<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Evaluasi Purchase Order</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-0 pt-3" id="menu-add-data-pr-all">

        <div class="row g-3" id="menu-preview-report-purchase-order">
            <div class="col-12">
                <div class="card border">
                    <div class="card-body bg-light border-top">
                        <div class="row">
                            <div class="col-lg col-xxl-5">
                                <h6 class="fw-semi-bold ls mb-3 text-uppercase">Purchase Request Information</h6>
                                <div class="row">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">ID</p>
                                    </div>
                                    <div class="col">{{$info->pem_pr_order_no}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">Token</p>
                                    </div>
                                    <div class="col">{{$info->pem_pr_order_code}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">Approval</p>
                                    </div>
                                    <div class="col">{{$info->pem_pr_order_app}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">Req Date</p>
                                    </div>
                                    <div class="col">{{$info->pem_pr_order_date}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">User Approval</p>
                                    </div>
                                    <div class="col">
                                        @php
                                            $user = DB::table('hrm_master_pegawai')->where('hrm_m_pegawai_code', $info->pem_pr_order_app)->first();
                                        @endphp
                                        @if ($user)
                                            {{ $user->hrm_m_pegawai_name }}
                                        @else
                                            Belum ditentukan
                                        @endif
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
                                        <div class="col">{{$info->pem_pr_order_payment}}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-sm-6">
                                        <p class="fw-semi-bold mb-1">PPN</p>
                                    </div>
                                    <div class="col">
                                        <div class="col">
                                            @if ($info->pem_pr_order_ppn == 0)
                                                <span class="badge bg-warning">Tidak Dengan PPN</span>
                                            @else
                                                <span class="badge bg-primary">Dengan PPN</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="menu-evaluasi-purchase-order" class="m-0"></div>
            <div class="col-12">
                <div class="card border">
                    <div class="card-body bg-light border-top" id="table-evaluasi-purchase-order">
                        <table id="data_barang" class="table table-striped border" style="width:100%">
                            <thead class="bg-200 text-700">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Quantity</th>
                                    <th>Harga / <small>Item</small> </th>
                                    <th>Discount </th>
                                    <th class="text-end">Total</th>
                                    <th>#</th>
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
                                            @if ($supp)
                                                @if ($supp->pem_pr_order_datas_status == 0)
                                                    <button class="btn btn-falcon-warning btn-sm m-2"
                                                        id="button-checklist-purchase-order"
                                                        data-code="{{ $supp->pem_pr_req_data_code }}"><span
                                                            class="far fa-check-square fs-2"></span></button>
                                                @else
                                                    <button class="btn btn-falcon-success btn-sm m-0"><span
                                                            class="far fa-check-square fs-2"></span></button>
                                                @endif
                                            @endif

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
                                    <td colspan="4" class="text-end">@currency($total)<br><strong
                                            class="text-warning">@currency($total1)</strong></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2">PPN {{ $info->pem_pr_order_ppn_v }} %</td>
                                    <td colspan="4" class="text-end">
                                        @currency($total * $info->pem_pr_order_ppn_v / 100)<br>
                                        <strong
                                            class="text-warning">@currency($total1 * $info->pem_pr_order_ppn_v / 100)</strong>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Total Payment</td>
                                    <td colspan="4" class="text-end">
                                        <strong>@currency($total + ($total * $info->pem_pr_order_ppn_v / 100) - $info->pem_pr_order_discount)<br><strong
                                                class="text-warning">@currency($total1 + ($total1 * $info->pem_pr_order_ppn_v / 100))</strong></strong>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            @if ($payment)
                <div class="col-12 pb-3">
                    <div class="card">
                        <div class="card-header bg-300">
                            <h5 class="mb-0">Payment Method</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="radio" value="" id="credit-card" checked="checked"
                                        name="payment-method">
                                    <label class="form-check-label mb-2 fs-1"
                                        for="credit-card">{{$payment->m_pay_detail_name}}
                                    </label>
                                </div>
                                <div class="row gx-0 ps-2 mb-0">
                                    <div class="col-sm-8 px-0">
                                        <div class="mb-3">
                                            <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0"
                                                for="inputNumber">Card Number</label>
                                            <input class="form-control" id="inputNumber" type="text"
                                                value="{{$payment->pem_pr_order_payment_no_rek}}" disabled>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <label
                                                    class="form-label ls text-uppercase text-600 fw-semi-bold mb-0">Termin (
                                                    Waktu Batas Pembayaran )</label>
                                                <input class="form-control" type="text"
                                                    value="{{ date("d-m-Y", strtotime($payment->pem_pr_order_payment_termin))}}"
                                                    disabled>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0">No Delivery Order<a class="d-inline-block" href="#" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title=""
                                                        data-bs-original-title="Card verification value"
                                                        aria-label="Card verification value"><svg
                                                            class="svg-inline--fa fa-question-circle fa-w-16 ms-2"
                                                            aria-hidden="true" focusable="false" data-prefix="fa"
                                                            data-icon="question-circle" role="img"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                            data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zM262.655 90c-54.497 0-89.255 22.957-116.549 63.758-3.536 5.286-2.353 12.415 2.715 16.258l34.699 26.31c5.205 3.947 12.621 3.008 16.665-2.122 17.864-22.658 30.113-35.797 57.303-35.797 20.429 0 45.698 13.148 45.698 32.958 0 14.976-12.363 22.667-32.534 33.976C247.128 238.528 216 254.941 216 296v4c0 6.627 5.373 12 12 12h56c6.627 0 12-5.373 12-12v-1.333c0-28.462 83.186-29.647 83.186-106.667 0-58.002-60.165-102-116.531-102zM256 338c-25.365 0-46 20.635-46 46 0 25.364 20.635 46 46 46s46-20.636 46-46c0-25.365-20.635-46-46-46z">
                                                            </path>
                                                        </svg><!-- <span class="fa fa-question-circle ms-2"></span> Font Awesome fontawesome.com --></a></label>
                                                <input class="form-control" type="text"
                                                    value="{{ $info->pem_pr_order_do }}" maxlength="3"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 ps-3 text-center pt-2 d-none d-sm-block">
                                        <div class="rounded-1 p-2 mt-3 bg-100">
                                            <div class="text-uppercase fs--2 fw-bold">We Accept</div><img
                                                src="{{ asset('asset/img/icons/icon-payment-methods-grid.png') }}" alt=""
                                                width="120">
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input" type="radio" value="" id="paypal" name="payment-method">
                                            <label class="form-check-label mb-0 ms-2" for="paypal"><img
                                                    src="{{ asset('asset/img/icons/icon-paypal-full.png') }}" height="20" alt="">
                                            </label>
                                        </div> -->
                                <div class="border-dashed-bottom border-primary my-4"></div>
                                <div class="row">
                                    <div class="col-md-7 col-xl-7 col-xxl-7 px-md-3 mb-xxl-0 position-relative">
                                        <div class="d-flex"><img class="me-3"
                                                src="{{ asset('asset/img/icons/shield.png') }}" alt="" width="60"
                                                height="60">
                                            <div class="flex-1">
                                                <h5 class="mb-2">Buyer Protection</h5>
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" id="protection-option-1" type="checkbox"
                                                        checked="checked">
                                                    <label class="form-check-label mb-0" for="protection-option-1">
                                                        <strong>Full Refund </strong>If you don't <br
                                                            class="d-none d-md-block d-lg-none">receive your order</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" id="protection-option-2" type="checkbox"
                                                        checked="checked">
                                                    <label class="form-check-label mb-0" for="protection-option-2">
                                                        <strong>Full or Partial Refund, </strong>If the product is not as
                                                        described in details</label>
                                                </div><a class="fs--1 ms-3 ps-2" href="#!">Learn More<svg
                                                        class="svg-inline--fa fa-caret-right fa-w-6 ms-1"
                                                        data-fa-transform="down-2" aria-hidden="true" focusable="false"
                                                        data-prefix="fas" data-icon="caret-right" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"
                                                        data-fa-i2svg="" style="transform-origin: 0.1875em 0.625em;">
                                                        <g transform="translate(96 256)">
                                                            <g transform="translate(0, 64)  scale(1, 1)  rotate(0 0 0)">
                                                                <path fill="currentColor"
                                                                    d="M0 384.662V127.338c0-17.818 21.543-26.741 34.142-14.142l128.662 128.662c7.81 7.81 7.81 20.474 0 28.284L34.142 398.804C21.543 411.404 0 402.48 0 384.662z"
                                                                    transform="translate(-96 -256)"></path>
                                                            </g>
                                                        </g>
                                                    </svg><!-- <span class="fas fa-caret-right ms-1" data-fa-transform="down-2">    </span> Font Awesome fontawesome.com --></a>
                                            </div>
                                        </div>
                                        <div class="vertical-line d-none d-md-block d-xl-block d-xxl-block"> </div>
                                    </div>
                                    <div
                                        class="col-md-5  col-xl-5 col-xxl-5 ps-lg-4 text-center text-md-start text-xl-center text-xxl-start">
                                        <div class="border-dashed-bottom d-block d-md-none d-xl-none d-xxl-none my-4">
                                        </div>
                                        <div class="fs-2 fw-semi-bold">All Total: <span class="text-primary">
                                                @currency($total1 + ($total1 * $info->pem_pr_order_ppn_v / 100))</span>
                                        </div>
                                        <div id="fotter-menu-evaluasi">
                                            <button class="btn btn-success px-3 mt-3" type="submit"
                                                id="button-save-send-purchase-order"
                                                data-code="{{$info->pem_pr_order_code}}">Confirm Purchase Order</button>
                                        </div>
                                        <p class="fs--1 mt-3 mb-0">By clicking <strong>Confirm &amp; Pay </strong>button you
                                            agree to the <a href="#!">Terms &amp; Conditions</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <span class="text-danger pb-3">Supllier belum isi Payment</span>
            @endif
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
</div>
<script>
    new DataTable('#data_barang', {
        responsive: true,
        // searching: false,
        paging: false,
        info: false
    });
</script>
