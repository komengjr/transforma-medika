<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPatient extends Model
{
    protected $table = 'master_patient';
    protected $primaryKey = 'id_master_patient';

    public function orders()
    {
        return $this->hasMany(DRegOrder::class, 'd_reg_order_rm', 'master_patient_code');
    }
}
