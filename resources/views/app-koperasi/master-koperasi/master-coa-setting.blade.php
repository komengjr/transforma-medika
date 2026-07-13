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
                    <h4 class="text-success fw-bold mb-0">Master <span class="text-success fw-medium">COA Setting</span>
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
                <h5 class="text-white">Setting COA</h5>
            </div>
            <div class="d-flex">
                <button class="btn btn-dark btn-sm" id="button-sinkronisasi-cabang" data-bs-toggle="modal" data-bs-target="#modal-coa">Sinkronisasi Cabang</button>
            </div>
        </div>
    </div>
    <div class="card-body border-top p-3" id="hasil-pencarian-list">
        <table id="example" class="table table-striped" style="width:100%">
            <thead class="bg-300 fs--1">
                <tr>
                    <th>No</th>
                    <th>Cabang</th>
                    <th>Metode Transaksi</th>
                    <th>Akun Debit</th>
                    <th>Akun Bunga Transaksi</th>
                    <th>Akun Admin Transaksi</th>
                    <th>Akun Kredit</th>
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
                    <td>{{ $datas->kop_master_cabang_name }}</td>
                    <td>{{ $datas->fin_master_coa_set_trx }}</td>
                    <td>
                        @php
                        $akun1 = DB::table('kop_fin_master_coa')->where('coa_code',$datas->fin_master_coa_set_debit)->first();
                        @endphp
                        @if ($akun1)
                        {{ $akun1->coa_code }} - {{ $akun1->coa_name }}
                        @endif
                    </td>
                    <td>
                        @php
                        $akun2 = DB::table('kop_fin_master_coa')->where('coa_code',$datas->fin_master_coa_set_bunga)->first();
                        @endphp
                        @if ($akun2)
                        {{ $akun2->coa_code }} - {{ $akun2->coa_name }}
                        @endif
                    </td>
                    <td>
                        @php
                        $akun3 = DB::table('kop_fin_master_coa')->where('coa_code',$datas->fin_master_coa_set_adm)->first();
                        @endphp
                        @if ($akun3)
                        {{ $akun3->coa_code }} - {{ $akun3->coa_name }}
                        @endif
                    </td>
                    <td>
                        @php
                        $akun4 = DB::table('kop_fin_master_coa')->where('coa_code',$datas->fin_master_coa_set_kredit)->first();
                        @endphp
                        @if ($akun4)
                        {{ $akun4->coa_code }} - {{ $akun4->coa_name }}
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modal-coa"
                            id="button-setup-set-coa" data-code="{{$datas->fin_master_coa_set_code}}">Setup</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
@section('base.js')
<div class="modal fade" id="modal-coa-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-coa-full"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-coa" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
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
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    new DataTable('#example', {
        responsive: true
    });
</script>

<script>
    $(document).on("click", "#button-setup-set-coa", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-coa').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_koperasi_data_coa_setting_setup') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-coa').html(data);
        }).fail(function() {
            $('#menu-coa').html('eror');
        });
    });
    $(document).on("click", "#button-sinkronisasi-cabang", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-coa').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_koperasi_data_coa_setting_sinkronisasi') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-coa').html(data);
        }).fail(function() {
            $('#menu-coa').html('eror');
        });
    });
    $(document).on("click", "#button-simpan-data-set-coa", function(e) {
        e.preventDefault();
        var data = $("#form-set-data-coa").serialize();
        $('#menu-set-data-coa').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_koperasi_data_coa_setting_save') }}",
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
                $('#menu-set-data-coa').html('<button class="btn btn-success float-end" id="button-simpan-data-set-coa" data-code="">Simpan Data</button>');
            } else {
                $('#menu-set-data-coa').html(data);
                location.reload();
            }
        }).fail(function() {
            $('#menu-set-data-coa').html('eror');
        });
    });
    $(document).on("click", "#button-simpan-data-cabang-coa", function(e) {
        e.preventDefault();
        var data = $("#form-set-data-cabang").serialize();
        $('#menu-set-data-coa').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_koperasi_data_coa_setting_sinkronisasi_save') }}",
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
                $('#menu-set-data-coa').html('<button class="btn btn-success float-end" id="button-simpan-data-cabang-coa" data-code="">Simpan Data</button>');
            } else {
                $('#menu-set-data-coa').html(data);
                location.reload();
            }
        }).fail(function() {
            $('#menu-set-data-coa').html('eror');
        });
    });
</script>
@endsection
