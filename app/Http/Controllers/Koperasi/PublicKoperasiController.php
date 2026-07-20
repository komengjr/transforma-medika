<?php

namespace App\Http\Controllers\Koperasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PublicKoperasiController extends Controller
{
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
    public function data_vocher($code)
    {
        $data = DB::table('kop_vocher_data')
            ->join('kop_master_cabang', 'kop_master_cabang.kop_master_cabang_code', '=', 'kop_vocher_data.kop_vocher_data_cabang')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_vocher_data.kop_master_peserta_code')
            ->where('kop_vocher_data.kop_vocher_data_code', $code)->first();
        if ($data) {
            if ($data->kop_vocher_data_status == '0') {

                $ketua = DB::table('kop_user_verifikasi')->where('kop_user_verifikasi_cabang', $data->kop_master_cabang_code)
                    ->where('kop_user_verifikasi_job', 1)
                    ->where('kop_user_verifikasi_status', 1)->first();
                return view('app-koperasi.public.form-sign-vocher', compact('data', 'ketua'));
            } else {
                return redirect()->route('login');
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function data_vocher_save_sign(Request $request)
    {
        $data = DB::table('kop_vocher_data_verif')->where('kop_vocher_data_code', $request->code)->first();
        if ($data) {
            return 0;
        } else {
            DB::table('kop_vocher_data_verif')->insert([
                'kop_vocher_data_verif_code' => str::uuid(),
                'kop_vocher_data_code' => $request->code,
                'kop_vocher_data_verif_sign' => $request->sign,
                'kop_vocher_data_verif_date' => now(),
                'created_at' => now()
            ]);
            DB::table('kop_vocher_data')->where('kop_vocher_data_code', $request->code)->update([
                'kop_vocher_data_status' => 1,
                'updated_at' => now()
            ]);
            return 1;
        }
    }
    public function data_peminjaman_uang($code)
    {
        $data = DB::table('kop_proses_verif')
            ->join('kop_proses_peminjaman_uang', 'kop_proses_peminjaman_uang.kop_proses_uang_code', '=', 'kop_proses_verif.kop_proses_uang_code')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_proses_peminjaman_uang.kop_master_peserta_code')
            ->join('kop_master_cabang', 'kop_master_cabang.kop_master_cabang_code', '=', 'kop_master_peserta.kop_master_peserta_cabang')
            ->join('kop_user_verifikasi', 'kop_user_verifikasi.kop_user_verifikasi_code', '=', 'kop_proses_verif.kop_proses_verif_user')
            ->where('kop_proses_verif.kop_proses_verif_code', $code)->first();
        if ($data) {
            if ($data->kop_proses_verif_status == '0') {
                return view('app-koperasi.public.form-sign-data-peminjaman', compact('data'));
            } else {
                return redirect()->route('login');
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function data_peminjaman_barang($code)
    {
        $data = DB::table('kop_proses_verif_brg')
            ->join('kop_proses_peminjaman_brg', 'kop_proses_peminjaman_brg.kop_proses_brg_code', '=', 'kop_proses_verif_brg.kop_proses_brg_code')
            ->join('kop_master_peserta', 'kop_master_peserta.kop_master_peserta_code', '=', 'kop_proses_peminjaman_brg.kop_master_peserta_code')
            ->join('kop_master_cabang', 'kop_master_cabang.kop_master_cabang_code', '=', 'kop_master_peserta.kop_master_peserta_cabang')
            ->join('kop_user_verifikasi', 'kop_user_verifikasi.kop_user_verifikasi_code', '=', 'kop_proses_verif_brg.kop_proses_verif_brg_user')
            ->where('kop_proses_verif_brg.kop_proses_verif_brg_code', $code)->first();
        if ($data) {
            if ($data->kop_proses_verif_brg_status == '0') {
                return view('app-koperasi.public.form-sign-data-peminjaman-barang', compact('data'));
            } else {
                return redirect()->route('login');
            }
        } else {
            return redirect()->route('login');
        }
    }
    public function data_peminjaman_uang_sign(Request $request)
    {
        try {
            if ($request->persetujuan == 'Y') {
                DB::table('kop_proses_verif')->where('kop_proses_verif_code', $request->code)->update([
                    'kop_proses_verif_sign' => $request->sign,
                    'kop_proses_verif_date' => now(),
                    'kop_proses_verif_status' => 1,
                    'updated_at' => now()
                ]);
                // DATA KACAB
                $data = DB::table('kop_proses_peminjaman_uang')->where('kop_proses_uang_code', $request->proses)->first();

                $kcb = DB::table('kop_proses_verif')->where('kop_proses_uang_code', $request->proses)->where('kop_proses_verif_user', $data->kop_proses_uang_kacab)->first();
                if ($kcb) {
                } else {
                    $userkacab = DB::table('kop_user_verifikasi')->where('kop_user_verifikasi_code', $data->kop_proses_uang_kacab)->first();
                    DB::table('kop_proses_verif')->insert([
                        'kop_proses_verif_code' => str::uuid(),
                        'kop_proses_uang_code' => $request->proses,
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
                    $verifikasi = DB::table('kop_proses_verif')->where('kop_proses_uang_code', $request->proses)->where('kop_proses_verif_user', $data->kop_proses_uang_kacab)->first();
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
                        'kop_sender_wa_code_user' => 'System',
                        'created_at' => now()
                    ]);
                }
            } elseif ($request->persetujuan == 'N') {
                DB::table('kop_proses_verif')->where('kop_proses_verif_code', $request->code)->update([
                    'kop_proses_verif_sign' => $request->sign,
                    'kop_proses_verif_date' => now(),
                    'kop_proses_verif_status' => 1,
                    'updated_at' => now()
                ]);
                DB::table('kop_proses_peminjaman_uang')->where('kop_proses_uang_code', $request->proses)->update([
                    'kop_proses_uang_status' => '-1'
                ]);
            }
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function data_peminjaman_barang_sign(Request $request)
    {
        try {
            if ($request->persetujuan == 'Y') {
                DB::table('kop_proses_verif_brg')->where('kop_proses_verif_brg_code', $request->code)->update([
                    'kop_proses_verif_brg_sign' => $request->sign,
                    'kop_proses_verif_brg_date' => now(),
                    'kop_proses_verif_brg_status' => 1,
                    'updated_at' => now()
                ]);
                // DATA KACAB
                $data = DB::table('kop_proses_peminjaman_brg')->where('kop_proses_brg_code', $request->proses)->first();

                $kcb = DB::table('kop_proses_verif_brg')->where('kop_proses_brg_code', $request->proses)->where('kop_proses_verif_brg_user', $data->kop_proses_brg_kacab)->first();
                if ($kcb) {
                } else {
                    $userkacab = DB::table('kop_user_verifikasi')->where('kop_user_verifikasi_code', $data->kop_proses_brg_kacab)->first();
                    DB::table('kop_proses_verif_brg')->insert([
                        'kop_proses_verif_brg_code' => str::uuid(),
                        'kop_proses_brg_code' => $request->proses,
                        'kop_proses_verif_brg_user' => $data->kop_proses_brg_kacab,
                        'kop_proses_verif_brg_status' => 0,
                        'created_at' => now()
                    ]);

                    $nomorhp = $this->stup_no_wa($userkacab->kop_user_verifikasi_whatsapp);

                    $verifikasi = DB::table('kop_proses_verif_brg')->where('kop_proses_brg_code', $request->proses)->where('kop_proses_verif_brg_user', $data->kop_proses_brg_kacab)->first();
                    $link = route('data_peminjaman_barang', ['code' => $verifikasi->kop_proses_verif_brg_code]);
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
                        'kop_sender_wa_code_user' => 'System',
                        'created_at' => now()
                    ]);
                }
            } elseif ($request->persetujuan == 'N') {
                DB::table('kop_proses_verif_brg')->where('kop_proses_verif_brg_code', $request->code)->update([
                    'kop_proses_verif_brg_sign' => $request->sign,
                    'kop_proses_verif_brg_date' => now(),
                    'kop_proses_verif_brg_status' => 1,
                    'updated_at' => now()
                ]);
                DB::table('kop_proses_peminjaman_brg')->where('kop_proses_brg_code', $request->proses)->update([
                    'kop_proses_brg_status' => '-1'
                ]);
            }
            return 1;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function data_persetujuan_form()
    {
        return view('app-koperasi.public.form-validasi-persetujuan');
    }
    public function data_persetujuan_form_get_data($id)
    {
        $pengajuan = DB::table('kop_trx_pembelian_anggota as pa')
            ->join('kop_master_peserta as p', 'pa.anggota_id', '=', 'p.id_kop_master_peserta')
            ->select('pa.*', 'p.kop_master_peserta_name', 'p.kop_master_peserta_code')
            ->where('pa.nota_nomor', $id)
            ->first();

        if (!$pengajuan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nomor nota transaksi tidak ditemukan di sistem.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $pengajuan
        ]);
    }
    public function data_persetujuan_form_proses(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pembelian' => 'required|integer',
            'keputusan'    => 'required|in:DISETUJUI,DITOLAK',
            'alasan'       => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal: ' . implode(', ', $validator->errors()->all())
            ], 422);
        }

        // 2. Cari data pengajuan pembelian barang
        $pembelian = DB::table('kop_trx_pembelian_anggota')
            ->where('id_pembelian', $request->id_pembelian)
            ->first();

        if (!$pembelian) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data transaksi pengajuan tidak ditemukan di sistem.'
            ], 404);
        }

        // Pastikan nota yang diproses statusnya masih PENDING
        if ($pembelian->status_persetujuan !== 'PENDING') {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi ini sudah pernah diproses sebelumnya dengan status: ' . $pembelian->status_persetujuan
            ], 400);
        }

