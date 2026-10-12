<?php

namespace App\Models\BrainTest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrainTestKategori extends Model
{
    protected $table = 'brain_test_kategori';
    protected $guarded = ['id'];

    // Relasi ke Klasifikasi (Sudah ada sebelumnya)
    public function klasifikasi(): BelongsTo
    {
        return $this->belongsTo(BrainTestKlasifikasi::class, 'klasifikasi_id');
    }

    // TAMBAHKAN INI: Relasi ke tabel Soal (brain_test_soal)
    public function soals(): HasMany
    {
        return $this->hasMany(BrainTestSoal::class, 'kategori_id');
    }
}
