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
    // REGISTRASI POLI
    public function poliklinik_register_poli($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $poliklinik = DB::table('m_poli')->get();
            return view('application.poliklinik.registrasi-poliklinik', ['poliklinik' => $poliklinik, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function poliklinik_register_poli_searchPatient(Request $request)
    {
        $keyword = $request->query('keyword');

        if (!$keyword) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kata kunci pencarian tidak boleh kosong.'
            ], 400);
        }

        $patient = DB::table('master_patient')
            ->where('master_patient_nik', $keyword)
            ->orWhere('master_patient_code', $keyword)
            ->first();

        if ($patient) {
            return response()->json([
                'status' => 'success',
                'data'   => [
                    'id'           => $patient->id_master_patient,
                    'code'         => $patient->master_patient_code,
                    'nik'          => $patient->master_patient_nik,
                    'name'         => $patient->master_patient_name,
                    'jk'           => $patient->master_patient_jk,
                    'tgl_lahir'    => $patient->master_patient_tgl_lahir,
                    'tempat_lahir' => $patient->master_patient_tempat_lahir,
                    'agama'        => $patient->master_patient_agama,
                    'no_hp'        => $patient->master_patient_no_hp ?? '',
                    'email'        => $patient->master_patient_email ?? '',
                    'alamat'       => $patient->master_patient_alamat ?? '',
                ]
            ]);
        }

        return response()->json([
            'status'  => 'not_found',
            'message' => 'Data pasien tidak ditemukan.'
        ], 404);
    }
    // 3. Get Jadwal Dokter berdasarkan Poliklinik dan Tanggal Berobat
    public function poliklinik_register_poli_getAvailableDoctors(Request $request)
    {
        $poliCode = $request->query('m_poli_code');
        $date     = $request->query('date');

        if (!$poliCode || !$date) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Poliklinik dan tanggal harus diisi.'
            ], 400);
        }

        $dayName = Carbon::parse($date)->locale('id')->isoFormat('dddd');

        $schedules = DB::table('m_poli_doctor_schedule as s')
            ->join('m_poli_doctor as pd', 's.m_poli_doctor_id', '=', 'pd.id')
            ->join('master_doctor as d', 'pd.master_doctor_code', '=', 'd.master_doctor_code')
            ->select(
                // Ganti 's.id' dengan nama primary key asli tabel schedule Anda
                // Contoh jika kolomnya id_schedule:
                's.id_schedule as id_schedule',
                's.m_poli_code',
                's.day_name',
                's.time_start',
                's.time_end',
                's.quota',
                'd.master_doctor_code',
                'd.master_doctor_name',
                'd.master_doctor_title_f',
                'd.master_doctor_title_e'
            )
            ->where('s.m_poli_code', $poliCode)
            ->where('s.day_name', ucfirst($dayName))
            ->get();

        foreach ($schedules as $sch) {
            $sch->quota_used = DB::table('t_registrations')
                ->where('schedule_id', $sch->id_schedule)
                ->where('visit_date', $date)
                ->where('status', '!=', 'BATAL')
                ->count();
        }

        return response()->json([
            'status' => 'success',
            'data'   => $schedules
        ]);
    }

    // 4. Simpan Pendaftaran
    public function poliklinik_register_poli_store(Request $request)
    {
        $request->validate([
            'visit_date'                 => 'required|date',
            'm_poli_code'                => 'required',
            'schedule_id'                => 'required',
            'payment_method'             => 'required',
            'master_patient_nik'         => 'required',
            'master_patient_name'        => 'required',
            'master_patient_jk'          => 'required',
            'master_patient_tgl_lahir'   => 'required|date',
            'master_patient_tempat_lahir' => 'required',
            'master_patient_agama'       => 'required',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $patientId = $request->id_master_patient;

                // Pasien Baru: Simpan ke master_patient & Generate Kode RM
                if ($request->is_new_patient == "1" || !$patientId) {
                    $lastId = DB::table('master_patient')->max('id_master_patient') + 1;
                    $patientCode = 'RM' . str_pad($lastId, 6, '0', STR_PAD_LEFT);

                    $patientId = DB::table('master_patient')->insertGetId([
                        'master_patient_code'         => $patientCode,
                        'master_patient_nik'          => $request->master_patient_nik,
                        'master_patient_name'         => $request->master_patient_name,
                        'master_patient_jk'           => $request->master_patient_jk,
                        'master_patient_tgl_lahir'    => $request->master_patient_tgl_lahir,
                        'master_patient_tempat_lahir' => $request->master_patient_tempat_lahir,
                        'master_patient_agama'        => $request->master_patient_agama,
                        'master_patient_no_hp'        => $request->master_patient_no_hp,
                        'master_patient_email'        => $request->master_patient_email,
                        'master_patient_alamat'       => $request->master_patient_alamat,
                        'created_at'                  => now(),
                        'updated_at'                  => now(),
                    ]);
                }

                $patient = DB::table('master_patient')->where('id_master_patient', $patientId)->first();
                $poli    = DB::table('m_poli')->where('m_poli_code', $request->m_poli_code)->first();

                // Ambil info dokter untuk keperluan cetak tiket
                $schedule = DB::table('m_poli_doctor_schedule as s')
                    ->join('m_poli_doctor as pd', 's.m_poli_doctor_id', '=', 'pd.id')
                    ->join('master_doctor as d', 'pd.master_doctor_code', '=', 'd.master_doctor_code')
                    ->select('s.*', 'd.master_doctor_name', 'd.master_doctor_title_f', 'd.master_doctor_title_e')
                    ->where('s.id_schedule', $request->schedule_id) // <-- Sesuaikan 's.id_schedule' dengan nama kolom PK Anda
                    ->first();

                $doctorFullName = trim(($schedule->master_doctor_title_f ?? '') . ' ' . ($schedule->master_doctor_name ?? '') . ' ' . ($schedule->master_doctor_title_e ?? ''));

                // Generate Nomor Antrean
                $lastQueue = DB::table('t_registrations')
                    ->where('m_poli_code', $request->m_poli_code)
                    ->where('visit_date', $request->visit_date)
                    ->count();

                $queueNumber = 'A-' . str_pad($lastQueue + 1, 3, '0', STR_PAD_LEFT);

                // Insert ke Tabel Pendaftaran
                DB::table('t_registrations')->insert([
                    'queue_number'   => $queueNumber,
                    'patient_id'     => $patientId,
                    'm_poli_code'    => $request->m_poli_code,
                    'schedule_id'    => $request->schedule_id,
                    'visit_date'     => $request->visit_date,
                    'payment_method' => $request->payment_method,
                    'insurance_no'   => $request->insurance_no,
                    'status'         => 'MENUNGGU',
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Pendaftaran berhasil disimpan.',
                    'data'    => [
                        'queue_number'   => $queueNumber,
                        'poli_name'      => $poli->m_poli_name ?? $request->m_poli_code,
                        'doctor_name'    => $doctorFullName ?: '-',
                        'patient_code'   => $patient->master_patient_code,
                        'patient_name'   => $patient->master_patient_name,
                        'payment_method' => $request->payment_method,
                        'visit_date'     => $request->visit_date,
                    ]
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan pendaftaran: ' . $e->getMessage()
            ], 500);
        }
    }
    // DATA REGISTRASI POLI
    public function data_registrasi_poli(Request $request, $akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $startDate = $request->input('start_date', Carbon::today()->toDateString());
            $endDate   = $request->input('end_date', Carbon::today()->toDateString());

            // Mengambil data dropdown dokter dari tabel `medical_master_doctor`
            $doctors = DB::table('medical_master_doctor')
                ->where('is_active', 1)
                ->select('id', 'nama_lengkap as master_doctor_name')
                ->get();

            $subPenjamins = DB::table('medical_sub_penjamin')->select('id', 'nama_sub_penjamin')->get();
            $polis = DB::table('medical_master_poli')->where('is_active', 1)->select('id', 'nama_poli')->get();

            return view('application.poliklinik.data-registrasi-poliklinik', [
                'doctors'       => $doctors,
                'subPenjamins'  => $subPenjamins,
                'polis'         => $polis,
                'startDate'     => $startDate,
                'endDate'       => $endDate,
                'akses'         => $akses ?? null,
                'code'          => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

    // Route khusus untuk memuat data tabel secara asinkron (AJAX)
    public function getDataPasienPoliJson(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-d'));
        $endDate   = $request->input('end_date', date('Y-m-d'));
        $keyword   = $request->input('keyword');
        $poliId    = $request->input('poli_id');
        $dokter    = $request->input('dokter');
        $subPenjId = $request->input('sub_penjamin_id');

        $query = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'p.id', '=', 'reg.pasien_id')
            ->leftJoin('medical_transaksi as t', 't.registrasi_id', '=', 'reg.id')
            ->leftJoin('medical_sub_penjamin as sp', 'sp.id', '=', 'reg.sub_penjamin_id')
            ->leftJoin('user_mains as u', 'u.userid', '=', 'reg.user_id')
            ->leftJoin('medical_master_poli as mmp', 'mmp.id', '=', 'reg.poli_id')
            ->leftJoin('medical_master_doctor as doc_poli', 'doc_poli.id', '=', 'reg.doctor_poli_id')
            ->leftJoin('medical_master_doctor as doc_pengirim', 'doc_pengirim.id', '=', 'reg.doctor_id')
            ->whereBetween('reg.tanggal_registrasi', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->select([
                'reg.id',
                'reg.no_registrasi',
                'reg.tanggal_registrasi',
                'reg.jenis_layanan',
                'reg.janji_hasil',
                'reg.metode_pengiriman',
                'reg.status_kunjungan',
                'mmp.nama_poli as poli_nama',
                'doc_poli.nama_lengkap as dokter_poli_nama',
                'doc_pengirim.nama_lengkap as dokter_pengirim_nama',
                'p.nama as pasien_nama',
                'p.pid as pasien_pid',
                'sp.nama_sub_penjamin as agreement', // <--- Disamakan menjadi 'agreement' agar sesuai dengan script Blade
                'u.username as petugas_nama',
                't.total_tagihan',
                't.status_pembayaran'
            ]);

        // Filter berdasarkan Keyword (No Reg / Nama Pasien / PID)
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('reg.no_registrasi', 'like', "%{$keyword}%")
                    ->orWhere('p.nama', 'like', "%{$keyword}%")
                    ->orWhere('p.pid', 'like', "%{$keyword}%");
            });
        }

        // Filter berdasarkan Poli
        if (!empty($poliId)) {
            $query->where('reg.poli_id', $poliId);
        }

        // Filter berdasarkan Dokter
        if (!empty($dokter)) {
            $query->where(function ($q) use ($dokter) {
                $q->where('doc_poli.nama_lengkap', 'like', "%{$dokter}%")
                    ->orWhere('doc_pengirim.nama_lengkap', 'like', "%{$dokter}%");
            });
        }

        // Filter berdasarkan Sub Penjamin
        if (!empty($subPenjId)) {
            $query->where('reg.sub_penjamin_id', $subPenjId);
        }

        $data = $query->orderBy('reg.id', 'DESC')->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    public function data_registrasi_poli_handling(Request $request)
    {
        // 1. Ambil data dari tabel medical_registrasi (pendaftaran baru)
        $data = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'reg.pasien_id', '=', 'p.id')
            // Join opsional ke poli jika ingin menampilkan nama poli
            ->leftJoin('medical_master_poli as poli', 'reg.poli_id', '=', 'poli.id')
            ->select(
                'reg.id as registrasi_id',
                'reg.no_registrasi',
                'reg.tanggal_registrasi',
                'p.pid as master_patient_code',
                'p.nama as master_patient_name',
                'p.no_id as master_patient_nik',
                'p.jk as master_patient_jk',
                'p.tgl_lahir as master_patient_tgl_lahir',
                'p.foto as master_patient_profile',
                'poli.nama_poli'
            )
            ->where('reg.no_registrasi', $request->code)
            ->first();

        if (!$data) {
            return response()->json(['message' => 'Data Registrasi Tidak Ditemukan'], 404);
        }

        // 2. Ambil referensi form fisik & anamnesa (Tabel ini masih menggunakan tabel lama Anda)
        $fisik = DB::table('diag_poli_fisik_umum')->where('diag_poli_fisik_type', 'text')->get();
        $fisik1 = DB::table('diag_poli_fisik_umum')->where('diag_poli_fisik_type', 'textarea')->get();

        return view('application.poliklinik.data-registrasi.form-handling', [
            'data'   => $data,
            'code'   => $request->code,
            'fisik'  => $fisik,
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
    public function data_registrasi_poliklinik_handling(Request $request, $akses, $id = null)
    {
        // Validasi hak akses
        if ($this->url_akses_sub($akses, $id) == true) {

            // Inisialisasi Query dengan relasi ke tabel dokter terbaru
            $query = DB::table('medical_registrasi as reg')
                ->select(
                    'reg.id as registrasi_id',
                    'reg.no_registrasi',
                    'reg.tanggal_registrasi',
                    'reg.status_kunjungan',
                    'p.pid as master_patient_code',
                    'p.nama as master_patient_name',
                    'poli.nama_poli as m_poli_name',
                    'doc.nama_lengkap as master_doctor_name' // Disesuaikan dengan tabel medical_master_doctor
                )
                ->join('medical_patient as p', 'p.id', '=', 'reg.pasien_id')
                ->leftJoin('medical_master_poli as poli', 'poli.id', '=', 'reg.poli_id')
                ->leftJoin('medical_master_doctor as doc', 'doc.id', '=', 'reg.doctor_poli_id') // Relasi dokter pemeriksa
                ->where('reg.jenis_layanan', 'RAWAT_JALAN')
                ->whereIn('reg.status_kunjungan', ['MENUNGGU', 'PROSES']);

            // ==========================================
            // FILTER HANDLING
            // ==========================================
            // 1. Filter Range Tanggal
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween(DB::raw('DATE(reg.tanggal_registrasi)'), [$request->start_date, $request->end_date]);
            } elseif ($request->filled('start_date')) {
                $query->whereDate('reg.tanggal_registrasi', '>=', $request->start_date);
            } elseif ($request->filled('end_date')) {
                $query->whereDate('reg.tanggal_registrasi', '<=', $request->end_date);
            } else {
                // Default tampilkan hari ini
                $query->whereDate('reg.tanggal_registrasi', date('Y-m-d'));
            }

            // 2. Filter Poliklinik
            if ($request->filled('poli_id')) {
                $query->where('reg.poli_id', $request->poli_id);
            }

            // 3. Filter No Registrasi / Nama / RM
            if ($request->filled('search_query')) {
                $query->where(function ($q) use ($request) {
                    $q->where('reg.no_registrasi', 'like', '%' . $request->search_query . '%')
                        ->orWhere('p.nama', 'like', '%' . $request->search_query . '%')
                        ->orWhere('p.pid', 'like', '%' . $request->search_query . '%');
                });
            }

            $data = $query->orderBy('reg.tanggal_registrasi', 'asc')->get();

            // Ambil daftar poliklinik untuk dropdown filter
            $polis = DB::table('medical_master_poli')->get();

            return view('application.poliklinik.poliklinik-handling', [
                'data' => $data,
                'polis' => $polis,
                'akses' => $akses,
                'code' => $id,
                'request' => $request
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_registrasi_poliklinik_handling_detail(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        // 1. Query Utama Pasien & Registrasi (Termasuk template & menu_aktif)
        $data = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'p.id', '=', 'reg.pasien_id')
            ->leftJoin('medical_master_poli as poli', 'poli.id', '=', 'reg.poli_id')
            ->leftJoin('medical_master_doctor as doc', 'doc.id', '=', 'reg.doctor_poli_id')
            ->leftJoin('medical_poli_template_setting as tpl', 'tpl.poli_id', '=', 'poli.id')
            ->leftJoin('medical_sub_penjamin as sp', 'sp.id', '=', 'reg.sub_penjamin_id')
            ->leftJoin('medical_penjamin as pj', 'pj.id', '=', 'sp.penjamin_id')
            ->where('reg.no_registrasi', $request->code)
            ->select(
                'reg.id as registrasi_id',
                'reg.no_registrasi',
                'reg.sub_penjamin_id',
                'pj.nama_penjamin',
                'sp.nama_sub_penjamin',
                'p.pid as master_patient_code',
                'p.nama as master_patient_name',
                'p.tgl_lahir as master_patient_tgl_lahir',
                'p.jk as master_patient_jk',
                'p.foto as master_patient_profile',
                'poli.nama_poli as m_poli_name',
                'doc.nama_lengkap as master_doctor_name',
                'tpl.jenis_template',
                'tpl.menu_aktif',
                'tpl.keterangan as instruksi_poli'
            )
            ->first();

        if (!$data) {
            return '<div class="card-retro bg-danger p-4 text-center"><h4 class="text-white fw-bolder">Data Registrasi Tidak Ditemukan!</h4></div>';
        }

        // CEK APAKAH TEMPLATE POLI SUDAH DISETTING ATAU BELUM
        if (empty($data->jenis_template)) {
            return '
            <div class="modal-body p-4 text-center" style="background-color: #f4f0ea;">
                <div class="card p-4 border-3 border-dark" style="border-radius: 12px; box-shadow: 4px 4px 0px #1e1e24; background-color: #fff;">
                    <div class="text-warning mb-3"><i class="fas fa-exclamation-triangle fa-3x"></i></div>
                    <h4 class="fw-bolder text-dark">Template Poliklinik Belum Dikonfigurasi!</h4>
                    <p class="text-muted fw-bold mt-2">Poliklinik <strong>' . ($data->m_poli_name ?? 'Poli Ini') . '</strong> belum memiliki setting jenis template dan menu form. Silakan lakukan pengaturan terlebih dahulu pada menu <em>Master Setting Template Poliklinik</em>.</p>
                    <button type="button" class="btn btn-secondary btn-sm fw-bold px-4 mt-3 border-dark" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>';
        }

        $template_type = $data->jenis_template;

        // Decode menu_aktif JSON menjadi Array
        $menu_aktif = [];
        if (!empty($data->menu_aktif)) {
            $menu_aktif = json_decode($data->menu_aktif, true) ?? [];
        } else {
            // Fallback jika template ada tapi menu aktif belum dicentang
            $menu_aktif = ['anamnesa', 'vital_sign', 'odontogram', 'tindakan', 'resep', 'diagnosa'];
        }

        // 2. Ambil Riwayat Pemeriksaan SOAP / Odontogram
        $existing_soap = DB::table('medical_poli_soap')
            ->where('registrasi_id', $data->registrasi_id)
            ->first();

        // 3. Ambil Riwayat Anamnesa Terpisah
        $existing_anamnesa = DB::table('medical_poli_anamnesa')
            ->where('registrasi_id', $data->registrasi_id)
            ->first();

        // 4. Ambil Riwayat Vital Sign Terpisah
        $existing_vs = DB::table('medical_poli_vital_sign')
            ->where('registrasi_id', $data->registrasi_id)
            ->first();

        // 5. Ambil Daftar Order Tindakan
        $existing_tindakan = DB::table('medical_poli_tindakan as pt')
            ->join('medical_master_pemeriksaan as mp', 'mp.id', '=', 'pt.master_pemeriksaan_id')
            ->join('medical_tipe_layanan as tl', 'tl.id', '=', 'mp.tipe_layanan_id')
            ->where('pt.registrasi_id', $data->registrasi_id)
            ->select('mp.id', 'mp.nama_layanan', 'tl.nama_tipe as kategori_tindakan', 'pt.tarif')
            ->get();

        // 6. Ambil Daftar Resep Obat
        $existing_resep = DB::table('medical_poli_resep as pr')
            ->join('farm_data_obat as obat', 'obat.farm_data_obat_code', '=', 'pr.farm_data_obat_code')
            ->where('pr.registrasi_id', $data->registrasi_id)
            ->select('obat.farm_data_obat_code', 'obat.farm_data_obat_name', 'obat.farm_data_obat_satuan', 'pr.qty', 'pr.signa', 'pr.harga')
            ->get();

        // 7. Query Master Pemeriksaan untuk Dropdown Order Baru
        $daftar_tindakan = DB::table('medical_master_pemeriksaan as mp')
            ->join('medical_tipe_layanan as tl', 'tl.id', '=', 'mp.tipe_layanan_id')
            ->leftJoin('medical_penjamin_pemeriksaan as mpp', function ($join) use ($data) {
                $join->on('mpp.master_pemeriksaan_id', '=', 'mp.id')
                    ->where('mpp.sub_penjamin_id', '=', $data->sub_penjamin_id);
            })
            ->where('mp.is_active', true)
            ->select(
                'mp.id',
                'mp.nama_layanan',
                'tl.nama_tipe as kategori_tindakan',
                DB::raw('(mp.harga - COALESCE(mpp.diskon, 0)) as harga_akhir')
            )
            ->get();

        // 8. Query Master Obat untuk Dropdown Resep Baru
        $daftar_obat = DB::table('farm_data_obat as obat')
            ->join('farm_penjamin_obat as fpo', 'fpo.farm_data_obat_code', '=', 'obat.farm_data_obat_code')
            ->where('fpo.sub_penjamin_id', $data->sub_penjamin_id)
            ->where('fpo.status', 1)
            ->select(
                'obat.farm_data_obat_code',
                'obat.farm_data_obat_name',
                'obat.farm_data_obat_satuan',
                'obat.farm_data_obat_stok',
                'fpo.harga_jual'
            )
            ->get();

        $fisik = DB::table('diag_poli_fisik_umum')->where('diag_poli_fisik_type', 'text')->get();
        $fisik1 = DB::table('diag_poli_fisik_umum')->where('diag_poli_fisik_type', 'textarea')->get();

        return view('application.poliklinik.poliklinik-handling.form-handling', [
            'data'              => $data,
            'code'              => $request->code,
            'template_type'     => $template_type,
            'menu_aktif'        => $menu_aktif,
            'fisik'             => $fisik,
            'fisik1'            => $fisik1,
            'daftar_tindakan'   => $daftar_tindakan,
            'daftar_obat'       => $daftar_obat,
            'existing_soap'     => $existing_soap,
            'existing_anamnesa' => $existing_anamnesa,
            'existing_vs'       => $existing_vs,
            'existing_tindakan' => $existing_tindakan,
            'existing_resep'    => $existing_resep
        ]);
    }
    public function store_handling_medis(Request $request)
    {
        $request->validate([
            'no_registrasi'  => 'required|string',
            'jenis_template' => 'required|string',
            'diagnosa_akhir' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $registrasi = DB::table('medical_registrasi')
                ->where('no_registrasi', $request->no_registrasi)
                ->first();

            if (!$registrasi) {
                return response()->json(['success' => false, 'message' => 'Registrasi tidak ditemukan.'], 404);
            }

            // 1. Data Spesifik Poli (Odontogram dll)
            $dataSpesifik = null;
            if ($request->jenis_template === 'GIGI') {
                $dataSpesifik = [
                    'gigi_status'  => $request->gigi ?? [],
                    'gigi_catatan' => $request->catatan_gigi ?? [],
                    'kalkulus'     => $request->gigi_kalkulus ?? 'TIDAK_ADA'
                ];
            }

            // 2. Simpan SOAP (Update jika sudah ada, Insert jika belum)
            DB::table('medical_poli_soap')->updateOrInsert(
                ['registrasi_id' => $registrasi->id],
                [
                    'subjektif'          => $request->keluhan_utama ?? $request->subjektif ?? null,
                    'objektif'           => $request->pemeriksaan_fisik ?? $request->objektif ?? null,
                    'asesmen'            => $request->diagnosa_akhir,
                    'planning'           => 'Pemberian resep & tindakan medis',
                    'data_spesifik_poli' => $dataSpesifik ? json_encode($dataSpesifik) : null,
                    'input_by'           => auth()->user()->name ?? 'Dokter Poli',
                    'status_verifikasi'  => 'Pending',
                    'updated_at'         => now(),
                    'created_at'         => now()
                ]
            );
            // 1. Simpan / Update Anamnesa Lengkap
            DB::table('medical_poli_anamnesa')->updateOrInsert(
                ['registrasi_id' => $registrasi->id],
                [
                    'keluhan_utama'             => $request->keluhan_utama,
                    'riwayat_penyakit_sekarang' => $request->riwayat_penyakit_sekarang,
                    'riwayat_penyakit_dahulu'   => $request->riwayat_penyakit_dahulu,
                    'riwayat_penyakit_keluarga' => $request->riwayat_penyakit_keluarga,
                    'riwayat_alergi'            => $request->riwayat_alergi,
                    'riwayat_penggunaan_obat'   => $request->riwayat_penggunaan_obat,
                    'input_by'                  => auth()->user()->name ?? 'Dokter Poli',
                    'updated_at'                => now(),
                    'created_at'                => now()
                ]
            );

            // 2. Simpan / Update Vital Sign & Fisik Umum
            DB::table('medical_poli_vital_sign')->updateOrInsert(
                ['registrasi_id' => $registrasi->id],
                [
                    'kesadaran'               => $request->kesadaran,
                    'tekanan_darah'           => $request->tekanan_darah,
                    'nadi'                    => $request->nadi,
                    'suhu'                    => $request->suhu,
                    'pernapasan'              => $request->pernapasan,
                    'saturasi_o2'             => $request->saturasi_o2,
                    'berat_badan'             => $request->berat_badan,
                    'tinggi_badan'            => $request->tinggi_badan,
                    'pemeriksaan_fisik_lain'  => $request->pemeriksaan_fisik_lain,
                    'input_by'                => auth()->user()->name ?? 'Dokter Poli',
                    'updated_at'              => now(),
                    'created_at'              => now()
                ]
            );

            // 3. Update Order Tindakan (Hapus yang lama, masukkan yang baru dari form)
            DB::table('medical_poli_tindakan')->where('registrasi_id', $registrasi->id)->delete();
            if ($request->has('order_pemeriksaan_id')) {
                for ($i = 0; $i < count($request->order_pemeriksaan_id); $i++) {
                    DB::table('medical_poli_tindakan')->insert([
                        'registrasi_id'         => $registrasi->id,
                        'master_pemeriksaan_id' => $request->order_pemeriksaan_id[$i],
                        'tarif'                 => $request->order_tarif[$i] ?? 0,
                        'jumlah'                => 1,
                        'input_by'              => auth()->user()->name ?? 'Dokter Poli',
                        'status_verifikasi'     => 'Pending',
                        'created_at'            => now(),
                        'updated_at'            => now()
                    ]);
                }
            }

            // 4. Update E-Resep (Hapus yang lama, masukkan yang baru dari form)
            DB::table('medical_poli_resep')->where('registrasi_id', $registrasi->id)->delete();
            if ($request->has('resep_obat_code')) {
                $noResep = 'RSP-' . date('Ymd') . '-' . rand(1000, 9999);

                for ($i = 0; $i < count($request->resep_obat_code); $i++) {
                    DB::table('medical_poli_resep')->insert([
                        'registrasi_id'         => $registrasi->id,
                        'transaksi_id'          => null,
                        'no_resep'              => $noResep,
                        'farm_data_obat_code'   => $request->resep_obat_code[$i],
                        'qty'                   => $request->resep_jumlah[$i],
                        'harga'                 => $request->resep_harga[$i],
                        'signa'                 => $request->resep_signa[$i],
                        'input_by'              => auth()->user()->name ?? 'Dokter Poli',
                        'status_verifikasi'     => 'Pending',
                        'status_pembayaran'     => 'BELUM LUNAS',
                        'created_at'            => now(),
                        'updated_at'            => now()
                    ]);
                }
            }

            DB::commit();
            DB::table('medical_registrasi')
                ->where('no_registrasi', $request->no_registrasi)->update(['status_kunjungan' => 'PROSES']);
            return response()->json([
                'success' => true,
                'message' => 'Hasil pemeriksaan berhasil diperbarui dan disimpan!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
    public function data_registrasi_poliklinik_handling_order_layanan(Request $request)
    {
        //RADIOLOGI
        $catCode = $request->input('cat_code');
        $regCode = $request->input('reg_code');

        // Ambil data kategori order
        $kategori = DB::table('t_layanan_cat')
            ->where('t_layanan_cat_code', $catCode)
            ->first();

        // Ambil daftar item pemeriksaan/layanan berdasarkan kategori
        $items = DB::table('t_layanan_data')
            ->where('t_layanan_cat_code', $catCode)
            ->where('t_layanan_data_status', 1)
            ->get();

        // Ambil data riwayat order yang sudah pernah di-input sebelumnya (jika ada)
        // $existingOrders = DB::table('t_order_penunjang_detail')
        //     ->join('t_order_penunjang', 't_order_penunjang.id', '=', 't_order_penunjang_detail.order_id')
        //     ->where('t_order_penunjang.reg_code', $regCode)
        //     ->where('t_order_penunjang.cat_code', $catCode)
        //     ->pluck('t_order_penunjang_detail.item_code')
        //     ->toArray();

        return view('application.poliklinik.poliklinik-handling.form-order-poliklinik', compact('kategori', 'items', 'catCode', 'regCode'));
        // if ($request->code == '80304154-baeb-4b7a-8ba8-f818726a84df') {
        //     $dokter = DB::table('master_doctor')->get();
        //     $pemeriksaan = DB::table('p_sales_data')
        //         ->join('p_sales_cat', 'p_sales_cat.p_sales_cat_code', '=', 'p_sales_data.p_sales_cat_code')
        //         ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
        //         ->where('p_sales_cat.t_layanan_cat_code', $request->code)
        //         ->where('p_sales_cat.p_sales_cat_name', 'PEMERIKSAAN')
        //         ->get();
        //     return view('application.poliklinik.poliklinik-handling.order-radiologi', ['reg' => $request->reg, 'dokter' => $dokter, 'code' => $request->code, 'pemeriksaan' => $pemeriksaan]);
        // } else {
        //     return $request->code;
        // }
    }
    public function data_registrasi_poliklinik_handling_order_layanan_save(Request $request)
    {
        $request->validate([
            'reg_code' => 'required',
            'cat_code' => 'required',
            'items'    => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        try {
            // 1. Simpan Header Order
            $orderId = DB::table('t_order_penunjang')->insertGetId([
                'order_code'     => 'ORD-' . date('YmdHis') . '-' . rand(100, 999),
                'reg_code'       => $request->reg_code,
                'cat_code'       => $request->cat_code,
                'catatan_dokter' => $request->catatan_dokter,
                'created_by'     => Auth::user()->id ?? 1,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            // 2. Simpan Detail Item Order
            $detailData = [];
            foreach ($request->items as $itemCode) {
                $detailData[] = [
                    'order_id'   => $orderId,
                    'item_code'  => $itemCode,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('t_order_penunjang_detail')->insert($detailData);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Order penunjang berhasil dikirim.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan order: ' . $e->getMessage()
            ], 500);
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
            return 'Berhasil Meenyimpan , Jika Pemeriksaan pada pasien sudah lengkap silahkan untuk melakukan skip / simpan data';
            # code...
        }
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
            ->join('t_pasien_cat_data', 't_pasien_cat_data.id_t_pasien_cat_data', '=', 't_pasien_cat_data_poli.id_t_pasien_cat_data')
            ->where('t_pasien_cat_data.t_pasien_cat_data_type', 'file')
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
    public function verifikasi_poliklinik_dokter(Request $request, $akses, $id = null)
    {
        if ($this->url_akses_sub($akses, $id) == true) {

            $query = DB::table('medical_registrasi as reg')
                ->select(
                    'reg.id as registrasi_id',
                    'reg.no_registrasi',
                    'reg.tanggal_registrasi',
                    'reg.status_kunjungan',
                    'p.pid as master_patient_code',
                    'p.nama as master_patient_name',
                    'poli.nama_poli as m_poli_name',
                    'doc.nama_lengkap as master_doctor_name',
                    'soap.status_verifikasi as status_verifikasi_dokter' // Mengambil status dari tabel SOAP poli
                )
                ->join('medical_patient as p', 'p.id', '=', 'reg.pasien_id')
                ->leftJoin('medical_master_poli as poli', 'poli.id', '=', 'reg.poli_id')
                ->leftJoin('medical_master_doctor as doc', 'doc.id', '=', 'reg.doctor_poli_id')
                ->leftJoin('medical_poli_soap as soap', 'soap.registrasi_id', '=', 'reg.id') // Join ke tabel SOAP poli
                ->where('reg.jenis_layanan', 'RAWAT_JALAN')
                ->where('reg.status_kunjungan', 'PROSES');

            // Filter Tanggal (Default Hari Ini)
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween(DB::raw('DATE(reg.tanggal_registrasi)'), [$request->start_date, $request->end_date]);
            } else {
                $query->whereDate('reg.tanggal_registrasi', date('Y-m-d'));
            }

            $data = $query->orderBy('reg.tanggal_registrasi', 'asc')->get();

            return view('application.poliklinik.verifikasi-dokter-poliklinik', [
                'akses' => $akses,
                'code' => $id,
                'data' => $data,
                'request' => $request
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function verifikasi_poliklinik_dokter_detail(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        // 1. Query Utama Pasien & Registrasi
        $data = DB::table('medical_registrasi as reg')
            ->join('medical_patient as p', 'p.id', '=', 'reg.pasien_id')
            ->leftJoin('medical_master_poli as poli', 'poli.id', '=', 'reg.poli_id')
            ->leftJoin('medical_master_doctor as doc', 'doc.id', '=', 'reg.doctor_poli_id')
            ->leftJoin('medical_poli_template_setting as tpl', 'tpl.poli_id', '=', 'poli.id')
            ->leftJoin('medical_sub_penjamin as sp', 'sp.id', '=', 'reg.sub_penjamin_id')
            ->leftJoin('medical_penjamin as pj', 'pj.id', '=', 'sp.penjamin_id')
            ->where('reg.no_registrasi', $request->code)
            ->select(
                'reg.id as registrasi_id',
                'reg.no_registrasi',
                'reg.sub_penjamin_id',
                'pj.nama_penjamin',
                'sp.nama_sub_penjamin',
                'p.pid as master_patient_code',
                'p.nama as master_patient_name',
                'p.tgl_lahir as master_patient_tgl_lahir',
                'p.jk as master_patient_jk',
                'p.foto as master_patient_profile',
                'poli.nama_poli as m_poli_name',
                'doc.nama_lengkap as master_doctor_name',
                'tpl.jenis_template',
                'tpl.menu_aktif',
                'tpl.keterangan as instruksi_poli'
            )
            ->first();

        if (!$data) {
            return '<div class="card-retro bg-danger p-4 text-center"><h4 class="text-white fw-bolder">Data Registrasi Tidak Ditemukan!</h4></div>';
        }

        $template_type = $data->jenis_template ?? 'UMUM';

        $menu_aktif = [];
        if (!empty($data->menu_aktif)) {
            $menu_aktif = json_decode($data->menu_aktif, true) ?? [];
        } else {
            $menu_aktif = ['anamnesa', 'vital_sign', 'odontogram', 'tindakan', 'resep', 'diagnosa'];
        }

        // 2. Ambil Riwayat SOAP / Diagnosa
        $existing_soap = DB::table('medical_poli_soap')
            ->where('registrasi_id', $data->registrasi_id)
            ->first();

        // 3. Ambil Riwayat Anamnesa
        $existing_anamnesa = DB::table('medical_poli_anamnesa')
            ->where('registrasi_id', $data->registrasi_id)
            ->first();

        // 4. Ambil Riwayat Vital Sign
        $existing_vs = DB::table('medical_poli_vital_sign')
            ->where('registrasi_id', $data->registrasi_id)
            ->first();

        // 5. Ambil Daftar Tindakan Tersimpan
        $existing_tindakan = DB::table('medical_poli_tindakan as pt')
            ->join('medical_master_pemeriksaan as mp', 'mp.id', '=', 'pt.master_pemeriksaan_id')
            ->join('medical_tipe_layanan as tl', 'tl.id', '=', 'mp.tipe_layanan_id')
            ->where('pt.registrasi_id', $data->registrasi_id)
            ->select('mp.id', 'mp.nama_layanan', 'tl.nama_tipe as kategori_tindakan', 'pt.tarif')
            ->get();

        // 6. Ambil Daftar Resep Obat Tersimpan
        $existing_resep = DB::table('medical_poli_resep as pr')
            ->join('farm_data_obat as obat', 'obat.farm_data_obat_code', '=', 'pr.farm_data_obat_code')
            ->where('pr.registrasi_id', $data->registrasi_id)
            ->select('obat.farm_data_obat_code', 'obat.farm_data_obat_name', 'obat.farm_data_obat_satuan', 'pr.qty', 'pr.signa', 'pr.harga')
            ->get();

        // 7. Master Tindakan & Obat (untuk opsi dropdown jika diperlukan edit saat verifikasi)
        $daftar_tindakan = DB::table('medical_master_pemeriksaan as mp')
            ->join('medical_tipe_layanan as tl', 'tl.id', '=', 'mp.tipe_layanan_id')
            ->leftJoin('medical_penjamin_pemeriksaan as mpp', function ($join) use ($data) {
                $join->on('mpp.master_pemeriksaan_id', '=', 'mp.id')
                    ->where('mpp.sub_penjamin_id', '=', $data->sub_penjamin_id);
            })
            ->where('mp.is_active', true)
            ->select('mp.id', 'mp.nama_layanan', 'tl.nama_tipe as kategori_tindakan', DB::raw('(mp.harga - COALESCE(mpp.diskon, 0)) as harga_akhir'))
            ->get();

        $daftar_obat = DB::table('farm_data_obat as obat')
            ->join('farm_penjamin_obat as fpo', 'fpo.farm_data_obat_code', '=', 'obat.farm_data_obat_code')
            ->where('fpo.sub_penjamin_id', $data->sub_penjamin_id)
            ->where('fpo.status', 1)
            ->select('obat.farm_data_obat_code', 'obat.farm_data_obat_name', 'obat.farm_data_obat_satuan', 'obat.farm_data_obat_stok', 'fpo.harga_jual')
            ->get();

        return view('application.poliklinik.verifikasi-poli.form-verifikasi-preview', [
            'data'              => $data,
            'code'              => $request->code,
            'template_type'     => $template_type,
            'menu_aktif'        => $menu_aktif,
            'daftar_tindakan'   => $daftar_tindakan,
            'daftar_obat'       => $daftar_obat,
            'existing_soap'     => $existing_soap,
            'existing_anamnesa' => $existing_anamnesa,
            'existing_vs'       => $existing_vs,
            'existing_tindakan' => $existing_tindakan,
            'existing_resep'    => $existing_resep
        ]);
    }
    public function verifikasi_poliklinik_dokter_save_verify(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        try {
            DB::beginTransaction();

            // 1. Ambil Data Registrasi
            $registrasi = DB::table('medical_registrasi')
                ->where('no_registrasi', $request->code)
                ->first();

            if (!$registrasi) {
                return response()->json(['success' => false, 'message' => 'Data registrasi tidak ditemukan.']);
            }

            // 2. Update status verifikasi langsung pada tabel medical_poli_soap
            DB::table('medical_poli_soap')
                ->where('registrasi_id', $registrasi->id)
                ->update([
                    'status_verifikasi' => 'Verified',
                    'updated_at'        => now()
                ]);

            // 3. Ambil ID Transaksi Utama (Kasir)
            $transaksi = DB::table('medical_transaksi')->where('registrasi_id', $registrasi->id)->first();

            if (!$transaksi) {
                $transaksiId = DB::table('medical_transaksi')->insertGetId([
                    'registrasi_id'     => $registrasi->id,
                    'total_tagihan'     => 0,
                    'total_bayar'       => 0,
                    'sisa_tagihan'      => 0,
                    'metode_bayar'      => 'CASH',
                    'status_pembayaran' => 'BELUM LUNAS',
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            } else {
                $transaksiId = $transaksi->id;
            }

            $akumulasiSelisihTagihan = 0; // Untuk melacak naik/turunnya tagihan kasir
            $tanggalFormat = date('dmy');

            // =================================================================================
            // TAHAP 1: CLEAN UP (Hapus tagihan di kasir jika dokter membatalkan/menghapus item)
            // =================================================================================

            // Bersihkan Tindakan Poli yang sudah tidak ada
            $orphanedTindakan = DB::table('medical_transaksi_detail')
                ->where('transaksi_id', $transaksiId)
                ->where('sumber_tagihan', 'POLI_TINDAKAN')
                ->where('status_pembayaran', 'BELUM LUNAS') // Hanya hapus jika belum dibayar
                ->whereNotIn('sumber_id', function ($q) use ($registrasi) {
                    $q->select('id')->from('medical_poli_tindakan')->where('registrasi_id', $registrasi->id);
                })->get();

            foreach ($orphanedTindakan as $ot) {
                $akumulasiSelisihTagihan -= $ot->harga_akhir; // Kurangi tagihan
                DB::table('medical_transaksi_detail')->where('id', $ot->id)->delete();
            }

            // Bersihkan Resep Obat yang sudah tidak ada
            $orphanedResep = DB::table('medical_transaksi_detail')
                ->where('transaksi_id', $transaksiId)
                ->where('sumber_tagihan', 'POLI_RESEP')
                ->where('status_pembayaran', 'BELUM LUNAS')
                ->whereNotIn('sumber_id', function ($q) use ($registrasi) {
                    $q->select('id')->from('medical_poli_resep')->where('registrasi_id', $registrasi->id);
                })->get();

            foreach ($orphanedResep as $or) {
                $akumulasiSelisihTagihan -= $or->harga_akhir; // Kurangi tagihan
                DB::table('medical_transaksi_detail')->where('id', $or->id)->delete();
            }

            // =================================================================================
            // TAHAP 2: SINKRONISASI TINDAKAN POLI
            // =================================================================================

            $tindakanPoli = DB::table('medical_poli_tindakan')
                ->where('registrasi_id', $registrasi->id)
                ->get(); // Ambil semua untuk dicek ulang

            foreach ($tindakanPoli as $tind) {
                $detailKasir = DB::table('medical_transaksi_detail')
                    ->where('transaksi_id', $transaksiId)
                    ->where('sumber_tagihan', 'POLI_TINDAKAN')
                    ->where('sumber_id', $tind->id)
                    ->first();

                if (!$detailKasir) {
                    // JIKA BELUM ADA: INSERT BARU
                    $master = DB::table('medical_master_pemeriksaan as mp')
                        ->leftJoin('medical_tipe_layanan as tl', 'mp.tipe_layanan_id', '=', 'tl.id')
                        ->select('mp.nama_layanan', 'tl.prefix')
                        ->where('mp.id', $tind->master_pemeriksaan_id)
                        ->first();

                    $prefix = strtoupper($master->prefix ?? 'ORD');
                    $lastOrder = DB::table('medical_transaksi_detail')
                        ->where('no_pemeriksaan', 'like', "{$prefix}{$tanggalFormat}%")
                        ->orderBy('id', 'desc')->first();

                    $noUrutOrder = $lastOrder ? (int) substr($lastOrder->no_pemeriksaan, -4) + 1 : 1;
                    $noPemeriksaanBaru = $prefix . $tanggalFormat . str_pad($noUrutOrder, 4, '0', STR_PAD_LEFT);

                    DB::table('medical_transaksi_detail')->insert([
                        'transaksi_id'          => $transaksiId,
                        'jenis_item'            => 'TINDAKAN',
                        'nama_item'             => $master->nama_layanan ?? 'Tindakan Poli',
                        'master_pemeriksaan_id' => $tind->master_pemeriksaan_id,
                        'farm_data_obat_code'   => null,
                        'sumber_tagihan'        => 'POLI_TINDAKAN',
                        'sumber_id'             => $tind->id,
                        'no_pemeriksaan'        => $noPemeriksaanBaru,
                        'qty'                   => 1,
                        'harga_dasar'           => $tind->tarif,
                        'harga_akhir'           => $tind->tarif,
                        'status_pemeriksaan'    => 'MENUNGGU',
                        'status_pembayaran'     => 'BELUM LUNAS',
                        'created_at'            => now(),
                        'updated_at'            => now(),
                    ]);

                    $akumulasiSelisihTagihan += $tind->tarif;
                } else {
                    // JIKA SUDAH ADA & BELUM LUNAS: UPDATE JIKA ADA PERUBAHAN HARGA
                    if ($detailKasir->status_pembayaran == 'BELUM LUNAS' && $detailKasir->harga_akhir != $tind->tarif) {
                        $selisih = $tind->tarif - $detailKasir->harga_akhir;
                        $akumulasiSelisihTagihan += $selisih;

                        DB::table('medical_transaksi_detail')->where('id', $detailKasir->id)->update([
                            'harga_dasar' => $tind->tarif,
                            'harga_akhir' => $tind->tarif,
                            'updated_at'  => now()
                        ]);
                    }
                }

                // Tandai tindakan poli sudah diverifikasi
                DB::table('medical_poli_tindakan')->where('id', $tind->id)->update(['status_verifikasi' => 'Verified']);
            }

            // =================================================================================
            // TAHAP 3: SINKRONISASI RESEP OBAT
            // =================================================================================

            $resepPoli = DB::table('medical_poli_resep')
                ->where('registrasi_id', $registrasi->id)
                ->get();

            foreach ($resepPoli as $rsp) {
                $subtotalObat = $rsp->qty * $rsp->harga;

                $detailKasir = DB::table('medical_transaksi_detail')
                    ->where('transaksi_id', $transaksiId)
                    ->where('sumber_tagihan', 'POLI_RESEP')
                    ->where('sumber_id', $rsp->id)
                    ->first();

                if (!$detailKasir) {
                    // JIKA BELUM ADA: INSERT BARU
                    $masterObat = DB::table('farm_data_obat')->where('farm_data_obat_code', $rsp->farm_data_obat_code)->first();

                    DB::table('medical_transaksi_detail')->insert([
                        'transaksi_id'          => $transaksiId,
                        'jenis_item'            => 'OBAT',
                        'nama_item'             => $masterObat->farm_data_obat_name ?? 'Obat Farmasi',
                        'farm_data_obat_code'   => $rsp->farm_data_obat_code,
                        'sumber_tagihan'        => 'POLI_RESEP',
                        'sumber_id'             => $rsp->id,
                        'qty'                   => $rsp->qty,
                        'harga_dasar'           => $rsp->harga,
                        'harga_akhir'           => $subtotalObat,
                        'status_pemeriksaan'    => 'MENUNGGU',
                        'status_pembayaran'     => 'BELUM LUNAS',
                        'created_at'            => now(),
                        'updated_at'            => now(),
                    ]);

                    $akumulasiSelisihTagihan += $subtotalObat;
                } else {
                    // JIKA SUDAH ADA & BELUM LUNAS: UPDATE JIKA DOKTER MENGUBAH QTY/HARGA
                    if ($detailKasir->status_pembayaran == 'BELUM LUNAS' && $detailKasir->harga_akhir != $subtotalObat) {
                        $selisih = $subtotalObat - $detailKasir->harga_akhir;
                        $akumulasiSelisihTagihan += $selisih;

                        DB::table('medical_transaksi_detail')->where('id', $detailKasir->id)->update([
                            'qty'         => $rsp->qty,
                            'harga_dasar' => $rsp->harga,
                            'harga_akhir' => $subtotalObat,
                            'updated_at'  => now()
                        ]);
                    }
                }

                // Tandai resep sudah diverifikasi
                DB::table('medical_poli_resep')->where('id', $rsp->id)->update([
                    'status_verifikasi' => 'Verified',
                    'transaksi_id'      => $transaksiId
                ]);
            }

            // =================================================================================
            // TAHAP 4: KALKULASI ULANG TOTAL TAGIHAN
            // =================================================================================

            if ($akumulasiSelisihTagihan != 0) {
                DB::table('medical_transaksi')
                    ->where('id', $transaksiId)
                    ->update([
                        'total_tagihan' => DB::raw("total_tagihan + ($akumulasiSelisihTagihan)"),
                        'sisa_tagihan'  => DB::raw("sisa_tagihan + ($akumulasiSelisihTagihan)"),
                    ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pemeriksaan poliklinik berhasil disinkronisasi & tagihan diteruskan ke kasir!'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
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
        $paket = DB::table('p_m_sales')->where('p_m_sales_status', 1)->get();
        $list = DB::table('d_reg_order_poli_log')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_poli_log.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_code', $request->code)->get();
        return view('application.poliklinik.verifikasi-poli.form-verifikasi', [
            'data' => $data,
            'code' => $request->code,
            'fisik' => $fisik,
            'fisik1' => $fisik1,
            'paket' => $paket,
            'list' => $list
        ]);
    }
    public function verifikasi_poliklinik_dokter_pilih_penjualan(Request $request)
    {
        $data = DB::table('p_sales')->where('p_m_sales_code', $request->id)->get();
        return view('application.poliklinik.verifikasi-poli.data-sub-penjualan', ['data' => $data]);
    }
    public function verifikasi_poliklinik_dokter_pilih_sub_penjualan(Request $request)
    {
        $data = DB::table('p_sales_data')
            ->join('p_sales_cat', 'p_sales_cat.p_sales_cat_code', '=', 'p_sales_data.p_sales_cat_code')
            ->join('p_sales', 'p_sales.p_sales_code', '=', 'p_sales_cat.p_sales_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('p_sales.p_sales_code', $request->code)->get();
        return view('application.poliklinik.verifikasi-poli.data-sub-paket', ['data' => $data]);
    }
    public function verifikasi_poliklinik_dokter_pilih_pemeriksaan(Request $request)
    {
        $data = DB::table('p_sales_data')->where('p_sales_data_code', $request->id)->first();
        $cek = DB::table('d_reg_order_poli_log')
            ->where('d_reg_order_code', $request->code)->where('p_sales_data_code', $request->id)->first();
        if ($cek) {
            return 1;
        } else {
            DB::table('d_reg_order_poli_log')->insert([
                'order_poli_log_code' => str::uuid(),
                'd_reg_order_code' => $request->code,
                'p_sales_data_code' => $request->id,
                'order_poli_log_price' => $data->p_sales_data_price,
                'order_poli_log_discount' => $data->p_sales_data_disc,
                'created_at' => now(),
            ]);
            $list = DB::table('d_reg_order_poli_log')
                ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_poli_log.p_sales_data_code')
                ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
                ->where('d_reg_order_code', $request->code)->get();
            return view('application.poliklinik.verifikasi-poli.table.list-harga-pemeriksaan', ['list' => $list, 'code' => $request->code]);
        }
    }
    public function verifikasi_poliklinik_dokter_remove_pemeriksaan(Request $request)
    {
        DB::table('d_reg_order_poli_log')->where('order_poli_log_code', $request->id)->delete();
        $list = DB::table('d_reg_order_poli_log')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_poli_log.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_code', $request->code)->get();
        return view('application.poliklinik.verifikasi-poli.table.list-harga-pemeriksaan', ['list' => $list, 'code' => $request->code]);
    }

    // POLIKLINIK DOKUMENTASI HASIL
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
                ->where('d_reg_order_poli.d_reg_order_poli_status', '>=', 3)->orderBy('id_d_reg_order_poli', 'DESC')->get();
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
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 575, 823);
            ');
        $pdf->get_canvas()->get_cpdf()->setEncryption("admin", date('dmY', strtotime($pasien->master_patient_tgl_lahir)));
        $file = base64_encode($pdf->stream());
        $base64Pdf = 'data:application/pdf;base64,' . $file; // Your Base64 encoded PDF string
        list($type, $data) = explode(';', $base64Pdf);
        list(, $data) = explode(',', $data);
        $pdfBinaryData = base64_decode($data);
        $tempPdfPath = storage_path('app/public/hasil/poli/' . $request->code . '.pdf');
        file_put_contents($tempPdfPath, $pdfBinaryData);
        // PROSES KIRIM

        $nomorhp = $pasien->master_patient_no_hp;
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
        $name = storage_path('app/public/hasil/poli/' . $request->code . '.pdf');

        $img = file_get_contents($name);
        // a route is created, (it must already be created in its repository(pdf)).
        // $rute    = "pdf/" . $name;
        $pass = date('dmY', strtotime($pasien->master_patient_tgl_lahir));
        // decode base64
        $pdf_b64 = base64_encode($img);
        $cek = DB::table('v_log_whatsapp')->where('d_reg_order_list_code', $request->code)->first();
        // you record the file in existing folder
        if ($cek) {
            DB::table('v_log_whatsapp')->where('d_reg_order_list_code', $request->code)->update([
                'v_log_whatsapp_number' => $nomorhp,
                'v_log_whatsapp_name' => $pasien->master_patient_name,
                'v_log_whatsapp_filename' => $request->code . date('his'),
                'v_log_whatsapp_text' => "Halo, " . $pasien->master_patient_name . "\nHasil Pemeriksaan Gigi, Dengan Password Tanggal Lahir : Ex. 01011991",
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
                'v_log_whatsapp_name' => $pasien->master_patient_name,
                'v_log_whatsapp_filename' => $request->code . date('his'),
                'v_log_whatsapp_text' => "Halo, " . $pasien->master_patient_name . "\nHasil Pemeriksaan Gigi, Dengan Password Tanggal Lahir : Ex. 01011991",
                'v_log_whatsapp_file' => $pdf_b64,
                'v_log_whatsapp_picture' => '0',
                'v_log_whatsapp_status' => 0,
                'v_log_whatsapp_date' => now(),
                'v_log_whatsapp_pass' => $pass,
                'created_at' => now(),
            ]);
        }
        DB::table('d_reg_order_poli')->where('d_reg_order_poli_code', $request->code)->update([
            'd_reg_order_poli_status' => 4,
            'updated_at' => now(),
        ]);
        return 123;
    }

    // POLIKLINIK DOKUMENTASI HASIL
    public function master_poliklinik_template($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {

            // Ambil data poliklinik beserta setting template dan menu_aktif-nya
            $data = DB::table('medical_master_poli as poli')
                ->leftJoin('medical_poli_template_setting as setting', 'poli.id', '=', 'setting.poli_id')
                ->select(
                    'poli.id as poli_id',
                    'poli.kode_poli',
                    'poli.nama_poli',
                    'setting.id as setting_id',
                    'setting.jenis_template',
                    'setting.menu_aktif', // <-- Tambahkan ini agar data JSON menu terbawa
                    'setting.keterangan',
                    'setting.is_active'
                )
                ->orderBy('poli.nama_poli', 'asc')
                ->get();

            // Pilihan template yang tersedia di sistem
            $template_options = [
                'UMUM' => 'Formulir Standar (Umum)',
                'GIGI' => 'Formulir Gigi & Odontogram',
                'KANDUNGAN' => 'Formulir Kandungan & USG',
                'MATA' => 'Formulir Pemeriksaan Mata (Visus)',
                'THT' => 'Formulir Pemeriksaan THT',
                'KULIT_KELAMIN' => 'Formulir Kulit & Kelamin',
                'CUSTOM' => 'Formulir Custom / Lainnya'
            ];

            return view('application.poliklinik.master-poliklinik-template', [
                'data' => $data,
                'template_options' => $template_options,
                'akses' => $akses,
                'code' => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function save_poliklinik_template(Request $request)
    {
        // 1. Validasi input yang masuk
        $request->validate([
            'poli_id' => 'required|integer',
            'jenis_template' => 'required|string',
        ]);

        try {
            // 2. Ubah array menu_form dari checkbox menjadi string JSON (jika ada)
            $menuAktif = $request->has('menu_form') ? json_encode($request->menu_form) : null;

            // 3. Cek apakah setting untuk poli_id ini sudah ada di database
            $exists = DB::table('medical_poli_template_setting')
                ->where('poli_id', $request->poli_id)
                ->first();

            if ($exists) {
                // Jika sudah ada -> Lakukan Update
                DB::table('medical_poli_template_setting')
                    ->where('poli_id', $request->poli_id)
                    ->update([
                        'jenis_template' => $request->jenis_template,
                        'menu_aktif'     => $menuAktif, // Simpan konfigurasi menu aktif
                        'keterangan'     => $request->keterangan,
                        'updated_at'     => now()
                    ]);
            } else {
                // Jika belum ada -> Lakukan Insert Baru
                DB::table('medical_poli_template_setting')->insert([
                    'poli_id'        => $request->poli_id,
                    'jenis_template' => $request->jenis_template,
                    'menu_aktif'     => $menuAktif, // Simpan konfigurasi menu aktif
                    'keterangan'     => $request->keterangan,
                    'is_active'      => 1,
                    'created_at'     => now(),
                    'updated_at'     => now()
                ]);
            }

            // 4. Kembalikan response JSON karena request menggunakan AJAX
            return response()->json([
                'success' => true,
                'message' => 'Konfigurasi template dan menu poliklinik berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            // Tangkap error jika terjadi masalah pada database
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
}
