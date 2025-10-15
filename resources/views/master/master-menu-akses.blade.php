@extends('layouts.template')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="card bg-100 shadow-none border">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3" src="{{ asset('img/app.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-primary fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-primary fw-bold mb-1">Innoventra <span class="text-info fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-primary fs--1 mb-0">Menu : </h6>
                        <h4 class="text-primary fw-bold mb-0">Master <span class="text-info fw-medium">Menu Akses</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-primary">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Master Menu Akses</span></h3>
                </div>
                <div class="col-auto">

                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Option</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-menu"
                                id="button-tambah-data-access" data-code="123"><span class="far fa-plus"></span>
                                Tambah Akses</button>
                            {{-- <div class="dropdown-divider"></div>
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                id="button-data-barang-cabang" data-code="123"><span class="far fa-folder-open"></span>
                                History</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border-top p-3">
            <table id="example" class="table table-striped nowrap" style="width:100%">
                <thead class="bg-200 text-700">
                    <tr>
                        <th>No</th>
                        <th>Nama Akses</th>
                        <th>Super Menu</th>
                        <th>Link Menu</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $datas->master_access_name }}</td>
                            <td>
                                @php
                                    $super = DB::table('z_menu_user_super')
                                        ->join('z_menu_super', 'z_menu_super.menu_super_code', '=', 'z_menu_user_super.menu_super_code')
                                        ->where('z_menu_user_super.access_code', $datas->master_access_code)->get();
                                @endphp
                                @foreach ($super as $supers)
                                    <li>{{ $supers->menu_super_name }}</li>
                                @endforeach
                            </td>
                            <td>
                                @php
                                    $menu = DB::table('z_menu_user')
                                        ->join('z_menu_sub', 'z_menu_sub.menu_sub_code', '=', 'z_menu_user.menu_sub_code')
                                        ->join('z_menu', 'z_menu.menu_code', '=', 'z_menu_sub.menu_code')
                                        ->where('z_menu_user.access_code', $datas->master_access_code)->get();
                                @endphp
                                @foreach ($menu as $menus)
                                    <li><strong class="text-primary">{{ $menus->menu_name }}</strong>
                                        <small>{{ $menus->menu_sub_name }}</small></li>
                                    @php
                                        $sub = DB::table('z_menu_user_sub')
                                            ->join('z_menu_sub_main', 'z_menu_sub_main.menu_main_sub_code', '=', 'z_menu_user_sub.menu_main_sub_code')
                                            ->join('z_menu_sub', 'z_menu_sub.menu_sub_code', '=', 'z_menu_sub_main.menu_sub_code')
                                            ->where('z_menu_sub.menu_sub_code', $menus->menu_sub_code)
                                            ->where('z_menu_user_sub.access_code', $datas->master_access_code)->get();
                                    @endphp
                                    @foreach ($sub as $subs)
                                        <li class="ms-3">{{ $subs->menu_main_sub_name }}</li>
                                    @endforeach
                                @endforeach
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Option</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-menu"
                                            id="button-setup-super-menu" data-code="{{ $datas->master_access_code }}"><span
                                                class="far fa-plus"></span>
                                            Setup Super Menu</button>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-menu"
                                            id="button-setup-sub-menu" data-code="{{ $datas->master_access_code }}"><span
                                                class="far fa-folder-open"></span>
                                            Setup sub Menu</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('base.js')
    <div class="modal fade" id="modal-menu" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
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
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    <script>
        $(document).on("click", "#button-tambah-data-access", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-menu').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('master_menu_akses_add') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-menu').html(data);
            }).fail(function () {
                $('#menu-menu').html('eror');
            });
        });
        $(document).on("click", "#button-setup-super-menu", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-menu').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('master_menu_akses_setup_super_menu') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-menu').html(data);
            }).fail(function () {
                $('#menu-menu').html('eror');
            });
        });
        $(document).on("click", "#button-pilih-akses", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            var id = $(this).data("id");
            $('#menu-menu').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
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
            }).done(function (data) {
                location.reload();
            }).fail(function () {
                $('#menu-menu').html('eror');
            });
        });
        $(document).on("click", "#button-setup-sub-menu", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-menu').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('master_menu_akses_setup_sub_menu') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-menu').html(data);
            }).fail(function () {
                $('#menu-menu').html('eror');
            });
        });
        $(document).on("click", "#button-update-menu", function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            var code = $(this).data("code");
            $('#table-menu-akses').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
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
            }).done(function (data) {
                $('#table-menu-akses').html(data);
            }).fail(function () {
                $('#table-menu-akses').html('eror');
            });
        });
        $(document).on("click", "#button-update-sub-menu", function (e) {
            e.preventDefault();
            var id = $(this).data("id");
            var code = $(this).data("code");
            $('#table-menu-akses').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
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
            }).done(function (data) {
                $('#table-menu-akses').html(data);
            }).fail(function () {
                $('#table-menu-akses').html('eror');
            });
        });

    </script>
@endsection
