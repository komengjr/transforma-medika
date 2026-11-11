@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    /* =========================================
       RETRO / NEUBRUTALISM THEME STYLES
       ========================================= */
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-pink: #ffa6c9;
        --retro-cyan: #8bf0fa;
        --retro-orange: #ff914d;
        --retro-green: #c1ff72;
        --retro-purple: #c8b6ff;
        --retro-bg: #f4f0ea;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 5px 5px 0px var(--retro-dark);
        --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
    }

    body {
        /* background-color: var(--retro-bg); */
    }

    /* Retro Cards & Banners */
    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        /* background-color: #ffffff; */
        overflow: hidden;
    }

    .retro-header-banner {
        background: linear-gradient(135deg, var(--retro-yellow) 0%, var(--retro-orange) 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-dark);
    }

    /* Retro Buttons */
    .retro-btn {
        font-weight: 800 !important;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        transition: all 0.1s ease-in-out;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
    }

    .retro-btn:active {
        transform: translate(3px, 3px);
        box-shadow: 0px 0px 0px var(--retro-dark);
    }

    .retro-btn-primary {
        background-color: var(--retro-cyan);
        color: var(--retro-dark);
    }

    .retro-btn-primary:hover {
        background-color: #6ce0ed;
        color: var(--retro-dark);
    }

    .retro-btn-warning {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
    }

    .retro-btn-warning:hover {
        background-color: #e6c84c;
        color: var(--retro-dark);
    }

    .retro-btn-success {
        background-color: var(--retro-green);
        color: var(--retro-dark);
    }

    .retro-btn-success:hover {
        background-color: #b0f55b;
        color: var(--retro-dark);
    }

    .retro-btn-danger {
        background-color: var(--retro-pink);
        color: var(--retro-dark);
    }

    /* Scanner Card Styling */
    .scanner-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        background: #ffffff;
    }

    .scan-input-group .input-group-text {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
        border: 2px solid var(--retro-dark);
        border-right: none;
        font-weight: 800;
        border-top-left-radius: 6px;
        border-bottom-left-radius: 6px;
    }

    .scan-input-group input {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 0 6px 6px 0 !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
        background-color: #ffffff !important;
    }

    .scan-input-group input:focus {
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
        outline: none;
    }

    /* Status Indicator Pulse */
    .pulse-indicator {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--retro-green);
        border: 2px solid var(--retro-dark);
        box-shadow: 2px 2px 0px var(--retro-dark);
        animation: pulse 1.6s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(0.95);
        }

        70% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(0.95);
        }
    }

    /* Modern Empty State */
    .empty-specimen-state {
        border: var(--retro-border);
        border-radius: 12px;
        background-color: #ffffff;
        padding: 3rem 1.5rem;
        text-align: center;
        box-shadow: var(--retro-shadow);
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
        text-transform: uppercase;
        display: inline-block;
        font-size: 0.7rem;
    }
</style>
@endsection

@section('content')
<!-- BREADCRUMB & HERO HEADER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark position-relative z-1">
                <div class="row align-items-center gy-3">

                    <!-- Brand & App Label -->
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <img src="{{ asset('img/verif.png') }}" alt="Logo" class="img-fluid" width="42" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark);">
                                    <i class="fas fa-shield-alt me-1"></i> v2.4 Medical Suite
                                </span>
                            </div>
                            <h3 class="fw-bolder mb-0 text-dark" style="font-size: 1.4rem; text-shadow: 1px 1px 0px white;">
                                Welcome to {{ Env('APP_LABEL')}} <span class="fw-normal">Management System</span>
                            </h3>
                        </div>
                    </div>

                    <!-- Module Badge / Quick Nav -->
                    <div class="col-lg-5 text-lg-end">
                        <div class="d-inline-flex align-items-center bg-white px-3 py-2 rounded-pill" style="border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <h6 class="fw-bolder mb-0 text-dark" style="font-size: 0.95rem;">
                                <i class="fas fa-copy me-1 text-warning"></i> Laboratorium Specimen Collection
                            </h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN TWO-COLUMN LAYOUT -->
<div class="row g-4">
    <!-- LEFT COLUMN: SCANNER & FILTER PANEL -->
    <div class="col-lg-4">
        <div class="sticky-sidebar">
            <div class="card scanner-card">
                <div class="card-header bg-white py-3 border-bottom border-dark d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bolder text-dark">
                        <i class="fas fa-microscope text-primary me-2"></i>Specimen Collection
                    </h6>
                    <div class="d-flex align-items-center gap-1 fs--2 text-dark fw-bold">
                        <span class="pulse-indicator me-1"></span> Ready
                    </div>
                </div>

                <div class="card-body p-3">
                    <!-- Date Range Picker -->
                    <div class="mb-3">
                        <label class="form-label fs--1 fw-bolder text-dark mb-1">Rentang Tanggal</label>
                        <div class="input-group">
                            <span class="input-group-text text-dark" style="background-color: var(--retro-yellow); border: 2px solid var(--retro-dark); border-right: none; border-top-left-radius: 6px; border-bottom-left-radius: 6px;"><i class="fas fa-calendar-alt"></i></span>
                            <input class="form-control datetimepicker fs--1 retro-input" id="timepicker3" type="text"
                                placeholder="Pilih rentang tanggal..."
                                data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' style="border: 2px solid var(--retro-dark); border-radius: 0 6px 6px 0;" />
                        </div>
                    </div>

                    <!-- Barcode/QR Scanner Input -->
                    <div class="mb-2">
                        <label for="no_reg" class="form-label fs--1 fw-bolder text-dark mb-1">Scan Barcode / No. Registrasi</label>
                        <div class="input-group scan-input-group">
                            <span class="input-group-text"><i class="fas fa-qrcode fs-0"></i></span>
                            <input type="text" name="no_reg"
                                class="form-control form-control-lg fs-0 fw-bold text-dark" id="no_reg"
                                placeholder="Arahkan scanner ke sini..." onkeydown="search(this)" autofocus autocomplete="off">
                        </div>
                        <span class="fs--2 text-dark fw-bold mt-2 d-block"><i class="fas fa-info-circle me-1 text-primary"></i>Tekan Enter setelah melakukan scanning.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: DETAILED SPECIMEN CONTENT -->
    <div class="col-lg-8">
        <div id="menu-detail-specimen">
            <!-- EMPTY STATE INITIAL DISPLAY -->
            <div class="empty-specimen-state shadow-sm">
                <div class="mb-3">
                    <span class="fa-stack fa">
                        <i class="fas fa-circle fa-stack-2x" style="color: var(--retro-yellow);"></i>
                        <i class="fas fa-vial fa-stack-1x text-dark"></i>
                    </span>
                </div>
                <h5 class="fw-bolder text-dark">Belum Ada Spesimen Dipilih</h5>
                <p class="text-dark fs--1 mb-0 mx-auto fw-bold opacity-75" style="max-width: 400px;">
                    Silakan scan barcode spesimen pasien menggunakan kolom input di sebelah kiri untuk menampilkan detail pemeriksaan laboratorium.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODALS -->
