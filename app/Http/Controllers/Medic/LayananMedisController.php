<?php

namespace App\Http\Controllers\Medic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $request->validate([
            'pasien_id' => 'required',
            'items' => 'required|array',
            'total_tagihan' => 'required|numeric',
            'metode_bayar' => 'required|string',
            'bahasa_hasil' => 'nullable|array',
            'pengiriman' => 'nullable|array',
            'is_cito' => 'nullable' // Tambahkan penerimaan parameter is_cito
        ]);

        try {
            DB::beginTransaction();

            // Mengambil userid dari user yang sedang login
            $userId = Auth::user()->userid ?? 'SYSTEM';

            // 1. TANGKAP FLAG CITO GLOBAL LANGSUNG DARI PAYLOAD JAVASCRIPT
            $isCitoGlobal = $request->input('is_cito', 0);

            // Fallback (Pencegahan): Jika entah kenapa is_cito global bernilai 0,
            // periksa ulang ke dalam isi keranjang (items)
            if ($isCitoGlobal == 0) {
                foreach ($request->items as $item) {
                    // Pengecekan tipe data longgar untuk menampung format JSON string/boolean
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

            // 3. Simpan data kunjungan/registrasi ke tabel `medical_registrasi`
            $registrasiId = DB::table('medical_registrasi')->insertGetId([
                'no_registrasi' => $noRegistrasiBaru,
                'pasien_id' => $request->pasien_id,
                'sub_penjamin_id' => $request->sub_penjamin_id ?? null,
                'tipe_fpp_id' => $request->tipe_fpp_id ?? null,
                'dokter' => $request->dokter ?? null,
                'janji_hasil' => $request->janji_hasil ?? null,
                'keluhan_medis' => $request->keluhan_medis ?? null,

                'bahasa_hasil' => $request->has('bahasa_hasil') ? json_encode($request->bahasa_hasil) : null,
                'metode_pengiriman' => $request->has('pengiriman') ? json_encode($request->pengiriman) : null,

                'is_cito' => $isCitoGlobal, // <--- Data CITO masuk ke sini
                'user_id' => $userId,
                'tanggal_registrasi' => now(),
                'status_kunjungan' => 'MENUNGGU',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 4. Logika Pemisahan Piutang vs Lunas
            $metodeBayar = strtoupper($request->metode_bayar);
            $totalTagihan = $request->total_tagihan;

            $totalBayar = 0;
            $sisaTagihan = 0;
            $statusPembayaran = 'LUNAS';

            if ($metodeBayar === 'PIUTANG') {
                $totalBayar = 0;
                $sisaTagihan = $totalTagihan;
                $statusPembayaran = 'BELUM LUNAS';
            } else {
                $totalBayar = $totalTagihan;
                $sisaTagihan = 0;
                $statusPembayaran = 'LUNAS';
            }

            // Simpan ke tabel transaksi utama
            $transaksiId = DB::table('medical_transaksi')->insertGetId([
                'registrasi_id' => $registrasiId,
                'total_tagihan' => $totalTagihan,
                'total_bayar' => $totalBayar,
                'sisa_tagihan' => $sisaTagihan,
                'metode_bayar' => $metodeBayar,
                'status_pembayaran' => $statusPembayaran,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 5. Simpan detail item pemeriksaan ke tabel relasi transaksi detail
            $tanggalFormat = date('dmy'); // Format DDMMYY

            foreach ($request->items as $item) {
                // Menangkap data CITO dari request per item dengan tipe pengecekan longgar
                $isCitoItem = (isset($item['is_cito']) && ($item['is_cito'] == 1 || $item['is_cito'] === '1' || $item['is_cito'] === true)) ? 1 : 0;
                $biayaCitoItem = isset($item['biaya_cito']) ? (float) $item['biaya_cito'] : 0;

                // Ambil master pemeriksaan dan cek apakah ini paket
                $master = DB::table('medical_master_pemeriksaan as mp')
                    ->leftJoin('medical_tipe_layanan as tl', 'mp.tipe_layanan_id', '=', 'tl.id')
                    ->select('mp.id', 'mp.nama_layanan', 'mp.is_paket', 'tl.prefix')
                    ->where('mp.id', $item['id'])
                    ->first();

                // Cek apakah item ini adalah paket (is_paket == 1)
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
                            'no_pemeriksaan' => $noPemeriksaanSub,
                            'harga_dasar' => 0,
                            'diskon' => 0,
                            'is_cito' => $isCitoItem, // <--- Penanda CITO turun ke sub-item
                            'biaya_cito' => 0,
                            'harga_akhir' => 0,
                            'status_pemeriksaan' => 'MENUNGGU',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                } else {
                    // Jika BUKAN paket (item satuan biasa)
                    $prefix = strtoupper($master->prefix ?? 'ORD');

                    $lastOrder = DB::table('medical_transaksi_detail')
                        ->where('no_pemeriksaan', 'like', "{$prefix}{$tanggalFormat}%")
                        ->orderBy('id', 'desc')
                        ->first();

                    $noUrutOrder = $lastOrder ? (int) substr($lastOrder->no_pemeriksaan, -4) + 1 : 1;
                    $noPemeriksaanBaru = $prefix . $tanggalFormat . str_pad($noUrutOrder, 4, '0', STR_PAD_LEFT);

                    DB::table('medical_transaksi_detail')->insert([
                        'transaksi_id' => $transaksiId,
                        'master_pemeriksaan_id' => $item['id'],
                        'no_pemeriksaan' => $noPemeriksaanBaru,
                        'harga_dasar' => $item['harga_dasar'],
                        'diskon' => $item['diskon'] ?? 0,
                        'is_cito' => $isCitoItem,  // <--- Penanda CITO tersimpan
                        'biaya_cito' => $biayaCitoItem, // <--- Nominal biaya CITO tersimpan
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
        // Ambil data transaksi di-join dengan registrasi dan pasien
        $transaksi = DB::table('medical_transaksi as t')
            ->join('medical_registrasi as r', 't.registrasi_id', '=', 'r.id')
            ->join('medical_patient as p', 'r.pasien_id', '=', 'p.id')
            ->where('t.id', $id)
            ->select(
                't.*',
                'r.no_registrasi',
                'r.tanggal_registrasi',
                'r.user_id',
                'r.dokter',
                'r.janji_hasil',
                'r.metode_pengiriman',
                'p.nama as nama_pasien',
                'p.pid',
                'p.umur',
                'p.jk',
                'p.alamat'
            )
            ->first();

        if (!$transaksi) {
            abort(404, 'Data transaksi tidak ditemukan.');
        }

        // Ambil rincian item pemeriksaan, tambahkan biaya cito
        $details = DB::table('medical_transaksi_detail as td')
            ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->where('td.transaksi_id', $id)
            ->select('mp.nama_layanan', 'td.harga_dasar', 'td.diskon', 'td.biaya_cito', 'td.harga_akhir')
            ->get();

        return view('application.pelayanan.report.nota-print', compact('transaksi', 'details'));
    }
}
