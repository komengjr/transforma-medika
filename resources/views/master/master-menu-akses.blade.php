@extends('layouts.template')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
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
        --ent-subtle-surface: #f8fafc;
        --ent-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-surface: #0f172a;
        --ent-subtle-surface: #1e293b;
        --ent-text: #f8fafc;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Header Banner */
    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 16px;
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.22);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 320px;
        height: 320px;
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

    /* Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.07) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 14px 20px;
    }

    /* Badges & Chips */
    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    .code-chip {
        font-family: 'JetBrains Mono', monospace;
        background-color: rgba(79, 70, 229, 0.1);
        color: #4338ca;
        border: 1px solid rgba(79, 70, 229, 0.25);
        padding: 2px 7px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.72rem;
        display: inline-block;
    }

    [data-bs-theme="dark"] .code-chip,
    .dark .code-chip {
        background-color: rgba(129, 140, 248, 0.16);
        color: #a5b4fc;
        border-color: rgba(129, 140, 248, 0.32);
    }

    .access-icon-badge {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.16) 0%, rgba(2, 132, 199, 0.16) 100%);
        border: 1px solid var(--ent-grid-border);
        color: var(--ent-indigo);
        font-weight: 800;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    [data-bs-theme="dark"] .access-icon-badge,
    .dark .access-icon-badge {
        color: #a5b4fc;
    }

    .menu-tree-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }

    .menu-tree-group {
        border: 1px solid var(--ent-grid-border);
        background-color: rgba(79, 70, 229, 0.03);
        border-radius: 10px;
        padding: 7px 10px;
        margin-bottom: 6px;
    }

    .menu-tree-group:last-child {
        margin-bottom: 0;
    }

    .menu-sub-item {
        font-size: 0.77rem;
        padding-left: 14px;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .menu-main-sub-item {
        font-size: 0.74rem;
        padding-left: 28px;
        margin-top: 2px;
        opacity: 0.88;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        font-size: 0.8rem;
        cursor: pointer;
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
        color: #ffffff;
    }

    .ent-btn-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.25);
    }

    .ent-btn-warning:hover:not(:disabled) {
        color: #ffffff;
    }

    .ent-btn-light {
        background-color: var(--bs-body-bg, var(--ent-surface));
        border: 1px solid var(--ent-grid-border);
        color: var(--bs-body-color, var(--ent-text));
    }

    /* Dropdown Menu */
    .ent-dropdown-menu {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 6px;
        box-shadow: 0 12px 24px -6px rgba(15, 23, 42, 0.18);
        background-color: var(--bs-body-bg, var(--ent-surface));
        z-index: 1055;
    }

    .ent-dropdown-menu .dropdown-item {
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 8px 12px;
        color: var(--bs-body-color, var(--ent-text));
    }

    .ent-dropdown-menu .dropdown-item:hover {
        background-color: rgba(79, 70, 229, 0.1);
        color: var(--ent-indigo);
    }

    /* Table Styling */
    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
        font-size: 0.83rem;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid var(--ent-grid-border) !important;
        border-bottom: 2px solid rgba(79, 70, 229, 0.45) !important;
        padding: 12px;
        letter-spacing: 0.04em;
    }

    .table-custom tbody tr {
        transition: background-color 0.15s ease;
    }

    .table-custom tbody tr:hover,
    .table-custom tbody tr:hover td {
        background-color: rgba(79, 70, 229, 0.05) !important;
    }

    .table-custom td {
        border: 1px solid var(--ent-grid-border) !important;
        font-weight: 500;
        color: var(--bs-body-color, var(--ent-text)) !important;
        padding: 10px 12px;
        vertical-align: top;
        font-size: 0.83rem;
    }

    /* DataTables Controls Spacing */
    div.dt-container .dt-length select,
    div.dt-container .dt-search input {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 9px !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color, var(--ent-text)) !important;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 5px 10px;
    }

    div.dt-container .dt-paging .page-link {
        border-radius: 8px !important;
        border-color: var(--ent-grid-border);
        font-size: 0.8rem;
        font-weight: 600;
    }

    div.dt-container .dt-paging .page-item.active .page-link {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border-color: #4f46e5;
        color: #ffffff;
    }

    /* Modal Styling */
    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        background-color: var(--bs-body-bg, var(--ent-surface)) !important;
        color: var(--bs-body-color, var(--ent-text));
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<!-- HERO BANNER HEADER -->
<header class="mb-3">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width: 58px; height: 58px;">
                        <img src="{{ asset('img/app.png') }}" alt="App Icon" width="38" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                <i class="fas fa-user-shield"></i> INNOVENTRA MANAGEMENT SYSTEM
                            </span>
                            <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Menu: Master Menu Akses</span>
                        </div>
                        <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: white;">
                            Master Menu Akses &amp; Otoritas Modul
                        </h4>
                        <p class="mb-0 small" style="color: #cbd5e1;">Atur hak akses role pengguna terhadap Super Menu, Menu Utama, dan Sub-Menu aplikasi.</p>
                    </div>
                </div>

                <div class="col-lg-4 text-lg-end d-flex flex-wrap align-items-center justify-content-lg-end gap-2">
                    <div class="ent-glass-pill px-3 py-2 text-start">
                        <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.58rem;">Total Akses</span>
                        <span class="fw-bold" style="color: #7dd3fc; font-family: 'JetBrains Mono', monospace;">{{ count($data) }}</span>
                    </div>
                    <button type="button" class="btn ent-btn ent-btn-warning px-3 py-2"
                        data-bs-toggle="modal" data-bs-target="#modal-menu"
                        id="button-tambah-data-access" data-code="123">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Akses
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- MAIN TABLE CARD -->
<main>
    <div class="ent-card mb-3">
        <div class="ent-card-header">
            <div class="row align-items-center gy-2">
                <div class="col">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-key me-2 text-primary"></i>Daftar Role &amp; Hak Akses Menu
                    </h6>
                    <small class="opacity-75">Rincian Super Menu dan struktur Link Menu yang aktif per level akses.</small>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm ent-btn ent-btn-light dropdown-toggle px-3 py-2"
                            id="btnGroupHeaderMenuAkses" type="button" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-sliders-h me-1 text-primary"></i> Option
                        </button>
                        <div class="dropdown-menu dropdown-menu-end ent-dropdown-menu" aria-labelledby="btnGroupHeaderMenuAkses">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-menu"
                                id="button-tambah-data-access-menu" data-code="123">
                                <i class="fas fa-plus-circle me-2 text-primary"></i> Tambah Akses
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-3 p-md-4">
            <div class="table-responsive">
                <table id="example" class="table table-custom nowrap w-100">
                    <thead>
                        <tr>
                            <th style="width: 55px;" class="text-center">No</th>
                            <th style="width: 190px;">Nama Akses</th>
                            <th style="width: 210px;">Super Menu</th>
                            <th>Link Menu</th>
                            <th style="width: 120px;" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $no = 1;
                        @endphp
                        @foreach ($data as $datas)
                        @php
                        $super = DB::table('z_menu_user_super')
                        ->join('z_menu_super', 'z_menu_super.menu_super_code', '=', 'z_menu_user_super.menu_super_code')
                        ->where('z_menu_user_super.access_code', $datas->master_access_code)
                        ->get();

                        $menu = DB::table('z_menu_user')
                        ->join('z_menu_sub', 'z_menu_sub.menu_sub_code', '=', 'z_menu_user.menu_sub_code')
                        ->join('z_menu', 'z_menu.menu_code', '=', 'z_menu_sub.menu_code')
                        ->where('z_menu_user.access_code', $datas->master_access_code)
                        ->get();

                        $groupedMenus = $menu->groupBy('menu_code');
                        @endphp
                        <tr>
                            <td class="text-center fw-bold" style="font-family: 'JetBrains Mono', monospace;">{{ $no++ }}</td>
                            <td>
                                <div class="d-flex align-items-start gap-2">
                                    <span class="access-icon-badge">
                                        <i class="fas fa-user-tag"></i>
                                    </span>
                                    <div>
                                        <div class="fw-bold">{{ $datas->master_access_name }}</div>
                                        @if (!empty($datas->master_access_code))
                                        <span class="code-chip mt-1">{{ $datas->master_access_code }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($super->count() > 0)
                                <div class="d-flex flex-column gap-1">
                                    @foreach ($super as $supers)
                                    <span class="ent-badge justify-content-start" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.28);">
                                        <i class="fas fa-layer-group"></i> {{ $supers->menu_super_name }}
                                    </span>
                                    @endforeach
                                </div>
                                @else
                                <span class="opacity-50 small fst-italic">Belum ada super menu</span>
                                @endif
                            </td>
                            <td>
                                @if ($groupedMenus->count() > 0)
                                <ul class="menu-tree-list">
                                    @foreach ($groupedMenus as $menuCode => $menuItems)
                                    @php
                                    $firstMenu = $menuItems->first();
                                    @endphp
                                    <li class="menu-tree-group">
                                        <div class="fw-bold text-primary small">
                                            <i class="fas fa-folder-open me-1"></i>{{ $firstMenu->menu_name }}
                                        </div>
                                        @foreach ($menuItems as $menus)
                                        <div class="menu-sub-item">
                                            <i class="fas fa-angle-right text-info"></i>
                                            <span class="fw-semibold">{{ $menus->menu_sub_name }}</span>
                                        </div>
                                        @php
                                        $sub = DB::table('z_menu_user_sub')
                                        ->join('z_menu_sub_main', 'z_menu_sub_main.menu_main_sub_code', '=', 'z_menu_user_sub.menu_main_sub_code')
                                        ->join('z_menu_sub', 'z_menu_sub.menu_sub_code', '=', 'z_menu_sub_main.menu_sub_code')
                                        ->where('z_menu_sub.menu_sub_code', $menus->menu_sub_code)
                                        ->where('z_menu_user_sub.access_code', $datas->master_access_code)
                                        ->get();
                                        @endphp
                                        @foreach ($sub as $subs)
                                        <div class="menu-main-sub-item">
                                            <i class="fas fa-minus opacity-50" style="font-size: 0.65rem;"></i>
                                            <span>{{ $subs->menu_main_sub_name }}</span>
                                        </div>
                                        @endforeach
                                        @endforeach
                                    </li>
                                    @endforeach
                                </ul>
                                @else
                                <span class="opacity-50 small fst-italic">Belum ada link menu aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm ent-btn ent-btn-light dropdown-toggle px-2 py-1"
                                        id="btnGroupRowMenuAkses{{ $no }}" type="button" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog me-1 text-primary"></i> Option
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end ent-dropdown-menu" aria-labelledby="btnGroupRowMenuAkses{{ $no }}">
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-menu"
                                            id="button-setup-super-menu" data-code="{{ $datas->master_access_code }}">
                                            <i class="fas fa-plus-circle me-2 text-primary"></i> Setup Super Menu
                                        </button>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-menu"
                                            id="button-setup-sub-menu" data-code="{{ $datas->master_access_code }}">
                                            <i class="fas fa-sitemap me-2 text-info"></i> Setup sub Menu
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

