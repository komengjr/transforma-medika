@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <style>
        .card {
            border: none;
            /* border-radius: 10px; */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s;
        }

        .cardreader:hover {
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
    <div class="row mb-3">
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
                        <h4 class="text-white fw-bold mb-0">Slip <span class="text-white fw-medium">Gaji Pegawai</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-3 ">
        <div class="col-md-3">
            <div class="card summary-card p-3 cardreader">
                <h6>Nama Pegawai</h6>
                <h4>{{ Auth::user()->fullname }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card summary-card p-3 cardreader">
                <h6>Total Gaji Bulan Ini</h6>
                <h4 class="text-success">Rp 285.000.000</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card summary-card p-3 cardreader">
                <h6>Periode Gaji</h6>
                <h4>Oktober 2025</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card summary-card p-3 cardreader">
                <h6>Status Pembayaran</h6>
                <h4 class="text-primary">Selesai</h4>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card p-4 mb-3 ">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Divisi</label>
                <select class="form-select">
                    <option>Semua Divisi</option>
                    <option>Finance</option>
                    <option>HRD</option>
                    <option>Marketing</option>
                    <option>Produksi</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Periode</label>
                <input type="month" class="form-control" value="2025-10">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100"><i class="bi bi-search"></i> Tampilkan</button>
            </div>
        </div>
    </div>

    <!-- Tabel Data Gaji -->
    <div class="card p-4">
        <h5 class="fw-bold mb-3">Daftar Gaji Karyawan</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Jabatan</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan</th>
                        <th>Lembur</th>
                        <th>Potongan</th>
                        <th>Total Diterima</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Agus Raharjo</td>
                        <td>HR Manager</td>
                        <td>Rp 12.000.000</td>
                        <td>Rp 2.000.000</td>
                        <td>Rp 500.000</td>
                        <td>Rp 300.000</td>
                        <td><b>Rp 14.200.000</b></td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm btn-action"><i class="bi bi-eye"></i>
                                Lihat</button>
                            <button class="btn btn-outline-success btn-sm btn-action"><i
                                    class="bi bi-download"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Rina Marlina</td>
                        <td>Staf Finance</td>
                        <td>Rp 7.000.000</td>
                        <td>Rp 1.000.000</td>
                        <td>Rp 300.000</td>
                        <td>Rp 100.000</td>
                        <td><b>Rp 8.200.000</b></td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm btn-action"><i class="bi bi-eye"></i>
                                Lihat</button>
                            <button class="btn btn-outline-success btn-sm btn-action"><i
                                    class="bi bi-download"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Dewi Putri</td>
                        <td>Marketing</td>
                        <td>Rp 6.500.000</td>
                        <td>Rp 800.000</td>
                        <td>Rp 200.000</td>
                        <td>Rp 150.000</td>
                        <td><b>Rp 7.350.000</b></td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm btn-action"><i class="bi bi-eye"></i>
                                Lihat</button>
                            <button class="btn btn-outline-success btn-sm btn-action"><i
                                    class="bi bi-download"></i></button>
                        </td>
                    </tr>
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

@endsection
