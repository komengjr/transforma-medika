<!DOCTYPE html>
<html lang="id" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- Document Title -->
    <title>{{ env('APP_NAME') }} | Management System</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <link rel="manifest" href="../../../asset/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="{{ asset('img/favicon.png') }}">
    <meta name="theme-color" content="#4f46e5">
    <script src="{{ asset('asset/js/config.js') }}"></script>

    <!-- Stylesheets -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        /* ========================================================= */
        /* MODERN ENTERPRISE THEME (MATCHING LANDING INDEX)          */
        /* ========================================================= */
        :root {
            --brand-indigo: #4f46e5;
            --brand-indigo-dark: #3730a3;
            --brand-indigo-soft: #eef2ff;
            --brand-slate-900: #0f172a;
            --brand-slate-800: #1e293b;
            --brand-slate-600: #475569;
            --brand-slate-200: #e2e8f0;
            --brand-bg: #f8fafc;
            --card-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
            --card-shadow-hover: 0 14px 28px -5px rgba(79, 70, 229, 0.14), 0 6px 12px -4px rgba(15, 23, 42, 0.06);
        }

        body {
            font-family: 'Inter', sans-serif !important;
            margin: 0;
            padding: 0;
            color: var(--brand-slate-900);
            background-color: var(--brand-bg);
            background-image:
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(16, 185, 129, 0.07) 0px, transparent 50%),
                radial-gradient(circle, rgba(99, 102, 241, 0.1) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 32px 32px;
            position: relative;
            min-height: 100vh;
        }

        input,
        button,
        select,
        textarea,
        .dropdown-menu,
        .modal,
        p,
        span,
        a,
        .badge {
            font-family: 'Inter', sans-serif !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-weight: 700 !important;
        }

        /* ========================================================= */
        /* MODE DESKTOP: MODERN ENTERPRISE LAUNCHER                  */
        /* ========================================================= */
        @media (min-width: 992px) {

            html,
            body {
                height: 100vh !important;
                max-height: 100vh !important;
                overflow: hidden !important;
            }

            .main-desktop-wrapper {
                height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 1.5rem 2.75rem;
                box-sizing: border-box;
            }

            .desktop-content-container {
                flex: 1;
                display: flex;
                flex-direction: column;
                max-width: 1400px;
                margin: 0 auto;
                width: 100%;
                min-height: 0;
            }

            /* Header Desktop Card Modern */
            .glass-header-card {
                background: rgba(255, 255, 255, 0.92);
                backdrop-filter: blur(12px);
                border-radius: 18px;
                border: 1px solid var(--brand-slate-200);
                box-shadow: var(--card-shadow);
                padding: 0.85rem 1.5rem;
                margin-bottom: 1rem;
                position: relative;
                z-index: 1050 !important;
                flex-shrink: 0;
            }

            .brand-logo-box {
                background: #ffffff;
                border: 1px solid var(--brand-slate-200);
                border-radius: 12px;
                padding: 0.45rem 0.75rem;
                box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
            }

            .desktop-search-wrapper {
                max-width: 440px;
            }

            .modern-search-group {
                background: #f1f5f9;
                border: 1px solid transparent;
                border-radius: 12px;
                transition: all 0.2s ease;
            }

            .modern-search-group:focus-within {
                background: #ffffff;
                border-color: var(--brand-indigo);
                box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
            }

            .modern-search-group input {
                background: transparent !important;
                font-size: 0.875rem;
                color: var(--brand-slate-900);
            }

            .modern-search-group input:focus {
                outline: none;
                box-shadow: none;
            }

            /* Announcement Banner Modern */
            .marquee-box {
                background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #312e81 100%);
                border-radius: 14px;
                padding: 10px 18px;
                color: #f8fafc;
                margin-bottom: 1.25rem;
                box-shadow: 0 6px 16px -4px rgba(30, 27, 75, 0.25);
                border: 1px solid rgba(99, 102, 241, 0.25);
                flex-shrink: 0;
                font-weight: 500;
            }

            .marquee-pill {
                background: rgba(99, 102, 241, 0.25);
                border: 1px solid rgba(129, 140, 248, 0.4);
                color: #c7d2fe;
                font-size: 0.7rem;
                font-weight: 700;
                padding: 3px 10px;
                border-radius: 99px;
                letter-spacing: 0.4px;
                text-transform: uppercase;
                white-space: nowrap;
            }

            /* Container Grid App Desktop */
            .menu-grid-desktop {
                flex: 1;
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                grid-auto-rows: min-content;
                gap: 1.15rem;
                align-items: stretch;
                align-content: start;
                min-height: 0;
                overflow-y: auto;
                padding: 0.25rem 0.5rem 1rem 0.1rem;
            }

            .menu-grid-desktop::-webkit-scrollbar {
                width: 6px;
            }

            .menu-grid-desktop::-webkit-scrollbar-track {
                background: transparent;
            }

            .menu-grid-desktop::-webkit-scrollbar-thumb {
                background-color: #cbd5e1;
                border-radius: 99px;
            }

            .menu-grid-desktop::-webkit-scrollbar-thumb:hover {
                background-color: var(--brand-indigo);
            }

            /* ----------------------------------------------------- */
            /* MODERN ENTERPRISE CARD STYLING                        */
            /* ----------------------------------------------------- */
            .menu-card-desktop {
                background: #ffffff;
                border-radius: 18px;
                border: 1px solid var(--brand-slate-200);
                position: relative;
                min-height: 150px;
                cursor: pointer;
                transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: var(--card-shadow);
                overflow: hidden;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 1.35rem;
                z-index: 1;
            }

            .menu-card-desktop::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 3px;
                background: var(--card-accent, var(--brand-indigo));
                opacity: 0;
                transition: opacity 0.25s ease;
            }

            .menu-card-desktop:hover {
                transform: translateY(-4px);
                box-shadow: var(--card-shadow-hover);
                border-color: rgba(79, 70, 229, 0.35);
            }

            .menu-card-desktop:hover::before {
                opacity: 1;
            }

            .card-content-wrapper {
                display: flex;
                flex-direction: column;
                height: 100%;
                justify-content: space-between;
            }

            .menu-icon-wrapper {
                width: 48px;
                height: 48px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.25rem;
                margin-bottom: 1rem;
                transition: transform 0.25s ease, box-shadow 0.25s ease;
            }

            .menu-card-desktop:hover .menu-icon-wrapper {
                transform: scale(1.07);
            }

            .card-arrow-hint {
                width: 28px;
                height: 28px;
                border-radius: 8px;
                background: #f8fafc;
                color: #94a3b8;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.75rem;
                transition: all 0.2s ease;
            }

            .menu-card-desktop:hover .card-arrow-hint {
                background: var(--brand-indigo-soft);
                color: var(--brand-indigo);
                transform: translateX(2px);
            }

            .card-text h6 {
                color: var(--brand-slate-900);
                font-size: 0.92rem;
                letter-spacing: -0.01em;
                transition: color 0.2s ease;
            }

            .menu-card-desktop:hover .card-text h6 {
                color: var(--brand-indigo);
            }

            .card-text p {
                color: var(--brand-slate-600);
                line-height: 1.4;
                font-weight: 400;
                font-size: 0.76rem;
            }

            .desktop-footer {
                padding: 0.75rem 0 0 0;
                text-align: center;
                color: var(--brand-slate-600) !important;
                flex-shrink: 0;
                font-weight: 500;
            }
        }

        /* ========================================================= */
        /* MODE MOBILE: MODERN CLEAN APP LAUNCHER                    */
        /* ========================================================= */
        @media (max-width: 991.98px) {
            body {
                padding-bottom: 95px;
            }

            .mobile-header-bar {
                background: rgba(255, 255, 255, 0.92);
                backdrop-filter: blur(12px);
                border-bottom: 1px solid var(--brand-slate-200);
                box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
                padding: 0.85rem 1.1rem;
                position: sticky;
                top: 0;
                z-index: 10000;
            }

            .android-widget-card {
                background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
                border: 1px solid rgba(99, 102, 241, 0.3);
                color: #ffffff;
                border-radius: 20px;
                padding: 1.25rem;
                margin: 1rem;
                box-shadow: 0 12px 24px -6px rgba(30, 27, 75, 0.35);
            }

            .android-app-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1.1rem 0.5rem;
                padding: 0.5rem 0.9rem;
            }

            .app-item-mobile {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-decoration: none;
                cursor: pointer;
            }

            .app-icon-wrapper {
                width: 58px;
                height: 58px;
                border-radius: 18px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.35rem;
                box-shadow: 0 6px 14px -3px rgba(15, 23, 42, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.8);
                margin-bottom: 7px;
                transition: transform 0.15s ease, box-shadow 0.15s ease;
            }

            .app-item-mobile:active .app-icon-wrapper {
                transform: scale(0.93);
            }

            .app-label-mobile {
                font-size: 0.7rem;
                font-weight: 600;
                color: var(--brand-slate-800);
                text-align: center;
                line-height: 1.25;
                max-width: 76px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .android-bottom-nav {
                position: fixed;
                bottom: 16px;
                left: 50%;
                transform: translateX(-50%);
                width: 92%;
                max-width: 410px;
                height: 68px;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(14px);
                border-radius: 22px;
                display: flex;
                align-items: center;
                justify-content: space-around;
                padding: 0 10px;
                box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.15);
                border: 1px solid var(--brand-slate-200);
                z-index: 10000;
            }

            .android-nav-btn {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                font-size: 0.68rem;
                font-weight: 600;
                color: var(--brand-slate-600);
                transition: all 0.2s ease;
                padding: 4px 10px;
                border-radius: 12px;
            }

            .nav-icon-wrapper {
                width: 34px;
                height: 34px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
                margin-bottom: 2px;
                transition: all 0.2s ease;
            }

            .nav-icon-home {
                background: #eef2ff;
                color: #4f46e5;
            }

            .nav-icon-reset {
                background: #fef3c7;
                color: #d97706;
            }

            .nav-icon-info {
                background: #e0f2fe;
                color: #0284c7;
            }

            .nav-icon-logout {
                background: #ffe4e6;
                color: #e11d48;
            }

            .android-nav-btn.active {
                color: var(--brand-indigo);
                font-weight: 700;
            }

            .android-nav-btn.active .nav-icon-home {
                background: var(--brand-indigo);
                color: #ffffff;
                box-shadow: 0 4px 10px rgba(79, 70, 229, 0.35);
            }
        }

        /* ========================================================= */
        /* MODERN DROPDOWN, BADGES & MODALS                          */
        /* ========================================================= */
        .modern-badge {
            border-radius: 8px;
            padding: 4px 10px;
            font-weight: 600;
            font-size: 0.7rem;
            letter-spacing: 0.02em;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .badge-indigo {
            background-color: #eef2ff;
            color: #4338ca;
            border: 1px solid #c7d2fe;
        }

        .badge-emerald {
            background-color: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        .glass-dropdown-menu,
        .glass-dropdown-mobile {
            background: #ffffff !important;
            border: 1px solid var(--brand-slate-200) !important;
            box-shadow: 0 20px 35px -10px rgba(15, 23, 42, 0.14), 0 4px 12px -2px rgba(15, 23, 42, 0.05) !important;
            border-radius: 16px !important;
            padding: 0.6rem !important;
            min-width: 245px !important;
            z-index: 999999 !important;
        }

        .dropdown-profile-header {
            background: #f8fafc;
            border: 1px solid var(--brand-slate-200);
            border-radius: 12px;
            padding: 0.75rem 0.85rem;
            margin-bottom: 0.45rem;
        }

        .glass-dropdown-item,
        .mobile-dropdown-item {
            border-radius: 10px !important;
            padding: 0.55rem 0.75rem !important;
            font-size: 0.83rem !important;
            font-weight: 600 !important;
            color: var(--brand-slate-800) !important;
            transition: all 0.15s ease !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }

        .glass-dropdown-item:hover,
        .mobile-dropdown-item:active {
            background-color: #eef2ff !important;
            color: var(--brand-indigo) !important;
        }

        .glass-dropdown-item.text-danger:hover {
            background-color: #fff1f2 !important;
            color: #e11d48 !important;
        }

        .item-icon-box {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            margin-right: 10px;
        }

        .btn-dropdown-trigger,
        .btn-mobile-trigger {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px !important;
            background: #ffffff !important;
            border: 1px solid var(--brand-slate-200) !important;
            color: var(--brand-slate-600) !important;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04) !important;
            transition: all 0.15s ease !important;
        }

        .btn-dropdown-trigger:hover,
        .btn-dropdown-trigger[aria-expanded="true"],
        .btn-mobile-trigger:active,
        .btn-mobile-trigger[aria-expanded="true"] {
            background: #eef2ff !important;
            border-color: #c7d2fe !important;
            color: var(--brand-indigo) !important;
        }

        /* Modal Styling Modern */
        .modal-sm-custom {
            max-width: 400px;
        }

        .modern-modal-content {
            background: #ffffff !important;
            border: 1px solid var(--brand-slate-200) !important;
            border-radius: 22px !important;
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25) !important;
            overflow: hidden;
        }

        .glass-reset-modal {
            padding: 2rem 1.75rem;
            position: relative;
        }

        .btn-close-custom {
            position: absolute;
            top: 16px;
            right: 16px;
            font-size: 0.75rem;
            z-index: 10;
            background-color: #f1f5f9;
            border-radius: 50%;
            padding: 8px;
            transition: background-color 0.2s;
        }

        .btn-close-custom:hover {
            background-color: #e2e8f0;
        }

        .reset-icon-badge {
            width: 58px;
            height: 58px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-input {
            border: 1px solid #cbd5e1 !important;
            border-radius: 10px !important;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.65rem 0.85rem;
            background: #ffffff !important;
            transition: all 0.2s ease;
        }

        .custom-input:focus {
            border-color: var(--brand-indigo) !important;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12) !important;
            outline: none;
        }

        .input-group .custom-input {
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }

        .input-group-text {
            border: 1px solid #cbd5e1 !important;
            border-right: 0 !important;
            border-radius: 10px 0 0 10px !important;
            background: #f8fafc !important;
            color: var(--brand-slate-600) !important;
        }

        .otp-input {
            width: 46px;
            height: 52px;
            font-size: 1.35rem;
            font-weight: 700;
            border-radius: 12px;
            background: #f8fafc;
            border: 1.5px solid #cbd5e1;
            color: var(--brand-slate-900);
            transition: all 0.15s ease;
        }

        .otp-input:focus {
            background: #ffffff;
            border-color: var(--brand-indigo);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
            outline: none;
        }

        .modern-btn {
            font-weight: 600 !important;
            border-radius: 12px !important;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none !important;
        }

        .btn-primary-gradient {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 6px 15px -3px rgba(79, 70, 229, 0.35) !important;
        }

        .btn-primary-gradient:hover {
            background: linear-gradient(135deg, #4338ca 0%, #3730a3 100%) !important;
            transform: translateY(-1px);
            color: #ffffff !important;
        }

        .btn-success-gradient {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 6px 15px -3px rgba(16, 185, 129, 0.35) !important;
        }

        .btn-success-gradient:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
            transform: translateY(-1px);
            color: #ffffff !important;
        }
    </style>
