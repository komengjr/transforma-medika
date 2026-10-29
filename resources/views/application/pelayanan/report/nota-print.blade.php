<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembayaran - {{ $transaksi->no_registrasi }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 20mm 20mm 20mm; /* Memberikan ruang margin bawah untuk footer */
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000;
            background: #fff;
        }

        /* Container Utama dengan Ketinggian Penuh */
        .receipt-container {
            width: 100%;
            max-width: 800px;
            min-height: 100vh;
            margin: 0 auto;
            position: relative;
            box-sizing: border-box;
            padding-bottom: 90px; /* Jarak aman agar konten tidak tertimpa footer */
        }

        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .text-start { text-align: left; }
        .fw-bold { font-weight: bold; }
        .fst-italic { font-style: italic; }

        .line-solid {
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            height: 2px;
            margin: 8px 0;
        }

        .line-dotted {
            border-top: 1px dashed #000;
            margin: 4px 0;
        }

        .form-code {
            text-align: right;
            font-size: 9px;
            margin-bottom: 15px;
        }

        .nota-title {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 5px 0;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 11px;
        }
        .info-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .info-table .col-label { width: 14%; }
        .info-table .col-colon { width: 2%; text-align: center; }
        .info-table .col-value { width: 34%; padding-right: 15px; }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        .item-table th, .item-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .box-lunas {
            border: 2px solid #000;
            display: inline-block;
            padding: 4px 25px;
            font-size: 14px;
            font-weight: 900;
            letter-spacing: 1px;
            margin-top: 10px;
        }

        .signature-area {
            float: right;
            text-align: center;
            margin-top: 15px;
            width: 250px;
        }

        /* WRAPPER KELOMPOK FOOTER DIPOSISIKAN KE PALING BAWAH HALAMAN */
        .footer-wrapper {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #fff;
        }

        .footer-text {
            text-align: center;
            font-style: italic;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }

        .bottom-meta {
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            margin-top: 15px;
        }

        .btn-print {
            display: block;
            width: 200px;
            padding: 10px;
            background: #4361ee;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            margin: 20px auto;
            text-align: center;
        }

        @media print {
            .btn-print { display: none; }
            .receipt-container {
                min-height: 98vh; /* Memastikan memenuhi tinggi kertas saat cetak */
            }
            .footer-wrapper {
                position: fixed;
                bottom: 0;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="receipt-container">

        <div class="form-code">YAN.33-FRM-CR-01.1/05</div>

        <div class="text-center" style="margin-bottom: 20px;">
            <h2 class="nota-title">NOTA PEMBAYARAN</h2>
            <div>No. Nota : {{ $transaksi->no_registrasi }}</div>
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
                <td class="col-value">{{ $transaksi->dokter ?? '-' }}</td>
            </tr>
            <tr>
                <td class="col-label">Penjamin</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ $transaksi->agreement ?? 'UMUM / PRIBADI' }}</td>

                <td class="col-label">Tanggal</td>
                <td class="col-colon">:</td>
                <td class="col-value">{{ date('d-m-Y H:i:s', strtotime($transaksi->tanggal_registrasi)) }}</td>
            </tr>
        </table>

        <div class="line-solid"></div>

        <table class="item-table">
            <thead>
                <tr>
                    <th class="text-start fst-italic fw-bold" style="width: 50%;">PEMERIKSAAN</th>
                    <th class="text-end fst-italic fw-bold" style="width: 20%;">BRUTO</th>
                    <th class="text-end fst-italic fw-bold" style="width: 15%;">DISKON</th>
                    <th class="text-end fst-italic fw-bold" style="width: 15%;">HARGA</th>
                </tr>
            </thead>
            <tbody>
                @php $subtotal = 0; @endphp
                @foreach($details as $item)
                @php
                    $hargaDasar = $item->harga_dasar + $item->biaya_cito;
                    $subtotal += $item->harga_akhir;
                @endphp
                <tr>
                    <td>{{ $item->nama_layanan }}</td>
                    <td class="text-end">{{ number_format($hargaDasar, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($item->diskon, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($item->harga_akhir, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="line-dotted"></div>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td class="fw-bold fst-italic" style="width: 70%;">Sub Total</td>
                <td class="text-end" style="width: 15%;">{{ number_format($subtotal, 0, ',', '.') }}</td>
                <td class="text-end" style="width: 15%;">{{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="line-dotted"></div>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td class="fw-bold fst-italic" style="width: 85%;">Pembulatan</td>
                <td class="text-end" style="width: 15%;">0</td>
            </tr>
            <tr>
                <td class="fw-bold fst-italic">Grand Total</td>
                <td class="text-end fw-bold">{{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="line-dotted"></div>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td class="fw-bold fst-italic" style="width: 85%;">Pembayaran</td>
                <td class="text-end"></td>
            </tr>
            <tr>
                <td>{{ ucfirst(strtolower($transaksi->metode_bayar)) }}</td>
                <td class="text-end">{{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="line-dotted"></div>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td class="fw-bold fst-italic text-uppercase" style="width: 85%;">TOTAL PEMBAYARAN</td>
                <td class="text-end">{{ number_format($transaksi->total_tagihan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="fw-bold fst-italic">Kembalian</td>
                @php
                    $kembalian = $transaksi->total_bayar > $transaksi->total_tagihan ? ($transaksi->total_bayar - $transaksi->total_tagihan) : 0;
                @endphp
                <td class="text-end">{{ number_format($kembalian, 0, ',', '.') }}</td>
            </tr>
        </table>

        <!-- Info Metode Pengiriman -->
        <div style="margin-top: 10px;">
            <div class="fw-bold fst-italic">Metode Pengiriman :</div>

            @php
                $metode = is_string($transaksi->metode_pengiriman) ? json_decode($transaksi->metode_pengiriman, true) : ($transaksi->metode_pengiriman ?? []);
                $metode = is_array($metode) ? $metode : [];
            @endphp

            <table style="width: 400px; margin-top: 3px;">
                <tr>
                    <td style="width: 25%;">Cetak Fisik</td>
                    <td>: {{ in_array('cetak_fisik', $metode) ? 'Ya' : '-' }}</td>
                </tr>
                <tr>
                    <td>Email / eResult</td>
                    <td>: {{ in_array('email', $metode) || in_array('satusehat', $metode) ? 'Kirim eResult Pasien' : '-' }}</td>
                </tr>
                <tr>
                    <td>Whatsapp</td>
                    <td>: {{ in_array('whatsapp', $metode) ? 'Ya' : '-' }}</td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 10px;">
            <div class="fw-bold fst-italic">Hasil Selesai :</div>
            <div>{{ $transaksi->janji_hasil ? date('d-m-Y H:i:s', strtotime($transaksi->janji_hasil)) : 'Menunggu Info Lab' }}</div>
        </div>

        <!-- Notes & Cap Lunas -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-top: 10px;">
            <div style="font-style: italic; max-width: 65%;">
                NB:<br>
                - Nota harap dibawa saat ambil hasil<br>
                - Hasil harap diambil paling lambat 1(satu) minggu setelah tanggal janji hasil<br>
                - Pembatalan tidak bisa dilakukan bila pemeriksaan sudah dilakukan, pembatalan pemeriksaan yang belum dilakukan sebelum lewat bulan dikenakan biaya pembatalan sebesar 10% dan 25% setelah lewat bulan<br>
                - Pembatalan tidak bisa dilakukan untuk semua program PROMO
            </div>

            @if(strtoupper($transaksi->status_pembayaran ?? '') == 'LUNAS')
                <div class="box-lunas">LUNAS</div>
            @endif
        </div>

        <!-- Tanda Tangan Kasir -->
        <div class="signature-area">
            <div>Pontianak, {{ date('d-m-Y H:i:s') }}</div>
            <br><br><br>
            <div style="text-decoration: underline; font-weight: bold;">
                {{ optional(auth()->user())->name ?? $transaksi->user_id }}
            </div>
        </div>

        <!-- ========================================== -->
        <!-- WRAPPER FOOTER (TERKUNCI DI PALING BAWAH) -->
        <!-- ========================================== -->
        <div class="footer-wrapper">
            <div class="footer-text">
                Terima kasih Anda telah melakukan pemeriksaan di Lab. Klinik "{{ config('app.name', 'Innoventra') }}". Sampaikan kesan dan saran Anda terhadap kualitas hasil & layanan kami melalui WhatsApp ke no. 0852-5172-0189
            </div>

            <div class="bottom-meta">
                <div>Dicetak Oleh : {{ optional(auth()->user())->name ?? $transaksi->user_id }}</div>
                <div>1 &nbsp;/&nbsp; 1</div>
                <div>{{ date('d M Y H.i') }}</div>
            </div>
        </div>

    </div>

    <!-- Tombol Cetak Manual -->
    <button class="btn-print" onclick="window.print()">Cetak Nota Pembayaran</button>

</body>
</html>
