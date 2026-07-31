<?php

namespace App\Models\medical;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalPendaftaranLabDetail extends Model
{
    protected $table = 'medical_pendaftaran_lab_details';
    protected $primaryKey = 'id_medical_pendaftaran_lab_detail';

    protected $fillable = [
        'medical_pendaftaran_lab_id',
        'medical_pemeriksaan_lab_id',
        'harga_pemeriksaan',
        'hasil_pemeriksaan',
        'satuan',
        'nilai_rujukan_terpakai',
        'flag_hasil'
    ];

    public function pemeriksaan()
    {
        return $this->belongsTo(MedicalPemeriksaanLab::class, 'medical_pemeriksaan_lab_id', 'id_medical_pemeriksaan_lab');
    }
}
