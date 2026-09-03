<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationSuccessMail;
use App\Models\Event\EventModel;
use App\Models\Event\Participant;
use App\Models\Event\SubEventModel;
use App\Models\Event\EventData;
use App\Models\Event\EventRegistration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function event_registrasi($id, $code)
    {
        $event = EventModel::where('event_data_code', $id)->first();

        if ($event) {
            // Pengecekan apakah deadline registrasi sudah lewat (sampai akhir hari deadline tersebut)
            $isExpired = Carbon::parse($event->event_data_reg_deadline)->endOfDay()->isPast();

            if ($isExpired) {
                return view('public.error.500');
            }

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
        // 1. Ambil Data Event Utama
        $event = EventModel::where('event_data_code', $id)->firstOrFail();

        // 2. Validasi Input
        $request->validate([
            'full_name'         => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'phone_number'      => 'required|string|max:20',
            'sub_event_codes'   => 'required|array|min:1',
            'sub_event_codes.*' => 'string',
            'class_ids'         => 'nullable|array',
            'gender'            => 'nullable|in:L,P',
            'identity_number'   => 'nullable|string|max:50',
            'institution'       => 'nullable|string|max:255',
            'address'           => 'nullable|string',
        ], [
            'full_name.required'       => 'Nama Lengkap wajib diisi.',
            'email.required'          => 'Email wajib diisi.',
            'phone_number.required'    => 'Nomor WhatsApp/HP wajib diisi.',
            'sub_event_codes.required' => 'Silakan pilih minimal satu Sub Event.',
        ]);

        DB::beginTransaction();
        try {
            // 3. Simpan Data Peserta Utama
            $participantCode = 'PAR-' . strtoupper(Str::random(8));
            // 1. Ambil nilai dan hapus spasi berlebih
            $frontTitle = trim($request->front_title);
            $fullName   = trim($request->full_name);
            $backTitle  = trim($request->back_title);

            // 2. Gabungkan Gelar Depan (jika ada)
            $formattedName = $frontTitle !== '' ? $frontTitle . ' ' . $fullName : $fullName;

            // 3. Gabungkan Gelar Belakang dengan Koma (jika ada)
            if ($backTitle !== '') {
                $formattedName .= ', ' . $backTitle;
            }
            $participantId = DB::table('event_participants')->insertGetId([
                'participant_code' => $participantCode,
                'full_name'        => $formattedName,
                'email'            => $request->email,
                'phone_number'     => $request->phone_number,
                'gender'           => $request->gender ?? null,
                'identity_number'  => $request->identity_number ?? null,
                'institution'      => $request->institution ?? null,
                'address'          => $request->address ?? null,
                'created_at'       => now(),
                'updated_at'       => now()
            ]);

            $subEventCodes = array_unique($request->input('sub_event_codes', []));
            $allSelectedClassIds = $request->input('class_ids', []); // Format: ['SUB01' => [1, 2], 'SUB02' => [5]]

            $createdRegCodes = [];
            $emailRegistrationData = []; // Array khusus untuk data email

            // 4. Loop Setiap Sub Event yang Dicentang Peserta
            foreach ($subEventCodes as $subCode) {

                // Ambil Detail Master Sub Event
                $subEventInfo = DB::table('event_data_sub')
                    ->where('event_data_sub_code', $subCode)
                    ->first();

                $subEventName = $subEventInfo->event_data_sub_name ?? $subCode;

                // Ambil Master Kelas Khusus untuk Sub Event Ini
                $allSubClasses = DB::table('event_data_sub_class')
                    ->where('event_data_sub_code', $subCode)
                    ->get();

                if ($allSubClasses->count() > 0) {
                    // Ambil ID kelas milik sub event ini yang dicentang user
                    $classIdsForSub = isset($allSelectedClassIds[$subCode]) ? (array) $allSelectedClassIds[$subCode] : [];

                    // Filter data kelas yang dipilih
                    $classesForThisSub = $allSubClasses->whereIn('id_event_data_sub_class', $classIdsForSub);

                    // Jika Sub Event memiliki opsi kelas tetapi user tidak memilih kelas satupun, lewati
                    if ($classesForThisSub->isEmpty()) {
                        continue;
                    }

                    $subEventTotal = $classesForThisSub->sum('event_data_sub_class_price');
                    $paymentStatus = $subEventTotal > 0 ? 'pending' : 'paid';

                    // Buat Kode Registrasi
                    $regCode = $this->generateRegistrationCode();
                    $createdRegCodes[] = $regCode;

                    $registrationId = DB::table('event_registrations')->insertGetId([
                        'id_event_data'     => $event->id_event_data,
                        'id_participant'    => $participantId,
                        'registration_code' => $regCode,
                        'total_amount'      => $subEventTotal,
                        'registration_date' => now(),
                        'payment_status'    => $paymentStatus,
                        'created_at'        => now(),
                        'updated_at'        => now()
                    ]);

                    $classesDetailForMail = [];

                    // Simpan Detail Kelas yang Dicentang
                    foreach ($classesForThisSub as $cls) {
                        $qrToken = 'QR-' . date('Ymd') . sprintf('%05d', mt_rand(0, 99999)) . rand(10, 99);

                        DB::table('event_registration_classes')->insert([
                            'id_registration'         => $registrationId,
                            'id_event_data_sub_class' => $cls->id_event_data_sub_class,
                            'price'                   => $cls->event_data_sub_class_price ?? 0,
                            'qr_code_token'           => $qrToken,
                            'attendance_status'       => 'registered',
                            'created_at'              => now(),
                            'updated_at'              => now()
                        ]);

                        // Format data kelas untuk dikirim ke email
                        $classesDetailForMail[] = [
                            'class_name' => $cls->event_data_sub_class_name,
                            'room'       => $cls->event_data_sub_class_room ?? '-',
                            'qr_token'   => $qrToken
                        ];
                    }

                    // Susun array email untuk Sub Event Berkelas
                    $emailRegistrationData[] = [
                        'sub_event_name'    => $subEventName,
                        'registration_code' => $regCode,
                        'classes'           => $classesDetailForMail
                    ];
                } else {
                    // Jika Sub Event TANPA KELAS: Registrasi Otomatis Terdaftar & Rp 0
                    $regCode = $this->generateRegistrationCode();
                    $createdRegCodes[] = $regCode;

                    DB::table('event_registrations')->insert([
                        'id_event_data'     => $event->id_event_data,
                        'id_participant'    => $participantId,
                        'registration_code' => $regCode,
                        'total_amount'      => 0,
                        'registration_date' => now(),
                        'payment_status'    => 'paid',
                        'created_at'        => now(),
                        'updated_at'        => now()
                    ]);

                    // Susun array email untuk Sub Event Tanpa Kelas
                    $emailRegistrationData[] = [
                        'sub_event_name'    => $subEventName,
                        'registration_code' => $regCode,
                        'classes'           => []
                    ];
                }
            }

            // Jika tidak ada registrasi yang berhasil dibuat
            if (empty($createdRegCodes)) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Silakan pilih setidaknya satu kelas pada Sub Event yang Anda centang.')->withInput();
            }

            // Commit Transaksi Database
            DB::commit();

            // 5. Kirim Email Konfirmasi Registrasi ke Peserta
            try {
                $contactPersons = DB::table('event_data_contact')
                    ->where('event_data_code', $id)
                    ->where('is_active', 1)
                    ->orderBy('sort_order', 'asc')
                    ->get();
                Mail::to($request->email)->send(
                    new RegistrationSuccessMail(
                        $formattedName,
                        $event->event_data_tittle ?? 'Event Utama',
                        $emailRegistrationData,
                        $contactPersons
                    )
                );
            } catch (\Exception $mailEx) {
                // Log eror jika SMTP server bermasalah agar tidak mencetak Exception merah ke halaman user
                Log::error('Gagal mengirim email pendaftaran: ' . $mailEx->getMessage());
            }

            return redirect()->back()->with('success', 'Pendaftaran berhasil! Rincian tiket telah dikirim ke email Anda. Kode Registrasi: ' . implode(', ', $createdRegCodes));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
    // Helper Function Generate Kode Registrasi Unik
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
}
