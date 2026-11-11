<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hasil Pemeriksaan Radiologi - {{ $code }}</title>
    <style>
        @page {
            margin: 15px 20px 20px 20px;
            size: A4 portrait;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #111111;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* HEADER KOP SURAT */
        .header-table {
            border: 1px solid #000000;
            margin-bottom: 8px;
        }

        .header-table td {
            vertical-align: middle;
            padding: 5px;
        }

        .logo-container {
            width: 130px;
            text-align: center;
            border-right: 1px solid #000000;
        }

        .logo-container img {
            max-width: 120px;
            max-height: 55px;
        }

        .hospital-info {
            text-align: center;
            padding: 0 10px;
        }

        .hospital-info h3 {
            margin: 0;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .hospital-info h4 {
            margin: 2px 0 0 0;
            font-size: 11px;
            font-weight: bold;
        }

        .hospital-info p {
            margin: 3px 0 0 0;
            font-size: 8px;
        }

        .qr-container {
            width: 80px;
            text-align: center;
            border-left: 1px solid #000000;
        }

        /* INFORMASI PASIEN */
        .title-section {
            font-weight: bold;
            font-size: 12px;
            color: #000000;
            margin-bottom: 4px;
        }

        .patient-table {
            margin-bottom: 12px;
            font-size: 10px;
        }

        .patient-table td {
            padding: 2px 3px;
            vertical-align: top;
        }

        /* TABEL HASIL EKSPERTISE */
        .card-result {
            border: 1px solid #000000;
            margin-bottom: 15px;
        }

        .table-result {
            width: 100%;
        }

        .table-result thead tr th {
            background-color: #f2f2f2;
            border-bottom: 1px solid #000000;
            padding: 6px;
            font-size: 10px;
            font-weight: bold;
            text-align: left;
        }

        .table-result tbody tr td {
            padding: 6px;
            font-size: 10px;
            border-bottom: 0.5px solid #e0e0e0;
        }

        .exam-title {
            background-color: #fafafa;
            font-weight: bold;
            font-size: 12px;
            color: #004085;
            border-bottom: 1px solid #cccccc !important;
            padding-top: 8px !important;
            padding-bottom: 8px !important;
        }

        .result-value {
            white-space: pre-line;
            line-height: 1.4;
            text-align: justify;
        }

        .section-title {
            font-weight: bold;
            font-size: 10px;
            color: #333333;
            margin-bottom: 2px;
            margin-top: 6px;
        }

        .impression-box {
            margin-top: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
        }

        /* FOOTER / TANDA TANGAN */
        .footer-section {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            width: 100%;
        }

        .table-footer td {
            vertical-align: bottom;
            font-size: 9px;
        }

        .note-text {
            font-size: 8px;
            color: #555555;
            line-height: 1.2;
        }
    </style>
</head>

<body>

    <!-- KOP SURAT HEADER -->
    <table class="header-table">
        <tr>
            <td class="logo-container">
                @if(!empty($image))
                <img src="data:image/png;base64, {{ $image }}" alt="Logo">
                @endif
                <div style="font-size: 8px; margin-top: 2px;">
                    Jl. Simulasi Sisingamangaraja No 98Z
                </div>
            </td>
            <td class="hospital-info">
                <h3>( TRANSFORMASI SISTEM INFORMASI MEDIKA )</h3>
                <h4>TRANSFORMA MEDIKA</h4>
                <p>RUMAH SAKIT TRANS MEDIKA BERJAYA</p>
            </td>
            <td class="qr-container">
                <img src="data:image/png;base64, {!! base64_encode(
                    QrCode::style('round')->eye('circle')->format('svg')->size(70)->errorCorrection('H')->generate($code)
                ) !!}" width="65">
            </td>
        </tr>
    </table>

    <!-- JUDUL HASIL & NO FORM -->
    <table style="width: 100%; margin-bottom: 5px;">
        <tr>
            <td class="title-section">HASIL PEMERIKSAAN RADIOLOGI</td>
            <td style="text-align: right; font-size: 9px; font-weight: bold;">
                RAD. 33-FRM-PU-03. 1/02
            </td>
        </tr>
    </table>
    <hr style="border: none; border-top: 1px solid #000000; margin-top: 0; margin-bottom: 8px;">

    <!-- BIODATA PASIEN -->
    <table class="patient-table">
        <tr>
            <td style="width: 12%;">No. Reg</td>
            <td style="width: 2%;">:</td>
            <td style="width: 36%; font-weight: bold;">{{ $data->no_registrasi ?? $code }}</td>

            <td style="width: 14%;">Tgl Registrasi</td>
            <td style="width: 2%;">:</td>
            <td style="width: 34%;">{{ date('d-m-Y H:i', strtotime($data->created_at ?? now())) }}</td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td style="font-weight: bold;">{{ $data->master_patient_name ?? '-' }}</td>

            <td>Pasien ID (RM)</td>
            <td>:</td>
            <td style="font-weight: bold;">{{ $data->master_patient_code ?? '-' }}</td>
        </tr>
        <tr>
            <td>Dokter Pengirim</td>
            <td>:</td>
            <td>{{ $data->dokter_rujukan ?? 'Dokter Rujukan / Luar' }}</td>

            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>
                @if (($data->master_patient_jk ?? '') == 'L') Laki - Laki
                @elseif (($data->master_patient_jk ?? '') == 'P') Perempuan
                @else - @endif
            </td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $data->master_patient_alamat ?? '-' }}</td>

            <td>Tgl Lahir</td>
            <td>:</td>
            <td>
                @if(!empty($data->master_patient_tgl_lahir))
                {{ date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) }}
                @else - @endif
            </td>
        </tr>
    </table>

    <!-- HASIL PEMERIKSAAN -->
    <div class="card-result">
        <table class="table-result">
            <thead>
                <tr>
                    <th style="width: 100%; text-align: center;">LAPORAN EKSPERTISE RADIOLOGI</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemeriksaanList as $pem)

                <!-- NAMA PEMERIKSAAN -->
                <tr>
                    <td class="exam-title" style="text-align: center; text-transform: uppercase;">
                        {{ $pem->nama_layanan }}
                    </td>
                </tr>

                <!-- KONTEN HASIL -->
                <tr>
                    <td style="padding: 12px;">

                        <!-- KLINIS & TEKNIK -->
                        <table style="width: 100%; margin-bottom: 8px;">
                            <tr>
                                <td style="width: 15%; vertical-align: top; font-weight: bold;">Klinis</td>
                                <td style="width: 2%; vertical-align: top;">:</td>
                                <td style="width: 83%; vertical-align: top;">{{ !empty($pem->klinis_indikasi) ? $pem->klinis_indikasi : '-' }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top; font-weight: bold;">Teknik Foto</td>
                                <td style="vertical-align: top;">:</td>
                                <td style="vertical-align: top;">{{ !empty($pem->teknik_pemeriksaan) ? $pem->teknik_pemeriksaan : '-' }}</td>
                            </tr>
                        </table>

                        <div style="border-top: 0.5px dashed #cccccc; margin: 8px 0;"></div>

                        <!-- DETAIL PARAMETER (Jika Ada) -->
                        @if(count($pem->details) > 0)
                        <table style="width: 100%; margin-bottom: 10px;">
                            @foreach ($pem->details as $det)
                            <tr>
                                <td style="width: 25%; vertical-align: top; font-weight: bold; padding-bottom: 4px;">{{ $det->nama_parameter }}</td>
                                <td style="width: 2%; vertical-align: top; padding-bottom: 4px;">:</td>
                                <td class="result-value" style="width: 73%; vertical-align: top; padding-bottom: 4px;">
                                    {!! nl2br(e($det->nilai_hasil ?? '-')) !!}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        @endif

                        <!-- KESAN / KESIMPULAN (SELALU DITAMPILKAN PALING BAWAH & TER-HIGHLIGHT) -->
                        <div class="impression-box">
                            <div class="section-title" style="font-size: 11px; text-decoration: underline; margin-bottom: 4px;">KESAN / KESIMPULAN:</div>
                            <div class="result-value" style="font-weight: bold;">
                                {!! !empty($pem->kesan_kesimpulan) ? nl2br(e($pem->kesan_kesimpulan)) : '-' !!}
                            </div>
                        </div>

                        <!-- SARAN -->
                        @if(!empty($pem->saran))
                        <div style="margin-top: 8px;">
                            <span style="font-weight: bold;">Saran:</span>
                            <span class="result-value">{!! nl2br(e($pem->saran)) !!}</span>
                        </div>
                        @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- FOOTER / TANDA TANGAN & VALIDASI -->
    <div class="footer-section">
        @php
        // Ambil data verifikasi dari item pertama
        $firstExam = $pemeriksaanList->first();
        $verifDate = !empty($firstExam->tanggal_verifikasi) ? date('d-m-Y H:i', strtotime($firstExam->tanggal_verifikasi)) : date('d-m-Y H:i');
        $radiologName = $firstExam->dokter_radiolog ?? (auth()->user()->name ?? 'Dr. Radiologi, Sp.Rad');
        @endphp

        <table class="table-footer" style="width: 100%;">
            <tr>
                <td style="width: 60%; text-align: left; vertical-align: bottom;">
                    <div class="note-text">
                        * Laporan ekspertise ini telah divalidasi secara elektronik dan sah tanpa tanda tangan basah.<br>
                        * Kesalahan interpretasi karena pencetakan kualitas rendah di luar tanggung jawab RS.<br><br>
                        <strong>Printed by:</strong> {{ auth()->user()->name ?? 'Operator' }} / {{ date('d-m-Y H:i') }}
                    </div>
                </td>

                <td style="width: 40%; text-align: center; vertical-align: bottom;">
                    <p style="margin: 0 0 4px 0; font-weight: bold;">Dokter Spesialis Radiologi</p>

                    <!-- QR VALIDASI -->
                    <img src="data:image/png;base64, {!! base64_encode(
                        QrCode::style('round')->eye('circle')->format('svg')->size(60)->errorCorrection('H')->generate($reg . ' | Validated By: ' . $radiologName . ' | Date: ' . $verifDate)
                    ) !!}" width="60" height="60">

                    <p style="margin: 4px 0 0 0; font-weight: bold; font-size: 10px;">
                        <u>{{ $radiologName }}</u>
                    </p>
                    <p style="margin: 0; font-size: 8px;">Telah Diverifikasi Tgl: {{ $verifDate }}</p>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
