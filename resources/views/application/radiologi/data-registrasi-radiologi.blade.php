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

    /* Avatar Pasien */
    .patient-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.18), rgba(2, 132, 199, 0.18));
        border: 1px solid rgba(99, 102, 241, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #6366f1;
        font-size: 0.75rem;
        flex-shrink: 0;
    }

    /* =========================================================
       TABLE WITH COLORED GRID BORDERS & SOLID ACTION BUTTON
       ========================================================= */
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

    .table-custom td .btn,
    .table-custom td .btn-sm {
        opacity: 1 !important;
    }

    /* DataTables Top & Bottom Controls Padding */
    #example_wrapper>.row:first-child,
    #example_wrapper .dt-layout-row:first-child {
        padding: 16px 20px 12px 20px;
        margin: 0 !important;
    }

    #example_wrapper>.row:last-child,
    #example_wrapper .dt-layout-row:last-child {
        padding: 14px 20px 18px 20px;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
    }

    #example_wrapper .dt-layout-table {
        margin: 0 !important;
    }

    #example_wrapper .dataTables_filter input,
    #example_wrapper .dt-search input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        padding: 6px 12px !important;
        font-size: 0.82rem !important;
        height: 36px !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    #example_wrapper .dataTables_filter input:focus,
    #example_wrapper .dt-search input:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    #example_wrapper .dataTables_length select,
    #example_wrapper .dt-length select {
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

    /* Soft Badges & Chips */
    .badge-soft-danger {
        background-color: rgba(225, 29, 72, 0.14);
        color: #e11d48;
        border: 1px solid rgba(225, 29, 72, 0.35);
    }

    .badge-soft-warning {
        background-color: rgba(217, 119, 6, 0.14);
        color: #d97706;
        border: 1px solid rgba(217, 119, 6, 0.35);
    }

    .badge-soft-info {
        background-color: rgba(2, 132, 199, 0.14);
        color: #0284c7;
        border: 1px solid rgba(2, 132, 199, 0.35);
    }

    .badge-soft-success {
        background-color: rgba(5, 150, 105, 0.14);
        color: #059669;
        border: 1px solid rgba(5, 150, 105, 0.35);
    }

    .badge-soft-primary {
        background-color: rgba(79, 70, 229, 0.14);
        color: #4f46e5;
        border: 1px solid rgba(79, 70, 229, 0.35);
    }

    .list-pemeriksaan-tag {
        display: inline-block;
        background-color: rgba(79, 70, 229, 0.07);
        color: var(--bs-body-color);
        padding: 2px 8px;
        border-radius: 6px;
        border: 1px solid var(--ent-grid-border);
        font-size: 0.74rem;
        margin: 1px;
        font-weight: 600;
    }

    .code-block {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.8rem;
        font-weight: 700;
    }

    /* Dropdown & Modal Styling */
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
<!-- BREADCRUMB & HERO HEADER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/rad.png') }}" alt="Logo" class="img-fluid" width="40" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(79, 70, 229, 0.25); border: 1px solid rgba(129, 140, 248, 0.45); color: #c7d2fe;">
                                    <i class="fas fa-radiation me-1"></i> v2.4 Medical Suite
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Instalasi Radiologi</span>
                            </div>
                            <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em;color: white;">
                                Welcome to {{ Env('APP_LABEL') }} <span class="fw-normal opacity-75">Management System</span>
                            </h4>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end">
                        <div class="ent-glass-pill px-3 py-2 d-inline-flex align-items-center gap-2">
                            <i class="fas fa-radiation text-info"></i>
                            <span class="fw-semibold" style="font-size: 0.86rem;">Data Registrasi Radiologi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN DATA TABLE CARD -->
