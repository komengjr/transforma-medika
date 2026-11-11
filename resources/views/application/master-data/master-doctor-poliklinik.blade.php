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
        --retro-bg: #f4f0ea;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 5px 5px 0px var(--retro-dark);
        --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
    }

    body {
        /* background-color: var(--retro-bg); */
    }

    /* Retro Cards */
    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        /* background-color: #ffffff; */
        overflow: hidden;
    }

    /* Retro Header Banner */
    .retro-header-banner {
        /* background: linear-gradient(135deg, var(--retro-pink) 0%, var(--retro-orange) 100%); */
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-dark);
    }

    /* Retro Buttons */
    .retro-btn {
        font-weight: 700;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        transition: all 0.1s ease-in-out;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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

    .retro-btn-danger {
        background-color: var(--retro-pink);
        color: var(--retro-dark);
    }

    .retro-btn-danger:hover {
        background-color: #ff8cb7;
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
        font-weight: 600;
    }

    .retro-input:focus {
        border-color: var(--retro-dark) !important;
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
        outline: none;
    }

    /* Poliklinik Item Cards */
    .poli-item-card {
        cursor: pointer;
        border: 2px solid var(--retro-dark);
        border-radius: 8px;
        box-shadow: var(--retro-shadow-sm);
        background-color: #ffffff;
        transition: all 0.2s ease-in-out;
        margin-bottom: 12px;
    }

    .poli-item-card:hover {
        background-color: var(--retro-yellow);
        transform: translateY(-3px);
        box-shadow: 5px 6px 0px var(--retro-dark);
    }

    .poli-item-card.active {
        background-color: var(--retro-green) !important;
        transform: translate(2px, 2px);
        box-shadow: 1px 1px 0px var(--retro-dark);
    }

    .poli-item-card h6 {
        color: var(--retro-dark) !important;
        font-weight: 800 !important;
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

    #table-doctor-poli tbody tr {
        border-bottom: 2px solid var(--retro-dark);
        transition: background 0.2s;
    }

    #table-doctor-poli tbody tr:hover {
        background-color: var(--retro-yellow) !important;
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 4px;
        padding: 4px 8px;
        font-weight: bold;
        background-color: var(--retro-cyan);
        color: var(--retro-dark);
        box-shadow: 2px 2px 0px var(--retro-dark);
    }

    /* Modal Styling */
    .retro-modal-content {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: 8px 8px 0px var(--retro-dark);
        background-color: #ffffff;
    }

    .retro-modal-header {
        background-color: var(--retro-dark);
        color: var(--retro-yellow);
        border-bottom: var(--retro-border);
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
                    <div style="background: white; border: 2px solid #1e1e24; border-radius: 50%; padding: 5px; box-shadow: 3px 3px 0px #1e1e24;" class="me-3">
                        <img src="{{ asset('img/doctor.png') }}" alt="" width="50" />
                    </div>
                    <div>
                        <h6 class="fs--1 mb-0 fw-bold" style="color: rgba(30, 30, 36, 0.7);">SETTING MAPPING</h6>
                        <h3 class="fw-bolder mb-0" style="color: var(--retro-dark); text-shadow: 1px 1px 0px white;">DOKTER <span class="fw-normal">POLIKLINIK</span></h3>
                    </div>
                </div>
                <div class="col-xl-auto px-4 py-2 text-end d-none d-sm-block">
                    <h6 class="fs--1 mb-0 fw-bold" style="color: rgba(30, 30, 36, 0.7);">MENU :</h6>
                    <h4 class="fw-bolder mb-0" style="color: var(--retro-dark);">MASTER <span class="fw-normal">DOCTOR POLI</span></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CONTAINER ALERT AJAX -->
<div id="ajax-alert-container"></div>

<!-- MAIN LAYOUT 2 KOLOM -->
<div class="row g-4">

    <!-- KOLOM KIRI: DAFTAR POLIKLINIK -->
    <div class="col-lg-4 col-md-5">
        <div class="retro-card h-100">
            <div class="card-header py-3 px-4" style="background-color: var(--retro-yellow); border-bottom: 3px solid var(--retro-dark);">
                <h5 class="mb-0 fw-bolder" style="color: var(--retro-dark);">
                    <span class="fas fa-clinic-medical me-2"></span>DAFTAR POLIKLINIK
                </h5>
            </div>
            <div class="card-body p-3" style="background-color: #ffffff; max-height: 650px; overflow-y: auto;">

                <div class="mb-3">
                    <input type="text" id="search-poli-input" class="form-control retro-input py-2" placeholder="🔍 Cari poliklinik...">
                </div>

                <div id="poli-list-loading" class="text-center py-5">
                    <div class="spinner-border" style="color: var(--retro-pink); width: 3rem; height: 3rem;" role="status"></div>
                    <p class="mb-0 mt-3 fw-bold" style="color: var(--retro-dark);">Memuat Poliklinik...</p>
                </div>

                <div id="container-poli-cards" class="d-flex flex-column pt-1"></div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: TABEL DOKTER -->
    <div class="col-lg-8 col-md-7">

        <!-- ALERT JIKA BELUM PILIH POLI -->
        <div class="retro-card h-100 d-flex flex-column justify-content-center align-items-center p-5 text-center" id="alert-select-poli" style="background-color: var(--retro-cyan);">
            <div style="background: white; border: 3px solid #1e1e24; box-shadow: 4px 4px 0px #1e1e24; border-radius: 50%; padding: 20px; margin-bottom: 20px;">
                <span class="fas fa-hand-point-left fa-4x" style="color: var(--retro-dark);"></span>
            </div>
            <h3 class="fw-bolder" style="color: var(--retro-dark);">SILAKAN PILIH POLIKLINIK</h3>
            <p class="fw-bold mb-0" style="color: rgba(30,30,36,0.8);">Pilih salah satu poliklinik pada daftar di sebelah kiri untuk menampilkan dokter bertugas.</p>
        </div>

        <!-- CONTAINER TABEL DOKTER -->
        <div class="retro-card h-100 d-none" id="card-table-doctors">
            <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: var(--retro-dark);">
                <h5 class="mb-0 fw-bolder" id="title-table-doctor" style="color: var(--retro-cyan);">
                    <span class="fas fa-list me-2"></span> DAFTAR DOKTER BERTUGAS
                </h5>
                <button type="button" class="btn btn-sm retro-btn retro-btn-light d-none" id="btn-open-modal-add" data-bs-toggle="modal" data-bs-target="#modal-add-doctor-poli">
                    <span class="fas fa-user-plus me-1"></span> Tambah Dokter
                </button>
            </div>
            <div class="card-body p-4">
                <div id="table-loading" class="text-center py-5 d-none">
                    <div class="spinner-border" style="color: var(--retro-orange); width: 3rem; height: 3rem;" role="status"></div>
                    <p class="mb-0 mt-3 fw-bold" style="color: var(--retro-dark);">Memuat data dokter...</p>
                </div>

                <div class="table-responsive">
                    <table id="table-doctor-poli" class="table align-middle nowrap fw-bold" style="width:100%; border: 2px solid var(--retro-dark);">
                        <thead class="retro-table-header">
                            <tr>
                                <th class="text-center py-3" style="width: 50px;">No</th>
                                <th class="py-3">Kode Dokter</th>
                                <th class="py-3">NIK Dokter</th>
                                <th class="py-3">Nama Dokter</th>
                                <th class="text-center py-3" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-doctor-poli" style="color: var(--retro-dark);"></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- MODAL ASSIGN DOKTER -->
<div class="modal fade" id="modal-add-doctor-poli" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-modal-content">
            <div class="modal-header retro-modal-header py-3 px-4">
                <h5 class="modal-title fw-bolder mb-0">
                    <span class="fas fa-plus-circle me-2"></span> TAMBAH DOKTER KE POLI
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1) grayscale(100%) brightness(200%);"></button>
            </div>
            <form id="form-add-doctor-poli">
                @csrf
                <input type="hidden" name="poli_id" id="modal_input_poli_id">

                <div class="modal-body p-4" style="background-color: var(--retro-bg);">
                    <div class="mb-4">
                        <label class="form-label fw-bolder fs-5" style="color: var(--retro-dark);" for="select_available_doctors">Pilih Dokter :</label>
                        <select class="form-select retro-input py-2" id="select_available_doctors" name="doctor_id" required>
                            <option value="">-- Pilih Dokter --</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer p-3" style="background-color: #ffffff; border-top: 3px solid var(--retro-dark);">
                    <button class="btn retro-btn retro-btn-light" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn retro-btn retro-btn-primary" type="submit" id="btn-save-doctor">
                        <span class="fas fa-save me-1"></span> Simpan Mapping
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
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>

