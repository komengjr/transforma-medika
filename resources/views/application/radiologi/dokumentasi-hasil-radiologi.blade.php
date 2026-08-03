@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

<style>
    /* ==========================================
     * RADIOLOGY & X-RAY THEME CUSTOM CSS
     * ========================================== */
    :root {
        --rad-dark-bg: #0f172a;
        --rad-card-bg: #1e293b;
        --rad-accent-cyan: #38bdf8;
        --rad-glow-cyan: rgba(56, 189, 248, 0.35);
    }

    /* Hero Header Radiologi */
    .rad-hero-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0369a1 100%);
        border: 1px solid rgba(56, 189, 248, 0.25);
        border-radius: 14px;
        color: #ffffff;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.35);
        position: relative;
        overflow: hidden;
    }

    .rad-hero-header::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -30px;
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, var(--rad-glow-cyan) 0%, transparent 75%);
        pointer-events: none;
    }

    /* Handling List Sidebar Card */
    .rad-sidebar-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .rad-sidebar-header {
        background: linear-gradient(90deg, #0f172a 0%, #1e293b 100%);
        color: #ffffff;
        border-bottom: 2px solid #0284c7;
        padding: 14px 18px;
    }

    /* Interactive Handling Item Card */
    .handling-item-card {
        border: 1px solid #e2e8f0;
        border-left: 4px solid #cbd5e1;
        border-radius: 10px;
        background-color: #ffffff;
        transition: all 0.25s ease-in-out;
        cursor: pointer;
    }

    .handling-item-card:hover {
        border-color: #38bdf8;
        border-left-color: #0284c7;
        background-color: #f0f9ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.12);
    }

    .handling-item-card.active-rad-item {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        border-color: #38bdf8 !important;
        border-left-color: #38bdf8 !important;
        color: #ffffff !important;
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.3) !important;
    }

    .handling-item-card.active-rad-item .patient-title {
        color: #38bdf8 !important;
    }

    .handling-item-card.active-rad-item .reg-code-badge {
        background-color: rgba(56, 189, 248, 0.2) !important;
        color: #38bdf8 !important;
        border: 1px solid rgba(56, 189, 248, 0.4);
    }

    /* Code Chips */
    .code-chip {
        font-family: 'Courier New', Courier, monospace;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 6px;
        background-color: #f1f5f9;
        border: 1px solid #cbd5e1;
        display: inline-block;
    }

    /* Input Custom Styles */
    .rad-search-input {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        transition: border-color 0.2s ease;
    }

    .rad-search-input:focus {
        border-color: #0284c7;
        box-shadow: 0 0 0 0.2rem rgba(2, 132, 199, 0.15);
    }

    /* Modals Custom Styling */
    .modal-content.rad-modal {
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(56, 189, 248, 0.3);
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.5);
    }
</style>
@endsection

