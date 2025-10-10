<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Add Perusahaan</h4>
        <p class="fs--2 mb-0 text-white">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <form class="row g-3 p-4" action="{{ route('master_company_add_company_save') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">Nama Perusahaan</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="name" placeholder="PT Sinar Matahari"
                required />
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">Lokasi Perusahaan</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="lokasi" placeholder="Pontianak"
                required />
        </div>
        <div class="col-md-4">
            <label class="form-label" for="inputAddress">Type Perusahaan</label>
            <select name="type" class="form-select form-select-lg" id="">
                <option value="">Pilih Type</option>
                <option value="Local">Local</option>
                <option value="Nasional">Nasional</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="inputAddress">Email Perusahaan</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="email" placeholder="contoh@gmail.com"
                required />
        </div>
        <div class="col-md-4">
            <label class="form-label" for="inputAddress">Contact Perusahaan</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="phone" placeholder="021 09283"
                required />
        </div>
        <div class="col-md-12">
            <div class="form-check">
                <input class="form-check-input" id="gridCheck" type="checkbox" required />
                <label class="form-check-label" for="gridCheck">Check me</label>
            </div>
        </div>
        <div class="col-md-12">
            <button class="btn btn-primary" type="submit"><span class="fas fa-save"></span> Save</button>
        </div>
    </form>
</div>
