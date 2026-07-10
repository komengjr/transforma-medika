<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DRegOrderLabList extends Model
{
    protected $table = 'd_reg_order_lab_list';
    protected $primaryKey = 'id_d_reg_order_lab_list';

    public function salesData()
    {
        return $this->belongsTo(PSalesData::class, 'p_sales_data_code', 'p_sales_data_code');
    }
}
