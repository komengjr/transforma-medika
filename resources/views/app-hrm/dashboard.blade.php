@extends('layouts.layouts')

@section('content')
<style>
    /* Styling khusus agar tampilan lebih hidup dan interaktif */
    .hr-hero-banner {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #6e8efb 100%);
        border: none;
        box-shadow: 0 10px 20px rgba(30, 60, 114, 0.15);
    }

    .hover-lift {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1) !important;
    }

    /* Gradient backgrounds untuk ikon modul */
    .bg-gradient-primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
    }

    .bg-gradient-success {
        background: linear-gradient(45deg, #1cc88a, #13855c);
    }

    .bg-gradient-warning {
        background: linear-gradient(45deg, #f6c23e, #dda20a);
    }

    .bg-gradient-info {
        background: linear-gradient(45deg, #36b9cc, #258391);
    }

    .bg-gradient-danger {
        background: linear-gradient(45deg, #e74a3b, #be2617);
    }

    .bg-gradient-purple {
        background: linear-gradient(45deg, #8e44ad, #6c3483);
    }

    .module-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
</style>

<!-- 1. HERO BANNER MODERN -->
<div class="card hr-hero-banner text-white mb-4 overflow-hidden position-relative">
    <div class="card-body p-4 p-lg-5 position-relative z-index-1">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge bg-soft-light text-warning mb-3 px-3 py-2 rounded-pill fs--1">
                    <i class="fas fa-sparkles me-1 text-warning"></i> Portal Resmi HRIS Internal
                </span>
                <h2 class="text-white fw-bold display-5 mb-2">Selamat Datang di Portal HR! 👋</h2>
                <p class="lead opacity-85 mb-4 fs-0">
                    Pusat kendali mandiri untuk mengelola kebutuhan karir, absensi, cuti, serta slip gaji Anda dengan transparan dan efisien.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#modul-hr" class="btn btn-light text-primary fw-bold rounded-pill px-4 shadow-sm">
                        <i class="fas fa-th-large me-2"></i>Jelajahi Modul
                    </a>
                    <a href="#faq-hr" class="btn btn-outline-light rounded-pill px-4">
                        <i class="fas fa-question-circle me-2"></i>Pusat Bantuan
                    </a>
                </div>
            </div>
            <!-- Gambar Ilustrasi HR / Tim Kreatif -->
            <div class="col-lg-5 text-center d-none d-lg-block">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=600&q=80"
                    alt="Human Resource Team"
                    class="img-fluid rounded-3 shadow-lg border border-3 border-white position-relative"
                    style="max-height: 240px; object-fit: cover; transform: rotate(1deg);">
            </div>
        </div>
    </div>
</div>

<!-- 2. QUICK STATS / INFORMATION CARDS -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-primary border-start border-4 border-primary">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Sisa Cuti Tahunan</h6>
                    <h3 class="mb-0 text-primary fw-bold">12 <span class="fs--1 text-500">Hari</span></h3>
                </div>
                <div class="avatar avatar-lg bg-soft-primary text-primary rounded-circle">
                    <i class="fas fa-calendar-check fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-success border-start border-4 border-success">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Status Kehadiran</h6>
                    <h3 class="mb-0 text-success fw-bold">Tepat Waktu</h3>
                </div>
                <div class="avatar avatar-lg bg-soft-success text-success rounded-circle">
                    <i class="fas fa-user-clock fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-warning border-start border-4 border-warning">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Pengajuan Pending</h6>
                    <h3 class="mb-0 text-warning fw-bold">1 <span class="fs--1 text-500">Dokumen</span></h3>
                </div>
                <div class="avatar avatar-lg bg-soft-warning text-warning rounded-circle">
                    <i class="fas fa-hourglass-half fs-1"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-info border-start border-4 border-info">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Periode Gaji</h6>
                    <h3 class="mb-0 text-info fw-bold">Agustus 2026</h3>
                </div>
                <div class="avatar avatar-lg bg-soft-info text-info rounded-circle">
                    <i class="fas fa-receipt fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. MODUL-MODUL PERKENALAN HR -->
<div class="d-flex align-items-center justify-content-between mb-3" id="modul-hr">
    <div>
        <h4 class="mb-0 text-800 fw-bold"><i class="fas fa-cubes text-primary me-2"></i>Modul Layanan HR</h4>
        <p class="text-600 fs--1 mb-0">Pilih modul di bawah untuk mengakses layanan lengkap Human Resources.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Modul 1: Profil & Data Karyawan -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center mb-3">
                    <div class="module-icon bg-gradient-primary text-white me-3">
                        <i class="fas fa-id-card fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Profil & Data Diri</h5>
                        <span class="badge bg-soft-primary text-primary fs--2">Employee Self Service</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Kelola biodata diri, riwayat pendidikan, keluarga, serta unggah dokumen resmi secara mandiri dan cepat.</p>
                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold">
                    Buka Profil <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 2: Absensi & Presensi -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center mb-3">
                    <div class="module-icon bg-gradient-success text-white me-3">
                        <i class="fas fa-fingerprint fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Presensi & Jam Kerja</h5>
                        <span class="badge bg-soft-success text-success fs--2">Real-time Clock-in</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Catat jam masuk/keluar harian, pengajuan koreksi presensi, lembur, dan riwayat kehadiran bulanan Anda.</p>
                <a href="#" class="btn btn-outline-success btn-sm rounded-pill w-100 fw-bold">
                    Lihat Absensi <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 3: Cuti & Perizinan -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center mb-3">
                    <div class="module-icon bg-gradient-warning text-white me-3">
                        <i class="fas fa-plane-departure fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Manajemen Cuti</h5>
                        <span class="badge bg-soft-warning text-warning fs--2">Sistem Persetujuan</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Pengajuan cuti tahunan, sakit, izin khusus, serta pantau alur persetujuan dari atasan secara langsung.</p>
                <a href="#" class="btn btn-outline-warning btn-sm rounded-pill w-100 fw-bold">
                    Ajukan Cuti <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 4: Payroll & Slip Gaji -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center mb-3">
                    <div class="module-icon bg-gradient-info text-white me-3">
                        <i class="fas fa-wallet fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Payroll & Slip Gaji</h5>
                        <span class="badge bg-soft-info text-info fs--2">Kerahasiaan Terjamin</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Unduh slip gaji digital bulanan, cek rincian tunjangan, insentif, potongan BPJS, dan PPh 21 secara rinci.</p>
                <a href="#" class="btn btn-outline-info btn-sm rounded-pill w-100 fw-bold">
                    Unduh Slip Gaji <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 5: Penilaian Kinerja / KPI -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center mb-3">
                    <div class="module-icon bg-gradient-purple text-white me-3">
                        <i class="fas fa-chart-line fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Performa & KPI</h5>
                        <span class="badge bg-soft-primary text-primary fs--2">Performance Review</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Pantau target kinerja semesteran, ikuti penilaian mandiri (self-assessment), dan lihat hasil ulasan kinerja.</p>
                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold">
                    Cek Kinerja <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 6: Pelatihan & Development -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4 position-relative">
                <div class="d-flex align-items-center mb-3">
                    <div class="module-icon bg-gradient-danger text-white me-3">
                        <i class="fas fa-graduation-cap fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Pengembangan & Pelatihan</h5>
                        <span class="badge bg-soft-danger text-danger fs--2">Skill Building</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Akses program pelatihan internal, sertifikasi, dan jadwalkan sesi workshop penunjang karir Anda.</p>
                <a href="#" class="btn btn-outline-danger btn-sm rounded-pill w-100 fw-bold">
                    Ikuti Pelatihan <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 4. BANNER INFORMASI BUDAYA PERUSAHAAN (GAMBAR VISUAL) -->
<div class="card border-0 shadow-sm mb-4 overflow-hidden">
    <div class="row g-0">
        <div class="col-md-5">
            <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=800&q=80"
                alt="Budaya Kerja Perusahaan"
                class="img-fluid h-100 w-100"
                style="object-fit: cover; min-height: 200px;">
        </div>
        <div class="col-md-7 d-flex align-items-center bg-soft-light">
            <div class="card-body p-4">
                <span class="badge bg-success mb-2">Budaya Kerja Kami</span>
                <h4 class="fw-bold mb-2">Tumbuh Bersama & Menginspirasi</h4>
                <p class="text-600 fs--1 mb-3">
                    Kami percaya bahwa kesuksesan perusahaan berawal dari kebahagiaan dan produktivitas setiap individu di dalamnya. Pastikan dokumen dan performa Anda selalu terbarukan melalui sistem HRIS ini.
                </p>
                <a href="#" class="btn btn-primary btn-sm rounded-pill px-4">Lihat Kegiatan Tim</a>
            </div>
        </div>
    </div>
</div>

<!-- 5. ACCORDION FAQ INTERAKTIF -->
<div class="card border-0 shadow-sm mb-3" id="faq-hr">
    <div class="card-header bg-white border-bottom p-3">
        <div class="d-flex align-items-center">
            <div class="avatar avatar-md bg-soft-info text-info rounded-circle me-2">
                <i class="fas fa-question-circle"></i>
            </div>
            <h5 class="mb-0 fw-bold">Pertanyaan yang Sering Diajukan (FAQ)</h5>
        </div>
    </div>
    <div class="card-body p-3">
        <div class="accordion accordion-flush" id="accordionHRFAQS">

            <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                        <i class="fas fa-calendar-plus me-2 text-warning"></i> Bagaimana cara mengajukan cuti?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseOne" data-bs-parent="#accordionHRFAQS">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Masuk ke modul <strong>Manajemen Cuti</strong>, tentukan tanggal mulai dan selesai, pilih jenis cuti (Tahunan/Sakit/Izin Khusus), sertakan catatan untuk atasan, lalu klik <em>Kirim Pengajuan</em>.
                    </div>
                </div>
            </div>

            <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                        <i class="fas fa-shield-alt me-2 text-primary"></i> Apakah data slip gaji saya aman?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseTwo" data-bs-parent="#accordionHRFAQS">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Ya, modul <strong>Payroll</strong> dilindungi oleh enkripsi keamanan tingkat tinggi. Slip gaji hanya dapat dibuka menggunakan password akun pribadi milik Anda.
                    </div>
                </div>
            </div>

            <div class="accordion-item border rounded-3 overflow-hidden">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                        <i class="fas fa-clock me-2 text-danger"></i> Lupa melakukan Clock-In presensi harian?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseThree" data-bs-parent="#accordionHRFAQS">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Anda dapat memanfaatkan fitur <em>"Koreksi Presensi"</em> pada modul <strong>Presensi & Jam Kerja</strong> maksimal 2x24 jam dari hari H untuk disetujui oleh Supervisor/Manager Anda.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
