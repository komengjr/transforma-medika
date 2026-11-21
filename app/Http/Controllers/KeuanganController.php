<?php

namespace App\Http\Controllers;

use App\Models\DRegOrder;
use App\Models\DRegOrderLabList;
use App\Models\DRegOrderList;
use App\Models\DRegOrderRadList;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
            $pay = DB::table('m_pay')->get();
            // Mengambil data kelompok pelanggan / sub penjamin untuk opsi filter
            $subPenjamins = DB::table('medical_sub_penjamin')->get();

            // --- TAMBAHAN BARU: Ambil data EDC / Rekening aktif ---
            $edcList = DB::table('medical_master_edc')->where('is_active', 1)->get();

            return view('application.keuangan.menu-cashier', [
                'akses'         => $akses,
                'code'          => $id,
                'pay'           => $pay,
                'subPenjamins'  => $subPenjamins,
                'edcList'       => $edcList // <--- Kirim ke view
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function keuangan_menu_cashier_list_all_patient(Request $request)
    {
        // Menerima parameter filter dari frontend
        $startDate = $request->input('start_date', date('Y-m-d'));
        $endDate   = $request->input('end_date', date('Y-m-d'));
        $status    = $request->input('status');     // 'Lunas', 'Belum Lunas', atau kosong (Semua)
        $penjamin  = $request->input('penjamin');   // ID sub_penjamin_id
        $keyword   = $request->input('keyword');    // Nama atau No Reg / RM

        // Kueri Utama berpusat pada Registrasi
        $query = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->leftJoin('medical_sub_penjamin as sp', 'reg.sub_penjamin_id', '=', 'sp.id')
            ->leftJoin('medical_transaksi as trx', 'trx.registrasi_id', '=', 'reg.id')
            ->select([
                'reg.id as registrasi_id',
                'reg.no_registrasi as d_reg_order_code',
                'reg.tanggal_registrasi',
                'p.pid as rm_code',
                'p.nama as patient_name',
                'sp.nama_sub_penjamin as t_layanan_cat_code',
                'trx.metode_bayar',
                'trx.dilunasi_oleh',
                'trx.status_pembayaran as trx_status_pembayaran',
                'trx.total_tagihan as total_semua',
                'trx.sisa_tagihan as total_belum_lunas'
            ])
            // Hanya tampilkan yang sudah memiliki transaksi / tagihan
            ->whereNotNull('trx.id');

        // Filter Rentang Tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('reg.tanggal_registrasi', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);
        }

        // Filter Status Pembayaran
        if (!empty($status)) {
            if (strtolower($status) === 'belum lunas') {
                $query->where('trx.status_pembayaran', '!=', 'LUNAS');
            } elseif (strtolower($status) === 'lunas') {
                $query->where('trx.status_pembayaran', 'LUNAS');
            }
        }

        // Filter Kelompok Pelanggan (Sub Penjamin)
        if (!empty($penjamin)) {
            $query->where('reg.sub_penjamin_id', $penjamin);
        }

        // Filter Keyword (No Reg, Nama Pasien, atau No RM)
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('reg.no_registrasi', 'like', "%{$keyword}%")
                    ->orWhere('p.nama', 'like', "%{$keyword}%")
                    ->orWhere('p.pid', 'like', "%{$keyword}%");
            });
        }

        $data = $query->orderBy('reg.tanggal_registrasi', 'DESC')->get();

        $formatted = $data->map(function ($item) {
            $isUnpaid = ($item->trx_status_pembayaran !== 'LUNAS');

            // Jika belum lunas, tampilkan sisa hutangnya. Jika lunas, tampilkan histori total pembayarannya.
            $tagihanTampil = $isUnpaid ? $item->total_belum_lunas : $item->total_semua;

            return [
                'registrasi_id'      => $item->registrasi_id,
                'd_reg_order_code'   => $item->d_reg_order_code,
                'rm_code'            => $item->rm_code,
                'patient_name'       => $item->patient_name,
                't_layanan_cat_code' => $item->t_layanan_cat_code ?? '-',
                'total_tagihan'      => (float) $tagihanTampil,
                'status_pembayaran'  => $item->trx_status_pembayaran,
                'metode_bayar'       => $isUnpaid ? '-' : ($item->metode_bayar ?? '-'),
                'user_pelunas'       => $isUnpaid ? '-' : ($item->dilunasi_oleh ?? '-'),
                'tanggal_registrasi' => $item->tanggal_registrasi
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $formatted
        ]);
    }
    public function keuangan_menu_cashier_list_all_patient_old1(Request $request)
    {
        // Menerima parameter filter dari frontend
        $startDate = $request->input('start_date', date('Y-m-d'));
        $endDate   = $request->input('end_date', date('Y-m-d'));
        $status    = $request->input('status');     // 'Lunas', 'Belum Lunas', atau kosong (Semua)
        $penjamin  = $request->input('penjamin');   // ID sub_penjamin_id
        $keyword   = $request->input('keyword');    // Nama atau No Reg / RM

        // 1. Sub-Query Tindakan (Hitung Total & Sisa Belum Lunas)
        $subTindakan = DB::table('medical_transaksi_detail as td')
            ->join('medical_transaksi as t', 'td.transaksi_id', '=', 't.id')
            ->select(
                't.registrasi_id',
                DB::raw('SUM(td.harga_akhir) as total_tindakan'),
                DB::raw("SUM(CASE WHEN td.status_pembayaran = 'BELUM LUNAS' THEN td.harga_akhir ELSE 0 END) as unpaid_tindakan")
            )
            ->where('td.status_pemeriksaan', '!=', 'BATAL')
            ->groupBy('t.registrasi_id');

        // 2. Sub-Query Obat Farmasi (Hitung Total & Sisa Belum Lunas)
        $subObat = DB::table('medical_ranap_resep as rr')
            ->select(
                'rr.registrasi_id',
                DB::raw('SUM(rr.qty * rr.harga) as total_obat'),
                DB::raw("SUM(CASE WHEN rr.status_pembayaran = 'BELUM LUNAS' THEN (rr.qty * rr.harga) ELSE 0 END) as unpaid_obat")
            )
            ->where('rr.status_verifikasi', 'Verified')
            ->groupBy('rr.registrasi_id');

        // 3. Kueri Utama berpusat pada Registrasi
        $query = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->leftJoin('medical_sub_penjamin as sp', 'reg.sub_penjamin_id', '=', 'sp.id')
            ->leftJoin('medical_transaksi as trx', 'trx.registrasi_id', '=', 'reg.id')
            ->leftJoinSub($subTindakan, 'tnd', function ($join) {
                $join->on('reg.id', '=', 'tnd.registrasi_id');
            })
            ->leftJoinSub($subObat, 'obt', function ($join) {
                $join->on('reg.id', '=', 'obt.registrasi_id');
            })
            ->select([
                'reg.id as registrasi_id',
                'reg.no_registrasi as d_reg_order_code',
                'reg.tanggal_registrasi',
                'p.pid as rm_code',
                'p.nama as patient_name',
                'sp.nama_sub_penjamin as t_layanan_cat_code',
                'trx.metode_bayar',
                'trx.dilunasi_oleh',
                // Kalkulasi Semua
                DB::raw('(COALESCE(tnd.total_tindakan, 0) + COALESCE(obt.total_obat, 0)) as total_semua'),
                // Kalkulasi Belum Lunas Saja
                DB::raw('(COALESCE(tnd.unpaid_tindakan, 0) + COALESCE(obt.unpaid_obat, 0)) as total_belum_lunas')
            ])
            // Filter Dasar: Hanya tampilkan pasien yang memiliki tagihan valid (>0)
            ->whereRaw('(COALESCE(tnd.total_tindakan, 0) + COALESCE(obt.total_obat, 0)) > 0');

        // 4. Filter Rentang Tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('reg.tanggal_registrasi', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);
        }

        // 5. Filter Status Pembayaran Berdasarkan Tagihan Detail (Unpaid Item)
        if (!empty($status)) {
            if (strtolower($status) === 'belum lunas') {
                // Pasien masih memiliki item (obat/tindakan) yang BELUM LUNAS
                $query->whereRaw('(COALESCE(tnd.unpaid_tindakan, 0) + COALESCE(obt.unpaid_obat, 0)) > 0');
            } elseif (strtolower($status) === 'lunas') {
                // Semua item sudah LUNAS (Total tagihan ada, tapi nilai unpaid = 0)
                $query->whereRaw('(COALESCE(tnd.unpaid_tindakan, 0) + COALESCE(obt.unpaid_obat, 0)) = 0');
            }
        }

        // 6. Filter Kelompok Pelanggan (Sub Penjamin)
        if (!empty($penjamin)) {
            $query->where('reg.sub_penjamin_id', $penjamin);
        }

        // 7. Filter Keyword (No Reg, Nama Pasien, atau No RM)
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('reg.no_registrasi', 'like', "%{$keyword}%")
                    ->orWhere('p.nama', 'like', "%{$keyword}%")
                    ->orWhere('p.pid', 'like', "%{$keyword}%");
            });
        }

        $data = $query->orderBy('reg.tanggal_registrasi', 'DESC')->get();

        $formatted = $data->map(function ($item) {
            // Logika Status: Jika masih ada tagihan unpaid, statusnya 'BELUM LUNAS'
            $isUnpaid = $item->total_belum_lunas > 0;
            $statusPembayaran = $isUnpaid ? 'BELUM LUNAS' : 'LUNAS';

            // Tagihan Tampil:
            // Jika kasir membuka pasien belum lunas, yang ditampilkan HANYA sisa yang harus dibayar.
            // Jika lunas (history), tampilkan total keseluruhannya.
            $tagihanTampil = $isUnpaid ? $item->total_belum_lunas : $item->total_semua;

            return [
                'registrasi_id'      => $item->registrasi_id,
                'd_reg_order_code'   => $item->d_reg_order_code,
                'rm_code'            => $item->rm_code,
                'patient_name'       => $item->patient_name,
                't_layanan_cat_code' => $item->t_layanan_cat_code ?? '-',
                'total_tagihan'      => (float) $tagihanTampil,
                'status_pembayaran'  => $statusPembayaran,
                'metode_bayar'       => $isUnpaid ? '-' : ($item->metode_bayar ?? '-'),
                'user_pelunas'       => $isUnpaid ? '-' : ($item->dilunasi_oleh ?? '-'),
                'tanggal_registrasi' => $item->tanggal_registrasi
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $formatted
        ]);
    }
    public function getDetailTagihanKasir($regId)
    {
        try {
            // 1. Ambil Data Pasien & Registrasi
            $registrasi = DB::table('medical_registrasi as reg')
                ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
                ->select('reg.id as registrasi_id', 'reg.no_registrasi', 'p.nama', 'p.pid')
                ->where('reg.id', $regId)
                ->first();

            if (!$registrasi) {
                return response()->json(['success' => false, 'message' => 'Data registrasi tidak ditemukan.']);
            }

            // 2. Ambil Header Transaksi Utama
            $transaksi = DB::table('medical_transaksi')
                ->where('registrasi_id', $regId)
                ->first();

            $items = collect([]);
            $totalTanggunganPasien = 0;
            $totalTanggunganPerusahaan = 0;
            $grandTotal = 0;
            $polaTanggungan = 'FULL_PASIEN';
            $statusBayar = 'BELUM LUNAS';

            if ($transaksi) {
                // 3. Ambil Rincian Transaksi beserta Kolom Tanggungan Penjamin (Pasien vs Perusahaan)
                $items = DB::table('medical_transaksi_detail as td')
                    ->select(
                        'td.id',
                        'td.jenis_item',
                        'td.nama_item',
                        'td.qty',
                        'td.harga_akhir', // Total harga item (qty * harga satuan)
                        'td.tanggungan_pasien',
                        'td.tanggungan_perusahaan',
                        'td.status_pembayaran'
                    )
                    ->where('td.transaksi_id', $transaksi->id)
                    ->whereNotIn('td.status_pemeriksaan', ['BATAL'])
                    ->where('td.status_pembayaran', 'BELUM LUNAS')
                    ->get();

                // Hitung akumulasi porsi masing-masing
                $totalTanggunganPasien = $items->sum('tanggungan_pasien');
                $totalTanggunganPerusahaan = $items->sum('tanggungan_perusahaan');

                // Grand total yang harus dibayar oleh kasir (mengacu ke porsi pasien)
                $grandTotal = $totalTanggunganPasien;

                // Tentukan pola penjamin berdasarkan data header/transaksi atau kalkulasi porsi
                if ($totalTanggunganPasien > 0 && $totalTanggunganPerusahaan > 0) {
                    $polaTanggungan = 'SPLIT_BILL';
                } elseif ($totalTanggunganPasien == 0 && $totalTanggunganPerusahaan > 0) {
                    $polaTanggungan = 'FULL_PERUSAHAAN';
                } else {
                    $polaTanggungan = 'FULL_PASIEN';
                }

                // Tentukan status lunas untuk antarmuka UI
                $statusBayar = ($grandTotal > 0 || $transaksi->status_pembayaran !== 'LUNAS') ? 'BELUM LUNAS' : 'LUNAS';
            }

            return response()->json([
                'success'                    => true,
                'pasien'                     => $registrasi,
                'transaksi'                  => [
                    'id'                     => $transaksi ? $transaksi->id : null,
                    'status_pembayaran'      => $statusBayar
                ],
                'items'                      => $items,
                'total_tanggungan_pasien'    => (float) $totalTanggunganPasien,
                'total_tanggungan_perusahaan' => (float) $totalTanggunganPerusahaan,
                'pola_tanggungan'            => $polaTanggungan,
                'grand_total'                => (float) $grandTotal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getDetailTagihanKasir_old($regId)
    {
        try {
            // 1. Ambil Data Pasien & Registrasi
            $registrasi = DB::table('medical_registrasi as reg')
                ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
                ->select('reg.id as registrasi_id', 'reg.no_registrasi', 'p.nama', 'p.pid')
                ->where('reg.id', $regId)
                ->first();

            if (!$registrasi) {
                return response()->json(['success' => false, 'message' => 'Data registrasi tidak ditemukan.']);
            }

            // 2. Ambil Header Transaksi (Jika sudah di-generate di pendaftaran/poli)
            $transaksi = DB::table('medical_transaksi')
                ->where('registrasi_id', $regId)
                ->first();

            // 3. Ambil Rincian Tindakan (Hanya yang BELUM LUNAS dan TIDAK BATAL)
            // 3. Ambil Rincian Tindakan (Hanya yang BELUM LUNAS dan TIDAK BATAL)
            $tindakan = collect([]);
            $totalTindakan = 0;

            if ($transaksi) {
                $tindakan = DB::table('medical_transaksi_detail as td')
                    ->leftJoin('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
                    ->select(
                        // Gunakan COALESCE: Jika nama_layanan null, ambil dari kategori_biaya (misal: 'JASA_DOKTER')
                        DB::raw("COALESCE(mp.nama_layanan, td.kategori_biaya) as item"),
                        'td.harga_akhir as harga',
                        'td.status_pembayaran'
                    )
                    ->where('td.transaksi_id', $transaksi->id)
                    ->whereNotIn('td.status_pemeriksaan', ['BATAL']) // Agar SELESAI & MENUNGGU masuk
                    ->where('td.status_pembayaran', 'BELUM LUNAS') // Filter rolling bill
                    ->get();

                $totalTindakan = $tindakan->sum('harga');
            }

            // 4. Ambil Rincian Resep Obat (Hanya yang Verified dan BELUM LUNAS)
            $obat = DB::table('medical_ranap_resep as rr')
                ->join('farm_data_obat as fo', 'rr.farm_data_obat_code', '=', 'fo.farm_data_obat_code')
                ->select(
                    'fo.farm_data_obat_name as item',
                    'rr.qty',
                    'rr.harga',
                    'rr.status_pembayaran'
                )
                ->where('rr.registrasi_id', $regId)
                ->where('rr.status_verifikasi', 'Verified')    // Sudah di-ACC Farmasi / Dokter
                ->where('rr.status_pembayaran', 'BELUM LUNAS') // Filter rolling bill
                ->get();

            $totalObat = $obat->sum(function ($item) {
                return $item->qty * $item->harga;
            });

            // 5. Hitung Grand Total
            $grandTotal = $totalTindakan + $totalObat;

            // 6. Tentukan Status Bayar untuk ditampilkan di UI
            // Jika grand total 0 (artinya semua sudah dibayar lunas sebelumnya), set LUNAS
            $statusBayar = ($grandTotal > 0) ? 'BELUM LUNAS' : 'LUNAS';

            return response()->json([
                'success'        => true,
                'pasien'         => $registrasi,
                'transaksi'      => [
                    'id'                => $transaksi ? $transaksi->id : null,
                    'status_pembayaran' => $statusBayar
                ],
                'tindakan'       => $tindakan,
                'total_tindakan' => $totalTindakan,
                'obat'           => $obat,
                'total_obat'     => $totalObat,
                'grand_total'    => $grandTotal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }
    public function keuangan_menu_cashier_find(Request $request)
    {
        $data = DB::table('d_reg_order')->where('d_reg_order_code', $request->code)->first();
        // $payment = DB::table('d_reg_order_code')->where('')
        if ($data) {
            $x = 0;
            $pasien = DB::table('d_reg_order')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->where('d_reg_order.d_reg_order_code', $request->code)->first();
            $data = DB::table('d_reg_order_list')
                ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'd_reg_order_list.t_layanan_cat_code')
                ->where('d_reg_order_list.d_reg_order_code', $request->code)->get();
            foreach ($data as $value) {
                $payment = DB::table('d_reg_order_payment')->where('d_reg_order_code', $request->code)->where('d_reg_order_list_code', $value->d_reg_order_list_code)->first();
                if ($payment) {
                    $x = $x + 0;
                } else {
                    $x = $x + 1;
                }
            }
            if ($x == 0) {
                return 1;
            } else {
                return view('application.keuangan.menu-cashier.detail-order', ['data' => $data, 'pasien' => $pasien, 'code' => $request->code]);
            }
        } else {
            return 0;
        }
    }
    public function keuangan_menu_cashier_find_data(Request $request)
    {
        $data = DB::table('d_reg_order')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->get();
        return view('application.keuangan.menu-cashier.find-data-tagihan', ['data' => $data]);
    }
    public function keuangan_menu_cashier_list_all_patient_old()
    {
        try {
            // Hitung tagihan menggantung di tabel Laboratorium ter-join ke Jembatan Order List
            $PoliQuery = DB::table('d_reg_order_poli_list')
                ->join('d_reg_order_list', 'd_reg_order_poli_list.d_reg_order_poli_code', '=', 'd_reg_order_list.d_reg_order_list_code')
                ->select(
                    'd_reg_order_list.d_reg_order_code',
                    DB::raw('SUM(order_poli_log_price - order_poli_log_discount) as total_tagihan'),
                    DB::raw('"Poliklinik" as jenis_layanan')
                )
                ->where('status_pembayaran', '!=', 'Lunas')
                ->groupBy('d_reg_order_list.d_reg_order_code');
            // Hitung tagihan menggantung di tabel Laboratorium ter-join ke Jembatan Order List
            $labQuery = DB::table('d_reg_order_lab_list')
                ->join('d_reg_order_list', 'd_reg_order_lab_list.d_reg_order_lab_code', '=', 'd_reg_order_list.d_reg_order_list_code')
                ->select(
                    'd_reg_order_list.d_reg_order_code',
                    DB::raw('SUM(order_lab_log_price - order_lab_log_discount) as total_tagihan'),
                    DB::raw('"Laboratorium" as jenis_layanan')
                )
                ->where('status_pembayaran', '!=', 'Lunas')
                ->groupBy('d_reg_order_list.d_reg_order_code');

            // Hitung tagihan menggantung di tabel Radiologi ter-join ke Jembatan Order List
            $combinedList = DB::table('d_reg_order_rad_list')
                ->join('d_reg_order_list', 'd_reg_order_rad_list.d_reg_order_rad_code', '=', 'd_reg_order_list.d_reg_order_list_code')
                ->select(
                    'd_reg_order_list.d_reg_order_code',
                    DB::raw('SUM(order_rad_log_price - order_rad_log_discount) as total_tagihan'),
                    DB::raw('"Radiologi" as jenis_layanan')
                )
                ->where('status_pembayaran', '!=', 'Lunas')
                ->groupBy('d_reg_order_list.d_reg_order_code')
                ->unionAll($labQuery)
                ->unionAll($PoliQuery)
                ->get();

            // Map data final dengan profil pasien dari tabel puncak d_reg_order
            $finalList = $combinedList->groupBy('d_reg_order_code')->map(function ($items, $orderCode) {
                $puncak = DB::table('d_reg_order')
                    ->join('master_patient', 'd_reg_order.d_reg_order_rm', '=', 'master_patient.master_patient_code')
                    ->where('d_reg_order.d_reg_order_code', '=', $orderCode)
                    ->select('master_patient.master_patient_name', 'd_reg_order.d_reg_order_rm', 'd_reg_order.d_reg_order_date')
                    ->first();

                return [
                    'd_reg_order_code'      => (string) $orderCode,
                    'patient_name'          => $puncak ? $puncak->master_patient_name : 'Pasien ' . $orderCode,
                    'rm_code'               => $puncak ? $puncak->d_reg_order_rm : '-',
                    't_layanan_cat_code'    => $items->pluck('jenis_layanan')->unique()->implode(' & '),
                    'd_reg_order_list_date' => $puncak ? $puncak->d_reg_order_date : date('Y-m-d'),
                    'total_tagihan'         => (int) $items->sum('total_tagihan')
                ];
            })->values();

            return response()->json(['success' => true, 'data' => $finalList]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function keuangan_menu_cashier_find_data_v2(Request $request)
    {
        $noReg = $request->query('no_reg');

        $order = DRegOrder::with([
            'pasien',
            'orderLists.laboratoriums.salesData.pemeriksaanList',
            'orderLists.radiologis.salesData.pemeriksaanList',
            'orderLists.radiologis.salesData.pemeriksaanList'
        ])
            ->where('d_reg_order_code', $noReg)
            ->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Berkas pendaftaran tidak ditemukan.'], 404);
        }

        $layananLab = collect();
        $layananRad = collect();
        $layananPoli = collect();
        // Loop melalui jembatan d_reg_order_list untuk mengurai isi item lab dan rad di dalamnya
        foreach ($order->orderLists as $list) {
            foreach ($list->laboratoriums as $lab) {
                $layananLab->push([
                    'id' => $lab->id_d_reg_order_lab_list,
                    'reg' => $lab->d_reg_order_lab_code,
                    'nama' => optional(optional($lab->salesData)->pemeriksaanList)->t_pemeriksaan_list_name ?? $lab->p_sales_data_code,
                    'harga' => (int) $lab->order_lab_log_price,
                    'diskon' => (int) $lab->order_lab_log_discount,
                    'lunas' => $lab->status_pembayaran === 'Lunas'
                ]);
            }

            foreach ($list->radiologis as $rad) {
                $layananRad->push([
                    'id' => $rad->id_d_reg_order_rad_list,
                    'reg' => $noReg,
                    'nama' => optional(optional($rad->salesData)->pemeriksaanList)->t_pemeriksaan_list_name ?? $rad->p_sales_data_code,
                    'harga' => (int) $rad->order_rad_log_price,
                    'diskon' => (int) $rad->order_rad_log_discount,
                    'lunas' => $rad->status_pembayaran === 'Lunas'
                ]);
            }
            // Ambil detail Poli
            // $polis = DB::table('d_reg_order_poli_list')->where('d_reg_order_poli_code', $list->d_reg_order_list_code)->get();
            foreach ($list->poliklinik as $poli) {
                $layananPoli->push([
                    'id' => $poli->id_d_reg_order_poli_list,
                    'reg' => $noReg,
                    'nama' => optional(optional($poli->salesData)->pemeriksaanList)->t_pemeriksaan_list_name ?? $poli->p_sales_data_code,
                    'harga' => (int) $poli->order_poli_log_price,
                    'diskon' => (int) $poli->order_poli_log_discount,
                    'lunas' => $poli->status_pembayaran === 'Lunas'
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'no_reg' => $order->d_reg_order_code,
                'no_rm' => $order->d_reg_order_rm,
                'nama' => $order->pasien ? $order->pasien->master_patient_name : '-',
                'jk' => $order->pasien ? ($order->pasien->master_patient_jk == 'L' ? 'Laki-laki' : 'Perempuan') : '-',
                'kategori_layanan' => $order->t_layanan_cat_code,
                'tanggal' => $order->d_reg_order_date,
                'layanan' => [
                    'Layanan Laboratorium' => $layananLab,
                    'Layanan Radiologi' => $layananRad,
                    'Layanan Poliklinik' => $layananPoli
                ]
            ]
        ]);
    }
    public function keuangan_menu_cashier_proses_payment(Request $request)
    {
        // Tangkap input (mendukung parameter registrasi_id atau d_reg_order_code dari JS lama)
        $regId       = $request->input('registrasi_id') ?? $request->input('d_reg_order_code');
        $metodeBayar = $request->input('metode_pembayaran') ?? $request->input('metode_bayar'); // CASH, DEBIT, CREDIT
        $jumlahBayar = floatval($request->input('jumlah_bayar') ?? $request->input('nominal_bayar', 0));
        $edcId       = $request->input('edc_id');
        $noReferensi = $request->input('no_referensi');

        // 1. VALIDASI: Pastikan metode pembayaran dikirim dan valid
        if (empty($metodeBayar) || !in_array($metodeBayar, ['CASH', 'DEBIT', 'CREDIT', 'DEBIT/TRANSFER'])) {
            return response()->json([
                'success' => false,
                'message' => 'Peringatan: Silakan pilih salah satu metode pembayaran terlebih dahulu!'
            ], 400);
        }

        // Ambil data user yang sedang login saat ini
        $currentUser   = Auth::user();
        $namaUserLogin = $currentUser ? ($currentUser->name ?? $currentUser->username ?? 'Kasir') : 'Sistem Kasir';
        $userIdLogin   = $currentUser ? ($currentUser->userid ?? $currentUser->id ?? null) : null;

        DB::beginTransaction();
        try {
            // 2. Ambil data Registrasi untuk memastikan data valid
            $registrasi = DB::table('medical_registrasi')->where('id', $regId)->orWhere('no_registrasi', $regId)->first();
            if (!$registrasi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data registrasi pasien tidak ditemukan!'
                ], 404);
            }

            // 3. Ambil data Header Transaksi (Jika belum ada, buat baru)
            $transaksi = DB::table('medical_transaksi')->where('registrasi_id', $registrasi->id)->first();
            if (!$transaksi) {
                $transaksiId = DB::table('medical_transaksi')->insertGetId([
                    'registrasi_id'     => $registrasi->id,
                    'total_tagihan'     => 0,
                    'total_bayar'       => 0,
                    'sisa_tagihan'      => 0,
                    'metode_bayar'      => $metodeBayar,
                    'status_pembayaran' => 'BELUM LUNAS',
                    'created_at'        => now(),
                    'updated_at'        => now()
                ]);
                $transaksi = DB::table('medical_transaksi')->where('id', $transaksiId)->first();
            }

            // 4. Hitung TOTAL TAGIHAN YANG BELUM LUNAS SAAT INI (Tindakan + Obat)
            $unpaidTindakan = DB::table('medical_transaksi_detail')
                ->where('transaksi_id', $transaksi->id)
                ->where('status_pemeriksaan', '!=', 'BATAL')
                ->where('status_pembayaran', 'BELUM LUNAS')
                ->sum('harga_akhir');

            $unpaidObat = DB::table('medical_ranap_resep')
                ->where('registrasi_id', $registrasi->id)
                ->where('status_verifikasi', 'Verified')
                ->where('status_pembayaran', 'BELUM LUNAS')
                ->sum(DB::raw('qty * harga'));

            $totalTagihanSekarang = floatval($unpaidTindakan + $unpaidObat);

            if ($totalTagihanSekarang <= 0) {
                return response()->json([
                    'success'    => false,
                    'alert_type' => 'warning',
                    'message'    => 'Tidak ada tagihan yang belum lunas untuk pasien ini.'
                ], 400);
            }

            // 5. VALIDASI NOMINAL PEMBAYARAN
            if ($jumlahBayar <= 0) {
                return response()->json([
                    'success'    => false,
                    'alert_type' => 'warning',
                    'message'    => 'Peringatan: Masukkan nominal pembayaran yang valid!'
                ], 400);
            }

            if ($jumlahBayar < $totalTagihanSekarang) {
                $kurang = $totalTagihanSekarang - $jumlahBayar;
                return response()->json([
                    'success'    => false,
                    'alert_type' => 'warning',
                    'message'    => 'Peringatan: Nominal pembayaran kurang dari Total Tagihan! Kekurangan: Rp ' . number_format($kurang, 0, ',', '.')
                ], 400);
            }

            // 6. UPDATE ITEM MENJADI LUNAS (Kunci Item Tindakan & Obat)
            DB::table('medical_transaksi_detail')
                ->where('transaksi_id', $transaksi->id)
                ->where('status_pemeriksaan', '!=', 'BATAL')
                ->where('status_pembayaran', 'BELUM LUNAS')
                ->update([
                    'status_pembayaran' => 'LUNAS',
                    'waktu_bayar'       => now(),
                    'updated_at'        => now()
                ]);

            DB::table('medical_ranap_resep')
                ->where('registrasi_id', $registrasi->id)
                ->where('status_verifikasi', 'Verified')
                ->where('status_pembayaran', 'BELUM LUNAS')
                ->update([
                    'transaksi_id'      => $transaksi->id, // Ikat resep ini ke nota
                    'status_pembayaran' => 'LUNAS',
                    'waktu_bayar'       => now(),
                    'updated_at'        => now()
                ]);

            // 7. KALKULASI & UPDATE HEADER TRANSAKSI KESELURUHAN (Termasuk histori sebelumnya)
            $allTindakan = DB::table('medical_transaksi_detail')
                ->where('transaksi_id', $transaksi->id)
                ->where('status_pemeriksaan', '!=', 'BATAL')
                ->sum('harga_akhir');

            $allObat = DB::table('medical_ranap_resep')
                ->where('registrasi_id', $registrasi->id)
                ->where('status_verifikasi', 'Verified')
                ->sum(DB::raw('qty * harga'));

            $grandTotalHistori = floatval($allTindakan + $allObat);
            $akumulasiBayar    = floatval($transaksi->total_bayar) + $jumlahBayar;

            DB::table('medical_transaksi')
                ->where('id', $transaksi->id)
                ->update([
                    'total_tagihan'     => $grandTotalHistori,
                    'total_bayar'       => $akumulasiBayar,
                    'sisa_tagihan'      => 0, // Karena lunas penuh
                    'status_pembayaran' => 'LUNAS',
                    'metode_bayar'      => $metodeBayar,
                    'edc_id'            => $edcId,
                    'no_referensi'      => $noReferensi,
                    'dilunasi_oleh'     => $userIdLogin,
                    'waktu_lunas'       => now(),
                    'updated_at'        => now()
                ]);

            DB::commit();

            return response()->json([
                'success'       => true,
                'message'       => 'Pembayaran berhasil dilunaskan oleh ' . $namaUserLogin,
                'total_dibayar' => $jumlahBayar,
                'user_pelunas'  => $namaUserLogin
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }
    public function keuangan_menu_cashier_find_fix_payment(Request $request)
    {
        if ($request['payment_method'] == 'CASH') {
            $nominal = $request->nominalCASH;
            $nominal = preg_replace("/[^0-9]/", "", $nominal);
            $payment_card = $request->payment_cardCASH;
            if ($nominal < $request->total_pembayaran) {
                return 'Uang Tidak Cukup Bayar';
            } else {
                $sisabayar = $nominal - $request->total_pembayaran;
                $list = DB::table('d_reg_order_list')->where('d_reg_order_code', $request->no_reg)->get();
                foreach ($list as $value) {
                    $check = DB::table('d_reg_order_payment')->where('d_reg_order_code', $request->no_reg)->where('d_reg_order_list_code', $value->d_reg_order_list_code)->first();
                    if ($check) {
                        return 'Sudah Pernah di bayar';
                    } else {
                        DB::table('d_reg_order_payment')->insert([
                            'd_reg_order_payment_code' => str::uuid(),
                            'd_reg_order_code' => $request->no_reg,
                            'd_reg_order_list_code' => $value->d_reg_order_list_code,
                            'd_reg_order_payment_date' => now(),
                            'd_reg_order_payment_user' => Auth::user()->userid,
                            'd_reg_order_payment_card' => 'CASH',
                            'd_reg_order_payment_total' => $request->total_pembayaran,
                            'created_at' => now()
                        ]);
                    }
                }
                return ' Berhasil Melakukan Payment, Sisa Bayar ' . $sisabayar;
            }
        } elseif ($request->payment_method == 'TRANSFER') {
            $nominal = $request->nominalTRANSFER;
            $nominal = preg_replace("/[^0-9]/", "", $nominal);
            $payment_card = $request->payment_cardTRANSFER;
            if ($nominal < $request->total_pembayaran) {
                return 'Uang Tidak Cukup Bayar';
            } else {
                $sisabayar = $nominal - $request->total_pembayaran;
                $list = DB::table('d_reg_order_list')->where('d_reg_order_code', $request->no_reg)->get();
                foreach ($list as $value) {
                    $check = DB::table('d_reg_order_payment')->where('d_reg_order_code', $request->no_reg)->where('d_reg_order_list_code', $value->d_reg_order_list_code)->first();
                    if ($check) {
                        return 'Sudah Pernah di bayar';
                    } else {
                        DB::table('d_reg_order_payment')->insert([
                            'd_reg_order_payment_code' => str::uuid(),
                            'd_reg_order_code' => $request->no_reg,
                            'd_reg_order_list_code' => $value->d_reg_order_list_code,
                            'd_reg_order_payment_date' => now(),
                            'd_reg_order_payment_user' => Auth::user()->userid,
                            'd_reg_order_payment_card' => $payment_card,
                            'd_reg_order_payment_total' => $request->total_pembayaran,
                            'created_at' => now()
                        ]);
                    }
                }
                return ' Berhasil Melakukan Payment, Sisa Bayar ' . $sisabayar;
            }
        } elseif ($request->payment_method == 'DEBIT') {
        } else {
            return 0;
        }
    }
    public function updateSplitItem(Request $request)
    {
        $request->validate([
            'detail_id'             => 'required|numeric',
            'tanggungan_pasien'     => 'required|numeric',
            'tanggungan_perusahaan' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $detailId = $request->detail_id;
            $tggPasien = (float) $request->tanggungan_pasien;
            $tggPerusahaan = (float) $request->tanggungan_perusahaan;

            // Ambil data detail transaksi
            $detail = DB::table('medical_transaksi_detail')->where('id', $detailId)->first();
            if (!$detail) {
                return response()->json(['success' => false, 'message' => 'Item detail tidak ditemukan.'], 404);
            }

            // Validasi agar total tanggungan tidak melebihi harga akhir item
            $hargaAkhir = (float) $detail->harga_akhir;
            if (round($tggPasien + $tggPerusahaan, 2) != round($hargaAkhir, 2)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total tanggungan pasien dan perusahaan harus sama dengan subtotal item (Rp ' . number_format($hargaAkhir, 0, ',', '.') . ')'
                ], 400);
            }

            // Update porsi tanggungan pada item detail tersebut
            DB::table('medical_transaksi_detail')
                ->where('id', $detailId)
                ->update([
                    'tanggungan_pasien'     => $tggPasien,
                    'tanggungan_perusahaan' => $tggPerusahaan,
                    'updated_at'            => now()
                ]);

            // Hitung ulang total tanggungan keseluruhan di tabel header transaksi utama
            $transaksiId = $detail->transaksi_id;
            if ($transaksiId) {
                $sumPasien = DB::table('medical_transaksi_detail')->where('transaksi_id', $transaksiId)->sum('tanggungan_pasien');
                $sumPerusahaan = DB::table('medical_transaksi_detail')->where('transaksi_id', $transaksiId)->sum('tanggungan_perusahaan');

                DB::table('medical_transaksi')
                    ->where('id', $transaksiId)
                    ->update([
                        'tanggungan_pasien'     => $sumPasien,
                        'tanggungan_perusahaan' => $sumPerusahaan,
                        'sisa_tagihan'          => $sumPerusahaan, // Menyesuaikan sisa piutang perusahaan
                        'updated_at'            => now()
                    ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Porsi split berhasil diperbarui dan disimpan ke database!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui porsi split: ' . $e->getMessage()
            ], 500);
        }
    }
    public function prosesPaymentParsial(Request $request)
    {
        $request->validate([
            'registrasi_id' => 'required',
            'metode_bayar'  => 'required|string',
            'nominal_bayar' => 'required|numeric',
            'item_ids'      => 'required|array', // ID detail item yang dicentang untuk dilunaskan
            'edc_id'        => 'nullable|numeric',
            'no_referensi'  => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $userId = Auth::user()->userid ?? 'SYSTEM';
            $registrasiId = $request->registrasi_id;

            // Ambil data registrasi utama
            $registrasi = DB::table('medical_registrasi')->where('id', $registrasiId)->first();
            if (!$registrasi) {
                return response()->json(['success' => false, 'message' => 'Data registrasi tidak ditemukan.'], 404);
            }

            // Ambil item-item detail yang dipilih kasir untuk dilunaskan pada pembayaran ini
            $selectedDetails = DB::table('medical_transaksi_detail')
                ->whereIn('id', $request->item_ids)
                ->where('status_pembayaran', '!=', 'LUNAS')
                ->get();

            if ($selectedDetails->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Tidak ada item valid yang dipilih atau item sudah lunas.'], 400);
            }

            // Hitung total tagihan dari item yang dipilih pada sesi pembayaran ini
            $subtotalBayarSesiIni = $selectedDetails->sum('tanggungan_pasien');
            $nominalBayarPasien = (float) $request->nominal_bayar;

            if ($nominalBayarPasien < $subtotalBayarSesiIni) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nominal bayar kurang dari total item porsi pasien yang dipilih (Rp ' . number_format($subtotalBayarSesiIni, 0, ',', '.') . ')'
                ], 400);
            }

            // 1. BUAT RECORD TRANSAKSI BARU KHUSUS UNTUK SESI PEMBAYARAN INI (Menerbitkan Nota ke-1, ke-2, dst)
            $transaksiBaruId = DB::table('medical_transaksi')->insertGetId([
                'registrasi_id'         => $registrasiId,
                'total_tagihan'         => $subtotalBayarSesiIni,
                'tanggungan_pasien'     => $subtotalBayarSesiIni,
                'tanggungan_perusahaan' => 0, // Perusahaan ditangani terpisah atau sesuai alur piutang
                'total_bayar'           => $nominalBayarPasien,
                'sisa_tagihan'          => 0,
                'metode_bayar'          => $request->metode_bayar,
                'status_pembayaran'     => 'LUNAS', // Karena sesi ini dibayar lunas oleh pasien
                'dibuat_oleh'           => $userId,
                'dilunasi_oleh'         => $userId,
                'waktu_lunas'           => now(),
                'created_at'            => now(),
                'updated_at'            => now(),
            ]);

            // 2. UPDATE STATUS ITEM DETAIL MENJADI LUNAS DAN KAITKAN KE TRANSAKSI PEMBAYARAN INI
            foreach ($selectedDetails as $detail) {
                DB::table('medical_transaksi_detail')
                    ->where('id', $detail->id)
                    ->update([
                        'transaksi_id'        => $transaksiBaruId, // Pindahkan/catat ke transaksi pembayaran nota ini
                        'status_pembayaran'   => 'LUNAS',
                        'waktu_bayar'         => now(),
                        'updated_at'          => now()
                    ]);
            }

            DB::commit();

            return response()->json([
                'success'      => true,
                'message'      => 'Pembayaran berhasil diproses dan nota pembayaran diterbitkan!',
                'transaksi_id' => $transaksiBaruId,
                'redirect_url' => route('pembayaran.nota', $transaksiBaruId)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pembayaran parsial: ' . $e->getMessage()
            ], 500);
        }
    }
    public function downloadReceiptPdf($orderCode)
    {
        try {
            // 1. Ambil data utama Registrasi, Transaksi, Pasien, Dokter, dan Sub Penjamin
            $transaksi = DB::table('medical_registrasi as reg')
                ->join('medical_patient as pt', 'reg.pasien_id', '=', 'pt.id')
                ->join('medical_transaksi as t', 'reg.id', '=', 't.registrasi_id')
                ->leftJoin('medical_master_doctor as doc_pengirim', 'doc_pengirim.id', '=', 'reg.doctor_id') // Sesuaikan jika ada kolom dokter pengirim/pemeriksa
                ->leftJoin('medical_master_doctor as doc_poli', 'doc_poli.id', '=', 'reg.doctor_poli_id')
                ->leftJoin('medical_sub_penjamin as sp', 'reg.sub_penjamin_id', '=', 'sp.id')
                ->select(
                    'reg.id as registrasi_id',
                    'reg.no_registrasi',
                    'reg.tanggal_registrasi',
                    'reg.jenis_layanan',
                    'reg.metode_pengiriman',
                    'reg.janji_hasil',
                    'pt.pid',
                    'pt.nama as nama_pasien',
                    'pt.alamat',
                    'pt.jk',
                    'pt.tgl_lahir',
                    'sp.nama_sub_penjamin as agreement',
                    't.id as transaksi_id',
                    't.total_tagihan',
                    't.total_bayar',
                    't.metode_bayar',
                    't.status_pembayaran',
                    'doc_pengirim.nama_lengkap as nama_dokter_pengirim',
                    'doc_poli.nama_lengkap as nama_dokter_poli'
                )
                ->where('reg.no_registrasi', $orderCode)
                ->first();

            if (!$transaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data order registrasi tidak ditemukan.'
                ], 404);
            }

            // 2. Hitung Umur Pasien Berdasarkan Tanggal Lahir
            $umur = '-';
            if (!empty($transaksi->tgl_lahir)) {
                $umur = \Carbon\Carbon::parse($transaksi->tgl_lahir)->age;
            }
            $transaksi->umur = $umur;

            // 3. Ambil Detail Item Pemeriksaan
            $details = DB::table('medical_transaksi_detail as td')
                ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
                ->where('td.transaksi_id', $transaksi->transaksi_id)
                ->select(
                    'td.id as detail_id',
                    'td.no_pemeriksaan',
                    'mp.nama_layanan',
                    'td.harga_dasar',
                    'td.diskon',
                    'td.biaya_cito',
                    'td.harga_akhir',
                    'td.status_pemeriksaan'
                )
                ->get();

            if ($details->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada item pemeriksaan ditemukan pada transaksi ini.'
                ], 404);
            }

            // 4. Render ke PDF View menggunakan DomPDF
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('application.keuangan.menu-cashier.report.bukti_pembayaran', [
                'transaksi' => $transaksi,
                'details'   => $details
            ])->setPaper('a4', 'portrait');

            return $pdf->download("Nota_Pembayaran_{$orderCode}.pdf");
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mencetak PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    // 1. Ambil daftar transaksi lunas yang dilunasi oleh petugas keuangan login tapi belum dibuatkan laporan
    public function getBelumDilaporkanKeuangan(Request $request)
    {
        try {
            $userId = (string) Auth::user()->userid;

            $data = DB::table('medical_registrasi')
                ->leftJoin('medical_patient', 'medical_registrasi.pasien_id', '=', 'medical_patient.id')
                ->leftJoin('medical_master_poli', 'medical_registrasi.poli_id', '=', 'medical_master_poli.id')
                ->leftJoin('medical_master_doctor', 'medical_registrasi.doctor_id', '=', 'medical_master_doctor.id')
                ->join('medical_transaksi', 'medical_transaksi.registrasi_id', '=', 'medical_registrasi.id')
                // Filter: Hanya yang dilunasi oleh user keuangan yang sedang login
                ->where('medical_transaksi.dilunasi_oleh', $userId)
                ->where('medical_transaksi.status_pembayaran', 'LUNAS')
                // Pastikan belum pernah masuk ke laporan keuangan manapun
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('medical_laporan_keuangan_detail')
                        ->whereColumn('medical_laporan_keuangan_detail.transaksi_id', 'medical_transaksi.id');
                })
                ->select(
                    'medical_transaksi.id as transaksi_id',
                    'medical_registrasi.tanggal_registrasi',
                    'medical_registrasi.no_registrasi',
                    'medical_registrasi.jenis_layanan',
                    'medical_patient.nama as nama_pasien',
                    'medical_patient.pid',
                    'medical_master_poli.nama_poli',
                    'medical_master_doctor.nama_lengkap as nama_dokter',
                    'medical_transaksi.metode_bayar',
                    'medical_transaksi.total_tagihan'
                )
                ->orderBy('medical_registrasi.tanggal_registrasi', 'asc')
                ->get()
                ->map(function ($item) {
                    return [
                        'transaksi_id' => $item->transaksi_id,
                        'tanggal_registrasi' => Carbon::parse($item->tanggal_registrasi)->format('d-m-Y H:i'),
                        'no_registrasi' => $item->no_registrasi ?? '-',
                        'nama_pasien' => $item->nama_pasien ?? 'Pasien Umum',
                        'pid' => $item->pid ?? '-',
                        'layanan' => str_replace('_', ' ', $item->jenis_layanan),
                        'poli' => $item->nama_poli ?? '-',
                        'nama_dokter' => $item->nama_dokter ?? '-',
                        'metode_bayar' => $item->metode_bayar ?? 'CASH',
                        'total_tagihan' => $item->total_tagihan ?? 0,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // 2. Simpan laporan keuangan yang dibuat oleh bagian keuangan
    public function storeLaporanKeuanganKeuangan(Request $request)
    {
        DB::beginTransaction();
        try {
            $userId = (string) Auth::user()->userid;
            $transaksiIds = $request->input('transaksi_ids', []);

            if (empty($transaksiIds)) {
                return response()->json(['success' => false, 'message' => 'Tidak ada transaksi yang dipilih untuk dilaporkan!'], 400);
            }

            // Validasi: Pastikan transaksi benar-benar dilunasi oleh user ini dan statusnya LUNAS
            $invalidTransaksi = DB::table('medical_transaksi')
                ->whereIn('id', $transaksiIds)
                ->where(function ($query) use ($userId) {
                    $query->where('dilunasi_oleh', '!=', $userId)
                        ->orWhere('status_pembayaran', '!=', 'LUNAS');
                })
                ->exists();

            if ($invalidTransaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Beberapa transaksi yang dipilih tidak valid atau bukan hasil pelunasan Anda!'
                ], 400);
            }

            $totalSetoran = DB::table('medical_transaksi')->whereIn('id', $transaksiIds)->sum('total_tagihan');
            $noLaporan = 'LAP-KEU-' . date('Ymd') . '-' . rand(1000, 9999);

            // Simpan ke master laporan keuangan
            $laporanId = DB::table('medical_laporan_keuangan')->insertGetId([
                'no_laporan'        => $noLaporan,
                'user_id'           => $userId,
                'total_setoran'     => $totalSetoran,
                'jumlah_transaksi'  => count($transaksiIds),
                'status_verifikasi' => 'PENDING', // Karena dibuat langsung oleh keuangan
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            // Simpan ke detail pivot
            $detailData = [];
            foreach ($transaksiIds as $txId) {
                $detailData[] = [
                    'laporan_id'   => $laporanId,
                    'transaksi_id' => $txId,
                ];
            }
            DB::table('medical_laporan_keuangan_detail')->insert($detailData);

            // Catat log trail
            DB::table('medical_laporan_keuangan_log')->insert([
                'laporan_id' => $laporanId,
                'user_id'    => $userId,
                'aksi'       => 'DISETUJUI',
                'catatan'    => 'Laporan keuangan pelunasan piutang/transaksi dibuat langsung oleh bagian keuangan.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success'    => true,
                'message'    => 'Laporan keuangan berhasil dibuat dengan No Nota: ' . $noLaporan,
                'no_laporan' => $noLaporan
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses laporan: ' . $e->getMessage()
            ], 500);
        }
    }
    // PERNERIMAAN TRANSAKSI
    public function keuangan_penerimaan_transaksi($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('application.keuangan.transaksi-penerimaan', [
                'akses' => $akses,
                'code' => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

    // Method untuk menangani AJAX Filter Data Table Keuangan
    public function keuangan_penerimaan_get_data(Request $request)
    {
        $query = DB::table('medical_laporan_keuangan as lk')
            ->leftJoin('user_mains as u_penyetor', 'lk.user_id', '=', 'u_penyetor.userid')
            ->leftJoin('user_mains as u_pemeriksa', 'lk.diperiksa_oleh', '=', 'u_pemeriksa.userid')
            ->select(
                'lk.*',
                'u_penyetor.fullname as nama_penyetor',
                'u_pemeriksa.fullname as nama_pemeriksa'
            );

        // Filter Tanggal Awal & Tanggal Akhir (berdasarkan created_at atau tanggal laporan)
        if (!empty($request->tgl_awal) && !empty($request->tgl_akhir)) {
            $query->whereDate('lk.created_at', '>=', $request->tgl_awal)
                ->whereDate('lk.created_at', '<=', $request->tgl_akhir);
        }

        // Filter Berdasarkan No Laporan
        if (!empty($request->no_laporan)) {
            $query->where('lk.no_laporan', 'LIKE', '%' . $request->no_laporan . '%');
        }

        // Filter Berdasarkan Nama Penyetor (fullname atau userid)
        if (!empty($request->nama_penyetor)) {
            $query->where(function ($q) use ($request) {
                $q->where('u_penyetor.fullname', 'LIKE', '%' . $request->nama_penyetor . '%')
                    ->orWhere('lk.user_id', 'LIKE', '%' . $request->nama_penyetor . '%');
            });
        }

        $data = $query->orderBy('lk.created_at', 'DESC')->get()->map(function ($item) {
            return [
                'id'                => $item->id,
                'no_laporan'        => $item->no_laporan,
                // Menampilkan fullname penyetor (jika kosong, fallback ke user_id aslinya)
                'user_id'           => $item->nama_penyetor ?? $item->user_id,
                'total_setoran'     => $item->total_setoran,
                'jumlah_transaksi'  => $item->jumlah_transaksi,
                'status_verifikasi' => $item->status_verifikasi,
                // Menampilkan fullname pemeriksa/keuangan (jika kosong, fallback ke diperiksa_oleh aslinya)
                'diperiksa_oleh'    => $item->nama_pemeriksa ?? $item->diperiksa_oleh ?? null,
                'waktu_diperiksa'   => $item->waktu_diperiksa ? \Carbon\Carbon::parse($item->waktu_diperiksa)->format('d-m-Y H:i') : null,
                'catatan'           => $item->catatan ?? null,
                'created_at'        => $item->created_at,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }
    public function keuangan_penerimaan_proses_transaksi(Request $request)
    {
        // 1. Ambil data laporan keuangan utama berdasarkan ID laporan
        $laporan = DB::table('medical_laporan_keuangan')
            ->where('id', $request->code)
            ->first();

        // 2. Ambil daftar transaksi yang terikat pada laporan ini melalui tabel pivot medical_laporan_keuangan_detail
        $transaksiList = DB::table('medical_laporan_keuangan_detail')
            ->join('medical_transaksi', 'medical_transaksi.id', '=', 'medical_laporan_keuangan_detail.transaksi_id')
            ->join('medical_registrasi', 'medical_registrasi.id', '=', 'medical_transaksi.registrasi_id')
            ->join('medical_patient', 'medical_patient.id', '=', 'medical_registrasi.pasien_id')
            // Left join ke Sub Penjamin menggunakan tabel 'medical_sub_penjamin'
            ->leftJoin('medical_sub_penjamin', 'medical_sub_penjamin.id', '=', 'medical_registrasi.sub_penjamin_id')
            // Left join ke Master Dokter Pemeriksa
            ->leftJoin('medical_master_doctor', 'medical_master_doctor.id', '=', 'medical_registrasi.doctor_poli_id')
            ->where('medical_laporan_keuangan_detail.laporan_id', $request->code)
            ->select(
                'medical_transaksi.*',
                'medical_registrasi.no_registrasi',
                'medical_registrasi.jenis_layanan',
                'medical_registrasi.tanggal_registrasi',
                'medical_patient.id as pasien_id',
                'medical_patient.pid',
                'medical_patient.awalan',
                'medical_patient.nama',
                'medical_patient.akhiran',
                'medical_patient.jk',
                'medical_patient.tempat_lahir',
                'medical_patient.tgl_lahir',
                'medical_patient.no_hp',
                'medical_patient.no_id', // NIK KTP / SIM
                'medical_patient.alamat',
                'medical_patient.foto', // Base64 atau path foto
                // Memanggil kolom dari tabel medical_sub_penjamin
                'medical_sub_penjamin.nama_sub_penjamin',
                'medical_master_doctor.nama_lengkap as nama_dokter_pemeriksa'
            )
            ->get();

        // 3. Looping setiap transaksi untuk mengambil rincian item pemeriksaannya (medical_transaksi_detail)
        foreach ($transaksiList as $trx) {
            $trx->items_pemeriksaan = DB::table('medical_transaksi_detail')
                ->leftJoin('medical_master_pemeriksaan', 'medical_master_pemeriksaan.id', '=', 'medical_transaksi_detail.master_pemeriksaan_id')
                ->where('medical_transaksi_detail.transaksi_id', $trx->id)
                ->select(
                    'medical_transaksi_detail.*',
                    'medical_master_pemeriksaan.nama_layanan'
                )
                ->get();
        }

        // Ambil sampel data pasien pertama untuk ditampilkan pada header profil form
        $dataPasien = $transaksiList->first();

        return view('application.keuangan.transaksi-penerimaan.form-proses-transaksi', [
            'laporan'       => $laporan,
            'transaksiList' => $transaksiList,
            'data'          => $dataPasien
        ]);
    }
    public function verifikasiLaporanSetoran(Request $request)
    {
        DB::beginTransaction();
        try {
            $userId = (string) Auth::user()->userid; // ID Petugas Keuangan yang login
            $laporanId = $request->input('laporan_id');
            $catatan = $request->input('catatan', 'Laporan keuangan telah diverifikasi dan disetujui.');

            if (empty($laporanId)) {
                return response()->json(['success' => false, 'message' => 'ID Laporan tidak ditemukan!'], 400);
            }

            // 1. Ambil data laporan
            $laporan = DB::table('medical_laporan_keuangan')->where('id', $laporanId)->first();

            if (!$laporan) {
                return response()->json(['success' => false, 'message' => 'Data laporan keuangan tidak ditemukan!'], 404);
            }

            if ($laporan->status_verifikasi === 'DISETUJUI') {
                return response()->json(['success' => false, 'message' => 'Laporan ini sudah pernah disetujui sebelumnya!'], 400);
            }

            // 2. Update status verifikasi pada tabel master laporan keuangan
            DB::table('medical_laporan_keuangan')
                ->where('id', $laporanId)
                ->update([
                    'status_verifikasi' => 'DISETUJUI',
                    'diperiksa_oleh'    => $userId,
                    'waktu_diperiksa'   => now(),
                    'catatan_verifikasi'           => $catatan, // <--- Tambahkan ini jika kolomnya ada di tabel medical_laporan_keuangan
                    'updated_at'        => now()
                ]);

            // 3. Catat rekam jejak audit (Log Trail) siapa yang menyetujui
            DB::table('medical_laporan_keuangan_log')->insert([
                'laporan_id' => $laporanId,
                'user_id'    => $userId, // ID Petugas Keuangan
                'aksi'       => 'DISETUJUI',
                'catatan'    => $catatan,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 4. (Opsional) Pastikan semua transaksi yang terikat pada laporan ini
            // tercatat waktu lunas dan dilunasi oleh petugas keuangan jika belum
            $transaksiIds = DB::table('medical_laporan_keuangan_detail')
                ->where('laporan_id', $laporanId)
                ->pluck('transaksi_id');

            if (!empty($transaksiIds)) {
                DB::table('medical_transaksi')
                    ->whereIn('id', $transaksiIds)
                    ->whereNull('dilunasi_oleh')
                    ->update([
                        'dilunasi_oleh' => $userId,
                        'waktu_lunas'   => now(),
                        'updated_at'    => now()
                    ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Laporan setoran berhasil disetujui dan diverifikasi oleh bagian keuangan!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memverifikasi laporan: ' . $e->getMessage()
            ], 500);
        }
    }
    // PENAGIHAN TRANSAKSI KEUANGAN
    public function penagihan_transaksi_keuangan($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Ambil daftar sub penjamin/perusahaan untuk filter dropdown
            $subPenjamins = DB::table('medical_sub_penjamin')->orderBy('nama_sub_penjamin', 'asc')->get();

            return view('application.keuangan.penagihan-transaksi-keuangan', [
                'akses' => $akses,
                'code' => $id,
                'subPenjamins' => $subPenjamins
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function apiGetPenagihanPerusahaan(Request $request)
    {
        try {
            $startDate = $request->input('start_date', date('Y-m-d'));
            $endDate = $request->input('end_date', date('Y-m-d'));
            $penjaminId = $request->input('penjamin');
            $status = $request->input('status', 'BELUM LUNAS'); // Default belum lunas/tertangguhkan
            $keyword = $request->input('keyword');

            $query = DB::table('medical_transaksi as mt')
                ->join('medical_registrasi as mr', 'mt.registrasi_id', '=', 'mr.id')
                ->join('medical_patient as mp', 'mr.pasien_id', '=', 'mp.id')
                ->leftJoin('medical_sub_penjamin as msp', 'mr.sub_penjamin_id', '=', 'msp.id')
                ->select(
                    'mt.id as transaksi_id',
                    'mt.registrasi_id',
                    'mr.no_registrasi',
                    'mr.tanggal_registrasi',
                    'mp.pid',
                    'mp.nama as nama_pasien',
                    'mp.title',
                    'mp.awalan',
                    'mp.akhiran',
                    'msp.nama_sub_penjamin',
                    'mt.total_tagihan',
                    'mt.tanggungan_pasien',
                    'mt.tanggungan_perusahaan',
                    'mt.sisa_tagihan',
                    'mt.status_pembayaran',
                    'mt.metode_bayar'
                )
                ->where('mt.tanggungan_perusahaan', '>', 0) // Hanya transaksi yang memiliki tanggungan perusahaan
                ->when($startDate && $endDate, function ($q) use ($startDate, $endDate) {
                    $q->whereDate('mr.tanggal_registrasi', '>=', $startDate)
                        ->whereDate('mr.tanggal_registrasi', '<=', $endDate);
                })
                ->when($penjaminId, function ($q) use ($penjaminId) {
                    $q->where('mr.sub_penjamin_id', $penjaminId);
                })
                ->when($status, function ($q) use ($status) {
                    if ($status !== 'SEMUA') {
                        if ($status === 'BELUM LUNAS') {
                            $q->where(function ($sub) {
                                $sub->where('mt.status_pembayaran', '!=', 'LUNAS')
                                    ->orWhereNull('mt.status_pembayaran');
                            });
                        } else {
                            $q->where('mt.status_pembayaran', 'like', "%{$status}%");
                        }
                    }
                })
                ->when($keyword, function ($q) use ($keyword) {
                    $q->where(function ($sub) use ($keyword) {
                        $sub->where('mr.no_registrasi', 'like', "%{$keyword}%")
                            ->orWhere('mp.nama', 'like', "%{$keyword}%")
                            ->orWhere('mp.pid', 'like', "%{$keyword}%");
                    });
                })
                ->orderBy('mr.tanggal_registrasi', 'desc');

            $data = $query->get()->map(function ($item) {
                // Format nama lengkap pasien menggunakan title, awalan, dan akhiran dari tabel medical_patient
                $item->nama_pasien_lengkap = trim(($item->title ? $item->title . ' ' : '') . $item->nama_pasien . ($item->akhiran ? ', ' . $item->akhiran : ''));
                return $item;
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data penagihan: ' . $e->getMessage()
            ], 500);
        }
    }
    public function apiGetDaftarPenagihanPerusahaan(Request $request)
    {
        try {
            $penjaminId = $request->input('penjamin');
            $noTagihan = $request->input('keyword');
            $status = $request->input('status', 'DRAFT');

            $query = DB::table('medical_penagihan_perusahaan as mpp')
                ->join('medical_sub_penjamin as msp', 'mpp.sub_penjamin_id', '=', 'msp.id')
                ->select(
                    'mpp.id as penagihan_id',
                    'mpp.no_tagihan',
                    'mpp.tanggal_tagihan',
                    'mpp.status_tagihan',
                    'mpp.total_tagihan',
                    'msp.nama_sub_penjamin'
                )
                ->when($penjaminId, function ($q) use ($penjaminId) {
                    $q->where('mpp.sub_penjamin_id', $penjaminId);
                })
                ->when($noTagihan, function ($q) use ($noTagihan) {
                    $q->where('mpp.no_tagihan', 'like', "%{$noTagihan}%");
                })
                ->when($status, function ($q) use ($status) {
                    if ($status !== 'SEMUA') {
                        $q->where('mpp.status_tagihan', $status);
                    }
                })
                ->orderBy('mpp.id', 'desc');

            $data = $query->get();

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat daftar penagihan: ' . $e->getMessage()
            ], 500);
        }
    }
    public function prosesPelunasanPiutangPerusahaan(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required|numeric',
            'metode_bayar' => 'required|string', // Transfer / Giro / Piutang Lunas
            'nominal_bayar' => 'required|numeric',
            'no_referensi' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $userId = Auth::user()->userid ?? 'SYSTEM';
            $transaksiId = $request->transaksi_id;

            $transaksi = DB::table('medical_transaksi')->where('id', $transaksiId)->first();
            if (!$transaksi) {
                return response()->json(['success' => false, 'message' => 'Data transaksi tidak ditemukan.'], 404);
            }

            // Update status pembayaran piutang perusahaan menjadi lunas
            DB::table('medical_transaksi')
                ->where('id', $transaksiId)
                ->update([
                    'total_bayar' => DB::raw('total_bayar + ' . $request->nominal_bayar),
                    'sisa_tagihan' => 0,
                    'status_pembayaran' => 'LUNAS',
                    'dilunasi_oleh' => $userId,
                    'waktu_lunas' => now(),
                    'updated_at' => now()
                ]);

            // Update detail item yang tanggungan perusahaannya belum lunas
            DB::table('medical_transaksi_detail')
                ->where('transaksi_id', $transaksiId)
                ->where('tanggungan_perusahaan', '>', 0)
                ->update([
                    'status_pembayaran' => 'LUNAS',
                    'waktu_bayar' => now(),
                    'updated_at' => now()
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pelunasan piutang perusahaan berhasil dicatat dan diselesaikan!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pelunasan: ' . $e->getMessage()
            ], 500);
        }
    }
    public function buatTagihanPerusahaan(Request $request)
    {
        $request->validate([
            'sub_penjamin_id' => 'required|numeric',
            'tanggal_tagihan' => 'required|date',
            'transaksi_ids'   => 'required|array', // Menerima array ID transaksi pasien yang dicentang
        ]);

        try {
            DB::beginTransaction();

            $tanggalHariIni = date('Ymd');
            $lastTagihan = DB::table('medical_penagihan_perusahaan')
                ->where('no_tagihan', 'like', "TGH-{$tanggalHariIni}-%")
                ->orderBy('id', 'desc')
                ->first();

            $noUrut = $lastTagihan ? (int) substr($lastTagihan->no_tagihan, -4) + 1 : 1;
            $noTagihanBaru = 'TGH-' . $tanggalHariIni . '-' . str_pad($noUrut, 4, '0', STR_PAD_LEFT);

            $userId = Auth::user()->userid ?? 'SYSTEM';

            // Hitung total tanggungan perusahaan dari transaksi yang dipilih
            $totalTagihanPrsh = DB::table('medical_transaksi')
                ->whereIn('id', $request->transaksi_ids)
                ->sum('tanggungan_perusahaan');

            // Simpan Header Tagihan
            $tagihanId = DB::table('medical_penagihan_perusahaan')->insertGetId([
                'no_tagihan'      => $noTagihanBaru,
                'tanggal_tagihan' => $request->tanggal_tagihan,
                'sub_penjamin_id' => $request->sub_penjamin_id,
                'total_tagihan'   => $totalTagihanPrsh,
                'status_tagihan'  => 'DRAFT',
                'dibuat_oleh'     => $userId,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            // Simpan Detail Transaksi ke Tagihan
            foreach ($request->transaksi_ids as $transaksiId) {
                DB::table('medical_penagihan_detail')->insert([
                    'penagihan_id' => $tagihanId,
                    'transaksi_id' => $transaksiId,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }

            DB::commit();

            return response()->json([
                'success'    => true,
                'message'    => 'Nomor tagihan berhasil dibuat dan nota pasien berhasil dimasukkan!',
                'tagihan_id' => $tagihanId,
                'no_tagihan' => $noTagihanBaru
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat tagihan: ' . $e->getMessage()
            ], 500);
        }
    }

    // 2. Ambil Daftar Pasien / Transaksi Piutang Berdasarkan Sub Penjamin yang Belum Ditagih
    public function getPasienBySubPenjamin(Request $request)
    {
        try {
            $subPenjaminId = $request->input('sub_penjamin_id');

            // Ambil ID transaksi yang sudah terdaftar di penagihan manapun
            $transaksiSudahDitagih = DB::table('medical_penagihan_detail')->pluck('transaksi_id');

            $data = DB::table('medical_transaksi as mt')
                ->join('medical_registrasi as mr', 'mt.registrasi_id', '=', 'mr.id')
                ->join('medical_patient as mp', 'mr.pasien_id', '=', 'mp.id')
                ->select(
                    'mt.id as transaksi_id',
                    'mr.no_registrasi',
                    'mr.tanggal_registrasi',
                    'mp.pid',
                    'mp.nama as nama_pasien',
                    'mp.title',
                    'mp.akhiran',
                    'mt.tanggungan_perusahaan',
                    'mt.status_pembayaran'
                )
                ->where('mr.sub_penjamin_id', $subPenjaminId)
                ->where('mt.tanggungan_perusahaan', '>', 0)
                ->where('mt.status_pembayaran', '!=', 'LUNAS')
                ->whereNotIn('mt.id', $transaksiSudahDitagih) // KUNCI UTAMA: Agar tidak bisa masuk penagihan lain
                ->get()
                ->map(function ($item) {
                    $item->nama_lengkap = trim(($item->title ? $item->title . ' ' : '') . $item->nama_pasien . ($item->akhiran ? ', ' . $item->akhiran : ''));
                    return $item;
                });

            return response()->json([
                'success' => true,
                'data'    => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data pasien: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getRincianItemTransaksi(Request $request)
    {
        try {
            $transaksiIds = $request->input('transaksi_ids', []);

            if (empty($transaksiIds)) {
                return response()->json([
                    'success' => true,
                    'items'   => [],
                    'total'   => 0
                ]);
            }

            $items = DB::table('medical_transaksi_detail')
                ->whereIn('transaksi_id', $transaksiIds)
                ->where('tanggungan_perusahaan', '>', 0)
                ->select(
                    'id',
                    'transaksi_id',
                    'jenis_item', // Misal: TINDAKAN, OBAT, ADMINISTRASI, KAMAR_INAP, dll
                    'nama_item',
                    'qty',
                    'harga_akhir',
                    'tanggungan_perusahaan'
                )
                ->get();

            $totalNominalPerusahaan = $items->sum('tanggungan_perusahaan');

            return response()->json([
                'success' => true,
                'items'   => $items,
                'total'   => $totalNominalPerusahaan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat rincian item: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getDetailPenagihan($id)
    {
        try {
            $data = DB::table('medical_penagihan_perusahaan as mpp')
                ->join('medical_sub_penjamin as msp', 'mpp.sub_penjamin_id', '=', 'msp.id')
                ->select('mpp.*', 'msp.nama_sub_penjamin', 'msp.telp_perusahaan', 'msp.alamat')
                ->where('mpp.id', $id)
                ->first();

            if (!$data) {
                return response()->json(['success' => false, 'message' => 'Data penagihan tidak ditemukan.'], 404);
            }

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Pelunasan seluruh transaksi dalam 1 nomor penagihan
    public function prosesPelunasanPenagihanPerusahaan(Request $request)
    {
        $request->validate([
            'penagihan_id' => 'required|numeric',
            'metode_bayar' => 'required|string',
            'no_referensi' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $penagihanId = $request->penagihan_id;

            // Ambil semua transaksi_id yang terikat pada penagihan ini
            $transaksiIds = DB::table('medical_penagihan_detail')
                ->where('penagihan_id', $penagihanId)
                ->pluck('transaksi_id');

            // Update status header penagihan menjadi LUNAS
            DB::table('medical_penagihan_perusahaan')
                ->where('id', $penagihanId)
                ->update([
                    'status_tagihan' => 'LUNAS',
                    'updated_at' => now()
                ]);

            // Update status transaksi utama & item detail terkait menjadi LUNAS
            foreach ($transaksiIds as $tId) {
                DB::table('medical_transaksi')->where('id', $tId)->update([
                    'sisa_tagihan' => 0,
                    'status_pembayaran' => 'LUNAS',
                    'waktu_lunas' => now()
                ]);
                DB::table('medical_transaksi_detail')->where('transaksi_id', $tId)->update([
                    'status_pembayaran' => 'LUNAS',
                    'waktu_bayar' => now()
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pelunasan seluruh tagihan perusahaan berhasil diproses!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Generate PDF Tagihan (Bisa menggunakan DomPDF atau library PDF laravel)
    public function downloadPdfPenagihan($id)
    {
        // Ambil header penagihan dan informasi perusahaan/sub penjamin
        $penagihan = DB::table('medical_penagihan_perusahaan as mpp')
            ->join('medical_sub_penjamin as msp', 'mpp.sub_penjamin_id', '=', 'msp.id')
            ->select('mpp.*', 'msp.nama_sub_penjamin', 'msp.alamat', 'msp.telp_perusahaan')
            ->where('mpp.id', $id)
            ->first();

        if (!$penagihan) {
            abort(404, 'Data penagihan tidak ditemukan.');
        }

        // Ambil daftar transaksi pasien yang masuk dalam penagihan ini
        $details = DB::table('medical_penagihan_detail as mpd')
            ->join('medical_transaksi as mt', 'mpd.transaksi_id', '=', 'mt.id')
            ->join('medical_registrasi as mr', 'mt.registrasi_id', '=', 'mr.id')
            ->join('medical_patient as mp', 'mr.pasien_id', '=', 'mp.id')
            ->select(
                'mt.id as transaksi_id',
                'mr.no_registrasi',
                'mr.tanggal_registrasi',
                'mp.pid',
                'mp.nama as nama_pasien',
                'mp.title',
                'mp.akhiran',
                'mt.tanggungan_perusahaan'
            )
            ->where('mpd.penagihan_id', $id)
            ->get()
            ->map(function ($pasien) {
                // Format nama lengkap pasien
                $pasien->nama_lengkap = trim(($pasien->title ? $pasien->title . ' ' : '') . $pasien->nama_pasien . ($pasien->akhiran ? ', ' . $pasien->akhiran : ''));

                // Ambil rincian item (tindakan & obat) per transaksi pasien
                $pasien->items = DB::table('medical_transaksi_detail')
                    ->where('transaksi_id', $pasien->transaksi_id)
                    ->where('tanggungan_perusahaan', '>', 0)
                    ->select('jenis_item', 'nama_item', 'qty', 'tanggungan_perusahaan')
                    ->get();

                return $pasien;
            });

        // Return view template cetak / PDF
        return view('application.keuangan.penagihan-keuangan.pdf.pdf-tagihan-template', compact('penagihan', 'details'));
    }

    public function kirimPesanTagihan(Request $request)
    {
        $penagihanId = $request->penagihan_id;
        $tipe = $request->tipe_pengiriman;

        $penagihan = DB::table('medical_penagihan_perusahaan as mpp')
            ->join('medical_sub_penjamin as msp', 'mpp.sub_penjamin_id', '=', 'msp.id')
            ->select('mpp.*', 'msp.nama_sub_penjamin', 'msp.telp_perusahaan')
            ->where('mpp.id', $penagihanId)
            ->first();

        if (!$penagihan) {
            return response()->json(['success' => false, 'message' => 'Data penagihan tidak ditemukan.'], 404);
        }

        if ($tipe === 'whatsapp') {
            // Mengambil nomor telepon dari kolom telp_perusahaan
            $noTelp = preg_replace('/[^0-9]/', '', $penagihan->telp_perusahaan ?? '');

            if (empty($noTelp)) {
                return response()->json(['success' => false, 'message' => 'Nomor telepon / WhatsApp perusahaan belum diatur pada data sub penjamin.'], 400);
            }

            if (substr($noTelp, 0, 1) === '0') {
                $noTelp = '62' . substr($noTelp, 1);
            }

            $pesan = urlencode("Halo *{$penagihan->nama_sub_penjamin}*,\n\nBerikut disampaikan tagihan medis dengan No: *{$penagihan->no_tagihan}* sebesar *Rp " . number_format($penagihan->total_tagihan, 0, ',', '.') . "*.\nMohon segera dilakukan pelunasan. Terima kasih.");

            return response()->json([
                'success' => true,
                'whatsapp_url' => "https://api.whatsapp.com/send?phone={$noTelp}&text={$pesan}"
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Fitur pengiriman Email belum dikonfigurasi.'
            ]);
        }
    }
}
