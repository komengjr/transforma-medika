<?php

namespace App\Models\BrainTest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrainTestKategori extends Model
{
    use HasFactory;

    protected $table = 'brain_test_kategori';

    protected $fillable = [
        'paket_id',
        'nama_kategori',
        'passing_grade',
        'urutan',
        'slug',
        'deskripsi',
    ];

    protected $casts = [
        'paket_id'      => 'integer',
        'passing_grade' => 'integer',
        'urutan'        => 'integer',
    ];

    public function paket(): BelongsTo
    {
        return $this->belongsTo(BrainTestPaket::class, 'paket_id');
    }

    public function soals(): HasMany
    {
        return $this->hasMany(BrainTestSoal::class, 'kategori_id');
    }
}
