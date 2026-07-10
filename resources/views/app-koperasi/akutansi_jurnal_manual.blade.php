@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

@endsection
@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow border border-success">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3" src="{{ asset('img/koperasi.png') }}" alt="" width="60" />
                    <div>
                        <h6 class="text-success fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-success fw-bold mb-1">{{ Env('APP_LABEL')}} <span
                                class="text-success fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-success fs--1 mb-0">Menu : </h6>
                    <h4 class="text-success fw-bold mb-0">Akutansi <span class="text-success fw-medium">Jurnal Otomatis</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3 bg-white p-4 rounded-3 shadow-sm border border-light-subtle">
    <div>
        <h1 class="h3 fw-bold text-primary mb-1">Sistem Keuangan Koperasi</h1>
        <p class="text-muted small mb-0">Otomatisasi Modul Koperasi ke Akuntansi (COA)</p>
    </div>
    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-semibold small">Sistem Aktif</span>
</div>

<div class="card mb-3 shadow-sm border border-light-subtle rounded-3 overflow-hidden">
    <div class="card-header bg-light py-3 border-bottom border-light-subtle">
        <h2 class="h5 fw-semibold text-dark mb-0">Daftar Pengajuan Peminjaman Uang</h2>
    </div>

    <div class="table-responsive py-3">
        <table id="peminjaman-table" class="table align-middle text-start table-bordered">
            <thead class="table-light text-uppercase text-white small tracking-wider bg-primary">
                <tr class="border-bottom">
                    <th class="p-3">Kode Transaksi</th>
                    <th class="p-3">Nama Anggota</th>
                    <th class="p-3">Nominal</th>
                    <th class="p-3">Bunga</th>
                    <th class="p-3">Admin</th>
                    <th class="p-3">Tenor</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="peminjaman-table-body" class="small">
                <tr>
                    <td colspan="7" class="p-4 text-center text-muted">Memuat data...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card mb-3 shadow-sm border border-light-subtle rounded-3 overflow-hidden">
    <div class="card-header bg-light py-3 border-bottom border-light-subtle">
        <h2 class="h5 fw-semibold text-dark mb-0">Daftar Pengajuan Peminjaman Barang</h2>
    </div>

    <div class="table-responsive py-3">
        <table id="barang-table" class="table align-middle text-start mb-0 table-bordered">
            <thead class="table-light text-uppercase text-white bg-primary small tracking-wider">
                <tr class="border-bottom">
                    <th class="p-3">Kode Transaksi</th>
                    <th class="p-3">Nama Anggota</th>
                    <th class="p-3">Nominal Barang</th>
                    <th class="p-3">Bunga</th>
                    <th class="p-3">Admin</th>
                    <th class="p-3">Tenor</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="barang-table-body" class="small">
                <tr>
                    <td colspan="7" class="p-4 text-center text-muted">Memuat data barang...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card mb-3 shadow-sm border border-light-subtle rounded-3 overflow-hidden">
    <div class="card-header bg-light py-3 border-bottom border-light-subtle">
        <h2 class="h5 fw-semibold text-dark mb-0">Daftar Klaim Voucher Anggota</h2>
    </div>

    <div class="table-responsive py-3">
        <table id="voucher-table" class="table align-middle text-start mb-0 table-bordered">
            <thead class="table-light text-uppercase text-white small tracking-wider bg-warning">
                <tr class="border-bottom">
                    <th class="p-3">Kode Voucher</th>
                    <th class="p-3">Token</th>
                    <th class="p-3">Nama Anggota</th>
                    <th class="p-3">Nominal Voucher</th>
                    <th class="p-3">Admin Voucher</th>
                    <th class="p-3">Masa Berlaku</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="voucher-table-body" class="small">
                <tr>
                    <td colspan="7" class="p-4 text-center text-muted">Memuat data voucher...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card mb-3 shadow-sm border border-light-subtle rounded-3 overflow-hidden">
    <div class="card-header bg-light py-3 border-bottom border-light-subtle">
        <h2 class="h5 fw-semibold text-dark mb-0">Daftar Grup & Pencairan Arisan</h2>
    </div>

    <div class="table-responsive py-3">
        <table id="arisan-table" class="table align-middle text-start mb-0 table-bordered">
            <thead class="table-dark bg-dark text-white text-secondary small tracking-wider">
                <tr class="border-bottom">
                    <th class="p-3">Kode Grup</th>
                    <th class="p-3">Nama Grup Arisan</th>
                    <th class="p-3">Nominal Arisan</th>
                    <th class="p-3">Potongan Jasa/Bunga</th>
                    <th class="p-3">Periode</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="arisan-table-body" class="small">
                <tr>
                    <td colspan="7" class="p-4 text-center text-muted">Memuat data arisan...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="card shadow-sm border border-light-subtle rounded-3 overflow-hidden mb-3">
    <div class="card-header bg-light py-3 border-bottom border-light-subtle">
        <h2 class="h5 fw-semibold text-dark mb-0">Daftar Tagihan Bulanan Anggota</h2>
    </div>

    <div class="table-responsive py-3">
        <table id="tagihan-table" class="table align-middle text-start mb-0">
            <thead class="table-light bg-info text-uppercase text-white small tracking-wider">
                <tr class="border-bottom">
                    <th class="p-3">Kode Tagihan</th>
                    <th class="p-3">Cabang Tagihan</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Angsuran Pokok</th>
                    <th class="p-3">Bunga / Jasa</th>
                    <th class="p-3">Total Anggota</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="tagihan-table-body" class="small">
                <tr>
                    <td colspan="7" class="p-4 text-center text-muted">Memuat data iuran bulanan...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('base.js')
