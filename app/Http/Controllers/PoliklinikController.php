<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class PoliklinikController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function url_akses($akses, $id)
    {
        $data = DB::table('z_menu_user')
            ->join('z_menu_sub', 'z_menu_sub.menu_sub_code', '=', 'z_menu_user.menu_sub_code')
            ->join('z_menu', 'z_menu.menu_code', '=', 'z_menu_sub.menu_code')
            ->where('z_menu.menu_super_code', $id)
            ->where('z_menu_user.menu_sub_code', $akses)
            ->where('z_menu_user.access_code', Auth::user()->access_code)->first();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }
    public function url_akses_sub($akses, $id)
    {
        $data = DB::table('z_menu_user_sub')
            ->join('z_menu_sub_main', 'z_menu_sub_main.menu_main_sub_code', '=', 'z_menu_user_sub.menu_main_sub_code')
            ->join('z_menu_sub', 'z_menu_sub.menu_sub_code', '=', 'z_menu_sub_main.menu_sub_code')
            ->join('z_menu', 'z_menu.menu_code', '=', 'z_menu_sub.menu_code')
            ->where('z_menu.menu_super_code', $id)
            ->where('z_menu_user_sub.menu_main_sub_code', $akses)
            ->where('z_menu_user_sub.access_code', Auth::user()->access_code)->first();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }
    // DATA REGISTRASI POLI
    public function data_registrasi_poli($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_poli')->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_poli.d_reg_order_code')
                ->join('m_doctor_poli', 'm_doctor_poli.m_doctor_poli_code', '=', 'd_reg_order_poli.m_doctor_poli_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('t_layanan_data', 't_layanan_data.t_layanan_data_code', '=', 'm_doctor_poli.t_layanan_data_code')
                ->join('master_doctor', 'master_doctor.master_doctor_code', '=', 'm_doctor_poli.master_doctor_code')
                ->where('d_reg_order.d_reg_order_cabang',Auth::user()->access_cabang)
                ->get();
            return view('application.poliklinik.data-registrasi-poliklinik', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_registrasi_poli_handling(Request $request)
    {
        $data = DB::table('d_reg_order_poli')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_poli.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_poli.d_reg_order_poli_code', $request->code)
            ->first();
        return view('application.poliklinik.data-registrasi.form-handling', ['data' => $data, 'code' => $request->code]);
    }
    public function data_registrasi_poli_handling_pasien(Request $request)
    {
        DB::table('d_reg_order_poli')->where('d_reg_order_poli_code', $request->code)->update([
            'd_reg_order_poli_status' => 1
        ]);
        return '<span class="badge bg-primary">Done</span>';
    }
    // POLIKLINIK HANDLING
    public function data_registrasi_poliklinik_handling($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_poli')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_poli.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('m_doctor_poli', 'm_doctor_poli.m_doctor_poli_code', '=', 'd_reg_order_poli.m_doctor_poli_code')
                ->join('t_layanan_data', 't_layanan_data.t_layanan_data_code', '=', 'm_doctor_poli.t_layanan_data_code')
                ->join('master_doctor', 'master_doctor.master_doctor_code', '=', 'm_doctor_poli.master_doctor_code')
                ->where('d_reg_order.d_reg_order_cabang',Auth::user()->access_cabang)
                ->where('d_reg_order_poli.d_reg_order_poli_status', 1)->get();
            return view('application.poliklinik.poliklinik-handling', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_registrasi_poliklinik_handling_detail(Request $request)
    {
        $data = DB::table('d_reg_order_poli')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_poli.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order.d_reg_order_code', $request->code)->first();
        $layanan = DB::table('t_layanan_cat')->get();
        return view('application.poliklinik.poliklinik-handling.form-handling', ['data' => $data, 'layanan' => $layanan, 'code' => $request->code]);
    }
    public function data_registrasi_poliklinik_handling_order_layanan(Request $request)
    {
        //RADIOLOGI
        if ($request->code == '80304154-baeb-4b7a-8ba8-f818726a84df') {
            $dokter = DB::table('master_doctor')->get();
            $pemeriksaan = DB::table('p_sales_data')
                ->join('p_sales_cat', 'p_sales_cat.p_sales_cat_code', '=', 'p_sales_data.p_sales_cat_code')
                ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
                ->where('p_sales_cat.t_layanan_cat_code', $request->code)
                ->where('p_sales_cat.p_sales_cat_name', 'PEMERIKSAAN')
                ->get();
            return view('application.poliklinik.poliklinik-handling.order-radiologi', ['reg' => $request->reg, 'dokter' => $dokter, 'code' => $request->code, 'pemeriksaan' => $pemeriksaan]);
        } else {
            return $request->code;
        }
    }
    public function data_registrasi_poliklinik_handling_order_layanan_rad(Request $request)
    {
        $total = DB::table('d_reg_order_rad')->where('d_reg_order_code', $request->no_reg)->count();
        $pemeriksaan = DB::table('p_sales_data')->where('p_sales_data_code', $request->pemeriksaan)->first();
        $code = 'R' . $request->no_reg . str_pad($total + 1, 4, '0', STR_PAD_LEFT);
        DB::table('d_reg_order_list')->insert([
            'd_reg_order_list_code' => $code,
            'd_reg_order_code' => $request->no_reg,
            't_layanan_cat_code' => $request->layanan,
            'd_reg_order_list_date' => now(),
            'created_at' => now(),
        ]);
        DB::table('d_reg_order_rad')->insert([
            'd_reg_order_rad_code' => $code,
            'd_reg_order_code' => $request->no_reg,
            'd_reg_order_rad_dr_rujukan' => $request->dokter,
            'd_reg_order_rad_date' => now(),
            'd_reg_order_rad_desc' => $request->desc,
            'd_reg_order_rad_number' => 1,
            'd_reg_order_rad_status' => 0,
            'd_reg_order_rad_user' => Auth::user()->userid,
            'created_at' => now()
        ]);
        DB::table('d_reg_order_rad_list')->insert([
            'order_rad_list_code' => str::uuid(),
            'd_reg_order_rad_code' => $code,
            'p_sales_data_code' => $request->pemeriksaan,
            'order_rad_log_price' => $pemeriksaan->p_sales_data_price,
            'order_rad_log_discount' => $pemeriksaan->p_sales_data_disc,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Order');
    }
    // POLIKLINIK VERIFIKASI DOKTER
    public function verifikasi_poliklinik_dokter($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('application.poliklinik.verifikasi-dokter-poliklinik', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
}
