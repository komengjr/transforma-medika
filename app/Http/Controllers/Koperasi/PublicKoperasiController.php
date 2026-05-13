<?php

namespace App\Http\Controllers\Koperasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PublicKoperasiController extends Controller
{
    public function data_vocher($code)
    {
        $data = DB::table('kop_vocher_data')
            ->join('kop_master_cabang', 'kop_master_cabang.kop_master_cabang_code', '=', 'kop_vocher_data.kop_vocher_data_cabang')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_vocher_data.kop_master_peserta_code')
            ->where('kop_vocher_data.kop_vocher_data_code', $code)->first();

        if ($data) {
            $ketua = DB::table('kop_user_verifikasi')->where('kop_user_verifikasi_cabang',$data->kop_master_cabang_code)
            ->where('kop_user_verifikasi_job', 1)
            ->where('kop_user_verifikasi_status', 1)->first();
            return view('app-koperasi.public.form-sign-vocher',compact('data','ketua'));
            # code...
        } else {
            return 'tidak ada data';
        }
    }
}
