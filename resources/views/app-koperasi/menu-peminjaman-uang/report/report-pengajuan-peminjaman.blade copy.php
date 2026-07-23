<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Penerimaan Pinjaman Koperasi Amanah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
            /* background-color: #f9f9f9; */
            margin: 20px;
        }


        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 5px;
        }

        .header-left h2,
        .header-right h2 {
            font-size: 13px;
            font-weight: bold;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }

        .header-right {
            text-align: right;
        }

        .header-right p {
            margin: 0;
            font-weight: bold;
        }

        .meta-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .meta-info td {
            padding: 2px 0;
            vertical-align: top;
        }

        .border-line {
            border-top: 1.5px solid #000;
            margin-bottom: 10px;
        }

        .content-sections {
            display: flex;
            justify-content: space-between;
        }


        .section-title {
            font-weight: bold;
            text-align: left;
            color: #d97706;
            /* Warna oranye/cokelat keemasan */
            text-decoration: underline;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .form-table {
            width: 100%;
            border-collapse: collapse;
        }

        .form-table td {
            padding: 3px 0;
            vertical-align: middle;
        }

        .col-num {
            width: 5%;
        }

        .col-label {
            width: 45%;
        }

        .col-colon {
            width: 5%;
            text-align: center;
        }

        .col-currency {
            width: 40%;
            text-align: left;
        }

        .col-value {
            width: 40%;
        }

        .middle-info {
            display: flex;
            justify-content: space-between;

            border-top: 1.5px solid #000;
            font-weight: bold;
        }

        .info-blue {
            color: #1d4ed8;
            /* Warna biru */
        }


        .sig-block {

            text-align: left;
        }

        .sig-block-right {
            text-align: right;
        }

        .sig-space {
            height: 60px;
        }

        .footer-note {
            margin-top: 40px;
            font-style: italic;
            color: #dc2626;
            /* Warna merah */
            font-size: 11px;
        }

        .footer-note p {
            margin: 2px 0;
        }
    </style>
</head>

<body>


    <div class="header">
        <div class="header-left">
            <h2>Slip Penerimaan Pinjaman Koperasi Amanah</h2>
        </div>
        <div class="header-right">
            <h2>Laboratorium Klinik "Pramita"</h2>
            <p>Jl.LL.RE.Martadinata No.135 Bandung</p>
        </div>
    </div>

    <table class="meta-info">
        <tr>
            <td style="width: 12%;">Jenis Pinjaman</td>
            <td style="width: 2%;">:</td>
            <td style="width: 36%;">Uang</td>
            <td style="width: 10%;"></td>
            <td style="width: 2%;"></td>
            <td style="width: 38%;"></td>
        </tr>
        <tr>
            <td>No Reg</td>
            <td>:</td>
            <td>0</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>0</td>
            <td>Cabang :</td>
            <td>:</td>
            <td>Bagian :</td>
        </tr>
    </table>

    <div class="border-line"></div>

    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <div class="section-left">
                    <div class="section-title">Pinjaman Baru</div>
                    <table class="form-table">
                        <tr>
                            <td class="col-num">1.</td>
                            <td class="col-label">Jumlah Pinjaman</td>
                            <td class="col-colon">:</td>
                            <td colspan="2" class="col-value">0</td>

                        </tr>
                        <tr>
                            <td class="col-num">2.</td>
                            <td class="col-label">Tanggal Pinjaman</td>
                            <td class="col-colon">:</td>
                            <td colspan="2" class="col-value">0</td>
                        </tr>
                        <tr>
                            <td class="col-num">3.</td>
                            <td class="col-label">Lama Pinjaman</td>
                            <td class="col-colon">:</td>
                            <td colspan="2" class="col-value">0</td>
                        </tr>
                        <tr>
                            <td class="col-num">4.</td>
                            <td class="col-label">Mulai Pinjaman</td>
                            <td class="col-colon">:</td>
                            <td colspan="2" class="col-value"></td>
                        </tr>
                        <tr>
                            <td class="col-num">5.</td>
                            <td class="col-label">Akhir Pinjaman</td>
                            <td class="col-colon">:</td>
                            <td colspan="2" class="col-value"></td>
                        </tr>
                        <tr>
                            <td class="col-num">6.</td>
                            <td class="col-label">Angsuran Pokok</td>
                            <td class="col-colon">:</td>
                            <td class="col-currency">Rp.</td>
                            <td class="col-value"></td>
                        </tr>
                        <tr>
                            <td class="col-num">7.</td>
                            <td class="col-label">Angsuran Bunga</td>
                            <td class="col-colon">:</td>
                            <td class="col-currency">Rp.</td>
                            <td class="col-value"></td>
                        </tr>
                        <tr>
                            <td class="col-num">8.</td>
                            <td class="col-label">Total Angsuran</td>
                            <td class="col-colon">:</td>
                            <td class="col-currency">@currency(0)</td>
                            <td class="col-value"></td>
                        </tr>
                    </table>
                </div>
            </td>
            <td style="width: 50%;">
                <div class="section-right">
                    <div class="section-title">Pinjaman Sebelumnya</div>
                    <table class="form-table">
                        <tr>
                            <td class="col-num">1.</td>
                            <td class="col-label">Angsuran Bulan Sebelumnya</td>
                            <td class="col-colon">:</td>
                            <td colspan="2" class="col-value"></td>
                        </tr>
                        <tr>
                            <td class="col-num">2.</td>
                            <td class="col-label">Total Angsuran</td>
                            <td class="col-colon">:</td>
                            <td colspan="2" class="col-value"></td>
                        </tr>
                        <tr>
                            <td class="col-num">3.</td>
                            <td class="col-label">Sisa Angsuran</td>
                            <td class="col-colon">:</td>
                            <td colspan="2" class="col-value"></td>
                        </tr>
                        <tr>
                            <td class="col-num">4.</td>
                            <td class="col-label">Angsuran Pokok (LB)</td>
                            <td class="col-colon">:</td>
                            <td class="col-currency">Rp.</td>
                            <td class="col-value"></td>
                        </tr>
                        <tr>
                            <td class="col-num">5.</td>
                            <td class="col-label">Angsuran Bunga (LB)</td>
                            <td class="col-colon">:</td>
                            <td class="col-currency">Rp.</td>
                            <td class="col-value"></td>
                        </tr>
                        <tr>
                            <td class="col-num">6.</td>
                            <td class="col-label">Total Angsuran Pokok</td>
                            <td class="col-colon">:</td>
                            <td class="col-currency">Rp.</td>
                            <td class="col-value"></td>
                        </tr>
                        <tr>
                            <td class="col-num">7.</td>
                            <td class="col-label">Pinalty</td>
                            <td class="col-colon">:</td>
                            <td class="col-currency">Rp.</td>
                            <td class="col-value"></td>
                        </tr>
                        <tr>
                            <td class="col-num">8.</td>
                            <td class="col-label">Total Potongan Pinjaman (LB)</td>
                            <td class="col-colon">:</td>
                            <td class="col-currency">Rp.</td>
                            <td class="col-value"></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>

    </table>

    <div class="middle-info">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">
                    <div style="width: 50%;" class="info-blue">
                        Dana yang diserahkan &nbsp;: <small style="color: #000;">@currency(0)</small>
                    </div>
                </td>
                <td style="width: 50%;">
                    <div style="width: 50%;" class="info-blue">
                        Untuk Keperluan : <small style="color: #000;">-</small>
                    </div>

                </td>
            </tr>
        </table>

    </div>
    <p style=" text-align: right;">Tanggal pencairan ___________</p>
    <div class="signatures">
        <table style="width: 100%;">
            <tr>
                <td style="width: 33%;">
                    <div class="sig-block" style="text-align: center;">
                        Bendahara Cabang, <br><br><br><br>

                        ttd
                    </div>
                </td>
                <td style="width: 33%;">
                    <div class="sig-block" style="text-align: center;">
                        Bendahara Cabang, <br><br><br><br>

                        ttd
                    </div>
                </td>
                <td style="width: 33%;">
                    <div class="sig-block-right">

                        <div class="sig-block" style="text-align: center;">
                            Bendahara Cabang, <br><br><br><br>

                            ttd
                        </div>
                    </div>
                </td>
            </tr>
        </table>





    </div>

    <div class="footer-note">
        <p>Note : - Simpan Slip ini bila suatu saat diperlukan</p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- Slip Putih untuk Karyawan, Slip Merah untuk arsip Bendahara Koperasi</p>
    </div>


</body>

</html>
