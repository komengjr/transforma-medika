@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

<style>
    /* Gradient Header Style */
    .bg-gradient-primary-custom {
        background: linear-gradient(135deg, #2c7be5 0%, #1a5bb8 100%);
    }

    /* Patient Card Styling */
    .patient-card {
        transition: all 0.25s ease-in-out;
        cursor: pointer;
        border-left: 4px solid #cbd5e1 !important;
    }

    .patient-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(44, 123, 229, 0.15) !important;
        border-left-color: #2c7be5 !important;
        background-color: #f8faff;
    }

    /* Active State saat item dipilih */
    .patient-card.active-patient {
        border-left-color: #00d27a !important;
        background-color: #edf2f9;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
    }

    /* Scrollable Patient List */
    .patient-list-container {
        max-height: 520px;
        overflow-y: auto;
        padding-right: 4px;
    }

    /* Custom Scrollbar */
    .patient-list-container::-webkit-scrollbar {
        width: 5px;
    }

    .patient-list-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
</style>
@endsection

@section('content')
<!-- BANNER HEADER ATAS -->
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
                        <div class="p-2 bg-opacity-10 rounded-4 shadow-sm me-3 border-opacity-10 d-flex align-items-center justify-content-center backdrop-blur"
                            style="width: 65px; height: 65px; backdrop-filter: blur(10px);">
                            <img src="{{ asset('img/dashboard.png') }}" alt="Logo" class="img-fluid drop-shadow" width="42" />
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
                                <i class="fas fa-file-prescription me-1"></i> Proses Result Entry
                            </h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- CONTENT MAIN GRID -->
<div class="row g-3">
    <!-- KIRI: FILTER & DAFTAR PASIEN -->
    <div class="col-lg-4">
        <div class="sticky-sidebar">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-light py-2 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold text-700">
                        <i class="fas fa-list-alt text-primary me-1"></i> Antrean Pasien Lab
                    </h6>
                    <span class="badge bg-soft-primary text-primary rounded-pill">{{ count($data) }} Pasien</span>
                </div>

                <div class="card-body p-3">
                    <!-- FILTER AREA -->
                    <div class="mb-3">
                        <label class="form-label fs--2 fw-semibold text-600 mb-1">Rentang Tanggal</label>
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text bg-white border-end-0 text-primary"><i class="fas fa-calendar-alt"></i></span>
                            <input class="form-control datetimepicker border-start-0" id="timepicker3" type="text" placeholder="Pilih rentang tanggal..." data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' />
                        </div>

                        <label class="form-label fs--2 fw-semibold text-600 mb-1">Scan / Cari No Reg</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0 text-primary"><i class="fas fa-qrcode"></i></span>
                            <input type="text" name="no_reg" class="form-control border-start-0 bg-white" id="no_reg" placeholder="Scan barcode / ketik No Reg..." onkeydown="search(this)" autofocus>
                        </div>
                    </div>

                    <hr class="my-2 text-200">

                    <!-- LIST PASIEN -->
                    <div class="patient-list-container">
                        @forelse ($data as $datas)
                        <div class="card border mb-2 patient-card remove-class shadow-none" id="button-proses-result-lab" data-code="{{ $datas->d_reg_order_lab_code }}">
                            <div class="card-body p-2">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="mb-0 fw-bold text-dark fs--1">{{ $datas->master_patient_name }}</h6>
                                    <span class="badge bg-soft-warning text-warning fs--2 rounded-pill fw-bold">
                                        {{ $datas->d_reg_order_lab_code }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center fs--2 text-600">
                                    <span><i class="fas fa-clock me-1 text-400"></i>{{ $datas->d_reg_order_lab_date }}</span>
                                    <span class="text-primary fw-semibold fs--2">Proses <i class="fas fa-chevron-right ms-1"></i></span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 text-300"></i>
                            <p class="fs--1 mb-0">Tidak ada antrean pasien</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KANAN: DETAIL RESULT PASIEN -->
    <div class="col-lg-8">
        <div id="menu-detail-result">
            <!-- Empty Placeholder -->
            <div class="card shadow-sm border-0 rounded-3 text-center py-5">
                <div class="card-body">
                    <img src="{{ asset('asset/img/illustrations/1.svg') }}" width="120" alt="Select Patient" class="mb-3 opacity-75">
                    <h5 class="text-700 fw-bold">Pilih Pasien Lab</h5>
                    <p class="text-500 fs--1 mb-0">Klik salah satu pasien dari antrean di sebelah kiri atau scan Barcode untuk memproses hasil laboratorium.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODALS -->
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

<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
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
    $(document).on("click", "#button-proses-result-lab", function(e) {
        e.preventDefault();

        // Visual indicator active state
        $('.patient-card').removeClass('active-patient');
        $(this).addClass('active-patient');

        var code = $(this).data("code");

        $('#menu-detail-result').html(
            '<div class="card shadow-sm border-0 py-5 text-center">' +
            '<div class="card-body">' +
            '<div class="spinner-border text-primary my-3" role="status"><span class="visually-hidden">Loading...</span></div>' +
            '<p class="text-muted fs--1 mb-0">Memuat data hasil pemeriksaan lab...</p>' +
            '</div>' +
            '</div>'
        );

        $.ajax({
            url: "{{ route('menu_lab_proses_result_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-detail-result').html(data);
        }).fail(function() {
            $('#menu-detail-result').html(
                '<div class="alert alert-danger shadow-sm border-0" role="alert">' +
                '<i class="fas fa-exclamation-triangle me-2"></i> Gagal memuat data. Silakan coba lagi.' +
                '</div>'
            );
        });
    });

    $(document).on("click", "#button-simpan-proses-result", function(e) {
        e.preventDefault();
        var data = $("#form-result-pasien").serialize();

        Swal.fire({
            title: "Simpan Hasil Lab?",
            text: "Pastikan seluruh parameter data hasil telah sesuai!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#00d27a",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('menu_lab_proses_result_detail_proses_save') }}",
                    type: "POST",
                    cache: false,
                    data: data,
                    dataType: 'html',
                }).done(function(data) {
                    Swal.fire({
                        title: "Tersimpan!",
                        text: "Data hasil laboratorium berhasil disimpan.",
                        icon: "success"
                    });
                    $('#menu-detail-result').html(data);
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
