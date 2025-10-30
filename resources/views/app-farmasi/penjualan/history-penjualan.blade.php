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
            <div class="card bg-200 shadow border border-warning">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3" src="{{ asset('img/poli.png') }}" alt="" width="80" />
                        <div>
                            <h6 class="text-warning fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-warning fw-bold mb-1">{{ Env('APP_LABEL')}} <span
                                    class="text-warning fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-warning fs--1 mb-0">Menu : </h6>
                        <h4 class="text-warning fw-bold mb-0">History <span class="text-warning fw-medium"> Penjualan</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-warning">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="m-0"><span class="badge bg-warning m-0 p-0">Data Riwayat Penjualan</span></h3>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-product-xl"
                                id="button-add-product" data-code="123"><span class="far fa-edit"></span>
                                Add New Obat</button>
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-product-xl"
                                id="button-upload-data-product" data-code="123"><span class="fas fa-upload"></span>
                                Import Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border-top p-3">
            <table id="example" class="table table-bordered table-striped" style="width:100%">
                <thead class="bg-800 text-200 fs--2">
                    <tr>
                        <th class="sort" data-sort="no">No</th>
                        <th class="sort" data-sort="reg">No Order / Nota</th>
                        <th class="sort" data-sort="name">Tanggal Order</th>
                        <th class="sort" data-sort="name">Type Order</th>
                        <th class="sort" data-sort="tgl">List Obat</th>
                        <th class="sort" data-sort="tgl">Total Pembayaran</th>
                        <th class="sort" data-sort="act">Action</th>
                    </tr>
                </thead>
                <tbody class="fs--2">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $datas->farm_order_data_code }}</td>
                            <td>{{ $datas->farm_order_data_date }}</td>
                            <td>
                                @if ($datas->farm_order_data_type == 'NON RESEP')
                                    <span class="badge bg-warning">NON RESEP</span>
                                @else
                                    @php
                                        $pasien = DB::table('farm_order_data_pasien')->where('farm_order_data_code',$datas->farm_order_data_code)->first();
                                    @endphp
                                    <span class="badge bg-primary">RESEP</span> <br>
                                    @if ($pasien)
                                        <strong>{{ $pasien->farm_order_data_pasien_name }}</strong>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @php
                                    $total = 0;
                                    $list = DB::table('farm_order_data_list')
                                        ->join('farm_data_obat', 'farm_data_obat.farm_data_obat_code', '=', 'farm_order_data_list.farm_data_obat_code')
                                        ->where('farm_order_data_code', $datas->farm_order_data_code)->get();
                                @endphp
                                @foreach ($list as $lists)
                                    <li class="ms-3">{{ $lists->farm_data_obat_name }}
                                        <br>@currency($lists->farm_order_data_list_price) * {{ $lists->farm_order_data_list_qty }}
                                    </li>
                                    @php
                                        $total = $total + ($lists->farm_order_data_list_price * $lists->farm_order_data_list_qty);
                                    @endphp
                                @endforeach
                            </td>
                            <td class="text-end">@currency($total)</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        <!-- <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-product-xl"
                                                                    id="button-add-product" data-code="123"><span class="far fa-edit"></span>
                                                                    Add New Obat</button>
                                                                <div class="dropdown-divider"></div> -->
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-product-xl"
                                            id="button-upload-data-product" data-code="123"><span class="fas fa-upload"></span>
                                            Import Excel</button>
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
    <div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
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
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>

@endsection
