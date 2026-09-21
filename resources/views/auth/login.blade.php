<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Innoventra Digital Solusi</title>
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
            background: linear-gradient(135deg, #09111e 0%, #0f1c3f 50%, #1e3a8a 100%);
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
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            animation: rise 15s infinite ease-in-out;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(2px);
            border: 1px solid rgba(255, 255, 255, 0.1);
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
                opacity: 0.5;
            }

            80% {
                opacity: 0.5;
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
            max-width: 1150px;
            height: 650px;
            margin: 1.5rem;
            background: linear-gradient(135deg, #0b1c3d 0%, #0d2356 100%);
            backdrop-filter: blur(25px);
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            display: flex;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.15);
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

        /* === SISI KIRI: Panel Profil & Detail Perusahaan (Scrollable) === */
        .login-banner-side {
            flex: 1.25;
            background: linear-gradient(135deg, #091736 0%, #15326e 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.5rem;
            overflow-y: auto;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-banner-side::-webkit-scrollbar {
            width: 5px;
        }

        .login-banner-side::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .login-banner-side::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1000&q=80') center/cover no-repeat;
            opacity: 0.12;
            pointer-events: none;
        }

        .welcome-big-text {
            font-size: 2.6rem;
            font-weight: 800;
            letter-spacing: -1px;
            color: #ffffff;
            margin-bottom: 0.2rem;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .company-info-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 1rem;
            padding: 1rem 1.2rem;
            backdrop-filter: blur(5px);
        }

        /* === SISI KANAN: Form Input & Branding === */
        .login-form-side {
            flex: 1;
            padding: 2.5rem 2.8rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-y: auto;
            background: transparent;
        }

        .brand-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 700;
            font-size: 0.8rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.9rem;
            border-radius: 50rem;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .brand-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin-bottom: 0.1rem;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.78rem;
            font-weight: 500;
        }

        .form-label {
            font-weight: 600;
            color: #ffffff;
            font-size: 0.76rem;
            margin-bottom: 0.2rem;
        }

        .input-group {
            border: none;
            border-radius: 0.75rem;
            overflow: hidden;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.4);
        }

        .input-group-text {
            background-color: transparent;
            border: none;
            color: #666;
            padding-left: 0.9rem;
            padding-right: 0.4rem;
            font-size: 0.85rem;
        }

        .form-control {
            font-family: 'Plus Jakarta Sans', sans-serif;
            border: none;
            padding: 0.5rem 0.7rem;
            font-size: 0.86rem;
            background-color: transparent !important;
            box-shadow: none !important;
            color: #222 !important;
        }

        .form-control::placeholder {
            color: #aaa !important;
        }

        textarea.form-control {
            resize: none;
        }

        /* === EFEK ANIMASI KLIK TOMBOL YANG KEREN (RIPPLE & SMOOTH TRANSITION) === */
        .btn-primary,
        .btn-dark,
        .contact-admin-link,
        .m-back-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
            cursor: pointer;
        }

        /* Efek Active / Saat Diklik (Mengecil & Mengkilap) */
        .btn-primary:active,
        .btn-dark:active,
        .contact-admin-link:active,
        .m-back-btn:active {
            transform: scale(0.95) !important;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3) !important;
        }

        /* Efek Ripple Dinamis saat Tombol Diklik via JS */
        .ripple-effect {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        .btn-primary {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #2563eb !important;
            border: none;
            border-radius: 50rem !important;
            padding: 0.55rem;
            font-weight: 700;
            font-size: 0.85rem;
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
        }

        .btn-primary:hover {
            background: #1d4ed8 !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.6);
        }

        .contact-admin-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            margin-top: 0.3rem;
            padding: 0.4rem;
            font-size: 0.72rem;
            font-weight: 600;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
            border: 1px dashed rgba(255, 255, 255, 0.3);
            border-radius: 0.75rem;
            text-decoration: none;
        }

        .contact-admin-link:hover {
            background: #ffffff;
            color: #1e3a8a;
            border-color: #ffffff;
            transform: translateY(-1px);
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
            transition: all 0.2s ease;
        }

        .otp-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
            background-color: #fff;
            outline: none;
            transform: scale(1.05);
        }

        /* === LOADING OVERLAY === */
        #login-overlay {
            position: fixed;
            inset: 0;
            background: rgba(9, 17, 30, 0.85);
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
            background: rgba(15, 28, 63, 0.95);
            border: 1px solid rgba(37, 99, 235, 0.5);
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
            border: 3px solid rgba(37, 99, 235, 0.2);
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
            min-height: 24px;
        }

        .encryption-title {
            color: #f8fafc;
            font-weight: 700;
            font-size: 0.98rem;
            margin-bottom: 0.2rem;
        }

        .mobile-screen {
            display: none;
        }

        /* === MOBILE STYLING === */
        @media (max-width: 992px) {
            body {
                background: linear-gradient(135deg, #09111e 0%, #0f1c3f 50%, #1e3a8a 100%) !important;
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
            }

            .mobile-screen {
                display: flex;
                flex-direction: column;
                width: 100vw;
                height: 100vh;
                position: absolute;
                inset: 0;
                background: linear-gradient(135deg, #09111e 0%, #0f1c3f 50%, #1e3a8a 100%);
                overflow: hidden;
            }

            .mobile-screen:not(.active-screen) {
                display: none !important;
            }

            .m-top-banner {
                width: 100%;
                height: 155px;
                background: linear-gradient(135deg, #091736 0%, #15326e 100%);
                position: relative;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 1rem;
            }

            .m-wave-svg {
                position: absolute;
                bottom: -1px;
                left: 0;
                width: 100%;
                height: 30px;
                pointer-events: none;
            }

            .m-back-btn {
                position: absolute;
                top: 15px;
                left: 15px;
                z-index: 10;
                background: rgba(255, 255, 255, 0.15);
                border: 1px solid rgba(255, 255, 255, 0.3);
                color: #fff;
                width: 34px;
                height: 34px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                backdrop-filter: blur(4px);
            }

            .m-content-body {
                flex: 1;
                padding: 1rem 1.2rem;
                overflow-y: auto;
            }

            .mobile-action-area {
                width: 100%;
                padding: 0.5rem 1.2rem 1.5rem 1.2rem;
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                align-items: center;
                flex-shrink: 0;
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
    <!-- TAMPILAN DESKTOP (Split Screen dengan Profil Perusahaan Detail) -->
    <!-- ========================================================== -->
    <div class="login-wrapper">
        <!-- SISI KIRI: Panel Profil & Detail Perusahaan -->
        <div class="login-banner-side d-none d-md-flex">
            <div>
                <span class="brand-badge-pill mb-3">
                    <i class="bi bi-hexagon-fill text-info"></i> PT Innoventra Solusi Digital
                </span>
                <div class="welcome-big-text">Welcome :)</div>
                <p class="text-white-50 mb-3" style="font-size: 0.78rem; line-height: 1.4;">
                    Perusahaan teknologi informasi dan komunikasi (TIK) inovatif yang berfokus pada penyediaan solusi digital terintegrasi untuk akselerasi transformasi digital bisnis dan kesehatan.
                </p>
            </div>

            <div class="d-flex flex-column gap-2 my-2">
                <div class="company-info-card">
                    <div class="text-info fw-bold mb-1" style="font-size: 0.78rem;"><i class="bi bi-eye-fill me-1"></i> Visi Kami</div>
                    <p class="text-white-50 mb-0" style="font-size: 0.72rem; line-height: 1.35;">
                        Menjadi mitra solusi digital dan integrasi teknologi terdepan di Indonesia yang dipercaya dalam menghadirkan inovasi terapan yang kreatif, adaptif, dan berdampak nyata bagi pertumbuhan ekosistem bisnis digital dan kesehatan.
                    </p>
                </div>

                <div class="company-info-card">
                    <div class="text-info fw-bold mb-1" style="font-size: 0.78rem;"><i class="bi bi-rocket-takeoff-fill me-1"></i> Misi Kami</div>
                    <ul class="text-white-50 ps-3 mb-0" style="font-size: 0.71rem; line-height: 1.3;">
                        <li>Mengembangkan website & aplikasi enterprise berkualitas tinggi.</li>
                        <li>Menyediakan layanan integrasi sistem medis (SIMRS/LIS/PACS) & alat kesehatan terstandar.</li>
                        <li>Memberikan konsultasi teknologi digital yang solutif & adaptif.</li>
                        <li>Menerapkan standar keamanan data & enkripsi medis terbaik.</li>
                    </ul>
                </div>
            </div>

            <div class="mt-2">
                <span class="text-white-50" style="font-size: 0.68rem;">&copy; 2026 Innoventra by Transforma &middot; All Rights Reserved</span>
            </div>
        </div>

        <!-- SISI KANAN: Form Input & Login -->
        <div class="login-form-side">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="brand-badge-pill d-md-none">Innoventra</span>
                    <span class="subtitle">Secure Enterprise Portal</span>
                </div>
                <div class="brand-title">Sign In to Continue</div>
            </div>

            <div class="form-card-box my-2">
                <form id="loginFormDesktop">
                    <div class="mb-2 text-start">
                        <label for="username_desk" class="form-label">Username / Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" id="username_desk" class="form-control" placeholder="Username" required autocomplete="username">
                        </div>
                    </div>

                    <div class="mb-2 text-start">
                        <label for="password_desk" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" id="password_desk" class="form-control" placeholder="Password" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3 px-1">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMeDesk">
                            <label for="rememberMeDesk" class="form-check-label text-white small fw-medium" style="font-size: 0.73rem;">Remember me</label>
                        </div>
                        <a href="#" class="text-decoration-none text-white fw-semibold" style="font-size: 0.73rem;" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">Forgot password?</a>
                    </div>

                    <button type="submit" id="btnSubmitDesk" class="btn btn-primary w-100 mb-2">
                        Login
                    </button>

                    <a href="javascript:void(0)" class="contact-admin-link mt-1" data-bs-toggle="modal" data-bs-target="#modalHubungiAdmin">
                        <i class="bi bi-headset text-info"></i> Hubungi Admin Sistem
                    </a>
                </form>
            </div>

            <div class="text-center">
                <span class="text-white opacity-50" style="font-size: 0.68rem;">&copy; 2026 Innoventra by Transforma</span>
            </div>
        </div>
    </div>


    <!-- ========================================================== -->
    <!-- TAMPILAN MOBILE (Dilengkapi Info Profil Perusahaan Lengkap) -->
    <!-- ========================================================== -->

    <!-- SCREEN 1: WELCOME SCREEN (Mobile) -->
    <div id="mobileWelcomeScreen" class="mobile-screen active-screen d-lg-none">
        <div class="m-top-banner">
            <div>
                <span class="brand-badge-pill mb-1" style="font-size: 0.68rem;"><i class="bi bi-hexagon-fill text-info"></i> Innoventra Digital Solusi</span>
                <h1 class="text-white fw-bold mb-0" style="font-size: 1.5rem;">Welcome :)</h1>
            </div>
            <!-- SVG Wave Header -->
            <svg class="m-wave-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path fill="#09111e" fill-opacity="1" d="M0,32L48,42.7C96,53,192,75,288,80C384,85,480,75,576,58.7C672,43,768,21,864,21.3C960,21,1056,43,1152,53.3C1248,64,1344,64,1392,64L1440,64L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
            </svg>
        </div>
        <div class="m-content-body text-start">
            <div class="p-3 rounded-4 mb-2" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                <h6 class="text-info fw-bold mb-1" style="font-size: 0.8rem;"><i class="bi bi-info-circle-fill me-1"></i> Tentang Kami</h6>
                <p class="text-white-50 mb-0" style="font-size: 0.72rem; line-height: 1.4;">
                    PT INNOVENTRA SOLUSI DIGITAL adalah perusahaan TIK inovatif yang berfokus pada penyedia solusi digital terintegrasi untuk UMKM, startup, korporasi, hingga fasilitas pelayanan kesehatan (Faskes, Rumah Sakit, dan Klinik).
                </p>
            </div>

            <div class="p-3 rounded-4 mb-2" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                <h6 class="text-info fw-bold mb-1" style="font-size: 0.8rem;"><i class="bi bi-eye-fill me-1"></i> Visi Kami</h6>
                <p class="text-white-50 mb-0" style="font-size: 0.72rem; line-height: 1.4;">
                    Menjadi mitra solusi digital dan integrasi teknologi terdepan di Indonesia yang dipercaya dalam menghadirkan inovasi terapan yang kreatif, adaptif, dan berdampak nyata.
                </p>
            </div>

            <div class="p-3 rounded-4 mb-2" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                <h6 class="text-info fw-bold mb-1" style="font-size: 0.8rem;"><i class="bi bi-rocket-takeoff-fill me-1"></i> Misi Kami</h6>
                <ul class="text-white-50 ps-3 mb-0" style="font-size: 0.71rem; line-height: 1.35;">
                    <li>Mengembangkan website & aplikasi enterprise berkualitas tinggi.</li>
                    <li>Menyediakan layanan integrasi sistem medis (SIMRS/LIS/PACS) & alat kesehatan.</li>
                    <li>Memberikan konsultasi teknologi digital yang solutif & adaptif.</li>
                    <li>Menerapkan standar keamanan data & enkripsi medis terbaik.</li>
                </ul>
            </div>
        </div>
        <!-- Action Area -->
        <div class="mobile-action-area d-lg-none">
            <div class="w-100 mb-2">
                <button type="button" id="btnGoLogin" class="btn btn-primary w-100 py-2">
                    MASUK KE PORTAL
                </button>
            </div>
            <span class="text-white opacity-75 text-center" style="font-size: 0.65rem;">&copy; 2026 Innoventra by Transforma</span>
        </div>
    </div>

    <!-- SCREEN 2: LOGIN SCREEN (Mobile) -->
    <div id="mobileLoginScreen" class="mobile-screen d-lg-none">
        <div class="m-top-banner">
            <a href="javascript:void(0)" class="m-back-btn btnBackToWelcome"><i class="bi bi-chevron-left"></i></a>
            <div>
                <span class="brand-badge-pill mb-1" style="font-size: 0.68rem;"><i class="bi bi-hexagon-fill text-info"></i> Innoventra Digital Solusi</span>
                <h5 class="text-white fw-bold mb-0" style="font-size: 0.9rem;">Sign In to Portal</h5>
            </div>
            <!-- SVG Wave Header -->
            <svg class="m-wave-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path fill="#09111e" fill-opacity="1" d="M0,32L48,42.7C96,53,192,75,288,80C384,85,480,75,576,58.7C672,43,768,21,864,21.3C960,21,1056,43,1152,53.3C1248,64,1344,64,1392,64L1440,64L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
            </svg>
        </div>
        <div class="m-content-body">
            <form id="loginFormMobile">
                <div class="mb-2 text-start">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" id="username_mob" class="form-control" placeholder="Username" required autocomplete="username">
                    </div>
                </div>

                <div class="mb-2 text-start">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password_mob" class="form-control" placeholder="Password" required autocomplete="current-password">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-1 px-1">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMeMob">
                        <label for="rememberMeMob" class="form-check-label text-white small" style="font-size: 0.72rem;">Remember me</label>
                    </div>
                    <a href="#" class="text-decoration-none text-white fw-semibold" style="font-size: 0.72rem;" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">Forgot password?</a>
                </div>
            </form>
        </div>
        <!-- Action Area -->
        <div class="mobile-action-area d-lg-none">
            <button type="submit" id="btnSubmitMob" form="loginFormMobile" class="btn btn-primary w-100 mb-2 py-2">
                Login
            </button>
            <div class="text-center mb-2">
                <a href="javascript:void(0)" class="text-white-50 text-decoration-none small" style="font-size: 0.72rem;" data-bs-toggle="modal" data-bs-target="#modalHubungiAdmin">
                    <i class="bi bi-headset text-info"></i> Hubungi Admin Sistem
                </a>
            </div>
            <span class="text-white opacity-75 text-center" style="font-size: 0.65rem;">&copy; 2026 Innoventra by Transforma</span>
        </div>
    </div>


    <!-- ================= MODAL HUBUNGI ADMIN SISTEM ================= -->
    <div class="modal fade" id="modalHubungiAdmin" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                <div class="modal-header border-0 text-center flex-column pb-0 pt-4" style="background: linear-gradient(135deg, rgba(37, 99, 235, 0.08), rgba(0, 0, 0, 0.02));">
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
                        <button type="submit" class="btn btn-dark w-100 mt-2 rounded-3 text-white" style="background: #2563eb !important; border: none;">
                            <i class="bi bi-send-fill me-2"></i>Kirim Pesan ke Admin
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= MODAL LUPA & RESET PASSWORD ================= -->
    <div class="modal fade" id="modalLupaPassword" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                <div class="modal-header border-0 text-center flex-column pb-0 pt-4" style="background: linear-gradient(135deg, rgba(37, 99, 235, 0.08), rgba(0, 0, 0, 0.02));">
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
                            <button type="submit" id="btnKirimOtp" class="btn btn-dark w-100 mt-2 rounded-3 text-white" style="background: #2563eb !important; border: none;">
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
                            <button type="submit" id="btnVerifikasiOtp" class="btn btn-dark w-100 rounded-3 text-white" style="background: #2563eb !important; border: none;">
                                <i class="bi bi-patch-check me-2"></i>Verifikasi OTP
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

        // === EFEK RIPPLE DINAMIS PADA KLIK TOMBOL ===
        document.querySelectorAll('button, .contact-admin-link, .m-back-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const ripple = document.createElement('span');
                ripple.classList.add('ripple-effect');
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Navigasi antar screen khusus Mobile
        document.getElementById('btnGoLogin').addEventListener('click', () => {
            document.getElementById('mobileWelcomeScreen').classList.remove('active-screen');
            document.getElementById('mobileLoginScreen').classList.add('active-screen');
        });

        document.querySelectorAll('.btnBackToWelcome').forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('mobileLoginScreen').classList.remove('active-screen');
                document.getElementById('mobileWelcomeScreen').classList.add('active-screen');
            });
        });

        // Handler Proses Login yang Aman (Anti-Null Error)
        function processLogin(username, password, btnElement) {
            overlaySpinner.style.display = 'block';
            overlayTitle.textContent = 'Autentikasi Sistem';
            statusText.className = 'encryption-text text-info';
            statusText.innerHTML = "Memulakan sambungan selamat...";

            if (btnElement) {
                btnElement.disabled = true;
            }

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
                    if (btnElement) {
                        btnElement.disabled = false;
                    }
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
                    if (btnElement) {
                        btnElement.disabled = false;
                    }
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
            processLogin($('#username_desk').val().trim(), $('#password_desk').val().trim(), document.getElementById('btnSubmitDesk'));
        });

        document.getElementById('loginFormMobile').addEventListener('submit', function(e) {
            e.preventDefault();
            processLogin($('#username_mob').val().trim(), $('#password_mob').val().trim(), document.getElementById('btnSubmitMob'));
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
            btn.prop('disabled', true);
            overlay.classList.add('active');

            setTimeout(() => {
                overlay.classList.remove('active');
                btn.prop('disabled', false);
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
