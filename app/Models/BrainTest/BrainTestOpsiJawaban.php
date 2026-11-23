<?php

namespace App\Models\BrainTest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrainTestOpsiJawaban extends Model
{
    use HasFactory;

    protected $table = 'brain_test_opsi_jawaban';

    protected $fillable = [
        'soal_id',
        'teks_jawaban',
        'gambar',
        'is_benar',
        'poin',
    ];

    protected $casts = [
        'soal_id'  => 'integer',
        'is_benar' => 'boolean',
        'poin'     => 'integer',
    ];

    public function soal(): BelongsTo
    {
        return $this->belongsTo(BrainTestSoal::class, 'soal_id');
    }

    public function jawabanRespondens(): HasMany
    {
        return $this->hasMany(BrainTestJawabanResponden::class, 'opsi_jawaban_id');
    }
}
