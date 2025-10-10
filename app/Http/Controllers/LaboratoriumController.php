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
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\PdfToImage\Pdf;

class LaboratoriumController extends Controller
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
    // DATA REGISTRASI LAB
    public function data_registrasi_lab($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('master_doctor', 'master_doctor.master_doctor_code', '=', 'd_reg_order_lab.d_reg_order_lab_rujukan')
                ->orderBy('id_d_reg_order_lab', 'DESC')->get();
            // dd($data);
            return view('application.laboratorium.data-registrasi-lab', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_registrasi_lab_handling(Request $request)
    {
        $data = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->code)
            ->first();
        return view('application.laboratorium.data-registrasi.form-handling', ['data' => $data, 'code' => $request->code]);
    }
    public function data_registrasi_lab_handling_proses(Request $request)
    {
        DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->code)->update([
            'd_reg_order_lab_status' => 1,
            'updated_at' => now()
        ]);
        return 213;
    }
    // SPECIMEN COLLECTION
    public function data_specimen_collection_lab($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->where('d_reg_order_lab_status', 1)
                ->get();
            return view('application.laboratorium.data-specimen-collection', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_specimen_collection_lab_cari_data(Request $request)
    {
        $data = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->code)->first();
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->code)->get();
        if ($data) {
            if ($data->d_reg_order_lab_status == 0) {
                return 'not';
            } elseif (($data->d_reg_order_lab_status == 1)) {
                return view('application.laboratorium.speciment-collection.detail-speciment', ['data' => $data, 'pemeriksaan' => $pemeriksaan, 'code' => $request->code]);
            } elseif (($data->d_reg_order_lab_status >= 2)) {
                return 'done';
            }
        } else {
            return 'false';
        }
    }
    public function data_specimen_collection_lab_detail(Request $request)
    {
        return 123;
    }
    public function data_specimen_collection_lab_proses(Request $request)
    {
        DB::table('s_specimen_log')->insert([
            's_specimen_log_code' => str::uuid(),
            't_pem_specimen_code' => $request->specimen,
            'd_reg_order_list_code' => $request->reg,
            's_specimen_log_time' => now(),
            's_specimen_log_end_time' => 0,
            's_specimen_log_user' => Auth::user()->userid,
            's_specimen_log_status' => 0,
            'created_at' => now(),
        ]);
        return '<button class="btn btn-falcon-warning btn-sm" id="button-simpan-specimen' . $request->code . '' . $request->specimen . '" data-code="123" data-specimen="' . $request->specimen . '" data-reg="' . $request->reg . '">' . now() . '</button>';
    }
    public function data_specimen_collection_lab_proses_simpan(Request $request)
    {
        DB::table('s_specimen_log')->where('t_pem_specimen_code', $request->specimen)->where('d_reg_order_list_code', $request->reg)->update([
            's_specimen_log_end_time' => now(),
            's_specimen_log_status' => 1,
        ]);
        return '<button class="btn btn-falcon-success btn-sm" id="" data-code="132">Selesai</button>';
    }
    public function data_specimen_collection_lab_proses_simpan_fix(Request $request)
    {
        DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->code)->update([
            'd_reg_order_lab_status' => 2,
            'updated_at' => now(),
        ]);
        return 123;
    }
    // PROSE RESULT
    public function menu_lab_proses_result($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->where('d_reg_order_lab_status', 2)
                ->get();
            return view('application.laboratorium.proses-result', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_lab_proses_result_detail(Request $request)
    {
        $data = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->code)->first();
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->code)->get();
        return view('application.laboratorium.proses-result.detail-proses-result', ['data' => $data, 'pemeriksaan' => $pemeriksaan, 'code' => $request->code]);
    }
    public function menu_lab_proses_result_detail_proses_save(Request $request)
    {
        $data = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->join('t_pemeriksaan_list_val', 't_pemeriksaan_list_val.t_pemeriksaan_list_code', '=', 't_pemeriksaan_list.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_list.d_reg_order_lab_code', $request->code)->get();
        foreach ($data as $value) {
            $cek = DB::table('h_reg_lab')->where('d_reg_order_lab_code', $request->code)->where('t_pem_list_val_code', $value->t_pem_list_val_code)->first();
            if ($cek) {
                DB::table('h_reg_lab')
                    ->where('d_reg_order_lab_code', $request->code)
                    ->where('t_pem_list_val_code', $value->t_pem_list_val_code)->update([
                            'h_reg_lab_value' => $request[$value->t_pem_list_val_code],
                            'h_reg_lab_metode' => $request['opt' . $value->t_pem_list_val_code],
                            'created_at' => now()
                        ]);
            } else {
                DB::table('h_reg_lab')->insert([
                    'h_reg_lab_code' => str::uuid(),
                    'd_reg_order_lab_code' => $request->code,
                    't_pem_list_val_code' => $value->t_pem_list_val_code,
                    'h_reg_lab_value' => $request[$value->t_pem_list_val_code],
                    'h_reg_lab_metode' => $request['opt' . $value->t_pem_list_val_code],
                    'created_at' => now()
                ]);
            }
        }
        $datax = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->code)->first();
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->code)->get();
        return view('application.laboratorium.proses-result.detail-proses-result', ['data' => $datax, 'pemeriksaan' => $pemeriksaan, 'code' => $request->code]);
    }
    // VERIFIKASI LAB
    public function verifikasi_laboratorium($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('master_doctor', 'master_doctor.master_doctor_code', '=', 'd_reg_order_lab.d_reg_order_lab_rujukan')
                ->where('d_reg_order_lab_status', 2)
                ->get();
            return view('application.laboratorium.verifikasi-hasil-lab', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function verifikasi_laboratorium_detail(Request $request)
    {
        $data = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->reg)->first();
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->reg)->get();
        return view('application.laboratorium.verifikasi-hasil.verifikasi-hasil-detail', [
            'code' => $request->code,
            'reg' => $request->reg,
            'pemeriksaan' => $pemeriksaan,
            'data' => $data,
        ]);
    }
    public function verifikasi_laboratorium_verifikasi_data(Request $request)
    {
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->reg)->get();
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $data = DB::table('d_reg_order')->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order.d_reg_order_code', $request->code)->first();
        $reg = DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->reg)->first();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.laboratorium.verifikasi-hasil.report.report-hasil-lab', [
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
        $tempPdfPath = storage_path('app/public/hasil/lab/' . $request->reg . '.pdf');
        file_put_contents($tempPdfPath, $pdfBinaryData);
        DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->reg)->update([
            'd_reg_order_lab_status' => 3,
            'updated_at' => now(),
        ]);
        return 'berhasil';
    }
    public function verifikasi_laboratorium_preview_report(Request $request)
    {
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->reg)->get();
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $data = DB::table('d_reg_order')->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order.d_reg_order_code', $request->code)->first();
        $reg = DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->reg)->first();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.laboratorium.verifikasi-hasil.report.report-hasil-lab', [
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
    // DOKUMENTASI HASIL
    public function dokumentasi_hasil_laboratorium($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->where('d_reg_order_lab_status', '>', 2)
                ->get();
            return view('application.laboratorium.dokumentasi-hasil-lab', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function dokumentasi_hasil_laboratorium_detail(Request $request)
    {
        $data = DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->code)->first();
        return view('application.laboratorium.dokumentasi-hasil.form-dokumentasi-hasil', ['data' => $data, 'code' => $request->code]);
    }
    public function dokumentasi_hasil_laboratorium_detail_kirim_hasil(Request $request)
    {
        $user = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->code)->first();
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
        $name = storage_path('app/public/hasil/lab/' . $request->code . '.pdf');

        $img = file_get_contents($name);
        // a route is created, (it must already be created in its repository(pdf)).
        // $rute    = "pdf/" . $name;
        $pass = date('dmY', strtotime($user->master_patient_tgl_lahir));
        // decode base64
        $pdf_b64 = base64_encode($img);
        $cek = DB::table('v_log_whatsapp')->where('d_reg_order_list_code', $request->code)->first();
        // you record the file in existing folder
        if ($cek) {
            DB::table('v_log_whatsapp')->where('d_reg_order_list_code', $request->code)->update([
                'v_log_whatsapp_number' => $nomorhp,
                'v_log_whatsapp_name' => $user->master_patient_name,
                'v_log_whatsapp_filename' => $request->code . date('his'),
                'v_log_whatsapp_text' => "Halo, " . $user->master_patient_name . "\nHasil Lab Dengan Password Tanggal Lahir : Ex. 01011991",
                'v_log_whatsapp_file' => $pdf_b64,
                'v_log_whatsapp_picture' => '0',
                'v_log_whatsapp_status' => 0,
                'v_log_whatsapp_date' => now(),
                'v_log_whatsapp_pass' => $pass,
            ]);
        } else {
            DB::table('v_log_whatsapp')->insert([
                'v_log_whatsapp_code' => str::uuid() . mt_rand(1000, 9999),
                'd_reg_order_list_code' => $request->code,
                'v_log_whatsapp_number' => $nomorhp,
                'v_log_whatsapp_name' => $user->master_patient_name,
                'v_log_whatsapp_filename' => $request->code . date('his'),
                'v_log_whatsapp_text' => "Halo, " . $user->master_patient_name . "\nHasil Lab Dengan Password Tanggal Lahir : Ex. 01011991",
                'v_log_whatsapp_file' => $pdf_b64,
                'v_log_whatsapp_picture' => '0',
                'v_log_whatsapp_status' => 0,
                'v_log_whatsapp_date' => now(),
                'v_log_whatsapp_pass' => $pass,
                'created_at' => now(),
            ]);
        }
        DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->code)->update([
            'd_reg_order_lab_status' => 4,
            'updated_at' => now(),
        ]);
        return $pdf_b64;
    }
    public function dokumentasi_hasil_laboratorium_detail_batal_kirim_hasil(Request $request)
    {
        return 123;
    }
    // PENGIRIMAN HASIL
    public function pengiriman_hasil_laboratorium($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')->join('v_log_whatsapp', 'v_log_whatsapp.d_reg_order_list_code', '=', 'd_reg_order_lab.d_reg_order_lab_code')->get();
            return view('application.laboratorium.pengiriman-hasil-lab', ['akses' => $akses, 'data' => $data, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function pengiriman_hasil_laboratorium_add(Request $request)
    {
        return view('application.laboratorium.pengiriman-hasil.form-add-whatsapp');
    }
    public function pengiriman_hasil_laboratorium_save(Request $request)
    {
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.laboratorium.pengiriman-hasil.format-pdf', compact('image'))->setPaper('A5', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $file = base64_encode($pdf->stream());
        $base64Pdf = 'data:application/pdf;base64,' . $file; // Your Base64 encoded PDF string
        list($type, $data) = explode(';', $base64Pdf);
        list(, $data) = explode(',', $data);
        $pdfBinaryData = base64_decode($data);
        $tempPdfPath = storage_path('app/temp_pdf_' . str::uuid() . '.pdf');
        file_put_contents($tempPdfPath, $pdfBinaryData);


        // $pdf = new Pdf($tempPdfPath);
        // $outputImagePath = storage_path('app/converted_image_' . str::uuid() . '.jpg');
        // $pdf->saveImage($outputImagePath);
        try {
            $pdf = new Pdf($tempPdfPath);
            $outputImagePath = storage_path('app/converted_image_' . str::uuid() . '.jpg');
            $pdf->saveImage($outputImagePath);
            $qrcode = base64_encode(file_get_contents($outputImagePath));
            DB::table('v_log_whatsapp')->insert([
                'v_log_whatsapp_code' => str::uuid() . mt_rand(1000, 9999),
                'd_reg_order_list_code' => '123132213',
                'v_log_whatsapp_number' => '+6281933770710',
                'v_log_whatsapp_name' => 'Agus Raharjo',
                'v_log_whatsapp_text' => 'Halo',
                'v_log_whatsapp_file' => $file,
                'v_log_whatsapp_picture' => $qrcode,
                'v_log_whatsapp_status' => 0,
                'v_log_whatsapp_date' => now(),
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Handle any errors during conversion
            echo 'Error converting PDF: ' . $e->getMessage();
        } finally {
            // Clean up the temporary PDF file
            if (file_exists($tempPdfPath)) {
                unlink($tempPdfPath);
            }
            if (file_exists($outputImagePath)) {
                unlink($outputImagePath);
            }
        }
        // $pdf = new Pdf($tempPdfPath);
        // $pdf->saveImage(storage_path('app/public/test.jpg'));

        // Now $outputImagePath contains the path to your converted JPG image
        // You can then serve this image or store its path in your database.



        // $qrcode = base64_encode(QrCode::format('png')
        //     ->size(500)
        //     // ->merge('/storage/app/public/logo.png')
        //     ->errorCorrection('H')
        //     ->eyeColor(2, 100, 100, 255, 0, 0, 0)
        //     ->style('round')
        //     ->margin(2)
        //     ->generate(str::uuid()));

        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Pengiriman Whatsapp');
    }
    public function pengiriman_hasil_laboratorium_template()
    {
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.laboratorium.verifikasi-hasil.report.report-hasil-lab', compact('image'))->setPaper('A4', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        return $pdf->stream();
    }
}
