<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'company_mou_peserta';
    protected $fillable = [
        'id_mou_peserta',
        'mou_peserta_code',
        'company_mou_code',
        'mou_peserta_nik',
        'mou_peserta_nip',
        'mou_peserta_name',
        'mou_peserta_no_hp',
        'mou_peserta_email',
        'mou_peserta_ttl',
        'mou_peserta_jk',
        'mou_peserta_departemen',
        'mou_agreement_code',
        'mou_peserta_status'
    ];
}
