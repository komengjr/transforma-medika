@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="card bg-200 shadow border border-primary">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/keuangan.png') }}" alt="" width="50" />
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
                        <h4 class="text-primary fw-bold mb-0">Transaksi <span
                                class="text-primary fw-medium">Penerimaan</span>
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
                    <a class="btn btn-falcon-default btn-sm mb-1" href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="" data-bs-original-title="Refresh" aria-label="Back to inbox">
                        <span class="fas fa-undo"></span>
                    </a>
                    <span class="mx-1 mx-sm-2 text-300">|</span>
                    <button class="btn btn-falcon-default btn-sm mb-1" type="button" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="" data-bs-original-title="Rate" aria-label="Archive">
                        <span class="far fa-chart-bar"></span>
                    </button>

                </div>
                <div class="d-flex">
                    <input class="form-control datetimepicker" id="timepicker3" type="text" placeholder="d/m/y to d/m/y"
                        data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' />
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
                        <th class="sort" data-sort="poli">List Pembayaran</th>
                        <th class="sort" data-sort="act">Action</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $datas->d_reg_order_code  }}</td>
                            <td>{{ $datas->master_patient_name }}</td>
                            <td>{{ $datas->d_reg_order_date }}</td>
                            <td>
                                @php
                                    $list = DB::table('d_reg_order_list')->where('d_reg_order_code', $datas->d_reg_order_code)->get();
                                @endphp
                                @foreach ($list as $lists)
                                    @php
                                        $payment = DB::table('d_reg_order_payment')->where('d_reg_order_list_code',$lists->d_reg_order_list_code)->first();
                                    @endphp
                                    @if ($payment)
                                    <li>{{ $lists->d_reg_order_list_code  }} <span class="text-primary">Lunas</span></li>
                                    @else
                                    <li>{{ $lists->d_reg_order_list_code  }} <span class="text-danger">Belum Lunas</span></li>
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Option</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                            <button class="dropdown-item text-warning" data-bs-toggle="modal"
                                                data-bs-target="#modal-keuangan" id="button-proses-transaksi"
                                                data-code="{{ $datas->d_reg_order_code }}"><span class="fab fa-amazon-pay"></span>
                                                Proses Transaksi</button>
                                                <div class="dropdown-divider"></div>
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                                id="button-data-barang-cabang" data-code="123"><span
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
    <div class="modal fade" id="modal-keuangan-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-keuangan-full"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-keuangan" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-keuangan"></div>
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
        $(document).on("click", "#button-proses-transaksi", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-keuangan').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('keuangan_penerimaan_proses_transaksi') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-keuangan').html(data);
            }).fail(function () {
                $('#menu-keuangan').html('eror');
            });
        });

    </script>
@endsection
