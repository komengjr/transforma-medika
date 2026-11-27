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

    .cardreader:hover {
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
        min-height: 40px;
        border-radius: 10px !important;
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        padding: 7px 12px !important;
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
        padding: 11px 12px;
        white-space: nowrap;
    }

    .table-custom tbody td {
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 10px 12px;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.04) !important;
    }

    .ent-mono {
        font-family: 'JetBrains Mono', monospace;
    }

    .rule-pill {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 12px 14px;
        background: rgba(79, 70, 229, 0.03);
    }
</style>
@endsection

@section('content')
{{-- 1. HERO BANNER HEADER --}}
<header class="mb-3 fs-2">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center justify-content-between gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 56px; height: 56px;">
                        <img src="{{ asset('img/app.png') }}" alt="Logo" width="36" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge fs--2" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                                <i class="fas fa-shield-alt"></i> {{ env('APP_NAME', 'INNOVENTRA') }} PAYROLL ENGINE
                            </span>
                            <span class="fs--2 fw-semibold" style="color: #94a3b8;">Menu: Pengaturan BPJS &amp; PPh 21 ({{ $code ?? '' }})</span>
                        </div>
                        <h4 class="text-white fw-bold mb-0 fs-1" style="letter-spacing: -0.02em;">
                            Pengaturan Potongan BPJS Kes, BPJS TK &amp; Pajak PPh 21
                        </h4>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">
                            Konfigurasi tarif global, penerapan massal per Divisi / Jabatan, serta penyesuaian PTKP &amp; kepesertaan per pegawai.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-inline-flex flex-wrap gap-2 justify-content-lg-end">
                        <button type="button" class="btn btn-sm ent-btn ent-glass-pill px-3 py-2 fs--1" data-bs-toggle="modal" data-bs-target="#modalMasterTarif">
                            <i class="fas fa-sliders-h me-1 text-warning"></i> Tarif Baku &amp; TER
                        </button>
                        <button type="button" class="btn btn-sm ent-btn px-3 py-2 fs--1 fw-bold"
                            style="background: rgba(56, 189, 248, 0.24); border: 1px solid rgba(56, 189, 248, 0.45); color: #ffffff;"
                            data-bs-toggle="modal" data-bs-target="#modalBulkAssign">
                            <i class="fas fa-users-cog me-1"></i> Atur Massal (Divisi/Jabatan)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- 2. RINGKASAN KONFIGURASI TARIF & SUMMARY CARD --}}
<div class="row g-3 mb-3 fs-2">
    <div class="col-sm-6 col-xl-3">
        <div class="card ent-card cardreader p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">BPJS Kesehatan</div>
                    <div class="fs-1 fw-bold text-primary ent-mono">{{ $bpjsConfig->bpjs_kes_karyawan_persen }}% <span class="fs--2 opacity-75 fw-normal">Karyawan</span></div>
                    <small class="opacity-75 fs--2">Perusahaan {{ $bpjsConfig->bpjs_kes_perusahaan_persen }}% • Maks. Rp {{ number_format($bpjsConfig->bpjs_kes_max_upah, 0, ',', '.') }}</small>
                </div>
                <div class="icon-shape" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                    <i class="fas fa-heartbeat fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card ent-card cardreader p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">BPJS Ketenagakerjaan</div>
                    <div class="fs-1 fw-bold text-info ent-mono">{{ $bpjsConfig->bpjs_jht_karyawan_persen + $bpjsConfig->bpjs_jp_karyawan_persen }}% <span class="fs--2 opacity-75 fw-normal">(JHT+JP)</span></div>
                    <small class="opacity-75 fs--2">JKK {{ $bpjsConfig->bpjs_jkk_perusahaan_persen }}% &amp; JKM {{ $bpjsConfig->bpjs_jkm_perusahaan_persen }}% PT</small>
                </div>
                <div class="icon-shape" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.24);">
                    <i class="fas fa-hard-hat fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card ent-card cardreader p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Skema Pajak PPh 21</div>
                    <div class="fs-1 fw-bold text-warning ent-mono">TER <span class="fs--2 opacity-75 fw-normal">Kat. A / B / C</span></div>
                    <small class="opacity-75 fs--2">Otomatis dari Status PTKP &amp; Bruto</small>
                </div>
                <div class="icon-shape" style="background: rgba(245, 158, 11, 0.14); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.24);">
                    <i class="fas fa-percent fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card ent-card cardreader p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Total Potongan Periode Ini</div>
                    <div id="summaryTotalPotongan" class="fs-1 fw-bold text-danger ent-mono">Rp 0</div>
                    <small class="opacity-75 fs--2">BPJS Kes + BPJS TK + PPh 21</small>
                </div>
                <div class="icon-shape" style="background: rgba(225, 29, 72, 0.12); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.2);">
                    <i class="fas fa-file-invoice-dollar fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 3. FILTER & PENCARIAN PEGAWAI --}}
