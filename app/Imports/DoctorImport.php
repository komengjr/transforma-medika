<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Illuminate\Support\Facades\DB as FacadesDB;

class DoctorImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Lewati jika nama dokter kosong
            if (empty($row['nama_dokter'])) {
                continue;
            }

            // Normalisasi data Jenis Kelamin (misal: "Laki-laki" -> "L", "Perempuan" -> "P")
            $jk = strtoupper(trim($row['jenis_kelamin'] ?? 'L'));
            if (str_contains($jk, 'LAK')) {
                $jk = 'L';
            } elseif (str_contains($jk, 'PER')) {
                $jk = 'P';
            }

            // Insert / Update berdasarkan NIK Dokter
            DB::table('master_doctor')->updateOrInsert(
                ['master_doctor_nik' => (string) $row['nik_dokter']],
                [
                    'master_doctor_code'    => 'DOC-' . rand(10000, 99999), // Kode unik dokter
                    'master_doctor_title_f' => $row['gelar_depan'] ?? '',
                    'master_doctor_name'    => $row['nama_dokter'],
                    'master_doctor_title_e' => $row['gelar_belakang'] ?? '',
                    'master_doctor_jk'      => $jk,
                    'master_doctor_hp'      => $row['no_hp'] ?? '',
                    'master_doctor_email'   => $row['email'] ?? '',
                    'master_doctor_profile' => $row['profile'] ?? '',
                    'updated_at'            => now(),
                    'created_at'            => now(),
                ]
            );
        }
    }
}
