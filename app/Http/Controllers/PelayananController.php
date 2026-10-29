<?php

namespace App\Http\Controllers;

use App\Imports\PesertaAllImport;
use App\Imports\PesertaImport;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Session;
use Svg\Tag\Rect;
use Illuminate\Support\Facades\File;

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
    public function registrasi_pasien($akses, $id, Request $request)
    {
        if ($this->url_akses($akses, $id) == true) {
            $ipClient = $request->ip(); // Mengambil IP Client/PC

            $total = DB::table('d_reg_order')->where('d_reg_order_cabang', Auth::user()->access_cabang)->count();
            $reject = DB::table('d_reg_order')->where('d_reg_order_cabang', Auth::user()->access_cabang)
                ->where('d_reg_order_status', -1)->count();

            $data = DB::table('d_reg_order')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('t_pasien_cat', 't_pasien_cat.t_pasien_cat_code', '=', 'd_reg_order.t_pasien_cat_code')
                ->where("d_reg_order_cabang", Auth::user()->access_cabang)->get();

            return view('application.pelayanan.registrasi-pasien', [
                'akses' => $akses,
                'code' => $id,
                'total' => $total,
                'reject' => $reject,
                'data' => $data,
                'ipClient' => $ipClient // Pass IP ke View Utama
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function registrasi_pasien_v2($akses, $id)
    {
        return view('application.pelayanan.registrasi-v2');
    }
    public function registrasi_pasien_add(Request $request)
    {
        return view('application.pelayanan.form.form-registrasi');
    }
    public function registrasi_pasien_create(Request $request)
    {
        $provinsi = DB::table('m_province')->get();
        return view('application.pelayanan.form.form-add', ['provinsi' => $provinsi]);
    }
    public function registrasi_pasien_create_pilih_provinsi(Request $request)
    {
        $city = DB::table('m_city')->where('M_CityM_ProvinceID', $request->id)->get();
        return view('application.pelayanan.form.location.detail-city', ['city' => $city]);
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
        // Validasi sederhana (opsional tapi disarankan)
        $request->validate([
            'nik' => 'required',
            'nama' => 'required',
            'jk' => 'required',
            'tgl_lahir' => 'required',
            'no_hp' => 'required',
        ]);

        if (empty($request->link)) {
            $file = null;
        } else {
            $file = 'profile/data_pasien/' . Auth::user()->access_cabang . '/' . $request->link;
        }

        // Cek apakah NIK sudah terdaftar
        $cek = DB::table('master_patient')->where('master_patient_nik', $request->nik)->first();

        if (!$cek) {
            DB::table('master_patient')->insert([
                'master_patient_code' => 'MPP' . date('YmdHis'),
                'master_patient_nik' => $request->nik,
                'master_patient_name' => $request->nama,
                'master_patient_jk' => $request->jk,
                'master_patient_tgl_lahir' => $request->tgl_lahir,
                'master_patient_tempat_lahir' => $request->tempat_lahir,
                'master_patient_agama' => $request->agama,
                'master_patient_no_hp' => $request->no_hp,
                'master_patient_email' => $request->email,
                'master_patient_place' => $request->data_city,
                'master_patient_alamat' => $request->alamat,
                'master_patient_profile' => $file,
                'created_at' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data pasien baru berhasil disimpan!',
                'icon' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'NIK sudah terdaftar dalam sistem!',
                'icon' => 'warning'
            ]);
        }
    }
    public function registrasi_pasien_cari_data_pasien(Request $request)
    {
        if ($request->option_pencarian == "") {
            return 0;
        } elseif ($request->option_pencarian == "nama") {
            $data = DB::table('master_patient')->where('master_patient_name', 'like', '%' . $request->option_nama . '%')->get();
            return view('application.pelayanan.form.table-pencarian-pasien', ['data' => $data]);
        } elseif ($request->option_pencarian == "tanggal_lahir") {
            $data = DB::table('master_patient')->where('master_patient_tgl_lahir', 'like', '%' . $request->option_nama . '%')->get();
            return view('application.pelayanan.form.table-pencarian-pasien', ['data' => $data]);
        }
    }
    public function registrasi_pasien_pilih_data_pasien(Request $request)
    {
        $list = DB::table('d_reg_order')->where('d_reg_order_date', date('Y-m-d'))->count();
        $no_reg = date('Ymdhis') . str_pad($list + 1, 3, '0', STR_PAD_LEFT);
        $data = DB::table('master_patient')
            ->join('m_city', 'm_city.M_CityID', '=', 'master_patient.master_patient_place')
            ->where('master_patient_code', $request->code)->first();
        return view('application.pelayanan.form.form-registrasi-proses', ['data' => $data, 'no_reg' => $no_reg]);
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan(Request $request)
    {
        $layanan = DB::table('t_layanan_cat')
            ->join('t_layanan_cabang', 't_layanan_cabang.t_layanan_cat_code', '=', 't_layanan_cat.t_layanan_cat_code')
            ->where('access_cabang', Auth::user()->access_cabang)->get();
        return view('application.pelayanan.form.form-kebutuhan-pasien', ['code' => $request->code, 'layanan' => $layanan]);
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_layanan(Request $request)
    {
        $pasien_cat = DB::table('t_pasien_cat')
            ->join('t_pasien_cat_data', 't_pasien_cat_data.t_pasien_cat_code', '=', 't_pasien_cat.t_pasien_cat_code')
            ->where('t_pasien_cat.t_pasien_cat_code', $request->cat)->get();
        if ($request->id == 'POLI') {
            $poli = DB::table('m_poli')->get();
            return view('application.pelayanan.form.kebutuhan.form-poliklinik', ['poli' => $poli, 'cat' => $pasien_cat]);
        } elseif ($request->id == 'LAB') {
            $dokter = DB::table('master_doctor')->get();
            $agrement = DB::table('p_sales')->get();
            $code = 'LAB';
            $masterSales = DB::table('p_m_sales')
                ->where('p_m_sales_status', '1') // atau atur filter status aktif jika ada
                ->get();
            return view('application.pelayanan.form.kebutuhan.form-laboratorium', compact('masterSales'), ['cat' => $pasien_cat, 'dokter' => $dokter, 'agrement' => $agrement, 'code' => $code]);
        } elseif ($request->id == '857946b2-62c2-488b-af9d-c4d330041b44') {
            $dokter = DB::table('master_doctor')->get();
            return view('application.pelayanan.form.kebutuhan.form-igd', ['cat' => $pasien_cat, 'dokter' => $dokter]);
        } elseif ($request->id == 'RAD') {
            $code = $request->code ?? 'RAD';
            // Fetch Dokter Master
            $dokter = DB::table('master_doctor')->get();
            // Fetch Kategori tambahan pasien jika ada
            $cat = DB::table('t_pasien_cat_data')->get();

            // Fetch STEP 1: Master Sales / Agreement (Sama seperti Lab)
            $masterSales = DB::table('p_m_sales')
                ->select('p_m_sales_code', 'p_m_sales_name')
                ->orderBy('p_m_sales_name', 'ASC')
                ->get();
            return view('application.pelayanan.form.kebutuhan.form-radiologi', compact('dokter', 'cat', 'masterSales', 'code'));
        } else {
            return '<span class="badge bg-warning">Coming Soon</span>';
        }
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_upload_file(Request $request)
    {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
        if (!$receiver->isUploaded()) {
            // file not uploaded
        }
        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.' . $extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name

            $disk = Storage::disk(config('filesystems.default'));
            $path = $disk->putFileAs('public/data_pasien/penunjang/' . auth::user()->access_cabang, $file, $fileName);
            // $path1 = $disk('videos', $file, $fileName);

            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => Storage::url('data_pasien/penunjang/' . auth::user()->access_cabang . '/' . $fileName),
                'filename' => $fileName
            ];
        }

        // otherwise return percentage informatoin
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
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
        $poliCode = $request->m_poli_code;
        $tanggal  = $request->tanggal_periksa;

        // Tentukan nama hari dalam Bahasa Indonesia dari tanggal periksa
        $dayIndex = Carbon::parse($tanggal)->dayOfWeek;
        $daysInIndonesian = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu'
        ];
        $dayName = $daysInIndonesian[$dayIndex];

        // Query Dokter yang memiliki jadwal AKTIF pada hari & poli tersebut
        $doctors = DB::table('m_poli_doctor_schedule as s')
            ->join('master_doctor as d', 's.master_doctor_code', '=', 'd.master_doctor_code')
            ->where('s.m_poli_code', $poliCode)
            ->where('s.day_name', $dayName)
            ->where('s.status', 'AKTIF')
            ->select('d.master_doctor_code', 'd.master_doctor_name', 'd.master_doctor_title_f', 'd.master_doctor_title_e')
            ->distinct()
            ->get();

        if ($doctors->isEmpty()) {
            return response()->json([
                'status'  => false,
                'message' => 'Tidak ada dokter yang berpraktik pada hari ' . $dayName,
                'doctors' => []
            ]);
        }

        return response()->json([
            'status'  => true,
            'doctors' => $doctors
        ]);
    }
    public function registrasi_pasien_pilih_data_pasien_get_dokter_poli(Request $request)
    {
        $poliCode = $request->m_poli_code;
        $tanggal  = $request->tanggal_periksa;

        // Tentukan nama hari dalam Bahasa Indonesia dari tanggal periksa
        $dayIndex = Carbon::parse($tanggal)->dayOfWeek;
        $daysInIndonesian = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu'
        ];
        $dayName = $daysInIndonesian[$dayIndex];

        // Query Dokter yang memiliki jadwal AKTIF pada hari & poli tersebut
        $doctors = DB::table('m_poli_doctor_schedule as s')
            ->join('master_doctor as d', 's.master_doctor_code', '=', 'd.master_doctor_code')
            ->where('s.m_poli_code', $poliCode)
            ->where('s.day_name', $dayName)
            ->where('s.status', 'AKTIF')
            ->select('d.master_doctor_code', 'd.master_doctor_name', 'd.master_doctor_title_f', 'd.master_doctor_title_e')
            ->distinct()
            ->get();

        if ($doctors->isEmpty()) {
            return response()->json([
                'status'  => false,
                'message' => 'Tidak ada dokter yang berpraktik pada hari ' . $dayName,
                'doctors' => []
            ]);
        }

        return response()->json([
            'status'  => true,
            'doctors' => $doctors
        ]);
    }
    // 2. Endpoint untuk mendapatkan Detail Kuota & Jam Kerja Dokter
    public function registrasi_pasien_pilih_data_pasien_get_dokter_quota(Request $request)
    {
        $poliCode   = $request->m_poli_code;
        $doctorCode = $request->master_doctor_code;
        $tanggal    = $request->tanggal_periksa;

        $dayIndex = Carbon::parse($tanggal)->dayOfWeek;
        $daysInIndonesian = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu'
        ];
        $dayName = $daysInIndonesian[$dayIndex];

        // Ambil Jadwal Dokter
        $schedule = DB::table('m_poli_doctor_schedule')
            ->where('m_poli_code', $poliCode)
            ->where('master_doctor_code', $doctorCode)
            ->where('day_name', $dayName)
            ->where('status', 'AKTIF')
            ->first();

        if (!$schedule) {
            return '<div class="alert alert-warning">Jadwal dokter tidak ditemukan.</div>';
        }

        // Hitung jumlah pendaftaran aktif yang sudah masuk di t_registrations
        $terpakai = DB::table('t_registrations')
            ->where('schedule_id', $schedule->id_schedule)
            ->where('visit_date', $tanggal)
            ->where('status', '!=', 'BATAL')
            ->count();

        $sisaKuota = max(0, $schedule->quota - $terpakai);

        // Return Partial View HTML
        return view('application.pelayanan.form.kebutuhan.poliklinik.kuota-dokter-poli', compact('schedule', 'terpakai', 'sisaKuota', 'tanggal'));
    }
    // 3. Endpoint untuk Menyimpan Pendaftaran ke t_registrations
    public function registrasi_pasien_pilih_data_pasien_storeRegistration(Request $request)
    {

        try {
            return DB::transaction(function () use ($request) {
                $tglHariIni  = date('Y-m-d');
                $tglVisit    = $request->d_reg_order_poli_visit ?? $tglHariIni;
                $userActive  = Auth::user()->id ?? Auth::user()->username ?? 'SYSTEM';

                // -------------------------------------------------------------
                // 1. INSERT / CEK MASTER REGISTRASI ORDER (d_reg_order)
                // -------------------------------------------------------------
                // Cek apakah pasien sudah memiliki pendaftaran order aktif pada hari ini
                $existingOrder = DB::table('d_reg_order')
                    ->where('d_reg_order_rm', $request->d_reg_order_rm)
                    ->whereDate('d_reg_order_date', $tglHariIni)
                    ->first();

                if ($existingOrder) {
                    $orderCode = $existingOrder->d_reg_order_code;
                } else {
                    // Generate Kode Order Baru
                    $orderCode = 'ORD-' . date('YmdHis') . '-' . rand(100, 999);

                    DB::table('d_reg_order')->insert([
                        'd_reg_order_code'     => $orderCode,
                        'd_reg_order_rm'       => $request->patientCode,
                        'd_reg_order_date'     => $tglHariIni,
                        't_layanan_cat_code'   => 'POLI',
                        't_pasien_cat_code'    => 'UMUM',
                        'd_reg_order_status'   => 'REGISTERED',
                        'd_reg_order_cabang'     => Auth::user()->access_cabang,
                        'd_reg_order_user'     => Auth::user()->userid,
                        'created_at'           => now(),
                        'updated_at'           => now(),
                    ]);
                }

                // -------------------------------------------------------------
                // 2. GENERATE NOMOR ANTREAN POLI
                // -------------------------------------------------------------
                $lastQueue = DB::table('d_reg_order_poli')
                    ->where('m_poli_code', $request->m_poli_code)
                    ->whereDate('d_reg_order_poli_visit', $tglVisit)
                    ->max('d_reg_order_poli_queue');

                $nextQueueNumber = ($lastQueue ? (int)$lastQueue : 0) + 1;
                $queueFormatted  = str_pad($nextQueueNumber, 3, '0', STR_PAD_LEFT); // Contoh: 001, 002

                // -------------------------------------------------------------
                // 3. INSERT DETAIL REGISTRASI POLI (d_reg_order_poli)
                // -------------------------------------------------------------
                $codeOrderPoli = 'POLI' . '-' . date('YmdHis') . '-' . rand(100, 999);
                $dokter = DB::table('m_poli_doctor_schedule')->where('id_schedule', $request->schedule_id)->first();
                DB::table('d_reg_order_poli')->insert([
                    'd_reg_order_poli_code'   => $codeOrderPoli,
                    'd_reg_order_code'        => $orderCode, // Terhubung ke d_reg_order
                    'master_doctor_code'      => $dokter->master_doctor_code,
                    'd_reg_order_poli_date'   => now(),
                    'd_reg_order_poli_status' => 'REGISTRATION',
                    'd_reg_order_poli_user'   => $userActive,
                    'd_reg_order_poli_queue'  => $queueFormatted,
                    'm_poli_code'             => $request->m_poli_code,
                    'schedule_id'             => $request->schedule_id,
                    'd_reg_order_poli_visit'  => $tglVisit,
                    'payment_method'          => $request->payment_method,
                    'insurance_no'            => ($request->payment_method !== 'UMUM') ? $request->insurance_no : null,
                    // 'd_reg_order_poli_status' => 'MENUNGGU',
                    'created_at'              => now(),
                    'updated_at'              => now(),
                ]);
                DB::table('d_reg_order_list')->insert([
                    'd_reg_order_list_code' => $codeOrderPoli,
                    'd_reg_order_code' => $orderCode,
                    't_layanan_cat_code' => 'POLI',
                    'd_reg_order_list_date' => now(),
                    'created_at' => now(),
                ]);
                return response()->json([
                    'status'     => 'success',
                    'message'    => 'Registrasi berhasil disimpan! Nomor Antrean Poli: ' . $queueFormatted,
                    'order_code' => $orderCode,
                    'queue'      => $queueFormatted, // <--- Pastikan nama key ini sesuai dengan JavaScript
                    'icon'       => 'success'
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan pendaftaran: ' . $e->getMessage(),
                'icon'    => 'error'
            ], 500);
        }
        // $request->validate([
        //     'patient_id'     => 'required',
        //     'm_poli_code'    => 'required',
        //     'schedule_id'    => 'required',
        //     'visit_date'     => 'required|date',
        //     'payment_method' => 'required',
        // ]);

        // DB::beginTransaction();
        // try {
        //     // Check Sisa Kuota
        //     $schedule = DB::table('m_poli_doctor_schedule')
        //         ->where('id_schedule', $request->schedule_id)
        //         ->first();

        //     $existingCount = DB::table('t_registrations')
        //         ->where('schedule_id', $request->schedule_id)
        //         ->where('visit_date', $request->visit_date)
        //         ->where('status', '!=', 'BATAL')
        //         ->count();

        //     if ($existingCount >= $schedule->quota) {
        //         return response()->json([
        //             'status'  => false,
        //             'message' => 'Kuota pendaftaran untuk jadwal ini sudah penuh.'
        //         ], 422);
        //     }

        //     // Generate Nomor Antrean Otomatis (Format: A-001, A-002, dst.)
        //     $nextQueueNum = $existingCount + 1;
        //     $queueNumber  = 'A-' . str_pad($nextQueueNum, 3, '0', STR_PAD_LEFT);

        //     // Simpan ke t_registrations
        //     $registrationId = DB::table('t_registrations')->insertGetId([
        //         'queue_number'   => $queueNumber,
        //         'patient_id'     => $request->patient_id,
        //         'm_poli_code'    => $request->m_poli_code,
        //         'schedule_id'    => $request->schedule_id,
        //         'visit_date'     => $request->visit_date,
        //         'payment_method' => $request->payment_method,
        //         'insurance_no'   => $request->insurance_no ?? null,
        //         'status'         => 'MENUNGGU',
        //         'created_at'     => now(),
        //         'updated_at'     => now(),
        //     ]);

        //     DB::commit();

        //     return response()->json([
        //         'status'  => true,
        //         'message' => 'Pendaftaran berhasil disimpan.',
        //         'data'    => [
        //             'id_registration' => $registrationId,
        //             'queue_number'    => $queueNumber
        //         ]
        //     ]);
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json([
        //         'status'  => false,
        //         'message' => 'Gagal menyimpan pendaftaran: ' . $e->getMessage()
        //     ], 500);
        // }
    }

    public function registrasi_pasien_pilih_data_pasien_print_ticket(Request $request)
    {
        $validated = $request->validate([
            'queue_no'     => 'required|string',
            'poli_name'    => 'required|string',
            'doctor_name'  => 'required|string',
            'patient_code' => 'required|string',
            'patient_name' => 'required|string',
            'payment'      => 'required|string',
            'date'         => 'required|string',
        ]);

        try {
            // OPTION A: Jika menggunakan printer lokal yang terhubung ke server/PC kasir (Mike42 Escpos)
            /*
            $connector = new \Mike42\Escpos\PrintConnectors\WindowsPrintConnector("PRINTER_RECEIPT_NAME");
            $printer   = new \Mike42\Escpos\Printer($connector);

            $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_CENTER);
            $printer->selectPrintMode(\Mike42\Escpos\Printer::MODE_DOUBLE_HEIGHT | \Mike42\Escpos\Printer::MODE_DOUBLE_WIDTH);
            $printer->text("RSUD HOSPITAL\n");
            $printer->selectPrintMode();
            $printer->text("Bukti Pendaftaran Poliklinik\n");
            $printer->text("--------------------------------\n");
            $printer->text("Nomor Antrean:\n");
            $printer->setTextSize(3, 3);
            $printer->text($validated['queue_no'] . "\n");
            $printer->setTextSize(1, 1);
            $printer->text("--------------------------------\n");
            $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_LEFT);
            $printer->text("Poli    : " . $validated['poli_name'] . "\n");
            $printer->text("Dokter  : " . $validated['doctor_name'] . "\n");
            $printer->text("Kode    : " . $validated['patient_code'] . "\n");
            $printer->text("Pasien  : " . $validated['patient_name'] . "\n");
            $printer->text("Penjamin: " . $validated['payment'] . "\n");
            $printer->text("Tanggal : " . $validated['date'] . "\n");
            $printer->text("--------------------------------\n");
            $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_CENTER);
            $printer->text("Harap datang 15 menit\nsebelum jam praktik.\n\n");
            $printer->cut();
            $printer->close();
            */

            // Return response sukses jika tidak ada error
            return response()->json([
                'status'  => true,
                'message' => 'Perintah cetak tiket berhasil dikirim ke printer.',
                'data'    => $validated
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal mencetak tiket: ' . $e->getMessage()
            ], 500);
        }
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
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')->get();
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
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_rad_code', $request->reg)->get();
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
        $antrian = DB::table('d_reg_order_poli')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_poli.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_date', $request->tgl)
            ->where('m_doctor_poli_code', $request->code)->get();
        return view('application.pelayanan.form.kebutuhan.form-dokter-poliklinik', [
            'dokter' => $dokter,
            'tgl' => $request->tgl,
            'antrian' => $antrian
        ]);
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_poli(Request $request)
    {
        DB::table('d_reg_order')->insert([
            'd_reg_order_code' => $request->no_reg,
            'd_reg_order_rm' => $request->no_rm,
            'd_reg_order_date' => now(),
            't_layanan_cat_code' => $request->layanan,
            't_pasien_cat_code' => $request->cat,
            'd_reg_order_cabang' => Auth::user()->access_cabang,
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
        $cat = DB::table('t_pasien_cat_data')->where('t_pasien_cat_code', $request->cat)->get();
        foreach ($cat as $value) {
            if ($request->data_penunjang == "") {
            } else {
                if ($value->t_pasien_cat_data_type == 'text') {
                    DB::table('t_pasien_cat_data_poli')->insert([
                        'id_t_pasien_cat_data' => $value->id_t_pasien_cat_data,
                        'd_reg_order_poli_code' => $code,
                        't_pasien_cat_data_poli_desc' => $request->data_penunjang,
                        'created_at' => now()
                    ]);
                } elseif ($value->t_pasien_cat_data_type == 'file') {
                    DB::table('t_pasien_cat_data_poli')->insert([
                        'id_t_pasien_cat_data' => $value->id_t_pasien_cat_data,
                        'd_reg_order_poli_code' => $code,
                        't_pasien_cat_data_poli_desc' => 'data_pasien/penunjang/' . Auth::user()->access_cabang . '/' . $request->data_link,
                        'created_at' => now()
                    ]);
                }
            }
        }
        return 13;
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_lab(Request $request)
    {
        Log::info('RAW ITEMS FROM REQUEST:', ['raw' => $request->items]);

        $items = json_decode($request->items, true);
        Log::info('PARSED ITEMS:', ['parsed' => $items]);

        if (empty($items) || !is_array($items)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal: Data item pemeriksaan kosong di Controller!'
            ], 400);
        }

        DB::beginTransaction();
        try {
            $user  = Auth::user()->name ?? 'System';
            $today = date('Y-m-d');
            $now   = now();

            $orderCode    = 'ORD-' . date('YmdHis') . '-' . rand(100, 999);
            $orderLabCode = 'LAB-' . date('YmdHis') . '-' . rand(100, 999);
            $labNumber    = 'REG-LAB-' . date('Ymd') . '-' . rand(1000, 9999);

            // Insert Header 1
            DB::table('d_reg_order')->insert([
                'd_reg_order_code'   => $orderCode,
                'd_reg_order_rm'     => $request->no_rm ?? '-',
                'd_reg_order_date'   => $request->date ?? $today,
                't_layanan_cat_code' => 'LAB',
                't_pasien_cat_code'  => $request->patient_cat,
                'd_reg_order_status' => '1',
                'd_reg_order_user'   => Auth::user()->userid,
                'd_reg_order_cabang' => '-',
                'created_at'         => $now,
                'updated_at'         => $now,
            ]);

            // Insert Header 2
            DB::table('d_reg_order_lab')->insert([
                'd_reg_order_lab_code'   => $orderLabCode,
                'd_reg_order_code'       => $orderCode,
                'd_reg_order_lab_date'   => $request->date ?? $today,
                'd_reg_order_lab_number' => $labNumber,
                'd_reg_order_lab_rujukan' => $request->rujukan,
                'd_reg_order_lab_status' => '1',
                'd_reg_order_lab_user'   => $user,
                'created_at'             => $now,
                'updated_at'             => $now,
            ]);

            // Insert Header 3
            DB::table('d_reg_order_list')->insert([
                'd_reg_order_list_code' => $orderLabCode,
                'd_reg_order_code'      => $orderCode,
                't_layanan_cat_code'    => 'LAB',
                'd_reg_order_list_date' => $request->date ?? $today,
                'created_at'            => $now,
                'updated_at'            => $now,
            ]);

            // Insert Detail Item (d_reg_order_lab_list)
            // 1. Pastikan $items ter-decode menjadi Array jika dikirim sebagai String
            $items = is_string($request->items) ? json_decode($request->items, true) : $request->items;

            // 2. Siapkan Array Bulk Insert
            $insertLabList = [];

            foreach ($items as $index => $item) {
                // KODE UNIK DENGAN MICROTIME AGAR GUARANTEED UNIK
                $uniqueCode = 'L' . date('ymd') . '' . Str::upper(Str::random(2)) . '' . sprintf("%02d", $index + 1);

                $insertLabList[] = [
                    'order_lab_list_code'   => $uniqueCode,
                    'd_reg_order_lab_code'  => $orderLabCode,
                    'p_sales_data_code'     => $item['code'],
                    'order_lab_log_price'    => (int) $item['harga'],
                    'order_lab_log_discount' => 0,
                    'status_pembayaran'     => '0',
                    'created_at'            => $now,
                    'updated_at'            => $now,
                ];
            }

            // 3. Eksekusi Ekstraksi Sekaligus (Lebih Efisien & Cepat)
            if (!empty($insertLabList)) {
                DB::table('d_reg_order_lab_list')->insert($insertLabList);
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Registrasi Lab Berhasil Disimpan!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ERROR SIMPAN LAB LIST:', ['error' => $e->getMessage()]);
            return response()->json([
                'status'  => 'error',
                'message' => 'Error DB: ' . $e->getMessage()
            ], 500);
        }
    }
    public function registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_rad(Request $request)
    {
        // 1. Validasi Input Data
        $request->validate([
            'no_rm'        => 'required|string',
            'date'         => 'required|date',
            'rujukan'      => 'required|string',
            'items'        => 'required|array|min:1',
            'items.*.code' => 'required|string',
            'items.*.price' => 'required|numeric',
            // 'file_rujukan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120' // Maks 5MB
        ]);

        DB::beginTransaction();

        try {
            $userLogin   = Auth::user()->name ?? 'System';
            $tglPeriksa  = $request->date;
            $nowTime     = now();

            // Handle Upload File Rujukan (jika ada)
            $filePath = null;
            if ($request->hasFile('file_rujukan')) {
                $filePath = $request->file('file_rujukan')->store('rujukan_radiologi', 'public');
            }

            // Generate Kode Unik
            $orderCode    = 'ORD-' . date('YmdHis') . '-' . rand(100, 999);
            $orderRadCode = 'RAD-' . date('YmdHis') . '-' . rand(100, 999);

            // -------------------------------------------------------------
            // TABEL 1: d_reg_order
            // -------------------------------------------------------------
            DB::table('d_reg_order')->insert([
                'd_reg_order_code'   => $orderCode,
                'd_reg_order_rm'     => $request->no_rm,
                'd_reg_order_date'   => $tglPeriksa,
                't_layanan_cat_code' => $request->t_layanan_cat_code ?? 'RAD', // Kode layanan Radiologi
                't_pasien_cat_code'  => $request->patient_cat ?? 'pribadi',
                'd_reg_order_status' => 'PENDING',
                'd_reg_order_user'   => Auth::user()->userid,
                'd_reg_order_cabang' => '-',
                'created_at'         => $nowTime,
                'updated_at'         => $nowTime,
            ]);

            // -------------------------------------------------------------
            // TABEL 2: d_reg_order_list
            // -------------------------------------------------------------
            DB::table('d_reg_order_list')->insert([
                'd_reg_order_list_code' => $orderRadCode,
                'd_reg_order_code'      => $orderCode,
                't_layanan_cat_code'    => 'RAD',
                'd_reg_order_list_date' => $tglPeriksa,
                'created_at'            => $nowTime,
                'updated_at'            => $nowTime,
            ]);

            // -------------------------------------------------------------
            // TABEL 3: d_reg_order_rad
            // -------------------------------------------------------------
            DB::table('d_reg_order_rad')->insert([
                'd_reg_order_rad_code'       => $orderRadCode,
                'd_reg_order_code'           => $orderCode,
                'd_reg_order_rad_dr_rujukan' => $request->rujukan,
                'd_reg_order_rad_dr_baca'    => $request->dr_baca ?? '', // Dokter spesialis Radiologi
                'd_reg_order_rad_date'       => $tglPeriksa,
                'd_reg_order_rad_desc'       => $filePath ?? '', // Menyimpan path file rujukan/keterangan
                'd_reg_order_rad_number'     => 'RAD-NO-' . rand(1000, 9999),
                'd_reg_order_rad_status'     => 'PENDING',
                'd_reg_order_rad_user'       => $userLogin,
                'created_at'                 => $nowTime,
                'updated_at'                 => $nowTime,
            ]);

            // -------------------------------------------------------------
            // TABEL 4: d_reg_order_rad_list (Looping Item Pemeriksaan)
            // -------------------------------------------------------------
            $itemsData = [];
            foreach ($request->items as $index => $item) {
                $uniqueCode = 'R' . date('ymd') . '' . Str::upper(Str::random(2)) . '' . sprintf("%02d", $index + 1);
                $itemsData[] = [
                    'order_rad_list_code'    => $uniqueCode,
                    'd_reg_order_rad_code'   => $orderRadCode,
                    'p_sales_data_code'      => $item['code'],
                    'order_rad_log_price'    => (int) $item['price'],
                    'order_rad_log_discount' => (int) ($item['discount'] ?? 0),
                    'status_pembayaran'      => 'BELUM LULUS', // atau 'UNPAID'
                    'created_at'             => $nowTime,
                    'updated_at'             => $nowTime,
                ];
            }

            // Mass Insert Ke Tabel Detail
            DB::table('d_reg_order_rad_list')->insert($itemsData);

            // Jika Semua Query Berhasil
            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Registrasi Radiologi Berhasil Disimpan!',
                'data'    => [
                    'order_code'     => $orderCode,
                    'order_rad_code' => $orderRadCode
                ]
            ], 200);
        } catch (Exception $e) {
            // Batalkan semua transaksi jika terjadi error
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data registrasi radiologi: ' . $e->getMessage()
            ], 500);
        }
    }
    public function registrasi_pasien_pilih_data_pasien_end_proses(Request $request)
    {
        $data = DB::table('d_reg_order')->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order.d_reg_order_code', $request->code)->first();
        return 'sukses';
        // return view('application.pelayanan.form.form-nomor-registrasi', [
        //     'code' => $request->code,
        //     'data' => $data
        // ]);
    }
    public function registrasi_pasien_pilih_data_pasien_preview_pdf(Request $request)
    {
        $pasien = DB::table('d_reg_order')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order.d_reg_order_code', $request->code)->first();
        $tgl_lahir_carbon = Carbon::parse($pasien->master_patient_tgl_lahir);
        $umur_tahun = $tgl_lahir_carbon->diffInYears(); // Menghitung umur dalam tahun
        $poli_gigi = DB::table('t_pasien_cat_data_poli')
            ->join('d_reg_order_poli', 'd_reg_order_poli.d_reg_order_poli_code', '=', 't_pasien_cat_data_poli.d_reg_order_poli_code')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_poli.d_reg_order_code')
            ->join('t_pasien_cat_data', 't_pasien_cat_data.id_t_pasien_cat_data', '=', 't_pasien_cat_data_poli.id_t_pasien_cat_data')
            ->where('d_reg_order.d_reg_order_code', $request->code)->get();
        $poli_gigi_doc = DB::table('t_pasien_cat_data_poli')
            ->join('d_reg_order_poli', 'd_reg_order_poli.d_reg_order_poli_code', '=', 't_pasien_cat_data_poli.d_reg_order_poli_code')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_poli.d_reg_order_code')
            ->join('t_pasien_cat_data', 't_pasien_cat_data.id_t_pasien_cat_data', '=', 't_pasien_cat_data_poli.id_t_pasien_cat_data')
            ->where('d_reg_order.d_reg_order_code', $request->code)->where('t_pasien_cat_data.t_pasien_cat_data_type', 'file')->first();
        // $file_gigi = base64_encode(Storage::url($poli_gigi_doc->t_pasien_cat_data_poli_desc));
        $file_gigi = base64_encode(file_get_contents(public_path('storage/' . $poli_gigi_doc->t_pasien_cat_data_poli_desc)));
        $umur = $umur_tahun . ' Th ';
        $image = base64_encode(file_get_contents(public_path('img/favicon.png')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.pelayanan.form.report.preview-registrasi', [
            'code' => $request->code,
            'pasien' => $pasien,
            'umur' => $umur,
            'poli_gigi' => $poli_gigi,
        ], compact('image', 'file_gigi'))
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
    public function registrasi_pasien_list_que(Request $request)
    {
        $clientIp = $request->ip();

        // Ambil data counter berdasarkan IP PC
        $assignedCounter = DB::table('medical_loket_counters')
            ->where('ip_address', $clientIp)
            ->first();

        // Ambil daftar loket pendukung
        $loketList = DB::table('medical_loket')->get();

        return view('application.pelayanan.antrian.list-antrian', compact('clientIp', 'assignedCounter', 'loketList'));
    }
    public function registrasi_pasien_poses_registrasi_pasien(Request $request)
    {
        // Tangkap parameter query dari AJAX modal
        $nomorAntrian = $request->query('nomor_antrian');
        $logId = $request->query('log_id');

        // (Opsional) Ambil data tambahan dari DB jika diperlukan
        // $antrianLog = AntrianLog::find($logId);

        // Renderpartial view form registrasi
        return view('application.pelayanan.antrian.form-proses-registrasi-pasien', compact('nomorAntrian', 'logId'));
    }
    public function registrasi_pasien_find_data_pasien(Request $request)
    {
        $keyword = $request->query('keyword');

        $pasien = DB::table('master_patient')
            ->where('master_patient_nik', 'LIKE', "%{$keyword}%")
            ->orWhere('master_patient_code', 'LIKE', "%{$keyword}%")
            ->orWhere('master_patient_name', 'LIKE', "%{$keyword}%")
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pasien
        ]);
    }
    public function registrasi_pasien_find_bpjs(Request $request)
    {
        $keyword = $request->query('keyword');

        if (!$keyword) {
            return response()->json(['success' => false, 'message' => 'Kata kunci pencarian tidak boleh kosong.']);
        }

        try {
            // --- CONTOH SIMULASI INTEGRASI API BPJS / VCLAIM ---
            // Gantikan blok ini dengan HTTP Client / Service Bridging VClaim BPJS Anda
            // $response = Http::withHeaders(...)->get("url_vclaim_bpjs/Peserta/nokartu/$keyword");

            // Contoh Data Response yang Berhasil Ditarik dari BPJS:
            $dataBpjs = [
                'no_kartu' => '0001234567890',
                'nik' => '6171012304950001',
                'nama' => 'Ahmad Subagja',
                'sex' => 'L',
                'tgl_lahir' => '1995-04-23',
                'no_telepon' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 45, Kota Pontianak',
                'status_peserta' => 'AKTIF',
                'faskes_1' => 'Puskesmas Perdana'
            ];

            return response()->json([
                'success' => true,
                'data' => $dataBpjs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghubungkan ke Server BPJS: ' . $e->getMessage()
            ], 500);
        }
    }
    public function getPoliSchedules(Request $request)
    {
        // Mengambil nama hari dalam bahasa Indonesia
        $daysMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu'
        ];
        $todayName = $daysMap[Carbon::now()->format('l')];

        $schedules = DB::table('m_poli_doctor_schedule as s')
            ->join('m_poli_doctor as pd', 's.m_poli_doctor_id', '=', 'pd.id')
            ->join('m_poli as p', 's.m_poli_code', '=', 'p.m_poli_code')
            ->join('master_doctor as d', 's.master_doctor_code', '=', 'd.master_doctor_code')
            ->select(
                'p.m_poli_code',
                'p.m_poli_name',
                'd.master_doctor_code',
                'd.master_doctor_title_f',
                'd.master_doctor_name',
                'd.master_doctor_title_e',
                's.id_schedule',
                's.day_name',
                's.time_start',
                's.time_end',
                's.quota',
                's.status'
            )
            ->where('p.m_poli_status', '1')
            ->where('s.status', 'AKTIF')
            ->where('s.day_name', $todayName)
            ->get();

        return response()->json([
            'success' => true,
            'today'   => $todayName,
            'data'    => $schedules
        ]);
    }
    public function registrasi_pasien_save_data_pasien(Request $request)
    {
        $request->validate([
            'master_patient_nik' => 'required|unique:master_patient,master_patient_nik',
            'master_patient_name' => 'required|string',
            'master_patient_jk' => 'required',
            'master_patient_tgl_lahir' => 'required|date',
        ]);

        try {
            // 1. Proses Pengolahan Foto Base64 dari Kamera
            $fileNamePath = null;

            if ($request->filled('foto_pasien_base64')) {
                $base64Image = $request->foto_pasien_base64;

                // Extract format data base64
                @list($type, $fileData) = explode(';', $base64Image);
                @list(, $fileData) = explode(',', $fileData);

                if ($fileData) {
                    // Tentukan lokasi direktori penyimpanan
                    $destinationFolder = public_path('profile/data_pasien/PA');

                    // Buat direktori jika belum tersedia
                    if (!File::exists($destinationFolder)) {
                        File::makeDirectory($destinationFolder, 0755, true);
                    }

                    // Generate nama file sesuai format
                    $dateStr = date('Y-m-d');
                    $timeStr = date('H.i.s');
                    $hash = Str::random(16);
                    $fileName = "WhatsApp Image {$dateStr} at {$timeStr}_{$hash}.jpeg";

                    // Simpan gambar fisik ke folder
                    File::put($destinationFolder . '/' . $fileName, base64_decode($fileData));

                    // Simpan relatif path untuk dimasukkan ke database
                    $fileNamePath = 'profile/data_pasien/PA/' . $fileName;
                }
            }

            // 2. Generate Kode Pasien Otomatis (Contoh: RM-202609001)
            $latestId = DB::table('master_patient')->max('id_master_patient') + 1;
            $generatedCode = 'RM-' . date('Ym') . sprintf('%04d', $latestId);

            // 3. Simpan ke Database
            $idPasien = DB::table('master_patient')->insertGetId([
                'master_patient_code' => $generatedCode,
                'master_patient_nik' => $request->master_patient_nik,
                'master_patient_name' => $request->master_patient_name,
                'master_patient_jk' => $request->master_patient_jk,
                'master_patient_tgl_lahir' => $request->master_patient_tgl_lahir,
                'master_patient_tempat_lahir' => $request->master_patient_tempat_lahir ?? '-',
                'master_patient_agama' => $request->master_patient_agama ?? '-',
                'master_patient_no_hp' => $request->master_patient_no_hp,
                'master_patient_email' => $request->master_patient_email,
                'master_patient_alamat' => $request->master_patient_alamat,
                'master_patient_foto' => $fileNamePath, // Path foto yang berhasil disimpan
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pasien baru berhasil didaftarkan.',
                'id_master_patient' => $idPasien,
                'master_patient_code' => $generatedCode,
                'foto_path' => $fileNamePath
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
    public function savePemeriksaanLayanan(Request $request)
    {
        $request->validate([
            'id_master_patient' => 'required',
            'tujuan_layanan' => 'required',
        ]);

        try {
            // Logika simpan pendaftaran (Contoh ke tabel pendaftaran / rekam medis)
            // $pendaftaran = Pendaftaran::create([
            //     'id_master_patient' => $request->id_master_patient,
            //     'jenis_penjamin'    => $request->jenis_penjamin,
            //     'nama_perusahaan'   => $request->nama_perusahaan,
            //     'tujuan_layanan'    => $request->tujuan_layanan,
            //     'poli_id'           => $request->poli_id,
            //     'dokter_id'         => $request->dokter_id ?? $request->dokter_igd_id,
            //     'triase_level'      => $request->triase_level,
            //     'pengantar_nama'    => $request->pengantar_nama,
            //     'td'                => $request->td,
            //     'suhu'              => $request->suhu,
            //     'nadi'              => $request->nadi,
            //     'respirasi'         => $request->respirasi,
            //     'keluhan_utama'     => $request->keluhan_utama,
            // ]);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran layanan medis berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    public function registrasi_pasien_choose_data_que(Request $request)
    {
        return 123;
    }
    // DATA REGISTRASI
    public function data_registrasi($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            // Data tidak lagi dipanggil di sini karena sudah menggunakan AJAX Server-Side DataTables
            return view('application.pelayanan.list-pasien-registrasi', [
                'akses' => $akses,
                'code' => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function getSpecimenBarcodeList($registrasi_id)
    {
        // Ambil data transaksi detail & nama pemeriksaan/spesimen
        $items = DB::table('medical_registrasi as reg')
            ->join('medical_transaksi as t', 't.registrasi_id', '=', 'reg.id')
            ->join('medical_transaksi_detail as td', 'td.transaksi_id', '=', 't.id')
            ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->where('reg.id', $registrasi_id)
            ->select('td.id as detail_id', 'mp.nama_layanan as specimen', 'td.no_pemeriksaan as barcode', 'reg.no_registrasi')
            ->get();

        if ($items->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Data spesimen tidak ditemukan']);
        }

        return response()->json(['success' => true, 'data' => $items]);
    }
    public function data_registrasi_data_table(Request $request)
    {
        // 1. Base Query
        $query = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'p.id', '=', 'reg.pasien_id')
            ->leftJoin('medical_transaksi as t', 't.registrasi_id', '=', 'reg.id')
            ->leftJoin('medical_sub_penjamin as sp', 'sp.id', '=', 'reg.sub_penjamin_id')
            ->leftJoin('user_mains as u', 'u.userid', '=', 'reg.user_id')
            ->select([
                'reg.id as registrasi_id',
                'reg.no_registrasi',
                'reg.tanggal_registrasi',
                'reg.dokter',
                'reg.janji_hasil',
                'reg.metode_pengiriman',
                'reg.is_cito',
                'p.title',
                'p.nama as nama_pasien',
                'p.pid',
                'sp.nama_sub_penjamin as agreement',
                'u.username as petugas',
                't.id as transaksi_id',
                't.total_tagihan',
                't.status_pembayaran'
            ]);

        // Filter 1: Tanggal Awal & Tanggal Akhir
        $tglAwal = $request->input('tgl1');
        $tglAkhir = $request->input('tgl2');

        if ($tglAwal && $tglAkhir) {
            $query->whereBetween('reg.tanggal_registrasi', [
                $tglAwal . ' 00:00:00',
                $tglAkhir . ' 23:59:59'
            ]);
        }

        // Filter 2: Dokter
        if ($dokter = $request->input('dokter')) {
            $query->where('reg.dokter', $dokter);
        }

        // Filter 3: Kelompok Pelanggan / Penjamin
        if ($penjamin = $request->input('penjamin')) {
            $query->where('sp.nama_sub_penjamin', 'like', "%{$penjamin}%");
        }

        // Filter 4: Filter Spesifik Pemeriksaan
        if ($pemeriksaan = $request->input('pemeriksaan')) {
            $query->whereExists(function ($sub) use ($pemeriksaan) {
                $sub->select(DB::raw(1))
                    ->from('medical_transaksi_detail as td_sub')
                    ->join('medical_master_pemeriksaan as mp_sub', 'td_sub.master_pemeriksaan_id', '=', 'mp_sub.id')
                    ->whereColumn('td_sub.transaksi_id', 't.id')
                    ->where('mp_sub.id', $pemeriksaan);
            });
        }

        // Total data awal
        $totalData = $query->count();

        // 2. Global Search & Input No Reg / Nama
        $searchValue = $request->input('search_custom') ?? $request->input('search.value');
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('reg.no_registrasi', 'like', "%{$searchValue}%")
                    ->orWhere('p.nama', 'like', "%{$searchValue}%")
                    ->orWhere('p.pid', 'like', "%{$searchValue}%")
                    ->orWhere('reg.dokter', 'like', "%{$searchValue}%");
            });
        }

        $totalFiltered = $query->count();

        // 3. Pagination & Ordering
        $start  = $request->input('start', 0);
        $length = $request->input('length', 10);

        $data = $query->offset($start)
            ->limit($length)
            ->orderBy('reg.tanggal_registrasi', 'desc')
            ->get();

        // Fetch List Pemeriksaan
        $transaksiIds = $data->pluck('transaksi_id')->filter()->unique();

        $pemeriksaanData = DB::table('medical_transaksi_detail as td')
            ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->whereIn('td.transaksi_id', $transaksiIds)
            ->select('td.transaksi_id', 'mp.nama_layanan')
            ->get()
            ->groupBy('transaksi_id');

        // 4. Formatting Output JSON
        $formattedData = [];
        $no = $start + 1;

        foreach ($data as $item) {
            // -- Kolom Aksi --
            $actionBtn = '<div class="dropdown text-center">
                            <button class="btn btn-sm text-white" type="button" data-bs-toggle="dropdown" style="background-color: #ff9800; height: 100%; min-height: 40px;">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu shadow-sm">
                                <li><a class="dropdown-item button-data-history-pasien" href="#" data-code="' . e($item->registrasi_id) . '">Riwayat Pasien</a></li>
                                <li><a class="dropdown-item" href="/pembayaran/nota/' . e($item->transaksi_id) . '" target="_blank">Cetak Struk</a></li>
                                <li><a class="dropdown-item btn-modal-barcode" href="#" data-regid="' . e($item->registrasi_id) . '" data-transid="' . e($item->transaksi_id) . '"><i class="fas fa-barcode me-1"></i> Cetak Barcode</a></li>
                            </ul>
                          </div>';

            // -- Badge Petugas --
            $petugasBadge = $item->petugas
                ? '<span class="badge bg-secondary text-white px-2 py-1" style="font-size: 0.7rem; border-radius: 4px;">' . e($item->petugas) . '</span>'
                : '<span class="badge bg-secondary text-white px-2 py-1" style="font-size: 0.7rem; border-radius: 4px;">Sistem</span>';

            $namaHtml = '<div class="text-start">
                            <div class="fw-bold text-dark" style="font-size: 0.85rem;">' . e($item->title) . ' ' . e($item->nama_pasien) . '</div>
                            <div class="mt-1">' . $petugasBadge . '</div>
                            <div class="mt-1 bg-secondary text-white d-inline-block px-2 py-1" style="font-size: 0.7rem; border-radius: 4px;">
                                ' . date('d-m-Y H:i', strtotime($item->tanggal_registrasi)) . '
                            </div>
                         </div>';

            // -- Badge CITO --
            $citoBadge = $item->is_cito == 1
                ? '<div class="mb-1"><span class="badge bg-danger text-white shadow-sm" style="font-size: 0.65rem;"><i class="fas fa-exclamation-triangle me-1"></i>CITO</span></div>'
                : '<div class="mb-1"><span class="badge bg-info text-white shadow-sm" style="font-size: 0.65rem;">NORMAL</span></div>';

            $noRegHtml = '<div class="text-start">' . $citoBadge . '
                            <div class="fw-bold text-dark" style="font-size: 0.85rem;">' . e($item->no_registrasi) . '</div>
                            <div class="fw-bold" style="font-size: 0.85rem; color: #800000;">' . e($item->pid) . '</div>
                          </div>';

            // -- Kolom Daftar Pemeriksaan --
            $pemeriksaanHtml = '<div class="text-dark" style="font-size: 0.85rem;">';
            if (isset($pemeriksaanData[$item->transaksi_id])) {
                foreach ($pemeriksaanData[$item->transaksi_id] as $l) {
                    $pemeriksaanHtml .= '<div class="mb-1">' . e($l->nama_layanan) . '</div>';
                }
            } else {
                $pemeriksaanHtml .= '-';
            }
            $pemeriksaanHtml .= '</div>';

            // -- Kolom Pengiriman Hasil --
            $pengirimanHtml = '<div class="d-flex flex-column gap-1 align-items-start">';
            if (!empty($item->metode_pengiriman)) {
                $metodeArray = json_decode($item->metode_pengiriman, true);
                if (is_array($metodeArray)) {
                    foreach ($metodeArray as $metode) {
                        if ($metode == 'whatsapp') {
                            $pengirimanHtml .= '<button class="btn btn-sm text-white fw-bold py-1 px-2 w-100 text-start" style="font-size: 0.7rem; background-color: #25D366; border:none;"><i class="fab fa-whatsapp me-1"></i> WHATSAPP</button>';
                        } elseif ($metode == 'email') {
                            $pengirimanHtml .= '<button class="btn btn-sm text-white fw-bold py-1 px-2 w-100 text-start" style="font-size: 0.7rem; background-color: #EA4335; border:none;"><i class="fas fa-envelope me-1"></i> EMAIL</button>';
                        } elseif ($metode == 'satusehat') {
                            $pengirimanHtml .= '<button class="btn btn-sm text-white fw-bold py-1 px-2 w-100 text-start" style="font-size: 0.7rem; background-color: #00BFA6; border:none;"><i class="fas fa-heartbeat me-1"></i> SATU SEHAT</button>';
                        } elseif ($metode == 'cetak_fisik') {
                            $pengirimanHtml .= '<button class="btn btn-sm text-white fw-bold py-1 px-2 w-100 text-start" style="font-size: 0.7rem; background-color: #6c757d; border:none;"><i class="fas fa-print me-1"></i> CETAK FISIK</button>';
                        }
                    }
                }
            } else {
                $pengirimanHtml .= '<button class="btn btn-info btn-sm text-white fw-bold py-1 px-2" style="font-size: 0.7rem; background-color: #00a8ff; border:none;">AMBIL SENDIRI</button>';
            }
            $pengirimanHtml .= '</div>';

            // -- Badge Pembayaran --
            $statusBayar = strtoupper($item->status_pembayaran ?? 'LUNAS');
            $pembayaranBadge = $statusBayar === 'LUNAS'
                ? '<div class="mt-1"><span class="badge bg-success text-white shadow-sm" style="font-size: 0.65rem;"><i class="fas fa-check-circle me-1"></i>LUNAS</span></div>'
                : '<div class="mt-1"><span class="badge bg-warning text-dark shadow-sm" style="font-size: 0.65rem;"><i class="fas fa-clock me-1"></i>BELUM LUNAS</span></div>';

            $totalTagihanHtml = '<div class="text-end">
                                    <div class="fw-bold text-dark" style="font-size: 0.85rem;">' . number_format($item->total_tagihan, 0, ',', '.') . '</div>
                                    ' . $pembayaranBadge . '
                                 </div>';

            $formattedData[] = [
                'action'       => $actionBtn,
                'no'           => $no++,
                'no_reg'       => $noRegHtml,
                'nama'         => $namaHtml,
                'agreement'    => '<div class="text-primary">' . e($item->agreement ?? 'UMUM') . '</div>',
                'dokter'       => '<div class="text-dark">' . e($item->dokter ?? '-') . '</div>',
                'janji_hasil'  => '<div class="text-dark">' . ($item->janji_hasil ? date('d-m-Y H:i', strtotime($item->janji_hasil)) : '-') . '</div>',
                'pemeriksaan'  => $pemeriksaanHtml,
                'pengiriman'   => $pengirimanHtml,
                'total'        => $totalTagihanHtml
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $formattedData
        ]);
    }
    public function data_verifikasi_registrasi_table(Request $request)
    {
        // 1. Base Query
        $query = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'p.id', '=', 'reg.pasien_id')
            ->leftJoin('medical_transaksi as t', 't.registrasi_id', '=', 'reg.id')
            ->leftJoin('medical_sub_penjamin as sp', 'sp.id', '=', 'reg.sub_penjamin_id')
            ->leftJoin('user_mains as u', 'u.userid', '=', 'reg.user_id')
            ->select([
                'reg.id as registrasi_id',
                'reg.no_registrasi',
                'reg.tanggal_registrasi',
                'reg.dokter',
                'reg.janji_hasil',
                'reg.metode_pengiriman',
                'reg.is_cito',
                'reg.status_kunjungan', // Status Batal/Selesai
                'p.title',
                'p.nama as nama_pasien',
                'p.pid',
                'sp.nama_sub_penjamin as agreement',
                'u.username as petugas',
                't.id as transaksi_id',
                't.total_tagihan',
                't.status_pembayaran' // Status Lunas/Refund/Batal
            ]);

        // Filter 1: Tanggal Awal & Tanggal Akhir
        $tglAwal = $request->input('tgl1');
        $tglAkhir = $request->input('tgl2');

        if ($tglAwal && $tglAkhir) {
            $query->whereBetween('reg.tanggal_registrasi', [
                $tglAwal . ' 00:00:00',
                $tglAkhir . ' 23:59:59'
            ]);
        }

        // Filter 2: Dokter
        if ($dokter = $request->input('dokter')) {
            $query->where('reg.dokter', $dokter);
        }

        // Filter 3: Kelompok Pelanggan / Penjamin
        if ($penjamin = $request->input('penjamin')) {
            $query->where('sp.nama_sub_penjamin', 'like', "%{$penjamin}%");
        }

        // Filter 4: Pemeriksaan
        if ($pemeriksaan = $request->input('pemeriksaan')) {
            $query->whereExists(function ($sub) use ($pemeriksaan) {
                $sub->select(DB::raw(1))
                    ->from('medical_transaksi_detail as td_sub')
                    ->join('medical_master_pemeriksaan as mp_sub', 'td_sub.master_pemeriksaan_id', '=', 'mp_sub.id')
                    ->whereColumn('td_sub.transaksi_id', 't.id')
                    ->where('mp_sub.id', $pemeriksaan);
            });
        }

        $totalData = $query->count();

        // 2. Global Search
        $searchValue = $request->input('search_custom') ?? $request->input('search.value');
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('reg.no_registrasi', 'like', "%{$searchValue}%")
                    ->orWhere('p.nama', 'like', "%{$searchValue}%")
                    ->orWhere('p.pid', 'like', "%{$searchValue}%")
                    ->orWhere('reg.dokter', 'like', "%{$searchValue}%");
            });
        }

        $totalFiltered = $query->count();

        // 3. Pagination & Ordering (VARIABEL YANG SEMPAT HILANG)
        $start  = $request->input('start', 0);
        $length = $request->input('length', 10);

        $data = $query->offset($start)
            ->limit($length)
            ->orderBy('reg.tanggal_registrasi', 'desc')
            ->get();

        // Fetch List Pemeriksaan
        $transaksiIds = $data->pluck('transaksi_id')->filter()->unique();
        $pemeriksaanData = DB::table('medical_transaksi_detail as td')
            ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->whereIn('td.transaksi_id', $transaksiIds)
            ->select('td.transaksi_id', 'mp.nama_layanan')
            ->get()
            ->groupBy('transaksi_id');

        // 4. Formatting Output JSON
        $formattedData = [];
        $no = $start + 1;

        foreach ($data as $item) {
            // Cek apakah data ini BATAL
            $isBatal = ($item->status_kunjungan === 'BATAL');

            // -- KOLOM AKSI --
            if ($isBatal) {
                // Jika sudah batal, hilangkan tombol dropdown aksi, ganti dengan label
                $actionBtn = '<span class="badge bg-danger px-3 py-2"><i class="fas fa-ban me-1"></i>VOID</span>';
            } else {
                $actionBtn = '<div class="dropdown text-center">
                                <button class="btn btn-sm btn-light border text-secondary" type="button" data-bs-toggle="dropdown" style="height: 100%; min-height: 40px; border-radius: 6px;">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3 py-2 fs--1">
                                    <li>
                                        <button class="dropdown-item text-primary py-2 button-verifikasi-data" data-bs-toggle="modal" data-bs-target="#modal-registrasi" data-code="' . e($item->registrasi_id) . '">
                                            <i class="fas fa-user-shield me-2"></i> Verifikasi Data
                                        </button>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider my-1">
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger py-2 button-batal-registrasi" data-code="' . e($item->registrasi_id) . '">
                                            <i class="fas fa-ban me-2"></i> Pembatalan Registrasi
                                        </button>
                                    </li>
                                </ul>
                              </div>';
            }

            $petugasBadge = $item->petugas
                ? '<span class="badge bg-secondary text-white px-2 py-1" style="font-size: 0.7rem; border-radius: 4px;">' . e($item->petugas) . '</span>'
                : '<span class="badge bg-secondary text-white px-2 py-1" style="font-size: 0.7rem; border-radius: 4px;">Sistem</span>';

            $namaHtml = '<div class="text-start">
                            <div class="fw-bold text-dark" style="font-size: 0.85rem;">' . e($item->title) . ' ' . e($item->nama_pasien) . '</div>
                            <div class="mt-1">' . $petugasBadge . '</div>
                            <div class="mt-1 bg-secondary text-white d-inline-block px-2 py-1" style="font-size: 0.7rem; border-radius: 4px;">
                                ' . date('d-m-Y H:i', strtotime($item->tanggal_registrasi)) . '
                            </div>
                         </div>';

            // -- BADGE CITO & BATAL (Muncul di atas No Registrasi) --
            $citoBadge = $item->is_cito == 1
                ? '<span class="badge bg-danger text-white shadow-sm me-1" style="font-size: 0.65rem;"><i class="fas fa-exclamation-triangle me-1"></i>CITO</span>'
                : '';

            $batalBadge = $isBatal
                ? '<span class="badge bg-dark text-white shadow-sm" style="font-size: 0.65rem;"><i class="fas fa-times me-1"></i>DIBATALKAN</span>'
                : '';

            $noRegHtml = '<div class="text-start mb-1">' . $citoBadge . $batalBadge . '</div>
                          <div class="text-start">
                            <div class="fw-bold ' . ($isBatal ? 'text-decoration-line-through text-muted' : 'text-dark') . '" style="font-size: 0.85rem;">' . e($item->no_registrasi) . '</div>
                            <div class="fw-bold" style="font-size: 0.85rem; color: #800000;">' . e($item->pid) . '</div>
                          </div>';

            $pemeriksaanHtml = '<div class="text-start ' . ($isBatal ? 'text-decoration-line-through text-muted' : '') . '" style="font-size: 0.85rem; color: #444;">';
            if (isset($pemeriksaanData[$item->transaksi_id])) {
                foreach ($pemeriksaanData[$item->transaksi_id] as $l) {
                    $pemeriksaanHtml .= '<div class="mb-1">' . e($l->nama_layanan) . '</div>';
                }
            } else {
                $pemeriksaanHtml .= '-';
            }
            $pemeriksaanHtml .= '</div>';

            $pengirimanHtml = '<div class="d-flex flex-column gap-1 align-items-start">';
            if (!empty($item->metode_pengiriman)) {
                $metodeArray = json_decode($item->metode_pengiriman, true);
                if (is_array($metodeArray)) {
                    foreach ($metodeArray as $metode) {
                        if ($metode == 'whatsapp') $pengirimanHtml .= '<button class="btn btn-sm text-white fw-bold py-1 px-2 w-100 text-start" style="font-size: 0.7rem; background-color: #25D366; border:none;"><i class="fab fa-whatsapp me-1"></i> WHATSAPP</button>';
                        elseif ($metode == 'email') $pengirimanHtml .= '<button class="btn btn-sm text-white fw-bold py-1 px-2 w-100 text-start" style="font-size: 0.7rem; background-color: #EA4335; border:none;"><i class="fas fa-envelope me-1"></i> EMAIL</button>';
                        elseif ($metode == 'satusehat') $pengirimanHtml .= '<button class="btn btn-sm text-white fw-bold py-1 px-2 w-100 text-start" style="font-size: 0.7rem; background-color: #00BFA6; border:none;"><i class="fas fa-heartbeat me-1"></i> SATU SEHAT</button>';
                        elseif ($metode == 'cetak_fisik') $pengirimanHtml .= '<button class="btn btn-sm text-white fw-bold py-1 px-2 w-100 text-start" style="font-size: 0.7rem; background-color: #6c757d; border:none;"><i class="fas fa-print me-1"></i> CETAK FISIK</button>';
                    }
                }
            } else {
                $pengirimanHtml .= '<button class="btn btn-info btn-sm text-white fw-bold py-1 px-2" style="font-size: 0.7rem; background-color: #00a8ff; border:none;">AMBIL SENDIRI</button>';
            }
            $pengirimanHtml .= '</div>';

            // -- BADGE STATUS PEMBAYARAN & REFUND --
            $statusBayar = strtoupper($item->status_pembayaran ?? 'BELUM LUNAS');

            if ($statusBayar === 'BATAL') {
                $pembayaranBadge = '<div class="mt-1"><span class="badge bg-danger text-white shadow-sm" style="font-size: 0.65rem;"><i class="fas fa-times-circle me-1"></i>BATAL (VOID)</span></div>';
            } elseif ($statusBayar === 'REFUND') {
                $pembayaranBadge = '<div class="mt-1"><span class="badge bg-secondary text-white shadow-sm" style="font-size: 0.65rem;"><i class="fas fa-undo me-1"></i>RETUR DANA</span></div>';
            } elseif ($statusBayar === 'LUNAS') {
                $pembayaranBadge = '<div class="mt-1"><span class="badge bg-success text-white shadow-sm" style="font-size: 0.65rem;"><i class="fas fa-check-circle me-1"></i>LUNAS</span></div>';
            } else {
                $pembayaranBadge = '<div class="mt-1"><span class="badge bg-warning text-dark shadow-sm" style="font-size: 0.65rem;"><i class="fas fa-clock me-1"></i>BELUM LUNAS</span></div>';
            }

            $totalTagihanHtml = '<div class="text-end">
                                    <div class="fw-bold ' . ($isBatal ? 'text-decoration-line-through text-muted' : 'text-dark') . '" style="font-size: 0.85rem;">' . number_format($item->total_tagihan, 0, ',', '.') . '</div>
                                    ' . $pembayaranBadge . '
                                 </div>';

            $formattedData[] = [
                'action'       => $actionBtn,
                'no'           => $no++,
                'no_reg'       => $noRegHtml,
                'nama'         => $namaHtml,
                'agreement'    => '<div style="font-size: 0.85rem; color: #555;">' . e($item->agreement ?? 'UMUM') . '</div>',
                'dokter'       => '<div style="font-size: 0.85rem; color: #555;">' . e($item->dokter ?? '-') . '</div>',
                'janji_hasil'  => '<div style="font-size: 0.85rem; color: #555;">' . ($item->janji_hasil ? date('d-m-Y H:i', strtotime($item->janji_hasil)) : '-') . '</div>',
                'pemeriksaan'  => $pemeriksaanHtml,
                'pengiriman'   => $pengirimanHtml,
                'total'        => $totalTagihanHtml
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $formattedData
        ]);
    }
    public function getFilterOptions(Request $request)
    {
        $tglAwal = $request->input('tgl1', date('Y-m-d')) . ' 00:00:00';
        $tglAkhir = $request->input('tgl2', date('Y-m-d')) . ' 23:59:59';

        // 1. Ambil daftar Dokter unik di rentang tanggal tersebut
        $dokterList = DB::table('medical_registrasi')
            ->whereBetween('tanggal_registrasi', [$tglAwal, $tglAkhir])
            ->whereNotNull('dokter')
            ->where('dokter', '!=', '')
            ->distinct()
            ->pluck('dokter');

        // 2. Ambil daftar Penjamin / Sub Penjamin unik
        $penjaminList = DB::table('medical_registrasi as reg')
            ->join('medical_sub_penjamin as sp', 'sp.id', '=', 'reg.sub_penjamin_id')
            ->whereBetween('reg.tanggal_registrasi', [$tglAwal, $tglAkhir])
            ->distinct()
            ->pluck('sp.nama_sub_penjamin');

        // 3. Ambil daftar Pemeriksaan unik
        $pemeriksaanList = DB::table('medical_registrasi as reg')
            ->join('medical_transaksi as t', 't.registrasi_id', '=', 'reg.id')
            ->join('medical_transaksi_detail as td', 'td.transaksi_id', '=', 't.id')
            ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
            ->whereBetween('reg.tanggal_registrasi', [$tglAwal, $tglAkhir])
            ->select('mp.id', 'mp.nama_layanan')
            ->distinct()
            ->get();

        return response()->json([
            'success' => true,
            'dokter' => $dokterList,
            'penjamin' => $penjaminList,
            'pemeriksaan' => $pemeriksaanList
        ]);
    }
    public function data_registrasi_old($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('d_reg_order')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('t_pasien_cat', 't_pasien_cat.t_pasien_cat_code', '=', 'd_reg_order.t_pasien_cat_code')->get();
            return view('application.pelayanan.list-pasien-registrasi', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_registrasi_data_table_old(Request $request)
    {
        // 1. Base Query (Disesuaikan dengan skema master_patient)
        $query = DB::table('d_reg_order')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->leftJoin('t_pasien_cat', 't_pasien_cat.t_pasien_cat_code', '=', 'd_reg_order.t_pasien_cat_code')
            ->select([
                'd_reg_order.d_reg_order_code',
                'd_reg_order.d_reg_order_rm',
                'd_reg_order.d_reg_order_user',
                'd_reg_order.created_at',
                'master_patient.master_patient_name',
                'master_patient.master_patient_tempat_lahir',
                'master_patient.master_patient_tgl_lahir',
                'master_patient.master_patient_jk',
                't_pasien_cat.t_pasien_cat_name'
            ]);

        // Filter Rentang Tanggal jika diisi
        if ($request->filled('tgl1') && $request->filled('tgl2')) {
            $query->whereBetween('d_reg_order.d_reg_order_date', [$request->tgl1, $request->tgl2]);
        }

        // Total data sebelum filter
        $totalData = $query->count();

        // 2. Global Search (Live Search Input)
        if ($searchValue = $request->input('search.value')) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('d_reg_order.d_reg_order_code', 'like', "%{$searchValue}%")
                    ->orWhere('d_reg_order.d_reg_order_rm', 'like', "%{$searchValue}%")
                    ->orWhere('master_patient.master_patient_name', 'like', "%{$searchValue}%")
                    ->orWhere('master_patient.master_patient_nik', 'like', "%{$searchValue}%");
            });
        }

        $totalFiltered = $query->count();

        // 3. Pagination & Ordering
        $start  = $request->input('start', 0);
        $length = $request->input('length', 10);

        $data = $query->offset($start)
            ->limit($length)
            ->orderBy('d_reg_order.created_at', 'desc')
            ->get();

        // Fetch User Fullnames
        $userIds = $data->pluck('d_reg_order_user')->unique();
        $users = DB::table('user_mains')
            ->whereIn('userid', $userIds)
            ->pluck('fullname', 'userid');

        // Fetch Layanan
        $orderCodes = $data->pluck('d_reg_order_code');
        $layananData = DB::table('d_reg_order_list')
            ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'd_reg_order_list.t_layanan_cat_code')
            ->whereIn('d_reg_order_list.d_reg_order_code', $orderCodes)
            ->select('d_reg_order_list.d_reg_order_code', 't_layanan_cat.t_layanan_cat_name')
            ->get()
            ->groupBy('d_reg_order_code');

        // 4. Formatting Output JSON
        $formattedData = [];
        $no = $start + 1;

        foreach ($data as $item) {
            $userName = $users[$item->d_reg_order_user] ?? null;
            $initial  = strtoupper(substr($item->master_patient_name ?? 'P', 0, 1));

            // Format Badge Petugas
            $userBadge = $userName
                ? '<span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-semibold" style="font-size: 0.7rem;"><i class="fas fa-user-edit me-1"></i>' . e($userName) . '</span>'
                : '<span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-semibold" style="font-size: 0.7rem;"><i class="fas fa-user-slash me-1"></i>Unknown</span>';

            // Format List Layanan
            $layananHtml = '<div class="d-flex flex-column gap-1">';
            if (isset($layananData[$item->d_reg_order_code])) {
                foreach ($layananData[$item->d_reg_order_code] as $l) {
                    $layananHtml .= '<div class="layanan-pill"><i class="fas fa-stethoscope me-1"></i><strong>' . e($l->t_layanan_cat_name) . '</strong></div>';
                }
            }
            $layananHtml .= '</div>';

            // Badge Gender / JK
            $jkBadge = ($item->master_patient_jk == 'L' || strtolower($item->master_patient_jk) == 'laki-laki')
                ? '<span class="badge bg-primary-subtle text-primary ms-1" style="font-size:0.65rem;">L</span>'
                : '<span class="badge bg-danger-subtle text-danger ms-1" style="font-size:0.65rem;">P</span>';

            $formattedData[] = [
                'no' => $no++,
                'no_reg' => '<div>
                                <div class="fw-bold text-primary mb-1">' . e($item->d_reg_order_code) . '</div>
                                ' . $userBadge . '
                            </div>',
                'pasien' => '<div class="d-flex align-items-center">
                                <div class="avatar-patient me-2 flex-shrink-0">' . $initial . '</div>
                                <div>
                                    <div class="fw-bold text-body-highlight">' . e($item->master_patient_name) . ' ' . $jkBadge . '</div>
                                    <small class="text-muted" style="font-size: 0.75rem;">RM: ' . e($item->d_reg_order_rm) . '</small>
                                </div>
                            </div>',
                'ttl' => '<i class="fas fa-map-marker-alt text-danger me-1" style="font-size: 0.75rem;"></i>'
                    . e($item->master_patient_tempat_lahir ?? '-') . ', <br><span class="fw-semibold text-body">' . date('d/m/Y', strtotime($item->master_patient_tgl_lahir)) . '</span>',
                'kategori' => '<span class="badge bg-info text-white border border-info-subtle px-2 py-1 fw-bold"><i class="fas fa-id-card me-1"></i>' . e($item->t_pasien_cat_name ?? 'UMUM') . '</span>',
                'layanan' => $layananHtml,
                'created_at' => '<span class="badge bg-dark text-white border border-subtle fw-medium" style="font-size: 0.72rem;"><i class="far fa-clock me-1 text-muted"></i>' . date('d/m/Y H:i', strtotime($item->created_at)) . '</span>',
                'action' => '<div class="dropdown text-end">
                                <button class="btn btn-sm btn-light border border-subtle dropdown-toggle shadow-none" type="button" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v text-secondary"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border border-subtle">
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center gap-2 py-2 button-data-history-pasien" data-bs-toggle="modal" data-bs-target="#modal-registrasi" data-code="' . e($item->d_reg_order_rm) . '">
                                            <i class="fas fa-history text-primary"></i>
                                            <span class="fw-semibold">Riwayat Pasien</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>'
            ];
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $formattedData
        ]);
    }
    public function data_registrasi_history(Request $request)
    {
        $data = DB::table('d_reg_order')
            ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'd_reg_order.t_layanan_cat_code')
            ->where('d_reg_order.d_reg_order_rm', $request->code)->get();
        return view('application.pelayanan.data-registrasi.form-data-registrasi-pasien', ['data' => $data]);
    }
    public function data_registrasi_find_data(Request $request)
    {
        $data = DB::select("CALL get_pasien(?,?)", [$request->tgl1, $request->tgl2]);
        return view('application.pelayanan.list-pasien.data-table-list', ['data' => $data]);
    }
    public function data_registrasi_refresh_data(Request $request)
    {
        $auth = Auth::user()->access_cabang;
        $data = DB::select("CALL get_pasien_today(?)", [$auth]);
        return view('application.pelayanan.list-pasien.data-table-list', ['data' => $data]);
    }
    // VERIFIKASI DATA REGISTRASI
    public function menu_pelayanan_verifikasi_registrasi($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Mengambil data registrasi & pasien dari tabel medis baru
            $data = DB::table('medical_registrasi as reg')
                ->join('medical_patient as p', 'p.id', '=', 'reg.pasien_id')
                ->leftJoin('medical_sub_penjamin as sp', 'sp.id', '=', 'reg.sub_penjamin_id')
                ->leftJoin('user_mains as u', 'u.userid', '=', 'reg.user_id')
                ->leftJoin('medical_transaksi as t', 't.registrasi_id', '=', 'reg.id')
                ->select([
                    'reg.id as registrasi_id',
                    'reg.no_registrasi',
                    'reg.tanggal_registrasi',
                    'reg.dokter',
                    'reg.is_cito',
                    'p.id as pasien_id',
                    'p.pid',
                    'p.title',
                    'p.nama as nama_pasien',
                    'p.jk',
                    'p.tempat_lahir', // <-- Diperbaiki sesuai schema
                    'p.tgl_lahir',
                    'sp.nama_sub_penjamin as agreement',
                    'u.username as petugas',
                    't.id as transaksi_id'
                ])
                ->orderBy('reg.id', 'DESC')
                ->get();

            return view('application.pelayanan.menu-verifikasi-data-registrasi', [
                'data' => $data,
                'akses' => $akses,
                'code' => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_pelayanan_verifikasi_registrasi_old($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'd_reg_order.t_layanan_cat_code')
                ->join('t_pasien_cat', 't_pasien_cat.t_pasien_cat_code', '=', 'd_reg_order.t_pasien_cat_code')
                ->where('d_reg_order.d_reg_order_cabang', Auth::user()->access_cabang)->orderBy('id_d_reg_order', 'DESC')
                ->get();
            return view('application.pelayanan.menu-verifikasi-data-registrasi', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_pelayanan_verifikasi_registrasi_data(Request $request)
    {
        // 1. Ambil data Registrasi dan Pasien
        $pasien = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'p.id', '=', 'reg.pasien_id')
            ->select(
                'reg.id as registrasi_id',
                'reg.no_registrasi',
                'p.id as pasien_id',
                'p.pid as master_patient_norm',
                'p.nama as master_patient_name',
                'p.jk as master_patient_jk',
                'p.tgl_lahir as master_patient_tgl_lahir',
                'p.tempat_lahir as master_patient_tempat_lahir',
                'p.no_hp as master_patient_no_hp',
                'p.agama as master_patient_agama',
                'p.email as master_patient_email',
                'p.alamat as master_patient_alamat',
                'p.no_id as master_patient_nik',
                'p.foto as master_patient_profile' // Base64 foto
            )
            ->where('reg.id', $request->code)
            ->first();

        // 2. Ambil List Pemeriksaan/Layanan berdasarkan ID Registrasi
        $data = DB::table('medical_transaksi as t')
            ->join('medical_transaksi_detail as td', 'td.transaksi_id', '=', 't.id')
            ->join('medical_master_pemeriksaan as mp', 'mp.id', '=', 'td.master_pemeriksaan_id')
            ->select(
                'td.id as detail_id',
                'mp.id as pemeriksaan_id',
                'mp.nama_layanan as t_layanan_cat_name'
            )
            ->where('t.registrasi_id', $request->code)
            ->get();

        return view('application.pelayanan.verifikasi-registrasi.form-verifikasi-data', [
            'pasien' => $pasien,
            'data'   => $data
        ]);
    }
    public function menu_pelayanan_verifikasi_registrasi_data_detail(Request $request)
    {
        $cek = DB::table('d_reg_order_list')
            ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'd_reg_order_list.t_layanan_cat_code')
            ->where('d_reg_order_list.d_reg_order_list_code', $request->code)->first();
        if ($cek->t_layanan_cat_name == 'POLIKLINIK') {
            $diagnosa = DB::table('diag_poli_fisik_umum_d')
                ->join('diag_poli_fisik_umum', 'diag_poli_fisik_umum.diag_poli_fisik_umum_code', '=', 'diag_poli_fisik_umum_d.diag_poli_fisik_umum_code')
                ->where('diag_poli_fisik_umum_d.d_reg_order_poli_code', $request->code)->get();
            $odontogram = DB::table('diag_poli_gigi_odon')
                ->where('d_reg_order_poli_code', $request->code)->get();
            return view('application.pelayanan.verifikasi-registrasi.form-detail-poliklinik', [
                'diagnosa' => $diagnosa,
                'odontogram' => $odontogram
            ]);
        } elseif ($cek->t_layanan_cat_name == 'RADIOLOGI') {
            return 'belum diset';
        } else {
            return 'belum ditemukan';
        }
    }
    // Contoh penanganan di Controller
    public function menu_pelayanan_verifikasi_pembatalan_registrasi(Request $request)
    {
        $registrasiId = $request->code;
        $alasan = $request->alasan;

        // 1. Update Tabel Registrasi
        DB::table('medical_registrasi')->where('id', $registrasiId)->update([
            'status_kunjungan' => 'BATAL',
            'alasan_batal' => $alasan,
            'dibatalkan_oleh' => Auth::user()->username, // Petugas yang membatalkan
            'waktu_batal' => now(),
        ]);

        // 2. Update Status Transaksi menjadi BATAL
        DB::table('medical_transaksi')->where('registrasi_id', $registrasiId)->update([
            'status_pembayaran' => 'BATAL'
        ]);

        // 3. Update Status Detail Transaksi (Pemeriksaan) menjadi BATAL
        $transaksi = DB::table('medical_transaksi')->where('registrasi_id', $registrasiId)->first();
        if ($transaksi) {
            DB::table('medical_transaksi_detail')->where('transaksi_id', $transaksi->id)->update([
                'status_pemeriksaan' => 'BATAL'
            ]);
        }

        return response()->json(['message' => 'Registrasi berhasil dibatalkan']);
    }
    public function menu_pelayanan_verifikasi_registrasi_data_save(Request $request)
    {
        return 123;
    }
    // SUPERVISIOR PELAYANAN
    public function menu_pelayanan_supervisior($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Ambil daftar Kelompok Pelanggan / Penjamin
            $kategori = DB::table('medical_sub_penjamin')->get();

            // Ambil daftar Layanan Pemeriksaan (bisa di-group jika terlalu banyak)
            $layanan = DB::table('medical_master_pemeriksaan')
                ->where('is_active', 1) // Asumsi ada flag aktif, jika tidak, hapus baris ini
                ->get();

            return view('application.pelayanan.menu-supervisior-pelayanan', [
                'akses'    => $akses,
                'layanan'  => $layanan,
                'kategori' => $kategori,
                'code'     => $id,
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_pelayanan_supervisior_find(Request $request)
    {
        try {
            $kategori = $request->kategori; // ID sub_penjamin
            $layanan  = $request->layanan;  // ID master_pemeriksaan / 'all'
            $rentangTgl = $request->tanggal; // Format range date dari flatpickr (YYYY-MM-DD to YYYY-MM-DD)

            $query = DB::table('medical_registrasi as reg')
                ->join('medical_patient as p', 'p.id', '=', 'reg.pasien_id')
                ->leftJoin('medical_sub_penjamin as sp', 'sp.id', '=', 'reg.sub_penjamin_id')
                ->leftJoin('user_mains as u', 'u.userid', '=', 'reg.user_id')
                ->leftJoin('medical_transaksi as t', 't.registrasi_id', '=', 'reg.id')
                ->select([
                    'reg.id as registrasi_id',
                    'reg.no_registrasi',
                    'reg.tanggal_registrasi',
                    'reg.dokter',
                    'reg.is_cito',
                    'reg.status_kunjungan',
                    'reg.metode_pengiriman', // Ditambahkan
                    'reg.bahasa_hasil',      // Ditambahkan
                    'p.title',
                    'p.nama as nama_pasien',
                    'p.pid',
                    'p.tempat_lahir',
                    'p.tgl_lahir',
                    'sp.nama_sub_penjamin as agreement',
                    'u.username as petugas',
                    't.id as transaksi_id'
                ]);

            // Filter Kategori (Sub Penjamin) jika dipilih
            if (!empty($kategori)) {
                $query->where('reg.sub_penjamin_id', $kategori);
            }

            // Filter Rentang Tanggal
            if (!empty($rentangTgl) && strlen($rentangTgl) >= 23) {
                $tgl1 = trim(substr($rentangTgl, 0, 10)) . ' 00:00:00';
                $tgl2 = trim(substr($rentangTgl, 14, 10)) . ' 23:59:59';
                $query->whereBetween('reg.tanggal_registrasi', [$tgl1, $tgl2]);
            }

            // Filter Berdasarkan Jenis Layanan Pemeriksaan tertentu (jika bukan 'all')
            if (!empty($layanan) && $layanan !== 'all') {
                $query->whereExists(function ($sub) use ($layanan) {
                    $sub->select(DB::raw(1))
                        ->from('medical_transaksi_detail as td_sub')
                        ->whereColumn('td_sub.transaksi_id', 't.id')
                        ->where('td_sub.master_pemeriksaan_id', $layanan);
                });
            }

            $data = $query->orderBy('reg.tanggal_registrasi', 'DESC')->get();

            return view('application.pelayanan.menu-supervisior.data-pencarian-pasien', [
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function menu_pelayanan_supervisior_detail_pasien(Request $request)
    {
        // Mengambil data registrasi dan pasien berdasarkan ID registrasi
        $registrasiId = $request->code;

        $pasien = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'p.id', '=', 'reg.pasien_id')
            ->leftJoin('medical_sub_penjamin as sp', 'sp.id', '=', 'reg.sub_penjamin_id')
            ->select(
                'reg.id as registrasi_id',
                'reg.no_registrasi',
                'reg.tanggal_registrasi',
                'reg.dokter',
                'reg.status_kunjungan',
                'reg.alasan_batal',
                'p.id as pasien_id',
                'p.pid',
                'p.nama as nama_pasien',
                'p.jk',
                'p.tempat_lahir',
                'p.tgl_lahir',
                'p.no_hp',
                'p.agama',
                'p.alamat',
                'sp.nama_sub_penjamin as agreement'
            )
            ->where('reg.id', $registrasiId)
            ->first();

        // Ambil transaksi terkait
        $transaksi = DB::table('medical_transaksi')->where('registrasi_id', $registrasiId)->first();

        // Ambil daftar pemeriksaan (detail transaksi)
        $pemeriksaanList = [];
        if ($transaksi) {
            $pemeriksaanList = DB::table('medical_transaksi_detail as td')
                ->join('medical_master_pemeriksaan as mp', 'mp.id', '=', 'td.master_pemeriksaan_id')
                ->select('td.id as detail_id', 'td.no_pemeriksaan', 'mp.id as master_id', 'mp.nama_layanan', 'td.harga_akhir', 'td.status_pemeriksaan')
                ->where('td.transaksi_id', $transaksi->id)
                ->get();
        }

        // Ambil master seluruh pemeriksaan untuk opsi tambah pemeriksaan baru
        $masterPemeriksaan = DB::table('medical_master_pemeriksaan')->get();

        return view('application.pelayanan.menu-supervisior.detail-pasien', [
            'pasien' => $pasien,
            'transaksi' => $transaksi,
            'pemeriksaanList' => $pemeriksaanList,
            'masterPemeriksaan' => $masterPemeriksaan
        ]);
    }
    // 1. Update Identitas Pasien
    public function menu_pelayanan_supervisior_update_pasien(Request $request)
    {
        DB::table('medical_patient')->where('id', $request->pasien_id)->update([
            'nama'         => $request->nama_pasien,
            'jk'           => $request->jk,
            'no_hp'        => $request->no_hp,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir'    => $request->tgl_lahir,
            'alamat'       => $request->alamat,
            'updated_at'   => now(),
        ]);

        DB::table('medical_registrasi')->where('id', $request->registrasi_id)->update([
            'dokter'       => $request->dokter,
            'updated_at'   => now(),
        ]);

        return response()->json(['success' => true]);
    }

    // 1. Tambah Item Pemeriksaan
    public function menu_pelayanan_supervisior_tambah_pemeriksaan(Request $request)
    {
        $transaksiId = $request->transaksi_id;
        $masterId = $request->master_pemeriksaan_id;

        $master = DB::table('medical_master_pemeriksaan')->where('id', $masterId)->first();
        if (!$master) return response()->json(['success' => false], 404);

        // Ambil data transaksi saat ini untuk mengetahui total_bayar
        $transaksi = DB::table('medical_transaksi')->where('id', $transaksiId)->first();
        if (!$transaksi) return response()->json(['success' => false], 404);

        // Generate No Pemeriksaan sederhana
        $noPemeriksaan = 'LAB' . date('ymd') . '' . rand(1000, 9999);

        DB::table('medical_transaksi_detail')->insert([
            'transaksi_id'          => $transaksiId,
            'master_pemeriksaan_id' => $masterId,
            'no_pemeriksaan'        => $noPemeriksaan,
            'harga_dasar'           => $master->harga ?? 0,
            'harga_akhir'           => $master->harga ?? 0,
            'status_pemeriksaan'    => 'MENUNGGU',
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        // Hitung ulang total tagihan transaksi
        $totalBaru = DB::table('medical_transaksi_detail')->where('transaksi_id', $transaksiId)->sum('harga_akhir');

        // Hitung sisa tagihan secara aman menggunakan nilai variabel PHP ($transaksi->total_bayar)
        $sisaTagihanBaru = max(0, $totalBaru - $transaksi->total_bayar);

        DB::table('medical_transaksi')->where('id', $transaksiId)->update([
            'total_tagihan' => $totalBaru,
            'sisa_tagihan'  => $sisaTagihanBaru,
            'updated_at'    => now()
        ]);

        return response()->json(['success' => true]);
    }

    // 2. Hapus Item Pemeriksaan
    public function menu_pelayanan_supervisior_hapus_pemeriksaan(Request $request)
    {
        $detailId = $request->detail_id;
        $detail = DB::table('medical_transaksi_detail')->where('id', $detailId)->first();

        if ($detail) {
            $transaksiId = $detail->transaksi_id;

            // Ambil data transaksi saat ini untuk mengetahui total_bayar
            $transaksi = DB::table('medical_transaksi')->where('id', $transaksiId)->first();

            DB::table('medical_transaksi_detail')->where('id', $detailId)->delete();

            // Hitung ulang total tagihan transaksi
            $totalBaru = DB::table('medical_transaksi_detail')->where('transaksi_id', $transaksiId)->sum('harga_akhir');

            // Hitung sisa tagihan secara aman menggunakan nilai variabel PHP
            $sisaTagihanBaru = $transaksi ? max(0, $totalBaru - $transaksi->total_bayar) : 0;

            DB::table('medical_transaksi')->where('id', $transaksiId)->update([
                'total_tagihan' => $totalBaru,
                'sisa_tagihan'  => $sisaTagihanBaru,
                'updated_at'    => now()
            ]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    // 4. Void / Batalkan Registrasi Total
    public function menu_pelayanan_supervisior_void_registrasi(Request $request)
    {
        $regId = $request->code;
        $alasan = $request->alasan;

        DB::table('medical_registrasi')->where('id', $regId)->update([
            'status_kunjungan' => 'BATAL',
            'alasan_batal'     => $alasan,
            'waktu_batal'      => now(),
            'updated_at'       => now()
        ]);

        $transaksi = DB::table('medical_transaksi')->where('registrasi_id', $regId)->first();
        if ($transaksi) {
            DB::table('medical_transaksi')->where('id', $transaksi->id)->update([
                'status_pembayaran' => 'BATAL',
                'updated_at'        => now()
            ]);
            DB::table('medical_transaksi_detail')->where('transaksi_id', $transaksi->id)->update([
                'status_pemeriksaan' => 'BATAL',
                'updated_at'         => now()
            ]);
        }

        return response()->json(['success' => true]);
    }
}