<div class="card ent-card mb-3 fs-2">
    <div class="card-body p-3 p-md-4">
        <form id="filterPotonganForm" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-sitemap me-1 text-primary"></i> Filter Divisi
                </label>
                <select id="filterDivisi" class="form-select ent-select fs-2">
                    <option value="">Semua Divisi</option>
                    @foreach($listDepartemen as $dept)
                    <option value="{{ $dept->hrm_departemen_code }}">{{ $dept->hrm_departemen_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-user-tag me-1 text-primary"></i> Filter Jabatan
                </label>
                <select id="filterJabatan" class="form-select ent-select fs-2">
                    <option value="">Semua Jabatan</option>
                    @foreach($listJabatan as $jab)
                    <option value="{{ $jab->hrm_jabatan_code }}">{{ $jab->hrm_jabatan_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="fas fa-id-badge me-1 text-primary"></i> Status PTKP
                </label>
                <select id="filterPtkp" class="form-select ent-select fs-2">
                    <option value="">Semua PTKP</option>
                    @foreach($listPtkp as $ptkp)
                    <option value="{{ $ptkp->hrm_ptkp_code }}">{{ $ptkp->hrm_ptkp_code }} (Kat. {{ $ptkp->hrm_ter_kategori }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold fs--1 mb-1">
                    <i class="far fa-calendar-alt me-1 text-primary"></i> Periode Payroll
                </label>
                <input type="month" id="filterPeriode" class="form-control ent-input ent-mono fs-2" value="{{ $periode ?? now()->format('Y-m') }}">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn ent-btn ent-btn-primary w-100 py-2 fs-2">
                    <i class="fas fa-filter me-1"></i> Terapkan
                </button>
                <button type="button" id="btnResetFilter" class="btn ent-btn btn-light border px-3 py-2 fs-2" title="Reset Filter">
                    <i class="fas fa-redo-alt"></i>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- 4. TABEL MASTER POTONGAN PEGAWAI (BPJS KES, BPJS TK & PPH 21) --}}
<div class="card ent-card mb-3 fs-2">
    <div class="ent-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h6 class="mb-0 fw-bold fs-1"><i class="fas fa-table text-primary me-2"></i>Daftar Potongan BPJS Kesehatan, BPJS TK &amp; PPh 21 Pegawai</h6>
            <span class="opacity-75 fs--1">Klik tombol pengaturan pada baris pegawai untuk menyesuaikan status kepesertaan BPJS, PTKP, atau metode pajak.</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" id="btnReloadData" class="btn btn-sm ent-btn btn-outline-secondary px-3 py-1 fs--2">
                <i class="fas fa-sync-alt me-1"></i> Muat Ulang
            </button>
            <button type="button" id="btnSimpanPeriode" class="btn btn-sm ent-btn ent-btn-primary px-3 py-1 fs--2">
                <i class="fas fa-database me-1"></i> Simpan Rekap Periode
            </button>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">
        <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
            <table id="tabelPotonganPegawai" class="table table-hover table-custom align-middle mb-0 w-100 fs-2">
                <thead>
                    <tr class="fs--2">
                        <th class="text-center" style="width: 44px;">No</th>
                        <th>Pegawai, Divisi &amp; Jabatan</th>
                        <th class="text-end">Dasar Upah / Bruto</th>
                        <th class="text-end">BPJS Kesehatan</th>
                        <th class="text-end">BPJS TK (JHT+JP)</th>
                        <th class="text-end">Pajak PPh 21 (TER)</th>
                        <th class="text-end">Total Potongan</th>
                        <th class="text-center" style="width: 110px;">Pengaturan</th>
                    </tr>
                </thead>
                <tbody id="tbodyPotonganPegawai" class="fs--1"></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
{{-- MODAL 1: PENGATURAN MASSAL BERDASARKAN DIVISI / JABATAN --}}
<div class="modal fade" id="modalBulkAssign" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content ent-card border-0 shadow-lg fs-2">
            <div class="modal-header text-white py-3 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-users-cog me-2 fs-1 text-warning"></i>
                    <h5 class="modal-title fs-1 fw-bold text-white mb-0">Atur Skema Potongan Massal (Divisi / Jabatan)</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div class="rule-pill mb-3 fs--1">
                    <i class="fas fa-info-circle text-primary me-1"></i>
                    Perubahan skema massal disimpan langsung ke tabel <strong>hrm_pegawai_pajak_bpjs</strong>.
                </div>

                <form id="formBulkAssign" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold fs--1 mb-1">Target Penerapan</label>
                        <select id="bulkTargetType" class="form-select ent-select fs-2" onchange="toggleBulkTarget()">
                            <option value="all">Semua Pegawai Aktif</option>
                            <option value="divisi">Berdasarkan Divisi</option>
                            <option value="jabatan">Berdasarkan Jabatan</option>
                        </select>
                    </div>
                    <div class="col-md-6" id="bulkTargetValueBox" style="display: none;">
                        <label class="form-label fw-bold fs--1 mb-1" id="bulkTargetLabel">Pilih Target</label>
                        <select id="bulkTargetValue" class="form-select ent-select fs-2"></select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold fs--1 mb-1">BPJS Kesehatan</label>
                        <select id="bulkBpjsKes" class="form-select ent-select fs-2">
                            <option value="keep">-- Tidak Diubah --</option>
                            <option value="1">Aktif (Potong Karyawan)</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold fs--1 mb-1">BPJS TK (JHT &amp; JP)</label>
                        <select id="bulkBpjsTk" class="form-select ent-select fs-2">
                            <option value="keep">-- Tidak Diubah --</option>
                            <option value="FULL">Lengkap (JHT + JP)</option>
                            <option value="JHT_ONLY">JHT Saja</option>
                            <option value="NONAKTIF">Nonaktif</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold fs--1 mb-1">Metode Pajak PPh 21</label>
                        <select id="bulkMetodePajak" class="form-select ent-select fs-2">
                            <option value="keep">-- Tidak Diubah --</option>
                            <option value="GROSS">Gross (Potong Pegawai)</option>
                            <option value="NET">Net (Ditanggung PT)</option>
                            <option value="GROSS_UP">Gross-Up (Tunjangan Pajak)</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer px-4 py-3 gap-2" style="border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn btn-secondary px-4 fs--1" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn ent-btn ent-btn-primary px-4 fs--1" onclick="terapkanBulkAssign()">
                    <i class="fas fa-check-circle me-1"></i> Terapkan &amp; Simpan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL 2: PENGATURAN INDIVIDUAL PER PEGAWAI --}}
<div class="modal fade" id="modalEditPegawai" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content ent-card border-0 shadow-lg fs-2">
            <div class="modal-header text-white py-3 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-cog me-2 fs-1 text-warning"></i>
                    <h5 class="modal-title fs-1 fw-bold text-white mb-0">Pengaturan Potongan Pegawai</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <input type="hidden" id="editPegawaiCode">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold fs--1 mb-1">Nama &amp; NIK Pegawai</label>
                        <input type="text" id="editNamaNik" class="form-control ent-input fs-2" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold fs--1 mb-1">Divisi &amp; Jabatan</label>
                        <input type="text" id="editDivisiJabatan" class="form-control ent-input fs-2" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold fs--1 mb-1">Gaji Pokok (Rp)</label>
                        <input type="number" id="editGajiPokok" class="form-control ent-input ent-mono fs-2" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold fs--1 mb-1">Tunjangan Tetap (Rp)</label>
                        <input type="number" id="editTunjanganTetap" class="form-control ent-input ent-mono fs-2" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold fs--1 mb-1">Dasar Upah BPJS (Rp)</label>
                        <input type="number" id="editUpahBpjs" class="form-control ent-input ent-mono fs-2" min="0">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold fs--1 mb-1">Status PTKP (Penentu TER)</label>
                        <select id="editPtkp" class="form-select ent-select fs-2">
                            @foreach($listPtkp as $ptkp)
                            <option value="{{ $ptkp->hrm_ptkp_code }}">{{ $ptkp->hrm_ptkp_code }} (Kat. {{ $ptkp->hrm_ter_kategori }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold fs--1 mb-1">No. NPWP &amp; Status</label>
                        <div class="input-group">
                            <input type="text" id="editNpwp" class="form-control ent-input ent-mono fs-2" placeholder="09.xxx.xxx.x-xxx.xxx">
                            <select id="editHasNpwp" class="form-select ent-select fs-2" style="max-width: 110px;">
                                <option value="1">Valid</option>
                                <option value="0">Non-NPWP</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold fs--1 mb-1">Metode PPh 21</label>
                        <select id="editMetodePajak" class="form-select ent-select fs-2">
                            <option value="GROSS">Gross (Potong Pegawai)</option>
                            <option value="NET">Net (Ditanggung PT)</option>
                            <option value="GROSS_UP">Gross-Up (Tunjangan Pajak)</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold fs--1 mb-1">Kepesertaan BPJS Kesehatan</label>
                        <select id="editBpjsKes" class="form-select ent-select fs-2">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold fs--1 mb-1">Kepesertaan BPJS Ketenagakerjaan</label>
                        <select id="editBpjsTk" class="form-select ent-select fs-2">
                            <option value="FULL">Lengkap (JHT + JP)</option>
                            <option value="JHT_ONLY">JHT Saja</option>
                            <option value="NONAKTIF">Nonaktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer px-4 py-3 gap-2" style="border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn btn-secondary px-4 fs--1" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn ent-btn ent-btn-primary px-4 fs--1" onclick="simpanEditPegawai()">
                    <i class="fas fa-save me-1"></i> Simpan ke Database
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL 3: PARAMETER TARIF BAKU --}}
<div class="modal fade" id="modalMasterTarif" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content ent-card border-0 shadow-lg fs-2">
            <div class="modal-header text-white py-3 px-4"
                style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border-top-left-radius: 14px; border-top-right-radius: 14px;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-sliders-h me-2 fs-1 text-warning"></i>
                    <h5 class="modal-title fs-1 fw-bold text-white mb-0">Parameter Tarif Baku BPJS &amp; PPh 21</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold fs--1 mb-1">Batas Atas Upah BPJS Kes (Rp)</label>
                        <input type="number" id="cfgMaxBpjsKes" class="form-control ent-input ent-mono fs-2" value="{{ $bpjsConfig->bpjs_kes_max_upah }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold fs--1 mb-1">Batas Atas Upah JP BPJS TK (Rp)</label>
                        <input type="number" id="cfgMaxJp" class="form-control ent-input ent-mono fs-2" value="{{ $bpjsConfig->bpjs_jp_max_upah }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold fs--1 mb-1">Tarif JKK Default (%)</label>
                        <input type="number" step="0.01" id="cfgTarifJkk" class="form-control ent-input ent-mono fs-2" value="{{ $bpjsConfig->bpjs_jkk_perusahaan_persen }}">
                    </div>
                </div>
            </div>
            <div class="modal-footer px-4 py-3" style="border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn ent-btn-primary px-4 fs--1" onclick="simpanMasterTarif()">
                    <i class="fas fa-check me-1"></i> Simpan Tarif
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const csrfToken = '{{ csrf_token() }}';
    const urlGetData = "{{ route('hrm.payroll.bpjs-pajak.data') }}";
    const urlSimpanPegawai = "{{ route('hrm.payroll.bpjs-pajak.simpan-pegawai') }}";
    const urlSimpanMassal = "{{ route('hrm.payroll.bpjs-pajak.simpan-massal') }}";
    const urlSimpanTarif = "{{ route('hrm.payroll.bpjs-pajak.simpan-tarif') }}";
    const urlSimpanPeriode = "{{ route('hrm.payroll.bpjs-pajak.simpan-periode') }}";

    const masterDepartemen = @json($listDepartemen ?? []);
    const masterJabatan = @json($listJabatan ?? []);
    let daftarPegawai = @json($pegawaiData ?? []);
    let dataTableInstance = null;

    function formatRupiah(angka) {
        return 'Rp ' + Math.round(Number(angka || 0)).toLocaleString('id-ID');
    }

    async function postJson(url, payload) {
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(payload)
        });
        const data = await res.json();
        if (!res.ok) {
            throw new Error(data.message || 'Terjadi kesalahan saat menyimpan data.');
        }
        return data;
    }

    async function muatDataPegawai(showToast = false) {
        const params = new URLSearchParams({
            periode: document.getElementById('filterPeriode').value || '',
            divisi: document.getElementById('filterDivisi').value || '',
            jabatan: document.getElementById('filterJabatan').value || '',
            ptkp: document.getElementById('filterPtkp').value || '',
        });

        try {
            const res = await fetch(`${urlGetData}?${params.toString()}`, {
                headers: {
                    'Accept': 'application/json'
                }
            });
            const json = await res.json();
            if (!res.ok || json.status !== 'success') {
                throw new Error(json.message || 'Gagal memuat data potongan pegawai.');
            }

            daftarPegawai = Array.isArray(json.data) ? json.data : [];
            renderTabelPegawai(json.total_potongan);

            if (showToast) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Data potongan diperbarui',
                    showConfirmButton: false,
                    timer: 1600
                });
            }
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Memuat Data',
                text: err.message
            });
        }
    }

    function renderTabelPegawai(totalDariServer = null) {
        if (dataTableInstance) {
            dataTableInstance.destroy();
        }

        const tbody = document.getElementById('tbodyPotonganPegawai');
        tbody.innerHTML = '';
        let grandTotalPotongan = 0;

        daftarPegawai.forEach((p, idx) => {
            const h = p.perhitungan || {
                pot_bpjs_kes: 0,
                pot_bpjs_tk: 0,
                nilai_pph21: 0,
                tarif_ter_persen: 0,
                total_potongan: 0
            };
            grandTotalPotongan += Number(h.total_potongan || 0);

            const badgeKes = p.bpjsKesAktif ?
                `<span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);">Aktif</span>` :
                `<span class="ent-badge fs--2" style="background: rgba(148, 163, 184, 0.16); color: #64748b;">Nonaktif</span>`;

            const modeTkUpper = String(p.bpjsTkMode || '').toUpperCase();
            const labelTk = modeTkUpper === 'FULL' ? 'JHT + JP' : (modeTkUpper === 'JHT_ONLY' ? 'JHT Saja' : 'Nonaktif');
            const badgeTk = modeTkUpper !== 'NONAKTIF' ?
                `<span class="ent-badge fs--2" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.24);">${labelTk}</span>` :
                `<span class="ent-badge fs--2" style="background: rgba(148, 163, 184, 0.16); color: #64748b;">Nonaktif</span>`;

            const infoPajak = p.metodePajak === 'GROSS' ?
                `<span class="ent-badge fs--2" style="background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.28);">TER ${p.ter_kategori} (${h.tarif_ter_persen}%)</span>` :
                `<span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.24);">${p.metodePajak}</span>`;

            tbody.innerHTML += `
                <tr>
                    <td class="text-center ent-mono fw-semibold">${idx + 1}</td>
                    <td>
                        <div class="fw-bold fs-2">${p.nama} <span class="ent-mono fs--2 opacity-75">(${p.nik || p.code})</span></div>
                        <div class="d-flex flex-wrap gap-1 mt-1">
                            <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1;">${p.divisi}</span>
                            <span class="ent-badge fs--2" style="background: rgba(148, 163, 184, 0.15); color: inherit;">${p.jabatan}</span>
                            <span class="ent-badge fs--2 ent-mono" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">PTKP: ${p.ptkp}</span>
                        </div>
                    </td>
                    <td class="text-end ent-mono">
                        <div class="fw-semibold fs-2">${formatRupiah(p.brutoPajak)}</div>
                        <div class="opacity-75 fs--2">Upah BPJS: ${formatRupiah(p.upahBpjs)}</div>
                    </td>
                    <td class="text-end ent-mono">
                        <div class="fw-bold">${formatRupiah(h.pot_bpjs_kes)}</div>
                        <div class="mt-1">${badgeKes}</div>
                    </td>
                    <td class="text-end ent-mono">
                        <div class="fw-bold">${formatRupiah(h.pot_bpjs_tk)}</div>
                        <div class="mt-1">${badgeTk}</div>
                    </td>
                    <td class="text-end ent-mono">
                        <div class="fw-bold text-warning">${formatRupiah(h.nilai_pph21)}</div>
                        <div class="mt-1">${infoPajak}</div>
                    </td>
                    <td class="text-end ent-mono fw-bold text-danger fs-2">
                        ${formatRupiah(h.total_potongan)}
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm ent-btn btn-outline-primary px-3 py-1 fs--2" onclick="bukaEditPegawai('${p.code}')">
                            <i class="fas fa-sliders-h me-1"></i> Atur
                        </button>
                    </td>
                </tr>
            `;
        });

        const totalFinal = totalDariServer !== null ? Number(totalDariServer) : grandTotalPotongan;
        document.getElementById('summaryTotalPotongan').innerText = formatRupiah(totalFinal);

        dataTableInstance = new DataTable('#tabelPotonganPegawai', {
            responsive: true,
            language: {
                search: "Cari Pegawai:",
                lengthMenu: "Tampilkan _MENU_ pegawai",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ pegawai",
                emptyTable: "Tidak ada data potongan pegawai untuk filter ini",
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    next: '<i class="fas fa-angle-right"></i>',
                    previous: '<i class="fas fa-angle-left"></i>'
                }
            }
        });
    }

    function toggleBulkTarget() {
        const type = document.getElementById('bulkTargetType').value;
        const box = document.getElementById('bulkTargetValueBox');
        const label = document.getElementById('bulkTargetLabel');
        const select = document.getElementById('bulkTargetValue');

        if (type === 'all') {
            box.style.display = 'none';
            return;
        }

        box.style.display = 'block';
        select.innerHTML = '';

        if (type === 'divisi') {
            label.innerText = 'Pilih Divisi Target';
            masterDepartemen.forEach(d => {
                select.innerHTML += `<option value="${d.hrm_departemen_code}">${d.hrm_departemen_name}</option>`;
            });
        } else {
            label.innerText = 'Pilih Jabatan Target';
            masterJabatan.forEach(j => {
                select.innerHTML += `<option value="${j.hrm_jabatan_code}">${j.hrm_jabatan_name}</option>`;
            });
        }
    }

    async function terapkanBulkAssign() {
        const payload = {
            target_type: document.getElementById('bulkTargetType').value,
            target_value: document.getElementById('bulkTargetValue').value,
            is_bpjs_kes_aktif: document.getElementById('bulkBpjsKes').value,
            mode_bpjs_tk: document.getElementById('bulkBpjsTk').value,
            metode_pajak: document.getElementById('bulkMetodePajak').value,
        };

        try {
            const data = await postJson(urlSimpanMassal, payload);
            bootstrap.Modal.getInstance(document.getElementById('modalBulkAssign')).hide();
            await muatDataPegawai();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan',
                text: err.message
            });
        }
    }

    function bukaEditPegawai(code) {
        const p = daftarPegawai.find(item => item.code === code);
        if (!p) return;

        document.getElementById('editPegawaiCode').value = p.code;
        document.getElementById('editNamaNik').value = `${p.nama} (${p.nik || p.code})`;
        document.getElementById('editDivisiJabatan').value = `${p.divisi} — ${p.jabatan}`;
        document.getElementById('editGajiPokok').value = p.gajiPokok ?? 0;
        document.getElementById('editTunjanganTetap').value = p.tunjanganTetap ?? 0;
        document.getElementById('editUpahBpjs').value = p.upahBpjs ?? 0;
        document.getElementById('editPtkp').value = p.ptkp || 'TK/0';
        document.getElementById('editNpwp').value = (!p.npwp || p.npwp === '-') ? '' : p.npwp;
        document.getElementById('editHasNpwp').value = p.hasNpwp ? '1' : '0';
        document.getElementById('editMetodePajak').value = p.metodePajak || 'GROSS';
        document.getElementById('editBpjsKes').value = p.bpjsKesAktif ? '1' : '0';
        document.getElementById('editBpjsTk').value = String(p.bpjsTkMode || 'FULL').toUpperCase();

        new bootstrap.Modal(document.getElementById('modalEditPegawai')).show();
    }

    async function simpanEditPegawai() {
        const ptkpValue = document.getElementById('editPtkp').value || 'TK/0';

        const payload = {
            hrm_m_pegawai_code: document.getElementById('editPegawaiCode').value,
            hrm_ptkp_code: ptkpValue,
            npwp_nomor: document.getElementById('editNpwp').value || null,
            is_npwp_valid: parseInt(document.getElementById('editHasNpwp').value, 10) === 1,
            metode_pajak: document.getElementById('editMetodePajak').value,
            is_bpjs_kes_aktif: parseInt(document.getElementById('editBpjsKes').value, 10) === 1,
            mode_bpjs_tk: document.getElementById('editBpjsTk').value,
            gaji_pokok: parseFloat(document.getElementById('editGajiPokok').value || 0),
            tunjangan_tetap: parseFloat(document.getElementById('editTunjanganTetap').value || 0),
            dasar_upah_bpjs: parseFloat(document.getElementById('editUpahBpjs').value || 0),
        };

        try {
            const data = await postJson(urlSimpanPegawai, payload);
            bootstrap.Modal.getInstance(document.getElementById('modalEditPegawai')).hide();
            await muatDataPegawai();
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: data.message || 'Pengaturan pegawai tersimpan',
                showConfirmButton: false,
                timer: 1800
            });
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan',
                text: err.message
            });
        }
    }

    async function simpanMasterTarif() {
        const payload = {
            bpjs_kes_max_upah: parseFloat(document.getElementById('cfgMaxBpjsKes').value || 12000000),
            bpjs_jp_max_upah: parseFloat(document.getElementById('cfgMaxJp').value || 10547400),
            bpjs_jkk_perusahaan_persen: parseFloat(document.getElementById('cfgTarifJkk').value || 0.24),
        };

        try {
            const data = await postJson(urlSimpanTarif, payload);
            bootstrap.Modal.getInstance(document.getElementById('modalMasterTarif')).hide();
            await muatDataPegawai();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: data.message
            }).then(() => window.location.reload());
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan',
                text: err.message
            });
        }
    }

    $(document).ready(function() {
        renderTabelPegawai();

        $('#filterPotonganForm').on('submit', async function(e) {
            e.preventDefault();
            await muatDataPegawai(false);
        });

        $('#btnResetFilter').on('click', async function() {
            $('#filterPotonganForm')[0].reset();
            await muatDataPegawai(false);
        });

        $('#btnReloadData').on('click', async function() {
            await muatDataPegawai(true);
        });

        $('#btnSimpanPeriode').on('click', async function() {
            const periode = document.getElementById('filterPeriode').value;
            try {
                const data = await postJson(urlSimpanPeriode, {
                    periode_payroll: periode
                });
                Swal.fire({
                    icon: 'success',
                    title: 'Rekap Tersimpan',
                    text: data.message
                });
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: err.message
                });
            }
        });
    });
</script>
@endsection
