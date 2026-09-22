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
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            overflow: hidden;
            position: relative;
        }

        /* === ANIMASI LATAR BELAKANG DESKTOP === */
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
                repeating-linear-gradient(45deg, rgba(255, 255, 255, 0.02) 0, rgba(255, 255, 255, 0.02) 1px, transparent 0, transparent 50px),
                repeating-linear-gradient(-45deg, rgba(255, 255, 255, 0.01) 0, rgba(255, 255, 255, 0.01) 1px, transparent 0, transparent 40px);
        }

        .bubble {
            position: absolute;
            bottom: -150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            animation: rise 12s infinite ease-in-out;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(2px);
            border: 1.5px solid rgba(255, 255, 255, 0.1);
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
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.9) 100%);
            backdrop-filter: blur(25px);
            border-radius: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            display: flex;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
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
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.3rem 1.25rem;
            border-radius: 50rem;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
        }

        .brand-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin-bottom: 0.2rem;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.7);
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
            background-color: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            border-color: #2dd4bf;
            box-shadow: 0 0 0 4px rgba(45, 212, 191, 0.2);
        }

        .input-group-text {
            background-color: transparent;
            border: none;
            color: #94a3b8;
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
            color: #ffffff !important;
        }

        .form-control::placeholder {
            color: #64748b !important;
        }

        .btn-mint {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #5eead4 !important;
            border: none;
            border-radius: 50rem !important;
            padding: 0.7rem;
            font-weight: 700;
            font-size: 0.9rem;
            color: #0f172a !important;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(94, 234, 212, 0.3);
        }

        .btn-mint:hover {
            transform: translateY(-2px);
            background: #2dd4bf !important;
            box-shadow: 0 6px 20px rgba(45, 212, 191, 0.5);
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
            background: rgba(255, 255, 255, 0.05);
            border: 1px dashed rgba(255, 255, 255, 0.2);
            border-radius: 0.85rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .contact-admin-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #2dd4bf;
            color: #5eead4;
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
            background: linear-gradient(to top, rgba(15, 23, 42, 0.85) 0%, transparent 60%);
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
            background: rgba(15, 23, 42, 0.9);
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
            border: 1px solid rgba(94, 234, 212, 0.4);
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
            border: 3px solid rgba(94, 234, 212, 0.2);
            border-top: 3px solid #5eead4;
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
            color: #5eead4;
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

        /* === MOBILE STYLING (3 LAYER DARK MODE SEPERTI REFERENSI GAMBAR) === */
        @media (max-width: 992px) {
            body {
                background: #000000 !important;
                height: 100vh;
                height: 100dvh;
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
                max-width: 420px;
                max-height: 100%;
                position: absolute;
                top: 0;
                left: 50%;
                transform: translateX(-50%);
                background: #0b0f19;
                color: #ffffff;
                overflow-y: auto;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
                border-radius: 0px;
                animation: slideScreen 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }

            @keyframes slideScreen {
                0% {
                    opacity: 0;
                    transform: translate(-50%, 15px);
                }

                100% {
                    opacity: 1;
                    transform: translate(-50%, 0);
                }
            }

            .mobile-screen:not(.active-screen) {
                display: none !important;
            }

            /* Status Bar Ponsel Atas ala iOS */
            .m-status-bar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 14px 24px 6px 24px;
                font-size: 0.8rem;
                font-weight: 600;
                color: #ffffff;
                background: #0b0f19;
            }

            .m-status-icons {
                display: flex;
                gap: 6px;
                font-size: 0.75rem;
            }

            /* Input Group Dark Mode */
            .mobile-screen .input-group {
                background-color: #121826 !important;
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 0.85rem;
            }

            .mobile-screen .input-group:focus-within {
                border-color: #5eead4 !important;
                box-shadow: 0 0 0 3px rgba(94, 234, 212, 0.15);
            }

            .mobile-screen .form-control {
                color: #ffffff !important;
                font-size: 0.85rem;
            }

            .mobile-screen .form-control::placeholder {
                color: #475569 !important;
            }

            /* Social Login Buttons Dark */
            .social-btn-group-dark {
                display: flex;
                justify-content: center;
                gap: 12px;
                margin-top: 0.4rem;
                margin-bottom: 0.4rem;
            }

            .social-pill-btn-dark {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                width: 100%;
                background: #121826;
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: 50rem;
                padding: 0.65rem;
                font-size: 0.82rem;
                font-weight: 600;
                color: #ffffff;
                text-decoration: none;
                transition: all 0.2s ease;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            }

            .social-pill-btn-dark:hover {
                background: #1e293b;
                border-color: rgba(255, 255, 255, 0.2);
                color: #5eead4;
            }

            .m-divider {
                display: flex;
                align-items: center;
                text-align: center;
                color: #475569;
                font-size: 0.7rem;
                margin: 0.75rem 0;
            }

            .m-divider::before,
            .m-divider::after {
                content: '';
                flex: 1;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            }

            .m-divider::before {
                margin-right: .75rem;
            }

            .m-divider::after {
                margin-left: .75rem;
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
                            <span class="input-group-text"><i class="bi bi-envelope-fill text-info"></i></span>
                            <input type="text" id="username_desk" class="form-control" placeholder="Email Address / Username" required autocomplete="username">
                        </div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="password_desk" class="form-label">Kata Sandi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill text-info"></i></span>
                            <input type="password" id="password_desk" class="form-control" placeholder="Password" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3 px-1">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMeDesk">
                            <label for="rememberMeDesk" class="form-check-label text-white small fw-medium" style="font-size: 0.78rem;">Ingat saya</label>
                        </div>
                        <a href="#" class="text-decoration-none text-info fw-semibold" style="font-size: 0.78rem;" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">Forget Password?</a>
                    </div>

                    <button type="submit" class="btn btn-mint w-100 mb-3">
                        Sign In / Masuk
                    </button>

                    <a href="javascript:void(0)" class="contact-admin-link" data-bs-toggle="modal" data-bs-target="#modalHubungiAdmin">
                        <i class="bi bi-headset text-info"></i> Hubungi Admin Sistem
                    </a>
                </form>
            </div>

            <div class="text-center mt-2">
                <span class="text-white opacity-50" style="font-size: 0.7rem;">&copy; 2026 Innoventra by Transforma &middot; Syarat & Ketentuan</span>
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
    <!-- TAMPILAN MOBILE: 3 LAYER (Sesuai Referensi Gambar Baru)   -->
    <!-- ========================================================== -->

    <!-- LAYER 1: WELCOME / REGISTER PROMPT (Mobile)[cite: 3] -->
    <div id="mobileWelcomeScreen" class="mobile-screen active-screen d-lg-none">
        <div class="m-status-bar">
            <span>9:41</span>
            <div class="m-status-icons">
                <i class="bi bi-cellular"></i>
                <i class="bi bi-wifi"></i>
                <i class="bi bi-battery-full"></i>
            </div>
        </div>

        <div class="flex-grow-1 d-flex flex-column px-4 pt-3 pb-4 justify-content-between">
            <!-- Ilustrasi Chat UI Card -->
            <div class="p-3 rounded-4 shadow-lg border border-secondary border-opacity-25" style="background: #121826;">
                <div class="d-flex align-items-center mb-2 bg-dark bg-opacity-50 p-2 rounded-3 border border-secondary border-opacity-10">
                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white me-2" style="width: 28px; height: 28px; font-size: 11px;"><i class="bi bi-person-fill"></i></div>
                    <div style="font-size: 0.7rem; color: #cbd5e1;">How can AI optimize my business processes quickly?</div>
                </div>
                <div class="d-flex align-items-center mb-2 bg-dark bg-opacity-50 p-2 rounded-3 border border-secondary border-opacity-10 ms-3">
                    <div class="rounded-circle bg-success d-flex align-items-center justify-content-center text-white me-2" style="width: 28px; height: 28px; font-size: 11px;"><i class="bi bi-robot"></i></div>
                    <div style="font-size: 0.7rem; color: #cbd5e1;">How long will the integration process usually take?</div>
                </div>
                <div class="d-flex align-items-center bg-dark bg-opacity-50 p-2 rounded-3 border border-secondary border-opacity-10">
                    <div class="rounded-circle bg-info d-flex align-items-center justify-content-center text-white me-2" style="width: 28px; height: 28px; font-size: 11px;"><i class="bi bi-chat-dots-fill"></i></div>
                    <div style="font-size: 0.7rem; color: #cbd5e1;">Can AI help streamline operations and reduce costs?</div>
                </div>
            </div>

            <!-- Teks & Tombol Utama -->
            <div class="text-start mt-4">
                <h2 class="fw-bold text-white mb-2" style="font-size: 1.6rem; letter-spacing: -0.5px;">Let's register account</h2>
                <p class="text-secondary mb-4" style="font-size: 0.8rem; line-height: 1.5;">Enjoy for reading and writing blog posts. Get $ 1.00 dollars you referral your friends.</p>

                <button type="button" id="btnGoRegisterFromWelcome" class="btn btn-mint w-100 py-3 mb-3 fw-bold rounded-pill shadow-sm">
                    Get Started
                </button>
            </div>

            <div class="text-center pb-2">
                <span class="text-secondary" style="font-size: 0.78rem;">Already have an account? <a href="javascript:void(0)" id="linkToLoginFromWelcome" class="fw-bold text-decoration-none text-info">Login</a></span>
            </div>
        </div>
    </div>

    <!-- LAYER 2: SIGN IN / LOGIN (Mobile)[cite: 3] -->
    <div id="mobileLoginScreen" class="mobile-screen d-lg-none">
        <div class="m-status-bar">
            <span>9:41</span>
            <div class="m-status-icons">
                <i class="bi bi-cellular"></i>
                <i class="bi bi-wifi"></i>
                <i class="bi bi-battery-full"></i>
            </div>
        </div>

        <div class="flex-grow-1 d-flex flex-column px-4 py-3 justify-content-between">
            <div>
                <div class="text-start mb-4 mt-2">
                    <h2 class="fw-bold text-white mb-1" style="font-size: 1.6rem; letter-spacing: -0.5px;">Let's sign in</h2>
                    <p class="text-secondary" style="font-size: 0.78rem;">Welcome Back, You have been missed.</p>
                </div>

                <form id="loginFormMobile">
                    <div class="mb-3 text-start">
                        <label class="form-label text-white-50" style="font-size: 0.72rem;">Email</label>
                        <div class="input-group">
                            <input type="text" id="username_mob" class="form-control" placeholder="email" required autocomplete="username">
                        </div>
                    </div>

                    <div class="mb-2 text-start">
                        <label class="form-label text-white-50" style="font-size: 0.72rem;">Password</label>
                        <div class="input-group">
                            <input type="password" id="password_mob" class="form-control" placeholder="password" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 px-1">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input bg-dark border-secondary" id="rememberMeMob">
                            <label for="rememberMeMob" class="form-check-label text-secondary" style="font-size: 0.73rem;">Remember Me</label>
                        </div>
                        <a href="#" class="text-decoration-none fw-semibold text-info" style="font-size: 0.73rem;" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">Forgot Password</a>
                    </div>

                    <button type="submit" class="btn btn-mint w-100 py-3 fw-bold rounded-pill shadow-sm mb-3">
                        Get Started
                    </button>

                    <div class="m-divider">or continue with</div>

                    <div class="d-flex flex-column gap-2 mt-2">
                        <a href="#" class="social-pill-btn-dark">
                            <i class="bi bi-facebook text-primary fs-5"></i> Continue with Facebook
                        </a>
                        <a href="#" class="social-pill-btn-dark">
                            <i class="bi bi-google text-danger fs-5"></i> Continue with Google
                        </a>
                        <a href="#" class="social-pill-btn-dark">
                            <i class="bi bi-apple text-white fs-5"></i> Continue with Apple
                        </a>
                    </div>
                </form>
            </div>

            <div class="text-center py-2">
                <span class="text-secondary" style="font-size: 0.78rem;">Don't have any account? <a href="javascript:void(0)" id="linkToGoRegister" class="fw-bold text-decoration-none text-info">Register Now</a></span>
            </div>
        </div>
    </div>

    <!-- LAYER 3: REGISTER ACCOUNT (Mobile)[cite: 3] -->
    <div id="mobileRegisterScreen" class="mobile-screen d-lg-none">
        <div class="m-status-bar">
            <span>9:41</span>
            <div class="m-status-icons">
                <i class="bi bi-cellular"></i>
                <i class="bi bi-wifi"></i>
                <i class="bi bi-battery-full"></i>
            </div>
        </div>

        <div class="flex-grow-1 d-flex flex-column px-4 py-2 justify-content-between">
            <div>
                <div class="text-start mb-3 mt-1">
                    <h2 class="fw-bold text-white mb-1" style="font-size: 1.5rem; letter-spacing: -0.5px;">Let's register account</h2>
                    <p class="text-secondary" style="font-size: 0.73rem;">Enjoy for reading and wiriting blog posts. Get $ 1.00 dollars you referral your friends.</p>
                </div>

                <form id="registerFormMobile">
                    <div class="mb-2 text-start">
                        <label class="form-label text-white-50" style="font-size: 0.7rem;">Name</label>
                        <div class="input-group">
                            <input type="text" id="reg_name" class="form-control" placeholder="name" required>
                        </div>
                    </div>

                    <div class="mb-2 text-start">
                        <label class="form-label text-white-50" style="font-size: 0.7rem;">Email</label>
                        <div class="input-group">
                            <input type="email" id="reg_email" class="form-control" placeholder="email" required>
                        </div>
                    </div>

                    <div class="mb-2 text-start">
                        <label class="form-label text-white-50" style="font-size: 0.7rem;">Password</label>
                        <div class="input-group">
                            <input type="password" id="reg_password" class="form-control" placeholder="password" required>
                        </div>
                    </div>

                    <p class="text-secondary text-start mb-3" style="font-size: 0.65rem; line-height: 1.4;">
                        By clicking register button you agree to our <a href="#" class="text-info text-decoration-none">terms and conditions</a> and <a href="#" class="text-info text-decoration-none">privacy policy</a>.
                    </p>

                    <button type="submit" class="btn btn-mint w-100 py-2.5 fw-bold rounded-pill shadow-sm mb-2">
                        Register
                    </button>
                </form>
            </div>

            <div class="text-center py-2">
                <span class="text-secondary" style="font-size: 0.78rem;">Already have an account? <a href="javascript:void(0)" id="linkBackToLogin" class="fw-bold text-decoration-none text-info">Login</a></span>
            </div>
        </div>
    </div>


    <!-- ================= MODAL HUBUNGI ADMIN SISTEM ================= -->
    <div class="modal fade" id="modalHubungiAdmin" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg bg-dark text-white border border-secondary border-opacity-25" style="border-radius: 1.5rem; overflow: hidden;">
                <div class="modal-header border-0 text-center flex-column pb-0 pt-4" style="background: rgba(255, 255, 255, 0.02);">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="p-3 bg-secondary bg-opacity-25 rounded-circle shadow-sm mb-2 d-inline-flex align-items-center justify-content-center text-info" style="width: 60px; height: 60px;">
                        <i class="bi bi-headset fs-4"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-white mt-1">Pusat Bantuan Admin</h5>
                    <p class="text-secondary small px-3" style="font-size: 0.82rem;">Sampaikan kendala atau pertanyaan Anda kepada tim pengelola sistem.</p>
                </div>
                <div class="modal-body p-4">
                    <form id="formHubungiAdmin">
                        <div class="mb-3 text-start">
                            <label class="form-label text-white-50">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" id="contact_name" class="form-control" placeholder="Masukkan nama Anda" required>
                            </div>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label text-white-50">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" id="contact_email" class="form-control" placeholder="email@domain.com" required>
                            </div>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label text-white-50">Deskripsi / Kendala</label>
                            <div class="input-group">
                                <span class="input-group-text align-items-start pt-2"><i class="bi bi-chat-left-text"></i></span>
                                <textarea id="contact_desc" class="form-control" rows="4" placeholder="Jelaskan kendala Anda..." required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-mint w-100 mt-2 rounded-3 fw-bold text-dark">
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
            <div class="modal-content border-0 shadow-lg bg-dark text-white border border-secondary border-opacity-25" style="border-radius: 1.5rem; overflow: hidden;">
                <div class="modal-header border-0 text-center flex-column pb-0 pt-4" style="background: rgba(255, 255, 255, 0.02);">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="p-3 bg-secondary bg-opacity-25 rounded-circle shadow-sm mb-2 d-inline-flex align-items-center justify-content-center text-info" style="width: 60px; height: 60px;">
                        <i class="bi bi-shield-lock-fill fs-4"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-white mt-1">Reset Password</h5>
                    <p class="text-secondary small px-3" style="font-size: 0.82rem;">Masukkan email terdaftar untuk pemulihan akun.</p>
                </div>
                <div class="modal-body p-4 text-center">
                    <form id="formKirimOtp">
                        <div class="mb-3 text-start">
                            <label class="form-label text-white-50">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" id="email_reset" class="form-control" placeholder="contoh@email.com" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-mint w-100 text-dark rounded-3 py-2 fw-bold">Kirim Permintaan Reset</button>
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

        // Navigasi Antar Layer Mobile (Welcome -> Register / Login)
        document.getElementById('btnGoRegisterFromWelcome').addEventListener('click', () => {
            document.getElementById('mobileWelcomeScreen').classList.remove('active-screen');
            document.getElementById('mobileRegisterScreen').classList.add('active-screen');
        });

        document.getElementById('linkToLoginFromWelcome').addEventListener('click', () => {
            document.getElementById('mobileWelcomeScreen').classList.remove('active-screen');
            document.getElementById('mobileLoginScreen').classList.add('active-screen');
        });

        document.getElementById('linkToGoRegister').addEventListener('click', () => {
            document.getElementById('mobileLoginScreen').classList.remove('active-screen');
            document.getElementById('mobileRegisterScreen').classList.add('active-screen');
        });

        document.getElementById('linkBackToLogin').addEventListener('click', () => {
            document.getElementById('mobileRegisterScreen').classList.remove('active-screen');
            document.getElementById('mobileLoginScreen').classList.add('active-screen');
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

        // Handler Pendaftaran Akun Mobile
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
                Swal.fire({
                    icon: 'success',
                    title: 'Pendaftaran Berhasil!',
                    text: 'Akun Anda telah berhasil dibuat. Silakan login.',
                    confirmButtonText: 'MASUK SEKARANG'
                }).then(() => {
                    document.getElementById('mobileRegisterScreen').classList.remove('active-screen');
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
