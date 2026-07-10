<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinMasterCoa;

class CoaSeeder extends Seeder
{
    public function run(): void
    {
        $coas = [
            // ASET (Normal Balance: Debit)
            [
                'coa_code' => '1111',
                'coa_name' => 'Kas dan Bank Koperasi',
                'coa_type' => 'aset',
                'normal_balance' => 'debit'
            ],
            [
                'coa_code' => '1121',
                'coa_name' => 'Piutang Pinjaman Uang Anggota',
                'coa_type' => 'aset',
                'normal_balance' => 'debit'
            ],
            [
                'coa_code' => '1122',
                'coa_name' => 'Piutang Pinjaman Barang Anggota',
                'coa_type' => 'aset',
                'normal_balance' => 'debit'
            ],

            // PENDAPATAN (Normal Balance: Kredit)
            [
                'coa_code' => '4201',
                'coa_name' => 'Pendapatan Administrasi Pinjaman',
                'coa_type' => 'pendapatan',
                'normal_balance' => 'kredit'
            ],

            // BEBAN (Normal Balance: Debit)
            [
                'coa_code' => '5501',
                'coa_name' => 'Beban Voucher Koperasi / Promosi',
                'coa_type' => 'beban',
                'normal_balance' => 'debit'
            ],
            // KEWAJIBAN / LIABILITAS (Normal Balance: Kredit)
            [
                'coa_code' => '2141',
                'coa_name' => 'Hutang Arisan Anggota',
                'coa_type' => 'kewajiban',
                'normal_balance' => 'kredit'
            ],

            // PENDAPATAN (Normal Balance: Kredit)
            [
                'coa_code' => '4202',
                'coa_name' => 'Pendapatan Jasa Pengelolaan Arisan',
                'coa_type' => 'pendapatan',
                'normal_balance' => 'kredit'
            ],
            // ASET / AKTIVA (Normal Balance: Debit)
            [
                'coa_code' => '1131',
                'coa_name' => 'Persediaan Barang Koperasi',
                'coa_type' => 'aset',
                'normal_balance' => 'debit'
            ],
            [
                'coa_code' => '4101',
                'coa_name' => 'Pendapatan Bunga / Jasa Pinjaman',
                'coa_type' => 'pendapatan',
                'normal_balance' => 'kredit'
            ],
        ];

        foreach ($coas as $coa) {
            FinMasterCoa::updateOrCreate(['coa_code' => $coa['coa_code']], $coa);
        }
    }
}
