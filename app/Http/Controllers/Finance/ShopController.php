<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    /**
     * Menampilkan E-Katalog Belanja Koperasi
     */
    public function index()
    {
        $produk = DB::table('kop_master_produk')->orderBy('nama_produk', 'asc')->get();
        $produk = collect($produk)->map(function ($item) {
            $item->url_gambar = $item->gambar_produk
                ? asset('storage/produk/' . $item->gambar_produk)
                : 'https://placehold.co/300x200?text=No+Image';
            return $item;
        });
        // 2. Ambil data anggota dari tabel kop_master_peserta untuk dropdown publik
        $peserta = DB::table('kop_master_peserta')
            ->select('id_kop_master_peserta', 'kop_master_peserta_nip', 'kop_master_peserta_name', 'kop_master_peserta_cabang')
            ->where('kop_master_peserta_status', 'AKTIF') // Hanya mengambil anggota dengan status Aktif
            ->orderBy('kop_master_peserta_name', 'asc')
            ->get();
        return view('app-koperasi.public.finance-shop-katalog', compact('produk', 'peserta'));
    }

    /**
     * Memproses Pengajuan Keranjang Belanja Anggota
     */
    public function prosesCheckout(Request $request)
    {
        // 1. Validasi input yang masuk
        $validator = Validator::make($request->all(), [
            'id_kop_master_peserta' => 'required',
            // Update validasi in: mengikuti pilihan metode pembayaran yang baru
            'metode_bayar'          => 'required|in:MASUK_TAGIHAN,TRANSFER_BANK,VIRTUAL_ACCOUNT',
            'security_code'         => 'required|digits:6',
            'cart'                  => 'required|array|min:1',
            'cart.*.id'             => 'required',
            'cart.*.qty'            => 'required|integer|min:1',
        ], [
            'id_kop_master_peserta.required' => 'Anggota koperasi belum dipilih.',
            'security_code.required'         => 'Kode keamanan wajib diisi.',
            'security_code.digits'           => 'Kode keamanan harus 6 digit angka.',
            'cart.required'                  => 'Keranjang belanja Anda masih kosong.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        // 2. Cek eksistensi Anggota & Validasi Security Code
        $peserta = DB::table('kop_master_peserta')
            ->where('id_kop_master_peserta', $request->id_kop_master_peserta)
            ->first();

        if (!$peserta) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data Anggota tidak ditemukan di sistem.'
            ], 404);
        }

        if ($peserta->kop_master_peserta_status !== 'AKTIF') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Status keanggotaan Anda tidak aktif. Transaksi ditolak.'
            ], 403);
        }

        if ($peserta->security_code !== $request->security_code) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kode Security Anggota yang Anda masukkan salah!'
            ], 403);
        }

        // 3. Mulai Database Transaction untuk keamanan multi-table & update stok
        DB::beginTransaction();
        try {
            $nota = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
            $totalTagihan = 0;
            $detailTransaksi = [];

            // Looping items di dalam keranjang belanja
            foreach ($request->cart as $item) {
                // Mengunci baris produk untuk menghindari race condition stok
                $produk = DB::table('kop_master_produk')
                    ->where('id_produk', $item['id'])
                    ->lockForUpdate()
                    ->first();

                if (!$produk) {
                    throw new Exception("Produk dengan ID {$item['id']} tidak ditemukan.");
                }

                if ($produk->stok_aktual < $item['qty']) {
                    throw new Exception("Stok untuk '{$produk->nama_produk}' tidak mencukupi.");
                }

                $subtotal = $produk->harga_jual_default * $item['qty'];
                $totalTagihan += $subtotal;

                // Potong stok aktual produk
                DB::table('kop_master_produk')
                    ->where('id_produk', $item['id'])
                    ->decrement('stok_aktual', $item['qty']);

                // Siapkan struktur data detail untuk batch insert nanti
                $detailTransaksi[] = [
                    'id_produk'    => $produk->id_produk,
                    'qty'          => $item['qty'],
                    'harga_satuan' => $produk->harga_jual_default,
                    'subtotal'     => $subtotal,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];
            }

            // 4. SIMPAN KE TABEL UTAMA (kop_trx_belanja)
            $idBelanja = DB::table('kop_trx_belanja')->insertGetId([
                'no_nota'               => $nota,
                'id_kop_master_peserta' => $request->id_kop_master_peserta,
                'total_harga'           => $totalTagihan,
                'metode_bayar'          => $request->metode_bayar,
                'status_transaksi'      => 'SUKSES', // Bisa disesuaikan 'PENDING' jika transfer manual belum dicek
                'created_at'            => now(),
                'updated_at'            => now(),
            ]);

            // 5. ISI ID_BELANJA KE DALAM STRUKTUR DETAIL & SIMPAN BATCH (kop_trx_belanja_detail)
            foreach ($detailTransaksi as &$detail) {
                $detail['id_belanja'] = $idBelanja;
            }

            DB::table('kop_trx_belanja_detail')->insert($detailTransaksi);

            // Jika semua proses aman, kunci perubahan di database
            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Transaksi belanja anggota berhasil diproses.',
                'nota'    => $nota
            ], 200);
        } catch (Exception $e) {
            // Gagalkan semua perubahan data (termasuk pengembalian stok produk) jika terjadi error di tengah jalan
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function history(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'id_kop_master_peserta' => 'required',
            'security_code'         => 'required|digits:6',
        ]);

        $idPeserta    = $request->id_kop_master_peserta;
        $securityCode = $request->security_code;

        // 2. Verifikasi Anggota & Security Code
        $anggota = DB::table('kop_master_peserta')
            ->where('id_kop_master_peserta', $idPeserta)
            ->first();

        if (!$anggota) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data anggota tidak ditemukan.'
            ], 404);
        }

        // Catatan keamaan: Jika password di-hash di DB, ganti ke: !Hash::check($securityCode, $anggota->security_code)
        if ($anggota->security_code !== $securityCode) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kode Security yang Anda masukkan salah. Akses ditolak!'
            ], 401);
        }

        // 3. Ambil Data Transaksi Berdasarkan Skema Tabel Anda
        // Di-join tepat ke tabel kop_master_produk untuk mengambil 'nama_produk'
        $riwayat = DB::table('kop_trx_belanja as b')
            ->join('kop_trx_belanja_detail as d', 'b.id_belanja', '=', 'd.id_belanja')
            ->join('kop_master_produk as p', 'd.id_produk', '=', 'p.id_produk')
            ->where('b.id_kop_master_peserta', $idPeserta)
            ->select([
                'b.no_nota',
                DB::raw("DATE_FORMAT(b.created_at, '%d-%m-%Y %H:%i') as tanggal"),
                'b.total_harga',
                // Hasil string gabungan, contoh: "2x Indomie Goreng, 1x Kopi Kapal Api"
                DB::raw("GROUP_CONCAT(CONCAT(d.qty, 'x ', p.nama_produk) SEPARATOR ', ') as rincian_barang")
            ])
            ->groupBy('b.id_belanja', 'b.no_nota', 'b.created_at', 'b.total_harga')
            ->orderBy('b.created_at', 'desc')
            ->get();

        // 4. Kirim Respons Balik ke AJAX di Frontend
        return response()->json([
            'status' => 'success',
            'data'   => $riwayat
        ], 200);
    }
}
