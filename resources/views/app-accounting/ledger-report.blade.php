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
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/ledger.png') }}" alt="" width="50" />
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
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Ledger <span
                                class="text-white fw-medium" style="color: white !important;">Report</span>
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
                    <form class="row g-1 needs-validation" novalidate="">
                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0 text-warning">Company</label>
                            <select class="form-select js-choice" id="organizerSingle" size="1" name="organizerSingle"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="">Select Company...</option>
                                <option>Massachusetts Institute of Technology</option>
                                <option>University of Chicago</option>
                                <option>GSAS Open Labs At Harvard</option>
                                <option>California Institute of Technology </option>
                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0 text-warning">Financial Book</label>
                            <select class="form-select js-choice" id="organizerSingle" size="1" name="organizerSingle"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="">Select Financial Book...</option>
                                <option>Massachusetts Institute of Technology</option>
                                <option>University of Chicago</option>
                                <option>GSAS Open Labs At Harvard</option>
                                <option>California Institute of Technology </option>
                            </select>
                        </div>

                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0 text-warning">Date Range</label>
                            <input class="form-control form-control-lg datetimepicker" id="floatingInputValid" type="text"
                                placeholder="d/m/y to d/m/y"
                                data-options='{"mode":"range","dateFormat":"d/m/y","disableMobile":true}' />
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0">Account</label>
                            <select class="form-select js-choice" id="organizerSingle" size="1" name="organizerSingle"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="">Select Financial Book...</option>
                                <option>Massachusetts Institute of Technology</option>
                                <option>University of Chicago</option>
                                <option>GSAS Open Labs At Harvard</option>
                                <option>California Institute of Technology </option>
                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0">Project</label>
                            <select class="form-select js-choice" id="organizerSingle" size="1" name="organizerSingle"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="">Select Financial Book...</option>
                                <option>Massachusetts Institute of Technology</option>
                                <option>University of Chicago</option>
                                <option>GSAS Open Labs At Harvard</option>
                                <option>California Institute of Technology </option>
                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0">Project</label>
                            <select class="form-select js-choice" id="organizerSingle" size="1" name="organizerSingle"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="">Select Financial Book...</option>
                                <option>Massachusetts Institute of Technology</option>
                                <option>University of Chicago</option>
                                <option>GSAS Open Labs At Harvard</option>
                                <option>California Institute of Technology </option>
                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0">Project</label>
                            <select class="form-select js-choice" id="organizerSingle" size="1" name="organizerSingle"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="">Select organizer...</option>
                                <option>Massachusetts Institute of Technology</option>
                                <option>University of Chicago</option>
                                <option>GSAS Open Labs At Harvard</option>
                                <option>California Institute of Technology </option>
                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <label for="" class="my-0">Project</label>
                            <select class="form-select js-choice" id="organizerSingle" size="1" name="organizerSingle"
                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                <option value="">Select Financial Book...</option>
                                <option>Massachusetts Institute of Technology</option>
                                <option>University of Chicago</option>
                                <option>GSAS Open Labs At Harvard</option>
                                <option>California Institute of Technology </option>
                            </select>
                        </div>
                        <div class="col-12 pt-3">
                            <button class="btn btn-primary float-end" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-primary">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="m-0"><span class="badge bg-primary m-0 p-0">General Ledger</span></h3>
                </div>
                <div class="col-auto">
                    <!-- <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-company"
                                    id="button-add-company" data-code="123"><span class="far fa-edit"></span>
                                    Tambah Perusahaan</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                    id="button-data-barang-cabang" data-code="123"><span class="far fa-folder-open"></span>
                                    History</button>
                            </div>
                        </div> -->
                </div>
            </div>
        </div>
        <div class="card-body border-top p-3">
            <table id="example" class="table table-striped nowrap" style="width:100%">
                <thead class="bg-200 text-700">
                    <tr>
                        <th>No</th>
                        <th>Posting Date</th>
                        <th>Account</th>
                        <th>Debit</th>
                        <th>Kredit</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp

                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('base.js')
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('asset/js/flatpickr.js') }}"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
@endsection
