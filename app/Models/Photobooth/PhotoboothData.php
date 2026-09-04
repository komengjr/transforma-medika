<?php

namespace App\Models\Photobooth;

use App\Models\PhotoboothResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoboothData extends Model
{
    use HasFactory;

    protected $table = 'photobooth_data';
    protected $fillable = ['org_code', 'org_name', 'logo_path', 'bg_path', 'is_active'];

    // Relasi One-to-Many ke Frame
    public function frames()
    {
        return $this->hasMany(PhotoboothDataFrame::class, 'photobooth_data_id');
    }
    public function results()
    {
        return $this->hasMany(PhotoboothResult::class, 'org_code', 'org_code');
    }
}
