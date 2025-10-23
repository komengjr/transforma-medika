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



    <!-- Data Table -->
    <div class="card">
        <div class="card-header bg-warning">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fw-bold mb-0"><i class="bi bi-clock-history text-primary"></i></h3>
                <button class="btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#modal-lembur-xl">
                    <i class="bi bi-plus-circle"></i> Ajukan Lembur
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-bordered text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Total Jam</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>10 Okt 2025</td>
                            <td>18:00</td>
                            <td>21:00</td>
                            <td><span class="fw-bold text-primary">3 Jam</span></td>
                            <td>Menyelesaikan laporan bulanan</td>
                            <td><span class="badge bg-success badge-status">Disetujui</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>17 Okt 2025</td>
                            <td>17:30</td>
                            <td>20:00</td>
                            <td><span class="fw-bold text-primary">2,5 Jam</span></td>
                            <td>Perbaikan server internal</td>
                            <td><span class="badge bg-warning text-dark badge-status">Menunggu</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>05 Okt 2025</td>
                            <td>19:00</td>
                            <td>22:00</td>
                            <td><span class="fw-bold text-primary">3 Jam</span></td>
                            <td>Persiapan meeting proyek</td>
                            <td><span class="badge bg-secondary badge-status">Ditolak</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Summary -->
    <div class="row mt-2 g-3">
        <div class="col-md-6">
            <div class="card text-center p-3">
                <h6>Total Lembur Bulan Ini</h6>
                <h4 class="fw-bold text-primary">8,5 Jam</h4>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center p-3">
                <h6>Total Pengajuan</h6>
                <h4 class="fw-bold text-success">3 Kali</h4>
            </div>
        </div>
    </div>

@endsection
@section('base.js')
    <div class="modal fade" id="modal-lembur-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-pegawai-xl">
                    <div class="modal-body p-0">
                        <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
                            <h4 class="mb-1" id="staticBackdropLabel" style="color: white !important;">Form Penambahan
                                Barang Inventaris</h4>
                            <p class="fs--2 mb-0" style="color: white !important;">Support by <a
                                    class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
                        </div>
                        <form class="p-4">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lembur</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jam Mulai</label>
                                    <input type="time" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jam Selesai</label>
                                    <input type="time" class="form-control">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control" rows="2" placeholder="Tuliskan alasan lembur..."></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Tambah Lembur -->
    <div class="modal fade" id="tambahLemburModal" tabindex="-1" aria-labelledby="tambahLemburModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="tambahLemburModalLabel"><i class="bi bi-plus-circle"></i> Ajukan Lembur</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lembur</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jam Mulai</label>
                                <input type="time" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jam Selesai</label>
                                <input type="time" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" rows="2" placeholder="Tuliskan alasan lembur..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Kirim Pengajuan</button>
                </div>
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
