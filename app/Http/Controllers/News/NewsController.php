<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\NewsCat;
use App\Models\NewsData;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function news_index()
    {
        $single = NewsData::latest()->paginate(5);
        $cat = NewsCat::latest()->limit(4)->get();
        // dd($cat);
        return view('News.index', compact('single', 'cat'));
    }
    public function news_detail($id)
    {
        return view('news.detail');
    }
}
