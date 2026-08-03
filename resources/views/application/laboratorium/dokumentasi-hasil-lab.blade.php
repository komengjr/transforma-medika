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
    }

    .handling-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
        border-color: #2c7be5 !important;
    }

    /* Active State saat diklik */
    .handling-card.active-handling {
        background-color: rgb(19, 28, 42) !important;
        border-left: 4px solid #2c7be5 !important;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
    }

    .handling-card.active-handling .patient-name {
        color: #2c7be5 !important;
        font-weight: 700;
    }

    /* Custom Glassmorphism Banner */
    .welcome-banner {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-radius: 0.75rem;
    }
</style>
@endsection

@section('content')
<!-- Header Banner Modern -->
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
                <!-- Header Card Sidebar -->
                <div class="card-header text-white py-3 px-3 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #1a3d8f 0%, #1e293b 100%);">
                    <h6 class="mb-0 text-white fw-bold">
                        <i class="fas fa-list-ul text-white me-2"></i>Daftar Handling
                    </h6>
                    <span class="badge bg-primary rounded-pill px-2 py-1 fs--2">
                        {{ count($data) }} Pasien
                    </span>
                </div>

                <div class="card-body bg-light p-3">
                    <!-- Filter Section -->
                    <div class="row g-2 mb-3">
                        <!-- Datepicker Filter -->
                        <div class="col-12">
                            <div class="input-group input-group-sm shadow-sm">
                                <span class="input-group-text bg-white border-end-0 text-primary">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <input class="form-control datetimepicker bg-white border-start-0" id="timepicker3" type="text" placeholder="Pilih Rentang Tanggal..." data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' />
                            </div>
                        </div>

                        <!-- Scan Barcode / NIK Filter -->
                        <div class="col-12">
                            <div class="input-group input-group-sm shadow-sm">
                                <span class="input-group-text bg-white border-end-0 text-primary">
                                    <i class="fas fa-qrcode"></i>
                                </span>
                                <input type="text" name="nik" class="form-control bg-white border-start-0" id="nik" placeholder="Scan Barcode / Cari NIK Pasien...">
                            </div>
                        </div>
                    </div>

                    <hr class="my-3 border-line-dashed opacity-50" />

                    <!-- Daftar Item Pasien (Scrollable Container) -->
                    <div class="d-flex flex-column gap-2 overflow-auto" style="max-height: 600px;">
                        @forelse ($data as $datas)
                        <div class="card border-0 shadow-sm handling-card"
                            id="button-dokumentasi-hasil-lab"
                            data-code="{{ $datas->d_reg_order_lab_code }}">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="mb-0 patient-name fw-bold text-800 fs--1">
                                        <i class="fas fa-user-circle me-1 text-primary"></i>{{ $datas->master_patient_name }}
                                    </h6>
                                    <span class="badge bg-soft-primary text-primary fs--2 fw-semi-bold">
                                        <i class="fas fa-hashtag me-1"></i>{{ $datas->d_reg_order_lab_code }}
                                    </span>
                                </div>

                                <div class="d-flex align-items-center text-500 fs--2 mt-2">
                                    <i class="fas fa-clock text-warning me-1"></i>
                                    <span>Tgl Reg: <strong class="text-700">{{ $datas->d_reg_order_lab_date }}</strong></span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 bg-white rounded-3 border border-dashed">
                            <i class="fas fa-inbox text-400 fs-3 mb-2"></i>
                            <p class="fs--1 text-600 mb-0">Tidak ada data handling hari ini.</p>
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
            <!-- State Default/Placeholder sebelum item dipilih -->
            <div class="card shadow-sm border-0 h-100 min-vh-50 d-flex align-items-center justify-content-center p-5 text-center">
                <div class="avatar avatar-5xl bg-soft-primary rounded-circle mb-3 p-3">
                    <i class="fas fa-notes-medical text-primary fs-3"></i>
                </div>
                <h5 class="fw-bold text-800">Pilih Pasien Dari Daftar Handling</h5>
                <p class="text-500 fs--1 mb-0 style=" max-width: 400px;">
                    Klik salah satu antrean pasien di sebelah kiri untuk melihat rincian pemeriksaan dan melakukan pengisian hasil laboratorium.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- Modal Containers -->
