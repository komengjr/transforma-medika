@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <style>
        .table thead {
            background-color: #198754;
            color: white;
        }

        .btn-action {
            border-radius: 8px;
            padding: 6px 12px;
        }

        .summary-card {
            border-radius: 16px;
            background: linear-gradient(135deg, #198754, #20c997);
            color: white;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
        }

        .summary-card h2 {
            font-weight: 700;
            margin-bottom: 0;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="card bg-200 shadow border border-primary">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3" src="{{ asset('img/poli.png') }}" alt="" width="80" />
                        <div>
                            <h6 class="text-primary fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-primary fw-bold mb-1">{{ Env('APP_LABEL')}} <span
                                    class="text-primary fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-primary fs--1 mb-0">Menu : </h6>
                        <h4 class="text-primary fw-bold mb-0">Verifikasi <span class="text-primary fw-medium"> Dosis Resep</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0 text-primary"><i class="bi bi-clipboard2-check"></i> </h3>
        <button class="btn btn-success rounded-pill px-4"><i class="fas fa-search"></i> Cari Resep</button>
    </div>
    <!-- Informasi Resep -->
    <div class="card p-4 mb-3">
        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-file-medical"></i> Informasi Resep</h5>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Nomor Resep</label>
                <input type="text" class="form-control" value="RX-2025-001" readonly>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nama Pasien</label>
                <input type="text" class="form-control" value="Budi Santoso" readonly>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nama Dokter</label>
                <input type="text" class="form-control" value="dr. Anita Wijaya" readonly>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tanggal Resep</label>
                <input type="date" class="form-control" value="2025-10-23" readonly>
            </div>
            <div class="col-md-8">
                <label class="form-label">Catatan Resep</label>
                <input type="text" class="form-control" value="Pasien dengan tekanan darah tinggi" readonly>
            </div>
        </div>
    </div>

    <!-- Verifikasi Dosis -->
    <div class="card p-4 mb-3">
        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-capsule-pill"></i> Pemeriksaan Obat & Dosis</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center" id="tabelVerifikasi">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>Dosis yang Diberikan</th>
                        <th>Dosis Dianjurkan</th>
                        <th>Hasil Verifikasi</th>
                        <th>Catatan Apoteker</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Amlodipine 5mg</td>
                        <td><input type="text" class="form-control text-center" value="1x1"></td>
                        <td>1x1</td>
                        <td><span class="status status-success">Aman</span></td>
                        <td><input type="text" class="form-control" placeholder="Tidak ada catatan"></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Paracetamol 500mg</td>
                        <td><input type="text" class="form-control text-center" value="3x1"></td>
                        <td>3x1</td>
                        <td><span class="status status-success">Aman</span></td>
                        <td><input type="text" class="form-control" placeholder="Tidak ada catatan"></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Ibuprofen 400mg</td>
                        <td><input type="text" class="form-control text-center" value="3x1"></td>
                        <td>2x1</td>
                        <td><span class="status status-warning">Perlu Revisi</span></td>
                        <td><input type="text" class="form-control" placeholder="Dosis sedikit berlebih"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kesimpulan Verifikasi -->
    <div class="card p-4 mb-3">
        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-clipboard-heart"></i> Kesimpulan Verifikasi</h5>
        <div class="row g-3">
            <div class="col-md-8">
                <textarea class="form-control" rows="3" placeholder="Catatan tambahan apoteker..."></textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label">Status Verifikasi</label>
                <select class="form-select">
                    <option value="disetujui">Disetujui</option>
                    <option value="perlu-revisi">Perlu Revisi</option>
                    <option value="ditolak">Ditolak</option>
                </select>
                <button class="btn btn-primary w-100 mt-3"><i class="bi bi-shield-check"></i> Simpan Verifikasi</button>
            </div>
        </div>
    </div>

@endsection
@section('base.js')
    <div class="modal fade" id="modal-poliklinik-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-poliklinik-full"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-poliklinik" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-poliklinik"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="{{ asset('asset/js/flatpickr.js') }}"></script>
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>

@endsection