</head>

<body>
    @php
    if (Auth::user()->access_code == 'master') {
    $menu = DB::table('z_menu_super')->get();
    } else {
    $menu = DB::table('z_menu_super')
    ->join('z_menu_user_super', 'z_menu_user_super.menu_super_code', '=', 'z_menu_super.menu_super_code')
    ->where('z_menu_user_super.access_code', Auth::user()->access_code)
    ->get();
    }
    @endphp

    <!-- ========================================================= -->
    <!-- DESKTOP MODE CONTAINER                                    -->
    <!-- ========================================================= -->
    <div class="main-desktop-wrapper d-none d-lg-flex">
        <div class="desktop-content-container">

            <!-- Desktop Header Card -->
            <div class="glass-header-card">
                <div class="d-flex align-items-center justify-content-between">

                    <!-- Kiri: Brand & Logo -->
                    <div class="d-flex align-items-center gap-3">
                        <div class="brand-logo-box">
                            <img src="{{ asset('img/system-panel.png') }}" alt="Logo" width="85" height="36" style="object-fit: contain;">
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="modern-badge badge-indigo">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #4f46e5;"></span>
                                    INNOVENTRA SUITE
                                </span>
                                <span class="text-muted fs--2 fw-semibold">v3.4</span>
                            </div>
                            <h5 class="fw-bolder mb-0 text-dark mt-1" style="font-size: 1.05rem;">
                                Enterprise <span class="text-primary">Management Portal</span>
                            </h5>
                        </div>
                    </div>

                    <!-- Tengah: Search Filter Aplikasi -->
                    <div class="flex-grow-1 px-4 mx-3 desktop-search-wrapper">
                        <div class="input-group modern-search-group px-2 py-1">
                            <span class="input-group-text bg-transparent border-0 text-muted ps-2">
                                <i class="fas fa-search fs--1"></i>
                            </span>
                            <input type="text" id="desktopSearchApp" class="form-control border-0 ps-2" placeholder="Cari aplikasi (SIMRS, Koperasi, HRIS, Keuangan)...">
                        </div>
                    </div>

                    <!-- Kanan: Profil & Setting -->
                    <div class="d-flex align-items-center gap-3">
                        <div class="text-end">
                            <h6 class="mb-0 fw-bold text-dark fs--1">{{ Auth::user()->fullname }}</h6>
                            <span class="modern-badge badge-emerald mt-1" style="font-size: 0.65rem; padding: 2px 8px;">
                                {{ strtoupper(Auth::user()->access_code) }}
                            </span>
                        </div>

                        <div class="position-relative">
                            <img class="rounded-circle" src="{{ asset('img/pp.png') }}" width="40" height="40" alt="Profile" style="border: 2px solid #e0e7ff; box-shadow: 0 2px 8px rgba(79,70,229,0.15);" />
                            <span style="position: absolute; bottom: 0; right: 0; width: 10px; height: 10px; background: #10b981; border: 2px solid #fff; border-radius: 50%;"></span>
                        </div>

                        <!-- Dropdown Action Button -->
                        <div class="dropdown" style="z-index: 999999 !important; position: relative;">
                            <button class="btn btn-dropdown-trigger" type="button" id="dropdownDesktop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end glass-dropdown-menu" aria-labelledby="dropdownDesktop">
                                <li class="dropdown-profile-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="fw-bold text-dark fs--1">{{ Auth::user()->fullname }}</div>
                                            <span class="modern-badge badge-indigo mt-1" style="font-size: 0.62rem; padding: 2px 7px;">
                                                {{ strtoupper(Auth::user()->access_code) }}
                                            </span>
                                        </div>
                                        <div class="item-icon-box m-0" style="background: #eef2ff; color: #4f46e5;">
                                            <i class="fas fa-user-shield"></i>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <button class="dropdown-item glass-dropdown-item" id="button-menu-utama">
                                        <div class="d-flex align-items-center">
                                            <span class="item-icon-box" style="background: #eef2ff; color: #4f46e5;">
                                                <i class="fas fa-home"></i>
                                            </span>
                                            <span>Halaman Utama</span>
                                        </div>
                                        <i class="fas fa-chevron-right fs--2 opacity-50"></i>
                                    </button>
                                </li>

                                <li>
                                    <button class="dropdown-item glass-dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-keuangan" id="button-proses-transaksi">
                                        <div class="d-flex align-items-center">
                                            <span class="item-icon-box" style="background: #fef3c7; color: #d97706;">
                                                <i class="fas fa-key"></i>
                                            </span>
                                            <span>Ubah Kata Sandi</span>
                                        </div>
                                        <i class="fas fa-chevron-right fs--2 opacity-50"></i>
                                    </button>
                                </li>

                                @if (Auth::user()->access_code == 'master')
                                <li>
                                    <button class="dropdown-item glass-dropdown-item" id="button-master-dashboard">
                                        <div class="d-flex align-items-center">
                                            <span class="item-icon-box" style="background: #f3e8ff; color: #7c3aed;">
                                                <i class="fas fa-sliders-h"></i>
                                            </span>
                                            <span>Master Page</span>
                                        </div>
                                        <i class="fas fa-chevron-right fs--2 opacity-50"></i>
                                    </button>
                                </li>
                                @endif

                                <li>
                                    <hr class="dropdown-divider my-2" style="border-color: #e2e8f0;">
                                </li>

                                <li>
                                    <button class="dropdown-item glass-dropdown-item text-danger" id="button-logout">
                                        <div class="d-flex align-items-center">
                                            <span class="item-icon-box" style="background: #ffe4e6; color: #e11d48;">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </span>
                                            <span>Log Out</span>
                                        </div>
                                        <i class="fas fa-chevron-right fs--2 opacity-50"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Running Text Marquee Banner -->
            <div class="marquee-box d-flex align-items-center gap-3">
                <span class="marquee-pill">
                    <i class="fas fa-bolt me-1 text-warning"></i> Info Sistem
                </span>
                <marquee class="m-0 fs--1 text-light" behavior="scroll" direction="left">
                    Selamat Datang di PT Innoventra Solusi Digital — Ekosistem Aplikasi Terpadu untuk Rumah Sakit (SIMRS &amp; Medis), Koperasi Digital, Human Resource (HRIS), serta Akuntansi &amp; Keuangan.
                </marquee>
            </div>

            <!-- Grid Card Features Desktop -->
            <div class="menu-grid-desktop" id="desktopAppGrid">
                @foreach ($menu as $menus)
                @php
                $code = strtolower($menus->menu_super_code . ' ' . $menus->menu_super_name);

                // Default: Enterprise Indigo
                $iconClass = 'fa-layer-group';
                $iconBg = '#eef2ff';
                $iconColor = '#4f46e5';
                $accentHex = '#4f46e5';

                if(str_contains($code, 'medic') || str_contains($code, 'health') || str_contains($code, 'rs') || str_contains($code, 'klinik')) {
                // Rumah Sakit / Medis (Sky Blue)
                $iconClass = 'fa-hospital-user';
                $iconBg = '#e0f2fe';
                $iconColor = '#0284c7';
                $accentHex = '#0284c7';
                } elseif(str_contains($code, 'koper') || str_contains($code, 'coop') || str_contains($code, 'simpan')) {
                // Koperasi Digital (Emerald)
                $iconClass = 'fa-hand-holding-usd';
                $iconBg = '#d1fae5';
                $iconColor = '#059669';
                $accentHex = '#059669';
                } elseif(str_contains($code, 'hr') || str_contains($code, 'sdm') || str_contains($code, 'pegawai') || str_contains($code, 'karyawan') || str_contains($code, 'payroll')) {
                // Human Resource (Violet)
                $iconClass = 'fa-users-cog';
                $iconBg = '#ede9fe';
                $iconColor = '#7c3aed';
                $accentHex = '#7c3aed';
                } elseif(str_contains($code, 'account') || str_contains($code, 'keuangan') || str_contains($code, 'akuntan') || str_contains($code, 'finance')) {
                // Akuntansi & Keuangan (Amber)
                $iconClass = 'fa-chart-line';
                $iconBg = '#fef3c7';
                $iconColor = '#d97706';
                $accentHex = '#d97706';
                } elseif(str_contains($code, 'inventar') || str_contains($code, 'stok') || str_contains($code, 'logis') || str_contains($code, 'gudang')) {
                // Inventaris & Logistik (Teal)
                $iconClass = 'fa-boxes';
                $iconBg = '#ccfbf1';
                $iconColor = '#0d9488';
                $accentHex = '#0d9488';
                }
                @endphp

                <div class="menu-card-desktop item-card-filter" id="menu" data-code="{{ $menus->menu_super_code }}" style="--card-accent: {{ $accentHex }};">
                    <div class="card-content-wrapper">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="menu-icon-wrapper" style="background-color: {{ $iconBg }}; color: {{ $iconColor }};">
                                <i class="fas {{ $iconClass }}"></i>
                            </div>
                            <span class="card-arrow-hint">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>

                        <div class="card-text">
                            <h6 class="fw-bold mb-1 filter-title">{{ $menus->menu_super_name }}</h6>
                            <p class="mb-0 text-truncate filter-desc" title="{{ $menus->menu_super_desc }}">{{ $menus->menu_super_desc }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>

        <footer class="desktop-footer text-center fs--2">
            <p class="mb-0">© <span id="yr-desktop">2026</span> <strong>PT Innoventra Solusi Digital</strong> — Enterprise Management Suite v3.4.0</p>
        </footer>
    </div>


    <!-- ========================================================= -->
    <!-- MOBILE MODE CONTAINER                                     -->
    <!-- ========================================================= -->
    <div class="d-lg-none">
        <div class="mobile-header-bar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2.5">
                <div class="position-relative">
                    <img src="{{ asset('img/pp.png') }}" width="38" height="38" class="rounded-circle bg-white" style="border: 2px solid #e0e7ff;" />
                    <span style="position: absolute; bottom: 0; right: 0; width: 9px; height: 9px; background: #10b981; border: 1.5px solid #fff; border-radius: 50%;"></span>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold text-dark fs--1">{{ Auth::user()->fullname }}</h6>
                    <span class="modern-badge badge-indigo" style="font-size: 0.6rem; padding: 1px 6px;">{{ strtoupper(Auth::user()->access_code) }}</span>
                </div>
            </div>

            <!-- Dropdown Action Button Mobile -->
            <div class="dropdown">
                <button class="btn btn-mobile-trigger" type="button" id="dropdownMobile" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end glass-dropdown-mobile" aria-labelledby="dropdownMobile">
                    <li>
                        <button class="dropdown-item mobile-dropdown-item" id="button-menu-utama">
                            <div class="d-flex align-items-center">
                                <span class="item-icon-box" style="background: #eef2ff; color: #4f46e5;"><i class="fas fa-home"></i></span>
                                <span>Halaman Utama</span>
                            </div>
                            <i class="fas fa-chevron-right fs--2 opacity-50"></i>
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item mobile-dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-keuangan" id="button-proses-transaksi">
                            <div class="d-flex align-items-center">
                                <span class="item-icon-box" style="background: #fef3c7; color: #d97706;"><i class="fas fa-key"></i></span>
                                <span>Ubah Password</span>
                            </div>
                            <i class="fas fa-chevron-right fs--2 opacity-50"></i>
                        </button>
                    </li>
                    @if (Auth::user()->access_code == 'master')
                    <li>
                        <button class="dropdown-item mobile-dropdown-item" id="button-master-dashboard">
                            <div class="d-flex align-items-center">
                                <span class="item-icon-box" style="background: #f3e8ff; color: #7c3aed;"><i class="fas fa-sliders-h"></i></span>
                                <span>Master Page</span>
                            </div>
                            <i class="fas fa-chevron-right fs--2 opacity-50"></i>
                        </button>
                    </li>
                    @endif
                    <li>
                        <hr class="dropdown-divider my-1" style="border-color: #e2e8f0;">
                    </li>
                    <li>
                        <button class="dropdown-item mobile-dropdown-item text-danger" id="button-logout">
                            <div class="d-flex align-items-center">
                                <span class="item-icon-box" style="background: #ffe4e6; color: #e11d48;"><i class="fas fa-sign-out-alt"></i></span>
                                <span>Log Out</span>
                            </div>
                            <i class="fas fa-chevron-right fs--2 opacity-50"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Mobile Hero Banner -->
        <div class="android-widget-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span style="background: rgba(99, 102, 241, 0.3); border: 1px solid rgba(165, 180, 252, 0.4); color: #e0e7ff; font-size: 0.65rem; font-weight: 700; padding: 3px 10px; border-radius: 99px;">
                    ● INNOVENTRA SUITE v3.4
                </span>
                <i class="fas fa-layer-group text-indigo-200 fs-5" style="color: #a5b4fc;"></i>
            </div>
            <h6 class="fw-bold mb-1 text-white" style="font-size: 1.05rem;">Portal Aplikasi Terpadu</h6>
            <p class="fs--2 mb-0" style="color: #cbd5e1;">Pilih modul Rumah Sakit, Koperasi, HRIS, atau Akuntansi di bawah untuk mulai bekerja.</p>
        </div>

        <!-- Mobile App Grid -->
        <div class="android-app-grid">
            @foreach ($menu as $menus)
            @php
            $code = strtolower($menus->menu_super_code . ' ' . $menus->menu_super_name);
            $iconClass = 'fa-layer-group';
            $iconBg = '#eef2ff';
            $iconColor = '#4f46e5';

            if(str_contains($code, 'medic') || str_contains($code, 'health') || str_contains($code, 'rs') || str_contains($code, 'klinik')) {
            $iconClass = 'fa-hospital-user';
            $iconBg = '#e0f2fe';
            $iconColor = '#0284c7';
            } elseif(str_contains($code, 'koper') || str_contains($code, 'coop') || str_contains($code, 'simpan')) {
            $iconClass = 'fa-hand-holding-usd';
            $iconBg = '#d1fae5';
            $iconColor = '#059669';
            } elseif(str_contains($code, 'hr') || str_contains($code, 'sdm') || str_contains($code, 'pegawai') || str_contains($code, 'karyawan') || str_contains($code, 'payroll')) {
            $iconClass = 'fa-users-cog';
            $iconBg = '#ede9fe';
            $iconColor = '#7c3aed';
            } elseif(str_contains($code, 'account') || str_contains($code, 'keuangan') || str_contains($code, 'akuntan') || str_contains($code, 'finance')) {
            $iconClass = 'fa-chart-line';
            $iconBg = '#fef3c7';
            $iconColor = '#d97706';
            } elseif(str_contains($code, 'inventar') || str_contains($code, 'stok') || str_contains($code, 'logis') || str_contains($code, 'gudang')) {
            $iconClass = 'fa-boxes';
            $iconBg = '#ccfbf1';
            $iconColor = '#0d9488';
            }
            @endphp

            <div class="app-item-mobile" id="menu" data-code="{{ $menus->menu_super_code }}">
                <div class="app-icon-wrapper" style="background-color: {{ $iconBg }}; color: {{ $iconColor }};">
                    <i class="fas {{ $iconClass }}"></i>
                </div>
                <span class="app-label-mobile">{{ $menus->menu_super_name }}</span>
            </div>
            @endforeach
        </div>

        <!-- Mobile Bottom Floating Navigation -->
        <div class="android-bottom-nav">
            <a class="android-nav-btn active" href="#">
                <div class="nav-icon-wrapper nav-icon-home"><i class="fas fa-th-large"></i></div>
                <span>Aplikasi</span>
            </a>
            <a class="android-nav-btn" href="#" data-bs-toggle="modal" data-bs-target="#modal-keuangan">
                <div class="nav-icon-wrapper nav-icon-reset"><i class="fas fa-key"></i></div>
                <span>Sandi</span>
            </a>
            <a class="android-nav-btn" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <div class="nav-icon-wrapper nav-icon-info"><i class="fas fa-info-circle"></i></div>
                <span>Info</span>
            </a>
            <a class="android-nav-btn" id="button-logout" href="#">
                <div class="nav-icon-wrapper nav-icon-logout"><i class="fas fa-power-off"></i></div>
                <span class="text-danger">Keluar</span>
            </a>
        </div>
    </div>

    <!-- ========================================================= -->
    <!-- MODALS                                                    -->
    <!-- ========================================================= -->
    <!-- Info Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modern-modal-content">
                <div class="modal-header bg-white border-bottom" style="border-color: #e2e8f0 !important;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="item-icon-box m-0" style="background: #eef2ff; color: #4f46e5;">
                            <i class="fas fa-info-circle"></i>
                        </span>
                        <h6 class="modal-title fw-bold text-dark mb-0" id="staticBackdropLabel">Informasi Sistem</h6>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-white">
                    <p class="text-slate-600 fs--1 mb-0" style="line-height: 1.6;">
                        <strong>PT Innoventra Solusi Digital</strong> — Platform manajemen terpadu untuk pengelolaan operasional Rumah Sakit (SIMRS &amp; PACS), Koperasi Digital, Human Resource (HRIS), serta Akuntansi &amp; Keuangan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Password OTP Modal -->
    <div class="modal fade" id="modal-keuangan" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-sm-custom">
            <div class="modal-content modern-modal-content glass-reset-modal">
                <button type="button" class="btn-close btn-close-custom" data-bs-dismiss="modal" aria-label="Close"></button>

                <!-- Step 1 -->
                <div id="reset-step-1" class="reset-step-container">
                    <div class="text-center mb-4">
                        <div class="reset-icon-badge mx-auto mb-3" style="background: #eef2ff; color: #4f46e5;">
                            <i class="fas fa-envelope-open-text fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Ubah Kata Sandi</h5>
                        <p class="text-muted fs--2 mb-0">Masukkan email terdaftar untuk menerima kode verifikasi OTP.</p>
                    </div>
                    <form id="form-request-otp">
                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold fs--2">Email Terdaftar</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-at"></i></span>
                                <input type="email" class="form-control custom-input" id="reset-email" placeholder="nama@perusahaan.com" required>
                            </div>
                        </div>
                        <button type="submit" class="btn modern-btn btn-primary-gradient w-100 py-2.5" id="btn-send-otp">
                            <span>Kirim Kode Verifikasi</span> <i class="fas fa-arrow-right ms-2 fs--2"></i>
                        </button>
                    </form>
                </div>

                <!-- Step 2 -->
                <div id="reset-step-2" class="reset-step-container d-none">
                    <div class="text-center mb-3">
                        <div class="reset-icon-badge mx-auto mb-2" style="background: #e0f2fe; color: #0284c7;">
                            <i class="fas fa-shield-alt fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Verifikasi OTP</h5>
                        <p class="text-muted fs--2 mb-0">Masukkan 6 digit kode OTP yang dikirim ke email Anda.</p>
                    </div>
                    <form id="form-verify-otp">
                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold fs--2 text-center d-block">Kode Verifikasi (OTP)</label>
                            <div class="d-flex justify-content-center gap-1.5 otp-group mb-2">
                                <input type="text" maxlength="1" class="form-control otp-input text-center px-1" required>
                                <input type="text" maxlength="1" class="form-control otp-input text-center px-1" required>
                                <input type="text" maxlength="1" class="form-control otp-input text-center px-1" required>
                                <input type="text" maxlength="1" class="form-control otp-input text-center px-1" required>
                                <input type="text" maxlength="1" class="form-control otp-input text-center px-1" required>
                                <input type="text" maxlength="1" class="form-control otp-input text-center px-1" required>
                            </div>
                            <div class="text-center">
                                <small class="text-muted fs--2">Belum terima kode? <a href="#" id="btn-resend-otp" class="text-primary fw-semibold text-decoration-none">Kirim Ulang</a></small>
                            </div>
                        </div>
                        <button type="submit" class="btn modern-btn btn-primary-gradient w-100 py-2.5 mt-2" id="btn-check-otp">
                            <i class="fas fa-check-circle me-1"></i> Verifikasi Kode OTP
                        </button>
                    </form>
                </div>

                <!-- Step 3 -->
                <div id="reset-step-3" class="reset-step-container d-none">
                    <div class="text-center mb-3">
                        <div class="reset-icon-badge mx-auto mb-2" style="background: #d1fae5; color: #059669;">
                            <i class="fas fa-lock fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Kata Sandi Baru</h5>
                        <p class="text-muted fs--2 mb-0">Buat kata sandi baru yang aman untuk akun Anda.</p>
                    </div>
                    <form id="form-reset-password">
                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold fs--2">Kata Sandi Baru</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control custom-input" id="new-password" placeholder="Minimal 6 karakter" minlength="6" required>
                                <button class="btn bg-light border text-muted btn-toggle-pass" type="button" style="border-color: #cbd5e1 !important; border-radius: 0 10px 10px 0 !important;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold fs--2">Konfirmasi Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control custom-input" id="confirm-password" placeholder="Ulangi kata sandi baru" minlength="6" required>
                            </div>
                        </div>
                        <button type="submit" class="btn modern-btn btn-success-gradient w-100 py-2.5 mt-2" id="btn-save-password">
                            <i class="fas fa-save me-1"></i> Simpan Kata Sandi Baru
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScripts -->
    <script src="{{ asset('vendors/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('asset/js/theme.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const yrEl = document.getElementById('yr-desktop');
            if (yrEl) yrEl.textContent = new Date().getFullYear();

            const searchInput = document.getElementById('desktopSearchApp');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const filter = this.value.toLowerCase();
                    const cards = document.querySelectorAll('.item-card-filter');
                    cards.forEach(card => {
                        const title = card.querySelector('.filter-title').innerText.toLowerCase();
                        const desc = card.querySelector('.filter-desc').innerText.toLowerCase();
                        if (title.includes(filter) || desc.includes(filter)) {
                            card.style.display = '';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }

            const step1 = document.getElementById("reset-step-1");
            const step2 = document.getElementById("reset-step-2");
            const step3 = document.getElementById("reset-step-3");
            const formReq = document.getElementById("form-request-otp");
            const formVerifyOtp = document.getElementById("form-verify-otp");
            const formResetPass = document.getElementById("form-reset-password");
            const otpInputs = document.querySelectorAll(".otp-input");
            let userEmail = "";
            let verifiedOtp = "";

            otpInputs.forEach((input, index) => {
                input.addEventListener("input", (e) => {
                    if (e.target.value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });
                input.addEventListener("keydown", (e) => {
                    if (e.key === "Backspace" && !e.target.value && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
            });

            document.querySelector(".btn-toggle-pass").addEventListener("click", function() {
                const passInput = document.getElementById("new-password");
                const icon = this.querySelector("i");
                if (passInput.type === "password") {
                    passInput.type = "text";
                    icon.classList.replace("fa-eye", "fa-eye-slash");
                } else {
                    passInput.type = "password";
                    icon.classList.replace("fa-eye-slash", "fa-eye");
                }
            });

            formReq.addEventListener("submit", function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                const emailInput = document.getElementById("reset-email");
                userEmail = emailInput.value;
                const btn = $("#btn-send-otp");
                btn.prop("disabled", true).html('<i class="fas fa-spinner fa-spin me-1"></i> Memeriksa Email...');
                $.ajax({
                    url: "{{ route('verifikasi_send_email') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: userEmail
                    },
                    dataType: "json"
                }).done(function(res) {
                    btn.prop("disabled", false).html('<span>Kirim Kode Verifikasi</span> <i class="fas fa-arrow-right ms-2 fs--2"></i>');
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Email Ditemukan!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        step1.classList.add("d-none");
                        step2.classList.remove("d-none");
                        step3.classList.add("d-none");
                        otpInputs[0].focus();
                    } else {
                        step1.classList.remove("d-none");
                        step2.classList.add("d-none");
                        step3.classList.add("d-none");
                        Swal.fire({
                            icon: 'error',
                            title: 'Email Tidak Ditemukan!',
                            text: res.message || 'Silakan periksa kembali email yang Anda masukkan.',
                            confirmButtonColor: '#4f46e5'
                        }).then(() => {
                            emailInput.focus();
                            emailInput.select();
                        });
                    }
                }).fail(function(xhr) {
                    btn.prop("disabled", false).html('<span>Kirim Kode Verifikasi</span> <i class="fas fa-arrow-right ms-2 fs--2"></i>');
                    step1.classList.remove("d-none");
                    step2.classList.add("d-none");
                    step3.classList.add("d-none");
                    const res = xhr.responseJSON;
                    const errorMsg = (res && res.message) ? res.message : "Email tidak terdaftar atau terjadi kesalahan server.";
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memeriksa Email',
                        text: errorMsg,
                        confirmButtonColor: '#4f46e5'
                    }).then(() => {
                        emailInput.focus();
                        emailInput.select();
                    });
                });
            });

            document.getElementById("btn-resend-otp").addEventListener("click", function(e) {
                e.preventDefault();
                formReq.dispatchEvent(new Event('submit'));
            });

            formVerifyOtp.addEventListener("submit", function(e) {
                e.preventDefault();
                let otpCode = "";
                otpInputs.forEach(input => otpCode += input.value);
                const btn = $("#btn-check-otp");
                if (otpCode.length < 6) {
                    Swal.fire({
                        icon: "warning",
                        title: "Peringatan",
                        text: "Harap masukkan 6 digit kode OTP secara lengkap!",
                        confirmButtonColor: '#4f46e5'
                    });
                    return;
                }
                btn.prop("disabled", true).html('<i class="fas fa-spinner fa-spin me-1"></i> Memverifikasi...');
                $.ajax({
                    url: "{{ route('verifikasi_otp_check') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: userEmail,
                        otp: otpCode
                    },
                    dataType: "json"
                }).done(function(res) {
                    btn.prop("disabled", false).html('<i class="fas fa-check-circle me-1"></i> Verifikasi Kode OTP');
                    if (res.status === 'success') {
                        verifiedOtp = otpCode;
                        Swal.fire({
                            icon: 'success',
                            title: 'OTP Valid!',
                            text: 'Silakan masukkan kata sandi baru Anda.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        step2.classList.add("d-none");
                        step3.classList.remove("d-none");
                        document.getElementById("new-password").focus();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "OTP Salah",
                            text: res.message,
                            confirmButtonColor: '#4f46e5'
                        });
                    }
                }).fail(function(xhr) {
                    btn.prop("disabled", false).html('<i class="fas fa-check-circle me-1"></i> Verifikasi Kode OTP');
                    const res = xhr.responseJSON;
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res && res.message ? res.message : "Gagal memverifikasi OTP.",
                        confirmButtonColor: '#4f46e5'
                    });
                });
            });

            formResetPass.addEventListener("submit", function(e) {
                e.preventDefault();
                const password = document.getElementById("new-password").value;
                const confirmPassword = document.getElementById("confirm-password").value;
                const btn = $("#btn-save-password");
                if (password !== confirmPassword) {
                    Swal.fire({
                        icon: "warning",
                        title: "Perhatian",
                        text: "Konfirmasi kata sandi tidak cocok!",
                        confirmButtonColor: '#4f46e5'
                    });
                    return;
                }
                btn.prop("disabled", true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');
                $.ajax({
                    url: "{{ route('verifikasi_reset_pass') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: userEmail,
                        otp: verifiedOtp,
                        password: password,
                        password_confirmation: confirmPassword
                    },
                    dataType: "json"
                }).done(function(res) {
                    btn.prop("disabled", false).html('<i class="fas fa-save me-1"></i> Simpan Kata Sandi Baru');
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                            confirmButtonColor: '#4f46e5'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal",
                            text: res.message,
                            confirmButtonColor: '#4f46e5'
                        });
                    }
                }).fail(function(xhr) {
                    btn.prop("disabled", false).html('<i class="fas fa-save me-1"></i> Simpan Kata Sandi Baru');
                    const res = xhr.responseJSON;
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res && res.message ? res.message : "Gagal mengubah password.",
                        confirmButtonColor: '#4f46e5'
                    });
                });
            });
        });

        $(document).on("click", "#menu", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            Swal.fire({
                title: "Memuat Aplikasi",
                html: "Menyiapkan ruang kerja Anda...",
                timer: 400,
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
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
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Gagal memuat modul aplikasi.",
                            confirmButtonColor: '#4f46e5'
                        });
                    });
                }
            });
        });

        $(document).on("click", "#button-logout", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Konfirmasi Keluar",
                text: "Apakah Anda yakin ingin mengakhiri sesi ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#4f46e5",
                cancelButtonColor: "#64748b",
                confirmButtonText: "Ya, Log Out",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('{{ route("logout") }}');
                }
            });
        });

        $(document).on("click", "#button-master-dashboard", function(e) {
            e.preventDefault();
            window.location.href = "{{ route('master_dashboard') }}";
        });
        $(document).on("click", "#button-menu-utama", function(e) {
            e.preventDefault();
            window.location.href = "{{ route('/') }}";
        });
    </script>
</body>

</html>
