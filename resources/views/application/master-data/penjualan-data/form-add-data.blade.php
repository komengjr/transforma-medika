<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Add Harga Item <strong>{{$data->t_layanan_cat_name}} - {{$data->p_sales_cat_name}}</strong></h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <form class="row g-3 p-4" action="{{ route('master_penjualan_data_save') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-6">
            <label class="form-label" for="inputAddress">Nama Item</label>
            <select name="name" class="form-control form-control-lg choices-single-pem" id="">
                <option value="">Pilih Pemeriksaan</option>
                @foreach ($pemeriksaan as $pem)
                <option value="{{$pem->t_pemeriksaan_list_code }}">{{$pem->t_pemeriksaan_list_name}}</option>
                @endforeach
            </select>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="code" value="{{$code}}" hidden />
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="code_kategori" value="{{$id}}" hidden />
        </div>
        <div class="col-6">
            <label class="form-label" for="inputAddress">Type Item</label>
            <select name="type" class="form-control form-control-lg choices-single-jenis" id="">
                <option value="">Pilih type</option>
                <option value="single">Single</option>
                <option value="group">Group</option>
            </select>
        </div>
        <div class="col-6">
            <label class="form-label" for="inputAddress">Harga Item</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="price"
                required />
        </div>
        <div class="col-6">
            <label class="form-label" for="inputAddress">Diskon Item</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="disc"
                required />
        </div>
        <div class="col-12">
            <label class="form-label" for="inputAddress">Deskripsi</label>
            <textarea name="desc" class="form-control" id=""></textarea>
        </div>

        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" id="gridCheck" type="checkbox" required />
                <label class="form-check-label" for="gridCheck">Check me</label>
            </div>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit"><span class="fas fa-save"></span> Save</button>
        </div>
    </form>
</div>
<script>
    new window.Choices(document.querySelector(".choices-single-pem"));
    // new window.Choices(document.querySelector(".choices-single-lokasi"));
</script>
