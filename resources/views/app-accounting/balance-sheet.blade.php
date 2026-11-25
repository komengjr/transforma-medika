@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-surface: #ffffff;
        --ent-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-surface: #0f172a;
        --ent-text: #f8fafc;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
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
        width: 320px;
        height: 320px;
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

    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: visible;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.07) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        border-radius: 16px 16px 0 0;
        padding: 14px 20px;
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    .ent-label {
        font-size: 0.75rem;
        font-weight: 700;
        margin-bottom: 5px;
        display: inline-block;
        color: var(--bs-body-color, var(--ent-text));
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        font-size: 0.82rem;
        cursor: pointer;
    }

    .ent-btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .ent-btn-primary:hover:not(:disabled) {
        color: #ffffff;
    }

    /* Choices.js Searchable Dropdown Styling */
    .choices {
        margin-bottom: 0 !important;
        font-size: 0.82rem;
    }

    .choices__inner {
        min-height: 40px !important;
        padding: 5px 10px !important;
        border-radius: 10px !important;
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .choices__input {
        background-color: transparent !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        font-size: 0.8rem !important;
        margin-bottom: 0 !important;
        padding: 2px 4px !important;
    }

    .choices__list--dropdown,
    .choices__list[aria-expanded] {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        box-shadow: 0 12px 24px -6px rgba(15, 23, 42, 0.18) !important;
        z-index: 1060 !important;
    }

    .choices__list--dropdown .choices__item--selectable.is-highlighted,
    .choices__list[aria-expanded] .choices__item--selectable.is-highlighted {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: #4f46e5 !important;
    }

    .choices__list--dropdown .choices__item {
        font-size: 0.8rem;
        padding: 7px 12px;
    }

    .ent-date-input {
        min-height: 40px;
        border-radius: 10px !important;
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        font-size: 0.82rem !important;
        padding: 7px 12px !important;
    }

    .bs-summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }

    .bs-stat-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        padding: 14px 16px;
        background-color: rgba(79, 70, 229, 0.03);
    }

    .bs-stat-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        opacity: 0.72;
        display: block;
        margin-bottom: 4px;
    }

    .bs-stat-value {
        font-family: 'JetBrains Mono', monospace;
        font-size: 1.02rem;
        font-weight: 700;
    }

    .bs-section-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 16px;
    }

    .bs-section-header {
        padding: 10px 15px;
        font-weight: 700;
        font-size: 0.84rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .bs-table {
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.81rem;
        margin-bottom: 0;
    }

    .bs-table thead th {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        color: #ffffff;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 9px 11px;
        border-color: rgba(99, 102, 241, 0.35);
        white-space: nowrap;
    }

    .bs-table tbody td {
        padding: 8px 11px;
        vertical-align: middle;
        border-color: rgba(148, 163, 184, 0.22);
    }

    .bs-table tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.035);
    }

    .bs-subtotal-row td {
        background-color: rgba(79, 70, 229, 0.07) !important;
        border-top: 2px solid rgba(99, 102, 241, 0.35) !important;
        border-bottom: 1px solid rgba(99, 102, 241, 0.25) !important;
        font-weight: 700;
        padding: 9px 11px !important;
    }

    .bs-grand-row td {
        background: rgba(15, 23, 42, 0.06) !important;
        border-top: 2px solid #4f46e5 !important;
        border-bottom: 2px solid #4f46e5 !important;
        font-weight: 700;
        padding: 10px 11px !important;
    }

    .bs-mono {
        font-family: 'JetBrains Mono', monospace;
    }

    .bs-coa-pill {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 6px;
        background: rgba(79, 70, 229, 0.11);
        color: #4f46e5;
        border: 1px solid rgba(79, 70, 229, 0.25);
        display: inline-block;
    }

    [data-bs-theme="dark"] .bs-coa-pill,
    .dark .bs-coa-pill {
        color: #a5b4fc;
        background: rgba(129, 140, 248, 0.16);
    }

    @media print {
        .no-print {
            display: none !important;
        }
        .ent-card, .bs-section-box {
            box-shadow: none !important;
        }
    }
