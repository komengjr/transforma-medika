<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalLoket extends Model
{
    use HasFactory;

    protected $table = 'medical_loket';

    protected $fillable = [
        'nama_loket',
        'kode_prefix',
        'deskripsi',
        'icon',
        'warna_tema',
        'nomor_terakhir',
        'is_active',
    ];
}
