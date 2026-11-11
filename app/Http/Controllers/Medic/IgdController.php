<?php

namespace App\Http\Controllers\Medic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class IgdController extends Controller
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
    // DATA REGISTRASI LAB
    // 1. Render Halaman Utama Lab
    public function data_registrasi_igd($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('application.igd.data-registrasi-igd', [
                'akses' => $akses,
                'code' => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_registrasi_igd_table(Request $request)
    {
        $query = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->leftJoin('medical_transaksi as t', 't.registrasi_id', '=', 'reg.id')
            ->leftJoin('medical_sub_penjamin as sp', 'reg.sub_penjamin_id', '=', 'sp.id')
            ->leftJoin('medical_master_doctor as doc_poli', 'doc_poli.id', '=', 'reg.doctor_poli_id')
            ->leftJoin('medical_master_poli as poli', 'poli.id', '=', 'reg.poli_id')
            ->where('reg.jenis_layanan', 'IGD')
            ->whereNull('reg.deleted_at');

        // Filter Rentang Tanggal (start_date & end_date)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('reg.tanggal_registrasi', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Filter Keyword (No Registrasi, Nama Pasien, atau No RM/PID)
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('reg.no_registrasi', 'like', "%{$keyword}%")
                    ->orWhere('p.nama', 'like', "%{$keyword}%")
                    ->orWhere('p.pid', 'like', "%{$keyword}%");
            });
        }

        // Filter Poli / Ruangan
        if ($request->filled('poli_id')) {
            $query->where('reg.poli_id', $request->poli_id);
        }

        // Filter Dokter
        if ($request->filled('dokter')) {
            $dokter = $request->dokter;
            $query->where('doc_poli.nama_lengkap', 'like', "%{$dokter}%");
        }

        // Filter Sub Penjamin
        if ($request->filled('sub_penjamin_id')) {
            $query->where('reg.sub_penjamin_id', $request->sub_penjamin_id);
        }

        // Hitung total data keseluruhan (tanpa filter pencarian tabel)
        $totalData = DB::table('medical_registrasi')
            ->where('jenis_layanan', 'IGD')
            ->whereNull('deleted_at')
            ->count();

        $totalFiltered = $query->count();

        // Pagination & Ordering
        $start  = $request->input('start', 0);
        $length = $request->input('length', 10);

        $rawQuery = $query->select([
            'reg.id as registrasi_id',
            'reg.no_registrasi',
            'reg.tanggal_registrasi',
            'doc_poli.nama_lengkap as nama_dokter_poli',
            'poli.nama_poli',
            'p.pid as rm_pasien',
            'p.nama as nama_pasien',
            'reg.status_kunjungan',
            't.status_pembayaran',
            't.total_tagihan'
        ])
            ->orderBy('reg.tanggal_registrasi', 'DESC')
            ->offset($start)
            ->limit($length)
            ->get();

        $formattedData = [];
        $no = $start + 1;

        foreach ($rawQuery as $datas) {
            $noRegHtml = '<div class="d-flex flex-column">
                        <span class="code-block text-danger fw-bold">' . e($datas->no_registrasi) . '</span>
                        <span class="text-muted fs--2 mt-1">IGD Unit</span>
                      </div>';

            $pasienHtml = '<div class="fw-bold text-dark">' . e($datas->nama_pasien) . '</div>
                       <span class="text-muted fs--2">PID: ' . e($datas->rm_pasien) . '</span>';

            $tglHtml = '<div class="text-nowrap text-secondary">
                        <i class="far fa-clock me-1 opacity-50"></i>' . date('d/m/Y H:i', strtotime($datas->tanggal_registrasi)) . '
                    </div>';

            $dokterHtml = '<span class="text-dark fw-medium">' . e($datas->nama_dokter_poli ?? '-') . '</span>';

            $poliHtml = '<span class="badge bg-light text-dark border border-dark">' . e($datas->nama_poli ?? 'IGD Umum') . '</span>';

            $status = $datas->status_kunjungan ?? 'MENUNGGU';
            if ($status == 'MENUNGGU') {
                $statusHtml = '<span class="badge bg-warning text-dark px-2 py-1">Menunggu</span>';
            } elseif ($status == 'PROSES') {
                $statusHtml = '<span class="badge bg-info text-dark px-2 py-1">Penanganan</span>';
            } elseif ($status == 'SELESAI') {
                $statusHtml = '<span class="badge bg-success text-white px-2 py-1">Selesai</span>';
            } elseif ($status == 'BATAL') {
                $statusHtml = '<span class="badge bg-dark text-white px-2 py-1">Batal</span>';
            } else {
                $statusHtml = '<span class="badge bg-secondary text-white px-2 py-1">' . e($status) . '</span>';
            }

            $actionHtml = '<div class="d-flex justify-content-center gap-1">
                <button class="btn btn-sm retro-btn retro-btn-primary px-2 py-1" data-code="' . $datas->registrasi_id . '" title="Handling Pasien IGD" style="font-size: 0.7rem;">
                    <i class="fas fa-notes-medical"></i>
                </button>
               </div>';

            $formattedData[] = [
                'no'            => $no++,
                'no_registrasi' => $noRegHtml,
                'nama_pasien'   => $pasienHtml,
                'tanggal_reg'   => $tglHtml,
                'dokter'        => $dokterHtml,
                'poli'          => $poliHtml,
                'status'        => '<div class="text-center">' . $statusHtml . '</div>',
                'action'        => '<div class="text-center">' . $actionHtml . '</div>'
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $formattedData
        ]);
    }
    public function igd_handling_form(Request $request)
    {
        $registrasiId = $request->input('code');

        if (!$registrasiId) {
            return response()->json(['success' => false, 'message' => 'ID Registrasi tidak valid.'], 400);
        }

        // Ambil data utama registrasi pasien IGD
        $pasien = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->leftJoin('medical_master_poli as poli', 'reg.poli_id', '=', 'poli.id')
            ->leftJoin('medical_master_doctor as doc', 'reg.doctor_poli_id', '=', 'doc.id')
            ->leftJoin('medical_sub_penjamin as sp', 'reg.sub_penjamin_id', '=', 'sp.id')
            ->leftJoin('medical_penjamin as penjamin', 'sp.penjamin_id', '=', 'penjamin.id')
            ->where('reg.id', $registrasiId)
            ->select([
                'reg.*',
                'p.pid',
                'p.nama as nama_pasien',
                'p.tgl_lahir',
                'p.jk as jenis_kelamin',
                'p.alamat',
                'poli.nama_poli',
                'doc.nama_lengkap as nama_dokter',
                'sp.nama_sub_penjamin',
                'penjamin.nama_penjamin'
            ])
            ->first();

        if (!$pasien) {
            return '<div class="alert alert-danger m-3">Data pasien IGD tidak ditemukan.</div>';
        }

        // Ambil data triase jika sudah ada
        $triase = DB::table('medical_igd_triase')->where('registrasi_id', $registrasiId)->first();

        // Ambil data SOAP / Anamnesis terakhir jika ada
        $soap = DB::table('medical_igd_soap')->where('registrasi_id', $registrasiId)->orderBy('id', 'DESC')->first();

        // Ambil data tindakan medis yang sudah diorder
        $tindakanList = DB::table('medical_igd_tindakan as it')
            ->join('medical_master_pemeriksaan as mp', 'it.master_pemeriksaan_id', '=', 'mp.id')
            ->where('it.registrasi_id', $registrasiId)
            ->select('it.*', 'mp.nama_layanan')
            ->get();

        // Ambil data resep obat yang sudah diorder
        $resepList = DB::table('medical_igd_resep as ir')
            ->join('farm_data_obat as obat', 'ir.farm_data_obat_code', '=', 'obat.farm_data_obat_code')
            ->where('ir.registrasi_id', $registrasiId)
            ->select('ir.*', 'obat.farm_data_obat_name', 'obat.farm_data_obat_satuan')
            ->get();

        // Ambil Master Obat difilter berdasarkan Sub Penjamin Pasien
        $daftarObat = DB::table('farm_data_obat as obat')
            ->join('farm_penjamin_obat as fpo', 'fpo.farm_data_obat_code', '=', 'obat.farm_data_obat_code')
            ->where('fpo.sub_penjamin_id', $pasien->sub_penjamin_id)
            ->where('fpo.status', 1) // Obat aktif
            ->select('obat.farm_data_obat_code', 'obat.farm_data_obat_name', 'obat.farm_data_obat_satuan', 'obat.farm_data_obat_stok', 'fpo.harga_jual')
            ->get();

        $masterTindakan = DB::table('medical_master_pemeriksaan')->get();
        $ruanganInap = DB::table('medical_master_ruangan')->get();

        return view('application.igd.data-registrasi.handling-igd-modal', [
            'pasien'         => $pasien,
            'triase'         => $triase,
            'soap'           => $soap,
            'tindakanList'   => $tindakanList,
            'resepList'      => $resepList,
            'daftarObat'     => $daftarObat,
            'masterTindakan' => $masterTindakan,
            'ruanganInap'    => $ruanganInap
        ]);
    }
    public function igd_handling_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'registrasi_id' => 'required|exists:medical_registrasi,id',
            'skala_triage'  => 'required|integer|between:1,5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . $validator->errors()->first()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $registrasiId = $request->input('registrasi_id');

            // 1. Update Status Kunjungan pada tabel registrasi utama
            $statusKunjungan = $request->input('status_kunjungan', 'PROSES');
            DB::table('medical_registrasi')->where('id', $registrasiId)->update([
                'status_kunjungan' => $statusKunjungan,
                'updated_at'       => now()
            ]);

            // 2. Simpan atau Perbarui Data Triase & Tanda Vital
            DB::table('medical_igd_triase')->updateOrInsert(
                ['registrasi_id' => $registrasiId],
                [
                    'skala_triage'     => $request->input('skala_triage'),
                    'keluhan_utama'    => $request->input('keluhan_utama'),
                    'tekanan_darah'    => $request->input('tekanan_darah'),
                    'nadi'             => $request->input('nadi'),
                    'suhu'             => $request->input('suhu'),
                    'saturasi_oksigen' => $request->input('saturasi_oksigen'),
                    'pernapasan'       => $request->input('pernapasan'),
                    'kesadaran'        => $request->input('kesadaran'),
                    'updated_at'       => now(),
                    'created_at'       => now()
                ]
            );

            // 3. Simpan Catatan Medis (SOAP) Baru jika diisi
            if ($request->filled('subjektif') || $request->filled('objektif') || $request->filled('asesmen') || $request->filled('planning')) {
                DB::table('medical_igd_soap')->insert([
                    'registrasi_id' => $registrasiId,
                    'subjektif'     => $request->input('subjektif'),
                    'objektif'      => $request->input('objektif'),
                    'asesmen'       => $request->input('asesmen'),
                    'planning'      => $request->input('planning'),
                    'created_at'    => now(),
                    'updated_at'    => now()
                ]);
            }

            // 4. Simpan Disposisi / Tindak Lanjut Pasien IGD
            if ($request->filled('tindak_lanjut')) {
                $tindakLanjut = $request->input('tindak_lanjut'); // PULANG, RAWAT_INAP, RUJUK, MENINGGAL

                DB::table('medical_igd_disposisi')->updateOrInsert(
                    ['registrasi_id' => $registrasiId],
                    [
                        'tindak_lanjut'      => $tindakLanjut,
                        'ruangan_tujuan_id'  => $tindakLanjut == 'RAWAT_INAP' ? $request->input('ruangan_tujuan_id') : null,
                        'catatan_pulang'     => $request->input('catatan_pulang'),
                        'updated_at'         => now(),
                        'created_at'         => now()
                    ]
                );

                if ($tindakLanjut == 'RAWAT_INAP') {
                    $ruanganBedId = $request->input('ruangan_bed_id'); // Ambil ID bed/kasur yang dipilih

                    // 1. Ubah status kunjungan registrasi utama
                    DB::table('medical_registrasi')->where('id', $registrasiId)->update([
                        'status_kunjungan' => 'SELESAI',
                        'updated_at'       => now()
                    ]);

                    // 2. Ambil dokter penanggung jawab dari registrasi IGD untuk dimasukkan ke rawat inap
                    $regData = DB::table('medical_registrasi')->where('id', $registrasiId)->first();

                    // 3. Masukkan ke tabel medical_rawat_inap
                    DB::table('medical_rawat_inap')->updateOrInsert(
                        ['registrasi_id' => $registrasiId],
                        [
                            'ruangan_bed_id' => $ruanganBedId,
                            'kode_dokter'    => $regData->doctor_poli_id ?? null, // Mengambil dokter jaga IGD
                            'tgl_masuk'      => now(),
                            'created_at'     => now(),
                            'updated_at'     => now()
                        ]
                    );
                    DB::table('medical_master_bed')->where('id', $ruanganBedId)->update([
                        'status' => 'TERISI'
                    ]);
                }
            }

            // =========================================================================
            // MANAJEMEN KASIR & TAGIHAN TERPUSAT (MEDICAL TRANSAKSI)
            // =========================================================================

            // Ambil atau buat Header Transaksi Kasir
            $transaksi = DB::table('medical_transaksi')->where('registrasi_id', $registrasiId)->first();
            if (!$transaksi) {
                $transaksiId = DB::table('medical_transaksi')->insertGetId([
                    'registrasi_id'     => $registrasiId,
                    'total_tagihan'     => 0,
                    'total_bayar'       => 0,
                    'sisa_tagihan'      => 0,
                    'metode_bayar'      => 'CASH',
                    'status_pembayaran' => 'BELUM LUNAS',
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            } else {
                $transaksiId = $transaksi->id;
            }

            $akumulasiSelisihTagihan = 0;
            $tanggalFormat = date('dmy');

            // -------------------------------------------------------------------------
            // 5. SINKRONISASI TINDAKAN & PEMERIKSAAN IGD
            // -------------------------------------------------------------------------
            $submittedTindakanIds = $request->input('tindakan_ids', []);
            $submittedTarifList   = $request->input('tarif_tindakan', []);

            // A. Hapus tindakan lama yang tidak dicentang lagi (jika belum lunas)
            $existingTindakanIGD = DB::table('medical_igd_tindakan')->where('registrasi_id', $registrasiId)->get();
            foreach ($existingTindakanIGD as $extTind) {
                if (!in_array($extTind->master_pemeriksaan_id, $submittedTindakanIds)) {
                    // Hapus dari detail kasir jika belum lunas
                    $detailKasir = DB::table('medical_transaksi_detail')
                        ->where('transaksi_id', $transaksiId)
                        ->where('sumber_tagihan', 'IGD_TINDAKAN')
                        ->where('sumber_id', $extTind->id)
                        ->where('status_pembayaran', 'BELUM LUNAS')
                        ->first();

                    if ($detailKasir) {
                        $akumulasiSelisihTagihan -= $detailKasir->harga_akhir;
                        DB::table('medical_transaksi_detail')->where('id', $detailKasir->id)->delete();
                    }

                    // Hapus dari tabel IGD tindakan
                    DB::table('medical_igd_tindakan')->where('id', $extTind->id)->delete();
                }
            }

            // B. Masukkan atau perbarui tindakan baru
            foreach ($submittedTindakanIds as $index => $masterPemeriksaanId) {
                $tarif = (float) ($submittedTarifList[$index] ?? 0);

                // Cek apakah data tindakan IGD sudah ada
                $tindakanRecord = DB::table('medical_igd_tindakan')
                    ->where('registrasi_id', $registrasiId)
                    ->where('master_pemeriksaan_id', $masterPemeriksaanId)
                    ->first();

                if (!$tindakanRecord) {
                    // Insert baru ke medical_igd_tindakan
                    $tindakanId = DB::table('medical_igd_tindakan')->insertGetId([
                        'registrasi_id'         => $registrasiId,
                        'master_pemeriksaan_id' => $masterPemeriksaanId,
                        'tarif'                 => $tarif,
                        'created_at'            => now(),
                        'updated_at'            => now()
                    ]);

                    // Ambil info master untuk nomor pemeriksaan & nama
                    $master = DB::table('medical_master_pemeriksaan as mp')
                        ->leftJoin('medical_tipe_layanan as tl', 'mp.tipe_layanan_id', '=', 'tl.id')
                        ->select('mp.nama_layanan', 'tl.prefix')
                        ->where('mp.id', $masterPemeriksaanId)
                        ->first();

                    $prefix = strtoupper($master->prefix ?? 'IGD');
                    $lastOrder = DB::table('medical_transaksi_detail')
                        ->where('no_pemeriksaan', 'like', "{$prefix}{$tanggalFormat}%")
                        ->orderBy('id', 'desc')->first();

                    $noUrutOrder = $lastOrder ? (int) substr($lastOrder->no_pemeriksaan, -4) + 1 : 1;
                    $noPemeriksaanBaru = $prefix . $tanggalFormat . str_pad($noUrutOrder, 4, '0', STR_PAD_LEFT);

                    // Insert ke medical_transaksi_detail (Kasir)
                    DB::table('medical_transaksi_detail')->insert([
                        'transaksi_id'          => $transaksiId,
                        'jenis_item'            => 'TINDAKAN',
                        'nama_item'             => $master->nama_layanan ?? 'Tindakan IGD',
                        'master_pemeriksaan_id' => $masterPemeriksaanId,
                        'sumber_tagihan'        => 'IGD_TINDAKAN',
                        'sumber_id'             => $tindakanId,
                        'no_pemeriksaan'        => $noPemeriksaanBaru,
                        'qty'                   => 1,
                        'harga_dasar'           => $tarif,
                        'harga_akhir'           => $tarif,
                        'status_pemeriksaan'    => 'MENUNGGU',
                        'status_pembayaran'     => 'BELUM LUNAS',
                        'created_at'            => now(),
                        'updated_at'            => now(),
                    ]);

                    $akumulasiSelisihTagihan += $tarif;
                } else {
                    // Update tarif jika berubah dan belum lunas
                    $detailKasir = DB::table('medical_transaksi_detail')
                        ->where('transaksi_id', $transaksiId)
                        ->where('sumber_tagihan', 'IGD_TINDAKAN')
                        ->where('sumber_id', $tindakanRecord->id)
                        ->first();

                    if ($detailKasir && $detailKasir->status_pembayaran == 'BELUM LUNAS' && $detailKasir->harga_akhir != $tarif) {
                        $selisih = $tarif - $detailKasir->harga_akhir;
                        $akumulasiSelisihTagihan += $selisih;

                        DB::table('medical_transaksi_detail')->where('id', $detailKasir->id)->update([
                            'harga_dasar' => $tarif,
                            'harga_akhir' => $tarif,
                            'updated_at'  => now()
                        ]);
                    }

                    DB::table('medical_igd_tindakan')->where('id', $tindakanRecord->id)->update([
                        'tarif'      => $tarif,
                        'updated_at' => now()
                    ]);
                }
            }

            // -------------------------------------------------------------------------
            // 6. SINKRONISASI E-RESEP OBAT IGD
            // -------------------------------------------------------------------------
            $submittedObatCodes = $request->input('resep_obat_code', []);
            $submittedJumlah    = $request->input('resep_jumlah', []);
            $submittedSigna     = $request->input('resep_signa', []);
            $submittedHarga     = $request->input('resep_harga', []);

            // A. Hapus resep lama yang sudah dibuang di form (jika belum lunas)
            $existingResepIGD = DB::table('medical_igd_resep')->where('registrasi_id', $registrasiId)->get();
            foreach ($existingResepIGD as $extResep) {
                if (!in_array($extResep->farm_data_obat_code, $submittedObatCodes)) {
                    $detailKasirObat = DB::table('medical_transaksi_detail')
                        ->where('transaksi_id', $transaksiId)
                        ->where('sumber_tagihan', 'IGD_RESEP')
                        ->where('sumber_id', $extResep->id)
                        ->where('status_pembayaran', 'BELUM LUNAS')
                        ->first();

                    if ($detailKasirObat) {
                        $akumulasiSelisihTagihan -= $detailKasirObat->harga_akhir;
                        DB::table('medical_transaksi_detail')->where('id', $detailKasirObat->id)->delete();
                    }

                    DB::table('medical_igd_resep')->where('id', $extResep->id)->delete();
                }
            }

            // B. Masukkan atau perbarui resep obat baru
            foreach ($submittedObatCodes as $index => $kodeObat) {
                $qty   = (int) ($submittedJumlah[$index] ?? 1);
                $signa = $submittedSigna[$index] ?? '-';
                $harga = (float) ($submittedHarga[$index] ?? 0);
                $subtotalObat = $qty * $harga;

                $resepRecord = DB::table('medical_igd_resep')
                    ->where('registrasi_id', $registrasiId)
                    ->where('farm_data_obat_code', $kodeObat)
                    ->first();

                if (!$resepRecord) {
                    // Insert baru ke medical_igd_resep
                    $resepId = DB::table('medical_igd_resep')->insertGetId([
                        'registrasi_id'         => $registrasiId,
                        'transaksi_id'          => $transaksiId,
                        'farm_data_obat_code'   => $kodeObat,
                        'qty'                   => $qty,
                        'signa'                 => $signa,
                        'harga'                 => $harga,
                        'status_verifikasi'     => 'Verified', // Otomatis terverifikasi dari IGD
                        'status_pembayaran'     => 'BELUM LUNAS',
                        'created_at'            => now(),
                        'updated_at'            => now()
                    ]);

                    $masterObat = DB::table('farm_data_obat')->where('farm_data_obat_code', $kodeObat)->first();

                    // Insert ke medical_transaksi_detail (Kasir)
                    DB::table('medical_transaksi_detail')->insert([
                        'transaksi_id'          => $transaksiId,
                        'jenis_item'            => 'OBAT',
                        'nama_item'             => $masterObat->farm_data_obat_name ?? 'Obat Farmasi IGD',
                        'farm_data_obat_code'   => $kodeObat,
                        'sumber_tagihan'        => 'IGD_RESEP',
                        'sumber_id'             => $resepId,
                        'qty'                   => $qty,
                        'harga_dasar'           => $harga,
                        'harga_akhir'           => $subtotalObat,
                        'status_pemeriksaan'    => 'MENUNGGU',
                        'status_pembayaran'     => 'BELUM LUNAS',
                        'created_at'            => now(),
                        'updated_at'            => now(),
                    ]);

                    $akumulasiSelisihTagihan += $subtotalObat;
                } else {
                    // Update jika qty/harga berubah dan belum lunas
                    $detailKasirObat = DB::table('medical_transaksi_detail')
                        ->where('transaksi_id', $transaksiId)
                        ->where('sumber_tagihan', 'IGD_RESEP')
                        ->where('sumber_id', $resepRecord->id)
                        ->first();

                    if ($detailKasirObat && $detailKasirObat->status_pembayaran == 'BELUM LUNAS' && $detailKasirObat->harga_akhir != $subtotalObat) {
                        $selisih = $subtotalObat - $detailKasirObat->harga_akhir;
                        $akumulasiSelisihTagihan += $selisih;

                        DB::table('medical_transaksi_detail')->where('id', $detailKasirObat->id)->update([
                            'qty'         => $qty,
                            'harga_dasar' => $harga,
                            'harga_akhir' => $subtotalObat,
                            'updated_at'  => now()
                        ]);
                    }

                    DB::table('medical_igd_resep')->where('id', $resepRecord->id)->update([
                        'qty'        => $qty,
                        'signa'      => $signa,
                        'harga'      => $harga,
                        'updated_at' => now()
                    ]);
                }
            }

            // -------------------------------------------------------------------------
            // 7. UPDATE TOTAL TAGIHAN DI HEADER TRANSAKSI UTAMA
            // -------------------------------------------------------------------------
            if ($akumulasiSelisihTagihan != 0) {
                DB::table('medical_transaksi')
                    ->where('id', $transaksiId)
                    ->update([
                        'total_tagihan' => DB::raw("total_tagihan + ($akumulasiSelisihTagihan)"),
                        'sisa_tagihan'  => DB::raw("sisa_tagihan + ($akumulasiSelisihTagihan)"),
                    ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data handling, tindakan, dan resep obat IGD berhasil disimpan & disinkronisasi ke kasir!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getSubPenjaminByPenjamin(Request $request)
    {
        $penjaminId = $request->input('penjamin_id');

        $subPenjamins = DB::table('medical_sub_penjamin')
            ->where('penjamin_id', $penjaminId)
            ->select('id', 'nama_sub_penjamin')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $subPenjamins
        ]);
    }
    public function getTarifIgdBySubPenjamin(Request $request)
    {
        $subPenjaminId = $request->input('sub_penjamin_id');

        if (!$subPenjaminId) {
            return response()->json([
                'success' => true,
                'data'    => []
            ]);
        }

        $items = DB::table('medical_master_pemeriksaan as mp')
            ->join('medical_penjamin_pemeriksaan as pp', 'mp.id', '=', 'pp.master_pemeriksaan_id')
            ->where('pp.sub_penjamin_id', $subPenjaminId)
            ->where('mp.is_active', 1)
            ->select(
                'mp.id as id',
                'mp.nama_layanan as nama_pemeriksaan',
                'mp.harga as tarif'
            )
            ->distinct()
            ->orderBy('mp.nama_layanan', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $items
        ]);
    }
    // DATA REGISTRASI LAB
    public function verifikasi_data_igd($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('application.igd.verifikasi-data-igd', [
                'akses' => $akses,
                'code'  => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_verifikasi_igd_table(Request $request)
    {
        $query = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->leftJoin('medical_transaksi as t', 't.registrasi_id', '=', 'reg.id')
            ->leftJoin('medical_master_doctor as doc_poli', 'doc_poli.id', '=', 'reg.doctor_poli_id')
            ->where('reg.jenis_layanan', 'IGD')
            ->whereNull('reg.deleted_at');

        // Filter Rentang Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('reg.tanggal_registrasi', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Filter Keyword
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('reg.no_registrasi', 'like', "%{$keyword}%")
                    ->orWhere('p.nama', 'like', "%{$keyword}%")
                    ->orWhere('p.pid', 'like', "%{$keyword}%");
            });
        }

        // Filter Status Kunjungan
        if ($request->filled('status_kunjungan')) {
            $query->where('reg.status_kunjungan', $request->status_kunjungan);
        }

        $totalData = DB::table('medical_registrasi')
            ->where('jenis_layanan', 'IGD')
            ->whereNull('deleted_at')
            ->count();

        $totalFiltered = $query->count();

        $start  = $request->input('start', 0);
        $length = $request->input('length', 10);

        $rawQuery = $query->select([
            'reg.id as registrasi_id',
            'reg.no_registrasi',
            'reg.tanggal_registrasi',
            'reg.status_kunjungan',
            'doc_poli.nama_lengkap as nama_dokter',
            'p.pid as rm_pasien',
            'p.nama as nama_pasien',
            't.total_tagihan'
        ])
            ->orderBy('reg.tanggal_registrasi', 'DESC')
            ->offset($start)
            ->limit($length)
            ->get();

        $formattedData = [];
        $no = $start + 1;

        foreach ($rawQuery as $datas) {
            $noRegHtml = '<div class="d-flex flex-column">
                        <span class="code-block text-danger fw-bold">' . e($datas->no_registrasi) . '</span>
                        <span class="text-muted fs--2 mt-1"><i class="far fa-clock me-1"></i>' . date('d/m/Y H:i', strtotime($datas->tanggal_registrasi)) . '</span>
                      </div>';

            $pasienHtml = '<div class="fw-bold text-dark">' . e($datas->nama_pasien) . '</div>
                       <span class="text-muted fs--2">RM: ' . e($datas->rm_pasien) . '</span>';

            // Placeholder Triage (bisa disesuaikan jika kolom triage sudah ada di tabel registrasi/igd)
            $triageHtml = '<span class="retro-badge bg-success text-white">Umum / Hijau</span>';

            $keluhanHtml = '<span class="text-dark fw-medium">Penanganan IGD Umum</span>';
            $dokterHtml = '<span class="text-dark fw-medium">' . e($datas->nama_dokter ?? '-') . '</span>';
            $tagihanHtml = '<span class="fw-bolder text-danger">Rp ' . number_format($datas->total_tagihan ?? 0, 0, ',', '.') . '</span>';

            $actionHtml = '<div class="d-flex justify-content-center gap-1">
            <button type="button" class="btn retro-btn retro-btn-primary btn-sm px-2 py-1 fs--2" onclick="lihatDetailIgd(\'' . $datas->registrasi_id . '\', \'' . e($datas->nama_pasien) . '\')" title="Lihat Hasil & Tindakan IGD">
                <i class="fas fa-eye"></i> Detail
            </button>
        </div>';

            $formattedData[] = [
                'no'            => $no++,
                'no_registrasi' => $noRegHtml,
                'nama_pasien'   => $pasienHtml,
                'triage'        => '<div class="text-center">' . $triageHtml . '</div>',
                'keluhan'       => $keluhanHtml,
                'dokter'        => $dokterHtml,
                'tagihan'       => '<div class="text-end">' . $tagihanHtml . '</div>',
                'action'        => '<div class="text-center">' . $actionHtml . '</div>'
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $formattedData
        ]);
    }
    public function getDetailVerifikasiIgd(Request $request)
    {
        $registrasiId = $request->input('registrasi_id');

        // 1. Ambil data informasi registrasi & catatan pemeriksaan IGD pasien
        $igd = DB::table('medical_registrasi as reg')
            ->leftJoin('medical_master_doctor as doc', 'doc.id', '=', 'reg.doctor_poli_id')
            ->leftJoin('medical_master_poli as poli', 'poli.id', '=', 'reg.poli_id')
            ->leftJoin('medical_igd_soap as soap', 'soap.registrasi_id', '=', 'reg.id')
            ->leftJoin('medical_igd_triase as triase', 'triase.registrasi_id', '=', 'reg.id')
            ->select(
                'reg.*',
                'doc.nama_lengkap as nama_dokter',
                'poli.nama_poli',
                'triase.keluhan_utama',
                'soap.subjektif as anamnesis',
                'soap.asesmen as diagnosis'
            )
            ->where('reg.id', $registrasiId)
            ->first();

        // 2. Ambil daftar tindakan atau item pemeriksaan dari transaksi detail registrasi tersebut
        $tindakanList = [];
        $transaksi = DB::table('medical_transaksi')->where('registrasi_id', $registrasiId)->first();

        if ($transaksi) {
            $tindakanList = DB::table('medical_transaksi_detail as td')
                ->leftJoin('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
                ->select(
                    'td.id as detail_id',
                    DB::raw('COALESCE(mp.nama_layanan, td.nama_item, td.kategori_biaya, "Tindakan Medis IGD") as nama_layanan'),
                    'td.qty as jumlah',
                    'td.harga_akhir as tarif',
                    'td.status_pembayaran',
                    'td.status_pemeriksaan'
                )
                ->where('td.transaksi_id', $transaksi->id)
                ->where('td.status_pemeriksaan', '!=', 'BATAL')
                ->get();
        }

        return response()->json([
            'success'      => true,
            'igd'          => [
                'keluhan_utama' => $igd->keluhan_utama ?? 'Penanganan kegawatdaruratan medis IGD unit.',
                'anamnesis'     => $igd->anamnesis ?? 'Pemeriksaan fisik awal dan stabilisasi pasien.',
                'diagnosis'     => $igd->diagnosis ?? 'Sesuai catatan pemeriksaan dokter DPJP IGD.'
            ],
            'tindakanList' => $tindakanList
        ]);
    }
    public function cancelDetailIgd(Request $request)
    {
        $request->validate([
            'detail_id' => 'required|exists:medical_transaksi_detail,id'
        ]);

        try {
            DB::beginTransaction();

            $detail = DB::table('medical_transaksi_detail')->where('id', $request->detail_id)->first();

            if (!$detail) {
                return response()->json(['success' => false, 'message' => 'Item tindakan tidak ditemukan.'], 404);
            }

            if ($detail->status_pembayaran === 'LUNAS') {
                return response()->json(['success' => false, 'message' => 'Item yang sudah lunas tidak dapat dibatalkan.'], 422);
            }

            $subtotalHarga = $detail->harga_akhir;
            $transaksiId = $detail->transaksi_id;

            // 1. Update status pemeriksaan menjadi BATAL (atau hapus barisnya)
            DB::table('medical_transaksi_detail')
                ->where('id', $detail->id)
                ->update([
                    'status_pemeriksaan' => 'BATAL',
                    'harga_akhir'        => 0,
                    'updated_at'         => now()
                ]);

            // Jika terhubung dengan tabel sumber IGD (tindakan/resep), sesuaikan statusnya jika perlu
            if ($detail->sumber_tagihan === 'IGD_TINDAKAN' && $detail->sumber_id) {
                DB::table('medical_igd_tindakan')->where('id', $detail->sumber_id)->delete();
            } elseif ($detail->sumber_tagihan === 'IGD_RESEP' && $detail->sumber_id) {
                DB::table('medical_igd_resep')->where('id', $detail->sumber_id)->delete();
            }

            // 2. Kurangi total tagihan & sisa tagihan di header medical_transaksi
            DB::table('medical_transaksi')
                ->where('id', $transaksiId)
                ->update([
                    'total_tagihan' => DB::raw("GREATEST(0, total_tagihan - {$subtotalHarga})"),
                    'sisa_tagihan'  => DB::raw("GREATEST(0, sisa_tagihan - {$subtotalHarga})"),
                    'updated_at'    => now()
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Item tindakan/resep berhasil dibatalkan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan item: ' . $e->getMessage()
            ], 500);
        }
    }
    // DATA REGISTRASI LAB
    public function riwayat_pasien_igd($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('application.igd.riwayat-pasien-igd', [
                'akses' => $akses,
                'code'  => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

    public function data_riwayat_igd_table(Request $request)
    {
        $query = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            ->leftJoin('medical_transaksi as t', 't.registrasi_id', '=', 'reg.id')
            ->leftJoin('medical_master_doctor as doc_poli', 'doc_poli.id', '=', 'reg.doctor_poli_id')
            ->where('reg.jenis_layanan', 'IGD')
            ->whereNull('reg.deleted_at');

        // Filter Rentang Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('reg.tanggal_registrasi', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Filter Keyword
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('reg.no_registrasi', 'like', "\%{$keyword}%")
                    ->orWhere('p.nama', 'like', "%{$keyword}%")
                    ->orWhere('p.pid', 'like', "%{$keyword}%");
            });
        }

        // Filter Status Kunjungan
        if ($request->filled('status_kunjungan')) {
            $query->where('reg.status_kunjungan', $request->status_kunjungan);
        }

        $totalData = DB::table('medical_registrasi')
            ->where('jenis_layanan', 'IGD')
            ->whereNull('deleted_at')
            ->count();

        $totalFiltered = $query->count();

        $start  = $request->input('start', 0);
        $length = $request->input('length', 10);

        $rawQuery = $query->select([
            'reg.id as registrasi_id',
            'reg.no_registrasi',
            'reg.tanggal_registrasi',
            'reg.status_kunjungan',
            'doc_poli.nama_lengkap as nama_dokter',
            'p.pid as rm_pasien',
            'p.nama as nama_pasien',
            't.total_tagihan'
        ])
            ->orderBy('reg.tanggal_registrasi', 'DESC') // Urutkan dari yang terbaru
            ->offset($start)
            ->limit($length)
            ->get();

        $formattedData = [];
        $no = $start + 1;

        foreach ($rawQuery as $datas) {
            $noRegHtml = '<div class="d-flex flex-column">
                        <span class="code-block text-success fw-bold">' . e($datas->no_registrasi) . '</span>
                        <span class="text-muted fs--2 mt-1"><i class="far fa-clock me-1"></i>' . date('d/m/Y H:i', strtotime($datas->tanggal_registrasi)) . '</span>
                      </div>';

            $pasienHtml = '<div class="fw-bold text-dark">' . e($datas->nama_pasien) . '</div>
                       <span class="text-muted fs--2">RM: ' . e($datas->rm_pasien) . '</span>';

            $dokterHtml = '<span class="text-dark fw-medium">' . e($datas->nama_dokter ?? '-') . '</span>';

            $status = $datas->status_kunjungan ?? 'MENUNGGU';
            if ($status == 'MENUNGGU') {
                $statusHtml = '<span class="badge bg-warning text-dark px-2 py-1">Menunggu</span>';
            } elseif ($status == 'PROSES') {
                $statusHtml = '<span class="badge bg-info text-dark px-2 py-1">Penanganan</span>';
            } elseif ($status == 'SELESAI') {
                $statusHtml = '<span class="badge bg-success text-white px-2 py-1">Selesai / Pulang</span>';
            } else {
                $statusHtml = '<span class="badge bg-secondary text-white px-2 py-1">' . e($status) . '</span>';
            }

            $tagihanHtml = '<span class="fw-bolder text-danger">Rp ' . number_format($datas->total_tagihan ?? 0, 0, ',', '.') . '</span>';

            $actionHtml = '<div class="d-flex justify-content-center gap-1">
            <button type="button" class="btn retro-btn retro-btn-primary btn-sm px-2 py-1 fs--2" onclick="lihatRiwayatIgd(\'' . $datas->registrasi_id . '\', \'' . e($datas->nama_pasien) . '\')" title="Lihat Rekam Medis & Histori IGD">
                <i class="fas fa-history"></i> Riwayat
            </button>
        </div>';

            $formattedData[] = [
                'no'            => $no++,
                'no_registrasi' => $noRegHtml,
                'nama_pasien'   => $pasienHtml,
                'dokter'        => $dokterHtml,
                'status'        => '<div class="text-center">' . $statusHtml . '</div>',
                'tagihan'       => '<div class="text-end">' . $tagihanHtml . '</div>',
                'action'        => '<div class="text-center">' . $actionHtml . '</div>'
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $formattedData
        ]);
    }
}
