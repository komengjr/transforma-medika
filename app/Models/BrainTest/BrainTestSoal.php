<?php

namespace App\Models\BrainTest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrainTestSoal extends Model
{
    use HasFactory;

    protected $table = 'brain_test_soal';

    // Gunakan fillable secara spesifik untuk menghindari mass-assignment error
    protected $fillable = [
        'kategori_id',
        'pertanyaan',
        'gambar', // <-- Tambahkan ini
    ];

    // Relasi ke Kategori
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(BrainTestKategori::class, 'kategori_id');
    }

    // Relasi ke Opsi Jawaban (untuk pilihan ganda)
    public function opsiJawabans(): HasMany
    {
        return $this->hasMany(BrainTestOpsiJawaban::class, 'soal_id');
    }

    // Relasi ke Jawaban Responden
    public function jawabanRespondens(): HasMany
    {
        return $this->hasMany(BrainTestJawabanResponden::class, 'soal_id');
    }
}
