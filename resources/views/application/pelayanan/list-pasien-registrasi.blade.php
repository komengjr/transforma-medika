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
            <div class="card bg-200 shadow border border-info">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/list-pasien.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-info fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-info fw-bold mb-1">{{ Env('APP_LABEL')}} <span
                                    class="text-primary fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-info fs--1 mb-0">Menu : </h6>
                        <h4 class="text-info fw-bold mb-0">Data <span class="text-info fw-medium">List Pasien</span>
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
                    <a class="btn btn-falcon-default btn-sm" href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="" data-bs-original-title="Refresh" aria-label="Back to inbox" id="button-data-today-pasien">
                        <span class="fas fa-undo"></span>
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
                        <th>No. Reg</th>
                        <th>Nama Pasien</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>Kategori Pasien</th>
                        <th>Layanan</th>
                        <th>Tanggal Registrasi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="fs--2">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                        @php
                            $user = DB::table('user_mains')->select('fullname')->where('userid', $datas->d_reg_order_user)->first();
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>
                                {{ $datas->d_reg_order_code }} <br>
                                @if ($user)
                                    <span class="badge bg-primary">{{$user->fullname}}</span>
                                @else
                                    <span class="badge bg-danger">Unknown</span>
                                @endif
                            </td>
                            <td>{{ $datas->master_patient_name }}</td>
                            <td>{{ $datas->master_patient_tempat_lahir }}, {{ $datas->master_patient_tgl_lahir }}</td>
                            <td class="text-info">{{ $datas->t_pasien_cat_name }}</td>
                            <td>
                                @php
                                    $layanan = DB::table('d_reg_order_list')->where('d_reg_order_code', $datas->d_reg_order_code)
                                        ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'd_reg_order_list.t_layanan_cat_code')
                                        ->get();
                                @endphp
                                @foreach ($layanan as $layanans)
                                    <li><strong>{{$layanans->d_reg_order_list_code }}</strong> <br> <span
                                            class="text-warning">{{$layanans->t_layanan_cat_name}}</span></li>
                                @endforeach
                            </td>
                            <td>{{ $datas->created_at }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-registrasi"
                                            id="button-data-history-pasien" data-code="{{$datas->d_reg_order_rm}}"><span
                                                class="far fa-folder-open"></span>
                                            History</button>
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
    <div class="modal fade" id="modal-company-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-company-full"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-registrasi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-registrasi"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="{{ asset('asset/js/flatpickr.js') }}"></script>
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>

    <script>
        $(document).on("click", "#button-data-history-pasien", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-registrasi').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('data_registrasi_history') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-registrasi').html(data);
            }).fail(function () {
                $('#menu-registrasi').html('eror');
            });
        });
        $(document).on("click", "#button-data-today-pasien", function (e) {
            e.preventDefault();
            $('#hasil-pencarian-list').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('data_registrasi_refresh_data') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": null
                },
                dataType: 'html',
            }).done(function (data) {
                $('#hasil-pencarian-list').html(data);
            }).fail(function () {
                $('#hasil-pencarian-list').html('eror');
            });
        });
    </script>
    <script>
        function search(ele) {
            const code = document.getElementById("timepicker3").value;
            $("#hasil-pencarian-list").html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            let tgl1 = code.substring(0, 10);
            let tgl2 = code.substring(14, 24);
            if (tgl2 == "") {

            } else {
                $.ajax({
                    url: "{{ route('data_registrasi_find_data') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "tgl1": tgl1,
                        "tgl2": tgl2
                    },
                    dataType: 'html',
                }).done(function (data) {
                    $("#hasil-pencarian-list").html(data);
                }).fail(function () {
                    $("#hasil-pencarian-list").html(
                        '<i class="fa fa-info-sign"></i> Something went wrong, Please try again...'
                    );
                });
            }
        };
    </script>
@endsection
