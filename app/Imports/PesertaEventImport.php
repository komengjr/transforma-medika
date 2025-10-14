<?php

namespace App\Imports;

use App\Models\PesertaEvent;
use DateTime;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PesertaEventImport implements ToModel, WithHeadingRow
{
    private $ids;
    private $code;
    public function __construct(string $code, $ids)
    {
        $this->ids = $ids;
        $this->code = $code;
    }
    public function model(array $row)
    {
        $total = FacadesDB::table('b_event_peserta')->count();
        // $data = DB::table('company_mou_peserta')->where('company_mou_code', $request->code)->first();
        // $UNIX_DATE = ($row['ttl'] - 25569) * 86400;
        return new PesertaEvent([
            'b_event_peserta_code' => 'P' . str_pad($total + 1, 30, '0', STR_PAD_LEFT),
            'b_event_code' => $this->code,
            'b_event_peserta_name' => $row['peserta_nama'],
            'b_event_peserta_booking' => $row['booking_no'],
            'b_event_peserta_class' => $row['class_name'],
            'b_event_peserta_room' => $row['room_id'],
            'b_event_peserta_hp' => $row['peserta_hp'],
            'b_event_peserta_email' => $row['peserta_email'],
            'b_event_peserta_lembaga' => $row['peserta_lembaga'],
            'b_event_peserta_desc' => $row['peserta_ket'],
            'b_event_peserta_status' => 0,
            'created_at' => now(),
        ]);
    }
}
