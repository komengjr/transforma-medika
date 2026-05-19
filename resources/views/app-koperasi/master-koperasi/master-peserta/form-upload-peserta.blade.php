<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Upload Data Peserta Koperasi</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>

    <form action="{{ route('master_koperasi_peserta_import_save') }}" method="post" id="form-input-upload"
        enctype="multipart/form-data">
        @csrf
        <div class="p-3">
            <div class="row">
                <div class="col-md-6">
                    <label for="">Pilih Cabang</label>
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <select name="code" id="code" class="form-control form-control-lg single-select">
                            <option value="">Pilih Cabang</option>
                            @foreach ($cabang as $cab)
                            <option value="{{ $cab->kop_master_cabang_code }}">{{ $cab->kop_master_cabang_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="">Pilih Simpanan Pokok</label>
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <select name="pokok" id="pokok" class="form-control form-control-lg single-select">
                            <option value="">Pilih Pokok</option>
                            @foreach ($pokok as $pok)
                            <option value="{{ $pok->kop_simpanan_pokok_code }}">{{ $pok->kop_simpanan_pokok_name }} - {{ $pok->kop_simpanan_pokok_nominal }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="">Pilih Simpanan Wajib</label>
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <select name="wajib" id="wajib" class="form-control form-control-lg single-select">
                            <option value="">Pilih Pokok</option>
                            @foreach ($wajib as $jib)
                            <option value="{{ $jib->kop_simpanan_wajib_code }}">{{ $jib->kop_simpanan_wajib_name }} - {{ $jib->kop_simpanan_wajib_nominal }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="">File Import</label>

                    <input type="file" name="file" id="file" class="form-control form-control-lg" required>

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-outline-primary" id="button-upload-excel-data"><i
                    class="fas fa-download"></i>
                Start Import</button>
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
                    class="fas fa-window-close"></i>
                Close</button>
        </div>
    </form>

</div>
