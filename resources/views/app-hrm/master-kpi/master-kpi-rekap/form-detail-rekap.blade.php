@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-grid-border: rgba(99, 102, 241, 0.14);
        --ent-surface: #ffffff;
        --ent-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark,
    body.dark-mode {
        --ent-surface: #0f172a;
        --ent-text: #f8fafc;
        --ent-grid-border: rgba(148, 163, 184, 0.16);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1rem;
    }

    /* Skala Font Standar: fs-2 (default), fs-1, fs--1, fs--2 */
    .fs-2 {
        font-size: 1rem !important;
        line-height: 1.55;
    }

    .fs-1 {
        font-size: 1.15rem !important;
        line-height: 1.4;
    }

    .fs--1 {
        font-size: 0.875rem !important;
        line-height: 1.5;
    }

    .fs--2 {
        font-size: 0.75rem !important;
        line-height: 1.4;
    }

    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.25) !important;
        border-radius: 14px;
        box-shadow: 0 10px 24px -6px rgba(15, 23, 42, 0.2);
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
        background: radial-gradient(circle, rgba(56, 189, 248, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 12px;
        color: #ffffff;
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 14px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 2px 12px -2px rgba(15, 23, 42, 0.05);
        transition: all 0.25s ease;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.05) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        padding: 14px 20px;
    }

    .kpi-card:hover {
        transform: translateY(-2px);
        border-color: rgba(79, 70, 229, 0.35) !important;
        box-shadow: 0 8px 20px -4px rgba(15, 23, 42, 0.1) !important;
    }

    .icon-shape {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        flex-shrink: 0;
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        letter-spacing: 0.03em;
    }

    .ent-input,
    .ent-select {
        min-height: 42px;
        border-radius: 10px !important;
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        padding: 8px 12px !important;
    }

    .ent-input:focus,
    .ent-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
        outline: none;
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
    }

    .ent-btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.22);
    }

    .ent-btn-primary:hover:not(:disabled) {
        color: #ffffff;
    }

    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 12px 14px;
        white-space: nowrap;
    }

    .table-custom tbody td {
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 11px 14px;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.04) !important;
    }

    .ent-sub-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        background-color: rgba(79, 70, 229, 0.03);
    }

    .ent-mono {
        font-family: 'JetBrains Mono', monospace;
    }
</style>
@endsection

@section('content')
{{-- Hero Banner Header --}}
<header class="mb-3 fs-2">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center justify-content-between gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 56px; height: 56px;">
                        <img src="{{ asset('img/gl.png') }}" alt="Logo" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge fs--2" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                                <i class="fas fa-chart-line"></i> {{ env('APP_LABEL', 'INNOVENTRA') }} MANAGEMENT SYSTEM
                            </span>
                            <span class="fs--2 fw-semibold" style="color: #94a3b8;">Menu: Master KPI Rekap All Pegawai</span>
                        </div>
                        <h4 class="text-white fw-bold mb-0 fs-1" style="letter-spacing: -0.02em;">
                            Master KPI Rekap All Pegawai
                        </h4>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">Ringkasan hasil evaluasi kinerja, rata-rata skor, dan kategori performa seluruh pegawai.</p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="ent-glass-pill px-3 py-2 d-inline-block text-start">
                        <span class="d-block text-uppercase fs--2" style="color: #94a3b8;">Periode Aktif</span>
                        <span class="fw-bold fs-1 ent-mono" style="color: #7dd3fc;">
                            <i class="far fa-calendar-check me-1 fs--1"></i> {{ $selectedPeriode }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- Form Filter --}}
