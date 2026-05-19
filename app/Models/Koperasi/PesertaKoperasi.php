<?php

namespace App\Models\Koperasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaKoperasi extends Model
{
    protected $table = 'kop_master_peserta';
    protected $fillable = [
        'id_kop_master_peserta',
        'kop_master_peserta_code',
        'kop_master_peserta_nik',
        'kop_master_peserta_nip',
        'kop_master_peserta_name',
        'kop_master_peserta_tgl_lahir',
        'kop_master_peserta_tempat_lahir',
        'kop_master_peserta_jk',
        'kop_master_peserta_agama',
        'kop_master_peserta_alamat',
        'kop_master_peserta_cabang',
        'kop_master_peserta_email',
        'kop_master_peserta_no_hp',
        'kop_master_peserta_tgl_kerja',
        'kop_master_peserta_tgl_anggota',
        'kop_master_peserta_photo',
        'kop_master_peserta_status',
        'created_at',
    ];
}
