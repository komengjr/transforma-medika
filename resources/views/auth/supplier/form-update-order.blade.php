<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Update Order</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4" id="menu-add-data-pr-all">
        <form class="row" id="form-order-data-supplier">
            @csrf
            <input type="text" name="code" id="code" value="{{ $id }}" hidden>
            <input type="text" name="data_code" value="{{ $data->pem_pr_req_data_code }}" hidden>
            <div class="col-md-4">
                <label for="">Nama Barang</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-scroll"></i></span>
                    <input type="text" name="nama" class="form-control form-control-lg border-start-0 bg-white"
                        value="{{ $data->master_item_name }}" disabled>
                </div>
            </div>
            <div class="col-md-2">
                <label for="">Jumlah Barang</label>
                <div class="input-group">
                    <input type="text" name="jumlah" class="form-control form-control-lg border-start-0 bg-white"
                        value="{{$data->pem_pr_req_data_qty}}"><span
                        class="input-group-text">{{$data->master_item_opt}}</span>
                </div>
            </div>
            <div class="col-md-4">
                <label for="">Harga Barang / <small>{{$data->master_item_opt}}</small></label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-money-check-alt"></i></span>
                    <input type="text" name="harga" class="form-control form-control-lg border-start-0 bg-white"
                        value="@currency($data->pem_pr_order_data_harga)" id="dengan-rupiah">
                </div>
            </div>
            <div class="col-md-2">
                <label for="">Discount</label>
                <div class="input-group">
                    <input type="text" name="discount" value="{{$data->pem_pr_order_data_discount}}"
                        class="form-control form-control-lg border-end-0 bg-white"><span class="input-group-text"><i
                            class="fas fa-percent"></i></span>
                </div>
            </div>
        </form>
        <script src="{{ asset('asset/js/rupiah.js') }}"></script>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-pr">
        <button class="btn btn-success float-end" id="button-simpan-data-order-supp" data-code="">Simpan
            Data</button>
    </span>
</div>
<script src="{{ asset('asset/js/rupiah.js') }}"></script>
