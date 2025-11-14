<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function news_index()
    {
        return view('News.index');
    }
    public function news_detail($id)
    {
        return view('news.detail');
    }
}
