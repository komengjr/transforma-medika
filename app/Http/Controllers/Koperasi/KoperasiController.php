<?php

namespace App\Http\Controllers\Koperasi;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;

class KoperasiController extends Controller
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
            ->get();
        return view('app-koperasi.menu-peminjaman.peminjaman-uang.form-cari-data', compact('data'));
    }
    public function menu_peminjaman_uang_pilih_peserta(Request $request)
    {
        $data = DB::table('kop_master_peserta')
            ->join('kop_master_cabang', 'kop_master_cabang.kop_master_cabang_code', '=', 'kop_master_peserta.kop_master_peserta_cabang')
            ->join('kop_setup_cabang_koperasi', 'kop_setup_cabang_koperasi.kop_setup_cabang_koperasi_cabang', '=', 'kop_master_peserta.kop_master_peserta_cabang')
            ->join('kop_master_peserta_job', 'kop_master_peserta_job.kop_master_peserta_code', '=', 'kop_master_peserta.kop_master_peserta_code')
            ->join('kop_master_div_bag', 'kop_master_div_bag.kop_master_div_bag_code', '=', 'kop_master_peserta_job.kop_master_div_bag_code')
            ->join('kop_master_divisi', 'kop_master_divisi.kop_master_divisi_code', '=', 'kop_master_div_bag.kop_master_divisi_code')
            ->where('kop_master_peserta.kop_master_peserta_code', $request->code)->first();
        return view('app-koperasi.menu-peminjaman.peminjaman-uang.form-peminjaman-uang', ['data' => $data]);
    }
    public function menu_peminjaman_uang_proses_pengajuan(Request $request){
        return 123;
    }
    // MENU PEMINJAMAN BARANG
    public function menu_peminjaman_barang($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('farm_data_obat')->get();
            return view('app-farmasi.penjualan.penjualan-non-resep', ['data' => $data, 'akses' => $akses, 'code' => $id]);
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
}
