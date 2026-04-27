<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Data Divisi / Departemen</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-add-data-pr-all">
        <form class="row g-3 pb-3" id="form-divisi-baru" method="POST">
            @csrf
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Nama DIvisi</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="divisi_name" class="form-control form-control-lg border-start-0"
                        id="divisi_name" placeholder="Ex. Kepala">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label text-youtube">Type DIvisi / Departemen</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    <select name="divisi_type" id="divisi_type" class="form-control form-control-lg single-select">
                        <option value="">Pilih Type</option>
                        <option value="A">Type A</option>
                        <option value="B">Type B</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-divisi">
        <button class="btn btn-success float-end" id="button-simpan-data-divisi" data-code="">Simpan
            Data</button>
    </span>
</div>
