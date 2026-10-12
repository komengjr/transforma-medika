<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BrainTestSoalTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function array(): array
    {
        return [
            [
                'Apa ibu kota negara Indonesia?',
                'Jakarta',
                'Bandung',
                'Surabaya',
                'Medan',
                'A'
            ],
            [
                'Berapakah hasil dari 5 + 5 x 2?',
                '20',
                '15',
                '10',
                '25',
                'B'
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'pertanyaan',
            'opsi_a',
            'opsi_b',
            'opsi_c',
            'opsi_d',
            'kunci_jawaban'
        ];
    }
}
