<?php

namespace App\Models\Brodcast;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class masterContact extends Model
{
    protected $table = 'b_master_contact';
    protected $fillable = [
        'id_b_master_contact',
        'b_master_contact_code',
        'b_master_contact_name',
        'b_master_contact_email',
        'b_master_contact_whatsapp',
        'b_master_contact_cabang',
        'b_master_contact_status',
        'created_at',
    ];
}
