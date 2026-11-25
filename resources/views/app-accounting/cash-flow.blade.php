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

    .cf-summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }

    .cf-stat-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        padding: 14px 16px;
        background-color: rgba(79, 70, 229, 0.03);
    }

    .cf-stat-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        opacity: 0.72;
        display: block;
        margin-bottom: 4px;
    }

    .cf-stat-value {
        font-family: 'JetBrains Mono', monospace;
        font-size: 1rem;
        font-weight: 700;
    }

    .cf-table {
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.81rem;
        margin-bottom: 0;
    }

    .cf-table thead th {
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

    .cf-table tbody td {
        padding: 8px 11px;
        vertical-align: middle;
        border-color: rgba(148, 163, 184, 0.22);
    }

    .cf-group-row td {
        background-color: rgba(79, 70, 229, 0.08) !important;
        font-weight: 700;
        color: var(--ent-indigo);
    }

    .cf-subtotal-row td {
        background-color: rgba(14, 165, 233, 0.08) !important;
        border-top: 1px dashed rgba(14, 165, 233, 0.45) !important;
        border-bottom: 1px solid rgba(14, 165, 233, 0.3) !important;
        font-weight: 700;
    }

    .cf-grand-row td {
        background: rgba(15, 23, 42, 0.06) !important;
        border-top: 2px solid #4f46e5 !important;
        border-bottom: 2px solid #4f46e5 !important;
        font-weight: 700;
        padding: 10px 11px !important;
    }

    .cf-mono {
        font-family: 'JetBrains Mono', monospace;
    }

    .cf-coa-pill {
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

    [data-bs-theme="dark"] .cf-coa-pill,
    .dark .cf-coa-pill {
        color: #a5b4fc;
        background: rgba(129, 140, 248, 0.16);
    }

    @media print {
        .no-print {
            display: none !important;
        }

        .ent-card {
            box-shadow: none !important;
        }
    }
</style>
@endsection

@section('content')
@php
$opList = collect($operasiItems ?? []);
$invList = collect($investasiItems ?? []);
$finList = collect($pendanaanItems ?? []);
$cOp = (int) ($kasOperasi ?? 0);
$cInv = (int) ($kasInvestasi ?? 0);
$cFin = (int) ($kasPendanaan ?? 0);
$netChange = (int) ($kenaikanKasBersih ?? ($cOp + $cInv + $cFin));
$begCash = (int) ($saldoKasAwal ?? 0);
$endCash = (int) ($saldoKasAkhir ?? ($begCash + $netChange));
@endphp

<!-- HERO BANNER HEADER -->
<header class="mb-3 no-print">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width: 58px; height: 58px;">
                        <img src="{{ asset('img/capital.png') }}" alt="Cash Flow Icon" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                <i class="fas fa-water"></i> {{ Env('APP_LABEL') }} MANAGEMENT SYSTEM
                            </span>
                            <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Menu: Cash Flow Statement</span>
                        </div>
                        <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: white;">
                            Laporan Arus Kas Terpusat (Cash Flow)
                        </h4>
                        <p class="mb-0 small" style="color: #cbd5e1;">Arus kas masuk dan keluar dari aktivitas operasi, investasi, dan pendanaan pada jurnal terposting.</p>
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
                    <i class="fas fa-filter me-2 text-primary"></i>Filter Laporan Arus Kas
                </h6>
                <small class="opacity-75">Pilih Project (ketik untuk mencari), Tanggal Awal, dan Tanggal Akhir lalu tekan Tampilkan.</small>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-success btn-sm rounded-3 fw-semibold" onclick="exportCashFlowCsv()">
                    <i class="fas fa-file-csv me-1"></i> Export CSV
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-3 fw-semibold" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> Cetak Laporan
                </button>
            </div>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">
        <form method="GET" action="{{ url()->current() }}" class="row g-3 align-items-end needs-validation" novalidate="" id="form-cf-filter">
            <div class="col-md-6 col-xl-4 position-relative">
                <label for="cf_project" class="ent-label">Project</label>
                <select class="form-select js-searchable-select" id="cf_project" name="project">
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
                <label for="cf_tanggal_awal" class="ent-label">Tanggal Awal</label>
                <input class="form-control ent-date-input datetimepicker" id="cf_tanggal_awal" name="tanggal_awal"
                    type="text" value="{{ $tanggal_awal ?? '' }}" placeholder="dd/mm/yyyy"
                    data-options='{"dateFormat":"d/m/Y","disableMobile":true}' />
            </div>

            <div class="col-md-6 col-xl-3 position-relative">
                <label for="cf_tanggal_akhir" class="ent-label">Tanggal Akhir</label>
                <input class="form-control ent-date-input datetimepicker" id="cf_tanggal_akhir" name="tanggal_akhir"
                    type="text" value="{{ $tanggal_akhir ?? '' }}" placeholder="dd/mm/yyyy"
                    data-options='{"dateFormat":"d/m/Y","disableMobile":true}' />
            </div>

            <div class="col-md-6 col-xl-2 d-grid">
                <button class="btn ent-btn ent-btn-primary py-2" type="submit" id="btnFilterCashFlow">
                    <i class="fas fa-search me-1"></i> Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- RINGKASAN & TABEL ARUS KAS -->
<div class="card ent-card mb-3">
    <div class="card-header bg-transparent border-bottom p-3 p-md-4" style="border-color: var(--ent-grid-border) !important;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5;">
                        <i class="fas fa-exchange-alt"></i> STATEMENT OF CASH FLOWS
                    </span>
                    @if (!empty($project))
                    <span class="ent-badge" style="background: rgba(2, 132, 199, 0.12); color: #0284c7;">
                        {{ strtoupper($project) }}
                    </span>
                    @endif
                </div>
                <h6 class="mb-0 fw-bold" id="periodeText">
                    Rincian Arus Kas &mdash; Periode: {{ !empty($tanggal_awal) ? $tanggal_awal : 'Semua Tanggal' }}
                    s/d {{ !empty($tanggal_akhir) ? $tanggal_akhir : 'Semua Tanggal' }}
                </h6>
            </div>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">
        <!-- KPI SUMMARY -->
        <div class="cf-summary-grid">
            <div class="cf-stat-card" style="border-left: 4px solid #0284c7 !important;">
                <span class="cf-stat-label">Arus Kas Operasi</span>
                <span class="cf-stat-value {{ $cOp >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ $cOp < 0 ? '-' : '' }}Rp {{ number_format(abs($cOp), 0, ',', '.') }}
                </span>
            </div>

            <div class="cf-stat-card" style="border-left: 4px solid #d97706 !important;">
                <span class="cf-stat-label">Arus Kas Investasi</span>
                <span class="cf-stat-value {{ $cInv >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ $cInv < 0 ? '-' : '' }}Rp {{ number_format(abs($cInv), 0, ',', '.') }}
                </span>
            </div>

            <div class="cf-stat-card" style="border-left: 4px solid #4f46e5 !important;">
                <span class="cf-stat-label">Arus Kas Pendanaan</span>
                <span class="cf-stat-value {{ $cFin >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ $cFin < 0 ? '-' : '' }}Rp {{ number_format(abs($cFin), 0, ',', '.') }}
                </span>
            </div>

            <div class="cf-stat-card" style="border-left: 4px solid #059669 !important;">
                <span class="cf-stat-label">Saldo Kas Akhir</span>
                <span class="cf-stat-value {{ $endCash >= 0 ? 'text-primary' : 'text-danger' }}">
                    {{ $endCash < 0 ? '-' : '' }}Rp {{ number_format(abs($endCash), 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div class="row g-3">
            <!-- TABEL ARUS KAS -->
            <div class="col-lg-7">
                <div class="border rounded-4 overflow-hidden" style="border-color: var(--ent-grid-border) !important;">
                    <div class="table-responsive">
                        <table id="cashFlowTable" class="table table-bordered cf-table w-100">
                            <thead>
                                <tr>
                                    <th style="width: 115px;">Kode COA</th>
                                    <th>Uraian / Aktivitas Arus Kas</th>
                                    <th class="text-end" style="width: 165px;">Nilai (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- 1. OPERASI -->
                                <tr class="cf-group-row">
                                    <td colspan="3"><i class="fas fa-briefcase me-1"></i> I. Arus Kas dari Aktivitas Operasi</td>
                                </tr>
                                @forelse ($opList as $row)
                                <tr>
                                    <td><span class="cf-coa-pill">{{ $row->coa_code }}</span></td>
                                    <td class="fw-semibold">{{ $row->coa_name }}</td>
                                    <td class="text-end cf-mono fw-semibold {{ $row->nominal >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $row->nominal < 0 ? '-' : '' }}{{ number_format(abs((int) $row->nominal), 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-2 opacity-75">Tidak ada mutasi kas aktivitas operasi pada periode ini.</td>
                                </tr>
                                @endforelse
                                <tr class="cf-subtotal-row">
                                    <td colspan="2" class="text-end">Kas Bersih dari Aktivitas Operasi</td>
                                    <td class="text-end cf-mono {{ $cOp >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $cOp < 0 ? '-' : '' }}{{ number_format(abs($cOp), 0, ',', '.') }}
                                    </td>
                                </tr>

                                <!-- 2. INVESTASI -->
                                <tr class="cf-group-row">
                                    <td colspan="3"><i class="fas fa-industry me-1"></i> II. Arus Kas dari Aktivitas Investasi</td>
                                </tr>
                                @forelse ($invList as $row)
                                <tr>
                                    <td><span class="cf-coa-pill">{{ $row->coa_code }}</span></td>
                                    <td class="fw-semibold">{{ $row->coa_name }}</td>
                                    <td class="text-end cf-mono fw-semibold {{ $row->nominal >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $row->nominal < 0 ? '-' : '' }}{{ number_format(abs((int) $row->nominal), 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-2 opacity-75">Tidak ada mutasi kas aktivitas investasi pada periode ini.</td>
                                </tr>
                                @endforelse
                                <tr class="cf-subtotal-row">
                                    <td colspan="2" class="text-end">Kas Bersih dari Aktivitas Investasi</td>
                                    <td class="text-end cf-mono {{ $cInv >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $cInv < 0 ? '-' : '' }}{{ number_format(abs($cInv), 0, ',', '.') }}
                                    </td>
                                </tr>

                                <!-- 3. PENDANAAN -->
                                <tr class="cf-group-row">
                                    <td colspan="3"><i class="fas fa-hand-holding-usd me-1"></i> III. Arus Kas dari Aktivitas Pendanaan</td>
                                </tr>
                                @forelse ($finList as $row)
                                <tr>
                                    <td><span class="cf-coa-pill">{{ $row->coa_code }}</span></td>
                                    <td class="fw-semibold">{{ $row->coa_name }}</td>
                                    <td class="text-end cf-mono fw-semibold {{ $row->nominal >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $row->nominal < 0 ? '-' : '' }}{{ number_format(abs((int) $row->nominal), 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-2 opacity-75">Tidak ada mutasi kas aktivitas pendanaan pada periode ini.</td>
                                </tr>
                                @endforelse
                                <tr class="cf-subtotal-row">
                                    <td colspan="2" class="text-end">Kas Bersih dari Aktivitas Pendanaan</td>
                                    <td class="text-end cf-mono {{ $cFin >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $cFin < 0 ? '-' : '' }}{{ number_format(abs($cFin), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-end fw-bold">Kenaikan / (Penurunan) Kas Bersih</td>
                                    <td class="text-end cf-mono fw-bold {{ $netChange >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $netChange < 0 ? '-' : '' }}Rp {{ number_format(abs($netChange), 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end fw-semibold">Saldo Kas Awal Periode</td>
                                    <td class="text-end cf-mono fw-semibold">
                                        {{ $begCash < 0 ? '-' : '' }}Rp {{ number_format(abs($begCash), 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr class="cf-grand-row">
                                    <td colspan="2" class="text-end text-uppercase">Saldo Kas Akhir Periode</td>
                                    <td class="text-end cf-mono text-primary">
                                        {{ $endCash < 0 ? '-' : '' }}Rp {{ number_format(abs($endCash), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- GRAFIK & KETERANGAN -->
            <div class="col-lg-5 d-flex flex-column gap-3">
                <div class="border rounded-4 p-3" style="border-color: var(--ent-grid-border) !important;">
                    <h6 class="fw-bold mb-1"><i class="fas fa-chart-bar me-1 text-primary"></i> Grafik Arus Kas Bersih per Aktivitas</h6>
                    <small class="opacity-75 d-block mb-3">Perbandingan arus kas masuk/keluar bersih pada periode terpilih.</small>
                    <canvas id="cashFlowChart" height="175"></canvas>
                </div>

                <div class="border rounded-4 p-3" style="border-color: var(--ent-grid-border) !important;">
                    <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-1 text-primary"></i> Keterangan Aktivitas</h6>
                    <ul class="mb-0 ps-3 small">
                        <li class="mb-1"><strong>Aktivitas Operasi:</strong> Arus kas dari pendapatan, beban operasional, piutang, persediaan, dan hutang usaha.</li>
                        <li class="mb-1"><strong>Aktivitas Investasi:</strong> Arus kas dari perolehan atau pelepasan aset tetap dan investasi jangka panjang.</li>
                        <li><strong>Aktivitas Pendanaan:</strong> Arus kas dari pinjaman, modal/ekuitas, prive, atau dividen.</li>
                    </ul>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    function parseDmyDate(dateStr) {
        if (!dateStr) return null;
        var parts = dateStr.trim().split("/");
        if (parts.length !== 3) return null;
        return new Date(parseInt(parts[2], 10), parseInt(parts[1], 10) - 1, parseInt(parts[0], 10));
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".js-searchable-select").forEach(function(selectEl) {
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

        const ctx = document.getElementById('cashFlowChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Operasi', 'Investasi', 'Pendanaan'],
                datasets: [{
                    label: 'Arus Kas Bersih (Rp)',
                    data: [{
                        {
                            $cOp
                        }
                    }, {
                        {
                            $cInv
                        }
                    }, {
                        {
                            $cFin
                        }
                    }],
                    backgroundColor: [
                        'rgba(2, 132, 199, 0.75)',
                        'rgba(217, 119, 6, 0.75)',
                        'rgba(79, 70, 229, 0.75)'
                    ],
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var val = Number(context.raw || 0);
                                return (val < 0 ? '-Rp ' : 'Rp ') + Math.abs(val).toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(val) {
                                var num = Number(val);
                                return (num < 0 ? '-Rp ' : 'Rp ') + Math.abs(num).toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    });

    $(document).on("submit", "#form-cf-filter", function(e) {
        var awal = document.getElementById("cf_tanggal_awal").value;
        var akhir = document.getElementById("cf_tanggal_akhir").value;
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

    function exportCashFlowCsv() {
        var table = document.getElementById("cashFlowTable");
        if (!table) return;
        var csvRows = [];
        for (var i = 0; i < table.rows.length; i++) {
            var cols = [];
            for (var j = 0; j < table.rows[i].cells.length; j++) {
                var txt = table.rows[i].cells[j].innerText.replace(/\s+/g, " ").trim().replace(/"/g, '""');
                cols.push('"' + txt + '"');
            }
            csvRows.push(cols.join(","));
        }
        var blob = new Blob([csvRows.join("\n")], {
            type: "text/csv;charset=utf-8;"
        });
        var url = URL.createObjectURL(blob);
        var a = document.createElement("a");
        a.href = url;
        a.download = "laporan-arus-kas.csv";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }
</script>
@endsection
