<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DRegOrderList extends Model
{
    protected $table = 'd_reg_order_list';
    protected $primaryKey = 'id_d_reg_order_list';

    public function laboratoriums()
    {
        return $this->hasMany(DRegOrderLabList::class, 'd_reg_order_lab_code', 'd_reg_order_list_code');
    }

    public function radiologis()
    {
        return $this->hasMany(DRegOrderRadList::class, 'd_reg_order_rad_code', 'd_reg_order_list_code');
    }
    public function poliklinik()
    {
        return $this->hasMany(DRegOrderPoliList::class, 'd_reg_order_poli_code', 'd_reg_order_list_code');
    }
}
