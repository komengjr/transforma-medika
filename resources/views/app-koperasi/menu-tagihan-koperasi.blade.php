@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.4/css/buttons.dataTables.css">
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

    #tab-bulanan .nav-link.active {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        color: #ffffff;
        opacity: 1;
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.28);
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

    #tab-lain .nav-link.active {
        background: linear-gradient(135deg, #475569 0%, #334155 100%);
        color: #ffffff;
        opacity: 1;
        box-shadow: 0 4px 12px rgba(71, 85, 105, 0.28);
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
                            <h4 class="mb-0 fw-bold text-white" style="letter-spacing: -0.02em;">Daftar Penagihan Koperasi</h4>
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
            <select class="form-select" id="cabang_id" name="cabang_id">
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
    <li class="nav-item" id="tab-bulanan"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-bulanan" type="button" role="tab">Bulanan</button></li>
    <li class="nav-item" id="tab-voucher"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-voucher" type="button" role="tab">Voucher</button></li>
    <li class="nav-item" id="tab-peminjaman-uang"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-peminjaman-uang" type="button" role="tab">Peminjaman Uang</button></li>
    <li class="nav-item" id="tab-peminjaman-barang"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-peminjaman-barang" type="button" role="tab">Peminjaman Barang</button></li>
    <li class="nav-item" id="tab-lain"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-lain" type="button" role="tab">Lain-Lain</button></li>
</ul>

<!-- KONTEN TABEL PENAGIHAN -->
<div class="tab-content ent-card ent-table-surface" id="pills-tabContent">
    @foreach([
    'bulanan' => ['id' => 'pills-bulanan', 'class' => 'show active', 'text' => 'Simpanan Wajib & Pokok', 'color' => 'info'],
    'voucher' => ['id' => 'pills-voucher', 'class' => '', 'text' => 'Belanja Toko / Kantin', 'color' => 'warning'],
    'peminjaman_uang' => ['id' => 'pills-peminjaman-uang', 'class' => '', 'text' => 'Angsuran & Pinjaman', 'color' => 'danger'],
    'peminjaman_barang' => ['id' => 'pills-peminjaman-barang', 'class' => '', 'text' => 'Angsuran & Pinjaman', 'color' => 'primary'],
    'lain' => ['id' => 'pills-lain', 'class' => '', 'text' => 'Biaya Administrasi & Sanksi', 'color' => 'secondary']
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
                    </tr>
                </thead>
                <tbody id="data-{{ $key }}">
                    <tr>
                        <td colspan="8" class="text-center py-4 opacity-75">Silakan tentukan filter lalu klik Cari Data.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
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
    // Fungsi AJAX Fetch API untuk mengambil data dari Route ke-2 tanpa reload halaman
    function loadDataTagihan() {
        const cabang = document.getElementById('cabang_id').value;
        const start = document.getElementById('start_date').value;
        const end = document.getElementById('end_date').value;

        // Berikan indikator loading pada semua tabel
        const categories = ['bulanan', 'voucher', 'peminjaman_uang', 'peminjaman_barang', 'lain'];
        categories.forEach(key => {
            document.getElementById(`data-${key}`).innerHTML = `<tr><td colspan="8" class="text-center py-4 text-primary"><div class="spinner-border spinner-border-sm me-2"></div>Memuat data...</td></tr>`;
        });

        // Tembak URL Route ke-2 dengan query string parameter
        fetch(`{{ route('menu_koperasi_tagihan_koperasi_load') }}?cabang_id=${cabang}&start_date=${start}&end_date=${end}`)
            .then(response => response.json())
            .then(res => {
                categories.forEach(key => {
                    // 1. Update Badge Total Uang Nominal
                    document.getElementById(`total-${key}`).innerText = 'Total: ' + formatRupiah(res[key].total);

                    // 2. Render isi baris tabel body
                    let htmlRows = '';
                    if (res[key].data.length === 0) {
                        htmlRows = `<tr><td colspan="8" class="text-center py-4 opacity-75">Tidak ditemukan data penagihan.</td></tr>`;
                    } else {
                        res[key].data.forEach((item, index) => {
                            let namaCabang = item.peserta && item.peserta.cabang ? item.peserta.cabang.kop_master_cabang_name : (item.peserta ? item.peserta.kop_master_peserta_cabang : 'N/A');
                            let idPeserta = item.peserta ? item.peserta.kop_master_peserta_code : item.kop_req_tagihan_id;
                            let namaPeserta = item.peserta ? item.peserta.kop_master_peserta_name : 'Data Peserta Hilang';
                            let badgeStatus = item.kop_req_tagihan_status === 'paid' ? 'badge-status-paid' : 'badge-status-unpaid';

                            htmlRows += `
                                <tr>
                                    <td class="fw-bold" style="font-family: 'JetBrains Mono', monospace;">${index + 1}</td>
                                    <td><span class="text-primary fw-bold" style="font-family: 'JetBrains Mono', monospace;">${item.kop_req_tagihan_code}</span></td>
                                    <td><span class="badge badge-meta-pill">${namaCabang}</span></td>
                                    <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.78rem;">${formatTanggal(item.kop_req_tagihan_date)}</td>
                                    <td><span class="badge badge-meta-pill" style="font-family: 'JetBrains Mono', monospace;">${idPeserta}</span></td>
                                    <td class="fw-semibold">${namaPeserta}</td>
                                    <td><span class="ent-badge ${badgeStatus}">${item.kop_req_tagihan_status.toUpperCase()}</span></td>
                                    <td class="text-end fw-bold" style="font-family: 'JetBrains Mono', monospace;">${formatRupiah(item.kop_req_tagihan_nominal)}</td>
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

    // Fungsi Pembantu: Format Angka ke Rupiah Akuntansi
    function formatRupiah(angka) {
        return 'Rp ' + parseFloat(angka).toLocaleString('id-ID', {
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
