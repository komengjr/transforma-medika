<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login & Register | Innoventra by Transforma</title>
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

        /* === DESKTOP SPLIT SCREEN LAYOUT === */
        .login-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1100px;
            height: 640px;
            margin: 1.5rem;
            background: linear-gradient(135deg, #1e3a8a 0%, #0c2361 60%, #0284c7 100%);
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
            padding: 0.6rem 0.75rem;
            font-size: 0.95rem;
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

        .btn-primary {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #ffffff !important;
            border: none;
            border-radius: 50rem !important;
            padding: 0.65rem;
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
            margin-top: 0.5rem;
            padding: 0.5rem;
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
        .mobile-screen {
            display: none;
        }

        /* === MOBILE STYLING (Multi-step Views: Welcome, Login, Register) === */
        @media (max-width: 992px) {
            body {
                background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 50%, #1d4ed8 100%) !important;
                height: 100vh;
                width: 100vw;
                display: flex;
                flex-direction: column;
                align-items: stretch;
                justify-content: flex-start;
                overflow: hidden !important;
                position: fixed;
                inset: 0;
                padding: 0;
            }

            .login-wrapper {
                display: none !important;
                /* Sembunyikan wrapper desktop di HP */
            }

            .mobile-screen {
                display: flex;
                flex-direction: column;
                width: 100vw;
                height: 100vh;
                position: absolute;
                inset: 0;
                background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 50%, #1d4ed8 100%);
                overflow: hidden;
            }

            .mobile-screen:not(.active-screen) {
                display: none !important;
            }

            /* Bagian Banner Gambar Atas */
            .m-top-banner {
                width: 100%;
                height: 220px;
                background-image: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=800&q=80');
                background-size: cover;
                background-position: center;
                position: relative;
                border-bottom-left-radius: 35px;
                border-bottom-right-radius: 35px;
                overflow: hidden;
                flex-shrink: 0;
            }

            .m-top-banner::after {
                content: '';
                position: absolute;
                inset: 0;
                background: rgba(15, 23, 42, 0.45);
            }

            /* Tombol Kembali (Back Arrow) */
            .m-back-btn {
                position: absolute;
                top: 20px;
                left: 20px;
                z-index: 10;
                background: rgba(255, 255, 255, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.4);
                color: #fff;
                width: 38px;
                height: 38px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                backdrop-filter: blur(4px);
                font-size: 1.1rem;
            }

            /* Konten Body Form Mobile */
            .m-content-body {
                flex: 1;
                padding: 1.5rem 1.75rem 3.5rem 1.75rem;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                overflow: hidden;
            }

            /* Spasi antar input mobile agar tidak berdempetan */
            .m-content-body .mb-3 {
                margin-bottom: 1rem !important;
            }

            /* Footer Fixed Absolute di Bawah untuk Mobile */
            .mobile-footer-fixed {
                position: absolute;
                bottom: 10px;
                left: 0;
                width: 100%;
                text-align: center;
                z-index: 10;
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

    <!-- ========================================================== -->
    <!-- TAMPILAN DESKTOP (Split Screen) -->
    <!-- ========================================================== -->
    <div class="login-wrapper">
        <!-- SISI KIRI: Form Input & Login -->
        <div class="login-form-side">
            <div>
                <div class="mb-3">
                    <span class="brand-badge-pill">Innoventra Solusi Digital</span>
                </div>
                <div class="brand-title">Welcome Back</div>
                <div class="subtitle">Sila masukkan akses akaun anda untuk meneruskan</div>
            </div>

            <div class="form-card-box my-1">
                <form id="loginFormDesktop">
                    <div class="mb-3 text-start">
                        <label for="username_desk" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="text" id="username_desk" class="form-control" placeholder="Email Address / Username" required autocomplete="username">
                        </div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="password_desk" class="form-label">Kata Sandi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" id="password_desk" class="form-control" placeholder="Password" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3 px-1">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMeDesk">
                            <label for="rememberMeDesk" class="form-check-label text-white small fw-medium" style="font-size: 0.78rem;">Ingat saya</label>
                        </div>
                        <a href="#" class="text-decoration-none text-white fw-semibold" style="font-size: 0.78rem;" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">Forget Password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        Sign In / Masuk
                    </button>

                    <a href="javascript:void(0)" class="contact-admin-link" data-bs-toggle="modal" data-bs-target="#modalHubungiAdmin">
                        <i class="bi bi-headset text-info"></i> Hubungi Admin Sistem
                    </a>
                </form>
            </div>

            <div class="text-center mt-2">
                <span class="text-white opacity-75" style="font-size: 0.7rem;">&copy; 2026 Innoventra by Transforma &middot; Syarat & Ketentuan</span>
            </div>
        </div>

        <!-- SISI KANAN: Panel Gambar Ilustrasi Profesional -->
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


    <!-- ========================================================== -->
    <!-- TAMPILAN MOBILE (Multi-Screen: Welcome -> Login / Register) -->
    <!-- ========================================================== -->

    <!-- SCREEN 1: WELCOME SCREEN (Halaman Awal Mobile) -->
    <div id="mobileWelcomeScreen" class="mobile-screen active-screen d-lg-none">
        <div class="m-top-banner" style="height: 260px;"></div>
        <div class="m-content-body text-center" style="justify-content: flex-start; padding-top: 2rem;">
            <div>
                <h1 class="text-white fw-bold mb-2" style="font-size: 2rem;">Innoventra</h1>
                <p class="text-white-50 small px-3 mb-4" style="font-size: 0.83rem;">Solusi sistem manajemen digital terpadu perusahaan Anda. Sila pilih akses untuk meneruskan.</p>
            </div>
            <div class="w-100 px-3 mt-3">
                <button type="button" id="btnGoLogin" class="btn btn-primary w-100 mb-3 py-2.5">
                    LOGIN
                </button>
                <button type="button" id="btnGoRegister" class="btn w-100 py-2.5 fw-bold text-white" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.4); border-radius: 50rem;">
                    SIGN UP
                </button>
            </div>
        </div>
        <div class="mobile-footer-fixed d-lg-none text-center">
            <span class="text-white opacity-75" style="font-size: 0.7rem;">&copy; 2026 Innoventra by Transforma &middot; Syarat & Ketentuan</span>
        </div>
    </div>

    <!-- SCREEN 2: LOGIN SCREEN (Form Login Mobile) -->
    <div id="mobileLoginScreen" class="mobile-screen d-lg-none">
        <div class="m-top-banner" style="height: 150px;">
            <a href="javascript:void(0)" class="m-back-btn btnBackToWelcome"><i class="bi bi-chevron-left"></i></a>
        </div>
        <div class="m-content-body">
            <div>
                <h4 class="text-white fw-bold mb-1">Welcome Back</h4>
                <p class="text-white-50 small" style="font-size: 0.78rem;">Login to your account</p>
            </div>

            <form id="loginFormMobile" class="my-auto">
                <div class="mb-3 text-start">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" id="username_mob" class="form-control" placeholder="Username" required autocomplete="username">
                    </div>
                </div>

                <div class="mb-3 text-start">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password_mob" class="form-control" placeholder="Password" required autocomplete="current-password">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3 px-1">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMeMob">
                        <label for="rememberMeMob" class="form-check-label text-white small" style="font-size: 0.75rem;">Remember me</label>
                    </div>
                    <a href="#" class="text-decoration-none text-white fw-semibold" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                    LOGIN
                </button>

                <div class="text-center">
                    <span class="text-white-50 small" style="font-size: 0.75rem;">Don't have an account? <a href="javascript:void(0)" id="linkSwitchToRegister" class="text-white fw-bold text-decoration-underline">Sign up</a></span>
                </div>
            </form>

            <div style="height: 10px;"></div>
        </div>
        <div class="mobile-footer-fixed d-lg-none text-center">
            <span class="text-white opacity-75" style="font-size: 0.7rem;">&copy; 2026 Innoventra by Transforma &middot; Syarat & Ketentuan</span>
        </div>
    </div>

    <!-- SCREEN 3: REGISTER SCREEN (Form Register Mobile) -->
    <div id="mobileRegisterScreen" class="mobile-screen d-lg-none">
        <div class="m-top-banner" style="height: 140px;">
            <a href="javascript:void(0)" class="m-back-btn btnBackToWelcome"><i class="bi bi-chevron-left"></i></a>
        </div>
        <div class="m-content-body">
            <div>
                <h4 class="text-white fw-bold mb-1">Register</h4>
                <p class="text-white-50 small" style="font-size: 0.78rem;">Create your account</p>
            </div>

            <form id="registerFormMobile" class="my-auto">
                <div class="mb-2 text-start">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" id="reg_username" class="form-control" placeholder="Username" required>
                    </div>
                </div>

                <div class="mb-2 text-start">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" id="reg_email" class="form-control" placeholder="Email address" required>
                    </div>
                </div>

                <div class="mb-2 text-start">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="reg_password" class="form-control" placeholder="Password" required>
                    </div>
                </div>

                <div class="mb-3 text-start">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" id="reg_confirm" class="form-control" placeholder="Confirm password" required>
                    </div>
                </div>

                <p class="text-white-50 text-center mb-3" style="font-size: 0.68rem; line-height: 1.2;">
                    By registering, you are agreeing to our <a href="#" class="text-white text-decoration-underline">Terms of use</a> and <a href="#" class="text-white text-decoration-underline">Privacy Policy</a>.
                </p>

                <button type="submit" class="btn btn-primary w-100 mb-2">
                    REGISTER
                </button>

                <div class="text-center">
                    <span class="text-white-50 small" style="font-size: 0.75rem;">Already have an account? <a href="javascript:void(0)" id="linkSwitchToLogin" class="text-white fw-bold text-decoration-underline">Login</a></span>
                </div>
            </form>

            <div style="height: 5px;"></div>
        </div>
        <div class="mobile-footer-fixed d-lg-none text-center">
            <span class="text-white opacity-75" style="font-size: 0.7rem;">&copy; 2026 Innoventra by Transforma &middot; Syarat & Ketentuan</span>
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

        // Navigasi antar screen khusus Mobile
        document.getElementById('btnGoLogin').addEventListener('click', () => {
            document.getElementById('mobileWelcomeScreen').classList.remove('active-screen');
            document.getElementById('mobileLoginScreen').classList.add('active-screen');
        });

        document.getElementById('btnGoRegister').addEventListener('click', () => {
            document.getElementById('mobileWelcomeScreen').classList.remove('active-screen');
            document.getElementById('mobileRegisterScreen').classList.add('active-screen');
        });

        document.querySelectorAll('.btnBackToWelcome').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('mobileLoginScreen').classList.remove('active-screen');
                document.getElementById('mobileRegisterScreen').classList.remove('active-screen');
                document.getElementById('mobileWelcomeScreen').classList.add('active-screen');
            });
        });

        document.getElementById('linkSwitchToRegister').addEventListener('click', () => {
            document.getElementById('mobileLoginScreen').classList.remove('active-screen');
            document.getElementById('mobileRegisterScreen').classList.add('active-screen');
        });

        document.getElementById('linkSwitchToLogin').addEventListener('click', () => {
            document.getElementById('mobileRegisterScreen').classList.remove('active-screen');
            document.getElementById('mobileLoginScreen').classList.add('active-screen');
        });

        // Handler Proses Login (Desktop & Mobile)
        function processLogin(username, password, btnElement) {
            overlaySpinner.style.display = 'block';
            overlayTitle.textContent = 'Autentikasi Sistem';
            statusText.className = 'encryption-text text-info';
            statusText.innerHTML = "Memulakan sambungan selamat...";
            btnElement.disabled = true;
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
                    btnElement.disabled = false;
                    if (data.toLowerCase().includes('success') || data.toLowerCase().includes('berhasil')) {
                        statusText.className = 'encryption-text text-success';
                        statusText.innerHTML = "Login Berhasil! Mengalihkan...";
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
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
                    btnElement.disabled = false;
                    overlaySpinner.style.display = 'none';
                    overlayTitle.textContent = 'Gagal Sistem';
                    statusText.className = 'encryption-text text-danger';
                    statusText.innerHTML = "Terjadi kesalahan pada pelayan/server.";
                    setTimeout(() => {
                        overlay.classList.remove('active');
                    }, 2000);
                }, 1200);
            });
        }

        document.getElementById('loginFormDesktop').addEventListener('submit', function(e) {
            e.preventDefault();
            processLogin($('#username_desk').val().trim(), $('#password_desk').val().trim(), this.querySelector('button[type="submit"]'));
        });

        document.getElementById('loginFormMobile').addEventListener('submit', function(e) {
            e.preventDefault();
            processLogin($('#username_mob').val().trim(), $('#password_mob').val().trim(), this.querySelector('button[type="submit"]'));
        });

        // Handler Proses Register Mobile
        document.getElementById('registerFormMobile').addEventListener('submit', function(e) {
            e.preventDefault();
            const u = $('#reg_username').val().trim();
            const em = $('#reg_email').val().trim();
            const p = $('#reg_password').val().trim();
            const cp = $('#reg_confirm').val().trim();

            if (p !== cp) {
                Swal.fire('Perhatian', 'Konfirmasi password tidak cocok!', 'warning');
                return;
            }

            const btn = this.querySelector('button[type="submit"]');
            overlaySpinner.style.display = 'block';
            overlayTitle.textContent = 'Pendaftaran Akun';
            statusText.className = 'encryption-text text-info';
            statusText.innerHTML = "Mendaftarkan akaun baru...";
            btn.disabled = true;
            overlay.classList.add('active');

            setTimeout(() => {
                overlay.classList.remove('active');
                btn.disabled = false;
                Swal.fire({
                    icon: 'success',
                    title: 'Registrasi Berhasil!',
                    text: 'Akun Anda telah berhasil dibuat. Silakan login.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    document.getElementById('mobileRegisterScreen').classList.remove('active-screen');
                    document.getElementById('mobileLoginScreen').classList.add('active-screen');
                });
            }, 1500);
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
                    confirmButtonText: 'OK'
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
        });
    </script>
</body>

</html>
