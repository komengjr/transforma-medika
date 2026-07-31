<?php

namespace App\Http\Controllers;

use App\Models\ads_ip;
use App\Models\NewsData;
use Illuminate\Support\Facades\Cache;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
    public function getway_whatsapp()
    {
        $data = DB::table('v_log_whatsapp')->where('v_log_whatsapp_status', 0)->first();
        return response()->json($data);
    }
    public function getway_whatsapp_status($code)
    {
        DB::table('v_log_whatsapp')->where('v_log_whatsapp_code', $code)->update([
            'v_log_whatsapp_status' => 1
        ]);
        return response()->json('Berhasil Kirim');
    }
    public function getway_whatsapp_update(Request $request)
    {
        DB::table('v_log_whatsapp')->where('v_log_whatsapp_code', $request->code)->update([
            'v_log_whatsapp_status' => $request->status
        ]);
        return response()->json('Berhasil Kirim');
    }
    public function getway_whatsapp_koperasi()
    {
        $data = DB::table('kop_sender_wa')->where('kop_sender_wa_code_status', 0)->first();
        return response()->json($data);
    }
    public function getway_whatsapp_koperasi_update(Request $request)
    {
        DB::table('kop_sender_wa')->where('kop_sender_wa_code', $request->code)->update([
            'kop_sender_wa_code_status' => 1
        ]);
        return response()->json('Berhasil Kirim');
    }
    public function interface_alat(Request $request)
    {
        $payload = $request->all();

        // Catat ke log Laravel sebagai bukti data berhasil ditangkap middleware
        Log::info('Data ASTM Alat Masuk:', $payload);

        $noLab = $request->input('nolab');
        $results = $request->input('result', []);

        // Lakukan proses validasi dan penyimpanan ke database di sini
        // Contoh:
        // foreach($results as $res) {
        //     HasilLab::create([...]);
        // }

        return response()->json([
            'status' => 'success',
            'message' => 'Laravel berhasil menerima data untuk NoLab: ' . $noLab,
            'total_data' => count($results)
        ], 200);
    }
    public function interface_alat_xn_500(Request $request){

    }
}
