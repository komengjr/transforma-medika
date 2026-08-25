<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Mail\ParticipantTicketMail;
use App\Mail\SendRegistrationTokenMail;
use App\Models\Event\EventModel;
use App\Models\Event\EventRegistration;
use App\Models\Event\Participant;
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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
    //DATA EVENT
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
        // Validasi input wajib
        if (!$request->nama_class || !$request->code_event) {
            return '0';
        }

        try {
            // Membersihkan format harga (misal dari "150.000" atau "Rp 150.000" menjadi 150000)
            $cleanPrice = (int) preg_replace('/[^0-9]/', '', $request->class_price ?? '0');

            DB::table('event_data_sub_class')->insert([
                'event_data_sub_class_code'   => (string) Str::uuid(),
                'event_data_sub_code'         => $request->code_event,
                'event_data_sub_class_name'   => $request->nama_class,
                'event_data_sub_class_room'   => $request->nama_room ?? '-',
                'event_data_sub_class_price'  => $cleanPrice,
                'event_data_sub_class_type'   => $request->class_type ?? 'default',
                'event_data_sub_class_kuota'  => 0,
                'event_data_sub_class_status' => 1,
                'created_at'                  => now(),
                'updated_at'                  => now(),
            ]);

            // Query ulang data berdasarkan event_data_sub_code
            $data = DB::table('event_data_sub_class')
                ->where('event_data_sub_code', $request->code_event)
                ->get();

            return view('app-event.menu-event.data-event.data-table-event-class', compact('data'));
        } catch (\Throwable $e) {
            // Cek file storage/logs/laravel.log jika terjadi error database
            Log::error('Error Save Sub Class: ' . $e->getMessage());
            return '0';
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
        $event = DB::table('event_data')
            ->where('event_data_code', $kode)
            ->first();

        if (!$event) {
            abort(404, 'Event tidak ditemukan');
        }

        // 2. Ambil data sub event berdasarkan event_data_code
        $sub_events = DB::table('event_data_sub')
            ->where('event_data_code', $event->event_data_code)
            ->orderBy('event_data_sub_start', 'asc')
            ->get();

        return view('app-event.menu-event.data-event.form-self-resgistrasi', compact('event', 'sub_events'), ['kode' => $kode]);
    }
    public function menu_event_data_form_registrasi_event_detail_sub_event_data_peserta(Request $request)
    {
        $subEventId = $request->sub_event_id;

        // Mengambil peserta berdasarkan relasi ke sub event / class
        $participants = DB::table('event_participants')
            ->join('event_registrations', 'event_participants.id_participant', '=', 'event_registrations.id_participant')
            ->join('event_registration_classes', 'event_registrations.id_registration', '=', 'event_registration_classes.id_registration')
            ->where('event_registration_classes.id_event_data_sub_class', $subEventId)
            ->select(
                'event_participants.*',
                'event_registrations.id_registration',
                'event_registrations.payment_status',
                'event_registrations.registration_status',
                'event_registration_classes.qr_code_token',
                'event_registration_classes.created_at as register_date'
            )
            ->get();

        return view('app-event.menu-event.data-event.sub_event_participants_table', compact('participants'))->render();
    }
    public function menu_event_data_form_registrasi_sub_event_data_peserta_edit($id)
    {
        // Mengambil data registrasi beserta data peserta dan sub-classnya
        $registration = DB::table('event_registrations')
            ->join('event_participants', 'event_registrations.id_participant', '=', 'event_participants.id_participant')
            ->leftJoin('event_registration_classes', 'event_registrations.id_registration', '=', 'event_registration_classes.id_registration')
            ->where('event_registrations.id_registration', $id)
            ->select(
                'event_registrations.*',
                'event_participants.full_name',
                'event_participants.email',
                'event_participants.phone_number',
                'event_participants.institution',
                'event_registration_classes.qr_code_token'
            )
            ->first();

        if (!$registration) {
            return redirect()->back()->with('error', 'Data registrasi tidak ditemukan.');
        }
        return view('app-event.menu-event.data-event.edit_registration', compact('registration'));
    }
    public function menu_event_data_form_registrasi_sub_event_data_peserta_update(Request $request, $id)
    {
        $request->validate([
            'payment_status'      => 'required|in:pending,paid,failed,cancelled',
            'registration_status' => 'required|in:active,cancelled',
            'full_name'           => 'required|string|max:255',
            'email'               => 'required|email',
            'phone_number'        => 'required|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            // 1. Ambil data registrasi
            $registration = DB::table('event_registrations')->where('id_registration', $id)->first();

            if (!$registration) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            // 2. Update data peserta
            DB::table('event_participants')
                ->where('id_participant', $registration->id_participant)
                ->update([
                    'full_name'    => $request->full_name,
                    'email'        => $request->email,
                    'phone_number' => $request->phone_number,
                    'institution'  => $request->institution,
                    'updated_at'   => now(),
                ]);

            // 3. Update status registrasi dan pembayaran
            DB::table('event_registrations')
                ->where('id_registration', $id)
                ->update([
                    'payment_status'      => $request->payment_status,
                    'registration_status' => $request->registration_status,
                    'updated_at'          => now(),
                ]);

            DB::commit();

            return redirect()->back()->with('success', 'Data pendaftaran berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }
    public function menu_event_data_form_registrasi_sub_event_data_peserta_remove($id)
    {
        try {
            // 1. Cari data peserta
            $registration = EventRegistration::find($id);

            if (!$registration) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Data peserta tidak ditemukan atau sudah dihapus.'
                ], 404);
            }

            // 2. Hapus berkas pendukung jika ada (Contoh: Bukti Pembayaran / QR Code)
            // if ($registration->payment_proof && \Storage::exists($registration->payment_proof)) {
            //     \Storage::delete($registration->payment_proof);
            // }

            // 3. Hapus data dari Database
            $registration->delete();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data peserta berhasil dihapus dari sistem.'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menghapus data peserta: ' . $e->getMessage()
            ], 500);
        }
    }
    public function menu_event_data_form_registrasi_sub_event_data_peserta_verify_payment(Request $request, $id)
    {
        try {
            // Cari data pendaftaran berdasarkan ID Registration
            $registration = EventRegistration::findOrFail($id);

            // Update status pembayaran menjadi 'paid'
            $registration->payment_status = 'paid';

            // Jika ada field waktu pelunasan di database Anda (Opsional):
            // $registration->paid_at = now();

            $registration->save();

            // Kembalikan response JSON untuk SweetAlert / AJAX
            return response()->json([
                'status'  => 'success',
                'message' => 'Pembayaran untuk peserta ' . ($registration->full_name ?? '') . ' telah berhasil diverifikasi dan diverifikasi LUNAS!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal memverifikasi pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }
    public function menu_event_data_form_registrasi_sub_event_data_peserta_send_email($id)
    {
        try {
            $registration = DB::table('event_registrations as er')
                ->join('event_participants as ep', 'er.id_participant', '=', 'ep.id_participant')
                ->leftJoin('event_registration_classes as erc', 'er.id_registration', '=', 'erc.id_registration')
                ->leftJoin('event_data_sub_class as esc', 'erc.id_event_data_sub_class', '=', 'esc.id_event_data_sub_class')
                ->where('er.id_registration', $id)
                ->select(
                    'er.id_registration',
                    'er.payment_status',
                    'erc.qr_code_token',
                    'ep.full_name',
                    'ep.email',
                    'ep.institution',
                    'ep.phone_number',
                    'esc.event_data_sub_class_name'
                )
                ->first();

            if (!$registration || !$registration->email) {
                return response()->json(['message' => 'Email peserta tidak ditemukan.'], 400);
            }

            // 4. Eksekusi Pengiriman Email
            Mail::to($registration->email)->send(new ParticipantTicketMail($registration));

            return response()->json([
                'status'  => 'success',
                'message' => 'Kode booking berhasil dikirim ke email ' . $registration->email
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengirim email: ' . $e->getMessage()
            ], 500);
        }
    }
    public function menu_event_data_form_registrasi_event_cek_booking(Request $request)
    {
        // 1. Validasi Input Data
        $request->validate([
            'token' => 'required|string',
            'code'  => 'required|string'
        ]);

        $token = trim($request->input('token'));
        $code  = trim($request->input('code'));

        try {
            // 2. Query Relasi untuk Mencari Peserta berdasarkan Token & Kode Event
            $participantData = DB::table('event_registration_classes as erc')
                ->join('event_registrations as er', 'erc.id_registration', '=', 'er.id_registration')
                ->join('event_participants as ep', 'er.id_participant', '=', 'ep.id_participant')
                ->join('event_data as ed', 'er.id_event_data', '=', 'ed.id_event_data')
                ->leftJoin('event_data_sub_class as esc', 'erc.id_event_data_sub_class', '=', 'esc.id_event_data_sub_class')
                ->select(
                    'erc.id_registration_class',
                    'erc.qr_code_token',
                    'erc.attendance_status',
                    'erc.check_in_at',
                    'er.id_registration',
                    'er.registration_code',
                    'er.payment_status',
                    'ed.id_event_data',
                    'ed.event_data_code',
                    'ed.event_data_tittle',
                    'ep.full_name',
                    'ep.phone_number',
                    'ep.email',
                    'ep.institution', // Ditambahkan jika butuh data instansi
                    'esc.event_data_sub_class_name'
                )
                ->where('erc.qr_code_token', $token)
                ->where('ed.event_data_code', $code) // Filter ketat berdasarkan Kode Event
                ->first();

            // 3. Jika Data Tidak Ditemukan
            if (!$participantData) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Kode QR / Tiket tidak ditemukan atau tidak terdaftar pada event ini!'
                ], 404);
            }

            // 4. Update Status Presensi jika Belum Check-in
            if ($participantData->attendance_status !== 'present') {
                DB::table('event_registration_classes')
                    ->where('id_registration_class', $participantData->id_registration_class)
                    ->update([
                        'attendance_status' => 'present',
                        'check_in_at'       => now(),
                        'updated_at'        => now()
                    ]);

                $participantData->attendance_status = 'present';
            }

            // 5. Return Response JSON Success
            return response()->json([
                'status' => 'success',
                'data'   => [
                    'id_registration_class' => $participantData->id_registration_class,
                    'id_event'              => $participantData->id_event_data,
                    'event_name'            => $participantData->event_data_tittle ?? 'Event Falcon',
                    'registration_code'     => $participantData->registration_code,
                    'qr_code_token'         => $participantData->qr_code_token,
                    'full_name'             => $participantData->full_name,
                    'institution'           => $participantData->institution ?? '-',
                    'phone_number'          => $participantData->phone_number ?? '-',
                    'email'                 => $participantData->email,
                    'class_name'            => $participantData->event_data_sub_class_name ?? 'Reguler',
                    'payment_status'        => ucfirst($participantData->payment_status),
                    'attendance_status'     => ucfirst($participantData->attendance_status),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
    public function menu_event_data_form_registrasi_event_test_print(Request $request)
    {
        // 1. Validasi Input Form Sesuai Parameter
        $request->validate([
            'nama_peserta'      => 'required|string|max:100',
            'nama_event'        => 'required|string|max:100',
            'id_event'          => 'required|string|max:50',
            'kode_booking'      => 'required|string|max:50',
            'registration_code' => 'required|string|max:50',
            'class_name'        => 'required|string|max:50',
        ]);

        // 2. Desain Label Menggunakan Bahasa ZPL (Zebra Programming Language)
        $zplCode = "^XA";
        $zplCode .= "^CI28"; // Support UTF-8

        // --- PENGATURAN UKURAN KERTAS (5x3 cm @203 DPI) ---
        $width = 400;  // Lebar label (400 dots)
        $zplCode .= "^PW" . $width;
        $zplCode .= "^LL240"; // Tinggi label (240 dots)
        $zplCode .= "^LS0";

        // 1. NAMA PESERTA (Padding 4mm -> Y = 47, Max 2 Baris)
        $zplCode .= "^FO0,47^FB400,2,0,C^A0N,22,22^FD" . $request->nama_peserta . "^FS";

        // 2. KELAS / KATEGORI
        $zplCode .= "^FO0,92^FB400,1,0,C^A0N,18,18^FD[" . $request->class_name . "]^FS";

        // 3. NAMA EVENT & ID EVENT
        $eventInfo = $request->nama_event . " (ID: " . $request->id_event . ")";
        $zplCode .= "^FO0,113^FB400,2,0,C^A0N,16,16^FD" . $eventInfo . "^FS";

        // --- PENGATURAN KETEBALAN & TINGGI BARCODE ---
        $zplCode .= "^BY2,3,50"; // Tinggi barcode disesuaikan 50 dots agar tidak terpotong

        // 4. BARCODE GARIS 1D (Code 128) RATA TENGAH
        $zplCode .= "^FT0,205^FB400,1,0,C^BCN,50,Y,N,N^FD" . $request->registration_code . "^FS";

        $zplCode .= "^XZ";

        // 3. Kembalikan ZPL ke Client Javascript
        if ($request->ajax()) {
            return response()->json([
                'status'  => true,
                'message' => 'ZPL berhasil di-generate oleh server.',
                'zpl'     => $zplCode
            ]);
        }

        return redirect()->back()->with('success', 'ZPL berhasil di-generate.');
    }
    //DATA EVENT
    public function menu_event_daftar($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            // Memuat data event beserta sub dan class-nya sekaligus agar ringan saat dirender
            $data = DB::table('event_data')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('app-event.menu-event.daftar-event', [
                'akses' => $akses,
                'code' => $id,
                'data' => $data
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function menu_event_daftar_get_detail($code)
    {
        $event = DB::table('event_data')
            ->where('event_data_code', $code)
            ->first();

        if ($event) {
            return response()->json([
                'status' => 'success',
                'data'   => $event
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'Data event tidak ditemukan.'
        ], 404);
    }

    // Fetch Sub Event / Session
    public function menu_event_daftar_get_session($code)
    {
        $sessions = DB::table('event_data_sub_session as sess')
            ->join('event_data_sub as sub', 'sess.event_data_sub_code', '=', 'sub.event_data_sub_code')
            ->where('sub.event_data_code', $code)
            ->select(
                'sess.id_event_data_sub_session',
                'sess.event_data_sub_session_code',
                'sess.event_data_sub_session_name',
                'sub.event_data_sub_code',
                'sub.event_data_sub_name',
                'sub.event_data_sub_start',
                'sub.event_data_sub_end'
            )
            ->orderBy('sub.event_data_sub_start', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $sessions
        ]);
    }

    // Fetch Peserta Event
    public function menu_event_daftar_get_peserta($code)
    {
        // 1. Ambil data peserta beserta detail pendaftaran
        $peserta = DB::table('event_registrations as er')
            ->join('event_participants as ep', 'er.id_participant', '=', 'ep.id_participant')
            ->join('event_data as ed', 'er.id_event_data', '=', 'ed.id_event_data')
            ->leftJoin('event_registration_classes as erc', 'er.id_registration', '=', 'erc.id_registration')
            ->leftJoin('event_data_sub_class as edsc', 'erc.id_event_data_sub_class', '=', 'edsc.id_event_data_sub_class')
            ->leftJoin('event_data_sub as eds', 'edsc.event_data_sub_code', '=', 'eds.event_data_sub_code')
            ->where('ed.event_data_code', $code)
            ->select(
                'er.id_registration',
                'er.registration_code',
                'er.payment_status',
                'er.registration_status',
                'er.registration_date',
                'ep.full_name',
                'ep.email',
                'ep.phone_number',
                'ep.institution',
                'eds.event_data_sub_code',
                'eds.event_data_sub_name',
                'edsc.id_event_data_sub_class',
                'edsc.event_data_sub_class_name',
                'edsc.event_data_sub_class_room',
                'erc.qr_code_token',
                'erc.attendance_status'
            )
            ->orderBy('er.registration_date', 'desc')
            ->get();

        // 2. Ambil master Sub Event & Class untuk opsi dropdown Filter
        $subEvents = DB::table('event_data_sub')
            ->where('event_data_code', $code)
            ->select('event_data_sub_code', 'event_data_sub_name')
            ->get();

        $classes = DB::table('event_data_sub_class as edsc')
            ->join('event_data_sub as eds', 'edsc.event_data_sub_code', '=', 'eds.event_data_sub_code')
            ->where('eds.event_data_code', $code)
            ->select('edsc.id_event_data_sub_class', 'edsc.event_data_sub_class_name', 'edsc.event_data_sub_code')
            ->get();

        return response()->json([
            'status'     => 'success',
            'data'       => $peserta,
            'sub_events' => $subEvents,
            'classes'    => $classes
        ]);
    }
    // MASTER PENGIRIMAN EMAIL
    public function master_event_pengiriman_email($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $events = DB::table('event_data')
                ->select('id_event_data', 'event_data_code', 'event_data_tittle', 'event_data_start_date', 'event_data_venue', 'event_data_city')
                ->orderBy('event_data_start_date', 'desc')
                ->get();

            // return view('pages.event.email_broadcast', compact('events', 'selectedEvent', 'selectedEventId'));
            return view('app-event.menu-event.master-event.pengiriman-email', compact('events'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function getSubEvents($eventId)
    {
        $event = DB::table('event_data')->where('id_event_data', $eventId)->first();

        if (!$event) {
            return response()->json([]);
        }

        $subEvents = DB::table('event_data_sub')
            ->where('event_data_code', $event->event_data_code)
            ->select('id_event_data_sub', 'event_data_sub_code', 'event_data_sub_name')
            ->get();

        return response()->json($subEvents);
    }

    /**
     * AJAX: Ambil Kelas berdasarkan Sub Event Code
     */
    public function getClasses($subCode)
    {
        $classes = DB::table('event_data_sub_class')
            ->where('event_data_sub_code', $subCode)
            ->select('id_event_data_sub_class', 'event_data_sub_class_code', 'event_data_sub_class_name')
            ->get();

        return response()->json($classes);
    }

    /**
     * AJAX: Ambil Daftar Peserta berdasarkan Filter Sub Event / Kelas
     */
    public function getParticipants(Request $request)
    {
        $subCode = $request->input('sub_code');
        $classId = $request->input('class_id');

        $query = DB::table('event_registrations as er')
            ->join('event_participants as ep', 'er.id_participant', '=', 'ep.id_participant')
            ->leftJoin('event_registration_classes as erc', 'er.id_registration', '=', 'erc.id_registration')
            ->leftJoin('event_data_sub_class as esc', 'erc.id_event_data_sub_class', '=', 'esc.id_event_data_sub_class')
            ->select(
                'er.id_registration',
                'er.payment_status',
                'er.email_sent_at',
                'er.wa_sent_at',
                'erc.qr_code_token',
                'erc.id_event_data_sub_class',
                'ep.full_name',
                'ep.full_name as name', // <-- Tambahkan alias ini
                'ep.institution',
                'ep.email',
                'ep.phone_number',
                'esc.event_data_sub_class_name'
            )
            ->where('esc.event_data_sub_code', $subCode);

        // Filter berdasarkan kelas spesifik jika ada
        if (!empty($classId)) {
            $query->where('erc.id_event_data_sub_class', $classId);
        }

        $participants = $query->get();

        return response()->json($participants);
    }
    // 2. Kirim Email Satuan
    public function sendEmailSingle($idRegistration)
    {
        $registration = DB::table('event_registrations as er')
            ->join('event_participants as ep', 'er.id_participant', '=', 'ep.id_participant')
            ->leftJoin('event_registration_classes as erc', 'er.id_registration', '=', 'erc.id_registration')
            ->leftJoin('event_data_sub_class as esc', 'erc.id_event_data_sub_class', '=', 'esc.id_event_data_sub_class')
            ->where('er.id_registration', $idRegistration)
            ->select(
                'er.id_registration',
                'er.payment_status',
                'erc.qr_code_token',
                'ep.full_name',
                'ep.email',
                'ep.institution',
                'ep.phone_number',
                'esc.event_data_sub_class_name'
            )
            ->first();

        if (!$registration || !$registration->email) {
            return response()->json(['message' => 'Email peserta tidak ditemukan.'], 400);
        }

        try {
            Mail::to($registration->email)->send(new ParticipantTicketMail($registration));

            // Update timestamp email_sent_at
            DB::table('event_registrations')
                ->where('id_registration', $idRegistration)
                ->update(['email_sent_at' => now()]);

            return response()->json(['message' => 'Email tiket berhasil dikirim ke ' . $registration->full_name]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengirim email: ' . $e->getMessage()], 500);
        }
    }

    // 3. Kirim Email Massal / Bulk
    public function sendEmailBulk(Request $request)
    {
        $targetIds = $request->input('target_ids', []);

        if (empty($targetIds)) {
            return response()->json(['message' => 'Tidak ada peserta yang dipilih.'], 400);
        }

        $successCount = 0;
        $failedCount = 0;

        foreach ($targetIds as $idRegistration) {
            try {
                $registration = DB::table('event_registrations as er')
                    ->join('event_participants as ep', 'er.id_participant', '=', 'ep.id_participant')
                    ->leftJoin('event_registration_classes as erc', 'er.id_registration', '=', 'erc.id_registration')
                    ->where('er.id_registration', $idRegistration)
                    ->select('er.*', 'erc.qr_code_token', 'ep.email', 'ep.full_name')
                    ->first();

                if ($registration && $registration->email) {
                    Mail::to($registration->email)->send(new ParticipantTicketMail($registration));

                    DB::table('event_registrations')
                        ->where('id_registration', $idRegistration)
                        ->update(['email_sent_at' => now()]);

                    $successCount++;
                } else {
                    $failedCount++;
                }
            } catch (\Exception $e) {
                $failedCount++;
            }
        }

        return response()->json([
            'message' => "Pengiriman selesai. Berhasil: {$successCount}, Gagal: {$failedCount}"
        ]);
    }
    // MASTER PENGIRIMAN WHATSAPP
    public function master_event_pengiriman_whatsapp($akses, $id)
    {
        if ($this->url_akses_sub($akses, $id) == true) {
            $events = DB::table('event_data')
                ->select('id_event_data', 'event_data_code', 'event_data_tittle', 'event_data_start_date', 'event_data_venue', 'event_data_city')
                ->orderBy('event_data_start_date', 'desc')
                ->get();

            // return view('pages.event.email_broadcast', compact('events', 'selectedEvent', 'selectedEventId'));
            return view('app-event.menu-event.master-event.pengiriman-whatsapp', compact('events'), ['akses' => $akses, 'code' => $id]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }

    public function sendWaSingle($idRegistration)
    {
        $registration = DB::table('event_registrations as er')
            ->join('event_participants as ep', 'er.id_participant', '=', 'ep.id_participant')
            ->leftJoin('event_registration_classes as erc', 'er.id_registration', '=', 'erc.id_registration')
            ->leftJoin('event_data_sub_class as esc', 'erc.id_event_data_sub_class', '=', 'esc.id_event_data_sub_class')
            ->where('er.id_registration', $idRegistration)
            ->select(
                'er.id_registration',
                'er.payment_status',
                'erc.qr_code_token',
                'ep.full_name',
                'ep.email',
                'ep.institution',
                'ep.phone_number',
                'esc.event_data_sub_class_name'
            )
            ->first();

        if (!$registration || !$registration->phone_number) {
            return response()->json(['message' => 'Nomor WhatsApp peserta tidak ditemukan.'], 400);
        }

        try {
            // Fungsi pembantu kirim WA ke Gateway
            $this->sendWaGateway($registration);

            // Update timestamp wa_sent_at
            DB::table('event_registrations')
                ->where('id_registration', $idRegistration)
                ->update(['wa_sent_at' => now()]);

            return response()->json(['message' => 'WhatsApp tiket berhasil dikirim ke ' . $registration->full_name]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengirim WhatsApp: ' . $e->getMessage()], 500);
        }
    }
    // 2. Kirim WhatsApp Massal / Bulk
    public function sendWaBulk(Request $request)
    {
        $targetIds = $request->input('target_ids', []);

        if (empty($targetIds)) {
            return response()->json(['message' => 'Tidak ada peserta yang dipilih.'], 400);
        }

        $successCount = 0;
        $failedCount = 0;

        foreach ($targetIds as $idRegistration) {
            try {
                $registration = DB::table('event_registrations as er')
                    ->join('event_participants as ep', 'er.id_participant', '=', 'ep.id_participant')
                    ->leftJoin('event_registration_classes as erc', 'er.id_registration', '=', 'erc.id_registration')
                    ->leftJoin('event_data_sub_class as esc', 'erc.id_event_data_sub_class', '=', 'esc.id_event_data_sub_class')
                    ->where('er.id_registration', $idRegistration)
                    ->select(
                        'er.id_registration',
                        'er.payment_status',
                        'erc.qr_code_token',
                        'ep.full_name',
                        'ep.email',
                        'ep.institution',
                        'ep.phone_number',
                        'esc.event_data_sub_class_name'
                    )
                    ->first();

                if ($registration && $registration->phone_number) {
                    $this->sendWaGateway($registration);

                    DB::table('event_registrations')
                        ->where('id_registration', $idRegistration)
                        ->update(['wa_sent_at' => now()]);

                    $successCount++;
                } else {
                    $failedCount++;
                }
            } catch (\Exception $e) {
                $failedCount++;
            }
        }

        return response()->json([
            'message' => "Pengiriman selesai. Berhasil: {$successCount}, Gagal: {$failedCount}"
        ]);
    }

    /**
     * Helper Function untuk Pengiriman via WA Gateway
     */
    private function sendWaGateway($registration)
    {
        $phone = preg_replace('/[^0-9]/', '', $registration->phone_number);
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        $message = "*E-TICKET EVENT PESERTA*\n\n";
        $message .= "Halo *{$registration->full_name}*,\n";
        $message .= "Berikut adalah rincian tiket Anda:\n\n";
        $message .= "• *QR Token:* {$registration->qr_code_token}\n";
        $message .= "• *Kelas:* " . ($registration->event_data_sub_class_name ?? '-') . "\n\n";
        $message .= "Terima kasih!";

        // Link Gambar QR Code Publik (Langsung menghasilkan PNG)
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($registration->qr_code_token);

        $token = trim(env('WA_GATEWAY_TOKEN', 'CJnxqZ4tb2LLwgxzmnWq'));

        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target'      => $phone,
            'message'     => $message,
            'url'         => $qrUrl, // Mengirim link gambar publik ke Fonnte
            'countryCode' => '62',
        ]);

        $result = $response->json();
        if (isset($result['status']) && $result['status'] === false) {
            throw new \Exception('Fonnte Gagal Kirim: ' . ($result['reason'] ?? 'Error tidak diketahui'));
        }

        return true;
    }
}
