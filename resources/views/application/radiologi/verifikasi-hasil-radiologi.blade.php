@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
        --ent-action-bg: #eef2ff;
        --ent-action-color: #3730a3;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
        --ent-action-bg: #1e293b;
        --ent-action-color: #a5b4fc;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
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
        background-color: rgba(79, 70, 229, 0.07) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 14px 18px;
    }

    .ent-table-surface {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
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
        background: radial-gradient(circle, rgba(244, 63, 94, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    /* Badges */
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

    /* Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
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

    .ent-btn-reset {
        background-color: rgba(100, 116, 139, 0.12);
        border: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color);
    }

    .ent-btn-reset:hover {
        background-color: rgba(100, 116, 139, 0.22);
        color: var(--bs-body-color);
    }

    /* Form Controls */
    .ent-field-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 4px;
        display: block;
    }

    .ent-input,
    .form-control,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.8rem !important;
        min-height: 36px;
        transition: all 0.2s ease;
    }

    .ent-input:focus,
    .form-control:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    /* Select2 Adaptive & Solid Dropdown Styling */
    .select2-container--bootstrap-5 {
        width: 100% !important;
    }

    .select2-container--bootstrap-5 .select2-selection {
        min-height: 36px !important;
        border-radius: 10px !important;
        background-color: var(--ent-solid-bg) !important;
        border: 1px solid var(--ent-grid-border) !important;
        display: flex !important;
        align-items: center !important;
        padding-left: 10px !important;
        padding-right: 28px !important;
        box-shadow: none !important;
        opacity: 1 !important;
        transition: all 0.2s ease;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: var(--ent-indigo) !important;
        background-color: var(--ent-solid-bg) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        color: var(--ent-solid-text) !important;
        padding-left: 0 !important;
        line-height: 1.35 !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        box-shadow: 0 14px 28px -6px rgba(15, 23, 42, 0.24) !important;
        overflow: hidden;
        opacity: 1 !important;
        z-index: 1080 !important;
        font-size: 0.8rem;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown {
        background-color: var(--ent-solid-bg) !important;
        padding: 8px !important;
        border-bottom: 1px solid var(--ent-grid-border);
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        padding: 6px 10px !important;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field:focus {
        border-color: var(--ent-indigo) !important;
        outline: none;
        box-shadow: 0 0 0 2.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-results__options {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        max-height: 240px;
        overflow-y: auto;
    }

    .select2-container--bootstrap-5 .select2-results__option {
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        padding: 7px 12px !important;
        line-height: 1.35 !important;
    }

    .select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected] {
        background-color: var(--ent-indigo) !important;
        color: #ffffff !important;
    }

    .select2-container--bootstrap-5 .select2-results__option[aria-selected="true"] {
        background-color: rgba(79, 70, 229, 0.14) !important;
        color: var(--ent-indigo) !important;
    }

    /* Table Styling */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
        font-size: 0.82rem;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: var(--bs-body-color) !important;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        padding: 13px 12px;
        letter-spacing: 0.04em;
    }

    .table-custom thead th:first-child {
        border-left: none !important;
    }

    .table-custom thead th:last-child {
        border-right: none !important;
        padding-right: 18px !important;
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
        height: 1px;
    }

    .table-custom tbody tr:hover,
    .table-custom tbody tr:hover td:not(.action-cell-full) {
        background-color: rgba(79, 70, 229, 0.07) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 11px 12px;
        vertical-align: middle;
        font-size: 0.83rem;
        background-color: transparent;
    }

    .table-custom tbody td:first-child {
        border-left: none !important;
    }

    .table-custom tbody td:last-child {
        border-right: none !important;
        padding-right: 18px !important;
    }

    /* SOLID FULL-CELL ACTION BUTTON STYLING (NON-TRANSPARENT) */
    .table-custom td.action-cell-full {
        padding: 0 !important;
        height: 100%;
        vertical-align: stretch !important;
        background-color: var(--ent-action-bg) !important;
    }

    .table-custom td.action-cell-full>.dropdown,
    .table-custom td.action-cell-full>.btn-group {
        display: flex !important;
        width: 100% !important;
        height: 100% !important;
        background-color: var(--ent-action-bg);
    }

    .table-custom td.action-cell-full .dropdown>.btn,
    .table-custom td.action-cell-full .btn-group>.btn,
    .table-custom td.action-cell-full>.btn {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 100% !important;
        height: 100% !important;
        min-height: 56px;
        border-radius: 0 !important;
        margin: 0 !important;
        border: none !important;
        background-color: var(--ent-action-bg) !important;
        color: var(--ent-action-color) !important;
        opacity: 1 !important;
        box-shadow: inset 0 0 0 1px rgba(79, 70, 229, 0.16);
        transition: background-color 0.15s ease, color 0.15s ease;
    }

    .table-custom td.action-cell-full .dropdown>.btn:hover,
    .table-custom td.action-cell-full .dropdown>.btn:focus,
    .table-custom td.action-cell-full .dropdown>.btn.show,
    .table-custom td.action-cell-full .btn-group>.btn:hover,
    .table-custom td.action-cell-full>.btn:hover,
    .table-custom tbody tr:hover td.action-cell-full .dropdown>.btn {
        background-color: var(--ent-action-hover-bg) !important;
        color: var(--ent-action-hover-color) !important;
        opacity: 1 !important;
    }

    /* DataTables Top & Bottom Controls Padding */
    #table-verifikasi-rad_wrapper>.row:first-child,
    #table-verifikasi-rad_wrapper .dt-layout-row:first-child {
        padding: 16px 20px 12px 20px;
        margin: 0 !important;
    }

    #table-verifikasi-rad_wrapper>.row:last-child,
    #table-verifikasi-rad_wrapper .dt-layout-row:last-child {
        padding: 14px 20px 18px 20px;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
    }

    #table-verifikasi-rad_wrapper .dt-layout-table {
        margin: 0 !important;
    }

    #table-verifikasi-rad_wrapper .dataTables_filter input,
    #table-verifikasi-rad_wrapper .dt-search input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        padding: 6px 12px !important;
        font-size: 0.82rem !important;
        height: 36px !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    #table-verifikasi-rad_wrapper .dataTables_filter input:focus,
    #table-verifikasi-rad_wrapper .dt-search input:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    #table-verifikasi-rad_wrapper .dataTables_length select,
    #table-verifikasi-rad_wrapper .dt-length select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        padding: 4px 28px 4px 10px !important;
        height: 34px !important;
        font-size: 0.82rem !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    .page-item.active .page-link {
        background-color: var(--ent-indigo) !important;
        border-color: var(--ent-indigo) !important;
        color: #ffffff !important;
        border-radius: 8px;
    }

    .page-link {
        color: var(--bs-body-color);
        border-radius: 8px;
        margin: 0 2px;
        border: 1px solid var(--ent-grid-border);
        font-weight: 600;
        font-size: 0.8rem;
    }

    /* Code Chip & Dropdown & Modal */
    .code-chip {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        font-size: 0.72rem;
        padding: 2px 8px;
        border-radius: 6px;
        background-color: rgba(79, 70, 229, 0.08);
        border: 1px solid var(--ent-grid-border);
        display: inline-block;
        color: var(--bs-body-color);
    }

    .code-chip-cyan {
        background-color: rgba(2, 132, 199, 0.12);
        border-color: rgba(2, 132, 199, 0.35);
        color: #0284c7;
    }

    .ent-dropdown-menu {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.25) !important;
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
<!-- HERO HEADER RADIOLOGI -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/rad.png') }}" alt="Radiology Logo" class="img-fluid" width="40" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(79, 70, 229, 0.25); border: 1px solid rgba(129, 140, 248, 0.45); color: #c7d2fe;">
                                    <i class="fas fa-radiation me-1"></i> v2.4 Medical Suite
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Instalasi Radiologi</span>
                            </div>
                            <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em;color: white;">
                                Dokter: <span style="text-decoration: underline;">Pengisian & Verifikasi Ekspertise</span>
                            </h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Modul Verifikasi & Processing Hasil Pemeriksaan Radiologi</p>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end">
                        <div class="ent-glass-pill px-3 py-2 d-inline-flex align-items-center gap-2">
                            <i class="fas fa-notes-medical text-info"></i>
                            <span class="fw-semibold" style="font-size: 0.86rem;">Radiologi : Ekspertise</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN CARD (FILTER & DATATABLE) -->
