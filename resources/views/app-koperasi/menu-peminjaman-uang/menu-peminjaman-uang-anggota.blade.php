@extends('layouts.layouts')

@section('base.css')
<!-- Select2 CSS & Theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (PINJAMAN UANG)
       (ADAPTIVE LIGHT & DARK MODE BOOTSTRAP 5)
       ========================================= */
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-indigo-soft: rgba(79, 70, 229, 0.12);
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-emerald: #059669;
        --ent-sky: #0284c7;
        --ent-amber: #d97706;
        --ent-rose: #e11d48;
        --ent-action-bg: #eef2ff;
        --ent-action-color: #3730a3;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
        --ent-surface: #ffffff;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-action-bg: #1e293b;
        --ent-action-color: #a5b4fc;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
        --ent-surface: #0f172a;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Adaptive Enterprise Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card>.card-header {
        border-bottom: 1px solid var(--ent-grid-border) !important;
    }

    .ent-table-surface {
        background-color: var(--bs-body-bg, var(--ent-surface));
    }

    /* Hero Banner */
    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 16px;
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.22);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    /* Modern Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        cursor: pointer;
        font-size: 0.82rem;
    }

    .ent-btn:hover {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .ent-btn-primary:hover {
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    .ent-btn-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .ent-btn-success:hover {
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        color: #ffffff;
    }

    /* Form Controls & Select2 Adaptive */
    .ent-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
    }

    .form-control {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .ent-input,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        padding-top: 18px !important;
        padding-bottom: 5px !important;
        padding-left: 11px !important;
        font-size: 0.8rem !important;
        height: 44px !important;
        transition: all 0.2s ease;
    }

    .ent-form .form-control,
    .ent-form .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .ent-form .form-control:focus,
    .ent-form .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .ent-form .input-group-text {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        background-color: rgba(79, 70, 229, 0.08) !important;
        color: #4f46e5 !important;
        font-size: 0.8rem;
    }

    .ent-form .input-group>.input-group-text:first-child {
        border-right: none !important;
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    .ent-form .input-group>.form-control:not(:first-child),
    .ent-form .input-group>.form-select:not(:first-child) {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    .ent-form .input-group>.input-group-text:last-child {
        border-left: none !important;
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    .ent-form .input-group>.form-select:not(:last-child) {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.8rem !important;
        min-height: 38px !important;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    /* Summary KPI Boxes */
    .ent-kpi-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 12px 10px;
        background-color: rgba(79, 70, 229, 0.04);
        text-align: center;
        transition: transform 0.15s ease;
    }

    .ent-kpi-box:hover {
        transform: translateY(-1px);
    }

    /* Soft Badges */
    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    /* =========================================================
       TABLE WITH COLORED GRID BORDERS & SOLID ACTION BUTTON
       ========================================================= */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: var(--bs-body-color) !important;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        padding: 13px 12px;
        letter-spacing: 0.04em;
    }

    .table-custom thead th:first-child {
        border-left: none !important;
    }

    .table-custom thead th:last-child {
        border-right: none !important;
        padding-right: 18px !important;
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
        height: 1px;
    }

    .table-custom tbody tr:hover,
    .table-custom tbody tr:hover td:not(.action-cell-full) {
        background-color: rgba(79, 70, 229, 0.07) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 11px 12px;
        vertical-align: middle;
        font-size: 0.82rem;
    }

    .table-custom tbody td:first-child {
        border-left: none !important;
    }

    .table-custom tbody td:last-child {
        border-right: none !important;
        padding-right: 18px !important;
    }

    /* SOLID FULL-CELL ACTION BUTTON STYLING (NON-TRANSPARENT) */
    .table-custom td.action-cell-full {
        padding: 0 !important;
        height: 100%;
        vertical-align: stretch !important;
        background-color: var(--ent-action-bg) !important;
    }

    .table-custom td.action-cell-full>.dropdown,
    .table-custom td.action-cell-full>.btn-group {
        display: flex !important;
        width: 100% !important;
        height: 100% !important;
        background-color: var(--ent-action-bg);
    }

    .table-custom td.action-cell-full .dropdown>.btn,
    .table-custom td.action-cell-full .btn-group>.btn,
    .table-custom td.action-cell-full>.btn {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 100% !important;
        height: 100% !important;
        min-height: 52px;
        border-radius: 0 !important;
        margin: 0 !important;
        border: none !important;
        background-color: var(--ent-action-bg) !important;
        color: var(--ent-action-color) !important;
        opacity: 1 !important;
        box-shadow: inset 0 0 0 1px rgba(79, 70, 229, 0.16);
        transition: background-color 0.15s ease, color 0.15s ease;
    }

    .table-custom td.action-cell-full .dropdown>.btn:hover,
    .table-custom td.action-cell-full .dropdown>.btn:focus,
    .table-custom td.action-cell-full .dropdown>.btn.show,
    .table-custom td.action-cell-full .btn-group>.btn:hover,
    .table-custom td.action-cell-full>.btn:hover,
    .table-custom tbody tr:hover td.action-cell-full .dropdown>.btn {
        background-color: var(--ent-action-hover-bg) !important;
        color: var(--ent-action-hover-color) !important;
        opacity: 1 !important;
    }

    /* Zero horizontal padding/margin on flush card body & DataTables wrapper */
    .ent-card-body-flush {
        padding: 0 !important;
        margin: 0 !important;
    }

    .ent-card-body-flush .table-responsive {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }

    #table-log-pinjaman_wrapper>.row:first-child,
    #table-log-pinjaman_wrapper .dt-layout-row:first-child {
        padding: 16px 20px 12px 20px;
        margin: 0 !important;
    }

    #table-log-pinjaman_wrapper>.row:last-child,
    #table-log-pinjaman_wrapper .dt-layout-row:last-child {
        padding: 14px 20px 18px 20px;
        margin: 0 !important;
        border-top: 1px solid var(--ent-grid-border);
    }

    #table-log-pinjaman_wrapper .dt-layout-table {
        margin: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    #table-log-pinjaman_wrapper .dt-layout-table>.dt-layout-cell {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    #table-log-pinjaman_wrapper .dataTables_filter input,
    #table-log-pinjaman_wrapper .dt-search input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        padding: 6px 12px !important;
        font-size: 0.82rem !important;
        height: 36px !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    #table-log-pinjaman_wrapper .dataTables_length select,
    #table-log-pinjaman_wrapper .dt-length select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        padding: 4px 28px 4px 10px !important;
        height: 34px !important;
        font-size: 0.82rem !important;
        background-color: var(--bs-body-bg) !important;
        color: var(--bs-body-color) !important;
    }

    .page-item.active .page-link {
        background-color: var(--ent-indigo) !important;
        border-color: var(--ent-indigo) !important;
        color: #ffffff !important;
        border-radius: 8px;
    }

    .page-link {
        color: var(--bs-body-color);
        border-radius: 8px;
        margin: 0 2px;
        border: 1px solid var(--ent-grid-border);
        font-weight: 600;
        font-size: 0.8rem;
    }

    /* Dropdown & Modal Adaptive */
    .ent-dropdown-menu {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.25) !important;
        background-color: var(--bs-body-bg, #ffffff) !important;
    }

    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg, #ffffff) !important;
        color: var(--bs-body-color);
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<!-- HERO BANNER HEADER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-hand-holding-usd fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-coins me-1"></i> {{ env('APP_LABEL', 'KOPERASI') }} LOAN
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Transaksi Peminjaman Uang</span>
                            </div>
                            <h4 class="mb-0 fw-bold text-white" style="letter-spacing: -0.02em;">Transaksi Peminjaman Uang Anggota</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Kelola akad pengajuan pinjaman, kalkulasi simulasi angsuran, dan pembuatan piutang pinjaman.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FORM INPUT & SIMULASI PINJAMAN -->
