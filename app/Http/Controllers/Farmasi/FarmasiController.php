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
use PhpParser\Node\Stmt\TryCatch;

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
    // DATA PEMBELIAN PO
    public function manajemen_farmasi_pembelian_obat($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.manajemen.pembelian-purchase-order', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // DATA PENERIMAAN BARANG PO
    public function manajemen_farmasi_penerimaan_barang($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.manajemen.penerimaan-barang', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // PEMBUATAN FAKTUR
    public function manajemen_farmasi_pembuatan_faktur($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.manajemen.pembuatan-faktur', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // RIWAYAT TRANSAKSI
    public function manajemen_farmasi_riwayat_transaksi($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.manajemen.riwayat-transaksi-po', ['data' => $data, 'akses' => $akses, 'code' => $id]);
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
    public function manajemen_farmasi_data_obat_add(Request $requestq)
    {
        return view('app-farmasi.manajemen.master-obat.form-add');
    }
    public function manajemen_farmasi_data_obat_save(Request $request)
    {
        try {
            DB::table('farm_data_obat')->insert([
                'farm_data_obat_code' => str::uuid(),
                'farm_data_obat_name' => $request->name,
                'farm_data_obat_cat' => $request->kategori,
                'farm_data_obat_jenis' => $request->jenis,
                'farm_data_obat_satuan' => $request->satuan,
                'farm_data_obat_stok' => 0,
                'farm_data_obat_stok_minimum' => $request->stok_min,
                'created_at' => now()
            ]);
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.manajemen.master-obat.data-table-obat', ['data' => $data]);
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function manajemen_farmasi_data_obat_update(Request $request)
    {
        $data = DB::table('farm_data_obat')->where('farm_data_obat_code', $request->code)->first();
        return view('app-farmasi.manajemen.master-obat.form-update', ['data' => $data]);
    }
    public function manajemen_farmasi_data_obat_update_save(Request $request)
    {
        try {
            DB::table('farm_data_obat')->where('farm_data_obat_code', $request->code)->update([
                'farm_data_obat_name' => $request->name,
                'farm_data_obat_cat' => $request->kategori,
                'farm_data_obat_jenis' => $request->jenis,
                'farm_data_obat_satuan' => $request->satuan,
                'farm_data_obat_stok' => 0,
                'farm_data_obat_stok_minimum' => $request->stok_min,
                'updated_at' => now()
            ]);
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.manajemen.master-obat.data-table-obat', ['data' => $data]);
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function manajemen_farmasi_data_obat_add_batch(Request $request)
    {
        return view('app-farmasi.manajemen.master-obat.form-add-batch', ['code' => $request->code]);
    }
    public function manajemen_farmasi_data_obat_save_batch(Request $request)
    {
        try {
            DB::table('farm_data_obat_exp')->insert([
                'farm_data_obat_exp_code' => str::uuid(),
                'farm_data_obat_code' => $request->code,
                'pem_grn_token_code' => $request->grn,
                'data_obat_tanggal_masuk' => $request->masuk,
                'data_obat_tanggal_exp' => $request->exp,
                'data_obat_stok' => $request->stok,
                'data_obat_rak' => $request->rak,
                'created_at' => now()
            ]);
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.manajemen.master-obat.data-table-obat', ['data' => $data]);
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function manajemen_farmasi_data_obat_batch_detail(Request $request)
    {
        $data = DB::table('farm_data_obat_exp')->where('farm_data_obat_code', $request->code)->get();
        return view('app-farmasi.manajemen.master-obat.form-batch-detail', ['data' => $data]);
    }
    public function manajemen_farmasi_data_obat_obat_detail(Request $request){
        return 123;
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
    // DATA SUPPLIER
    public function manajemen_farmasi_data_supplier($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.manajemen.master-data-supplier', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // DATA SUPPLIER
    public function manajemen_farmasi_data_pelanggan($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.manajemen.master-data-pelanggan', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

}