<div class="ent-card mb-4">
    <div class="ent-card-header">
        <form id="form-filter-verifikasi" class="row g-2 align-items-end">
            <!-- Tombol Refresh -->
            <div class="col-12 col-sm-auto">
                <button type="button" id="btn-refresh-verifikasi"
                    class="btn btn-sm ent-btn ent-btn-primary px-3 d-flex align-items-center justify-content-center gap-1 w-100"
                    style="height: 36px;" data-bs-toggle="tooltip" title="Refresh Data">
                    <i class="fas fa-redo-alt"></i>
                    <span class="fw-semibold ms-1">Refresh</span>
                </button>
            </div>

            <!-- Tanggal Awal -->
            <div class="col-12 col-sm-6 col-md-4 col-xl">
                <label class="ent-field-label">Tanggal Awal</label>
                <input type="text" class="form-control ent-input datetimepicker" id="verif_tgl_awal" name="tgl_awal" value="{{ date('Y-m-d') }}" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
            </div>

            <!-- Tanggal Akhir -->
            <div class="col-12 col-sm-6 col-md-4 col-xl">
                <label class="ent-field-label">Tanggal Akhir</label>
                <input type="text" class="form-control ent-input datetimepicker" id="verif_tgl_akhir" name="tgl_akhir" value="{{ date('Y-m-d') }}" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
            </div>

            <!-- Cari -->
            <div class="col-12 col-sm-6 col-md-4 col-xl">
                <label class="ent-field-label">Cari...</label>
                <input type="text" class="form-control ent-input" id="verif_cari" name="cari" placeholder="No Reg / Nama / RM">
            </div>

            <!-- Kel. Pelanggan -->
            <div class="col-12 col-sm-6 col-md-4 col-xl">
                <label class="ent-field-label">Kel. Pelanggan</label>
                <select name="penjamin" id="verif_penjamin" class="form-select ent-input select2-rad-verifikasi" data-placeholder="Semua">
                    <option value="Semua">Semua</option>
                    <option value="UMUM">UMUM</option>
                    <option value="PASIEN KLINIS">PASIEN KLINIS</option>
                    <option value="ASURANSI">ASURANSI</option>
                </select>
            </div>

            <!-- Pemeriksaan (X-Ray, USG, dll) -->
            <div class="col-12 col-sm-6 col-md-4 col-xl">
                <label class="ent-field-label">Pemeriksaan</label>
                <select name="pemeriksaan" id="verif_pemeriksaan" class="form-select ent-input select2-rad-verifikasi" data-placeholder="Semua Pemeriksaan">
                    <option value="Semua">Semua Pemeriksaan</option>
                    <option value="X-RAY">X-RAY / Rontgen</option>
                    <option value="USG">USG</option>
                    <option value="CT-SCAN">CT-SCAN</option>
                    <option value="MRI">MRI</option>
                </select>
            </div>

            <!-- Tombol Submit Form -->
            <div class="col-12 col-sm-auto d-grid">
                <button type="submit" class="btn btn-sm ent-btn ent-btn-primary px-3 d-flex align-items-center justify-content-center" style="height: 36px;" title="Cari Data">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="card-body p-0 ent-table-surface">
        <div class="table-responsive pb-3">
            <table id="table-verifikasi-rad" class="table table-hover align-middle table-custom w-100 mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 4%;">#</th>
                        <th class="text-center" style="width: 5%;">No</th>
                        <th style="width: 22%;">Identitas Pasien</th>
                        <th style="width: 12%;">Kategori</th>
                        <th style="width: 14%;">Tanggal Reg</th>
                        <th style="width: 16%;">Dokter / Petugas</th>
                        <th class="text-center" style="width: 12%;">Status Pembayaran</th>
                        <th class="text-center" style="width: 15%;">Status Pem.</th>
                    </tr>
                </thead>
                <tbody id="tbody-verifikasi"></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- Modals Section -->
