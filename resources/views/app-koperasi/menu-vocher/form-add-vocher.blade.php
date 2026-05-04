<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Data Vocher</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-add-data-pr-all">
        <form class="row g-3 pb-3" id="form-add-vocher-baru" method="POST">
            @csrf
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Pilih Nama Peserta</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <select name="anggota" class="form-control form-control-lg" id="">
                        <option value="">Pilih Anggota</option>
                        @foreach ($anggota as $anggotas)
                        <option value="{{ $anggotas->kop_master_peserta_code }}">{{ $anggotas->kop_master_peserta_nip }} - {{ $anggotas->kop_master_peserta_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <label for="inputLastName1" class="form-label">Kategori Vocher</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <select name="kategori" class="form-control form-control-lg" id="">
                        <option value="">Pilih Anggota</option>
                        @foreach ($cat as $cats)
                        <option value="{{ $cats->kop_vocher_cat_code }}">{{ $cats->kop_vocher_cat_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <label for="inputLastName1" class="form-label">Tanggal Voccher</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="date" name="tanggal_vocher" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. 089XXXXXXX">
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label">Nomor ID</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="nomor_id" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. 089XXXXXXX">
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label">Nominal Vocher</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="nominal" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. 089XXXXXXX">
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label">Mengetahui</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <select name="verif" class="form-control" id="">
                        <option value="">Pilih Anggota</option>
                        @foreach ($verif as $verifs)
                        <option value="{{ $verifs->kop_user_verifikasi_code }}">{{ $verifs->kop_user_verifikasi_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-vocher">
        <button class="btn btn-success float-end" id="button-simpan-data-vocher" data-code="">Simpan
            Data</button>
    </span>
</div>
