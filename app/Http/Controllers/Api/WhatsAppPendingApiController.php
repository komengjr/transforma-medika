<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WhatsAppPendingApiController extends Controller
{
    /**
     * Mengambil daftar pesan dengan status 'pending'
     */
    public function getPendingMessages(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);
            $batchId = $request->input('batch_id');

            $query = DB::table('b_whatsapp_histories')
                ->where('status', 'pending');

            if ($batchId) {
                $query->where('batch_id', $batchId);
            }

            $data = $query->orderBy('created_at', 'asc')
                ->limit($limit)
                ->get();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data pending berhasil ditemukan',
                'total'   => $data->count(),
                'data'    => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST: /api/wa-gateway/wa/pending/fetch-and-lock
     * Mengambil data pending sekaligus mengunci statusnya menjadi 'processing'
     */
    public function fetchAndLockPending(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);

            // 1. Ambil ID antrean pending
            $pendingIds = DB::table('b_whatsapp_histories')
                ->where('status', 'pending')
                ->orderBy('created_at', 'asc')
                ->limit($limit)
                ->pluck('id');

            if ($pendingIds->isEmpty()) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Tidak ada antrean pending',
                    'total'   => 0,
                    'data'    => []
                ], 200);
            }

            // 2. Kunci status menjadi 'processing'
            DB::table('b_whatsapp_histories')
                ->whereIn('id', $pendingIds)
                ->update([
                    'status'     => 'processing',
                    'updated_at' => now()
                ]);

            // 3. Ambil data histori
            $data = DB::table('b_whatsapp_histories')
                ->whereIn('id', $pendingIds)
                ->get();

            // 4. Attach base64 & mimetype file dari Storage jika ada lampiran
            $formattedData = $data->map(function ($row) {
                $base64   = null;
                $mimeType = null;

                if ($row->attachment) {
                    $filePath = storage_path('app/public/whatsapp_attachments/' . $row->attachment);

                    if (file_exists($filePath)) {
                        $base64   = base64_encode(file_get_contents($filePath));
                        $mimeType = mime_content_type($filePath);
                    }
                }

                return [
                    'id'                  => $row->id,
                    'batch_id'            => $row->batch_id,
                    'recipient'           => $row->recipient,
                    'subject'             => $row->subject,
                    'message'             => "*" . $row->subject . "*\n\n" . $row->message,
                    'attachment'          => $row->attachment,
                    'attachment_base64'   => $base64,
                    'attachment_mimetype' => $mimeType,
                    'status'              => $row->status,
                    'created_at'          => $row->created_at,
                ];
            });

            return response()->json([
                'status'  => 'success',
                'message' => 'Data antrean berhasil dikunci ke processing',
                'total'   => $formattedData->count(),
                'data'    => $formattedData
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST: /api/wa-gateway/wa/update-status
     * Mengupdate status laporan dari Node.js (success/failed)
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id'            => 'required',
            'status'        => 'required|in:success,failed',
            'error_message' => 'nullable'
        ]);

        try {
            $updated = DB::table('b_whatsapp_histories')
                ->where('id', $request->id)
                ->update([
                    'status'        => $request->status,
                    'error_message' => $request->error_message ?? null,
                    'updated_at'    => now()
                ]);

            if ($updated) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Status berhasil diperbarui'
                ], 200);
            }

            return response()->json([
                'status'  => 'error',
                'message' => 'Data histori tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal update status: ' . $e->getMessage()
            ], 500);
        }
    }
}
