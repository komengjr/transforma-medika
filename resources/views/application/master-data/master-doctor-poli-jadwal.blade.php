@extends('layouts.layouts')

@section('content')
<style>
    /* Custom Styling untuk Tampilan Kalender Mingguan */
    .calendar-wrapper {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 12px;
        min-width: 900px;
    }

    .day-column {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 10px;
        min-height: 480px;
        border: 1px solid #e9ecef;
    }

    .day-header {
        font-weight: 700;
        text-align: center;
        padding-bottom: 8px;
        margin-bottom: 12px;
        border-bottom: 2px solid #dee2e6;
        color: #495057;
    }

    .schedule-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 10px;
        border-left: 4px solid #0d6efd;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .schedule-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .doc-name {
        font-weight: 600;
        font-size: 0.85rem;
        color: #212529;
        line-height: 1.2;
    }

    .poli-badge {
        font-size: 0.7rem;
        font-weight: 600;
    }

    .time-badge {
        font-size: 0.75rem;
        color: #6c757d;
    }
</style>

<div class="container-fluid py-4">
    <!-- Header Page -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Jadwal Praktek Dokter</h4>
            <p class="text-muted small mb-0">Kelola operasional jadwal dan kuota dokter poliklinik</p>
        </div>
        <button class="btn btn-primary shadow-sm rounded-pill px-3" onclick="openAddModal()">
            <i class="bi bi-plus-lg me-1"></i> Tambah Jadwal
        </button>
    </div>

    <div class="row g-4">
        <!-- SEBELAH KIRI: Panel Filter & Quick Stats -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-3 mb-3">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-funnel me-2 text-primary"></i>Filter Data</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Poliklinik</label>
                        <select id="filter_poli" class="form-select form-select-sm" onchange="loadScheduleTable()">
                            <option value="">-- Semua Poliklinik --</option>
                            @foreach($poliklinik as $p)
                            <option value="{{ $p->m_poli_code }}">{{ $p->m_poli_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Hari</label>
                        <select id="filter_hari" class="form-select form-select-sm" onchange="loadScheduleTable()">
                            <option value="">-- Semua Hari --</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>

                    <button class="btn btn-outline-secondary btn-sm w-100" onclick="resetFilter()">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filter
                    </button>
                </div>
            </div>

            <!-- Card Informasi Singkat -->
            <div class="card border-0 shadow-sm rounded-3 bg-primary text-white p-3">
                <div class="d-flex align-items-center">
                    <div class="fs-1 me-3"><i class="bi bi-calendar2-check"></i></div>
                    <div>
                        <span class="d-block text-white-50 small">Total Jadwal</span>
                        <h4 class="fw-bold mb-0" id="totalScheduleCount">0</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEBELAH KANAN: Tampilan Kalender Mingguan / Tabel -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
                    <h6 class="fw-bold mb-0 text-dark" id="viewTitle"><i class="bi bi-calendar3 me-2 text-primary"></i>Kalender Mingguan</h6>

                    <!-- Toggle View (Kalender / Tabel) -->
                    <ul class="nav nav-pills nav-fill bg-light p-1 rounded-pill" id="pills-tab" role="tablist" style="font-size: 0.85rem;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill py-1 px-3" id="pills-calendar-tab" data-bs-toggle="pill" data-bs-target="#pills-calendar" type="button" role="tab" onclick="changeViewTitle('Kalender Mingguan')">
                                <i class="bi bi-grid-3x3-gap-fill me-1"></i> Kalender
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill py-1 px-3" id="pills-table-tab" data-bs-toggle="pill" data-bs-target="#pills-table" type="button" role="tab" onclick="changeViewTitle('Tabel Daftar Jadwal')">
                                <i class="bi bi-table me-1"></i> Tabel
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-3">
                    <div class="tab-content" id="pills-tabContent">

                        <!-- TAB 1: Kalender Mingguan -->
                        <div class="tab-pane fade show active" id="pills-calendar" role="tabpanel">
                            <div class="table-responsive">
                                <div class="calendar-wrapper">
                                    @php $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']; @endphp
                                    @foreach($days as $day)
                                    <div class="day-column">
                                        <div class="day-header">{{ $day }}</div>
                                        <div class="day-content" id="col-day-{{ $day }}">
                                            <div class="text-center py-4 text-muted small">Memuat...</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: Tabel Ringkasan -->
                        <div class="tab-pane fade" id="pills-table" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3">Poliklinik</th>
                                            <th>Dokter</th>
                                            <th>Hari</th>
                                            <th>Jam Praktek</th>
                                            <th>Kuota</th>
                                            <th>Status</th>
                                            <th class="text-end pe-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="scheduleTableBody">
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">Memuat data...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Jadwal -->
<div class="modal fade" id="modalJadwal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">Tambah Jadwal Dokter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formJadwal" onsubmit="saveSchedule(event)">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Poliklinik <span class="text-danger">*</span></label>
                        <select id="m_poli_code" name="m_poli_code" class="form-select" onchange="onModalPoliChange()" required>
                            <option value="">-- Pilih Poliklinik --</option>
                            @foreach($poliklinik as $p)
                            <option value="{{ $p->m_poli_code }}">{{ $p->m_poli_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Dokter <span class="text-danger">*</span></label>
                        <select id="m_poli_doctor_id" name="m_poli_doctor_id" class="form-select" disabled required>
                            <option value="">-- Pilih Poliklinik Terlebih Dahulu --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Hari Praktek <span class="text-danger">*</span></label>
                        <select id="day_name" name="day_name" class="form-select" required>
                            <option value="">-- Pilih Hari --</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Jam Mulai <span class="text-danger">*</span></label>
                            <input type="time" name="time_start" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Jam Selesai <span class="text-danger">*</span></label>
                            <input type="time" name="time_end" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kuota Pasien <span class="text-danger">*</span></label>
                        <input type="number" name="quota" class="form-control" min="1" placeholder="Contoh: 20" required>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4" id="btnSave">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- CDN SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let modalJadwal;
    const daysList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    document.addEventListener('DOMContentLoaded', function() {
        const modalElement = document.getElementById('modalJadwal');
        if (modalElement) {
            modalJadwal = new bootstrap.Modal(modalElement);
        }
        loadScheduleTable();
    });

    function changeViewTitle(title) {
        const icon = title === 'Kalender Mingguan' ? 'bi-calendar3' : 'bi-table';
        document.getElementById('viewTitle').innerHTML = `<i class="bi ${icon} me-2 text-primary"></i>${title}`;
    }

    function openAddModal() {
        document.getElementById('formJadwal').reset();
        const docSelect = document.getElementById('m_poli_doctor_id');
        if (docSelect) {
            docSelect.innerHTML = '<option value="">-- Pilih Poliklinik Terlebih Dahulu --</option>';
            docSelect.disabled = true;
        }

        if (modalJadwal) {
            modalJadwal.show();
        } else {
            const modalElement = document.getElementById('modalJadwal');
            modalJadwal = new bootstrap.Modal(modalElement);
            modalJadwal.show();
        }
    }

    function loadScheduleTable() {
        const poli = document.getElementById('filter_poli').value;
        const day = document.getElementById('filter_hari').value;

        // Reset Tampilan Kalender per Kolom
        daysList.forEach(d => {
            const col = document.getElementById(`col-day-${d}`);
            if (col) col.innerHTML = '';
        });

        const url = `{{ route('master_jadwal_doctor_poliklinik_getSchedules') }}?m_poli_code=${encodeURIComponent(poli)}&day_name=${encodeURIComponent(day)}`;

        fetch(url)
            .then(res => res.json())
            .then(res => {
                const tbody = document.getElementById('scheduleTableBody');
                tbody.innerHTML = '';

                if (!res.data || !Array.isArray(res.data) || res.data.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-muted">Belum ada jadwal praktek terdaftar.</td></tr>`;
                    document.getElementById('totalScheduleCount').innerText = '0';

                    daysList.forEach(d => {
                        const col = document.getElementById(`col-day-${d}`);
                        if (col) col.innerHTML = `<div class="text-center py-4 text-muted small">Tidak ada jadwal</div>`;
                    });
                    return;
                }

                document.getElementById('totalScheduleCount').innerText = res.data.length;

                res.data.forEach(item => {
                    const fullName = `${item.master_doctor_title_f || ''} ${item.master_doctor_name} ${item.master_doctor_title_e || ''}`.trim();
                    const statusText = item.status || item.schedule_status || 'AKTIF';
                    const badgeClass = statusText === 'AKTIF' ? 'bg-success' : 'bg-secondary';
                    const scheduleId = item.id_schedule || item.id;
                    const timeStart = item.time_start ? item.time_start.substring(0, 5) : '-';
                    const timeEnd = item.time_end ? item.time_end.substring(0, 5) : '-';

                    // 1. Render Tabel
                    tbody.innerHTML += `
                        <tr>
                            <td class="ps-3 fw-bold text-dark">${item.m_poli_name}</td>
                            <td>${fullName}</td>
                            <td><span class="badge bg-light text-dark border">${item.day_name}</span></td>
                            <td><i class="bi bi-clock me-1 text-primary"></i>${timeStart} - ${timeEnd}</td>
                            <td><span class="badge bg-info text-dark">${item.quota} Pasien</span></td>
                            <td><span class="badge ${badgeClass}">${statusText}</span></td>
                            <td class="text-end pe-3">
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteSchedule(${scheduleId})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    // 2. Render Kolom Kalender
                    const dayCol = document.getElementById(`col-day-${item.day_name}`);
                    if (dayCol) {
                        dayCol.innerHTML += `
                            <div class="schedule-card position-relative">
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle poli-badge mb-1">${item.m_poli_name}</span>
                                <div class="doc-name mb-1">${fullName}</div>
                                <div class="time-badge d-flex align-items-center justify-content-between">
                                    <span><i class="bi bi-clock me-1"></i>${timeStart} - ${timeEnd}</span>
                                    <span class="badge bg-light text-dark border">${item.quota} Q</span>
                                </div>
                                <button class="btn btn-link text-danger p-0 position-absolute top-0 end-0 me-2 mt-1" style="font-size:0.75rem;" onclick="deleteSchedule(${scheduleId})" title="Hapus Jadwal">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        `;
                    }
                });

                // Set status kosong untuk hari yang tidak memiliki jadwal
                daysList.forEach(d => {
                    const col = document.getElementById(`col-day-${d}`);
                    if (col && col.innerHTML.trim() === '') {
                        col.innerHTML = `<div class="text-center py-4 text-muted small">Tidak ada jadwal</div>`;
                    }
                });

            })
            .catch(err => {
                console.error("Gagal memuat data jadwal:", err);
                document.getElementById('scheduleTableBody').innerHTML = `<tr><td colspan="7" class="text-center py-4 text-danger">Gagal memuat data jadwal.</td></tr>`;
            });
    }

    function onModalPoliChange() {
        const poliCode = document.getElementById('m_poli_code').value;
        const docSelect = document.getElementById('m_poli_doctor_id');

        if (!poliCode) {
            docSelect.innerHTML = '<option value="">-- Pilih Poliklinik Terlebih Dahulu --</option>';
            docSelect.disabled = true;
            return;
        }

        docSelect.innerHTML = '<option value="">Memuat data dokter...</option>';
        docSelect.disabled = true;

        const url = `{{ route('master_jadwal_doctor_poliklinik_getDoctorsByPoli') }}?m_poli_code=${encodeURIComponent(poliCode)}`;

        fetch(url)
            .then(res => res.json())
            .then(res => {
                docSelect.innerHTML = '<option value="">-- Pilih Dokter --</option>';

                if (res.data && Array.isArray(res.data) && res.data.length > 0) {
                    res.data.forEach(doc => {
                        const fullName = `${doc.master_doctor_title_f || ''} ${doc.master_doctor_name} ${doc.master_doctor_title_e || ''}`.trim();
                        docSelect.innerHTML += `<option value="${doc.m_poli_doctor_id}">${fullName}</option>`;
                    });
                    docSelect.disabled = false;
                } else {
                    docSelect.innerHTML = '<option value="">Tidak ada dokter di poliklinik ini</option>';
                }
            })
            .catch(err => {
                console.error("Gagal memuat daftar dokter:", err);
                docSelect.innerHTML = '<option value="">Gagal mengambil data dokter</option>';
            });
    }

    function saveSchedule(e) {
        e.preventDefault();

        const form = document.getElementById('formJadwal');
        const formData = new FormData(form);
        const btnSave = document.getElementById('btnSave');

        ['time_start', 'time_end'].forEach(field => {
            const value = formData.get(field);
            if (value) {
                const timeParts = value.split(':');
                if (timeParts.length >= 2) {
                    const formattedTime = `${timeParts[0].padStart(2, '0')}:${timeParts[1].padStart(2, '0')}`;
                    formData.set(field, formattedTime);
                }
            }
        });

        btnSave.disabled = true;
        btnSave.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...';

        fetch("{{ route('master_jadwal_doctor_poliklinik_saveSchedule') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: formData
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    let errorMessage = data.message || 'Terjadi kesalahan pada sistem.';
                    if (data.errors) {
                        const firstErrorKey = Object.keys(data.errors)[0];
                        errorMessage = data.errors[firstErrorKey][0];
                    }
                    throw new Error(errorMessage);
                }
                return data;
            })
            .then(res => {
                btnSave.disabled = false;
                btnSave.innerHTML = 'Simpan Jadwal';

                if (res.status === 'success') {
                    const modalEl = document.getElementById('modalJadwal');
                    const instance = bootstrap.Modal.getInstance(modalEl) || modalJadwal;
                    if (instance) {
                        instance.hide();
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message || 'Jadwal dokter berhasil disimpan.',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    form.reset();
                    loadScheduleTable();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message || 'Terjadi kesalahan saat menyimpan.'
                    });
                }
            })
            .catch(err => {
                btnSave.disabled = false;
                btnSave.innerHTML = 'Simpan Jadwal';

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan',
                    text: err.message || 'Terjadi kesalahan sistem saat menghubungi server.'
                });
            });
    }

    function deleteSchedule(id) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data jadwal yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ route('master_jadwal_doctor_poliklinik_remove') }}", {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            id_schedule: id // <-- Sesuaikan nama key menjadi id_schedule
                        })
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: res.message || 'Jadwal berhasil dihapus.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            loadScheduleTable();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: res.message || 'Gagal menghapus jadwal.'
                            });
                        }
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Server',
                            text: 'Terjadi kesalahan sistem saat menghapus data.'
                        });
                    });
            }
        });
    }

    function resetFilter() {
        document.getElementById('filter_poli').value = '';
        document.getElementById('filter_hari').value = '';
        loadScheduleTable();
    }
</script>
@endsection
