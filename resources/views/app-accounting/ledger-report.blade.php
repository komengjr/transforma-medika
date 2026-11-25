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

    .gl-summary-strip {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        gap: 12px;
        margin-bottom: 18px;
    }

    .gl-stat-box {
        border: 1px solid rgba(99, 102, 241, 0.25);
        border-radius: 12px;
        padding: 12px 15px;
        background-color: rgba(79, 70, 229, 0.03);
    }

    .gl-stat-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        opacity: 0.72;
        display: block;
        margin-bottom: 4px;
    }

    .gl-stat-value {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.98rem;
        font-weight: 700;
    }

    .gl-journal-table {
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.82rem;
    }

    .gl-journal-table thead th {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        color: #ffffff;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 11px 12px;
        border-color: rgba(99, 102, 241, 0.35);
        white-space: nowrap;
    }

    .gl-group-header-row {
        cursor: pointer;
        user-select: none;
    }

    .gl-group-header-row td {
        background-color: rgba(79, 70, 229, 0.07) !important;
        border-top: 2px solid rgba(79, 70, 229, 0.32) !important;
        border-bottom: 1px solid rgba(79, 70, 229, 0.2) !important;
        padding: 10px 12px !important;
        transition: background-color 0.15s ease;
    }

    .gl-group-header-row:hover td {
        background-color: rgba(79, 70, 229, 0.13) !important;
    }

    .gl-group-header-row.is-open td {
        background-color: rgba(79, 70, 229, 0.14) !important;
    }

    .gl-collapse-icon {
        width: 24px;
        height: 24px;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(79, 70, 229, 0.14);
        color: #4f46e5;
        font-size: 0.72rem;
        transition: transform 0.2s ease;
        flex-shrink: 0;
    }

    [data-bs-theme="dark"] .gl-collapse-icon,
    .dark .gl-collapse-icon {
        color: #a5b4fc;
        background: rgba(129, 140, 248, 0.2);
    }

    .gl-group-header-row.is-open .gl-collapse-icon {
        transform: rotate(90deg);
    }

    .gl-detail-child-row {
        display: none;
    }

    .gl-journal-table tr.is-expanded {
        display: table-row;
    }

    .gl-entry-row td {
        padding: 8px 12px !important;
        vertical-align: middle;
        border-color: rgba(148, 163, 184, 0.22) !important;
    }

    .gl-entry-row:hover td {
        background-color: rgba(79, 70, 229, 0.035);
    }

    .gl-account-cell {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
    }

    .gl-account-main {
        display: inline-flex;
        align-items: flex-start;
        gap: 7px;
        min-width: 0;
    }

    .gl-credit-indent {
        padding-left: 1.5rem !important;
    }

    .gl-credit-arrow {
        color: #0c6aee;
        font-weight: 700;
        line-height: 1.45;
        flex-shrink: 0;
    }

    .gl-subtotal-row td {
        background-color: rgba(148, 163, 184, 0.08) !important;
        border-top: 1px dashed rgba(99, 102, 241, 0.35) !important;
        border-bottom: 1px solid rgba(99, 102, 241, 0.25) !important;
        padding: 7px 12px !important;
        font-size: 0.78rem;
    }

    .gl-grandtotal-row td {
        background: rgba(15, 23, 42, 0.06) !important;
        border-top: 2px solid #4f46e5 !important;
        border-bottom: 2px solid #4f46e5 !important;
        padding: 11px 12px !important;
        font-size: 0.85rem;
    }

    .gl-mono {
        font-family: 'JetBrains Mono', monospace;
    }

    .gl-coa-pill {
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

    [data-bs-theme="dark"] .gl-coa-pill,
    .dark .gl-coa-pill {
        color: #a5b4fc;
        background: rgba(129, 140, 248, 0.16);
    }

    .gl-action-btn {
        border-radius: 8px;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 5px 10px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
</style>
@endsection

@section('content')
@php
    $collection = collect($reports ?? []);
    $groupedJournals = $collection->groupBy(function ($item) {
        return $item->id_acc_jurnal ?? ($item->acc_jurnal_id ?? ($item->acc_jurnal_no ?? uniqid()));
    });

    $grandTotalDebit = $collection->sum(fn($r) => (int) ($r->jurnal_debit ?? 0));
    $grandTotalKredit = $collection->sum(fn($r) => (int) ($r->jurnal_kredit ?? 0));
    $isAllBalanced = ($grandTotalDebit === $grandTotalKredit);
@endphp

<!-- HERO BANNER HEADER -->
<header class="mb-3">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width: 58px; height: 58px;">
                        <img src="{{ asset('img/ledger.png') }}" alt="Ledger Report Icon" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                <i class="fas fa-file-invoice-dollar"></i> {{ Env('APP_LABEL') }} MANAGEMENT SYSTEM
                            </span>
                            <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Menu: Ledger Report</span>
                        </div>
                        <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: white;">
                            Laporan Jurnal Terpusat (Posted)
                        </h4>
                        <p class="mb-0 small" style="color: #cbd5e1;">Rekapitulasi jurnal yang sudah dilaporkan dan diposting ke keuangan pusat lintas aplikasi.</p>
                    </div>
                </div>

                <div class="col-lg-4 text-lg-end">
                    <div class="ent-glass-pill px-3 py-2 d-inline-block text-start">
                        <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.6rem;">Sumber Data</span>
                        <span class="fw-bold small" style="color: #7dd3fc;">
                            <i class="fas fa-check-double me-1"></i> Pusat Keuangan (acc_jurnal)
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- FILTER CARD -->
<div class="card ent-card mb-3">
    <div class="ent-card-header">
        <div>
            <h6 class="mb-0 fw-bold">
                <i class="fas fa-filter me-2 text-primary"></i>Filter Laporan Jurnal Terpusat
            </h6>
            <small class="opacity-75">Pilih Project (ketik untuk mencari), Tanggal Awal, dan Tanggal Akhir lalu tekan Submit.</small>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">
        <form method="GET" action="{{ url()->current() }}" class="row g-3 align-items-end needs-validation" novalidate="" id="form-ledger-report-filter">
            <div class="col-md-6 col-xl-4 position-relative">
                <label for="report_project" class="ent-label">Project</label>
                <select class="form-select js-searchable-select" id="report_project" name="project">
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
                <label for="report_tanggal_awal" class="ent-label">Tanggal Awal</label>
                <input class="form-control ent-date-input datetimepicker" id="report_tanggal_awal" name="tanggal_awal"
                    type="text" value="{{ $tanggal_awal ?? '' }}" placeholder="dd/mm/yyyy"
                    data-options='{"dateFormat":"d/m/Y","disableMobile":true}' />
            </div>

            <div class="col-md-6 col-xl-3 position-relative">
                <label for="report_tanggal_akhir" class="ent-label">Tanggal Akhir</label>
                <input class="form-control ent-date-input datetimepicker" id="report_tanggal_akhir" name="tanggal_akhir"
                    type="text" value="{{ $tanggal_akhir ?? '' }}" placeholder="dd/mm/yyyy"
                    data-options='{"dateFormat":"d/m/Y","disableMobile":true}' />
            </div>

            <div class="col-md-6 col-xl-2 d-grid">
                <button class="btn ent-btn ent-btn-primary py-2" type="submit" id="button-submit-report">
                    <i class="fas fa-paper-plane me-1"></i> Submit
                </button>
            </div>
        </form>
    </div>
</div>

<!-- RESULT CARD -->
<div class="card ent-card mb-3">
    <div class="card-header bg-transparent border-bottom p-3 p-md-4" style="border-color: var(--ent-grid-border) !important;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="ent-badge" style="background: rgba(5, 150, 105, 0.14); color: #059669;">
                        <i class="fas fa-check-circle"></i> POSTED TO ACCOUNTING
                    </span>
                    @if (!empty($project))
                        <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5;">
                            {{ strtoupper($project) }}
                        </span>
                    @endif
                </div>
                <h6 class="mb-0 fw-bold">Hasil Data Jurnal Terlapor</h6>
                <small class="opacity-75">
                    Periode: <strong>{{ !empty($tanggal_awal) ? $tanggal_awal : 'Semua Tanggal' }}</strong>
                    s/d <strong>{{ !empty($tanggal_akhir) ? $tanggal_akhir : 'Semua Tanggal' }}</strong>
                    &bull; Klik baris transaksi untuk membuka/menutup detail COA
                </small>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button type="button" class="btn btn-outline-primary gl-action-btn" id="btn-expand-all-report">
                    <i class="fas fa-folder-open"></i> Buka Semua
                </button>
                <button type="button" class="btn btn-outline-secondary gl-action-btn" id="btn-collapse-all-report">
                    <i class="fas fa-folder"></i> Tutup Semua
                </button>
                <div class="input-group input-group-sm" style="width: 225px;">
                    <span class="input-group-text bg-transparent"><i class="fas fa-search opacity-75"></i></span>
                    <input type="text" id="filter-report-quick" class="form-control" placeholder="Cari No. ACC / Bukti / COA...">
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">
        <div class="gl-summary-strip">
            <div class="gl-stat-box">
                <span class="gl-stat-label">Jurnal Terlapor</span>
                <span class="gl-stat-value text-primary">{{ number_format($groupedJournals->count(), 0, ',', '.') }} Transaksi</span>
            </div>
            <div class="gl-stat-box">
                <span class="gl-stat-label">Total Mutasi Debit</span>
                <span class="gl-stat-value text-success">Rp {{ number_format($grandTotalDebit, 0, ',', '.') }}</span>
            </div>
            <div class="gl-stat-box">
                <span class="gl-stat-label">Total Mutasi Kredit</span>
                <span class="gl-stat-value text-danger">Rp {{ number_format($grandTotalKredit, 0, ',', '.') }}</span>
            </div>
            <div class="gl-stat-box">
                <span class="gl-stat-label">Status Keseimbangan</span>
                @if ($collection->count() === 0)
                    <span class="gl-stat-value opacity-50">-</span>
                @elseif ($isAllBalanced)
                    <span class="gl-stat-value text-success"><i class="fas fa-check-circle me-1"></i>BALANCED</span>
                @else
                    <span class="gl-stat-value text-danger">
                        <i class="fas fa-exclamation-triangle me-1"></i>Selisih Rp {{ number_format(abs($grandTotalDebit - $grandTotalKredit), 0, ',', '.') }}
                    </span>
                @endif
            </div>
        </div>

        @if ($groupedJournals->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered gl-journal-table w-100 mb-0" id="table-ledger-report">
                    <thead>
                        <tr>
                            <th style="width: 135px;">Tanggal</th>
                            <th style="width: 195px;">No. ACC / Bukti</th>
                            <th style="width: 145px;">Status Posting</th>
                            <th>Nama Akun &amp; Uraian Transaksi</th>
                            <th class="text-end" style="width: 155px;">Debit (Rp)</th>
                            <th class="text-end" style="width: 155px;">Kredit (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $trxNo = 1; @endphp
                        @foreach ($groupedJournals as $jurnalKey => $entries)
                            @php
                                $head = $entries->first();
                                $accNo = $head->acc_jurnal_no ?? ('ACC-' . $jurnalKey);
                                $noBukti = $head->jurnal_no_bukti ?? ($head->jurnal_ref_code ?? '-');
                                $srcProject = strtoupper($head->source_project ?? 'UMUM');
                                $keterangan = $head->jurnal_keterangan ?? '';
                                $cabang = $head->jurnal_cabang ?? '-';
                                $postedBy = $head->posted_by ?? ($head->jurnal_user ?? '-');
                                $postedAt = !empty($head->posted_at) ? \Carbon\Carbon::parse($head->posted_at)->format('d/m/Y H:i') : null;

                                $tglRaw = !empty($head->jurnal_tgl) ? $head->jurnal_tgl : null;
                                $tglFormatted = $tglRaw ? \Carbon\Carbon::parse($tglRaw)->format('d/m/Y') : '-';

                                $sortedEntries = $entries->sortBy(function ($item) {
                                    return ((int) ($item->jurnal_debit ?? 0) > 0) ? 0 : 1;
                                });

                                $subDebit = $entries->sum(fn($r) => (int) ($r->jurnal_debit ?? 0));
                                $subKredit = $entries->sum(fn($r) => (int) ($r->jurnal_kredit ?? 0));
                            @endphp

                            <tr class="gl-group-header-row" data-journal-group="{{ $jurnalKey }}" title="Klik untuk membuka/menutup detail COA">
                                <td class="fw-bold gl-mono">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="gl-collapse-icon">
                                            <i class="fas fa-chevron-right"></i>
                                        </span>
                                        <div>
                                            <span class="badge bg-dark text-white me-1">#{{ $trxNo++ }}</span>
                                            <span>{{ $tglFormatted }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary gl-mono">{{ $accNo }}</div>
                                    <small class="opacity-75 d-block">Bukti: {{ $noBukti }} &bull; {{ $srcProject }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                        <i class="fas fa-check-circle me-1"></i>Posted
                                    </span>
                                    @if ($postedAt)
                                        <small class="d-block opacity-75 mt-1">{{ $postedAt }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">
                                        {{ $keterangan !== '' ? $keterangan : ('Jurnal Terpusat ' . $srcProject) }}
                                    </div>
                                    <small class="opacity-75">
                                        <i class="fas fa-building me-1"></i>Cabang: <strong>{{ $cabang }}</strong>
                                        &nbsp;&bull;&nbsp;
                                        <i class="fas fa-user-check me-1"></i>Diposting oleh: <strong>{{ $postedBy }}</strong>
                                    </small>
                                </td>
                                <td class="text-end gl-mono fw-bold text-success">
                                    {{ number_format($subDebit, 0, ',', '.') }}
                                </td>
                                <td class="text-end gl-mono fw-bold text-danger">
                                    {{ number_format($subKredit, 0, ',', '.') }}
                                </td>
                            </tr>

                            @foreach ($sortedEntries as $line)
                                @php
                                    $debitVal = (int) ($line->jurnal_debit ?? 0);
                                    $kreditVal = (int) ($line->jurnal_kredit ?? 0);
                                    $isCredit = ($kreditVal > 0 && $debitVal === 0);
                                    $coaCode = $line->coa_code ?? '-';
                                    $coaName = $line->coa_name ?? ('Akun COA ' . $coaCode);
                                    $coaType = $line->coa_type ?? null;
                                @endphp
                                <tr class="gl-entry-row gl-detail-child-row" data-journal-group="{{ $jurnalKey }}">
                                    <td></td>
                                    <td class="text-end small opacity-60 gl-mono">
                                        {{ $isCredit ? 'Kredit' : 'Debit' }}
                                    </td>
                                    <td>
                                        <span class="gl-coa-pill">{{ $coaCode }}</span>
                                    </td>
                                    <td class="{{ $isCredit ? 'gl-credit-indent' : '' }}">
                                        <div class="gl-account-cell">
                                            <div class="gl-account-main">
                                                @if ($isCredit)
                                                    <span class="gl-credit-arrow" aria-hidden="true">↳</span>
                                                @endif
                                                <span class="fw-semibold">{{ $coaName }}</span>
                                            </div>
                                            @if (!empty($coaType))
                                                <span class="badge bg-light text-dark border text-uppercase flex-shrink-0" style="font-size: 0.62rem;">
                                                    {{ $coaType }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-end gl-mono fw-semibold {{ $debitVal > 0 ? 'text-success' : 'opacity-50' }}">
                                        {{ $debitVal > 0 ? number_format($debitVal, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="text-end gl-mono fw-semibold {{ $kreditVal > 0 ? 'text-danger' : 'opacity-50' }}">
                                        {{ $kreditVal > 0 ? number_format($kreditVal, 0, ',', '.') : '-' }}
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="gl-subtotal-row gl-detail-child-row" data-journal-group="{{ $jurnalKey }}">
                                <td colspan="4" class="text-end fw-semibold opacity-75">
                                    Subtotal Jurnal <span class="gl-mono">{{ $accNo }}</span>
                                </td>
                                <td class="text-end gl-mono fw-bold text-success">
                                    {{ number_format($subDebit, 0, ',', '.') }}
                                </td>
                                <td class="text-end gl-mono fw-bold text-danger">
                                    {{ number_format($subKredit, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="gl-grandtotal-row">
                            <td colspan="4" class="text-end fw-bold text-uppercase">
                                Total Keseluruhan ({{ $groupedJournals->count() }} Jurnal Terlapor)
                            </td>
                            <td class="text-end gl-mono fw-bold text-success">
                                Rp {{ number_format($grandTotalDebit, 0, ',', '.') }}
                            </td>
                            <td class="text-end gl-mono fw-bold text-danger">
                                Rp {{ number_format($grandTotalKredit, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="text-center py-5 opacity-75">
                <i class="fas fa-inbox fa-2x text-primary mb-2"></i>
                <div class="fw-bold">Belum Ada Jurnal Terlapor</div>
                <small>Silakan laporkan jurnal dari menu General Ledger atau sesuaikan filter Project dan tanggal.</small>
            </div>
        @endif
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

    function setReportGroupExpanded(jurnalKey, expanded) {
        const $headerRow = $('#table-ledger-report tbody tr.gl-group-header-row[data-journal-group="' + jurnalKey + '"]');
        const $childRows = $('#table-ledger-report tbody tr.gl-detail-child-row[data-journal-group="' + jurnalKey + '"]');
        $headerRow.toggleClass("is-open", expanded);
        $childRows.toggleClass("is-expanded", expanded);
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

    $(document).on("submit", "#form-ledger-report-filter", function (e) {
        var awal = document.getElementById("report_tanggal_awal").value;
        var akhir = document.getElementById("report_tanggal_akhir").value;
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

    $(document).on("click", "#table-ledger-report tbody tr.gl-group-header-row", function () {
        const jurnalKey = $(this).attr("data-journal-group");
        setReportGroupExpanded(jurnalKey, !$(this).hasClass("is-open"));
    });

    $(document).on("click", "#btn-expand-all-report", function () {
        $("#table-ledger-report tbody tr.gl-group-header-row:visible").each(function () {
            setReportGroupExpanded($(this).attr("data-journal-group"), true);
        });
    });

    $(document).on("click", "#btn-collapse-all-report", function () {
        $("#table-ledger-report tbody tr.gl-group-header-row").each(function () {
            setReportGroupExpanded($(this).attr("data-journal-group"), false);
        });
    });

    $(document).on("keyup", "#filter-report-quick", function () {
        const keyword = $(this).val().toLowerCase().trim();
        const groups = {};

        $("#table-ledger-report tbody tr[data-journal-group]").each(function () {
            const grp = $(this).attr("data-journal-group");
            if (!groups[grp]) {
                groups[grp] = { header: null, children: [], text: "" };
            }
            if ($(this).hasClass("gl-group-header-row")) {
                groups[grp].header = this;
            } else {
                groups[grp].children.push(this);
            }
            groups[grp].text += " " + $(this).text().toLowerCase();
        });

        Object.keys(groups).forEach(function (grp) {
            const matched = keyword === "" || groups[grp].text.indexOf(keyword) !== -1;
            $(groups[grp].header).toggle(matched);

            if (!matched) {
                $(groups[grp].children).removeClass("is-expanded").hide();
            } else if (keyword !== "") {
                $(groups[grp].header).addClass("is-open");
                $(groups[grp].children).addClass("is-expanded").show();
            } else {
                $(groups[grp].children).css("display", "");
            }
        });
    });
</script>
@endsection
