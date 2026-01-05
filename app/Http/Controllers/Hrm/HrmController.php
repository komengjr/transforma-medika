<?php

namespace App\Http\Controllers\Hrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
    // CUTI dan IZIM
    public function hrm_data_kehadiran_cuti_izin($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('app-hrm.data-kehadiran.cuti-dan-izin', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // CUTI dan IZIM
    public function hrm_data_kehadiran_lembur($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('app-hrm.data-kehadiran.data-lembur', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // DATA GAJI
    public function payroll_data_gaji($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            return view('app-hrm.payroll.data-gaji', ['akses' => $akses, 'code' => $id]);
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
            return view('app-hrm.manajemen.penilaian-kpi', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
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
        $data = DB::table('hrm_master_pegawai')->select('hrm_m_pegawai_code', 'hrm_m_pegawai_name', 'hrm_m_position_code', 'hrm_m_pegawai_email', 'hrm_m_pegawai_img', 'hrm_m_pegawai_hp')
            ->get()
            ->map(function ($item) {
                return [
                    "code"   => $item->hrm_m_pegawai_code,
                    "nama"   => $item->hrm_m_pegawai_name,
                    "jabatan" => $item->hrm_m_position_code,
                    "divisi" => $item->hrm_m_position_code,
                    "foto"   => $item->hrm_m_pegawai_img,
                    "kontak" => $item->hrm_m_pegawai_hp,
                ];
            });

        return response()->json($data);
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
        $count = DB::table('hrm_master_pegawai')->count();
        try {
            if ($request->link == "") {
                $gambar = "";
            } else {
                $gambar = Storage::url('pegawai/profile/' . auth::user()->access_cabang . '/' . $request->link);
            }

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
                'hrm_m_pegawai_img' => $gambar,
                'created_at' => now(),
            ]);
            return '<script>location.reload();</script>';
        } catch (\Throwable $th) {
            return '0';
        }
    }
    public function master_data_pegawai_update(Request $request)
    {
        $data = DB::table('hrm_master_pegawai')->where('hrm_m_pegawai_code', $request->code)->first();
        return view('app-hrm.master-pegawai.form.form-update-pegawai', compact('data'));
    }
    public function master_data_pegawai_detail(Request $request)
    {
        $data = DB::table('hrm_master_pegawai')->where('hrm_m_pegawai_code', $request->code)->first();
        return view('app-hrm.master-pegawai.form.form-detail-pegawai', compact('data'));
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
        try {
            DB::table('hrm_kpi_master')->insert([
                'hrm_kpi_master_code' => str::uuid(),
                'hrm_departemen_code' => $request->departemen,
                'hrm_kpi_master_name' => $request->nama,
                'hrm_kpi_master_desc' => $request->desc,
                'hrm_kpi_master_bobot' => $request->bobot,
                'hrm_kpi_master_target' => $request->target,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $th) {
            return 0;
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
    public function master_data_kpi_rekap($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            return view('app-hrm.master-kpi.master-kpi-rekap', ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
}
