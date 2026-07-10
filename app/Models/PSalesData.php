<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PSalesData extends Model
{
    protected $table = 'p_sales_data';
    protected $primaryKey = 'id_p_sales_data';

    // Hubungkan ke definisi pemeriksaan medis asli
    public function pemeriksaanList()
    {
        return $this->belongsTo(TPemeriksaanList::class, 't_pemeriksaan_list_code', 't_pemeriksaan_list_code');
    }
}
