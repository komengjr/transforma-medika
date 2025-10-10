<?php

namespace App\Imports;

use App\Models\master_item;
use DateTime;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemsImport implements ToModel, WithHeadingRow
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
        $total = DB::table('master_item')->count();
        // $data = DB::table('company_mou_peserta')->where('company_mou_code', $request->code)->first();
        // $UNIX_DATE = ($row['ttl'] - 25569) * 86400;
        return new master_item([
            'master_item_code' => 'ITEM' . str_pad($total + 1, 10, '0', STR_PAD_LEFT),
            'master_item_name' => $row['nama'],
            'master_item_type' => $this->ids,
            'master_item_class' => $this->code,
            'master_item_opt' => $row['opt'],
            'master_item_pic' => $row['file'],
            'master_item_barcode' => $row['barcode'],
            'master_item_status' => 1,
            'created_at' => now(),
        ]);
    }
}
