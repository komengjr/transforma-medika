<div class="modal-body p-0">
    <div class="bg-warning rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Add Batch Obat</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold"
                href="#!">{{ Env('APP_LABEL')}}</a>
        </p>
    </div>
    <style>
        .choices {
            width: 100%;
            border-radius: 5px;
        }
    </style>
    <div class="px-4 py-3 pb-3">
        <form class="row g-3" id="form-save-batch">
            @csrf
            <input type="text" name="code" value="{{ $code }}" id="" hidden>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label text-youtube">No GRN</label>
                <select name="grn" class="form-select form-select-lg choices-single-company" id="grn">
                    <option value="">Pilih Grn</option>
                    @foreach ($grn as $grns)
                        <option value="{{ $grns->pem_grn_token_code }}">{{ $grns->pem_grn_token_number }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="inputLastName1" class="form-label text-youtube">Stok Obat</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                    <input type="text" name="stok" class="form-control form-control-lg border-start-0 bg-white">
                </div>
            </div>
            <div class="col-md-3">
                <label for="inputLastName1" class="form-label text-youtube">Lokasi Penyimpanan</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                    <input type="text" name="rak" class="form-control form-control-lg border-start-0 bg-white">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label text-youtube">Tanggal Masuk</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                    <input type="date" name="masuk" class="form-control form-control-lg border-start-0 bg-white">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label text-youtube">Tanggal Kadaluarsa</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                    <input type="date" name="exp" class="form-control form-control-lg border-start-0 bg-white">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-batch">
        <button class="btn btn-success float-end" id="button-simpan-batch-obat">Simpan
            Data</button>
    </span>
</div>
<script>
    new window.Choices(document.querySelector(".choices-single-company"));
</script>
