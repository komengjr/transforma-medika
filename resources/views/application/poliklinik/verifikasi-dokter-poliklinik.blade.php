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
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        background-color: transparent;
        overflow: hidden;
    }

    .ent-card>.card-header {
        background-color: transparent !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
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

    .ent-btn-outline {
        border: 1px solid var(--ent-grid-border);
        background-color: transparent;
        color: var(--bs-body-color);
    }

    .ent-btn-outline:hover {
        background-color: rgba(79, 70, 229, 0.08);
        border-color: var(--ent-indigo);
        color: var(--bs-body-color);
    }

    /* Adaptive Floating Filters */
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

    /* =========================================================
       TRANSPARENT TABLE WITH COLORED GRID BORDERS & FULL ACTION
       ========================================================= */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
        background-color: transparent !important;
        --bs-table-bg: transparent;
        --bs-table-accent-bg: transparent;
        --bs-table-striped-bg: rgba(99, 102, 241, 0.03);
        --bs-table-hover-bg: rgba(79, 70, 229, 0.08);
        --bs-table-color: var(--bs-body-color);
        --bs-table-border-color: var(--ent-grid-border);
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.09) !important;
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
        background-color: transparent !important;
        transition: background-color 0.15s ease;
        height: 1px;
    }

    .table-custom tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.07) !important;
    }

    .table-custom td {
        background-color: transparent !important;
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 11px 12px;
        vertical-align: middle;
        font-size: 0.83rem;
    }

    .table-custom tbody td:first-child {
        border-left: none !important;
    }

    .table-custom tbody td:last-child {
        border-right: none !important;
    }

    /* FULL-CELL ACTION BUTTON STYLING */
    .table-custom td.action-cell-full {
        padding: 0 !important;
        height: 100%;
        vertical-align: stretch !important;
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
        background-color: rgba(79, 70, 229, 0.12);
        color: #4f46e5;
        font-weight: 700;
        font-size: 0.8rem;
        transition: all 0.15s ease;
    }

    .table-custom td.action-cell-full>button:hover,
    .table-custom td.action-cell-full>.btn:hover {
        background-color: var(--ent-indigo);
        color: #ffffff;
    }

    /* DataTables Top & Bottom Controls Padding (Adaptive Transparent) */
    #example_wrapper>.row:first-child,
    #example_wrapper .dt-layout-row:first-child {
        padding: 16px 20px 12px 20px;
        margin: 0 !important;
        background-color: transparent;
    }

    #example_wrapper>.row:last-child,
    #example_wrapper .dt-layout-row:last-child {
        padding: 14px 20px 18px 20px;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
        background-color: transparent;
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
        background-color: transparent;
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
        background-color: var(--bs-body-bg);
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
                            <img src="{{ asset('img/verif.png') }}" alt="Verifikasi Logo" class="img-fluid" width="38" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-user-md me-1"></i> LIVE SYSTEM
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Otorisasi Medis Poliklinik</span>
                            </div>
                            <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: #cbd5e1;">
                                Verifikasi Dokter <span class="fw-normal" style="color: #cbd5e1;">Poliklinik</span>
                            </h4>
                        </div>
                    </div>

                    <div class="col-lg-4 text-lg-end">
                        <div class="ent-glass-pill d-inline-flex align-items-center px-3 py-2">
                            <h6 class="fw-bold mb-0" style="font-size: 0.9rem;color: #fdfeff;">
                                <i class="fas fa-clipboard-check me-2 text-info"></i> Daftar Pasien Menunggu Verifikasi
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN DATA TABLE CARD (TRANSPARENT HEADER + ADAPTIVE TABLE BODY + COLORED GRID) -->
<div class="ent-card mb-3">
    <div class="card-header py-3 px-3 px-md-4">
        <form method="GET" action="" class="row align-items-center g-2">

            <!-- TOMBOL AKSI UTAMA & TOGGLE FILTER MOBILE -->
            <div class="col-12 col-md-auto d-flex align-items-center justify-content-between gap-2">
                <a href="{{ url()->current() }}" class="btn btn-sm ent-btn ent-btn-primary px-3 py-2 d-flex align-items-center gap-2" style="height: 44px;"
                    data-bs-toggle="tooltip" title="Reset & Refresh Data Hari Ini">
                    <i class="fas fa-sync-alt"></i>
                    <span class="d-sm-inline fw-semibold">Reset Data</span>
                </a>

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

                    <!-- Filter Tanggal Awal -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="form-floating-custom">
                            <label>Tanggal Awal</label>
                            <input type="text" name="start_date" class="form-control datetimepicker ent-input" value="{{ request('start_date', date('Y-m-d')) }}" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Filter Tanggal Akhir -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="form-floating-custom">
                            <label>Tanggal Akhir</label>
                            <input type="text" name="end_date" class="form-control datetimepicker ent-input" value="{{ request('end_date', date('Y-m-d')) }}" placeholder="YYYY-MM-DD" data-options='{"dateFormat":"Y-m-d","disableMobile":true}'>
                        </div>
                    </div>

                    <!-- Filter Poliklinik -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="form-floating-custom">
                            <label>Pilih Poliklinik</label>
                            <select name="poli_id" class="form-select ent-input select2-verif-poli" id="filter_poli_id" data-placeholder="Semua Poliklinik">
                                <option value="">Semua Poliklinik</option>
                                @foreach($polis ?? [] as $p)
                                <option value="{{ $p->id }}" {{ request('poli_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_poli }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Tombol Submit Filter -->
                    <div class="col-12 col-sm-6 col-md-2">
                        <button type="submit" class="btn btn-sm ent-btn ent-btn-primary w-100 d-flex align-items-center justify-content-center gap-2" style="height: 44px;">
                            <i class="fas fa-search"></i>
                            <span class="fw-semibold">Filter</span>
                        </button>
                    </div>

                </div>
            </div>

        </form>
    </div>

    <div class="card-body p-0" style="background-color: var(--bs-body-bg);">
        <div class="table-responsive pb-3">
            <table id="example" class="table table-custom align-middle pb-3 w-100">
                <thead class="text-dark">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="15%">No Registrasi</th>
                        <th width="20%">Nama Pasien</th>
                        <th width="14%">Tanggal Reg</th>
                        <th width="14%">Poliklinik</th>
                        <th width="15%">Dokter Pemeriksa</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="7%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data as $datas)
                    <tr>
                        <td class="text-center fw-semibold">{{ $no++ }}</td>
                        <td>
                            <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #4f46e5; border: 1px solid rgba(79, 70, 229, 0.35); font-family: 'JetBrains Mono', monospace; font-size: 0.74rem;">
                                {{ $datas->no_registrasi }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $datas->master_patient_name }}</div>
                            <div class="opacity-75 fw-semibold mt-0.5" style="font-size: 0.72rem; font-family: 'JetBrains Mono', monospace;">
                                <i class="fas fa-qrcode text-primary me-1"></i>RM: {{ $datas->master_patient_code }}
                            </div>
                        </td>
                        <td class="fw-semibold" style="font-size: 0.8rem;">{{ $datas->tanggal_registrasi }}</td>
                        <td>
                            <span class="ent-badge" style="background: rgba(14, 165, 233, 0.14); color: #0284c7; border: 1px solid rgba(14, 165, 233, 0.35);">
                                {{ $datas->m_poli_name ?? '-' }}
                            </span>
                        </td>
                        <td class="fw-semibold">
                            <i class="fas fa-user-md me-1 text-primary"></i> {{ $datas->master_doctor_name ?? 'Belum Ditentukan' }}
                        </td>
                        <td class="text-center">
                            @if (isset($datas->status_verifikasi_dokter) && $datas->status_verifikasi_dokter == 'Verified')
                            <span class="ent-badge" style="background: rgba(16, 185, 129, 0.15); color: #059669; border: 1px solid rgba(16, 185, 129, 0.35);">
                                <i class="fas fa-check-circle me-1"></i> Verified
                            </span>
                            @else
                            <span class="ent-badge" style="background: rgba(244, 63, 94, 0.15); color: #e11d48; border: 1px solid rgba(244, 63, 94, 0.35);">
                                <i class="fas fa-clock me-1"></i> Not Verified
                            </span>
                            @endif
                        </td>
                        <td class="action-cell-full text-center">
                            <button class="btn"
                                data-bs-toggle="modal" data-bs-target="#modal-poliklinik"
                                id="button-proses-verifikasi" data-code="{{ $datas->no_registrasi }}"
                                title="Verifikasi Pemeriksaan">
                                <i class="fas fa-stethoscope me-1"></i> Verifikasi
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form Handling -->
<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <!-- <button class="btn-close shadow-sm rounded-circle p-2" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div id="menu-poliklinik"></div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function initSelect2VerifPoli(selector) {
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
        initSelect2VerifPoli('.select2-verif-poli');

        new DataTable('#example', {
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari nama, RM, atau No Reg...",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ pasien",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                }
            }
        });
    });

    // Klik Tombol Verifikasi (Membuka Form Handling Detail)
    $(document).on("click", "#button-proses-verifikasi", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-poliklinik').html(
            '<div class="custom-loader py-5 text-center"><div class="spinner-border text-primary mb-2" role="status"></div><span class="fw-semibold small d-block">Memuat Form Pemeriksaan...</span></div>'
        );
        $.ajax({
            url: "{{ route('verifikasi_poliklinik_dokter_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-poliklinik').html(data);
        }).fail(function() {
            $('#menu-poliklinik').html('<div class="alert alert-danger m-4 rounded-3 text-center fw-semibold"><i class="fas fa-exclamation-triangle me-2"></i> Gagal memuat form verifikasi.</div>');
        });
    });

    // Simpan & Verifikasi Final oleh Dokter
    $(document).on("click", "#button-save-data-diagnosa-pasien-poli", function(e) {
        e.preventDefault();

        Swal.fire({
            title: "Verifikasi & Simpan Pemeriksaan?",
            text: "Data anamnesa, vital sign, tindakan, resep, dan diagnosa akan diverifikasi final oleh dokter.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Verifikasi!",
            cancelButtonText: "Batal",
            customClass: {
                confirmButton: "btn btn-success px-4 mx-2",
                cancelButton: "btn btn-outline-secondary px-4 mx-2"
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = $('#form-handling-medis').serialize();

                $.ajax({
                    url: "{{ route('store_handling_medis') }}",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Menyimpan data pemeriksaan poli.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                            var regCode = $('input[name="no_registrasi"]').val();

                            $.ajax({
                                url: "{{ route('verifikasi_poliklinik_dokter_save_verify') }}",
                                type: "POST",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "code": regCode
                                },
                                dataType: "json",
                                success: function(res) {
                                    Swal.fire({
                                        title: "Berhasil Terverifikasi!",
                                        text: "Pemeriksaan pasien poli telah disetujui oleh dokter.",
                                        icon: "success",
                                        confirmButtonColor: "#4f46e5"
                                    }).then(() => {
                                        $('.modal').modal('hide');
                                        location.reload();
                                    });
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Terjadi kesalahan saat menyimpan data.'
                        });
                    }
                });
            }
        });
    });
</script>
@endsection
