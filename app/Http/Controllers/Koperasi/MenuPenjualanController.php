<?php

namespace App\Http\Controllers\Koperasi;

use App\Http\Controllers\Controller;
use App\Services\AccountingService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class MenuPenjualanController extends Controller
{
    protected $accountingService;
    public function __construct(AccountingService $accountingService)
    {
        $this->middleware('auth');
        $this->accountingService = $accountingService;
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
    public function stup_no_wa($number)
    {
        $nomorhp = $number;
        //Terlebih dahulu kita trim dl
        $nomorhp = trim($nomorhp);
        //bersihkan dari karakter yang tidak perlu
        $nomorhp = strip_tags($nomorhp);
        // Berishkan dari spasi
        $nomorhp = str_replace(" ", "", $nomorhp);
        // Berishkan dari -
        $nomorhp = str_replace("-", "", $nomorhp);
        // bersihkan dari bentuk seperti  (022) 66677788
        $nomorhp = str_replace("(", "", $nomorhp);
        // bersihkan dari format yang ada titik seperti 0811.222.333.4
        $nomorhp = str_replace(".", "", $nomorhp);

        if (!preg_match('/[^+0-9]/', trim($nomorhp))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($nomorhp), 0, 3) == '+62') {
                $nomorhp = trim($nomorhp);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif (substr($nomorhp, 0, 1) == '0') {
                $nomorhp = '+62' . substr($nomorhp, 1);
            }
        }
        return $nomorhp;
    }
    // MENU PENJUALAN PRODUCT
    public function menu_koperasi_penjualan_product_koperasi(Request $request, $akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // $bankCoa = DB::table('kop_fin_master_coa')->where('is_active', true)->where('coa_code', 'LIKE', '11%')->get();

            // $listNota = DB::table('kop_trx_pembelian_anggota as pa')
            //     ->join('kop_master_peserta as p', 'pa.anggota_id', '=', 'p.id_kop_master_peserta')
            //     ->where('pa.status_tagihan', 'BELUM_LUNAS')
            //     ->select('pa.id_pembelian', 'pa.nota_nomor', 'p.kop_master_peserta_name')
            //     ->get();
            // Mengambil data produk untuk ditampilkan di tabel dan dropdown opsi restock
            $produk = DB::table('kop_master_produk')->orderBy('created_at', 'desc')->get();
            // return view('finance.produk-dan-stok', compact('produk'));
            return view('app-koperasi.menu-penjualan.menu-create-product', compact('produk'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_penjualan_product_koperasi_get_data()
    {
        $produk = DB::table('kop_master_produk')->orderBy('nama_produk', 'asc')->get();

        // Format asset URL untuk gambar
        $produk = collect($produk)->map(function ($item) {
            $item->url_gambar = $item->gambar_produk
                ? asset('storage/produk/' . $item->gambar_produk)
                : 'https://placehold.co/50x50?text=No+Image';
            return $item;
        });

        return response()->json(['status' => 'success', 'data' => $produk]);
    }
    public function menu_koperasi_penjualan_product_koperasi_save_master(Request $request)
    {
        // 1. Tambahkan validasi gambar (maksimal 2MB, format jpg/jpeg/png)
        $validator = Validator::make($request->all(), [
            'nama_produk'   => 'required|string|max:255',
            'kategori'      => 'required|string',
            'satuan'        => 'required|string',
            'harga_beli'    => 'required|numeric|min:0',
            'harga_jual'    => 'required|numeric|min:0',
            'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }

        try {
            $kodeProduk = 'PRD-' . strtoupper(substr(md5(uniqid()), 0, 6));
            $namaGambar = null;

            // 2. Proses upload gambar jika ada berkas yang dikirim
            if ($request->hasFile('gambar_produk')) {
                $file = $request->file('gambar_produk');
                $namaGambar = $kodeProduk . '_' . time() . '.' . $file->getClientOriginalExtension();
                // Menyimpan ke folder storage/app/public/produk (Pastikan sudah menjalankan `php artisan storage:link`)
                $file->storeAs('public/produk', $namaGambar);
            }

            DB::table('kop_master_produk')->insert([
                'kode_produk'        => $kodeProduk,
                'nama_produk'        => $request->nama_produk,
                'gambar_produk'      => $namaGambar, // Simpan nama file ke database
                'kategori'           => $request->kategori,
                'satuan'             => $request->satuan,
                'harga_beli_default' => $request->harga_beli,
                'harga_jual_default' => $request->harga_jual,
                'stok_aktual'        => 0,
                'created_at'         => now(),
                'updated_at'         => now()
            ]);

            return response()->json(['status' => 'success', 'message' => 'Master produk baru beserta gambar berhasil didaftarkan.']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }
    public function menu_koperasi_penjualan_product_koperasi_save_stok(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produk_id'     => 'required|integer',
            'jumlah_masuk'  => 'required|integer|min:1',
            'harga_beli'    => 'required|numeric|min:0',
            'tanggal_masuk' => 'required|date',
            'keterangan'    => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }

        DB::beginTransaction();
        try {
            // 1. Catat log histori barang masuk
            DB::table('kop_trx_produk_stok_masuk')->insert([
                'produk_id'         => $request->produk_id,
                'jumlah_masuk'      => $request->jumlah_masuk,
                'harga_beli_satuan' => $request->harga_beli,
                'tanggal_masuk'     => $request->tanggal_masuk,
                'keterangan'        => $request->keterangan,
                'created_at'        => now(),
                'updated_at'        => now()
            ]);

            // 2. Naikkan akumulasi akumulatif stok_aktual di master barang
            DB::table('kop_master_produk')
                ->where('id_produk', $request->produk_id)
                ->increment('stok_aktual', $request->jumlah_masuk);

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Stok produk berhasil diperbarui/ditambahkan.']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Gagal input stok: ' . $e->getMessage()], 500);
        }
    }
    // MENU PENJUALAN PRODUCT
    public function menu_koperasi_penagihan_belanja_koperasi(Request $request, $akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $daftarCabang = DB::table('kop_master_peserta')
                ->whereNotNull('kop_master_peserta_cabang')
                ->distinct()
                ->pluck('kop_master_peserta_cabang');
            return view('app-koperasi.menu-penjualan.menu-penagihan-belanja-anggota', compact('daftarCabang'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_penagihan_belanja_koperasi_tagih(Request $request)
    {
        $request->validate([
            'cabang' => 'required|string'
        ]);

        $cabangTerpilih = $request->cabang;

        // Query mengelompokkan total tagihan per anggota di cabang tersebut
        $dataTagihan = DB::table('kop_master_peserta as p')
            ->join('kop_trx_belanja as b', 'p.id_kop_master_peserta', '=', 'b.id_kop_master_peserta')
            ->where('p.kop_master_peserta_cabang', $cabangTerpilih)
            ->where('b.metode_bayar', 'MASUK_TAGIHAN')
            ->where('b.status_transaksi', 'SUKSES') // Hanya transaksi sukses yang ditagih
            ->select([
                'p.id_kop_master_peserta',
                'p.kop_master_peserta_nip as nip',
                'p.kop_master_peserta_name as nama_anggota',
                'p.kop_master_peserta_cabang as cabang',
                DB::raw('COUNT(b.id_belanja) as total_transaksi'),
                DB::raw('SUM(b.total_harga) as total_tagihan')
            ])
            ->groupBy('p.id_kop_master_peserta', 'p.kop_master_peserta_nip', 'p.kop_master_peserta_name', 'p.kop_master_peserta_cabang')
            ->orderBy('p.kop_master_peserta_name', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'cabang' => $cabangTerpilih,
            'data'   => $dataTagihan
        ], 200);
    }
}
