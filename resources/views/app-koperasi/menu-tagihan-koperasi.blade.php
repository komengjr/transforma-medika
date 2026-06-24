@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.4/css/buttons.dataTables.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    .nav-pills .nav-link {
        border-radius: 8px;
        color: #495057;
        font-weight: 600;
        padding: 10px 20px;
    }

    #tab-bulanan .nav-link.active {
        background-color: #0dcaf0;
        color: #000;
    }

    #tab-voucher .nav-link.active {
        background-color: #ffc107;
        color: #000;
    }

    #tab-peminjaman-uang .nav-link.active {
        background-color: #dc3545;
        color: #fff;
    }
    #tab-peminjaman-barang .nav-link.active {
        background-color: #0b57ee;
        color: #fff;
    }

    #tab-lain .nav-link.active {
        background-color: #6c757d;
        color: #fff;
    }

    .table-responsive {
        border-radius: 0 0 12px 12px;
        overflow: hidden;
    }
</style>
@endsection
@section('content')
<div class="row mb-3 ">
    <div class="col">
        <div class="card bg-200 shadow border border-primary bg-primary">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3 m-2" src="{{ asset('img/gl.png') }}" alt="" width="50" />
                    <div>
                        <h6 class="text-white fs--1 mb-0 pt-2" style="color: white !important;">Welcome to </h6>
                        <h4 class="text-white fw-bold mb-1" style="color: white !important;">{{ Env('APP_LABEL') }}
                            <span class="text-white fw-medium" style="color: white !important;">Management
                                System</span>
                        </h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-white fs--1 mb-0" style="color: white !important;">Menu : </h6>
                    <h4 class="text-white fw-bold mb-0" style="color: white !important;">Daftar <span
                            class="text-white fw-medium" style="color: white !important;">Penagihan Koperasi</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-custom p-4 mb-3 bg-white border-start border-primary border-0">
    <h5 class="fw-bold text-secondary mb-3"><i class="bi bi-sliders me-2"></i> Parameter Filter Pencarian</h5>
    <form id="filterForm" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label text-muted small fw-bold">CABANG KOPERASI</label>
            <select class="form-select" id="cabang_id" name="cabang_id">
                <option value="semua">Semua Cabang</option>
                @foreach($list_cabang as $cabang)
                <option value="{{ $cabang->kop_master_cabang_code }}">[ {{$cabang->kop_master_cabang_code}} ] {{ $cabang->kop_master_cabang_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label text-muted small fw-bold">TANGGAL MULAI</label>
            <input type="date" class="form-control" id="start_date" name="start_date">
        </div>
        <div class="col-md-3">
            <label class="form-label text-muted small fw-bold">TANGGAL SELESAI</label>
            <input type="date" class="form-control" id="end_date" name="end_date">
        </div>
        <div class="col-md-3 d-grid">
            <button type="button" onclick="loadDataTagihan()" class="btn btn-primary py-2 fw-bold shadow-sm">
                <i class="bi bi-search me-2"></i> Cari Data
            </button>
        </div>
    </form>
</div>

<ul class="nav nav-pills gap-2 mb-3 p-2 bg-white rounded-3 shadow-sm" id="pills-tab" role="tablist">
    <li class="nav-item" id="tab-bulanan"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-bulanan" type="button" role="tab">Bulanan</button></li>
    <li class="nav-item" id="tab-voucher"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-voucher" type="button" role="tab">Voucher</button></li>
    <li class="nav-item" id="tab-peminjaman-uang"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-peminjaman-uang" type="button" role="tab">Peminjaman Uang</button></li>
    <li class="nav-item" id="tab-peminjaman-barang"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-peminjaman-barang" type="button" role="tab">Peminjaman Barang</button></li>
    <li class="nav-item" id="tab-lain"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-lain" type="button" role="tab">Lain-Lain</button></li>
</ul>

<div class="tab-content card card-custom bg-white shadow-sm" id="pills-tabContent">
    @foreach([
    'bulanan' => ['id' => 'pills-bulanan', 'class' => 'show active', 'text' => 'Simpanan Wajib & Pokok', 'color' => 'info'],
    'voucher' => ['id' => 'pills-voucher', 'class' => '', 'text' => 'Belanja Toko / Kantin', 'color' => 'warning'],
    'peminjaman_uang' => ['id' => 'pills-peminjaman-uang', 'class' => '', 'text' => 'Angsuran & Pinjaman', 'color' => 'danger'],
    'peminjaman_barang' => ['id' => 'pills-peminjaman-barang', 'class' => '', 'text' => 'Angsuran & Pinjaman', 'color' => 'primary'],
    'lain' => ['id' => 'pills-lain', 'class' => '', 'text' => 'Biaya Administrasi & Sanksi', 'color' => 'secondary']
    ] as $key => $meta)
    <div class="tab-pane fade {{ $meta['class'] }}" id="{{ $meta['id'] }}" role="tabpanel">
        <div class="p-3 bg-{{ $meta['color'] }} bg-opacity-10 border-bottom d-flex justify-content-between align-items-center">
            <span class="fw-bold text-white">{{ $meta['text'] }}</span>
            <span class="badge bg-{{ $meta['color'] }} text-dark fw-bold fs-2" id="total-{{ $key }}">Total: Rp 0</span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>No. Tagihan</th>
                        <th>Nama Cabang</th>
                        <th>Tanggal</th>
                        <th>ID Peserta</th>
                        <th>Nama Peserta</th>
                        <th>Status</th>
                        <th>Nominal</th>
                    </tr>
                </thead>
                <tbody id="data-{{ $key }}">
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Silakan tentukan filter lalu klik Cari Data.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

</div>


@endsection
@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js">
</script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/dataTables.buttons.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.4/js/buttons.print.min.js"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fungsi AJAX Fetch API untuk mengambil data dari Route ke-2 tanpa reload halaman
    function loadDataTagihan() {
        const cabang = document.getElementById('cabang_id').value;
        const start = document.getElementById('start_date').value;
        const end = document.getElementById('end_date').value;

        // Berikan indikator loading pada semua tabel
        const categories = ['bulanan', 'voucher', 'peminjaman_uang','peminjaman_barang', 'lain'];
        categories.forEach(key => {
            document.getElementById(`data-${key}`).innerHTML = `<tr><td colspan="8" class="text-center py-4 text-primary"><div class="spinner-border spinner-border-sm me-2"></div>Memuat data...</td></tr>`;
        });

        // Tembak URL Route ke-2 dengan query string parameter
        fetch(`{{ route('menu_koperasi_tagihan_koperasi_load') }}?cabang_id=${cabang}&start_date=${start}&end_date=${end}`)
            .then(response => response.json())
            .then(res => {
                categories.forEach(key => {
                    // 1. Update Badge Total Uang Nominal
                    document.getElementById(`total-${key}`).innerText = 'Total: ' + formatRupiah(res[key].total);

                    // 2. Render isi baris tabel body
                    let htmlRows = '';
                    if (res[key].data.length === 0) {
                        htmlRows = `<tr><td colspan="8" class="text-center py-4 text-muted">Tidak ditemukan data penagihan.</td></tr>`;
                    } else {
                        res[key].data.forEach((item, index) => {
                            let namaCabang = item.peserta && item.peserta.cabang ? item.peserta.cabang.kop_master_cabang_name : (item.peserta ? item.peserta.kop_master_peserta_cabang : 'N/A');
                            let idPeserta = item.peserta ? item.peserta.kop_master_peserta_code : item.kop_req_tagihan_id;
                            let namaPeserta = item.peserta ? item.peserta.kop_master_peserta_name : 'Data Peserta Hilang';
                            let badgeStatus = item.kop_req_tagihan_status === 'paid' ? 'bg-success' : 'bg-warning text-dark';

                            htmlRows += `
                                <tr>
                                    <td class="ps-4">${index + 1}</td>
                                    <td><code>${item.kop_req_tagihan_code}</code></td>
                                    <td><span class="badge bg-light text-secondary border">${namaCabang}</span></td>
                                    <td>${formatTanggal(item.kop_req_tagihan_date)}</td>
                                    <td><span class="badge bg-light text-dark border">${idPeserta}</span></td>
                                    <td class="fw-semibold">${namaPeserta}</td>
                                    <td><span class="badge ${badgeStatus}">${item.kop_req_tagihan_status.toUpperCase()}</span></td>
                                    <td class="fw-bold text-dark">${formatRupiah(item.kop_req_tagihan_nominal)}</td>
                                </tr>`;
                        });
                    }
                    document.getElementById(`data-${key}`).innerHTML = htmlRows;
                });
            })
            .catch(error => {
                console.error("Gagal memuat data:", error);
                alert("Terjadi kesalahan sistem saat memuat data.");
            });
    }

    // Fungsi Pembantu: Format Angka ke Rupiah Akuntansi
    function formatRupiah(angka) {
        return 'Rp ' + parseFloat(angka).toLocaleString('id-ID', {
            minimumFractionDigits: 0
        });
    }

    // Fungsi Pembantu: Format Tanggal YYYY-MM-DD ke DD MMM YYYY
    function formatTanggal(stringTanggal) {
        const opsi = {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        };
        return new Date(stringTanggal).toLocaleDateString('id-ID', opsi);
    }
</script>
@endsection
