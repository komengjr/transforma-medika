<div class="modal-body p-0">
    <div class="bg-warning rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add User Verifikasi</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-add-data-pr-all">
        <form class="row g-3 pb-3" id="form-add-verifikasi-baru" method="POST">
            @csrf
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Nama User</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="user_name" class="form-control form-control-lg border-start-0"
                        id="user_name" placeholder="Ex. Kepala">
                    <input type="text" name="code" value="{{ $code }}" hidden>
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Email</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="email" class="form-control form-control-lg border-start-0"
                        id="email" placeholder="Ex@gmail.com">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Whatsapp</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="whatsapp" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. 089XXXXXXX">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label text-youtube">Jabatan</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    <select name="jabatan" id="jabatan" class="form-control form-control-lg single-select">
                        <option value="">Pilih Level</option>
                        <option value="0">Kepala Cabang</option>
                        <option value="1">Ketua Koperasi</option>
                    </select>
                </div>
            </div>

        </form>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-verifikasi">
        <button class="btn btn-success float-end" id="button-simpan-data-verifikasi" data-code="">Simpan
            Data</button>
    </span>
</div>
