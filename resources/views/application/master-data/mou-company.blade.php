@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="card bg-200 shadow border border-danger">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3" src="{{ asset('img/company.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-danger fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-danger fw-bold mb-1">MCU <span class="text-danger fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-danger fs--1 mb-0">Menu : </h6>
                        <h4 class="text-danger fw-bold mb-0">MOU <span class="text-danger fw-medium">Perusahaan</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-danger">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="m-0"><span class="badge bg-danger m-0 p-0">MOU Perusahaan</span></h3>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu Perusahaan</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-company-xl"
                                id="button-add-mou-company" data-code="123"><span class="far fa-edit"></span>
                                Tambah MOU Perusahaan</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border-top p-3">
            <table id="example" class="table table-striped nowrap" style="width:100%">
                <thead class="bg-200 text-700 fs--2">
                    <tr>
                        <th>No</th>
                        <th>MOU Persuahaan</th>
                        <th>Nama Perusahaan</th>
                        <th>Jumlah Peserta</th>
                        <th>Tanggal</th>
                        <th>Agreement</th>
                        <th>Status MOU</th>
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
                            <td>{{ $datas->company_mou_name }}</td>
                            <td>{{ $datas->master_company_name }}</td>
                            <td>
                                @php
                                    $total = DB::table('company_mou_peserta')
                                        ->where('company_mou_code', $datas->company_mou_code)
                                        ->count();
                                @endphp
                                {{ $total }}
                            </td>
                            <td>{{ $datas->company_mou_start }} <br>{{ $datas->company_mou_end }}</td>
                            <td>
                                @php
                                    $agreement = DB::table('company_mou_agreement')->where('company_mou_code',$datas->company_mou_code)->get();
                                @endphp
                                @foreach ($agreement as $item)
                                    <li>{{$item->mou_agreement_name}}</li>
                                @endforeach
                            </td>
                            <td>
                                @if ($datas->company_mou_status == 0)
                                    <span class="badge bg-danger">Tidak Aktif</span>
                                @else
                                    <span class="badge bg-primary">Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"><span class="fas fa-align-left me-1"
                                            data-fa-transform="shrink-3"></span>Option</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        <button class="dropdown-item text-warning" data-bs-toggle="modal"
                                            data-bs-target="#modal-company" id="button-add-companys" data-code="123"><span
                                                class="far fa-edit"></span>
                                            Edit Perusahaan</button>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-company"
                                            id="button-data-peserta-mcu" data-code="{{ $datas->company_mou_code }}">
                                            <span class="fas fa-user-friends"></span>
                                            Peserta MCU</button>
                                        <button class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#modal-company-xl" id="button-data-insert-peserta"
                                            data-code="{{ $datas->company_mou_code }}">
                                            <span class="fas fa-file-import"></span>
                                            Insert Peserta</button>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item text-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal-company-sm" id="button-aktifasi-mou"
                                            data-code="{{ $datas->company_mou_code }}">
                                            <span class="fab fa-galactic-republic"></span>
                                            Aktivasi MOU</button>
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
    <div class="modal fade" id="modal-company" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-company"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-company-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-company-xl"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-company-lg" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-company-lg"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-company-sm" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-company-sm"></div>
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
        $(document).on("click", "#button-add-mou-company", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-company-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('mou_company_add') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-company-xl').html(data);
            }).fail(function() {
                $('#menu-company-xl').html('eror');
            });
        });
        $(document).on("click", "#button-data-peserta-mcu", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-company').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('mou_company_peserta_mcu') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-company').html(data);
            }).fail(function() {
                $('#menu-company').html('eror');
            });
        });
        $(document).on("click", "#button-data-insert-peserta", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-company-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('mou_company_insert_peserta_mcu') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-company-xl').html(data);
            }).fail(function() {
                $('#menu-company-xl').html('eror');
            });
        });
        $(document).on("click", "#button-add-form-mou-company", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-metode-insert').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('mou_company_insert_peserta_mcu_manual') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-metode-insert').html(data);
            }).fail(function() {
                $('#menu-metode-insert').html('eror');
            });
        });
        $(document).on("click", "#button-add-upload-mou-company", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-metode-insert').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('mou_company_insert_peserta_mcu_upload') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-metode-insert').html(data);
            }).fail(function() {
                $('#menu-metode-insert').html('eror');
            });
        });
        $(document).on("click", "#button-data-insert-pemeriksaan", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-company').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('mou_company_insert_pemeriksaan_mcu') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-company').html(data);
            }).fail(function() {
                $('#menu-company').html('eror');
            });
        });
        $(document).on("click", "#button-pilih-pemeriksaan-mou", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var code = $(this).data("code");
            $('#menu-pemeriksaan-mcu').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('mou_company_insert_pemeriksaan_mcu_insert') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-pemeriksaan-mcu').html(data);
                location.reload();
            }).fail(function() {
                $('#menu-pemeriksaan-mcu').html('eror');
            });
        });
        $(document).on("click", "#button-aktifasi-mou", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-company-sm').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('mou_company_activasi_mou') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-company-sm').html(data);
            }).fail(function() {
                $('#menu-company-sm').html('eror');
            });
        });

        $(document).on("click", "#button-add-upload-excel-mou-company", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-metode-insert').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('mou_company_insert_all_peserta_mcu_upload') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-metode-insert').html(data);
            }).fail(function() {
                $('#menu-metode-insert').html('eror');
            });
        });
    </script>
@endsection
