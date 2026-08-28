<?php

namespace App\Http\Controllers\Event;

use App\Exports\ParticipantTemplateExport;
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
use Maatwebsite\Excel\Facades\Excel;
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
    private function generateRegistrationCode()
    {
        $todayPrefix = 'R' . date('Ymd');
        $lastRegistration = DB::table('event_registrations')
            ->where('registration_code', 'LIKE', $todayPrefix . '%')
            ->orderBy('registration_code', 'desc')
            ->first();

        $newSequence = $lastRegistration ? ((int) substr($lastRegistration->registration_code, -5) + 1) : 1;
        return $todayPrefix . str_pad($newSequence, 5, '0', STR_PAD_LEFT);
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
        $subEventId = $request->sub_event_id; // Dapat berisi id_event_data_sub / sub_code

        // Mengambil peserta berdasarkan Sub Event beserta detail Kelas-nya
        $participants = DB::table('event_participants')
            ->join('event_registrations', 'event_participants.id_participant', '=', 'event_registrations.id_participant')
            ->leftJoin('event_registration_classes', 'event_registrations.id_registration', '=', 'event_registration_classes.id_registration')
            ->leftJoin('event_data_sub_class', 'event_registration_classes.id_event_data_sub_class', '=', 'event_data_sub_class.id_event_data_sub_class')
            ->leftJoin('event_data_sub', function ($join) {
                // Relasi ke Sub Event: bisa via master class atau langsung dari registration bila tanpa class
                $join->on('event_data_sub_class.event_data_sub_code', '=', 'event_data_sub.event_data_sub_code');
            })
            ->where(function ($query) use ($subEventId) {
                // Filter berdasarkan ID Sub Event, Kode Sub Event, atau ID Sub Class
                $query->where('event_data_sub.id_event_data_sub', $subEventId)
                    ->orWhere('event_data_sub.event_data_sub_code', $subEventId)
                    ->orWhere('event_registration_classes.id_event_data_sub_class', $subEventId);
            })
            ->select(
                'event_participants.*',
                'event_registrations.id_registration',
                'event_registrations.registration_code',
                'event_registrations.payment_status',
                'event_registrations.registration_status',
                'event_registrations.registration_date',
                'event_registration_classes.qr_code_token',
                'event_registration_classes.attendance_status',
                'event_registration_classes.created_at as register_date',
                // Data Sub Event & Class yang dimunculkan
                'event_data_sub.event_data_sub_name',
                'event_data_sub.event_data_sub_code',
                'event_data_sub_class.event_data_sub_class_name',
                'event_data_sub_class.event_data_sub_class_room',
                'event_data_sub_class.event_data_sub_class_price'
            )
            ->distinct()
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
                ->leftJoin('event_data_sub as eds', 'esc.event_data_sub_code', '=', 'eds.event_data_sub_code')
                ->leftJoin('event_data as ed', 'eds.event_data_code', '=', 'ed.event_data_code')
                ->where('er.id_registration', $id)
                ->select(
                    'er.id_registration',
                    'er.registration_code',
                    'er.payment_status',
                    'ed.event_data_code',
                    'ed.event_data_tittle as event_name',        // Judul Event Utama
                    'eds.event_data_sub_name as sub_event_name', // Nama Sub Event
                    'erc.qr_code_token',
                    'ep.full_name',                              // Nama Lengkap Peserta
                    'ep.email',
                    'ep.institution',
                    'ep.phone_number',
                    'esc.event_data_sub_class_name',
                    'esc.event_data_sub_class_price'
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
                ->leftJoin('event_data_sub as eds', 'esc.event_data_sub_code', '=', 'eds.event_data_sub_code') // Join ke Sub Event
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
                    'eds.event_data_sub_name', // Ambil Nama Sub Event
                    'ep.full_name',
                    'ep.phone_number',
                    'ep.email',
                    'ep.institution',
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
                    'sub_event_name'        => $participantData->event_data_sub_name ?? '-', // Ditambahkan
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
    public function getSubEventsData($eventCode)
    {
        $subEvents = DB::table('event_data_sub')
            ->where('event_data_code', $eventCode)
            ->select('event_data_sub_code', 'event_data_sub_name')
            ->get();

        return response()->json(['data' => $subEvents]);
    }
    // --- SIMPAN CLASS ---
    public function saveClass(Request $request)
    {
        if (empty($request->nama_class) || empty($request->code_event)) {
            return response()->json(0);
        }

        // Generate kode unik untuk class
        $classCode = 'ESC-' . strtoupper(Str::random(8));

        DB::table('event_data_sub_class')->insert([
            'event_data_sub_class_code' => $classCode,
            'event_data_sub_code'       => $request->code_event,
            'event_data_sub_class_name' => $request->nama_class,
            'event_data_sub_class_room' => $request->nama_room ?? '-',
            'event_data_sub_class_price' => $request->class_price ?? 0,
            'event_data_sub_class_type' => $request->class_type ?? 'default',
            'event_data_sub_class_kuota' => $request->class_kuota ?? 0,
            'event_data_sub_class_status' => 1, // Status default: Active (1)
            'created_at'                => now(),
            'updated_at'                => now(),
        ]);

        return $this->renderTableClass($request->code_event);
    }
    public function searchParticipantsJson(Request $request)
    {
        $search = $request->get('q');

        $participants = DB::table('event_participants')
            ->select('id_participant', 'full_name', 'email', 'phone_number')
            ->where('full_name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orWhere('phone_number', 'LIKE', "%{$search}%")
            ->limit(20)
            ->get();

        return response()->json($participants);
    }
    // --- HAPUS CLASS ---
    public function deleteClass($id, $code)
    {
        DB::table('event_data_sub_class')
            ->where('id_event_data_sub_class', $id)
            ->delete();

        return $this->renderTableClass($code);
    }

    // --- SIMPAN SESSION ---
    public function saveSession(Request $request)
    {
        if (empty($request->nama_session) || empty($request->code_event)) {
            return response()->json(0);
        }

        // Generate kode unik untuk session (contoh: ESS-ABC12345)
        $sessionCode = 'ESS-' . strtoupper(Str::random(8));

        DB::table('event_data_sub_session')->insert([
            'event_data_sub_session_code' => $sessionCode,
            'event_data_sub_code'         => $request->code_event,
            'event_data_sub_session_name' => $request->nama_session,
            'created_at'                  => now(),
            'updated_at'                  => now(),
        ]);

        return $this->renderTableSession($request->code_event);
    }

    // --- HAPUS SESSION ---
    public function deleteSession($id, $code)
    {
        DB::table('event_data_sub_session')
            ->where('id_event_data_sub_session', $id)
            ->delete();

        return $this->renderTableSession($code);
    }

    // Helper Helper Render Partial Table Class
    private function renderTableClass($code)
    {
        $data = DB::table('event_data_sub_class')
            ->where('event_data_sub_code', $code)
            ->get();

        $html = '<table class="table table-bordered mt-0 bg-white dark__bg-1100">
                    <thead>
                        <tr class="fs--1 bg-300">
                            <th>Class Name</th>
                            <th>Room</th>
                            <th>Price</th>
                            <th>Kuota</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($data as $datas) {
            $html .= '<tr>
                <td>' . e($datas->event_data_sub_class_name) . '</td>
                <td>' . e($datas->event_data_sub_class_room) . '</td>
                <td class="text-center align-middle">Rp ' . number_format($datas->event_data_sub_class_price, 0, ',', '.') . '</td>
                <td class="text-center align-middle">' . $datas->event_data_sub_class_kuota . '</td>
                <td class="text-center">
                    <button type="button" class="btn btn-link btn-sm text-danger p-0 btn-delete-class" data-id="' . $datas->id_event_data_sub_class . '">
                        <span class="fas fa-trash"></span>
                    </button>
                </td>
            </tr>';
        }

        if ($data->isEmpty()) {
            $html .= '<tr><td colspan="5" class="text-center text-muted">Belum ada class ditambahkan</td></tr>';
        }

        $html .= '</tbody></table>';

        return response($html);
    }

    // Helper Helper Render Partial Table Session
    private function renderTableSession($code)
    {
        $session = DB::table('event_data_sub_session')
            ->where('event_data_sub_code', $code)
            ->get();

        $html = '<table class="table table-bordered mt-0 bg-white dark__bg-1100">
                    <thead>
                        <tr class="fs--1 bg-300">
                            <th>Session Name</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($session as $sessions) {
            $html .= '<tr>
                <td>' . e($sessions->event_data_sub_session_name) . '</td>
                <td class="text-center">
                    <button type="button" class="btn btn-link btn-sm text-danger p-0 btn-delete-session" data-id="' . $sessions->id_event_data_sub_session . '">
                        <span class="fas fa-trash"></span>
                    </button>
                </td>
            </tr>';
        }

        if ($session->isEmpty()) {
            $html .= '<tr><td colspan="2" class="text-center text-muted fs--1">Belum ada session ditambahkan</td></tr>';
        }

        $html .= '</tbody></table>';

        return response($html);
    }

    // 2. Fetch Sub Event Class berdasarkan event_data_sub_code
    public function getSubClassesBySub($subCode)
    {
        $subClasses = DB::table('event_data_sub_class')
            ->where('event_data_sub_code', $subCode)
            ->select(
                'id_event_data_sub_class',
                'event_data_sub_class_name',
                'event_data_sub_class_price',
                'event_data_sub_class_kuota'
            )
            ->get();

        return response()->json(['data' => $subClasses]);
    }

    // 3. Process Insert Peserta Manual
    public function storeManualPeserta(Request $request)
    {
        // 1. Validasi Dinamis berdasarkan participant_mode
        $rules = [
            'event_data_code'         => 'required|string',
            'id_event_data_sub_class' => 'required',
            'participant_mode'        => 'required|in:existing,new',
        ];

        if ($request->participant_mode === 'existing') {
            $rules['id_participant']          = 'required|exists:event_participants,id_participant';
            $rules['payment_status_existing'] = 'required|in:paid,pending,cancelled';
        } else {
            $rules['full_name']       = 'required|string|max:255';
            $rules['email']           = 'required|email';
            $rules['phone_number']    = 'required|string|max:20';
            $rules['gender']          = 'nullable|in:L,P';
            $rules['identity_number'] = 'nullable|string';
            $rules['institution']     = 'nullable|string';
            $rules['address']         = 'nullable|string';
            $rules['payment_status']   = 'required|in:paid,pending,cancelled';
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            // 2. Ambil data Main Event (id_event_data) berdasarkan event_data_code
            $eventData = DB::table('event_data')
                ->where('event_data_code', $request->event_data_code)
                ->first();

            if (!$eventData) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Data Event tidak ditemukan.'
                ], 404);
            }

            // 3. Ambil snapshot harga dari Sub Class
            $subClass = DB::table('event_data_sub_class')
                ->where('id_event_data_sub_class', $request->id_event_data_sub_class)
                ->first();

            if (!$subClass) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Data Sub Class tidak ditemukan.'
                ], 404);
            }

            $classPrice = $subClass->event_data_sub_class_price ?? 0;

            // 4. Tentukan ID Participant & Status Pembayaran berdasarkan mode
            if ($request->participant_mode === 'existing') {
                $participantId = $request->id_participant;
                $paymentStatus = $request->payment_status_existing;
            } else {
                // Murni Insert Peserta Baru (Tanpa pengecekan email/duplikasi)
                $participantCode = 'PRT-' . date('Ymd') . '-' . strtoupper(Str::random(4));

                $participantId = DB::table('event_participants')->insertGetId([
                    'participant_code' => $participantCode,
                    'full_name'        => $request->full_name,
                    'email'            => $request->email,
                    'phone_number'     => $request->phone_number,
                    'gender'           => $request->gender ?? null,
                    'identity_number'  => $request->identity_number ?? null,
                    'institution'      => $request->institution ?? null,
                    'address'          => $request->address ?? null,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);

                $paymentStatus = $request->payment_status;
            }

            $totalAmount = $classPrice;

            // 5. Generate registration_code Unik (Format: REG-YYYYMMDD-XXXX)
            $registrationCode = 'REG-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            $regCode = $this->generateRegistrationCode();
            // 6. Insert ke event_registrations
            $registrationId = DB::table('event_registrations')->insertGetId([
                'registration_code'   => $regCode,
                'id_participant'      => $participantId,
                'id_event_data'       => $eventData->id_event_data,
                'total_amount'        => $totalAmount,
                'payment_status'      => $paymentStatus,
                'registration_status' => 'active',
                'registration_date'   => now(),
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);

            // 7. Generate Token QR Code Unik (Format: EVT-XXXXXXXX)
            $qrCodeToken = 'EVT-' . strtoupper(Str::random(8));

            // 8. Insert ke event_registration_classes
            DB::table('event_registration_classes')->insert([
                'id_registration'         => $registrationId,
                'id_event_data_sub_class' => $request->id_event_data_sub_class,
                'price'                   => $classPrice,
                'attendance_status'       => 'registered',
                'qr_code_token'           => $qrCodeToken,
                'created_at'              => now(),
                'updated_at'              => now(),
            ]);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Peserta berhasil ditambahkan!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menambahkan peserta: ' . $e->getMessage()
            ], 500);
        }
    }
    // 2. Import Peserta Massal dari File Excel / CSV
    public function importExcelPeserta(Request $request)
    {
        $request->validate([
            'event_data_code'         => 'required',
            'id_event_data_sub_class' => 'required',
            'file_excel'              => 'required|file|mimes:xlsx,xls,csv|max:5120',
            'default_payment_status'  => 'required|in:paid,pending',
        ]);

        DB::beginTransaction();
        try {
            $eventData = DB::table('event_data')->where('event_data_code', $request->event_data_code)->first();
            $subClass = DB::table('event_data_sub_class')->where('id_event_data_sub_class', $request->id_event_data_sub_class)->first();

            if (!$eventData || !$subClass) {
                return response()->json(['status' => 'error', 'message' => 'Event atau Kelas tidak ditemukan.'], 404);
            }

            // Read data dari file Excel .xlsx
            $rows = Excel::toArray([], $request->file('file_excel'))[0];

            // Hapus baris pertama (Header)
            array_shift($rows);

            $importedCount = 0;
            $classPrice = $subClass->event_data_sub_class_price ?? 0;

            foreach ($rows as $row) {
                // Kolom Excel: 0: full_name, 1: email, 2: phone_number, 3: gender, 4: identity_number, 5: institution, 6: address
                $fullName = $row[0] ?? null;
                $email    = $row[1] ?? null;
                $phone    = $row[2] ?? null;

                if (empty($fullName) || empty($email) || empty($phone)) {
                    continue; // Skip jika data utama kosong
                }

                // 1. Insert Peserta
                $participantId = DB::table('event_participants')->insertGetId([
                    'participant_code' => 'PRT-' . date('Ymd') . '-' . strtoupper(Str::random(4)),
                    'full_name'        => trim($fullName),
                    'email'            => trim($email),
                    'phone_number'     => trim($phone),
                    'gender'           => isset($row[3]) && in_array(strtoupper(trim($row[3])), ['L', 'P']) ? strtoupper(trim($row[3])) : null,
                    'identity_number'  => $row[4] ?? null,
                    'institution'      => $row[5] ?? null,
                    'address'          => $row[6] ?? null,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
                $regCode = $this->generateRegistrationCode();
                // 2. Insert Registrasi
                $registrationId = DB::table('event_registrations')->insertGetId([
                    'registration_code'   => $regCode,
                    'id_participant'      => $participantId,
                    'id_event_data'       => $eventData->id_event_data,
                    'total_amount'        => $classPrice,
                    'payment_status'      => $request->default_payment_status,
                    'registration_status' => 'active',
                    'registration_date'   => now(),
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);

                // 3. Insert Kelas Registrasi & Token QR Code
                DB::table('event_registration_classes')->insert([
                    'id_registration'         => $registrationId,
                    'id_event_data_sub_class' => $request->id_event_data_sub_class,
                    'price'                   => $classPrice,
                    'attendance_status'       => 'registered',
                    'qr_code_token'           => 'EVT-' . strtoupper(Str::random(8)),
                    'created_at'              => now(),
                    'updated_at'              => now(),
                ]);

                $importedCount++;
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => "Berhasil mengimport {$importedCount} data peserta dari file Excel!"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Gagal import: ' . $e->getMessage()], 500);
        }
    }
    // Download Template CSV untuk Import Peserta
    public function downloadTemplateExcel()
    {
        return Excel::download(new ParticipantTemplateExport, 'template_import_peserta.xlsx');
    }
    // DATA EVENT
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
    public function menu_event_daftar_get_survay($code)
    {
        try {
            // 1. Ambil data semua survey beserta peserta terkait
            $rawSurveys = DB::table('event_survey_answers')
                ->join('event_surveys', 'event_survey_answers.id_event_survey', '=', 'event_surveys.id_event_survey')
                ->join('event_data', 'event_surveys.id_event_data', '=', 'event_data.id_event_data')
                ->join('event_participants', 'event_survey_answers.id_participant', '=', 'event_participants.id_participant')
                ->where('event_data.event_data_code', $code)
                ->select(
                    'event_participants.id_participant',
                    'event_participants.participant_code',
                    'event_participants.full_name',
                    'event_participants.email',
                    'event_participants.phone_number',
                    'event_surveys.question as survey_question',
                    'event_survey_answers.answer as survey_answer',
                    'event_survey_answers.created_at as submitted_at'
                )
                ->orderBy('event_participants.id_participant', 'asc')
                ->orderBy('event_survey_answers.id_event_survey', 'asc')
                ->get();

            // 2. Kelompokkan (Group) data berdasarkan Peserta
            $groupedData = [];

            foreach ($rawSurveys as $item) {
                $participantId = $item->id_participant;

                if (!isset($groupedData[$participantId])) {
                    $groupedData[$participantId] = [
                        'id_participant'   => $item->id_participant,
                        'participant_code' => $item->participant_code,
                        'full_name'        => $item->full_name,
                        'email'            => $item->email,
                        'phone_number'     => $item->phone_number,
                        'total_answers'    => 0,
                        'surveys'          => []
                    ];
                }

                $groupedData[$participantId]['surveys'][] = [
                    'survey_question' => $item->survey_question,
                    'survey_answer'   => $item->survey_answer,
                    'submitted_at'    => $item->submitted_at
                ];

                $groupedData[$participantId]['total_answers']++;
            }

            // Reset keys array agar menjadi indexed array (0, 1, 2, ...)
            $result = array_values($groupedData);

            return response()->json([
                'status'  => 'success',
                'message' => 'Data survey peserta berhasil dimuat.',
                'data'    => $result
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengambil data survey: ' . $e->getMessage()
            ], 500);
        }
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
            ->leftJoin('event_data_sub as eds', 'esc.event_data_sub_code', '=', 'eds.event_data_sub_code')
            ->leftJoin('event_data as ed', 'eds.event_data_code', '=', 'ed.event_data_code')
            ->where('er.id_registration', $idRegistration)
            ->select(
                'er.id_registration',
                'er.registration_code',
                'er.payment_status',
                'ed.event_data_code',
                'ed.event_data_tittle as event_name',        // Judul Event Utama
                'eds.event_data_sub_name as sub_event_name', // Nama Sub Event
                'erc.qr_code_token',
                'ep.full_name',                              // Nama Lengkap Peserta
                'ep.email',
                'ep.institution',
                'ep.phone_number',
                'esc.event_data_sub_class_name',
                'esc.event_data_sub_class_price'
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
                    ->leftJoin('event_data_sub_class as esc', 'erc.id_event_data_sub_class', '=', 'esc.id_event_data_sub_class')
                    ->leftJoin('event_data_sub as eds', 'esc.event_data_sub_code', '=', 'eds.event_data_sub_code')
                    ->leftJoin('event_data as ed', 'eds.event_data_code', '=', 'ed.event_data_code')
                    ->where('er.id_registration', $idRegistration)
                    ->select(
                        'er.id_registration',
                        'er.registration_code',
                        'er.payment_status',
                        'ed.event_data_code',
                        'ed.event_data_tittle as event_name',        // Judul Event Utama
                        'eds.event_data_sub_name as sub_event_name', // Nama Sub Event
                        'erc.qr_code_token',
                        'ep.full_name',                              // Nama Lengkap Peserta
                        'ep.email',
                        'ep.institution',
                        'ep.phone_number',
                        'esc.event_data_sub_class_name',
                        'esc.event_data_sub_class_price'
                    )
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
    // DATA EVENT
    public function menu_event_e_sertifikat_event($akses, $id)
    {
        if ($this->url_akses($akses, $id) == true) {
            // Get semua Event Utama
            $events = DB::table('event_data')
                ->select('event_data_code', 'event_data_tittle')
                ->get();

            return view('app-event.menu-event.e-sertifikat-event', [
                'akses' => $akses,
                'code' => $id,
                'events' => $events
            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
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

    // DATA KEHADIRAN
    public function laporan_event_daftar_kehadiran($akses, $id, Request $request)
    {
        if ($this->url_akses($akses, $id) == true) {
            // Get semua Event Utama
            $events = DB::table('event_data')
                ->select('event_data_code', 'event_data_tittle')
                ->get();

            return view('app-event.laporan.laporan-kehadiran', compact(
                'events'
            ), [
                'akses' => $akses,
                'code' => $id,

            ]);
        } else {
            return Redirect::to('dashboard/home');
        }
    }
    public function getSubEventsattendance($event_code)
    {
        $subEvents = DB::table('event_data_sub')
            ->where('event_data_code', $event_code)
            ->get();

        return response()->json($subEvents);
    }
    public function getClassesattendance($sub_code)
    {
        $classes = DB::table('event_data_sub_class')
            ->where('event_data_sub_code', $sub_code)
            ->get();

        return response()->json($classes);
    }
    public function getSessionsattendance($sub_code)
    {
        $sessions = DB::table('event_data_sub_session')
            ->where('event_data_sub_code', $sub_code)
            ->get();

        return response()->json($sessions);
    }

    public function getParticipantsattendance(Request $request)
    {
        $subCode = $request->query('sub_code');
        $classId = $request->query('class_id');
        $sessionCode = $request->query('session_code');

        $query = DB::table('event_participants')
            ->join('event_registrations', 'event_participants.id_participant', '=', 'event_registrations.id_participant')
            ->join('event_registration_classes', 'event_registrations.id_registration', '=', 'event_registration_classes.id_registration')
            ->join('event_data_sub_class', 'event_registration_classes.id_event_data_sub_class', '=', 'event_data_sub_class.id_event_data_sub_class')
            ->join('event_data_sub', 'event_data_sub_class.event_data_sub_code', '=', 'event_data_sub.event_data_sub_code')
            ->join('event_data', 'event_data_sub.event_data_code', '=', 'event_data.event_data_code')
            ->where('event_data_sub.event_data_sub_code', $subCode);

        // Filter Opsional: Kelas
        if ($classId) {
            $query->where('event_data_sub_class.id_event_data_sub_class', $classId);
        }

        // Filter Opsional: Sesi Check-In
        if ($sessionCode) {
            $session = DB::table('event_data_sub_session')->where('event_data_sub_session_code', $sessionCode)->first();
            if ($session) {
                $query->leftJoin('event_session_logs', function ($join) use ($session) {
                    $join->on('event_registration_classes.id_registration_class', '=', 'event_session_logs.id_registration_class')
                        ->where('event_session_logs.id_event_data_sub_session', '=', $session->id_event_data_sub_session);
                });
            }
        } else {
            $query->leftJoin('event_session_logs', 'event_registration_classes.id_registration_class', '=', 'event_session_logs.id_registration_class');
        }

        $participants = $query->select(
            'event_participants.full_name',
            'event_participants.participant_code',
            'event_participants.institution',
            'event_participants.phone_number',
            'event_registrations.registration_code',
            'event_data_sub_class.event_data_sub_class_name',
            'event_registration_classes.attendance_status',
            'event_registration_classes.check_in_at',
            'event_session_logs.created_at as session_check_in_at'
        )->distinct()->get();

        return response()->json($participants);
    }
}
