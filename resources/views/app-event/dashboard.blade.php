@extends('layouts.layouts')

@section('content')
<style>
    /* Custom Styling Dashboard Event Management */
    .event-hero {
        background: linear-gradient(135deg, #4c1d95 0%, #6d28d9 50%, #8b5cf6 100%);
        border: none;
        box-shadow: 0 10px 20px rgba(109, 40, 217, 0.25);
    }

    .hover-lift {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1) !important;
    }

    .event-icon-box {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .bg-gradient-violet {
        background: linear-gradient(45deg, #7c3aed, #6d28d9);
    }

    .bg-gradient-fuchsia {
        background: linear-gradient(45deg, #d946ef, #c026d3);
    }

    .bg-gradient-amber {
        background: linear-gradient(45deg, #f59e0b, #d97706);
    }

    .bg-gradient-teal {
        background: linear-gradient(45deg, #14b8a6, #0d9488);
    }

    .bg-gradient-rose {
        background: linear-gradient(45deg, #f43f5e, #e11d48);
    }

    .bg-gradient-sky {
        background: linear-gradient(45deg, #0ea5e9, #0284c7);
    }
</style>

<!-- 1. HERO HEADER EVENT MANAGEMENT -->
<div class="card event-hero text-white mb-4 overflow-hidden position-relative">
    <div class="bg-holder d-none d-lg-block bg-card"
        style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); opacity: 0.15;">
    </div>
    <div class="card-body p-4 p-lg-5 position-relative z-index-1">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-soft-light text-warning mb-2 px-3 py-1 rounded-pill fs--1">
                    <i class="fas fa-calendar-star me-1 text-warning"></i> Event Management System
                </span>
                <h2 class="text-white fw-bold display-6 mb-2">Pusat Pengelolaan Event & Tiket 🎪</h2>
                <p class="lead opacity-85 mb-4 fs-0">
                    Kelola seluruh rangkaian acara, penjualan tiket online, registrasi peserta, sistem check-in scanner, hingga statistik partisipasi secara mendalam.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#modul-event" class="btn btn-light text-purple fw-bold rounded-pill px-4 shadow-sm">
                        <i class="fas fa-th-large me-2"></i>Modul Event
                    </a>
                    <a href="#tabel-event" class="btn btn-outline-light rounded-pill px-4">
                        <i class="fas fa-calendar-alt me-2"></i>Jadwal Event Terbaru
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=600&q=80"
                    alt="Event Management"
                    class="img-fluid rounded-3 shadow-lg border border-3 border-white position-relative"
                    style="max-height: 200px; object-fit: cover; transform: rotate(-2deg);">
            </div>
        </div>
    </div>
</div>

<!-- 2. SUMMARY METRICS CARDS -->
<div class="row g-3 mb-4">
    <!-- Total Event -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-primary border-start border-4 border-primary h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Total Acara</h6>
                    <h3 class="mb-0 text-primary fw-bold">24 <span class="fs--1 text-500">Event</span></h3>
                    <small class="text-500 fs--2"><i class="fas fa-calendar-check text-primary me-1"></i>Aktif & Mendatang</small>
                </div>
                <div class="avatar avatar-lg bg-soft-primary text-primary rounded-circle">
                    <i class="fas fa-calendar-day fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Peserta Terdaftar -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-info border-start border-4 border-info h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Peserta Terdaftar</h6>
                    <h3 class="mb-0 text-info fw-bold">3,850 <span class="fs--1 text-500">Orang</span></h3>
                    <small class="text-500 fs--2"><i class="fas fa-user-check text-info me-1"></i>Terverifikasi</small>
                </div>
                <div class="avatar avatar-lg bg-soft-info text-info rounded-circle">
                    <i class="fas fa-users fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tiket Terjual -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-warning border-start border-4 border-warning h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Tiket Terjual</h6>
                    <h3 class="mb-0 text-warning fw-bold">2,910 <span class="fs--1 text-500">Tiket</span></h3>
                    <small class="text-500 fs--2"><i class="fas fa-ticket-alt text-warning me-1"></i>75.5% Terjual</small>
                </div>
                <div class="avatar avatar-lg bg-soft-warning text-warning rounded-circle">
                    <i class="fas fa-tags fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendapatan Tiket -->
    <div class="col-sm-6 col-xxl-3">
        <div class="card border-0 shadow-sm hover-lift bg-soft-success border-start border-4 border-success h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-uppercase text-600 mb-1 fs--2 fw-bold">Total Pendapatan</h6>
                    <h3 class="mb-0 text-success fw-bold">Rp 345M</h3>
                    <small class="text-500 fs--2"><i class="fas fa-arrow-up text-success me-1"></i>Hasil Penjualan Tiket</small>
                </div>
                <div class="avatar avatar-lg bg-soft-success text-success rounded-circle">
                    <i class="fas fa-coins fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. MODUL UTAMA EVENT MANAGEMENT -->
<div class="d-flex align-items-center justify-content-between mb-3" id="modul-event">
    <div>
        <h4 class="mb-0 text-800 fw-bold"><i class="fas fa-th-large text-purple me-2"></i>Modul Operasional Event</h4>
        <p class="text-600 fs--1 mb-0">Fitur lengkap untuk merencanakan, mendistribusikan, dan mengeksekusi acara secara terorganisir.</p>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Modul 1: Manajemen Acara -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="event-icon-box bg-gradient-violet text-white me-3">
                        <i class="fas fa-calendar-plus fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Buat & Kelola Acara</h5>
                        <span class="badge bg-soft-primary text-primary fs--2">Event Builder</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Atur detail acara, lokasi (online/onsite), tanggal pelaksanaan, rundown, serta kategori acara.</p>
                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold">
                    Buat Event Baru <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 2: Tiket & Registrasi -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="event-icon-box bg-gradient-fuchsia text-white me-3">
                        <i class="fas fa-ticket-alt fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Penjualan Tiket</h5>
                        <span class="badge bg-soft-danger text-danger fs--2">Ticketing System</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Kelola kategori tiket (Early Bird, VIP, Regular), harga, kuota, serta kupon diskon secara fleksibel.</p>
                <a href="#" class="btn btn-outline-danger btn-sm rounded-pill w-100 fw-bold">
                    Atur Tiket <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 3: QR Check-in System -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="event-icon-box bg-gradient-teal text-white me-3">
                        <i class="fas fa-qrcode fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">QR Check-in Scanner</h5>
                        <span class="badge bg-soft-success text-success fs--2">On-site Verification</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Pindai e-ticket peserta menggunakan scanner QR code untuk kehadiran di lokasi acara secara real-time.</p>
                <a href="#" class="btn btn-outline-success btn-sm rounded-pill w-100 fw-bold">
                    Buka Scanner <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 4: Pembicara & Agenda -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="event-icon-box bg-gradient-amber text-white me-3">
                        <i class="fas fa-user-tie fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Pembicara & Agenda</h5>
                        <span class="badge bg-soft-warning text-warning fs--2">Schedule & Speakers</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Kelola profil pemateri, susunan acara (rundown), dan ruang breakout untuk konferensi/seminar.</p>
                <a href="#" class="btn btn-outline-warning btn-sm rounded-pill w-100 fw-bold">
                    Kelola Agenda <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 5: Sponsorship & Partner -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="event-icon-box bg-gradient-sky text-white me-3">
                        <i class="fas fa-handshake fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Sponsor & Partner</h5>
                        <span class="badge bg-soft-info text-info fs--2">Sponsorships</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Atur penempatan logo sponsor, tier kemitraan (Gold, Platinum), dan benefit promosi dalam event.</p>
                <a href="#" class="btn btn-outline-info btn-sm rounded-pill w-100 fw-bold">
                    Kelola Sponsor <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modul 6: Analytics & Laporan -->
    <div class="col-md-6 col-xl-4">
        <div class="card h-100 border-0 shadow-sm hover-lift overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="event-icon-box bg-gradient-rose text-white me-3">
                        <i class="fas fa-chart-line fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Laporan & Analitik</h5>
                        <span class="badge bg-soft-danger text-danger fs--2">Event Reports</span>
                    </div>
                </div>
                <p class="text-600 fs--1 mb-3">Pantau demografi peserta, tingkat kehadiran (attendance rate), dan performa penjualan tiket.</p>
                <a href="#" class="btn btn-outline-danger btn-sm rounded-pill w-100 fw-bold">
                    Lihat Analitik <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 4. TABEL RINGKASAN EVENT MENDATANG -->
<div class="card border-0 shadow-sm mb-4" id="tabel-event">
    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
        <div>
            <h6 class="mb-0 fw-bold text-800"><i class="fas fa-calendar-alt text-purple me-2"></i>Jadwal Event Mendatang</h6>
            <small class="text-muted fs--2">Daftar agenda acara yang akan dan sedang berlangsung</small>
        </div>
        <a href="#" class="btn btn-link btn-sm text-decoration-none p-0 fw-bold">Lihat Semua Event <i class="fas fa-chevron-right ms-1"></i></a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="bg-200 text-800 fs--1">
                    <tr>
                        <th class="ps-3">Nama Event</th>
                        <th>Kategori</th>
                        <th>Tanggal & Waktu</th>
                        <th>Lokasi</th>
                        <th>Kapasitas Tiket</th>
                        <th class="text-end pe-3">Status</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                    <tr>
                        <td class="ps-3">
                            <div class="fw-bold text-dark">National Tech Summit 2026</div>
                            <small class="text-muted">ID: EVT-2026-001</small>
                        </td>
                        <td><span class="badge bg-soft-primary text-primary">Konferensi</span></td>
                        <td>15 Aug 2026, 09:00 WIB</td>
                        <td>Grand Ballroom, Jakarta</td>
                        <td class="fw-bold">450 / 500 <small class="text-success">(90%)</small></td>
                        <td class="text-end pe-3"><span class="badge bg-soft-success text-success"><i class="fas fa-check-circle me-1"></i>Upcoming</span></td>
                    </tr>
                    <tr>
                        <td class="ps-3">
                            <div class="fw-bold text-dark">Workshop UI/UX Design Trends</div>
                            <small class="text-muted">ID: EVT-2026-002</small>
                        </td>
                        <td><span class="badge bg-soft-info text-info">Workshop</span></td>
                        <td>18 Aug 2026, 13:00 WIB</td>
                        <td>Online (Zoom Meeting)</td>
                        <td class="fw-bold">120 / 150 <small class="text-info">(80%)</small></td>
                        <td class="text-end pe-3"><span class="badge bg-soft-success text-success"><i class="fas fa-check-circle me-1"></i>Upcoming</span></td>
                    </tr>
                    <tr>
                        <td class="ps-3">
                            <div class="fw-bold text-dark">Logistics & Supply Chain Expo</div>
                            <small class="text-muted">ID: EVT-2026-003</small>
                        </td>
                        <td><span class="badge bg-soft-warning text-warning">Pameran</span></td>
                        <td>11 Aug 2026, 08:30 WIB</td>
                        <td>ICE BSD, Tangerang</td>
                        <td class="fw-bold">1,200 / 1,500 <small class="text-success">(80%)</small></td>
                        <td class="text-end pe-3"><span class="badge bg-soft-primary text-primary"><i class="fas fa-sync-alt me-1"></i>Ongoing</span></td>
                    </tr>
                    <tr>
                        <td class="ps-3">
                            <div class="fw-bold text-dark">Healthcare Innovation Webinar</div>
                            <small class="text-muted">ID: EVT-2026-004</small>
                        </td>
                        <td><span class="badge bg-soft-secondary text-secondary">Webinar</span></td>
                        <td>25 Aug 2026, 10:00 WIB</td>
                        <td>Online (Google Meet)</td>
                        <td class="fw-bold">45 / 200 <small class="text-muted">(22%)</small></td>
                        <td class="text-end pe-3"><span class="badge bg-soft-secondary text-secondary"><i class="fas fa-file-edit me-1"></i>Draft</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 5. ACCORDION FAQ EVENT MANAGEMENT -->
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white border-bottom p-3">
        <div class="d-flex align-items-center">
            <div class="avatar avatar-md bg-soft-primary text-primary rounded-circle me-2">
                <i class="fas fa-question-circle"></i>
            </div>
            <h5 class="mb-0 fw-bold">Pertanyaan Sering Diajukan (FAQ Event Management)</h5>
        </div>
    </div>
    <div class="card-body p-3">
        <div class="accordion accordion-flush" id="accordionEventFAQ">

            <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                <h2 class="accordion-header" id="faqEvent1">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEvent1">
                        <i class="fas fa-qrcode me-2 text-primary"></i> Bagaimana sistem pindaian QR Code e-ticket saat check-in di lokasi?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseEvent1" data-bs-parent="#accordionEventFAQ">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Setiap peserta yang berhasil mendaftar akan menerima e-ticket berisikan QR Code unik melalui email. Panitia di lokasi dapat menggunakan modul <strong>QR Check-in Scanner</strong> dari smartphone atau pemindai khusus untuk melakukan verifikasi tiket secara instan.
                    </div>
                </div>
            </div>

            <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                <h2 class="accordion-header" id="faqEvent2">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEvent2">
                        <i class="fas fa-ticket-alt me-2 text-danger"></i> Bisakah satu acara memiliki beberapa jenis/tier tiket yang berbeda?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseEvent2" data-bs-parent="#accordionEventFAQ">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Ya, Anda dapat membuat berbagai variasi tiket seperti <em>Early Bird</em>, <em>Regular</em>, <em>VIP</em>, atau tiket khusus mahasiswa dengan kuota dan periode harga yang bisa diatur secara otomatis.
                    </div>
                </div>
            </div>

            <div class="accordion-item border rounded-3 overflow-hidden">
                <h2 class="accordion-header" id="faqEvent3">
                    <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEvent3">
                        <i class="fas fa-certificate me-2 text-warning"></i> Apakah sistem mendukung penerbitan e-Sertifikat otomatis bagi peserta?
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseEvent3" data-bs-parent="#accordionEventFAQ">
                    <div class="accordion-body text-600 fs--1 bg-light">
                        Tentu. Sistem dapat dikonfigurasi untuk mengirimkan e-Sertifikat otomatis dalam bentuk PDF ke email peserta setelah acara selesai atau jika status absensi/check-in peserta telah terverifikasi.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
