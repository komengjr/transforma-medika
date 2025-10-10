@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row mb-3 ">
        <div class="col">
            <div class="card bg-200 shadow border border-primary bg-primary">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/app.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-white fs--1 mb-0 pt-2" style="color: white !important;">Welcome to </h6>
                            <h4 class="text-white fw-bold mb-1" style="color: white !important;">Trans <span
                                    class="text-white fw-medium" style="color: white !important;">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-white fs--1 mb-0" style="color: white !important;">Menu : </h6>
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Data <span
                                class="text-white fw-medium" style="color: white !important;">Absensi</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3 border border-primary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <form class="row g-1 needs-validation " novalidate="">
                        <div class="col-md-6 position-relative">
                            <label for="" class="my-0 text-warning">Nama Staff</label>
                            <select class="form-select js-choice" id="data_nama" size="1" name="organizerSingle"
                                style="font-size: 9px !important;"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value=""><small>Select Name...</small></option>
                                <option value="1">Massachusetts Institute</option>
                                <option>University of Chicago</option>
                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0 text-warning">Date Range</label>
                            <input class="form-control form-control-lg datetimepicker" id="data_date" type="text"
                                placeholder="y-m-d to y-m-d"
                                data-options='{"mode":"range","dateFormat":"Y-m-d","disableMobile":true}' />
                        </div>
                        <div class="col-md-3 position-relative pt-3">
                            <button class="btn btn-primary float-end" type="button" id="button-search-data">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card" id="menu-general-ledger">

    </div>
@endsection
@section('base.js')
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('asset/js/flatpickr.js') }}"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on("click", "#button-search-data", function (e) {
            e.preventDefault();
            var nama = document.getElementById("data_nama").value;
            var date = document.getElementById("data_date").value;
            console.log(date);

            $('#menu-general-ledger').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            if (date == "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#menu-general-ledger').html('');
            } else {
                $.ajax({
                    url: "{{ route('data_kehadiran_search') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "date": date,
                        "nama": nama
                    },
                    dataType: 'html',
                }).done(function (data) {
                    $('#menu-general-ledger').html(data);
                    // $('#button-login-system').html('<span class="fab fa-500px"></span> Log in');
                }).fail(function () {
                    console.log('error');

                });
            }
        });
    </script>
@endsection
