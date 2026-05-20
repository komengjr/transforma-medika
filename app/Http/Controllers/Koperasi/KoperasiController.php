<?php

namespace App\Http\Controllers\Koperasi;

use App\Http\Controllers\Controller;
use App\Imports\Koperasi\PesertaImport;
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
            $setup = DB::table('kop_setup_cabang_koperasi')->where('kop_setup_cabang_koperasi_cabang', $request->cabang)->first();
            if ($setup->kop_setup_cabang_koperasi_wa == '0' || $setup->kop_setup_cabang_koperasi_email == '0') {
                $status = 0;
            } elseif ($setup->kop_setup_cabang_koperasi_wa == '0') {
                $status = 0;
            } elseif ($setup->kop_setup_cabang_koperasi_email == '0') {
                $status = 0;
            } else {
                $status = 1;
            }
            $code = str::uuid();
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
                'kop_master_peserta_status' => $status,
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
        $data = DB::table('kop_master_peserta')->where('kop_master_peserta_cabang', Auth::user()->access_cabang)->get();
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
    // MENU VOCHER KOPERASI
    public function menu_koperasi_vocher($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('kop_vocher_data')
                ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_vocher_data.kop_master_peserta_code')
                ->join('kop_user_verifikasi', 'kop_user_verifikasi.kop_user_verifikasi_code', '=', 'kop_vocher_data.kop_vocher_data_ketua')
                ->where('kop_vocher_data_cabang', Auth::user()->access_cabang)->get();
            return view('app-koperasi.menu-vocher-koperasi', compact('data'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
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
            DB::table('kop_vocher_data')->insert([
                'kop_vocher_data_code' => str::uuid(),
                'kop_vocher_data_token' => str::uuid(),
                'kop_master_peserta_code' => $request->anggota,
                'kop_vocher_cat_code' => $request->kategori,
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
        return view('app-koperasi.menu-vocher.form-proses-vocher', ['data' => $data]);
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
            $nomorhp = $data->kop_user_verifikasi_whatsapp;
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
            $link = route('data_vocher_koperasi', ['code' => $data->kop_vocher_data_code]);
            $text = "Halo " . $data->kop_user_verifikasi_name . "\n\nDengan Nomor Vocher : " . $data->kop_vocher_data_code .
                "\nAda Pengeluaran Vocher Sebagai Berikut\nNama :" . $data->kop_master_peserta_name . "\nNominal Vocher : Rp." . number_format($data->kop_vocher_data_nominal, 0, ',', '.') . "\nSilahkan Untuk Sign Di bawah ini:\n" . $link . "\n\nLogIT System Notifikasi";
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
            $data = DB::table('kop_vocher_data')->where('kop_vocher_data_code', $request->data_vocher)->first();
            try {
                $cek = DB::table('kop_log_vocher')->where('kop_vocher_data_code', $request->data_vocher)->first();
                if ($cek) {
                    return 0;
                } else {
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
        return view('app-koperasi.menu-vocher.form-pelunasan-vocher', compact('data'));
    }
    public function menu_koperasi_vocher_pelunasan_payment(Request $request)
    {
        $verif = DB::table('kop_vocher_data_verif')->where('kop_vocher_data_code', $request->data_vocher)->first();
        if ($verif) {
            $data = DB::table('kop_vocher_data')->where('kop_vocher_data_code', $request->data_vocher)->first();
            try {
                $cek = DB::table('kop_log_vocher')->where('kop_vocher_data_code', $request->data_vocher)->first();
                if ($cek) {
                    return 0;
                } else {
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
            $data = DB::table('kop_tagihan_bulan')->get();
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
            DB::table('kop_tagihan_bulan')->insert([
                'kop_tagihan_bulan_code' => str::uuid(),
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
            ->where('kop_master_peserta.kop_master_peserta_status', 1)
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
        return view('app-koperasi.menu-iuran.form-generate-tagihan', compact('data'), ['code' => $request->code]);
    }
    public function menu_koperasi_iuran_proses_peserta_payment(Request $request)
    {
        $data = DB::table('kop_tagihan_bulan_peserta')->where('kop_tagihan_bulan_code', $request->code)->get();
        foreach ($data as $datas) {
            $cek = DB::table('kop_log_tagihan_bulan')->where('kop_tagihan_bulan_peserta_code', $datas->kop_tagihan_bulan_peserta_code)->first();
            if (!$cek) {
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
            DB::table('kop_simpanan_sukarela')->insert([
                'kop_simpanan_sukarela_code' => str::uuid(),
                'kop_master_peserta_code' => $request->anggota,
                'kop_tagihan_bulan_peserta_pokok' => $request->nominal - (($request->bunga / 100) * $request->nominal),
                'kop_tagihan_bulan_peserta_bunga' => $request->bunga,
                'kop_tagihan_bulan_peserta_nominal' => $request->nominal,
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
        return view('app-koperasi.menu-simpanan-sukarela.form-proses-simpanan-sukarela', compact('data'));
    }
    public function menu_koperasi_sukarela_proses_save(Request $request)
    {
        $data = DB::table('kop_simpanan_sukarela')->where('kop_simpanan_sukarela_code', $request->code)->first();
        try {
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
            ->where('kop_master_peserta.kop_master_peserta_status', 1)
            ->get();
        return view('app-koperasi.menu-peminjaman.peminjaman-uang.form-cari-data', compact('data'));
    }
    public function menu_peminjaman_uang_pilih_peserta(Request $request)
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
        return view('app-koperasi.menu-peminjaman.peminjaman-uang.form-peminjaman-uang', ['data' => $data, 'kcb' => $kcb, 'mgr' => $mgr]);
    }
    public function menu_peminjaman_uang_proses_pengajuan(Request $request)
    {
        try {
            $integer = preg_replace('/[^0-9]/', '', $request->nominal_pinjam);
            DB::table('kop_proses_peminjaman_uang')->insert([
                'kop_proses_uang_code' => str::uuid(),
                'kop_master_peserta_code' => $request->peserta_koperasi,
                'kop_proses_uang_nominal' => $integer,
                'kop_proses_uang_tgl' => $request->tgl_pinjam,
                'kop_proses_uang_tenor' => $request->tenor,
                'kop_proses_uang_bunga' => $request->bunga_pinjam,
                'kop_proses_uang_admin' => $request->biaya_admin,
                'kop_proses_uang_kacab' => $request->kepala_cabang,
                'kop_proses_uang_ketua' => $request->ketua_koperasi,
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
    // MENU LIST PEMINJAMAN
    public function menu_peminjaman_list($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('kop_proses_peminjaman_uang')
                ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_proses_peminjaman_uang.kop_master_peserta_code')
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
        return view('app-koperasi.menu-peminjaman.peminjaman-list.form-proses-pengajuan', ['code' => $request->code, 'data' => $data]);
    }
    public function menu_peminjaman_list_proses_pengajuan_send_verif(Request $request)
    {
        try {
            $data = DB::table('kop_proses_peminjaman_uang')->where('kop_proses_uang_code', $request->code)->first();

            // DATA KACAB
            $kcb = DB::table('kop_proses_verif')->where('kop_proses_uang_code', $request->code)->where('kop_proses_verif_user', $data->kop_proses_uang_kacab)->first();
            if ($kcb) {
            } else {
                $userkacab = DB::table('kop_user_verifikasi')->where('kop_user_verifikasi_code', $data->kop_proses_uang_kacab)->first();
                DB::table('kop_proses_verif')->insert([
                    'kop_proses_verif_code' => str::uuid(),
                    'kop_proses_uang_code' => $request->code,
                    'kop_proses_verif_user' => $data->kop_proses_uang_kacab,
                    'kop_proses_verif_status' => 0,
                    'created_at' => now()
                ]);

                $nomorhp = $userkacab->kop_user_verifikasi_whatsapp;
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
                $verifikasi = DB::table('kop_proses_verif')->where('kop_proses_uang_code', $request->code)->where('kop_proses_verif_user', $data->kop_proses_uang_kacab)->first();
                $link = route('data_peminjaman_uang', ['code' => $verifikasi->kop_proses_verif_code]);
                $text = "Halo " . $userkacab->kop_user_verifikasi_name . "\nAda Pengajuan Peminjaman silahkan Untuk Melihat data di bawah ini :\n" . $link . "\nLogIT System Notifikasi";
                DB::table('kop_sender_wa')->insert([
                    'kop_sender_wa_code' => str::uuid(),
                    'kop_sender_wa_code_token' => str::uuid(),
                    'kop_sender_wa_code_number' => $nomorhp,
                    'kop_sender_wa_code_name' => $userkacab->kop_user_verifikasi_name,
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
                $text = "Halo " . $userketua->kop_user_verifikasi_name . "\nAda Pengajuan Peminjaman silahkan Untuk Melihat data di bawah ini :\n" . $link . "\nLogIT System Notifikasi";
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
            $data = DB::table('kop_proses_peminjaman_uang')->where('kop_proses_uang_code', $request->code)->first();
            $pokok = $data->kop_proses_uang_nominal / $data->kop_proses_uang_tenor;
            $suku_bunga = ($data->kop_proses_uang_nominal * ($data->kop_proses_uang_bunga / 100) * ($data->kop_proses_uang_tenor / 12)) / $data->kop_proses_uang_tenor;
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
        return view('app-koperasi.menu-peminjaman.peminjaman-list.form-kontrak', ['code' => $request->code, 'data' => $data]);
    }
    public function menu_peminjaman_list_cek_kontrak_payment(Request $request)
    {
        $data = DB::table('kop_log_peminjaman_uang')->where('kop_log_peminjaman_uang_code', $request->code)->first();
        return view('app-koperasi.menu-peminjaman.peminjaman-list.form-payment-kontrak', ['data' => $data]);
    }
    public function menu_peminjaman_list_cek_kontrak_payment_fix(Request $request)
    {
        DB::table('kop_log_peminjaman_uang')->where('kop_log_peminjaman_uang_code', $request->code)->update([
            'kop_log_peminjaman_uang_status' => 1,
            'updated_at' => now(),
        ]);
        return 'Berhasil Payment';
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

            return view('app-koperasi.laporan-pembagian-shu', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
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
            return view('app-koperasi.akutansi_jurnal_otomatis', compact('cabang', 'divisi', 'pokok', 'wajib'), ['akses' => $akses, 'code' => $id]);
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
        $data = DB::table('acc_master_coa_data')->where('acc_master_coa_code', $request->code)->get();
        return view('app-koperasi.master-koperasi.master-coa.form-add-level', [
            'level' => $request->level,
            'code' => $request->code,
            'nomor' => $request->nomor,
            'data' => $data
        ]);
    }
}
