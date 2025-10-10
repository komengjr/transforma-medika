<?php

namespace App\Imports;

use App\Models\Peserta;
use DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PesertaAllImport implements ToModel, WithHeadingRow
{
    public function __construct(string $code)
    {
        $this->code = $code;
    }
    public function model(array $row)
    {
        $data = DB::table('company_mou_agreement')->where('company_mou_code', $this->code)
            ->where('mou_agreement_name', $row['paket'])->first();
        if ($data) {
            $paket = $data->mou_agreement_code;
        } else {
            $paket = '';
        }
        $UNIX_DATE = ($row['ttl'] - 25569) * 86400;
        return new Peserta([
            'mou_peserta_code' => $this->code . mt_rand(10000, 99999),
            'company_mou_code' => $this->code,
            'mou_peserta_nik' => $row['nik'],
            'mou_peserta_nip' => $row['nip'],
            'mou_peserta_name' => $row['name'],
            'mou_peserta_no_hp' => $row['no_hp'],
            'mou_peserta_email' => $row['email'],
            'mou_peserta_ttl' => date('Y-m-d',$UNIX_DATE),
            'mou_peserta_jk' => $row['jk'],
            'mou_peserta_departemen' => $row['departemen'],
            'mou_agreement_code' => $paket,
            'mou_peserta_status' => 0,
            'created_at' => now(),
        ]);
    }
}
