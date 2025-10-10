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
                                <h6 class="fw-semi-bold ls mb-3 text-uppercase">Purchase Order Information</h6>
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
            <div class="col-12 pb-3">
                <div class="card border">
                    <div class="card-body bg-light border-top" id="table-purchase-order">
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
                                                @if ($supp->pem_pr_order_datas_status == 1)
                                                    <button class="btn btn-falcon-success btn-sm m-0"
                                                        id="button-terima-barang-purchase-order"
                                                        data-code="{{$info->pem_pr_order_code}}"
                                                        data-id="{{ $datas->pem_pr_req_data_code }}"><span
                                                            class="far fa-check-square"></span> Terima</button>
                                                @elseif ($supp->pem_pr_order_datas_status == 2)
                                                    <button class="btn btn-primary btn-sm">Done</button>
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
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300" id="fotter-menu-purchase-order">
    <button class="btn btn-primary" id="button-save-generate-grn" data-code="{{$info->pem_pr_order_code}}">Save &
        Generate GRN</button>
</div>
<script>
    new DataTable('#data_barang', {
        responsive: true,
        // searching: false,
        paging: false,
        info: false
    });
</script>
