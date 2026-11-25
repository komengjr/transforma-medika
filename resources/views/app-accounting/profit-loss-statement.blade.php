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

    .pl-summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }

    .pl-stat-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        padding: 14px 16px;
        background-color: rgba(79, 70, 229, 0.03);
    }

    .pl-stat-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        opacity: 0.72;
        display: block;
        margin-bottom: 4px;
    }

    .pl-stat-value {
        font-family: 'JetBrains Mono', monospace;
        font-size: 1.02rem;
        font-weight: 700;
    }

    .pl-section-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 18px;
    }

    .pl-section-header {
        padding: 11px 16px;
        font-weight: 700;
        font-size: 0.86rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .pl-table {
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.82rem;
        margin-bottom: 0;
    }

    .pl-table thead th {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        color: #ffffff;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 10px 12px;
        border-color: rgba(99, 102, 241, 0.35);
        white-space: nowrap;
    }

    .pl-table tbody td {
        padding: 8px 12px;
        vertical-align: middle;
        border-color: rgba(148, 163, 184, 0.22);
    }

    .pl-table tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.035);
    }

    .pl-subtotal-row td {
        background-color: rgba(79, 70, 229, 0.07) !important;
        border-top: 2px solid rgba(99, 102, 241, 0.35) !important;
        border-bottom: 1px solid rgba(99, 102, 241, 0.25) !important;
        font-weight: 700;
        padding: 10px 12px !important;
    }

    .pl-net-box {
        border: 2px solid #4f46e5;
        border-radius: 14px;
        padding: 16px 20px;
        background: rgba(79, 70, 229, 0.05);
    }

    .pl-mono {
        font-family: 'JetBrains Mono', monospace;
    }

    .pl-coa-pill {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
        background: rgba(79, 70, 229, 0.11);
        color: #4f46e5;
        border: 1px solid rgba(79, 70, 229, 0.25);
        display: inline-block;
    }

    [data-bs-theme="dark"] .pl-coa-pill,
    .dark .pl-coa-pill {
        color: #a5b4fc;
        background: rgba(129, 140, 248, 0.16);
    }

    @media print {
        .no-print {
            display: none !important;
        }
        .ent-card, .pl-section-box, .pl-net-box {
            box-shadow: none !important;
        }
    }
</style>
@endsection

@section('content')
@php
    $pendapatanList = collect($pendapatanItems ?? []);
    $bebanList      = collect($bebanItems ?? []);
    $totPendapatan  = (int) ($totalPendapatan ?? 0);
    $totBeban       = (int) ($totalBeban ?? 0);
    $netProfit      = (int) ($labaBersih ?? ($totPendapatan - $totBeban));
    $margin         = $marginPersen ?? ($totPendapatan > 0 ? round(($netProfit / $totPendapatan) * 100, 2) : 0);
    $isProfit       = $netProfit >= 0;
@endphp

<!-- HERO BANNER HEADER -->
<header class="mb-3 no-print">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width: 58px; height: 58px;">
                        <img src="{{ asset('img/profit.png') }}" alt="Profit Loss Icon" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                <i class="fas fa-chart-line"></i> {{ Env('APP_LABEL') }} MANAGEMENT SYSTEM
                            </span>
                            <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Menu: Profit &amp; Loss Statement</span>
                        </div>
                        <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: white;">
                            Laporan Laba Rugi Terpusat (Profit &amp; Loss)
                        </h4>
                        <p class="mb-0 small" style="color: #cbd5e1;">Rincian pendapatan (4xxx) dan beban (5xxx-9xxx) per akun COA dari jurnal terposting.</p>
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
                    <i class="fas fa-filter me-2 text-primary"></i>Filter Laporan Laba Rugi
                </h6>
                <small class="opacity-75">Pilih Project (ketik untuk mencari), Tanggal Awal, dan Tanggal Akhir lalu tekan Tampilkan.</small>
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-3 fw-semibold" onclick="window.print()">
                <i class="fas fa-print me-1"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">
        <form method="GET" action="{{ url()->current() }}" class="row g-3 align-items-end needs-validation" novalidate="" id="form-pl-filter">
            <div class="col-md-6 col-xl-4 position-relative">
                <label for="pl_project" class="ent-label">Project</label>
                <select class="form-select js-searchable-select" id="pl_project" name="project">
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
                <label for="pl_tanggal_awal" class="ent-label">Tanggal Awal</label>
                <input class="form-control ent-date-input datetimepicker" id="pl_tanggal_awal" name="tanggal_awal"
                    type="text" value="{{ $tanggal_awal ?? '' }}" placeholder="dd/mm/yyyy"
                    data-options='{"dateFormat":"d/m/Y","disableMobile":true}' />
            </div>

            <div class="col-md-6 col-xl-3 position-relative">
                <label for="pl_tanggal_akhir" class="ent-label">Tanggal Akhir</label>
                <input class="form-control ent-date-input datetimepicker" id="pl_tanggal_akhir" name="tanggal_akhir"
                    type="text" value="{{ $tanggal_akhir ?? '' }}" placeholder="dd/mm/yyyy"
                    data-options='{"dateFormat":"d/m/Y","disableMobile":true}' />
            </div>

            <div class="col-md-6 col-xl-2 d-grid">
                <button class="btn ent-btn ent-btn-primary py-2" type="submit" id="btnFilter">
                    <i class="fas fa-search me-1"></i> Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- LAPORAN LABA RUGI DETAIL -->
