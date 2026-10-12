<?php

namespace App\Imports;

use App\Models\BrainTest\BrainTestSoal;
use App\Models\BrainTest\BrainTestOpsiJawaban;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BrainTestSoalImport implements ToModel, WithHeadingRow
{
    protected $kategoriId;

    public function __construct($kategoriId)
    {
        $this->kategoriId = $kategoriId;
    }

    public function model(array $row)
    {
        // Normalisasi key array agar aman dari spasi atau huruf besar/kecil
        $row = array_change_key_case($row, CASE_LOWER);

        $pertanyaan = $row['pertanyaan'] ?? $row['soal'] ?? null;
        if (empty($pertanyaan)) {
            return null;
        }

        // 1. Simpan Soal
        $soal = BrainTestSoal::create([
            'kategori_id' => $this->kategoriId,
            'pertanyaan'  => $pertanyaan,
            'tipe_soal'   => 'pilihan_ganda',
            'bobot_nilai' => 1,
        ]);

        $options = [
            'A' => $row['opsi_a'] ?? $row['pilihan_a'] ?? null,
            'B' => $row['opsi_b'] ?? $row['pilihan_b'] ?? null,
            'C' => $row['opsi_c'] ?? $row['pilihan_c'] ?? null,
            'D' => $row['opsi_d'] ?? $row['pilihan_d'] ?? null,
            'E' => $row['opsi_e'] ?? $row['pilihan_e'] ?? null,
        ];

        $kunci = strtoupper(trim($row['kunci_jawaban'] ?? $row['kunci'] ?? 'A'));

        // 2. Simpan Opsi Jawaban
        foreach ($options as $key => $teks) {
            if (!empty($teks)) {
                $isBenar = ($key === $kunci);

                BrainTestOpsiJawaban::create([
                    'soal_id'      => $soal->id,
                    'teks_jawaban' => $teks,
                    'is_benar'     => $isBenar,
                    'poin'         => $isBenar ? 5 : 0,
                ]);
            }
        }

        return $soal;
    }
}
