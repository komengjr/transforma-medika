<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
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
    public function master_data_supplier($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('master_supplier')->orderBy('id_master_supplier', 'DESC')->get();
            return view('app-supplier.master.data-supplier', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_data_supplier_add(Request $request)
    {
        return view('app-supplier.master.data-supplier.form-add');
    }
    public function master_data_supplier_save(Request $request)
    {
        try {
            DB::table('master_supplier')->insert([
                'master_supplier_code' => 'SP' . date('ymdhis'),
                'master_supplier_name' => $request->name,
                'master_supplier_city' => $request->city,
                'master_supplier_alamat' => $request->alamat,
                'master_supplier_phone' => $request->phone,
                'master_supplier_email' => $request->mail,
                'master_supplier_status' => 0,
                'created_at' => now()
            ]);
            return 123;
        } catch (\Throwable $e) {
            return 0;
        }
    }
}
