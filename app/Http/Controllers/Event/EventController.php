<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event\EventModel;
use App\Models\Event\SubEventModel;
use App\Models\Movie;
use App\Models\NewsCat;
use App\Models\NewsData;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use App\Services\ZebraPrinterService;
use Svg\Tag\Rect;

class EventController extends Controller
{
    // 2. WAJIB DEKLARASIKAN PROPERTI INI DI LUAR METHOD
    protected $printerService;

    // 3. SEPERTI INI CARA INJECT-NYA DI CONSTRUCTOR

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
    public function menu_event_create($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $cat = NewsCat::latest()->get();
            return view('app-event.menu-event.create-event', ['akses' => $akses, 'code' => $id, 'cat' => $cat]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_event_create_save(Request $request)
    {
        if ($request->link_cover == '') {
            $cover = null;
        } else {
            $cover = 'event/cover/' . auth::user()->userid . '/' . $request->link_cover;
        }
        try {
            EventModel::insert([
                'event_data_code' => 'EVENT' . $request->data_code,
                'event_data_tittle' => $request->title,
                'event_data_start_date' => $request->start_date,
                'event_data_end_date' => $request->end_date,
                'event_data_reg_deadline' => $request->end_date,
                'event_data_venue' => $request->venue,
                'event_data_address' => $request->address,
                'event_data_city' => $request->city,
                'event_data_status' => 0,
                'event_data_desc' => $request->desc,
                'event_data_cover' => $cover,
                'event_data_template' => 'event/template/' . auth::user()->userid . '/' . $request->link,
                'event_data_user_id' => Auth::user()->userid,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $e) {
            return $e;
        }
    }
    public function menu_event_data_upload_template(Request $request)
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
            $path = $disk->putFileAs('public/event/template/' . auth::user()->userid, $file, $fileName);
            // $path1 = $disk('videos', $file, $fileName);

            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => Storage::url('/event/template/' . auth::user()->userid . '/' . $fileName),
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
    public function menu_event_data_upload_cover(Request $request)
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
            $path = $disk->putFileAs('public/event/cover/' . auth::user()->userid, $file, $fileName);
            // $path1 = $disk('videos', $file, $fileName);

            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => Storage::url('/event/cover/' . auth::user()->userid . '/' . $fileName),
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
    public function menu_event_data($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = EventModel::latest()->get();

            return view('app-event.menu-event.data-event', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_event_data_add_sub_event(Request $request)
    {
        return view('app-event.menu-event.data-event.form-add-sub-event', ['code' => $request->code]);
    }
    public function menu_event_data_save_sub_event(Request $request)
    {
        try {
            $total = SubEventModel::where('event_data_code', $request->data_code)->count();
            $total = $total + 1;
            SubEventModel::insert([
                'event_data_sub_code' => $request->data_code . '' . str_pad($total, 3, '0', STR_PAD_LEFT),
                'event_data_code' => $request->data_code,
                'event_data_sub_name' => $request->name,
                'event_data_sub_start' => $request->start,
                'event_data_sub_end' => $request->end,
                'created_at' => now()
            ]);
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public function menu_event_data_detail_event(Request $request)
    {
        $data = EventModel::where('event_data_code', $request->code)->first();
        $sub_event = SubEventModel::where('event_data_code', $request->code)->get();
        return view('app-event.menu-event.data-event.form-detail-event', ['code' => $request->code], compact('data', 'sub_event'));
    }
    public function menu_event_data_detail_event_add_type(Request $request)
    {
        $data = DB::table('event_data_sub_class')->where('event_data_sub_code', $request->code)->get();
        $session = DB::table('event_data_sub_session')->where('event_data_sub_code', $request->code)->get();
        return view('app-event.menu-event.data-event.form-add-type-peserta', ['code' => $request->code], compact('data', 'session'));
    }
    public function menu_event_data_detail_event_save_class(Request $request)
    {
        try {
            DB::table('event_data_sub_class')->insert([
                'event_data_sub_class_code' => Str::uuid(),
                'event_data_sub_code' => $request->code_event,
                'event_data_sub_class_name' => $request->nama_class,
                'event_data_sub_class_room' => $request->nama_room,
                'event_data_sub_class_price' => $request->class_price,
                'event_data_sub_class_type' => $request->class_type,
                'event_data_sub_class_kuota' => 0,
                'event_data_sub_class_status' => 1,
                'created_at' => now(),
            ]);
            $data = DB::table('event_data_sub_class')->where('event_data_sub_code', $request->code_event)->get();
            return view('app-event.menu-event.data-event.data-table-event-class', compact('data'));
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function menu_event_data_detail_event_save_session(Request $request)
    {
        try {
            DB::table('event_data_sub_session')->insert([
                'event_data_sub_session_code' => Str::uuid(),
                'event_data_sub_code' => $request->code_event,
                'event_data_sub_session_name' => $request->nama_session,
            ]);
            $data = DB::table('event_data_sub_session')->where('event_data_sub_code', $request->code_event)->get();
            return view('app-event.menu-event.data-event.data-table-event-session', compact('data'));
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function menu_event_data_form_registrasi_event(Request $request)
    {
        $data = EventModel::where('event_data_code', $request->code)->first();
        $event_sub = DB::table('event_data_sub')->where('event_data_code', $request->code)->get();
        return view('app-event.menu-event.data-event.form-registrasi-event', compact('data', 'event_sub'));
    }
    public function menu_event_data_form_registrasi_event_detail_sub_event(Request $request)
    {
        $data = DB::table('event_data_sub_class')->where('event_data_sub_code', $request->code)->get();
        $session = DB::table('event_data_sub_session')->where('event_data_sub_code', $request->code)->get();
        return view('app-event.menu-event.data-event.data-table-sub-event-detail', compact('data', 'session'));
    }
    public function menu_event_data_form_registrasi_event_detail_sub_event_add_peserta(Request $request)
    {
        return view('app-event.menu-event.data-event.form-event.form-sub-event-add-peserta');
    }
    public function menu_event_data_form_self_registrasi($kode)
    {
        return view('app-event.menu-event.data-event.form-self-resgistrasi');
    }

    public function menu_event_data_form_registrasi_event_test_print(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'nama_produk' => 'required|string|max:50',
            'sku'         => 'required|string|max:20',
            'harga'       => 'required|numeric',
        ]);

        // 2. Desain Label Menggunakan Bahasa ZPL (Zebra Programming Language)
        $zplCode = "^XA";
        $zplCode .= "^CI28"; // Mendukung UTF-8

        // --- PENGATURAN UKURAN KERTAS (5x3 cm @203 DPI) ---
        $width = 400;  // Lebar total label (400 dots)
        $zplCode .= "^PW" . $width;
        $zplCode .= "^LL240"; // Tinggi total label (240 dots)
        $zplCode .= "^LS0";

        // ============================================================
        // 1. NAMA PRODUK (CENTER + AUTO WRAP)
        // ============================================================
        // Perubahan: fungsi substr() dihapus agar teks panjang tidak terpotong di PHP.
        // Parameter ^FB diubah menjadi: 400 (lebar), 2 (maksimal 2 baris), 0 (spasi), C (Center)
        // Ukuran font diturunkan sedikit ke 20,20 agar muat jika menjadi 2 baris.
        $zplCode .= "^FO0,25^FB400,2,0,C^A0N,22,22^FD" . $request->nama_produk . "^FS";

        // ============================================================
        // 2. NAMA EVENT / HARGA (CENTER + AUTO WRAP)
        // ============================================================
        // Koordinat Y digeser agak ke bawah (Y=80) memberikan ruang jika Nama Produk di atas menjadi 2 baris.
        // Menggunakan cara yang sama (^FB 400, 2, 0, C) agar tulisan panjang otomatis ke bawah dan tetap center.
        $zplCode .= "^FO0,80^FB400,2,0,C^A0N,22,22^FD" . $request->nama_event . "^FS";

        // ============================================================
        // 3. BARCODE CODE 128 (CENTER MANUAL)
        // ============================================================
        $skuLength = strlen($request->sku);
        $barcodeWidth = ($skuLength * 11 * 2) + 50;

        // Hitung koordinat X agar posisi barcode pas di tengah kertas
        $barcodeX = ($width - $barcodeWidth) / 2;

        // Jika hasil perhitungan minus atau terlalu kecil, kunci di batas aman
        if ($barcodeX < 20) {
            $barcodeX = 20;
        }

        // Koordinat Y barcode diturunkan sedikit ke Y=140 agar aman dari teks di atasnya yang mungkin memanjang.
        $zplCode .= "^FO" . $barcodeX . ",140^BY2^BCN,60,Y,N,N^FD" . $request->sku . "^FS";

        $zplCode .= "^XZ";


        // 3. Eksekusi cetak
        $printResult = $this->printerService->sendToPrinter($zplCode);

        // 4. Kembalikan respons ke halaman sebelumnya
        if ($printResult['status']) {
            return redirect()->back()->with('success', $printResult['message']);
        } else {
            return redirect()->back()->with('error', $printResult['message'])->withInput();
        }
    }
}
