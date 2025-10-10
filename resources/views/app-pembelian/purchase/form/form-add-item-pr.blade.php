<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Item Request</h4>
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
                <form class="row" id="form-input-item-pr">
                    @csrf
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Type Item</label>
                        <div class="input-group"> <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <select name="type" class="form-control form-control-lg" id="type">
                                <option value="">Pilih Type</option>
                                <option value="brg">Barang</option>
                                <option value="jasa">Jasa</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Nama Item</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                           <select name="item" class="form-control form-control-lg" id="item">
                                <option value="">Pilih Item</option>
                                @foreach ($item as $items)
                                <option value="{{$items->master_item_code}}">{{$items->master_item_name}}</option>
                                @endforeach
                            </select>
                            <input type="text" name="code" id="" value="{{ $code }}" hidden>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputLastName1" class="form-label text-youtube">Jumlah Barang</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="qty" id="qty"
                                class="form-control form-control-lg border-start-0 bg-white" id="dengan-rupiah">
                        </div>
                    </div>


                    <div class="col-12 pt-3">
                        <button class="btn btn-primary float-end" id="button-simpan-item-pr-data">Add
                            Data</button>
                    </div>
                </form>
            </div>
            <div class="col-12">
                <div class="card border">
                    <div class="card-body bg-light border-top" id="table-barang-request">
                        <table id="data_barang" class="table table-striped nowrap" style="width:100%">
                            <thead class="bg-200 text-700 fs--2">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
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
                                        <td>{{ $datas->pem_pr_req_data_qty }}</td>
                                        <td class="text-center"><button class="btn btn-danger btn-sm"
                                                id="button-remove-item-pr"
                                                data-id="{{ $datas->pem_pr_req_data_code }}" data-code="{{ $code }}"><span
                                                    class="fas fa-trash"></span></button></td>
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
    <span id="menu-add-data-pr">
        <button class="btn btn-success float-end" id="button-simpan-item-pr" data-code="{{ $code }}">Simpan
            Data</button>
    </span>
</div>
<script>
    new DataTable('#data_barang', {
        responsive: true
    });
</script>
<!-- <script src="{{ asset('asset/js/rupiah.js') }}"></script> -->
