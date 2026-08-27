<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EventModel;

class EventSurveyController extends Controller
{
    private $googleReviewUrl = 'https://search.google.com/local/writereview?placeid=ChIJUW8KCA5ZHS4R8Ykb1Ld4rxM';
    public function getAdminSurveys($eventCode)
    {
        $event = DB::table('event_data')->where('event_data_code', $eventCode)->first();

        if (!$event) {
            return response()->json(['status' => 'error', 'message' => 'Event tidak ditemukan.'], 404);
        }

        $surveys = DB::table('event_surveys')
            ->where('id_event_data', $event->id_event_data)
            ->get();

        // Contoh format link publik untuk admin (parameter {registrationCode} diisi placeholder)
        $publicSurveyUrl = url("event/survey/form/{$eventCode}/[KODE_REGISTRASI_PESERTA]");

        return response()->json([
            'status'     => 'success',
            'event'      => $event,
            'surveys'    => $surveys,
            'survey_url' => $publicSurveyUrl
        ]);
    }

    public function storeQuestion(Request $request)
    {
        $request->validate([
            'id_event_data' => 'required|numeric',
            'question'      => 'required|string|max:500',
            'type'          => 'required|in:text,rating',
        ]);

        DB::table('event_surveys')->insert([
            'id_event_data' => $request->id_event_data,
            'question'      => $request->question,
            'type'          => $request->type,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pertanyaan survey berhasil ditambahkan!'
        ]);
    }

    public function deleteQuestion($id)
    {
        DB::table('event_surveys')->where('id_event_survey', $id)->delete();
        DB::table('event_survey_answers')->where('id_event_survey', $id)->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Pertanyaan berhasil dihapus.'
        ]);
    }

    // ==================== AKSI PESERTA (FORM PUBLIK) ====================

    /**
     * Halaman Form Survey Publik Peserta dengan ID Registrasi / Kode Registrasi
     */
    public function publicSurveyForm($eventCode, $registrationCode)
    {
        // 1. Cek Event
        $event = DB::table('event_data')
            ->where('event_data_code', $eventCode)
            ->first();

        if (!$event) {
            abort(404, 'Event tidak ditemukan.');
        }

        // 2. Cek Registrasi & Participant
        $registration = DB::table('event_registrations')
            ->join('event_participants', 'event_registrations.id_participant', '=', 'event_participants.id_participant')
            ->where('event_registrations.registration_code', $registrationCode)
            ->orWhere('event_registrations.id_registration', $registrationCode)
            ->select(
                'event_registrations.id_registration',
                'event_registrations.registration_code',
                'event_participants.id_participant',
                'event_participants.full_name',
                'event_participants.email'
            )
            ->first();

        if (!$registration) {
            abort(404, 'Data Registrasi Peserta tidak ditemukan.');
        }

        // 3. Cek Apakah Peserta Sudah Pernah Mengisi Survey
        $alreadySubmitted = DB::table('event_survey_answers')
            ->where('id_participant', $registration->id_participant)
            ->exists();

        // JIKA SUDAH TERISI (DONE) -> LANGSUNG REDIRECT KE GOOGLE REVIEW PRAMITA PONTIANAK
        if ($alreadySubmitted) {
            return redirect()->away($this->googleReviewUrl);
        }

        // 4. Jika Belum Mengisi, Tampilkan Pertanyaan Survey
        $surveys = DB::table('event_surveys')
            ->where('id_event_data', $event->id_event_data)
            ->get();

        return view('public.public-survey-form', compact('event', 'registration', 'surveys'));
    }

    /**
     * Submit Jawaban Survey Peserta
     */
    public function submitPublicAnswer(Request $request)
    {
        $request->validate([
            'id_participant' => 'required|numeric',
            'answers'        => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->answers as $surveyId => $answer) {
                if (!empty($answer)) {
                    DB::table('event_survey_answers')->updateOrInsert(
                        [
                            'id_event_survey' => $surveyId,
                            'id_participant'  => $request->id_participant,
                        ],
                        [
                            'answer'     => is_array($answer) ? json_encode($answer) : $answer,
                            'updated_at' => now(),
                            'created_at' => now(),
                        ]
                    );
                }
            }
            DB::commit();

            // Selesai isi -> Langsung redirect ke Google Review Pramita Pontianak
            return redirect()->away($this->googleReviewUrl);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
