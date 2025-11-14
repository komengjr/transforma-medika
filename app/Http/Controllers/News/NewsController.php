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
        $data = NewsData::latest()->get();
        $cat = NewsCat::latest()->limit(4)->get();
        // dd($cat);
        return view('News.index', compact('single', 'cat', 'data'));
    }
    public function news_detail($id)
    {
        $data = NewsData::where('news_data_slug', $id)->first();
        return view('news.detail', compact('data'));
    }
}
