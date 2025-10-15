<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    @php
        $super = DB::table('z_menu_super')->where('menu_super_code', $code)->first();
    @endphp
    @if (!$super)
        <script>
            window.location.replace("{{route('dashboard.home')}}")
        </script>
    @else
        <title>{{$super->menu_super_name}} - {{ Env('APP_VER') }}</title>
    @endif

    @if (Auth::user()->access_status == 0)
        <script>
            window.location.replace("{{route('logout')}}")
        </script>
    @endif

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
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('asset/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('asset/css/user.min.css') }}" rel="stylesheet" id="user-style-default">
    <link href="https://fonts.googleapis.com/css2?family=Saira+Stencil+One&display=swap" rel="stylesheet">
    <style>
        /* @import url(https://fonts.googleapis.com/css?family=Roboto:400,100,900);

        body {
            font-family: 'Roboto', sans-serif !important;
        } */
    </style>
    @yield('base.css')
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
</head>


<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <script>
                var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                if (isFluid) {
                    var container = document.querySelector('[data-layout]');
                    container.classList.remove('container');
                    container.classList.add('container-fluid');
                }
            </script>
            <nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
                <script>
                    var navbarStyle = localStorage.getItem("navbarStyle");
                    if (navbarStyle && navbarStyle !== 'transparent') {
                        document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
                    }
                </script>
                <div class="d-flex align-items-center">
                    <div class="toggle-icon-wrapper">
                        <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle"
                            data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation"><span
                                class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>

                    </div><a class="navbar-brand" href="{{ route('dashboard.home') }}">
                        <div class="d-flex align-items-center py-2">
                            <img class="mx-3" src="{{ asset('img/favicon.png') }}" alt="" width="90" />
                            <!-- <span class="font-sans-serif fs--3">App</span> -->
                        </div>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                    <div class="navbar-vertical-content scrollbar pt-2">
                        <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                            <li class="nav-item">
                                <!-- parent pages--><a class="nav-link dropdown-indicator" href="#dashboard"
                                    role="button" data-bs-toggle="collapse" aria-expanded="false"
                                    aria-controls="dashboard">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                class="fab fa-dashcube"></span></span><span
                                            class="nav-link-text ps-1">Dashboard</span>
                                    </div>
                                </a>
                                <ul class="nav collapse false" id="dashboard">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('dashboard.home') }}" aria-expanded="false">
                                            <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Back
                                                    to Home</span>
                                            </div>
                                        </a>
                                        <!-- more inner pages-->
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" href="{{ route('dashboard.profile') }}" aria-expanded="false">
                                            <div class="d-flex align-items-center"><span
                                                    class="nav-link-text ps-1">Profile</span>
                                            </div>
                                        </a>
                                    </li> -->

                                </ul>
                            </li>

                            @php
                                $menu = DB::table('z_menu_user')
                                    ->join('z_menu_sub', 'z_menu_sub.menu_sub_code', '=', 'z_menu_user.menu_sub_code')
                                    ->join('z_menu', 'z_menu.menu_code', '=', 'z_menu_sub.menu_code')
                                    ->where('z_menu_user.access_code', Auth::user()->access_code)
                                    ->where('z_menu.menu_super_code', $code)
                                    ->orderBy('z_menu.id_menu', 'ASC')
                                    ->get()
                                    ->unique('menu_code');
                            @endphp
                            @foreach ($menu as $menus)
                                <li class="nav-items">
                                    <!-- label-->
                                    <div class="row navbar-vertical-label-wrapper mt-1 mb-1">
                                        <div class="col-auto navbar-vertical-label">{{ $menus->menu_name }}
                                        </div>
                                        <div class="col ps-0">
                                            <hr class="mb-0 navbar-vertical-divider" />
                                        </div>
                                    </div>
                                    @php
                                        $sub_menu = DB::table('z_menu_user')
                                            ->join('z_menu_sub', 'z_menu_sub.menu_sub_code', '=', 'z_menu_user.menu_sub_code')
                                            ->where('z_menu_user.access_code', Auth::user()->access_code)
                                            ->where('z_menu_sub.menu_code', $menus->menu_code)
                                            ->orderBy('z_menu_sub.id_menu_sub', 'ASC')
                                            ->get();
                                    @endphp
                                    @foreach ($sub_menu as $sub_menus)
                                            @if ($sub_menus->menu_sub_option == 'dropdown')
                                                    @php
                                                        $sub = DB::table('z_menu_sub_main')
                                                            ->join('z_menu_user_sub', 'z_menu_user_sub.menu_main_sub_code', '=', 'z_menu_sub_main.menu_main_sub_code')
                                                            ->where('z_menu_sub_main.menu_sub_code', $sub_menus->menu_sub_code)
                                                            ->where('access_code', Auth::user()->access_code)->get();
                                                    @endphp
                                                <li class="nav-item">
                                                    <a class="nav-link dropdown-indicator" href="#menu-{{ $sub_menus->id_menu_sub }}"
                                                        role="button" data-bs-toggle="collapse" aria-expanded="false"
                                                        aria-controls="dashboard">
                                                        <div class="d-flex align-items-center "><span class="nav-link-icon"><span
                                                                    class="{{ $sub_menus->menu_sub_icon }}"></span></span><span
                                                                class="nav-link-text ps-1">{{ $sub_menus->menu_sub_name }}</span>
                                                        </div>
                                                    </a>
                                                    @php
                                                        $show = DB::table('z_menu_sub_main')
                                                            ->where('menu_main_sub_code', $akses)
                                                            ->where('menu_sub_code', $sub_menus->menu_sub_code)->first();
                                                    @endphp
                                                    @if ($show)
                                                        @php
                                                            $shown = 'show'
                                                        @endphp
                                                    @else
                                                        @php
                                                            $shown = 'false'
                                                        @endphp
                                                    @endif
                                                    <ul class="nav collapse {{$shown}}" id="menu-{{ $sub_menus->id_menu_sub }}">
                                                        @foreach ($sub as $item)
                                                            @php
                                                                $submenu = DB::table('z_menu_user_sub')
                                                                    ->where('menu_main_sub_code', $item->menu_main_sub_code)
                                                                    ->where('access_code', Auth::user()->access_code)->first();
                                                            @endphp
                                                            <li class="nav-item">
                                                                @if ($submenu)
                                                                    @if ($akses == $item->menu_main_sub_code)
                                                                        <a class="nav-link active"
                                                                            href="{{ url($item->menu_main_sub_code . '/' . $item->menu_main_sub_link) }}"
                                                                            aria-expanded="false">
                                                                            <div class="d-flex align-items-center ">
                                                                                <span class="nav-link-icon"><span
                                                                                        class="{{$item->menu_main_sub_icon}}"></span></span>
                                                                                <span class="nav-link-text fs--2"> {{$item->menu_main_sub_name}}</span>
                                                                            </div>
                                                                        </a>
                                                                    @else
                                                                        <a class="nav-link false"
                                                                            href="{{ url($item->menu_main_sub_code . '/' . $item->menu_main_sub_link) }}"
                                                                            aria-expanded="false">
                                                                            <div class="d-flex align-items-center ">
                                                                                <span class="nav-link-icon"><span
                                                                                        class="{{$item->menu_main_sub_icon}}"></span></span>
                                                                                <span class="nav-link-text fs--2"> {{$item->menu_main_sub_name}}</span>
                                                                            </div>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                            <li class="nav-item">
                                                @if ($akses == $sub_menus->menu_sub_code)
                                                    <a class="nav-link active"
                                                        href="{{ url($sub_menus->menu_sub_code . '/' . $sub_menus->menu_sub_link) }}"
                                                        role="button" aria-expanded="false">
                                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                                    class="{{ $sub_menus->menu_sub_icon }}"></span></span><span
                                                                class="nav-link-text ps-1">{{ $sub_menus->menu_sub_name }}</span>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a class="nav-link"
                                                        href="{{ url($sub_menus->menu_sub_code . '/' . $sub_menus->menu_sub_link) }}"
                                                        role="button" aria-expanded="false">
                                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                                    class="{{ $sub_menus->menu_sub_icon }}"></span></span><span
                                                                class="nav-link-text ps-1">{{ $sub_menus->menu_sub_name }}</span>
                                                        </div>
                                                    </a>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                <!-- parent pages-->
                                </li>
                            @endforeach

                        </ul>

                    </div>
                </div>
            </nav>
            <div class="content">
                <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">

                    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
                        data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse"
                        aria-controls="navbarVerticalCollapse" aria-expanded="false"
                        aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span
                                class="toggle-line"></span></span></button>
                    <a class="navbar-brand me-1 me-sm-3" href="{{ route('dashboard.home') }}">
                        <div class="d-flex align-items-center">
                            <img class="mx-3" src="{{ asset('img/favicon.png') }}" alt="" width="65" /><span
                                class="fs-2 text-linkedin">ver 1.2</span>
                        </div>
                    </a>
                    <ul class="navbar-nav align-items-center d-none d-lg-block">
                        <li class="nav-item">
                            <div class="search-box" data-list='{"valueNames":["title"]}'>
                                <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                                    <input class="form-control search-input fuzzy-search" type="search"
                                        placeholder="Search..." aria-label="Search" />
                                    <span class="fas fa-search search-box-icon"></span>

                                </form>
                                <div class="btn-close-falcon-container position-absolute end-0 top-50 translate-middle shadow-none"
                                    data-bs-dismiss="search">
                                    <div class="btn-close-falcon" aria-label="Close"></div>
                                </div>
                                <div class="dropdown-menu border font-base start-0 mt-2 py-0 overflow-hidden w-100">
                                    <div class="scrollbar list py-3" style="max-height: 24rem;">
                                        <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-0 pb-2">
                                            Recently Browsed</h6>
                                        <a class="dropdown-item fs--1 px-card py-1 hover-primary" href="#">
                                            <div class="d-flex align-items-center">
                                                <span class="fas fa-circle me-2 text-300 fs--2"></span>

                                                <div class="fw-normal title">Pages <span
                                                        class="fas fa-chevron-right mx-1 text-500 fs--2"
                                                        data-fa-transform="shrink-2"></span> Dashboard</div>
                                            </div>
                                        </a>

                                        <hr class="bg-200 dark__bg-900" />
                                    </div>
                                    <div class="text-center mt-n3">
                                        <p class="fallback fw-bold fs-1 d-none">No Result Found.</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
                        <li class="nav-item">
                            <div class="theme-control-toggle fa-icon-wait px-2">
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
                        {{-- <li class="nav-item">
                            <a class="nav-link px-0 notification-indicator notification-indicator-warning notification-indicator-fill fa-icon-wait"
                                href="#"><span class="fas fa-shopping-cart" data-fa-transform="shrink-7"
                                    style="font-size: 33px;"></span><span
                                    class="notification-indicator-number">1</span></a>

                        </li> --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link notification-indicator notification-indicator-primary px-0 fa-icon-wait"
                                id="navbarDropdownNotification" href="#" role="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><span class="fas fa-bell"
                                    data-fa-transform="shrink-6" style="font-size: 33px;"></span></a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-card dropdown-menu-notification"
                                aria-labelledby="navbarDropdownNotification">
                                <div class="card card-notification shadow-none">
                                    <div class="card-header">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-auto">
                                                <h6 class="card-header-title mb-0">Notifications</h6>
                                            </div>
                                            <div class="col-auto ps-0 ps-sm-3"><a class="card-link fw-normal"
                                                    href="#">Mark all as read</a></div>
                                        </div>
                                    </div>
                                    <div class="scrollbar-overlay" style="max-height:19rem" id="show-notification">

                                    </div>
                                    <div class="card-footer text-center border-top"><a class="card-link d-block"
                                            href="../app/social/notifications.html">View all</a></div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown"><a class="nav-link pe-0" id="navbarDropdownUser" href="#"
                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-xl">
                                    <img class="rounded-circle" src="{{ asset('img/pp.png') }}" alt="" />

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
                        </li>
                    </ul>
                </nav>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

                @yield('content')



                <footer class="footer">
                    <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600">Thank you for creating with Transforma<span
                                    class="d-none d-sm-inline-block">| </span><br class="d-sm-none" /> 2025 &copy;
                                <a href="#">{{ Env('APP_NAME') }}</a>
                                <button class="btn btn-primary" id="liveToastBtn" type="button" hidden></button>
                            </p>
                        </div>
                        <div class="col-12 col-sm-auto text-center">
                            <img src="{{ asset('img/logo.png') }}" alt="" width="80">
                        </div>
                    </div>
                </footer>
            </div>

        </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->
    <div class="offcanvas offcanvas-end settings-panel border-0" id="settings-offcanvas" tabindex="-1"
        aria-labelledby="settings-offcanvas">
        <div class="offcanvas-header settings-panel-header bg-shape">
            <div class="z-index-1 py-1 light">
                <h5 class="text-white"> <span class="fas fa-palette me-2 fs-0"></span>Settings</h5>
                <p class="mb-0 fs--1 text-white opacity-75"> Set your own customized style</p>
            </div>
            <button class="btn-close btn-close-white z-index-1 mt-0" type="button" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body scrollbar-overlay px-card" id="themeController">
            <h5 class="fs-0">Color Scheme</h5>
            <p class="fs--1">Choose the perfect color mode for your app.</p>
            <div class="btn-group d-block w-100 btn-group-navbar-style">
                <div class="row gx-2">
                    <div class="col-6">
                        <input class="btn-check" id="themeSwitcherLight" name="theme-color" type="radio" value="light"
                            data-theme-control="theme" />
                        <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherLight"> <span
                                class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                    src="{{ asset('asset/img/generic/falcon-mode-default.jpg') }}" alt="" /></span><span
                                class="label-text">Light</span></label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="themeSwitcherDark" name="theme-color" type="radio" value="dark"
                            data-theme-control="theme" />
                        <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherDark"> <span
                                class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                    src="{{ asset('asset/img/generic/falcon-mode-dark.jpg') }}" alt="" /></span><span
                                class="label-text"> Dark</span></label>
                    </div>
                </div>
            </div>
            <hr />
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-start"><img class="me-2"
                        src="{{ asset('asset/img/icons/left-arrow-from-left.svg') }}" width="20" alt="" />
                    <div class="flex-1">
                        <h5 class="fs-0">RTL Mode</h5>
                        <p class="fs--1 mb-0">Pariatur labore dolorem laboriosam eum at ratione, nesciunt, tenetur
                            fugiat eligendi minima ducimus iusto animi inventore facilis soluta error repellat amet
                            reprehenderit?</p>
                    </div>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input ms-0" id="mode-rtl" type="checkbox" data-theme-control="isRTL" />
                </div>
            </div>
            <hr />
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-start"><img class="me-2"
                        src="{{ asset('asset/img/icons/arrows-h.svg') }}" width="20" alt="" />
                    <div class="flex-1">
                        <h5 class="fs-0">Fluid Layout</h5>
                        <p class="fs--1 mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input ms-0" id="mode-fluid" type="checkbox" data-theme-control="isFluid" />
                </div>
            </div>
            <hr />
            <h5 class="fs-0 d-flex align-items-center">Vertical Navbar Style</h5>
            <p class="fs--1 mb-0">Switch between styles for your vertical navbar </p>
            <div class="btn-group d-block w-100 btn-group-navbar-style">
                <div class="row gx-2">
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-transparent" type="radio" name="navbarStyle"
                            value="transparent" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-transparent"> <img
                                class="img-fluid img-prototype" src="{{ asset('asset/img/generic/default.png') }}"
                                alt="" /><span class="label-text"> Transparent</span></label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-inverted" type="radio" name="navbarStyle"
                            value="inverted" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-inverted"> <img
                                class="img-fluid img-prototype" src="{{ asset('asset/img/generic/inverted.png') }}"
                                alt="" /><span class="label-text"> Inverted</span></label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-card" type="radio" name="navbarStyle" value="card"
                            data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-card"> <img
                                class="img-fluid img-prototype" src="{{ asset('asset/img/generic/card.png') }}"
                                alt="" /><span class="label-text"> Card</span></label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-vibrant" type="radio" name="navbarStyle"
                            value="vibrant" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-vibrant"> <img
                                class="img-fluid img-prototype" src="{{ asset('asset/img/generic/vibrant.png') }}"
                                alt="" /><span class="label-text"> Vibrant</span></label>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <a class="card setting-toggle" href="#settings-offcanvas" data-bs-toggle="offcanvas">
        <div class="card-body d-flex align-items-center py-md-2 px-2 py-1">
            <div class="bg-soft-primary position-relative rounded-start" style="height:34px;width:28px">
                <div class="settings-popover"><span class="ripple"><span
                            class="fa-spin position-absolute all-0 d-flex flex-center"><span
                                class="icon-spin position-absolute all-0 d-flex flex-center">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19.7369 12.3941L19.1989 12.1065C18.4459 11.7041 18.0843 10.8487 18.0843 9.99495C18.0843 9.14118 18.4459 8.28582 19.1989 7.88336L19.7369 7.59581C19.9474 7.47484 20.0316 7.23291 19.9474 7.03131C19.4842 5.57973 18.6843 4.28943 17.6738 3.20075C17.5053 3.03946 17.2527 2.99914 17.0422 3.12011L16.393 3.46714C15.6883 3.84379 14.8377 3.74529 14.1476 3.3427C14.0988 3.31422 14.0496 3.28621 14.0002 3.25868C13.2568 2.84453 12.7055 2.10629 12.7055 1.25525V0.70081C12.7055 0.499202 12.5371 0.297594 12.2845 0.257272C10.7266 -0.105622 9.16879 -0.0653007 7.69516 0.257272C7.44254 0.297594 7.31623 0.499202 7.31623 0.70081V1.23474C7.31623 2.09575 6.74999 2.8362 5.99824 3.25599C5.95774 3.27861 5.91747 3.30159 5.87744 3.32493C5.15643 3.74527 4.26453 3.85902 3.53534 3.45302L2.93743 3.12011C2.72691 2.99914 2.47429 3.03946 2.30587 3.20075C1.29538 4.28943 0.495411 5.57973 0.0322686 7.03131C-0.051939 7.23291 0.0322686 7.47484 0.242788 7.59581L0.784376 7.8853C1.54166 8.29007 1.92694 9.13627 1.92694 9.99495C1.92694 10.8536 1.54166 11.6998 0.784375 12.1046L0.242788 12.3941C0.0322686 12.515 -0.051939 12.757 0.0322686 12.9586C0.495411 14.4102 1.29538 15.7005 2.30587 16.7891C2.47429 16.9504 2.72691 16.9907 2.93743 16.8698L3.58669 16.5227C4.29133 16.1461 5.14131 16.2457 5.8331 16.6455C5.88713 16.6767 5.94159 16.7074 5.99648 16.7375C6.75162 17.1511 7.31623 17.8941 7.31623 18.7552V19.2891C7.31623 19.4425 7.41373 19.5959 7.55309 19.696C7.64066 19.7589 7.74815 19.7843 7.85406 19.8046C9.35884 20.0925 10.8609 20.0456 12.2845 19.7729C12.5371 19.6923 12.7055 19.4907 12.7055 19.2891V18.7346C12.7055 17.8836 13.2568 17.1454 14.0002 16.7312C14.0496 16.7037 14.0988 16.6757 14.1476 16.6472C14.8377 16.2446 15.6883 16.1461 16.393 16.5227L17.0422 16.8698C17.2527 16.9907 17.5053 16.9504 17.6738 16.7891C18.7264 15.7005 19.4842 14.4102 19.9895 12.9586C20.0316 12.757 19.9474 12.515 19.7369 12.3941ZM10.0109 13.2005C8.1162 13.2005 6.64257 11.7893 6.64257 9.97478C6.64257 8.20063 8.1162 6.74905 10.0109 6.74905C11.8634 6.74905 13.3792 8.20063 13.3792 9.97478C13.3792 11.7893 11.8634 13.2005 10.0109 13.2005Z"
                                        fill="#2A7BE4"></path>
                                </svg></span></span></span>
                </div>
            </div>
            <small
                class="text-uppercase text-primary fw-bold bg-soft-primary py-2 pe-2 ps-1 rounded-end">Setting</small>
        </div>
    </a>

    {{-- START MODAL --}}
    <div class="modal fade" id="modal-template" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-template"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-template-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-template-xl"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-template-sm" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-template-sm"></div>
            </div>
        </div>
    </div>
    {{-- END MODAL --}}
    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ asset('vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
    <script src="{{ asset('vendors/is/is.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
    <script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
    <script src="{{ asset('asset/js/theme.js') }}"></script>
    <script src="{{ asset('online/resumable.min.js') }}"></script>
    <script src="{{ asset('asset/notifications/js/notifications.min.js') }}"></script>
    @yield('base.js')


    @if (session('success'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 99999">
            <div class="toast show" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true"
                data-options='{"autoShow":true,"showOnce":true,"cookieExpireTime":3}' data-autohide="false">
                <div class="toast-header bg-primary text-white"><strong class="me-auto">Notice</strong><small>1 sec
                        ago</small>
                    <button class="btn-close btn-close-white" type="button" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('success') }}</div>
            </div>
        </div>
    @elseif (session('error'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 99999">
            <div class="toast show" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true"
                data-options='{"autoShow":true,"showOnce":true,"cookieExpireTime":720}' data-autohide="false">
                <div class="toast-header bg-danger text-white"><strong class="me-auto">Notice</strong><small>1 sec
                        ago</small>
                    <button class="btn-close btn-close-white" type="button" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('error') }}</div>
            </div>
        </div>
    @endif


    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 99999">
        <div class="toast fade" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true"
            data-options='{"autoShow":true,"showOnce":true,"cookieExpireTime":720}' data-autohide="false">
            <div class="toast-header bg-danger text-white"><strong class="me-auto">Notice</strong><small>1 sec
                    ago</small>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body">Data Error</div>
        </div>
    </div>
</body>

</html>
