<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterfaceAlatArchitectCi4100 extends Model
{
    protected $table = 'interface_alat_architect_ci4100';

    protected $casts = [
        'tanggal' => 'datetime',
        'results' => 'array',
        'raw_payload' => 'array',
    ];
}
