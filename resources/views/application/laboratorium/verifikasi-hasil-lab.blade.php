@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<style>
    #button-verifikasi-hasil:hover {
        cursor: pointer;
        color: red;
    }
</style>
@endsection
@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow border border-primary">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3 m-2" src="{{ asset('img/lab.png') }}" alt="" width="50" />
                    <div>
                        <h6 class="text-primary fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-primary fw-bold mb-1">Trans <span class="text-primary fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-primary fs--1 mb-0">Menu : </h6>
                    <h4 class="text-primary fw-bold mb-0">Laboratorium <span class="text-primary fw-medium">Verifikasi Hasil</span>
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
                <a class="btn btn-falcon-default btn-sm mb-1" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Refresh" aria-label="Back to inbox">
                    <span class="fas fa-undo"></span>
                </a>
                <span class="mx-1 mx-sm-2 text-300">|</span>
                <button class="btn btn-falcon-default btn-sm mb-1" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Rate" aria-label="Archive">
                    <span class="far fa-chart-bar"></span>
                </button>

            </div>
            <div class="d-flex">
                <input class="form-control datetimepicker" id="timepicker3" type="text" placeholder="d/m/y to d/m/y" data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' />
            </div>
        </div>
    </div>
    <div class="card-body border-top p-3">
        <table id="example" class="table table-bordered table-striped" style="width:100%">
            <thead class="bg-800 text-200 fs--2">
                <tr>
                    <th class="sort" data-sort="no">No</th>
                    <th class="sort" data-sort="reg">No Reg</th>
                    <th class="sort" data-sort="name">Nama Pasien</th>
                    <th class="sort" data-sort="tgl">Tanggal Reg</th>
                    <th class="sort" data-sort="poli">Rujukan</th>
                    <th class="sort" data-sort="poli">Pemeriksaan</th>
                    <th class="sort" data-sort="status">Status Reg</th>
                </tr>
            </thead>
            <tbody class="fs--1">
                @php
                $no = 1;
                @endphp
                @foreach ($data as $datas)
                <tr id="button-verifikasi-hasil" data-code="{{ $datas->d_reg_order_code }}" data-reg="{{ $datas->d_reg_order_lab_code  }}" data-bs-toggle="modal" data-bs-target="#modal-lab-full">
                    <td class="no">{{ $no++ }}</td>
                    <td class="reg">{{ $datas->d_reg_order_code }}</td>
                    <td class="name">{{ $datas->master_patient_name }}</td>
                    <td class="tgl">{{ $datas->d_reg_order_date }}</td>
                    <td class="poli">{{$datas->master_doctor_name}}</td>
                    <td class="poli">
                        @php
                        $pem = DB::table('d_reg_order_lab_list')
                        ->join('p_sales_data','p_sales_data.p_sales_data_code','=','d_reg_order_lab_list.p_sales_data_code')
                        ->join('t_pemeriksaan_list','t_pemeriksaan_list.t_pemeriksaan_list_code','=','p_sales_data.t_pemeriksaan_list_code')
                        ->where('d_reg_order_lab_code',$datas->d_reg_order_lab_code)->get();
                        @endphp
                        @foreach ($pem as $pems)
                        <li>{{ $pems->t_pemeriksaan_list_name }}</li>
                        @endforeach
                    </td>
                    <td class="text-center">
                        @if ($datas->d_reg_order_lab_status == 0)
                        <span class="badge bg-danger">Belum</span>
                        @elseif ($datas->d_reg_order_lab_status == 1)
                        <span class="badge bg-warning">Proses</span>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('base.js')
<div class="modal fade" id="modal-lab-full" data-bs-keyboard="false" data-bs-backdrop="static"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-lab-full"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('asset/js/swetalert.js') }}"></script>
<script>
    new DataTable('#example', {
        responsive: true
    });
</script>

<script>
    $(document).on("click", "#button-verifikasi-hasil", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var reg = $(this).data("reg");
        $('#menu-lab-full').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('verifikasi_laboratorium_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "reg": reg,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-lab-full').html(data);

        }).fail(function() {
            $('#menu-lab-full').html('eror');
        });
    });
    $(document).on("click", "#button-verifikasi-hasil-lab", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var reg = $(this).data("reg");
        Swal.fire({
            // toast: true,
            title: "Are you sure?",
            text: "You won't be able to verify this!",
            icon: "warning",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Verif it!"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Verify!",
                    text: "Your Report has been Verifikasi.",
                    icon: "success"
                });
                $('#menu-verifikasi-hasil').html(
                    '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                );
                $.ajax({
                    url: "{{ route('verifikasi_laboratorium_verifikasi_data') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code,
                        "reg": reg,
                    },
                    dataType: 'html',
                }).done(function(data) {
                    $('#menu-verifikasi-hasil').html(data);
                    location.reload();
                }).fail(function() {
                    $('#menu-verifikasi-hasil').html('eror');
                });
            }
        });

    });
</script>
<!-- REPORT -->
<script>
    $(document).on("click", "#button-verifikasi-preview-report", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var reg = $(this).data("reg");
        $('#view-map').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('verifikasi_laboratorium_preview_report') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
                "reg": reg,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#button-verifikasi-hasil-lab').show();
            $('#view-map').html(
                '<iframe src="data:application/pdf;base64, ' +
                data +
                '" style="width:100%; height:533px;" frameborder="0"></iframe>');
        }).fail(function() {
            $('#view-map').html('eror');
        });
    });
</script>
@endsection
