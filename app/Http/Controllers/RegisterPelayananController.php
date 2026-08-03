<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterPelayananController extends Controller
{
    public function getSubSales(Request $request)
    {
        $mSalesCode = $request->m_sales_code;

        $subSales = DB::table('p_sales')
            ->select('p_sales_code', 'p_sales_name')
            ->where('p_m_sales_code', $mSalesCode)
            ->orderBy('p_sales_name', 'ASC')
            ->get();

        $html = '<option value="">-- Pilih Sub Sales / Agreement --</option>';
        foreach ($subSales as $sub) {
            $html .= '<option value="' . $sub->p_sales_code . '">' . $sub->p_sales_name . '</option>';
        }

        return response()->json([
            'status' => 'success',
            'html' => $html,
            'data' => $subSales
        ]);
    }

    /**
     * STEP 3: Pilih Sub Sales -> Ambil Paket / Kategori (p_sales_cat)
     */
    public function getPaketCat(Request $request)
    {
        $salesCode = $request->sales_code;

        $paketList = DB::table('p_sales_cat')
            ->select('p_sales_cat_code', 'p_sales_cat_name')
            ->where('p_sales_code', $salesCode)
            ->orderBy('p_sales_cat_name', 'ASC')
            ->get();

        $html = '<option value="">-- Pilih Paket / Kategori Radiologi --</option>';
        foreach ($paketList as $pkt) {
            $html .= '<option value="' . $pkt->p_sales_cat_code . '">' . $pkt->p_sales_cat_name . '</option>';
        }

        return response()->json([
            'status' => 'success',
            'html' => $html,
            'data' => $paketList
        ]);
    }

    /**
     * STEP 4: Pilih Paket -> Ambil List Item Pemeriksaan Radiologi (p_sales_data)
     */
    public function getItemPemeriksaanRad(Request $request)
    {
        $catCode = $request->cat_code;

        // Mengambil daftar tindakan/pemeriksaan Radiologi berdasarkan kategori
        $items = DB::table('p_sales_data')
            ->select(
                'p_sales_data_code as rad_item_code', // atau 'id' / 'item_code'
                'p_sales_data_name as rad_item_name',
                'p_sales_data_price as price'         // sesuaikan jika nama kolom harga adalah 'price' / 'p_sales_data_price'
            )
            ->where('p_sales_cat_code', $catCode)
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $items
        ]);
    }

    /**
     * PROSES FIX REGISTRASI RADIOLOGI
     */
    public function fixRegistrasiRad(Request $request)
    {
        // 1. Validasi Input Data
        $request->validate([
            'no_rm'        => 'required|string',
            'date'         => 'required|date',
            'rujukan'      => 'required|string',
            'items'        => 'required|array|min:1',
            'items.*.code' => 'required|string',
            'items.*.price' => 'required|numeric',
            // 'file_rujukan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120' // Maks 5MB
        ]);

        DB::beginTransaction();

        try {
            $userLogin   = Auth::user()->name ?? 'System';
            $tglPeriksa  = $request->date;
            $nowTime     = now();

            // Handle Upload File Rujukan (jika ada)
            $filePath = null;
            if ($request->hasFile('file_rujukan')) {
                $filePath = $request->file('file_rujukan')->store('rujukan_radiologi', 'public');
            }

            // Generate Kode Unik
            $orderCode    = 'ORD-' . date('YmdHis') . '-' . rand(100, 999);
            $orderRadCode = 'RAD-' . date('YmdHis') . '-' . rand(100, 999);

            // -------------------------------------------------------------
            // TABEL 1: d_reg_order
            // -------------------------------------------------------------
            DB::table('d_reg_order')->insert([
                'd_reg_order_code'   => $orderCode,
                'd_reg_order_rm'     => $request->no_rm,
                'd_reg_order_date'   => $tglPeriksa,
                't_layanan_cat_code' => $request->t_layanan_cat_code ?? 'RAD', // Kode layanan Radiologi
                't_pasien_cat_code'  => $request->patient_cat ?? 'pribadi',
                'd_reg_order_status' => 'PENDING',
                'd_reg_order_user'   => Auth::user()->userid,
                'd_reg_order_cabang' => '-',
                'created_at'         => $nowTime,
                'updated_at'         => $nowTime,
            ]);

            // -------------------------------------------------------------
            // TABEL 2: d_reg_order_list
            // -------------------------------------------------------------
            DB::table('d_reg_order_list')->insert([
                'd_reg_order_list_code' => $orderRadCode,
                'd_reg_order_code'      => $orderCode,
                't_layanan_cat_code'    => 'RAD',
                'd_reg_order_list_date' => $tglPeriksa,
                'created_at'            => $nowTime,
                'updated_at'            => $nowTime,
            ]);

            // -------------------------------------------------------------
            // TABEL 3: d_reg_order_rad
            // -------------------------------------------------------------
            DB::table('d_reg_order_rad')->insert([
                'd_reg_order_rad_code'       => $orderRadCode,
                'd_reg_order_code'           => $orderCode,
                'd_reg_order_rad_dr_rujukan' => $request->rujukan,
                'd_reg_order_rad_dr_baca'    => $request->dr_baca ?? '', // Dokter spesialis Radiologi
                'd_reg_order_rad_date'       => $tglPeriksa,
                'd_reg_order_rad_desc'       => $filePath ?? '', // Menyimpan path file rujukan/keterangan
                'd_reg_order_rad_number'     => 'RAD-NO-' . rand(1000, 9999),
                'd_reg_order_rad_status'     => 'PENDING',
                'd_reg_order_rad_user'       => $userLogin,
                'created_at'                 => $nowTime,
                'updated_at'                 => $nowTime,
            ]);

            // -------------------------------------------------------------
            // TABEL 4: d_reg_order_rad_list (Looping Item Pemeriksaan)
            // -------------------------------------------------------------
            $itemsData = [];
            foreach ($request->items as $index => $item) {
                $uniqueCode = 'R' . date('ymd') . '' . Str::upper(Str::random(2)) . '' . sprintf("%02d", $index + 1);
                $itemsData[] = [
                    'order_rad_list_code'    => $uniqueCode,
                    'd_reg_order_rad_code'   => $orderRadCode,
                    'p_sales_data_code'      => $item['code'],
                    'order_rad_log_price'    => (int) $item['price'],
                    'order_rad_log_discount' => (int) ($item['discount'] ?? 0),
                    'status_pembayaran'      => 'BELUM LULUS', // atau 'UNPAID'
                    'created_at'             => $nowTime,
                    'updated_at'             => $nowTime,
                ];
            }

            // Mass Insert Ke Tabel Detail
            DB::table('d_reg_order_rad_list')->insert($itemsData);

            // Jika Semua Query Berhasil
            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Registrasi Radiologi Berhasil Disimpan!',
                'data'    => [
                    'order_code'     => $orderCode,
                    'order_rad_code' => $orderRadCode
                ]
            ], 200);
        } catch (Exception $e) {
            // Batalkan semua transaksi jika terjadi error
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data registrasi radiologi: ' . $e->getMessage()
            ], 500);
        }
    }
}
