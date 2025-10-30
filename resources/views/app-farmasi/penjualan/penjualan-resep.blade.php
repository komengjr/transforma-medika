@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <style>
        .table thead {
            background-color: #0d6efd;
            color: white;
        }

        .summary-card {
            border-radius: 16px;
            background: linear-gradient(135deg, #0d6efd, #4c9aff);
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
            border-radius: 10px !important;
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
                        <h4 class="text-primary fw-bold mb-0">Penjualan <span class="text-primary fw-medium">Dengan
                                Resep</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-4 mb-3">
        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-person-lines-fill"></i> Data Resep</h5>
        <form id="formResep" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Nomor Resep</label>
                <input type="text" class="form-control" id="noResep" placeholder="Contoh: RX-2025-001">
            </div>
            <div class="col-md-3">
                <label class="form-label">Nama Pasien</label>
                <input type="text" class="form-control" id="namaPasien" placeholder="Nama pasien">
            </div>
            <div class="col-md-6">
                <label class="form-label">Dokter</label>
                <select name="namaDokter" class="form-select choices-single-doctor" id="namaDokter">
                    <option value="">Pilih Dokter</option>
                    @foreach ($doctor as $doc)
                        <option value="{{ $doc->master_doctor_code }}">{{ $doc->master_doctor_name }}</option>
                    @endforeach
                </select>

            </div>
            <div class="col-md-4">
                <label class="form-label">Tanggal Resep</label>
                <input type="date" class="form-control" id="tglResep">
            </div>
            <div class="col-md-8">
                <label class="form-label">Keterangan</label>
                <input type="text" class="form-control" id="keteranganResep" placeholder="Contoh: Resep dari Klinik Medika">
            </div>
        </form>
    </div>

    <!-- Form Tambah Obat -->
    <div class="card p-4 mb-3">
        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-capsule"></i> Tambah Obat Dari Resep</h5>
        <form id="formObat" class="row g-3 align-items-end">
            @csrf
            <input type="text" name="no_reg" id="no_reg" value="{{ date('Ymdhis') }}" hidden>
            <div class="col-md-4">
                <label class="form-label">Nama Obat</label>
                <select name="namaObat" class="form-select form-select-lg choices-single-company" id="namaObat">
                    <option value="">Ketik nama obat...</option>
                    @foreach ($data as $datas)
                        <option value="{{ $datas->farm_data_obat_code }}">{{ $datas->farm_data_obat_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Harga</label>
                <input type="number" class="form-control" id="hargaObat" name="hargaObat" placeholder="0" hidden>
                <input type="text" class="form-control" id="hargaObatx" placeholder="0" readonly>
            </div>
            <div class="col-md-2">
                <label class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="jumlahObat" value="1" min="1" name="jumlahObat">
            </div>
            <div class="col-md-2">
                <label class="form-label">Subtotal</label>
                <input type="text" class="form-control" id="subtotalObat" readonly>
            </div>
            <div class="col-md-2 text-center">
                <button type="button" class="btn btn-primary w-100" id="tambahBtn"><i class="bi bi-plus-circle"></i>
                    Tambah</button>
            </div>
        </form>
    </div>

    <div class="row g-3">
        <div class="col-md-8">
            <!-- Tabel Penjualan -->
            <div class="card p-4 mb-3">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-cart4"></i> Daftar Obat Resep</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center" id="tabelPenjualan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Obat</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-list-harga">
                            <!-- item akan ditambahkan via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Total -->
            <div class="summary-card">
                <h5>Total Pembayaran Resep</h5>
                <h2 id="totalHarga">Rp 0</h2>
                <button class="btn btn-light btn-lg mt-3" id="button-show-data-list-obat"><i class="bi bi-check-circle"></i>
                    Simpan Penjualan</button>
                <button data-bs-toggle="modal" data-bs-target="#modal-penjualan" id="klik-button-penjualan"
                    style="display: none;">klik</button>
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
    <div class="modal fade" id="modal-penjualan" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-penjualan"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="{{ asset('asset/js/flatpickr.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    <script>
        new window.Choices(document.querySelector(".choices-single-company"));
        new window.Choices(document.querySelector(".choices-single-doctor"));
    </script>
    <script>
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }
        $('#namaObat').on("change", function () {
            var dataid = document.getElementById("namaObat").value;
            if (dataid == "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
            } else {
                $.ajax({
                    url: "{{ route('penjualan_non_resep_cari_data') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": dataid,
                    },
                    dataType: 'html',
                }).done(function (data) {
                    if (data == 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Setting Harga Terlebih dahulu",
                            footer: '<a href="#">Why do I have this issue?</a>'
                        });
                    } else {
                        const rupiah = formatRupiah(data);
                        document.getElementById('hargaObat').value = data;
                        // $('#hargaObatx').html(rupiah);
                        document.getElementById('hargaObatx').value = rupiah;
                        document.getElementById("subtotalObat").value = (data * 1).toLocaleString();
                    }
                }).fail(function () {
                    console.log('eror');
                });
            }
        });
        $(document).on("click", "#tambahBtn", function (e) {
            e.preventDefault();
            var data = $("#formObat").serialize();
            $.ajax({
                url: "{{ route('penjualan_non_resep_save_data') }}",
                type: "POST",
                cache: false,
                data: data,
                dataType: 'html',
            }).done(function (data) {
                if (data == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "APe Yang kau Pileh !",
                        footer: '<a href="#">Why do I have this issue?</a>'
                    });
                } else {
                    $('#table-list-harga').html(data);
                    document.getElementById("jumlahObat").value = "1";
                    document.getElementById("hargaObat").value = "";
                    document.getElementById("hargaObatx").value = "";
                    document.getElementById("namaObat").value = "";
                    document.getElementById("subtotalObat").value = "";
                }
            }).fail(function () {
                $('#table-list-harga').html('eror');
            });
        });
        $(document).on("click", "#button-remove-list-obat", function (e) {
            e.preventDefault();
            var code = $(this).data("code");
            const no_reg = document.getElementById('no_reg').value;
            $.ajax({
                url: "{{ route('penjualan_non_resep_remove_data') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                    "no_reg": no_reg,
                },
                dataType: 'html',
            }).done(function (data) {
                $('#table-list-harga').html(data);
            }).fail(function () {
                $('#table-list-harga').html('eror');
            });
        });
        $(document).on("click", "#button-show-data-list-obat", function (e) {
            e.preventDefault();
            const code = document.getElementById('no_reg').value;
            const noResep = document.getElementById('noResep').value;
            const namaPasien = document.getElementById('namaPasien').value;
            const namaDokter = document.getElementById('namaDokter').value;
            const tglResep = document.getElementById('tglResep').value;
            const keteranganResep = document.getElementById('keteranganResep').value;
            if (noResep == "" || namaPasien == "" || namaDokter == "" || tglResep == "") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Tidak Bisa Melanjutkan Order!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
            } else {
                $("#klik-button-penjualan").click();
                $('#menu-penjualan').html(
                    '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
                );
                $.ajax({
                    url: "{{ route('penjualan_resep_show_data_list') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": code,
                        "noResep": noResep,
                        "namaPasien": namaPasien,
                        "namaDokter": namaDokter,
                        "tglResep": tglResep,
                        "keteranganResep": keteranganResep,
                    },
                    dataType: 'html',
                }).done(function (data) {
                    $('#menu-penjualan').html(data);
                }).fail(function () {
                    $('#menu-penjualan').html('eror');
                });
            }
        });
        $(document).on("click", "#button--payment-penjualan-obat", function (e) {
            e.preventDefault();
            var code = $(this).data("code");

            $('#menu-data-list-obat').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('penjualan_resep_payment_data_list') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,

                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-data-list-obat').html(data);
            }).fail(function () {
                $('#menu-data-list-obat').html('eror');
            });
        });
        $(document).on("click", "#button-pilih-method", function (e) {
            e.preventDefault();
            var key = $(this).data("key");
            const code = document.getElementById('no_reg').value;
            const noResep = document.getElementById('noResep').value;
            const namaPasien = document.getElementById('namaPasien').value;
            const namaDokter = document.getElementById('namaDokter').value;
            const tglResep = document.getElementById('tglResep').value;
            const keteranganResep = document.getElementById('keteranganResep').value;
            $('#menu-payment-method').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('penjualan_resep_payment_pilih') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "key": key,
                    "code": code,
                    "noResep": noResep,
                    "namaPasien": namaPasien,
                    "namaDokter": namaDokter,
                    "tglResep": tglResep,
                    "keteranganResep": keteranganResep,
                },
                dataType: 'html',
            }).done(function (data) {
                $('#menu-payment-method').html(data);
            }).fail(function () {
                $('#menu-payment-method').html('eror');
            });
        });
        $(document).on("click", "#button-confirm-payment-obat", function (e) {
            e.preventDefault();
            const code = document.getElementById('no_reg').value;
            var data = $("#form-pembayaran-obat").serialize();
            $('#menu-button-confrim').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('penjualan_resep_payment_confrim') }}",
                type: "POST",
                cache: false,
                data: data,
                dataType: 'html',
            }).done(function (data) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "Pembayaran Berhasil"
                });
                $('#tombol-non-resep').html('<button class="btn btn-primary btn-sm" onclick="location.reload()">Selesai</button>');
                $('#menu-data-list-obat').html('<iframe src="data:application/pdf;base64, ' + data + '" style="width:100%; height:533px;" frameborder="0"></iframe>');
            }).fail(function () {
                $('#menu-button-confrim').html('eror');
            });
        });
    </script>
    <script>
        // Auto hitung subtotal
        document.getElementById("hargaObat").addEventListener("input", hitungSubtotal);
        document.getElementById("jumlahObat").addEventListener("input", hitungSubtotal);
        function hitungSubtotal() {
            const harga = parseFloat(document.getElementById("hargaObat").value) || 0;
            const jumlah = parseInt(document.getElementById("jumlahObat").value) || 1;
            document.getElementById("subtotalObat").value = (harga * jumlah).toLocaleString();
        }
    </script>
@endsection
