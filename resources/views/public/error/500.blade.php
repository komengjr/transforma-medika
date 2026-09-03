<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>500 - Server Sedang Istirahat | Innoventra</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <link rel="manifest" href="{{ asset('asset/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('img/favicon.png') }}">
    <meta name="theme-color" content="#0c4a6e">
    <script src="{{ asset('asset/js/config.js') }}"></script>
    <script src="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/notifications/css/lobibox.min.css') }}" />

    <!-- Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fredoka:wght@600;700&display=swap" rel="stylesheet">

    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('asset/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('asset/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
        if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault?.setAttribute('disabled', true);
            userLinkDefault?.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL?.setAttribute('disabled', true);
            userLinkRTL?.setAttribute('disabled', true);
        }
    </script>

    <!-- Custom Modern Beach Style & Relaxing Animations -->
    <style>
        :root {
            --beach-sand: #fef08a;
            --ocean-blue: #0284c7;
            --cyan-glow: #06b6d4;
            --coral-orange: #f97316;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(180deg, #0c4a6e 0%, #082f49 50%, #0f172a 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Card Beach Glassmorphism */
        .beach-card {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(56, 189, 248, 0.25);
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(2, 132, 199, 0.3);
            position: relative;
            z-index: 10;
        }

        /* ANIMASI SERVER SEDANG ISTIRAHAT (RELAXING BEACH SCENE) */
        .relax-scene {
            position: relative;
            width: 160px;
            height: 100px;
            margin: 0 auto 1rem;
        }

        /* Animasi Server Berjemur */
        .server-relax {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 2.8rem;
            color: #38bdf8;
            filter: drop-shadow(0 6px 10px rgba(0, 0, 0, 0.4));
            animation: breathe 3s ease-in-out infinite alternate;
        }

        /* Animasi Kacamata Hitam Server */
        .sunglasses {
            position: absolute;
            top: 18px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 1.1rem;
            color: #0f172a;
        }

        /* Animasi Pohon Kelapa Bergoyang */
        .palm-tree {
            position: absolute;
            bottom: 15px;
            right: 10px;
            font-size: 2.5rem;
            color: #22c55e;
            transform-origin: bottom center;
            animation: sway 4s ease-in-out infinite alternate;
        }

        /* Animasi Efek Tidur "Zzz" */
        .zzz-container {
            position: absolute;
            top: 0;
            left: 20px;
        }

        .zzz {
            position: absolute;
            font-family: 'Fredoka', cursive;
            font-weight: bold;
            color: #fef08a;
            opacity: 0;
            animation: sleepZ 3s infinite;
        }

        .zzz:nth-child(1) {
            font-size: 1rem;
            animation-delay: 0s;
        }

        .zzz:nth-child(2) {
            font-size: 1.3rem;
            animation-delay: 1s;
            left: 10px;
        }

        .zzz:nth-child(3) {
            font-size: 1.6rem;
            animation-delay: 2s;
            left: 20px;
        }

        @keyframes breathe {
            0% {
                transform: translateX(-50%) scale(1) rotate(-2deg);
            }

            100% {
                transform: translateX(-50%) scale(1.05) rotate(2deg);
            }
        }

        @keyframes sway {
            0% {
                transform: rotate(-5deg);
            }

            100% {
                transform: rotate(6deg);
            }
        }

        @keyframes sleepZ {
            0% {
                opacity: 0;
                transform: translateY(10px) scale(0.8);
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: translateY(-25px) scale(1.2);
            }
        }

        /* 500 Code typography */
        .error-code-beach {
            font-family: 'Fredoka', cursive;
            font-size: clamp(4.5rem, 10vw, 7.5rem);
            background: linear-gradient(135deg, #38bdf8 0%, #06b6d4 50%, #fef08a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
            filter: drop-shadow(0 8px 20px rgba(6, 182, 212, 0.3));
        }

        /* Buttons Optimization */
        .btn-ocean-primary {
            background: linear-gradient(135deg, #0284c7 0%, #06b6d4 100%);
            border: none;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(6, 182, 212, 0.35);
            transition: all 0.25s ease;
        }

        .btn-ocean-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(6, 182, 212, 0.5);
            color: #ffffff;
        }

        .btn-coral-light {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #e2e8f0;
            transition: all 0.25s ease;
        }

        .btn-coral-light:hover {
            background: rgba(249, 115, 22, 0.15);
            border-color: rgba(249, 115, 22, 0.4);
            color: #ffedd5;
            transform: translateY(-2px);
        }

        /* Wave Decoration */
        .ocean-waves {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            z-index: 1;
        }

        .ocean-waves svg {
            position: relative;
            display: block;
            width: calc(140% + 1.3px);
            height: 110px;
            animation: waveMove 10s ease-in-out infinite alternate;
        }

        @keyframes waveMove {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-40px);
            }
        }

        .text-cyan-light {
            color: #cbd5e1;
        }

        .text-sand {
            color: #fef08a;
        }
    </style>
