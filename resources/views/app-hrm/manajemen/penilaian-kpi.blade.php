@extends('layouts.layouts')

@section('base.css')
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

    .ent-input[readonly] {
        opacity: 0.85;
        background-color: rgba(79, 70, 229, 0.04) !important;
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
        padding: 11px 14px;
        white-space: nowrap;
    }

    .table-custom tbody td {
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 10px 14px;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.04) !important;
    }

    .avatar-sm-initial {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(79, 70, 229, 0.12);
        border: 1px solid rgba(79, 70, 229, 0.24);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #6366f1;
        flex-shrink: 0;
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
                        <i class="fas fa-user-check fs-1 text-white"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge fs--2" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                                <i class="fas fa-bullseye"></i> KPI Evaluation Module
                            </span>
                            <span class="fs--2 fw-semibold" style="color: #94a3b8;">{{ env('APP_LABEL', 'INNOVENTRA') }} Management System</span>
                        </div>
                        <h4 class=" fw-bold mb-0 fs-1" style="letter-spacing: -0.02em;color: white;">
                            Penilaian Key Performance Indicator (KPI)
                        </h4>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">Input realisasi indikator kinerja pegawai per periode dan pantau rekapitulasi skor serta predikat evaluasi.</p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="ent-glass-pill px-3 py-2 d-inline-block text-start">
                        <span class="d-block text-uppercase fs--2" style="color: #94a3b8;">Total Rekapitulasi</span>
                        <span class="fw-bold fs-1 ent-mono" style="color: #7dd3fc;">
                            <i class="fas fa-chart-line me-1 fs--1"></i> {{ count($rekaps) }} Record
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- Alert Notifikasi --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show ent-card p-3 mb-3 fs--1" role="alert">
    <i class="fas fa-check-circle me-2 text-success"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show ent-card p-3 mb-3 fs--1" role="alert">
    <i class="fas fa-exclamation-circle me-2 text-danger"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- 1. FORM INPUT PENILAIAN KPI --}}
<div class="card ent-card mb-3 fs-2">
    <div class="ent-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h6 class="mb-0 fs-1 fw-bold"><i class="fas fa-user-check me-2 text-primary"></i>Form Penilaian Key Performance Indicator (KPI)</h6>
            <span class="opacity-75 fs--1">Pilih pegawai dan periode untuk memuat indikator KPI sesuai departemen.</span>
        </div>
    </div>
    <div class="card-body p-3 p-md-4">
        <form action="{{ route('kpi.penilaian.store') }}" method="POST">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-8">
                    <label class="form-label fw-bold fs--1 mb-1">
                        <i class="fas fa-user-tie me-1 text-primary"></i> Pilih Pegawai &amp; Departemen
                    </label>

                    @if(Auth::check() && Auth::user()->access_code == 'master')
                    {{-- Dropdown Akses Master --}}
                    <select name="hrm_m_pegawai_code" id="pegawai_select" class="form-select ent-select fs-2" required>
                        <option value="" data-dept="">-- Pilih Pegawai --</option>
                        @foreach($pegawais as $p)
                        <option value="{{ $p->hrm_m_pegawai_code }}" data-dept="{{ $p->hrm_m_position_code }}">
                            {{ $p->hrm_m_pegawai_name }} ({{ $p->hrm_m_pegawai_nip }}) - Dept: {{ $p->hrm_departemen_name ?? 'N/A' }}
                        </option>
                        @endforeach
                    </select>
                    @else
                    {{-- Dropdown Terkunci untuk Akses Pegawai Biasa --}}
                    @php
                    $userNip = Auth::user()->userid ?? '';
                    $pegawaiLogin = $pegawais->firstWhere('hrm_m_pegawai_nip', $userNip);
                    @endphp

                    @if($pegawaiLogin)
                    <input type="hidden" name="hrm_m_pegawai_code" id="pegawai_code_hidden" value="{{ $pegawaiLogin->hrm_m_pegawai_code }}">
                    <input type="hidden" id="pegawai_dept_hidden" value="{{ $pegawaiLogin->hrm_m_position_code }}">
                    <input type="text" class="form-control ent-input fw-bold fs-2" value="{{ $pegawaiLogin->hrm_m_pegawai_name }} ({{ $pegawaiLogin->hrm_m_pegawai_nip }}) - Dept: {{ $pegawaiLogin->hrm_departemen_name ?? 'N/A' }}" readonly>
                    @else
                    <input type="text" class="form-control ent-input is-invalid fs-2" value="Data Pegawai Tidak Ditemukan (NIP: {{ $userNip }})" readonly>
                    <small class="text-danger fs--2 mt-1 d-block">NIP akun Anda tidak cocok dengan data master pegawai.</small>
                    @endif
                    @endif
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold fs--1 mb-1">
                        <i class="far fa-calendar-alt me-1 text-primary"></i> Periode Penilaian
                    </label>
                    <input type="month" name="hrm_kpi_pegawai_periode" id="hrm_kpi_pegawai_periode" class="form-control ent-input ent-mono fs-2" value="{{ date('Y-m') }}" required>
                </div>
            </div>

            <div class="table-responsive rounded-3 mb-3" style="border: 1px solid var(--ent-grid-border);">
                <table class="table table-hover table-custom align-middle mb-0 fs-2" id="kpi_table">
                    <thead>
                        <tr class="fs--2">
                            <th style="width: 35%;">Indikator KPI</th>
                            <th style="width: 10%;" class="text-center">Bobot (%)</th>
                            <th style="width: 10%;" class="text-center">Target</th>
                            <th style="width: 20%;">Realisasi / Capaian</th>
                            <th style="width: 25%;">Catatan Evaluator</th>
                        </tr>
                    </thead>
                    <tbody id="kpi_container" class="fs--1">
                        <tr>
                            <td colspan="5" class="text-center py-4 opacity-75">Silakan pilih pegawai terlebih dahulu.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn ent-btn ent-btn-primary px-4 py-2 fs--1">
                    <i class="fas fa-paper-plane me-1"></i> Simpan &amp; Hitung Penilaian
                </button>
            </div>
        </form>
    </div>
