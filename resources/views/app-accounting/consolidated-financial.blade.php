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

    .cons-summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }

    .cons-stat-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        padding: 14px 16px;
        background-color: rgba(79, 70, 229, 0.03);
    }

    .cons-stat-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        opacity: 0.72;
        display: block;
        margin-bottom: 4px;
    }

    .cons-stat-value {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.98rem;
        font-weight: 700;
    }

    .cons-table {
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.81rem;
        margin-bottom: 0;
    }

    .cons-table thead th {
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

    .cons-table tbody td {
        padding: 8px 11px;
        vertical-align: middle;
        border-color: rgba(148, 163, 184, 0.22);
    }

    .cons-table tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.035);
    }

    .cons-grand-row td {
        background: rgba(15, 23, 42, 0.06) !important;
        border-top: 2px solid #4f46e5 !important;
        border-bottom: 2px solid #4f46e5 !important;
        font-weight: 700;
        padding: 10px 11px !important;
    }

    .cons-mono {
        font-family: 'JetBrains Mono', monospace;
    }

    .chart-container {
        position: relative;
        height: 290px;
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
    $rowsList   = collect($consolidatedRows ?? []);
    $sumAset    = (int) $rowsList->sum('total_aset');
    $sumLiab    = (int) $rowsList->sum('total_kewajiban');
    $sumEq      = (int) $rowsList->sum('total_ekuitas');
    $sumRev     = (int) $rowsList->sum('pendapatan');
    $sumExp     = (int) $rowsList->sum('beban');
    $sumProfit  = (int) $rowsList->sum('net_profit');
@endphp

<!-- HERO BANNER HEADER -->
<header class="mb-3 no-print">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width: 58px; height: 58px;">
                        <img src="{{ asset('img/balance.png') }}" alt="Consolidated Icon" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                <i class="fas fa-layer-group"></i> {{ Env('APP_LABEL') }} MANAGEMENT SYSTEM
                            </span>
                            <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Menu: Consolidated Financial</span>
                        </div>
                        <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: white;">
                            Laporan Keuangan Konsolidasi Terpusat
                        </h4>
                        <p class="mb-0 small" style="color: #cbd5e1;">Ringkasan posisi aset, kewajiban, ekuitas, pendapatan, beban, dan laba/rugi bersih per entitas/project.</p>
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
                    <i class="fas fa-filter me-2 text-primary"></i>Filter Laporan Konsolidasi
                </h6>
                <small class="opacity-75">Pilih Project (ketik untuk mencari), Tanggal Awal, dan Tanggal Akhir lalu tekan Tampilkan.</small>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-success btn-sm rounded-3 fw-semibold" onclick="exportConsolidatedCsv()">
                    <i class="fas fa-file-csv me-1"></i> Export CSV
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-3 fw-semibold" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> Cetak Laporan
                </button>
            </div>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">
        <form method="GET" action="{{ url()->current() }}" class="row g-3 align-items-end needs-validation" novalidate="" id="form-cons-filter">
            <div class="col-md-6 col-xl-4 position-relative">
                <label for="cons_project" class="ent-label">Project</label>
                <select class="form-select js-searchable-select" id="cons_project" name="project">
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
                <label for="cons_tanggal_awal" class="ent-label">Tanggal Awal</label>
                <input class="form-control ent-date-input datetimepicker" id="cons_tanggal_awal" name="tanggal_awal"
                    type="text" value="{{ $tanggal_awal ?? '' }}" placeholder="dd/mm/yyyy"
                    data-options='{"dateFormat":"d/m/Y","disableMobile":true}' />
            </div>

            <div class="col-md-6 col-xl-3 position-relative">
                <label for="cons_tanggal_akhir" class="ent-label">Tanggal Akhir</label>
                <input class="form-control ent-date-input datetimepicker" id="cons_tanggal_akhir" name="tanggal_akhir"
                    type="text" value="{{ $tanggal_akhir ?? '' }}" placeholder="dd/mm/yyyy"
                    data-options='{"dateFormat":"d/m/Y","disableMobile":true}' />
            </div>

            <div class="col-md-6 col-xl-2 d-grid">
                <button class="btn ent-btn ent-btn-primary py-2" type="submit" id="btnFilterConsolidated">
                    <i class="fas fa-search me-1"></i> Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- RINGKASAN KONSOLIDASI & TABEL -->
<div class="card ent-card mb-3">
    <div class="card-header bg-transparent border-bottom p-3 p-md-4" style="border-color: var(--ent-grid-border) !important;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5;">
                        <i class="fas fa-building"></i> CONSOLIDATED SUMMARY
                    </span>
                    @if (!empty($project))
                        <span class="ent-badge" style="background: rgba(2, 132, 199, 0.12); color: #0284c7;">
                            {{ strtoupper($project) }}
                        </span>
                    @endif
                </div>
                <h6 class="mb-0 fw-bold">
                    Ringkasan Konsolidasi &mdash; Periode: {{ !empty($tanggal_awal) ? $tanggal_awal : 'Semua Tanggal' }}
                    s/d {{ !empty($tanggal_akhir) ? $tanggal_akhir : 'Semua Tanggal' }}
                </h6>
            </div>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">
        <div class="cons-summary-grid">
            <div class="cons-stat-card" style="border-left: 4px solid #0284c7 !important;">
                <span class="cons-stat-label">Total Aset Konsolidasi</span>
                <span class="cons-stat-value text-primary">Rp {{ number_format($sumAset, 0, ',', '.') }}</span>
            </div>
            <div class="cons-stat-card" style="border-left: 4px solid #e11d48 !important;">
                <span class="cons-stat-label">Total Kewajiban</span>
                <span class="cons-stat-value text-danger">Rp {{ number_format($sumLiab, 0, ',', '.') }}</span>
            </div>
            <div class="cons-stat-card" style="border-left: 4px solid #4f46e5 !important;">
                <span class="cons-stat-label">Total Ekuitas</span>
                <span class="cons-stat-value text-info">Rp {{ number_format($sumEq, 0, ',', '.') }}</span>
            </div>
            <div class="cons-stat-card" style="border-left: 4px solid #059669 !important;">
                <span class="cons-stat-label">Net Profit Konsolidasi</span>
                <span class="cons-stat-value {{ $sumProfit >= 0 ? 'text-success' : 'text-danger' }}">
                    {{ $sumProfit < 0 ? '-' : '' }}Rp {{ number_format(abs($sumProfit), 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div class="border rounded-4 overflow-hidden" style="border-color: var(--ent-grid-border) !important;">
            <div class="table-responsive">
                <table id="consolidatedTable" class="table table-bordered cons-table w-100">
                    <thead>
                        <tr>
                            <th>Entitas / Project</th>
                            <th class="text-end">Total Aset</th>
                            <th class="text-end">Total Kewajiban</th>
                            <th class="text-end">Ekuitas</th>
                            <th class="text-end">Pendapatan</th>
                            <th class="text-end">Beban</th>
                            <th class="text-end">Net Profit</th>
                            <th class="text-center no-print" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rowsList as $idx => $item)
                            @php
                                $np = (int) ($item->net_profit ?? 0);
                            @endphp
                            <tr>
                                <td class="fw-bold">{{ $item->project_name }}</td>
                                <td class="text-end cons-mono">Rp {{ number_format((int) $item->total_aset, 0, ',', '.') }}</td>
                                <td class="text-end cons-mono">Rp {{ number_format((int) $item->total_kewajiban, 0, ',', '.') }}</td>
                                <td class="text-end cons-mono">Rp {{ number_format((int) $item->total_ekuitas, 0, ',', '.') }}</td>
                                <td class="text-end cons-mono text-success">Rp {{ number_format((int) $item->pendapatan, 0, ',', '.') }}</td>
                                <td class="text-end cons-mono text-danger">Rp {{ number_format((int) $item->beban, 0, ',', '.') }}</td>
                                <td class="text-end cons-mono fw-bold {{ $np >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $np < 0 ? '-' : '' }}Rp {{ number_format(abs($np), 0, ',', '.') }}
                                </td>
                                <td class="text-center no-print">
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-2" onclick="openEntityDetail({{ $idx }})">
                                        <i class="fas fa-eye me-1"></i> Preview
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 opacity-75">Tidak ada data konsolidasi pada filter periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if ($rowsList->count() > 0)
                        <tfoot>
                            <tr class="cons-grand-row">
                                <td>TOTAL KONSOLIDASI</td>
                                <td class="text-end cons-mono">Rp {{ number_format($sumAset, 0, ',', '.') }}</td>
                                <td class="text-end cons-mono">Rp {{ number_format($sumLiab, 0, ',', '.') }}</td>
                                <td class="text-end cons-mono">Rp {{ number_format($sumEq, 0, ',', '.') }}</td>
                                <td class="text-end cons-mono text-success">Rp {{ number_format($sumRev, 0, ',', '.') }}</td>
                                <td class="text-end cons-mono text-danger">Rp {{ number_format($sumExp, 0, ',', '.') }}</td>
                                <td class="text-end cons-mono {{ $sumProfit >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $sumProfit < 0 ? '-' : '' }}Rp {{ number_format(abs($sumProfit), 0, ',', '.') }}
                                </td>
                                <td class="no-print"></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

<!-- GRAFIK KONSOLIDASI -->
<div class="card ent-card mb-3">
    <div class="ent-card-header">
        <h6 class="mb-0 fw-bold"><i class="fas fa-chart-bar me-2 text-primary"></i>Perbandingan Aset vs Kewajiban + Ekuitas</h6>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="chart-container">
            <canvas id="financeChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title text-white" id="detailModalTitle">Detail Laporan Konsolidasi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailModalBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-3" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@php
    $consolidatedPayload = $rowsList->values()->all();
@endphp

<script>
    const consolidatedData = {!! json_encode($consolidatedPayload, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!};

    function parseDmyDate(dateStr) {
        if (!dateStr) return null;
        var parts = dateStr.trim().split("/");
        if (parts.length !== 3) return null;
        return new Date(parseInt(parts[2], 10), parseInt(parts[1], 10) - 1, parseInt(parts[0], 10));
    }

    function formatRupiah(num) {
        var n = Number(num || 0);
        return (n < 0 ? "-Rp " : "Rp ") + Math.abs(n).toLocaleString("id-ID");
    }

    function escapeHtml(str) {
        return String(str || "")
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;");
    }

    function openEntityDetail(index) {
        var ent = consolidatedData[index];
        if (!ent) return;

        document.getElementById("detailModalTitle").innerText = "Detail Konsolidasi — " + (ent.project_name || "");

        var rowsHtml = "";
        (ent.accounts || []).forEach(function (acc) {
            rowsHtml += `
                <tr>
                    <td><span class="badge bg-light text-dark border">${escapeHtml(acc.coa_code)}</span></td>
                    <td>${escapeHtml(acc.coa_name)}</td>
                    <td>${escapeHtml(acc.kelompok)}</td>
                    <td class="text-end cons-mono fw-semibold">${formatRupiah(acc.saldo)}</td>
                </tr>
            `;
        });

        if (rowsHtml === "") {
            rowsHtml = `<tr><td colspan="4" class="text-center py-3 opacity-75">Tidak ada rincian akun.</td></tr>`;
        }

        document.getElementById("detailModalBody").innerHTML = `
            <div class="row g-2 mb-3 small">
                <div class="col-md-4"><strong>Total Aset:</strong> <span class="cons-mono">${formatRupiah(ent.total_aset)}</span></div>
                <div class="col-md-4"><strong>Total Kewajiban:</strong> <span class="cons-mono">${formatRupiah(ent.total_kewajiban)}</span></div>
                <div class="col-md-4"><strong>Ekuitas:</strong> <span class="cons-mono">${formatRupiah(ent.total_ekuitas)}</span></div>
                <div class="col-md-4"><strong>Pendapatan:</strong> <span class="cons-mono text-success">${formatRupiah(ent.pendapatan)}</span></div>
                <div class="col-md-4"><strong>Beban:</strong> <span class="cons-mono text-danger">${formatRupiah(ent.beban)}</span></div>
                <div class="col-md-4"><strong>Net Profit:</strong> <span class="cons-mono fw-bold">${formatRupiah(ent.net_profit)}</span></div>
            </div>
            <div class="table-responsive" style="max-height: 320px; overflow-y: auto;">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode COA</th>
                            <th>Nama Akun</th>
                            <th>Kelompok</th>
                            <th class="text-end">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>${rowsHtml}</tbody>
                </table>
            </div>
        `;

        new bootstrap.Modal(document.getElementById("detailModal")).show();
    }

    function exportConsolidatedCsv() {
        var table = document.getElementById("consolidatedTable");
        if (!table) return;
        var csvRows = [];
        for (var i = 0; i < table.rows.length; i++) {
            var cols = [];
            for (var j = 0; j < table.rows[i].cells.length; j++) {
                if (j === table.rows[i].cells.length - 1) continue;
                var txt = table.rows[i].cells[j].innerText.replace(/\s+/g, " ").trim().replace(/"/g, '""');
                cols.push('"' + txt + '"');
            }
            csvRows.push(cols.join(","));
        }
        var blob = new Blob([csvRows.join("\n")], { type: "text/csv;charset=utf-8;" });
        var url = URL.createObjectURL(blob);
        var a = document.createElement("a");
        a.href = url;
        a.download = "laporan-keuangan-konsolidasi.csv";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
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

        const ctx = document.getElementById("financeChart").getContext("2d");
        const labels = consolidatedData.map(item => item.project_name);
        const asetSeries = consolidatedData.map(item => Number(item.total_aset || 0));
        const liabEqSeries = consolidatedData.map(item => Number(item.total_kewajiban || 0) + Number(item.total_ekuitas || 0));

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Total Aset",
                        data: asetSeries,
                        backgroundColor: "rgba(79, 70, 229, 0.78)",
                        borderRadius: 8
                    },
                    {
                        label: "Kewajiban + Ekuitas",
                        data: liabEqSeries,
                        backgroundColor: "rgba(5, 150, 105, 0.78)",
                        borderRadius: 8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return context.dataset.label + ": " + formatRupiah(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (val) {
                                return formatRupiah(val);
                            }
                        }
                    }
                }
            }
        });
    });

    $(document).on("submit", "#form-cons-filter", function (e) {
        var awal = document.getElementById("cons_tanggal_awal").value;
        var akhir = document.getElementById("cons_tanggal_akhir").value;
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
