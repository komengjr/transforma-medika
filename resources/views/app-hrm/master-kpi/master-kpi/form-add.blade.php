<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Master KPI</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-0" id="menu-add-data-pr-all">
        <form class="row g-3 pb-3" id="form-master-kpi" method="POST">
            @csrf
            <div class="col-md-12">
                <label for="inputLastName2" class="form-label text-youtube">Nama KPI</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-file-archive"></i></span>
                    <input type="text" name="nama" class="form-control form-control-lg border-start-0" id="no_hp"
                        placeholder="Penilaian Example">
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName2" class="form-label">Bobot KPI</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                    <input type="email" name="bobot" class="form-control form-control-lg border-start-0" id="inputLastName2" placeholder="Ex. 20%">
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName2" class="form-label">Target KPI</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                    <input type="email" name="target" class="form-control form-control-lg border-start-0" id="inputLastName2" placeholder="Ex. 100">
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label text-youtube">Posisi Departemen</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-fingerprint"></i></span>
                    <select name="departemen" id="" class="form-control form-control-lg single-select">
                        <option value="">Pilih Departemen</option>
                        @foreach ($departemen as $dep)
                        <option value="{{ $dep->hrm_departemen_code }}">{{ $dep->hrm_departemen_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-12">
                <label for="inputAddress3" class="form-label text-youtube">Deskripsi Alamat</label>
                <textarea class="form-control" name="desc" id="inputAddress3" placeholder="Enter Address"
                    rows="3"></textarea>
            </div>

        </form>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-master-kpi">
        <button class="btn btn-success float-end" id="button-simpan-data-master-kpi" data-code="">Simpan
            Data</button>
    </span>
</div>
