<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinJurnal extends Model
{
    protected $table = 'kop_fin_jurnal';
    protected $primaryKey = 'id_jurnal';
    protected $fillable = [
        'jurnal_no_bukti',
        'jurnal_tgl',
        'jurnal_keterangan',
        'jurnal_ref_table',
        'jurnal_ref_code',
        'jurnal_user'
    ];

    public function details()
    {
        return $this->hasMany(FinJurnalDetail::class, 'jurnal_id', 'id_jurnal');
    }
}
