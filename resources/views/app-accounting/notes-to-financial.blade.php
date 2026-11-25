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

    .ntf-summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }

    .ntf-stat-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        padding: 14px 16px;
        background-color: rgba(79, 70, 229, 0.03);
    }

    .ntf-stat-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        opacity: 0.72;
        display: block;
        margin-bottom: 4px;
    }

    .ntf-stat-value {
        font-family: 'JetBrains Mono', monospace;
        font-size: 1rem;
        font-weight: 700;
    }

    .ntf-table {
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.81rem;
        margin-bottom: 0;
    }

    .ntf-table thead th {
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

    .ntf-table tbody td {
        padding: 8px 11px;
        vertical-align: middle;
        border-color: rgba(148, 163, 184, 0.22);
    }

    .ntf-table tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.035);
    }

    .ntf-mono {
        font-family: 'JetBrains Mono', monospace;
    }

    .ntf-coa-pill {
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

    [data-bs-theme="dark"] .ntf-coa-pill,
    .dark .ntf-coa-pill {
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
    $items = collect($noteItems ?? []);
@endphp

<!-- HERO BANNER HEADER -->
<header class="mb-3 no-print">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width: 58px; height: 58px;">
                        <img src="{{ asset('img/balance.png') }}" alt="Notes Icon" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                <i class="fas fa-file-alt"></i> {{ Env('APP_LABEL') }} MANAGEMENT SYSTEM
                            </span>
                            <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Menu: Notes to Financial Statement</span>
                        </div>
                        <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: white;">
                            Catatan atas Laporan Keuangan (Notes to Financial)
                        </h4>
                        <p class="mb-0 small" style="color: #cbd5e1;">Penjelasan rincian saldo akun COA dan catatan tambahan pada periode terpilih.</p>
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
                    <i class="fas fa-filter me-2 text-primary"></i>Filter Catatan Laporan Keuangan
                </h6>
                <small class="opacity-75">Pilih Project (ketik untuk mencari), Tanggal Awal, dan Tanggal Akhir lalu tekan Tampilkan.</small>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn ent-btn ent-btn-primary btn-sm" onclick="openAddNoteModal()">
                    <i class="fas fa-plus me-1"></i> Tambah Catatan
                </button>
                <button type="button" class="btn btn-outline-success btn-sm rounded-3 fw-semibold" onclick="exportNotesCsv()">
                    <i class="fas fa-file-csv me-1"></i> Export CSV
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-3 fw-semibold" onclick="window.print()">
                    <i class="fas fa-print me-1"></i> Cetak Laporan
                </button>
            </div>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">
        <form method="GET" action="{{ url()->current() }}" class="row g-3 align-items-end needs-validation" novalidate="" id="form-ntf-filter">
            <div class="col-md-6 col-xl-4 position-relative">
                <label for="ntf_project" class="ent-label">Project</label>
                <select class="form-select js-searchable-select" id="ntf_project" name="project">
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
                <label for="ntf_tanggal_awal" class="ent-label">Tanggal Awal</label>
                <input class="form-control ent-date-input datetimepicker" id="ntf_tanggal_awal" name="tanggal_awal"
                    type="text" value="{{ $tanggal_awal ?? '' }}" placeholder="dd/mm/yyyy"
                    data-options='{"dateFormat":"d/m/Y","disableMobile":true}' />
            </div>

            <div class="col-md-6 col-xl-3 position-relative">
                <label for="ntf_tanggal_akhir" class="ent-label">Tanggal Akhir</label>
                <input class="form-control ent-date-input datetimepicker" id="ntf_tanggal_akhir" name="tanggal_akhir"
                    type="text" value="{{ $tanggal_akhir ?? '' }}" placeholder="dd/mm/yyyy"
                    data-options='{"dateFormat":"d/m/Y","disableMobile":true}' />
            </div>

            <div class="col-md-6 col-xl-2 d-grid">
                <button class="btn ent-btn ent-btn-primary py-2" type="submit" id="btnFilterNotes">
                    <i class="fas fa-search me-1"></i> Tampilkan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- TABEL CATATAN LAPORAN KEUANGAN -->
<div class="card ent-card mb-3">
    <div class="card-header bg-transparent border-bottom p-3 p-md-4" style="border-color: var(--ent-grid-border) !important;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5;">
                        <i class="fas fa-list-alt"></i> NOTES TO FINANCIAL STATEMENTS
                    </span>
                    @if (!empty($project))
                        <span class="ent-badge" style="background: rgba(2, 132, 199, 0.12); color: #0284c7;">
                            {{ strtoupper($project) }}
                        </span>
                    @endif
                </div>
                <h6 class="mb-0 fw-bold" id="periodeText">
                    Rincian Catatan Akun &mdash; Periode: {{ !empty($tanggal_awal) ? $tanggal_awal : 'Semua Tanggal' }}
                    s/d {{ !empty($tanggal_akhir) ? $tanggal_akhir : 'Semua Tanggal' }}
                </h6>
            </div>

            <div class="input-group input-group-sm no-print" style="width: 250px;">
                <span class="input-group-text bg-transparent"><i class="fas fa-search opacity-75"></i></span>
                <input type="text" id="filter-ntf-search" class="form-control" placeholder="Cari Akun / Catatan...">
            </div>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">
        <div class="ntf-summary-grid" id="ntfSummaryGrid">
            <div class="ntf-stat-card" style="border-left: 4px solid #4f46e5 !important;">
                <span class="ntf-stat-label">Jumlah Akun / Catatan</span>
                <span class="ntf-stat-value text-primary" id="ntfTotalCount">{{ $items->count() }}</span>
            </div>
            <div class="ntf-stat-card" style="border-left: 4px solid #0284c7 !important;">
                <span class="ntf-stat-label">Total Mutasi Debit</span>
                <span class="ntf-stat-value text-info" id="ntfTotalDebit">Rp {{ number_format((int) $items->sum('total_debit'), 0, ',', '.') }}</span>
            </div>
            <div class="ntf-stat-card" style="border-left: 4px solid #059669 !important;">
                <span class="ntf-stat-label">Total Mutasi Kredit</span>
                <span class="ntf-stat-value text-success" id="ntfTotalKredit">Rp {{ number_format((int) $items->sum('total_kredit'), 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="border rounded-4 overflow-hidden" style="border-color: var(--ent-grid-border) !important;">
            <div class="table-responsive">
                <table id="notesTable" class="table table-bordered ntf-table w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 55px;">No</th>
                            <th style="width: 115px;">Kode COA</th>
                            <th style="width: 210px;">Akun</th>
                            <th style="width: 115px;">Kelompok</th>
                            <th>Deskripsi / Catatan</th>
                            <th class="text-end" style="width: 155px;">Nilai / Saldo (Rp)</th>
                            <th class="text-center no-print" style="width: 105px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- GRAFIK KOMPOSISI -->
<div class="card ent-card mb-3">
    <div class="ent-card-header">
        <h6 class="mb-0 fw-bold"><i class="fas fa-chart-pie me-2 text-primary"></i>Komposisi Nilai Akun Utama</h6>
    </div>
    <div class="card-body p-3 p-md-4">
        <canvas id="notesChart" height="100"></canvas>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modalNote" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title text-white">Tambah / Edit Catatan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="noteForm">
                    <input type="hidden" id="editIndex">
                    <div class="mb-3">
                        <label class="ent-label">Kode COA</label>
                        <input type="text" id="coa_code" class="form-control" placeholder="Contoh: CAT-01">
                    </div>
                    <div class="mb-3">
                        <label class="ent-label">Akun</label>
                        <input type="text" id="akun" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="ent-label">Kelompok</label>
                        <select id="kelompok" class="form-select">
                            <option value="Catatan Tambahan">Catatan Tambahan</option>
                            <option value="Aset">Aset</option>
                            <option value="Kewajiban">Kewajiban</option>
                            <option value="Ekuitas">Ekuitas</option>
                            <option value="Pendapatan">Pendapatan</option>
                            <option value="Beban">Beban</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="ent-label">Deskripsi / Catatan</label>
                        <textarea id="deskripsi" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="ent-label">Nilai (Rp)</label>
                        <input type="number" id="nilai" class="form-control" step="any" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-3" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn ent-btn ent-btn-primary btn-sm" onclick="simpanNote()">Simpan</button>
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
    $notesPayload = $items->map(function ($it) {
        return [
            'coa_code'  => (string) ($it->coa_code ?? ''),
            'akun'      => (string) ($it->coa_name ?? ''),
            'kelompok'  => (string) ($it->kelompok ?? 'Umum'),
            'deskripsi' => (string) ($it->deskripsi ?? ''),
            'nilai'     => (float) ($it->saldo ?? 0),
        ];
    })->values()->all();
@endphp
<script>
    let notes = @json($notesPayload);

    const tableBody = document.getElementById("tableBody");
    const ctx = document.getElementById("notesChart").getContext("2d");
    let chart;

    function parseDmyDate(dateStr) {
        if (!dateStr) return null;
        var parts = dateStr.trim().split("/");
        if (parts.length !== 3) return null;
        return new Date(parseInt(parts[2], 10), parseInt(parts[1], 10) - 1, parseInt(parts[0], 10));
    }

    function escapeHtml(str) {
        return String(str || "")
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;");
    }

    function renderTable() {
        var keyword = ($("#filter-ntf-search").val() || "").toLowerCase().trim();
        tableBody.innerHTML = "";

        var visibleCount = 0;
        notes.forEach((n, i) => {
            var searchBlob = ((n.coa_code || "") + " " + (n.akun || "") + " " + (n.kelompok || "") + " " + (n.deskripsi || "")).toLowerCase();
            if (keyword !== "" && searchBlob.indexOf(keyword) === -1) {
                return;
            }
            visibleCount++;
            var valNum = Number(n.nilai || 0);
            var formattedVal = (valNum < 0 ? "-" : "") + Math.abs(valNum).toLocaleString("id-ID");

            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td class="text-center fw-bold">${i + 1}</td>
                <td><span class="ntf-coa-pill">${escapeHtml(n.coa_code || "-")}</span></td>
                <td class="fw-semibold">${escapeHtml(n.akun)}</td>
                <td><span class="badge bg-light text-dark border">${escapeHtml(n.kelompok || "Umum")}</span></td>
                <td>${escapeHtml(n.deskripsi)}</td>
                <td class="text-end ntf-mono fw-semibold ${valNum < 0 ? "text-danger" : "text-success"}">${formattedVal}</td>
                <td class="text-center no-print">
                    <button type="button" class="btn btn-sm btn-outline-warning rounded-2 me-1" onclick="editNote(${i})" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-2" onclick="hapusNote(${i})" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(tr);
        });

        if (visibleCount === 0) {
            tableBody.innerHTML = `<tr><td colspan="7" class="text-center py-4 opacity-75">Belum ada catatan atau akun pada periode ini.</td></tr>`;
        }

        document.getElementById("ntfTotalCount").innerText = notes.length;
        renderChart();
    }

    function renderChart() {
        const topNotes = [...notes]
            .sort((a, b) => Math.abs(Number(b.nilai || 0)) - Math.abs(Number(a.nilai || 0)))
            .slice(0, 8);

        const labels = topNotes.map(n => n.akun);
        const data = topNotes.map(n => Math.abs(Number(n.nilai || 0)));

        if (chart) chart.destroy();
        chart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [{
                    label: "Nilai Saldo Absolut (Rp)",
                    data: data,
                    backgroundColor: [
                        "rgba(79, 70, 229, 0.75)",
                        "rgba(2, 132, 199, 0.75)",
                        "rgba(5, 150, 105, 0.75)",
                        "rgba(217, 119, 6, 0.75)",
                        "rgba(225, 29, 72, 0.75)",
                        "rgba(99, 102, 241, 0.75)",
                        "rgba(14, 165, 233, 0.75)",
                        "rgba(16, 185, 129, 0.75)"
                    ],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return "Rp " + Number(context.raw || 0).toLocaleString("id-ID");
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (val) {
                                return "Rp " + Number(val).toLocaleString("id-ID");
                            }
                        }
                    }
                }
            }
        });
    }

    function openAddNoteModal() {
        document.getElementById("noteForm").reset();
        document.getElementById("editIndex").value = "";
        new bootstrap.Modal(document.getElementById("modalNote")).show();
    }

    function simpanNote() {
        const coaCode = document.getElementById("coa_code").value.trim() || "NOTE";
        const akun = document.getElementById("akun").value.trim();
        const kelompok = document.getElementById("kelompok").value;
        const deskripsi = document.getElementById("deskripsi").value.trim();
        const nilai = parseFloat(document.getElementById("nilai").value);
        const index = document.getElementById("editIndex").value;

        if (!akun || !deskripsi || isNaN(nilai)) {
            Swal.fire({
                icon: "warning",
                title: "Data Belum Lengkap",
                text: "Lengkapi Akun, Deskripsi, dan Nilai terlebih dahulu."
            });
            return;
        }

        const item = { coa_code: coaCode, akun: akun, kelompok: kelompok, deskripsi: deskripsi, nilai: nilai };
        if (index === "") {
            notes.push(item);
        } else {
            notes[parseInt(index, 10)] = item;
        }

        document.getElementById("noteForm").reset();
        document.getElementById("editIndex").value = "";
        const modalInstance = bootstrap.Modal.getInstance(document.getElementById("modalNote"));
        if (modalInstance) modalInstance.hide();
        renderTable();
    }

    function editNote(i) {
        const n = notes[i];
        if (!n) return;
        document.getElementById("coa_code").value = n.coa_code || "";
        document.getElementById("akun").value = n.akun || "";
        document.getElementById("kelompok").value = n.kelompok || "Catatan Tambahan";
        document.getElementById("deskripsi").value = n.deskripsi || "";
        document.getElementById("nilai").value = n.nilai || 0;
        document.getElementById("editIndex").value = i;
        new bootstrap.Modal(document.getElementById("modalNote")).show();
    }

    function hapusNote(i) {
        Swal.fire({
            icon: "question",
            title: "Hapus Catatan?",
            text: "Catatan ini akan dihapus dari daftar tampilan saat ini.",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal"
        }).then(function (result) {
            if (result.isConfirmed) {
                notes.splice(i, 1);
                renderTable();
            }
        });
    }

    function exportNotesCsv() {
        var rowsCsv = [['"No"', '"Kode COA"', '"Akun"', '"Kelompok"', '"Deskripsi"', '"Nilai (Rp)"'].join(",")];
        notes.forEach(function (n, idx) {
            var cols = [
                '"' + (idx + 1) + '"',
                '"' + String(n.coa_code || "").replace(/"/g, '""') + '"',
                '"' + String(n.akun || "").replace(/"/g, '""') + '"',
                '"' + String(n.kelompok || "").replace(/"/g, '""') + '"',
                '"' + String(n.deskripsi || "").replace(/"/g, '""') + '"',
                '"' + Number(n.nilai || 0) + '"'
            ];
            rowsCsv.push(cols.join(","));
        });
        var blob = new Blob([rowsCsv.join("\n")], { type: "text/csv;charset=utf-8;" });
        var url = URL.createObjectURL(blob);
        var a = document.createElement("a");
        a.href = url;
        a.download = "notes-to-financial-statement.csv";
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

        renderTable();
    });

    $(document).on("submit", "#form-ntf-filter", function (e) {
        var awal = document.getElementById("ntf_tanggal_awal").value;
        var akhir = document.getElementById("ntf_tanggal_akhir").value;
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

    $(document).on("keyup", "#filter-ntf-search", function () {
        renderTable();
    });
</script>
@endsection
