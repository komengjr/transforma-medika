@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <style>
        #button-handling-pasien-radiologi:hover {
            cursor: pointer;
            background: rgb(215, 106, 11);
        }
    </style>
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="card bg-200 shadow border border-danger">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3" src="{{ asset('img/poli.png') }}" alt="" width="80" />
                        <div>
                            <h6 class="text-danger fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-danger fw-bold mb-1">Trans <span class="text-danger fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-danger fs--1 mb-0">Menu : </h6>
                        <h4 class="text-danger fw-bold mb-0">Radiologi <span class="text-danger fw-medium">Handling</span>
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
                        <h5 class="mb-0">Daftar Handling</h5>
                    </div>
                    <div class="card-body bg-light">
                        <div class="col-12 mb-2">
                            <div class="input-group"> <span class="input-group-text"><i class="fas fa-qrcode"></i></span>
                                <input type="text" name="nik"
                                    class="form-control form-control-lg border-start-0 bg-white" id="nik"
                                    placeholder="Scan Disini">
                            </div>
                        </div>
                        @foreach ($data as $datas)
                            <div class="col-12 mb-2">
                                <div class="card border h-100 border-danger remove-class"
                                    id="button-handling-pasien-radiologi" data-code="{{ $datas->d_reg_order_rad_code  }}">
                                    <div class="card-body fs--2 text-dark py-2">
                                        <div class="card-title my-0">{{ $datas->master_patient_name }}</div>
                                        <p class="card-text">No. reg : <strong
                                                class="text-primary">{{ $datas->d_reg_order_code }}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 ps-lg-2">
            <span id="menu-detail-handling"></span>
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
    <div class="modal fade" id="modal-radiologi-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-radiologi-full"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-radiologi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-radiologi"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>


    <script>
        $(document).on("click", "#button-handling-pasien-radiologi", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $(".remove-class").removeClass("bg-warning");
            $(this).addClass("bg-warning");
            $('#menu-detail-handling').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('menu_radiologi_handling_pasien') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-detail-handling').html(data);
            }).fail(function() {
                $('#menu-detail-handling').html('eror');
            });
        });
        $(document).on("click", "#button-order-layanan-dokter", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            var reg = $(this).data("reg");
            $('#menu-order-layanan-dokter').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('data_registrasi_poliklinik_handling_order_layanan') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                    "reg": reg,
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-order-layanan-dokter').html(data);
            }).fail(function() {
                $('#menu-order-layanan-dokter').html('eror');
            });
        });
    </script>

@endsection
