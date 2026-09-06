<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappHistory extends Model
{
    use HasFactory;

    // Arahkan ke nama tabel baru
    protected $table = 'b_whatsapp_histories';

    protected $fillable = [
        'batch_id',
        'recipient',
        'subject',
        'message',
        'attachment',
        'status',
        'error_message',
    ];
}
