<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Penagihan - {{ $penagihan->no_tagihan }}</title>
    <style>
        /* Pengaturan Ukuran Halaman Portrait A4 */
        @page {
            size: A4 portrait;
            margin: 1.5cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif, Arial, sans-serif;
            color: #111;
            margin: 0;
            padding: 0;
            font-size: 12pt;
            line-height: 1.5;
            background: #fff;
        }

        /* Kop Surat Resmi */
        .kop-surat {
            border-bottom: 3px double #111;
            padding-bottom: 10px;
            margin-bottom: 20px;
            width: 100%;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-table td {
            vertical-align: middle;
        }

        /* Atribut Surat */
        .nomor-surat-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11pt;
        }

        .nomor-surat-table td {
            vertical-align: top;
            padding: 2px 0;
        }

        /* Tabel Rincian */
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .item-table th,
        .item-table td {
            border: 1px solid #333;
            padding: 6px 8px;
            text-align: left;
            font-size: 10pt;
        }

        .item-table th {
            background-color: #f2f2f2;
            color: #000;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        /* Bagian Total */
        .total-box {
            width: 100%;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        .total-table {
            width: 50%;
            float: right;
            border-collapse: collapse;
        }

        .total-table td {
            border: 1px solid #333;
            padding: 6px 10px;
            font-size: 11pt;
        }

        /* Tanda Tangan */
        .ttd-section {
            width: 100%;
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ttd-table td {
            vertical-align: top;
            font-size: 11pt;
        }

        .footer {
            margin-top: 50px;
            width: 100%;
            text-align: center;
            font-size: 9pt;
            color: #555;
            border-top: 1px solid #ccc;
            padding-top: 10px;
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

<body>

    <!-- Tombol Cetak / Print (Hilang saat diprint/pdf) -->
    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #1e1e24; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
            🖨️ Cetak / Simpan PDF (Portrait)
        </button>
    </div>

    <!-- KOP SURAT RESMI -->
    <div class="kop-surat">
        <table class="kop-table">
            <tr>
                <td style="width: 15%; text-align: center;">
                    <!-- Placeholder Logo Instansi / Rumah Sakit -->
                    <div style="font-size: 32px;">🏥</div>
                </td>
                <td style="width: 85%; text-align: center;">
                    <div style="font-size: 16pt; font-weight: bold; letter-spacing: 0.5px;">RUMAH SAKIT / KLINIK MEDIS UTAMA</div>
                    <div style="font-size: 10pt; color: #333; margin-top: 2px;">Jl. Kesehatan No. 128, Pontianak, Kalimantan Barat</div>
                    <div style="font-size: 9pt; color: #555;">Telepon: (0561) 123456 | Email: billing@rumahsakit.com</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- HEADER / PERIHAL SURAT -->
    <div style="text-align: center; margin-bottom: 25px;">
        <div style="font-size: 13pt; font-weight: bold; text-decoration: underline;">NOTA / TAGIHAN KEUANGAN PERUSAHAAN</div>
        <div style="font-size: 10pt; color: #555; margin-top: 3px;">Nomor: {{ $penagihan->no_tagihan }}</div>
    </div>

    <!-- INFORMASI TUJUAN & TANGGAL -->
    <table class="nomor-surat-table">
        <tr>
            <td style="width: 15%;">Kepada Yth,</td>
            <td style="width: 45%;"><strong>{{ $penagihan->nama_sub_penjamin }}</strong></td>
            <td style="width: 15%;">Tanggal Tagihan</td>
            <td style="width: 25%;">: {{ date('d-m-Y', strtotime($penagihan->tanggal_tagihan)) }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>{{ $penagihan->alamat ?? '-' }}</td>
            <td>Jatuh Tempo</td>
            <td>: {{ date('d-m-Y', strtotime($penagihan->tanggal_tagihan . ' +30 days')) }}</td>
        </tr>
        <tr>
            <td>Telp / Kontak</td>
            <td>{{ $penagihan->telp_perusahaan ?? '-' }}</td>
            <td>Status Pembayaran</td>
            <td>: <strong style="color: {{ $penagihan->status_tagihan == 'LUNAS' ? '#28a745' : '#d9534f' }};">{{ $penagihan->status_tagihan }}</strong></td>
        </tr>
    </table>

    <div style="font-size: 11pt; margin-bottom: 10px;">Dengan hormat, bersama surat ini kami sampaikan rincian penagihan biaya pelayanan medis dan pengobatan karyawan/peserta dari instansi Bapak/Ibu sebagai berikut:</div>

    <!-- TABEL RINCIAN PASIEN, TINDAKAN & OBAT -->
    <table class="item-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 22%;">No. Reg / Tanggal</th>
                <th style="width: 48%;">Nama Pasien & Rincian Medis (Tindakan / Obat)</th>
                <th style="text-end" style="width: 25%;">Porsi Perusahaan</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($details as $row)
            <tr>
                <td class="text-center" style="vertical-align: top;">{{ $no++ }}</td>
                <td style="vertical-align: top;">
                    <strong style="color: #d9534f;">{{ $row->no_registrasi }}</strong><br>
                    <span style="font-size: 9pt; color: #555;">{{ $row->tanggal_registrasi }}</span>
                </td>
                <td style="vertical-align: top;">
                    <div class="fw-bold" style="text-transform: uppercase;">{{ $row->nama_lengkap }}</div>
                    <div style="font-size: 9pt; color: #555; margin-bottom: 4px;">No. RM (PID): {{ $row->pid }}</div>

                    @if(isset($row->items) && count($row->items) > 0)
                    <table style="width: 100%; font-size: 9pt; background: #fafafa; border: 1px solid #ddd; margin-top: 3px; border-collapse: collapse;">
                        @foreach($row->items as $it)
                        <tr>
                            <td style="border: none; padding: 2px 4px;">• [{{ $it->jenis_item }}] {{ $it->nama_item }} (x{{ $it->qty }})</td>
                            <td class="text-end" style="border: none; padding: 2px 4px; color: #28a745;">Rp {{ number_format($it->tanggungan_perusahaan, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
                </td>
                <td class="text-end" style="vertical-align: top; font-weight: bold; color: #28a745;">
                    Rp {{ number_format($row->tanggungan_perusahaan, 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center" style="padding: 15px; color: #777;">Tidak ada rincian pasien dalam penagihan ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TOTAL KESELURUHAN -->
    <div class="total-box">
        <table class="total-table">
            <tr>
                <td class="fw-bold" style="background: #f9f9f9;">TOTAL KESELURUHAN TAGIHAN:</td>
                <td class="text-end fw-bold" style="color: #28a745; font-size: 12pt;">Rp {{ number_format($penagihan->total_tagihan, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div style="clear: both;"></div>

    <div style="font-size: 11pt; margin-top: 15px; margin-bottom: 10px;">
        Pembayaran dapat dilakukan melalui transfer bank ke rekening operasional rumah sakit kami. Demikian disampaikan, atas kerja samanya kami ucapkan terima kasih.
    </div>

    <!-- TANDA TANGAN -->
    <div class="ttd-section">
        <table class="ttd-table">
            <tr>
                <td style="width: 60%;"></td>
                <td class="text-center" style="width: 40%;">
                    <div>Pontianak, {{ date('d F Y') }}</div>
                    <div style="font-weight: bold; margin-top: 2px;">Bagian Keuangan & Penagihan</div>
                    <div style="height: 65px;"></div>
                    <div style="font-weight: bold; text-decoration: underline;">( ___________________ )</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Dokumen penagihan resmi ini diterbitkan secara elektronik oleh Sistem Informasi Rumah Sakit dan sah tanpa tanda tangan basah.
    </div>

</body>

</html>
