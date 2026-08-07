<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Document Title -->
    <title>{{ env('APP_NAME')}} | Management System</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <link rel="manifest" href="../../../asset/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="{{ asset('img/favicon.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('asset/js/config.js') }}"></script>

    <!-- Stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('asset/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('asset/css/user.min.css') }}" rel="stylesheet" id="user-style-default">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
        if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>

    <style>
        /* Animated Background */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(-45deg, #e0e7ff, #f3e8ff, #e0f2fe, #f4f7fe);
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
            min-height: 100vh;
        }

        @keyframes gradientAnimation {
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

        /* Header Fix Layering */
        .glass-header-container {
            position: relative;
            z-index: 1050;
            /* Memastikan header & dropdown diatas marquee */
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-radius: 20px !important;
            border: 1px solid rgba(255, 255, 255, 0.6) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        /* Fix Dropdown z-index tertutup marquee & card */
        .dropdown-menu {
            z-index: 99999 !important;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        }

        /* Marquee Container Layering */
        .marquee-container {
            position: relative;
            z-index: 10;
        }

        /* Modern Card Menu UI */
        .menu-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            height: 220px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            z-index: 1;
        }

        .menu-card .card-bg-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
            z-index: 1;
        }

        .menu-card .card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.2) 0%, rgba(15, 23, 42, 0.85) 100%);
            z-index: 2;
            transition: background 0.3s ease;
        }

        .menu-card .card-content {
            position: relative;
            z-index: 3;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.5rem;
            color: #ffffff;
        }

        .menu-card .menu-icon-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 3;
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .menu-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.18);
        }

        .menu-card:hover .card-bg-img {
            transform: scale(1.15);
        }

        .menu-card:hover .card-overlay {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.1) 0%, rgba(15, 23, 42, 0.95) 100%);
        }

        .menu-card .card-title {
            font-weight: 700;
            letter-spacing: 0.5px;
            font-size: 1.15rem;
            margin-bottom: 0.3rem;
            color: #ffffff !important;
            text-transform: uppercase;
        }

        .menu-card .card-text {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-align: left;
        }

        /* Coming Soon Card Style */
        .coming-soon-card {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(8px);
            border: 2px dashed #94a3b8;
            border-radius: 20px;
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 1.5rem;
        }

        /* Modern Bottom Navigation for Mobile */
        .kaki {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            position: fixed;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 25px;
            width: 90%;
            max-width: 450px;
            height: 65px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            z-index: 99999;
            padding: 0 10px;
        }

        .kaki .nav-link-custom {
            color: #94a3b8;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            text-decoration: none;
            transition: color 0.2s;
        }

        .kaki .nav-link-custom i {
            font-size: 1.2rem;
            margin-bottom: 2px;
        }

        .kaki .nav-link-custom.active,
        .kaki .nav-link-custom:hover {
            color: #38bdf8;
        }
    </style>
</head>

