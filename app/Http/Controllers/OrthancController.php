<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrthancController extends Controller
{
    public function showViewer(Request $request)
    {
        $baseUrl = config('services.orthanc.url');

        // Menggunakan Web Viewer bawaan Orthanc
        // Format URL Web Viewer Orthanc: /ui/app/#/study?uuid={studyId}
        // Atau Stone Web Viewer (jika terinstall): /stone-webviewer/index.html?study={studyId}
        $viewerUrl = "{$baseUrl}/ohif/";

        return view('application.radiologi.orthanc.viwer', [
            'viewerUrl' => $viewerUrl,
        ]);
    }
    public function getStudies()
    {
        $baseUrl = config('services.orthanc.url');
        $username = config('services.orthanc.username'); // Opsional jika pakai auth
        $password = config('services.orthanc.password'); // Opsional jika pakai auth

        $studiesList = [];

        try {
            // Menyiapkan HTTP Request ke Orthanc
            $http = Http::timeout(10);

            // Tambahkan Basic Auth jika diset di .env
            if ($username && $password) {
                $http->withBasicAuth($username, $password);
            }

            // Gunakan endpoint /tools/find untuk ambil detail sekaligus
            $response = $http->post("{$baseUrl}/tools/find", [
                'Level'   => 'Study',
                'Query'   => (object)[], // Kosongkan untuk mengambil SEMUA study
                'Expand'  => true,       // true = sertakan detail tag DICOM pasien
            ]);

            if ($response->successful()) {
                $studies = $response->json() ?? [];

                foreach ($studies as $study) {
                    $studiesList[] = [
                        'orthanc_study_id' => $study['ID'] ?? '',
                        'patient_name'     => $study['PatientMainDicomTags']['PatientName'] ?? 'N/A',
                        'patient_id'       => $study['PatientMainDicomTags']['PatientID'] ?? 'N/A',
                        'study_date'       => $study['MainDicomTags']['StudyDate'] ?? 'N/A',
                        'modality'         => $study['Series'][0] ?? 'N/A',
                    ];
                }
            } else {
                Log::error("Orthanc API Error Status: " . $response->status());
            }
        } catch (\Exception $e) {
            Log::error("Gagal terhubung ke Orthanc: " . $e->getMessage());
        }
        return view('application.radiologi.orthanc.index', compact('studiesList'));
    }
}
