<?php

namespace App\Imports;

use App\Models\log_m_product;
use DateTime;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel , WithHeadingRow
{
    private $ids;
    private $code;
    public function __construct(string $code, $ids)
    {
        $this->ids = $ids;
        $this->code = $code;
    }
    public function model(array $row)
    {
        $total = FacadesDB::table('log_m_product')->count();
        // $data = DB::table('company_mou_peserta')->where('company_mou_code', $request->code)->first();
        // $UNIX_DATE = ($row['ttl'] - 25569) * 86400;
        return new log_m_product([
            'log_m_product_code' => 'PRO' . str_pad($total + 1, 10, '0', STR_PAD_LEFT),
            'log_m_product_name' => $row['nama'],
            'log_m_class_code' => $row['class'],
            'log_m_type_code' => $this->code,
            'log_m_product_status' => $row['status'],
            'log_m_product_qr' => $row['qr'],
            'log_m_product_file' => $row['file'],
            'created_at' => now(),
        ]);
    }
}
