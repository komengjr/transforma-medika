<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ShopController extends Controller
{
    /**
     * Menampilkan E-Katalog Belanja Koperasi
     */
    public function index()
    {
        // Mengambil semua produk terdaftar
        $produk = DB::table('kop_master_produk')->orderBy('nama_produk', 'asc')->get();

        // Format URL Gambar Ritel
        $produk = collect($produk)->map(function ($item) {
            $item->url_gambar = $item->gambar_produk
                ? asset('storage/produk/' . $item->gambar_produk)
                : 'https://placehold.co/300x200?text=No+Image';
            return $item;
        });

        return view('finance.shop-katalog', compact('produk'));
    }

    /**
     * Memproses Pengajuan Keranjang Belanja Anggota
     */
    public function prosesCheckout(Request $request)
    {
        $cart = $request->input('cart');
        if (empty($cart)) {
            return response()->json(['status' => 'error', 'message' => 'Keranjang belanja Anda kosong.'], 422);
        }

        DB::beginTransaction();
        try {
            // Simulasi dummy ID Anggota (sesuaikan dengan Auth::user jika sudah terintegrasi)
            $anggotaId = 1;

            // Generate Nomor Nota Pembelian Unik
            $notaNomor = 'PBI-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

            $totalPiutang = 0;
            $totalHargaBeliPokok = 0;

            foreach ($cart as $item) {
                // Ambil info produk asli di DB untuk mencegah manipulasi harga dari client-side
                $prod = DB::table('kop_master_produk')->where('id_produk', $item['id'])->first();

                if (!$prod || $prod->stok_aktual < $item['qty']) {
                    throw new Exception("Stok produk '{$item['nama']}' tidak mencukupi atau tidak ditemukan.");
                }

                // Kalkulasi Finansial
                $subtotalJual = $prod->harga_jual_default * $item['qty'];
                $subtotalBeli = $prod->harga_beli_default * $item['qty'];

                $totalPiutang += $subtotalJual;
                $totalHargaBeliPokok += $subtotalBeli;

                // Kurangi stok produk langsung di master barang
                DB::table('kop_master_produk')
                    ->where('id_produk', $item['id'])
                    ->decrement('stok_aktual', $item['qty']);
            }

            // Margin Koperasi diperoleh dari selisih harga jual dan harga beli pokok
            $marginKoperasi = $totalPiutang - $totalHargaBeliPokok;
            $tenorBulan = 12; // Default contoh tenor cicilan koperasi 12 bulan
            $cicilanPerBulan = ceil($totalPiutang / $tenorBulan);

            // Masukkan data pengajuan transaksi utama ke tabel pembelian (Modul 3 sebelumnya)
            // agar nantinya bisa divalidasi manual lewat input Nota oleh Ketua Koperasi
            $idPembelian = DB::table('kop_trx_pembelian_anggota')->insertGetId([
                'nota_nomor'         => $notaNomor,
                'anggota_id'         => $anggotaId,
                'barang_nama'        => count($cart) . " Macam Item Barang Koperasi",
                'harga_beli'         => $totalHargaBeliPokok,
                'margin_koperasi'    => $marginKoperasi,
                'total_piutang'      => $totalPiutang,
                'tenor_bulan'        => $tenorBulan,
                'cicilan_per_bulan'  => $cicilanPerBulan,
                'status_persetujuan' => 'PENDING',
                'tanggal_transaksi'  => now(),
                'created_at'         => now(),
                'updated_at'         => now()
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Pesanan berhasil dibuat! Silakan infokan nomor nota berikut ke Ketua untuk validasi.',
                'nota' => $notaNomor
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
