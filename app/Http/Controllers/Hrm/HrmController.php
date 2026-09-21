<?php

namespace App\Http\Controllers\Hrm;

use App\Exports\GajiPegawaiExport;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Stmt\TryCatch;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class HrmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function calculateAttendanceScore($pegawaiCode, $periode)
    {
        if (empty($pegawaiCode) || empty($periode)) {
            return 0;
        }

        // Ekstrak Tahun dan Bulan dari Format 'YYYY-MM'
        $parts = explode('-', $periode);
        if (count($parts) < 2) {
            return 0;
        }

        $year  = (int) $parts[0];
        $month = (int) $parts[1];

        // Total kehadiran yang sah
        $totalHadir = DB::table('hrm_absensi')
            ->where('hrm_m_pegawai_code', $pegawaiCode)
            ->whereYear('hrm_absensi_date', $year)
            ->whereMonth('hrm_absensi_date', $month)
            ->whereIn('hrm_absensi_status', ['hadir', 'terlambat', 'dinas_luar'])
            ->count();

        // Total record presensi tercatat
        $totalHariKerja = DB::table('hrm_absensi')
            ->where('hrm_m_pegawai_code', $pegawaiCode)
            ->whereYear('hrm_absensi_date', $year)
            ->whereMonth('hrm_absensi_date', $month)
            ->count();

        if ($totalHariKerja === 0) {
            return 0;
        }

        return round(($totalHadir / $totalHariKerja) * 100, 2);
    }
    private function calculateSystemScore($pegawaiCode, $periode, $formula = null)
    {
        if (empty($pegawaiCode) || empty($periode)) {
            return 0;
        }

        $parts = explode('-', $periode);
        if (count($parts) < 2) {
            return 0;
        }

        $year  = (int) $parts[0];
        $month = (int) $parts[1];

        // Buat rentang tanggal awal dan akhir bulan (Safety Range)
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth()->toDateTimeString();
        $endDate   = Carbon::createFromDate($year, $month, 1)->endOfMonth()->toDateTimeString();

        switch (strtoupper($formula)) {
            case 'SALES_ACHIEVEMENT':
                return DB::table('hrm_tasks')
                    ->where(function ($query) use ($pegawaiCode) {
                        // Cek ketersediaan nama kolom penugasan
                        $query->where('assigned_pegawai_code', $pegawaiCode);
                    })
                    ->where(function ($query) {
                        // Menangani variasi status 'completed' (case-insensitive)
                        $query->whereRaw('LOWER(status) = ?', ['completed'])
                            ->orWhereRaw('LOWER(status) = ?', ['done']);
                    })
                    ->where(function ($query) use ($startDate, $endDate, $year, $month) {
                        // Prioritas 1: completed_at (menggunakan range tanggal)
                        $query->whereBetween('completed_at', [$startDate, $endDate])
                            // Fallback jika completed_at null, cek updated_at
                            ->orWhere(function ($q) use ($startDate, $endDate) {
                                $q->whereNull('completed_at')
                                    ->whereBetween('updated_at', [$startDate, $endDate]);
                            })
                            // Fallback jika menggunakan created_at
                            ->orWhere(function ($q) use ($year, $month) {
                                $q->whereNull('completed_at')
                                    ->whereYear('created_at', $year)
                                    ->whereMonth('created_at', $month);
                            });
                    })
                    ->count();
            case 'PUNCTUALITY_SCORE':
                $terlambat = DB::table('hrm_absensi')
                    ->where('hrm_m_pegawai_code', $pegawaiCode)
                    ->whereBetween('hrm_absensi_date', [$startDate, $endDate])
                    ->whereRaw('LOWER(hrm_absensi_status) = ?', ['terlambat'])
                    ->count();
                return max(0, 100 - ($terlambat * 5));

            default:
                return 0;
        }
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
    public function personal_data($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('app-hrm.dashboard.personal-data', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function personal_data_update_desc(Request $request)
    {
        return view('app-hrm.dashboard.form.form-update-desc');
    }
    public function hrm_data_kehadiran_rekap($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Ambil data pegawai menggunakan tabel hrm_master_pegawai
            $staffs = DB::table('hrm_master_pegawai')
                ->select('id_hrm_m_pegawai as id', 'hrm_m_pegawai_name as name')
                ->orderBy('hrm_m_pegawai_name', 'asc')
                ->get();

            return view('app-hrm.data-kehadiran.abesnsi', [
                'akses'  => $akses,
                'code'   => $id,
                'staffs' => $staffs
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_kehadiran_search(Request $request)
    {
        $daftar_hari = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );

        $bulan = sprintf('%02d', $request->bulan); // Format: '01' - '12'
        $tahun = $request->tahun;                   // Format: '2026'
        $nama  = $request->nama;                    // ID Pegawai (id_hrm_m_pegawai)

        // 1. Ambil Data Pegawai
        $pegawai = null;
        if (!empty($nama)) {
            $pegawai = DB::table('hrm_master_pegawai')
                ->where('id_hrm_m_pegawai', $nama)
                ->first();
        }

        // 2. Ambil Master Jam Kerja
        $master_jam_kerja = DB::table('hrm_master_jam_kerja')->get()->keyBy('hrm_m_jam_kerja_code');

        // Shift Default Pegawai
        $default_shift_code = $pegawai->hrm_m_jam_kerja_code ?? 'JK-REGULAR';
        $default_jam_kerja  = $master_jam_kerja[$default_shift_code] ?? $master_jam_kerja->first();

        // 3. Ambil Plot Jadwal Shift Khusus (hrm_jadwal_shift)
        $jadwal_khusus = collect();
        if ($pegawai) {
            $pegawai_code = $pegawai->hrm_m_pegawai_code ?? $pegawai->id_hrm_m_pegawai;
            $jadwal_khusus = DB::table('hrm_jadwal_shift')
                ->where('hrm_m_pegawai_code', $pegawai_code)
                ->whereMonth('hrm_jadwal_date', $bulan)
                ->whereYear('hrm_jadwal_date', $tahun)
                ->get()
                ->keyBy('hrm_jadwal_date');
        }

        // 4. Ambil Data Absensi Real
        $query_absensi = DB::table('hrm_absensi')
            ->whereMonth('hrm_absensi_date', $bulan)
            ->whereYear('hrm_absensi_date', $tahun);

        if ($pegawai) {
            $pegawai_code = $pegawai->hrm_m_pegawai_code ?? $pegawai->id_hrm_m_pegawai;
            $query_absensi->where('hrm_m_pegawai_code', $pegawai_code);
        }

        $absensi = $query_absensi->get()->keyBy('hrm_absensi_date');

        // 5. AMBIL DATA LEMBUR DARI TABEL hrm_pengajuan_lembur
        $data_lembur = collect();
        if ($pegawai) {
            $pegawai_code = $pegawai->hrm_m_pegawai_code ?? $pegawai->id_hrm_m_pegawai;
            $data_lembur = DB::table('hrm_pengajuan_lembur')
                ->where('hrm_m_pegawai_code', $pegawai_code)
                ->whereMonth('hrm_lembur_date', $bulan)
                ->whereYear('hrm_lembur_date', $tahun)
                ->where('hrm_lembur_status', 'approved')
                ->get()
                ->keyBy('hrm_lembur_date');
        }

        // 6. Build Data Per Hari
        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, (int)$bulan, (int)$tahun);

        $tgl = [];
        $hari = [];
        $jam_kerja = [];
        $date_keys = [];
        $late_minutes_calculated = [];
        $overtime_calculated = [];

        for ($i = 1; $i <= $jumlah_hari; $i++) {
            $date_string = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);
            $date_keys[$i] = $date_string;

            $tgl[$i] = date('d - M - Y', strtotime($date_string));

            $day_code = date('D', strtotime($date_string));
            $hari_nama = $daftar_hari[$day_code];
            $hari[$i] = $hari_nama;

            // Prioritas Shift Aktif Hari Ini
            $is_shift_khusus = false;
            if (isset($jadwal_khusus[$date_string])) {
                $shift_code_hari_ini = $jadwal_khusus[$date_string]->hrm_m_jam_kerja_code;
                $shift_hari_ini      = $master_jam_kerja[$shift_code_hari_ini] ?? $default_jam_kerja;
                $is_shift_khusus     = true;
            } else {
                $shift_hari_ini = $default_jam_kerja;
            }

            // Hari Libur
            $days_off = !empty($shift_hari_ini->hrm_m_jam_kerja_days_off)
                ? json_decode($shift_hari_ini->hrm_m_jam_kerja_days_off, true)
                : ['Minggu'];

            // Format HTML Tampilan Jam Kerja
            if (in_array($hari_nama, $days_off)) {
                $jam_kerja[$i] = '<span class="badge bg-soft-danger text-danger rounded-pill px-2">Libur</span>';
            } else {
                $jam_masuk  = date('H:i', strtotime($shift_hari_ini->hrm_m_jam_kerja_in));
                $jam_keluar = date('H:i', strtotime($shift_hari_ini->hrm_m_jam_kerja_out));
                $html_jam   = '<span class="fw-semibold">' . $jam_masuk . ' - ' . $jam_keluar . '</span>';

                if ($is_shift_khusus) {
                    $ket = $jadwal_khusus[$date_string]->hrm_jadwal_keterangan ?? 'Shift Khusus';
                    $html_jam .= ' <br><span class="badge bg-soft-warning text-warning fs--2 rounded-pill mt-1" data-bs-toggle="tooltip" title="' . e($ket) . '"><i class="fas fa-exchange-alt me-1"></i>' . e($shift_hari_ini->hrm_m_jam_kerja_name) . '</span>';
                }

                $jam_kerja[$i] = $html_jam;
            }

            // A. PERHITUNGAN TERLAMBAT (DINAMIS)
            $record = $absensi[$date_string] ?? null;
            $terlambat_menit = 0;

            if ($record && !empty($record->hrm_absensi_in) && !in_array($hari_nama, $days_off)) {
                $time_masuk_real  = date('H:i:s', strtotime($record->hrm_absensi_in));
                $time_masuk_shift = date('H:i:s', strtotime($shift_hari_ini->hrm_m_jam_kerja_in));

                $dt_masuk_real  = Carbon::parse($date_string . ' ' . $time_masuk_real);
                $dt_masuk_shift = Carbon::parse($date_string . ' ' . $time_masuk_shift);

                if ($dt_masuk_real->gt($dt_masuk_shift)) {
                    $terlambat_menit = $dt_masuk_shift->diffInMinutes($dt_masuk_real);
                }
            }

            // B. AMBIL JAM LEMBUR DARI TABEL hrm_pengajuan_lembur
            $lembur_info = $data_lembur[$date_string] ?? null;
            $lembur_jam  = $lembur_info ? (float)$lembur_info->hrm_lembur_total_hours : 0;

            $late_minutes_calculated[$i] = $terlambat_menit;
            $overtime_calculated[$i]     = $lembur_jam;
        }

        return view('app-hrm.data-kehadiran.absensi.data-absensi', [
            'data'                     => $jumlah_hari,
            'tgl'                      => $tgl,
            'hari'                     => $hari,
            'jam_kerja'                => $jam_kerja,
            'date_keys'                => $date_keys,
            'bulan'                    => $bulan,
            'tahun'                    => $tahun,
            'pegawai'                  => $pegawai,
            'jam_kerja_setting'        => $default_jam_kerja,
            'absensi'                  => $absensi,
            'data_lembur'              => $data_lembur,
            'late_minutes_calculated'  => $late_minutes_calculated,
            'overtime_calculated'      => $overtime_calculated,
        ]);
    }
    // CUTI dan IZIM
    public function hrm_data_kehadiran_cuti_izin($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('app-hrm.data-kehadiran.cuti-dan-izin', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // DATA LEMBUR
    public function hrm_data_kehadiran_lembur($akses, $id, Request $request)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // 1. Ambil List Pegawai untuk Dropdown Filter & Modal
            $list_pegawai = DB::table('hrm_master_pegawai')
                ->select('id_hrm_m_pegawai', 'hrm_m_pegawai_code', 'hrm_m_pegawai_name')
                ->orderBy('hrm_m_pegawai_name', 'asc')
                ->get();

            // 2. Ambil Input Filter (Bulan, Tahun, Pegawai)
            $bulan = sprintf('%02d', $request->input('bulan', date('m')));
            $tahun = $request->input('tahun', date('Y'));
            $pegawai_code = $request->input('pegawai_code');

            // Jika belum pilih pegawai di filter, otomatis ambil pegawai pertama dari list
            if (empty($pegawai_code) && $list_pegawai->isNotEmpty()) {
                $pegawai_code = $list_pegawai->first()->hrm_m_pegawai_code;
            }

            // 3. Query Data Lembur dari Tabel hrm_pengajuan_lembur
            $query_lembur = DB::table('hrm_pengajuan_lembur')
                ->whereMonth('hrm_lembur_date', $bulan)
                ->whereYear('hrm_lembur_date', $tahun);

            if (!empty($pegawai_code)) {
                $query_lembur->where('hrm_m_pegawai_code', $pegawai_code);
            }

            $list_lembur = $query_lembur
                ->orderBy('hrm_lembur_date', 'desc')
                ->get();

            // 4. Hitung Total Jam Lembur yang Disetujui (Approved)
            $total_jam_approved = $list_lembur
                ->where('hrm_lembur_status', 'approved')
                ->sum('hrm_lembur_total_hours');

            // 5. Return View
            return view('app-hrm.data-kehadiran.data-lembur', [
                'akses'              => $akses,
                'code'               => $id,
                'list_pegawai'       => $list_pegawai,
                'list_lembur'        => $list_lembur,
                'total_jam_approved' => $total_jam_approved,
                'bulan'              => $bulan,
                'tahun'              => $tahun,
                'pegawai_code'       => $pegawai_code
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // DATA GAJI
    public function payroll_data_gaji($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $departemens = DB::table('hrm_departemen')->get();
            return view('app-hrm.payroll.data-gaji', compact('departemens'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function payroll_data_gaji_get_data(Request $request)
    {
        $bulan = $request->input('bulan', date('n')); // Default bulan saat ini (1-12)
        $tahun = $request->input('tahun', date('Y')); // Default tahun saat ini

        $query = DB::table('hrm_master_pegawai as p')
            ->leftJoin('hrm_departemen as d', 'p.hrm_m_position_code', '=', 'd.hrm_departemen_code')
            ->select(
                'p.hrm_m_pegawai_code',
                'p.hrm_m_pegawai_name',
                'p.hrm_m_pegawai_nip',
                'p.hrm_m_pegawai_nik',
                'p.hrm_m_position_code',
                'd.hrm_departemen_name',
                'd.hrm_departemen_lokasi'
            );

        if ($request->filled('dept_code')) {
            $query->where('d.hrm_departemen_code', $request->dept_code);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('p.hrm_m_pegawai_name', 'like', "%{$search}%")
                    ->orWhere('p.hrm_m_pegawai_nip', 'like', "%{$search}%")
                    ->orWhere('p.hrm_m_pegawai_nik', 'like', "%{$search}%");
            });
        }

        $pegawaiList = $query->get();

        // Ambil data transaksi penggajian yang SUDAH LUNAS (PAID) pada Bulan & Tahun terpilih
        $gajiPaidList = DB::table('hrm_penggajian')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('status', 'PAID')
            ->pluck('hrm_m_pegawai_code')
            ->toArray();

        $data = $pegawaiList->map(function ($p) use ($gajiPaidList) {
            // Check jika pegawai sudah punya setup di hrm_pegawai_komponen
            $pegawaiKomponen = DB::table('hrm_pegawai_komponen as pk')
                ->join('hrm_komponen_gaji as k', 'pk.id_komponen', '=', 'k.id_komponen')
                ->where('pk.hrm_m_pegawai_code', $p->hrm_m_pegawai_code)
                ->where('k.is_active', true)
                ->select('k.tipe', 'pk.nominal')
                ->get();

            $totalPendapatan = 0;
            $totalPotongan = 0;
            $isConfigured = $pegawaiKomponen->isNotEmpty();

            if ($isConfigured) {
                foreach ($pegawaiKomponen as $pk) {
                    if ($pk->tipe === 'pendapatan') {
                        $totalPendapatan += floatval($pk->nominal);
                    } else {
                        $totalPotongan += floatval($pk->nominal);
                    }
                }
            } else {
                // Ambil default nominal departemen jika pegawai belum di-setup khusus
                $defaultDept = DB::table('hrm_departemen_komponen as dk')
                    ->join('hrm_komponen_gaji as k', 'dk.id_komponen', '=', 'k.id_komponen')
                    ->where('dk.hrm_departemen_code', $p->hrm_m_position_code)
                    ->where('k.is_active', true)
                    ->select('k.tipe', 'dk.nominal_default')
                    ->get();

                foreach ($defaultDept as $dk) {
                    if ($dk->tipe === 'pendapatan') {
                        $totalPendapatan += floatval($dk->nominal_default);
                    } else {
                        $totalPotongan += floatval($dk->nominal_default);
                    }
                }
            }

            $p->total_pendapatan = $totalPendapatan;
            $p->total_potongan = $totalPotongan;
            $p->is_configured = $isConfigured;

            // Cek apakah gaji pegawai ini sudah LUNAS di bulan & tahun terpilih
            $p->is_paid = in_array($p->hrm_m_pegawai_code, $gajiPaidList);

            return $p;
        });

        $totalGajiEstimasi = $data->sum(function ($item) {
            return $item->total_pendapatan - $item->total_potongan;
        });

        return response()->json([
            'status' => true,
            'data' => $data,
            'stats' => [
                'totalPegawai' => $data->count(),
                'totalGajiEstimasi' => 'Rp ' . number_format($totalGajiEstimasi, 0, ',', '.'),
                'pendingGaji' => $data->where('is_paid', false)->count() // Pegawai yang belum lunas di periode ini
            ]
        ]);
    }
    public function payroll_data_gaji_get_detail(Request $request, $pegawaiCode)
    {
        $pegawai = DB::table('hrm_master_pegawai as p')
            ->leftJoin('hrm_departemen as d', 'p.hrm_m_position_code', '=', 'd.hrm_departemen_code')
            ->where('p.hrm_m_pegawai_code', $pegawaiCode)
            ->select('p.*', 'd.hrm_departemen_name', 'd.hrm_departemen_lokasi')
            ->first();

        if (!$pegawai) {
            return response()->json(['status' => false, 'message' => 'Pegawai tidak ditemukan.'], 404);
        }

        // Fetch Master Komponen + Default Dept + Saved Nominal dari Pivot
        $komponen = DB::table('hrm_komponen_gaji as k')
            ->leftJoin('hrm_departemen_komponen as dk', function ($join) use ($pegawai) {
                $join->on('k.id_komponen', '=', 'dk.id_komponen')
                    ->where('dk.hrm_departemen_code', '=', $pegawai->hrm_m_position_code);
            })
            ->leftJoin('hrm_pegawai_komponen as pk', function ($join) use ($pegawaiCode) {
                $join->on('k.id_komponen', '=', 'pk.id_komponen')
                    ->where('pk.hrm_m_pegawai_code', '=', $pegawaiCode);
            })
            ->where('k.is_active', true)
            ->select(
                'k.id_komponen',
                'k.kode_komponen',
                'k.nama_komponen',
                'k.tipe',
                DB::raw('COALESCE(pk.nominal, dk.nominal_default, 0) as nominal_default')
            )
            ->orderBy('k.id_komponen', 'asc')
            ->get();

        $gajiInfo = DB::table('hrm_m_gaji_pokok')
            ->where('hrm_m_pegawai_code', $pegawaiCode)
            ->first();

        return response()->json([
            'status' => true,
            'pegawai' => $pegawai,
            'komponen' => $komponen,
            'gaji' => $gajiInfo
        ]);
    }
    public function payroll_data_gaji_store(Request $request)
    {
        $request->validate([
            'hrm_m_pegawai_code' => 'required|string',
            'komponen'           => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $pegawaiCode = $request->hrm_m_pegawai_code;
            $bulan       = $request->input('bulan', date('n'));
            $tahun       = $request->input('tahun', date('Y'));

            // 1. Save / Update Info Bank
            DB::table('hrm_m_gaji_pokok')->updateOrInsert(
                ['hrm_m_pegawai_code' => $pegawaiCode],
                [
                    'nama_bank'      => $request->nama_bank,
                    'nomor_rekening' => $request->nomor_rekening,
                    'updated_at'     => now(),
                    'created_at'     => now(),
                ]
            );

            // 2. Refresh Pivot Komponen Pegawai
            DB::table('hrm_pegawai_komponen')->where('hrm_m_pegawai_code', $pegawaiCode)->delete();

            $insertPivot     = [];
            $totalPendapatan = 0;
            $totalPotongan   = 0;

            foreach ($request->komponen as $kodeKomponen => $nominal) {
                $komponenMaster = DB::table('hrm_komponen_gaji')->where('kode_komponen', $kodeKomponen)->first();

                if ($komponenMaster) {
                    $nom = floatval($nominal) ?? 0;
                    $insertPivot[] = [
                        'hrm_m_pegawai_code' => $pegawaiCode,
                        'id_komponen'        => $komponenMaster->id_komponen,
                        'nominal'            => $nom,
                        'created_at'         => now(),
                        'updated_at'         => now(),
                    ];

                    if ($komponenMaster->tipe === 'pendapatan') {
                        $totalPendapatan += $nom;
                    } else {
                        $totalPotongan += $nom;
                    }
                }
            }

            if (!empty($insertPivot)) {
                DB::table('hrm_pegawai_komponen')->insert($insertPivot);
            }

            // 3. SIMPAN KE TABEL hrm_penggajian
            DB::table('hrm_penggajian')->updateOrInsert(
                [
                    'hrm_m_pegawai_code' => $pegawaiCode,
                    'bulan'              => $bulan,
                    'tahun'              => $tahun,
                ],
                [
                    'total_pendapatan' => $totalPendapatan,
                    'total_potongan'   => $totalPotongan,
                    'take_home_pay'    => $totalPendapatan - $totalPotongan,
                    'status'           => 'PAID',
                    'tanggal_bayar'  => now(),
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]
            );

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Struktur gaji & status pembayaran berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menyimpan data gaji: ' . $e->getMessage()
            ], 500);
        }
    }
    public function payroll_data_gaji_export_excel(Request $request)
    {
        return Excel::download(
            new GajiPegawaiExport($request->dept_code, $request->search, $request->bulan, $request->tahun),
            'Master_Gaji_Pegawai_' . date('Ymd_His') . '.xlsx'
        );
    }
    public function payroll_data_gaji_print($pegawaiCode)
    {
        $pegawai = DB::table('hrm_master_pegawai as p')
            ->leftJoin('hrm_departemen as d', 'p.hrm_m_position_code', '=', 'd.hrm_departemen_code')
            ->where('p.hrm_m_pegawai_code', $pegawaiCode)
            ->select('p.*', 'd.hrm_departemen_name', 'd.hrm_departemen_lokasi', 'd.hrm_departemen_kepala')
            ->first();

        if (!$pegawai) {
            abort(404, 'Data pegawai tidak ditemukan');
        }

        $gaji = DB::table('hrm_m_gaji_pokok')->where('hrm_m_pegawai_code', $pegawaiCode)->first();

        $komponens = DB::table('hrm_komponen_gaji as k')
            ->leftJoin('hrm_pegawai_komponen as pk', function ($join) use ($pegawaiCode) {
                $join->on('k.id_komponen', '=', 'pk.id_komponen')
                    ->where('pk.hrm_m_pegawai_code', '=', $pegawaiCode);
            })
            ->where('k.is_active', true)
            ->select('k.nama_komponen', 'k.tipe', DB::raw('COALESCE(pk.nominal, 0) as nominal'))
            ->orderBy('k.id_komponen', 'asc')
            ->get();

        $pdf = Pdf::loadView('app-hrm.payroll.data-gaji.report.report-slip-gaji', compact('pegawai', 'gaji', 'komponens'))->setPaper('a5', 'landscape');
        return $pdf->stream('Slip_Gaji_' . $pegawai->hrm_m_pegawai_nip . '.pdf');
    }
    public function payroll_data_gaji_get_status(Request $request, $pegawaiCode)
    {
        $tahun = $request->input('tahun', date('Y')); // Default tahun berjalan (e.g. 2026)

        // 1. Ambil data transaksi yang SUDAH DIBAYAR di tahun tersebut
        $gajiLunas = DB::table('hrm_penggajian')
            ->where('hrm_m_pegawai_code', $pegawaiCode)
            ->where('tahun', $tahun)
            ->where('status', 'PAID')
            ->pluck('tanggal_bayar', 'bulan') // Produces [bulan => tanggal_bayar]
            ->toArray();

        // 2. Map 12 bulan untuk mengecek status masing-masing bulan
        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $riwayatBulan = [];
        foreach ($namaBulan as $numBulan => $nama) {
            $isPaid = isset($gajiLunas[$numBulan]);

            $riwayatBulan[] = [
                'bulan_angka'   => $numBulan,
                'nama_bulan'    => $nama,
                'tahun'         => $tahun,
                'is_paid'       => $isPaid,
                'status'        => $isPaid ? 'LUNAS' : 'BELUM DIBAYAR',
                'tanggal_bayar' => $isPaid ? date('d-m-Y H:i', strtotime($gajiLunas[$numBulan])) : null
            ];
        }

        return response()->json([
            'status' => true,
            'pegawai_code' => $pegawaiCode,
            'tahun' => $tahun,
            'data' => $riwayatBulan
        ]);
    }
    public function payroll_data_gaji_preview_html($pegawaiCode)
    {
        $pegawai = DB::table('hrm_master_pegawai as p')
            ->leftJoin('hrm_departemen as d', 'p.hrm_m_position_code', '=', 'd.hrm_departemen_code')
            ->where('p.hrm_m_pegawai_code', $pegawaiCode)
            ->select('p.*', 'd.hrm_departemen_name', 'd.hrm_departemen_lokasi', 'd.hrm_departemen_kepala')
            ->first();

        if (!$pegawai) {
            return response('<div style="text-align:center; padding: 20px;">Data pegawai tidak ditemukan.</div>', 404);
        }

        $gaji = DB::table('hrm_m_gaji_pokok')->where('hrm_m_pegawai_code', $pegawaiCode)->first();

        $komponens = DB::table('hrm_komponen_gaji as k')
            ->leftJoin('hrm_pegawai_komponen as pk', function ($join) use ($pegawaiCode) {
                $join->on('k.id_komponen', '=', 'pk.id_komponen')
                    ->where('pk.hrm_m_pegawai_code', '=', $pegawaiCode);
            })
            ->where('k.is_active', true)
            ->select('k.nama_komponen', 'k.tipe', DB::raw('COALESCE(pk.nominal, 0) as nominal'))
            ->orderBy('k.id_komponen', 'asc')
            ->get();

        // Return view HTML langsung (bukan stream PDF)
        return view('app-hrm.payroll.data-gaji.report.report-slip-gaji', compact('pegawai', 'gaji', 'komponens'));
    }
    // DATA SLIP GAJI
    public function payroll_slip_gaji($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('app-hrm.payroll.slip-gaji', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function payroll_pajak_bpjs($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('app-hrm.payroll.bpjs-dan-pajak', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

    // TARGET KPI
    public function manajemen_kpi_target($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Ambil data pegawai beserta nama departemennya
            $pegawais = DB::table('hrm_master_pegawai as p')
                ->leftJoin('hrm_departemen as d', 'p.hrm_m_position_code', '=', 'd.hrm_departemen_code')
                ->select(
                    'p.hrm_m_pegawai_code',
                    'p.hrm_m_pegawai_name',
                    'p.hrm_m_pegawai_nip',
                    'p.hrm_m_position_code',
                    'd.hrm_departemen_name'
                )
                ->get();

            // Query Rekapitulasi KPI
            $queryRekap = DB::table('hrm_kpi_rekap as r')
                ->leftJoin('hrm_master_pegawai as p', 'r.hrm_m_pegawai_code', '=', 'p.hrm_m_pegawai_code')
                ->select(
                    'r.id_hrm_kpi_rekap',
                    'r.hrm_kpi_rekap_code',
                    'r.hrm_m_pegawai_code',
                    'r.hrm_kpi_rekap_periode',
                    'r.hrm_kpi_rekap_total',
                    'r.hrm_kpi_rekap_cat',
                    'p.hrm_m_pegawai_name',
                    'p.hrm_m_pegawai_nip'
                );

            // Jika pegawai biasa, batasi rekap hanya milik NIP nya
            if (Auth::check() && Auth::user()->access_code !== 'master') {
                $userNip = Auth::user()->userid;
                $queryRekap->where('p.hrm_m_pegawai_nip', $userNip);
            }

            $rekaps = $queryRekap->orderBy('r.created_at', 'desc')->get();
            return view('app-hrm.manajemen.penilaian-kpi', compact('pegawais', 'rekaps'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function getKpiByDept($deptCode, Request $request)
    {
        // 1. Tangkap pegawai_code dan periode dari Query String atau Form Input
        $pegawaiCode = $request->input('pegawai_code') ?? $request->query('pegawai_code');
        $periode     = $request->input('periode') ?? $request->query('periode') ?? date('Y-m');

        // 2. Ambil Master KPI berdasarkan kode departemen
        $kpis = DB::table('hrm_kpi_master')
            ->where('hrm_departemen_code', $deptCode)
            ->get();

        // Fallback: Jika departemen tidak ditemukan (misal menggunakan relasi posisi)
        if ($kpis->isEmpty()) {
            $kpis = DB::table('hrm_kpi_master')->get(); // Ambil semua indikator sebagai fallback
        }

        // 3. Process Perhitungan Otomatis
        foreach ($kpis as $kpi) {
            $type = strtolower($kpi->hrm_kpi_master_type ?? 'manual');

            if ($type === 'kehadiran') {
                $kpi->auto_calculated_value = $this->calculateAttendanceScore($pegawaiCode, $periode);
            } elseif ($type === 'sistem') {
                $kpi->auto_calculated_value = $this->calculateSystemScore($pegawaiCode, $periode, $kpi->hrm_kpi_master_formula ?? null);
            } else {
                $kpi->auto_calculated_value = null; // Diisi manual
            }
        }

        return response()->json($kpis);
    }
    public function store(Request $request)
    {
        $request->validate([
            'hrm_m_pegawai_code' => 'required',
            'hrm_kpi_pegawai_periode' => 'required',
            'values' => 'required|array',
        ]);

        $pegawaiCode = $request->hrm_m_pegawai_code;
        $periode = $request->hrm_kpi_pegawai_periode;

        // Cek duplikasi pengisian KPI di bulan yang sama
        $sudahAdaPenilaian = DB::table('hrm_kpi_rekap')
            ->where('hrm_m_pegawai_code', $pegawaiCode)
            ->where('hrm_kpi_rekap_periode', $periode)
            ->exists();

        if ($sudahAdaPenilaian) {
            $pegawai = DB::table('hrm_master_pegawai')
                ->where('hrm_m_pegawai_code', $pegawaiCode)
                ->first();

            $namaPegawai = $pegawai->hrm_m_pegawai_name ?? 'Pegawai';

            return back()->with('error', "Penilaian KPI untuk {$namaPegawai} pada periode {$periode} sudah pernah dibuat. Anda tidak dapat mengisi ulang periode yang sama.");
        }

        DB::beginTransaction();
        try {
            $totalScoreWeighted = 0;
            $evaluator = Auth::user()->name ?? 'System/HRD';
            $now = now();

            foreach ($request->values as $kpiMasterCode => $realizationValue) {
                $kpiMaster = DB::table('hrm_kpi_master')
                    ->where('hrm_kpi_master_code', $kpiMasterCode)
                    ->first();

                if (!$kpiMaster) continue;

                $target = (float) $kpiMaster->hrm_kpi_master_target;
                $bobot = (float) $kpiMaster->hrm_kpi_master_bobot;
                $realisasi = (float) $realizationValue;

                $percentCapaian = $target > 0 ? ($realisasi / $target) * 100 : 0;
                $scoreWeighted = ($percentCapaian * $bobot) / 100;

                $totalScoreWeighted += $scoreWeighted;

                DB::table('hrm_kpi_pegawai')->insert([
                    'hrm_kpi_pegawai_code' => 'KPIG-' . Str::upper(Str::random(8)),
                    'hrm_m_pegawai_code' => $pegawaiCode,
                    'hrm_kpi_master_code' => $kpiMasterCode,
                    'hrm_kpi_pegawai_periode' => $periode,
                    'hrm_kpi_pegawai_value' => $realisasi,
                    'hrm_kpi_pegawai_score' => round($scoreWeighted, 2),
                    'hrm_kpi_pegawai_evaluator' => $evaluator,
                    'hrm_kpi_pegawai_catatan' => $request->catatan[$kpiMasterCode] ?? '-',
                    'hrm_kpi_pegawai_status' => 'SUBMITTED',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            // Kategori Predikat
            if ($totalScoreWeighted >= 90) {
                $kategori = 'A (Sangat Baik)';
            } elseif ($totalScoreWeighted >= 75) {
                $kategori = 'B (Baik)';
            } elseif ($totalScoreWeighted >= 60) {
                $kategori = 'C (Cukup)';
            } else {
                $kategori = 'D (Kurang)';
            }

            DB::table('hrm_kpi_rekap')->insert([
                'hrm_kpi_rekap_code' => 'RKP-' . Str::upper(Str::random(8)),
                'hrm_m_pegawai_code' => $pegawaiCode,
                'hrm_kpi_rekap_periode' => $periode,
                'hrm_kpi_rekap_total' => round($totalScoreWeighted, 2),
                'hrm_kpi_rekap_cat' => $kategori,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::commit();
            return back()->with('success', 'Penilaian KPI berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan penilaian: ' . $e->getMessage());
        }
    }
    public function show($pegawaiCode, $periode)
    {
        try {
            // 1. Validasi Auth & Hak Akses Pegawai
            if (Auth::check() && Auth::user()->access_code !== 'master') {
                $userNip = Auth::user()->userid;

                $pegawaiAkses = DB::table('hrm_master_pegawai')
                    ->where('hrm_m_pegawai_code', $pegawaiCode)
                    ->first();

                if (!$pegawaiAkses || $pegawaiAkses->hrm_m_pegawai_nip !== $userNip) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Akses ditolak. Anda tidak memiliki izin melihat data ini.'
                    ], 403);
                }
            }

            // 2. Ambil Data Master Pegawai & Departemen
            $pegawai = DB::table('hrm_master_pegawai as p')
                ->leftJoin('hrm_departemen as d', 'p.hrm_m_position_code', '=', 'd.hrm_departemen_code')
                ->where('p.hrm_m_pegawai_code', $pegawaiCode)
                ->select('p.hrm_m_pegawai_code', 'p.hrm_m_pegawai_name', 'p.hrm_m_pegawai_nip', 'd.hrm_departemen_name')
                ->first();

            if (!$pegawai) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Data pegawai tidak ditemukan.'
                ], 404);
            }

            // 3. Ambil Detail Transaksi Indikator KPI
            $details = DB::table('hrm_kpi_pegawai as kp')
                ->join('hrm_kpi_master as km', 'kp.hrm_kpi_master_code', '=', 'km.hrm_kpi_master_code')
                ->where('kp.hrm_m_pegawai_code', $pegawaiCode)
                ->where('kp.hrm_kpi_pegawai_periode', $periode)
                ->select(
                    'kp.hrm_kpi_pegawai_value',
                    'kp.hrm_kpi_pegawai_score',
                    'kp.hrm_kpi_pegawai_catatan',
                    'km.hrm_kpi_master_name',
                    'km.hrm_kpi_master_desc',
                    'km.hrm_kpi_master_bobot',
                    'km.hrm_kpi_master_target'
                )
                ->get();

            // 4. Ambil Rekapitulasi Akhir
            $rekap = DB::table('hrm_kpi_rekap')
                ->where('hrm_m_pegawai_code', $pegawaiCode)
                ->where('hrm_kpi_rekap_periode', $periode)
                ->first();

            // 5. Kembalikan Response JSON Murni
            return response()->json([
                'status'  => 'success',
                'periode' => $periode,
                'pegawai' => $pegawai,
                'rekap'   => $rekap,
                'details' => $details
            ], 200);
        } catch (\Exception $e) {
            // Tangkap exception jika terjadi query error/server error agar balasan tetap berupa JSON
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
    // JADWAL PELATIHAN
    public function pelatihan_pegawai_jadwal($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('app-hrm.manajemen.jadwal-pelatihan', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // MASTER PEGAWAI
    public function master_data_pegawai($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {

            $divisi = DB::table('hrm_departemen')->get();
            return view('app-hrm.master-pegawai.data-pegawai', [
                'akses' => $akses,
                'code' => $id,
                'divisi' => $divisi
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_data_pegawai_add(Request $request)
    {
        $departemen = DB::table('hrm_departemen')->get();
        return view('app-hrm.master-pegawai.form.form-add-pegawai', compact('departemen'));
    }
    public function master_data_pegawai_data(Request $request)
    {
        $data = DB::table('hrm_master_pegawai')
            ->select(
                'hrm_m_pegawai_code',
                'hrm_m_pegawai_name',
                'hrm_m_position_code',
                'hrm_m_pegawai_email',
                'hrm_m_pegawai_img',
                'hrm_m_pegawai_hp',
                'hrm_m_pegawai_status'
            )
            ->get()
            ->map(function ($item) {
                // Cek path foto agar url valid
                $fotoUrl = asset('img/default-avatar.png');
                if (!empty($item->hrm_m_pegawai_img)) {
                    // Jika tersimpan hanya nama file/path relatif di storage
                    $fotoUrl = str_contains($item->hrm_m_pegawai_img, 'http')
                        ? $item->hrm_m_pegawai_img
                        : asset('storage/pegawai/profile/PA/' . $item->hrm_m_pegawai_img); // Sesuaikan lokasi storage Anda
                }

                return [
                    "code"    => $item->hrm_m_pegawai_code,
                    "nama"    => $item->hrm_m_pegawai_name,
                    "jabatan" => $item->hrm_m_position_code ?? '-',
                    "divisi"  => $item->hrm_m_position_code ?? '-',
                    "foto"    => $fotoUrl,
                    "kontak"  => $item->hrm_m_pegawai_hp ?? '-',
                    "email"   => $item->hrm_m_pegawai_email ?? '-',
                    "status"  => $item->hrm_m_pegawai_status ?? 'Aktif',
                ];
            });

        // Mengembalikan data JSON yang siap digunakan oleh DataTables/AJAX
        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }
    public function master_data_pegawai_create_login(Request $request)
    {
        $code = $request->code;

        // 1. Ambil data pegawai
        $pegawai = DB::table('hrm_master_pegawai')
            ->where('hrm_m_pegawai_code', $code)
            ->first();

        if (!$pegawai) {
            return response()->html('<div class="alert alert-danger p-3">Data pegawai tidak ditemukan.</div>');
        }

        // 2. Cek apakah user sudah memiliki akses login di tabel `user_mains` (via userid / email)
        $user = DB::table('user_mains')
            ->where('userid', $pegawai->hrm_m_pegawai_code)
            ->first();

        // 3. Render Blade View berdasarkan kondisi akun
        if ($user) {
            // SUDAH ADA: Tampilkan informasi detail akun
            return view('app-hrm.master-pegawai.form.detail-akses-login', [
                'pegawai'  => $pegawai,
                'user'     => $user,
                'is_exist' => true
            ]);
        } else {
            // BELUM ADA: Tampilkan form untuk buat akun baru
            return view('app-hrm.master-pegawai.form.form-akses-login', [
                'pegawai'  => $pegawai,
                'is_exist' => false
            ]);
        }
    }
    public function master_data_pegawai_save_login(Request $request)
    {
        // Validasi sesuai skema tabel user_mains
        $request->validate([
            'pegawai_code'     => 'required',
            'username'         => 'required|unique:user_mains,username',
            'email'            => 'required|email|unique:user_mains,email',
            'password'         => 'required|min:6',
            'access_cabang'    => 'required',
            'access_code'      => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Cek ganda keamanan untuk mencegah duplikasi
            $isExist = DB::table('user_mains')
                ->where('userid', $request->pegawai_code)
                ->exists();

            if ($isExist) {
                return response()->json([
                    'status'  => 'warning',
                    'message' => 'Pegawai ini sudah memiliki akses login!'
                ], 400);
            }

            // Insert data ke tabel user_mains
            DB::table('user_mains')->insert([
                'fullname'         => $request->fullname,
                'username'         => $request->username,
                'userid'           => $request->pegawai_code,
                'email'            => $request->email,
                'number_handphone' => $request->number_handphone ?? '-',
                'password'         => Hash::make($request->password),
                'access_cabang'    => $request->access_cabang,
                'access_code'      => $request->access_code,
                'access_status'    => 1, // 1 = Aktif, 0 = Tidak Aktif
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Akses login berhasil dibuat!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal membuat akses login: ' . $e->getMessage()
            ], 500);
        }
    }
    public function master_data_pegawai_reset_password(Request $request)
    {
        try {
            DB::table('user_mains')
                ->where('userid', $request->userid)
                ->update([
                    'password'   => Hash::make('12345678'), // Default password baru
                    'updated_at' => now(),
                ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Password berhasil di-reset menjadi: 12345678'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mereset password: ' . $e->getMessage()
            ], 500);
        }
    }
    public function master_data_pegawai_upload_profile(Request $request)
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
            $path = $disk->putFileAs('public/pegawai/profile/' . auth::user()->access_cabang, $file, $fileName);
            // $path1 = $disk('videos', $file, $fileName);

            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => Storage::url('pegawai/profile/' . auth::user()->access_cabang . '/' . $fileName),
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
    public function master_data_pegawai_save(Request $request)
    {
        // 1. Validasi Input sesuai nama tabel hrm_master_pegawai
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'nik'       => 'required|numeric|digits:16|unique:hrm_master_pegawai,hrm_m_pegawai_nik',
            'nip'       => 'required|string|max:50|unique:hrm_master_pegawai,hrm_m_pegawai_nip',
            'jk'        => 'required|in:l,p',
            'posisi'    => 'required|string',
            'hp'        => 'required|numeric',
            'email'     => 'nullable|email|max:255',
            'place'     => 'nullable|string|max:255',
            'dob'       => 'nullable|date',
            'agama'     => 'nullable|string|max:100',
            'alamat'    => 'nullable|string',
            'link'      => 'nullable|string', // Foto dari Resumable.js
        ], [
            'name.required'   => 'Nama lengkap wajib diisi.',
            'nik.required'    => 'NIK wajib diisi.',
            'nik.digits'      => 'NIK harus berjumlah 16 digit.',
            'nik.unique'      => 'NIK sudah terdaftar dalam sistem.',
            'nip.required'    => 'NIP wajib diisi.',
            'nip.unique'      => 'NIP sudah terdaftar.',
            'jk.required'     => 'Jenis kelamin wajib dipilih.',
            'posisi.required' => 'Departemen/Jabatan wajib dipilih.',
            'hp.required'     => 'Nomor handphone wajib diisi.',
            'email.email'     => 'Format email tidak valid.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // 2. Pemindahan Foto dari Folder Temp ke Storage Permanen
            $fotoPath = null;
            if ($request->filled('link')) {
                $tempPath = 'public/tmp/' . $request->link;
                $newPath  = 'public/pegawai/foto/' . $request->link;

                if (Storage::exists($tempPath)) {
                    Storage::move($tempPath, $newPath);
                    $fotoPath = 'storage/pegawai/foto/' . $request->link;
                } else {
                    $fotoPath = $request->link;
                }
            }

            // 3. Generate Kode Pegawai Otomatis (Contoh: PEG-202609-001)
            $codePegawai = 'PEG-' . date('Ym') . '-' . Str::random(5);

            // 4. Direct Insert ke Database menggunakan Query Builder DB::table
            DB::table('hrm_master_pegawai')->insert([
                'hrm_m_pegawai_code'    => $codePegawai,
                'hrm_m_pegawai_nip'     => $request->nip,
                'hrm_m_pegawai_nik'     => $request->nik,
                'hrm_m_pegawai_name'    => $request->name,
                'hrm_master_pegawai_dob' => $request->dob ?? date('Y-m-d'),
                'hrm_master_pegawai_dop' => $request->place ?? '-',
                'hrm_m_pegawai_agama'   => $request->agama ?? '-',
                'hrm_m_pegawai_sex'     => $request->jk,
                'hrm_m_pegawai_hp'      => $request->hp,
                'hrm_m_pegawai_email'   => $request->email ?? '-',
                'hrm_m_position_code'   => $request->posisi,
                'hrm_m_position_loc'    => $request->kota ?? '-',
                'hrm_m_jam_kerja_code'  => null, // Sesuaikan jika ada input jam kerja
                'hrm_m_pegawai_address' => $request->alamat ?? '-',
                'hrm_m_pegawai_img'     => $fotoPath,
                'created_at'            => now(),
                'updated_at'            => now(),
            ]);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data pegawai berhasil disimpan!'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
    public function master_data_pegawai_update(Request $request)
    {
        $data = DB::table('hrm_master_pegawai')->where('hrm_m_pegawai_code', $request->code)->first();
        $departemen = DB::table('hrm_departemen')->get(); // Diperlukan untuk dropdown departemen

        return view('app-hrm.master-pegawai.form.form-update-pegawai', compact('data', 'departemen'));
    }
    // Method Simpan Perubahan Data
    public function master_data_pegawai_update_store(Request $request)
    {
        try {
            $dataToUpdate = [
                'hrm_m_pegawai_name'      => $request->name,
                'hrm_m_pegawai_gender'    => $request->jk,
                'hrm_m_pegawai_nik'       => $request->nik,
                'hrm_m_pegawai_nip'       => $request->nip,
                'hrm_m_pegawai_dob'       => $request->dob,
                'hrm_m_pegawai_pob'       => $request->place,
                'hrm_m_pegawai_religion'  => $request->agama,
                'hrm_m_pegawai_phone'     => $request->hp,
                'hrm_m_pegawai_email'     => $request->email,
                'hrm_m_pegawai_dept_code' => $request->posisi,
                'hrm_m_pegawai_provinsi'  => $request->provinsi,
                'hrm_m_pegawai_kota'      => $request->kota,
                'hrm_m_pegawai_kecamatan' => $request->kecamatan,
                'hrm_m_pegawai_address'   => $request->alamat,
                'updated_at'              => now(),
            ];

            // Hanya perbarui foto jika ada file foto baru yang diunggah
            if (!empty($request->link)) {
                $dataToUpdate['hrm_m_pegawai_image'] = $request->link;
            }

            DB::table('hrm_master_pegawai')
                ->where('hrm_m_pegawai_code', $request->code)
                ->update($dataToUpdate);

            return response()->json([
                'status'  => 'success',
                'message' => 'Data pegawai berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal memperbarui data: ' . $e->getMessage()
            ], 500);
        }
    }
    public function master_data_pegawai_detail(Request $request)
    {
        $code = $request->code;
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $periodeSaatIni = Carbon::now()->format('Y-m'); // Format: 2026-09

        // 1. Data Pegawai + Departemen
        $data = DB::table('hrm_master_pegawai as p')
            ->leftJoin('hrm_departemen as d', 'p.hrm_m_position_code', '=', 'd.hrm_departemen_code')
            ->leftJoin('hrm_master_pegawai as kepala', 'd.hrm_departemen_kepala', '=', 'kepala.hrm_m_pegawai_code')
            ->select(
                'p.*',
                'd.hrm_departemen_name',
                'd.hrm_departemen_lokasi',
                'kepala.hrm_m_pegawai_name as nama_kepala_departemen'
            )
            ->where('p.hrm_m_pegawai_code', $code)
            ->first();

        if (!$data) {
            return response()->json(['message' => 'Data pegawai tidak ditemukan.'], 404);
        }

        // 2. Data KPI Pegawai (Rekap + Detail Item KPI)
        $kpiRekap = DB::table('hrm_kpi_rekap')
            ->where('hrm_m_pegawai_code', $code)
            ->orderBy('hrm_kpi_rekap_periode', 'desc')
            ->first();

        $totalSkorKpi = $kpiRekap->hrm_kpi_rekap_total ?? 0;
        $kategoriKpi  = $kpiRekap->hrm_kpi_rekap_cat ?? 'Belum Dievaluasi';

        // Item Detail KPI Pegawai
        $kpiItems = DB::table('hrm_kpi_pegawai as kp')
            ->join('hrm_kpi_master as km', 'kp.hrm_kpi_master_code', '=', 'km.hrm_kpi_master_code')
            ->select(
                'km.hrm_kpi_master_name',
                'km.hrm_kpi_master_desc',
                'km.hrm_kpi_master_target',
                'km.hrm_kpi_master_bobot',
                'km.hrm_kpi_master_type',
                'kp.hrm_kpi_pegawai_value',
                'kp.hrm_kpi_pegawai_score',
                'kp.hrm_kpi_pegawai_status',
                'kp.hrm_kpi_pegawai_catatan'
            )
            ->where('kp.hrm_m_pegawai_code', $code)
            ->where('kp.hrm_kpi_pegawai_periode', $kpiRekap->hrm_kpi_rekap_periode ?? $periodeSaatIni)
            ->get();

        // 3. Summary Quick KPI Top Cards
        $totalHadir = DB::table('hrm_absensi')
            ->where('hrm_m_pegawai_code', $code)
            ->whereMonth('hrm_absensi_date', $currentMonth)
            ->whereYear('hrm_absensi_date', $currentYear)
            ->whereIn('hrm_absensi_status', ['hadir', 'terlambat', 'dinas_luar'])
            ->count();

        $totalTerlambat = DB::table('hrm_absensi')
            ->where('hrm_m_pegawai_code', $code)
            ->whereMonth('hrm_absensi_date', $currentMonth)
            ->whereYear('hrm_absensi_date', $currentYear)
            ->where('hrm_absensi_status', 'terlambat')
            ->count();

        $totalLembur = DB::table('hrm_absensi')
            ->where('hrm_m_pegawai_code', $code)
            ->whereMonth('hrm_absensi_date', $currentMonth)
            ->whereYear('hrm_absensi_date', $currentYear)
            ->sum('hrm_absensi_overtime_hours');

        $kpiSummary = [
            'skor_total'     => $totalSkorKpi,
            'kategori'       => $kategoriKpi,
            'tepat_waktu'    => max(0, $totalHadir - $totalTerlambat),
            'terlambat'      => $totalTerlambat,
            'overtime_hours' => number_format($totalLembur, 1)
        ];

        // 4. Riwayat Absensi
        $absensi = DB::table('hrm_absensi')
            ->where('hrm_m_pegawai_code', $code)
            ->orderBy('hrm_absensi_date', 'desc')
            ->limit(10)
            ->get();

        // 5. Data Master Gaji & Payroll
        $gajiPokok = DB::table('hrm_m_gaji_pokok')
            ->where('hrm_m_pegawai_code', $code)
            ->first();

        $payrollSlip = DB::table('hrm_payroll_slip')
            ->where('hrm_m_pegawai_code', $code)
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get();

        return view('app-hrm.master-pegawai.form.form-detail-pegawai', compact(
            'data',
            'kpiSummary',
            'kpiRekap',
            'kpiItems',
            'absensi',
            'gajiPokok',
            'payrollSlip'
        ));
    }
    // MASTER Jabatan
    public function master_data_jabatan($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('app-hrm.master-pegawai.data-jabatan', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // MASTER Departemen
    public function master_data_departemen($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('hrm_departemen')->get();
            return view('app-hrm.master-pegawai.data-departemen', ['akses' => $akses, 'code' => $id], compact('data'));
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // MASTER KPI
    public function master_data_kpi($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('hrm_kpi_master')
                ->join('hrm_departemen', 'hrm_departemen.hrm_departemen_code', '=', 'hrm_kpi_master.hrm_departemen_code')
                ->get();
            return view('app-hrm.master-kpi.master-kpi', ['akses' => $akses, 'code' => $id], compact('data'));
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_data_kpi_add(Request $request)
    {
        $departemen = DB::table('hrm_departemen')->get();
        return view('app-hrm.master-kpi.master-kpi.form-add', compact('departemen'));
    }
    public function master_data_kpi_save(Request $request)
    {
        // 1. Validasi Input Data
        $validated = $request->validate([
            'nama'                  => 'required|string|max:255',
            'bobot'                 => 'required|numeric|min:0|max:100',
            'target'                => 'required|numeric',
            'departemen'            => 'required|string',
            'hrm_kpi_master_type'   => 'required|in:manual,kehadiran,sistem',
            'hrm_kpi_master_formula' => 'nullable|required_if:hrm_kpi_master_type,sistem|string',
            'desc'                  => 'nullable|string',
        ]);

        try {
            // 2. Insert ke Database
            DB::table('hrm_kpi_master')->insert([
                'hrm_kpi_master_code'    => (string) Str::uuid(),
                'hrm_departemen_code'    => $request->departemen,
                'hrm_kpi_master_name'    => $request->nama,
                'hrm_kpi_master_desc'    => $request->desc,
                'hrm_kpi_master_bobot'   => $request->bobot,
                'hrm_kpi_master_target'  => $request->target,
                'hrm_kpi_master_type'    => $request->hrm_kpi_master_type,
                'hrm_kpi_master_formula' => $request->hrm_kpi_master_type === 'sistem' ? $request->hrm_kpi_master_formula : null,
                'created_at'             => now(),
                'updated_at'             => now(),
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Master KPI berhasil disimpan!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan Master KPI: ' . $th->getMessage()
            ], 500);
        }
    }
    // MASTER KPI Pegawai
    public function master_data_kpi_pegawai($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('app-hrm.master-kpi.master-kpi-pegawai', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // MASTER KPI Rekap
    public function master_data_kpi_rekap($akses, $id, Request $request)
    {
        if ($this->url_akses($akses, $id) == true) {
            $departemens = DB::table('hrm_departemen')
                ->select('hrm_departemen_code', 'hrm_departemen_name')
                ->orderBy('hrm_departemen_name', 'asc')
                ->get();

            return view('app-hrm.master-kpi.master-kpi-rekap', [
                'id'              => $id,
                'departemens'     => $departemens,
                'selectedPeriode' => date('Y-m'),
                'akses' => $akses,
                'code' => $id
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_data_kpi_rekap_get(Request $request)
    {
        $selectedPeriode = $request->input('periode', date('Y-m'));
        $selectedDept    = $request->input('dept_code');
        $search          = $request->input('search');

        $query = DB::table('hrm_master_pegawai as p')
            ->leftJoin('hrm_departemen as d', 'p.hrm_m_position_code', '=', 'd.hrm_departemen_code')
            ->leftJoin('hrm_kpi_rekap as r', function ($join) use ($selectedPeriode) {
                $join->on('p.hrm_m_pegawai_code', '=', 'r.hrm_m_pegawai_code')
                    ->where('r.hrm_kpi_rekap_periode', '=', $selectedPeriode);
            })
            ->select(
                'p.hrm_m_pegawai_code',
                'p.hrm_m_pegawai_name',
                'p.hrm_m_pegawai_nip',
                'd.hrm_departemen_name',
                DB::raw("'$selectedPeriode' as periode"),
                DB::raw("COALESCE(r.hrm_kpi_rekap_total, 0) as total_score"),
                DB::raw("COALESCE(r.hrm_kpi_rekap_cat, 'Belum Dinilai') as kategori")
            );

        if (!empty($selectedDept)) {
            $query->where('p.hrm_m_position_code', $selectedDept);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('p.hrm_m_pegawai_name', 'LIKE', "%{$search}%")
                    ->orWhere('p.hrm_m_pegawai_nip', 'LIKE', "%{$search}%");
            });
        }

        $rekaps = $query->orderBy('total_score', 'desc')->get();

        $avgSkor = $rekaps->count() > 0 ? $rekaps->avg('total_score') : 0;
        $totalHighPerformer = $rekaps->where('total_score', '>=', 80)->count();
        $totalUnderPerformer = $rekaps->where('total_score', '>', 0)->where('total_score', '<', 70)->count();

        return response()->json([
            'status'              => 'success',
            'rekaps'              => $rekaps,
            'avgSkor'             => number_format($avgSkor, 1),
            'totalEvaluasi'       => $rekaps->count(),
            'totalHighPerformer'  => $totalHighPerformer,
            'totalUnderPerformer' => $totalUnderPerformer,
        ]);
    }
}
