<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopTagihanBulan extends Model
{
    protected $table = 'kop_tagihan_bulan';
    protected $primaryKey = 'id_kop_tagihan_bulan';
    protected $fillable = ['kop_tagihan_bulan_status'];
}
