<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalAntrianLog extends Model
{
    use HasFactory;

    protected $table = 'medical_antrian_log';

    protected $fillable = [
        'loket_id',
        'nomor_antrian',
        'status',
        'nomor_loket_pemanggil',
        'waktu_panggil',
        'waktu_selesai',
    ];

    // Relasi ke tabel medical_loket
    public function loket()
    {
        // GANTI $table->belongsTo MENJADI $this->belongsTo
        return $this->belongsTo(MedicalLoket::class, 'loket_id');
    }
}
