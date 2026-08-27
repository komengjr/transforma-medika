<!DOCTYPE html>
<html lang="id" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Registrasi | {{ $event->event_data_tittle }}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ Storage::url($event->event_data_template) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --bg-body: #0b0f19;
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --border-color: #e2e8f0;
            --text-main: #0f172a;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            min-height: 100vh;
            color: var(--text-main);
            overflow-x: hidden;
        }

        .split-container {
            min-height: 100vh;
        }

        /* --- SISI KIRI: GAMBAR HERO GLASS --- */
        .event-sidebar-hero {
            position: relative;
            background-size: cover !important;
            background-position: center !important;
            min-height: 360px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        @media (min-width: 992px) {
            .event-sidebar-hero {
                min-height: 100vh;
                position: fixed;
                top: 0;
                left: 0;
                width: 41.666667%;
            }

            .form-right-content {
                margin-left: 41.666667%;
            }
        }

        .event-sidebar-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                    rgba(11, 15, 25, 0.4) 0%,
                    rgba(11, 15, 25, 0.75) 50%,
                    rgba(11, 15, 25, 0.95) 100%);
            z-index: 1;
        }

        .hero-glow {
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(79, 70, 229, 0.4);
            filter: blur(80px);
            border-radius: 50%;
            z-index: 1;
            top: 10%;
            left: 10%;
        }

        .hero-content-wrapper {
            position: relative;
            z-index: 2;
        }

        .hero-glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 16px;
            padding: 1rem 1.25rem;
            color: #ffffff;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .badge-event-tag {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.72rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .info-pill {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            padding: 0.6rem 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #ffffff;
        }

        .info-pill-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        /* --- SISI KANAN: BACKGROUND EVENT ATMOSPHERE & FORM --- */
        .form-right-content {
            background-color: #f1f5f9;
            background-image:
                radial-gradient(at 10% 20%, rgba(79, 70, 229, 0.08) 0px, transparent 40%),
                radial-gradient(at 90% 80%, rgba(14, 165, 233, 0.08) 0px, transparent 40%),
                radial-gradient(at 50% 50%, rgba(236, 72, 153, 0.05) 0px, transparent 50%),
                radial-gradient(#cbd5e1 0.8px, transparent 0.8px);
            background-size: 100% 100%, 100% 100%, 100% 100%, 20px 20px;
            min-height: 100vh;
        }

        .form-card-container {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 15px 35px -10px rgba(15, 23, 42, 0.08);
            padding: 1.75rem 2rem;
        }

        @media (max-width: 576px) {
            .form-card-container {
                padding: 1.25rem 1.25rem;
                border-radius: 16px;
            }
        }

        .custom-form-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            color: #475569;
            margin-bottom: 0.25rem;
        }

        .form-control-custom,
        .form-select-custom {
            border-radius: 10px;
            border: 1.5px solid var(--border-color);
            padding: 0.55rem 0.85rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            background-color: #f8fafc;
        }

        .form-control-custom:focus,
        .form-select-custom:focus {
            background-color: #ffffff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
            outline: none;
        }

        /* --- REDESIGN DESAIN TIKET & PAYMENT UI --- */
        .ticket-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            overflow: hidden;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .ticket-card.disabled-ticket {
            opacity: 0.55;
            background: #f8fafc;
        }

        .ticket-card:not(.disabled-ticket):hover {
            border-color: #cbd5e1;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.05);
        }

        .ticket-card.active {
            border-color: var(--primary-color);
            box-shadow: 0 8px 20px -4px rgba(79, 70, 229, 0.15);
        }

        .ticket-header-label {
            padding: 1rem 1.15rem;
            cursor: pointer;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            user-select: none;
        }

        .ticket-card.active .ticket-header-label {
            background: rgba(79, 70, 229, 0.02);
        }

        .ticket-icon-box {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #f1f5f9;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .ticket-card.active .ticket-icon-box {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary-color);
        }

        .ticket-badge-tag {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 3px 8px;
            border-radius: 6px;
            background: #f1f5f9;
            color: #64748b;
            transition: all 0.2s ease;
        }

        .ticket-card.active .ticket-badge-tag {
            background: var(--primary-color);
            color: #ffffff;
        }

        .class-accordion-wrapper {
            background: #f8fafc;
            border-top: 1px dashed #e2e8f0;
            padding: 1rem;
        }

        .class-option-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 0.9rem;
            margin-bottom: 0.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease;
        }

        .class-option-card:hover {
            border-color: #cbd5e1;
            transform: translateY(-1px);
        }

        .class-option-card.active {
            border-color: var(--primary-color);
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.08);
        }

        .badge-price-paid {
            background: #eef2ff;
            color: var(--primary-color);
            border: 1px solid #c7d2fe;
            font-weight: 800;
            font-size: 0.8rem;
            padding: 4px 10px;
            border-radius: 8px;
        }

        .badge-price-free {
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
            font-weight: 800;
            font-size: 0.8rem;
            padding: 4px 10px;
            border-radius: 8px;
        }

        .btn-register-submit {
            background: var(--primary-color);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 0.85rem 1.25rem;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.25);
        }

        .btn-register-submit:hover {
            background: var(--primary-hover);
            color: #ffffff;
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0">
        <div class="row g-0 split-container">

            <!-- ================= SISI KIRI: GAMBAR + INFORMASI EVENT MODERN ================= -->
            <div class="col-lg-5 event-sidebar-hero p-4 p-md-5"
                style='background: url("{{ Storage::url($event->event_data_template) }}") no-repeat center center / cover;'>

                <div class="hero-glow"></div>

                <!-- TOP INFORMASI: BADGE & JUDUL -->
                <div class="hero-content-wrapper mb-3">
                    <div class="d-inline-block mb-2">
                        <span class="badge-event-tag">
                            <i class="bi bi-stars text-warning me-1"></i> Official Event
                        </span>
                    </div>

                    <h2 class="fw-extrabold text-white mb-2" style="letter-spacing: -0.6px; line-height: 1.25; font-size: 1.75rem;">
                        {{ $event->event_data_tittle }}
                    </h2>

                    <p class="text-white-50 fs-7 mb-0 d-none d-sm-block" style="line-height: 1.5;">
                        {{ Str::limit(strip_tags($event->event_data_desc), 140) }}
                    </p>
                </div>

                <!-- BOTTOM INFORMASI: DETAIL WAKTU & LOKASI -->
                <div class="hero-content-wrapper mt-auto pt-2">
                    <div class="row g-2 mb-2">
                        <div class="col-12">
                            <div class="info-pill">
                                <div class="info-pill-icon text-warning">
                                    <i class="bi bi-calendar2-week"></i>
                                </div>
                                <div>
                                    <small class="d-block text-white-50 fs-8">Waktu Pelaksanaan</small>
                                    <span class="fw-bold fs-7 text-white">
                                        {{ \Carbon\Carbon::parse($event->event_data_start_date)->translatedFormat('d F Y, H:i') }} WIB
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="info-pill">
                                <div class="info-pill-icon text-info">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div>
                                    <small class="d-block text-white-50 fs-8">Lokasi Acara</small>
                                    <span class="fw-bold fs-7 text-white">
                                        {{ $event->event_data_venue }}, {{ $event->event_data_city }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hero-glass-card">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-shield-check text-success fs-6"></i>
                            <span class="fs-8 text-white-50">E-Sertifikat & Access Card QR Code Instan</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ================= SISI KANAN: FORM MULTI-REGISTRASI EVENT ================= -->
            <div class="col-lg-7 form-right-content p-3 p-md-4 d-flex flex-column justify-content-center">

                <div class="mx-auto style-form-wrapper" style="max-width: 680px; width: 100%;">

                    <!-- CARD UTAMA FORM -->
                    <div class="form-card-container">
                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                            <div>
                                <h4 class="fw-bold text-dark m-0" style="letter-spacing: -0.4px;">Form Pendaftaran</h4>
                                <small class="text-muted fs-8">Pilih tiket sub-event yang ingin Anda ikuti.</small>
                            </div>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 fs-8">
                                <i class="bi bi-ticket-perforated me-1"></i> Event Pass
                            </span>
                        </div>

                        <form id="registerForm" action="{{ route('event.register.store', $event->event_data_code) }}" method="POST">
                            @csrf

                            <!-- DATA DIRI PESERTA -->
                            <div class="row g-2 mb-3">

                                <!-- Gelar Depan (Opsional) -->
                                <div class="col-md-3">
                                    <label class="custom-form-label"><small>Gelar Depan</small></label>
                                    <input type="text" class="form-control form-control-custom" id="front_title" name="front_title" value="{{ old('front_title') }}" placeholder="Dr. / Prof.">
                                </div>

                                <!-- Nama Lengkap (Wajib) -->
                                <div class="col-md-6">
                                    <label class="custom-form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-custom participant-input" id="full_name" name="full_name" value="{{ old('full_name') }}" placeholder="Ahmad Wijaya" required>
                                </div>

                                <!-- Gelar Belakang (Opsional) -->
                                <div class="col-md-3">
                                    <label class="custom-form-label"><small>Gelar Belakang</small> </label>
                                    <input type="text" class="form-control form-control-custom" id="back_title" name="back_title" value="{{ old('back_title') }}" placeholder="S.Kom., M.T.">
                                </div>

                                <!-- Email (Wajib) -->
                                <div class="col-md-6">
                                    <label class="custom-form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control form-control-custom participant-input" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                                </div>

                                <!-- No WhatsApp (Wajib) -->
                                <div class="col-md-6">
                                    <label class="custom-form-label">No. WhatsApp <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control form-control-custom participant-input" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" placeholder="08123456789" required>
                                </div>

                                <!-- Jenis Kelamin (Opsional) -->
                                <div class="col-md-6">
                                    <label class="custom-form-label">Jenis Kelamin <span class="text-muted fw-normal fs-8">(Opsional)</span></label>
                                    <select class="form-select form-select-custom" name="gender">
                                        <option value="" selected>-- Pilih --</option>
                                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                <!-- No. Identitas NIK/Paspor (Opsional) -->
                                <div class="col-md-6">
                                    <label class="custom-form-label">NIK / Paspor <span class="text-muted fw-normal fs-8">(Opsional)</span></label>
                                    <input type="text" class="form-control form-control-custom" name="identity_number" value="{{ old('identity_number') }}" placeholder="3201234567890001">
                                </div>

                                <!-- Instansi / Sekolah (Opsional) -->
                                <div class="col-12">
                                    <label class="custom-form-label">Instansi / Perusahaan <span class="text-muted fw-normal fs-8">(Opsional)</span></label>
                                    <input type="text" class="form-control form-control-custom" name="institution" value="{{ old('institution') }}" placeholder="Contoh: Universitas Indonesia / PT. Falcon">
                                </div>

                                <!-- Alamat (Opsional) -->
                                <div class="col-12">
                                    <label class="custom-form-label">Alamat Lengkap <span class="text-muted fw-normal fs-8">(Opsional)</span></label>
                                    <textarea class="form-control form-control-custom" name="address" rows="2" placeholder="Alamat domisili atau instansi">{{ old('address') }}</textarea>
                                </div>
                            </div>

                            <!-- INFORMASI INFO ISI DATA DIRI -->
                            <div id="fillDataWarning" class="alert alert-warning border-0 fs-8 mb-3 rounded-3 py-2 px-3 d-flex align-items-center gap-2">
                                <i class="bi bi-info-circle-fill fs-6"></i>
                                <span>Silakan isi <strong>Nama Lengkap, Email, dan No. WhatsApp</strong> di atas untuk membuka opsi tiket Sub Event.</span>
                            </div>

                            <!-- SELEKSI SUB EVENT & KELAS (REDESIGN TIKET CHECKOUT) -->
                            <div class="mb-4">
                                <label class="custom-form-label d-block mb-1">Pilihan Tiket Sub Event <span class="text-danger">*</span></label>
                                <small class="text-muted fs-8 d-block mb-2.5">Centang tiket sub-event yang ingin diikuti, lalu tentukan pilihan sesi/kelas di dalamnya.</small>

                                <div class="d-flex flex-column gap-3">
                                    @forelse ($subevent as $sub)
                                    <div class="ticket-card disabled-ticket" id="ticket-card-{{ $sub->event_data_sub_code }}">
                                        <!-- Card Header Subevent -->
                                        <label class="ticket-header-label" for="sub-{{ $sub->event_data_sub_code }}">
                                            <div class="d-flex align-items-center gap-3">
                                                <input class="form-check-input subevent-checkbox m-0" type="checkbox" name="sub_event_codes[]" id="sub-{{ $sub->event_data_sub_code }}" value="{{ $sub->event_data_sub_code }}" disabled style="width: 1.25em; height: 1.25em; cursor: pointer;">
                                                <div class="ticket-icon-box">
                                                    <i class="bi bi-ticket-perforated"></i>
                                                </div>
                                                <div>
                                                    <div class="d-flex align-items-center gap-2 mb-0.5">
                                                        <strong class="text-dark fs-7 mb-0">{{ $sub->event_data_sub_name }}</strong>
                                                        <span class="ticket-badge-tag">Pilihan Tiket</span>
                                                    </div>
                                                    <small class="text-muted fs-8 d-block">
                                                        <i class="bi bi-clock me-1 text-primary"></i>
                                                        {{ \Carbon\Carbon::parse($sub->event_data_sub_start)->format('H:i') }} - {{ \Carbon\Carbon::parse($sub->event_data_sub_end)->format('H:i') }} WIB
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="text-end ms-2">
                                                <i class="bi bi-chevron-down text-muted icon-chevron transition-transform"></i>
                                            </div>
                                        </label>

                                        <!-- Detail Kelas / Sesi Tiket -->
                                        <div class="class-accordion-wrapper d-none" id="class-container-{{ $sub->event_data_sub_code }}">
                                            <div class="d-flex align-items-center justify-content-between mb-2 px-1">
                                                <span class="custom-form-label m-0 text-secondary fs-8 ms-2">Pilih Sesi / Kelas Tiket:</span>
                                            </div>
                                            <div class="row g-2">
                                                @php
                                                $hasClasses = false;
                                                @endphp
                                                @foreach($classes as $cls)
                                                @if($cls->event_data_sub_code == $sub->event_data_sub_code && ($cls->event_data_sub_class_type ?? '') !== 'hide')
                                                @php
                                                $hasClasses = true;
                                                $price = $cls->event_data_sub_class_price ?? 0;
                                                @endphp
                                                <div class="col-12">
                                                    <label class="class-option-card mb-0" for="class-{{ $cls->id_event_data_sub_class }}">
                                                        <div class="d-flex align-items-center gap-2.5">
                                                            <input class="form-check-input class-checkbox m-0 me-4" type="checkbox" name="class_ids[{{ $sub->event_data_sub_code }}][]" id="class-{{ $cls->id_event_data_sub_class }}" value="{{ $cls->id_event_data_sub_class }}" data-price="{{ $price }}" style="width: 1.1em; height: 1.1em; cursor: pointer;">
                                                            <div>
                                                                <strong class="d-block text-dark fs-7" style="line-height: 1.2;">{{ $cls->event_data_sub_class_name }}</strong>
                                                                <small class="text-muted fs-8">
                                                                    <i class="bi bi-door-open me-1"></i>Ruang: {{ $cls->event_data_sub_class_room ?? '-' }}
                                                                    <span class="mx-1">•</span>
                                                                    <i class="bi bi-people me-1"></i>Sisa Kuota: {{ $cls->event_data_sub_class_kuota }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="ms-2">
                                                            @if($price > 0)
                                                            <span class="badge-price-paid">
                                                                Rp {{ number_format($price, 0, ',', '.') }}
                                                            </span>
                                                            @else
                                                            <span class="badge-price-free">
                                                                Gratis
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </label>
                                                </div>
                                                @endif
                                                @endforeach

                                                @if(!$hasClasses)
                                                <div class="col-12">
                                                    <div class="alert alert-light border fs-8 m-0 rounded-3 py-2 px-3 text-muted">
                                                        <i class="bi bi-check-circle me-1 text-success"></i> Sub Event ini tidak membutuhkan pemilihan kelas (Otomatis Terdaftar).
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-12">
                                        <div class="alert alert-warning border-0 fs-8 m-0 rounded-3 py-2 px-3">
                                            Belum ada agenda Sub Event yang tersedia.
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- AREA SUBMIT & KETENTUAN (RINGKASAN PEMBAYARAN) -->
                            <div id="submitSection" class="d-none">
                                <div class="p-3 mb-3 rounded-3" style="background: #f8fafc; border: 1.5px dashed #cbd5e1;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="fw-bold text-secondary fs-7 d-block">Ringkasan Pembayaran</span>
                                            <small class="text-muted fs-8">Total estimasi biaya tiket yang terpilih</small>
                                        </div>
                                        <h3 class="fw-extrabold text-primary m-0" id="displayTotal">Rp 0</h3>
                                    </div>
                                </div>

                                <!-- KETENTUAN -->
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="terms" id="termsCheck" required style="cursor: pointer;">
                                    <label class="form-check-label fs-8 text-muted" for="termsCheck">
                                        Saya menyetujui seluruh syarat & ketentuan pendaftaran acara ini.
                                    </label>
                                </div>

                                <!-- SUBMIT BUTTON WITH LOADING ANIMATION -->
                                <button class="btn btn-register-submit w-100" type="submit" id="btnSubmit">
                                    <span id="btnText">
                                        <i class="bi bi-credit-card-2-front me-2"></i> Selesaikan Pendaftaran
                                    </span>
                                    <span id="btnSpinner" class="d-none">
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Memproses Pendaftaran...
                                    </span>
                                </button>
                            </div>

                        </form>
                    </div>
                    <!-- END FORM CARD CONTAINER -->

                </div>

            </div>
        </div>
    </div>

    <!-- JS LOGIC MULTI-SELEKSI SUB EVENT & KALKULASI HARGA -->
    <script>
        $(document).ready(function() {

            // --- SWEETALERT NOTIFICATION HANDLER ---
            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Pendaftaran Berhasil!',
                html: `
                        <div class="text-center">
                            <p class="mb-2">{{ session('success') }}</p>
                            @if(session('registration_code'))
                                <div class="alert alert-light border my-2 py-2">
                                    <small class="text-muted d-block">Nomor Registrasi Anda:</small>
                                    <strong class="fs-5 text-primary">{{ session('registration_code') }}</strong>
                                </div>
                            @endif
                            <p class="small text-muted mb-0">Silakan cek email Anda untuk informasi lebih detail dan tiket registrasi.</p>
                        </div>
                    `,
                confirmButtonText: 'Saya Mengerti',
                confirmButtonColor: '#4f46e5'
            });
            @endif

            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Pendaftaran Gagal',
                text: "{{ session('error') }}",
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#ef4444'
            });
            @endif

            // --- FUNGSI CEK KELENGKAPAN DATA DIRI WAJIB ---
            function checkParticipantData() {
                let name = $('#full_name').val().trim();
                let email = $('#email').val().trim();
                let phone = $('#phone_number').val().trim();

                if (name !== '' && email !== '' && phone !== '') {
                    $('.subevent-checkbox').prop('disabled', false);
                    $('.ticket-card').removeClass('disabled-ticket');
                    $('#fillDataWarning').addClass('d-none');
                } else {
                    $('.subevent-checkbox').prop('disabled', true).prop('checked', false);
                    $('.ticket-card').addClass('disabled-ticket').removeClass('active');
                    $('.class-checkbox').prop('checked', false);
                    $('.class-option-card').removeClass('active');
                    $('.class-accordion-wrapper').addClass('d-none');

                    $('#submitSection').addClass('d-none');
                    $('#fillDataWarning').removeClass('d-none');
                    calculateTotal();
                }
            }

            $('.participant-input').on('input change', function() {
                checkParticipantData();
            });

            checkParticipantData();

            // --- TOGGLE SUB EVENT CHECKBOX ---
            $('.subevent-checkbox').change(function() {
                let subCode = $(this).val();
                let card = $('#ticket-card-' + subCode);
                let container = $('#class-container-' + subCode);

                if ($(this).is(':checked')) {
                    card.addClass('active');
                    container.removeClass('d-none');
                } else {
                    card.removeClass('active');
                    container.addClass('d-none');
                    container.find('.class-checkbox').prop('checked', false);
                    container.find('.class-option-card').removeClass('active');
                }

                checkSubmitVisibility();
                calculateTotal();
            });

            // --- TOGGLE KELAS CHECKBOX ---
            $(document).on('change', '.class-checkbox', function() {
                if ($(this).is(':checked')) {
                    $(this).closest('.class-option-card').addClass('active');
                } else {
                    $(this).closest('.class-option-card').removeClass('active');
                }

                checkSubmitVisibility();
                calculateTotal();
            });

            // --- CEK KAPAN AREA SUBMIT TAMPIL ---
            function checkSubmitVisibility() {
                let anyChecked = $('.subevent-checkbox:checked').length > 0;
                if (anyChecked) {
                    $('#submitSection').removeClass('d-none');
                } else {
                    $('#submitSection').addClass('d-none');
                }
            }

            // --- HITUNG TOTAL HARGA SELURUH KELAS ---
            function calculateTotal() {
                let total = 0;
                $('.class-checkbox:checked').each(function() {
                    let price = parseFloat($(this).data('price')) || 0;
                    total += price;
                });

                if (total > 0) {
                    let formatted = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0
                    }).format(total);
                    $('#displayTotal').text(formatted);
                } else {
                    $('#displayTotal').text('Rp 0');
                }
            }

            // --- HANDLE FORM SUBMIT & LOADING ANIMATION ---
            $('#registerForm').on('submit', function() {
                const $btn = $('#btnSubmit');
                $btn.prop('disabled', true);
                $('#btnText').addClass('d-none');
                $('#btnSpinner').removeClass('d-none');
            });

        });
    </script>
</body>

</html>
