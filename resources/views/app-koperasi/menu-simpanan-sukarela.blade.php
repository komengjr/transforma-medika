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
                    <h4 class="text-success fw-bold mb-0">Simpanan <span class="text-success fw-medium">Sukarela</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3 border border-success">
    <div class="card-header bg-primary">
        <div class="d-flex justify-content-between">
            <div>
                <a class="btn btn-falcon-default btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#modal-koperasi" id="button-add-data-simpanan">
                    <span class="fas fa-plus me-2"></span> Buat Simpanan
                </a>
                <!-- <span class="mx-1 mx-sm-2 text-300">|</span>
                <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="" data-bs-original-title="Archive" aria-label="Archive"><span
                        class="fas fa-print"></span></button> -->

            </div>
            <div class="d-flex">
                <input class="form-control datetimepicker" id="timepicker3" type="text" placeholder="Y-m-d to Y-m-d"
                    data-options='{"mode":"range","dateFormat":"Y-m-d","disableMobile":true,"locale":"en"}'
                    onchange="search(this)" />
            </div>
        </div>
    </div>
    <div class="card-body">
        <table id="example" class="table table-striped" style="width:100%">
            <thead class="bg-300 fs--1">
                <tr>
                    <th>No</th>
                    <th>Tanggal Simpanan</th>
                    <th>Nama Anggota</th>
                    <th>Biaya Bunga</th>
                    <th>Nominal Total</th>
                    <th>Status Simpanan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="fs--1">
                @php
                $no = 1;
                @endphp
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $datas->kop_simpanan_sukarela_date }}</td>
                    <td>{{ $datas->kop_master_peserta_name }}</td>
                    <td>{{ $datas->kop_tagihan_bulan_peserta_bunga }} %</td>
                    <td class="text-end">@currency($datas->kop_tagihan_bulan_peserta_nominal)</td>
                    <td class="text-center">
                        @if ($datas->kop_simpanan_sukarela_status == "0")
                        <span class="badge bg-warning">Proses Penyimpanan</span>
                        @else
                        <span class="badge bg-primary">Selesai</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                @if ($datas->kop_simpanan_sukarela_status == "0")
                                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#modal-koperasi"
                                    id="button-proses-penyimpanan-sukarela" data-code="{{$datas->kop_simpanan_sukarela_code}}"><span
                                        class="fas fa-file-contract"> </span> Proses Penyimpanan</button>
                                @elseif ($datas->kop_simpanan_sukarela_status == "1")
                                <button class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#modal-koperasi"
                                    id="button-proses-tagihan-bulanan-peserta" data-code="{{$datas->kop_simpanan_sukarela_code}}"><span
                                        class="far fa-hourglass"> </span> Proses Tagihan Peserta</button>
                                @else
                                <button class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#modal-koperasi"
                                    id="button-cetak-tagihan-bulanan-peserta" data-code="{{$datas->kop_simpanan_sukarela_code}}"><span
                                        class="far fa-printer"> </span> Cetak Tagihan Peserta</button>
                                @endif
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
<div class="modal fade" id="modal-koperasi-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-koperasi-full"></div>
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
    $(document).on("click", "#button-add-data-simpanan", function(e) {
        e.preventDefault();
        $('#menu-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_koperasi_sukarela_add') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": 123
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-koperasi').html(data);
        }).fail(function() {
            $('#menu-koperasi').html('eror');
        });
    });
    $(document).on("click", "#button-simpan-simpanan-sukarela", function(e) {
        e.preventDefault();
        var data = $("#form-add-tagihan-bulan").serialize();
        $('#menu-add-tagihan-bulan').html(
            '<div class="spinner-border my-0" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_koperasi_sukarela_save') }}",
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
                $('#menu-add-tagihan-bulan').html('<button class="btn btn-success float-end" id="button-simpan-simpanan-sukarela" data-code="">Simpan Data</button>');
            } else {
                Swal.fire('Berhasil!', 'Data Simpanan Berhasil di Buat', 'success').then(() => {
                    location.reload();
                });
            }
        }).fail(function() {
            $('#menu-add-tagihan-bulan').html('eror');
        });
    });
    $(document).on("click", "#button-proses-penyimpanan-sukarela", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_koperasi_sukarela_proses') }}",
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
    $(document).on("click", "#button-payment-data-penyimpanan-sukarela", function(e) {
        e.preventDefault();
        var code = document.getElementById('data_simpanan_sukarela').value;
        var akun = document.getElementById('akun_setor').value;
        $('#menu-proses-data-simpanan').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_koperasi_sukarela_proses_save') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "akun": akun
            },
            dataType: 'html',
        }).done(function(data) {
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#menu-proses-data-simpanan').html('<button class="btn btn-success float-end" id="button-payment-data-penyimpanan-sukarela" >Simpan Data</button>');
            } else {
                Swal.fire('Berhasil!', 'Data Tagihan Berhasil di Buat', 'success').then(() => {
                    location.reload();
                });
            }
        }).fail(function() {
            $('#menu-proses-data-simpanan').html('eror');
        });
    });
</script>
@endsection
