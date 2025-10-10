<?php

namespace App\Http\Controllers;

use App\Imports\DataHargaPenjualan;
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

class MasterDataController extends Controller
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
    // MASTER DOKTER
    public function master_doctor_data_doctor($akses)
    {
        if ($this->url_akses_sub($akses) == true) {
            $data = DB::table('master_doctor')->get();
            return view('application.master-data.master-data-doctor', ['akses' => $akses, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_doctor_data_doctor_add(Request $request)
    {
        return view('application.master-data.data-doctor.form-add');
    }
    public function master_doctor_data_doctor_save(Request $request)
    {
        DB::table('master_doctor')->insert([
            'master_doctor_code' => str::uuid(),
            'master_doctor_nik' => $request->nik,
            'master_doctor_title_f' => $request->awal,
            'master_doctor_name' => $request->name,
            'master_doctor_title_e' => $request->akhir,
            'master_doctor_jk' => $request->jk,
            'master_doctor_hp' => $request->no_hp,
            'master_doctor_email' => $request->email,
            'master_doctor_profile' => 'img/profile-doctor.png',
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Dokter');
    }
    // MASTER DOKTER POLIKLINIK
    public function master_doctor_poliklinik($akses)
    {
        if ($this->url_akses_sub($akses) == true) {
            $data = DB::table('m_poli')->get();
            $layanan = DB::table('t_layanan_data')
                ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 't_layanan_data.t_layanan_cat_code')
                ->where('t_layanan_cat.t_layanan_cat_name', 'POLIKLINIK')->get();
            return view('application.master-data.master-doctor-poliklinik', ['data' => $data, 'layanan' => $layanan, 'akses' => $akses]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_doctor_poliklinik_add(Request $request)
    {
        return view('application.master-data.data-doctor-poli.form-add');
    }
    public function master_doctor_poliklinik_save(Request $request)
    {
        DB::table('m_poli')->insert([
            'm_poli_code' => str::uuid(),
            'm_poli_name' => $request->name,
            'm_poli_type' => 1,
            'm_poli_status' => 1,
            'created_at' => now(),
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Poli Dokter');
    }
    public function master_doctor_poliklinik_pilih_dokter(Request $request)
    {
        $data = DB::table('master_doctor')->get();
        return view('application.master-data.data-doctor-poli.form-add-doctor', ['data' => $data, 'code' => $request->code]);
    }
    public function master_doctor_poliklinik_pilih_dokter_save(Request $request)
    {
        $cek = DB::table('m_doctor_poli')->where('master_doctor_code', $request->dokter)->first();
        if ($cek) {
            return redirect()->back()->withError('Filed! Gagal Menambahkan Data Dokter');
        } else {
            DB::table('m_doctor_poli')->insert([
                'm_doctor_poli_code' => str::uuid(),
                't_layanan_data_code' => $request->code,
                'master_doctor_code' => $request->dokter,
                'created_at' => now()
            ]);
            return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Dokter');
        }
    }
    // MASTER JADWAL DOKTER
    public function master_jadwal_doctor_poliklinik($akses)
    {
        if ($this->url_akses_sub($akses) == true) {
            $data = DB::table('m_poli')->get();
            return view('application.master-data.master-doctor-poli-jadwal', ['akses' => $akses, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // MASTER KATEGORI DOKTER
    public function master_pemeriksaan_category($akses)
    {
        if ($this->url_akses_sub($akses) == true) {
            $data = DB::table('t_pemeriksaan_cat')->get();
            return view('application.master-data.master-pemeriksaan-category', ['akses' => $akses, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_pemeriksaan_category_add(Request $request)
    {
        return view('application.master-data.pemeriksaan-category.form-add');
    }
    public function master_pemeriksaan_category_save(Request $request)
    {
        $no = DB::table('t_pemeriksaan_cat')->count();
        DB::table('t_pemeriksaan_cat')->insert([
            't_pemeriksaan_cat_code' => 'PEM' . str_pad($no + 1, 4, '0', STR_PAD_LEFT),
            't_pemeriksaan_cat_name' => $request->nama,
            't_pemeriksaan_cat_status' => 1,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Kategori Pemeriksaan');
    }
    // MASTER DATA PEMERIKSAAN
    public function master_pemeriksaan_data($akses)
    {
        if ($this->url_akses_sub($akses) == true) {
            $data = DB::table('t_pemeriksaan_data')
                ->join('t_pemeriksaan_cat', 't_pemeriksaan_cat.t_pemeriksaan_cat_code', '=', 't_pemeriksaan_data.t_pemeriksaan_cat_code')
                ->get();
            return view('application.master-data.master-pemeriksaan-data', ['akses' => $akses, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_pemeriksaan_data_add(Request $request)
    {
        $cat = DB::table('t_pemeriksaan_cat')->get();
        return view('application.master-data.pemeriksaan-data.form-add', ['cat' => $cat]);
    }
    public function master_pemeriksaan_data_save(Request $request)
    {
        $no = DB::table('t_pemeriksaan_data')->count();
        DB::table('t_pemeriksaan_data')->insert([
            't_pemeriksaan_data_code' => $request->code . '' . date('YmdHis') . str_pad($no + 1, 4, '0', STR_PAD_LEFT),
            't_pemeriksaan_cat_code' => $request->code,
            't_pemeriksaan_data_name' => $request->name,
            't_pemeriksaan_data_status' => 1,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Kategori Pemeriksaan');
    }
    // MASTER GROUP PEMERIKSAAN
    public function master_pemeriksaan_group($akses)
    {
        if ($this->url_akses_sub($akses) == true) {
            $data = DB::table('t_pemeriksaan_data')
                ->join('t_pemeriksaan_cat', 't_pemeriksaan_cat.t_pemeriksaan_cat_code', '=', 't_pemeriksaan_data.t_pemeriksaan_cat_code')
                ->get();
            $layanan = DB::table('t_pemeriksaan_cat')->get();
            return view('application.master-data.master-pemeriksaan-group', ['akses' => $akses, 'data' => $data, 'layanan' => $layanan]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_pemeriksaan_group_layanan(Request $request)
    {
        $data = DB::table('t_pemeriksaan_data')->where('t_pemeriksaan_cat_code', $request->code)->get();
        return view('application.master-data.pemeriksaan-group.option-pemeriksaan', ['data' => $data]);
    }
    public function master_pemeriksaan_group_pilih_pemeriksaan(Request $request)
    {
        $data = DB::table('t_pemeriksaan_list')->where('t_pemeriksaan_data_code', $request->code)->get();
        return view('application.master-data.pemeriksaan-group.data-table-pemeriksaan', ['code' => $request->code, 'data' => $data]);
    }
    public function master_pemeriksaan_group_add_pemeriksaan(Request $request)
    {
        return view('application.master-data.pemeriksaan-group.form-add-list-pemeriksaan', ['code' => $request->code]);
    }
    public function master_pemeriksaan_group_add_pemeriksaan_save(Request $request)
    {
        $no = DB::table('t_pemeriksaan_list')->where('t_pemeriksaan_data_code', $request->code)->count();
        DB::table('t_pemeriksaan_list')->insert([
            't_pemeriksaan_list_code' => $request->code . str_pad($no + 1, 5, '0', STR_PAD_LEFT),
            't_pemeriksaan_data_code' => $request->code,
            't_pemeriksaan_list_name' => $request->name,
            't_pemeriksaan_list_option' => $request->jenis,
            't_pemeriksaan_list_type' => $request->type,
            't_pemeriksaan_list_status' => 1,
            'created_at' => now(),
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data List Pemeriksaan');
    }
    public function master_pemeriksaan_group_add_value_pemeriksaan(Request $request)
    {
        return view('application.master-data.pemeriksaan-group.form-add-value', ['code' => $request->code]);
    }
    public function master_pemeriksaan_group_add_value_pemeriksaan_save(Request $request)
    {
        $no = DB::table('t_pemeriksaan_list_val')->where('t_pemeriksaan_list_code', $request->code)->count();
        DB::table('t_pemeriksaan_list_val')->insert([
            't_pem_list_val_code' => $request->code . str_pad($no + 1, 5, '0', STR_PAD_LEFT),
            't_pemeriksaan_list_code' => $request->code,
            't_pem_list_val_name' => $request->name,
            't_pem_list_val_nilai' => 0,
            't_pem_list_val_rujukan' => $request->rujukan,
            't_pem_list_val_satuan' => $request->satuan,
            'created_at' => now(),
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data List Pemeriksaan');
    }
    // MASTER HARGA PEMERIKSAAN
    public function master_pemeriksaan_harga($akses)
    {
        if ($this->url_akses_sub($akses) == true) {
            $data = DB::table('p_m_pemeriksaan')->get();
            $cat = DB::table('t_pemeriksaan_cat')->get();
            return view('application.master-data.master-pemeriksaan-harga', ['data' => $data, 'cat' => $cat, 'akses' => $akses]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_pemeriksaan_harga_master(Request $request)
    {
        $data = DB::table('p_pemeriksaan')->where('p_m_pemeriksaan_code', $request->code)->get();
        return view('application.master-data.pemeriksaan-harga.form-paket-pemeriksaan', ['data' => $data]);
    }
    public function master_pemeriksaan_harga_group(Request $request)
    {
        $data = DB::table('p_pemeriksaan')->where('p_m_pemeriksaan_code', $request->code)->get();
        $layanan = DB::table('t_layanan_cat')->get();
        return view('application.master-data.pemeriksaan-harga.data-gorup-pemeriksaan', ['data' => $data, 'layanan' => $layanan]);
    }
    // MASTER SPECIMEN PEMERIKSAAN
    public function master_pemeriksaan_specimen($akses)
    {
        if ($this->url_akses_sub($akses) == true) {

            $cat = DB::table('t_pemeriksaan_cat')->get();
            $data = DB::table('t_pemeriksaan_data')
                ->join('t_pemeriksaan_cat', 't_pemeriksaan_cat.t_pemeriksaan_cat_code', '=', 't_pemeriksaan_data.t_pemeriksaan_cat_code')
                ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_data_code', '=', 't_pemeriksaan_data.t_pemeriksaan_data_code')
                ->get();
            return view('application.master-data.master-pemeriksaan-specimen', [
                'data' => $data,
                'cat' => $cat,
                'akses' => $akses,
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_pemeriksaan_specimen_detail(Request $request)
    {
        $specimen = DB::table('s_specimen_data')->get();
        $data = DB::table('t_pem_specimen')
            ->join('s_specimen_data', 's_specimen_data.s_specimen_data_code', '=', 't_pem_specimen.s_specimen_data_code')
            ->where('t_pem_specimen.t_pemeriksaan_list_code', $request->code)->get();
        return view('application.master-data.pemeriksaan-specimen.data-specimen', ['specimen' => $specimen, 'code' => $request->code, 'data' => $data]);
    }
    public function master_pemeriksaan_specimen_save(Request $request)
    {
        $cek = DB::table('t_pem_specimen')->where('s_specimen_data_code', $request->specimen)->where('t_pemeriksaan_list_code', $request->code)->first();
        if ($cek) {
            return 0;
        } else {
            DB::table('t_pem_specimen')->insert([
                't_pem_specimen_code' => str::uuid(),
                's_specimen_data_code' => $request->specimen,
                't_pemeriksaan_list_code' => $request->code,
                't_pem_specimen_status' => 1,
                'created_at' => now()
            ]);
            $data = DB::table('t_pem_specimen')
                ->join('s_specimen_data', 's_specimen_data.s_specimen_data_code', '=', 't_pem_specimen.s_specimen_data_code')
                ->where('t_pem_specimen.t_pemeriksaan_list_code', $request->code)->get();
            return view('application.master-data.pemeriksaan-specimen.detail-specimen', ['data' => $data]);
        }
    }
    // MASTER DATA PERUSAHAAN
    public function master_perusahaan_data($akses)
    {
        if ($this->url_akses_sub($akses) == true) {
            $data = DB::table('master_company')->get();
            return view('application.master-data.master-company', ['data' => $data, 'akses' => $akses]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // MASTER MOU PERUSAHAAN
    public function master_perusahaan_mou($akses)
    {
        if ($this->url_akses_sub($akses) == true) {
            $data = DB::table('company_mou')
                ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
                ->orderBy('id_company_mou', 'DESC')->get();
            return view('application.master-data.mou-company', ['data' => $data, 'akses' => $akses]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // MASTER LAYANAN KATEGORI
    public function master_layanan_category($akses)
    {
        if ($this->url_akses_sub($akses) == true) {
            $data = DB::table('t_layanan_cat')->get();
            return view('application.master-data.master-layanan-category', ['data' => $data, 'akses' => $akses]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_layanan_category_add(Request $request)
    {
        return view('application.master-data.layanan-category.form-add');
    }
    public function master_layanan_category_save(Request $request)
    {
        DB::table('t_layanan_cat')->insert([
            't_layanan_cat_code' => str::uuid(),
            't_layanan_cat_name' => $request->name,
            't_layanan_cat_status' => 1,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Kategori Layanan');
    }
    // MASTER LAYANAN DATA
    public function master_layanan_data($akses)
    {
        if ($this->url_akses_sub($akses) == true) {
            $data = DB::table('t_layanan_data')
                ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 't_layanan_data.t_layanan_cat_code')
                ->get();
            return view('application.master-data.master-layanan-data', ['data' => $data, 'akses' => $akses]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_layanan_data_add(Request $request)
    {
        $layanan = DB::table('t_layanan_cat')->get();
        return view('application.master-data.layanan-data.form-add', ['layanan' => $layanan]);
    }
    public function master_layanan_data_save(Request $request)
    {
        DB::table('t_layanan_data')->insert([
            't_layanan_data_code' => str::uuid(),
            't_layanan_cat_code' => $request->code,
            't_layanan_data_name' => $request->name,
            't_layanan_data_status' => 1,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Layanan');
    }
    // FORMULIR LAYANAN
    public function master_layanan_formulir($akses)
    {
        if ($this->url_akses_sub($akses) == true) {
            $data = DB::table('t_layanan_form')
                ->join('t_layanan_data', 't_layanan_data.t_layanan_data_code', '=', 't_layanan_form.t_layanan_data_code')
                ->get();
            // dd($data);
            return view('application.master-data.master-layanan-formulir', ['data' => $data, 'akses' => $akses]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_layanan_formulir_add(Request $request)
    {
        $layanan = DB::table('t_layanan_data')->get();
        return view('application.master-data.layanan-formulir.form-add', ['layanan' => $layanan]);
    }
    public function master_layanan_formulir_save(Request $request)
    {
        DB::table('t_layanan_form')->insert([
            't_layanan_form_code' => str::uuid(),
            't_layanan_data_code' => $request->code,
            't_layanan_form_name' => $request->name,
            't_layanan_form_jenis' => '-',
            't_layanan_form_type' => '-',
            't_layanan_form_status' => '1',
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Layanan');
    }
    public function master_layanan_formulir_add_field(Request $request)
    {
        return view('application.master-data.layanan-formulir.form-add-field', ['code' => $request->code]);
    }
    public function master_layanan_formulir_save_field(Request $request)
    {
        DB::table('t_layanan_form_f')->insert([
            't_layanan_form_f_code' => str::uuid(),
            't_layanan_form_code' => $request->code,
            't_layanan_form_f_name' => $request->name,
            't_layanan_form_f_type' => $request->type,
            't_layanan_form_f_number' => 0,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Layanan');
    }
    // MASTER PENJUALAN DATA
    public function master_penjualan_data($akses)
    {
        if ($this->url_akses_sub($akses) == true) {
            $data = DB::table('p_m_sales')->get();
            return view('application.master-data.master-penjualan-data', ['data' => $data, 'akses' => $akses]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_penjualan_data_master(Request $request)
    {
        $data = DB::table('p_sales')->where('p_m_sales_code', $request->code)->get();
        return view('application.master-data.penjualan-data.form-paket-penjualan', ['data' => $data]);
    }
    public function master_penjualan_data_group(Request $request)
    {
        $data = DB::table('p_sales_cat')
            ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'p_sales_cat.t_layanan_cat_code')
            ->where('p_sales_cat.p_sales_code', $request->code)->get();
        $layanan = DB::table('t_layanan_cat')->get();
        $harga = DB::table('p_sales_data')->join('p_sales_cat', 'p_sales_cat.p_sales_cat_code', '=', 'p_sales_data.p_sales_cat_code')
            ->join('p_sales', 'p_sales.p_sales_code', '=', 'p_sales_cat.p_sales_code')
            ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'p_sales_cat.t_layanan_cat_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('p_sales.p_sales_code', $request->code)->get();
        return view('application.master-data.penjualan-data.data-group-penjualan', ['data' => $data, 'code' => $request->code, 'harga' => $harga]);
    }
    public function master_penjualan_data_add(Request $request)
    {
        $data = DB::table('p_sales_cat')
            ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'p_sales_cat.t_layanan_cat_code')
            ->where('p_sales_cat.p_sales_cat_code', $request->id)->first();
        $pemeriksaan = DB::table('t_pemeriksaan_list')->get();
        return view('application.master-data.penjualan-data.form-add-data', [
            'code' => $request->code,
            'id' => $request->id,
            'data' => $data,
            'pemeriksaan' => $pemeriksaan
        ]);
    }
    public function master_penjualan_data_save(Request $request)
    {
        DB::table('p_sales_data')->insert([
            'p_sales_data_code' => str::uuid(),
            'p_sales_cat_code' => $request->code_kategori,
            'p_sales_data_name' => $request->name,
            't_pemeriksaan_list_code' => $request->name,
            'p_sales_data_type' => $request->type,
            'p_sales_data_price' => $request->price,
            'p_sales_data_disc' => $request->disc,
            'p_sales_data_desc' => $request->desc,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Layanan');
    }
    public function master_penjualan_data_import(Request $request)
    {
        $data = DB::table('p_sales_cat')
            ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'p_sales_cat.t_layanan_cat_code')
            ->where('p_sales_cat.p_sales_cat_code', $request->code)->first();
        return view('application.master-data.penjualan-data.form-import-data', ['code' => $request->code, 'data' => $data]);
    }
    public function master_penjualan_data_import_save(Request $request)
    {
        Excel::import(new DataHargaPenjualan($request->code), request()->file('file'));
        return redirect()->back()->withSuccess('Great! Upload Data Pemeriksaan');
    }
    // PENJUALAN KATEGORI
    public function master_penjualan_kategori($akses)
    {
        if ($this->url_akses_sub($akses) == true) {
            $data = DB::table('p_sales')->get();
            return view('application.master-data.master-penjualan-kategori', ['data' => $data, 'akses' => $akses]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_penjualan_kategori_add_kategori(Request $request)
    {
        $data = DB::table('t_layanan_cat')->get();
        return view('application.master-data.penjualan-kategori.form-add-kategori', ['code' => $request->code, 'data' => $data]);
    }
    public function master_penjualan_kategori_save_kategori(Request $request)
    {
        $total = DB::table('p_sales_cat')->where('p_sales_code', $request->code)->count();
        DB::table('p_sales_cat')->insert([
            'p_sales_cat_code' => $request->code . '' . str_pad($total + 1, 4, '0', STR_PAD_LEFT),
            'p_sales_code' => $request->code,
            't_layanan_cat_code' => $request->layanan,
            'p_sales_cat_name' => $request->name,
            'created_at' => now(),
        ]);
        return redirect()->back()->withSuccess('Great! Menambahkan data Kategori');
    }
}
