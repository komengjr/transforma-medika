<?php

namespace App\Http\Controllers;

use App\Exports\DoctorTemplateExport;
use App\Imports\DataHargaPenjualan;
use App\Imports\DoctorImport;
use App\Imports\MasterDoctorImport;
use App\Imports\PesertaAllImport;
use App\Imports\PesertaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;
use Session;

class MasterDataController extends Controller
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
    // MASTER DOKTER
    public function master_doctor_data_doctor(Request $request, $akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Ambil data spesialis untuk filter dropdown di halaman utama
            $listSpesialis = DB::table('medical_master_spesialis')->where('is_active', 1)->get();

            return view('application.master-data.master-data-doctor', [
                'akses'         => $akses,
                'code'          => $id,
                'listSpesialis' => $listSpesialis // Lempar ke view utama
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_doctor_get_data(Request $request)
    {
        // Tangkap parameter bawaan dari DataTables
        $draw = $request->input('draw');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $searchValue = $request->input('search.value');

        // Tangkap parameter filter custom
        $status = $request->input('status');
        $filterSpesialis = $request->input('spesialis');
        $query = DB::table('medical_master_doctor as d')
            ->leftJoin('medical_master_spesialis as s', 'd.kode_spesialis', '=', 's.kode_spesialis')
            ->select('d.*', 's.nama_spesialis');

        // Hitung total seluruh data tanpa filter
        $totalRecords = $query->count();

        // Terapkan Filter Status Keaktifan (Gunakan d.is_active untuk menghindari ambiguous column)
        if ($status !== null && $status !== '') {
            $query->where('d.is_active', $status);
        }
        // Filter Spesialisasi Baru
        if ($filterSpesialis !== null && $filterSpesialis !== '') {
            $query->where('d.kode_spesialis', $filterSpesialis);
        }
        // Terapkan Global Search
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('d.kode_dokter', 'like', "%{$searchValue}%")
                    ->orWhere('d.nama_lengkap', 'like', "%{$searchValue}%")
                    ->orWhere('s.nama_spesialis', 'like', "%{$searchValue}%") // Pencarian spesialis
                    ->orWhere('d.nik', 'like', "%{$searchValue}%");
            });
        }

        // Hitung total data setelah filter pencarian
        $filteredRecords = $query->count();

        // Terapkan Paginasi (Offset & Limit)
        if ($length > 0) {
            $query->skip($start)->take($length);
        }

        // Ambil data (Gunakan d.id untuk menghindari ambiguous column)
        $doctors = $query->orderBy('d.id', 'desc')->get();

        // Format data menjadi array yang berisi string HTML untuk dilempar ke DataTables
        $data = [];
        $no = $start + 1;

        foreach ($doctors as $row) {
            // Gunakan nama_spesialis dari hasil JOIN
            $namaSpesialis = $row->nama_spesialis ?? 'Belum Diatur';
            $spesialisasiBadge = '<span class="badge bg-soft-info text-info">' . $namaSpesialis . '</span>';

            $noTelp = $row->no_telp ? '<span class="fas fa-phone me-1 text-primary fs--2"></span> ' . $row->no_telp : '<span class="text-400">-</span>';

            $statusBadge = $row->is_active
                ? '<span class="badge bg-success">Aktif</span>'
                : '<span class="badge bg-secondary">Non-Aktif</span>';

            $aksi = '
        <div class="btn-group" role="group">
            <button class="btn btn-sm btn-falcon-default dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="fas fa-cog"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-doctor" id="button-edit-doctor" data-code="' . $row->kode_dokter . '">
                    <span class="fas fa-edit me-2 text-info"></span> Edit Data Dokter
                </button>
                <div class="dropdown-divider"></div>
                <button class="dropdown-item text-danger" id="button-delete-doctor" data-code="' . $row->kode_dokter . '">
                    <span class="fas fa-trash-alt me-2"></span> Hapus Dokter
                </button>
            </div>
        </div>';

            $data[] = [
                'DT_RowIndex'  => '<div class="text-center fw-bold">' . $no++ . '</div>',
                'kode_dokter'  => '<span class="badge bg-soft-primary text-primary fs--2">' . $row->kode_dokter . '</span>',
                'nama_lengkap' => $row->nama_lengkap, // Kirim teks aslinya agar di-render oleh JS bersama foto
                'foto'         => $row->foto,         // WAJIB ditambahkan untuk fungsi render foto di JS
                'spesialisasi' => $spesialisasiBadge,
                'sip'          => $row->sip ?? '-',
                'no_telp'      => $noTelp,
                'is_active'    => $statusBadge,
                'aksi'         => '<div class="text-center">' . $aksi . '</div>'
            ];
        }

        // Kembalikan Response JSON sesuai struktur yang dikenali DataTables
        return response()->json([
            "draw"            => intval($draw),
            "recordsTotal"    => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data"            => $data
        ]);
    }
    public function master_doctor_data_doctor_import(Request $request)
    {
        // Validasi file (harus berupa excel/csv dan maksimal 5MB)
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:5120'
        ]);

        try {
            if ($request->hasFile('file_excel')) {
                $file = $request->file('file_excel');

                // Proses import menggunakan class MasterDoctorImport
                Excel::import(new MasterDoctorImport, $file);

                return response()->json([
                    'success' => true,
                    'message' => 'Data dokter berhasil diimport!'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengimport data: ' . $e->getMessage()
            ]);
        }
    }
    public function master_doctor_download_template(Request $request)
    {
        $fileName = 'Template_Import_Dokter_' . date('Ymd_His') . '.xlsx';

        return Excel::download(new DoctorTemplateExport, $fileName);
    }
    public function master_doctor_data_doctor_add(Request $request)
    {
        $code = $request->get('code', 0);
        $doctor = null;


        $doctor = DB::table('medical_master_doctor')->where('kode_dokter', $code)->first();

        // Ambil data daftar spesialisasi yang aktif
        $listSpesialis = DB::table('medical_master_spesialis')->where('is_active', 1)->get();

        return view('application.master-data.data-doctor.form-add', [
            'doctor'        => $doctor,
            'code'          => $code,
            'listSpesialis' => $listSpesialis // Lempar ke view
        ]);
    }
    public function master_doctor_data_doctor_save(Request $request)
    {
        try {
            $code = $request->input('kode_dokter');

            $namaLengkap = $request->input('nama_lengkap');
            if (empty($namaLengkap)) {
                $awal  = $request->input('awal', '');
                $name  = $request->input('name', '');
                $akhir = $request->input('akhir', '');
                $namaLengkap = trim(($awal ? $awal . ' ' : '') . $name . ($akhir ? ', ' . $akhir : ''));
            }

            $dataSimpan = [
                'nama_lengkap'  => $namaLengkap,
                'jenis_kelamin' => $request->input('jenis_kelamin') ?? $request->input('jk'),
                'nik'           => $request->input('nik'),
                'sip'           => $request->input('sip'),
                'kode_spesialis' => $request->input('kode_spesialis'),
                'email'         => $request->input('email'),
                'no_telp'       => $request->input('no_telp') ?? $request->input('no_hp'),
                'is_active'     => $request->input('is_active', 1),
                'alamat'        => $request->input('alamat'),
                'updated_at'    => now(),
            ];

            // Proses Upload Foto Jika Ada
            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                $file->storeAs('public/doctors', $fileName);
                $dataSimpan['foto'] = $fileName;
            }

            if ($code) {
                DB::table('medical_master_doctor')->where('kode_dokter', $code)->update($dataSimpan);
                $pesan = 'Data dokter berhasil diperbarui!';
            } else {
                $lastDoctor = DB::table('medical_master_doctor')->orderBy('id', 'desc')->first();
                $nextId = $lastDoctor ? $lastDoctor->id + 1 : 1;
                $dataSimpan['kode_dokter'] = 'DR-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
                $dataSimpan['created_at']  = now();

                DB::table('medical_master_doctor')->insert($dataSimpan);
                $pesan = 'Data dokter baru berhasil ditambahkan!';
            }

            // KEMBALIKAN SEBAGAI JSON
            return response()->json([
                'success' => true,
                'message' => $pesan
            ]);
        } catch (\Exception $e) {
            // Tangkap Error Database dan Kembalikan JSON Error
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ]);
        }
    }
    // MASTER DOKTER POLIKLINIK
    public function master_doctor_poliklinik($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // View hanya melempar akses dan code, data ditarik via AJAX
            return view('application.master-data.master-doctor-poliklinik', [
                'akses' => $akses,
                'code' => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_doctor_poliklinik_list()
    {
        try {
            // Ambil poli yang aktif
            $data = DB::table('medical_master_poli')->where('is_active', true)->get();
            return response()->json(['status' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // --- 3. AJAX GET DOCTOR (MAPPED & AVAILABLE) ---
    public function master_doctor_poliklinik_get_doctor(Request $request)
    {
        try {
            $poli_id = $request->poli_id;

            // A. Ambil dokter yang SUDAH ter-mapping ke poli ini
            $mapped_doctors = DB::table('medical_poli_dokter')
                ->join('medical_master_doctor', 'medical_master_doctor.id', '=', 'medical_poli_dokter.doctor_id')
                ->where('medical_poli_dokter.poli_id', $poli_id)
                ->whereNull('medical_master_doctor.deleted_at') // Abaikan dokter yang di-soft-delete
                ->select(
                    'medical_poli_dokter.id as mapping_id', // ID dari tabel pivot untuk dihapus nanti
                    'medical_master_doctor.id as doctor_id',
                    'medical_master_doctor.kode_dokter',
                    'medical_master_doctor.nik',
                    'medical_master_doctor.nama_lengkap'
                )
                ->get();

            $mapped_doctor_ids = $mapped_doctors->pluck('doctor_id')->toArray();

            // B. Ambil dokter yang BELUM ter-mapping (Tersedia)
            $available_doctors = DB::table('medical_master_doctor')
                ->where('is_active', true)
                ->whereNull('deleted_at');

            if (!empty($mapped_doctor_ids)) {
                $available_doctors->whereNotIn('id', $mapped_doctor_ids);
            }

            $available_doctors = $available_doctors->get();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'mapped_doctors' => $mapped_doctors,
                    'available_doctors' => $available_doctors
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    public function master_doctor_poliklinik_add(Request $request)
    {
        return view('application.master-data.data-doctor-poli.form-add');
    }
    public function master_doctor_poliklinik_save(Request $request)
    {
        try {
            if (empty($request->poli_id) || empty($request->doctor_id)) {
                return response()->json(['status' => 'error', 'message' => 'Poli atau Dokter tidak boleh kosong!']);
            }

            // Insert ke tabel pivot medical_poli_dokter
            DB::table('medical_poli_dokter')->insert([
                'poli_id'    => $request->poli_id,
                'doctor_id'  => $request->doctor_id,
                'created_at' => now(),
                'updated_at' => now(),
                // hari_praktek, jam_praktek, kuota_pasien akan menggunakan nilai null/default dari database
            ]);

            return response()->json(['status' => 'success', 'message' => 'Dokter berhasil ditambahkan ke Poliklinik!']);
        } catch (\Exception $e) {
            // Tangani error duplikat jika tabel memiliki unique constraint ['poli_id', 'doctor_id']
            if ($e->getCode() == 23000) {
                return response()->json(['status' => 'error', 'message' => 'Dokter ini sudah terdaftar di Poliklinik tersebut.']);
            }
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
        }
    }

    // --- 5. AJAX HAPUS MAPPING ---
    public function master_doctor_poliklinik_remove(Request $request)
    {
        try {
            DB::table('medical_poli_dokter')->where('id', $request->mapping_id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Dokter berhasil dikeluarkan dari Poliklinik!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal menghapus: ' . $e->getMessage()], 500);
        }
    }
    public function master_doctor_poliklinik_pilih_dokter(Request $request)
    {
        $data = DB::table('master_doctor')->get();
        return view('application.master-data.data-doctor-poli.form-add-doctor', ['data' => $data, 'code' => $request->code]);
    }
    public function master_doctor_poliklinik_pilih_dokter_save(Request $request)
    {
        $cek = DB::table('m_doctor_poli')->where('master_doctor_code', $request->dokter)->first();
        if ($cek) {
            return redirect()->back()->withError('Filed! Gagal Menambahkan Data Dokter');
        } else {
            DB::table('m_doctor_poli')->insert([
                'm_doctor_poli_code' => str::uuid(),
                't_layanan_data_code' => $request->code,
                'master_doctor_code' => $request->dokter,
                'created_at' => now()
            ]);
            return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Dokter');
        }
    }
    // MASTER JADWAL DOKTER
    public function master_jadwal_doctor_poliklinik($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Menggunakan tabel medical_master_poli sesuai struktur database terbaru
            $poliklinik = DB::table('medical_master_poli')
                ->select('id', 'kode_poli', 'nama_poli')
                ->where('is_active', true)
                ->orderBy('nama_poli', 'asc')
                ->get();

            return view('application.master-data.master-doctor-poli-jadwal', [
                'akses' => $akses,
                'poliklinik' => $poliklinik,
                'code' => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_jadwal_doctor_poliklinik_getSchedules(Request $request)
    {
        try {
            // Asumsi nama tabel jadwal Anda yang baru adalah 'medical_jadwal_dokter'
            $query = DB::table('medical_jadwal_dokter')
                ->join('medical_master_poli', 'medical_jadwal_dokter.poli_id', '=', 'medical_master_poli.id')
                ->join('medical_master_doctor', 'medical_jadwal_dokter.doctor_id', '=', 'medical_master_doctor.id')
                ->select(
                    'medical_jadwal_dokter.id as id_schedule',
                    'medical_jadwal_dokter.day_name',
                    'medical_jadwal_dokter.time_start',
                    'medical_jadwal_dokter.time_end',
                    'medical_jadwal_dokter.quota',
                    'medical_jadwal_dokter.is_active',
                    'medical_master_poli.nama_poli',
                    'medical_master_doctor.nama_lengkap',
                    'medical_master_doctor.kode_dokter'
                )
                ->whereNull('medical_master_doctor.deleted_at'); // Abaikan dokter yang ter-soft delete

            // Filter by Poliklinik ID
            if ($request->filled('poli_id')) {
                $query->where('medical_jadwal_dokter.poli_id', $request->poli_id);
            }

            // Filter by Hari
            if ($request->filled('day_name')) {
                $query->where('medical_jadwal_dokter.day_name', $request->day_name);
            }

            $schedules = $query->orderBy('medical_jadwal_dokter.time_start', 'asc')->get();

            // Ubah is_active boolean menjadi text 'AKTIF'/'NON-AKTIF' untuk UI
            foreach ($schedules as $schedule) {
                $schedule->status = $schedule->is_active ? 'AKTIF' : 'NON-AKTIF';
            }

            return response()->json([
                'status' => 'success',
                'data'   => $schedules
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengambil data jadwal: ' . $e->getMessage(),
                'data'    => []
            ], 500);
        }
    }

    /**
     * AJAX: Get Daftar Dokter berdasarkan Poliklinik
     */
    public function master_jadwal_doctor_poliklinik_getDoctorsByPoli(Request $request)
    {
        try {
            $query = DB::table('medical_poli_dokter')
                ->join('medical_master_doctor', 'medical_poli_dokter.doctor_id', '=', 'medical_master_doctor.id')
                ->select(
                    'medical_master_doctor.id as doctor_id',
                    'medical_master_doctor.nama_lengkap',
                    'medical_master_doctor.kode_dokter'
                )
                ->whereNull('medical_master_doctor.deleted_at');

            if ($request->filled('poli_id')) {
                $query->where('medical_poli_dokter.poli_id', $request->poli_id);
            }

            $doctors = $query->get();

            return response()->json([
                'status' => 'success',
                'data'   => $doctors
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengambil data dokter: ' . $e->getMessage(),
                'data'    => []
            ], 500);
        }
    }

    /**
     * AJAX: Simpan Jadwal Baru
     */
    public function master_jadwal_doctor_poliklinik_saveSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'poli_id'    => 'required|exists:medical_master_poli,id',
            'doctor_id'  => 'required|exists:medical_master_doctor,id',
            'day_name'   => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'time_start' => 'required|date_format:H:i',
            'time_end'   => 'required|date_format:H:i|after:time_start',
            'quota'      => 'required|integer|min:1',
        ], [
            'poli_id.required'    => 'Poliklinik wajib dipilih.',
            'doctor_id.required'  => 'Dokter wajib dipilih.',
            'day_name.required'   => 'Hari wajib dipilih.',
            'time_start.required' => 'Jam mulai wajib diisi.',
            'time_end.required'   => 'Jam selesai wajib diisi.',
            'time_end.after'      => 'Jam selesai harus lebih besar dari jam mulai.',
            'quota.required'      => 'Kuota wajib diisi.',
            'quota.min'           => 'Kuota minimal 1 pasien.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            // Pengecekan Bentrok Jadwal (Overlap) pada dokter dan hari yang sama
            $isOverlapping = DB::table('medical_jadwal_dokter')
                ->where('doctor_id', $request->doctor_id)
                ->where('day_name', $request->day_name)
                ->where('is_active', true)
                ->where(function ($query) use ($request) {
                    $query->where('time_start', '<', $request->time_end)
                        ->where('time_end', '>', $request->time_start);
                })
                ->exists();

            if ($isOverlapping) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Jadwal dokter pada jam tersebut sudah ada yang bentrok.'
                ], 422);
            }

            // Simpan Jadwal
            $insertedId = DB::table('medical_jadwal_dokter')->insertGetId([
                'poli_id'    => $request->poli_id,
                'doctor_id'  => $request->doctor_id,
                'day_name'   => $request->day_name,
                'time_start' => $request->time_start,
                'time_end'   => $request->time_end,
                'quota'      => $request->quota,
                'is_active'  => true, // Default aktif
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Jadwal dokter berhasil ditambahkan!',
                'id'      => $insertedId
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan jadwal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * AJAX: Hapus Jadwal
     */
    public function master_jadwal_doctor_poliklinik_remove(Request $request)
    {
        $request->validate([
            'id_schedule' => 'required'
        ]);

        try {
            $deleted = DB::table('medical_jadwal_dokter')
                ->where('id', $request->id_schedule)
                ->delete();

            if ($deleted) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Jadwal berhasil dihapus!'
                ], 200);
            }

            return response()->json([
                'status'  => 'error',
                'message' => 'Jadwal tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menghapus jadwal: ' . $e->getMessage()
            ], 500);
        }
    }
    // MASTER KATEGORI DOKTER
    public function master_pemeriksaan_category($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('t_pemeriksaan_cat')->get();
            return view('application.master-data.master-pemeriksaan-category', ['akses' => $akses, 'data' => $data, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_pemeriksaan_category_add(Request $request)
    {
        return view('application.master-data.pemeriksaan-category.form-add');
    }
    public function master_pemeriksaan_category_save(Request $request)
    {
        $no = DB::table('t_pemeriksaan_cat')->count();
        DB::table('t_pemeriksaan_cat')->insert([
            't_pemeriksaan_cat_code' => 'PEM' . str_pad($no + 1, 4, '0', STR_PAD_LEFT),
            't_pemeriksaan_cat_name' => $request->nama,
            't_pemeriksaan_cat_status' => 1,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Kategori Pemeriksaan');
    }
    // MASTER DATA PEMERIKSAAN
    public function master_pemeriksaan_data($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Mengambil daftar Tipe Layanan untuk Dropdown Filter
            $tipe_layanan = DB::table('medical_tipe_layanan')
                ->where('is_active', true)
                ->orderBy('nama_tipe', 'asc')
                ->get();

            // Mengambil data Master Pemeriksaan
            $data = DB::table('medical_master_pemeriksaan')
                ->join('medical_tipe_layanan', 'medical_tipe_layanan.id', '=', 'medical_master_pemeriksaan.tipe_layanan_id')
                ->select(
                    'medical_master_pemeriksaan.*',
                    'medical_tipe_layanan.nama_tipe'
                )
                ->orderBy('medical_master_pemeriksaan.kode_layanan', 'asc')
                ->get();

            return view('application.master-data.master-pemeriksaan-data', [
                'akses' => $akses,
                'data' => $data,
                'tipe_layanan' => $tipe_layanan, // Kirim ke View
                'code' => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_pemeriksaan_data_add(Request $request)
    {
        // Mengambil master kategori/tipe layanan yang aktif
        $cat = DB::table('medical_tipe_layanan')->where('is_active', true)->get();

        return view('application.master-data.pemeriksaan-data.form-add', [
            'cat' => $cat
        ]);
    }
    public function master_pemeriksaan_data_save(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'tipe_layanan_id' => 'required',
            'nama_layanan'    => 'required',
            'harga'           => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            // 2. Ambil prefix dari tabel Tipe Layanan
            $tipeLayanan = DB::table('medical_tipe_layanan')
                ->where('id', $request->tipe_layanan_id)
                ->first();

            if (!$tipeLayanan) {
                return response()->json(['status' => 'error', 'message' => 'Tipe Layanan tidak valid.'], 404);
            }

            $prefix = $tipeLayanan->prefix;

            // 3. Generate Kode Layanan Berurutan
            $lastData = DB::table('medical_master_pemeriksaan')
                ->where('kode_layanan', 'LIKE', $prefix . '-%')
                ->orderBy('kode_layanan', 'desc')
                ->first();

            if ($lastData) {
                $lastNumber = (int) substr($lastData->kode_layanan, strlen($prefix) + 1);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            $newKodeLayanan = $prefix . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

            // 4. Insert data ke Database
            $insertId = DB::table('medical_master_pemeriksaan')->insertGetId([
                'kode_layanan'         => $newKodeLayanan,
                'tipe_layanan_id'      => $request->tipe_layanan_id,
                'nama_layanan'         => $request->nama_layanan,
                'is_paket'             => $request->is_paket,
                'harga'                => $request->harga,
                'estimasi_waktu_menit' => $request->estimasi_waktu_menit ?? 15,
                'is_active'            => true,
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);

            // 5. Ambil data yang baru disimpan beserta nama tipe layanannya untuk di-render di tabel front-end
            $newData = DB::table('medical_master_pemeriksaan')
                ->join('medical_tipe_layanan', 'medical_tipe_layanan.id', '=', 'medical_master_pemeriksaan.tipe_layanan_id')
                ->where('medical_master_pemeriksaan.id', $insertId)
                ->select('medical_master_pemeriksaan.*', 'medical_tipe_layanan.nama_tipe')
                ->first();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data Pemeriksaan berhasil ditambahkan!',
                'data'    => $newData
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi Kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    public function master_pemeriksaan_download_template()
    {
        // Pastikan Anda sudah meletakkan file Template_Import_Pemeriksaan.xlsx
        // yang baru diunduh ke dalam folder: public/template/
        $filepath = public_path('template/Template_Import_Pemeriksaan.xlsx');

        if (file_exists($filepath)) {
            return response()->download($filepath);
        }

        return redirect()->back()->with('error', 'File template tidak ditemukan di server.');
    }

    /**
     * Method untuk memproses data Import Excel
     */
    public function master_pemeriksaan_import(Request $request)
    {
        // 1. Validasi file
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ], [
            'file_excel.required' => 'File Excel wajib diunggah.',
            'file_excel.mimes'    => 'Format file harus berupa Excel (.xlsx / .csv).'
        ]);

        try {
            $file = $request->file('file_excel');

            // 2. Baca isi file excel ke dalam bentuk Array
            $dataExcel = Excel::toArray([], $file);
            $rows = $dataExcel[0]; // Mengambil sheet pertama

            // Hapus baris pertama (Index 0) karena itu adalah Header Tabel
            unset($rows[0]);

            $jumlahBerhasil = 0;

            foreach ($rows as $row) {
                $tipe_layanan_id = $row[0] ?? null;
                $nama_layanan    = $row[1] ?? null;
                $is_paket        = $row[2] ?? 0;
                $harga           = $row[3] ?? 0;
                $estimasi        = $row[4] ?? 15;

                // Abaikan baris jika ID Tipe atau Nama Layanan kosong
                if (empty($tipe_layanan_id) || empty($nama_layanan)) {
                    continue;
                }

                // 3. Ambil Prefix berdasarkan Tipe Layanan ID
                $tipeLayanan = DB::table('medical_tipe_layanan')->where('id', $tipe_layanan_id)->first();

                if (!$tipeLayanan) {
                    continue; // Skip jika tipe layanan tidak ada di database
                }

                $prefix = $tipeLayanan->prefix;

                // 4. Generate Kode Layanan Otomatis
                $lastData = DB::table('medical_master_pemeriksaan')
                    ->where('kode_layanan', 'LIKE', $prefix . '-%')
                    ->orderBy('kode_layanan', 'desc')
                    ->first();

                if ($lastData) {
                    $lastNumber = (int) substr($lastData->kode_layanan, strlen($prefix) + 1);
                    $newNumber = $lastNumber + 1;
                } else {
                    $newNumber = 1;
                }

                $newKodeLayanan = $prefix . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

                // 5. Simpan ke database
                DB::table('medical_master_pemeriksaan')->insert([
                    'kode_layanan'         => $newKodeLayanan,
                    'tipe_layanan_id'      => $tipe_layanan_id,
                    'nama_layanan'         => $nama_layanan,
                    'is_paket'             => $is_paket,
                    'harga'                => $harga,
                    'estimasi_waktu_menit' => $estimasi,
                    'is_active'            => true,
                    'created_at'           => now(),
                    'updated_at'           => now(),
                ]);

                $jumlahBerhasil++;
            }

            return response()->json([
                'status'  => 'success',
                'message' => "Import selesai! Sebanyak $jumlahBerhasil data berhasil ditambahkan."
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat memproses import: ' . $e->getMessage()
            ], 500);
        }
    }
    // MASTER GROUP PEMERIKSAAN
    public function master_pemeriksaan_group($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('t_pemeriksaan_data')
                ->join('t_pemeriksaan_cat', 't_pemeriksaan_cat.t_pemeriksaan_cat_code', '=', 't_pemeriksaan_data.t_pemeriksaan_cat_code')
                ->get();
            $layanan = DB::table('t_pemeriksaan_cat')->get();
            return view('application.master-data.master-setting-pemeriksaan', ['akses' => $akses, 'data' => $data, 'layanan' => $layanan, 'code' => $id]);
            // return view('application.master-data.master-pemeriksaan-group', ['akses' => $akses, 'data' => $data, 'layanan' => $layanan, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_pemeriksaan_group_layanan(Request $request)
    {
        $data = DB::table('t_pemeriksaan_data')->where('t_pemeriksaan_cat_code', $request->code)->get();
        return view('application.master-data.pemeriksaan-group.option-pemeriksaan', ['data' => $data]);
    }
    public function master_pemeriksaan_group_pilih_pemeriksaan(Request $request)
    {
        $data = DB::table('t_pemeriksaan_list')->where('t_pemeriksaan_data_code', $request->code)->get();
        return view('application.master-data.pemeriksaan-group.data-table-pemeriksaan', ['code' => $request->code, 'data' => $data]);
    }
    public function master_pemeriksaan_group_add_pemeriksaan(Request $request)
    {
        return view('application.master-data.pemeriksaan-group.form-add-list-pemeriksaan', ['code' => $request->code]);
    }
    public function master_pemeriksaan_group_add_pemeriksaan_save(Request $request)
    {
        $no = DB::table('t_pemeriksaan_list')->where('t_pemeriksaan_data_code', $request->code)->count();
        DB::table('t_pemeriksaan_list')->insert([
            't_pemeriksaan_list_code' => $request->code . str_pad($no + 1, 5, '0', STR_PAD_LEFT),
            't_pemeriksaan_data_code' => $request->code,
            't_pemeriksaan_list_name' => $request->name,
            't_pemeriksaan_list_option' => $request->jenis,
            't_pemeriksaan_list_type' => $request->type,
            't_pemeriksaan_list_status' => 1,
            'created_at' => now(),
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data List Pemeriksaan');
    }
    public function master_pemeriksaan_group_add_value_pemeriksaan(Request $request)
    {
        $alat = DB::table('medical_master_alat')->get();
        return view('application.master-data.pemeriksaan-group.form-add-value', compact('alat'), ['code' => $request->code]);
    }
    public function master_pemeriksaan_group_add_value_pemeriksaan_save(Request $request)
    {
        $no = DB::table('t_pemeriksaan_list_val')->where('t_pemeriksaan_list_code', $request->code)->count();
        DB::table('t_pemeriksaan_list_val')->insert([
            't_pem_list_val_code' => $request->code . str_pad($no + 1, 5, '0', STR_PAD_LEFT),
            't_pemeriksaan_list_code' => $request->code,
            't_pem_list_val_name' => $request->name,
            't_pem_list_val_nilai' => 0,
            't_pem_list_val_rujukan' => $request->rujukan,
            't_pem_list_val_satuan' => $request->satuan,
            't_pem_list_val_instrumen' => $request->instrumen,
            't_pem_list_val_param' => $request->parameter,
            'created_at' => now(),
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data List Pemeriksaan');
    }
    // MASTER HARGA PEMERIKSAAN
    public function master_pemeriksaan_harga($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Ambil Data Penjamin Utama
            $penjaminList = DB::table('medical_penjamin')->orderBy('nama_penjamin', 'asc')->get();

            // Ambil Data Tipe Layanan (Laboratorium, Radiologi, dll)
            $tipeLayananList = DB::table('medical_tipe_layanan')->where('is_active', true)->get();

            // Ambil List Master Pemeriksaan yang aktif
            $pemeriksaanList = DB::table('medical_master_pemeriksaan')
                ->where('is_active', true)
                ->select('id', 'kode_layanan', 'nama_layanan', 'harga', 'is_paket')
                ->get();

            return view('application.master-data.master-pemeriksaan-harga', compact(
                'penjaminList',
                'tipeLayananList',
                'pemeriksaanList',
                'akses',
            ), ['code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function getSubPenjamin($penjamin_id)
    {
        $subPenjamin = DB::table('medical_sub_penjamin')
            ->where('penjamin_id', $penjamin_id)
            ->get();
        return response()->json($subPenjamin);
    }

    // AJAX: Ambil Data Harga & Diskon Pemeriksaan berdasarkan Sub Penjamin & Tipe Layanan
    public function getPenjaminPemeriksaanFilter(Request $request)
    {
        $sub_penjamin_id = $request->sub_penjamin_id;
        $tipe_layanan_id = $request->tipe_layanan_id;

        if (!$sub_penjamin_id) {
            return response()->json([]);
        }

        $query = DB::table('medical_penjamin_pemeriksaan')
            ->join('medical_master_pemeriksaan', 'medical_penjamin_pemeriksaan.master_pemeriksaan_id', '=', 'medical_master_pemeriksaan.id')
            ->join('medical_tipe_layanan', 'medical_master_pemeriksaan.tipe_layanan_id', '=', 'medical_tipe_layanan.id')
            ->where('medical_penjamin_pemeriksaan.sub_penjamin_id', $sub_penjamin_id)
            ->select(
                'medical_penjamin_pemeriksaan.*',
                'medical_master_pemeriksaan.id as master_pemeriksaan_id',
                'medical_master_pemeriksaan.kode_layanan',
                'medical_master_pemeriksaan.nama_layanan',
                'medical_master_pemeriksaan.harga as harga_dasar',
                'medical_master_pemeriksaan.is_paket',
                'medical_tipe_layanan.nama_tipe',
                'medical_tipe_layanan.prefix'
            );

        if ($tipe_layanan_id) {
            $query->where('medical_master_pemeriksaan.tipe_layanan_id', $tipe_layanan_id);
        }

        $data = $query->get();

        // Ambil detail item jika pemeriksaan tersebut adalah paket
        foreach ($data as $item) {
            if ($item->is_paket) {
                $item->package_items = DB::table('medical_paket_detail')
                    ->join('medical_master_pemeriksaan', 'medical_paket_detail.pemeriksaan_id', '=', 'medical_master_pemeriksaan.id')
                    ->where('medical_paket_detail.paket_id', $item->master_pemeriksaan_id)
                    ->select('medical_master_pemeriksaan.kode_layanan', 'medical_master_pemeriksaan.nama_layanan')
                    ->get();
            } else {
                $item->package_items = [];
            }
        }

        return response()->json($data);
    }

    // AJAX: Simpan / Update Harga & Diskon Penjamin Pemeriksaan
    public function storePenjaminPemeriksaan(Request $request)
    {
        $request->validate([
            'sub_penjamin_id'       => 'required|exists:medical_sub_penjamin,id',
            'master_pemeriksaan_id' => 'required|exists:medical_master_pemeriksaan,id',
            'diskon'                => 'nullable' // Dibuat nullable agar bebas dari error validasi string format rupiah
        ]);

        // Membersihkan format titik pemisah ribuan (contoh: "150.000" menjadi "150000")
        $rawDiskon = $request->diskon;
        if (!is_null($rawDiskon) && $rawDiskon !== '') {
            $rawDiskon = str_replace(['.', ','], ['', '.'], $rawDiskon);
            $rawDiskon = floatval($rawDiskon);
        } else {
            $rawDiskon = 0;
        }

        // Mengecek apakah data relasi penjamin & pemeriksaan sudah ada
        $exists = DB::table('medical_penjamin_pemeriksaan')
            ->where('sub_penjamin_id', $request->sub_penjamin_id)
            ->where('master_pemeriksaan_id', $request->master_pemeriksaan_id)
            ->exists();

        if ($exists) {
            // Proses UPDATE jika sudah ada
            DB::table('medical_penjamin_pemeriksaan')
                ->where('sub_penjamin_id', $request->sub_penjamin_id)
                ->where('master_pemeriksaan_id', $request->master_pemeriksaan_id)
                ->update([
                    'diskon'     => $rawDiskon,
                    'updated_at' => now()
                ]);
            $message = 'Diskon/Tarif pemeriksaan penjamin berhasil diperbarui.';
        } else {
            // Proses INSERT jika belum ada
            DB::table('medical_penjamin_pemeriksaan')->insert([
                'sub_penjamin_id'       => $request->sub_penjamin_id,
                'master_pemeriksaan_id' => $request->master_pemeriksaan_id,
                'diskon'                => $rawDiskon,
                'created_at'            => now(),
                'updated_at'            => now()
            ]);
            $message = 'Diskon/Tarif pemeriksaan penjamin berhasil disimpan.';
        }

        return response()->json([
            'status'  => 'success',
            'message' => $message
        ]);
    }

    // AJAX: Simpan Detail Item Paket (`medical_paket_detail`)
    public function savePackageItems(Request $request)
    {
        $request->validate([
            'master_pemeriksaan_id' => 'required|exists:medical_master_pemeriksaan,id',
            'items'                 => 'required|array',
            'items.*'               => 'exists:medical_master_pemeriksaan,id'
        ]);

        $paket_id = $request->master_pemeriksaan_id;

        // Hapus item paket lama
        DB::table('medical_paket_detail')->where('paket_id', $paket_id)->delete();

        // Masukkan item paket baru
        $insertData = [];
        foreach ($request->items as $pemeriksaan_id) {
            $insertData[] = [
                'paket_id'       => $paket_id,
                'pemeriksaan_id' => $pemeriksaan_id,
                'created_at'     => now(),
                'updated_at'     => now()
            ];
        }

        if (!empty($insertData)) {
            DB::table('medical_paket_detail')->insert($insertData);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Detail items pemeriksaan paket berhasil disimpan.'
        ]);
    }

    // AJAX: Ambil Item Paket berdasarkan Master Pemeriksaan ID
    public function getPackageItems($master_pemeriksaan_id)
    {
        $items = DB::table('medical_paket_detail')
            ->where('paket_id', $master_pemeriksaan_id)
            ->pluck('pemeriksaan_id');
        return response()->json($items);
    }
    public function master_pemeriksaan_harga_master(Request $request)
    {
        $data = DB::table('p_pemeriksaan')->where('p_m_pemeriksaan_code', $request->code)->get();
        return view('application.master-data.pemeriksaan-harga.form-paket-pemeriksaan', ['data' => $data]);
    }
    public function master_pemeriksaan_harga_group(Request $request)
    {
        $data = DB::table('p_pemeriksaan')->where('p_m_pemeriksaan_code', $request->code)->get();
        $layanan = DB::table('t_layanan_cat')->get();
        return view('application.master-data.pemeriksaan-harga.data-gorup-pemeriksaan', ['data' => $data, 'layanan' => $layanan]);
    }
    // MASTER SPECIMEN PEMERIKSAAN
    public function master_pemeriksaan_specimen($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $cat = DB::table('medical_tipe_layanan')->where('is_active', true)->get();

            // Tambahkan ->where('medical_master_pemeriksaan.is_paket', 0) di sini
            $data = DB::table('medical_master_pemeriksaan')
                ->join('medical_tipe_layanan', 'medical_tipe_layanan.id', '=', 'medical_master_pemeriksaan.tipe_layanan_id')
                ->where('medical_master_pemeriksaan.is_paket', 0) // <-- Filter hanya non-paket
                ->select(
                    'medical_master_pemeriksaan.*',
                    'medical_tipe_layanan.nama_tipe'
                )
                ->orderBy('medical_master_pemeriksaan.kode_layanan', 'asc')
                ->get();

            return view('application.master-data.master-pemeriksaan-specimen', [
                'data'  => $data,
                'cat'   => $cat,
                'akses' => $akses,
                'code'  => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_pemeriksaan_specimen_detail(Request $request)
    {
        // $request->code berisi ID dari medical_master_pemeriksaan yang dikirim via AJAX
        $master_pemeriksaan_id = $request->code;

        // Ambil semua daftar master spesimen yang aktif
        $specimen = DB::table('medical_specimen_data')
            ->where('is_active', true)
            ->get();

        // Ambil data spesimen yang sudah terhubung ke pemeriksaan ini via tabel pivot medical_pem_specimen
        $data = DB::table('medical_pem_specimen')
            ->join('medical_specimen_data', 'medical_specimen_data.id', '=', 'medical_pem_specimen.specimen_data_id')
            ->where('medical_pem_specimen.master_pemeriksaan_id', $master_pemeriksaan_id)
            ->select('medical_pem_specimen.*', 'medical_specimen_data.s_specimen_data_name', 'medical_specimen_data.s_specimen_data_code')
            ->get();

        return view('application.master-data.pemeriksaan-specimen.data-specimen', [
            'specimen' => $specimen,
            'code'     => $master_pemeriksaan_id,
            'data'     => $data
        ]);
    }
    public function master_pemeriksaan_specimen_save(Request $request)
    {
        $master_pemeriksaan_id = $request->code;
        $specimen_data_id      = $request->specimen; // Berisi ID dari medical_specimen_data

        // Cek apakah spesimen sudah pernah ditambahkan ke pemeriksaan ini
        $exists = DB::table('medical_pem_specimen')
            ->where('master_pemeriksaan_id', $master_pemeriksaan_id)
            ->where('specimen_data_id', $specimen_data_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Specimen sudah terdaftar pada pemeriksaan ini.'
            ], 422);
        }

        // Simpan ke tabel pivot
        DB::table('medical_pem_specimen')->insert([
            'master_pemeriksaan_id' => $master_pemeriksaan_id,
            'specimen_data_id'      => $specimen_data_id,
            'created_at'            => now(),
            'updated_at'            => now()
        ]);

        // Ambil ulang data spesimen yang sudah terhubung untuk dirender kembali via AJAX
        $data = DB::table('medical_pem_specimen')
            ->join('medical_specimen_data', 'medical_specimen_data.id', '=', 'medical_pem_specimen.specimen_data_id')
            ->where('medical_pem_specimen.master_pemeriksaan_id', $master_pemeriksaan_id)
            ->select('medical_pem_specimen.*', 'medical_specimen_data.s_specimen_data_name')
            ->get();

        // Render HTML badge untuk dikembalikan ke frontend
        $html = '';
        foreach ($data as $datas) {
            $html .= '<span class="retro-badge me-1 mb-1" style="background-color: var(--retro-purple); color: var(--retro-dark); font-size: 0.75rem;"><i class="fas fa-vial me-1"></i> ' . $datas->s_specimen_data_name . '</span>';
        }

        return response($html);
    }
    // MASTER DATA PERUSAHAAN
    public function master_perusahaan_data($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('master_company')->get();
            return view('application.master-data.master-company', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // MASTER MOU PERUSAHAAN
    public function master_perusahaan_mou($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('company_mou')
                ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
                ->orderBy('id_company_mou', 'DESC')->get();
            return view('application.master-data.mou-company', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // MASTER AGREEMENT PERUSAHAAN
    public function master_perusahaan_agreement($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('company_mou_agreement')
                ->join('company_mou', 'company_mou.company_mou_code', '=', 'company_mou_agreement.company_mou_code')
                ->join('master_company', 'master_company.master_company_code', '=', 'company_mou.master_company_code')
                ->get();
            return view('application.master-data.agreement-perusahaan', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // MASTER LAYANAN KATEGORI
    public function master_layanan_category($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('t_layanan_cat')->get();
            return view('application.master-data.master-layanan-category', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_layanan_category_add(Request $request)
    {
        return view('application.master-data.layanan-category.form-add');
    }
    public function master_layanan_category_save(Request $request)
    {
        DB::table('t_layanan_cat')->insert([
            't_layanan_cat_code' => str::uuid(),
            't_layanan_cat_name' => $request->name,
            't_layanan_cat_status' => 1,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Kategori Layanan');
    }
    // MASTER LAYANAN DATA
    public function master_layanan_data($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('t_layanan_data')
                ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 't_layanan_data.t_layanan_cat_code')
                ->get();
            return view('application.master-data.master-layanan-data', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_layanan_data_add(Request $request)
    {
        $layanan = DB::table('t_layanan_cat')->get();
        return view('application.master-data.layanan-data.form-add', ['layanan' => $layanan]);
    }
    public function master_layanan_data_save(Request $request)
    {
        DB::table('t_layanan_data')->insert([
            't_layanan_data_code' => str::uuid(),
            't_layanan_cat_code' => $request->code,
            't_layanan_data_name' => $request->name,
            't_layanan_data_status' => 1,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Layanan');
    }
    // FORMULIR LAYANAN
    public function master_layanan_formulir($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('t_layanan_form')
                ->join('t_layanan_data', 't_layanan_data.t_layanan_data_code', '=', 't_layanan_form.t_layanan_data_code')
                ->get();
            // dd($data);
            return view('application.master-data.master-layanan-formulir', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_layanan_formulir_add(Request $request)
    {
        $layanan = DB::table('t_layanan_data')->get();
        return view('application.master-data.layanan-formulir.form-add', ['layanan' => $layanan]);
    }
    public function master_layanan_formulir_save(Request $request)
    {
        DB::table('t_layanan_form')->insert([
            't_layanan_form_code' => str::uuid(),
            't_layanan_data_code' => $request->code,
            't_layanan_form_name' => $request->name,
            't_layanan_form_jenis' => '-',
            't_layanan_form_type' => '-',
            't_layanan_form_status' => '1',
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Layanan');
    }
    public function master_layanan_formulir_add_field(Request $request)
    {
        return view('application.master-data.layanan-formulir.form-add-field', ['code' => $request->code]);
    }
    public function master_layanan_formulir_save_field(Request $request)
    {
        DB::table('t_layanan_form_f')->insert([
            't_layanan_form_f_code' => str::uuid(),
            't_layanan_form_code' => $request->code,
            't_layanan_form_f_name' => $request->name,
            't_layanan_form_f_type' => $request->type,
            't_layanan_form_f_number' => 0,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Layanan');
    }
    // MASTER PENJUALAN DATA
    public function master_penjualan_data($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('p_m_sales')->get();
            return view('application.master-data.master-penjualan-data', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_penjualan_data_master(Request $request)
    {
        $data = DB::table('p_sales')->where('p_m_sales_code', $request->code)->get();
        return view('application.master-data.penjualan-data.form-paket-penjualan', ['data' => $data]);
    }
    public function master_penjualan_data_group(Request $request)
    {
        $data = DB::table('p_sales_cat')
            ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'p_sales_cat.t_layanan_cat_code')
            ->where('p_sales_cat.p_sales_code', $request->code)->get();
        $layanan = DB::table('t_layanan_cat')->get();
        $harga = DB::table('p_sales_data')->join('p_sales_cat', 'p_sales_cat.p_sales_cat_code', '=', 'p_sales_data.p_sales_cat_code')
            ->join('p_sales', 'p_sales.p_sales_code', '=', 'p_sales_cat.p_sales_code')
            ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'p_sales_cat.t_layanan_cat_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('p_sales.p_sales_code', $request->code)->get();
        return view('application.master-data.penjualan-data.data-group-penjualan', ['data' => $data, 'code' => $request->code, 'harga' => $harga]);
    }
    public function master_penjualan_data_add(Request $request)
    {
        $data = DB::table('p_sales_cat')
            ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'p_sales_cat.t_layanan_cat_code')
            ->where('p_sales_cat.p_sales_cat_code', $request->id)->first();
        $pemeriksaan = DB::table('t_pemeriksaan_list')->get();
        return view('application.master-data.penjualan-data.form-add-data', [
            'code' => $request->code,
            'id' => $request->id,
            'data' => $data,
            'pemeriksaan' => $pemeriksaan
        ]);
    }
    public function master_penjualan_data_save(Request $request)
    {
        DB::table('p_sales_data')->insert([
            'p_sales_data_code' => str::uuid(),
            'p_sales_cat_code' => $request->code_kategori,
            'p_sales_data_name' => $request->name,
            't_pemeriksaan_list_code' => $request->name,
            'p_sales_data_type' => $request->type,
            'p_sales_data_price' => $request->price,
            'p_sales_data_disc' => $request->disc,
            'p_sales_data_desc' => $request->desc,
            'created_at' => now()
        ]);
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Layanan');
    }
    public function master_penjualan_data_import(Request $request)
    {
        $data = DB::table('p_sales_cat')
            ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'p_sales_cat.t_layanan_cat_code')
            ->where('p_sales_cat.p_sales_cat_code', $request->code)->first();
        return view('application.master-data.penjualan-data.form-import-data', ['code' => $request->code, 'data' => $data]);
    }
    public function master_penjualan_data_import_save(Request $request)
    {
        Excel::import(new DataHargaPenjualan($request->code), request()->file('file'));
        return redirect()->back()->withSuccess('Great! Upload Data Pemeriksaan');
    }
    // PENJUALAN KATEGORI
    public function master_penjualan_kategori($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('p_sales')->get();
            return view('application.master-data.master-penjualan-kategori', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_penjualan_kategori_add_kategori(Request $request)
    {
        $data = DB::table('t_layanan_cat')->get();
        return view('application.master-data.penjualan-kategori.form-add-kategori', ['code' => $request->code, 'data' => $data]);
    }
    public function master_penjualan_kategori_save_kategori(Request $request)
    {
        $total = DB::table('p_sales_cat')->where('p_sales_code', $request->code)->count();
        DB::table('p_sales_cat')->insert([
            'p_sales_cat_code' => $request->code . '' . str_pad($total + 1, 4, '0', STR_PAD_LEFT),
            'p_sales_code' => $request->code,
            't_layanan_cat_code' => $request->layanan,
            'p_sales_cat_name' => $request->name,
            'created_at' => now(),
        ]);
        return redirect()->back()->withSuccess('Great! Menambahkan data Kategori');
    }
    // MASTER PENJAMIN
    public function master_data_penjamin($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Ambil seluruh data penjamin utama
            $penjaminUtama = DB::table('medical_penjamin')
                ->select(['id', 'nama_penjamin'])
                ->orderBy('nama_penjamin', 'ASC')
                ->get();

            // Ambil seluruh data sub penjamin beserta relasinya ke penjamin utama
            $subPenjamin = DB::table('medical_sub_penjamin as sp')
                ->join('medical_penjamin as p', 'sp.penjamin_id', '=', 'p.id')
                ->select([
                    'sp.id as sub_penjamin_id',
                    'sp.penjamin_id',
                    'sp.nama_sub_penjamin',
                    'p.nama_penjamin'
                ])
                ->orderBy('sp.nama_sub_penjamin', 'ASC')
                ->get();

            return view('application.master-data.master-penjamin', [
                'penjaminUtama' => $penjaminUtama,
                'subPenjamin'   => $subPenjamin,
                'akses'         => $akses,
                'code'          => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // ==========================================
    // 1. PENJAMIN UTAMA (STORE & UPDATE)
    // ==========================================
    public function store_penjamin_utama(Request $request)
    {
        $request->validate([
            'nama_penjamin' => 'required|string|max:255|unique:medical_penjamin,nama_penjamin'
        ]);

        try {
            DB::table('medical_penjamin')->insert([
                'nama_penjamin' => $request->nama_penjamin,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            return back()->with('success', 'Penjamin utama berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update_penjamin_utama(Request $request, $id)
    {
        $request->validate([
            'nama_penjamin' => 'required|string|max:255|unique:medical_penjamin,nama_penjamin,' . $id
        ]);

        try {
            DB::table('medical_penjamin')
                ->where('id', $id)
                ->update([
                    'nama_penjamin' => $request->nama_penjamin,
                    'updated_at'    => now(),
                ]);

            return back()->with('success', 'Penjamin utama berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ==========================================
    // 2. SUB PENJAMIN (STORE & UPDATE)
    // ==========================================
    public function store_sub_penjamin(Request $request)
    {
        $request->validate([
            'penjamin_id'       => 'required|exists:medical_penjamin,id',
            'nama_sub_penjamin' => 'required|string|max:255'
        ]);

        try {
            DB::table('medical_sub_penjamin')->insert([
                'penjamin_id'       => $request->penjamin_id,
                'nama_sub_penjamin' => $request->nama_sub_penjamin,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            return back()->with('success', 'Sub penjamin berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update_sub_penjamin(Request $request, $id)
    {
        $request->validate([
            'nama_sub_penjamin' => 'required|string|max:255'
        ]);

        try {
            DB::table('medical_sub_penjamin')
                ->where('id', $id)
                ->update([
                    'nama_sub_penjamin' => $request->nama_sub_penjamin,
                    'updated_at'        => now(),
                ]);

            return back()->with('success', 'Sub penjamin berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    // PENJUALAN KATEGORI
    public function master_tarif_penjamin($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $subPenjamin = DB::table('medical_sub_penjamin as sp')
                ->join('medical_penjamin as p', 'sp.penjamin_id', '=', 'p.id')
                ->select('sp.id', 'sp.nama_sub_penjamin', 'p.nama_penjamin')
                ->get();

            $masterPoli = DB::table('medical_master_poli')->select('id', 'nama_poli')->get();

            // 1. Data Tarif Rawat Jalan / Poli
            $tarifPoli = DB::table('medical_tarif_poli as tp')
                ->join('medical_master_poli as mp', 'tp.poli_id', '=', 'mp.id')
                ->leftJoin('medical_sub_penjamin as sp', 'tp.sub_penjamin_id', '=', 'sp.id')
                ->leftJoin('medical_penjamin as p', 'sp.penjamin_id', '=', 'p.id')
                ->select('tp.*', 'mp.nama_poli', 'sp.nama_sub_penjamin', 'p.nama_penjamin')
                ->orderBy('tp.id', 'DESC')
                ->get();

            // 2. Data Tarif Rawat Inap
            $tarifRawatInap = DB::table('medical_tarif_rawatinap as tri')
                ->join('medical_sub_penjamin as sp', 'tri.sub_penjamin_id', '=', 'sp.id')
                ->join('medical_penjamin as p', 'sp.penjamin_id', '=', 'p.id')
                ->select('tri.*', 'sp.nama_sub_penjamin', 'p.nama_penjamin')
                ->orderBy('tri.id', 'DESC')
                ->get();

            // 3. Data Tarif IGD
            $tarifIgd = DB::table('medical_tarif_igd as tigd')
                ->join('medical_sub_penjamin as sp', 'tigd.sub_penjamin_id', '=', 'sp.id')
                ->join('medical_penjamin as p', 'sp.penjamin_id', '=', 'p.id')
                ->select('tigd.*', 'sp.nama_sub_penjamin', 'p.nama_penjamin')
                ->orderBy('tigd.id', 'DESC')
                ->get();

            return view('application.master-data.master-tarif-penjamin', [
                'tarifPoli'      => $tarifPoli,
                'tarifRawatInap' => $tarifRawatInap,
                'tarifIgd'       => $tarifIgd,
                'subPenjamin'    => $subPenjamin,
                'masterPoli'     => $masterPoli,
                'akses'          => $akses,
                'code'           => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function store_tarif_poli(Request $request)
    {
        $request->validate([
            'poli_id'        => 'required|exists:medical_master_poli,id',
            'sub_penjamin_id' => 'nullable|exists:medical_sub_penjamin,id',
            'kategori_biaya' => 'required|string|max:50',
            'nama_tarif'     => 'required|string|max:255',
            'tarif'          => 'required|numeric|min:0'
        ]);

        try {
            DB::table('medical_tarif_poli')->insert([
                'poli_id'         => $request->poli_id,
                'sub_penjamin_id' => $request->sub_penjamin_id,
                'kategori_biaya'  => $request->kategori_biaya,
                'nama_tarif'      => $request->nama_tarif,
                'tarif'           => $request->tarif,
                'is_active'       => 1,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            return back()->with('success', 'Tarif poli berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function update_tarif_poli(Request $request, $id)
    {
        $request->validate([
            'poli_id'        => 'required|exists:medical_master_poli,id',
            'sub_penjamin_id' => 'nullable|exists:medical_sub_penjamin,id',
            'kategori_biaya' => 'required|string|max:50',
            'nama_tarif'     => 'required|string|max:255',
            'tarif'          => 'required|numeric|min:0'
        ]);

        try {
            DB::table('medical_tarif_poli')->where('id', $id)->update([
                'poli_id'         => $request->poli_id,
                'sub_penjamin_id' => $request->sub_penjamin_id,
                'kategori_biaya'  => $request->kategori_biaya,
                'nama_tarif'      => $request->nama_tarif,
                'tarif'           => $request->tarif,
                'updated_at'      => now(),
            ]);

            return back()->with('success', 'Tarif poli berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    // ==========================================
    // STORE & UPDATE TARIF RAWAT INAP
    // ==========================================
    public function store_tarif_rawatinap(Request $request)
    {
        $request->validate([
            'kelas'                            => 'required|string|max:255',
            'sub_penjamin_id'                  => 'required|exists:medical_sub_penjamin,id',
            'tarif_kamar_per_hari'             => 'required|numeric|min:0',
            'tarif_visite_dokter_per_hari'     => 'required|numeric|min:0',
            'tarif_asuhan_keperawatan_per_hari' => 'required|numeric|min:0'
        ]);

        try {
            DB::table('medical_tarif_rawatinap')->insert([
                'kelas'                             => $request->kelas,
                'sub_penjamin_id'                   => $request->sub_penjamin_id,
                'tarif_kamar_per_hari'              => $request->tarif_kamar_per_hari,
                'tarif_visite_dokter_per_hari'      => $request->tarif_visite_dokter_per_hari,
                'tarif_asuhan_keperawatan_per_hari' => $request->tarif_asuhan_keperawatan_per_hari,
                'is_active'                         => 1,
                'created_at'                        => now(),
                'updated_at'                        => now(),
            ]);

            return back()->with('success', 'Tarif rawat inap berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function update_tarif_rawatinap(Request $request, $id)
    {
        $request->validate([
            'kelas'                            => 'required|string|max:255',
            'sub_penjamin_id'                  => 'required|exists:medical_sub_penjamin,id',
            'tarif_kamar_per_hari'             => 'required|numeric|min:0',
            'tarif_visite_dokter_per_hari'     => 'required|numeric|min:0',
            'tarif_asuhan_keperawatan_per_hari' => 'required|numeric|min:0'
        ]);

        try {
            DB::table('medical_tarif_rawatinap')->where('id', $id)->update([
                'kelas'                             => $request->kelas,
                'sub_penjamin_id'                   => $request->sub_penjamin_id,
                'tarif_kamar_per_hari'              => $request->tarif_kamar_per_hari,
                'tarif_visite_dokter_per_hari'      => $request->tarif_visite_dokter_per_hari,
                'tarif_asuhan_keperawatan_per_hari' => $request->tarif_asuhan_keperawatan_per_hari,
                'updated_at'                        => now(),
            ]);

            return back()->with('success', 'Tarif rawat inap berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    // ==========================================
    // STORE & UPDATE TARIF IGD
    // ==========================================
    public function store_tarif_igd(Request $request)
    {
        $request->validate([
            'sub_penjamin_id' => 'required|exists:medical_sub_penjamin,id',
            'kategori_biaya'  => 'required|string|max:50',
            'nama_tarif'      => 'required|string|max:255',
            'tarif'           => 'required|numeric|min:0'
        ]);

        try {
            DB::table('medical_tarif_igd')->insert([
                'sub_penjamin_id' => $request->sub_penjamin_id,
                'kategori_biaya'  => $request->kategori_biaya,
                'nama_tarif'      => $request->nama_tarif,
                'tarif'           => $request->tarif,
                'is_active'       => 1,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            return back()->with('success', 'Tarif IGD berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function update_tarif_igd(Request $request, $id)
    {
        $request->validate([
            'sub_penjamin_id' => 'required|exists:medical_sub_penjamin,id',
            'kategori_biaya'  => 'required|string|max:50',
            'nama_tarif'      => 'required|string|max:255',
            'tarif'           => 'required|numeric|min:0'
        ]);

        try {
            DB::table('medical_tarif_igd')->where('id', $id)->update([
                'sub_penjamin_id' => $request->sub_penjamin_id,
                'kategori_biaya'  => $request->kategori_biaya,
                'nama_tarif'      => $request->nama_tarif,
                'tarif'           => $request->tarif,
                'updated_at'      => now(),
            ]);

            return back()->with('success', 'Tarif IGD berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }
}
