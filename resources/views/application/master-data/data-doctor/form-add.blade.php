<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Add Doctor</h4>
        <p class="fs--2 mb-0 text-white">Support by <a class="text-warning fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <form class="row g-3 p-4" action="{{ route('master_doctor_data_doctor_save') }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="col-md-3">
            <label class="form-label" for="inputAddress">Title Awal</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="awal"
                placeholder="dr" required />
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">Nama Perusahaan</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="name"
                placeholder="Jhone Doe" required />
        </div>
        <div class="col-md-3">
            <label class="form-label" for="inputAddress">Title Akhir</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="akhir"
                placeholder="Sp.PS" required />
        </div>
        <div class="col-md-6">
            <label class="form-label" for="inputAddress">NIK Dokter</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="nik"
                placeholder="8293812************" required />
        </div>
         <div class="col-md-6">
            <label class="form-label" for="inputAddress">Email</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="email"
                placeholder="021 09283" required />
        </div>
        <div class="col-md-4">
            <label class="form-label" for="inputAddress">Jenis Kelamin</label>
            <select name="jk" class="form-select form-select-lg" id="">
                <option value="">Pilih Type</option>
                <option value="L">Laki - Laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="inputAddress">No Handphone</label>
            <input class="form-control form-control-lg" id="inputAddress" type="text" name="no_hp"
                placeholder="contoh@gmail.com" required />
        </div>
        <div class="col-md-4">
            <label class="form-label" for="inputAddress">Upload Profile</label>
            <input class="form-control form-control-lg" id="inputAddress" type="file" name="profile" />
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
