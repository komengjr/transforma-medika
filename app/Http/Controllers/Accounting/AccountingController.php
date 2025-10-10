<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;

class AccountingController extends Controller
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
    public function general_ledger($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('app-accounting.general-ledger', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function general_ledger_search(Request $request)
    {
        return view('app-accounting.general-ledger.data-search-ledger');
    }
    public function ledger_report($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('app-accounting.ledger-report', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function statement_profit_loss($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('app-accounting.profit-loss-statement', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function statement_balance_sheet($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('app-accounting.balance-sheet', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function statement_capital_statement($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('app-accounting.capital-statement', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // MASTER COA
    public function master_accounting_coa($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $total = DB::table('acc_master_coa_data')->where('acc_coa_data_opt',0)->count();
            $data = DB::table('acc_master_coa')->get();
            return view('app-accounting.master.master-coa', [
                'akses' => $akses,
                'code' => $id,
                'total' => $total,
                'data' => $data
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_accounting_coa_add_level(Request $request)
    {
        return view('app-accounting.master.form.form-add-level-coa', [
            'level' => $request->level,
            'code' => $request->code,
            'nomor' => $request->nomor
        ]);
    }
    public function master_accounting_coa_save_level(Request $request)
    {
        try {
            $total = DB::table('acc_master_coa_data')->where('acc_master_coa_code', $request->code)->count();
            DB::table('acc_master_coa_data')->insert([
                'acc_coa_data_code' => $request->code . str_pad($total + 1, 3, '0', STR_PAD_LEFT),
                'acc_master_coa_code' => $request->code,
                'acc_coa_data_no' => $request->nomor,
                'acc_coa_data_name' => $request->name,
                'acc_coa_data_type' => 1,
                'acc_coa_data_level' => $request->level,
                'acc_coa_data_opt' => $request->option,
                'acc_coa_data_status' => 1,
                'created_at' => now()
            ]);
            return 'berhasil Input';
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function master_accounting_coa_update_level(Request $request)
    {
        $data = DB::table('acc_master_coa_data')->where('acc_coa_data_code', $request->code)->first();
        return view('app-accounting.master.form.form-update-level-coa', ['data' => $data]);
    }
    public function master_accounting_coa_update_save_level(Request $request)
    {
        DB::table('acc_master_coa_data')->where('acc_coa_data_code', $request->code)->update([
            'acc_coa_data_name' => $request->name,
            'acc_coa_data_opt' => $request->option,
        ]);
        return 123;
    }
}
