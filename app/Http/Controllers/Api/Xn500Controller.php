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
            // Log payload masuk
            Log::info('Data XN-500 diterima:', $request->all());

            $nolab = $request->input('nolab');
            if (!$nolab) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Nolab / Sample ID tidak ditemukan'
                ], 400);
            }

            // Simpan otomatis ke tabel interface_alat_xn_500
            $insertedId = DB::table('interface_alat_xn_500')->insertGetId([
                'instrument_id' => $request->input('instrumentID'),
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
                'message' => 'Data XN-500 berhasil dimasukkan ke database',
                'id'      => $insertedId
            ], 201);
        } catch (\Exception $e) {
            Log::error('Gagal memproses data XN-500: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan ke database',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
