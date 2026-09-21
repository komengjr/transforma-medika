<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Innoventra by Transforma</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.png') }}">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Gradasi latar belakang body: Lebih gelap & smooth (Deep Ocean & Sky Blue) */
            background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 50%, #1d4ed8 100%);
            overflow: hidden;
            position: relative;
        }

        /* === ANIMASI BALON / BUBBLE MELAYANG DI LATAR BELAKANG === */
        .bubble-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
            pointer-events: none;
        }

        .bubble {
            position: absolute;
            bottom: -150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: rise 15s infinite ease-in-out;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(2px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .bubble:nth-child(1) {
            width: 80px;
            height: 80px;
            left: 10%;
            animation-duration: 12s;
            animation-delay: 0s;
        }

        .bubble:nth-child(2) {
            width: 120px;
            height: 120px;
            left: 25%;
            animation-duration: 18s;
            animation-delay: 2s;
        }

        .bubble:nth-child(3) {
            width: 60px;
            height: 60px;
            left: 45%;
            animation-duration: 10s;
            animation-delay: 4s;
        }

        .bubble:nth-child(4) {
            width: 150px;
            height: 150px;
            left: 65%;
            animation-duration: 22s;
            animation-delay: 1s;
        }

        .bubble:nth-child(5) {
            width: 90px;
            height: 90px;
            left: 80%;
            animation-duration: 14s;
            animation-delay: 3s;
        }

        .bubble:nth-child(6) {
            width: 110px;
            height: 110px;
            left: 90%;
            animation-duration: 16s;
            animation-delay: 5s;
        }

        @keyframes rise {
            0% {
                transform: translateY(0) scale(1) rotate(0deg);
                opacity: 0;
            }

            20% {
                opacity: 0.7;
            }

            80% {
                opacity: 0.7;
            }

            100% {
                transform: translateY(-110vh) scale(1.05) rotate(360deg);
                opacity: 0;
            }
        }

        /* === DESKTOP SPLIT SCREEN LAYOUT (Gradasi Biru Gelap & Smooth) === */
        .login-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1100px;
            height: 640px;
            margin: 1.5rem;
            background: linear-gradient(135deg, #1e3a8a 0%, #031e69 60%, #085276 100%);
            backdrop-filter: blur(25px);
            border-radius: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            display: flex;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.25);
            animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px) scale(0.98);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* === SISI KIRI: Form Input & Branding === */
        .login-form-side {
            flex: 1;
            padding: 2.5rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-y: auto;
            background: transparent;
        }

        .brand-badge-pill {
            display: inline-block;
            font-weight: 700;
            font-size: 0.95rem;
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 0.3rem 1.25rem;
            border-radius: 50rem;
            color: #ffffff;
            background: rgba(0, 0, 0, 0.25);
            letter-spacing: -0.3px;
        }

        .form-card-box {
            background: transparent;
            border-radius: 1rem;
            padding: 0.5rem 0;
            width: 100%;
            margin: 0;
        }

        .brand-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin-bottom: 0.2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.82rem;
            font-weight: 500;
        }

        .form-label {
            font-weight: 600;
            color: #ffffff;
            font-size: 0.8rem;
            margin-bottom: 0.3rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
        }

        .input-group {
            border: none;
            border-radius: 0.85rem;
            overflow: hidden;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.35);
        }

        .input-group-text {
            background-color: transparent;
            border: none;
            color: #555;
            padding-left: 1rem;
            padding-right: 0.5rem;
            font-size: 0.95rem;
        }

        .form-control {
            font-family: 'Plus Jakarta Sans', sans-serif;
            border: none;
            padding: 0.7rem 0.75rem;
            font-size: 0.85rem;
            background-color: transparent !important;
            box-shadow: none !important;
            color: #222 !important;
        }

        .form-control::placeholder {
            color: #999 !important;
        }

        textarea.form-control {
            resize: none;
        }

        /* Tombol Utama Putih Bersih Menonjol */
        .btn-primary {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #ffffff !important;
            border: none;
            border-radius: 50rem !important;
            padding: 0.75rem;
            font-weight: 700;
            font-size: 0.9rem;
            color: #1e3a8a !important;
            transition: all 0.2s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .btn-primary:hover {
            background: #f8f9fa !important;
            color: #1d4ed8 !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
        }

        .contact-admin-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            margin-top: 0.75rem;
            padding: 0.6rem;
            font-size: 0.78rem;
            font-weight: 600;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.15);
            border: 1px dashed rgba(255, 255, 255, 0.5);
            border-radius: 0.85rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .contact-admin-link:hover {
            background: #ffffff;
            color: #1e3a8a;
            border-color: #ffffff;
        }

        /* === SISI KANAN: Panel Gambar Ilustrasi === */
        .login-banner-side {
            flex: 1.15;
            background-image: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1000&q=80');
            background-size: cover;
            background-position: center;
            border-radius: 2rem;
            margin: 12px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 2rem;
            overflow: hidden;
        }

        .login-banner-side::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(15, 23, 42, 0.6) 0%, transparent 60%);
            border-radius: 2rem;
        }

        .banner-content-overlay {
            position: relative;
            z-index: 2;
            color: #fff;
        }

        .otp-input-container {
            display: flex;
            justify-content: space-between;
            gap: 6px;
        }

        .otp-input {
            font-family: 'Plus Jakarta Sans', sans-serif;
            width: 38px;
            height: 42px;
            text-align: center;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 0.5rem;
            border: 2px solid #cbd5e1;
            background-color: #f8fafc;
        }

        .otp-input:focus {
            border-color: #1d4ed8;
            box-shadow: 0 0 0 0.2rem rgba(29, 78, 216, 0.25);
            background-color: #fff;
            outline: none;
        }

        /* === LOADING OVERLAY === */
        #login-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(8px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        #login-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .encryption-box {
            background: rgba(30, 41, 59, 0.95);
            border: 1px solid rgba(29, 78, 216, 0.5);
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            max-width: 380px;
            width: 90%;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);
        }

        .encryption-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(29, 78, 216, 0.2);
            border-top: 3px solid #38bdf8;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1.2rem auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .encryption-text {
            font-family: 'Fira Code', monospace;
            font-size: 0.75rem;
            color: #38bdf8;
            letter-spacing: -0.5px;
            min-height: 24px;
        }

        .encryption-title {
            color: #f8fafc;
            font-weight: 700;
            font-size: 0.98rem;
            margin-bottom: 0.2rem;
        }

        .custom-swal-popup {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border-radius: 1.5rem !important;
            padding: 2rem !important;
        }

        .custom-swal-title {
            font-weight: 800 !important;
            color: #0f172a !important;
        }

        /* Elemen khusus mobile */
        .mobile-top-banner,
        .mobile-auth-switch {
            display: none;
        }

        /* === MOBILE STYLING (Smooth Dark Ocean Gradient) === */
        @media (max-width: 992px) {
            body {
                background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 50%, #1d4ed8 100%) !important;
                height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: stretch;
                justify-content: flex-start;
                overflow-y: auto;
                padding: 0;
            }

            .login-wrapper {
                max-width: 100% !important;
                width: 100% !important;
                height: 100vh !important;
                margin: 0 !important;
                background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 50%, #1d4ed8 100%) !important;
                backdrop-filter: none !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: flex-start !important;
                border: none !important;
                overflow-y: auto !important;
            }

            .login-banner-side {
                display: none !important;
            }

            .mobile-top-banner {
                display: block;
                width: 100%;
                height: 230px;
                background-image: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80');
                background-size: cover;
                background-position: center;
                position: relative;
                border-bottom-left-radius: 45px;
                border-bottom-right-radius: 45px;
                overflow: hidden;
            }

            .mobile-top-banner::after {
                content: '';
                position: absolute;
                inset: 0;
                background: rgba(15, 23, 42, 0.4);
            }

            .login-form-side {
                flex: 1 !important;
                width: 100%;
                background: transparent !important;
                padding: 1.5rem 2rem 2rem 2rem !important;
                box-shadow: none !important;
                margin-top: 0 !important;
                border-radius: 0 !important;
            }

            .login-form-side>div:first-child,
            .brand-badge-pill,
            .brand-title,
            .subtitle {
                display: none !important;
            }

            .mobile-auth-switch {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
                padding: 0 0.5rem;
            }

            .auth-tab {
                font-size: 1.25rem;
                font-weight: 700;
                color: rgba(255, 255, 255, 0.6);
                text-decoration: none;
                position: relative;
                padding-bottom: 4px;
                transition: color 0.2s;
            }

            .auth-tab.active {
                color: #ffffff;
            }

            .auth-tab.active::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 35px;
                height: 3px;
                background-color: #ffffff;
                border-radius: 2px;
            }
        }
    </style>
