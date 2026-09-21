<style>
    input[type="file"] {
        display: none;
    }

    .modal-header-gradient {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .upload-box {
        border: 2px dashed #0d6efd;
        border-radius: 12px;
        background-color: #f8f9fa;
        padding: 1.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .upload-box:hover {
        background-color: #e9ecef;
        border-color: #0a58ca;
    }

    .preview-img-container {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .preview-img-container img {
        object-fit: cover;
        max-height: 240px;
        width: 100%;
    }

    .section-title {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #0d6efd;
        margin-bottom: 1rem;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 0.4rem;
    }
</style>

<div class="modal-body p-0">
    <!-- Header Modal -->
    <div class="modal-header-gradient text-white py-3 px-4 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="mb-0 text-white fw-bold"><i class="fas fa-box-open me-2"></i>Tambah Barang Inventaris Baru</h4>
            <p class="fs--2 mb-0 opacity-75">Sistem Manajemen Aset Transforma</p>
        </div>
    </div>

    <form method="POST" action="#" enctype="multipart/form-data" id="form-add-data-barang">
        @csrf
        <div class="p-4" id="showdatabarang">
            <div class="row g-4">

                <!-- Kolom Upload Gambar -->
                <div class="col-lg-4 text-center border-end-lg">
                    <div class="section-title text-start"><i class="fas fa-image me-1"></i> Foto Aset / Barang</div>

                    <div class="preview-img-container mb-3 bg-light">
                        <a href="#" data-fancybox="images">
                            <img src="{{ asset('img/lab.png') }}" alt="Preview Barang" class="img-fluid rounded" id="videoPreview">
                        </a>
                    </div>

                    <label for="browseFile" class="upload-box w-100 d-block text-center mb-3">
                        <input type="file" id="browseFile" class="form-control" />
                        <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                        <div class="fw-bold text-dark">Klik untuk Unggah Gambar</div>
                        <small class="text-muted">Format: JPG, JPEG, PNG</small>
                    </label>

                    <div class="progress shadow-sm" style="height: 16px; display: none;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success loading"
                            role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">0%</div>
                    </div>
                </div>

                <!-- Form Data Utama -->
                <div class="col-lg-4">
                    <div class="section-title"><i class="fas fa-info-circle me-1"></i> Informasi Utama</div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" name="nama_barang" class="form-control" id="nama_barang" placeholder="Contoh: Laptop Dell Latitude" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Klasifikasi Inventaris <span class="text-danger">*</span></label>
                        <select class="form-select choices-single-jenis" name="klasifikasi" id="klasifikasi" required>
                            <option value="">Pilih Jenis Inventaris</option>
                            @foreach ($class as $clas)
                            <option value="{{ $clas->id_inv_data_class_code }}">{{ $clas->id_inv_data_class_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori Aset <span class="text-danger">*</span></label>
                        <select class="form-select kategori_barang" name="jenis" required>
                            <option value="1">Aset Perusahaan</option>
                            <option value="0">Non Aset / Sub-Inventaris</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tgl Pembelian <span class="text-danger">*</span></label>
                            <input type="date" name="tgl_beli" class="form-control" id="tgl_beli" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Harga Perolehan <span class="text-danger">*</span></label>
                            <input type="text" name="harga_perolehan" class="form-control" id="dengan-rupiah" placeholder="Rp 0" required>
                            <input id="link" type="text" name="link" hidden>
                        </div>
                    </div>
                </div>

                <!-- Form Spesifikasi & Lokasi -->
                <div class="col-lg-4">
                    <div class="section-title"><i class="fas fa-sliders-h me-1"></i> Detail & Penempatan</div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Supplier / Vendor <span class="text-danger">*</span></label>
                        <input type="text" name="suplier" class="form-control" id="suplier" placeholder="PT. Distributor Utama" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Lokasi / Ruangan <span class="text-danger">*</span></label>
                        <select class="form-select choices-single-lokasi" name="lokasi" id="lokasi" required>
                            <option value="">Pilih Ruangan Penempatan</option>
                            <option value="1">Rumah 01</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted">Merek</label>
                            <input type="text" name="merk" class="form-control" id="merk" placeholder="Asus, HP, dll">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted">Tipe Barang</label>
                            <input type="text" name="type" class="form-control" id="type" placeholder="Model / Type">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">Nomor Serial (S/N)</label>
                        <input type="text" name="seri" class="form-control" id="seri" placeholder="SN-123456789">
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer Modal -->
        <div class="modal-footer bg-light px-4 py-3">
            <button type="button" class="btn btn-secondary px-4 me-2" data-bs-dismiss="modal">
                <i class="fas fa-times me-1"></i> Batal
            </button>
            <div id="menu-simpan-data">
                <button type="button" class="btn btn-primary px-4 fw-bold shadow-sm" id="button-simpan-data">
                    <i class="fas fa-save me-1"></i> Simpan Data Inventaris
                </button>
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
        target: "{{ route('master_barang_add_upload_gambar') }}",
        query: {
            _token: '{{ csrf_token() }}'
        },
        fileType: ['jpg', 'jpeg', 'png'],
        headers: {
            'Accept': 'application/json'
        },
        testChunks: false,
        throttleProgressCallbacks: 1,
    });

    resumable.assignBrowse(browseFile[0]);

    resumable.on('fileAdded', function(file) {
        showProgress();
        resumable.upload();
    });

    resumable.on('fileProgress', function(file) {
        updateProgress(Math.floor(file.progress() * 100));
    });

    resumable.on('fileSuccess', function(file, response) {
        response = JSON.parse(response);
        $('#videoPreview').attr('src', response.path);
        $('#link').val(response.filename);
        hideProgress();
    });

    resumable.on('fileError', function(file, response) {
        alert('Gagal mengunggah gambar.');
        hideProgress();
    });

    var progress = $('.progress');

    function showProgress() {
        progress.find('.loading').css('width', '0%').html('0%');
        progress.show();
    }

    function updateProgress(value) {
        progress.find('.loading').css('width', `${value}%`).html(`${value}%`);
    }

    function hideProgress() {
        progress.hide();
    }
</script>
