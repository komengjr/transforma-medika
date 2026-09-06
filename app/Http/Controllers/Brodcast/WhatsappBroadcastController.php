<?php

namespace App\Http\Controllers\Brodcast;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WhatsappBroadcastController extends Controller
{
    public function index()
    {
        return view('menu_brodcast_whatsapp'); // Sesuaikan dengan nama file Blade Anda
    }

    public function historyAjax(Request $request)
    {
        $query = DB::table('b_whatsapp_histories');

        // Fitur Search DataTables
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('recipient', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $totalData = DB::table('b_whatsapp_histories')->count();
        $totalFiltered = $query->count();

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);

        $histories = $query->offset($start)
            ->limit($limit)
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [];
        $no = $start + 1;

        foreach ($histories as $row) {
            $badgeStatus = $row->status == 'success'
                ? '<span class="badge bg-success">Terkirim</span>'
                : '<span class="badge bg-danger">Gagal</span>';

            $attachmentInfo = $row->attachment
                ? '<br><small class="text-muted"><i class="fas fa-paperclip me-1"></i>' . e($row->attachment) . '</small>'
                : '';

            $data[] = [
                'no'         => $no++,
                'recipient'  => e($row->recipient),
                'subject'    => e($row->subject) . $attachmentInfo,
                'status'     => $badgeStatus,
                'created_at' => date('d/m/Y H:i', strtotime($row->created_at)),
            ];
        }

        return response()->json([
            'draw'            => intval($request->input('draw')),
            'recordsTotal'    => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data'            => $data,
        ]);
    }

    /**
     * Search Async Kontak via Select2 dari b_master_contact
     */
    public function contactsAjax(Request $request)
    {
        $search = $request->input('term');

        // Menggunakan tabel b_master_contact
        $contacts = DB::table('b_master_contact')
            ->whereNotNull('b_master_contact_whatsapp')
            ->where('b_master_contact_whatsapp', '!=', '')
            ->when($search, function ($q) use ($search) {
                $q->where('b_master_contact_name', 'like', "%{$search}%")
                    ->orWhere('b_master_contact_whatsapp', 'like', "%{$search}%")
                    ->orWhere('b_master_contact_code', 'like', "%{$search}%");
            })
            ->select('id_b_master_contact', 'b_master_contact_name', 'b_master_contact_whatsapp')
            ->limit(20)
            ->get();

        $results = $contacts->map(function ($contact) {
            return [
                'id'   => $contact->id_b_master_contact,
                'text' => $contact->b_master_contact_name . ' (' . $contact->b_master_contact_whatsapp . ')'
            ];
        });

        return response()->json(['results' => $results]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject'    => 'required|string|max:255',
            'message'    => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:10240',
        ]);

        $selectAll = $request->input('select_all') == '1';
        $contactIds = $request->input('contact_ids', []);

        // Ambil Daftar Kontak Target dari b_master_contact
        if ($selectAll) {
            $recipients = DB::table('b_master_contact')
                ->whereNotNull('b_master_contact_whatsapp')
                ->where('b_master_contact_whatsapp', '!=', '')
                ->pluck('b_master_contact_whatsapp', 'id_b_master_contact')
                ->toArray();
        } else {
            if (empty($contactIds)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Pilih minimal satu kontak atau aktifkan fitur Kirim ke Semua!'
                ], 422);
            }
            $recipients = DB::table('b_master_contact')
                ->whereIn('id_b_master_contact', $contactIds)
                ->pluck('b_master_contact_whatsapp', 'id_b_master_contact')
                ->toArray();
        }

        $totalCount = count($recipients);

        if ($totalCount === 0) {
            return response()->json([
                'status'  => false,
                'message' => 'Tidak ada kontak aktif dengan nomor WhatsApp yang ditemukan.'
            ], 422);
        }

        // URL Server WhatsApp Node.js Anda (Ganti dengan URL Server WA Anda / env)
        $nodeServerUrl = env('WA_NODE_SERVER_URL', 'http://localhost:3000/send-message');
        $userId = Auth::user()->userid ?? Auth::id();

        // Handle File Attachment jika ada
        $attachmentName = null;
        $attachmentPath = null;
        $fileContent = null;

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $attachmentName = time() . '_' . $file->getClientOriginalName();
            $attachmentPath = $file->storeAs('public/whatsapp_attachments', $attachmentName);
            $fileContent = file_get_contents($file->getRealPath());
        }

        // Generasi Batch ID unik untuk tracking progress
        $batchId = (string) Str::uuid();

        // Simpan State Progress Awal di Cache
        Cache::put("wa_batch_{$batchId}", [
            'total'      => $totalCount,
            'processed'  => 0,
            'percentage' => 0,
            'status'     => 'processing',
        ], now()->addHours(2));

        // Iterasi Pengiriman Pesan
        $processed = 0;
        foreach ($recipients as $contactId => $phone) {
            $status = 'failed';
            $errorMessage = null;

            try {
                // Format Pesan (Gabungkan Subject dan Message jika diperlukan)
                $formattedMessage = "*" . $request->subject . "*\n\n" . $request->message;

                // Kirim via Http Client Laravel ke Node.js WA Server
                if ($fileContent && $attachmentName) {
                    // Pengiriman DENGAN Lampiran
                    $response = Http::attach(
                        'attachment',
                        $fileContent,
                        $attachmentName
                    )->post($nodeServerUrl, [
                        'userId'  => $userId,
                        'number'  => $phone,
                        'message' => $formattedMessage,
                    ]);
                } else {
                    // Pengiriman TANPA Lampiran
                    $response = Http::post($nodeServerUrl, [
                        'userId'  => $userId,
                        'number'  => $phone,
                        'message' => $formattedMessage,
                    ]);
                }

                if ($response->successful()) {
                    $status = 'success';
                } else {
                    $errorMessage = $response->body() ?: 'HTTP Error Code: ' . $response->status();
                }
            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();
            }

            // Simpan Log Pengiriman ke b_whatsapp_histories
            DB::table('b_whatsapp_histories')->insert([
                'batch_id'      => $batchId,
                'recipient'     => $phone,
                'subject'       => $request->subject,
                'message'       => $request->message,
                'attachment'    => $attachmentName,
                'status'        => $status,
                'error_message' => $errorMessage,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            $processed++;
            $percentage = round(($processed / $totalCount) * 100);

            // Update Status Progress di Cache
            Cache::put("wa_batch_{$batchId}", [
                'total'      => $totalCount,
                'processed'  => $processed,
                'percentage' => $percentage,
                'status'     => ($processed >= $totalCount) ? 'completed' : 'processing',
            ], now()->addHours(2));
        }

        return response()->json([
            'status'   => true,
            'batch_id' => $batchId,
            'total'    => $totalCount,
            'message'  => 'Proses broadcast WhatsApp berhasil dijalankan.'
        ]);
    }

    /**
     * Endpoint Polling Real-time Progress Bar
     */
    public function progress($batchId)
    {
        $progress = Cache::get("wa_batch_{$batchId}", [
            'total'      => 0,
            'processed'  => 0,
            'percentage' => 100,
            'status'     => 'completed'
        ]);

        return response()->json($progress);
    }
}
