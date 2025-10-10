@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <style>
        #button-dokumentasi-hasil-lab:hover {
            cursor: pointer;
            background: rgba(11, 133, 215, 1);
        }
    </style>
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="card bg-200 shadow border border-primary">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3" src="{{ asset('img/verif.png') }}" alt="" width="80" />
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
                        <h4 class="text-primary fw-bold mb-0">Laboratorium <span class="text-primary fw-medium">Specimen
                                Collection</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-lg-4 pe-lg-2 mb-3">
            <div class="sticky-sidebar">
                <div class="card mb-lg-0">
                    <div class="card-header bg-300">
                        <h5 class="mb-0">Specimen Collection</h5>
                    </div>
                    <div class="card-body bg-light">
                        <div class="col-12 mb-2">
                            <div class="input-group mb-2"> <span class="input-group-text"><i
                                        class="fas fa-calendar-day"></i></span>
                                <input class="form-control datetimepicker form-control-lg" id="timepicker3" type="text"
                                    placeholder="d/m/y to d/m/y"
                                    data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true,"locale":"en"}' />
                            </div>
                            <div class="input-group"> <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                <input type="text" name="no_reg"
                                    class="form-control form-control-lg border-start-0 bg-white" id="no_reg"
                                    placeholder="Scan Disini" onkeydown="search(this)" autofocus>
                            </div>
                        </div>
                        <!-- @foreach ($data as $datas)
                                    <div class="col-12 mb-2">
                                        <div class="card border h-100 border-warning remove-class" id="button-dokumentasi-hasil-lab"
                                            data-code="{{$datas->d_reg_order_code}}">
                                            <div class="card-body fs--2 text-dark py-2">
                                                <div class="card-title my-0">Nama</div>
                                                <p class="card-text">No. reg : <strong
                                                        class="text-warning">Reg</strong>, Menuju Poli
                                                    <strong class="text-dark">Nama</strong> dengan dokter Spesialis
                                                    <strong class="text-dark">Doktor</strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 ps-lg-2">
            <span id="menu-detail-specimen"></span>
        </div>
    </div>
    <div class="card mt-0">
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col-md">
                    {{-- <h5 class="mb-2 mb-md-0">Nice Job! You're almost done</h5> --}}
                </div>
                <div class="col-auto">
                    {{-- <button class="btn btn-falcon-default btn-sm me-2">Save</button> --}}
                    {{-- <button class="btn btn-falcon-primary btn-sm">Make your event live </button> --}}
                </div>
            </div>
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
    <script src="{{ asset('asset/js/swetalert.js') }}"></script>
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>

    <script>
        function search(ele) {
            if (event.key === 'Enter') {
                var code = document.getElementById('no_reg').value;
                if (code == "") {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "error",
                        title: "Scan Tidak Boleh Kosong"
                    });
                    $('#menu-detail-specimen').html("");
                } else {
                    $.ajax({
                        url: "{{ route('data_specimen_collection_lab_cari_data') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "code": code,
                        },
                        dataType: 'html',
                    }).done(function (data) {
                        document.getElementById('no_reg').value = "";
                        if (data == 'false') {
                            $('#menu-detail-specimen').html("");
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "warning",
                                title: "Data Tidak Ditemukan"
                            });
                        } else if (data == 'done') {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "info",
                                title: "Data Sudah di Handling"
                            });
                            $('#menu-detail-specimen').html("");
                        } else if (data == 'not') {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "warning",
                                title: "Data Belum Melakukan Handling Pasien"
                            });
                            $('#menu-detail-specimen').html("");
                        } else {
                            $('#menu-detail-specimen').html(data);
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "success",
                                title: "Data Ditemukan"
                            });
                        }

                    }).fail(function () {
                        $('#menu-daftar-inevntaris').html(
                            '<i class="fa fa-info-sign"></i> Something went wrong, Please try again...'
                        );
                    });
                }
            }
        };
    </script>
    <script>
        $(document).on("click", "#button-simpan-proses-specimen-collection", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: true
            });
            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#menu-proses-specimen-collection').html(
                        '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                    );
                    $.ajax({
                        url: "{{ route('data_specimen_collection_lab_proses_simpan_fix') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "code": code
                        },
                        dataType: 'html',
                    }).done(function (data) {
                        swalWithBootstrapButtons.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                        location.reload();
                    }).fail(function () {
                        swalWithBootstrapButtons.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
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
