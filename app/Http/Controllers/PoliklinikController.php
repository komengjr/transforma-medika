<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Svg\Tag\Rect;

class PoliklinikController extends Controller
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
    // DATA REGISTRASI POLI
    public function data_registrasi_poli($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_poli')->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_poli.d_reg_order_code')
                ->join('m_doctor_poli', 'm_doctor_poli.m_doctor_poli_code', '=', 'd_reg_order_poli.m_doctor_poli_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('t_layanan_data', 't_layanan_data.t_layanan_data_code', '=', 'm_doctor_poli.t_layanan_data_code')
                ->join('master_doctor', 'master_doctor.master_doctor_code', '=', 'm_doctor_poli.master_doctor_code')
                ->where('d_reg_order.d_reg_order_cabang', Auth::user()->access_cabang)->orderBy('id_d_reg_order', 'DESC')
                ->get();
            return view('application.poliklinik.data-registrasi-poliklinik', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_registrasi_poli_handling(Request $request)
    {
        $data = DB::table('d_reg_order_poli')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_poli.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_poli.d_reg_order_poli_code', $request->code)
            ->first();
        $fisik = DB::table('diag_poli_fisik_umum')->where('diag_poli_fisik_type', 'text')->get();
        $fisik1 = DB::table('diag_poli_fisik_umum')->where('diag_poli_fisik_type', 'textarea')->get();
        return view('application.poliklinik.data-registrasi.form-handling', [
            'data' => $data,
            'code' => $request->code,
            'fisik' => $fisik,
            'fisik1' => $fisik1
        ]);
    }
    public function data_registrasi_poli_handling_pasien(Request $request)
    {
        $form = DB::table('diag_poli_fisik_umum')->get();
        foreach ($form as $f) {
            $data = $f->diag_poli_fisik_umum_code;
            if ($request[$data] == "") {
                # code...
            } else {
                $cek = DB::table('diag_poli_fisik_umum_d')
                    ->where('diag_poli_fisik_umum_code', $f->diag_poli_fisik_umum_code)
                    ->where('d_reg_order_poli_code', $request->no_registrasi)->first();
                if ($cek) {
                    $cek = DB::table('diag_poli_fisik_umum_d')
                        ->where('diag_poli_fisik_umum_code', $f->diag_poli_fisik_umum_code)
                        ->where('d_reg_order_poli_code', $request->no_registrasi)->update([
                                'diag_poli_fisik_umum_d_val' => $request[$data],
                                'updated_at' => now()
                            ]);
                } else {
                    DB::table('diag_poli_fisik_umum_d')->insert([
                        'diag_poli_fisik_umum_d_code' => str::uuid(),
                        'diag_poli_fisik_umum_code' => $f->diag_poli_fisik_umum_code,
                        'd_reg_order_poli_code' => $request->no_registrasi,
                        'diag_poli_fisik_umum_d_val' => $request[$data],
                        'created_at' => now()
                    ]);
                }
            }
        }
        DB::table('d_reg_order_poli')->where('d_reg_order_poli_code', $request->no_registrasi)->update([
            'd_reg_order_poli_status' => 1
        ]);
        return '<span class="badge bg-primary">Done</span>';
    }
    // POLIKLINIK HANDLING
    public function data_registrasi_poliklinik_handling($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_poli')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_poli.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('m_doctor_poli', 'm_doctor_poli.m_doctor_poli_code', '=', 'd_reg_order_poli.m_doctor_poli_code')
                ->join('t_layanan_data', 't_layanan_data.t_layanan_data_code', '=', 'm_doctor_poli.t_layanan_data_code')
                ->join('master_doctor', 'master_doctor.master_doctor_code', '=', 'm_doctor_poli.master_doctor_code')
                ->where('d_reg_order.d_reg_order_cabang', Auth::user()->access_cabang)
                ->where('d_reg_order_poli.d_reg_order_poli_status', 1)->get();
            return view('application.poliklinik.poliklinik-handling', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_registrasi_poliklinik_handling_detail(Request $request)
    {
        $data = DB::table('d_reg_order_poli')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_poli.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order.d_reg_order_code', $request->code)->first();
        $layanan = DB::table('t_layanan_cat')->get();
        return view('application.poliklinik.poliklinik-handling.form-handling', ['data' => $data, 'layanan' => $layanan, 'code' => $request->code]);
    }
    public function data_registrasi_poliklinik_handling_order_layanan(Request $request)
    {
        //RADIOLOGI
        if ($request->code == '80304154-baeb-4b7a-8ba8-f818726a84df') {
            $dokter = DB::table('master_doctor')->get();
            $pemeriksaan = DB::table('p_sales_data')
                ->join('p_sales_cat', 'p_sales_cat.p_sales_cat_code', '=', 'p_sales_data.p_sales_cat_code')
                ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
                ->where('p_sales_cat.t_layanan_cat_code', $request->code)
                ->where('p_sales_cat.p_sales_cat_name', 'PEMERIKSAAN')
                ->get();
            return view('application.poliklinik.poliklinik-handling.order-radiologi', ['reg' => $request->reg, 'dokter' => $dokter, 'code' => $request->code, 'pemeriksaan' => $pemeriksaan]);
        } else {
            return $request->code;
        }
    }
    public function data_registrasi_poliklinik_handling_order_layanan_rad(Request $request)
    {
        $total = DB::table('d_reg_order_rad')->where('d_reg_order_code', $request->no_reg)->count();
        $pemeriksaan = DB::table('p_sales_data')->where('p_sales_data_code', $request->pemeriksaan)->first();
        $code = 'R' . $request->no_reg . str_pad($total + 1, 4, '0', STR_PAD_LEFT);
        DB::table('d_reg_order_list')->insert([
            'd_reg_order_list_code' => $code,
            'd_reg_order_code' => $request->no_reg,
            't_layanan_cat_code' => $request->layanan,
            'd_reg_order_list_date' => now(),
            'created_at' => now(),
        ]);
        DB::table('d_reg_order_rad')->insert([
            'd_reg_order_rad_code' => $code,
            'd_reg_order_code' => $request->no_reg,
            'd_reg_order_rad_dr_rujukan' => $request->dokter,
            'd_reg_order_rad_date' => now(),
            'd_reg_order_rad_desc' => $request->desc,
            'd_reg_order_rad_number' => 1,
            'd_reg_order_rad_status' => 0,
            'd_reg_order_rad_user' => Auth::user()->userid,
            'created_at' => now()
        ]);
        DB::table('d_reg_order_rad_list')->insert([
            'order_rad_list_code' => str::uuid(),
            'd_reg_order_rad_code' => $code,
            'p_sales_data_code' => $request->pemeriksaan,
            'order_rad_log_price' => $pemeriksaan->p_sales_data_price,
            'order_rad_log_discount' => $pemeriksaan->p_sales_data_disc,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Order');
    }

    public function data_registrasi_poliklinik_save_odontogram(Request $request)
    {
        $datas = $request->data;
        $json = $request->data;

        // Ubah JSON jadi array
        $data = json_decode($json, true);

        // Ambil semua key di level atas
        $keys = array_keys($data);
        if ($datas == '[]') {
            return 0;
        } else {
            foreach ($data as $key => $value) {
                $cek = DB::table('diag_poli_gigi_odon')->where('d_reg_order_poli_code', $request->id)->where('diag_poli_gigi_odon_no', $key)->first();
                if ($cek) {
                    DB::table('diag_poli_gigi_odon')->where('d_reg_order_poli_code', $request->id)->where('diag_poli_gigi_odon_no', $key)->update([
                        'diag_poli_gigi_odon_val' => implode(", ", $value['diagnosis']),
                        'diag_poli_gigi_odon_note' => $value['note'],
                    ]);
                } else {
                    DB::table('diag_poli_gigi_odon')->insert([
                        'diag_poli_gigi_odon_code' => str::uuid(),
                        'd_reg_order_poli_code' => $request->id,
                        'diag_poli_gigi_odon_no' => $key,
                        'diag_poli_gigi_odon_val' => implode(", ", $value['diagnosis']),
                        'diag_poli_gigi_odon_note' => $value['note'],
                        'diag_poli_gigi_odon_status' => 0,
                        'created_at' => now()
                    ]);
                }
                // echo "Key: $key <br>";
                // echo "Diagnosis: " . implode(", ", $value['diagnosis']) . "<br>";
                // echo "Note: " . $value['note'] . "<br><br>";
            }
            return $datas;
            # code...
        }

        // return $data['15']['diagnosis'][0];
        // return $data['15']['note'];
    }
    public function data_registrasi_poliklinik_reset_odontogram(Request $request)
    {
        DB::table('diag_poli_gigi_odon')->where('d_reg_order_poli_code', $request->id)->delete();
    }
    public function data_registrasi_poliklinik_save_diagnosa(Request $request)
    {
        $cek = DB::table('diag_poli_gigi_umum')->where('d_reg_order_poli_code', $request->id)->where('diag_poli_gigi_umum_name', $request->name)->first();
        if ($cek) {
            return 0;
        } else {
            DB::table('diag_poli_gigi_umum')->insert([
                'diag_poli_gigi_umum_code' => str::uuid(),
                'd_reg_order_poli_code' => $request->id,
                'diag_poli_gigi_umum_name' => $request->name,
                'diag_poli_gigi_umum_desc' => $request->desc,
                'created_at' => now()
            ]);
            $data = DB::table('diag_poli_gigi_umum')->where('d_reg_order_poli_code', $request->id)->get();
            return view('application.poliklinik.poliklinik-handling.table.data-diagnosa-umum', ['data' => $data]);
        }
    }
    public function data_registrasi_poliklinik_data_penunjang(Request $request)
    {
        $data = DB::table('t_pasien_cat_data_poli')
        ->join('t_pasien_cat_data','t_pasien_cat_data.id_t_pasien_cat_data','=','t_pasien_cat_data_poli.id_t_pasien_cat_data')
        ->where('t_pasien_cat_data.t_pasien_cat_data_type','file')
        ->where('t_pasien_cat_data_poli.d_reg_order_poli_code', $request->id)->first();
        return view('application.poliklinik.poliklinik-handling.form-penunjang-poliklinik', ['data' => $data]);
    }
    public function data_registrasi_poliklinik_save_diagnosa_pasien_poli(Request $request)
    {
        DB::table('d_reg_order_poli')->where('d_reg_order_poli_code', $request->id)->update([
            'd_reg_order_poli_status' => 2
        ]);
        return "done";
    }

    // POLIKLINIK VERIFIKASI DOKTER
    public function verifikasi_poliklinik_dokter($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_poli')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_poli.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('m_doctor_poli', 'm_doctor_poli.m_doctor_poli_code', '=', 'd_reg_order_poli.m_doctor_poli_code')
                ->join('t_layanan_data', 't_layanan_data.t_layanan_data_code', '=', 'm_doctor_poli.t_layanan_data_code')
                ->join('master_doctor', 'master_doctor.master_doctor_code', '=', 'm_doctor_poli.master_doctor_code')
                ->where('d_reg_order.d_reg_order_cabang', Auth::user()->access_cabang)
                ->where('d_reg_order_poli.d_reg_order_poli_status', 2)->get();
            return view('application.poliklinik.verifikasi-dokter-poliklinik', [
                'akses' => $akses,
                'code' => $id,
                'data' => $data
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function verifikasi_poliklinik_dokter_verify(Request $request)
    {
        $data = DB::table('d_reg_order_poli')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_poli.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_poli.d_reg_order_poli_code', $request->code)
            ->first();
        $fisik = DB::table('diag_poli_fisik_umum')->where('diag_poli_fisik_type', 'text')->get();
        $fisik1 = DB::table('diag_poli_fisik_umum')->where('diag_poli_fisik_type', 'textarea')->get();
        return view('application.poliklinik.verifikasi-poli.form-verifikasi', [
            'data' => $data,
            'code' => $request->code,
            'fisik' => $fisik,
            'fisik1' => $fisik1
        ]);
    }
    public function verifikasi_poliklinik_dokter_save_verify(Request $request)
    {
        DB::table('d_reg_order_poli')->where('d_reg_order_poli_code', $request->code)->update([
            'd_reg_order_poli_status' => 3
        ]);
    }
    // POLIKLINIK VERIFIKASI DOKTER
    public function verifikasi_poliklinik_dokumentasi_hasil($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_poli')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_poli.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('m_doctor_poli', 'm_doctor_poli.m_doctor_poli_code', '=', 'd_reg_order_poli.m_doctor_poli_code')
                ->join('t_layanan_data', 't_layanan_data.t_layanan_data_code', '=', 'm_doctor_poli.t_layanan_data_code')
                ->join('master_doctor', 'master_doctor.master_doctor_code', '=', 'm_doctor_poli.master_doctor_code')
                ->where('d_reg_order.d_reg_order_cabang', Auth::user()->access_cabang)
                ->where('d_reg_order_poli.d_reg_order_poli_status', 3)->get();
            return view('application.poliklinik.dokumentasi-hasil-poli', [
                'akses' => $akses,
                'code' => $id,
                'data' => $data
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function verifikasi_poliklinik_dokumentasi_hasil_preview(Request $request)
    {
        return view('application.poliklinik.dokumentasi-hasil.form-preview-hasil', ['code' => $request->code]);
    }
    public function verifikasi_poliklinik_dokumentasi_hasil_preview_report(Request $request)
    {
        $image = base64_encode(file_get_contents(public_path('img/favicon.png')));
        $odon = DB::table('diag_poli_gigi_odon')->where('d_reg_order_poli_code', $request->code)->get();
        $fisik = DB::table('diag_poli_fisik_umum_d')
            ->join('diag_poli_fisik_umum', 'diag_poli_fisik_umum.diag_poli_fisik_umum_code', '=', 'diag_poli_fisik_umum_d.diag_poli_fisik_umum_code')
            ->where('d_reg_order_poli_code', $request->code)->get();
        $umum = DB::table('diag_poli_gigi_umum')->where('d_reg_order_poli_code', $request->code)->get();
        $pasien = DB::table('d_reg_order')
            ->join('d_reg_order_poli', 'd_reg_order_poli.d_reg_order_code', '=', 'd_reg_order.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_poli.d_reg_order_poli_code', $request->code)->first();
        $tgl_lahir_carbon = Carbon::parse($pasien->master_patient_tgl_lahir);
        $umur_tahun = $tgl_lahir_carbon->diffInYears(); // Menghitung umur dalam tahun

        $umur = $umur_tahun . ' Th ';
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.poliklinik.dokumentasi-hasil.report.report-preview-hasil', [
            'code' => $request->code,
            'odon' => $odon,
            'fisik' => $fisik,
            'umum' => $umum,
            'pasien' => $pasien,
            'umur' => $umur,
        ], compact('image'))
            ->setPaper('A5', 'potrait')->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                ]);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $font1 = $dompdf->getFontMetrics()->get_font("helvetica", "normal");
        $dompdf->get_canvas()->page_text(300, 820, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
        $dompdf->get_canvas()->page_text(34, 820, "Print by. " . Auth::user()->fullname, $font1, 10, array(0, 0, 0));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 400, 575);
            ');
        return base64_encode($pdf->stream());
    }
    public function verifikasi_poliklinik_dokumentasi_hasil_send_report(Request $request)
    {
        return 123;
    }
}
