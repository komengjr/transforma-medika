<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Data Cabang</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-add-data-pr-all">
        <form class="row g-3 pb-3" id="form-add-cabang-baru" method="POST">
            @csrf
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Kode Cabang</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="code_cabang" class="form-control form-control-lg border-start-0"
                        id="user_name" placeholder="Ex. Kepala">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Nama Cabang</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="nama_cabang" class="form-control form-control-lg border-start-0"
                        id="email" placeholder="Ex@gmail.com">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Kota</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="kota_cabang" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. 089XXXXXXX">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Alamat</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="alamat_cabang" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. 089XXXXXXX">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-cabang">
        <button class="btn btn-success float-end" id="button-simpan-data-cabang" data-code="">Simpan
            Data</button>
    </span>
</div>
