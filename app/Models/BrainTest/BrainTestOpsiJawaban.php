<?php

namespace App\Models\BrainTest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrainTestOpsiJawaban extends Model
{
    use HasFactory;

    protected $table = 'brain_test_opsi_jawaban'; // <-- Diperbaiki ke nama tabel yang benar

    protected $fillable = [
        'soal_id',
        'teks_jawaban',
        'gambar', // <-- Tambahkan ini
        'is_benar',
        'poin',
    ];

    // Relasi ke Soal
    public function soal(): BelongsTo
    {
        return $this->belongsTo(BrainTestSoal::class, 'soal_id');
    }

    // Relasi ke Jawaban Responden
    public function jawabanRespondens(): HasMany
    {
        return $this->hasMany(BrainTestJawabanResponden::class, 'opsi_jawaban_id');
    }
}
