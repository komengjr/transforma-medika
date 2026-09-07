<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WaQueueController extends Controller
{
    public function enqueue(Request $request)
    {
        $request->validate([
            'userId'     => 'required',
            'number'     => 'required',
            'message'    => 'nullable|string',
            'attachment' => 'nullable|array',
        ]);

        try {
            $id = DB::table('event_data_sends')->insertGetId([
                'user_id'             => $request->userId,
                'phone_number'        => $request->number,
                'message'             => $request->message ?? '',
                'attachment_base64'   => $request->attachment['base64'] ?? null,
                'attachment_mimetype' => $request->attachment['mimetype'] ?? null,
                'attachment_filename' => $request->attachment['filename'] ?? null,
                'status'              => 'pending',
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);

            return response()->json([
                'status'  => true,
                'message' => 'Pesan berhasil masuk antrean server',
                'queue_id' => $id
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menyimpan antrean: ' . $e->getMessage()
            ], 500);
        }
    }
}
