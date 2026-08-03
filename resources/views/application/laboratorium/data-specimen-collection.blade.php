@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<style>
    /* Modern Header Hero */
    .page-header-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border: none;
        color: #ffffff;
    }

    /* Glassmorphic Scanner Card Styling */
    .scanner-card {
        border: 1px solid #e2e8f0;
        border-top: 4px solid #3b82f6;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border-radius: 0.75rem;
        background: #ffffff;
    }

    .scan-input-group .input-group-text {
        background-color: #3b82f6;
        color: #ffffff;
        border-color: #3b82f6;
    }

    .scan-input-group input:focus {
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
        border-color: #3b82f6;
    }

    /* Status Indicator Pulse */
    .pulse-indicator {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulse 1.6s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        }

        70% {
            transform: scale(1);
            box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
        }

        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
        }
    }

    /* Modern Empty State */
    .empty-specimen-state {
        border: 2px dashed #cbd5e1;
        border-radius: 0.75rem;
        background-color: #f8fafc;
        padding: 3rem 1.5rem;
        text-align: center;
    }
</style>
@endsection

@section('content')
<!-- BREADCRUMB & HERO HEADER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative"
            style="background: linear-gradient(135deg, #1f6f92 0%, #203a43 50%, #2c5364 100%);">

            <!-- Hiasan Blur Glowing Circle -->
            <div class="position-absolute rounded-circle bg-primary opacity-25 blur-3xl"
                style="width: 250px; height: 250px; top: -80px; right: 10%; filter: blur(60px);"></div>
            <div class="position-absolute rounded-circle bg-info opacity-25 blur-3xl"
                style="width: 200px; height: 200px; bottom: -80px; left: -50px; filter: blur(50px);"></div>

            <div class="card-body p-4 text-white position-relative z-1">
                <div class="row align-items-center gy-3">

                    <!-- Brand & App Label -->
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 bg-opacity-1 rounded-4 shadow-sm me-3 border-opacity-10 d-flex align-items-center justify-content-center backdrop-blur"
                            style="width: 65px; height: 65px; backdrop-filter: blur(10px);">
                            <img src="{{ asset('img/verif.png') }}" alt="Logo" class="img-fluid drop-shadow" width="42" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-primary text-dark fw-bold px-2 py-1 rounded-pill" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                    <i class="fas fa-shield-alt me-1 text-info"></i> <span class="text-white" style="font-size: 0.75rem;">v2.4 Medical Suite</span>
                                </span>
                            </div>
                            <h3 class="text-white fw-extrabold mb-0 tracking-tight" style="font-size: 1.4rem;">
                                Welcome to {{ Env('APP_LABEL')}} <span class="text-info fw-light">Management System</span>
                            </h3>
                        </div>
                    </div>

                    <!-- Module Badge / Quick Nav -->
                    <div class="col-lg-5 text-lg-end border-start-lg border-white border-opacity-10 ps-lg-4">
                        <!-- <span class="text-white-50 text-uppercase fw-semibold d-block mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Module Aktif</span> -->
                        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 border border-white border-opacity-20 px-3 py-2 rounded-pill backdrop-blur">
                            <!-- <span class="p-1 bg-success rounded-circle me-2 animate-pulse" style="width: 8px; height: 8px;"></span> -->
                            <h6 class="text-primary fw-bold mb-0" style="font-size: 0.95rem;">
                                <i class="fas fa-copy me-1"></i> Laboratorium Specimen Collection
                            </h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN TWO-COLUMN LAYOUT -->
<div class="row g-3">
    <!-- LEFT COLUMN: SCANNER & FILTER PANEL -->
    <div class="col-lg-4">
        <div class="sticky-sidebar">
            <div class="card scanner-card">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold text-700">
                        <i class="fas fa-microscope text-primary me-2"></i>Specimen Collection
                    </h6>
                    <div class="d-flex align-items-center gap-1 fs--2 text-muted fw-semibold">
                        <span class="pulse-indicator me-1"></span> Ready
                    </div>
                </div>

                <div class="card-body p-3">
                    <!-- Date Range Picker -->
                    <div class="mb-3">
                        <label class="form-label fs--1 fw-semi-bold text-600 mb-1">Rentang Tanggal</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-500"><i class="fas fa-calendar-alt"></i></span>
                            <input class="form-control datetimepicker fs--1" id="timepicker3" type="text"
                                placeholder="Pilih rentang tanggal..."
                                data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' />
                        </div>
                    </div>

                    <!-- Barcode/QR Scanner Input -->
                    <div class="mb-2">
                        <label for="no_reg" class="form-label fs--1 fw-bold text-primary mb-1">Scan Barcode / No. Registrasi</label>
                        <div class="input-group scan-input-group">
                            <span class="input-group-text"><i class="fas fa-qrcode fs-0"></i></span>
                            <input type="text" name="no_reg"
                                class="form-control form-control-lg fs-0 fw-bold text-dark" id="no_reg"
                                placeholder="Arahkan scanner ke sini..." onkeydown="search(this)" autofocus autocomplete="off">
                        </div>
                        <span class="fs--2 text-muted mt-1 d-block"><i class="fas fa-info-circle me-1"></i>Tekan Enter setelah melakukan scanning.</span>
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
                    <span class="fa-stack fa-2x">
                        <i class="fas fa-circle fa-stack-2x text-200"></i>
                        <i class="fas fa-vial fa-stack-1x text-400"></i>
                    </span>
                </div>
                <h5 class="fw-bold text-700">Belum Ada Spesimen Dipilih</h5>
                <p class="text-500 fs--1 mb-0 mx-auto" style="max-width: 400px;">
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
        <div class="modal-content border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
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
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h6 class="fw-bold text-700 mb-1">Mencari Data Spesimen...</h6>
                    <p class="text-muted fs--1 mb-0">Sistem sedang memproses barcode registrasi</p>
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
                            <i class="fas fa-circle fa-stack-2x text-200"></i>
                            <i class="fas fa-vial fa-stack-1x text-400"></i>
                        </span>
                    </div>
                    <h5 class="fw-bold text-700">Belum Ada Spesimen Dipilih</h5>
                    <p class="text-500 fs--1 mb-0 mx-auto" style="max-width: 400px;">
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
            confirmButtonColor: "#22c55e",
            cancelButtonColor: "#ef4444",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $('#menu-proses-specimen-collection').html(`
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary mb-2" role="status"></div>
                            <p class="text-muted fs--1 mb-0">Menyimpan data spesimen...</p>
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
