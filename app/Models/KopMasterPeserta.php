<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopMasterPeserta extends Model
{
    use HasFactory;

    // 1. Tentukan nama tabel yang sesuai di database
    protected $table = 'kop_master_peserta';

    // 2. Tentukan primary key karena tidak menggunakan 'id' bawaan Laravel
    protected $primaryKey = 'id_kop_master_peserta';

    // 3. Daftarkan kolom yang boleh diisi (Mass Assignment)
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
        'kop_master_peserta_status',
    ];

    // 4. Casting tipe data tanggal agar otomatis menjadi Carbon instance
    protected $casts = [
        'kop_master_peserta_tgl_lahir' => 'date',
        'kop_master_peserta_tgl_kerja' => 'date',
        'kop_master_peserta_tgl_anggota' => 'date',
    ];

    /**
     * Relasi ke Jadwal Arisan (One-to-Many)
     * Seorang peserta bisa memiliki banyak plotting jadwal arisan dalam 1 dekade.
     */
    public function jadwalArisan()
    {
        return $this->hasMany(KopJadwalArisan::class, 'id_kop_master_peserta', 'id_kop_master_peserta');
    }
}
