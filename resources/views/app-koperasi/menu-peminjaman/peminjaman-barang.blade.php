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
        <div class="card bg-200 shadow border border-success">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3" src="{{ asset('img/koperasi.png') }}" alt="" width="60" />
                    <div>
                        <h6 class="text-success fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-success fw-bold mb-1">{{ Env('APP_LABEL')}} <span
                                class="text-success fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-success fs--1 mb-0">Menu : </h6>
                    <h4 class="text-success fw-bold mb-0">Peminjaman <span class="text-success fw-medium">Barang</span>
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


            </div>
            <div class="d-flex">
                <input class="form-control datetimepicker" id="timepicker3" type="text" placeholder="Y-m-d to Y-m-d"
                    data-options='{"mode":"range","dateFormat":"Y-m-d","disableMobile":true,"locale":"en"}'
                    onchange="search(this)" />
            </div>
        </div>
    </div>
    <div class="card-body border-top p-3" id="hasil-pencarian-list">

    </div>
</div>

@endsection
@section('base.js')
<div class="modal fade" id="modal-koperasi-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-koperasi-full"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-koperasi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-koperasi"></div>
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
    $(document).on("click", "#button-proses-data-pengajuan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_peminjaman_list_proses_pengajuan') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-koperasi').html(data);
        }).fail(function() {
            $('#menu-koperasi').html('eror');
        });
    });
    $(document).on("click", "#button-kirim-verifikasi-pengajuan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#loading-button-kirim').html(
            '<button class="btn btn-falcon-primary btn-sm" type="button" disabled=""><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>'
        );
        $.ajax({
            url: "{{ route('menu_peminjaman_list_proses_pengajuan_send_verif') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#loading-button-kirim').html(data);
        }).fail(function() {
            $('#loading-button-kirim').html('eror');
        });
    });
    $(document).on("click", "#button-cetak-pengajuain-peminjaman", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_peminjaman_list_cetak_pengajuan') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-koperasi').html(data);
        }).fail(function() {
            $('#menu-koperasi').html('eror');
        });
    });
</script>

<script>
    $(document).on("click", "#button-proses-pengajuan-peminjaman", function(e) {
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: true
        });
        swalWithBootstrapButtons.fire({
            title: "Apakah Kamu yakin >?",
            text: "Kamu Yakin Untuk Proses Data ini ?",
            icon: "success",
            showCancelButton: true,
            confirmButtonText: "Yes, Setuju",
            cancelButtonText: "No, Batal",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                var data = $("#form-pengajuan-peminjaman-uang").serialize();
                $('#loading-button-proses').html(
                    '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                );
                $.ajax({
                    url: "{{ route('menu_peminjaman_uang_proses_pengajuan') }}",
                    type: "POST",
                    cache: false,
                    data: data,
                    dataType: 'html',
                }).done(function(data) {
                    if (data == 1) {
                        swalWithBootstrapButtons.fire({
                            title: "Sukses!",
                            text: "Your file has been Sukses.",
                            icon: "success"
                        });
                        location.reload();
                    } else {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Gagal Menyimpan",
                            icon: "error"
                        });
                        $('#loading-button-proses').html(
                            '<button class="btn btn-primary d-block w-100" type="button" id="button-proses-pengajuan-peminjaman">Pengajuan Peminjaman</button>'
                        );
                    }
                }).fail(function() {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Gagal Menyimpan",
                        icon: "error"
                    });
                });


            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Gagal Menyimpan",
                    icon: "error"
                });

            }
        });


    });
</script>
@endsection
