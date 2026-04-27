@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

@endsection
@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow border border-success">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3" src="{{ asset('img/koperasi.png') }}" alt="" width="60" />
                    <div>
                        <h6 class="text-success fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-success fw-bold mb-1">{{ Env('APP_LABEL')}} <span
                                class="text-success fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-success fs--1 mb-0">Menu : </h6>
                    <h4 class="text-success fw-bold mb-0">Master <span class="text-success fw-medium">Cabang Koperasi</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-primary">
        <div class="d-flex justify-content-between">
            <div>
                <a class="btn btn-falcon-default btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#modal-koperasi" id="button-add-data-divisi">
                    <span class="fas fa-plus"></span>
                </a>
                <span class="mx-1 mx-sm-2 text-300">|</span>
                <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="" data-bs-original-title="Archive" aria-label="Archive"><span
                        class="fas fa-print"></span></button>

            </div>
            <div class="d-flex">
                <input class="form-control datetimepicker" id="timepicker3" type="text" placeholder="Y-m-d to Y-m-d"
                    data-options='{"mode":"range","dateFormat":"Y-m-d","disableMobile":true,"locale":"en"}'
                    onchange="search(this)" />
            </div>
        </div>
    </div>
    <div class="card-body border-top p-3" id="hasil-pencarian-list">
        <table id="example" class="table table-striped" style="width:100%">
            <thead class="bg-300 fs--1">
                <tr>
                    <th>No</th>
                    <th>Kode Cabang</th>
                    <th>Nama Cabang</th>
                    <th>Kota</th>
                    <th>User Verifikasi</th>
                    <th>Setup Peminjaman</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="fs--2">
                @php
                $no = 1;
                @endphp
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $datas->kop_master_cabang_code }}</td>
                    <td>{{ $datas->kop_master_cabang_name }}</td>
                    <td>{{ $datas->kop_master_cabang_city }}</td>
                    <td>
                        @php
                        $user = DB::table('kop_user_verifikasi')->where('kop_user_verifikasi_cabang',$datas->kop_master_cabang_code)->get();
                        @endphp
                        @foreach ($user as $users)
                        <li>
                            {{ $users->kop_user_verifikasi_name }} -
                            @if ($users->kop_user_verifikasi_job == '0')
                                Kepala Cabang
                            @else
                                Ketua Koperasi
                            @endif
                        </li>
                        @endforeach
                    </td>
                    <td>
                        @php
                            $setup = DB::table('kop_setup_cabang_koperasi')->where('kop_setup_cabang_koperasi_cabang',$datas->kop_master_cabang_code)->first();
                        @endphp
                        @if ($setup)
                        <strong>Jumlah Pinjaman</strong>
                        <ul>
                            <li>Barang Max : @currency($setup->kop_setup_cabang_koperasi_jp_brg)</li>
                            <li>Uang Max : @currency($setup->kop_setup_cabang_koperasi_jp_uang)</li>
                        </ul>
                        <strong>Yang Akan dibayar Selama :</strong>
                        <ul>
                            <li>Barang Max : {{ $setup->kop_setup_cabang_koperasi_tenor_brg }} kali</li>
                            <li>Uang Max : {{ $setup->kop_setup_cabang_koperasi_tenor_uang }} kali</li>
                        </ul>
                        <strong>Angsuran Bunga : {{ $setup->kop_setup_cabang_koperasi_bunga }} %</strong>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-koperasi"
                                    id="button-data-history-pasien" data-code="{{$datas->kop_master_cabang_code}}">
                                    Update Data Cabang</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-koperasi"
                                    id="button-add-data-verifikasi" data-code="{{$datas->kop_master_cabang_code}}">
                                    Tambah User Verifikasi Cabang</button>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-koperasi"
                                    id="button-update-data-setup" data-code="{{$datas->kop_master_cabang_code}}">
                                    Setup Peminjaman</button>
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
<div class="modal fade" id="modal-penjualan-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-koperasi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-koperasi"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
<script>
    $(document).on("click", "#button-add-data-verifikasi", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_koperasi_cabang_add_verifikasi') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-koperasi').html(data);
        }).fail(function() {
            $('#menu-koperasi').html('eror');
        });
    });
    $(document).on("click", "#button-simpan-data-verifikasi", function(e) {
        e.preventDefault();
        var data = $("#form-add-verifikasi-baru").serialize();
        $('#menu-add-data-verifikasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_koperasi_cabang_save_data_verifikasi') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'html',
        }).done(function(data) {
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#menu-add-data-verifikasi').html('<button class="btn btn-success float-end" id="button-simpan-data-verifikasi" data-code="">Simpan Data</button>');
            } else {
                $('#menu-add-data-verifikasi').html(data);
                location.reload();
            }
        }).fail(function() {
            $('#menu-add-data-verifikasi').html('eror');
        });
    });
    $(document).on("click", "#button-update-data-setup", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_koperasi_cabang_update_data_setup') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-koperasi').html(data);
        }).fail(function() {
            $('#menu-koperasi').html('eror');
        });
    });
    $(document).on("click", "#button-simpan-data-setup", function(e) {
        e.preventDefault();
        var data = $("#form-add-setup-baru").serialize();
        $('#menu-add-data-setup').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_koperasi_cabang_save_data_setup') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'html',
        }).done(function(data) {
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#menu-add-data-setup').html('<button class="btn btn-success float-end" id="button-simpan-data-setup" data-code="">Simpan Data</button>');
            } else {
                $('#menu-add-data-setup').html(data);
                location.reload();
            }
        }).fail(function() {
            $('#menu-add-data-setup').html('eror');
        });
    });
</script>

@endsection
