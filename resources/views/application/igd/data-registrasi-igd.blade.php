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

    /* Enterprise Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        overflow: hidden;
    }

    .ent-card>.card-header {
        background-color: rgba(79, 70, 229, 0.05) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
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

    /* Modern Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        cursor: pointer;
        font-size: 0.82rem;
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
        background-color: rgba(245, 158, 11, 0.15);
        border: 1px solid rgba(245, 158, 11, 0.4);
        color: #d97706;
    }

    .ent-btn-warning:hover {
        background-color: #f59e0b;
        border-color: #f59e0b;
        color: #ffffff;
    }

    /* Floating Filters */
    .form-floating-custom {
        position: relative;
    }

    .form-floating-custom label {
        position: absolute;
        top: 5px;
        left: 11px;
        font-size: 0.64rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        pointer-events: none;
        z-index: 5;
        background: transparent;
    }

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

    .ent-input,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        padding-top: 18px !important;
        padding-bottom: 5px !important;
        padding-left: 11px !important;
        font-size: 0.8rem !important;
        height: 44px !important;
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
    .form-floating-custom .select2-container--bootstrap-5 {
        width: 100% !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection {
        height: 44px !important;
        padding-top: 16px !important;
        padding-bottom: 4px !important;
        padding-left: 8px !important;
        padding-right: 28px !important;
        border-radius: 10px !important;
        background-color: var(--ent-solid-bg) !important;
        border: 1px solid var(--ent-grid-border) !important;
        display: flex !important;
        align-items: center !important;
        box-shadow: none !important;
        opacity: 1 !important;
        transition: all 0.2s ease;
    }

    .form-floating-custom .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .form-floating-custom .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: var(--ent-indigo) !important;
        background-color: var(--ent-solid-bg) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        color: var(--ent-solid-text) !important;
        padding-left: 3px !important;
        line-height: 1.4 !important;
    }

    .form-floating-custom .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
        top: 10px !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
        opacity: 1 !important;
        z-index: 1080 !important;
        box-shadow: 0 14px 28px -6px rgba(15, 23, 42, 0.24) !important;
        overflow: hidden;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown {
        background-color: var(--ent-solid-bg) !important;
        padding: 8px !important;
        border-bottom: 1px solid var(--ent-grid-border);
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        background-color: var(--ent-solid-bg) !important;
        color: var(--ent-solid-text) !important;
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

    /* =========================================================
       ADAPTIVE TABLE WITH COLORED GRID BORDERS & SOLID ACTION CELL
       ========================================================= */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.11) !important;
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
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
        height: 1px;
    }

    .table-custom tbody tr:hover,
    .table-custom tbody tr:hover td:not(.action-cell-full) {
        background-color: rgba(79, 70, 229, 0.06) !important;
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
    }

    /* SOLID FULL-CELL ACTION BUTTON STYLING (NON-TRANSPARENT) */
    .table-custom td.action-cell-full {
        padding: 0 !important;
        height: 100%;
        vertical-align: stretch !important;
        background-color: var(--ent-action-bg) !important;
    }

    .table-custom td.action-cell-full>.btn,
    .table-custom td.action-cell-full>.btn-group,
    .table-custom td.action-cell-full>.dropdown,
    .table-custom td.action-cell-full>a,
    .table-custom td.action-cell-full>button {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 100% !important;
        height: 100% !important;
        min-height: 52px;
        border-radius: 0 !important;
        margin: 0 !important;
        border: none !important;
        background-color: var(--ent-action-bg) !important;
        color: var(--ent-action-color) !important;
        opacity: 1 !important;
        font-weight: 700 !important;
        font-size: 0.8rem !important;
        box-shadow: inset 0 0 0 1px rgba(79, 70, 229, 0.16);
        transition: background-color 0.15s ease, color 0.15s ease;
    }

    .table-custom td.action-cell-full>.btn:hover,
    .table-custom td.action-cell-full>a:hover,
    .table-custom td.action-cell-full>button:hover,
    .table-custom tbody tr:hover td.action-cell-full>.btn,
    .table-custom tbody tr:hover td.action-cell-full>a,
    .table-custom tbody tr:hover td.action-cell-full>button {
        background-color: var(--ent-action-hover-bg) !important;
        color: var(--ent-action-hover-color) !important;
        opacity: 1 !important;
    }

    /* DataTables Top & Bottom Controls Padding */
    #table-registrasi-igd_wrapper>.row:first-child,
    #table-registrasi-igd_wrapper .dt-layout-row:first-child {
        padding: 16px 20px 12px 20px;
        margin: 0 !important;
        color: var(--bs-body-color);
    }

    #table-registrasi-igd_wrapper>.row:last-child,
    #table-registrasi-igd_wrapper .dt-layout-row:last-child {
        padding: 14px 20px 18px 20px;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color);
    }

    #table-registrasi-igd_wrapper .dt-layout-table {
        margin: 0 !important;
    }

    #table-registrasi-igd_wrapper .dataTables_filter input,
    #table-registrasi-igd_wrapper .dt-search input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        padding: 6px 12px !important;
        font-size: 0.82rem !important;
        height: 36px !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    #table-registrasi-igd_wrapper .dataTables_filter input:focus,
    #table-registrasi-igd_wrapper .dt-search input:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    #table-registrasi-igd_wrapper .dataTables_length select,
    #table-registrasi-igd_wrapper .dt-length select {
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
        background-color: var(--bs-body-bg);
        border-radius: 8px;
        margin: 0 2px;
        border: 1px solid var(--ent-grid-border);
        font-weight: 600;
        font-size: 0.8rem;
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
<!-- HEADER HERO BANNER ENTERPRISE -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-ambulance text-danger fs-3"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(244, 63, 94, 0.22); border: 1px solid rgba(244, 63, 94, 0.45); color: #fda4af;">
                                    <i class="fas fa-heartbeat me-1"></i> UNIT GAWAT DARURAT
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Emergency &amp; Triage Care</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-white" style="letter-spacing: -0.02em;">
                                List Registrasi &amp; <span class="fw-normal" style="color: #cbd5e1;">Penanganan IGD</span>
                            </h4>
                        </div>
                    </div>

                    <div class="col-lg-4 text-lg-end">
                        <div class="ent-glass-pill d-inline-flex align-items-center px-3 py-2">
                            <h6 class="fw-bold mb-0 text-white" style="font-size: 0.9rem;">
                                <i class="fas fa-notes-medical me-2 text-info"></i> Data Kunjungan Pasien IGD
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN DATA TABLE CARD -->
<div class="ent-card mb-3">
    <div class="card-header py-3 px-3 px-md-4">
        <form id="form-filter" onsubmit="event.preventDefault(); reloadTable();" class="row align-items-center g-2">

            <!-- TOMBOL AKSI UTAMA & TOGGLE FILTER MOBILE -->
            <div class="col-12 col-md-auto d-flex align-items-center justify-content-between gap-2">
                <button class="btn btn-sm ent-btn ent-btn-primary px-3 py-2 d-flex align-items-center gap-2" style="height: 44px;"
                    type="button" id="button-refresh-igd" data-bs-toggle="tooltip" title="Reset & Refresh Data Hari Ini">
                    <i class="fas fa-sync-alt"></i>
                    <span class="d-sm-inline fw-semibold">Refresh Data</span>
                </button>

                <button class="btn btn-sm ent-btn ent-btn-warning px-3 py-2 d-md-none d-flex align-items-center gap-1" style="height: 44px;"
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilterMobile" aria-expanded="false" aria-controls="collapseFilterMobile">
                    <i class="fas fa-filter"></i>
                    <span>Filter</span>
                    <i class="fas fa-chevron-down ms-1"></i>
                </button>
            </div>

            <!-- CONTAINER DERETAN FILTER -->
            <div class="col-12 col-md collapse d-md-block" id="collapseFilterMobile">
                <div class="row g-2 align-items-center mt-2 mt-md-0 pt-2 pt-md-0 border-top border-md-0">

                    <!-- Tanggal Awal -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Tanggal Awal</label>
                            <input type="text" class="form-control datetimepicker ent-input" id="start_date" name="start_date" value="{{ $startDate ?? date('Y-m-d') }}" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Tanggal Akhir -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Tanggal Akhir</label>
                            <input type="text" class="form-control datetimepicker ent-input" id="end_date" name="end_date" value="{{ $endDate ?? date('Y-m-d') }}" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- No Reg / Nama / RM -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>No Reg / Nama / RM</label>
                            <input type="text" class="form-control ent-input" id="keyword" name="keyword" placeholder="Cari Reg/Nama/RM...">
                        </div>
                    </div>

                    <!-- Poli / Ruangan IGD -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Poli / Ruangan IGD</label>
                            <select class="form-select ent-input select2-filter-igd" id="poli_id" name="poli_id" data-placeholder="Semua Poli/Ruangan">
                                <option value="">Semua Poli/Ruangan</option>
                                @if(isset($polis))
                                @foreach ($polis as $poli)
                                <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <!-- Dokter -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Dokter Pemeriksa</label>
                            <select class="form-select ent-input select2-filter-igd" id="dokter" name="dokter" data-placeholder="Semua Dokter">
                                <option value="">Semua Dokter</option>
                                @if(isset($doctors))
                                @foreach ($doctors as $doc)
                                <option value="{{ $doc->master_doctor_name ?? $doc->nama_lengkap }}">{{ $doc->master_doctor_name ?? $doc->nama_lengkap }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <!-- Kel. Pelanggan (Sub Penjamin) -->
                    <div class="col-12 col-sm-6 col-md">
                        <div class="form-floating-custom">
                            <label>Kel. Pelanggan</label>
                            <select class="form-select ent-input select2-filter-igd" id="sub_penjamin_id" name="sub_penjamin_id" data-placeholder="Semua Kelompok">
                                <option value="">Semua Kelompok</option>
                                @if(isset($subPenjamins))
                                @foreach ($subPenjamins as $sp)
                                <option value="{{ $sp->id }}">{{ $sp->nama_sub_penjamin }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <!-- Tombol Submit Filter -->
                    <div class="col-12 col-sm-6 col-md-auto">
                        <button type="submit" class="btn btn-sm ent-btn ent-btn-primary px-3 d-flex align-items-center justify-content-center gap-2 w-100" style="height: 44px;" title="Cari / Filter">
                            <i class="fas fa-search"></i>
                            <span class="d-md-none fw-semibold">Cari Data</span>
                        </button>
                    </div>

                </div>
            </div>

        </form>
    </div>

    <div class="card-body p-0 ent-table-surface">
        <div class="table-responsive pb-3">
            <table id="table-registrasi-igd" class="table table-custom align-middle w-100 mb-0 pb-3">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>No. Registrasi</th>
                        <th>Pasien &amp; RM</th>
                        <th>Tanggal Masuk</th>
                        <th>Dokter Pemeriksa</th>
                        <th>Ruangan / Poli IGD</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 110px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data dimuat dinamis via DataTables Server-side / AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODAL CONTAINER UNTUK HANDLING IGD -->
<div class="modal fade" id="modal-handling-igd" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;"></div>
            <div id="menu-handling-igd"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>

<script>
    let tableIgd;

    function initSelect2Igd(selector) {
        if (!(window.jQuery && $.fn.select2)) return;
        $(selector).each(function() {
            const $el = $(this);
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.select2('destroy');
            }
            const placeholderText = $el.data('placeholder') || $el.find('option:first').text() || 'Pilih';
            $el.select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: placeholderText,
                allowClear: true,
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

    $(document).ready(function() {
        initSelect2Igd('.select2-filter-igd');

        tableIgd = $('#table-registrasi-igd').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('data_registrasi_igd_table') }}",
                type: "GET",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.keyword = $('#keyword').val();
                    d.poli_id = $('#poli_id').val();
                    d.dokter = $('#dokter').val();
                    d.sub_penjamin_id = $('#sub_penjamin_id').val();
                }
            },
            columns: [{
                    data: 'no',
                    name: 'no',
                    orderable: false,
                    searchable: false,
                    className: 'text-center align-middle fw-semibold'
                },
                {
                    data: 'no_registrasi',
                    name: 'reg.no_registrasi',
                    className: 'align-middle'
                },
                {
                    data: 'nama_pasien',
                    name: 'p.nama',
                    className: 'align-middle fw-semibold'
                },
                {
                    data: 'tanggal_reg',
                    name: 'reg.tanggal_registrasi',
                    className: 'align-middle'
                },
                {
                    data: 'dokter',
                    name: 'doc_poli.nama_lengkap',
                    className: 'align-middle'
                },
                {
                    data: 'poli',
                    name: 'poli.nama_poli',
                    orderable: false,
                    className: 'align-middle'
                },
                {
                    data: 'status',
                    name: 'reg.status_kunjungan',
                    orderable: false,
                    className: 'text-center align-middle'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'action-cell-full text-center align-middle'
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data pasien IGD...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ pasien",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                },
                processing: `
                    <div class="custom-loader py-4 text-center">
                        <div class="spinner-border text-primary mb-2" style="width: 2.2rem; height: 2.2rem;" role="status"></div>
                        <span class="fw-semibold small d-block">Memuat data pasien IGD...</span>
                    </div>
                `
            }
        });

        $('#start_date, #end_date, #poli_id, #dokter, #sub_penjamin_id').on('change', function() {
            reloadTable();
        });

        $('#keyword').on('keyup', function() {
            reloadTable();
        });

        $('#button-refresh-igd').on('click', function(e) {
            e.preventDefault();
            const today = new Date().toISOString().split('T')[0];
            $('#start_date').val(today);
            $('#end_date').val(today);
            $('#keyword').val('');
            $('#poli_id').val('').trigger('change.select2');
            $('#dokter').val('').trigger('change.select2');
            $('#sub_penjamin_id').val('').trigger('change.select2');
            reloadTable();
        });
    });

    function reloadTable() {
        tableIgd.ajax.reload(null, false);
    }

    $(document).on("click", "#table-registrasi-igd .retro-btn-primary, #table-registrasi-igd .action-cell-full .btn, #table-registrasi-igd .action-cell-full button, #table-registrasi-igd .action-cell-full a", function(e) {
        e.preventDefault();
        var code = $(this).data("code");

        $('#menu-handling-igd').html(`
            <div class="custom-loader py-5 text-center">
                <div class="spinner-border text-primary mb-2" role="status"></div>
                <span class="fw-semibold small d-block">Memuat Form Handling IGD...</span>
            </div>
        `);
        $('#modal-handling-igd').modal('show');

        $.ajax({
            url: "{{ route('igd.handling.form') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-handling-igd').html(data);
        }).fail(function() {
            $('#menu-handling-igd').html(`
                <div class="alert alert-danger m-4 rounded-3 text-center fw-semibold">
                    <i class="fas fa-exclamation-triangle me-2"></i> Gagal memuat form handling IGD.
                </div>
            `);
        });
    });
</script>
@endsection
