<?php

namespace App\Imports;

use App\Models\Peserta;
use DateTime;
use DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PesertaImport implements ToModel, WithHeadingRow
{
    public function __construct(string $code, $ids)
    {
        $this->ids = $ids;
        $this->code = $code;
    }
    public function model(array $row)
    {
        $UNIX_DATE = ($row['ttl'] - 25569) * 86400;
        return new Peserta([
            'mou_peserta_code' => $this->code . mt_rand(1000, 9999),
            'company_mou_code' => $this->code,
            'mou_peserta_nik' => $row['nik'],
            'mou_peserta_nip' => $row['nip'],
            'mou_peserta_name' => $row['name'],
            'mou_peserta_no_hp' => $row['no_hp'],
            'mou_peserta_email' => $row['email'],
            'mou_peserta_ttl' => date('Y-m-d', $UNIX_DATE),
            'mou_peserta_jk' => $row['jk'],
            'mou_peserta_departemen' => $row['departemen'],
            'mou_agreement_code' => $this->ids,
            'mou_peserta_status' => 0,
            'created_at' => now(),
        ]);
    }
}