</head>

<body>
    <!-- Elemen Balon-balon Melayang di Background Body -->
    <div class="bubble-bg">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

    <!-- Layar Overlay Loading -->
    <div id="login-overlay">
        <div class="encryption-box">
            <div class="encryption-spinner" id="overlaySpinner"></div>
            <div class="encryption-title" id="overlayTitle">Autentikasi Sistem</div>
            <div id="encryptionStatus" class="encryption-text">Memulakan sambungan selamat...</div>
        </div>
    </div>

    <!-- UTAMA: Wrapper Desktop Split Screen & Mobile Full-Screen -->
    <div class="login-wrapper">

        <!-- Banner Gambar Khusus Tampilan Mobile di Bagian Atas -->
        <div class="mobile-top-banner"></div>

        <!-- SISI KIRI: Form Input & Login -->
        <div class="login-form-side">
            <!-- Bagian Atas Desktop: Logo & Sambutan -->
            <div>
                <div class="mb-3">
                    <span class="brand-badge-pill">Innoventra Solusi Digital</span>
                </div>
                <div class="brand-title">Welcome Back</div>
                <div class="subtitle">Sila masukkan akses akaun anda untuk meneruskan</div>
            </div>

            <!-- Tab Navigasi Sign In / Sign Up Khusus Mobile -->
            <div class="mobile-auth-switch">
                <a href="#" class="auth-tab active">Sign In</a>
                <!-- <a href="#" class="auth-tab" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">Sign up</a> -->
            </div>

            <!-- BAGIAN CARD FORM -->
            <div class="form-card-box my-2">
                <form id="loginForm">
                    <div class="mb-3 text-start">
                        <label for="username" class="form-label d-none d-lg-block">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="text" id="username" class="form-control" placeholder="Email Address / Username" required autocomplete="username">
                        </div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="password" class="form-label d-none d-lg-block">Kata Sandi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" id="password" class="form-control" placeholder="Password" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe">
                            <label for="rememberMe" class="form-check-label text-white text-lg-white small fw-medium" style="font-size: 0.78rem;">Ingat saya</label>
                        </div>
                        <a href="#" class="text-decoration-none text-white text-lg-white fw-semibold" style="font-size: 0.78rem;" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">Forget Password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        Sign In / Masuk
                    </button>

                    <!-- Tombol Hubungi Admin -->
                    <a href="javascript:void(0)" class="contact-admin-link" data-bs-toggle="modal" data-bs-target="#modalHubungiAdmin">
                        <i class="bi bi-headset text-info"></i> Hubungi Admin Sistem
                    </a>
                </form>
            </div>

            <!-- Bagian Bawah: Footer -->
            <div class="text-center mt-3">
                <span id="notifikasi-login" class="d-none"></span>
                <span class="text-white opacity-75" style="font-size: 0.72rem;">&copy; 2026 Innoventra by Transforma &middot; Syarat & Ketentuan</span>
            </div>
        </div>

        <!-- SISI KANAN: Panel Gambar Ilustrasi Profesional (Desktop) -->
        <div class="login-banner-side d-none d-md-flex">
            <div class="banner-content-overlay">
                <span class="badge bg-dark bg-opacity-60 px-3 py-2 rounded-pill mb-2 border border-light border-opacity-25" style="font-size: 0.75rem;">
                    <i class="bi bi-shield-check-fill text-info"></i> Secure Enterprise Portal v2.6
                </span>
                <h5 class="fw-bold mb-1" style="font-size: 1.15rem;">Transformasi Digital Perusahaan</h5>
                <p class="text-white-50 mb-0" style="font-size: 0.78rem;">Kelola operasional dan data perusahaan secara real-time dan terintegrasi.</p>
            </div>
        </div>

    </div>

    <!-- ================= MODAL HUBUNGI ADMIN SISTEM ================= -->
    <div class="modal fade" id="modalHubungiAdmin" tabindex="-1" aria-labelledby="modalHubungiAdminLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                <div class="modal-header border-0 text-center flex-column pb-0 pt-4" style="background: linear-gradient(135deg, rgba(29, 78, 216, 0.08), rgba(0, 0, 0, 0.02));">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="p-3 bg-white rounded-circle shadow-sm mb-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-headset text-primary fs-4"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark mt-1">Pusat Bantuan Admin</h5>
                    <p class="text-muted small px-3" style="font-size: 0.82rem;">Sampaikan kendala atau pertanyaan Anda kepada tim pengelola sistem.</p>
                </div>
                <div class="modal-body p-4">
                    <form id="formHubungiAdmin">
                        <div class="mb-3 text-start">
                            <label for="contact_name" class="form-label text-dark">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" id="contact_name" class="form-control" placeholder="Masukkan nama Anda" required>
                            </div>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="contact_email" class="form-label text-dark">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" id="contact_email" class="form-control" placeholder="email@domain.com" required>
                            </div>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="contact_desc" class="form-label text-dark">Deskripsi / Kendala</label>
                            <div class="input-group">
                                <span class="input-group-text align-items-start pt-2"><i class="bi bi-chat-left-text"></i></span>
                                <textarea id="contact_desc" class="form-control" rows="4" placeholder="Jelaskan kendala atau pesan Anda secara detail..." required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 mt-2 rounded-3 text-white" style="background: #1d4ed8 !important; border: none;">
                            <i class="bi bi-send-fill me-2"></i>Kirim Pesan ke Admin
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= MODAL LUPA & RESET PASSWORD ================= -->
    <div class="modal fade" id="modalLupaPassword" tabindex="-1" aria-labelledby="modalLupaPasswordLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                <div class="modal-header border-0 text-center flex-column pb-0 pt-4" style="background: linear-gradient(135deg, rgba(29, 78, 216, 0.08), rgba(0, 0, 0, 0.02));">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="p-3 bg-white rounded-circle shadow-sm mb-2 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i id="modalHeaderIcon" class="bi bi-shield-lock-fill text-primary fs-4"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark mt-1" id="modalTitleText">Reset Password</h5>
                    <p class="text-muted small px-3" id="modalSubTitleText" style="font-size: 0.82rem;">Masukkan email terdaftar untuk menerima kode verifikasi OTP.</p>
                </div>

                <div class="modal-body p-4 text-center">
                    <div id="step-email">
                        <form id="formKirimOtp">
                            <div class="mb-3 text-start">
                                <label for="email" class="form-label text-dark">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" id="email" class="form-control" placeholder="contoh@email.com" required>
                                </div>
                            </div>
                            <button type="submit" id="btnKirimOtp" class="btn btn-dark w-100 mt-2 rounded-3 text-white" style="background: #1d4ed8 !important; border: none;">
                                <i class="bi bi-send me-2"></i>Kirim Kode OTP
                            </button>
                        </form>
                    </div>

                    <div id="step-otp" style="display: none;">
                        <p class="text-muted small mb-2" style="font-size: 0.83rem;">Kode OTP 6 digit telah dikirim ke email <strong id="displayEmailText" class="text-dark"></strong>.</p>
                        <form id="formVerifikasiOtp">
                            <div class="otp-input-container my-3">
                                <input type="text" class="form-control otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                                <input type="text" class="form-control otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                                <input type="text" class="form-control otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                                <input type="text" class="form-control otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                                <input type="text" class="form-control otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                                <input type="text" class="form-control otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                            </div>
                            <button type="submit" id="btnVerifikasiOtp" class="btn btn-dark w-100 rounded-3 text-white" style="background: #1d4ed8 !important; border: none;">
                                <i class="bi bi-patch-check me-2"></i>Verifikasi OTP
                            </button>
                        </form>
                        <div class="mt-3">
                            <small class="text-muted" style="font-size: 0.8rem;">Tidak menerima kode?
                                <a href="javascript:void(0)" id="btnKirimUlangOtp" class="text-decoration-none fw-semibold text-primary">Kirim Ulang</a>
                            </small>
                        </div>
                    </div>

                    <div id="step-reset" style="display: none;">
                        <form id="formResetPassword">
                            <div class="mb-3 text-start">
                                <label for="new_password" class="form-label text-dark">Password Baru</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                                    <input type="password" id="new_password" class="form-control" placeholder="Masukkan password baru" required>
                                </div>
                            </div>
                            <div class="mb-3 text-start">
                                <label for="confirm_password" class="form-label text-dark">Konfirmasi Password</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="bi bi-check2-circle"></i></span>
                                    <input type="password" id="confirm_password" class="form-control" placeholder="Ulangi password baru" required>
                                </div>
                            </div>
                            <button type="submit" id="btnSimpanPassword" class="btn btn-dark w-100 mt-2 rounded-3 text-white" style="background: #1d4ed8 !important; border: none;">
                                <i class="bi bi-box-arrow-in-down me-2"></i>Simpan Password Baru
                            </button>
                        </form>
                    </div>
                    <span id="notifikasi-otp" class="d-none mt-3"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        const overlay = document.getElementById('login-overlay');
        const statusText = document.getElementById('encryptionStatus');
        const overlaySpinner = document.getElementById('overlaySpinner');
        const overlayTitle = document.getElementById('overlayTitle');

        const form = document.getElementById('loginForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const btn = form.querySelector('button[type="submit"]');

            overlaySpinner.style.display = 'block';
            overlayTitle.textContent = 'Autentikasi Sistem';
            statusText.className = 'encryption-text text-info';
            statusText.innerHTML = "Memulakan sambungan selamat...";
            btn.disabled = true;
            overlay.classList.add('active');

            setTimeout(() => {
                if (overlay.classList.contains('active')) {
                    statusText.innerHTML = "Proses Login, Mohon Menunggu...";
                }
            }, 300);

            $.ajax({
                url: "{{ route('verifikasi_Login') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "username": username,
                    "password": password
                },
                dataType: 'html',
            }).done(function(data) {
                setTimeout(() => {
                    btn.disabled = false;

                    if (data.toLowerCase().includes('success') || data.toLowerCase().includes('berhasil')) {
                        statusText.className = 'encryption-text text-success';
                        statusText.innerHTML = "Login Berhasil! Mengalihkan...";
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        $('#notifikasi-login').html(data);
                        overlaySpinner.style.display = 'none';
                        overlayTitle.textContent = 'Gagal Masuk';
                        statusText.className = 'encryption-text text-danger';
                        statusText.innerHTML = "Akun anda salah, periksa kembali username atau kata sandi Anda.";

                        setTimeout(() => {
                            overlay.classList.remove('active');
                        }, 2200);
                    }
                }, 1500);
            }).fail(function() {
                setTimeout(() => {
                    btn.disabled = false;
                    overlaySpinner.style.display = 'none';
                    overlayTitle.textContent = 'Gagal Sistem';
                    statusText.className = 'encryption-text text-danger';
                    statusText.innerHTML = "Terjadi kesalahan pada pelayan/server.";

                    setTimeout(() => {
                        overlay.classList.remove('active');
                    }, 2000);
                }, 1200);
            });
        });

        $('#formHubungiAdmin').on('submit', function(e) {
            e.preventDefault();
            $('#modalHubungiAdmin').modal('hide');

            overlaySpinner.style.display = 'block';
            overlayTitle.textContent = 'Mengirim Pesan';
            statusText.className = 'encryption-text text-info';
            statusText.innerHTML = "Menghantar mesej kepada admin sistem...";
            overlay.classList.add('active');

            setTimeout(() => {
                overlay.classList.remove('active');
                Swal.fire({
                    icon: 'success',
                    title: 'Pesan Terkirim!',
                    text: 'Pesan kendala Anda telah diteruskan ke bagian admin sistem.',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'custom-swal-popup',
                        title: 'custom-swal-title'
                    }
                });
                $('#formHubungiAdmin')[0].reset();
            }, 1500);
        });

        const otpInputs = document.querySelectorAll('.otp-input');
        otpInputs.forEach((input, index) => {
            input.addEventListener('keyup', (e) => {
                if (e.key >= 0 && e.key <= 9) {
                    if (index < otpInputs.length - 1) otpInputs[index + 1].focus();
                } else if (e.key === 'Backspace') {
                    if (index > 0) otpInputs[index - 1].focus();
                }
            });
            input.addEventListener('paste', (e) => {
                const pasteData = e.clipboardData.getData('text').trim();
                if (pasteData.length === 6 && /^\d+$/.test(pasteData)) {
                    pasteData.split('').forEach((char, i) => otpInputs[i].value = char);
                    otpInputs[5].focus();
                }
                e.preventDefault();
            });
        });

        $('#formKirimOtp').on('submit', function(e) {
            e.preventDefault();
            const email = $('#email').val().trim();
            const btn = $('#btnKirimOtp');

            overlaySpinner.style.display = 'block';
            overlayTitle.textContent = 'Pengiriman OTP';
            statusText.className = 'encryption-text text-info';
            statusText.innerHTML = "Menghantar kod pengesahan OTP...";
            btn.disabled = true;
            overlay.classList.add('active');

            $.ajax({
                url: "{{ route('verifikasi_send_email') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "email": email
                },
                dataType: 'json',
            }).done(function() {
                setTimeout(() => {
                    overlay.classList.remove('active');
                    btn.disabled = false;
                    $('#modalHeaderIcon').attr('class', 'bi bi-phone-vibrate-fill text-success fs-4');
                    $('#modalTitleText').text('Verifikasi Kode OTP');
                    $('#modalSubTitleText').text('Masukkan 6 digit angka yang dikirim ke email Anda.');
                    $('#displayEmailText').text(email);
                    $('#step-email').hide();
                    $('#step-otp').fadeIn();
                    $('.otp-input').first().focus();
                }, 1000);
            }).fail(function(xhr) {
                setTimeout(() => {
                    overlay.classList.remove('active');
                    btn.disabled = false;
                    let msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Email anda tidak di temukan.';
                    Swal.fire('Gagal', msg, 'error');
                }, 1000);
            });
        });

        $('#btnKirimUlangOtp').on('click', function() {
            $('#formKirimOtp').submit();
        });

        $('#formVerifikasiOtp').on('submit', function(e) {
            e.preventDefault();
            let otpValue = '';
            $('.otp-input').each(function() {
                otpValue += $(this).val();
            });

            if (otpValue.length < 6) {
                Swal.fire('Perhatian', 'Masukkan 6 digit kode OTP secara lengkap!', 'warning');
                return;
            }

            const btn = $('#btnVerifikasiOtp');
            overlaySpinner.style.display = 'block';
            overlayTitle.textContent = 'Verifikasi & Kemas Kini';
            statusText.className = 'encryption-text text-info';
            statusText.innerHTML = "Menyemak kod OTP...";
            btn.disabled = true;
            overlay.classList.add('active');

            $.ajax({
                url: "{{ route('verifikasi_otp_check') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "email": $('#email').val().trim(),
                    "otp": otpValue
                },
                dataType: 'json',
            }).done(function() {
                setTimeout(() => {
                    overlay.classList.remove('active');
                    btn.disabled = false;
                    $('#modalHeaderIcon').attr('class', 'bi bi-lock-fill text-primary fs-4');
                    $('#modalTitleText').text('Password Baru');
                    $('#modalSubTitleText').text('Buat kata sandi baru untuk akun Anda.');
                    $('#step-otp').hide();
                    $('#step-reset').fadeIn();
                }, 1000);
            }).fail(function(xhr) {
                setTimeout(() => {
                    overlay.classList.remove('active');
                    btn.disabled = false;
                    let msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Kode OTP yang Anda masukkan salah!';
                    Swal.fire('Ralat (Error)', msg, 'error');
                    $('.otp-input').val('');
                    $('.otp-input').first().focus();
                }, 1000);
            });
        });

        $('#formResetPassword').on('submit', function(e) {
            e.preventDefault();
            const pass = $('#new_password').val();
            const confirmPass = $('#confirm_password').val();
            let otpValue = '';
            $('.otp-input').each(function() {
                otpValue += $(this).val();
            });

            if (pass !== confirmPass) {
                Swal.fire('Perhatian', 'Konfirmasi password tidak cocok!', 'warning');
                return;
            }

            const btn = $('#btnSimpanPassword');
            overlaySpinner.style.display = 'block';
            overlayTitle.textContent = 'Menyimpan Data';
            statusText.className = 'encryption-text text-info';
            statusText.innerHTML = "Menyimpan kata sandi baru...";
            btn.disabled = true;
            overlay.classList.add('active');

            $.ajax({
                url: "{{ route('verifikasi_reset_pass') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "email": $('#email').val().trim(),
                    "otp": otpValue,
                    "password": pass,
                    "password_confirmation": confirmPass
                },
                dataType: 'json',
            }).done(function() {
                setTimeout(() => {
                    overlay.classList.remove('active');
                    btn.disabled = false;
                    Swal.fire({
                        title: 'Berjaya!',
                        text: 'Password berhasil diubah! Silakan login.',
                        icon: 'success',
                        confirmButtonText: 'Log Masuk'
                    }).then(() => {
                        $('#modalLupaPassword').modal('hide');
                    });
                }, 1200);
            }).fail(function(xhr) {
                setTimeout(() => {
                    overlay.classList.remove('active');
                    btn.disabled = false;
                    let msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Gagal mereset password!';
                    Swal.fire('Gagal', msg, 'error');
                }, 1200);
            });
        });

        $('#modalLupaPassword').on('hidden.bs.modal', function() {
            $('#modalHeaderIcon').attr('class', 'bi bi-shield-lock-fill text-primary fs-4');
            $('#modalTitleText').text('Reset Password');
            $('#modalSubTitleText').text('Masukkan email terdaftar untuk menerima kode verifikasi OTP.');
            $('#step-otp, #step-reset').hide();
            $('#step-email').show();
            $('#formKirimOtp')[0].reset();
            $('#formVerifikasiOtp')[0].reset();
            $('#formResetPassword')[0].reset();
        });
    </script>
</body>

</html>
