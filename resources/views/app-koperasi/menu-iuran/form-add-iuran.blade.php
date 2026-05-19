<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Data Iuran Bulanan</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-add-data-pr-all">
        <form class="row g-3 pb-3" id="form-add-tagihan-bulan" method="POST">
            @csrf
            <div class="col-md-7">
                <label for="inputLastName1" class="form-label">Pilih Cabang</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <select name="cabang" class="form-control form-control-lg" id="">
                        <option value="">Pilih Cabang</option>
                        @foreach ($cabang as $cabs)
                            <option value="{{ $cabs->kop_master_cabang_code }}">{{ $cabs->kop_master_cabang_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <label for="inputLastName1" class="form-label">Tanggal Tagihan</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    <input type="date" name="tanggal_tagihan" class="form-control form-control-lg border-start-0"
                        id="tanggal_tagihan" >
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Simpanan Wajib</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="simpanan_wajib" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. @currency(10000000)">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Keuntungan Koperasi</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="keuntungan" class="form-control form-control-lg border-start-0"
                        id="keuntungan" placeholder="Ex. 20 %">
                </div>
            </div>

        </form>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-tagihan-bulan">
        <button class="btn btn-success float-end" id="button-simpan-tagihan-bulan" data-code="">Simpan
            Data</button>
    </span>
</div>
