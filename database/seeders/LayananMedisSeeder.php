<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananMedisSeeder extends Seeder
{
    public function run()
    {
        // Insert Penjamin Utama
        $penjaminUmumId = DB::table('medical_penjamin')->insertGetId(['nama_penjamin' => 'UMUM / PRIBADI']);

        // Insert Sub Penjamin
        $subUmum2026Id = DB::table('medical_sub_penjamin')->insertGetId([
            'penjamin_id' => $penjaminUmumId,
            'nama_sub_penjamin' => 'Pasien Umum 2026'
        ]);

        // Insert Master Tipe Layanan
        $tipeLabId = DB::table('medical_tipe_layanan')->insertGetId(['nama_tipe' => 'Laboratorium']);
        $tipeRadId = DB::table('medical_tipe_layanan')->insertGetId(['nama_tipe' => 'Radiologi']);
        $tipeIgdId = DB::table('medical_tipe_layanan')->insertGetId(['nama_tipe' => 'IGD / Tindakan Medis']);

        // Insert Dummy Pemeriksaan dengan Tipe Layanan
        DB::table('medical_pemeriksaan')->insert([
            [
                'sub_penjamin_id' => $subUmum2026Id,
                'tipe_layanan_id' => $tipeLabId,
                'kode_layanan' => 'LAB-01',
                'nama_layanan' => 'Hematologi Lengkap (CBC)',
                'harga' => 150000
            ],
            [
                'sub_penjamin_id' => $subUmum2026Id,
                'tipe_layanan_id' => $tipeRadId,
                'kode_layanan' => 'RAD-01',
                'nama_layanan' => 'Rontgen Thorax AP/PA',
                'harga' => 250000
            ],
            [
                'sub_penjamin_id' => $subUmum2026Id,
                'tipe_layanan_id' => $tipeIgdId,
                'kode_layanan' => 'IGD-01',
                'nama_layanan' => 'Jahit Luka (1-5 Jahitan)',
                'harga' => 120000
            ]
        ]);
    }
}
