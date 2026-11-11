@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

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
        color: var(--retro-dark);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Retro Cards & Banners */
    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        background-color: #ffffff;
        overflow: hidden;
    }

    .retro-header-banner {
        background: linear-gradient(135deg, var(--retro-cyan) 0%, var(--retro-purple) 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-dark);
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

    /* Handling List Sidebar Card */
    .rad-sidebar-card {
        background: #ffffff;
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        overflow: hidden;
    }

    .rad-sidebar-header {
        background-color: var(--retro-dark);
        color: var(--retro-green);
        border-bottom: 2px solid var(--retro-dark);
        padding: 14px 18px;
    }

    /* Interactive Handling Item Card */
    .handling-item-card {
        border: 2px solid var(--retro-dark);
        border-radius: 8px;
        background-color: #ffffff;
        transition: all 0.1s ease-in-out;
        cursor: pointer;
        box-shadow: 2px 2px 0px var(--retro-dark);
    }

    .handling-item-card:hover {
        background-color: var(--retro-cyan) !important;
        transform: translate(-1px, -1px);
        box-shadow: 3px 3px 0px var(--retro-dark);
    }

    .handling-item-card.active-rad-item {
        background-color: var(--retro-yellow) !important;
        border-color: var(--retro-dark) !important;
        color: var(--retro-dark) !important;
        box-shadow: 3px 3px 0px var(--retro-dark) !important;
    }

    .handling-item-card.active-rad-item .patient-title {
        color: var(--retro-dark) !important;
    }

    .handling-item-card.active-rad-item .reg-code-badge {
        background-color: #ffffff !important;
        color: var(--retro-dark) !important;
        border: 2px solid var(--retro-dark);
    }

    /* Code Chips */
    .code-chip {
        font-family: 'Courier New', Courier, monospace;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 6px;
        background-color: #ffffff;
        border: 2px solid var(--retro-dark);
        display: inline-block;
    }

    /* Input Custom Styles */
    .rad-search-input {
        border-radius: 6px !important;
        border: 2px solid var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
    }

    .rad-search-input:focus {
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
    }

    /* Modals Custom Styling */
    .modal-content.rad-modal {
        border: 3px solid var(--retro-dark);
        border-radius: 14px;
        box-shadow: 8px 8px 0px var(--retro-dark);
        background-color: var(--retro-bg);
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<!-- HERO HEADER RADIOLOGI -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark position-relative z-1">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <img src="{{ asset('img/verif.png') }}" alt="Radiology Dokumentasi Logo" class="img-fluid" width="42" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="retro-badge" style="background-color: var(--retro-yellow); color: var(--retro-dark);">
                                    <i class="fas fa-radiation me-1"></i> TRANS MANAGEMENT SYSTEM
                                </span>
                            </div>
                            <h3 class="fw-bolder mb-0 text-dark" style="font-size: 1.3rem; text-shadow: 1px 1px 0px white;">
                                Welcome to <span style="text-decoration: underline;">Management System</span>
                            </h3>
                            <p class="text-dark fw-bold mb-0 small opacity-75" style="font-size: 0.75rem;">Modul Pengolahan & Dokumentasi Hasil Radiologi</p>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end">
                        <div class="d-inline-flex align-items-center bg-white px-3 py-2 rounded-pill" style="border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <h6 class="fw-bolder mb-0 text-dark" style="font-size: 0.95rem;">
                                <i class="fas fa-file-medical-alt me-1 text-danger"></i> Radiologi : Dokumentasi Hasil
                            </h6>
                        </div>
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
                    <h6 class="mb-0 text-white fw-bolder">
                        <i class="fas fa-tasks me-2"></i>Daftar Handling
                    </h6>
                    <span class="badge bg-white text-dark border border-dark rounded-2 px-2 py-1 fw-bold shadow-sm">
                        {{ count($data) }} Pasien
                    </span>
                </div>
                <div class="card-body bg-white p-3">
                    <!-- FILTER CONTROLS -->
                    <div class="col-12 mb-3">
                        <div class="input-group input-group-sm mb-2 shadow-sm">
                            <span class="input-group-text bg-white text-dark border-dark border-end-0 fw-bold" style="border-width: 2px 0 2px 2px;"><i class="fas fa-calendar-alt"></i></span>
                            <input class="form-control datetimepicker rad-search-input" id="timepicker3" type="text" placeholder="Filter Rentang Tanggal..." data-options='{"mode":"range","dateFormat":"d/m/Y","disableMobile":true,"locale":"en"}' />
                        </div>
                        <div class="input-group input-group-sm shadow-sm">
                            <span class="input-group-text bg-white text-dark border-dark border-end-0 fw-bold" style="border-width: 2px 0 2px 2px;"><i class="fas fa-qrcode"></i></span>
                            <input type="text" name="nik" class="form-control rad-search-input" id="nik" placeholder="Scan QR / No. Reg / NIK...">
                        </div>
                    </div>

                    <hr class="my-3 text-dark" style="border-top: 2px solid var(--retro-dark);" />

                    <!-- HANDLING ITEMS SCROLL CONTAINER -->
                    <div class="handling-list-wrapper pe-1" style="max-height: 580px; overflow-y: auto;">
                        @forelse ($data as $datas)
                        <div class="handling-item-card remove-class p-3 mb-2"
                            id="button-dokumentasi-hasil-rad"
                            data-code="{{ $datas->d_reg_order_rad_code }}">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="fw-bolder text-dark patient-title mb-0 transition-base" style="font-size: 0.9rem;">
                                    {{ $datas->master_patient_name }}
                                </h6>
                                <i class="fas fa-chevron-right text-dark fs--2 mt-1"></i>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <span class="text-dark fw-bold small fs--2">No. Registrasi:</span>
                                <span class="code-chip reg-code-badge fs--2 text-dark">{{ $datas->d_reg_order_rad_code }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 px-2 border-2 border-dashed border-dark rounded-3 bg-light">
                            <i class="fas fa-inbox text-dark fa-2x mb-2"></i>
                            <p class="text-dark fw-bold small mb-0">Tidak ada daftar handling pemeriksaan.</p>
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
            <div class="rad-sidebar-card p-5 text-center bg-white">
                <div class="py-4">
                    <div class="p-3 rounded-circle d-inline-block mb-3 fw-bold" style="width: 80px; height: 80px; background-color: var(--retro-yellow); border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                        <i class="fas fa-file-medical fa-2x text-dark mt-2"></i>
                    </div>
                    <h5 class="fw-bolder text-dark">Pilih Pasien Dari Daftar Handling</h5>
                    <p class="text-dark fw-bold small mx-auto mb-0 opacity-75" style="max-width: 420px;">
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
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base bg-white border border-dark fw-bold shadow-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik-full" class="p-3"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content rad-modal border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base bg-white border border-dark fw-bold shadow-sm" data-bs-dismiss="modal" aria-label="Close"></button>
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
            <div class="rad-sidebar-card p-5 text-center bg-white">
                <div class="py-5">
                    <div class="spinner-border text-dark mb-3" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h6 class="fw-bolder text-dark mb-1">Memuat Dokumentasi Hasil Radiologi...</h6>
                    <p class="text-dark small mb-0 fw-bold opacity-75">Sedang mengambil data pemeriksaan pasien.</p>
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
                <div class="alert alert-danger border-2 border-dark rounded-3 p-4 text-center fw-bold shadow-sm" role="alert" style="background-color: var(--retro-pink); color: var(--retro-dark);">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <h6 class="fw-bolder">Gagal Memuat Detail Handling</h6>
                    <p class="small mb-0">Terjadi kesalahan pada jaringan atau server. Silakan coba lagi.</p>
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
            confirmButtonColor: "#ffde59",
            cancelButtonColor: "#ffa6c9",
            confirmButtonText: "<i class='fas fa-paper-plane me-1 text-dark'></i> Ya, Kirim Hasil!",
            cancelButtonText: "Batal",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
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
                        confirmButtonColor: "#1e1e24"
                    });
                });
            }
        });
    });
</script>
@endsection