        // 3. Eksekusi Database Transaction
        DB::beginTransaction();
        try {
            $namaKetua = auth()->user()->name ?? 'Ketua Koperasi';

            if ($request->keputusan === 'DISETUJUI') {

                // A. Update status induk transaksi menjadi DISETUJUI
                DB::table('kop_trx_pembelian_anggota')
                    ->where('id_pembelian', $request->id_pembelian)
                    ->update([
                        'status_persetujuan'  => 'DISETUJUI',
                        'disetujui_oleh'       => $namaKetua,
                        'tanggal_persetujuan' => now(),
                        'updated_at'          => now()
                    ]);

                // B. GENERATE OTOMATIS JADWAL TENOR (ANGSURAN BULANAN)
                $tglBaseline = $pembelian->tanggal_transaksi;

                for ($i = 1; $i <= $pembelian->tenor_bulan; $i++) {
                    // Membuat tanggal jatuh tempo bertambah 1 bulan dari bulan sebelumnya
                    $jatuhTempo = date('Y-m-d', strtotime("+$i month", strtotime($tglBaseline)));

                    DB::table('kop_trx_pembelian_tenor')->insert([
                        'id_pembelian'   => $pembelian->id_pembelian,
                        'angsuran_ke'    => $i,
                        'jatuh_tempo'    => $jatuhTempo,
                        'jumlah_tagihan' => $pembelian->cicilan_per_bulan,
                        'status_bayar'   => 'BELUM',
                        'created_at'     => now(),
                        'updated_at'     => now()
                    ]);
                }

                $pesan = 'Pengajuan pembelian barang berhasil DISETUJUI. Jadwal tenor angsuran bulanan telah diaktifkan ke sistem penagihan.';
            } else {

                // C. Jika DITOLAK, cukup ubah status dan rekam alasannya
                DB::table('kop_trx_pembelian_anggota')
                    ->where('id_pembelian', $request->id_pembelian)
                    ->update([
                        'status_persetujuan'  => 'DITOLAK',
                        'alasan_penolakan'    => $request->alasan,
                        'disetujui_oleh'       => $namaKetua,
                        'tanggal_persetujuan' => now(),
                        'updated_at'          => now()
                    ]);

                $pesan = 'Pengajuan pembelian barang telah DITOLAK oleh Ketua Koperasi.';
            }

            // Commit perubahan ke database
            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => $pesan
            ], 200);
        } catch (Exception $e) {
            // Batalkan semua query jika terjadi kegagalan/error di tengah jalan
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan sistem internal: ' . $e->getMessage()
            ], 500);
        }
    }
}
