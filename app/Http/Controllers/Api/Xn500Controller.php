<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Xn500Controller extends Controller
{
    public function receiveData(Request $request)
    {
        try {
            // Log payload yang masuk dari Node.js
            Log::info('Data XN-500 masuk:', $request->all());

            $nolab = $request->input('nolab') ?? ('UNKNOWN_' . time());

            // Insert ke database
            $insertedId = DB::table('interface_alat_xn_500')->insertGetId([
                'instrument_id' => $request->input('instrumentID', 17),
                'nolab'         => $nolab,
                'tanggal'       => $request->input('tanggal') ?? now(),
                'flag_qc'       => $request->input('flag_qc', 'N'),
                'flag_query'    => $request->input('flag_query', 'N'),
                'results'       => json_encode($request->input('result', [])),
                'raw_payload'   => json_encode($request->all()),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Data berhasil disimpan ke database',
                'id'      => $insertedId
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error save XN-500: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data ke database',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
