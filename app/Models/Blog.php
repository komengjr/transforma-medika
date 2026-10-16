<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'title', 'slug', 'content', 'thumbnail', 'views'
    ];

    // Relasi One-to-Many: 1 Blog punya Banyak Comment
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
