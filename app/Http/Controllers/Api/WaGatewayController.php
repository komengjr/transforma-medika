<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WaGatewayController extends Controller
{
    /**
     * Mengambil antrean pesan yang berstatus 'pending'
     * dan langsung mengubah statusnya menjadi 'processing'
     */
    public function getPending(Request $req)
    {
        try {
            DB::beginTransaction();

            // 1. Ambil 5 data antrean dengan status 'pending'
            $pendingSends = DB::table('event_data_sends')
                ->where('status', 'pending')
                ->orderBy('id', 'asc')
                ->limit(5)
                ->lockForUpdate() // Mengunci baris agar tidak diambil ganda oleh request bersamaan
                ->get();

            if ($pendingSends->isEmpty()) {
                DB::commit();
                return response()->json([
                    'status'  => true,
                    'message' => 'Tidak ada antrean pending',
                    'data'    => []
                ], 200);
            }

            // 2. Ambil ID dari data yang akan diproses
            $ids = $pendingSends->pluck('id')->toArray();

            // 3. Ubah status menjadi 'processing'
            DB::table('event_data_sends')
                ->whereIn('id', $ids)
                ->update([
                    'status'     => 'processing',
                    'updated_at' => now(),
                ]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Berhasil mengambil antrean',
                'data'    => $pendingSends
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('API WA Get Pending Error: ' . $e->getMessage());

            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage(),
                'data'    => []
            ], 500);
        }
    }

    /**
     * Memperbarui status antrean setelah diproses oleh Node.js (sent / failed)
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id'            => 'required|integer',
            'status'        => 'required|in:sent,failed',
            'error_message' => 'nullable|string',
        ]);

        try {
            $id = $request->input('id');
            $status = $request->input('status');
            $errorMessage = $request->input('error_message');

            $updateData = [
                'status'     => $status,
                'updated_at' => now(),
            ];

            if ($status === 'sent') {
                $updateData['sent_at'] = now();
                $updateData['error_message'] = null;
            } else {
                $updateData['error_message'] = $errorMessage;
            }

            $updated = DB::table('event_data_sends')
                ->where('id', $id)
                ->update($updateData);

            if (!$updated) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data antrean tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status'  => true,
                'message' => "Status antrean ID {$id} berhasil diperbarui menjadi {$status}"
            ], 200);
        } catch (\Exception $e) {
            Log::error('API WA Update Status Error: ' . $e->getMessage());

            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }
}
