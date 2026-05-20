<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Data Simpanan Sukarela</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-add-data-pr-all">
        <form class="row g-3 pb-3" id="form-add-tagihan-bulan" method="POST">
            @csrf
            <div class="col-md-7">
                <label for="inputLastName1" class="form-label">Pilih Anggota</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <select name="anggota" class="form-control form-control-lg" id="">
                        <option value="">Pilih Anggota</option>
                        @foreach ($peserta as $pes)
                        <option value="{{ $pes->kop_master_peserta_code }}">{{ $pes->kop_master_peserta_nip }} - {{ $pes->kop_master_peserta_name }}</option>

                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <label for="inputLastName1" class="form-label">Tanggal Simpanan</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    <input type="date" name="tanggal_simpan" class="form-control form-control-lg border-start-0"
                        id="tanggal_tagihan">
                </div>
            </div>
            <div class="col-md-10">
                <label for="inputLastName1" class="form-label">Nominal Simpanan</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="nominal" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. @currency(10000000)">
                </div>
            </div>
            <div class="col-md-2">
                <label for="inputLastName1" class="form-label">Bunga</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="bunga" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. 2 %">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-tagihan-bulan">
        <button class="btn btn-success float-end" id="button-simpan-simpanan-sukarela" data-code="">Simpan
            Data</button>
    </span>
</div>
