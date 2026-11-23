<?php

namespace App\Models\BrainTest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrainTestSesiResponden extends Model
{
    use HasFactory;

    protected $table = 'brain_test_sesi_responden';
    protected $guarded = ['id'];

    protected $casts = [
        'paket_id'      => 'integer',
        'total_skor'    => 'integer',
        'waktu_mulai'   => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    /**
     * Relasi ke Paket / Nama Tes yang dikerjakan.
     */
    public function paket(): BelongsTo
    {
        return $this->belongsTo(BrainTestPaket::class, 'paket_id');
    }

    public function jawabanRespondens(): HasMany
    {
        return $this->hasMany(BrainTestJawabanResponden::class, 'sesi_responden_id');
    }
}
