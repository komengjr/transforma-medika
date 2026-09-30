<?php

namespace App\Http\Controllers\Medic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ElektromedisController extends Controller
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
    public function pendaftaran_elektromedis($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            // Menggunakan tabel baru: medical_electromedical_reg
            $registrations = DB::table('medical_electromedical_reg')->orderBy('id', 'desc')->get();

            $examinationTypes = [
                'ECG' => 'Elektrokardiografi (ECG / EKG)',
                'EEG' => 'Elektroensefalografi (EEG)',
                'Treadmill' => 'Treadmill Test',
                'Echocardiography' => 'Echocardiography (Echo)',
                'Audiometri' => 'Audiometri Pemeriksaan Pendengaran',
                'Spirometri' => 'Spirometri Fungsi Paru',
                'USG' => 'Ultrasonografi (USG Medik)',
            ];

            $units = [
                'Poli Jantung',
                'Poli Penyakit Dalam',
                'Poli Saraf',
                'Instalasi Gawat Darurat (IGD)',
                'Rawat Inap (VIP)',
                'Rawat Inap Kelas 1/2/3'
            ];

            return view('application.elektromedis.pendaftaran-elektromedis', compact(
                'registrations',
                'examinationTypes',
                'units'
            ), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

    // Tambahkan method store untuk menyimpan data baru ke database
    public function store_pendaftaran(Request $request)
    {
        $request->validate([
            'medical_record_number' => 'required|string',
            'patient_name'          => 'required|string',
            'origin_unit'           => 'required|string',
            'examination_type'      => 'required|string',
            'scheduled_at'          => 'required|date',
        ]);

        // Generate Nomor Registrasi Otomatis
        $today = date('Ymd');
        $lastReg = DB::table('medical_electromedical_reg')
            ->whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastReg ? (int)substr($lastReg->registration_number, -4) + 1 : 1;
        $registrationNumber = 'REG-' . $today . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        DB::table('medical_electromedical_reg')->insert([
            'registration_number'     => $registrationNumber,
            'medical_record_number'   => $request->medical_record_number,
            'patient_name'            => $request->patient_name,
            'origin_unit'             => $request->origin_unit,
            'examination_type'        => $request->examination_type,
            'scheduled_at'            => $request->scheduled_at,
            'status'                  => 'Terdaftar',
            'created_at'              => now(),
            'updated_at'              => now(),
        ]);

        return redirect()->back()->with('success', 'Pendaftaran elektromedik berhasil disimpan!');
    }

    public function menu_elektromedis_handling(Request $request, $akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $selectedExam = $request->input('examination_type');

            $registrations = collect();

            // Data hanya diload jika filter sudah dikirimkan
            if ($startDate && $endDate && $selectedExam) {
                $query = DB::table('medical_electromedical_reg')
                    ->whereDate('scheduled_at', '>=', $startDate)
                    ->whereDate('scheduled_at', '<=', $endDate);

                if ($selectedExam !== 'ALL') {
                    $query->where('examination_type', $selectedExam);
                }

                $registrations = $query->orderBy('scheduled_at', 'asc')->get();
            }

            $examinationTypes = [
                'ECG' => 'Elektrokardiografi (ECG / EKG)',
                'EEG' => 'Elektroensefalografi (EEG)',
                'Treadmill' => 'Treadmill Test',
                'Echocardiography' => 'Echocardiography (Echo)',
                'Audiometri' => 'Audiometri Pemeriksaan Pendengaran',
                'Spirometri' => 'Spirometri Fungsi Paru',
                'USG' => 'Ultrasonografi (USG Medik)',
            ];

            return view('application.elektromedis.elektromedis-handling', [
                'akses' => $akses,
                'code' => $id,
                'registrations' => $registrations,
                'examinationTypes' => $examinationTypes,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'selectedExam' => $selectedExam
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

    // Method untuk memproses update status / tindakan handling per pasien
    public function update_handling_status(Request $request, $regId)
    {
        $request->validate([
            'status' => 'required|string',
            'progress_notes' => 'nullable|string'
        ]);

        DB::table('electromedical_registrations')
            ->where('id', $regId)
            ->update([
                'status' => $request->status,
                'clinical_notes' => DB::raw("CONCAT(COALESCE(clinical_notes, ''), '\n[Handling]: ', " . DB::getPdo()->quote($request->progress_notes) . ")"),
                'updated_at' => Carbon::now()
            ]);

        return redirect()->back()->with('success', 'Status dan tindakan pemeriksaan berhasil diperbarui!');
    }

    // 2. Menampilkan Form Detail ECG
    public function form_pemeriksaan_ecg($registration_number)
    {
        // Cek data registrasi berdasarkan registration_number
        $registration = DB::table('medical_electromedical_reg')
            ->where('registration_number', $registration_number)
            ->first();

        // Jika data pasien/registrasi tidak ditemukan
        if (!$registration) {
            abort(404, 'Data pasien pemeriksaan tidak ditemukan.');
        }

        // Ambil hasil ECG berdasarkan id registrasi
        $ecgResult = DB::table('medical_ecg_results')
            ->where('registration_id', $registration->id)
            ->first();

        // Ambil data referensi DICOM ECG dari tabel medical_dicom_ecg
        $dicomData = DB::table('medical_dicom_ecg')
            ->where('medical_record_number', $registration->medical_record_number)
            ->orWhere('registration_id', $registration->id)
            ->first();

        return view('application.elektromedis.form-pemeriksaan-ecg', [
            'registration' => $registration,
            'ecgResult' => $ecgResult,
            'dicomData' => $dicomData
        ]);
    }

    // 3. Menyimpan Hasil Pemeriksaan ECG
    public function store_pemeriksaan_ecg(Request $request, $registration_id)
    {
        $data = [
            'registration_id' => $registration_id,
            'heart_rate' => $request->input('heart_rate'),
            'rhythm' => $request->input('rhythm'),
            'axis' => $request->input('axis'),
            'pr_interval' => $request->input('pr_interval'),
            'qrs_complex' => $request->input('qrs_complex'),
            'st_segment' => $request->input('st_segment'),
            't_wave' => $request->input('t_wave'),
            'clinical_impression' => $request->input('clinical_impression'),
            'doctor_notes' => $request->input('doctor_notes'),
            'updated_at' => now(),
        ];

        $existing = DB::table('medical_ecg_results')->where('registration_id', $registration_id)->first();
        if ($existing) {
            DB::table('medical_ecg_results')->where('registration_id', $registration_id)->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('medical_ecg_results')->insert($data);
        }

        // Update status registrasi utama
        DB::table('medical_electromedical_reg')->where('id', $registration_id)->update([
            'status' => 'Verifikasi Dokter',
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Hasil pemeriksaan ECG berhasil disimpan!');
    }
}
