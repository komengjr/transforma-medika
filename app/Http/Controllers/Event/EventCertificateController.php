<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EventCertificateController extends Controller
{
    /**
     * Tampilan utama menu E-Sertifikat
     */
    public function builder()
    {
        $config = $this->getCertificateConfig();
        return view('app-event.menu-event.builder', compact('config'));
    }

    /**
     * Memproses upload file background template sertifikat (JPG/PNG)
     */
    public function uploadTemplate(Request $request)
    {
        $request->validate([
            'template_image'      => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            'signer_mode'         => 'required|in:1,2',

            // Posisi & Ukuran Nama Peserta
            'pos_name_top'        => 'required|numeric',
            'font_name_size'      => 'required|numeric',
            'align_name'          => 'required|string',

            // Posisi & Ukuran Event Utama
            'pos_event_top'       => 'required|numeric',
            'font_event_size'     => 'required|numeric',
            'align_event'         => 'required|string',

            // Posisi & Ukuran Sub Event
            'pos_sub_event_top'   => 'required|numeric',
            'font_sub_event_size' => 'required|numeric',
            'align_sub_event'     => 'required|string',

            // Pengesah 1
            'signer1_name'        => 'nullable|string',
            'signer1_title'       => 'nullable|string',
            'pos_signer1_left'    => 'required|numeric',
            'pos_signer1_top'     => 'required|numeric',
            'font_signer1_size'   => 'required|numeric',

            // Pengesah 2
            'signer2_name'        => 'nullable|string',
            'signer2_title'       => 'nullable|string',
            'pos_signer2_left'    => 'required|numeric',
            'pos_signer2_top'     => 'required|numeric',
            'font_signer2_size'   => 'required|numeric',

            'qr_signer1_size' => 'required|numeric',
            'qr_signer2_size' => 'required|numeric',
        ]);

        // Handle upload gambar jika ada background baru yang diunggah
        if ($request->hasFile('template_image')) {
            $file = $request->file('template_image');
            $file->storeAs('public/certificate_templates', 'background.jpg');
        }

        // Ambil seluruh input konfigurasi
        $configData = [
            'signer_mode'         => $request->input('signer_mode', '1'),

            'pos_name_top'        => $request->input('pos_name_top', 75),
            'font_name_size'      => $request->input('font_name_size', 26),
            'align_name'          => $request->input('align_name', 'center'),

            'pos_event_top'       => $request->input('pos_event_top', 105),
            'font_event_size'     => $request->input('font_event_size', 20),
            'align_event'         => $request->input('align_event', 'center'),

            'pos_sub_event_top'   => $request->input('pos_sub_event_top', 125),
            'font_sub_event_size' => $request->input('font_sub_event_size', 13),
            'align_sub_event'     => $request->input('align_sub_event', 'center'),

            // Pengesah 1 (Koordinat Left X, Top Y, Font & QR Size)
            'signer1_name'        => $request->input('signer1_name'),
            'signer1_title'       => $request->input('signer1_title'),
            'pos_signer1_left'    => $request->input('pos_signer1_left', 180),
            'pos_signer1_top'     => $request->input('pos_signer1_top', 160),
            'font_signer1_size'   => $request->input('font_signer1_size', 12),
            'qr_signer1_size'     => $request->input('qr_signer1_size', 60),

            // Pengesah 2 (Koordinat Left X, Top Y, Font & QR Size)
            'signer2_name'        => $request->input('signer2_name'),
            'signer2_title'       => $request->input('signer2_title'),
            'pos_signer2_left'    => $request->input('pos_signer2_left', 30),
            'pos_signer2_top'     => $request->input('pos_signer2_top', 160),
            'font_signer2_size'   => $request->input('font_signer2_size', 12),
            'qr_signer2_size'     => $request->input('qr_signer2_size', 60),
        ];

        // Simpan ke file JSON
        $jsonPath = storage_path('app/public/certificate_templates/config.json');

        // Pastikan direktori ada
        if (!file_exists(dirname($jsonPath))) {
            mkdir(dirname($jsonPath), 0755, true);
        }

        file_put_contents($jsonPath, json_encode($configData, JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'Konfigurasi tata letak sertifikat berhasil disimpan.');
    }
    public function index()
    {
        // Mengambil daftar event utama
        $events = DB::table('event_datas')
            ->select('event_data_code', 'event_data_tittle')
            ->whereNull('deleted_at')
            ->get();

        return view('admin.events.e_certificate', compact('events'));
    }

    public function printSingle($regCode)
    {
        $participant = DB::table('event_registrations as er')
            ->join('event_participants as ep', 'er.id_participant', '=', 'ep.id_participant')
            ->join('event_data as ed', 'er.id_event_data', '=', 'ed.id_event_data')
            ->select(
                'er.id_registration',
                'er.registration_code',
                'er.registration_date',
                'ep.full_name',
                'ep.email',
                'ep.institution',
                'ed.event_data_tittle'
            )
            ->where('er.registration_code', $regCode)
            ->where('er.payment_status', 'paid')
            ->first();

        if (!$participant) {
            abort(404, 'Data pendaftaran tidak ditemukan atau belum lunas.');
        }

        $participantClasses = DB::table('event_registration_classes as erc')
            ->join('event_data_sub_class as edsc', 'erc.id_event_data_sub_class', '=', 'edsc.id_event_data_sub_class')
            ->join('event_data_sub as eds', 'edsc.event_data_sub_code', '=', 'eds.event_data_sub_code')
            ->select('eds.event_data_sub_name', 'edsc.event_data_sub_class_name', 'erc.check_in_at')
            ->where('erc.id_registration', $participant->id_registration)
            ->get();

        $config = $this->getCertificateConfig();

        // Generate PDF Sertifikat Landscape
        $pdf = PDF::loadView('app-event.menu-event.pdf.certificate_template', compact('participant', 'participantClasses', 'config'))
            ->setPaper('A4', 'landscape');

        return $pdf->stream('Sertifikat-' . $participant->registration_code . '.pdf');
    }

    /**
     * Bulk Print PDF Massal
     */
    public function bulkPrint(Request $request)
    {
        $subCode = $request->get('sub_code');
        $classId = $request->get('class_id');

        $query = DB::table('event_registration_classes as erc')
            ->join('event_registrations as er', 'erc.id_registration', '=', 'er.id_registration')
            ->join('event_participants as ep', 'er.id_participant', '=', 'ep.id_participant')
            ->join('event_data_sub_class as edsc', 'erc.id_event_data_sub_class', '=', 'edsc.id_event_data_sub_class')
            ->select(
                'er.registration_code',
                'ep.full_name',
                'ep.institution',
                'edsc.event_data_sub_class_name',
                'erc.check_in_at'
            )
            ->where('er.payment_status', 'paid')
            ->where('erc.attendance_status', 'present'); // Hanya yang hadir

        if ($subCode) {
            $query->where('edsc.event_data_sub_code', $subCode);
        }

        if ($classId && $classId !== 'ALL') {
            $query->where('erc.id_event_data_sub_class', $classId);
        }

        $participants = $query->get();

        if ($participants->isEmpty()) {
            return response('Tidak ada data peserta eligible (Hadir) untuk dicetak.', 404);
        }

        $pdf = PDF::loadView('pdf.certificate_bulk_template', compact('participants'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('Sertifikat-Massal.pdf');
    }

    /**
     * API Kirim Email Sertifikat (Sesuai Konfirmasi SweetAlert2)
     */
    public function sendEmail($regCode)
    {
        try {
            // Ambil data registrasi & peserta
            $participant = DB::table('event_registrations as er')
                ->join('event_participants as ep', 'er.id_participant', '=', 'ep.id_participant')
                ->join('event_data as ed', 'er.id_event_data', '=', 'ed.id_event_data')
                ->select(
                    'er.id_registration',
                    'er.registration_code',
                    'ep.full_name',
                    'ep.email',
                    'ed.event_data_tittle'
                )
                ->where('er.registration_code', $regCode)
                ->first();

            if (!$participant) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data registrasi tidak ditemukan.'
                ], 404);
            }

            if (empty($participant->email)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Peserta tidak memiliki alamat email.'
                ], 422);
            }

            $participantClasses = DB::table('event_registration_classes as erc')
                ->join('event_data_sub_class as edsc', 'erc.id_event_data_sub_class', '=', 'edsc.id_event_data_sub_class')
                ->join('event_data_sub as eds', 'edsc.event_data_sub_code', '=', 'eds.event_data_sub_code')
                ->select('eds.event_data_sub_name', 'edsc.event_data_sub_class_name')
                ->where('erc.id_registration', $participant->id_registration)
                ->get();

            // Load Konfigurasi Sertifikat (Memastikan Pengesah 1 & 2 ikut terisi)
            $config = $this->getCertificateConfig();

            // 1. Render PDF di Memory dengan menyertakan $config
            $pdf = PDF::loadView('app-event.menu-event.pdf.certificate_template', compact('participant', 'participantClasses', 'config'))
                ->setPaper('a4', 'landscape');

            // 2. Kirim Email Lampiran PDF
            Mail::send('emails.certificate_notification', ['participant' => $participant], function ($message) use ($participant, $pdf) {
                $message->to($participant->email, $participant->full_name)
                    ->subject('E-Sertifikat - ' . $participant->event_data_tittle)
                    ->attachData($pdf->output(), "Sertifikat-{$participant->registration_code}.pdf", [
                        'mime' => 'application/pdf',
                    ]);
            });

            // Update timestamp kirim email di event_registrations
            DB::table('event_registrations')
                ->where('id_registration', $participant->id_registration)
                ->update(['email_sent_at' => now()]);

            return response()->json([
                'status' => 'success',
                'message' => 'E-Sertifikat berhasil dikirim ke ' . $participant->email
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengirim email: ' . $e->getMessage()
            ], 500);
        }
    }
    private function getCertificateConfig()
    {
        $jsonPath = storage_path('app/public/certificate_templates/config.json');

        // Default nilai jika file config.json belum tersedia
        $defaultConfig = [
            'signer_mode'         => '1',

            'pos_name_top'        => 75,
            'font_name_size'      => 26,
            'align_name'          => 'center',

            'pos_event_top'       => 105,
            'font_event_size'     => 20,
            'align_event'         => 'center',

            'pos_sub_event_top'   => 125,
            'font_sub_event_size' => 13,
            'align_sub_event'     => 'center',

            'signer1_name'        => 'Dr. John Doe, M.Pd',
            'signer1_title'       => 'Ketua Panitia Pelaksana',
            'pos_signer1_left'    => 180,
            'pos_signer1_top'     => 160,
            'font_signer1_size'   => 12,

            'signer2_name'        => 'Prof. Jane Smith, Ph.D',
            'signer2_title'       => 'Ketua Umum Organisasi',
            'pos_signer2_left'    => 30,
            'pos_signer2_top'     => 160,
            'font_signer2_size'   => 12,

            'qr_signer1_size' => 60,
            'qr_signer2_size' => 60,
        ];

        if (file_exists($jsonPath)) {
            $jsonContent = file_get_contents($jsonPath);
            $savedConfig = json_decode($jsonContent, true);

            if (is_array($savedConfig)) {
                // Gabungkan data tersimpan dengan default (menjaga kunci baru tetap ada jika file JSON lama)
                return array_merge($defaultConfig, $savedConfig);
            }
        }

        return $defaultConfig;
    }
}
