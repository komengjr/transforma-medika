<?php

namespace App\Http\Controllers\Medic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    // Fungsi untuk Mencari Pasien berdasarkan NIK, Nama, atau PID
    public function search(Request $request)
    {
        $keyword = $request->q;

        if (!$keyword) {
            return response()->json(['success' => false, 'message' => 'Keyword kosong']);
        }

        $pasien = DB::table('medical_patient')
            ->where('pid', 'LIKE', "%{$keyword}%")
            ->orWhere('nama', 'LIKE', "%{$keyword}%")
            ->orWhere('no_id', 'LIKE', "%{$keyword}%") // NIK
            ->orWhere('tgl_lahir', 'LIKE', "%{$keyword}%") // Tanggal Lahir (Format YYYY-MM-DD)
            ->orWhere('no_hp', 'LIKE', "%{$keyword}%")
            ->get(); // Menggunakan get() untuk mengambil list data

        if ($pasien->count() > 0) {
            return response()->json(['success' => true, 'data' => $pasien]);
        }

        return response()->json(['success' => false, 'message' => 'Pasien tidak ditemukan']);
    }

    // Fungsi Create Pasien Baru
    public function store(Request $request)
    {
        // Generate PID otomatis (Contoh: P-1001, P-1002)
        $lastPasien = DB::table('medical_patient')->orderBy('id', 'desc')->first();
        $nextId = $lastPasien ? $lastPasien->id + 1 : 1;
        $pid = 'P-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $id = DB::table('medical_patient')->insertGetId([
            'pid' => $pid,
            'awalan' => $request->awalan,
            'nama' => $request->nama,
            'akhiran' => $request->akhiran,
            'jk' => $request->jk,
            'title' => $request->title,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => date('Y-m-d', strtotime($request->tgl_lahir)),
            'umur' => $request->umur,
            'agama' => $request->agama,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'pekerjaan' => $request->pekerjaan,
            'nip' => $request->nip,
            'tipe_id' => $request->tipe_id,
            'no_id' => $request->no_id,
            'catatan' => $request->catatan,
            'alamat' => $request->alamat,
            'foto' => $request->patient_photo_base64,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $pasien = DB::table('medical_patient')->where('id', $id)->first();
        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan', 'data' => $pasien]);
    }

    // Fungsi Update Data Pasien
    public function update(Request $request, $id)
    {
        $updateData = [
            'awalan' => $request->awalan,
            'nama' => $request->nama,
            'akhiran' => $request->akhiran,
            'jk' => $request->jk,
            'title' => $request->title,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => date('Y-m-d', strtotime($request->tgl_lahir)),
            'umur' => $request->umur,
            'agama' => $request->agama,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'pekerjaan' => $request->pekerjaan,
            'nip' => $request->nip,
            'tipe_id' => $request->tipe_id,
            'no_id' => $request->no_id,
            'catatan' => $request->catatan,
            'alamat' => $request->alamat,
            'updated_at' => now(),
        ];

        if ($request->filled('patient_photo_base64')) {
            $updateData['foto'] = $request->patient_photo_base64;
        }

        DB::table('medical_patient')->where('id', $id)->update($updateData);
        $pasien = DB::table('medical_patient')->where('id', $id)->first();

        return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui', 'data' => $pasien]);
    }
}
