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
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/gl.png') }}" alt="" width="50" />
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
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">General <span
                                class="text-white fw-medium" style="color: white !important;">Ledger</span>
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
                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0 text-warning">Company</label>
                            <select class="form-select js-choice" id="data_company" size="1" name="organizerSingle"
                                style="font-size: 9px !important;"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value=""><small>Select Company...</small></option>
                                <option value="1"><small>Massachusetts Institute</small></option>
                                <option><small>University of Chicago</small></option>

                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0 text-warning">Financial Book</label>
                            <select class="form-select js-choice" id="data_financial" size="1" name="organizerSingle"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value=""><small>Select Financial</small></option>
                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0 text-warning">Date Range</label>
                            <input class="form-control form-control-lg datetimepicker" id="data_date" type="text"
                                placeholder="d/m/y to d/m/y"
                                data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true}' />
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0">Account</label>
                            <select class="form-select js-choice" id="organizerSingle" size="1" name="organizerSingle"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value=""><small>Select Account</small></option>
                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0">Project</label>
                            <select class="form-select js-choice" id="organizerSingle" size="1" name="organizerSingle"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value=""><small>Select Financial</small></option>
                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0">Project</label>
                            <select class="form-select js-choice" id="organizerSingle" size="1" name="organizerSingle"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value=""><small>Select Financial</small></option>
                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0">Project</label>
                            <select class="form-select js-choice" id="organizerSingle" size="1" name="organizerSingle"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value=""><small>Select Financial</small></option>
                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0">Project</label>
                            <select class="form-select js-choice" id="organizerSingle" size="1" name="organizerSingle"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value=""><small>Select Financial</small></option>
                            </select>
                        </div>
                        <div class="col-12 pt-3">
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
            var company = document.getElementById("data_company").value;
            var financial = document.getElementById("data_financial").value;
            var date = document.getElementById("data_date").value;
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
                    url: "{{ route('general_ledger_search') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "company": company,
                        "financial": financial
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
