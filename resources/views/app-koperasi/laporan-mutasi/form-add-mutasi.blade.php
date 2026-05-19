<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form add Data Mutasi</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-add-data-pr-all">
        <form class="row g-3 pb-3" id="form-add-mutasi-baru" method="POST">
            @csrf
            <div class="col-md-8">
                <label for="inputLastName1" class="form-label">Pilih Nama Bank</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <select name="data_bank" class="form-control form-control-lg" id="">
                        <option value="">Pilih Bank</option>
                        @foreach ($bank as $banks)
                            <option value="{{ $banks->kop_master_bank_code }}">{{ $banks->kop_master_bank_name }} {{ $banks->kop_master_bank_number }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label">Tanggal</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="date" name="tanggal_mutasi" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. 089XXXXXXX">
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label">Debit</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="debit" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. @currency(0)">
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label">Kredit</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="kredit" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. @currency(0)">
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label">Saldo</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="saldo" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. @currency(0)">
                </div>
            </div>
            <div class="col-md-12">
                <label for="inputLastName1" class="form-label">Keterangan Mutasi</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <textarea name="desc" class="form-control" id=""></textarea>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-mutasi">
        <button class="btn btn-success float-end" id="button-simpan-data-mutasi" data-code="">Simpan
            Data</button>
    </span>
</div>
