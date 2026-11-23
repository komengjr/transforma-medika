@extends('layouts.template')

@section('base.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />

    <style>
        /* =========================================
           MODERN ENTERPRISE UI STYLES
           (ADAPTIVE LIGHT & DARK MODE BOOTSTRAP 5)
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
            --ent-solid-bg: #ffffff;
            --ent-solid-text: #0f172a;
        }

        [data-bs-theme="dark"],
        .dark {
            --ent-solid-bg: #0f172a;
            --ent-solid-text: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .font-mono-code {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Adaptive Enterprise Card */
        .ent-card {
            border: 1px solid var(--ent-grid-border);
            border-radius: 16px;
            background-color: var(--bs-body-bg, var(--ent-solid-bg));
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .ent-card-header {
            background-color: rgba(79, 70, 229, 0.06) !important;
            border-bottom: 1px solid var(--ent-grid-border) !important;
            padding: 15px 20px;
        }

        /* Hero Banner */
        .ent-header-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
            border: 1px solid rgba(99, 102, 241, 0.35);
            border-radius: 18px;
            box-shadow: 0 14px 32px -8px rgba(15, 23, 42, 0.25);
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .ent-header-banner::before {
            content: '';
            position: absolute;
            top: -55%;
            right: -5%;
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.22) 0%, transparent 70%);
            pointer-events: none;
        }

        .ent-glass-pill {
            background: rgba(255, 255, 255, 0.09);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 12px;
            color: #ffffff;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--ent-grid-border) !important;
            border-radius: 10px !important;
            font-weight: 600 !important;
            color: var(--bs-body-color) !important;
            background-color: var(--bs-body-bg) !important;
            font-size: 0.82rem !important;
            min-height: 38px;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--ent-indigo) !important;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.14) !important;
        }

        /* Buttons */
        .ent-btn {
            font-weight: 600 !important;
            border-radius: 10px;
            transition: all 0.18s ease;
            letter-spacing: 0.01em;
            cursor: pointer;
            font-size: 0.84rem;
        }

        .ent-btn:hover {
            transform: translateY(-1px);
        }

        .ent-btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            border: none;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.28);
        }

        .ent-btn-primary:hover {
            box-shadow: 0 6px 18px rgba(79, 70, 229, 0.4);
            color: #ffffff;
        }

        .ent-btn-light {
            background-color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.35);
            color: #0f172a;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.18);
        }

        .ent-btn-light:hover {
            background-color: #f8fafc;
            color: #0f172a;
        }

        /* Icon Box */
        .icon-shape-sm {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            flex-shrink: 0;
        }

        .icon-shape-md {
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            flex-shrink: 0;
        }

        /* Pulse Badge */
        .pulse-badge {
            display: inline-block;
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
            animation: pulse 1.6s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
            }

            70% {
                transform: scale(1.12);
            }

            100% {
                transform: scale(0.95);
            }
        }

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

        .ent-table thead th {
            background-color: rgba(79, 70, 229, 0.06) !important;
            border-bottom: 1px solid var(--ent-grid-border) !important;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .ent-table tbody td {
            border-bottom-color: var(--ent-grid-border) !important;
            font-size: 0.84rem;
        }

        .ent-modal-content {
            border: 1px solid var(--ent-grid-border);
            border-radius: 18px;
            background-color: var(--bs-body-bg, var(--ent-solid-bg));
            box-shadow: 0 24px 48px -12px rgba(15, 23, 42, 0.25);
            overflow: hidden;
        }

        .sub-menu-list {
            margin: 0;
            padding-left: 1.1rem;
            font-size: 0.8rem;
        }

        .sub-menu-list li {
            margin-bottom: 2px;
        }

        /* Sembunyikan search bawaan DataTables karena sudah ada di header card */
        div.dt-container .dt-search {
            display: none;
        }

        div.dt-container .dt-length,
        div.dt-container .dt-info,
        div.dt-container .dt-paging {
            padding: 12px 20px;
            font-size: 0.8rem;
        }
    </style>
@endsection

@section('content')
    @php
        $totalMenu = count($data);
        $totalSubMenu = DB::table('z_menu_sub_main')->count();
    @endphp

    <!-- Hero / Welcome Banner Master Menu -->
    <div class="card mb-3 ent-header-banner p-1">
        <div class="card-body position-relative p-4" style="z-index: 2;">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8">
                    <div class="ent-glass-pill d-inline-flex align-items-center rounded-pill px-3 py-1 mb-2">
                        <span class="pulse-badge me-2"></span>
                        <small class="fw-semibold" style="font-size: 0.78rem; color: #cbd5e1;">
                            Innoventra Management System &bull; Navigasi &amp; Hak Akses
                        </small>
                    </div>

                    <h2 class="fw-bold mb-1" style="letter-spacing: -0.02em; color: #ffffff;">
                        Master Menu
                    </h2>
                    <p class="mb-0" style="color: #cbd5e1; font-size: 0.88rem; line-height: 1.6;">
                        Kelola struktur menu utama, tautan rute modul, opsi konfigurasi, ikon, dan daftar sub menu aplikasi.
                    </p>
                </div>

                <div class="col-lg-4 d-flex flex-wrap justify-content-lg-end gap-2">
                    <button type="button" class="btn ent-btn ent-btn-light px-4 py-2" data-bs-toggle="modal"
                        data-bs-target="#modal-menu" id="button-tambah-data-menu" data-code="123">
                        <i class="fas fa-plus-circle me-2 text-primary"></i> Tambah Menu
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Cards Ringkasan -->
    <div class="row g-3 g-md-4 mb-3">
        <div class="col-sm-6 col-xl-4">
            <div class="ent-card h-100 p-3" style="border-left: 4px solid var(--ent-indigo) !important;">
                <div class="d-flex align-items-center">
                    <div class="icon-shape-md me-3"
                        style="background-color: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.3);">
                        <i class="fas fa-sitemap fs-4"></i>
                    </div>
                    <div>
                        <span class="opacity-75 fw-semibold d-block" style="font-size: 0.72rem; text-transform: uppercase;">
                            Total Menu Utama
                        </span>
                        <h5 class="fw-bold mb-0 font-mono-code" style="font-size: 1.1rem;">{{ $totalMenu }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="ent-card h-100 p-3" style="border-left: 4px solid var(--ent-sky) !important;">
                <div class="d-flex align-items-center">
                    <div class="icon-shape-md me-3"
                        style="background-color: rgba(2, 132, 199, 0.14); color: #0ea5e9; border: 1px solid rgba(2, 132, 199, 0.3);">
                        <i class="fas fa-layer-group fs-4"></i>
                    </div>
                    <div>
                        <span class="opacity-75 fw-semibold d-block" style="font-size: 0.72rem; text-transform: uppercase;">
                            Total Sub Menu
                        </span>
                        <h5 class="fw-bold mb-0 font-mono-code" style="font-size: 1.1rem;">{{ $totalSubMenu }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-xl-4">
            <div class="ent-card h-100 p-3" style="border-left: 4px solid var(--ent-emerald) !important;">
                <div class="d-flex align-items-center">
                    <div class="icon-shape-md me-3"
                        style="background-color: rgba(5, 150, 105, 0.14); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.3);">
                        <i class="fas fa-shield-alt fs-4"></i>
                    </div>
                    <div>
                        <span class="opacity-75 fw-semibold d-block" style="font-size: 0.72rem; text-transform: uppercase;">
                            Status Konfigurasi
                        </span>
                        <div class="d-flex align-items-center gap-2">
                            <h5 class="fw-bold mb-0" style="font-size: 1rem;">Aktif</h5>
                            <span class="ent-badge"
                                style="background-color: rgba(5, 150, 105, 0.14); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.3);">
                                Tersinkron
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Tabel Master Menu -->
    <div class="ent-card mb-3">
        <div class="ent-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                <span class="icon-shape-sm" style="background-color: rgba(79, 70, 229, 0.14); color: #6366f1;">
                    <i class="fas fa-list-ul"></i>
                </span>
                Daftar Master Menu
            </h6>

            <div class="d-flex flex-wrap align-items-center gap-2">
                <input type="text" id="menuSearchInput" class="form-control" style="max-width: 240px;"
                    placeholder="Cari nama menu, link, sub menu...">
                <div class="btn-group" role="group">
                    <button class="btn ent-btn ent-btn-primary px-3 py-1 dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-sliders-h me-1"></i> Option
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow"
                        style="border-radius: 12px; border: 1px solid var(--ent-grid-border);">
                        <li>
                            <button type="button" class="dropdown-item fw-semibold" style="font-size: 0.82rem;"
                                data-bs-toggle="modal" data-bs-target="#modal-menu" id="button-tambah-data-menu-dropdown"
                                data-code="123">
                                <i class="fas fa-plus me-2 text-primary"></i>Tambah Menu
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="example" class="table table-hover align-middle mb-0 ent-table nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="py-3 ps-4" style="width: 60px;">No</th>
                            <th class="py-3">Nama Menu</th>
                            <th class="py-3">Link Menu</th>
                            <th class="py-3">Option Menu</th>
                            <th class="py-3">Sub Menu</th>
                            <th class="py-3">Icon Menu</th>
                            <th class="py-3 pe-4 text-end" style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $datas)
                            @php
                                $cek = DB::table('z_menu_sub_main')
                                    ->where('menu_sub_code', $datas->menu_sub_code)
                                    ->get();
                            @endphp
                            <tr>
                                <td class="ps-4 fw-bold font-mono-code">{{ $no++ }}</td>
                                <td>
                                    <div class="fw-bold">{{ $datas->menu_sub_name }}</div>
                                    <div class="opacity-75 font-mono-code" style="font-size: 0.72rem;">
                                        {{ $datas->menu_sub_code }}
                                    </div>
                                </td>
                                <td>
                                    @if (!empty($datas->menu_sub_link))
                                        <span class="ent-badge font-mono-code text-lowercase"
                                            style="background-color: rgba(2, 132, 199, 0.12); color: #0ea5e9; border: 1px solid rgba(2, 132, 199, 0.3);">
                                            {{ $datas->menu_sub_link }}
                                        </span>
                                    @else
                                        <span class="opacity-50 fst-italic" style="font-size: 0.78rem;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($datas->menu_sub_option))
                                        <span class="ent-badge"
                                            style="background-color: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.3);">
                                            {{ $datas->menu_sub_option }}
                                        </span>
                                    @else
                                        <span class="opacity-50" style="font-size: 0.78rem;">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($cek->count() > 0)
                                        <ul class="sub-menu-list">
                                            @foreach ($cek as $ceks)
                                                <li>{{ $ceks->menu_main_sub_name }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="ent-badge"
                                            style="background-color: rgba(100, 116, 139, 0.14); color: #94a3b8; border: 1px solid rgba(100, 116, 139, 0.28);">
                                            Tidak ada sub menu
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($datas->menu_sub_icon))
                                        <div class="d-inline-flex align-items-center gap-2">
                                            <span class="icon-shape-sm"
                                                style="background-color: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.28);">
                                                <i class="{{ $datas->menu_sub_icon }}"></i>
                                            </span>
                                            <span class="opacity-75 font-mono-code" style="font-size: 0.76rem;">
                                                {{ $datas->menu_sub_icon }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="opacity-50" style="font-size: 0.78rem;">-</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="btn-group" role="group">
                                        <button class="btn ent-btn px-3 py-1 dropdown-toggle"
                                            style="background-color: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3);"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-align-left me-1"></i>Option
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow"
                                            style="border-radius: 12px; border: 1px solid var(--ent-grid-border);">
                                            <li>
                                                <button type="button"
                                                    class="dropdown-item fw-semibold button-update-data-menu"
                                                    style="font-size: 0.82rem;" data-bs-toggle="modal"
                                                    data-bs-target="#modal-menu" data-code="{{ $datas->menu_sub_code }}">
                                                    <i class="fas fa-edit me-2 text-primary"></i>Update Menu
                                                </button>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <button type="button"
                                                    class="dropdown-item text-danger fw-semibold button-remove-data-menu"
                                                    style="font-size: 0.82rem;" data-code="{{ $datas->menu_sub_code }}">
                                                    <i class="fas fa-trash me-2"></i>Remove
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('base.js')
    <div class="modal fade" id="modal-menu" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content ent-modal-content">
                <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-menu"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            const table = new DataTable('#example', {
                responsive: true
            });

            // Hubungkan input pencarian di header card dengan DataTables
            $('#menuSearchInput').on('input keyup', function() {
                table.search(this.value).draw();
            });

            function modalSpinner() {
                return `
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="opacity-75 mt-2 mb-0" style="font-size: 0.84rem;">Memuat form menu...</p>
                    </div>
                `;
            }

            $(document).on("click", "#button-tambah-data-menu, #button-tambah-data-menu-dropdown", function(e) {
                e.preventDefault();
                var code = $(this).data("code");
                $('#menu-menu').html(modalSpinner());
                $.ajax({
                    url: "{{ route('master_menu_add') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code
                    },
                    dataType: 'html',
                }).done(function(data) {
                    $('#menu-menu').html(data);
                }).fail(function() {
                    $('#menu-menu').html('<div class="p-4 text-center text-danger">Gagal memuat data.</div>');
                });
            });

            $(document).on("click", ".button-update-data-menu", function(e) {
                e.preventDefault();
                var code = $(this).data("code");
                $('#menu-menu').html(modalSpinner());
                $.ajax({
                    url: "{{ route('master_menu_update') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code
                    },
                    dataType: 'html',
                }).done(function(data) {
                    $('#menu-menu').html(data);
                }).fail(function() {
                    $('#menu-menu').html('<div class="p-4 text-center text-danger">Gagal memuat data.</div>');
                });
            });
        });
    </script>
@endsection
