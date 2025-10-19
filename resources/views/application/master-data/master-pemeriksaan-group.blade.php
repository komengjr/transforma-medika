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
                    <h4 class="text-primary fw-bold mb-0">Kelompok <span class="text-primary fw-medium">Pemeriksaan</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header bg-github text-github">
        <div class="row align-items-center">
            <div class="col-md-4">
                <label class="form-label text-warning" for="inputAddress">Layanan Pemeriksaan</label>
                <select name="layanan" id="layanan" class="form-control choices-single-layanan">
                    <option value="">Pilih Layanan Pemeriksaan</option>
                    @foreach ($layanan as $lay)
                    <option value="{{ $lay->t_pemeriksaan_cat_code  }}">{{ $lay->t_pemeriksaan_cat_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4" id="menu-pemeriksaan">

            </div>

        </div>
    </div>
    <div class="card-body border-top p-3" id="data-table-pemeriksaan">

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
            <div id="menu-modal-pemeriksaan"></div>
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
    new window.Choices(document.querySelector(".choices-single-layanan"));
</script>
<script>
    $(document).on("click", "#button-add-data-pemeriksaan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-pemeriksaan').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_pemeriksaan_data_add') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-pemeriksaan').html(data);
        }).fail(function() {
            $('#menu-pemeriksaan').html('eror');
        });
    });
    $(document).on("click", "#button-edit-pemeriksaan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-pemeriksaan').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_pemeriksaan_update') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-pemeriksaan').html(data);
        }).fail(function() {
            $('#menu-pemeriksaan').html('eror');
        });
    });
    $(document).on("click", "#button-add-jenis-pemeriksaan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-modal-pemeriksaan').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_pemeriksaan_group_add_pemeriksaan') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-modal-pemeriksaan').html(data);
        }).fail(function() {
            $('#menu-modal-pemeriksaan').html('eror');
        });
    });
    $(document).on("click", "#button-add-value-pemeriksaan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-modal-pemeriksaan').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_pemeriksaan_group_add_value_pemeriksaan') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-modal-pemeriksaan').html(data);
        }).fail(function() {
            $('#menu-modal-pemeriksaan').html('eror');
        });
    });
</script>
<script>
    $('#layanan').on("change", function() {
        var dataid = document.getElementById("layanan").value;
        if (dataid == "") {
            Lobibox.notify('warning', {
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: true,
                position: 'top right',
                icon: 'fas fa-info-circle',
                msg: 'Pastikan Sudah dipilih'
            });
        } else {
            $.ajax({
                url: "{{ route('master_pemeriksaan_group_layanan') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": dataid,
                },
                dataType: 'html',
            }).done(function(data) {
                $("#menu-pemeriksaan").html(data);
                $("#data-table-pemeriksaan").html("");
            }).fail(function() {
                console.log('eror');
            });
        }
    });

</script>
@endsection
