<?php

namespace App\Models\medical;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalPendaftaranLab extends Model
{
    protected $table = 'medical_pendaftaran_labs';
    protected $primaryKey = 'id_medical_pendaftaran_lab';

    protected $fillable = [
        'nolab',
        'id_master_patient',
        'tanggal_daftar',
        'status',
        'total_biaya',
        'catatan'
    ];

    public function patient()
    {
        return $this->belongsTo(MasterPatient::class, 'id_master_patient', 'id_master_patient');
    }

    public function details()
    {
        return $this->hasMany(MedicalPendaftaranLabDetail::class, 'medical_pendaftaran_lab_id', 'id_medical_pendaftaran_lab');
    }
}
