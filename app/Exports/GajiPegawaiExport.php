<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GajiPegawaiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $deptCode;
    protected $search;
    protected $bulan;
    protected $tahun;

    public function __construct($deptCode = null, $search = null, $bulan = null, $tahun = null)
    {
        $this->deptCode = $deptCode;
        $this->search   = $search;
        $this->bulan    = $bulan ?? date('n');
        $this->tahun    = $tahun ?? date('Y');
    }

    public function collection()
    {
        $query = DB::table('hrm_master_pegawai as p')
            ->leftJoin('hrm_departemen as d', 'p.hrm_m_position_code', '=', 'd.hrm_departemen_code')
            ->select(
                'p.hrm_m_pegawai_code',
                'p.hrm_m_pegawai_nip',
                'p.hrm_m_pegawai_name',
                'p.hrm_m_position_code',
                'd.hrm_departemen_name',
                'd.hrm_departemen_lokasi'
            );

        if ($this->deptCode) {
            $query->where('d.hrm_departemen_code', $this->deptCode);
        }

        if ($this->search) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('p.hrm_m_pegawai_name', 'like', "%{$search}%")
                    ->orWhere('p.hrm_m_pegawai_nip', 'like', "%{$search}%")
                    ->orWhere('p.hrm_m_pegawai_nik', 'like', "%{$search}%");
            });
        }

        $pegawaiList = $query->get();

        $gajiPaidList = DB::table('hrm_penggajian')
            ->where('bulan', $this->bulan)
            ->where('tahun', $this->tahun)
            ->where('status', 'PAID')
            ->pluck('hrm_m_pegawai_code')
            ->toArray();

        return $pegawaiList->map(function ($p) use ($gajiPaidList) {
            $pegawaiKomponen = DB::table('hrm_pegawai_komponen as pk')
                ->join('hrm_komponen_gaji as k', 'pk.id_komponen', '=', 'k.id_komponen')
                ->where('pk.hrm_m_pegawai_code', $p->hrm_m_pegawai_code)
                ->where('k.is_active', true)
                ->select('k.tipe', 'pk.nominal')
                ->get();

            $totalPendapatan = 0;
            $totalPotongan   = 0;

            if ($pegawaiKomponen->isNotEmpty()) {
                foreach ($pegawaiKomponen as $pk) {
                    if ($pk->tipe === 'pendapatan') {
                        $totalPendapatan += floatval($pk->nominal);
                    } else {
                        $totalPotongan += floatval($pk->nominal);
                    }
                }
            } else {
                $defaultDept = DB::table('hrm_departemen_komponen as dk')
                    ->join('hrm_komponen_gaji as k', 'dk.id_komponen', '=', 'k.id_komponen')
                    ->where('dk.hrm_departemen_code', $p->hrm_m_position_code)
                    ->where('k.is_active', true)
                    ->select('k.tipe', 'dk.nominal_default')
                    ->get();

                foreach ($defaultDept as $dk) {
                    if ($dk->tipe === 'pendapatan') {
                        $totalPendapatan += floatval($dk->nominal_default);
                    } else {
                        $totalPotongan += floatval($dk->nominal_default);
                    }
                }
            }

            $p->total_pendapatan = $totalPendapatan;
            $p->total_potongan   = $totalPotongan;
            $p->thp              = $totalPendapatan - $totalPotongan;
            $p->is_paid          = in_array($p->hrm_m_pegawai_code, $gajiPaidList);

            return $p;
        });
    }

    public function headings(): array
    {
        return [
            'NIP',
            'Nama Pegawai',
            'Departemen',
            'Lokasi',
            'Total Pendapatan',
            'Total Potongan',
            'Take Home Pay (THP)',
            'Status Pembayaran',
        ];
    }

    public function map($row): array
    {
        return [
            $row->hrm_m_pegawai_nip,
            $row->hrm_m_pegawai_name,
            $row->hrm_departemen_name ?? '-',
            $row->hrm_departemen_lokasi ?? '-',
            $row->total_pendapatan,
            $row->total_potongan,
            $row->thp,
            $row->is_paid ? 'PAID' : 'UNPAID',
        ];
    }
}
