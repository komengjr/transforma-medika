@extends('layouts.layouts')

@section('content')
<style>
    /* Styling khusus Sistem Akuntansi */
    .accounting-hero-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
        border: none;
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.2);
    }

    .hover-lift {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12) !important;
    }

    /* Modul Icon Styling */
    .accounting-icon-box {
        width: 58px;
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
    }

    .bg-gradient-indigo {
        background: linear-gradient(45deg, #6366f1, #4338ca);
    }

    .bg-gradient-emerald {
        background: linear-gradient(45deg, #10b981, #047857);
    }

    .bg-gradient-amber {
        background: linear-gradient(45deg, #f59e0b, #b45309);
    }

    .bg-gradient-cyan {
        background: linear-gradient(45deg, #06b6d4, #0e7490);
    }

    .bg-gradient-rose {
        background: linear-gradient(45deg, #f43f5e, #be123c);
    }

    .bg-gradient-violet {
        background: linear-gradient(45deg, #8b5cf6, #6d28d9);
    }
</style>

<!-- 1. HERO BANNER UTAMA ACCOUNTING -->
<div class="card accounting-hero-banner text-white mb-4 overflow-hidden position-relative">
    <div class="card-body p-4 p-lg-5 position-relative z-index-1">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge bg-soft-light text-warning mb-3 px-3 py-2 rounded-pill fs--1">
                    <i class="fas fa-calculator me-1 text-warning"></i> Accounting & Financial System
                </span>
                <h2 class="text-white fw-bold display-6 mb-2">Pusat Kendali Keuangan 👋</h2>
                <p class="lead opacity-85 mb-4 fs-0">
                    Kelola pembukuan, pencatatan jurnal umum, pemantauan arus kas (cashflow), hingga penyusunan laporan keuangan perusahaan secara real-time dan akurat.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#modul-accounting" class="btn btn-light text-dark fw-bold rounded-pill px-4 shadow-sm">
                        <i class="fas fa-th-large me-2"></i>Modul Akuntansi
                    </a>
                    <a href="#ringkasan-kas" class="btn btn-outline-light rounded-pill px-4">
                        <i class="fas fa-chart-line me-2"></i>Ringkasan Kas
                    </a>
                </div>
            </div>
            <!-- Ilustrasi Keuangan & Analisis Data -->
            <div class="col-lg-5 text-center d-none d-lg-block">
                <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=600&q=80"
                    alt="Accounting & Finance"
                    class="img-fluid rounded-3 shadow-lg border border-3 border-white position-relative"
                    style="max-height: 230px; object-fit: cover; transform: rotate(-1deg);">
            </div>
        </div>
    </div>
</div>

<!-- 2. METRIK KEUANGAN UTAMA (KEY FINANCIAL METRICS) -->
<div class="row g-3 mb-4" id="ringkasan-kas">
    <!-- Total Kas & Bank -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-success border-start border-4 border-success h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Total Kas & Bank</h6>
                    <h3 class="mb-0 text-success fw-bold">Rp 485.250.000</h3>
                    <small class="text-500 fs--2"><i class="fas fa-arrow-up text-success me-1"></i>+8.5% bulan ini</small>
                </div>
                <div class="avatar avatar-lg bg-soft-success text-success rounded-circle">
                    <i class="fas fa-wallet fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Piutang Usaha (Accounts Receivable) -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-info border-start border-4 border-info h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Piutang Usaha (AR)</h6>
                    <h3 class="mb-0 text-info fw-bold">Rp 124.800.000</h3>
                    <small class="text-500 fs--2"><i class="fas fa-clock text-info me-1"></i>12 Invoice Jatuh Tempo</small>
                </div>
                <div class="avatar avatar-lg bg-soft-info text-info rounded-circle">
                    <i class="fas fa-file-invoice-dollar fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Hutang Usaha (Accounts Payable) -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-warning border-start border-4 border-warning h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Hutang Usaha (AP)</h6>
                    <h3 class="mb-0 text-warning fw-bold">Rp 68.400.000</h3>
                    <small class="text-500 fs--2"><i class="fas fa-exclamation-triangle text-warning me-1"></i>5 Tagihan Vendor</small>
                </div>
                <div class="avatar avatar-lg bg-soft-warning text-warning rounded-circle">
                    <i class="fas fa-receipt fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Laba Bersih (Net Profit YTD) -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-primary border-start border-4 border-primary h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Laba Bersih (YTD)</h6>
                    <h3 class="mb-0 text-primary fw-bold">Rp 215.600.000</h3>
                    <small class="text-500 fs--2"><i class="fas fa-chart-line text-primary me-1"></i>Periode Berjalan 2026</small>
                </div>
                <div class="avatar avatar-lg bg-soft-primary text-primary rounded-circle">
                    <i class="fas fa-balance-scale fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. MODUL-MODUL AKUNTANSI -->
<div class="d-flex align-items-center justify-content-between mb-3" id="modul-accounting">
    <div>
        <h4 class="mb-0 text-800 fw-bold"><i class="fas fa-cubes text-primary me-2"></i>Modul Layanan Akuntansi</h4>
        <p class="text-600 fs--1 mb-0">Fitur lengkap untuk pengolahan transaksi akuntansi dan pelaporan keuangan.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Modul 1: Jurnal Umum & Transaksi -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="accounting-icon-box bg-gradient-indigo text-white me-3">
                        <i class="fas fa-book-open fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Jurnal & Transaksi</h5>
                        <span class="badge bg-soft-primary text-primary fs--2">General Journal</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Catat transaksi debet dan kredit harian, input jurnal penyesuaian (adj. entry), serta kelola bagan akun (Chart of Accounts).</p>
                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold">
                    Input Jurnal <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 2: Buku Besar (General Ledger) -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="accounting-icon-box bg-gradient-cyan text-white me-3">
                        <i class="fas fa-layer-group fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Buku Besar</h5>
                        <span class="badge bg-soft-info text-info fs--2">General Ledger</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Pantau pergerakan saldo akhir tiap akun secara rinci, posting otomatis, dan lacak histori transaksi akun spesifik.</p>
                <a href="#" class="btn btn-outline-info btn-sm rounded-pill w-100 fw-bold">
                    Buka Buku Besar <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 3: Invoicing & Penjualan (AR) -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="accounting-icon-box bg-gradient-emerald text-white me-3">
                        <i class="fas fa-file-invoice fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Penjualan & Invoicing</h5>
                        <span class="badge bg-soft-success text-success fs--2">Accounts Receivable</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Buat faktur penagihan pelanggan, pantau status pembayaran invoice, serta kelola penerimaan piutang secara otomatis.</p>
                <a href="#" class="btn btn-outline-success btn-sm rounded-pill w-100 fw-bold">
                    Kelola Invoice <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 4: Tagihan Vendor & Pembelian (AP) -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="accounting-icon-box bg-gradient-amber text-white me-3">
                        <i class="fas fa-shopping-cart fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Pembelian & Tagihan</h5>
                        <span class="badge bg-soft-warning text-warning fs--2">Accounts Payable</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Pencatatan tagihan supplier/vendor, jadwal pembayaran hutang, serta rekapitulasi pengeluaran operasional.</p>
                <a href="#" class="btn btn-outline-warning btn-sm rounded-pill w-100 fw-bold">
                    Kelola Tagihan <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 5: Laporan Keuangan Lengkap -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="accounting-icon-box bg-gradient-violet text-white me-3">
                        <i class="fas fa-chart-pie fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Laporan Keuangan</h5>
                        <span class="badge bg-soft-primary text-primary fs--2">Financial Reports</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Cetak Laporan Laba Rugi (Income Statement), Neraca (Balance Sheet), Arus Kas (Cashflow), dan Perubahan Modal.</p>
                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold">
                    Generate Laporan <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 6: Aset Tetap & Perpajakan -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="accounting-icon-box bg-gradient-rose text-white me-3">
                        <i class="fas fa-coins fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Aset & Perpajakan</h5>
                        <span class="badge bg-soft-danger text-danger fs--2">Fixed Assets & Tax</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Hitung penyusutan aset otomatis (depresiasi), kelola rekap PPN & PPh, serta pelaporan pajak secara sistematis.</p>
                <a href="#" class="btn btn-outline-danger btn-sm rounded-pill w-100 fw-bold">
                    Kelola Aset & Pajak <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 4. BANNER AUDIT & EDAPATAN (ANALYSIS) -->
<div class="card border-0 shadow-sm mb-4 overflow-hidden">
    <div class="row g-0">
        <div class="col-md-5">
            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80"
                alt="Financial Audit"
                class="img-fluid h-100 w-100"
                style="object-fit: cover; min-height: 200px;">
        </div>
        <div class="col-md-7 d-flex align-items-center bg-soft-light">
            <div class="card-body p-4">
                <span class="badge bg-dark mb-2">Pemeriksaan & Audit</span>
                <h4 class="fw-bold mb-2">Integritas Data Keuangan Terjamin</h4>
                <p class="text-600 fs--1 mb-3">
                    Sistem akuntansi terintegrasi dengan audit trail otomatis yang merekam seluruh riwayat pembuatan, perubahan, dan persetujuan jurnal transaksi untuk transparansi penuh.
                </p>
                <a href="#" class="btn btn-dark btn-sm rounded-pill px-4">Lihat Audit Log</a>
            </div>
        </div>
    </div>
</div>

<!-- 5. ACCORDION FAQ ACCOUNTING -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white border-bottom p-3">
        <div class="d-flex align-items-center">
            <div class="avatar avatar-md bg-soft-dark text-dark rounded-circle me-2">
                <i class="fas fa-question-circle"></i>
            </div>
            <h5 class="mb-0 fw-bold">Pertanyaan Sering Diajukan (FAQ Akuntansi)</h5>
        </div>
    </div>
    <div class="card-body p-3">
        <div class="accordion accordion-flush" id="accordionAccountingFAQ">

            <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                <h2 class="accordion-header" id="faqAcc1">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAcc1">
                        <i class="fas fa-exchange-alt me-2 text-primary"></i> Bagaimana cara melakukan tutup buku bulanan (Monthly Closing)?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseAcc1" data-bs-parent="#accordionAccountingFAQ">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Proses tutup buku dilakukan melalui modul <strong>Laporan Keuangan</strong> dengan memastikan seluruh jurnal penyesuaian, rekonsiliasi bank, dan penyusunan depresiasi aset periode tersebut telah selesai diposting.
                    </div>
                </div>
            </div>

            <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                <h2 class="accordion-header" id="faqAcc2">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAcc2">
                        <i class="fas fa-university me-2 text-success"></i> Apakah sistem mendukung Rekonsiliasi Bank otomatis?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseAcc2" data-bs-parent="#accordionAccountingFAQ">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Ya, Anda dapat mengunggah mutasi rekening bank (format CSV/Excel) pada modul <strong>Buku Besar / Kas & Bank</strong> untuk dicocokkan otomatis dengan catatan pencatatan internal.
                    </div>
                </div>
            </div>

            <div class="accordion-item border rounded-3 overflow-hidden">
                <h2 class="accordion-header" id="faqAcc3">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAcc3">
                        <i class="fas fa-cogs me-2 text-danger"></i> Bagaimana jika terdapat kesalahan pada jurnal yang telah diposting?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseAcc3" data-bs-parent="#accordionAccountingFAQ">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Jurnal yang sudah diposting tidak dapat dihapus langsung untuk menjaga validitas audit. Anda harus membuat <strong>Jurnal Pembalik (Reversing Entry)</strong> atau Jurnal Koreksi melalui persetujuan Supervisor Accounting.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
