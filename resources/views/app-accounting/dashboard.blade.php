@extends('layouts.layouts')

@section('content')
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

    .ent-finance-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 16px;
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.22);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-finance-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 340px;
        height: 340px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-finance-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        transition: transform 0.22s ease, box-shadow 0.22s ease;
    }

    .ent-finance-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 26px -6px rgba(15, 23, 42, 0.14);
    }

    .ent-metric-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.07);
        transition: transform 0.22s ease, box-shadow 0.22s ease;
    }

    .ent-metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 22px -6px rgba(15, 23, 42, 0.14);
    }

    .ent-metric-value {
        font-family: 'JetBrains Mono', monospace;
        letter-spacing: -0.02em;
    }

    .ent-metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 1.15rem;
    }

    .accounting-icon-box {
        width: 54px;
        height: 54px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.14);
        flex-shrink: 0;
    }

    .bg-gradient-indigo {
        background: linear-gradient(135deg, #6366f1, #4338ca);
    }

    .bg-gradient-emerald {
        background: linear-gradient(135deg, #10b981, #047857);
    }

    .bg-gradient-amber {
        background: linear-gradient(135deg, #f59e0b, #b45309);
    }

    .bg-gradient-cyan {
        background: linear-gradient(135deg, #06b6d4, #0e7490);
    }

    .bg-gradient-rose {
        background: linear-gradient(135deg, #f43f5e, #be123c);
    }

    .bg-gradient-violet {
        background: linear-gradient(135deg, #8b5cf6, #6d28d9);
    }

    .ent-pill-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.03em;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .ent-faq-item {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 12px !important;
        overflow: hidden;
        margin-bottom: 8px;
        background-color: var(--bs-body-bg, var(--ent-surface));
    }

    .ent-faq-item:last-child {
        margin-bottom: 0;
    }

    .ent-faq-item .accordion-button {
        font-weight: 700;
        font-size: 0.86rem;
        background-color: var(--bs-body-bg, var(--ent-surface));
        color: var(--bs-body-color, var(--ent-text));
    }

    .ent-faq-item .accordion-button:not(.collapsed) {
        background-color: rgba(79, 70, 229, 0.07);
        color: #4f46e5;
        box-shadow: none;
    }

    .ent-faq-item .accordion-body {
        border-top: 1px solid var(--ent-grid-border);
        background-color: rgba(79, 70, 229, 0.02);
        font-size: 0.82rem;
    }
</style>

<!-- 1. HERO BANNER UTAMA ACCOUNTING -->
<div class="card ent-finance-banner text-white mb-4 overflow-hidden position-relative">
    <div class="card-body p-4 p-lg-5 position-relative" style="z-index: 2;">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <span class="ent-pill-badge mb-3" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                    <i class="fas fa-calculator text-warning"></i> ACCOUNTING &amp; FINANCIAL SYSTEM
                </span>
                <h2 class="fw-bold mb-2" style="letter-spacing: -0.02em;color: white;">Pusat Kendali Keuangan &#128075;</h2>
                <p class="mb-4 small" style="color: #cbd5e1; line-height: 1.65;">
                    Kelola pembukuan, pencatatan jurnal umum, pemantauan arus kas (cashflow), hingga penyusunan laporan keuangan perusahaan secara real-time dan akurat.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#modul-accounting" class="btn btn-light text-dark fw-bold rounded-pill px-4 py-2 shadow-sm small">
                        <i class="fas fa-th-large me-2 text-primary"></i>Modul Akuntansi
                    </a>
                    <a href="#ringkasan-kas" class="btn btn-outline-light fw-semibold rounded-pill px-4 py-2 small">
                        <i class="fas fa-chart-line me-2"></i>Ringkasan Kas
                    </a>
                </div>
            </div>

            <div class="col-lg-5 text-center d-none d-lg-block">
                <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=600&q=80"
                    alt="Accounting & Finance"
                    class="img-fluid rounded-3 shadow-lg border border-2 border-white-50"
                    style="max-height: 220px; object-fit: cover;">
            </div>
        </div>
    </div>
</div>

<!-- 2. METRIK KEUANGAN UTAMA (KEY FINANCIAL METRICS) -->
<div class="row g-3 mb-4" id="ringkasan-kas">
    <!-- Total Kas & Bank -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card ent-metric-card h-100" style="border-left: 4px solid #059669 !important;">
            <div class="card-body d-flex align-items-center justify-content-between p-3 p-md-4">
                <div>
                    <span class="text-uppercase fw-bold d-block mb-1 opacity-75" style="font-size: 0.7rem; letter-spacing: 0.04em;">Total Kas &amp; Bank</span>
                    <h4 class="mb-1 fw-bold text-success ent-metric-value">Rp 485.250.000</h4>
                    <small class="opacity-75" style="font-size: 0.74rem;">
                        <i class="fas fa-arrow-up text-success me-1"></i>+8.5% bulan ini
                    </small>
                </div>
                <div class="ent-metric-icon" style="background: rgba(5, 150, 105, 0.12); color: #059669;">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Piutang Usaha (Accounts Receivable) -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card ent-metric-card h-100" style="border-left: 4px solid #0284c7 !important;">
            <div class="card-body d-flex align-items-center justify-content-between p-3 p-md-4">
                <div>
                    <span class="text-uppercase fw-bold d-block mb-1 opacity-75" style="font-size: 0.7rem; letter-spacing: 0.04em;">Piutang Usaha (AR)</span>
                    <h4 class="mb-1 fw-bold text-info ent-metric-value">Rp 124.800.000</h4>
                    <small class="opacity-75" style="font-size: 0.74rem;">
                        <i class="fas fa-clock text-info me-1"></i>12 Invoice Jatuh Tempo
                    </small>
                </div>
                <div class="ent-metric-icon" style="background: rgba(2, 132, 199, 0.12); color: #0284c7;">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Hutang Usaha (Accounts Payable) -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card ent-metric-card h-100" style="border-left: 4px solid #d97706 !important;">
            <div class="card-body d-flex align-items-center justify-content-between p-3 p-md-4">
                <div>
                    <span class="text-uppercase fw-bold d-block mb-1 opacity-75" style="font-size: 0.7rem; letter-spacing: 0.04em;">Hutang Usaha (AP)</span>
                    <h4 class="mb-1 fw-bold text-warning ent-metric-value">Rp 68.400.000</h4>
                    <small class="opacity-75" style="font-size: 0.74rem;">
                        <i class="fas fa-exclamation-triangle text-warning me-1"></i>5 Tagihan Vendor
                    </small>
                </div>
                <div class="ent-metric-icon" style="background: rgba(217, 119, 6, 0.12); color: #d97706;">
                    <i class="fas fa-receipt"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Laba Bersih (Net Profit YTD) -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card ent-metric-card h-100" style="border-left: 4px solid #4f46e5 !important;">
            <div class="card-body d-flex align-items-center justify-content-between p-3 p-md-4">
                <div>
                    <span class="text-uppercase fw-bold d-block mb-1 opacity-75" style="font-size: 0.7rem; letter-spacing: 0.04em;">Laba Bersih (YTD)</span>
                    <h4 class="mb-1 fw-bold text-primary ent-metric-value">Rp 215.600.000</h4>
                    <small class="opacity-75" style="font-size: 0.74rem;">
                        <i class="fas fa-chart-line text-primary me-1"></i>Periode Berjalan 2026
                    </small>
                </div>
                <div class="ent-metric-icon" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5;">
                    <i class="fas fa-balance-scale"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. MODUL-MODUL AKUNTANSI -->
<div class="d-flex align-items-center justify-content-between mb-3" id="modul-accounting">
    <div>
        <h5 class="mb-0 fw-bold"><i class="fas fa-cubes text-primary me-2"></i>Modul Layanan Akuntansi</h5>
        <small class="opacity-75">Fitur lengkap untuk pengolahan transaksi akuntansi dan pelaporan keuangan.</small>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Modul 1: Jurnal Umum & Transaksi -->
    <div class="col-md-6 col-xl-4">
        <div class="card ent-finance-card h-100 overflow-hidden">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="accounting-icon-box bg-gradient-indigo text-white me-3">
                        <i class="fas fa-book-open fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold">Jurnal &amp; Transaksi</h6>
                        <span class="ent-pill-badge" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5;">General Journal</span>
                    </div>
                </div>
                <p class="small opacity-75 mb-4 flex-grow-1">
                    Catat transaksi debet dan kredit harian, input jurnal penyesuaian (adj. entry), serta kelola bagan akun (Chart of Accounts).
                </p>
                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold py-2">
                    Input Jurnal <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 2: Buku Besar (General Ledger) -->
    <div class="col-md-6 col-xl-4">
        <div class="card ent-finance-card h-100 overflow-hidden">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="accounting-icon-box bg-gradient-cyan text-white me-3">
                        <i class="fas fa-layer-group fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold">Buku Besar</h6>
                        <span class="ent-pill-badge" style="background: rgba(2, 132, 199, 0.12); color: #0284c7;">General Ledger</span>
                    </div>
                </div>
                <p class="small opacity-75 mb-4 flex-grow-1">
                    Pantau pergerakan saldo akhir tiap akun secara rinci, posting otomatis, dan lacak histori transaksi akun spesifik.
                </p>
                <a href="#" class="btn btn-outline-info btn-sm rounded-pill w-100 fw-bold py-2">
                    Buka Buku Besar <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 3: Invoicing & Penjualan (AR) -->
    <div class="col-md-6 col-xl-4">
        <div class="card ent-finance-card h-100 overflow-hidden">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="accounting-icon-box bg-gradient-emerald text-white me-3">
                        <i class="fas fa-file-invoice fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold">Penjualan &amp; Invoicing</h6>
                        <span class="ent-pill-badge" style="background: rgba(5, 150, 105, 0.12); color: #059669;">Accounts Receivable</span>
                    </div>
                </div>
                <p class="small opacity-75 mb-4 flex-grow-1">
                    Buat faktur penagihan pelanggan, pantau status pembayaran invoice, serta kelola penerimaan piutang secara otomatis.
                </p>
                <a href="#" class="btn btn-outline-success btn-sm rounded-pill w-100 fw-bold py-2">
                    Kelola Invoice <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 4: Tagihan Vendor & Pembelian (AP) -->
    <div class="col-md-6 col-xl-4">
        <div class="card ent-finance-card h-100 overflow-hidden">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="accounting-icon-box bg-gradient-amber text-white me-3">
                        <i class="fas fa-shopping-cart fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold">Pembelian &amp; Tagihan</h6>
                        <span class="ent-pill-badge" style="background: rgba(217, 119, 6, 0.12); color: #d97706;">Accounts Payable</span>
                    </div>
                </div>
                <p class="small opacity-75 mb-4 flex-grow-1">
                    Pencatatan tagihan supplier/vendor, jadwal pembayaran hutang, serta rekapitulasi pengeluaran operasional.
                </p>
                <a href="#" class="btn btn-outline-warning btn-sm rounded-pill w-100 fw-bold py-2">
                    Kelola Tagihan <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 5: Laporan Keuangan Lengkap -->
    <div class="col-md-6 col-xl-4">
        <div class="card ent-finance-card h-100 overflow-hidden">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="accounting-icon-box bg-gradient-violet text-white me-3">
                        <i class="fas fa-chart-pie fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold">Laporan Keuangan</h6>
                        <span class="ent-pill-badge" style="background: rgba(139, 92, 246, 0.14); color: #7c3aed;">Financial Reports</span>
                    </div>
                </div>
                <p class="small opacity-75 mb-4 flex-grow-1">
                    Cetak Laporan Laba Rugi (Income Statement), Neraca (Balance Sheet), Arus Kas (Cashflow), dan Perubahan Modal.
                </p>
                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold py-2">
                    Generate Laporan <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 6: Aset Tetap & Perpajakan -->
    <div class="col-md-6 col-xl-4">
        <div class="card ent-finance-card h-100 overflow-hidden">
            <div class="card-body p-4 d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                    <div class="accounting-icon-box bg-gradient-rose text-white me-3">
                        <i class="fas fa-coins fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold">Aset &amp; Perpajakan</h6>
                        <span class="ent-pill-badge" style="background: rgba(225, 29, 72, 0.12); color: #e11d48;">Fixed Assets &amp; Tax</span>
                    </div>
                </div>
                <p class="small opacity-75 mb-4 flex-grow-1">
                    Hitung penyusutan aset otomatis (depresiasi), kelola rekap PPN &amp; PPh, serta pelaporan pajak secara sistematis.
                </p>
                <a href="#" class="btn btn-outline-danger btn-sm rounded-pill w-100 fw-bold py-2">
                    Kelola Aset &amp; Pajak <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 4. BANNER AUDIT & KEPATUHAN -->
<div class="card ent-finance-card mb-4 overflow-hidden">
    <div class="row g-0">
        <div class="col-md-5">
            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80"
                alt="Financial Audit"
                class="img-fluid h-100 w-100"
                style="object-fit: cover; min-height: 210px;">
        </div>
        <div class="col-md-7 d-flex align-items-center">
            <div class="card-body p-4">
                <span class="ent-pill-badge mb-2" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5;">
                    <i class="fas fa-shield-alt"></i> Pemeriksaan &amp; Audit
                </span>
                <h5 class="fw-bold mb-2">Integritas Data Keuangan Terjamin</h5>
                <p class="small opacity-75 mb-3">
                    Sistem akuntansi terintegrasi dengan audit trail otomatis yang merekam seluruh riwayat pembuatan, perubahan, dan persetujuan jurnal transaksi untuk transparansi penuh.
                </p>
                <a href="#" class="btn btn-dark btn-sm rounded-pill px-4 fw-semibold">Lihat Audit Log</a>
            </div>
        </div>
    </div>
</div>

<!-- 5. ACCORDION FAQ ACCOUNTING -->
<div class="card ent-finance-card mb-3">
    <div class="card-header bg-transparent border-bottom p-3 p-md-4" style="border-color: var(--ent-grid-border) !important;">
        <div class="d-flex align-items-center gap-3">
            <div class="ent-metric-icon" style="width: 40px; height: 40px; background: rgba(79, 70, 229, 0.12); color: #4f46e5; font-size: 1rem;">
                <i class="fas fa-question-circle"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold">Pertanyaan Sering Diajukan (FAQ Akuntansi)</h6>
                <small class="opacity-75">Panduan singkat operasional tutup buku, rekonsiliasi, dan koreksi jurnal.</small>
            </div>
        </div>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="accordion accordion-flush" id="accordionAccountingFAQ">
            <div class="accordion-item ent-faq-item">
                <h2 class="accordion-header" id="faqAcc1">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAcc1">
                        <i class="fas fa-exchange-alt me-2 text-primary"></i> Bagaimana cara melakukan tutup buku bulanan (Monthly Closing)?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseAcc1" data-bs-parent="#accordionAccountingFAQ">
                    <div class="accordion-body opacity-85">
                        Proses tutup buku dilakukan melalui modul <strong>Laporan Keuangan</strong> dengan memastikan seluruh jurnal penyesuaian, rekonsiliasi bank, dan penyusunan depresiasi aset periode tersebut telah selesai diposting.
                    </div>
                </div>
            </div>

            <div class="accordion-item ent-faq-item">
                <h2 class="accordion-header" id="faqAcc2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAcc2">
                        <i class="fas fa-university me-2 text-success"></i> Apakah sistem mendukung Rekonsiliasi Bank otomatis?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseAcc2" data-bs-parent="#accordionAccountingFAQ">
                    <div class="accordion-body opacity-85">
                        Ya, Anda dapat mengunggah mutasi rekening bank (format CSV/Excel) pada modul <strong>Buku Besar / Kas &amp; Bank</strong> untuk dicocokkan otomatis dengan catatan pencatatan internal.
                    </div>
                </div>
            </div>

            <div class="accordion-item ent-faq-item">
                <h2 class="accordion-header" id="faqAcc3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAcc3">
                        <i class="fas fa-cogs me-2 text-danger"></i> Bagaimana jika terdapat kesalahan pada jurnal yang telah diposting?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseAcc3" data-bs-parent="#accordionAccountingFAQ">
                    <div class="accordion-body opacity-85">
                        Jurnal yang sudah diposting tidak dapat dihapus langsung untuk menjaga validitas audit. Anda harus membuat <strong>Jurnal Pembalik (Reversing Entry)</strong> atau Jurnal Koreksi melalui persetujuan Supervisor Accounting.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