<div class="modal fade" id="modal-penjualan-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
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
<!-- Script Peminjaman Uang -->
<script>
    // 1. Ambil Data dari Backend
    async function fetchPeminjamanData() {
        try {
            const response = await fetch(`{{ route('akutansi_koperasi_get_peminjaman') }}`);
            const data = await response.json();
            renderTable(data);
        } catch (error) {
            console.error("Gagal mengambil data:", error);
            document.getElementById('peminjaman-table-body').innerHTML = `
                    <tr><td colspan="7" class="p-4 text-center text-red-500 font-medium">Gagal memuat data dari server backend.</td></tr>
                `;
        }
    }

    // 2. Tampilkan Data ke Tabel HTML
    function renderTable(items) {
        const tableId = '#peminjaman-table';
        const tbody = document.getElementById('peminjaman-table-body');

        // 1. Hancurkan DataTable jika sudah pernah diinisialisasi sebelumnya
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().destroy();
        }

        // 2. Kosongkan isi tbody
        tbody.innerHTML = '';

        // Jika data kosong, DataTables akan otomatis menampilkan pesan "No data available in table"
        if (items.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted p-4">Tidak ada pengajuan pinjaman uang.</td></tr>`;
            return;
        }

        // 3. Render baris data tabel
        let tableRows = '';
        items.forEach(item => {
            // Logika warna status Bootstrap 5

            let status = 'Belum di Terbit kan';
            let statusColor = 'bg-warning-subtle text-warning border border-warning';
            let buttonAction = `<button onclick="prosesCairkan(${item.id_kop_proses_uang})" class="btn btn-dark btn-sm fw-semibold shadow-sm">Terbit Jurnal</button>`;
            if (item.kop_proses_uang_status == 2) {
                status = 'Sudah Terbit';
                statusColor = 'bg-warning-subtle text-success border border-success';
                buttonAction = `<button onclick="prosesCairkan(${item.id_kop_proses_uang})" class="btn btn-dark btn-sm fw-semibold shadow-sm">Terbit Jurnal</button>`;
            } else if (item.kop_proses_uang_status === 'cair') {
                status = 'Sudah di Terbit kan';
                buttonAction = `<span class="text-muted fst-italic small">Jurnal Sudah Terbit</span>`;
            } else if (item.kop_proses_uang_status === '-1') {
                status = 'dI batalkan';
                statusColor = 'bg-danger-subtle text-danger border border-danger';
            }



            tableRows += `
            <tr>
                <td class="fw-bold text-dark">${item.kop_proses_uang_code}</td>
                <td>${item.kop_master_peserta_name}</td>
                <td class="fw-semibold">Rp ${Number(item.kop_proses_uang_nominal).toLocaleString('id-ID')}</td>
                <td class="text-danger fw-medium">${item.kop_proses_uang_bunga} %</td>
                <td class="text-danger fw-medium">${item.kop_proses_uang_admin} %</td>
                <td>${item.kop_proses_uang_tenor} Bulan</td>
                <td><span class="badge ${statusColor} px-2.5 py-1.5 rounded-pill">${status}</span></td>
                <td class="text-center">${buttonAction}</td>
            </tr>
        `;
        });

        tbody.innerHTML = tableRows;

        // 4. Inisialisasi ulang DataTables dengan konfigurasi Bahasa Indonesia & Bootstrap 5
        $(tableId).DataTable({
            responsive: true,
            pageLength: 10, // Menampilkan 10 data per halaman
            language: {
                search: "Cari Data:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: ">",
                    previous: "<"
                }
            }
        });
    }

    // 3. Aksi Trigger Pencairan Dana ke API Laravel
    async function prosesCairkan(id) {
        Swal.fire({
            title: 'Konfirmasi Pencairan',
            text: `Apakah Anda yakin ingin menerbitkan jurnal ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#212529', // Warna tombol dark (sesuai tema btn-dark)
            cancelButtonColor: '#dc3545', // Warna tombol merah
            confirmButtonText: 'Ya, Terbitkan!',
            cancelButtonText: 'Batal',
            reverseButtons: true // Membalik posisi tombol agar 'Batal' di kiri dan 'Ya' di kanan
        }).then((result) => {
            // 2. Jika user mengklik "Ya, Cairkan!"
            if (result.isConfirmed) {

                // Menampilkan loading block (bagus untuk proses异步/Ajax)
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Harap tunggu sebentar.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // 3. Jalankan proses Anda (Contoh menggunakan Fetch API / Ajax)
                // Ganti URL di bawah ini dengan URL endpoint backend Anda
                fetch(`{{ url('koperasi/akutansi-koperasi/jurnal-manual/get-peminjaman') }}/${id}/cairkan`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}" // <-- Tambahkan baris ini
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // 4. Tampilkan pesan Sukses
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Dana telah dicairkan dan jurnal berhasil diterbitkan.',
                            icon: 'success',
                            confirmButtonColor: '#212529'
                        }).then(() => {
                            fetchPeminjamanData();
                        });
                    })
                    .catch(error => {
                        // 5. Tampilkan pesan Gagal jika terjadi error
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat memproses data.',
                            icon: 'error',
                            confirmButtonColor: '#212529'
                        });
                    });

            }
        });

    }

    // Jalankan fungsi fetch saat pertama kali halaman dibuka
    window.onload = fetchPeminjamanData;
</script>
<!-- Script Peminjaman Barang -->
<script>
    // 1. Ambil data barang dari backend
    async function fetchBarangData() {
        try {
            const response = await fetch(`{{ route('akutansi_koperasi_get_peminjaman_barang') }}`);
            const data = await response.json();
            renderBarangTable(data);
        } catch (error) {
            console.error("Gagal mengambil data barang:", error);
            document.getElementById('barang-table-body').innerHTML = `
            <tr><td colspan="7" class="p-4 text-center text-danger fw-medium">Gagal memuat data barang.</td></tr>
        `;
        }
    }

    // 2. Render data ke tabel HTML Bootstrap 5
    function renderBarangTable(items) {
        const tableId = '#barang-table';
        const tbody = document.getElementById('barang-table-body');

        // 1. Hancurkan DataTable jika sudah pernah diinisialisasi sebelumnya
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().destroy();
        }

        // 2. Kosongkan isi tbody
        tbody.innerHTML = '';

        // Jika data kosong, DataTables akan otomatis menangani teks pemberitahuannya
        if (items.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted p-4">Tidak ada pengajuan pinjaman barang.</td></tr>`;
            return;
        }

        // 3. Render baris data tabel
        let tableRows = '';
        items.forEach(item => {
            const isDiserahkan = item.kop_proses_brg_status === 'diserahkan';

            // Menggunakan utilitas warna Bootstrap 5 yang lebih soft sesuai kode Anda
            const statusColor = isDiserahkan ?
                'bg-success-subtle text-success border border-success' :
                'bg-warning-subtle text-warning-emphasis border border-warning';

            // Menggunakan fungsi Swal pada onclick untuk proses interaktif yang modern
            const buttonAction = !isDiserahkan ?
                `<button onclick="prosesSerahkanBarang(${item.id_kop_proses_brg})" class="btn btn-success btn-sm fw-semibold shadow-sm">Serahkan & Jurnal</button>` :
                `<span class="text-muted small fst-italic">Barang Keluar & Dijurnal</span>`;

            tableRows += `
            <tr>
                <td class="fw-bold text-dark">${item.kop_proses_brg_code}</td>
                <td class="text-secondary">${item.kop_master_peserta_name}</td>
                <td class="fw-semibold text-dark">Rp ${Number(item.kop_proses_brg_nominal).toLocaleString('id-ID')}</td>
                <td class="text-primary fw-medium">${item.kop_proses_brg_bunga} %</td>
                <td class="text-primary fw-medium">${item.kop_proses_brg_admin} %</td>
                <td class="text-secondary">${item.kop_proses_brg_tenor} Bulan</td>
                <td><span class="badge ${statusColor} rounded-pill px-2.5 py-1.5 text-capitalize">${item.kop_proses_brg_status}</span></td>
                <td class="text-center">${buttonAction}</td>
            </tr>
        `;
        });

        tbody.innerHTML = tableRows;

        // 4. Inisialisasi ulang DataTables dengan konfigurasi Bahasa Indonesia
        $(tableId).DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "Cari Barang:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data pengajuan tidak ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: ">",
                    previous: "<"
                }
            }
        });
    }

    // 3. Eksekusi kirim data token CSRF ke rute web/api penyerahan barang
    async function prosesSerahkanBarang(id) {
        Swal.fire({
            title: 'Konfirmasi Penyerahan',
            text: `Apakah Anda yakin ingin menyerahkan barang & menerbitkan jurnal ?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754', // Warna hijau (sesuai tema btn-success)
            cancelButtonColor: '#dc3545', // Warna merah
            confirmButtonText: 'Ya, Terbitkan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                // Tampilkan animasi loading
                Swal.fire({
                    title: 'Memproses Penyerahan...',
                    text: 'Harap tunggu sebentar.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Eksekusi ke endpoint backend Anda (ganti URL sesuai kebutuhan)
                fetch(`{{ url('koperasi/akutansi-koperasi/jurnal-manual/get-peminjaman-barang') }}/${id}/serahkan`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Barang berhasil diserahkan dan jurnal otomatis diterbitkan.',
                            icon: 'success',
                            confirmButtonColor: '#198754'
                        }).then(() => {
                            fetchBarangData(); // Refresh data tabel barang
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi gangguan koneksi atau kesalahan server.',
                            icon: 'error',
                            confirmButtonColor: '#198754'
                        });
                    });

            }
        });
    }

    // Tambahkan pemanggilan ini di window.onload lama Anda
    const oldOnload = window.onload;
    window.onload = function() {
        if (oldOnload) oldOnload();
        fetchBarangData();
    };
</script>
<!-- Script Vocher Data -->
<script>
    // 1. Fetch data voucher dari server
    async function fetchVoucherData() {
        try {
            const response = await fetch(`{{ route('akutansi_koperasi_get_vocher') }}`);
            const data = await response.json();
            renderVoucherTable(data);
        } catch (error) {
            console.error("Gagal mengambil data voucher:", error);
            document.getElementById('voucher-table-body').innerHTML = `
            <tr><td colspan="7" class="p-4 text-center text-danger fw-medium">Gagal memuat data voucher.</td></tr>
        `;
        }
    }

    // 2. Render data voucher ke Bootstrap 5 Table
    function renderVoucherTable(items) {
        const tableId = '#voucher-table';
        const tbody = document.getElementById('voucher-table-body');

        // 1. Hancurkan DataTable jika sudah pernah diinisialisasi sebelumnya
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().destroy();
        }

        // 2. Kosongkan isi tbody
        tbody.innerHTML = '';

        // Jika data kosong, DataTables akan otomatis menangani teks pemberitahuannya
        if (items.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted p-4">Tidak ada data klaim voucher.</td></tr>`;
            return;
        }

        // 3. Render baris data tabel
        let tableRows = '';
        items.forEach(item => {
            const isDigunakan = item.kop_vocher_data_status === 'digunakan';

            // Penyesuaian warna badge Bootstrap 5 agar serasi dengan logika css Anda
            const statusColor = isDigunakan ?
                'bg-danger-subtle text-danger border border-danger' :
                'bg-primary-subtle text-primary border border-primary';

            // Tombol aksi mengarah ke fungsi SweetAlert2
            const buttonAction = !isDigunakan ?
                `<button onclick="prosesCairkanVoucher(${item.id_vocher_data})" class="btn btn-warning btn-sm fw-semibold shadow-sm text-white">Proses Voucher</button>` :
                `<span class="text-muted small fst-italic">Voucher Telah Diklaim</span>`;

            tableRows += `
            <tr>
                <td class="fw-bold text-dark">${item.kop_vocher_data_code}</td>
                <td class="font-monospace text-secondary small">${item.kop_vocher_data_token}</td>
                <td class="text-secondary">${item.kop_master_peserta_name}</td>
                <td class="fw-semibold text-success">Rp ${Number(item.kop_vocher_data_nominal).toLocaleString('id-ID')}</td>
                <td class="text-secondary">${item.kop_vocher_data_admin} %</td>
                <td class="text-muted small">${item.kop_vocher_data_date_start} s/d ${item.kop_vocher_data_date_end}</td>
                <td><span class="badge ${statusColor} rounded-pill px-2.5 py-1.5 text-capitalize">${item.kop_vocher_data_status}</span></td>
                <td class="text-center">${buttonAction}</td>
            </tr>
        `;
        });

        tbody.innerHTML = tableRows;

        // 4. Inisialisasi ulang DataTables dengan konfigurasi Bahasa Indonesia
        $(tableId).DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "Cari Voucher:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data voucher tidak ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: ">",
                    previous: "<"
                }
            }
        });
    }

    // 3. Request Kirim Data dengan Pengaman CSRF Token
    async function prosesCairkanVoucher(id) {
        Swal.fire({
            title: 'Konfirmasi Pencairan Voucher',
            text: `Apakah Anda yakin ingin Menerbitkan Jurnal voucher ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffc107', // Warna kuning pekat (sesuai tema btn-warning)
            cancelButtonColor: '#dc3545', // Warna merah
            confirmButtonText: 'Ya, Terbitkan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                // Tampilkan loading screen saat proses backend berjalan
                Swal.fire({
                    title: 'Mencairkan Voucher...',
                    text: 'Harap tunggu sebentar.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Eksekusi AJAX / Fetch ke backend Anda (ganti URL sesuai endpoint Anda)
                fetch(`{{ url('koperasi/akutansi-koperasi/jurnal-manual/get-vocher') }}/${id}/cairkan`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Voucher berhasil dicairkan dan saldo telah diperbarui.',
                            icon: 'success',
                            confirmButtonColor: '#ffc107'
                        }).then(() => {
                            fetchVoucherData(); // Refresh data voucher
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan sistem atau masalah koneksi.',
                            icon: 'error',
                            confirmButtonColor: '#ffc107'
                        });
                    });

            }
        });
    }

    // Daftarkan pemanggilan fetchVoucherData ke siklus window.onload
    const currentOnload = window.onload;
    window.onload = function() {
        if (currentOnload) currentOnload();
        fetchVoucherData();
    };
</script>
<!-- Script Arisan -->
<script>
    // 1. Ambil data arisan dari server
    async function fetchArisanData() {
        try {
            const response = await fetch(`{{ route('akutansi_koperasi_get_arisan') }}`);
            const data = await response.json();
            renderArisanTable(data);
        } catch (error) {
            console.error("Gagal mengambil data arisan:", error);
            document.getElementById('arisan-table-body').innerHTML = `
            <tr><td colspan="7" class="p-4 text-center text-danger fw-medium">Gagal memuat data program arisan.</td></tr>
        `;
        }
    }

    // 2. Tampilkan data ke tabel Bootstrap 5
    function renderArisanTable(items) {
        const tableId = '#arisan-table';
        const tbody = document.getElementById('arisan-table-body');

        // 1. Hancurkan DataTable jika sudah pernah diinisialisasi sebelumnya
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().destroy();
        }

        // 2. Kosongkan isi tbody
        tbody.innerHTML = '';

        // Jika data kosong, DataTables akan otomatis menangani teks pemberitahuannya
        if (items.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center text-muted p-4">Tidak ada grup arisan terdaftar.</td></tr>`;
            return;
        }

        // 3. Render baris data tabel arisan
        let tableRows = '';
        items.forEach(item => {
            const isDicairkan = item.kop_arisan_group_status === 'dicairkan';

            // Penyesuaian warna badge Bootstrap 5
            const statusColor = isDicairkan ?
                'bg-success-subtle text-success border border-success' :
                'bg-primary-subtle text-primary border border-primary';

            // Tombol aksi diarahkan ke fungsi penanganan SweetAlert2
            const buttonAction = !isDicairkan ?
                `<button onclick="prosesCairkanArisan(${item.id_kop_arisan_group})" class="btn btn-info btn-sm fw-semibold shadow-sm text-white">Terbit Jurnal</button>` :
                `<span class="text-muted small fst-italic">Arisan Selesai Dijurnal</span>`;

            tableRows += `
            <tr>
                <td class="fw-bold text-dark">${item.kop_arisan_group_code}</td>
                <td class="text-secondary fw-semibold">${item.kop_arisan_group_name}</td>
                <td class="text-dark fw-bold">Rp ${Number(item.kop_arisan_group_nominal).toLocaleString('id-ID')}</td>
                <td class="text-danger fw-medium">${item.kop_arisan_group_bunga} %</td>
                <td class="text-muted small">${item.kop_arisan_group_date_start} s/d ${item.kop_arisan_group_date_end}</td>
                <td><span class="badge ${statusColor} rounded-pill px-2.5 py-1.5 text-capitalize">${item.kop_arisan_group_status}</span></td>
                <td class="text-center">${buttonAction}</td>
            </tr>
        `;
        });

        tbody.innerHTML = tableRows;

        // 4. Inisialisasi ulang DataTables dengan bahasa Indonesia
        $(tableId).DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "Cari Arisan:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data grup arisan tidak ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: ">",
                    previous: "<"
                }
            }
        });
    }

    // 3. Kirim request dengan pengaman CSRF Token untuk Pencairan Arisan
    async function prosesCairkanArisan(id) {
        Swal.fire({
            title: 'Konfirmasi Undi & Cairkan',
            text: `Apakah Anda yakin ingin Terbitkan Jurnal grup arisan ini ?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0dcaf0', // Warna cyan/info (sesuai tema btn-info)
            cancelButtonColor: '#dc3545', // Warna merah
            confirmButtonText: 'Ya, Proses!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                // Tampilkan animasi pengundian/loading arisan
                Swal.fire({
                    title: 'Sedang Mengundi & Memproses...',
                    text: 'Harap tunggu proses pembuatan jurnal selesai.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Ganti URL endpoint berikut sesuai konfigurasi backend Anda
                fetch(`{{ url('koperasi/akutansi-koperasi/jurnal-manual/get-arisan') }}/${id}/cairkan`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Pemenang arisan berhasil diundi, dana dicairkan, dan jurnal berhasil diterbitkan.',
                            icon: 'success',
                            confirmButtonColor: '#0dcaf0'
                        }).then(() => {
                            fetchArisanData(); // Refresh data arisan
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi gangguan jaringan atau kesalahan pada server.',
                            icon: 'error',
                            confirmButtonColor: '#0dcaf0'
                        });
                    });

            }
        });
    }

    // Ikat ke siklus window.onload utama dashboard
    const arisanOnload = window.onload;
    window.onload = function() {
        if (arisanOnload) arisanOnload();
        fetchArisanData();
    };
</script>
<!-- Script Tagihan Bulan -->
<script>
    // 1. Ambil data tagihan dari backend
    async function fetchTagihanData() {
        try {
            const response = await fetch(`{{ route('akutansi_koperasi_get_tagihan_bulan') }}`);
            const data = await response.json();
            renderTagihanTable(data);
        } catch (error) {
            console.error("Gagal mengambil data tagihan bulanan:", error);
            document.getElementById('tagihan-table-body').innerHTML = `
            <tr><td colspan="7" class="p-4 text-center text-danger fw-medium">Gagal memuat data tagihan bulanan.</td></tr>
        `;
        }
    }

    // 2. Tampilkan ke dalam tabel Bootstrap 5
    function renderTagihanTable(items) {
        const tableId = '#tagihan-table';
        const tbody = document.getElementById('tagihan-table-body');

        // 1. Hancurkan DataTable jika sudah pernah diinisialisasi sebelumnya
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().destroy();
        }

        // 2. Kosongkan isi tbody
        tbody.innerHTML = '';

        // Jika data kosong, DataTables akan otomatis menangani teks pemberitahuannya
        if (items.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted p-4">Tidak ada tagihan bulanan bulan ini.</td></tr>`;
            return;
        }

        // 3. Render baris data tabel tagihan
        let tableRows = '';
        items.forEach(item => {
            const isLunas = item.kop_tagihan_bulan_status === 1;

            // Penyesuaian warna badge Bootstrap 5
            const statusColor = isLunas ?
                'bg-success-subtle text-success border border-success' :
                'bg-danger-subtle text-danger border border-danger';

            const statusText = isLunas ? 'Lunas' : 'Belum Bayar';

            // Tombol aksi diarahkan ke fungsi penanganan SweetAlert2
            const buttonAction = !isLunas ?
                `<button onclick="prosesBayarTagihan(${item.id_kop_tagihan_bulan})" class="btn btn-primary btn-sm fw-semibold shadow-sm">Terima Pembayaran</button>` :
                `<span class="text-success small fw-semibold">✓ Terbayar & Dijurnal</span>`;

            tableRows += `
            <tr>
                <td class="fw-bold text-dark">${item.kop_tagihan_bulan_code}</td>
                <td class="text-secondary">${item.kop_master_cabang_name}</td>
                <td class="text-secondary">${item.kop_tagihan_bulan_date}</td>
                <td class="text-dark fw-semibold">Rp ${Number(item.kop_tagihan_bulan_nominal).toLocaleString('id-ID')}</td>
                <td class="text-primary fw-medium">${item.kop_tagihan_bulan_bunga} %</td>
                <td class="fw-bold text-dark">${item.kop_tagihan_bulan_peserta} Peserta</td>
                <td><span class="badge ${statusColor} rounded-pill px-2.5 py-1.5">${statusText}</span></td>
                <td class="text-center">${buttonAction}</td>
            </tr>
        `;
        });

        tbody.innerHTML = tableRows;

        // 4. Inisialisasi ulang DataTables dengan bahasa Indonesia
        $(tableId).DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "Cari Tagihan:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Data tagihan tidak ditemukan",
                info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: ">",
                    previous: "<"
                }
            }
        });
    }

    // 3. Eksekusi Pembayaran Tagihan dengan Header CSRF Token
    async function prosesBayarTagihan(id) {
        Swal.fire({
            title: 'Konfirmasi Pembayaran',
            text: `Apakah Anda yakin ingin memproses pembayaran tagihan ini ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd', // Warna biru primer (sesuai tema btn-primary)
            cancelButtonColor: '#dc3545', // Warna merah
            confirmButtonText: 'Ya, Terima!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                // Tampilkan animasi loading proses jurnal
                Swal.fire({
                    title: 'Memproses Pembayaran...',
                    text: 'Sedang menerbitkan jurnal akuntansi, mohon tunggu.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Eksekusi AJAX / Fetch ke backend Anda (ganti URL sesuai endpoint backend Anda)
                fetch(`{{ url('koperasi/akutansi-koperasi/jurnal-manual/get-tagihan-bulan') }}/${id}/bayar`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            title: 'Sukses Berhasil!',
                            text: 'Pembayaran tagihan berhasil diterima dan jurnal otomatis diterbitkan.',
                            icon: 'success',
                            confirmButtonColor: '#0d6efd'
                        }).then(() => {
                            fetchTagihanData(); // Segarkan isi tabel tagihan bulanan
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal memproses pembayaran karena masalah sistem atau jaringan.',
                            icon: 'error',
                            confirmButtonColor: '#0d6efd'
                        });
                    });

            }
        });
    }

    // Kaitkan ke siklus window.onload global
    const tagihanOnload = window.onload;
    window.onload = function() {
        if (tagihanOnload) tagihanOnload();
        fetchTagihanData();
    };
</script>
@endsection
