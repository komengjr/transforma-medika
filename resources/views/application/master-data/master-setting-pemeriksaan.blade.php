@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
    }

    .hero-header {
        background: var(--primary-gradient);
        border-radius: 12px;
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.2);
    }

    .table-custom {
        border-collapse: separate;
        border-spacing: 0 4px;
        font-size: 0.8rem;
    }

    .table-custom thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 8px 12px;
        border: none;
        text-transform: uppercase;
    }

    .table-custom tbody tr {
        background: #ffffff;
        transition: all 0.2s ease;
    }

    .table-custom tbody tr:hover {
        background-color: #f1f5f9 !important;
    }

    .table-custom td {
        padding: 8px 12px;
        vertical-align: middle;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
    }

    .table-custom td:first-child {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        border-left: 1px solid #f1f5f9;
    }

    .table-custom td:last-child {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        border-right: 1px solid #f1f5f9;
    }

    .param-row {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        transition: all 0.2s ease;
    }

    .param-row.has-child {
        border-left: 4px solid #3b82f6;
        background: #f0f9ff;
    }

    .child-row {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }

    .custom-loader {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 30px 0;
    }
</style>
@endsection

@section('content')
<!-- HERO HEADER -->
<div class="row mb-3">
    <div class="col-12">
        <div class="hero-header p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="badge bg-white bg-opacity-20 text-white fw-semibold px-2 py-1 mb-1 rounded-pill" style="font-size: 0.68rem;">
                        <i class="fas fa-microscope me-1"></i> MASTER PARAMETER LAB
                    </span>
                    <h4 class="fw-bold mb-0 text-white" style="font-size: 1.2rem;">Setting Parameter Nilai Pemeriksaan</h4>
                    <p class="text-white-50 mb-0 small" style="font-size: 0.72rem;">Kelola rujukan, satuan, metode, perkalian, param, instrumen alat, dan sub-parameter.</p>
                </div>
                <div class="d-none d-md-block text-end">
                    <span class="badge bg-white bg-opacity-10 text-white border border-white-50 px-3 py-2 rounded-3" style="font-size: 0.75rem;">
                        <i class="fas fa-calendar-alt me-1 text-warning"></i> {{ date('d M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN DATA TABLE CARD -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="table-pemeriksaan" class="table table-custom align-middle w-100">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="18%">Kode Pemeriksaan</th>
                        <th width="35%">Nama Pemeriksaan</th>
                        <th width="15%">Tipe</th>
                        <th width="15%">Status Parameter</th>
                        <th width="12%" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL SETTING PARAMETER -->
<div class="modal fade" id="modal-setting-param" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen p-3" style="max-width: 100%;">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom py-2 px-3 bg-light rounded-top-4">
                <div>
                    <h6 class="modal-title fw-bold text-dark mb-0" id="modal-title-pemeriksaan">Setting Parameter</h6>
                    <span class="badge bg-primary-subtle text-primary fw-semibold" id="modal-code-pemeriksaan" style="font-size: 0.68rem;"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form-setting-param">
                @csrf
                <input type="hidden" id="input_t_pemeriksaan_list_code" name="t_pemeriksaan_list_code">

                <div class="modal-body p-3" style="max-height: 78vh; overflow-y: auto; background: #f8fafc;">
                    <div class="d-flex justify-content-between align-items-center mb-3 bg-white p-2 rounded-3 border">
                        <span class="fw-bold text-dark" style="font-size: 0.78rem;">
                            <i class="fas fa-sliders-h text-primary me-1"></i> Form Parameter Pemeriksaan
                        </span>
                        <button type="button" class="btn btn-xs btn-success fw-bold px-2 py-1 shadow-sm" id="btn-add-row" style="font-size: 0.72rem;">
                            <i class="fas fa-plus me-1"></i> Tambah Parameter
                        </button>
                    </div>

                    <!-- DYNAMIC ROW CONTAINER -->
                    <div id="param-container">
                        <!-- JS Dynamic Row Inserted Here -->
                    </div>
                </div>

                <div class="modal-footer bg-light py-2 px-3 rounded-bottom-4">
                    <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary fw-bold" id="btn-save-param">
                        <i class="fas fa-save me-1"></i> Simpan Semua Parameter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

<script>
    let tablePemeriksaan;
    let rowIdx = 0;
    let instrumentOptions = []; // Menyimpan master alat dari server

    $(document).ready(function() {
        tablePemeriksaan = $('#table-pemeriksaan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('pemeriksaan.setting.datatable') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                }
            },
            columns: [{
                    data: 'no',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'code'
                },
                {
                    data: 'name'
                },
                {
                    data: 'type'
                },
                {
                    data: 'total_param',
                    orderable: false
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-end'
                }
            ],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "🔍 Cari nama/kode pemeriksaan...",
                lengthMenu: "_MENU_",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    next: "<i class='fas fa-chevron-right'></i>",
                    previous: "<i class='fas fa-chevron-left'></i>"
                }
            }
        });

        // Buka Modal Parameter
        $(document).on('click', '.btn-setting-param', function() {
            const code = $(this).data('code');
            const name = $(this).data('name');

            $('#modal-title-pemeriksaan').text('Setting Parameter: ' + name);
            $('#modal-code-pemeriksaan').text('KODE: ' + code);
            $('#input_t_pemeriksaan_list_code').val(code);

            $('#param-container').html(`
                <div class="custom-loader">
                    <div class="spinner-border text-primary mb-2" role="status"></div>
                    <span class="fw-bold text-muted small">Mengambil parameter & data alat...</span>
                </div>
            `);

            $.post("{{ route('pemeriksaan.setting.get_params') }}", {
                _token: "{{ csrf_token() }}",
                code: code
            }, function(res) {
                if (res.status === 'success') {
                    instrumentOptions = res.instruments || [];
                    populateExistingData(res.data);
                }
                $('#modal-setting-param').modal('show');
            });
        });

        $('#btn-add-row').on('click', function() {
            addParamRow();
        });

        // Toggle Sub-Anakan
        $(document).on('change', '.opt-select', function() {
            const parentId = $(this).data('parent-id');
            const rowElement = `#row-${parentId}`;
            const childContainer = `#child-container-${parentId}`;

            if ($(this).val() === 'Y') {
                $(rowElement).addClass('has-child');
                $(childContainer).removeClass('d-none');

                if ($(`#child-list-${parentId}`).children().length === 0) {
                    addSubChildRow(parentId);
                }
            } else {
                $(rowElement).removeClass('has-child');
                $(childContainer).addClass('d-none');
            }
        });

        $(document).on('click', '.btn-add-sub-child', function() {
            const parentId = $(this).data('parent-id');
            addSubChildRow(parentId);
        });

        $(document).on('click', '.btn-remove-row', function() {
            $($(this).data('id')).remove();
        });

        $(document).on('click', '.btn-remove-child', function() {
            $($(this).data('id')).remove();
        });

        // Submit Form Setting Parameter
        $('#form-setting-param').on('submit', function(e) {
            e.preventDefault();

            const btnSave = $('#btn-save-param');
            btnSave.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

            $.ajax({
                url: "{{ route('pemeriksaan.setting.store') }}",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(res) {
                    btnSave.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Semua Parameter');

                    // Pengecekan respons secara aman
                    if (res && res.status === 'success') {
                        $('#modal-setting-param').modal('hide');
                        tablePemeriksaan.draw();
                        alert(res.message || 'Parameter pemeriksaan berhasil disimpan!');
                    } else {
                        alert(res.message || 'Gagal menyimpan data parameter.');
                    }
                },
                error: function(xhr) {
                    btnSave.prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Semua Parameter');

                    // Ambil pesan error dari backend Laravel (jika ada)
                    let errorMessage = 'Gagal menyimpan data parameter.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        console.error("Server Error:", xhr.responseText);
                    }

                    alert(errorMessage);
                }
            });
        });
    });

    // Helper Dropdown Instrumen menggunakan instrument_id
    function generateInstrumentOptions(selectedValue = '') {
        let optionsHtml = '<option value="">-- Pilih Alat --</option>';

        if (Array.isArray(instrumentOptions) && instrumentOptions.length > 0) {
            instrumentOptions.forEach(inst => {
                const val = inst.instrument_id; // Menggunakan Primary Key instrument_id
                const label = inst.nama_alat + ' (' + inst.kode_alat + ')';
                const isSelected = (val == selectedValue) ? 'selected' : '';
                optionsHtml += `<option value="${val}" ${isSelected}>${label}</option>`;
            });
        }
        return optionsHtml;
    }

    // Mapping Data Parameter Terdaftar
    function populateExistingData(paramList) {
        $('#param-container').html('');
        rowIdx = 0;

        const parents = paramList.filter(p => !p.t_pem_list_val_opt_code);

        if (parents.length === 0) {
            addParamRow();
            return;
        }

        parents.forEach(parent => {
            addParamRow(parent);

            const children = paramList.filter(c => c.t_pem_list_val_opt_code === parent.t_pem_list_val_code);
            if (children.length > 0) {
                children.forEach(child => {
                    addSubChildRow(rowIdx, child);
                });
            }
        });
    }

    // Render Parent Row
    function addParamRow(data = null) {
        rowIdx++;
        const isOptMulti = data && data.t_pem_list_val_opt === 'Y';
        const bgClass = isOptMulti ? 'has-child' : '';
        const showChildArea = isOptMulti ? '' : 'd-none';
        const currentInstrumen = data ? (data.t_pem_list_val_instrumen || '') : '';

        const html = `
            <div class="param-row ${bgClass}" id="row-${rowIdx}" data-row-id="${rowIdx}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-2">
                        <label class="form-label text-muted mb-1" style="font-size:0.65rem;">Nama Parameter</label>
                        <input type="text" name="items[${rowIdx}][name]" class="form-control form-control-sm fw-bold" value="${data ? data.t_pem_list_val_name : ''}" placeholder="Erythrocytes" required>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label text-muted mb-1" style="font-size:0.65rem;">Nilai Normal</label>
                        <input type="text" name="items[${rowIdx}][nilai]" class="form-control form-control-sm" value="${data ? data.t_pem_list_val_nilai : ''}" placeholder="4.0 - 5.5">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label text-muted mb-1" style="font-size:0.65rem;">Rujukan</label>
                        <input type="text" name="items[${rowIdx}][rujukan]" class="form-control form-control-sm" value="${data ? data.t_pem_list_val_rujukan : ''}" placeholder="L: 4.5-5.5">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label text-muted mb-1" style="font-size:0.65rem;">Satuan</label>
                        <input type="text" name="items[${rowIdx}][satuan]" class="form-control form-control-sm" value="${data ? data.t_pem_list_val_satuan : ''}" placeholder="10^6/µL">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label text-muted mb-1" style="font-size:0.65rem;">Param Input</label>
                        <input type="text" name="items[${rowIdx}][param]" class="form-control form-control-sm" value="${data ? (data.t_pem_list_val_param || '') : ''}" placeholder="Param">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-muted mb-1" style="font-size:0.65rem;"><i class="fas fa-tools text-primary me-1"></i>Instrumen Alat</label>
                        <select name="items[${rowIdx}][t_pem_list_val_instrumen]" class="form-select form-select-sm">
                            ${generateInstrumentOptions(currentInstrumen)}
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label text-muted mb-1" style="font-size:0.65rem;">Metode</label>
                        <input type="text" name="items[${rowIdx}][metode]" class="form-control form-control-sm" value="${data ? (data.t_pem_list_val_metode || '') : ''}" placeholder="Metode">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label text-muted mb-1" style="font-size:0.65rem;">Kali</label>
                        <input type="number" step="any" name="items[${rowIdx}][kali]" class="form-control form-control-sm text-center fw-semibold" value="${data ? (data.t_pem_list_val_kali || '1') : '1'}" placeholder="1">
                    </div>
                    <div class="col-md-1 text-center">
                        <label class="form-label text-muted mb-1" style="font-size:0.65rem;">Anakan?</label>
                        <select name="items[${rowIdx}][opt]" class="form-select form-select-sm opt-select" data-parent-id="${rowIdx}">
                            <option value="N" ${!isOptMulti ? 'selected' : ''}>N</option>
                            <option value="Y" ${isOptMulti ? 'selected' : ''}>Y</option>
                        </select>
                    </div>
                    <div class="col-md-1 text-end pt-3">
                        <button type="button" class="btn btn-xs btn-outline-danger btn-remove-row" data-id="#row-${rowIdx}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <!-- CONTAINER SUB-ANAKAN -->
                <div class="child-container mt-2 pt-2 border-top border-primary-subtle ${showChildArea}" id="child-container-${rowIdx}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-primary text-white" style="font-size: 0.65rem;">
                            <i class="fas fa-sitemap me-1"></i> Sub-Anakan Parameter
                        </span>
                        <button type="button" class="btn btn-xs btn-outline-primary py-0 px-2 btn-add-sub-child" data-parent-id="${rowIdx}" style="font-size: 0.68rem;">
                            <i class="fas fa-plus me-1"></i> Tambah Sub-Anakan
                        </button>
                    </div>
                    <div class="child-list" id="child-list-${rowIdx}"></div>
                </div>
            </div>
        `;

        $('#param-container').append(html);
    }

    // Render Sub-Child Row
    function addSubChildRow(parentId, childData = null) {
        const childIdx = Date.now() + Math.floor(Math.random() * 1000);
        const childInstrumen = childData ? (childData.t_pem_list_val_instrumen || '') : '';

        const childHtml = `
            <div class="child-row p-2 mb-1 bg-white" id="child-row-${childIdx}">
                <div class="row g-2 align-items-center">
                    <div class="col-auto text-muted">
                        <i class="fas fa-level-up-alt fa-rotate-90 text-primary ms-1" style="font-size: 0.7rem;"></i>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="items[${parentId}][children][${childIdx}][name]" class="form-control form-control-sm" value="${childData ? childData.t_pem_list_val_name : ''}" placeholder="Nama Sub-Parameter" required>
                    </div>
                    <div class="col-md-1">
                        <input type="text" name="items[${parentId}][children][${childIdx}][nilai]" class="form-control form-control-sm" value="${childData ? childData.t_pem_list_val_nilai : ''}" placeholder="Nilai Normal">
                    </div>
                    <div class="col-md-1">
                        <input type="text" name="items[${parentId}][children][${childIdx}][rujukan]" class="form-control form-control-sm" value="${childData ? childData.t_pem_list_val_rujukan : ''}" placeholder="Rujukan">
                    </div>
                    <div class="col-md-1">
                        <input type="text" name="items[${parentId}][children][${childIdx}][satuan]" class="form-control form-control-sm" value="${childData ? childData.t_pem_list_val_satuan : ''}" placeholder="Satuan">
                    </div>
                    <div class="col-md-1">
                        <input type="text" name="items[${parentId}][children][${childIdx}][param]" class="form-control form-control-sm" value="${childData ? (childData.t_pem_list_val_param || '') : ''}" placeholder="Param">
                    </div>
                    <div class="col-md-2">
                        <select name="items[${parentId}][children][${childIdx}][t_pem_list_val_instrumen]" class="form-select form-select-sm">
                            ${generateInstrumentOptions(childInstrumen)}
                        </select>
                    </div>
                    <div class="col-md-1">
                        <input type="text" name="items[${parentId}][children][${childIdx}][metode]" class="form-control form-control-sm" value="${childData ? (childData.t_pem_list_val_metode || '') : ''}" placeholder="Metode">
                    </div>
                    <div class="col-md-1">
                        <input type="number" step="any" name="items[${parentId}][children][${childIdx}][kali]" class="form-control form-control-sm text-center fw-semibold" value="${childData ? (childData.t_pem_list_val_kali || '1') : '1'}" placeholder="1">
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-xs text-danger btn-remove-child" data-id="#child-row-${childIdx}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        $(`#child-list-${parentId}`).append(childHtml);
    }
</script>
@endsection
