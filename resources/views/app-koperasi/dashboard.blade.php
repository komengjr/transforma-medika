@extends('layouts.layouts')

@section('content')
<style>
    /* Styling khusus Sistem Koperasi */
    .koperasi-hero-banner {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 50%, #052c65 100%);
        border: none;
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.15);
    }

    .hover-lift {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1) !important;
    }

    /* Modul Icon Styling */
    .koperasi-icon-box {
        width: 58px;
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.12);
    }

    .bg-gradient-emerald {
        background: linear-gradient(45deg, #198754, #0f5132);
    }

    .bg-gradient-blue {
        background: linear-gradient(45deg, #0d6efd, #0a58ca);
    }

    .bg-gradient-amber {
        background: linear-gradient(45deg, #ffc107, #d39e00);
    }

    .bg-gradient-teal {
        background: linear-gradient(45deg, #20c997, #1aa179);
    }

    .bg-gradient-purple {
        background: linear-gradient(45deg, #6f42c1, #52278f);
    }

    .bg-gradient-coral {
        background: linear-gradient(45deg, #fd7e14, #ca5d0c);
    }
</style>

<!-- 1. HERO BANNER UTAMA KOPERASI -->
<div class="card koperasi-hero-banner text-white mb-3 overflow-hidden position-relative">
    <div class="card-body p-4 p-lg-5 position-relative z-index-1">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge bg-soft-light text-warning mb-3 px-3 py-2 rounded-pill fs--1">
                    <i class="fas fa-handshake me-1 text-warning"></i> Portal Anggota Koperasi Pegawai
                </span>
                <h2 class="text-white fw-bold display-6 mb-2">Selamat Datang, {{ Auth::user()->fullname ?? 'Anggota' }}! 👋</h2>
                <p class="lead opacity-85 mb-4 fs-0">
                    Sistem Layanan Mandiri Koperasi Simpan Pinjam. Kelola simpanan, ajukan pinjaman, dan pantau estimasi Sisa Hasil Usaha (SHU) Anda secara transparan.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#modul-koperasi" class="btn btn-light text-primary fw-bold rounded-pill px-4 shadow-sm">
                        <i class="fas fa-th-large me-2"></i>Layanan Koperasi
                    </a>
                    <a href="#ringkasan-keuangan" class="btn btn-outline-light rounded-pill px-4">
                        <i class="fas fa-wallet me-2"></i>Status Simpanan
                    </a>
                </div>
            </div>
            <!-- Ilustrasi / Foto Kegiatan Koperasi -->
            <div class="col-lg-5 text-center d-none d-lg-block">
                <img src="https://www.redeia.com/sites/default/files/styles/crop_style_scale_768_x_428/public/2026-02/proveedores-codigo-conducta.jpg.webp?h=ef1f3445&itok=Ta6dhrVr"
                    alt="Koperasi Indonesia"
                    class="img-fluid rounded-3 shadow-lg border border-3 border-white position-relative"
                    style="max-height: 230px; object-fit: cover; transform: rotate(1deg);">
            </div>
        </div>
    </div>
</div>



<!-- 3. MODUL-MODUL PERKENALAN SYSTEM KOPERASI -->
<div class="d-flex align-items-center justify-content-between mb-3" id="modul-koperasi">
    <div>
        <h4 class="mb-0 text-800 fw-bold"><i class="fas fa-cubes text-primary me-2"></i>Layanan Utamanya Koperasi</h4>
        <p class="text-600 fs--1 mb-0">Akses fitur simpan pinjam dan belanja unit usaha pegawai secara mandiri.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Modul 1: Simpanan Anggota -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="koperasi-icon-box bg-gradient-emerald text-white me-3">
                        <i class="fas fa-vault fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Simpanan Anggota</h5>
                        <span class="badge bg-soft-success text-success fs--2">Simpanan Pokok & Sukarela</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Lihat mutasi saldo simpanan pokok, simpanan wajib bulanan, serta lakukan setoran simpanan sukarela secara online.</p>
                <a href="#" class="btn btn-outline-success btn-sm rounded-pill w-100 fw-bold">
                    Cek Mutasi Simpanan <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 2: Pinjaman & Kredit -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="koperasi-icon-box bg-gradient-blue text-white me-3">
                        <i class="fas fa-file-invoice-dollar fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Pengajuan Pinjaman</h5>
                        <span class="badge bg-soft-primary text-primary fs--2">Proses Cepat & Transparan</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Ajukan pinjaman regular/darurat, kalkulasi simulasi angsuran bulanan, dan pantau proses verifikasi pengurus.</p>
                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold">
                    Ajukan Pinjaman <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 3: Unit Toko & Waserda (Koperasi Pegawai) -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="koperasi-icon-box bg-gradient-amber text-white me-3">
                        <i class="fas fa-shopping-basket fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Kredit Barang & Waserda</h5>
                        <span class="badge bg-soft-warning text-warning fs--2">Kebutuhan Pegawai</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Belanja kebutuhan harian, elektronik, atau barang kebutuhan instansi dengan sistem pemotongan gaji bulanan.</p>
                <a href="#" class="btn btn-outline-warning btn-sm rounded-pill w-100 fw-bold">
                    Katalog Barang <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 4: Sisa Hasil Usaha (SHU) -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="koperasi-icon-box bg-gradient-teal text-white me-3">
                        <i class="fas fa-chart-pie fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Pembagian SHU</h5>
                        <span class="badge bg-soft-info text-info fs--2">Transparansi Keuangan</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Pantau rinci alokasi SHU Anda berdasarkan jasa modal dan jasa transaksi anggota selama periode buku berjalan.</p>
                <a href="#" class="btn btn-outline-info btn-sm rounded-pill w-100 fw-bold">
                    Rincian SHU <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 5: Simpanan Berjangka / Mudharabah -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="koperasi-icon-box bg-gradient-purple text-white me-3">
                        <i class="fas fa-seedling fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Simpanan Berjangka</h5>
                        <span class="badge bg-soft-primary text-primary fs--2">Investasi Anggota</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Program simpanan investasi jangka panjang bagi anggota dengan imbal hasil (bagi hasil) yang kompetitif.</p>
                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold">
                    Info Investment <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 6: RAT & Laporan Koperasi -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="koperasi-icon-box bg-gradient-coral text-white me-3">
                        <i class="fas fa-file-signature fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">RAT & Laporan Tahunan</h5>
                        <span class="badge bg-soft-danger text-danger fs--2">Rapat Anggota Tahunan</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Akses dokumen Laporan Pertanggungjawaban (LPJ) Pengurus, jadwal RAT, serta voting e-RAT online.</p>
                <a href="#" class="btn btn-outline-danger btn-sm rounded-pill w-100 fw-bold">
                    Dokumen RAT <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>


<!-- 5. ACCORDION FAQ KOPERASI -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white border-bottom p-3">
        <div class="d-flex align-items-center">
            <div class="avatar avatar-md bg-soft-primary text-primary rounded-circle me-2">
                <i class="fas fa-question-circle"></i>
            </div>
            <h5 class="mb-0 fw-bold">Pertanyaan Sering Diajukan (FAQ Koperasi)</h5>
        </div>
    </div>
    <div class="card-body p-3">
        <div class="accordion accordion-flush" id="accordionKoperasiFAQ">

            <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                <h2 class="accordion-header" id="faqKop1">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKop1">
                        <i class="fas fa-money-check-alt me-2 text-success"></i> Bagaimana skema pemotongan pinjaman & simpanan wajib?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseKop1" data-bs-parent="#accordionKoperasiFAQ">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Untuk Koperasi Pegawai, potongan simpanan wajib dan angsuran pinjaman dilakukan secara otomatis setiap bulan melalui sistem pemotongan gaji (payroll) instansi/perusahaan.
                    </div>
                </div>
            </div>

            <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                <h2 class="accordion-header" id="faqKop2">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKop2">
                        <i class="fas fa-calculator me-2 text-primary"></i> Bagaimana perhitungan SHU bagi setiap anggota?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseKop2" data-bs-parent="#accordionKoperasiFAQ">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        SHU dihitung proporsional berdasarkan dua aspek utama: <strong>Jasa Modal</strong> (besarnya jumlah simpanan Anda) dan <strong>Jasa Usaha/Transaksi</strong> (keaktifan transaksi Anda di Waserda maupun produk pinjaman).
                    </div>
                </div>
            </div>

            <div class="accordion-item border rounded-3 overflow-hidden">
                <h2 class="accordion-header" id="faqKop3">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKop3">
                        <i class="fas fa-file-medical-alt me-2 text-warning"></i> Apa saja syarat pengajuan pinjaman online?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseKop3" data-bs-parent="#accordionKoperasiFAQ">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Anggota wajib telah terdaftar minimal 3 bulan, tidak memiliki tunggakan angsuran, serta mengunggah slip gaji terbaru dan dokumen persetujuan (jika plafon pinjaman di atas batas tertentu).
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
