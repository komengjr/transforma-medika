<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoboothResult extends Model
{
    use HasFactory;

    protected $table = 'photobooth_results';

    protected $fillable = [
        'code',
        'name',
        'phone',
        'email',
        'image_path',
        'single_images',
    ];

    // Otomatis mengubah JSON menjadi Array PHP
    protected $casts = [
        'single_images' => 'array',
    ];
}
