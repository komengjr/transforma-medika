<?php

namespace App\Http\Controllers\Medic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class RanapController extends Controller
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
    public function data_registrasi_ranap($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Mengambil master ruangan untuk filter jika diperlukan
            $ruangans = DB::table('medical_master_ruangan')->get();
            $subPenjamins = DB::table('medical_sub_penjamin')->get();

            return view('application.ranap.data-registrasi-ranap', [
                'akses' => $akses,
                'code' => $id,
                'ruangans' => $ruangans,
                'subPenjamins' => $subPenjamins,
                'startDate' => date('Y-m-d'),
                'endDate' => date('Y-m-d')
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_registrasi_ranap_table(Request $request)
    {
        $query = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->join('medical_rawat_inap as ri', 'reg.id', '=', 'ri.registrasi_id')
            ->join('medical_master_bed as b', 'ri.ruangan_bed_id', '=', 'b.id')
            ->join('medical_master_ruangan as mr', 'b.ruangan_id', '=', 'mr.id')
            ->leftJoin('medical_master_doctor as doc', 'ri.kode_dokter', '=', 'doc.kode_dokter')
            ->select(
                'reg.id',
                'reg.no_registrasi',
                'reg.tanggal_registrasi',
                'p.nama',
                'p.pid',
                'doc.nama_lengkap',
                'mr.nama_ruangan',
                'mr.kelas',
                'b.nomor_bed',
                'ri.tgl_masuk',
                'ri.status_inap' // <--- Ambil status langsung dari tabel rawat inap
            )
            ->whereNull('ri.tgl_keluar'); // Pasien rawat inap aktif

        // Filter pencarian keyword jika ada
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('reg.no_registrasi', 'like', "%{$keyword}%")
                    ->orWhere('p.nama', 'like', "%{$keyword}%")
                    ->orWhere('p.pid', 'like', "%{$keyword}%");
            });
        }

        $data = $query->get();

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }
    public function ranap_handling_form(Request $request)
    {
        $registrasiId = $request->input('code');

        $pasien = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->join('medical_rawat_inap as ri', 'reg.id', '=', 'ri.registrasi_id')
            ->leftJoin('medical_master_doctor as doc', 'ri.kode_dokter', '=', 'doc.kode_dokter')
            ->join('medical_master_bed as b', 'ri.ruangan_bed_id', '=', 'b.id')
            ->join('medical_master_ruangan as mr', 'b.ruangan_id', '=', 'mr.id')
            ->leftJoin('medical_sub_penjamin as sp', 'reg.sub_penjamin_id', '=', 'sp.id')
            ->leftJoin('medical_penjamin as pj', 'sp.penjamin_id', '=', 'pj.id')
            ->select(
                'reg.*',
                'p.nama as nama_pasien',
                'p.pid',
                'doc.nama_lengkap as nama_dokter',
                'mr.nama_ruangan',
                'mr.kelas',
                'b.nomor_bed',
                'ri.tgl_masuk',
                'sp.penjamin_id',
                'sp.nama_sub_penjamin',
                'pj.nama_penjamin'
            )
            ->where('reg.id', $registrasiId)
            ->first();

        $soap = DB::table('medical_ranap_soap')->where('registrasi_id', $registrasiId)->first();

        $tindakanList = DB::table('medical_ranap_tindakan as rt')
            ->join('medical_master_pemeriksaan as mp', 'rt.master_pemeriksaan_id', '=', 'mp.id')
            ->select('rt.*', 'mp.nama_layanan')
            ->where('rt.registrasi_id', $registrasiId)
            ->get();

        // HANYA MENGAMBIL OBAT YANG AKTIF (status = 1) DAN HARGA JUAL > 0 BERDASARKAN SUB PENJAMIN PASIEN
        $obatList = DB::table('farm_data_obat as fo')
            ->join('farm_penjamin_obat as fpo', function ($join) use ($pasien) {
                $join->on('fpo.farm_data_obat_code', '=', 'fo.farm_data_obat_code')
                    ->where('fpo.sub_penjamin_id', '=', $pasien->sub_penjamin_id)
                    ->where('fpo.status', '=', 1)
                    ->where('fpo.harga_jual', '>', 0);
            })
            ->leftJoin('farm_data_satuan as fs', 'fs.farm_data_satuan_code', '=', 'fo.farm_data_obat_satuan')
            ->select('fo.*', 'fs.farm_data_satuan_name', 'fpo.harga_jual')
            ->get();

        $resepList = DB::table('medical_ranap_resep as rr')
            ->join('farm_data_obat as fo', 'rr.farm_data_obat_code', '=', 'fo.farm_data_obat_code')
            ->select('rr.*', 'fo.farm_data_obat_name')
            ->where('rr.registrasi_id', $registrasiId)
            ->get();

        return view('application.ranap.handling-ranap-modal', compact('pasien', 'soap', 'tindakanList', 'obatList', 'resepList'));
    }
    public function ranap_get_harga_obat(Request $request)
    {
        $subPenjaminId = $request->input('sub_penjamin_id');
        $obatCode      = $request->input('obat_code');

        $harga = DB::table('farm_penjamin_obat')
            ->where('sub_penjamin_id', $subPenjaminId)
            ->where('farm_data_obat_code', $obatCode)
            ->where('status', 1)
            ->where('harga_jual', '>', 0)
            ->value('harga_jual');

        return response()->json([
            'harga' => $harga ?? 0
        ]);
    }

    // 2. Method AJAX get Sub Penjamin
    public function getSubPenjaminByPenjamin(Request $request)
    {
        // Mengambil dari medical_sub_penjamin (Tanpa where is_active karena tidak ada di skema)
        $subPenjamins = DB::table('medical_sub_penjamin')
            ->where('penjamin_id', $request->penjamin_id)
            ->get();

        return response()->json($subPenjamins);
    }

    // 3. Method AJAX get Layanan / Tindakan
    public function getLayananBySubPenjamin(Request $request)
    {
        // Mengambil master pemeriksaan berdasarkan sub penjamin
        $layanans = DB::table('medical_master_pemeriksaan as mp')
            ->join('medical_penjamin_pemeriksaan as pp', 'mp.id', '=', 'pp.master_pemeriksaan_id')
            ->where('pp.sub_penjamin_id', $request->sub_penjamin_id)
            ->where('mp.is_active', 1)
            ->select('mp.id', 'mp.nama_layanan', 'mp.harga as tarif')
            ->get();

        return response()->json($layanans);
    }
    public function ranap_handling_store(Request $request)
    {
        // 1. Validasi input dari form handling (termasuk resep obat)
        $request->validate([
            'registrasi_id'     => 'required|numeric',
            'subjektif'         => 'nullable|string',
            'objektif'          => 'nullable|string',
            'asesmen'           => 'nullable|string',
            'planning'          => 'nullable|string',
            'tindakan_ids'      => 'nullable|array',
            'tarif_tindakan'    => 'nullable|array',
            'resep_obat_code'   => 'nullable|array',
            'resep_qty'         => 'nullable|array',
            'resep_signa'       => 'nullable|array',
            'resep_harga'       => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            $registrasiId = $request->input('registrasi_id');
            // Mendapatkan nama user/perawat yang sedang login
            $currentUser  = auth()->user()->userid ?? 'Perawat/Staf';

            // 2. Simpan atau Update data SOAP (Medical Ranap SOAP)
            DB::table('medical_ranap_soap')->updateOrInsert(
                ['registrasi_id' => $registrasiId],
                [
                    'subjektif'            => $request->input('subjektif'),
                    'objektif'             => $request->input('objektif'),
                    'asesmen'              => $request->input('asesmen'),
                    'planning'             => $request->input('planning'),
                    'input_by'             => $currentUser,
                    'status_verifikasi'    => 'Pending', // Menunggu verifikasi dokter DPJP
                    'updated_at'           => now(),
                    'created_at'           => now(),
                ]
            );

            // 3. Simpan Tindakan / Visite Baru yang ditambahkan
            if ($request->has('tindakan_ids') && is_array($request->input('tindakan_ids'))) {
                $tindakanIds    = $request->input('tindakan_ids');
                $tarifTindakans = $request->input('tarif_tindakan');

                foreach ($tindakanIds as $index => $masterPemeriksaanId) {
                    $tarif = $tarifTindakans[$index] ?? 0;

                    // Cek apakah tindakan ini sudah pernah disimpan sebelumnya untuk registrasi yang sama
                    $exists = DB::table('medical_ranap_tindakan')
                        ->where('registrasi_id', $registrasiId)
                        ->where('master_pemeriksaan_id', $masterPemeriksaanId)
                        ->exists();

                    if (!$exists) {
                        DB::table('medical_ranap_tindakan')->insert([
                            'registrasi_id'         => $registrasiId,
                            'master_pemeriksaan_id' => $masterPemeriksaanId,
                            'tarif'                 => $tarif,
                            'jumlah'                => 1,
                            'input_by'              => $currentUser,
                            'status_verifikasi'     => 'Pending', // Menunggu verifikasi dokter
                            'created_at'            => now(),
                            'updated_at'            => now(),
                        ]);
                    }
                }
            }

            // 4. Simpan Order Resep / Obat Farmasi
            if ($request->has('resep_obat_code') && is_array($request->input('resep_obat_code'))) {
                $obatCodes = $request->input('resep_obat_code');
                $qtys      = $request->input('resep_qty');
                $signas    = $request->input('resep_signa');
                $hargas    = $request->input('resep_harga');

                // Hapus data resep lama yang masih pending untuk registrasi ini sebelum di-insert ulang sesuai input terbaru pada tabel sementara
                DB::table('medical_ranap_resep')
                    ->where('registrasi_id', $registrasiId)
                    ->where('status_verifikasi', 'Pending')
                    ->delete();

                foreach ($obatCodes as $index => $obatCode) {
                    $qty   = $qtys[$index] ?? 1;
                    $signa = $signas[$index] ?? '';
                    $harga = $hargas[$index] ?? 0;

                    DB::table('medical_ranap_resep')->insert([
                        'registrasi_id'         => $registrasiId,
                        'farm_data_obat_code'   => $obatCode,
                        'qty'                   => $qty,
                        'signa'                 => $signa,
                        'harga'                 => $harga,
                        'input_by'              => $currentUser,
                        'status_verifikasi'     => 'Pending', // Menunggu verifikasi dokter
                        'created_at'            => now(),
                        'updated_at'            => now(),
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data handling rawat inap (SOAP, Tindakan & Order Resep) berhasil disimpan dan menunggu verifikasi dokter!'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan handling rawat inap: ' . $e->getMessage()
            ], 500);
        }
    }
    // VERIFIKASI PASIEN RANAP
    public function verifikasi_pasien_ranap($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Hitung total pasien rawat inap aktif untuk badge ringkasan di header view
            $totalAktif = DB::table('medical_registrasi as reg')
                ->join('medical_rawat_inap as ri', 'reg.id', '=', 'ri.registrasi_id')
                ->whereNull('ri.tgl_keluar')
                ->count();

            return view('application.ranap.verifikasi-pasien-rawat-inap', [
                'akses'      => $akses,
                'code'       => $id,
                'totalAktif' => $totalAktif,
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_verifikasi_ranap_table(Request $request)
    {
        $query = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->join('medical_rawat_inap as ri', 'reg.id', '=', 'ri.registrasi_id')
            ->join('medical_master_bed as b', 'ri.ruangan_bed_id', '=', 'b.id')
            ->join('medical_master_ruangan as mr', 'b.ruangan_id', '=', 'mr.id')
            ->leftJoin('medical_master_doctor as doc', 'ri.kode_dokter', '=', 'doc.kode_dokter')
            ->leftJoin('medical_transaksi as tr', 'reg.id', '=', 'tr.registrasi_id')
            ->select(
                'reg.id as registrasi_id',
                'reg.no_registrasi',
                'reg.tanggal_registrasi',
                'p.nama as nama_pasien',
                'p.pid',
                'doc.nama_lengkap as nama_dokter',
                'mr.nama_ruangan',
                'mr.kelas',
                'b.id as bed_id',
                'b.nomor_bed',
                'ri.tgl_masuk',
                'tr.total_tagihan',
                'tr.status_pembayaran'
            )
            ->whereNull('ri.tgl_keluar'); // Hanya pasien rawat inap aktif

        // Filter berdasarkan rentang tanggal masuk jika ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('ri.tgl_masuk', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        // Filter pencarian keyword (No Reg, Nama Pasien, atau No RM)
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('reg.no_registrasi', 'like', "\%{$keyword}%")
                    ->orWhere('p.nama', 'like', "%{$keyword}%")
                    ->orWhere('p.pid', 'like', "%{$keyword}%");
            });
        }

        $data = $query->orderBy('ri.tgl_masuk', 'desc')->get();

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }
    public function prosesPulangRanap(Request $request)
    {
        $request->validate([
            'registrasi_id' => 'required|numeric',
            'bed_id'        => 'required|numeric',
            'status_pulang' => 'required|string',
            'catatan_pulang' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $registrasiId = $request->input('registrasi_id');
            $bedId        = $request->input('bed_id');

            // 1. Update data di medical_rawat_inap (Tgl keluar & status pulang)
            DB::table('medical_rawat_inap')
                ->where('registrasi_id', $registrasiId)
                ->update([
                    'tgl_keluar'     => now(),
                    'status_pulang'  => $request->input('status_pulang'),
                    'catatan_pulang' => $request->input('catatan_pulang'),
                    'updated_at'     => now(),
                ]);

            // 2. Update status kunjungan di medical_registrasi menjadi SELESAI
            DB::table('medical_registrasi')
                ->where('id', $registrasiId)
                ->update([
                    'status_kunjungan' => 'SELESAI',
                    'updated_at'       => now(),
                ]);

            // 3. Bebaskan Bed kembali menjadi TERSEDIA agar bisa digunakan pasien lain
            DB::table('medical_master_bed')
                ->where('id', $bedId)
                ->update([
                    'status'     => 'TERSEDIA',
                    'updated_at' => now(),
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pasien diizinkan pulang dan Bed berhasil dibuka kembali!'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses kepulangan pasien: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getDetailHandlingRanap(Request $request)
    {
        $registrasiId = $request->input('registrasi_id');

        // Ambil data SOAP
        $soap = DB::table('medical_ranap_soap')
            ->where('registrasi_id', $registrasiId)
            ->first();

        // Ambil daftar tindakan (Sertakan rt.id agar bisa di-update per baris)
        $tindakanList = DB::table('medical_ranap_tindakan as rt')
            ->join('medical_master_pemeriksaan as mp', 'rt.master_pemeriksaan_id', '=', 'mp.id')
            ->select('rt.id', 'rt.master_pemeriksaan_id', 'mp.nama_layanan', 'rt.tarif', 'rt.jumlah', 'rt.input_by', 'rt.dokter_verifikasi_kode', 'rt.status_verifikasi', 'rt.created_at')
            ->where('rt.registrasi_id', $registrasiId)
            ->get();

        // Ambil daftar resep obat (Sertakan rr.id agar bisa di-update per baris)
        $resepList = DB::table('medical_ranap_resep as rr')
            ->join('farm_data_obat as fo', 'rr.farm_data_obat_code', '=', 'fo.farm_data_obat_code')
            ->select('rr.id', 'fo.farm_data_obat_name', 'rr.qty', 'rr.signa', 'rr.harga', 'rr.input_by', 'rr.dokter_verifikasi_kode', 'rr.status_verifikasi', 'rr.created_at')
            ->where('rr.registrasi_id', $registrasiId)
            ->get();

        return response()->json([
            'success'      => true,
            'soap'         => $soap,
            'tindakanList' => $tindakanList,
            'resepList'    => $resepList
        ]);
    }
    public function prosesVerifikasiHandling(Request $request)
    {
        $request->validate([
            'registrasi_id' => 'required|numeric',
            'dokter_kode'   => 'required|string',
            'tindakan'      => 'nullable|array',
            'resep'         => 'nullable|array',
        ]);

        $registrasiId = $request->input('registrasi_id');
        $dokterKode   = $request->input('dokter_kode');
        $tindakanData = $request->input('tindakan', []);
        $resepData    = $request->input('resep', []);

        DB::beginTransaction();
        try {
            // Cek apakah ada tindakan yang disetujui (Verified)
            $hasVerifiedTindakan = collect($tindakanData)->contains('status', 'Verified');

            $transaksi = DB::table('medical_transaksi')->where('registrasi_id', $registrasiId)->first();
            $transaksiId = $transaksi ? $transaksi->id : null;

            // Jika ada tindakan di-ACC tapi pasien belum punya nota transaksi, buatkan notanya
            if (!$transaksi && $hasVerifiedTindakan) {
                $transaksiId = DB::table('medical_transaksi')->insertGetId([
                    'registrasi_id'     => $registrasiId,
                    'total_tagihan'     => 0,
                    'total_bayar'       => 0,
                    'sisa_tagihan'      => 0,
                    'metode_bayar'      => 'BELUM DITENTUKAN',
                    'status_pembayaran' => 'BELUM LUNAS',
                    'created_at'        => now(),
                    'updated_at'        => now()
                ]);
            }

            $tanggalFormat = date('dmy');
            $totalTambahanTagihan = 0;

            // --- PROSES TINDAKAN ---
            foreach ($tindakanData as $tind) {
                $rt = DB::table('medical_ranap_tindakan')->where('id', $tind['id'])->first();

                // Hanya proses yang status sebelumnya masih 'Pending'
                if ($rt && $rt->status_verifikasi === 'Pending') {

                    // 1. Update status di tabel rawat inap tindakan
                    DB::table('medical_ranap_tindakan')->where('id', $rt->id)->update([
                        'status_verifikasi'      => $tind['status'],
                        'dokter_verifikasi_kode' => $dokterKode,
                        'updated_at'             => now()
                    ]);

                    // 2. Jika disetujui, injeksi ke tagihan kasir (medical_transaksi_detail)
                    if ($tind['status'] === 'Verified') {

                        // A. Ambil info master pemeriksaan & nama layanannya
                        $master = DB::table('medical_master_pemeriksaan as mp')
                            ->leftJoin('medical_tipe_layanan as tl', 'mp.tipe_layanan_id', '=', 'tl.id')
                            ->select('mp.id', 'mp.nama_layanan', 'tl.prefix', 'mp.is_paket')
                            ->where('mp.id', $rt->master_pemeriksaan_id)
                            ->first();

                        $namaLayanan = $master ? $master->nama_layanan : 'Tindakan Rawat Inap';
                        $prefix = $master && $master->prefix ? strtoupper($master->prefix) : 'ORD';

                        // B. Generate nomor pemeriksaan sesuai prefix
                        $lastOrder = DB::table('medical_transaksi_detail')
                            ->where('no_pemeriksaan', 'like', "{$prefix}{$tanggalFormat}%")
                            ->orderBy('id', 'desc')
                            ->first();

                        $noUrutOrder = $lastOrder ? (int) substr($lastOrder->no_pemeriksaan, -4) + 1 : 1;
                        $noPemeriksaanBaru = $prefix . $tanggalFormat . str_pad($noUrutOrder, 4, '0', STR_PAD_LEFT);

                        $qtyTindakan = isset($rt->jumlah) ? intval($rt->jumlah) : 1;
                        $hargaDasar  = floatval($rt->tarif);
                        $subtotal    = $hargaDasar * $qtyTindakan;

                        // C. Simpan ke detail transaksi (Sesuai skema baru)
                        DB::table('medical_transaksi_detail')->insert([
                            'transaksi_id'          => $transaksiId,
                            'jenis_item'            => 'TINDAKAN',
                            'nama_item'             => $namaLayanan, // <-- Terisi dengan benar tanpa null
                            'master_pemeriksaan_id' => $rt->master_pemeriksaan_id,
                            'farm_data_obat_code'   => null,
                            'sumber_tagihan'        => 'RANAP_TINDAKAN',
                            'sumber_id'             => $rt->id,
                            'qty'                   => $qtyTindakan,
                            'harga_dasar'           => $hargaDasar,
                            'diskon'                => 0,
                            'is_cito'               => 0,
                            'biaya_cito'            => 0,
                            'harga_akhir'           => $subtotal,
                            'no_pemeriksaan'        => $noPemeriksaanBaru,
                            'status_pemeriksaan'    => 'SELESAI',
                            'status_pembayaran'     => 'BELUM LUNAS',
                            'created_at'            => now(),
                            'updated_at'            => now()
                        ]);

                        $totalTambahanTagihan += $subtotal;

                        // D. Jika item adalah paket, bongkar isinya ke detail transaksi
                        if ($master && ($master->is_paket == 1 || $master->is_paket == true)) {
                            $subItems = DB::table('medical_paket_detail as pd')
                                ->join('medical_master_pemeriksaan as sub_mp', 'pd.pemeriksaan_id', '=', 'sub_mp.id')
                                ->leftJoin('medical_tipe_layanan as sub_tl', 'sub_mp.tipe_layanan_id', '=', 'sub_tl.id')
                                ->where('pd.paket_id', $master->id)
                                ->select('sub_mp.id as sub_id', 'sub_mp.nama_layanan as sub_nama', 'sub_tl.prefix as sub_prefix')
                                ->get();

                            foreach ($subItems as $sub) {
                                $subPrefix = strtoupper($sub->sub_prefix ?? 'LAB');

                                $lastOrderSub = DB::table('medical_transaksi_detail')
                                    ->where('no_pemeriksaan', 'like', "{$subPrefix}{$tanggalFormat}%")
                                    ->orderBy('id', 'desc')
                                    ->first();

                                $noUrutOrderSub = $lastOrderSub ? (int) substr($lastOrderSub->no_pemeriksaan, -4) + 1 : 1;
                                $noPemeriksaanSub = $subPrefix . $tanggalFormat . str_pad($noUrutOrderSub, 4, '0', STR_PAD_LEFT);

                                DB::table('medical_transaksi_detail')->insert([
                                    'transaksi_id'          => $transaksiId,
                                    'jenis_item'            => 'TINDAKAN',
                                    'nama_item'             => $sub->sub_nama ?? 'Sub Item Paket',
                                    'master_pemeriksaan_id' => $sub->sub_id,
                                    'farm_data_obat_code'   => null,
                                    'sumber_tagihan'        => 'RANAP_PAKET',
                                    'sumber_id'             => $rt->id,
                                    'qty'                   => 1,
                                    'harga_dasar'           => 0, // Harga sudah termasuk dalam paket induk
                                    'diskon'                => 0,
                                    'is_cito'               => 0,
                                    'biaya_cito'            => 0,
                                    'harga_akhir'           => 0,
                                    'no_pemeriksaan'        => $noPemeriksaanSub,
                                    'status_pemeriksaan'    => 'MENUNGGU',
                                    'status_pembayaran'     => 'BELUM LUNAS',
                                    'created_at'            => now(),
                                    'updated_at'            => now(),
                                ]);
                            }
                        }
                    }
                }
            }

            // --- PROSES RESEP OBAT ---
            foreach ($resepData as $res) {
                $rr = DB::table('medical_ranap_resep')->where('id', $res['id'])->first();

                if ($rr && $rr->status_verifikasi === 'Pending') {
                    DB::table('medical_ranap_resep')->where('id', $rr->id)->update([
                        'status_verifikasi'      => $res['status'],
                        'dokter_verifikasi_kode' => $dokterKode,
                        'updated_at'             => now()
                    ]);

                    // Jika resep juga ingin langsung masuk kasir saat diverifikasi:
                    if ($res['status'] === 'Verified') {
                        $masterObat = DB::table('farm_data_obat')->where('farm_data_obat_code', $rr->farm_data_obat_code)->first();
                        $namaObat   = $masterObat ? $masterObat->farm_data_obat_name : 'Obat Farmasi Ranap';

                        $qtyObat    = intval($rr->qty ?? 1);
                        $hargaObat  = floatval($rr->harga ?? 0);
                        $subtotalObat = $qtyObat * $hargaObat;

                        DB::table('medical_transaksi_detail')->insert([
                            'transaksi_id'          => $transaksiId,
                            'jenis_item'            => 'OBAT',
                            'nama_item'             => $namaObat,
                            'master_pemeriksaan_id' => null,
                            'farm_data_obat_code'   => $rr->farm_data_obat_code,
                            'sumber_tagihan'        => 'RANAP_RESEP',
                            'sumber_id'             => $rr->id,
                            'qty'                   => $qtyObat,
                            'harga_dasar'           => $hargaObat,
                            'diskon'                => 0,
                            'is_cito'               => 0,
                            'biaya_cito'            => 0,
                            'harga_akhir'           => $subtotalObat,
                            'no_pemeriksaan'        => null,
                            'status_pemeriksaan'    => 'SELESAI',
                            'status_pembayaran'     => 'BELUM LUNAS',
                            'created_at'            => now(),
                            'updated_at'            => now()
                        ]);

                        $totalTambahanTagihan += $subtotalObat;
                    }
                }
            }

            // --- UPDATE HEADER TOTAL TAGIHAN DI MEDICAL TRANSAKSI ---
            if ($transaksiId && $totalTambahanTagihan > 0) {
                DB::table('medical_transaksi')
                    ->where('id', $transaksiId)
                    ->update([
                        'total_tagihan' => DB::raw("total_tagihan + {$totalTambahanTagihan}"),
                        'sisa_tagihan'  => DB::raw("sisa_tagihan + {$totalTambahanTagihan}"),
                        'updated_at'    => now()
                    ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status verifikasi berhasil disimpan, item tercatat di kasir, dan diteruskan ke bagian terkait.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
    public function verifyOrderSoap(Request $request)
    {
        $registrasiId = $request->input('registrasi_id');
        $status       = $request->input('status'); // 'Verified' atau 'Rejected'

        $currentUser  = Auth::user();
        $dokterKode   = $currentUser ? ($currentUser->username ?? 'DR-SYSTEM') : 'DR-SYSTEM';

        try {
            DB::table('medical_ranap_soap')
                ->where('registrasi_id', $registrasiId)
                ->update([
                    'status_verifikasi'      => $status,
                    'dokter_verifikasi_kode' => $dokterKode,
                    'updated_at'             => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Status SOAP berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui SOAP: ' . $e->getMessage()
            ], 500);
        }
    }
    public function ranap_verify_order(Request $request)
    {
        $registrasiId = $request->input('registrasi_id');
        $jenis        = $request->input('jenis'); // 'soap', 'tindakan', atau 'resep'
        $status       = $request->input('status'); // 'Verified' atau 'Rejected'
        $dokterKode   = auth()->user()->userid ?? (auth()->user()->name ?? 'Dokter Verifikator');

        if ($jenis == 'soap') {
            DB::table('medical_ranap_soap')->where('registrasi_id', $registrasiId)->update([
                'status_verifikasi'      => $status,
                'dokter_verifikasi_kode' => $dokterKode,
                'updated_at'             => now()
            ]);
        } elseif ($jenis == 'tindakan') {
            DB::table('medical_ranap_tindakan')->where('registrasi_id', $registrasiId)->update([
                'status_verifikasi'      => $status,
                'dokter_verifikasi_kode' => $dokterKode,
                'updated_at'             => now()
            ]);
        } elseif ($jenis == 'resep') {
            DB::table('medical_ranap_resep')->where('registrasi_id', $registrasiId)->update([
                'status_verifikasi'      => $status,
                'dokter_verifikasi_kode' => $dokterKode,
                'updated_at'             => now()
            ]);
        }

        return response()->json(['success' => true, 'message' => "Verifikasi berhasil diperbarui menjadi {$status}!"]);
    }
    // RIWAYAT PASIEN RANAP
    public function riwayat_pasien_ranap($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('application.ranap.riwayat-pasien-ranap', [
                'akses' => $akses,
                'code'  => $id,
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

    public function data_riwayat_pasien_ranap_table(Request $request)
    {
        $query = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->join('medical_rawat_inap as ri', 'reg.id', '=', 'ri.registrasi_id')
            ->join('medical_master_bed as b', 'ri.ruangan_bed_id', '=', 'b.id')
            ->join('medical_master_ruangan as mr', 'b.ruangan_id', '=', 'mr.id')
            ->leftJoin('medical_master_doctor as doc', 'ri.kode_dokter', '=', 'doc.kode_dokter')
            ->leftJoin('medical_transaksi as tr', 'reg.id', '=', 'tr.registrasi_id')
            ->select(
                'reg.id as registrasi_id',
                'reg.no_registrasi',
                'reg.tanggal_registrasi',
                'reg.status_kunjungan',
                'p.nama as nama_pasien',
                'p.pid',
                'doc.nama_lengkap as nama_dokter',
                'mr.nama_ruangan',
                'mr.kelas',
                'b.nomor_bed',
                'ri.tgl_masuk',
                'ri.tgl_keluar',
                'ri.status_pulang',
                'ri.catatan_pulang',
                'tr.total_tagihan',
                'tr.status_pembayaran'
            );

        // 1. Filter rentang tanggal masuk
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('ri.tgl_masuk', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        // 2. Filter status kunjungan / status pulang
        if ($request->filled('status_pulang')) {
            $query->where('ri.status_pulang', $request->input('status_pulang'));
        }

        // 3. Filter kelas ruangan
        if ($request->filled('kelas')) {
            $query->where('mr.kelas', $request->input('kelas'));
        }

        // 4. Filter keyword (No. Registrasi, Nama Pasien, No RM)
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('reg.no_registrasi', 'like', "\%{$keyword}%")
                    ->orWhere('p.nama', 'like', "%{$keyword}%")
                    ->orWhere('p.pid', 'like', "%{$keyword}%");
            });
        }

        $data = $query->orderBy('ri.tgl_masuk', 'desc')->get();

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }
    // MASTER RUANGAN
    public function master_ranap_ruangan_kelas($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // 1. Ambil daftar ruangan beserta relasi bed/kasurnya
            $ruanganList = DB::table('medical_master_ruangan')
                ->orderBy('id', 'desc')
                ->get();

            // Masukkan data bed ke dalam masing-masing ruangan agar mudah di-looping di Blade
            foreach ($ruanganList as $ruangan) {
                $ruangan->beds = DB::table('medical_master_bed')
                    ->where('ruangan_id', $ruangan->id)
                    ->get();
            }

            // 2. Hitung statistik keseluruhan status bed untuk ringkasan di atas
            $statsTersedia  = DB::table('medical_master_bed')->where('status', 'TERSEDIA')->count();
            $statsTerisi    = DB::table('medical_master_bed')->where('status', 'TERISI')->count();
            $statsPerbaikan = DB::table('medical_master_bed')->where('status', 'PERBAIKAN')->count();
            $statsRusak     = DB::table('medical_master_bed')->where('status', 'RUSAK')->count();

            return view('application.ranap.master-ruangan-kelas', [
                'akses'           => $akses,
                'code'            => $id,
                'ruanganList'     => $ruanganList,
                'statsTersedia'   => $statsTersedia,
                'statsTerisi'     => $statsTerisi,
                'statsPerbaikan'  => $statsPerbaikan,
                'statsRusak'      => $statsRusak,
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function storeRuangan(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'kelas'        => 'required|string|max:50',
        ]);

        DB::table('medical_master_ruangan')->insert([
            'nama_ruangan' => $request->nama_ruangan,
            'kelas'        => $request->kelas,
            'is_active'    => 1,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect()->back()->with('success', 'Ruangan baru berhasil ditambahkan!');
    }
    public function storeBed(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|numeric',
            'nomor_bed'  => 'required|string|max:50',
            'status'     => 'required|string',
        ]);

        DB::table('medical_master_bed')->insert([
            'ruangan_id' => $request->ruangan_id,
            'nomor_bed'  => $request->nomor_bed,
            'status'     => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Bed berhasil ditambahkan ke ruangan!');
    }

    public function updateBed(Request $request, $id)
    {
        DB::table('medical_master_bed')
            ->where('id', $id)
            ->update([
                'nomor_bed'  => $request->nomor_bed,
                'status'     => $request->status,
                'updated_at' => now(),
            ]);

        return response()->json(['success' => true, 'message' => 'Bed berhasil diperbarui']);
    }

    public function destroyBed($id)
    {
        DB::table('medical_master_bed')->where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Bed berhasil dihapus']);
    }
    public function toggleActiveBed($id)
    {
        $bed = DB::table('medical_master_bed')->where('id', $id)->first();

        if (!$bed) {
            return response()->json(['success' => false, 'message' => 'Bed tidak ditemukan']);
        }

        // Balikkan nilai status is_active (jika 1 jadi 0, jika 0 jadi 1)
        $newStatus = $bed->is_active == 1 ? 0 : 1;

        DB::table('medical_master_bed')
            ->where('id', $id)
            ->update([
                'is_active'  => $newStatus,
                'updated_at' => now(),
            ]);

        $pesan = $newStatus == 1 ? 'Bed berhasil diaktifkan kembali.' : 'Bed berhasil dinonaktifkan.';

        return response()->json(['success' => true, 'message' => $pesan]);
    }
}
