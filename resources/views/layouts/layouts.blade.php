<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <!-- Favicons -->
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

    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link href="{{ asset('vendors/overlayscrollbars/OverlayScrollbars.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/theme-rtl.min.css') }}" rel="stylesheet" id="style-rtl">
    <link href="{{ asset('asset/css/theme.min.css') }}" rel="stylesheet" id="style-default">
    <link href="{{ asset('asset/css/user-rtl.min.css') }}" rel="stylesheet" id="user-style-rtl">
    <link href="{{ asset('asset/css/user.min.css') }}" rel="stylesheet" id="user-style-default">

    <!-- Custom Global Font, Search & Mobile Floating Navbar Styling -->
    <style>
        body,
        .font-base,
        .dropdown-menu,
        .form-control,
        .btn {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .card-header-title,
        .navbar-vertical-label,
        .nav-link-text {
            font-family: 'Outfit', sans-serif !important;
        }

        /* Sembunyikan icon search saat user mengetik agar tidak mengganggu teks */
        .search-box.has-query .search-box-icon {
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none;
            transition: opacity 0.15s ease;
        }

        .search-box.has-query .search-input {
            padding-left: 0.85rem !important;
        }

        /* Flex search-box mobile agar menyesuaikan ruang secara otomatis */
        .mobile-search-flex {
            min-width: 0;
            flex: 1 1 auto;
        }

        .mobile-search-flex .search-input {
            height: 36px;
            font-size: 0.85rem;
            padding-right: 1.9rem;
        }

        .mobile-search-flex .dropdown-menu {
            width: 300px;
            max-width: calc(100vw - 24px);
            min-width: unset !important;
        }

        /* Teks menu pada search-box menurun ke bawah agar tidak terpotong ke kanan */
        .navbar-menu-search-box .dropdown-menu {
            min-width: 320px;
        }

        .navbar-menu-search-box .scrollbar.list {
            overflow-x: hidden !important;
        }

        .navbar-menu-search-box .navbar-menu-result {
            white-space: normal !important;
            word-break: break-word;
        }

        .navbar-menu-search-box .title {
            white-space: normal !important;
            line-height: 1.35;
        }

        .search-menu-breadcrumb {
            display: block;
            font-size: 0.72rem;
            color: #64748b;
            line-height: 1.25;
            margin-bottom: 2px;
        }

        .search-menu-name {
            display: block;
            font-size: 0.83rem;
            font-weight: 600;
            line-height: 1.3;
        }

        /* Tombol melayang pojok kanan bawah dengan gambar profile di mobile */
        .mobile-fab-container {
            position: fixed;
            right: 18px;
            bottom: 18px;
            z-index: 1055;
        }

        .mobile-fab-btn {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            padding: 0;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            overflow: hidden;
            border: 2px solid #fff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .mobile-fab-btn img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .mobile-fab-btn:active {
            transform: scale(0.95);
        }

        /* Floating navbar bergaya pesan yang muncul di atas tombol */
        .mobile-message-navbar {
            position: fixed;
            right: 18px;
            bottom: 80px;
            width: 280px;
            max-width: calc(100vw - 36px);
            z-index: 1060;
            border-radius: 18px;
            box-shadow: 0 16px 38px rgba(15, 23, 42, 0.18);
            transform-origin: bottom right;
            opacity: 0;
            transform: translateY(12px) scale(0.95);
            pointer-events: none;
            transition: opacity 0.2s ease, transform 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .mobile-message-navbar.show {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        .mobile-message-header {
            background: linear-gradient(135deg, #2c7be5 0%, #1a5bb8 100%);
            color: #fff;
            border-top-left-radius: 18px;
            border-top-right-radius: 18px;
            padding: 12px 14px;
        }

        .mobile-message-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            color: inherit;
            text-decoration: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: background-color 0.15s ease;
        }

        .mobile-message-item:last-child {
            border-bottom: 0;
            border-bottom-left-radius: 18px;
            border-bottom-right-radius: 18px;
        }

        .mobile-message-item:hover {
            background-color: rgba(44, 123, 229, 0.07);
        }

        .mobile-message-icon-badge {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
    </style>

    @yield('base.css')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                        <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation">
                            <span class="navbar-toggle-icon"><span class="toggle-line"></span></span>
                        </button>
                    </div>
                    <a class="navbar-brand" href="{{ route('dashboard.home') }}">
                        <div class="d-flex align-items-center py-2">
                            <img class="my-2" src="{{ asset('img/system-panel.png') }}" alt="" width="150" />
                        </div>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                    <div class="navbar-vertical-content scrollbar pt-2">
                        <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                            <li class="nav-item">
                                <a class="nav-link dropdown-indicator" href="#dashboard" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="dashboard">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-icon"><span class="fab fa-dashcube"></span></span>
                                        <span class="nav-link-text ps-1">Dashboard</span>
                                    </div>
                                </a>
                                <ul class="nav collapse false" id="dashboard">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('dashboard.home') }}" aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text ps-1">Back to Home</span>
                                            </div>
                                        </a>
                                    </li>
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
                                <div class="row navbar-vertical-label-wrapper mt-1 mb-1">
                                    <div class="col-auto navbar-vertical-label">{{ $menus->menu_name }}</div>
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
                                <a class="nav-link dropdown-indicator" href="#menu-{{ $sub_menus->id_menu_sub }}" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="dashboard">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-icon"><span class="{{ $sub_menus->menu_sub_icon }}"></span></span>
                                        <span class="nav-link-text ps-1">{{ $sub_menus->menu_sub_name }}</span>
                                    </div>
                                </a>
                                @php
                                $show = DB::table('z_menu_sub_main')
                                ->where('menu_main_sub_code', $akses)
                                ->where('menu_sub_code', $sub_menus->menu_sub_code)->first();
                                $shown = $show ? 'show' : 'false';
                                @endphp
                                <ul class="nav collapse {{$shown}}" id="menu-{{ $sub_menus->id_menu_sub }}">
                                    @foreach ($sub as $item)
                                    @php
                                    $submenu = DB::table('z_menu_user_sub')
                                    ->where('menu_main_sub_code', $item->menu_main_sub_code)
                                    ->where('access_code', Auth::user()->access_code)->first();
                                    @endphp
                                    <li class="nav-item">
                                        @if ($submenu)
                                        <a class="nav-link {{ $akses == $item->menu_main_sub_code ? 'active' : 'false' }}" href="{{ url($item->menu_main_sub_code . '/' . $item->menu_main_sub_link) }}" aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-icon"><span class="{{$item->menu_main_sub_icon}}"></span></span>
                                                <span class="nav-link-text fs--2"> {{$item->menu_main_sub_name}}</span>
                                            </div>
                                        </a>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link {{ $akses ==$sub_menus->menu_sub_code ? 'active' : '' }}" href="{{ url($sub_menus->menu_sub_code . '/' .$sub_menus->menu_sub_link) }}" role="button" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-icon"><span class="{{ $sub_menus->menu_sub_icon }}"></span></span>
                                        <span class="nav-link-text ps-1">{{ $sub_menus->menu_sub_name }}</span>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @endforeach
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="content">
                @php
                $searchableMenus = collect([
                    [
                        'path' => 'Dashboard',
                        'name' => 'Back to Home',
                        'url' => route('dashboard.home'),
                        'icon' => 'fab fa-dashcube'
                    ]
                ]);

                foreach ($menu as $menus) {
                    $subMenuSearch = DB::table('z_menu_user')
                        ->join('z_menu_sub', 'z_menu_sub.menu_sub_code', '=', 'z_menu_user.menu_sub_code')
                        ->where('z_menu_user.access_code', Auth::user()->access_code)
                        ->where('z_menu_sub.menu_code', $menus->menu_code)
                        ->orderBy('z_menu_sub.id_menu_sub', 'ASC')
                        ->get();

                    foreach ($subMenuSearch as $sub_menus) {
                        if ($sub_menus->menu_sub_option == 'dropdown') {
                            $mainSubs = DB::table('z_menu_sub_main')
                                ->join('z_menu_user_sub', 'z_menu_user_sub.menu_main_sub_code', '=', 'z_menu_sub_main.menu_main_sub_code')
                                ->where('z_menu_sub_main.menu_sub_code', $sub_menus->menu_sub_code)
                                ->where('z_menu_user_sub.access_code', Auth::user()->access_code)
                                ->get();

                            foreach ($mainSubs as $item) {
                                $searchableMenus->push([
                                    'path' => $menus->menu_name . ' • ' . $sub_menus->menu_sub_name,
                                    'name' => $item->menu_main_sub_name,
                                    'url' => url($item->menu_main_sub_code . '/' . $item->menu_main_sub_link),
                                    'icon' => $item->menu_main_sub_icon ?: $sub_menus->menu_sub_icon
                                ]);
                            }
                        } else {
                            $searchableMenus->push([
                                'path' => $menus->menu_name,
                                'name' => $sub_menus->menu_sub_name,
                                'url' => url($sub_menus->menu_sub_code . '/' . $sub_menus->menu_sub_link),
                                'icon' => $sub_menus->menu_sub_icon
                            ]);
                        }
                    }
                }
                @endphp

                <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">
                    <div class="d-flex align-items-center w-100 gap-2">
                        <button class="btn navbar-toggler-humburger-icon navbar-toggler flex-shrink-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation">
                            <span class="navbar-toggle-icon"><span class="toggle-line"></span></span>
                        </button>

                        <!-- MOBILE: SEARCH BOX MENU (FLEX OTOMATIS) -->
                        <div class="d-block d-lg-none navbar-menu-search-box mobile-search-flex" id="navbarMenuSearchBoxMobile">
                            <div class="search-box" data-list='{"valueNames":["title"]}'>
                                <form class="position-relative" data-bs-toggle="search" data-bs-display="static" onsubmit="return false;">
                                    <input class="form-control search-input fuzzy-search navbar-menu-search-input" id="navbarMenuSearchInputMobile" type="search" placeholder="Cari menu..." aria-label="Search" autocomplete="off" />
                                    <!-- <span class="fas fa-search search-box-icon"></span> -->
                                </form>
                                <div class="btn-close-falcon-container position-absolute end-0 top-50 translate-middle shadow-none" data-bs-dismiss="search">
                                    <div class="btn-close-falcon" aria-label="Close"></div>
                                </div>
                                <div class="dropdown-menu border font-base start-0 mt-2 py-0 overflow-hidden">
                                    <div class="scrollbar list py-2" style="max-height: 24rem;">
                                        <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-1 pb-2">Daftar Menu</h6>
                                        @foreach ($searchableMenus as $mItem)
                                        <a class="dropdown-item fs--1 px-card py-2 hover-primary navbar-menu-result" href="{{ $mItem['url'] }}">
                                            <div class="d-flex align-items-start">
                                                <span class="{{ $mItem['icon'] ?: 'fas fa-circle' }} me-2 mt-1 text-primary fs--1 flex-shrink-0"></span>
                                                <div>
                                                    <span class="search-menu-breadcrumb">{{ $mItem['path'] }}</span>
                                                    <span class="search-menu-name title">{{ $mItem['path'] }} - {{ $mItem['name'] }}</span>
                                                </div>
                                            </div>
                                        </a>
                                        @endforeach
                                    </div>
                                    <div class="text-center py-2 d-none navbar-search-no-result">
                                        <p class="fallback fw-bold fs--1 mb-0 text-500">Menu tidak ditemukan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DESKTOP: SEARCH BOX MENU -->
                        <ul class="navbar-nav align-items-center d-none d-lg-block mb-0">
                            <li class="nav-item">
                                <div class="search-box navbar-menu-search-box" id="navbarMenuSearchBox" data-list='{"valueNames":["title"]}'>
                                    <form class="position-relative" data-bs-toggle="search" data-bs-display="static" onsubmit="return false;">
                                        <input class="form-control search-input fuzzy-search navbar-menu-search-input" id="navbarMenuSearchInput" type="search" placeholder="Cari menu..." aria-label="Search" autocomplete="off" />
                                        <!-- <span class="fas fa-search search-box-icon"></span> -->
                                    </form>
                                    <div class="btn-close-falcon-container position-absolute end-0 top-50 translate-middle shadow-none" data-bs-dismiss="search">
                                        <div class="btn-close-falcon" aria-label="Close"></div>
                                    </div>
                                    <div class="dropdown-menu border font-base start-0 mt-2 py-0 overflow-hidden w-100">
                                        <div class="scrollbar list py-2" style="max-height: 24rem;">
                                            <h6 class="dropdown-header fw-medium text-uppercase px-card fs--2 pt-1 pb-2">Daftar Menu</h6>
                                            @foreach ($searchableMenus as $mItem)
                                            <a class="dropdown-item fs--1 px-card py-2 hover-primary navbar-menu-result" href="{{ $mItem['url'] }}">
                                                <div class="d-flex align-items-start">
                                                    <span class="{{ $mItem['icon'] ?: 'fas fa-circle' }} me-2 mt-1 text-primary fs--1 flex-shrink-0"></span>
                                                    <div>
                                                        <span class="search-menu-breadcrumb">{{ $mItem['path'] }}</span>
                                                        <span class="search-menu-name title">{{ $mItem['path'] }} - {{ $mItem['name'] }}</span>
                                                    </div>
                                                </div>
                                            </a>
                                            @endforeach
                                        </div>
                                        <div class="text-center py-2 d-none navbar-search-no-result">
                                            <p class="fallback fw-bold fs--1 mb-0 text-500">Menu tidak ditemukan.</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>

                        <!-- DESKTOP: 3 BUTTON KANAN -->
                        <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center d-none d-lg-flex flex-shrink-0 mb-0">
                            <li class="nav-item">
                                <div class="theme-control-toggle fa-icon-wait px-2">
                                    <input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle" type="checkbox" data-theme-control="theme" value="dark" />
                                    <label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to light theme"><span class="fas fa-sun fs-0"></span></label>
                                    <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to dark theme"><span class="fas fa-moon fs-0"></span></label>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link notification-indicator notification-indicator-primary px-0 fa-icon-wait" id="navbarDropdownNotification" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="fas fa-bell" data-fa-transform="shrink-6" style="font-size: 33px;"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-card dropdown-menu-notification" aria-labelledby="navbarDropdownNotification">
                                    <div class="card card-notification shadow-none">
                                        <div class="card-header">
                                            <div class="row justify-content-between align-items-center">
                                                <div class="col-auto">
                                                    <h6 class="card-header-title mb-0">Notifications</h6>
                                                </div>
                                                <div class="col-auto ps-0 ps-sm-3"><a class="card-link fw-normal" href="#">Mark all as read</a></div>
                                            </div>
                                        </div>
                                        <div class="scrollbar-overlay" style="max-height:19rem" id="show-notification"></div>
                                        <div class="card-footer text-center border-top"><a class="card-link d-block" href="../app/social/notifications.html">View all</a></div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link pe-0" id="navbarDropdownUser" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="avatar avatar-xl">
                                        <img class="rounded-circle" src="{{ asset('img/pp.png') }}" alt="" />
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
                                    <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                        <a class="dropdown-item text-primary text-center">{{ Auth::user()->fullname }}</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#!" id="button-setup-notification" data-bs-toggle="modal" data-bs-target="#modal-template-sm">
                                            <span class="fas fa-cogs me-1 text-warning"></span> Set Notification
                                        </a>
                                        <a class="dropdown-item" href="#" id="button-setup-profil" data-bs-toggle="modal" data-bs-target="#modal-template-xl">
                                            <span class="fas fa-user-cog me-1 text-info"></span> Profile & account
                                        </a>
                                        @if (Auth::user()->access_code == 'master')
                                        <a class="dropdown-item" href="{{route('master_dashboard')}}">
                                            <span class="fas fa-th-large me-2 text-danger"></span> Master Page
                                        </a>
                                        @endif
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}"><span class="fab fa-keycdn"></span> Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

                @yield('content')

                <footer class="footer">
                    <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600">Thank you for creating with Transforma<span class="d-none d-sm-inline-block">| </span><br class="d-sm-none" /> 2025 &copy;
                                <a href="#">{{ Env('APP_NAME') }}</a>
                                <button class="btn btn-primary" id="liveToastBtn" type="button" hidden></button>
                            </p>
                        </div>
                        <div class="col-12 col-sm-auto text-center">
                            <img src="{{ asset('img/logo-pt.png') }}" alt="" width="90">
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </main>

    <!-- MOBILE: FLOATING MESSAGE NAVBAR & PROFILE BOTTOM-RIGHT BUTTON -->
    <div class="d-lg-none">
        <div class="mobile-message-navbar bg-white dark__bg-1000 border" id="mobileMessageNavbar">
            <div class="mobile-message-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 min-w-0">
                    <img class="rounded-circle border border-white flex-shrink-0" src="{{ asset('img/pp.png') }}" alt="" width="34" height="34" />
                    <div class="min-w-0">
                        <div class="fw-semibold fs--1 text-truncate">{{ Auth::user()->fullname }}</div>
                        <div class="fs--2 opacity-75">Quick Menu</div>
                    </div>
                </div>
                <button class="btn btn-sm text-white p-1" type="button" id="closeMobileMessageNavbar" aria-label="Tutup">
                    <span class="fas fa-times"></span>
                </button>
            </div>

            <div class="mobile-message-item justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="mobile-message-icon-badge bg-soft-primary text-primary">
                        <span class="fas fa-adjust"></span>
                    </span>
                    <span class="fs--1 fw-medium">Tema Tampilan</span>
                </div>
                <div class="theme-control-toggle fa-icon-wait">
                    <input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggleMobile" type="checkbox" data-theme-control="theme" value="dark" />
                    <label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggleMobile" title="Switch to light theme"><span class="fas fa-sun fs-0"></span></label>
                    <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggleMobile" title="Switch to dark theme"><span class="fas fa-moon fs-0"></span></label>
                </div>
            </div>

            <a class="mobile-message-item" href="#navbarDropdownNotification" onclick="$('#mobileMessageNavbar').removeClass('show'); $('#navbarDropdownNotification').dropdown('toggle');">
                <span class="mobile-message-icon-badge bg-soft-info text-info">
                    <span class="fas fa-bell"></span>
                </span>
                <div class="flex-1">
                    <div class="fs--1 fw-medium">Notifications</div>
                    <div class="fs--2 text-500">Lihat pemberitahuan terbaru</div>
                </div>
            </a>

            <a class="mobile-message-item" href="#!" id="button-setup-notification-mobile" data-bs-toggle="modal" data-bs-target="#modal-template-sm">
                <span class="mobile-message-icon-badge bg-soft-warning text-warning">
                    <span class="fas fa-cogs"></span>
                </span>
                <div class="flex-1">
                    <div class="fs--1 fw-medium">Set Notification</div>
                    <div class="fs--2 text-500">Atur preferensi notifikasi</div>
                </div>
            </a>

            <a class="mobile-message-item" href="#" id="button-setup-profil-mobile" data-bs-toggle="modal" data-bs-target="#modal-template-xl">
                <span class="mobile-message-icon-badge bg-soft-success text-success">
                    <span class="fas fa-user-cog"></span>
                </span>
                <div class="flex-1">
                    <div class="fs--1 fw-medium">Profile & account</div>
                    <div class="fs--2 text-500">Kelola profil akun</div>
                </div>
            </a>

            <a class="mobile-message-item" href="#settings-offcanvas" data-bs-toggle="offcanvas" onclick="$('#mobileMessageNavbar').removeClass('show');">
                <span class="mobile-message-icon-badge bg-soft-primary text-primary">
                    <span class="fas fa-sliders-h"></span>
                </span>
                <div class="flex-1">
                    <div class="fs--1 fw-medium">Setting</div>
                    <div class="fs--2 text-500">Pengaturan layout &amp; tema</div>
                </div>
            </a>

            @if (Auth::user()->access_code == 'master')
            <a class="mobile-message-item" href="{{route('master_dashboard')}}">
                <span class="mobile-message-icon-badge bg-soft-danger text-danger">
                    <span class="fas fa-th-large"></span>
                </span>
                <div class="flex-1">
                    <div class="fs--1 fw-medium">Master Page</div>
                    <div class="fs--2 text-500">Panel administrator</div>
                </div>
            </a>
            @endif

            <a class="mobile-message-item" href="{{ route('logout') }}">
                <span class="mobile-message-icon-badge bg-soft-secondary text-700">
                    <span class="fab fa-keycdn"></span>
                </span>
                <div class="flex-1">
                    <div class="fs--1 fw-medium text-danger">Logout</div>
                    <div class="fs--2 text-500">Keluar dari sesi</div>
                </div>
            </a>
        </div>

        <div class="mobile-fab-container">
            <button class="btn btn-primary mobile-fab-btn" id="mobileFabToggleBtn" type="button" aria-expanded="false" aria-label="Buka Menu Profil & Pintas">
                <img src="{{ asset('img/pp.png') }}" alt="Profile" id="mobileFabProfileImg" />
                <span class="fas fa-times d-none" id="mobileFabCloseIcon"></span>
            </button>
        </div>
    </div>

    <!-- Offcanvas Settings Panel -->
    <div class="offcanvas offcanvas-end settings-panel border-0" id="settings-offcanvas" tabindex="-1" aria-labelledby="settings-offcanvas">
        <div class="offcanvas-header settings-panel-header bg-shape">
            <div class="z-index-1 py-1 light">
                <h5 class="text-white"><span class="fas fa-palette me-2 fs-0"></span>Settings</h5>
                <p class="mb-0 fs--1 text-white opacity-75">Set your own customized style</p>
            </div>
            <button class="btn-close btn-close-white z-index-1 mt-0" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body scrollbar-overlay px-card" id="themeController">
            <h5 class="fs-0">Color Scheme</h5>
            <p class="fs--1">Choose the perfect color mode for your app.</p>
            <div class="btn-group d-block w-100 btn-group-navbar-style">
                <div class="row gx-2">
                    <div class="col-6">
                        <input class="btn-check" id="themeSwitcherLight" name="theme-color" type="radio" value="light" data-theme-control="theme" />
                        <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherLight">
                            <span class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0" src="{{ asset('asset/img/generic/falcon-mode-default.jpg') }}" alt="" /></span>
                            <span class="label-text">Light</span>
                        </label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="themeSwitcherDark" name="theme-color" type="radio" value="dark" data-theme-control="theme" />
                        <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherDark">
                            <span class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0" src="{{ asset('asset/img/generic/falcon-mode-dark.jpg') }}" alt="" /></span>
                            <span class="label-text"> Dark</span>
                        </label>
                    </div>
                </div>
            </div>
            <hr />
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-start">
                    <img class="me-2" src="{{ asset('asset/img/icons/left-arrow-from-left.svg') }}" width="20" alt="" />
                    <div class="flex-1">
                        <h5 class="fs-0">RTL Mode</h5>
                        <p class="fs--1 mb-0">Pariatur labore dolorem laboriosam eum at ratione...</p>
                    </div>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input ms-0" id="mode-rtl" type="checkbox" data-theme-control="isRTL" />
                </div>
            </div>
            <hr />
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-start">
                    <img class="me-2" src="{{ asset('asset/img/icons/arrows-h.svg') }}" width="20" alt="" />
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
                        <input class="btn-check" id="navbar-style-transparent" type="radio" name="navbarStyle" value="transparent" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-transparent">
                            <img class="img-fluid img-prototype" src="{{ asset('asset/img/generic/default.png') }}" alt="" /><span class="label-text"> Transparent</span>
                        </label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-inverted" type="radio" name="navbarStyle" value="inverted" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-inverted">
                            <img class="img-fluid img-prototype" src="{{ asset('asset/img/generic/inverted.png') }}" alt="" /><span class="label-text"> Inverted</span>
                        </label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-card" type="radio" name="navbarStyle" value="card" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-card">
                            <img class="img-fluid img-prototype" src="{{ asset('asset/img/generic/card.png') }}" alt="" /><span class="label-text"> Card</span>
                        </label>
                    </div>
                    <div class="col-6">
                        <input class="btn-check" id="navbar-style-vibrant" type="radio" name="navbarStyle" value="vibrant" data-theme-control="navbarStyle" />
                        <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-vibrant">
                            <img class="img-fluid img-prototype" src="{{ asset('asset/img/generic/vibrant.png') }}" alt="" /><span class="label-text"> Vibrant</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DESKTOP: SETTING TOGGLE -->
    <a class="card setting-toggle d-none d-lg-block" href="#settings-offcanvas" data-bs-toggle="offcanvas">
        <div class="card-body d-flex align-items-center py-md-2 px-2 py-1">
            <div class="bg-soft-primary position-relative rounded-start" style="height:34px;width:28px">
                <div class="settings-popover">
                    <span class="ripple">
                        <span class="fa-spin position-absolute all-0 d-flex flex-center">
                            <span class="icon-spin position-absolute all-0 d-flex flex-center">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.7369 12.3941L19.1989 12.1065C18.4459 11.7041 18.0843 10.8487 18.0843 9.99495C18.0843 9.14118 18.4459 8.28582 19.1989 7.88336L19.7369 7.59581C19.9474 7.47484 20.0316 7.23291 19.9474 7.03131C19.4842 5.57973 18.6843 4.28943 17.6738 3.20075C17.5053 3.03946 17.2527 2.99914 17.0422 3.12011L16.393 3.46714C15.6883 3.84379 14.8377 3.74529 14.1476 3.3427C14.0988 3.31422 14.0496 3.28621 14.0002 3.25868C13.2568 2.84453 12.7055 2.10629 12.7055 1.25525V0.70081C12.7055 0.499202 12.5371 0.297594 12.2845 0.257272C10.7266 -0.105622 9.16879 -0.0653007 7.69516 0.257272C7.44254 0.297594 7.31623 0.499202 7.31623 0.70081V1.23474C7.31623 2.09575 6.74999 2.8362 5.99824 3.25599C5.95774 3.27861 5.91747 3.30159 5.87744 3.32493C5.15643 3.74527 4.26453 3.85902 3.53534 3.45302L2.93743 3.12011C2.72691 2.99914 2.47429 3.03946 2.30587 3.20075C1.29538 4.28943 0.495411 5.57973 0.0322686 7.03131C-0.051939 7.23291 0.0322686 7.47484 0.242788 7.59581L0.784376 7.8853C1.54166 8.29007 1.92694 9.13627 1.92694 9.99495C1.92694 10.8536 1.54166 11.6998 0.784375 12.1046L0.242788 12.3941C0.0322686 12.515 -0.051939 12.757 0.0322686 12.9586C0.495411 14.4102 1.29538 15.7005 2.30587 16.7891C2.47429 16.9504 2.72691 16.9907 2.93743 16.8698L3.58669 16.5227C4.29133 16.1461 5.14131 16.2457 5.8331 16.6455C5.88713 16.6767 5.94159 16.7074 5.99648 16.7375C6.75162 17.1511 7.31623 17.8941 7.31623 18.7552V19.2891C7.31623 19.4425 7.41373 19.5959 7.55309 19.696C7.64066 19.7589 7.74815 19.7843 7.85406 19.8046C9.35884 20.0925 10.8609 20.0456 12.2845 19.7729C12.5371 19.6923 12.7055 19.4907 12.7055 19.2891V18.7346C12.7055 17.8836 13.2568 17.1454 14.0002 16.7312C14.0496 16.7037 14.0988 16.6757 14.1476 16.6472C14.8377 16.2446 15.6883 16.1461 16.393 16.5227L17.0422 16.8698C17.2527 16.9907 17.5053 16.9504 17.6738 16.7891C18.7264 15.7005 19.4842 14.4102 19.9895 12.9586C20.0316 12.757 19.9474 12.515 19.7369 12.3941ZM10.0109 13.2005C8.1162 13.2005 6.64257 11.7893 6.64257 9.97478C6.64257 8.20063 8.1162 6.74905 10.0109 6.74905C11.8634 6.74905 13.3792 8.20063 13.3792 9.97478C13.3792 11.7893 11.8634 13.2005 10.0109 13.2005Z" fill="#2A7BE4"></path>
                                </svg>
                            </span>
                        </span>
                    </span>
                </div>
            </div>
            <small class="text-uppercase text-primary fw-bold bg-soft-primary py-2 pe-2 ps-1 rounded-end">Setting</small>
        </div>
    </a>

    <!-- Modals -->
    <div class="modal fade" id="modal-template" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-template"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-template-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-template-xl"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-template-sm" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-template-sm"></div>
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
    <script src="{{ asset('online/resumable.min.js') }}"></script>
    <script src="{{ asset('asset/notifications/js/notifications.min.js') }}"></script>

    <!-- Search Box Menu Filter & Mobile Floating Message Navbar -->
    <script>
        $(document).ready(function() {
            $('.navbar-menu-search-box').each(function() {
                const $box = $(this);
                const $searchContainer = $box.find('.search-box');
                const $input = $box.find('.navbar-menu-search-input');
                const $dropdown = $box.find('.dropdown-menu');
                const $noResult = $box.find('.navbar-search-no-result');

                function toggleSearchIcon() {
                    const hasVal = ($input.val() || '').trim().length > 0;
                    $searchContainer.toggleClass('has-query', hasVal);
                }

                function filterMenus() {
                    const q = ($input.val() || '').toLowerCase().trim();
                    let visible = 0;

                    toggleSearchIcon();

                    $box.find('.navbar-menu-result').each(function() {
                        const $row = $(this);
                        const text = ($row.find('.title').text() || '').toLowerCase();
                        const pathText = ($row.find('.search-menu-breadcrumb').text() || '').toLowerCase();
                        const matched = q === '' || text.indexOf(q) !== -1 || pathText.indexOf(q) !== -1;

                        $row.css('display', matched ? '' : 'none');
                        if (matched) visible++;
                    });

                    $noResult.toggleClass('d-none', visible > 0);
                }

                $input.on('input focus', function() {
                    filterMenus();
                    $dropdown.addClass('show');
                });

                $box.find('.btn-close-falcon').on('click', function() {
                    $input.val('');
                    filterMenus();
                });

                $(document).on('click', function(e) {
                    if (!$(e.target).closest($box).length) {
                        $dropdown.removeClass('show');
                    }
                });
            });

            // Toggle Floating Message Navbar (Mobile) dengan gambar profil
            const $fabBtn = $('#mobileFabToggleBtn');
            const $fabProfileImg = $('#mobileFabProfileImg');
            const $fabCloseIcon = $('#mobileFabCloseIcon');
            const $msgNav = $('#mobileMessageNavbar');

            function setMobileMessageOpen(open) {
                $msgNav.toggleClass('show', open);
                $fabBtn.attr('aria-expanded', open ? 'true' : 'false');
                if (open) {
                    $fabProfileImg.addClass('d-none');
                    $fabCloseIcon.removeClass('d-none');
                } else {
                    $fabProfileImg.removeClass('d-none');
                    $fabCloseIcon.addClass('d-none');
                }
            }

            $fabBtn.on('click', function(e) {
                e.stopPropagation();
                const isOpen = $msgNav.hasClass('show');
                setMobileMessageOpen(!isOpen);
            });

            $('#closeMobileMessageNavbar').on('click', function(e) {
                e.stopPropagation();
                setMobileMessageOpen(false);
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#mobileMessageNavbar, #mobileFabToggleBtn').length) {
                    setMobileMessageOpen(false);
                }
            });
        });
    </script>

    @yield('base.js')

    @if (session('success'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 99999">
        <div class="toast show" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true" data-options='{"autoShow":true,"showOnce":true,"cookieExpireTime":3}' data-autohide="false">
            <div class="toast-header bg-primary text-white"><strong class="me-auto">Notice</strong><small>1 sec ago</small>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">{{ session('success') }}</div>
        </div>
    </div>
    @elseif (session('error'))
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 99999">
        <div class="toast show" id="liveToast" role="alert" aria-live="assertive" aria-atomic="true" data-options='{"autoShow":true,"showOnce":true,"cookieExpireTime":720}' data-autohide="false">
            <div class="toast-header bg-danger text-white"><strong class="me-auto">Notice</strong><small>1 sec ago</small>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">{{ session('error') }}</div>
        </div>
    </div>
    @endif
</body>

</html>
