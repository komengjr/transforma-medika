<?php

namespace App\Http\Controllers\Koperasi;

use App\Http\Controllers\Controller;
use App\Imports\Koperasi\PesertaImport;
use App\Models\KopArisanGroup;
use App\Models\Koperasi\Cabang;
use App\Models\Koperasi\Tagihan;
use App\Models\KopJadwalArisan;
use App\Models\KopMasterArisan;
use App\Models\KopMasterPeserta;
use App\Models\KopPencairanArisan;
use App\Models\KopProsesPeminjamanBrg;
use App\Models\KopProsesPeminjamanUang;
use App\Models\KopTagihanBulan;
use App\Models\KopTransaksiArisan;
use App\Models\KopVocherData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Currency;
use PhpParser\Node\Stmt\TryCatch;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\AccountingService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class KoperasiController extends Controller
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
    // MASTER REGISTRASI PESERTA
    public function menu_koperasi_registrasi_peserta($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $cabang = DB::table('kop_master_cabang')->get();
            $divisi = DB::table('kop_master_div_bag')->join('kop_master_divisi', 'kop_master_divisi.kop_master_divisi_code', '=', 'kop_master_div_bag.kop_master_divisi_code')->get();
            $pokok = DB::table('kop_simpanan_pokok')->get();
            $wajib = DB::table('kop_simpanan_wajib')->get();
            return view('app-koperasi.registrasi-peserta-koperasi', compact('cabang', 'divisi', 'pokok', 'wajib'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_registrasi_peserta_add(Request $request)
    {
        try {
            $total = DB::table('kop_master_peserta')->count();
            $code = 'P' . str_pad($total + 1, 10, '0', STR_PAD_LEFT);
            DB::table('kop_master_peserta_job')->insert([
                'kop_master_peserta_job_code' => str::uuid(),
                'kop_master_peserta_code' => $code,
                'kop_master_div_bag_code' => $request->divisi,
                'kop_master_peserta_job_status' => 1,
                'created_at' => now()
            ]);
            DB::table('kop_master_peserta')->insert([
                'kop_master_peserta_code' => $code,
                'kop_master_peserta_nik' => $request->nik,
                'kop_master_peserta_nip' => $request->nip,
                'kop_master_peserta_name' => $request->nama_lengkap,
                'kop_master_peserta_tgl_lahir' => $request->tgl_lahir,
                'kop_master_peserta_tempat_lahir' => $request->tempat_lahir,
                'kop_master_peserta_jk' => $request->jenis_kelamin,
                'kop_master_peserta_agama' => $request->agama,
                'kop_master_peserta_alamat' => $request->alamat,
                'kop_master_peserta_cabang' => $request->cabang,
                'kop_master_peserta_email' => $request->email,
                'kop_master_peserta_no_hp' => $request->no_hp,
                'kop_master_peserta_tgl_kerja' => $request->tgl_masuk,
                'kop_master_peserta_tgl_anggota' => now(),
                'kop_master_peserta_photo' => "",
                'kop_master_peserta_status' => 1,
                'created_at' => now()
            ]);
            DB::table('kop_peserta_sim_pok')->insert([
                'kop_peserta_sim_pok_code' => str::uuid(),
                'kop_master_peserta_code' => $code,
                'kop_simpanan_pokok_code' => $request->simpanan_pokok,
                'kop_peserta_sim_pok_date' => now(),
                'kop_peserta_sim_pok_status' => '1',
                'created_at' => now()
            ]);
            DB::table('kop_peserta_sim_jib')->insert([
                'kop_peserta_sim_jib_code' => str::uuid(),
                'kop_master_peserta_code' => $code,
                'kop_simpanan_wajib_code' => $request->simpanan_wajib,
                'kop_peserta_sim_jib_date' => now(),
                'kop_peserta_sim_jib_status' => '1',
                'created_at' => now()
            ]);

            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    // MENU SIMPANAN POKOK
    public function menu_koperasi_simpanan_pokok($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $list_cabang = DB::table('kop_master_peserta')
                ->select('kop_master_peserta_cabang')
                ->distinct()
                ->whereNotNull('kop_master_peserta_cabang')
                ->pluck('kop_master_peserta_cabang');

            // Ambil COA Pembayaran (Aset) langsung menggunakan Query Builder
            $coa_pembayaran = DB::table('kop_fin_master_coa')
                ->where('is_active', 1)
                ->where('coa_type', 'aset')
                ->orderBy('coa_code', 'asc')
                ->get();

            // Ambil COA Simpanan (Kewajiban & Ekuitas)
            $coa_simpanan = DB::table('kop_fin_master_coa')
                ->where('is_active', 1)
                // ->whereIn('coa_type', ['kewajiban', 'ekuitas'])
                ->orderBy('coa_code', 'asc')
                ->get();

            $nominal_simpanan_pokok = 100000;
            return view('app-koperasi.menu-simpanan.menu-simpanan-pokok', compact(
                'list_cabang',
                'coa_pembayaran',
                'coa_simpanan',
                'nominal_simpanan_pokok'
            ), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_simpanan_pokok_get_data(Request $request)
    {
        $cabang = $request->query('cabang');

        if (!$cabang) {
            return response()->json(['data' => []], 400);
        }

        $anggota = KopMasterPeserta::where('kop_master_peserta_cabang', $cabang)
            ->orderBy('kop_master_peserta_name', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $anggota
        ]);
    }
    public function menu_koperasi_simpanan_pokok_bayar(Request $request, $id)
    {
        // Validasi input pilihan COA dari modal
        $request->validate([
            'coa_pembayaran' => 'required|string',
            'coa_simpanan'   => 'required|string',
        ]);

        $peserta = KopMasterPeserta::findOrFail($id);

        // 1. Ambil kode COA terpilih untuk kebutuhan integrasi jurnal akuntansi
        $coaDebit  = $request->coa_pembayaran; // E.g., '1101' (Kas)
        $coaKredit = $request->coa_simpanan;   // E.g., '3101' (Simpanan Pokok)


        $headerJurnal = [
            'jurnal_tgl' => now()->format('Y-m-d'),
            'jurnal_keterangan' => "Simpanan Pokok.  an. " . $peserta->kop_master_peserta_name . " ( " . $peserta->kop_master_peserta_nip . " ) ",
            'jurnal_ref_table' => 'simpanan_pokok',
            'jurnal_ref_code' => $peserta->kop_master_peserta_code,
            'jurnal_user' => $peserta->kop_master_peserta_code,
            'jurnal_cabang' => $peserta->kop_master_peserta_cabang,
        ];

        $detailJurnal = [
            ['coa_code' => $coaDebit, 'jurnal_debit' => $request->nominal_pokok, 'jurnal_kredit' => 0], // Piutang Anggota
            ['coa_code' => $coaKredit, 'jurnal_debit' => 0, 'jurnal_kredit' => $request->nominal_pokok],    // Kas/Bank Koperasi
        ];

        // Aturan Akuntansi: Debit (Piutang), Kredit (Pendapatan Admin & Kas)

        // 3. Eksekusi Jurnal
        $this->accountingService->createJournal($headerJurnal, $detailJurnal);

        // 2. Update status keanggotaan
        if ($peserta->kop_master_peserta_tgl_anggota == "") {
            $peserta->update([
                'kop_master_peserta_status' => 'AKTIF',
                'kop_master_peserta_tgl_anggota' => Carbon::now()->format('Y-m-d')
            ]);
        } else {
            $peserta->update([
                'kop_master_peserta_status' => 'AKTIF',
            ]);
        }

        // Redirect kembali dengan membawa parameter cabang agar tabel otomatis ter-filter lagi setelah reload
        return redirect()->back()->with('success', 'Simpanan pokok untuk ' . $peserta->kop_master_peserta_name . ' berhasil diproses menggunakan COA terpilih!');
    }
    // MENU SIMPANAN WAJIB
    public function menu_koperasi_simpanan_wajib_koperasi($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Ambil list cabang dari master peserta
            $list_cabang = DB::table('kop_master_peserta')
                ->select('kop_master_peserta_cabang')
                ->distinct()
                ->whereNotNull('kop_master_peserta_cabang')
                ->pluck('kop_master_peserta_cabang');

            // Ambil COA Pembayaran (Aset)
            $coa_pembayaran = DB::table('kop_fin_master_coa')
                ->where('is_active', true)
                ->where('coa_type', 'aset')
                ->orderBy('coa_code', 'asc')
                ->get();

            // Ambil COA Simpanan Wajib (Kewajiban / Ekuitas)
            $coa_simpanan = DB::table('kop_fin_master_coa')
                ->where('is_active', true)
                // ->whereIn('coa_type', ['kewajiban', 'ekuitas'])
                ->orderBy('coa_code', 'asc')
                ->get();
            $nominal_wajib = 50000;
            return view('app-koperasi.menu-simpanan.menu-simpanan-wajib', compact(
                'list_cabang',
                'coa_pembayaran',
                'coa_simpanan',
                'nominal_wajib'
            ), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_simpanan_wajib_get_data(Request $request)
    {
        $cabang = $request->query('cabang');
        $bulanIni = Carbon::now()->format('Y-m'); // Output: 2026-07

        if (!$cabang) return response()->json(['data' => []], 400);

        // Ambil data anggota aktif
        $anggota = DB::table('kop_master_peserta')
            ->where('kop_master_peserta_cabang', $cabang)
            ->where('kop_master_peserta_status', 'AKTIF')
            ->orderBy('kop_master_peserta_name', 'asc')
            ->get();

        // Cari tahu siapa saja yang SUDAH bayar bulan ini di tabel histori
        $sudahBayarIds = DB::table('kop_simpanan_wajib_histori')
            ->where('periode_bulan', $bulanIni)
            ->pluck('id_kop_master_peserta')
            ->toArray();

        // Petakan status ke dalam data anggota
        $dataMapped = $anggota->map(function ($item) use ($sudahBayarIds) {
            $item->sudah_bayar = in_array($item->id_kop_master_peserta, $sudahBayarIds);
            return $item;
        });

        return response()->json([
            'status' => 'success',
            'data'   => $dataMapped
        ]);
    }
    public function menu_koperasi_simpanan_wajib_bayar(Request $request)
    {
        $request->validate([
            'cabang_terpilih' => 'required|string',
            'ids_anggota'     => 'required|array|min:1',
            'coa_pembayaran'  => 'required|string',
            'coa_simpanan'    => 'required|string',
            'nominal_wajib'   => 'required|numeric'
        ]);

        $ids = $request->ids_anggota;
        $nominalPerAnggota = $request->nominal_wajib;
        $totalNominal = $nominalPerAnggota * count($ids);
        $bulanIni = Carbon::now()->format('Y-m');

        // --- TAMBAHAN: Ambil nama-nama anggota untuk keterangan jurnal ---
        $daftarNama = DB::table('kop_master_peserta')
            ->whereIn('id_kop_master_peserta', $ids)
            ->pluck('kop_master_peserta_name')
            ->toArray();

        // Gabungkan nama anggota dipisahkan dengan koma (Contoh: "Budi, Andi, Siti")
        $keteranganNama = implode(', ', $daftarNama);

        // Batasi panjang string jika daftar namanya terlalu panjang agar tidak error di DB (max 65.000 karakter untuk TEXT atau 255 untuk VARCHAR)
        // Di sini kita potong aman di 500 karakter jika datanya masal sekali, atau sesuaikan dengan tipe data kolom Anda
        $keteranganNama = strlen($keteranganNama) > 500 ? substr($keteranganNama, 0, 500) . '...dst' : $keteranganNama;
        // -----------------------------------------------------------------

        DB::beginTransaction();
        try {
            // 1. Generate Nomor Jurnal
            $currentMonth = Carbon::now()->format('Ym');
            $prefix = "JVW-" . $currentMonth . "-";

            $lastJurnal = DB::table('kop_fin_jurnal')
                ->where('jurnal_no_bukti', 'like', $prefix . '%')
                ->orderBy('id_jurnal', 'desc')
                ->first();

            $nextNumber = $lastJurnal ? str_pad(((int) substr($lastJurnal->jurnal_no_bukti, -4)) + 1, 4, '0', STR_PAD_LEFT) : "0001";
            $noBukti = 'JV-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
            $userLogin = Auth::user()->name ?? 'Admin Koperasi';

            // 2. Insert Header Jurnal (Keterangan diperbarui dengan total & daftar nama)
            $jurnalId = DB::table('kop_fin_jurnal')->insertGetId([
                'jurnal_no_bukti'   => $noBukti,
                'jurnal_tgl'        => Carbon::now()->format('Y-m-d'),
                // Tampilan Keterangan: Simpanan Wajib Massal Juli 2026 - Cabang: PUSAT (3 Anggota: Budi, Andi, Siti)
                'jurnal_keterangan' => "Simpanan Wajib Massal " . Carbon::now()->translatedFormat('F Y') .
                    " - Cabang: " . strtoupper($request->cabang_terpilih) .
                    " (" . count($ids) . " Anggota: " . $keteranganNama . ")",
                'jurnal_ref_table'  => 'kop_master_peserta_massal',
                'jurnal_ref_code'   => $request->cabang_terpihal . '-' . $currentMonth,
                'jurnal_user'       => $userLogin,
                'jurnal_cabang'     => $request->cabang_terpilih,
                'jurnal_created'    => $userLogin,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);

            // 3. Insert Detail Jurnal (Debit & Kredit)
            DB::table('kop_fin_jurnal_detail')->insert([
                ['jurnal_id' => $jurnalId, 'coa_code' => $request->coa_pembayaran, 'jurnal_debit' => $totalNominal, 'jurnal_kredit' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['jurnal_id' => $jurnalId, 'coa_code' => $request->coa_simpanan, 'jurnal_debit' => 0, 'jurnal_kredit' => $totalNominal, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            ]);

            // 4. LOOPING: Catat ke tabel histori per Anggota
            $insertHistori = [];
            foreach ($ids as $idAnggota) {
                $insertHistori[] = [
                    'id_kop_master_peserta' => $idAnggota,
                    'id_jurnal'             => $jurnalId,
                    'periode_bulan'         => $bulanIni,
                    'tgl_bayar'             => Carbon::now()->format('Y-m-d'),
                    'nominal'               => $nominalPerAnggota,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now()
                ];
            }
            DB::table('kop_simpanan_wajib_histori')->insert($insertHistori);

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil memproses Simpanan Wajib untuk ' . count($ids) . ' anggota. No Jurnal: ' . $noBukti);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }
    // MENU SIMPANAN SUKARELA
    public function menu_koperasi_simpanan_sukarela_koperasi($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $list_cabang = DB::table('kop_master_peserta')
                ->select('kop_master_peserta_cabang')
                ->distinct()
                ->whereNotNull('kop_master_peserta_cabang')
                ->pluck('kop_master_peserta_cabang');

            // COA Aset (Kas/Bank)
            $coa_pembayaran = DB::table('kop_fin_master_coa')
                ->where('is_active', 1)->where('coa_type', 'aset')->orderBy('coa_code', 'asc')->get();

            // COA Simpanan Sukarela (Kewajiban Koperasi ke Anggota)
            $coa_sukarela = DB::table('kop_fin_master_coa')
                ->where('is_active', 1)->orderBy('coa_code', 'asc')->get();

            // return view('koperasi.simpanan.sukarela', compact('list_cabang', 'coa_pembayaran', 'coa_sukarela'));
            return view('app-koperasi.menu-simpanan.menu-simpanan-sukarela', compact(
                'list_cabang',
                'coa_pembayaran',
                'coa_sukarela'
            ), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_simpanan_sukarela_koperasi_get_data(Request $request)
    {
        $cabang = $request->query('cabang');
        if (!$cabang) return response()->json(['data' => []], 400);

        // Mengambil data anggota dan menghitung sisa saldo berjalan dari tabel transaksi
        $anggota = DB::table('kop_master_peserta as p')
            ->select(
                'p.id_kop_master_peserta',
                'p.kop_master_peserta_code',
                'p.kop_master_peserta_name',
                DB::raw("COALESCE(
                    SUM(
                        CASE
                            WHEN t.jenis_transaksi = 'SETORAN' THEN t.nominal
                            ELSE -t.nominal
                        END
                    ), 0
                ) as saldo_sukarela")
            )
            ->leftJoin('kop_simpanan_sukarela_transaksi as t', 'p.id_kop_master_peserta', '=', 't.id_kop_master_peserta')
            ->where('p.kop_master_peserta_cabang', $cabang)
            ->where('p.kop_master_peserta_status', 'AKTIF')
            ->groupBy('p.id_kop_master_peserta', 'p.kop_master_peserta_code', 'p.kop_master_peserta_name')
            ->orderBy('p.kop_master_peserta_name', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $anggota
        ]);
    }
    public function menu_koperasi_simpanan_sukarela_koperasi_bayar(Request $request)
    {
        $request->validate([
            'id_kop_master_peserta' => 'required',
            'jenis_transaksi'       => 'required|in:SETORAN,PENARIKAN,POTONG_VOUCHER',
            'nominal'               => 'required|numeric|min:1',
            'coa_kas_bank'          => 'required|string',
            'coa_sukarela'          => 'required|string',
            'keterangan'            => 'nullable|string'
        ]);

        $idPeserta = $request->id_kop_master_peserta;
        $jenis = $request->jenis_transaksi;
        $nominal = $request->nominal;
        $operator = Auth::user()->name ?? 'Admin';

        // Ambil info nama & cabang peserta
        $peserta = DB::table('kop_master_peserta')->where('id_kop_master_peserta', $idPeserta)->first();
        if (!$peserta) return redirect()->back()->with('error', 'Anggota tidak ditemukan.');

        // Cek kecukupan saldo jika melakukan Penarikan / Potong Voucher
        if (in_array($jenis, ['PENARIKAN', 'POTONG_VOUCHER'])) {
            $saldoSaatIni = DB::table('kop_simpanan_sukarela_transaksi')
                ->where('id_kop_master_peserta', $idPeserta)
                ->select(DB::raw("SUM(CASE WHEN jenis_transaksi = 'SETORAN' THEN nominal ELSE -nominal END) as total"))
                ->value('total') ?? 0;

            if ($saldoSaatIni < $nominal) {
                return redirect()->back()->with('error', 'Transaksi Gagal! Saldo Sukarela tidak mencukupi. Sisa saldo saat ini: Rp ' . number_format($saldoSaatIni, 0, ',', '.'));
            }
        }

        DB::beginTransaction();
        try {
            // 1. Generate Nomor Jurnal (JVS = Jurnal Voucher Sukarela)
            $currentMonth = Carbon::now()->format('Ym');
            $prefix = "JVS-" . $currentMonth . "-";
            $lastJurnal = DB::table('kop_fin_jurnal')->where('jurnal_no_bukti', 'like', $prefix . '%')->orderBy('id_jurnal', 'desc')->first();
            $nextNumber = $lastJurnal ? str_pad(((int) substr($lastJurnal->jurnal_no_bukti, -4)) + 1, 4, '0', STR_PAD_LEFT) : "0001";
            $noBukti = $prefix . $nextNumber;

            // Keterangan default jurnal
            $ketJurnal = "Transaksi Sukarela [{$jenis}] - {$peserta->kop_master_peserta_name}. " . ($request->keterangan ?? '');

            // 2. Insert Header Jurnal
            $jurnalId = DB::table('kop_fin_jurnal')->insertGetId([
                'jurnal_no_bukti'   => $noBukti,
                'jurnal_tgl'        => Carbon::now()->format('Y-m-d'),
                'jurnal_keterangan' => $ketJurnal,
                'jurnal_ref_table'  => 'kop_simpanan_sukarela_transaksi',
                'jurnal_ref_code'   => $noBukti,
                'jurnal_user'       => $operator,
                'jurnal_cabang'     => $peserta->kop_master_peserta_cabang,
                'jurnal_created'    => $operator,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);

            // 3. Atur Posisi Debit & Kredit Accounting berdasarkan Jenis Transaksi
            if ($jenis === 'SETORAN') {
                // Uang masuk ke koperasi (Kas Bertambah [D], Tabungan Sukarela Anggota Bertambah/Kewajiban [K])
                $debitCoa  = $request->coa_kas_bank;
                $kreditCoa = $request->coa_sukarela;
            } else {
                // PENARIKAN / POTONG_VOUCHER: Tabungan Sukarela Berkurang [D], Kas Koperasi Berkurang [K]
                $debitCoa  = $request->coa_sukarela;
                $kreditCoa = $request->coa_kas_bank;
            }

            DB::table('kop_fin_jurnal_detail')->insert([
                ['jurnal_id' => $jurnalId, 'coa_code' => $debitCoa, 'jurnal_debit' => $nominal, 'jurnal_kredit' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['jurnal_id' => $jurnalId, 'coa_code' => $kreditCoa, 'jurnal_debit' => 0, 'jurnal_kredit' => $nominal, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            ]);

            // 4. Masukkan Mutasi ke Saldo Internal Sukarela
            DB::table('kop_simpanan_sukarela_transaksi')->insert([
                'id_kop_master_peserta' => $idPeserta,
                'id_jurnal'             => $jurnalId,
                'tgl_transaksi'         => Carbon::now()->format('Y-m-d'),
                'jenis_transaksi'       => $jenis,
                'nominal'               => $nominal,
                'keterangan'            => $request->keterangan ?? "Mutasi saldo {$jenis}",
                'operator'              => $operator,
                'created_at'            => Carbon::now(),
                'updated_at'            => Carbon::now()
            ]);

            DB::commit();
            return redirect()->back()->with('success', "Sukses memproses {$jenis} sebesar Rp " . number_format($nominal, 0, ',', '.') . ". No Jurnal: " . $noBukti);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
    // MENU ARISAN KOPERASI
    public function menu_koperasi_arisan($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('kop_arisan_group')->where('kop_arisan_group_cabang', Auth::user()->access_cabang)->get();
            return view('app-koperasi.menu-arisan-koperasi', compact('data'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_arisan_add_group(Request $request)
    {
        return view('app-koperasi.menu-arisan.form-add-group');
    }
    public function menu_koperasi_arisan_save_group(Request $request)
    {
        try {
            DB::table('kop_arisan_group')->insert([
                'kop_arisan_group_code' => str::uuid(),
                'kop_arisan_group_name' => $request->nama_group,
                'kop_arisan_group_date_start' => $request->tgl_mulai,
                'kop_arisan_group_date_end' => $request->tgl_selesai,
                'kop_arisan_group_nominal' => $request->nominal,
                'kop_arisan_group_bunga' => $request->bunga,
                'kop_arisan_group_cabang' => Auth::user()->access_cabang,
                'kop_arisan_group_status' => 0,
                'created_at' => now(),
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function menu_koperasi_arisan_add_group_peserta(Request $request)
    {
        $data = DB::table('kop_master_peserta')->get();
        return view('app-koperasi.menu-arisan.form-add-peserta', compact('data'), ['code' => $request->code]);
    }
    public function menu_koperasi_arisan_save_group_peserta(Request $request)
    {
        try {
            DB::table('kop_arisan_group_user')->insert([
                'kop_arisan_group_user_code' => str::uuid(),
                'kop_arisan_group_code' => $request->id,
                'kop_master_peserta_code' => $request->code,
                'created_at' => now()
            ]);
            return 'Berhasil';
        } catch (\Throwable $e) {
            return 'Gagal';
        }
    }
    public function menu_koperasi_arisan_generate_proses_arisan(Request $request)
    {
        try {
            $total_peserta = DB::table('kop_arisan_group_user')->where('kop_arisan_group_code', $request->code)->count();
            $data = DB::table('kop_arisan_group')->where('kop_arisan_group_code', $request->code)->first();
            $date1 = Carbon::parse($data->kop_arisan_group_date_start);
            $date2 = Carbon::parse($data->kop_arisan_group_date_end);
            $diffInMonths = $date1->diffInMonths($date2);
            $bunga = ($data->kop_arisan_group_bunga / 100) * ($data->kop_arisan_group_nominal * $total_peserta);
            for ($i = 0; $i <= $diffInMonths; $i++) {
                $date = date('Y-m-d', strtotime('+' . $i . ' month', strtotime($data->kop_arisan_group_date_start)));
                $cek = DB::table('kop_arisan_tagihan')->where('kop_arisan_group_code', $request->code)->where('kop_arisan_tagihan_date', $date)->first();
                if (!$cek) {
                    DB::table('kop_arisan_tagihan')->insert([
                        'kop_arisan_tagihan_code' => str::uuid(),
                        'kop_arisan_group_code' => $request->code,
                        'kop_arisan_tagihan_date' => $date,
                        'kop_arisan_tagihan_pokok' => ($data->kop_arisan_group_nominal * $total_peserta) - $bunga,
                        'kop_arisan_tagihan_bunga' => $bunga,
                        'kop_arisan_tagihan_nominal' => $data->kop_arisan_group_nominal * $total_peserta,
                        'kop_arisan_tagihan_kuota' => $total_peserta / $diffInMonths,
                        'kop_arisan_tagihan_status' => 0,
                        'created_at' => now()
                    ]);
                }
            }
            DB::table('kop_arisan_group')->where('kop_arisan_group_code', $request->code)->update([
                'kop_arisan_group_status' => 1,
                'updated_at' => now()
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function menu_koperasi_arisan_periode_group_arisan(Request $request)
    {
        $data = DB::table('kop_arisan_tagihan')->where('kop_arisan_group_code', $request->code)->get();
        return view('app-koperasi.menu-arisan.form-periode-arisan', compact('data'));
    }
    public function menu_koperasi_arisan_periode_group_arisan_create_token(Request $request)
    {
        $status = DB::table('kop_arisan_tagihan')->where('kop_arisan_group_code', $request->id)->where('kop_arisan_tagihan_status', 1)->first();
        if ($status) {
            return 0;
        } else {
            DB::table('kop_arisan_tagihan')->where('kop_arisan_tagihan_code', $request->code)->update([
                'kop_arisan_tagihan_status' => 1,
                'updated_at' => now()
            ]);
            return 1;
        }
    }
    public function menu_koperasi_arisan_proses_group_arisan(Request $request)
    {
        $peserta = DB::table('kop_arisan_group_user')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_arisan_group_user.kop_master_peserta_code')
            ->where('kop_arisan_group_code', $request->code)->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('kop_arisan_tagihan_peserta')
                    ->join('kop_arisan_tagihan', 'kop_arisan_tagihan.kop_arisan_tagihan_code', '=', 'kop_arisan_tagihan_peserta.kop_arisan_tagihan_code')
                    ->whereRaw('kop_arisan_tagihan_peserta.kop_arisan_group_user_code = kop_arisan_group_user.kop_arisan_group_user_code');
            })->get();
        $arisan = DB::table('kop_arisan_tagihan')->where('kop_arisan_group_code', $request->code)->where('kop_arisan_tagihan_status', 1)->first();
        $terpilih = DB::table('kop_arisan_tagihan')
            ->join('kop_arisan_tagihan_peserta', 'kop_arisan_tagihan_peserta.kop_arisan_tagihan_code', '=', 'kop_arisan_tagihan.kop_arisan_tagihan_code')
            ->join('kop_arisan_group_user', 'kop_arisan_group_user.kop_arisan_group_user_code', '=', 'kop_arisan_tagihan_peserta.kop_arisan_group_user_code')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_arisan_group_user.kop_master_peserta_code')
            ->where('kop_arisan_group_user.kop_arisan_group_code', $request->code)->get();
        if ($arisan) {
            return view('app-koperasi.menu-arisan.form-proses-group-arisan', compact('peserta', 'terpilih'), ['code' => $request->code, 'arisan' => $arisan]);
        } else {
            return '<div class="alert alert-danger" role="alert">
            <h4 class="alert-heading fw-semi-bold">Eror!</h4>
            <p>Pastikan Periode Arisan nYa sudah aktif.</p>
            <hr />
            <p class="mb-0">Silahkan Ke Periode Bulanan Untuk Mengaktifkan periodenya.</p>
            </div>';
        }
    }
    public function menu_koperasi_arisan_proses_group_arisan_spin(Request $request)
    {
        $kuota = DB::table('kop_arisan_tagihan')
            ->where('kop_arisan_tagihan_code', $request->data_arisan)->first();
        $data = DB::table('kop_arisan_tagihan_peserta')
            ->join('kop_arisan_tagihan', 'kop_arisan_tagihan.kop_arisan_tagihan_code', '=', 'kop_arisan_tagihan_peserta.kop_arisan_tagihan_code')
            ->where('kop_arisan_tagihan_peserta.kop_arisan_tagihan_code', $request->data_arisan)->count();
        if ($kuota->kop_arisan_tagihan_kuota == $data) {
            return 0;
            # code...
        } else {
            DB::table('kop_arisan_tagihan_peserta')->insert([
                'id_kop_tagihan_peserta_code' => str::uuid(),
                'kop_arisan_tagihan_code' => $request->data_arisan,
                'kop_arisan_group_user_code' => $request->data_peserta,
                'kop_tagihan_peserta_nominal' => $kuota->kop_arisan_tagihan_pokok / $kuota->kop_arisan_tagihan_kuota,
                'kop_tagihan_peserta_status' => 0,
                'created_at' => now()
            ]);
            $data1 = DB::table('kop_arisan_tagihan_peserta')
                ->join('kop_arisan_tagihan', 'kop_arisan_tagihan.kop_arisan_tagihan_code', '=', 'kop_arisan_tagihan_peserta.kop_arisan_tagihan_code')
                ->where('kop_arisan_tagihan_peserta.kop_arisan_tagihan_code', $request->data_arisan)->count();
            if ($kuota->kop_arisan_tagihan_kuota == $data1) {
                DB::table('kop_arisan_tagihan')->where('kop_arisan_tagihan_code', $request->data_arisan)->update([
                    'kop_arisan_tagihan_status' => 2,
                    'kop_arisan_tagihan_terpilih' => 'tidak jadi',
                    'updated_at' => now()
                ]);
            }
            return 1;
        }
    }
    // MENU ARISAN SETUP
    public function menu_koperasi_setup_arisan($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('kop_arisan_group')->where('kop_arisan_group_cabang', Auth::user()->access_cabang)->get();
            return view('app-koperasi.menu-arisan.arisan-setup', compact('data'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_setup_arisan_save_master_arisan(Request $request)
    {
        $request->validate([
            'kop_master_arisan_code' => 'required|unique:kop_master_arisan,kop_master_arisan_code',
            'kop_master_arisan_name' => 'required|string|max:255',
            'kop_master_arisan_nominal_point' => 'required|numeric|min:0',
            'kop_master_arisan_thn_mulai' => 'required|integer',
            'kop_master_arisan_thn_selesai' => 'required|integer',
        ]);

        KopMasterArisan::create([
            'kop_master_arisan_code' => $request->kop_master_arisan_code,
            'kop_master_arisan_name' => $request->kop_master_arisan_name,
            'kop_master_arisan_nominal_point' => $request->kop_master_arisan_nominal_point,
            'kop_master_arisan_thn_mulai' => $request->kop_master_arisan_thn_mulai,
            'kop_master_arisan_thn_selesai' => $request->kop_master_arisan_thn_selesai,
            'kop_master_arisan_status' => 'Draft', // Set default 'Draft' agar bisa diedit dulu
        ]);

        return response()->json(['success' => true, 'message' => 'Master Arisan Baru Berhasil Dibuat (Status: Draft)!']);
    }
    public function menu_koperasi_setup_arisan_get_data(Request $request)
    {
        $masterArisanList = KopMasterArisan::select(
            'id_kop_master_arisan',
            'kop_master_arisan_name',
            'kop_master_arisan_status',
            'kop_master_arisan_nominal_point'
        )->get();

        $cabangList = KopMasterPeserta::join('kop_master_cabang', 'kop_master_peserta.kop_master_peserta_cabang', '=', 'kop_master_cabang.kop_master_cabang_code')
            ->select(
                'kop_master_cabang.kop_master_cabang_code', // Kolom Kode Cabang
                'kop_master_cabang.kop_master_cabang_name'  // Kolom Nama Cabang
            )
            ->distinct()
            ->whereNotNull('kop_master_peserta.kop_master_peserta_cabang')
            ->get();

        return response()->json([
            'master_arisan_list' => $masterArisanList,
            'cabang_list' => $cabangList
        ]);
    }
    public function menu_koperasi_setup_arisan_get_peserta($cabang)
    {
        $peserta = KopMasterPeserta::where('kop_master_peserta_cabang', $cabang)
            ->where('kop_master_peserta_status', 'AKTIF')
            ->select('id_kop_master_peserta', 'kop_master_peserta_name', 'kop_master_peserta_code')
            ->get();

        return response()->json($peserta);
    }
    public function menu_koperasi_setup_arisan_get_jadwal(Request $request)
    {
        $idMaster = $request->query('id_master');
        $tahun = $request->query('tahun');

        $master = KopMasterArisan::findOrFail($idMaster);

        $jadwal = KopJadwalArisan::with(['peserta:id_kop_master_peserta,kop_master_peserta_name,kop_master_peserta_cabang'])
            ->where('id_kop_master_arisan', $idMaster)
            ->where('kop_jadwal_arisan_tahun', $tahun)
            ->get();

        return response()->json([
            'status_master' => $master->kop_master_arisan_status,
            'nominal_point' => $master->kop_master_arisan_nominal_point,
            'jadwal' => $jadwal
        ]);
    }
    public function menu_koperasi_setup_arisan_get_jadwal_store(Request $request)
    {
        $request->validate([
            'id_kop_master_arisan' => 'required|exists:kop_master_arisan,id_kop_master_arisan',
            'id_kop_master_peserta' => 'required|exists:kop_master_peserta,id_kop_master_peserta',
            'kop_jadwal_arisan_bulan' => 'required|integer|between:1,12',
            'kop_jadwal_arisan_tahun' => 'required|integer',
            'kop_jadwal_arisan_point' => 'required|integer|min:1',
        ]);

        $master = KopMasterArisan::findOrFail($request->id_kop_master_arisan);
        if ($master->kop_master_arisan_status === 'Aktif') {
            return response()->json(['message' => 'Gagal! Status arisan sudah AKTIF (Terkuci).'], 403);
        }

        $exist = KopJadwalArisan::where('id_kop_master_arisan', $request->id_kop_master_arisan)
            ->where('id_kop_master_peserta', $request->id_kop_master_peserta)
            ->where('kop_jadwal_arisan_bulan', $request->kop_jadwal_arisan_bulan)
            ->where('kop_jadwal_arisan_tahun', $request->kop_jadwal_arisan_tahun)
            ->exists();

        if ($exist) {
            return response()->json(['message' => 'Peserta sudah terdaftar di bulan ini!'], 422);
        }

        KopJadwalArisan::create($request->all());
        return response()->json(['success' => true, 'message' => 'Berhasil dijadwalkan!']);
    }
    public function menu_koperasi_setup_arisan_get_jadwal_delete($id)
    {
        $jadwal = KopJadwalArisan::findOrFail($id);
        $master = KopMasterArisan::findOrFail($jadwal->id_kop_master_arisan);

        if ($master->kop_master_arisan_status === 'Aktif') {
            return response()->json(['message' => 'Gagal! Data aktif dikunci.'], 403);
        }

        $jadwal->delete();
        return response()->json(['success' => true]);
    }
    // MENU ARISAN PENAGIHAN
    public function menu_koperasi_penagihan_arisan($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('kop_arisan_group')->where('kop_arisan_group_cabang', Auth::user()->access_cabang)->get();
            $akun = DB::table('kop_fin_master_coa')->get();
            return view('app-koperasi.menu-arisan.arisan-penagihan', compact('data', 'akun'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_penagihan_arisan_get_data(Request $request)
    {
        $masterAktif = KopMasterArisan::where('kop_master_arisan_status', 'Aktif')
            ->select('id_kop_master_arisan', 'kop_master_arisan_name', 'kop_master_arisan_nominal_point')
            ->get();

        return response()->json(['master_aktif' => $masterAktif]);
    }
    public function menu_koperasi_penagihan_arisan_get_laporan(Request $request)
    {
        $request->validate([
            'id_master' => 'required|exists:kop_master_arisan,id_kop_master_arisan',
            'tahun' => 'required|integer',
        ]);

        $idMaster = $request->query('id_master');
        $tahun = $request->query('tahun');

        $master = KopMasterArisan::findOrFail($idMaster);
        $nominalPoin = $master->kop_master_arisan_nominal_point;

        // 1. Ambil data akumulasi poin tahunan per peserta
        $tagihanTahunan = KopJadwalArisan::select(
            'id_kop_master_peserta',
            DB::raw('SUM(kop_jadwal_arisan_point) as total_poin_setahun')
        )
            ->where('id_kop_master_arisan', $idMaster)
            ->where('kop_jadwal_arisan_tahun', $tahun)
            ->groupBy('id_kop_master_peserta')
            ->with(['peserta:id_kop_master_peserta,kop_master_peserta_code,kop_master_peserta_name,kop_master_peserta_cabang,kop_master_peserta_no_hp'])
            ->get();

        // 2. Ambil list bulan yang SUDAH dibayar oleh masing-masing peserta di tahun ini
        $listPembayaran = KopTransaksiArisan::where('id_kop_master_arisan', $idMaster)
            ->where('kop_transaksi_tahun', $tahun)
            ->select('id_kop_master_peserta', 'kop_transaksi_bulan')
            ->get()
            ->groupBy('id_kop_master_peserta')
            ->map(function ($transaksi) {
                return $transaksi->pluck('kop_transaksi_bulan')->toArray();
            });

        // 3. Gabungkan data tagihan dengan riwayat pembayaran
        $resultData = $tagihanTahunan->map(function ($item) use ($nominalPoin, $listPembayaran) {
            $item->tagihan_per_bulan = $item->total_poin_setahun * $nominalPoin;

            // Ambil array bulan yang sudah lunas (jika belum ada transaksi, default array kosong)
            $item->bulan_lunas = $listPembayaran->get($item->id_kop_master_peserta, []);

            return $item;
        });

        return response()->json([
            'nama_arisan' => $master->kop_master_arisan_name,
            'nominal_per_poin' => $nominalPoin,
            'data_tagihan' => $resultData
        ]);
    }
    public function menu_koperasi_penagihan_arisan_payment(Request $request)
    {
        $request->validate([
            'id_kop_master_arisan' => 'required|exists:kop_master_arisan,id_kop_master_arisan',
            'id_kop_master_peserta' => 'required|exists:kop_master_peserta,id_kop_master_peserta',
            'kop_transaksi_bulan' => 'required|integer|between:1,12',
            'kop_transaksi_tahun' => 'required|integer',
            'kop_transaksi_total_poin' => 'required|integer',
            'kop_transaksi_nominal' => 'required|numeric',
            'kop_transaksi_metode' => 'required|string',
        ]);
        $data = DB::table('kop_jadwal_arisan')
            ->join('kop_master_arisan', 'kop_master_arisan.id_kop_master_arisan', '=', 'kop_jadwal_arisan.id_kop_master_arisan')
            ->join('kop_master_peserta', 'kop_master_peserta.id_kop_master_peserta', '=', 'kop_jadwal_arisan.id_kop_master_peserta')
            ->join('kop_master_cabang', 'kop_master_cabang.kop_master_cabang_code', '=', 'kop_master_peserta.kop_master_peserta_cabang')
            ->where('kop_master_arisan.id_kop_master_arisan', $request->id_kop_master_arisan)
            ->where('kop_jadwal_arisan.id_kop_master_peserta', $request->id_kop_master_peserta)
            // ->where('kop_jadwal_arisan.kop_jadwal_arisan_bulan', ($request->kop_transaksi_bulan)
            ->where('kop_jadwal_arisan.kop_jadwal_arisan_tahun', $request->kop_transaksi_tahun)->first();

        $sudahBayar = KopTransaksiArisan::where('id_kop_master_arisan', $request->id_kop_master_arisan)
            ->where('id_kop_master_peserta', $request->id_kop_master_peserta)
            ->where('kop_transaksi_bulan', $request->kop_transaksi_bulan)
            ->where('kop_transaksi_tahun', $request->kop_transaksi_tahun)
            ->exists();
        if (!$data) {
            return response()->json(['message' => 'Data Arisan Tidak di temukan'], 422);
        }
        if ($sudahBayar) {
            return response()->json(['message' => 'Anggota sudah membayar iuran arisan pada bulan terpilih!'], 422);
        }

        $nominalPokok = $request->kop_transaksi_nominal;
        // $biayaAdmin = $data->kop_tagihan_bulan_peserta_nominal - $data->kop_tagihan_bulan_peserta_pokok;
        $kasMasuk = $request->kop_transaksi_nominal;
        $headerJurnal = [
            'jurnal_tgl' => now()->format('Y-m-d'),
            'jurnal_keterangan' => "Setoran Arisan Anggota . " . $data->kop_master_arisan_name . " an. " . $data->kop_master_peserta_name . " ( " . $data->kop_master_peserta_nip . " ) ",
            'jurnal_ref_table' => 'kop_transaksi_arisan',
            'jurnal_ref_code' => $data->id_kop_master_arisan,
            'jurnal_user' => $data->kop_master_peserta_code,
            'jurnal_cabang' => $data->kop_master_peserta_cabang,
        ];

        $detailJurnal = [
            ['coa_code' => $request->kop_transaksi_metode, 'jurnal_debit' => $kasMasuk, 'jurnal_kredit' => 0], // Piutang Anggota
            ['coa_code' => '2.3.1', 'jurnal_debit' => 0, 'jurnal_kredit' => $nominalPokok],    // Kas/Bank Koperasi
        ];


        $this->accountingService->createJournal($headerJurnal, $detailJurnal);

        $transaksi = KopTransaksiArisan::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran kas arisan berhasil disimpan ke database!',
            'data' => $transaksi
        ]);
    }
    // MENU ARISAN PENCAIRAN
    public function menu_koperasi_pencairan_arisan($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('kop_arisan_group')->where('kop_arisan_group_cabang', Auth::user()->access_cabang)->get();
            $akun = DB::table('kop_fin_master_coa')->get();
            return view('app-koperasi.menu-arisan.arisan-pencairan', compact('data', 'akun'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_pencairan_arisan_get_data()
    {
        $masterAktif = KopMasterArisan::where('kop_master_arisan_status', 'Aktif')
            ->select('id_kop_master_arisan', 'kop_master_arisan_name', 'kop_master_arisan_nominal_point')
            ->get();

        return response()->json(['master_aktif' => $masterAktif]);
    }
    public function menu_koperasi_pencairan_arisan_cek_pemenang(Request $request)
    {
        $idMaster = $request->query('id_master');
        $tahun = $request->query('tahun');
        $bulan = $request->query('bulan');

        $master = KopMasterArisan::findOrFail($idMaster);
        $nominalRate = $master->kop_master_arisan_nominal_point;

        // 1. Cari peserta yang terjadwal cair di bulan & tahun ini
        $pemenangJadwal = KopJadwalArisan::where('id_kop_master_arisan', $idMaster)
            ->where('kop_jadwal_arisan_tahun', $tahun)
            ->where('kop_jadwal_arisan_bulan', $bulan)
            ->with(['peserta'])
            ->get();

        $dataHasil = $pemenangJadwal->map(function ($jadwal) use ($idMaster, $tahun, $bulan, $nominalRate) {
            $idPeserta = $jadwal->id_kop_master_peserta;
            $poinBulanIni = $jadwal->kop_jadwal_arisan_point;

            // RUMUS BARU: Poin Bulan Ini x Rate Poin x 12 Bulan Periode
            $nominalPencairan = $poinBulanIni * $nominalRate * 12;

            // 2. Cek tracking pembayaran dari Januari (bulan 1) sampai Bulan Berjalan ($bulan)
            $listBulanWajib = range(1, $bulan);
            $bulanSudahBayar = KopTransaksiArisan::where('id_kop_master_arisan', $idMaster)
                ->where('id_kop_master_peserta', $idPeserta)
                ->where('kop_transaksi_tahun', $tahun)
                ->whereIn('kop_transaksi_bulan', $listBulanWajib)
                ->pluck('kop_transaksi_bulan')
                ->toArray();

            $detailReviewBulan = [];
            $siapCair = true;

            foreach ($listBulanWajib as $b) {
                $lunas = in_array($b, $bulanSudahBayar);
                if (!$lunas) {
                    $siapCair = false;
                }
                $detailReviewBulan[] = [
                    'bulan' => $b,
                    'status' => $lunas ? 'Lunas' : 'Belum Bayar'
                ];
            }

            // 3. Cek double pencairan
            $sudahCair = KopPencairanArisan::where('id_kop_master_arisan', $idMaster)
                ->where('id_kop_master_peserta', $idPeserta)
                ->where('kop_pencairan_tahun', $tahun)
                ->where('kop_pencairan_bulan', $bulan)
                ->exists();

            return [
                'id_peserta' => $idPeserta,
                'nama_peserta' => $jadwal->peserta->kop_master_peserta_name,
                'kode_peserta' => $jadwal->peserta->kop_master_peserta_code,
                'cabang' => $jadwal->peserta->kop_master_peserta_cabang,
                'poin_bulan_ini' => $poinBulanIni,
                'nominal_pencairan' => $nominalPencairan,
                'review_pembayaran' => $detailReviewBulan,
                'is_siap_cair' => $siapCair,
                'is_sudah_cair' => $sudahCair
            ];
        });

        return response()->json([
            'nominal_rate' => $nominalRate,
            'pemenang' => $dataHasil
        ]);
    }
    public function menu_koperasi_pencairan_arisan_proses(Request $request)
    {
        $request->validate([
            'id_kop_master_arisan' => 'required|exists:kop_master_arisan,id_kop_master_arisan',
            'id_kop_master_peserta' => 'required|exists:kop_master_peserta,id_kop_master_peserta',
            'kop_pencairan_bulan' => 'required|integer',
            'kop_pencairan_tahun' => 'required|integer',
            'kop_pencairan_nominal' => 'required|numeric',
        ]);

        $data = DB::table('kop_jadwal_arisan')
            ->join('kop_master_arisan', 'kop_master_arisan.id_kop_master_arisan', '=', 'kop_jadwal_arisan.id_kop_master_arisan')
            ->join('kop_master_peserta', 'kop_master_peserta.id_kop_master_peserta', '=', 'kop_jadwal_arisan.id_kop_master_peserta')
            ->join('kop_master_cabang', 'kop_master_cabang.kop_master_cabang_code', '=', 'kop_master_peserta.kop_master_peserta_cabang')
            ->where('kop_master_arisan.id_kop_master_arisan', $request->id_kop_master_arisan)
            ->where('kop_jadwal_arisan.id_kop_master_peserta', $request->id_kop_master_peserta)
            ->where('kop_jadwal_arisan_bulan', $request->kop_pencairan_bulan)
            ->where('kop_jadwal_arisan_tahun', $request->kop_pencairan_tahun)->first();

        // Proteksi double pencairan
        $exist = KopPencairanArisan::where('id_kop_master_arisan', $request->id_kop_master_arisan)
            ->where('id_kop_master_peserta', $request->id_kop_master_peserta)
            ->where('kop_pencairan_tahun', $request->kop_pencairan_tahun)
            ->where('kop_pencairan_bulan', $request->kop_pencairan_bulan)
            ->exists();

        if ($exist) {
            return response()->json(['message' => 'Dana arisan bulan ini untuk anggota tersebut sudah dicairkan sebelumnya!'], 422);
        }

        $nominalPokok = $request->kop_pencairan_nominal;
        // $biayaAdmin = $data->kop_tagihan_bulan_peserta_nominal - $data->kop_tagihan_bulan_peserta_pokok;
        $kasMasuk = $request->kop_pencairan_nominal;
        $headerJurnal = [
            'jurnal_tgl' => now()->format('Y-m-d'),
            'jurnal_keterangan' => "Setoran Arisan Anggota . " . $data->kop_master_arisan_name . " an. " . $data->kop_master_peserta_name . " ( " . $data->kop_master_peserta_nip . " ) ",
            'jurnal_ref_table' => 'kop_transaksi_arisan',
            'jurnal_ref_code' => $data->id_kop_master_arisan,
            'jurnal_user' => $data->kop_master_peserta_code,
            'jurnal_cabang' => $data->kop_master_peserta_cabang,
        ];

        $detailJurnal = [
            ['coa_code' => '2.3.1', 'jurnal_debit' => $kasMasuk, 'jurnal_kredit' => 0], // Piutang Anggota
            ['coa_code' => $request->id_akun_keuangan, 'jurnal_debit' => 0, 'jurnal_kredit' => $nominalPokok],    // Kas/Bank Koperasi
        ];

        $this->accountingService->createJournal($headerJurnal, $detailJurnal);
        KopPencairanArisan::create([
            'id_kop_master_arisan' => $request->id_kop_master_arisan,
            'id_kop_master_peserta' => $request->id_kop_master_peserta,
            'kop_pencairan_bulan' => $request->kop_pencairan_bulan,
            'kop_pencairan_tahun' => $request->kop_pencairan_tahun,
            'kop_pencairan_nominal' => $request->kop_pencairan_nominal,
            'kop_pencairan_tanggal' => Carbon::now(),
            'kop_pencairan_status' => 'Cair',
            'kop_pencairan_keterangan' => $request->kop_pencairan_keterangan ?? 'Pencairan Arisan Bulanan Terjadwal',
        ]);

        return response()->json(['success' => true, 'message' => 'Sukses! Dana arisan berhasil dicairkan kepada pemenang.']);
    }

    // MENU VOCHER KOPERASI
    public function menu_koperasi_vocher($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('kop_vocher_data')
                ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_vocher_data.kop_master_peserta_code')
                ->join('kop_user_verifikasi', 'kop_user_verifikasi.kop_user_verifikasi_code', '=', 'kop_vocher_data.kop_vocher_data_ketua')
                ->where('kop_vocher_data_cabang', Auth::user()->access_cabang)->orderBy('id_vocher_data', 'desc')->get();
            $categories = [
                'ELC' => 'Listrik (PLN)',
                'WTR' => 'PDAM',
                'NET' => 'Internet / WiFi',
                'TEL' => 'Pulsa / Pascabayar'
            ];
            return view('app-koperasi.menu-vocher-koperasi', compact('data', 'categories'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_vocher_store(Request $request)
    {
        $request->validate([
            'kop_master_peserta_code' => 'required|string',
            'kop_vocher_cat_code'    => 'required|string',
            'kop_vocher_data_nominal' => 'required|numeric|min:1000',
            'kop_vocher_data_admin'   => 'required|numeric|min:0',
            'kop_vocher_data_number_id' => 'required|string',
            'kop_vocher_data_cabang'   => 'required|string',
        ]);

        // Otomatisasi Tanggal (Mulai hari ini s.d Akhir Bulan Ini untuk tagihan akhir bulan)
        $dateStart = Carbon::now();
        $dateEnd   = Carbon::now()->endOfMonth(); // Jatuh tempo akhir bulan berjalan

        // Generate Kode & Token Unik
        $voucherCode = 'VCH-' . strtoupper(Str::random(8));
        $token       = strtoupper(Str::random(12)); // Bisa disesuaikan dengan format API PPOB jika ada

        KopVocherData::create([
            'kop_vocher_data_code'     => $voucherCode,
            'kop_vocher_data_token'    => $token,
            'kop_master_peserta_code'  => $request->kop_master_peserta_code,
            'kop_vocher_cat_code'      => $request->kop_vocher_cat_code,
            'kop_vocher_data_nominal'  => $request->kop_vocher_data_nominal,
            'kop_vocher_data_admin'    => $request->kop_vocher_data_admin,
            'kop_vocher_data_number_id' => $request->kop_vocher_data_number_id,
            'kop_vocher_data_ketua'    => 'Ketua Koperasi 2026', // Bisa dinamis dari session/config
            'kop_vocher_data_date_start' => $dateStart->format('Y-m-d'),
            'kop_vocher_data_date_end'  => $dateEnd->format('Y-m-d'),
            'kop_vocher_data_cabang'   => $request->kop_vocher_data_cabang,
            'kop_vocher_data_status'   => 'PENDING_BILL', // Status: Menunggu tagihan akhir bulan
        ]);

        return redirect()->back()->with('success', 'Voucher berhasil diterbitkan! Tagihan dimasukkan ke akhir bulan.');
    }
    public function menu_koperasi_vocher_add(Request $request)
    {
        $cat = DB::table('kop_vocher_cat')->get();
        $anggota = DB::table('kop_master_peserta')->where('kop_master_peserta_cabang', Auth::user()->access_cabang)->get();
        $verif = DB::table('kop_user_verifikasi')->where('kop_user_verifikasi_cabang', Auth::user()->access_cabang)->get();
        return view('app-koperasi.menu-vocher.form-add-vocher', compact('cat', 'anggota', 'verif'));
    }
    public function menu_koperasi_vocher_save(Request $request)
    {
        try {
            $kode = 'VC-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
            DB::table('kop_vocher_data')->insert([
                'kop_vocher_data_code' => $kode,
                'kop_vocher_data_token' => str::uuid(),
                'kop_master_peserta_code' => $request->anggota,
                'kop_vocher_cat_code' => $request->kategori,
                'kop_vocher_data_admin' => $request->admin,
                'kop_vocher_data_nominal' => $request->nominal,
                'kop_vocher_data_number_id' => $request->nomor_id,
                'kop_vocher_data_ketua' => $request->verif,
                'kop_vocher_data_date_start' => $request->tanggal_vocher,
                'kop_vocher_data_date_end' =>  date('Y-m-d', strtotime('+' . 1 . ' month', strtotime($request->tanggal_vocher))),
                'kop_vocher_data_cabang' => Auth::user()->access_cabang,
                'kop_vocher_data_status' => 0,
                'created_at' => now(),
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function menu_koperasi_vocher_proses(Request $request)
    {
        $data = DB::table('kop_vocher_data')->where('kop_vocher_data_code', $request->code)->first();
        $akun = DB::table('kop_fin_master_coa')->where('coa_type', 'aset')->get();
        return view('app-koperasi.menu-vocher.form-proses-vocher', compact('akun'), ['data' => $data]);
    }
    public function menu_koperasi_vocher_proses_send_token(Request $request)
    {
        $data = DB::table('kop_vocher_data')
            ->join('kop_user_verifikasi', 'kop_user_verifikasi.kop_user_verifikasi_cabang', '=', 'kop_vocher_data.kop_vocher_data_cabang')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_vocher_data.kop_master_peserta_code')
            ->where('kop_user_verifikasi_job', 1)
            ->where('kop_user_verifikasi_status', 1)
            ->where('kop_vocher_data_code', $request->data_vocher)->first();
        if ($data) {
            $nomorhp = $this->stup_no_wa($data->kop_user_verifikasi_whatsapp);

            $link = route('data_vocher_koperasi', ['code' => $data->kop_vocher_data_code]);
            $text = "Halo " . $data->kop_user_verifikasi_name . "\n\nDengan Nomor Vocher : " . $data->kop_vocher_data_code .
                "\nAda Pengeluaran Vocher Sebagai Berikut\nNama :" . $data->kop_master_peserta_name . "\nNominal Vocher : Rp." . number_format($data->kop_vocher_data_nominal, 0, ',', '.') . "\nSilahkan Untuk Sign Di bawah ini:\n\n" . $link . "\n\nSystem Notifikasi";
            $cek = DB::table('kop_sender_wa')->where('kop_sender_wa_code_token', $data->kop_vocher_data_token)->first();
            if ($cek) {
                DB::table('kop_sender_wa')->where('kop_sender_wa_code_token', $data->kop_vocher_data_token)->update([
                    'kop_sender_wa_code_status' => 0,
                    'kop_sender_wa_code_user' => Auth::user()->userid,
                    'updated_at' => now()
                ]);
            } else {
                # code...
                DB::table('kop_sender_wa')->insert([
                    'kop_sender_wa_code' => str::uuid(),
                    'kop_sender_wa_code_token' => $data->kop_vocher_data_token,
                    'kop_sender_wa_code_number' => $nomorhp,
                    'kop_sender_wa_code_name' => $data->kop_master_peserta_name,
                    'kop_sender_wa_code_filename' => 'nofile',
                    'kop_sender_wa_code_text' => $text,
                    'kop_sender_wa_code_file' => 'N',
                    'kop_sender_wa_code_picture' => 0,
                    'kop_sender_wa_code_status' => 0,
                    'kop_sender_wa_code_date' => now(),
                    'kop_sender_wa_code_pass' => 'admin',
                    'kop_sender_wa_code_user' => Auth::user()->userid,
                    'created_at' => now()
                ]);
            }
            return 1;
        } else {
            return 0;
        }
    }
    public function menu_koperasi_vocher_proses_save(Request $request)
    {
        $verif = DB::table('kop_vocher_data_verif')->where('kop_vocher_data_code', $request->data_vocher)->first();
        if ($verif) {
            $data = DB::table('kop_vocher_data')
                ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_vocher_data.kop_master_peserta_code')
                ->where('kop_vocher_data_code', $request->data_vocher)->first();
            try {
                $cek = DB::table('kop_log_vocher')->where('kop_vocher_data_code', $request->data_vocher)->first();
                if ($cek) {
                    return 0;
                } else {
                    $nominalPokok = $data->kop_vocher_data_nominal;
                    $biayaAdmin = ($data->kop_vocher_data_admin / 100) * $data->kop_vocher_data_nominal;
                    $kasKeluar = $nominalPokok - $biayaAdmin;
                    $headerJurnal = [
                        'jurnal_tgl' => now()->format('Y-m-d'),
                        'jurnal_keterangan' => "Pencairan Vocher Dengan No Pengajuan. " . $data->kop_vocher_data_code . " an. " . $data->kop_master_peserta_name . " ( " . $data->kop_master_peserta_nip . " ) ",
                        'jurnal_ref_table' => 'kop_vocher_data',
                        'jurnal_ref_code' => $data->kop_vocher_data_code,
                        'jurnal_user' => Auth::user()->userid,
                        'jurnal_cabang' => $data->kop_master_peserta_cabang,
                    ];
                    $set = DB::table('kop_fin_master_coa_set')
                        ->where('fin_master_coa_set_cabang', $data->kop_master_peserta_cabang)
                        ->where('fin_master_coa_set_type', '=', 'proses_vocher')->first();
                    if ($request->akun == "") {
                        $akun_pencairan = $set->fin_master_coa_set_kredit;
                    } else {
                        $akun_pencairan = $request->akun;
                    }
                    if ($biayaAdmin == 0) {
                        $detailJurnal = [
                            ['coa_code' => $set->fin_master_coa_set_debit, 'jurnal_debit' => $nominalPokok, 'jurnal_kredit' => 0], // Piutang Anggota
                            ['coa_code' => $akun_pencairan, 'jurnal_debit' => 0, 'jurnal_kredit' => $kasKeluar],    // Kas/Bank Koperasi
                        ];
                    } else {
                        $detailJurnal = [
                            ['coa_code' => $set->fin_master_coa_set_debit, 'jurnal_debit' => $nominalPokok, 'jurnal_kredit' => 0], // Piutang Anggota
                            ['coa_code' => $set->fin_master_coa_set_adm, 'jurnal_debit' => 0, 'jurnal_kredit' => $biayaAdmin],   // Pendapatan Admin
                            ['coa_code' => $akun_pencairan, 'jurnal_debit' => 0, 'jurnal_kredit' => $kasKeluar],    // Kas/Bank Koperasi
                        ];
                    }

                    // Aturan Akuntansi: Debit (Piutang), Kredit (Pendapatan Admin & Kas)

                    // 3. Eksekusi Jurnal
                    $this->accountingService->createJournal($headerJurnal, $detailJurnal);

                    // DB::table('kop_log_vocher')->insert([
                    //     'kop_log_vocher_code' => str::uuid(),
                    //     'kop_vocher_data_code' => $request->data_vocher,
                    //     'kop_log_vocher_pokok' => $data->kop_vocher_data_nominal,
                    //     'kop_log_vocher_bunga' => 0,
                    //     'kop_log_vocher_nominal' => $data->kop_vocher_data_nominal,
                    //     'kop_log_vocher_date' => now(),
                    //     'created_at' => now(),
                    // ]);
                    DB::table('kop_vocher_data')->where('kop_vocher_data_code', $request->data_vocher)->update([
                        'kop_vocher_data_status' => 2,
                        'updated_at' => now()
                    ]);
                    return 1;
                }
            } catch (\Throwable $e) {
                return 0;
            }
        } else {
            return 0;
        }
    }
    public function menu_koperasi_vocher_pelunasan(Request $request)
    {
        $data = DB::table('kop_vocher_data')->where('kop_vocher_data_code', $request->code)->first();
        $akun = DB::table('kop_fin_master_coa')->where('coa_type', 'aset')->get();
        return view('app-koperasi.menu-vocher.form-pelunasan-vocher', compact('data', 'akun'), ['code' => $request->code]);
    }
    public function menu_koperasi_vocher_pelunasan_payment(Request $request)
    {
        $verif = DB::table('kop_vocher_data_verif')->where('kop_vocher_data_code', $request->data_vocher)->first();
        if ($verif) {
            $data = DB::table('kop_vocher_data')
                ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_vocher_data.kop_master_peserta_code')
                ->where('kop_vocher_data_code', $request->data_vocher)->first();
            try {
                $cek = DB::table('kop_log_vocher')->where('kop_vocher_data_code', $request->data_vocher)->first();
                if ($cek) {
                    return 0;
                } else {
                    $nominalPokok = $data->kop_vocher_data_nominal;

                    $headerJurnal = [
                        'jurnal_tgl' => now()->format('Y-m-d'),
                        'jurnal_keterangan' => "Pelunasan Vocher Dengan No Pengajuan. " . $data->kop_vocher_data_code . " an. " . $data->kop_master_peserta_name . " ( " . $data->kop_master_peserta_nip . " ) ",
                        'jurnal_ref_table' => 'kop_vocher_data',
                        'jurnal_ref_code' => $data->kop_vocher_data_code,
                        'jurnal_user' => Auth::user()->userid,
                        'jurnal_cabang' => $data->kop_master_peserta_cabang,
                    ];
                    $set = DB::table('kop_fin_master_coa_set')
                        ->where('fin_master_coa_set_cabang', $data->kop_master_peserta_cabang)
                        ->where('fin_master_coa_set_type', '=', 'tagihan_vocher')->first();
                    if ($request->akun == "") {
                        $akun_pencairan = $set->fin_master_coa_set_kredit;
                    } else {
                        $akun_pencairan = $request->akun;
                    }

                    $detailJurnal = [
                        ['coa_code' => $akun_pencairan, 'jurnal_debit' => $nominalPokok, 'jurnal_kredit' => 0], // Piutang Anggota
                        ['coa_code' => $set->fin_master_coa_set_kredit, 'jurnal_debit' => 0, 'jurnal_kredit' => $nominalPokok],    // Kas/Bank Koperasi
                    ];


                    // Aturan Akuntansi: Debit (Piutang), Kredit (Pendapatan Admin & Kas)

                    // 3. Eksekusi Jurnal
                    $this->accountingService->createJournal($headerJurnal, $detailJurnal);

                    DB::table('kop_log_vocher')->insert([
                        'kop_log_vocher_code' => str::uuid(),
                        'kop_vocher_data_code' => $request->data_vocher,
                        'kop_log_vocher_pokok' => $data->kop_vocher_data_nominal,
                        'kop_log_vocher_bunga' => 0,
                        'kop_log_vocher_nominal' => $data->kop_vocher_data_nominal,
                        'kop_log_vocher_date' => now(),
                        'created_at' => now(),
                    ]);
                    DB::table('kop_vocher_data')->where('kop_vocher_data_code', $request->data_vocher)->update([
                        'kop_vocher_data_status' => 3,
                        'updated_at' => now()
                    ]);
                    return 1;
                }
            } catch (\Throwable $e) {
                return 0;
            }
        } else {
            return 0;
        }
    }
    // MENU IURAN KOPERASI
    public function menu_koperasi_iuran($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('kop_tagihan_bulan')
                ->join('kop_master_cabang', 'kop_master_cabang.kop_master_cabang_code', '=', 'kop_tagihan_bulan.kop_tagihan_bulan_cabang')
                ->where('kop_tagihan_bulan_cabang', Auth::user()->access_cabang)->orderBy('id_kop_tagihan_bulan', 'desc')->get();
            return view('app-koperasi.menu-iuran-koperasi', compact('data'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_iuran_add(Request $request)
    {
        $cabang = DB::table('kop_master_cabang')->get();
        return view('app-koperasi.menu-iuran.form-add-iuran', compact('cabang'));
    }
    public function menu_koperasi_iuran_save(Request $request)
    {
        try {
            $peserta = DB::table('kop_master_peserta')->where('kop_master_peserta_cabang', $request->cabang)->count();
            $kode = 'SW-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
            DB::table('kop_tagihan_bulan')->insert([
                'kop_tagihan_bulan_code' => $kode,
                'kop_tagihan_bulan_date' => $request->tanggal_tagihan,
                'kop_tagihan_bulan_pokok' => $request->simpanan_wajib - ($request->keuntungan / 100) * $request->simpanan_wajib,
                'kop_tagihan_bulan_bunga' => $request->keuntungan,
                'kop_tagihan_bulan_nominal' => $request->simpanan_wajib,
                'kop_tagihan_bulan_peserta' => $peserta,
                'kop_tagihan_bulan_cabang' => $request->cabang,
                'kop_tagihan_bulan_status' => 0,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function menu_koperasi_iuran_proses(Request $request)
    {
        $data = DB::table('kop_master_peserta')
            ->join('kop_tagihan_bulan', 'kop_tagihan_bulan.kop_tagihan_bulan_cabang', '=', 'kop_master_peserta.kop_master_peserta_cabang')
            ->where('kop_master_peserta.kop_master_peserta_status', 'AKTIF')
            ->where('kop_tagihan_bulan_code', $request->code)->get();
        return view('app-koperasi.menu-iuran.form-proses-iuran', compact('data'), ['code' => $request->code]);
    }
    public function menu_koperasi_iuran_proses_create(Request $request)
    {
        $data = DB::table('kop_master_peserta')
            ->join('kop_tagihan_bulan', 'kop_tagihan_bulan.kop_tagihan_bulan_cabang', '=', 'kop_master_peserta.kop_master_peserta_cabang')
            ->where('kop_master_peserta.kop_master_peserta_status', 1)
            ->where('kop_tagihan_bulan_code', $request->code)->get();
        foreach ($data as $datas) {
            $cek = DB::table('kop_tagihan_bulan_peserta')->where('kop_tagihan_bulan_code', $request->code)->where('kop_master_peserta_code', $datas->kop_master_peserta_code)->first();
            if (!$cek) {
                DB::table('kop_tagihan_bulan_peserta')->insert([
                    'kop_tagihan_bulan_peserta_code' => str::uuid(),
                    'kop_tagihan_bulan_code' => $request->code,
                    'kop_master_peserta_code' => $datas->kop_master_peserta_code,
                    'kop_tagihan_bulan_peserta_pokok' => $datas->kop_tagihan_bulan_pokok,
                    'kop_tagihan_bulan_peserta_bunga' => ($datas->kop_tagihan_bulan_bunga / 100) * $datas->kop_tagihan_bulan_nominal,
                    'kop_tagihan_bulan_peserta_nominal' => $datas->kop_tagihan_bulan_nominal,
                    'kop_tagihan_bulan_peserta_date' => $datas->kop_tagihan_bulan_date,
                    'kop_tagihan_bulan_peserta_status' => 0,
                    'created_at' => now(),
                ]);
            }
        }
        DB::table('kop_tagihan_bulan')->where('kop_tagihan_bulan_code', $request->code)->update([
            'kop_tagihan_bulan_status' => 1
        ]);
        return 1;
    }
    public function menu_koperasi_iuran_proses_peserta(Request $request)
    {
        $data = DB::table('kop_tagihan_bulan_peserta')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_tagihan_bulan_peserta.kop_master_peserta_code')
            ->where('kop_tagihan_bulan_peserta.kop_tagihan_bulan_code', $request->code)->get();
        $akun = DB::table('kop_fin_master_coa')->where('coa_type', 'aset')->get();
        return view('app-koperasi.menu-iuran.form-generate-tagihan', compact('data', 'akun'), ['code' => $request->code]);
    }
    public function menu_koperasi_iuran_proses_peserta_payment(Request $request)
    {
        $data = DB::table('kop_tagihan_bulan_peserta')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_tagihan_bulan_peserta.kop_master_peserta_code')
            ->where('kop_tagihan_bulan_peserta.kop_tagihan_bulan_code', $request->code)->get();
        foreach ($data as $datas) {
            $cek = DB::table('kop_log_tagihan_bulan')->where('kop_tagihan_bulan_peserta_code', $datas->kop_tagihan_bulan_peserta_code)->first();
            if (!$cek) {

                $nominalPokok = $datas->kop_tagihan_bulan_peserta_pokok;
                $biayaAdmin = $datas->kop_tagihan_bulan_peserta_bunga;
                $kasMasuk = $datas->kop_tagihan_bulan_peserta_nominal;
                $headerJurnal = [
                    'jurnal_tgl' => now()->format('Y-m-d'),
                    'jurnal_keterangan' => "Setoran Simpanan Wajib Anggota Dengan No Setoran. " . $datas->kop_tagihan_bulan_peserta_code . " an. " . $datas->kop_master_peserta_name . " ( " . $datas->kop_master_peserta_nip . " ) ",
                    'jurnal_ref_table' => 'kop_tagihan_bulan_peserta',
                    'jurnal_ref_code' => $request->code,
                    'jurnal_user' => Auth::user()->userid,
                    'jurnal_cabang' => $datas->kop_master_peserta_cabang,
                ];
                $set = DB::table('kop_fin_master_coa_set')
                    ->where('fin_master_coa_set_cabang', $datas->kop_master_peserta_cabang)
                    ->where('fin_master_coa_set_type', '=', 'simpanan_wajib')->first();
                if ($request->akun == "") {
                    $akun_pencairan = $set->fin_master_coa_set_kredit;
                } else {
                    $akun_pencairan = $request->akun;
                }
                if ($biayaAdmin == 0) {
                    $detailJurnal = [
                        ['coa_code' => $akun_pencairan, 'jurnal_debit' => $kasMasuk, 'jurnal_kredit' => 0], // Piutang Anggota
                        ['coa_code' => $set->fin_master_coa_set_kredit, 'jurnal_debit' => 0, 'jurnal_kredit' => $nominalPokok],    // Kas/Bank Koperasi
                    ];
                } else {
                    $detailJurnal = [
                        ['coa_code' => $akun_pencairan, 'jurnal_debit' => $kasMasuk, 'jurnal_kredit' => 0], // Piutang Anggota
                        ['coa_code' => $set->fin_master_coa_set_adm, 'jurnal_debit' => 0, 'jurnal_kredit' => $biayaAdmin],   // Pendapatan Admin
                        ['coa_code' => $set->fin_master_coa_set_kredit, 'jurnal_debit' => 0, 'jurnal_kredit' => $nominalPokok],    // Kas/Bank Koperasi
                    ];
                }

                $this->accountingService->createJournal($headerJurnal, $detailJurnal);

                DB::table('kop_log_tagihan_bulan')->insert([
                    'kop_log_tagihan_bulan_code' => str::uuid(),
                    'kop_tagihan_bulan_peserta_code' => $datas->kop_tagihan_bulan_peserta_code,
                    'kop_log_tagihan_bulan_pokok' => $datas->kop_tagihan_bulan_peserta_pokok,
                    'kop_log_tagihan_bulan_bunga' => $datas->kop_tagihan_bulan_peserta_bunga,
                    'kop_log_tagihan_bulan_nominal' => $datas->kop_tagihan_bulan_peserta_nominal,
                    'kop_log_tagihan_bulan_date' => $datas->kop_tagihan_bulan_peserta_date,
                    'kop_log_tagihan_bulan_status' => 0,
                    'created_at' => now(),
                ]);
            }
            DB::table('kop_tagihan_bulan_peserta')->where('kop_tagihan_bulan_peserta_code', $datas->kop_tagihan_bulan_peserta_code)->update([
                'kop_tagihan_bulan_peserta_status' => 1
            ]);
        }
        DB::table('kop_tagihan_bulan')->where('kop_tagihan_bulan_code', $request->code)->update([
            'kop_tagihan_bulan_status' => 2,
            'updated_at' => now()
        ]);
        return 1;
    }
    // MENU SIMPANAN SUKARELA
    public function menu_koperasi_sukarela($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('kop_simpanan_sukarela')
                ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_simpanan_sukarela.kop_master_peserta_code')
                ->where('kop_master_peserta_cabang', Auth::user()->access_cabang)->orderBy('id_kop_simpanan_sukarela', 'desc')
                ->get();
            return view('app-koperasi.menu-simpanan-sukarela', compact('data'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_sukarela_add(Request $request)
    {
        $peserta = DB::table('kop_master_peserta')->get();
        return view('app-koperasi.menu-simpanan-sukarela.form-add-simpanan-sukarela', compact('peserta'));
    }
    public function menu_koperasi_sukarela_save(Request $request)
    {
        try {
            $kode = 'SS-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
            $angka_bersih = str_replace('.', '', $request->nominal);

            // Ubah menjadi tipe data integer
            $nominal = (int)$angka_bersih;
            DB::table('kop_simpanan_sukarela')->insert([
                'kop_simpanan_sukarela_code' => $kode,
                'kop_master_peserta_code' => $request->anggota,
                'kop_tagihan_bulan_peserta_pokok' => $nominal - (($request->bunga / 100) * $nominal),
                'kop_tagihan_bulan_peserta_bunga' => $request->bunga,
                'kop_tagihan_bulan_peserta_nominal' => $nominal,
                'kop_simpanan_sukarela_date' => $request->tanggal_simpan,
                'kop_simpanan_sukarela_status' => 0,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function menu_koperasi_sukarela_proses(Request $request)
    {
        $data = DB::table('kop_simpanan_sukarela')->where('kop_simpanan_sukarela_code', $request->code)->first();
        $akun = DB::table('kop_fin_master_coa')->get();
        return view('app-koperasi.menu-simpanan-sukarela.form-proses-simpanan-sukarela', compact('data', 'akun'));
    }
    public function menu_koperasi_sukarela_proses_save(Request $request)
    {
        $data = DB::table('kop_simpanan_sukarela')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_simpanan_sukarela.kop_master_peserta_code')
            ->where('kop_simpanan_sukarela_code', $request->code)->first();
        // try {
        $nominalPokok = $data->kop_tagihan_bulan_peserta_pokok;
        $biayaAdmin = $data->kop_tagihan_bulan_peserta_nominal - $data->kop_tagihan_bulan_peserta_pokok;
        $kasMasuk = $data->kop_tagihan_bulan_peserta_nominal;
        $headerJurnal = [
            'jurnal_tgl' => now()->format('Y-m-d'),
            'jurnal_keterangan' => "Setoran Simpanan Sukarela Anggota Dengan No Simpanan Sukarela. " . $data->kop_simpanan_sukarela_code . " an. " . $data->kop_master_peserta_name . " ( " . $data->kop_master_peserta_nip . " ) ",
            'jurnal_ref_table' => 'kop_simpanan_sukarela',
            'jurnal_ref_code' => $request->code,
            'jurnal_user' => $data->kop_master_peserta_code,
            'jurnal_cabang' => $data->kop_master_peserta_cabang,
        ];
        $set = DB::table('kop_fin_master_coa_set')
            ->where('fin_master_coa_set_cabang', $data->kop_master_peserta_cabang)
            ->where('fin_master_coa_set_type', '=', 'simpanan_sukarela')->first();
        if ($request->akun == "") {
            $akun_pencairan = $set->fin_master_coa_set_kredit;
        } else {
            $akun_pencairan = $request->akun;
        }
        if ($biayaAdmin == 0) {
            $detailJurnal = [
                ['coa_code' => $akun_pencairan, 'jurnal_debit' => $kasMasuk, 'jurnal_kredit' => 0], // Piutang Anggota
                ['coa_code' => $set->fin_master_coa_set_kredit, 'jurnal_debit' => 0, 'jurnal_kredit' => $nominalPokok],    // Kas/Bank Koperasi
            ];
        } else {
            $detailJurnal = [
                ['coa_code' => $akun_pencairan, 'jurnal_debit' => $kasMasuk, 'jurnal_kredit' => 0], // Piutang Anggota
                ['coa_code' => $set->fin_master_coa_set_adm, 'jurnal_debit' => 0, 'jurnal_kredit' => $biayaAdmin],   // Pendapatan Admin
                ['coa_code' => $set->fin_master_coa_set_kredit, 'jurnal_debit' => 0, 'jurnal_kredit' => $nominalPokok],    // Kas/Bank Koperasi
            ];
        }

        $this->accountingService->createJournal($headerJurnal, $detailJurnal);

        DB::table('kop_log_simpanan_sukarela')->insert([
            'kop_log_simpanan_sukarela_code' => str::uuid(),
            'kop_simpanan_sukarela_code' => $data->kop_simpanan_sukarela_code,
            'kop_log_simpanan_sukarela_pokok' => $data->kop_tagihan_bulan_peserta_pokok,
            'kop_log_simpanan_sukarela_bunga' => $data->kop_tagihan_bulan_peserta_bunga,
            'kop_log_simpanan_sukarela_nominal' => $data->kop_tagihan_bulan_peserta_nominal,
            'kop_log_simpanan_sukarela_date' => $data->kop_simpanan_sukarela_date,
            'kop_log_simpanan_sukarela_status' => 0,
            'created_at' => now()
        ]);
        DB::table('kop_simpanan_sukarela')->where('kop_simpanan_sukarela_code', $request->code)->update([
            'kop_simpanan_sukarela_status' => 1,
            'updated_at' => now(),
        ]);
        return 1;
        // } catch (\Throwable $e) {
        //     return 0;
        // }
    }
    // MENU TAGIHAN KOPERASI
    public function menu_koperasi_tagihan_koperasi(Request $request, $akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            // Ambil semua daftar cabang untuk isi dropdown filter
            $list_cabang = Cabang::all();

            return view('app-koperasi.menu-tagihan-koperasi', compact('list_cabang'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_tagihan_koperasi_load(Request $request)
    {
        $query = Tagihan::with(['peserta.cabang']);

        // Filter Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('kop_req_tagihan_date', [$request->start_date, $request->end_date]);
        }

        // Filter Cabang
        if ($request->filled('cabang_id') && $request->cabang_id !== 'semua') {
            $query->whereHas('peserta', function ($q) use ($request) {
                $q->where('kop_master_peserta_cabang', $request->cabang_id);
            });
        }

        $all_tagihan = $query->get();

        // Mengembalikan data terkelompok dalam format JSON
        return response()->json([
            'bulanan' => [
                'total' => $all_tagihan->where('kop_req_tagihan_type', 'bulanan')->sum('kop_req_tagihan_nominal'),
                'data'  => $all_tagihan->where('kop_req_tagihan_type', 'bulanan')->values()
            ],
            'voucher' => [
                'total' => $all_tagihan->where('kop_req_tagihan_type', 'voucher')->sum('kop_req_tagihan_nominal'),
                'data'  => $all_tagihan->where('kop_req_tagihan_type', 'voucher')->values()
            ],
            'peminjaman_uang' => [
                'total' => $all_tagihan->where('kop_req_tagihan_type', 'peminjaman')->sum('kop_req_tagihan_nominal'),
                'data'  => $all_tagihan->where('kop_req_tagihan_type', 'peminjaman')->values()
            ],
            'peminjaman_barang' => [
                'total' => $all_tagihan->where('kop_req_tagihan_type', 'peminjaman')->sum('kop_req_tagihan_nominal'),
                'data'  => $all_tagihan->where('kop_req_tagihan_type', 'peminjaman')->values()
            ],
            'lain' => [
                'total' => $all_tagihan->where('kop_req_tagihan_type', 'lain-lain')->sum('kop_req_tagihan_nominal'),
                'data'  => $all_tagihan->where('kop_req_tagihan_type', 'lain-lain')->values()
            ],
        ]);
    }
    // MENU PEMINJAMAN UANG
    public function menu_peminjaman_uang($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('farm_data_obat')->get();
            return view('app-koperasi.menu-peminjaman.peminjaman-uang', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_peminjaman_uang_cari_peserta(Request $request)
    {
        $data = DB::table('kop_master_peserta')
            ->join('kop_master_cabang', 'kop_master_cabang.kop_master_cabang_code', '=', 'kop_master_peserta.kop_master_peserta_cabang')
            ->join('kop_setup_cabang_koperasi', 'kop_setup_cabang_koperasi.kop_setup_cabang_koperasi_cabang', '=', 'kop_master_peserta.kop_master_peserta_cabang')
            ->where('kop_master_peserta.kop_master_peserta_status', 'AKTIF')
            ->get();
        return view('app-koperasi.menu-peminjaman.peminjaman-uang.form-cari-data', compact('data'));
    }
    public function menu_peminjaman_uang_pilih_peserta(Request $request)
    {
        $status = DB::table('kop_proses_peminjaman_uang')->where('kop_master_peserta_code', $request->code)->whereBetween('kop_proses_uang_status', [0, 1])->first();
        if ($status) {
            return 'Anggota Masih Dalam Proses Peminjaman';
        } else {
            $data = DB::table('kop_master_peserta')
                ->join('kop_master_cabang', 'kop_master_cabang.kop_master_cabang_code', '=', 'kop_master_peserta.kop_master_peserta_cabang')
                ->join('kop_setup_cabang_koperasi', 'kop_setup_cabang_koperasi.kop_setup_cabang_koperasi_cabang', '=', 'kop_master_peserta.kop_master_peserta_cabang')
                ->where('kop_master_peserta.kop_master_peserta_code', $request->code)->first();
            $kcb = DB::table('kop_user_verifikasi')
                ->where('kop_user_verifikasi_cabang', $data->kop_master_peserta_cabang)
                ->where('kop_user_verifikasi_job', 0)->get();
            $mgr = DB::table('kop_user_verifikasi')
                ->where('kop_user_verifikasi_cabang', $data->kop_master_peserta_cabang)
                ->where('kop_user_verifikasi_job', 1)->get();
            return view('app-koperasi.menu-peminjaman.peminjaman-uang.form-peminjaman-uang', ['data' => $data, 'kcb' => $kcb, 'mgr' => $mgr]);
        }
    }
    public function menu_peminjaman_uang_proses_pengajuan(Request $request)
    {
        try {
            $integer = preg_replace('/[^0-9]/', '', $request->nominal_pinjam);
            $kode = 'PU-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
            DB::table('kop_proses_peminjaman_uang')->insert([
                'kop_proses_uang_code' => $kode,
                'kop_master_peserta_code' => $request->peserta_koperasi,
                'kop_proses_uang_nominal' => $integer,
                'kop_proses_uang_tgl' => $request->tgl_pinjam,
                'kop_proses_uang_tenor' => $request->tenor,
                'kop_proses_uang_bunga' => $request->bunga_pinjam,
                'kop_proses_uang_admin' => $request->biaya_admin,
                'kop_proses_uang_kacab' => $request->kepala_cabang,
                'kop_proses_uang_ketua' => $request->ketua_koperasi,
                'kop_proses_uang_keperluan' => $request->keperluan,
                'kop_proses_uang_user' => Auth::user()->userid,
                'kop_proses_uang_status' => 0,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }

    // MENU PEMINJAMAN BARANG
    public function menu_peminjaman_barang($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('farm_data_obat')->get();
            return view('app-koperasi.menu-peminjaman.peminjaman-barang', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_peminjaman_barang_cari_peserta(Request $request)
    {
        $data = DB::table('kop_master_peserta')
            ->join('kop_master_cabang', 'kop_master_cabang.kop_master_cabang_code', '=', 'kop_master_peserta.kop_master_peserta_cabang')
            ->join('kop_setup_cabang_koperasi', 'kop_setup_cabang_koperasi.kop_setup_cabang_koperasi_cabang', '=', 'kop_master_peserta.kop_master_peserta_cabang')
            ->where('kop_master_peserta.kop_master_peserta_status', 'AKTIF')
            ->get();
        return view('app-koperasi.menu-peminjaman.peminjaman-barang.form-cari-data', compact('data'));
    }
    public function menu_peminjaman_barang_pilih_peserta(Request $request)
    {
        $data = DB::table('kop_master_peserta')
            ->join('kop_master_cabang', 'kop_master_cabang.kop_master_cabang_code', '=', 'kop_master_peserta.kop_master_peserta_cabang')
            ->join('kop_setup_cabang_koperasi', 'kop_setup_cabang_koperasi.kop_setup_cabang_koperasi_cabang', '=', 'kop_master_peserta.kop_master_peserta_cabang')
            ->where('kop_master_peserta.kop_master_peserta_code', $request->code)->first();
        $kcb = DB::table('kop_user_verifikasi')
            ->where('kop_user_verifikasi_cabang', $data->kop_master_peserta_cabang)
            ->where('kop_user_verifikasi_job', 0)->get();
        $mgr = DB::table('kop_user_verifikasi')
            ->where('kop_user_verifikasi_cabang', $data->kop_master_peserta_cabang)
            ->where('kop_user_verifikasi_job', 1)->get();
        return view('app-koperasi.menu-peminjaman.peminjaman-barang.form-peminjaman-barang', ['data' => $data, 'kcb' => $kcb, 'mgr' => $mgr]);
    }
    public function menu_peminjaman_barang_proses_pengajuan(Request $request)
    {
        try {
            $integer = preg_replace('/[^0-9]/', '', $request->nominal_pinjam);
            $kode = 'PB-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
            DB::table('kop_proses_peminjaman_brg')->insert([
                'kop_proses_brg_code' => $kode,
                'kop_master_peserta_code' => $request->peserta_koperasi,
                'kop_proses_brg_nominal' => $integer,
                'kop_proses_brg_tgl' => $request->tgl_pinjam,
                'kop_proses_brg_tenor' => $request->tenor,
                'kop_proses_brg_bunga' => $request->bunga_pinjam,
                'kop_proses_brg_admin' => $request->biaya_admin,
                'kop_proses_brg_kacab' => $request->kepala_cabang,
                'kop_proses_brg_ketua' => $request->ketua_koperasi,
                'kop_proses_brg_keperluan' => $request->keperluan,
                'kop_proses_brg_file' => '123',
                'kop_proses_brg_user' => Auth::user()->userid,
                'kop_proses_brg_status' => 0,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    // MENU LIST PEMINJAMAN
    public function menu_peminjaman_list($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('kop_proses_peminjaman_uang')
                ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_proses_peminjaman_uang.kop_master_peserta_code')
                ->orderBy('id_kop_proses_uang', 'desc')
                ->get();
            return view('app-koperasi.menu-peminjaman.peminjaman-list-data', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_peminjaman_list_proses_pengajuan(Request $request)
    {
        $data = DB::table('kop_master_peserta')
            ->join('kop_proses_peminjaman_uang', 'kop_proses_peminjaman_uang.kop_master_peserta_code', '=', 'kop_master_peserta.kop_master_peserta_code')
            ->where('kop_proses_uang_code', $request->code)->first();
        $akun = DB::table('kop_fin_master_coa')->where('coa_type', 'aset')->get();
        return view('app-koperasi.menu-peminjaman.peminjaman-list.form-proses-pengajuan', compact('akun'), ['code' => $request->code, 'data' => $data]);
    }
    public function menu_peminjaman_list_proses_pengajuan_send_verif(Request $request)
    {
        try {
            $data = DB::table('kop_proses_peminjaman_uang')->where('kop_proses_uang_code', $request->code)->first();

            // DATA KETUA
            $ketua = DB::table('kop_proses_verif')->where('kop_proses_uang_code', $request->code)->where('kop_proses_verif_user', $data->kop_proses_uang_ketua)->first();
            if ($ketua) {
            } else {
                $userketua = DB::table('kop_user_verifikasi')->where('kop_user_verifikasi_code', $data->kop_proses_uang_ketua)->first();
                DB::table('kop_proses_verif')->insert([
                    'kop_proses_verif_code' => str::uuid(),
                    'kop_proses_uang_code' => $request->code,
                    'kop_proses_verif_user' => $data->kop_proses_uang_ketua,
                    'kop_proses_verif_status' => 0,
                    'created_at' => now()
                ]);
                $nomorhp = $userketua->kop_user_verifikasi_whatsapp;
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
                $verifikasi = DB::table('kop_proses_verif')->where('kop_proses_uang_code', $request->code)->where('kop_proses_verif_user', $data->kop_proses_uang_ketua)->first();
                $link = route('data_peminjaman_uang', ['code' => $verifikasi->kop_proses_verif_code]);
                $text = "Halo " . $userketua->kop_user_verifikasi_name . "\nAda Pengajuan Peminjaman silahkan Untuk Melihat data di bawah ini :\n\n" . $link . "\n\nSystem Notifikasi";
                DB::table('kop_sender_wa')->insert([
                    'kop_sender_wa_code' => str::uuid(),
                    'kop_sender_wa_code_token' => str::uuid(),
                    'kop_sender_wa_code_number' => $nomorhp,
                    'kop_sender_wa_code_name' => $userketua->kop_user_verifikasi_name,
                    'kop_sender_wa_code_filename' => 'nofile',
                    'kop_sender_wa_code_text' => $text,
                    'kop_sender_wa_code_file' => 'N',
                    'kop_sender_wa_code_picture' => 0,
                    'kop_sender_wa_code_status' => 0,
                    'kop_sender_wa_code_date' => now(),
                    'kop_sender_wa_code_pass' => 'admin',
                    'kop_sender_wa_code_user' => Auth::user()->userid,
                    'created_at' => now()
                ]);
            }
            return 'Berhasil Kirim';
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function menu_peminjaman_list_proses_pengajuan_save_verif(Request $request)
    {
        try {
            $data = DB::table('kop_proses_peminjaman_uang')
                ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_proses_peminjaman_uang.kop_master_peserta_code')
                ->where('kop_proses_peminjaman_uang.kop_proses_uang_code', $request->code)->first();
            $pokok = $data->kop_proses_uang_nominal / $data->kop_proses_uang_tenor;
            $suku_bunga = ($data->kop_proses_uang_nominal * ($data->kop_proses_uang_bunga / 100)) / $data->kop_proses_uang_tenor;
            $ttd = 0;
            $kcb = DB::table('kop_proses_verif')
                ->where('kop_proses_uang_code', $request->code)
                ->where('kop_proses_verif_user', $data->kop_proses_uang_kacab)
                ->where('kop_proses_verif_status', 1)
                ->first();
            if ($kcb) {
                $ttd = $ttd + 1;
            }
            $ketua = DB::table('kop_proses_verif')
                ->where('kop_proses_uang_code', $request->code)
                ->where('kop_proses_verif_user', $data->kop_proses_uang_ketua)
                ->where('kop_proses_verif_status', 1)
                ->first();
            if ($ketua) {
                $ttd = $ttd + 1;
            }
            if ($ttd == 2) {
                for ($i = 1; $i <= $data->kop_proses_uang_tenor; $i++) {
                    $token = DB::table('kop_log_peminjaman_uang')
                        ->where('kop_proses_uang_code', $request->code)
                        ->where('kop_log_peminjaman_uang_tenor', $i)
                        ->first();
                    if (!$token) {
                        DB::table('kop_log_peminjaman_uang')->insert([
                            'kop_log_peminjaman_uang_code' => str::uuid(),
                            'kop_proses_uang_code' => $request->code,
                            'kop_log_peminjaman_uang_tenor' => $i,
                            'kop_log_peminjaman_uang_pokok' => $pokok,
                            'kop_log_peminjaman_uang_bunga' => $suku_bunga,
                            'kop_log_peminjaman_uang_nominal' => $pokok + $suku_bunga,
                            'kop_log_peminjaman_uang_date' => date('Y-m-d', strtotime('+' . $i . ' month', strtotime($data->kop_proses_uang_tgl))),
                            'kop_log_peminjaman_uang_cat' => 'pinjaman_uang',
                            'kop_log_peminjaman_uang_token' => str::uuid(),
                            'kop_log_peminjaman_uang_status' => 0,
                            'created_at' => now()
                        ]);
                    }
                }

                $nominalPokok = $data->kop_proses_uang_nominal;
                $biayaAdmin = ($data->kop_proses_uang_admin / 100) * $data->kop_proses_uang_nominal;
                $kasKeluar = $nominalPokok - $biayaAdmin;
                $headerJurnal = [
                    'jurnal_tgl' => now()->format('Y-m-d'),
                    'jurnal_keterangan' => "Pencairan Pinjaman Uang Dengan No Pengajuan. " . $data->kop_proses_uang_code . " an. " . $data->kop_master_peserta_name . " ( " . $data->kop_master_peserta_nip . " ) ",
                    'jurnal_ref_table' => 'kop_proses_peminjaman_uang',
                    'jurnal_ref_code' => $request->code,
                    'jurnal_user' => $data->kop_master_peserta_code,
                    'jurnal_cabang' => $data->kop_master_peserta_cabang,
                ];
                $set = DB::table('kop_fin_master_coa_set')
                    ->where('fin_master_coa_set_cabang', $data->kop_master_peserta_cabang)
                    ->where('fin_master_coa_set_type', '=', 'pinjaman_uang')->first();
                if ($request->akun == "") {
                    $akun_pencairan = $set->fin_master_coa_set_kredit;
                } else {
                    $akun_pencairan = $request->akun;
                }
                if ($biayaAdmin == 0) {
                    $detailJurnal = [
                        ['coa_code' => $set->fin_master_coa_set_debit, 'jurnal_debit' => $nominalPokok, 'jurnal_kredit' => 0], // Piutang Anggota
                        ['coa_code' => $akun_pencairan, 'jurnal_debit' => 0, 'jurnal_kredit' => $kasKeluar],    // Kas/Bank Koperasi
                    ];
                } else {
                    $detailJurnal = [
                        ['coa_code' => $set->fin_master_coa_set_debit, 'jurnal_debit' => $nominalPokok, 'jurnal_kredit' => 0], // Piutang Anggota
                        ['coa_code' => $set->fin_master_coa_set_adm, 'jurnal_debit' => 0, 'jurnal_kredit' => $biayaAdmin],   // Pendapatan Admin
                        ['coa_code' => $akun_pencairan, 'jurnal_debit' => 0, 'jurnal_kredit' => $kasKeluar],    // Kas/Bank Koperasi
                    ];
                }

                // Aturan Akuntansi: Debit (Piutang), Kredit (Pendapatan Admin & Kas)

                // 3. Eksekusi Jurnal
                $this->accountingService->createJournal($headerJurnal, $detailJurnal);
                // Perubahan Data
                DB::table('kop_proses_peminjaman_uang')->where('kop_proses_uang_code', $request->code)->update([
                    'kop_proses_uang_status' => 1,
                    'updated_at' => now(),
                ]);
                return 1;
            } else {
                return 'Pastikan Sudah di Sign';
            }
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function menu_peminjaman_list_cetak_slip_pengajuan(Request $request)
    {
        return view('app-koperasi.menu-peminjaman.peminjaman-list.form-report-slip', ['code' => $request->code]);
    }
    public function menu_peminjaman_list_cetak_slip_pengajuan_report(Request $request)
    {
        $data = DB::table('kop_master_peserta')
            ->join('kop_proses_peminjaman_uang', 'kop_proses_peminjaman_uang.kop_master_peserta_code', '=', 'kop_master_peserta.kop_master_peserta_code')
            ->where('kop_proses_uang_code', $request->code)->first();
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('app-koperasi.menu-peminjaman.peminjaman-list.report.report-slip-peminjaman-uang', compact('image', 'data'), [
            'code' => $request->code
        ])->setPaper('A4', 'landscape')->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $font1 = $dompdf->getFontMetrics()->get_font("helvetica", "normal");
        $dompdf->get_canvas()->page_text(300, 560, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
        // $dompdf->get_canvas()->page_text(34, 390, "Note. Slip elektronik Ini Simpan Sebagai Bukti", $font1, 10, array(0, 5, 1));
        $dompdf->get_canvas()->page_text(350, 560, "Print by. " . Auth::user()->fullname, $font1, 10, array(0, 0, 0));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 875, 823);
            ');
        return base64_encode($pdf->stream());
    }
    public function menu_peminjaman_list_cetak_pengajuan(Request $request)
    {
        return view('app-koperasi.menu-peminjaman.peminjaman-list.form-report-data-pengajuan', ['code' => $request->code]);
    }
    public function menu_peminjaman_list_cetak_pengajuan_report(Request $request)
    {
        $data = DB::table('kop_master_peserta')
            ->join('kop_proses_peminjaman_uang', 'kop_proses_peminjaman_uang.kop_master_peserta_code', '=', 'kop_master_peserta.kop_master_peserta_code')
            ->where('kop_proses_uang_code', $request->code)->first();
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('app-koperasi.menu-peminjaman.peminjaman-list.report.report-pengajuan-peminjaman', compact('image', 'data'), [
            'code' => $request->code
        ])->setPaper('A5', 'landscape')->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $font1 = $dompdf->getFontMetrics()->get_font("helvetica", "normal");
        $dompdf->get_canvas()->page_text(300, 390, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
        // $dompdf->get_canvas()->page_text(34, 390, "Note. Slip elektronik Ini Simpan Sebagai Bukti", $font1, 10, array(0, 5, 1));
        $dompdf->get_canvas()->page_text(350, 390, "Print by. " . Auth::user()->fullname, $font1, 10, array(0, 0, 0));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 575, 823);
            ');
        return base64_encode($pdf->stream());
    }
    public function menu_peminjaman_list_cek_kontrak(Request $request)
    {
        $data = DB::table('kop_master_peserta')
            ->join('kop_proses_peminjaman_uang', 'kop_proses_peminjaman_uang.kop_master_peserta_code', '=', 'kop_master_peserta.kop_master_peserta_code')
            ->where('kop_proses_uang_code', $request->code)->first();
        $lunas = DB::table('kop_log_peminjaman_uang')->where('kop_proses_uang_code', $request->code)->where('kop_log_peminjaman_uang_status', 1)->count();
        return view('app-koperasi.menu-peminjaman.peminjaman-list.form-kontrak', compact('lunas'), ['code' => $request->code, 'data' => $data]);
    }
    public function menu_peminjaman_list_cek_kontrak_payment(Request $request)
    {
        $data = DB::table('kop_log_peminjaman_uang')->where('kop_log_peminjaman_uang_code', $request->code)->first();
        $akun = DB::table('kop_fin_master_coa')->where('coa_type', 'aset')->get();
        return view('app-koperasi.menu-peminjaman.peminjaman-list.form-payment-kontrak', compact('akun'), ['data' => $data]);
    }
    public function menu_peminjaman_list_cek_kontrak_payment_fix(Request $request)
    {

        $data = DB::table('kop_log_peminjaman_uang')
            ->join('kop_proses_peminjaman_uang', 'kop_proses_peminjaman_uang.kop_proses_uang_code', '=', 'kop_log_peminjaman_uang.kop_proses_uang_code')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_proses_peminjaman_uang.kop_master_peserta_code')
            ->where('kop_log_peminjaman_uang.kop_log_peminjaman_uang_code', $request->code)->first();
        // Hitung total uang yang dibayarkan pada angsuran ini
        $pokok = (float) $data->kop_log_peminjaman_uang_pokok;
        $bunga = (float) $data->kop_log_peminjaman_uang_bunga;
        $totalNominalLog = $pokok + $bunga;

        $headerJurnal = [
            'jurnal_tgl' => now()->format('Y-m-d'),
            'jurnal_keterangan' => "Penerimaan Angsuran (Log: {$data->kop_log_peminjaman_uang_code}) Tenor ke : {$data->kop_log_peminjaman_uang_tenor} - Dengan No Pengajuan : {$data->kop_proses_uang_code} (An : {$data->kop_master_peserta_name} ( {$data->kop_master_peserta_nip} ))",
            'jurnal_ref_table' => 'kop_log_peminjaman_uang',
            'jurnal_ref_code' => $request->code,
            'jurnal_user' => $data->kop_master_peserta_code,
            'jurnal_cabang' => $data->kop_master_peserta_cabang,
        ];
        $set = DB::table('kop_fin_master_coa_set')
            ->where('fin_master_coa_set_cabang', $data->kop_master_peserta_cabang)
            ->where('fin_master_coa_set_type', '=', 'angsuran_pinjaman_uang')->first();
        if ($request->akun == "") {
            $akun = $set->fin_master_coa_set_debit;
        } else {
            $akun = $request->akun;
        }

        // 6. Insert Detail Jurnal Berdasarkan Data dari Sub-Table Log
        if ($bunga == 0) {
            # code...
            $detailJurnal = [
                ['coa_code' => $akun, 'jurnal_debit' => $totalNominalLog, 'jurnal_kredit' => 0], // Piutang Anggota
                ['coa_code' => $set->fin_master_coa_set_kredit, 'jurnal_debit' => 0, 'jurnal_kredit' => $pokok],    // Kas/Bank Koperasi
            ];
        } else {
            $detailJurnal = [
                ['coa_code' => $akun, 'jurnal_debit' => $totalNominalLog, 'jurnal_kredit' => 0], // Piutang Anggota
                ['coa_code' => $set->fin_master_coa_set_bunga, 'jurnal_debit' => 0, 'jurnal_kredit' => $bunga],    // Kas/Bank Koperasi
                ['coa_code' => $set->fin_master_coa_set_kredit, 'jurnal_debit' => 0, 'jurnal_kredit' => $pokok],    // Kas/Bank Koperasi
            ];
        }


        // 3. Eksekusi Jurnal
        $this->accountingService->createJournal($headerJurnal, $detailJurnal);


        DB::table('kop_log_peminjaman_uang')->where('kop_log_peminjaman_uang_code', $request->code)->update([
            'kop_log_peminjaman_uang_status' => 1,
            'updated_at' => now(),
        ]);
        return 'Berhasil Payment';
    }
    public function menu_peminjaman_list_cek_kontrak_payment_multi(Request $request)
    {
        // 1. Validasi Input Data
        $data = DB::table('kop_proses_peminjaman_uang')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_proses_peminjaman_uang.kop_master_peserta_code')
            ->where('kop_proses_peminjaman_uang.kop_proses_uang_code', $request->kop_proses_uang_code)->first();
        $request->validate([
            'kop_proses_uang_code' => 'required',
            'log_codes'            => 'required|array|min:1',
            'payment_coa_code'     => 'required',
        ], [
            'log_codes.required'        => 'Pilih minimal satu bulan tagihan yang ingin dilunasi.',
            'payment_coa_code.required' => 'Metode pembayaran (Akun COA) wajib dipilih.',
        ]);

        DB::beginTransaction();

        try {
            $prosesUangCode = $request->kop_proses_uang_code;
            $logCodes       = $request->log_codes; // Berisi array kop_log_peminjaman_uang_code
            $paymentCoa     = $request->payment_coa_code; // COA Kas/Bank pilihan user

            // Tampungan hitungan akumulasi nilai untuk kebutuhan entry jurnal
            $totalPokokDiterima = 0;
            $totalBungaDiterima = 0;
            $grandTotalDiterima = 0;
            $tenorTerbayar      = [];

            // 2. Loop pertama: Validasi status dan akumulasi nominal angsuran
            foreach ($logCodes as $code) {
                $logPeminjaman = DB::table('kop_log_peminjaman_uang')
                    ->where('kop_log_peminjaman_uang_code', $code)
                    ->first();

                if (!$logPeminjaman) {
                    throw new Exception("Detail tagihan dengan kode {$code} tidak ditemukan.");
                }

                // Cek jika status sudah bernilai '1' (Lunas)
                if ($logPeminjaman->kop_log_peminjaman_uang_status == '1') {
                    throw new Exception("Tagihan tenor ke-{$logPeminjaman->kop_log_peminjaman_uang_tenor} sudah berstatus lunas.");
                }

                // Akumulasikan nilai berdasarkan data asli di baris tabel log
                $totalPokokDiterima += $logPeminjaman->kop_log_peminjaman_uang_pokok;
                $totalBungaDiterima += $logPeminjaman->kop_log_peminjaman_uang_bunga * (10 / 100);
                $grandTotalDiterima += $logPeminjaman->kop_log_peminjaman_uang_nominal;
                $tenorTerbayar[]     = $logPeminjaman->kop_log_peminjaman_uang_tenor;

                // UPDATE STATUS LOG PEMINJAMAN MENJADI LUNAS ('1')
                DB::table('kop_log_peminjaman_uang')
                    ->where('kop_log_peminjaman_uang_code', $code)
                    ->update([
                        'kop_log_peminjaman_uang_status' => '1',
                        'updated_at'                     => now()
                    ]);
            }

            // Generate Nomor Bukti Jurnal Masuk (BKM)
            $periodeYm = date('Ym');
            $latestJurnal = DB::table('kop_fin_jurnal')
                ->where('jurnal_no_bukti', 'LIKE', "BKM-{$periodeYm}-%")
                ->orderBy('jurnal_no_bukti', 'desc')
                ->first();

            if ($latestJurnal) {
                $lastNum = (int) substr($latestJurnal->jurnal_no_bukti, -4);
                $nextNum = sprintf('%04d', $lastNum + 1);
            } else {
                $nextNum = '0001';
            }
            $noBukti = $header['jurnal_no_bukti'] ?? 'JV-' . now()->format('Ymd') . '-' . strtoupper(uniqid());

            // 3. INSERT HEADER JURNAL (kop_fin_jurnal)
            $stringTenor = implode(', ', $tenorTerbayar);
            $idJurnalHeader = DB::table('kop_fin_jurnal')->insertGetId([
                'jurnal_no_bukti'   => $noBukti,
                'jurnal_tgl'        => date('Y-m-d'),
                'jurnal_keterangan' => "Pelunasan Angsuran Tenor [{$stringTenor}] - Dengan No Pengajuan : {$prosesUangCode} (An : {$data->kop_master_peserta_name} ( {$data->kop_master_peserta_nip} ))",
                'jurnal_ref_table'  => 'kop_proses_peminjaman_uang',
                'jurnal_ref_code'   => $prosesUangCode,
                'jurnal_user'       => $data->kop_master_peserta_code,
                'jurnal_cabang'     => $data->kop_master_peserta_cabang,
                'jurnal_created'    => now(),
                'created_at'        => now()
            ]);

            // 4. INSERT DETAIL JURNAL - DEBIT (Kas/Bank bertambah sebesar Grand Total)
            DB::table('kop_fin_jurnal_detail')->insert([
                'jurnal_id'     => $idJurnalHeader,
                'coa_code'      => $paymentCoa,
                'jurnal_debit'  => $totalPokokDiterima + $totalBungaDiterima,
                'jurnal_kredit' => 0,
                'created_at'    => now()
            ]);

            // 5. INSERT DETAIL JURNAL - KREDIT (Piutang Pokok Berkurang)
            // *Catatan: Sesuaikan '11301' dengan COA Piutang Pokok Peminjaman Anda
            $set = DB::table('kop_fin_master_coa_set')
                ->where('fin_master_coa_set_cabang', $data->kop_master_peserta_cabang)
                ->where('fin_master_coa_set_type', '=', 'angsuran_pinjaman_uang')->first();

            $coaPiutangPokok = $set->fin_master_coa_set_kredit;
            DB::table('kop_fin_jurnal_detail')->insert([
                'jurnal_id'     => $idJurnalHeader,
                'coa_code'      => $coaPiutangPokok,
                'jurnal_debit'  => 0,
                'jurnal_kredit' => $totalPokokDiterima,
                'created_at'    => now()
            ]);

            // 6. INSERT DETAIL JURNAL - KREDIT (Pendapatan Bunga Berkurang / Bertambah di Kredit)
            // *Catatan: Sesuaikan '41101' dengan COA Pendapatan Bunga Peminjaman Anda
            if ($totalBungaDiterima > 0) {
                $coaPendapatanBunga = $set->fin_master_coa_set_bunga;
                DB::table('kop_fin_jurnal_detail')->insert([
                    'jurnal_id'     => $idJurnalHeader,
                    'coa_code'      => $coaPendapatanBunga,
                    'jurnal_debit'  => 0,
                    'jurnal_kredit' => $totalBungaDiterima,
                    'created_at'    => now()
                ]);
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => count($logCodes) . ' bulan angsuran (Tenor: ' . $stringTenor . ') berhasil dilunasi. No Bukti: ' . $noBukti
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal memproses pelunasan: ' . $e->getMessage()
            ], 500);
        }
    }
    public function menu_peminjaman_list_cek_kontrak_penyelesaian_kontrak(Request $request)
    {
        $data = DB::table('kop_proses_peminjaman_uang')->where('kop_proses_uang_code', $request->code)->first();
        $log = DB::table('kop_log_peminjaman_uang')->where('kop_proses_uang_code', $request->code)->where('kop_log_peminjaman_uang_status', 1)->count();
        if ($data->kop_proses_uang_tenor == $log) {
            DB::table('kop_proses_peminjaman_uang')->where('kop_proses_uang_code', $request->code)->update([
                'kop_proses_uang_status' => 2,
                'updated_at' => now()
            ]);
            return 1;
        } else {
            return 0;
        }
    }
    public function menu_peminjaman_list_proses_pengajuan_baru(Request $request)
    {
        $data = DB::table('kop_proses_peminjaman_uang')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_proses_peminjaman_uang.kop_master_peserta_code')
            ->join('kop_setup_cabang_koperasi', 'kop_setup_cabang_koperasi.kop_setup_cabang_koperasi_cabang', '=', 'kop_master_peserta.kop_master_peserta_cabang')
            ->where('kop_proses_uang_code', $request->code)->first();
        $akun = DB::table('kop_fin_master_coa')->where('coa_type', 'aset')->get();
        $sisa = DB::table('kop_log_peminjaman_uang')->where('kop_proses_uang_code', $request->code)->where('kop_log_peminjaman_uang_status', '=', 0)->sum('kop_log_peminjaman_uang_nominal');
        return view('app-koperasi.menu-peminjaman.peminjaman-list.form-pengajuan-peminjaman-baru', compact('data', 'sisa', 'akun'), ['code' => $request->code]);
    }
    public function menu_peminjaman_list_proses_pengajuan_baru_save(Request $request)
    {
        try {
            $kode = 'PU-' . now()->format('Ymd') . '-' . strtoupper(uniqid());
            $data = DB::table('kop_proses_peminjaman_uang')
                ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_proses_peminjaman_uang.kop_master_peserta_code')
                ->where('kop_proses_uang_code', $request->kode_peminjaman)->first();
            $integer = preg_replace('/[^0-9]/', '', $request->nominal_pinjam);
            DB::table('kop_proses_peminjaman_uang')->insert([
                'kop_proses_uang_code' => $kode,
                'kop_master_peserta_code' => $data->kop_master_peserta_code,
                'kop_proses_uang_nominal' => $integer,
                'kop_proses_uang_tgl' => $request->tgl_pinjam,
                'kop_proses_uang_tenor' => $request->tenor,
                'kop_proses_uang_bunga' => $request->bunga_pinjam,
                'kop_proses_uang_admin' => $request->biaya_admin,
                'kop_proses_uang_kacab' => $data->kop_proses_uang_kacab,
                'kop_proses_uang_ketua' => $data->kop_proses_uang_ketua,
                'kop_proses_uang_keperluan' => $request->keperluan,
                'kop_proses_uang_user' => Auth::user()->userid,
                'kop_proses_uang_status' => 1,
                'created_at' => now(),
            ]);
            $pokok = $integer / $request->tenor;
            $bunga = ($request->bunga_pinjam / 100) * ($integer / $request->tenor);
            $verif = DB::table('kop_proses_verif')->where('kop_proses_uang_code', $request->kode_peminjaman)->get();
            foreach ($verif as  $value) {
                DB::table('kop_proses_verif')->insert([
                    'kop_proses_verif_code' => str::uuid(),
                    'kop_proses_uang_code' => $kode,
                    'kop_proses_verif_user' => $value->kop_proses_verif_user,
                    'kop_proses_verif_status' => $value->kop_proses_verif_status,
                    'kop_proses_verif_sign' => $value->kop_proses_verif_sign,
                    'kop_proses_verif_date' => now(),
                    'created_at' => now()
                ]);
            }
            for ($i = 1; $i <= $request->tenor; $i++) {
                $token = DB::table('kop_log_peminjaman_uang')
                    ->where('kop_proses_uang_code', $kode)
                    ->where('kop_log_peminjaman_uang_tenor', $i)
                    ->first();
                if (!$token) {
                    DB::table('kop_log_peminjaman_uang')->insert([
                        'kop_log_peminjaman_uang_code' => str::uuid(),
                        'kop_proses_uang_code' => $kode,
                        'kop_log_peminjaman_uang_tenor' => $i,
                        'kop_log_peminjaman_uang_pokok' => $pokok,
                        'kop_log_peminjaman_uang_bunga' => $bunga,
                        'kop_log_peminjaman_uang_nominal' => $pokok + $bunga,
                        'kop_log_peminjaman_uang_date' => date('Y-m-d', strtotime('+' . $i . ' month', strtotime($request->tgl_pinjam))),
                        'kop_log_peminjaman_uang_cat' => 'pinjaman_uang_lanjut',
                        'kop_log_peminjaman_uang_token' => str::uuid(),
                        'kop_log_peminjaman_uang_status' => 0,
                        'created_at' => now()
                    ]);
                }
            }
            DB::table('kop_log_peminjaman_uang')
                ->where('kop_proses_uang_code', $request->kode_peminjaman)->update([
                    'kop_log_peminjaman_uang_status' => 1,
                    'updated_at' => now()
                ]);
            DB::table('kop_proses_peminjaman_uang')
                ->where('kop_proses_uang_code', $request->kode_peminjaman)->update([
                    'kop_proses_uang_status' => 2,
                    'updated_at' => now(),
                ]);
            $nominalPokok = $integer;
            $biayaAdmin = ($request->biaya_admin / 100) * $integer;
            $kasKeluar = $nominalPokok - $biayaAdmin - $request->nominal_tagihan;
            $headerJurnal = [
                'jurnal_tgl' => now()->format('Y-m-d'),
                'jurnal_keterangan' => "Pencairan Pinjaman Lanjutan dari no Pengajuan : " . $request->kode_peminjaman . " ke no Pengajuan Baru : " . $kode . " an. " . $data->kop_master_peserta_name . " ( " . $data->kop_master_peserta_nip . " )",
                'jurnal_ref_table' => 'kop_proses_peminjaman_uang',
                'jurnal_ref_code' => $kode,
                'jurnal_user' => Auth::user()->userid,
                'jurnal_cabang' => $data->kop_master_peserta_cabang,
            ];
            $set = DB::table('kop_fin_master_coa_set')
                ->where('fin_master_coa_set_cabang', $data->kop_master_peserta_cabang)
                ->where('fin_master_coa_set_type', '=', 'lanjut_pinjam_uang')->first();
            if ($request->akun == "") {
                $akun_pencairan = $set->fin_master_coa_set_kredit;
            } else {
                $akun_pencairan = $request->akun;
            }
            if ($biayaAdmin == 0) {
                $detailJurnal = [
                    ['coa_code' => $set->fin_master_coa_set_debit, 'jurnal_debit' => $nominalPokok, 'jurnal_kredit' => 0], // Piutang Anggota
                    ['coa_code' => $set->fin_master_coa_set_kredit, 'jurnal_debit' => 0, 'jurnal_kredit' => $request->nominal_tagihan],    // Kas/Bank Koperasi
                    ['coa_code' => $akun_pencairan, 'jurnal_debit' => 0, 'jurnal_kredit' => $kasKeluar],    // Kas/Bank Koperasi
                ];
            } else {
                $detailJurnal = [
                    ['coa_code' => $set->fin_master_coa_set_debit, 'jurnal_debit' => $nominalPokok, 'jurnal_kredit' => 0], // Piutang Anggota
                    ['coa_code' => $set->fin_master_coa_set_adm, 'jurnal_debit' => 0, 'jurnal_kredit' => $biayaAdmin],   // Pendapatan Admin
                    ['coa_code' => $set->fin_master_coa_set_kredit, 'jurnal_debit' => 0, 'jurnal_kredit' => $request->nominal_tagihan],    // Kas/Bank Koperasi
                    ['coa_code' => $akun_pencairan, 'jurnal_debit' => 0, 'jurnal_kredit' => $kasKeluar],    // Kas/Bank Koperasi
                ];
            }
            // 3. Eksekusi Jurnal
            $this->accountingService->createJournal($headerJurnal, $detailJurnal);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }

    // MENU LIST PEMINJAMAN BARANG
    public function menu_peminjaman_list_barang($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('kop_proses_peminjaman_brg')
                ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_proses_peminjaman_brg.kop_master_peserta_code')
                ->orderBy('id_kop_proses_brg', 'desc')
                ->get();
            return view('app-koperasi.menu-peminjaman.peminjaman-list-barang', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_peminjaman_list_barang_proses_pengajuan(Request $request)
    {
        $data = DB::table('kop_master_peserta')
            ->join('kop_proses_peminjaman_brg', 'kop_proses_peminjaman_brg.kop_master_peserta_code', '=', 'kop_master_peserta.kop_master_peserta_code')
            ->where('kop_proses_brg_code', $request->code)->first();
        $akun = DB::table('kop_fin_master_coa')->where('coa_type', 'aset')->get();
        return view('app-koperasi.menu-peminjaman.peminjaman-list-barang.form-proses-pengajuan-barang', compact('akun'), ['code' => $request->code, 'data' => $data]);
    }
    public function menu_peminjaman_list_barang_proses_pengajuan_send(Request $request)
    {
        try {
            $data = DB::table('kop_proses_peminjaman_brg')->where('kop_proses_brg_code', $request->code)->first();

            // DATA KETUA
            $ketua = DB::table('kop_proses_verif_brg')->where('kop_proses_brg_code', $request->code)->where('kop_proses_verif_brg_user', $data->kop_proses_brg_ketua)->first();
            if ($ketua) {
            } else {
                $userketua = DB::table('kop_user_verifikasi')->where('kop_user_verifikasi_code', $data->kop_proses_brg_ketua)->first();
                DB::table('kop_proses_verif_brg')->insert([
                    'kop_proses_verif_brg_code' => str::uuid(),
                    'kop_proses_brg_code' => $request->code,
                    'kop_proses_verif_brg_user' => $data->kop_proses_brg_ketua,
                    'kop_proses_verif_brg_status' => 0,
                    'created_at' => now()
                ]);
                $nomorhp = $userketua->kop_user_verifikasi_whatsapp;
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
                $verifikasi = DB::table('kop_proses_verif_brg')->where('kop_proses_brg_code', $request->code)->where('kop_proses_verif_brg_user', $data->kop_proses_brg_ketua)->first();
                $link = route('data_peminjaman_barang', ['code' => $verifikasi->kop_proses_verif_brg_code]);
                $text = "Halo " . $userketua->kop_user_verifikasi_name . "\nAda Pengajuan Peminjaman silahkan Untuk Melihat data di bawah ini :\n\n" . $link . "\n\n System Notifikasi";
                DB::table('kop_sender_wa')->insert([
                    'kop_sender_wa_code' => str::uuid(),
                    'kop_sender_wa_code_token' => str::uuid(),
                    'kop_sender_wa_code_number' => $nomorhp,
                    'kop_sender_wa_code_name' => $userketua->kop_user_verifikasi_name,
                    'kop_sender_wa_code_filename' => 'nofile',
                    'kop_sender_wa_code_text' => $text,
                    'kop_sender_wa_code_file' => 'N',
                    'kop_sender_wa_code_picture' => 0,
                    'kop_sender_wa_code_status' => 0,
                    'kop_sender_wa_code_date' => now(),
                    'kop_sender_wa_code_pass' => 'admin',
                    'kop_sender_wa_code_user' => Auth::user()->userid,
                    'created_at' => now()
                ]);
            }
            return 'Berhasil Kirim';
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function menu_peminjaman_list_barang_proses_pengajuan_save(Request $request)
    {
        try {
            $data = DB::table('kop_proses_peminjaman_brg')
                ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_proses_peminjaman_brg.kop_master_peserta_code')
                ->where('kop_proses_peminjaman_brg.kop_proses_brg_code', $request->code)->first();
            $pokok = $data->kop_proses_brg_nominal / $data->kop_proses_brg_tenor;
            $suku_bunga = ($data->kop_proses_brg_nominal * ($data->kop_proses_brg_bunga / 100)) / $data->kop_proses_brg_tenor;
            $ttd = 0;
            $kcb = DB::table('kop_proses_verif_brg')
                ->where('kop_proses_brg_code', $request->code)
                ->where('kop_proses_verif_brg_user', $data->kop_proses_brg_kacab)
                ->where('kop_proses_verif_brg_status', 1)
                ->first();
            if ($kcb) {
                $ttd = $ttd + 1;
            }
            $ketua = DB::table('kop_proses_verif_brg')
                ->where('kop_proses_brg_code', $request->code)
                ->where('kop_proses_verif_brg_user', $data->kop_proses_brg_ketua)
                ->where('kop_proses_verif_brg_status', 1)
                ->first();
            if ($ketua) {
                $ttd = $ttd + 1;
            }
            if ($ttd == 2) {
                for ($i = 1; $i <= $data->kop_proses_brg_tenor; $i++) {
                    $token = DB::table('kop_log_peminjaman_barang')
                        ->where('kop_proses_brg_code', $request->code)
                        ->where('kop_log_peminjaman_brg_tenor', $i)
                        ->first();
                    if (!$token) {
                        DB::table('kop_log_peminjaman_barang')->insert([
                            'kop_log_peminjaman_barang_code' => str::uuid(),
                            'kop_proses_brg_code' => $request->code,
                            'kop_log_peminjaman_brg_tenor' => $i,
                            'kop_log_peminjaman_brg_pokok' => $pokok,
                            'kop_log_peminjaman_brg_bunga' => $suku_bunga,
                            'kop_log_peminjaman_brg_nominal' => $pokok + $suku_bunga,
                            'kop_log_peminjaman_brg_date' => date('Y-m-d', strtotime('+' . $i . ' month', strtotime($data->kop_proses_brg_tgl))),
                            'kop_log_peminjaman_brg_cat' => 'pinjaman_barang',
                            'kop_log_peminjaman_brg_token' => str::uuid(),
                            'kop_log_peminjaman_brg_status' => 0,
                            'created_at' => now()
                        ]);
                    }
                }

                $nominalPokok = $data->kop_proses_brg_nominal;
                $biayaAdmin = ($data->kop_proses_brg_admin / 100) * $data->kop_proses_brg_nominal;
                $kasKeluar = $nominalPokok - $biayaAdmin;
                $headerJurnal = [
                    'jurnal_tgl' => now()->format('Y-m-d'),
                    'jurnal_keterangan' => "Pencairan Pinjaman Barang Dengan No Pengajuan. " . $data->kop_proses_brg_code . " an. " . $data->kop_master_peserta_name . " ( " . $data->kop_master_peserta_nip . " ) ",
                    'jurnal_ref_table' => 'kop_proses_peminjaman_brg',
                    'jurnal_ref_code' => $request->code,
                    'jurnal_user' => $data->kop_master_peserta_code,
                    'jurnal_cabang' => $data->kop_master_peserta_cabang,
                ];
                $set = DB::table('kop_fin_master_coa_set')
                    ->where('fin_master_coa_set_cabang', $data->kop_master_peserta_cabang)
                    ->where('fin_master_coa_set_type', '=', 'pinjaman_barang')->first();
                if ($request->akun == "") {
                    $akun_pencairan = $set->fin_master_coa_set_kredit;
                } else {
                    $akun_pencairan = $request->akun;
                }
                if ($biayaAdmin == 0) {
                    $detailJurnal = [
                        ['coa_code' => $set->fin_master_coa_set_debit, 'jurnal_debit' => $nominalPokok, 'jurnal_kredit' => 0], // Piutang Anggota
                        ['coa_code' => $akun_pencairan, 'jurnal_debit' => 0, 'jurnal_kredit' => $kasKeluar],    // Kas/Bank Koperasi
                    ];
                } else {
                    $detailJurnal = [
                        ['coa_code' => $set->fin_master_coa_set_debit, 'jurnal_debit' => $nominalPokok, 'jurnal_kredit' => 0], // Piutang Anggota
                        ['coa_code' => $set->fin_master_coa_set_adm, 'jurnal_debit' => 0, 'jurnal_kredit' => $biayaAdmin],   // Pendapatan Admin
                        ['coa_code' => $akun_pencairan, 'jurnal_debit' => 0, 'jurnal_kredit' => $kasKeluar],    // Kas/Bank Koperasi
                    ];
                }

                // Aturan Akuntansi: Debit (Piutang), Kredit (Pendapatan Admin & Kas)

                // 3. Eksekusi Jurnal
                $this->accountingService->createJournal($headerJurnal, $detailJurnal);
                // Perubahan Data
                DB::table('kop_proses_peminjaman_brg')->where('kop_proses_brg_code', $request->code)->update([
                    'kop_proses_brg_status' => 1,
                    'updated_at' => now(),
                ]);
                return 1;
            } else {
                return 'Pastikan Sudah di Sign';
            }
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function menu_peminjaman_list_barang_cek_status_kontrak(Request $request)
    {
        $data = DB::table('kop_master_peserta')
            ->join('kop_proses_peminjaman_brg', 'kop_proses_peminjaman_brg.kop_master_peserta_code', '=', 'kop_master_peserta.kop_master_peserta_code')
            ->where('kop_proses_brg_code', $request->code)->first();
        return view('app-koperasi.menu-peminjaman.peminjaman-list-barang.form-kontrak-peminjaman-barang', ['code' => $request->code, 'data' => $data]);
    }
    public function menu_peminjaman_list_barang_cek_status_kontrak_payment(Request $request)
    {
        $data = DB::table('kop_log_peminjaman_barang')->where('kop_log_peminjaman_barang_code', $request->code)->first();
        $akun = DB::table('kop_fin_master_coa')->where('coa_type', 'aset')->get();
        return view('app-koperasi.menu-peminjaman.peminjaman-list-barang.form-kontrak-payment', compact('akun'), ['data' => $data]);
    }
    public function menu_peminjaman_list_barang_cek_status_kontrak_payment_fix(Request $request)
    {
        $data = DB::table('kop_log_peminjaman_barang')
            ->join('kop_proses_peminjaman_brg', 'kop_proses_peminjaman_brg.kop_proses_brg_code', '=', 'kop_log_peminjaman_barang.kop_proses_brg_code')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_proses_peminjaman_brg.kop_master_peserta_code')
            ->where('kop_log_peminjaman_barang.kop_log_peminjaman_barang_code', $request->code)->first();
        // Hitung total uang yang dibayarkan pada angsuran ini
        $pokok = (float) $data->kop_log_peminjaman_brg_pokok;
        $bunga = (float) $data->kop_log_peminjaman_brg_bunga;
        $totalNominalLog = $pokok + $bunga;

        $headerJurnal = [
            'jurnal_tgl' => now()->format('Y-m-d'),
            'jurnal_keterangan' => "Penerimaan Angsuran (Log: {$data->kop_log_peminjaman_barang_code}) Tenor ke : {$data->kop_log_peminjaman_brg_tenor} - Dengan No Pengajuan : {$data->kop_proses_brg_code} (An : {$data->kop_master_peserta_name} ( {$data->kop_master_peserta_nip} ))",
            'jurnal_ref_table' => 'kop_log_peminjaman_barang',
            'jurnal_ref_code' => $request->code,
            'jurnal_user' => Auth::user()->userid,
            'jurnal_cabang' => $data->kop_master_peserta_cabang,
        ];
        $set = DB::table('kop_fin_master_coa_set')
            ->where('fin_master_coa_set_cabang', $data->kop_master_peserta_cabang)
            ->where('fin_master_coa_set_type', '=', 'angsuran_pinjaman_barang')->first();
        if ($request->akun == "") {
            $akun = $set->fin_master_coa_set_debit;
        } else {
            $akun = $request->akun;
        }

        // 6. Insert Detail Jurnal Berdasarkan Data dari Sub-Table Log
        if ($bunga == 0) {
            # code...
            $detailJurnal = [
                ['coa_code' => $akun, 'jurnal_debit' => $totalNominalLog, 'jurnal_kredit' => 0], // Piutang Anggota
                ['coa_code' => $set->fin_master_coa_set_kredit, 'jurnal_debit' => 0, 'jurnal_kredit' => $pokok],    // Kas/Bank Koperasi
            ];
        } else {
            $detailJurnal = [
                ['coa_code' => $akun, 'jurnal_debit' => $totalNominalLog, 'jurnal_kredit' => 0], // Piutang Anggota
                ['coa_code' => $set->fin_master_coa_set_bunga, 'jurnal_debit' => 0, 'jurnal_kredit' => $bunga],    // Kas/Bank Koperasi
                ['coa_code' => $set->fin_master_coa_set_kredit, 'jurnal_debit' => 0, 'jurnal_kredit' => $pokok],    // Kas/Bank Koperasi
            ];
        }


        // 3. Eksekusi Jurnal
        $this->accountingService->createJournal($headerJurnal, $detailJurnal);


        DB::table('kop_log_peminjaman_barang')->where('kop_log_peminjaman_barang_code', $request->code)->update([
            'kop_log_peminjaman_brg_status' => 1,
            'updated_at' => now(),
        ]);
        return 'Berhasil Payment';
    }
    public function menu_peminjaman_list_barang_cek_status_kontrak_payment_multi(Request $request)
    {
        $data = DB::table('kop_proses_peminjaman_brg')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_proses_peminjaman_brg.kop_master_peserta_code')
            ->where('kop_proses_peminjaman_brg.kop_proses_brg_code', $request->kop_proses_brg_code)->first();
        // 1. Validasi Masukan Form
        $request->validate([
            'kop_proses_brg_code' => 'required',
            'log_codes'           => 'required|array|min:1',
            'payment_coa_code'    => 'required',
        ]);

        DB::beginTransaction();

        try {
            $kontrakCode = $request->kop_proses_brg_code;
            $logCodes    = $request->log_codes; // Array key kode log barang
            $paymentCoa  = $request->payment_coa_code;

            // Dapatkan Master Kontrak Barang
            $pinjamanBrg = DB::table('kop_proses_peminjaman_brg')
                ->where('kop_proses_brg_code', $kontrakCode)
                ->first();

            if (!$pinjamanBrg) {
                return response()->json(['status' => 'error', 'message' => 'Kontrak peminjaman barang tidak ditemukan.']);
            }

            $totalPokokDiterima = 0;
            $totalBungaDiterima = 0;
            $grandTotalDiterima = 0;
            $tenorTerbayar      = [];

            // 2. Loop pertama untuk hitung total kas & ubah status log
            foreach ($logCodes as $code) {
                $logBarang = DB::table('kop_log_peminjaman_barang')
                    ->where('kop_log_peminjaman_barang_code', $code)
                    ->first();

                if (!$logBarang) {
                    throw new Exception("Data baris angsuran dengan kode {$code} tidak terdaftar.");
                }

                if ($logBarang->kop_log_peminjaman_brg_status == '1') {
                    throw new Exception("Angsuran tenor ke-{$logBarang->kop_log_peminjaman_brg_tenor} sudah berstatus lunas sebelumnya.");
                }

                // Kalkulasi akumulasi total pembukuan dari kolom log
                $totalPokokDiterima += $logBarang->kop_log_peminjaman_brg_pokok;
                $totalBungaDiterima += $logBarang->kop_log_peminjaman_brg_bunga;
                $grandTotalDiterima += $logBarang->kop_log_peminjaman_brg_nominal;
                $tenorTerbayar[]     = $logBarang->kop_log_peminjaman_brg_tenor;

                // UPDATE STATUS LOG BARANG MENJADI LUNAS
                DB::table('kop_log_peminjaman_barang')
                    ->where('kop_log_peminjaman_barang_code', $code)
                    ->update([
                        'kop_log_peminjaman_brg_status' => '1',
                        'updated_at'                    => now()
                    ]);
            }

            // Penomoran Bukti Jurnal Otomatis (BKM)
            $periodeYm = date('Ym');
            $latestJurnal = DB::table('kop_fin_jurnal')
                ->where('jurnal_no_bukti', 'LIKE', "BKM-{$periodeYm}-%")
                ->orderBy('jurnal_no_bukti', 'desc')
                ->first();

            if ($latestJurnal) {
                $lastNum = (int) substr($latestJurnal->jurnal_no_bukti, -4);
                $nextNum = sprintf('%04d', $lastNum + 1);
            } else {
                $nextNum = '0001';
            }
            $noBukti = $header['jurnal_no_bukti'] ?? 'JV-' . now()->format('Ymd') . '-' . strtoupper(uniqid());

            $userLogin = Auth::user()->name ?? 'System';
            $cabang    = Auth::user()->cabang_code ?? $pinjamanBrg->kop_proses_brg_kacab;

            // 3. SEEDING JURNAL HEADER (kop_fin_jurnal)
            $stringTenor = implode(', ', $tenorTerbayar);
            $idJurnalHeader = DB::table('kop_fin_jurnal')->insertGetId([
                'jurnal_no_bukti'   => $noBukti,
                'jurnal_tgl'        => date('Y-m-d'),
                'jurnal_keterangan' => "Pelunasan Angsuran Barang Tenor [{$stringTenor}] - Dengan no Pengajuan {$kontrakCode} (An : {$data->kop_master_peserta_name} ( {$data->kop_master_peserta_nip} ))",
                'jurnal_ref_table'  => 'kop_proses_peminjaman_brg', // Referensi polimorfisme tabel barang
                'jurnal_ref_code'   => $kontrakCode,
                'jurnal_user'       => $data->kop_master_peserta_code,
                'jurnal_cabang'     => $data->kop_master_peserta_cabang,
                'jurnal_created'    => now(),
                'created_at'        => now()
            ]);

            // 4. JURNAL DETAIL - SISI DEBIT (Kas/Bank bertambah)
            DB::table('kop_fin_jurnal_detail')->insert([
                'jurnal_id'     => $idJurnalHeader,
                'coa_code'      => $paymentCoa,
                'jurnal_debit'  => $grandTotalDiterima,
                'jurnal_kredit' => 0,
                'created_at'    => now()
            ]);

            // 5. JURNAL DETAIL - SISI KREDIT (Piutang Barang Berkurang)
            // *Catatan: Silakan ubah kode COA '11302' sesuai piutang peminjaman barang koperasi Anda
            $set = DB::table('kop_fin_master_coa_set')
                ->where('fin_master_coa_set_cabang', $data->kop_master_peserta_cabang)
                ->where('fin_master_coa_set_type', '=', 'angsuran_pinjaman_uang')->first();
            $coaPiutangBarang = $set->fin_master_coa_set_kredit;
            DB::table('kop_fin_jurnal_detail')->insert([
                'jurnal_id'     => $idJurnalHeader,
                'coa_code'      => $coaPiutangBarang,
                'jurnal_debit'  => 0,
                'jurnal_kredit' => $totalPokokDiterima,
                'created_at'    => now()
            ]);

            // 6. JURNAL DETAIL - SISI KREDIT (Pendapatan Margin/Bunga Barang)
            // *Catatan: Silakan ubah kode COA '41102' sesuai Pendapatan Operasional Barang Anda
            if ($totalBungaDiterima > 0) {
                $coaPendapatanMargin = $set->fin_master_coa_set_bunga;
                DB::table('kop_fin_jurnal_detail')->insert([
                    'jurnal_id'     => $idJurnalHeader,
                    'coa_code'      => $coaPendapatanMargin,
                    'jurnal_debit'  => 0,
                    'jurnal_kredit' => $totalBungaDiterima,
                    'created_at'    => now()
                ]);
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => count($logCodes) . ' bulan angsuran berhasil dilunasi. Bukti Transaksi: ' . $noBukti
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Gagal simpan: ' . $e->getMessage()], 500);
        }
    }
    // MENU PEMBELIAN BARANG KOPERASI
    public function menu_koperasi_pembelian_barang($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('kop_simpanan_sukarela')
                ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_simpanan_sukarela.kop_master_peserta_code')
                ->where('kop_master_peserta_cabang', Auth::user()->access_cabang)->orderBy('id_kop_simpanan_sukarela', 'desc')
                ->get();
            $coas = DB::table('kop_fin_master_coa')->get();
            return view('app-koperasi.menu-pembelian-barang-koperasi', compact('data', 'coas'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_pembelian_barang_get_data()
    {
        try {
            $data = DB::table('kop_pembelian_barang')
                ->orderBy('id_pembelian', 'desc')
                ->limit(100) // Batasi 100 transaksi terakhir demi performa database yang efisien
                ->get();

            return response()->json($data);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function menu_koperasi_pembelian_barang_save(Request $request)
    {
        // 1. Validasi Input Data Form
        $request->validate([
            'tgl_beli'       => 'required|date',
            'supplier'       => 'required|string|max:255',
            'coa_pembayaran' => 'required|string',
            'kategori'       => 'required|in:ASET,NON_ASET',
            'nama_barang'    => 'required|string|max:255',
            'satuan'         => 'required|string',
            'qty'            => 'required|integer|min:1',
            'harga_satuan'   => 'required|integer|min:0',
        ]);

        // Mulai Database Transaction untuk keamanan finansial terintegrasi
        DB::beginTransaction();

        try {
            $tglBeli       = $request->input('tgl_beli');
            $kategori      = $request->input('kategori');
            $qty           = (int) $request->input('qty');
            $hargaSatuan   = (int) $request->input('harga_satuan');
            $totalHarga    = $qty * $hargaSatuan;

            $coaPembayaran = $request->input('coa_pembayaran');
            $namaUser      = auth()->user()->userid ?? 'Admin';
            $kodeCabang    = auth()->user()->cabang_code ?? 'PUSAT'; // Disesuaikan dengan session login

            // Tentukan COA Target Debit berdasarkan pilihan kategori barang
            if ($kategori === 'ASET') {
                $coaDebitTarget = $request->input('coa_aset');
                $umurEkonomis   = $request->input('umur_ekonomis') ? (int) $request->input('umur_ekonomis') : null;

                if (!$coaDebitTarget) {
                    return response()->json(['status' => 'error', 'message' => 'Akun COA Aset Tetap wajib dipilih.'], 400);
                }
            } else {
                $coaDebitTarget = $request->input('coa_beban');
                $umurEkonomis   = null;

                if (!$coaDebitTarget) {
                    return response()->json(['status' => 'error', 'message' => 'Akun COA Beban/Perlengkapan wajib dipilih.'], 400);
                }
            }

            // 2. Generate Nomor Kode Pembelian Barang (Format: PO-YYYYMMDD-XXXX)
            $dateClean = date('Ymd', strtotime($tglBeli));
            $prefixPo  = 'PO-' . $dateClean . '-';
            $lastPo    = DB::table('kop_pembelian_barang')
                ->where('pembelian_code', 'like', $prefixPo . '%')
                ->orderBy('pembelian_code', 'desc')
                ->first();

            $nextPoNum = $lastPo ? sprintf('%04d', ((int) substr($lastPo->pembelian_code, -4)) + 1) : '0001';
            $kodePembelian = $prefixPo . $nextPoNum;

            // 3. Simpan fisik dokumen transaksi ke tabel 'kop_pembelian_barang'
            DB::table('kop_pembelian_barang')->insert([
                'pembelian_code'      => $kodePembelian,
                'tgl_beli'            => $tglBeli,
                'supplier'            => $request->input('supplier'),
                'kategori'            => $kategori,
                'nama_barang'         => $request->input('nama_barang'),
                'satuan'              => $request->input('satuan'),
                'qty'                 => $qty,
                'harga_satuan'        => $hargaSatuan,
                'total_harga'         => $totalHarga,
                'coa_pembayaran'      => $coaPembayaran,
                'coa_debit_target'    => $coaDebitTarget,
                'umur_ekonomis_tahun' => $umurEkonomis,
                'keterangan'          => $request->input('keterangan'),
                'created_by'          => $namaUser,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);

            // 4. Generate Nomor Bukti Jurnal Akuntansi (Format: JV-YYYYMM-XXXX)
            $periodeYm = date('Ym', strtotime($tglBeli));
            $prefixJurnal = 'JV-' . $periodeYm . '-';
            $lastJournal = DB::table('kop_fin_jurnal')
                ->where('jurnal_no_bukti', 'like', $prefixJurnal . '%')
                ->orderBy('jurnal_no_bukti', 'desc')
                ->first();

            $nextJurnalNum = $lastJournal ? sprintf('%04d', ((int) substr($lastJournal->jurnal_no_bukti, -4)) + 1) : '0001';
            $noBuktiJurnal = 'JV-' . now()->format('Ymd') . '-' . strtoupper(uniqid());

            // 5. Insert ke Main Header Jurnal Keuangan (`kop_fin_jurnal`)
            $idJurnalBaru = DB::table('kop_fin_jurnal')->insertGetId([
                'jurnal_no_bukti'   => $noBuktiJurnal,
                'jurnal_tgl'        => $tglBeli,
                'jurnal_keterangan' => "Pengadaan barang [" . $request->input('nama_barang') . "] dari supplier: " . $request->input('supplier') . " ($kodePembelian)",

                // Polimorfisme penanda relasi tabel asal pengadaan barang
                'jurnal_ref_table'  => 'kop_pembelian_barang',
                'jurnal_ref_code'   => $kodePembelian,

                'jurnal_user'       => $namaUser,
                'jurnal_cabang'     => $kodeCabang,
                'jurnal_created'    => $namaUser,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            // 6. Insert Detail Jurnal Posisi DEBIT (Penambahan nilai Aset / Pembebanan Biaya)
            DB::table('kop_fin_jurnal_detail')->insert([
                'jurnal_id'     => $idJurnalBaru,
                'coa_code'      => $coaDebitTarget,
                'jurnal_debit'  => $totalHarga,
                'jurnal_kredit' => 0,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            // 7. Insert Detail Jurnal Posisi KREDIT (Pengurangan Saldo Kas / Bank Koperasi)
            DB::table('kop_fin_jurnal_detail')->insert([
                'jurnal_id'     => $idJurnalBaru,
                'coa_code'      => $coaPembayaran,
                'jurnal_debit'  => 0,
                'jurnal_kredit' => $totalHarga,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            // Selesaikan transaksi dengan sukses
            DB::commit();

            return response()->json([
                'status'    => 'success',
                'jurnal_no' => $noBuktiJurnal,
                'message'   => 'Data pembelian barang dan jurnal akuntansi berhasil disimpan.'
            ]);
        } catch (Exception $e) {
            // Rollback database jika terjadi malfungsi query SQL
            DB::rollBack();
            Log::error('Gagal Transaksi Pembelian Barang: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi gangguan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
    // MENU MUTASI REKENING BANK
    public function menu_koperasi_mutasi_rekening_bank($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $allCoa = DB::table('kop_fin_master_coa')
                ->where('is_active', true)
                ->orderBy('coa_code', 'asc')
                ->get();
            $bankCoa = DB::table('kop_fin_master_coa')
                ->where('is_active', true)
                ->where('coa_code', 'LIKE', '1.2%') // Hapus/sesuaikan filter LIKE ini jika tidak ada penomoran khusus
                ->orderBy('coa_code', 'asc')
                ->get();
            $logMutasi = DB::table('kop_log_mutasi_bank as mb')
                ->join('kop_fin_master_coa as coa', 'mb.coa_code', '=', 'coa.coa_code')
                ->select('mb.*', 'coa.coa_name')
                ->orderBy('mb.mutasi_tgl', 'desc')
                ->orderBy('mb.id_mutasi', 'desc')
                ->limit(50) // Batasi 50 transaksi terakhir agar halaman tetap ringan
                ->get();
            return view('app-koperasi.menu-mutasi-rekening-bank', compact('allCoa', 'bankCoa', 'logMutasi'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_mutasi_rekening_bank_save(Request $request)
    {
        $request->validate([
            'mutasi_tgl'        => 'required|date',
            'bank_coa_code'     => 'required|string',
            'mutasi_jenis'      => 'required|in:CR,DB', // CR = Cash Receipt (Masuk), DB = Disbursement (Keluar)
            'mutasi_nominal'    => 'required|numeric|min:1',
            'lawan_coa_code'    => 'required|string',
            'mutasi_keterangan' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $tgl        = $request->mutasi_tgl;
            $bankCoa    = $request->bank_coa_code;
            $jenis      = $request->mutasi_jenis;
            $nominal    = $request->mutasi_nominal;
            $lawanCoa   = $request->lawan_coa_code;
            $keterangan = $request->mutasi_keterangan ?? 'Mutasi Rekening Bank';

            $userLogin  = Auth::user()->name ?? 'System';
            $cabang     = Auth::user()->cabang_code ?? '001'; // Default ke pusat jika kolom cabang kosong

            // 2. Pembuatan Nomor Bukti Otomatis (BKM untuk masuk / BKK untuk keluar)
            $periodeYm  = date('Ym', strtotime($tgl));
            $prefix     = ($jenis === 'CR') ? 'BKM' : 'BKK'; // Bukti Kas Masuk / Bukti Kas Keluar

            $latestJurnal = DB::table('kop_fin_jurnal')
                ->where('jurnal_no_bukti', 'LIKE', "{$prefix}-{$periodeYm}-%")
                ->orderBy('jurnal_no_bukti', 'desc')
                ->first();

            if ($latestJurnal) {
                $lastNum = (int) substr($latestJurnal->jurnal_no_bukti, -4);
                $nextNum = sprintf('%04d', $lastNum + 1);
            } else {
                $nextNum = '0001';
            }
            $noBukti = 'MT-' . now()->format('Ymd') . '-' . strtoupper(uniqid());

            // 3. SEEDING DATA KE BUKU MUTASI BANK (Misal nama tabel: kop_log_mutasi_bank)
            // *Catatan: Sesuaikan nama tabel log bank ini dengan skema yang ada di database Anda
            $idMutasiBank = DB::table('kop_log_mutasi_bank')->insertGetId([
                'mutasi_no_bukti'   => $noBukti,
                'mutasi_tgl'        => $tgl,
                'coa_code'          => $bankCoa,
                'mutasi_keterangan' => $keterangan,
                'mutasi_debit'      => ($jenis === 'CR') ? $nominal : 0,  // Uang masuk menambah debit bank
                'mutasi_kredit'     => ($jenis === 'DB') ? $nominal : 0,  // Uang keluar menambah kredit bank
                'mutasi_user'       => $userLogin,
                'created_at'        => now(),
                'updated_at'        => now()
            ]);

            // 4. POSTING JURNAL HEADER (kop_fin_jurnal)
            $idJurnalHeader = DB::table('kop_fin_jurnal')->insertGetId([
                'jurnal_no_bukti'   => $noBukti,
                'jurnal_tgl'        => $tgl,
                'jurnal_keterangan' => $keterangan,
                'jurnal_ref_table'  => 'kop_log_mutasi_bank', // Referensi asal data induk
                'jurnal_ref_code'   => $idMutasiBank,         // ID Log Mutasi Bank
                'jurnal_user'       => Auth::user()->userid,
                'jurnal_cabang'     => Auth::user()->access_cabang,
                'jurnal_created'    => now(),
                'created_at'        => now()
            ]);

            // 5. POSTING JURNAL DETAIL - DOUBLE ENTRY BALANCE SYSTEM
            if ($jenis === 'CR') {
                // KONDISI UANG MASUK:
                // Baris 1: Rekening Bank bertambah di Sisi DEBIT
                DB::table('kop_fin_jurnal_detail')->insert([
                    'jurnal_id'     => $idJurnalHeader,
                    'coa_code'      => $bankCoa,
                    'jurnal_debit'  => $nominal,
                    'jurnal_kredit' => 0,
                    'created_at'    => now()
                ]);

                // Baris 2: Akun Lawan (Pendapatan/Piutang) bertambah/berkurang di Sisi KREDIT
                DB::table('kop_fin_jurnal_detail')->insert([
                    'jurnal_id'     => $idJurnalHeader,
                    'coa_code'      => $lawanCoa,
                    'jurnal_debit'  => 0,
                    'jurnal_kredit' => $nominal,
                    'created_at'    => now()
                ]);
            } else {
                // KONDISI UANG KELUAR:
                // Baris 1: Akun Lawan (Beban/Biaya/Pasiva) bertambah di Sisi DEBIT
                DB::table('kop_fin_jurnal_detail')->insert([
                    'jurnal_id'     => $idJurnalHeader,
                    'coa_code'      => $lawanCoa,
                    'jurnal_debit'  => $nominal,
                    'jurnal_kredit' => 0,
                    'created_at'    => now()
                ]);

                // Baris 2: Rekening Bank berkurang di Sisi KREDIT
                DB::table('kop_fin_jurnal_detail')->insert([
                    'jurnal_id'     => $idJurnalHeader,
                    'coa_code'      => $bankCoa,
                    'jurnal_debit'  => 0,
                    'jurnal_kredit' => $nominal,
                    'created_at'    => now()
                ]);
            }

            // Jika semua proses aman, kunci transaksi ke database
            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => "Nomor transaksi {$noBukti} berhasil diposting ke dalam jurnal keuangan umum."
            ]);
        } catch (Exception $e) {
            // Batalkan semua perubahan jika di tengah jalan terjadi error database
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan mutasi: ' . $e->getMessage()
            ], 500);
        }
    }
    // MENU PEMBELIAN BARANG ANGGOTA
    public function menu_koperasi_pembelian_barang_anggota($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // 1. Ambil data peserta dengan status AKTIF berdasarkan struktur tabel kop_master_peserta
            $anggota = DB::table('kop_master_peserta')
                ->where('kop_master_peserta_status', 'AKTIF')
                ->orderBy('kop_master_peserta_name', 'asc')
                ->get();

            // 2. Ambil COA kas/bank untuk opsi sumber pendanaan pembelian ke supplier
            $bankCoa = DB::table('kop_fin_master_coa')
                ->where('is_active', true)
                ->where('coa_code', 'LIKE', '1.%')
                ->get();

            // 3. Ambil 30 riwayat pembelian barang terakhir dengan join ke kop_master_peserta
            $riwayat = DB::table('kop_trx_pembelian_anggota as pa')
                ->join('kop_master_peserta as p', 'pa.anggota_id', '=', 'p.id_kop_master_peserta')
                ->select(
                    'pa.*',
                    'p.kop_master_peserta_name',
                    'p.kop_master_peserta_code'
                )
                ->orderBy('pa.id_pembelian', 'desc')
                ->limit(30)
                ->get();
            return view('app-koperasi.menu-pembelian-barang-anggota', compact('anggota', 'bankCoa', 'riwayat'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_pembelian_barang_anggota_save(Request $request)
    {
        // 1. Validasi Input dari Frontend
        $validator = Validator::make($request->all(), [
            'anggota_id'        => 'required|integer',
            'barang_nama'       => 'required|string|max:255',
            'tanggal_transaksi' => 'required|date',
            'harga_beli'        => 'required|numeric|min:1',
            'margin_koperasi'   => 'nullable|numeric|min:0',
            'sumber_dana_coa'   => 'required|string',
            'tenor_bulan'       => 'required|integer|in:3,6,12,18,24,36',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validasi gagal: ' . implode(', ', $validator->errors()->all())
            ], 422);
        }

        // 2. Cek apakah ID Peserta benar-benar valid dan aktif di database
        $peserta = DB::table('kop_master_peserta')
            ->where('id_kop_master_peserta', $request->anggota_id)
            ->where('kop_master_peserta_status', 'AKTIF')
            ->first();

        if (!$peserta) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data peserta tidak ditemukan atau status peserta tidak aktif.'
            ], 404);
        }

        // 3. Mulai Database Transaction
        DB::beginTransaction();
        try {
            // Kalkulasi finansial awal
            $hargaBeli    = $request->harga_beli;
            $margin       = $request->margin_koperasi ?? 0;
            $totalPiutang = $hargaBeli + $margin;
            $tenor        = $request->tenor_bulan;

            // Pembulatan ke atas (ceil) agar tidak ada sisa pembagian nominal per bulan
            $cicilan      = ceil($totalPiutang / $tenor);

            // Generate nomor nota unik otomatis (Contoh: PBI-20260720-XYZ123)
            $nota = 'PBI-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

            // A. Simpan data ke tabel utama (kop_trx_pembelian_anggota)
            $idPembelian = DB::table('kop_trx_pembelian_anggota')->insertGetId([
                'nota_nomor'        => $nota,
                'anggota_id'        => $request->anggota_id, // Menyimpan id_kop_master_peserta
                'barang_nama'       => $request->barang_nama,
                'harga_beli'        => $hargaBeli,
                'margin_koperasi'   => $margin,
                'total_piutang'     => $totalPiutang,
                'tenor_bulan'       => $tenor,
                'cicilan_per_bulan' => $cicilan,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'status_tagihan'    => 'BELUM_LUNAS',
                'created_by'        => auth()->user()->name ?? 'Admin Finance',
                'created_at'        => now(),
                'updated_at'        => now()
            ]);

            // B. Generate Otomatis Jadwal Angsuran Tenor Bulanan (kop_trx_pembelian_tenor)
            $tglBaseline = $request->tanggal_transaksi;
            for ($i = 1; $i <= $tenor; $i++) {
                // Jatuh tempo dihitung maju secara presisi per bulan dari tanggal transaksi
                $jatuhTempo = date('Y-m-d', strtotime("+$i month", strtotime($tglBaseline)));

                DB::table('kop_trx_pembelian_tenor')->insert([
                    'id_pembelian'   => $idPembelian,
                    'angsuran_ke'    => $i,
                    'jatuh_tempo'    => $jatuhTempo,
                    'jumlah_tagihan' => $cicilan,
                    'status_bayar'   => 'BELUM',
                    'created_at'     => now(),
                    'updated_at'     => now()
                ]);
            }

            // C. BAGIAN INTEGRASI JURNAL AKUNTANSI (Double Entry) - Opsional sesuai regulasi COA Koperasi Anda
            /*
            $jurnalId = DB::table('kop_fin_trx_jurnal')->insertGetId([
                'jurnal_code' => 'JRN-' . date('Ymd') . '-' . rand(100,999),
                'jurnal_date' => $request->tanggal_transaksi,
                'description' => 'Pembelian barang tenor nota: ' . $nota . ' a/n ' . $peserta->kop_master_peserta_name,
                'created_at'  => now()
            ]);

            // Debit: Akun Piutang Anggota (121-0001) -> Sebesar total piutang
            DB::table('kop_fin_trx_jurnal_detail')->insert([
                'jurnal_id' => $jurnalId, 'coa_code' => '121-0001', 'debit' => $totalPiutang, 'kredit' => 0
            ]);
            // Kredit: Akun Kas/Bank Koperasi Asal -> Sebesar modal awal barang
            DB::table('kop_fin_trx_jurnal_detail')->insert([
                'jurnal_id' => $jurnalId, 'coa_code' => $request->sumber_dana_coa, 'debit' => 0, 'kredit' => $hargaBeli
            ]);
            // Kredit: Akun Pendapatan Margin Pembiayaan (412-0005) jika ada keuntungan margin
            if ($margin > 0) {
                DB::table('kop_fin_trx_jurnal_detail')->insert([
                    'jurnal_id' => $jurnalId, 'coa_code' => '412-0005', 'debit' => 0, 'kredit' => $margin
                ]);
            }
            */

            // Komit transaksi jika semua operasi database di atas berhasil tanpa error
            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Kontrak pengadaan barang berhasil dibukukan dengan nomor nota ' . $nota . '. Proyeksi jangka waktu ' . $tenor . ' bulan sudah diaktifkan.'
            ]);
        } catch (Exception $e) {
            // Batalkan semua perubahan jika di tengah jalan terdapat crash sistem/database
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal memproses transaksi: ' . $e->getMessage()
            ], 500);
        }
    }
    // MENU PENAGIHAN BARANG ANGGOTA
    public function menu_koperasi_penagihan_barang_anggota(Request $request, $akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $bankCoa = DB::table('kop_fin_master_coa')->where('is_active', true)->where('coa_code', 'LIKE', '11%')->get();

            $listNota = DB::table('kop_trx_pembelian_anggota as pa')
                ->join('kop_master_peserta as p', 'pa.anggota_id', '=', 'p.id_kop_master_peserta')
                ->where('pa.status_tagihan', 'BELUM_LUNAS')
                ->select('pa.id_pembelian', 'pa.nota_nomor', 'p.kop_master_peserta_name')
                ->get();

            return view('app-koperasi.menu-penagihan-barang-anggota', compact('bankCoa', 'listNota'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_koperasi_penagihan_barang_anggota_get_data($id_pembelian)
    {
        $kontrak = DB::table('kop_trx_pembelian_anggota as pa')
            ->join('kop_master_peserta as p', 'pa.anggota_id', '=', 'p.id_kop_master_peserta')
            ->where('pa.id_pembelian', $id_pembelian)
            ->select('pa.*', 'p.kop_master_peserta_name', 'p.kop_master_peserta_code')
            ->first();

        if (!$kontrak) {
            return response()->json(['status' => 'error', 'message' => 'Data kontrak tidak ditemukan'], 404);
        }

        $detailJadwal = DB::table('kop_trx_pembelian_tenor')
            ->where('id_pembelian', $id_pembelian)
            ->orderBy('angsuran_ke', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'kontrak' => $kontrak,
            'jadwal' => $detailJadwal
        ]);
    }
    public function menu_koperasi_penagihan_barang_anggota_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_tenor'        => 'required|integer',
            'sumber_dana_coa' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak valid.'], 422);
        }

        // Ambil data tenor yang akan dibayar
        $tenor = DB::table('kop_trx_pembelian_tenor')->where('id_tenor', $request->id_tenor)->first();
        if (!$tenor || $tenor->status_bayar === 'LUNAS') {
            return response()->json(['status' => 'error', 'message' => 'Tagihan sudah lunas atau tidak ditemukan.'], 404);
        }

        // Ambil data induk pembelian
        $pembelian = DB::table('kop_trx_pembelian_anggota')->where('id_pembelian', $tenor->id_pembelian)->first();

        DB::beginTransaction();
        try {
            // 1. Update status tabel tenor detail menjadi LUNAS
            DB::table('kop_trx_pembelian_tenor')
                ->where('id_tenor', $request->id_tenor)
                ->update([
                    'status_bayar'  => 'LUNAS',
                    'tanggal_bayar' => now(),
                    'updated_at'    => now()
                ]);

            // 2. Cek apakah seluruh tenor untuk id_pembelian ini sudah lunas semua
            $sisaTagihan = DB::table('kop_trx_pembelian_tenor')
                ->where('id_pembelian', $tenor->id_pembelian)
                ->where('status_bayar', 'BELUM')
                ->count();

            // Jika tidak ada sisa tagihan, update tabel utama menjadi LUNAS
            if ($sisaTagihan === 0) {
                DB::table('kop_trx_pembelian_anggota')
                    ->where('id_pembelian', $tenor->id_pembelian)
                    ->update([
                        'status_tagihan' => 'LUNAS',
                        'updated_at'     => now()
                    ]);
            }

            // 3. DRAFT OTOMATIS JURNAL AKUNTANSI (Uang Masuk / Pelunasan Piutang)
            /*
            $jurnalId = DB::table('kop_fin_trx_jurnal')->insertGetId([
                'jurnal_code' => 'KAS-' . date('Ymd') . '-' . rand(100,999),
                'jurnal_date' => date('Y-m-d'),
                'description' => 'Terima cicilan ke-' . $tenor->angsuran_ke . ' nota: ' . $pembelian->nota_nomor,
                'created_at'  => now()
            ]);

            // Debit: Kas/Bank Koperasi Asal yang dipilih -> Menerima uang tunai cicilan
            DB::table('kop_fin_trx_jurnal_detail')->insert([
                'jurnal_id' => $jurnalId, 'coa_code' => $request->sumber_dana_coa, 'debit' => $tenor->jumlah_tagihan, 'kredit' => 0
            ]);

            // Kredit: Mengurangi Piutang Pembelian Barang Anggota (121-0001)
            DB::table('kop_fin_trx_jurnal_detail')->insert([
                'jurnal_id' => $jurnalId, 'coa_code' => '121-0001', 'debit' => 0, 'kredit' => $tenor->jumlah_tagihan
            ]);
            */

            DB::commit();
            return response()->json([
                'status'  => 'success',
                'message' => 'Pembayaran angsuran ke-' . $tenor->angsuran_ke . ' berhasil diverifikasi.'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal memproses pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }
    // LAPORAN TAGIHAN
    public function laporan_koperasi_tagihan($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $cabang = DB::table('kop_master_cabang')->get();
            return view('app-koperasi.laporan-tagihan', compact('cabang'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function laporan_koperasi_tagihan_find(Request $request)
    {
        $peserta = DB::table('kop_master_peserta')->where('kop_master_peserta_cabang', $request->cabang)->get();
        return view('app-koperasi.laporan-tagihan.data-tagihan-koperasi', compact('peserta'));
    }
    // LAPORAN MUTASI BANK
    public function laporan_koperasi_mutasi_bank($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('kop_mutasi_bank')
                ->join('kop_master_bank', 'kop_master_bank.kop_master_bank_code', '=', 'kop_mutasi_bank.kop_master_bank_code')
                ->get();
            return view('app-koperasi.laporan-mutasi-bank', ['akses' => $akses, 'code' => $id], compact('data'));
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function laporan_koperasi_mutasi_bank_add(Request $request)
    {
        $bank = DB::table('kop_master_bank')->get();
        return view('app-koperasi.laporan-mutasi.form-add-mutasi', compact('bank'));
    }
    public function laporan_koperasi_mutasi_bank_save(Request $request)
    {
        try {
            DB::table('kop_mutasi_bank')->insert([
                'kop_mutasi_bank_code' => str::uuid(),
                'kop_master_bank_code' => $request->data_bank,
                'kop_mutasi_bank_desc' => $request->desc,
                'kop_mutasi_bank_date' => $request->tanggal_mutasi,
                'kop_mutasi_bank_debit' => $request->debit,
                'kop_mutasi_bank_kredit' => $request->kredit,
                'kop_mutasi_bank_total' => $request->saldo,
                'created_at' => now(),
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    // LAPORAN JURNAL UMUM
    public function laporan_koperasi_jurnal_umum($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $cabang = DB::table('kop_master_cabang')->get();
            $divisi = DB::table('kop_master_div_bag')->join('kop_master_divisi', 'kop_master_divisi.kop_master_divisi_code', '=', 'kop_master_div_bag.kop_master_divisi_code')->get();
            $pokok = DB::table('kop_simpanan_pokok')->get();
            $wajib = DB::table('kop_simpanan_wajib')->get();
            $coa = DB::table('kop_fin_master_coa')->get();
            return view('app-koperasi.laporan-jurnal-umum', compact(
                'coa',
                'cabang',
                'divisi',
                'pokok',
                'wajib'
            ), [
                'akses' => $akses,
                'code' => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function laporan_koperasi_jurnal_umum_get_coa()
    {
        try {
            // Mengambil dari tabel sesuai skema Anda: kop_fin_master_coa
            $coaList = DB::table('kop_fin_master_coa')
                ->select('coa_code', 'coa_name', 'coa_type') // Menggunakan coa_code sebagai identifier unik
                ->where('is_active', true)
                ->orderBy('coa_code', 'asc') // Urut berdasarkan kode nomor akun
                ->get();

            return response()->json($coaList, 200);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil list COA aktif: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat master akun COA dari server.'
            ], 500);
        }
    }
    public function laporan_koperasi_jurnal_umum_save_data(Request $request)
    {
        // 1. Validasi Struktur Payload JSON dari Frontend
        $request->validate([
            'no_bukti'               => 'required|string|exists:kop_fin_jurnal,jurnal_no_bukti',
            'keterangan'             => 'nullable|string|max:1000',
            'jurnal'                 => 'required|array|min:1',
            'jurnal.*.coa_code'      => 'required|string|exists:kop_fin_master_coa,coa_code',
            'jurnal.*.jurnal_debit'  => 'required|integer|min:0',
            'jurnal.*.jurnal_kredit' => 'required|integer|min:0',
            'jurnal.*.id_jurnal_detail' => 'nullable|integer' // Bisa null jika fallback penambahan baris baru
        ], [
            'no_bukti.exists'          => 'Nomor bukti jurnal tidak ditemukan di database.',
            'jurnal.*.coa_code.exists' => 'Kode COA yang dipilih tidak valid atau tidak terdaftar.',
        ]);

        try {
            DB::beginTransaction();

            // 2. Ambil data induk jurnal berdasarkan nomor bukti
            $jurnalInduk = DB::table('kop_fin_jurnal')
                ->where('jurnal_no_bukti', $request->no_bukti)
                ->first();

            if (!$jurnalInduk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui. Data induk jurnal tidak ditemukan.'
                ], 444);
            }

            // 3. Update Keterangan pada tabel Induk (kop_fin_jurnal)
            DB::table('kop_fin_jurnal')
                ->where('jurnal_no_bukti', $request->no_bukti)
                ->update([
                    'jurnal_keterangan' => $request->keterangan,
                    'updated_at'        => now()
                ]);

            $totalDebit = 0;
            $totalKredit = 0;

            // 4. Looping untuk update baris detail (kop_fin_jurnal_detail)
            foreach ($request->jurnal as $item) {
                $debit  = intval($item['jurnal_debit']);
                $kredit = intval($item['jurnal_kredit']);

                $totalDebit  += $debit;
                $totalKredit += $kredit;

                // Cek apakah data dikirim dengan ID detail murni
                if (!empty($item['id_jurnal_detail'])) {
                    // Opsi Utama: Update berdasarkan Primary Key id_jurnal_detail
                    DB::table('kop_fin_jurnal_detail')
                        ->where('id_jurnal_detail', $item['id_jurnal_detail'])
                        ->where('jurnal_id', $jurnalInduk->id_jurnal)
                        ->update([
                            'coa_code'      => $item['coa_code'],
                            'jurnal_debit'  => $debit,
                            'jurnal_kredit' => $kredit,
                            'updated_at'    => now()
                        ]);
                } else {
                    // Opsi Cadangan (Fallback): Jika ID null/kosong, update berdasarkan relasi jurnal_id + coa_code
                    DB::table('kop_fin_jurnal_detail')
                        ->where('jurnal_id', $jurnalInduk->id_jurnal)
                        ->where('coa_code', $item['coa_code'])
                        ->update([
                            'jurnal_debit'  => $debit,
                            'jurnal_kredit' => $kredit,
                            'updated_at'    => now()
                        ]);
                }
            }

            // 5. Validasi Proteksi Keseimbangan Akuntansi (Asas Double-Entry)
            if ($totalDebit !== $totalKredit) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan. Jurnal tidak seimbang! Total Debit (Rp ' .
                        number_format($totalDebit, 0, ',', '.') . ') ≠ Total Kredit (Rp ' .
                        number_format($totalKredit, 0, ',', '.') . ').'
                ], 422);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Jurnal ' . $request->no_bukti . ' berhasil diperbarui dan diseimbangkan.'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            // Log error internal untuk mempermudah pelacakan tim IT/Developer
            Log::error('Gagal Update Jurnal Manual: ' . $e->getMessage(), [
                'no_bukti' => $request->no_bukti,
                'payload'  => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan internal pada sistem database: ' . $e->getMessage()
            ], 500);
        }
    }
    // LAPORAN RUGI LABA
    public function laporan_koperasi_rugi_laba($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {

            return view('app-koperasi.laporan-rugi-laba', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // LAPORAN NERACA
    public function laporan_koperasi_neraca($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {

            return view('app-koperasi.laporan-neraca', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // LAPORAN PEMBAGIAN LABA
    public function laporan_koperasi_pembagian_laba($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {

            return view('app-koperasi.laporan-pembagian-laba', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // LAPORAN PEMBAGIAN SHU
    public function laporan_koperasi_pembagian_shu($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $cabangs = DB::table('kop_master_cabang')->get();
            $coas = DB::table('kop_fin_master_coa')->get();
            return view('app-koperasi.laporan-pembagian-shu', compact('cabangs', 'coas'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function laporan_koperasi_pembagian_shu_get_data(Request $request)
    {
        // 1. Ambil parameter filter (Default ke tahun berjalan jika kosong)
        $dari = $request->query('tgl_mulai', now()->startOfYear()->format('Y-m-d'));
        $sampai = $request->query('tgl_selesai', now()->endOfYear()->format('Y-m-d'));

        // Menangkap filter cabang dari frontend
        $cabang = $request->query('cabang_id');

        // Jika nilai 'ALL' atau kosong, set null agar klausul ->when() dilewati (Global)
        $cabangFilter = ($cabang && $cabang !== 'ALL') ? $cabang : null;

        // 2. HITUNG PENDAPATAN OPERASIONAL (Seluruh Kepala 4)
        $pendapatan = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->whereBetween('j.jurnal_tgl', [$dari, $sampai])
            ->where('d.coa_code', 'like', '4%') // Mengambil langsung seluruh Kepala 4
            ->when($cabangFilter, function ($q) use ($cabangFilter) {
                return $q->where('j.jurnal_cabang', $cabangFilter);
            })
            ->select(DB::raw('SUM(d.jurnal_kredit) - SUM(d.jurnal_debit) as total'))
            ->first();

        // 3. HITUNG BEBAN OPERASIONAL (Prefix COA 5 dan 6)
        $beban = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->whereBetween('j.jurnal_tgl', [$dari, $sampai])
            ->whereIn(DB::raw('LEFT(d.coa_code, 1)'), ['5', '6'])
            ->when($cabangFilter, function ($q) use ($cabangFilter) {
                return $q->where('j.jurnal_cabang', $cabangFilter);
            })
            ->select(DB::raw('SUM(d.jurnal_debit) - SUM(d.jurnal_kredit) as total'))
            ->first();

        $totalPendapatan = floatval($pendapatan->total ?? 0);
        $totalBeban = floatval($beban->total ?? 0);

        // SHU Bersih = Pendapatan - Beban
        $shuTotal = $totalPendapatan - $totalBeban;
        if ($shuTotal < 0) {
            $shuTotal = 0; // Jika kondisi koperasi rugi, SHU senilai 0 (tidak ada pembagian)
        }

        // 4. SETTING PERSENTASE ALOKASI POS SHU (Sesuai AD/ART Koperasi)
        $persentase = [
            'dana_cadangan'   => 50, // 30% untuk cadangan modal koperasi
            'jasa_modal'      => 15, // 25% untuk Jasa Simpanan Anggota
            'jasa_anggota'    => 15, // 20% untuk Jasa Transaksi/Usaha Anggota (Partisipasi Kepala 4)
            'dana_pengurus'   => 10, // 10% pembagian pengurus
            'dana_karyawan'   => 5,  // 5% tunjangan kesejahteraan karyawan
            'dana_pendidikan' => 5,  // 5% dana pendidikan koperasi
            'dana_sosial'     => 5,  // 5% dana alokasi sosial
        ];

        // Kalkulasi nilai nominal Rupiah per Pos Anggaran
        $alokasiShu = [];
        foreach ($persentase as $key => $pct) {
            $alokasiShu[$key] = ($pct / 100) * $shuTotal;
        }

        // 5. HITUNG ACUAN PEMBAGIAN (GRAND TOTAL SIMPANAN & TRANSAKSI KEPALA 4)
        // Grand Total Simpanan Anggota (COA kelompok 21) sampai tanggal evaluasi
        $grandTotalSimpanan = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->where('d.coa_code', 'like', '21%')
            ->where('j.jurnal_tgl', '<=', $sampai)
            ->when($cabangFilter, function ($q) use ($cabangFilter) {
                return $q->where('j.jurnal_cabang', $cabangFilter);
            })
            ->select(DB::raw('SUM(d.jurnal_kredit) - SUM(d.jurnal_debit) as total'))
            ->first()->total ?? 0;

        // Grand Total Partisipasi Transaksi Anggota (Mengambil Seluruh Kepala 4) pada periode terpilih
        $grandTotalTransaksi = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->whereBetween('j.jurnal_tgl', [$dari, $sampai])
            ->where('d.coa_code', 'like', '4%') // Mengambil global seluruh pendapatan kepala 4
            ->when($cabangFilter, function ($q) use ($cabangFilter) {
                return $q->where('j.jurnal_cabang', $cabangFilter);
            })
            // Tambahkan kondisi jika ada COA non-anggota (misal 4200) yang tidak ingin dimasukkan ke SHU anggota
            // ->where('d.coa_code', 'not like', '42%')
            ->select(DB::raw('SUM(d.jurnal_kredit) - SUM(d.jurnal_debit) as total'))
            ->first()->total ?? 0;

        // Hindari pembagian dengan angka nol (Division by Zero)
        $pembagiSimpanan = $grandTotalSimpanan > 0 ? $grandTotalSimpanan : 1;
        $pembagiTransaksi = $grandTotalTransaksi > 0 ? $grandTotalTransaksi : 1;

        // 6. AMBIL DATA ANGGOTA DAN DISTRIBUSI SHU INDIVIDU
        $anggotaList = DB::table('kop_master_peserta as p')
            ->select(
                'p.kop_master_peserta_code',
                'p.kop_master_peserta_name',
                'p.kop_master_peserta_cabang as cabang_id',

                // Sub-Query 1: Total Saldo Akhir Simpanan Anggota (21%)
                DB::raw("(SELECT COALESCE(SUM(d1.jurnal_kredit) - SUM(d1.jurnal_debit), 0)
                          FROM kop_fin_jurnal_detail d1
                          JOIN kop_fin_jurnal j1 ON d1.jurnal_id = j1.id_jurnal
                          WHERE j1.jurnal_user = p.kop_master_peserta_code
                          AND d1.coa_code LIKE '21%'
                          AND j1.jurnal_tgl <= '$sampai') as simpanan_anggota"),

                // Sub-Query 2: Total Akumulasi Transaksi Anggota dari SELURUH KEPALA 4 (Pinjaman, Toko, dll)
                DB::raw("(SELECT COALESCE(SUM(d2.jurnal_kredit) - SUM(d2.jurnal_debit), 0)
                          FROM kop_fin_jurnal_detail d2
                          JOIN kop_fin_jurnal j2 ON d2.jurnal_id = j2.id_jurnal
                          WHERE j2.jurnal_user = p.kop_master_peserta_code
                          AND d2.coa_code LIKE '4%' -- Menangkap pinjaman/toko selama user-nya terikat ke kode anggota
                          AND j2.jurnal_tgl BETWEEN '$dari' AND '$sampai') as transaksi_anggota")
            )
            // Menyaring daftar anggota berdasarkan cabang yang dipilih di frontend
            ->when($cabangFilter, function ($q) use ($cabangFilter) {
                return $q->where('p.kop_master_peserta_cabang', $cabangFilter);
            })
            ->get();

        // Map data untuk menghitung formula pembagian SHU masing-masing individu
        $detailSHUAnggota = $anggotaList->map(function ($a) use ($alokasiShu, $pembagiSimpanan, $pembagiTransaksi) {
            $simpanan = floatval($a->simpanan_anggota);
            $transaksi = floatval($a->transaksi_anggota);

            // Rumus SHU Jasa Modal = (Simpanan Anggota / Total Simpanan Koperasi) * Alokasi Anggaran Jasa Modal
            $jasaModal = ($simpanan / $pembagiSimpanan) * $alokasiShu['jasa_modal'];

            // Rumus SHU Jasa Usaha = (Transaksi Anggota / Total Transaksi Koperasi) * Alokasi Anggaran Jasa Anggota
            $jasaUsaha = ($transaksi / $pembagiTransaksi) * $alokasiShu['jasa_anggota'];

            $totalShu = $jasaModal + $jasaUsaha;

            return [
                'code'       => $a->kop_master_peserta_code,
                'name'       => $a->kop_master_peserta_name,
                'cabang_id'  => $a->cabang_id,
                'simpanan'   => $simpanan,
                'transaksi'  => $transaksi,
                'jasa_modal' => round($jasaModal, 2),
                'jasa_usaha' => round($jasaUsaha, 2),
                'total_shu'  => round($totalShu, 2)
            ];
        });

        // 7. Kembalikan data dalam bentuk struktur JSON terpadu
        return response()->json([
            'periode'        => ['mulai' => $dari, 'selesai' => $sampai],
            'shu_total'      => $shuTotal,
            'persentase'     => $persentase,
            'alokasi_shu'    => $alokasiShu,
            'detail_anggota' => $detailSHUAnggota
        ]);
    }
    public function laporan_koperasi_pembagian_shu_cairkan_shu(Request $request)
    {
        // 1. Validasi Input Data dari AJAX UI
        $request->validate([
            'anggota_code'  => 'required|string',
            'nominal'       => 'required|numeric|min:1',
            'coa_code'      => 'required|string',
            'tgl_pencairan' => 'required|date',
        ]);

        // Mulai Database Transaction demi keamanan integritas data finansial
        // DB::beginTransaction();

        try {
            $anggotaCode  = $request->input('anggota_code');
            $nominal      = (int) $request->input('nominal'); // Cast ke integer sesuai tipe kolom schema
            $coaKasBank   = $request->input('coa_code');
            // $tglPencairan = $request->input('tgl_pencairan');

            // 2. Proteksi Awal: Ambil data anggota sekaligus kode cabangnya
            $anggota = DB::table('kop_master_peserta')
                ->where('kop_master_peserta_code', $anggotaCode)
                ->first();

            if (!$anggota) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Data Anggota tidak ditemukan di sistem.'
                ], 404);
            }

            // Ambil kode cabang anggota atau bisa juga disesuaikan dengan kode cabang user login
            $kodeCabang = $anggota->kop_master_peserta_cabang ?? 'HO';
            $namaUser   = $anggota->kop_master_peserta_code ?? 'System/Kasir';



            $headerJurnal = [
                'jurnal_tgl' => now()->format('Y-m-d'),
                'jurnal_keterangan' => "Pencairan SHU Koperasi kepada Anggota: " . $anggota->kop_master_peserta_name . " ($anggota->kop_master_peserta_nip)",
                'jurnal_ref_table' => 'kop_pembagian_shu',
                'jurnal_ref_code' => $anggotaCode,
                'jurnal_user' => $anggota->kop_master_peserta_code,
                'jurnal_cabang' => $anggota->kop_master_peserta_cabang,
            ];
            $set = DB::table('kop_fin_master_coa_set')
                ->where('fin_master_coa_set_cabang', $anggota->kop_master_peserta_cabang)
                ->where('fin_master_coa_set_type', '=', 'pencairan_dana_shu')->first();

            // 6. Insert Detail Jurnal Berdasarkan Data dari Sub-Table Log

            $detailJurnal = [
                ['coa_code' => $set->fin_master_coa_set_debit, 'jurnal_debit' => $nominal, 'jurnal_kredit' => 0], // Piutang Anggota
                ['coa_code' => $coaKasBank, 'jurnal_debit' => 0, 'jurnal_kredit' => $nominal],    // Kas/Bank Koperasi
            ];


            // 3. Eksekusi Jurnal
            $this->accountingService->createJournal($headerJurnal, $detailJurnal);

            return response()->json([
                'status'  => 'success',
                'jurnal'  => '0000000000000000000000000',
                'message' => 'Pencairan SHU berhasil dibukukan.'
            ]);
        } catch (Exception $e) {
            // Batalkan semua query jika terjadi kegagalan di tengah jalan
            DB::rollBack();

            Log::error('Gagal Eksekusi Jurnal SHU: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menulis ke jurnal keuangan: ' . $e->getMessage()
            ], 500);
        }
    }
    // AKUTANSI JURNAL OTOMATIS
    public function akutansi_koperasi_jurnal_otomatis($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $cabang = DB::table('kop_master_cabang')->get();
            $divisi = DB::table('kop_master_div_bag')->join('kop_master_divisi', 'kop_master_divisi.kop_master_divisi_code', '=', 'kop_master_div_bag.kop_master_divisi_code')->get();
            $pokok = DB::table('kop_simpanan_pokok')->get();
            $wajib = DB::table('kop_simpanan_wajib')->get();
            $coa = DB::table('kop_fin_master_coa')->get();
            return view('app-koperasi.akutansi_jurnal_otomatis', compact(
                'coa',
                'cabang',
                'divisi',
                'pokok',
                'wajib'
            ), [
                'akses' => $akses,
                'code' => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // AKUTANSI JURNAL OTOMATIS
    public function akutansi_koperasi_jurnal_manual($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $cabang = DB::table('kop_master_cabang')->get();
            $divisi = DB::table('kop_master_div_bag')->join('kop_master_divisi', 'kop_master_divisi.kop_master_divisi_code', '=', 'kop_master_div_bag.kop_master_divisi_code')->get();
            $pokok = DB::table('kop_simpanan_pokok')->get();
            $wajib = DB::table('kop_simpanan_wajib')->get();
            return view('app-koperasi.akutansi_jurnal_manual', compact('cabang', 'divisi', 'pokok', 'wajib'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // MASTER PESERTA KOPERASI
    public function master_koperasi_peserta($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('kop_master_peserta')->get();
            return view('app-koperasi.master-koperasi.master-peserta', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_koperasi_peserta_add(Request $request)
    {
        $cabang = DB::table('kop_master_cabang')->get();
        $divisi = DB::table('kop_master_div_bag')->join('kop_master_divisi', 'kop_master_divisi.kop_master_divisi_code', '=', 'kop_master_div_bag.kop_master_divisi_code')->get();
        return view('app-koperasi.master-koperasi.master-peserta.form-add', compact('cabang', 'divisi'));
    }
    public function master_koperasi_peserta_save(Request $request)
    {
        try {
            $code = str::uuid();
            DB::table('kop_master_peserta')->insert([
                'kop_master_peserta_code' => $code,
                'kop_master_peserta_nik' => $request->nik,
                'kop_master_peserta_nip' => $request->nip,
                'kop_master_peserta_name' => $request->nama_lengkap,
                'kop_master_peserta_tgl_lahir' => $request->tgl_lahir,
                'kop_master_peserta_tempat_lahir' => $request->tempat_lahir,
                'kop_master_peserta_jk' => $request->jenis_kelamin,
                'kop_master_peserta_agama' => $request->agama,
                'kop_master_peserta_alamat' => $request->alamat,
                'kop_master_peserta_cabang' => $request->cabang,
                'kop_master_peserta_email' => $request->email,
                'kop_master_peserta_no_hp' => $request->no_hp,
                'kop_master_peserta_tgl_kerja' => $request->tgl_masuk,
                'kop_master_peserta_tgl_anggota' => $request->tgl_anggota,
                'kop_master_peserta_photo' => "",
                'kop_master_peserta_status' => 1,
                'created_at' => now()
            ]);
            DB::table('kop_master_peserta_job')->insert([
                'kop_master_peserta_job_code' => str::uuid(),
                'kop_master_peserta_code' => $code,
                'kop_master_div_bag_code' => $request->divisi,
                'kop_master_peserta_job_status' => 1,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function master_koperasi_peserta_import(Request $request)
    {
        $cabang = DB::table('kop_master_cabang')->get();
        $pokok = DB::table('kop_simpanan_pokok')->get();
        $wajib = DB::table('kop_simpanan_wajib')->get();
        return view('app-koperasi.master-koperasi.master-peserta.form-upload-peserta', compact('cabang', 'pokok', 'wajib'));
    }
    public function master_koperasi_peserta_import_save(Request $request)
    {
        Excel::import(new PesertaImport($request->code, $request->pokok, $request->wajib), request()->file('file'));
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Perusahaan');
    }
    public function master_koperasi_peserta_update(Request $request)
    {
        $data = DB::table('kop_master_peserta')->where('kop_master_peserta_code', $request->code)->first();
        return view('app-koperasi.master-koperasi.master-peserta.form-update-peserta', compact('data'));
    }
    public function master_koperasi_peserta_update_save(Request $request)
    {
        return 0;
    }
    // MASTER CABANG KOPERASI
    public function master_koperasi_cabang($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('kop_master_cabang')->get();
            return view('app-koperasi.master-koperasi.master-cabang', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_koperasi_cabang_add_cabang(Request $request)
    {
        return view('app-koperasi.master-koperasi.master-cabang.form-add-cabang');
    }
    public function master_koperasi_cabang_save_cabang(Request $request)
    {
        try {
            DB::table('kop_master_cabang')->insert([
                'kop_master_cabang_code' => $request->code_cabang,
                'kop_master_cabang_name' => $request->nama_cabang,
                'kop_master_cabang_city' => $request->kota_cabang,
                'kop_master_cabang_alamat' => $request->alamat_cabang,
                'created_at' => now(),
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function master_koperasi_cabang_add_verifikasi(Request $request)
    {
        return view('app-koperasi.master-koperasi.master-cabang.form-add-verifikasi', ['code' => $request->code]);
    }
    public function master_koperasi_cabang_save_data_verifikasi(Request $request)
    {
        try {
            DB::table('kop_user_verifikasi')->insert([
                'kop_user_verifikasi_code' => str::uuid(),
                'kop_user_verifikasi_name' => $request->user_name,
                'kop_user_verifikasi_email' => $request->email,
                'kop_user_verifikasi_whatsapp' => $request->whatsapp,
                'kop_user_verifikasi_job' => $request->jabatan,
                'kop_user_verifikasi_cabang' => $request->code,
                'kop_user_verifikasi_status' => 1,
                'created_at' => now(),
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function master_koperasi_cabang_update_data_setup(Request $request)
    {
        return view('app-koperasi.master-koperasi.master-cabang.form-update-setup', ['code' => $request->code]);
    }
    public function master_koperasi_cabang_save_data_setup(Request $request)
    {
        try {
            $setup = DB::table('kop_setup_cabang_koperasi')->where('kop_setup_cabang_koperasi_cabang', $request->code)->first();
            if ($setup) {
                DB::table('kop_setup_cabang_koperasi')->where('kop_setup_cabang_koperasi_cabang', $request->code)->update([
                    'kop_setup_cabang_koperasi_jp_brg' => $request->jp_brg_max,
                    'kop_setup_cabang_koperasi_jp_uang' => $request->jp_uang_max,
                    'kop_setup_cabang_koperasi_tenor_brg' => $request->tenor_brg_max,
                    'kop_setup_cabang_koperasi_tenor_uang' => $request->tenor_uang_max,
                    'kop_setup_cabang_koperasi_bunga' => $request->bunga_angsuran,
                    'kop_setup_cabang_koperasi_admin' => $request->bunga_admin,
                    'kop_setup_cabang_koperasi_wa' => $request->metode_whatsapp,
                    'kop_setup_cabang_koperasi_email' => $request->metode_email,
                    'updated_at' => now()
                ]);
            } else {
                DB::table('kop_setup_cabang_koperasi')->insert([
                    'kop_setup_cabang_koperasi_code' => str::uuid(),
                    'kop_setup_cabang_koperasi_jp_brg' => $request->jp_brg_max,
                    'kop_setup_cabang_koperasi_jp_uang' => $request->jp_uang_max,
                    'kop_setup_cabang_koperasi_tenor_brg' => $request->tenor_brg_max,
                    'kop_setup_cabang_koperasi_tenor_uang' => $request->tenor_uang_max,
                    'kop_setup_cabang_koperasi_bunga' => $request->bunga_angsuran,
                    'kop_setup_cabang_koperasi_admin' => $request->bunga_admin,
                    'kop_setup_cabang_koperasi_wa' => $request->metode_whatsapp,
                    'kop_setup_cabang_koperasi_email' => $request->metode_email,
                    'kop_setup_cabang_koperasi_status' => 1,
                    'kop_setup_cabang_koperasi_cabang' => $request->code,
                    'created_at' => now()
                ]);
            }
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    // MASTER DIVISI KOPERASI
    public function master_koperasi_divisi($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('kop_master_divisi')->get();
            return view('app-koperasi.master-koperasi.master-divisi', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_koperasi_divisi_add(Request $request)
    {
        return view('app-koperasi.master-koperasi.master-divisi.form-add');
    }
    public function master_koperasi_divisi_save(Request $request)
    {
        try {
            DB::table('kop_master_divisi')->insert([
                'kop_master_divisi_code' => str::uuid(),
                'kop_master_divisi_name' => $request->divisi_name,
                'kop_master_divisi_type' => $request->divisi_type,
                'kop_master_divisi_status' => 1,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function master_koperasi_divisi_add_bagian(Request $request)
    {
        return view('app-koperasi.master-koperasi.master-divisi.form-add-bagian', ['code' => $request->code]);
    }
    public function master_koperasi_divisi_save_bagian(Request $request)
    {
        try {
            DB::table('kop_master_div_bag')->insert([
                'kop_master_div_bag_code' => str::uuid(),
                'kop_master_divisi_code' => $request->code,
                'kop_master_div_bag_name' => $request->bagian_name,
                'kop_master_div_bag_lvl' => $request->bagian_level,
                'kop_master_div_bag_status' => 1,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    // MASTER SIMPANAN POKOK
    public function master_koperasi_simpanan_pokok($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('kop_simpanan_pokok')->get();
            return view('app-koperasi.master-koperasi.master-simpanan-pokok', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_koperasi_simpanan_pokok_add(Request $request)
    {
        return view('app-koperasi.master-koperasi.simpanan-pokok.form-add');
    }
    public function master_koperasi_simpanan_pokok_save(Request $request)
    {
        try {
            DB::table('kop_simpanan_pokok')->insert([
                'kop_simpanan_pokok_code' => str::uuid(),
                'kop_simpanan_pokok_name' => $request->nama_simpanan,
                'kop_simpanan_pokok_nominal' => $request->nominal_simpanan,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    // MASTER SIMPANAN WAJIB
    public function master_koperasi_simpanan_wajib($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('kop_simpanan_wajib')->get();
            return view('app-koperasi.master-koperasi.master-simpanan-wajib', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_koperasi_simpanan_wajib_add(Request $request)
    {
        return view('app-koperasi.master-koperasi.simpanan-wajib.form-add');
    }
    public function master_koperasi_simpanan_wajib_save(Request $request)
    {
        try {
            DB::table('kop_simpanan_wajib')->insert([
                'kop_simpanan_wajib_code' => str::uuid(),
                'kop_simpanan_wajib_name' => $request->nama_simpanan,
                'kop_simpanan_wajib_nominal' => $request->nominal_simpanan,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    // MASTER DATA BANK
    public function master_koperasi_data_bank($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('kop_master_bank')->get();
            return view('app-koperasi.master-koperasi.master-bank', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_koperasi_data_bank_add(Request $request)
    {
        return view('app-koperasi.master-koperasi.master-bank.form-add');
    }
    public function master_koperasi_data_bank_save(Request $request)
    {
        try {
            DB::table('kop_master_bank')->insert([
                'kop_master_bank_code' => str::uuid(),
                'kop_master_bank_id' => $request->kode_bank,
                'kop_master_bank_name' => $request->nama_bank,
                'kop_master_bank_number' => $request->no_bank,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    // MASTER DATA COA
    public function master_koperasi_data_coa($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $total = DB::table('kop_master_coa_data')->where('kop_coa_data_opt', 0)->count();
            $data = DB::table('kop_master_coa')->get();
            return view('app-koperasi.master-koperasi.master-coa', ['total' => $total, 'data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_koperasi_data_coa_add_level(Request $request)
    {
        $data = DB::table('kop_master_coa_data')->where('kop_master_coa_code', $request->code)->get();
        return view('app-koperasi.master-koperasi.master-coa.form-add-level', [
            'level' => $request->level,
            'code' => $request->code,
            'nomor' => $request->nomor,
            'data' => $data
        ]);
    }
    public function master_koperasi_data_coa_save_level(Request $request)
    {
        try {
            $get = DB::table('kop_master_coa_data')->where('kop_coa_data_code', $request->code)->first();
            if (!$get) {
                $get = DB::table('kop_master_coa')->where('kop_master_coa_code', $request->code)->first();
                $no = $get->kop_master_coa_no;
            } else {
                $no = $get->kop_coa_data_no;
            }
            $total = DB::table('kop_master_coa_data')->where('kop_master_coa_code', $request->code)->count();
            DB::table('kop_master_coa_data')->insert([
                'kop_coa_data_code' => $request->code . str_pad($total + 1, 3, '0', STR_PAD_LEFT),
                'kop_master_coa_code' => $request->code,
                'kop_coa_data_no' => $no . '.' . ($total + 1),
                'kop_coa_data_name' => $request->name,
                'kop_coa_data_type' => 1,
                'kop_coa_data_level' => $request->level,
                'kop_coa_data_opt' => $request->option,
                'kop_coa_data_status' => 1,
                'created_at' => now()
            ]);
            $total = DB::table('kop_master_coa_data')->where('kop_coa_data_opt', 0)->count();
            $data = DB::table('kop_master_coa_data')->where('kop_master_coa_code', $request->code)->get();
            return view('app-koperasi.master-koperasi.master-coa.table.data-table-coa', ['data' => $data]);
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function master_koperasi_data_coa_sinskronisasi(Request $request)
    {
        $data = DB::table('kop_fin_master_coa')->get();
        return view('app-koperasi.master-koperasi.master-coa.form-sinkronisasi-data-coa', compact('data'));
    }
    public function master_koperasi_data_coa_sinskronisasi_proses(Request $request)
    {
        $data = DB::table('kop_master_coa_data')
            ->join('kop_master_coa', 'kop_master_coa.kop_master_coa_no', '=', DB::raw('LEFT(kop_master_coa_data.kop_coa_data_no, 1)'))
            ->where('kop_master_coa_data.kop_coa_data_opt', '=', 0)
            ->get();
        foreach ($data as $value) {
            $cek = DB::table('kop_fin_master_coa')->where('coa_code', $value->kop_coa_data_no)->first();
            if (!$cek) {
                DB::table('kop_fin_master_coa')->insert([
                    'coa_code' => $value->kop_coa_data_no,
                    'coa_name' => $value->kop_coa_data_name,
                    'coa_type' => $value->kop_master_coa_name,
                    'normal_balance' => $value->kop_master_coa_jenis,
                    'is_active' => 1,
                    'created_at' => now()
                ]);
            }
        }
        return 1;
    }

    // MASTER COA SETTING
    public function master_koperasi_data_coa_setting($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('kop_fin_master_coa_set')
                ->join('kop_master_cabang', 'kop_master_cabang.kop_master_cabang_code', '=', 'kop_fin_master_coa_set.fin_master_coa_set_cabang')->get();
            return view('app-koperasi.master-koperasi.master-coa-setting', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_koperasi_data_coa_setting_setup(Request $request)
    {
        $akun = DB::table('kop_fin_master_coa')->get();
        return view('app-koperasi.master-koperasi.master-coa-set.form-set-coa', compact('akun'), ['code' => $request->code]);
    }
    public function master_koperasi_data_coa_setting_save(Request $request)
    {
        try {
            DB::table('kop_fin_master_coa_set')->where('fin_master_coa_set_code', $request->code)->update([
                'fin_master_coa_set_debit' => $request->trx_1,
                'fin_master_coa_set_bunga' => $request->trx_2,
                'fin_master_coa_set_adm' => $request->trx_3,
                'fin_master_coa_set_kredit' => $request->trx_4
            ]);

            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function master_koperasi_data_coa_setting_sinkronisasi(Request $request)
    {
        $data = DB::table('kop_master_cabang')->get();
        return view('app-koperasi.master-koperasi.master-coa-set.form-sinkronisasi-cabang', compact('data'), ['code' => $request->code]);
    }
    public function master_koperasi_data_coa_setting_sinkronisasi_save(Request $request)
    {
        try {
            $data = DB::table('kop_master_coa_set')->get();
            foreach ($data as $value) {
                $cek = DB::table('kop_fin_master_coa_set')->where('fin_master_coa_set_cabang', $request->cabang)->where('fin_master_coa_set_type', $value->kop_master_coa_set_code)->first();
                if (!$cek) {
                    DB::table('kop_fin_master_coa_set')->insert([
                        'fin_master_coa_set_code' => str::uuid(),
                        'fin_master_coa_set_cabang' => $request->cabang,
                        'fin_master_coa_set_type' => $value->kop_master_coa_set_code,
                        'fin_master_coa_set_trx' => $value->kop_master_coa_set_name,
                        'fin_master_coa_set_debit' => 0,
                        'fin_master_coa_set_adm' => 0,
                        'fin_master_coa_set_bunga' => 0,
                        'fin_master_coa_set_kredit' => 0,
                        'fin_master_coa_set_status' => 1,
                        'created_at' => now()
                    ]);
                }
            }
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }


    // JURNAL MANUAL
    public function akutansi_koperasi_get_peminjaman()
    {
        $data = KopProsesPeminjamanUang::orderBy('id_kop_proses_uang', 'desc')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_proses_peminjaman_uang.kop_master_peserta_code')->get();
        return response()->json($data);
    }
    public function akutansi_koperasi_get_peminjaman_cairkan($id, Request $request)
    {
        $pinjaman = KopProsesPeminjamanUang::findOrFail($id);

        if ($pinjaman->kop_proses_uang_status === 'cair') {
            return response()->json(['success' => false, 'message' => 'Pinjaman sudah dicairkan sebelumnya!'], 400);
        }

        DB::beginTransaction();
        try {
            // 1. Update Status Pinjaman Koperasi
            $pinjaman->update([
                'kop_proses_uang_status' => 'cair',
                'kop_proses_uang_tgl' => now()->format('Y-m-d')
            ]);
            $peserta = DB::table('kop_master_peserta')->where('kop_master_peserta_code', $pinjaman->kop_master_peserta_code)->first();
            // 2. Hitung Matematika Akuntansi
            $bunga = ($pinjaman->kop_proses_uang_bunga / 100) * $pinjaman->kop_proses_uang_nominal;
            $nominalPokok = $pinjaman->kop_proses_uang_nominal + $bunga;
            $biayaAdmin = ($pinjaman->kop_proses_uang_admin / 100) * $pinjaman->kop_proses_uang_nominal + $bunga;
            $kasKeluar = $nominalPokok - $biayaAdmin;

            $headerJurnal = [
                'jurnal_tgl' => now()->format('Y-m-d'),
                'jurnal_keterangan' => "Pencairan Pinjaman Uang Rek. " . $pinjaman->kop_proses_uang_code . " an. " . $peserta->kop_master_peserta_name,
                'jurnal_ref_table' => 'kop_proses_peminjaman_uang',
                'jurnal_ref_code' => $pinjaman->kop_proses_uang_code,
                'jurnal_user' => 'Admin Keuangan',
            ];

            // Aturan Akuntansi: Debit (Piutang), Kredit (Pendapatan Admin & Kas)
            $detailJurnal = [
                ['coa_code' => '1131', 'jurnal_debit' => $nominalPokok, 'jurnal_kredit' => 0], // Piutang Anggota
                ['coa_code' => '4201', 'jurnal_debit' => 0, 'jurnal_kredit' => $biayaAdmin],   // Pendapatan Admin
                ['coa_code' => '1111', 'jurnal_debit' => 0, 'jurnal_kredit' => $kasKeluar],    // Kas/Bank Koperasi
            ];

            // 3. Eksekusi Jurnal
            $this->accountingService->createJournal($headerJurnal, $detailJurnal);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Berhasil mencairkan pinjaman dan menjurnal ke COA']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function akutansi_koperasi_get_peminjaman_barang()
    {
        $data = KopProsesPeminjamanBrg::orderBy('id_kop_proses_brg', 'desc')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_proses_peminjaman_brg.kop_master_peserta_code')->get();
        return response()->json($data);
    }
    public function akutansi_koperasi_get_peminjaman_barang_serahkan($id, Request $request)
    {
        $pinjaman = KopProsesPeminjamanBrg::findOrFail($id);

        if ($pinjaman->kop_proses_brg_status === 'diserahkan') {
            return response()->json(['success' => false, 'message' => 'Barang sudah diserahkan sebelumnya!'], 400);
        }

        DB::beginTransaction();
        try {
            // 1. Update Status Pinjaman Barang
            $pinjaman->update([
                'kop_proses_brg_status' => 'diserahkan',
                'kop_proses_brg_tgl' => now()->format('Y-m-d')
            ]);
            $peserta = DB::table('kop_master_peserta')->where('kop_master_peserta_code', $pinjaman->kop_master_peserta_code)->first();
            // 2. Hitung Nilai Akuntansi
            $bunga = ($pinjaman->kop_proses_brg_bunga / 100) * $pinjaman->kop_proses_brg_nominal;
            $nominalBarang = $pinjaman->kop_proses_brg_nominal + $bunga;
            $biayaAdmin = ($pinjaman->kop_proses_brg_admin / 100) * $pinjaman->kop_proses_brg_nominal + $bunga;

            // Total piutang anggota mencakup harga barang + admin (jika admin dimasukkan ke dalam cicilan)
            $totalPiutang = $nominalBarang + $biayaAdmin;

            $headerJurnal = [
                'jurnal_tgl' => now()->format('Y-m-d'),
                'jurnal_keterangan' => "Penyerahan Pinjaman Barang Rek. " . $pinjaman->kop_proses_brg_code . " an. " . $peserta->kop_master_peserta_name,
                'jurnal_ref_table' => 'kop_proses_peminjaman_brg',
                'jurnal_ref_code' => $pinjaman->kop_proses_brg_code,
                'jurnal_user' => 'Admin Gudang/Keuangan',
            ];

            // ATURAN AKUNTANSI BARANG:
            // Debit: Piutang Pinjaman Barang (Aset bertambah)
            // Kredit: Pendapatan Admin (Pendapatan bertambah)
            // Kredit: Persediaan Barang Koperasi (Aset berkurang karena barang keluar gudang)
            $detailJurnal = [
                ['coa_code' => '1122', 'jurnal_debit' => $totalPiutang, 'jurnal_kredit' => 0], // Piutang Barang Anggota
                ['coa_code' => '4201', 'jurnal_debit' => 0, 'jurnal_kredit' => $biayaAdmin],   // Pendapatan Admin
                ['coa_code' => '1131', 'jurnal_debit' => 0, 'jurnal_kredit' => $nominalBarang], // Persediaan Barang
            ];

            // 3. Simpan ke Jurnal lewat Service
            $this->accountingService->createJournal($headerJurnal, $detailJurnal);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Berhasil menyerahkan barang dan otomatis mencatat jurnal COA']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function akutansi_koperasi_get_vocher()
    {
        $data = KopVocherData::orderBy('id_vocher_data', 'desc')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_vocher_data.kop_master_peserta_code')->get();
        return response()->json($data);
    }
    public function akutansi_koperasi_get_vocher_cairkan($id, Request $request)
    {
        $voucher = KopVocherData::findOrFail($id);

        if ($voucher->kop_vocher_data_status === 'digunakan') {
            return response()->json(['success' => false, 'message' => 'Voucher sudah diklaim/digunakan sebelumnya!'], 400);
        }

        DB::beginTransaction();
        try {
            // 1. Update Status Voucher
            $voucher->update([
                'kop_vocher_data_status' => 'digunakan'
            ]);
            $peserta = DB::table('kop_master_peserta')->where('kop_master_peserta_code', $voucher->kop_master_peserta_code)->first();
            // 2. Hitung Parameter Akuntansi dengan Nilai Admin
            $biayaAdmin     = ($voucher->kop_vocher_data_admin / 100) * $voucher->kop_vocher_data_nominal;
            $nominalVoucher = $voucher->kop_vocher_data_nominal + $biayaAdmin;

            // Uang kas yang dikeluarkan koperasi adalah nilai voucher dikurangi potongan admin
            $kasKeluar      = $nominalVoucher - $biayaAdmin;

            $headerJurnal = [
                'jurnal_tgl'        => now()->format('Y-m-d'),
                'jurnal_keterangan' => "Pencairan Klaim Voucher Koperasi No. " . $voucher->kop_vocher_data_code . " oleh Anggota: " . $peserta->kop_master_peserta_name,
                'jurnal_ref_table'  => 'kop_vocher_data',
                'jurnal_ref_code'   => $voucher->kop_vocher_data_code,
                'jurnal_user'       => 'Admin Kasir',
            ];

            // ATURAN AKUNTANSI VOUCHER DENGAN ADMIN:
            // Debit: Beban Voucher / Promosi (Sebesar nilai kotor voucher)
            // Kredit: Pendapatan Administrasi (Dari potongan admin voucher)
            // Kredit: Kas dan Bank Koperasi (Uang bersih yang dibayarkan ke merchant/anggota)
            $detailJurnal = [
                ['coa_code' => '5501', 'jurnal_debit' => $nominalVoucher, 'jurnal_kredit' => 0], // Beban Voucher
                ['coa_code' => '4201', 'jurnal_debit' => 0, 'jurnal_kredit' => $biayaAdmin],     // Pendapatan Admin
                ['coa_code' => '1121', 'jurnal_debit' => 0, 'jurnal_kredit' => $kasKeluar],      // Kredit lewat BANK BRI
            ];

            // 3. Eksekusi Jurnal
            $this->accountingService->createJournal($headerJurnal, $detailJurnal);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Voucher berhasil dicairkan dan dijurnal ke COA']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function akutansi_koperasi_get_arisan()
    {
        $data = KopArisanGroup::orderBy('id_kop_arisan_group', 'desc')->get();
        return response()->json($data);
    }
    public function akutansi_koperasi_get_arisan_cairkan($id, Request $request)
    {
        $arisan = KopArisanGroup::findOrFail($id);

        if ($arisan->kop_arisan_group_status === 'dicairkan') {
            return response()->json(['success' => false, 'message' => 'Dana arisan grup ini sudah dicairkan sebelumnya!'], 400);
        }

        DB::beginTransaction();
        try {
            $tanggalAwal = $arisan->kop_arisan_group_date_start;
            $tanggalAkhir = $arisan->kop_arisan_group_date_end;
            $tahun1 = date('Y', strtotime($tanggalAwal));
            $tahun2 = date('Y', strtotime($tanggalAkhir));

            $bulan1 = date('m', strtotime($tanggalAwal));
            $bulan2 = date('m', strtotime($tanggalAkhir));

            $totalBulan = (($tahun2 - $tahun1) * 12) + ($bulan2 - $bulan1);
            // 1. Update Status Arisan
            $arisan->update([
                'kop_arisan_group_status' => 'dicairkan'
            ]);

            // 2. Hitung Nilai Akuntansi
            $bungaArisan = ($arisan->kop_arisan_group_bunga / 100) * ($arisan->kop_arisan_group_nominal * $totalBulan); // Jasa pengelolaan arisan untuk koperasi
            $nominalArisan = ($arisan->kop_arisan_group_nominal * $totalBulan) + $bungaArisan;
            $kasKeluar = $nominalArisan - $bungaArisan; // Net yang diterima pemenang

            $headerJurnal = [
                'jurnal_tgl' => now()->format('Y-m-d'),
                'jurnal_keterangan' => "Pencairan Dana Pemenang Arisan Grup: " . $arisan->kop_arisan_group_name . " (" . $arisan->kop_arisan_group_code . ")",
                'jurnal_ref_table' => 'kop_arisan_group',
                'jurnal_ref_code' => $arisan->kop_arisan_group_code,
                'jurnal_user' => 'Admin Arisan',
            ];

            // ATURAN AKUNTANSI ARISAN (Saat Cair ke Pemenang):
            // Debit: Hutang Arisan Anggota (Kewajiban koperasi berkurang karena dana diserahkan)
            // Kredit: Pendapatan Bunga/Jasa Arisan (Pendapatan koperasi bertambah)
            // Kredit: Kas dan Bank Koperasi (Aset berkurang untuk bayar pemenang)
            $detailJurnal = [
                ['coa_code' => '2141', 'jurnal_debit' => $nominalArisan, 'jurnal_kredit' => 0], // Hutang Arisan
                ['coa_code' => '4202', 'jurnal_debit' => 0, 'jurnal_kredit' => $bungaArisan],   // Pendapatan Jasa Arisan
                ['coa_code' => '1111', 'jurnal_debit' => 0, 'jurnal_kredit' => $kasKeluar],    // Kas/Bank
            ];

            // 3. Eksekusi Jurnal
            $this->accountingService->createJournal($headerJurnal, $detailJurnal);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Arisan berhasil dicairkan dan otomatis dijurnal ke COA']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function akutansi_koperasi_get_tagihan_bulan()
    {
        $data = KopTagihanBulan::orderBy('id_kop_tagihan_bulan', 'desc')
            ->join('kop_master_cabang', 'kop_master_cabang.kop_master_cabang_code', '=', 'kop_tagihan_bulan.kop_tagihan_bulan_cabang')->get();
        return response()->json($data);
    }
    public function akutansi_koperasi_get_tagihan_bulan_cairkan($id, Request $request)
    {
        $tagihan = KopTagihanBulan::findOrFail($id);

        if ((int)$tagihan->kop_tagihan_bulan_status === 1) {
            return response()->json(['success' => false, 'message' => 'Tagihan bulanan simpanan ini sudah lunas sebelumnya!'], 400);
        }

        DB::beginTransaction();
        try {
            // Hitung total peserta yang aktif di cabang tersebut
            $totalpeserta = DB::table('kop_master_peserta')
                ->where('kop_master_peserta_cabang', $tagihan->kop_tagihan_bulan_cabang)
                ->where('kop_master_peserta_status', 'AKTIF')
                ->count();

            // 1. Update Status Tagihan Jadi Lunas (1)
            $tagihan->update([
                'kop_tagihan_bulan_status' => 1
            ]);

            // 2. Hitung Nominal Akuntansi Simpanan Anggota
            $totalUangMasuk = $tagihan->kop_tagihan_bulan_nominal * $totalpeserta; // Total uang bruto yang diterima kasir
            $bunga          = ($tagihan->kop_tagihan_bulan_bunga / 100) * $totalUangMasuk; // Potongan jasa manajemen koperasi
            $simpananBersih = $totalUangMasuk - $bunga; // Uang murni milik anggota yang dititipkan di koperasi

            $headerJurnal = [
                'jurnal_tgl'        => now()->format('Y-m-d'),
                'jurnal_keterangan' => "Penerimaan Titipan Simpanan Bulanan Ref: " . $tagihan->kop_tagihan_bulan_code . " via Cabang: " . $tagihan->kop_tagihan_bulan_cabang . " (Total " . $totalpeserta . " Anggota Aktif)",
                'jurnal_ref_table'  => 'kop_tagihan_bulan',
                'jurnal_ref_code'   => $tagihan->kop_tagihan_bulan_code,
                'jurnal_user'       => 'Admin Kasir/Teller',
            ];

            // ATURAN AKUNTANSI REVISI (Penerimaan Simpanan Terpotong Administrasi):
            // Debit: Kas dan Bank Koperasi (Aset kas bertambah sebesar total uang kotor yang ditarik)
            // Kredit: Simpanan Anggota / Hutang Titipan (Kewajiban koperasi bertambah sebesar nilai bersih)
            // Kredit: Pendapatan Administrasi / Jasa (Pendapatan operasional koperasi bertambah dari potongan)
            $detailJurnal = [
                ['coa_code' => '1112', 'jurnal_debit' => $totalUangMasuk, 'jurnal_kredit' => 0], // Masuk ke Kas Kecil (D)
                ['coa_code' => '2112', 'jurnal_debit' => 0, 'jurnal_kredit' => $simpananBersih], // Hutang Simpanan (K)
                ['coa_code' => '4203', 'jurnal_debit' => 0, 'jurnal_kredit' => $bunga],          // Pendapatan Jasa (K)
            ];

            // 3. Masukkan ke Buku Jurnal umum
            $this->accountingService->createJournal($headerJurnal, $detailJurnal);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Simpanan bulanan berhasil diterima dan otomatis dijurnal sebagai Kewajiban COA']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    private function hitungLabaBersihInternal($dari, $sampai)
    {
        $pendapatan = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->join('kop_fin_master_coa as c', 'd.coa_code', '=', 'c.coa_code')
            ->where('c.coa_type', 'pendapatan')
            ->whereBetween('j.jurnal_tgl', [$dari, $sampai])
            ->sum(DB::raw('d.jurnal_kredit - d.jurnal_debit'));

        $beban = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->join('kop_fin_master_coa as c', 'd.coa_code', '=', 'c.coa_code')
            ->where('c.coa_type', 'beban')
            ->whereBetween('j.jurnal_tgl', [$dari, $sampai])
            ->sum(DB::raw('d.jurnal_debit - d.jurnal_kredit'));

        return [
            'total_pendapatan' => $pendapatan,
            'total_beban' => $beban,
            'laba_bersih' => $pendapatan - $beban
        ];
    }
    public function akutansi_koperasi_report_jurnal(Request $request)
    {
        $dari = $request->query('tgl_mulai', now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->query('tgl_selesai', now()->endOfMonth()->format('Y-m-d'));

        $data = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->join('kop_fin_master_coa as c', 'd.coa_code', '=', 'c.coa_code')
            ->select('j.jurnal_tgl', 'j.jurnal_no_bukti', 'j.jurnal_keterangan', 'd.coa_code', 'c.coa_name', 'd.jurnal_debit', 'd.jurnal_kredit')
            ->whereBetween('j.jurnal_tgl', [$dari, $sampai])
            ->orderBy('j.jurnal_tgl', 'asc')
            ->orderBy('j.id_jurnal', 'asc')
            ->get();

        return response()->json($data);
    }
    public function akutansi_koperasi_report_buku_besar(Request $request)
    {
        $coa = $request->query('coa_code');
        $dari = $request->query('tgl_mulai', now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->query('tgl_selesai', now()->endOfMonth()->format('Y-m-d'));

        if (!$coa) {
            return response()->json(['message' => 'Pilih kode COA terlebih dahulu'], 400);
        }

        // 1. Ambil data master COA untuk mengetahui detail akun dan normal_balance ('debit' atau 'kredit')
        $masterCoa = DB::table('kop_fin_master_coa')
            ->where('coa_code', $coa)
            ->first();

        if (!$masterCoa) {
            return response()->json(['message' => 'Kode COA tidak terdaftar di dalam sistem'], 404);
        }

        // 2. Ambil Saldo Awal sebelum tanggal mulai
        $saldoAwalData = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->select(DB::raw('SUM(d.jurnal_debit) as total_debit, SUM(d.jurnal_kredit) as total_kredit'))
            ->where('d.coa_code', $coa)
            ->where('j.jurnal_tgl', '<', $dari)
            ->first();

        // 3. Ambil data Mutasi Transaksi pada periode yang dipilih
        $mutasi = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->select('j.jurnal_tgl', 'j.jurnal_no_bukti', 'j.jurnal_keterangan', 'd.jurnal_debit', 'd.jurnal_kredit')
            ->where('d.coa_code', $coa)
            ->whereBetween('j.jurnal_tgl', [$dari, $sampai])
            ->orderBy('j.jurnal_tgl', 'asc')
            ->orderBy('j.id_jurnal', 'asc') // Tambahan order-by ID agar urutan running balance tidak acak jika tanggalnya sama
            ->get();

        // 4. Return response lengkap beserta variabel normal_balance
        return response()->json([
            'normal_balance' => $masterCoa->normal_balance, // Mengirim 'debit' atau 'kredit' ke frontend
            'coa_name'       => $masterCoa->coa_name,       // Opsional: untuk konfirmasi nama akun di frontend
            'saldo_awal'     => $saldoAwalData,
            'mutasi'         => $mutasi
        ]);
    }
    public function akutansi_koperasi_report_neraca(Request $request)
    {
        $dari = $request->query('tgl_mulai', now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->query('tgl_selesai', now()->endOfMonth()->format('Y-m-d'));

        // Hitung SHU tahun berjalan sebagai penyeimbang
        $ringkasanLaba = $this->hitungLabaBersihInternal($dari, $sampai);
        $labaBersih = (float)$ringkasanLaba['laba_bersih'];

        // 1. DETAIL AKTIVA: Aset [Kepala 1] -> Saldo Normal: (Debit - Kredit)
        $aset = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->join('kop_fin_master_coa as c', 'd.coa_code', '=', 'c.coa_code')
            ->select('d.coa_code', 'c.coa_name', DB::raw('SUM(d.jurnal_debit - d.jurnal_kredit) as total'))
            ->where('c.coa_type', 'aset')
            ->where('j.jurnal_tgl', '<=', $sampai)
            ->groupBy('d.coa_code', 'c.coa_name')
            ->having('total', '!=', 0)
            ->get();

        // 2. DETAIL PASIVA: Kewajiban/Hutang [Kepala 2] -> Saldo Normal: (Kredit - Debit)
        $kewajiban = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->join('kop_fin_master_coa as c', 'd.coa_code', '=', 'c.coa_code')
            ->select('d.coa_code', 'c.coa_name', DB::raw('SUM(d.jurnal_kredit - d.jurnal_debit) as total'))
            ->where('c.coa_type', 'kewajiban')
            ->where('j.jurnal_tgl', '<=', $sampai)
            ->groupBy('d.coa_code', 'c.coa_name')
            ->having('total', '!=', 0)
            ->get();

        // 3. DETAIL PASIVA: Modal/Ekuitas [Kepala 3] -> Saldo Normal: (Kredit - Debit)
        $modal = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->join('kop_fin_master_coa as c', 'd.coa_code', '=', 'c.coa_code')
            ->select('d.coa_code', 'c.coa_name', DB::raw('SUM(d.jurnal_kredit - d.jurnal_debit) as total'))
            ->where('c.coa_type', 'modal')
            ->where('j.jurnal_tgl', '<=', $sampai)
            ->groupBy('d.coa_code', 'c.coa_name')
            ->having('total', '!=', 0)
            ->get();

        $totalAset = $aset->sum('total');
        $totalKewajiban = $kewajiban->sum('total');
        $totalModal = $modal->sum('total');

        return response()->json([
            'aset' => $aset,
            'kewajiban' => $kewajiban,
            'modal' => $modal,
            'laba_bersih_berjalan' => $labaBersih,
            'total_aset' => (float)$totalAset,
            'total_kewajiban' => (float)$totalKewajiban,
            'total_modal' => (float)$totalModal,
            'total_pasiva' => (float)($totalKewajiban + $totalModal + $labaBersih)
        ]);
    }
    public function akutansi_koperasi_report_rugi_laba(Request $request)
    {
        $dari = $request->query('tgl_mulai', now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->query('tgl_selesai', now()->endOfMonth()->format('Y-m-d'));

        // Ambil rincian semua akun Pendapatan [Kepala 4]
        // Saldo normal Pendapatan adalah Kredit, jadi: (Kredit - Debit)
        $pendapatanDetail = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->join('kop_fin_master_coa as c', 'd.coa_code', '=', 'c.coa_code')
            ->select('d.coa_code', 'c.coa_name', DB::raw('SUM(d.jurnal_kredit - d.jurnal_debit) as total'))
            ->where('c.coa_type', 'pendapatan')
            ->whereBetween('j.jurnal_tgl', [$dari, $sampai])
            ->groupBy('d.coa_code', 'c.coa_name')
            ->having('total', '!=', 0) // Hanya tampilkan akun yang ada aktivitasnya
            ->get();

        // Ambil rincian semua akun Beban [Kepala 5]
        // Saldo normal Beban adalah Debit, jadi: (Debit - Kredit)
        $bebanDetail = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->join('kop_fin_master_coa as c', 'd.coa_code', '=', 'c.coa_code')
            ->select('d.coa_code', 'c.coa_name', DB::raw('SUM(d.jurnal_debit - d.jurnal_kredit) as total'))
            ->where('c.coa_type', 'beban')
            ->whereBetween('j.jurnal_tgl', [$dari, $sampai])
            ->groupBy('d.coa_code', 'c.coa_name')
            ->having('total', '!=', 0)
            ->get();

        // Hitung total menggunakan helper internal
        $ringkasan = $this->hitungLabaBersihInternal($dari, $sampai);

        return response()->json([
            'pendapatan' => $pendapatanDetail,
            'beban' => $bebanDetail,
            'total_pendapatan' => (float)$ringkasan['total_pendapatan'],
            'total_beban' => (float)$ringkasan['total_beban'],
            'laba_bersih' => (float)$ringkasan['laba_bersih']
        ]);
    }
    public function akutansi_koperasi_report_perubahan_modal(Request $request)
    {
        $dari = $request->query('tgl_mulai', now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->query('tgl_selesai', now()->endOfMonth()->format('Y-m-d'));

        // Hitung SHU / Laba Bersih internal untuk periode ini
        $ringkasanLaba = $this->hitungLabaBersihInternal($dari, $sampai);
        $labaBersih = (float)$ringkasanLaba['laba_bersih'];

        // Ambil rincian saldo semua akun Ekuitas/Modal [Kepala 3] sebelum ditambahkan SHU berjalan
        // Saldo normal Modal adalah Kredit, jadi: (Kredit - Debit)
        $modalDetail = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->join('kop_fin_master_coa as c', 'd.coa_code', '=', 'c.coa_code')
            ->select('d.coa_code', 'c.coa_name', DB::raw('SUM(d.jurnal_kredit - d.jurnal_debit) as total'))
            ->where('c.coa_type', 'modal')
            ->where('j.jurnal_tgl', '<=', $sampai) // Mengambil akumulasi saldo hingga tanggal akhir periode
            ->groupBy('d.coa_code', 'c.coa_name')
            ->get();

        // Hitung Total Modal Awal/Berjalan sebelum SHU dimasukkan
        $totalModalAwal = $modalDetail->sum('total');

        return response()->json([
            'detail_modal' => $modalDetail,
            'total_modal_awal' => (float)$totalModalAwal,
            'laba_bersih_shu' => $labaBersih,
            'total_modal_akhir' => (float)($totalModalAwal + $labaBersih)
        ]);
    }
    public function akutansi_koperasi_report_arus_kas(Request $request)
    {
        $dari = $request->query('tgl_mulai', now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->query('tgl_selesai', now()->endOfMonth()->format('Y-m-d'));

        $listKasBank = ['1111', '1112', '1121', '1122'];

        // 1. Ambil ID Jurnal yang melibatkan mutasi Kas/Bank pada periode ini
        $idJurnalKas = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->whereIn('d.coa_code', $listKasBank)
            ->whereBetween('j.jurnal_tgl', [$dari, $sampai])
            ->pluck('d.jurnal_id')
            ->unique();

        // 2. DETIL ARUS KAS MASUK: Akun lawan saat Kas bertambah (Debit)
        // Kita mencari akun non-kas di jurnal yang sama yang berada di posisi Kredit
        $arusMasukDetail = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_master_coa as c', 'd.coa_code', '=', 'c.coa_code')
            ->select('d.coa_code', 'c.coa_name', DB::raw('SUM(d.jurnal_kredit) as total'))
            ->whereIn('d.jurnal_id', $idJurnalKas)
            ->whereNotIn('d.coa_code', $listKasBank) // Cari akun lawannya
            ->where('d.jurnal_kredit', '>', 0)
            ->groupBy('d.coa_code', 'c.coa_name')
            ->having('total', '>', 0)
            ->get();

        // 3. DETIL ARUS KAS KELUAR: Akun lawan saat Kas berkurang (Kredit)
        // Kita mencari akun non-kas di jurnal yang sama yang berada di posisi Debit
        $arusKeluarDetail = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_master_coa as c', 'd.coa_code', '=', 'c.coa_code')
            ->select('d.coa_code', 'c.coa_name', DB::raw('SUM(d.jurnal_debit) as total'))
            ->whereIn('d.jurnal_id', $idJurnalKas)
            ->whereNotIn('d.coa_code', $listKasBank) // Cari akun lawannya
            ->where('d.jurnal_debit', '>', 0)
            ->groupBy('d.coa_code', 'c.coa_name')
            ->having('total', '>', 0)
            ->get();

        $totalMasuk = $arusMasukDetail->sum('total');
        $totalKeluar = $arusKeluarDetail->sum('total');

        return response()->json([
            'arus_masuk_detail' => $arusMasukDetail,
            'arus_keluar_detail' => $arusKeluarDetail,
            'total_arus_masuk' => (float)$totalMasuk,
            'total_arus_keluar' => (float)$totalKeluar,
            'kenaikan_bersih' => (float)($totalMasuk - $totalKeluar)
        ]);
    }

    public function akutansi_koperasi_report_jurnal_cabang(Request $request)
    {
        $dari = $request->query('tgl_mulai', now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->query('tgl_selesai', now()->endOfMonth()->format('Y-m-d'));

        $data = DB::table('kop_fin_jurnal_detail')
            ->join('kop_fin_jurnal', 'kop_fin_jurnal_detail.jurnal_id', '=', 'kop_fin_jurnal.id_jurnal')
            ->join('kop_fin_master_coa', 'kop_fin_jurnal_detail.coa_code', '=', 'kop_fin_master_coa.coa_code') // <-- WAJIB ADA JOIN INI
            ->select(
                'kop_fin_jurnal_detail.id_jurnal_detail',
                'kop_fin_jurnal.jurnal_no_bukti',
                'kop_fin_jurnal.jurnal_tgl',
                'kop_fin_jurnal.jurnal_keterangan',
                'kop_fin_jurnal_detail.coa_code',
                'kop_fin_master_coa.coa_name', // <-- Kolom nama ini yang dibutuhkan oleh JavaScript
                'kop_fin_jurnal_detail.jurnal_debit',
                'kop_fin_jurnal_detail.jurnal_kredit'
            )
            ->whereBetween('kop_fin_jurnal.jurnal_tgl', [$dari, $sampai])
            ->where('kop_fin_jurnal.jurnal_cabang', Auth::user()->access_cabang)
            ->orderBy('kop_fin_jurnal.jurnal_tgl', 'asc')
            ->orderBy('kop_fin_jurnal.id_jurnal', 'asc')
            ->get();

        return response()->json($data);
    }
    public function akutansi_koperasi_report_buku_besar_cabang(Request $request)
    {
        $coa = $request->query('coa_code');
        $dari = $request->query('tgl_mulai', now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->query('tgl_selesai', now()->endOfMonth()->format('Y-m-d'));

        if (!$coa) {
            return response()->json(['message' => 'Pilih kode COA terlebih dahulu'], 400);
        }

        // 1. Ambil data master COA untuk mengetahui detail akun dan normal_balance ('debit' atau 'kredit')
        $masterCoa = DB::table('kop_fin_master_coa')
            ->where('coa_code', $coa)
            ->first();

        if (!$masterCoa) {
            return response()->json(['message' => 'Kode COA tidak terdaftar di dalam sistem'], 404);
        }

        // 2. Ambil Saldo Awal sebelum tanggal mulai
        $saldoAwalData = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->select(DB::raw('SUM(d.jurnal_debit) as total_debit, SUM(d.jurnal_kredit) as total_kredit'))
            ->where('d.coa_code', $coa)
            ->where('j.jurnal_tgl', '<', $dari)
            ->first();

        // 3. Ambil data Mutasi Transaksi pada periode yang dipilih
        $mutasi = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')

            // 1. Join Cabang (Tetap)
            ->leftJoin('kop_master_cabang as c', 'j.jurnal_cabang', '=', 'c.kop_master_cabang_code')

            // 2. LANGSUNG JOIN ke Master Peserta Utama tanpa melalui tabel job
            ->leftJoin('kop_master_peserta as p', 'j.jurnal_user', '=', 'p.kop_master_peserta_code')

            ->select(
                'd.id_jurnal_detail',
                'j.jurnal_tgl',
                'j.jurnal_no_bukti',
                'j.jurnal_keterangan',
                'j.jurnal_cabang',
                'c.kop_master_cabang_name',
                'p.kop_master_peserta_name as nama_anggota', // Mengambil nama langsung dari tabel master
                'd.jurnal_debit',
                'd.jurnal_kredit'
            )
            ->where('d.coa_code', $coa)
            ->whereBetween('j.jurnal_tgl', [$dari, $sampai])
            ->orderBy('j.jurnal_tgl', 'asc')
            ->orderBy('d.id_jurnal_detail', 'asc')
            ->get();

        // 4. Return response lengkap beserta variabel normal_balance
        return response()->json([
            'normal_balance' => $masterCoa->normal_balance, // Mengirim 'debit' atau 'kredit' ke frontend
            'coa_name'       => $masterCoa->coa_name,       // Opsional: untuk konfirmasi nama akun di frontend
            'saldo_awal'     => $saldoAwalData,
            'mutasi'         => $mutasi
        ]);
    }
    public function akutansi_koperasi_report_rugi_laba_cabang(Request $request)
    {
        $dari = $request->query('tgl_mulai', now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->query('tgl_selesai', now()->endOfMonth()->format('Y-m-d'));

        // Ambil rincian semua akun Pendapatan [Kepala 4]
        // Saldo normal Pendapatan adalah Kredit, jadi: (Kredit - Debit)
        $pendapatanDetail = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->join('kop_fin_master_coa as c', 'd.coa_code', '=', 'c.coa_code')
            ->select('d.coa_code', 'c.coa_name', DB::raw('SUM(d.jurnal_kredit - d.jurnal_debit) as total'))
            ->where('c.coa_type', 'pendapatan')
            ->whereBetween('j.jurnal_tgl', [$dari, $sampai])
            ->groupBy('d.coa_code', 'c.coa_name')
            ->having('total', '!=', 0) // Hanya tampilkan akun yang ada aktivitasnya
            ->get();

        // Ambil rincian semua akun Beban [Kepala 5]
        // Saldo normal Beban adalah Debit, jadi: (Debit - Kredit)
        $bebanDetail = DB::table('kop_fin_jurnal_detail as d')
            ->join('kop_fin_jurnal as j', 'd.jurnal_id', '=', 'j.id_jurnal')
            ->join('kop_fin_master_coa as c', 'd.coa_code', '=', 'c.coa_code')
            ->select('d.coa_code', 'c.coa_name', DB::raw('SUM(d.jurnal_debit - d.jurnal_kredit) as total'))
            ->where('c.coa_type', 'beban')
            ->whereBetween('j.jurnal_tgl', [$dari, $sampai])
            ->groupBy('d.coa_code', 'c.coa_name')
            ->having('total', '!=', 0)
            ->get();

        // Hitung total menggunakan helper internal
        $ringkasan = $this->hitungLabaBersihInternal($dari, $sampai);

        return response()->json([
            'pendapatan' => $pendapatanDetail,
            'beban' => $bebanDetail,
            'total_pendapatan' => (float)$ringkasan['total_pendapatan'],
            'total_beban' => (float)$ringkasan['total_beban'],
            'laba_bersih' => (float)$ringkasan['laba_bersih']
        ]);
    }
}
