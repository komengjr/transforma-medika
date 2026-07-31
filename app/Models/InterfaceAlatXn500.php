<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterfaceAlatXn500 extends Model
{
    protected $table = 'interface_alat_xn_500';

    protected $fillable = [
        'instrument_id',
        'nolab',
        'tanggal',
        'flag_qc',
        'flag_query',
        'results',
        'raw_payload',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'results' => 'array',
        'raw_payload' => 'array',
    ];
}
