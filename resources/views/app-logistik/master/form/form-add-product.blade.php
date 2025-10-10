<style>
    input[type="file"] {
        display: none;
    }
</style>
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
                <div class="card border border-primary">
                    <div class="row g-4 p-4">
                        <div class="col-md-4 text-center">
                            <label class="custom-file-upload form-control" id="upload-container">
                                <input type="file" id="browseFile" class="form-control" />
                                <span class="fas fa-cloud-upload-alt"></span> Upload Gambar
                            </label>
                            <a href="#" data-fancybox="images" data-caption="">
                                <img src="{{ asset('img/product.png') }}" alt="lightbox"
                                    class="lightbox-thumb img-thumbnail" id="videoPreview" width="350" height="350">
                            </a>
                            <div class="progress  mt-3" style="height: 20px">
                                <div class="progress-bar progress-bar-striped progress-bar-animated loading"
                                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 0%; height: 100%">0%</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="inputPassword4" class="form-label text-danger">Nama Product</label>
                            <input type="text" name="nama_product" class="form-control form-control-lg" id="nama_barang"
                                required>

                            <label for="inputEmail4" class="form-label text-danger">Klasifikasi Product</label>
                            <select class="form-control choices-single-jenis" name="klasifikasi" id="klasifikasi"
                                required>
                                <option value="">Pilih Jenis Product</option>
                                @foreach ($class as $clas)
                                    <option value="{{ $clas->log_m_class_code }}"> {{ $clas->log_m_class_name }}</option>
                                @endforeach
                            </select>

                            <label for="inputPassword4" class="form-label text-danger">Type Product</label>
                            <select class="form-control form-control-lg kategori_barang" name="jenis" required>
                                <option value="BHP">Bahan Habis Pakai</option>
                                <option value="BTHP">Bahan Tidak Habis Pakai</option>
                            </select>

                            <label for="inputEmail4" class="form-label text-danger">Tanggal Pembelian</label>
                            <input type="date" name="tgl_beli" class="form-control form-control-lg" id="tgl_beli"
                                required>


                            <input id="link" type="text" name="link" class="form-control" hidden>
                        </div>
                        <div class="col-md-4">
                            <label for="inputPassword4" class="form-label text-danger">Barcode</label>
                            <input type="text" name="suplier" class="form-control form-control-lg" id="suplier"
                                required>

                            <label for="inputEmail4" class="form-label text-danger">Lokasi</label>
                            <select class="form-control choices-single-lokasi" name="lokasi" id="lokasi">
                                <option value="">Pilih Ruangan</option>
                                <option value="1">Rumah 01</option>
                            </select>

                            <label for="inputPassword4" class="form-label">Merek</label>
                            <input type="text" name="merk" class="form-control form-control-lg" id="merk">

                            <label for="inputPassword4" class="form-label">Type Barang</label>
                            <input type="text" name="type" class="form-control form-control-lg" id="type">

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" id="button-clear-data"><i
                    class="fas fa-window-close"></i> Close</button>
            <div id="menu-simpan-data">
                <button type="button" class="btn btn-outline-success" id="button-simpan-data"><i class="fa fa-save"></i>
                    Simpan Data</button>
            </div>
        </div>
    </form>
</div>
<script src="{{ asset('asset/js/rupiah.js') }}"></script>
<script>
    new window.Choices(document.querySelector(".choices-single-jenis"));
    new window.Choices(document.querySelector(".choices-single-lokasi"));
</script>
<script type="text/javascript">
    var browseFile = $('#browseFile');
    var resumable = new Resumable({
        target: "{{ route('master_logistik_add_product_upload_file') }}",
        query: {
            _token: '{{ csrf_token() }}'
        }, // CSRF token
        fileType: ['jpg', 'jpeg', 'png'],
        headers: {
            'Accept': 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    resumable.assignBrowse(browseFile[0]);

    resumable.on('fileAdded', function (file) { // trigger when file picked
        showProgress();
        resumable.upload() // to actually start uploading.
    });

    resumable.on('fileProgress', function (file) { // trigger when file progress update
        updateProgress(Math.floor(file.progress() * 100));
    });

    resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
        response = JSON.parse(response)
        $('#videoPreview').attr('src', response.path);
        $('#link').attr('value', response.filename);
        $('.card-footer').show();
        $('#browseFile').hide();
    });

    resumable.on('fileError', function (file, response) { // trigger when there is any error
        alert('file uploading error.')
    });

    var progress = $('.progress');

    function showProgress() {
        progress.find('.loading').css('width', '0%');
        progress.find('.loading').html('0%');
        progress.find('.loading').removeClass('bg-info');
        progress.show();
    }

    function updateProgress(value) {
        progress.find('.loading').css('width', ` ${value}%`)
        progress.find('.loading').html(`${value}%`)
    }

    function hideProgress() {
        progress.hide();
    }
</script>
