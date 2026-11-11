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

    /* Patient Card Styling Retro */
    .patient-card {
        transition: all 0.1s ease-in-out;
        cursor: pointer;
        border: 2px solid var(--retro-dark) !important;
        border-left: 6px solid var(--retro-dark) !important;
        border-radius: 8px !important;
        box-shadow: 2px 2px 0px var(--retro-dark);
        margin-bottom: 10px;
        background-color: #ffffff;
    }

    .patient-card:hover {
        transform: translate(-2px, -2px);
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
        background-color: var(--retro-cyan) !important;
    }

    /* Active State saat item dipilih */
    .patient-card.active-patient {
        border-left-color: var(--retro-green) !important;
        background-color: var(--retro-yellow) !important;
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
        transform: translate(-2px, -2px);
    }

    /* Scrollable Patient List */
    .patient-list-container {
        max-height: 520px;
        overflow-y: auto;
        padding-right: 4px;
    }

    /* Custom Scrollbar Retro */
    .patient-list-container::-webkit-scrollbar {
        width: 8px;
    }

    .patient-list-container::-webkit-scrollbar-track {
        background: var(--retro-bg);
        border-left: 2px solid var(--retro-dark);
    }

    .patient-list-container::-webkit-scrollbar-thumb {
        background: var(--retro-dark);
        border-radius: 4px;
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
<!-- BANNER HEADER ATAS -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark position-relative z-1">
                <div class="row align-items-center gy-3">

                    <!-- Brand & App Label -->
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <img src="{{ asset('img/dashboard.png') }}" alt="Logo" class="img-fluid" width="42" />
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
                                <i class="fas fa-file-prescription me-1 text-warning"></i> Proses Result Entry
                            </h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- CONTENT MAIN GRID -->
<div class="row g-4">
    <!-- KIRI: FILTER & DAFTAR PASIEN -->
    <div class="col-lg-4">
        <div class="sticky-sidebar">
            <div class="card retro-card">
                <div class="card-header py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow);">
                    <h6 class="mb-0 fw-bolder text-dark">
                        <i class="fas fa-list-alt text-dark me-1"></i> Antrean Pasien Lab
                    </h6>
                    <span class="retro-badge" style="background-color: #ffffff; color: var(--retro-dark);">{{ count($data) }} Pasien</span>
                </div>

                <div class="card-body p-3">
                    <!-- FILTER AREA -->
                    <div class="mb-3">
                        <label class="form-label fs--2 fw-bolder text-dark mb-1">Rentang Tanggal</label>
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text text-dark fw-bold" style="background-color: var(--retro-cyan); border: 2px solid var(--retro-dark); border-right: none; border-top-left-radius: 6px; border-bottom-left-radius: 6px;"><i class="fas fa-calendar-alt"></i></span>
                            <input class="form-control datetimepicker border-start-0 retro-input" id="timepicker3" type="text" placeholder="Pilih rentang tanggal..." data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' style="border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;" />
                        </div>

                        <label class="form-label fs--2 fw-bolder text-dark mb-1">Scan / Cari No Reg</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text text-dark fw-bold" style="background-color: var(--retro-cyan); border: 2px solid var(--retro-dark); border-right: none; border-top-left-radius: 6px; border-bottom-left-radius: 6px;"><i class="fas fa-qrcode"></i></span>
                            <input type="text" name="no_reg" class="form-control border-start-0 retro-input" id="no_reg" placeholder="Scan barcode / ketik No Reg..." onkeydown="search(this)" autofocus style="border-top-left-radius: 0 !important; border-bottom-left-radius: 0 !important;">
                        </div>
                    </div>

                    <hr class="my-3 border-dark" style="border-width: 2px;">

                    <!-- LIST PASIEN / REGISTRASI -->
                    <div class="patient-list-container">
                        @forelse ($data as $datas)
                        <div class="patient-card remove-class shadow-none button-pilih-registrasi p-2.5" data-code="{{ $datas->registrasi_id }}">
                            <div class="card-body p-1">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="mb-0 fw-bolder text-dark fs--1">{{ $datas->master_patient_name }}</h6>
                                    <span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark); font-size: 0.65rem;">
                                        {{ $datas->no_registrasi }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center fs--2 text-dark fw-bold">
                                    <span><i class="fas fa-clock me-1 text-dark"></i>{{ $datas->d_reg_order_lab_date }}</span>
                                    <span class="text-dark fw-bolder">{{ $datas->total_pemeriksaan }} Pemeriksaan <i class="fas fa-chevron-right ms-1"></i></span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-dark fw-bold">
                            <i class="fas fa-inbox fa-2x mb-2 text-dark"></i>
                            <p class="fs--1 mb-0">Tidak ada antrean registrasi lab</p>
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
            <div class="retro-card text-center py-5">
                <div class="card-body">
                    <div class="mb-3">
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-1x" style="color: var(--retro-yellow);"></i>
                            <i class="fas fa-file-medical fa-stack-1x text-dark"></i>
                        </span>
                    </div>
                    <h5 class="text-dark fw-bolder">Pilih Pasien Lab</h5>
                    <p class="text-dark fs--1 mb-0 mx-auto fw-bold opacity-75" style="max-width: 400px;">Klik salah satu pasien dari antrean di sebelah kiri atau scan Barcode untuk memproses hasil laboratorium.</p>
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
        <div class="modal-content retro-card border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close" style="border: 2px solid var(--retro-dark); border-radius: 50%; padding: 5px; box-shadow: 2px 2px 0px var(--retro-dark); background-color: var(--retro-yellow);"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
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
    // Event listener untuk klik antrean registrasi pasien lab di sebelah kiri
    $(document).on("click", ".button-pilih-registrasi", function(e) {
        e.preventDefault();

        // Mengatur status aktif pada kartu pasien
        $('.patient-card').removeClass('active-patient');
        $(this).addClass('active-patient');

        var registrasiId = $(this).data("code");

        $('#menu-detail-result').html(
            '<div class="retro-card py-5 text-center">' +
            '<div class="card-body">' +
            '<div class="spinner-border text-dark my-3" role="status" style="width: 2.5rem; height: 2.5rem;"><span class="visually-hidden">Loading...</span></div>' +
            '<p class="text-dark fw-bold fs--1 mb-0">Memuat daftar pemeriksaan & parameter lab...</p>' +
            '</div>' +
            '</div>'
        );

        $.ajax({
            url: "{{ route('menu_lab_proses_result_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": registrasiId, // Mengirim ID Registrasi
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-detail-result').html(data);
        }).fail(function() {
            $('#menu-detail-result').html(
                '<div class="alert alert-danger shadow-sm border-2 border-dark" role="alert" style="border-radius: 8px;">' +
                '<i class="fas fa-exclamation-triangle me-2"></i> Gagal memuat data pemeriksaan. Silakan coba lagi.' +
                '</div>'
            );
        });
    });

    // Event listener untuk menyimpan hasil pemeriksaan lab
    $(document).on("click", "#button-simpan-proses-result", function(e) {
        e.preventDefault();
        var data = $("#form-result-pasien").serialize();

        Swal.fire({
            title: "Simpan Hasil Lab?",
            text: "Pastikan seluruh parameter data hasil telah sesuai!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#c1ff72",
            cancelButtonColor: "#ffa6c9",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            reverseButtons: true
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
