<?php

namespace App\Models\Photobooth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoboothDataFrame extends Model
{
    use HasFactory;

    protected $table = 'photobooth_data_frame';
    protected $fillable = ['photobooth_data_id', 'frame_name', 'frame_path', 'is_active'];

    // Inverse Relasi
    public function photobooth()
    {
        return $this->belongsTo(PhotoboothData::class, 'photobooth_data_id');
    }
}
