<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel" style="color: white !important;">Form Penambahan Master Prooduct
        </h4>
        <p class="fs--2 mb-0" style="color: white !important;">Support by <a class="link-600 fw-semi-bold"
                href="#!">Transforma</a></p>
    </div>
    <form method="POST" action="#" enctype="multipart/form-data" id="form-add-data-product">
        @csrf
        <div class="body" id="showdatabarang">
            <div class="card-body ">
                <div class="card">
                    <div class="row g-4">
                        <div class="col-12 ">
                            <input type="text" name="code_product" id="code_product" value="{{ $code }}" hidden>
                            @if ($data)
                                <textarea class="tinymce d-none min-vh-50" name="textAreaName"
                                    id="mytextarea">{{ $data->log_m_product_desc_text }}</textarea>
                            @else
                                <textarea class="tinymce d-none min-vh-50" name="textAreaName" id="mytextarea"></textarea>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" onclick="location.reload();"><i
                    class="fas fa-window-close"></i> Close</button>
            <div id="menu-simpan-data">
                <button type="button" class="btn btn-outline-success" id="button-save-deskripsi-product"><i
                        class="fa fa-save"></i>
                    Simpan Data</button>
            </div>
        </div>
    </form>
</div>
<script>
    tinymce.init({
        selector: '#mytextarea'
    });
</script>
