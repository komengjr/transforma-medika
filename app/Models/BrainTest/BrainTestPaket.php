<?php

namespace App\Models\BrainTest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrainTestPaket extends Model
{
    use HasFactory;

    protected $table = 'brain_test_paket';

    protected $fillable = [
        'klasifikasi_id',
        'nama_test',
        'slug',
        'durasi_menit',
        'passing_grade',
        'deskripsi',
        'status',
    ];

    protected $casts = [
        'klasifikasi_id' => 'integer',
        'durasi_menit'   => 'integer',
        'passing_grade'  => 'integer',
    ];

    public function klasifikasi(): BelongsTo
    {
        return $this->belongsTo(BrainTestKlasifikasi::class, 'klasifikasi_id');
    }

    public function kategoris(): HasMany
    {
        return $this->hasMany(BrainTestKategori::class, 'paket_id')->orderBy('urutan');
    }

    public function sesiRespondens(): HasMany
    {
        return $this->hasMany(BrainTestSesiResponden::class, 'paket_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
