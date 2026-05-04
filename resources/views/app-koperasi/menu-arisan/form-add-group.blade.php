<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Data Group Arisan</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-add-data-pr-all">
        <form class="row g-3 pb-3" id="form-add-arisan-baru" method="POST">
            @csrf

            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Nama Group</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="nama_group" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. 089XXXXXXX">
                </div>
            </div>
            <div class="col-md-3">
                <label for="inputLastName1" class="form-label">Mulai Arisan</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="date" name="tgl_mulai" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. 089XXXXXXX">
                </div>
            </div>
            <div class="col-md-3">
                <label for="inputLastName1" class="form-label">Selesai Arisan</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="date" name="tgl_selesai" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. 089XXXXXXX">
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label">Nominal Arisan</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="nominal" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. 089XXXXXXX">
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label">Bunga Arisan</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="bunga" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. 089XXXXXXX">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-arisan">
        <button class="btn btn-success float-end" id="button-simpan-data-arisan" data-code="">Simpan
            Data</button>
    </span>
</div>
