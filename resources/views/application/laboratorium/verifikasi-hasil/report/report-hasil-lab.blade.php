<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hasil Pemeriksaan Laboratorium - {{ $reg }}</title>
    <style>
        @page {
            margin: 20px 25px 20px 25px;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #222222;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-muted {
            color: #666666;
        }

        .text-danger {
            color: #d9534f;
        }

        .text-primary {
            color: #1a5bb8;
        }

        /* KOP SURAT */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #1a5bb8;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .header-logo {
            width: 130px;
            vertical-align: middle;
        }

        .header-title {
            text-align: center;
            vertical-align: middle;
        }

        .header-title h2 {
            margin: 0;
            font-size: 15px;
            color: #1a5bb8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header-title h3 {
            margin: 3px 0 0 0;
            font-size: 13px;
            color: #333333;
        }

        .header-title p {
            margin: 3px 0 0 0;
            font-size: 9px;
            color: #666666;
        }

        .header-qr {
            width: 80px;
            text-align: right;
            vertical-align: middle;
        }

        /* BAR TITLE */
        .doc-title {
            background-color: #f0f4f9;
            border-left: 4px solid #1a5bb8;
            padding: 6px 10px;
            margin-bottom: 12px;
        }

        .doc-title table {
            width: 100%;
        }

        /* INFORMASI PASIEN */
        .patient-info-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .patient-info-table td {
            padding: 3px 4px;
            vertical-align: top;
            font-size: 10.5px;
        }

        .patient-info-table .label {
            color: #555555;
            width: 15%;
        }

        .patient-info-table .separator {
            width: 2%;
            text-align: center;
        }

        .patient-info-table .value {
            font-weight: bold;
            width: 33%;
        }

        /* TABEL HASIL LAB */
        .lab-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .lab-table th {
            background-color: #1a5bb8;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            padding: 6px 8px;
            font-size: 10px;
            border: 1px solid #1a5bb8;
        }

        .lab-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 10px;
        }

        .lab-table tr {
            page-break-inside: avoid;
        }

        .lab-table tr.main-category-row td {
            background-color: #f0f4f9;
            color: #1a5bb8;
            font-weight: bold;
            padding: 6px 8px;
            font-size: 10.5px;
            border-bottom: 1px solid #c8d9f1;
        }

        .lab-table tr.parent-header-row td {
            background-color: #f8fafc;
            font-weight: bold;
            color: #222222;
            padding: 6px 8px;
            border-bottom: 1px solid #e0e0e0;
        }

        .lab-table tr.child-row td {
            background-color: #ffffff;
        }

        .child-prefix {
            color: #888888;
            font-family: monospace, sans-serif;
            margin-right: 4px;
        }

        /* FOOTER */
        .footer-container {
            width: 100%;
            margin-top: 20px;
            page-break-inside: avoid;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            vertical-align: bottom;
        }

        .notes-card {
            border: 1px dashed #cccccc;
            background-color: #fafafa;
            padding: 8px;
            font-size: 9px;
            color: #555555;
            border-radius: 4px;
        }

        .signature-box {
            text-align: center;
        }

        .signature-box p {
            margin: 2px 0;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <!-- KOP SURAT / HEADER -->
    <table class="header-table">
        <tr>
            <td class="header-logo">
                <img src="data:image/png;base64, {{ $image }}" width="120" alt="Logo">
            </td>
            <td class="header-title">
                <h2>TRANSFORMA MEDIKA</h2>
                <h3>RUMAH SAKIT ASUPAN BERTENAGA</h3>
                <p>Jl. Simulasi Kecamatan Singsingamaraja No. 98Z | Telp: (021) 12345678</p>
            </td>
            <td class="header-qr">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::style('round')->eye('circle')->format('svg')->size(75)->errorCorrection('H')->generate($reg)) !!}" width="75" alt="QR Code">
            </td>
        </tr>
    </table>

    <!-- BAR TITLE DOKUMEN -->
    <div class="doc-title">
        <table>
            <tr>
                <td class="fw-bold text-primary" style="font-size: 12px;">HASIL PEMERIKSAAN LABORATORIUM</td>
                <td class="text-right text-muted" style="font-size: 9.5px;">No. Form: LAB. 33-FRM-PU-03.1/02</td>
            </tr>
        </table>
    </div>

    <!-- INFORMASI PASIEN -->
    <table class="patient-info-table">
        <tr>
            <td class="label">No. Registrasi</td>
            <td class="separator">:</td>
            <td class="value text-primary">{{ $reg }}</td>

            <td class="label">Tgl. Registrasi</td>
            <td class="separator">:</td>
            <td class="value">
                {{ !empty($data->tanggal_registrasi) ? date('d-m-Y', strtotime($data->tanggal_registrasi)) : date('d-m-Y') }}
            </td>
        </tr>
        <tr>
            <td class="label">Nama Pasien</td>
            <td class="separator">:</td>
            <td class="value">{{ $data->nama_pasien }}</td>

            <td class="label">ID Pasien / RM</td>
            <td class="separator">:</td>
            <td class="value">{{ $data->rm_pasien }}</td>
        </tr>
        <tr>
            <td class="label">Dokter Pengirim</td>
            <td class="separator">:</td>
            <td class="value">{{ $data->dokter ?? '-' }}</td>

            <td class="label">Jenis Kelamin</td>
            <td class="separator">:</td>
            <td class="value">
                {{ (strtolower($data->jk_pasien) == 'l' || strtolower($data->jk_pasien) == 'laki-laki') ? 'Laki-Laki' : 'Perempuan' }}
            </td>
        </tr>
        <tr>
            <td class="label">Alamat Pasien</td>
            <td class="separator">:</td>
            <td class="value">{{ $data->alamat_pasien ?? '-' }}</td>

            <td class="label">Tanggal Lahir</td>
            <td class="separator">:</td>
            <td class="value">
                {{ !empty($data->tgl_lahir_pasien) ? date('d-m-Y', strtotime($data->tgl_lahir_pasien)) : '-' }}
            </td>
        </tr>
    </table>

    <!-- TABEL PEMERIKSAAN RESULT -->
    <table class="lab-table">
        <thead>
            <tr>
                <th class="text-left" style="width: 35%;">JENIS PEMERIKSAAN</th>
                <th class="text-center" style="width: 15%;">HASIL</th>
                <th class="text-center" style="width: 18%;">NILAI RUJUKAN</th>
                <th class="text-center" style="width: 12%;">SATUAN</th>
                <th class="text-left" style="width: 20%;">METODE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pemeriksaan as $pem)
            <!-- Header Utama Kelompok Pemeriksaan -->
            <tr class="main-category-row">
                <td colspan="5">
                    <span style="text-transform: uppercase;">{{ $pem->nama_layanan }}</span>
                </td>
            </tr>

            @php
            $parameters = DB::table('medical_master_parameter')
            ->where('master_pemeriksaan_id', $pem->master_pemeriksaan_id)
            ->whereNull('parent_id')
            ->orderBy('urutan', 'ASC')
            ->get();
            @endphp

            @foreach ($parameters as $param)
            @if ($param->is_group == 1)
            {{-- CASE 1: JIKA INI KEPALA (Misal: Hitung Jenis) --}}
            <tr class="parent-header-row">
                <td colspan="5">
                    <strong>{{ $param->nama_parameter }}</strong>
                </td>
            </tr>

            @php
            $subParams = DB::table('medical_master_parameter')
            ->where('parent_id', $param->id)
            ->orderBy('urutan', 'ASC')
            ->get();
            @endphp

            @foreach ($subParams as $sub)
            @php
            $nilai = DB::table('medical_transaksi_hasil')
            ->where('detail_id', $pem->detail_id)
            ->where('parameter_id', $sub->id)
            ->first();

            // Logika Auto-Detect Abnormal (Merah)
            $isAbnormal = false;
            if ($nilai && !empty($nilai->hasil)) {
            // 1. Cek dari Flag manual yang diisi petugas
            if (in_array($nilai->flag, ['H', 'L', 'A'])) {
            $isAbnormal = true;
            }
            // 2. Jika tidak ada flag, cek otomatis dari rentang angka (Misal: 3,80 - 5,20)
            elseif (!empty($sub->nilai_normal)) {
            $rujukan = str_replace(',', '.', $sub->nilai_normal);
            $hasilAngka = (float) str_replace(',', '.', $nilai->hasil);

            if (strpos($rujukan, '-') !== false) {
            $parts = explode('-', $rujukan);
            if (count($parts) == 2) {
            $min = (float) trim($parts[0]);
            $max = (float) trim($parts[1]);
            if ($hasilAngka < $min || $hasilAngka> $max) {
                $isAbnormal = true;
                }
                }
                }
                }
                }
                @endphp
                <tr class="child-row">
                    <td style="padding-left: 22px;">
                        <span class="child-prefix">-</span>
                        <span>{{ $sub->nama_parameter }}</span>
                    </td>
                    <td class="text-center fw-bold">
                        @if($nilai && !empty($nilai->hasil))
                        <!-- Jika abnormal berikan class text-danger (merah) -->
                        <span class="{{ $isAbnormal ? 'text-danger' : '' }}">{{ $nilai->hasil }}</span>
                        @else
                        <span class="text-danger" style="font-style: italic;">Belum</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $sub->nilai_normal ?? '-' }}</td>
                    <td class="text-center">{{ $sub->satuan ?? '-' }}</td>
                    <td class="text-left">{{ $sub->metode ?? '-' }}</td>
                </tr>
                @endforeach

                @else
                {{-- CASE 2: PARAMETER TUNGGAL (Misal: Hemoglobin) --}}
                @php
                $nilai = DB::table('medical_transaksi_hasil')
                ->where('detail_id', $pem->detail_id)
                ->where('parameter_id', $param->id)
                ->first();

                // Logika Auto-Detect Abnormal (Merah)
                $isAbnormal = false;
                if ($nilai && !empty($nilai->hasil)) {
                if (in_array($nilai->flag, ['H', 'L', 'A'])) {
                $isAbnormal = true;
                } elseif (!empty($param->nilai_normal)) {
                $rujukan = str_replace(',', '.', $param->nilai_normal);
                $hasilAngka = (float) str_replace(',', '.', $nilai->hasil);

                if (strpos($rujukan, '-') !== false) {
                $parts = explode('-', $rujukan);
                if (count($parts) == 2) {
                $min = (float) trim($parts[0]);
                $max = (float) trim($parts[1]);
                if ($hasilAngka < $min || $hasilAngka> $max) {
                    $isAbnormal = true;
                    }
                    }
                    }
                    }
                    }
                    @endphp
                    <tr>
                        <td>
                            <span class="fw-bold">{{ $param->nama_parameter }}</span>
                        </td>
                        <td class="text-center fw-bold">
                            @if($nilai && !empty($nilai->hasil))
                            <!-- Jika abnormal berikan class text-danger (merah) -->
                            <span class="{{ $isAbnormal ? 'text-danger' : '' }}">{{ $nilai->hasil }}</span>
                            @else
                            <span class="text-danger" style="font-style: italic;">Belum</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $param->nilai_normal ?? '-' }}</td>
                        <td class="text-center">{{ $param->satuan ?? '-' }}</td>
                        <td class="text-left">{{ $param->metode ?? '-' }}</td>
                    </tr>
                    @endif
                    @endforeach
                    @endforeach
        </tbody>
    </table>

    <!-- FOOTER / TANDA TANGAN -->
    <div class="footer-container">
        <table class="footer-table">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <div class="notes-card">
                        <strong class="text-primary">Informasi Layanan:</strong>
                        <p style="margin: 3px 0 6px 0; line-height: 1.4;">
                            Hasil laboratorium ini dapat diakses secara online melalui Web Resmi kami atau Email terdaftar.<br>
                            Dokumen terenkripsi dengan password menggunakan format: <strong>DDMMYYYY</strong> (Tgl. Lahir Pasien).
                        </p>
                        <span class="text-muted" style="font-size: 8.5px;">
                            Dicetak pada {{ date('d-m-Y H:i:s') }} WIB
                        </span>
                    </div>
                </td>

                <td style="width: 40%;" class="signature-box">
                    <p class="fw-bold">Petugas Validasi,</p>
                    <div style="margin: 6px 0;">
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::style('round')->eye('circle')->format('svg')->size(55)->errorCorrection('H')->generate($reg)) !!}" width="55" alt="Validation Stamp">
                    </div>
                    <p class="fw-bold text-primary" style="text-decoration: underline;">Penanggung Jawab Lab</p>
                    <p class="text-muted" style="font-size: 8px;">SIP: 446/LAB/{{ date('Y') }}</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
