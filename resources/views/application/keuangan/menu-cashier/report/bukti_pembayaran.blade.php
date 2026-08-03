<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice Pembayaran - {{ $order->d_reg_order_code }}</title>
    <style>
        @page {
            margin: 18px 22px;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, 'DejaVu Sans', Arial, sans-serif;
            font-size: 8.5pt;
            color: #1e293b;
            line-height: 1.35;
        }

        /* Font khusus format Angka / Akuntansi */
        .accounting-font {
            font-family: 'Courier New', Courier, 'Lucida Console', monospace;
            font-weight: bold;
            letter-spacing: -0.5px;
        }

        /* Header Section */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2.5px solid #0f172a;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .company-name {
            font-size: 13pt;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .company-sub {
            font-size: 7.5pt;
            color: #64748b;
            margin-top: 2px;
        }

        .invoice-title-box {
            text-align: right;
            vertical-align: top;
        }

        .invoice-title-box h2 {
            margin: 0;
            font-size: 14pt;
            font-weight: 800;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .status-badge {
            display: inline-block;
            background-color: #16a34a;
            color: #ffffff;
            font-size: 7pt;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 3px;
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Metadata & Info Section */
        .info-container {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
        }

        .info-container td {
            padding: 8px 10px;
            vertical-align: top;
            width: 50%;
        }

        .info-block-title {
            font-size: 7pt;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 5px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 2px;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
        }

        .meta-table td {
            padding: 2px 0;
            font-size: 8pt;
        }

        .meta-label {
            color: #475569;
            width: 85px;
        }

        .meta-value {
            font-weight: bold;
            color: #0f172a;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .items-table th {
            background-color: #1e293b;
            color: #ffffff;
            text-transform: uppercase;
            font-size: 7pt;
            font-weight: bold;
            padding: 6px 8px;
            border: 1px solid #1e293b;
            text-align: left;
            letter-spacing: 0.5px;
        }

        .items-table td {
            padding: 5px 8px;
            border-bottom: 1px solid #e2e8f0;
            border-left: 1px solid #f1f5f9;
            border-right: 1px solid #f1f5f9;
            font-size: 8pt;
        }

        .items-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* Financial Summary Box */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .summary-notes {
            width: 55%;
            vertical-align: top;
            padding-right: 15px;
            font-size: 7.5pt;
            color: #64748b;
        }

        .summary-calculation {
            width: 45%;
            vertical-align: top;
        }

        .calc-table {
            width: 100%;
            border-collapse: collapse;
        }

        .calc-table td {
            padding: 3px 6px;
            font-size: 8pt;
        }

        .calc-label {
            text-align: right;
            color: #475569;
            font-weight: 500;
        }

        .calc-value {
            text-align: right;
            width: 110px;
        }

        /* Accounting Grand Total Box */
        .grand-total-row td {
            border-top: 1.5px solid #0f172a;
            border-bottom: 3.5px double #0f172a;
            /* Garis ganda khas standar akuntansi */
            padding: 6px 6px !important;
            background-color: #f1f5f9;
        }

        .grand-total-label {
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            font-size: 8.5pt;
        }

        .grand-total-amount {
            font-size: 10.5pt;
            font-weight: bold;
            color: #0f172a;
        }

        /* Alignment & Helpers */
        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        /* Signatures */
        .footer-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .footer-table td {
            text-align: center;
            font-size: 7.5pt;
            vertical-align: bottom;
        }

        .sign-space {
            height: 38px;
        }

        .sign-line {
            border-bottom: 1px solid #0f172a;
            display: inline-block;
            width: 170px;
            margin-bottom: 2px;
        }
    </style>
</head>

<body>

    <!-- Header Instansi & Judul Dokumen -->
    <table class="header-table">
        <tr>
            <td width="55%">
                <div class="company-name">{{ config('app.name', 'RUMAH SAKIT / KLINIK') }}</div>
                <div class="company-sub">Bukti Pembayaran Sektor Keuangan & Kasir Resmi</div>
            </td>
            <td width="45%" class="invoice-title-box">
                <h2>INVOICE LUNAS</h2>
                <div class="status-badge">PAID / LUNAS</div>
            </td>
        </tr>
    </table>

    <!-- Informasi Pasien & Metrik Transaksi -->
    <table class="info-container">
        <tr>
            <td>
                <div class="info-block-title">Diterbitkan Untuk (Pasien):</div>
                <table class="meta-table">
                    <tr>
                        <td class="meta-label" style="width: 105px;">No. Rekam Medis</td>
                        <td width="8" style="width: 15px;">:</td>
                        <td class="meta-value accounting-font">{{ $order->master_patient_code ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="meta-label">Nama Pasien</td>
                        <td tyle="width: 5px;">:</td>
                        <td class="meta-value">{{ $order->master_patient_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="meta-label">Alamat Pasien</td>
                        <td tyle="width: 5px;">:</td>
                        <td class="meta-value" style="font-size: 7.5pt;">{{ $order->master_patient_alamat ?? '-' }}</td>
                    </tr>
                </table>
            </td>
            <td style="border-left: 1px solid #e2e8f0;">
                <div class="info-block-title">Rincian Transaksi:</div>
                <table class="meta-table">
                    <tr>
                        <td class="meta-label" style="width: 105px;">No. Registrasi/Order</td>
                        <td width="8" style="width: 15px;">:</td>
                        <td class="meta-value accounting-font">{{ $order->d_reg_order_code }}</td>
                    </tr>
                    <tr>
                        <td class="meta-label">Tanggal Bayar</td>
                        <td>:</td>
                        <td class="meta-value">
                            {{ isset($items[0]->d_reg_order_payment_date) ? date('d/m/Y H:i', strtotime($items[0]->d_reg_order_payment_date)) : date('d/m/Y H:i') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="meta-label">Metode Pembayaran</td>
                        <td>:</td>
                        <td class="meta-value">{{ $items[0]->d_reg_order_payment_card ?? 'TUNAI' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Tabel Detail Rincian Item (HANYA ITEM LUNAS) -->
    <table class="items-table">
        <thead>
            <tr>
                <th width="4%" class="text-center">No</th>
                <th width="16%">Kategori</th>
                <th>Deskripsi Layanan / Tindakan</th>
                <th width="18%" class="text-end">Harga (Rp)</th>
                <th width="15%" class="text-end">Diskon (Rp)</th>
                <th width="20%" class="text-end">Subtotal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php
            $grandGross = 0;
            $grandDiscount = 0;
            @endphp
            @forelse($items as $index => $item)
            @php
            $hargaAwal = $item->price;
            $diskon = $item->discount;
            $subtotal = $hargaAwal - $diskon;

            $grandGross += $hargaAwal;
            $grandDiscount += $diskon;
            @endphp
            <tr>
                <td class="text-center accounting-font">{{ $index + 1 }}</td>
                <td><span class="fw-bold" style="color: #334155;">{{ $item->t_layanan_cat_code }}</span></td>
                <td>{{ $item->item_name }}</td>
                <td class="text-end accounting-font">{{ number_format($hargaAwal, 0, ',', '.') }}</td>
                <td class="text-end accounting-font" style="color: #dc2626;">
                    {{ $diskon > 0 ? '(' . number_format($diskon, 0, ',', '.') . ')' : '-' }}
                </td>
                <td class="text-end accounting-font fw-bold">{{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 15px; color: #94a3b8;">
                    Tidak ada item transaksi berstatus lunas yang dapat ditampilkan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Ringkasan Perhitungan Akuntansi -->
    <table class="summary-table">
        <tr>
            <td class="summary-notes">
                <div style="font-weight: bold; color: #334155; margin-bottom: 3px;">Catatan Pembayaran:</div>
                <ul style="margin: 0; padding-left: 12px; line-height: 1.4;">
                    <li>Kuitansi ini hanya mencantumkan item layanan yang telah <b>LUNAS</b> ditagihkan.</li>
                    <li>Bukti pembayaran sah dikeluarkannya dokumen secara komputerisasi tanpa memerlukan cap basah.</li>
                </ul>
            </td>
            <td class="summary-calculation">
                <table class="calc-table">
                    <tr>
                        <td class="calc-label">Total Kotor (Gross):</td>
                        <td class="calc-value accounting-font">Rp {{ number_format($grandGross, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="calc-label">Total Diskon:</td>
                        <td class="calc-value accounting-font" style="color: #dc2626;">
                            {{ $grandDiscount > 0 ? '- Rp ' . number_format($grandDiscount, 0, ',', '.') : 'Rp 0' }}
                        </td>
                    </tr>
                    <tr class="grand-total-row">
                        <td class="calc-label grand-total-label">Total Pelunasan Netto:</td>
                        <td class="calc-value grand-total-amount accounting-font">
                            Rp {{ number_format($totalLunas, 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Tanda Tangan & Footer -->
    <table class="footer-table">
        <tr>
            <td width="60%" style="text-align: left; vertical-align: bottom;">
                <div style="font-size: 7pt; color: #64748b;">
                    <i>Waktu Cetak Dokumen: {{ date('d-m-Y H:i:s') }} WIB</i>
                </div>
            </td>
            <td width="40%">
                <div>Kasir / Officer Keuangan,</div>
                <div class="sign-space"></div>
                <div class="sign-line"></div>
                <div class="fw-bold" style="font-size: 8.5pt;">{{ auth()->user()->name ?? 'Petugas Kasir' }}</div>
            </td>
        </tr>
    </table>

</body>

</html>
