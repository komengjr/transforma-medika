<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopVocherData extends Model
{
    protected $table = 'kop_vocher_data';
    protected $primaryKey = 'id_vocher_data';
    protected $fillable = [
        'kop_vocher_data_code',
        'kop_vocher_data_token',
        'kop_master_peserta_code',
        'kop_vocher_cat_code',
        'kop_vocher_data_nominal',
        'kop_vocher_data_number_id',
        'kop_vocher_data_ketua',
        'kop_vocher_data_date_start',
        'kop_vocher_data_date_end',
        'kop_vocher_data_cabang',
        'kop_vocher_data_status',

        // Field admin tambahan yang baru digabungkan:
        'kop_vocher_data_admin',
    ];
    protected $casts = [
        'kop_vocher_data_date_start' => 'date',
        'kop_vocher_data_date_end' => 'date',
    ];
}
