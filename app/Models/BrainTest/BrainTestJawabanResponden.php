<?php

namespace App\Models\BrainTest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrainTestJawabanResponden extends Model
{
    use HasFactory;

    protected $table = 'brain_test_jawaban_responden';
    protected $guarded = ['id'];

    protected $casts = [
        'sesi_responden_id' => 'integer',
        'soal_id'           => 'integer',
        'opsi_jawaban_id'   => 'integer',
        'is_ragu'           => 'boolean',
    ];

    public function sesiResponden(): BelongsTo
    {
        return $this->belongsTo(BrainTestSesiResponden::class, 'sesi_responden_id');
    }

    public function soal(): BelongsTo
    {
        return $this->belongsTo(BrainTestSoal::class, 'soal_id');
    }

    public function opsiJawaban(): BelongsTo
    {
        return $this->belongsTo(BrainTestOpsiJawaban::class, 'opsi_jawaban_id');
    }
}
