<?php

namespace App\Imports;

use App\Models\HargaPenjualan;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataHargaPenjualan implements ToModel , WithHeadingRow
{
    public function __construct(string $code)
    {
        $this->code = $code;
    }
    public function model(array $row)
    {
        return new HargaPenjualan([
            'p_sales_data_code' => Str::uuid(),
            'p_sales_cat_code' => $this->code,
            'p_sales_data_name' => $row['nama_item'],
            'p_sales_data_type' => 'single',
            'p_sales_data_price' => $row['price_item'],
            'p_sales_data_disc' => $row['disc_item'],
            'p_sales_data_desc' => $row['desc_item'],
            'created_at' => now()
        ]);
    }
}
