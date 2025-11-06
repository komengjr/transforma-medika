<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Innoventra by Transforma</title>

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

        /* Lottie Animation Container */
        #lottie-background {
            position: absolute;
            inset: 0;
            z-index: 0;
            opacity: 0.5;
            pointer-events: none;
        }

        /* Floating gradient shapes */
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

        /* Login Card */
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
            /* font-weight: 600; */
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

        @media (max-width: 576px) {
            .login-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Gradient Shapes -->
    <div class="gradient-shape one"></div>
    <div class="gradient-shape two"></div>

    <!-- Lottie Animation -->
    <div id="lottie-background"></div>

    <!-- Login Card -->
    <div class="login-card">

        <div class="logo">
            <img src="https://innoventra.site/img/favicon.png" alt="Innoventra Logo">
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
                <a href="#" class="text-decoration-none text-primary">Lupa Password?</a>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Lottie Animation Script -->
    <script>
        // Background animation (digital transformation theme)
        lottie.loadAnimation({
            container: document.getElementById('lottie-background'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: "{{asset('img/json/4.json')}}"
            // animasi tema "Digital transformation / innovation background"
        });

        // Login Form Handler
        const form = document.getElementById('loginForm');
        form.addEventListener('submit', function (e) {
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
            }).done(function (data) {
                $('#notifikasi-login').html(data);
                btn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang';
                btn.disabled = false;
            }).fail(function () {
                btn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang';
                btn.disabled = false;
            });
            // setTimeout(() => {
            //     if (username === "admin" && password === "innoventra123") {
            //         alert("Selamat datang di Innoventra, " + username + "!");
            //         window.location.href = "dashboard.html";
            //     } else {
            //         alert("Username atau password salah!");
            //         btn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang';
            //         btn.disabled = false;
            //     }
            // }, 1000);
        });
    </script>
</body>

</html>
