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

    .specimen-chip {
        font-family: 'JetBrains Mono', monospace;
        background-color: rgba(79, 70, 229, 0.1);
        color: #4338ca;
        border: 1px solid rgba(79, 70, 229, 0.25);
        padding: 2px 8px;
        border-radius: 7px;
        font-weight: 700;
        font-size: 0.7rem;
        display: inline-block;
    }

    [data-bs-theme="dark"] .specimen-chip,
    .dark .specimen-chip {
        background-color: rgba(129, 140, 248, 0.16);
        color: #a5b4fc;
        border-color: rgba(129, 140, 248, 0.32);
    }

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

    .ent-field-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 6px;
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
        min-height: 40px;
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
        min-width: 42px;
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

    .scan-input-group .form-control {
        min-height: 44px !important;
        font-family: 'JetBrains Mono', monospace !important;
        font-size: 0.88rem !important;
    }

    .specimen-item-card {
        transition: all 0.16s ease;
        cursor: pointer;
        border: 1px solid var(--ent-grid-border) !important;
        border-left: 4px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
    }

    .specimen-item-card:hover {
        border-color: rgba(79, 70, 229, 0.5) !important;
        border-left-color: var(--ent-indigo) !important;
        background-color: rgba(79, 70, 229, 0.05);
    }

    .specimen-list-container {
        max-height: 360px;
        overflow-y: auto;
        padding-right: 4px;
    }

    .ready-pill {
        background-color: rgba(16, 185, 129, 0.12);
        border: 1px solid rgba(16, 185, 129, 0.35);
        color: #059669;
        border-radius: 9999px;
        padding: 3px 10px;
        font-size: 0.7rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    [data-bs-theme="dark"] .ready-pill,
    .dark .ready-pill {
        color: #34d399;
    }

    .pulse-indicator {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.6);
        animation: ent-pulse 1.8s infinite;
    }

    @keyframes ent-pulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.6);
        }

        70% {
            transform: scale(1);
            box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
        }

        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
        }
    }

    .empty-specimen-state {
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
            <div class="card-body p-3 p-md-3 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/verif.png') }}" alt="Logo" class="img-fluid" width="40" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-vials me-1"></i> {{ env('APP_LABEL', 'HIS') }} SYSTEM
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Laboratorium Klinis</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-white" style="letter-spacing: -0.02em;">
                                Laboratorium Specimen Collection
                            </h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Pemindaian barcode registrasi dan verifikasi pengambilan spesimen laboratorium.</p>
                        </div>
                    </div>

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

<!-- MAIN TWO-COLUMN LAYOUT -->
<div class="row g-3">
    <!-- LEFT COLUMN: SCANNER & FILTER PANEL -->
    <div class="col-lg-4">
        <div class="sticky-sidebar">
            <div class="card ent-card">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                            <i class="fas fa-microscope text-primary"></i>
                            <span>Specimen Collection</span>
                        </h6>
                        <small class="opacity-75" style="font-size: 0.7rem;" id="specimenFilterInfo">
                            Hari Ini: {{ $default_today ?? date('d/m/Y') }} ({{ count($data) }} data)
                        </small>
                    </div>
                    <span class="ready-pill">
                        <span class="pulse-indicator"></span> Ready
                    </span>
                </div>

                <div class="card-body p-3">
                    <!-- Form Pencarian: Ketik No. Reg & Range Tanggal -> Klik Cari -->
                    <form id="formSearchSpecimenCollection" class="mb-3">
                        <div class="mb-3">
                            <label for="no_reg" class="ent-field-label">Scan Barcode / No. Registrasi</label>
                            <div class="input-group ent-input-group scan-input-group">
                                <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                <input type="text"
                                    name="no_reg"
                                    class="form-control ent-input fw-bold"
                                    id="no_reg"
                                    placeholder="Ketik / scan No. Registrasi..."
                                    onkeydown="search(this)"
                                    autofocus
                                    autocomplete="off">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="timepicker3" class="ent-field-label">Range Tanggal</label>
                            <div class="input-group ent-input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                <input class="form-control datetimepicker ent-input"
                                    name="range_tanggal"
                                    id="timepicker3"
                                    type="text"
                                    placeholder="Pilih rentang tanggal..."
                                    data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' />
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-8">
                                <button type="submit" class="btn ent-btn ent-btn-primary w-100 py-2" id="btnSearchSpecimen">
                                    <i class="fas fa-search me-1"></i> Cari
                                </button>
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn ent-btn btn-outline-secondary w-100 py-2" id="btnResetSpecimenToday" title="Tampilkan Data Hari Ini">
                                    <i class="fas fa-calendar-day me-1"></i> Hari Ini
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr class="my-3" style="border-color: var(--ent-grid-border); opacity: 1;">

                    <!-- Daftar Spesimen Sesuai Filter -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="ent-field-label mb-0">Daftar Antrean Spesimen</span>
                        <span class="specimen-chip" id="specimenTotalBadge">{{ count($data) }} Data</span>
                    </div>

                    <div class="d-flex flex-column gap-2 specimen-list-container" id="specimenQueueList">
                        @include('application.laboratorium.speciment-collection.specimen-collection-list', ['data' => $data])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: DETAILED SPECIMEN CONTENT -->
    <div class="col-lg-8">
        <div id="menu-detail-specimen">
            <div class="empty-specimen-state">
                <div class="mb-3">
                    <div class="empty-icon-wrap">
                        <i class="fas fa-vial"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-2">Belum Ada Spesimen Dipilih</h5>
                <p class="small opacity-75 mb-0 mx-auto" style="max-width: 420px;">
                    Silakan cari atau scan barcode spesimen pasien menggunakan kolom input di sebelah kiri untuk menampilkan detail pemeriksaan laboratorium.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODALS -->
<div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 95%;">
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
    <div class="modal-dialog modal-dialog-centered modal-xl">
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
    let activeSpecimenSearchAjax = null;
    let activeSpecimenListAjax = null;

    $(document).ready(function() {
        if ($('#example').length) {
            new DataTable('#example', {
                responsive: true
            });
        }
    });

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    const loadingCard = `
        <div class="card ent-card">
            <div class="card-body text-center py-5">
                <div class="spinner-border text-primary mb-3" role="status" style="width: 2.5rem; height: 2.5rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h6 class="fw-bold mb-1">Mencari Data Spesimen...</h6>
                <p class="opacity-75 small mb-0">Sistem sedang memproses data registrasi</p>
            </div>
        </div>
    `;

    function muatDaftarSpesimen(resetHariIni = false) {
        const noReg = resetHariIni ? '' : ($('#no_reg').val() || '').trim();
        const rangeTgl = resetHariIni ? '' : ($('#timepicker3').val() || '').trim();

        if (activeSpecimenListAjax && activeSpecimenListAjax.readyState !== 4) {
            activeSpecimenListAjax.abort();
        }

        $('#specimenQueueList').html(`
            <div class="text-center py-3">
                <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                <span class="small fw-semibold">Memuat daftar spesimen...</span>
            </div>
        `);

        activeSpecimenListAjax = $.ajax({
            url: "{{ route('data_specimen_collection_lab_search') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "no_registrasi": noReg,
                "range_tanggal": rangeTgl
            },
            dataType: 'json'
        }).done(function(res) {
            if (res && res.status) {
                $('#specimenQueueList').html(res.html);
                $('#specimenTotalBadge').text(`${res.total} Data`);

                if (resetHariIni || (!noReg && !rangeTgl)) {
                    $('#specimenFilterInfo').text(`Hari Ini: {{ $default_today ?? date('d/m/Y') }} (${res.total} data)`);
                } else {
                    const info = [noReg ? `Reg: ${noReg}` : '', rangeTgl ? `Tgl: ${rangeTgl}` : ''].filter(Boolean).join(' • ');
                    $('#specimenFilterInfo').text(`${info} (${res.total} data)`);
                }
            }
        }).fail(function(xhr, status) {
            if (status === 'abort') return;
            $('#specimenQueueList').html(`
                <div class="alert alert-danger rounded-3 py-2 small mb-0">
                    <i class="fas fa-exclamation-triangle me-1"></i> Gagal memuat daftar spesimen.
                </div>
            `);
        }).always(function() {
            activeSpecimenListAjax = null;
        });
    }

    function cariDetailSpesimenByCode(codeValue) {
        const cleanCode = (codeValue || '').trim();
        if (!cleanCode) {
            Toast.fire({
                icon: "error",
                title: "No. Registrasi / Scan Tidak Boleh Kosong"
            });
            return;
        }

        if (activeSpecimenSearchAjax && activeSpecimenSearchAjax.readyState !== 4) {
            activeSpecimenSearchAjax.abort();
        }

        $('#menu-detail-specimen').html(loadingCard);

        activeSpecimenSearchAjax = $.ajax({
            url: "{{ route('data_specimen_collection_lab_cari_data') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": cleanCode,
            },
            dataType: 'html',
        }).done(function(data) {
            const inputEl = document.getElementById('no_reg');
            if (inputEl) {
                inputEl.focus();
            }

            if (data.trim() === 'false') {
                resetToEmptyState();
                Toast.fire({
                    icon: "warning",
                    title: "Data Tidak Ditemukan"
                });
            } else if (data.trim() === 'done') {
                resetToEmptyState();
                Toast.fire({
                    icon: "info",
                    title: "Data Sudah di Handling"
                });
            } else if (data.trim() === 'not') {
                resetToEmptyState();
                Toast.fire({
                    icon: "warning",
                    title: "Pasien Belum Melakukan Handling"
                });
            } else {
                $('#menu-detail-specimen').html(data);
                Toast.fire({
                    icon: "success",
                    title: "Data Ditemukan"
                });
            }
        }).fail(function(xhr, status) {
            if (status === 'abort') return;
            resetToEmptyState();
            Toast.fire({
                icon: "error",
                title: "Gagal terhubung ke server. Silakan coba lagi."
            });
        }).always(function() {
            activeSpecimenSearchAjax = null;
        });
    }

    // Pencarian daftar & detail saat form / tombol "Cari" diklik
    $('#formSearchSpecimenCollection').on('submit', function(e) {
        e.preventDefault();
        muatDaftarSpesimen(false);
        const noReg = ($('#no_reg').val() || '').trim();
        if (noReg !== '') {
            cariDetailSpesimenByCode(noReg);
        }
    });

    // Kembali ke data hari ini saja
    $('#btnResetSpecimenToday').on('click', function() {
        $('#no_reg').val('');
        const fpInstance = document.getElementById('timepicker3')?._flatpickr;
        if (fpInstance) {
            fpInstance.clear();
        } else {
            $('#timepicker3').val('');
        }
        resetToEmptyState();
        muatDaftarSpesimen(true);
    });

    // Klik item antrean spesimen untuk isi No. Reg & buka detail
    $(document).on("click", ".specimen-item-card", function() {
        const regNo = $(this).data("reg");
        const labCode = $(this).data("code");
        const targetCode = regNo || labCode;
        if (targetCode) {
            $('#no_reg').val(targetCode);
            cariDetailSpesimenByCode(targetCode);
        }
    });

    function search(ele) {
        if (event.key === 'Enter') {
            event.preventDefault();
            var code = document.getElementById('no_reg').value;
            muatDaftarSpesimen(false);
            cariDetailSpesimenByCode(code);
        }
    }

    function resetToEmptyState() {
        $('#menu-detail-specimen').html(`
            <div class="empty-specimen-state">
                <div class="mb-3">
                    <div class="empty-icon-wrap">
                        <i class="fas fa-vial"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-2">Belum Ada Spesimen Dipilih</h5>
                <p class="small opacity-75 mb-0 mx-auto" style="max-width: 420px;">
                    Silakan cari atau scan barcode spesimen pasien menggunakan kolom input di sebelah kiri untuk menampilkan detail pemeriksaan laboratorium.
                </p>
            </div>
        `);
    }

    $(document).on("click", "#button-simpan-proses-specimen-collection", function(e) {
        e.preventDefault();
        var btn = $(this);
        if (btn.prop('disabled')) return;
        var code = btn.data("code");

        Swal.fire({
            title: "Konfirmasi Simpan",
            text: "Apakah Anda yakin ingin memproses spesimen collection ini?",
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
                $('#menu-proses-specimen-collection').html(`
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary mb-2" role="status"></div>
                        <p class="opacity-75 fw-semibold small mb-0">Menyimpan data spesimen...</p>
                    </div>
                `);

                $.ajax({
                    url: "{{ route('data_specimen_collection_lab_proses_simpan_fix') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code
                    },
                    dataType: 'html',
                }).done(function() {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Proses simpan spesimen berhasil dilakukan.",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
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
