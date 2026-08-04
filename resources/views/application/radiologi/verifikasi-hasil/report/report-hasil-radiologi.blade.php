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
            font-size: 11px;
            color: #004085;
            border-bottom: 1px solid #cccccc !important;
        }

        .result-value {
            white-space: pre-line;
            line-height: 1.4;
            font-family: 'Courier', monospace, sans-serif;
        }

        /* FOOTER / TANDA TANGAN */
        .footer-section {
            position: fixed;
            bottom: 0;
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
            <td style="width: 36%; font-weight: bold;">{{ $code }}</td>

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
            <td>
                @php
                $dokter = DB::table('master_doctor')->where('master_doctor_code', $reg->d_reg_order_rad_dr_rujukan ?? null)->first();
                @endphp
                {{ $dokter->master_doctor_name ?? 'Dokter Rujukan / Luar' }}
            </td>

            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>
                @if (($data->master_patient_jk ?? '') == 'L')
                Laki - Laki
                @elseif (($data->master_patient_jk ?? '') == 'P')
                Perempuan
                @else
                -
                @endif
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
                @else
                -
                @endif
            </td>
        </tr>
    </table>

    <!-- HASIL PEMERIKSAAN -->
    <div class="card-result">
        <table class="table-result">
            <thead>
                <tr>
                    <th style="width: 35%;">JENIS PEMERIKSAAN / PARAMETER</th>
                    <th style="width: 65%;">HASIL EKSPERTISE / DESKRIPSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemeriksaan as $pem)
                <!-- BARIS NAMA PEMERIKSAAN / EXAMINATION NAME -->
                <tr>
                    <td colspan="2" class="exam-title">
                        {{ $pem->t_pemeriksaan_list_name ?? $pem->p_sales_data_name ?? 'Pemeriksaan Radiologi' }}
                    </td>
                </tr>

                @php
                // Ambil sub-parameter jika ada
                $sub = DB::table('t_pemeriksaan_list_val')
                ->where('t_pemeriksaan_list_code', $pem->t_pemeriksaan_list_code ?? '')
                ->get();

                // Query data hasil dari h_reg_rad
                $hRegRad = DB::table('h_reg_rad')
                ->where('order_rad_list_code', $pem->order_rad_list_code ?? $code)
                ->get();
                @endphp

                @if($sub->count() > 0)
                @foreach ($sub as $subs)
                @php
                $valResult = $hRegRad->firstWhere('t_pem_list_val_code', $subs->t_pem_list_val_code);
                $textHasil = $valResult->h_reg_rad_value ?? '- Belum Ada Hasil -';
                @endphp
                <tr>
                    <td style="vertical-align: top; font-weight: bold; padding-left: 12px;">
                        {{ $subs->t_pem_list_val_name }}
                    </td>
                    <td class="result-value">
                        {!! nl2br(e($textHasil)) !!}
                    </td>
                </tr>
                @endforeach
                @else
                <!-- JIKA TIDAK ADA SUB-PARAMETER, TAMPILKAN HASIL UTAMA -->
                @php
                $valResult = $hRegRad->first();
                $textHasil = $valResult->h_reg_rad_value ?? '- Belum Ada Hasil -';
                @endphp
                <tr>
                    <td style="vertical-align: top; font-weight: bold; padding-left: 12px;">
                        Deskripsi Hasil
                    </td>
                    <td class="result-value">
                        {!! nl2br(e($textHasil)) !!}
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- FOOTER / TANDA TANGAN & VALIDASI -->
    <div class="footer-section">
        <table class="table-footer" style="width: 100%;">
            <tr>
                <td style="width: 60%; text-align: left; vertical-align: bottom;">
                    <div class="note-text">
                        * Hasil pemeriksaan ini dibuat dan divalidasi secara elektronik.<br>
                        * Informasi lebih lanjut dapat menghubungi Customer Service kami.<br><br>
                        <strong>Printed by:</strong> {{ auth()->user()->name ?? 'Operator' }} / {{ date('d-m-Y H:i:s') }} / {{ $code }}
                    </div>
                </td>

                <td style="width: 40%; text-align: center; vertical-align: bottom;">
                    <p style="margin: 0 0 4px 0; font-weight: bold;">Dokter Penanggung Jawab / Radiolog</p>

                    <!-- QR VALIDASI -->
                    <img src="data:image/png;base64, {!! base64_encode(
                        QrCode::style('round')->eye('circle')->format('svg')->size(55)->errorCorrection('H')->generate($code . ' | Validated By Radiologist')
                    ) !!}" width="55" height="55">

                    <p style="margin: 4px 0 0 0; font-weight: bold; font-size: 10px;">
                        <u>{{ auth()->user()->name ?? 'Dr. Radiologi, Sp.Rad' }}</u>
                    </p>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
