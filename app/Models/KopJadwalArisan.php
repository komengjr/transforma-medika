<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopJadwalArisan extends Model
{
    use HasFactory;

    // 1. Tentukan nama tabel di database
    protected $table = 'kop_jadwal_arisan';

    // 2. Tentukan primary key custom
    protected $primaryKey = 'id_kop_jadwal_arisan';

    // 3. Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'id_kop_master_arisan',
        'id_kop_master_peserta',
        'kop_jadwal_arisan_bulan',
        'kop_jadwal_arisan_tahun',
        'kop_jadwal_arisan_point',
        'kop_jadwal_arisan_keterangan',
    ];

    // 4. Casting tipe data
    protected $casts = [
        'id_kop_master_arisan' => 'integer',
        'id_kop_master_peserta' => 'integer',
        'kop_jadwal_arisan_bulan' => 'integer',
        'kop_jadwal_arisan_tahun' => 'integer',
        'kop_jadwal_arisan_point' => 'integer',
    ];

    /**
     * Relasi ke Master Arisan (Belongs To)
     * Mengetahui jadwal ini merujuk ke program master arisan yang mana.
     */
    public function masterArisan()
    {
        return $this->belongsTo(KopMasterArisan::class, 'id_kop_master_arisan', 'id_kop_master_arisan');
    }

    /**
     * Relasi ke Master Peserta (Belongs To)
     * Mengambil data profil lengkap peserta yang memiliki jadwal ini.
     */
    public function peserta()
    {
        return $this->belongsTo(KopMasterPeserta::class, 'id_kop_master_peserta', 'id_kop_master_peserta');
    }
}
