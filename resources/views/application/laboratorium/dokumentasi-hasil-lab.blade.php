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

    /* Item Card Custom Styling Retro */
    .handling-card {
        transition: all 0.1s ease-in-out;
        cursor: pointer;
        border: 2px solid var(--retro-dark) !important;
        border-left: 6px solid var(--retro-dark) !important;
        border-radius: 8px !important;
        box-shadow: 2px 2px 0px var(--retro-dark);
        background-color: #ffffff;
        margin-bottom: 10px;
    }

    .handling-card:not(.active-handling):hover {
        transform: translate(-2px, -2px);
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
        background-color: var(--retro-cyan) !important;
    }

    .handling-card.active-handling {
        background-color: var(--retro-yellow) !important;
        border-left-color: var(--retro-green) !important;
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
        transform: translate(-2px, -2px);
    }

    .handling-card.active-handling .patient-name {
        color: var(--retro-dark) !important;
        font-weight: 900;
    }

    .retro-input,
    .form-control {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
        background-color: #ffffff !important;
    }

    .retro-input:focus,
    .form-control:focus {
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
        outline: none;
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
<!-- Header Banner Modern -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark position-relative z-1">
                <div class="row align-items-center gy-3">
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

                    <div class="col-lg-5 text-lg-end">
                        <div class="d-inline-flex align-items-center bg-white px-3 py-2 rounded-pill" style="border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <h6 class="fw-bolder mb-0 text-dark" style="font-size: 0.95rem;">
                                <i class="fas fa-file-signature me-1 text-warning"></i> Dokumentasi Hasil Laboratorium
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Sidebar Kiri: Daftar Handling Pasien -->
    <div class="col-lg-4">
        <div class="sticky-sidebar">
            <div class="card retro-card">
                <div class="card-header py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow);">
                    <h6 class="mb-0 text-dark fw-bolder">
                        <i class="fas fa-list-ul text-dark me-2"></i>Daftar Handling Selesai
                    </h6>
                    <span class="retro-badge" style="background-color: white; color: var(--retro-dark);">
                        {{ count($data) }} Pasien
                    </span>
                </div>

                <div class="card-body bg-white p-3">
                    <!-- Filter Section -->
                    <div class="row g-2 mb-3">
                        <div class="col-12">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text text-dark fw-bold" style="background-color: var(--retro-cyan); border: 2px solid var(--retro-dark); border-right: none; border-top-left-radius: 6px; border-bottom-left-radius: 6px;">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <input class="form-control datetimepicker bg-white border-start-0 retro-input" id="timepicker3" type="text" placeholder="Pilih Rentang Tanggal..." data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' style="border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;" />
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text text-dark fw-bold" style="background-color: var(--retro-cyan); border: 2px solid var(--retro-dark); border-right: none; border-top-left-radius: 6px; border-bottom-left-radius: 6px;">
                                    <i class="fas fa-qrcode"></i>
                                </span>
                                <input type="text" name="nik" class="form-control bg-white border-start-0 retro-input" id="nik" placeholder="Scan Barcode / Cari No Reg..." style="border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;">
                            </div>
                        </div>
                    </div>

                    <hr class="my-3 border-dark" style="border-width: 2px;" />

                    <!-- Daftar Item Pasien -->
                    <div class="d-flex flex-column gap-2 overflow-auto patient-list-container" style="max-height: 600px;">
                        @forelse ($data as $datas)
                        <div class="handling-card p-3"
                            id="button-dokumentasi-hasil-lab"
                            data-code="{{ $datas->registrasi_id }}">
                            <div class="card-body p-0">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="mb-0 patient-name fw-bolder text-dark fs--1 text-uppercase">
                                        <i class="fas fa-user-circle me-1 text-primary"></i>{{ $datas->master_patient_name }}
                                    </h6>
                                    <span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark); font-size: 0.65rem;">
                                        {{ $datas->no_registrasi }}
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center text-dark fs--2 mt-2 fw-bold">
                                    <span><i class="fas fa-clock text-dark me-1"></i>{{ $datas->d_reg_order_lab_date }}</span>
                                    <span class="text-dark fw-bolder">{{ $datas->total_pemeriksaan }} Layanan</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 bg-white rounded-3 border-2 border-dark" style="border: 2px dashed var(--retro-dark);">
                            <i class="fas fa-inbox text-dark fs-3 mb-2"></i>
                            <p class="fs--1 text-dark fw-bold mb-0">Tidak ada data terverifikasi.</p>
                        </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Kanan: Detail Handling Pasien -->
    <div class="col-lg-8">
        <div id="menu-detail-handling">
            <div class="retro-card h-100 min-vh-50 d-flex align-items-center justify-content-center p-5 text-center">
                <div>
                    <div class="mb-3">
                        <span class="fa-stack fa-3x">
                            <i class="fas fa-circle fa-stack-2x" style="color: var(--retro-yellow);"></i>
                            <i class="fas fa-notes-medical fa-stack-1x text-dark"></i>
                        </span>
                    </div>
                    <h5 class="fw-bolder text-dark">Pilih Pasien Dari Daftar Handling</h5>
                    <p class="text-dark fs--1 mb-0 mx-auto fw-bold opacity-75" style="max-width: 400px;">
                        Klik salah satu antrean pasien di sebelah kiri untuk melihat rincian dokumentasi dan file hasil laboratorium.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content retro-card border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close" style="border: 2px solid var(--retro-dark); border-radius: 50%; padding: 5px; box-shadow: 2px 2px 0px var(--retro-dark); background-color: var(--retro-yellow);"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>

<script>
    $(document).ready(function() {
        // Event Klik Item Handling Pasien
        $(document).on("click", "#button-dokumentasi-hasil-lab", function(e) {
            e.preventDefault();
            var code = $(this).data("code"); // Mengirim registrasi_id

            $(".handling-card").removeClass("active-handling");
            $(this).addClass("active-handling");

            $('#menu-detail-handling').html(
                '<div class="retro-card py-5 text-center">' +
                '<div class="card-body">' +
                '<div class="spinner-border text-dark my-3" role="status" style="width: 2.5rem; height: 2.5rem;"><span class="visually-hidden">Loading...</span></div>' +
                '<p class="fs--1 text-dark fw-bold mb-0">Memuat rincian dokumentasi hasil lab pasien...</p>' +
                '</div>' +
                '</div>'
            );

            $.ajax({
                url: "{{ route('dokumentasi_hasil_laboratorium_detail') }}",
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
                $('#menu-detail-handling').html(
                    '<div class="alert alert-danger shadow-sm border-2 border-dark text-center my-3 fw-bold" role="alert" style="border-radius: 8px;">' +
                    '<i class="fas fa-exclamation-triangle me-2"></i> Terjadi kesalahan sistem saat memuat data.' +
                    '</div>'
                );
            });
        });
    });
</script>
@endsection
