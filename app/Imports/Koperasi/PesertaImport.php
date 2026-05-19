<?php

namespace App\Imports\Koperasi;

use App\Models\Koperasi\PesertaKoperasi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Illuminate\Support\Str;

class PesertaImport implements ToModel, WithHeadingRow
{
    private $pokok;
    private $code;
    private $wajib;
    public function __construct(string $code, $pokok, $wajib)
    {
        $this->pokok = $pokok;
        $this->code = $code;
        $this->wajib = $wajib;
    }
    public function model(array $row)
    {
        $total = DB::table('kop_master_peserta')->count();
        $UNIX_DATE = ($row['tgl_lahir'] - 25569) * 86400;
        $code_peserta = 'P' . str_pad($total + 1, 10, '0', STR_PAD_LEFT);
        DB::table('kop_peserta_sim_pok')->insert([
            'kop_peserta_sim_pok_code' => str::uuid(),
            'kop_master_peserta_code' => $code_peserta,
            'kop_simpanan_pokok_code' => $this->pokok,
            'kop_peserta_sim_pok_date' => now(),
            'kop_peserta_sim_pok_status' => 1,
            'created_at' => now(),
        ]);
        DB::table('kop_peserta_sim_jib')->insert([
            'kop_peserta_sim_jib_code' => str::uuid(),
            'kop_master_peserta_code' => $code_peserta,
            'kop_simpanan_wajib_code' => $this->wajib,
            'kop_peserta_sim_jib_date' => now(),
            'kop_peserta_sim_jib_status' => 1,
            'created_at' => now(),
        ]);
        return new PesertaKoperasi([
            'kop_master_peserta_code' => $code_peserta,
            'kop_master_peserta_nik' => $row['nik'],
            'kop_master_peserta_nip' => $row['nip'],
            'kop_master_peserta_name' => $row['nama'],
            'kop_master_peserta_tgl_lahir' => date('Y-m-d',$UNIX_DATE),
            'kop_master_peserta_tempat_lahir' => $row['tempat'],
            'kop_master_peserta_jk' => $row['jenis_kelamin'],
            'kop_master_peserta_agama' => $row['agama'],
            'kop_master_peserta_alamat' => $row['alamat'],
            'kop_master_peserta_cabang' => $this->code,
            'kop_master_peserta_email' => $row['email'],
            'kop_master_peserta_no_hp' => $row['no_hp'],
            'kop_master_peserta_tgl_kerja' => now(),
            'kop_master_peserta_tgl_anggota' => now(),
            'kop_master_peserta_photo' => null,
            'kop_master_peserta_status' => 1,
            'created_at' => now(),
        ]);
    }
}
