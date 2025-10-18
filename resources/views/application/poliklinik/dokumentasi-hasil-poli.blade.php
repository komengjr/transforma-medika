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
                        <img class="ms-3 mx-3" src="{{ asset('img/verif.png') }}" alt="" width="80" />
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
                        <h4 class="text-warning fw-bold mb-0">Poli <span class="text-warning fw-medium">Dokumentasi
                                Hasil</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-warning">
            <div class="d-flex justify-content-between">
                <div>
                    <a class="btn btn-falcon-default btn-sm mb-1" href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="" data-bs-original-title="Refresh" aria-label="Back to inbox">
                        <span class="fas fa-undo"></span>
                    </a>
                    <span class="mx-1 mx-sm-2 text-300">|</span>
                    <button class="btn btn-falcon-default btn-sm mb-1" type="button" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="" data-bs-original-title="Pencarian Data" aria-label="Archive">
                        <span class="fas fa-search"></span>
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
                        <th class="sort" data-sort="reg">No Registrasi</th>
                        <th class="sort" data-sort="name">Nama Pasien</th>
                        <th class="sort" data-sort="tgl">Tanggal Reg</th>
                        <th class="sort" data-sort="poli">Poliklinik</th>
                        <th class="sort" data-sort="doc">Dokter</th>
                        <th class="sort" data-sort="status">Status Reg</th>
                        <th class="sort" data-sort="act">Action</th>
                    </tr>
                </thead>
                <tbody class="fs--2">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                        @php
                            $user = DB::table('user_mains')
                                ->select('fullname')
                                ->where('userid', $datas->d_reg_order_poli_user)
                                ->first();
                        @endphp
                        <tr>
                            <td class="no">{{ $no++ }}</td>
                            <td class="reg fw-bold">{{ $datas->d_reg_order_code }} <br> <strong
                                    class="text-warning">{{ $datas->d_reg_order_poli_code }}</strong>
                                <br>
                                @if ($user)
                                    <span class="badge bg-primary">{{ $user->fullname }}</span>
                                @else
                                    <span class="badge bg-danger">Unknown</span>
                                @endif
                            </td>
                            <td class="name">{{ $datas->master_patient_name }} <br> {{ $datas->master_patient_code }}</td>
                            <td class="tgl">{{ $datas->d_reg_order_date }}</td>
                            <td class="poli">{{ $datas->t_layanan_data_name }}</td>
                            <td class="doc">{{ $datas->master_doctor_name }}</td>
                            <td class="text-center">
                                @if ($datas->d_reg_order_poli_status == 2)
                                    <span class="badge bg-danger">Not Verified</span>
                                @elseif ($datas->d_reg_order_poli_status == 3)
                                    <span class="badge bg-primary">Verified</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-falcon-warning dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Option</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        <button class="dropdown-item text-warning" data-bs-toggle="modal"
                                            data-bs-target="#modal-poliklinik" id="button-cetak-hasil"
                                            data-code="{{ $datas->d_reg_order_poli_code }}"><span class="fas fa-dna"></span>
                                            Cetak Hasil Pasien</button>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item" id="button-kirim-hasil"
                                            data-code="{{ $datas->d_reg_order_poli_code }}"><span
                                                class="fas fa-mail-bulk"></span>
                                            Kirim Hasil Ke Pasien</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    <script>
        $(document).on("click", "#button-cetak-hasil", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-poliklinik').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('verifikasi_poliklinik_dokumentasi_hasil_preview') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-poliklinik').html(data);
            }).fail(function () {
                $('#menu-poliklinik').html('eror');
            });
        });
        $(document).on("click", "#button-kirim-hasil", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won Send this Report!",
                icon: "success",
                showCancelButton: true,
                confirmButtonText: "Yes, Send it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#menu-poliklinik').html(
                        '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                    );
                    $.ajax({
                        url: "{{ route('verifikasi_poliklinik_dokumentasi_hasil_send_report') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "code": code
                        },
                        dataType: 'html',
                    }).done(function (data) {
                        swalWithBootstrapButtons.fire({
                            title: "success!",
                            text: "Your Report Has been Success.",
                            icon: "success"
                        });
                    }).fail(function () {
                        swalWithBootstrapButtons.fire({
                            title: "Failed",
                            text: "Gagal Kirim :)",
                            icon: "error"
                        });
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Your imaginary file is safe :)",
                        icon: "error"
                    });
                }
            });

        });
    </script>
@endsection
