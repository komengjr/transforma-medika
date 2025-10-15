<?php

namespace App\Http\Controllers;

use App\Imports\PesertaAllImport;
use App\Imports\PesertaImport;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class PelayananController extends Controller
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
    // REGISTRASI
    public function registrasi_pasien($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('application.pelayanan.registrasi-pasien', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function registrasi_pasien_add(Request $request)
    {
        return view('application.pelayanan.form.form-registrasi');
    }
    public function registrasi_pasien_create(Request $request)
    {
        return view('application.pelayanan.form.form-add');
    }
    public function registrasi_pasien_reader_passport(Request $request)
    {
        return view('application.pelayanan.form.form-reader-passport');
    }
    public function registrasi_pasien_reader_passport_scan(Request $request)
    {
        $data = $request->code;
        // \
        $nik = $data[0]['ID Number'];
        $nama = $data[0]['Name'];
        $dob = $data[0]['Date of Birth'];
        $jk = $data[0]['Gender'];
        $lahir = $data[0]['Place of Birth'];
        $agama = $data[0]['Religion'];
        $gambar = $data[1]['OcrHead'];
        return view('application.pelayanan.form.form-reader-show', [
            'nik' => $nik,
            'nama' => $nama,
            'dob' => $dob,
            'gambar' => $gambar,
            'jk' => $jk,
            'lahir' => $lahir,
            'agama' => $agama,
        ]);
    }
    public function reader_pasien(Request $request)
    {
        return view('application.pelayanan.form.form-reader-passport');
    }
    public function registrasi_pasien_create_save(Request $request)
    {
        if ($request->link == "") {
            $file = null;
        } else {
            $file = 'profile/data_pasien/' . auth::user()->access_cabang . '/' . $request->link;
        }
        $cek = DB::table('master_patient')->where('master_patient_nik', $request->nik)->first();
        if (!$cek) {
            DB::table('master_patient')->insert([
                'master_patient_code' => 'MPP' . date('Ymdhis'),
                'master_patient_nik' => $request->nik,
                'master_patient_name' => $request->nama,
                'master_patient_jk' => $request->jk,
                'master_patient_tgl_lahir' => $request->tgl_lahir,
                'master_patient_tempat_lahir' => $request->tempat_lahir,
                'master_patient_agama' => $request->agama,
                'master_patient_no_hp' => $request->no_hp,
                'master_patient_email' => $request->email,
                'master_patient_place' => 29992029,
                'master_patient_alamat' => $request->alamat,
                'master_patient_profile' => $file,
                'created_at' => now()
            ]);
            return 1;
        } else {
            return 0;
        }
    }
    public function registrasi_pasien_cari_data_pasien(Request $request)
    {
        $data = DB::table('master_patient')->get();
        return view('application.pelayanan.form.table-pencarian-pasien', ['data' => $data]);
    }
    public function registrasi_pasien_pilih_data_pasien(Request $request)
    {
        $list = DB::table('d_reg_order')->where('d_reg_order_date', date('Y-m-d'))->count();
        $no_reg = date('Ymdhis') . str_pad($list + 1, 3, '0', STR_PAD_LEFT);
        $data = DB::table('master_patient')->where('master_patient_code', $request->code)->first();
        return view('application.pelayanan.form.form-registrasi-proses', ['data' => $data, 'no_reg' => $no_reg]);
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan(Request $request)
    {
        $layanan = DB::table('t_layanan_cat')->get();
        return view('application.pelayanan.form.form-kebutuhan-pasien', ['code' => $request->code, 'layanan' => $layanan]);
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_layanan(Request $request)
    {
        $pasien_cat = DB::table('t_pasien_cat')
            ->join('t_pasien_cat_data', 't_pasien_cat_data.t_pasien_cat_code', '=', 't_pasien_cat.t_pasien_cat_code')
            ->where('t_pasien_cat.t_pasien_cat_code', $request->cat)->get();
        if ($request->id == '14de0404-0c88-4cff-bae1-d28ea75b53ad') {
            $poli = DB::table('t_layanan_data')->where('t_layanan_cat_code', '14de0404-0c88-4cff-bae1-d28ea75b53ad')->get();
            return view('application.pelayanan.form.kebutuhan.form-poliklinik', ['poli' => $poli, 'cat' => $pasien_cat]);
        } elseif ($request->id == '0bd4ea7f-bd6e-4fa7-878a-29295f74f0ac') {
            $dokter = DB::table('master_doctor')->get();
            $agrement = DB::table('p_sales')->get();
            $code = '0bd4ea7f-bd6e-4fa7-878a-29295f74f0ac';
            return view('application.pelayanan.form.kebutuhan.form-laboratorium', ['cat' => $pasien_cat, 'dokter' => $dokter, 'agrement' => $agrement, 'code' => $code]);
        } elseif ($request->id == '857946b2-62c2-488b-af9d-c4d330041b44') {
            $dokter = DB::table('master_doctor')->get();
            return view('application.pelayanan.form.kebutuhan.form-igd', ['cat' => $pasien_cat, 'dokter' => $dokter]);
        } elseif ($request->id == '80304154-baeb-4b7a-8ba8-f818726a84df') {
            $dokter = DB::table('master_doctor')->get();
            $agrement = DB::table('p_sales')->get();
            $code = '80304154-baeb-4b7a-8ba8-f818726a84df';
            return view('application.pelayanan.form.kebutuhan.form-radiologi', ['cat' => $pasien_cat, 'dokter' => $dokter, 'agrement' => $agrement, 'code' => $code]);
        } else {
            return '<span class="badge bg-warning">Coming Soon</span>';
        }
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_lab_agrement(Request $request)
    {
        $data = DB::table('p_sales_cat')
            ->where('t_layanan_cat_code', $request->code)
            ->where('p_sales_code', $request->id)->get();
        return view('application.pelayanan.form.kebutuhan.laboratorium.data-agrement-lab', ['data' => $data]);
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_lab_type_agrement(Request $request)
    {
        $data = DB::table('p_sales_data')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('p_sales_data.p_sales_cat_code', $request->id)->get();
        return view('application.pelayanan.form.kebutuhan.laboratorium.data-table-pemeriksaan', ['data' => $data]);
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_lab_pemeriksaan(Request $request)
    {
        $data = DB::table('p_sales_data')->where('p_sales_data_code', $request->code)->first();
        DB::table('d_reg_order_lab_log')->insert([
            'order_lab_log_code' => str::uuid(),
            'd_reg_order_code' => $request->reg,
            'p_sales_data_code' => $request->code,
            'order_lab_log_price' => $data->p_sales_data_price,
            'order_lab_log_discount' => $data->p_sales_data_disc,
            'created_at' => now(),
        ]);
        $list = DB::table('d_reg_order_lab_log')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_log.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')->where('d_reg_order_code', $request->reg)->get();
        return view('application.pelayanan.form.kebutuhan.laboratorium.data-order-lab', ['list' => $list]);
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_remove_pemeriksaan_lab(Request $request)
    {
        DB::table('d_reg_order_lab_log')->where('order_lab_log_code', $request->code)->delete();
        $list = DB::table('d_reg_order_lab_log')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_log.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')->where('d_reg_order_code', $request->reg)->get();
        return view('application.pelayanan.form.kebutuhan.laboratorium.data-order-lab', ['list' => $list]);
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli(Request $request)
    {
        $data = DB::table('t_layanan_data')->where('t_layanan_data_code', $request->id)->first();
        $dokter = DB::table('m_doctor_poli')->join('master_doctor', 'master_doctor.master_doctor_code', '=', 'm_doctor_poli.master_doctor_code')
            ->where('m_doctor_poli.t_layanan_data_code', $request->id)->get();
        return view('application.pelayanan.form.kebutuhan.data-poliklinik', ['data' => $data, 'dokter' => $dokter]);
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli_agrement(Request $request)
    {
        $data = DB::table('p_sales_cat')
            ->where('t_layanan_cat_code', $request->code)
            ->where('p_sales_code', $request->id)->get();
        return view('application.pelayanan.form.kebutuhan.radiologi.data-agrement', ['data' => $data]);
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli_type_agrement(Request $request)
    {
        $data = DB::table('p_sales_data')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('p_sales_data.p_sales_cat_code', $request->id)->get();
        return view('application.pelayanan.form.kebutuhan.radiologi.data-table-pemeriksaan', ['data' => $data]);
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_poli_pemeriksaan(Request $request)
    {
        $data = DB::table('p_sales_data')->where('p_sales_data_code', $request->code)->first();
        DB::table('d_reg_order_rad_log')->insert([
            'order_rad_log_code' => str::uuid(),
            'd_reg_order_rad_code' => $request->reg,
            'p_sales_data_code' => $request->code,
            'order_rad_log_price' => $data->p_sales_data_price,
            'order_rad_log_discount' => $data->p_sales_data_disc,
            'created_at' => now(),
        ]);
        $list = DB::table('d_reg_order_rad_log')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_rad_log.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')->where('d_reg_order_rad_code', $request->reg)->get();
        return view('application.pelayanan.form.kebutuhan.radiologi.data-order-radiologi', ['list' => $list]);
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_remove_pemeriksaan_rad(Request $request)
    {
        DB::table('d_reg_order_rad_log')->where('order_rad_log_code', $request->code)->delete();
        $list = DB::table('d_reg_order_rad_log')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_rad_log.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')->where('d_reg_order_rad_code', $request->reg)->get();
        return view('application.pelayanan.form.kebutuhan.radiologi.data-order-radiologi', ['list' => $list]);
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_dokter(Request $request)
    {
        $dokter = DB::table('m_doctor_poli')->join('t_layanan_data', 't_layanan_data.t_layanan_data_code', '=', 'm_doctor_poli.t_layanan_data_code')
            ->join('master_doctor', 'master_doctor.master_doctor_code', '=', 'm_doctor_poli.master_doctor_code')
            ->where('m_doctor_poli.m_doctor_poli_code', $request->code)->first();
        return view('application.pelayanan.form.kebutuhan.form-dokter-poliklinik', ['dokter' => $dokter, 'tgl' => $request->tgl]);
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_poli(Request $request)
    {
        DB::table('d_reg_order')->insert([
            'd_reg_order_code' => $request->no_reg,
            'd_reg_order_rm' => $request->no_rm,
            'd_reg_order_date' => now(),
            't_layanan_cat_code' => $request->layanan,
            't_pasien_cat_code' => $request->cat,
            'd_reg_order_status' => 0,
            'd_reg_order_user' => Auth::user()->userid,
            'created_at' => now()
        ]);
        $code = 'P' . $request->no_reg . '0001';
        DB::table('d_reg_order_list')->insert([
            'd_reg_order_list_code' => $code,
            'd_reg_order_code' => $request->no_reg,
            't_layanan_cat_code' => $request->layanan,
            'd_reg_order_list_date' => now(),
        ]);
        DB::table('d_reg_order_poli')->insert([
            'd_reg_order_poli_code' => $code,
            'd_reg_order_code' => $request->no_reg,
            'm_doctor_poli_code' => $request->code,
            'd_reg_order_poli_date' => $request->date,
            'd_reg_order_poli_number' => 1,
            'd_reg_order_poli_status' => 0,
            'd_reg_order_poli_user' => Auth::user()->userid,
            'created_at' => now()
        ]);
        return 13;
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_lab(Request $request)
    {
        $data = DB::table('d_reg_order_lab_log')->where('d_reg_order_code', $request->no_reg)->get();
        $code = 'L' . $request->no_reg . '0001';
        foreach ($data as $value) {
            DB::table('d_reg_order_lab_list')->insert([
                'order_lab_list_code' => str::uuid(),
                'd_reg_order_lab_code' => $code,
                'p_sales_data_code' => $value->p_sales_data_code,
                'order_lab_log_price' => $value->order_lab_log_price,
                'order_lab_log_discount' => $value->order_lab_log_discount,
                'created_at' => now()
            ]);
        }
        DB::table('d_reg_order')->insert([
            'd_reg_order_code' => $request->no_reg,
            'd_reg_order_rm' => $request->no_rm,
            'd_reg_order_date' => now(),
            't_layanan_cat_code' => $request->layanan,
            't_pasien_cat_code' => $request->cat,
            'd_reg_order_status' => 0,
            'd_reg_order_user' => Auth::user()->userid,
            'created_at' => now()
        ]);

        DB::table('d_reg_order_list')->insert([
            'd_reg_order_list_code' => $code,
            'd_reg_order_code' => $request->no_reg,
            't_layanan_cat_code' => $request->layanan,
            'd_reg_order_list_date' => now(),
        ]);
        DB::table('d_reg_order_lab')->insert([
            'd_reg_order_lab_code' => $code,
            'd_reg_order_code' => $request->no_reg,
            'd_reg_order_lab_rujukan' => $request->rujukan,
            'd_reg_order_lab_date' => $request->date,
            'd_reg_order_lab_number' => 1,
            'd_reg_order_lab_status' => 0,
            'd_reg_order_lab_user' => Auth::user()->userid,
            'created_at' => now()
        ]);
        return 123;
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_rad(Request $request)
    {
        $data = DB::table('d_reg_order_rad_log')->where('d_reg_order_rad_code', $request->no_reg)->get();
        $code = 'R' . $request->no_reg . '0001';
        foreach ($data as $value) {
            DB::table('d_reg_order_rad_list')->insert([
                'order_rad_list_code' => str::uuid(),
                'd_reg_order_rad_code' => $code,
                'p_sales_data_code' => $value->p_sales_data_code,
                'order_rad_log_price' => $value->order_rad_log_price,
                'order_rad_log_discount' => $value->order_rad_log_discount,
                'created_at' => now()
            ]);
        }
        DB::table('d_reg_order')->insert([
            'd_reg_order_code' => $request->no_reg,
            'd_reg_order_rm' => $request->no_rm,
            'd_reg_order_date' => now(),
            't_layanan_cat_code' => $request->layanan,
            't_pasien_cat_code' => $request->cat,
            'd_reg_order_status' => 0,
            'd_reg_order_user' => Auth::user()->userid,
            'created_at' => now()
        ]);
        DB::table('d_reg_order_list')->insert([
            'd_reg_order_list_code' => $code,
            'd_reg_order_code' => $request->no_reg,
            't_layanan_cat_code' => $request->layanan,
            'd_reg_order_list_date' => now(),
        ]);
        DB::table('d_reg_order_rad')->insert([
            'd_reg_order_rad_code' => $code,
            'd_reg_order_code' => $request->no_reg,
            'd_reg_order_rad_dr_rujukan' => $request->rujukan,
            'd_reg_order_rad_date' => $request->date,
            'd_reg_order_rad_number' => 1,
            'd_reg_order_rad_status' => 0,
            'd_reg_order_rad_user' => Auth::user()->userid,
            'created_at' => now()
        ]);
        return 123;
    }
    public function registrasi_pasien_pilih_data_pasien_end_proses(Request $request)
    {
        return view('application.pelayanan.form.form-nomor-registrasi', ['code' => $request->code]);
    }
    public function registrasi_pasien_pilih_data_pasien_preview_pdf(Request $request)
    {

        $image = base64_encode(file_get_contents(public_path('img/favicon.png')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.pelayanan.form.report.preview-registrasi', ['code' => $request->code], compact('image'))
            ->setPaper('A5', 'potrait')->setOptions(['defaultFont' => 'helvetica']);
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
    // DAFTAR REGISTRASI
    public function data_registrasi($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('d_reg_order')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'd_reg_order.t_layanan_cat_code')
                ->join('t_pasien_cat', 't_pasien_cat.t_pasien_cat_code', '=', 'd_reg_order.t_pasien_cat_code')
                ->get();
            return view('application.pelayanan.list-pasien-registrasi', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // VERIFIKASI DATA REGISTRASI
    public function menu_pelayanan_verifikasi_registrasi($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'd_reg_order.t_layanan_cat_code')
                ->join('t_pasien_cat', 't_pasien_cat.t_pasien_cat_code', '=', 'd_reg_order.t_pasien_cat_code')
                ->get();
            return view('application.pelayanan.menu-verifikasi-data-registrasi', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // SUPERVISIOR PELAYANAN
    public function menu_pelayanan_supervisior($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'd_reg_order.t_layanan_cat_code')
                ->join('t_pasien_cat', 't_pasien_cat.t_pasien_cat_code', '=', 'd_reg_order.t_pasien_cat_code')
                ->get();
            $kategori = DB::table('t_pasien_cat')->get();
            $layanan = DB::table('t_layanan_cat')->get();
            return view('application.pelayanan.menu-supervisior-pelayanan', [
                'data' => $data,
                'akses' => $akses,
                'layanan' => $layanan,
                'kategori' => $kategori,
                'code' => $id,
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_pelayanan_supervisior_find(Request $request)
    {
        try {
            $data = DB::table('d_reg_order')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'd_reg_order.t_layanan_cat_code')
                ->join('t_pasien_cat', 't_pasien_cat.t_pasien_cat_code', '=', 'd_reg_order.t_pasien_cat_code')
                ->where('d_reg_order.t_pasien_cat_code', $request->kategori)->get();
            // return $data;
            return view('application.pelayanan.menu-supervisior.data-pencarian-pasien', ['data' => $data]);
        } catch (Exception $e) {
            return $e;
        }
    }
}
