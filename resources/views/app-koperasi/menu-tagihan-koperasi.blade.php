@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.4/css/buttons.dataTables.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (PENAGIHAN KOPERASI)
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

    /* Adaptive Enterprise Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-table-surface {
        background-color: var(--ent-surface);
        color: var(--ent-text);
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
        font-size: 0.8rem;
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
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    .ent-btn-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .ent-btn-success:hover:not(:disabled) {
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        color: #ffffff;
    }

    /* Form Controls */
    .ent-form-label {
        font-size: 0.68rem;
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

    .ent-form .form-control,
    .ent-form .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--ent-text) !important;
        background-color: var(--ent-surface) !important;
        font-size: 0.82rem !important;
        padding: 8px 12px !important;
        transition: all 0.2s ease;
        height: 40px !important;
    }

    .ent-form .form-control:focus,
    .ent-form .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .ent-form .form-control[readonly] {
        background-color: rgba(79, 70, 229, 0.06) !important;
    }

    /* Select2 Custom Enterprise Integration */
    .select2-container--bootstrap-5 {
        width: 100% !important;
    }

    .ent-form .select2-container--bootstrap-5 .select2-selection--single {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--ent-text) !important;
        background-color: var(--ent-surface) !important;
        padding: 6px 34px 6px 12px !important;
        font-size: 0.82rem !important;
        height: 40px !important;
        min-height: 40px !important;
        display: flex !important;
        align-items: center !important;
        box-shadow: none !important;
        transition: all 0.2s ease;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection--single,
    .select2-container--bootstrap-5.select2-container--open .select2-selection--single {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        padding: 0 !important;
        line-height: 1.25 !important;
        color: var(--ent-text) !important;
        font-weight: 600 !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        background-color: var(--ent-surface) !important;
        color: var(--ent-text) !important;
        box-shadow: 0 12px 24px -6px rgba(15, 23, 42, 0.18) !important;
        overflow: hidden;
        z-index: 1075;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px !important;
        background-color: var(--ent-surface) !important;
        color: var(--ent-text) !important;
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        padding: 6px 10px !important;
    }

    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field:focus {
        border-color: var(--ent-indigo) !important;
        outline: none;
        box-shadow: 0 0 0 2.5px rgba(79, 70, 229, 0.15) !important;
    }

    .select2-container--bootstrap-5 .select2-results__option {
        font-size: 0.8rem !important;
        font-weight: 600 !important;
        padding: 8px 12px !important;
        color: var(--ent-text) !important;
    }

    .select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected] {
        background-color: var(--ent-indigo) !important;
        color: #ffffff !important;
    }

    .select2-container--bootstrap-5 .select2-results__option[aria-selected="true"] {
        background-color: rgba(79, 70, 229, 0.14) !important;
        color: var(--ent-indigo) !important;
    }

    /* Navigation Pills */
    .ent-nav-pills {
        background-color: var(--ent-surface);
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        padding: 8px;
        box-shadow: 0 4px 14px -2px rgba(15, 23, 42, 0.05);
    }

    .nav-pills .nav-link {
        border-radius: 10px;
        color: var(--ent-text);
        opacity: 0.78;
        font-weight: 700;
        font-size: 0.78rem;
        padding: 9px 16px;
        transition: all 0.18s ease;
    }

    .nav-pills .nav-link:hover {
        opacity: 1;
        background-color: rgba(79, 70, 229, 0.08);
    }

    #tab-voucher .nav-link.active {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #ffffff;
        opacity: 1;
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.28);
    }

    #tab-peminjaman-uang .nav-link.active {
        background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
        color: #ffffff;
        opacity: 1;
        box-shadow: 0 4px 12px rgba(225, 29, 72, 0.28);
    }

    #tab-peminjaman-barang .nav-link.active {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        color: #ffffff;
        opacity: 1;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.28);
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

    .badge-status-paid {
        background-color: rgba(16, 185, 129, 0.16) !important;
        color: #10b981 !important;
        border: 1px solid rgba(16, 185, 129, 0.38);
    }

    .badge-status-unpaid {
        background-color: rgba(245, 158, 11, 0.16) !important;
        color: #d97706 !important;
        border: 1px solid rgba(245, 158, 11, 0.38);
    }

    .badge-meta-pill {
        background-color: rgba(79, 70, 229, 0.08) !important;
        color: var(--ent-text) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 8px;
        padding: 3px 8px;
        font-size: 0.72rem;
        font-weight: 600;
    }

    /* =========================================================
       TABLE WITH COLORED GRID BORDERS
       ========================================================= */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: var(--ent-text) !important;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        padding: 12px;
        letter-spacing: 0.04em;
    }

    .table-custom thead th:first-child {
        border-left: none !important;
    }

    .table-custom thead th:last-child {
        border-right: none !important;
        padding-right: 16px !important;
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-custom tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.06) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--ent-text) !important;
        padding: 10px 12px;
        vertical-align: middle;
        font-size: 0.82rem;
    }

    .table-custom tbody td:first-child {
        border-left: none !important;
    }

    .table-custom tbody td:last-child {
        border-right: none !important;
        padding-right: 16px !important;
    }

    .table-responsive {
        border-radius: 0 0 16px 16px;
        overflow-x: auto;
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
                    <div class="col-lg-9 d-flex align-items-center">
                        <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-file-invoice-dollar fa-2x text-info"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                    <i class="fas fa-coins me-1"></i> {{ Env('APP_LABEL', 'KOPERASI') }} BILLING
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Rekapitulasi Tagihan</span>
                            </div>
                            <h4 class="mb-0 fw-bold" style="letter-spacing: -0.02em;color: white;">Daftar Penagihan Koperasi</h4>
                            <p class="mb-0 small" style="color: #cbd5e1;">Pantau dan saring tagihan anggota per cabang, rentang tanggal, serta kategori transaksi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PARAMETER FILTER PENCARIAN -->
<div class="ent-card ent-table-surface p-3 p-md-4 mb-3">
    <h6 class="fw-bold mb-3"><i class="fas fa-sliders me-2 text-primary"></i>Parameter Filter Pencarian</h6>
    <form id="filterForm" class="row g-3 align-items-end ent-form">
        <div class="col-md-3">
            <label class="form-label ent-form-label">Cabang Koperasi</label>
            <select class="form-select select2-penagihan-kop" id="cabang_id" name="cabang_id">
                <option value="semua">Semua Cabang</option>
                @foreach($list_cabang as $cabang)
                <option value="{{ $cabang->kop_master_cabang_code }}">[ {{$cabang->kop_master_cabang_code}} ] {{ $cabang->kop_master_cabang_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label ent-form-label">Tanggal Mulai</label>
            <input type="date" class="form-control" id="start_date" name="start_date" style="font-family: 'JetBrains Mono', monospace;">
        </div>
        <div class="col-md-3">
            <label class="form-label ent-form-label">Tanggal Selesai</label>
            <input type="date" class="form-control" id="end_date" name="end_date" style="font-family: 'JetBrains Mono', monospace;">
        </div>
        <div class="col-md-3 d-grid">
            <button type="button" onclick="loadDataTagihan()" class="btn ent-btn ent-btn-primary py-2">
                <i class="fas fa-search me-2"></i> Cari Data
            </button>
        </div>
    </form>
</div>

<!-- TAB KATEGORI PENAGIHAN -->
<ul class="nav nav-pills gap-2 mb-3 ent-nav-pills" id="pills-tab" role="tablist">
    <li class="nav-item" id="tab-voucher"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-voucher" type="button" role="tab">Voucher Layanan</button></li>
    <li class="nav-item" id="tab-peminjaman-uang"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-peminjaman-uang" type="button" role="tab">Peminjaman Uang</button></li>
    <li class="nav-item" id="tab-peminjaman-barang"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-peminjaman-barang" type="button" role="tab">Pembelian Barang</button></li>
</ul>

<!-- KONTEN TABEL PENAGIHAN -->
<div class="tab-content ent-card ent-table-surface" id="pills-tabContent">
    @foreach([
    'voucher' => ['id' => 'pills-voucher', 'class' => 'show active', 'text' => 'Tagihan Voucher Layanan Anggota', 'color' => 'warning'],
    'peminjaman_uang' => ['id' => 'pills-peminjaman-uang', 'class' => '', 'text' => 'Angsuran Peminjaman Uang Anggota', 'color' => 'danger'],
    'peminjaman_barang' => ['id' => 'pills-peminjaman-barang', 'class' => '', 'text' => 'Angsuran Pembelian Barang Anggota', 'color' => 'primary'],
    ] as $key => $meta)
    <div class="tab-pane fade {{ $meta['class'] }}" id="{{ $meta['id'] }}" role="tabpanel">
        <div class="p-3 d-flex justify-content-between align-items-center flex-wrap gap-2" style="background-color: rgba(79, 70, 229, 0.06); border-bottom: 1px solid var(--ent-grid-border);">
            <span class="fw-bold small text-uppercase"><i class="fas fa-folder-open me-2 text-primary"></i>{{ $meta['text'] }}</span>
            <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.35); font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;" id="total-{{ $key }}">Total: Rp 0</span>
        </div>
        <div class="table-responsive">
            <table class="table table-custom align-middle mb-0 w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Tagihan</th>
                        <th>Nama Cabang</th>
                        <th>Tanggal</th>
                        <th>ID Peserta</th>
                        <th>Nama Peserta</th>
                        <th>Status</th>
                        <th class="text-end">Nominal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="data-{{ $key }}">
                    <tr>
                        <td colspan="9" class="text-center py-4 opacity-75">Silakan tentukan filter lalu klik Cari Data.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</div>

<!-- MODAL FORM PELUNASAN TAGIHAN -->
<div class="modal fade" id="modalPelunasanTagihan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ent-table-surface" style="border: 1px solid var(--ent-grid-border); border-radius: 16px; overflow: hidden;">
            <div class="modal-header text-white py-3 px-4" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                <h6 class="modal-title fw-bold mb-0">
                    <i class="fas fa-money-check-dollar me-2"></i>Form Pelunasan Tagihan
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formPelunasanTagihan" class="ent-form">
                @csrf
                <div class="modal-body p-4">
                    <input type="hidden" id="lunas_id" name="id_transaksi">
                    <input type="hidden" id="lunas_kategori" name="kategori">
                    <input type="hidden" id="lunas_kode_lama" name="kode_transaksi">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label ent-form-label">No. Tagihan</label>
                            <input type="text" class="form-control fw-bold text-primary" id="lunas_no_tagihan" style="font-family: 'JetBrains Mono', monospace;" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label ent-form-label">Tanggal Bayar <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="lunas_tanggal_bayar" name="tanggal_bayar" value="{{ date('Y-m-d') }}" style="font-family: 'JetBrains Mono', monospace;" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label ent-form-label">Peserta / Anggota</label>
                            <input type="text" class="form-control" id="lunas_peserta" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label ent-form-label">Total Tagihan (Rp)</label>
                            <input type="text" class="form-control fw-bold text-danger" id="lunas_total_tagihan" style="font-family: 'JetBrains Mono', monospace;" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label ent-form-label">Nominal Pelunasan (Rp) <span class="text-danger">*</span></label>
                            <input type="text" inputmode="decimal" class="form-control fw-bold text-success" id="lunas_nominal_bayar" name="nominal_bayar" style="font-family: 'JetBrains Mono', monospace;" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label ent-form-label">Akun Kas / Bank Penerima (Debit) <span class="text-danger">*</span></label>
                            <select class="form-select select2-penagihan-kop-modal" id="lunas_coa_kas" name="coa_kas" required>
                                <option value="" selected>-- Pilih COA Kas / Bank --</option>
                                @foreach(($list_coa ?? collect()) as $coa)
                                <option value="{{ $coa->coa_code }}">
                                    {{ $coa->coa_code }} - {{ $coa->coa_name }} ({{ strtoupper($coa->coa_type) }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label ent-form-label">Catatan Pelunasan</label>
                            <input type="text" class="form-control" id="lunas_keterangan" name="keterangan" placeholder="Contoh: Pelunasan tagihan anggota...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="background-color: rgba(79, 70, 229, 0.04); border-top: 1px solid var(--ent-grid-border);">
                    <button type="button" class="btn ent-btn btn-secondary px-3 py-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-success px-4 py-2">
                        <i class="fas fa-check-circle me-1"></i> Proses Pelunasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/dataTables.buttons.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/buttons.print.min.js"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let modalPelunasanTagihanInstance = null;
    let cachedTagihanResponse = {};

    function runWhenSelect2Ready(callback) {
        if (window.jQuery && $.fn.select2) {
            callback();
            return;
        }
        const loadSelect2 = () => {
            const s = document.createElement('script');
            s.src = 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js';
            s.onload = callback;
            document.head.appendChild(s);
        };
        if (!window.jQuery) {
            const jq = document.createElement('script');
            jq.src = 'https://code.jquery.com/jquery-3.7.1.min.js';
            jq.onload = loadSelect2;
            document.head.appendChild(jq);
        } else {
            loadSelect2();
        }
    }

    function initSelect2PenagihanKop() {
        if (!(window.jQuery && $.fn.select2)) return;

        $('.select2-penagihan-kop').each(function() {
            const $el = $(this);
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.select2('destroy');
            }
            $el.select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Semua Cabang',
                allowClear: false,
                language: {
                    noResults: function() {
                        return 'Data tidak ditemukan';
                    },
                    searching: function() {
                        return 'Mencari...';
                    }
                }
            });
        });

        $('.select2-penagihan-kop-modal').each(function() {
            const $el = $(this);
            const placeholderText = $el.find('option:first').text() || '-- Pilih COA Kas / Bank --';
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.select2('destroy');
            }
            $el.select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: placeholderText,
                allowClear: true,
                dropdownParent: $('#modalPelunasanTagihan'),
                language: {
                    noResults: function() {
                        return 'Data tidak ditemukan';
                    },
                    searching: function() {
                        return 'Mencari...';
                    }
                }
            });
        });
    }

    function formatSeparatorRupiah(val) {
        const clean = String(val ?? '').replace(/[^\d]/g, '').replace(/^0+(?=\d)/, '');
        if (!clean) return '0';
        return Number(clean).toLocaleString('id-ID');
    }

    function parseSeparatorRupiah(val) {
        const clean = String(val ?? '').replace(/[^\d]/g, '');
        return clean ? parseInt(clean, 10) : 0;
    }

    // Fungsi AJAX Fetch API untuk mengambil data dari Route ke-2 tanpa reload halaman
    function loadDataTagihan() {
        const cabang = document.getElementById('cabang_id').value;
        const start = document.getElementById('start_date').value;
        const end = document.getElementById('end_date').value;

        // Berikan indikator loading pada tabel kategori aktif
        const categories = ['voucher', 'peminjaman_uang', 'peminjaman_barang'];
        categories.forEach(key => {
            document.getElementById(`data-${key}`).innerHTML = `<tr><td colspan="9" class="text-center py-4 text-primary"><div class="spinner-border spinner-border-sm me-2"></div>Memuat data...</td></tr>`;
        });

        // Tembak URL Route ke-2 dengan query string parameter
        fetch(`{{ route('menu_koperasi_tagihan_koperasi_load') }}?cabang_id=${encodeURIComponent(cabang)}&start_date=${encodeURIComponent(start)}&end_date=${encodeURIComponent(end)}`)
            .then(response => response.json())
            .then(res => {
                cachedTagihanResponse = res;

                categories.forEach(key => {
                    const catData = res[key] || { total: 0, data: [] };

                    // 1. Update Badge Total Uang Nominal
                    document.getElementById(`total-${key}`).innerText = 'Total: ' + formatRupiah(catData.total || 0);

                    // 2. Render isi baris tabel body
                    let htmlRows = '';
                    if (!catData.data || catData.data.length === 0) {
                        htmlRows = `<tr><td colspan="9" class="text-center py-4 opacity-75">Tidak ditemukan data penagihan.</td></tr>`;
                    } else {
                        catData.data.forEach((item, index) => {
                            let namaCabang = item.peserta && item.peserta.cabang ? item.peserta.cabang.kop_master_cabang_name : (item.peserta ? item.peserta.kop_master_peserta_cabang : 'N/A');
                            let idPeserta = item.peserta ? item.peserta.kop_master_peserta_code : item.kop_req_tagihan_id;
                            let namaPeserta = item.peserta ? item.peserta.kop_master_peserta_name : 'Data Peserta Hilang';
                            let isPaid = String(item.kop_req_tagihan_status || '').toLowerCase() === 'paid';
                            let badgeStatus = isPaid ? 'badge-status-paid' : 'badge-status-unpaid';
                            let labelStatus = isPaid ? 'LUNAS' : String(item.kop_req_tagihan_status || 'UNPAID').toUpperCase();

                            let aksiHtml = isPaid
                                ? `<span class="ent-badge badge-status-paid"><i class="fas fa-check me-1"></i> Lunas</span>`
                                : `<button type="button" class="btn btn-sm ent-btn ent-btn-success py-1 px-2" onclick="openModalPelunasan('${key}', ${index})"><i class="fas fa-money-check-dollar me-1"></i> Lunasi</button>`;

                            htmlRows += `
                                <tr>
                                    <td class="fw-bold" style="font-family: 'JetBrains Mono', monospace;">${index + 1}</td>
                                    <td><span class="text-primary fw-bold" style="font-family: 'JetBrains Mono', monospace;">${item.kop_req_tagihan_code}</span></td>
                                    <td><span class="badge badge-meta-pill">${namaCabang}</span></td>
                                    <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">${formatTanggal(item.kop_req_tagihan_date)}</td>
                                    <td><span class="badge badge-meta-pill" style="font-family: 'JetBrains Mono', monospace;">${idPeserta}</span></td>
                                    <td class="fw-semibold">${namaPeserta}</td>
                                    <td><span class="ent-badge ${badgeStatus}">${labelStatus}</span></td>
                                    <td class="text-end fw-bold" style="font-family: 'JetBrains Mono', monospace;">${formatRupiah(item.kop_req_tagihan_nominal)}</td>
                                    <td class="text-center">${aksiHtml}</td>
                                </tr>`;
                        });
                    }
                    document.getElementById(`data-${key}`).innerHTML = htmlRows;
                });
            })
            .catch(error => {
                console.error("Gagal memuat data:", error);
                Swal.fire('Gagal Memuat', 'Terjadi kesalahan sistem saat memuat data penagihan.', 'error');
            });
    }

    function openModalPelunasan(kategori, index) {
        const catList = cachedTagihanResponse[kategori]?.data || [];
        const item = catList[index];
        if (!item) return;

        const pesertaLabel = item.peserta
            ? `${item.peserta.kop_master_peserta_code} - ${item.peserta.kop_master_peserta_name}`
            : (item.kop_req_tagihan_id || '-');
        const nominalAngka = parseInt(parseFloat(item.kop_req_tagihan_nominal || 0), 10);

        document.getElementById('lunas_id').value = item.id ?? '';
        document.getElementById('lunas_kategori').value = kategori;
        document.getElementById('lunas_kode_lama').value = item.kop_req_tagihan_code;
        document.getElementById('lunas_no_tagihan').value = item.kop_req_tagihan_code;
        document.getElementById('lunas_tanggal_bayar').value = '{{ date("Y-m-d") }}';
        document.getElementById('lunas_peserta').value = pesertaLabel;
        document.getElementById('lunas_total_tagihan').value = formatRupiah(nominalAngka);
        document.getElementById('lunas_nominal_bayar').value = formatSeparatorRupiah(nominalAngka);
        document.getElementById('lunas_keterangan').value = `Pelunasan tagihan ${item.kop_req_tagihan_code} (${pesertaLabel})`;

        if (window.jQuery && $.fn.select2) {
            $('#lunas_coa_kas').val('').trigger('change.select2');
        } else {
            document.getElementById('lunas_coa_kas').value = '';
        }

        if (!modalPelunasanTagihanInstance) {
            modalPelunasanTagihanInstance = new bootstrap.Modal(document.getElementById('modalPelunasanTagihan'));
        }
        modalPelunasanTagihanInstance.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        runWhenSelect2Ready(function() {
            initSelect2PenagihanKop();
        });

        const inputBayar = document.getElementById('lunas_nominal_bayar');
        if (inputBayar) {
            inputBayar.addEventListener('input', function() {
                this.value = formatSeparatorRupiah(this.value);
            });
        }

        const formPelunasan = document.getElementById('formPelunasanTagihan');
        if (formPelunasan) {
            formPelunasan.addEventListener('submit', function(e) {
                e.preventDefault();

                const payload = {
                    id_transaksi: document.getElementById('lunas_id').value,
                    kategori: document.getElementById('lunas_kategori').value,
                    kode_transaksi: document.getElementById('lunas_kode_lama').value,
                    tanggal_bayar: document.getElementById('lunas_tanggal_bayar').value,
                    nominal_bayar: parseSeparatorRupiah(document.getElementById('lunas_nominal_bayar').value),
                    coa_kas: document.getElementById('lunas_coa_kas').value,
                    keterangan: document.getElementById('lunas_keterangan').value
                };

                if (!payload.coa_kas || payload.nominal_bayar <= 0) {
                    Swal.fire('Form Belum Lengkap', 'Pilih COA Kas/Bank dan pastikan nominal pelunasan lebih dari 0.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi Pelunasan?',
                    text: `Tagihan ${payload.kode_transaksi} sebesar Rp ${formatSeparatorRupiah(payload.nominal_bayar)} akan dilunasi dan dijurnal.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#059669',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Lunasi Sekarang',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    Swal.fire({
                        title: 'Memproses Pelunasan...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    fetch(`{{ route('menu_koperasi_tagihan_koperasi_pelunasan') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(async res => {
                        const data = await res.json();
                        if (!res.ok) throw new Error(data.message || 'Gagal memproses pelunasan.');
                        return data;
                    })
                    .then(res => {
                        Swal.fire('Berhasil!', res.message || 'Tagihan berhasil dilunasi.', 'success').then(() => {
                            if (modalPelunasanTagihanInstance) {
                                modalPelunasanTagihanInstance.hide();
                            }
                            loadDataTagihan();
                        });
                    })
                    .catch(err => {
                        Swal.fire('Gagal', err.message || 'Terjadi kesalahan saat memproses pelunasan.', 'error');
                    });
                });
            });
        }
    });

    // Fungsi Pembantu: Format Angka ke Rupiah Akuntansi
    function formatRupiah(angka) {
        return 'Rp ' + parseFloat(angka || 0).toLocaleString('id-ID', {
            minimumFractionDigits: 0
        });
    }

    // Fungsi Pembantu: Format Tanggal YYYY-MM-DD ke DD MMM YYYY
    function formatTanggal(stringTanggal) {
        const opsi = {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        };
        return new Date(stringTanggal).toLocaleDateString('id-ID', opsi);
    }
</script>
@endsection
