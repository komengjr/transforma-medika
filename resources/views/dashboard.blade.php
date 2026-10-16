<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- Document Title -->
    <title>{{ env('APP_NAME')}} | Management System</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">
    <link rel="manifest" href="../../../asset/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="{{ asset('img/favicon.png') }}">
    <meta name="theme-color" content="#0f172a">
    <script src="{{ asset('asset/js/config.js') }}"></script>

    <!-- Stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
        /* GLOBAL (DEFAULT UNTUK MOBILE) - TEMA GELAP CITY           */
        /* ========================================================= */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            margin: 0;
            padding: 0;
            color: #1e293b;
            background-color: #0b0f19;
            position: relative;
            min-height: 100vh;
        }

        /* Latar Belakang Image Khusus Mobile */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: url('https://images.unsplash.com/photo-1519501025264-65ba15a82390?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(8px) brightness(0.75);
            transform: scale(1.05);
            z-index: -2;
        }

        body::after {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.45) 0%, rgba(2, 132, 199, 0.25) 100%);
            z-index: -1;
        }

        input,
        button,
        select,
        textarea,
        .dropdown-menu,
        .modal,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span,
        a,
        badge {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        /* ========================================================= */
        /* MODE DESKTOP OPTIMIZED: LEBIH RINGAN & GRADASI WARNA      */
        /* ========================================================= */
        @media (min-width: 992px) {

            html,
            body {
                height: 100vh !important;
                max-height: 100vh !important;
                overflow: hidden !important;
                /* Background Pure CSS Gradient agar sangat ringan */
                background: linear-gradient(135deg, #f1f5f9 0%, #e0f2fe 100%) !important;
            }

            /* Mematikan background gambar berat di mode desktop */
            body::before,
            body::after {
                display: none !important;
            }

            .main-desktop-wrapper {
                height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 1.5rem 3rem;
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

            /* Header Desktop Card */
            .glass-header-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(15px);
                border-radius: 16px;
                border: 1px solid rgba(255, 255, 255, 1);
                box-shadow: 0 4px 15px rgba(2, 132, 199, 0.05);
                padding: 0.6rem 1.2rem;
                margin-bottom: 1rem;
                position: relative;
                z-index: 1050 !important;
                flex-shrink: 0;
            }

            .desktop-search-wrapper {
                max-width: 450px;
            }

            .desktop-search-wrapper input:focus {
                outline: none;
                background: #fff;
            }

            .dropdown-menu-custom {
                z-index: 999999 !important;
                position: absolute !important;
                border-radius: 14px !important;
                padding: 0.5rem !important;
                background-color: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15) !important;
            }

            .marquee-box {
                background: #ffffff;
                border-radius: 10px;
                padding: 5px 14px;
                color: #0284c7;
                margin-bottom: 1rem;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
                border: 1px solid #e2e8f0;
                flex-shrink: 0;
            }

            /* Container Grid App Desktop dengan Support Scroll & Ukuran Fixed */
            .menu-grid-desktop {
                flex: 1;
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                grid-auto-rows: min-content;
                /* Memastikan baris tidak memanjang memenuhi kontainer kosong */
                gap: 1rem;
                align-items: stretch;
                align-content: start;
                /* Mencegah card tertarik vertikal jika hanya 1 aplikasi */
                min-height: 0;
                overflow-y: auto;
                /* Aktifkan scroll ke bawah jika card melebihi tinggi layar */
                padding-bottom: 1rem;
                padding-right: 0.5rem;
            }

            /* Scrollbar styling agar rapi */
            .menu-grid-desktop::-webkit-scrollbar {
                width: 6px;
            }

            .menu-grid-desktop::-webkit-scrollbar-track {
                background: transparent;
            }

            .menu-grid-desktop::-webkit-scrollbar-thumb {
                background-color: rgba(2, 132, 199, 0.2);
                border-radius: 10px;
            }

            /* ----------------------------------------------------- */
            /* STYLING CARD OPTIMIZED & RINGAN (TanPA Gambar Besar)  */
            /* ----------------------------------------------------- */
            .menu-card-desktop {
                background: #ffffff;
                border-radius: 16px;
                position: relative;
                min-height: 140px;
                cursor: pointer;
                transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
                overflow: hidden;
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: 1.2rem;
                z-index: 1;
            }

            /* Background Gradasi Transparan di dalam Card */
            .card-gradient-bg {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                opacity: 0.05;
                transition: opacity 0.3s ease;
                z-index: -1;
            }

            .menu-card-desktop:hover {
                transform: translateY(-6px);
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            }

            .menu-card-desktop:hover .card-gradient-bg {
                opacity: 0.15;
            }

            /* Container Isi Card */
            .card-content-wrapper {
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            /* Icon Card Besar dengan Warna Gradien */
            .menu-icon-wrapper {
                width: 48px;
                height: 48px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.4rem;
                color: #ffffff;
                margin-bottom: 0.8rem;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease;
            }

            .menu-card-desktop:hover .menu-icon-wrapper {
                transform: scale(1.1);
            }

            .card-text h6 {
                color: #0f172a;
                font-size: 0.9rem;
            }

            .card-text p {
                color: #64748b;
                line-height: 1.3;
            }

            .desktop-footer {
                padding: 0.8rem 0 0 0;
                text-align: center;
                color: #475569 !important;
                flex-shrink: 0;
                font-weight: 600;
            }
        }

        /* ========================================================= */
        /* MODE MOBILE: HOME SCREEN ANDROID NATIVE LAUNCHER (TETAP)  */
        /* ========================================================= */
        @media (max-width: 991.98px) {
            body {
                padding-bottom: 85px;
            }

            .mobile-header-bar {
                background: rgba(255, 255, 255, 0.92);
                backdrop-filter: blur(20px);
                padding: 0.8rem 1rem;
                position: sticky;
                top: 0;
                z-index: 10000;
                border-bottom: 1px solid #e2e8f0;
            }

            .android-widget-card {
                background: linear-gradient(135deg, rgba(2, 132, 199, 0.9), rgba(3, 105, 161, 0.9));
                backdrop-filter: blur(12px);
                color: #ffffff;
                border-radius: 20px;
                padding: 1.1rem;
                margin: 0.8rem;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .android-app-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 1rem 0.4rem;
                padding: 0.5rem 0.8rem;
            }

            .app-item-mobile {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-decoration: none;
                cursor: pointer;
            }

            .app-icon-wrapper {
                width: 56px;
                height: 56px;
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.35rem;
                color: #ffffff;
                box-shadow: 0 5px 12px rgba(0, 0, 0, 0.25);
                margin-bottom: 5px;
                transition: transform 0.15s ease;
            }

            .app-item-mobile:active .app-icon-wrapper {
                transform: scale(0.88);
            }

            .app-label-mobile {
                font-size: 0.68rem;
                font-weight: 600;
                color: #ffffff;
                text-shadow: 0 1px 3px rgba(0, 0, 0, 0.8);
                text-align: center;
                line-height: 1.2;
                max-width: 72px;
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
                width: 90%;
                max-width: 400px;
                height: 70px;
                background: rgba(255, 255, 255, 0.88);
                backdrop-filter: blur(20px) saturate(180%);
                -webkit-backdrop-filter: blur(20px) saturate(180%);
                border-radius: 35px;
                display: flex;
                align-items: center;
                justify-content: space-around;
                padding: 0 10px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25), 0 5px 15px rgba(0, 0, 0, 0.08);
                border: 1px solid rgba(255, 255, 255, 0.8);
                z-index: 10000;
            }

            .android-nav-btn {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                font-size: 0.68rem;
                font-weight: 700;
                color: #64748b;
                transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                position: relative;
                padding: 4px 10px;
                border-radius: 20px;
            }

            .nav-icon-wrapper {
                width: 38px;
                height: 38px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.15rem;
                margin-bottom: 2px;
                transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            }

            .nav-icon-home {
                background: linear-gradient(135deg, #3b82f6, #1d4ed8);
                color: #fff;
            }

            .nav-icon-reset {
                background: linear-gradient(135deg, #f59e0b, #d97706);
                color: #fff;
            }

            .nav-icon-info {
                background: linear-gradient(135deg, #06b6d4, #0891b2);
                color: #fff;
            }

            .nav-icon-logout {
                background: linear-gradient(135deg, #ef4444, #dc2626);
                color: #fff;
            }

            .android-nav-btn.active .nav-icon-wrapper {
                transform: translateY(-6px) scale(1.12);
                box-shadow: 0 8px 18px rgba(2, 132, 199, 0.35);
            }

            .android-nav-btn.active {
                color: #0284c7;
            }

            .android-nav-btn:active .nav-icon-wrapper {
                transform: scale(0.88);
            }

            .android-nav-btn i {
                font-size: 1.15rem;
                margin-bottom: 2px;
            }
        }

        /* Custom Stylish Dropdown & Modals */
        .glass-dropdown-menu {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.8) !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12), 0 5px 15px rgba(0, 0, 0, 0.05) !important;
            border-radius: 18px !important;
            padding: 0.6rem !important;
            min-width: 230px !important;
            animation: fadeInDropdown 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeInDropdown {
            from {
                opacity: 0;
                transform: translateY(-8px) scale(0.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .dropdown-profile-header {
            background: linear-gradient(135deg, rgba(2, 132, 199, 0.08), rgba(59, 130, 246, 0.05));
            border-radius: 12px;
            padding: 0.65rem 0.8rem;
            margin-bottom: 0.4rem;
        }

        .glass-dropdown-item {
            border-radius: 10px !important;
            padding: 0.55rem 0.75rem !important;
            font-size: 0.85rem !important;
            font-weight: 600 !important;
            color: #334155 !important;
            transition: all 0.2s ease !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }

        .glass-dropdown-item:hover {
            background-color: #f1f5f9 !important;
            color: #0284c7 !important;
            transform: translateX(3px);
        }

        .glass-dropdown-item.text-danger:hover {
            background-color: #fef2f2 !important;
            color: #ef4444 !important;
        }

        .item-icon-box {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            margin-right: 10px;
            transition: transform 0.2s ease;
        }

        .glass-dropdown-item:hover .item-icon-box {
            transform: scale(1.1);
        }

        .item-arrow {
            font-size: 0.65rem;
            opacity: 0;
            transform: translateX(-5px);
            transition: all 0.2s ease;
        }

        .glass-dropdown-item:hover .item-arrow {
            opacity: 0.6;
            transform: translateX(0);
        }

        .btn-dropdown-trigger {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50% !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            transition: all 0.2s ease !important;
        }

        .btn-dropdown-trigger:hover,
        .btn-dropdown-trigger[aria-expanded="true"] {
            background: #0284c7 !important;
            color: #ffffff !important;
            border-color: #0284c7 !important;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3) !important;
        }

        .glass-dropdown-mobile {
            background: rgba(255, 255, 255, 0.96) !important;
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.8) !important;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.15) !important;
            border-radius: 16px !important;
            padding: 0.5rem !important;
            min-width: 210px !important;
            margin-top: 8px !important;
            animation: fadeInMobileDropdown 0.2s ease-out forwards;
        }

        @keyframes fadeInMobileDropdown {
            from {
                opacity: 0;
                transform: translateY(-6px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .mobile-dropdown-item {
            border-radius: 10px !important;
            padding: 0.6rem 0.75rem !important;
            font-size: 0.82rem !important;
            font-weight: 600 !important;
            color: #334155 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            transition: background-color 0.15s ease, transform 0.1s ease !important;
        }

        .mobile-dropdown-item:active {
            background-color: #f1f5f9 !important;
            transform: scale(0.98);
        }

        .mobile-dropdown-item.text-danger:active {
            background-color: #fef2f2 !important;
        }

        .mobile-icon-box {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            margin-right: 10px;
        }

        .btn-mobile-trigger {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50% !important;
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            transition: all 0.2s ease !important;
        }

        .btn-mobile-trigger:active,
        .btn-mobile-trigger[aria-expanded="true"] {
            background: #0284c7 !important;
            color: #ffffff !important;
            border-color: #0284c7 !important;
        }

        .modal-sm-custom {
            max-width: 380px;
        }

        .glass-reset-modal {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(25px) saturate(200%);
            -webkit-backdrop-filter: blur(25px) saturate(200%);
            border-radius: 24px !important;
            padding: 1.8rem;
            position: relative;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .btn-close-custom {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 0.8rem;
            z-index: 10;
        }

        .reset-icon-badge {
            width: 60px;
            height: 60px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-input {
            border-radius: 0 12px 12px 0 !important;
            font-size: 0.85rem;
            padding: 0.6rem 0.75rem;
            background: #f8fafc;
        }

        .custom-input:focus {
            box-shadow: none;
            border-color: #0284c7;
            background: #fff;
        }

        .input-group-text {
            border-radius: 12px 0 0 12px !important;
            background: #f8fafc !important;
        }

        .otp-input {
            width: 48px;
            height: 52px;
            font-size: 1.4rem;
            font-weight: 700;
            border-radius: 12px;
            background: #f1f5f9;
            border: 2px solid transparent;
            color: #0f172a;
            transition: all 0.2s ease;
        }

        .otp-input:focus {
            background: #fff;
            border-color: #0284c7;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.15);
            outline: none;
        }

        .btn-primary-gradient {
            background: linear-gradient(135deg, #0284c7, #2563eb);
            border: none;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            transition: all 0.2s ease;
        }

        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
        }

        .btn-success-gradient {
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            transition: all 0.2s ease;
        }

        .btn-success-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
        }
    </style>
</head>

<body>
    <!-- DESKTOP MODE CONTAINER -->
    <div class="main-desktop-wrapper d-none d-lg-flex">
        <div class="desktop-content-container">

            <!-- Desktop Header Card -->
            <div class="glass-header-card">
                <div class="d-flex align-items-center justify-content-between">

                    <!-- Kiri: Logo -->
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 bg-white rounded-3 border shadow-sm">
                            <img src="{{asset('img/logo-pt.png')}}" alt="Logo" width="85" height="36">
                        </div>
                        <div>
                            <span class="badge bg-primary rounded-pill px-2 py-1 fs--2">Innoventra System</span>
                            <h5 class="fw-bold mb-0 text-dark">
                                Ver.3 <span class="text-primary">Dashboard</span>
                            </h5>
                        </div>
                    </div>

                    <!-- Tengah: Search Filter Aplikasi -->
                    <div class="flex-grow-1 px-4 mx-3 desktop-search-wrapper">
                        <div class="input-group shadow-sm bg-white rounded-pill overflow-hidden border">
                            <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" id="desktopSearchApp" class="form-control border-0 ps-2" placeholder="Cari modul atau aplikasi..." style="box-shadow: none;">
                        </div>
                    </div>

                    <!-- Kanan: Profil & Setting -->
                    <div class="d-flex align-items-center gap-3">
                        <div class="text-end">
                            <h6 class="mb-0 fw-bold text-dark fs--1">{{Auth::user()->fullname}}</h6>
                            <span class="badge bg-light text-dark border fs--2">{{ strtoupper(Auth::user()->access_code) }}</span>
                        </div>

                        <div class="position-relative">
                            <img class="rounded-circle border border-2 border-primary" src="{{asset('img/pp.png')}}" width="38" height="38" alt="Profile" />
                        </div>

                        <!-- Dropdown Action Button -->
                        <div class="dropdown" style="z-index: 999999 !important; position: relative;">
                            <button class="btn btn-dropdown-trigger shadow-sm" type="button" id="dropdownDesktop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end glass-dropdown-menu border-0 shadow-lg" aria-labelledby="dropdownDesktop">
                                <li class="dropdown-profile-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <div class="fw-bold text-dark fs--1">{{ Auth::user()->fullname }}</div>
                                            <small class="text-muted fs--2" style="font-size: 0.7rem;">
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">
                                                    {{ strtoupper(Auth::user()->access_code) }}
                                                </span>
                                            </small>
                                        </div>
                                        <i class="fas fa-user-shield text-primary opacity-50 fs-5"></i>
                                    </div>
                                </li>

                                <li>
                                    <button class="dropdown-item glass-dropdown-item" id="button-menu-utama">
                                        <div class="d-flex align-items-center">
                                            <span class="item-icon-box bg-primary-subtle text-primary">
                                                <i class="fab fa-dashcube"></i>
                                            </span>
                                            <span>Menu Utama</span>
                                        </div>
                                        <i class="fas fa-chevron-right item-arrow"></i>
                                    </button>
                                </li>

                                <li>
                                    <button class="dropdown-item glass-dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-keuangan" id="button-proses-transaksi">
                                        <div class="d-flex align-items-center">
                                            <span class="item-icon-box bg-warning-subtle text-warning">
                                                <i class="fas fa-key"></i>
                                            </span>
                                            <span>Ubah Kata Sandi</span>
                                        </div>
                                        <i class="fas fa-chevron-right item-arrow"></i>
                                    </button>
                                </li>

                                @if (Auth::user()->access_code == 'master')
                                <li>
                                    <button class="dropdown-item glass-dropdown-item" id="button-master-dashboard">
                                        <div class="d-flex align-items-center">
                                            <span class="item-icon-box bg-info-subtle text-info">
                                                <i class="fas fa-cog"></i>
                                            </span>
                                            <span>Master Page</span>
                                        </div>
                                        <i class="fas fa-chevron-right item-arrow"></i>
                                    </button>
                                </li>
                                @endif

                                <li>
                                    <hr class="dropdown-divider my-2 opacity-25">
                                </li>

                                <li>
                                    <button class="dropdown-item glass-dropdown-item text-danger" id="button-logout">
                                        <div class="d-flex align-items-center">
                                            <span class="item-icon-box bg-danger-subtle text-danger">
                                                <i class="fas fa-sign-out-alt"></i>
                                            </span>
                                            <span>Log Out</span>
                                        </div>
                                        <i class="fas fa-chevron-right item-arrow"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Running Text Marquee -->
            <div class="marquee-box d-flex align-items-center">
                <i class="fas fa-bullhorn me-2 text-warning fs--1"></i>
                <marquee class="m-0 fw-medium fs--1" behavior="scroll" direction="left">
                    Selamat Datang di Innoventra System Management — Solusi Integrasi Sistem Terlengkap untuk Bisnis Anda.
                </marquee>
            </div>

            <!-- Grid Card Features Desktop -->
            <div class="menu-grid-desktop" id="desktopAppGrid">
                @if (Auth::user()->access_code == 'master')
                @php $menu = DB::table('z_menu_super')->get(); @endphp
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

                $iconClass = 'fa-cubes';
                $iconBg = 'linear-gradient(135deg, #38bdf8, #0284c7)';
                $cardBorder = 'rgba(2, 132, 199, 0.3)';

                if(str_contains($code, 'account') || str_contains($code, 'keuangan')) {
                $iconClass = 'fa-chart-pie';
                $iconBg = 'linear-gradient(135deg, #34d399, #059669)';
                $cardBorder = 'rgba(5, 150, 105, 0.3)';
                } elseif(str_contains($code, 'inventar') || str_contains($code, 'stok')) {
                $iconClass = 'fa-box-open';
                $iconBg = 'linear-gradient(135deg, #fbbf24, #d97706)';
                $cardBorder = 'rgba(217, 119, 6, 0.3)';
                } elseif(str_contains($code, 'medic') || str_contains($code, 'health')) {
                $iconClass = 'fa-notes-medical';
                $iconBg = 'linear-gradient(135deg, #f87171, #dc2626)';
                $cardBorder = 'rgba(220, 38, 38, 0.3)';
                } elseif(str_contains($code, 'logis') || str_contains($code, 'kurir')) {
                $iconClass = 'fa-truck-fast';
                $iconBg = 'linear-gradient(135deg, #a78bfa, #6d28d9)';
                $cardBorder = 'rgba(109, 40, 217, 0.3)';
                }
                @endphp

                <div class="menu-card-desktop item-card-filter" id="menu" data-code="{{$menus->menu_super_code}}" style="border: 1px solid {{$cardBorder}};">

                    <div class="card-gradient-bg" style="background: {{$iconBg}};"></div>

                    <div class="card-content-wrapper">
                        <div class="menu-icon-wrapper" style="background: {{$iconBg}};">
                            <i class="fas {{$iconClass}}"></i>
                        </div>

                        <div class="card-text">
                            <h6 class="fw-bold text-uppercase mb-1 filter-title">{{$menus->menu_super_name}}</h6>
                            <p class="fs--2 mb-0 text-truncate filter-desc">{{$menus->menu_super_desc}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>

        <footer class="desktop-footer text-center fs--2">
            <p class="mb-0">Innoventra System &copy; 2026 | v3.4.0</p>
        </footer>
    </div>


    <!-- MOBILE MODE CONTAINER -->
    <div class="d-lg-none">
        <div class="mobile-header-bar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <img src="{{asset('img/pp.png')}}" width="36" height="36" class="rounded-circle border border-primary p-1 bg-white" />
                <div>
                    <h6 class="mb-0 fw-bold text-dark fs--1">{{Auth::user()->fullname}}</h6>
                    <small class="text-muted fs--2">{{ strtoupper(Auth::user()->access_code) }}</small>
                </div>
            </div>

            <!-- Dropdown Action Button Mobile -->
            <div class="dropdown">
                <button class="btn btn-mobile-trigger shadow-sm" type="button" id="dropdownMobile" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end glass-dropdown-mobile border-0" aria-labelledby="dropdownMobile">
                    <li>
                        <button class="dropdown-item mobile-dropdown-item" id="button-menu-utama">
                            <div class="d-flex align-items-center">
                                <span class="mobile-icon-box bg-primary-subtle text-primary"><i class="fab fa-dashcube"></i></span>
                                <span>Menu Utama</span>
                            </div>
                            <i class="fas fa-chevron-right fs--2 opacity-50"></i>
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item mobile-dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-keuangan" id="button-proses-transaksi">
                            <div class="d-flex align-items-center">
                                <span class="mobile-icon-box bg-warning-subtle text-warning"><i class="fas fa-key"></i></span>
                                <span>Ubah Password</span>
                            </div>
                            <i class="fas fa-chevron-right fs--2 opacity-50"></i>
                        </button>
                    </li>
                    @if (Auth::user()->access_code == 'master')
                    <li>
                        <button class="dropdown-item mobile-dropdown-item" id="button-master-dashboard">
                            <div class="d-flex align-items-center">
                                <span class="mobile-icon-box bg-info-subtle text-info"><i class="fas fa-cog"></i></span>
                                <span>Master Page</span>
                            </div>
                            <i class="fas fa-chevron-right fs--2 opacity-50"></i>
                        </button>
                    </li>
                    @endif
                    <li>
                        <hr class="dropdown-divider my-1 opacity-25">
                    </li>
                    <li>
                        <button class="dropdown-item mobile-dropdown-item text-danger" id="button-logout">
                            <div class="d-flex align-items-center">
                                <span class="mobile-icon-box bg-danger-subtle text-danger"><i class="fas fa-sign-out-alt"></i></span>
                                <span>Log Out</span>
                            </div>
                            <i class="fas fa-chevron-right fs--2 opacity-50"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="android-widget-card">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="badge bg-white text-primary fw-bold fs--2">Ver.3 Active</span>
                <i class="fas fa-microchip fs-1 opacity-50"></i>
            </div>
            <h6 class="fw-bold mb-1 text-white">Innoventra Dashboard</h6>
            <p class="fs--2 mb-0 opacity-75">Silakan pilih aplikasi/modul di bawah untuk pengelolaan data.</p>
        </div>

        <div class="android-app-grid">
            @foreach ($menu as $menus)
            @php
            $code = strtolower($menus->menu_super_code);
            $bgColor = 'background: linear-gradient(135deg, #3b82f6, #1d4ed8);';
            $iconClass = 'fa-th-large';

            if(str_contains($code, 'account') || str_contains($code, 'keuangan')) {
            $bgColor = 'background: linear-gradient(135deg, #10b981, #047857);';
            $iconClass = 'fa-calculator';
            } elseif(str_contains($code, 'inventar') || str_contains($code, 'stok')) {
            $bgColor = 'background: linear-gradient(135deg, #f59e0b, #b45309);';
            $iconClass = 'fa-boxes';
            } elseif(str_contains($code, 'medic') || str_contains($code, 'health')) {
            $bgColor = 'background: linear-gradient(135deg, #ef4444, #b91c1c);';
            $iconClass = 'fa-user-md';
            } elseif(str_contains($code, 'logis') || str_contains($code, 'kurir')) {
            $bgColor = 'background: linear-gradient(135deg, #8b5cf6, #6d28d9);';
            $iconClass = 'fa-truck';
            }
            @endphp

            <div class="app-item-mobile" id="menu" data-code="{{$menus->menu_super_code}}">
                <div class="app-icon-wrapper" style="{{$bgColor}}">
                    <i class="fas {{$iconClass}}"></i>
                </div>
                <span class="app-label-mobile">{{$menus->menu_super_name}}</span>
            </div>
            @endforeach
        </div>

        <div class="android-bottom-nav">
            <a class="android-nav-btn" href="#">
                <div class="nav-icon-wrapper nav-icon-home"><i class="fas fa-home"></i></div>
                <span>Home</span>
            </a>
            <a class="android-nav-btn" href="#" data-bs-toggle="modal" data-bs-target="#modal-keuangan">
                <div class="nav-icon-wrapper nav-icon-reset"><i class="fas fa-key"></i></div>
                <span>Reset</span>
            </a>
            <a class="android-nav-btn" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <div class="nav-icon-wrapper nav-icon-info"><i class="fas fa-comment-alt"></i></div>
                <span>Info</span>
            </a>
            <a class="android-nav-btn" id="button-logout" href="#">
                <div class="nav-icon-wrapper nav-icon-logout"><i class="fas fa-power-off"></i></div>
                <span class="text-danger">Keluar</span>
            </a>
        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-light">
                    <h6 class="modal-title fw-bold" id="staticBackdropLabel">Informasi System</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted fs--1 mb-0">Layanan integrasi dashboard manajemen terlengkap untuk membantu pengelolaan data perusahaan Anda.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-keuangan" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-sm-custom">
            <div class="modal-content glass-reset-modal border-0 shadow-lg">
                <button type="button" class="btn-close btn-close-custom" data-bs-dismiss="modal" aria-label="Close"></button>
                <div id="reset-step-1" class="reset-step-container">
                    <div class="text-center mb-4">
                        <div class="reset-icon-badge bg-warning-subtle text-warning mx-auto mb-3"><i class="fas fa-envelope fs-3"></i></div>
                        <h5 class="fw-bold text-dark mb-1">Reset Password</h5>
                        <p class="text-muted fs--2 mb-0">Masukkan email terdaftar untuk menerima kode verifikasi OTP.</p>
                    </div>
                    <form id="form-request-otp">
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold fs--2">EMAIL TERDAFTAR</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="fas fa-at"></i></span>
                                <input type="email" class="form-control custom-input border-start-0" id="reset-email" placeholder="nama@email.com" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary-gradient w-100 rounded-pill py-2 fw-semibold text-white" id="btn-send-otp">
                            <span>Kirim Kode Verifikasi</span> <i class="fas fa-arrow-right ms-2 fs--2"></i>
                        </button>
                    </form>
                </div>

                <div id="reset-step-2" class="reset-step-container d-none">
                    <div class="text-center mb-3">
                        <div class="reset-icon-badge bg-info-subtle text-info mx-auto mb-2"><i class="fas fa-shield-alt fs-4"></i></div>
                        <h5 class="fw-bold text-dark mb-1">Verifikasi OTP</h5>
                        <p class="text-muted fs--2 mb-0">Masukkan 6 digit kode OTP yang dikirim ke email Anda.</p>
                    </div>
                    <form id="form-verify-otp">
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold fs--2 text-center d-block">KODE VERIFIKASI (OTP)</label>
                            <div class="d-flex justify-content-center gap-1 otp-group mb-2">
                                <input type="text" maxlength="1" class="form-control otp-input text-center px-1" required>
                                <input type="text" maxlength="1" class="form-control otp-input text-center px-1" required>
                                <input type="text" maxlength="1" class="form-control otp-input text-center px-1" required>
                                <input type="text" maxlength="1" class="form-control otp-input text-center px-1" required>
                                <input type="text" maxlength="1" class="form-control otp-input text-center px-1" required>
                                <input type="text" maxlength="1" class="form-control otp-input text-center px-1" required>
                            </div>
                            <div class="text-center"><small class="text-muted fs--2">Belum terima kode? <a href="#" id="btn-resend-otp" class="text-primary fw-bold text-decoration-none">Kirim Ulang</a></small></div>
                        </div>
                        <button type="submit" class="btn btn-primary-gradient w-100 rounded-pill py-2 fw-semibold text-white mt-2" id="btn-check-otp"><i class="fas fa-check-circle me-1"></i> Verifikasi Kode OTP</button>
                    </form>
                </div>

                <div id="reset-step-3" class="reset-step-container d-none">
                    <div class="text-center mb-3">
                        <div class="reset-icon-badge bg-success-subtle text-success mx-auto mb-2"><i class="fas fa-lock fs-4"></i></div>
                        <h5 class="fw-bold text-dark mb-1">Password Baru</h5>
                        <p class="text-muted fs--2 mb-0">Buat kata sandi baru untuk akun Anda.</p>
                    </div>
                    <form id="form-reset-password">
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold fs--2">KATA SANDI BARU</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control custom-input border-start-0" id="new-password" placeholder="••••••••" minlength="6" required>
                                <button class="btn border border-start-0 text-muted btn-toggle-pass" type="button"><i class="fas fa-eye"></i></button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold fs--2">KONFIRMASI KATA SANDI</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control custom-input border-start-0" id="confirm-password" placeholder="••••••••" minlength="6" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success-gradient w-100 rounded-pill py-2 fw-semibold text-white mt-2" id="btn-save-password"><i class="fas fa-save me-1"></i> Simpan Password Baru</button>
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
                btn.prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Memeriksa Email...');
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
                            text: res.message || 'Silakan periksa kembali email yang Anda masukkan.'
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
                        text: errorMsg
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
                    Swal.fire("Peringatan", "Harap masukkan 6 digit kode OTP secara lengkap!", "warning");
                    return;
                }
                btn.prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Memverifikasi...');
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
                            text: 'Silakan masukkan password baru Anda.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        step2.classList.add("d-none");
                        step3.classList.remove("d-none");
                        document.getElementById("new-password").focus();
                    } else {
                        Swal.fire("OTP Salah", res.message, "error");
                    }
                }).fail(function(xhr) {
                    btn.prop("disabled", false).html('<i class="fas fa-check-circle me-1"></i> Verifikasi Kode OTP');
                    const res = xhr.responseJSON;
                    Swal.fire("Error", res && res.message ? res.message : "Gagal memverifikasi OTP.", "error");
                });
            });

            formResetPass.addEventListener("submit", function(e) {
                e.preventDefault();
                const password = document.getElementById("new-password").value;
                const confirmPassword = document.getElementById("confirm-password").value;
                const btn = $("#btn-save-password");
                if (password !== confirmPassword) {
                    Swal.fire("Perhatian", "Konfirmasi kata sandi tidak cocok!", "warning");
                    return;
                }
                btn.prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
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
                    btn.prop("disabled", false).html('<i class="fas fa-save me-1"></i> Simpan Password Baru');
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire("Gagal", res.message, "error");
                    }
                }).fail(function(xhr) {
                    btn.prop("disabled", false).html('<i class="fas fa-save me-1"></i> Simpan Password Baru');
                    const res = xhr.responseJSON;
                    Swal.fire("Error", res && res.message ? res.message : "Gagal mengubah password.", "error");
                });
            });
        });

        $(document).on("click", "#menu", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            Swal.fire({
                title: "Mohon Menunggu",
                html: "Membuka modul...",
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
                        Swal.fire("Error", "Gagal memuat menu.", "error");
                    });
                }
            });
        });

        $(document).on("click", "#button-logout", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Konfirmasi Keluar",
                text: "Apakah Anda yakin ingin keluar?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
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
            window.location.href = "{{route('master_dashboard')}}";
        });
        $(document).on("click", "#button-menu-utama", function(e) {
            e.preventDefault();
            window.location.href = "{{route('/')}}";
        });
    </script>
</body>

</html>
