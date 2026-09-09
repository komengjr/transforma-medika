<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalLoketCounter extends Model
{
    protected $fillable = ['loket_ids', 'nomor_counter', 'ip_address', 'nama_counter', 'is_active'];

    protected $casts = [
        'loket_ids' => 'array', // Konversi JSON ke Array secara otomatis
        'is_active' => 'boolean',
    ];

    // Relasi helper untuk mengambil data detail loket-loket terikat
    public function lokets()
    {
        return MedicalLoket::whereIn('id', $this->loket_ids ?? [])->get();
    }
}
