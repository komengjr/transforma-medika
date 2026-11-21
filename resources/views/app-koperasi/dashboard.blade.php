@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (KOPERASI)
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
        --ent-purple: #7c3aed;
        --ent-coral: #ea580c;
        --ent-solid-bg: #ffffff;
        --ent-solid-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Adaptive Enterprise Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 15px 20px;
    }

    /* Hero Banner */
    .koperasi-hero-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 18px;
        box-shadow: 0 14px 32px -8px rgba(15, 23, 42, 0.25);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .koperasi-hero-banner::before {
        content: '';
        position: absolute;
        top: -55%;
        right: -5%;
        width: 380px;
        height: 380px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

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

    /* Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        cursor: pointer;
        font-size: 0.84rem;
    }

    .ent-btn:hover {
        transform: translateY(-1px);
    }

    .ent-btn-light {
        background-color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.35);
        color: #0f172a;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.18);
    }

    .ent-btn-light:hover {
        background-color: #f8fafc;
        color: #0f172a;
    }

    /* Feature Card Hover */
    .hover-lift {
        transition: all 0.2s ease;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 14px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 4px 16px -4px rgba(15, 23, 42, 0.06);
    }

    .hover-lift:hover {
        transform: translateY(-3px);
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 12px 24px -6px rgba(79, 70, 229, 0.16);
    }

    /* Modul Icon Styling */
    .koperasi-icon-box {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        flex-shrink: 0;
    }

    .icon-emerald {
        background-color: rgba(5, 150, 105, 0.14);
        color: #10b981;
        border: 1px solid rgba(5, 150, 105, 0.3);
    }

    .icon-blue {
        background-color: rgba(79, 70, 229, 0.14);
        color: #818cf8;
        border: 1px solid rgba(79, 70, 229, 0.3);
    }

    .icon-amber {
        background-color: rgba(217, 119, 6, 0.14);
        color: #f59e0b;
        border: 1px solid rgba(217, 119, 6, 0.3);
    }

    .icon-teal {
        background-color: rgba(2, 132, 199, 0.14);
        color: #0ea5e9;
        border: 1px solid rgba(2, 132, 199, 0.3);
    }

    .icon-purple {
        background-color: rgba(124, 58, 237, 0.14);
        color: #a78bfa;
        border: 1px solid rgba(124, 58, 237, 0.3);
    }

    .icon-coral {
        background-color: rgba(234, 88, 12, 0.14);
        color: #fb923c;
        border: 1px solid rgba(234, 88, 12, 0.3);
    }

    /* Accordion Styling */
    .ent-accordion .accordion-item {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px !important;
        overflow: hidden;
        margin-bottom: 12px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
    }

    .ent-accordion .accordion-button {
        font-weight: 700;
        font-size: 0.88rem;
        color: var(--bs-body-color);
        background-color: rgba(79, 70, 229, 0.06);
        box-shadow: none !important;
    }

    .ent-accordion .accordion-button:not(.collapsed) {
        background-color: rgba(79, 70, 229, 0.12);
        color: #6366f1;
    }
</style>
@endsection

@section('content')
<!-- 1. HERO BANNER UTAMA KOPERASI -->
<div class="card koperasi-hero-banner text-white mb-3 p-1">
    <div class="card-body p-4 p-lg-5 position-relative" style="z-index: 2;">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <div class="ent-glass-pill d-inline-flex align-items-center rounded-pill px-3 py-1.5 mb-3">
                    <i class="fas fa-handshake me-2 text-warning"></i>
                    <small class="fw-semibold text-white" style="font-size: 0.78rem;">Portal Anggota Koperasi Pegawai</small>
                </div>
                <h2 class="text-white fw-bold mb-2" style="letter-spacing: -0.02em;">
                    Selamat Datang, {{ Auth::user()->fullname ?? 'Anggota' }}!
                </h2>
                <p class="mb-3" style="color: #cbd5e1; font-size: 0.92rem; line-height: 1.65;">
                    Sistem Layanan Mandiri Koperasi Simpan Pinjam. Kelola simpanan, ajukan pinjaman, dan pantau estimasi Sisa Hasil Usaha (SHU) Anda secara transparan.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#modul-koperasi" class="btn ent-btn ent-btn-light px-4 py-2">
                        <i class="fas fa-th-large me-2 text-primary"></i>Layanan Koperasi
                    </a>
                    <a href="#ringkasan-keuangan" class="btn ent-btn ent-glass-pill px-4 py-2">
                        <i class="fas fa-wallet me-2 text-info"></i>Status Simpanan
                    </a>
                </div>
            </div>
            <!-- Ilustrasi / Foto Kegiatan Koperasi -->
            <div class="col-lg-5 text-center d-none d-lg-block">
                <div class="ent-glass-pill p-2 d-inline-block" style="border-radius: 16px;">
                    <img src="https://www.redeia.com/sites/default/files/styles/crop_style_scale_768_x_428/public/2026-02/proveedores-codigo-conducta.jpg.webp?h=ef1f3445&itok=Ta6dhrVr"
                        alt="Koperasi Indonesia"
                        class="img-fluid rounded-3"
                        style="max-height: 225px; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. MODUL-MODUL PERKENALAN SYSTEM KOPERASI -->
<div class="d-flex align-items-center justify-content-between mb-3" id="modul-koperasi">
    <div>
        <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
            <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 34px; height: 34px; background-color: rgba(79, 70, 229, 0.14); color: #6366f1;">
                <i class="fas fa-cubes"></i>
            </span>
            Layanan Utama Koperasi
        </h5>
        <p class="opacity-75 mb-0 mt-1" style="font-size: 0.83rem;">Akses fitur simpan pinjam dan belanja unit usaha pegawai secara mandiri.</p>
    </div>
</div>

<div class="row g-3 g-md-3 mb-3" id="ringkasan-keuangan">
    <!-- Modul 1: Simpanan Anggota -->
    <div class="col-md-6 col-xl-4">
        <div class="p-4 hover-lift h-100 d-flex flex-column" style="border-top: 4px solid var(--ent-emerald) !important;">
            <div class="d-flex align-items-center mb-3">
                <div class="koperasi-icon-box icon-emerald me-3">
                    <i class="fas fa-vault fs-4"></i>
                </div>
                <div>
                    <h6 class="mb-1 fw-bold" style="font-size: 0.95rem;">Simpanan Anggota</h6>
                    <span class="ent-badge" style="background-color: rgba(5, 150, 105, 0.14); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.3);">Simpanan Pokok &amp; Sukarela</span>
                </div>
            </div>
            <p class="opacity-75 mb-3" style="font-size: 0.84rem; line-height: 1.6;">
                Lihat mutasi saldo simpanan pokok, simpanan wajib bulanan, serta lakukan setoran simpanan sukarela secara online.
            </p>
            <a href="#" class="btn btn-outline-success ent-btn btn-sm rounded-pill w-100 mt-auto py-2">
                Cek Mutasi Simpanan <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <!-- Modul 2: Pinjaman & Kredit -->
    <div class="col-md-6 col-xl-4">
        <div class="p-4 hover-lift h-100 d-flex flex-column" style="border-top: 4px solid var(--ent-indigo) !important;">
            <div class="d-flex align-items-center mb-3">
                <div class="koperasi-icon-box icon-blue me-3">
                    <i class="fas fa-file-invoice-dollar fs-4"></i>
                </div>
                <div>
                    <h6 class="mb-1 fw-bold" style="font-size: 0.95rem;">Pengajuan Pinjaman</h6>
                    <span class="ent-badge" style="background-color: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.3);">Proses Cepat &amp; Transparan</span>
                </div>
            </div>
            <p class="opacity-75 mb-3" style="font-size: 0.84rem; line-height: 1.6;">
                Ajukan pinjaman regular/darurat, kalkulasi simulasi angsuran bulanan, dan pantau proses verifikasi pengurus.
            </p>
            <a href="#" class="btn btn-outline-primary ent-btn btn-sm rounded-pill w-100 mt-auto py-2">
                Ajukan Pinjaman <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <!-- Modul 3: Unit Toko & Waserda (Koperasi Pegawai) -->
    <div class="col-md-6 col-xl-4">
        <div class="p-4 hover-lift h-100 d-flex flex-column" style="border-top: 4px solid var(--ent-amber) !important;">
            <div class="d-flex align-items-center mb-3">
                <div class="koperasi-icon-box icon-amber me-3">
                    <i class="fas fa-shopping-basket fs-4"></i>
                </div>
                <div>
                    <h6 class="mb-1 fw-bold" style="font-size: 0.95rem;">Kredit Barang &amp; Waserda</h6>
                    <span class="ent-badge" style="background-color: rgba(217, 119, 6, 0.14); color: #f59e0b; border: 1px solid rgba(217, 119, 6, 0.3);">Kebutuhan Pegawai</span>
                </div>
            </div>
            <p class="opacity-75 mb-3" style="font-size: 0.84rem; line-height: 1.6;">
                Belanja kebutuhan harian, elektronik, atau barang kebutuhan instansi dengan sistem pemotongan gaji bulanan.
            </p>
            <a href="#" class="btn btn-outline-warning ent-btn btn-sm rounded-pill w-100 mt-auto py-2">
                Katalog Barang <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <!-- Modul 4: Sisa Hasil Usaha (SHU) -->
    <div class="col-md-6 col-xl-4">
        <div class="p-4 hover-lift h-100 d-flex flex-column" style="border-top: 4px solid var(--ent-sky) !important;">
            <div class="d-flex align-items-center mb-3">
                <div class="koperasi-icon-box icon-teal me-3">
                    <i class="fas fa-chart-pie fs-4"></i>
                </div>
                <div>
                    <h6 class="mb-1 fw-bold" style="font-size: 0.95rem;">Pembagian SHU</h6>
                    <span class="ent-badge" style="background-color: rgba(2, 132, 199, 0.14); color: #0ea5e9; border: 1px solid rgba(2, 132, 199, 0.3);">Transparansi Keuangan</span>
                </div>
            </div>
            <p class="opacity-75 mb-3" style="font-size: 0.84rem; line-height: 1.6;">
                Pantau rinci alokasi SHU Anda berdasarkan jasa modal dan jasa transaksi anggota selama periode buku berjalan.
            </p>
            <a href="#" class="btn btn-outline-info ent-btn btn-sm rounded-pill w-100 mt-auto py-2">
                Rincian SHU <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <!-- Modul 5: Simpanan Berjangka / Mudharabah -->
    <div class="col-md-6 col-xl-4">
        <div class="p-4 hover-lift h-100 d-flex flex-column" style="border-top: 4px solid var(--ent-purple) !important;">
            <div class="d-flex align-items-center mb-3">
                <div class="koperasi-icon-box icon-purple me-3">
                    <i class="fas fa-seedling fs-4"></i>
                </div>
                <div>
                    <h6 class="mb-1 fw-bold" style="font-size: 0.95rem;">Simpanan Berjangka</h6>
                    <span class="ent-badge" style="background-color: rgba(124, 58, 237, 0.14); color: #a78bfa; border: 1px solid rgba(124, 58, 237, 0.3);">Investasi Anggota</span>
                </div>
            </div>
            <p class="opacity-75 mb-3" style="font-size: 0.84rem; line-height: 1.6;">
                Program simpanan investasi jangka panjang bagi anggota dengan imbal hasil (bagi hasil) yang kompetitif.
            </p>
            <a href="#" class="btn btn-outline-primary ent-btn btn-sm rounded-pill w-100 mt-auto py-2">
                Info Investment <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>

    <!-- Modul 6: RAT & Laporan Koperasi -->
    <div class="col-md-6 col-xl-4">
        <div class="p-4 hover-lift h-100 d-flex flex-column" style="border-top: 4px solid var(--ent-coral) !important;">
            <div class="d-flex align-items-center mb-3">
                <div class="koperasi-icon-box icon-coral me-3">
                    <i class="fas fa-file-signature fs-4"></i>
                </div>
                <div>
                    <h6 class="mb-1 fw-bold" style="font-size: 0.95rem;">RAT &amp; Laporan Tahunan</h6>
                    <span class="ent-badge" style="background-color: rgba(234, 88, 12, 0.14); color: #fb923c; border: 1px solid rgba(234, 88, 12, 0.3);">Rapat Anggota Tahunan</span>
                </div>
            </div>
            <p class="opacity-75 mb-3" style="font-size: 0.84rem; line-height: 1.6;">
                Akses dokumen Laporan Pertanggungjawaban (LPJ) Pengurus, jadwal RAT, serta voting e-RAT online.
            </p>
            <a href="#" class="btn btn-outline-danger ent-btn btn-sm rounded-pill w-100 mt-auto py-2">
                Dokumen RAT <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>

<!-- 3. ACCORDION FAQ KOPERASI -->
<div class="ent-card mb-3">
    <div class="ent-card-header">
        <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
            <i class="fas fa-question-circle text-primary"></i> Pertanyaan Sering Diajukan (FAQ Koperasi)
        </h6>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="accordion border-0 ent-accordion" id="accordionKoperasiFAQ">

            <div class="accordion-item">
                <h2 class="accordion-header" id="faqKop1">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKop1">
                        <i class="fas fa-money-check-alt me-2 text-success"></i> Bagaimana skema pemotongan pinjaman &amp; simpanan wajib?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseKop1" data-bs-parent="#accordionKoperasiFAQ">
                    <div class="accordion-body opacity-75" style="font-size: 0.85rem; line-height: 1.65;">
                        Untuk Koperasi Pegawai, potongan simpanan wajib dan angsuran pinjaman dilakukan secara otomatis setiap bulan melalui sistem pemotongan gaji (payroll) instansi/perusahaan.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="faqKop2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKop2">
                        <i class="fas fa-calculator me-2 text-primary"></i> Bagaimana perhitungan SHU bagi setiap anggota?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseKop2" data-bs-parent="#accordionKoperasiFAQ">
                    <div class="accordion-body opacity-75" style="font-size: 0.85rem; line-height: 1.65;">
                        SHU dihitung proporsional berdasarkan dua aspek utama: <strong>Jasa Modal</strong> (besarnya jumlah simpanan Anda) dan <strong>Jasa Usaha/Transaksi</strong> (keaktifan transaksi Anda di Waserda maupun produk pinjaman).
                    </div>
                </div>
            </div>

            <div class="accordion-item mb-0">
                <h2 class="accordion-header" id="faqKop3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKop3">
                        <i class="fas fa-file-medical-alt me-2 text-warning"></i> Apa saja syarat pengajuan pinjaman online?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseKop3" data-bs-parent="#accordionKoperasiFAQ">
                    <div class="accordion-body opacity-75" style="font-size: 0.85rem; line-height: 1.65;">
                        Anggota wajib telah terdaftar minimal 3 bulan, tidak memiliki tunggakan angsuran, serta mengunggah slip gaji terbaru dan dokumen persetujuan (jika plafon pinjaman di atas batas tertentu).
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
