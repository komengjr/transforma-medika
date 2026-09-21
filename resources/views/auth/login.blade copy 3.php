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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- Lottie -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.0/lottie.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e9f5ff, #ffffff);
            overflow: hidden;
            position: relative;
        }

        #lottie-background {
            position: absolute;
            inset: 0;
            z-index: 0;
            opacity: 0.5;
            pointer-events: none;
        }

        .gradient-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.5;
            animation: float 10s ease-in-out infinite;
        }

        .gradient-shape.one {
            width: 300px;
            height: 300px;
            background: #39c46a;
            top: 10%;
            left: 8%;
            animation-delay: 0s;
        }

        .gradient-shape.two {
            width: 400px;
            height: 400px;
            background: #2e64c2;
            bottom: 5%;
            right: 10%;
            animation-delay: 3s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-25px);
            }
        }

        .login-card {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.1);
            max-width: 460px;
            width: 100%;
            padding: 2.5rem;
            padding-top: 0.7rem;
            margin: 1rem;
            text-align: center;
            animation: fadeInUp 1s ease forwards;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo img {
            width: 140px;
            margin-bottom: 0;
            animation: fadeIn 1.2s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .brand-text {
            font-size: 1.3rem;
            color: #2e64c2;
        }

        .subtitle {
            color: #777;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem;
            border-color: #d0d9e2;
        }

        .form-control:focus {
            border-color: #39c46a;
            box-shadow: 0 0 0 0.25rem rgba(57, 196, 106, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2e64c2, #39c46a);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: scale(1.03);
            filter: brightness(1.1);
        }

        .footer-text {
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #666;
        }

        .footer-text strong {
            color: #2e64c2;
        }

        .otp-input-container {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .otp-input {
            width: 50px;
            height: 55px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            border-radius: 0.5rem;
            border: 2px solid #d0d9e2;
        }

        .otp-input:focus {
            border-color: #39c46a;
            box-shadow: 0 0 0 0.2rem rgba(57, 196, 106, 0.25);
            outline: none;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 2rem 1.5rem;
            }

            .otp-input {
                width: 40px;
                height: 48px;
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <div class="gradient-shape one"></div>
    <div class="gradient-shape two"></div>

    <div id="lottie-background"></div>

    <div class="login-card">
        <div class="logo">
            <img src="{{ asset('img/logo-pt.png') }}" alt="Innoventra Logo">
        </div>
        <div class="brand-text">Innoventra by <small class="text-success">Transforma</small></div>
        <div class="subtitle">Masuk ke sistem</div>

        <form id="loginForm">
            <div class="mb-3 text-start">
                <label for="username" class="form-label fw-semibold">Username</label>
                <input type="text" id="username" class="form-control" placeholder="Masukkan username Anda" required>
            </div>

            <div class="mb-3 text-start">
                <label for="password" class="form-label fw-semibold">Kata Sandi</label>
                <input type="password" id="password" class="form-control" placeholder="Masukkan kata sandi" required>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label for="rememberMe" class="form-check-label">Ingat saya</label>
                </div>
                <a href="#" class="text-decoration-none text-primary" data-bs-toggle="modal" data-bs-target="#modalLupaPassword">Lupa Password?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
            </button>
        </form>
        <span id="notifikasi-login" class="pb-0 mt-0"></span>
        <div class="footer-text">
            © 2025 <strong>Innoventra by Transforma</strong> — Mendorong Transformasi Digital.
        </div>
    </div>

    <!-- ================= MODAL LUPA & RESET PASSWORD ================= -->
    <div class="modal fade" id="modalLupaPassword" tabindex="-1" aria-labelledby="modalLupaPasswordLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">

                <div class="modal-header border-0 text-center flex-column pb-0 pt-4" style="background: linear-gradient(135deg, rgba(46, 100, 194, 0.08), rgba(57, 196, 106, 0.08));">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>

                    <div class="p-3 bg-white rounded-circle shadow-sm mb-2 d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                        <i id="modalHeaderIcon" class="bi bi-shield-lock-fill text-primary display-6"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark mt-2" id="modalTitleText">Reset Password</h5>
                    <p class="text-muted small px-3" id="modalSubTitleText">Masukkan email terdaftar untuk menerima kode verifikasi OTP.</p>
                </div>

                <div class="modal-body p-4 text-center">

                    <!-- STEP 1: Form Input Email -->
                    <div id="step-email">
                        <form id="formKirimOtp">
                            <div class="mb-3 text-start">
                                <label for="email" class="form-label fw-semibold">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 0.75rem 0 0 0.75rem;">
                                        <i class="bi bi-envelope text-secondary"></i>
                                    </span>
                                    <input type="email" id="email" class="form-control border-start-0" placeholder="contoh@email.com" style="border-radius: 0 0.75rem 0.75rem 0;" required>
                                </div>
                            </div>
                            <button type="submit" id="btnKirimOtp" class="btn btn-primary w-100 mt-2">
                                <i class="bi bi-send me-2"></i>Kirim Kode OTP
                            </button>
                        </form>
                    </div>

                    <!-- STEP 2: Input 6 Digit OTP -->
                    <div id="step-otp" style="display: none;">
                        <p class="text-muted small mb-2">Kode OTP 6 digit telah dikirim ke email <strong id="displayEmailText" class="text-dark"></strong>.</p>

                        <form id="formVerifikasiOtp">
                            <div class="otp-input-container my-4">
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
                            <small class="text-muted">Tidak menerima kode?
                                <a href="javascript:void(0)" id="btnKirimUlangOtp" class="text-decoration-none fw-semibold">Kirim Ulang</a>
                            </small>
                        </div>
                    </div>

                    <!-- STEP 3: Form Input Password Baru -->
                    <div id="step-reset" style="display: none;">
                        <form id="formResetPassword">
                            <div class="mb-3 text-start">
                                <label for="new_password" class="form-label fw-semibold">Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 0.75rem 0 0 0.75rem;">
                                        <i class="bi bi-key text-secondary"></i>
                                    </span>
                                    <input type="password" id="new_password" class="form-control border-start-0" placeholder="Masukkan password baru" style="border-radius: 0 0.75rem 0.75rem 0;" required>
                                </div>
                            </div>

                            <div class="mb-3 text-start">
                                <label for="confirm_password" class="form-label fw-semibold">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0" style="border-radius: 0.75rem 0 0 0.75rem;">
                                        <i class="bi bi-check2-circle text-secondary"></i>
                                    </span>
                                    <input type="password" id="confirm_password" class="form-control border-start-0" placeholder="Ulangi password baru" style="border-radius: 0 0.75rem 0.75rem 0;" required>
                                </div>
                            </div>

                            <button type="submit" id="btnSimpanPassword" class="btn btn-primary w-100 mt-2">
                                <i class="bi bi-box-arrow-in-down me-2"></i>Simpan Password Baru
                            </button>
                        </form>
                    </div>

                    <span id="notifikasi-otp" class="d-block mt-3"></span>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        if (window.innerWidth >= 768) {
            lottie.loadAnimation({
                container: document.getElementById('lottie-background'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: "{{asset('img/json/4.json')}}"
            });
        }

        // Login Handler
        const form = document.getElementById('loginForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const btn = form.querySelector('button');

            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memeriksa...';
            btn.disabled = true;
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
                $('#notifikasi-login').html(data);
                btn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang';
                btn.disabled = false;
            }).fail(function() {
                btn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang';
                btn.disabled = false;
            });
        });

        // OTP Box Navigation
        const otpInputs = document.querySelectorAll('.otp-input');
        otpInputs.forEach((input, index) => {
            input.addEventListener('keyup', (e) => {
                if (e.key >= 0 && e.key <= 9) {
                    if (index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                } else if (e.key === 'Backspace') {
                    if (index > 0) {
                        otpInputs[index - 1].focus();
                    }
                }
            });

            input.addEventListener('paste', (e) => {
                const pasteData = e.clipboardData.getData('text').trim();
                if (pasteData.length === 6 && /^\d+$/.test(pasteData)) {
                    pasteData.split('').forEach((char, i) => {
                        otpInputs[i].value = char;
                    });
                    otpInputs[5].focus();
                }
                e.preventDefault();
            });
        });

        // Step 1: Send OTP Email
        $('#formKirimOtp').on('submit', function(e) {
            e.preventDefault();
            const email = $('#email').val().trim();
            const btn = $('#btnKirimOtp');

            btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...').prop('disabled', true);

            $.ajax({
                url: "{{ route('verifikasi_send_email') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "email": email
                },
                dataType: 'json',
            }).done(function(res) {
                $('#modalHeaderIcon').attr('class', 'bi bi-phone-vibrate-fill text-success display-6');
                $('#modalTitleText').text('Verifikasi Kode OTP');
                $('#modalSubTitleText').text('Masukkan 6 digit angka yang dikirim ke email Anda.');

                $('#displayEmailText').text(email);
                $('#step-email').hide();
                $('#step-otp').fadeIn();
                $('#notifikasi-otp').html('');
                $('.otp-input').first().focus();
            }).fail(function(xhr) {
                let msg = 'Gagal mengirim OTP. Pastikan email terdaftar!';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                $('#notifikasi-otp').html('<div class="alert alert-danger p-2 small mt-2">' + msg + '</div>');
            }).always(function() {
                btn.html('<i class="bi bi-send me-2"></i>Kirim Kode OTP').prop('disabled', false);
            });
        });

        $('#btnKirimUlangOtp').on('click', function() {
            $('#formKirimOtp').submit();
        });

        // Step 2: Cek Validasi OTP via AJAX
        $('#formVerifikasiOtp').on('submit', function(e) {
            e.preventDefault();

            let otpValue = '';
            $('.otp-input').each(function() {
                otpValue += $(this).val();
            });

            if (otpValue.length < 6) {
                $('#notifikasi-otp').html('<div class="alert alert-warning p-2 small">Masukkan 6 digit kode OTP secara lengkap!</div>');
                return;
            }

            const btn = $('#btnVerifikasiOtp');
            btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Memeriksa OTP...').prop('disabled', true);

            $.ajax({
                url: "{{ route('verifikasi_otp_check') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "email": $('#email').val().trim(),
                    "otp": otpValue
                },
                dataType: 'json',
            }).done(function(res) {
                $('#modalHeaderIcon').attr('class', 'bi bi-lock-fill text-primary display-6');
                $('#modalTitleText').text('Password Baru');
                $('#modalSubTitleText').text('Buat kata sandi baru untuk akun Anda.');

                $('#step-otp').hide();
                $('#step-reset').fadeIn();
                $('#notifikasi-otp').html('');
            }).fail(function(xhr) {
                let msg = 'Kode OTP yang Anda masukkan salah!';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                $('#notifikasi-otp').html('<div class="alert alert-danger p-2 small mt-2">' + msg + '</div>');

                $('.otp-input').val('');
                $('.otp-input').first().focus();
            }).always(function() {
                btn.html('<i class="bi bi-patch-check me-2"></i>Verifikasi OTP').prop('disabled', false);
            });
        });

        // Step 3: Simpan Password Baru
        $('#formResetPassword').on('submit', function(e) {
            e.preventDefault();
            const pass = $('#new_password').val();
            const confirmPass = $('#confirm_password').val();

            let otpValue = '';
            $('.otp-input').each(function() {
                otpValue += $(this).val();
            });

            if (pass !== confirmPass) {
                $('#notifikasi-otp').html('<div class="alert alert-danger p-2 small">Konfirmasi password tidak cocok!</div>');
                return;
            }

            const btn = $('#btnSimpanPassword');
            btn.html('<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...').prop('disabled', true);

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
            }).done(function(res) {
                $('#notifikasi-otp').html('<div class="alert alert-success p-2 small">Password berhasil diubah! Silakan login.</div>');
                setTimeout(function() {
                    $('#modalLupaPassword').modal('hide');
                }, 2000);
            }).fail(function(xhr) {
                let msg = 'Gagal mereset password!';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                $('#notifikasi-otp').html('<div class="alert alert-danger p-2 small">' + msg + '</div>');
            }).always(function() {
                btn.html('<i class="bi bi-box-arrow-in-down me-2"></i>Simpan Password Baru').prop('disabled', false);
            });
        });

        // Reset Modal ke Semula Saat Ditutup
        $('#modalLupaPassword').on('hidden.bs.modal', function() {
            $('#modalHeaderIcon').attr('class', 'bi bi-shield-lock-fill text-primary display-6');
            $('#modalTitleText').text('Reset Password');
            $('#modalSubTitleText').text('Masukkan email terdaftar untuk menerima kode verifikasi OTP.');

            $('#step-otp, #step-reset').hide();
            $('#step-email').show();
            $('#formKirimOtp')[0].reset();
            $('#formVerifikasiOtp')[0].reset();
            $('#formResetPassword')[0].reset();
            $('#notifikasi-otp').html('');
        });
    </script>
</body>

</html>