<div class="card ent-card mb-3 fs-2">
    <div class="card-body p-3 p-md-4">
        <form action="{{ route('kpi.rekap.data') }}" method="GET" class="row g-3 align-items-end">
            <input type="hidden" name="id" value="{{ $id }}">

            <div class="col-md-3">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="far fa-calendar-alt me-1 text-primary"></i> Periode Bulan
                </label>
                <input type="month" name="periode" class="form-control ent-input ent-mono fs-2" value="{{ $selectedPeriode }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-sitemap me-1 text-primary"></i> Filter Departemen
                </label>
                <select name="dept_code" class="form-select ent-select fs-2">
                    <option value="">-- Semua Departemen --</option>
                    @foreach($departemens as $d)
                    <option value="{{ $d->hrm_departemen_code }}" {{ $selectedDept == $d->hrm_departemen_code ? 'selected' : '' }}>
                        {{ $d->hrm_departemen_name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-search me-1 text-primary"></i> Cari Pegawai
                </label>
                <input type="text" name="search" class="form-control ent-input fs-2" placeholder="Cari Nama / NIP..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn ent-btn ent-btn-primary w-100 py-2 fs-2">
                    <i class="fas fa-search me-1"></i> Search
                </button>
                <a href="{{ route('kpi.rekap.index', ['id' => $id]) }}" class="btn ent-btn btn-light border px-3 py-2 fs-2" title="Reset Awal">
                    <i class="fas fa-undo"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Summary Cards --}}
<div class="row g-3 mb-3 fs-2">
    <div class="col-md-3 col-6">
        <div class="card ent-card kpi-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Total Evaluasi</div>
                    <div class="fs-1 fw-bold text-primary ent-mono">{{ count($rekaps) }}</div>
                    <small class="opacity-75 fs--2">Pegawai Terdaftar</small>
                </div>
                <div class="icon-shape" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                    <i class="fas fa-users fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card ent-card kpi-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Rata-Rata Skor</div>
                    <div class="fs-1 fw-bold text-success ent-mono">{{ number_format($avgSkor, 1) }}</div>
                    <small class="opacity-75 fs--2">Performa Keseluruhan</small>
                </div>
                <div class="icon-shape" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">
                    <i class="fas fa-star fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card ent-card kpi-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Sangat Baik (A/B)</div>
                    <div class="fs-1 fw-bold text-info ent-mono">{{ $totalHighPerformer }}</div>
                    <small class="opacity-75 fs--2">Pegawai High Perform</small>
                </div>
                <div class="icon-shape" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.2);">
                    <i class="fas fa-award fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card ent-card kpi-card p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Perlu Perbaikan</div>
                    <div class="fs-1 fw-bold text-warning ent-mono">{{ $totalUnderPerformer }}</div>
                    <small class="opacity-75 fs--2">Skor di bawah standar</small>
                </div>
                <div class="icon-shape" style="background: rgba(245, 158, 11, 0.12); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2);">
                    <i class="fas fa-exclamation-triangle fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Data --}}
