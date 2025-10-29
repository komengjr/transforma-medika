<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Document Stockopname</title>
    <!-- <link rel="stylesheet" href="style.css" media="all" /> -->
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->

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
            /* font-size: 0.7em; */
            white-space: nowrap;
            /* border-top: 1px solid #AAAAAA; */
        }

        table tfoot tr:last-child td {
            color: #db3311;
            /* font-size: 0.9em; */
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
        <div id="company">
            <!-- <div style="margin-top: -20px; font-size: 9px;;">REG/001/POLI/20250201/PRIBADI</div><br> -->
            <h2 class="name" style="margin-top: -20px;  color: #0087C3;font-size: 25px;font-weight: 800;">INNOVENTRA FARMA
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
                        <td style="padding: 1;">No Nota</td>
                        <td style="padding-top: 0;padding-bottom: 0px;">:</td>
                        <td style="padding: 1;">{{$no_reg}}</td>
                    </tr>
                    <tr>
                        <td style="padding: 1;">Tanggal</td>
                        <td style="padding-top: 0;padding-bottom: 0px;">:</td>
                        <td style="padding: 1;">{{ date('d-m-Y H-i-s') }}</td>
                    </tr>

                </table>

            </div>
            <div id="invoice">
                <img src="data:image/png;base64,' . {{DNS1D::getBarcodePNG($no_reg, 'C39', 1, 35)}} . '"
                    alt="barcode" />
                <!-- <div class="date" style="color: #0087C3">{{ date('d-m-Y H-i-s') }}</div><br> -->
                <!-- <span style="font-size: 1em">Form Registrasi Pasien</span> -->
                {{-- <div class="date" style="color: red; font-size: 12px;">Print By : {{ Auth::user()->fullname }}
                </div> --}}
            </div>
        </div>
        <table>
            <thead class="light">
                <tr class="bg-primary">
                    <th style="text-align: left;">Nama Obat</th>
                    <!-- <th class="border-0 text-end">Harga Satuan</th>
                    <th class="border-0 text-center">Quantity</th> -->
                    <th style="text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $rand = mt_rand(1000, 9999);
                    $no = 1;
                @endphp
                @foreach ($list as $lists)
                    <tr style="padding: 1; margin: 0;">
                        <td style="padding: 1; margin: 0;">
                            {{ $lists->farm_data_obat_name}}
                        </td>
                        <!-- <td class="align-middle text-end">@currency($lists->farm_list_log_harga)</td>
                                    <td class="align-middle text-center">{{ $lists->farm_list_log_qty }}</td> -->
                        <td style="text-align: right;padding: 1;margin: 0;">
                            @currency($lists->farm_list_log_harga * $lists->farm_list_log_qty)</td>
                    </tr>
                    @php
                        $total = $total + ($lists->farm_list_log_harga * $lists->farm_list_log_qty);
                    @endphp
                @endforeach

            </tbody>

            <tfoot style=" border-top: 1px solid #020101ff;">
                <tr class="border-top border-top-2 fw-bolder text-900">
                    <td class="text-900">Subtotal:</td>
                    <td style="text-align: right;">@currency($total)</td>
                </tr>
                <tr>
                    <td class="text-900">Tax 8%:</td>
                    <td style="text-align: right;">@currency(0)</td>
                </tr>
                <tr class="border-top">
                    <td class="text-900">Total:</td>
                    <td style="text-align: right;">@currency($total)</td>
                </tr>
                <tr>
                    <td>Amount Due:</td>
                    <td style="text-align: right;">@currency($total)</td>
                </tr>
            </tfoot>
        </table>
        <!-- <div class="details" id="kepala">
        </div> -->

        {{-- <div id="thanks">Thank you!</div> --}}
        <div id="notices">
            <div class="notice">Notes: We really appreciate your business , please
                let us know!</div>
        </div>
    </main>
</body>

</html>
