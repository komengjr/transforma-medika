<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinJurnalDetail extends Model
{
    protected $table = 'kop_fin_jurnal_detail';
    protected $primaryKey = 'id_jurnal_detail';
    protected $fillable = ['jurnal_id', 'coa_code', 'jurnal_debit', 'jurnal_kredit'];

    public function coa()
    {
        return $this->belongsTo(FinMasterCoa::class, 'coa_code', 'coa_code');
    }
}
