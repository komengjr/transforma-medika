<?php

namespace App\Models\Koperasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'kop_req_tagihan';
    protected $primaryKey = 'id_kop_req_tagihan';

    protected $fillable = [
        'kop_req_tagihan_code',
        'kop_req_tagihan_date',
        'kop_req_tagihan_type',
        'kop_req_tagihan_id',
        'kop_req_tagihan_nominal',
        'kop_req_tagihan_status'
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'kop_req_tagihan_id', 'kop_master_peserta_code');
    }
}
