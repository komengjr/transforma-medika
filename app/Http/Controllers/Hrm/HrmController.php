<?php

namespace App\Http\Controllers\Hrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Stmt\TryCatch;

class HrmController extends Controller
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
    public function personal_data($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('app-hrm.dashboard.personal-data', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function hrm_data_kehadiran_rekap($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('app-hrm.data-kehadiran.abesnsi', ['akses' => $akses, 'code' => $id]);
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
        $awals = substr($request->date, 0, 10);
        $awal = date_create($awals);
        // $awal = date_create($awal);
        $akhirs = substr($request->date, 14, 10);
        $akhir = date_create($akhirs);
        // $setup = DB::table('master_depresiasi_sub')->where('depresiasi_sub_code', $request->code)->first();
        // $inventaris = DB::table('inventaris_data')->where('inventaris_data_code', $request->id)->first();
        // $fixharga = $inventaris->inventaris_data_harga;
        // $pengurangan = $fixharga / $setup->depresiasi_sub_hitung;
        // $persen = ($pengurangan / $fixharga) * 100;
        $date = date_diff($awal, $akhir);
        for ($i = 0; $i <= $date->days; $i++) {
            $tgl[$i] = date('d - M - Y', strtotime('+' . $i . ' day', strtotime($awals)));
            $hari[$i] = date('D', strtotime('+' . $i . ' day', strtotime($awals)));
            $hari[$i] = $daftar_hari[$hari[$i]];
            if ($hari[$i] == 'Minggu') {
                $jam_kerja[$i] = '<strong>Libur Nasional</strong>';
            } else {
                $jam_kerja[$i] = '06:30:00 12:30:00';
            }

        }
        // for ($i = 0; $i < $setup->depresiasi_sub_hitung; $i++) {
        //     $hargaperolehan[$i] = $fixharga;
        //     $fixharga = $fixharga - $pengurangan;
        // }
        return view('app-hrm.data-kehadiran.absensi.data-absensi', [
            'data' => $date->days,
            'tgl' => $tgl,
            'hari' => $hari,
            'jam_kerja' => $jam_kerja,
        ]);
    }
    public function hrm_data_kehadiran_cuti_izin($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('app-hrm.data-kehadiran.schedule', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function payroll_slip_gaji($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('app-hrm.payroll.slip-gaji', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function payroll_slip_thr($akses, $id)
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
            return view('app-hrm.payroll.slip-gaji', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // TARGET KPI
    public function manajemen_kpi_target($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('app-hrm.manajemen.penilaian-kpi', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // MASTER PEGAWAI
    public function master_data_pegawai($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('hrm_master_pegawai')->get();
            return view('app-hrm.master-pegawai.data-pegawai', [
                'akses' => $akses,
                'code' => $id,
                'data' => $data
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_data_pegawai_add(Request $request)
    {
        return view('app-hrm.master-pegawai.form.form-add-pegawai');
    }
    public function master_data_pegawai_save(Request $request)
    {
        $count = DB::table('hrm_master_pegawai')->count();
        try {
            DB::table('hrm_master_pegawai')->insert([
                'hrm_m_pegawai_code' => 'PEG' . date('Ymd') . str_pad($count + 1, 4, '0', STR_PAD_LEFT),
                'hrm_m_pegawai_nip' => $request->nip,
                'hrm_m_pegawai_nik' => $request->nik,
                'hrm_m_pegawai_name' => $request->name,
                'hrm_master_pegawai_dob' => $request->dob,
                'hrm_m_pegawai_sex' => $request->jk,
                'hrm_master_pegawai_dop' => $request->place,
                'hrm_m_pegawai_agama' => $request->agama,
                'hrm_m_pegawai_hp' => $request->hp,
                'hrm_m_pegawai_email' => $request->email,
                'hrm_m_position_code' => 123,
                'hrm_m_position_loc' => 123,
                'hrm_m_pegawai_address' => 123,
                'hrm_m_pegawai_img' => 123,
                'created_at' => now(),
            ]);
            return '<script>location.reload();</script>';
        } catch (\Throwable $th) {
            return '0';
        }

    }
    // MASTER Jabatan
    public function master_data_jabatan($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('app-hrm.payroll.slip-gaji', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
}
