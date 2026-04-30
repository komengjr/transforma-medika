@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

@endsection
@section('content')


<div class="card mb-3 border border-success">
    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../../asset/img/icons/spot-illustrations/corner-4.png);">
    </div>
    <!--/.bg-holder-->

    <div class="card-body position-relative">
        <div class="row">
            <div class="col-lg-8">
                <h3>Pengajuan Peminjaman Uang</h3>
                <p class="mt-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio vitae quae beatae, omnis asperiores molestiae provident ducimus, labore explicabo ratione quas laudantium, libero tempore voluptates dolores. Autem est saepe soluta.</p>
                <button class="btn btn-primary btn-sm" type="button" id="button-cari-data-peserta" data-bs-toggle="modal" data-bs-target="#modal-peminjaman-full"><span class="fas fa-user-shield"></span> Cari Data</button>
            </div>
        </div>
    </div>
</div>
<div id="menu-form-peminjaman-uang"></div>


@endsection
@section('base.js')
<div class="modal fade" id="modal-peminjaman-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-peminjaman-full"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-peminjaman" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-peminjaman"></div>
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
    $(document).on("click", "#button-cari-data-peserta", function(e) {
        e.preventDefault();
        $('#menu-peminjaman-full').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_peminjaman_uang_cari_peserta') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": "{{Auth::user()->userid}}"
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-peminjaman-full').html(data);
        }).fail(function() {
            $('#menu-peminjaman-full').html('eror');
        });
    });
    $(document).on("click", "#button-pilih-data-peserta", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-form-peminjaman-uang').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_peminjaman_uang_pilih_peserta') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-form-peminjaman-uang').html(data);
        }).fail(function() {
            $('#menu-form-peminjaman-uang').html('eror');
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
                    swalWithBootstrapButtons.fire({
                        title: "Sukses!",
                        text: "Your file has been Sukses.",
                        icon: "success"
                    });
                    location.reload();
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
