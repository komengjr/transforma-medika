@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<style>
    /* Styling Header & Theme Poliklinik */
    .bg-poliklinik-gradient {
        background: linear-gradient(135deg, #0d9488 0%, #0284c7 100%) !important;
    }

    .text-poliklinik {
        color: #0d9488 !important;
    }

    /* Styling List Patient Card */
    .patient-card-item {
        cursor: pointer;
        transition: all 0.25s ease-in-out;
        border-left: 4px solid #0d9488 !important;
        background-color: #ffffff;
    }

    .patient-card-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.15) !important;
        border-color: #0284c7 !important;
        background-color: #f0fdfa !important;
    }

    .patient-card-item.active-patient {
        background: linear-gradient(135deg, #0d9488 0%, #0284c7 100%) !important;
        color: #ffffff !important;
        border-left: 4px solid #042f2e !important;
        box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3) !important;
    }

    .patient-card-item.active-patient .text-muted,
    .patient-card-item.active-patient .text-dark,
    .patient-card-item.active-patient .text-poliklinik,
    .patient-card-item.active-patient .patient-title {
        color: #ffffff !important;
    }

    .patient-card-item.active-patient .badge-poli {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: #ffffff !important;
    }

    .badge-poli {
        background-color: #ccfbf1;
        color: #0f766e;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<!-- Banner Header -->
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
                            <img src="{{ asset('img/lab.png') }}" alt="Logo" class="img-fluid drop-shadow" width="42" />
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
                                <i class="fas fa-file-alt me-1"></i> Data Poliklinik Handling
                            </h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Main Content Split Area -->
<div class="row g-3">
    <!-- Sidebar Patient List -->
    <div class="col-lg-4">
        <div class="sticky-sidebar">
            <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                <!-- Header Daftar Handling bertema Poliklinik -->
                <div class="card-header bg-poliklinik-gradient text-white py-3 px-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-injury fs-1 me-2"></i>
                        <h5 class="mb-0 text-white fw-bold fs-0">Daftar Antrean Handling</h5>
                    </div>
                    <span class="badge bg-white text-dark rounded-pill px-2 py-1 fs--1 shadow-sm">
                        {{ count($data) }} Pasien
                    </span>
                </div>

                <div class="card-body bg-light p-3">
                    <!-- Search / Scan Input -->
                    <div class="mb-3">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-white border-end-0 text-poliklinik">
                                <i class="fas fa-qrcode"></i>
                            </span>
                            <input type="text" name="nik" class="form-control border-start-0 bg-white" id="nik" placeholder="Scan Barcode / Cari Pasien..." autofocus>
                        </div>
                    </div>

                    <!-- Patients List -->
                    <div class="patient-list-container pe-1" style="max-height: 68vh; overflow-y: auto;">
                        @forelse ($data as $datas)
                        <div class="card border-0 shadow-sm mb-2 patient-card-item button-handling-pasien-poli" data-code="{{ $datas->d_reg_order_code }}">
                            <div class="card-body fs--1 py-2 px-3">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <div class="fw-bold fs-0 patient-title text-dark">{{ $datas->master_patient_name }}</div>
                                    <span class="badge badge-poli rounded-pill fs--2 px-2 py-1">
                                        {{ $datas->m_poli_name }}
                                    </span>
                                </div>
                                <div class="text-muted fs--1">
                                    <div class="mb-1">
                                        <i class="fas fa-hashtag me-1 text-poliklinik"></i>Reg: <strong class="text-poliklinik">{{ $datas->d_reg_order_code }}</strong>
                                    </div>
                                    <div>
                                        <i class="fas fa-user-md me-1 opacity-75"></i>Dokter: <strong class="text-dark">{{ $datas->master_doctor_name }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-info text-center mb-0 border-0 shadow-sm" role="alert">
                            <i class="fas fa-info-circle me-1"></i> Tidak ada data antrean pasien.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Handling Area -->
    <div class="col-lg-8">
        <div id="menu-detail-handling">
            <div class="card shadow-sm border text-center py-5">
                <div class="card-body">
                    <i class="fas fa-user-clock fa-3x text-poliklinik mb-3"></i>
                    <h5 class="text-600">Pilih Pasien dari Daftar</h5>
                    <p class="text-500 mb-0">Klik pada salah satu kartu pasien di sebelah kiri untuk melihat detail penanganan.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- Modals -->
<div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik"></div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Spinner indicator helper
        const loaderHtml = `
            <div class="d-flex justify-content-center align-items-center py-5">
                <div class="spinner-border text-teal" style="color: #0d9488;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>`;

        // DataTables Config
        if ($('#example').length) {
            new DataTable('#example', {
                responsive: true
            });
        }

        // Handling Load Patient Detail
        $(document).on("click", ".button-handling-pasien-poli", function(e) {
            e.preventDefault();
            const $this = $(this);
            const code = $this.data("code");

            $(".button-handling-pasien-poli").removeClass("active-patient");
            $this.addClass("active-patient");

            $('#menu-detail-handling').html(loaderHtml);

            $.ajax({
                url: "{{ route('data_registrasi_poliklinik_handling_detail') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html'
            }).done(function(data) {
                $('#menu-detail-handling').html(data);
            }).fail(function() {
                $('#menu-detail-handling').html(`
                    <div class="alert alert-danger" role="alert">
                        Gagal memuat detail pasien. Silakan coba lagi.
                    </div>
                `);
            });
        });

        // Handling Order Layanan Dokter
        $(document).on("click", "#button-order-layanan-dokter", function(e) {
            e.preventDefault();
            const code = $(this).data("code");
            const reg = $(this).data("reg");

            $('#menu-order-layanan-dokter').html(loaderHtml);

            $.ajax({
                url: "{{ route('data_registrasi_poliklinik_handling_order_layanan') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                    "reg": reg,
                },
                dataType: 'html'
            }).done(function(data) {
                $('#menu-order-layanan-dokter').html(data);
            }).fail(function() {
                $('#menu-order-layanan-dokter').html('<div class="alert alert-danger">Terjadi kesalahan sistem.</div>');
            });
        });

        // Save Diagnosa Umum
        $(document).on("click", "#button-simpan-data-diagnosa-umum", function(e) {
            e.preventDefault();
            const name = $('#data-name').val();
            const desc = $('#data-desc').val();
            const id = $('#code_gigi').val();

            if (!name || !desc) {
                Swal.fire({
                    icon: "error",
                    title: "Peringatan",
                    text: "Harap isi Nama dan Deskripsi Diagnosa terlebih dahulu!"
                });
                return;
            }

            $('#menu-diagnosa-umum').html(loaderHtml);

            $.ajax({
                url: "{{ route('data_registrasi_poliklinik_save_diagnosa') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "name": name,
                    "desc": desc,
                    "id": id,
                },
                dataType: 'html'
            }).done(function(data) {
                $('#data-name').val('');
                $('#data-desc').val('');
                $('#menu-diagnosa-umum').html(data);
            }).fail(function() {
                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: "Gagal menyimpan diagnosa."
                });
            });
        });

        // Save Diagnosa Pasien Poli Final
        $(document).on("click", "#button-save-data-diagnosa-pasien-poli", function(e) {
            e.preventDefault();
            const id = $('#code_gigi').val();

            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Pastikan seluruh data pasien telah diisi dengan benar!",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "Batal",
                confirmButtonText: "Ya, Proses!",
                customClass: {
                    confirmButton: "btn btn-success me-2",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#menu-pasien-poliklinik').html(loaderHtml);

                    $.ajax({
                        url: "{{ route('data_registrasi_poliklinik_save_diagnosa_pasien_poli') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id,
                        },
                        dataType: 'html'
                    }).done(function() {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Pasien berhasil ditangani.",
                            icon: "success"
                        }).then(() => {
                            location.reload();
                        });
                    }).fail(function() {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal",
                            text: "Terjadi kesalahan saat memproses data."
                        });
                    });
                }
            });
        });

        // Load Data Penunjang
        $(document).on("click", "#button-penunjang-poliklinik", function(e) {
            e.preventDefault();
            const id = $('#code_gigi').val();

            $('#menu-poliklinik').html(loaderHtml);

            $.ajax({
                url: "{{ route('data_registrasi_poliklinik_data_penunjang') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                },
                dataType: 'html'
            }).done(function(data) {
                $('#menu-poliklinik').html(data);
            }).fail(function() {
                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: "Gagal memuat data penunjang."
                });
            });
        });
    });
</script>
@endsection
