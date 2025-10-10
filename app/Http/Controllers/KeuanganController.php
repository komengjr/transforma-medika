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

class KeuanganController extends Controller
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
    // MENU KASIR
    public function keuangan_menu_cashier($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('application.keuangan.menu-cashier', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function keuangan_menu_cashier_find(Request $request)
    {
        $data = DB::table('d_reg_order')->where('d_reg_order_code', $request->code)->first();
        if ($data) {
            $pasien = DB::table('d_reg_order')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->where('d_reg_order.d_reg_order_code', $request->code)->first();
            $data = DB::table('d_reg_order_list')
                ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'd_reg_order_list.t_layanan_cat_code')
                ->where('d_reg_order_list.d_reg_order_code', $request->code)->get();
            return view('application.keuangan.menu-cashier.detail-order', ['data' => $data, 'pasien' => $pasien, 'code' => $request->code]);
            # code...
        } else {
            return 0;
        }
    }
    public function keuangan_menu_cashier_find_fix_payment(Request $request)
    {
        $list = DB::table('d_reg_order_list')->where('d_reg_order_code', $request->code)->get();
        foreach ($list as $value) {
            DB::table('d_reg_order_payment')->insert([
                'd_reg_order_payment_code' => str::uuid(),
                'd_reg_order_code' => $request->code,
                'd_reg_order_list_code' => $value->d_reg_order_list_code,
                'd_reg_order_payment_date' => now(),
                'd_reg_order_payment_user' => Auth::user()->userid,
                'created_at' => now()
            ]);
        }
        return 123;
    }
    // PERNERIMAAN TRANSAKSI
    public function keuangan_penerimaan_transaksi($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->get();
            return view('application.keuangan.transaksi-penerimaan', ['akses' => $akses, 'data' => $data, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function keuangan_penerimaan_proses_transaksi(Request $request)
    {
        $data = DB::table('d_reg_order')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order.d_reg_order_code', $request->code)
            ->first();
        return view('application.keuangan.transaksi-penerimaan.form-proses-transaksi', ['data' => $data]);
    }
}
