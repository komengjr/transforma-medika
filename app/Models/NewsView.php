<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsView extends Model
{
    protected $table = 'news_view';
    protected $fillable = [
        'news_data_code',
        'news_view_user_ip',
        'news_view_user_agent',
        'news_view_date'
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
