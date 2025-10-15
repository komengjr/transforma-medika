<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Add Cabang</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <form class="row g-3 p-4" action="{{ route('master_cabang_save') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-4">
            <label class="form-label" for="inputAddress">Nama Cabang</label>
            <input class="form-control" id="inputAddress" type="text" name="nama" placeholder="dashboard" required />
        </div>
        <div class="col-4">
            <label class="form-label" for="inputAddress">Pilih Entitas</label>
            <select name="entitas" class="form-control" id="">
                <option value="">Pilih Perusahaan</option>
                <option value="A">Perusahaan A</option>
            </select>
        </div>
        <div class="col-4">
            <label class="form-label" for="inputAddress">City</label>
            <input class="form-control" id="inputAddress" type="text" name="city" placeholder="page/detail" required />
        </div>
        <div class="col-4">
            <label class="form-label" for="inputAddress">Phone</label>
            <input class="form-control" id="inputAddress" type="text" name="phone" placeholder="fa fa-book" required />
        </div>
         <div class="col-4">
            <label class="form-label" for="inputAddress">email</label>
            <input class="form-control" id="inputAddress" type="text" name="email" placeholder="page/detail" required />
        </div>
        <div class="col-6">
            <label class="form-label" for="inputAddress">Latitude</label>
            <input class="form-control" id="inputAddress" type="text" name="lat" placeholder="fa fa-book" required />
        </div>
         <div class="col-6">
            <label class="form-label" for="inputAddress">Longtitude</label>
            <input class="form-control" id="inputAddress" type="text" name="long" placeholder="page/detail" required />
        </div>
        <div class="col-12">
            <label class="form-label" for="inputAddress">Alamat</label>
            <textarea name="alamat" class="form-control" id=""></textarea>
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
