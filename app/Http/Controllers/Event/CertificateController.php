<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CertificateController extends Controller
{
    public function verify($code)
    {
        // Cari data peserta & event utama langsung menggunakan DB Query Builder
        $participant = DB::table('event_registrations as er')
            ->join('event_participants as ep', 'er.id_participant', '=', 'ep.id_participant')
            ->join('event_data as ed', 'er.id_event_data', '=', 'ed.id_event_data')
            ->select(
                'er.id_registration',
                'er.registration_code',
                'er.created_at as registration_date',
                'ep.full_name',
                'ep.email',
                'ed.event_data_tittle'
            )
            ->where('er.registration_code', $code)
            ->first();

        // Jika data tidak ditemukan
        if (!$participant) {
            return view('certificate.verify_failed', [
                'code' => $code,
                'message' => 'Sertifikat tidak ditemukan atau kode verifikasi tidak valid.'
            ]);
        }

        // Ambil data sub event & class milik peserta
        $participantClasses = DB::table('event_registration_classes as erc')
            ->join('event_data_sub_class as edsc', 'erc.id_event_data_sub_class', '=', 'edsc.id_event_data_sub_class')
            ->join('event_data_sub as eds', 'edsc.event_data_sub_code', '=', 'eds.event_data_sub_code')
            ->select('eds.event_data_sub_name', 'edsc.event_data_sub_class_name')
            ->where('erc.id_registration', $participant->id_registration)
            ->get();

        // Ambil konfigurasi sertifikat
        $config = $this->getCertificateConfig();

        // Tampilkan halaman verifikasi sukses
        return view('certificate.verify_success', [
            'participant'        => $participant,
            'participantClasses' => $participantClasses,
            'config'             => $config,
            'status'             => 'VALID',
            'verified_at'        => now()->translatedFormat('d F Y H:i'),
        ]);
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
