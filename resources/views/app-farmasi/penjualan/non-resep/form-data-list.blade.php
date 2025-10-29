<div class="modal-body p-0">
    <div class="bg-success rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Item Request</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-2 pb-0" id="menu-add-data-pr-all">
        <div class="card mb-2 border border-success">
            <div class="card-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md">
                        <h5 class="mb-2 mb-md-0">Order #{{$code}}</h5>
                    </div>
                    <div class="col-auto">

                        <!-- <button class="btn btn-falcon-default btn-sm me-1 mb-2 mb-sm-0" type="button"><i
                                class="fas fa-print"></i>Print</button> -->
                        <button class="btn btn-falcon-success btn-sm mb-2 mb-sm-0" type="button"
                            id="button--payment-penjualan-obat" data-code="{{ $code }}"><i class="fas fa-donate"></i>
                            Payment</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3 border border-success" id="menu-data-list-obat">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">

                        <h5>FARMASI {{env('APP_NAME')}}</h5>
                        <p class="fs--1">1954 Bloor Street West<br>Torronto ON, M6P 3K9<br>Canada</p>

                    </div>
                    <div class="col-sm-auto ms-auto">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless fs--1">
                                <tbody>
                                    <!-- <tr>
                                        <th class="text-sm-end">Invoice No:</th>
                                        <td>{{$code}}</td>
                                    </tr> -->
                                    <tr>
                                        <th class="text-sm-end">Order Number:</th>
                                        <td>{{$code}}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-sm-end">Invoice Date:</th>
                                        <td>2018-09-25</td>
                                    </tr>
                                    <tr>
                                        <th class="text-sm-end">Payment Due:</th>
                                        <td>Upon receipt</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="table-responsive scrollbar mt-4 fs-1">
                    <table class="table table-striped border-bottom">
                        <thead class="light">
                            <tr class="bg-primary text-white dark__bg-1000">
                                <th class="border-0">Nama Obat</th>
                                <th class="border-0 text-end">Harga Satuan</th>
                                <th class="border-0 text-center">Quantity</th>
                                <th class="border-0 text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                                $rand = mt_rand(1000, 9999);
                                $no = 1;
                            @endphp
                            @foreach ($list as $lists)
                                <tr>
                                    <td class="align-middle">
                                        <h6 class="mb-0 text-nowrap">{{ $lists->farm_data_obat_name}}</h6>
                                        <p class="mb-0">{{ $lists->farm_data_obat_code}}</p>
                                    </td>
                                    <td class="align-middle text-end">@currency($lists->farm_list_log_harga)</td>
                                    <td class="align-middle text-center">{{ $lists->farm_list_log_qty }}</td>
                                    <td class="align-middle text-end">
                                        @currency($lists->farm_list_log_harga * $lists->farm_list_log_qty)</td>
                                </tr>
                                @php
                                    $total = $total + ($lists->farm_list_log_harga * $lists->farm_list_log_qty);
                                @endphp
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <table class="table table-sm table-borderless fs-1 text-end">
                            <tbody>
                                <tr>
                                    <th class="text-900">Subtotal:</th>
                                    <td class="fw-semi-bold">@currency($total)</td>
                                </tr>
                                <tr>
                                    <th class="text-900">Tax 8%:</th>
                                    <td class="fw-semi-bold">@currency(0)</td>
                                </tr>
                                <tr class="border-top">
                                    <th class="text-900">Total:</th>
                                    <td class="fw-semi-bold">@currency($total)</td>
                                </tr>
                                <tr class="border-top border-top-2 fw-bolder text-900">
                                    <th>Amount Due:</th>
                                    <td>@currency($total)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border ">
                <p class="fs--1 mb-0"><strong>Notes: </strong>We really appreciate your business and if there’s anything
                    else we can do, please let us know!</p>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">

</div>
<script>
    function printInvoice() {
        window.print();
    }
</script>
