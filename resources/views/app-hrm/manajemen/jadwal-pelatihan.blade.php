@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">

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
                        <h4 class="text-white fw-bold mb-0">Jadwal <span class="text-white fw-medium">Pelatihan</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card p-4 mb-3 ">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Cari nama pelatihan...">
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option value="">Pilih Departemen</option>
                    <option>SDM</option>
                    <option>Finance</option>
                    <option>Marketing</option>
                    <option>IT</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="month" class="form-control">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card py-3">
        <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped">
                <thead class="bg-800 text-200 fs--2">
                    <tr>
                        <th>No</th>
                        <th>Nama Pelatihan</th>
                        <th>Departemen</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Instruktur</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                    <tr>
                        <td>1</td>
                        <td>Leadership Development</td>
                        <td>SDM</td>
                        <td>05 Nov 2025</td>
                        <td>07 Nov 2025</td>
                        <td>Drs. Hendra Pratama</td>
                        <td>Ruang Meeting Lt. 3</td>
                        <td><span class="badge bg-warning badge-status">Sedang Berlangsung</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                            <!-- <button class="btn btn-sm btn-outline-success"><i class="fab fa-person-plus"></i></button> -->
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Pelatihan Sistem ERP</td>
                        <td>IT</td>
                        <td>15 Nov 2025</td>
                        <td>17 Nov 2025</td>
                        <td>Ir. Agus Raharjo</td>
                        <td>Lab Komputer</td>
                        <td><span class="badge bg-success badge-status">Dijadwalkan</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Customer Service Excellence</td>
                        <td>Marketing</td>
                        <td>20 Okt 2025</td>
                        <td>22 Okt 2025</td>
                        <td>Rina Sari, S.Psi</td>
                        <td>Hotel Horizon</td>
                        <td><span class="badge bg-secondary badge-status">Selesai</span></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mt-1 g-3">
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h6>Total Pelatihan Bulan Ini</h6>
                <h4 class="fw-bold text-primary">12 Program</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h6>Peserta Terdaftar</h6>
                <h4 class="fw-bold text-success">86 Orang</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h6>Pelatihan Selesai</h6>
                <h4 class="fw-bold text-secondary">7 Program</h4>
            </div>
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

@endsection