@section('content')
<!-- HERO HEADER RADIOLOGI -->
<div class="row mb-3">
    <div class="col-12">
        <div class="rad-hero-header p-3 p-md-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="p-2 bg-white bg-opacity-10 rounded-3 me-3 border border-white-50 d-flex align-items-center justify-content-center"
                        style="width: 60px; height: 60px; backdrop-filter: blur(8px);">
                        <img src="{{ asset('img/verif.png') }}" alt="Radiology Dokumentasi Logo" class="img-fluid" width="40" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-info bg-opacity-20 text-cyan px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.7rem; color: #38bdf8;">
                                <i class="fas fa-radiation me-1"></i> TRANS MANAGEMENT SYSTEM
                            </span>
                        </div>
                        <h4 class="fw-bold mb-0 text-white" style="font-size: 1.3rem;">
                            Welcome to <span style="color: #38bdf8;">Management System</span>
                        </h4>
                        <p class="text-white-50 mb-0 small" style="font-size: 0.75rem;">Modul Pengolahan & Dokumentasi Hasil Radiologi</p>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="bg-white bg-opacity-10 border border-info border-opacity-30 px-3 py-2 rounded-pill backdrop-blur">
                        <span class="text-info fw-bold mb-0" style="font-size: 0.9rem; color: #38bdf8 !important;">
                            <i class="fas fa-file-medical-alt me-2"></i>Radiologi : Dokumentasi Hasil
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN CONTENT SECTION -->
<div class="row g-3">
    <!-- LEFT SIDEBAR: DAFTAR HANDLING -->
    <div class="col-lg-4">
        <div class="sticky-sidebar" style="top: 20px;">
            <div class="rad-sidebar-card">
                <div class="rad-sidebar-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 text-white fw-bold">
                        <i class="fas fa-tasks me-2 text-info"></i>Daftar Handling
                    </h6>
                    <span class="badge bg-info bg-opacity-20 text-cyan rounded-pill px-2 py-1" style="color: #38bdf8;">
                        {{ count($data) }} Pasien
                    </span>
                </div>
                <div class="card-body bg-light p-3">
                    <!-- FILTER CONTROLS -->
                    <div class="col-12 mb-3">
                        <div class="input-group input-group-sm mb-2 shadow-sm">
                            <span class="input-group-text bg-white text-info border-end-0"><i class="fas fa-calendar-alt"></i></span>
                            <input class="form-control datetimepicker rad-search-input border-start-0" id="timepicker3" type="text" placeholder="Filter Rentang Tanggal..." data-options='{"mode":"range","dateFormat":"d/m/Y","disableMobile":true,"locale":"en"}' />
                        </div>
                        <div class="input-group input-group-sm shadow-sm">
                            <span class="input-group-text bg-white text-info border-end-0"><i class="fas fa-qrcode"></i></span>
                            <input type="text" name="nik" class="form-control rad-search-input border-start-0" id="nik" placeholder="Scan QR / No. Reg / NIK...">
                        </div>
                    </div>

                    <hr class="my-2 text-300" />

                    <!-- HANDLING ITEMS SCROLL CONTAINER -->
                    <div class="handling-list-wrapper pe-1" style="max-height: 580px; overflow-y: auto;">
                        @forelse ($data as $datas)
                        <div class="handling-item-card remove-class p-3 mb-2"
                            id="button-dokumentasi-hasil-rad"
                            data-code="{{ $datas->d_reg_order_rad_code }}">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="fw-bold text-dark patient-title mb-0 transition-base" style="font-size: 0.9rem;">
                                    {{ $datas->master_patient_name }}
                                </h6>
                                <i class="fas fa-chevron-right text-muted fs--2 mt-1"></i>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <span class="text-muted small fs--2">No. Registrasi:</span>
                                <span class="code-chip reg-code-badge fs--2 text-primary">{{ $datas->d_reg_order_rad_code }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 px-2">
                            <i class="fas fa-inbox text-400 fa-2x mb-2"></i>
                            <p class="text-muted small mb-0">Tidak ada daftar handling pemeriksaan.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT SECTION: DETAIL DOKUMENTASI HASIL -->
    <div class="col-lg-8">
        <div id="menu-detail-handling">
            <div class="rad-sidebar-card p-5 text-center">
                <div class="py-4">
                    <div class="p-3 bg-soft-info text-info rounded-circle d-inline-block mb-3">
                        <i class="fas fa-file-medical fa-3x"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Pilih Pasien Dari Daftar Handling</h5>
                    <p class="text-muted small mx-auto mb-0" style="max-width: 420px;">
                        Silakan klik salah satu pasien pada panel sebelah kiri untuk menampilkan detail pemeriksaan dan mengunggah dokumentasi hasil radiologi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- Modals Section -->
<div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content rad-modal border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik-full" class="p-3"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content rad-modal border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik" class="p-3"></div>
        </div>
    </div>
</div>

<!-- Scripts -->
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

    // Event Handler: Klik Item Antrean Handling Radiologi
    $(document).on("click", "#button-dokumentasi-hasil-rad", function(e) {
        e.preventDefault();
        var code = $(this).data("code");

        // Styling active item card
        $(".remove-class").removeClass("active-rad-item");
        $(this).addClass("active-rad-item");

        // Loading Indicator State
        $('#menu-detail-handling').html(`
            <div class="rad-sidebar-card p-5 text-center">
                <div class="py-5">
                    <div class="spinner-border text-info mb-3" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h6 class="fw-bold text-dark mb-1">Memuat Dokumentasi Hasil Radiologi...</h6>
                    <p class="text-muted small mb-0">Sedang mengambil data pemeriksaan pasien.</p>
                </div>
            </div>
        `);

        // Request Detail handling via AJAX
        $.ajax({
            url: "{{ route('dokumentasi_hasil_radiologi_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-detail-handling').html(data);
        }).fail(function() {
            $('#menu-detail-handling').html(`
                <div class="alert alert-danger border-0 shadow-sm rounded-3 p-4 text-center role="alert">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2 text-danger"></i>
                    <h6 class="fw-bold">Gagal Memuat Detail Handling</h6>
                    <p class="small mb-0 text-muted">Terjadi kesalahan pada jaringan atau server. Silakan coba lagi.</p>
                </div>
            `);
        });
    });

    // Event Handler: Kirim Dokumentasi Hasil Radiologi
    $(document).on("click", "#button-kirim-dokumentasi-hasil", function(e) {
        e.preventDefault();
        var code = $(this).data("code");

        Swal.fire({
            title: "Konfirmasi Pengiriman Hasil?",
            text: "Pastikan berkas dokumentasi hasil pemeriksaan sudah lengkap dan sesuai.",
            icon: "question",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonColor: "#0284c7",
            cancelButtonColor: "#dc2626",
            confirmButtonText: "<i class='fas fa-paper-plane me-1'></i> Ya, Kirim Hasil!",
            cancelButtonText: "Batal",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Loader saat proses pengiriman
                $('#button-kirim-dokumentasi-hasil').prop('disabled', true).html(`
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Mengirimkan...
                `);

                $.ajax({
                    url: "{{ route('dokumentasi_hasil_radiologi_detail_kirim_hasil') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code,
                    },
                    dataType: 'html',
                }).done(function(data) {
                    Swal.fire({
                        title: "Berhasil Dikirim!",
                        text: "Dokumentasi hasil radiologi telah berhasil dikirim.",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                }).fail(function() {
                    $('#button-kirim-dokumentasi-hasil').prop('disabled', false).html(`
                        <i class="fas fa-paper-plane me-1"></i> Kirim Hasil
                    `);

                    Swal.fire({
                        title: "Gagal Mengirim",
                        text: "Terjadi kesalahan saat proses pengiriman hasil radiologi.",
                        icon: "error",
                        confirmButtonColor: "#0284c7"
                    });
                });
            }
        });
    });
</script>
@endsection
