<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Preview Purchase Order</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-0 pt-3" id="menu-add-data-pr-all">
        <div class="row g-3 pb-2">
            <div class="col-12">
                <div class="card border bg-primary">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="" data-bs-original-title="Print" aria-label="Print"
                                id="button-preview-report-purchase-order"
                                data-code="{{ $info->pem_pr_order_code }}"><span class="fas fa-print"></span> Print
                                Preview</button>
                            <span class="mx-1 mx-sm-2 text-300">|</span>
                            <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="" data-bs-original-title="Archive"
                                aria-label="Archive"><span class="fab fa-firefox-browser"></span></button>

                        </div>
                        <div class="d-flex">
                            <div class="dropdown font-sans-serif">
                                <button
                                    class="btn btn-falcon-default text-600 btn-sm dropdown-toggle dropdown-caret-none ms-2"
                                    type="button" id="email-settings" data-bs-toggle="dropdown" data-boundary="viewport"
                                    aria-haspopup="true" aria-expanded="false"><svg
                                        class="svg-inline--fa fa-cog fa-w-16" aria-hidden="true" focusable="false"
                                        data-prefix="fas" data-icon="cog" role="img" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z">
                                        </path>
                                    </svg><!-- <span class="fas fa-cog"></span> Font Awesome fontawesome.com --></button>
                                <div class="dropdown-menu dropdown-menu-end border py-2"
                                    aria-labelledby="email-settings">
                                    <a class="dropdown-item" href="#!">Configure Purchase Order</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#!" onclick="window.open('{{route('app_supp_token', ['id' => $info->master_supplier_code, 'token' => $info->pem_pr_order_code])}}','_blank');">Verifikasi
                                        Purchase Order</a>
                                    <a class="dropdown-item" href="#!">Send Code Verifikasi</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#!">Send to Supplier</a>
                                    <a class="dropdown-item" href="#!">Help</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                        <p class="fw-semi-bold mb-1">Req Name</p>
                                    </div>
                                    <div class="col">{{$info->pem_pr_order_code}}</div>
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
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                    $total = 0;
                                @endphp
                                @foreach ($data as $datas)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $datas->master_item_name }}</td>
                                        <td>{{ $datas->pem_pr_req_data_qty }} {{ $datas->master_item_opt }}</td>
                                        <td>
                                            @currency($datas->pem_pr_order_data_harga)
                                            / <small>{{ $datas->master_item_opt }}</small>
                                        </td>
                                        <td>
                                            -
                                            @currency($datas->pem_pr_order_data_harga * $datas->pem_pr_req_data_qty * $datas->pem_pr_order_data_discount / 100)
                                            ( {{ $datas->pem_pr_order_data_discount }} % )
                                        </td>
                                        <td class="text-end">
                                            @currency(($datas->pem_pr_order_data_harga * $datas->pem_pr_req_data_qty) - ($datas->pem_pr_order_data_harga * $datas->pem_pr_req_data_qty * $datas->pem_pr_order_data_discount / 100))
                                        </td>
                                    </tr>
                                    @php
                                        $total = $total + (($datas->pem_pr_order_data_harga * $datas->pem_pr_req_data_qty) - ($datas->pem_pr_order_data_harga * $datas->pem_pr_req_data_qty * $datas->pem_pr_order_data_discount / 100));
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot class="bg-primary text-white">
                                <tr>
                                    <td colspan="2">Total</td>
                                    <td colspan="4" class="text-end">@currency($total)</td>
                                </tr>
                                <tr>
                                    <td colspan="2">PPN {{ $info->pem_pr_order_ppn_v }} %</td>
                                    <td colspan="4" class="text-end">@currency($total * $info->pem_pr_order_ppn_v / 100)
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">Total Payment</td>
                                    <td colspan="4" class="text-end">
                                        <strong>@currency($total + ($total * $info->pem_pr_order_ppn_v / 100) - $info->pem_pr_order_discount)</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
</div>
<script>
    new DataTable('#data_barang', {
        responsive: true
    });
</script>
