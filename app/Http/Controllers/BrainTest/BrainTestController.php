<?php

namespace App\Http\Controllers\BrainTest;

use App\Exports\BrainTestSoalTemplateExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\StreamController;
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
    private function parseSpreadsheetRows($file, ?string $preferredSheet = null): array
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $path = $file->getRealPath();

        // 1. Jika file CSV
        if ($ext === 'csv') {
            $rows = [];
            if (($handle = fopen($path, 'r')) !== false) {
                while (($line = fgetcsv($handle)) !== false) {
                    $rows[] = $line;
                }
                fclose($handle);
            }
            return $rows;
        }

        // 2. Jika file XLSX (Native PHP ZipArchive + SimpleXML, tanpa PhpSpreadsheet)
        if ($ext === 'xlsx') {
            $zip = new \ZipArchive();
            if ($zip->open($path) !== true) {
                throw new \RuntimeException('File .xlsx tidak dapat dibuka atau rusak.');
            }

            // Baca sharedStrings.xml (kamus teks sel Excel)
            $sharedStrings = [];
            if (($sharedXml = $zip->getFromName('xl/sharedStrings.xml')) !== false) {
                $xml = simplexml_load_string($sharedXml);
                if ($xml && isset($xml->si)) {
                    foreach ($xml->si as $si) {
                        if (isset($si->t)) {
                            $sharedStrings[] = (string) $si->t;
                        } elseif (isset($si->r)) {
                            $text = '';
                            foreach ($si->r as $r) {
                                $text .= (string) ($r->t ?? '');
                            }
                            $sharedStrings[] = $text;
                        } else {
                            $sharedStrings[] = '';
                        }
                    }
                }
            }

            // Cari sheet target berdasarkan nama sheet (jika ada) atau default sheet1.xml
            $targetSheetPath = 'xl/worksheets/sheet1.xml';
            if ($preferredSheet && ($workbookXml = $zip->getFromName('xl/workbook.xml')) !== false) {
                $wb = simplexml_load_string($workbookXml);
                if ($wb && isset($wb->sheets->sheet)) {
                    $sheetIndex = 1;
                    foreach ($wb->sheets->sheet as $sheetNode) {
                        $name = (string) $sheetNode['name'];
                        if (strcasecmp(trim($name), trim($preferredSheet)) === 0) {
                            $candidate = "xl/worksheets/sheet{$sheetIndex}.xml";
                            if ($zip->locateName($candidate) !== false) {
                                $targetSheetPath = $candidate;
                            }
                            break;
                        }
                        $sheetIndex++;
                    }
                }
            }

            $sheetXml = $zip->getFromName($targetSheetPath);
            $zip->close();

            if ($sheetXml === false) {
                throw new \RuntimeException('Worksheet di dalam file .xlsx tidak ditemukan.');
            }

            $sheet = simplexml_load_string($sheetXml);
            $rows = [];

            if ($sheet && isset($sheet->sheetData->row)) {
                foreach ($sheet->sheetData->row as $rowNode) {
                    $rowArr = [];
                    foreach ($rowNode->c as $cell) {
                        // Konversi referensi kolom Excel (misal "A1", "AA4") ke index 0-based
                        $cellRef = (string) $cell['r'];
                        $colLetters = preg_replace('/[0-9]+/', '', $cellRef);
                        $colIdx = 0;
                        for ($i = 0; $i < strlen($colLetters); $i++) {
                            $colIdx = $colIdx * 26 + (ord($colLetters[$i]) - 64);
                        }
                        $colIdx = max(0, $colIdx - 1);

                        $type = (string) $cell['t'];
                        $val = '';

                        if ($type === 's') {
                            $strIdx = (int) $cell->v;
                            $val = $sharedStrings[$strIdx] ?? '';
                        } elseif ($type === 'inlineStr') {
                            $val = (string) ($cell->is->t ?? '');
                        } else {
                            $val = isset($cell->v) ? (string) $cell->v : '';
                        }

                        $rowArr[$colIdx] = $val;
                    }

                    if (!empty($rowArr)) {
                        $maxCol = max(array_keys($rowArr));
                        $normalizedRow = [];
                        for ($c = 0; $c <= $maxCol; $c++) {
                            $normalizedRow[] = $rowArr[$c] ?? '';
                        }
                        $rows[] = $normalizedRow;
                    }
                }
            }

            return $rows;
        }

        throw new \RuntimeException('Format tidak didukung. Gunakan file .xlsx atau .csv.');
    }

    /**
     * Helper membuat slug unik pada tabel target
     */
    private function generateUniqueSlug(string $table, string $sourceText): string
    {
        $baseSlug = StreamController::slug($sourceText) ?: 'item';
        $slug = $baseSlug;
        $counter = 1;

        while (DB::table($table)->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Import Soal ke Kategori Tertentu (Level 4: brain_test_soal & brain_test_opsi_jawaban)
     */
    public function importSoal(Request $request, $kategoriId)
    {
        $kategori = DB::table('brain_test_kategori')->where('id', $kategoriId)->first();
        if (!$kategori) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kategori soal tidak ditemukan.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'file_excel' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ], [
            'file_excel.required' => 'File Excel/CSV wajib dipilih.',
            'file_excel.mimes'    => 'Format file harus .xlsx, .xls, atau .csv.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            $rows = $this->parseSpreadsheetRows($request->file('file_excel'), 'Import_Bank_Soal');
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal membaca file: ' . $e->getMessage(),
            ], 422);
        }

        // Deteksi baris header yang memiliki kolom 'pertanyaan'
        $headerIdx = null;
        $colMap = [];
        foreach ($rows as $idx => $row) {
            $normalized = array_map(fn($v) => strtolower(trim((string) $v)), $row);
            if (in_array('pertanyaan', $normalized, true)) {
                $headerIdx = $idx;
                foreach ($normalized as $cIdx => $colName) {
                    if ($colName !== '') {
                        $colMap[$colName] = $cIdx;
                    }
                }
                break;
            }
        }

        if ($headerIdx === null) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kolom header "pertanyaan" tidak ditemukan di dalam file.',
            ], 422);
        }

        $hurufList = ['A', 'B', 'C', 'D', 'E'];
        $now = now();
        $importedCount = 0;

        DB::beginTransaction();
        try {
            for ($i = $headerIdx + 1; $i < count($rows); $i++) {
                $r = $rows[$i];
                $get = fn(string $key, $default = '') => isset($colMap[$key]) ? trim((string) ($r[$colMap[$key]] ?? $default)) : $default;

                $pertanyaan = $get('pertanyaan');
                if ($pertanyaan === '') {
                    continue;
                }

                $tipeRaw = strtolower($get('tipe_soal', 'pilihan_ganda'));
                $tipeSoal = in_array($tipeRaw, ['pilihan_ganda', 'isian'], true) ? $tipeRaw : 'pilihan_ganda';
                $kunciIsian = $get('kunci_jawaban_isian') ?: null;
                $bobotNilai = is_numeric($get('bobot_nilai')) && (int) $get('bobot_nilai') > 0
                    ? (int) $get('bobot_nilai')
                    : 1;
                $pembahasan = $get('pembahasan') ?: null;

                $soalId = DB::table('brain_test_soal')->insertGetId([
                    'kategori_id'         => $kategori->id,
                    'pertanyaan'          => $pertanyaan,
                    'gambar'              => null,
                    'tipe_soal'           => $tipeSoal,
                    'kunci_jawaban_isian' => $tipeSoal === 'isian' ? $kunciIsian : null,
                    'bobot_nilai'         => $bobotNilai,
                    'pembahasan'          => $pembahasan,
                    'created_at'          => $now,
                    'updated_at'          => $now,
                ]);

                if ($tipeSoal === 'pilihan_ganda') {
                    $kunciHuruf = strtoupper($get('kunci_jawaban'));
                    $opsiRecords = [];

                    foreach ($hurufList as $huruf) {
                        $lower = strtolower($huruf);
                        $teksOpsi = $get('opsi_' . $lower);
                        if ($teksOpsi === '') {
                            continue;
                        }

                        $isBenar = ($kunciHuruf === $huruf);
                        $poinRaw = $get('poin_' . $lower, '');
                        $poin = is_numeric($poinRaw)
                            ? (int) $poinRaw
                            : ($isBenar ? $bobotNilai : 0);

                        $opsiRecords[] = [
                            'soal_id'      => $soalId,
                            'teks_jawaban' => $teksOpsi,
                            'gambar'       => null,
                            'is_benar'     => $isBenar,
                            'poin'         => $poin,
                            'created_at'   => $now,
                            'updated_at'   => $now,
                        ];
                    }

                    if (count($opsiRecords) < 2) {
                        DB::rollBack();
                        return response()->json([
                            'status'  => 'error',
                            'message' => 'Baris ke-' . ($i + 1) . ' (pilihan_ganda) minimal harus memiliki 2 opsi jawaban.',
                        ], 422);
                    }

                    DB::table('brain_test_opsi_jawaban')->insert($opsiRecords);
                }

                $importedCount++;
            }

            if ($importedCount === 0) {
                DB::rollBack();
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Tidak ada baris soal valid yang ditemukan pada file.',
                ], 422);
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => "Berhasil mengimpor {$importedCount} soal ke kategori {$kategori->nama_kategori}.",
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat import soal: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Download Contoh Template Import Soal (CSV)
     */
    public function downloadTemplateSoal()
    {
        $headers = [
            'tipe_soal',
            'pertanyaan',
            'opsi_a',
            'poin_a',
            'opsi_b',
            'poin_b',
            'opsi_c',
            'poin_c',
            'opsi_d',
            'poin_d',
            'opsi_e',
            'poin_e',
            'kunci_jawaban',
            'kunci_jawaban_isian',
            'bobot_nilai',
            'pembahasan',
        ];

        $sample = [
            [
                'pilihan_ganda',
                'Semboyan Bhinneka Tunggal Ika diambil dari kitab...',
                'Negarakertagama',
                0,
                'Sutasoma',
                5,
                'Arjunawiwaha',
                0,
                'Bharatayuddha',
                0,
                'Pararaton',
                0,
                'B',
                '',
                5,
                'Berasal dari Kitab Sutasoma karya Mpu Tantular.',
            ],
            [
                'isian',
                'Tanggal peringatan Hari Lahir Pancasila adalah...',
                '',
                0,
                '',
                0,
                '',
                0,
                '',
                0,
                '',
                0,
                '',
                '1 Juni',
                5,
                'Diperingati setiap 1 Juni.',
            ],
        ];

        return response()->streamDownload(function () use ($headers, $sample) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $headers);
            foreach ($sample as $row) {
                fputcsv($out, $row);
            }
            fclose($out);
        }, 'template-import-soal-brain-test.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * (Opsional) Import Hierarki Lengkap: Klasifikasi -> Paket -> Kategori -> Soal
     */
    public function importMasterLengkap(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_excel' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            $rows = $this->parseSpreadsheetRows($request->file('file_excel'), 'Import_Master_Lengkap');
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }

        $headerIdx = null;
        $colMap = [];
        foreach ($rows as $idx => $row) {
            $normalized = array_map(fn($v) => strtolower(trim((string) $v)), $row);
            if (in_array('nama_klasifikasi', $normalized, true) && in_array('pertanyaan', $normalized, true)) {
                $headerIdx = $idx;
                foreach ($normalized as $cIdx => $colName) {
                    if ($colName !== '') {
                        $colMap[$colName] = $cIdx;
                    }
                }
                break;
            }
        }

        if ($headerIdx === null) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Header sheet Import_Master_Lengkap tidak sesuai.',
            ], 422);
        }

        $hurufList = ['A', 'B', 'C', 'D', 'E'];
        $now = now();
        $totalSoal = 0;

        DB::beginTransaction();
        try {
            for ($i = $headerIdx + 1; $i < count($rows); $i++) {
                $r = $rows[$i];
                $get = fn(string $key, $default = '') => isset($colMap[$key]) ? trim((string) ($r[$colMap[$key]] ?? $default)) : $default;

                $namaKlasifikasi = $get('nama_klasifikasi');
                $namaTest        = $get('nama_test');
                $namaKategori    = $get('nama_kategori');
                $pertanyaan      = $get('pertanyaan');

                if ($namaKlasifikasi === '' || $namaTest === '' || $namaKategori === '' || $pertanyaan === '') {
                    continue;
                }

                // Level 1: brain_test_klasifikasi
                $klasifikasi = DB::table('brain_test_klasifikasi')
                    ->where('nama_klasifikasi', $namaKlasifikasi)
                    ->first();

                if (!$klasifikasi) {
                    $klasifikasiId = DB::table('brain_test_klasifikasi')->insertGetId([
                        'nama_klasifikasi' => $namaKlasifikasi,
                        'slug'             => $this->generateUniqueSlug('brain_test_klasifikasi', $namaKlasifikasi),
                        'deskripsi'        => $get('deskripsi_klasifikasi') ?: null,
                        'status'           => 'aktif',
                        'created_at'       => $now,
                        'updated_at'       => $now,
                    ]);
                } else {
                    $klasifikasiId = $klasifikasi->id;
                }

                // Level 2: brain_test_paket
                $paket = DB::table('brain_test_paket')
                    ->where('klasifikasi_id', $klasifikasiId)
                    ->where('nama_test', $namaTest)
                    ->first();

                if (!$paket) {
                    $paketId = DB::table('brain_test_paket')->insertGetId([
                        'klasifikasi_id' => $klasifikasiId,
                        'nama_test'      => $namaTest,
                        'slug'           => $this->generateUniqueSlug('brain_test_paket', $namaTest),
                        'durasi_menit'   => (int) ($get('durasi_menit', 60) ?: 60),
                        'passing_grade'  => (int) ($get('passing_grade_paket', 0) ?: 0),
                        'deskripsi'      => null,
                        'status'         => 'aktif',
                        'created_at'     => $now,
                        'updated_at'     => $now,
                    ]);
                } else {
                    $paketId = $paket->id;
                }

                // Level 3: brain_test_kategori
                $kategori = DB::table('brain_test_kategori')
                    ->where('paket_id', $paketId)
                    ->where('nama_kategori', $namaKategori)
                    ->first();

                if (!$kategori) {
                    $kategoriId = DB::table('brain_test_kategori')->insertGetId([
                        'paket_id'      => $paketId,
                        'nama_kategori' => $namaKategori,
                        'slug'          => $this->generateUniqueSlug('brain_test_kategori', $namaTest . '-' . $namaKategori),
                        'passing_grade' => (int) ($get('passing_grade_kategori', 0) ?: 0),
                        'urutan'        => (int) ($get('urutan_kategori', 1) ?: 1),
                        'deskripsi'     => null,
                        'created_at'    => $now,
                        'updated_at'    => $now,
                    ]);
                } else {
                    $kategoriId = $kategori->id;
                }

                // Level 4: brain_test_soal + brain_test_opsi_jawaban
                $tipeSoal = in_array(strtolower($get('tipe_soal', 'pilihan_ganda')), ['pilihan_ganda', 'isian'], true)
                    ? strtolower($get('tipe_soal', 'pilihan_ganda'))
                    : 'pilihan_ganda';
                $bobotNilai = max(1, (int) ($get('bobot_nilai', 1) ?: 1));

                $soalId = DB::table('brain_test_soal')->insertGetId([
                    'kategori_id'         => $kategoriId,
                    'pertanyaan'          => $pertanyaan,
                    'gambar'              => null,
                    'tipe_soal'           => $tipeSoal,
                    'kunci_jawaban_isian' => $tipeSoal === 'isian' ? ($get('kunci_jawaban_isian') ?: null) : null,
                    'bobot_nilai'         => $bobotNilai,
                    'pembahasan'          => $get('pembahasan') ?: null,
                    'created_at'          => $now,
                    'updated_at'          => $now,
                ]);

                if ($tipeSoal === 'pilihan_ganda') {
                    $kunciHuruf = strtoupper($get('kunci_jawaban'));
                    $opsiRecords = [];
                    foreach ($hurufList as $huruf) {
                        $lower = strtolower($huruf);
                        $teksOpsi = $get('opsi_' . $lower);
                        if ($teksOpsi === '') continue;

                        $isBenar = ($kunciHuruf === $huruf);
                        $poinRaw = $get('poin_' . $lower, '');
                        $poin = is_numeric($poinRaw) ? (int) $poinRaw : ($isBenar ? $bobotNilai : 0);

                        $opsiRecords[] = [
                            'soal_id'      => $soalId,
                            'teks_jawaban' => $teksOpsi,
                            'gambar'       => null,
                            'is_benar'     => $isBenar,
                            'poin'         => $poin,
                            'created_at'   => $now,
                            'updated_at'   => $now,
                        ];
                    }
                    if (!empty($opsiRecords)) {
                        DB::table('brain_test_opsi_jawaban')->insert($opsiRecords);
                    }
                }

                $totalSoal++;
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => "Import master lengkap berhasil ({$totalSoal} soal diproses).",
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal import master lengkap: ' . $e->getMessage(),
            ], 500);
        }
    }
}
