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

    .cs-summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }

    .cs-stat-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        padding: 14px 16px;
        background-color: rgba(79, 70, 229, 0.03);
    }

    .cs-stat-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        opacity: 0.72;
        display: block;
        margin-bottom: 4px;
    }

    .cs-stat-value {
        font-family: 'JetBrains Mono', monospace;
        font-size: 1rem;
        font-weight: 700;
    }

    .cs-table {
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.82rem;
        margin-bottom: 0;
    }

    .cs-table thead th {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        color: #ffffff;
        font-size: 0.71rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 10px 12px;
        border-color: rgba(99, 102, 241, 0.35);
        white-space: nowrap;
    }

    .cs-table tbody td {
        padding: 9px 12px;
        vertical-align: middle;
        border-color: rgba(148, 163, 184, 0.22);
    }

    .cs-table tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.035);
    }

    .cs-subtotal-row td {
        background-color: rgba(79, 70, 229, 0.07) !important;
        border-top: 1px dashed rgba(99, 102, 241, 0.4) !important;
        border-bottom: 1px solid rgba(99, 102, 241, 0.25) !important;
        font-weight: 700;
        padding: 9px 12px !important;
    }

    .cs-grand-row td {
        background: rgba(15, 23, 42, 0.06) !important;
        border-top: 2px solid #4f46e5 !important;
        border-bottom: 2px solid #4f46e5 !important;
        font-weight: 700;
        padding: 11px 12px !important;
        font-size: 0.86rem;
    }

    .cs-mono {
        font-family: 'JetBrains Mono', monospace;
    }

    .cs-coa-pill {
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

    [data-bs-theme="dark"] .cs-coa-pill,
    .dark .cs-coa-pill {
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
    $mAwal       = (int) ($modalAwal ?? 0);
    $tInvestasi  = (int) ($tambahanInvestasi ?? 0);
    $pPrive      = (int) ($privePenarikan ?? 0);
    $labaPeriode = (int) ($labaBersihPeriode ?? 0);
    $kenaikan    = (int) ($kenaikanModal ?? ($tInvestasi - $pPrive + $labaPeriode));
    $mAkhir      = (int) ($modalAkhir ?? ($mAwal + $kenaikan));
    $detailsList = collect($ekuitasDetails ?? []);
@endphp

<!-- HERO BANNER HEADER -->
<header class="mb-3 no-print">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width: 58px; height: 58px;">
                        <img src="{{ asset('img/capital.png') }}" alt="Capital Statement Icon" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                <i class="fas fa-layer-group"></i> {{ Env('APP_LABEL') }} MANAGEMENT SYSTEM
                            </span>
                            <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Menu: Capital Statement</span>
                        </div>
                        <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: white;">
                            Laporan Perubahan Modal (Capital Statement)
                        </h4>
                        <p class="mb-0 small" style="color: #cbd5e1;">Rekonsiliasi Modal Awal, Tambahan Investasi, Prive, dan Laba/Rugi Bersih menuju Modal Akhir.</p>
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
                    <i class="fas fa-filter me-2 text-primary"></i>Filter Laporan Perubahan Modal
                </h6>
                <small class="opacity-75">Pilih Project (ketik untuk mencari), Tanggal Awal, dan Tanggal Akhir lalu tekan Tampilkan.</small>
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-3 fw-semibold" onclick="window.print()">
                <i class="fas fa-print me-1"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">
        <form method="GET" action="{{ url()->current() }}" class="row g-3 align-items-end needs-validation" novalidate="" id="form-cs-filter">
            <div class="col-md-6 col-xl-4 position-relative">
                <label for="cs_project" class="ent-label">Project</label>
                <select class="form-select js-searchable-select" id="cs_project" name="project">
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
                <label for="cs_tanggal_awal" class="ent-label">Tanggal Awal</label>
                <input class="form-control ent-date-input datetimepicker" id="cs_tanggal_awal" name="tanggal_awal"
                    type="text" value="{{ $tanggal_awal ?? '' }}" placeholder="dd/mm/yyyy"
                    data-options='{"dateFormat":"d/m/Y","disableMobile":true}' />
            </div>

            <div class="col-md-6 col-xl-3 position-relative">
                <label for="cs_tanggal_akhir" class="ent-label">Tanggal Akhir</label>
                <input class="form-control ent-date-input datetimepicker" id="cs_tanggal_akhir" name="tanggal_akhir"
                    type="text" value="{{ $tanggal_akhir ?? '' }}" placeholder="dd/mm/yyyy"
                    data-options='{"dateFormat":"d/m/Y","disableMobile":true}' />
            </div>

            <div class="col-md-6 col-xl-2 d-grid">
                <button class="btn ent-btn ent-btn-primary py-2" type="submit" id="btnFilterCapital">
                    <i class="fas fa-search me-1"></i> Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- RINGKASAN & TABEL PERUBAHAN MODAL -->
<div class="card ent-card mb-3">
    <div class="card-header bg-transparent border-bottom p-3 p-md-4" style="border-color: var(--ent-grid-border) !important;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5;">
                        <i class="fas fa-file-signature"></i> STATEMENT OF CHANGES IN EQUITY
                    </span>
                    @if (!empty($project))
                        <span class="ent-badge" style="background: rgba(2, 132, 199, 0.12); color: #0284c7;">
                            {{ strtoupper($project) }}
                        </span>
                    @endif
                </div>
                <h6 class="mb-0 fw-bold">Ikhtisar &amp; Rincian Perubahan Modal</h6>
                <small class="opacity-75">
                    Periode: <strong>{{ !empty($tanggal_awal) ? $tanggal_awal : 'Semua Tanggal' }}</strong>
                    s/d <strong>{{ !empty($tanggal_akhir) ? $tanggal_akhir : 'Semua Tanggal' }}</strong>
                </small>
            </div>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">
        <!-- KPI SUMMARY -->
        <div class="cs-summary-grid">
            <div class="cs-stat-card" style="border-left: 4px solid #4f46e5 !important;">
                <span class="cs-stat-label">Modal Awal Periode</span>
                <span class="cs-stat-value text-primary">Rp {{ number_format($mAwal, 0, ',', '.') }}</span>
            </div>

            <div class="cs-stat-card" style="border-left: 4px solid #0284c7 !important;">
                <span class="cs-stat-label">Tambahan Investasi / Modal</span>
                <span class="cs-stat-value text-info">+ Rp {{ number_format($tInvestasi, 0, ',', '.') }}</span>
            </div>

            <div class="cs-stat-card" style="border-left: 4px solid #e11d48 !important;">
                <span class="cs-stat-label">Prive / Penarikan Modal</span>
                <span class="cs-stat-value text-danger">- Rp {{ number_format($pPrive, 0, ',', '.') }}</span>
            </div>

            <div class="cs-stat-card" style="border-left: 4px solid {{ $labaPeriode >= 0 ? '#059669' : '#e11d48' }} !important;">
                <span class="cs-stat-label">{{ $labaPeriode >= 0 ? 'Laba Bersih Berjalan' : 'Rugi Bersih Berjalan' }}</span>
                <span class="cs-stat-value {{ $labaPeriode >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ $labaPeriode < 0 ? '-' : '+' }} Rp {{ number_format(abs($labaPeriode), 0, ',', '.') }}
                </span>
            </div>

            <div class="cs-stat-card" style="border-left: 4px solid #059669 !important;">
                <span class="cs-stat-label">Total Modal Akhir</span>
                <span class="cs-stat-value text-success">Rp {{ number_format($mAkhir, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="row g-3">
            <!-- TABEL LAPORAN PERUBAHAN MODAL -->
            <div class="col-lg-6">
                <div class="border rounded-4 overflow-hidden h-100" style="border-color: var(--ent-grid-border) !important;">
                    <div class="px-3 py-2 fw-bold small" style="background: rgba(79, 70, 229, 0.09); border-bottom: 1px solid var(--ent-grid-border);">
                        <i class="fas fa-list-ol me-1 text-primary"></i> Komponen Perubahan Modal
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered cs-table w-100">
                            <thead>
                                <tr>
                                    <th>Komponen Ekuitas</th>
                                    <th class="text-end" style="width: 175px;">Nominal (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-semibold">Modal Awal Periode</td>
                                    <td class="text-end cs-mono fw-bold">{{ number_format($mAwal, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="fw-semibold">Penambahan Modal / Setoran Investasi</span>
                                        <small class="d-block opacity-75">Mutasi kredit akun kelompok Ekuitas (3xxx)</small>
                                    </td>
                                    <td class="text-end cs-mono fw-semibold text-success">+ {{ number_format($tInvestasi, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="fw-semibold">Penarikan Modal / Prive</span>
                                        <small class="d-block opacity-75">Mutasi debit akun Ekuitas / Prive</small>
                                    </td>
                                    <td class="text-end cs-mono fw-semibold text-danger">- {{ number_format($pPrive, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="fw-semibold">{{ $labaPeriode >= 0 ? 'Laba Bersih Periode Berjalan' : 'Rugi Bersih Periode Berjalan' }}</span>
                                        <small class="d-block opacity-75">Selisih Pendapatan dan Beban periode berjalan</small>
                                    </td>
                                    <td class="text-end cs-mono fw-semibold {{ $labaPeriode >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $labaPeriode < 0 ? '-' : '+' }} {{ number_format(abs($labaPeriode), 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr class="cs-subtotal-row">
                                    <td class="text-end text-uppercase">Kenaikan / (Penurunan) Bersih Modal</td>
                                    <td class="text-end cs-mono {{ $kenaikan >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $kenaikan < 0 ? '-' : '+' }} {{ number_format(abs($kenaikan), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="cs-grand-row">
                                    <td class="text-uppercase">Total Modal Akhir</td>
                                    <td class="text-end cs-mono text-primary" id="totalCapital">
                                        Rp {{ number_format($mAkhir, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- GRAFIK PERGERAKAN MODAL -->
            <div class="col-lg-6">
                <div class="border rounded-4 p-3 h-100 d-flex flex-column justify-content-between" style="border-color: var(--ent-grid-border) !important;">
                    <div>
                        <h6 class="fw-bold mb-1"><i class="fas fa-chart-line me-1 text-primary"></i> Grafik Pergerakan Modal Pemilik</h6>
                        <small class="opacity-75 d-block mb-3">Visualisasi bertahap dari Modal Awal hingga Modal Akhir.</small>
                    </div>
                    <canvas id="capitalChart" height="150"></canvas>
                </div>
            </div>
        </div>

        <!-- RINCIAN MUTASI PER AKUN EKUITAS -->
        <div class="border rounded-4 overflow-hidden mt-3" style="border-color: var(--ent-grid-border) !important;">
            <div class="px-3 py-2 fw-bold small d-flex align-items-center justify-content-between"
                style="background: rgba(79, 70, 229, 0.09); border-bottom: 1px solid var(--ent-grid-border);">
                <span><i class="fas fa-book me-1 text-primary"></i> Rincian Mutasi Akun Ekuitas (COA 3xxx) Periode Ini</span>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">
                    {{ $detailsList->count() }} Akun
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered cs-table w-100">
                    <thead>
                        <tr>
                            <th style="width: 120px;">Kode COA</th>
                            <th>Nama Akun Ekuitas</th>
                            <th style="width: 155px;">Kategori</th>
                            <th class="text-center" style="width: 80px;">Jurnal</th>
                            <th class="text-end" style="width: 145px;">Debit / Prive</th>
                            <th class="text-end" style="width: 145px;">Kredit / Setoran</th>
                            <th class="text-end" style="width: 155px;">Perubahan Bersih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($detailsList as $det)
                            <tr>
                                <td><span class="cs-coa-pill">{{ $det->coa_code }}</span></td>
                                <td class="fw-semibold">{{ $det->coa_name }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $det->kategori }}</span></td>
                                <td class="text-center cs-mono">{{ $det->jumlah_jurnal }}</td>
                                <td class="text-end cs-mono text-danger">{{ number_format((int) $det->total_debit, 0, ',', '.') }}</td>
                                <td class="text-end cs-mono text-success">{{ number_format((int) $det->total_kredit, 0, ',', '.') }}</td>
                                <td class="text-end cs-mono fw-bold {{ $det->net_change >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $det->net_change < 0 ? '-' : '' }}{{ number_format(abs((int) $det->net_change), 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 opacity-75">Belum ada mutasi akun ekuitas pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- KETERANGAN -->
<div class="card ent-card mb-3">
    <div class="ent-card-header">
        <h6 class="mb-0 fw-bold"><i class="fas fa-info-circle me-2 text-primary"></i>Keterangan Komponen Laporan</h6>
    </div>
    <div class="card-body p-3 p-md-4 small">
        <ul class="mb-0 ps-3">
            <li class="mb-1"><strong>Modal Awal:</strong> Akumulasi saldo ekuitas dan laba/rugi ditahan sebelum tanggal awal periode yang dipilih.</li>
            <li class="mb-1"><strong>Tambahan Investasi:</strong> Penambahan modal yang disetor atau dikreditkan ke akun ekuitas selama periode berjalan.</li>
            <li class="mb-1"><strong>Prive / Penarikan Modal:</strong> Penarikan modal oleh pemilik/anggota yang didebitkan pada akun ekuitas selama periode berjalan.</li>
            <li><strong>Laba / Rugi Bersih:</strong> Selisih antara total pendapatan dan total beban pada periode berjalan yang menambah atau mengurangi modal akhir.</li>
        </ul>
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

        const step1 = {{ $mAwal }};
        const step2 = step1 + {{ $tInvestasi }};
        const step3 = step2 - {{ $pPrive }};
        const step4 = {{ $mAkhir }};

        const ctx = document.getElementById('capitalChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Modal Awal', '+ Investasi', '- Prive', 'Modal Akhir'],
                datasets: [{
                    label: 'Posisi Modal (Rp)',
                    data: [step1, step2, step3, step4],
                    fill: true,
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.16)',
                    tension: 0.3,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointBackgroundColor: '#4338ca'
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

    $(document).on("submit", "#form-cs-filter", function (e) {
        var awal = document.getElementById("cs_tanggal_awal").value;
        var akhir = document.getElementById("cs_tanggal_akhir").value;
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
</script>
@endsection
