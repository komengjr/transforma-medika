<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaEvent extends Model
{
    protected $table = 'b_event_peserta';
    protected $fillable = [
        'id_b_event_peserta',
        'b_event_peserta_code',
        'b_event_code',
        'b_event_peserta_name',
        'b_event_peserta_booking',
        'b_event_peserta_class',
        'b_event_peserta_room',
        'b_event_peserta_hp',
        'b_event_peserta_email',
        'b_event_peserta_lembaga',
        'b_event_peserta_desc',
        'b_event_peserta_status',
        'created_at',
    ];
}
