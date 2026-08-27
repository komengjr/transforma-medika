<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventDataRekening;
use App\Models\EventDataContact;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EventAddonController extends Controller
{
    // Fetch & Store Rekening
    public function getRekening($event_code)
    {
        $data = DB::table('event_data_rekening')
            ->where('event_data_code', $event_code)
            ->where('is_active', true)
            ->orderBy('id_event_data_rekening', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function storeRekening(Request $request)
    {
        $request->validate([
            'event_data_code' => 'required',
            'bank_name'       => 'required',
            'account_number'  => 'required',
            'account_holder'  => 'required',
        ]);

        $now = Carbon::now();

        $id = DB::table('event_data_rekening')->insertGetId([
            'event_data_code' => $request->event_data_code,
            'bank_name'       => $request->bank_name,
            'account_number'  => $request->account_number,
            'account_holder'  => $request->account_holder,
            'bank_branch'     => $request->bank_branch ?? null,
            'is_active'       => true,
            'created_at'      => $now,
            'updated_at'      => $now,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data rekening berhasil disimpan!',
            'id'      => $id
        ]);
    }

    public function destroyRekening($id)
    {
        DB::table('event_data_rekening')
            ->where('id_event_data_rekening', $id)
            ->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data rekening berhasil dihapus!'
        ]);
    }


    // ================= CONTACT PERSON CRUD (DIRECT DB) ================= //

    public function getContact($event_code)
    {
        $data = DB::table('event_data_contact')
            ->where('event_data_code', $event_code)
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id_event_data_contact', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'event_data_code' => 'required',
            'contact_name'    => 'required',
            'contact_number'  => 'required',
        ]);

        $now = Carbon::now();

        $id = DB::table('event_data_contact')->insertGetId([
            'event_data_code' => $request->event_data_code,
            'contact_name'    => $request->contact_name,
            'contact_role'    => $request->contact_role ?? null,
            'contact_number'  => $request->contact_number,
            'is_active'       => true,
            'sort_order'      => 0,
            'created_at'      => $now,
            'updated_at'      => $now,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Data contact berhasil disimpan!',
            'id'      => $id
        ]);
    }

    public function destroyContact($id)
    {
        DB::table('event_data_contact')
            ->where('id_event_data_contact', $id)
            ->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Data contact berhasil dihapus!'
        ]);
    }
}
