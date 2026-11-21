@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE HEALTHCARE UI STYLES
       (ADAPTIVE LIGHT & DARK MODE BOOTSTRAP 5)
       ========================================= */
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-indigo-soft: rgba(79, 70, 229, 0.12);
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-emerald: #059669;
        --ent-sky: #0284c7;
        --ent-amber: #d97706;
        --ent-rose: #e11d48;
        --ent-solid-bg: #ffffff;
        --ent-solid-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Adaptive Enterprise Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 14px 18px;
    }

    /* Hero Banner */
    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 16px;
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.22);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 340px;
        height: 340px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    /* Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        cursor: pointer;
        font-size: 0.8rem;
    }

    .ent-btn:hover {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .ent-btn-primary:hover {
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    .ent-btn-warning {
        background-color: rgba(245, 158, 11, 0.16);
        border: 1px solid rgba(245, 158, 11, 0.45);
        color: #d97706;
    }

    .ent-btn-warning:hover {
        background-color: #f59e0b;
        border-color: #f59e0b;
        color: #ffffff;
    }

    /* Metric Boxes */
    .ent-metric-success {
        background-color: rgba(5, 150, 105, 0.1);
        border: 1px solid rgba(5, 150, 105, 0.32);
        border-radius: 14px;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .ent-metric-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px -6px rgba(5, 150, 105, 0.2);
    }

    .ent-metric-danger {
        background-color: rgba(225, 29, 72, 0.1);
        border: 1px solid rgba(225, 29, 72, 0.32);
        border-radius: 14px;
        transition: transform 0.18s ease, box-shadow 0.18s ease;
    }

    .ent-metric-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px -6px rgba(225, 29, 72, 0.2);
    }

    /* List Group Items */
    .ent-list-item {
        border-bottom: 1px solid var(--ent-grid-border) !important;
        background-color: transparent !important;
        transition: background-color 0.15s ease;
    }

    .ent-list-item:last-child {
        border-bottom: none !important;
    }

    .ent-list-item:hover {
        background-color: rgba(79, 70, 229, 0.05) !important;
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    /* Modal Adaptive Enterprise */
    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        color: var(--bs-body-color);
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<!-- BANNER HEADER ATAS -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">

                    <!-- Brand & App Label -->
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="ent-glass-pill p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/dashboard.png') }}" alt="Logo" class="img-fluid" width="40" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(245, 158, 11, 0.2); border: 1px solid rgba(245, 158, 11, 0.45); color: #fcd34d;">
                                    <i class="fas fa-bolt me-1"></i> LIVE SYSTEM
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">v2.4 Medical Suite</span>
                            </div>
                            <h4 class="text-white fw-bold mb-0" style="letter-spacing: -0.02em;">
                                Welcome to {{ Env('APP_LABEL')}} <span class="fw-normal" style="color: #cbd5e1;">Management System</span>
                            </h4>
                        </div>
                    </div>

                    <!-- Module Badge / Quick Nav -->
                    <div class="col-lg-5 text-lg-end">
                        <div class="ent-glass-pill d-inline-flex align-items-center px-3 py-2">
                            <h6 class="text-warning fw-bold mb-0" style="font-size: 0.92rem;">
                                <i class="fas fa-user-plus me-1"></i> Registrasi Pasien
                            </h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- SECTION KONTEN UTAMA & QUICK METRICS -->
<div class="row g-3 mb-4">

    <!-- KOLOM KIRI: Stat & Quick Actions -->
    <div class="col-lg-7">
        <div class="ent-card h-100">

            <!-- Hero Greeting Card -->
            <div class="p-4 position-relative overflow-hidden" style="background-color: rgba(79, 70, 229, 0.04); border-bottom: 1px solid var(--ent-grid-border);">
                <img class="position-absolute d-none d-md-block opacity-25"
                    src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}"
                    alt="chart" style="right: -10px; top: -10px; width: 140px; pointer-events: none;" />

                <div class="position-relative" style="z-index: 2;">
                    <h5 class="fw-bold mb-1">
                        Selamat Datang, <span class="text-primary">{{ Auth::user()->fullname }}</span>!
                    </h5>
                    <p class="opacity-75 mb-3" style="font-size: 0.82rem;">
                        Kelola antrian dan kelengkapan data pasien hari ini secara real-time.
                    </p>

                    <!-- Metrics Stat Boxes -->
                    <div class="row g-2">
                        <!-- Order Selesai -->
                        <div class="col-6">
                            <div class="p-3 ent-metric-success position-relative overflow-hidden">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-success fw-bold text-uppercase d-block mb-1" style="font-size: 0.68rem; letter-spacing: 0.04em;">Order Selesai</span>
                                        <h3 class="text-success fw-bold mb-0" style="font-size: 1.5rem; font-family: 'JetBrains Mono', monospace;">
                                            {{$total - $reject}} <span class="fw-semibold text-success opacity-75" style="font-size: 0.8rem; font-family: 'Plus Jakarta Sans', sans-serif;">Order</span>
                                        </h3>
                                    </div>
                                    <div class="p-2 bg-success text-white rounded-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-check-circle fs-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Batal -->
                        <div class="col-6">
                            <div class="p-3 ent-metric-danger position-relative overflow-hidden">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-danger fw-bold text-uppercase d-block mb-1" style="font-size: 0.68rem; letter-spacing: 0.04em;">Order Batal</span>
                                        <h3 class="text-danger fw-bold mb-0" style="font-size: 1.5rem; font-family: 'JetBrains Mono', monospace;">
                                            {{$reject}} <span class="fw-semibold text-danger opacity-75" style="font-size: 0.8rem; font-family: 'Plus Jakarta Sans', sans-serif;">Order</span>
                                        </h3>
                                    </div>
                                    <div class="p-2 bg-danger text-white rounded-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-times-circle fs-5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Quick Action List Group -->
            <div class="card-body p-0">
                <div class="list-group list-group-flush">

                    <!-- Item 1: Registrasi -->
                    <div class="list-group-item p-3 ent-list-item d-flex align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3);">
                                <i class="fas fa-user-plus fs-2"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold" style="font-size: 0.88rem;">{{$total}} Order Pasien Hari Ini</h6>
                                <span class="opacity-75" style="font-size: 0.75rem;">Siap untuk alur pendaftaran pasien baru</span>
                            </div>
                        </div>
                        <button type="button" class="btn ent-btn ent-btn-primary btn-sm rounded-pill px-3 shadow-sm fw-semibold" id="button-registrasi-pasien" style="font-size: 0.78rem;">
                            <i class="fas fa-registered me-1"></i> Registrasi
                        </button>
                    </div>

                    <!-- Item 2: Panggil Antrian -->
                    <div class="list-group-item p-3 ent-list-item d-flex align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: rgba(217, 119, 6, 0.14); color: #f59e0b; border: 1px solid rgba(217, 119, 6, 0.3);">
                                <i class="fas fa-bullhorn fs-2"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold" style="font-size: 0.88rem;">7 Orders Belum Bayar</h6>
                                <span class="opacity-75" style="font-size: 0.75rem;">Menunggu instruksi panggilan antrian kasir</span>
                            </div>
                        </div>
                        <button type="button" class="btn ent-btn ent-btn-warning btn-sm rounded-pill px-3 shadow-sm fw-semibold"
                            data-bs-toggle="modal" data-bs-target="#modal-registrasi-xl" id="button-call-antrian" style="font-size: 0.78rem;">
                            <i class="fas fa-satellite-dish me-1"></i> Panggil Antrian
                        </button>
                    </div>

                    <!-- Item 3: Tutup Pendaftaran -->
                    <div class="list-group-item p-3 ent-list-item d-flex align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 44px; height: 44px; background-color: rgba(225, 29, 72, 0.14); color: #f43f5e; border: 1px solid rgba(225, 29, 72, 0.3);">
                                <i class="fas fa-power-off fs-2"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold" style="font-size: 0.88rem;">{{$total}} Orders Semua Pasien</h6>
                                <span class="opacity-75" style="font-size: 0.75rem;">Kunci &amp; selesaikan registrasi hari ini</span>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-danger ent-btn btn-sm rounded-pill px-3 fw-semibold" style="font-size: 0.78rem;">
                            <i class="fas fa-lock me-1"></i> Tutup Pendaftaran
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- KOLOM KANAN: Activity Log Card -->
    <div class="col-lg-5">
        <div class="ent-card h-100">
            <!-- Log Header -->
            <div class="ent-card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="p-2 rounded-3 me-2 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; background-color: rgba(2, 132, 199, 0.14); color: #0ea5e9; border: 1px solid rgba(2, 132, 199, 0.3);">
                        <i class="fas fa-stream"></i>
                    </div>
                    <h6 class="fw-bold mb-0" style="font-size: 0.92rem;">Activity Log</h6>
                </div>
                <a class="btn btn-xs btn-outline-primary ent-btn rounded-pill fw-semibold px-3 py-1" href="#" style="font-size: 0.72rem;">View All</a>
            </div>

            <!-- Log Content List -->
            <div class="card-body p-3 overflow-auto" style="max-height: 380px;">
                <div class="timeline-simple">
                    @foreach ($data as $datas)
                    <div class="d-flex align-items-start mb-3 pb-2" style="border-bottom: 1px solid var(--ent-grid-border);">
                        <div class="avatar-container me-3 flex-shrink-0">
                            <div class="rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; background-color: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid var(--ent-grid-border);">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1" style="font-size: 0.8rem;">
                            <p class="mb-1 lh-sm">
                                <strong class="fw-bold">{{$datas->master_patient_name}}</strong>
                                terdaftar pada <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2">{{ $datas->t_pasien_cat_name }}</span>
                            </p>
                            <div class="d-flex align-items-center opacity-75" style="font-size: 0.72rem;">
                                <i class="fas fa-hashtag me-1"></i><strong class="me-2" style="font-family: 'JetBrains Mono', monospace;">{{ $datas->d_reg_order_code }}</strong>
                                <i class="fas fa-clock me-1 ms-auto"></i> {{ $datas->created_at }}
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Dummy Event Item -->
                    <div class="d-flex align-items-start pt-1">
                        <div class="avatar-container me-3 flex-shrink-0">
                            <div class="rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; background-color: rgba(2, 132, 199, 0.12); color: #0ea5e9; border: 1px solid var(--ent-grid-border);">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1" style="font-size: 0.8rem;">
                            <p class="mb-1 lh-sm">
                                <strong>Massachusetts Institute of Technology</strong> invited <strong>Anthony Hopkin</strong> to an event
                            </p>
                            <span class="opacity-75 d-block" style="font-size: 0.72rem;"><i class="fas fa-clock me-1"></i> October 28, 12:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-registrasi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" id="button-close-registrasi" style="z-index: 10;">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <div id="menu-registrasi"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-registrasi-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-registrasi-xl"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>
