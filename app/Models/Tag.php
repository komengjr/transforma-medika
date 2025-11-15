<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'news_tag';
    protected $fillable = ['news_tag_name', 'news_tag_slug'];

    public function news()
    {
        return $this->belongsToMany(NewsData::class, 'news_tag');
    }
}
