<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TatController extends Controller
{
    private $dbExternal = 'mysql_external';
    // Fetch Data LAB dari Server Lain
    public function getDataLab(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Menggunakan DB::connection() ke server eksternal
        $data = DB::connection($this->dbExternal)
            ->table('ss_tat_v2')
            ->whereBetween('SsTatV2Date', [$startDate, $endDate])
            ->orderBy('SsTatV2Date', 'asc')
            ->get();

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    // Fetch Data NON-LAB dari Server Lain
    public function getDataNonLab(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Menggunakan DB::connection() ke server eksternal
        $data = DB::connection($this->dbExternal)
            ->table('ss_tat_v2_nonlab')
            ->whereBetween('SsTatV2NonLabDate', [$startDate, $endDate])
            ->orderBy('SsTatV2NonLabDate', 'asc')
            ->get();

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    // Update Data LAB ke Server Lain
    public function updateLab(Request $request)
    {
        $rows = $request->input('data', []);

        foreach ($rows as $id => $row) {
            DB::connection($this->dbExternal)
                ->table('ss_tat_v2')
                ->where('SsTatV2ID', $id)
                ->update([
                    'SsTatV2FoTargetEntry'   => $row['SsTatV2FoTargetEntry'] ?? null,
                    'SsTatV2FoVerif'         => $row['SsTatV2FoVerif'] ?? null,
                    'SsTatV2FoTotalData'     => $row['SsTatV2FoTotalData'] ?? null,
                    'SsTatV2FoPctFo'         => $row['SsTatV2FoPctFo'] ?? null,
                    'SsTatV2FoPctVerif'      => $row['SsTatV2FoPctVerif'] ?? null,
                    'SsTatV2SamplingData'    => $row['SsTatV2SamplingData'] ?? null,
                    'SsTatV2SamplingHasil'   => $row['SsTatV2SamplingHasil'] ?? null,
                    'SsTatV2SamplingPct'     => $row['SsTatV2SamplingPct'] ?? null,
                    'SsTatV2VerifData'       => $row['SsTatV2VerifData'] ?? null,
                    'SsTatV2VerifHasil'      => $row['SsTatV2VerifHasil'] ?? null,
                    'SsTatV2VerifPct'        => $row['SsTatV2VerifPct'] ?? null,
                    'SsTatV2PengolahanData'  => $row['SsTatV2PengolahanData'] ?? null,
                    'SsTatV2PengolahanHasil' => $row['SsTatV2PengolahanHasil'] ?? null,
                    'SsTatV2PengolahanPct'   => $row['SsTatV2PengolahanPct'] ?? null,
                    'SsTatV2ValidasiData'    => $row['SsTatV2ValidasiData'] ?? null,
                    'SsTatV2ValidasiHasil'   => $row['SsTatV2ValidasiHasil'] ?? null,
                    'SsTatV2ValidasiPct'     => $row['SsTatV2ValidasiPct'] ?? null,
                    'SsTatV2AdmLabData'      => $row['SsTatV2AdmLabData'] ?? null,
                    'SsTatV2AdmLabHasil'     => $row['SsTatV2AdmLabHasil'] ?? null,
                    'SsTatV2AdmLabPct'       => $row['SsTatV2AdmLabPct'] ?? null,
                    'SsTatV2FullLabData'     => $row['SsTatV2FullLabData'] ?? null,
                    'SsTatV2FullLabHasil'    => $row['SsTatV2FullLabHasil'] ?? null,
                    'SsTatV2FullLabPct'      => $row['SsTatV2FullLabPct'] ?? null,
                ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Data TAT Lab di server eksternal berhasil diperbarui!']);
    }

    // Update Data NON-LAB ke Server Lain
    public function updateNonLab(Request $request)
    {
        $rows = $request->input('data', []);

        foreach ($rows as $id => $row) {
            DB::connection($this->dbExternal)
                ->table('ss_tat_v2_nonlab')
                ->where('SsTatV2NonLabID', $id)
                ->update([
                    'SsTatV2NonLabHandlingData'      => $row['SsTatV2NonLabHandlingData'] ?? null,
                    'SsTatV2NonLabHandling'          => $row['SsTatV2NonLabHandling'] ?? null,
                    'SsTatV2NonLabHandlingPct'       => $row['SsTatV2NonLabHandlingPct'] ?? null,
                    'SsTatV2NonLabVerifikasiData'    => $row['SsTatV2NonLabVerifikasiData'] ?? null,
                    'SsTatV2NonLabVerifikasi'        => $row['SsTatV2NonLabVerifikasi'] ?? null,
                    'SsTatV2NonLabVerifikasiPct'     => $row['SsTatV2NonLabVerifikasiPct'] ?? null,
                    'SsTatV2NonLabHandlingImageData' => $row['SsTatV2NonLabHandlingImageData'] ?? null,
                    'SsTatV2NonLabHandlingImage'     => $row['SsTatV2NonLabHandlingImage'] ?? null,
                    'SsTatV2NonLabHandlingImagePct'  => $row['SsTatV2NonLabHandlingImagePct'] ?? null,
                    'SsTatV2NonLabValidasiData'      => $row['SsTatV2NonLabValidasiData'] ?? null,
                    'SsTatV2NonLabValidasi'          => $row['SsTatV2NonLabValidasi'] ?? null,
                    'SsTatV2NonLabValidasiPct'       => $row['SsTatV2NonLabValidasiPct'] ?? null,
                    'SsTatV2NonLabTerimaFoData'      => $row['SsTatV2NonLabTerimaFoData'] ?? null,
                    'SsTatV2NonLabTerimaFo'          => $row['SsTatV2NonLabTerimaFo'] ?? null,
                    'SsTatV2NonLabTerimaFoPct'       => $row['SsTatV2NonLabTerimaFoPct'] ?? null,
                ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Data TAT Non-Lab di server eksternal berhasil diperbarui!']);
    }
}
