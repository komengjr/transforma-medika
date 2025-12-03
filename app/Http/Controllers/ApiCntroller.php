<?php

namespace App\Http\Controllers;

use App\Models\ads_ip;
use App\Models\NewsData;
use Illuminate\Support\Facades\Cache;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiCntroller extends Controller
{
    public function data_product()
    {
        try {
            $category = DB::table('log_m_product')->inRandomOrder()->limit(10)->get();
            return response()->json($category);
        } catch (QueryException $e) {
            $error = [
                'error' => $e->getMessage()
            ];
            return response()->json($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function data_antrian()
    {

        $data_arr = array(
            "loket1" => "A015",
            "loket2" => "B004",
            "loket3" => "Z021"
        );
        return response()->json($data_arr);
    }
    public function data_stream_api(Request $request)
    {
        $ip = $request->ip();
        $agent = $request->header('User-Agent');
        $today = date('Y-m-d');

        // Cek apakah sudah pernah view hari ini
        $existing = \App\Models\ads_ip::where([
            'news_view_user_ip' => $ip,
            'news_view_date' => $today,
        ])->first();

        if (!$existing) {
            ads_ip::create([
                'news_view_user_ip' => $ip,
                'news_view_user_agent' => $agent,
                'news_view_date' => $today,
            ]);
        }

        $data = NewsData::inRandomOrder()->first();
        return response()->json([
            'data' => Cache::get('/', $ip)
        ]);
    }
}
