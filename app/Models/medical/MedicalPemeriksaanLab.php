<?php

namespace App\Models\medical;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalPemeriksaanLab extends Model
{
    protected $table = 'medical_pemeriksaan_labs';
    protected $primaryKey = 'id_medical_pemeriksaan_lab';

    protected $fillable = [
        'nama_pemeriksaan',
        'code_alat', // <-- Pastikan ini terdaftar
        'harga',
        'satuan',
        'nilai_rujukan',
    ];
    protected $guarded = [];

    // Relasi 1 Master punya Banyak Sub-Parameter
    public function subs()
    {
        return $this->hasMany(MedicalPemeriksaanLabSub::class, 'medical_pemeriksaan_lab_id')->orderBy('urutan');
    }
}
