@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <style>
        .table th {
            background-color: #f0f2f7;
        }

        .btn-modern {
            background: linear-gradient(135deg, #007bff, #00c4ff);
            border: none;
            color: white;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-modern:hover {
            background: linear-gradient(135deg, #0062cc, #00a6d6);
            transform: scale(1.05);
        }

        .search-bar input {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding-left: 35px;
        }

        .search-bar i {
            position: absolute;
            left: 12px;
            top: 10px;
            color: #888;
        }

        .fade-out {
            animation: fadeOut 0.4s ease forwards;
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: scale(1);
            }

            to {
                opacity: 0;
                transform: scale(0.8);
            }
        }

        .modal-content {
            border-radius: 20px;
            animation: zoomIn 0.4s ease;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="card bg-200 shadow border border-warning">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3" src="{{ asset('img/poli.png') }}" alt="" width="80" />
                        <div>
                            <h6 class="text-warning fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-warning fw-bold mb-1">{{ Env('APP_LABEL')}} <span
                                    class="text-warning fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-warning fs--1 mb-0">Menu : </h6>
                        <h4 class="text-warning fw-bold mb-0">Manajemen <span class="text-warning fw-medium">Data
                                Obat</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
            <h4 class="fw-semibold mb-2">💊 Master Data Obat</h4>
            <button class="btn btn-modern" data-bs-toggle="modal" data-bs-target="#modal-obat" id="button-add-obat">+ Tambah
                Obat</button>
        </div>


        <!-- <div class="row mb-3 search-bar">
                    <div class="col-md-6 mb-2">
                        <input type="text" id="searchKode" class="form-control" placeholder="Cari berdasarkan Kode Obat">
                    </div>
                    <div class="col-md-6 mb-2">
                        <input type="text" id="searchNama" class="form-control" placeholder="Cari berdasarkan Nama Obat">
                    </div>
                </div> -->

        <div class="table-responsive" id="data-table-obat">
            <table id="example" class="table table-striped border" style="width:100%">
                <thead class="bg-warning text-100">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Obat</th>
                        <th>Satuan</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Batch & Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataBody"></tbody>
            </table>
        </div>

        <nav>
            <ul class="pagination justify-content-center mt-3" id="pagination"></ul>
        </nav>

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
    <div class="modal fade" id="modal-obat" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-obat"></div>
            </div>
        </div>
    </div>
    <!-- Modal Tambah Obat -->
    <div class="modal fade" id="modalObat" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Obat Baru</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formObat">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Kode Obat</label>
                                <input type="text" id="kodeObat" class="form-control" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Nama Obat</label>
                                <input type="text" id="namaObat" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Satuan</label>
                                <input type="text" id="satuan" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kategori</label>
                                <input type="text" id="kategori" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jenis</label>
                                <input type="text" id="pabrikan" class="form-control">
                            </div>
                        </div>
                        <hr>
                        <h6 class="text-primary">Batch & Harga</h6>
                        <div id="batchContainer"></div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addBatch">+ Tambah
                            Batch</button>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-modern">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Update Batch -->
    <div class="modal fade" id="modalBatch" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">Update Batch & Harga</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formUpdateBatch">
                    <div class="modal-body">
                        <div id="batchUpdateContainer"></div>
                        <button type="button" class="btn btn-outline-warning btn-sm mt-2" id="addBatchUpdate">+ Tambah
                            Batch</button>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-modern">Simpan Perubahan</button>
                    </div>
                </form>
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
    <script>
        $(document).on("click", "#button-add-obat", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-obat').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('manajemen_farmasi_data_obat_add') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": 123
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-obat').html(data);
            }).fail(function () {
                $('#menu-obat').html('eror');
            });
        });
        $(document).on("click", "#button-simpan-data-obat", function (e) {
            e.preventDefault();
            var data = $("#form-input-obat").serialize();
            $('#menu-add-data-obat').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('manajemen_farmasi_data_obat_save') }}",
                type: "POST",
                cache: false,
                data: data,
                dataType: 'html',
            }).done(function (data) {
                $('#modal-obat').modal('hide');
                $('#data-table-obat').html(data);
            }).fail(function () {
                $('#data-table-obat').html('eror');
            });
        });
    </script>
    <!-- <script>
            let dataObat = JSON.parse(localStorage.getItem("dataObat")) || [];
            const perPage = 5;
            let currentPage = 1;
            let currentEditIndex = null;

            function tampilkanData() {
                const tbody = document.getElementById("dataBody");
                const searchKode = document.getElementById("searchKode").value.toLowerCase();
                const searchNama = document.getElementById("searchNama").value.toLowerCase();
                tbody.innerHTML = '';

                const filtered = dataObat.filter(o =>
                    o.kode.toLowerCase().includes(searchKode) &&
                    o.nama.toLowerCase().includes(searchNama)
                );

                const start = (currentPage - 1) * perPage;
                const pageData = filtered.slice(start, start + perPage);

                pageData.forEach((o, i) => {
                    const batchList = o.batch.map(b => `
                                          <div><strong>${b.noBatch}</strong> | Exp: ${b.expDate} | <span class="text-success">Beli:</span> Rp${b.hargaBeli.toLocaleString()} | <span class="text-danger">Jual:</span> Rp${b.hargaJual.toLocaleString()}</div>
                                        `).join('');
                    const row = `
                                          <tr>
                                            <td data-label="Kode">${o.kode}</td>
                                            <td data-label="Nama">${o.nama}</td>
                                            <td data-label="Satuan">${o.satuan}</td>
                                            <td data-label="Kategori">${o.kategori}</td>
                                            <td data-label="Pabrikan">${o.pabrikan}</td>
                                            <td data-label="Batch">${batchList}</td>
                                            <td data-label="Aksi">
                                              <button class="btn btn-sm btn-outline-warning" onclick="editBatch(${dataObat.indexOf(o)})">✏️</button>
                                              <button class="btn btn-sm btn-outline-danger" onclick="hapusObat(${dataObat.indexOf(o)})">🗑️</button>
                                            </td>
                                          </tr>
                                        `;
                    tbody.innerHTML += row;
                });

                buatPagination(filtered.length);
            }

            function buatPagination(total) {
                const totalPages = Math.ceil(total / perPage);
                const pagination = document.getElementById("pagination");
                pagination.innerHTML = '';
                for (let i = 1; i <= totalPages; i++) {
                    pagination.innerHTML += `
                                          <li class="page-item ${i === currentPage ? 'active' : ''}">
                                            <a class="page-link" href="#" onclick="gantiHalaman(${i})">${i}</a>
                                          </li>`;
                }
            }

            function gantiHalaman(page) {
                currentPage = page;
                tampilkanData();
            }

            document.getElementById('formObat').addEventListener('submit', e => {
                e.preventDefault();
                const kode = document.getElementById('kodeObat').value.trim();
                const nama = document.getElementById('namaObat').value.trim();
                const satuanVal = document.getElementById('satuan').value.trim();
                const kategoriVal = document.getElementById('kategori').value.trim();
                const pabrikanVal = document.getElementById('pabrikan').value.trim();

                const batchData = Array.from(document.querySelectorAll('#batchContainer > div')).map(b => ({
                    noBatch: b.querySelector('.batchNo').value.trim(),
                    expDate: b.querySelector('.batchExp').value,
                    hargaBeli: Number(b.querySelector('.batchBeli').value) || 0,
                    hargaJual: Number(b.querySelector('.batchJual').value) || 0
                }));

                dataObat.push({ kode, nama, satuan: satuanVal, kategori: kategoriVal, pabrikan: pabrikanVal, batch: batchData });
                localStorage.setItem("dataObat", JSON.stringify(dataObat));
                tampilkanData();
                e.target.reset();
                document.getElementById('batchContainer').innerHTML = '';
                bootstrap.Modal.getInstance(document.getElementById('modalObat')).hide();
            });

            document.getElementById('addBatch').addEventListener('click', () => {
                const div = document.createElement('div');
                div.className = 'row g-2 mt-2';
                div.innerHTML = `
                                        <div class="col-md-3"><input type="text" class="form-control form-control-sm batchNo" placeholder="No Batch" required></div>
                                        <div class="col-md-3"><input type="date" class="form-control form-control-sm batchExp" required></div>
                                        <div class="col-md-3"><input type="number" class="form-control form-control-sm batchBeli" placeholder="Harga Beli" required></div>
                                        <div class="col-md-3"><input type="number" class="form-control form-control-sm batchJual" placeholder="Harga Jual" required></div>
                                      `;
                document.getElementById('batchContainer').appendChild(div);
            });

            function editBatch(index) {
                currentEditIndex = index;
                const obat = dataObat[index];
                const container = document.getElementById('batchUpdateContainer');
                container.innerHTML = '';
                obat.batch.forEach(b => {
                    const div = document.createElement('div');
                    div.className = 'row g-2 mt-2';
                    div.innerHTML = `
                                          <div class="col-md-3"><input type="text" class="form-control form-control-sm batchNo" value="${b.noBatch}" required></div>
                                          <div class="col-md-3"><input type="date" class="form-control form-control-sm batchExp" value="${b.expDate}" required></div>
                                          <div class="col-md-3"><input type="number" class="form-control form-control-sm batchBeli" value="${b.hargaBeli}" required></div>
                                          <div class="col-md-3"><input type="number" class="form-control form-control-sm batchJual" value="${b.hargaJual}" required></div>
                                        `;
                    container.appendChild(div);
                });
                new bootstrap.Modal(document.getElementById('modalBatch')).show();
            }

            document.getElementById('formUpdateBatch').addEventListener('submit', e => {
                e.preventDefault();
                const batchData = Array.from(document.querySelectorAll('#batchUpdateContainer > div')).map(b => ({
                    noBatch: b.querySelector('.batchNo').value.trim(),
                    expDate: b.querySelector('.batchExp').value,
                    hargaBeli: Number(b.querySelector('.batchBeli').value) || 0,
                    hargaJual: Number(b.querySelector('.batchJual').value) || 0
                }));
                dataObat[currentEditIndex].batch = batchData;
                localStorage.setItem("dataObat", JSON.stringify(dataObat));
                tampilkanData();
                bootstrap.Modal.getInstance(document.getElementById('modalBatch')).hide();
            });

            function hapusObat(index) {
                if (confirm("Yakin ingin menghapus obat ini?")) {
                    dataObat.splice(index, 1);
                    localStorage.setItem("dataObat", JSON.stringify(dataObat));
                    tampilkanData();
                }
            }

            document.getElementById('searchKode').addEventListener('input', tampilkanData);
            document.getElementById('searchNama').addEventListener('input', tampilkanData);

            tampilkanData();
        </script> -->
@endsection