<body>
    <main class="main" id="top">
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">

                    <!-- Header Card -->
                    <div class="glass-header-container mb-4">
                        <div class="card glass-header border-0">
                            <div class="card-body p-3 p-md-4">
                                <div class="row align-items-center justify-content-between g-3">
                                    <div class="col-auto d-flex align-items-center">
                                        <img class="me-3" src="{{asset('img/favicon.png')}}" alt="Logo" width="55">
                                        <div>
                                            <span class="badge bg-soft-primary text-primary fw-semibold mb-1">Innoventra System</span>
                                            <h3 class="fw-bold text-dark mb-0 fs-1 fs-sm-2">Dashboard <span class="text-primary">Home</span></h3>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="text-end d-none d-sm-block">
                                                <h6 class="mb-0 text-dark fw-bold">Hi, {{Auth::user()->fullname}}</h6>
                                                <small class="text-muted">{{ ucfirst(Auth::user()->access_code) }}</small>
                                            </div>

                                            <div class="avatar avatar-xl position-relative">
                                                <img class="rounded-circle border border-2 border-primary shadow-sm" src="{{asset('img/pp.png')}}" alt="Profile" />
                                            </div>

                                            <!-- Dropdown Menu -->
                                            <div class="dropdown">
                                                <button class="btn btn-light rounded-circle p-2 shadow-sm" type="button" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v text-secondary"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 mt-2" aria-labelledby="dropdownUser">
                                                    <li>
                                                        <button class="dropdown-item py-2" id="button-menu-utama">
                                                            <i class="fab fa-dashcube me-2 text-primary"></i> Menu Utama
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item py-2" data-bs-toggle="modal" data-bs-target="#modal-keuangan" id="button-proses-transaksi">
                                                            <i class="fas fa-key me-2 text-warning"></i> Ubah Kata Sandi
                                                        </button>
                                                    </li>
                                                    @if (Auth::user()->access_code == 'master')
                                                    <li>
                                                        <button class="dropdown-item py-2" id="button-master-dashboard">
                                                            <i class="fas fa-cog me-2 text-info"></i> Master Page
                                                        </button>
                                                    </li>
                                                    @endif
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item py-2 text-danger" id="button-logout">
                                                            <i class="fas fa-sign-out-alt me-2"></i> Log Out
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Marquee Announcement -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-primary text-white overflow-hidden marquee-container">
                        <div class="card-body py-2 px-3 d-flex align-items-center">
                            <i class="fas fa-bullhorn me-3 fs-0"></i>
                            <marquee class="m-0 fw-medium fs--1" behavior="scroll" direction="left">
                                Selamat Datang di Innoventra System Management — Solusi Integrasi Sistem Terlengkap untuk Bisnis Anda.
                            </marquee>
                        </div>
                    </div>

                    <!-- Grid Menu Features -->
                    <div class="row g-4">
                        @if (Auth::user()->access_code == 'master')
                        @php
                        $menu = DB::table('z_menu_super')->get();
                        @endphp
                        @else
                        @php
                        $menu = DB::table('z_menu_super')
                        ->join('z_menu_user_super', 'z_menu_user_super.menu_super_code', '=', 'z_menu_super.menu_super_code')
                        ->where('z_menu_user_super.access_code', Auth::user()->access_code)
                        ->get();
                        @endphp
                        @endif

                        @foreach ($menu as $menus)
                        @php
                        $code = strtolower($menus->menu_super_code);
                        $imgUrl = 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=600&q=80';
                        $iconClass = 'fa-th-large';

                        if(str_contains($code, 'account') || str_contains($code, 'keuangan')) {
                        $imgUrl = 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=600&q=80';
                        $iconClass = 'fa-calculator';
                        } elseif(str_contains($code, 'inventar') || str_contains($code, 'stok')) {
                        $imgUrl = 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=600&q=80';
                        $iconClass = 'fa-boxes';
                        } elseif(str_contains($code, 'medic') || str_contains($code, 'health')) {
                        $imgUrl = 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=600&q=80';
                        $iconClass = 'fa-user-md';
                        } elseif(str_contains($code, 'logis') || str_contains($code, 'kurir')) {
                        $imgUrl = 'https://images.unsplash.com/photo-1580674684081-7617fbf3d745?auto=format&fit=crop&w=600&q=80';
                        $iconClass = 'fa-truck';
                        } elseif(str_contains($code, 'suppli') || str_contains($code, 'vendor')) {
                        $imgUrl = 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?auto=format&fit=crop&w=600&q=80';
                        $iconClass = 'fa-handshake';
                        } elseif(str_contains($code, 'purchas') || str_contains($code, 'beli')) {
                        $imgUrl = 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80';
                        $iconClass = 'fa-shopping-cart';
                        } elseif(str_contains($code, 'broad') || str_contains($code, 'pesan')) {
                        $imgUrl = 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80';
                        $iconClass = 'fa-paper-plane';
                        }
                        @endphp

                        <div class="col-sm-6 col-lg-4">
                            <div class="card menu-card" id="menu" data-code="{{$menus->menu_super_code}}">
                                <img src="{{ asset($menus->menu_super_img ?? $imgUrl) }}" alt="{{$menus->menu_super_name}}" class="card-bg-img">
                                <div class="card-overlay"></div>
                                <div class="menu-icon-badge">
                                    <i class="fas {{$iconClass}}"></i>
                                </div>
                                <div class="card-content">
                                    <h5 class="card-title">{{$menus->menu_super_name}}</h5>
                                    <p class="card-text mb-0">{{$menus->menu_super_desc}}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Coming Soon Card Placeholder -->
                        <div class="col-sm-6 col-lg-4">
                            <div class="coming-soon-card">
                                <div>
                                    <div class="mb-2 text-muted fs-2"><i class="fas fa-rocket"></i></div>
                                    <h6 class="fw-bold text-secondary mb-1">Fitur Mendatang</h6>
                                    <small class="text-muted d-block">Modul baru sedang dalam pengembangan.</small>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 text-center text-muted fs--1">
        <p class="mb-0">
            Thank you for creating with <a class="fw-semibold text-dark text-decoration-none" href="https://Innoventra.site">Innoventra</a> &copy; 2025 | v3.4.0
        </p>
    </footer>

    <!-- Bottom Navigation Bar (Mobile View) -->
    <div class="d-lg-none kaki">
        <div class="d-flex justify-content-around align-items-center h-100">
            <a class="nav-link-custom active" href="#">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a class="nav-link-custom" href="#">
                <i class="fas fa-key"></i>
                <span>Reset</span>
            </a>
            <a class="nav-link-custom position-relative" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fas fa-comments"></i>
                @guest
                @else
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.55rem;">
                    1
                </span>
                @endguest
                <span>Chat</span>
            </a>
            <div class="avatar avatar-l">
                <img class="rounded-circle border border-2 border-light" src="{{asset('img/my.jpg')}}" alt="User" />
            </div>
        </div>
    </div>

    <!-- Modal Chat/Info -->
    <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="staticBackdropLabel">Informasi System & Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-lg-8">
                            <h6 class="fw-bold mb-2">Labels</h6>
                            <div class="d-flex gap-2 mb-3">
                                <span class="badge bg-soft-success text-success px-3 py-2">New</span>
                                <span class="badge bg-soft-primary text-primary px-3 py-2">Goal</span>
                                <span class="badge bg-soft-info text-info px-3 py-2">Enhancement</span>
                            </div>
                            <hr />
                            <h6 class="fw-bold mb-2">Description</h6>
                            <p class="text-muted fs--1">
                                Layanan integrasi dashboard manajemen terlengkap untuk membantu pengelolaan data perusahaan Anda.
                            </p>
                        </div>
                        <div class="col-lg-4 border-start-lg">
                            <h6 class="fw-bold mb-2">Opsi Menu</h6>
                            <ul class="nav flex-column gap-1 fs--1">
                                <li class="nav-item"><a class="nav-link text-secondary px-0" href="#!"><i class="fas fa-user me-2"></i> Members</a></li>
                                <li class="nav-item"><a class="nav-link text-secondary px-0" href="#!"><i class="fas fa-tag me-2"></i> Label</a></li>
                                <li class="nav-item"><a class="nav-link text-secondary px-0" href="#!"><i class="fas fa-paperclip me-2"></i> Attachments</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScripts -->
    <script src="{{ asset('vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('asset/js/theme.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "warning",
            title: "Account Has been Log Out !!"
        });
    </script>
    @endif

    <script>
        $(document).on("click", "#menu", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            let timerInterval;
            Swal.fire({
                title: "Mohon Menunggu",
                html: "Membuka halaman dalam <b></b> milidetik.",
                timer: 500,
                timerProgressBar: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    $.ajax({
                        url: "{{ route('app_check_menu') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "code": code
                        },
                        dataType: 'html',
                    }).done(function(data) {
                        window.location.replace(data);
                    }).fail(function() {
                        Swal.fire("Error", "Gagal memuat menu.", "error");
                    });
                }
            });
        });

        $(document).on("click", "#button-logout", function(e) {
            e.preventDefault();
            let timerInterval;
            Swal.fire({
                title: "Mohon Menunggu",
                html: "Keluar dalam <b></b> milidetik.",
                timer: 1000,
                showCancelButton: true,
                cancelButtonText: "Batal",
                timerProgressBar: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    window.location.replace('{{ route("logout") }}');
                }
            });
        });

        $(document).on("click", "#button-master-dashboard", function(e) {
            e.preventDefault();
            window.location.href = "{{route('master_dashboard')}}";
        });

        $(document).on("click", "#button-menu-utama", function(e) {
            e.preventDefault();
            window.location.href = "{{route('/')}}";
        });
    </script>
</body>

</html>
