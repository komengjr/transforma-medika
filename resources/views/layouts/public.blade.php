<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-adsense-account" content="ca-pub-4154628728879232">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4154628728879232"
        crossorigin="anonymous"></script>

    <!-- ===============================================-->
    <!--    Document Title  -->
    <!-- ===============================================-->
    <title>Innoventra | Dashboard &amp; Welcome</title>
    @php
        $app = DB::table('z_menu_super')->get();
        $menu = DB::table('z_menu')->get();
    @endphp

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <link rel="manifest" href="{{ asset('asset/img/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('img/favicon.png') }}">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('asset/js/config.js') }}"></script>
    <script src="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/notifications/css/lobibox.min.css') }}" />

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">

    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('asset/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('asset/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://fonts.googleapis.com/css2?family=Saira+Stencil+One&display=swap" rel="stylesheet">
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

</head>


<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <nav class="navbar navbar-standard navbar-expand-lg fixed-top navbar-dark"
            data-navbar-darken-on-scroll="data-navbar-darken-on-scroll">
            <div class="container"><a class="navbar-brand" href="{{route('/')}}">
                    <img src="{{ asset('img/favicon.png') }}" alt="" width="90">
                </a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarStandard" aria-controls="navbarStandard" aria-expanded="false"
                    aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse scrollbar" id="navbarStandard">
                    <ul class="navbar-nav" data-top-nav-dropdowns="data-top-nav-dropdowns">
                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                id="dashboards">Dashboard</a>
                            <div class="dropdown-menu dropdown-menu-card border-0 mt-0" aria-labelledby="dashboards">
                                <div class="bg-white dark__bg-1000 rounded-3 py-2">
                                    <a class="dropdown-item link-600 fw-medium" href="{{route('/')}}">Default</a>

                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="apps">App</a>
                            <div class="dropdown-menu dropdown-menu-card border-0 mt-0" aria-labelledby="apps">
                                <div class="card navbar-card-app shadow-none dark__bg-1000">
                                    <div class="card-body scrollbar max-h-dropdown">
                                        <img class="img-dropdown"
                                            src="{{ asset('asset/img/icons/spot-illustrations/authentication-corner.png') }}"
                                            width="130" alt="" />
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="nav flex-column">
                                                    @foreach ($app as $apps)
                                                        <a class="dropdown-item link-600 fw-medium text-700 my-1 fw-bold"
                                                            href="{{route($apps->menu_public_link)}}"> <span
                                                                class="fas fa-pager text-primary me-3"></span>
                                                            {{$apps->menu_super_name}}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{asset('product')}}" role="button" aria-haspopup="true"
                                aria-expanded="false" id="pagess">Product
                            </a>

                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{route('news_index')}}" role="button" aria-haspopup="true"
                                aria-expanded="false" id="pagess">News
                            </a>

                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{route('movies.index')}}" role="button" aria-haspopup="true"
                                aria-expanded="false" id="pagess">Movie
                            </a>

                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{route('about')}}" role="button" aria-haspopup="true"
                                aria-expanded="false" id="pagess">About
                            </a>

                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{route('contact')}}" role="button" aria-haspopup="true"
                                aria-expanded="false" id="pagess">Contact
                            </a>

                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{route('privacy-policy')}}" role="button" aria-haspopup="true"
                                aria-expanded="false" id="pagess">Privacy Policy
                            </a>

                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="{{route('terms-of-service')}}" role="button" aria-haspopup="true"
                                aria-expanded="false" id="pagess">Terms of Service
                            </a>

                        </li>
                        <!-- <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                id="documentations">Documentation</a>
                            <div class="dropdown-menu dropdown-menu-card border-0 mt-0"
                                aria-labelledby="documentations">
                                <div class="bg-white dark__bg-1000 rounded-3 py-2">

                                    <a class="dropdown-item link-600 fw-medium"
                                        href="{{route('changelog')}}">Changelog</a>
                                </div>
                            </div>
                        </li> -->
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <div class="theme-control-toggle fa-icon-wait ">
                                <input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle"
                                    type="checkbox" data-theme-control="theme" value="dark" />
                                <label class="mb-0 theme-control-toggle-label theme-control-toggle-light"
                                    for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Switch to light theme"><span class="fas fa-sun fs-0"></span></label>
                                <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark"
                                    for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left"
                                    title="Switch to dark theme"><span class="fas fa-moon fs-0"></span></label>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><span class="d-none d-lg-inline-block" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="Dashboard"><span
                                        class="fas fa-chart-pie"></span></span><span class="d-lg-none">Dashboard</span>
                                |</a>
                        </li>

                        <li class="nav-item dropdown">
                            @guest
                                <a class="nav-link text-warning" href="{{route('login')}}" "><span class=" fab
                                    fa-keycdn"></span> Login</a>
                            @else
                                <a class="nav-link py-0 my-0" id="navbarDropdownUser" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="avatar avatar-xl">
                                        <img class="rounded-circle" src="{{ asset('img/my.jpg') }}" alt="" />

                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                                    <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                        {{-- <a class="dropdown-item fw-bold text-warning" href="#!"><span
                                                class="fas fa-crown me-1"></span><span>Go Pro</span></a> --}}
                                        <a class="dropdown-item text-primary text-center">{{ Auth::user()->fullname }}</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-warning" href="#!" id="button-setup-notification"
                                            data-bs-toggle="modal" data-bs-target="#modal-template-sm"><span
                                                class="fas fa-user-cog"></span> Set Notification</a>
                                        <a class="dropdown-item text-info" href="#" id="button-setup-profil"
                                            data-bs-toggle="modal" data-bs-target="#modal-template-xl"><span
                                                class="fas fa-user-cog"></span>
                                            Profile &amp;
                                            account</a>
                                        <a class="dropdown-item text-primary" href="{{route('dashboard.home')}}"><span
                                                class="fas fa-chalkboard-teacher"></span> Homepage</a>
                                        @if (Auth::user()->access_code == 'master')
                                            <a class="dropdown-item text-danger" href="{{route('master_dashboard')}}"><span
                                                    class="fas fa-user-cog"></span> Master Page</a>
                                        @endif
                                        <div class="dropdown-divider"></div>
                                        {{-- <a class="dropdown-item" href="#">Settings</a> --}}
                                        <a class="dropdown-item" href="{{ route('logout') }}"><span
                                                class="fab fa-keycdn"></span> Logout</a>
                                    </div>
                                </div>
                            @endguest
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body p-4">
                        <div class="row text-start justify-content-between align-items-center mb-2">
                            <div class="col-auto">
                                <h5 id="modalLabel">Login System</h5>
                            </div>
                            <div class="col-auto">
                                <p class="fs--1 text-600 mb-0">Have an account? <a href="{{route('login')}}">Login</a>
                                </p>
                            </div>
                        </div>
                        <form>
                            <div class="mb-3">
                                <label class="form-label" for="card-email">Username</label>
                                <input class="form-control" id="username" type="text" name="username" required
                                    autofocus />
                                @if ($errors->has('username'))
                                    <span class="text-danger">{{ $errors->first('username') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="card-password">Password</label>
                                </div>
                                <input class="form-control" id="password" type="password" name="password" required />
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <span id="notifikasi-login" class="pb-0 mt-0"></span>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="modal-register-checkbox" />
                                <label class="form-label" for="modal-register-checkbox">I accept the <a href="#!">terms
                                    </a>and <a href="#!">privacy policy</a></label>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="button"
                                    id="button-login-system" name="submit"><span class="fab fa-500px"></span> Log
                                    in</button>
                            </div>
                        </form>
                        <div class="position-relative mt-4">
                            <hr class="bg-300" />
                            <div class="divider-content-center">or register with</div>
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col-sm-6"><a class="btn btn-outline-google-plus btn-sm d-block w-100"
                                    href="#"><span class="fab fa-google-plus-g me-2" data-fa-transform="grow-8"></span>
                                    google</a></div>
                            <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100"
                                    href="#"><span class="fab fa-facebook-square me-2"
                                        data-fa-transform="grow-8"></span> facebook</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- ============================================-->
        <!-- <section> begin ============================-->

        <!-- <section> close ============================-->
        <!-- ============================================-->


        @yield('content')
        <section class="light">

            <div class="bg-holder overlay"
                style="background-image:url(../asset/img/generic/bg-2.jpg);background-position: center top;">
            </div>
            <!--/.bg-holder-->

            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <p class="fs-2 fs-sm-2 text-white">Innoventra tidak hanya membangun teknologi — kami membangun
                            masa
                            depan digital.
                            Melalui riset berkelanjutan, kolaborasi dengan berbagai sektor, dan penerapan standar
                            teknologi
                            global, kami berkomitmen menjadi bagian dari perubahan positif menuju dunia yang lebih
                            terhubung,
                            efisien, dan inovatif.</p>
                        <button class="btn btn-outline-light border-2 rounded-pill btn-lg mt-4 fs-0 py-2"
                            type="button">Start with Us</button>
                    </div>
                </div>
            </div>
            <!-- end of .container-->

        </section>

        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section class="bg-dark pt-8 pb-4 light">

            <div class="container">
                <div class="position-absolute btn-back-to-top bg-dark"><a class="text-600" href="#banner"
                        data-bs-offset-top="0" data-scroll-to="#banner"><span class="fas fa-chevron-up"
                            data-fa-transform="rotate-45"></span></a></div>
                <div class="row">
                    <div class="col-lg-4">
                        <h5 class="text-uppercase text-white opacity-85 mb-3">Our Mission</h5>
                        <p class="text-600">Innoventra adalah perusahaan pengembang solusi digital yang berfokus pada
                            inovasi, efisiensi, dan transformasi teknologi. Terinspirasi dari dua kata — Innovation dan
                            Venture — kami hadir sebagai wadah bagi ide-ide kreatif untuk tumbuh menjadi produk dan
                            layanan yang berdampak nyata.</p>
                        <div class="icon-group mt-4"><a class="icon-item bg-white text-facebook" href="#!"><span
                                    class="fab fa-facebook-f"></span></a><a class="icon-item bg-white text-twitter"
                                href="#!"><span class="fab fa-twitter"></span></a><a
                                class="icon-item bg-white text-google-plus" href="#!"><span
                                    class="fab fa-google-plus-g"></span></a><a class="icon-item bg-white text-linkedin"
                                href="#!"><span class="fab fa-linkedin-in"></span></a><a class="icon-item bg-white"
                                href="#!"><span class="fab fa-medium-m"></span></a></div>
                    </div>
                    <div class="col ps-lg-6 ps-xl-8">
                        <div class="row mt-5 mt-lg-0">
                            <div class="col-6 col-md-3">
                                <h5 class="text-uppercase text-white opacity-85 mb-3">Company</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-1"><a class="link-600" href="{{ route('about') }}">About</a></li>
                                    <li class="mb-1"><a class="link-600" href="{{ route('contact') }}">Contact</a></li>
                                    <li class="mb-1"><a class="link-600"
                                            href="{{ route('privacy-policy') }}">Privacy</a></li>
                                    <li class="mb-1"><a class="link-600" href="{{ route('terms-of-service') }}">Term</a>
                                    </li>
                                    <li><a class="link-600" href="#!">Imprint</a></li>
                                </ul>
                            </div>
                            <div class="col-6 col-md-3">
                                <h5 class="text-uppercase text-white opacity-85 mb-3">Movies</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-1"><a class="link-600" href="{{route('movies.index')}}">Watch Now</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col mt-5 mt-md-0">
                                <h5 class="text-uppercase text-white opacity-85 mb-3">From the Blog</h5>
                                <ul class="list-unstyled">
                                    <li>
                                        <h5 class="fs-0 mb-0"><a class="link-600" href="#!"> Interactive graphs and
                                                charts</a></h5>
                                        <p class="text-600 opacity-50">Jan 15 &bull; 8min read </p>
                                    </li>
                                    <li>
                                        <h5 class="fs-0 mb-0"><a class="link-600" href="#!"> Lifetime free updates</a>
                                        </h5>
                                        <p class="text-600 opacity-50">Jan 5 &bull; 3min read &starf;</p>
                                    </li>
                                    <li>
                                        <h5 class="fs-0 mb-0"><a class="link-600" href="#!"> Merry Christmas From us</a>
                                        </h5>
                                        <p class="text-600 opacity-50">Dec 25 &bull; 2min read</p>
                                    </li>
                                    <li>
                                        <h5 class="fs-0 mb-0"><a class="link-600" href="#!"> The New Innoventra
                                                Theme</a>
                                        </h5>
                                        <p class="text-600 opacity-50">Dec 23 &bull; 10min read </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of .container-->

        </section>
        <!-- <section> close ============================-->
        <!-- ============================================-->




        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section class="py-0 bg-dark light">
            <div>
                <hr class="my-0 text-600 opacity-25" />
                <div class="container py-3">
                    <div class="row justify-content-between fs--1">
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600 opacity-85">Thank you for creating with Innoventra <span
                                    class="d-none d-sm-inline-block">| </span><br class="d-sm-none" /> 2025 &copy; <a
                                    class="text-white opacity-85" href="https://Innoventra.site">Innoventra</a></p>
                        </div>
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600 opacity-85">v3.4.0</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of .container-->

        </section>
        <!-- <section> close ============================-->
        <!-- ============================================-->



    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
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

    <script>
        var input = document.getElementById("password");
        var input2 = document.getElementById("username");
        var button = document.getElementById("button-login-system");
        input.addEventListener("keypress", function (event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Mencegah perilaku default (seperti mengirim form)
                button.click(); // Memicu klik pada tombol
            }
        });
        input2.addEventListener("keypress", function (event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Mencegah perilaku default (seperti mengirim form)
                button.click(); // Memicu klik pada tombol
            }
        });
        $(document).on("click", "#button-login-system", function (e) {
            e.preventDefault();
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            $('#button-login-system').html(
                '<div class="spinner-border my-0" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            if (username == "" || password == "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#button-login-system').html('<span class="fab fa-500px"></span> Log in');
            } else {
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
                    $('#button-login-system').html('<span class="fab fa-500px"></span> Log in');
                }).fail(function () {
                    console.log('error');

                });
            }
        });
    </script>
</body>

</html>
