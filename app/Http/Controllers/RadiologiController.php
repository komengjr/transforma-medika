<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        // 1. Validasi input No Registrasi
        if (!$request->filled('code')) {
            return response()->view('components.alert-error', [
                'message' => 'Kode Registrasi Radiologi tidak ditemukan.'
            ], 400);
        }

        $code = $request->code;

        // 2. Ambil data Master Registrasi Radiologi & Detail Pasien (1 Row Utama)
        $data = DB::table('d_reg_order_rad')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_rad.d_reg_order_rad_code', $code)
            ->select('d_reg_order_rad.*', 'd_reg_order.*', 'master_patient.*')
            ->first();

        // Jika No Registrasi Master tidak ditemukan
        if (!$data) {
            return response()->html(
                '<div class="alert alert-warning border-0 rounded-3 shadow-sm p-4 text-center">' .
                    '<i class="fas fa-exclamation-circle fa-2x mb-2 text-warning"></i>' .
                    '<h6>Data Tidak Ditemukan</h6>' .
                    '<p class="mb-0 small">No Registrasi Radiologi (' . e($code) . ') tidak terdaftar di sistem.</p>' .
                    '</div>'
            );
        }

        // 3. Ambil SEMUA Item Pemeriksaan di bawah No Registrasi Master ini
        // (Akan mengambil Panoramic & Thorax jika pasien memesan 2 pemeriksaan sekaligus)
        $pemeriksaanList = DB::table('d_reg_order_rad_list')
            ->leftJoin('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_rad_list.p_sales_data_code')
            ->where('d_reg_order_rad_list.d_reg_order_rad_code', $code)
            ->select(
                'd_reg_order_rad_list.*',
                'p_sales_data.p_sales_data_name as nama_pemeriksaan'
            )
            ->get();

        // 4. Ambil Master Layanan (opsional/pendukung)
        $layanan = DB::table('t_layanan_cat')->get();

        // 5. Render view Blade dan kembalikan HTML ke AJAX
        return view('application.radiologi.radiologi-handling.form-handling-pasien', [
            'data'            => $data,            // Header Pasien & Registrasi
            'pemeriksaanList' => $pemeriksaanList, // Array List Pemeriksaan (Multiple/Single)
            'layanan'         => $layanan,
            'code'            => $code             // No Registrasi Radiologi Master
        ]);
    }
    public function menu_radiologi_handling_pasien_print_barcode(Request $request){

    }
    private $orthancUrl = 'http://192.168.61.249:8042'; // Ganti dengan IP/Port Orthanc Anda
    private $orthancUser = 'orthanc';               // Kosongkan jika tanpa auth
    private $orthancPass = 'orthanc';               // Kosongkan jika tanpa auth
    public function menu_radiologi_handling_pasien_image($code)
    {
        try {
            // 1. Ambil SEMUA item pemeriksaan berdasarkan d_reg_order_rad_code
            $orders = DB::table('d_reg_order_rad_list')
                ->join('d_reg_order_rad', 'd_reg_order_rad.d_reg_order_rad_code', '=', 'd_reg_order_rad_list.d_reg_order_rad_code')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_rad.d_reg_order_code')
                ->leftJoin('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_rad_list.p_sales_data_code')
                ->where('d_reg_order_rad_list.d_reg_order_rad_code', $code)
                ->select(
                    'd_reg_order_rad_list.order_rad_list_code',
                    'd_reg_order_rad.d_reg_order_rad_code',
                    'p_sales_data.p_sales_data_name as nama_pemeriksaan'
                )
                ->get();

            if ($orders->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Data order tidak ditemukan'], 404);
            }

            $images = [];
            $studiesList = [];

            // 2. LOOPING PER ITEM PEMERIKSAAN (Agar Tombol OHIF Dipisah Per Pemeriksaan)
            foreach ($orders as $item) {
                $listCode = $item->order_rad_list_code;
                $namaPemeriksaan = $item->nama_pemeriksaan ?? 'Pemeriksaan Radiologi';

                // Cari Study di Orthanc berdasarkan PatientID = order_rad_list_code
                $res = Http::withBasicAuth($this->orthancUser, $this->orthancPass)
                    ->post("{$this->orthancUrl}/tools/find", [
                        'Level' => 'Study',
                        'Query' => [
                            'PatientID' => $listCode
                        ]
                    ]);

                if ($res->successful()) {
                    $studies = $res->json();

                    foreach ($studies as $studyId) {
                        $studyDetail = Http::withBasicAuth($this->orthancUser, $this->orthancPass)
                            ->get("{$this->orthancUrl}/studies/{$studyId}")
                            ->json();

                        if (!isset($studyDetail['Series'])) {
                            continue;
                        }

                        // Tambahkan ke daftar Study terpisah per item pemeriksaan
                        $studiesList[] = [
                            'order_rad_list_code' => $listCode,
                            'nama_pemeriksaan'    => $namaPemeriksaan,
                            'orthanc_study_id'   => $studyDetail['ID'] ?? $studyId,
                            'study_description'  => $studyDetail['MainDicomTags']['StudyDescription'] ?? $namaPemeriksaan,
                        ];

                        // Ambil instance gambar untuk preview gallery
                        foreach ($studyDetail['Series'] as $seriesId) {
                            $seriesDetail = Http::withBasicAuth($this->orthancUser, $this->orthancPass)
                                ->get("{$this->orthancUrl}/series/{$seriesId}")
                                ->json();

                            $modality = $seriesDetail['MainDicomTags']['Modality'] ?? 'CR';

                            if (isset($seriesDetail['Instances'])) {
                                foreach ($seriesDetail['Instances'] as $instanceId) {
                                    $images[] = [
                                        'study_id'         => $studyId,
                                        'instance_id'      => $instanceId,
                                        'nama_pemeriksaan' => $namaPemeriksaan,
                                        'preview_url'      => route('menu_radiologi_handling_pasien_rander_image', ['instanceId' => $instanceId]),
                                        'caption'          => "[$modality] " . $namaPemeriksaan . ' - ' . substr($instanceId, 0, 8)
                                    ];
                                }
                            }
                        }
                    }
                }
            }

            return response()->json([
                'success'      => true,
                'studies_list' => $studiesList, // Berisi list study + nama pemeriksaan untuk membuat button OHIF terpisah
                'images'       => $images
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
    public function menu_radiologi_handling_pasien_rander_image($instanceId)
    {
        try {
            // Mengambil preview gambar (PNG) langsung dari API Orthanc
            $response = Http::withBasicAuth($this->orthancUser, $this->orthancPass)
                ->get("{$this->orthancUrl}/instances/{$instanceId}/preview");

            if ($response->failed()) {
                return response('Gagal mengambil preview gambar', 404);
            }

            return response($response->body(), 200)
                ->header('Content-Type', 'image/png')
                ->header('Cache-Control', 'max-age=86400, public');
        } catch (\Exception $e) {
            return response('Error: ' . $e->getMessage(), 500);
        }
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
    // PACS SERVER
    public function pacs_server_studies_list($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $baseUrl = config('services.orthanc.url');
            $username = config('services.orthanc.username'); // Opsional jika pakai auth
            $password = config('services.orthanc.password'); // Opsional jika pakai auth

            $studiesList = [];

            try {
                // Menyiapkan HTTP Request ke Orthanc
                $http = Http::timeout(10);

                // Tambahkan Basic Auth jika diset di .env
                if ($username && $password) {
                    $http->withBasicAuth($username, $password);
                }

                // Gunakan endpoint /tools/find dengan MINTA TAG ModalitiesInStudy
                $response = $http->post("{$baseUrl}/tools/find", [
                    'Level'         => 'Study',
                    'Query'         => (object)[], // Kosongkan untuk mengambil SEMUA study
                    'Expand'        => true,       // true = sertakan detail tag DICOM pasien
                    'RequestedTags' => ['ModalitiesInStudy'] // <--- INI KUNCINYA agar Modality (CR, DX, CT) langsung keluar
                ]);

                if ($response->successful()) {
                    $studies = $response->json() ?? [];

                    foreach ($studies as $study) {
                        // 1. Ambil Modality dari RequestedTags atau MainDicomTags
                        $modality = $study['RequestedTags']['ModalitiesInStudy']
                            ?? $study['MainDicomTags']['ModalitiesInStudy']
                            ?? null;

                        // Jika masih null/array, format menjadi string (misal "CR" atau "CR, DX")
                        if (is_array($modality)) {
                            $modality = implode(', ', $modality);
                        } elseif (!$modality) {
                            $modality = 'CR'; // Fallback default
                        }

                        // 2. Hitung jumlah instance/gambar DICOM keseluruhan
                        $instancesCount = 0;
                        if (isset($study['Series']) && is_array($study['Series'])) {
                            // Biasanya jumlah instance estimasi dari series
                            $instancesCount = count($study['Series']);
                        }

                        $studiesList[] = [
                            'orthanc_study_id'   => $study['ID'],
                            'patient_id'         => $study['PatientMainDicomTags']['PatientID'] ?? '-',
                            'patient_name'       => $study['PatientMainDicomTags']['PatientName'] ?? 'anon',
                            'patient_birth_date' => $study['PatientMainDicomTags']['PatientBirthDate'] ?? '-',
                            'study_description'  => $study['MainDicomTags']['StudyDescription'] ?? '-',
                            'study_date'         => $study['MainDicomTags']['StudyDate'] ?? '-',
                            'modality'           => $modality, // <--- Sudah berisi CR, DX, CT, MR, dll.
                            'accession_number'   => $study['MainDicomTags']['AccessionNumber'] ?? '-',
                            'series_count'       => count($study['Series'] ?? []),
                            'instances_count'    => $instancesCount,
                        ];
                    }
                } else {
                    Log::error("Orthanc API Error Status: " . $response->status());
                }
            } catch (\Exception $e) {
                Log::error("Gagal terhubung ke Orthanc: " . $e->getMessage());
            }

            return view('application.radiologi.pacs-server.studies-list', compact('studiesList'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function pacs_server_studies_show(Request $request, $studyId)
    {
        $baseUrl = config('services.orthanc.url');
        $username = config('services.orthanc.username');
        $password = config('services.orthanc.password');

        $studyDetail = null;
        $studyInstanceUID = null;

        try {
            $http = Http::timeout(5);
            if ($username && $password) {
                $http->withBasicAuth($username, $password);
            }

            // Ambil detail Study dari Orthanc
            $response = $http->get("{$baseUrl}/studies/{$studyId}");

            if ($response->successful()) {
                $studyDetail = $response->json();
                // Mengambil StudyInstanceUID dari tag DICOM
                $studyInstanceUID = $studyDetail['MainDicomTags']['StudyInstanceUID'] ?? null;
            }
        } catch (\Exception $e) {
            // Handle error jika koneksi gagal
        }

        // =========================================================================
        // SOLUSI: Sisipkan Basic Auth langsung ke dalam URL Viewer
        // =========================================================================
        if ($username && $password) {
            // Mengubah "http://192.168.1.100:8042"
            // Menjadi "http://username:password@192.168.1.100:8042"
            $authenticatedBaseUrl = preg_replace(
                '#^https?://#',
                '$0' . rawurlencode($username) . ':' . rawurlencode($password) . '@',
                $baseUrl
            );
            $viewerUrl = "{$baseUrl}/ohif/viewer?StudyInstanceUIDs={$studyInstanceUID}";
        } else {
            $viewerUrl = "{$baseUrl}/ohif/viewer?StudyInstanceUIDs={$studyInstanceUID}";
        }

        // ATAU Jika OHIF berdiri sendiri (standalone server/docker/app terpisah):
        // $ohifUrl = "http://192.168.1.100:3000/viewer?StudyInstanceUIDs={$studyInstanceUID}";

        return view('application.radiologi.pacs-server.studies-show', compact('viewerUrl', 'studyId', 'studyDetail'));
    }
    public function proxy(Request $request, $path = null)
    {
        $baseUrl  = config('services.orthanc.url');
        $username = config('services.orthanc.username');
        $password = config('services.orthanc.password');

        // Susun target URL ke Orthanc
        $targetUrl = "{$baseUrl}/{$path}";
        if ($request->getQueryString()) {
            $targetUrl .= '?' . $request->getQueryString();
        }

        // Kirim request dari Laravel ke Orthanc membawa Basic Auth
        $http = Http::timeout(15);
        if ($username && $password) {
            $http->withBasicAuth($username, $password);
        }

        // Meneruskan method (GET, POST, dll) beserta body jika ada
        $response = $http->send($request->method(), $targetUrl, [
            'body' => $request->getContent(),
            'headers' => [
                'Content-Type' => $request->header('Content-Type', 'application/json'),
            ]
        ]);

        // Kembalikan response Orthanc langsung ke browser pengguna
        return response($response->body(), $response->status())
            ->header('Content-Type', $response->header('Content-Type'))
            ->header('Access-Control-Allow-Origin', '*');
    }
}
