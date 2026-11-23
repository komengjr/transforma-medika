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

    protected $fillable = [
        'kategori_id',
        'pertanyaan',
        'gambar',
        'tipe_soal',
        'kunci_jawaban_isian',
        'bobot_nilai',
        'pembahasan',
    ];

    protected $casts = [
        'kategori_id' => 'integer',
        'bobot_nilai' => 'integer',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(BrainTestKategori::class, 'kategori_id');
    }

    public function opsiJawabans(): HasMany
    {
        return $this->hasMany(BrainTestOpsiJawaban::class, 'soal_id');
    }

    public function jawabanRespondens(): HasMany
    {
        return $this->hasMany(BrainTestJawabanResponden::class, 'soal_id');
    }
}
