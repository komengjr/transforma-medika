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
                    <img class="ms-3 mx-3 m-2" src="{{ asset('img/super.png') }}" alt="" width="50" />
                    <div>
                        <h6 class="text-primary fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-primary fw-bold mb-1">{{ Env('APP_LABEL')}} <span class="text-primary fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-primary fs--1 mb-0">Menu : </h6>
                    <h4 class="text-primary fw-bold mb-0">Supervisior <span class="text-primary fw-medium">Pelayanan</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header bg-primary">
        <div class="d-flex justify-content-between">
            <div class="row g-3">
                <div class="col-md-4">
                    <select class="form-select js-choice" id="kategori_pasien" size="1" name="organizerSingle" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategori as $cat)
                        <option value="{{ $cat->t_pasien_cat_code }}">{{ $cat->t_pasien_cat_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select js-choice" id="layanan_pasien" size="1" name="organizerSingle" data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Pilih Layanan</option>
                        <option value="all">All</option>
                        @foreach ($layanan as $lay)
                        <option value="{{$lay->t_layanan_cat_code}}">{{$lay->t_layanan_cat_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <input class="form-control form-control-lg datetimepicker" id="timepicker3" type="text" placeholder="d-m-y to d-m-y" data-options='{"mode":"range","dateFormat":"d-m-y","disableMobile":true,"locale":"in"}' />
                </div>
            </div>
            <div class="d-flex" style="padding-left: 10px;">
                <button class="btn btn-falcon-warning" id="button-pencarian-data-pasien"><span class="fas fa-search"></span></button>
            </div>
        </div>
    </div>
    <div class="card-body border-top p-3" id="menu-pencarian-data-pasien">

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
<script>
    $(document).on("click", "#button-pencarian-data-pasien", function(e) {
        e.preventDefault();
        // var code = $(this).data("code");
        var kategori = document.getElementById("kategori_pasien").value;
        var layanan = document.getElementById("layanan_pasien").value;
        if (kategori == "") {
            Swal.fire({
                title: "Ada Yang Kosong ?",
                text: "Coba Lihat Pilihan Kategori?",
                icon: "question"
            });
        } else if (layanan == "") {
            Swal.fire({
                title: "Ada Yang Kosong ?",
                text: "Coba Lihat Pilihan Layanan?",
                icon: "question"
            });
        } else {
            $('#menu-pencarian-data-pasien').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('menu_pelayanan_supervisior_find') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "kategori": kategori,
                    "layanan": layanan,
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-pencarian-data-pasien').html(data);
                const Toast = Swal.mixin({
                    toast: true,
                    position: "bottom-end",
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
                    title: "Data Pencarian Pasien"
                });
            }).fail(function() {
                Swal.fire({
                    title: "The Information Slow?",
                    text: "That thing is still around?",
                    icon: "question"
                });
            });
        }
    });
</script>
@endsection
