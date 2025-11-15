<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\NewsCat;
use App\Models\NewsData;
use App\Models\NewsView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function news_index()
    {
        $single = NewsData::latest()->paginate(5);
        $data = NewsData::latest()->get();
        $cat = NewsCat::latest()->limit(4)->get();
        $randomRecord = NewsData::inRandomOrder()->first();
        return view('news.index', compact('single', 'cat', 'data', 'randomRecord'));
    }
    public function news_detail($id, Request $request)
    {
        $data = NewsData::where('news_data_slug', $id)->firstOrFail();
        $this->addView($data, $request);
        $coment = DB::table('news_comments')->where('news_data_code', $data->news_data_code)->get();
        $randomRecord = NewsData::inRandomOrder()->join('news_categori','news_categori.news_categori_code','=','news_data.news_categori_code')->limit(4)->get();
        $views = DB::table('news_view')->where('news_data_code', $data->news_data_code)->count();
        return view('news.detail', compact('data', 'coment', 'randomRecord','views'));
    }
    private function addView(NewsData $news, Request $request)
    {
        $ip = $request->ip();
        $agent = $request->header('User-Agent');
        $today = date('Y-m-d');

        // Cek apakah sudah pernah view hari ini
        $existing = \App\Models\NewsView::where([
            'news_data_code' => $news->news_data_code,
            'news_view_user_ip' => $ip,
            'news_view_date' => $today,
        ])->first();

        if (!$existing) {
            NewsView::create([
                'news_data_code' => $news->news_data_code,
                'news_view_user_ip' => $ip,
                'news_view_user_agent' => $agent,
                'news_view_date' => $today,
            ]);
        }
    }
}
