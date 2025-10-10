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
        <div class="card bg-200 shadow border border-primary">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3 m-2" src="{{ asset('img/list-pasien.png') }}" alt="" width="50" />
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
                    <h4 class="text-primary fw-bold mb-0">Verifikasi <span class="text-primary fw-medium">Data Registrasi</span>
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
                <a class="btn btn-falcon-default btn-sm" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Refresh" aria-label="Back to inbox">
                    <span class="fas fa-undo"></span>
                </a>
                <span class="mx-1 mx-sm-2 text-300">|</span>
                <button class="btn btn-falcon-default btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Archive" aria-label="Archive"><svg class="svg-inline--fa fa-archive fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="archive" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M32 448c0 17.7 14.3 32 32 32h384c17.7 0 32-14.3 32-32V160H32v288zm160-212c0-6.6 5.4-12 12-12h104c6.6 0 12 5.4 12 12v8c0 6.6-5.4 12-12 12H204c-6.6 0-12-5.4-12-12v-8zM480 32H32C14.3 32 0 46.3 0 64v48c0 8.8 7.2 16 16 16h480c8.8 0 16-7.2 16-16V64c0-17.7-14.3-32-32-32z"></path>
                    </svg><!-- <span class="fas fa-archive"></span> Font Awesome fontawesome.com --></button>
                <button class="btn btn-falcon-default btn-sm ms-1 ms-sm-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete" aria-label="Delete"><svg class="svg-inline--fa fa-trash-alt fa-w-14" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path>
                    </svg><!-- <span class="fas fa-trash-alt"></span> Font Awesome fontawesome.com --></button>
                <button class="btn btn-falcon-default btn-sm ms-1 ms-sm-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Mark as unread" aria-label="Mark as unread"><svg class="svg-inline--fa fa-envelope fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"></path>
                    </svg><!-- <span class="fas fa-envelope"></span> Font Awesome fontawesome.com --></button>
                <button class="btn btn-falcon-default btn-sm ms-1 ms-sm-2" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Snooze" aria-label="Snooze"><svg class="svg-inline--fa fa-clock fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M256,8C119,8,8,119,8,256S119,504,256,504,504,393,504,256,393,8,256,8Zm92.49,313h0l-20,25a16,16,0,0,1-22.49,2.5h0l-67-49.72a40,40,0,0,1-15-31.23V112a16,16,0,0,1,16-16h32a16,16,0,0,1,16,16V256l58,42.5A16,16,0,0,1,348.49,321Z"></path>
                    </svg><!-- <span class="fas fa-clock"></span> Font Awesome fontawesome.com --></button>
                <button class="btn btn-falcon-default btn-sm ms-1 ms-sm-2 d-none d-sm-inline-block" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Print" aria-label="Print"><svg class="svg-inline--fa fa-print fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="print" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                        <path fill="currentColor" d="M448 192V77.25c0-8.49-3.37-16.62-9.37-22.63L393.37 9.37c-6-6-14.14-9.37-22.63-9.37H96C78.33 0 64 14.33 64 32v160c-35.35 0-64 28.65-64 64v112c0 8.84 7.16 16 16 16h48v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h48c8.84 0 16-7.16 16-16V256c0-35.35-28.65-64-64-64zm-64 256H128v-96h256v96zm0-224H128V64h192v48c0 8.84 7.16 16 16 16h48v96zm48 72c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z"></path>
                    </svg><!-- <span class="fas fa-print"></span> Font Awesome fontawesome.com --></button>
            </div>
            <div class="d-flex">
                <input class="form-control datetimepicker" id="timepicker3" type="text" placeholder="d/m/y to d/m/y" data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' />
            </div>
        </div>
    </div>
    <div class="card-body border-top p-3">
        <table id="example" class="table table-striped nowrap" style="width:100%">
            <thead class="bg-200 text-700">
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
                $user = DB::table('user_mains')->select('fullname')->where('userid',$datas->d_reg_order_user)->first();
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
                        $layanan = DB::table('d_reg_order_list')->where('d_reg_order_code',$datas->d_reg_order_code)
                        ->join('t_layanan_cat','t_layanan_cat.t_layanan_cat_code','=','d_reg_order_list.t_layanan_cat_code')
                        ->get();
                        @endphp
                        @foreach ($layanan as $layanans)
                        <li><strong>{{$layanans->d_reg_order_list_code }}</strong> <br> <span class="text-warning">{{$layanans->t_layanan_cat_name}}</span></li>
                        @endforeach
                    </td>
                    <td>{{ $datas->d_reg_order_date }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"><span class="fas fa-align-left me-1"
                                    data-fa-transform="shrink-3"></span>Menu</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                    id="button-data-barang-cabang" data-code="123">
                                    <span class="fas fa-user-shield"></span>
                                    Verifikasi Data Registrasi
                                </button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                    id="button-data-barang-cabang" data-code="123">
                                    <span class="fas fa-user-cog"></span>
                                    Perubahan Data Registrasi
                                </button>
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
<div class="modal fade" id="modal-company" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-company"></div>
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
