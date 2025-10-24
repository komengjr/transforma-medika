<?php

namespace App\Http\Controllers\Farmasi;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class FarmasiController extends Controller
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
    // PENJUALAN NON RESEP
    public function penjualan_non_resep($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.penjualan.penjualan-non-resep', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // PENJUALAN NON RESEP
    public function penjualan_farmasi_resep($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.penjualan.penjualan-resep', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // PENJUALAN VERIFIKASI RESEP
    public function penjualan_verifikasi_dosis_resep($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.penjualan.verifikasi-dosis-resep', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // CETAK NOTA FARMASI
    public function penjualan_cetak_nota_farmmasi($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.penjualan.percetakan-nota-farmasi', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // DATA OBAT
    public function manajemen_farmasi_data_obat($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.manajemen.data-obat', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // DATA MASUK DAN KELUAR
    public function manajemen_farmasi_obat_in_out($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.manajemen.obat-in-out', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // DATA MASUK DAN KELUAR
    public function manajemen_farmasi_stock_min_max($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.manajemen.stox-min-max', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

}
