<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class FinMasterCoa extends Model
{
    // 1. Definisikan nama tabel secara eksplisit
    protected $table = 'kop_fin_master_coa';

    // 2. Tentukan primary key yang digunakan
    protected $primaryKey = 'coa_code';

    // 3. Beritahu Eloquent bahwa primary key-nya BUKAN integer auto-incrementing
    public $incrementing = false;

    // 4. Beritahu Eloquent bahwa tipe data primary key adalah string
    protected $keyType = 'string';

    // 5. Daftarkan kolom yang boleh diisi secara massal (mass assignment)
    protected $fillable = [
        'coa_code',
        'coa_name',
        'coa_type',
        'normal_balance',
        'is_active',
    ];

    /**
     * Relasi ke tabel fin_jurnal_detail.
     * Satu akun COA bisa memiliki banyak baris histori di detail jurnal.
     * * @return HasMany
     */
    public function jurnalDetails(): HasMany
    {
        return $this->hasMany(FinJurnalDetail::class, 'coa_code', 'coa_code');
    }

    /**
     * Scope helper untuk memfilter hanya akun COA yang aktif saja.
     * Bisa dipanggil dengan cara: FinMasterCoa::active()->get();
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
