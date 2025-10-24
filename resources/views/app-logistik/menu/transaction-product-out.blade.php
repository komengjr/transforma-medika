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
                            <h6 class="text-white fs--1 mb-0 pt-2" style="color: white !important;">Welcome to </h6>
                            <h4 class="text-white fw-bold mb-1" style="color: white !important;">Trans <span
                                    class="text-white fw-medium" style="color: white !important;">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-white fs--1 mb-0" style="color: white !important;">Menu : </h6>
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Transaction <span
                                class="text-white fw-medium" style="color: white !important;">Product Out</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card p-4 mb-3">
        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-clipboard2-data"></i> Informasi Divisi / User</h5>
        <form class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Tanggal Form Barang Keluar</label>
                <input type="date" class="form-control" value="2025-10-23">
            </div>
            <div class="col-md-3">
                <label class="form-label">Penerima Barang</label>
                <input type="text" class="form-control" value="Agus Raharjo">
            </div>
            <div class="col-md-6">
                <label class="form-label">Catatan</label>
                <input type="text" class="form-control" placeholder="Keterangan tambahan...">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary w-100" id="tambahBarang"><i class="bi bi-plus-circle"></i>
                    Tambah</button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header bg-300">
            <button class="btn btn-success btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalTambah">
                📦 Tambah Barang Keluar
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabelBarangKeluar" class="table table-striped table-bordered align-middle border">
                    <thead class="table-primary fs--2">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Keluar</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Penerima</th>
                            <th>User/Petugas</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="fs--2">
                        <tr>
                            <td>1</td>
                            <td>2025-10-24</td>
                            <td>BRG001</td>
                            <td>Masker Medis</td>
                            <td>50 Box</td>
                            <td>Ruang Farmasi</td>
                            <td>Admin Gudang</td>
                            <td>Untuk kebutuhan harian</td>
                            <td>
                                <button class="btn btn-sm btn-warning me-1">Edit</button>
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('base.js')
    <div class="modal fade" id="modal-pr" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-pr"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalTambah" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
                        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Barang Keluar</h4>
                        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold"
                                href="#!">{{ Env('APP_LABEL')}}</a>
                        </p>
                    </div>
                    <form id="formBarangKeluar" class="row p-3">
                        <!-- Alert error -->
                        <div id="alertError" class="alert alert-danger d-none"></div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Keluar</label>
                            <input type="date" class="form-control" name="tanggal" required>
                        </div>
                        <div class="col-md-6  mb-3">
                            <label class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" name="kode" placeholder="Contoh: BRG001" required
                                minlength="3">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" name="nama" required minlength="3">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" class="form-control" name="jumlah" min="1" required>
                        </div>
                        <div class="col-md-6  mb-3">
                            <label class="form-label">Penerima</label>
                            <input type="text" class="form-control" name="penerima" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">User/Petugas</label>
                            <input type="text" class="form-control" name="user" placeholder="Nama Petugas" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="2"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
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
        $(document).ready(function () {
            const table = $('#tabelBarangKeluar').DataTable();

            $('#formBarangKeluar').on('submit', function (e) {
                e.preventDefault();
                $('#alertError').addClass('d-none').text('');

                const form = $(this)[0];
                const data = $(this).serializeArray();

                // Ambil nilai form
                const tanggal = data[0].value.trim();
                const kode = data[1].value.trim();
                const nama = data[2].value.trim();
                const jumlah = parseInt(data[3].value.trim());
                const penerima = data[4].value.trim();
                const user = data[5].value.trim();
                const keterangan = data[6].value.trim();

                // Validasi sederhana
                if (!tanggal || !kode || !nama || !jumlah || !penerima || !user) {
                    showError('Semua kolom wajib diisi.');
                    return;
                }
                if (kode.length < 3) {
                    showError('Kode barang minimal 3 karakter.');
                    return;
                }
                if (nama.length < 3) {
                    showError('Nama barang minimal 3 karakter.');
                    return;
                }
                if (jumlah <= 0) {
                    showError('Jumlah barang harus lebih dari 0.');
                    return;
                }

                // Tambah data ke tabel
                const newRow = [
                    table.rows().count() + 1,
                    tanggal,
                    kode,
                    nama,
                    jumlah,
                    penerima,
                    user,
                    keterangan,
                    `<button class="btn btn-sm btn-warning me-1">Edit</button>
                                                     <button class="btn btn-sm btn-danger">Hapus</button>`
                ];
                table.row.add(newRow).draw(false);

                // Reset form
                form.reset();
                $('#modalTambah').modal('hide');
            });

            function showError(message) {
                $('#alertError').removeClass('d-none').text(message);
            }
        });
    </script>
@endsection
