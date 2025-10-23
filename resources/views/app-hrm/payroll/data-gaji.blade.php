@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <style>
        .summary-card {
            text-align: center;
            padding: 1.5rem;
            border-radius: 16px;
            background: linear-gradient(135deg, #0d6efd, #4c9aff);
            /* color: white; */
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
        }

        .summary-card h3 {
            font-weight: 700;
            margin-bottom: 0;
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
                        <h4 class="text-white fw-bold mb-0">Data <span class="text-white fw-medium">Gaji Pegawai</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Gaji Bulan Ini -->
    <div class="summary-card mb-3">
        <h5>Gaji Bersih Bulan Ini (Oktober 2025)</h5>
        <h3 class="text-white">Rp 8.450.000</h3>
    </div>

    <!-- Detail Komponen Gaji -->
    <div class="card p-4 mb-3">
        <h5 class="fw-bold mb-3"><i class="bi bi-list-check text-primary"></i> Rincian Gaji</h5>
        <div class="table-responsive">
            <table class="table align-middle table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>Komponen</th>
                        <th>Keterangan</th>
                        <th>Nominal (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Gaji Pokok</td>
                        <td>Gaji dasar karyawan tetap</td>
                        <td class="text-end fw-bold">6.000.000</td>
                    </tr>
                    <tr>
                        <td>Tunjangan Transport</td>
                        <td>Diberikan setiap bulan</td>
                        <td class="text-end fw-bold">500.000</td>
                    </tr>
                    <tr>
                        <td>Tunjangan Makan</td>
                        <td>Subsidi makan harian</td>
                        <td class="text-end fw-bold">750.000</td>
                    </tr>
                    <tr>
                        <td>Bonus Kinerja</td>
                        <td>Bonus bulan Oktober</td>
                        <td class="text-end fw-bold text-success">1.500.000</td>
                    </tr>
                    <tr>
                        <td>Potongan BPJS</td>
                        <td>Potongan iuran karyawan</td>
                        <td class="text-end text-danger fw-bold">-150.000</td>
                    </tr>
                    <tr>
                        <td>Potongan Pajak</td>
                        <td>PPh 21</td>
                        <td class="text-end text-danger fw-bold">-150.000</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td colspan="2" class="text-center">Total Gaji Bersih</td>
                        <td class="text-end">Rp 8.450.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Riwayat Gaji -->
    <div class="card p-4">
        <h5 class="fw-bold mb-3"><i class="bi bi-clock-history text-primary"></i> Riwayat Gaji Saya</h5>
        <div class="table-responsive">
            <table class="table align-middle table-bordered text-center">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Gaji Bersih (Rp)</th>
                        <th>Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>September</td>
                        <td>2025</td>
                        <td class="fw-bold text-success">8.300.000</td>
                        <td><span class="badge bg-success">Dibayar</span></td>
                    </tr>
                    <tr>
                        <td>Agustus</td>
                        <td>2025</td>
                        <td class="fw-bold text-success">8.250.000</td>
                        <td><span class="badge bg-success">Dibayar</span></td>
                    </tr>
                    <tr>
                        <td>Juli</td>
                        <td>2025</td>
                        <td class="fw-bold text-success">8.250.000</td>
                        <td><span class="badge bg-success">Dibayar</span></td>
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
