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
            background: #070b14;
            overflow: hidden;
            position: relative;
        }

        /* Background Glow Ambient */
        body::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(13, 148, 136, 0.12) 0%, rgba(0, 0, 0, 0) 70%);
            top: -150px;
            left: -150px;
            z-index: 1;
        }

        body::after {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(46, 100, 194, 0.12) 0%, rgba(0, 0, 0, 0) 70%);
            bottom: -150px;
            right: -150px;
            z-index: 1;
        }

        /* === DESKTOP SPLIT SCREEN LAYOUT === */
        .login-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1160px;
            height: 640px;
            margin: 1.5rem;
            background: rgba(255, 255, 255, 0.99);
            backdrop-filter: blur(25px);
            border-radius: 2rem;
            box-shadow: 0 35px 70px -15px rgba(0, 0, 0, 0.7);
            display: flex;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.4);
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

        /* === SISI KIRI: Informasi & Branding Enterprise === */
        .login-banner-side {
            flex: 1.25;
            background: linear-gradient(135deg, #0f172a, #1e3a8a, #0d9488);
            background-size: 200% 200%;
            animation: gradientBG 15s ease infinite;
            padding: 2.75rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
            position: relative;
            overflow: hidden;
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

        .banner-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            background: #ffffff;
            animation: floatShape 10s ease-in-out infinite;
        }

        .banner-shape.s1 {
            width: 320px;
            height: 320px;
            top: -100px;
            left: -100px;
        }

        .banner-shape.s2 {
            width: 240px;
            height: 240px;
            bottom: -80px;
            right: -80px;
            animation-delay: 3s;
        }

        @keyframes floatShape {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-15px) scale(1.03);
            }
        }

        .banner-content {
            position: relative;
            z-index: 2;
        }

        .desktop-logo-img {
            max-height: 42px;
            width: auto;
            filter: brightness(0) invert(1);
        }

        .banner-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.3rem 0.75rem;
            border-radius: 50rem;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 1.25rem;
            backdrop-filter: blur(5px);
        }

        .banner-content h1 {
            font-weight: 800;
            font-size: 2.1rem;
            letter-spacing: -1px;
            margin-bottom: 0.75rem;
            line-height: 1.2;
        }

        .banner-content p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.88rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            position: relative;
            z-index: 2;
        }

        .feature-item {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.12);
            padding: 0.85rem;
            border-radius: 1rem;
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-2px);
        }

        .feature-icon {
            font-size: 1.15rem;
            color: #38bdf8;
            margin-bottom: 0.25rem;
            display: inline-block;
        }

        .feature-title {
            font-weight: 700;
            font-size: 0.82rem;
            color: #ffffff;
            margin-bottom: 0.1rem;
        }

        .feature-desc {
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
            line-height: 1.3;
        }

        .banner-footer {
            position: relative;
            z-index: 2;
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1rem;
            margin-top: 1rem;
        }

        /* === SISI KANAN: Form Input & Modern Styling === */
        .login-form-side {
            flex: 1;
            padding: 2.2rem 2.75rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow-y: auto;
            background: #ffffff;
        }

        .form-card-box {
            background: #ffffff;
            border-radius: 1rem;
            padding: 0.5rem 0;
            width: 100%;
            margin: 0;
        }

        .mobile-logo-img {
            max-height: 36px;
            width: auto;
            object-fit: contain;
        }

        .brand-title {
            font-size: 1.45rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .subtitle {
            color: #64748b;
            font-size: 0.8rem;
            margin-top: 0.2rem;
            font-weight: 500;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            font-size: 0.8rem;
            margin-bottom: 0.3rem;
        }

        .input-group {
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
            overflow: hidden;
            background-color: #f8fafc;
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            border-color: #0d9488;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.12);
        }

        .input-group-text {
            background-color: transparent;
            border: none;
            color: #64748b;
            padding-left: 0.85rem;
            padding-right: 0.5rem;
            font-size: 0.95rem;
        }

        .form-control {
            font-family: 'Plus Jakarta Sans', sans-serif;
            border: none;
            padding: 0.65rem 0.75rem;
            font-size: 0.85rem;
            background-color: transparent !important;
            box-shadow: none !important;
        }

        .btn-primary {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #2e64c2, #0d9488);
            border: none;
            border-radius: 0.75rem;
            padding: 0.7rem;
            font-weight: 700;
            font-size: 0.88rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            filter: brightness(1.1);
            box-shadow: 0 6px 15px rgba(13, 148, 136, 0.25);
        }

        .animated-info-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 0.6rem 0.85rem;
            margin-top: 1rem;
            font-size: 0.75rem;
            color: #475569;
        }

        .animated-info-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 600;
        }

        .animated-info-item i {
            color: #0d9488;
            font-size: 0.9rem;
        }

        .pulse-dot {
            width: 7px;
            height: 7px;
            background-color: #22c55e;
            border-radius: 50%;
            display: inline-block;
            animation: pulseGlow 1.5s infinite ease-in-out;
        }

        @keyframes pulseGlow {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4);
            }

            50% {
                transform: scale(1.3);
                opacity: 0.8;
                box-shadow: 0 0 0 5px rgba(34, 197, 94, 0);
            }
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
            border-color: #0d9488;
            box-shadow: 0 0 0 0.2rem rgba(13, 148, 136, 0.15);
            background-color: #fff;
            outline: none;
        }

        #login-overlay {
            position: fixed;
            inset: 0;
            background: rgba(7, 11, 20, 0.85);
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
            border: 1px solid rgba(13, 148, 136, 0.4);
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
            border: 3px solid rgba(13, 148, 136, 0.2);
            border-top: 3px solid #0d9488;
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
            color: #2dd4bf;
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

        .custom-swal-confirm-btn {
            background: linear-gradient(135deg, #2e64c2, #0d9488) !important;
            border: none !important;
            border-radius: 0.65rem !important;
            padding: 0.6rem 2rem !important;
            font-weight: 700 !important;
        }

        @media (max-width: 992px) {
            body {
                background: linear-gradient(135deg, #0f172a, #1e3a8a, #0d9488);
                background-size: 200% 200%;
                animation: gradientBG 15s ease infinite;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow-y: auto;
                padding: 1rem;
            }

            body::before,
            body::after {
                display: none;
            }

            .login-wrapper {
                max-width: 400px;
                width: 100%;
                height: auto;
                margin: auto;
                flex-direction: column;
                border-radius: 1.5rem;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            }

            .login-banner-side {
                display: none;
            }

            .login-form-side {
                padding: 2rem 1.5rem;
                justify-content: center;
            }

            .animated-info-bar {
                display: none !important;
            }

            .otp-input {
                width: 38px;
                height: 44px;
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Layar Overlay Loading -->
    <div id="login-overlay">
        <div class="encryption-box">
            <div class="encryption-spinner" id="overlaySpinner"></div>
            <div class="encryption-title" id="overlayTitle">Autentikasi Sistem</div>
            <div id="encryptionStatus" class="encryption-text">Memulakan sambungan selamat...</div>
        </div>
    </div>

    <!-- UTAMA: Wrapper Desktop Split Screen & Mobile Centered Card -->
    <div class="login-wrapper">

        <!-- SISI KIRI: Informasi & Branding Enterprise -->
        <div class="login-banner-side">
            <div class="banner-shape s1"></div>
            <div class="banner-shape s2"></div>

            <div class="banner-content">
                <div class="banner-badge">
                    <i class="bi bi-shield-check-fill text-teal"></i> Secure Enterprise Portal v2.6
                </div>
                <div class="mb-2">
                    <img src="{{ asset('img/logo-pt.png') }}" alt="Logo" class="desktop-logo-img">
                </div>
                <h1>Mendorong<br>Transformasi Digital.</h1>
                <p>Platform pemantauan terintegrasi berkecepatan tinggi untuk manajemen dan operasional data perusahaan secara real-time.</p>

                <div class="feature-grid mt-3">
                    <div class="feature-item">
                        <i class="bi bi-shield-lock feature-icon"></i>
                        <div class="feature-title">End-to-End Encryption</div>
                        <p class="feature-desc">Perlindungan data berlapis standar enterprise.</p>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-speedometer2 feature-icon"></i>
                        <div class="feature-title">Real-Time Sync</div>
                        <p class="feature-desc">Sinkronisasi data langsung tanpa jeda waktu.</p>
                    </div>
                </div>
            </div>

            <div class="banner-footer">
                <span><i class="bi bi-circle-fill text-success" style="font-size: 7px;"></i> Server Online &middot; 99.9% Uptime</span>
                <span>&copy; 2026 Innoventra</span>
            </div>
        </div>

        <!-- SISI KANAN: Form Input -->
        <div class="login-form-side">
            <!-- Bagian Atas: Header & Selamat Datang -->
            <div class="text-center text-lg-start">
                <div class="d-lg-none text-center mb-2">
                    <img src="{{ asset('img/logo-pt.png') }}" alt="Innoventra Logo" class="mobile-logo-img">
                </div>

                <div class="brand-title">Selamat Datang! 👋</div>
                <div class="subtitle">Sila masukkan akses akaun anda untuk meneruskan</div>
            </div>

            <!-- BAGIAN CARD FORM -->
            <div class="form-card-box my-3">
                <form id="loginForm">
                    <div class="mb-3 text-start">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" id="username" class="form-control" placeholder="Masukkan username Anda" required autocomplete="username">
                        </div>
                    </div>

                    <div class="mb-3 text-start">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" id="password" class="form-control" placeholder="Masukkan kata sandi" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe">
                            <label for="rememberMe" class="form-check-label text-secondary small fw-medium" style="font-size: 0.78rem;">Ingat saya</label>
                        </div>
                        <a href="#" class="text-decoration-none text-primary small fw-semibold" style="font-size: 0.78rem;" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">Lupa Password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
                    </button>
                </form>
            </div>

            <!-- Bagian Bawah: Informasi Tambahan Beranimasi & Footer -->
            <div>
                <div class="animated-info-bar d-none d-lg-flex">
                    <div class="animated-info-item">
                        <i class="bi bi-shield-shaded"></i>
                        <span>Sistem Terenkripsi</span>
                    </div>
                    <div class="animated-info-item">
                        <span class="pulse-dot"></span>
                        <span>Gateway Aktif</span>
                    </div>
                    <div class="animated-info-item">
                        <i class="bi bi-cpu"></i>
                        <span>Optimized</span>
                    </div>
                </div>

                <span id="notifikasi-login" class="d-none"></span>

                <div class="text-center mt-2 d-lg-none">
                    <span class="text-muted" style="font-size: 0.72rem;">&copy; 2026 Innoventra by Transforma</span>
                </div>
            </div>
        </div>

    </div>

    <!-- ================= MODAL LUPA & RESET PASSWORD ================= -->
    <div class="modal fade" id="modalLupaPassword" tabindex="-1" aria-labelledby="modalLupaPasswordLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">

                <div class="modal-header border-0 text-center flex-column pb-0 pt-4" style="background: linear-gradient(135deg, rgba(46, 100, 194, 0.08), rgba(13, 148, 136, 0.08));">
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
                                <label for="email" class="form-label">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" id="email" class="form-control" placeholder="contoh@email.com" required>
                                </div>
                            </div>
                            <button type="submit" id="btnKirimOtp" class="btn btn-primary w-100 mt-2">
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

                            <button type="submit" id="btnVerifikasiOtp" class="btn btn-primary w-100">
                                <i class="bi bi-patch-check me-2"></i>Verifikasi OTP
                            </button>
                        </form>

                        <div class="mt-3">
                            <small class="text-muted" style="font-size: 0.8rem;">Tidak menerima kode?
                                <a href="javascript:void(0)" id="btnKirimUlangOtp" class="text-decoration-none fw-semibold">Kirim Ulang</a>
                            </small>
                        </div>
                    </div>

                    <div id="step-reset" style="display: none;">
                        <form id="formResetPassword">
                            <div class="mb-3 text-start">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                                    <input type="password" id="new_password" class="form-control" placeholder="Masukkan password baru" required>
                                </div>
                            </div>

                            <div class="mb-3 text-start">
                                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="bi bi-check2-circle"></i></span>
                                    <input type="password" id="confirm_password" class="form-control" placeholder="Ulangi password baru" required>
                                </div>
                            </div>

                            <button type="submit" id="btnSimpanPassword" class="btn btn-primary w-100 mt-2">
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
            const btn = form.querySelector('button');

            // Reset tampilan overlay ke mode loading awal
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
                        // Ubah status loading menjadi pesan gagal di dalam kotak hitam/gelap
                        overlaySpinner.style.display = 'none';
                        overlayTitle.textContent = 'Gagal Masuk';
                        statusText.className = 'encryption-text text-danger';
                        statusText.innerHTML = "Akun anda salah, periksa kembali username atau kata sandi Anda.";

                        // Tutup overlay otomatis setelah 2.2 detik agar user sempat membaca
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
