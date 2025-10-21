<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class dashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('dashboard', ['akses' => '213']);
        // return view('dashboard.index',['akses'=>'213']);
    }
    public function profile()
    {
        return view('dashboard.profile', ['akses' => 123]);
    }
    public function setting()
    {
        return view('dashboard.setting');
    }
    public function news()
    {
        return view('dashboard.news');
    }
    public function actifity()
    {
        return view('dashboard.actifity');
    }
    public function app_check_menu(Request $request)
    {
        $cek = DB::table('z_menu_super')->where('menu_super_code', $request->code)->first();
        if ($cek) {
            return url('console/' . $request->code . '/dashboard');
        } else {
            return route('dashboard.home');
        }
    }
    public function dashboard_all($id)
    {
        if ($id == 'hrm') {
            return view('app-hrm.dashboard', ['akses' => $id, 'code' => $id]);
        } elseif ($id == 'medical') {
            return view('application.dashboard', ['akses' => $id, 'code' => $id]);
        } elseif ($id == 'accounting') {
            return view('app-accounting.dashboard', ['akses' => $id, 'code' => $id]);
        } elseif ($id == 'inventaris') {
            return view('app-inventaris.dashboard', ['akses' => $id, 'code' => $id]);
        } elseif ($id == 'logistik') {
            return view('app-logistik.dashboard', ['akses' => $id, 'code' => $id]);
        } elseif ($id == 'pembelian') {
            return view('app-pembelian.dashboard', ['akses' => $id, 'code' => $id]);
        } elseif ($id == 'supplier') {
            return view('app-supplier.dashboard', ['akses' => $id, 'code' => $id]);
        } elseif ($id == 'brodcast') {
            return view('app-brodcast.dashboard', ['akses' => $id, 'code' => $id]);
        } elseif ($id == 'farmasi') {
            return view('app-farmasi.dashboard', ['akses' => $id, 'code' => $id]);
        } else {

            return Redirect::to('dashboard/home');
        }
    }
    public function dashboard_medica()
    {

    }
}
