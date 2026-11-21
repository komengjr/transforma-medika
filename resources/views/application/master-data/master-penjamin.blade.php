@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-indigo-soft: #eef2ff;
        --ent-emerald: #059669;
        --ent-emerald-soft: #d1fae5;
        --ent-sky: #0284c7;
        --ent-amber: #d97706;
        --ent-slate-900: #0f172a;
        --ent-slate-700: #334155;
        --ent-slate-500: #64748b;
        --ent-border: #e2e8f0;
        --ent-bg: #f8fafc;
    }

    .ent-font-display {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    /* Modern Hero Header */
    .ent-hero-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-radius: 16px;
        border: 1px solid rgba(99, 102, 241, 0.25);
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.2);
        position: relative;
        overflow: hidden;
    }

    .ent-hero-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.28) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-icon-glass {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Modern Cards */
    .ent-card {
        border: 1px solid var(--ent-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
        /* background-color: #ffffff; */
        overflow: hidden;
    }

    .ent-card-header {
        /* background: #f8fafc; */
        border-bottom: 1px solid var(--ent-border);
        padding: 0.9rem 1.25rem;
    }

    /* Buttons */
    .btn-ent-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        color: #ffffff !important;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        transition: all 0.2s ease;
    }

    .btn-ent-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
    }

    .btn-ent-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff !important;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
        transition: all 0.2s ease;
    }

    .btn-ent-success:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
    }

    .btn-ent-success:disabled {
        opacity: 0.55;
        box-shadow: none;
    }

    .btn-ent-soft-warning {
        background-color: #fef3c7;
        color: #b45309 !important;
        border: 1px solid #fde68a;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.15s ease;
    }

    .btn-ent-soft-warning:hover {
        background-color: #f59e0b;
        color: #ffffff !important;
    }

    .btn-ent-soft-primary {
        background-color: #e0e7ff;
        color: #4338ca !important;
        border: 1px solid #c7d2fe;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.15s ease;
    }

    .btn-ent-soft-primary:hover {
        background-color: #4f46e5;
        color: #ffffff !important;
    }

    .btn-ent-soft-info {
        background-color: #e0f2fe;
        color: #0369a1 !important;
        border: 1px solid #bae6fd;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.15s ease;
    }

    .btn-ent-soft-info:hover {
        background-color: #0284c7;
        color: #ffffff !important;
    }

    /* Form Controls */
    .ent-input,
    .form-control,
    .form-select {
        border: 1px solid #cbd5e1 !important;
        border-radius: 10px !important;
        font-size: 0.85rem;
        color: var(--ent-slate-900);
        background-color: #ffffff;
        transition: all 0.2s ease;
    }

    .ent-input:focus,
    .form-control:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.12) !important;
        outline: none;
    }

    /* Penjamin Utama List Items */
    .list-group-item-penjamin {
        border: 1px solid var(--ent-border) !important;
        margin-bottom: 8px;
        border-radius: 12px !important;
        cursor: pointer;
        transition: all 0.18s ease;
        background-color: #ffffff;
        color: var(--ent-slate-700);
    }

    .list-group-item-penjamin:hover {
        background-color: #f8fafc;
        border-color: #c7d2fe !important;
        transform: translateX(2px);
    }

    .list-group-item-penjamin.active {
        background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%) !important;
        color: var(--ent-indigo-dark) !important;
        border: 1.5px solid var(--ent-indigo) !important;
        box-shadow: 0 4px 12px -2px rgba(79, 70, 229, 0.15);
    }

    .list-group-item-penjamin.active .folder-icon-box {
        background-color: var(--ent-indigo) !important;
        color: #ffffff !important;
    }

    .folder-icon-box {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        background-color: #f1f5f9;
        color: var(--ent-indigo);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.18s ease;
    }

    /* Modern DataTable */
    .table-custom {
        font-size: 0.82rem;
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }

    .table-custom thead th {
        background-color: #f1f5f9 !important;
        color: var(--ent-slate-700) !important;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border-top: 1px solid var(--ent-border) !important;
        border-bottom: 1.5px solid #cbd5e1 !important;
        border-left: none !important;
        border-right: none !important;
        padding: 11px 12px;
    }

    .table-custom tbody td {
        border-bottom: 1px solid #f1f5f9 !important;
        border-left: none !important;
        border-right: none !important;
        color: var(--ent-slate-700);
        padding: 11px 12px;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover td {
        background-color: #f8fafc;
    }

    /* Soft Badges */
    .ent-badge {
        border-radius: 6px;
        padding: 4px 9px;
        font-weight: 600;
        font-size: 0.7rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge-soft-success {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .badge-soft-danger {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .badge-soft-warning {
        background-color: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .badge-soft-info {
        background-color: #e0f2fe;
        color: #075985;
        border: 1px solid #bae6fd;
    }

    .badge-soft-indigo {
        background-color: #e0e7ff;
        color: #3730a3;
        border: 1px solid #c7d2fe;
    }

    /* Modal Styling */
    .ent-modal-content {
        border: 1px solid var(--ent-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25) !important;
        overflow: hidden;
    }

    .ent-modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        color: #ffffff;
        padding: 1rem 1.35rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .ent-section-title {
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--ent-indigo);
        border-bottom: 1px solid var(--ent-border);
        padding-bottom: 0.45rem;
        margin-bottom: 0.25rem;
    }
</style>
@endsection

@section('content')
<!-- HERO HEADER BANNER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="ent-hero-card p-3 p-md-4">
            <div class="row align-items-center justify-content-between gy-3 position-relative" style="z-index: 2;">
                <div class="col-lg-8 d-flex align-items-center gap-3">
                    <div class="ent-icon-glass flex-shrink-0">
                        <i class="fas fa-handshake text-info fs-3"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge rounded-pill" style="background: rgba(99, 102, 241, 0.3); border: 1px solid rgba(165, 180, 252, 0.4); color: #e0e7ff; font-size: 0.68rem; letter-spacing: 0.04em;">
                                <i class="fas fa-database me-1"></i> MASTER DATA KEUANGAN & KLAIM
                            </span>
                        </div>
                        <h3 class="ent-font-display fw-bold mb-0 text-white" style="font-size: 1.35rem;">
                            Manajemen <span style="color: #38bdf8;">Penjamin & Sub Penjamin</span>
                        </h3>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">
                            Kelola kategori penjamin utama, rekanan perusahaan/asuransi, aturan tanggungan biaya, dan tarif khusus layanan.
                        </p>
                    </div>
                </div>
                <div class="col-lg-auto">
                    <div class="px-3 py-2 rounded-3 d-flex align-items-center gap-2" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15);">
                        <i class="fas fa-building text-success"></i>
                        <div>
                            <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.62rem;">Penjamin Utama</span>
                            <span class="ent-font-display fw-bold text-white fs--1">{{ count($penjaminUtama) }} Kategori</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN LAYOUT -->
<div class="row g-3">
    <!-- KOLOM KIRI: PENJAMIN UTAMA -->
    <div class="col-lg-4">
        <div class="ent-card h-100">
            <div class="ent-card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span class="rounded-2 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background: var(--ent-indigo-soft); color: var(--ent-indigo);">
                        <i class="fas fa-building fs--1"></i>
                    </span>
                    <h6 class="ent-font-display mb-0 text-dark fw-bold">Penjamin Utama</h6>
                </div>
                <button class="btn btn-sm btn-ent-success px-2 py-1 fs--1" data-bs-toggle="modal" data-bs-target="#modal-tambah-penjamin">
                    <i class="fas fa-plus me-1"></i> Tambah
                </button>
            </div>
            <div class="card-body p-3 bg-white">
                <div class="mb-3">
                    <div class="position-relative">
                        <i class="fas fa-search text-muted position-absolute top-50 start-0 translate-middle-y ms-3 fs--1"></i>
                        <input type="text" id="search-penjamin-utama" class="form-control ent-input form-control-sm ps-5" placeholder="Cari penjamin utama...">
                    </div>
                </div>

                <div class="list-group" id="list-penjamin-utama" style="max-height: 460px; overflow-y: auto;">
                    @forelse ($penjaminUtama as $utama)
                    <div class="list-group-item list-group-item-penjamin p-2 px-3 d-flex justify-content-between align-items-center @if($loop->first) active @endif"
                        data-id="{{ $utama->id }}"
                        data-nama="{{ $utama->nama_penjamin }}">
                        <div class="d-flex align-items-center gap-2 flex-grow-1 text-truncate pe-2 item-click-target">
                            <div class="folder-icon-box">
                                <i class="fas fa-folder-open fs--1"></i>
                            </div>
                            <div class="text-truncate">
                                <div class="nama-penjamin-text ent-font-display fw-bold fs--1 text-truncate">{{ $utama->nama_penjamin }}</div>
                                <span class="badge rounded-pill bg-light text-secondary border mt-0.5" style="font-size: 0.62rem;">
                                    {{ $utama->jenis_kategori ?? 'Umum / Lainnya' }}
                                </span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-1.5 flex-shrink-0">
                            <button type="button" class="btn btn-sm btn-ent-soft-warning px-2 py-1 btn-edit-utama"
                                data-id="{{ $utama->id }}"
                                data-nama="{{ $utama->nama_penjamin }}"
                                data-kategori="{{ $utama->jenis_kategori }}"
                                title="Edit Penjamin Utama" style="font-size: 0.68rem;">
                                <i class="fas fa-edit"></i>
                            </button>
                            <i class="fas fa-chevron-right fs--2 text-muted ms-1"></i>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted fs--1">
                        <i class="fas fa-folder-open d-block fs-2 mb-2 opacity-50"></i>
                        Belum ada penjamin utama.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: TABEL SUB PENJAMIN -->
    <div class="col-lg-8">
        <div class="ent-card h-100">
            <div class="ent-card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="rounded-2 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background: #e0f2fe; color: #0284c7;">
                        <i class="fas fa-list-alt fs--1"></i>
                    </span>
                    <h6 class="ent-font-display mb-0 text-dark fw-bold">
                        Sub Penjamin: <span id="selected-penjamin-title" class="text-primary">Pilih Penjamin</span>
                    </h6>
                </div>
                <button class="btn btn-sm btn-ent-success px-3 py-1.5 fs--1" data-bs-toggle="modal" data-bs-target="#modal-tambah-sub-penjamin" id="btn-tambah-sub-trigger" disabled>
                    <i class="fas fa-plus-circle me-1"></i> Tambah Sub Penjamin
                </button>
            </div>
            <div class="card-body p-3 bg-white">
                <div class="table-responsive">
                    <table id="table-sub-penjamin" class="table table-custom align-middle w-100 mb-0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 40px;">No</th>
                                <th>Nama Perusahaan / Asuransi</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Metode Bayar</th>
                                <th>Kontak PIC</th>
                                <th class="text-center">Agreement / Ref</th>
                                <th class="text-center" style="width: 110px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="sub-penjamin-tbody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH PENJAMIN UTAMA -->
<div class="modal fade" id="modal-tambah-penjamin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ent-modal-content">
            <div class="ent-modal-header d-flex justify-content-between align-items-center">
                <h6 class="ent-font-display mb-0 text-white fw-bold"><i class="fas fa-plus-circle text-info me-2"></i>Tambah Penjamin Utama</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body p-4 bg-white">
                <form action="{{ route('master_penjamin_utama_store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark fs--1">Nama Penjamin Utama</label>
                        <input type="text" class="form-control ent-input" name="nama_penjamin" placeholder="Contoh: BPJS, Asuransi Swasta, Umum..." required>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <button type="button" class="btn btn-light border btn-sm px-3 fw-semibold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-ent-success btn-sm px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH SUB PENJAMIN -->
<div class="modal fade" id="modal-tambah-sub-penjamin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content ent-modal-content">
            <div class="ent-modal-header d-flex justify-content-between align-items-center">
                <h6 class="ent-font-display mb-0 text-white fw-bold"><i class="fas fa-plus-circle text-info me-2"></i>Form Sub Penjamin / Rekanan</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white" style="max-height: 80vh; overflow-y: auto;">
                <form action="{{ route('sub_penjamin_store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="modal-penjamin-id" name="penjamin_id">

                    <div class="row g-3">
                        <!-- SECTION 1: IDENTITAS & KONTRAK -->
                        <div class="col-md-12">
                            <div class="ent-section-title"><i class="fas fa-info-circle me-1"></i> Identitas & Kontrak</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs--1">Nama Perusahaan / Asuransi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control ent-input" name="nama_sub_penjamin" placeholder="Nama Perusahaan..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs--1">No. Kontrak / SPK / MoU</label>
                            <input type="text" class="form-control ent-input" name="no_ref" placeholder="No Referensi">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs--1">Tgl. Mulai</label>
                            <input type="date" class="form-control ent-input" name="tgl_mulai">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs--1">Tgl. Selesai</label>
                            <input type="date" class="form-control ent-input" name="tgl_selesai">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark fs--1">Catatan Pelayanan</label>
                            <textarea class="form-control ent-input" name="catatan_pelayanan" rows="2" placeholder="Catatan khusus pelayanan..."></textarea>
                        </div>

                        <!-- SECTION 2: PEMBAYARAN & KEUANGAN -->
                        <div class="col-md-12 mt-4">
                            <div class="ent-section-title"><i class="fas fa-calculator me-1"></i> Pengaturan Pembayaran & Keuangan</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs--1">Metode Pembayaran</label>
                            <select class="form-select ent-input" name="tipe_pembayaran" required>
                                <option value="CASH_DI_AWAL">Cash di Awal</option>
                                <option value="CORPORATE_BILLING">Corporate Billing</option>
                                <option value="INSURANCE_CLAIM">Insurance Claim</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs--1">Jatuh Tempo (Hari)</label>
                            <input type="number" class="form-control ent-input" name="jatuh_tempo_hari" value="30">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs--1">Min DP (%)</label>
                            <input type="number" step="0.01" class="form-control ent-input" name="min_dp_persen" value="0.00">
                        </div>

                        <!-- SKEMA TANGGUNGAN (COVERAGE RULE) -->
                        <div class="col-md-12 pt-2">
                            <div class="row g-3 p-3 rounded-3 border" style="background-color: var(--ent-bg);">
                                <div class="col-md-12 mb-0">
                                    <label class="fw-bold text-primary fs--2 text-uppercase"><i class="fas fa-shield-alt me-1"></i> Skema Tanggungan Biaya (Coverage Rule)</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold text-dark fs--1">Pola Tanggungan</label>
                                    <select class="form-select ent-input form-select-sm" name="pola_tanggungan" id="add-pola-tanggungan">
                                        <option value="FULL_PASIEN">Full Pasien (100% Tunai)</option>
                                        <option value="FULL_PERUSAHAAN">Full Perusahaan (100% Piutang)</option>
                                        <option value="SPLIT_PERSENTASE">Split (Persentase %)</option>
                                        <option value="SPLIT_PLAFON">Split (Plafon Rupiah)</option>
                                    </select>
                                </div>
                                <div class="col-md-4 add-wrapper-tanggungan d-none" id="add-wrapper-persen">
                                    <label class="form-label fw-semibold text-dark fs--1">Tanggungan Perusahaan (%)</label>
                                    <input type="number" step="0.01" class="form-control ent-input form-control-sm" name="tanggungan_perusahaan_persen" value="0.00">
                                </div>
                                <div class="col-md-4 add-wrapper-tanggungan d-none" id="add-wrapper-plafon">
                                    <label class="form-label fw-semibold text-dark fs--1">Maks. Plafon (Rp)</label>
                                    <input type="number" step="0.01" class="form-control ent-input form-control-sm" name="tanggungan_perusahaan_maksimal_rp" value="0.00">
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: KONTAK & ALAMAT UTAMA -->
                        <div class="col-md-12 mt-4">
                            <div class="ent-section-title"><i class="fas fa-map-marker-alt me-1"></i> Kontak & Alamat Utama</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs--1">No. Telp Perusahaan</label>
                            <input type="text" class="form-control ent-input" name="telp_perusahaan" placeholder="No Telepon...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs--1">Alamat</label>
                            <textarea class="form-control ent-input" name="alamat" rows="2" placeholder="Alamat perusahaan..."></textarea>
                        </div>

                        <!-- SECTION 4: MULTI-PIC KEUANGAN -->
                        <div class="col-md-12 mt-4">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                                <span class="ent-section-title border-0 pb-0 mb-0"><i class="fas fa-id-card me-1"></i> PIC Keuangan / Klaim</span>
                                <button type="button" class="btn btn-sm btn-ent-soft-primary py-1 px-2 fs--2" id="btn-tambah-pic-row">
                                    <i class="fas fa-plus me-1"></i> Tambah PIC
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="container-pic-rows" class="d-flex flex-column gap-2">
                                <div class="card p-2 bg-light border rounded-3 pic-item-row">
                                    <div class="row g-2 align-items-center">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control ent-input form-control-sm" name="pics[0][nama_pic]" placeholder="Nama PIC..." required>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control ent-input form-control-sm" name="pics[0][telepon]" placeholder="No. HP...">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control ent-input form-control-sm" name="pics[0][email]" placeholder="Email...">
                                        </div>
                                        <div class="col-md-1 text-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2 btn-hapus-pic" title="Hapus"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 5: KETENTUAN KHUSUS & STATUS -->
                        <div class="col-md-12 mt-4">
                            <div class="ent-section-title"><i class="fas fa-cog me-1"></i> Ketentuan & Status</div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="wajib_surat_garansi" value="1" id="add_wajib_lo">
                                <label class="form-check-label fw-semibold text-dark fs--1" for="add_wajib_lo">Wajib melampirkan Surat Garansi / LoG (Letter of Guarantee)</label>
                            </div>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" value="1" name="status_aktif" id="add_status_aktif" checked>
                                <label class="form-check-label fw-semibold text-dark fs--1" for="add_status_aktif">Status Aktif</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 mt-4 border-top">
                        <button type="button" class="btn btn-light border btn-sm px-3 fw-semibold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-ent-success btn-sm px-4">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT SUB PENJAMIN -->
<div class="modal fade" id="modal-edit-sub-penjamin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content ent-modal-content">
            <div class="ent-modal-header d-flex justify-content-between align-items-center">
                <h6 class="ent-font-display mb-0 text-white fw-bold"><i class="fas fa-edit text-warning me-2"></i>Edit Sub Penjamin / Rekanan</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white" style="max-height: 80vh; overflow-y: auto;">
                <form id="form-edit-sub-penjamin" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <!-- SECTION 1: IDENTITAS & KONTRAK -->
                        <div class="col-md-12">
                            <div class="ent-section-title"><i class="fas fa-info-circle me-1"></i> Identitas & Kontrak</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs--1">Nama Perusahaan / Asuransi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control ent-input" id="edit-nama-sub-penjamin" name="nama_sub_penjamin" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs--1">No. Kontrak / SPK / MoU</label>
                            <input type="text" class="form-control ent-input" id="edit-no-ref" name="no_ref" placeholder="No Referensi">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs--1">Tgl. Mulai</label>
                            <input type="date" class="form-control ent-input" id="edit-tgl-mulai" name="tgl_mulai">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs--1">Tgl. Selesai</label>
                            <input type="date" class="form-control ent-input" id="edit-tgl-selesai" name="tgl_selesai">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-dark fs--1">Catatan Pelayanan</label>
                            <textarea class="form-control ent-input" id="edit-catatan-pelayanan" name="catatan_pelayanan" rows="2" placeholder="Catatan khusus pelayanan..."></textarea>
                        </div>

                        <!-- SECTION 2: PEMBAYARAN & KEUANGAN -->
                        <div class="col-md-12 mt-4">
                            <div class="ent-section-title"><i class="fas fa-calculator me-1"></i> Pengaturan Pembayaran & Keuangan</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs--1">Metode Pembayaran</label>
                            <select class="form-select ent-input" id="edit-tipe-pembayaran" name="tipe_pembayaran" required>
                                <option value="CASH_DI_AWAL">Cash di Awal</option>
                                <option value="CORPORATE_BILLING">Corporate Billing</option>
                                <option value="INSURANCE_CLAIM">Insurance Claim</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs--1">Jatuh Tempo (Hari)</label>
                            <input type="number" class="form-control ent-input" id="edit-jatuh-tempo" name="jatuh_tempo_hari">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark fs--1">Min DP (%)</label>
                            <input type="number" step="0.01" class="form-control ent-input" id="edit-min-dp" name="min_dp_persen">
                        </div>

                        <!-- SKEMA TANGGUNGAN (COVERAGE RULE) MODAL EDIT -->
                        <div class="col-md-12 pt-2">
                            <div class="row g-3 p-3 rounded-3 border" style="background-color: var(--ent-bg);">
                                <div class="col-md-12 mb-0">
                                    <label class="fw-bold text-primary fs--2 text-uppercase"><i class="fas fa-shield-alt me-1"></i> Skema Tanggungan Biaya (Coverage Rule)</label>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold text-dark fs--1">Pola Tanggungan</label>
                                    <select class="form-select ent-input form-select-sm" name="pola_tanggungan" id="edit-pola-tanggungan">
                                        <option value="FULL_PASIEN">Full Pasien (100% Tunai)</option>
                                        <option value="FULL_PERUSAHAAN">Full Perusahaan (100% Piutang)</option>
                                        <option value="SPLIT_PERSENTASE">Split (Persentase %)</option>
                                        <option value="SPLIT_PLAFON">Split (Plafon Rupiah)</option>
                                    </select>
                                </div>
                                <div class="col-md-4 edit-wrapper-tanggungan d-none" id="edit-wrapper-persen">
                                    <label class="form-label fw-semibold text-dark fs--1">Tanggungan Perusahaan (%)</label>
                                    <input type="number" step="0.01" class="form-control ent-input form-control-sm" id="edit-tanggungan-persen" name="tanggungan_perusahaan_persen" value="0.00">
                                </div>
                                <div class="col-md-4 edit-wrapper-tanggungan d-none" id="edit-wrapper-plafon">
                                    <label class="form-label fw-semibold text-dark fs--1">Maks. Plafon (Rp)</label>
                                    <input type="number" step="0.01" class="form-control ent-input form-control-sm" id="edit-tanggungan-plafon" name="tanggungan_perusahaan_maksimal_rp" value="0.00">
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: KONTAK & ALAMAT UTAMA -->
                        <div class="col-md-12 mt-4">
                            <div class="ent-section-title"><i class="fas fa-id-card me-1"></i> Kontak & Alamat Utama</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs--1">No. Telp Perusahaan</label>
                            <input type="text" class="form-control ent-input" id="edit-telp-perusahaan" name="telp_perusahaan" placeholder="No Telepon...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-dark fs--1">Alamat</label>
                            <textarea class="form-control ent-input" id="edit-alamat" name="alamat" rows="2" placeholder="Alamat perusahaan..."></textarea>
                        </div>

                        <!-- SECTION 4: MULTI-PIC KEUANGAN -->
                        <div class="col-md-12 mt-4">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                                <span class="ent-section-title border-0 pb-0 mb-0"><i class="fas fa-id-card me-1"></i> PIC Keuangan / Klaim</span>
                                <button type="button" class="btn btn-sm btn-ent-soft-primary py-1 px-2 fs--2" id="btn-tambah-pic-row-edit">
                                    <i class="fas fa-plus me-1"></i> Tambah PIC
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="container-pic-rows-edit" class="d-flex flex-column gap-2"></div>
                        </div>

                        <!-- SECTION 5: KETENTUAN KHUSUS & STATUS -->
                        <div class="col-md-12 mt-4">
                            <div class="ent-section-title"><i class="fas fa-cog me-1"></i> Ketentuan & Status</div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="wajib_surat_garansi" value="1" id="edit_wajib_lo">
                                <label class="form-check-label fw-semibold text-dark fs--1" for="edit_wajib_lo">Wajib melampirkan Surat Garansi / LoG (Letter of Guarantee)</label>
                            </div>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" value="1" name="status_aktif" id="edit_status_aktif">
                                <label class="form-check-label fw-semibold text-dark fs--1" for="edit_status_aktif">Status Aktif</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 mt-4 border-top">
                        <button type="button" class="btn btn-light border btn-sm px-3 fw-semibold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-ent-success btn-sm px-4">Perbarui Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PENGATURAN TARIF (DINAMIS 3 TABEL) -->
<div class="modal fade" id="modal-pengaturan-tarif" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content ent-modal-content">
            <div class="ent-modal-header d-flex justify-content-between align-items-center">
                <h6 class="ent-font-display mb-0 text-white fw-bold"><i class="fas fa-tags text-info me-2"></i>Pengaturan Tarif Khusus: <span id="title-tarif-nama" style="color: #38bdf8;"></span></h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body p-0 bg-white">
                <div class="row g-0 h-100">
                    <!-- KOLOM KIRI: FORM TAMBAH -->
                    <div class="col-md-4 p-4 border-end bg-light" style="max-height: 560px; overflow-y: auto;">
                        <h6 class="ent-font-display fw-bold text-dark border-bottom pb-2 mb-3"><i class="fas fa-plus-circle text-primary me-1"></i> Tambah Tarif</h6>
                        <form id="form-pengaturan-tarif">
                            @csrf
                            <input type="hidden" name="sub_penjamin_id" id="tarif-sub-id">
                            <div class="mb-3 p-3 border rounded-3 bg-white shadow-sm">
                                <label class="form-label fw-bold text-dark fs--1 mb-1"><i class="fas fa-copy text-warning me-1"></i> Salin Data dari Sub Penjamin Lain</label>
                                <div class="input-group input-group-sm">
                                    <select class="form-select ent-input form-select-sm" id="select-sumber-sub-penjamin">
                                        <option value="">-- Pilih Sub Penjamin Sumber --</option>
                                    </select>
                                    <button type="button" class="btn btn-ent-soft-warning px-3" id="btn-proses-salin-tarif">
                                        <i class="fas fa-file-import me-1"></i> Salin
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-1" style="font-size: 0.68rem;">Menyalin semua data tarif IGD, Poli, dan Ranap ke sub penjamin ini.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark fs--1">Kategori Layanan</label>
                                <select class="form-select ent-input" name="kategori_layanan" id="select-kategori-tarif" required>
                                    <option value="">-- Pilih Layanan --</option>
                                    <option value="IGD">Tarif IGD</option>
                                    <option value="POLI">Tarif Poliklinik (Rajal)</option>
                                    <option value="RANAP">Tarif Rawat Inap (Ranap)</option>
                                </select>
                            </div>

                            <!-- FORM KHUSUS IGD -->
                            <div id="form-group-igd" class="d-none dynamic-tarif-form p-3 mb-3 border rounded-3 bg-white shadow-sm">
                                <h6 class="fw-bold text-danger border-bottom pb-2 fs--1"><i class="fas fa-ambulance me-1"></i> Form Tarif IGD</h6>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs--2">Kategori Biaya</label>
                                    <select class="form-select form-select-sm ent-input" name="igd_kategori_biaya">
                                        <option value="ADMINISTRASI">Administrasi</option>
                                        <option value="JASA_DOKTER_IGD">Jasa Dokter IGD</option>
                                        <option value="SARANA_IGD">Sarana IGD</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs--2">Nama Tarif</label>
                                    <input type="text" class="form-control form-control-sm ent-input" name="igd_nama_tarif" placeholder="Cth: Konsultasi Dokter Jaga">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs--2">Nominal Tarif (Rp)</label>
                                    <input type="number" class="form-control form-control-sm ent-input" name="igd_tarif" placeholder="0">
                                </div>
                            </div>

                            <!-- FORM KHUSUS POLI -->
                            <div id="form-group-poli" class="d-none dynamic-tarif-form p-3 mb-3 border rounded-3 bg-white shadow-sm">
                                <h6 class="fw-bold text-success border-bottom pb-2 fs--1"><i class="fas fa-stethoscope me-1"></i> Form Tarif Poliklinik</h6>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs--2">Pilih Poliklinik</label>
                                    <select class="form-select form-select-sm ent-input" name="poli_id" id="select-master-poli">
                                        <option value="">-- Memuat data Poli... --</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs--2">Kategori Biaya</label>
                                    <select class="form-select form-select-sm ent-input" name="poli_kategori_biaya">
                                        <option value="ADMINISTRASI">Administrasi</option>
                                        <option value="JASA_DOKTER">Jasa Dokter</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs--2">Nama Tarif</label>
                                    <input type="text" class="form-control form-control-sm ent-input" name="poli_nama_tarif" placeholder="Cth: Jasa Konsultasi Spesialis">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs--2">Nominal Tarif (Rp)</label>
                                    <input type="number" class="form-control form-control-sm ent-input" name="poli_tarif" placeholder="0">
                                </div>
                            </div>

                            <!-- FORM KHUSUS RAWAT INAP (RANAP) -->
                            <div id="form-group-ranap" class="d-none dynamic-tarif-form p-3 mb-3 border rounded-3 bg-white shadow-sm">
                                <h6 class="fw-bold text-primary border-bottom pb-2 fs--1"><i class="fas fa-procedures me-1"></i> Form Tarif Rawat Inap</h6>

                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs--2">Pilih Ruangan</label>
                                    <select class="form-select form-select-sm ent-input" name="ruangan_id" id="select-master-ruangan">
                                        <option value="">-- Memuat data Ruangan... --</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs--2">Pilih Bed (Opsional)</label>
                                    <select class="form-select form-select-sm ent-input" name="bed_id" id="select-master-bed" disabled>
                                        <option value="">-- Pilih Ruangan Terlebih Dahulu --</option>
                                    </select>
                                </div>

                                <input type="hidden" name="ranap_kelas" id="hidden-ranap-kelas">

                                <div class="mb-2 mt-3 border-top pt-2">
                                    <label class="form-label fw-semibold text-dark fs--2">Tarif Kamar / Hari (Rp)</label>
                                    <input type="number" class="form-control form-control-sm ent-input" name="ranap_tarif_kamar" placeholder="0">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs--2">Tarif Visite Dokter / Hari (Rp)</label>
                                    <input type="number" class="form-control form-control-sm ent-input" name="ranap_tarif_visite" placeholder="0">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs--2">Tarif Askep / Hari (Rp)</label>
                                    <input type="number" class="form-control form-control-sm ent-input" name="ranap_tarif_askep" placeholder="0">
                                </div>
                            </div>

                            <!-- SKEMA TANGGUNGAN KHUSUS LAYANAN INI -->
                            <div class="p-3 mb-3 border rounded-3 bg-white shadow-sm" id="form-group-coverage" style="display: none;">
                                <h6 class="fw-bold text-primary border-bottom pb-1 fs--2 text-uppercase"><i class="fas fa-shield-alt me-1"></i> Skema Tanggungan Tarif Ini</h6>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold text-dark fs--2">Aturan Tanggungan</label>
                                    <select class="form-select form-select-sm ent-input" name="pola_tanggungan" id="tarif-pola-tanggungan">
                                        <option value="IKUT_ATURAN_INDUK">Ikut Aturan Induk (Default)</option>
                                        <option value="FULL_PASIEN">Full Pasien (100% Tunai)</option>
                                        <option value="FULL_PERUSAHAAN">Full Perusahaan (100% Piutang)</option>
                                        <option value="SPLIT_PERSENTASE">Split (Persentase %)</option>
                                        <option value="SPLIT_PLAFON">Split (Plafon Rupiah)</option>
                                    </select>
                                </div>
                                <div class="mb-2 tarif-wrapper-tanggungan d-none" id="tarif-wrapper-persen">
                                    <label class="form-label fw-semibold text-dark fs--2">Tanggungan Perusahaan (%)</label>
                                    <input type="number" step="0.01" class="form-control form-control-sm ent-input" name="tanggungan_perusahaan_persen" value="0">
                                </div>
                                <div class="mb-2 tarif-wrapper-tanggungan d-none" id="tarif-wrapper-plafon">
                                    <label class="form-label fw-semibold text-dark fs--2">Maks. Tanggungan (Rp)</label>
                                    <input type="number" step="0.01" class="form-control form-control-sm ent-input" name="tanggungan_perusahaan_maksimal_rp" value="0">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-ent-primary w-100 btn-sm mt-2 py-2" id="btn-save-tarif" disabled>
                                <i class="fas fa-save me-1"></i> Simpan Tarif
                            </button>
                        </form>
                    </div>

                    <!-- KOLOM KANAN: TABEL LISTING -->
                    <div class="col-md-8 p-4">
                        <h6 class="ent-font-display fw-bold text-dark border-bottom pb-2 mb-3"><i class="fas fa-list text-primary me-1"></i> Daftar Tarif Layanan</h6>
                        <div class="table-responsive" style="max-height: 460px; overflow-y: auto;">
                            <table class="table table-custom align-middle w-100 mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 40px;">No</th>
                                        <th>Layanan</th>
                                        <th>Detail Kategori / Nama Tarif</th>
                                        <th class="text-end">Rincian Harga (Rp)</th>
                                        <th class="text-center" style="width: 70px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-list-tarif">
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Pilih Kategori Layanan</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PENGATURAN PEMERIKSAAN -->
<div class="modal fade" id="modal-pengaturan-pemeriksaan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ent-modal-content">
            <div class="ent-modal-header d-flex justify-content-between align-items-center">
                <h6 class="ent-font-display mb-0 text-white fw-bold"><i class="fas fa-stethoscope text-info me-2"></i>Pengaturan Harga Pemeriksaan</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-body p-4 bg-white">
                <form id="form-pengaturan-pemeriksaan" method="POST">
                    @csrf
                    <input type="hidden" name="sub_penjamin_id" id="pemeriksaan-sub-id">

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark fs--1">Sub Penjamin</label>
                        <input type="text" class="form-control ent-input bg-light text-muted" id="pemeriksaan-sub-nama" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark fs--1">Jenis Pemeriksaan</label>
                        <select class="form-select ent-input" name="jenis_pemeriksaan" required>
                            <option value="Laboratorium">Laboratorium</option>
                            <option value="Radiologi">Radiologi</option>
                            <option value="Fisioterapi">Fisioterapi</option>
                            <option value="Poliklinik Spesialis">Poliklinik Spesialis</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark fs--1">Harga Acuan Khusus (Rp)</label>
                        <input type="number" class="form-control ent-input" name="harga_khusus" placeholder="Contoh: 150000" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <button type="button" class="btn btn-light border btn-sm px-3 fw-semibold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-ent-primary btn-sm px-4">Simpan Pemeriksaan</button>
                    </div>
                </form>
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
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>

<script>
    let currentSubPenjaminData = [];
    let subTable;
    let picIndexAdd = 1;
    let picIndexEdit = 1;

    $(document).ready(function() {
        // Live Search Penjamin Utama
        $('#search-penjamin-utama').on('input', function() {
            let keyword = $(this).val().toLowerCase().trim();
            $('#list-penjamin-utama .list-group-item-penjamin').each(function() {
                let nama = $(this).find('.nama-penjamin-text').text().toLowerCase();
                let kategori = $(this).find('.badge').text().toLowerCase();
                if (nama.includes(keyword) || kategori.includes(keyword)) {
                    $(this).removeClass('d-none').addClass('d-flex');
                } else {
                    $(this).removeClass('d-flex').addClass('d-none');
                }
            });
        });

        $('#add-pola-tanggungan').on('change', function() {
            let val = $(this).val();
            $('.add-wrapper-tanggungan').addClass('d-none');
            if (val === 'SPLIT_PERSENTASE') {
                $('#add-wrapper-persen').removeClass('d-none');
            } else if (val === 'SPLIT_PLAFON') {
                $('#add-wrapper-plafon').removeClass('d-none');
            }
        });

        $('#edit-pola-tanggungan').on('change', function() {
            let val = $(this).val();
            $('.edit-wrapper-tanggungan').addClass('d-none');
            if (val === 'SPLIT_PERSENTASE') {
                $('#edit-wrapper-persen').removeClass('d-none');
            } else if (val === 'SPLIT_PLAFON') {
                $('#edit-wrapper-plafon').removeClass('d-none');
            }
        });

        subTable = $('#table-sub-penjamin').DataTable({
            responsive: true,
            language: {
                search: "",
                searchPlaceholder: "Cari sub penjamin...",
                emptyTable: "Pilih penjamin utama untuk melihat data."
            },
            pageLength: 10
        });

        $('#btn-tambah-pic-row').on('click', function() {
            let rowHtml = `
            <div class="card p-2 bg-light border rounded-3 pic-item-row">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" class="form-control ent-input form-control-sm" name="pics[${picIndexAdd}][nama_pic]" placeholder="Nama PIC..." required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control ent-input form-control-sm" name="pics[${picIndexAdd}][telepon]" placeholder="No. HP...">
                    </div>
                    <div class="col-md-4">
                        <input type="email" class="form-control ent-input form-control-sm" name="pics[${picIndexAdd}][email]" placeholder="Email...">
                    </div>
                    <div class="col-md-1 text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2 btn-hapus-pic" title="Hapus"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>`;
            $('#container-pic-rows').append(rowHtml);
            picIndexAdd++;
        });

        $('#btn-tambah-pic-row-edit').on('click', function() {
            let rowHtml = `
            <div class="card p-2 bg-light border rounded-3 pic-item-row-edit">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" class="form-control ent-input form-control-sm" name="pics[${picIndexEdit}][nama_pic]" placeholder="Nama PIC..." required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control ent-input form-control-sm" name="pics[${picIndexEdit}][telepon]" placeholder="No. HP...">
                    </div>
                    <div class="col-md-4">
                        <input type="email" class="form-control ent-input form-control-sm" name="pics[${picIndexEdit}][email]" placeholder="Email...">
                    </div>
                    <div class="col-md-1 text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2 btn-hapus-pic" title="Hapus"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>`;
            $('#container-pic-rows-edit').append(rowHtml);
            picIndexEdit++;
        });

        $(document).on('click', '.btn-hapus-pic', function() {
            let container = $(this).closest('#container-pic-rows, #container-pic-rows-edit');
            if (container.find('.card').length > 1) {
                $(this).closest('.card').remove();
            } else {
                Swal.fire('Perhatian', 'Minimal harus ada 1 form PIC.', 'warning');
            }
        });

        triggerFirstVisiblePenjamin();
    });

    function triggerFirstVisiblePenjamin() {
        let firstItem = $('#list-penjamin-utama .list-group-item-penjamin:visible').first();
        if (firstItem.length > 0) {
            firstItem.find('.item-click-target').trigger('click');
        } else {
            $('#selected-penjamin-title').text('Tidak ada data');
            $('#btn-tambah-sub-trigger').prop('disabled', true);
            subTable.clear().draw();
        }
    }

    $(document).on('click', '.list-group-item-penjamin .item-click-target', function(e) {
        e.stopPropagation();
        let parentItem = $(this).closest('.list-group-item-penjamin');
        $('.list-group-item-penjamin').removeClass('active');
        parentItem.addClass('active');

        let penjaminId = parentItem.data('id');
        let penjaminNama = parentItem.data('nama');

        $('#selected-penjamin-title').text(penjaminNama + ' (Memuat...)');
        $('#modal-penjamin-id').val(penjaminId);
        $('#btn-tambah-sub-trigger').prop('disabled', true);
        subTable.clear().draw();

        $.ajax({
            url: `/master-data/penjamin/get-sub/${penjaminId}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#selected-penjamin-title').text(penjaminNama);
                    $('#btn-tambah-sub-trigger').prop('disabled', false);
                    currentSubPenjaminData = response.data;
                    renderSubPenjaminTable(currentSubPenjaminData);
                } else {
                    $('#selected-penjamin-title').text(penjaminNama + ' (Gagal memuat)');
                    Swal.fire('Error', 'Gagal memuat data sub penjamin.', 'error');
                }
            },
            error: function() {
                $('#selected-penjamin-title').text(penjaminNama + ' (Gagal memuat)');
                Swal.fire('Error', 'Terjadi kesalahan jaringan atau server.', 'error');
            }
        });
    });

    function renderSubPenjaminTable(dataArray) {
        subTable.clear();
        if (dataArray && dataArray.length > 0) {
            dataArray.forEach((sub, index) => {
                let badgeBilling = 'badge-soft-indigo';
                if (sub.tipe_pembayaran === 'CORPORATE_BILLING') badgeBilling = 'badge-soft-warning';
                else if (sub.tipe_pembayaran === 'INSURANCE_CLAIM') badgeBilling = 'badge-soft-info';
                else badgeBilling = 'badge-soft-success';

                let rawStatus = sub.status_aktif !== undefined ? sub.status_aktif : 1;
                let statusVal = Number(rawStatus);
                let statusBadge = (statusVal === 1) ?
                    '<span class="ent-badge badge-soft-success"><i class="fas fa-check-circle"></i> Aktif</span>' :
                    '<span class="ent-badge badge-soft-danger"><i class="fas fa-times-circle"></i> Non-Aktif</span>';

                let picListHtml = '<span class="text-muted fst-italic fs--2">Belum ada PIC</span>';
                if (sub.pics && sub.pics.length > 0) {
                    picListHtml = sub.pics.map(p => `<span class="fw-semibold text-dark">${p.nama_pic}</span> <small class="text-muted">(${p.telepon || '-'})</small>`).join('<br>');
                }

                let agreementInfo = `<span class="fw-semibold text-dark">Kontrak / Ref</span><br><small class="text-muted">Ref: ${sub.no_ref || '-'}</small>`;

                let actionBtn = `<div class="d-flex justify-content-center gap-1">`;
                actionBtn += `<button class="btn btn-sm btn-ent-soft-warning px-2 py-1 btn-edit-sub"
                                data-id="${sub.sub_penjamin_id}"
                                data-aktif="${statusVal}"
                                title="Edit Sub Penjamin" style="font-size: 0.72rem;">
                                <i class="fas fa-edit"></i>
                              </button>`;

                if (statusVal === 0) {
                    actionBtn += `<button class="btn btn-sm btn-ent-soft-primary px-2 py-1 btn-tarif"
                                    data-id="${sub.sub_penjamin_id}"
                                    title="Pengaturan Tarif" style="font-size: 0.72rem;">
                                    <i class="fas fa-tags"></i>
                                  </button>`;

                    actionBtn += `<button class="btn btn-sm btn-ent-soft-info px-2 py-1 btn-pemeriksaan"
                                    data-id="${sub.sub_penjamin_id}"
                                    title="Pengaturan Pemeriksaan" style="font-size: 0.72rem;">
                                    <i class="fas fa-stethoscope"></i>
                                  </button>`;
                }
                actionBtn += `</div>`;

                subTable.row.add([
                    `<div class="text-center fw-semibold text-muted">${index + 1}</div>`,
                    `<div class="fw-bold text-dark">${sub.nama_sub_penjamin}<br><small class="text-muted fw-normal">Ref: ${sub.no_ref || '-'}</small></div>`,
                    `<div class="text-center">${statusBadge}</div>`,
                    `<div class="text-center"><span class="ent-badge ${badgeBilling}">${sub.tipe_pembayaran || 'CASH'}</span></div>`,
                    `<div>${picListHtml}</div>`,
                    `<div class="text-center">${agreementInfo}</div>`,
                    actionBtn
                ]);
            });
        }
        subTable.draw();
    }

    $(document).on('click', '.btn-edit-sub', function() {
        let id = $(this).data('id');
        let statusAktif = Number($(this).data('aktif'));
        let sub = currentSubPenjaminData.find(item => item.sub_penjamin_id == id);
        if (!sub) return;

        if (statusAktif === 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Sub Penjamin Sedang Aktif',
                text: 'Data yang berstatus AKTIF tidak dapat diubah. Apakah Anda ingin menonaktifkannya sekarang?',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-power-off"></i> Ya, Nonaktifkan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#475569'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = $('<form>', {
                        'method': 'POST',
                        'action': `/master-data/master-penjamin/nonaktifkan-sub/${id}`
                    });
                    form.append($('<input>', {
                        'type': 'hidden',
                        'name': '_token',
                        'value': '{{ csrf_token() }}'
                    }));
                    $('body').append(form);
                    form.submit();
                }
            });
            return;
        }

        bukaModalEditLengkap(sub, id);
    });

    $(document).on('click', '.btn-tarif', function() {
        let id = $(this).data('id');
        let sub = currentSubPenjaminData.find(item => item.sub_penjamin_id == id);
        if (!sub) return;

        $('#title-tarif-nama').text(sub.nama_sub_penjamin);
        $('#tarif-sub-id').val(id);
        $('#form-pengaturan-tarif')[0].reset();
        $('.dynamic-tarif-form').addClass('d-none');
        $('#form-group-coverage').hide();
        $('#btn-save-tarif').prop('disabled', true);
        $('#form-pengaturan-tarif').attr('action', `/master-data/master-penjamin/store-tarif/${id}`);

        loadDropdownSumberSubPenjamin(id);
        $('#modal-pengaturan-tarif').modal('show');
        loadTableTarif(id);
    });

    let isMasterPoliLoaded = false;
    let isMasterRuanganLoaded = false;

    $('#select-kategori-tarif').on('change', function() {
        let val = $(this).val();
        $('.dynamic-tarif-form').addClass('d-none');
        $('#btn-save-tarif').prop('disabled', true);

        if (val) {
            $('#form-group-coverage').show();
            $('#btn-save-tarif').prop('disabled', false);
        } else {
            $('#form-group-coverage').hide();
        }

        if (val === 'IGD') {
            $('#form-group-igd').removeClass('d-none');
        } else if (val === 'POLI') {
            $('#form-group-poli').removeClass('d-none');
            if (!isMasterPoliLoaded) {
                $('#select-master-poli').html('<option value="">-- Memuat data... --</option>');
                $.get('/master-data/master-penjamin/polis-json', function(res) {
                    let options = '<option value="">-- Pilih Poli --</option>';
                    if (res.data && res.data.length > 0) {
                        res.data.forEach(poli => {
                            options += `<option value="${poli.id}">${poli.nama_poli}</option>`;
                        });
                    }
                    $('#select-master-poli').html(options);
                    isMasterPoliLoaded = true;
                }).fail(function() {
                    $('#select-master-poli').html('<option value="">Gagal memuat data poli</option>');
                });
            }
        } else if (val === 'RANAP') {
            $('#form-group-ranap').removeClass('d-none');
            if (!isMasterRuanganLoaded) {
                $('#select-master-ruangan').html('<option value="">-- Memuat data... --</option>');
                $.get('master-data/master-penjamin/get-all', function(res) {
                    let options = '<option value="">-- Pilih Ruangan --</option>';
                    if (res.data && res.data.length > 0) {
                        res.data.forEach(rg => {
                            options += `<option value="${rg.id}" data-kelas="${rg.kelas}">${rg.nama_ruangan} (Kelas ${rg.kelas})</option>`;
                        });
                    }
                    $('#select-master-ruangan').html(options);
                    isMasterRuanganLoaded = true;
                }).fail(function() {
                    $('#select-master-ruangan').html('<option value="">Gagal memuat data ruangan</option>');
                });
            }
        }
    });

    $('#select-master-ruangan').on('change', function() {
        let ruanganId = $(this).val();
        let kelasTerkait = $(this).find('option:selected').data('kelas');
        $('#hidden-ranap-kelas').val(kelasTerkait || '');
        let bedSelect = $('#select-master-bed');

        if (ruanganId) {
            bedSelect.prop('disabled', false).html('<option value="">-- Memuat bed... --</option>');
            $.get(`master-data/master-penjamin/bed-tersedia/${ruanganId}`, function(res) {
                let options = '<option value="">-- Pilih Bed --</option>';
                if (res.data && res.data.length > 0) {
                    res.data.forEach(bed => {
                        options += `<option value="${bed.id}">${bed.nomor_bed} - [${bed.status}]</option>`;
                    });
                } else {
                    options = '<option value="">Bed tidak tersedia</option>';
                }
                bedSelect.html(options);
            }).fail(function() {
                bedSelect.html('<option value="">Gagal memuat data bed</option>');
            });
        } else {
            bedSelect.prop('disabled', true).html('<option value="">-- Pilih Ruangan Terlebih Dahulu --</option>');
        }
    });

    $('#tarif-pola-tanggungan').on('change', function() {
        let val = $(this).val();
        $('.tarif-wrapper-tanggungan').addClass('d-none');
        if (val === 'SPLIT_PERSENTASE') $('#tarif-wrapper-persen').removeClass('d-none');
        else if (val === 'SPLIT_PLAFON') $('#tarif-wrapper-plafon').removeClass('d-none');
    });

    $('#form-pengaturan-tarif').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        let submitBtn = $('#btn-save-tarif');
        let subId = $('#tarif-sub-id').val();

        if (!subId) {
            Swal.fire('Error', 'ID Sub Penjamin tidak ditemukan.', 'error');
            return;
        }

        let formData = form.serialize();
        let actionUrl = `/master-data/master-penjamin/store-tarif/${subId}`;
        let originalBtnText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                submitBtn.prop('disabled', false).html(originalBtnText);
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Tarif berhasil disimpan.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    loadTableTarif(subId);
                    form.find('input[type="number"], input[type="text"]').val('');
                } else {
                    Swal.fire('Gagal', response.message || 'Gagal menyimpan tarif.', 'error');
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html(originalBtnText);
                let errorMsg = 'Terjadi kesalahan pada server.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire('Error', errorMsg, 'error');
            }
        });
    });

    function renderCoverageInfo(row, totalTarif) {
        const formatRp = (angka) => new Intl.NumberFormat('id-ID').format(angka);
        let pola = row.pola_tanggungan || 'IKUT_ATURAN_INDUK';
        let total = parseFloat(totalTarif) || 0;

        if (pola === 'IKUT_ATURAN_INDUK') {
            return `<div class="mt-1"><span class="badge bg-light text-secondary border w-100" style="font-size:0.62rem;">Ikut Aturan Induk</span></div>`;
        }
        if (pola === 'FULL_PASIEN') {
            return `<div class="mt-1 text-danger fw-bold" style="font-size:0.7rem;"><i class="fas fa-user me-1"></i>Pasien: Rp ${formatRp(total)}</div>`;
        }
        if (pola === 'FULL_PERUSAHAAN') {
            return `<div class="mt-1 text-success fw-bold" style="font-size:0.7rem;"><i class="fas fa-building me-1"></i>Prsh: Rp ${formatRp(total)}</div>`;
        }
        if (pola === 'SPLIT_PERSENTASE') {
            let persen = parseFloat(row.tanggungan_perusahaan_persen) || 0;
            let prsh = total * (persen / 100);
            let psn = total - prsh;
            return `<div class="mt-1 border-top pt-1" style="font-size:0.7rem;">
                        <div class="text-success fw-semibold"><i class="fas fa-building me-1"></i>Prsh (${persen}%): Rp ${formatRp(prsh)}</div>
                        <div class="text-danger fw-semibold"><i class="fas fa-user me-1"></i>Pasien: Rp ${formatRp(psn)}</div>
                    </div>`;
        }
        if (pola === 'SPLIT_PLAFON') {
            let plafon = parseFloat(row.tanggungan_perusahaan_maksimal_rp) || 0;
            let prsh = Math.min(total, plafon);
            let psn = total - prsh;
            return `<div class="mt-1 border-top pt-1" style="font-size:0.7rem;">
                        <div class="text-success fw-semibold"><i class="fas fa-building me-1"></i>Prsh (Maks): Rp ${formatRp(prsh)}</div>
                        <div class="text-danger fw-semibold"><i class="fas fa-user me-1"></i>Pasien: Rp ${formatRp(psn)}</div>
                    </div>`;
        }
        return '';
    }

    function loadTableTarif(subPenjaminId) {
        $('#tbody-list-tarif').html('<tr><td colspan="5" class="text-center py-4 text-muted"><i class="fas fa-spinner fa-spin me-2"></i> Memuat data...</td></tr>');

        $.get(`/master-data/master-penjamin/get-tarif/${subPenjaminId}`, function(response) {
            let tbody = '';
            let no = 1;
            const formatRp = (angka) => new Intl.NumberFormat('id-ID').format(angka);

            if (response.status === 'success') {
                if (response.data.igd && response.data.igd.length > 0) {
                    response.data.igd.forEach(row => {
                        let coverageHtml = renderCoverageInfo(row, row.tarif);
                        tbody += `<tr>
                            <td class="text-center">${no++}</td>
                            <td><span class="ent-badge badge-soft-danger">IGD</span></td>
                            <td><small class="text-muted fw-semibold d-block">${row.kategori_biaya}</small><span class="fw-bold text-dark">${row.nama_tarif}</span></td>
                            <td class="text-end">
                                <div class="fw-bold text-dark">Rp ${formatRp(row.tarif)}</div>
                                ${coverageHtml}
                            </td>
                            <td class="text-center"><button class="btn btn-sm btn-outline-danger py-1 px-2 btn-hapus-tarif"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
                    });
                }

                if (response.data.poli && response.data.poli.length > 0) {
                    response.data.poli.forEach(row => {
                        let coverageHtml = renderCoverageInfo(row, row.tarif);
                        tbody += `<tr>
                            <td class="text-center">${no++}</td>
                            <td><span class="ent-badge badge-soft-success">POLIKLINIK</span></td>
                            <td><small class="text-muted fw-semibold d-block">${row.kategori_biaya}</small><span class="fw-bold text-dark">${row.nama_tarif}</span></td>
                            <td class="text-end">
                                <div class="fw-bold text-dark">Rp ${formatRp(row.tarif)}</div>
                                ${coverageHtml}
                            </td>
                            <td class="text-center"><button class="btn btn-sm btn-outline-danger py-1 px-2 btn-hapus-tarif"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
                    });
                }

                if (response.data.ranap && response.data.ranap.length > 0) {
                    response.data.ranap.forEach(row => {
                        let totalRanap = parseFloat(row.tarif_kamar_per_hari) + parseFloat(row.tarif_visite_dokter_per_hari) + parseFloat(row.tarif_asuhan_keperawatan_per_hari);
                        let coverageHtml = renderCoverageInfo(row, totalRanap);
                        let rincian = `Kamar: Rp ${formatRp(row.tarif_kamar_per_hari)}<br>Visite: Rp ${formatRp(row.tarif_visite_dokter_per_hari)}<br>Askep: Rp ${formatRp(row.tarif_asuhan_keperawatan_per_hari)}`;
                        tbody += `<tr>
                            <td class="text-center">${no++}</td>
                            <td><span class="ent-badge badge-soft-indigo">RAWAT INAP</span></td>
                            <td class="fw-bold text-dark">Kelas: ${row.kelas}</td>
                            <td class="text-end">
                                <div style="font-size: 0.75rem;" class="mb-1 text-muted">${rincian}</div>
                                <div class="fw-bold text-dark border-top pt-1">Total: Rp ${formatRp(totalRanap)}</div>
                                ${coverageHtml}
                            </td>
                            <td class="text-center align-middle"><button class="btn btn-sm btn-outline-danger py-1 px-2 btn-hapus-tarif"><i class="fas fa-trash"></i></button></td>
                        </tr>`;
                    });
                }

                if (no === 1) tbody = `<tr><td colspan="5" class="text-center py-4 text-muted fst-italic">Belum ada tarif terdaftar.</td></tr>`;
            } else {
                tbody = `<tr><td colspan="5" class="text-center py-4 text-danger fw-semibold">Gagal memuat format data.</td></tr>`;
            }
            $('#tbody-list-tarif').html(tbody);
        });
    }

    function bukaModalEditLengkap(sub, id) {
        $('#edit-nama-sub-penjamin').val(sub.nama_sub_penjamin);
        $('#edit-no-ref').val(sub.no_ref);
        $('#edit-tgl-mulai').val(sub.tgl_mulai);
        $('#edit-tgl-selesai').val(sub.tgl_selesai);
        $('#edit-catatan-pelayanan').val(sub.catatan_pelayanan);

        $('#edit-tipe-pembayaran').val(sub.tipe_pembayaran);
        $('#edit-min-dp').val(sub.min_dp_persen);
        $('#edit-jatuh-tempo').val(sub.jatuh_tempo_hari);

        $('#edit-telp-perusahaan').val(sub.telp_perusahaan);
        $('#edit-alamat').val(sub.alamat);

        let rawStatusEdit = sub.status_aktif !== undefined ? sub.status_aktif : 0;
        $('#edit_status_aktif').prop('checked', Number(rawStatusEdit) === 1);
        $('#edit_wajib_lo').prop('checked', Number(sub.wajib_surat_garansi) === 1);

        $('#edit-pola-tanggungan').val(sub.pola_tanggungan || 'FULL_PASIEN').trigger('change');
        $('#edit-tanggungan-persen').val(sub.tanggungan_perusahaan_persen || 0);
        $('#edit-tanggungan-plafon').val(sub.tanggungan_perusahaan_maksimal_rp || 0);

        loadPicEditModal(sub);

        $('#form-edit-sub-penjamin').attr('action', `/master-data/master-penjamin/update-sub/${id}`);
        $('#modal-edit-sub-penjamin').modal('show');
    }

    function loadPicEditModal(sub) {
        let picContainerEdit = $('#container-pic-rows-edit');
        picContainerEdit.empty();

        if (sub.pics && sub.pics.length > 0) {
            sub.pics.forEach((p, idx) => {
                let rowHtml = `
                    <div class="card p-2 bg-light border rounded-3 pic-item-row-edit">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-4">
                                <input type="text" class="form-control ent-input form-control-sm" name="pics[${idx}][nama_pic]" value="${p.nama_pic || ''}" placeholder="Nama PIC..." required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control ent-input form-control-sm" name="pics[${idx}][telepon]" value="${p.telepon || ''}" placeholder="No. HP...">
                            </div>
                            <div class="col-md-4">
                                <input type="email" class="form-control ent-input form-control-sm" name="pics[${idx}][email]" value="${p.email || ''}" placeholder="Email...">
                            </div>
                            <div class="col-md-1 text-center">
                                <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2 btn-hapus-pic" title="Hapus"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>`;
                picContainerEdit.append(rowHtml);
                picIndexEdit = idx + 1;
            });
        } else {
            picContainerEdit.append(`
                <div class="card p-2 bg-light border rounded-3 pic-item-row-edit">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <input type="text" class="form-control ent-input form-control-sm" name="pics[0][nama_pic]" placeholder="Nama PIC..." required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control ent-input form-control-sm" name="pics[0][telepon]" placeholder="No. HP...">
                        </div>
                        <div class="col-md-4">
                            <input type="email" class="form-control ent-input form-control-sm" name="pics[0][email]" placeholder="Email...">
                        </div>
                        <div class="col-md-1 text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2 btn-hapus-pic" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>`);
            picIndexEdit = 1;
        }
    }

    function loadDropdownSumberSubPenjamin(currentSubId) {
        let select = $('#select-sumber-sub-penjamin');
        select.html('<option value="">Memuat data sub penjamin...</option>');

        $.get('/master-data/master-penjamin/get-all-sub', function(response) {
            let options = '<option value="">-- Pilih Sub Penjamin Sumber --</option>';
            if (response.status === 'success' && response.data.length > 0) {
                response.data.forEach(sub => {
                    if (sub.sub_penjamin_id != currentSubId) {
                        options += `<option value="${sub.sub_penjamin_id}">${sub.nama_sub_penjamin} (${sub.nama_penjamin})</option>`;
                    }
                });
            } else {
                options = '<option value="">Tidak ada sub penjamin lain</option>';
            }
            select.html(options);
        }).fail(function() {
            select.html('<option value="">Gagal memuat data</option>');
        });
    }

    $('#btn-proses-salin-tarif').on('click', function() {
        let sumberSubId = $('#select-sumber-sub-penjamin').val();
        let targetSubId = $('#tarif-sub-id').val();

        if (!sumberSubId) {
            Swal.fire('Perhatian', 'Silakan pilih sub penjamin sumber terlebih dahulu.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Salin Data Tarif?',
            text: 'Semua tarif dari sub penjamin terpilih akan disalin ke sub penjamin ini.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Salin Sekarang',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#4f46e5'
        }).then((result) => {
            if (result.isConfirmed) {
                let btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                $.ajax({
                    url: '/master-data/master-penjamin/salin-tarif',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        sumber_sub_id: sumberSubId,
                        target_sub_id: targetSubId
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html('<i class="fas fa-file-import me-1"></i> Salin');
                        if (response.status === 'success') {
                            Swal.fire('Berhasil!', response.message, 'success');
                            loadTableTarif(targetSubId);
                        } else {
                            Swal.fire('Gagal', response.message || 'Gagal menyalin tarif.', 'error');
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html('<i class="fas fa-file-import me-1"></i> Salin');
                        Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
                    }
                });
            }
        });
    });
</script>
@endsection
