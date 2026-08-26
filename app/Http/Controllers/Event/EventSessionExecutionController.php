<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventSessionExecutionController extends Controller
{
    public function index(Request $request)
    {
        $sessionCode = $request->query('session_code');
        $subCode     = $request->query('sub_code');

        // 1. Ambil Informasi Session & Sub Event
        $session = DB::table('event_data_sub_session')
            ->where('event_data_sub_session_code', $sessionCode)
            ->first();

        $subEvent = DB::table('event_data_sub')
            ->where('event_data_sub_code', $subCode)
            ->first();

        if (!$session || !$subEvent) {
            abort(404, 'Data Session atau Sub Event tidak ditemukan.');
        }

        // 2. Query Peserta berdasarkan Sub Event & Left Join ke Log Session
        $participants = DB::table('event_participants')
            ->join('event_registrations', 'event_participants.id_participant', '=', 'event_registrations.id_participant')
            ->join('event_registration_classes', 'event_registrations.id_registration', '=', 'event_registration_classes.id_registration')
            ->join('event_data_sub_class', 'event_registration_classes.id_event_data_sub_class', '=', 'event_data_sub_class.id_event_data_sub_class')
            ->where('event_data_sub_class.event_data_sub_code', $subCode)
            ->leftJoin('event_session_logs', function ($join) use ($session) {
                $join->on('event_registration_classes.id_registration_class', '=', 'event_session_logs.id_registration_class')
                    ->where('event_session_logs.id_event_data_sub_session', '=', $session->id_event_data_sub_session);
            })
            ->select(
                'event_participants.full_name',
                'event_participants.participant_code',
                'event_participants.institution',
                'event_registrations.registration_code',
                'event_registrations.payment_status',
                'event_registration_classes.id_registration_class',
                'event_registration_classes.qr_code_token',
                'event_session_logs.created_at as executed_at',
                'event_session_logs.id_session_log'
            )
            ->distinct()
            ->get();

        return view('app-event.menu-event.session-execution.index', compact('session', 'subEvent', 'participants'));
    }

    // Process Scan / Input Manual registration_code
    public function processCheck(Request $request)
    {
        $request->validate([
            'session_code'      => 'required',
            'registration_code' => 'required',
        ]);

        $regCode     = trim($request->registration_code);
        $sessionCode = $request->session_code;

        // 1. Ambil data Session berdasarkan session_code
        $session = DB::table('event_data_sub_session')
            ->where('event_data_sub_session_code', $sessionCode)
            ->first();

        if (!$session) {
            return response()->json(['status' => 'error', 'message' => 'Sesi tidak valid!'], 404);
        }

        // 2. Cari Data Registrasi & Kelas berdasarkan registration_code
        $regClass = DB::table('event_registrations')
            ->join('event_participants', 'event_registrations.id_participant', '=', 'event_participants.id_participant')
            ->join('event_registration_classes', 'event_registrations.id_registration', '=', 'event_registration_classes.id_registration')
            ->where('event_registrations.registration_code', $regCode)
            ->select(
                'event_registration_classes.id_registration_class',
                'event_registration_classes.qr_code_token',
                'event_participants.full_name',
                'event_participants.participant_code',
                'event_registrations.registration_code',
                'event_registrations.payment_status'
            )
            ->first();

        if (!$regClass) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kode Registrasi peserta tidak ditemukan!'
            ], 404);
        }

        // 3. Cek apakah id_registration_class sudah dicatat di sesi ini
        $existingLog = DB::table('event_session_logs')
            ->where('id_event_data_sub_session', $session->id_event_data_sub_session)
            ->where('id_registration_class', $regClass->id_registration_class)
            ->first();

        if ($existingLog) {
            return response()->json([
                'status'  => 'warning',
                'message' => "Peserta A.n <b>{$regClass->full_name}</b> (Kode: {$regClass->registration_code}) SUDAH diproses pada sesi ini!",
                'data'    => $regClass
            ]);
        }

        // 4. Simpan Log Presensi Sesi
        DB::table('event_session_logs')->insert([
            'id_registration_class'     => $regClass->id_registration_class,
            'id_event_data_sub_session' => $session->id_event_data_sub_session,
            'qr_code_token'             => $regClass->qr_code_token ?? $regCode,
            'created_at'                => now(),
            'updated_at'                => now(),
        ]);

        // 5. Update Status Presensi Kelas
        DB::table('event_registration_classes')
            ->where('id_registration_class', $regClass->id_registration_class)
            ->update([
                'attendance_status' => 'present',
                'check_in_at'       => now()
            ]);

        return response()->json([
            'status'  => 'success',
            'message' => "Berhasil! <b>{$regClass->full_name}</b> (Kode: {$regClass->registration_code}) sukses dicatat.",
            'data'    => $regClass
        ]);
    }
}
