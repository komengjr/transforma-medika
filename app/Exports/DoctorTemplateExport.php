<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DoctorTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'nik_dokter',
            'gelar_depan',
            'nama_dokter',
            'gelar_belakang',
            'jenis_kelamin', // 'L' atau 'P'
            'no_hp',
            'email',
            'profile'
        ];
    }

    public function array(): array
    {
        return [
            [
                '3171012345670001',
                'dr.',
                'Ahmad Subagyo',
                'Sp.PD',
                'L',
                '081234567890',
                'ahmad@gmail.com',
                'Dokter Spesialis Penyakit Dalam'
            ],
            [
                '3171012345670002',
                'drg.',
                'Siti Nurhaliza',
                'Sp.KG',
                'P',
                '081987654321',
                'siti@gmail.com',
                'Dokter Spesialis Konservasi Gigi'
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
