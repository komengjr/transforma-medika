<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Setting Data Cabang</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-add-data-pr-all">
        <form class="row g-4 pb-3" id="form-set-data-cabang" method="POST">
            @csrf
            <!-- <input type="text" name="code" value="{{ $code }}"> -->
            <div class="col-md-12">
                <label for="inputLastName1" class="form-label">Pilih Cabang Untuk Sinkronisasi Data COA</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <select class="form-select form-select-lg" name="cabang" id="cabang">
                        <option value="">Pilih Akun</option>
                        @foreach ($data as $datas)
                        <option value="{{ $datas->kop_master_cabang_code }}">{{ $datas->kop_master_cabang_code }} - {{ $datas->kop_master_cabang_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-set-data-coa">
        <button class="btn btn-success float-end" id="button-simpan-data-cabang-coa" data-code="">Simpan
            Data</button>
    </span>
</div>
