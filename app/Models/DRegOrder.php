<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DRegOrder extends Model
{
    protected $table = 'd_reg_order';
    protected $primaryKey = 'id_d_reg_order';

    public function pasien()
    {
        return $this->belongsTo(MasterPatient::class, 'd_reg_order_rm', 'master_patient_code');
    }

    public function orderLists()
    {
        return $this->hasMany(DRegOrderList::class, 'd_reg_order_code', 'd_reg_order_code');
    }
}
