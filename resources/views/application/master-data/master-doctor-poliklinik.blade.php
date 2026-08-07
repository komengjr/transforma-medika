@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />

<style>
    /* Styling Card Poli agar interaktif */
    .poli-item-card {
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        border-left: 4px solid transparent;
    }

    .poli-item-card:hover {
        background-color: #f8f9fa;
        transform: translateX(3px);
    }

    .poli-item-card.active {
        background-color: #e6f2ff !important;
        border-left-color: #0d6efd !important;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow-sm border border-primary">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom border-sm-0 p-3">
                    <img class="me-3" src="{{ asset('img/doctor.png') }}" alt="" width="50" />
                    <div>
                        <h6 class="text-primary fs--1 mb-0">Setting Mapping</h6>
                        <h4 class="text-primary fw-bold mb-0">Dokter <span class="fw-normal">Poliklinik</span></h4>
                    </div>
                </div>
                <div class="col-xl-auto px-4 py-2 text-end">
                    <h6 class="text-primary fs--1 mb-0">Menu :</h6>
                    <h4 class="text-primary fw-bold mb-0">Master <span class="fw-normal">Doctor Poli</span></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CONTAINER ALERT AJAX (TANPA RELOAD) -->
<div id="ajax-alert-container"></div>

<!-- MAIN LAYOUT 2 KOLOM (KIRI: POLI CARD, KANAN: TABEL DOKTER) -->
<div class="row g-3">

    <!-- KOLOM KIRI: DAFTAR POLIKLINIK (CARD LIST) -->
    <div class="col-lg-4 col-md-5">
        <div class="card shadow-sm border border-200 h-100">
            <div class="card-header bg-200 d-flex justify-content-between align-items-center py-2 px-3">
                <h6 class="mb-0 fw-bold text-dark">
                    <span class="fas fa-clinic-medical text-primary me-2"></span>Daftar Poliklinik
                </h6>
            </div>
            <div class="card-body p-2" style="max-height: 600px; overflow-y: auto;">
                <!-- Search Box Filter List Poli -->
                <div class="mb-2">
                    <input type="text" id="search-poli-input" class="form-control form-control-sm" placeholder="Cari poliklinik...">
                </div>

                <!-- Loading Spinner List Poli -->
                <div id="poli-list-loading" class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                    <p class="mb-0 mt-2 text-muted fs--1">Memuat Poliklinik...</p>
                </div>

                <!-- Container Card List Poli -->
                <div id="container-poli-cards" class="d-flex flex-column gap-2"></div>
            </div>
        </div>
    </div>

    <!-- KOLOM KANAN: TABEL DOKTER -->
    <div class="col-lg-8 col-md-7">

        <!-- ALERT JIKA BELUM PILIH POLI -->
        <div class="alert alert-info text-center shadow-sm p-4 h-100 d-flex flex-column justify-content-center align-items-center" id="alert-select-poli">
            <span class="fas fa-hand-point-left fa-3x mb-3 text-info"></span>
            <h5 class="fw-bold">Silakan Pilih Poliklinik</h5>
            <p class="text-muted fs--1 mb-0">Pilih salah satu poliklinik pada daftar di sebelah kiri untuk menampilkan dokter bertugas.</p>
        </div>

        <!-- CONTAINER TABEL DOKTER -->
        <div class="card shadow-sm border d-none" id="card-table-doctors">
            <div class="card-header bg-primary py-2 px-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-white" id="title-table-doctor">
                    <span class="fas fa-list me-2"></span> Daftar Dokter Bertugas
                </h6>
                <button type="button" class="btn btn-sm btn-light text-primary fw-semi-bold d-none" id="btn-open-modal-add" data-bs-toggle="modal" data-bs-target="#modal-add-doctor-poli">
                    <span class="fas fa-user-plus me-1"></span> Tambah Dokter
                </button>
            </div>
            <div class="card-body p-3">
                <div id="table-loading" class="text-center py-4 d-none">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mb-0 mt-2 text-muted fs--1">Memuat data dokter...</p>
                </div>

                <table id="table-doctor-poli" class="table table-striped table-hover align-middle nowrap fs--1" style="width:100%">
                    <thead class="bg-200 text-800">
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th>Kode Dokter</th>
                            <th>NIK Dokter</th>
                            <th>Nama Dokter</th>
                            <th class="text-center" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-doctor-poli"></tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- MODAL ASSIGN DOKTER -->
<div class="modal fade" id="modal-add-doctor-poli" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">
                    <span class="fas fa-plus-circle me-2"></span> Tambah Dokter ke Poli
                </h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-add-doctor-poli">
                @csrf
                <input type="hidden" name="m_poli_code" id="modal_input_m_poli_code">

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" for="select_available_doctors">Pilih Dokter :</label>
                        <select class="form-select" id="select_available_doctors" name="master_doctor_code" required>
                            <option value="">-- Pilih Dokter --</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-100">
                    <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-sm btn-primary" type="submit" id="btn-save-doctor">
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
    let selectedPoliCode = null;

    $(document).ready(function() {
        // 1. Load list Poli saat halaman dibuka
        fetchPolis();

        // 2. Search Filter untuk List Poli Card
        $('#search-poli-input').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            $('.poli-item-card').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // 3. Event handler Klik Card Poli
        $(document).on('click', '.poli-item-card', function() {
            $('.poli-item-card').removeClass('active');
            $(this).addClass('active');

            selectedPoliCode = $(this).data('code');
            const poliName = $(this).data('name');

            if (selectedPoliCode) {
                $('#modal_input_m_poli_code').val(selectedPoliCode);
                $('#btn-open-modal-add').removeClass('d-none');
                $('#card-table-doctors').removeClass('d-none');
                $('#alert-select-poli').addClass('d-none');
                $('#title-table-doctor').html(`<span class="fas fa-list me-2"></span> Dokter di ${poliName}`);

                fetchDoctorsByPoli(selectedPoliCode);
            }
        });

        // 4. Submit Form Tambah Dokter via AJAX
        $('#form-add-doctor-poli').on('submit', function(e) {
            e.preventDefault();

            const btnSave = $('#btn-save-doctor');
            btnSave.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

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
                    btnSave.prop('disabled', false).html('<span class="fas fa-save me-1"></span> Simpan Mapping');

                    if (res.status === 'success' || res.success) {
                        showAlert('success', res.message || 'Dokter berhasil ditambahkan ke Poliklinik!');

                        // Close Modal Bootstrap
                        const modalEl = document.getElementById('modal-add-doctor-poli');
                        const modalInstance = bootstrap.Modal.getInstance(modalEl);
                        if (modalInstance) modalInstance.hide();

                        // Refresh Tabel tanpa reload
                        if (selectedPoliCode) {
                            fetchDoctorsByPoli(selectedPoliCode);
                        }
                    } else {
                        showAlert('danger', res.message || 'Gagal menyimpan data mapping.');
                    }
                })
                .catch(err => {
                    btnSave.prop('disabled', false).html('<span class="fas fa-save me-1"></span> Simpan Mapping');
                    console.error("Error Store:", err);
                    showAlert('danger', 'Terjadi kesalahan sistem server.');
                });
        });
    });

    // Helper Toast / Alert
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show shadow-sm" role="alert">
                <span class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-1"></span> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        $('#ajax-alert-container').html(alertHtml);
        setTimeout(() => {
            $('#ajax-alert-container .alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 4000);
    }

    // Fetch Daftar Poliklinik (Render sebagai Cards)
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
                            <div class="card poli-item-card shadow-none border" data-code="${item.m_poli_code}" data-name="${item.m_poli_name}">
                                <div class="card-body p-2 d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="mb-0 text-primary fw-bold fs--1">${item.m_poli_name}</h6>
                                        <small class="text-muted fs--2">Kode: ${item.m_poli_code}</small>
                                    </div>
                                    <span class="badge bg-soft-info text-info fs--2">${item.m_poli_type || 'Poli'}</span>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    cardsHtml = `<div class="text-center text-muted fs--1 py-3">Tidak ada data poliklinik</div>`;
                }

                $('#container-poli-cards').html(cardsHtml);
            })
            .catch(err => {
                $('#poli-list-loading').addClass('d-none');
                console.error("Error Fetch Poli:", err);
            });
    }

    // Fetch Dokter Mapped & Available
    function fetchDoctorsByPoli(poliCode) {
        $('#table-loading').removeClass('d-none');

        fetch(`{{ route('master_doctor_poliklinik_get_doctor') }}?m_poli_code=${poliCode}`)
            .then(response => response.json())
            .then(res => {
                $('#table-loading').addClass('d-none');

                if (dataTableInstance) {
                    dataTableInstance.destroy();
                }

                let tbodyContent = '';
                let availableDocOptions = '<option value="">-- Pilih Dokter --</option>';

                if (res.status === 'success') {
                    // Render Tabel Dokter Terdaftar
                    if (res.data.mapped_doctors.length > 0) {
                        res.data.mapped_doctors.forEach((doc, idx) => {
                            const fullName = `${doc.master_doctor_title_f || ''} ${doc.master_doctor_name} ${doc.master_doctor_title_e || ''}`.trim();
                            tbodyContent += `
                                <tr>
                                    <td class="text-center fw-bold">${idx + 1}</td>
                                    <td><span class="badge bg-soft-primary text-primary fs--2">${doc.master_doctor_code}</span></td>
                                    <td>${doc.master_doctor_nik || '-'}</td>
                                    <td class="fw-bold text-dark">${fullName}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-doctor" data-id="${doc.id}">
                                            <span class="fas fa-user-minus me-1"></span> Hapus
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    }

                    // Populate Dropdown Modal Dokter yang Belum Terdaftar
                    res.data.available_doctors.forEach(doc => {
                        const fullName = `${doc.master_doctor_title_f || ''} ${doc.master_doctor_name} ${doc.master_doctor_title_e || ''}`.trim();
                        availableDocOptions += `<option value="${doc.master_doctor_code}">${fullName}</option>`;
                    });
                }

                $('#tbody-doctor-poli').html(tbodyContent);
                $('#select_available_doctors').html(availableDocOptions);

                dataTableInstance = new DataTable('#table-doctor-poli', {
                    responsive: true
                });
            })
            .catch(err => {
                $('#table-loading').addClass('d-none');
                console.error("Error Fetch Doctors:", err);
            });
    }

    // Hapus Dokter via AJAX
    $(document).on('click', '.btn-delete-doctor', function() {
        const id = $(this).data('id');

        if (!confirm('Keluarkan dokter dari poliklinik ini?')) {
            return;
        }

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
                    id: id
                })
            })
            .then(response => response.json())
            .then(res => {
                if (res.status === 'success' || res.success) {
                    showAlert('success', res.message || 'Dokter berhasil dikeluarkan dari Poliklinik!');
                    if (selectedPoliCode) {
                        fetchDoctorsByPoli(selectedPoliCode);
                    }
                } else {
                    btn.prop('disabled', false).html('<span class="fas fa-user-minus me-1"></span> Hapus');
                    showAlert('danger', res.message || 'Gagal menghapus data dokter.');
                }
            })
            .catch(err => {
                btn.prop('disabled', false).html('<span class="fas fa-user-minus me-1"></span> Hapus');
                console.error("Error Delete:", err);
                showAlert('danger', 'Terjadi kesalahan sistem server.');
            });
    });
</script>
@endsection
