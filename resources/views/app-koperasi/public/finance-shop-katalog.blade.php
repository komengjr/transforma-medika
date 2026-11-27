<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koperasi E-Shop &amp; Katalog Anggota</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Select2 CSS & Bootstrap 5 Theme -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

    <style>
        /* =========================================
           MODERN ENTERPRISE UI STYLES (KOP-MART E-SHOP)
           (MINIMARKET THEME + ADAPTIVE LIGHT & DARK MODE)
           ========================================= */
        :root {
            --ent-indigo: #4f46e5;
            --ent-indigo-dark: #4338ca;
            --ent-indigo-soft: rgba(79, 70, 229, 0.12);
            --ent-grid-border: rgba(99, 102, 241, 0.28);
            --ent-emerald: #059669;
            --ent-sky: #0284c7;
            --ent-amber: #d97706;
            --ent-rose: #e11d48;
            --ent-surface: #ffffff;
            --ent-text: #0f172a;
            --ent-bg: #eef2f7;
        }

        [data-bs-theme="dark"],
        .dark {
            --ent-surface: #0f172a;
            --ent-text: #f8fafc;
            --ent-bg: #020617;
        }

        /* Latar Belakang Nuansa Minimarket (Rak & Aisle Ambient) */
        body.minimarket-bg {
            background-color: var(--ent-bg);
            color: var(--ent-text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            position: relative;
            min-height: 100vh;
            background-image:
                radial-gradient(circle at 12% 18%, rgba(79, 70, 229, 0.08) 0%, transparent 38%),
                radial-gradient(circle at 88% 12%, rgba(16, 185, 129, 0.08) 0%, transparent 35%),
                radial-gradient(circle at 82% 85%, rgba(245, 158, 11, 0.07) 0%, transparent 40%),
                /* Pola rak minimarket horizontal & lorong vertikal halus */
                repeating-linear-gradient(
                    0deg,
                    transparent 0px,
                    transparent 54px,
                    rgba(99, 102, 241, 0.055) 54px,
                    rgba(99, 102, 241, 0.055) 56px
                ),
                repeating-linear-gradient(
                    90deg,
                    transparent 0px,
                    transparent 118px,
                    rgba(14, 165, 233, 0.045) 118px,
                    rgba(14, 165, 233, 0.045) 120px
                );
            background-attachment: fixed;
        }

        /* Siluet Rak & Keranjang Minimarket Dekoratif di Latar Belakang */
        .minimarket-backdrop-decor {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .minimarket-backdrop-decor .shelf-silhouette {
            position: absolute;
            bottom: 0;
            width: 340px;
            height: 260px;
            opacity: 0.055;
            color: #4f46e5;
        }

        .minimarket-backdrop-decor .shelf-left {
            left: 1.5%;
        }

        .minimarket-backdrop-decor .shelf-right {
            right: 1.5%;
        }

        .main-shop-wrapper {
            position: relative;
            z-index: 1;
        }

        /* Hero Navbar Banner dengan Aksen Kanopi Minimarket */
        .ent-navbar-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
            border-bottom: 1px solid rgba(99, 102, 241, 0.35);
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.25);
            position: relative;
            overflow: hidden;
        }

        .ent-navbar-banner::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 4px;
            background: repeating-linear-gradient(
                90deg,
                #38bdf8 0px,
                #38bdf8 22px,
                #10b981 22px,
                #10b981 44px,
                #f59e0b 44px,
                #f59e0b 66px
            );
            opacity: 0.85;
        }

        .ent-glass-pill {
            background: rgba(255, 255, 255, 0.09);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 12px;
            color: #ffffff;
        }

        /* Adaptive Enterprise Card */
        .ent-card {
            border: 1px solid var(--ent-grid-border);
            border-radius: 16px;
            background-color: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(6px);
            color: var(--ent-text);
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
            overflow: visible;
        }

        [data-bs-theme="dark"] .ent-card,
        .dark .ent-card {
            background-color: rgba(15, 23, 42, 0.94);
        }

        /* Product Card */
        .product-card {
            border: 1px solid var(--ent-grid-border);
            border-radius: 16px;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            overflow: hidden;
            background: var(--ent-surface);
            color: var(--ent-text);
            box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.06);
        }

        .product-card:hover {
            transform: translateY(-4px);
            border-color: rgba(79, 70, 229, 0.55);
            box-shadow: 0 12px 24px -6px rgba(79, 70, 229, 0.15);
        }

        .product-img-wrapper {
            position: relative;
            height: 195px;
            width: 100%;
            background: linear-gradient(145deg, rgba(79, 70, 229, 0.07) 0%, rgba(14, 165, 233, 0.08) 100%);
            border-bottom: 1px solid var(--ent-grid-border);
            overflow: hidden;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Default Product Icon Placeholder jika gambar kosong/error */
        .product-icon-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at 50% 35%, rgba(79, 70, 229, 0.13), rgba(2, 132, 199, 0.05));
            color: #4f46e5;
            gap: 8px;
        }

        .product-icon-placeholder .icon-circle {
            width: 68px;
            height: 68px;
            border-radius: 20px;
            background: rgba(79, 70, 229, 0.12);
            border: 1px dashed rgba(79, 70, 229, 0.38);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.85rem;
            color: #4f46e5;
        }

        [data-bs-theme="dark"] .product-icon-placeholder .icon-circle,
        .dark .product-icon-placeholder .icon-circle {
            color: #818cf8;
            border-color: rgba(129, 140, 248, 0.4);
        }

        .product-icon-placeholder span {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            opacity: 0.65;
        }

        .badge-category {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 2;
            background: rgba(15, 23, 42, 0.82) !important;
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 9999px;
            padding: 4px 10px;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .cart-sticky {
            position: sticky;
            top: 24px;
        }

        .fs-7 {
            font-size: 0.75rem;
        }

        /* Form Label & Input */
        .ent-form-label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: var(--bs-secondary-color, #64748b);
            margin-bottom: 6px;
        }

        .search-box,
        .ent-select {
            border: 1px solid var(--ent-grid-border) !important;
            border-radius: 10px !important;
            background-color: var(--ent-surface) !important;
            color: var(--ent-text) !important;
            font-weight: 600;
            font-size: 0.82rem;
            transition: all 0.2s ease;
        }

        .search-box:focus,
        .ent-select:focus {
            border-color: var(--ent-indigo) !important;
            box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
            outline: none;
        }

        /* Select2 Custom Enterprise Styling */
        .select2-container--bootstrap-5 .select2-selection {
            border: 1px solid var(--ent-grid-border) !important;
            border-radius: 10px !important;
            background-color: var(--ent-surface) !important;
            color: var(--ent-text) !important;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.76rem !important;
            font-weight: 600 !important;
            min-height: 40px !important;
            padding: 6px 12px !important;
            display: flex;
            align-items: center;
        }

        .select2-container--bootstrap-5.select2-container--focus .select2-selection,
        .select2-container--bootstrap-5.select2-container--open .select2-selection {
            border-color: var(--ent-indigo) !important;
            box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            color: var(--ent-text) !important;
            padding-left: 0 !important;
        }

        .select2-container--bootstrap-5 .select2-dropdown {
            border: 1px solid var(--ent-grid-border) !important;
            border-radius: 12px !important;
            background-color: var(--ent-surface) !important;
            color: var(--ent-text) !important;
            box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.22) !important;
            overflow: hidden;
        }

        .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
            border: 1px solid var(--ent-grid-border) !important;
            border-radius: 8px !important;
            background-color: var(--ent-surface) !important;
            color: var(--ent-text) !important;
            font-size: 0.8rem !important;
        }

        .select2-container--bootstrap-5 .select2-results__option {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem !important;
            padding: 8px 12px !important;
        }

        .select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected] {
            background-color: #4f46e5 !important;
            color: #ffffff !important;
        }

        .search-input-group .input-group-text {
            border: 1px solid var(--ent-grid-border) !important;
            border-right: none !important;
            border-radius: 10px 0 0 10px !important;
            background-color: rgba(79, 70, 229, 0.06) !important;
            color: var(--ent-indigo) !important;
        }

        .search-input-group .search-box {
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }

        /* Category Pills */
        .category-pill {
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
            border: 1px solid var(--ent-grid-border);
            background-color: rgba(79, 70, 229, 0.06);
            color: var(--ent-text);
            font-weight: 600;
            font-size: 0.74rem;
        }

        .category-pill:hover {
            background-color: rgba(79, 70, 229, 0.16);
            border-color: var(--ent-indigo);
        }

        .category-pill.active {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            border-color: #4f46e5;
            color: #ffffff !important;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }

        /* Modern Buttons */
        .ent-btn {
            font-weight: 600 !important;
            border-radius: 10px;
            transition: all 0.18s ease;
            letter-spacing: 0.01em;
            cursor: pointer;
            font-size: 0.82rem;
        }

        .ent-btn:hover:not(:disabled) {
            transform: translateY(-1px);
        }

        .ent-btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            border: none;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }

        .ent-btn-primary:hover:not(:disabled) {
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
            color: #ffffff;
        }

        /* Soft Badges */
        .ent-badge {
            border-radius: 9999px;
            padding: 4px 10px;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            font-size: 0.68rem;
            letter-spacing: 0.03em;
        }

        .badge-stock-ok {
            background-color: rgba(16, 185, 129, 0.16) !important;
            color: #10b981 !important;
            border: 1px solid rgba(16, 185, 129, 0.38);
        }

        .badge-stock-empty {
            background-color: rgba(225, 29, 72, 0.16) !important;
            color: #e11d48 !important;
            border: 1px solid rgba(225, 29, 72, 0.38);
        }

        /* Cart Item Row */
        .cart-item-row {
            background-color: rgba(79, 70, 229, 0.05);
            border: 1px solid var(--ent-grid-border) !important;
        }

        /* Payment Radio Box */
        .ent-pay-option {
            border: 1px solid var(--ent-grid-border);
            border-radius: 10px;
            padding: 8px 10px;
            background-color: rgba(79, 70, 229, 0.03);
            transition: border-color 0.15s ease, background-color 0.15s ease;
        }

        .ent-pay-option:hover {
            border-color: rgba(79, 70, 229, 0.5);
            background-color: rgba(79, 70, 229, 0.07);
        }
    </style>
