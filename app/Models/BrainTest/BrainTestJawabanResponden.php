<?php

namespace App\Models\BrainTest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrainTestJawabanResponden extends Model
{
    protected $table = 'brain_test_jawaban_responden';
    protected $guarded = ['id'];

    // Relasi ke Sesi Responden
    public function sesiResponden(): BelongsTo
    {
        return $this->belongsTo(BrainTestSesiResponden::class, 'sesi_responden_id');
    }

    // Relasi ke Soal
    public function soal(): BelongsTo
    {
        return $this->belongsTo(BrainTestSoal::class, 'soal_id');
    }

    // Relasi ke Opsi Jawaban yang dipilih
    public function opsiJawaban(): BelongsTo
    {
        return $this->belongsTo(BrainTestOpsiJawaban::class, 'opsi_jawaban_id');
    }
}
