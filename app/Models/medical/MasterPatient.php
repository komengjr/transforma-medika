<?php

namespace App\Models\medical;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPatient extends Model
{
    use HasFactory;

    protected $table = 'master_patient';
    protected $primaryKey = 'id_master_patient'; // Primary Key Custom

    // Daftarkan semua kolom yang diizinkan untuk dikirim via create() / update()
    protected $fillable = [
        'master_patient_code',
        'master_patient_nik',
        'master_patient_name',
        'master_patient_jk',
        'master_patient_tgl_lahir',
        'master_patient_tempat_lahir',
        'master_patient_agama',
        'master_patient_no_hp',
        'master_patient_email',
        'master_patient_place',
        'master_patient_alamat',
        'master_patient_profile',
    ];

    /**
     * Relasi ke Pendaftaran Lab
     */
    public function pendaftaranLabs()
    {
        return $this->hasMany(MedicalPendaftaranLab::class, 'id_master_patient', 'id_master_patient');
    }
}
