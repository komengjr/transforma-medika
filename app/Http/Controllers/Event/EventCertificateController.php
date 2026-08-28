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
            'template_image'      => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'signer_mode'         => 'required|in:1,2',
            'pos_name_top'        => 'required|numeric',
            'font_name_size'      => 'required|numeric',
            'align_name'          => 'required|in:left,center,right',
            'pos_event_top'       => 'required|numeric',
            'font_event_size'     => 'required|numeric',
            'align_event'         => 'required|in:left,center,right',
            'pos_sub_event_top'   => 'required|numeric',
            'font_sub_event_size' => 'required|numeric',
            'align_sub_event'     => 'required|in:left,center,right',
        ]);

        if ($request->hasFile('template_image')) {
            $request->file('template_image')->storeAs('public/certificate_templates', 'background.jpg');
        }

        // Ambil data konfigurasi lengkap
        $configData = [
            'signer_mode'        => $request->signer_mode,

            // Peserta
            'pos_name_top'       => $request->pos_name_top,
            'font_name_size'     => $request->font_name_size,
            'align_name'         => $request->align_name,

            // Event Utama
            'pos_event_top'      => $request->pos_event_top,
            'font_event_size'    => $request->font_event_size,
            'align_event'        => $request->align_event,

            // Sub Event & Class
            'pos_sub_event_top'  => $request->pos_sub_event_top,
            'font_sub_event_size' => $request->font_sub_event_size,
            'align_sub_event'    => $request->align_sub_event,

            // Pengesah 1 (Kanan)
            'signer1_name'       => $request->signer1_name ?? 'Dr. John Doe, M.Pd',
            'signer1_title'      => $request->signer1_title ?? 'Ketua Panitia Pelaksana',
            'pos_signer1_top'    => $request->pos_signer1_top ?? 160,
            'font_signer1_size'  => $request->font_signer1_size ?? 12,
            'align_signer1'      => $request->align_signer1 ?? 'right',

            // Pengesah 2 (Kiri - Pastikan Data Tersimpan)
            'signer2_name'       => $request->signer2_name ?? 'Prof. Jane Smith, Ph.D',
            'signer2_title'      => $request->signer2_title ?? 'Ketua Umum Organisasi',
            'pos_signer2_top'    => $request->pos_signer2_top ?? 160,
            'font_signer2_size'  => $request->font_signer2_size ?? 12,
            'align_signer2'      => $request->align_signer2 ?? 'left',
        ];

        Storage::put('public/certificate_templates/config.json', json_encode($configData));

        return redirect()->back()->with('success', 'Konfigurasi sertifikat berhasil diperbarui!');
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
        if (Storage::exists('public/certificate_templates/config.json')) {
            return json_decode(Storage::get('public/certificate_templates/config.json'), true);
        }

        return [
            'signer_mode'        => '2',
            'pos_name_top'       => 75,
            'font_name_size'     => 26,
            'align_name'         => 'center',
            'pos_event_top'      => 105,
            'font_event_size'    => 20,
            'align_event'        => 'center',
            'pos_sub_event_top'  => 125,
            'font_sub_event_size' => 13,
            'align_sub_event'    => 'center',
            'signer1_name'       => 'Dr. John Doe, M.Pd',
            'signer1_title'      => 'Ketua Panitia Pelaksana',
            'pos_signer1_top'    => 160,
            'font_signer1_size'  => 12,
            'align_signer1'      => 'right',
            'signer2_name'       => 'Prof. Jane Smith, Ph.D',
            'signer2_title'      => 'Ketua Umum Organisasi',
            'pos_signer2_top'    => 160,
            'font_signer2_size'  => 12,
            'align_signer2'      => 'left',
        ];
    }
}
