@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <style>
        #button-pick-request {
            cursor: pointer;
        }

        #button-pick-request:hover {
            background: rgb(223, 217, 25);
        }

        #button-terima-order-barang-peminjaman:hover {
            background: rgb(223, 217, 25);
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="row mb-3 ">
        <div class="col">
            <div class="card bg-200 shadow border border-primary bg-primary">
                <div class="row gx-0 flex-between-center" style="color: white !important;">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/pasien.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-white fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-white fw-bold mb-1">{{ env('APP_LABEL')}} <span
                                    class="text-white fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-white fs--1 mb-0">Menu : </h6>
                        <h4 class="text-white fw-bold mb-0">Data <span class="text-white fw-medium">Pasien</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-primary">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Data Pasien</span></h3>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-pegawai-xl"
                                id="button-add-pegawai" data-code="123"><span class="far fa-edit"></span>
                                Tambah Pasien</button>
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                id="button-data-barang-cabang" data-code="123"><span class="far fa-folder-open"></span>
                                History</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border-top p-3">
            <table id="example" class="table table-striped nowrap" style="width:100%">
                <thead class="bg-400  fs--2">
                    <tr>
                        <th>Gambar</th>
                        <th>No Rekam Medik</th>
                        <th>Nama Pasien</th>
                        <th>NIK </th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>No Handphone</th>
                        <th>Acc</th>
                    </tr>
                </thead>
                <tbody class="fs--1 list">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                        <tr id="button-pilih-data-pasien" data-code="{{ $datas->master_patient_code }}">
                            <td>
                                @if ($datas->master_patient_profile == "")
                                    <img class="h-60 w-60 overflow-hidden img-thumbnail shadow-sm"
                                        src="{{ asset('img/pasien.png') }}" width="100" alt="">
                                @else
                                    <img class="h-60 w-60 overflow-hidden img-thumbnail shadow-sm"
                                        src="{{ Storage::url($datas->master_patient_profile) }}" width="100" alt="">
                                @endif

                            </td>
                            <td><strong>{{ $datas->master_patient_code }}</strong></td>
                            <td>{{ $datas->master_patient_name }}</td>
                            <td>{{ $datas->master_patient_nik }}</td>
                            <td>
                                @if ($datas->master_patient_jk == 'l')
                                    Laki - Laki
                                @else
                                    Perempuan
                                @endif
                            </td>
                            <td>{{ $datas->master_patient_tempat_lahir }}</td>
                            <td>{{ $datas->master_patient_tgl_lahir }}</td>
                            <td>{{ $datas->master_patient_no_hp }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                        type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                            class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Menu</button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-pegawai-xl"
                                            id="button-update-patient" data-code="{{$datas->master_patient_code}}"><span
                                                class="far fa-edit"></span>
                                            Update Pasien</button>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                            id="button-data-barang-cabang" data-code="123"><span
                                                class="far fa-folder-open"></span>
                                            History Pasien</button>
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
    <div class="modal fade" id="modal-pegawai-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-pegawai-xl"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    <script>
        $(document).on("click", "#button-add-pegawai", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-pegawai-xl').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('master_data_pegawai_add') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-pegawai-xl').html(data);
            }).fail(function () {
                $('#menu-pegawai-xl').html('eror');
            });
        });
        $(document).on("click", "#button-simpan-data-pegawai", function (e) {
            e.preventDefault();
            var data = $("#form-pegawai-baru").serialize();
            $('#menu-add-data-pegawai').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('master_data_pegawai_save') }}",
                type: "POST",
                cache: false,
                data: data,
                dataType: 'html',
            }).done(function (data) {
                if (data == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Ada Kesalahan Teknis Pada Pengisian!",
                        footer: '<a href="#">Why do I have this issue?</a>'
                    });
                    $('#menu-add-data-pegawai').html('<button class="btn btn-success float-end" id="button-simpan-data-pegawai" data-code="">Simpan Data</button>');
                } else {
                    $('#menu-add-data-pegawai').html(data);
                }
            }).fail(function () {
                $('#menu-add-data-pegawai').html('eror');
            });
        });
    </script>
@endsection
