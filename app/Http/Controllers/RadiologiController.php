<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class RadiologiController extends Controller
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
    public function data_registrasi_radiologi($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_rad')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->get();
            return view('application.radiologi.data-registrasi-radiologi', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

    public function data_registrasi_radiologi_handling(Request $request)
    {
        $data = DB::table('d_reg_order_rad')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_rad.d_reg_order_rad_code', $request->code)
            ->first();
        return view('application.radiologi.data-registrasi.form-handling', ['data' => $data, 'code' => $request->code]);
    }
    public function menu_radiologi_handling($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_rad')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->get();
            return view('application.radiologi.radiologi-handling', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_radiologi_handling_pasien(Request $request)
    {
        $data = DB::table('d_reg_order_rad')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_rad.d_reg_order_rad_code', $request->code)->first();
        $layanan = DB::table('t_layanan_cat')->get();
        return view('application.radiologi.radiologi-handling.form-handling-pasien', ['data' => $data, 'layanan' => $layanan, 'code' => $request->code]);
    }
    // VERIFIKASI HASIL RADIOLOGI
    public function hasil_radiologi_verifikasi($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_rad')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->get();
            return view('application.radiologi.verifikasi-hasil-radiologi', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function hasil_radiologi_verifikasi_detail(Request $request)
    {
        return view('application.radiologi.verifikasi-hasil.verifikasi-hasil-detail', ['code' => $request->code, 'reg' => $request->reg]);
    }
    public function verifikasi_radiologi_preview_report(Request $request)
    {
        $pemeriksaan = DB::table('d_reg_order_rad_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_rad_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_rad_code', $request->reg)->get();
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $data = DB::table('d_reg_order')->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order.d_reg_order_code', $request->code)->first();
        $reg = DB::table('d_reg_order_rad')->where('d_reg_order_rad_code', $request->reg)->first();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.radiologi.verifikasi-hasil.report.report-hasil-radiologi', [
            'code' => $request->code,
            'data' => $data,
            'reg' => $reg,
            'pemeriksaan' => $pemeriksaan,
        ], compact('image'))->setPaper('A4', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $font1 = $dompdf->getFontMetrics()->get_font("helvetica", "normal");
        $dompdf->get_canvas()->page_text(300, 820, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
        $dompdf->get_canvas()->page_text(34, 820, "Print by. Admin", $font1, 10, array(0, 0, 0));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 575, 823);
            ');
        return base64_encode($pdf->stream());
    }
    public function hasil_radiologi_verifikasi_data(Request $request)
    {
        $pemeriksaan = DB::table('d_reg_order_rad_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_rad_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_rad_code', $request->reg)->get();
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $data = DB::table('d_reg_order')->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order.d_reg_order_code', $request->code)->first();
        $reg = DB::table('d_reg_order_rad')->where('d_reg_order_rad_code', $request->reg)->first();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.radiologi.verifikasi-hasil.report.report-hasil-radiologi', [
            'code' => $request->code,
            'data' => $data,
            'reg' => $reg,
            'pemeriksaan' => $pemeriksaan,
        ], compact('image'))->setPaper('A4', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 575, 823);
            ');
        $pdf->get_canvas()->get_cpdf()->setEncryption("admin", date('dmY', strtotime($data->master_patient_tgl_lahir)));
        $file = base64_encode($pdf->stream());
        $base64Pdf = 'data:application/pdf;base64,' . $file; // Your Base64 encoded PDF string
        list($type, $data) = explode(';', $base64Pdf);
        list(, $data) = explode(',', $data);
        $pdfBinaryData = base64_decode($data);
        $tempPdfPath = storage_path('app/public/hasil/rad/' . $request->reg . '.pdf');
        file_put_contents($tempPdfPath, $pdfBinaryData);
        return 'berhasil';
    }
    // DOKUMENTASI HASIL RADIOLOGI
    public function hasil_radiologi_dokumnatasi($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_rad')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->get();
            return view('application.radiologi.dokumentasi-hasil-radiologi', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function dokumentasi_hasil_radiologi_detail(Request $request)
    {
        return view('application.radiologi.dokumentasi-hasil.form-dokumentasi-hasil-radiologi', ['code' => $request->code]);
    }
    public function dokumentasi_hasil_radiologi_detail_kirim_hasil(Request $request)
    {
        $user = DB::table('d_reg_order_rad')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_rad.d_reg_order_rad_code', $request->code)->first();
        $nomorhp = $user->master_patient_no_hp;
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
        // $tempPdfPath = storage_path('app/public/hasil/rpt.pdf');
        $name = storage_path('app/public/hasil/rad/' . $request->code . '.pdf');

        $img = file_get_contents($name);
        // a route is created, (it must already be created in its repository(pdf)).
        // $rute    = "pdf/" . $name;
        $pass = date('dmY', strtotime($user->master_patient_tgl_lahir));
        // decode base64
        $pdf_b64 = base64_encode($img);
        $cek = DB::table('v_log_whatsapp')->where('d_reg_order_list_code', $request->code)->first();
        if ($cek) {
            DB::table('v_log_whatsapp')->where('d_reg_order_list_code', $request->code)->update([
                'v_log_whatsapp_number' => $nomorhp,
                'v_log_whatsapp_name' => $user->master_patient_name,
                'v_log_whatsapp_filename' => $request->code . date('his'),
                'v_log_whatsapp_text' => "Halo, " . $user->master_patient_name . "\nHasil Radiologi Dengan Password Tanggal Lahir : Ex. 01011991",
                'v_log_whatsapp_file' => $pdf_b64,
                'v_log_whatsapp_status' => 0,
                'v_log_whatsapp_date' => now(),
                'v_log_whatsapp_pass' => $pass,
                'created_at' => now(),
            ]);
        } else {
            DB::table('v_log_whatsapp')->insert([
                'v_log_whatsapp_code' => str::uuid() . mt_rand(1000, 9999),
                'd_reg_order_list_code' => $request->code,
                'v_log_whatsapp_number' => $nomorhp,
                'v_log_whatsapp_name' => $user->master_patient_name,
                'v_log_whatsapp_filename' => $request->code . date('his'),
                'v_log_whatsapp_text' => "Halo, " . $user->master_patient_name . "\nHasil Radiologi Dengan Password Tanggal Lahir : Ex. 01011991",
                'v_log_whatsapp_file' => $pdf_b64,
                'v_log_whatsapp_picture' => '0',
                'v_log_whatsapp_status' => 0,
                'v_log_whatsapp_date' => now(),
                'v_log_whatsapp_pass' => $pass,
                'created_at' => now(),
            ]);
        }
        return $pdf_b64;
    }
    // DOKUMENTASI HASIL RADIOLOGI
    public function hasil_radiologi_pengiriman($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_rad')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->get();
            return view('application.radiologi.dokumentasi-hasil-radiologi', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
}
