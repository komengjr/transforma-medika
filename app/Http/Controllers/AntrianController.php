<?php

namespace App\Http\Controllers;

use App\Models\MedicalAntrianLog;
use App\Models\MedicalLoket;
use App\Models\MedicalLoketCounter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AntrianController extends Controller
{
    public function display_antrian()
    {
        return view('antrian.display-antrian');
    }
    public function both_antrian()
    {
        $lokets = MedicalLoket::where('is_active', true)->get();
        return view('antrian.both-antiran', compact('lokets'));
    }
    // Menampilkan halaman Kiosk Kios Antrian
    public function index()
    {
        // Mengambil semua data loket yang aktif dari tabel medical_loket
        $lokets = MedicalLoket::where('is_active', true)->get();

        return view('antrian.kiosk', compact('lokets'));
    }

    // Endpoint API POST saat pasien menekan tombol antrian
    public function store(Request $request)
    {
        $request->validate([
            'loket_id' => 'required|exists:medical_loket,id',
        ]);

        $loket = MedicalLoket::findOrFail($request->loket_id);

        // Increment nomor antrian terakhir di database
        $loket->increment('nomor_terakhir');
        $loket->refresh();

        // Format nomor antrian, contoh: A001, B005
        $nomorFormatted = $loket->kode_prefix . str_pad($loket->nomor_terakhir, 3, '0', STR_PAD_LEFT);
        $waktuFormatted = Carbon::now()->translatedFormat('d M Y, H:i');

        // ==========================================
        // SIMPAN / INSERT KE TABEL medical_antrian_log
        // ==========================================
        $log = MedicalAntrianLog::create([
            'loket_id'      => $loket->id,
            'nomor_antrian' => $nomorFormatted,
            'status'        => 'menunggu', // Status awal saat tiket diambil
        ]);

        return response()->json([
            'success'       => true,
            'log_id'        => $log->id, // Mengembalikan ID log yang baru dibuat
            'nomor_antrian' => $nomorFormatted,
            'nama_loket'    => $loket->nama_loket,
            'waktu'         => $waktuFormatted,
            'message'       => 'Antrian berhasil diproses dan dicatat',
        ]);
    }
    public function getDisplayData()
    {
        // Antrian yang SEDANG DIPANGGIL saat ini (Terbaru)
        $sedangDipanggil = MedicalAntrianLog::with('loket')
            ->where('status', 'dipanggil')
            ->orderBy('waktu_panggil', 'desc')
            ->first();

        // Riwayat 5 Antrian terakhir yang sudah dipanggil
        $riwayatPanggilan = MedicalAntrianLog::with('loket')
            ->where('status', 'dipanggil')
            ->orderBy('waktu_panggil', 'desc')
            ->take(5)
            ->get();

        // Daftar antrian yang MASIH MENUNGGU (Lengkap dengan relasi loket)
        $antrianMenunggu = MedicalAntrianLog::with('loket')
            ->where('status', 'menunggu')
            ->orderBy('id', 'asc') // Urutkan dari yang pertama mendaftar
            ->take(10)             // Ambil 10 antrian terdepan untuk ditampilkan
            ->get();

        return response()->json([
            'success'           => true,
            'sedang_dipanggil'   => $sedangDipanggil,
            'riwayat_panggilan'  => $riwayatPanggilan,
            'antrian_menunggu'   => $antrianMenunggu
        ]);
    }



    // ... Method index(), store(), getDisplayData() dari kode sebelumnya tetap ada ...

    // Halaman Interface Petugas Pemanggil
    public function indexPetugas(Request $request)
    {
        $clientIp = $request->ip();

        $assignedCounter = MedicalLoketCounter::where('ip_address', $clientIp)
            ->where('is_active', true)
            ->first();

        // Ambil data detail loket berdasarkan array loket_ids
        $loketList = $assignedCounter ? $assignedCounter->lokets() : collect();
        return view('antrian.page-panggilan', compact('assignedCounter', 'loketList', 'clientIp'));
    }

    // API Memanggil Antrian Berikutnya
    public function panggilAntrian(Request $request)
    {
        $clientIp = $request->ip();
        $counter = MedicalLoketCounter::where('ip_address', $clientIp)->where('is_active', true)->first();

        if (!$counter) {
            return response()->json(['success' => false, 'message' => 'Komputer Anda tidak terdaftar.'], 403);
        }

        // Proteksi: Harus menyelesaikan antrian aktif dulu
        $antrianAktif = MedicalAntrianLog::where('nomor_loket_pemanggil', $counter->nomor_counter)
            ->where('status', 'dipanggil')
            ->first();

        if ($antrianAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Selesaikan antrian saat ini terlebih dahulu sebelum memanggil berikutnya!'
            ], 422);
        }

        $loketIds = $counter->loket_ids ?? [];
        $selectedLoketId = $request->input('loket_id');

        $query = MedicalAntrianLog::where('status', 'menunggu');

        if ($selectedLoketId && in_array($selectedLoketId, $loketIds)) {
            $query->where('loket_id', $selectedLoketId);
        } else {
            $query->whereIn('loket_id', $loketIds);
        }

        $antrian = $query->orderBy('id', 'asc')->first();

        if (!$antrian) {
            return response()->json(['success' => false, 'message' => 'Tidak ada antrian tersisa.']);
        }

        $antrian->update([
            'status' => 'dipanggil',
            'nomor_loket_pemanggil' => $counter->nomor_counter,
            'waktu_panggil' => now()
        ]);

        return response()->json(['success' => true, 'data' => $antrian]);
    }

    // API Panggil Ulang (Update waktu_panggil agar TV Display mendeteksi & membunyikan suara lagi)
    public function panggilUlang(Request $request)
    {
        $request->validate(['log_id' => 'required|exists:medical_antrian_log,id']);

        $antrian = MedicalAntrianLog::findOrFail($request->log_id);
        $antrian->update([
            'waktu_panggil' => now(), // Trigger ulang di display
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Panggilan ulang berhasil dikirim!'
        ]);
    }

    // API Ubah Status Antrian (Selesai / Batal)
    public function updateStatus(Request $request)
    {
        $request->validate([
            'log_id' => 'required|exists:medical_antrian_log,id',
            'status' => 'required|in:selesai,batal'
        ]);

        $antrian = MedicalAntrianLog::findOrFail($request->log_id);
        $dataUpdate = ['status' => $request->status];

        if ($request->status === 'selesai') {
            $dataUpdate['waktu_selesai'] = now();
        }

        $antrian->update($dataUpdate);

        return response()->json([
            'success' => true,
            'message' => 'Status antrian berhasil diperbarui menjadi ' . $request->status
        ]);
    }

    // API Ambil Antrian Aktif & List Menunggu untuk Petugas
    public function getPetugasData(Request $request)
    {
        $clientIp = $request->ip();
        $counter = MedicalLoketCounter::where('ip_address', $clientIp)->where('is_active', true)->first();

        if (!$counter) {
            return response()->json(['success' => false, 'message' => 'Komputer ini tidak terdaftar.'], 403);
        }

        $loketIds = $counter->loket_ids ?? [];
        $selectedLoketId = $request->get('loket_id');

        // Cek antrian yang sedang dipanggil
        $sedangDilayani = MedicalAntrianLog::where('nomor_loket_pemanggil', $counter->nomor_counter)
            ->where('status', 'dipanggil')
            ->first();

        // Query antrian menunggu
        $queryMenunggu = MedicalAntrianLog::whereIn('loket_id', $loketIds)->where('status', 'menunggu');

        // Filter jika petugas memilih 1 loket spesifik di UI
        if ($selectedLoketId) {
            $queryMenunggu->where('loket_id', $selectedLoketId);
        }

        $listMenunggu = $queryMenunggu->orderBy('id', 'asc')->get();

        return response()->json([
            'success'        => true,
            'counter'        => $counter,
            'sedang_dilayani' => $sedangDilayani,
            'total_menunggu' => $listMenunggu->count(),
            'list_menunggu'  => $listMenunggu
        ]);
    }

    public function panggil(Request $request)
    {
        $clientIp = $request->ip();
        $counter = MedicalLoketCounter::where('ip_address', $clientIp)->where('is_active', true)->first();

        if (!$counter) {
            return response()->json(['success' => false, 'message' => 'Akses Ditolak: Komputer Anda tidak diizinkan memanggil.'], 403);
        }

        // Ambil antrian terdepan
        $antrian = MedicalAntrianLog::where('loket_id', $counter->loket_id)
            ->where('status', 'menunggu')
            ->orderBy('id', 'asc')
            ->first();

        if (!$antrian) {
            return response()->json(['success' => false, 'message' => 'Tidak ada antrian tersisa.']);
        }

        $antrian->update([
            'status' => 'dipanggil',
            'nomor_loket_pemanggil' => $counter->nomor_counter,
            'waktu_panggil' => now()
        ]);

        return response()->json(['success' => true, 'data' => $antrian]);
    }
}