<div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik"></div>
        </div>
    </div>
</div>

<!-- Vendor Scripts -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>

<script>
    new DataTable('#example', {
        responsive: true
    });
</script>

<script>
    $(document).ready(function() {

        // Event Klik Item Handling Pasien
        $(document).on("click", "#button-dokumentasi-hasil-lab", function(e) {
            e.preventDefault();
            var code = $(this).data("code");

            // Toggle Active Class Visual State
            $(".remove-class").removeClass("active-handling");
            $(this).addClass("active-handling");

            // Render Loading Spinner Modern
            $('#menu-detail-handling').html(
                '<div class="card shadow-sm border-0 py-5 text-center">' +
                '<div class="card-body">' +
                '<div class="spinner-border text-primary my-3" role="status"><span class="visually-hidden">Loading...</span></div>' +
                '<p class="fs--1 text-600 mb-0">Memuat rincian data laboratorium pasien...</p>' +
                '</div>' +
                '</div>'
            );

            // AJAX Detail Handling
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
                    '<i class="fas fa-exclamation-triangle me-2"></i> Terjadi kesalahan sistem saat memuat data. Silakan coba lagi.' +
                    '</div>'
                );
            });
        });

        // Event Kirim Dokumentasi Hasil
        $(document).on("click", "#button-kirim-dokumentasi-hasil", function(e) {
            e.preventDefault();
            var code = $(this).data("code");

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success me-2",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            Swal.fire({
                title: "Kirim Dokumen Hasil?",
                text: "Pastikan seluruh parameter hasil laboratorium telah diperiksa dengan benar.",
                icon: "question",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                confirmButtonColor: "#2c7be5",
                cancelButtonColor: "#d33",
                confirmButtonText: "<i class='fas fa-paper-plane me-1'></i> Ya, Kirim Sekarang!",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire({
                        title: "Berhasil!",
                        text: "Dokumen hasil laboratorium berhasil dikirim.",
                        icon: "success"
                    });

                    $('#button-kirim-dokumentasi-hasil').html(
                        '<div class="spinner-border spinner-border-sm text-light me-1" role="status"></div> Mengirim...'
                    );

                    $.ajax({
                        url: "{{ route('dokumentasi_hasil_laboratorium_detail_kirim_hasil') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "code": code,
                        },
                        dataType: 'html',
                    }).done(function(data) {
                        location.reload();
                    }).fail(function() {
                        alert('Terjadi kesalahan jaringan.');
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Dibatalkan",
                        text: "Proses pengiriman dokumen hasil dibatalkan.",
                        icon: "error"
                    });
                }
            });
        });

        // Event Batal Kirim Dokumentasi Hasil
        $(document).on("click", "#button-batal-kirim-dokumentasi-hasil", function(e) {
            e.preventDefault();
            var code = $(this).data("code");

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success me-2",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            Swal.fire({
                title: "Batalkan Pengiriman Hasil?",
                text: "Apakah Anda yakin ingin membatalkan pengiriman dokumen hasil ini?",
                icon: "warning",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Batalkan!",
                cancelButtonText: "Kembali",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire({
                        title: "Berhasil!",
                        text: "Pengiriman hasil berhasil dibatalkan.",
                        icon: "success"
                    });

                    $('#button-batal-kirim-dokumentasi-hasil').html(
                        '<div class="spinner-border spinner-border-sm text-light me-1" role="status"></div> Diproses...'
                    );

                    $.ajax({
                        url: "{{ route('dokumentasi_hasil_laboratorium_detail_kirim_hasil') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "code": code,
                        },
                        dataType: 'html',
                    }).done(function(data) {
                        location.reload();
                    }).fail(function() {
                        alert('Terjadi kesalahan jaringan.');
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: "Dibatalkan",
                        text: "Tindakan pembatalan diurungkan.",
                        icon: "info"
                    });
                }
            });
        });

    });
</script>
@endsection
