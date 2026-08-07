<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class PriceSettingController extends Controller
{
    // Menampilkan halaman form
    public function create()
    {
        $masterSales = DB::table('p_m_sales')
            ->where('p_m_sales_status', 'active') // sesuaikan kondisi status aktif
            ->get();

        return view('price_setting.create', compact('masterSales'));
    }

    // Endpoint AJAX untuk mendapatkan Sub Sales
    public function getSubSales($mSalesCode)
    {
        $subSales = DB::table('p_sales')
            ->where('p_m_sales_code', $mSalesCode)
            ->where('p_sales_status', '1')
            ->get();

        return response()->json($subSales);
    }

    // Endpoint AJAX untuk mendapatkan Kategori Sales
    public function getSalesCat($salesCode)
    {
        $categories = DB::table('p_sales_cat')
            ->leftJoin('t_layanan_cat', 'p_sales_cat.t_layanan_cat_code', '=', 't_layanan_cat.t_layanan_cat_code')
            ->where('p_sales_cat.p_sales_code', $salesCode)
            ->select('p_sales_cat.*', 't_layanan_cat.t_layanan_cat_name')
            ->get();

        return response()->json($categories);
    }

    // Endpoint AJAX untuk MENGAMBIL DATA TABEL berdasarkan Sub Sales / Kategori
    public function getSalesDataFilter(Request $request)
    {
        $pSalesCode = $request->get('p_sales_code');
        $pSalesCatCode = $request->get('p_sales_cat_code');

        $query = DB::table('p_sales_data as psd')
            ->leftJoin('p_sales_cat as psc', 'psd.p_sales_cat_code', '=', 'psc.p_sales_cat_code')
            ->leftJoin('p_sales as ps', 'psc.p_sales_code', '=', 'ps.p_sales_code') // Join ps via psc
            ->leftJoin('t_layanan_cat as tlc', 'psc.t_layanan_cat_code', '=', 'tlc.t_layanan_cat_code')
            ->leftJoin('t_pemeriksaan_list as tpl', 'psd.t_pemeriksaan_list_code', '=', 'tpl.t_pemeriksaan_list_code')
            ->select(
                'psd.*',
                'ps.p_sales_name',
                'psc.p_sales_cat_name',
                'tlc.t_layanan_cat_name',
                'tpl.t_pemeriksaan_list_name'
            );

        // FIX: Filter p_sales_code diarahkan ke psc (p_sales_cat)
        if ($pSalesCode) {
            $query->where('psc.p_sales_code', $pSalesCode);
        }

        if ($pSalesCatCode) {
            $query->where('psd.p_sales_cat_code', $pSalesCatCode);
        }

        $salesData = $query->get();

        // Load sub paket untuk item pemeriksaan paket
        foreach ($salesData as $row) {
            if ($row->p_sales_data_type === 'Package') {
                $row->package_items = DB::table('p_sales_data_sub')
                    ->where('p_sales_data_code', $row->p_sales_data_code)
                    ->get(['p_sales_data_sub_code', 'p_sales_data_sub_name', 't_pemeriksaan_list_code']);
            } else {
                $row->package_items = [];
            }
        }

        return response()->json($salesData);
    }

    // Menyimpan data harga pemeriksaan
    // Menyimpan data harga pemeriksaan via AJAX
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'p_sales_cat_code'        => 'required',
            't_pemeriksaan_list_code' => 'required',
            'p_sales_data_name'       => 'required|string|max:255',
            'p_sales_data_type'       => 'required|string',
            'p_sales_data_price'      => 'required|numeric|min:0',
            'p_sales_data_disc'       => 'nullable|numeric|min:0',
            'p_sales_data_desc'       => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate Kode Sales Data Random Unik (Contoh: PSD-8F2A1K)
        do {
            $randomCode = 'PSD-' . strtoupper(Str::random(6));
        } while (DB::table('p_sales_data')->where('p_sales_data_code', $randomCode)->exists());

        DB::table('p_sales_data')->insert([
            'p_sales_data_code'       => $randomCode,
            't_pemeriksaan_list_code' => $request->t_pemeriksaan_list_code,
            'p_sales_cat_code'        => $request->p_sales_cat_code,
            'p_sales_data_name'       => $request->p_sales_data_name,
            'p_sales_data_type'       => $request->p_sales_data_type,
            'p_sales_data_price'      => $request->p_sales_data_price,
            'p_sales_data_disc'       => $request->p_sales_data_disc ?? 0,
            'p_sales_data_desc'       => $request->p_sales_data_desc,
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Harga pemeriksaan berhasil disimpan dengan kode: ' . $randomCode
        ]);
    }
    public function savePackageItems(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'p_sales_data_code' => 'required|exists:p_sales_data,p_sales_data_code',
            'items'             => 'required|array|min:1',
            'items.*'           => 'required|exists:t_pemeriksaan_list,t_pemeriksaan_list_code',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $pSalesDataCode = $request->p_sales_data_code;
        $items = $request->items;

        DB::beginTransaction();
        try {
            // 1. Hapus item lama terkait paket ini (agar bisa ditimpa/diupdate)
            DB::table('p_sales_data_sub')
                ->where('p_sales_data_code', $pSalesDataCode)
                ->delete();

            // 2. Ambil Nama Pemeriksaan Master untuk p_sales_data_sub_name
            $pemeriksaanMaster = DB::table('t_pemeriksaan_list')
                ->whereIn('t_pemeriksaan_list_code', $items)
                ->pluck('t_pemeriksaan_list_name', 't_pemeriksaan_list_code');

            $insertData = [];
            foreach ($items as $itemCode) {
                // Generate Kode Random Unik untuk Sub Data Paket (Contoh: PSDS-9A2X1M)
                do {
                    $randomSubCode = 'PSDS-' . strtoupper(Str::random(6));
                } while (DB::table('p_sales_data_sub')->where('p_sales_data_sub_code', $randomSubCode)->exists());

                $insertData[] = [
                    'p_sales_data_sub_code' => $randomSubCode,
                    't_pemeriksaan_list_code' => $itemCode,
                    'p_sales_data_code'     => $pSalesDataCode,
                    'p_sales_data_sub_name' => $pemeriksaanMaster[$itemCode] ?? 'Pemeriksaan Paket',
                    'created_at'            => now(),
                    'updated_at'            => now(),
                ];
            }

            // 3. Insert Batch ke p_sales_data_sub
            DB::table('p_sales_data_sub')->insert($insertData);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => count($insertData) . ' item pemeriksaan paket berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan detail paket: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mengambil item paket yang sudah tersimpan untuk p_sales_data_code tertentu
     */
    public function getPackageItems($pSalesDataCode)
    {
        $selectedItems = DB::table('p_sales_data_sub')
            ->where('p_sales_data_code', $pSalesDataCode)
            ->pluck('t_pemeriksaan_list_code');

        return response()->json($selectedItems);
    }
    public function storeMasterSales(Request $request)
    {
        $request->validate([
            'p_m_sales_name' => 'required|string|max:255',
        ]);

        // Otomatis generate kode (misal MS-2026-001) atau atur sesuai standar koding aplikasi Anda
        $lastRecord = DB::table('p_m_sales')->orderBy('p_m_sales_code', 'desc')->first();
        $nextNumber = 1;
        if ($lastRecord) {
            $lastNum = (int) preg_replace('/[^0-9]/', '', $lastRecord->p_m_sales_code);
            $nextNumber = $lastNum + 1;
        }
        $newCode = 'MS-' . date('Y') . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        DB::table('p_m_sales')->insert([
            'p_m_sales_code' => $newCode,
            'p_m_sales_name' => $request->p_m_sales_name,
            'p_m_sales_status' => 1,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Master Sales berhasil ditambahkan!',
            'data'    => [
                'p_m_sales_code' => $newCode,
                'p_m_sales_name' => $request->p_m_sales_name
            ]
        ]);
    }
    public function storeSubSales(Request $request)
    {
        $request->validate([
            'p_m_sales_code' => 'required|string',
            'p_sales_name'   => 'required|string|max:255',
        ]);

        // Format kode Sub Sales otomatis (misal: PS-2026-001)
        $lastRecord = DB::table('p_sales')->count();
        if ($lastRecord) {
            $nextNumber = $lastRecord + 1;
        } else {
            $nextNumber = 1;
        }
        $newCode = 'PS-' . date('Y') . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        DB::table('p_sales')->insert([
            'p_sales_code'   => $newCode,
            'p_m_sales_code' => $request->p_m_sales_code,
            'p_sales_name'   => $request->p_sales_name,
            'p_sales_type'   => 1,
            'p_sales_status'   => 1,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Sub Sales berhasil ditambahkan!',
            'data'    => [
                'p_sales_code'   => $newCode,
                'p_m_sales_code' => $request->p_m_sales_code,
                'p_sales_name'   => $request->p_sales_name
            ]
        ]);
    }
    public function storeSalesCat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'p_sales_code'     => 'required|string',
            'p_sales_cat_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $lastCode = DB::table('p_sales_cat')->count();
        $newCode = 'CATS' . str_pad(((int) filter_var($lastCode, FILTER_SANITIZE_NUMBER_INT)) + 1, 3, '0', STR_PAD_LEFT);

        DB::table('p_sales_cat')->insert([
            'p_sales_cat_code' => $newCode,
            'p_sales_code'     => $request->p_sales_code,
            't_layanan_cat_code' => $request->t_layanan_cat_code,
            'p_sales_cat_name'   => $request->p_sales_cat_name,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        return response()->json([
            'message' => 'Kategori Sales berhasil ditambahkan!',
            'data'    => [
                'p_sales_cat_code' => $newCode,
                'p_sales_cat_name' => $request->p_sales_cat_name,
            ]
        ]);
    }
}
