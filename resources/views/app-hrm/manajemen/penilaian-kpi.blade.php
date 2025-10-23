@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <style>
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .progress {
            height: 10px;
            border-radius: 10px;
        }

        .kpi-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .badge-status {
            font-size: 0.85rem;
        }
    </style>
@endsection
@section('content')
    <div class="row mb-3 ">
        <div class="col">
            <div class="card bg-200 shadow border border-primary bg-primary">
                <div class="row gx-0 flex-between-center" style="color: white !important;">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/app.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-white fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-white fw-bold mb-1">{{env('APP_NAME')}} <span
                                    class="text-white fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-white fs--1 mb-0">Menu : </h6>
                        <h4 class="text-white fw-bold mb-0">Penilaian <span class="text-white fw-medium">Kinerja</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-muted mb-1">Total KPI</h6>
                <h4>8 Target</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-muted mb-1">Rata-rata Pencapaian</h6>
                <h4 class="text-success">84%</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-muted mb-1">Periode Penilaian</h6>
                <h4>Januari - Juni 2025</h4>
            </div>
        </div>
    </div>

    <!-- Tabel KPI -->
    <div class="card p-4">
        <div class="kpi-header mb-3">
            <h5 class="fw-bold">Daftar KPI Individu</h5>
            <select class="form-select w-auto">
                <option>Semua Divisi</option>
                <option>Produksi</option>
                <option>Marketing</option>
                <option>Finance</option>
            </select>
        </div>

        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama KPI</th>
                    <th>Bobot</th>
                    <th>Target</th>
                    <th>Realisasi</th>
                    <th>Pencapaian</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Peningkatan Produktivitas</td>
                    <td>25%</td>
                    <td>95%</td>
                    <td>90%</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: 90%"></div>
                        </div>
                    </td>
                    <td><span class="badge bg-success badge-status">Tercapai</span></td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>Kedisiplinan Kehadiran</td>
                    <td>15%</td>
                    <td>100%</td>
                    <td>92%</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar bg-primary" style="width: 92%"></div>
                        </div>
                    </td>
                    <td><span class="badge bg-success badge-status">Tercapai</span></td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>Kepuasan Pelanggan Internal</td>
                    <td>20%</td>
                    <td>85%</td>
                    <td>78%</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width: 78%"></div>
                        </div>
                    </td>
                    <td><span class="badge bg-warning text-dark badge-status">Perlu Perbaikan</span></td>
                </tr>

                <tr>
                    <td>4</td>
                    <td>Ketepatan Pelaporan</td>
                    <td>10%</td>
                    <td>100%</td>
                    <td>70%</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar bg-danger" style="width: 70%"></div>
                        </div>
                    </td>
                    <td><span class="badge bg-danger badge-status">Belum Tercapai</span></td>
                </tr>

            </tbody>
        </table>
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
