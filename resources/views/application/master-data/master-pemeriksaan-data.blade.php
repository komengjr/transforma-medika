@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />

<style>
    /* =========================================
       RETRO / NEUBRUTALISM THEME STYLES
       ========================================= */
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-pink: #ffa6c9;
        --retro-cyan: #8bf0fa;
        --retro-orange: #ff914d;
        --retro-green: #c1ff72;
        --retro-purple: #c8b6ff;
        --retro-bg: #f4f0ea;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 5px 5px 0px var(--retro-dark);
        --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
    }

    body {
        background-color: var(--retro-bg);
    }

    /* Retro Cards */
    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        background-color: #ffffff;
        overflow: hidden;
    }

    /* Retro Header Banner */
    .retro-header-banner {
        background: linear-gradient(135deg, var(--retro-pink) 0%, var(--retro-orange) 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-dark);
    }

    /* Retro Buttons */
    .retro-btn {
        font-weight: 800 !important;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        transition: all 0.1s ease-in-out;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
    }

    .retro-btn:active {
        transform: translate(3px, 3px);
        box-shadow: 0px 0px 0px var(--retro-dark);
    }

    .retro-btn-primary {
        background-color: var(--retro-cyan);
        color: var(--retro-dark);
    }

    .retro-btn-primary:hover {
        background-color: #6ce0ed;
        color: var(--retro-dark);
    }

    .retro-btn-warning {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
    }

    .retro-btn-warning:hover {
        background-color: #e6c84c;
        color: var(--retro-dark);
    }

    .retro-btn-light {
        background-color: #ffffff;
        color: var(--retro-dark);
    }

    .retro-btn-light:hover {
        background-color: #f0f0f0;
        color: var(--retro-dark);
    }

    /* Inputs & Selects */
    .retro-input {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700;
        color: var(--retro-dark);
    }

    .retro-input:focus {
        border-color: var(--retro-dark) !important;
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
        outline: none;
    }

    /* Table Styling */
    .retro-table-header {
        background-color: var(--retro-dark);
        color: var(--retro-green);
        border-bottom: 3px solid var(--retro-dark);
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    #example tbody tr {
        border-bottom: 2px solid var(--retro-dark);
        transition: background 0.2s;
    }

    #example tbody tr:hover {
        background-color: var(--retro-yellow) !important;
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
        text-transform: uppercase;
        display: inline-block;
    }

    /* Modal Styling */
    .retro-modal-content {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: 8px 8px 0px var(--retro-dark);
        background-color: #ffffff;
    }

    /* DataTables Customization */
    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        box-shadow: 2px 2px 0px var(--retro-dark);
        padding: 4px 10px;
        font-weight: 600;
        outline: none;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-4">
    <div class="col">
        <div class="card retro-header-banner p-1">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center p-3">
                    <div style="background: white; border: 2px solid #1e1e24; border-radius: 50%; padding: 8px; box-shadow: 3px 3px 0px #1e1e24;" class="me-3">
                        <img src="{{ asset('img/kategori.png') }}" alt="" width="45" />
                    </div>
                    <div>
                        <h6 class="fs--1 mb-0 fw-bold" style="color: rgba(30, 30, 36, 0.7);">MANAJEMEN MEDIS</h6>
                        <h3 class="fw-bolder mb-0" style="color: var(--retro-dark); text-shadow: 1px 1px 0px white;">MASTER <span class="fw-normal">PEMERIKSAAN</span></h3>
                    </div>
                </div>
                <div class="col-xl-auto px-4 py-2 text-end d-flex align-items-center gap-2">
                    <button class="btn btn-sm retro-btn retro-btn-light" data-bs-toggle="modal" data-bs-target="#modal-history" id="button-data-history">
                        <i class="fas fa-history me-1"></i> HISTORY
                    </button>
                    <button class="btn btn-sm retro-btn retro-btn-primary" data-bs-toggle="modal" data-bs-target="#modal-pemeriksaan" id="button-add-data-pemeriksaan" data-code="{{ $code }}">
                        <i class="fas fa-plus me-1"></i> TAMBAH DATA
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER DATA CARD -->
<div class="retro-card mb-4" style="background-color: var(--retro-cyan);">
    <div class="card-body p-3">
        <div class="row align-items-end g-3">
            <div class="col-md-5">
                <label class="form-label fw-bolder mb-1" style="color: var(--retro-dark);"><i class="fas fa-filter me-1"></i> FILTER TIPE LAYANAN</label>
                <select id="filter-tipe" class="form-select retro-input">
                    <option value="">-- SEMUA TIPE LAYANAN --</option>
                    @foreach($tipe_layanan as $tl)
                    <option value="{{ $tl->nama_tipe }}">{{ strtoupper($tl->nama_tipe) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bolder mb-1" style="color: var(--retro-dark);"><i class="fas fa-box-open me-1"></i> JENIS PEMERIKSAAN</label>
                <select id="filter-jenis" class="form-select retro-input">
                    <option value="">-- SEMUA JENIS --</option>
                    <option value="PAKET">KHUSUS PAKET</option>
                    <option value="SATUAN">SATUAN (NON-PAKET)</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn retro-btn retro-btn-light w-100" id="btn-reset-filter">
                    <i class="fas fa-sync-alt me-1"></i> RESET FILTER
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CONTAINER TABEL -->
<div class="retro-card mb-4">
    <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: var(--retro-dark);">
        <h5 class="mb-0 fw-bolder" style="color: var(--retro-green);">
            <span class="fas fa-microscope me-2"></span> DATA LAYANAN PEMERIKSAAN
        </h5>
    </div>
    <div class="card-body p-4" style="background-color: #ffffff;">
        <div class="table-responsive">
            <table id="example" class="table align-middle nowrap fw-bold" style="width:100%; border: 2px solid var(--retro-dark);">
                <thead class="retro-table-header">
                    <tr>
                        <th class="text-center py-3" style="width: 50px;">NO</th>
                        <th class="py-3">KODE</th>
                        <th class="py-3">TIPE LAYANAN</th>
                        <th class="py-3 text-center">JENIS</th>
                        <th class="py-3">NAMA PEMERIKSAAN</th>
                        <th class="py-3">TARIF DASAR</th>
                        <th class="text-center py-3">STATUS</th>
                        <th class="text-center py-3" style="width: 100px;">AKSI</th>
                    </tr>
                </thead>
                <tbody style="color: var(--retro-dark);">
                    @php $no = 1; @endphp
                    @foreach ($data as $item)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td><span class="retro-badge" style="background-color: var(--retro-bg);">{{ $item->kode_layanan }}</span></td>
                        <td class="text-uppercase">{{ $item->nama_tipe }}</td>
                        <td class="text-center">
                            @if($item->is_paket)
                            <span class="retro-badge" style="background-color: var(--retro-purple); color: var(--retro-dark);">PAKET</span>
                            @else
                            <span class="retro-badge" style="background-color: #ffffff; color: var(--retro-dark);">SATUAN</span>
                            @endif
                        </td>
                        <td class="text-uppercase" style="font-size: 1.05rem;">{{ $item->nama_layanan }}</td>
                        <td style="color: #198754; font-size: 1.1rem;">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($item->is_active)
                            <span class="retro-badge" style="background-color: var(--retro-green);">AKTIF</span>
                            @else
                            <span class="retro-badge" style="background-color: var(--retro-pink);">NON-AKTIF</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm retro-btn retro-btn-warning" id="button-edit-pemeriksaan" data-code="{{ $item->kode_layanan }}" data-bs-toggle="modal" data-bs-target="#modal-pemeriksaan">
                                <i class="far fa-edit me-1"></i> EDIT
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH/EDIT PEMERIKSAAN -->
<div class="modal fade" id="modal-pemeriksaan" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content retro-modal-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0); border: 2px solid #1e1e24; border-radius: 50%; padding: 5px; box-shadow: 2px 2px 0px #1e1e24;"></button>
            </div>
            <!-- Konten modal akan diload via AJAX di dalam div ini -->
            <div id="menu-pemeriksaan"></div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // --- 1. INIT DATATABLES ---
        var table = $('#example').DataTable({
            responsive: true,
            language: {
                search: "CARI PADA TABEL:",
                lengthMenu: "TAMPIL _MENU_ DATA",
                info: "MENAMPILKAN _START_ S/D _END_ DARI _TOTAL_ PEMERIKSAAN",
                paginate: {
                    first: "AWAL",
                    last: "AKHIR",
                    next: "❯",
                    previous: "❮"
                }
            }
        });

        // --- 2. LOGIKA CUSTOM FILTER DATATABLES ---
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var filterTipe = $('#filter-tipe').val().toUpperCase();
                var filterJenis = $('#filter-jenis').val().toUpperCase();

                // Index Kolom: 2 = Tipe Layanan, 3 = Jenis (Paket/Satuan)
                var rowTipe = data[2].toUpperCase();
                var rowJenis = data[3].toUpperCase();

                // Pengecekan Tipe Layanan
                if (filterTipe && rowTipe.indexOf(filterTipe) === -1) {
                    return false;
                }

                // Pengecekan Jenis Paket / Satuan
                if (filterJenis && rowJenis.indexOf(filterJenis) === -1) {
                    return false;
                }

                return true;
            }
        );

        // Memicu filter ulang setiap dropdown berubah
        $('#filter-tipe, #filter-jenis').on('change', function() {
            table.draw();
        });

        // Tombol Reset Filter
        $('#btn-reset-filter').on('click', function() {
            $('#filter-tipe').val('');
            $('#filter-jenis').val('');
            table.draw();
        });


        // --- 3. AJAX LOAD MODAL TAMBAH ---
        $(document).on("click", "#button-add-data-pemeriksaan", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-pemeriksaan').html(
                '<div class="text-center p-5"><div class="spinner-border" style="color: var(--retro-pink); width: 3rem; height: 3rem;" role="status"></div><p class="mt-3 fw-bold" style="color: var(--retro-dark);">MEMUAT FORM...</p></div>'
            );
            $.ajax({
                url: "{{ route('master_pemeriksaan_data_add') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-pemeriksaan').html(data);
            }).fail(function() {
                $('#menu-pemeriksaan').html('<div class="alert alert-danger m-4 fw-bold border-dark shadow-sm">Gagal memuat data dari server.</div>');
            });
        });

        // --- 4. AJAX LOAD MODAL EDIT ---
        $(document).on("click", "#button-edit-pemeriksaan", function(e) {
            e.preventDefault();
            var code = $(this).data("code"); // Mengambil kode_layanan
            $('#menu-pemeriksaan').html(
                '<div class="text-center p-5"><div class="spinner-border" style="color: var(--retro-cyan); width: 3rem; height: 3rem;" role="status"></div><p class="mt-3 fw-bold" style="color: var(--retro-dark);">MEMUAT DATA...</p></div>'
            );
            $.ajax({
                url: "{{ route('master_pemeriksaan_update') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-pemeriksaan').html(data);
            }).fail(function() {
                $('#menu-pemeriksaan').html('<div class="alert alert-danger m-4 fw-bold border-dark shadow-sm">Gagal memuat data dari server.</div>');
            });
        });
        // --- 5. AJAX SUBMIT FORM TAMBAH (TANPA REFRESH) ---
        $(document).on('submit', '#form-add-pemeriksaan', function(e) {
            e.preventDefault(); // Mencegah reload halaman

            var form = $(this);
            var btnSave = $('#btn-save-pemeriksaan');
            var originalText = btnSave.html();

            // Ubah tombol jadi loading
            btnSave.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> MENYIMPAN...');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        // Tutup Modal
                        $('#modal-pemeriksaan').modal('hide');

                        // Formatting harga untuk DataTables
                        var formattedHarga = new Intl.NumberFormat('id-ID').format(res.data.harga);
                        var badgeJenis = res.data.is_paket == 1 ?
                            `<span class="retro-badge" style="background-color: var(--retro-purple); color: var(--retro-dark);">PAKET</span>` :
                            `<span class="retro-badge" style="background-color: #ffffff; color: var(--retro-dark);">SATUAN</span>`;

                        // Build baris HTML baru untuk dimasukkan ke DataTables
                        var newRow = [
                            '<div class="text-center"><i class="fas fa-star text-warning"></i></div>', // Indikator data baru
                            `<span class="retro-badge" style="background-color: var(--retro-bg);">${res.data.kode_layanan}</span>`,
                            `<span class="text-uppercase">${res.data.nama_tipe}</span>`,
                            `<div class="text-center">${badgeJenis}</div>`,
                            `<span class="text-uppercase" style="font-size: 1.05rem;">${res.data.nama_layanan}</span>`,
                            `<span style="color: #198754; font-size: 1.1rem;">Rp ${formattedHarga}</span>`,
                            `<div class="text-center"><span class="retro-badge" style="background-color: var(--retro-green);">AKTIF</span></div>`,
                            `<div class="text-center"><button class="btn btn-sm retro-btn retro-btn-warning" id="button-edit-pemeriksaan" data-code="${res.data.kode_layanan}" data-bs-toggle="modal" data-bs-target="#modal-pemeriksaan"><i class="far fa-edit me-1"></i> EDIT</button></div>`
                        ];

                        // Insert ke DataTables di urutan paling atas dan Gambar ulang tabel (draw)
                        // .draw(false) agar tidak berpindah halaman saat ini
                        table.row.add(newRow).draw(false);

                        // Tampilkan Notifikasi Sukses
                        alert('Berhasil: ' + res.message); // Anda bisa menggantinya dengan SweetAlert/Toast
                    }
                },
                error: function(xhr) {
                    // Kembalikan tombol seperti semula jika error
                    btnSave.prop('disabled', false).html(originalText);

                    var errorMsg = 'Terjadi Kesalahan pada Server.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    alert('Gagal: ' + errorMsg); // Anda bisa menggantinya dengan SweetAlert
                }
            });
        });
        $(document).on('submit', '#form-update-pemeriksaan', function(e) {
            e.preventDefault(); // Mencegah reload / refresh halaman bawaan browser

            var form = $(this);
            var btnSave = form.find('button[type="submit"]'); // Mencari tombol submit di dalam form
            var originalText = btnSave.html();

            // 1. Ubah tombol menjadi status Loading agar tidak di-klik 2 kali
            btnSave.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> MEMPROSES...');

            // 2. Kirim data menggunakan AJAX
            $.ajax({
                url: form.attr('action'), // Mengambil route dari atribut action form
                type: 'POST',
                data: form.serialize(), // Mengambil semua inputan dari form
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        // 3. Tutup Modal setelah sukses
                        $('#modal-pemeriksaan').modal('hide');

                        // 4. Tampilkan pesan sukses (Bisa diganti menggunakan SweetAlert)
                        alert('Berhasil: ' + res.message);

                        // 5. Update DataTables secara instan tanpa refresh
                        // Pastikan variabel tabel DataTables Anda sudah di-inisialisasi sebelumnya, contoh: var table = $('#example').DataTable();
                        if (typeof table !== 'undefined') {
                            var formattedHarga = new Intl.NumberFormat('id-ID').format(res.data.harga);
                            var badgeJenis = res.data.is_paket == 1 ?
                                `<span class="retro-badge" style="background-color: var(--retro-purple); color: var(--retro-dark);">PAKET</span>` :
                                `<span class="retro-badge" style="background-color: #ffffff; color: var(--retro-dark);">SATUAN</span>`;
                            var badgeStatus = res.data.is_active == 1 ?
                                `<span class="retro-badge" style="background-color: var(--retro-green);">AKTIF</span>` :
                                `<span class="retro-badge" style="background-color: var(--retro-pink);">NON-AKTIF</span>`;

                            // Cari baris yang diedit dan perbarui isinya
                            table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                                var rowData = this.data();
                                // Asumsi Kode Layanan ada di kolom ke-2 (index 1)
                                if (rowData[1].includes(res.data.kode_layanan)) {
                                    rowData[2] = `<span class="text-uppercase">${res.data.nama_tipe}</span>`;
                                    rowData[3] = `<div class="text-center">${badgeJenis}</div>`;
                                    rowData[4] = `<span class="text-uppercase" style="font-size: 1.05rem;">${res.data.nama_layanan}</span>`;
                                    rowData[5] = `<span style="color: #198754; font-size: 1.1rem;">Rp ${formattedHarga}</span>`;
                                    rowData[6] = `<div class="text-center">${badgeStatus}</div>`;

                                    table.row(rowIdx).data(rowData).invalidate(); // Terapkan data baru ke baris
                                }
                            });

                            table.draw(false); // Render ulang tabel tanpa kembali ke halaman 1
                        } else {
                            // Jika Anda tidak menggunakan cara update baris dinamis di atas, gunakan reload halaman sebagai fallback
                            // location.reload();
                        }
                    }
                },
                error: function(xhr) {
                    // Kembalikan tombol seperti semula jika terjadi error
                    btnSave.prop('disabled', false).html(originalText);

                    // Ambil pesan error dari backend JSON
                    var errorMsg = 'Terjadi Kesalahan pada Server.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    alert('Gagal: ' + errorMsg); // Bisa diganti SweetAlert
                }
            });
        });
        // --- 7. AJAX SUBMIT IMPORT EXCEL (TANPA REFRESH) ---
        $(document).on('submit', '#form-import-pemeriksaan', function(e) {
            e.preventDefault();

            var form = $(this);
            var btnSave = form.find('button[type="submit"]');
            var originalText = btnSave.html();

            // Animasi Loading
            btnSave.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> MENGUPLOAD...');

            var formData = new FormData(this); // Gunakan FormData karena ada file upload

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                contentType: false, // Wajib false untuk file upload AJAX
                processData: false, // Wajib false untuk file upload AJAX
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        $('#modal-pemeriksaan').modal('hide');
                        alert('Berhasil: ' + res.message); // Bisa diganti SweetAlert

                        // Khusus import (karena banyak data), kita reload halamannya agar tabel me-render seluruh data baru
                        location.reload();
                    }
                },
                error: function(xhr) {
                    btnSave.prop('disabled', false).html(originalText);

                    var errorMsg = 'Gagal mengupload file.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    alert('Error: ' + errorMsg);
                }
            });
        });
    });
</script>
@endsection
