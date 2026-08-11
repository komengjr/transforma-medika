@extends('layouts.layouts')

@section('content')
<style>
    /* Styling khusus Sistem Inventaris & Aset */
    .inventory-hero-banner {
        background: linear-gradient(135deg, #065f46 0%, #047857 50%, #10b981 100%);
        border: none;
        box-shadow: 0 10px 20px rgba(6, 95, 70, 0.2);
    }

    .hover-lift {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12) !important;
    }

    /* Modul Icon Styling */
    .inventory-icon-box {
        width: 58px;
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
    }

    .bg-gradient-teal {
        background: linear-gradient(45deg, #0d9488, #0f766e);
    }

    .bg-gradient-blue {
        background: linear-gradient(45deg, #2563eb, #1d4ed8);
    }

    .bg-gradient-amber {
        background: linear-gradient(45deg, #d97706, #b45309);
    }

    .bg-gradient-purple {
        background: linear-gradient(45deg, #7c3aed, #6d28d9);
    }

    .bg-gradient-rose {
        background: linear-gradient(45deg, #e11d48, #be123c);
    }

    .bg-gradient-cyan {
        background: linear-gradient(45deg, #0891b2, #0e7490);
    }
</style>

<!-- 1. HERO BANNER UTAMA INVENTARIS & ASET -->
<div class="card inventory-hero-banner text-white mb-4 overflow-hidden position-relative">
    <div class="card-body p-4 p-lg-5 position-relative z-index-1">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge bg-soft-light text-warning mb-3 px-3 py-2 rounded-pill fs--1">
                    <i class="fas fa-boxes me-1 text-warning"></i> Asset & Inventory Management System
                </span>
                <h2 class="text-white fw-bold display-6 mb-2">Pusat Kendali Aset & Stok 👋</h2>
                <p class="lead opacity-85 mb-4 fs-0">
                    Sistem pemantauan barang inventaris, pelacakan posisi aset perusahaan, manajemen peminjaman, serta penjadwalan pemeliharaan rutin secara akurat.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#modul-inventaris" class="btn btn-light text-dark fw-bold rounded-pill px-4 shadow-sm">
                        <i class="fas fa-th-large me-2"></i>Modul Inventaris
                    </a>
                    <a href="#ringkasan-aset" class="btn btn-outline-light rounded-pill px-4">
                        <i class="fas fa-chart-bar me-2"></i>Status Aset
                    </a>
                </div>
            </div>
            <!-- Ilustrasi Gudang / Asset Tracking -->
            <div class="col-lg-5 text-center d-none d-lg-block">
                <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=600&q=80"
                    alt="Warehouse & Inventory Management"
                    class="img-fluid rounded-3 shadow-lg border border-3 border-white position-relative"
                    style="max-height: 230px; object-fit: cover; transform: rotate(1deg);">
            </div>
        </div>
    </div>
</div>

<!-- 2. METRIK UTAMA ASET & STOK (KEY INVENTORY METRICS) -->
<div class="row g-3 mb-4" id="ringkasan-aset">
    <!-- Total Unit Aset -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-success border-start border-4 border-success h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Total Item Aset</h6>
                    <h3 class="mb-0 text-success fw-bold">1,420 <span class="fs--1 text-500">Unit</span></h3>
                    <small class="text-500 fs--2"><i class="fas fa-check-circle text-success me-1"></i>Tercatat di Sistem</small>
                </div>
                <div class="avatar avatar-lg bg-soft-success text-success rounded-circle">
                    <i class="fas fa-cubes fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Dipinjam / Digunakan -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-info border-start border-4 border-info h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Sedang Dipinjam</h6>
                    <h3 class="mb-0 text-info fw-bold">184 <span class="fs--1 text-500">Item</span></h3>
                    <small class="text-500 fs--2"><i class="fas fa-user-clock text-info me-1"></i>Oleh Pegawai/Unit</small>
                </div>
                <div class="avatar avatar-lg bg-soft-info text-info rounded-circle">
                    <i class="fas fa-hand-holding fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Perlu Maintenance / Rusak -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-warning border-start border-4 border-warning h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Perlu Perawatan</h6>
                    <h3 class="mb-0 text-warning fw-bold">12 <span class="fs--1 text-500">Aset</span></h3>
                    <small class="text-500 fs--2"><i class="fas fa-tools text-warning me-1"></i>Jadwal Maintenance</small>
                </div>
                <div class="avatar avatar-lg bg-soft-warning text-warning rounded-circle">
                    <i class="fas fa-wrench fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Stok Minimum -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-danger border-start border-4 border-danger h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Stok Menipis (Low)</h6>
                    <h3 class="mb-0 text-danger fw-bold">5 <span class="fs--1 text-500">Kategori</span></h3>
                    <small class="text-500 fs--2"><i class="fas fa-exclamation-triangle text-danger me-1"></i>Perlu Restock</small>
                </div>
                <div class="avatar avatar-lg bg-soft-danger text-danger rounded-circle">
                    <i class="fas fa-dolly-flatbed fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. MODUL-MODUL PERKENALAN INVENTARIS & ASET -->
<div class="d-flex align-items-center justify-content-between mb-3" id="modul-inventaris">
    <div>
        <h4 class="mb-0 text-800 fw-bold"><i class="fas fa-cubes text-primary me-2"></i>Modul Utamanya Aplikasi</h4>
        <p class="text-600 fs--1 mb-0">Fitur pengelolaan rantai pasok barang, aset kantor, dan pelacakan riwayat lokasi.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Modul 1: Master Data Aset & Inventaris -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="inventory-icon-box bg-gradient-teal text-white me-3">
                        <i class="fas fa-boxes fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Master Data Aset</h5>
                        <span class="badge bg-soft-success text-success fs--2">Katalog & Kategori</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Kelola data seluruh aset perusahaan, spesifikasi barang, nomor seri, harga perolehan, dan lokasi penyimpanan.</p>
                <a href="#" class="btn btn-outline-success btn-sm rounded-pill w-100 fw-bold">
                    Lihat Data Aset <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 2: Peminjaman & Pengembalian -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="inventory-icon-box bg-gradient-blue text-white me-3">
                        <i class="fas fa-people-carry fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Sirkulasi & Peminjaman</h5>
                        <span class="badge bg-soft-primary text-primary fs--2">Check-in / Check-out</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Catat alur peminjaman aset oleh karyawan, verifikasi kondisi sebelum & sesudah dipinjam, serta riwayat penanggung jawab.</p>
                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold">
                    Input Peminjaman <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 3: Barcode & Label QR Scanner -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="inventory-icon-box bg-gradient-cyan text-white me-3">
                        <i class="fas fa-qrcode fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Barcode & Label QR</h5>
                        <span class="badge bg-soft-info text-info fs--2">Cetak & Scan Label</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Generate barcode atau QR Code unik untuk ditempel pada aset, mempermudah proses audit dan scan barang.</p>
                <a href="#" class="btn btn-outline-info btn-sm rounded-pill w-100 fw-bold">
                    Cetak Barcode <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 4: Stock Opname & Audit -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="inventory-icon-box bg-gradient-amber text-white me-3">
                        <i class="fas fa-clipboard-check fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Stock Opname</h5>
                        <span class="badge bg-soft-warning text-warning fs--2">Verifikasi Fisik</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Lakukan penghitungan fisik persediaan secara rutin, bandingkan data sistem vs fisik, dan sesuaikan selisih (adjustment).</p>
                <a href="#" class="btn btn-outline-warning btn-sm rounded-pill w-100 fw-bold">
                    Mulai Opname <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 5: Pemeliharaan (Maintenance) -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="inventory-icon-box bg-gradient-purple text-white me-3">
                        <i class="fas fa-tools fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Perawatan & Service</h5>
                        <span class="badge bg-soft-primary text-primary fs--2">Preventive Maintenance</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Jadwalkan servis berkala, catat riwayat kerusakan, estimasi biaya perbaikan, serta status garansi aset.</p>
                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold">
                    Jadwal Perawatan <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 6: Penghapusan & Mutasi Aset -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="inventory-icon-box bg-gradient-rose text-white me-3">
                        <i class="fas fa-trash-alt fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Mutasi & Disposal</h5>
                        <span class="badge bg-soft-danger text-danger fs--2">Transfer & Penghapusan</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Kelola alur perpindahan aset antar cabang/ruangan, serta proses penghapusan aset yang sudah rusak berat atau habis umur ekonomis.</p>
                <a href="#" class="btn btn-outline-danger btn-sm rounded-pill w-100 fw-bold">
                    Kelola Mutasi <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 4. BANNER AUDIT & MONITORING VISUAL -->
<div class="card border-0 shadow-sm mb-4 overflow-hidden">
    <div class="row g-0">
        <div class="col-md-5">
            <img src="https://images.unsplash.com/photo-1553413077-190dd305871c?auto=format&fit=crop&w=800&q=80"
                alt="Asset Tracking Management"
                class="img-fluid h-100 w-100"
                style="object-fit: cover; min-height: 200px;">
        </div>
        <div class="col-md-7 d-flex align-items-center bg-soft-light">
            <div class="card-body p-4">
                <span class="badge bg-emerald text-white mb-2" style="background-color: #047857;">Transparansi Gudang</span>
                <h4 class="fw-bold mb-2">Kontrol Penuh Aset Perusahaan Anda</h4>
                <p class="text-600 fs--1 mb-3">
                    Cegah kehilangan aset, lacak penanggung jawab secara langsung, dan pastikan setiap nilai investasi barang berharga perusahaan tercatat rapi serta terpelihara dengan baik.
                </p>
                <a href="#" class="btn btn-emerald text-white btn-sm rounded-pill px-4" style="background-color: #047857;">Cetak Laporan Aset</a>
            </div>
        </div>
    </div>
</div>

<!-- 5. ACCORDION FAQ INVENTARIS & ASET -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white border-bottom p-3">
        <div class="d-flex align-items-center">
            <div class="avatar avatar-md bg-soft-success text-success rounded-circle me-2">
                <i class="fas fa-question-circle"></i>
            </div>
            <h5 class="mb-0 fw-bold">Pertanyaan Sering Diajukan (FAQ Inventaris & Aset)</h5>
        </div>
    </div>
    <div class="card-body p-3">
        <div class="accordion accordion-flush" id="accordionInventoryFAQ">

            <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                <h2 class="accordion-header" id="faqInv1">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInv1">
                        <i class="fas fa-qrcode me-2 text-primary"></i> Bagaimana cara menambahkan label QR Code pada aset baru?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseInv1" data-bs-parent="#accordionInventoryFAQ">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Setelah mendaftarkan item di modul <strong>Master Data Aset</strong>, sistem akan secara otomatis membuat kode QR unik. Anda tinggal masuk ke modul <strong>Barcode & Label QR</strong> untuk mencetaknya ke printer label.
                    </div>
                </div>
            </div>

            <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                <h2 class="accordion-header" id="faqInv2">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInv2">
                        <i class="fas fa-sync me-2 text-warning"></i> Berapa kali Stock Opname idealnya dilakukan?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseInv2" data-bs-parent="#accordionInventoryFAQ">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Jadwal Stock Opname umumnya dilakukan per triwulan (3 bulan) atau per semester (6 bulan) untuk barang aset tetap, sedangkan persediaan konsumsi (consumable items) dilakukan setiap akhir bulan.
                    </div>
                </div>
            </div>

            <div class="accordion-item border rounded-3 overflow-hidden">
                <h2 class="accordion-header" id="faqInv3">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInv3">
                        <i class="fas fa-exchange-alt me-2 text-danger"></i> Apa prosedur jika aset mengalami kerusakan saat dipinjam?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseInv3" data-bs-parent="#accordionInventoryFAQ">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Peminjam wajib melaporkannya pada modul <strong>Sirkulasi & Peminjaman</strong> dengan memilih status kondisi <em>"Rusak"</em>. Petugas inventaris akan merujuk barang tersebut ke modul <strong>Perawatan & Service</strong> untuk diperbaiki atau dilakukan penghapusan jika rusak total.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
