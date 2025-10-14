<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel" style="color: white !important;">Form Penambahan Master Prooduct
        </h4>
        <p class="fs--2 mb-0" style="color: white !important;">Support by <a class="link-600 fw-semi-bold"
                href="#!">Transforma</a></p>
    </div>
    <form action="{{ route('menu_brodcast_management_export_excel_start') }}" method="post" id="form-input-upload"
        enctype="multipart/form-data">
        @csrf
        <div class="p-3">
            <div class="row">
                <div class="col-md-12">
                    <label for="">File Import</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                    <input type="text" name="code" value="{{ $code }}" id="">
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
