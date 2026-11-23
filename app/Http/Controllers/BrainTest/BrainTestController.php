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
use App\Models\BrainTest\BrainTestPaket;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
    // MENU RESPONDEN
    public function brain_test_menu_responden($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $pakets = BrainTestPaket::with(['klasifikasi', 'kategoris'])
                ->orderBy('id', 'desc')
                ->get();

            $respondenTerbaru = collect();
            $rekapPerPaket = [];

            // Prioritaskan tabel sesi responden terlebih dahulu
            $hasilTable = null;
            foreach (
                [
                    'brain_test_sesi_responden',
                    'brain_test_hasil',
                    'brain_test_responden',
                    'brain_test_peserta_test',
                ] as $candidateTable
            ) {
                if (Schema::hasTable($candidateTable)) {
                    $hasilTable = $candidateTable;
                    break;
                }
            }

            if ($hasilTable) {
                $skorCol = Schema::hasColumn($hasilTable, 'total_skor')
                    ? 'total_skor'
                    : (Schema::hasColumn($hasilTable, 'skor') ? 'skor' : null);

                $selectCols = [
                    'h.*',
                    'p.nama_test',
                    'p.passing_grade as paket_passing_grade',
                    'k.nama_klasifikasi',
                ];
                if ($skorCol) {
                    $selectCols[] = DB::raw("COALESCE(h.`{$skorCol}`, 0) as skor_nilai");
                } else {
                    $selectCols[] = DB::raw('0 as skor_nilai');
                }

                $respondenTerbaru = DB::table($hasilTable . ' as h')
                    ->leftJoin('brain_test_paket as p', 'h.paket_id', '=', 'p.id')
                    ->leftJoin('brain_test_klasifikasi as k', 'p.klasifikasi_id', '=', 'k.id')
                    ->select($selectCols)
                    ->orderByDesc('h.id')
                    ->limit(10)
                    ->get();

                foreach ($pakets as $paket) {
                    $rows = DB::table($hasilTable)->where('paket_id', $paket->id);
                    $jumlah = (clone $rows)->count();

                    $avgSkor = 0;
                    $maxSkor = 0;
                    $lulusCount = 0;

                    if ($jumlah > 0 && $skorCol) {
                        $avgSkor = round((float) (clone $rows)->avg($skorCol), 1);
                        $maxSkor = (clone $rows)->max($skorCol) ?? 0;
                        if ((int) ($paket->passing_grade ?? 0) > 0) {
                            $lulusCount = (clone $rows)
                                ->where($skorCol, '>=', (int) $paket->passing_grade)
                                ->count();
                        }
                    }

                    $rekapPerPaket[$paket->id] = [
                        'jumlah'      => $jumlah,
                        'avg_skor'    => $avgSkor,
                        'max_skor'    => $maxSkor,
                        'lulus_count' => $lulusCount,
                    ];
                }
            } else {
                foreach ($pakets as $paket) {
                    $rekapPerPaket[$paket->id] = [
                        'jumlah'      => 0,
                        'avg_skor'    => 0,
                        'max_skor'    => 0,
                        'lulus_count' => 0,
                    ];
                }
            }

            return view('app-brain-test.menu.menu-responden', [
                'akses'            => $akses,
                'code'             => $id,
                'pakets'           => $pakets,
                'respondenTerbaru' => $respondenTerbaru,
                'rekapPerPaket'    => $rekapPerPaket,
            ]);
        }

        return Redirect::to('dashboard/home');
    }
    // MENU MASTER DATA
    public function brain_test_master_data($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $klasifikasiList = BrainTestKlasifikasi::with([
                'pakets' => function ($query) {
                    $query->orderBy('id', 'desc')->with([
                        'kategoris' => function ($q) {
                            $q->orderBy('urutan')->withCount('soals');
                        },
                    ]);
                },
            ])->orderBy('id', 'asc')->get();

            return view('app-brain-test.master.master-data-test', [
                'akses'           => $akses,
                'code'            => $id,
                'klasifikasiList' => $klasifikasiList,
            ]);
        }

        return Redirect::to('dashboard/home');
    }

    public function storeKlasifikasi(Request $request)
    {
        $request->validate([
            'nama_klasifikasi' => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
        ]);

        BrainTestKlasifikasi::create([
            'nama_klasifikasi' => $request->nama_klasifikasi,
            'slug'             => Str::slug($request->nama_klasifikasi) . '-' . Str::lower(Str::random(4)),
            'deskripsi'        => $request->deskripsi,
            'status'           => 'aktif',
        ]);

        return back()->with('success', 'Klasifikasi tes berhasil ditambahkan.');
    }

    public function destroyKlasifikasi($id)
    {
        BrainTestKlasifikasi::findOrFail($id)->delete();

        return back()->with('success', 'Klasifikasi tes berhasil dihapus.');
    }

    public function storePaket(Request $request)
    {
        $request->validate([
            'klasifikasi_id' => 'required|exists:brain_test_klasifikasi,id',
            'nama_test'      => 'required|string|max:255',
            'durasi_menit'   => 'nullable|integer|min:1',
            'passing_grade'  => 'nullable|integer|min:0',
            'deskripsi'      => 'nullable|string',
        ]);

        BrainTestPaket::create([
            'klasifikasi_id' => $request->klasifikasi_id,
            'nama_test'      => $request->nama_test,
            'slug'           => Str::slug($request->nama_test) . '-' . Str::lower(Str::random(4)),
            'durasi_menit'   => $request->durasi_menit ?? 60,
            'passing_grade'  => $request->passing_grade ?? 0,
            'deskripsi'      => $request->deskripsi,
            'status'         => 'aktif',
        ]);

        return back()->with('success', 'Nama Tes / Paket berhasil ditambahkan.');
    }

    public function destroyPaket($id)
    {
        BrainTestPaket::findOrFail($id)->delete();

        return back()->with('success', 'Nama Tes / Paket berhasil dihapus.');
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'paket_id'      => 'required|exists:brain_test_paket,id',
            'nama_kategori' => 'required|string|max:255',
            'passing_grade' => 'nullable|integer|min:0',
            'urutan'        => 'nullable|integer|min:1',
            'deskripsi'     => 'nullable|string',
        ]);

        $paket = BrainTestPaket::findOrFail($request->paket_id);

        BrainTestKategori::create([
            'paket_id'      => $paket->id,
            'nama_kategori' => $request->nama_kategori,
            'slug'          => Str::slug($paket->nama_test . '-' . $request->nama_kategori) . '-' . Str::lower(Str::random(4)),
            'passing_grade' => $request->passing_grade ?? 0,
            'urutan'        => $request->urutan ?? 1,
            'deskripsi'     => $request->deskripsi,
        ]);

        return back()->with('success', 'Kategori soal berhasil ditambahkan.');
    }

    public function destroyKategori($id)
    {
        BrainTestKategori::findOrFail($id)->delete();

        return back()->with('success', 'Kategori soal berhasil dihapus.');
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
    public function storeSoal(Request $request, $kategoriId)
    {
        $kategori = BrainTestKategori::findOrFail($kategoriId);

        $validator = Validator::make($request->all(), [
            'pertanyaan'    => 'nullable|string',
            'gambar_soal'   => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:4096',
            'jawaban_benar' => 'required|integer|min:0|max:4',
            'opsi'          => 'required|array|min:2|max:5',
            'opsi.*.teks'   => 'nullable|string',
            'opsi.*.poin'   => 'nullable|integer',
            'opsi.*.gambar' => 'nullable|image|mimes:jpeg,jpg,png,webp,gif|max:4096',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $pertanyaanTeks = isset($request->pertanyaan) ? trim((string) $request->pertanyaan) : '';
        $fileSoal       = $request->file('gambar_soal');
        $adaGambarSoal  = !is_null($fileSoal);

        if ($pertanyaanTeks === '' && !$adaGambarSoal) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Pertanyaan wajib diisi (teks atau gambar).',
            ], 422);
        }

        $opsiTerisi = [];
        foreach ($request->input('opsi', []) as $index => $item) {
            $idx      = (int) $index;
            $teks     = isset($item['teks']) ? trim((string) $item['teks']) : '';
            $fileOpsi = $request->file("opsi.$idx.gambar");
            $hasImg   = !is_null($fileOpsi);

            if ($teks !== '' || $hasImg) {
                $opsiTerisi[] = [
                    'original_index' => $idx,
                    'teks_jawaban'   => $teks,
                    'file_gambar'    => $fileOpsi,
                    'poin'           => isset($item['poin']) && $item['poin'] !== '' ? (int) $item['poin'] : 0,
                ];
            }
        }

        if (count($opsiTerisi) < 2) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Minimal harus mengisi 2 pilihan jawaban (teks atau gambar).',
            ], 422);
        }

        $kunciDipilih = (int) $request->input('jawaban_benar');
        $adaKunciDiOpsiTerisi = collect($opsiTerisi)->contains('original_index', $kunciDipilih);

        if (!$adaKunciDiOpsiTerisi) {
            $kunciDipilih = $opsiTerisi[0]['original_index'];
        }

        $uploadedExamPaths = [];

        DB::beginTransaction();
        try {
            $gambarSoalPath = null;
            if ($adaGambarSoal && $fileSoal) {
                $extSoal           = $fileSoal->getClientOriginalExtension() ?: 'jpg';
                $namaSoal          = time() . '_' . Str::random(12) . '.' . $extSoal;
                $gambarSoalPath    = Storage::disk('exam')->putFileAs('brain-test/soal', $fileSoal, $namaSoal);
                $uploadedExamPaths[] = $gambarSoalPath;
            }

            $soal = BrainTestSoal::create([
                'kategori_id' => $kategori->id,
                'pertanyaan'  => $pertanyaanTeks,
                'gambar'      => $gambarSoalPath,
                'tipe_soal'   => 'pilihan_ganda',
            ]);

            foreach ($opsiTerisi as $opt) {
                $idx     = $opt['original_index'];
                $isBenar = ($idx === $kunciDipilih);

                $gambarOpsiPath = null;
                if (!is_null($opt['file_gambar'])) {
                    $fileOpsi          = $opt['file_gambar'];
                    $extOpsi           = $fileOpsi->getClientOriginalExtension() ?: 'jpg';
                    $namaOpsi          = time() . '_' . Str::random(12) . '_' . $idx . '.' . $extOpsi;
                    $gambarOpsiPath    = Storage::disk('exam')->putFileAs('brain-test/opsi', $fileOpsi, $namaOpsi);
                    $uploadedExamPaths[] = $gambarOpsiPath;
                }

                BrainTestOpsiJawaban::create([
                    'soal_id'      => $soal->id,
                    'teks_jawaban' => $opt['teks_jawaban'],
                    'gambar'       => $gambarOpsiPath,
                    'is_benar'     => $isBenar,
                    'poin'         => $opt['poin'],
                ]);
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Soal berhasil ditambahkan (' . count($opsiTerisi) . ' pilihan).',
                'data'    => $soal->load('opsiJawabans'),
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();

            if (!empty($uploadedExamPaths)) {
                Storage::disk('exam')->delete($uploadedExamPaths);
            }

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan soal: ' . $e->getMessage(),
            ], 500);
        }
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
    public function preview($paketId)
    {
        $paket = BrainTestPaket::with([
            'klasifikasi',
            'kategoris' => function ($q) {
                $q->orderBy('urutan')->withCount('soals');
            },
        ])->findOrFail($paketId);

        return view('app-brain-test.preview-tryout', [
            'paket' => $paket,
        ]);
    }

    public function jsonSoalPaket(Request $request, $paketId)
    {
        $paket = BrainTestPaket::with(['kategoris' => function ($q) {
            $q->orderBy('urutan');
        }])->findOrFail($paketId);

        $kategoriIds = $paket->kategoris->pluck('id');

        if ($request->filled('kategori_id') && $kategoriIds->contains((int)$request->kategori_id)) {
            $kategoriIds = collect([(int)$request->kategori_id]);
        }

        $soals = BrainTestSoal::with(['kategori', 'opsiJawabans'])
            ->whereIn('kategori_id', $kategoriIds)
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($soals);
    }
}
