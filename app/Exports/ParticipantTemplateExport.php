<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParticipantTemplateExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    // Data contoh/dummy di dalam template
    public function collection()
    {
        return collect([
            [
                'full_name'       => 'Budi Santoso',
                'email'           => 'budi@example.com',
                'phone_number'    => '081234567890',
                'gender'          => 'L',
                'identity_number' => '3171012345670001',
                'institution'     => 'PT Maju Bersama',
                'address'         => 'Jl. Sudirman No. 12',
            ],
            [
                'full_name'       => 'Siti Aminah',
                'email'           => 'siti@example.com',
                'phone_number'    => '089876543210',
                'gender'          => 'P',
                'identity_number' => '3171012345670002',
                'institution'     => 'Universitas Nusantara',
                'address'         => 'Jl. Gajah Mada No. 45',
            ]
        ]);
    }

    // Header Kolom Excel
    public function headings(): array
    {
        return [
            'full_name',
            'email',
            'phone_number',
            'gender',
            'identity_number',
            'institution',
            'address',
        ];
    }

    // Styling Header (Bikin Bold & Highlight Warna)
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1F4E79']
                ]
            ],
        ];
    }
}