</div>

{{-- 2. TABEL REKAPITULASI HASIL KPI --}}
<div class="card ent-card fs-2">
    <div class="ent-card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h6 class="mb-0 fs-1 fw-bold"><i class="fas fa-chart-line me-2 text-primary"></i>Rekapitulasi Hasil Penilaian KPI</h6>
            <span class="opacity-75 fs--1">Daftar rekapitulasi skor akhir dan kategori performa pegawai.</span>
        </div>
        <span class="ent-badge fs--2 ent-mono" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.22);">
            {{ count($rekaps) }} Record
        </span>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
            <table class="table table-hover table-custom align-middle mb-0 fs-2">
                <thead>
                    <tr class="fs--2">
                        <th class="text-center" style="width: 48px;">No</th>
                        <th>Kode Rekap</th>
                        <th>Pegawai</th>
                        <th class="text-center">Periode</th>
                        <th class="text-center">Total Skor</th>
                        <th>Kategori / Predikat</th>
                        <th class="text-center" style="width: 110px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                    @forelse($rekaps as $index => $rekap)
                    @php
                    $catText = $rekap->hrm_kpi_rekap_cat ?? '-';
                    $catStyle = 'background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.25);';
                    if (str_contains($catText, 'Sangat Baik') || str_contains($catText, 'A')) {
                        $catStyle = 'background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);';
                    } elseif (str_contains($catText, 'Baik') || str_contains($catText, 'B')) {
                        $catStyle = 'background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.25);';
                    } elseif (str_contains($catText, 'Cukup') || str_contains($catText, 'C')) {
                        $catStyle = 'background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.28);';
                    }
                    @endphp
                    <tr>
                        <td class="text-center ent-mono fw-semibold">{{ $index + 1 }}</td>
                        <td class="ent-mono">
                            <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.08); border: 1px solid var(--ent-grid-border);">
                                {{ $rekap->hrm_kpi_rekap_code }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm-initial me-2 fs--1">
                                    {{ strtoupper(substr($rekap->hrm_m_pegawai_name ?? 'P', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold fs-2">{{ $rekap->hrm_m_pegawai_name ?? 'N/A' }}</div>
                                    <div class="opacity-75 fs--2 ent-mono">NIP: {{ $rekap->hrm_m_pegawai_nip ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center ent-mono">
                            <span class="ent-badge fs--2" style="background: rgba(100, 116, 139, 0.14); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.25);">
                                {{ $rekap->hrm_kpi_rekap_periode }}
                            </span>
                        </td>
                        <td class="text-center fs-1 fw-bold text-primary ent-mono">{{ $rekap->hrm_kpi_rekap_total }}</td>
                        <td>
                            <span class="ent-badge fs--2" style="{{ $catStyle }}">{{ $catText }}</span>
                        </td>
                        <td class="text-center text-nowrap">
                            <button type="button"
                                class="btn btn-sm ent-btn btn-outline-primary py-1 px-3 fs--2 btn-detail-modal"
                                data-pegawai="{{ $rekap->hrm_m_pegawai_code }}"
                                data-periode="{{ $rekap->hrm_kpi_rekap_periode }}">
                                <i class="fas fa-eye me-1"></i> Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center opacity-75 py-5 fs--1">
                            <i class="fas fa-folder-open fs-1 mb-2 d-block text-primary"></i>
                            Belum ada data rekapitulasi penilaian KPI.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL DETAIL EVALUASI KPI MODERN --}}
<div class="modal fade" id="modalDetailKpi" tabindex="-1" aria-labelledby="modalDetailKpiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ent-card border-0 shadow-lg fs-2">
            <div class="modal-header text-white py-3 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-id-card me-2 fs-1 text-warning"></i>
                    <h6 class="modal-title fs-1 fw-bold text-white mb-0" id="modalDetailKpiLabel">Rincian Evaluasi KPI Pegawai</h6>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="modal_kpi_body">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 opacity-75 fs--1">Memuat detail evaluasi...</p>
                </div>
            </div>
            <div class="modal-footer px-4 py-3" style="border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn btn-secondary px-4 fs--1" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let selectPegawai = document.getElementById('pegawai_select');
        let hiddenDept = document.getElementById('pegawai_dept_hidden');
        let inputPeriode = document.getElementById('hrm_kpi_pegawai_periode');

        function escapeHtml(text) {
            return String(text || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        // Helper function untuk mengambil deptCode aktif saat ini
        function getCurrentDeptCode() {
            if (selectPegawai) {
                let selectedOption = selectPegawai.options[selectPegawai.selectedIndex];
                return selectedOption ? selectedOption.getAttribute('data-dept') : '';
            }
            if (hiddenDept) {
                return hiddenDept.value || '';
            }
            return '';
        }

        function loadKpiByDeptCode(deptCode) {
            let container = document.getElementById('kpi_container');

            // Tangkap kode pegawai dan periode terbaru dari input form
            let pegawaiCode = document.getElementById('pegawai_select')?.value || document.getElementById('pegawai_code_hidden')?.value || '';
            let periode = inputPeriode?.value || '';

            if (!deptCode) {
                container.innerHTML = '<tr><td colspan="5" class="text-center py-4 opacity-75 fs--1">Silakan pilih pegawai terlebih dahulu.</td></tr>';
                return;
            }

            container.innerHTML = '<tr><td colspan="5" class="text-center py-4 fs--1"><i class="fas fa-spinner fa-spin me-2 text-primary"></i> Memuat indikator KPI...</td></tr>';

            // Mengirim query parameter pegawai_code & periode
            fetch(`{{ url('hrm/manajemen/kpi-dan-target/getKpiByDept') }}/${encodeURIComponent(deptCode)}?pegawai_code=${encodeURIComponent(pegawaiCode)}&periode=${encodeURIComponent(periode)}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (!Array.isArray(data) || data.length === 0) {
                        container.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-danger fs--1">Tidak ada indikator KPI untuk departemen ini.</td></tr>';
                        return;
                    }

                    let html = '';
                    data.forEach(kpi => {
                        let isAuto = (kpi.hrm_kpi_master_type !== 'manual');
                        let readOnlyAttr = isAuto ? 'readonly' : '';
                        let val = (kpi.auto_calculated_value !== null && kpi.auto_calculated_value !== undefined) ? kpi.auto_calculated_value : '';

                        html += `
                        <tr>
                            <td>
                                <div class="fw-bold fs-2">${escapeHtml(kpi.hrm_kpi_master_name)}</div>
                                <small class="opacity-75 d-block fs--2">${escapeHtml(kpi.hrm_kpi_master_desc ?? '-')}</small>
                            </td>
                            <td class="text-center ent-mono">
                                <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.08); border: 1px solid var(--ent-grid-border);">${escapeHtml(kpi.hrm_kpi_master_bobot)}%</span>
                            </td>
                            <td class="text-center fw-semibold ent-mono fs--1">${escapeHtml(kpi.hrm_kpi_master_target)}</td>
                            <td>
                                <input type="number" step="0.01"
                                       name="values[${escapeHtml(kpi.hrm_kpi_master_code)}]"
                                       value="${escapeHtml(val)}"
                                       class="form-control ent-input ent-mono fs-2"
                                       placeholder="Nilai Realisasi" required ${readOnlyAttr}>
                            </td>
                            <td>
                                <input type="text" name="catatan[${escapeHtml(kpi.hrm_kpi_master_code)}]" class="form-control ent-input fs-2" placeholder="Catatan Evaluator (Opsional)">
                            </td>
                        </tr>`;
                    });
                    container.innerHTML = html;
                })
                .catch(error => {
                    console.error(error);
                    container.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-danger fs--1">Gagal mengambil data KPI.</td></tr>';
                });
        }

        // Event listener ketika dropdown pegawai diubah
        if (selectPegawai) {
            selectPegawai.addEventListener('change', function() {
                let selectedOption = this.options[this.selectedIndex];
                let deptCode = selectedOption ? selectedOption.getAttribute('data-dept') : '';
                loadKpiByDeptCode(deptCode);
            });
        }

        // Event listener ketika input bulan/periode diubah
        if (inputPeriode) {
            inputPeriode.addEventListener('change', function() {
                let deptCode = getCurrentDeptCode();
                if (deptCode) {
                    loadKpiByDeptCode(deptCode);
                }
            });
        }

        // Auto load saat pertama kali halaman terbuka (untuk user pegawai/non-master)
        let initialDeptCode = getCurrentDeptCode();
        if (initialDeptCode) {
            loadKpiByDeptCode(initialDeptCode);
        }

        // Handler Modal Detail
        const modalElement = new bootstrap.Modal(document.getElementById('modalDetailKpi'));
        const modalBody = document.getElementById('modal_kpi_body');

        document.querySelectorAll('.btn-detail-modal').forEach(button => {
            button.addEventListener('click', function() {
                let pegawaiCode = this.getAttribute('data-pegawai');
                let periode = this.getAttribute('data-periode');

                modalBody.innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 opacity-75 fs--1 fw-semibold">Mengambil Data Evaluasi...</p>
                    </div>
                `;
                modalElement.show();

                fetch(`{{ url('hrm/manajemen/kpi-dan-target/getDetailAjax') }}/${encodeURIComponent(pegawaiCode)}/${encodeURIComponent(periode)}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Akses ditolak atau data tidak ditemukan');
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
                                            <i class="far fa-calendar-alt me-2 text-primary"></i>Periode:
                                            <span class="ent-badge fs--2 ent-mono ms-1" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.22);">${escapeHtml(data.periode)}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="p-3 rounded-3 text-center text-white h-100 d-flex flex-column justify-content-center"
                                        style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border: 1px solid rgba(99, 102, 241, 0.3);">
                                        <span class="text-uppercase fw-bold fs--2" style="color: #94a3b8;">Total Skor Performance</span>
                                        <div class="fw-bold text-white my-1 ent-mono" style="font-size: 1.5rem !important;">${r ? escapeHtml(r.hrm_kpi_rekap_total) : '0'}</div>
                                        <div>
                                            <span class="ent-badge fs--2" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                                                ${r ? escapeHtml(r.hrm_kpi_rekap_cat) : '-'}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h6 class="fw-bold mb-2 fs-1"><i class="fas fa-list me-2 text-primary"></i>Rincian Indikator KPI</h6>
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
                                            <th>Catatan Evaluator</th>
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
