<?php

namespace App\Models\Koperasi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'kop_master_cabang';
    protected $primaryKey = 'kop_master_cabang_code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kop_master_cabang_code',
        'kop_master_cabang_name',
        'kop_master_cabang_city',
        'kop_master_cabang_alamat',
    ];

    public function peserta()
    {
        return $this->hasMany(Peserta::class, 'kop_master_peserta_cabang', 'kop_master_cabang_code');
    }
}
