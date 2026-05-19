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
            if ($data->kop_vocher_data_status == '0') {

                $ketua = DB::table('kop_user_verifikasi')->where('kop_user_verifikasi_cabang', $data->kop_master_cabang_code)
                    ->where('kop_user_verifikasi_job', 1)
                    ->where('kop_user_verifikasi_status', 1)->first();
                return view('app-koperasi.public.form-sign-vocher', compact('data', 'ketua'));
            } else {
                return redirect()->route('login');
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function data_vocher_save_sign(Request $request)
    {
        $data = DB::table('kop_vocher_data_verif')->where('kop_vocher_data_code', $request->code)->first();
        if ($data) {
            return 0;
        } else {
            DB::table('kop_vocher_data_verif')->insert([
                'kop_vocher_data_verif_code' => str::uuid(),
                'kop_vocher_data_code' => $request->code,
                'kop_vocher_data_verif_sign' => $request->sign,
                'kop_vocher_data_verif_date' => now(),
                'created_at' => now()
            ]);
            DB::table('kop_vocher_data')->where('kop_vocher_data_code', $request->code)->update([
                'kop_vocher_data_status' => 1,
                'updated_at' => now()
            ]);
            return 1;
        }
    }
    public function data_peminjaman_uang($code)
    {
        $data = DB::table('kop_proses_verif')
            ->join('kop_proses_peminjaman_uang', 'kop_proses_peminjaman_uang.kop_proses_uang_code', '=', 'kop_proses_verif.kop_proses_uang_code')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_proses_peminjaman_uang.kop_master_peserta_code')
            ->join('kop_master_cabang', 'kop_master_cabang.kop_master_cabang_code', '=', 'kop_master_peserta.kop_master_peserta_cabang')
            ->join('kop_user_verifikasi', 'kop_user_verifikasi.kop_user_verifikasi_code', '=', 'kop_proses_verif.kop_proses_verif_user')
            ->where('kop_proses_verif.kop_proses_verif_code', $code)->first();
        if ($data) {
            if ($data->kop_proses_verif_status == '0') {
                return view('app-koperasi.public.form-sign-data-peminjaman', compact('data'));
            } else {
                return redirect()->route('login');
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function data_peminjaman_uang_sign(Request $request)
    {
        try {
            DB::table('kop_proses_verif')->where('kop_proses_verif_code', $request->code)->update([
                'kop_proses_verif_sign' => $request->sign,
                'kop_proses_verif_date' => now(),
                'kop_proses_verif_status' => 1,
                'updated_at' => now()
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
}
