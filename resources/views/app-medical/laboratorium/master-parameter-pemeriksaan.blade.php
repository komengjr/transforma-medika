@extends('layouts.layouts')

@section('base.css')
<!-- Select2 CSS & Theme Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-indigo-soft: rgba(79, 70, 229, 0.12);
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-emerald: #059669;
        --ent-sky: #0284c7;
        --ent-amber: #d97706;
        --ent-rose: #e11d48;
        --ent-solid-bg: #ffffff;
        --ent-solid-text: #0f172a;
        --ent-subtle-surface: #f8fafc;
        --ent-action-bg: #eef2ff;
        --ent-action-color: #3730a3;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
        --ent-subtle-surface: #1e293b;
        --ent-action-bg: #1e293b;
        --ent-action-color: #a5b4fc;
        --ent-action-hover-bg: #4f46e5;
        --ent-action-hover-color: #ffffff;
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
        width: 340px;
        height: 340px;
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
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.07) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 14px 20px;
    }

    .ent-filter-surface {
        background-color: var(--ent-subtle-surface);
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        box-shadow: 0 4px 16px -4px rgba(15, 23, 42, 0.06);
    }

    .ent-table-surface {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    .code-chip {
        font-family: 'JetBrains Mono', monospace;
        background-color: rgba(79, 70, 229, 0.1);
        color: #4338ca;
        border: 1px solid rgba(79, 70, 229, 0.25);
        padding: 2px 8px;
        border-radius: 7px;
        font-weight: 700;
        font-size: 0.72rem;
        display: inline-block;
    }

    [data-bs-theme="dark"] .code-chip,
    .dark .code-chip {
        background-color: rgba(129, 140, 248, 0.16);
        color: #a5b4fc;
        border-color: rgba(129, 140, 248, 0.32);
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        cursor: pointer;
        font-size: 0.8rem;
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

    .ent-btn-soft-primary {
        background-color: rgba(79, 70, 229, 0.12);
        border: 1px solid rgba(79, 70, 229, 0.3);
        color: var(--ent-indigo);
    }

    .ent-btn-soft-primary:hover {
        background-color: var(--ent-indigo);
        border-color: var(--ent-indigo);
        color: #ffffff;
    }

    .ent-btn-soft-danger {
        background-color: rgba(225, 29, 72, 0.12);
        border: 1px solid rgba(225, 29, 72, 0.3);
        color: var(--ent-rose);
    }

    .ent-btn-soft-danger:hover {
        background-color: var(--ent-rose);
        border-color: var(--ent-rose);
        color: #ffffff;
    }

    .ent-btn-light {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        border: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color, var(--ent-solid-text));
    }

    .ent-btn-light:hover {
        background-color: rgba(79, 70, 229, 0.08);
        border-color: var(--ent-indigo);
        color: var(--ent-indigo);
    }

    .ent-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 6px;
    }

    .ent-input,
    .form-control,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        font-size: 0.82rem !important;
        min-height: 40px;
        transition: all 0.2s ease;
    }

    .ent-input:focus,
    .form-control:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        font-size: 0.82rem !important;
        min-height: 42px !important;
        display: flex !important;
        align-items: center !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
        transition: all 0.2s ease;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
        padding-left: 4px;
    }

    .select2-container--bootstrap-5 .select2-dropdown {
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.22) !important;
        overflow: hidden;
    }

    .select2-container--bootstrap-5 .select2-search__field {
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        font-size: 0.8rem !important;
    }

    .select2-container--bootstrap-5 .select2-results__option {
        font-size: 0.82rem !important;
        font-weight: 500;
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
        padding: 8px 12px;
    }

    .select2-container--bootstrap-5 .select2-results__option--highlighted {
        background-color: var(--ent-indigo) !important;
        color: #ffffff !important;
    }

    .ent-switch-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 10px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        padding: 8px 12px;
        min-height: 40px;
        display: flex;
        align-items: center;
    }

    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
        font-size: 0.82rem;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: var(--bs-body-color) !important;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        padding: 13px 14px;
        letter-spacing: 0.04em;
    }

    .table-custom thead th:first-child {
        border-left: none !important;
    }

    .table-custom thead th:last-child {
        border-right: none !important;
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-custom tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.06) !important;
    }

    .table-custom tbody tr.row-group-header {
        background-color: rgba(79, 70, 229, 0.07) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color) !important;
        padding: 11px 14px;
        vertical-align: middle;
        font-size: 0.83rem;
    }

    .table-custom tbody td:first-child {
        border-left: none !important;
    }

    .table-custom tbody td:last-child {
        border-right: none !important;
    }

    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color);
        overflow: hidden;
    }

    .ent-modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-modal-header::before {
        content: '';
        position: absolute;
        top: -60%;
        right: -5%;
        width: 260px;
        height: 260px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-modal-header>* {
        position: relative;
        z-index: 2;
    }

    .ent-modal-footer {
        background-color: var(--ent-subtle-surface);
        border-top: 1px solid var(--ent-grid-border);
    }
</style>
@endsection

@section('content')
<!-- HEADER HERO BANNER ENTERPRISE -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 58px; height: 58px;">
                            <i class="fas fa-vials fs-4" style="color: #38bdf8;"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-flask"></i> {{ env('APP_LABEL', 'HIS') }} SYSTEM
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Laboratorium Management</span>
                            </div>
                            <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em;color: white;">
                                Parameter Pemeriksaan Lab
                            </h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Kelola struktur parameter, label tampilan, grup pemeriksaan, nilai rujukan, satuan, dan metode uji laboratorium.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 text-lg-end">
                        <div class="ent-glass-pill d-inline-flex align-items-center gap-2 px-3 py-2">
                            <i class="fas fa-layer-group" style="color: #38bdf8;"></i>
                            <div class="text-start">
                                <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.6rem; line-height: 1.1;">Total Parameter</span>
                                <span class="fw-bold text-white" id="badgeTotalParameter" style="font-size: 0.85rem; font-family: 'JetBrains Mono', monospace;">0 Parameter</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- PILIH MASTER PEMERIKSAAN -->
    <div class="col-12">
        <div class="ent-filter-surface p-3 p-md-4">
            <div class="row align-items-center g-2">
                <div class="col-md-4 col-lg-3">
                    <label for="select_master_pemeriksaan" class="ent-label mb-0 d-flex align-items-center gap-2">
                        <i class="fas fa-microscope text-primary"></i>
                        <span>Pilih Master Pemeriksaan <span class="text-danger">*</span></span>
                    </label>
                    <small class="opacity-75 d-block" style="font-size: 0.72rem;">Pilih layanan lab untuk memuat parameter.</small>
                </div>
                <div class="col-md-8 col-lg-9">
                    <select class="form-select select2-search" id="select_master_pemeriksaan">
                        <option value="">-- Pilih Pemeriksaan Lab --</option>
                        @foreach($pemeriksaanList as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_layanan }} ({{ $item->kode_layanan }}) - {{ $item->nama_tipe }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL PARAMETER -->
    <div class="col-12">
        <div class="ent-card mb-4">
            <div class="ent-card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-3"
                        style="width: 32px; height: 32px; background: rgba(79, 70, 229, 0.14); color: var(--ent-indigo);">
                        <i class="fas fa-list-check"></i>
                    </span>
                    <div>
                        <h6 class="mb-0 fw-bold" style="font-size: 0.9rem;">Daftar Parameter Pemeriksaan</h6>
                        <small class="opacity-75" style="font-size: 0.72rem;">Urutan dan hierarki parameter sesuai tampilan hasil pemeriksaan.</small>
                    </div>
                </div>

                <button class="btn ent-btn ent-btn-primary px-3 py-2 d-none" id="btnAddParameter" data-bs-toggle="modal" data-bs-target="#modalParameter">
                    <i class="fas fa-plus me-1"></i> Tambah Parameter
                </button>
            </div>

            <div class="card-body p-0 ent-table-surface">
                <div class="table-responsive">
                    <table class="table table-custom align-middle mb-0" id="tableParameter">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 80px;">Urutan</th>
                                <th>Parameter / Label</th>
                                <th style="width: 170px;">Tipe / Kategori</th>
                                <th>Nilai Normal</th>
                                <th style="width: 120px;">Satuan</th>
                                <th>Metode</th>
                                <th class="text-center" style="width: 115px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="parameterTableBody">
                            <tr>
                                <td colspan="7" class="text-center py-5 opacity-75">
                                    <i class="fas fa-info-circle fs-4 text-primary d-block mb-2"></i>
                                    <span class="fw-semibold">Silakan pilih Master Pemeriksaan di atas terlebih dahulu.</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FORM TAMBAH / EDIT PARAMETER -->
<div class="modal fade" id="modalParameter" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-ent-content">
            <div class="modal-header ent-modal-header py-3 px-4 border-0">
                <div class="d-flex align-items-center gap-2">
                    <span class="ent-glass-pill d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fas fa-sliders-h" style="color: #38bdf8;"></i>
                    </span>
                    <div>
                        <h5 class="modal-title fw-bold mb-0 text-white" id="modalTitle" style="font-size: 1rem;">
                            Tambah Parameter Pemeriksaan
                        </h5>
                        <small style="color: #cbd5e1; font-size: 0.72rem;">Lengkapi detail parameter dan label tampilan pemeriksaan laboratorium.</small>
                    </div>
                </div>
                <button type="button" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center"
                    data-bs-dismiss="modal" aria-label="Close"
                    style="width: 32px; height: 32px; background: rgba(255,255,255,0.12); color: #ffffff; border: 1px solid rgba(255,255,255,0.2);">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="formParameter">
                @csrf
                <input type="hidden" id="parameter_id" name="parameter_id">
                <input type="hidden" id="modal_master_pemeriksaan_id" name="master_pemeriksaan_id">

                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nama_parameter" class="ent-label">Kode / Nama Parameter <span class="text-danger">*</span></label>
                            <input type="text" class="form-control ent-input" id="nama_parameter" name="nama_parameter" placeholder="Contoh: EO%, HGB, Hitung Jenis" required>
                        </div>
                        <div class="col-md-6">
                            <label for="label" class="ent-label">Label Tampilan (Hasil &amp; QC)</label>
                            <input type="text" class="form-control ent-input" id="label" name="label" placeholder="Contoh: Eosinofil, Hemoglobin">
                            <small class="opacity-75 d-block mt-1" style="font-size: 0.7rem;">Jika dikosongkan, otomatis mengikuti Nama Parameter.</small>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="ent-label">Indikator Kelompok (Group)</label>
                            <div class="ent-switch-box">
                                <div class="form-check form-switch mb-0 d-flex align-items-center gap-2">
                                    <input class="form-check-input m-0" type="checkbox" id="is_group" name="is_group" value="1" style="width: 38px; height: 20px; cursor: pointer;">
                                    <label class="form-check-label fw-semibold mb-0" for="is_group" style="font-size: 0.8rem; cursor: pointer;">
                                        Jadikan Judul Kelompok (Header)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="parent_id" class="ent-label">Parameter Induk (Parent Group)</label>
                            <select class="form-select ent-input" id="parent_id" name="parent_id">
                                <option value="">-- Tanpa Induk (Root) --</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="nilai_normal" class="ent-label">Nilai Normal</label>
                            <input type="text" class="form-control ent-input" id="nilai_normal" name="nilai_normal" placeholder="Contoh: 13.0 - 17.0">
                        </div>
                        <div class="col-md-6">
                            <label for="satuan" class="ent-label">Satuan</label>
                            <input type="text" class="form-control ent-input" id="satuan" name="satuan" placeholder="Contoh: %, g/dL, /uL">
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="metode" class="ent-label">Metode Pemeriksaan</label>
                            <input type="text" class="form-control ent-input" id="metode" name="metode" placeholder="Contoh: Flow Cytometry / Impedance">
                        </div>
                        <div class="col-md-4">
                            <label for="urutan" class="ent-label">Urutan</label>
                            <input type="number" class="form-control ent-input" id="urutan" name="urutan" value="0">
                        </div>
                    </div>
                </div>

                <div class="modal-footer ent-modal-footer px-4 py-3">
                    <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-primary px-4 py-2" id="btnSaveParameter">
                        <i class="fas fa-save me-1"></i> Simpan Parameter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('.select2-search').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });

        const selectMasterPemeriksaan = $('#select_master_pemeriksaan');
        const parameterTableBody = $('#parameterTableBody');
        const btnAddParameter = $('#btnAddParameter');
        const badgeTotalParameter = $('#badgeTotalParameter');
        const modalParameter = new bootstrap.Modal(document.getElementById('modalParameter'));
        const formParameter = $('#formParameter');
        let currentParametersList = [];

        function escapeHtml(text) {
            if (!text) return '';
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        selectMasterPemeriksaan.on('change', function() {
            const masterId = $(this).val();
            if (!masterId) {
                btnAddParameter.addClass('d-none');
                badgeTotalParameter.text('0 Parameter');
                parameterTableBody.html(`
                    <tr>
                        <td colspan="7" class="text-center py-5 opacity-75">
                            <i class="fas fa-info-circle fs-4 text-primary d-block mb-2"></i>
                            <span class="fw-semibold">Silakan pilih Master Pemeriksaan di atas terlebih dahulu.</span>
                        </td>
                    </tr>`);
                return;
            }

            btnAddParameter.removeClass('d-none');
            $('#modal_master_pemeriksaan_id').val(masterId);
            loadParameters(masterId);
        });

        function loadParameters(masterId) {
            parameterTableBody.html(`
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                        <span class="fw-semibold opacity-75">Memuat data parameter...</span>
                    </td>
                </tr>`);

            $.ajax({
                url: "{{ route('lab.get_parameters') }}",
                type: "GET",
                data: {
                    master_pemeriksaan_id: masterId
                },
                success: function(res) {
                    currentParametersList = res.parameters || [];
                    badgeTotalParameter.text(`${currentParametersList.length} Parameter`);
                    parameterTableBody.empty();

                    let parentSelect = $('#parent_id');
                    parentSelect.html('<option value="">-- Tanpa Induk (Root) --</option>');
                    (res.groupParameters || []).forEach(grp => {
                        const grpTitle = grp.label && grp.label !== grp.nama_parameter
                            ? `${grp.nama_parameter} (${grp.label})`
                            : grp.nama_parameter;
                        parentSelect.append(`<option value="${grp.id}">${escapeHtml(grpTitle)}</option>`);
                    });

                    if (currentParametersList.length === 0) {
                        parameterTableBody.html(`
                            <tr>
                                <td colspan="7" class="text-center py-5 opacity-75">
                                    <i class="fas fa-folder-open fs-4 text-primary d-block mb-2"></i>
                                    <span class="fw-semibold">Belum ada parameter untuk pemeriksaan ini. Klik <strong>"Tambah Parameter"</strong> untuk membuat baru.</span>
                                </td>
                            </tr>`);
                        return;
                    }

                    currentParametersList.forEach((param) => {
                        let isGroup = param.is_group == 1;
                        let isGroupBadge = isGroup ?
                            '<span class="ent-badge" style="background: rgba(245, 158, 11, 0.14); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.35);"><i class="fas fa-folder"></i> Group Header</span>' :
                            '<span class="ent-badge" style="background: rgba(2, 132, 199, 0.14); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.35);"><i class="fas fa-sliders-h"></i> Parameter Input</span>';

                        let paddingStyle = param.parent_id ? 'padding-left: 34px;' : '';
                        let namePrefix = param.parent_id ?
                            '<i class="fas fa-level-up-alt fa-rotate-90 me-2 text-primary opacity-75"></i>' :
                            (isGroup ? '<i class="fas fa-layer-group me-2 text-warning"></i>' : '');

                        const displayLabel = param.label ? escapeHtml(param.label) : escapeHtml(param.nama_parameter);
                        const showCodeChip = !isGroup && param.label && param.label !== param.nama_parameter;
                        const labelSubHtml = showCodeChip
                            ? `<div class="mt-1"><span class="code-chip">${escapeHtml(param.nama_parameter)}</span></div>`
                            : '';

                        let tr = `
                            <tr class="${isGroup ? 'row-group-header fw-bold' : ''}">
                                <td class="text-center">
                                    <span class="code-chip">${param.urutan}</span>
                                </td>
                                <td style="${paddingStyle}">
                                    <span class="${isGroup ? 'fw-bold text-uppercase' : 'fw-bold'}">${namePrefix}${displayLabel}</span>
                                    ${labelSubHtml}
                                </td>
                                <td>${isGroupBadge}</td>
                                <td class="fw-semibold" style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">${escapeHtml(param.nilai_normal) || '-'}</td>
                                <td class="fw-semibold">${escapeHtml(param.satuan) || '-'}</td>
                                <td>${escapeHtml(param.metode) || '-'}</td>
                                <td class="text-center">
                                    <div class="d-inline-flex align-items-center gap-1">
                                        <button type="button" class="btn btn-sm ent-btn ent-btn-soft-primary px-2 py-1 btn-edit-param" data-id="${param.id}" title="Edit Parameter">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm ent-btn ent-btn-soft-danger px-2 py-1 btn-delete-param" data-id="${param.id}" title="Hapus Parameter">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>`;
                        parameterTableBody.append(tr);
                    });
                },
                error: function() {
                    badgeTotalParameter.text('0 Parameter');
                    parameterTableBody.html(`
                        <tr>
                            <td colspan="7" class="text-center py-4 text-danger fw-semibold">
                                <i class="fas fa-exclamation-triangle me-1"></i> Gagal memuat data parameter.
                            </td>
                        </tr>`);
                }
            });
        }

        $('#btnAddParameter').on('click', function() {
            formParameter[0].reset();
            $('#parameter_id').val('');
            $('#label').val('');
            $('#modalTitle').text('Tambah Parameter Pemeriksaan');
        });

        formParameter.on('submit', function(e) {
            e.preventDefault();
            let btn = $('#btnSaveParameter');
            let originalText = btn.html();
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

            $.ajax({
                url: "{{ route('lab.save_parameter') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    btn.prop('disabled', false).html(originalText);
                    modalParameter.hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message,
                        confirmButtonColor: '#059669',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    loadParameters(selectMasterPemeriksaan.val());
                },
                error: function() {
                    btn.prop('disabled', false).html(originalText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan pada server.',
                        confirmButtonColor: '#e11d48'
                    });
                }
            });
        });

        $(document).on('click', '.btn-edit-param', function() {
            let id = $(this).data('id');
            let param = currentParametersList.find(p => p.id == id);

            if (param) {
                $('#parameter_id').val(param.id);
                $('#nama_parameter').val(param.nama_parameter);
                $('#label').val(param.label || '');
                $('#is_group').prop('checked', param.is_group == 1);
                $('#parent_id').val(param.parent_id);
                $('#nilai_normal').val(param.nilai_normal);
                $('#satuan').val(param.satuan);
                $('#metode').val(param.metode);
                $('#urutan').val(param.urutan);

                $('#modalTitle').text('Edit Parameter Pemeriksaan');
                modalParameter.show();
            }
        });

        $(document).on('click', '.btn-delete-param', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Hapus Parameter?',
                text: "Data parameter yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('lab.delete_parameter') }}",
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: res.message,
                                confirmButtonColor: '#059669',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            loadParameters(selectMasterPemeriksaan.val());
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal menghapus parameter.',
                                confirmButtonColor: '#e11d48'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
