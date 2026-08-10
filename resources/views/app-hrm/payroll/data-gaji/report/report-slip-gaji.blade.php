<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $pegawai->hrm_m_pegawai_name }}</title>
    <style>
        @page {
            margin: 20px 25px;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.4;
        }

        .header-table {
            width: 100%;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 8px;
            margin-bottom: 2px;
        }

        .company-title {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .company-subtitle {
            font-size: 9px;
            color: #64748b;
        }

        .doc-title {
            font-size: 11px;
            font-weight: bold;
            color: #0284c7;
            text-align: right;
            text-transform: uppercase;
        }

        .info-table {
            width: 100%;
            margin-bottom: 0px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .main-table th {
            background-color: #f1f5f9;
            color: #0f172a;
            text-align: left;
            padding: 6px 8px;
            font-size: 8px;
            text-transform: uppercase;
            border-top: 1px solid #cbd5e1;
            border-bottom: 1px solid #cbd5e1;
        }

        .main-table td {
            padding: 0;
        }

        .sub-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sub-table td {
            padding: 4px 8px;
            border: none;
        }

        .total-row {
            background-color: #f8fafc;
            font-weight: bold;
        }

        .total-row td {
            border-top: 1px solid #cbd5e1;
            padding: 6px 8px;
        }

        .thp-box {
            background-color: #f0f9ff;
            border: 1px solid #bae6fd;
            padding: 10px;
            text-align: center;
            border-radius: 4px;
            margin-bottom: 25px;
        }

        .thp-label {
            font-size: 8px;
            color: #0369a1;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .thp-value {
            font-size: 12px;
            color: #0284c7;
            font-weight: bold;
            margin-top: 2px;
        }

        .signature-table {
            width: 100%;
            margin-top: 10px;
        }

        .signature-table td {
            text-align: center;
            vertical-align: bottom;
            height: 65px;
        }
    </style>
</head>

<body>

    {{-- Header Kop Surat --}}
    <table class="header-table">
        <tr>
            <td width="60%">
                <div class="company-title">{{ env('APP_NAME', 'PT. HARAPAN BARU') }}</div>
                <div class="company-subtitle">Human Resource Management System - Financial & Payroll Module</div>
            </td>
            <td width="40%" class="doc-title">
                SLIP GAJI PEGAWAI
            </td>
        </tr>
    </table>

    {{-- Informasi Pegawai --}}
    <table class="info-table">
        <tr>
            <td width="15%" class="font-bold">NIP / NIK</td>
            <td width="35%">: {{ $pegawai->hrm_m_pegawai_nip ?? '-' }} / {{ $pegawai->hrm_m_pegawai_nik ?? '-' }}</td>
            <td width="15%" class="font-bold">Departemen</td>
            <td width="35%">: {{ $pegawai->hrm_departemen_name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="font-bold">Nama Pegawai</td>
            <td>: {{ $pegawai->hrm_m_pegawai_name }}</td>
            <td class="font-bold">Lokasi Kerja</td>
            <td>: {{ $pegawai->hrm_departemen_lokasi ?? '-' }}</td>
        </tr>
        <tr>
            <td class="font-bold">Bank / Rekening</td>
            <td>: {{ $gaji->nama_bank ?? '-' }} ({{ $gaji->nomor_rekening ?? '-' }})</td>
            <td class="font-bold">Tanggal Cetak</td>
            <td>: {{ date('d F Y') }}</td>
        </tr>
    </table>

    {{-- Rincian Penerimaan & Potongan Dinamis --}}
    <table class="main-table">
        <thead>
            <tr>
                <th width="50%">PENERIMAAN (PENDAPATAN)</th>
                <th width="50%">POTONGAN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                {{-- Column Pendapatan --}}
                <td style="vertical-align: top; border-right: 1px solid #f1f5f9; font-size: 8px;">
                    <table class="sub-table">
                        @php $totalPendapatan = 0; @endphp
                        @forelse($komponens->where('tipe', 'pendapatan') as $k)
                        @php $totalPendapatan += floatval($k->nominal); @endphp
                        <tr>
                            <td>{{ $k->nama_komponen }}</td>
                            <td class="text-right">Rp {{ number_format($k->nominal, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" style="color: #94a3b8; font-style: italic;">Tidak ada komponen pendapatan</td>
                        </tr>
                        @endforelse
                    </table>
                </td>

                {{-- Column Potongan --}}
                <td style="vertical-align: top; font-size: 8px;">
                    <table class="sub-table">
                        @php $totalPotongan = 0; @endphp
                        @forelse($komponens->where('tipe', 'potongan') as $k)
                        @php $totalPotongan += floatval($k->nominal); @endphp
                        <tr>
                            <td>{{ $k->nama_komponen }}</td>
                            <td class="text-right">Rp {{ number_format($k->nominal, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" style="color: #94a3b8; font-style: italic;">Tidak ada komponen potongan</td>
                        </tr>
                        @endforelse
                    </table>
                </td>
            </tr>

            {{-- Total Baris --}}
            <tr class="total-row">
                <td style="border-right: 1px solid #cbd5e1;">
                    <table class="sub-table">
                        <tr>
                            <td>TOTAL PENERIMAAN</td>
                            <td class="text-right" style="color: #059669;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table class="sub-table">
                        <tr>
                            <td>TOTAL POTONGAN</td>
                            <td class="text-right" style="color: #dc2626;">Rp {{ number_format($totalPotongan, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- Take Home Pay (THP) Card --}}
    @php $thp = $totalPendapatan - $totalPotongan; @endphp
    <div class="thp-box">
        <div class="thp-label">Penerimaan Bersih / Take Home Pay (THP)</div>
        <div class="thp-value">Rp {{ number_format($thp, 0, ',', '.') }}</div>
    </div>

    {{-- Tanda Tangan --}}
    <table class="signature-table">
        <tr>
            <td width="50%">
                Penerima,
                <br><br><br><br>
                <b>( {{ $pegawai->hrm_m_pegawai_name }} )</b>
            </td>
            <td width="50%">
                Disetujui Oleh,
                <br><br><br><br>
                <b>( {{ $pegawai->hrm_departemen_kepala ?? 'HRD / Finance Manager' }} )</b>
            </td>
        </tr>
    </table>

</body>

</html>