<script>
    let dataTableInstance = null;
    let selectedPoliId = null;

    $(document).ready(function() {
        fetchPolis();

        $('#search-poli-input').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            $('.poli-item-card').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Klik pada Card Poli
        $(document).on('click', '.poli-item-card', function() {
            $('.poli-item-card').removeClass('active');
            $(this).addClass('active');

            selectedPoliId = $(this).data('id');
            const poliName = $(this).data('name');

            if (selectedPoliId) {
                $('#modal_input_poli_id').val(selectedPoliId);
                $('#btn-open-modal-add').removeClass('d-none');
                $('#card-table-doctors').removeClass('d-none');
                $('#alert-select-poli').addClass('d-none');
                $('#title-table-doctor').html(`<span class="fas fa-list me-2"></span> DOKTER DI ${poliName.toUpperCase()}`);

                fetchDoctorsByPoli(selectedPoliId);
            }
        });

        // Submit Form
        $('#form-add-doctor-poli').on('submit', function(e) {
            e.preventDefault();
            const btnSave = $('#btn-save-doctor');
            btnSave.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> MENYIMPAN...');

            const formData = new FormData(this);

            fetch("{{ route('master_doctor_poliklinik_save') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(res => {
                    btnSave.prop('disabled', false).html('<span class="fas fa-save me-1"></span> SIMPAN MAPPING');

                    if (res.status === 'success' || res.success) {
                        showAlert('success', res.message);
                        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modal-add-doctor-poli'));
                        if (modalInstance) modalInstance.hide();
                        if (selectedPoliId) fetchDoctorsByPoli(selectedPoliId);
                    } else {
                        showAlert('danger', res.message);
                    }
                })
                .catch(err => {
                    btnSave.prop('disabled', false).html('<span class="fas fa-save me-1"></span> SIMPAN MAPPING');
                    showAlert('danger', 'Terjadi kesalahan sistem server.');
                });
        });
    });

    function showAlert(type, message) {
        // Retro colors for alerts
        let bgColor = type === 'success' ? '#c1ff72' : '#ffa6c9';
        let icon = type === 'success' ? 'check-circle' : 'exclamation-triangle';

        const alertHtml = `
            <div class="alert alert-dismissible fade show" role="alert" style="background-color: ${bgColor}; border: 3px solid #1e1e24; box-shadow: 4px 4px 0px #1e1e24; color: #1e1e24; font-weight: bold; border-radius: 8px;">
                <span class="fas fa-${icon} me-2 fs-5"></span> <span class="fs-6">${message}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: brightness(0);"></button>
            </div>
        `;
        $('#ajax-alert-container').html(alertHtml);
        setTimeout(() => {
            $('#ajax-alert-container .alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 4000);
    }

    // Fetch Daftar Poli
    function fetchPolis() {
        $('#poli-list-loading').removeClass('d-none');
        fetch("{{ route('master_doctor_poliklinik_list') }}")
            .then(response => response.json())
            .then(res => {
                $('#poli-list-loading').addClass('d-none');
                let cardsHtml = '';

                if (res.status === 'success' && res.data.length > 0) {
                    res.data.forEach(item => {
                        cardsHtml += `
                            <div class="poli-item-card p-3" data-id="${item.id}" data-code="${item.kode_poli}" data-name="${item.nama_poli}">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="mb-1 text-uppercase">${item.nama_poli}</h6>
                                        <span class="badge" style="background-color: var(--retro-dark); color: var(--retro-yellow); border-radius: 4px; border: 1px solid var(--retro-dark);">
                                            <i class="fas fa-hashtag me-1"></i>${item.kode_poli}
                                        </span>
                                    </div>
                                    <div style="background-color: var(--retro-bg); border: 2px solid var(--retro-dark); border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; box-shadow: 2px 2px 0px var(--retro-dark);">
                                        <i class="fas fa-stethoscope" style="color: var(--retro-dark);"></i>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    cardsHtml = `<div class="text-center fw-bold py-4" style="color: var(--retro-dark);">Tidak ada data poliklinik aktif</div>`;
                }
                $('#container-poli-cards').html(cardsHtml);
            });
    }

    // Fetch Dokter berdasarkan Poli ID
    function fetchDoctorsByPoli(poliId) {
        $('#table-loading').removeClass('d-none');
        fetch(`{{ route('master_doctor_poliklinik_get_doctor') }}?poli_id=${poliId}`)
            .then(response => response.json())
            .then(res => {
                $('#table-loading').addClass('d-none');
                if (dataTableInstance) dataTableInstance.destroy();

                let tbodyContent = '';
                let availableDocOptions = '<option value="">-- Pilih Dokter --</option>';

                if (res.status === 'success') {
                    if (res.data.mapped_doctors.length > 0) {
                        res.data.mapped_doctors.forEach((doc, idx) => {
                            tbodyContent += `
                                <tr>
                                    <td class="text-center">${idx + 1}</td>
                                    <td><span class="retro-badge">${doc.kode_dokter}</span></td>
                                    <td>${doc.nik || '-'}</td>
                                    <td class="text-uppercase">${doc.nama_lengkap}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm retro-btn retro-btn-danger btn-delete-doctor" data-mapping-id="${doc.mapping_id}">
                                            <span class="fas fa-trash-alt me-1"></span> Hapus
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    }

                    res.data.available_doctors.forEach(doc => {
                        availableDocOptions += `<option value="${doc.id}">${doc.kode_dokter} - ${doc.nama_lengkap}</option>`;
                    });
                }

                $('#tbody-doctor-poli').html(tbodyContent);
                $('#select_available_doctors').html(availableDocOptions);

                dataTableInstance = new DataTable('#table-doctor-poli', {
                    responsive: true,
                    language: {
                        search: "Cari Dokter:",
                        lengthMenu: "Tampil _MENU_ data",
                        info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ dokter",
                        paginate: {
                            first: "Awal",
                            last: "Akhir",
                            next: "❯",
                            previous: "❮"
                        }
                    }
                });
            });
    }

    // Hapus Dokter dari Poli
    $(document).on('click', '.btn-delete-doctor', function() {
        const mappingId = $(this).data('mapping-id');
        if (!confirm('Keluarkan dokter dari poliklinik ini?')) return;

        const btn = $(this);
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

        fetch("{{ route('master_doctor_poliklinik_remove') }}", {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    mapping_id: mappingId
                })
            })
            .then(response => response.json())
            .then(res => {
                if (res.status === 'success') {
                    showAlert('success', res.message);
                    if (selectedPoliId) fetchDoctorsByPoli(selectedPoliId);
                } else {
                    btn.prop('disabled', false).html('<span class="fas fa-trash-alt me-1"></span> Hapus');
                    showAlert('danger', res.message);
                }
            });
    });
</script>
@endsection