<div class="modal fade" id="modal-radiologi-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalRadiologiFullLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content modal-ent-content border-0 shadow-lg">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn btn-sm ent-btn ent-btn-reset d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close" style="width: 32px; height: 32px; border-radius: 50%; padding: 0;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="menu-radiologi-full" class="p-3 p-md-4"></div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let verifikasiTable;
    let activeVerifDetailAjax = null;

    function initSelect2VerifikasiRad(selector, modalSelector) {
        if (!(window.jQuery && $.fn.select2)) return;
        const $parent = modalSelector && $(modalSelector).length ? $(modalSelector) : $(document.body);

        $(selector).each(function() {
            const $el = $(this);
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.select2('destroy');
            }
            const placeholderText = $el.data('placeholder') || $el.find('option:first').text() || 'Pilih';
            const hasEmptyOption = $el.find('option[value=""]').length > 0;

            $el.select2({
                theme: 'bootstrap-5',
                width: '100%',
                dropdownParent: $parent,
                placeholder: placeholderText,
                allowClear: hasEmptyOption,
                language: {
                    noResults: function() {
                        return 'Data tidak ditemukan';
                    },
                    searching: function() {
                        return 'Mencari...';
                    }
                }
            });
        });
    }

    function syncFlatpickrVerifDate(selector, dateStr) {
        document.querySelectorAll(selector).forEach(function(input) {
            if (input._flatpickr) {
                input._flatpickr.setDate(dateStr, false);
            } else {
                input.value = dateStr;
            }
        });
    }

    function renderPaymentBadgeVerif(statusPembayaran) {
        if (statusPembayaran === 'LUNAS' || statusPembayaran === 'SEBAGIAN' || statusPembayaran === 'ASURANSI') {
            return '<span class="ent-badge" style="background: rgba(5, 150, 105, 0.14); color: #059669; border: 1px solid rgba(5, 150, 105, 0.35);"><i class="fas fa-check-circle me-1"></i>Lunas</span>';
        }
        return '<span class="ent-badge" style="background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.35);"><i class="fas fa-times-circle me-1"></i>Belum Lunas</span>';
    }

    function renderStatusBadgeVerif(statusPemeriksaan) {
        if (statusPemeriksaan === 'SELESAI') {
            return '<span class="ent-badge" style="background: rgba(5, 150, 105, 0.14); color: #059669; border: 1px solid rgba(5, 150, 105, 0.35);"><i class="fas fa-check-double me-1"></i>Selesai / Menunggu Verif</span>';
        }
        if (statusPemeriksaan === 'PROSES') {
            return '<span class="ent-badge" style="background: rgba(217, 119, 6, 0.14); color: #d97706; border: 1px solid rgba(217, 119, 6, 0.35);"><i class="fas fa-spinner fa-spin me-1"></i>Diproses Petugas</span>';
        }
        return '<span class="ent-badge" style="background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.35);"><i class="fas fa-hourglass-half me-1"></i>Antrean</span>';
    }

    // Fungsi Global Load Data Table
    function loadDataVerifikasi() {
        var formData = $('#form-filter-verifikasi').serialize();

        if (verifikasiTable) {
            $('#tbody-verifikasi').html(`
                <tr>
                    <td colspan="8" class="text-center py-4 fw-semibold">
                        <i class="fas fa-spinner fa-spin me-2 text-primary"></i> Mencari data...
                    </td>
                </tr>
            `);
        }

        $.ajax({
            url: "{{ route('radiologi.get_data_verifikasi') }}",
            type: "GET",
            data: formData,
            success: function(response) {
                const rows = (response && Array.isArray(response.data)) ? response.data : [];
                if (verifikasiTable) {
                    verifikasiTable.clear().rows.add(rows).draw();
                }
            },
            error: function() {
                if (verifikasiTable) {
                    verifikasiTable.clear().draw();
                }
                $('#tbody-verifikasi').html('<tr><td colspan="8" class="text-center text-danger fw-semibold py-4">Gagal mengambil data dari server. Periksa koneksi atau route.</td></tr>');
            }
        });
    }

    $(document).ready(function() {
        initSelect2VerifikasiRad('.select2-rad-verifikasi');

        verifikasiTable = $('#table-verifikasi-rad').DataTable({
            data: [],
            paging: true,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            searching: true,
            ordering: false,
            info: true,
            responsive: true,
            autoWidth: false,
            columns: [{
                    data: null,
                    className: 'action-cell-full text-center align-middle',
                    render: function(data, type, row) {
                        const code = row.registrasi_id ?? '';
                        const reg = row.order_rad_code ?? '';
                        return `
                            <div class="dropdown">
                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Aksi">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu ent-dropdown-menu py-2">
                                    <li>
                                        <a class="dropdown-item fw-semibold py-2 button-verifikasi-hasil" href="#" data-bs-toggle="modal" data-bs-target="#modal-radiologi-full" data-code="${code}" data-reg="${reg}">
                                            <i class="fas fa-pen-alt me-2 text-primary"></i> Isi Ekspertise
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        `;
                    }
                },
                {
                    data: null,
                    className: 'text-center fw-bold',
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'master_patient_name',
                    render: function(data, type, row) {
                        return `
                            <div class="fw-bold patient-name">${data ?? '-'}</div>
                            <div class="mt-1 d-flex flex-wrap gap-1">
                                <span class="code-chip" title="No Registrasi">${row.no_registrasi ?? '-'}</span>
                                <span class="code-chip code-chip-cyan" title="Order Code">${row.order_rad_code ?? '-'}</span>
                            </div>
                        `;
                    }
                },
                {
                    data: 'nama_penjamin',
                    render: function(data) {
                        return `<span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: var(--bs-body-color); border: 1px solid var(--ent-grid-border);">${data ?? '-'}</span>`;
                    }
                },
                {
                    data: 'tanggal_registrasi_formatted',
                    className: 'text-nowrap fw-semibold',
                    render: function(data) {
                        return `<span style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;"><i class="far fa-clock me-1 text-primary opacity-75"></i>${data ?? '-'}</span>`;
                    }
                },
                {
                    data: 'nama_dokter_petugas',
                    render: function(data) {
                        return `<span class="ent-badge" style="background: rgba(2, 132, 199, 0.12); color: var(--bs-body-color); border: 1px solid var(--ent-grid-border);"><i class="fas fa-user-md me-1 text-primary"></i>${data ?? '-'}</span>`;
                    }
                },
                {
                    data: 'status_pembayaran',
                    className: 'text-center',
                    render: function(data) {
                        return renderPaymentBadgeVerif(data);
                    }
                },
                {
                    data: 'status_pemeriksaan',
                    className: 'text-center',
                    render: function(data) {
                        return renderStatusBadgeVerif(data);
                    }
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "🔍 Cari data...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 - 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                emptyTable: `
                    <div class="text-center py-4 fw-semibold opacity-75">
                        <i class="fas fa-box-open fa-2x mb-2 opacity-50"></i><br>
                        Tidak ada data verifikasi hasil radiologi.
                    </div>
                `,
                zeroRecords: `
                    <div class="text-center py-4 fw-semibold opacity-75">
                        <i class="fas fa-search fa-2x mb-2 opacity-50"></i><br>
                        Data tidak cocok dengan pencarian.
                    </div>
                `,
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                }
            }
        });

        // Load data otomatis saat pertama kali dibuka
        loadDataVerifikasi();

        // Trigger load data saat form di-submit
        $('#form-filter-verifikasi').on('submit', function(e) {
            e.preventDefault();
            loadDataVerifikasi();
        });

        // Tombol Refresh
        $('#btn-refresh-verifikasi').on('click', function(e) {
            e.preventDefault();
            const today = new Date().toISOString().split('T')[0];
            syncFlatpickrVerifDate('#verif_tgl_awal, #verif_tgl_akhir', today);
            $('#verif_cari').val('');
            $('#verif_penjamin').val('Semua').trigger('change.select2');
            $('#verif_pemeriksaan').val('Semua').trigger('change.select2');
            loadDataVerifikasi();
        });

        // Bersihkan handler & konten modal saat ditutup agar tidak menumpuk
        const modalEl = document.getElementById('modal-radiologi-full');
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function() {
                if (activeVerifDetailAjax && activeVerifDetailAjax.readyState !== 4) {
                    activeVerifDetailAjax.abort();
                    activeVerifDetailAjax = null;
                }
                $(document).off('.radVerifModal');
                $('#menu-radiologi-full select.select2-hidden-accessible').select2('destroy');
                $('#menu-radiologi-full').empty();
            });
        }
    });

    function menu_radiologi_verifikasi_handling_pasien(code, reg) {
        if (activeVerifDetailAjax && activeVerifDetailAjax.readyState !== 4) {
            activeVerifDetailAjax.abort();
        }
        $(document).off('.radVerifModal');

        $('#menu-radiologi-full').html(`
            <div class="text-center my-5 py-4">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h6 class="mt-3 fw-bold">Memuat Detail Verifikasi Ekspertise Radiologi...</h6>
                <p class="small mb-0 fw-semibold opacity-75">Mohon tunggu sebentar, data pemeriksaan sedang disiapkan.</p>
            </div>
        `);

        activeVerifDetailAjax = $.ajax({
            url: "{{ route('menu_radiologi_verifikasi_handling_pasien') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "reg": reg,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-radiologi-full').html(data);
            initSelect2VerifikasiRad('#menu-radiologi-full select', '#modal-radiologi-full');
        }).fail(function(xhr, status) {
            if (status === 'abort') return;
            $('#menu-radiologi-full').html(`
                <div class="alert alert-danger rounded-3 text-center my-4 p-4 fw-semibold" role="alert">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <h6>Gagal Memuat Form Ekspertise</h6>
                    <p class="mb-0 small">Terjadi kesalahan sistem. Silakan coba beberapa saat lagi.</p>
                </div>
            `);
        }).always(function() {
            activeVerifDetailAjax = null;
        });
    }

    // Event Handler: Hanya lewat Action Button Isi Ekspertise
    $(document).on("click", ".button-verifikasi-hasil", function(e) {
        e.preventDefault();
        e.stopPropagation();
        var code = $(this).data("code");
        var reg = $(this).data("reg");
        menu_radiologi_verifikasi_handling_pasien(code, reg);
    });
</script>
@endsection
