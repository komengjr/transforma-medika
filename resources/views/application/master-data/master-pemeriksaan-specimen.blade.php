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
                    <img class="ms-3 mx-3 m-2" src="{{ asset('img/kategori.png') }}" alt="" width="50" />
                    <div>
                        <h6 class="text-primary fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-primary fw-bold mb-1">TRANS <span class="text-primary fw-medium">Medical
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-primary fs--1 mb-0">Menu : </h6>
                    <h4 class="text-primary fw-bold mb-0">Specimen <span class="text-primary fw-medium">Pemeriksaan</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="card mb-3"><img class="card-img-top" src="../../assets/img/generic/13.jpg" alt="" />
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col">
                    <div class="d-flex">
                        <div class="calendar me-2"><span class="calendar-month">Dec</span><span class="calendar-day">31
                            </span></div>
                        <div class="flex-1 fs--1">
                            <h5 class="fs-0">FREE New Year's Eve Midnight Harbor Fireworks</h5>
                            <p class="mb-0">by <a href="#!">Boston Harbor Now</a></p><span
                                class="fs-0 text-warning fw-semi-bold">$49.99 – $89.99</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-auto mt-4 mt-md-0">
                    <button class="btn btn-falcon-default btn-sm me-2" type="button"><span
                            class="fas fa-heart text-danger me-1"></span>235</button>
                    <button class="btn btn-falcon-default btn-sm me-2" type="button"><span
                            class="fas fa-share-alt me-1"></span>Share</button>
                    <button class="btn btn-falcon-primary btn-sm px-4 px-sm-5" type="button">Register</button>
                </div>
            </div>
        </div>
    </div> --}}
<div class="row g-3">
    <div class="col-lg-8">
        <div class="sticky-sidebar">
            <div class="card mb-3 mb-lg-0">
                <div class="card-header bg-300">
                    <h5 class="mb-0">Data Pemeriksaan</h5>
                </div>
                <div class="card-body fs--1">
                    <table id="example" class="table table-striped nowrap" style="width:100%">
                        <thead class="bg-200 text-700">
                            <tr>
                                <th>No</th>
                                <th>Kategori Pemeriksaan</th>
                                <th>Nama Pemeriksaan</th>
                                <th>Jenis Pemeriksaan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach ($data as $datas)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $datas->t_pemeriksaan_cat_name }}</td>
                                <td>{{ $datas->t_pemeriksaan_data_name }}</td>
                                <td>{{ $datas->t_pemeriksaan_list_name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-falcon-primary" id="button-pilih-specimen" data-code="{{ $datas->t_pemeriksaan_list_code  }}"><span class="fas fa-align-left me-1"
                                            data-fa-transform="shrink-3"></span>Option</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-light  border-top">
                    <!-- <a class="btn btn-link d-block w-100" href="../../app/events/event-list.html">All Events<span
                            class="fas fa-chevron-right ms-1 fs--2"></span></a> -->
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-3 mb-lg-0">
            <div class="card mb-3 mb-lg-0">
                <div class="card-header bg-300">
                    <h5 class="mb-0">Data Specimen</h5>
                </div>
                <span id="menu-master-specimen"></span>

            </div>
        </div>
    </div>

</div>
@endsection
@section('base.js')
<div class="modal fade" id="modal-pemeriksaan" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-pemeriksaan"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
<script>
    new window.Choices(document.querySelector(".choices-single-jenis"));
</script>
<script>
    $(document).on("click", "#button-pilih-specimen", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-master-specimen').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_pemeriksaan_specimen_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-master-specimen').html(data);
        }).fail(function() {
            $('#menu-master-specimen').html('eror');
        });
    });
    $(document).on("click", "#button-simpan-data-specimen-pemeriksaan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var specimen = document.getElementById('data_specimen').value;
        if (specimen == "") {
            Swal.fire({
                title: 'Error!',
                text: 'Do you want to continue',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        } else {

            $.ajax({
                url: "{{ route('master_pemeriksaan_specimen_save') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                    "specimen": specimen
                },
                dataType: 'html',
            }).done(function(data) {
                if (data == 1) {
                    $('#menu-master-specimen-detail').html(
                        '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                    );
                    $('#menu-master-specimen-detail').html(data);
                } else if (data == 0) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Specimen Is There',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                } else {
                    $('#menu-master-specimen-detail').html(
                        '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                    );
                    $('#menu-master-specimen-detail').html(data);
                }
            }).fail(function() {
                $('#menu-master-specimen-detail').html('eror');
            });
        }
    });
    $('#master_pemeriksaan').on("change", function() {
        var dataid = document.getElementById('master_pemeriksaan').value;
        if (dataid == '') {
            Lobibox.notify('warning', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: true,
                position: 'top right',
                icon: 'fas fa-info-circle',
                msg: 'Pastikan Master Sudah dipilih'
            });
            $("#menu-master-pemeriksaan").html('');
            $("#menu-group-pemeriksaan").html('');
        } else {
            $.ajax({
                url: "{{ route('master_pemeriksaan_harga_master') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": dataid,
                },
                dataType: 'html',
            }).done(function(data) {
                $("#menu-master-pemeriksaan").html(data);
            }).fail(function() {
                console.log('eror');
            });
        }
    });
</script>
@endsection