<div class="card ent-card mb-3 fs-2">
    <div class="ent-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h6 class="mb-0 fw-bold fs-1"><i class="fas fa-list-alt text-primary me-2"></i>Daftar Rekapitulasi KPI Pegawai</h6>
            <span class="opacity-75 fs--1">Hasil evaluasi kinerja pegawai berdasarkan filter periode dan departemen.</span>
        </div>
        <span class="ent-badge fs--2 ent-mono" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
            {{ count($rekaps) }} Data
        </span>
    </div>

    <div class="card-body p-3 p-md-4">
        <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
            <table id="tableRekapKpi" class="table table-hover table-custom align-middle mb-0 w-100 fs-2">
                <thead>
                    <tr class="fs--2">
                        <th class="text-center" style="width: 48px;">#</th>
                        <th>Informasi Pegawai</th>
                        <th>Departemen</th>
                        <th class="text-center">Periode</th>
                        <th class="text-center">Total Skor KPI</th>
                        <th class="text-center">Kategori Performa</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                    @forelse($rekaps as $index => $row)
                    @php
                    $score = $row->total_score ?? 0;
                    $badgeStyle = 'background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.25);';
                    $scoreClass = 'text-danger';

                    if ($score >= 90) {
                        $badgeStyle = 'background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);';
                        $scoreClass = 'text-success';
                    } elseif ($score >= 80) {
                        $badgeStyle = 'background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.25);';
                        $scoreClass = 'text-primary';
                    } elseif ($score >= 70) {
                        $badgeStyle = 'background: rgba(2, 132, 199, 0.14); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.25);';
                        $scoreClass = 'text-info';
                    } elseif ($score >= 60) {
                        $badgeStyle = 'background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.28);';
                        $scoreClass = 'text-warning';
                    }
                    @endphp
                    <tr>
                        <td class="text-center ent-mono fw-semibold">{{ $index + 1 }}</td>
                        <td>
                            <div class="fw-bold fs-2">{{ $row->hrm_m_pegawai_name }}</div>
                            <div class="opacity-75 fs--2 ent-mono"><i class="fas fa-id-badge me-1 text-primary"></i>NIP: {{ $row->hrm_m_pegawai_nip }}</div>
                        </td>
                        <td>
                            <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                <i class="fas fa-building"></i> {{ $row->hrm_departemen_name ?? '-' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="fw-semibold fs--1">{{ date('F Y', strtotime($row->periode . '-01')) }}</span>
                        </td>
                        <td class="text-center ent-mono">
                            <span class="fs-1 fw-bold {{ $scoreClass }}">{{ number_format($score, 2) }}</span>
                        </td>
                        <td class="text-center">
                            <span class="ent-badge fs--2" style="{{ $badgeStyle }}">
                                {{ $row->kategori ?? 'Belum Dinilai' }}
                            </span>
                        </td>
                        <td class="text-center text-nowrap">
                            <button type="button"
                                class="btn btn-sm ent-btn btn-outline-primary px-3 py-1 fs--2 btn-detail-modal"
                                data-pegawai="{{ $row->hrm_m_pegawai_code }}"
                                data-periode="{{ $row->periode }}"
                                title="Lihat Detail">
                                <i class="fas fa-eye me-1"></i>Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 opacity-75 fs--1">
                            <i class="fas fa-folder-open fs-1 mb-2 d-block text-primary"></i>
                            <div class="fw-bold fs-2">Tidak ada data rekap KPI</div>
                            <span>Tidak ada data rekap KPI ditemukan untuk pencarian ini.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Detail --}}
