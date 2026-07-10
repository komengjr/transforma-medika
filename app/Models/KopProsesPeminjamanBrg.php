<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopProsesPeminjamanBrg extends Model
{
    protected $table = 'kop_proses_peminjaman_brg';
    protected $primaryKey = 'id_kop_proses_brg';
    protected $fillable = ['kop_proses_brg_status', 'kop_proses_brg_tgl'];
}
