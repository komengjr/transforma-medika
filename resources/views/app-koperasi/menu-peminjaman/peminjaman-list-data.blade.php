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
                    <h4 class="text-success fw-bold mb-0">Peminjaman <span class="text-success fw-medium">List Data</span>
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
        <table id="example" class="table table-striped" style="width:100%">
            <thead class="bg-300 fs--1">
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Nominal Peminjaman</th>
                    <th>Bunga</th>
                    <th>Admin</th>
                    <th>Tenor Peminjaman</th>
                    <th>Kepala Cabang</th>
                    <th>Ketua Koperasi</th>
                    <th>Status Peminjaman</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="fs--2">
                @php
                $no = 1;
                @endphp
                @foreach ($data as $datas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $datas->kop_master_peserta_name }} <br>{{ $datas->kop_master_peserta_nip }} <br>{{ $datas->kop_master_peserta_nik }}</td>
                    <td>{{ $datas->kop_proses_uang_tgl }}</td>
                    <td>@currency($datas->kop_proses_uang_nominal)</td>
                    <td>{{ $datas->kop_proses_uang_bunga }} %</td>
                    <td>{{ $datas->kop_proses_uang_admin }} %</td>
                    <td>{{ $datas->kop_proses_uang_tenor }} Bulan</td>
                    <td>
                        @php
                        $kacab = DB::table('kop_user_verifikasi')->where('kop_user_verifikasi_code',$datas->kop_proses_uang_kacab)->first();
                        @endphp
                        @if ($kacab)
                        {{ $kacab->kop_user_verifikasi_name }}
                        @endif
                    </td>
                    <td>
                        @php
                        $ketua = DB::table('kop_user_verifikasi')->where('kop_user_verifikasi_code',$datas->kop_proses_uang_ketua)->first();
                        @endphp
                        @if ($ketua)
                        {{ $ketua->kop_user_verifikasi_name }}
                        @endif
                    </td>
                    <td>
                        @if ($datas->kop_proses_uang_status == '0')
                        <span class="badge bg-info">Peminjaman Baru</span>
                        @elseif ($datas->kop_proses_uang_status == '1')
                        <span class="badge bg-warning">Peminjaman diproses</span>
                        @elseif ($datas->kop_proses_uang_status == '2')
                        <span class="badge bg-success">Peminjaman Lunas</span>
                        @elseif ($datas->kop_proses_uang_status == '3')
                        <span class="badge bg-primary">Peminjaman Lunas</span>
                        @elseif ($datas->kop_proses_uang_status == '-1')
                        <span class="badge bg-danger">Peminjaman Di Batalkan</span>
                        @endif
                        @php
                        $jurnal = DB::table('kop_fin_jurnal')
                        ->where('jurnal_ref_table','=','kop_proses_peminjaman_uang')
                        ->where('jurnal_ref_code',$datas->kop_proses_uang_code)
                        ->first();
                        @endphp
                        @if ($jurnal)
                        <br> <span class="badge bg-primary">{{ $jurnal->jurnal_no_bukti }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                    class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                @if ($datas->kop_proses_uang_status == '0')
                                <button class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#modal-koperasi"
                                    id="button-proses-data-pengajuan" data-code="{{$datas->kop_proses_uang_code}}"><span
                                        class="far fa-folder-open"></span>
                                    Proses Pengajuan Peminjaman</button>
                                @elseif ($datas->kop_proses_uang_status == '1')
                                <button class="dropdown-item text-warning" data-bs-toggle="modal" data-bs-target="#modal-koperasi"
                                    id="button-cek-status-kontrak" data-code="{{$datas->kop_proses_uang_code}}"><span
                                        class="fab fa-leanpub"></span>
                                    Cek Status Kontrak</button>
                                <button class="dropdown-item text-primary" data-bs-toggle="modal" data-bs-target="#modal-koperasi"
                                    id="button-cetak-slip-peminjaman" data-code="{{$datas->kop_proses_uang_code}}"><span
                                        class="fas fa-print"></span>
                                    Cetak Slip Peminjaman</button>
                                @elseif ($datas->kop_proses_uang_status == '2')
                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-koperasi"
                                    id="button-cetak-pengajuain-peminjaman" data-code="{{$datas->kop_proses_uang_code}}"><span
                                        class="fas fa-print"></span>
                                    Cetak Pengajuan Peminjaman</button>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
            location.reload();
        }).fail(function() {
            $('#loading-button-kirim').html('eror');
        });
    });
    $(document).on("click", "#button-cetak-slip-peminjaman", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_peminjaman_list_cetak_slip_pengajuan') }}",
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
    $(document).on("click", "#button-cek-status-kontrak", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-koperasi').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_peminjaman_list_cek_kontrak') }}",
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
    $(document).on("click", "#button-proses-pembayaran-bulanan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-status-kontrak').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_peminjaman_list_cek_kontrak_payment') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-add-data-verifikasi').html('');
            $('#menu-status-kontrak').html(data);
        }).fail(function() {
            $('#menu-status-kontrak').html('eror');
        });
    });
    $(document).on("click", "#button-fix-payment-kontrak-bulanan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var akun = document.getElementById('akun_pembayaran').value;
        if (akun == "") {
            Swal.fire('Failed!', 'Akun Nya Harus di pilih', 'error').then(() => {

            });
        } else {
            $('#menu-status-kontrak').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('menu_peminjaman_list_cek_kontrak_payment_fix') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "akun": akun,
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                setTimeout(() => {
                    Swal.fire('Berhasil!', 'Pembayaran Berhasil dilakukan', 'success').then(() => {
                        location.reload();
                    });
                }, 1000);
            }).fail(function() {
                $('#menu-status-kontrak').html('eror');
            });
        }
    });
</script>

<script>
    $(document).on("click", "#button-simpan-data-verifikasi", function(e) {
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
                var code = $(this).data("code");
                var akun = document.getElementById('akun_pencairan').value;
                if (akun == "") {
                    swalWithBootstrapButtons.fire({
                        title: "Failed",
                        text: "Gagal Menyimpan Karena Akun Belum dipilih",
                        icon: "error"
                    });
                } else {
                    $('#loading-button-proses').html(
                        '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                    );
                    $.ajax({
                        url: "{{ route('menu_peminjaman_list_proses_pengajuan_save_verif') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "code": code,
                            "akun": akun,
                        },
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
                }
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Gagal Menyimpan",
                    icon: "error"
                });
            }
        });
    });

    $(document).on("click", "#button-penyelesaian-data-kontrak", function(e) {
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
                var code = $(this).data("code");
                $('#loading-button-proses').html(
                    '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                );
                $.ajax({
                    url: "{{ route('menu_peminjaman_list_cek_kontrak_penyelesaian_kontrak') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code
                    },
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
<!-- Kontrak baru -->
<script>
    $(document).on("click", "#button-create-data-kontrak-baru", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $('#menu-data-show-peminjaman-baru').html(
            '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('menu_peminjaman_list_proses_pengajuan_baru') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-data-show-peminjaman-baru').html(data);
            $('#menu-add-data-verifikasi').html('');
        }).fail(function() {
            $('#menu-data-show-peminjaman-baru').html('eror');
        });
    });
    $(document).on("click", "#button-save-proses-pengajuan-peminjaman-baru", function(e) {
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
                    url: "{{ route('menu_peminjaman_list_proses_pengajuan_baru_save') }}",
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
                            '<button class="btn btn-primary d-block w-100" type="button" id="button-save-proses-pengajuan-peminjaman-baru">Pengajuan Peminjaman</button>'
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