</head>

<body>

    <main class="main" id="top">
        <div class="container" data-layout="container">
            <script>
                var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                if (isFluid) {
                    var container = document.querySelector('[data-layout]');
                    container?.classList.remove('container');
                    container?.classList.add('container-fluid');
                }
            </script>

            <div class="row flex-center min-vh-100 py-5 position-relative" style="z-index: 5;">
                <div class="col-sm-11 col-md-9 col-lg-7 col-xl-6 col-xxl-5 text-center">

                    {{-- Logo Brand --}}
                    <!-- <a class="d-inline-flex flex-center mb-3 text-decoration-none" href="#">
                        <img class="me-2" src="{{ asset('img/favicon.png') }}" alt="Innoventra Logo" width="46" />
                        <span class="font-sans-serif fw-bolder fs-3 text-white tracking-wide">Innoventra</span>
                    </a> -->

                    {{-- Main Card Error Theme Beach --}}
                    <div class="card beach-card">
                        <div class="card-body p-4 p-sm-5">

                            {{-- ANIMASI SERVER BERISTIRAHAT DI PANTAI --}}
                            <div class="relax-scene">
                                {{-- Animasi Zzz --}}
                                <div class="zzz-container">
                                    <span class="zzz">Z</span>
                                    <span class="zzz">z</span>
                                    <span class="zzz">z</span>
                                </div>
                                {{-- Ikon Pohon Kelapa --}}
                                <div class="palm-tree">
                                    <i class="fas fa-tree"></i>
                                </div>
                                {{-- Ikon Server Santai Pakai Kacamata Hitam --}}
                                <div class="server-relax">
                                    <i class="fas fa-server"></i>
                                    <i class="fas fa-glasses sunglasses"></i>
                                </div>
                            </div>

                            {{-- Error Code & Message --}}
                            <div class="error-code-beach unselectable">500</div>
                            <h4 class="fw-bold text-white mt-2 mb-2">Server Sedang Istirahat Sejenak</h4>
                            <p class="text-cyan-light fs-0 mb-4">
                                Server kami sedang dalam perbaikan dan mengambil napas sejenak di tepi pantai. Kami akan segera membangunkannya!
                            </p>

                            {{-- Action Buttons --}}
                            <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center mb-4">
                                <button onclick="window.location.replace('/');" class="btn btn-ocean-primary rounded-pill px-4 py-2.5 fw-bold">
                                    <i class="fas fa-cocktail me-2"></i> Bangunkan & Coba Lagi
                                </button>
                                <button onclick="window.history.back();" class="btn btn-coral-light rounded-pill px-4 py-2.5 fw-semibold">
                                    <i class="fas fa-compass me-2"></i> Kembali
                                </button>
                            </div>

                            <hr class="border-secondary opacity-25 my-4" />

                            {{-- Support Option --}}
                            <div class="d-flex align-items-center justify-content-between text-start text-cyan-light fs--1">
                                <span>Perlu bantuan mendesak?</span>
                                <a href="mailto:info@innoventra.site" class="text-sand fw-bold text-decoration-none">
                                    Hubungi Tim Support <i class="fas fa-life-ring ms-1"></i>
                                </a>
                            </div>

                            {{-- Laravel Exception Debug Info --}}
                            @if(isset($exception) && config('app.debug'))
                            <div class="mt-3 text-start">
                                <button class="btn btn-link btn-sm text-cyan-light p-0 text-decoration-none fs--2" type="button" data-bs-toggle="collapse" data-bs-target="#debugDetail">
                                    <i class="fas fa-bug me-1"></i> Mode Debug (Developer Only)
                                </button>
                                <div class="collapse mt-2" id="debugDetail">
                                    <div class="bg-dark p-3 rounded-3 text-warning font-monospace fs--2 text-break" style="max-height: 140px; overflow-y: auto;">
                                        {{ $exception->getMessage() }}
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>

                    {{-- Footer --}}
                    <p class="text-cyan-light fs--1 mt-4 mb-0 opacity-75">&copy; {{ date('Y') }} Innoventra. All rights reserved.</p>

                </div>
            </div>
        </div>
    </main>

    <!-- Waves SVG Background Animation -->
    <div class="ocean-waves">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0 C150,90 350,-40 500,60 C650,160 900,10 1200,40 L1200,120 L0,120 Z" fill="rgba(56, 189, 248, 0.12)"></path>
            <path d="M0,20 C200,100 450,10 700,70 C950,130 1100,20 1200,50 L1200,120 L0,120 Z" fill="rgba(6, 182, 212, 0.18)"></path>
        </svg>
    </div>

    <!-- JavaScripts Standard Template -->
    <script src="{{ asset('vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('vendors/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{ asset('vendors/typed.js/typed.js')}}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('asset/js/theme.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
