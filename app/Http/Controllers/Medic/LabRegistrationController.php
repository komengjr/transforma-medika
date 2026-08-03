<?php

namespace App\Http\Controllers\Medic;

use App\Http\Controllers\Controller;
use App\Models\medical\MasterPatient;
use App\Models\medical\MedicalPemeriksaanLab;
use App\Models\medical\MedicalPendaftaranLab;
use App\Models\medical\MedicalPendaftaranLabDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class LabRegistrationController extends Controller
{
    public function index()
    {
        $orders = MedicalPendaftaranLab::with(['patient', 'details.pemeriksaan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['status' => 'success', 'data' => $orders]);
    }
    public function getMasterPemeriksaan()
    {
        $pemeriksaan = DB::table('medical_pemeriksaan_labs')
            ->select('id', 'nama_pemeriksaan', 'harga')
            ->orderBy('nama_pemeriksaan', 'asc')
            ->get();

        return response()->json(['data' => $pemeriksaan]);
    }
    public function searchPasien(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json(['data' => []]);
        }

        $pasien = DB::table('master_patient')
            ->select(
                'id_master_patient',
                'master_patient_code as no_rkm_medis',
                'master_patient_nik as nik',
                'master_patient_name as nm_pasien',
                'master_patient_jk as jk',
                'master_patient_tgl_lahir as tgl_lahir',
                'master_patient_alamat as alamat',
                'master_patient_no_hp as no_hp'
            )
            ->where('master_patient_code', 'LIKE', "%{$query}%")
            ->orWhere('master_patient_nik', 'LIKE', "%{$query}%")
            ->orWhere('master_patient_name', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json(['data' => $pasien]);
    }
    public function registerLabOrder(Request $request)
    {
        $request->validate([
            'id_master_patient' => 'required|exists:master_patient,id_master_patient',
            'pemeriksaan_ids'   => 'required|array', // Array ID dari medical_pemeriksaan_labs
            'catatan'           => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Generate No. Lab (Contoh: LAB202607310001)
            $today = date('Ymd');
            $lastLab = DB::table('medical_pendaftaran_labs')
                ->where('nolab', 'LIKE', "LAB{$today}%")
                ->orderBy('nolab', 'desc')
                ->first();

            $nextNumber = $lastLab ? ((int) substr($lastLab->nolab, -4)) + 1 : 1;
            $nolab = 'LAB' . $today . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // Hitung total biaya dari paket pemeriksaan
            $totalBiaya = DB::table('medical_pemeriksaan_labs')
                ->whereIn('id', $request->pemeriksaan_ids)
                ->sum('harga');

            // 1. Insert Header Pendaftaran
            $pendaftaranId = DB::table('medical_pendaftaran_labs')->insertGetId([
                'nolab'             => $nolab,
                'id_master_patient' => $request->id_master_patient,
                'tanggal_daftar'    => now(),
                'status'            => 'PENDING',
                'total_biaya'       => 1000000,
                'catatan'           => $request->catatan,
                'created_at'        => now(),
                'updated_at'        => now()
            ]);

            // 2. Insert Detail Parameter (Otomatis mengambil Sub-Parameter dari Paket)
            foreach ($request->pemeriksaan_ids as $pemeriksaanId) {
                $paket = DB::table('medical_pemeriksaan_labs')->find($pemeriksaanId);
                $subs = DB::table('medical_pemeriksaan_lab_subs')
                    ->where('medical_pemeriksaan_lab_id', $pemeriksaanId)
                    ->orderBy('urutan', 'asc')
                    ->get();

                if ($subs->isNotEmpty()) {
                    foreach ($subs as $sub) {
                        DB::table('medical_pendaftaran_lab_details')->insert([
                            'medical_pendaftaran_lab_id'     => $pendaftaranId,
                            'medical_pemeriksaan_lab_id'     => $pemeriksaanId,
                            'medical_pemeriksaan_lab_sub_id' => $sub->id,
                            'harga_pemeriksaan'              => $paket->harga,
                            'hasil_pemeriksaan'              => null,
                            'satuan'                         => $sub->satuan,
                            'nilai_rujukan_terpakai'         => $sub->nilai_rujukan,
                            'flag_hasil'                     => 'N',
                            'created_at'                     => now(),
                            'updated_at'                     => now()
                        ]);
                    }
                } else {
                    // Jika pemeriksaan tidak memiliki sub-parameter
                    DB::table('medical_pendaftaran_lab_details')->insert([
                        'medical_pendaftaran_lab_id'     => $pendaftaranId,
                        'medical_pemeriksaan_lab_id'     => $pemeriksaanId,
                        'medical_pemeriksaan_lab_sub_id' => null,
                        'harga_pemeriksaan'              => $paket->harga,
                        'hasil_pemeriksaan'              => null,
                        'satuan'                         => null,
                        'nilai_rujukan_terpakai'         => null,
                        'flag_hasil'                     => 'N',
                        'created_at'                     => now(),
                        'updated_at'                     => now()
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Pendaftaran laboratorium berhasil disimpan',
                'nolab'   => $nolab
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storePendaftaran: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal membuat pendaftaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getDetailOrder($nolab)
    {
        $orders = DB::table('medical_pendaftaran_labs as h')
            ->join('master_patient as p', 'h.id_master_patient', '=', 'p.id_master_patient')
            ->select(
                'h.id_medical_pendaftaran_lab as id',
                'h.nolab',
                'p.id_master_patient',
                'p.master_patient_code as no_rkm_medis',
                'p.master_patient_name as nm_pasien',
                'p.master_patient_nik as nik',
                'h.tanggal_daftar as tgl_permintaan',
                'h.status',
                'h.total_biaya'
            )
            ->orderBy('h.tanggal_daftar', 'desc')
            ->limit(20)
            ->get();

        return response()->json(['data' => $orders]);
    }
    public function getDaftarPendaftaran()
    {
        $orders = DB::table('medical_pendaftaran_labs as h')
            ->join('master_patient as p', 'h.id_master_patient', '=', 'p.id_master_patient')
            ->select(
                'h.id_medical_pendaftaran_lab as id',
                'h.nolab',
                'p.id_master_patient',
                'p.master_patient_code as no_rkm_medis',
                'p.master_patient_name as nm_pasien',
                'p.master_patient_nik as nik',
                'h.tanggal_daftar as tgl_permintaan',
                'h.status',
                'h.total_biaya'
            )
            ->orderBy('h.tanggal_daftar', 'desc')
            ->limit(20)
            ->get();

        return response()->json(['data' => $orders]);
    }
    public function storePendaftaran(Request $request)
    {
        $request->validate([
            'id_master_patient' => 'required|exists:master_patient,id_master_patient',
            'pemeriksaan_ids'   => 'required|array|min:1',
            'pemeriksaan_ids.*' => 'exists:medical_pemeriksaan_labs,id',
            'catatan'           => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            // Generate Nomor Lab (Contoh: LAB202607310001)
            $today = date('Ymd');
            $lastLab = DB::table('medical_pendaftaran_labs')
                ->where('nolab', 'LIKE', "LAB{$today}%")
                ->orderBy('nolab', 'desc')
                ->first();

            $nextNumber = $lastLab ? ((int) substr($lastLab->nolab, -4)) + 1 : 1;
            $nolab = 'LAB' . $today . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // Hitung Total Biaya dari Paket Pemeriksaan
            $totalBiaya = DB::table('medical_pemeriksaan_labs')
                ->whereIn('id', $request->pemeriksaan_ids)
                ->sum('harga');

            // 1. Insert Header Pendaftaran
            $pendaftaranId = DB::table('medical_pendaftaran_labs')->insertGetId([
                'nolab'             => $nolab,
                'id_master_patient' => $request->id_master_patient,
                'tanggal_daftar'    => now(),
                'status'            => 'PENDING',
                'total_biaya'       => $totalBiaya,
                'catatan'           => $request->catatan,
                'created_at'        => now(),
                'updated_at'        => now()
            ]);

            // 2. Insert Detail Parameter (Mengambil Sub Parameter dari Paket)
            foreach ($request->pemeriksaan_ids as $pemeriksaanId) {
                $paket = DB::table('medical_pemeriksaan_labs')->find($pemeriksaanId);
                $subs  = DB::table('medical_pemeriksaan_lab_subs')
                    ->where('medical_pemeriksaan_lab_id', $pemeriksaanId)
                    ->orderBy('urutan', 'asc')
                    ->get();

                if ($subs->isNotEmpty()) {
                    foreach ($subs as $sub) {
                        DB::table('medical_pendaftaran_lab_details')->insert([
                            'medical_pendaftaran_lab_id'     => $pendaftaranId,
                            'medical_pemeriksaan_lab_id'     => $pemeriksaanId,
                            'medical_pemeriksaan_lab_sub_id' => $sub->id,
                            'harga_pemeriksaan'              => $paket->harga,
                            'hasil_pemeriksaan'              => null,
                            'satuan'                         => $sub->satuan,
                            'nilai_rujukan_terpakai'         => $sub->nilai_rujukan,
                            'flag_hasil'                     => 'N',
                            'created_at'                     => now(),
                            'updated_at'                     => now()
                        ]);
                    }
                } else {
                    // Jika pemeriksaan tunggal (tanpa sub-parameter)
                    DB::table('medical_pendaftaran_lab_details')->insert([
                        'medical_pendaftaran_lab_id'     => $pendaftaranId,
                        'medical_pemeriksaan_lab_id'     => $pemeriksaanId,
                        'medical_pemeriksaan_lab_sub_id' => null,
                        'harga_pemeriksaan'              => $paket->harga,
                        'hasil_pemeriksaan'              => null,
                        'satuan'                         => null,
                        'nilai_rujukan_terpakai'         => null,
                        'flag_hasil'                     => 'N',
                        'created_at'                     => now(),
                        'updated_at'                     => now()
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Pendaftaran laboratorium berhasil dibuat',
                'nolab'   => $nolab
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storePendaftaran: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan pendaftaran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 5. GET /lab/pendaftaran/{nolab}
     * Ambil Detail Pendaftaran & Item Hasil
     */
    public function showDetail($nolab)
    {
        $order = DB::table('medical_pendaftaran_labs as h')
            ->join('master_patient as p', 'h.id_master_patient', '=', 'p.id_master_patient')
            ->where('h.nolab', $nolab)
            ->select(
                'h.id_medical_pendaftaran_lab as id',
                'h.nolab',
                'h.tanggal_daftar',
                'h.status',
                'h.total_biaya',
                'h.catatan',
                'p.id_master_patient',
                'p.master_patient_code as no_rkm_medis',
                'p.master_patient_name as nm_pasien',
                'p.master_patient_nik as nik',
                'p.master_patient_tgl_lahir as tgl_lahir',
                'p.master_patient_jk as jk'
            )
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Data pendaftaran tidak ditemukan'], 404);
        }

        // Ambil list detail item pemeriksaan & sub-parameternya
        $pemeriksaan = DB::table('medical_pendaftaran_lab_details as d')
            ->leftJoin('medical_pemeriksaan_labs as m', 'd.medical_pemeriksaan_lab_id', '=', 'm.id')
            ->leftJoin('medical_pemeriksaan_lab_subs as s', 'd.medical_pemeriksaan_lab_sub_id', '=', 's.id')
            ->where('d.medical_pendaftaran_lab_id', $order->id)
            ->select(
                'd.id_medical_pendaftaran_lab_detail as detail_id',
                'd.medical_pemeriksaan_lab_id',
                'd.medical_pemeriksaan_lab_sub_id',
                'm.nama_pemeriksaan',
                's.nama_sub',
                's.code_alat',
                'd.hasil_pemeriksaan as nilai',
                'd.satuan',
                'd.nilai_rujukan_terpakai as nilai_rujukan',
                'd.flag_hasil as flag'
            )
            ->get();

        // Format label nama tampilan
        $order->pemeriksaan = $pemeriksaan->map(function ($item) {
            $item->nm_perawatan = $item->nama_sub ? "{$item->nama_pemeriksaan} - {$item->nama_sub}" : $item->nama_pemeriksaan;
            return $item;
        });

        return response()->json(['data' => $order]);
    }
    public function syncSysmex(Request $request)
    {
        $request->validate([
            'nolab' => 'required|string',
        ]);

        $nolab = $request->nolab;

        // 1. Cari data pendaftaran lab
        $pendaftaran = DB::table('medical_pendaftaran_labs')
            ->where('nolab', $nolab)
            ->first();

        if (!$pendaftaran) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pendaftaran lab tidak ditemukan.'
            ], 404);
        }

        // 2. Ambil data hasil Sysmex XN-500 terbaru berdasarkan nolab
        $sysmexData = DB::table('interface_alat_xn_500')
            ->where('nolab', $nolab)
            ->latest('tanggal')
            ->first();

        if (!$sysmexData || empty($sysmexData->results)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data hasil pemeriksaan dari alat Sysmex tidak ditemukan untuk No. Lab ini.'
            ], 404);
        }

        // 3. Handling parsing JSON (mengantisipasi jika tersimpan sebagai string/json)
        $results = $sysmexData->results;
        if (is_string($results)) {
            $results = json_decode($results, true);
        }

        if (!is_array($results)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Format JSON hasil Sysmex tidak valid.'
            ], 400);
        }

        // 4. Map berdasarkan kunci "px" dari alat Sysmex
        $sysmexMap = [];
        foreach ($results as $res) {
            if (isset($res['px'])) {
                $codeAlat = trim($res['px']);

                // Konversi nilai flag jika null
                $flag = $res['flag'] ?? 'N';
                if (empty($flag)) {
                    $flag = 'N';
                }

                $sysmexMap[$codeAlat] = [
                    'nilai' => $res['result'] ?? '',
                    'flag'  => $flag,
                ];
            }
        }

        // 5. Ambil detail pendaftaran lab
        $details = DB::table('medical_pendaftaran_lab_details as d')
            ->join('medical_pemeriksaan_lab_subs as s', 'd.id_sub_pemeriksaan', '=', 's.id')
            ->where('d.id_pendaftaran_lab', $pendaftaran->id)
            ->select('d.id as detail_id', 's.code_alat')
            ->get();

        $updatedCount = 0;

        // 6. Matching code_alat dari master sub dengan kunci "px" Sysmex
        foreach ($details as $detail) {
            $codeAlatMaster = trim($detail->code_alat);

            if ($codeAlatMaster && isset($sysmexMap[$codeAlatMaster])) {
                $sysmexItem = $sysmexMap[$codeAlatMaster];

                DB::table('medical_pendaftaran_lab_details')
                    ->where('id', $detail->detail_id)
                    ->update([
                        'nilai'      => $sysmexItem['nilai'],
                        'flag'       => $sysmexItem['flag'],
                        'updated_at' => now(),
                    ]);

                $updatedCount++;
            }
        }

        // Update status transaksi menjadi PROSES
        if ($pendaftaran->status === 'PENDING') {
            DB::table('medical_pendaftaran_labs')
                ->where('id', $pendaftaran->id)
                ->update(['status' => 'PROSES', 'updated_at' => now()]);
        }

        // Return response JSON
        return response()->json([
            'status'  => 'success',
            'message' => "Berhasil menyingkronkan {$updatedCount} parameter hasil dari Sysmex.",
            'data'    => $this->getDetailData($nolab) // Mengambil data detail terbaru
        ]);
    }
    private function getDetailData($nolab)
    {
        $pendaftaran = DB::table('medical_pendaftaran_labs as p')
            ->join('master_patient as pt', 'p.id_master_patient', '=', 'pt.id_master_patient')
            ->where('p.nolab', $nolab)
            ->select('p.*', 'pt.nm_pasien', 'pt.no_rkm_medis')
            ->first();

        if (!$pendaftaran) return null;

        $pemeriksaan = DB::table('medical_pendaftaran_lab_details as d')
            ->join('medical_pemeriksaan_lab_subs as s', 'd.id_sub_pemeriksaan', '=', 's.id')
            ->where('d.id_pendaftaran_lab', $pendaftaran->id)
            ->select(
                'd.id as detail_id',
                's.nm_perawatan',
                's.code_alat',
                'd.nilai',
                'd.satuan',
                'd.nilai_rujukan',
                'd.flag'
            )
            ->get();

        $pendaftaran->pemeriksaan = $pemeriksaan;

        return $pendaftaran;
    }
    /**
     * 5. Update Hasil Pemeriksaan Lab Manual
     */
    public function updateHasil(Request $request, $id)
    {
        $request->validate([
            'nolab'       => 'required|string',
            'pemeriksaan' => 'required|array',
            'pemeriksaan.*.detail_id' => 'required|exists:medical_pendaftaran_lab_details,id_medical_pendaftaran_lab_detail',
            'pemeriksaan.*.nilai'     => 'nullable',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->pemeriksaan as $item) {
                DB::table('medical_pendaftaran_lab_details')
                    ->where('id_medical_pendaftaran_lab_detail', $item['detail_id'])
                    ->update([
                        'hasil_pemeriksaan'      => $item['nilai'] ?? null,
                        'satuan'                 => $item['satuan'] ?? null,
                        'nilai_rujukan_terpakai' => $item['nilai_rujukan'] ?? null,
                        'flag_hasil'             => $item['flag'] ?? 'N',
                        'updated_at'             => now()
                    ]);
            }

            // Ubah status header menjadi 'PROSES' atau 'SELESAI'
            DB::table('medical_pendaftaran_labs')
                ->where('id_medical_pendaftaran_lab', $id)
                ->orWhere('nolab', $request->nolab)
                ->update([
                    'status'     => 'SELESAI',
                    'updated_at' => now()
                ]);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Hasil pemeriksaan laboratorium berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updateHasil Lab: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan hasil lab: ' . $e->getMessage()
            ], 500);
        }
    }
    // Fungsi Menangani Pilihan AJAX Master & Paket Agreement
    public function pilihLabAgrement(Request $request) {}

    // Fungsi Menyimpan Data Registrasi
    public function fixRegistrasiLab(Request $request)
    {
        $rujukan = $request->rujukan;
        $date = $request->date;
        $agreement = $request->pilih_agrement_lab;
        $items = json_decode($request->items, true); // Array berisi item pemeriksaan terpilih

        // Proses penyimpanan file rujukan jika ada
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('rujukan_files', 'public');
        }

        // Contoh Penyimpanan Data Transaksi Ke Database
        // DB::transaction(...);

        return response()->json(['status' => 'success', 'message' => 'Registrasi Berhasil']);
    }
    public function getSubSales(Request $request)
    {
        $mSalesCode = $request->m_sales_code;

        $subSales = DB::table('p_sales')
            ->where('p_m_sales_code', $mSalesCode)
            ->where('p_sales_status', '1')
            ->get();

        if ($subSales->isEmpty()) {
            return response()->json([
                'status' => 'empty',
                'html'   => '<div class="alert alert-warning mb-0"><i class="fas fa-exclamation-circle me-1"></i> Tidak ada Sub Master Agreement untuk pilihan ini.</div>'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $subSales
        ]);
    }

    /**
     * AJAX Step 2 -> Step 3: Ambil Kategori / Paket (p_sales_cat) berdasarkan Sub Sales (p_sales)
     */
    public function getCategories(Request $request)
    {
        $salesCode = $request->sales_code;

        $categories = DB::table('p_sales_cat')
            ->where('p_sales_code', $salesCode)
            ->get();

        if ($categories->isEmpty()) {
            return response()->json([
                'status' => 'empty',
                'html'   => '<div class="alert alert-warning mb-0"><i class="fas fa-exclamation-circle me-1"></i> Tidak ada paket pemeriksaan dalam kelompok ini.</div>'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $categories
        ]);
    }

    /**
     * AJAX Step 3 -> Step 4: Ambil Item Pemeriksaan & Harga (p_sales_data) berdasarkan Kategori (p_sales_cat)
     */
    public function getPemeriksaanItems(Request $request)
    {
        $catCode = $request->cat_code;

        $items = DB::table('p_sales_data')
            ->where('p_sales_cat_code', $catCode)
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $items
        ]);
    }

    /**
     * AJAX Final: Simpan Data Registrasi Lab
     */
    public function storeRegistrasi(Request $request)
    {
        Log::info('RAW ITEMS FROM REQUEST:', ['raw' => $request->items]);

        $items = json_decode($request->items, true);
        Log::info('PARSED ITEMS:', ['parsed' => $items]);

        if (empty($items) || !is_array($items)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal: Data item pemeriksaan kosong di Controller!'
            ], 400);
        }

        DB::beginTransaction();
        try {
            $user  = Auth::user()->name ?? 'System';
            $today = date('Y-m-d');
            $now   = now();

            $orderCode    = 'ORD-' . date('YmdHis') . '-' . rand(100, 999);
            $orderLabCode = 'LAB-' . date('YmdHis') . '-' . rand(100, 999);
            $labNumber    = 'REG-LAB-' . date('Ymd') . '-' . rand(1000, 9999);

            // Insert Header 1
            DB::table('d_reg_order')->insert([
                'd_reg_order_code'   => $orderCode,
                'd_reg_order_rm'     => $request->no_rm ?? '-',
                'd_reg_order_date'   => $request->date ?? $today,
                't_layanan_cat_code' => 'LAB',
                't_pasien_cat_code'  => $request->patient_cat,
                'd_reg_order_status' => '1',
                'd_reg_order_user'   => Auth::user()->userid,
                'd_reg_order_cabang' => '-',
                'created_at'         => $now,
                'updated_at'         => $now,
            ]);

            // Insert Header 2
            DB::table('d_reg_order_lab')->insert([
                'd_reg_order_lab_code'   => $orderLabCode,
                'd_reg_order_code'       => $orderCode,
                'd_reg_order_lab_date'   => $request->date ?? $today,
                'd_reg_order_lab_number' => $labNumber,
                'd_reg_order_lab_rujukan' => $request->rujukan,
                'd_reg_order_lab_status' => '1',
                'd_reg_order_lab_user'   => $user,
                'created_at'             => $now,
                'updated_at'             => $now,
            ]);

            // Insert Header 3
            DB::table('d_reg_order_list')->insert([
                'd_reg_order_list_code' => $orderLabCode,
                'd_reg_order_code'      => $orderCode,
                't_layanan_cat_code'    => 'LAB',
                'd_reg_order_list_date' => $request->date ?? $today,
                'created_at'            => $now,
                'updated_at'            => $now,
            ]);

            // Insert Detail Item (d_reg_order_lab_list)
            // 1. Pastikan $items ter-decode menjadi Array jika dikirim sebagai String
            $items = is_string($request->items) ? json_decode($request->items, true) : $request->items;

            // 2. Siapkan Array Bulk Insert
            $insertLabList = [];

            foreach ($items as $index => $item) {
                // KODE UNIK DENGAN MICROTIME AGAR GUARANTEED UNIK
                $uniqueCode = 'L' . date('ymd') . '' . Str::upper(Str::random(2)) . '' . sprintf("%02d", $index + 1);

                $insertLabList[] = [
                    'order_lab_list_code'   => $uniqueCode,
                    'd_reg_order_lab_code'  => $orderLabCode,
                    'p_sales_data_code'     => $item['code'],
                    'order_lab_log_price'    => (int) $item['harga'],
                    'order_lab_log_discount' => 0,
                    'status_pembayaran'     => '0',
                    'created_at'            => $now,
                    'updated_at'            => $now,
                ];
            }

            // 3. Eksekusi Ekstraksi Sekaligus (Lebih Efisien & Cepat)
            if (!empty($insertLabList)) {
                DB::table('d_reg_order_lab_list')->insert($insertLabList);
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Registrasi Lab Berhasil Disimpan!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR SIMPAN LAB LIST:', ['error' => $e->getMessage()]);
            return response()->json([
                'status'  => 'error',
                'message' => 'Error DB: ' . $e->getMessage()
            ], 500);
        }
    }
}
