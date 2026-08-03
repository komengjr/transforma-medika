@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />

<style>
    /* ==========================================
         * RADIOLOGY & X-RAY THEME CUSTOM CSS
         * ========================================== */
    :root {
        --rad-dark-bg: #0f172a;
        --rad-card-bg: #1e293b;
        --rad-accent-cyan: #38bdf8;
        --rad-accent-blue: #2563eb;
        --rad-glow-cyan: rgba(56, 189, 248, 0.35);
        --rad-glow-active: rgba(14, 165, 233, 0.6);
    }

    /* Hero Header Radiologi */
    .rad-hero-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0369a1 100%);
        border: 1px solid rgba(56, 189, 248, 0.2);
        border-radius: 12px;
        color: #ffffff;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.4);
        position: relative;
        overflow: hidden;
    }

    .rad-hero-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, var(--rad-glow-cyan) 0%, transparent 70%);
        pointer-events: none;
    }

    /* Card Frame General */
    .rad-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }

    .rad-card-header {
        background: linear-gradient(90deg, #0f172a 0%, #1e293b 100%);
        color: #38bdf8;
        font-weight: 700;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        padding: 12px 18px;
        border-bottom: 2px solid #0284c7;
    }

    /* Scan Input Styling */
    .rad-scan-input {
        border: 2px solid #cbd5e1;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .rad-scan-input:focus {
        border-color: #38bdf8;
        box-shadow: 0 0 10px var(--rad-glow-cyan);
    }

    .rad-scan-icon {
        background: #0f172a;
        color: #38bdf8;
        border: 2px solid #0f172a;
    }

    /* List Item Handling (Kartu Pasien) */
    .rad-patient-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #64748b;
        border-radius: 8px;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
    }

    .rad-patient-card:hover {
        transform: translateY(-2px);
        border-color: #38bdf8;
        border-left-color: #0284c7;
        box-shadow: 0 6px 15px rgba(2, 132, 199, 0.15);
        background: #f0f9ff;
    }

    /* State ketika item terpilih (Active) */
    .rad-patient-card.active-handling {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        color: #ffffff !important;
        border: 1px solid #38bdf8 !important;
        border-left: 5px solid #38bdf8 !important;
        box-shadow: 0 0 15px var(--rad-glow-active) !important;
    }

    .rad-patient-card.active-handling .patient-name {
        color: #38bdf8 !important;
    }

    .rad-patient-card.active-handling .reg-code {
        color: #f1f5f9 !important;
    }

    .rad-patient-card.active-handling .badge-status {
        background-color: rgba(56, 189, 248, 0.2) !important;
        color: #38bdf8 !important;
        border: 1px solid #38bdf8;
    }

    /* Loading Skeleton / Spinner X-Ray Style */
    .rad-loader-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 50px 20px;
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .rad-spinner {
        width: 3rem;
        height: 3rem;
        color: #0284c7;
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
                        <img src="{{ asset('img/rad.png') }}" alt="Radiology Logo" class="img-fluid" width="40" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-info bg-opacity-20 text-cyan px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.7rem; color: #fffdfc;">
                                <i class="fas fa-radiation me-1"></i> MEDICAL SUITE v2.4
                            </span>
                        </div>
                        <h4 class="fw-bold mb-0 text-white" style="font-size: 1.3rem;">
                            Welcome to {{ Env('APP_LABEL')}} <span style="color: #38bdf8;">Management System</span>
                        </h4>
                        <p class="text-white-50 mb-0 small" style="font-size: 0.75rem;">Manajemen & Monitoring Antrean Registrasi Radiologi</p>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <span class="badge bg-dark border border-info px-3 py-2 rounded-3 text-info" style="font-size: 0.78rem;">
                        <i class="fas fa-radiation fa-spin me-1"></i> RADIOLOGY HANDLING
                    </span>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- MAIN CONTENT LAYOUT -->
<div class="row g-3">
    <!-- SIDEBAR: DAFTAR PASIEN -->
    <div class="col-lg-4">
        <div class="sticky-sidebar">
            <div class="rad-card">
                <div class="rad-card-header d-flex align-items-center justify-content-between">
                    <span class="mb-0 fs-0">
                        <i class="fas fa-list-ul me-2"></i>Daftar Antrean Handling
                    </span>
                    <span class="badge bg-info text-dark fw-bold rounded-pill">{{ count($data) }} Pasien</span>
                </div>
                <div class="card-body p-3 bg-slate-50">
                    <!-- Input Barcode Scanner -->
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-semibold mb-1">Scan QR / Barcode Pasien</label>
                        <div class="input-group shadow-sm">
                            <span class="input-group-text rad-scan-icon"><i class="fas fa-qrcode"></i></span>
                            <input type="text" name="nik" class="form-control form-control-md rad-scan-input bg-white" id="nik" placeholder="Arahkan scanner ke sini..." autofocus>
                        </div>
                    </div>

                    <hr class="my-2 border-secondary opacity-25">

                    <!-- Scrollable List Pasien -->
                    <div class="patient-list-container pe-1" style="max-height: 65vh; overflow-y: auto;">
                        @forelse ($data as $datas)
                        <div class="mb-2">
                            <div class="rad-patient-card p-2 px-3 remove-class"
                                id="button-handling-pasien-radiologi"
                                data-code="{{ $datas->d_reg_order_rad_code }}">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="patient-name fw-bold text-dark mb-0 fs--1">{{ $datas->master_patient_name }}</h6>
                                    <span class="badge badge-status bg-light text-secondary border fs--2">Antrean</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-1">
                                    <span class="text-muted fs--2">No. Reg:</span>
                                    <strong class="reg-code text-primary fs--1">{{ $datas->d_reg_order_code }}</strong>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-folder-open fa-2x mb-2 opacity-50"></i>
                            <p class="small mb-0">Belum ada antrean radiologi hari ini.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN DISPLAY: DETAIL HANDLING -->
    <div class="col-lg-8">
        <div id="menu-detail-handling">
            <div class="rad-card p-5 text-center">
                <div class="py-4">
                    <i class="fas fa-x-ray text-cyan fa-4x mb-3 opacity-50" style="color: #0284c7;"></i>
                    <h5 class="fw-bold text-secondary">Pilih Pasien Radiologi</h5>
                    <p class="text-muted small mb-0" style="max-width: 400px; margin: 0 auto;">
                        Silakan klik salah satu pasien pada antrean di sebelah kiri atau scan barcode pasien untuk memproses data radiologi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODAL FULLSIZE RADIOLOGI -->
<div class="modal fade" id="modal-radiologi-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 96%;">
        <div class="modal-content rad-modal border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-radiologi-full"></div>
        </div>
    </div>
</div>

<!-- MODAL XL RADIOLOGI -->
<div class="modal fade" id="modal-radiologi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content rad-modal border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-radiologi"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>

<script>
    $(document).on("click", "#button-handling-pasien-radiologi", function(e) {
        e.preventDefault();
        var code = $(this).data("code");

        // Toggle Class Active dengan Efek X-Ray Glow
        $(".remove-class").removeClass("active-handling");
        $(this).addClass("active-handling");

        // Tampilkan Custom Loader bertema Radiologi
        $('#menu-detail-handling').html(
            '<div class="rad-loader-container shadow-sm">' +
            '<div class="spinner-border rad-spinner mb-3" role="status"></div>' +
            '<h6 class="fw-bold text-dark mb-1">Memuat Data Radiologi...</h6>' +
            '<p class="text-muted small mb-0">Mohon tunggu sebentar, sistem sedang mengambil berkas pemeriksaan.</p>' +
            '</div>'
        );

        $.ajax({
            url: "{{ route('menu_radiologi_handling_pasien') }}",
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
                '<div class="alert alert-danger border-0 rounded-3 shadow-sm p-4 text-center">' +
                '<i class="fas fa-exclamation-triangle fa-2x mb-2"></i>' +
                '<h6>Gagal Memuat Data</h6>' +
                '<p class="mb-0 small">Terjadi kesalahan saat mengambil data pemeriksaan radiologi.</p>' +
                '</div>'
            );
        });
    });

    $(document).on("click", "#button-order-layanan-dokter", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var reg = $(this).data("reg");

        $('#menu-order-layanan-dokter').html(
            '<div class="text-center my-4 py-3"><div class="spinner-border text-info" role="status"></div><p class="small text-muted mt-2">Memuat layanan dokter...</p></div>'
        );

        $.ajax({
            url: "{{ route('data_registrasi_poliklinik_handling_order_layanan') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "reg": reg,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-order-layanan-dokter').html(data);
        }).fail(function() {
            $('#menu-order-layanan-dokter').html('<div class="alert alert-danger p-2 small">Gagal memuat order layanan.</div>');
        });
    });
</script>
@endsection
