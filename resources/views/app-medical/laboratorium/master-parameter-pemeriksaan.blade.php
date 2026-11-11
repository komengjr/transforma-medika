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
        /* background-color: var(--retro-bg); */
    }

    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        background-color: #ffffff;
        overflow: hidden;
    }

    .retro-header-banner {
        background: linear-gradient(135deg, var(--retro-purple) 0%, var(--retro-cyan) 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-dark);
    }

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

    .retro-btn-success {
        background-color: var(--retro-green);
        color: var(--retro-dark);
    }

    .retro-btn-success:hover {
        background-color: #b0f55b;
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

    .select2-container--bootstrap-5 .select2-selection {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
        background-color: #fff;
    }

    .retro-table-header {
        background-color: var(--retro-dark);
        color: var(--retro-green);
        border-bottom: 3px solid var(--retro-dark);
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    #tableParameter tbody tr {
        border-bottom: 2px solid var(--retro-dark);
        transition: background 0.2s;
    }

    #tableParameter tbody tr:hover {
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
                        <i class="fas fa-list-alt fs-3 text-dark"></i>
                    </div>
                    <div>
                        <h6 class="fs--1 mb-0 fw-bold" style="color: rgba(30, 30, 36, 0.7);">LABORATORIUM MANAGEMENT</h6>
                        <h3 class="fw-bolder mb-0" style="color: var(--retro-dark); text-shadow: 1px 1px 0px white;">PARAMETER <span class="fw-normal">PEMERIKSAAN LAB</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- PILIH MASTER PEMERIKSAAN -->
    <div class="col-12">
        <div class="retro-card p-4" style="background-color: var(--retro-yellow);">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <label class="form-label fw-bolder text-dark mb-1">PILIH MASTER PEMERIKSAAN <span class="text-danger">*</span></label>
                </div>
                <div class="col-md-8">
                    <select class="form-select select2-search" id="select_master_pemeriksaan">
                        <option value="">-- Pilih Pemeriksaan Lab --</option>
                        @foreach($pemeriksaanList as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_layanan }} ({{ $item->kode_layanan }}) - {{ $item->nama_tipe }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL PARAMETER -->
    <div class="col-12">
        <div class="retro-card">
            <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: var(--retro-dark);">
                <h5 class="mb-0 fw-bolder text-white" style="color: var(--retro-green) !important;">
                    <i class="fas fa-table me-2"></i>Daftar Parameter Pemeriksaan
                </h5>
                <button class="btn btn-sm retro-btn retro-btn-warning d-none" id="btnAddParameter" data-bs-toggle="modal" data-bs-target="#modalParameter">
                    <i class="fas fa-plus me-1"></i> Tambah Parameter
                </button>
            </div>
            <div class="card-body p-0" style="background-color: #ffffff;">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 fw-bold" id="tableParameter" style="border: 2px solid var(--retro-dark);">
                        <thead class="retro-table-header">
                            <tr>
                                <th class="text-center py-3" style="width: 60px;">Urutan</th>
                                <th class="py-3">Nama Parameter</th>
                                <th class="py-3">Tipe / Kategori</th>
                                <th class="py-3">Nilai Normal</th>
                                <th class="py-3">Satuan</th>
                                <th class="py-3">Metode</th>
                                <th class="text-center py-3" style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="parameterTableBody" style="color: var(--retro-dark);">
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted fw-bold">
                                    <i class="fas fa-info-circle fs-3 d-block mb-2"></i>
                                    <em>Silakan pilih Master Pemeriksaan di atas terlebih dahulu.</em>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FORM TAMBAH / EDIT PARAMETER -->
<div class="modal fade" id="modalParameter" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content retro-modal-content">
            <div class="modal-header py-3 px-4" style="background-color: var(--retro-cyan); border-bottom: 3px solid var(--retro-dark); color: var(--retro-dark);">
                <h5 class="modal-title fw-bolder" id="modalTitle">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Parameter Pemeriksaan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0); border: 2px solid #1e1e24; border-radius: 50%; padding: 5px; box-shadow: 2px 2px 0px #1e1e24;"></button>
            </div>
            <form id="formParameter">
                @csrf
                <input type="hidden" id="parameter_id" name="parameter_id">
                <input type="hidden" id="modal_master_pemeriksaan_id" name="master_pemeriksaan_id">

                <div class="modal-body p-4" style="background-color: var(--retro-bg);">
                    <div class="mb-3">
                        <label class="form-label fw-bolder text-dark">NAMA PARAMETER <span class="text-danger">*</span></label>
                        <input type="text" class="form-control retro-input" id="nama_parameter" name="nama_parameter" placeholder="Contoh: Hemoglobin / Hitung Jenis" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bolder text-dark">INDIKATOR KELOMPOK (GROUP)</label>
                            <div class="form-check form-switch mt-2 border border-dark p-2 rounded bg-white shadow-sm">
                                <input class="form-check-input ms-0 me-2" type="checkbox" id="is_group" name="is_group" value="1" style="width: 40px; height: 20px; border: 2px solid var(--retro-dark);">
                                <label class="form-check-label fw-bold text-dark pt-1" for="is_group">Jadikan Judul Kelompok (Header)</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bolder text-dark">PARAMETER INDUK (PARENT GROUP)</label>
                            <select class="form-select retro-input" id="parent_id" name="parent_id">
                                <option value="">-- Tanpa Induk (Root) --</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bolder text-dark">NILAI NORMAL</label>
                            <input type="text" class="form-control retro-input" id="nilai_normal" name="nilai_normal" placeholder="Contoh: 13.0 - 17.0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bolder text-dark">SATUAN</label>
                            <input type="text" class="form-control retro-input" id="satuan" name="satuan" placeholder="Contoh: g/dL, /uL">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bolder text-dark">METODE PEMERIKSAAN</label>
                            <input type="text" class="form-control retro-input" id="metode" name="metode" placeholder="Contoh: Sahli / Impedance">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bolder text-dark">URUTAN</label>
                            <input type="number" class="form-control retro-input" id="urutan" name="urutan" value="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white border-top border-dark">
                    <button type="button" class="btn retro-btn retro-btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn retro-btn retro-btn-primary" id="btnSaveParameter">
                        <i class="fas fa-save me-1"></i> Simpan Parameter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('.select2-search').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });

        const selectMasterPemeriksaan = $('#select_master_pemeriksaan');
        const parameterTableBody = $('#parameterTableBody');
        const btnAddParameter = $('#btnAddParameter');
        const modalParameter = new bootstrap.Modal(document.getElementById('modalParameter'));
        const formParameter = $('#formParameter');
        let currentParametersList = [];

        // Saat Master Pemeriksaan Dipilih
        selectMasterPemeriksaan.on('change', function() {
            const masterId = $(this).val();
            if (!masterId) {
                btnAddParameter.addClass('d-none');
                parameterTableBody.html(`
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted fw-bold">
                            <i class="fas fa-info-circle fs-3 d-block mb-2"></i>
                            <em>Silakan pilih Master Pemeriksaan di atas terlebih dahulu.</em>
                        </td>
                    </tr>`);
                return;
            }

            btnAddParameter.removeClass('d-none');
            $('#modal_master_pemeriksaan_id').val(masterId);
            loadParameters(masterId);
        });

        function loadParameters(masterId) {
            parameterTableBody.html(`<tr><td colspan="7" class="text-center py-4 fw-bold">Memuat data parameter...</td></tr>`);

            $.ajax({
                url: "{{ route('lab.get_parameters') }}", // Sesuaikan route name Anda
                type: "GET",
                data: {
                    master_pemeriksaan_id: masterId
                },
                success: function(res) {
                    currentParametersList = res.parameters;
                    parameterTableBody.empty();

                    // Update dropdown parent di modal
                    let parentSelect = $('#parent_id');
                    parentSelect.html('<option value="">-- Tanpa Induk (Root) --</option>');
                    res.groupParameters.forEach(grp => {
                        parentSelect.append(`<option value="${grp.id}">${grp.nama_parameter}</option>`);
                    });

                    if (res.parameters.length === 0) {
                        parameterTableBody.html(`
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted fw-bold">
                                    Belum ada parameter untuk pemeriksaan ini. Klik "Tambah Parameter" untuk membuat baru.
                                </td>
                            </tr>`);
                        return;
                    }

                    res.parameters.forEach((param, index) => {
                        let isGroupBadge = param.is_group == 1 ?
                            '<span class="retro-badge" style="background-color: var(--retro-yellow); color: var(--retro-dark); font-size: 0.7rem;">GROUP HEADER</span>' :
                            '<span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark); font-size: 0.7rem;">PARAMETER INPUT</span>';

                        let paddingStyle = param.parent_id ? 'padding-left: 30px;' : '';
                        let namePrefix = param.parent_id ? '<i class="fas fa-level-up-alt fa-rotate-90 me-2 text-muted"></i>' : '';

                        let tr = `
                            <tr class="${param.is_group == 1 ? 'table-secondary fw-bold' : ''}">
                                <td class="text-center">${param.urutan}</td>
                                <td style="${paddingStyle}">${namePrefix}${param.nama_parameter}</td>
                                <td>${isGroupBadge}</td>
                                <td>${param.nilai_normal ?? '-'}</td>
                                <td>${param.satuan ?? '-'}</td>
                                <td>${param.metode ?? '-'}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm retro-btn retro-btn-primary btn-edit-param py-0 px-2 me-1" data-id="${param.id}" title="Edit"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm retro-btn retro-btn-danger btn-delete-param py-0 px-2" data-id="${param.id}" title="Hapus"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>`;
                        parameterTableBody.append(tr);
                    });
                },
                error: function() {
                    parameterTableBody.html(`<tr><td colspan="7" class="text-center py-4 text-danger fw-bold">Gagal memuat data parameter.</td></tr>`);
                }
            });
        }

        // Tombol Tambah Parameter (Reset Form)
        $('#btnAddParameter').on('click', function() {
            formParameter[0].reset();
            $('#parameter_id').val('');
            $('#modalTitle').html('<i class="fas fa-plus-circle me-2"></i>Tambah Parameter Pemeriksaan');
        });

        // Submit Form Simpan/Update Parameter
        formParameter.on('submit', function(e) {
            e.preventDefault();
            let btn = $('#btnSaveParameter');
            let originalText = btn.html();
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

            $.ajax({
                url: "{{ route('lab.save_parameter') }}", // Sesuaikan route name Anda
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    btn.prop('disabled', false).html(originalText);
                    modalParameter.hide();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    loadParameters(selectMasterPemeriksaan.val());
                },
                error: function() {
                    btn.prop('disabled', false).html(originalText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan pada server.'
                    });
                }
            });
        });

        // Tombol Edit Parameter
        $(document).on('click', '.btn-edit-param', function() {
            let id = $(this).data('id');
            let param = currentParametersList.find(p => p.id == id);

            if (param) {
                $('#parameter_id').val(param.id);
                $('#nama_parameter').val(param.nama_parameter);
                $('#is_group').prop('checked', param.is_group == 1);
                $('#parent_id').val(param.parent_id);
                $('#nilai_normal').val(param.nilai_normal);
                $('#satuan').val(param.satuan);
                $('#metode').val(param.metode);
                $('#urutan').val(param.urutan);

                $('#modalTitle').html('<i class="fas fa-edit me-2"></i>Edit Parameter Pemeriksaan');
                modalParameter.show();
            }
        });

        // Tombol Hapus Parameter
        $(document).on('click', '.btn-delete-param', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Hapus Parameter?',
                text: "Data parameter yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1e1e24',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('lab.delete_parameter') }}", // Sesuaikan route name Anda
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            loadParameters(selectMasterPemeriksaan.val());
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal menghapus parameter.'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
