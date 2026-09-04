<?php

namespace App\Models;

use App\Models\Photobooth\PhotoboothData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoboothResult extends Model
{
    use HasFactory;

    protected $table = 'photobooth_results';

    protected $fillable = [
        'org_code',
        'code',
        'name',
        'phone',
        'email',
        'image_path',
        'single_images',
    ];

    protected $casts = [
        'single_images' => 'array',
    ];

    /**
     * Relasi ke model Photobooth / Organization
     */
    public function photobooth()
    {
        return $this->belongsTo(PhotoboothData::class, 'org_code', 'org_code');
    }
}
