@extends('layouts.layouts')
@section('base.css')

@endsection
@section('content')
<!-- Select2 CSS & Theme Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />


<div class="row g-3">
    <!-- FORM INPUT (KIRI) -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 sticky-top" style="top: 20px; z-index: 10;">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-tag-fill me-2"></i>Form Pembuatan Harga</h5>
            </div>
            <div class="card-body p-3">

                <form action="{{ route('price-setting.store') }}" method="POST" id="priceForm">
                    @csrf

                    <h6 class="text-primary fw-bold mb-3"><i class="bi bi-diagram-3 me-1"></i> 1. Hirarki Sales & Kategori</h6>

                    <!-- MASTER SALES -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="p_m_sales_code" class="form-label font-weight-bold mb-0">Master Sales <span class="text-danger">*</span></label>
                            <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalAddMasterSales">
                                <i class="bi bi-plus-lg me-1"></i>Tambah Master
                            </button>
                        </div>
                        <select class="form-select select2-search" id="p_m_sales_code" name="p_m_sales_code" required>
                            <option value="">-- Pilih Master --</option>
                            @foreach($masterSales as $ms)
                            <option value="{{ $ms->p_m_sales_code }}">{{ $ms->p_m_sales_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <!-- SUB SALES DENGAN TOMBOL TAMBAH DYNAMIC -->
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="p_sales_code" class="form-label font-weight-bold mb-0">Sub Sales <span class="text-danger">*</span></label>
                                <button type="button" class="btn btn-sm btn-outline-primary py-0 px-1 d-none" id="btnOpenModalSubSales" style="font-size: 0.75rem;">
                                    <i class="bi bi-plus-lg"></i> Tambah
                                </button>
                            </div>
                            <select class="form-select select2-search" id="p_sales_code" name="p_sales_code" disabled required>
                                <option value="">-- Pilih Sub Sales --</option>
                            </select>
                        </div>

                        <!-- KATEGORI SALES DENGAN TOMBOL TAMBAH DYNAMIC -->
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="p_sales_cat_code" class="form-label font-weight-bold mb-0">Kategori Sales <span class="text-danger">*</span></label>
                                <button type="button" class="btn btn-sm btn-outline-primary py-0 px-1 d-none" id="btnOpenModalSalesCat" style="font-size: 0.75rem;">
                                    <i class="bi bi-plus-lg"></i> Tambah
                                </button>
                            </div>
                            <select class="form-select select2-search" id="p_sales_cat_code" name="p_sales_cat_code" required disabled>
                                <option value="">-- Pilih Kategori --</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-3">
                    <h6 class="text-primary fw-bold mb-3"><i class="bi bi-card-checklist me-1"></i> 2. Detail Data Pemeriksaan & Harga</h6>

                    <!-- PILIH PEMERIKSAAN MASTER -->
                    <div class="mb-3">
                        <label for="t_pemeriksaan_list_code" class="form-label font-weight-bold">Pilih Pemeriksaan Master <span class="text-danger">*</span></label>
                        <select class="form-select select2-search" id="t_pemeriksaan_list_code" name="t_pemeriksaan_list_code" required>
                            <option value="" data-name="">-- Pilih Items Pemeriksaan Utama --</option>
                            @foreach($pemeriksaanList as $item)
                            <option value="{{ $item->t_pemeriksaan_list_code }}" data-name="{{ $item->t_pemeriksaan_list_name }}">
                                {{ $item->t_pemeriksaan_list_name }} ({{ $item->t_pemeriksaan_list_code }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-7">
                            <label for="p_sales_data_name" class="form-label font-weight-bold">Nama Sales Data / Label <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="p_sales_data_name" name="p_sales_data_name" placeholder="Otomatis terisi..." required>
                        </div>
                        <div class="col-md-5">
                            <label for="p_sales_data_type" class="form-label font-weight-bold">Tipe <span class="text-danger">*</span></label>
                            <select class="form-select" id="p_sales_data_type" name="p_sales_data_type" required>
                                <option value="">-- Pilih --</option>
                                <option value="Single">Single</option>
                                <option value="Package">Package / Paket</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="p_sales_data_price" class="form-label font-weight-bold">Harga (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control rupiah-input" id="p_sales_data_price" name="p_sales_data_price" placeholder="0" required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="p_sales_data_disc" class="form-label font-weight-bold">Diskon (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" class="form-control rupiah-input" id="p_sales_data_disc" name="p_sales_data_disc" value="0" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="p_sales_data_desc" class="form-label font-weight-bold">Keterangan / Deskripsi</label>
                        <textarea class="form-control" id="p_sales_data_desc" name="p_sales_data_desc" rows="2" placeholder="Catatan tambahan..."></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" id="btnReset" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </button>
                        <button type="submit" id="btnSubmit" class="btn btn-primary w-100">
                            <i class="bi bi-save me-1"></i> Simpan Harga
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- TABEL DATA HARGA (KANAN) -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-table me-2"></i>Daftar Harga Pemeriksaan</h5>
                <span class="badge bg-primary px-3 py-2 fs-6" id="totalBadge">Total: 0 Data</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-dark sticky-top" style="z-index: 5;">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th>Kode / Nama Data</th>
                                <th>Kategori & Layanan</th>
                                <th>Tipe</th>
                                <th class="text-end">Harga Nett</th>
                                <th width="15%" class="text-center">Aksi Paket</th>
                            </tr>
                        </thead>
                        <tbody id="tableSalesBody">
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                                    <em>Silakan pilih Sub Sales terlebih dahulu untuk menampilkan data harga.</em>
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

<!-- MODAL TAMBAH MASTER SALES -->
<div class="modal fade" id="modalAddMasterSales" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Master Sales Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAddMasterSales" action="{{ route('master-sales.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="new_p_m_sales_name" class="form-label fw-bold">Nama Master Sales <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="new_p_m_sales_name" name="p_m_sales_name" placeholder="Masukkan nama master sales..." required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveMasterSales">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH SUB SALES -->
<div class="modal fade" id="modalAddSubSales" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Sub Sales Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAddSubSales" action="{{ route('sub-sales.store') }}" method="POST">
                @csrf
                <input type="hidden" id="modal_p_m_sales_code_hidden" name="p_m_sales_code">

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="modal_p_m_sales_code" class="form-label fw-bold">Master Sales Terpilih</label>
                        <select class="form-select bg-light" id="modal_p_m_sales_code" disabled>
                            <option value="">-- Pilih Master --</option>
                            @foreach($masterSales as $ms)
                            <option value="{{ $ms->p_m_sales_code }}">{{ $ms->p_m_sales_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="new_p_sales_name" class="form-label fw-bold">Nama Sub Sales Baru <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="new_p_sales_name" name="p_sales_name" placeholder="Contoh: Klinik Medika B" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveSubSales">
                        <i class="bi bi-save me-1"></i> Simpan Sub Sales
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH KATEGORI SALES -->
<div class="modal fade" id="modalAddSalesCat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Kategori Sales Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAddSalesCat" action="{{ route('sales-cat.store') }}" method="POST">
                @csrf
                <input type="hidden" id="modal_p_sales_code_hidden" name="p_sales_code">

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="modal_p_sales_code_display" class="form-label fw-bold">Sub Sales Terpilih</label>
                        <input type="text" class="form-control bg-light" id="modal_p_sales_code_display" readonly>
                    </div>

                    <!-- DROPDOWN KATEGORI LAYANAN (DARI TABLE t_layanan_cat) -->
                    <div class="mb-3">
                        <label for="t_layanan_cat_code_modal" class="form-label fw-bold">Kategori Layanan <span class="text-danger">*</span></label>
                        <select class="form-select select2-modal" id="t_layanan_cat_code_modal" name="t_layanan_cat_code" required>
                            <option value="">-- Pilih Kategori Layanan --</option>
                            @foreach($layananCategories as $layanan)
                            <option value="{{ $layanan->t_layanan_cat_code }}">{{ $layanan->t_layanan_cat_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="new_p_sales_cat_name" class="form-label fw-bold">Nama Kategori Sales Baru <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="new_p_sales_cat_name" name="p_sales_cat_name" placeholder="Contoh: MCU Standard / Umum" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveSalesCat">
                        <i class="bi bi-save me-1"></i> Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PILIH ITEM PEMERIKSAAN UNTUK PAKET -->
<div class="modal fade" id="modalPackageItems" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold" id="modalPackageItemsLabel">
                    <i class="bi bi-box-seam me-2"></i>Pilih Detail Items Pemeriksaan Paket
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-warning py-2 mb-3">
                    <strong class="d-block">Paket: <span id="modalPackageTitle" class="text-primary"></span></strong>
                    <small class="text-muted">Centang pemeriksaan yang termasuk ke dalam daftar paket ini.</small>
                </div>

                <div class="row g-2" id="packageCheckboxList">
                    @foreach($pemeriksaanList as $p)
                    <div class="col-md-6">
                        <div class="form-check border p-2 rounded bg-white h-100 d-flex align-items-center ms-0">
                            <input class="form-check-input package-item-check ms-1 me-2" type="checkbox" value="{{ $p->t_pemeriksaan_list_code }}" id="check_{{ $p->t_pemeriksaan_list_code }}">
                            <label class="form-check-label w-100 cursor-pointer" for="check_{{ $p->t_pemeriksaan_list_code }}">
                                <strong>{{ $p->t_pemeriksaan_list_name }}</strong><br>
                                <small class="text-muted">Code: {{ $p->t_pemeriksaan_list_code }}</small>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSavePackageItems">
                    <i class="bi bi-check-circle me-1"></i> Simpan Items Paket
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // --- INISIALISASI SELECT2 UNTUK DROPDOWN SEARCHABLE ---
        $('.select2-search').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: function() {
                $(this).data('placeholder');
            }
        });

        const masterSelect = $('#p_m_sales_code');
        const subSelect = $('#p_sales_code');
        const catSelect = $('#p_sales_cat_code');

        const btnOpenModalSubSales = $('#btnOpenModalSubSales');
        const btnOpenModalSalesCat = $('#btnOpenModalSalesCat');

        const pemeriksaanSelect = $('#t_pemeriksaan_list_code');
        const salesDataNameInput = $('#p_sales_data_name');
        const tableBody = $('#tableSalesBody');
        const totalBadge = $('#totalBadge');
        const btnReset = $('#btnReset');
        const priceForm = $('#priceForm');
        const btnSubmit = $('#btnSubmit');

        const csrfToken = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';

        let selectedPackageCode = '';

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(number);
        }

        // Filter & Reload Tabel AJAX
        function filterTableData() {
            const subSales = subSelect.val();
            const catSales = catSelect.val();

            if (!subSales) {
                tableBody.html(`
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                            <em>Silakan pilih Sub Sales terlebih dahulu untuk menampilkan data harga.</em>
                        </td>
                    </tr>`);
                totalBadge.text(`Total: 0 Data`);
                return;
            }

            const url = `/get-sales-data-filter?p_sales_code=${subSales}&p_sales_cat_code=${catSales || ''}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    tableBody.empty();
                    totalBadge.text(`Total: ${data.length} Data`);

                    if (data.length === 0) {
                        tableBody.html(`
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    Tidak ada data harga pemeriksaan pada Sub Sales / Kategori ini.
                                </td>
                            </tr>`);
                        return;
                    }

                    data.forEach((row, index) => {
                        const price = parseFloat(row.p_sales_data_price) || 0;
                        const disc = parseFloat(row.p_sales_data_disc) || 0;
                        const nett = price - disc;

                        const layananName = row.t_layanan_cat_name ?
                            `<span class="badge bg-success mt-1"><i class="bi bi-hospital me-1"></i>${row.t_layanan_cat_name}</span>` :
                            '';

                        let packageItemsHtml = '';
                        if (row.p_sales_data_type === 'Package') {
                            if (row.package_items && row.package_items.length > 0) {
                                packageItemsHtml = '<div class="mt-2 p-2 bg-light rounded border"><small class="text-dark fw-bold d-block mb-1"><i class="bi bi-list-check me-1"></i>Isi Paket:</small>';
                                row.package_items.forEach(sub => {
                                    packageItemsHtml += `<span class="badge bg-secondary text-white package-item-badge"><i class="bi bi-check2 me-1"></i>${sub.p_sales_data_sub_name}</span> `;
                                });
                                packageItemsHtml += '</div>';
                            } else {
                                packageItemsHtml = '<div class="mt-1"><small class="text-danger fst-italic"><i class="bi bi-exclamation-circle me-1"></i>Belum ada item paket dipilih</small></div>';
                            }
                        }

                        let actionBtn = '<span class="text-muted small">-</span>';
                        if (row.p_sales_data_type === 'Package') {
                            actionBtn = `<button type="button" class="btn btn-sm btn-warning text-dark fw-bold btn-open-package w-100"
                                            data-code="${row.p_sales_data_code}"
                                            data-name="${row.p_sales_data_name}">
                                            <i class="bi bi-box-seam me-1"></i> Items
                                         </button>`;
                        }

                        const tr = `
                            <tr>
                                <td class="text-center fw-bold">${index + 1}</td>
                                <td>
                                    <code>${row.p_sales_data_code}</code><br>
                                    <strong>${row.p_sales_data_name}</strong>
                                    ${packageItemsHtml}
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark d-block mb-1">${row.p_sales_cat_name ?? row.p_sales_cat_code}</span>
                                    ${layananName}
                                </td>
                                <td>
                                    <span class="badge ${row.p_sales_data_type === 'Package' ? 'bg-warning text-dark' : 'bg-secondary'}">
                                        ${row.p_sales_data_type}
                                    </span>
                                </td>
                                <td class="text-end fw-bold text-success">
                                    ${formatRupiah(nett)}
                                    ${disc > 0 ? `<br><small class="text-decoration-line-through text-muted fw-normal">${formatRupiah(price)}</small>` : ''}
                                </td>
                                <td class="text-center">${actionBtn}</td>
                            </tr>`;
                        tableBody.append(tr);
                    });
                })
                .catch(err => {
                    console.error('Error fetching table filter:', err);
                    tableBody.html(`<tr><td colspan="6" class="text-center text-danger py-3">Gagal memuat data dari server.</td></tr>`);
                });
        }

        // EVENT CHANGED PEMERIKSAAN
        pemeriksaanSelect.on('change', function() {
            const selectedOption = $(this).find('option:selected');
            const name = selectedOption.data('name');
            if (name) salesDataNameInput.val(name);
        });

        // EVENT CHANGED MASTER SALES
        masterSelect.on('change', function() {
            const mSalesCode = $(this).val();

            subSelect.html('<option value="">-- Pilih Sub Sales --</option>').prop('disabled', true).trigger('change.select2');
            catSelect.html('<option value="">-- Pilih Kategori --</option>').prop('disabled', true).trigger('change.select2');

            btnOpenModalSubSales.addClass('d-none');
            btnOpenModalSalesCat.addClass('d-none');

            if (mSalesCode) {
                btnOpenModalSubSales.removeClass('d-none');
            }

            filterTableData();

            if (mSalesCode) {
                fetch(`/get-sub-sales/${mSalesCode}`)
                    .then(response => response.json())
                    .then(data => {
                        subSelect.prop('disabled', false);
                        data.forEach(item => {
                            subSelect.append(new Option(`${item.p_sales_name} (${item.p_sales_code})`, item.p_sales_code, false, false));
                        });
                        subSelect.trigger('change.select2');
                    })
                    .catch(err => console.error('Error loading sub sales:', err));
            }
        });

        // EVENT CHANGED SUB SALES
        subSelect.on('change', function() {
            const salesCode = $(this).val();

            catSelect.html('<option value="">-- Pilih Kategori --</option>').prop('disabled', true).trigger('change.select2');
            btnOpenModalSalesCat.addClass('d-none');

            if (salesCode) {
                btnOpenModalSalesCat.removeClass('d-none');

                fetch(`/get-sales-cat/${salesCode}`)
                    .then(response => response.json())
                    .then(data => {
                        catSelect.prop('disabled', false);
                        data.forEach(item => {
                            catSelect.append(new Option(`${item.t_layanan_cat_name} - ${item.p_sales_cat_name}`, item.p_sales_cat_code, false, false));
                        });
                        catSelect.trigger('change.select2');
                    })
                    .catch(err => console.error('Error loading sales cat:', err));
            }

            filterTableData();
        });

        // EVENT CHANGED KATEGORI SALES
        catSelect.on('change', function() {
            filterTableData();
        });

        // BUKA MODAL SUB SALES
        btnOpenModalSubSales.on('click', function() {
            const currentMaster = masterSelect.val();
            if (!currentMaster) {
                alert('Silakan pilih Master Sales terlebih dahulu!');
                return;
            }

            $('#modal_p_m_sales_code').val(currentMaster);
            $('#modal_p_m_sales_code_hidden').val(currentMaster);

            const modal = new bootstrap.Modal(document.getElementById('modalAddSubSales'));
            modal.show();
        });

        // BUKA MODAL KATEGORI SALES
        btnOpenModalSalesCat.on('click', function() {
            const currentSubCode = subSelect.val();
            const currentSubText = subSelect.find('option:selected').text();

            if (!currentSubCode) {
                alert('Silakan pilih Sub Sales terlebih dahulu!');
                return;
            }

            $('#modal_p_sales_code_display').val(currentSubText);
            $('#modal_p_sales_code_hidden').val(currentSubCode);

            const modal = new bootstrap.Modal(document.getElementById('modalAddSalesCat'));
            modal.show();
        });

        // HANDLER SIMPAN MASTER SALES
        $('#formAddMasterSales').on('submit', function(e) {
            e.preventDefault();
            const btn = $('#btnSaveMasterSales');
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

            fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        alert("Gagal menambahkan Master Sales.");
                    } else {
                        alert(data.message);

                        const newOpt = new Option(data.data.p_m_sales_name, data.data.p_m_sales_code, true, true);
                        masterSelect.append(newOpt).trigger('change');

                        $('#modal_p_m_sales_code').append(new Option(data.data.p_m_sales_name, data.data.p_m_sales_code));

                        this.reset();
                        bootstrap.Modal.getInstance(document.getElementById('modalAddMasterSales')).hide();
                    }
                })
                .catch(err => console.error(err))
                .finally(() => {
                    btn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Simpan');
                });
        });

        // HANDLER SIMPAN SUB SALES
        $('#formAddSubSales').on('submit', function(e) {
            e.preventDefault();
            const btn = $('#btnSaveSubSales');
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

            fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        alert("Gagal menambahkan Sub Sales.");
                    } else {
                        alert(data.message);

                        subSelect.prop('disabled', false);
                        const newOpt = new Option(`${data.data.p_sales_name} (${data.data.p_sales_code})`, data.data.p_sales_code, true, true);
                        subSelect.append(newOpt).trigger('change');

                        $('#new_p_sales_name').val('');
                        bootstrap.Modal.getInstance(document.getElementById('modalAddSubSales')).hide();
                    }
                })
                .catch(err => console.error(err))
                .finally(() => {
                    btn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Simpan Sub Sales');
                });
        });

        // HANDLER SIMPAN KATEGORI SALES
        $('#formAddSalesCat').on('submit', function(e) {
            e.preventDefault();
            const btn = $('#btnSaveSalesCat');
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

            fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        alert("Gagal menambahkan Kategori Sales.");
                    } else {
                        alert(data.message);

                        catSelect.prop('disabled', false);
                        const newOpt = new Option(`${data.data.p_sales_cat_name} (${data.data.p_sales_cat_code})`, data.data.p_sales_cat_code, true, true);
                        catSelect.append(newOpt).trigger('change');

                        $('#new_p_sales_cat_name').val('');
                        bootstrap.Modal.getInstance(document.getElementById('modalAddSalesCat')).hide();
                    }
                })
                .catch(err => console.error(err))
                .finally(() => {
                    btn.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Simpan Kategori');
                });
        });


        // --- FUNGSI FORMATTER RUPIAH PADA INPUT ---
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

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        // Event listener saat user mengetik di input harga / diskon
        $(document).on('keyup change', '.rupiah-input', function() {
            let val = $(this).val();
            $(this).val(formatRupiahInput(val));
        });
        // --- UPDATE HANDLER FORM SUBMIT ---
        priceForm.on('submit', function(e) {
            e.preventDefault();

            btnSubmit.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

            // Buat FormData dari form
            let formData = new FormData(this);

            // Hapus titik separator sebelum dikirim ke backend
            let rawPrice = $('#p_sales_data_price').val().replace(/\./g, '');
            let rawDisc = $('#p_sales_data_disc').val().replace(/\./g, '');

            formData.set('p_sales_data_price', rawPrice);
            formData.set('p_sales_data_disc', rawDisc || '0');

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        if (response.status === 422) {
                            let errMsgs = [];
                            Object.values(data.errors).forEach(err => errMsgs.push(err.join('\n')));
                            alert("Gagal menyimpan:\n" + errMsgs.join('\n'));
                        } else {
                            alert("Terjadi kesalahan pada server.");
                        }
                    } else {
                        alert(data.message);

                        pemeriksaanSelect.val('').trigger('change.select2');
                        $('#p_sales_data_name').val('');
                        $('#p_sales_data_type').val('');
                        $('#p_sales_data_price').val('');
                        $('#p_sales_data_disc').val('0');
                        $('#p_sales_data_desc').val('');

                        filterTableData();
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Terjadi kesalahan saat menyimpan data.');
                })
                .finally(() => {
                    btnSubmit.prop('disabled', false).html('<i class="bi bi-save me-1"></i> Simpan Harga');
                });
        });

        // BUKA MODAL PILIH ITEM PAKET
        $(document).on('click', '.btn-open-package', function() {
            selectedPackageCode = $(this).data('code');
            const name = $(this).data('name');

            $('#modalPackageTitle').text(`${name} (${selectedPackageCode})`);
            $('.package-item-check').prop('checked', false);

            fetch(`/get-package-items/${selectedPackageCode}`)
                .then(response => response.json())
                .then(savedCodes => {
                    savedCodes.forEach(code => {
                        $(`#check_${code}`).prop('checked', true);
                    });

                    const modal = new bootstrap.Modal(document.getElementById('modalPackageItems'));
                    modal.show();
                })
                .catch(err => {
                    console.error('Error fetching package items:', err);
                    alert('Gagal memuat detail item paket.');
                });
        });

        // SIMPAN ITEM PAKET
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

            fetch("{{ route('price-setting.save-package-items') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        p_sales_data_code: selectedPackageCode,
                        items: selectedItems
                    })
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        if (response.status === 422) {
                            let errMsgs = [];
                            Object.values(data.errors).forEach(err => errMsgs.push(err.join('\n')));
                            alert("Gagal menyimpan:\n" + errMsgs.join('\n'));
                        } else {
                            alert(data.message || "Terjadi kesalahan pada server.");
                        }
                    } else {
                        alert(data.message);

                        const modalEl = document.getElementById('modalPackageItems');
                        const modal = bootstrap.Modal.getInstance(modalEl);
                        modal.hide();

                        filterTableData();
                    }
                })
                .catch(err => {
                    console.error('Error saving package items:', err);
                    alert('Terjadi kesalahan saat menyimpan detail paket.');
                })
                .finally(() => {
                    btnSave.prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i> Simpan Items Paket');
                });
        });

        // RESET FORM
        btnReset.on('click', function() {
            priceForm[0].reset();
            masterSelect.val('').trigger('change.select2');
            subSelect.html('<option value="">-- Pilih Sub Sales --</option>').prop('disabled', true).trigger('change.select2');
            catSelect.html('<option value="">-- Pilih Kategori --</option>').prop('disabled', true).trigger('change.select2');
            pemeriksaanSelect.val('').trigger('change.select2');
            btnOpenModalSubSales.addClass('d-none');
            btnOpenModalSalesCat.addClass('d-none');
            filterTableData();
        });
    });
</script>
@endsection