<div class="row g-3 mb-3 ent-form">
    <!-- FORM PENGATURAN KONTRAK PINJAMAN -->
    <div class="col-lg-5">
        <div class="ent-card ent-table-surface h-100">
            <div class="card-header py-3 px-4">
                <h6 class="card-title mb-0 fw-bold">
                    <i class="fas fa-file-signature text-primary me-2"></i>Form Pengajuan Pinjaman Uang
                </h6>
            </div>
            <div class="card-body p-4">
                <form id="form-peminjaman-uang">
                    @csrf

                    <!-- Dropdown Anggota / Peserta -->
                    <div class="mb-3">
                        <label class="form-label ent-label">Pilih Anggota <span class="text-danger">*</span></label>
                        <select class="form-select select2-peserta" id="pinjam_anggota_id" name="anggota_id" required>
                            <option value="">Pilih Anggota Koperasi</option>
                            @foreach($peserta as $p)
                            <option value="{{ $p->id_kop_master_peserta }}"
                                data-code="{{ $p->kop_master_peserta_code }}"
                                data-nip="{{ $p->kop_master_peserta_nip }}">
                                [{{ $p->kop_master_peserta_code }}] {{ $p->kop_master_peserta_name }} - NIP: {{ $p->kop_master_peserta_nip ?? '-' }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tujuan & Tanggal -->
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label for="tanggal_pinjaman" class="form-label ent-label">Tgl. Transaksi <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal_pinjaman" name="tanggal_pinjaman" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tujuan_pinjaman" class="form-label ent-label">Tujuan Pinjaman</label>
                            <input type="text" class="form-control" id="tujuan_pinjaman" name="tujuan_pinjaman" placeholder="Misal: Biaya Pendidikan, Renovasi">
                        </div>
                    </div>

                    <hr class="my-3" style="border-color: var(--ent-grid-border);">

                    <!-- Komponen Finansial Pinjaman -->
                    <div class="mb-3">
                        <label for="jumlah_pinjaman" class="form-label ent-label">Jumlah Pinjaman (Pokok) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text fw-bold">Rp</span>
                            <input type="text" class="form-control rupiah-input fw-bold text-primary" id="jumlah_pinjaman" name="jumlah_pinjaman" placeholder="0" style="font-family: 'JetBrains Mono', monospace;" required>
                        </div>
                        <small class="opacity-75" style="font-size: 0.72rem;">Nominal plafon pinjaman yang disetujui.</small>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label for="pinjam_biaya_admin" class="form-label ent-label">Biaya Admin</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control rupiah-input" id="pinjam_biaya_admin" name="pinjam_biaya_admin" value="0" style="font-family: 'JetBrains Mono', monospace;">
                            </div>
                            <small class="opacity-75" style="font-size: 0.68rem;">Dipotong di awal dari pencairan.</small>
                        </div>
                        <div class="col-md-6">
                            <label for="pinjam_bunga_koperasi" class="form-label ent-label">Total Bunga/Margin</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control rupiah-input" id="pinjam_bunga_koperasi" name="pinjam_bunga_koperasi" value="0" style="font-family: 'JetBrains Mono', monospace;">
                            </div>
                            <small class="opacity-75" style="font-size: 0.68rem;">Margin keuntungan dicicil.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="pinjam_tenor_bulan" class="form-label ent-label">Tenor / Jangka Waktu <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-select" id="pinjam_tenor_bulan" name="tenor_bulan" required>
                                <option value="1">1 Bulan</option>
                                <option value="3">3 Bulan</option>
                                <option value="6" selected>6 Bulan</option>
                                <option value="12">12 Bulan</option>
                                <option value="18">18 Bulan</option>
                                <option value="24">24 Bulan</option>
                                <option value="36">36 Bulan</option>
                            </select>
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                    </div>

                    <!-- Pengaturan Akun COA Jurnal -->
                    <div class="rounded-3 p-3 mb-3" style="background: rgba(79, 70, 229, 0.05); border: 1px solid var(--ent-grid-border);">
                        <h6 class="fw-bold mb-2 small"><i class="fas fa-book text-primary me-1"></i> Pemetaan Akun Jurnal (Double Entry)</h6>

                        <!-- COA Piutang -->
                        <div class="mb-2">
                            <label class="form-label ent-label mb-1">COA Piutang (Debet)</label>
                            <select class="form-select select2-coa-pinjam" id="pinjam_coa_piutang" name="coa_piutang">
                                <option value=""></option>
                                @foreach($coaList as $coa)
                                <option value="{{ $coa->coa_code }}" {{ str_contains(strtolower($coa->coa_name), 'piutang') ? 'selected' : '' }}>
                                    {{ $coa->coa_code }} - {{ $coa->coa_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- COA Kas/Bank -->
                        <div class="mb-2">
                            <label class="form-label ent-label mb-1">COA Kas/Bank Pencairan (Kredit Netto)</label>
                            <select class="form-select select2-coa-pinjam" id="pinjam_sumber_dana_coa" name="sumber_dana_coa">
                                <option value=""></option>
                                @foreach($coaList as $coa)
                                <option value="{{ $coa->coa_code }}" {{ (str_contains(strtolower($coa->coa_name), 'kas') || str_contains(strtolower($coa->coa_name), 'bank')) ? 'selected' : '' }}>
                                    {{ $coa->coa_code }} - {{ $coa->coa_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-2">
                            <!-- COA Pendapatan Admin -->
                            <div class="col-md-6">
                                <label class="form-label ent-label mb-1">COA Pend. Admin</label>
                                <select class="form-select select2-coa-pinjam" id="pinjam_coa_pendapatan_admin" name="coa_pendapatan_admin">
                                    <option value=""></option>
                                    @foreach($coaList as $coa)
                                    <option value="{{ $coa->coa_code }}" {{ str_contains(strtolower($coa->coa_name), 'admin') ? 'selected' : '' }}>
                                        {{ $coa->coa_code }} - {{ $coa->coa_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- COA Pendapatan Bunga -->
                            <div class="col-md-6">
                                <label class="form-label ent-label mb-1">COA Pend. Bunga</label>
                                <select class="form-select select2-coa-pinjam" id="pinjam_coa_pendapatan_bunga" name="coa_pendapatan_bunga">
                                    <option value=""></option>
                                    @foreach($coaList as $coa)
                                    <option value="{{ $coa->coa_code }}" {{ (str_contains(strtolower($coa->coa_name), 'bunga') || str_contains(strtolower($coa->coa_name), 'margin')) ? 'selected' : '' }}>
                                        {{ $coa->coa_code }} - {{ $coa->coa_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="btn-kalkulasi-pinjaman" class="btn ent-btn ent-btn-primary w-100 py-2">
                        <i class="fas fa-calculator me-1"></i> Hitung Simulasi &amp; Draf
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- HASIL SIMULASI & PROYEKSI ANGSURAN -->
    <div class="col-lg-7">
        <div class="ent-card ent-table-surface h-100">
            <div class="card-header py-3 px-4">
                <h6 class="card-title mb-0 fw-bold">
                    <i class="fas fa-chart-line text-success me-2"></i>Ringkasan Pencairan &amp; Schedule Angsuran
                </h6>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <!-- Box Indikator Ringkasan Finansial -->
                <div class="row g-2 mb-3">
                    <div class="col-md-3 col-6">
                        <div class="ent-kpi-box">
                            <span class="d-block ent-label mb-1">Pencairan Netto</span>
                            <strong id="lbl-pinjam-pencairan-netto" class="text-success fw-bold" style="font-family: 'JetBrains Mono', monospace; font-size: 0.9rem;">Rp 0</strong>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="ent-kpi-box">
                            <span class="d-block ent-label mb-1">Total Piutang</span>
                            <strong id="lbl-pinjam-total-piutang" class="text-primary fw-bold" style="font-family: 'JetBrains Mono', monospace; font-size: 0.9rem;">Rp 0</strong>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="ent-kpi-box">
                            <span class="d-block ent-label mb-1">Tenor</span>
                            <strong id="lbl-pinjam-tenor" class="fw-bold" style="font-family: 'JetBrains Mono', monospace; font-size: 0.9rem;">0 Bln</strong>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="ent-kpi-box">
                            <span class="d-block ent-label mb-1">Cicilan / Bln</span>
                            <strong id="lbl-pinjam-cicilan-bulanan" class="text-danger fw-bold" style="font-family: 'JetBrains Mono', monospace; font-size: 0.9rem;">Rp 0</strong>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Jurnal Pencairan Awal -->
                <div class="rounded-3 p-3 mb-3" style="border: 1px solid var(--ent-grid-border); background: rgba(79, 70, 229, 0.03);">
                    <h6 class="fw-bold small mb-2"><i class="fas fa-balance-scale text-primary me-1"></i> Draft Jurnal Pencairan Pinjaman (Awal)</h6>
                    <div class="table-responsive">
                        <table class="table table-custom mb-0" style="font-size: 0.78rem;">
                            <thead>
                                <tr>
                                    <th>Akun / Rekening</th>
                                    <th class="text-end">Debet</th>
                                    <th class="text-end">Kredit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>[Debet] Piutang Pinjaman Anggota</td>
                                    <td class="text-end fw-bold text-success" id="j-pinjam-debit-piutang" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                    <td class="text-end opacity-75" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                </tr>
                                <tr>
                                    <td>[Kredit] Kas/Bank Koperasi (Cair Netto)</td>
                                    <td class="text-end opacity-75" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                    <td class="text-end fw-bold text-danger" id="j-pinjam-kredit-kas" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                </tr>
                                <tr>
                                    <td>[Kredit] Pendapatan Biaya Admin</td>
                                    <td class="text-end opacity-75" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                    <td class="text-end fw-bold" id="j-pinjam-kredit-admin" style="font-family: 'JetBrains Mono', monospace;">Rp 0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tabel Jadwal Tenor -->
                <div class="table-responsive rounded-3 mb-3 flex-grow-1" style="border: 1px solid var(--ent-grid-border); max-height: 250px; overflow-y: auto;">
                    <table class="table table-custom align-middle mb-0" style="font-size: 0.8rem;">
                        <thead>
                            <tr>
                                <th>Angsuran</th>
                                <th>Jatuh Tempo</th>
                                <th class="text-end">Pokok</th>
                                <th class="text-end">Bunga</th>
                                <th class="text-end">Total Angsuran</th>
                            </tr>
                        </thead>
                        <tbody id="simulasi-pinjaman-tenor-tbody">
                            <tr>
                                <td colspan="5" class="text-center py-4 opacity-75">
                                    <i class="fas fa-info-circle me-1 text-primary"></i> Klik tombol <strong>Hitung Simulasi</strong> untuk melihat rincian angsuran.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Tombol Terbitkan Kontrak -->
                <button type="button" id="btn-submit-final-pinjaman" class="btn ent-btn ent-btn-success w-100 py-2 d-none">
                    <i class="fas fa-check-circle me-1"></i> Konfirmasi &amp; Terbitkan Akad Pinjaman
                </button>
            </div>
        </div>
    </div>
</div>

<!-- LOG & RIWAYAT TRANSAKSI PEMINJAMAN UANG -->
<div class="ent-card">
    <div class="card-header py-3 px-3 px-md-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-list-ul text-primary"></i>
                <h5 class="card-title mb-0 fw-bold">Log Akad Pinjaman &amp; Status Tenor</h5>
            </div>
            <!-- Filter Status -->
            <div class="d-flex align-items-center gap-2 ent-form">
                <label for="filter-status-pinjaman" class="form-label mb-0 ent-label">Filter Status:</label>
                <select id="filter-status-pinjaman" class="form-select" style="width: 170px; min-height: 36px;">
                    <option value="">Semua Status</option>
                    <option value="DRAFT">DRAFT</option>
                    <option value="BELUM_LUNAS">BELUM LUNAS</option>
                    <option value="LUNAS">LUNAS</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card-body ent-card-body-flush ent-table-surface">
        <div class="table-responsive">
            <table id="table-log-pinjaman" class="table table-custom align-middle mb-0 w-100">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 4%;">#</th>
                        <th>No. Nota / Akad</th>
                        <th>Peserta Koperasi</th>
                        <th>Tujuan</th>
                        <th class="text-end">Plafon Pinjaman</th>
                        <th class="text-end">Biaya Admin</th>
                        <th class="text-end">Pencairan Netto</th>
                        <th class="text-end">Total Piutang</th>
                        <th class="text-center">Tenor</th>
                        <th class="text-end">Cicilan / Bln</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayat as $row)
                    @php
                    $statusUpper = strtoupper(trim($row->status_tagihan));
                    $phone = preg_replace('/[^0-9]/', '', $row->peserta_hp ?? '');
                    if (str_starts_with($phone, '0')) {
                    $phone = '62' . substr($phone, 1);
                    }
                    $pesanWA = "Halo *" . $row->kop_master_peserta_name . "*,\n\n"
                    . "Berikut draf pengajuan peminjaman uang Anda di Koperasi:\n"
                    . "- *No. Akad:* " . $row->nota_nomor . "\n"
                    . "- *Plafon Pinjaman:* Rp " . number_format($row->jumlah_pinjaman, 0, ',', '.') . "\n"
                    . "- *Pencairan Netto:* Rp " . number_format($row->pencairan_netto, 0, ',', '.') . "\n"
                    . "- *Tenor:* " . $row->tenor_bulan . " Bulan\n"
                    . "- *Cicilan/Bln:* Rp " . number_format($row->cicilan_per_bulan, 0, ',', '.') . "\n\n"
                    . "Mohon konfirmasi jika persetujuan akad sudah sesuai. Terima kasih!";
                    @endphp
                    <tr>
                        <td class="action-cell-full text-center align-middle">
                            @if($statusUpper == 'DRAFT')
                            <a href="https://wa.me/{{ $phone }}?text={{ urlencode($pesanWA) }}"
                                target="_blank"
                                class="btn"
                                title="Kirim Notifikasi WA">
                                <i class="fab fa-whatsapp fs-5 text-success"></i>
                            </a>
                            @elseif($statusUpper == 'BELUM_LUNAS')
                            <button type="button"
                                class="btn"
                                id="button-print-pengajuan-peminjaman"
                                data-code="{{ $row->id }}"
                                data-bs-toggle="modal"
                                data-bs-target="#modal-koperasi"
                                title="Cetak Akad Pinjaman">
                                <i class="fas fa-print"></i>
                            </button>
                            @else
                            <div class="dropdown">
                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Aksi">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu ent-dropdown-menu py-2">
                                    <li>
                                        <span class="dropdown-item-text small opacity-75">Akad Lunas</span>
                                    </li>
                                </ul>
                            </div>
                            @endif
                        </td>
                        <td class="fw-bold text-success" style="font-family: 'JetBrains Mono', monospace;">{{ $row->nota_nomor }}</td>
                        <td>
                            <small class="opacity-75 d-block" style="font-family: 'JetBrains Mono', monospace; font-size: 0.7rem;">{{ $row->kop_master_peserta_code }}</small>
                            <strong class="text-uppercase" style="font-size: 0.8rem;">{{ $row->kop_master_peserta_name }}</strong>
                        </td>
                        <td>{{ $row->tujuan_pinjaman ?? '-' }}</td>
                        <td class="text-end fw-semibold" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($row->jumlah_pinjaman, 0, ',', '.') }}</td>
                        <td class="text-end opacity-75" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($row->biaya_admin ?? 0, 0, ',', '.') }}</td>
                        <td class="text-end text-success fw-bold" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($row->pencairan_netto, 0, ',', '.') }}</td>
                        <td class="text-end fw-semibold text-primary" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($row->total_piutang, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: var(--bs-body-color); border: 1px solid var(--ent-grid-border);">{{ $row->tenor_bulan }} Bulan</span>
                        </td>
                        <td class="text-end fw-bold text-danger" style="font-family: 'JetBrains Mono', monospace;">Rp {{ number_format($row->cicilan_per_bulan, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($statusUpper == 'DRAFT')
                            <span class="ent-badge" style="background: rgba(100, 116, 139, 0.16); color: var(--bs-secondary-color, #94a3b8); border: 1px solid rgba(100, 116, 139, 0.35);">DRAFT</span>
                            @elseif($statusUpper == 'LUNAS')
                            <span class="ent-badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.35);">LUNAS</span>
                            @else
                            <span class="ent-badge" style="background: rgba(245, 158, 11, 0.16); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.38);">{{ $row->status_tagihan }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-koperasi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-koperasi"></div>
        </div>
    </div>
</div>

<!-- SweetAlert2, Select2, & DataTables JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // DataTables Init (Kolom Status sekarang di index 10)
        let logPinjamanTable = $('#table-log-pinjaman').DataTable({
            language: {
                search: "Cari Data:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data yang tersedia",
                infoFiltered: "(disaring dari total _MAX_ data)",
                zeroRecords: "Data pinjaman tidak ditemukan",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            },
            pageLength: 10,
            order: [],
            columnDefs: [{
                orderable: false,
                targets: [0, 10]
            }]
        });

        // Filter Status Dropdown
        $('#filter-status-pinjaman').on('change', function() {
            let selectedStatus = $(this).val();
            if (selectedStatus) {
                logPinjamanTable.column(10).search('^' + selectedStatus + '$', true, false).draw();
            } else {
                logPinjamanTable.column(10).search('').draw();
            }
        });

        // Select2 Init
        if ($.isFunction($.fn.select2)) {
            $('.select2-peserta').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Cari NIP, Code, atau Nama Peserta...',
                allowClear: true
            });

            $('.select2-coa-pinjam').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        }

        // Helpers
        function formatRupiah(angka) {
            return 'Rp ' + parseFloat(angka).toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        function formatNumberThousand(value) {
            let numberString = value.replace(/[^,\d]/g, '').toString();
            let split = numberString.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        }

        function cleanNumber(value) {
            if (!value) return 0;
            return parseFloat(value.toString().replace(/\./g, '').replace(',', '.')) || 0;
        }

        // Masking Realtime
        $(document).on('keyup input', '.rupiah-input', function() {
            let formatted = formatNumberThousand($(this).val());
            $(this).val(formatted);
        });

        // Kalkulasi Simulasi
        $('#btn-kalkulasi-pinjaman').on('click', function() {
            let anggota = $('#pinjam_anggota_id').val();
            let tgl = $('#tanggal_pinjaman').val();

            let jumlahPinjaman = cleanNumber($('#jumlah_pinjaman').val());
            let biayaAdmin = cleanNumber($('#pinjam_biaya_admin').val());
            let bungaKoperasi = cleanNumber($('#pinjam_bunga_koperasi').val());
            let tenor = parseInt($('#pinjam_tenor_bulan').val()) || 1;

            let coaPiutang = $('#pinjam_coa_piutang').val();
            let bankCoa = $('#pinjam_sumber_dana_coa').val();
            let coaAdmin = $('#pinjam_coa_pendapatan_admin').val();
            let coaBunga = $('#pinjam_coa_pendapatan_bunga').val();

            if (!anggota || jumlahPinjaman <= 0) {
                Swal.fire({
                    title: 'Form Belum Lengkap',
                    text: 'Pastikan Anda telah memilih peserta dan menginput nominal pengajuan pinjaman.',
                    icon: 'warning'
                });
                return;
            }

            if (!coaPiutang || !bankCoa || !coaAdmin || !coaBunga) {
                Swal.fire({
                    title: 'COA Jurnal Belum Dipilih',
                    text: 'Silahkan tentukan Akun Piutang Pinjaman, Kas/Bank, Admin, dan Bunga pada tabel Draft Jurnal.',
                    icon: 'warning'
                });
                return;
            }

            let pencairanNetto = jumlahPinjaman - biayaAdmin;
            let totalPiutangPengembalian = jumlahPinjaman + bungaKoperasi;
            let cicilanPerBulan = Math.round(totalPiutangPengembalian / tenor);
            let pokokPerBulan = Math.floor(jumlahPinjaman / tenor);
            let sisaPokokAkhir = jumlahPinjaman - (pokokPerBulan * tenor);

            let bungaPerBulan = Math.floor(bungaKoperasi / tenor);
            let sisaBungaAkhir = bungaKoperasi - (bungaPerBulan * tenor);

            $('#lbl-pinjam-pencairan-netto').text(formatRupiah(pencairanNetto));
            $('#lbl-pinjam-total-piutang').text(formatRupiah(totalPiutangPengembalian));
            $('#lbl-pinjam-tenor').text(tenor + ' Bln');
            $('#lbl-pinjam-cicilan-bulanan').text(formatRupiah(cicilanPerBulan));

            $('#j-pinjam-debit-piutang').text(formatRupiah(jumlahPinjaman));
            $('#j-pinjam-kredit-kas').text(formatRupiah(pencairanNetto));
            $('#j-pinjam-kredit-admin').text(formatRupiah(biayaAdmin));

            let htmlTimeline = '';
            let startDate = new Date(tgl);
            let startDay = startDate.getDate();

            let baseDate = new Date(startDate.getFullYear(), startDate.getMonth(), 26);
            if (startDay > 15) {
                baseDate.setMonth(baseDate.getMonth() + 1);
            }

            for (let i = 1; i <= tenor; i++) {
                let dueDate = new Date(baseDate.getFullYear(), baseDate.getMonth() + (i - 1), 26);

                let day = dueDate.getDate().toString().padStart(2, '0');
                let month = (dueDate.getMonth() + 1).toString().padStart(2, '0');
                let year = dueDate.getFullYear();
                let formattedDate = `${day}-${month}-${year}`;

                let currentPokok = (i === tenor) ? (pokokPerBulan + sisaPokokAkhir) : pokokPerBulan;
                let currentBunga = (i === tenor) ? (bungaPerBulan + sisaBungaAkhir) : bungaPerBulan;
                let currentTotal = currentPokok + currentBunga;

                htmlTimeline += `
                    <tr>
                        <td class="fw-semibold opacity-75">Angsuran Ke-${i}</td>
                        <td><i class="far fa-calendar-check me-2 text-primary"></i> ${formattedDate}</td>
                        <td class="text-end opacity-75" style="font-family: 'JetBrains Mono', monospace;">${formatRupiah(currentPokok)}</td>
                        <td class="text-end opacity-75" style="font-family: 'JetBrains Mono', monospace;">${formatRupiah(currentBunga)}</td>
                        <td class="text-end fw-bold" style="font-family: 'JetBrains Mono', monospace;">${formatRupiah(currentTotal)}</td>
                    </tr>
                `;
            }

            $('#simulasi-pinjaman-tenor-tbody').html(htmlTimeline);
            $('#btn-submit-final-pinjaman').removeClass('d-none');
        });

        // Submit Form via AJAX
        $('#btn-submit-final-pinjaman').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Pinjaman',
                text: "Kontrak peminjaman uang ini akan diterbitkan. Jadwal tagihan angsuran bulanan peserta akan langsung diaktifkan.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Terbitkan Kontrak'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses Kontrak Pinjaman',
                        text: 'Silahkan tunggu, sistem sedang memproses akad & pencairan...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    let payloadData = {};
                    let rawArray = $('#form-peminjaman-uang').serializeArray();

                    $.each(rawArray, function(_, field) {
                        if (['jumlah_pinjaman', 'pinjam_biaya_admin', 'pinjam_bunga_koperasi'].includes(field.name)) {
                            payloadData[field.name] = cleanNumber(field.value);
                        } else {
                            payloadData[field.name] = field.value;
                        }
                    });

                    $.ajax({
                        url: `{{ route('menu_koperasi_peminjaman_uang_anggota_save') }}`,
                        type: "POST",
                        data: payloadData,
                        success: function(response) {
                            Swal.close();
                            if (response.status === 'success') {
                                if (response.wa_url) {
                                    Swal.fire({
                                        title: 'Berhasil Disimpan!',
                                        text: response.message,
                                        icon: 'success',
                                        showCancelButton: true,
                                        confirmButtonColor: '#25D366',
                                        cancelButtonColor: '#6c757d',
                                        confirmButtonText: '<i class="fab fa-whatsapp me-1"></i> Kirim Notifikasi WA',
                                        cancelButtonText: 'Tutup'
                                    }).then((waResult) => {
                                        if (waResult.isConfirmed) {
                                            window.open(response.wa_url, '_blank');
                                        }
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: response.message,
                                        icon: 'success'
                                    }).then(() => {
                                        location.reload();
                                    });
                                }
                            } else {
                                Swal.fire('Gagal Menyimpan', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            let errorMsg = 'Terjadi masalah koneksi ke server.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            Swal.fire('Error Transaksi', errorMsg, 'error');
                        }
                    });
                }
            });
        });
    });
</script>

<script>
    $(document).on("click", "#button-print-pengajuan-peminjaman", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_koperasi_peminjaman_uang_anggota_print') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-koperasi').html(
                '<iframe src="data:application/pdf;base64, ' +
                data +
                '" style="width:100%; height:533px;" frameborder="0"></iframe>');
        }).fail(function() {
            $('#menu-koperasi').html('eror');
        });
    });
</script>
@endsection
