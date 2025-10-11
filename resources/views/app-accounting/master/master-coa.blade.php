@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row mb-3 ">
        <div class="col">
            <div class="card bg-200 shadow border border-primary bg-primary">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/profit.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-white fs--1 mb-0 pt-2" style="color: white !important;">Welcome to </h6>
                            <h4 class="text-white fw-bold mb-1" style="color: white !important;">Trans <span
                                    class="text-white fw-medium" style="color: white !important;">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-white fs--1 mb-0" style="color: white !important;">Menu : </h6>
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Master<span
                                class="text-white fw-medium" style="color: white !important;"> COA</span>
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
                    <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Chart Of Account : {{ $total }} Accounts</span></h3>
                </div>
                <div class="col-auto">
                </div>
            </div>
        </div>
        <div class="card-body border-top p-3 fs-1">
            <ul class="treeview treeview-stripe" id="treeviewStriped" data-options='{"striped":true}'>
                <!-- TINGKAT MASTER  -->
                @foreach ($data as $datas)
                    <li class="treeview-list-item">
                        <a data-bs-toggle="collapse" href="#treeviewStriped-1-{{$datas->id_acc_master_coa}}" role="button"
                            aria-expanded="false">
                            <p class="treeview-text">
                                <span class="text-warning me-2">{{$datas->acc_master_coa_no}}. </span> {{$datas->acc_master_coa_name}}
                            </p>
                        </a>
                        <ul class="collapse treeview-list" id="treeviewStriped-1-{{$datas->id_acc_master_coa}}"
                            data-show="true">
                            @php
                                $sub = DB::table('acc_master_coa_data')
                                    ->where('acc_master_coa_code', $datas->acc_master_coa_code)
                                    ->where('acc_coa_data_level', 1)
                                    ->get();
                                $no = 1;
                            @endphp
                            <!-- TINGKAT 1 START -->
                            @foreach ($sub as $subs)
                                @if ($subs->acc_coa_data_opt == 1)
                                    <li class="treeview-list-item">
                                        <a data-bs-toggle="collapse" href="#treeviewStriped-2-{{$subs->id_acc_master_coa_data}}" oncontextmenu="myFunction('{{$subs->acc_coa_data_code}}'); return false;"
                                            role="button" aria-expanded="false">
                                            <p class="treeview-text">
                                                <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no++ }}</span> {{$subs->acc_coa_data_name}}
                                            </p>
                                        </a>
                                        <ul class="collapse treeview-list" id="treeviewStriped-2-{{$subs->id_acc_master_coa_data}}"
                                            data-show="true">
                                            @php
                                                $sub1 = DB::table('acc_master_coa_data')
                                                    ->where('acc_master_coa_code', $subs->acc_coa_data_code)
                                                    ->where('acc_coa_data_level', 2)
                                                    ->get();
                                                $no1 = 1;
                                            @endphp
                                            <!-- TINGKAT 2 -->
                                            @foreach ($sub1 as $subs1)
                                                @if ($subs1->acc_coa_data_opt == 1)
                                                    <div class="treeview-row treeview-row-even"></div>
                                                    <li class="treeview-list-item">
                                                        <a data-bs-toggle="collapse" href="#treeviewStriped-2-{{$subs1->id_acc_master_coa_data}}" role="button" oncontextmenu="myFunction('{{$subs1->acc_coa_data_code}}'); return false;"
                                                            aria-expanded="false">
                                                            <p class="treeview-text">
                                                                <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1++ }}</span> {{$subs1->acc_coa_data_name}}
                                                            </p>
                                                        </a>
                                                        <ul class="collapse treeview-list" id="treeviewStriped-2-{{$subs1->id_acc_master_coa_data}}" data-show="true">
                                                            @php
                                                                $sub2 = DB::table('acc_master_coa_data')
                                                                    ->where('acc_master_coa_code', $subs1->acc_coa_data_code)
                                                                    ->where('acc_coa_data_level', 3)
                                                                    ->get();
                                                                $no2 = 1;
                                                            @endphp
                                                            <!-- TINGKAT 3 -->
                                                            @foreach ($sub2 as $subs2)
                                                                @if ($subs2->acc_coa_data_opt == 1)
                                                                    <li class="treeview-list-item">
                                                                        <a data-bs-toggle="collapse" href="#treeviewStriped-3-{{$subs2->id_acc_master_coa_data}}" role="button" oncontextmenu="myFunction('{{$subs2->acc_coa_data_code}}'); return false;"
                                                                            aria-expanded="false">
                                                                            <p class="treeview-text">
                                                                                <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2++ }}</span> {{$subs2->acc_coa_data_name}}
                                                                            </p>
                                                                        </a>
                                                                        <ul class="collapse treeview-list" id="treeviewStriped-3-{{$subs2->id_acc_master_coa_data}}" data-show="true">
                                                                            @php
                                                                                $sub3 = DB::table('acc_master_coa_data')
                                                                                    ->where('acc_master_coa_code', $subs2->acc_coa_data_code)
                                                                                    ->where('acc_coa_data_level', 4)
                                                                                    ->get();
                                                                                $no3 = 1;
                                                                            @endphp
                                                                            <!-- TINGKAT 4 -->
                                                                            @foreach ($sub3 as $subs3)
                                                                                @if ($subs3->acc_coa_data_opt == 1)
                                                                                    <li class="treeview-list-item">
                                                                                        <a data-bs-toggle="collapse" href="#treeviewStriped-3-{{$subs3->id_acc_master_coa_data}}" role="button" oncontextmenu="myFunction('{{$subs3->acc_coa_data_code}}'); return false;"
                                                                                            aria-expanded="false">
                                                                                            <p class="treeview-text">
                                                                                                <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3++ }}</span> {{$subs3->acc_coa_data_name}}
                                                                                            </p>
                                                                                        </a>
                                                                                        <ul class="collapse treeview-list" id="treeviewStriped-3-{{$subs3->id_acc_master_coa_data}}" data-show="true">
                                                                                            @php
                                                                                                $sub4 = DB::table('acc_master_coa_data')
                                                                                                    ->where('acc_master_coa_code', $subs3->acc_coa_data_code)
                                                                                                    ->where('acc_coa_data_level', 5)
                                                                                                    ->get();
                                                                                                $no4 = 1;
                                                                                            @endphp
                                                                                            <!-- TINGKAT 5 -->
                                                                                            @foreach ($sub4 as $subs4)
                                                                                                @if ($subs4->acc_coa_data_opt == 1)
                                                                                                    <li class="treeview-list-item">
                                                                                                        <div class="treeview-item">
                                                                                                            <a class="flex-1" href="#!" oncontextmenu="myFunction('{{$subs4->acc_coa_data_code}}'); return false;">
                                                                                                                <p class="treeview-text">
                                                                                                                    <span class="me-2 fas fa-universal-access text-primary"></span>
                                                                                                                    <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3-1 }}.{{ $no4++ }}</span> {{$subs4->acc_coa_data_name}}
                                                                                                                </p>
                                                                                                            </a>
                                                                                                            <div class="dot bg-info"></div>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                @else ($subs4->acc_coa_data_opt == 0)
                                                                                                    <li class="treeview-list-item">
                                                                                                        <div class="treeview-item">
                                                                                                            <a class="flex-1" href="#!" oncontextmenu="myFunction('{{$subs4->acc_coa_data_code}}'); return false;">
                                                                                                                <p class="treeview-text">
                                                                                                                    <span class="me-2 fas fa-universal-access text-primary"></span>
                                                                                                                    <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3-1 }}.{{ $no4++ }}</span> {{$subs4->acc_coa_data_name}}
                                                                                                                </p>
                                                                                                            </a>
                                                                                                            <div class="dot bg-info"></div>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                @endif
                                                                                            @endforeach
                                                                                            <li class="treeview-list-item">
                                                                                                <div class="treeview-item">
                                                                                                    <a class="flex-1" href="#!" id="button-add-level" data-bs-toggle="modal" data-bs-target="#modal-coa" data-nomor="{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3-1 }}.{{ $no4 }}" data-level="5" data-code="{{ $subs3->acc_coa_data_code }}">
                                                                                                        <p class="treeview-text">
                                                                                                            <span class="me-2 fas fas fa-plus-circle text-success"></span>
                                                                                                            add Data x.x.x.x.x.x
                                                                                                        </p>
                                                                                                    </a>
                                                                                                </div>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </li>
                                                                                @else ($subs3->acc_coa_data_opt == 0)
                                                                                    <li class="treeview-list-item">
                                                                                        <div class="treeview-item">
                                                                                            <a class="flex-1" href="#!" oncontextmenu="myFunction('{{$subs3->acc_coa_data_code}}'); return false;">
                                                                                                <p class="treeview-text">
                                                                                                    <span class="mx-2 ms-3 fas fa-universal-access text-primary"></span>
                                                                                                    <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3++ }}</span> {{$subs3->acc_coa_data_name}}
                                                                                                </p>
                                                                                            </a>
                                                                                            <div class="dot bg-info"></div>
                                                                                        </div>
                                                                                    </li>
                                                                                @endif
                                                                            @endforeach
                                                                            <li class="treeview-list-item">
                                                                                <div class="treeview-item">
                                                                                    <a class="flex-1" href="#!" id="button-add-level" data-bs-toggle="modal" data-bs-target="#modal-coa" data-nomor="{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3 }}" data-level="4" data-code="{{ $subs2->acc_coa_data_code }}">
                                                                                        <p class="treeview-text">
                                                                                            <span class="me-2 fas fas fa-plus-circle text-success"></span>
                                                                                            add Data x.x.x.x.x
                                                                                        </p>
                                                                                    </a>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                @else ($subs2->acc_coa_data_opt == 0)
                                                                    <li class="treeview-list-item">
                                                                        <div class="treeview-item">
                                                                            <a class="flex-1" href="#!" oncontextmenu="myFunction('{{$subs2->acc_coa_data_code}}'); return false;">
                                                                                <p class="treeview-text">
                                                                                    <span class="mx-2 ms-3 fas fa-universal-access text-primary"></span>
                                                                                    <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2++ }}</span> {{$subs2->acc_coa_data_name}}
                                                                                </p>
                                                                            </a>
                                                                            <div class="dot bg-info"></div>
                                                                        </div>
                                                                    </li>

                                                                @endif
                                                            @endforeach
                                                            <li class="treeview-list-item">
                                                                <div class="treeview-item">
                                                                    <a class="flex-1" href="#!" id="button-add-level" data-bs-toggle="modal" data-bs-target="#modal-coa" data-nomor="{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2 }}" data-level="3" data-code="{{ $subs1->acc_coa_data_code }}">
                                                                        <p class="treeview-text">
                                                                            <span class="me-2 fas fas fa-plus-circle text-success"></span>
                                                                            add Data x.x.x.x
                                                                        </p>
                                                                    </a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                @else ($subs1->acc_coa_data_opt == 0)
                                                    <li class="treeview-list-item">
                                                        <div class="treeview-item">
                                                            <a class="flex-1" href="#!" oncontextmenu="myFunction('{{$subs1->acc_coa_data_code}}'); return false;">
                                                                <p class="treeview-text">
                                                                    <span class="mx-2 ms-3 fas fa-universal-access text-primary"></span>
                                                                    <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1++ }}</span> {{$subs1->acc_coa_data_name}}
                                                                </p>
                                                            </a>
                                                            <div class="dot bg-info"></div>
                                                        </div>
                                                    </li>

                                                @endif
                                            @endforeach
                                            <li class="treeview-list-item">
                                                <div class="treeview-item">
                                                    <a class="flex-1" href="#!" id="button-add-level" data-bs-toggle="modal" data-bs-target="#modal-coa" data-nomor="{{$datas->acc_master_coa_no}}.{{ $no-1 }}.{{ $no1 }}" data-level="2" data-code="{{ $subs->acc_coa_data_code }}">
                                                        <p class="treeview-text">
                                                            <span class="me-2 fas fa-plus-circle text-success"></span>
                                                            add Data x.x.x
                                                        </p>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                @elseif($subs->acc_coa_data_opt == 0)
                                    <li class="treeview-list-item">
                                        <div class="treeview-item">
                                            <a class="flex-1" href="#!" oncontextmenu="myFunction('{{$subs->acc_coa_data_code}}'); return false;">
                                                <p class="treeview-text">
                                                    <span class="me-2 fas fa-universal-access text-primary"></span>
                                                    <span class="text-warning me-2">{{$datas->acc_master_coa_no}}.{{ $no++ }}</span> {{$subs->acc_coa_data_name}}
                                                </p>
                                            </a>
                                            <div class="dot bg-info"></div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                            <!-- TINGKAT 1 END-->
                            <li class="treeview-list-item">
                                <div class="treeview-item">
                                    <a class="flex-1" href="#!" id="button-add-level" data-bs-toggle="modal" data-bs-target="#modal-coa" data-nomor="{{$datas->acc_master_coa_no}}.{{ $no }}" data-level="1" data-code="{{ $datas->acc_master_coa_code }}">
                                        <p class="treeview-text">
                                            <span class="me-2 fas fa-plus-circle text-success"></span>
                                            add Data x.x
                                        </p>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endforeach
                <!-- CONFIGURASI TAMBAHAN -->
                <li class="treeview-list-item">
                    <div class="treeview-item">
                        <a class="flex-1" href="#!">
                            <p class="treeview-text">
                                <span class="me-2 fab fa-node-js text-success"></span>
                                package-lock.json
                            </p>
                        </a>
                    </div>
                </li>
                <li class="treeview-list-item">
                    <div class="treeview-item">
                        <a class="flex-1" href="#!">
                            <p class="treeview-text">
                                <span class="me-2 fas fa-exclamation-circle text-primary"></span>
                                README.md
                            </p>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection
