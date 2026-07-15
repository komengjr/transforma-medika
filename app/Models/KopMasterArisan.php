<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopMasterArisan extends Model
{
    use HasFactory;

    // 1. Tentukan nama tabel di database
    protected $table = 'kop_master_arisan';

    // 2. Tentukan primary key custom
    protected $primaryKey = 'id_kop_master_arisan';

    // 3. Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'kop_master_arisan_code',
        'kop_master_arisan_name',
        'kop_master_arisan_nominal_point',
        'kop_master_arisan_thn_mulai',
        'kop_master_arisan_thn_selesai',
        'kop_master_arisan_status',
    ];

    // 4. Casting tipe data agar lebih mudah diolah di PHP
    protected $casts = [
        'kop_master_arisan_nominal_point' => 'float',
        'kop_master_arisan_thn_mulai' => 'integer',
        'kop_master_arisan_thn_selesai' => 'integer',
    ];

    /**
     * Relasi ke Jadwal Arisan (One-to-Many)
     * Satu master program arisan memiliki banyak daftar plotting jadwal anggota.
     */
    public function jadwalArisan()
    {
        return $this->hasMany(KopJadwalArisan::class, 'id_kop_master_arisan', 'id_kop_master_arisan');
    }
}
