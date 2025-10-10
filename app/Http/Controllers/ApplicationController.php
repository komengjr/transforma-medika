<?php

namespace App\Http\Controllers;

use App\Imports\PesertaAllImport;
use App\Imports\PesertaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;
use Session;
class ApplicationController extends Controller
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

    // COMPANY MASTER
    public function master_company($akses)
    {
        if ($this->url_akses($akses) == true) {
            $data = DB::table('master_company')->get();
            return view('application.master-data.master-company', ['data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_company_add_company(Request $request)
    {
        return view('application.master-data.company.form-add');
    }
    public function master_company_add_company_save(Request $request)
    {
        $total = DB::table('master_company')->count();
        DB::table('master_company')->insert([
            'master_company_code' => 'CMP' . date('Ymd') . '' . str_pad($total + 1, 4, '0', STR_PAD_LEFT),
            'master_company_name' => $request->name,
            'master_company_wilayah' => $request->lokasi,
            'master_company_nat' => 0,
            'master_company_type' => $request->type,
            'master_company_phone' => $request->phone,
            'master_company_email' => $request->email,
            'master_company_level' => 0,
            'master_company_status' => 0,
            'master_company_user' => Auth::user()->userid,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Perusahaan');
    }
    public function master_company_edit_company(Request $request)
    {
        $data = DB::table('master_company')->where('master_company_code', $request->code)->first();
        return view('application.master-data.company.form-edit', ['data' => $data]);
    }
    public function master_company_edit_company_save(Request $request)
    {
        return redirect()->back()->withSuccess('Great! Berhasil update Data Perusahaan');
    }
    public function master_company_data_mou_company(Request $request)
    {
        $data = DB::table('company_mou')
            ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.master_company_code', $request->code)
            ->orderBy('id_company_mou', 'DESC')->get();
        return view('application.master-data.company.data-mou-company', ['data' => $data]);
    }

    // COMPANY MOU
    public function mou_company($akses)
    {
        if ($this->url_akses($akses) == true) {
            $data = DB::table('company_mou')
                ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
                ->orderBy('id_company_mou', 'DESC')->get();
            return view('application.master-data.mou-company', ['data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function mou_company_add(Request $request)
    {
        $data = DB::table('master_company')
            ->get();
        return view('application.master-data.mou-company.form-add', ['data' => $data]);
    }
    public function mou_company_save(Request $request)
    {
        $total = DB::table('company_mou')->where('master_company_code', $request->perusahaan)->count();
        DB::table('company_mou')->insert([
            'company_mou_code' => $request->perusahaan . '' . str_pad($total + 1, 4, '0', STR_PAD_LEFT),
            'master_company_code' => $request->perusahaan,
            'company_mou_name' => $request->nama,
            'company_mou_peserta' => $request->peserta,
            'company_mou_start' => $request->start,
            'company_mou_end' => $request->end,
            'company_mou_status' => 0,
            'created_at' => now(),
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data MOU Perusahaan');
    }
    public function mou_company_peserta_mcu(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        $peserta = DB::table('company_mou_peserta')->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_peserta.company_mou_code')
            ->where('company_mou_peserta.company_mou_code', $request->code)->get();
        return view('application.master-data.mou-company.data-peserta-mcu', ['data' => $data, 'peserta' => $peserta]);
    }
    public function mou_company_insert_peserta_mcu(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        return view('application.master-data.mou-company.form-insert-peserta', ['data' => $data]);
    }
    public function mou_company_insert_peserta_mcu_manual(Request $request)
    {
        $data = DB::table('company_mou_agreement')->where('company_mou_code', $request->code)->get();
        return view('application.master-data.mou-company.form-add-peserta', ['code' => $request->code, 'data' => $data]);
    }
    public function mou_company_insert_peserta_mcu_manual_save(Request $request)
    {
        DB::table('company_mou_peserta')->insert([
            'mou_peserta_code' => $request->code . mt_rand(1000, 9999),
            'company_mou_code' => $request->code,
            'mou_peserta_nik' => $request->nik,
            'mou_peserta_nip' => $request->nip,
            'mou_peserta_name' => $request->nama,
            'mou_peserta_ttl' => $request->ttl,
            'mou_peserta_jk' => $request->jk,
            'mou_peserta_no_hp' => $request->no_hp,
            'mou_peserta_email' => $request->email,
            'mou_peserta_departemen' => $request->departemen,
            'mou_agreement_code' => $request->agreement,
            'mou_peserta_status' => 0,
            'created_at' => now(),
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data MOU Perusahaan');
    }
    public function mou_company_insert_peserta_mcu_upload(Request $request)
    {
        $data = DB::table('company_mou_agreement')->where('company_mou_code', $request->code)->get();
        return view('application.master-data.mou-company.form-upload-excel', ['code' => $request->code, 'data' => $data]);
    }
    public function mou_company_insert_peserta_mcu_upload_save(Request $request)
    {
        Excel::import(new PesertaImport($request->code, $request->id), request()->file('file'));
        return redirect()->back();
    }
    public function mou_company_insert_all_peserta_mcu_upload(Request $request)
    {
        $data = DB::table('company_mou_agreement')->where('company_mou_code', $request->code)->get();
        return view('application.master-data.mou-company.form-upload-excel-all', ['code' => $request->code, 'data' => $data]);
    }
    public function mou_company_insert_all_peserta_mcu_upload_save(Request $request)
    {
        Excel::import(new PesertaAllImport($request->code), request()->file('file'));
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Perusahaan');
    }
    public function mou_company_insert_pemeriksaan_mcu(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
            ->where('company_mou.company_mou_code', $request->code)->first();
        $pemeriksaan = DB::table('master_pemeriksaan')->get();
        return view('application.master-data.mou-company.form-insert-pemeriksaan', ['data' => $data, 'pemeriksaan' => $pemeriksaan]);
    }
    public function mou_company_insert_pemeriksaan_mcu_insert(Request $request)
    {
        DB::table('company_mou_pemeriksaan')->insert([
            'mou_pemeriksaan_code' => str::uuid(),
            'company_mou_code' => $request->code,
            'master_pemeriksaan_code' => $request->id,
            'created_at' => now()
        ]);
        return 'sukses';
    }
    public function mou_company_activasi_mou(Request $request)
    {
        return view('application.master-data.mou-company.form-activasi-mou', ['code' => $request->code]);
    }
    public function mou_company_activasi_mou_save(Request $request)
    {
        $peserta = DB::table('company_mou_peserta')->where('company_mou_code', $request->code)->first();
        $paket = DB::table('company_mou_agreement')->where('company_mou_code', $request->code)->first();
        if ($peserta || $paket) {
            DB::table('company_mou')->where('company_mou_code', $request->code)->update([
                'company_mou_status' => 1
            ]);
            return redirect()->back()->withSuccess('Great! Berhasil Aktivasi Data MOU Perusahaan');
        } else {
            return redirect()->back()->withError('Gagal! Peserta dan Pemilihan Paket TIdak Boleh Kosong');
        }
    }

    // AGREEMENT PERUSAHAAN
    public function agreement_perusahaan($akses)
    {
        if ($this->url_akses($akses) == true) {
            $data = DB::table('company_mou_agreement')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_agreement.company_mou_code')
                ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
                ->get();
            return view('application.master-data.agreement-perusahaan', ['data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function agreement_perusahaan_add(Request $request)
    {
        $data = DB::table('company_mou')->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')->get();
        return view('application.master-data.agreement.form-add', ['data' => $data]);
    }
    public function agreement_perusahaan_save(Request $request)
    {
        DB::table('company_mou_agreement')->insert([
            'mou_agreement_code' => str::uuid(),
            'company_mou_code' => $request->code,
            'mou_agreement_name' => $request->nama,
            'mou_agreement_status' => 1,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data MOU Perusahaan');
    }
    public function agreement_perusahaan_update(Request $request)
    {
        $data = DB::table('company_mou_agreement')->where('mou_agreement_code', $request->code)->first();
        return view('application.master-data.agreement.form-update', ['data' => $data]);
    }
    public function agreement_perusahaan_update_save(Request $request)
    {
        DB::table('company_mou_agreement')->where('mou_agreement_code', $request->code)->update([
            'mou_agreement_name' => $request->nama,
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Perusahaan');
    }
    public function agreement_perusahaan_add_pemeriksaan(Request $request)
    {
        $pemeriksaan = DB::table('master_pemeriksaan')->get();
        $data = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->where('company_mou_agreement_sub.mou_agreement_code', $request->code)->get();
        return view('application.master-data.agreement.form-add-pemeriksaan', ['pemeriksaan' => $pemeriksaan, 'code' => $request->code, 'data' => $data]);
    }
    public function agreement_perusahaan_save_pemeriksaan(Request $request)
    {
        DB::table('company_mou_agreement_sub')->insert([
            'mou_agreement_code' => $request->code,
            'master_pemeriksaan_code' => $request->id,
            'created_at' => now()
        ]);
        $data = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->where('company_mou_agreement_sub.mou_agreement_code', $request->code)->get();
        return view('application.master-data.agreement.table-pemeriksaan-mcu', ['data' => $data]);
    }
    public function agreement_perusahaan_remove_pemeriksaan(Request $request)
    {
        DB::table('company_mou_agreement_sub')->where('id_mou_agreement_sub', $request->id)->delete();
        $data = DB::table('company_mou_agreement_sub')
            ->join('master_pemeriksaan', 'master_pemeriksaan.master_pemeriksaan_code', '=', 'company_mou_agreement_sub.master_pemeriksaan_code')
            ->where('company_mou_agreement_sub.mou_agreement_code', $request->code)->get();
        return view('application.master-data.agreement.table-pemeriksaan-mcu', ['data' => $data]);
    }
    public function agreement_perusahaan_remove_agreement(Request $request)
    {
        DB::table('company_mou_agreement')->where('mou_agreement_code', $request->code)->delete();
        DB::table('company_mou_agreement_sub')->where('mou_agreement_code', $request->code)->delete();
        return 'Berhasil Remove';
    }

    // MASTER PEMERIKSAAN
    public function master_pemeriksaan($akses)
    {
        if ($this->url_akses($akses) == true) {
            $data = DB::table('master_pemeriksaan')->get();
            return view('application.master-data.master-pemeriksaan', ['data' => $data, 'akses' => $akses]);
        } else {
            return Redirect::to('dashboard/home');
        }

    }
    public function master_pemeriksaan_add(Request $request)
    {
        return view('application.master-data.pemeriksaan.form-add');
    }
    public function master_pemeriksaan_save(Request $request)
    {
        DB::table('master_pemeriksaan')->insert([
            'master_pemeriksaan_code' => str::uuid(),
            'master_pemeriksaan_name' => $request->nama,
            'master_pemeriksaan_status' => 1,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Pemeriksaan');
    }
    public function master_pemeriksaan_update(Request $request)
    {
        $data = DB::table('master_pemeriksaan')->where('master_pemeriksaan_code', $request->code)->first();
        return view('application.master-data.pemeriksaan.form-update', ['data' => $data]);
    }
    public function master_pemeriksaan_update_save(Request $request)
    {
        DB::table('master_pemeriksaan')->where('master_pemeriksaan_code', $request->code)->update([
            'master_pemeriksaan_name' => $request->nama
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Pemeriksaan');
    }
}
