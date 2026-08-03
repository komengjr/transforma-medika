<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hasil Pemeriksaan Laboratorium - {{ $code }}</title>
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

        /* HELPER STYLES */
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

        /* HEADER / KOP SURAT */
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

        /* TITLE DOKUMEN */
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

        /* Header Kelompok Utama (Judul Besar) */
        .lab-table tr.main-category-row td {
            background-color: #f0f4f9;
            color: #1a5bb8;
            font-weight: bold;
            padding: 6px 8px;
            font-size: 10.5px;
            border-bottom: 1px solid #c8d9f1;
        }

        /* Sub-Header / Kepala (t_pem_list_val_opt = Y) */
        .lab-table tr.parent-header-row td {
            background-color: #f8fafc;
            font-weight: bold;
            color: #222222;
            padding: 6px 8px;
            border-bottom: 1px solid #e0e0e0;
        }

        /* Anak (Child Row) */
        .lab-table tr.child-row td {
            background-color: #ffffff;
        }

        .child-prefix {
            color: #888888;
            font-family: monospace, sans-serif;
            margin-right: 4px;
        }

        /* FOOTER & TANDA TANGAN */
        .footer-container {
            width: 100%;
            margin-top: 20px;
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
                <img src="data:image/png;base64, {!! base64_encode(QrCode::style('round')->eye('circle')->format('svg')->size(75)->errorCorrection('H')->generate($code)) !!}" width="75" alt="QR Code">
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
            <td class="value text-primary">{{ $code }}</td>

            <td class="label">Tgl. Registrasi</td>
            <td class="separator">:</td>
            <td class="value">
                {{ !empty($reg->d_reg_order_lab_date) ? date('d-m-Y', strtotime($reg->d_reg_order_lab_date)) : date('d-m-Y') }}
            </td>
        </tr>
        <tr>
            <td class="label">Nama Pasien</td>
            <td class="separator">:</td>
            <td class="value">{{ $data->master_patient_name }}</td>

            <td class="label">ID Pasien / RM</td>
            <td class="separator">:</td>
            <td class="value">{{ $data->master_patient_code }}</td>
        </tr>
        <tr>
            <td class="label">Dokter Pengirim</td>
            <td class="separator">:</td>
            <td class="value">{{ $reg->d_reg_order_lab_rujukan ?? '-' }}</td>

            <td class="label">Jenis Kelamin</td>
            <td class="separator">:</td>
            <td class="value">
                {{ ($data->master_patient_jk == 'L' || $data->master_patient_jk == 'Laki-laki') ? 'Laki-Laki' : 'Perempuan' }}
            </td>
        </tr>
        <tr>
            <td class="label">Alamat Pasien</td>
            <td class="separator">:</td>
            <td class="value">{{ $data->master_patient_alamat ?? '-' }}</td>

            <td class="label">Tanggal Lahir</td>
            <td class="separator">:</td>
            <td class="value">
                {{ !empty($data->master_patient_tgl_lahir) ? date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}
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
                    <span style="text-transform: uppercase;">{{ $pem->t_pemeriksaan_list_name }}</span>
                </td>
            </tr>

            @php
            $sub = DB::table('t_pemeriksaan_list_val')
            ->where('t_pemeriksaan_list_code', $pem->t_pemeriksaan_list_code)
            ->get();
            @endphp

            @foreach ($sub as $subs)
            @php
            // Cek apakah item ini merupakan anak (memiliki t_pem_list_val_opt_code)
            $is_child = !empty($subs->t_pem_list_val_opt_code);
            @endphp

            {{-- CASE 1: JIKA INI KEPALA / PARENT (t_pem_list_val_opt == 'Y') --}}
            @if ($subs->t_pem_list_val_opt == 'Y')
            <tr class="parent-header-row">
                <td colspan="5">
                    <strong>{{ $subs->t_pem_list_val_name }}</strong>
                </td>
            </tr>

            {{-- CASE 2: ITEM BARIS HASIL (Anak atau Parameter Mandiri) --}}
            @else
            @php
            $nilai = DB::table('h_reg_lab')
            ->where('d_reg_order_lab_code', $reg->d_reg_order_lab_code)
            ->where('t_pem_list_val_code', $subs->t_pem_list_val_code)
            ->first();
            @endphp

            <tr class="{{ $is_child ? 'child-row' : '' }}">
                <!-- Kolom Nama Jenis Pemeriksaan -->
                <td style="{{ $is_child ? 'padding-left: 22px;' : '' }}">
                    @if ($is_child)
                    <!-- Indikator Anak -->
                    <span class="child-prefix">-</span>
                    @endif
                    <span class="{{ !$is_child ? 'fw-bold' : '' }}">
                        {{ $subs->t_pem_list_val_name }}
                    </span>
                </td>

                <!-- Kolom Hasil -->
                <td class="text-center fw-bold">
                    @if ($nilai && !empty($nilai->h_reg_lab_value))
                    {{ $nilai->h_reg_lab_value }}
                    @else
                    <span class="text-danger" style="font-style: italic;">Belum</span>
                    @endif
                </td>

                <!-- Nilai Rujukan -->
                <td class="text-center">{{ $subs->t_pem_list_val_rujukan ?? '-' }}</td>

                <!-- Satuan -->
                <td class="text-center">{{ $subs->t_pem_list_val_satuan ?? '-' }}</td>

                <!-- Metode -->
                <td class="text-left">
                    @if ($nilai && !empty($nilai->h_reg_lab_metode))
                    {{ $nilai->h_reg_lab_metode }}
                    @else
                    <span class="text-muted" style="font-style: italic;">-</span>
                    @endif
                </td>
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
                            Jika ada pertanyaan, silakan hubungi Customer Service RS.
                        </p>
                        <span class="text-muted" style="font-size: 8.5px;">
                            Dicetak oleh: <strong>agus</strong> pada {{ date('d-m-Y H:i:s') }} WIB
                        </span>
                    </div>
                </td>

                <td style="width: 40%;" class="signature-box">
                    <p class="fw-bold">Petugas Validasi,</p>
                    <div style="margin: 6px 0;">
                        <img src="data:image/png;base64, {!! base64_encode(QrCode::style('round')->eye('circle')->format('svg')->size(55)->errorCorrection('H')->generate($code)) !!}" width="55" alt="Validation Stamp">
                    </div>
                    <p class="fw-bold text-primary" style="text-decoration: underline;">Penanggung Jawab Lab</p>
                    <p class="text-muted" style="font-size: 8px;">SIP: 446/LAB/{{ date('Y') }}</p>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