</style>
@endsection

@section('content')
@php
    $asetList        = collect($asetItems ?? []);
    $kewajibanList   = collect($kewajibanItems ?? []);
    $ekuitasList     = collect($ekuitasItems ?? []);
    $totAset         = (int) ($totalAset ?? 0);
    $totKewajiban    = (int) ($totalKewajiban ?? 0);
    $totEkuitas      = (int) ($totalEkuitas ?? 0);
    $labaBerjalan    = (int) ($labaRugiBerjalan ?? 0);
    $totKewEkuitas   = (int) ($totalKewajibanEkuitas ?? ($totKewajiban + $totEkuitas + $labaBerjalan));
    $selisih         = (int) ($selisihNeraca ?? ($totAset - $totKewEkuitas));
    $isBalanced      = ($selisih === 0);
@endphp

<!-- HERO BANNER HEADER -->
<header class="mb-3 no-print">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width: 58px; height: 58px;">
                        <img src="{{ asset('img/balance.png') }}" alt="Balance Sheet Icon" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                <i class="fas fa-balance-scale"></i> {{ Env('APP_LABEL') }} MANAGEMENT SYSTEM
                            </span>
                            <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Menu: Balance Sheet</span>
                        </div>
                        <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: white;">
                            Neraca Keuangan Terpusat (Balance Sheet)
                        </h4>
                        <p class="mb-0 small" style="color: #cbd5e1;">Posisi Aset, Kewajiban, dan Ekuitas per akun COA dari jurnal terposting lintas project.</p>
                    </div>
                </div>

                <div class="col-lg-4 text-lg-end">
                    <div class="ent-glass-pill px-3 py-2 d-inline-block text-start">
                        <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.6rem;">Basis Pelaporan</span>
                        <span class="fw-bold small" style="color: #7dd3fc;">
                            <i class="fas fa-check-double me-1"></i> Jurnal Terposting (acc_jurnal)
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- FILTER CARD -->
<div class="card ent-card mb-3 no-print">
    <div class="ent-card-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-filter me-2 text-primary"></i>Filter Posisi Neraca
                </h6>
                <small class="opacity-75">Pilih Project (ketik untuk mencari), Tanggal Awal, dan Tanggal Akhir lalu tekan Tampilkan.</small>
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-3 fw-semibold" onclick="window.print()">
                <i class="fas fa-print me-1"></i> Cetak Neraca
            </button>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">
        <form method="GET" action="{{ url()->current() }}" class="row g-3 align-items-end needs-validation" novalidate="" id="form-bs-filter">
            <div class="col-md-6 col-xl-4 position-relative">
                <label for="bs_project" class="ent-label">Project</label>
                <select class="form-select js-searchable-select" id="bs_project" name="project">
                    <option value="">Semua Project...</option>
                    @if (!empty($projects))
                        @foreach ($projects as $proj)
                            @php
                                $projCode = $proj->menu_super_code ?? ($proj->master_code_super ?? '');
                                $projName = $proj->menu_super_name ?? ($proj->master_name_super ?? $projCode);
                            @endphp
                            <option value="{{ $projCode }}" {{ (strtolower($project ?? '') === strtolower((string) $projCode)) ? 'selected' : '' }}>
                                {{ $projName }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-md-6 col-xl-3 position-relative">
                <label for="bs_tanggal_awal" class="ent-label">Tanggal Awal</label>
                <input class="form-control ent-date-input datetimepicker" id="bs_tanggal_awal" name="tanggal_awal"
                    type="text" value="{{ $tanggal_awal ?? '' }}" placeholder="dd/mm/yyyy"
                    data-options='{"dateFormat":"d/m/Y","disableMobile":true}' />
            </div>

            <div class="col-md-6 col-xl-3 position-relative">
                <label for="bs_tanggal_akhir" class="ent-label">Tanggal Akhir</label>
                <input class="form-control ent-date-input datetimepicker" id="bs_tanggal_akhir" name="tanggal_akhir"
                    type="text" value="{{ $tanggal_akhir ?? '' }}" placeholder="dd/mm/yyyy"
                    data-options='{"dateFormat":"d/m/Y","disableMobile":true}' />
            </div>

            <div class="col-md-6 col-xl-2 d-grid">
                <button class="btn ent-btn ent-btn-primary py-2" type="submit" id="btnFilterBalance">
                    <i class="fas fa-search me-1"></i> Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- RINGKASAN & TABEL NERACA -->
<div class="card ent-card mb-3">
    <div class="card-header bg-transparent border-bottom p-3 p-md-4" style="border-color: var(--ent-grid-border) !important;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5;">
                        <i class="fas fa-table"></i> STATEMENT OF FINANCIAL POSITION
                    </span>
                    @if (!empty($project))
                        <span class="ent-badge" style="background: rgba(2, 132, 199, 0.12); color: #0284c7;">
                            {{ strtoupper($project) }}
                        </span>
                    @endif
                </div>
                <h6 class="mb-0 fw-bold">Rincian Neraca (Aset, Kewajiban &amp; Ekuitas)</h6>
                <small class="opacity-75">
                    Periode: <strong>{{ !empty($tanggal_awal) ? $tanggal_awal : 'Semua Tanggal' }}</strong>
                    s/d <strong>{{ !empty($tanggal_akhir) ? $tanggal_akhir : 'Semua Tanggal' }}</strong>
                </small>
            </div>

            <div class="input-group input-group-sm no-print" style="width: 240px;">
                <span class="input-group-text bg-transparent"><i class="fas fa-search opacity-75"></i></span>
                <input type="text" id="filter-bs-account" class="form-control" placeholder="Cari Kode / Nama Akun...">
            </div>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">
        <div class="bs-summary-grid">
            <div class="bs-stat-card" style="border-left: 4px solid #0284c7 !important;">
                <span class="bs-stat-label">Total Aset</span>
                <span class="bs-stat-value text-info">Rp {{ number_format($totAset, 0, ',', '.') }}</span>
            </div>

            <div class="bs-stat-card" style="border-left: 4px solid #e11d48 !important;">
                <span class="bs-stat-label">Total Kewajiban</span>
                <span class="bs-stat-value text-danger">Rp {{ number_format($totKewajiban, 0, ',', '.') }}</span>
            </div>

            <div class="bs-stat-card" style="border-left: 4px solid #059669 !important;">
                <span class="bs-stat-label">Total Ekuitas (+ Laba/Rugi)</span>
                <span class="bs-stat-value text-success">Rp {{ number_format($totEkuitas + $labaBerjalan, 0, ',', '.') }}</span>
            </div>

            <div class="bs-stat-card" style="border-left: 4px solid {{ $isBalanced ? '#059669' : '#d97706' }} !important;">
                <span class="bs-stat-label">Status Keseimbangan</span>
                @if ($isBalanced)
                    <span class="bs-stat-value text-success"><i class="fas fa-check-circle me-1"></i>BALANCED</span>
                @else
                    <span class="bs-stat-value text-warning">
                        <i class="fas fa-exclamation-triangle me-1"></i>Selisih Rp {{ number_format(abs($selisih), 0, ',', '.') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="row g-3">
            <!-- KOLOM KIRI: ASET -->
            <div class="col-lg-6">
                <div class="bs-section-box h-100">
                    <div class="bs-section-header" style="background: rgba(2, 132, 199, 0.1); border-bottom: 1px solid rgba(2, 132, 199, 0.25); color: #0284c7;">
                        <span><i class="fas fa-landmark me-2"></i>I. ASET (ASSETS)</span>
                        <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill">{{ $asetList->count() }} Akun</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered bs-table w-100" id="tableAset">
                            <thead>
                                <tr>
                                    <th style="width: 115px;">Kode COA</th>
                                    <th>Nama Akun Aset</th>
                                    <th class="text-center" style="width: 75px;">Jurnal</th>
                                    <th class="text-end" style="width: 150px;">Saldo (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($asetList as $item)
                                    <tr class="bs-filterable-row">
                                        <td><span class="bs-coa-pill">{{ $item->coa_code }}</span></td>
                                        <td class="fw-semibold">{{ $item->coa_name }}</td>
                                        <td class="text-center bs-mono">{{ $item->jumlah_jurnal }}</td>
                                        <td class="text-end bs-mono fw-semibold text-info">
                                            {{ number_format((int) $item->saldo, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 opacity-75">Belum ada mutasi akun aset pada periode ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="bs-grand-row">
                                    <td colspan="3" class="text-end text-uppercase">Total Aset</td>
                                    <td class="text-end bs-mono text-info" id="totalAset">
                                        Rp {{ number_format($totAset, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN: KEWAJIBAN & EKUITAS -->
            <div class="col-lg-6">
                <div class="bs-section-box">
                    <div class="bs-section-header" style="background: rgba(225, 29, 72, 0.1); border-bottom: 1px solid rgba(225, 29, 72, 0.25); color: #e11d48;">
                        <span><i class="fas fa-file-contract me-2"></i>II. KEWAJIBAN (LIABILITIES)</span>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">{{ $kewajibanList->count() }} Akun</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered bs-table w-100" id="tableKewajiban">
                            <thead>
                                <tr>
                                    <th style="width: 115px;">Kode COA</th>
                                    <th>Nama Akun Kewajiban</th>
                                    <th class="text-center" style="width: 75px;">Jurnal</th>
                                    <th class="text-end" style="width: 150px;">Saldo (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kewajibanList as $item)
                                    <tr class="bs-filterable-row">
                                        <td><span class="bs-coa-pill">{{ $item->coa_code }}</span></td>
                                        <td class="fw-semibold">{{ $item->coa_name }}</td>
                                        <td class="text-center bs-mono">{{ $item->jumlah_jurnal }}</td>
                                        <td class="text-end bs-mono fw-semibold text-danger">
                                            {{ number_format((int) $item->saldo, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3 opacity-75">Belum ada mutasi akun kewajiban pada periode ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="bs-subtotal-row">
                                    <td colspan="3" class="text-end text-uppercase">Subtotal Kewajiban</td>
                                    <td class="text-end bs-mono text-danger">
                                        Rp {{ number_format($totKewajiban, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="bs-section-box mb-0">
                    <div class="bs-section-header" style="background: rgba(5, 150, 105, 0.1); border-bottom: 1px solid rgba(5, 150, 105, 0.25); color: #059669;">
                        <span><i class="fas fa-coins me-2"></i>III. EKUITAS (EQUITY)</span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">{{ $ekuitasList->count() }} Akun</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered bs-table w-100" id="tableEkuitas">
                            <thead>
                                <tr>
                                    <th style="width: 115px;">Kode COA</th>
                                    <th>Nama Akun Ekuitas</th>
                                    <th class="text-center" style="width: 75px;">Jurnal</th>
                                    <th class="text-end" style="width: 150px;">Saldo (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ekuitasList as $item)
                                    <tr class="bs-filterable-row">
                                        <td><span class="bs-coa-pill">{{ $item->coa_code }}</span></td>
                                        <td class="fw-semibold">{{ $item->coa_name }}</td>
                                        <td class="text-center bs-mono">{{ $item->jumlah_jurnal }}</td>
                                        <td class="text-end bs-mono fw-semibold text-success">
                                            {{ number_format((int) $item->saldo, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3 opacity-75">Belum ada mutasi akun ekuitas pada periode ini.</td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <td><span class="bs-coa-pill">PL-YTD</span></td>
                                    <td class="fw-semibold">{{ $labaBerjalan >= 0 ? 'Laba Periode Berjalan' : 'Rugi Periode Berjalan' }}</td>
                                    <td class="text-center bs-mono">-</td>
                                    <td class="text-end bs-mono fw-semibold {{ $labaBerjalan >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $labaBerjalan < 0 ? '-' : '' }}{{ number_format(abs($labaBerjalan), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="bs-subtotal-row">
                                    <td colspan="3" class="text-end text-uppercase">Subtotal Ekuitas (+ Laba/Rugi)</td>
                                    <td class="text-end bs-mono text-success">
                                        Rp {{ number_format($totEkuitas + $labaBerjalan, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr class="bs-grand-row">
                                    <td colspan="3" class="text-end text-uppercase">Total Kewajiban + Ekuitas</td>
                                    <td class="text-end bs-mono text-primary" id="totalLiab">
                                        Rp {{ number_format($totKewEkuitas, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- GRAFIK VISUAL -->
<div class="card ent-card mb-3">
    <div class="card-header bg-transparent border-bottom p-3 p-md-4" style="border-color: var(--ent-grid-border) !important;">
        <h6 class="mb-0 fw-bold"><i class="fas fa-chart-bar me-2 text-primary"></i>Grafik Komponen Neraca (Aset, Kewajiban &amp; Ekuitas)</h6>
    </div>
    <div class="card-body p-3 p-md-4">
        <canvas id="balanceChart" height="95"></canvas>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    function parseDmyDate(dateStr) {
        if (!dateStr) return null;
        var parts = dateStr.trim().split("/");
        if (parts.length !== 3) return null;
        return new Date(parseInt(parts[2], 10), parseInt(parts[1], 10) - 1, parseInt(parts[0], 10));
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".js-searchable-select").forEach(function (selectEl) {
            if (!selectEl.dataset.choicesInitialized) {
                new Choices(selectEl, {
                    searchEnabled: true,
                    shouldSort: false,
                    removeItemButton: true,
                    placeholder: true,
                    placeholderValue: selectEl.options[0] ? selectEl.options[0].text : "Semua Project...",
                    searchPlaceholderValue: "Ketik nama project untuk mencari...",
                    noResultsText: "Project tidak ditemukan",
                    noChoicesText: "Tidak ada project tersedia",
                    itemSelectText: "Tekan untuk pilih"
                });
                selectEl.dataset.choicesInitialized = "true";
            }
        });

        const ctx = document.getElementById('balanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Aset', 'Total Kewajiban', 'Total Ekuitas (+ Laba/Rugi)'],
                datasets: [{
                    label: 'Nilai (Rp)',
                    data: [
                        {{ $totAset }},
                        {{ $totKewajiban }},
                        {{ $totEkuitas + $labaBerjalan }}
                    ],
                    backgroundColor: [
                        'rgba(2, 132, 199, 0.75)',
                        'rgba(225, 29, 72, 0.75)',
                        'rgba(5, 150, 105, 0.75)'
                    ],
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                var val = Number(context.raw || 0);
                                return 'Rp ' + val.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (val) {
                                return 'Rp ' + Number(val).toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    });

    $(document).on("submit", "#form-bs-filter", function (e) {
        var awal = document.getElementById("bs_tanggal_awal").value;
        var akhir = document.getElementById("bs_tanggal_akhir").value;
        var dStart = parseDmyDate(awal);
        var dEnd = parseDmyDate(akhir);

        if (dStart && dEnd && dStart > dEnd) {
            e.preventDefault();
            Swal.fire({
                icon: "warning",
                title: "Rentang Tanggal Tidak Valid",
                text: "Tanggal Awal tidak boleh melebihi Tanggal Akhir."
            });
        }
    });

    $(document).on("keyup", "#filter-bs-account", function () {
        var keyword = $(this).val().toLowerCase().trim();
        $("table.bs-table tbody tr.bs-filterable-row").each(function () {
            var text = $(this).text().toLowerCase();
            $(this).toggle(keyword === "" || text.indexOf(keyword) !== -1);
        });
    });
</script>
@endsection
