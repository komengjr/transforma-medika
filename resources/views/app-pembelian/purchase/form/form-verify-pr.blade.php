<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Verify Purchase Request</h4>
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
                                    <div class="col">{{$info->pem_pr_req_nomor}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">Req Name</p>
                                    </div>
                                    <div class="col">{{$info->pem_pr_req_name}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">Req Date</p>
                                    </div>
                                    <div class="col">{{$info->pem_pr_req_date}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">Req Date Require</p>
                                    </div>
                                    <div class="col">
                                        <div class="col">{{$info->pem_pr_req_date_require}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg col-xxl-5 mt-4 mt-lg-0 offset-xxl-1">
                                <h6 class="fw-semi-bold ls mb-3 text-uppercase">User Information</h6>
                                <div class="row">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">Request By</p>
                                    </div>
                                    <div class="col">{{$info->pem_pr_req_by}}</div>
                                </div>
                                <div class="row">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">Approval By</p>
                                    </div>
                                    <div class="col">
                                        <div class="col">{{$info->pem_pr_req_app_by}}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5 col-sm-4">
                                        <p class="fw-semi-bold mb-1">Create By</p>
                                    </div>
                                    <div class="col">{{$info->pem_pr_req_create_by}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card border">
                    <div class="card-body bg-light border-top" id="table-barang-request">
                        <table id="data_barang" class="table border" style="width:100%">
                            <thead class="bg-200 text-700">
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
                                @foreach ($data as $datas)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $datas->master_item_name }}</td>
                                        <td>{{ $datas->pem_pr_req_data_type }}</td>
                                        <td>{{ $datas->pem_pr_req_data_qty }} {{ $datas->master_item_opt }}</td>
                                        <td class="text-end"><button class="btn btn-warning btn-sm">Edit</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">

            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-verify-data-pr">
        <button class="btn btn-success float-end" id="button-verify-purchase-req" data-code="{{ $code }}">Verify Data</button>
        <button class="btn btn-danger float-end me-2" id="button-reject-purchase-req" data-code="{{ $code }}">Reject Data</button>
    </span>
</div>
<!-- <script src="{{ asset('asset/js/rupiah.js') }}"></script> -->
