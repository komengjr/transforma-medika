<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Nota Setoran Keuangan - {{ $laporan->no_laporan }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 15px;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 11px;
        }

        .info-table,
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table td {
            padding: 4px 0;
            font-size: 11px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 5px 6px;
            text-align: left;
        }

        .data-table th {
            background-color: #f2f2f2;
            font-size: 10px;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="header">
        <h2>REKAPITULASI SETORAN KASIR KE KEUANGAN</h2>
        <p>Sistem Informasi Manajemen Rumah Sakit (SIMRS)</p>
    </div>

    <table class="info-table">
        <tr>
            <td style="width: 15%;"><strong>No. Laporan</strong></td>
            <td style="width: 35%;">: {{ $laporan->no_laporan }}</td>
            <td style="width: 15%;"><strong>Tanggal Cetak</strong></td>
            <td style="width: 35%;">: {{ date('d-m-Y H:i:s') }}</td>
        </tr>
        <tr>
            <td><strong>ID Petugas</strong></td>
            <td>: {{ Auth::user()->fullname }}</td>
            <td><strong>Status</strong></td>
            <td>: {{ $laporan->status_verifikasi }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 4%;">NO</th>
                <th>TGL REGISTRASI</th>
                <th>NO. REGISTRASI</th>
                <th>PID / PASIEN</th>
                <th>JENIS LAYANAN</th>
                <th>DOKTER</th>
                <th>METODE</th>
                <th class="text-end">NOMINAL (RP)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $index => $row)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <!-- Menampilkan Tanggal Registrasi -->
                <td>{{ date('d-m-Y H:i', strtotime($row->tanggal_registrasi)) }}</td>
                <td><strong>{{ $row->no_registrasi }}</strong></td>
                <td>{{ $row->pid }} - {{ $row->nama_pasien }}</td>
                <td>{{ str_replace('_', ' ', $row->jenis_layanan) }}</td>
                <td>{{ $row->nama_dokter ?? '-' }}</td>
                <td>{{ $row->metode_bayar }}</td>
                <td class="text-end">Rp {{ number_format($row->total_tagihan, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" class="text-end">TOTAL KESELURUHAN SETORAN:</th>
                <th class="text-end">Rp {{ number_format($laporan->total_setoran, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div style="display: flex; justify-content: space-between; margin-top: 40px; text-align: center;">
        <div style="width: 40%;">
            <p>Petugas Kasir / Pendaftaran</p>
            <br><br><br>
            <p><strong>( _____________________ )</strong></p>
        </div>
        <div style="width: 40%;">
            <p>Mengetahui, Bagian Keuangan (Accounting)</p>
            <br><br><br>
            <p><strong>( _____________________ )</strong></p>
        </div>
    </div>

</body>

</html>