<div class="card ent-card mb-3">
    <div class="card-header bg-transparent border-bottom p-3 p-md-4" style="border-color: var(--ent-grid-border) !important;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5;">
                        <i class="fas fa-file-invoice"></i> INCOME STATEMENT
                    </span>
                    @if (!empty($project))
                        <span class="ent-badge" style="background: rgba(2, 132, 199, 0.12); color: #0284c7;">
                            {{ strtoupper($project) }}
                        </span>
                    @endif
                </div>
                <h6 class="mb-0 fw-bold">Rincian Laporan Laba Rugi</h6>
                <small class="opacity-75">
                    Periode: <strong>{{ !empty($tanggal_awal) ? $tanggal_awal : 'Semua Tanggal' }}</strong>
                    s/d <strong>{{ !empty($tanggal_akhir) ? $tanggal_akhir : 'Semua Tanggal' }}</strong>
                </small>
            </div>

            <div class="input-group input-group-sm no-print" style="width: 240px;">
                <span class="input-group-text bg-transparent"><i class="fas fa-search opacity-75"></i></span>
                <input type="text" id="filter-pl-account" class="form-control" placeholder="Cari Kode / Nama Akun...">
            </div>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">
        <!-- RINGKASAN KPI LABA RUGI -->
        <div class="pl-summary-grid">
            <div class="pl-stat-card" style="border-left: 4px solid #059669 !important;">
                <span class="pl-stat-label">Total Pendapatan</span>
                <span class="pl-stat-value text-success">Rp {{ number_format($totPendapatan, 0, ',', '.') }}</span>
            </div>

            <div class="pl-stat-card" style="border-left: 4px solid #d97706 !important;">
                <span class="pl-stat-label">Total Beban / Pengeluaran</span>
                <span class="pl-stat-value text-warning">Rp {{ number_format($totBeban, 0, ',', '.') }}</span>
            </div>

            <div class="pl-stat-card" style="border-left: 4px solid {{ $isProfit ? '#059669' : '#e11d48' }} !important;">
                <span class="pl-stat-label">{{ $isProfit ? 'Laba Bersih' : 'Rugi Bersih' }}</span>
                <span class="pl-stat-value {{ $isProfit ? 'text-success' : 'text-danger' }}">
                    {{ $netProfit < 0 ? '-' : '' }}Rp {{ number_format(abs($netProfit), 0, ',', '.') }}
                </span>
            </div>

            <div class="pl-stat-card" style="border-left: 4px solid #4f46e5 !important;">
                <span class="pl-stat-label">Margin Laba Bersih</span>
                <span class="pl-stat-value {{ $margin >= 0 ? 'text-primary' : 'text-danger' }}">
                    {{ number_format($margin, 2, ',', '.') }}%
                </span>
            </div>
        </div>

        <!-- 1. PENDAPATAN -->
        <div class="pl-section-box">
            <div class="pl-section-header" style="background: rgba(5, 150, 105, 0.1); border-bottom: 1px solid rgba(5, 150, 105, 0.25); color: #059669;">
                <span><i class="fas fa-arrow-circle-down me-2"></i>I. PENDAPATAN (REVENUE)</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                    {{ $pendapatanList->count() }} Akun
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered pl-table w-100" id="tablePendapatan">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 55px;">No</th>
                            <th style="width: 130px;">Kode COA</th>
                            <th>Nama Akun Pendapatan</th>
                            <th class="text-center" style="width: 105px;">Jurnal</th>
                            <th class="text-end" style="width: 150px;">Debit (Rp)</th>
                            <th class="text-end" style="width: 150px;">Kredit (Rp)</th>
                            <th class="text-end" style="width: 165px;">Saldo Bersih (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendapatanList as $idx => $item)
                            <tr class="pl-filterable-row">
                                <td class="text-center fw-bold">{{ $idx + 1 }}</td>
                                <td><span class="pl-coa-pill">{{ $item->coa_code }}</span></td>
                                <td class="fw-semibold">{{ $item->coa_name }}</td>
                                <td class="text-center pl-mono">{{ $item->jumlah_jurnal }}</td>
                                <td class="text-end pl-mono opacity-75">{{ number_format($item->total_debit, 0, ',', '.') }}</td>
                                <td class="text-end pl-mono opacity-75">{{ number_format($item->total_kredit, 0, ',', '.') }}</td>
                                <td class="text-end pl-mono fw-bold text-success">{{ number_format($item->saldo, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 opacity-75">Belum ada mutasi akun pendapatan pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="pl-subtotal-row">
                            <td colspan="4" class="text-end text-uppercase">Subtotal Pendapatan</td>
                            <td class="text-end pl-mono">{{ number_format($pendapatanList->sum('total_debit'), 0, ',', '.') }}</td>
                            <td class="text-end pl-mono">{{ number_format($pendapatanList->sum('total_kredit'), 0, ',', '.') }}</td>
                            <td class="text-end pl-mono text-success">Rp {{ number_format($totPendapatan, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- 2. BEBAN / PENGELUARAN -->
        <div class="pl-section-box">
            <div class="pl-section-header" style="background: rgba(217, 119, 6, 0.1); border-bottom: 1px solid rgba(217, 119, 6, 0.25); color: #b45309;">
                <span><i class="fas fa-arrow-circle-up me-2"></i>II. BEBAN / PENGELUARAN (EXPENSES)</span>
                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">
                    {{ $bebanList->count() }} Akun
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered pl-table w-100" id="tableBeban">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 55px;">No</th>
                            <th style="width: 130px;">Kode COA</th>
                            <th>Nama Akun Beban</th>
                            <th class="text-center" style="width: 105px;">Jurnal</th>
                            <th class="text-end" style="width: 150px;">Debit (Rp)</th>
                            <th class="text-end" style="width: 150px;">Kredit (Rp)</th>
                            <th class="text-end" style="width: 165px;">Saldo Bersih (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bebanList as $idx => $item)
                            <tr class="pl-filterable-row">
                                <td class="text-center fw-bold">{{ $idx + 1 }}</td>
                                <td><span class="pl-coa-pill">{{ $item->coa_code }}</span></td>
                                <td class="fw-semibold">{{ $item->coa_name }}</td>
                                <td class="text-center pl-mono">{{ $item->jumlah_jurnal }}</td>
                                <td class="text-end pl-mono opacity-75">{{ number_format($item->total_debit, 0, ',', '.') }}</td>
                                <td class="text-end pl-mono opacity-75">{{ number_format($item->total_kredit, 0, ',', '.') }}</td>
                                <td class="text-end pl-mono fw-bold text-danger">{{ number_format($item->saldo, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 opacity-75">Belum ada mutasi akun beban pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="pl-subtotal-row">
                            <td colspan="4" class="text-end text-uppercase">Subtotal Beban / Pengeluaran</td>
                            <td class="text-end pl-mono">{{ number_format($bebanList->sum('total_debit'), 0, ',', '.') }}</td>
                            <td class="text-end pl-mono">{{ number_format($bebanList->sum('total_kredit'), 0, ',', '.') }}</td>
                            <td class="text-end pl-mono text-danger">Rp {{ number_format($totBeban, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- 3. RINGKASAN LABA / RUGI BERSIH -->
        <div class="pl-net-box">
            <div class="row align-items-center gy-2">
                <div class="col-md-7">
                    <div class="text-uppercase fw-bold small opacity-75">Hasil Akhir Periode</div>
                    <h5 class="mb-0 fw-bold">
                        {{ $isProfit ? 'LABA BERSIH OPERASIONAL (NET PROFIT)' : 'RUGI BERSIH OPERASIONAL (NET LOSS)' }}
                    </h5>
                    <small class="opacity-75">
                        Total Pendapatan (Rp {{ number_format($totPendapatan, 0, ',', '.') }}) &minus; Total Beban (Rp {{ number_format($totBeban, 0, ',', '.') }})
                    </small>
                </div>
                <div class="col-md-5 text-md-end">
                    <div class="pl-mono fw-bold fs-4 {{ $isProfit ? 'text-success' : 'text-danger' }}">
                        {{ $netProfit < 0 ? '-' : '' }}Rp {{ number_format(abs($netProfit), 0, ',', '.') }}
                    </div>
                    <small class="fw-semibold opacity-75">Margin: {{ number_format($margin, 2, ',', '.') }}%</small>
                </div>
            </div>
        </div>
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
    });

    $(document).on("submit", "#form-pl-filter", function (e) {
        var awal = document.getElementById("pl_tanggal_awal").value;
        var akhir = document.getElementById("pl_tanggal_akhir").value;
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

    $(document).on("keyup", "#filter-pl-account", function () {
        var keyword = $(this).val().toLowerCase().trim();
        $("table.pl-table tbody tr.pl-filterable-row").each(function () {
            var text = $(this).text().toLowerCase();
            $(this).toggle(keyword === "" || text.indexOf(keyword) !== -1);
        });
    });
</script>
@endsection
