<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Document Report Purchase Request</title>
    <link rel="stylesheet" href="style.css" media="all" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: "Roboto Slab", serif;
            font-optical-sizing: auto;
            font-weight: 500;
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
    </style>
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="data:image/png;base64, {{ $image }}">
        </div>
        <div id="company">
            <div style="margin-top: -20px; font-size: 9px;">PR/001/ACC/{{$info->pem_grn_token_number}}</div><br>
            <h2 class="name" style="margin-top: -20px; font-weight: 900; color: #0087C3;">TRANS PURCHASING</h2>
            <div style="font-size: 11px; padding-bottom: 0px;">Pontianak, Jl Ahmad Yani 3 No 1234</div>
            <div style="font-size: 11px; padding-top: 0px;">0896 9410 7336</div>
        </div>
        </div>
    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">
                <table style="margin: 0px; padding: 0px; font-size: 0.7em;">
                    <tr>
                        <td style="padding: 0;">No Goods Recived Note</td>
                        <td style="padding-top: 0;padding-bottom: 0px;">:</td>
                        <td style="padding: 0;">{{$info->pem_grn_token_number}}</td>
                    </tr>
                    <tr>
                        <td style="padding: 0;">No Invoice</td>
                        <td style="padding-top: 0;padding-bottom: 0px;">:</td>
                        <td style="padding: 0;"><strong style="color: red;">{{$info->pem_grn_token_invoice}}</strong>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="invoice">
                <span style="font-size: 1em;color: #0087C3; font-weight: 800;"><strong>GOODS RECIVED NOTE</strong></span>
                {{-- <div class="date" style="color: red; font-size: 12px;">Print By : {{ Auth::user()->fullname }}
                </div> --}}
                <div class="date" style="color: #080803ff">{{ date('d-m-Y H-i-s') }}, Print By :
                    {{ Auth::user()->fullname }}
                </div>
                <img src="data:image/png;base64,' . {{DNS1D::getBarcodePNG($info->pem_grn_token_number, 'C39', 1, 35)}} . '"
                    alt="barcode" />
            </div>
        </div>
        <!-- <h5 style="margin-bottom: 0px;">PURCHASE ORDER - HARGA DEAL</h5> -->
        <table border="1" cellspacing="0" cellpadding="0" style="width: 100%; margin-bottom: 15px;">
            <thead style="font-size: 10px;">
                <tr>
                    <th class="no" style="width: 5%;">#</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Harga / <small>Item</small> </th>
                    <th>Discount</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody id="invoiceItems" style="font-size: 8px;">
                @php
                    $no = 1;
                    $total = 0;
                @endphp
                @foreach ($data_supp as $data_supps)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data_supps->master_item_name }}</td>
                        <td style="text-align: center; width: 5%;">{{ $data_supps->pem_pr_order_datas_qty }} </td>
                        <td style="text-align: right;">
                            @currency($data_supps->pem_pr_order_datas_harga) /
                            <small>{{ $data_supps->master_item_opt }}</small>
                        </td>
                        <td style="text-align: right;">
                            -
                            @currency($data_supps->pem_pr_order_datas_harga * $data_supps->pem_pr_order_datas_qty * $data_supps->pem_pr_order_datas_discount / 100)
                            <small>{{ $data_supps->pem_pr_order_datas_discount }} %</small>
                            <br>

                        </td>
                        <td style="text-align: right;">
                            @currency(($data_supps->pem_pr_order_datas_harga * $data_supps->pem_pr_order_datas_qty) - ($data_supps->pem_pr_order_datas_harga * $data_supps->pem_pr_order_datas_qty * $data_supps->pem_pr_order_datas_discount / 100))
                        </td>
                    </tr>
                    @php
                        $total = $total + (($data_supps->pem_pr_order_datas_harga * $data_supps->pem_pr_order_datas_qty) - ($data_supps->pem_pr_order_datas_harga * $data_supps->pem_pr_order_datas_qty * $data_supps->pem_pr_order_datas_discount / 100));
                    @endphp
                @endforeach
            </tbody>
            <tfoot class="bg-primary text-white" style=" border-top: 1px solid #000000ff;">
                <tr>
                    <td colspan="6">Total <span style="float: right;">@currency($total)</span></td>
                    <!-- <td colspan="3" style="text-align: right;"></td> -->
                </tr>
                <tr>
                    <td colspan="6">PPN {{ $info->pem_pr_order_ppn_v }} % <span
                            style="float: right;">@currency($total * $info->pem_pr_order_ppn_v / 100)</span></td>
                    <!-- <td colspan="3" style="text-align: right;"> -->
                    </td>
                </tr>
                <tr>
                    <td colspan="6">Total Payment <strong
                            style="float: right;">@currency($total + ($total * $info->pem_pr_order_ppn_v / 100) - $info->pem_pr_order_discount)</strong>
                    </td>
                    <!-- <td colspan="3" style="text-align: right;"> -->

                    </td>
                </tr>
            </tfoot>
        </table>
        {{-- <div id="thanks">Thank you!</div> --}}
        <div id="notices">
            <img style="padding-top: 1px; left: 10px;"
                src="data:image/png;base64, {!! base64_encode(QrCode::style('round')->eye('circle')->format('svg')->size(30)->errorCorrection('H')->generate(123), ) !!}">
            <div class="notice">Notes: We really appreciate your business and if there’s anything else we can do, please
                let us know!</div>
        </div>
    </main>
</body>

</html>
