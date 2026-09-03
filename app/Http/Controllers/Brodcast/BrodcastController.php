<?php

namespace App\Http\Controllers\Brodcast;

use App\Http\Controllers\Controller;
use App\Imports\Brodcast\ContactImport;
use App\Imports\PesertaEventImport;
use App\Jobs\SendBroadcastEmailJob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Maatwebsite\Excel\Facades\Excel;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Svg\Tag\Rect;
use Midtrans\Config;
use Midtrans\Snap;

class BrodcastController extends Controller
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
    // BRODCAST WHATSAPP
    public function menu_brodcast_whatsapp($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('log_schedule_product')->orderBy('id_schedule_product', 'DESC')->get();
            return view('app-brodcast.menu.brodcast-whatsapp', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_brodcast_whatsapp_upload_file(Request $request)
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
            $path = $disk->putFileAs('public/brodcast/data-send/' . auth::user()->access_cabang, $file, $fileName);
            // $path1 = $disk('videos', $file, $fileName);
            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => Storage::url('brodcast/data-send/' . auth::user()->access_cabang . '/' . $fileName),
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
    public function menu_brodcast_whatsapp_remove_file(Request $request)
    {
        Storage::delete('public/brodcast/data-send/' . auth::user()->access_cabang . '/' . $request->link);
        return 'ok';
    }
    public function menu_brodcast_whatsapp_send(Request $request)
    {
        if ($request->link == "") {
            $gambar = 0;
        } else {
            $filegambar = storage_path('app/public/brodcast/data-send/' . Auth::user()->access_cabang . '/' . $request->link);
            $img = file_get_contents($filegambar);
            $gambar = base64_encode($img);
        }
        if ($request->tipe_pengiriman == 'personal') {
            $nomorhp = $request->number;
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
            $text = "Halo " . $request->subject . "\n\n" . $request->text . "\n\nˢᵘᵖᵖᵒʳᵗ ᴮʸ.ᴵⁿⁿᵒᵛᵉⁿᵗʳᵃ";
            DB::table('v_log_whatsapp')->insert([
                'v_log_whatsapp_code' => str::uuid(),
                'd_reg_order_list_code' => str::uuid(),
                'v_log_whatsapp_number' => $nomorhp,
                'v_log_whatsapp_name' => 'Anonymous',
                'v_log_whatsapp_filename' => $request->subject,
                'v_log_whatsapp_text' => $text,
                'v_log_whatsapp_file' => 'N',
                'v_log_whatsapp_picture' => $gambar,
                'v_log_whatsapp_status' => 0,
                'v_log_whatsapp_date' => now(),
                'v_log_whatsapp_pass' => mt_rand(10000, 90000),
                'v_log_whatsapp_user' => Auth::user()->userid,
                'created_at' => now()
            ]);
        } elseif ($request->tipe_pengiriman == 'all') {
            $contact = DB::table('b_master_contact')->where('b_master_contact_cabang', Auth::user()->access_cabang)->get();
            foreach ($contact as $value) {
                $nomorhp = $value->b_master_contact_whatsapp;
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
                $text = "Halo *Bapak / Ibu* \n" . $request->subject . "\n\n" . $request->text . "\n\nˢᵘᵖᵖᵒʳᵗ ᴮʸ.ᴵⁿⁿᵒᵛᵉⁿᵗʳᵃ";
                DB::table('v_log_whatsapp')->insert([
                    'v_log_whatsapp_code' => str::uuid(),
                    'd_reg_order_list_code' => str::uuid(),
                    'v_log_whatsapp_number' => $nomorhp,
                    'v_log_whatsapp_name' => $value->b_master_contact_name,
                    'v_log_whatsapp_filename' => Auth::user()->fullname,
                    'v_log_whatsapp_text' => $text,
                    'v_log_whatsapp_file' => 'N',
                    'v_log_whatsapp_picture' => $gambar,
                    'v_log_whatsapp_status' => 0,
                    'v_log_whatsapp_date' => now(),
                    'v_log_whatsapp_pass' => mt_rand(10000, 90000),
                    'v_log_whatsapp_user' => Auth::user()->userid,
                    'created_at' => now()
                ]);
            }
        }

        return 123;
    }
    // BRODCAST WHATSAPP
    public function menu_brodcast_management($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('b_event')->orderBy('id_b_event', 'DESC')->get();
            return view('app-brodcast.menu.brodcast-management', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_brodcast_management_add(Request $request)
    {
        return view('app-brodcast.menu.form.form-add-event');
    }
    public function menu_brodcast_management_save(Request $request)
    {
        try {
            DB::table('b_event')->insert([
                'b_event_code' => str::uuid(),
                'b_event_name' => $request->name,
                'b_event_location' => $request->location,
                'b_event_class' => $request->class,
                'b_event_text' => $request->desc,
                'b_event_date' => $request->date,
                'b_event_status' => 1,
                'created_at' => now()
            ]);
            return 'sukses';
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public function menu_brodcast_management_add_peserta(Request $request)
    {
        return view('app-brodcast.menu.form.form-add-peserta', ['code' => $request->code]);
    }
    public function menu_brodcast_management_save_peserta(Request $request)
    {
        try {
            $event = DB::table('b_event')->where('b_event_code', $request->code_event)->first();
            DB::table('b_event_peserta')->insert([
                'b_event_peserta_code' => str::uuid(),
                'b_event_code' => $request->code_event,
                'b_event_peserta_name' => $request->name,
                'b_event_peserta_booking' => $request->booking,
                'b_event_peserta_class' => $event->b_event_location,
                'b_event_peserta_room' => $event->b_event_class,
                'b_event_peserta_hp' => $request->hp,
                'b_event_peserta_email' => $request->email,
                'b_event_peserta_lembaga' => $request->lembaga,
                'b_event_peserta_desc' => $request->desc,
                'b_event_peserta_status' => 1,
                'created_at' => now(),
            ]);
            return 'sukses';
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function menu_brodcast_management_brodcast_whatsapp(Request $request)
    {
        $data = DB::table('b_event_peserta')->where('b_event_code', $request->code)->get();
        return view('app-brodcast.menu.form.form-brodcast-whatsapp', [
            'data' => $data,
            'code' => $request->code
        ]);
    }
    public function menu_brodcast_management_brodcast_whatsapp_send(Request $request)
    {
        $data = DB::table('b_event_peserta')->where('b_event_code', $request->code)->get();
        $event = DB::table('b_event')->where('b_event_code', $request->code)->first();
        foreach ($data as $datas) {
            if ($datas->b_event_peserta_hp == "") {
                # code...
            } else {
                $cek = DB::table('v_log_whatsapp')->where('d_reg_order_list_code', $datas->b_event_peserta_code)->first();

                if (!$cek) {
                    $nomorhp = $datas->b_event_peserta_hp;
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
                    $text = "Hi *" . $datas->b_event_peserta_name . "* \nSelamat Anda Terdaftar Sebagai Peserta Event : " . $event->b_event_name . " \nLokasi Event : " . $event->b_event_location . "\nRoom : " . $event->b_event_class . "\nTanggal & Jam : " . $event->b_event_date . "\nKode Booking : " . $datas->b_event_peserta_booking . "\n" . $event->b_event_text . "\nˢᵘᵖᵖᵒʳᵗ ᴮʸ.ᴵⁿⁿᵒᵛᵉⁿᵗʳᵃ";
                    $qrcode = base64_encode(QrCode::format('png')
                        ->size(500)
                        ->errorCorrection('H')
                        ->style('round')
                        ->margin(2)
                        ->generate($datas->b_event_peserta_booking));
                    DB::table('v_log_whatsapp')->insert([
                        'v_log_whatsapp_code' => str::uuid(),
                        'd_reg_order_list_code' => $datas->b_event_peserta_code,
                        'v_log_whatsapp_number' => $nomorhp,
                        'v_log_whatsapp_name' => $datas->b_event_peserta_name,
                        'v_log_whatsapp_filename' => 'N',
                        'v_log_whatsapp_text' => $text,
                        'v_log_whatsapp_file' => 'N',
                        'v_log_whatsapp_picture' => $qrcode,
                        'v_log_whatsapp_status' => 0,
                        'v_log_whatsapp_date' => now(),
                        'v_log_whatsapp_pass' => mt_rand(100000, 9999999),
                        'created_at' => now()

                    ]);
                }
            }
        }
        $data = DB::table('b_event_peserta')->where('b_event_code', $request->code)->get();
        return view('app-brodcast.menu.table.table-peserta-event', ['data' => $data]);
    }
    public function menu_brodcast_management_export_excel(Request $request)
    {
        return view('app-brodcast.menu.form.form-export-excel-peserta', ['code' => $request->code]);
    }
    public function menu_brodcast_management_export_excel_start(Request $request)
    {
        Excel::import(new PesertaEventImport($request->code, 454), request()->file('file'));
        return redirect()->back()->withSuccess('Great! Berhasil Menambahkan Data Perusahaan');
    }
    // HISTORY WHATSAPP
    public function menu_brodcast_history_whatsapp($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('v_log_whatsapp')->get();
            return view('app-brodcast.menu.history-whatsapp', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // BRODCAST EMAIL
    public function menu_brodcast_email($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {

            return view('app-brodcast.menu.brodcast-email',  ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    // AJAX Endpoint Search Select2 Kontak (Lazy Load)
    public function get_contacts_ajax(Request $request)
    {
        $search = $request->term;
        $query = DB::table('b_master_contact')
            ->where('b_master_contact_status', '1');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('b_master_contact_name', 'LIKE', "%{$search}%")
                    ->orWhere('b_master_contact_email', 'LIKE', "%{$search}%");
            });
        }

        $contacts = $query->limit(30)->get(['id_b_master_contact as id', 'b_master_contact_name', 'b_master_contact_email']);

        $results = [];
        foreach ($contacts as $c) {
            $results[] = [
                'id'   => $c->id,
                'text' => $c->b_master_contact_name . ' (' . $c->b_master_contact_email . ')'
            ];
        }

        return response()->json(['results' => $results]);
    }

    // Dispatch Job dengan Batch ID unik
    public function menu_brodcast_email_send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject'     => 'required|string|max:255',
            'message'     => 'required|string',
            'attachment'  => 'nullable|file|mimes:pdf,docx,doc,xlsx,xls,jpg,jpeg,png,zip|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validasi gagal.'], 422);
        }

        if ($request->has('select_all') && $request->select_all == '1') {
            $contactIds = DB::table('b_master_contact')
                ->where('b_master_contact_status', 'active')
                ->pluck('id_b_master_contact')
                ->toArray();
        } else {
            if (!$request->has('contact_ids') || empty($request->contact_ids)) {
                return response()->json(['status' => false, 'message' => 'Pilih kontak terlebih dahulu!'], 422);
            }
            $contactIds = $request->contact_ids;
        }

        $filePath = null;
        $fileName = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/attachments', $fileName);
        }

        // Buat Batch ID Unik
        $batchId = uniqid('batch_', true);

        // Jalankan Job
        SendBroadcastEmailJob::dispatch($batchId, $contactIds, $request->subject, $request->message, $filePath, $fileName);

        return response()->json([
            'status'   => true,
            'batch_id' => $batchId,
            'total'    => count($contactIds)
        ]);
    }

    // Endpoint untuk Check Progress Real-time via AJAX
    public function check_progress($batch_id)
    {
        $progress = \Illuminate\Support\Facades\Cache::get("broadcast_progress_{$batch_id}", [
            'processed'  => 0,
            'total'      => 0,
            'percentage' => 0,
            'status'     => 'running'
        ]);

        return response()->json($progress);
    }

    // DataTables Server-Side Processing untuk History Email
    public function get_history_datatables(Request $request)
    {
        $totalData = DB::table('b_email_histories')->count();

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $searchValue = $request->input('search.value');

        $query = DB::table('b_email_histories');

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('recipient_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('recipient_email', 'LIKE', "%{$searchValue}%")
                    ->orWhere('subject', 'LIKE', "%{$searchValue}%");
            });
        }

        $totalFiltered = $query->count();

        $histories = $query->offset($start)
            ->limit($limit)
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [];
        foreach ($histories as $key => $h) {
            $nestedData = [];
            $nestedData['no'] = $start + $key + 1;
            $nestedData['recipient'] = '<strong>' . e($h->recipient_name) . '</strong><br><small class="text-muted">' . e($h->recipient_email) . '</small>';

            $subjectCol = '<div class="fw-semibold">' . e($h->subject) . '</div>';
            if ($h->attachment) {
                $subjectCol .= '<small class="text-primary"><i class="fas fa-paperclip me-1"></i>' . e($h->attachment) . '</small>';
            }
            $nestedData['subject'] = $subjectCol;

            if ($h->status == 'success') {
                $nestedData['status'] = '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Sukses</span>';
            } else {
                $nestedData['status'] = '<span class="badge bg-danger" data-bs-toggle="tooltip" title="' . e($h->error_message) . '"><i class="fas fa-times-circle me-1"></i>Gagal</span>';
            }

            $nestedData['created_at'] = date('d M Y H:i', strtotime($h->created_at));
            $data[] = $nestedData;
        }

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ]);
    }
    // BRODCAST MASTER CONTACT
    public function master_brodcast_contact($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('b_master_contact')->where('b_master_contact_cabang', Auth::user()->access_cabang)->orderBy('id_b_master_contact', 'DESC')->get();

            return view('app-brodcast.master.master-contact', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_brodcast_contact_add(Request $request)
    {
        return view('app-brodcast.master.form.form-add-contact');
    }
    public function master_brodcast_contact_save(Request $request)
    {
        try {
            DB::table('b_master_contact')->insert([
                'b_master_contact_code' => str::uuid(),
                'b_master_contact_name' => $request->name,
                'b_master_contact_email' => $request->email,
                'b_master_contact_whatsapp' => $request->whatsapp,
                'b_master_contact_cabang' => Auth::user()->access_cabang,
                'b_master_contact_status' => 1,
                'created_at' => now()
            ]);
            return 123;
        } catch (\Throwable $e) {
            return 0;
        }
    }
    public function master_brodcast_contact_import(Request $request)
    {
        return view('app-brodcast.master.form.form-import-excel');
    }
    public function master_brodcast_contact_import_save(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'File tidak ditemukan'], 400);
        }
        try {
            Excel::import(new ContactImport, $request->file('file'));
            return 'berhasil';
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    // KONFIGURASI WHATSAPP
    public function master_brodcast_configure_whatsapp($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            $data = DB::table('v_log_whatsapp')->where('v_log_whatsapp_user', Auth::user()->userid)->get();
            return view('app-brodcast.master.configure-whatsapp', ['akses' => $akses, 'code' => $id, 'data' => $data]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function master_brodcast_configure_whatsapp_buy_kuota(Request $request)
    {
        return view('app-brodcast.master.form.form-add-kuota-whatsapp');
    }
    public function master_brodcast_configure_whatsapp_token_payment()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => 100000,
            ],
            'customer_details' => [
                'first_name' => 'Agus',
                'email' => 'agus@example.com',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        // return view('app-brodcast.master.form.form-payment', compact('snapToken'));
        return $snapToken;
    }
    public function master_brodcast_configure_whatsapp_confrim_payment(Request $request)
    {
        return 123;
    }
}
