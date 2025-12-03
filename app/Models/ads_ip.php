<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ads_ip extends Model
{
    protected $table = 'ads_ip';
    protected $fillable = [
        'news_view_user_ip',
        'news_view_user_agent',
        'news_view_date'
    ];
}
