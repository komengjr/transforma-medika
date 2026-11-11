<?php

namespace App\Http\Controllers\Medic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LayananMedisController extends Controller
{
    public function getPemeriksaanBySubPenjamin($sub_penjamin_id)
    {
        $pemeriksaan = DB::table('medical_penjamin_pemeriksaan as pivot')
            ->join('medical_master_pemeriksaan as master', 'pivot.master_pemeriksaan_id', '=', 'master.id')
            ->where('pivot.sub_penjamin_id', $sub_penjamin_id)
            ->select(
                'master.id',
                'master.kode_layanan',
                'master.nama_layanan',
                'master.harga as harga_dasar',
                'master.is_paket', // Ambil status paket
                'pivot.diskon',
                DB::raw('(master.harga - pivot.diskon) as harga_akhir')
            )
            ->get();

        // Jika dia adalah paket, ambil isi detailnya
        foreach ($pemeriksaan as $item) {
            if ($item->is_paket) {
                // Ambil daftar pemeriksaan anak yang ada di dalam paket ini
                $item->detail_paket = DB::table('medical_paket_detail as pd')
                    ->join('medical_master_pemeriksaan as m', 'pd.pemeriksaan_id', '=', 'm.id')
                    ->where('pd.paket_id', $item->id)
                    ->select('m.id', 'm.kode_layanan', 'm.nama_layanan')
                    ->get();
            } else {
                $item->detail_paket = []; // Kosongkan jika bukan paket
            }
        }

        return response()->json([
            'success' => true,
            'data' => $pemeriksaan
        ]);
    }
    public function prosesDanCetak(Request $request)
    {
        // 1. SESUAIKAN VALIDASI DENGAN PAYLOAD JAVASCRIPT
        $request->validate([
            'pasien_id'       => 'required',
            'jenis_layanan'   => 'required|string',
            'poli_id'         => 'nullable|numeric',
            'ruangan_id'      => 'nullable|numeric',
            'bed_id'          => 'nullable|numeric',
            'doctor_id'       => 'nullable|numeric', // Dokter Pengirim
            'doctor_poli_id'  => 'nullable|numeric', // Dokter Pemeriksa Rawat Jalan
            'doctor_igd_id'   => 'nullable|numeric', // Dokter Jaga IGD
            'sub_penjamin_id' => 'nullable|numeric',
            'tipe_fpp_id'     => 'nullable|numeric',
            'keluhan_medis'   => 'nullable|string',
            'tanggal_periksa' => 'nullable|date',
            'items'           => 'required|array',
            'total_tagihan'   => 'required|numeric',
            'metode_bayar'    => 'required|string',
            'bahasa_hasil'    => 'nullable|array',
            'pengiriman'      => 'nullable|array',
            'is_cito'         => 'nullable',
            'edc_data'        => 'nullable|array',   // Array data untuk pembayaran EDC
        ]);

        try {
            DB::beginTransaction();

            $userId = Auth::user()->userid ?? 'SYSTEM';

            // 2. TANGKAP FLAG CITO GLOBAL
            $isCitoGlobal = $request->input('is_cito', 0);

            if ($isCitoGlobal == 0) {
                foreach ($request->items as $item) {
                    if (isset($item['is_cito']) && ($item['is_cito'] == 1 || $item['is_cito'] === '1' || $item['is_cito'] === true)) {
                        $isCitoGlobal = 1;
                        break;
                    }
                }
            }

            // 3. GENERATE NO REGISTRASI OTOMOTIS (Format: REG-YYYYMMDD-XXXX)
            $tanggalHariIni = date('Ymd');
            $lastReg = DB::table('medical_registrasi')
                ->where('no_registrasi', 'like', "REG-{$tanggalHariIni}-%")
                ->orderBy('id', 'desc')
                ->first();

            $noUrutReg = $lastReg ? (int) substr($lastReg->no_registrasi, -4) + 1 : 1;
            $noRegistrasiBaru = 'REG-' . $tanggalHariIni . '-' . str_pad($noUrutReg, 4, '0', STR_PAD_LEFT);

            // Gabungkan Dokter Pemeriksa (Bisa dari Poli, IGD, atau Dokter Utama)
            $dokterPemeriksa = $request->doctor_poli_id ?? $request->doctor_igd_id ?? $request->doctor_id ?? null;

            // 4. SIMPAN DATA KE TABEL REGISTRASI
            $registrasiId = DB::table('medical_registrasi')->insertGetId([
                'no_registrasi'      => $noRegistrasiBaru,
                'pasien_id'          => $request->pasien_id,
                'jenis_layanan'      => $request->jenis_layanan,
                'poli_id'            => $request->poli_id ?? null,
                'ruangan_id'         => $request->ruangan_id ?? null,
                'bed_id'             => $request->bed_id ?? null,
                'doctor_id'          => $request->doctor_id ?? null,
                'doctor_poli_id'     => $dokterPemeriksa,
                'sub_penjamin_id'    => $request->sub_penjamin_id ?? null,
                'tipe_fpp_id'        => $request->tipe_fpp_id ?? null,
                'janji_hasil'        => $request->tanggal_periksa ?? null,
                'keluhan_medis'      => $request->keluhan_medis ?? null,
                'bahasa_hasil'       => $request->has('bahasa_hasil') ? json_encode($request->bahasa_hasil) : null,
                'metode_pengiriman'  => $request->has('pengiriman') ? json_encode($request->pengiriman) : null,
                'is_cito'            => $isCitoGlobal,
                'user_id'            => $userId,
                'tanggal_registrasi' => now(),
                'status_kunjungan'   => 'MENUNGGU',
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            // 4.1 JIKA LAYANAN RAWAT INAP (RANAP), SIMPAN KE TABEL medical_rawat_inap & UPDATE STATUS BED
            $jenisLayananUpper = strtoupper($request->jenis_layanan);
            if (in_array($jenisLayananUpper, ['RAWAT_INAP', 'RANAP'])) {
                if ($request->bed_id) {
                    DB::table('medical_rawat_inap')->insert([
                        'registrasi_id'  => $registrasiId,
                        'ruangan_bed_id' => $request->bed_id,
                        'kode_dokter'    => $dokterPemeriksa,
                        'tgl_masuk'      => now(),
                        'tgl_keluar'     => null,
                        'status_pulang'  => null,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);

                    DB::table('medical_master_bed')
                        ->where('id', $request->bed_id)
                        ->update([
                            'status'     => 'TERISI',
                            'updated_at' => now()
                        ]);
                }
            }

            // 5. LOGIKA PEMBAYARAN & PEMBUATAN TRANSAKSI
            $metodeBayar = strtoupper($request->metode_bayar);
            $totalTagihan = $request->total_tagihan;

            $totalBayar = ($metodeBayar === 'PIUTANG') ? 0 : $totalTagihan;
            $sisaTagihan = ($metodeBayar === 'PIUTANG') ? $totalTagihan : 0;

            $statusPembayaran = ($metodeBayar === 'PIUTANG') ? 'BELUM LUNAS' : 'LUNAS';
            $waktuLunas = ($metodeBayar === 'PIUTANG') ? null : now();
            $dibuatOleh = ($metodeBayar === 'PIUTANG') ? null : $userId;

            $transaksiId = DB::table('medical_transaksi')->insertGetId([
                'registrasi_id'     => $registrasiId,
                'total_tagihan'     => $totalTagihan,
                'total_bayar'       => $totalBayar,
                'sisa_tagihan'      => $sisaTagihan,
                'metode_bayar'      => $metodeBayar,
                'edc_id'            => $request->edc_data['edc_id'] ?? null,
                'no_referensi'      => $request->edc_data['approval'] ?? null,
                'status_pembayaran' => $statusPembayaran,
                'dibuat_oleh'       => $dibuatOleh,
                'dilunasi_oleh'     => null,
                'waktu_lunas'       => $waktuLunas,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            // 6. SIMPAN DETAIL ITEM PEMERIKSAAN
            $tanggalFormat = date('dmy');

            foreach ($request->items as $item) {
                $kategoriBiaya = $item['kategori_biaya'] ?? 'TINDAKAN';

                // Item non-tindakan medis (Termasuk KAMAR_INAP, ADMINISTRASI, dll)
                if (in_array($kategoriBiaya, ['ADMINISTRASI', 'JASA_DOKTER', 'KAMAR_INAP', 'KEPERAWATAN'])) {
                    DB::table('medical_transaksi_detail')->insert([
                        'transaksi_id'          => $transaksiId,
                        'jenis_item'            => $kategoriBiaya, // INSERT JENIS ITEM
                        'nama_item'             => $item['nama_item'] ?? 'Biaya ' . $kategoriBiaya, // INSERT NAMA ITEM
                        'master_pemeriksaan_id' => null,
                        'no_pemeriksaan'        => null,
                        'qty'                   => 1, // DEFAULT QTY
                        'harga_dasar'           => $item['harga_dasar'],
                        'diskon'                => $item['diskon'] ?? 0,
                        'is_cito'               => 0,
                        'biaya_cito'            => 0,
                        'harga_akhir'           => $item['harga_akhir'],
                        'status_pemeriksaan'    => 'SELESAI',
                        'status_pembayaran'     => $statusPembayaran,
                        'waktu_bayar'           => $waktuLunas,
                        'created_at'            => now(),
                        'updated_at'            => now(),
                    ]);
                    continue;
                }

                $isCitoItem = (isset($item['is_cito']) && ($item['is_cito'] == 1 || $item['is_cito'] === '1' || $item['is_cito'] === true)) ? 1 : 0;
                $biayaCitoItem = isset($item['biaya_cito']) ? (float) $item['biaya_cito'] : 0;

                if (!isset($item['id'])) {
                    continue;
                }

                $masterId = str_replace('tarif_', '', $item['id']);
                $master = DB::table('medical_master_pemeriksaan as mp')
                    ->leftJoin('medical_tipe_layanan as tl', 'mp.tipe_layanan_id', '=', 'tl.id')
                    ->select('mp.id', 'mp.nama_layanan', 'mp.is_paket', 'tl.prefix')
                    ->where('mp.id', $masterId)
                    ->first();

                if ($master) {
                    $prefix = strtoupper($master->prefix ?? 'ORD');

                    $lastOrder = DB::table('medical_transaksi_detail')
                        ->where('no_pemeriksaan', 'like', "{$prefix}{$tanggalFormat}%")
                        ->orderBy('id', 'desc')
                        ->first();

                    $noUrutOrder = $lastOrder ? (int) substr($lastOrder->no_pemeriksaan, -4) + 1 : 1;
                    $noPemeriksaanBaru = $prefix . $tanggalFormat . str_pad($noUrutOrder, 4, '0', STR_PAD_LEFT);

                    // A. SIMPAN ITEM UTAMA TINDAKAN MEDIS
                    DB::table('medical_transaksi_detail')->insert([
                        'transaksi_id'          => $transaksiId,
                        'jenis_item'            => 'TINDAKAN', // INSERT JENIS ITEM
                        'nama_item'             => $master->nama_layanan, // INSERT NAMA ITEM
                        'master_pemeriksaan_id' => $master->id,
                        'no_pemeriksaan'        => $noPemeriksaanBaru,
                        'qty'                   => 1, // DEFAULT QTY UNTUK TINDAKAN
                        'harga_dasar'           => $item['harga_dasar'],
                        'diskon'                => $item['diskon'] ?? 0,
                        'is_cito'               => $isCitoItem,
                        'biaya_cito'            => $biayaCitoItem,
                        'harga_akhir'           => $item['harga_akhir'],
                        'status_pemeriksaan'    => 'MENUNGGU',
                        'status_pembayaran'     => $statusPembayaran,
                        'waktu_bayar'           => $waktuLunas,
                        'created_at'            => now(),
                        'updated_at'            => now(),
                    ]);

                    // B. JIKA ITEM ADALAH PAKET: Simpan komponen di dalam paket
                    if ($master->is_paket == 1 || $master->is_paket == true) {
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
                                'jenis_item'            => 'TINDAKAN', // INSERT JENIS ITEM
                                'nama_item'             => $sub->sub_nama, // INSERT NAMA ITEM
                                'master_pemeriksaan_id' => $sub->sub_id,
                                'no_pemeriksaan'        => $noPemeriksaanSub,
                                'qty'                   => 1,
                                'harga_dasar'           => 0,
                                'diskon'                => 0,
                                'is_cito'               => $isCitoItem,
                                'biaya_cito'            => 0,
                                'harga_akhir'           => 0,
                                'status_pemeriksaan'    => 'MENUNGGU',
                                'status_pembayaran'     => $statusPembayaran,
                                'waktu_bayar'           => $waktuLunas,
                                'created_at'            => now(),
                                'updated_at'            => now(),
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success'       => true,
                'message'       => 'Registrasi dan transaksi berhasil disimpan!',
                'transaksi_id'  => $transaksiId,
                'no_registrasi' => $noRegistrasiBaru,
                'redirect_url'  => route('pembayaran.nota', $transaksiId)
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success'       => false,
                'message'       => 'Gagal memproses transaksi: ' . $e->getMessage()
            ], 500);
        }
    }
    public function prosesDanCetak_old1(Request $request)
    {
        // 1. SESUAIKAN VALIDASI DENGAN PAYLOAD JAVASCRIPT
        $request->validate([
            'pasien_id'       => 'required',
            'jenis_layanan'   => 'required|string',
            'poli_id'         => 'nullable|numeric',
            'ruangan_id'      => 'nullable|numeric',
            'bed_id'          => 'nullable|numeric',
            'doctor_id'       => 'nullable|numeric', // Dokter Pengirim
            'doctor_poli_id'  => 'nullable|numeric', // Dokter Pemeriksa Rawat Jalan
            'doctor_igd_id'   => 'nullable|numeric', // Dokter Jaga IGD
            'sub_penjamin_id' => 'nullable|numeric',
            'tipe_fpp_id'     => 'nullable|numeric',
            'keluhan_medis'   => 'nullable|string',
            'tanggal_periksa' => 'nullable|date',
            'items'           => 'required|array',
            'total_tagihan'   => 'required|numeric',
            'metode_bayar'    => 'required|string',
            'bahasa_hasil'    => 'nullable|array',
            'pengiriman'      => 'nullable|array',
            'is_cito'         => 'nullable',
            'edc_data'        => 'nullable|array',   // Array data untuk pembayaran EDC
        ]);

        try {
            DB::beginTransaction();

            $userId = Auth::user()->userid ?? 'SYSTEM';

            // 2. TANGKAP FLAG CITO GLOBAL
            $isCitoGlobal = $request->input('is_cito', 0);

            if ($isCitoGlobal == 0) {
                foreach ($request->items as $item) {
                    if (isset($item['is_cito']) && ($item['is_cito'] == 1 || $item['is_cito'] === '1' || $item['is_cito'] === true)) {
                        $isCitoGlobal = 1;
                        break;
                    }
                }
            }

            // 3. GENERATE NO REGISTRASI OTOMOTIS (Format: REG-YYYYMMDD-XXXX)
            $tanggalHariIni = date('Ymd');
            $lastReg = DB::table('medical_registrasi')
                ->where('no_registrasi', 'like', "REG-{$tanggalHariIni}-%")
                ->orderBy('id', 'desc')
                ->first();

            $noUrutReg = $lastReg ? (int) substr($lastReg->no_registrasi, -4) + 1 : 1;
            $noRegistrasiBaru = 'REG-' . $tanggalHariIni . '-' . str_pad($noUrutReg, 4, '0', STR_PAD_LEFT);

            // Gabungkan Dokter Pemeriksa (Bisa dari Poli, IGD, atau Dokter Utama)
            $dokterPemeriksa = $request->doctor_poli_id ?? $request->doctor_igd_id ?? $request->doctor_id ?? null;

            // 4. SIMPAN DATA KE TABEL REGISTRASI
            $registrasiId = DB::table('medical_registrasi')->insertGetId([
                'no_registrasi'      => $noRegistrasiBaru,
                'pasien_id'          => $request->pasien_id,
                'jenis_layanan'      => $request->jenis_layanan,
                'poli_id'            => $request->poli_id ?? null,
                'ruangan_id'         => $request->ruangan_id ?? null,
                'bed_id'             => $request->bed_id ?? null,
                'doctor_id'          => $request->doctor_id ?? null,
                'doctor_poli_id'     => $dokterPemeriksa,
                'sub_penjamin_id'    => $request->sub_penjamin_id ?? null,
                'tipe_fpp_id'        => $request->tipe_fpp_id ?? null,
                'janji_hasil'        => $request->tanggal_periksa ?? null,
                'keluhan_medis'      => $request->keluhan_medis ?? null,
                'bahasa_hasil'       => $request->has('bahasa_hasil') ? json_encode($request->bahasa_hasil) : null,
                'metode_pengiriman'  => $request->has('pengiriman') ? json_encode($request->pengiriman) : null,
                'is_cito'            => $isCitoGlobal,
                'user_id'            => $userId,
                'tanggal_registrasi' => now(),
                'status_kunjungan'   => 'MENUNGGU',
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            // 4.1 JIKA LAYANAN RAWAT INAP (RANAP), SIMPAN KE TABEL medical_rawat_inap & UPDATE STATUS BED
            $jenisLayananUpper = strtoupper($request->jenis_layanan);
            if (in_array($jenisLayananUpper, ['RAWAT_INAP', 'RANAP'])) {
                if ($request->bed_id) {
                    // Masukkan data ke tabel medical_rawat_inap
                    DB::table('medical_rawat_inap')->insert([
                        'registrasi_id'  => $registrasiId,
                        'ruangan_bed_id' => $request->bed_id,
                        'kode_dokter'    => $dokterPemeriksa,
                        'tgl_masuk'      => now(),
                        'tgl_keluar'     => null,
                        'status_pulang'  => null,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);

                    // Update status bed menjadi TERISI
                    DB::table('medical_master_bed')
                        ->where('id', $request->bed_id)
                        ->update([
                            'status'     => 'TERISI',
                            'updated_at' => now()
                        ]);
                }
            }

            // 5. LOGIKA PEMBAYARAN & PEMBUATAN TRANSAKSI
            $metodeBayar = strtoupper($request->metode_bayar);
            $totalTagihan = $request->total_tagihan;

            $totalBayar = ($metodeBayar === 'PIUTANG') ? 0 : $totalTagihan;
            $sisaTagihan = ($metodeBayar === 'PIUTANG') ? $totalTagihan : 0;

            // --- UPDATE: Status Pembayaran Item & Header ---
            $statusPembayaran = ($metodeBayar === 'PIUTANG') ? 'BELUM LUNAS' : 'LUNAS';
            $waktuLunas = ($metodeBayar === 'PIUTANG') ? null : now();
            // -----------------------------------------------

            $dibuatOleh = ($metodeBayar === 'PIUTANG') ? null : $userId;

            $transaksiId = DB::table('medical_transaksi')->insertGetId([
                'registrasi_id'     => $registrasiId,
                'total_tagihan'     => $totalTagihan,
                'total_bayar'       => $totalBayar,
                'sisa_tagihan'      => $sisaTagihan,
                'metode_bayar'      => $metodeBayar,
                'edc_id'            => $request->edc_data['edc_id'] ?? null,
                'no_referensi'      => $request->edc_data['approval'] ?? null,
                'status_pembayaran' => $statusPembayaran,
                'dibuat_oleh'       => $dibuatOleh,
                'dilunasi_oleh'     => null,
                'waktu_lunas'       => $waktuLunas,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            // 6. SIMPAN DETAIL ITEM PEMERIKSAAN
            $tanggalFormat = date('dmy');

            foreach ($request->items as $item) {
                $kategoriBiaya = $item['kategori_biaya'] ?? 'TINDAKAN';

                // Item non-tindakan (Termasuk KAMAR_INAP, ADMINISTRASI, dll)
                if (in_array($kategoriBiaya, ['ADMINISTRASI', 'JASA_DOKTER', 'KAMAR_INAP', 'KEPERAWATAN'])) {
                    DB::table('medical_transaksi_detail')->insert([
                        'transaksi_id'          => $transaksiId,
                        'master_pemeriksaan_id' => null,
                        'kategori_biaya'        => $kategoriBiaya,
                        'no_pemeriksaan'        => null,
                        'harga_dasar'           => $item['harga_dasar'],
                        'diskon'                => $item['diskon'] ?? 0,
                        'is_cito'               => 0,
                        'biaya_cito'            => 0,
                        'harga_akhir'           => $item['harga_akhir'],
                        'status_pemeriksaan'    => 'SELESAI',
                        'status_pembayaran'     => $statusPembayaran, // UPDATE
                        'waktu_bayar'           => $waktuLunas,       // UPDATE
                        'created_at'            => now(),
                        'updated_at'            => now(),
                    ]);
                    continue;
                }

                $isCitoItem = (isset($item['is_cito']) && ($item['is_cito'] == 1 || $item['is_cito'] === '1' || $item['is_cito'] === true)) ? 1 : 0;
                $biayaCitoItem = isset($item['biaya_cito']) ? (float) $item['biaya_cito'] : 0;

                if (!isset($item['id'])) {
                    continue;
                }

                $masterId = str_replace('tarif_', '', $item['id']);
                $master = DB::table('medical_master_pemeriksaan as mp')
                    ->leftJoin('medical_tipe_layanan as tl', 'mp.tipe_layanan_id', '=', 'tl.id')
                    ->select('mp.id', 'mp.nama_layanan', 'mp.is_paket', 'tl.prefix')
                    ->where('mp.id', $masterId)
                    ->first();

                if ($master) {
                    $prefix = strtoupper($master->prefix ?? 'ORD');

                    // Generate no pemeriksaan untuk item utama
                    $lastOrder = DB::table('medical_transaksi_detail')
                        ->where('no_pemeriksaan', 'like', "{$prefix}{$tanggalFormat}%")
                        ->orderBy('id', 'desc')
                        ->first();

                    $noUrutOrder = $lastOrder ? (int) substr($lastOrder->no_pemeriksaan, -4) + 1 : 1;
                    $noPemeriksaanBaru = $prefix . $tanggalFormat . str_pad($noUrutOrder, 4, '0', STR_PAD_LEFT);

                    // A. SIMPAN ITEM UTAMA
                    DB::table('medical_transaksi_detail')->insert([
                        'transaksi_id'          => $transaksiId,
                        'master_pemeriksaan_id' => $master->id,
                        'kategori_biaya'        => 'TINDAKAN',
                        'no_pemeriksaan'        => $noPemeriksaanBaru,
                        'harga_dasar'           => $item['harga_dasar'],
                        'diskon'                => $item['diskon'] ?? 0,
                        'is_cito'               => $isCitoItem,
                        'biaya_cito'            => $biayaCitoItem,
                        'harga_akhir'           => $item['harga_akhir'],
                        'status_pemeriksaan'    => 'MENUNGGU',
                        'status_pembayaran'     => $statusPembayaran, // UPDATE
                        'waktu_bayar'           => $waktuLunas,       // UPDATE
                        'created_at'            => now(),
                        'updated_at'            => now(),
                    ]);

                    // B. JIKA ITEM ADALAH PAKET: Simpan komponen di dalam paket
                    if ($master->is_paket == 1 || $master->is_paket == true) {
                        $subItems = DB::table('medical_paket_detail as pd')
                            ->join('medical_master_pemeriksaan as sub_mp', 'pd.pemeriksaan_id', '=', 'sub_mp.id')
                            ->leftJoin('medical_tipe_layanan as sub_tl', 'sub_mp.tipe_layanan_id', '=', 'sub_tl.id')
                            ->where('pd.paket_id', $master->id)
                            ->select('sub_mp.id as sub_id', 'sub_tl.prefix as sub_prefix')
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
                                'master_pemeriksaan_id' => $sub->sub_id,
                                'kategori_biaya'        => 'TINDAKAN',
                                'no_pemeriksaan'        => $noPemeriksaanSub,
                                'harga_dasar'           => 0,
                                'diskon'                => 0,
                                'is_cito'               => $isCitoItem,
                                'biaya_cito'            => 0,
                                'harga_akhir'           => 0,
                                'status_pemeriksaan'    => 'MENUNGGU',
                                'status_pembayaran'     => $statusPembayaran, // UPDATE
                                'waktu_bayar'           => $waktuLunas,       // UPDATE
                                'created_at'            => now(),
                                'updated_at'            => now(),
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success'       => true,
                'message'       => 'Registrasi dan transaksi berhasil disimpan!',
                'transaksi_id'  => $transaksiId,
                'no_registrasi' => $noRegistrasiBaru,
                'redirect_url'  => route('pembayaran.nota', $transaksiId)
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success'       => false,
                'message'       => 'Gagal memproses transaksi: ' . $e->getMessage()
            ], 500);
        }
    }
    public function prosesDanCetak_old(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required',
            'jenis_layanan' => 'required|string',
            'poli_id' => 'nullable|numeric',
            'ruangan_id' => 'nullable|numeric',   // <--- Validasi Ruangan Rawat Inap
            'bed_id' => 'nullable|numeric',       // <--- Validasi Bed Rawat Inap
            'doctor_id' => 'nullable|numeric',
            'doctor_poli_id' => 'nullable|numeric',
            'tanggal_periksa' => 'nullable|date',
            'items' => 'required|array',
            'total_tagihan' => 'required|numeric',
            'metode_bayar' => 'required|string',
            'bahasa_hasil' => 'nullable|array',
            'pengiriman' => 'nullable|array',
            'is_cito' => 'nullable'
        ]);

        try {
            DB::beginTransaction();

            $userId = Auth::user()->userid ?? 'SYSTEM';

            // 1. TANGKAP FLAG CITO GLOBAL
            $isCitoGlobal = $request->input('is_cito', 0);

            if ($isCitoGlobal == 0) {
                foreach ($request->items as $item) {
                    if (isset($item['is_cito']) && ($item['is_cito'] == 1 || $item['is_cito'] === '1' || $item['is_cito'] === true)) {
                        $isCitoGlobal = 1;
                        break;
                    }
                }
            }

            // 2. Generate No Registrasi Otomatis (Format: REG-YYYYMMDD-XXXX)
            $tanggalHariIni = date('Ymd');
            $lastReg = DB::table('medical_registrasi')
                ->where('no_registrasi', 'like', "REG-{$tanggalHariIni}-%")
                ->orderBy('id', 'desc')
                ->first();

            $noUrutReg = $lastReg ? (int) substr($lastReg->no_registrasi, -4) + 1 : 1;
            $noRegistrasiBaru = 'REG-' . $tanggalHariIni . '-' . str_pad($noUrutReg, 4, '0', STR_PAD_LEFT);

            // 3. Simpan data registrasi ke tabel `medical_registrasi` (Termasuk ruangan_id & bed_id)
            $registrasiId = DB::table('medical_registrasi')->insertGetId([
                'no_registrasi' => $noRegistrasiBaru,
                'pasien_id' => $request->pasien_id,
                'jenis_layanan' => $request->jenis_layanan,
                'poli_id' => $request->poli_id ?? null,
                'ruangan_id' => $request->ruangan_id ?? null,     // <--- Simpan Ruangan (Rawat Inap)
                'bed_id' => $request->bed_id ?? null,             // <--- Simpan Bed (Rawat Inap)
                'doctor_id' => $request->doctor_id ?? null,
                'doctor_poli_id' => $request->doctor_poli_id ?? null,
                'sub_penjamin_id' => $request->sub_penjamin_id ?? null,
                'tipe_fpp_id' => $request->tipe_fpp_id ?? null,
                'janji_hasil' => $request->tanggal_periksa ?? null,
                'keluhan_medis' => $request->keluhan_medis ?? null,

                'bahasa_hasil' => $request->has('bahasa_hasil') ? json_encode($request->bahasa_hasil) : null,
                'metode_pengiriman' => $request->has('pengiriman') ? json_encode($request->pengiriman) : null,

                'is_cito' => $isCitoGlobal,
                'user_id' => $userId,
                'tanggal_registrasi' => now(),
                'status_kunjungan' => 'MENUNGGU',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 3.1 Jika layanan RAWAT_INAP dan bed_id dipilih, update status bed menjadi TERISI
            if ($request->jenis_layanan === 'RAWAT_INAP' && $request->bed_id) {
                DB::table('medical_master_bed')
                    ->where('id', $request->bed_id)
                    ->update([
                        'status' => 'TERISI',
                        'updated_at' => now()
                    ]);
            }

            // 4. Logika Pembayaran (Piutang vs Lunas)
            $metodeBayar = strtoupper($request->metode_bayar);
            $totalTagihan = $request->total_tagihan;

            $totalBayar = ($metodeBayar === 'PIUTANG') ? 0 : $totalTagihan;
            $sisaTagihan = ($metodeBayar === 'PIUTANG') ? $totalTagihan : 0;
            $statusPembayaran = ($metodeBayar === 'PIUTANG') ? 'BELUM LUNAS' : 'LUNAS';

            $transaksiId = DB::table('medical_transaksi')->insertGetId([
                'registrasi_id'     => $registrasiId,
                'total_tagihan'     => $totalTagihan,
                'total_bayar'       => $totalBayar,
                'sisa_tagihan'      => $sisaTagihan,
                'metode_bayar'      => $metodeBayar,

                // --- TAMBAHKAN KOLOM BARU INI ---
                'edc_id'            => $request->edc_data['edc_id'] ?? null,       // ID Bank / Mesin EDC (jika metode EDC)
                'no_referensi'      => $request->edc_data['approval'] ?? $request->no_referensi ?? null, // No Approval EDC / VA / Ref QRIS
                // --------------------------------

                'status_pembayaran' => $statusPembayaran,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            // 5. Simpan detail item pemeriksaan (Termasuk komponen biaya kamar/inap otomatis)
            $tanggalFormat = date('dmy');

            foreach ($request->items as $item) {
                $kategoriBiaya = $item['kategori_biaya'] ?? 'TINDAKAN';

                // Menangani item administrasi, jasa dokter, kamar inap, atau keperawatan
                if (in_array($kategoriBiaya, ['ADMINISTRASI', 'JASA_DOKTER', 'KAMAR_INAP', 'KEPERAWATAN'])) {
                    DB::table('medical_transaksi_detail')->insert([
                        'transaksi_id' => $transaksiId,
                        'master_pemeriksaan_id' => null,
                        'kategori_biaya' => $kategoriBiaya,
                        'no_pemeriksaan' => null,
                        'harga_dasar' => $item['harga_dasar'],
                        'diskon' => $item['diskon'] ?? 0,
                        'is_cito' => 0,
                        'biaya_cito' => 0,
                        'harga_akhir' => $item['harga_akhir'],
                        'status_pemeriksaan' => 'SELESAI',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    continue;
                }

                $isCitoItem = (isset($item['is_cito']) && ($item['is_cito'] == 1 || $item['is_cito'] === '1' || $item['is_cito'] === true)) ? 1 : 0;
                $biayaCitoItem = isset($item['biaya_cito']) ? (float) $item['biaya_cito'] : 0;

                // Pastikan item memiliki ID master pemeriksaan yang valid
                if (!isset($item['id'])) {
                    continue;
                }

                $master = DB::table('medical_master_pemeriksaan as mp')
                    ->leftJoin('medical_tipe_layanan as tl', 'mp.tipe_layanan_id', '=', 'tl.id')
                    ->select('mp.id', 'mp.nama_layanan', 'mp.is_paket', 'tl.prefix')
                    ->where('mp.id', str_replace('tarif_', '', $item['id'])) // Mengantisipasi prefix string jika ada
                    ->first();

                if ($master && ($master->is_paket == 1 || $master->is_paket == true)) {
                    $subItems = DB::table('medical_paket_detail as pd')
                        ->join('medical_master_pemeriksaan as sub_mp', 'pd.pemeriksaan_id', '=', 'sub_mp.id')
                        ->leftJoin('medical_tipe_layanan as sub_tl', 'sub_mp.tipe_layanan_id', '=', 'sub_tl.id')
                        ->where('pd.paket_id', $master->id)
                        ->select('sub_mp.id as sub_id', 'sub_tl.prefix as sub_prefix')
                        ->get();

                    foreach ($subItems as $sub) {
                        $subPrefix = strtoupper($sub->sub_prefix ?? 'LAB');

                        $lastOrder = DB::table('medical_transaksi_detail')
                            ->where('no_pemeriksaan', 'like', "{$subPrefix}{$tanggalFormat}%")
                            ->orderBy('id', 'desc')
                            ->first();

                        $noUrutOrder = $lastOrder ? (int) substr($lastOrder->no_pemeriksaan, -4) + 1 : 1;
                        $noPemeriksaanSub = $subPrefix . $tanggalFormat . str_pad($noUrutOrder, 4, '0', STR_PAD_LEFT);

                        DB::table('medical_transaksi_detail')->insert([
                            'transaksi_id' => $transaksiId,
                            'master_pemeriksaan_id' => $sub->sub_id,
                            'kategori_biaya' => 'TINDAKAN',
                            'no_pemeriksaan' => $noPemeriksaanSub,
                            'harga_dasar' => 0,
                            'diskon' => 0,
                            'is_cito' => $isCitoItem,
                            'biaya_cito' => 0,
                            'harga_akhir' => 0,
                            'status_pemeriksaan' => 'MENUNGGU',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                } else if ($master) {
                    $prefix = strtoupper($master->prefix ?? 'ORD');

                    $lastOrder = DB::table('medical_transaksi_detail')
                        ->where('no_pemeriksaan', 'like', "{$prefix}{$tanggalFormat}%")
                        ->orderBy('id', 'desc')
                        ->first();

                    $noUrutOrder = $lastOrder ? (int) substr($lastOrder->no_pemeriksaan, -4) + 1 : 1;
                    $noPemeriksaanBaru = $prefix . $tanggalFormat . str_pad($noUrutOrder, 4, '0', STR_PAD_LEFT);

                    DB::table('medical_transaksi_detail')->insert([
                        'transaksi_id' => $transaksiId,
                        'master_pemeriksaan_id' => $master->id,
                        'kategori_biaya' => 'TINDAKAN',
                        'no_pemeriksaan' => $noPemeriksaanBaru,
                        'harga_dasar' => $item['harga_dasar'],
                        'diskon' => $item['diskon'] ?? 0,
                        'is_cito' => $isCitoItem,
                        'biaya_cito' => $biayaCitoItem,
                        'harga_akhir' => $item['harga_akhir'],
                        'status_pemeriksaan' => 'MENUNGGU',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registrasi dan transaksi berhasil disimpan!',
                'transaksi_id' => $transaksiId,
                'no_registrasi' => $noRegistrasiBaru,
                'redirect_url' => route('pembayaran.nota', $transaksiId)
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses transaksi: ' . $e->getMessage()
            ], 500);
        }
    }
    public function tampilkanNota($id)
    {
        $transaksi = DB::table('medical_transaksi as t')
            ->join('medical_registrasi as r', 't.registrasi_id', '=', 'r.id')
            ->join('medical_patient as p', 'r.pasien_id', '=', 'p.id')
            ->leftJoin('medical_master_poli as pol', 'r.poli_id', '=', 'pol.id')
            ->leftJoin('medical_master_doctor as doc_pengirim', 'r.doctor_id', '=', 'doc_pengirim.id')
            ->leftJoin('medical_master_doctor as doc_poli', 'r.doctor_poli_id', '=', 'doc_poli.id')
            ->where('t.id', $id)
            ->select(
                't.*',
                'r.no_registrasi',
                'r.tanggal_registrasi',
                'r.user_id',
                'r.jenis_layanan',
                'pol.nama_poli',
                'r.janji_hasil',
                'r.metode_pengiriman',
                'p.nama as nama_pasien',
                'p.pid',
                'p.umur',
                'p.jk',
                'p.alamat',
                'doc_pengirim.nama_lengkap as nama_dokter_pengirim',
                'doc_poli.nama_lengkap as nama_dokter_poli'
            )
            ->first();

        if (!$transaksi) {
            abort(404, 'Data transaksi tidak ditemukan.');
        }

        // Ambil langsung dari tabel detail karena baris paket dan komponennya sudah tersimpan berurutan
        $details = DB::table('medical_transaksi_detail as td')
            ->leftJoin('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->where('td.transaksi_id', $id)
            ->select(
                DB::raw('COALESCE(mp.nama_layanan, td.kategori_biaya) as nama_layanan'),
                'mp.is_paket',
                'td.harga_dasar',
                'td.diskon',
                'td.biaya_cito',
                'td.harga_akhir',
                'td.kategori_biaya'
            )
            ->get();

        return view('application.pelayanan.report.nota-print', compact('transaksi', 'details'));
    }
    public function getTarifOtomatis(Request $request)
    {
        try {
            $jenisLayanan  = $request->query('jenis_layanan'); // RAWAT_JALAN, IGD, RAWAT_INAP
            $poliId        = $request->query('poli_id');       // ID Poliklinik
            $ruanganId     = $request->query('ruangan_id');    // ID Ruangan (untuk Rawat Inap)
            $subPenjaminId = $request->query('sub_penjamin_id'); // ID Sub Penjamin / Cara Bayar

            // Validasi parameter wajib
            if (!$jenisLayanan || !$subPenjaminId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parameter jenis_layanan dan sub_penjamin_id wajib diisi.'
                ], 400);
            }

            // Jika Rawat Jalan, pastikan poli_id sudah dipilih
            if ($jenisLayanan === 'RAWAT_JALAN' && !$poliId) {
                return response()->json([
                    'success' => true,
                    'data'    => [] // Belum mengembalikan tarif jika poli belum dipilih
                ]);
            }

            // Jika Rawat Inap, pastikan ruangan_id sudah dipilih
            if ($jenisLayanan === 'RAWAT_INAP' && !$ruanganId) {
                return response()->json([
                    'success' => true,
                    'data'    => [] // Belum mengembalikan tarif jika ruangan belum dipilih
                ]);
            }

            // 1. RAWAT JALAN
            if ($jenisLayanan === 'RAWAT_JALAN') {
                $query = DB::table('medical_tarif_poli')
                    ->where('poli_id', $poliId)
                    ->where('is_active', 1);

                if ($subPenjaminId) {
                    // Perluasan kondisi filter, antisipasi jika sub_penjamin_id bernilai 0 atau string kosong
                    $query->where(function ($q) use ($subPenjaminId) {
                        $q->where('sub_penjamin_id', $subPenjaminId)
                            ->orWhereNull('sub_penjamin_id')
                            ->orWhere('sub_penjamin_id', 0)
                            ->orWhere('sub_penjamin_id', '');
                    });
                }

                $tarifList = $query->select(
                    'id',
                    'nama_tarif',
                    'tarif',
                    'kategori_biaya'
                )->get();

                // FALLBACK / DUMMY: Jika database kosong, beri nilai simulasi agar tabel HTML terisi
                if ($tarifList->isEmpty()) {
                    $tarifList = [
                        (object) ['id' => 901, 'nama_tarif' => 'Administrasi Pendaftaran Poli', 'tarif' => 15000, 'kategori_biaya' => 'ADMINISTRASI'],
                        (object) ['id' => 902, 'nama_tarif' => 'Jasa Pemeriksaan & Konsultasi Dokter', 'tarif' => 75000, 'kategori_biaya' => 'JASA_DOKTER']
                    ];
                }

                return response()->json([
                    'success' => true,
                    'data'    => $tarifList
                ]);
            }

            // 2. RAWAT INAP
            if ($jenisLayanan === 'RAWAT_INAP') {
                $ruangan = DB::table('medical_master_ruangan')->where('id', $ruanganId)->first();

                if (!$ruangan) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data ruangan tidak ditemukan.'
                    ], 404);
                }

                $tarifInap = DB::table('medical_tarif_rawatinap')
                    ->where('kelas', $ruangan->kelas)
                    ->where(function ($q) use ($subPenjaminId) {
                        $q->where('sub_penjamin_id', $subPenjaminId)
                            ->orWhereNull('sub_penjamin_id')
                            ->orWhere('sub_penjamin_id', 0);
                    })
                    ->where('is_active', 1)
                    ->first();

                $tarifList = [];

                if ($tarifInap) {
                    if ($tarifInap->tarif_kamar_per_hari > 0) {
                        $tarifList[] = (object) [
                            'id'             => 'inap_kamar_' . $tarifInap->id,
                            'nama_tarif'     => 'Akomodasi Kamar (' . $ruangan->nama_ruangan . ' - ' . $ruangan->kelas . ') / Hari',
                            'tarif'          => $tarifInap->tarif_kamar_per_hari,
                            'kategori_biaya' => 'KAMAR_INAP'
                        ];
                    }

                    if ($tarifInap->tarif_visite_dokter_per_hari > 0) {
                        $tarifList[] = (object) [
                            'id'             => 'inap_visite_' . $tarifInap->id,
                            'nama_tarif'     => 'Visite Dokter / Konsultasi Harian',
                            'tarif'          => $tarifInap->tarif_visite_dokter_per_hari,
                            'kategori_biaya' => 'JASA_DOKTER'
                        ];
                    }

                    if ($tarifInap->tarif_asuhan_keperawatan_per_hari > 0) {
                        $tarifList[] = (object) [
                            'id'             => 'inap_askep_' . $tarifInap->id,
                            'nama_tarif'     => 'Asuhan Keperawatan / Hari',
                            'tarif'          => $tarifInap->tarif_asuhan_keperawatan_per_hari,
                            'kategori_biaya' => 'KEPERAWATAN'
                        ];
                    }
                } else {
                    // FALLBACK / DUMMY RAWAT INAP
                    $tarifList = [
                        (object) ['id' => 'sim_1', 'nama_tarif' => 'Akomodasi Kamar (' . $ruangan->nama_ruangan . ') / Hari', 'tarif' => 250000, 'kategori_biaya' => 'KAMAR_INAP'],
                        (object) ['id' => 'sim_2', 'nama_tarif' => 'Visite Dokter Harian', 'tarif' => 100000, 'kategori_biaya' => 'JASA_DOKTER'],
                        (object) ['id' => 'sim_3', 'nama_tarif' => 'Asuhan Keperawatan / Hari', 'tarif' => 50000, 'kategori_biaya' => 'KEPERAWATAN'],
                    ];
                }

                return response()->json([
                    'success' => true,
                    'data'    => $tarifList
                ]);
            }

            // 3. IGD / GAWAT DARURAT (Otomatis memunculkan tarif dasar IGD)
            if ($jenisLayanan === 'IGD') {
                $tarifList = [
                    (object) ['id' => 991, 'nama_tarif' => 'Administrasi Gawat Darurat (IGD)', 'tarif' => 35000, 'kategori_biaya' => 'ADMINISTRASI'],
                    (object) ['id' => 992, 'nama_tarif' => 'Jasa Pemeriksaan Dokter Jaga', 'tarif' => 125000, 'kategori_biaya' => 'JASA_DOKTER'],
                    (object) ['id' => 993, 'nama_tarif' => 'Observasi IGD (< 6 Jam)', 'tarif' => 50000, 'kategori_biaya' => 'TINDAKAN']
                ];

                return response()->json([
                    'success' => true,
                    'data'    => $tarifList
                ]);
            }

            // Default kembalian jika tipe tidak dikenali
            return response()->json([
                'success' => true,
                'data'    => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getDokterBerjadwal(Request $request)
    {
        $poliId = $request->poli_id;
        $tanggal = $request->tanggal;

        // Ubah tanggal menjadi nama hari dalam bahasa Indonesia
        $dayOfWeek = date('w', strtotime($tanggal));
        $hariIndo = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $namaHari = $hariIndo[$dayOfWeek];

        // Ambil data dari tabel jadwal di-join dengan master dokter
        $jadwals = DB::table('medical_jadwal_dokter')
            ->join('medical_master_doctor', 'medical_master_doctor.id', '=', 'medical_jadwal_dokter.doctor_id')
            ->where('medical_jadwal_dokter.poli_id', $poliId)
            ->where('medical_jadwal_dokter.day_name', $namaHari)
            ->where('medical_jadwal_dokter.is_active', true)
            ->select(
                'medical_master_doctor.id as doctor_id',
                'medical_master_doctor.nama_lengkap', // <-- PERBAIKAN DI SINI
                'medical_jadwal_dokter.time_start',
                'medical_jadwal_dokter.time_end',
                'medical_jadwal_dokter.quota'
            )
            ->get();

        return response()->json([
            'success' => true,
            'data' => $jadwals,
            'hari' => $namaHari
        ]);
    }
    public function getDoctorsJson(Request $request)
    {
        $search = $request->query('q');

        $query = DB::table('medical_master_doctor')
            ->leftJoin('medical_master_spesialis', 'medical_master_doctor.kode_spesialis', '=', 'medical_master_spesialis.kode_spesialis')
            ->where('medical_master_doctor.is_active', 1);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('medical_master_doctor.nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('medical_master_doctor.kode_dokter', 'like', "%{$search}%")
                    ->orWhere('medical_master_spesialis.nama_spesialis', 'like', "%{$search}%");
            });
        }

        $doctors = $query->select(
            'medical_master_doctor.id',
            'medical_master_doctor.nama_lengkap',
            'medical_master_spesialis.nama_spesialis'
        )->limit(20)->get();

        $results = [];
        foreach ($doctors as $doc) {
            $results[] = [
                'id'   => $doc->id, // <--- ID angka dokter sebagai value
                'text' => $doc->nama_lengkap . ($doc->nama_spesialis ? ' - ' . $doc->nama_spesialis : '')
            ];
        }

        return response()->json([
            'results' => $results
        ]);
    }
    public function getPendaftaranHariIni(Request $request)
    {
        try {
            $data = DB::table('medical_registrasi')
                // 1. Join ke tabel Pasien untuk ambil Nama dan PID
                ->leftJoin('medical_patient', 'medical_registrasi.pasien_id', '=', 'medical_patient.id')

                // 2. Join ke tabel Poli untuk ambil Nama Poli
                ->leftJoin('medical_master_poli', 'medical_registrasi.poli_id', '=', 'medical_master_poli.id')

                // 3. Join ke tabel Transaksi untuk ambil Metode Bayar & Tagihan
                ->leftJoin('medical_transaksi', 'medical_transaksi.registrasi_id', '=', 'medical_registrasi.id')

                // Pilih kolom-kolom yang diperlukan untuk laporan di tabel
                ->select(
                    'medical_registrasi.id',
                    'medical_registrasi.tanggal_registrasi',
                    'medical_registrasi.jenis_layanan',
                    'medical_patient.nama as nama_pasien',
                    'medical_patient.pid',
                    'medical_master_poli.nama_poli',
                    'medical_transaksi.metode_bayar',
                    'medical_transaksi.total_tagihan'
                )
                // Filter hanya data hari ini
                ->whereDate('medical_registrasi.tanggal_registrasi', Carbon::today())

                // --- UPDATE DI SINI: Filter berdasarkan userid custom Anda ---
                ->where('medical_registrasi.user_id', (string) Auth::user()->userid)

                // Urutkan dari yang paling baru
                ->orderBy('medical_registrasi.tanggal_registrasi', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'waktu' => Carbon::parse($item->tanggal_registrasi)->format('H:i'),
                        'nama_pasien' => $item->nama_pasien ?? 'Pasien Umum',
                        'pid' => $item->pid ?? '-',
                        'layanan' => str_replace('_', ' ', $item->jenis_layanan),
                        'poli' => $item->nama_poli ?? '-',
                        'metode_bayar' => $item->metode_bayar ?? 'Belum Lunas',
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
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getBelumDilaporkan(Request $request)
    {
        try {
            $userId = (string) Auth::user()->userid;

            $data = DB::table('medical_registrasi')
                ->leftJoin('medical_patient', 'medical_registrasi.pasien_id', '=', 'medical_patient.id')
                ->leftJoin('medical_master_poli', 'medical_registrasi.poli_id', '=', 'medical_master_poli.id')
                ->leftJoin('medical_master_doctor', 'medical_registrasi.doctor_id', '=', 'medical_master_doctor.id')
                ->join('medical_transaksi', 'medical_transaksi.registrasi_id', '=', 'medical_registrasi.id') // Ubah ke join biasa agar wajib terikat transaksi
                // Filter berdasarkan petugas yang membuat transaksi awal di front office (dibuat_oleh)
                ->where('medical_transaksi.dibuat_oleh', $userId)
                // Hanya ambil transaksi yang status pembayarannya LUNAS (menyaring piutang / belum lunas)
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

    // 2. Proses simpan beberapa transaksi ke dalam 1 nota laporan keuangan
    public function storeLaporanKeuangan(Request $request)
    {
        DB::beginTransaction();
        try {
            $userId = (string) Auth::user()->userid;
            $transaksiIds = $request->input('transaksi_ids', []); // Array ID transaksi yang dipilih

            if (empty($transaksiIds)) {
                return response()->json(['success' => false, 'message' => 'Tidak ada transaksi yang dipilih untuk dilaporkan!'], 400);
            }

            // Validasi tambahan: Pastikan transaksi yang dipilih valid, milik kasir yang login, dan statusnya LUNAS
            $invalidTransaksi = DB::table('medical_transaksi')
                ->whereIn('id', $transaksiIds)
                ->where(function ($query) use ($userId) {
                    $query->where('dibuat_oleh', '!=', $userId)
                        ->orWhere('status_pembayaran', '!=', 'LUNAS');
                })
                ->exists();

            if ($invalidTransaksi) {
                return response()->json([
                    'success' => false,
                    'message' => 'Beberapa transaksi yang dipilih tidak valid, bukan milik Anda, atau belum lunas!'
                ], 400);
            }

            // Hitung total setoran dan jumlah transaksi
            $totalSetoran = DB::table('medical_transaksi')->whereIn('id', $transaksiIds)->sum('total_tagihan');
            $noLaporan = 'LAP-KSR-' . date('Ymd') . '-' . rand(1000, 9999);

            // 1. Simpan ke tabel master laporan keuangan
            $laporanId = DB::table('medical_laporan_keuangan')->insertGetId([
                'no_laporan'        => $noLaporan,
                'user_id'           => $userId, // ID Kasir yang membuat laporan
                'total_setoran'     => $totalSetoran,
                'jumlah_transaksi'  => count($transaksiIds),
                'status_verifikasi' => 'PENDING',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            // 2. Simpan detail transaksi ke dalam tabel pivot laporan keuangan
            $detailData = [];
            foreach ($transaksiIds as $txId) {
                $detailData[] = [
                    'laporan_id'   => $laporanId,
                    'transaksi_id' => $txId,
                ];
            }
            DB::table('medical_laporan_keuangan_detail')->insert($detailData);

            // 3. UPDATE TRANSAKSI TERKAIT: Set kolom dilunasi_oleh & waktu_lunas
            // Karena ini disetor oleh kasir front office yang melunasi di awal
            DB::table('medical_transaksi')
                ->whereIn('id', $transaksiIds)
                ->update([
                    'dilunasi_oleh' => $userId,
                    'waktu_lunas'   => now(),
                    'updated_at'    => now()
                ]);

            // 4. Simpan jejak audit (Log Trail) bahwa laporan ini baru saja DIBUAT oleh Front Office / Kasir
            DB::table('medical_laporan_keuangan_log')->insert([
                'laporan_id' => $laporanId,
                'user_id'    => $userId, // ID Kasir yang mengajukan
                'aksi'       => 'DIBUAT',
                'catatan'    => 'Laporan setoran harian kasir dibuat dan diajukan untuk diverifikasi.',
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
    // 1. Ambil daftar nota laporan yang pernah dibuat oleh user login
    public function getDaftarNota(Request $request)
    {
        try {
            $userId = (string) Auth::user()->userid;

            $data = DB::table('medical_laporan_keuangan')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // 2. Tampilkan halaman print nota setoran keuangan
    public function printSetoran($no_laporan)
    {
        // 1. Ambil ID user yang sedang login
        $userId = (string) Auth::user()->userid;

        // 2. Cari berdasarkan no_laporan DAN user_id
        $laporan = DB::table('medical_laporan_keuangan')
            ->where('no_laporan', $no_laporan)
            ->where('user_id', $userId)
            ->first();

        if (!$laporan) {
            abort(404, 'Nota laporan tidak ditemukan atau Anda tidak memiliki akses.');
        }

        // 3. Gunakan $laporan->id (Primary Key) untuk merelasikan ke tabel detail
        $details = DB::table('medical_laporan_keuangan_detail')
            ->join('medical_transaksi', 'medical_laporan_keuangan_detail.transaksi_id', '=', 'medical_transaksi.id')
            ->join('medical_registrasi', 'medical_transaksi.registrasi_id', '=', 'medical_registrasi.id')
            ->leftJoin('medical_patient', 'medical_registrasi.pasien_id', '=', 'medical_patient.id')
            ->leftJoin('medical_master_doctor', 'medical_registrasi.doctor_id', '=', 'medical_master_doctor.id')
            ->where('medical_laporan_keuangan_detail.laporan_id', $laporan->id)
            ->select(
                'medical_registrasi.no_registrasi',
                'medical_registrasi.tanggal_registrasi',
                'medical_registrasi.jenis_layanan',
                'medical_patient.nama as nama_pasien',
                'medical_patient.pid',
                'medical_master_doctor.nama_lengkap as nama_dokter',
                'medical_transaksi.metode_bayar',
                'medical_transaksi.total_tagihan'
            )
            ->get();

        return view('application.pelayanan.report.print-setoran-keuangan', compact('laporan', 'details'));
    }


    public function getBedTersedia($ruangan_id)
    {
        // Mengambil data bed berdasarkan ruangan_id dari tabel medical_master_bed
        $beds = DB::table('medical_master_bed')
            ->where('ruangan_id', $ruangan_id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $beds
        ]);
    }
    public function getDokterJagaIgd(Request $request)
    {
        $tanggal = $request->query('tanggal');

        $jadwal = DB::table('medical_jadwal_igd as j')
            ->join('medical_master_doctor as d', 'd.id', '=', 'j.doctor_id')
            ->where('j.tanggal', $tanggal)
            ->where('j.is_active', 1)
            ->select('j.doctor_id', 'd.nama_lengkap', 'j.shift', 'j.jam_mulai', 'j.jam_selesai')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $jadwal
        ]);
    }
    public function getListEdc()
    {
        $edcList = DB::table('medical_master_edc')
            ->where('is_active', 1)
            ->select('id', 'nama_bank', 'no_rekening', 'nama_pemilik')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $edcList
        ]);
    }
    public function getUtama(Request $request)
    {
        try {
            $data = DB::table('medical_penjamin')
                ->select('id', 'nama_penjamin')
                ->orderBy('nama_penjamin', 'ASC')
                ->get();

            return response()->json([
                'success' => true,
                'data'    => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data penjamin utama: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ambil data sub penjamin dari tabel medical_sub_penjamin berdasarkan penjamin_id
     */
    public function getSub(Request $request)
    {
        try {
            $penjaminId = $request->input('penjamin_id');

            if (!$penjaminId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parameter penjamin_id diperlukan.'
                ], 400);
            }

            $data = DB::table('medical_sub_penjamin')
                ->where('penjamin_id', $penjaminId)
                ->select('id', 'nama_sub_penjamin')
                ->orderBy('nama_sub_penjamin', 'ASC')
                ->get();

            return response()->json([
                'success' => true,
                'data'    => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data sub penjamin: ' . $e->getMessage()
            ], 500);
        }
    }
}
