<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Agar baris pertama dianggap header

class MasterDoctorImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Ambil ID dokter terakhir untuk generate kode dokter (DR-00X)
        $lastDoctor = DB::table('medical_master_doctor')->orderBy('id', 'desc')->first();
        $nextId = $lastDoctor ? $lastDoctor->id : 0;

        foreach ($rows as $row) {
            // Pastikan baris memiliki data nama dokter (jangan proses baris kosong)
            if (!isset($row['nama_lengkap'])) {
                continue;
            }

            $nextId++;
            $kodeDokter = 'DR-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

            // Cek kode_spesialis berdasarkan nama spesialis yang ada di Excel
            $spesialis = DB::table('medical_master_spesialis')
                           ->where('nama_spesialis', 'like', '%' . $row['spesialisasi'] . '%')
                           ->first();
            $kodeSpesialis = $spesialis ? $spesialis->kode_spesialis : null;

            DB::table('medical_master_doctor')->insert([
                'kode_dokter'    => $kodeDokter,
                'nama_lengkap'   => $row['nama_lengkap'],
                'kode_spesialis' => $kodeSpesialis,
                'jenis_kelamin'  => isset($row['jenis_kelamin']) && in_array(strtoupper($row['jenis_kelamin']), ['L', 'P']) ? strtoupper($row['jenis_kelamin']) : 'L',
                'nik'            => $row['nik'] ?? null,
                'sip'            => $row['sip'] ?? null,
                'email'          => $row['email'] ?? null,
                'no_telp'        => $row['no_telp'] ?? null,
                'alamat'         => $row['alamat'] ?? null,
                'is_active'      => 1,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}
