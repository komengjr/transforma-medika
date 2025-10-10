<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Document Stockopname</title>
    <link rel="stylesheet" href="style.css" media="all" />
</head>
<style>
    @font-face {
        font-family: SourceSansPro;
        src: url(SourceSansPro-Regular.ttf);
    }

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
        margin-bottom: 10px;
    }

    #client {
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
        background: #373332;
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

    /* table tbody tr:last-child td {
        border: none;
    } */

    table tfoot td {
        padding: 10px 20px;
        background: #FFFFFF;
        /* border-bottom: none; */
        font-size: 1.2em;
        white-space: nowrap;
        /* border-top: 1px solid #AAAAAA; */
    }

    /* table tfoot tr:first-child td {
        border-top: none;
    } */

    table tfoot tr:last-child td {
        color: #db3311;
        font-size: 1.4em;
        border-top: 1px solid #db3311;

    }

    /* table tfoot tr td:first-child {
        border: none;
    } */

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
        font-size: 1.0em;
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
</style>
{{-- @php
    $no_doc = DB::table('master_doocument_cab')
        ->where('master_document_code', '=', 'MC')
        ->where('kd_cabang', $cabang->kd_cabang)
        ->first();
@endphp
@if ($no_doc)
    @php
        $no = $no_doc->master_document_no;
    @endphp
@else
    @php
        $no = 'Nomor Dokumen Belum Di isi';
    @endphp
@endif --}}

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="data:image/png;base64, {{ $image }}">
        </div>
        <div id="company">
            <div style="margin-top: -20px; font-size: 9px;;">REG/001/IGD/20250201/ASURANSI</div><br>
            <h2 class="name">Transforma Medika</h2>
            <div>Lorem, ipsum dolor sit amet consectetur adipisicing elit</div>
            <div>092 82733</div>
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
                        <td>No Registrasi</td>
                        <td>:</td>
                        <td>{{$code}}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Registrasi</td>
                        <td>:</td>
                        <td>
                            -
                        </td>
                    </tr>
                    {{-- <tr>
                        <td>Tanggal Buat Laporan</td>
                        <td>:</td>
                        <td>
                            -
                        </td>
                    </tr> --}}

                </table>
            </div>
            <div id="invoice">
                <span style="font-size: 1em">Form Registrasi Pasien</span>
                {{-- <div class="date" style="color: red; font-size: 12px;">Print By : {{ Auth::user()->fullname }}</div> --}}
                <div class="date" style="color: #0087C3">{{ date('d-m-Y H-i-s') }}</div><br>
                <img src="data:image/png;base64,' . {{DNS1D::getBarcodePNG($code, 'C39',1,35)}} . '" alt="barcode"   />
            </div>
        </div>
        <br>

        {{-- <div id="thanks">Thank you!</div> --}}
        <div id="notices">
            <img style="padding-top: 1px; left: 10px;" src="data:image/png;base64, {!! base64_encode(
                QrCode::style('round')->eye('circle')->format('svg')->size(70)->errorCorrection('H')->generate(123),
            ) !!}">
            <div class="notice">Notes: We really appreciate your business and if there’s anything else we can do, please
                let us know!</div>
        </div>
    </main>
</body>

</html>