@section('base.js')
<div class="modal fade" id="modal-menu" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 5;">
                <button class="btn-close btn btn-sm btn-circle d-flex align-items-center justify-content-center"
                    data-bs-dismiss="modal" aria-label="Close"></button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const menuAjaxLoader =
        '<div class="py-5 text-center">' +
        '<div class="spinner-border text-primary mb-2" role="status"><span class="visually-hidden">Loading...</span></div>' +
        '<div class="small fw-semibold opacity-75">Memuat data pengaturan akses...</div>' +
        '</div>';

    const menuAjaxError =
        '<div class="p-4 text-center text-danger fw-bold">' +
        '<i class="fas fa-exclamation-triangle me-1"></i> Gagal memuat data pengaturan akses.' +
        '</div>';

    document.addEventListener("DOMContentLoaded", function() {
        new DataTable('#example', {
            responsive: true,
            pageLength: 10,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ akses",
                infoEmpty: "Tidak ada data akses",
                zeroRecords: "Data akses tidak ditemukan",
                emptyTable: "Belum ada data akses terdaftar"
            }
        });
    });

    $(document).on("click", "#button-tambah-data-access, #button-tambah-data-access-menu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-menu').html(menuAjaxLoader);
        $.ajax({
            url: "{{ route('master_menu_akses_add') }}",
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
            $('#menu-menu').html(menuAjaxError);
        });
    });

    $(document).on("click", "#button-setup-super-menu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-menu').html(menuAjaxLoader);
        $.ajax({
            url: "{{ route('master_menu_akses_setup_super_menu') }}",
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
            $('#menu-menu').html(menuAjaxError);
        });
    });

    $(document).on("click", "#button-pilih-akses", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var id = $(this).data("id");
        $('#menu-menu').html(menuAjaxLoader);
        $.ajax({
            url: "{{ route('master_menu_akses_update_akses_super_menu') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "code": code,
            },
            dataType: 'html',
        }).done(function() {
            location.reload();
        }).fail(function() {
            $('#menu-menu').html(menuAjaxError);
        });
    });

    $(document).on("click", "#button-setup-sub-menu", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-menu').html(menuAjaxLoader);
        $.ajax({
            url: "{{ route('master_menu_akses_setup_sub_menu') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-menu').html(data);
        }).fail(function() {
            $('#menu-menu').html(menuAjaxError);
        });
    });

    $(document).on("click", "#button-update-menu", function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var code = $(this).data("code");
        $('#table-menu-akses').html(menuAjaxLoader);
        $.ajax({
            url: "{{ route('master_menu_akses_update_menu') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#table-menu-akses').html(data);
        }).fail(function() {
            $('#table-menu-akses').html(menuAjaxError);
        });
    });

    $(document).on("click", "#button-update-sub-menu", function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var code = $(this).data("code");
        $('#table-menu-akses').html(menuAjaxLoader);
        $.ajax({
            url: "{{ route('master_menu_akses_update_sub_menu') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#table-menu-akses').html(data);
        }).fail(function() {
            $('#table-menu-akses').html(menuAjaxError);
        });
    });
</script>
@endsection
