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
        /* BACKGROUND SMART CITY TEKNOLOGI DENGAN EFEK BLUR           */
        /* ========================================================= */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #1e293b;
            background-color: #0b0f19;
            position: relative;
            min-height: 100vh;
        }

        /* Container Layer Gambar Background + Filter Blur */
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

        /* Overlay Gradien Halus */
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

        /* ========================================================= */
        /* MODE DESKTOP OPTIMIZED: NO SCROLL & AUTO FIT-TO-SCREEN     */
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
                padding: 1rem 2rem;
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
                background: rgba(255, 255, 255, 0.88);
                backdrop-filter: blur(24px);
                border-radius: 16px;
                border: 1px solid rgba(255, 255, 255, 0.9);
                box-shadow: 0 10px 25px rgba(2, 132, 199, 0.12);
                padding: 0.6rem 1.2rem;
                margin-bottom: 0.8rem;
                position: relative;
                z-index: 1050 !important;
                flex-shrink: 0;
            }

            /* Dropdown z-index Fix */
            .dropdown-menu-custom {
                z-index: 999999 !important;
                position: absolute !important;
                border-radius: 14px !important;
                padding: 0.5rem !important;
                background-color: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                box-shadow: 0 20px 40px rgba(15, 23, 42, 0.25) !important;
            }

            .marquee-box {
                background: linear-gradient(90deg, #0369a1, #0284c7);
                border-radius: 10px;
                padding: 5px 14px;
                color: #fff;
                margin-bottom: 0.8rem;
                box-shadow: 0 4px 10px rgba(2, 132, 199, 0.2);
                flex-shrink: 0;
            }

            /* Container Grid Dynamic Height */
            .menu-grid-desktop {
                flex: 1;
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                gap: 0.8rem;
                align-items: stretch;
                min-height: 0;
            }

            /* Styling Card Desktop dengan Border Gradien Modern */
            .menu-card-desktop {
                border: none;
                border-radius: 16px;
                overflow: hidden;
                position: relative;
                height: 100%;
                min-height: 120px;
                cursor: pointer;
                transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
                z-index: 1;
                background: #0f172a;
                padding: 2px;
                /* Memberikan ruang untuk border gradien */
            }

            /* Lapisan Border Gradien (Pseudo Element) */
            .menu-card-desktop::before {
                content: "";
                position: absolute;
                inset: 0;
                border-radius: 16px;
                padding: 2px;
                /* Ketebalan border gradien */
                background: linear-gradient(135deg, rgba(56, 189, 248, 0.8), rgba(99, 102, 241, 0.2), rgba(236, 72, 153, 0.8));
                -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
                -webkit-mask-composite: xor;
                mask-composite: exclude;
                pointer-events: none;
                z-index: 10;
                transition: all 0.4s ease;
                opacity: 0.7;
            }

            /* Efek Hover: Border Gradien Menyala & Membesar */
            .menu-card-desktop:hover {
                transform: translateY(-5px);
                box-shadow: 0 14px 28px rgba(2, 132, 199, 0.4), 0 0 15px rgba(56, 189, 248, 0.25);
            }

            .menu-card-desktop:hover::before {
                opacity: 1;
                background: linear-gradient(135deg, #00f2fe, #4facfe, #00c6ff);
            }

            .menu-card-desktop .card-bg-img {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.4s ease;
                z-index: 1;
                border-radius: 14px;
            }

            .menu-card-desktop .card-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(180deg, rgba(15, 23, 42, 0.15) 0%, rgba(15, 23, 42, 0.9) 100%);
                z-index: 2;
                border-radius: 14px;
            }

            .menu-card-desktop .card-content {
                position: relative;
                z-index: 3;
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                padding: 1rem;
                color: #ffffff;
            }

            .menu-card-desktop .menu-icon-badge {
                position: absolute;
                top: 12px;
                right: 12px;
                width: 36px;
                height: 36px;
                background: rgba(255, 255, 255, 0.2);
                backdrop-filter: blur(8px);
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
                color: #fff;
                border: 1px solid rgba(255, 255, 255, 0.4);
                z-index: 3;
            }

            .menu-card-desktop:hover .card-bg-img {
                transform: scale(1.08);
            }

            .desktop-footer {
                padding: 0.4rem 0 0 0;
                text-align: center;
                color: #f8fafc !important;
                flex-shrink: 0;
            }
        }

        /* ========================================================= */
        /* MODE MOBILE: HOME SCREEN ANDROID NATIVE LAUNCHER          */
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

            /* Custom Floating Dock Bottom Nav */
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
                /* Super Rounded Oval */
                display: flex;
                align-items: center;
                justify-content: space-around;
                padding: 0 10px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25), 0 5px 15px rgba(0, 0, 0, 0.08);
                border: 1px solid rgba(255, 255, 255, 0.8);
                z-index: 10000;
            }

            /* Nav Button Item */
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

            /* Icon Wrapper/Badge Berwarna & Besar */
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

            /* Skema Warna Gradient Tiap Icon */
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

            /* Active State & Press Effect */
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

            .android-nav-btn.active {
                color: #0284c7;
            }
        }

        /* Custom Stylish Dropdown */
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

        /* Header Mini Profil di Atas Menu */
        .dropdown-profile-header {
            background: linear-gradient(135deg, rgba(2, 132, 199, 0.08), rgba(59, 130, 246, 0.05));
            border-radius: 12px;
            padding: 0.65rem 0.8rem;
            margin-bottom: 0.4rem;
        }

        /* Item Menu Hover Effect */
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

        /* Icon Badge Styling */
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

        /* Chevron panah kecil di sisi kanan menu */
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

        /* Trigger Button */
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

        /* Mobile Glassmorphism Dropdown */
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

        /* Item Dropdown Mobile */
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

        /* Icon Box Mobile */
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

        /* Trigger Button Mobile */
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

        /* Glassmorphism Reset Modal */
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

        /* Form Input Styling */
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

        /* OTP Boxes Styling */
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

        /* Gradient Buttons */
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

                    <div class="d-flex align-items-center gap-3">
                        <div class="text-end">
                            <h6 class="mb-0 fw-bold text-dark fs--1">{{Auth::user()->fullname}}</h6>
                            <span class="badge bg-light text-dark border fs--2">{{ strtoupper(Auth::user()->access_code) }}</span>
                        </div>

                        <div class="position-relative">
                            <img class="rounded-circle border border-2 border-primary" src="{{asset('img/pp.png')}}" width="38" height="38" alt="Profile" />
                        </div>

                        <!-- Dropdown Action Button Modern -->
                        <div class="dropdown" style="z-index: 999999 !important; position: relative;">
                            <button class="btn btn-dropdown-trigger shadow-sm" type="button" id="dropdownDesktop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end glass-dropdown-menu border-0 shadow-lg" aria-labelledby="dropdownDesktop">

                                <!-- Header Ringkas Profil -->
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

                                <!-- Menu Navigation -->
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
            <div class="menu-grid-desktop">
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
                }
                @endphp

                <div class="menu-card-desktop" id="menu" data-code="{{$menus->menu_super_code}}">
                    <img src="{{ asset($menus->menu_super_img ?? $imgUrl) }}" alt="{{$menus->menu_super_name}}" class="card-bg-img">
                    <div class="card-overlay"></div>
                    <div class="menu-icon-badge"><i class="fas {{$iconClass}}"></i></div>
                    <div class="card-content">
                        <h6 class="fw-bold text-uppercase mb-1 text-white fs--1">{{$menus->menu_super_name}}</h6>
                        <p class="fs--2 opacity-75 mb-0 text-truncate">{{$menus->menu_super_desc}}</p>
                    </div>
                </div>
                @endforeach
            </div>

        </div>

        <footer class="desktop-footer text-center fs--2">
            <p class="mb-0 fw-medium">Innoventra System &copy; 2026 | v3.4.0</p>
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
                                <span class="mobile-icon-box bg-primary-subtle text-primary">
                                    <i class="fab fa-dashcube"></i>
                                </span>
                                <span>Menu Utama</span>
                            </div>
                            <i class="fas fa-chevron-right fs--2 opacity-50"></i>
                        </button>
                    </li>

                    <li>
                        <button class="dropdown-item mobile-dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-keuangan" id="button-proses-transaksi">
                            <div class="d-flex align-items-center">
                                <span class="mobile-icon-box bg-warning-subtle text-warning">
                                    <i class="fas fa-key"></i>
                                </span>
                                <span>Ubah Password</span>
                            </div>
                            <i class="fas fa-chevron-right fs--2 opacity-50"></i>
                        </button>
                    </li>

                    @if (Auth::user()->access_code == 'master')
                    <li>
                        <button class="dropdown-item mobile-dropdown-item" id="button-master-dashboard">
                            <div class="d-flex align-items-center">
                                <span class="mobile-icon-box bg-info-subtle text-info">
                                    <i class="fas fa-cog"></i>
                                </span>
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
                                <span class="mobile-icon-box bg-danger-subtle text-danger">
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

        <!-- Floating Glass Bottom Navigation -->
        <div class="android-bottom-nav">
            <a class="android-nav-btn" href="#">
                <div class="nav-icon-wrapper nav-icon-home">
                    <i class="fas fa-home"></i>
                </div>
                <span>Home</span>
            </a>

            <a class="android-nav-btn" href="#" data-bs-toggle="modal" data-bs-target="#modal-keuangan">
                <div class="nav-icon-wrapper nav-icon-reset">
                    <i class="fas fa-key"></i>
                </div>
                <span>Reset</span>
            </a>

            <a class="android-nav-btn" href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <div class="nav-icon-wrapper nav-icon-info">
                    <i class="fas fa-comment-alt"></i>
                </div>
                <span>Info</span>
            </a>

            <a class="android-nav-btn" id="button-logout" href="#">
                <div class="nav-icon-wrapper nav-icon-logout">
                    <i class="fas fa-power-off"></i>
                </div>
                <span class="text-danger">Keluar</span>
            </a>
        </div>
    </div>

    <!-- Modal Information -->
    <div class="modal fade" id="staticBackdrop" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header bg-light">
                    <h6 class="modal-title fw-bold" id="staticBackdropLabel">Informasi System</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted fs--1 mb-0">
                        Layanan integrasi dashboard manajemen terlengkap untuk membantu pengelolaan data perusahaan Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Reset Password Multi-step -->
    <div class="modal fade" id="modal-keuangan" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-sm-custom">
            <div class="modal-content glass-reset-modal border-0 shadow-lg">

                <!-- Close Button -->
                <button type="button" class="btn-close btn-close-custom" data-bs-dismiss="modal" aria-label="Close"></button>

                <!-- STEP 1: Request OTP / Email Input -->
                <div id="reset-step-1" class="reset-step-container">
                    <div class="text-center mb-4">
                        <div class="reset-icon-badge bg-warning-subtle text-warning mx-auto mb-3">
                            <i class="fas fa-shield-alt fs-3"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Reset Password</h5>
                        <p class="text-muted fs--2 mb-0">Masukkan email/username terdaftar untuk menerima kode verifikasi.</p>
                    </div>

                    <form id="form-request-otp">
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold fs--2">EMAIL / USERNAME</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0 bg-transparent text-muted">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="text" class="form-control custom-input border-start-0" id="reset-identity" placeholder="nama@email.com" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary-gradient w-100 rounded-pill py-2 fw-semibold text-white">
                            <span>Kirim Kode Verifikasi</span> <i class="fas fa-arrow-right ms-2 fs--2"></i>
                        </button>
                    </form>
                </div>

                <!-- STEP 2: Input OTP & New Password (Hidden by default) -->
                <div id="reset-step-2" class="reset-step-container d-none">
                    <div class="text-center mb-3">
                        <div class="reset-icon-badge bg-info-subtle text-info mx-auto mb-2">
                            <i class="fas fa-lock-open fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Verifikasi & Ubah</h5>
                        <p class="text-muted fs--2 mb-0">Masukkan 4 digit kode yang dikirim dan buat kata sandi baru.</p>
                    </div>

                    <form id="form-submit-reset">
                        <!-- OTP Input Box -->
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold fs--2 text-center d-block">KODE VERIFIKASI (OTP)</label>
                            <div class="d-flex justify-content-center gap-2 otp-group mb-2">
                                <input type="text" maxlength="1" class="form-control otp-input text-center" required>
                                <input type="text" maxlength="1" class="form-control otp-input text-center" required>
                                <input type="text" maxlength="1" class="form-control otp-input text-center" required>
                                <input type="text" maxlength="1" class="form-control otp-input text-center" required>
                            </div>
                            <div class="text-center">
                                <small class="text-muted fs--2">Belum terima kode? <a href="#" id="btn-resend-otp" class="text-primary fw-bold text-decoration-none">Kirim Ulang</a></small>
                            </div>
                        </div>

                        <!-- New Password Input -->
                        <div class="mb-3">
                            <label class="form-label text-secondary fw-semibold fs--2">KATA SANDI BARU</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="fas fa-key"></i></span>
                                <input type="password" class="form-control custom-input border-start-0" id="new-password" placeholder="••••••••" required>
                                <button class="btn border border-start-0 text-muted btn-toggle-pass" type="button"><i class="fas fa-eye"></i></button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success-gradient w-100 rounded-pill py-2 fw-semibold text-white mt-2">
                            <i class="fas fa-check-circle me-1"></i> Simpan Password Baru
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const step1 = document.getElementById("reset-step-1");
            const step2 = document.getElementById("reset-step-2");
            const formReq = document.getElementById("form-request-otp");
            const formSubmit = document.getElementById("form-submit-reset");
            const otpInputs = document.querySelectorAll(".otp-input");

            // 1. Pindah dari Step 1 ke Step 2 (Kirim OTP)
            formReq.addEventListener("submit", function(e) {
                e.preventDefault();
                step1.classList.add("d-none");
                step2.classList.remove("d-none");
                otpInputs[0].focus(); // Auto focus ke kotak OTP pertama
            });

            // 2. Auto Focus Next/Prev Input pada Kotak OTP
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

            // 3. Toggle Lihat Password
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

            // 4. Submit Reset Form Akhir
            formSubmit.addEventListener("submit", function(e) {
                e.preventDefault();
                alert("Password berhasil diperbarui!");
                // Reset Form & Tutup Modal
                location.reload();
            });
        });
    </script>
</body>

</html>
