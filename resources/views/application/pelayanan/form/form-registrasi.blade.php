<div class="modal-body p-0">
    <div class="bg-dark rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Registrasi Pasien</h4>
        <p class="fs--2 mb-0 text-warning">Support by <a class="text-warning fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="card m-3 border border-info bg-300">
        <div class="px-4 py-3 pb-4">
            <form class="row g-3" action="#" id="form-registrasi-pasien">
                @csrf
                <div class="col-md-8">
                    <label class="form-label text-dark" for="basic-form-name">Pencarian Data</label>
                    <div class="input-group"> <span class="input-group-text border border-warning"><i
                                class="fas fa-user-friends"></i></span>
                        <input type="text" name="option_nama" class="form-control form-control-lg border border-warning"
                            id="option_nama" placeholder="Ex. Bambang Junaidi">
                        <input type="text" name="ss" required hidden>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-dark" for="basic-form-gender">Option</label>
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-cogs"></i></span>
                        <select name="option_pencarian" id="option_pencarian" class="form-control single-select form-control-lg" required>
                            <option value="">Pilih</option>
                            <option value="nama">Cari By Name</option>
                            <option value="tanggal_lahir">Cari By Tanggal Lahir</option>
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary" id="button-create-data-pasien" type="button">
                        <span class="fas fa-user-lock"></span><span class="d-none d-md-inline-block mx-2">Create
                            Pasien</span>
                    </button>
                    <button class="btn btn-danger" id="button-scan-data-pasien" type="button">
                        <span class="fab fa-keycdn"></span><span class="d-none d-md-inline-block mx-2">Scan Passport</span>
                    </button>

                    <button class="btn btn-warning float-end" id="button-cari-data-pasien" type="button">
                        <span class="fas fa-search"></span>
                        Cari Pasien</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card m-3 border border-info h-200">
        <div class="tab-content py-2" id="menu-registrasi-pasien">

        </div>

    </div>
</div>
