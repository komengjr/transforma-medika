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
                        <h4 class="text-white fw-bold mb-0">Data <span class="text-white fw-medium">BPJS dan Pajak</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card p-4 mb-3 ">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Cari nama karyawan...">
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option value="">Filter Jenis BPJS</option>
                    <option>BPJS Kesehatan</option>
                    <option>BPJS Ketenagakerjaan</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option value="">Periode</option>
                    <option>Januari 2025</option>
                    <option>Februari 2025</option>
                    <option>Maret 2025</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100"><i class="bi bi-search"></i> Tampilkan</button>
            </div>
        </div>
    </div>
    <div class="card py-4">
        <div class="table-responsive">
            <table id="example" class="table table-bordered table-striped" style="width:100%">
                <thead class="bg-800 text-200 fs--2">
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>NIK</th>
                        <th>Jenis BPJS</th>
                        <th>Nomor BPJS</th>
                        <th>Iuran Karyawan</th>
                        <th>Iuran Perusahaan</th>
                        <th>NPWP</th>
                        <th>Pajak (PPH 21)</th>
                        <th>Total Potongan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Andi Setiawan</td>
                        <td>EMP001</td>
                        <td>BPJS Kesehatan</td>
                        <td>000123456789</td>
                        <td>Rp. 100.000</td>
                        <td>Rp. 200.000</td>
                        <td>09.123.456.7-801.000</td>
                        <td>Rp. 350.000</td>
                        <td><span class="fw-bold text-danger">Rp. 650.000</span></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Budi Hartono</td>
                        <td>EMP002</td>
                        <td>BPJS Ketenagakerjaan</td>
                        <td>000987654321</td>
                        <td>Rp. 120.000</td>
                        <td>Rp. 250.000</td>
                        <td>09.234.567.8-801.000</td>
                        <td>Rp. 400.000</td>
                        <td><span class="fw-bold text-danger">Rp. 770.000</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary Section -->
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card text-center p-3">
                <h6>Total Iuran BPJS Bulan Ini</h6>
                <h4 class="fw-bold text-primary">Rp. 1.370.000</h4>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center p-3">
                <h6>Total Pajak (PPH 21)</h6>
                <h4 class="fw-bold text-danger">Rp. 750.000</h4>
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
