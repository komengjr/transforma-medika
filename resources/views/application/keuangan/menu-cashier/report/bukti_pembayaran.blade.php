<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembayaran - {{ $transaksi->no_registrasi }}</title>
    <style>
        @page {
            size: A5 portrait;
            margin: 10mm;
            /* Memberikan margin keliling di semua sisi kertas */
        }

        html,
        body {
            height: 100%;

            font-family: Arial, Helvetica, sans-serif;
            font-size: 8pt;
            color: #000;
            background: #fff;
            line-height: 1.15;
        }

        .receipt-container {
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .text-start {
            text-align: left;
        }

        .fw-bold {
            font-weight: bold;
        }

        .fst-italic {
            font-style: italic;
        }

        .line-solid {
            border-top: 1.5px solid #000;
            border-bottom: 1px solid #000;
            height: 1px;
            margin: 4px 0;
        }

        .line-dotted {
            border-top: 1px dashed #000;
            margin: 2px 0;
        }

        .form-code {
            text-align: right;
            font-size: 7.5pt;
            margin-bottom: 2px;
        }

        .nota-title {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 2px 0;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
            font-size: 8pt;
        }

        .info-table td {
            padding: 1.5px 0;
            vertical-align: top;
        }

        .info-table .col-label {
            width: 18%;
        }

        .info-table .col-colon {
            width: 2%;
            text-align: center;
        }

        .info-table .col-value {
            width: 30%;
            padding-right: 5px;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2px;
        }

        .item-table th {
            border-top: 1.5px solid #000;
            border-bottom: 1.5px solid #000;
            padding: 3px 2px;
            font-size: 8pt;
        }

        .item-table td {
            padding: 2.5px 2px;
            vertical-align: top;
            font-size: 8pt;
        }

        .box-lunas {
            border: 2px solid #000;
            display: inline-block;
            padding: 2px 18px;
            font-size: 10pt;
            font-weight: 900;
            letter-spacing: 1.5px;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 8pt;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .footer-text {
            text-align: center;
            font-style: italic;
            font-size: 6.5pt;
            margin-top: 6px;
            border-top: 1px solid #ddd;
            padding-top: 3px;
        }

        .bottom-meta {
            width: 100%;
            display: table;
            font-size: 7pt;
            margin-top: 3px;
        }

        .bottom-meta div {
            display: table-cell;
        }
    </style>
</head>

<body>

    <div class="receipt-container">

        <div class="form-code">YAN.33-FRM-CR-01.1/05</div>

        <div class="text-center" style="margin-bottom: 6px;">
            <h2 class="nota-title">NOTA PEMBAYARAN</h2>
            <div style="font-size: 8pt;">No. Nota : {{ $transaksi->no_registrasi }}</div>
        </div>

        <table class="info-table">
            <tr>
                <td class="col-label">Nama Pelanggan</td>
                <td class="col-colon">:</td>
                <td class="col-value fw-bold">Sdr {{ strtoupper($transaksi->nama_pasien) }}</td>

                <td class="col-label">ID Pelanggan</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $transaksi->pid }}</td>
            </tr>
            <tr>
                <td class="col-label">Umur/J. Kelamin</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $transaksi->umur ?? '-' }} tahun / {{ $transaksi->jk == 'L' ? 'L' : 'P' }}</td>

                <td class="col-label">No. Reg</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $transaksi->no_registrasi }}</td>
            </tr>
            <tr>
                <td class="col-label">Alamat</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $transaksi->alamat ?? '-' }}</td>

                <td class="col-label">Pengirim</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $transaksi->nama_dokter_pengirim ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-label">Kel. Pelanggan</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $transaksi->agreement ?? 'PASIEN KLINISI' }}</td>

                <td class="col-label">Tanggal</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ date('d-m-Y H:i:s', strtotime($transaksi->tanggal_registrasi)) }}</td>
            </tr>
        </table>

        <table class="item-table">
            <thead>
                <tr>
                    <th class="text-start fst-italic fw-bold" style="width: 52%;">PEMERIKSAAN</th>
                    <th class="text-end fst-italic fw-bold" style="width: 16%;">BRUTO</th>
                    <th class="text-end fst-italic fw-bold" style="width: 16%;">DISKON</th>
                    <th class="text-end fst-italic fw-bold" style="width: 16%;">HARGA</th>
                </tr>
            </thead>
            <tbody>
                @php
                $totalBruto = 0;
                $totalDiskon = 0;
                $subtotalNet = 0;
                @endphp
                @foreach($details as $item)
                @php
                $hargaDasar = ($item->harga_dasar ?? 0) + ($item->biaya_cito ?? 0);
                $diskon = $item->diskon ?? 0;
                $hargaAkhir = $item->harga_akhir ?? ($hargaDasar - $diskon);

                $totalBruto += $hargaDasar;
                $totalDiskon += $diskon;
                $subtotalNet += $hargaAkhir;
                @endphp
                <tr>
                    <td>{{ $item->nama_layanan }}</td>
                    <td class="text-end">{{ number_format($hargaDasar, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($diskon, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($hargaAkhir, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="line-solid" style="margin-top: 3px;"></div>

        <!-- Sub Total -->
        <table style="width: 100%; border-collapse: collapse; font-size: 8pt;">
            <tr>
                <td class="fw-bold fst-italic" style="width: 52%;">Sub Total</td>
                <td class="text-end fw-bold" style="width: 16%;">{{ number_format($totalBruto, 0, ',', '.') }}</td>
                <td class="text-end fw-bold" style="width: 16%;">{{ number_format($totalDiskon, 0, ',', '.') }}</td>
                <td class="text-end fw-bold" style="width: 16%;">{{ number_format($subtotalNet, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="line-dotted"></div>

        <!-- Pembulatan -->
        <table style="width: 100%; border-collapse: collapse; font-size: 8pt;">
            <tr>
                <td class="fw-bold fst-italic" style="width: 84%;">Pembulatan</td>
                <td class="text-end" style="width: 16%;">0</td>
            </tr>
        </table>

        <div class="line-dotted"></div>

        <!-- Grand Total -->
        <table style="width: 100%; border-collapse: collapse; font-size: 8pt;">
            <tr>
                <td class="fw-bold fst-italic" style="width: 84%;">Grand Total</td>
                <td class="text-end fw-bold" style="width: 16%;">{{ number_format($subtotalNet, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="line-dotted"></div>

        <!-- Pembayaran -->
        <table style="width: 100%; border-collapse: collapse; font-size: 8pt;">
            <tr>
                <td class="fw-bold fst-italic" style="width: 84%;">Pembayaran</td>
                <td class="text-end" style="width: 16%;"></td>
            </tr>
            <tr>
                <td>{{ ucfirst(strtolower($transaksi->metode_bayar ?? 'Cash')) }}</td>
                <td class="text-end">{{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="line-dotted"></div>

        <!-- Total Pembayaran & Kembalian -->
        <table style="width: 100%; border-collapse: collapse; font-size: 8pt;">
            <tr>
                <td class="fw-bold fst-italic text-uppercase" style="width: 84%;">TOTAL PEMBAYARAN</td>
                <td class="text-end fw-bold" style="width: 16%;">{{ number_format($transaksi->total_tagihan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="fw-bold fst-italic">Kembalian</td>
                @php
                $kembalian = $transaksi->total_bayar > $transaksi->total_tagihan ? ($transaksi->total_bayar - $transaksi->total_tagihan) : 0;
                @endphp
                <td class="text-end">{{ number_format($kembalian, 0, ',', '.') }}</td>
            </tr>
        </table>

        <!-- Informasi Pemeriksaan & Hasil -->
        <div style="margin-top: 3px; font-size: 8pt;">
            <div class="fw-bold fst-italic">Hasil Pemeriksaan :</div>
            <div>Ambil Sendiri</div>
            <div style="margin-top: 1px;"><span class="fw-bold">Whatsapp Pasien :</span> {{ $transaksi->no_hp ?? '-' }}</div>
            <div class="fw-bold fst-italic" style="margin-top: 1px;">Hasil Selesai :</div>
            <div>{{ $transaksi->janji_hasil ? date('d-m-Y H:i:s', strtotime($transaksi->janji_hasil)) : 'Menunggu Info Lab' }}</div>
        </div>

        <!-- Catatan / NB -->
        <div style="font-style: italic; font-size: 6pt; margin-top: 3px; line-height: 1.15;">
            NB:<br>
            - Nota harap dibawa saat ambil hasil<br>
            - Hasil harap diambil paling lambat 1(satu) minggu setelah tanggal janji hasil<br>
            - Pembatalan tidak bisa dilakukan bila pemeriksaan sudah dilakukan. pembatalan pemeriksaan yang belum dilakukan sebelum lewat bulan dikenakan biaya pembatalan sebesar 10% dan 25% setelah lewat bulan<br>
            - Pembatalan tidak bisa dilakukan untuk semua program PROMO
        </div>

        <!-- Kotak LUNAS dan Tanggal -->
        <table style="width: 100%; margin-top: 4px; border-collapse: collapse;">
            <tr>
                <td style="width: 40%; vertical-align: top;">
                    @if(strtoupper($transaksi->status_pembayaran ?? '') == 'LUNAS')
                    <div class="box-lunas">LUNAS</div>
                    @endif
                </td>
                <td style="width: 60%; text-align: right; font-size: 7.5pt; vertical-align: bottom;">
                    Pontianak, {{ date('d-m-Y H:i:s') }}
                </td>
            </tr>
        </table>

        <div style="font-size: 7.5pt; margin-top: 2px;">
            Kami menyetujui bahwa hasil pemeriksaan dikirim melalui media elektronik WhatsApp No.{{ $transaksi->no_hp ?? '-' }}
        </div>

        <!-- Tanda Tangan Pelanggan & Petugas -->
        <table class="signature-table">
            <tr>
                <td>
                    <br><br><br>
                    <div style="text-decoration: underline; font-weight: bold;">
                        Sdr {{ strtoupper($transaksi->nama_pasien) }}
                    </div>
                </td>
                <td>
                    <br><br><br>
                    <div style="text-decoration: underline; font-weight: bold;">
                        {{ optional(auth()->user())->name ?? 'Petugas Kasir' }}
                    </div>
                </td>
            </tr>
        </table>

        <!-- FOOTER -->
        <div class="footer-text">
            Terima kasih Anda telah melakukan pemeriksaan di LAb. Klinis "PRAMITA". Sampaikan kesan dan saran Anda terhadap kualitas hasil & layanan kami melalui WhatsApp ke no. 0852-5172-0189
        </div>

        <div class="bottom-meta">
            <div style="text-align: left;">Dicetak Oleh : {{ optional(auth()->user())->name ?? 'Petugas Kasir' }}</div>
            <div style="text-align: center;">1 / 1</div>
            <div style="text-align: right;">{{ date('d M Y H.i') }}</div>
        </div>

    </div>

</body>

</html>
