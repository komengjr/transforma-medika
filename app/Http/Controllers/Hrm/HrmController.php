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
        $bulan = (int) $request->input('bulan', date('n'));
        $tahun = (int) $request->input('tahun', date('Y'));
        $periodeStr = sprintf('%04d-%02d', $tahun, $bulan);

        $query = DB::table('hrm_master_pegawai as p')
            ->leftJoin('hrm_departemen as d', 'p.hrm_m_position_code', '=', 'd.hrm_departemen_code')
            ->leftJoin('hrm_pegawai_pajak_bpjs as cfg', 'p.hrm_m_pegawai_code', '=', 'cfg.hrm_m_pegawai_code')
            ->leftJoin('hrm_master_ptkp as ptkp', 'cfg.hrm_ptkp_code', '=', 'ptkp.hrm_ptkp_code')
            ->select(
                'p.hrm_m_pegawai_code',
                'p.hrm_m_pegawai_name',
                'p.hrm_m_pegawai_nip',
                'p.hrm_m_pegawai_nik',
                'p.hrm_m_position_code',
                'd.hrm_departemen_name',
                'd.hrm_departemen_lokasi',
                'cfg.hrm_ptkp_code',
                'ptkp.hrm_ter_kategori',
                'cfg.metode_pajak',
                'cfg.is_bpjs_kes_aktif',
                'cfg.mode_bpjs_tk',
                'cfg.gaji_pokok',
                'cfg.tunjangan_tetap',
                'cfg.dasar_upah_bpjs'
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

        // Ambil rekap potongan bulanan jika sudah di-generate untuk periode ini
        $transaksiPotonganMap = DB::table('hrm_transaksi_potongan_bulanan')
            ->where('periode_payroll', $periodeStr)
            ->get()
            ->keyBy('hrm_m_pegawai_code');

        $bpjsConfig = DB::table('hrm_master_bpjs_config')
            ->where('is_active', true)
            ->first() ?? (object) [
                'bpjs_kes_karyawan_persen' => 1.00,
                'bpjs_kes_perusahaan_persen' => 4.00,
                'bpjs_kes_max_upah' => 12000000,
                'bpjs_jht_karyawan_persen' => 2.00,
                'bpjs_jht_perusahaan_persen' => 3.70,
                'bpjs_jp_karyawan_persen' => 1.00,
                'bpjs_jp_perusahaan_persen' => 2.00,
                'bpjs_jp_max_upah' => 10547400,
                'bpjs_jkk_perusahaan_persen' => 0.24,
                'bpjs_jkm_perusahaan_persen' => 0.30,
            ];

        $listTer = DB::table('hrm_master_ter_tarif')
            ->orderBy('hrm_ter_kategori')
            ->orderBy('bruto_min')
            ->get();

        $data = $pegawaiList->map(function ($p) use ($gajiPaidList, $transaksiPotonganMap, $bpjsConfig, $listTer) {
            $pegawaiKomponen = DB::table('hrm_pegawai_komponen as pk')
                ->join('hrm_komponen_gaji as k', 'pk.id_komponen', '=', 'k.id_komponen')
                ->where('pk.hrm_m_pegawai_code', $p->hrm_m_pegawai_code)
                ->where('k.is_active', true)
                ->select('k.tipe', 'pk.nominal')
                ->get();

            $totalPendapatan = 0.0;
            $totalPotonganKomponen = 0.0;
            $isConfigured = $pegawaiKomponen->isNotEmpty();

            if ($isConfigured) {
                foreach ($pegawaiKomponen as $pk) {
                    if ($pk->tipe === 'pendapatan') {
                        $totalPendapatan += floatval($pk->nominal);
                    } else {
                        $totalPotonganKomponen += floatval($pk->nominal);
                    }
                }
            } else {
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
                        $totalPotonganKomponen += floatval($dk->nominal_default);
                    }
                }
            }

            // Gabungkan potongan BPJS Kes, BPJS TK & PPh 21
            $trxPotongan = $transaksiPotonganMap->get($p->hrm_m_pegawai_code);
            if ($trxPotongan) {
                $potBpjsKes = (float) $trxPotongan->pot_bpjs_kes_karyawan;
                $potJht = (float) $trxPotongan->pot_bpjs_jht_karyawan;
                $potJp = (float) $trxPotongan->pot_bpjs_jp_karyawan;
                $potBpjsTk = $potJht + $potJp;
                $potPph21 = (float) $trxPotongan->pot_pph21_karyawan;
                $tarifTerPersen = (float) $trxPotongan->tarif_ter_persen;
                $totalPotonganBpjsPajak = (float) $trxPotongan->total_potongan_karyawan;
            } else {
                $brutoPajak = ((float) ($p->gaji_pokok ?? 0) + (float) ($p->tunjangan_tetap ?? 0)) > 0
                    ? ((float) ($p->gaji_pokok ?? 0) + (float) ($p->tunjangan_tetap ?? 0))
                    : $totalPendapatan;

                $dasarUpahBpjs = (float) ($p->dasar_upah_bpjs ?? 0) > 0
                    ? (float) $p->dasar_upah_bpjs
                    : $brutoPajak;

                $calc = $this->hitungKomponenPotongan($p, $dasarUpahBpjs, $brutoPajak, $bpjsConfig, $listTer);
                $potBpjsKes = $calc['pot_bpjs_kes'];
                $potJht = $calc['pot_jht'];
                $potJp = $calc['pot_jp'];
                $potBpjsTk = $calc['pot_bpjs_tk'];
                $potPph21 = $calc['pot_pph21_karyawan'];
                $tarifTerPersen = $calc['tarif_ter_persen'];
                $totalPotonganBpjsPajak = $calc['total_potongan'];
            }

            $p->total_pendapatan = $totalPendapatan;
            $p->total_potongan_komponen = $totalPotonganKomponen;
            $p->total_potongan_bpjs_pajak = $totalPotonganBpjsPajak;
            $p->total_potongan = $totalPotonganKomponen + $totalPotonganBpjsPajak;
            $p->potongan_detail = [
                'bpjs_kes' => $potBpjsKes,
                'bpjs_tk_jht' => $potJht,
                'bpjs_tk_jp' => $potJp,
                'bpjs_tk' => $potBpjsTk,
                'pph21' => $potPph21,
                'tarif_ter_persen' => $tarifTerPersen,
                'ptkp' => $p->hrm_ptkp_code ?? 'TK/0',
                'ter_kategori' => $p->hrm_ter_kategori ?? 'A',
                'metode_pajak' => $p->metode_pajak ?? 'GROSS',
                'sumber' => $trxPotongan ? 'TRANSAKSI_PERIODE' : 'SIMULASI_MASTER',
            ];
            $p->is_configured = $isConfigured;
            $p->is_paid = in_array($p->hrm_m_pegawai_code, $gajiPaidList);

            return $p;
        });

        $totalGajiEstimasi = $data->sum(function ($item) {
            return $item->total_pendapatan - $item->total_potongan;
        });

        return response()->json([
            'status' => true,
            'periode' => $periodeStr,
            'data' => $data,
            'stats' => [
                'totalPegawai' => $data->count(),
                'totalGajiEstimasi' => 'Rp ' . number_format($totalGajiEstimasi, 0, ',', '.'),
                'pendingGaji' => $data->where('is_paid', false)->count()
            ]
        ]);
    }

    public function payroll_data_gaji_get_detail(Request $request, $pegawaiCode)
    {
        $bulan = (int) $request->input('bulan', date('n'));
        $tahun = (int) $request->input('tahun', date('Y'));
        $periodeStr = sprintf('%04d-%02d', $tahun, $bulan);

        $pegawai = DB::table('hrm_master_pegawai as p')
            ->leftJoin('hrm_departemen as d', 'p.hrm_m_position_code', '=', 'd.hrm_departemen_code')
            ->where('p.hrm_m_pegawai_code', $pegawaiCode)
            ->select('p.*', 'd.hrm_departemen_name', 'd.hrm_departemen_lokasi')
            ->first();

        if (!$pegawai) {
            return response()->json(['status' => false, 'message' => 'Pegawai tidak ditemukan.'], 404);
        }

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

        $pajakBpjsCfg = DB::table('hrm_pegawai_pajak_bpjs as cfg')
            ->leftJoin('hrm_master_ptkp as ptkp', 'cfg.hrm_ptkp_code', '=', 'ptkp.hrm_ptkp_code')
            ->where('cfg.hrm_m_pegawai_code', $pegawaiCode)
            ->select('cfg.*', 'ptkp.hrm_ter_kategori')
            ->first();

        $trxPotongan = DB::table('hrm_transaksi_potongan_bulanan')
            ->where('hrm_m_pegawai_code', $pegawaiCode)
            ->where('periode_payroll', $periodeStr)
            ->first();

        $bpjsConfig = DB::table('hrm_master_bpjs_config')
            ->where('is_active', true)
            ->first() ?? (object) [
                'bpjs_kes_karyawan_persen' => 1.00,
                'bpjs_kes_perusahaan_persen' => 4.00,
                'bpjs_kes_max_upah' => 12000000,
                'bpjs_jht_karyawan_persen' => 2.00,
                'bpjs_jht_perusahaan_persen' => 3.70,
                'bpjs_jp_karyawan_persen' => 1.00,
                'bpjs_jp_perusahaan_persen' => 2.00,
                'bpjs_jp_max_upah' => 10547400,
                'bpjs_jkk_perusahaan_persen' => 0.24,
                'bpjs_jkm_perusahaan_persen' => 0.30,
            ];

        $listTer = DB::table('hrm_master_ter_tarif')
            ->orderBy('hrm_ter_kategori')
            ->orderBy('bruto_min')
            ->get();

        if ($trxPotongan) {
            $potonganBpjsPajak = [
                'bpjs_kes' => (float) $trxPotongan->pot_bpjs_kes_karyawan,
                'bpjs_tk_jht' => (float) $trxPotongan->pot_bpjs_jht_karyawan,
                'bpjs_tk_jp' => (float) $trxPotongan->pot_bpjs_jp_karyawan,
                'bpjs_tk' => (float) $trxPotongan->pot_bpjs_jht_karyawan + (float) $trxPotongan->pot_bpjs_jp_karyawan,
                'pph21' => (float) $trxPotongan->pot_pph21_karyawan,
                'tarif_ter_persen' => (float) $trxPotongan->tarif_ter_persen,
                'total_potongan' => (float) $trxPotongan->total_potongan_karyawan,
                'ptkp' => $trxPotongan->hrm_ptkp_code ?? 'TK/0',
                'ter_kategori' => $trxPotongan->hrm_ter_kategori ?? 'A',
                'metode_pajak' => $trxPotongan->metode_pajak ?? 'GROSS',
            ];
        } else {
            $totalPendapatanKomponen = $komponen->where('tipe', 'pendapatan')->sum('nominal_default');
            $brutoPajak = ((float) ($pajakBpjsCfg->gaji_pokok ?? 0) + (float) ($pajakBpjsCfg->tunjangan_tetap ?? 0)) > 0
                ? ((float) ($pajakBpjsCfg->gaji_pokok ?? 0) + (float) ($pajakBpjsCfg->tunjangan_tetap ?? 0))
                : (float) $totalPendapatanKomponen;

            $dasarUpahBpjs = (float) ($pajakBpjsCfg->dasar_upah_bpjs ?? 0) > 0
                ? (float) $pajakBpjsCfg->dasar_upah_bpjs
                : $brutoPajak;

            $calc = $this->hitungKomponenPotongan(
                $pajakBpjsCfg ?? (object) [],
                $dasarUpahBpjs,
                $brutoPajak,
                $bpjsConfig,
                $listTer
            );

            $potonganBpjsPajak = [
                'bpjs_kes' => $calc['pot_bpjs_kes'],
                'bpjs_tk_jht' => $calc['pot_jht'],
                'bpjs_tk_jp' => $calc['pot_jp'],
                'bpjs_tk' => $calc['pot_bpjs_tk'],
                'pph21' => $calc['pot_pph21_karyawan'],
                'tarif_ter_persen' => $calc['tarif_ter_persen'],
                'total_potongan' => $calc['total_potongan'],
                'ptkp' => $pajakBpjsCfg->hrm_ptkp_code ?? 'TK/0',
                'ter_kategori' => $pajakBpjsCfg->hrm_ter_kategori ?? 'A',
                'metode_pajak' => $pajakBpjsCfg->metode_pajak ?? 'GROSS',
            ];
        }

        return response()->json([
            'status' => true,
            'pegawai' => $pegawai,
            'komponen' => $komponen,
            'gaji' => $gajiInfo,
            'pajak_bpjs' => $pajakBpjsCfg,
            'potongan_bpjs_pajak' => $potonganBpjsPajak,
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
    public function payroll_pajak_bpjs($akses, $id, Request $request = null)
    {
        if ($this->url_akses_sub($akses, $id) != true) {
            return Redirect::to('dashboard/home');
        }

        $request = $request ?? request();
        $periode = $request->get('periode', now()->format('Y-m'));

        $bpjsConfig = DB::table('hrm_master_bpjs_config')
            ->where('is_active', true)
            ->first() ?? (object) [
                'hrm_bpjs_config_code' => 'DEFAULT_2026',
                'bpjs_kes_karyawan_persen' => 1.00,
                'bpjs_kes_perusahaan_persen' => 4.00,
                'bpjs_kes_max_upah' => 12000000,
                'bpjs_jht_karyawan_persen' => 2.00,
                'bpjs_jht_perusahaan_persen' => 3.70,
                'bpjs_jp_karyawan_persen' => 1.00,
                'bpjs_jp_perusahaan_persen' => 2.00,
                'bpjs_jp_max_upah' => 10547400,
                'bpjs_jkk_perusahaan_persen' => 0.24,
                'bpjs_jkm_perusahaan_persen' => 0.30,
            ];

        $listPtkp = DB::table('hrm_master_ptkp')->orderBy('id_hrm_master_ptkp')->get();
        $listDepartemen = DB::table('hrm_departemen')->orderBy('hrm_departemen_name')->get();
        $listJabatan = DB::table('hrm_jabatan')->orderBy('hrm_jabatan_name')->get();
        $listTer = DB::table('hrm_master_ter_tarif')
            ->orderBy('hrm_ter_kategori')
            ->orderBy('bruto_min')
            ->get();

        $pegawaiRows = DB::table('hrm_master_pegawai as p')
            ->leftJoin('hrm_pegawai_pajak_bpjs as cfg', 'p.hrm_m_pegawai_code', '=', 'cfg.hrm_m_pegawai_code')
            ->leftJoin('hrm_master_ptkp as ptkp', 'cfg.hrm_ptkp_code', '=', 'ptkp.hrm_ptkp_code')
            ->leftJoin('hrm_departemen as dept', 'cfg.hrm_departemen_code', '=', 'dept.hrm_departemen_code')
            ->leftJoin('hrm_jabatan as jab', 'cfg.hrm_jabatan_code', '=', 'jab.hrm_jabatan_code')
            ->leftJoin('hrm_master_position as pos', 'p.hrm_m_position_code', '=', 'pos.hrm_master_position_code')
            ->select([
                'p.id_hrm_m_pegawai',
                'p.hrm_m_pegawai_code',
                'p.hrm_m_pegawai_nip',
                'p.hrm_m_pegawai_nik',
                'p.hrm_m_pegawai_name',
                'p.hrm_m_position_code',
                'pos.hrm_master_position_name',
                DB::raw("COALESCE(dept.hrm_departemen_name, 'Umum') as nama_departemen"),
                DB::raw("COALESCE(cfg.hrm_departemen_code, '') as hrm_departemen_code"),
                DB::raw("COALESCE(jab.hrm_jabatan_name, pos.hrm_master_position_name, 'Staff') as nama_jabatan"),
                DB::raw("COALESCE(cfg.hrm_jabatan_code, '') as hrm_jabatan_code"),
                DB::raw("COALESCE(cfg.npwp_nomor, '-') as npwp_nomor"),
                DB::raw("COALESCE(cfg.is_npwp_valid, 1) as is_npwp_valid"),
                DB::raw("COALESCE(cfg.hrm_ptkp_code, 'TK/0') as hrm_ptkp_code"),
                DB::raw("COALESCE(ptkp.hrm_ter_kategori, 'A') as hrm_ter_kategori"),
                DB::raw("COALESCE(cfg.metode_pajak, 'GROSS') as metode_pajak"),
                DB::raw("COALESCE(cfg.no_bpjs_kesehatan, '-') as no_bpjs_kesehatan"),
                DB::raw("COALESCE(cfg.is_bpjs_kes_aktif, 1) as is_bpjs_kes_aktif"),
                DB::raw("COALESCE(cfg.no_bpjs_ketenagakerjaan, '-') as no_bpjs_ketenagakerjaan"),
                DB::raw("COALESCE(cfg.mode_bpjs_tk, 'FULL') as mode_bpjs_tk"),
                DB::raw("COALESCE(cfg.gaji_pokok, 0) as gaji_pokok"),
                DB::raw("COALESCE(cfg.tunjangan_tetap, 0) as tunjangan_tetap"),
                DB::raw("COALESCE(cfg.dasar_upah_bpjs, 0) as dasar_upah_bpjs"),
            ])
            ->orderBy('p.hrm_m_pegawai_name')
            ->get();

        $pegawaiFormatted = $pegawaiRows->map(function ($row) use ($bpjsConfig, $listTer) {
            $brutoPajak = (float) $row->gaji_pokok + (float) $row->tunjangan_tetap;
            $dasarUpahBpjs = (float) $row->dasar_upah_bpjs > 0 ? (float) $row->dasar_upah_bpjs : $brutoPajak;

            $calc = $this->hitungKomponenPotongan(
                $row,
                $dasarUpahBpjs,
                $brutoPajak,
                $bpjsConfig,
                $listTer
            );

            return [
                'id' => $row->id_hrm_m_pegawai,
                'code' => $row->hrm_m_pegawai_code,
                'nip' => $row->hrm_m_pegawai_nip,
                'nik' => $row->hrm_m_pegawai_nik,
                'nama' => $row->hrm_m_pegawai_name,
                'divisi' => $row->nama_departemen,
                'divisi_code' => $row->hrm_departemen_code,
                'jabatan' => $row->nama_jabatan,
                'jabatan_code' => $row->hrm_jabatan_code,
                'ptkp' => $row->hrm_ptkp_code,
                'ter_kategori' => $row->hrm_ter_kategori,
                'npwp' => $row->npwp_nomor,
                'hasNpwp' => (bool) $row->is_npwp_valid,
                'gajiPokok' => (float) $row->gaji_pokok,
                'tunjanganTetap' => (float) $row->tunjangan_tetap,
                'upahBpjs' => $dasarUpahBpjs,
                'brutoPajak' => $brutoPajak,
                'bpjsKesAktif' => (bool) $row->is_bpjs_kes_aktif,
                'bpjsTkMode' => strtolower($row->mode_bpjs_tk),
                'metodePajak' => $row->metode_pajak,
                'perhitungan' => $calc,
            ];
        })->values();

        return view('app-hrm.payroll.bpjs-dan-pajak', [
            'akses' => $akses,
            'code' => $id,
            'periode' => $periode,
            'bpjsConfig' => $bpjsConfig,
            'listPtkp' => $listPtkp,
            'listDepartemen' => $listDepartemen,
            'listJabatan' => $listJabatan,
            'listTer' => $listTer,
            'pegawaiData' => $pegawaiFormatted,
        ]);
    }
    private function hitungKomponenPotongan($pegawai, float $dasarUpahBpjs, float $brutoPajak, $bpjsConfig, $listTer): array
    {
        $isKesAktif = (bool) ($pegawai->is_bpjs_kes_aktif ?? true);
        $modeTk = strtoupper($pegawai->mode_bpjs_tk ?? 'FULL');
        $kategoriTer = strtoupper($pegawai->hrm_ter_kategori ?? 'A');
        $metodePajak = strtoupper($pegawai->metode_pajak ?? 'GROSS');

        $dasarKes = min($dasarUpahBpjs, (float) $bpjsConfig->bpjs_kes_max_upah);
        $potBpjsKes = $isKesAktif ? round($dasarKes * ((float) $bpjsConfig->bpjs_kes_karyawan_persen / 100)) : 0;
        $ptBpjsKes = $isKesAktif ? round($dasarKes * ((float) $bpjsConfig->bpjs_kes_perusahaan_persen / 100)) : 0;

        $potJht = 0;
        $potJp = 0;
        if (in_array($modeTk, ['FULL', 'JHT_ONLY'])) {
            $potJht = round($dasarUpahBpjs * ((float) $bpjsConfig->bpjs_jht_karyawan_persen / 100));
        }
        if ($modeTk === 'FULL') {
            $dasarJp = min($dasarUpahBpjs, (float) $bpjsConfig->bpjs_jp_max_upah);
            $potJp = round($dasarJp * ((float) $bpjsConfig->bpjs_jp_karyawan_persen / 100));
        }
        $potBpjsTk = $potJht + $potJp;

        $tarifRow = $listTer
            ->where('hrm_ter_kategori', $kategoriTer)
            ->filter(function ($item) use ($brutoPajak) {
                $minOk = $brutoPajak >= (float) $item->bruto_min;
                $maxOk = is_null($item->bruto_max) || $brutoPajak <= (float) $item->bruto_max;
                return $minOk && $maxOk;
            })
            ->first();

        $tarifPersen = $tarifRow ? (float) $tarifRow->tarif_persen : 0.0;
        $nilaiPph21 = round($brutoPajak * ($tarifPersen / 100));
        $potPph21Karyawan = ($metodePajak === 'GROSS') ? $nilaiPph21 : 0;

        $totalPotongan = $potBpjsKes + $potBpjsTk + $potPph21Karyawan;

        return [
            'pot_bpjs_kes' => $potBpjsKes,
            'pt_bpjs_kes' => $ptBpjsKes,
            'pot_jht' => $potJht,
            'pot_jp' => $potJp,
            'pot_bpjs_tk' => $potBpjsTk,
            'tarif_ter_persen' => $tarifPersen,
            'nilai_pph21' => $nilaiPph21,
            'pot_pph21_karyawan' => $potPph21Karyawan,
            'total_potongan' => $totalPotongan,
        ];
    }

    public function simpan_skema_potongan_pegawai(Request $request)
    {
        $validated = $request->validate([
            'hrm_m_pegawai_code' => 'required|string',
            'hrm_ptkp_code' => 'required|string',
            'npwp_nomor' => 'nullable|string|max:30',
            'is_npwp_valid' => 'required|boolean',
            'metode_pajak' => 'required|in:GROSS,NET,GROSS_UP',
            'is_bpjs_kes_aktif' => 'required|boolean',
            'mode_bpjs_tk' => 'required|in:FULL,JHT_ONLY,NONAKTIF',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan_tetap' => 'required|numeric|min:0',
            'dasar_upah_bpjs' => 'required|numeric|min:0',
        ]);

        DB::table('hrm_pegawai_pajak_bpjs')->updateOrInsert(
            ['hrm_m_pegawai_code' => $validated['hrm_m_pegawai_code']],
            array_merge($validated, ['updated_at' => now()])
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Pengaturan potongan pegawai berhasil disimpan.',
        ]);
    }
    public function simpan_skema_potongan_massal(Request $request)
    {
        $validated = $request->validate([
            'target_type' => 'required|in:all,divisi,jabatan',
            'target_value' => 'nullable|string',
            'is_bpjs_kes_aktif' => 'nullable|in:keep,0,1',
            'mode_bpjs_tk' => 'nullable|in:keep,FULL,JHT_ONLY,NONAKTIF',
            'metode_pajak' => 'nullable|in:keep,GROSS,NET,GROSS_UP',
        ]);

        $allPegawai = DB::table('hrm_master_pegawai')->pluck('hrm_m_pegawai_code');
        foreach ($allPegawai as $kodePegawai) {
            DB::table('hrm_pegawai_pajak_bpjs')->insertOrIgnore([
                'hrm_m_pegawai_code' => $kodePegawai,
                'hrm_ptkp_code' => 'TK/0',
                'metode_pajak' => 'GROSS',
                'is_bpjs_kes_aktif' => true,
                'mode_bpjs_tk' => 'FULL',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $query = DB::table('hrm_pegawai_pajak_bpjs');
        if ($validated['target_type'] === 'divisi' && !empty($validated['target_value'])) {
            $query->where('hrm_departemen_code', $validated['target_value']);
        } elseif ($validated['target_type'] === 'jabatan' && !empty($validated['target_value'])) {
            $query->where('hrm_jabatan_code', $validated['target_value']);
        }

        $updateData = ['updated_at' => now()];
        if (!empty($validated['is_bpjs_kes_aktif']) && $validated['is_bpjs_kes_aktif'] !== 'keep') {
            $updateData['is_bpjs_kes_aktif'] = (int) $validated['is_bpjs_kes_aktif'];
        }
        if (!empty($validated['mode_bpjs_tk']) && $validated['mode_bpjs_tk'] !== 'keep') {
            $updateData['mode_bpjs_tk'] = $validated['mode_bpjs_tk'];
        }
        if (!empty($validated['metode_pajak']) && $validated['metode_pajak'] !== 'keep') {
            $updateData['metode_pajak'] = $validated['metode_pajak'];
        }

        $affected = $query->update($updateData);

        return response()->json([
            'status' => 'success',
            'message' => "Skema potongan berhasil diterapkan ke {$affected} data pegawai.",
        ]);
    }
    public function simpan_master_tarif(Request $request)
    {
        $validated = $request->validate([
            'bpjs_kes_max_upah' => 'required|numeric|min:0',
            'bpjs_jp_max_upah' => 'required|numeric|min:0',
            'bpjs_jkk_perusahaan_persen' => 'required|numeric|min:0',
        ]);

        DB::table('hrm_master_bpjs_config')
            ->where('is_active', true)
            ->update(array_merge($validated, ['updated_at' => now()]));

        return response()->json([
            'status' => 'success',
            'message' => 'Parameter tarif BPJS berhasil diperbarui.',
        ]);
    }
    public function simpan_potongan_periode(Request $request)
    {
        $validated = $request->validate([
            'periode_payroll' => 'required|string|size:7', // YYYY-MM
        ]);

        $bpjsConfig = DB::table('hrm_master_bpjs_config')->where('is_active', true)->first();
        if (!$bpjsConfig) {
            return response()->json(['status' => 'error', 'message' => 'Konfigurasi BPJS aktif belum ditemukan.'], 422);
        }

        $listTer = DB::table('hrm_master_ter_tarif')->get();
        $rows = DB::table('hrm_master_pegawai as p')
            ->leftJoin('hrm_pegawai_pajak_bpjs as cfg', 'p.hrm_m_pegawai_code', '=', 'cfg.hrm_m_pegawai_code')
            ->leftJoin('hrm_master_ptkp as ptkp', 'cfg.hrm_ptkp_code', '=', 'ptkp.hrm_ptkp_code')
            ->select([
                'p.hrm_m_pegawai_code',
                'cfg.hrm_departemen_code',
                'cfg.hrm_jabatan_code',
                DB::raw("COALESCE(cfg.hrm_ptkp_code, 'TK/0') as hrm_ptkp_code"),
                DB::raw("COALESCE(ptkp.hrm_ter_kategori, 'A') as hrm_ter_kategori"),
                DB::raw("COALESCE(cfg.metode_pajak, 'GROSS') as metode_pajak"),
                DB::raw("COALESCE(cfg.is_bpjs_kes_aktif, 1) as is_bpjs_kes_aktif"),
                DB::raw("COALESCE(cfg.mode_bpjs_tk, 'FULL') as mode_bpjs_tk"),
                DB::raw("COALESCE(cfg.gaji_pokok, 0) as gaji_pokok"),
                DB::raw("COALESCE(cfg.tunjangan_tetap, 0) as tunjangan_tetap"),
                DB::raw("COALESCE(cfg.dasar_upah_bpjs, 0) as dasar_upah_bpjs"),
            ])
            ->get();

        foreach ($rows as $row) {
            $bruto = (float) $row->gaji_pokok + (float) $row->tunjangan_tetap;
            $dasarBpjs = (float) $row->dasar_upah_bpjs > 0 ? (float) $row->dasar_upah_bpjs : $bruto;
            $calc = $this->hitungKomponenPotongan($row, $dasarBpjs, $bruto, $bpjsConfig, $listTer);

            DB::table('hrm_transaksi_potongan_bulanan')->updateOrInsert(
                [
                    'periode_payroll' => $validated['periode_payroll'],
                    'hrm_m_pegawai_code' => $row->hrm_m_pegawai_code,
                ],
                [
                    'kode_transaksi_potongan' => 'POT-' . str_replace('-', '', $validated['periode_payroll']) . '-' . $row->hrm_m_pegawai_code,
                    'hrm_departemen_code' => $row->hrm_departemen_code,
                    'hrm_jabatan_code' => $row->hrm_jabatan_code,
                    'hrm_ptkp_code' => $row->hrm_ptkp_code,
                    'hrm_ter_kategori' => $row->hrm_ter_kategori,
                    'metode_pajak' => $row->metode_pajak,
                    'dasar_upah_bpjs' => $dasarBpjs,
                    'penghasilan_bruto_pajak' => $bruto,
                    'pot_bpjs_kes_karyawan' => $calc['pot_bpjs_kes'],
                    'pot_bpjs_jht_karyawan' => $calc['pot_jht'],
                    'pot_bpjs_jp_karyawan' => $calc['pot_jp'],
                    'tarif_ter_persen' => $calc['tarif_ter_persen'],
                    'nilai_pph21' => $calc['nilai_pph21'],
                    'pot_pph21_karyawan' => $calc['pot_pph21_karyawan'],
                    'total_potongan_karyawan' => $calc['total_potongan'],
                    'tanggungan_bpjs_kes_pt' => $calc['pt_bpjs_kes'],
                    'tanggungan_bpjs_jkk_pt' => round($dasarBpjs * ((float) $bpjsConfig->bpjs_jkk_perusahaan_persen / 100)),
                    'tanggungan_bpjs_jkm_pt' => round($dasarBpjs * ((float) $bpjsConfig->bpjs_jkm_perusahaan_persen / 100)),
                    'status_posting' => 'DRAFT',
                    'updated_at' => now(),
                ]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => "Potongan periode {$validated['periode_payroll']} berhasil dihitung dan disimpan ke database.",
        ]);
    }

    public function get_data_potongan_pegawai(Request $request)
    {
        $periode = $request->get('periode', now()->format('Y-m'));
        $divisi = $request->get('divisi');
        $jabatan = $request->get('jabatan');
        $ptkpCode = $request->get('ptkp');

        $bpjsConfig = DB::table('hrm_master_bpjs_config')
            ->where('is_active', true)
            ->first() ?? (object) [
                'bpjs_kes_karyawan_persen' => 1.00,
                'bpjs_kes_perusahaan_persen' => 4.00,
                'bpjs_kes_max_upah' => 12000000,
                'bpjs_jht_karyawan_persen' => 2.00,
                'bpjs_jht_perusahaan_persen' => 3.70,
                'bpjs_jp_karyawan_persen' => 1.00,
                'bpjs_jp_perusahaan_persen' => 2.00,
                'bpjs_jp_max_upah' => 10547400,
                'bpjs_jkk_perusahaan_persen' => 0.24,
                'bpjs_jkm_perusahaan_persen' => 0.30,
            ];

        $listTer = DB::table('hrm_master_ter_tarif')
            ->orderBy('hrm_ter_kategori')
            ->orderBy('bruto_min')
            ->get();

        $query = DB::table('hrm_master_pegawai as p')
            ->leftJoin('hrm_pegawai_pajak_bpjs as cfg', 'p.hrm_m_pegawai_code', '=', 'cfg.hrm_m_pegawai_code')
            ->leftJoin('hrm_master_ptkp as ptkp', 'cfg.hrm_ptkp_code', '=', 'ptkp.hrm_ptkp_code')
            ->leftJoin('hrm_departemen as dept', 'cfg.hrm_departemen_code', '=', 'dept.hrm_departemen_code')
            ->leftJoin('hrm_jabatan as jab', 'cfg.hrm_jabatan_code', '=', 'jab.hrm_jabatan_code')
            ->leftJoin('hrm_master_position as pos', 'p.hrm_m_position_code', '=', 'pos.hrm_master_position_code')
            ->select([
                'p.id_hrm_m_pegawai',
                'p.hrm_m_pegawai_code',
                'p.hrm_m_pegawai_nip',
                'p.hrm_m_pegawai_nik',
                'p.hrm_m_pegawai_name',
                DB::raw("COALESCE(dept.hrm_departemen_name, 'Umum') as nama_departemen"),
                DB::raw("COALESCE(cfg.hrm_departemen_code, '') as hrm_departemen_code"),
                DB::raw("COALESCE(jab.hrm_jabatan_name, pos.hrm_master_position_name, 'Staff') as nama_jabatan"),
                DB::raw("COALESCE(cfg.hrm_jabatan_code, '') as hrm_jabatan_code"),
                DB::raw("COALESCE(cfg.npwp_nomor, '-') as npwp_nomor"),
                DB::raw("COALESCE(cfg.is_npwp_valid, 1) as is_npwp_valid"),
                DB::raw("COALESCE(cfg.hrm_ptkp_code, 'TK/0') as hrm_ptkp_code"),
                DB::raw("COALESCE(ptkp.hrm_ter_kategori, 'A') as hrm_ter_kategori"),
                DB::raw("COALESCE(cfg.metode_pajak, 'GROSS') as metode_pajak"),
                DB::raw("COALESCE(cfg.is_bpjs_kes_aktif, 1) as is_bpjs_kes_aktif"),
                DB::raw("COALESCE(cfg.mode_bpjs_tk, 'FULL') as mode_bpjs_tk"),
                DB::raw("COALESCE(cfg.gaji_pokok, 0) as gaji_pokok"),
                DB::raw("COALESCE(cfg.tunjangan_tetap, 0) as tunjangan_tetap"),
                DB::raw("COALESCE(cfg.dasar_upah_bpjs, 0) as dasar_upah_bpjs"),
            ]);

        if (!empty($divisi)) {
            $query->where('cfg.hrm_departemen_code', $divisi);
        }
        if (!empty($jabatan)) {
            $query->where('cfg.hrm_jabatan_code', $jabatan);
        }
        if (!empty($ptkpCode)) {
            $query->where(DB::raw("COALESCE(cfg.hrm_ptkp_code, 'TK/0')"), $ptkpCode);
        }

        $rows = $query->orderBy('p.hrm_m_pegawai_name')->get();

        $data = $rows->map(function ($row) use ($bpjsConfig, $listTer) {
            $brutoPajak = (float) $row->gaji_pokok + (float) $row->tunjangan_tetap;
            $dasarUpahBpjs = (float) $row->dasar_upah_bpjs > 0 ? (float) $row->dasar_upah_bpjs : $brutoPajak;
            $calc = $this->hitungKomponenPotongan($row, $dasarUpahBpjs, $brutoPajak, $bpjsConfig, $listTer);

            return [
                'id' => $row->id_hrm_m_pegawai,
                'code' => $row->hrm_m_pegawai_code,
                'nip' => $row->hrm_m_pegawai_nip,
                'nik' => $row->hrm_m_pegawai_nik,
                'nama' => $row->hrm_m_pegawai_name,
                'divisi' => $row->nama_departemen,
                'divisi_code' => $row->hrm_departemen_code,
                'jabatan' => $row->nama_jabatan,
                'jabatan_code' => $row->hrm_jabatan_code,
                'ptkp' => $row->hrm_ptkp_code,
                'ter_kategori' => $row->hrm_ter_kategori,
                'npwp' => $row->npwp_nomor,
                'hasNpwp' => (bool) $row->is_npwp_valid,
                'gajiPokok' => (float) $row->gaji_pokok,
                'tunjanganTetap' => (float) $row->tunjangan_tetap,
                'upahBpjs' => $dasarUpahBpjs,
                'brutoPajak' => $brutoPajak,
                'bpjsKesAktif' => (bool) $row->is_bpjs_kes_aktif,
                'bpjsTkMode' => strtolower($row->mode_bpjs_tk),
                'metodePajak' => $row->metode_pajak,
                'perhitungan' => $calc,
            ];
        })->values();

        return response()->json([
            'status' => 'success',
            'periode' => $periode,
            'total_potongan' => $data->sum(fn($item) => $item['perhitungan']['total_potongan']),
            'data' => $data,
        ]);
    }
    public function get_detail_potongan_pegawai(string $pegawaiCode)
    {
        $pegawai = DB::table('hrm_master_pegawai as p')
            ->leftJoin('hrm_pegawai_pajak_bpjs as cfg', 'p.hrm_m_pegawai_code', '=', 'cfg.hrm_m_pegawai_code')
            ->leftJoin('hrm_master_ptkp as ptkp', 'cfg.hrm_ptkp_code', '=', 'ptkp.hrm_ptkp_code')
            ->where('p.hrm_m_pegawai_code', $pegawaiCode)
            ->select([
                'p.*',
                'cfg.hrm_departemen_code',
                'cfg.hrm_jabatan_code',
                'cfg.npwp_nomor',
                'cfg.is_npwp_valid',
                'cfg.hrm_ptkp_code',
                'ptkp.hrm_ter_kategori',
                'cfg.metode_pajak',
                'cfg.no_bpjs_kesehatan',
                'cfg.is_bpjs_kes_aktif',
                'cfg.no_bpjs_ketenagakerjaan',
                'cfg.mode_bpjs_tk',
                'cfg.gaji_pokok',
                'cfg.tunjangan_tetap',
                'cfg.dasar_upah_bpjs',
            ])
            ->first();

        if (!$pegawai) {
            return response()->json(['status' => 'error', 'message' => 'Data pegawai tidak ditemukan.'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $pegawai]);
    }
    public function get_master_referensi_pajak()
    {
        return response()->json([
            'status' => 'success',
            'bpjs_config' => DB::table('hrm_master_bpjs_config')->where('is_active', true)->first(),
            'ptkp' => DB::table('hrm_master_ptkp')->orderBy('id_hrm_master_ptkp')->get(),
            'ter_tarif' => DB::table('hrm_master_ter_tarif')->orderBy('hrm_ter_kategori')->orderBy('bruto_min')->get(),
            'departemen' => DB::table('hrm_departemen')->orderBy('hrm_departemen_name')->get(),
            'jabatan' => DB::table('hrm_jabatan')->orderBy('hrm_jabatan_name')->get(),
        ]);
    }
    public function get_rekap_potongan_periode(Request $request)
    {
        $periode = $request->get('periode_payroll', now()->format('Y-m'));

        $rows = DB::table('hrm_transaksi_potongan_bulanan as tr')
            ->leftJoin('hrm_master_pegawai as p', 'tr.hrm_m_pegawai_code', '=', 'p.hrm_m_pegawai_code')
            ->where('tr.periode_payroll', $periode)
            ->select('tr.*', 'p.hrm_m_pegawai_name', 'p.hrm_m_pegawai_nik')
            ->orderBy('p.hrm_m_pegawai_name')
            ->get();

        return response()->json([
            'status' => 'success',
            'periode_payroll' => $periode,
            'total_potongan_karyawan' => $rows->sum('total_potongan_karyawan'),
            'data' => $rows,
        ]);
    }
    public function posting_potongan_periode(Request $request)
    {
        $validated = $request->validate([
            'periode_payroll' => 'required|string|size:7',
        ]);

        $updated = DB::table('hrm_transaksi_potongan_bulanan')
            ->where('periode_payroll', $validated['periode_payroll'])
            ->update([
                'status_posting' => 'FINAL',
                'updated_at' => now(),
            ]);

        return response()->json([
            'status' => 'success',
            'message' => "Sebanyak {$updated} data potongan periode {$validated['periode_payroll']} berhasil di-posting (FINAL).",
        ]);
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
    // MASTER KPI Rekap
    public function accounting_hrm_payroll_payment($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $departemens = DB::table('hrm_departemen')
                ->orderBy('hrm_departemen_name')
                ->get();

            return view('app-hrm.accounting.payroll-payment', [
                'id'          => $id,
                'akses'       => $akses,
                'code'        => $id,
                'departemens' => $departemens,
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function payroll_payment_get_data(Request $request)
    {
        $bulan = (int) $request->input('bulan', date('n'));
        $tahun = (int) $request->input('tahun', date('Y'));
        $statusFilter = strtoupper((string) $request->input('status_bayar', '')); // '', 'PAID', 'UNPAID'
        $periodeStr = sprintf('%04d-%02d', $tahun, $bulan);

        $query = DB::table('hrm_master_pegawai as p')
            ->leftJoin('hrm_departemen as d', 'p.hrm_m_position_code', '=', 'd.hrm_departemen_code')
            ->leftJoin('hrm_m_gaji_pokok as g', 'p.hrm_m_pegawai_code', '=', 'g.hrm_m_pegawai_code')
            ->leftJoin('hrm_pegawai_pajak_bpjs as cfg', 'p.hrm_m_pegawai_code', '=', 'cfg.hrm_m_pegawai_code')
            ->leftJoin('hrm_master_ptkp as ptkp', 'cfg.hrm_ptkp_code', '=', 'ptkp.hrm_ptkp_code')
            ->select(
                'p.hrm_m_pegawai_code',
                'p.hrm_m_pegawai_name',
                'p.hrm_m_pegawai_nip',
                'p.hrm_m_pegawai_nik',
                'p.hrm_m_position_code',
                'd.hrm_departemen_name',
                'd.hrm_departemen_lokasi',
                'g.nama_bank',
                'g.nomor_rekening',
                'cfg.hrm_ptkp_code',
                'ptkp.hrm_ter_kategori',
                'cfg.metode_pajak',
                'cfg.is_bpjs_kes_aktif',
                'cfg.mode_bpjs_tk',
                'cfg.gaji_pokok',
                'cfg.tunjangan_tetap',
                'cfg.dasar_upah_bpjs'
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

        // Data transaksi hrm_penggajian pada bulan & tahun terpilih
        $penggajianMap = DB::table('hrm_penggajian')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get()
            ->keyBy('hrm_m_pegawai_code');

        // Rekap potongan bulanan jika sudah ada
        $transaksiPotonganMap = DB::table('hrm_transaksi_potongan_bulanan')
            ->where('periode_payroll', $periodeStr)
            ->get()
            ->keyBy('hrm_m_pegawai_code');

        // Daftar pegawai yang punya konfigurasi komponen gaji SDM
        $configuredPegawaiCodes = DB::table('hrm_pegawai_komponen')
            ->distinct()
            ->pluck('hrm_m_pegawai_code')
            ->toArray();

        $bpjsConfig = DB::table('hrm_master_bpjs_config')
            ->where('is_active', true)
            ->first() ?? (object) [
                'bpjs_kes_karyawan_persen' => 1.00,
                'bpjs_kes_perusahaan_persen' => 4.00,
                'bpjs_kes_max_upah' => 12000000,
                'bpjs_jht_karyawan_persen' => 2.00,
                'bpjs_jht_perusahaan_persen' => 3.70,
                'bpjs_jp_karyawan_persen' => 1.00,
                'bpjs_jp_perusahaan_persen' => 2.00,
                'bpjs_jp_max_upah' => 10547400,
                'bpjs_jkk_perusahaan_persen' => 0.24,
                'bpjs_jkm_perusahaan_persen' => 0.30,
            ];

        $listTer = DB::table('hrm_master_ter_tarif')
            ->orderBy('hrm_ter_kategori')
            ->orderBy('bruto_min')
            ->get();

        $items = $pegawaiList->map(function ($p) use ($penggajianMap, $transaksiPotonganMap, $configuredPegawaiCodes, $bpjsConfig, $listTer) {
            $trxGaji = $penggajianMap->get($p->hrm_m_pegawai_code);
            $hasKomponen = in_array($p->hrm_m_pegawai_code, $configuredPegawaiCodes);
            $isVerified = $hasKomponen || ($trxGaji !== null);

            $pegawaiKomponen = DB::table('hrm_pegawai_komponen as pk')
                ->join('hrm_komponen_gaji as k', 'pk.id_komponen', '=', 'k.id_komponen')
                ->where('pk.hrm_m_pegawai_code', $p->hrm_m_pegawai_code)
                ->where('k.is_active', true)
                ->select('k.tipe', 'pk.nominal')
                ->get();

            $totalPendapatan = 0.0;
            $totalPotonganKomponen = 0.0;

            if ($pegawaiKomponen->isNotEmpty()) {
                foreach ($pegawaiKomponen as $pk) {
                    if ($pk->tipe === 'pendapatan') {
                        $totalPendapatan += floatval($pk->nominal);
                    } else {
                        $totalPotonganKomponen += floatval($pk->nominal);
                    }
                }
            } else {
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
                        $totalPotonganKomponen += floatval($dk->nominal_default);
                    }
                }
            }

            $trxPotongan = $transaksiPotonganMap->get($p->hrm_m_pegawai_code);
            if ($trxPotongan) {
                $potBpjsKes = (float) $trxPotongan->pot_bpjs_kes_karyawan;
                $potJht = (float) $trxPotongan->pot_bpjs_jht_karyawan;
                $potJp = (float) $trxPotongan->pot_bpjs_jp_karyawan;
                $potBpjsTk = $potJht + $potJp;
                $potPph21 = (float) $trxPotongan->pot_pph21_karyawan;
                $totalPotonganBpjsPajak = (float) $trxPotongan->total_potongan_karyawan;
            } else {
                $brutoPajak = ((float) ($p->gaji_pokok ?? 0) + (float) ($p->tunjangan_tetap ?? 0)) > 0
                    ? ((float) ($p->gaji_pokok ?? 0) + (float) ($p->tunjangan_tetap ?? 0))
                    : $totalPendapatan;

                $dasarUpahBpjs = (float) ($p->dasar_upah_bpjs ?? 0) > 0
                    ? (float) $p->dasar_upah_bpjs
                    : $brutoPajak;

                $calc = method_exists($this, 'hitungKomponenPotongan')
                    ? $this->hitungKomponenPotongan($p, $dasarUpahBpjs, $brutoPajak, $bpjsConfig, $listTer)
                    : [
                        'pot_bpjs_kes' => 0,
                        'pot_jht' => 0,
                        'pot_jp' => 0,
                        'pot_bpjs_tk' => 0,
                        'pot_pph21_karyawan' => 0,
                        'total_potongan' => 0,
                    ];

                $potBpjsKes = $calc['pot_bpjs_kes'];
                $potJht = $calc['pot_jht'];
                $potJp = $calc['pot_jp'];
                $potBpjsTk = $calc['pot_bpjs_tk'];
                $potPph21 = $calc['pot_pph21_karyawan'];
                $totalPotonganBpjsPajak = $calc['total_potongan'];
            }

            $totalPotongan = $totalPotonganKomponen + $totalPotonganBpjsPajak;
            $thp = $totalPendapatan - $totalPotongan;

            $isPaid = $trxGaji && strtoupper((string) $trxGaji->status) === 'PAID';
            if ($trxGaji && isset($trxGaji->total_thp) && (float) $trxGaji->total_thp > 0) {
                $thp = (float) $trxGaji->total_thp;
            }

            $p->is_verified = $isVerified;
            $p->is_paid = $isPaid;
            $p->payment_status = $isPaid ? 'PAID' : 'UNPAID';
            $p->tanggal_bayar = $trxGaji->tanggal_bayar ?? null;
            $p->metode_bayar = $trxGaji->metode_bayar ?? null;
            $p->catatan_bayar = $trxGaji->catatan ?? null;
            $p->total_pendapatan = $totalPendapatan;
            $p->total_potongan_komponen = $totalPotonganKomponen;
            $p->total_potongan_bpjs_pajak = $totalPotonganBpjsPajak;
            $p->total_potongan = $totalPotongan;
            $p->thp = $thp;
            $p->potongan_detail = [
                'bpjs_kes' => $potBpjsKes,
                'bpjs_tk_jht' => $potJht,
                'bpjs_tk_jp' => $potJp,
                'bpjs_tk' => $potBpjsTk,
                'pph21' => $potPph21,
                'ptkp' => $p->hrm_ptkp_code ?? 'TK/0',
            ];

            return $p;
        })
            // Tampilkan hanya pegawai yang sudah diverifikasi SDM
            ->filter(function ($item) {
                return $item->is_verified === true;
            });

        if ($statusFilter === 'PAID') {
            $items = $items->where('is_paid', true);
        } elseif ($statusFilter === 'UNPAID') {
            $items = $items->where('is_paid', false);
        }

        $data = $items->values();

        $totalSiapBayar = $data->where('is_paid', false)->sum('thp');
        $totalTerbayar = $data->where('is_paid', true)->sum('thp');
        $belumDibayarCount = $data->where('is_paid', false)->count();

        return response()->json([
            'status' => true,
            'periode' => $periodeStr,
            'data' => $data,
            'stats' => [
                'totalPegawai' => $data->count(),
                'totalSiapBayar' => 'Rp ' . number_format($totalSiapBayar, 0, ',', '.'),
                'totalTerbayar' => 'Rp ' . number_format($totalTerbayar, 0, ',', '.'),
                'belumDibayarCount' => $belumDibayarCount,
            ]
        ]);
    }
    public function payroll_payment_get_detail(Request $request, $pegawaiCode)
    {
        $bulan = (int) $request->input('bulan', date('n'));
        $tahun = (int) $request->input('tahun', date('Y'));
        $periodeStr = sprintf('%04d-%02d', $tahun, $bulan);

        $pegawai = DB::table('hrm_master_pegawai as p')
            ->leftJoin('hrm_departemen as d', 'p.hrm_m_position_code', '=', 'd.hrm_departemen_code')
            ->leftJoin('hrm_m_gaji_pokok as g', 'p.hrm_m_pegawai_code', '=', 'g.hrm_m_pegawai_code')
            ->where('p.hrm_m_pegawai_code', $pegawaiCode)
            ->select(
                'p.*',
                'd.hrm_departemen_name',
                'd.hrm_departemen_lokasi',
                'g.nama_bank',
                'g.nomor_rekening'
            )
            ->first();

        if (!$pegawai) {
            return response()->json(['status' => false, 'message' => 'Data pegawai tidak ditemukan.'], 404);
        }

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
                'k.kode_komponen',
                'k.nama_komponen',
                'k.tipe',
                DB::raw('COALESCE(pk.nominal, dk.nominal_default, 0) as nominal')
            )
            ->orderBy('k.id_komponen', 'asc')
            ->get();

        $trxGaji = DB::table('hrm_penggajian')
            ->where('hrm_m_pegawai_code', $pegawaiCode)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        $trxPotongan = DB::table('hrm_transaksi_potongan_bulanan')
            ->where('hrm_m_pegawai_code', $pegawaiCode)
            ->where('periode_payroll', $periodeStr)
            ->first();

        return response()->json([
            'status' => true,
            'periode' => $periodeStr,
            'pegawai' => $pegawai,
            'komponen' => $komponen,
            'potongan_bulanan' => $trxPotongan,
            'pembayaran' => $trxGaji,
        ]);
    }
    public function payroll_payment_pay(Request $request)
    {
        $request->validate([
            'hrm_m_pegawai_code' => 'required|string',
            'bulan'              => 'required|integer|min:1|max:12',
            'tahun'              => 'required|integer|min:2020|max:2100',
            'tanggal_bayar'      => 'required|date',
            'metode_bayar'       => 'required|string|max:50',
            'catatan'            => 'nullable|string|max:255',
        ]);

        $pegawaiCode = $request->hrm_m_pegawai_code;
        $bulan = (int) $request->bulan;
        $tahun = (int) $request->tahun;

        $pegawai = DB::table('hrm_master_pegawai')
            ->where('hrm_m_pegawai_code', $pegawaiCode)
            ->first();

        if (!$pegawai) {
            return response()->json(['status' => false, 'message' => 'Pegawai tidak ditemukan.'], 404);
        }

        // Hitung ulang THP terkini agar nominal terbayar konsisten
        $summary = $this->hitungRingkasanPayrollPegawai($pegawai, $bulan, $tahun);

        DB::beginTransaction();
        try {
            $existing = DB::table('hrm_penggajian')
                ->where('hrm_m_pegawai_code', $pegawaiCode)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();

            $payload = [
                'total_pendapatan' => $summary['total_pendapatan'],
                'total_potongan'   => $summary['total_potongan'],
                'total_thp'        => $summary['thp'],
                'status'           => 'PAID',
                'tanggal_bayar'    => $request->tanggal_bayar,
                'metode_bayar'     => $request->metode_bayar,
                'catatan'          => $request->catatan,
                'updated_at'       => now(),
            ];

            if (Auth::check()) {
                $payload['paid_by'] = Auth::id();
            }

            if ($existing) {
                DB::table('hrm_penggajian')
                    ->where('id', $existing->id)
                    ->update($payload);
            } else {
                $payload['hrm_m_pegawai_code'] = $pegawaiCode;
                $payload['bulan'] = $bulan;
                $payload['tahun'] = $tahun;
                $payload['created_at'] = now();
                DB::table('hrm_penggajian')->insert($payload);
            }

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Pembayaran gaji ' . $pegawai->hrm_m_pegawai_name . ' periode ' . sprintf('%02d/%04d', $bulan, $tahun) . ' berhasil ditandai PAID.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Gagal memproses pembayaran: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function payroll_payment_pay_bulk(Request $request)
    {
        $request->validate([
            'pegawai_codes'   => 'required|array|min:1',
            'pegawai_codes.*' => 'required|string',
            'bulan'           => 'required|integer|min:1|max:12',
            'tahun'           => 'required|integer|min:2020|max:2100',
            'tanggal_bayar'   => 'required|date',
            'metode_bayar'    => 'required|string|max:50',
            'catatan'         => 'nullable|string|max:255',
        ]);

        $bulan = (int) $request->bulan;
        $tahun = (int) $request->tahun;
        $codes = array_unique($request->pegawai_codes);

        DB::beginTransaction();
        try {
            $processed = 0;

            foreach ($codes as $code) {
                $pegawai = DB::table('hrm_master_pegawai')
                    ->where('hrm_m_pegawai_code', $code)
                    ->first();

                if (!$pegawai) {
                    continue;
                }

                $summary = $this->hitungRingkasanPayrollPegawai($pegawai, $bulan, $tahun);

                $existing = DB::table('hrm_penggajian')
                    ->where('hrm_m_pegawai_code', $code)
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->first();

                $payload = [
                    'total_pendapatan' => $summary['total_pendapatan'],
                    'total_potongan'   => $summary['total_potongan'],
                    'total_thp'        => $summary['thp'],
                    'status'           => 'PAID',
                    'tanggal_bayar'    => $request->tanggal_bayar,
                    'metode_bayar'     => $request->metode_bayar,
                    'catatan'          => $request->catatan,
                    'updated_at'       => now(),
                ];

                if (Auth::check()) {
                    $payload['paid_by'] = Auth::id();
                }

                if ($existing) {
                    DB::table('hrm_penggajian')
                        ->where('id', $existing->id)
                        ->update($payload);
                } else {
                    $payload['hrm_m_pegawai_code'] = $code;
                    $payload['bulan'] = $bulan;
                    $payload['tahun'] = $tahun;
                    $payload['created_at'] = now();
                    DB::table('hrm_penggajian')->insert($payload);
                }

                $processed++;
            }

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => "{$processed} data gaji pegawai berhasil diproses menjadi PAID.",
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Gagal memproses pembayaran massal: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function payroll_payment_export_excel(Request $request)
    {
        $bulan = (int) $request->input('bulan', date('n'));
        $tahun = (int) $request->input('tahun', date('Y'));
        $periodeStr = sprintf('%04d-%02d', $tahun, $bulan);

        $jsonResponse = $this->payroll_payment_get_data($request);
        $payload = $jsonResponse->getData(true);
        $rows = $payload['data'] ?? [];

        $filename = "rekap-payment-payroll-{$periodeStr}.csv";
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($rows, $periodeStr) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, [
                'Periode',
                'Kode Pegawai',
                'NIP',
                'Nama Pegawai',
                'Departemen',
                'Bank',
                'No Rekening',
                'Total Pendapatan',
                'Total Potongan',
                'THP',
                'Status Pembayaran',
                'Tanggal Bayar',
                'Metode Bayar',
            ]);

            foreach ($rows as $r) {
                fputcsv($handle, [
                    $periodeStr,
                    $r['hrm_m_pegawai_code'] ?? '',
                    $r['hrm_m_pegawai_nip'] ?? '',
                    $r['hrm_m_pegawai_name'] ?? '',
                    $r['hrm_departemen_name'] ?? '',
                    $r['nama_bank'] ?? '',
                    $r['nomor_rekening'] ?? '',
                    $r['total_pendapatan'] ?? 0,
                    $r['total_potongan'] ?? 0,
                    $r['thp'] ?? 0,
                    $r['payment_status'] ?? 'UNPAID',
                    $r['tanggal_bayar'] ?? '-',
                    $r['metode_bayar'] ?? '-',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
    private function hitungRingkasanPayrollPegawai($pegawai, int $bulan, int $tahun): array
    {
        $periodeStr = sprintf('%04d-%02d', $tahun, $bulan);

        $pegawaiKomponen = DB::table('hrm_pegawai_komponen as pk')
            ->join('hrm_komponen_gaji as k', 'pk.id_komponen', '=', 'k.id_komponen')
            ->where('pk.hrm_m_pegawai_code', $pegawai->hrm_m_pegawai_code)
            ->where('k.is_active', true)
            ->select('k.tipe', 'pk.nominal')
            ->get();

        $totalPendapatan = 0.0;
        $totalPotonganKomponen = 0.0;

        if ($pegawaiKomponen->isNotEmpty()) {
            foreach ($pegawaiKomponen as $pk) {
                if ($pk->tipe === 'pendapatan') {
                    $totalPendapatan += floatval($pk->nominal);
                } else {
                    $totalPotonganKomponen += floatval($pk->nominal);
                }
            }
        } else {
            $defaultDept = DB::table('hrm_departemen_komponen as dk')
                ->join('hrm_komponen_gaji as k', 'dk.id_komponen', '=', 'k.id_komponen')
                ->where('dk.hrm_departemen_code', $pegawai->hrm_m_position_code)
                ->where('k.is_active', true)
                ->select('k.tipe', 'dk.nominal_default')
                ->get();

            foreach ($defaultDept as $dk) {
                if ($dk->tipe === 'pendapatan') {
                    $totalPendapatan += floatval($dk->nominal_default);
                } else {
                    $totalPotonganKomponen += floatval($dk->nominal_default);
                }
            }
        }

        $trxPotongan = DB::table('hrm_transaksi_potongan_bulanan')
            ->where('hrm_m_pegawai_code', $pegawai->hrm_m_pegawai_code)
            ->where('periode_payroll', $periodeStr)
            ->first();

        if ($trxPotongan) {
            $totalPotonganBpjsPajak = (float) $trxPotongan->total_potongan_karyawan;
        } else {
            $cfg = DB::table('hrm_pegawai_pajak_bpjs as c')
                ->leftJoin('hrm_master_ptkp as t', 'c.hrm_ptkp_code', '=', 't.hrm_ptkp_code')
                ->where('c.hrm_m_pegawai_code', $pegawai->hrm_m_pegawai_code)
                ->select('c.*', 't.hrm_ter_kategori')
                ->first();

            $bpjsConfig = DB::table('hrm_master_bpjs_config')->where('is_active', true)->first() ?? (object) [
                'bpjs_kes_karyawan_persen' => 1.00,
                'bpjs_kes_perusahaan_persen' => 4.00,
                'bpjs_kes_max_upah' => 12000000,
                'bpjs_jht_karyawan_persen' => 2.00,
                'bpjs_jht_perusahaan_persen' => 3.70,
                'bpjs_jp_karyawan_persen' => 1.00,
                'bpjs_jp_perusahaan_persen' => 2.00,
                'bpjs_jp_max_upah' => 10547400,
                'bpjs_jkk_perusahaan_persen' => 0.24,
                'bpjs_jkm_perusahaan_persen' => 0.30,
            ];

            $listTer = DB::table('hrm_master_ter_tarif')
                ->orderBy('hrm_ter_kategori')
                ->orderBy('bruto_min')
                ->get();

            $brutoPajak = ((float) ($cfg->gaji_pokok ?? 0) + (float) ($cfg->tunjangan_tetap ?? 0)) > 0
                ? ((float) ($cfg->gaji_pokok ?? 0) + (float) ($cfg->tunjangan_tetap ?? 0))
                : $totalPendapatan;

            $dasarUpahBpjs = (float) ($cfg->dasar_upah_bpjs ?? 0) > 0
                ? (float) $cfg->dasar_upah_bpjs
                : $brutoPajak;

            $calc = method_exists($this, 'hitungKomponenPotongan')
                ? $this->hitungKomponenPotongan($cfg ?? (object) [], $dasarUpahBpjs, $brutoPajak, $bpjsConfig, $listTer)
                : ['total_potongan' => 0];

            $totalPotonganBpjsPajak = (float) ($calc['total_potongan'] ?? 0);
        }

        $totalPotongan = $totalPotonganKomponen + $totalPotonganBpjsPajak;
        $thp = $totalPendapatan - $totalPotongan;

        return [
            'total_pendapatan' => $totalPendapatan,
            'total_potongan'   => $totalPotongan,
            'thp'              => $thp,
        ];
    }
}