<div class="modal fade" id="modalDetailKpi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content ent-card border-0 shadow-lg fs-2">
            <div class="modal-header text-white py-3 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <h6 class="modal-title fw-bold text-white fs-1 mb-0">
                    <i class="fas fa-file-alt text-warning me-2"></i>Rincian Penilaian KPI Pegawai
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="modal_kpi_body">
                {{-- Dynamic via JavaScript --}}
            </div>
            <div class="modal-footer px-4 py-3" style="border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn btn-secondary px-4 fs--1" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function escapeHtml(text) {
            return String(text || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        const tableEl = document.getElementById('tableRekapKpi');
        const hasDataRows = tableEl && tableEl.querySelector('tbody tr td[colspan]') === null && tableEl.querySelectorAll('tbody tr').length > 0;

        if (hasDataRows) {
            new DataTable('#tableRekapKpi', {
                responsive: true,
                language: {
                    search: "Cari cepat:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ pegawai",
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                        previous: "<i class='fas fa-angle-left'></i>",
                        next: "<i class='fas fa-angle-right'></i>"
                    }
                }
            });
        }

        const modalElement = new bootstrap.Modal(document.getElementById('modalDetailKpi'));
        const modalBody = document.getElementById('modal_kpi_body');

        document.querySelectorAll('.btn-detail-modal').forEach(button => {
            button.addEventListener('click', function() {
                let pegawaiCode = this.getAttribute('data-pegawai');
                let periode = this.getAttribute('data-periode');

                modalBody.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary mb-2" role="status"></div>
                    <p class="mb-0 opacity-75 fs--1 fw-semibold">Mengambil Data Evaluasi...</p>
                </div>
                `;
                modalElement.show();

                fetch(`{{ url('hrm/manajemen/kpi-dan-target/getDetailAjax') }}/${pegawaiCode}/${periode}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Data tidak ditemukan');
                        return response.json();
                    })
                    .then(data => {
                        let p = data.pegawai;
                        let r = data.rekap;
                        let details = data.details || [];

                        let detailRows = '';
                        if (details.length > 0) {
                            details.forEach((item, idx) => {
                                detailRows += `
                                <tr>
                                    <td class="text-center ent-mono fw-semibold">${idx + 1}</td>
                                    <td>
                                        <div class="fw-bold fs--1">${escapeHtml(item.hrm_kpi_master_name)}</div>
                                        <span class="opacity-75 fs--2">${escapeHtml(item.hrm_kpi_master_desc ?? '-')}</span>
                                    </td>
                                    <td class="text-center ent-mono fw-semibold">${escapeHtml(item.hrm_kpi_master_bobot)}%</td>
                                    <td class="text-center ent-mono">${escapeHtml(item.hrm_kpi_master_target)}</td>
                                    <td class="text-center fw-bold ent-mono">${escapeHtml(item.hrm_kpi_pegawai_value)}</td>
                                    <td class="text-center fw-bold text-primary ent-mono">${escapeHtml(item.hrm_kpi_pegawai_score)}</td>
                                    <td><span class="opacity-75 fs--2">${escapeHtml(item.hrm_kpi_pegawai_catatan ?? '-')}</span></td>
                                </tr>
                                `;
                            });
                        } else {
                            detailRows = `
                            <tr>
                                <td colspan="7" class="text-center py-4 opacity-75 fs--1">Belum ada rincian indikator KPI pada periode ini.</td>
                            </tr>
                            `;
                        }

                        modalBody.innerHTML = `
                        <div class="row g-3 mb-4">
                            <div class="col-md-7">
                                <div class="p-3 ent-sub-box h-100">
                                    <h6 class="fw-bold mb-2 fs-1">${escapeHtml(p.hrm_m_pegawai_name)}</h6>
                                    <div class="opacity-75 fs--1 mb-1 ent-mono"><i class="fas fa-id-badge me-2 text-primary"></i>NIP: <strong>${escapeHtml(p.hrm_m_pegawai_nip)}</strong></div>
                                    <div class="opacity-75 fs--1 mb-2"><i class="fas fa-building me-2 text-primary"></i>Dept: <strong>${escapeHtml(p.hrm_departemen_name ?? '-')}</strong></div>
                                    <div class="opacity-75 fs--1">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>Periode:
                                        <span class="ent-badge fs--2 ent-mono ms-1" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.22);">${escapeHtml(data.periode)}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="p-3 rounded-3 text-center h-100 d-flex flex-column justify-content-center"
                                    style="background: rgba(79, 70, 229, 0.08); border: 1px solid rgba(79, 70, 229, 0.22);">
                                    <span class="text-uppercase fw-bold text-primary fs--2">Total Skor Performance</span>
                                    <div class="fw-bold text-primary my-1 ent-mono" style="font-size: 1.5rem !important;">${r ? escapeHtml(r.hrm_kpi_rekap_total) : '0'}</div>
                                    <div>
                                        <span class="ent-badge fs--2" style="background: #4f46e5; color: #ffffff;">
                                            ${r ? escapeHtml(r.hrm_kpi_rekap_cat) : '-'}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-2 fs-1"><i class="fas fa-tasks text-primary me-2"></i>Rincian Indikator KPI</h6>
                        <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                            <table class="table table-hover table-custom align-middle mb-0">
                                <thead>
                                    <tr class="fs--2">
                                        <th class="text-center">No</th>
                                        <th>Indikator</th>
                                        <th class="text-center">Bobot</th>
                                        <th class="text-center">Target</th>
                                        <th class="text-center">Realisasi</th>
                                        <th class="text-center">Skor</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody class="fs--1">
                                    ${detailRows}
                                </tbody>
                            </table>
                        </div>
                        `;
                    })
                    .catch(err => {
                        modalBody.innerHTML = `
                        <div class="text-center py-4 text-danger fs--1">
                            <i class="fas fa-exclamation-circle fs-1 mb-2 d-block"></i>
                            <p class="mb-0 fw-semibold">${escapeHtml(err.message)}</p>
                        </div>
                        `;
                    });
            });
        });
    });
</script>
@endsection