@section('base.js')
<div class="modal fade" id="modal-coa" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-coa"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('asset/js/flatpickr.js') }}"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function myFunction(data) {
            $('#modal-coa').modal('show');
            $.ajax({
                url: "{{ route('master_accounting_coa_update_level') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": data
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-coa').html(data);
            }).fail(function () {
                $('#menu-coa').html('eror');
            });
        }
    </script>
    <script>
        new DataTable('#example', {
            responsive: true
        });

    </script>
    <script>
        $(document).on("click", "#button-add-level", function (e) {
            e.preventDefault();
            let code = $(this).data("code");
            let level = $(this).data("level");
            let nomor = $(this).data("nomor");
            $.ajax({
                url: "{{ route('master_accounting_coa_add_level') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "nomor": nomor,
                    "code": code,
                    "level": level
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-coa').html(data);
            }).fail(function () {
                $('#menu-coa').html('eror');
            });
        });
        $(document).on("click", "#button-update-level", function (e) {
            e.preventDefault();
            let code = $(this).data("code");
            $.ajax({
                url: "{{ route('master_accounting_coa_update_level') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-coa').html(data);
            }).fail(function () {
                $('#menu-coa').html('eror');
            });
        });
        $(document).on("click", "#button-simpan-data-level-coa", function (e) {
            e.preventDefault();
            var data = $("#form-input-coa").serialize();
            $('#menu-add-data-coa').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('master_accounting_coa_save_level') }}",
                type: "POST",
                cache: false,
                data: data,
                dataType: 'html',
            }).done(function (data) {
                if (data == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                        footer: '<a href="#">Why do I have this issue?</a>'
                    });
                    $('#menu-add-data-coa').html('<button class="btn btn-success float-end" id="button-simpan-data-level-coa" data-code="">Simpan Data</button>');
                } else {
                    $('#menu-add-data-coa').html(data);
                    location.reload();
                }
            }).fail(function () {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#menu-add-data-coa').html('<button class="btn btn-success float-end" id="button-simpan-data-level-coa" data-code="">Simpan Data</button>');
            });
        });
        $(document).on("click", "#button-simpan-data-update-level-coa", function (e) {
            e.preventDefault();
            var data = $("#form-update-coa").serialize();
            $('#menu-add-data-coa').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('master_accounting_coa_update_save_level') }}",
                type: "POST",
                cache: false,
                data: data,
                dataType: 'html',
            }).done(function (data) {
                if (data == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                        footer: '<a href="#">Why do I have this issue?</a>'
                    });
                    $('#menu-add-data-coa').html('<button class="btn btn-success float-end" id="button-simpan-data-level-coa" data-code="">Simpan Data</button>');
                } else {
                    $('#menu-add-data-coa').html(data);
                    location.reload();
                }
            }).fail(function () {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#menu-add-data-coa').html('<button class="btn btn-success float-end" id="button-simpan-data-level-coa" data-code="">Simpan Data</button>');
            });
        });
    </script>
@endsection
