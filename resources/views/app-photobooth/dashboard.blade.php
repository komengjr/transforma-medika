@extends('layouts.layouts')

@section('content')
<style>
    /* Custom Styling Dashboard Purchasing & Procurement */
    .purchasing-hero {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
        border: none;
        box-shadow: 0 10px 20px rgba(30, 27, 75, 0.2);
    }

    .hover-lift {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1) !important;
    }

    .purchasing-icon-box {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .bg-gradient-indigo {
        background: linear-gradient(45deg, #4338ca, #3730a3);
    }

    .bg-gradient-emerald {
        background: linear-gradient(45deg, #059669, #047857);
    }

    .bg-gradient-amber {
        background: linear-gradient(45deg, #d97706, #b45309);
    }

    .bg-gradient-blue {
        background: linear-gradient(45deg, #0284c7, #0369a1);
    }

    .bg-gradient-purple {
        background: linear-gradient(45deg, #7c3aed, #6d28d9);
    }

    .bg-gradient-rose {
        background: linear-gradient(45deg, #e11d48, #be123c);
    }
</style>

<!-- 1. HERO HEADER PURCHASING -->
<div class="card purchasing-hero text-white mb-4 overflow-hidden position-relative">
    <div class="bg-holder d-none d-lg-block bg-card"
        style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); opacity: 0.15;">
    </div>
    <div class="card-body p-4 p-lg-5 position-relative z-index-1">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-soft-light text-warning mb-2 px-3 py-1 rounded-pill fs--1">
                    <i class="fas fa-shopping-cart me-1 text-warning"></i> Purchasing & Procurement System
                </span>
                <h2 class="text-white fw-bold display-6 mb-2">Pusat Pengadaan & Pembelian 🛒</h2>
                <p class="lead opacity-85 mb-4 fs-0">
                    Kelola permintaan pembelian (PR), penerbitan Purchase Order (PO), verifikasi vendor/pemasok, dan riwayat penerimaan barang secara efisien.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#modul-purchasing" class="btn btn-light text-dark fw-bold rounded-pill px-4 shadow-sm">
                        <i class="fas fa-th-large me-2"></i>Modul Pengadaan
                    </a>
                    <a href="#tabel-po" class="btn btn-outline-light rounded-pill px-4">
                        <i class="fas fa-file-invoice-dollar me-2"></i>Status PO Terbaru
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=600&q=80"
                    alt="Procurement Management"
                    class="img-fluid rounded-3 shadow-lg border border-3 border-white position-relative"
                    style="max-height: 200px; object-fit: cover; transform: rotate(-2deg);">
            </div>
        </div>
    </div>
</div>

<!-- 2. SUMMARY METRICS CARDS -->
<div class="row g-3 mb-4">
    <!-- Total Purchase Order -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-primary border-start border-4 border-primary h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Total PO Bulan Ini</h6>
                    <h3 class="mb-0 text-primary fw-bold">128 <span class="fs--1 text-500">Dokumen</span></h3>
                    <small class="text-500 fs--2"><i class="fas fa-check-circle text-primary me-1"></i>Telah Diterbitkan</small>
                </div>
                <div class="avatar avatar-lg bg-soft-primary text-primary rounded-circle">
                    <i class="fas fa-file-signature fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- PR Pending Approval -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-warning border-start border-4 border-warning h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Pengajuan Pending (PR)</h6>
                    <h3 class="mb-0 text-warning fw-bold">14 <span class="fs--1 text-500">Permintaan</span></h3>
                    <small class="text-500 fs--2"><i class="fas fa-clock text-warning me-1"></i>Menunggu Approval</small>
                </div>
                <div class="avatar avatar-lg bg-soft-warning text-warning rounded-circle">
                    <i class="fas fa-hourglass-half fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Budget Pembelian -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-success border-start border-4 border-success h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Nilai Pembelian</h6>
                    <h3 class="mb-0 text-success fw-bold">Rp 482M</h3>
                    <small class="text-500 fs--2"><i class="fas fa-arrow-up text-success me-1"></i>Realisasi Anggaran</small>
                </div>
                <div class="avatar avatar-lg bg-soft-success text-success rounded-circle">
                    <i class="fas fa-wallet fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor / Pemasok Aktif -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-info border-start border-4 border-info h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Pemasok Aktif</h6>
                    <h3 class="mb-0 text-info fw-bold">42 <span class="fs--1 text-500">Vendor</span></h3>
                    <small class="text-500 fs--2"><i class="fas fa-truck-loading text-info me-1"></i>Mitra Terverifikasi</small>
                </div>
                <div class="avatar avatar-lg bg-soft-info text-info rounded-circle">
                    <i class="fas fa-store fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. MODUL UTAMA PURCHASING -->
<div class="d-flex align-items-center justify-content-between mb-3" id="modul-purchasing">
    <div>
        <h4 class="mb-0 text-800 fw-bold"><i class="fas fa-shopping-bag text-indigo me-2"></i>Modul Alur Pembelian</h4>
        <p class="text-600 fs--1 mb-0">Fitur lengkap pengadaan barang dari pengajuan hingga proses pembayaran vendor.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Modul 1: Purchase Requisition (PR) -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="purchasing-icon-box bg-gradient-indigo text-white me-3">
                        <i class="fas fa-file-alt fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Permintaan Pembelian (PR)</h5>
                        <span class="badge bg-soft-primary text-primary fs--2">Purchase Requisition</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Buat pengajuan barang/jasa dari tiap divisi internal dan pantau persetujuan (approval level) dari manajerial.</p>
                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold">
                    Buat Pengajuan PR <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 2: Purchase Order (PO) -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="purchasing-icon-box bg-gradient-emerald text-white me-3">
                        <i class="fas fa-file-invoice-dollar fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Pesanan Pembelian (PO)</h5>
                        <span class="badge bg-soft-success text-success fs--2">Purchase Order</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Terbitkan dokumen PO resmi ke vendor berdasarkan PR yang disetujui, atur termin pembayaran dan tenggat pengiriman.</p>
                <a href="#" class="btn btn-outline-success btn-sm rounded-pill w-100 fw-bold">
                    Kelola PO <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 3: Manajemen Vendor / Pemasok -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="purchasing-icon-box bg-gradient-blue text-white me-3">
                        <i class="fas fa-handshake fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Database Pemasok</h5>
                        <span class="badge bg-soft-info text-info fs--2">Vendor Management</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Kelola katalog vendor, performa penawaran harga, rating kecepatan pengiriman, serta kontrak kerja sama.</p>
                <a href="#" class="btn btn-outline-info btn-sm rounded-pill w-100 fw-bold">
                    Daftar Vendor <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 4: Penerimaan Barang (Goods Receipt) -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="purchasing-icon-box bg-gradient-amber text-white me-3">
                        <i class="fas fa-truck-loading fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Penerimaan Barang (GR)</h5>
                        <span class="badge bg-soft-warning text-warning fs--2">Goods Receipt / LPB</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Verifikasi kesesuaian jumlah fisik barang yang dikirim vendor dengan dokumen PO sebelum masuk stok gudang.</p>
                <a href="#" class="btn btn-outline-warning btn-sm rounded-pill w-100 fw-bold">
                    Input Penerimaan <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 5: Tagihan & Faktur (Invoice Matching) -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="purchasing-icon-box bg-gradient-purple text-white me-3">
                        <i class="fas fa-receipt fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Faktur & Tagihan Vendor</h5>
                        <span class="badge bg-soft-primary text-primary fs--2">3-Way Matching</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Pencocokan 3 arah antara dokumen PO, Penerimaan Barang (GR), dan Faktur Vendor untuk diteruskan ke tim Keuangan.</p>
                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold">
                    Verifikasi Tagihan <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 6: Laporan Pengadaan -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="purchasing-icon-box bg-gradient-rose text-white me-3">
                        <i class="fas fa-chart-pie fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Laporan Procurement</h5>
                        <span class="badge bg-soft-danger text-danger fs--2">Analytics & Spending</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Analisis efisiensi pengeluaran anggaran, perbandingan harga antar vendor, dan rekapitulasi pengadaan bulanan.</p>
                <a href="#" class="btn btn-outline-danger btn-sm rounded-pill w-100 fw-bold">
                    Cetak Laporan <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 4. TABEL RINGKASAN PURCHASE ORDER TERBARU -->
<div class="card border-0 shadow-sm mb-4" id="tabel-po">
    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
        <div>
            <h6 class="mb-0 fw-bold text-800"><i class="fas fa-history text-indigo me-2"></i>Daftar Pesanan Pembelian (PO) Terbaru</h6>
            <small class="text-muted fs--2">Aktivitas penerbitan dokumen PO ke pemasok</small>
        </div>
        <a href="#" class="btn btn-link btn-sm text-decoration-none p-0 fw-bold">Lihat Semua PO <i class="fas fa-chevron-right ms-1"></i></a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="bg-200 text-800 fs--1">
                    <tr>
                        <th class="ps-3">No. PO</th>
                        <th>Vendor / Pemasok</th>
                        <th>Tanggal PO</th>
                        <th>Total Nilai</th>
                        <th>Estimasi Tiba</th>
                        <th class="text-end pe-3">Status</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                    <tr>
                        <td class="ps-3"><code class="fw-bold text-primary">PO-2026-0801</code></td>
                        <td class="fw-bold text-dark">PT. Medika Jaya Utama</td>
                        <td>10 Aug 2026</td>
                        <td class="fw-bold">Rp 45.000.000</td>
                        <td>14 Aug 2026</td>
                        <td class="text-end pe-3"><span class="badge bg-soft-success text-success"><i class="fas fa-check-circle me-1"></i>Approved</span></td>
                    </tr>
                    <tr>
                        <td class="ps-3"><code class="fw-bold text-primary">PO-2026-0802</code></td>
                        <td class="fw-bold text-dark">CV. Kimia Nusantara</td>
                        <td>09 Aug 2026</td>
                        <td class="fw-bold">Rp 18.500.000</td>
                        <td>12 Aug 2026</td>
                        <td class="text-end pe-3"><span class="badge bg-soft-warning text-warning"><i class="fas fa-clock me-1"></i>Pending Review</span></td>
                    </tr>
                    <tr>
                        <td class="ps-3"><code class="fw-bold text-primary">PO-2026-0803</code></td>
                        <td class="fw-bold text-dark">PT. Global Logistik Sarana</td>
                        <td>08 Aug 2026</td>
                        <td class="fw-bold">Rp 120.000.000</td>
                        <td>20 Aug 2026</td>
                        <td class="text-end pe-3"><span class="badge bg-soft-success text-success"><i class="fas fa-check-circle me-1"></i>Approved</span></td>
                    </tr>
                    <tr>
                        <td class="ps-3"><code class="fw-bold text-primary">PO-2026-0804</code></td>
                        <td class="fw-bold text-dark">Deltamed Supply Co.</td>
                        <td>07 Aug 2026</td>
                        <td class="fw-bold">Rp 8.750.000</td>
                        <td>11 Aug 2026</td>
                        <td class="text-end pe-3"><span class="badge bg-soft-secondary text-secondary"><i class="fas fa-file me-1"></i>Draft</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 5. ACCORDION FAQ PEMBELIAN -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white border-bottom p-3">
        <div class="d-flex align-items-center">
            <div class="avatar avatar-md bg-soft-primary text-primary rounded-circle me-2">
                <i class="fas fa-question-circle"></i>
            </div>
            <h5 class="mb-0 fw-bold">Pertanyaan Sering Diajukan (FAQ Pembelian & Procurement)</h5>
        </div>
    </div>
    <div class="card-body p-3">
        <div class="accordion accordion-flush" id="accordionPurchasingFAQ">

            <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                <h2 class="accordion-header" id="faqPurchasing1">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePurchasing1">
                        <i class="fas fa-file-alt me-2 text-primary"></i> Apa perbedaan antara Purchase Requisition (PR) dan Purchase Order (PO)?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapsePurchasing1" data-bs-parent="#accordionPurchasingFAQ">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        <strong>Purchase Requisition (PR)</strong> adalah dokumen pengajuan internal dari tim ke bagian Purchasing. Setelah PR disetujui, bagian Purchasing akan menerbitkan <strong>Purchase Order (PO)</strong> sebagai dokumen resmi pemesanan ke vendor eksternal.
                    </div>
                </div>
            </div>

            <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                <h2 class="accordion-header" id="faqPurchasing2">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePurchasing2">
                        <i class="fas fa-handshake me-2 text-success"></i> Bagaimana cara menambahkan Vendor atau Pemasok Baru?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapsePurchasing2" data-bs-parent="#accordionPurchasingFAQ">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Pilih menu <strong>Database Pemasok</strong> lalu klik tombol <em>"Tambah Vendor Baru"</em>. Isi formulir legalitas usaha, kontak sales, syarat pembayaran (TOP), serta kategori produk yang disediakan.
                    </div>
                </div>
            </div>

            <div class="accordion-item border rounded-3 overflow-hidden">
                <h2 class="accordion-header" id="faqPurchasing3">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePurchasing3">
                        <i class="fas fa-check-double me-2 text-warning"></i> Apa itu proses 3-Way Matching pada modul Keuangan & Pembelian?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapsePurchasing3" data-bs-parent="#accordionPurchasingFAQ">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        <strong>3-Way Matching</strong> adalah metode validasi sebelum pembayaran dilakukan dengan membandingkan 3 dokumen: 1) Dokumen PO, 2) Dokumen Penerimaan Barang (Goods Receipt), dan 3) Faktur Tagihan dari Vendor untuk memastikan jumlah dan harga yang ditagihkan sesuai.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
