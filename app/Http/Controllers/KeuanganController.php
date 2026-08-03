<?php

namespace App\Http\Controllers;

use App\Models\DRegOrder;
use App\Models\DRegOrderLabList;
use App\Models\DRegOrderList;
use App\Models\DRegOrderRadList;
use Barryvdh\DomPDF\Facade\Pdf;
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
            $pay = DB::table('m_pay')->get();
            return view('application.keuangan.menu-cashier', [
                'akses' => $akses,
                'code' => $id,
                'pay' => $pay
            ]);
        } else {
            return Redirect::to('dashboard/home');
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
    public function keuangan_menu_cashier_list_all_patient()
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
        // 1. Ambil data input dari request JSON front-end
        $dRegOrderCode = $request->input('d_reg_order_code'); // Kode order puncak (misal: ORD-001)
        $metodePembayaran = $request->input('metode_pembayaran'); // Mengisi d_reg_order_payment_card
        $items = $request->input('items'); // Array objek berisi ID dan kategori item

        if (empty($items)) {
            return response()->json(['success' => false, 'message' => 'Silakan pilih minimal satu item tindakan untuk dibayar!'], 400);
        }

        if (!$dRegOrderCode) {
            return response()->json(['success' => false, 'message' => 'Kode order puncak tidak valid.'], 400);
        }

        // Mulai transaksi database (jika di tengah jalan ada error, data otomatis di-rollback/batal)
        DB::beginTransaction();

        try {
            // Generasi nomor kwitansi/invoice unik terpusat untuk sesi pembayaran ini
            $paymentCode = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            // Variabel penampung akumulasi total uang riil yang dibayarkan saat membuat invoice ini
            $grandTotalInvoiceIni = 0;

            // Variabel pembantu untuk mencatat d_reg_order_list_code terakhir yang terlibat
            $lastOrderListCode = null;

            // 2. Loop & Update status item tindakan sekaligus hitung akumulasi harga bersihnya
            foreach ($items as $item) {
                if ($item['kategori'] === 'Layanan Laboratorium') {
                    // Cari data asli di DB untuk mengambil log price & discount (menghindari manipulasi front-end)
                    $labItem = DB::table('d_reg_order_lab_list')
                        ->where('id_d_reg_order_lab_list', $item['id'])
                        ->first();

                    if ($labItem) {
                        $lastOrderListCode = $labItem->d_reg_order_lab_code;

                        // Hitung harga bersih item ini (Harga - Diskon)
                        $biayaBersih = $labItem->order_lab_log_price - $labItem->order_lab_log_discount;
                        $grandTotalInvoiceIni += $biayaBersih;

                        // Ubah status item menjadi lunas
                        DB::table('d_reg_order_lab_list')
                            ->where('id_d_reg_order_lab_list', $item['id'])
                            ->update(['status_pembayaran' => 'Lunas']);
                    }
                } elseif ($item['kategori'] === 'Layanan Radiologi') {
                    $radItem = DB::table('d_reg_order_rad_list')
                        ->where('id_d_reg_order_rad_list', $item['id'])
                        ->first();

                    if ($radItem) {
                        $lastOrderListCode = $radItem->d_reg_order_rad_code;

                        $biayaBersih = $radItem->order_rad_log_price - $radItem->order_rad_log_discount;
                        $grandTotalInvoiceIni += $biayaBersih;

                        DB::table('d_reg_order_rad_list')
                            ->where('id_d_reg_order_rad_list', $item['id'])
                            ->update(['status_pembayaran' => 'Lunas']);
                    }
                } elseif ($item['kategori'] === 'Layanan Poliklinik') {
                    $radItem = DB::table('d_reg_order_poli_list')
                        ->where('id_d_reg_order_poli_list', $item['id'])
                        ->first();

                    if ($radItem) {
                        $lastOrderListCode = $radItem->d_reg_order_poli_code;

                        $biayaBersih = $radItem->order_poli_log_price - $radItem->order_poli_log_discount;
                        $grandTotalInvoiceIni += $biayaBersih;

                        DB::table('d_reg_order_poli_list')
                            ->where('id_d_reg_order_poli_list', $item['id'])
                            ->update(['status_pembayaran' => 'Lunas']);
                    }
                }
            }

            // 3. Simpan riwayat transaksi ke tabel d_reg_order_payment (Cukup 1 baris per nota invoice)
            DB::table('d_reg_order_payment')->insert([
                'd_reg_order_payment_code'  => $paymentCode,
                'd_reg_order_code'          => $dRegOrderCode,
                'd_reg_order_list_code'     => $lastOrderListCode ?? '-', // Kode jembatan d_reg_order_list
                'd_reg_order_payment_card'  => $metodePembayaran, // Simpan Tunai/Debit/QRIS
                'd_reg_order_payment_total' => $grandTotalInvoiceIni, // <--- TOTAL RIIL YANG DIBAYAR PASIEN PADA INVOICE INI
                'd_reg_order_payment_date'  => date('Y-m-d H:i:s'),
                'd_reg_order_payment_user'  => auth()->user()->name ?? 'System_Kasir',
                'created_at'                => now(),
                'updated_at'                => now()
            ]);

            // 4. SISTEM CHECK otomatis pelunasan tingkat puncak (d_reg_order)
            $cekLabSisa = DB::table('d_reg_order_lab_list')
                ->join('d_reg_order_list', 'd_reg_order_lab_list.d_reg_order_lab_code', '=', 'd_reg_order_list.d_reg_order_list_code')
                ->where('d_reg_order_list.d_reg_order_code', $dRegOrderCode)
                ->where('d_reg_order_lab_list.status_pembayaran', '!=', 'Lunas')
                ->exists();

            $cekRadSisa = DB::table('d_reg_order_rad_list')
                ->join('d_reg_order_list', 'd_reg_order_rad_list.d_reg_order_rad_code', '=', 'd_reg_order_list.d_reg_order_list_code')
                ->where('d_reg_order_list.d_reg_order_code', $dRegOrderCode)
                ->where('d_reg_order_rad_list.status_pembayaran', '!=', 'Lunas')
                ->exists();

            $cekPoliSisa = DB::table('d_reg_order_poli_list')
                ->join('d_reg_order_list', 'd_reg_order_poli_list.d_reg_order_poli_code', '=', 'd_reg_order_list.d_reg_order_list_code')
                ->where('d_reg_order_list.d_reg_order_code', $dRegOrderCode)
                ->where('d_reg_order_poli_list.status_pembayaran', '!=', 'Lunas')
                ->exists();

            if (!$cekLabSisa && !$cekRadSisa && !$cekPoliSisa) {
                DB::table('d_reg_order')
                    ->where('d_reg_order_code', $dRegOrderCode)
                    ->update(['d_reg_order_status' => 'Lunas']);
            }

            // Jika Poli, lab dan rad sudah tidak ada yang "Belum Lunas", tandai berkas pasien lunas total
            // Semua operasi aman, kunci perubahan ke database
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil disimpan!',
                'invoice_code' => $paymentCode,
                'total_dibayar' => $grandTotalInvoiceIni
            ], 200);
        } catch (\Exception $e) {
            // Jika terjadi kegagalan sistem, batalkan seluruh update status di atas
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
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
    public function downloadReceiptPdf($orderCode)
    {
        try {
            // 1. Ambil data utama Order/Registrasi & Pasien
            $order = DB::table('d_reg_order as r')
                ->leftJoin('master_patient as pt', 'r.d_reg_order_rm', '=', 'pt.master_patient_code')
                ->select(
                    'r.*',
                    'pt.master_patient_code',
                    'pt.master_patient_name',
                    'pt.master_patient_alamat'
                )
                ->where('r.d_reg_order_code', $orderCode)
                ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data order registrasi tidak ditemukan.'
                ], 404);
            }

            // 2. Query Item List dengan Join ke Lab, Rad, dan Poli
            $allItems = DB::table('d_reg_order_list as l')
                // Join ke detail Lab
                ->leftJoin('d_reg_order_lab_list as lab', 'l.d_reg_order_list_code', '=', 'lab.d_reg_order_lab_code')
                ->leftJoin('p_sales_data as s_lab', 'lab.p_sales_data_code', '=', 's_lab.p_sales_data_code')

                // Join ke detail Rad
                ->leftJoin('d_reg_order_rad_list as rad', 'l.d_reg_order_list_code', '=', 'rad.d_reg_order_rad_code')
                ->leftJoin('p_sales_data as s_rad', 'rad.p_sales_data_code', '=', 's_rad.p_sales_data_code')

                // Join ke detail Poli
                ->leftJoin('d_reg_order_poli_list as poli', 'l.d_reg_order_list_code', '=', 'poli.d_reg_order_poli_code')
                ->leftJoin('p_sales_data as s_poli', 'poli.p_sales_data_code', '=', 's_poli.p_sales_data_code')

                // Join ke Payment khusus log tanggal/metode
                ->leftJoin('d_reg_order_payment as p', 'l.d_reg_order_list_code', '=', 'p.d_reg_order_list_code')

                ->select(
                    'l.d_reg_order_list_code',
                    'l.t_layanan_cat_code',

                    // Nama Item / Layanan
                    DB::raw("COALESCE(s_lab.p_sales_data_name, s_rad.p_sales_data_name, s_poli.p_sales_data_name, CONCAT('Layanan ', l.t_layanan_cat_code)) as item_name"),

                    // Harga Log
                    DB::raw("COALESCE(lab.order_lab_log_price, rad.order_rad_log_price, poli.order_poli_log_price, 0) as price"),

                    // Diskon Log
                    DB::raw("COALESCE(lab.order_lab_log_discount, rad.order_rad_log_discount, poli.order_poli_log_discount, 0) as discount"),

                    'p.d_reg_order_payment_code',
                    'p.d_reg_order_payment_date',
                    'p.d_reg_order_payment_card',

                    // PENGECEKAN STATUS LUNAS DARI MASING-MASING TABEL LIST
                    DB::raw("
                CASE
                    WHEN COALESCE(lab.status_pembayaran, rad.status_pembayaran, poli.status_pembayaran, '') IN ('LUNAS', 'PAID', '1', 1) THEN 'LUNAS'
                    ELSE 'BELUM BAYAR'
                END as status_bayar
            ")
                )
                ->where('l.d_reg_order_code', $orderCode)
                ->get();

            // 3. FILTER STATUS LUNAS DAN DISTINCT/UNIQUE BERDASARKAN NAMA PEMERIKSAAN / KODE ITEM
            $items = $allItems->where('status_bayar', 'LUNAS')
                ->unique('item_name') // <--- DI-DISTINCT KAN BERDASARKAN NAMA PEMERIKSAAN
                ->values();

            // Cek jika tidak ada 1 pun item yang lunas
            if ($items->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Belum ada transaksi item yang lunas untuk dicetak pada order ini.'
                ], 404);
            }

            // 4. Hitung Total Pelunasan Murni dari 2 Item Unik Tersebut
            $totalLunas = $items->sum(function ($item) {
                return $item->price - $item->discount;
            });

            // 5. Render ke PDF View
            $pdf = Pdf::loadView('application.keuangan.menu-cashier.report.bukti_pembayaran', compact('order', 'items', 'totalLunas'))
                ->setPaper('a5', 'landscape');

            return $pdf->download("Kuitansi_Lunas_{$orderCode}.pdf");
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mencetak PDF: ' . $e->getMessage()
            ], 500);
        }
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
