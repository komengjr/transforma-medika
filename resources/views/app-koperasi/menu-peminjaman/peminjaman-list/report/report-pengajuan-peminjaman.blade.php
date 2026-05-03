<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Document Stockopname</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: "Roboto Mono", monospace;
            font-optical-sizing: auto;
            font-weight: <weight>;
            font-style: normal;
        }
    </style>
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            position: relative;
            width: 100%;
            height: 100%;
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-family: SourceSansPro;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #0b0909;
        }

        #logo {
            float: left;
            margin-top: 8px;
        }

        #logo img {
            height: 70px;
        }

        #company {
            float: right;
            text-align: right;
            color: #0b0909;
        }

        #details {
            padding: 10px;
            border: 1px solid #0b0909;
            border-style: solid solid dashed double;
            border-radius: 5px;
            /* margin-bottom: 10px; */
        }

        #client {
            padding-top: 5px;
            padding-left: 6px;
            border-left: 6px solid #db3311;
            float: left;
            font-size: 1.0em;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
        }

        #invoice {
            padding-top: 0;
            float: right;
            text-align: right;
        }

        #invoice span {
            font-size: 1.2rem;
        }

        #invoice h1 {
            color: #db3311;
            font-size: 2.4em;
            /* line-height: 1em; */
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        #invoice .date {
            font-size: 0.5em;
            color: #777777;
        }



        #thanks {
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices {
            position: absolute;
            bottom: 0;
            padding-left: 6px;
            border-left: 6px solid #db3311;
        }

        #notices .notice {
            font-size: 0.7em;
        }

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: center;
        }

        #kepala {
            border: 1px solid #badadbff;
            border-style: solid solid solid solid;
            border-radius: 10px;
            /* background-color: #138cc0ff; */
            color: black;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            font-size: 9px;
            /* margin-bottom: 20px; */
        }

        table th,
        table td {
            padding: 5px;
            /* background: #EEEEEE; */
            text-align: center;
            /* border-bottom: 1px solid #000000; */
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
            background: #b90303;
            color: white;
        }

        table td {
            text-align: left;
        }

        table td h3 {
            color: #000000ff;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            text-align: center;
            background: #db3311;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #DDDDDD;
        }

        table .qty {
            text-align: center;
        }

        table .total {
            background: #eaebe3;
            color: #ff0404;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        /* table tbody tr:last-child td {
        border: none;
    } */


        /* table tfoot tr:first-child td {
        border-top: none;
    } */

        table tfoot tr:last-child td {
            color: #11db40;
            font-size: 1.4em;
            border-top: 1px solid #db3311;

        }
    </style>
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="data:image/png;base64, {{ $image }}}}">
        </div>
        <div id="company">
            <div style="margin-top: -20px; font-size: 9px;;">REG/001/POLI/20250201/PRIBADI</div><br>
            <h2 class="name" style="margin-top: -20px;  color: #0087C3;font-size: 25px;font-weight: 800;">Koperasi Innoventra
            </h2>
            <div>Lorem, ipsum dolor sit amet thanks</div>
        </div>
        </div>
    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">
                {{-- <h2 class="name">
                </h2>
                <div class="address"></div> --}}

                <table style="margin: 0px; padding: 0px; font-size: 0.8em;">
                    <tr>
                        <td style="padding: 1;">Token Pengajuan</td>
                        <td style="padding-top: 0;padding-bottom: 0px;">:</td>
                        <td style="padding: 1;">{{ $code }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 1;">Nama Peminjam</td>
                        <td style="padding-top: 0;padding-bottom: 0px;">:</td>
                        <td style="padding: 1;">
                            {{ $data->kop_master_peserta_name }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 1;">Umur / Tanggal Lahir</td>
                        <td style="padding-top: 0;padding-bottom: 0px;">:</td>
                        <td style="padding: 1;">
                            123123
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 1;">Cabang / Divisi</td>
                        <td style="padding-top: 0;padding-bottom: 0px;">:</td>
                        <td style="padding: 1;">
                            123123
                        </td>
                    </tr>
                </table>

            </div>
            <div id="invoice">
                <img src="data:image/png;base64, {!! base64_encode(
                            QrCode::style('dot')->format('svg')->size(70)->errorCorrection('H')->generate($code),
                        ) !!}">
                <div class="date" style="color: #0087C3">{{ date('d-m-Y H-i-s') }}</div><br>
            </div>
        </div>

        <strong style="margin: 0; padding: 0;">Data Angsuran Peminjaman Uang</strong>
        <hr>
        <table border="1">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Tenor Ke</th>
                    <th>Suku Bunga {{ $data->kop_proses_uang_bunga }} %</th>
                    <th style="text-align: right;">Angsuran Pokok</th>
                    <th style="text-align: right;">Total Angsuran Bulanan</th>
                </tr>
            </thead>
            <tbody>
                @php
                $total = 0 ;
                $pokok = $data->kop_proses_uang_nominal/$data->kop_proses_uang_tenor ;
                $suku_bunga = ($data->kop_proses_uang_nominal * ($data->kop_proses_uang_bunga / 100) * ($data->kop_proses_uang_tenor/12))/$data->kop_proses_uang_tenor;
                $admin = ($data->kop_proses_uang_admin / 100) * $data->kop_proses_uang_nominal;
                @endphp
                @for ($i = 1 ; $i <= $data->kop_proses_uang_tenor ; $i++)
                    <tr>
                        <td>
                            {{ date('d - M - Y', strtotime('+' . $i .' month', strtotime($data->kop_proses_uang_tgl))) }}
                        </td>
                        <td style="text-align: center;">{{ $i }}</td>
                        <td style="text-align: center;">@currency($suku_bunga)</td>
                        <td style="text-align: right;">@currency($pokok)</td>
                        <td style="text-align: right;">@currency($pokok + $suku_bunga)</td>
                    </tr>
                    @php
                    $total = $total + ( $pokok + $suku_bunga );
                    @endphp
                    @endfor
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Subtotal :</td>
                    <td style="text-align: right;">@currency($pokok * $data->kop_proses_uang_tenor)</td>
                    <td style="text-align: right;">@currency($total)</td>
                </tr>
                <tr>
                    <td colspan="3">Biaya Admin :</td>
                    <td style="text-align: right;">- @currency($admin)</td>
                    <td style="text-align: right;">+ @currency($admin)</td>
                </tr>
                <tr>
                    <td colspan="3">Total :</td>
                    <td style="text-align: right;">@currency($pokok * $data->kop_proses_uang_tenor - $admin)</td>
                    <td style="text-align: right;">@currency($total + $admin)</td>
                </tr>
            </tfoot>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="5">
            <tr>
                <td>Yang diterima : @currency($pokok * $data->kop_proses_uang_tenor - $admin)</td>
                <td>Untuk Keperluan</td>
            </tr>
            <tr>
                <td></td>
                <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Necessitatibus, non tempora officiis laborum, voluptate totam nisi mollitia hic consequatur quidem, tempore explicabo? Quisquam rerum doloribus ducimus distinctio provident ipsum fugit!</td>
            </tr>
        </table>

        {{-- <div id="thanks">Thank you!</div> --}}
        <div id="notices">
            <div class="notice">Notes: We really appreciate your business , please
                let us know!</div>
        </div>
    </main>
</body>

</html>
