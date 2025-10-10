@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
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
                    <img class="ms-3 mx-3 m-2" src="{{ asset('img/sending.png') }}" alt="" width="50" />
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
                    <h4 class="text-primary fw-bold mb-0">Laboratorium <span class="text-primary fw-medium">Pengiriman Hasil</span>
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
                <button class="btn btn-falcon-default btn-sm mb-1" type="button" id="button-add-pengiriman" data-bs-toggle="modal" data-bs-target="#modal-whatsapp" title="" data-bs-original-title="Rate" aria-label="Archive">
                    <span class="fas fa-plus-circle"></span>
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
                    <th class="sort" data-sort="name">No Whatsapp</th>
                    <th class="sort" data-sort="tgl">Tanggal Kirim</th>
                    <th class="sort" data-sort="status">Status Reg</th>
                </tr>
            </thead>
            <tbody class="fs--2">
                @php
                $no = 1;
                @endphp
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $datas->d_reg_order_lab_code  }}</td>
                    <td>{{ $datas->v_log_whatsapp_name  }}</td>
                    <td>{{ $datas->v_log_whatsapp_number  }}</td>
                    <td>{{ $datas->v_log_whatsapp_date  }}</td>
                    <td>
                        @if ($datas->v_log_whatsapp_status == 0)
                        <span class="badge bg-danger">Belum Terkirim</span>
                        @else
                        <span class="badge bg-primary">Terkirim</span>
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
<div class="modal fade" id="modal-whatsapp" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-whatsapp"></div>
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
    $(document).on("click", "#button-add-pengiriman", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-whatsapp').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('pengiriman_hasil_laboratorium_add') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-whatsapp').html(data);
        }).fail(function() {
            $('#menu-whatsapp').html('eror');
        });
    });
</script>
@endsection
