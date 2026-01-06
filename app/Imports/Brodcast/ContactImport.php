<?php

namespace App\Imports\Brodcast;

use App\Models\Brodcast\masterContact;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Illuminate\Support\Str;

class ContactImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new masterContact([
            'b_master_contact_code'  => Str::uuid(),
            'b_master_contact_name' => $row['contact_name'],
            'b_master_contact_email' => $row['contact_email'],
            'b_master_contact_whatsapp' => $row['contact_number'],
            'b_master_contact_cabang' => Auth::user()->access_cabang,
            'b_master_contact_status' => 1,
            'created_at' => now(),
        ]);
    }
}
