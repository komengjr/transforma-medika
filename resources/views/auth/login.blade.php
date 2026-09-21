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
    <!-- Google Fonts: Plus Jakarta Sans, Outfit & Fira Code -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
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

        /* === ANIMASI BALON / BUBBLE MELAYANG DI LATAR BELAKANG (DESKTOP) === */
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

        .mobile-screen {
            display: none;
        }

        /* === MOBILE STYLING (GRADASI WARNA KUNING DINAMIS & ANIMASI KEREN) === */
        @media (max-width: 992px) {
            body {
                /* Gradasi warna latar belakang mobile yang dinamis & elegan */
                background: linear-gradient(135deg, #fce38a 0%, #f38181 100%) !important;
                background-size: 200% 200%;
                animation: gradientBG 10s ease infinite;
                height: 100vh;
                width: 100vw;
                display: flex;
                flex-direction: column;
                align-items: stretch;
                justify-content: flex-start;
                overflow-y: auto !important;
                position: relative;
                padding: 0;
            }

            @keyframes gradientBG {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            .login-wrapper {
                display: none !important;
            }

            .mobile-screen {
                display: flex;
                flex-direction: column;
                width: 100vw;
                min-height: 100vh;
                position: relative;
                background: transparent;
                overflow-y: auto;
            }

            .mobile-screen:not(.active-screen) {
                display: none !important;
            }

            /* Header Teks dengan Font Eksklusif 'Outfit' & Animasi Masuk */
            .m-yellow-header {
                text-align: center;
                padding: 2.2rem 1.5rem 1.2rem 1.5rem;
                animation: fadeInDownMobile 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }

            @keyframes fadeInDownMobile {
                0% {
                    opacity: 0;
                    transform: translateY(-20px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .m-yellow-header h1 {
                font-family: 'Outfit', sans-serif;
                font-size: 2.75rem;
                font-weight: 800;
                color: #1a1a1a;
                margin-bottom: 0;
                letter-spacing: -1px;
                text-shadow: 0 2px 10px rgba(255, 255, 255, 0.4);
            }

            .m-yellow-header p {
                font-family: 'Outfit', sans-serif;
                font-size: 1.2rem;
                font-weight: 700;
                color: #2c2c2c;
                margin-bottom: 0;
                letter-spacing: -0.3px;
            }

            /* Kartu Putih dengan Animasi Slide Up */
            .m-white-card-container {
                background: #ffffff;
                border-top-left-radius: 2.5rem;
                border-top-right-radius: 2.5rem;
                padding: 2.2rem 1.75rem 3rem 1.75rem;
                box-shadow: 0 -15px 35px rgba(0, 0, 0, 0.1);
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                animation: slideUpMobile 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }

            @keyframes slideUpMobile {
                0% {
                    opacity: 0;
                    transform: translateY(40px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Input Group dengan Efek Transisi Fokus yang Halus */
            .mobile-input-group {
                border: 1.5px solid #e2e8f0;
                border-radius: 1rem;
                background-color: #f8fafc;
                padding: 0.3rem 0.75rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .mobile-input-group:focus-within {
                border-color: #f38181;
                background-color: #ffffff;
                box-shadow: 0 0 0 4px rgba(243, 129, 129, 0.15);
                transform: translateY(-2px);
            }

            .mobile-input-group .form-control {
                border: none;
                padding: 0.45rem 0.2rem;
                font-size: 0.92rem;
                color: #1e293b !important;
                background: transparent !important;
                font-family: 'Plus Jakarta Sans', sans-serif;
            }

            .mobile-input-group .input-group-text {
                background: transparent;
                border: none;
                color: #64748b;
                font-size: 1.05rem;
                transition: color 0.3s ease;
            }

            .mobile-input-group:focus-within .input-group-text {
                color: #f38181;
            }

            .m-label {
                font-family: 'Outfit', sans-serif;
                font-size: 0.88rem;
                font-weight: 700;
                color: #334155;
                margin-bottom: 0.35rem;
            }

            /* Tombol Utama dengan Efek Gradient & Hover Interaktif */
            .btn-mobile-primary {
                font-family: 'Outfit', sans-serif;
                background: linear-gradient(135deg, #ffca28 0%, #ff6f61 100%) !important;
                border: none;
                border-radius: 50rem !important;
                padding: 0.8rem;
                font-weight: 800;
                font-size: 1rem;
                color: #ffffff !important;
                box-shadow: 0 6px 20px rgba(255, 111, 97, 0.4);
                width: 100%;
                transition: all 0.3s ease;
            }

            .btn-mobile-primary:active {
                transform: scale(0.97);
            }
        }
    </style>
</head>

<body>
    <!-- Elemen Balon-balon Melayang (Desktop) -->
    <div class="bubble-bg d-none d-lg-block">
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
    <div class="login-wrapper d-none d-lg-flex">
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

        <div class="login-banner-side">
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
    <!-- TAMPILAN MOBILE (Gradasi Dinamis & Animasi Interaktif) -->
    <!-- ========================================================== -->

    <!-- SCREEN 1: WELCOME SCREEN -->
    <div id="mobileWelcomeScreen" class="mobile-screen active-screen d-lg-none">
        <div class="m-yellow-header pt-4">
            <h1 class="mt-4">Hello</h1>
            <p>Welcome Back!</p>
        </div>
        <div class="m-white-card-container text-center">
            <div class="my-auto py-3">
                <h3 class="fw-bold text-dark mb-2" style="font-family: 'Outfit', sans-serif; font-size: 1.6rem;">Innoventra</h3>
                <p class="text-muted small px-2 mb-4" style="font-size: 0.83rem;">Solusi sistem manajemen digital terpadu perusahaan Anda. Sila pilih akses untuk meneruskan.</p>
                <button type="button" id="btnGoLogin" class="btn-mobile-primary mb-3">
                    LOGIN ACCOUNT
                </button>
                <button type="button" id="btnGoRegister" class="btn w-100 py-2.5 fw-bold text-dark" style="background: #f1f5f9; border-radius: 50rem; border: none; font-size: 0.9rem; font-family: 'Outfit', sans-serif;">
                    CREATE NEW ACCOUNT
                </button>
            </div>
            <div class="text-center pb-2">
                <span class="text-muted" style="font-size: 0.68rem;">&copy; 2026 Innoventra by Transforma</span>
            </div>
        </div>
    </div>

    <!-- SCREEN 2: LOGIN SCREEN -->
    <div id="mobileLoginScreen" class="mobile-screen d-lg-none">
        <div class="m-yellow-header">
            <h1>Hello</h1>
            <p>Welcome Back!</p>
        </div>
        <div class="m-white-card-container">
            <div>
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark mb-1" style="font-family: 'Outfit', sans-serif; font-size: 1.6rem;">Login Account</h3>
                    <p class="text-muted" style="font-size: 0.76rem; line-height: 1.3;">Masukkan kredensial akun Anda untuk mengakses sistem.</p>
                </div>

                <form id="loginFormMobile">
                    <div class="mb-3 text-start">
                        <label class="m-label">Email Address / Username</label>
                        <div class="input-group mobile-input-group">
                            <input type="text" id="username_mob" class="form-control" placeholder="Your Email Address" required autocomplete="username">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        </div>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="m-label">Password</label>
                        <div class="input-group mobile-input-group">
                            <input type="password" id="password_mob" class="form-control" placeholder="*************" required autocomplete="current-password">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMeMob">
                            <label for="rememberMeMob" class="form-check-label text-dark fw-medium" style="font-size: 0.78rem;">Save Password</label>
                        </div>
                        <a href="#" class="text-decoration-none fw-bold text-dark" style="font-size: 0.78rem;" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn-mobile-primary mb-3">
                        Login Account
                    </button>

                    <div class="text-center mt-2">
                        <a href="javascript:void(0)" id="linkSwitchToRegister" class="text-dark fw-bold text-decoration-none" style="font-size: 0.85rem; font-family: 'Outfit', sans-serif;">Create New Account</a>
                    </div>
                </form>
            </div>

            <div class="text-center pt-3">
                <a href="javascript:void(0)" class="text-muted text-decoration-none small" style="font-size: 0.72rem;" data-bs-toggle="modal" data-bs-target="#modalHubungiAdmin"><i class="bi bi-headset"></i> Hubungi Admin Sistem</a>
            </div>
        </div>
    </div>

    <!-- SCREEN 3: REGISTER SCREEN -->
    <div id="mobileRegisterScreen" class="mobile-screen d-lg-none">
        <div class="m-yellow-header py-3">
            <h1 style="font-size: 2.2rem;">Register</h1>
            <p style="font-size: 1.05rem;">Create new account</p>
        </div>
        <div class="m-white-card-container">
            <div>
                <form id="registerFormMobile">
                    <div class="mb-2 text-start">
                        <label class="m-label">Username</label>
                        <div class="input-group mobile-input-group">
                            <input type="text" id="reg_username" class="form-control" placeholder="Username" required>
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                        </div>
                    </div>

                    <div class="mb-2 text-start">
                        <label class="m-label">Email Address</label>
                        <div class="input-group mobile-input-group">
                            <input type="email" id="reg_email" class="form-control" placeholder="Your Email Address" required>
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        </div>
                    </div>

                    <div class="mb-2 text-start">
                        <label class="m-label">Password</label>
                        <div class="input-group mobile-input-group">
                            <input type="password" id="reg_password" class="form-control" placeholder="*************" required>
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        </div>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="m-label">Confirm Password</label>
                        <div class="input-group mobile-input-group">
                            <input type="password" id="reg_confirm" class="form-control" placeholder="*************" required>
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        </div>
                    </div>

                    <button type="submit" class="btn-mobile-primary mb-3 mt-2">
                        Sign Up
                    </button>

                    <div class="text-center">
                        <span class="text-muted small" style="font-size: 0.8rem;">Already have an account? <a href="javascript:void(0)" id="linkSwitchToLogin" class="text-dark fw-bold text-decoration-underline">Login</a></span>
                    </div>
                </form>
            </div>
            <div class="text-center pt-2">
                <span class="text-muted" style="font-size: 0.68rem;">&copy; 2026 Innoventra by Transforma</span>
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

        // Navigasi Screen Mobile
        document.getElementById('btnGoLogin').addEventListener('click', () => {
            document.getElementById('mobileWelcomeScreen').classList.remove('active-screen');
            document.getElementById('mobileLoginScreen').classList.add('active-screen');
        });

        document.getElementById('btnGoRegister').addEventListener('click', () => {
            document.getElementById('mobileWelcomeScreen').classList.remove('active-screen');
            document.getElementById('mobileRegisterScreen').classList.add('active-screen');
        });

        document.getElementById('linkSwitchToRegister').addEventListener('click', () => {
            document.getElementById('mobileLoginScreen').classList.remove('active-screen');
            document.getElementById('mobileRegisterScreen').classList.add('active-screen');
        });

        document.getElementById('linkSwitchToLogin').addEventListener('click', () => {
            document.getElementById('mobileRegisterScreen').classList.remove('active-screen');
            document.getElementById('mobileLoginScreen').classList.add('active-screen');
        });

        // Proses Login (Desktop & Mobile)
        function processLogin(username, password, btnElement) {
            overlaySpinner.style.display = 'block';
            overlayTitle.textContent = 'Autentikasi Sistem';
            statusText.className = 'encryption-text text-info';
            statusText.innerHTML = "Memulakan sambungan selamat...";
            btnElement.disabled = true;
            overlay.classList.add('active');

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
                        statusText.innerHTML = "Akun anda salah, periksa kembali email atau kata sandi Anda.";
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

        document.getElementById('registerFormMobile').addEventListener('submit', function(e) {
            e.preventDefault();
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
    </script>
</body>

</html>
