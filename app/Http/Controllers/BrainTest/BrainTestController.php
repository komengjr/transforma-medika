<?php

namespace App\Http\Controllers\BrainTest;

use App\Exports\BrainTestSoalTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\BrainTestSoalImport;
use App\Models\BrainTest\BrainTestKategori;
use App\Models\BrainTest\BrainTestKlasifikasi;
use App\Models\BrainTest\BrainTestOpsiJawaban;
use App\Models\BrainTest\BrainTestSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class BrainTestController extends Controller
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
    public function brain_test_master_data($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            // Mengambil seluruh data klasifikasi beserta relasi kategori dan jumlah soalnya
            $klasifikasiList = BrainTestKlasifikasi::with(['kategoris' => function ($query) {
                $query->withCount('soals');
            }])->get();

            return view('app-brain-test.master.master-data-test', [
                'akses' => $akses,
                'code' => $id,
                'klasifikasiList' => $klasifikasiList,
            ]);
        } else {
            return \Illuminate\Support\Facades\Redirect::to('dashboard/home');
        }
    }
    public function storeKlasifikasi(Request $request)
    {
        $request->validate([
            'nama_klasifikasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        BrainTestKlasifikasi::create([
            'nama_klasifikasi' => $request->nama_klasifikasi,
            'slug' => Str::slug($request->nama_klasifikasi),
            'deskripsi' => $request->deskripsi,
            'status' => 'aktif',
        ]);

        return redirect()->back()->with('success', 'Klasifikasi tes berhasil ditambahkan!');
    }

    /**
     * Menyimpan data Kategori baru ke dalam Klasifikasi tertentu.
     */
    public function storeKategori(Request $request)
    {
        $request->validate([
            'klasifikasi_id' => 'required|exists:brain_test_klasifikasi,id',
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        BrainTestKategori::create([
            'klasifikasi_id' => $request->klasifikasi_id,
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Kategori tes berhasil ditambahkan!');
    }

    /**
     * Menghapus data klasifikasi.
     */
    public function destroyKlasifikasi($id)
    {
        $klasifikasi = BrainTestKlasifikasi::findOrFail($id);
        $klasifikasi->delete();

        return redirect()->back()->with('success', 'Klasifikasi berhasil dihapus.');
    }

    /**
     * Menghapus data kategori.
     */
    public function destroyKategori($id)
    {
        $kategori = BrainTestKategori::findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
    public function index($kategoriId)
    {
        // Validasi jika kategoriId kosong atau tidak ditemukan di database
        if (empty($kategoriId)) {
            abort(404, 'ID Kategori tidak boleh kosong.');
        }

        $kategori = BrainTestKategori::with('klasifikasi')->findOrFail($kategoriId);
        $soals = BrainTestSoal::where('kategori_id', $kategoriId)->with('opsiJawabans')->paginate(10);

        return view('app-brain-test.master.form-add-soal', compact('kategori', 'soals'));
    }
    public function getJsonSoal($kategoriId)
    {
        $soals = BrainTestSoal::where('kategori_id', $kategoriId)->with('opsiJawabans')->get();
        return response()->json($soals);
    }
    // Menyimpan soal manual satu per satu
    public function storeSoal(Request $request, $kategoriId)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'opsi' => 'required|array',
            'jawaban_benar' => 'required',
        ]);

        $soal = BrainTestSoal::create([
            'kategori_id' => $kategoriId,
            'pertanyaan'  => $request->pertanyaan,
            'tipe_soal'   => 'pilihan_ganda',
            'bobot_nilai' => 1,
        ]);

        foreach ($request->opsi as $index => $opsiData) {
            if (!empty($opsiData['teks'])) {
                $isBenar = ((string)$request->jawaban_benar === (string)$index);

                BrainTestOpsiJawaban::create([
                    'soal_id'      => $soal->id,
                    'teks_jawaban' => $opsiData['teks'],
                    'is_benar'     => $isBenar,
                    'poin'         => $isBenar ? 5 : 0,
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Soal manual berhasil ditambahkan!'
        ]);
    }

    // Menghapus soal
    public function destroy($id)
    {
        $soal = BrainTestSoal::findOrFail($id);
        $soal->delete();

        return redirect()->back()->with('success', 'Soal berhasil dihapus.');
    }

    // Metode sederhana untuk import excel (bisa dikustomisasi menggunakan library Maatwebsite Excel)
    public function import(Request $request, $kategoriId)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            // Mengirim $kategoriId ke dalam constructor BrainTestSoalImport
            Excel::import(new BrainTestSoalImport($kategoriId), $request->file('file_excel'));

            return response()->json([
                'status' => 'success',
                'message' => 'Data soal berhasil di-import dari Excel!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat import: ' . $e->getMessage()
            ], 422);
        }
    }
    public function downloadTemplate()
    {
        // Aman, karena berada dalam object context
        return Excel::download(new BrainTestSoalTemplateExport(), 'template_import_soal.xlsx');
    }
    public function preview($kategoriId)
    {
        $kategori = BrainTestKategori::findOrFail($kategoriId);
        return view('app-brain-test.preview-tryout', compact('kategori'));
    }
}
