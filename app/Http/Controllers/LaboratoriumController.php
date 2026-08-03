<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\PdfToImage\Pdf;
use App\Services\ZebraPrinterService;

class LaboratoriumController extends Controller
{
    protected $printerService;
    public function __construct(ZebraPrinterService $printerService)
    {
        $this->middleware('auth');
        $this->printerService = $printerService;
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
    // DATA REGISTRASI LAB
    public function data_registrasi_lab($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('master_doctor', 'master_doctor.master_doctor_code', '=', 'd_reg_order_lab.d_reg_order_lab_rujukan')
                ->orderBy('id_d_reg_order_lab', 'DESC')->get();
            // dd($data);
            return view('application.laboratorium.data-registrasi-lab', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_registrasi_lab_handling(Request $request)
    {
        $data = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->code)
            ->first();
        return view('application.laboratorium.data-registrasi.form-handling', ['data' => $data, 'code' => $request->code]);
    }
    public function data_registrasi_lab_handling_proses(Request $request)
    {
        DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->code)->update([
            'd_reg_order_lab_status' => 1,
            'updated_at' => now()
        ]);
        return 213;
    }
    // SPECIMEN COLLECTION
    public function data_specimen_collection_lab($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->where('d_reg_order_lab_status', 1)
                ->get();
            return view('application.laboratorium.data-specimen-collection', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function data_specimen_collection_lab_cari_data(Request $request)
    {
        $data = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->code)->first();
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->code)->get();
        if ($data) {
            if ($data->d_reg_order_lab_status == 0) {
                return 'not';
            } elseif (($data->d_reg_order_lab_status == 1)) {
                return view('application.laboratorium.speciment-collection.detail-speciment', ['data' => $data, 'pemeriksaan' => $pemeriksaan, 'code' => $request->code]);
            } elseif (($data->d_reg_order_lab_status >= 2)) {
                return 'done';
            }
        } else {
            return 'false';
        }
    }
    public function data_specimen_collection_lab_detail(Request $request)
    {
        return 123;
    }
    public function data_specimen_collection_lab_print_barcode(Request $request)
    {
        $codeId     = $request->query('code');     // id_t_pemeriksaan_list
        $specimenId = $request->query('specimen'); // t_pem_specimen_code
        $regId      = $request->query('reg');      // order_lab_list_code

        // 1. Ambil data spesimen saja (tanpa join ke order_lab_list yang tidak ada)
        $specimenData = DB::table('t_pem_specimen as tps')
            ->join('s_specimen_data as ssd', 'ssd.s_specimen_data_code', '=', 'tps.s_specimen_data_code')
            ->where('tps.t_pem_specimen_code', '=', $specimenId) // Di-binding aman oleh Query Builder
            ->select(
                'tps.t_pem_specimen_code',
                'ssd.s_specimen_data_name'
            )
            ->first();

        // Jika Anda punya tabel registrasi/pasien lain, ganti 'NAMA_TABEL_ANDA' di bawah:
        /*
    $patientData = DB::table('NAMA_TABEL_ANDA')
        ->where('order_lab_list_code', $regId)
        ->first();
    */

        if (!$specimenData) {
            return response('
            <div class="alert alert-danger text-center m-0 p-2">
                <i class="fas fa-exclamation-triangle me-1"></i> Data spesimen tidak ditemukan.
            </div>
        ', 404);
        }

        // 2. Generate Barcode (C128)
        $dns1d = new \Milon\Barcode\DNS1D();
        $barcodeHtml = $dns1d->getBarcodeHTML($regId, 'C128', 1.5, 45);

        // 3. Susun HTML Preview
        $html = '
        <div style="font-family: Arial, sans-serif; text-align: center; color: #333; padding: 5px;">
            <div style="font-size: 11px; font-weight: bold; margin-bottom: 4px;">
                Sample : ' . e($specimenData->s_specimen_data_name) . '
            </div>

            <div style="display: flex; justify-content: center; align-items: center; margin: 8px 0; background: #fff; padding: 4px;">
                ' . $barcodeHtml . '
            </div>

            <div style="font-size: 10px; font-weight: bold; letter-spacing: 0.5px;">
                ' . e($regId) . '
            </div>


        </div>
        ';

        return response($html, 200)->header('Content-Type', 'text/html');
    }
    public function data_specimen_collection_lab_print_barcode_proses(Request $request)
    {
        try {
            $code     = $request->input('code');     // id_t_pemeriksaan_list / kode pemeriksaan
            $specimen = $request->input('specimen'); // t_pem_specimen_code / kode spesimen
            $reg      = $request->input('reg');      // order_lab_list_code / no reg yang di-barcode

            // 1. Ambil nama spesimen dari database agar tampilan cetakan lebih informatif
            $specimenData = DB::table('t_pem_specimen as tps')
                ->join('s_specimen_data as ssd', 'ssd.s_specimen_data_code', '=', 'tps.s_specimen_data_code')
                ->where('tps.t_pem_specimen_code', '=', $specimen)
                ->select('ssd.s_specimen_data_name')
                ->first();

            $specimenName = $specimenData->s_specimen_data_name ?? 'Spesimen';

            // 2. Susun Kode ZPL untuk Printer Zebra (Label 5x3 cm @ 203 DPI)
            $zplCode = "^XA";
            $zplCode .= "^CI28"; // Support UTF-8

            // Pengaturan Ukuran Label (400x240 dots)
            $width = 400;
            $zplCode .= "^PW" . $width;
            $zplCode .= "^LL240";
            $zplCode .= "^LS0";

            // Teks Header 1: No. Registrasi / Kode Pemeriksaan
            $zplCode .= "^FO0,20^FB400,1,0,C^A0N,22,22^FDREG: " . $reg . "^FS";

            // Teks Header 2: Nama Spesimen
            $zplCode .= "^FO0,50^FB400,1,0,C^A0N,20,20^FDSAMPEL: " . $specimenName . "^FS";

            // Perhitungan Lebar & Posisi Presisi Barcode (Code 128)
            // Nilai barcode yang dicetak menggunakan $specimen (atau $reg sesuai kebutuhan)
            $barcodeValue = $specimen;
            $skuLength    = strlen($barcodeValue);

            // Modul lebar 2 (BY2) -> estimasi ~11 dots per karakter + quiet zone
            $barcodeWidth = ($skuLength * 11 * 2) + 40;
            $barcodeX     = floor(($width - $barcodeWidth) / 2);

            // Batas aman margin kiri jika teks barcode sangat panjang
            if ($barcodeX < 15) {
                $barcodeX = 15;
            }

            // Cetak Barcode Code128 (^BCN, tinggi 60 dots, print text interpretation below = Y)
            $zplCode .= "^FO" . $barcodeX . ",90^BY2^BCN,60,Y,N,N^FD" . $barcodeValue . "^FS";

            $zplCode .= "^XZ";

            // 3. Eksekusi pengiriman perintah ZPL ke Printer Zebra
            $printResult = $this->printerService->sendToPrinter($zplCode);

            // Periksa status pengiriman printer
            if ($printResult) {
                return response()->json([
                    'success' => true,
                    'message' => 'Label barcode spesimen berhasil dikirim ke printer Zebra.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal terhubung atau mengirim perintah ke printer Zebra.'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
    public function data_specimen_collection_lab_proses(Request $request)
    {
        DB::table('s_specimen_log')->insert([
            's_specimen_log_code' => $request->reg . '' . Str::upper(Str::random(2)),
            't_pem_specimen_code' => $request->specimen,
            'order_lab_list_code' => $request->reg,
            's_specimen_log_time' => now(),
            's_specimen_log_end_time' => 0,
            's_specimen_log_user' => Auth::user()->userid,
            's_specimen_log_status' => 0,
            'created_at' => now(),
        ]);
        $specimenData = DB::table('t_pem_specimen')
            ->join('s_specimen_data', 's_specimen_data.s_specimen_data_code', '=', 't_pem_specimen.s_specimen_data_code')
            ->where('t_pem_specimen_code', $request->specimen)
            ->first();
        $specimenName = $specimenData->s_specimen_data_name ?? 'Spesimen';
        $codeId     = $request->code;
        $specimenId = $request->specimen;
        $regId      = $request->reg;
        $logTime    = now()->format('H:i');
        return '
        <div class="d-inline-flex flex-column align-items-center">
            <button class="btn btn-warning btn-sm shadow-sm px-3 py-1 d-flex align-items-center justify-content-center gap-1"
                id="button-simpan-specimen' . $codeId . $specimenId . '"
                data-code="' . $codeId . '"
                data-specimen="' . $specimenId . '"
                data-reg="' . $regId . '"
                title="Klik untuk Menyelesaikan Proses Spesimen">
                <i class="fas fa-clock me-1"></i> Proses (' . $logTime . ')
            </button>
            <small class="text-muted fw-semibold mt-1 fs--2">
                ' . $specimenName . '
            </small>
        </div>';
    }
    public function data_specimen_collection_lab_proses_simpan(Request $request)
    {
        DB::table('s_specimen_log')
            ->where('t_pem_specimen_code', $request->specimen)
            ->where('order_lab_list_code', $request->reg)
            ->update([
                's_specimen_log_end_time' => now(),
                's_specimen_log_status'   => 1,
            ]);

        // Ambil data pendukung untuk identifier tombol (jika diperlukan)
        $codeId     = $request->code;
        $specimenId = $request->specimen;
        $regId      = $request->reg;
        // 2. Ambil nama spesimen dari database
        $specimenData = DB::table('t_pem_specimen')
            ->join('s_specimen_data', 's_specimen_data.s_specimen_data_code', '=', 't_pem_specimen.s_specimen_data_code')
            ->where('t_pem_specimen_code', $request->specimen)
            ->first();

        $specimenName = $specimenData->s_specimen_data_name ?? 'Spesimen';
        // Mengembalikan tampilan tombol Selesai + Tombol Print Barcode + Event Handler JS
        return '
        <div class="d-inline-flex flex-column align-items-center">
            <button class="btn btn-success btn-sm shadow-sm px-3 py-1 d-flex align-items-center justify-content-center gap-1"
                id="button-print-barcode-ajax-' . $codeId . '"
                data-code="' . $codeId . '"
                data-specimen="' . $specimenId . '"
                data-reg="' . $regId . '"
                title="Klik untuk Cetak Barcode Sampel">
                <i class="fas fa-barcode"></i> Print Barcode
            </button>
            <small class="text-muted fw-semibold mt-1 fs--2">
                ' . $specimenName . '
            </small>
        </div>

        <script>
            $(document).off("click", "#button-print-barcode-ajax-' . $codeId . '").on("click", "#button-print-barcode-ajax-' . $codeId . '", function(e) {
                e.preventDefault();
                var code = $(this).data("code");
                var specimen = $(this).data("specimen");
                var reg = $(this).data("reg");

                var url = "' . url('data-specimen-collection-lab/print-barcode') . '?code=" + code + "&specimen=" + specimen + "&reg=" + reg;
                window.open(url, "_blank", "width=400,height=500");
            });
        </script>
        ';
    }
    public function data_specimen_collection_lab_proses_simpan_fix(Request $request)
    {
        DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->code)->update([
            'd_reg_order_lab_status' => 2,
            'updated_at' => now(),
        ]);
        return 123;
    }
    // PROSE RESULT
    public function menu_lab_proses_result($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->where('d_reg_order_lab_status', 2)
                ->get();
            return view('application.laboratorium.proses-result', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_lab_proses_result_detail(Request $request)
    {
        $data = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->code)->first();
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->code)->get();
        return view('application.laboratorium.proses-result.detail-proses-result', ['data' => $data, 'pemeriksaan' => $pemeriksaan, 'code' => $request->code]);
    }
    public function menu_lab_proses_result_detail_sinkronisasi(Request $request)
    {
        $code = $request->input('code'); // d_reg_order_lab_code / nolab
        $listCodes = $request->input('list_codes', []); // Array kode dari halaman aktif

        if (empty($listCodes)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Tidak ada kode parameter yang dikirim dari halaman.'
            ], 400);
        }

        // 1. Ambil data alat dari medical_interface_result berdasarkan nolab
        $interfaceData = DB::table('medical_interface_result')
            ->where('nolab', $code)
            ->latest('tanggal')
            ->first();

        if (!$interfaceData || empty($interfaceData->results)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Data dari alat tidak ditemukan untuk No. Lab: ' . $code
            ], 404);
        }

        // Ambil instrumen/alat jika ada di kolom medical_interface_result
        $instrumentId = $interfaceData->instrumen ?? $interfaceData->id_instrumen ?? null;

        // 2. Decode kolom results dari JSON
        $resultsArray = is_string($interfaceData->results)
            ? json_decode($interfaceData->results, true)
            : $interfaceData->results;

        if (!is_array($resultsArray) || empty($resultsArray)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Format data JSON hasil alat tidak valid.'
            ], 400);
        }

        // 3. Ambil master parameter t_pemeriksaan_list_val berdasarkan list_codes halaman aktif
        $masterParams = DB::table('t_pemeriksaan_list_val')
            ->whereIn('t_pem_list_val_code', $listCodes)
            ->get();

        DB::beginTransaction();
        try {
            $savedCount = 0;
            $updatedValues = [];

            // Pre-fetch data existing h_reg_lab untuk efisiensi
            $existingRecords = DB::table('h_reg_lab')
                ->where('d_reg_order_lab_code', $code)
                ->whereIn('t_pem_list_val_code', $listCodes)
                ->get()
                ->keyBy('t_pem_list_val_code');

            foreach ($resultsArray as $item) {
                $paramPx   = $item['px'] ?? null;     // Kode parameter dari alat ("GLUC", "1", dll)
                $rawResult = $item['result'] ?? null; // Hasil alat ("140", "25^1+", dll)
                $rawFlag   = $item['flag'] ?? null;   // Flag alat ("EXP^HIGH", "HIGH", "L", dll)

                // Lewati jika px atau hasilnya kosong
                if ($paramPx === null || $rawResult === null || $rawResult === '') {
                    continue;
                }

                // 4. Match px dari JSON alat ke t_pem_list_val_param & t_pem_list_val_instrumen
                $matchedMaster = $masterParams->first(function ($master) use ($paramPx, $instrumentId) {
                    $paramMatches = (string) $master->t_pem_list_val_param === (string) $paramPx;

                    if ($instrumentId && !empty($master->t_pem_list_val_instrumen)) {
                        return $paramMatches && (strcasecmp($master->t_pem_list_val_instrumen, $instrumentId) === 0);
                    }

                    return $paramMatches;
                });

                // Jika tidak cocok dengan master parameter halaman aktif, lewati
                if (!$matchedMaster) {
                    continue;
                }

                $testCode = $matchedMaster->t_pem_list_val_code;

                // --- Ambil Metode dari t_pemeriksaan_list_val ---
                $metode = !empty($matchedMaster->t_pem_list_val_metode) ? $matchedMaster->t_pem_list_val_metode : '-';

                // --- Parsing format Value jika mengandung '^' ---
                if (str_contains($rawResult, '^')) {
                    $partsValue = explode('^', $rawResult);
                    $value = !empty($partsValue[1]) ? $partsValue[1] : $partsValue[0];
                } else {
                    $value = $rawResult;
                }

                // --- PERKALIAN VALUE DENGAN FIELD t_pem_list_val_kali ---
                $multiplier = $matchedMaster->t_pem_list_val_kali ?? null;
                if (is_numeric($value) && is_numeric($multiplier) && (float)$multiplier != 0) {
                    $value = (float)$value * (float)$multiplier;
                }

                // --- Parsing format Flag jika mengandung '^' (misal: "EXP^HIGH" -> "HIGH") ---
                $flag = '-';
                if (!empty($rawFlag)) {
                    if (str_contains($rawFlag, '^')) {
                        $partsFlag = explode('^', $rawFlag);
                        $flag = !empty($partsFlag[1]) ? $partsFlag[1] : $partsFlag[0];
                    } else {
                        $flag = $rawFlag;
                    }
                }

                $existing = $existingRecords->get($testCode);

                // 5. Upsert ke h_reg_lab
                DB::table('h_reg_lab')->updateOrInsert(
                    [
                        'd_reg_order_lab_code' => $code,
                        't_pem_list_val_code'  => $testCode,
                    ],
                    [
                        'h_reg_lab_code'   => $existing ? $existing->h_reg_lab_code : 'LAB-' . strtoupper(Str::random(10)),
                        'h_reg_lab_value'  => $value, // <-- NILAI YANG SUDAH DIKALIKAN
                        'h_reg_lab_flag'   => $flag,
                        'h_reg_lab_metode' => $metode,
                        'updated_at'       => now(),
                        'created_at'       => $existing ? $existing->created_at : now(),
                    ]
                );

                $updatedValues[$testCode] = $value;
                $savedCount++;
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Berhasil menyinkronkan ' . $savedCount . ' parameter.',
                'data'    => $updatedValues
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
    public function menu_lab_proses_result_simpan_sinkronisasi(Request $request)
    {
        $orderCode  = $request->input('code'); // d_reg_order_lab_code
        $hasilData  = $request->input('hasil', []); // Array [t_pem_list_val_code => value]
        $flagData   = $request->input('flag', []);  // Array [t_pem_list_val_code => flag]
        $metodeData = $request->input('metode', []); // Array [t_pem_list_val_code => metode]

        $savedCodes = [];

        DB::beginTransaction();
        try {
            foreach ($hasilData as $valCode => $value) {
                // 1. Abaikan jika nilai hasil kosong
                if ($value === null || $value === '') {
                    continue;
                }

                // 2. Proteksi Tambahan: Abaikan jika data berupa Kepala/Parent (opt = 'Y')
                $masterVal = DB::table('t_pemeriksaan_list_val')
                    ->where('t_pem_list_val_code', $valCode)
                    ->first();

                if ($masterVal && $masterVal->t_pem_list_val_opt === 'Y') {
                    continue;
                }

                $flag   = $flagData[$valCode] ?? '*';
                $metode = $metodeData[$valCode] ?? ($masterVal->t_pem_list_val_metode ?? '-');

                // 3. Cek apakah record di h_reg_lab sudah ada sebelumnya
                $existing = DB::table('h_reg_lab')
                    ->where('d_reg_order_lab_code', $orderCode)
                    ->where('t_pem_list_val_code', $valCode)
                    ->first();

                if ($existing) {
                    // Update record yang sudah ada
                    DB::table('h_reg_lab')
                        ->where('d_reg_order_lab_code', $orderCode)
                        ->where('t_pem_list_val_code', $valCode)
                        ->update([
                            'h_reg_lab_flag'   => $flag,
                            'h_reg_lab_value'  => $value,
                            'h_reg_lab_metode' => $metode,
                            'updated_at'       => now(),
                        ]);
                } else {
                    // Insert record baru
                    DB::table('h_reg_lab')->insert([
                        'h_reg_lab_code'       => 'LAB-' . strtoupper(Str::random(10)),
                        'd_reg_order_lab_code' => $orderCode,
                        't_pem_list_val_code'  => $valCode,
                        'h_reg_lab_flag'       => $flag,
                        'h_reg_lab_value'      => $value,
                        'h_reg_lab_metode'     => $metode,
                        'created_at'           => now(),
                        'updated_at'           => now(),
                    ]);
                }

                $savedCodes[] = $valCode;
            }

            DB::commit();

            return response()->json([
                'status'      => 'success',
                'message'     => 'Data hasil pemeriksaan berhasil disimpan!',
                'saved_codes' => $savedCodes
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }
    public function menu_lab_proses_result_detail_proses_save(Request $request)
    {
        $data = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->join('t_pemeriksaan_list_val', 't_pemeriksaan_list_val.t_pemeriksaan_list_code', '=', 't_pemeriksaan_list.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_list.d_reg_order_lab_code', $request->code)->get();
        foreach ($data as $value) {
            $cek = DB::table('h_reg_lab')->where('d_reg_order_lab_code', $request->code)->where('t_pem_list_val_code', $value->t_pem_list_val_code)->first();
            if ($cek) {
                DB::table('h_reg_lab')
                    ->where('d_reg_order_lab_code', $request->code)
                    ->where('t_pem_list_val_code', $value->t_pem_list_val_code)->update([
                        'h_reg_lab_value' => $request[$value->t_pem_list_val_code],
                        'h_reg_lab_metode' => $request['opt' . $value->t_pem_list_val_code],
                        'created_at' => now()
                    ]);
            } else {
                DB::table('h_reg_lab')->insert([
                    'h_reg_lab_code' => str::uuid(),
                    'd_reg_order_lab_code' => $request->code,
                    't_pem_list_val_code' => $value->t_pem_list_val_code,
                    'h_reg_lab_value' => $request[$value->t_pem_list_val_code],
                    'h_reg_lab_metode' => $request['opt' . $value->t_pem_list_val_code],
                    'created_at' => now()
                ]);
            }
        }
        $datax = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->code)->first();
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->code)->get();
        return view('application.laboratorium.proses-result.detail-proses-result', ['data' => $datax, 'pemeriksaan' => $pemeriksaan, 'code' => $request->code]);
    }
    // VERIFIKASI LAB
    public function verifikasi_laboratorium($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->join('master_doctor', 'master_doctor.master_doctor_code', '=', 'd_reg_order_lab.d_reg_order_lab_rujukan')
                ->where('d_reg_order_lab_status', 2)
                ->get();
            return view('application.laboratorium.verifikasi-hasil-lab', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function verifikasi_laboratorium_detail(Request $request)
    {
        $data = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->reg)->first();
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->reg)->get();
        return view('application.laboratorium.verifikasi-hasil.verifikasi-hasil-detail', [
            'code' => $request->code,
            'reg' => $request->reg,
            'pemeriksaan' => $pemeriksaan,
            'data' => $data,
        ]);
    }
    public function verifikasi_laboratorium_verifikasi_data(Request $request)
    {
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->reg)->get();
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $data = DB::table('d_reg_order')->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order.d_reg_order_code', $request->code)->first();
        $reg = DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->reg)->first();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.laboratorium.verifikasi-hasil.report.report-hasil-lab', [
            'code' => $request->code,
            'data' => $data,
            'reg' => $reg,
            'pemeriksaan' => $pemeriksaan,
        ], compact('image'))->setPaper('A4', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 575, 823);
            ');
        $pdf->get_canvas()->get_cpdf()->setEncryption("admin", date('dmY', strtotime($data->master_patient_tgl_lahir)));
        $file = base64_encode($pdf->stream());
        $base64Pdf = 'data:application/pdf;base64,' . $file; // Your Base64 encoded PDF string
        list($type, $data) = explode(';', $base64Pdf);
        list(, $data) = explode(',', $data);
        $pdfBinaryData = base64_decode($data);
        $tempPdfPath = storage_path('app/public/hasil/lab/' . $request->reg . '.pdf');
        file_put_contents($tempPdfPath, $pdfBinaryData);
        DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->reg)->update([
            'd_reg_order_lab_status' => 3,
            'updated_at' => now(),
        ]);
        return 'berhasil';
    }
    public function verifikasi_laboratorium_preview_report(Request $request)
    {
        $pemeriksaan = DB::table('d_reg_order_lab_list')
            ->join('p_sales_data', 'p_sales_data.p_sales_data_code', '=', 'd_reg_order_lab_list.p_sales_data_code')
            ->join('t_pemeriksaan_list', 't_pemeriksaan_list.t_pemeriksaan_list_code', '=', 'p_sales_data.t_pemeriksaan_list_code')
            ->where('d_reg_order_lab_code', $request->reg)->get();
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $data = DB::table('d_reg_order')->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order.d_reg_order_code', $request->code)->first();
        $reg = DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->reg)->first();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.laboratorium.verifikasi-hasil.report.report-hasil-lab', [
            'code' => $request->code,
            'data' => $data,
            'reg' => $reg,
            'pemeriksaan' => $pemeriksaan,
        ], compact('image'))->setPaper('A4', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $font1 = $dompdf->getFontMetrics()->get_font("helvetica", "normal");
        $dompdf->get_canvas()->page_text(300, 820, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
        $dompdf->get_canvas()->page_text(34, 820, "Print by. Admin", $font1, 10, array(0, 0, 0));
        $canvas = $pdf->getDomPDF()->getCanvas();
        $canvas->page_script('
            // $pdf->set_opacity(.9);
            $pdf->image("img/cover.png", 12, 12, 575, 823);
            ');
        return base64_encode($pdf->stream());
    }
    // DOKUMENTASI HASIL
    public function dokumentasi_hasil_laboratorium($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')
                ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
                ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
                ->where('d_reg_order_lab_status', '>', 2)
                ->get();
            return view('application.laboratorium.dokumentasi-hasil-lab', ['data' => $data, 'akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function dokumentasi_hasil_laboratorium_detail(Request $request)
    {
        $data = DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->code)->first();
        return view('application.laboratorium.dokumentasi-hasil.form-dokumentasi-hasil', ['data' => $data, 'code' => $request->code]);
    }
    public function dokumentasi_hasil_laboratorium_detail_kirim_hasil(Request $request)
    {
        $user = DB::table('d_reg_order_lab')
            ->join('d_reg_order', 'd_reg_order.d_reg_order_code', '=', 'd_reg_order_lab.d_reg_order_code')
            ->join('master_patient', 'master_patient.master_patient_code', '=', 'd_reg_order.d_reg_order_rm')
            ->where('d_reg_order_lab.d_reg_order_lab_code', $request->code)->first();
        $nomorhp = $user->master_patient_no_hp;
        //Terlebih dahulu kita trim dl
        $nomorhp = trim($nomorhp);
        //bersihkan dari karakter yang tidak perlu
        $nomorhp = strip_tags($nomorhp);
        // Berishkan dari spasi
        $nomorhp = str_replace(" ", "", $nomorhp);
        // Berishkan dari -
        $nomorhp = str_replace("-", "", $nomorhp);
        // bersihkan dari bentuk seperti  (022) 66677788
        $nomorhp = str_replace("(", "", $nomorhp);
        // bersihkan dari format yang ada titik seperti 0811.222.333.4
        $nomorhp = str_replace(".", "", $nomorhp);

        if (!preg_match('/[^+0-9]/', trim($nomorhp))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($nomorhp), 0, 3) == '+62') {
                $nomorhp = trim($nomorhp);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif (substr($nomorhp, 0, 1) == '0') {
                $nomorhp = '+62' . substr($nomorhp, 1);
            }
        }
        // $tempPdfPath = storage_path('app/public/hasil/rpt.pdf');
        $name = storage_path('app/public/hasil/lab/' . $request->code . '.pdf');

        $img = file_get_contents($name);
        // a route is created, (it must already be created in its repository(pdf)).
        // $rute    = "pdf/" . $name;
        $pass = date('dmY', strtotime($user->master_patient_tgl_lahir));
        // decode base64
        $pdf_b64 = base64_encode($img);
        $cek = DB::table('v_log_whatsapp')->where('d_reg_order_list_code', $request->code)->first();
        // you record the file in existing folder
        if ($cek) {
            DB::table('v_log_whatsapp')->where('d_reg_order_list_code', $request->code)->update([
                'v_log_whatsapp_number' => $nomorhp,
                'v_log_whatsapp_name' => $user->master_patient_name,
                'v_log_whatsapp_filename' => $request->code . date('his'),
                'v_log_whatsapp_text' => "Halo, " . $user->master_patient_name . "\nHasil Lab Dengan Password Tanggal Lahir : Ex. 01011991",
                'v_log_whatsapp_file' => $pdf_b64,
                'v_log_whatsapp_picture' => '0',
                'v_log_whatsapp_status' => 0,
                'v_log_whatsapp_date' => now(),
                'v_log_whatsapp_pass' => $pass,
            ]);
        } else {
            DB::table('v_log_whatsapp')->insert([
                'v_log_whatsapp_code' => str::uuid() . mt_rand(1000, 9999),
                'd_reg_order_list_code' => $request->code,
                'v_log_whatsapp_number' => $nomorhp,
                'v_log_whatsapp_name' => $user->master_patient_name,
                'v_log_whatsapp_filename' => $request->code . date('his'),
                'v_log_whatsapp_text' => "Halo, " . $user->master_patient_name . "\nHasil Lab Dengan Password Tanggal Lahir : Ex. 01011991",
                'v_log_whatsapp_file' => $pdf_b64,
                'v_log_whatsapp_picture' => '0',
                'v_log_whatsapp_status' => 0,
                'v_log_whatsapp_date' => now(),
                'v_log_whatsapp_pass' => $pass,
                'created_at' => now(),
            ]);
        }
        DB::table('d_reg_order_lab')->where('d_reg_order_lab_code', $request->code)->update([
            'd_reg_order_lab_status' => 4,
            'updated_at' => now(),
        ]);
        return $pdf_b64;
    }
    public function dokumentasi_hasil_laboratorium_detail_batal_kirim_hasil(Request $request)
    {
        return 123;
    }
    // PENGIRIMAN HASIL
    public function pengiriman_hasil_laboratorium($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')->join('v_log_whatsapp', 'v_log_whatsapp.d_reg_order_list_code', '=', 'd_reg_order_lab.d_reg_order_lab_code')->get();
            return view('application.laboratorium.pengiriman-hasil-lab', ['akses' => $akses, 'data' => $data, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function pengiriman_hasil_laboratorium_add(Request $request)
    {
        return view('application.laboratorium.pengiriman-hasil.form-add-whatsapp');
    }
    public function pengiriman_hasil_laboratorium_save(Request $request)
    {
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.laboratorium.pengiriman-hasil.format-pdf', compact('image'))->setPaper('A5', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        $file = base64_encode($pdf->stream());
        $base64Pdf = 'data:application/pdf;base64,' . $file; // Your Base64 encoded PDF string
        list($type, $data) = explode(';', $base64Pdf);
        list(, $data) = explode(',', $data);
        $pdfBinaryData = base64_decode($data);
        $tempPdfPath = storage_path('app/temp_pdf_' . str::uuid() . '.pdf');
        file_put_contents($tempPdfPath, $pdfBinaryData);


        // $pdf = new Pdf($tempPdfPath);
        // $outputImagePath = storage_path('app/converted_image_' . str::uuid() . '.jpg');
        // $pdf->saveImage($outputImagePath);
        try {
            $pdf = new Pdf($tempPdfPath);
            $outputImagePath = storage_path('app/converted_image_' . str::uuid() . '.jpg');
            $pdf->saveImage($outputImagePath);
            $qrcode = base64_encode(file_get_contents($outputImagePath));
            DB::table('v_log_whatsapp')->insert([
                'v_log_whatsapp_code' => str::uuid() . mt_rand(1000, 9999),
                'd_reg_order_list_code' => '123132213',
                'v_log_whatsapp_number' => '+6281933770710',
                'v_log_whatsapp_name' => 'Agus Raharjo',
                'v_log_whatsapp_text' => 'Halo',
                'v_log_whatsapp_file' => $file,
                'v_log_whatsapp_picture' => $qrcode,
                'v_log_whatsapp_status' => 0,
                'v_log_whatsapp_date' => now(),
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Handle any errors during conversion
            echo 'Error converting PDF: ' . $e->getMessage();
        } finally {
            // Clean up the temporary PDF file
            if (file_exists($tempPdfPath)) {
                unlink($tempPdfPath);
            }
            if (file_exists($outputImagePath)) {
                unlink($outputImagePath);
            }
        }
        // $pdf = new Pdf($tempPdfPath);
        // $pdf->saveImage(storage_path('app/public/test.jpg'));

        // Now $outputImagePath contains the path to your converted JPG image
        // You can then serve this image or store its path in your database.



        // $qrcode = base64_encode(QrCode::format('png')
        //     ->size(500)
        //     // ->merge('/storage/app/public/logo.png')
        //     ->errorCorrection('H')
        //     ->eyeColor(2, 100, 100, 255, 0, 0, 0)
        //     ->style('round')
        //     ->margin(2)
        //     ->generate(str::uuid()));

        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Pengiriman Whatsapp');
    }
    public function pengiriman_hasil_laboratorium_template()
    {
        $image = base64_encode(file_get_contents(public_path('img/logo.png')));
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadview('application.laboratorium.verifikasi-hasil.report.report-hasil-lab', compact('image'))->setPaper('A4', 'potrait')->setOptions(['defaultFont' => 'Helvetica']);
        $pdf->output();
        return $pdf->stream();
    }
    // PENGIRIMAN HASIL
    public function pendaftaran_lab_registrasi($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $data = DB::table('d_reg_order_lab')->join('v_log_whatsapp', 'v_log_whatsapp.d_reg_order_list_code', '=', 'd_reg_order_lab.d_reg_order_lab_code')->get();
            return view('app-medical.laboratorium.pendaftara-lab', ['akses' => $akses, 'data' => $data, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // INTERFACE DATA RESULT
    public function interfave_lab_data_result($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            // Mengambil daftar alat untuk dropdown filter di frontend
            $alatList = DB::table('medical_master_alat')
                ->where('status', 'aktif')
                ->select('instrument_id', 'kode_alat', 'nama_alat')
                ->get();
            return view('app-medical.laboratorium.interface-lab-data-result', ['akses' => $akses, 'alatList' => $alatList, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function interfave_lab_data_result_get_data(Request $request)
    {
        // 1. Base Query dengan JOIN ke tabel medical_master_alat
        $query = DB::table('medical_interface_result as mir')
            ->leftJoin('medical_master_alat as mma', 'mir.instrument_id', '=', 'mma.instrument_id')
            ->select([
                'mir.id',
                'mir.nolab',
                'mir.tanggal',
                'mir.flag_qc',
                'mir.flag_query',
                'mir.instrument_id',
                'mma.kode_alat',
                'mma.nama_alat',
                'mma.lokasi_ruangan'
            ]);

        $totalData = DB::table('medical_interface_result')->count();

        // 2. Filter No. Lab
        if ($request->filled('nolab')) {
            $query->where('mir.nolab', 'like', '%' . trim($request->nolab) . '%');
        }

        // 3. Filter Tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('mir.tanggal', $request->tanggal);
        }

        // 4. Filter Berdasarkan Alat / Instrument ID
        if ($request->filled('instrument_id')) {
            $query->where('mir.instrument_id', $request->instrument_id);
        }

        // 5. Global Search DataTables
        $searchValue = $request->input('search.value');
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('mir.nolab', 'like', "%{$searchValue}%")
                    ->orWhere('mma.kode_alat', 'like', "%{$searchValue}%")
                    ->orWhere('mma.nama_alat', 'like', "%{$searchValue}%");
            });
        }

        $totalFiltered = $query->count();

        // 6. Pagination & Ordering
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $data = $query->orderBy('mir.tanggal', 'desc')
            ->offset($start)
            ->limit($length)
            ->get();

        // 7. Format Data Response
        $formattedData = $data->map(function ($row) {
            return [
                'id' => $row->id,
                'nolab' => $row->nolab,
                'nama_instrument' => $row->nama_alat
                    ? "<strong>{$row->nama_alat}</strong> <br><small class='text-muted'>[{$row->kode_alat}] - {$row->lokasi_ruangan}</small>"
                    : "<span class='text-muted'>ID: " . ($row->instrument_id ?? '-') . "</span>",
                'tanggal' => $row->tanggal ? date('d-m-Y H:i:s', strtotime($row->tanggal)) : '-',
                'flag_qc' => $row->flag_qc === 'Y'
                    ? '<span class="badge bg-warning text-dark">QC</span>'
                    : '<span class="badge bg-secondary">N</span>',
                'flag_query' => $row->flag_query === 'Y'
                    ? '<span class="badge bg-danger">Query</span>'
                    : '<span class="badge bg-secondary">N</span>',
                'action' => '
                    <select class="form-select form-select-sm action-select" data-id="' . $row->id . '">
                        <option value="" selected disabled>-- Pilih Aksi --</option>
                        <option value="toggle-detail">👁️ Detail Hasil</option>
                        <option value="raw-payload">📜 Raw Payload</option>
                    </select>
                '
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $formattedData
        ]);
    }
    public function interfave_lab_data_result_show_data_detail($id)
    {
        $result = DB::table('medical_interface_result as mir')
            ->leftJoin('medical_master_alat as mma', 'mir.instrument_id', '=', 'mma.instrument_id')
            ->where('mir.id', $id)
            ->select('mir.*', 'mma.nama_alat', 'mma.kode_alat')
            ->first();

        if (!$result) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        // Decode JSON results ke Array
        $parsedResults = json_decode($result->results, true) ?? [];

        return response()->json([
            'status' => 'success',
            'info' => [
                'nolab' => $result->nolab,
                'nama_alat' => $result->nama_alat ?? 'Unknown Instrument',
                'kode_alat' => $result->kode_alat ?? '-',
                'tanggal' => $result->tanggal ? date('d-m-Y H:i:s', strtotime($result->tanggal)) : '-',
                'flag_qc' => $result->flag_qc,
                'flag_query' => $result->flag_query,
            ],
            'results' => $parsedResults
        ]);
    }
    public function interfave_lab_data_result_show_data_raw($id)
    {
        $result = DB::table('medical_interface_result')->where('id', $id)->first();

        if (!$result) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'nolab' => $result->nolab,
            'raw_payload' => $result->raw_payload ?? 'Tidak ada data raw payload.'
        ]);
    }
}
