<div class="d-flex mb-4"><span class="fa-stack me-2 ms-n1"><svg
            class="svg-inline--fa fa-circle fa-w-16 fa-stack-2x text-300" aria-hidden="true" focusable="false"
            data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
            data-fa-i2svg="">
            <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path>
        </svg><!-- <i class="fas fa-circle fa-stack-2x text-300"></i> Font Awesome fontawesome.com --><svg
            class="svg-inline--fa fa-spinner fa-w-16 fa-inverse fa-stack-1x text-primary" aria-hidden="true"
            focusable="false" data-prefix="fas" data-icon="spinner" role="img" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512" data-fa-i2svg="">
            <path fill="currentColor"
                d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z">
            </path>
        </svg><!-- <i class="fa-inverse fa-stack-1x text-primary fas fa-spinner"></i> Font Awesome fontawesome.com --></span>
    <div class="col">
        <h5 class="mb-0 text-primary position-relative">Prosess Verifikasi Purchase Orders
            <span class="border position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
        </h5>
        <p class="mb-0">You can easily show your stats content by using these cards.</p>
    </div>
</div>
<div class="row g-3" id="menu-preview-report-purchase-order">
    <div class="col-12">
        <div class="card border">
            <div class="card-body bg-light border-top">
                <div class="row">
                    <div class="col-lg col-xxl-5">
                        <h6 class="fw-semi-bold ls mb-3 text-uppercase">Purchase Order Information</h6>
                        <div class="row">
                            <div class="col-6 col-sm-6">
                                <p class="fw-semi-bold mb-1">No Purchase Order</p>
                            </div>
                            <div class="col">{{$info->pem_pr_order_no}}</div>
                            <input type="text" name="code_po" id="code_po" value="{{$info->pem_pr_order_code}}" hidden>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6">
                                <p class="fw-semi-bold mb-1">Req Date</p>
                            </div>
                            <div class="col">{{$info->pem_pr_order_date}}</div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6">
                                <p class="fw-semi-bold mb-1">User Approval</p>
                            </div>
                            <div class="col">
                                ******
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 col-sm-4">
                                <small>Harga Penawaran</small>
                            </div>
                            <div class="col">
                                Rp. xx.000
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 col-sm-4">
                                <small>Harga Supplier</small>
                            </div>
                            <div class="col">
                                <strong class="text-warning">Rp. xx.000</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg col-xxl-5 mt-4 mt-lg-0 offset-xxl-1">
                        <h6 class="fw-semi-bold ls mb-3 text-uppercase">Supplier Information</h6>
                        <div class="row">
                            <div class="col-6 col-sm-6">
                                <p class="fw-semi-bold mb-1">Supplier Name</p>
                            </div>
                            <div class="col">{{$info->master_supplier_name}}</div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6">
                                <p class="fw-semi-bold mb-1">No Hp</p>
                            </div>
                            <div class="col">{{$info->master_supplier_phone}}</div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6">
                                <p class="fw-semi-bold mb-1">Email</p>
                            </div>
                            <div class="col">{{$info->master_supplier_email}}</div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6">
                                <p class="fw-semi-bold mb-1">Methode Payment</p>
                            </div>
                            <div class="col">
                                <div class="col">-</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-6">
                                <p class="fw-semi-bold mb-1">PPN</p>
                            </div>
                            <div class="col">
                                <div class="col">
                                    {{$info->pem_pr_order_ppn_v}} %
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 pb-3">
        <div class="card border">
            <div class="card-body bg-light border-top" id="table-barang-request-order">
                <table id="data_barang" class="table table-striped border" style="width:100%">
                    <thead class="bg-200 text-700">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Quantity</th>
                            <th>Harga / <small>Item</small> </th>
                            <th>Discount </th>
                            <th class="text-end">Total</th>
                            <th class="text-center">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                            $total = 0;
                            $total1 = 0;
                        @endphp
                        @foreach ($data as $datas)
                            @php
                                $supp = DB::table('pem_pr_order_datas')
                                    ->join('pem_pr_req_data', 'pem_pr_req_data.pem_pr_req_data_code', '=', 'pem_pr_order_datas.pem_pr_req_data_code')
                                    ->join('master_item', 'master_item.master_item_code', '=', 'pem_pr_req_data.master_item_code')
                                    ->where('pem_pr_order_datas.pem_pr_req_data_code', $datas->pem_pr_req_data_code)->first();
                            @endphp
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $datas->master_item_name }}</td>
                                <td>{{ $datas->pem_pr_req_data_qty }} {{ $datas->master_item_opt }}</td>
                                <td>
                                    @currency($datas->pem_pr_order_data_harga)
                                    / <small>{{ $datas->master_item_opt }}</small>
                                    @if ($supp)
                                        <br>
                                        <strong class="text-warning">@currency($supp->pem_pr_order_datas_harga)</strong>
                                    @endif
                                </td>
                                <td>
                                    -
                                    @currency($datas->pem_pr_order_data_harga * $datas->pem_pr_req_data_qty * $datas->pem_pr_order_data_discount / 100)
                                    ( {{ $datas->pem_pr_order_data_discount }} % )
                                    @if ($supp)
                                        <br>
                                        <strong class="text-warning">
                                            -
                                            @currency($supp->pem_pr_order_datas_harga * $supp->pem_pr_order_datas_qty * $supp->pem_pr_order_datas_discount / 100)
                                            ( {{ $supp->pem_pr_order_datas_discount }} % )
                                        </strong>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @currency(($datas->pem_pr_order_data_harga * $datas->pem_pr_req_data_qty) - ($datas->pem_pr_order_data_harga * $datas->pem_pr_req_data_qty * $datas->pem_pr_order_data_discount / 100))
                                    @if ($supp)
                                        <br>
                                        <strong class="text-warning">
                                            @currency(($supp->pem_pr_order_datas_harga * $supp->pem_pr_order_datas_qty) - ($supp->pem_pr_order_datas_harga * $supp->pem_pr_order_datas_qty * $supp->pem_pr_order_datas_discount / 100))
                                        </strong>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal-supplier"
                                        id="button-update-order" data-code="{{ $datas->pem_pr_order_data_code }}"
                                        data-id="{{$info->pem_pr_order_code}}"><span
                                            class="far fa-edit text-warning"></span></a>
                                </td>
                            </tr>
                            @php
                                $total = $total + (($datas->pem_pr_order_data_harga * $datas->pem_pr_req_data_qty) - ($datas->pem_pr_order_data_harga * $datas->pem_pr_req_data_qty * $datas->pem_pr_order_data_discount / 100));

                            @endphp
                            @if ($supp)
                                @php
                                    $total1 = $total1 + (($supp->pem_pr_order_datas_harga * $supp->pem_pr_order_datas_qty) - ($supp->pem_pr_order_datas_harga * $supp->pem_pr_order_datas_qty * $supp->pem_pr_order_datas_discount / 100));
                                @endphp
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot class="bg-300 text-dark border-white">
                        <tr>
                            <td colspan="2">Total</td>
                            <td colspan="4" class="text-end">@currency($total) <br> <strong
                                    class="text-warning">@currency($total1)</strong></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">PPN {{ $info->pem_pr_order_ppn_v }} %</td>
                            <td colspan="4" class="text-end">@currency($total * $info->pem_pr_order_ppn_v / 100) <br>
                                <strong
                                    class="text-warning">@currency($total1 * $info->pem_pr_order_ppn_v / 100)</strong>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="2">Total Payment</td>
                            <td colspan="4" class="text-end">
                                <strong>@currency($total + ($total * $info->pem_pr_order_ppn_v / 100) - $info->pem_pr_order_discount)<br>
                                    <strong
                                        class="text-warning">@currency($total1 + ($total1 * $info->pem_pr_order_ppn_v / 100))</strong></strong>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
