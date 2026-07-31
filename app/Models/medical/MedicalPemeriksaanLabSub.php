<?php

namespace App\Models\medical;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalPemeriksaanLabSub extends Model
{
    protected $guarded = [];

    // Relasi Sub milik 1 Master
    public function master()
    {
        return $this->belongsTo(MedicalPemeriksaanLab::class, 'medical_pemeriksaan_lab_id');
    }
}
