<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Item Purchase Order</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-0" id="menu-add-data-pr-all">
        <div class="row g-3">
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
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">Supplier Name</p>
                                    </div>
                                    <div class="col">{{$info->master_supplier_name}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">No Hp</p>
                                    </div>
                                    <div class="col">{{$info->master_supplier_phone}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">Email</p>
                                    </div>
                                    <div class="col">{{$info->master_supplier_email}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">Methode Payment</p>
                                    </div>
                                    <div class="col">
                                        <div class="col">{{$info->pem_pr_order_payment}}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5 col-sm-4">
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
            <div class="col-12" id="menu-data-order">

            </div>
        </div>
        <div class="row g-3 pb-3" id="table-barang-request-order">
            <div class="col-md-6">
                <div class="card border">
                    <div class="card-body bg-light border-top">
                        <table id="data_barang" class="table table-striped border" style="width:100%">
                            <thead class="bg-200 text-700 fs--2">
                                <tr>
                                    <th>No</th>
                                    <th>No Purchase Req</th>
                                    <th>Nama Barang</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @if (!$data->isEmpty())
                                    @foreach ($data as $datas)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $datas->pem_pr_req_nomor }} <br> <small>{{ $datas->pem_pr_req_name }}</small>
                                            </td>
                                            <td>{{ $datas->master_item_name }}</td>
                                            <td>{{ $datas->pem_pr_req_data_type }}</td>
                                            <td>{{ $datas->pem_pr_req_data_qty }} {{ $datas->master_item_opt }}</td>
                                            <td class="text-end">
                                                @php
                                                    $cek = DB::table('pem_pr_order_data')->where('pem_pr_req_data_code', $datas->pem_pr_req_data_code)->first();
                                                @endphp
                                                @if ($cek)
                                                    <span class="badge bg-primary">Ok</span>
                                                @else
                                                    <button class="btn btn-warning btn-sm" id="button-pilih-item-order"
                                                        data-id="{{ $datas->pem_pr_req_data_code }}" data-code="{{ $code }}"><span
                                                            class="far fa-arrow-alt-circle-right"></span></button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border">
                    <div class="card-body bg-light border-top" id="table-barang-request-order">
                        <table id="data_barang_req" class="table table-striped border" style="width:100%">
                            <thead class="bg-200 text-700 fs--2">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($order as $orders)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $orders->master_item_name }}</td>
                                        <td>{{ $orders->pem_pr_req_data_type }}</td>
                                        <td>{{ $orders->pem_pr_req_data_qty }} {{ $orders->master_item_opt }}</td>
                                        <td class="text-end">
                                            <button class="btn btn-danger btn-sm" id="button-remove-item-order"
                                                data-id="{{ $orders->pem_pr_req_data_code }}" data-code="{{ $code }}"><span
                                                    class="far fa-trash-alt"></span></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-proses-data-order">
        <button class="btn btn-success float-end" id="button-simpan-proses-purchase-order"
            data-code="{{ $code }}">Simpan
            Data</button>
    </span>
</div>
<script>
    new DataTable('#data_barang', {
        responsive: true
    });
    new DataTable('#data_barang_req', {
        responsive: true
    });
</script>
