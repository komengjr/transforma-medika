<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoboothResult extends Model
{
    use HasFactory;

    protected $table = 'photobooth_results';

    protected $fillable = [
        'code',       // <-- Pastikan ini ada!
        'name',
        'phone',
        'email',
        'image_path',
    ];
}
