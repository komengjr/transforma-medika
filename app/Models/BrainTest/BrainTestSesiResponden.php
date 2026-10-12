<?php

namespace App\Models\BrainTest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrainTestSesiResponden extends Model
{
    protected $table = 'brain_test_sesi_responden';
    protected $guarded = ['id'];

    /**
     * Relasi ke tabel Klasifikasi Tes
     */
    public function klasifikasi(): BelongsTo
    {
        return $this->belongsTo(BrainTestKlasifikasi::class, 'klasifikasi_id');
    }

    /**
     * Relasi ke tabel Jawaban Responden (untuk memantau riwayat jawaban)
     */
    public function jawabanRespondens(): HasMany
    {
        return $this->hasMany(BrainTestJawabanResponden::class, 'sesi_responden_id');
    }
}
