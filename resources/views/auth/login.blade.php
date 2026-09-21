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
            max-width: 1050px;
            height: 600px;
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

        /* === SISI KIRI: Panel Ilustrasi & "Welcome :)" === */
        .login-banner-side {
            flex: 1.1;
            background: linear-gradient(135deg, #091736 0%, #15326e 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            overflow: hidden;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-banner-side::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=1000&q=80') center/cover no-repeat;
            opacity: 0.15;
        }

        .banner-content-overlay {
            position: relative;
            z-index: 2;
            color: #fff;
            margin: auto 0;
        }

        .welcome-big-text {
            font-size: 3.2rem;
            font-weight: 800;
            letter-spacing: -1px;
            color: #ffffff;
            margin-bottom: 0.5rem;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* === SISI KANAN: Form Input & Branding === */
        .login-form-side {
            flex: 1.1;
            padding: 2.5rem 3rem;
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
            font-size: 0.85rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.3rem 1rem;
            border-radius: 50rem;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .brand-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
            margin-bottom: 0.1rem;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
            font-weight: 500;
        }

        .form-label {
            font-weight: 600;
            color: #ffffff;
            font-size: 0.78rem;
            margin-bottom: 0.25rem;
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
            padding-left: 1rem;
            padding-right: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control {
            font-family: 'Plus Jakarta Sans', sans-serif;
            border: none;
            padding: 0.55rem 0.75rem;
            font-size: 0.9rem;
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

        .btn-primary {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #2563eb !important;
            border: none;
            border-radius: 50rem !important;
            padding: 0.6rem;
            font-weight: 700;
            font-size: 0.88rem;
            color: #ffffff !important;
            transition: all 0.2s ease;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
        }

        .btn-primary:hover {
            background: #1d4ed8 !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.6);
        }

        .contact-admin-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            margin-top: 0.4rem;
            padding: 0.45rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
            border: 1px dashed rgba(255, 255, 255, 0.3);
            border-radius: 0.75rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .contact-admin-link:hover {
            background: #ffffff;
            color: #1e3a8a;
            border-color: #ffffff;
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
            border-color: #2563eb;
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
            background-color: #fff;
            outline: none;
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

        /* Elemen khusus mobile */
        .mobile-screen {
            display: none;
        }

        /* === MOBILE STYLING (Fixed Bottom Footer & No Scroll Layout) === */
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
                height: 160px;
                background: linear-gradient(135deg, #091736 0%, #15326e 100%);
                position: relative;
                border-bottom-left-radius: 25px;
                border-bottom-right-radius: 25px;
                overflow: hidden;
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 1rem;
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
                padding: 1rem 1.5rem 5.5rem 1.5rem;
                /* Padding bawah dilebihkan agar tidak tertutup footer fixed */
                display: flex;
                flex-direction: column;
                justify-content: center;
                overflow: hidden;
            }

            /* Footer Fixed Absolut di Bawah untuk Mobile (Tombol & Copyright menyatu tanpa scroll) */
            .mobile-footer-fixed {
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                padding: 1rem 1.55rem 1.25rem 1.55rem;
                background: linear-gradient(to top, #09111e 80%, rgba(9, 17, 30, 0));
                z-index: 10;
                text-align: center;
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
        <!-- SISI KIRI: Panel Ilustrasi & Welcome -->
        <div class="login-banner-side d-none d-md-flex">
            <div>
                <span class="brand-badge-pill">
                    <i class="bi bi-hexagon-fill text-info"></i> Innoventra
                </span>
            </div>
            <div class="banner-content-overlay">
                <div class="welcome-big-text">Welcome :)</div>
                <h5 class="fw-bold mb-2" style="font-size: 1.1rem; color: #38bdf8;">Convert Your Smart Idea to The Great Business</h5>
                <p class="text-white-50 mb-0" style="font-size: 0.8rem; line-height: 1.4;">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
            </div>
            <div>
                <span class="text-white-50" style="font-size: 0.7rem;">&copy; 2026 Innoventra by Transforma &middot; All Rights Reserved</span>
            </div>
        </div>

        <!-- SISI KANAN: Form Input & Login -->
        <div class="login-form-side">
            <div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="brand-badge-pill d-md-none">Innoventra</span>
                    <span class="subtitle">Join over 50 million members from around the globe</span>
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
                            <label for="rememberMeDesk" class="form-check-label text-white small fw-medium" style="font-size: 0.75rem;">Remember me</label>
                        </div>
                        <a href="#" class="text-decoration-none text-white fw-semibold" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        Login
                    </button>

                    <div class="text-center mt-2">
                        <span class="text-white-50" style="font-size: 0.75rem;">Don't have an account? <a href="#" class="text-white fw-bold text-decoration-underline" data-bs-toggle="modal" data-bs-target="#modalHubungiAdmin">Create Account</a></span>
                    </div>

                    <a href="javascript:void(0)" class="contact-admin-link mt-2" data-bs-toggle="modal" data-bs-target="#modalHubungiAdmin">
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
    <!-- TAMPILAN MOBILE (Multi-Screen dengan Fixed Bottom Footer) -->
    <!-- ========================================================== -->

    <!-- SCREEN 1: WELCOME SCREEN (Mobile) -->
    <div id="mobileWelcomeScreen" class="mobile-screen active-screen d-lg-none">
        <div class="m-top-banner" style="height: 220px;">
            <div>
                <span class="brand-badge-pill mb-2"><i class="bi bi-hexagon-fill text-info"></i> Innoventra</span>
                <h1 class="text-white fw-bold mb-1" style="font-size: 2rem;">Welcome :)</h1>
                <p class="text-info small mb-0 fw-semibold" style="font-size: 0.75rem;">Convert Your Smart Idea to The Great Business</p>
            </div>
        </div>
        <div class="m-content-body text-center">
            <p class="text-white-50 small px-2 mb-0" style="font-size: 0.8rem;">Join over 50 million members from around the globe to manage your digital enterprise.</p>
        </div>
        <!-- Footer Fixed Mobile (Welcome) -->
        <div class="mobile-footer-fixed d-lg-none">
            <div class="w-100 mb-2">
                <button type="button" id="btnGoLogin" class="btn btn-primary w-100 mb-2 py-2">
                    LOGIN
                </button>
                <button type="button" id="btnGoRegister" class="btn w-100 py-2 fw-bold text-white" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); border-radius: 50rem;">
                    SIGN UP
                </button>
            </div>
            <span class="text-white opacity-75" style="font-size: 0.68rem;">&copy; 2026 Innoventra by Transforma</span>
        </div>
    </div>

    <!-- SCREEN 2: LOGIN SCREEN (Mobile) -->
    <div id="mobileLoginScreen" class="mobile-screen d-lg-none">
        <div class="m-top-banner" style="height: 130px;">
            <a href="javascript:void(0)" class="m-back-btn btnBackToWelcome"><i class="bi bi-chevron-left"></i></a>
            <div>
                <span class="brand-badge-pill mb-1" style="font-size: 0.7rem;"><i class="bi bi-hexagon-fill text-info"></i> Innoventra</span>
                <h5 class="text-white fw-bold mb-0" style="font-size: 1rem;">Sign in to continue</h5>
            </div>
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

                <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMeMob">
                        <label for="rememberMeMob" class="form-check-label text-white small" style="font-size: 0.72rem;">Remember me</label>
                    </div>
                    <a href="#" class="text-decoration-none text-white fw-semibold" style="font-size: 0.72rem;" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">Forgot password?</a>
                </div>
            </form>
        </div>
        <!-- Footer Fixed Mobile (Login) -->
        <div class="mobile-footer-fixed d-lg-none">
            <button type="submit" form="loginFormMobile" class="btn btn-primary w-100 mb-2 py-2">
                Login
            </button>
            <div class="text-center mb-2">
                <span class="text-white-50 small" style="font-size: 0.72rem;">Don't have an account? <a href="javascript:void(0)" id="linkSwitchToRegister" class="text-white fw-bold text-decoration-underline">Sign up</a></span>
            </div>
            <span class="text-white opacity-75" style="font-size: 0.68rem;">&copy; 2026 Innoventra by Transforma</span>
        </div>
    </div>

    <!-- SCREEN 3: REGISTER SCREEN (Mobile) -->
    <div id="mobileRegisterScreen" class="mobile-screen d-lg-none">
        <div class="m-top-banner" style="height: 120px;">
            <a href="javascript:void(0)" class="m-back-btn btnBackToWelcome"><i class="bi bi-chevron-left"></i></a>
            <div>
                <span class="brand-badge-pill mb-1" style="font-size: 0.7rem;"><i class="bi bi-hexagon-fill text-info"></i> Innoventra</span>
                <h5 class="text-white fw-bold mb-0" style="font-size: 1rem;">Sign up to continue</h5>
            </div>
        </div>
        <div class="m-content-body">
            <form id="registerFormMobile">
                <div class="mb-2 text-start">
                    <label class="form-label" style="font-size: 0.72rem;">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text py-1"><i class="bi bi-envelope"></i></span>
                        <input type="email" id="reg_email" class="form-control py-1" placeholder="Email Address" required>
                    </div>
                </div>

                <div class="mb-2 text-start">
                    <label class="form-label" style="font-size: 0.72rem;">Username</label>
                    <div class="input-group">
                        <span class="input-group-text py-1"><i class="bi bi-person"></i></span>
                        <input type="text" id="reg_username" class="form-control py-1" placeholder="Username" required>
                    </div>
                </div>

                <div class="mb-2 text-start">
                    <label class="form-label" style="font-size: 0.72rem;">Password</label>
                    <div class="input-group">
                        <span class="input-group-text py-1"><i class="bi bi-lock"></i></span>
                        <input type="password" id="reg_password" class="form-control py-1" placeholder="Password" required>
                    </div>
                </div>

                <div class="form-check text-start px-1">
                    <input type="checkbox" class="form-check-input" id="agreeTerms" required>
                    <label for="agreeTerms" class="form-check-label text-white-50" style="font-size: 0.65rem;">
                        I agree to all statements in <a href="#" class="text-white text-decoration-underline">Terms of Use</a>
                    </label>
                </div>
            </form>
        </div>
        <!-- Footer Fixed Mobile (Register) -->
        <div class="mobile-footer-fixed d-lg-none">
            <button type="submit" form="registerFormMobile" class="btn btn-primary w-100 mb-2 py-2">
                Sign Up
            </button>
            <div class="text-center mb-2">
                <span class="text-white-50 small" style="font-size: 0.72rem;">Already a member? <a href="javascript:void(0)" id="linkSwitchToLogin" class="text-white fw-bold text-decoration-underline">Login</a></span>
            </div>
            <span class="text-white opacity-75" style="font-size: 0.68rem;">&copy; 2026 Innoventra by Transforma</span>
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