<div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 95%;">
        <div class="modal-content retro-card border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close" style="border: 2px solid var(--retro-dark); border-radius: 50%; padding: 5px; box-shadow: 2px 2px 0px var(--retro-dark); background-color: var(--retro-yellow);"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content retro-card border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close" style="border: 2px solid var(--retro-dark); border-radius: 50%; padding: 5px; box-shadow: 2px 2px 0px var(--retro-dark); background-color: var(--retro-yellow);"></button>
            </div>
            <div id="menu-poliklinik"></div>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>

<script>
    $(document).ready(function() {
        if ($('#example').length) {
            new DataTable('#example', {
                responsive: true
            });
        }
    });

    // TOAST NOTIFICATION HELPER
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    // LOADING SPINNER UI
    const loadingCard = `
            <div class="card retro-card border-0">
                <div class="card-body text-center py-5">
                    <div class="spinner-border text-dark mb-3" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h6 class="fw-bolder text-dark mb-1">Mencari Data Spesimen...</h6>
                    <p class="text-dark fw-bold fs--1 mb-0">Sistem sedang memproses barcode registrasi</p>
                </div>
            </div>
        `;

    function search(ele) {
        if (event.key === 'Enter') {
            var code = document.getElementById('no_reg').value;
            if (code.trim() == "") {
                Toast.fire({
                    icon: "error",
                    title: "Scan Tidak Boleh Kosong"
                });
            } else {
                $('#menu-detail-specimen').html(loadingCard);

                $.ajax({
                    url: "{{ route('data_specimen_collection_lab_cari_data') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code,
                    },
                    dataType: 'html',
                }).done(function(data) {
                    document.getElementById('no_reg').value = "";

                    if (data.trim() == 'false') {
                        resetToEmptyState();
                        Toast.fire({
                            icon: "warning",
                            title: "Data Tidak Ditemukan"
                        });
                    } else if (data.trim() == 'done') {
                        resetToEmptyState();
                        Toast.fire({
                            icon: "info",
                            title: "Data Sudah di Handling"
                        });
                    } else if (data.trim() == 'not') {
                        resetToEmptyState();
                        Toast.fire({
                            icon: "warning",
                            title: "Pasien Belum Melakukan Handling"
                        });
                    } else {
                        $('#menu-detail-specimen').html(data);
                        Toast.fire({
                            icon: "success",
                            title: "Data Ditemukan"
                        });
                    }
                }).fail(function() {
                    resetToEmptyState();
                    Toast.fire({
                        icon: "error",
                        title: "Gagal terhubung ke server. Silakan coba lagi."
                    });
                });
            }
        }
    }

    function resetToEmptyState() {
        $('#menu-detail-specimen').html(`
                <div class="empty-specimen-state shadow-sm">
                    <div class="mb-3">
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x" style="color: var(--retro-yellow);"></i>
                            <i class="fas fa-vial fa-stack-1x text-dark"></i>
                        </span>
                    </div>
                    <h5 class="fw-bolder text-dark">Belum Ada Spesimen Dipilih</h5>
                    <p class="text-dark fs--1 mb-0 mx-auto fw-bold opacity-75" style="max-width: 400px;">
                        Silakan scan barcode spesimen pasien menggunakan kolom input di sebelah kiri untuk menampilkan detail pemeriksaan laboratorium.
                    </p>
                </div>
            `);
    }

    $(document).on("click", "#button-simpan-proses-specimen-collection", function(e) {
        e.preventDefault();
        var code = $(this).data("code");

        Swal.fire({
            title: "Konfirmasi Simpan",
            text: "Apakah Anda yakin ingin memproses spesimen collection ini?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#c1ff72",
            cancelButtonColor: "#ffa6c9",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $('#menu-proses-specimen-collection').html(`
                        <div class="text-center py-4">
                            <div class="spinner-border text-dark mb-2" role="status"></div>
                            <p class="text-dark fw-bold fs--1 mb-0">Menyimpan data spesimen...</p>
                        </div>
                    `);

                $.ajax({
                    url: "{{ route('data_specimen_collection_lab_proses_simpan_fix') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code
                    },
                    dataType: 'html',
                }).done(function(data) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Proses simpan spesimen berhasil dilakukan.",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }).fail(function() {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Terjadi kesalahan saat menyimpan data.",
                        icon: "error"
                    });
                });
            }
        });
    });
</script>
@endsection