<script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>

<script>
    if (document.querySelector('#example')) {
        new DataTable('#example', {
            responsive: true
        });
    }
</script>
<script>
   $(document).on("click", "#button-registrasi-pasien", function(e) {
        e.preventDefault();

        @php
            $routeAkses = request()->route('akses');
            $routeId = request()->route('id');
            $segments = request()->segments();
            $aksesParam = $routeAkses ?? ($segments[0] ?? 'default');
            $idParam = $routeId ?? ($segments[1] ?? '0');
            $registrasiV2Url = route('registrasi_pasien_v2', ['akses' => $aksesParam, 'id' => $idParam]);
        @endphp

        const targetUrl = "{{ $registrasiV2Url }}";

        Swal.fire({
            title: "Buka Registrasi Pasien v2?",
            text: "Anda akan diarahkan ke halaman Registrasi Pasien v2.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#4f46e5",
            cancelButtonColor: "#64748b",
            confirmButtonText: "Ya, Lanjutkan",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = targetUrl;
            }
        });
    });
    $(document).on("click", "#button-create-data-pasien", function(e) {
        e.preventDefault();
        $('#menu-registrasi-pasien').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_create') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 1
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-registrasi-pasien').html(data);
        }).fail(function() {
            $('#menu-registrasi-pasien').html('eror');
        });
    });
    $(document).on("click", "#button-scan-data-pasien", function(e) {
        e.preventDefault();
        $('#menu-registrasi-pasien').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_reader_passport') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 1
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-registrasi-pasien').html(data);
        }).fail(function() {
            $('#menu-registrasi-pasien').html('eror');
        });
    });
    $(document).on("click", "#button-cari-data-pasien", function(e) {
        e.preventDefault();
        var data = $("#form-registrasi-pasien").serialize();
        var pencarian = document.getElementById('option_nama').value;
        if (pencarian == "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Pencarian Tidak Boleh Kosong",
            });
        } else {
            $('#menu-registrasi-pasien').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('registrasi_pasien_cari_data_pasien') }}",
                type: "POST",
                cache: false,
                data: data,
                dataType: 'html',
            }).done(function(data) {
                if (data == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Pilih dulu Optional Pencarian",
                    });
                } else {
                    $('#menu-registrasi-pasien').html(data);
                }
            }).fail(function() {
                $('#menu-registrasi-pasien').html('eror');
            });
        }
    });
    $(document).on("click", "#button-save-create-pasien-baru", function(e) {
        e.preventDefault();

        var data = $("#form-create-pasien-baru").serialize();
        var nama = $("#nama_lengkap").val();
        var nik = $("#nik").val();
        var jk = $("#jenis_kelamin").val();
        var tgl = $("#tgl_lahir").val();
        var agama = $("#agama").val();
        var no_hp = $("#no_hp").val();

        if (nama === '' || nik === '' || jk === '' || tgl === '' || agama === '' || no_hp === '') {
            Swal.fire({
                title: 'Peringatan!',
                text: 'Pastikan seluruh data wajib sudah terisi!',
                icon: 'warning',
                confirmButtonColor: '#4f46e5',
                confirmButtonText: 'Mengerti'
            });
            return;
        }

        var $btn = $(this);
        var btnOriginalText = $btn.html();
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...');

        $.ajax({
            url: "{{ route('registrasi_pasien_create_save') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'json',
        }).done(function(response) {
            $btn.prop('disabled', false).html(btnOriginalText);

            if (response.status === 'success') {
                Swal.fire({
                    title: 'Berhasil!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonColor: '#4f46e5',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed || result.dismiss) {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: response.message,
                    icon: response.icon || 'warning',
                    confirmButtonColor: '#e11d48',
                    confirmButtonText: 'Tutup'
                });
            }
        }).fail(function(xhr) {
            $btn.prop('disabled', false).html(btnOriginalText);

            var errorMsg = 'Terjadi kesalahan sistem saat menyimpan data.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }

            Swal.fire({
                title: 'Error!',
                text: errorMsg,
                icon: 'error',
                confirmButtonColor: '#e11d48',
                confirmButtonText: 'Tutup'
            });
        });
    });
    $(document).on("click", "#button-pilih-data-pasien", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-registrasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_pilih_data_pasien') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-registrasi').html(data);
        }).fail(function() {
            $('#menu-registrasi').html('eror');
        });
    });
    // FASILITAS LAYANAN
    $(document).on("click", "#button-pilih-kebutuhan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-falcon-success",
                cancelButton: "btn btn-falcon-danger"
            },
            buttonsStyling: true
        });
        swalWithBootstrapButtons.fire({
            title: "Apakah kamu Yakin ?",
            text: "Pastikan Data Pasien Sudah Benar!",
            icon: "warning",
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            cancelButtonText: "No, Batal!",
            confirmButtonText: "Yes, Yakin!",
        }).then((result) => {
            if (result.isConfirmed) {
                $('#menu-kebutuhan-registrasi').html(
                    '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                );
                $.ajax({
                    url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code
                    },
                    dataType: 'html',
                }).done(function(data) {
                    $('#menu-kebutuhan-registrasi').html(data);
                    document.getElementById("menu-fasilitas-layanan").style.display = "block";
                    document.getElementById("button-pilih-kebutuhan").style.display = "none";
                    document.getElementById("pill-profile-tab").click();
                }).fail(function() {
                    $('#menu-kebutuhan-registrasi').html('eror');
                });
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Your imaginary file is safe :)",
                    icon: "error"
                });
            }
        });
    });
    $(document).on("click", "#button-pilih-dokter-poliklinik", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var tgl = document.getElementById("tanggal_periksa").value;
        $('#menu-pilihan-dokter-poli').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan_pilih_dokter') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "tgl": tgl,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-pilihan-dokter-poli').html(data);
        }).fail(function() {
            $('#menu-pilihan-dokter-poli').html('eror');
        });
    });
    $(document).on("click", "#button-fix-print-registrasi-poli", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var date = $(this).data("date");
        var layanan = $(this).data("layanan");
        var no_reg = document.getElementById("no_registrasi").value;
        var no_rm = document.getElementById("no_rm").value;
        var cat = document.getElementById("kategori").value;
        var data_link = document.getElementById("link_penunjang").value;
        var data_penunjang = document.getElementById("data_penunjang").value;

        $.ajax({
            url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_poli') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "date": date,
                "layanan": layanan,
                "no_reg": no_reg,
                "no_rm": no_rm,
                "cat": cat,
                "data_link": data_link,
                "data_penunjang": data_penunjang
            },
            dataType: 'html',
        }).done(function(data) {
            document.getElementById("menu-fasilitas-layanan").disabled = true;
            document.getElementById("menu-cetak-data-registrasi").style.display = "block";
            document.getElementById("pill-contact-tab").click();
            document.getElementById("button-pilih-end-proses").click();
        }).fail(function() {});
    });
    $(document).on("click", "#button-pilih-end-proses", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var id = $(this).data("id");
        $('#menu-invoice-registrasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_pilih_data_pasien_end_proses') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "id": id,
            },
            dataType: 'html',
        }).done(function(data) {
            document.getElementById("menu-fasilitas-layanan").style.display = "none";
            document.getElementById("button-close-registrasi").style.display = "none";
            setTimeout(() => {
                $('#menu-invoice-registrasi').html(data);
                Lobibox.notify('success', {
                    pauseDelayOnHover: true,
                    continueDelayOnInactiveTab: true,
                    position: 'top right',
                    icon: 'fas fa-info-circle',
                    msg: 'Berhasil Daftar Registrasi'
                });
            }, 3000);
        }).fail(function() {
            $('#menu-invoice-registrasi').html('eror');
        });
    });
    $(document).on("click", "#button-preview-registrasi-pasien", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-preview-registrasi-pasien').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_pilih_data_pasien_preview_pdf') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
            },
            dataType: 'html',
        }).done(function(data) {
            setTimeout(() => {
                $('#menu-preview-registrasi-pasien').html(
                    '<iframe src="data:application/pdf;base64, ' +
                    data +
                    '" style="width:100%; height:533px;" frameborder="0"></iframe>');
            }, 500);
        }).fail(function() {
            $('#menu-preview-registrasi-pasien').html('eror');
        });
    });
</script>

<script>
    $(document).on("click", "#button-call-antrian", function(e) {
        e.preventDefault();
        $('#menu-registrasi-xl').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_list_que') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 1,
                "ip_client": "{{ $ipClient }}"
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-registrasi-xl').html(data);
        }).fail(function() {
            $('#menu-registrasi-xl').html('eror');
        });
    });
    $(document).on("click", "#button-pilih-call-antrian", function(e) {
        e.preventDefault();
        $('#menu-modal-antrian').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('registrasi_pasien_choose_data_que') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 1
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-modal-antrian').html(data);
        }).fail(function() {
            $('#menu-modal-antrian').html('eror');
        });
    });
</script>
@endsection