<div class="ent-card mb-4">
    <!-- CARD HEADER TOOLBAR & FILTER -->
    <div class="ent-card-header">
        <div class="row align-items-end g-2">

            <!-- TOMBOL UTAMA (Refresh & Mobile Toggle) -->
            <div class="col-12 col-xl-auto d-flex align-items-center justify-content-between gap-2">
                <button class="btn btn-sm ent-btn ent-btn-primary px-3 d-flex align-items-center gap-1" style="height: 36px;"
                    type="button" id="btn-refresh-rad" data-bs-toggle="tooltip" title="Refresh Data Hari Ini">
                    <i class="fas fa-sync-alt"></i>
                    <span class="fw-semibold ms-1">Refresh Data</span>
                </button>

                <button class="btn btn-sm ent-btn ent-btn-reset px-3 d-xl-none d-flex align-items-center gap-1" style="height: 36px;"
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilterMobile" aria-expanded="false" aria-controls="collapseFilterMobile">
                    <i class="fas fa-filter"></i>
                    <span class="fw-semibold">Filter</span>
                    <i class="fas fa-chevron-down ms-1"></i>
                </button>
            </div>

            <!-- CONTAINER DERETAN FILTER -->
            <div class="col-12 col-xl collapse d-xl-block" id="collapseFilterMobile">
                <div class="row g-2 align-items-end mt-2 mt-xl-0 pt-2 pt-xl-0">

                    <!-- Filter Tanggal Awal -->
                    <div class="col-12 col-sm-6 col-md-4 col-xl">
                        <label class="ent-field-label" for="filter_tgl_awal">Tanggal Awal</label>
                        <input type="text" class="form-control ent-input datetimepicker" id="filter_tgl_awal" value="{{ date('Y-m-d') }}" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                    </div>

                    <!-- Filter Tanggal Akhir -->
                    <div class="col-12 col-sm-6 col-md-4 col-xl">
                        <label class="ent-field-label" for="filter_tgl_akhir">Tanggal Akhir</label>
                        <input type="text" class="form-control ent-input datetimepicker" id="filter_tgl_akhir" value="{{ date('Y-m-d') }}" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                    </div>

                    <!-- Filter No Reg / Nama -->
                    <div class="col-12 col-sm-6 col-md-4 col-xl">
                        <label class="ent-field-label" for="filter_search">No Reg / Nama</label>
                        <input type="text" class="form-control ent-input" id="filter_search" placeholder="Cari Reg/Nama...">
                    </div>

                    <!-- Filter Dokter -->
                    <div class="col-12 col-sm-6 col-md-4 col-xl">
                        <label class="ent-field-label" for="filter_dokter">Dokter</label>
                        <select class="form-select ent-input select2-rad-filter" id="filter_dokter" data-placeholder="Semua Dokter">
                            <option value="">Semua Dokter</option>
                        </select>
                    </div>

                    <!-- Filter Kel. Pelanggan / Penjamin -->
                    <div class="col-12 col-sm-6 col-md-4 col-xl">
                        <label class="ent-field-label" for="filter_penjamin">Kel. Pelanggan</label>
                        <select class="form-select ent-input select2-rad-filter" id="filter_penjamin" data-placeholder="Semua Kelompok">
                            <option value="">Semua Kelompok</option>
                            <option value="PASIEN KLINIS">PASIEN KLINIS</option>
                            <option value="UMUM">UMUM / PRIBADI</option>
                            <option value="ASURANSI">ASURANSI</option>
                        </select>
                    </div>

                    <!-- Filter Pemeriksaan -->
                    <div class="col-12 col-sm-6 col-md-4 col-xl">
                        <label class="ent-field-label" for="filter_pemeriksaan">Pemeriksaan</label>
                        <select class="form-select ent-input select2-rad-filter" id="filter_pemeriksaan" data-placeholder="Semua Pemeriksaan">
                            <option value="">Semua Pemeriksaan</option>
                        </select>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- CARD BODY / TABLE -->
    <div class="card-body p-0 ent-table-surface">
        <div class="table-responsive pb-3">
            <table id="example" class="table table-hover table-custom align-middle mb-0" style="width:100%;">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 4%;">#</th>
                        <th class="text-center" style="width: 5%;">No</th>
                        <th style="width: 17%;">No Registrasi</th>
                        <th style="width: 20%;">Nama Pasien</th>
                        <th style="width: 12%;">Tanggal Reg</th>
                        <th style="width: 15%;">Rujukan</th>
                        <th style="width: 16%;">Pemeriksaan</th>
                        <th class="text-center" style="width: 11%;">Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODALS -->
