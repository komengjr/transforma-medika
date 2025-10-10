<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaPenjualan extends Model
{
    protected $table = 'p_sales_data';
    protected $fillable = [
        'id_p_sales_data',
        'p_sales_data_code',
        'p_sales_cat_code',
        'p_sales_data_name',
        'p_sales_data_type',
        'p_sales_data_price',
        'p_sales_data_disc',
        'p_sales_data_desc',
        'created_at',
    ];
}