</head>

<body class="minimarket-bg">

    <!-- DEKORASI LATAR BELAKANG SUASANA MINIMARKET -->
    <div class="minimarket-backdrop-decor" aria-hidden="true">
        <!-- Rak Gondola Kiri -->
        <svg class="shelf-silhouette shelf-left" viewBox="0 0 320 240" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="20" y="20" width="12" height="220" rx="4" fill="currentColor" />
            <rect x="288" y="20" width="12" height="220" rx="4" fill="currentColor" />
            <rect x="20" y="55" width="280" height="8" rx="3" fill="currentColor" />
            <rect x="20" y="115" width="280" height="8" rx="3" fill="currentColor" />
            <rect x="20" y="175" width="280" height="8" rx="3" fill="currentColor" />
            <rect x="20" y="230" width="280" height="10" rx="3" fill="currentColor" />
            <!-- Item barang di rak -->
            <rect x="44" y="27" width="32" height="28" rx="4" fill="currentColor" />
            <rect x="84" y="33" width="26" height="22" rx="4" fill="currentColor" />
            <rect x="122" y="25" width="38" height="30" rx="5" fill="currentColor" />
            <rect x="172" y="31" width="30" height="24" rx="4" fill="currentColor" />
            <rect x="215" y="27" width="44" height="28" rx="5" fill="currentColor" />
            <rect x="48" y="85" width="42" height="30" rx="5" fill="currentColor" />
            <rect x="102" y="90" width="28" height="25" rx="4" fill="currentColor" />
            <rect x="142" y="83" width="36" height="32" rx="5" fill="currentColor" />
            <rect x="190" y="88" width="48" height="27" rx="5" fill="currentColor" />
            <rect x="45" y="143" width="34" height="32" rx="5" fill="currentColor" />
            <rect x="92" y="148" width="46" height="27" rx="5" fill="currentColor" />
            <rect x="150" y="142" width="30" height="33" rx="4" fill="currentColor" />
            <rect x="192" y="146" width="40" height="29" rx="5" fill="currentColor" />
        </svg>

        <!-- Rak & Keranjang Belanja Kanan -->
        <svg class="shelf-silhouette shelf-right" viewBox="0 0 320 240" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="20" y="20" width="12" height="220" rx="4" fill="currentColor" />
            <rect x="288" y="20" width="12" height="220" rx="4" fill="currentColor" />
            <rect x="20" y="55" width="280" height="8" rx="3" fill="currentColor" />
            <rect x="20" y="115" width="280" height="8" rx="3" fill="currentColor" />
            <rect x="20" y="175" width="280" height="8" rx="3" fill="currentColor" />
            <rect x="20" y="230" width="280" height="10" rx="3" fill="currentColor" />
            <rect x="52" y="28" width="40" height="27" rx="5" fill="currentColor" />
            <rect x="104" y="32" width="32" height="23" rx="4" fill="currentColor" />
            <rect x="148" y="26" width="44" height="29" rx="5" fill="currentColor" />
            <rect x="204" y="30" width="36" height="25" rx="4" fill="currentColor" />
            <rect x="44" y="86" width="36" height="29" rx="5" fill="currentColor" />
            <rect x="92" y="84" width="48" height="31" rx="5" fill="currentColor" />
            <rect x="152" y="90" width="30" height="25" rx="4" fill="currentColor" />
            <rect x="196" y="85" width="42" height="30" rx="5" fill="currentColor" />
            <rect x="55" y="145" width="44" height="30" rx="5" fill="currentColor" />
            <rect x="112" y="142" width="32" height="33" rx="4" fill="currentColor" />
            <rect x="156" y="147" width="46" height="28" rx="5" fill="currentColor" />
            <rect x="214" y="144" width="34" height="31" rx="5" fill="currentColor" />
        </svg>
    </div>

    <div class="main-shop-wrapper">
        <!-- TOP HERO NAVBAR -->
        <nav class="navbar navbar-expand-lg ent-navbar-banner navbar-dark py-3 mb-4">
            <div class="container">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
                    <span class="ent-glass-pill d-inline-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                        <i class="fas fa-store text-info"></i>
                    </span>
                    <span>KOP-MART <span class="text-info">MINIMARKET</span></span>
                </a>
                <div class="d-flex align-items-center gap-2">
                    <span class="ent-badge" style="background: rgba(56, 189, 248, 0.18); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                        <i class="fas fa-shopping-basket me-1"></i> E-Shop Anggota
                    </span>
                    <span class="navbar-text small d-none d-md-inline" style="color: #cbd5e1;">Katalog Belanja Khusus Anggota Koperasi</span>
                </div>
            </div>
        </nav>

        <div class="container pb-5">

            <!-- FITUR FILTER & PENCARIAN -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="ent-card p-3 p-md-4">
                        <div class="row align-items-center g-3">
                            <!-- Input Cari Nama -->
                            <div class="col-md-5">
                                <label class="form-label ent-form-label"><i class="fas fa-search me-1 text-primary"></i> Cari Produk</label>
                                <div class="input-group search-input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" id="search-product" class="form-control search-box py-2" placeholder="Ketik nama produk yang dicari...">
                                </div>
                            </div>
                            <!-- Filter Kategori Buttons -->
                            <div class="col-md-7">
                                <label class="form-label ent-form-label"><i class="fas fa-tags me-1 text-primary"></i> Filter Kategori</label>
                                <div class="d-flex flex-wrap gap-2" id="category-filter-container">
                                    <span class="badge category-pill rounded-pill px-3 py-2 active" data-category="all">Semua</span>

                                    @php
                                    $categories = $produk->pluck('kategori')->unique();
                                    @endphp
                                    @foreach($categories as $cat)
                                    <span class="badge category-pill rounded-pill px-3 py-2" data-category="{{ $cat }}">{{ $cat }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">

                <!-- BAGIAN KIRI: ETALASE DAFTAR PRODUK (8 COLUMNS) -->
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0"><i class="fas fa-boxes me-2 text-primary"></i>Rak Etalase Produk</h5>
                        <span class="opacity-75 small fw-semibold" id="search-status"></span>
                    </div>

                    <div class="row row-cols-1 row-cols-md-3 g-4" id="product-list-container">
                        @forelse($produk as $p)
                        @php
                            $rawImg = trim((string) ($p->url_gambar ?? ''));
                            $hasValidImage = $rawImg !== '' && !str_contains(strtolower($rawImg), 'placehold.co') && !str_contains(strtolower($rawImg), 'no+image') && !str_contains(strtolower($rawImg), 'no-image');
                        @endphp
                        <div class="col product-item" data-nama="{{ strtolower($p->nama_produk) }}" data-kategori="{{ $p->kategori }}">
                            <div class="card h-100 product-card">
                                <div class="product-img-wrapper">
                                    <span class="badge text-white badge-category shadow-sm">{{ $p->kategori }}</span>
                                    @if($hasValidImage)
                                        <img src="{{ $rawImg }}"
                                             class="product-img"
                                             alt="{{ $p->nama_produk }}"
                                             onerror="this.classList.add('d-none'); this.nextElementSibling.classList.remove('d-none');">
                                        <div class="product-icon-placeholder d-none">
                                            <div class="icon-circle">
                                                <i class="fas fa-box-open"></i>
                                            </div>
                                            <span>Produk Koperasi</span>
                                        </div>
                                    @else
                                        <div class="product-icon-placeholder">
                                            <div class="icon-circle">
                                                <i class="fas fa-box-open"></i>
                                            </div>
                                            <span>Produk Koperasi</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body d-flex flex-column p-3">
                                    <small class="opacity-75 text-uppercase fs-7" style="font-family: 'JetBrains Mono', monospace;">{{ $p->kode_produk }}</small>
                                    <h6 class="fw-bold mt-1 text-truncate product-name" title="{{ $p->nama_produk }}">{{ $p->nama_produk }}</h6>
                                    <h6 class="text-danger fw-bold my-2" style="font-family: 'JetBrains Mono', monospace; font-size: 1rem;">Rp {{ number_format($p->harga_jual_default, 0, ',', '.') }}</h6>

                                    <div class="mt-auto pt-2">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="small opacity-75">Stok Tersedia:</span>
                                            @if($p->stok_aktual <= 0)
                                                <span class="ent-badge badge-stock-empty">Habis</span>
                                            @else
                                                <span class="ent-badge badge-stock-ok" style="font-family: 'JetBrains Mono', monospace;">{{ $p->stok_aktual }} {{ $p->satuan }}</span>
                                            @endif
                                        </div>

                                        <button type="button" class="btn ent-btn ent-btn-primary w-100 py-2 btn-add-to-cart"
                                            data-id="{{ $p->id_produk }}"
                                            data-nama="{{ $p->nama_produk }}"
                                            data-harga="{{ $p->harga_jual_default }}"
                                            data-stok="{{ $p->stok_aktual }}"
                                            {{ $p->stok_aktual <= 0 ? 'disabled' : '' }}>
                                            <i class="fas fa-cart-plus me-1"></i> Beli Barang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5" id="original-empty-message">
                            <div class="opacity-75"><i class="fas fa-folder-open fa-3x mb-3 text-primary"></i><br>Belum ada produk aktif yang dijual oleh koperasi.</div>
                        </div>
                        @endforelse

                        <div class="col-12 text-center py-5 d-none" id="search-empty-message">
                            <div class="opacity-75"><i class="fas fa-search fa-3x mb-3 text-primary"></i><br>Produk yang kamu cari tidak ditemukan. Coba kata kunci lain!</div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN KANAN: PILIHAN ANGGOTA & RINGKASAN KERANJANG (4 COLUMNS) -->
                <div class="col-lg-4">
                    <div class="cart-sticky">

                        <!-- BOX PILIH IDENTITAS ANGGOTA (SELECT2 SEARCHABLE) -->
                        <div class="ent-card p-3 p-md-4 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label for="select-peserta" class="form-label ent-form-label mb-0"><i class="fas fa-user-check me-1 text-primary"></i> Pilih Anggota Pembeli:</label>
                                <button type="button" class="btn btn-sm ent-btn btn-outline-primary px-2 py-1" id="btn-view-history" style="font-size: 0.7rem;">
                                    <i class="fas fa-history me-1"></i> List Belanja
                                </button>
                            </div>
                            <select class="form-select ent-select py-2 fs-7" id="select-peserta" style="width: 100%;">
                                <option value="">-- Ketik NIP / Nama Anggota Koperasi --</option>
                                @foreach($peserta as $item)
                                <option value="{{ $item->id_kop_master_peserta }}">
                                    {{ $item->kop_master_peserta_nip }} - {{ $item->kop_master_peserta_name }} ({{ $item->kop_master_peserta_cabang }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- RINGKASAN KERANJANG BELANJA -->
                        <div class="ent-card p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center pb-3 mb-3" style="border-bottom: 1px solid var(--ent-grid-border);">
                                <h6 class="fw-bold mb-0"><i class="fas fa-shopping-cart me-2 text-primary"></i>Keranjang Saya</h6>
                                <span class="ent-badge" style="background: rgba(225, 29, 72, 0.16); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.35); font-family: 'JetBrains Mono', monospace;" id="cart-count-badge">0</span>
                            </div>

                            <!-- Kontainer Daftar Rincian Barang di Keranjang -->
                            <div id="cart-items-container" style="max-height: 210px; overflow-y: auto;" class="mb-3">
                                <p class="opacity-75 text-center py-4 small mb-0" id="cart-empty-text">Keranjang masih kosong. Silakan pilih produk di sebelah kiri.</p>
                            </div>

                            <!-- PILIHAN METODE PEMBAYARAN -->
                            <div class="pt-3 mb-3" id="payment-method-wrapper" style="border-top: 1px solid var(--ent-grid-border);">
                                <label class="form-label ent-form-label mb-2"><i class="fas fa-credit-card me-1 text-primary"></i> Pilih Metode Pembayaran:</label>

                                <div class="ent-pay-option form-check mb-2">
                                    <input class="form-check-input ms-0 me-2" type="radio" name="select_metode_bayar" id="pay-cash" value="CASH">
                                    <label class="form-check-label small d-block" for="pay-cash">
                                        <strong>CASH</strong>
                                        <div class="opacity-75 fs-7">Silahkan Langsung Bayar ke Bagian Bendahara.</div>
                                    </label>
                                </div>

                                <div class="ent-pay-option form-check mb-2">
                                    <input class="form-check-input ms-0 me-2" type="radio" name="select_metode_bayar" id="pay-tagihan" value="MASUK_TAGIHAN" checked>
                                    <label class="form-check-label small d-block" for="pay-tagihan">
                                        <strong>Masuk Tagihan Anggota</strong>
                                        <div class="opacity-75 fs-7">Akumulasi otomatis ke dalam lembar tagihan rutin koperasi bulanan Anda.</div>
                                    </label>
                                </div>

                                <div class="ent-pay-option form-check mb-2 opacity-50">
                                    <input class="form-check-input ms-0 me-2" type="radio" name="select_metode_bayar" id="pay-tf" value="TRANSFER_BANK" disabled>
                                    <label class="form-check-label small d-block" for="pay-tf">
                                        <strong>Transfer Bank Manual</strong>
                                        <div class="opacity-75 fs-7">Transfer langsung ke rekening bank resmi Koperasi (Verifikasi manual).</div>
                                    </label>
                                </div>

                                <div class="ent-pay-option form-check opacity-50">
                                    <input class="form-check-input ms-0 me-2" type="radio" name="select_metode_bayar" id="pay-va" value="VIRTUAL_ACCOUNT" disabled>
                                    <label class="form-check-label small d-block" for="pay-va">
                                        <strong>Virtual Account (Otomatis)</strong>
                                        <div class="opacity-75 fs-7">Konfirmasi instan menggunakan kode VA unik (Mandiri, BRI, BCA, BNI).</div>
                                    </label>
                                </div>
                            </div>

                            <!-- Total Harga Gabungan -->
                            <div class="pt-3" style="border-top: 1px solid var(--ent-grid-border);">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="fw-bold opacity-75 small text-uppercase">Total Tagihan:</span>
                                    <h5 class="fw-bold text-primary mb-0" id="cart-total-price" style="font-family: 'JetBrains Mono', monospace;">Rp 0</h5>
                                </div>
                                <div class="alert py-2 px-3 small rounded-3 mb-3" id="tenor-info-alert" style="background: rgba(79, 70, 229, 0.08); border: 1px solid var(--ent-grid-border); color: var(--ent-text);">
                                    <i class="fas fa-info-circle me-1 text-primary"></i> Transaksi menggunakan metode: <strong id="text-tenor-info">Masuk Tagihan Anggota</strong>.
                                </div>
                                <button type="button" class="btn ent-btn ent-btn-primary w-100 py-2" id="btn-checkout" disabled>
                                    <i class="fas fa-lock me-1"></i> Verifikasi Keamanan &amp; Ajukan
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- JS Dependencies -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 pada Pilih Anggota Pembeli
            $('#select-peserta').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: '-- Ketik NIP / Nama Anggota Koperasi --',
                allowClear: true,
                language: {
                    noResults: function() {
                        return 'Anggota koperasi tidak ditemukan';
                    },
                    searching: function() {
                        return 'Mencari anggota...';
                    }
                }
            });

            let internalCart = [];

            function formatRupiah(number) {
                return 'Rp ' + parseFloat(number).toLocaleString('id-ID');
            }

            // FILTER & PENCARIAN REALTIME (CLIENT-SIDE)
            function filterProducts() {
                let searchText = $('#search-product').val().toLowerCase().trim();
                let selectedCategory = $('.category-pill.active').data('category');
                let visibleCount = 0;

                $('.product-item').each(function() {
                    let productName = $(this).data('nama');
                    let productCategory = $(this).data('kategori');

                    let matchSearch = productName.includes(searchText);
                    let matchCategory = (selectedCategory === 'all' || productCategory === selectedCategory);

                    if (matchSearch && matchCategory) {
                        $(this).removeClass('d-none');
                        visibleCount++;
                    } else {
                        $(this).addClass('d-none');
                    }
                });

                if (visibleCount === 0 && $('.product-item').length > 0) {
                    $('#search-empty-message').removeClass('d-none');
                } else {
                    $('#search-empty-message').addClass('d-none');
                }

                if (searchText !== "" || selectedCategory !== "all") {
                    $('#search-status').text(`Menampilkan ${visibleCount} produk`);
                } else {
                    $('#search-status').text('');
                }
            }

            $('#search-product').on('keyup', function() {
                filterProducts();
            });

            $('.category-pill').on('click', function() {
                $('.category-pill').removeClass('active');
                $(this).addClass('active');
                filterProducts();
            });

            // Listener metode pembayaran
            $('input[name="select_metode_bayar"]').on('change', function() {
                let currentMethod = $(this).val();
                if (currentMethod === 'CASH') {
                    $('#text-tenor-info').text('CASH');
                } else if (currentMethod === 'MASUK_TAGIHAN') {
                    $('#text-tenor-info').text('Masuk Tagihan Anggota');
                } else if (currentMethod === 'TRANSFER_BANK') {
                    $('#text-tenor-info').text('Transfer Bank Manual');
                } else if (currentMethod === 'VIRTUAL_ACCOUNT') {
                    $('#text-tenor-info').text('Virtual Account (Otomatis)');
                }
            });

            // Klik Tombol Beli Barang
            $('.btn-add-to-cart').on('click', function() {
                let id = $(this).data('id');
                let nama = $(this).data('nama');
                let harga = parseFloat($(this).data('harga'));
                let maxStok = parseInt($(this).data('stok'));

                let existingItem = internalCart.find(item => item.id === id);

                if (existingItem) {
                    if (existingItem.qty >= maxStok) {
                        Swal.fire('Stok Terbatas', 'Jumlah pesanan tidak boleh melebihi sisa stok produk aktif.', 'warning');
                        return;
                    }
                    existingItem.qty += 1;
                } else {
                    internalCart.push({
                        id: id,
                        nama: nama,
                        harga: harga,
                        qty: 1,
                        maxStok: maxStok
                    });
                }

                renderKeranjangVisual();
            });

            // Menggambar UI Rincian item
            function renderKeranjangVisual() {
                if (internalCart.length === 0) {
                    $('#cart-empty-text').removeClass('d-none');
                    $('#cart-items-container .cart-item-row').remove();
                    $('#cart-count-badge').text('0');
                    $('#cart-total-price').text('Rp 0');
                    $('#btn-checkout').prop('disabled', true);
                    return;
                }

                $('#cart-empty-text').addClass('d-none');
                $('#cart-items-container .cart-item-row').remove();

                let totalBelanja = 0;
                let totalQtyItem = 0;

                internalCart.forEach(function(item, index) {
                    totalBelanja += (item.harga * item.qty);
                    totalQtyItem += item.qty;

                    let rowHtml = `
                    <div class="d-flex justify-content-between align-items-center p-2 rounded-3 mb-2 cart-item-row">
                        <div style="max-width: 62%;">
                            <span class="fw-bold d-block text-truncate small">${item.nama}</span>
                            <small class="text-danger fw-bold" style="font-family: 'JetBrains Mono', monospace;">${formatRupiah(item.harga)}</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 btn-change-qty" data-index="${index}" data-action="minus">-</button>
                            <span class="mx-2 fw-bold small" style="font-family: 'JetBrains Mono', monospace;">${item.qty}</span>
                            <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 btn-change-qty" data-index="${index}" data-action="plus">+</button>
                        </div>
                    </div>
                `;
                    $('#cart-items-container').append(rowHtml);
                });

                $('#cart-count-badge').text(totalQtyItem);
                $('#cart-total-price').text(formatRupiah(totalBelanja));
                $('#btn-checkout').prop('disabled', false);
            }

            // Handler Ubah Qty
            $(document).on('click', '.btn-change-qty', function() {
                let index = $(this).data('index');
                let action = $(this).data('action');
                let targetItem = internalCart[index];

                if (action === 'plus') {
                    if (targetItem.qty >= targetItem.maxStok) {
                        Swal.fire('Batas Maksimal', 'Pembelian tidak bisa melebihi persediaan fisik barang.', 'warning');
                        return;
                    }
                    targetItem.qty += 1;
                } else {
                    targetItem.qty -= 1;
                    if (targetItem.qty <= 0) {
                        internalCart.splice(index, 1);
                    }
                }
                renderKeranjangVisual();
            });

            // Action Checkout
            $('#btn-checkout').on('click', function() {
                let idPeserta = $('#select-peserta').val();
                let metodeTerpilih = $('input[name="select_metode_bayar"]:checked').val();
                let labelMetode = $('#text-tenor-info').text();

                if (!idPeserta) {
                    Swal.fire('Anggota Belum Dipilih', 'Silakan pilih Anggota Koperasi Pembeli terlebih dahulu pada dropdown di atas.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Verifikasi Keamanan Anggota',
                    text: `Metode: [${labelMetode}]. Masukkan 6 digit Kode Security Anggota terpilih untuk melakukan otorisasi transaksi:`,
                    input: 'password',
                    inputAttributes: {
                        autocapitalize: 'off',
                        autocorrect: 'off',
                        maxlength: 6,
                        placeholder: '******',
                        style: 'text-align: center; font-size: 24px; letter-spacing: 8px;'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    confirmButtonText: 'Konfirmasi Pembelian',
                    cancelButtonText: 'Batal',
                    inputValidator: (value) => {
                        if (!value || value.length < 6) {
                            return 'Kode security harus diisi lengkap 6 digit!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let secureCodeValue = result.value;

                        $.ajax({
                            url: "{{ route('shop.checkout') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                cart: internalCart,
                                id_kop_master_peserta: idPeserta,
                                metode_bayar: metodeTerpilih,
                                security_code: secureCodeValue
                            },
                            success: function(res) {
                                if (res.status === 'success') {
                                    Swal.fire({
                                        title: 'Transaksi Berhasil!',
                                        html: `${res.message}<br><br><b class="fs-4 text-primary p-2 rounded d-inline-block mt-2" style="font-family: 'JetBrains Mono', monospace; background: rgba(79,70,229,0.08); border: 1px solid rgba(79,70,229,0.28);">${res.nota}</b>`,
                                        icon: 'success'
                                    }).then(() => {
                                        internalCart = [];
                                        location.reload();
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Otorisasi Gagal', (xhr.responseJSON && xhr.responseJSON.message) || 'Kode security salah atau data tidak sesuai.', 'error');
                            }
                        });
                    }
                });
            });

            // Action Lihat List Belanja (History) Anggota
            $('#btn-view-history').on('click', function() {
                let idPeserta = $('#select-peserta').val();
                let namaPeserta = $("#select-peserta option:selected").text().trim();

                if (!idPeserta) {
                    Swal.fire('Anggota Belum Dipilih', 'Silakan pilih Anggota Koperasi terlebih dahulu untuk melihat list belanja.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Verifikasi Keamanan Riwayat',
                    text: `Masukkan 6 digit Kode Security untuk melihat list belanja dari: ${namaPeserta}`,
                    input: 'password',
                    inputAttributes: {
                        autocapitalize: 'off',
                        autocorrect: 'off',
                        maxlength: 6,
                        placeholder: '******',
                        style: 'text-align: center; font-size: 24px; letter-spacing: 8px;'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    confirmButtonText: 'Lihat List Belanja',
                    cancelButtonText: 'Batal',
                    inputValidator: (value) => {
                        if (!value || value.length < 6) {
                            return 'Kode security harus diisi lengkap 6 digit!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let secureCodeValue = result.value;

                        Swal.fire({
                            title: 'Mengambil Data...',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });

                        $.ajax({
                            url: "{{ route('shop.history') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id_kop_master_peserta: idPeserta,
                                security_code: secureCodeValue
                            },
                            success: function(res) {
                                if (res.status === 'success') {
                                    let listHtml = `<div class="text-start" style="max-height: 350px; overflow-y: auto;">`;

                                    if (res.data && res.data.length > 0) {
                                        listHtml += `<table class="table table-sm small table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nota / Tgl</th>
                                                    <th>Item Belanja</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
                                        res.data.forEach(function(nota) {
                                            listHtml += `<tr>
                                                <td>
                                                    <strong class="text-primary">${nota.no_nota}</strong><br>
                                                    <small class="text-muted">${nota.tanggal}</small>
                                                </td>
                                                <td>${nota.rincian_barang}</td>
                                                <td class="text-end fw-bold text-danger">${formatRupiah(nota.total_harga)}</td>
                                            </tr>`;
                                        });
                                        listHtml += `</tbody></table>`;
                                    } else {
                                        listHtml += `<div class="text-center py-3 text-muted"><i class="fas fa-receipt fa-2x mb-2"></i><br>Belum ada riwayat transaksi belanja.</div>`;
                                    }
                                    listHtml += `</div>`;

                                    Swal.fire({
                                        title: `List Belanja Anggota`,
                                        html: listHtml,
                                        icon: 'info',
                                        width: '600px',
                                        confirmButtonText: 'Tutup'
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal Membuka Riwayat', (xhr.responseJSON && xhr.responseJSON.message) || 'Kode security salah atau otorisasi gagal.', 'error');
                            }
                        });
                    }
                });
            });

        });
    </script>
</body>

</html>
