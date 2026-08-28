@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

<style>
    /* Styling Hero & Cover Header */
    .event-hero-card {
        background: linear-gradient(135deg, #0284c7 0%, #2563eb 50%, #4f46e5 100%);
        border: none;
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.2);
    }

    .cover-image-container {
        position: relative;
        border-radius: 14px;
        overflow: hidden;
        max-height: 280px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .cover-image-container img {
        width: 100%;
        height: 280px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .cover-image-container:hover img {
        transform: scale(1.02);
    }

    .cover-image-overlay {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background: rgba(15, 23, 42, 0.75);
        backdrop-filter: blur(8px);
        color: #fff;
        padding: 8px 16px;
        border-radius: 30px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.2s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .cover-image-overlay:hover {
        background: rgba(15, 23, 42, 0.95);
        transform: translateY(-2px);
    }

    /* Custom File Input Upload Box */
    .custom-upload-box {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.2s ease;
        display: block;
    }

    .custom-upload-box:hover {
        border-color: #2563eb;
        background: #eff6ff;
    }

    /* Live Preview Card Styling */
    .preview-card-sticky {
        position: sticky;
        top: 20px;
    }

    .preview-event-card {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .preview-event-card:hover {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
    }

    .preview-event-card img {
        height: 180px;
        object-fit: cover;
    }

    /* Custom Input Controls Styling */
    input[type="file"] {
        display: none;
    }

    .card-section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
    }
</style>
@endsection

@section('content')
<!-- 1. HERO HEADER BANNER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card event-hero-card text-white overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center">
                    <div class="col-md-8 d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 p-3 rounded-3 me-3 d-none d-sm-block">
                            <img src="{{ asset('img/app.png') }}" alt="App Logo" width="48" height="48" class="img-fluid" />
                        </div>
                        <div>
                            <span class="badge bg-white bg-opacity-20 text-dark rounded-pill px-3 py-1 fs--2 mb-2">
                                <i class="fas fa-plus-circle me-1"></i> Event Creator
                            </span>
                            <h3 class="text-white fw-bold mb-1">
                                {{env('APP_NAME')}} <span class="fw-normal opacity-75">Management System</span>
                            </h3>
                            <p class="mb-0 fs--1 text-white-50">Buat dan publikasikan acara baru lengkap dengan rincian jadwal dan tiket.</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0 border-start border-white border-opacity-10 ps-md-4">
                        <span class="text-white-50 fs--2 text-uppercase fw-semibold d-block">Menu Navigasi</span>
                        <h4 class="text-white fw-bold mb-0">Tambah <span class="fw-normal">Event Baru</span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PROGRESS BAR UPLOAD COVER -->
<div class="progress_cover mb-3" style="height: 10px; display: none; border-radius: 10px; overflow: hidden;">
    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info loadings"
        role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
        style="width: 0%; height: 100%">0%</div>
</div>

<!-- 2. COVER IMAGE HEADER SECTION -->
<div class="card mb-3 border-0 shadow-sm overflow-hidden">
    <div class="cover-image-container">
        <img id="card-img-top" src="{{ asset('asset/img/generic/13.jpg') }}" alt="Cover Preview" />
        <input class="d-none" id="upload-cover-image" type="file" />
        <label class="cover-image-overlay mb-0" for="upload-cover-image">
            <span class="fas fa-camera me-2"></span>Ganti Foto Sampul
        </label>
    </div>
</div>

<!-- 3. FORM INPUT EVENT -->
<form id="formEvent" method="post">
    @csrf
    <div class="row g-3">
        <!-- LEFT COLUMN: EVENT DETAILS & SUB SCHEDULE -->
        <div class="col-lg-8">

            <!-- INFORMASI UTAMA EVENT -->
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                    <div class="avatar avatar-md bg-soft-primary text-primary rounded-circle me-2">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h5 class="mb-0 card-section-title">Detail Informasi Acara</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row gx-3 gy-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold text-800" for="event-name">Judul Event <span class="text-danger">*</span></label>
                            <input class="form-control form-control-lg fs-0" id="event-name" name="title" type="text" placeholder="Masukkan judul acara menarik..." />
                            <input type="text" name="data_code" value="{{ date('YmdHis') }}" id="" hidden>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label fw-semibold text-800" for="start-date">Waktu Mulai <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-100"><i class="far fa-calendar-alt text-600"></i></span>
                                <input class="form-control datetimepicker" name="start_date" id="datetimepicker" type="text" placeholder="dd/mm/yy H:i" data-options='{"enableTime":true,"dateFormat":"d/m/y H:i","disableMobile":true}' />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label fw-semibold text-800" for="end-date">Waktu Selesai <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-100"><i class="far fa-calendar-check text-600"></i></span>
                                <input class="form-control datetimepicker" name="end_date" id="datetimepicker" type="text" placeholder="dd/mm/yy H:i" data-options='{"enableTime":true,"dateFormat":"d/m/y H:i","disableMobile":true}' />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label fw-semibold text-800 mb-0" for="event-venue">Lokasi / Tempat</label>
                                <button class="btn btn-link btn-sm p-0 text-decoration-none fw-semibold" type="button"><i class="fas fa-globe me-1"></i>Online Event</button>
                            </div>
                            <input class="form-control" name="venue" id="event-venue" type="text" placeholder="Nama Gedung / Ruangan" />
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label fw-semibold text-800" for="event-address">Alamat Lengkap</label>
                            <input class="form-control" name="address" id="event-address" type="text" placeholder="Jalan, No. Bangunan, RT/RW" />
                        </div>

                        <div class="col-sm-4">
                            <label class="form-label fw-semibold text-800" for="event-city">Kota</label>
                            <input class="form-control" name="city" id="event-city" type="text" placeholder="Nama Kota" />
                        </div>

                        <div class="col-sm-4">
                            <label class="form-label fw-semibold text-800" for="event-state">Provinsi</label>
                            <input class="form-control" name="state" id="event-state" type="text" placeholder="Provinsi" />
                        </div>

                        <div class="col-sm-4">
                            <label class="form-label fw-semibold text-800" for="event-country">Negara</label>
                            <input class="form-control" name="country" id="event-country" type="text" placeholder="Negara" />
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-800" for="event-description">Deskripsi Lengkap Acara</label>
                            <textarea class="form-control" name="desc" id="event-description" rows="5" placeholder="Tuliskan gambaran umum, kriteria peserta, atau hal penting lainnya..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SCHEDULE SUB EVENT -->
            <!-- <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-md bg-soft-info text-info rounded-circle me-2">
                            <i class="fas fa-list-alt"></i>
                        </div>
                        <h5 class="mb-0 card-section-title">Sub Event & Jadwal Sesi</h5>
                    </div>
                    <span class="badge bg-soft-info text-info rounded-pill fs--2">Sesi Opsional</span>
                </div>
                <div class="card-body p-4">
                    <div class="border rounded-3 position-relative bg-light p-3 p-sm-4 mb-3">
                        <div class="position-absolute end-0 top-0 mt-3 me-3 z-index-1">
                            <button class="btn btn-soft-danger btn-sm rounded-circle p-1" type="button" style="width: 28px; height: 28px;" title="Hapus Sub Event">
                                <span class="fas fa-times fs--1"></span>
                            </button>
                        </div>

                        <div class="row gx-2 gy-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-800" for="schedule-title">Sub Judul Sesi</label>
                                <input class="form-control form-control-sm" id="schedule-title" type="text" placeholder="Contoh: Keynote Speech / Workshop UI" />
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold text-800" for="schedule-start-date">Tanggal Sesi</label>
                                <input class="form-control form-control-sm datetimepicker" id="schedule-start-date" type="text" placeholder="dd/mm/yy" data-options='{"dateFormat":"d/m/y","enableTime":false}' />
                            </div>

                            <div class="col-sm-6">
                                <label class="form-label fw-semibold text-800" for="schedule-start-time">Jam Sesi</label>
                                <input class="form-control form-control-sm datetimepicker" id="schedule-start-time" type="text" placeholder="HH:mm" data-options='{"enableTime":true,"noCalendar":true,"dateFormat":"H:i"}' />
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label fw-semibold text-800">Ruangan / Hall</label>
                                <input class="form-control form-control-sm" type="text" placeholder="Contoh: Ballroom 1" />
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label fw-semibold text-800" for="field-type">Tipe Tiket</label>
                                <select class="form-select form-select-sm" id="field-type">
                                    <option value="" selected disabled>Pilih Tipe</option>
                                    <option value="free">Gratis (Free)</option>
                                    <option value="prabayar">Berbayar (Prabayar)</option>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label fw-semibold text-800" for="field-name">Harga Tiket (Rp)</label>
                                <input class="form-control form-control-sm" id="field-name" type="text" placeholder="100.000" />
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-800" for="field-options">Catatan Tambahan / Opsi</label>
                                <textarea class="form-control form-control-sm" id="field-options" rows="2" placeholder="Sertakan opsi tambahan jika ada..."></textarea>
                                <div class="form-text fs--2 text-warning"><i class="fas fa-exclamation-triangle me-1"></i>Pisahkan pilihan opsi dengan tanda koma (,)</div>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-outline-primary btn-sm rounded-pill fw-semibold" type="button">
                        <span class="fas fa-plus fs--2 me-1"></span>Tambah Sesi Sub Event
                    </button>
                </div>
            </div> -->

        </div>

        <!-- RIGHT COLUMN: SIDEBAR UPLOAD & LIVE PREVIEW -->
        <div class="col-lg-4">
            <div class="preview-card-sticky">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 card-section-title"><i class="fas fa-image text-primary me-2"></i>Template & Preview</h5>
                    </div>
                    <div class="card-body p-3">

                        <!-- UPLOAD TEMPLATE DROPBOX -->
                        <div class="mb-3">
                            <label class="custom-upload-box mb-0" id="upload-container">
                                <input type="file" id="browseFile" class="form-control" />
                                <div class="avatar avatar-lg bg-soft-primary text-primary rounded-circle mx-auto mb-2">
                                    <i class="fas fa-cloud-upload-alt fs-2"></i>
                                </div>
                                <span class="fw-bold text-dark d-block">Upload Template Event</span>
                                <span class="fs--2 text-muted">Format: JPG, JPEG, PNG</span>
                            </label>

                            <div class="progress mt-3" style="height: 12px; display: none; border-radius: 6px;" id="loading-prgress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary loading"
                                    role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                    style="width: 0%; height: 100%">0%</div>
                            </div>

                            <input id="link" type="text" name="link" class="form-control" hidden>
                            <input id="link_cover" type="text" name="link_cover" class="form-control" hidden>
                        </div>

                        <!-- CARD PREVIEW CARD -->
                        <div class="mb-2">
                            <span class="text-uppercase text-600 fw-bold fs--2 d-block mb-2"><i class="fas fa-eye me-1"></i>Tampilan Visual Kartu</span>
                            <div class="preview-event-card bg-white shadow-sm">
                                <img class="w-100" id="videoPreview" src="https://i.pinimg.com/736x/a5/c2/8a/a5c28a83e4929a3f4775287888cd32f9.jpg" alt="Preview Template" />
                                <div class="p-3">
                                    <span class="badge bg-soft-primary text-primary mb-1 fs--2">Live Preview</span>
                                    <h5 class="card-title text-truncate fw-bold mb-1">Nama Event Utama</h5>
                                    <p class="card-text text-muted fs--1 mb-2">Sesi Sub Event</p>
                                    <p class="card-text text-600 fs--2 line-clamp-2">Deskripsi ringkas event akan muncul secara otomatis pada pratinjau kartu ini.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- 4. BOTTOM SAVE ACTION BAR -->
<div class="card border-0 shadow-sm mt-3 bg-white">
    <div class="card-body p-3 p-md-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-md mb-2 mb-md-0">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-md bg-soft-success text-success rounded-circle me-3 d-none d-sm-block">
                        <i class="fas fa-check-circle fs-1"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold text-900">Sudah Selesai Mengisi Data?</h5>
                        <p class="text-600 fs--1 mb-0">Pastikan seluruh tanggal, informasi lokasi, dan tiket sudah dikonfirmasi.</p>
                    </div>
                </div>
            </div>
            <div class="col-auto" id="proses-save-event">
                <button class="btn btn-primary px-4 py-2 rounded-pill fw-bold shadow-sm" id="button-save-event">
                    <i class="fas fa-paper-plane me-2"></i>Simpan & Terbitkan Event
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    new DataTable('#example', {
        responsive: true
    });
</script>

<script>
    $(document).on("click", "#button-save-event", function(e) {
        e.preventDefault();
        var data = $("#formEvent").serialize();
        $('#proses-save-event').html(
            '<div class="spinner-border text-primary" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_event_create_save') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'html',
        }).done(function(data) {
            if (data == 1) {
                Swal.fire({
                    title: "Simpan Data Berhasil!",
                    icon: "success",
                    draggable: true
                });
                location.reload();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#proses-save-event').html(
                    '<button class="btn btn-primary px-4 py-2 rounded-pill fw-bold shadow-sm" id="button-save-event"><i class="fas fa-paper-plane me-2"></i>Simpan & Terbitkan Event</button>'
                );
            }
            console.log(data);

        }).fail(function() {
            $('#proses-save-event').html('<span class="text-danger fw-bold">Gagal Menyimpan Data</span>');
        });
    });
