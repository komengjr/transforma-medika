<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopProsesPeminjamanUang extends Model
{
    protected $table = 'kop_proses_peminjaman_uang';
    protected $primaryKey = 'id_kop_proses_uang';
    protected $fillable = ['kop_proses_uang_status', 'kop_proses_uang_tgl'];
}
