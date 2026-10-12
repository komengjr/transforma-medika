<?php

namespace App\Models\BrainTest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrainTestKlasifikasi extends Model
{
    protected $table = 'brain_test_klasifikasi';
    protected $guarded = ['id'];

    public function kategoris(): HasMany
    {
        return $this->hasMany(BrainTestKategori::class, 'klasifikasi_id');
    }
}