</script>

<script type="text/javascript">
    var browseFile = $('#browseFile');
    var resumable = new Resumable({
        target: "{{ route('menu_event_data_upload_template') }}",
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

    resumable.on('fileAdded', function(file) { // trigger when file picked
        showProgres();
        resumable.upload() // to actually start uploading.
    });

    resumable.on('fileProgress', function(file) { // trigger when file progress update
        updateProgres(Math.floor(file.progress() * 100));
    });

    resumable.on('fileSuccess', function(file, response) { // trigger when file upload complete
        response = JSON.parse(response)
        $('#videoPreview').attr('src', response.path);
        $('#link').attr('value', response.filename);
        $('.card-footer').show();

        $('#browseFile').hide();
    });

    resumable.on('fileError', function(file, response) { // trigger when there is any error
        alert('file uploading error.')
    });

    var progress = $('#loading-prgress');

    function showProgres() {
        progress.find('.loading').css('width', '0%');
        progress.find('.loading').html('0%');
        progress.find('.loading').removeClass('bg-info');
        progress.show();
    }

    function updateProgres(value) {
        progress.find('.loading').css('width', ` ${value}%`)
        progress.find('.loading').html(`${value}%`)
    }

    function hideProgres() {
        progress.hide();
    }
</script>

<script type="text/javascript">
    var CoverFile = $('#upload-cover-image');
    var resumableCover = new Resumable({
        target: "{{ route('menu_event_data_upload_cover') }}",
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

    resumableCover.assignBrowse(CoverFile[0]);

    resumableCover.on('fileAdded', function(file) { // trigger when file picked
        showProgress();
        resumableCover.upload() // to actually start uploading.
    });

    resumableCover.on('fileProgress', function(file) { // trigger when file progress update
        updateProgress(Math.floor(file.progress() * 100));
    });

    resumableCover.on('fileSuccess', function(file, response) { // trigger when file upload complete
        response = JSON.parse(response)
        $('#card-img-top').attr('src', response.path);
        $('#link_cover').attr('value', response.filename);
        $('#upload-cover-image').hide();
    });

    resumableCover.on('fileError', function(file, response) { // trigger when there is any error
        alert('file uploading error.')
    });

    var progress_cover = $('.progress_cover');

    function showProgress() {
        progress_cover.find('.loadings').css('width', '0%');
        progress_cover.find('.loadings').html('0%');
        progress_cover.find('.loadings').removeClass('bg-info');
        progress_cover.show();
    }

    function updateProgress(value) {
        progress_cover.find('.loadings').css('width', ` ${value}%`)
        progress_cover.find('.loadings').html(`${value}%`)
    }

    function hideProgress() {
        progress_cover.hide();
    }
</script>
@endsection
