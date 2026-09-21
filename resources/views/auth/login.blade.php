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
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #db2777 100%);
            overflow: hidden;
            position: relative;
        }

        /* === ANIMASI BALON & GARIS-GARIS DI LATAR BELAKANG === */
        .bubble-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
            pointer-events: none;
            background-image:
                repeating-linear-gradient(45deg, rgba(255, 255, 255, 0.05) 0, rgba(255, 255, 255, 0.05) 1px, transparent 0, transparent 50px),
                repeating-linear-gradient(-45deg, rgba(255, 255, 255, 0.03) 0, rgba(255, 255, 255, 0.03) 1px, transparent 0, transparent 40px);
        }

        .bubble {
            position: absolute;
            bottom: -150px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            animation: rise 12s infinite ease-in-out;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(2px);
            border: 1.5px solid rgba(255, 255, 255, 0.3);
        }

        .bubble:nth-child(1) {
            width: 90px;
            height: 90px;
            left: 10%;
            animation-duration: 10s;
            animation-delay: 0s;
        }

        .bubble:nth-child(2) {
            width: 130px;
            height: 130px;
            left: 25%;
            animation-duration: 15s;
            animation-delay: 2s;
        }

        .bubble:nth-child(3) {
            width: 70px;
            height: 70px;
            left: 45%;
            animation-duration: 9s;
            animation-delay: 1s;
        }

        .bubble:nth-child(4) {
            width: 160px;
            height: 160px;
            left: 65%;
            animation-duration: 18s;
            animation-delay: 3s;
        }

        .bubble:nth-child(5) {
            width: 100px;
            height: 100px;
            left: 85%;
            animation-duration: 11s;
            animation-delay: 2s;
        }

        @keyframes rise {
            0% {
                transform: translateY(0) scale(1) rotate(0deg);
                opacity: 0;
            }

            20% {
                opacity: 0.8;
            }

            80% {
                opacity: 0.8;
            }

            100% {
                transform: translateY(-110vh) scale(1.08) rotate(360deg);
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
            background: linear-gradient(135deg, rgba(30, 27, 75, 0.9) 0%, rgba(76, 29, 149, 0.85) 100%);
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
        }

        .brand-badge-pill {
            display: inline-block;
            font-weight: 700;
            font-size: 0.95rem;
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 0.3rem 1.25rem;
            border-radius: 50rem;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
        }

        .brand-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin-bottom: 0.2rem;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.85);
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
            box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.4);
        }

        .input-group-text {
            background-color: transparent;
            border: none;
            color: #555;
            padding-left: 1rem;
            padding-right: 0.5rem;
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
            background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%) !important;
            border: none;
            border-radius: 50rem !important;
            padding: 0.65rem;
            font-weight: 700;
            font-size: 0.9rem;
            color: #ffffff !important;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(236, 72, 153, 0.6);
            filter: brightness(1.1);
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
            color: #4f46e5;
            border-color: #ffffff;
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
            background: linear-gradient(to top, rgba(15, 23, 42, 0.7) 0%, transparent 60%);
            border-radius: 2rem;
        }

        .banner-content-overlay {
            position: relative;
            z-index: 2;
            color: #fff;
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
            border: 1px solid rgba(236, 72, 153, 0.5);
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
            border: 3px solid rgba(236, 72, 153, 0.2);
            border-top: 3px solid #ec4899;
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
            color: #f472b6;
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

        /* === MOBILE STYLING (FULL DI ATAS TANPA SPACE KOSONG) === */
        @media (max-width: 992px) {
            body {
                background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 50%, #ec4899 100%) !important;
                height: 100vh;
                height: 100dvh;
                /* Menyesuaikan tinggi dinamis browser mobile */
                width: 100vw;
                margin: 0;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden !important;
                position: fixed;
                inset: 0;
            }

            .login-wrapper {
                display: none !important;
            }

            .mobile-screen {
                display: flex;
                flex-direction: column;
                width: 100%;
                height: 100vh;
                height: 100dvh;
                max-width: 100%;
                max-height: 100%;
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: #ffffff;
                overflow-y: auto;
                box-shadow: none;
                border-radius: 0px;
                /* Full layar merapat */
                animation: slideScreen 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }

            @keyframes slideScreen {
                0% {
                    opacity: 0;
                    transform: translateY(15px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .mobile-screen:not(.active-screen) {
                display: none !important;
            }

            /* Header Ilustrasi Mobile menempel rapat di atas */
            .m-header-mockup {
                background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
                padding: 2.2rem 1.5rem 1.2rem 1.5rem;
                text-align: center;
                position: relative;
                color: #ffffff;
                overflow: hidden;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }

            /* Garis-garis dekoratif di header mobile */
            .m-header-mockup::before {
                content: '';
                position: absolute;
                inset: 0;
                background-image: repeating-linear-gradient(120deg, rgba(236, 72, 153, 0.15) 0px, rgba(236, 72, 153, 0.15) 2px, transparent 2px, transparent 15px);
                pointer-events: none;
            }

            .m-dots {
                display: flex;
                justify-content: center;
                gap: 6px;
                margin-bottom: 1rem;
                position: relative;
                z-index: 2;
            }

            .m-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.3);
                transition: all 0.3s ease;
            }

            .m-dot.active {
                background: #ec4899;
                width: 22px;
                border-radius: 10px;
                box-shadow: 0 0 10px #ec4899;
            }

            .m-header-mockup h4,
            .m-header-mockup p {
                position: relative;
                z-index: 2;
            }

            .m-content-body {
                flex: 1;
                padding: 1.5rem 1.75rem 2rem 1.75rem;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                background: #ffffff;
            }

            .m-content-body .form-label {
                color: #334155 !important;
            }

            .m-content-body .input-group {
                background-color: #f8fafc !important;
                border: 1px solid #e2e8f0 !important;
                transition: all 0.3s ease;
            }

            .m-content-body .input-group:focus-within {
                border-color: #8b5cf6 !important;
                box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15) !important;
            }

            .m-content-body .form-control {
                color: #0f172a !important;
            }

            .m-divider {
                display: flex;
                align-items: center;
                text-align: center;
                color: #94a3b8;
                font-size: 0.75rem;
                margin: 0.75rem 0;
            }

            .m-divider::before,
            .m-divider::after {
                content: '';
                flex: 1;
                border-bottom: 1px solid #e2e8f0;
            }

            .m-divider::before {
                margin-right: .75rem;
            }

            .m-divider::after {
                margin-left: .75rem;
            }

            .btn-outline-custom {
                width: 100%;
                background: #ffffff;
                border: 2px solid #8b5cf6;
                border-radius: 50rem;
                padding: 0.65rem;
                font-weight: 700;
                font-size: 0.9rem;
                color: #7c3aed;
                text-align: center;
                text-decoration: none;
                display: block;
                transition: all 0.2s ease;
            }

            .btn-outline-custom:hover {
                background: #f5f3ff;
                border-color: #7c3aed;
                color: #6d28d9;
                transform: translateY(-1px);
            }
        }
    </style>
</head>

<body>
    <!-- Balon Melayang & Garis Latar Belakang -->
    <div class="bubble-bg">
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
        <div class="bubble"></div>
    </div>

    <!-- Loading Overlay -->
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
                            <span class="input-group-text"><i class="bi bi-envelope-fill text-primary"></i></span>
                            <input type="text" id="username_desk" class="form-control" placeholder="Email Address / Username" required autocomplete="username">
                        </div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="password_desk" class="form-label">Kata Sandi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill text-primary"></i></span>
                            <input type="password" id="password_desk" class="form-control" placeholder="Password" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3 px-1">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMeDesk">
                            <label for="rememberMeDesk" class="form-check-label text-white small fw-medium" style="font-size: 0.78rem;">Ingat saya</label>
                        </div>
                        <a href="#" class="text-decoration-none text-pink-light fw-semibold text-warning" style="font-size: 0.78rem;" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">Forget Password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        Sign In / Masuk
                    </button>

                    <a href="javascript:void(0)" class="contact-admin-link" data-bs-toggle="modal" data-bs-target="#modalHubungiAdmin">
                        <i class="bi bi-headset text-warning"></i> Hubungi Admin Sistem
                    </a>
                </form>
            </div>

            <div class="text-center mt-2">
                <span class="text-white opacity-75" style="font-size: 0.7rem;">&copy; 2026 Innoventra by Transforma &middot; Syarat & Ketentuan</span>
            </div>
        </div>

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
    <!-- TAMPILAN MOBILE: 3 LAYER (Login, Create, Verify) -->
    <!-- ========================================================== -->

    <!-- LAYER 1: LOGIN ACCOUNT (Mobile) -->
    <div id="mobileLoginScreen" class="mobile-screen active-screen d-lg-none">
        <div class="m-header-mockup">
            <div class="m-dots">
                <div class="m-dot active"></div>
                <div class="m-dot"></div>
                <div class="m-dot"></div>
            </div>
            <div class="py-2">
                <div class="bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-lg" style="width: 68px; height: 68px; background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);">
                    <i class="bi bi-fingerprint fs-2"></i>
                </div>
            </div>
            <h4 class="fw-bold text-white mt-2 mb-1" style="font-size: 1.35rem;">Login Account</h4>
            <p class="text-white-50 mb-0" style="font-size: 0.74rem; padding: 0 1rem;">Selamat datang kembali, silakan masuk ke akun Anda dengan aman.</p>
        </div>

        <div class="m-content-body">
            <form id="loginFormMobile">
                <div class="mb-3 text-start">
                    <label class="form-label small fw-bold">Email Account</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0 text-primary"><i class="bi bi-envelope"></i></span>
                        <input type="email" id="username_mob" class="form-control" placeholder="name@example.com" required autocomplete="username">
                    </div>
                </div>

                <div class="mb-2 text-start">
                    <label class="form-label small fw-bold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0 text-primary"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password_mob" class="form-control" placeholder="••••••••" required autocomplete="current-password">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMeMob">
                        <label for="rememberMeMob" class="form-check-label text-muted small" style="font-size: 0.75rem;">Save Password</label>
                    </div>
                    <a href="#" class="text-decoration-none fw-semibold" style="font-size: 0.75rem; color: #8b5cf6;" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-2 py-2.5">
                    LOGIN
                </button>

                <div class="m-divider">OR</div>

                <button type="button" id="btnGoRegister" class="btn-outline-custom">
                    CREATE ACCOUNT
                </button>
            </form>

            <div class="text-center mt-3">
                <span class="text-muted" style="font-size: 0.68rem;">&copy; 2026 Innoventra by Transforma</span>
            </div>
        </div>
    </div>

    <!-- LAYER 2: CREATE ACCOUNT (Mobile) -->
    <div id="mobileRegisterScreen" class="mobile-screen d-lg-none">
        <div class="m-header-mockup" style="padding-top: 1.8rem; padding-bottom: 0.8rem;">
            <div class="m-dots">
                <div class="m-dot"></div>
                <div class="m-dot active"></div>
                <div class="m-dot"></div>
            </div>
            <h4 class="fw-bold text-white mb-1" style="font-size: 1.25rem;">Create Account</h4>
            <p class="text-white-50 mb-0" style="font-size: 0.72rem; padding: 0 1rem;">Daftarkan diri Anda untuk menikmati layanan penuh sistem kami.</p>
        </div>

        <div class="m-content-body" style="padding-top: 1rem;">
            <form id="registerFormMobile">
                <div class="row g-2 mb-2">
                    <div class="col-6 text-start">
                        <label class="form-label" style="font-size: 0.72rem;">First Name</label>
                        <div class="input-group">
                            <input type="text" id="reg_firstname" class="form-control form-control-sm" placeholder="First Name" required>
                        </div>
                    </div>
                    <div class="col-6 text-start">
                        <label class="form-label" style="font-size: 0.72rem;">Last Name</label>
                        <div class="input-group">
                            <input type="text" id="reg_lastname" class="form-control form-control-sm" placeholder="Last Name" required>
                        </div>
                    </div>
                </div>

                <div class="mb-2 text-start">
                    <label class="form-label" style="font-size: 0.72rem;">Email Account</label>
                    <div class="input-group">
                        <input type="email" id="reg_email" class="form-control form-control-sm" placeholder="Email address" required>
                    </div>
                </div>

                <div class="mb-2 text-start">
                    <label class="form-label" style="font-size: 0.72rem;">Username</label>
                    <div class="input-group">
                        <input type="text" id="reg_username" class="form-control form-control-sm" placeholder="Username" required>
                        <span class="input-group-text text-success"><i class="bi bi-check-circle-fill"></i></span>
                    </div>
                </div>

                <div class="mb-2 text-start">
                    <label class="form-label" style="font-size: 0.72rem;">Birthday</label>
                    <div class="row g-1">
                        <div class="col-4">
                            <select class="form-select form-select-sm" style="font-size: 0.78rem; background-color: #f8fafc;">
                                <option selected>Day</option>
                                <option>01</option>
                                <option>02</option>
                                <option>03</option>
                                <option>04</option>
                                <option>05</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <select class="form-select form-select-sm" style="font-size: 0.78rem; background-color: #f8fafc;">
                                <option selected>Month</option>
                                <option>Jan</option>
                                <option>Feb</option>
                                <option>Mar</option>
                                <option>Apr</option>
                                <option>May</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <select class="form-select form-select-sm" style="font-size: 0.78rem; background-color: #f8fafc;">
                                <option selected>Year</option>
                                <option>2000</option>
                                <option>2001</option>
                                <option>2002</option>
                                <option>2003</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-2 text-start">
                    <label class="form-label" style="font-size: 0.72rem;">Password</label>
                    <div class="input-group">
                        <input type="password" id="reg_password" class="form-control form-control-sm" placeholder="Password" required>
                    </div>
                </div>

                <div class="form-check mb-3 text-start">
                    <input type="checkbox" class="form-check-input" id="agreeTerms" required>
                    <label for="agreeTerms" class="form-check-label text-muted" style="font-size: 0.72rem;">Agree with <a href="#" class="fw-bold" style="color: #8b5cf6;">Terms & Conditions</a></label>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-2 py-2">
                    CREATE ACCOUNT
                </button>

                <div class="m-divider my-1">OR</div>

                <button type="button" id="btnBackToLogin" class="btn-outline-custom py-1.5" style="font-size: 0.82rem;">
                    BACK TO LOGIN
                </button>
            </form>
        </div>
    </div>

    <!-- LAYER 3: VERIFY ACCOUNT (Mobile) -->
    <div id="mobileVerifyScreen" class="mobile-screen d-lg-none">
        <div class="m-header-mockup">
            <div class="m-dots">
                <div class="m-dot"></div>
                <div class="m-dot"></div>
                <div class="m-dot active"></div>
            </div>
            <div class="py-1">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center shadow-lg text-white" style="width: 68px; height: 68px; background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);">
                    <i class="bi bi-shield-check fs-2"></i>
                </div>
            </div>
            <h4 class="fw-bold text-white mt-2 mb-1" style="font-size: 1.35rem;">Verify Account</h4>
            <p class="text-white-50 mb-0" style="font-size: 0.74rem; padding: 0 1rem;">Verifikasi nomor telepon atau email Anda untuk aktivasi akun penuh.</p>
        </div>

        <div class="m-content-body">
            <form id="verifyFormMobile">
                <!-- Toggle Tab pilihan verifikasi Phone / Email -->
                <div class="bg-light p-1 rounded-pill d-flex mb-3 border">
                    <button type="button" class="flex-fill btn btn-sm rounded-pill btn-primary shadow-sm py-1 fw-bold" id="tabPhone" style="font-size: 0.75rem;">PHONE</button>
                    <button type="button" class="flex-fill btn btn-sm rounded-pill text-muted py-1 fw-bold" id="tabEmail" style="font-size: 0.75rem;">Email</button>
                </div>

                <div class="mb-3 text-start" id="inputContainerVerify">
                    <label class="form-label small fw-bold">Phone Number</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0 text-muted">+62</span>
                        <input type="tel" id="verify_phone" class="form-control" placeholder="812-3456-7890" required>
                    </div>
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label small fw-bold">Account Password</label>
                    <div class="input-group">
                        <input type="password" id="verify_password" class="form-control" placeholder="Enter password to confirm" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3 py-2.5">
                    VERIFY PHONE
                </button>

                <div class="text-center">
                    <a href="javascript:void(0)" id="linkBackToLoginFromVerify" class="text-muted small text-decoration-none" style="font-size: 0.78rem;">
                        <i class="bi bi-arrow-left me-1"></i> Return to Login
                    </a>
                </div>
            </form>

            <div class="text-center mt-3">
                <span class="text-muted" style="font-size: 0.68rem;">&copy; 2026 Innoventra by Transforma</span>
            </div>
        </div>
    </div>


    <!-- ================= MODAL HUBUNGI ADMIN SISTEM ================= -->
    <div class="modal fade" id="modalHubungiAdmin" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                <div class="modal-header border-0 text-center flex-column pb-0 pt-4" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.08), rgba(0, 0, 0, 0.02));">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="p-3 bg-white rounded-circle shadow-sm mb-2 d-inline-flex align-items-center justify-content-center text-primary" style="width: 60px; height: 60px;">
                        <i class="bi bi-headset fs-4"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark mt-1">Pusat Bantuan Admin</h5>
                    <p class="text-muted small px-3" style="font-size: 0.82rem;">Sampaikan kendala atau pertanyaan Anda kepada tim pengelola sistem.</p>
                </div>
                <div class="modal-body p-4">
                    <form id="formHubungiAdmin">
                        <div class="mb-3 text-start">
                            <label class="form-label text-dark">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" id="contact_name" class="form-control" placeholder="Masukkan nama Anda" required>
                            </div>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label text-dark">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" id="contact_email" class="form-control" placeholder="email@domain.com" required>
                            </div>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label text-dark">Deskripsi / Kendala</label>
                            <div class="input-group">
                                <span class="input-group-text align-items-start pt-2"><i class="bi bi-chat-left-text"></i></span>
                                <textarea id="contact_desc" class="form-control" rows="4" placeholder="Jelaskan kendala Anda..." required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 mt-2 rounded-3 text-white" style="background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%) !important; border: none;">
                            <i class="bi bi-send-fill me-2"></i>Kirim Pesan ke Admin
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= MODAL LUPA PASSWORD ================= -->
    <div class="modal fade" id="modalLupaPassword" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
                <div class="modal-header border-0 text-center flex-column pb-0 pt-4" style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.08), rgba(0, 0, 0, 0.02));">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="p-3 bg-white rounded-circle shadow-sm mb-2 d-inline-flex align-items-center justify-content-center text-primary" style="width: 60px; height: 60px;">
                        <i class="bi bi-shield-lock-fill fs-4"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark mt-1">Reset Password</h5>
                    <p class="text-muted small px-3" style="font-size: 0.82rem;">Masukkan email terdaftar untuk pemulihan akun.</p>
                </div>
                <div class="modal-body p-4 text-center">
                    <form id="formKirimOtp">
                        <div class="mb-3 text-start">
                            <label class="form-label text-dark">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" id="email_reset" class="form-control" placeholder="contoh@email.com" required>
                            </div>
                        </div>
                        <button type="submit" class="btn w-100 text-white rounded-3 py-2" style="background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%); border: none;">Kirim Permintaan Reset</button>
                    </form>
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

        // Navigasi antar Layer Mobile
        document.getElementById('btnGoRegister').addEventListener('click', () => {
            document.getElementById('mobileLoginScreen').classList.remove('active-screen');
            document.getElementById('mobileRegisterScreen').classList.add('active-screen');
        });

        document.getElementById('btnBackToLogin').addEventListener('click', () => {
            document.getElementById('mobileRegisterScreen').classList.remove('active-screen');
            document.getElementById('mobileLoginScreen').classList.add('active-screen');
        });

        document.getElementById('linkBackToLoginFromVerify').addEventListener('click', () => {
            document.getElementById('mobileVerifyScreen').classList.remove('active-screen');
            document.getElementById('mobileLoginScreen').classList.add('active-screen');
        });

        // Tab Switcher pada Layer 3 (Verify Account: Phone / Email)
        $('#tabPhone').on('click', function() {
            $(this).addClass('btn-primary shadow-sm text-white').removeClass('text-muted');
            $('#tabEmail').removeClass('btn-primary shadow-sm text-white').addClass('text-muted');
            $('#inputContainerVerify').html(`
                <label class="form-label small fw-bold">Phone Number</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-0 text-muted">+62</span>
                    <input type="tel" id="verify_phone" class="form-control" placeholder="812-3456-7890" required>
                </div>
            `);
            $('#verifyFormMobile button[type="submit"]').text('VERIFY PHONE');
        });

        $('#tabEmail').on('click', function() {
            $(this).addClass('btn-primary shadow-sm text-white').removeClass('text-muted');
            $('#tabPhone').removeClass('btn-primary shadow-sm text-white').addClass('text-muted');
            $('#inputContainerVerify').html(`
                <label class="form-label small fw-bold">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-envelope"></i></span>
                    <input type="email" id="verify_email_input" class="form-control" placeholder="name@example.com" required>
                </div>
            `);
            $('#verifyFormMobile button[type="submit"]').text('VERIFY EMAIL');
        });

        // Handler Proses Login
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

        // Handler Pendaftaran dari Layer 2 -> Berpindah otomatis ke Layer 3 (Verify Account)
        document.getElementById('registerFormMobile').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');

            overlaySpinner.style.display = 'block';
            overlayTitle.textContent = 'Pendaftaran Akun';
            statusText.className = 'encryption-text text-info';
            statusText.innerHTML = "Menyimpan data akaun baru...";
            btn.disabled = true;
            overlay.classList.add('active');

            setTimeout(() => {
                overlay.classList.remove('active');
                btn.disabled = false;

                // Pindah ke Layer 3 (Verify Account)
                document.getElementById('mobileRegisterScreen').classList.remove('active-screen');
                document.getElementById('mobileVerifyScreen').classList.add('active-screen');
            }, 1200);
        });

        // Handler Submit Verifikasi (Layer 3)
        document.getElementById('verifyFormMobile').addEventListener('submit', function(e) {
            e.preventDefault();
            overlaySpinner.style.display = 'block';
            overlayTitle.textContent = 'Verifikasi Akun';
            statusText.className = 'encryption-text text-info';
            statusText.innerHTML = "Mengesahkan kod verifikasi...";
            overlay.classList.add('active');

            setTimeout(() => {
                overlay.classList.remove('active');
                Swal.fire({
                    icon: 'success',
                    title: 'Verifikasi Berhasil!',
                    text: 'Akun Anda telah aktif dan terverifikasi sepenuhnya.',
                    confirmButtonText: 'MASUK SEKARANG'
                }).then(() => {
                    document.getElementById('mobileVerifyScreen').classList.remove('active-screen');
                    document.getElementById('mobileLoginScreen').classList.add('active-screen');
                });
            }, 1500);
        });

        $('#formHubungiAdmin').on('submit', function(e) {
            e.preventDefault();
            $('#modalHubungiAdmin').modal('hide');
            Swal.fire('Terkirim!', 'Pesan Anda telah diteruskan ke admin.', 'success');
            $('#formHubungiAdmin')[0].reset();
        });

        $('#formKirimOtp').on('submit', function(e) {
            e.preventDefault();
            $('#modalLupaPassword').modal('hide');
            Swal.fire('Berhasil', 'Instruksi reset password telah dikirim ke email Anda.', 'success');
        });
    </script>
</body>

</html>
