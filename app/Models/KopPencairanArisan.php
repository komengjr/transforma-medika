<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopPencairanArisan extends Model
{
    use HasFactory;

    protected $table = 'kop_pencairan_arisan';
    protected $primaryKey = 'id_kop_pencairan_arisan';

    protected $fillable = [
        'id_kop_master_arisan',
        'id_kop_master_peserta',
        'kop_pencairan_bulan',
        'kop_pencairan_tahun',
        'kop_pencairan_nominal',
        'kop_pencairan_tanggal',
        'kop_pencairan_status',
        'kop_pencairan_keterangan',
    ];
}
