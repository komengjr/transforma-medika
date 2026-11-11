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
    public function menu_farmasi_order_internal($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('app-farmasi.menu-farmasi.order-list-pasien-internal', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function getOrderInternalData(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');
        $kategori  = $request->input('kategori_layanan');
        $keyword   = $request->input('keyword');

        // 1. Query ke tabel medical_registrasi dengan relasinya
        $query = DB::table('medical_registrasi as r')
            ->join('medical_patient as p', 'r.pasien_id', '=', 'p.id')
            ->leftJoin('medical_master_doctor as d', 'r.doctor_poli_id', '=', 'd.id')
            ->leftJoin('medical_master_ruangan as ru', 'r.ruangan_id', '=', 'ru.id')
            ->leftJoin('medical_master_poli as po', 'r.poli_id', '=', 'po.id')
            // =========================================================================
            // FILTER UTAMA: HANYA TAMPILKAN JIKA PASIEN MEMILIKI ORDER RESEP OBAT
            // =========================================================================
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('medical_ranap_resep as rr')
                    ->whereColumn('rr.registrasi_id', 'r.id');
            })
            ->select(
                'r.id as registrasi_id',
                'r.no_registrasi',
                'r.tanggal_registrasi as tgl_order',
                'p.nama as nama_pasien',
                'p.pid',
                'r.jenis_layanan as kategori',
                DB::raw('COALESCE(ru.nama_ruangan, po.nama_poli, "IGD / Non-Ruangan") as nama_ruangan'),
                DB::raw('COALESCE(d.nama_lengkap, "-") as nama_dokter'),
                'r.status_kunjungan as status_order'
            );

        // 2. Filter Rentang Tanggal
        if (!empty($startDate) && !empty($endDate)) {
            $query->whereDate('r.tanggal_registrasi', '>=', $startDate)
                ->whereDate('r.tanggal_registrasi', '<=', $endDate);
        }

        // 3. Filter Kategori (Konversi nilai frontend ke ENUM tabel)
        if (!empty($kategori) && $kategori !== 'ALL') {
            $enumLayanan = $kategori;
            if ($kategori === 'RANAP') {
                $enumLayanan = 'RAWAT_INAP';
            } elseif ($kategori === 'POLIKLINIK') {
                $enumLayanan = 'RAWAT_JALAN';
            }
            $query->where('r.jenis_layanan', $enumLayanan);
        }

        // 4. Filter Pencarian Keyword (No Reg, Nama Pasien, RM)
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('r.no_registrasi', 'LIKE', "%{$keyword}%")
                    ->orWhere('p.nama', 'LIKE', "%{$keyword}%")
                    ->orWhere('p.pid', 'LIKE', "%{$keyword}%");
            });
        }

        // Ambil data terbaru di atas
        $data = $query->orderBy('r.tanggal_registrasi', 'DESC')->get();

        // 5. Format kembalian DataTables
        return response()->json([
            'draw'            => intval($request->input('draw')),
            'recordsTotal'    => $data->count(),
            'recordsFiltered' => $data->count(),
            'data'            => $data
        ]);
    }

    public function getDetailOrderInternal(Request $request)
    {
        $registrasiId = $request->input('registrasi_id');
        $kategori     = $request->input('kategori'); // RAWAT_INAP, RAWAT_JALAN, atau IGD

        try {
            // Catatan: Jika resep IGD/Poli memiliki tabel yang berbeda (misal: medical_rajal_resep),
            // Anda dapat menggunakan kondisi IF($kategori == 'RAWAT_JALAN') di sini.
            // Untuk saat ini disesuaikan dengan tabel resep rawat inap yang kita bangun sebelumnya.
            $dataObat = DB::table('medical_ranap_resep as rr')
                ->join('farm_data_obat as fo', 'rr.farm_data_obat_code', '=', 'fo.farm_data_obat_code')
                ->select(
                    'fo.farm_data_obat_code', // <--- TAMBAHKAN INI
                    'fo.farm_data_obat_name as nama_obat',
                    'rr.qty',
                    'rr.signa',
                    'rr.harga'
                )
                ->where('rr.registrasi_id', $registrasiId)
                ->get();

            return response()->json([
                'success' => true,
                'data'    => $dataObat
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail order obat: ' . $e->getMessage()
            ]);
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
    public function penjualan_non_resep_cari_data(Request $request)
    {
        try {
            $data = DB::table('farm_data_obat')
                ->join('farm_data_obat_sale', 'farm_data_obat_sale.farm_data_obat_code', '=', 'farm_data_obat.farm_data_obat_code')
                ->where('farm_data_obat.farm_data_obat_code', $request->code)->first();
            return $data->farm_data_obat_sale_sell;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function penjualan_non_resep_save_data(Request $request)
    {
        try {
            $cek = DB::table('farm_list_log')->where('farm_list_log_reg', $request->no_reg)->where('farm_data_obat_code', $request->namaObat)->first();
            if ($cek) {
                DB::table('farm_list_log')->where('farm_list_log_reg', $request->no_reg)->where('farm_data_obat_code', $request->namaObat)->update([
                    'farm_list_log_qty' => $request->jumlahObat + $cek->farm_list_log_qty,
                ]);
            } else {
                DB::table('farm_list_log')->insert([
                    'farm_list_log_code' => str::uuid(),
                    'farm_list_log_reg' => $request->no_reg,
                    'farm_data_obat_code' => $request->namaObat,
                    'farm_list_log_qty' => $request->jumlahObat,
                    'farm_list_log_harga' => $request->hargaObat,
                    'created_at' => now()
                ]);
            }
            $data = DB::table('farm_list_log')->join('farm_data_obat', 'farm_data_obat.farm_data_obat_code', '=', 'farm_list_log.farm_data_obat_code')
                ->where('farm_list_log_reg', $request->no_reg)->get();
            return view('app-farmasi.penjualan.non-resep.table-list-obat', ['data' => $data]);
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function penjualan_non_resep_remove_data(Request $request)
    {
        DB::table('farm_list_log')->where('farm_list_log_code', $request->code)->delete();
        $data = DB::table('farm_list_log')->join('farm_data_obat', 'farm_data_obat.farm_data_obat_code', '=', 'farm_list_log.farm_data_obat_code')
            ->where('farm_list_log_reg', $request->no_reg)->get();
        return view('app-farmasi.penjualan.non-resep.table-list-obat', ['data' => $data]);
    }
    public function penjualan_non_resep_show_data_list(Request $request)
    {
        $list = DB::table('farm_list_log')
            ->join('farm_data_obat', 'farm_data_obat.farm_data_obat_code', '=', 'farm_list_log.farm_data_obat_code')
            ->where('farm_list_log_reg', $request->code)
            ->get();
        return view('app-farmasi.penjualan.non-resep.form-data-list', [
            'code' => $request->code,
            'list' => $list
        ]);
    }
    public function penjualan_non_resep_payment_data_list(Request $request)
    {
        return view('app-farmasi.penjualan.non-resep.form-pembayaran');
    }
    public function penjualan_non_resep_payment_pilih(Request $request)
    {
        $total = DB::table('farm_list_log')->select(DB::raw('SUM(farm_list_log_harga * farm_list_log_qty) as total'))
            ->where('farm_list_log_reg', $request->code)->first();
        return view('app-farmasi.penjualan.non-resep.form-pembayaran-method', [
            'key' => $request->key,
            'total' => $total,
            'code' => $request->code
        ]);
    }
    public function penjualan_non_resep_payment_confrim(Request $request)
    {
        if ($request->method_payment == 'cod') {
            $list = DB::table('farm_list_log')->join('farm_data_obat', 'farm_data_obat.farm_data_obat_code', '=', 'farm_list_log.farm_data_obat_code')
                ->where('farm_list_log_reg', $request->no_reg)->get();
            foreach ($list as $value) {
                $cek = DB::table('farm_order_data_list')->where('farm_order_data_code', $request->no_reg)->where('farm_data_obat_code', $value->farm_data_obat_code)->first();
                if (!$cek) {
                    DB::table('farm_order_data_list')->insert([
                        'farm_order_data_list_code' => str::uuid(),
                        'farm_order_data_code' => $request->no_reg,
                        'farm_data_obat_code' => $value->farm_data_obat_code,
                        'farm_order_data_list_price' => $value->farm_list_log_harga,
                        'farm_order_data_list_qty' => $value->farm_list_log_qty,
                        'created_at' => now()
                    ]);
                }
            }
            $order = DB::table('farm_order_data')->where('farm_order_data_code', $request->no_reg)->first();
            if (!$order) {
                DB::table('farm_order_data')->insert([
                    'farm_order_data_code' => $request->no_reg,
                    'farm_order_data_date' => now(),
                    'farm_order_data_type' => 'NON RESEP',
                    'created_at' => now()
                ]);
            }
        } else {
            # code...
        }
        $list = DB::table('farm_list_log')->join('farm_data_obat', 'farm_data_obat.farm_data_obat_code', '=', 'farm_list_log.farm_data_obat_code')
            ->where('farm_list_log_reg', $request->no_reg)->get();
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('app-farmasi.penjualan.non-resep.report.report-invoice', [
            'no_reg' => $request->no_reg,
            'list' => $list
        ], compact('image'))->setPaper('A6', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->get_canvas()->page_text(300, 820, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 400, 575);
            ');
        return base64_encode($pdf->stream());
    }
    // PENJUALAN NON RESEP
    public function penjualan_farmasi_resep($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $doctor = DB::table('master_doctor')->get();
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.penjualan.penjualan-resep', [
                'data' => $data,
                'doctor' => $doctor,
                'akses' => $akses,
                'code' => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function penjualan_resep_cari_data(Request $request)
    {
        try {
            $data = DB::table('farm_data_obat')
                ->join('farm_data_obat_sale', 'farm_data_obat_sale.farm_data_obat_code', '=', 'farm_data_obat.farm_data_obat_code')
                ->where('farm_data_obat.farm_data_obat_code', $request->code)->first();
            return $data->farm_data_obat_sale_sell;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function penjualan_resep_show_data_list(Request $request)
    {
        $list = DB::table('farm_list_log')->join('farm_data_obat', 'farm_data_obat.farm_data_obat_code', '=', 'farm_list_log.farm_data_obat_code')
            ->where('farm_list_log_reg', $request->code)->get();
        return view('app-farmasi.penjualan.resep.form-data-list', [
            'code' => $request->code,
            'list' => $list,
            "noResep" => $request->noResep,
            "namaPasien" => $request->namaPasien,
            "namaDokter" => $request->namaDokter,
            "tglResep" => $request->tglResep,
            "keteranganResep" => $request->keteranganResep,
        ]);
    }
    public function penjualan_resep_payment_data_list(Request $request)
    {
        return view('app-farmasi.penjualan.resep.form-pembayaran');
    }
    public function penjualan_resep_payment_pilih(Request $request)
    {
        $total = DB::table('farm_list_log')->select(DB::raw('SUM(farm_list_log_harga * farm_list_log_qty) as total'))
            ->where('farm_list_log_reg', $request->code)->first();
        return view('app-farmasi.penjualan.resep.form-pembayaran-method', [
            'key' => $request->key,
            'total' => $total,
            'code' => $request->code,
            "noResep" => $request->noResep,
            "namaPasien" => $request->namaPasien,
            "namaDokter" => $request->namaDokter,
            "tglResep" => $request->tglResep,
            "keteranganResep" => $request->keteranganResep,
        ]);
    }
    public function penjualan_resep_payment_confrim(Request $request)
    {
        if ($request->method_payment == 'cod') {
            $list = DB::table('farm_list_log')->join('farm_data_obat', 'farm_data_obat.farm_data_obat_code', '=', 'farm_list_log.farm_data_obat_code')
                ->where('farm_list_log_reg', $request->no_reg)->get();
            foreach ($list as $value) {
                $cek = DB::table('farm_order_data_list')->where('farm_order_data_code', $request->no_reg)->where('farm_data_obat_code', $value->farm_data_obat_code)->first();
                if (!$cek) {
                    DB::table('farm_order_data_list')->insert([
                        'farm_order_data_list_code' => str::uuid(),
                        'farm_order_data_code' => $request->no_reg,
                        'farm_data_obat_code' => $value->farm_data_obat_code,
                        'farm_order_data_list_price' => $value->farm_list_log_harga,
                        'farm_order_data_list_qty' => $value->farm_list_log_qty,
                        'created_at' => now()
                    ]);
                }
            }
            $order = DB::table('farm_order_data')->where('farm_order_data_code', $request->no_reg)->first();
            if (!$order) {
                DB::table('farm_order_data')->insert([
                    'farm_order_data_code' => $request->no_reg,
                    'farm_order_data_date' => now(),
                    'farm_order_data_type' => 'RESEP',
                    'created_at' => now()
                ]);
                DB::table('farm_order_data_pasien')->insert([
                    'farm_order_data_pasien_code' => str::uuid(),
                    'farm_order_data_code' => $request->no_reg,
                    'farm_order_data_pasien_name' => $request->namaPasien,
                    'farm_order_data_pasien_date' => $request->tglResep,
                    'farm_order_data_pasien_no' => $request->noResep,
                    'farm_order_data_pasien_doctor' => $request->namaDokter,
                    'farm_order_data_pasien_desc' => $request->keteranganResep,
                    'created_at' => now()
                ]);
            }
        } else {
        }
        $list = DB::table('farm_list_log')->join('farm_data_obat', 'farm_data_obat.farm_data_obat_code', '=', 'farm_list_log.farm_data_obat_code')
            ->where('farm_list_log_reg', $request->no_reg)->get();
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('app-farmasi.penjualan.non-resep.report.report-invoice', [
            'no_reg' => $request->no_reg,
            'list' => $list
        ], compact('image'))->setPaper('A6', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->get_canvas()->page_text(300, 820, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 400, 575);
            ');
        return base64_encode($pdf->stream());
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
    // HISTORY PENJUALAN
    public function penjualan_history_penjualan(Request $request, $akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $startDate = $request->input('start_date', date('Y-m-01'));
            $endDate   = $request->input('end_date', date('Y-m-d'));
            $keyword   = $request->input('keyword');

            $query = DB::table('farm_order_data')
                ->whereDate('farm_order_data_date', '>=', $startDate)
                ->whereDate('farm_order_data_date', '<=', $endDate);

            if (!empty($keyword)) {
                $query->where('farm_order_data_code', 'LIKE', '\%' . $keyword . '%');
            }

            $data = $query->orderBy('farm_order_data_date', 'DESC')->get();

            return view('app-farmasi.penjualan.history-penjualan', [
                'data'      => $data,
                'akses'     => $akses,
                'code'      => $id,
                'startDate' => $startDate,
                'endDate'   => $endDate,
                'keyword'   => $keyword
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function penjualan_history_penjualan_detail(Request $request)
    {
        return view('app-farmasi.penjualan.history-penjualan.detail-history', ['code' => $request->code]);
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
            $data = DB::table('farm_data_obat')
                ->leftJoin('farm_data_satuan', 'farm_data_satuan.farm_data_satuan_code', '=', 'farm_data_obat.farm_data_obat_satuan')
                ->leftJoin('farm_data_jenis', 'farm_data_jenis.farm_data_jenis_code', '=', 'farm_data_obat.farm_data_obat_jenis')
                ->select([
                    'farm_data_obat.*',
                    'farm_data_satuan.farm_data_satuan_name',
                    'farm_data_jenis.farm_data_jenis_name'
                ])
                ->get();

            // Cek jika request dari AJAX (untuk refresh partial table)
            if (request()->ajax()) {
                return view('app-farmasi.manajemen.partials.table-data-obat', ['data' => $data])->render();
            }

            return view('app-farmasi.manajemen.data-obat', [
                'data'  => $data,
                'akses' => $akses,
                'code'  => $id
            ]);
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
        $grn = DB::table('pem_grn_token')->get();
        return view('app-farmasi.manajemen.master-obat.form-add-batch', [
            'code' => $request->code,
            'grns' => $grn
        ]);
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
        $data = DB::table('farm_data_obat_sale')
            ->join('pem_grn_token', 'pem_grn_token.pem_grn_token_code', '=', 'farm_data_obat_sale.pem_grn_token_code')
            ->where('farm_data_obat_code', $request->code)->get();
        $obat = DB::table('farm_data_obat')->where('farm_data_obat_code', $request->code)->first();
        return view('app-farmasi.manajemen.master-obat.form-batch-detail', ['data' => $data, 'obat' => $obat]);
    }
    public function manajemen_farmasi_data_obat_obat_sale(Request $request)
    {
        $grn = DB::table('pem_grn_token')->get();
        $data = DB::table('farm_data_obat_sale')
            ->join('pem_grn_token', 'pem_grn_token.pem_grn_token_code', '=', 'farm_data_obat_sale.pem_grn_token_code')
            ->where('farm_data_obat_code', $request->code)->get();
        return view('app-farmasi.manajemen.master-obat.form-sale-data-obat', [
            'data' => $data,
            'code' => $request->code,
            'grn' => $grn
        ]);
    }
    public function manajemen_farmasi_data_obat_obat_sale_add(Request $request)
    {
        try {
            $cek = DB::table('farm_data_obat_sale')->where('farm_data_obat_code', $request->code)->where('pem_grn_token_code', $request->grn)->first();
            if ($cek) {
                return 1;
            } else {
                DB::table('farm_data_obat_sale')->insert([
                    'farm_data_obat_sale_code' => str::uuid(),
                    'farm_data_obat_code' => $request->code,
                    'pem_grn_token_code' => $request->grn,
                    'farm_data_obat_sale_buy' => $request->harga,
                    'farm_data_obat_sale_sell' => $request->harga,
                    'farm_data_obat_sale_date' => now(),
                    'farm_data_obat_sale_desc' => 'text',
                    'created_at' => now()
                ]);
                $data = DB::table('farm_data_obat_sale')
                    ->join('pem_grn_token', 'pem_grn_token.pem_grn_token_code', '=', 'farm_data_obat_sale.pem_grn_token_code')
                    ->where('farm_data_obat_code', $request->code)->get();
                return view('app-farmasi.manajemen.master-obat.data-table-sale-obat', ['data' => $data]);
            }
        } catch (\Throwable $e) {
            return 0;
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
            $data = DB::table('farm_data_obat as fo')
                ->leftJoin('farm_data_satuan as fs', 'fs.farm_data_satuan_code', '=', 'fo.farm_data_obat_satuan')
                ->leftJoin('farm_data_jenis as fj', 'fj.farm_data_jenis_code', '=', 'fo.farm_data_obat_jenis')
                ->select([
                    'fo.*',
                    'fs.farm_data_satuan_name',
                    'fj.farm_data_jenis_name',
                    // Menghitung total stok aktif dari tabel batch/expired
                    DB::raw('(SELECT COALESCE(SUM(data_obat_stok), 0) FROM farm_data_obat_exp WHERE farm_data_obat_exp.farm_data_obat_code = fo.farm_data_obat_code) as total_stok')
                ])
                ->get();

            return view('app-farmasi.manajemen.stox-min-max', [
                'data'  => $data,
                'akses' => $akses,
                'code'  => $id
            ]);
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
    // DATA SUPPLIER
    public function master_data_farmasi_harga_obat($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $penjamins = DB::table('medical_penjamin')->get();

            $obats = DB::table('farm_data_obat as fo')
                ->leftJoin('farm_data_satuan as fs', 'fs.farm_data_satuan_code', '=', 'fo.farm_data_obat_satuan')
                ->select('fo.*', 'fs.farm_data_satuan_name')
                ->get();

            return view('app-farmasi.master-data.master-harga-obat', [
                'akses'     => $akses,
                'code'      => $id,
                'penjamins' => $penjamins,
                'obats'     => $obats
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

    public function master_data_farmasi_harga_obat_save(Request $request)
    {
        $subPenjaminId = $request->input('sub_penjamin_id');
        $penjaminId    = $request->input('penjamin_id');
        $items         = $request->input('item', []); // Format: [ obat_code => [ 'harga' => 1000, 'status' => 1 ] ]

        if (!$subPenjaminId) {
            return response()->json(['success' => false, 'message' => 'Sub penjamin belum dipilih!']);
        }

        foreach ($items as $obatCode => $data) {
            $isActive = isset($data['status']) ? 1 : 0;
            $harga    = str_replace('.', '', $data['harga'] ?? 0); // Bersihkan format rupiah jika ada

            if ($isActive) {
                // Jika diaktifkan, simpan atau update harganya
                DB::table('farm_penjamin_obat')->updateOrInsert(
                    [
                        'farm_data_obat_code' => $obatCode,
                        'sub_penjamin_id'     => $subPenjaminId,
                    ],
                    [
                        'penjamin_id'         => $penjaminId,
                        'harga_jual'          => $harga,
                        'status'              => 1,
                        'updated_at'          => now(),
                        'created_at'          => now()
                    ]
                );
            } else {
                // Jika dinonaktifkan, Anda bisa menghapusnya dari database atau mengubah statusnya jadi 0
                DB::table('farm_penjamin_obat')
                    ->where('farm_data_obat_code', $obatCode)
                    ->where('sub_penjamin_id', $subPenjaminId)
                    ->update(['status' => 0, 'updated_at' => now()]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Pengaturan master harga obat berhasil disimpan!']);
    }
    public function master_data_farmasi_harga_obat_get(Request $request)
    {
        $subPenjaminId = $request->input('sub_penjamin_id');

        // Mengambil data harga dan status aktif per kode obat
        $pricesData = DB::table('farm_penjamin_obat')
            ->where('sub_penjamin_id', $subPenjaminId)
            ->select('farm_data_obat_code', 'harga_jual', 'status')
            ->get()
            ->keyBy('farm_data_obat_code');

        return response()->json([
            'prices' => $pricesData
        ]);
    }
}
