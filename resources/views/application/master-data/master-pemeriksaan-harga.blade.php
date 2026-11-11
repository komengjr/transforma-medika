@extends('layouts.layouts')
@section('base.css')
<!-- Select2 CSS & Theme Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

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

    .retro-btn-danger {
        background-color: var(--retro-pink);
        color: var(--retro-dark);
    }

    /* Inputs, Selects & Textareas */
    .retro-input,
    .form-control,
    .form-select {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
    }

    .retro-input:focus,
    .form-control:focus,
    .form-select:focus {
        border-color: var(--retro-dark) !important;
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
        outline: none;
    }

    /* Select2 Customization for Retro Theme */
    .select2-container--bootstrap-5 .select2-selection {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
        background-color: #fff;
    }

    .select2-container--bootstrap-5 .select2-dropdown {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: var(--retro-shadow-sm);
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

    .table tbody tr {
        border-bottom: 2px solid var(--retro-dark);
        transition: background 0.2s;
    }

    .table tbody tr:hover {
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
                        <i class="bi bi-tag-fill fs-3 text-dark"></i>
                    </div>
                    <div>
                        <h6 class="fs--1 mb-0 fw-bold" style="color: rgba(30, 30, 36, 0.7);">MANAJEMEN KEUANGAN & TARIF</h6>
                        <h3 class="fw-bolder mb-0" style="color: var(--retro-dark); text-shadow: 1px 1px 0px white;">SETTING TARIF & <span class="fw-normal">DISKON PENJAMIN</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- FORM INPUT (KIRI) -->
    <div class="col-lg-4">
        <div class="retro-card sticky-top" style="top: 20px; z-index: 10;">
            <div class="card-header py-3 px-4" style="background-color: var(--retro-yellow); border-bottom: 3px solid var(--retro-dark);">
                <h5 class="mb-0 fw-bolder text-dark"><i class="bi bi-tag-fill me-2"></i>Setting Tarif & Diskon</h5>
            </div>
            <div class="card-body p-4" style="background-color: #ffffff;">

                <form action="{{ route('penjamin-price.store') }}" method="POST" id="priceForm">
                    @csrf

                    <h6 class="fw-bolder mb-3 pb-2 border-bottom border-dark text-dark"><i class="bi bi-diagram-3 me-1"></i> 1. Hirarki Penjamin</h6>

                    <!-- PENJAMIN UTAMA -->
                    <div class="mb-3">
                        <label for="penjamin_id" class="form-label fw-bolder text-dark mb-1">Penjamin Utama <span class="text-danger">*</span></label>
                        <select class="form-select select2-search" id="penjamin_id" name="penjamin_id" required>
                            <option value="">-- Pilih Penjamin Utama --</option>
                            @foreach($penjaminList as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_penjamin }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- SUB PENJAMIN -->
                    <div class="mb-3">
                        <label for="sub_penjamin_id" class="form-label fw-bolder text-dark mb-1">Sub Penjamin <span class="text-danger">*</span></label>
                        <select class="form-select select2-search" id="sub_penjamin_id" name="sub_penjamin_id" disabled required>
                            <option value="">-- Pilih Sub Penjamin --</option>
                        </select>
                    </div>

                    <h6 class="fw-bolder mb-3 pt-2 pb-2 border-bottom border-dark text-dark"><i class="bi bi-card-checklist me-1"></i> 2. Master Pemeriksaan & Diskon</h6>

                    <!-- PILIH MASTER PEMERIKSAAN -->
                    <div class="mb-3">
                        <label for="master_pemeriksaan_id" class="form-label fw-bolder text-dark">Pilih Pemeriksaan <span class="text-danger">*</span></label>
                        <select class="form-select select2-search" id="master_pemeriksaan_id" name="master_pemeriksaan_id" required>
                            <option value="" data-harga="0">-- Pilih Pemeriksaan --</option>
                            @foreach($pemeriksaanList as $item)
                            <option value="{{ $item->id }}" data-harga="{{ $item->harga }}" data-paket="{{ $item->is_paket }}">
                                {{ $item->nama_layanan }} ({{ $item->kode_layanan }}) - Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- INFO HARGA DASAR -->
                    <div class="mb-3 p-3 rounded" style="background-color: var(--retro-cyan); border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                        <small class="text-dark fw-bold d-block">Harga Dasar Master:</small>
                        <strong class="text-dark fs-5" id="lblHargaDasar">Rp 0</strong>
                    </div>

                    <!-- DISKON -->
                    <div class="mb-4">
                        <label for="diskon" class="form-label fw-bolder text-dark">Diskon / Potongan Harga (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text fw-bold text-dark" style="border: 2px solid var(--retro-dark); border-right: none; background-color: var(--retro-bg);">Rp</span>
                            <input type="text" class="form-control rupiah-input" id="diskon" name="diskon" value="0" autocomplete="off">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" id="btnReset" class="btn retro-btn retro-btn-light">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </button>
                        <button type="submit" id="btnSubmit" class="btn retro-btn retro-btn-primary w-100">
                            <i class="bi bi-save me-1"></i> Simpan Pengaturan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- TABEL DATA HARGA PENJAMIN (KANAN) -->
    <div class="col-lg-8">
        <div class="retro-card">
            <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: var(--retro-dark);">
                <h5 class="mb-0 fw-bolder text-white" style="color: var(--retro-green) !important;"><i class="bi bi-table me-2"></i>Daftar Tarif & Diskon Penjamin</h5>
                <span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark);" id="totalBadge">Total: 0 Data</span>
            </div>

            <div class="card-body p-3 border-bottom border-dark" style="background-color: #fff;">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <label class="form-label fw-bolder text-dark small mb-1">FILTER BERDASARKAN TIPE LAYANAN:</label>
                        <select id="filter_tipe_layanan" class="form-select form-select-sm retro-input">
                            <option value="">-- Semua Tipe Layanan --</option>
                            @foreach($tipeLayananList as $tl)
                            <option value="{{ $tl->id }}">{{ $tl->nama_tipe }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body p-0" style="background-color: #ffffff;">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 fw-bold" style="border: 2px solid var(--retro-dark);">
                        <thead class="retro-table-header">
                            <tr>
                                <th width="5%" class="text-center py-3">No</th>
                                <th class="py-3">Kode / Nama Pemeriksaan</th>
                                <th class="py-3">Tipe Layanan</th>
                                <th class="py-3">Harga Dasar & Diskon</th>
                                <th class="text-end py-3">Tarif Nett</th>
                                <th width="22%" class="text-center py-3">Aksi / Paket</th>
                            </tr>
                        </thead>
                        <tbody id="tablePenjaminBody" style="color: var(--retro-dark);">
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted fw-bold">
                                    <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                                    <em>Silakan pilih Sub Penjamin terlebih dahulu untuk menampilkan data tarif.</em>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- MODAL PILIH ITEM PEMERIKSAAN UNTUK PAKET -->
<div class="modal fade" id="modalPackageItems" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content retro-modal-content">
            <div class="modal-header py-3 px-4" style="background-color: var(--retro-yellow); border-bottom: 3px solid var(--retro-dark); color: var(--retro-dark);">
                <h5 class="modal-title fw-bolder" id="modalPackageItemsLabel">
                    <i class="bi bi-box-seam me-2"></i>Pilih Detail Item Pemeriksaan Paket
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0); border: 2px solid #1e1e24; border-radius: 50%; padding: 5px; box-shadow: 2px 2px 0px #1e1e24;"></button>
            </div>
            <div class="modal-body p-4" style="background-color: var(--retro-bg);">
                <div class="alert mb-3" style="background-color: var(--retro-cyan); border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark); color: var(--retro-dark);">
                    <strong class="d-block">Paket: <span id="modalPackageTitle"></span></strong>
                    <small class="fw-bold">Centang pemeriksaan master yang termasuk ke dalam paket ini.</small>
                </div>

                <div class="row g-2" id="packageCheckboxList">
                    @foreach($pemeriksaanList as $p)
                    <div class="col-md-6">
                        <div class="form-check border border-dark p-2 rounded bg-white h-100 d-flex align-items-center ms-0 shadow-sm">
                            <input class="form-check-input package-item-check ms-1 me-2" type="checkbox" value="{{ $p->id }}" id="check_{{ $p->id }}" style="border: 2px solid var(--retro-dark);">
                            <label class="form-check-label w-100 cursor-pointer text-dark fw-bold" for="check_{{ $p->id }}">
                                <span>{{ $p->nama_layanan }}</span><br>
                                <small class="text-muted">Kode: {{ $p->kode_layanan }}</small>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer bg-white border-top border-dark">
                <button type="button" class="btn retro-btn retro-btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn retro-btn retro-btn-primary" id="btnSavePackageItems">
                    <i class="bi bi-check-circle me-1"></i> Simpan Item Paket
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2-search').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });

        const penjaminSelect = $('#penjamin_id');
        const subPenjaminSelect = $('#sub_penjamin_id');
        const tipeLayananFilter = $('#filter_tipe_layanan');
        const masterPemeriksaanSelect = $('#master_pemeriksaan_id');
        const lblHargaDasar = $('#lblHargaDasar');
        const diskonInput = $('#diskon');

        const tableBody = $('#tablePenjaminBody');
        const totalBadge = $('#totalBadge');
        const btnReset = $('#btnReset');
        const priceForm = $('#priceForm');
        const btnSubmit = $('#btnSubmit');
        const csrfToken = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';

        let selectedPackageMasterId = '';

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(number);
        }

        function formatRupiahInput(angka) {
            let number_string = angka.replace(/[^,\d]/g, '').toString();
            let split = number_string.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        }

        $(document).on('keyup change', '.rupiah-input', function() {
            let val = $(this).val();
            $(this).val(formatRupiahInput(val));
        });

        // Load Sub Penjamin
        penjaminSelect.on('change', function() {
            const penjaminId = $(this).val();
            subPenjaminSelect.html('<option value="">-- Pilih Sub Penjamin --</option>').prop('disabled', true).trigger('change.select2');

            if (penjaminId) {
                fetch(`/master-data/get-sub-penjamin/${penjaminId}`)
                    .then(res => res.json())
                    .then(data => {
                        subPenjaminSelect.prop('disabled', false);
                        data.forEach(item => {
                            subPenjaminSelect.append(new Option(item.nama_sub_penjamin, item.id, false, false));
                        });
                        subPenjaminSelect.trigger('change.select2');
                    })
                    .catch(err => console.error('Error sub penjamin:', err));
            }
            filterTableData();
        });

        subPenjaminSelect.on('change', function() {
            filterTableData();
        });

        tipeLayananFilter.on('change', function() {
            filterTableData();
        });

        masterPemeriksaanSelect.on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const harga = parseFloat(selectedOption.data('harga')) || 0;
            lblHargaDasar.text(formatRupiah(harga));
        });

        // Filter & Reload Tabel AJAX
        function filterTableData() {
            const subPenjaminId = subPenjaminSelect.val();
            const tipeLayananId = tipeLayananFilter.val();

            if (!subPenjaminId) {
                tableBody.html(`
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted fw-bold">
                            <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                            <em>Silakan pilih Sub Penjamin terlebih dahulu untuk menampilkan data tarif.</em>
                        </td>
                    </tr>`);
                totalBadge.text(`Total: 0 Data`);
                return;
            }

            const url = `/master-data/get-penjamin-pemeriksaan-filter?sub_penjamin_id=${subPenjaminId}&tipe_layanan_id=${tipeLayananId || ''}`;

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    tableBody.empty();
                    totalBadge.text(`Total: ${data.length} Data`);

                    if (data.length === 0) {
                        tableBody.html(`
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted fw-bold">
                                    Tidak ada data tarif/diskon pemeriksaan untuk Sub Penjamin ini.
                                </td>
                            </tr>`);
                        return;
                    }

                    data.forEach((row, index) => {
                        const hargaDasar = parseFloat(row.harga_dasar) || 0;
                        const diskon = parseFloat(row.diskon) || 0;
                        const nett = hargaDasar - diskon;

                        let packageItemsHtml = '';
                        if (row.is_paket == 1) {
                            if (row.package_items && row.package_items.length > 0) {
                                packageItemsHtml = '<div class="mt-2 p-2 bg-light rounded border border-dark"><small class="text-dark fw-bold d-block mb-1"><i class="bi bi-list-check me-1"></i>Isi Paket:</small>';
                                row.package_items.forEach(sub => {
                                    packageItemsHtml += `<span class="retro-badge" style="background-color: var(--retro-purple); color: var(--retro-dark); font-size: 0.7rem; margin-right: 2px; margin-bottom: 2px;">${sub.nama_layanan} (${sub.kode_layanan})</span>`;
                                });
                                packageItemsHtml += '</div>';
                            } else {
                                packageItemsHtml = '<div class="mt-1"><small class="text-danger fw-bold fst-italic"><i class="bi bi-exclamation-circle me-1"></i>Belum ada item paket dipilih</small></div>';
                            }
                        }

                        // Tombol Aksi Paket & Edit Diskon
                        let actionHtml = '';
                        if (row.is_paket == 1) {
                            actionHtml += `<button type="button" class="btn btn-sm retro-btn retro-btn-warning btn-open-package w-100 mb-1"
                                            data-id="${row.master_pemeriksaan_id}"
                                            data-name="${row.nama_layanan}" style="box-shadow: 2px 2px 0px var(--retro-dark); font-size: 0.75rem;">
                                            <i class="bi bi-box-seam me-1"></i> Items Paket
                                         </button>`;
                        }

                        actionHtml += `<button type="button" class="btn btn-sm retro-btn retro-btn-primary btn-edit-harga w-100"
                                        data-id="${row.master_pemeriksaan_id}"
                                        data-harga="${hargaDasar}"
                                        data-diskon="${diskon}" style="box-shadow: 2px 2px 0px var(--retro-dark); font-size: 0.75rem;">
                                        <i class="bi bi-pencil-square me-1"></i> Edit Diskon
                                     </button>`;

                        const tr = `
                            <tr>
                                <td class="text-center fw-bold">${index + 1}</td>
                                <td>
                                    <code class="fw-bold text-dark bg-light px-1 border border-dark rounded">${row.kode_layanan}</code><br>
                                    <strong class="text-uppercase">${row.nama_layanan}</strong>
                                    ${packageItemsHtml}
                                </td>
                                <td>
                                    <span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark);">${row.nama_tipe}</span>
                                </td>
                                <td>
                                    Base: ${formatRupiah(hargaDasar)}
                                    ${diskon > 0 ? `<br><small class="text-danger fw-bold">Disc: -${formatRupiah(diskon)}</small>` : ''}
                                </td>
                                <td class="text-end fw-bold" style="color: #198754; font-size: 1.05rem;">
                                    ${formatRupiah(nett)}
                                </td>
                                <td class="text-center">${actionHtml}</td>
                            </tr>`;
                        tableBody.append(tr);
                    });
                })
                .catch(err => {
                    console.error('Error fetching table:', err);
                    tableBody.html(`<tr><td colspan="6" class="text-center text-danger fw-bold py-3">Gagal memuat data dari server.</td></tr>`);
                });
        }

        // Simpan / Update Harga Penjamin
        priceForm.on('submit', function(e) {
            e.preventDefault();
            btnSubmit.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

            let formData = new FormData(this);
            let rawDiskon = diskonInput.val().replace(/\./g, '');
            formData.set('diskon', rawDiskon || '0');

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) {
                        alert("Gagal menyimpan data.");
                    } else {
                        alert(data.message);
                        masterPemeriksaanSelect.val('').trigger('change.select2');
                        lblHargaDasar.text('Rp 0');
                        diskonInput.val('0');
                        filterTableData();
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Terjadi kesalahan saat menyimpan data.');
                })
                .finally(() => {
                    btnSubmit.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Simpan Pengaturan');
                });
        });

        // Modal Pilih Item Paket
        $(document).on('click', '.btn-open-package', function() {
            selectedPackageMasterId = $(this).data('id');
            const name = $(this).data('name');

            $('#modalPackageTitle').text(name);
            $('.package-item-check').prop('checked', false);

            fetch(`/master-data/get-package-items/${selectedPackageMasterId}`)
                .then(res => res.json())
                .then(savedIds => {
                    savedIds.forEach(id => {
                        $(`#check_${id}`).prop('checked', true);
                    });
                    const modal = new bootstrap.Modal(document.getElementById('modalPackageItems'));
                    modal.show();
                })
                .catch(err => console.error('Error package items:', err));
        });

        // Simpan Item Paket
        $('#btnSavePackageItems').on('click', function() {
            const selectedItems = [];
            $('.package-item-check:checked').each(function() {
                selectedItems.push($(this).val());
            });

            if (selectedItems.length === 0) {
                alert('Pilih minimal 1 pemeriksaan untuk paket ini!');
                return;
            }

            const btnSave = $(this);
            btnSave.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

            fetch("{{ route('penjamin-price.save-package-items') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        master_pemeriksaan_id: selectedPackageMasterId,
                        items: selectedItems
                    })
                })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) {
                        alert("Gagal menyimpan item paket.");
                    } else {
                        alert(data.message);
                        bootstrap.Modal.getInstance(document.getElementById('modalPackageItems')).hide();
                        filterTableData();
                    }
                })
                .catch(err => console.error(err))
                .finally(() => {
                    btnSave.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i> Simpan Item Paket');
                });
        });

        btnReset.on('click', function() {
            priceForm[0].reset();
            penjaminSelect.val('').trigger('change.select2');
            subPenjaminSelect.html('<option value="">-- Pilih Sub Penjamin --</option>').prop('disabled', true).trigger('change.select2');
            masterPemeriksaanSelect.val('').trigger('change.select2');
            lblHargaDasar.text('Rp 0');
            filterTableData();
        });

        // EVENT KETIKA TOMBOL EDIT DISKON DIKLIK
        $(document).on('click', '.btn-edit-harga', function() {
            const masterId = $(this).data('id');
            const hargaDasar = parseFloat($(this).data('harga')) || 0;
            const diskon = parseFloat($(this).data('diskon')) || 0;

            masterPemeriksaanSelect.val(masterId).trigger('change.select2');
            lblHargaDasar.text(formatRupiah(hargaDasar));
            diskonInput.val(formatRupiahInput(diskon.toString())).focus();

            $('html, body').animate({
                scrollTop: $('#priceForm').offset().top - 100
            }, 300);
        });
    });
</script>
@endsection
