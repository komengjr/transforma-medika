<?php

namespace App\Models\Koperasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'kop_master_peserta';
    protected $primaryKey = 'kop_master_peserta_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
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
        'kop_master_peserta_status'
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'kop_master_peserta_cabang', 'kop_master_cabang_code');
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'kop_req_tagihan_id', 'kop_master_peserta_code');
    }
}
