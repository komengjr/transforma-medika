@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
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

    .ent-card>.card-header,
    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.07) !important;
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

    /* Badges & Chips */
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

    .code-chip {
        font-family: 'JetBrains Mono', monospace;
        background-color: rgba(79, 70, 229, 0.1);
        color: #4338ca;
        border: 1px solid rgba(79, 70, 229, 0.25);
        padding: 2px 8px;
        border-radius: 7px;
        font-weight: 700;
        font-size: 0.72rem;
        display: inline-block;
    }

    [data-bs-theme="dark"] .code-chip,
    .dark .code-chip {
        background-color: rgba(129, 140, 248, 0.16);
        color: #a5b4fc;
        border-color: rgba(129, 140, 248, 0.32);
    }

    /* Form Controls & Input Groups */
    .ent-field-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
        display: block;
    }

    .ent-input,
    .form-control {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .ent-input:focus,
    .form-control:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .ent-input-group .input-group-text {
        background-color: rgba(79, 70, 229, 0.09) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-right: none !important;
        border-radius: 10px 0 0 10px !important;
        color: var(--ent-indigo) !important;
        min-width: 38px;
        justify-content: center;
    }

    [data-bs-theme="dark"] .ent-input-group .input-group-text,
    .dark .ent-input-group .input-group-text {
        color: #a5b4fc !important;
    }

    .ent-input-group .form-control {
        border-left: none !important;
        border-radius: 0 10px 10px 0 !important;
    }

    /* Patient Queue Cards */
    .patient-card {
        transition: all 0.16s ease;
        cursor: pointer;
        border: 1px solid var(--ent-grid-border) !important;
        border-left: 4px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        margin-bottom: 10px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
    }

    .patient-card:hover {
        transform: translateY(-1px);
        border-color: rgba(79, 70, 229, 0.5) !important;
        border-left-color: var(--ent-indigo) !important;
        background-color: rgba(79, 70, 229, 0.05);
        box-shadow: 0 6px 16px -4px rgba(79, 70, 229, 0.18);
    }

    .patient-card.active-patient {
        border-color: var(--ent-indigo) !important;
        border-left: 4px solid var(--ent-indigo) !important;
        background-color: rgba(79, 70, 229, 0.11) !important;
        box-shadow: 0 8px 20px -6px rgba(79, 70, 229, 0.25);
    }

    /* Scrollable Patient List */
    .patient-list-container {
        max-height: 520px;
        overflow-y: auto;
        padding-right: 4px;
    }

    .patient-list-container::-webkit-scrollbar {
        width: 6px;
    }

    .patient-list-container::-webkit-scrollbar-track {
        background: transparent;
    }

    .patient-list-container::-webkit-scrollbar-thumb {
        background: rgba(99, 102, 241, 0.35);
        border-radius: 9999px;
    }

    .patient-list-container::-webkit-scrollbar-thumb:hover {
        background: var(--ent-indigo);
    }

    /* Empty State & Modal Adaptive */
    .empty-result-state {
        border: 1px dashed var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        padding: 3.5rem 1.5rem;
        text-align: center;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.06);
    }

    .empty-icon-wrap {
        width: 68px;
        height: 68px;
        border-radius: 18px;
        background: rgba(79, 70, 229, 0.1);
        border: 1px solid var(--ent-grid-border);
        color: var(--ent-indigo);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.65rem;
    }

    [data-bs-theme="dark"] .empty-icon-wrap,
    .dark .empty-icon-wrap {
        color: #a5b4fc;
    }

    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color);
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<!-- HERO HEADER BANNER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <!-- Brand & App Label -->
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/dashboard.png') }}" alt="Logo" class="img-fluid" width="40" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-flask me-1"></i> {{ env('APP_LABEL', 'HIS') }} SYSTEM
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Laboratorium Klinis</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-white" style="letter-spacing: -0.02em;">
                                Proses Result Entry
                            </h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Input dan verifikasi parameter hasil pemeriksaan laboratorium pasien.</p>
                        </div>
                    </div>

                    <!-- Date Indicator Pill -->
                    <div class="col-lg-4 text-lg-end">
                        <div class="ent-glass-pill px-3 py-2 d-inline-flex align-items-center gap-2">
                            <i class="fas fa-calendar-check text-info"></i>
                            <span class="fw-semibold" style="font-size: 0.86rem;">{{ date('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CONTENT MAIN GRID -->
<div class="row g-3 g-md-4">
    <!-- KIRI: FILTER & DAFTAR PASIEN -->
    <div class="col-lg-4">
        <div class="sticky-sidebar">
            <div class="card ent-card">
                <div class="ent-card-header py-3 px-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="fas fa-list-alt text-primary"></i>
                        <span>Antrean Pasien Lab</span>
                    </h6>
                    <span class="code-chip">{{ count($data) }} Pasien</span>
                </div>

                <div class="card-body p-3">
                    <!-- FILTER AREA -->
                    <div class="mb-3">
                        <label for="timepicker3" class="ent-field-label">Rentang Tanggal</label>
                        <div class="input-group ent-input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            <input class="form-control datetimepicker ent-input" id="timepicker3" type="text" placeholder="Pilih rentang tanggal..." data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' />
                        </div>

                        <label for="no_reg" class="ent-field-label">Scan / Cari No Reg</label>
                        <div class="input-group ent-input-group">
                            <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                            <input type="text" name="no_reg" class="form-control ent-input" id="no_reg" placeholder="Scan barcode / ketik No Reg..." onkeydown="if(typeof search === 'function') search(this)" autofocus autocomplete="off" style="font-family: 'JetBrains Mono', monospace;">
                        </div>
                    </div>

                    <hr class="my-3" style="border-color: var(--ent-grid-border); opacity: 1;">

                    <!-- LIST PASIEN / REGISTRASI -->
                    <div class="patient-list-container">
                        @forelse ($data as $datas)
                            <div class="patient-card remove-class button-pilih-registrasi p-2" data-code="{{ $datas->registrasi_id }}">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                    <h6 class="mb-0 fw-bold small">{{ $datas->master_patient_name }}</h6>
                                    <span class="code-chip flex-shrink-0">{{ $datas->no_registrasi }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center small opacity-75 fw-semibold" style="font-size: 0.74rem;">
                                    <span style="font-family: 'JetBrains Mono', monospace;">
                                        <i class="far fa-clock me-1 text-primary"></i>{{ $datas->d_reg_order_lab_date }}
                                    </span>
                                    <span class="fw-bold text-primary">
                                        {{ $datas->total_pemeriksaan }} Pemeriksaan <i class="fas fa-chevron-right ms-1"></i>
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 opacity-75">
                                <i class="fas fa-inbox fa-2x mb-2 text-primary"></i>
                                <p class="small fw-semibold mb-0">Tidak ada antrean registrasi lab</p>
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
            <div class="empty-result-state">
                <div class="mb-3">
                    <div class="empty-icon-wrap">
                        <i class="fas fa-file-medical"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-2">Pilih Pasien Lab</h5>
                <p class="small opacity-75 mb-0 mx-auto" style="max-width: 420px;">
                    Klik salah satu pasien dari antrean di sebelah kiri atau scan Barcode untuk memproses hasil laboratorium.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODALS -->
<div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close" style="width: 32px; height: 32px; background-color: var(--ent-solid-bg); color: var(--ent-solid-text); border: 1px solid var(--ent-grid-border);">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close" style="width: 32px; height: 32px; background-color: var(--ent-solid-bg); color: var(--ent-solid-text); border: 1px solid var(--ent-grid-border);">
                    <i class="fas fa-times"></i>
                </button>
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
    let activeResultDetailAjax = null;

    // Event listener untuk klik antrean registrasi pasien lab di sebelah kiri
    $(document).on("click", ".button-pilih-registrasi", function(e) {
        e.preventDefault();

        $('.patient-card').removeClass('active-patient');
        $(this).addClass('active-patient');

        var registrasiId = $(this).data("code");

        if (activeResultDetailAjax && activeResultDetailAjax.readyState !== 4) {
            activeResultDetailAjax.abort();
        }

        $('#menu-detail-result').html(`
            <div class="card ent-card py-5 text-center">
                <div class="card-body">
                    <div class="spinner-border text-primary my-3" role="status" style="width: 2.5rem; height: 2.5rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="opacity-75 fw-semibold small mb-0">Memuat daftar pemeriksaan &amp; parameter lab...</p>
                </div>
            </div>
        `);

        activeResultDetailAjax = $.ajax({
            url: "{{ route('menu_lab_proses_result_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": registrasiId,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-detail-result').html(data);
        }).fail(function(xhr, status) {
            if (status === 'abort') return;
            $('#menu-detail-result').html(`
                <div class="alert alert-danger rounded-3" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> Gagal memuat data pemeriksaan. Silakan coba lagi.
                </div>
            `);
        }).always(function() {
            activeResultDetailAjax = null;
        });
    });

    // Event listener untuk menyimpan hasil pemeriksaan lab
    $(document).on("click", "#button-simpan-proses-result", function(e) {
        e.preventDefault();
        var btn = $(this);
        if (btn.prop('disabled')) return;
        var data = $("#form-result-pasien").serialize();

        Swal.fire({
            title: "Simpan Hasil Lab?",
            text: "Pastikan seluruh parameter data hasil telah sesuai!",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#059669",
            cancelButtonColor: "#e11d48",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                btn.prop('disabled', true);
                $.ajax({
                    url: "{{ route('menu_lab_proses_result_detail_proses_save') }}",
                    type: "POST",
                    cache: false,
                    data: data,
                    dataType: 'html',
                }).done(function(response) {
                    Swal.fire({
                        title: "Tersimpan!",
                        text: "Data hasil laboratorium berhasil disimpan.",
                        icon: "success"
                    });
                    $('#menu-detail-result').html(response);
                }).fail(function() {
                    btn.prop('disabled', false);
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
