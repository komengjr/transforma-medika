@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-cyan: #8bf0fa;
        --retro-green: #c1ff72;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 5px 5px 0px var(--retro-dark);
        --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
    }

    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        background-color: #ffffff;
        overflow: hidden;
    }

    .retro-header-banner {
        background: linear-gradient(135deg, #2b5876 0%, #4e4376 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: white;
    }

    .retro-btn {
        font-weight: 800 !important;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        text-transform: uppercase;
        cursor: pointer;
    }

    .retro-btn-primary {
        background-color: var(--retro-cyan);
        color: var(--retro-dark);
    }

    .retro-btn-warning {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
    }

    .retro-btn-success {
        background-color: var(--retro-green);
        color: var(--retro-dark);
    }

    .retro-input,
    .form-control,
    .form-select {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
        font-size: 0.8rem !important;
    }

    .table-custom {
        font-size: 0.8rem;
        border-collapse: collapse !important;
        width: 100%;
    }

    .table-custom thead th {
        background-color: var(--retro-dark) !important;
        color: var(--retro-green) !important;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        border: 2px solid var(--retro-dark) !important;
        padding: 12px 10px;
        text-align: center;
    }

    .table-custom td {
        border: 2px solid var(--retro-dark) !important;
        font-weight: 700;
        color: var(--retro-dark);
        padding: 10px;
        vertical-align: middle;
        background-color: #ffffff;
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
        text-transform: uppercase;
        font-size: 0.7rem;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-white">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <i class="fas fa-pills text-danger fs-2"></i>
                        </div>
                        <div>
                            <span class="retro-badge mb-1 d-inline-block bg-warning text-dark">Manajemen Farmasi</span>
                            <h3 class="fw-bolder mb-0 text-white" style="font-size: 1.4rem;">Order Pasien Internal (E-Resep)</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR -->
<div class="retro-card mb-4 p-3 bg-white">
    <form id="form-filter" onsubmit="event.preventDefault(); reloadTable();">
        <div class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="form-label fs--1 fw-bold text-dark mb-1">Dari Tanggal</label>
                <input class="form-control form-control-sm retro-input" type="date" id="start_date" name="start_date" value="{{ date('Y-m-01') }}" />
            </div>
            <div class="col-md-2">
                <label class="form-label fs--1 fw-bold text-dark mb-1">Sampai Tanggal</label>
                <input class="form-control form-control-sm retro-input" type="date" id="end_date" name="end_date" value="{{ date('Y-m-d') }}" />
            </div>
            <div class="col-md-3">
                <label class="form-label fs--1 fw-bold text-dark mb-1">Kategori Layanan</label>
                <select class="form-select form-select-sm retro-input" id="kategori_layanan" name="kategori_layanan">
                    <option value="ALL">-- Semua Layanan --</option>
                    <option value="IGD">IGD (Gawat Darurat)</option>
                    <option value="RANAP">Rawat Inap</option>
                    <option value="POLIKLINIK">Rawat Jalan / Poliklinik</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fs--1 fw-bold text-dark mb-1">Pencarian</label>
                <input class="form-control form-control-sm retro-input" type="text" id="keyword" name="keyword" placeholder="Cari No Reg / Nama / RM..." />
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn retro-btn retro-btn-warning btn-sm w-100 fw-bold" style="height: 38px;">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </div>
    </form>
</div>

<!-- MAIN TABLE MONITORING -->
<div class="retro-card mb-4">
    <div class="card-header bg-white border-bottom border-dark d-flex justify-content-between align-items-center py-3 px-3">
        <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-list-alt text-success me-2"></i> Daftar Antrean Order Resep Internal</h5>
    </div>
    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="table-order-internal" class="table table-custom align-middle w-100 mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>Tgl Order & No Reg</th>
                        <th>Pasien & RM</th>
                        <th>Kategori & Ruangan</th>
                        <th>Dokter DPJP</th>
                        <th class="text-center">Status Order</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data dimuat via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL DETAIL ORDER RESEP -->
<div class="modal fade" id="modalDetailOrder" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0 retro-card">
            <div class="modal-header py-3 px-4" style="background-color: var(--retro-yellow); border-bottom: 3px solid var(--retro-dark);">
                <h5 class="modal-title fw-bolder text-dark">
                    <i class="fas fa-prescription-bottle-alt me-2"></i> Rincian Order Resep: <span id="detail_nama_pasien" class="text-danger"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless fs--1 fw-bold text-dark">
                            <tr>
                                <td width="130">No. Registrasi</td>
                                <td width="10">:</td>
                                <td id="lbl_no_reg" class="text-success">-</td>
                            </tr>
                            <tr>
                                <td>Kategori Layanan</td>
                                <td>:</td>
                                <td id="lbl_kategori_layanan">-</td>
                            </tr>
                            <tr>
                                <td>Dokter Pengirim</td>
                                <td>:</td>
                                <td id="lbl_dokter">-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <span class="retro-badge bg-cyan text-dark d-inline-block mb-1" id="lbl_status_verifikasi">Status: Menunggu</span>
                    </div>
                </div>

                <div class="table-responsive mb-3">
                    <table class="table table-bordered table-sm fs--1 align-middle text-center table-custom" style="border: 2px solid var(--retro-dark);">
                        <thead class="table-dark" style="background-color: var(--retro-dark); color: var(--retro-green);">
                            <tr>
                                <th class="py-2 px-3 text-start">Nama Obat</th>
                                <th class="py-2 px-3 text-center" style="width: 60px;">Qty</th>
                                <th class="py-2 px-3 text-start" style="width: 150px;">Signa</th>
                                <th class="py-2 px-3 text-end" style="width: 120px;">Harga Satuan</th>
                                <th class="py-2 px-3 text-end" style="width: 120px;">Subtotal</th>
                                <!-- Tambahan Kolom Baru -->
                                <th class="py-2 px-3 text-center" style="width: 90px;">Sedia?</th>
                                <th class="py-2 px-3 text-center" style="width: 180px;">Keterangan / Notes</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-detail-resep" class="bg-white">
                            <tr>
                                <td colspan="7" class="text-center py-3">Memuat rincian obat...</td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-light">
                            <tr style="border-top: 3px solid var(--retro-dark);">
                                <td colspan="4" class="text-end fw-bolder text-dark px-3 py-2 text-uppercase">Total Biaya Resep (Tersedia):</td>
                                <td class="text-end fw-bolder text-danger px-3 py-2" id="total-resep-text">Rp 0</td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light border-top border-dark d-flex justify-content-between">
                <button type="button" class="btn btn-secondary btn-sm fw-bold px-4 retro-btn" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success btn-sm fw-bold px-4 retro-btn retro-btn-success" id="btn-proses-farmasi">
                    <i class="fas fa-check-circle me-1"></i> Proses Penjualan Farmasi
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let tableOrderInternal;
    let currentRegistrasiId = null;

    $(document).ready(function() {
        // Konfigurasi DataTable Server-Side (Pastikan Anda membuat route ini di backend)
        tableOrderInternal = $('#table-order-internal').DataTable({
            processing: true,
            serverSide: false, // <--- Pastikan ini false
            responsive: true,
            ajax: {
                url: "{{ route('farmasi.order.internal.data') }}", // <-- Ganti dengan Route Backend Anda
                type: "GET",
                data: function(d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                    d.kategori_layanan = $('#kategori_layanan').val();
                    d.keyword = $('#keyword').val();
                }
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1; // Membuat nomor urut otomatis berdasarkan baris
                    },
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'no_registrasi',
                    render: function(data, type, row) {
                        return `<span class="fw-bold text-success">${data}</span><br>
                    <small class="text-muted"><i class="far fa-clock"></i> ${row.tgl_order}</small>`;
                    }
                },
                {
                    data: 'nama_pasien',
                    render: function(data, type, row) {
                        return `<span class="fw-bold text-dark">${data}</span><br>
                    <small class="text-muted">RM: ${row.pid}</small>`;
                    }
                },
                {
                    data: 'kategori',
                    render: function(data, type, row) {
                        let badgeColor = data === 'IGD' ? 'bg-danger text-white' : (data === 'RANAP' ? 'bg-warning text-dark' : 'bg-primary text-white');
                        return `<span class="retro-badge ${badgeColor} mb-1">${data}</span><br>
                    <small class="text-dark fw-bold">${row.nama_ruangan}</small>`;
                    }
                },
                {
                    data: 'nama_dokter',
                    name: 'nama_dokter'
                },
                {
                    data: 'status_order',
                    className: 'text-center',
                    render: function(data) {
                        let badge = data === 'Selesai' ? 'bg-success' : 'bg-warning text-dark';
                        return `<span class="retro-badge ${badge}">${data}</span>`;
                    }
                },
                {
                    data: 'aksi',
                    className: 'text-center',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                <button type="button" class="btn retro-btn retro-btn-primary btn-sm px-3 py-1 fs--2" onclick="lihatDetailOrder('${row.registrasi_id}', '${row.nama_pasien}', '${row.kategori}', '${row.nama_dokter}', '${row.no_registrasi}')">
                    <i class="fas fa-eye"></i> Detail Order
                </button>
            `;
                    }
                }
            ]
        });
    });

    function reloadTable() {
        tableOrderInternal.ajax.reload(null, false);
    }

    function lihatDetailOrder(registrasiId, namaPasien, kategori, dokter, noReg) {
        currentRegistrasiId = registrasiId;
        $('#detail_nama_pasien').text(namaPasien);
        $('#lbl_no_reg').text(noReg);
        $('#lbl_kategori_layanan').text(kategori);
        $('#lbl_dokter').text(dokter);

        $('#tbody-detail-resep').html('<tr><td colspan="7" class="text-center py-3">Memuat data order resep...</td></tr>');
        $('#total-resep-text').text('Rp 0');

        $('#modalDetailOrder').modal('show');

        $.ajax({
            url: "{{ route('farmasi.order.internal.detail') }}",
            type: "GET",
            data: {
                registrasi_id: registrasiId,
                kategori: kategori
            },
            success: function(res) {
                if (res.success) {
                    let resepRows = '';

                    if (res.data.length > 0) {
                        res.data.forEach(function(item) {
                            let qty = parseFloat(item.qty) || 1;
                            let harga = parseFloat(item.harga) || 0;
                            let subtotal = qty * harga;

                            // Tambahkan input toggle dan catatan
                            resepRows += `
                                <tr data-kode="${item.farm_data_obat_code}">
                                    <td class="fw-bold text-dark text-start">${item.nama_obat}</td>
                                    <td class="text-center fw-bold">${qty}</td>
                                    <td class="text-start">${item.signa || '-'}</td>
                                    <td class="text-end">Rp ${harga.toLocaleString('id-ID')}</td>
                                    <td class="text-end fw-bold text-success subtotal-cell" data-subtotal="${subtotal}">Rp ${subtotal.toLocaleString('id-ID')}</td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center mb-0">
                                            <input class="form-check-input switch-ketersediaan" type="checkbox" checked onchange="hitungUlangTotalResep()">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm retro-input input-keterangan" placeholder="Tulis alasan jika kosong...">
                                    </td>
                                </tr>`;
                        });
                    } else {
                        resepRows = '<tr><td colspan="7" class="text-center text-muted py-3">Tidak ada obat pada order resep ini.</td></tr>';
                    }

                    $('#tbody-detail-resep').html(resepRows);
                    hitungUlangTotalResep(); // Hitung total saat pertama kali di load
                }
            },
            error: function() {
                Swal.fire('Error', 'Gagal memuat rincian order resep.', 'error');
            }
        });
    }

    // FUNGSI UNTUK MENGHITUNG ULANG TOTAL (Mengabaikan obat yang di-uncheck / tidak sedia)
    function hitungUlangTotalResep() {
        let totalBiaya = 0;
        $('#tbody-detail-resep tr').each(function() {
            let row = $(this);
            let isSedia = row.find('.switch-ketersediaan').is(':checked');
            let subtotal = parseFloat(row.find('.subtotal-cell').attr('data-subtotal')) || 0;

            if (isSedia) {
                totalBiaya += subtotal;
                row.find('.input-keterangan').prop('disabled', true).val(''); // Jika sedia, disable keterangan
                row.removeClass('bg-light text-muted');
            } else {
                row.find('.input-keterangan').prop('disabled', false); // Jika kosong, enable keterangan
                row.addClass('bg-light text-muted');
            }
        });
        $('#total-resep-text').text('Rp ' + totalBiaya.toLocaleString('id-ID'));
    }

    // EKSEKUSI PROSES PENJUALAN FARMASI
    $('#btn-proses-farmasi').off('click').on('click', function() {
        if (!currentRegistrasiId) return;

        // Kumpulkan data persediaan & keterangan dari tabel
        let orderProsesData = [];
        $('#tbody-detail-resep tr').each(function() {
            let row = $(this);
            let kodeObat = row.attr('data-kode');

            if (kodeObat) {
                orderProsesData.push({
                    kode_obat: kodeObat,
                    tersedia: row.find('.switch-ketersediaan').is(':checked') ? 1 : 0,
                    keterangan: row.find('.input-keterangan').val()
                });
            }
        });

        Swal.fire({
            title: 'Proses Farmasi',
            text: "Lanjutkan memproses obat yang tersedia ke faktur penjualan?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Proses Sekarang',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log("Data Order yang diproses: ", orderProsesData); // Lihat data di inspect element console

                // Di sini Anda bisa mengirim 'orderProsesData' ke Controller Kasir via AJAX
                // atau menyimpan ke session sebelum dilempar ke halaman Kasir Penjualan

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data kesediaan obat telah disimpan. Silakan lanjutkan ke transaksi kasir.'
                });
            }
        });
    });
</script>
@endsection
