<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Setting Data COA</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-add-data-pr-all">
        <form class="row g-4 pb-3" id="form-set-data-coa" method="POST">
            @csrf
            <input type="text" name="code" value="{{ $code }}">
            <div class="col-md-12">
                <label for="inputLastName1" class="form-label">Transaksi Debit</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <select class="form-select form-select-lg" name="trx_1" id="trx_1">
                        <option value="0">Pilih Akun</option>
                        @foreach ($akun as $akuns)
                            <option value="{{ $akuns->coa_code }}">{{ $akuns->coa_code }} - {{ $akuns->coa_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <label for="inputLastName1" class="form-label">Transaksi Bunga</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <select class="form-select form-select-lg" name="trx_2" id="trx_2">
                        <option value="0">Pilih Akun</option>
                        @foreach ($akun as $akuns)
                            <option value="{{ $akuns->coa_code }}">{{ $akuns->coa_code }} - {{ $akuns->coa_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <label for="inputLastName1" class="form-label">Transaksi Admin</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <select class="form-select form-select-lg" name="trx_3" id="trx_3">
                        <option value="0">Pilih Akun</option>
                        @foreach ($akun as $akuns)
                            <option value="{{ $akuns->coa_code }}">{{ $akuns->coa_code }} - {{ $akuns->coa_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <label for="inputLastName1" class="form-label">Transaksi Kredit</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <select class="form-select form-select-lg" name="trx_4" id="trx_4">
                        <option value="0">Pilih Akun</option>
                        @foreach ($akun as $akuns)
                            <option value="{{ $akuns->coa_code }}">{{ $akuns->coa_code }} - {{ $akuns->coa_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-set-data-coa">
        <button class="btn btn-success float-end" id="button-simpan-data-set-coa" data-code="">Simpan
            Data</button>
    </span>
</div>