<div class="modal fade" id="modal-radiologi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn btn-sm ent-btn ent-btn-reset d-flex align-items-center justify-content-center" data-bs-dismiss="modal" aria-label="Close" style="width: 32px; height: 32px; border-radius: 50%; padding: 0;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="menu-radiologi" class="p-3 p-md-4"></div>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let radTable;

    function initSelect2Radiologi(selector, modalSelector) {
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

    function syncFlatpickrDate(selector, dateStr) {
        document.querySelectorAll(selector).forEach(function(input) {
            if (input._flatpickr) {
                input._flatpickr.setDate(dateStr, false);
            } else {
                input.value = dateStr;
            }
        });
    }

    function extractCodeFromAction(actionHtml, row) {
        if (row && row.code) return row.code;
        if (row && row.no_registrasi) return row.no_registrasi;
        if (!actionHtml) return '';
        const $tmp = $('<div>').html(actionHtml);
        return $tmp.find('[data-code]').first().data('code') || '';
    }

    $(document).ready(function() {
        // Inisialisasi Select2 untuk Filter
        initSelect2Radiologi('.select2-rad-filter');

        // Inisialisasi DataTable Server-Side
        radTable = $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('data_registrasi_radiologi_table') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.tgl1 = $('#filter_tgl_awal').val();
                    d.tgl2 = $('#filter_tgl_akhir').val();
                    d.search_custom = $('#filter_search').val();
                    d.dokter = $('#filter_dokter').val();
                    d.penjamin = $('#filter_penjamin').val();
                    d.pemeriksaan = $('#filter_pemeriksaan').val();
                }
            },
            columns: [{
                    data: 'action',
                    className: 'action-cell-full text-center align-middle',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        const code = extractCodeFromAction(data, row);
                        const statusText = String(row.status || '').toUpperCase();
                        let btnHandling = '';
                        if (code) {
                            btnHandling = `
                                <li>
                                    <a class="dropdown-item fw-semibold py-2 button-proses-handling-rad" href="#" data-bs-toggle="modal" data-bs-target="#modal-radiologi" data-code="${code}">
                                        <i class="fas fa-x-ray me-2 text-primary"></i> Proses Handling Radiologi
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            `;
                        }
                        return `
                            <div class="dropdown">
                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Aksi">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu ent-dropdown-menu py-2">
                                    ${btnHandling}
                                    <li>
                                        <a class="dropdown-item fw-semibold py-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-radiologi" data-code="${code}">
                                            <i class="fas fa-info-circle me-2 text-info"></i> Detail Radiologi (${statusText || 'DATA'})
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        `;
                    }
                },
                {
                    data: 'no',
                    className: 'text-center fw-bold',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'no_registrasi',
                    orderable: false
                },
                {
                    data: 'nama_pasien',
                    orderable: false
                },
                {
                    data: 'tanggal_reg',
                    orderable: false,
                    className: 'text-nowrap'
                },
                {
                    data: 'rujukan',
                    orderable: false
                },
                {
                    data: 'pemeriksaan',
                    orderable: false
                },
                {
                    data: 'status',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "🔍 Cari data...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                },
                processing: `
                    <div class="custom-loader py-4">
                        <div class="spinner-border text-primary mb-2" style="width: 2.2rem; height: 2.2rem;" role="status"></div>
                        <span class="fw-semibold small d-block">Memuat data radiologi...</span>
                    </div>
                `
            },
            pageLength: 10
        });

        // Trigger pencarian ulang jika input filter diubah
        $('#filter_tgl_awal, #filter_tgl_akhir').on('change', function() {
            radTable.ajax.reload();
        });

        $('#filter_dokter, #filter_penjamin, #filter_pemeriksaan').on('change', function() {
            radTable.ajax.reload();
        });

        $('#filter_search').on('keyup', function() {
            radTable.ajax.reload();
        });

        // Tombol Refresh Data
        $('#btn-refresh-rad').on('click', function(e) {
            e.preventDefault();
            const today = new Date().toISOString().split('T')[0];
            syncFlatpickrDate('#filter_tgl_awal, #filter_tgl_akhir', today);
            $('#filter_search').val('');
            $('#filter_dokter').val('').trigger('change.select2');
            $('#filter_penjamin').val('').trigger('change.select2');
            $('#filter_pemeriksaan').val('').trigger('change.select2');
            radTable.ajax.reload();
        });
    });

    // LOADING SPINNER HTML HELPER
    const loadingSpinner = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 mb-0 fw-semibold">Memuat data pemeriksaan...</p>
        </div>
    `;

    // Event Handler untuk Button Proses Handling Radiologi
    $(document).on("click", ".button-proses-handling-rad", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-radiologi').html(loadingSpinner);

        $.ajax({
            url: "{{ route('data_registrasi_radiologi_handling') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-radiologi').html(data);
            initSelect2Radiologi('#menu-radiologi select', '#modal-radiologi');
        }).fail(function() {
            $('#menu-radiologi').html('<div class="alert alert-danger m-4 fw-semibold" role="alert"><i class="fas fa-exclamation-triangle me-2"></i>Gagal memuat data. Silakan coba lagi.</div>');
        });
    });
</script>
@endsection
