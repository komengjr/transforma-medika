<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event\EventModel;
use App\Models\Event\Participant;
use App\Models\Event\SubEventModel;
use App\Models\Event\EventData;
use App\Models\Event\EventRegistration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function event_registrasi($id, $code)
    {
        $event = EventModel::where('event_data_code', $id)->first();

        if ($event) {
            // Ambil sub event
            $subevent = SubEventModel::where('event_data_code', $id)->get();

            // Kumpulkan sub_code
            $subCodes = $subevent->pluck('event_data_sub_code');

            // Ambil semua class yang terkait dengan sub event di atas
            $classes = DB::table('event_data_sub_class')
                ->whereIn('event_data_sub_code', $subCodes)
                ->where('event_data_sub_class_status', 1)
                ->get();

            return view('public.event-registrasi', compact('event', 'subevent', 'classes'));
        } else {
            return view('public.error.500');
        }
    }
    public function store(Request $request, $id)
    {
        $event = EventModel::where('event_data_code', $id)->firstOrFail();

        // Validasi Wajib & Opsional
        $request->validate([
            'full_name'       => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'phone_number'    => 'required|string|max:20',
            'sub_event_code'  => 'required|string',
            'class_id'        => 'required',
            // Opsional
            'gender'          => 'nullable|in:L,P',
            'identity_number' => 'nullable|string|max:50',
            'institution'     => 'nullable|string|max:255',
            'address'         => 'nullable|string',
        ], [
            'full_name.required'      => 'Nama Lengkap wajib diisi.',
            'email.required'          => 'Email wajib diisi.',
            'phone_number.required'   => 'Nomor WhatsApp/HP wajib diisi.',
            'sub_event_code.required' => 'Silakan pilih Sub Event terlebih dahulu.',
            'class_id.required'       => 'Silakan pilih Kelas / Tiket.'
        ]);

        DB::beginTransaction();
        try {
            // 0. Ambil Data Kelas dari tabel 'event_data_sub_class' (Tanpa 's')
            $selectedClass = DB::table('event_data_sub_class')
                ->where('id_event_data_sub_class', $request->class_id)
                ->first();

            // Ambil harga tiket (jika gratis / null diset 0)
            $classPrice = $selectedClass ? ($selectedClass->event_data_sub_class_price ?? 0) : 0;

            // Status pembayaran otomatis
            $paymentStatus = $classPrice > 0 ? 'pending' : 'paid';

            // A. Simpan Data Peserta
            $participantCode = 'PAR-' . strtoupper(Str::random(8));

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
                'updated_at'       => now()
            ]);

            // B. Simpan Master Registrasi Event
            $regCode = 'REG-' . strtoupper(Str::random(8));
            $registrationId = DB::table('event_registrations')->insertGetId([
                'id_event_data'     => $event->id_event_data,
                'id_participant'    => $participantId,
                'registration_code' => $regCode,
                'total_amount'      => $classPrice,       // Mengisi total_amount
                'registration_date' => now(),             // Mengisi registration_date
                'payment_status'    => $paymentStatus,
                'created_at'        => now(),
                'updated_at'        => now()
            ]);

            // C. Simpan Detail Kelas Pendaftaran & Snapshot Price
            $qrToken = 'QR-' . strtoupper(md5($regCode . time()));
            DB::table('event_registration_classes')->insert([
                'id_registration'         => $registrationId,
                'id_event_data_sub_class' => $request->class_id,
                'price'                   => $classPrice,   // Snapshot harga kelas
                'qr_code_token'           => $qrToken,
                'attendance_status'       => 'registered',  // Menggunakan default 'registered' sesuai enum
                'created_at'              => now(),
                'updated_at'              => now()
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Pendaftaran berhasil! Kode Registrasi Anda: ' . $regCode);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}
