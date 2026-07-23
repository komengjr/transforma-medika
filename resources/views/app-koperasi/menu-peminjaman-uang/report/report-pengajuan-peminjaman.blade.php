<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Penerimaan Pinjaman - {{ $pinjaman->nota_nomor ?? 'Koperasi Amanah' }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #222;
            line-height: 1.35;
            /* margin: 0;
            padding: 0px; */
            background-color: #fff;
        }

        /* Container utama slip agar menyerupai lembar fisik */
        .slip-container {
            border: 1.5px solid #333;
            padding: 25px;
            max-width: 100%;
            margin: 0px;
        }

        /* Header Kop Surat */
        .header {
            display: table;
            width: 100%;
            border-bottom: 2px solid #222;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }

        .header-left, .header-right {
            display: table-cell;
            vertical-align: top;
        }

        .header-left {
            width: 60%;
        }

        .header-right {
            width: 40%;
            text-align: right;
        }

        .header h2 {
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 3px 0;
            text-transform: uppercase;
            color: #111;
        }

        .header h3 {
            font-size: 12px;
            font-weight: bold;
            margin: 0 0 2px 0;
            color: #1e3a8a; /* Biru korporat */
        }

        .header p {
            margin: 0;
            font-size: 10px;
            color: #555;
        }

        /* Informasi Metadata (No Reg, Nama, dll) */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .meta-table td {
            padding: 3px 2px;
            vertical-align: top;
            font-size: 11px;
        }

        .label-field {
            font-weight: bold;
            width: 13%;
        }

        .separator-field {
            width: 2%;
            text-align: center;
        }

        .value-field {
            width: 35%;
        }

        /* Bagian Konten 2 Kolom (Pinjaman Baru vs Pinjaman Sebelumnya) */
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .content-table td {
            vertical-align: top;
            width: 50%;
            padding: 0 5px;
        }

        .content-table td:first-child {
            padding-left: 0;
            border-right: 1px dashed #bbb;
        }

        .content-table td:last-child {
            padding-right: 0;
        }

        .section-box {
            background-color: #fafafa;
            border: 1px solid #e5e7eb;
            padding: 8px 10px;
            border-radius: 4px;
            min-height: 180px;
        }

        .section-title {
            font-weight: bold;
            font-size: 12px;
            color: #b45309; /* Warna aksen emas/kecoklatan */
            border-bottom: 1.5px solid #d97706;
            padding-bottom: 3px;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .form-table {
            width: 100%;
            border-collapse: collapse;
        }

        .form-table td {
            padding: 2.5px 0;
            font-size: 10.5px;
            /* border: none; */
        }

        .col-num { width: 1px; color: #666; }
        .col-label { width: 300px; }
        .col-colon { width: 4%; text-align: center; }
        .col-curr { width: 10%; text-align: left; color: #555; }
        .col-val { width: 26%; text-align: right; font-weight: 500; }
        /* .col-val-text { width: 36%; text-align: right; } */

        /* Kotak Info Ringkasan Bawah (Dana Diserahkan) */
        .summary-box {
            border: 1px solid #1e3a8a;
            background-color: #eff6ff;
            padding: 8px 12px;
            margin-bottom: 20px;
            margin-top: 20px;
            border-radius: 4px;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table td {
            font-size: 11.5px;
            font-weight: bold;
            color: #1e3a8a;
        }

        .date-disburse {
            text-align: right;
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* Blok Tanda Tangan */
        .sig-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .sig-table td {
            width: 33.33%;
            text-align: center;
            vertical-align: top;
            font-size: 11px;
        }

        .sig-space {
            height: 50px;
        }

        .sig-name {
            font-weight: bold;
            text-decoration: underline;
        }

        /* Catatan Kaki */
        .footer-note {
            margin-top: 15px;
            border-top: 1px solid #ccc;
            padding-top: 5px;
            font-style: italic;
            color: #dc2626;
            font-size: 9.5px;
        }

        .footer-note p {
            margin: 1px 0;
        }
    </style>
</head>

<body>

<div class="slip-container">
    <!-- Header Kop -->
    <div class="header">
        <div class="header-left">
            <h2>Koperasi Amanah</h2>
            <p>Unit Simpan Pinjam Karyawan & Anggota</p>
        </div>
        <div class="header-right">
            <h3>Laboratorium Klinik "Pramita"</h3>
            <p>Jl. LL. RE. Martadinata No. 135 Bandung</p>
        </div>
    </div>

    <!-- Informasi Anggota & Nota -->
    <table class="meta-table">
        <tr>
            <td class="label-field">Jenis Pinjaman</td>
            <td class="separator-field">:</td>
            <td class="value-field"><b>Uang (Tunai / Transfer)</b></td>
            <td class="label-field">Cabang</td>
            <td class="separator-field">:</td>
            <td class="value-field">{{ $pinjaman->cabang ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-field">No. Referensi</td>
            <td class="separator-field">:</td>
            <td class="value-field">{{ $pinjaman->nota_nomor ?? '-' }}</td>
            <td class="label-field">Bagian / Unit</td>
            <td class="separator-field">:</td>
            <td class="value-field">{{ $pinjaman->peserta->bagian ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-field">Nama Anggota</td>
            <td class="separator-field">:</td>
            <td class="value-field"><b>{{ $pinjaman->kop_master_peserta_name ?? '-' }}</b></td>
            <td class="label-field">ID Anggota</td>
            <td class="separator-field">:</td>
            <td class="value-field">{{ $pinjaman->kop_master_peserta_code ?? '-' }}</td>
        </tr>
    </table>

    <!-- Dua Kolom: Pinjaman Baru & Pinjaman Sebelumnya -->
    <table class="content-table">
        <tr>
            <!-- Kolom Kiri: Pinjaman Baru -->
            <td>
                <div class="section-box">
                    <div class="section-title">I. Rincian Pinjaman Baru</div>
                    <table class="form-table">
                        <tr>
                            <td class="col-num" style="width: 10%;">1.</td>
                            <td class="col-label" style="width: 140px;">Jumlah Pinjaman</td>
                            <td class="col-colon">:</td>
                            <td class="col-curr">Rp</td>
                            <td class="col-val">{{ number_format($pinjaman->jumlah_pinjaman ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="col-num" style="width: 10%;">2.</td>
                            <td class="col-label">Tanggal Pengajuan</td>
                            <td class="col-colon">:</td>
                            <td colspan="2" class="col-val-text">{{ isset($pinjaman->tanggal_pinjaman) ? date('d-m-Y', strtotime($pinjaman->tanggal_pinjaman)) : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="col-num" style="width: 10%;">3.</td>
                            <td class="col-label">Lama Pinjaman</td>
                            <td class="col-colon">:</td>
                            <td colspan="2" class="col-val-text"><b>{{ $pinjaman->tenor_bulan ?? 0 }} Bulan</b></td>
                        </tr>
                        <tr>
                            <td class="col-num" style="width: 10%;">4.</td>
                            <td class="col-label">Mulai Angsuran</td>
                            <td class="col-colon">:</td>
                            <td colspan="2" class="col-val-text">{{ isset($pinjaman->mulai_pinjaman) ? date('d-m-Y', strtotime($pinjaman->mulai_pinjaman)) : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="col-num" style="width: 10%;">5.</td>
                            <td class="col-label">Akhir Angsuran</td>
                            <td class="col-colon">:</td>
                            <td colspan="2" class="col-val-text">{{ isset($pinjaman->akhir_pinjaman) ? date('d-m-Y', strtotime($pinjaman->akhir_pinjaman)) : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="col-num" style="width: 10%;">6.</td>
                            <td class="col-label">Angsuran Pokok</td>
                            <td class="col-colon">:</td>
                            <td class="col-curr">Rp</td>
                            <td class="col-val">{{ number_format($pinjaman->angsuran_pokok_per_bulan ?? ($pinjaman->jumlah_pinjaman / max($pinjaman->tenor_bulan, 1)), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="col-num" style="width: 10%;">7.</td>
                            <td class="col-label">Angsuran Bunga</td>
                            <td class="col-colon">:</td>
                            <td class="col-curr">Rp</td>
                            <td class="col-val">{{ number_format($pinjaman->angsuran_bunga_per_bulan ?? (($pinjaman->bunga_koperasi ?? 0) / max($pinjaman->tenor_bulan, 1)), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="col-num" style="width: 10%;">8.</td>
                            <td class="col-label"><b>Total Cicilan / Bln</b></td>
                            <td class="col-colon">:</td>
                            <td class="col-curr"><b>Rp</b></td>
                            <td class="col-val"><b>{{ number_format($pinjaman->cicilan_per_bulan ?? 0, 0, ',', '.') }}</b></td>
                        </tr>
                    </table>
                </div>
            </td>

            <!-- Kolom Kanan: Pinjaman Sebelumnya -->
            <td>
                <div class="section-box">
                    <div class="section-title">II. Rincian Pinjaman Sebelumnya</div>
                    <table class="form-table">
                        <tr>
                            <td class="col-num" style="width: 10%;">1.</td>
                            <td class="col-label" style="width: 50%;">No. Akad Sebelumnya</td>
                            <td class="col-colon">:</td>
                            <td colspan="2" class="col-val-text"><b>{{ $pinjaman->prev_angsuran_bulan ?? '-' }}</b></td>
                        </tr>
                        <tr>
                            <td class="col-num" style="width: 10%;">2.</td>
                            <td class="col-label" style="width: 50%;">Total Tagihan Lalu</td>
                            <td class="col-colon">:</td>
                            <td class="col-curr">Rp</td>
                            <td class="col-val">{{ number_format($pinjaman->prev_total_angsuran ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="col-num" style="width: 10%;">3.</td>
                            <td class="col-label style="width: 50%;"">Sisa Tenor Belum Lunas</td>
                            <td class="col-colon">:</td>
                            <td colspan="2" class="col-val-text">{{ $pinjaman->prev_sisa_angsuran ?? '0 Bulan' }}</td>
                        </tr>
                        <tr>
                            <td class="col-num" style="width: 10%;">4.</td>
                            <td class="col-label" style="width: 50%;">Pokok Pelunasan (LB)</td>
                            <td class="col-colon">:</td>
                            <td class="col-curr">Rp</td>
                            <td class="col-val">{{ number_format($pinjaman->prev_pokok_lb ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="col-num" style="width: 10%;">5.</td>
                            <td class="col-label" style="width: 50%;">Bunga Pelunasan (LB)</td>
                            <td class="col-colon">:</td>
                            <td class="col-curr">Rp</td>
                            <td class="col-val">{{ number_format($pinjaman->prev_bunga_lb ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="col-num" style="width: 10%;">6.</td>
                            <td class="col-label" style="width: 50%;">Biaya Penalti / Lainnya</td>
                            <td class="col-colon">:</td>
                            <td class="col-curr">Rp</td>
                            <td class="col-val">{{ number_format($pinjaman->prev_penalty ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="col-num" style="width: 10%;">7.</td>
                            <td class="col-label" style="width: 140px;"><b>Total Potongan Pelunasan</b></td>
                            <td class="col-colon" style="width: 10%;">:</td>
                            <td class="col-curr"><b>Rp</b></td>
                            <td class="col-val"><b>{{ number_format($pinjaman->prev_total_potongan ?? 0, 0, ',', '.') }}</b></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <!-- Kotak Info Ringkasan Bersih -->
    <div class="summary-box">
        <table class="summary-table">
            <tr>
                <td style="width: 55%;">
                    DANA BERSIH YANG DISERAHKAN : Rp. {{ number_format($pinjaman->pencairan_netto ?? $pinjaman->jumlah_pinjaman, 0, ',', '.') }}
                </td>
                <td style="width: 45%; text-align: right;">
                    UNTUK KEPERLUAN : {{ strtoupper($pinjaman->tujuan_pinjaman ?? '-') }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Tanggal Pencairan -->
    <div class="date-disburse">
        Bandung, {{ isset($pinjaman->tanggal_pinjaman) ? date('d F Y', strtotime($pinjaman->tanggal_pinjaman)) : '________________________' }}
    </div>

    <!-- Blok Tanda Tangan -->
    <table class="sig-table">
        <tr>
            <td>
                Disetujui Oleh,<br>
                <b>Ketua Koperasi Amanah</b>
                <div class="sig-space"></div>
                <span class="sig-name">( _____________________ )</span>
            </td>
            <td>
                Dihitung / Dibukukan,<br>
                <b>Bendahara Cabang</b>
                <div class="sig-space"></div>
                <span class="sig-name">( _____________________ )</span>
            </td>
            <td>
                Penerima Dana,<br>
                <b>Anggota / Pemohon</b>
                <div class="sig-space"></div>
                <span class="sig-name">( {{ $pinjaman->peserta->kop_master_peserta_name ?? '_____________________' }} )</span>
            </td>
        </tr>
    </table>

    <!-- Catatan Kaki -->
    <div class="footer-note">
        <p><b>Note :</b></p>
        <p>1. Simpan slip ini dengan baik sebagai bukti transaksi yang sah bilamana diperlukan.</p>
        <p>2. Lembar Putih untuk Arsip Karyawan / Pemohon, Lembar Merah untuk Arsip Pembukuan Bendahara Koperasi.</p>
    </div>
</div>

</body>
</html>
