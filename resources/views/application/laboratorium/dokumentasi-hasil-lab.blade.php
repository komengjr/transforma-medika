@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

<style>
    /* Item Card Custom Styling */
    .handling-card {
        transition: all 0.25s ease-in-out;
        cursor: pointer;
        border-left: 4px solid transparent !important;
        background-color: #ffffff;
    }

    .handling-card:not(.active-handling):hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
        border-color: #2c7be5 !important;
        background-color: #ffffff !important;
    }

    .handling-card.active-handling {
        background-color: rgb(19, 28, 42) !important;
        border-left: 4px solid #2c7be5 !important;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        transform: none !important;
    }

    .handling-card.active-handling .patient-name {
        color: #2c7be5 !important;
        font-weight: 700;
    }
</style>
@endsection

@section('content')
<!-- Header Banner Modern -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden position-relative"
            style="background: linear-gradient(135deg, #1f6f92 0%, #203a43 50%, #2c5364 100%);">

            <div class="position-absolute rounded-circle bg-primary opacity-25 blur-3xl"
                style="width: 250px; height: 250px; top: -80px; right: 10%; filter: blur(60px);"></div>
            <div class="position-absolute rounded-circle bg-info opacity-25 blur-3xl"
                style="width: 200px; height: 200px; bottom: -80px; left: -50px; filter: blur(50px);"></div>

            <div class="card-body p-4 text-white position-relative z-1">
                <div class="row align-items-center gy-3">
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

                    <div class="col-lg-5 text-lg-end border-start-lg border-white border-opacity-10 ps-lg-4">
                        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 border border-white border-opacity-20 px-3 py-2 rounded-pill backdrop-blur">
                            <h6 class="text-primary fw-bold mb-0" style="font-size: 0.95rem;">
                                <i class="fas fa-file-signature me-1"></i> Dokumentasi Hasil Laboratorium
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Sidebar Kiri: Daftar Handling Pasien -->
    <div class="col-lg-4">
        <div class="sticky-sidebar">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header text-white py-3 px-3 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #1a3d8f 0%, #1e293b 100%);">
                    <h6 class="mb-0 text-white fw-bold">
                        <i class="fas fa-list-ul text-white me-2"></i>Daftar Handling Selesai
                    </h6>
                    <span class="badge bg-primary rounded-pill px-2 py-1 fs--2">
                        {{ count($data) }} Pasien
                    </span>
                </div>

                <div class="card-body bg-light p-3">
                    <!-- Filter Section -->
                    <div class="row g-2 mb-3">
                        <div class="col-12">
                            <div class="input-group input-group-sm shadow-sm">
                                <span class="input-group-text bg-white border-end-0 text-primary">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <input class="form-control datetimepicker bg-white border-start-0" id="timepicker3" type="text" placeholder="Pilih Rentang Tanggal..." data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' />
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-group input-group-sm shadow-sm">
                                <span class="input-group-text bg-white border-end-0 text-primary">
                                    <i class="fas fa-qrcode"></i>
                                </span>
                                <input type="text" name="nik" class="form-control bg-white border-start-0" id="nik" placeholder="Scan Barcode / Cari No Reg...">
                            </div>
                        </div>
                    </div>

                    <hr class="my-3 border-line-dashed opacity-50" />

                    <!-- Daftar Item Pasien -->
                    <div class="d-flex flex-column gap-2 overflow-auto" style="max-height: 600px;">
                        @forelse ($data as $datas)
                        <div class="card border-0 shadow-sm handling-card"
                            id="button-dokumentasi-hasil-lab"
                            data-code="{{ $datas->registrasi_id }}">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="mb-0 patient-name fw-bold text-800 fs--1">
                                        <i class="fas fa-user-circle me-1 text-primary"></i>{{ $datas->master_patient_name }}
                                    </h6>
                                    <span class="badge bg-soft-primary text-primary fs--2 fw-semi-bold">
                                        {{ $datas->no_registrasi }}
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center text-500 fs--2 mt-2">
                                    <span><i class="fas fa-clock text-warning me-1"></i>{{ $datas->d_reg_order_lab_date }}</span>
                                    <span class="text-primary fw-semibold">{{ $datas->total_pemeriksaan }} Layanan</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 bg-white rounded-3 border border-dashed">
                            <i class="fas fa-inbox text-400 fs-3 mb-2"></i>
                            <p class="fs--1 text-600 mb-0">Tidak ada data terverifikasi.</p>
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
            <div class="card shadow-sm border-0 h-100 min-vh-50 d-flex align-items-center justify-content-center p-5 text-center">
                <div class="avatar avatar-5xl bg-soft-primary rounded-circle mb-3 p-3">
                    <i class="fas fa-notes-medical text-primary fs-3"></i>
                </div>
                <h5 class="fw-bold text-800">Pilih Pasien Dari Daftar Handling</h5>
                <p class="text-500 fs--1 mb-0" style="max-width: 400px;">
                    Klik salah satu antrean pasien di sebelah kiri untuk melihat rincian dokumentasi dan file hasil laboratorium.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
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
                '<div class="card shadow-sm border-0 py-5 text-center">' +
                '<div class="card-body">' +
                '<div class="spinner-border text-primary my-3" role="status"><span class="visually-hidden">Loading...</span></div>' +
                '<p class="fs--1 text-600 mb-0">Memuat rincian dokumentasi hasil lab pasien...</p>' +
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
                    '<div class="alert alert-danger shadow-sm border-0 text-center my-3" role="alert">' +
                    '<i class="fas fa-exclamation-triangle me-2"></i> Terjadi kesalahan sistem saat memuat data.' +
                    '</div>'
                );
            });
        });
    });
</script>
@endsection
