<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Document Stockopname</title>
    <link rel="stylesheet" href="style.css" media="all" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
            margin-bottom: 10px;
        }

        #client {
            padding-top: 35px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
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
            background: #01929fff;
            color: white;
        }

        table td {
            text-align: left;
        }

        table td h3 {
            color: #db3311;
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

        table tfoot td {
            /* padding: 10px 20px; */
            background: #FFFFFF;
            /* border-bottom: none; */
            font-size: 0.7em;
            white-space: nowrap;
            /* border-top: 1px solid #AAAAAA; */
        }

        table tfoot tr:last-child td {
            color: #db3311;
            font-size: 0.9em;
            border-top: 1px solid #db3311;
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
    </style>
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="data:image/png;base64, {{ $image }}">
        </div>
        <div id="company">
            <div style="margin-top: -20px; font-size: 9px;;">REG/001/POLI/20250201/PRIBADI</div><br>
            <h2 class="name" style="margin-top: -20px;  color: #0087C3;font-size: 25px;font-weight: 800;">Innovenrta
                Medic
            </h2>
            <div>Lorem, ipsum dolor sit amet thanks</div>
            <!-- <div>092 82733</div> -->
        </div>
        </div>
    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">
                {{-- <h2 class="name">
                </h2>
                <div class="address"></div> --}}

                <table style="margin: 0px; padding: 0px; font-size: 0.8em; ">
                    <tr>
                        <td style="padding: 1;">No Registrasi</td>
                        <td style="padding-top: 0;padding-bottom: 0px;">:</td>
                        <td style="padding: 1;">{{$code}}</td>
                    </tr>
                    <tr>
                        <td style="padding: 1;">Nama Pasien</td>
                        <td style="padding-top: 0;padding-bottom: 0px;">:</td>
                        <td style="padding: 1;">
                            {{$pasien->master_patient_name}}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 1;">Umur / Tanggal Lahir</td>
                        <td style="padding-top: 0;padding-bottom: 0px;">:</td>
                        <td style="padding: 1;">
                           {{ $umur }} / {{$pasien->master_patient_tgl_lahir}}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 1;">Tanggal Registrasi</td>
                        <td style="padding-top: 0;padding-bottom: 0px;">:</td>
                        <td style="padding: 1;">
                            {{$pasien->d_reg_order_date}}
                        </td>
                    </tr>
                </table>

            </div>
            <div id="invoice">
                <img src="data:image/png;base64,' . {{DNS1D::getBarcodePNG($code, 'C39', 1, 35)}} . '" alt="barcode" />
                <div class="date" style="color: #0087C3">{{ date('d-m-Y H-i-s') }}</div><br>
                <!-- <span style="font-size: 1em">Form Registrasi Pasien</span> -->
                {{-- <div class="date" style="color: red; font-size: 12px;">Print By : {{ Auth::user()->fullname }}
                </div> --}}

            </div>
        </div>
        <div class="details" id="kepala">
            <strong style="margin: 0; padding: 0; margin-left: 4px;">Pemeriksaan Fisik</strong>
            <table style="font-size: 8px;">
                <tr>
                    @foreach ($fisik as $f)
                        <td style="padding: 4px;">
                            <div id="kepala">
                                {{ $f->diag_poli_fisik_umum_name }} <br><small>{{ $f->diag_poli_fisik_umum_d_val }}
                                    {{ $f->diag_poli_fisik_satuan }}</small>
                            </div>
                        </td>
                    @endforeach
                </tr>
            </table>
        </div>
        <table style="padding-top: 10px; font-size: 10px;">
            <tr>
                <td style="padding: 0; padding-right: 5px; vertical-align: top; width: 40%;">
                    <div class="details" id="kepala">
                        <strong style="margin: 0; padding: 0;">Diagnosa Pada Gigi</strong>
                        <hr>
                        @foreach ($umum as $umums)
                            <li style="margin-left: 15px;">{{ $umums->diag_poli_gigi_umum_name }}
                                <small>{{ $umums->diag_poli_gigi_umum_desc }}</small>
                            </li>
                        @endforeach
                    </div>
                </td>
                <td style="padding: 0; padding-left: 5px;vertical-align: top; width: 60%;">
                    <div class="details" id="kepala">
                        <strong style="margin: 0; padding: 0;">Diagnosa Odontogram</strong>
                        <hr>
                        @foreach ($odon as $od)
                            <li style="margin-left: 15px;">Gigi No. {{ $od->diag_poli_gigi_odon_no }}
                                <small style="color: #db3311;">{{ $od->diag_poli_gigi_odon_val }}</small>
                            </li>
                        @endforeach
                    </div>
                </td>
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
