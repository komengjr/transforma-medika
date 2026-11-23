<?php

namespace App\Models\BrainTest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class BrainTestKlasifikasi extends Model
{
    use HasFactory;

    protected $table = 'brain_test_klasifikasi';

    protected $fillable = [
        'nama_klasifikasi',
        'slug',
        'deskripsi',
        'status',
    ];

    public function pakets(): HasMany
    {
        return $this->hasMany(BrainTestPaket::class, 'klasifikasi_id')->orderBy('id', 'desc');
    }

    public function kategoris(): HasManyThrough
    {
        return $this->hasManyThrough(
            BrainTestKategori::class,
            BrainTestPaket::class,
            'klasifikasi_id',
            'paket_id',
            'id',
            'id'
        );
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
