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
       MODERN ENTERPRISE UI STYLES (MASTER CABANG)
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
        --ent-action-bg: #eef2ff;
        --ent-action-color: #3730a3;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
        --ent-surface: #ffffff;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-action-bg: #1e293b;
        --ent-action-color: #a5b4fc;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
        --ent-surface: #0f172a;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Adaptive Enterprise Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card>.card-header {
        border-bottom: 1px solid var(--ent-grid-border) !important;
    }

    .ent-table-surface {
        background-color: var(--bs-body-bg, var(--ent-surface));
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

    /* Avatar Cabang */
    .cabang-avatar {
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

    /* Soft Badges */
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

    .badge-ya {
        background-color: rgba(16, 185, 129, 0.15) !important;
        color: #10b981 !important;
        border: 1px solid rgba(16, 185, 129, 0.35);
    }

    .badge-tidak {
        background-color: rgba(100, 116, 139, 0.15) !important;
        color: var(--bs-secondary-color, #94a3b8) !important;
        border: 1px solid rgba(100, 116, 139, 0.35);
    }

    /* =========================================================
       TABLE WITH COLORED GRID BORDERS & SOLID ACTION BUTTON
       ========================================================= */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
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

    /* Zero horizontal padding/margin on flush card body & DataTables wrapper */
    .ent-card-body-flush {
        padding: 0 !important;
        margin: 0 !important;
    }

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
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    #example_wrapper .dt-layout-table > .dt-layout-cell {
        padding-left: 0 !important;
        padding-right: 0 !important;
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

    /* Dropdown & Modal Adaptive */
    .ent-dropdown-menu {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.25) !important;
        background-color: var(--bs-body-bg, #ffffff) !important;
    }

    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg, #ffffff) !important;
        color: var(--bs-body-color);
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<!-- Banner Header Enterprise -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/koperasi.png') }}" alt="Koperasi Logo" width="40" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-code-branch me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} SYSTEM
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Master Cabang Koperasi</span>
                            </div>
                            <h4 class="mb-0 fw-bold text-white" style="letter-spacing: -0.02em;">Master Cabang Koperasi</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Kelola data cabang, user verifikasi, dan pengaturan limit peminjaman koperasi.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end d-flex flex-wrap justify-content-lg-end gap-2">
                        <a href="#" class="btn ent-btn ent-btn-primary px-3 py-2" data-bs-toggle="modal" data-bs-target="#modal-koperasi" id="button-add-data-cabang">
                            <i class="fas fa-plus me-1"></i> Tambah Cabang
                        </a>
                        <button type="button" class="btn ent-btn ent-btn-warning px-3 py-2" onclick="window.print();" data-bs-toggle="tooltip" title="Cetak Data Cabang">
                            <i class="fas fa-print me-1"></i> Cetak
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Card with Integrated Floating Filter Bar & Zero Horizontal Padding Table -->
<div class="ent-card mb-3">
    <div class="card-header py-3 px-3 px-md-4">
        <form id="form-filter-cabang" onsubmit="event.preventDefault(); refreshCabangTable();">
            <div class="row g-2 align-items-center">
                <!-- Tombol Refresh / Reset -->
                <div class="col-auto">
                    <button type="button" id="btnResetFilterCabang" class="btn ent-btn ent-btn-primary px-3 fw-semibold d-flex align-items-center gap-2" style="height: 44px;">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>

                <!-- Cari Nama / Kode Cabang -->
                <div class="col-12 col-sm-6 col-md">
                    <div class="form-floating-custom">
                        <label>Kode / Nama Cabang</label>
                        <input class="form-control ent-input" type="text" id="search_cabang" name="search_cabang" placeholder="Cari Kode atau Nama Cabang..." />
                    </div>
                </div>

                <!-- Filter Kota -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-floating-custom">
                        <label>Kota Cabang</label>
                        <select class="form-select ent-input" id="filter_kota_cabang" name="filter_kota_cabang">
                            <option value="">Semua Kota</option>
                            @foreach ($data->pluck('kop_master_cabang_city')->filter()->unique() as $kota)
                            <option value="{{ strtolower($kota) }}">{{ $kota }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Rentang Tanggal -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="form-floating-custom">
                        <label>Rentang Tanggal</label>
                        <input class="form-control ent-input datetimepicker" id="timepicker3" type="text" placeholder="Y-m-d to Y-m-d"
                            data-options='{"mode":"range","dateFormat":"Y-m-d","disableMobile":true,"locale":"en"}'
                            onchange="if (typeof search === 'function') search(this)" />
                    </div>
                </div>

                <!-- Tombol Submit Filter -->
                <div class="col-auto">
                    <button type="submit" class="btn ent-btn ent-btn-warning px-3 d-flex align-items-center justify-content-center" style="height: 44px;" title="Terapkan Filter">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body ent-card-body-flush ent-table-surface" id="hasil-pencarian-list">
        <div class="table-responsive pb-3">
            <table id="example" class="table table-custom align-middle mb-0 w-100">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 4%;">#</th>
                        <th class="text-center" style="width: 5%;">NO</th>
                        <th style="width: 18%;">KODE &amp; NAMA CABANG</th>
                        <th style="width: 13%;">KOTA</th>
                        <th style="width: 22%;">USER VERIFIKASI</th>
                        <th style="width: 38%;">SETUP PEMINJAMAN</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                    @php
                    $initial = $datas->kop_master_cabang_name ? strtoupper(substr($datas->kop_master_cabang_name, 0, 3)) : 'CBG';
                    $user = DB::table('kop_user_verifikasi')->where('kop_user_verifikasi_cabang', $datas->kop_master_cabang_code)->get();
                    $setup = DB::table('kop_setup_cabang_koperasi')->where('kop_setup_cabang_koperasi_cabang', $datas->kop_master_cabang_code)->first();
                    @endphp
                    <tr
                        data-code="{{ strtolower($datas->kop_master_cabang_code) }}"
                        data-nama="{{ strtolower($datas->kop_master_cabang_name) }}"
                        data-kota="{{ strtolower($datas->kop_master_cabang_city) }}">
                        <td class="action-cell-full text-center align-middle">
                            <div class="dropdown">
                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Aksi">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu ent-dropdown-menu py-2">
                                    <li>
                                        <a class="dropdown-item fw-semibold py-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-koperasi"
                                            id="button-data-history-pasien" data-code="{{ $datas->kop_master_cabang_code }}">
                                            <i class="fas fa-edit me-2 text-primary"></i> Update Data Cabang
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item fw-semibold py-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-koperasi"
                                            id="button-add-data-verifikasi" data-code="{{ $datas->kop_master_cabang_code }}">
                                            <i class="fas fa-user-shield me-2 text-info"></i> Tambah User Verifikasi Cabang
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item fw-semibold py-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-koperasi"
                                            id="button-update-data-setup" data-code="{{ $datas->kop_master_cabang_code }}">
                                            <i class="fas fa-sliders-h me-2 text-warning"></i> Setup Peminjaman
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td class="text-center fw-semibold" style="font-family: 'JetBrains Mono', monospace;">{{ $no++ }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="cabang-avatar">{{ $initial }}</div>
                                <div>
                                    <div class="fw-bold text-uppercase" style="font-size: 0.84rem;">{{ $datas->kop_master_cabang_name }}</div>
                                    <span class="ent-badge mt-0.5" style="background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3); font-family: 'JetBrains Mono', monospace; font-size: 0.62rem; padding: 2px 7px;">
                                        {{ $datas->kop_master_cabang_code }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fw-semibold" style="font-size: 0.82rem;">
                                <i class="fas fa-map-marker-alt text-primary me-1"></i>{{ $datas->kop_master_cabang_city }}
                            </span>
                        </td>
                        <td>
                            @if ($user->count() > 0)
                            <div class="d-flex flex-column gap-1.5">
                                @foreach ($user as $users)
                                <div class="d-flex align-items-center justify-content-between gap-2 px-2 py-1 rounded-3" style="background: rgba(79, 70, 229, 0.06); border: 1px solid var(--ent-grid-border);">
                                    <span class="fw-semibold" style="font-size: 0.78rem;">{{ $users->kop_user_verifikasi_name }}</span>
                                    <span class="ent-badge" style="background: rgba(2, 132, 199, 0.15); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.35); font-size: 0.6rem; padding: 2px 7px;">
                                        @if ($users->kop_user_verifikasi_job == '0')
                                        Kepala Cabang
                                        @else
                                        Ketua Koperasi
                                        @endif
                                    </span>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <span class="opacity-50 small">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($setup)
                            <div class="row g-2" style="font-size: 0.76rem;">
                                <div class="col-md-6">
                                    <div class="p-2 rounded-3" style="background: rgba(79, 70, 229, 0.05); border: 1px solid var(--ent-grid-border);">
                                        <div class="fw-bold text-primary mb-1" style="font-size: 0.68rem; text-transform: uppercase;">Jumlah Pinjaman Max</div>
                                        <div>Barang: <strong>@currency($setup->kop_setup_cabang_koperasi_jp_brg)</strong></div>
                                        <div>Uang: <strong>@currency($setup->kop_setup_cabang_koperasi_jp_uang)</strong></div>
                                        <div class="fw-bold text-primary mt-1.5 mb-1" style="font-size: 0.68rem; text-transform: uppercase;">Tenor Max</div>
                                        <div>Barang: <strong>{{ $setup->kop_setup_cabang_koperasi_tenor_brg }} kali</strong></div>
                                        <div>Uang: <strong>{{ $setup->kop_setup_cabang_koperasi_tenor_uang }} kali</strong></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-2 rounded-3 h-100" style="background: rgba(79, 70, 229, 0.05); border: 1px solid var(--ent-grid-border);">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Angsuran Bunga:</span>
                                            <strong style="font-family: 'JetBrains Mono', monospace;">{{ $setup->kop_setup_cabang_koperasi_bunga }}%</strong>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Biaya Admin:</span>
                                            <strong style="font-family: 'JetBrains Mono', monospace;">{{ $setup->kop_setup_cabang_koperasi_admin }}%</strong>
                                        </div>
                                        <div class="fw-bold text-primary mb-1" style="font-size: 0.68rem; text-transform: uppercase;">Metode Verifikasi</div>
                                        <div class="d-flex flex-wrap gap-1.5">
                                            <span class="ent-badge {{ $setup->kop_setup_cabang_koperasi_wa == '0' ? 'badge-tidak' : 'badge-ya' }}" style="font-size: 0.62rem; padding: 2px 8px;">
                                                <i class="fab fa-whatsapp me-1"></i> WA: {{ $setup->kop_setup_cabang_koperasi_wa == '0' ? 'TIDAK' : 'YA' }}
                                            </span>
                                            <span class="ent-badge {{ $setup->kop_setup_cabang_koperasi_email == '0' ? 'badge-tidak' : 'badge-ya' }}" style="font-size: 0.62rem; padding: 2px 8px;">
                                                <i class="fas fa-envelope me-1"></i> Email: {{ $setup->kop_setup_cabang_koperasi_email == '0' ? 'TIDAK' : 'YA' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <span class="opacity-50 small">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-penjualan-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-koperasi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-koperasi"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let cabangTable = null;

    function refreshCabangTable() {
        if (cabangTable) {
            cabangTable.draw();
        }
    }

    $(document).ready(function() {
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (settings.nTable.id !== 'example') return true;

            const rowNode = settings.aoData[dataIndex].nTr;
            const keyword = ($('#search_cabang').val() || '').toString().trim().toLowerCase();
            const selectedKota = ($('#filter_kota_cabang').val() || '').toString().trim().toLowerCase();

            const rowCode = ($(rowNode).attr('data-code') || '').toString().trim().toLowerCase();
            const rowNama = ($(rowNode).attr('data-nama') || '').toString().trim().toLowerCase();
            const rowKota = ($(rowNode).attr('data-kota') || '').toString().trim().toLowerCase();

            const matchKeyword = keyword === '' || rowCode.includes(keyword) || rowNama.includes(keyword);
            const matchKota = selectedKota === '' || rowKota === selectedKota;

            return matchKeyword && matchKota;
        });

        if (document.querySelector('#example')) {
            cabangTable = new DataTable('#example', {
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari data...",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    emptyTable: "Tidak ada data cabang.",
                    zeroRecords: "Data cabang tidak ditemukan.",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "<i class='fas fa-angle-right'></i>",
                        previous: "<i class='fas fa-angle-left'></i>"
                    }
                }
            });
        }

        $('#search_cabang').on('input keyup', refreshCabangTable);
        $('#filter_kota_cabang').on('change', refreshCabangTable);

        $('#btnResetFilterCabang').on('click', function() {
            $('#search_cabang').val('');
            $('#filter_kota_cabang').val('');
            refreshCabangTable();
        });
    });
</script>

<script>
    $(document).on("click", "#button-add-data-cabang", function(e) {
        e.preventDefault();
        $('#menu-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_koperasi_cabang_add_cabang') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 123
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-koperasi').html(data);
        }).fail(function() {
            $('#menu-koperasi').html('eror');
        });
    });

    $(document).on("click", "#button-simpan-data-cabang", function(e) {
        e.preventDefault();
        var data = $("#form-add-cabang-baru").serialize();
        $('#menu-add-data-cabang').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_koperasi_cabang_save_cabang') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'html',
        }).done(function(data) {
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#menu-add-data-cabang').html('<button class="btn btn-success float-end" id="button-simpan-data-cabang" data-code="">Simpan Data</button>');
            } else {
                $('#menu-add-data-cabang').html(data);
                location.reload();
            }
        }).fail(function() {
            $('#menu-add-data-cabang').html('eror');
        });
    });

    $(document).on("click", "#button-add-data-verifikasi", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_koperasi_cabang_add_verifikasi') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-koperasi').html(data);
        }).fail(function() {
            $('#menu-koperasi').html('eror');
        });
    });

    $(document).on("click", "#button-simpan-data-verifikasi", function(e) {
        e.preventDefault();
        var data = $("#form-add-verifikasi-baru").serialize();
        $('#menu-add-data-verifikasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_koperasi_cabang_save_data_verifikasi') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'html',
        }).done(function(data) {
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#menu-add-data-verifikasi').html('<button class="btn btn-success float-end" id="button-simpan-data-verifikasi" data-code="">Simpan Data</button>');
            } else {
                $('#menu-add-data-verifikasi').html(data);
                location.reload();
            }
        }).fail(function() {
            $('#menu-add-data-verifikasi').html('eror');
        });
    });

    $(document).on("click", "#button-update-data-setup", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_koperasi_cabang_update_data_setup') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-koperasi').html(data);
        }).fail(function() {
            $('#menu-koperasi').html('eror');
        });
    });

    $(document).on("click", "#button-simpan-data-setup", function(e) {
        e.preventDefault();
        var data = $("#form-add-setup-baru").serialize();
        console.log(data);

        $('#menu-add-data-setup').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_koperasi_cabang_save_data_setup') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'html',
        }).done(function(data) {
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#menu-add-data-setup').html('<button class="btn btn-success float-end" id="button-simpan-data-setup" data-code="">Simpan Data</button>');
            } else {
                $('#menu-add-data-setup').html(data);
                location.reload();
            }
        }).fail(function() {
            $('#menu-add-data-setup').html('eror');
        });
    });
</script>
@endsection
