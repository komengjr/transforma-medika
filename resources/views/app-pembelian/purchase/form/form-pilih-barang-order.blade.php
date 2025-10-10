<div class="card border mb-3">
    <div class="card-body">
        <form class="row" id="form-fix-data-order">
            @csrf
            <input type="text" name="code" value="{{ $code }}" hidden>
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
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-sort-numeric-up"></i></span>
                    <input type="text" name="jumlah" class="form-control form-control-lg border-start-0 bg-white"
                        value="{{$data->pem_pr_req_data_qty}} {{$data->master_item_opt}}" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <label for="">Harga Barang / <small>{{$data->master_item_opt}}</small></label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-money-check-alt"></i></span>
                    <input type="text" name="harga" class="form-control form-control-lg border-start-0 bg-white"
                        id="dengan-rupiah">
                </div>
            </div>
            <div class="col-md-2">
                <label for="">Discount</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-percent"></i></span>
                    <input type="text" name="discount" class="form-control form-control-lg border-start-0 bg-white" >
                </div>
            </div>
            <div class="col-12 pt-3">
                <button class="btn btn-primary float-end" id="button-simpan-item-purchase-order">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('asset/js/rupiah.js') }}"></script>
