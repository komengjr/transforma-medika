<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopTransaksiArisan extends Model
{
    use HasFactory;

    protected $table = 'kop_transaksi_arisan';
    protected $primaryKey = 'id_kop_transaksi_arisan';

    protected $fillable = [
        'id_kop_master_arisan',
        'id_kop_master_peserta',
        'kop_transaksi_bulan',
        'kop_transaksi_tahun',
        'kop_transaksi_total_poin',
        'kop_transaksi_nominal',
        'kop_transaksi_metode',
        'kop_transaksi_status',
        'kop_transaksi_keterangan',
    ];
}
