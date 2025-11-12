<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TvChannel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'stream_url',
        'category',
        'is_active'
    ];
}
