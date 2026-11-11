@extends('layouts.layouts')

@section('base.css')
<!-- CDN SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
        background: linear-gradient(135deg, var(--retro-purple) 0%, var(--retro-cyan) 100%);
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

    /* Inputs & Selects */
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

    /* Kalender Grid Layout */
    .calendar-wrapper {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 1rem;
        min-width: 900px;
    }

    .schedule-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 2px solid var(--retro-dark) !important;
        border-radius: 8px !important;
        box-shadow: 2px 2px 0px var(--retro-dark);
    }

    .schedule-card:hover {
        transform: translateY(-3px);
        box-shadow: 4px 4px 0px var(--retro-dark) !important;
    }

    /* Scrollbar minimalis untuk tabel kalender */
    .custom-scroll::-webkit-scrollbar {
        height: 8px;
    }

    .custom-scroll::-webkit-scrollbar-track {
        background: #ffffff;
        border: 2px solid var(--retro-dark);
        border-radius: 8px;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background: var(--retro-orange);
        border: 2px solid var(--retro-dark);
        border-radius: 8px;
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

    #scheduleTableBody tr {
        border-bottom: 2px solid var(--retro-dark);
        transition: background 0.2s;
    }

    #scheduleTableBody tr:hover {
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
<!-- HTML5 SEMANTIC: HEADER -->
<header class="mb-4">
    <div class="card retro-header-banner p-1">
        <div class="row gx-0 flex-between-center">
            <div class="col-sm-auto d-flex align-items-center p-3">
                <div style="background: white; border: 2px solid #1e1e24; border-radius: 50%; padding: 8px; box-shadow: 3px 3px 0px #1e1e24;" class="me-3">
                    <img src="{{ asset('img/doctor.png') }}" alt="Doctor Icon" width="45" />
                </div>
                <div>
                    <h6 class="fs--1 mb-0 fw-bold" style="color: rgba(30, 30, 36, 0.7); letter-spacing: 1px;">MANAJEMEN OPERASIONAL</h6>
                    <h3 class="fw-bolder mb-0" style="color: var(--retro-dark); text-shadow: 1px 1px 0px white;">JADWAL <span class="fw-normal">PRAKTEK</span></h3>
                </div>
            </div>
            <div class="col-xl-auto px-4 py-2 text-end">
                <button class="btn retro-btn retro-btn-warning" onclick="openAddModal()">
                    <i class="fas fa-plus me-1"></i> Tambah Jadwal
                </button>
            </div>
        </div>
    </div>
</header>

<!-- HTML5 SEMANTIC: MAIN CONTENT -->
<main>
    <div class="row g-4">
        <!-- HTML5 SEMANTIC: ASIDE (Sidebar Filter & Info) -->
        <div class="col-lg-3">
            <!-- Filter Card -->
            <div class="retro-card mb-4">
                <div class="card-header py-3 px-4 border-bottom border-dark" style="background-color: var(--retro-dark); color: var(--retro-cyan);">
                    <h6 class="fw-bolder mb-0">
                        <i class="fas fa-filter me-2"></i>FILTER DATA
                    </h6>
                </div>
                <div class="card-body p-4" style="background-color: #ffffff;">
                    <div class="mb-3">
                        <label class="form-label fs--1 fw-bolder text-dark">POLIKLINIK</label>
                        <select id="filter_poli" class="form-select retro-input" onchange="loadScheduleTable()">
                            <option value="">-- Semua Poliklinik --</option>
                            @foreach($poliklinik as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fs--1 fw-bolder text-dark">HARI</label>
                        <select id="filter_hari" class="form-select retro-input" onchange="loadScheduleTable()">
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

                    <button class="btn retro-btn retro-btn-danger w-100 fw-bold" onclick="resetFilter()">
                        <i class="fas fa-sync-alt me-1"></i> RESET FILTER
                    </button>
                </div>
            </div>

            <!-- Widget Info -->
            <article class="retro-card" style="background-color: var(--retro-orange);">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="fs-1 me-3 text-dark">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <span class="d-block small fw-bolder text-dark opacity-75">TOTAL JADWAL AKTIF</span>
                        <h3 class="fw-bolder mb-0 text-dark" id="totalScheduleCount">0</h3>
                    </div>
                </div>
            </article>
        </div>

        <!-- HTML5 SEMANTIC: SECTION (Konten Utama Tabel/Kalender) -->
        <div class="col-lg-9">
            <div class="retro-card h-100">
                <div class="card-header py-3 px-4 border-bottom border-dark d-flex justify-content-between align-items-center flex-wrap gap-2" style="background-color: #ffffff;">
                    <h5 class="fw-bolder mb-0 text-dark" id="viewTitle">
                        <i class="fas fa-calendar-alt me-2 text-primary"></i>Kalender Mingguan
                    </h5>

                    <!-- Toggle Nav Pills -->
                    <ul class="nav nav-pills p-1 rounded-pill border border-dark bg-light shadow-sm" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill py-1 px-3 fw-bolder small" id="pills-calendar-tab" data-bs-toggle="pill" data-bs-target="#pills-calendar" type="button" role="tab" onclick="changeViewTitle('Kalender Mingguan')" style="background-color: var(--retro-cyan) !important; color: var(--retro-dark) !important; border: 2px solid var(--retro-dark);">
                                <i class="fas fa-th-large me-1"></i> Kalender
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill py-1 px-3 fw-bolder small text-dark" id="pills-table-tab" data-bs-toggle="pill" data-bs-target="#pills-table" type="button" role="tab" onclick="changeViewTitle('Tabel Daftar Jadwal')">
                                <i class="fas fa-list me-1"></i> Tabel
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-3" style="background-color: #ffffff;">
                    <div class="tab-content" id="pills-tabContent">

                        <!-- TAB 1: Kalender Mingguan -->
                        <div class="tab-pane fade show active" id="pills-calendar" role="tabpanel">
                            <div class="overflow-auto custom-scroll pb-3 px-1">
                                <div class="calendar-wrapper">
                                    @php $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']; @endphp
                                    @foreach($days as $day)
                                    <div class="rounded-3 p-2 border border-dark bg-light shadow-sm">
                                        <div class="fw-bolder text-center border-bottom border-dark pb-2 mb-3 text-dark" style="background-color: var(--retro-yellow); border-radius: 4px; padding: 4px;">
                                            {{ $day }}
                                        </div>
                                        <div id="col-day-{{ $day }}">
                                            <div class="text-center py-4 text-muted small fw-bold">Memuat...</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: Tabel Ringkasan -->
                        <div class="tab-pane fade" id="pills-table" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table align-middle w-100 m-0 fw-bold" style="border: 2px solid var(--retro-dark);">
                                    <thead class="retro-table-header">
                                        <tr>
                                            <th class="py-3">Poliklinik</th>
                                            <th class="py-3">Dokter</th>
                                            <th class="py-3">Hari</th>
                                            <th class="py-3">Jam Praktek</th>
                                            <th class="py-3">Kuota</th>
                                            <th class="py-3">Status</th>
                                            <th class="text-end py-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="scheduleTableBody" style="color: var(--retro-dark);">
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">Memuat data...</td>
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
</main>

<!-- HTML5 SEMANTIC: MODAL (Dialog) -->
<div class="modal fade" id="modalJadwal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content retro-modal-content">
            <div class="modal-header py-3 px-4" style="background-color: var(--retro-yellow); border-bottom: 3px solid var(--retro-dark); color: var(--retro-dark);">
                <h5 class="modal-title fw-bolder">
                    <i class="fas fa-user-clock me-2"></i> Tambah Jadwal Dokter
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0); border: 2px solid #1e1e24; border-radius: 50%; padding: 5px; box-shadow: 2px 2px 0px #1e1e24;"></button>
            </div>
            <form id="formJadwal" onsubmit="saveSchedule(event)">
                @csrf
                <div class="modal-body p-4" style="background-color: var(--retro-bg);">
                    <div class="mb-3">
                        <label class="form-label fw-bolder text-dark">Poliklinik <span class="text-danger">*</span></label>
                        <select id="poli_id" name="poli_id" class="form-select retro-input" onchange="onModalPoliChange()" required>
                            <option value="">-- Pilih Poliklinik --</option>
                            @foreach($poliklinik as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bolder text-dark">Dokter <span class="text-danger">*</span></label>
                        <select id="doctor_id" name="doctor_id" class="form-select retro-input" disabled required>
                            <option value="">-- Pilih Poliklinik Terlebih Dahulu --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bolder text-dark">Hari Praktek <span class="text-danger">*</span></label>
                        <select id="day_name" name="day_name" class="form-select retro-input" required>
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
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bolder text-dark">Jam Mulai <span class="text-danger">*</span></label>
                            <input type="time" name="time_start" class="form-control retro-input" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bolder text-dark">Jam Selesai <span class="text-danger">*</span></label>
                            <input type="time" name="time_end" class="form-control retro-input" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bolder text-dark">Kuota Pasien <span class="text-danger">*</span></label>
                        <input type="number" name="quota" class="form-control retro-input" min="1" placeholder="Contoh: 20" required>
                    </div>
                </div>
                <div class="modal-footer bg-white border-top border-dark">
                    <button type="button" class="btn retro-btn retro-btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn retro-btn retro-btn-primary" id="btnSave">
                        <i class="fas fa-save me-1"></i> Simpan Jadwal
                    </button>
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
        const icon = title === 'Kalender Mingguan' ? 'fa-calendar-alt' : 'fa-list';
        document.getElementById('viewTitle').innerHTML = `<i class="fas ${icon} me-2 text-primary"></i>${title}`;
    }

    function openAddModal() {
        document.getElementById('formJadwal').reset();
        const docSelect = document.getElementById('doctor_id');
        if (docSelect) {
            docSelect.innerHTML = '<option value="">-- Pilih Poliklinik Terlebih Dahulu --</option>';
            docSelect.disabled = true;
        }
        if (modalJadwal) {
            modalJadwal.show();
        }
    }

    function loadScheduleTable() {
        const poliId = document.getElementById('filter_poli').value;
        const day = document.getElementById('filter_hari').value;

        // Kosongkan kalender grid
        daysList.forEach(d => {
            const col = document.getElementById(`col-day-${d}`);
            if (col) col.innerHTML = '';
        });

        const url = `{{ route('master_jadwal_doctor_poliklinik_getSchedules') }}?poli_id=${encodeURIComponent(poliId)}&day_name=${encodeURIComponent(day)}`;

        fetch(url)
            .then(res => res.json())
            .then(res => {
                const tbody = document.getElementById('scheduleTableBody');
                tbody.innerHTML = '';

                if (!res.data || !Array.isArray(res.data) || res.data.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="7" class="text-center py-5 text-muted fw-bold">Belum ada jadwal praktek terdaftar.</td></tr>`;
                    document.getElementById('totalScheduleCount').innerText = '0';

                    daysList.forEach(d => {
                        const col = document.getElementById(`col-day-${d}`);
                        if (col) col.innerHTML = `<div class="text-center py-4 text-muted small fw-bold">Tidak ada jadwal</div>`;
                    });
                    return;
                }

                document.getElementById('totalScheduleCount').innerText = res.data.length;

                res.data.forEach(item => {
                    const fullName = item.nama_lengkap || item.master_doctor_name || 'Dokter';
                    const poliName = item.nama_poli || item.m_poli_name || 'Poli';
                    const statusText = item.is_active || item.status === 'AKTIF' ? 'AKTIF' : 'NON-AKTIF';
                    const badgeClass = statusText === 'AKTIF' ? 'background-color: var(--retro-green); color: var(--retro-dark);' : 'background-color: #e9ecef; color: var(--retro-dark);';
                    const scheduleId = item.id_schedule || item.id;
                    const timeStart = item.time_start || item.jam_mulai ? (item.time_start || item.jam_mulai).substring(0, 5) : '-';
                    const timeEnd = item.time_end || item.jam_selesai ? (item.time_end || item.jam_selesai).substring(0, 5) : '-';
                    const dayName = item.day_name || item.hari_praktek;
                    const quota = item.quota || item.kuota_pasien;

                    // 1. Render Baris Tabel
                    tbody.innerHTML += `
                        <tr>
                            <td class="fw-bolder text-dark">${poliName}</td>
                            <td class="fw-bold text-dark">${fullName}</td>
                            <td><span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark);">${dayName}</span></td>
                            <td><i class="fas fa-clock me-1 text-dark"></i> ${timeStart} - ${timeEnd}</td>
                            <td><span class="retro-badge" style="background-color: var(--retro-yellow); color: var(--retro-dark);">${quota} Pasien</span></td>
                            <td><span class="retro-badge" style="${badgeClass}">${statusText}</span></td>
                            <td class="text-end">
                                <button class="btn btn-sm retro-btn retro-btn-danger" onclick="deleteSchedule(${scheduleId})" title="Hapus Jadwal" style="padding: 2px 8px;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    // 2. Render Kolom Kalender
                    const dayCol = document.getElementById(`col-day-${dayName}`);
                    if (dayCol) {
                        dayCol.innerHTML += `
                            <article class="schedule-card card bg-white mb-2 p-2 position-relative">
                                <span class="retro-badge mb-2" style="background-color: var(--retro-cyan); color: var(--retro-dark); font-size: 0.7rem; width: fit-content;">${poliName}</span>
                                <h6 class="fw-bolder fs--1 mb-2 text-dark text-uppercase" style="line-height: 1.2;">${fullName}</h6>

                                <div class="d-flex align-items-center justify-content-between small text-dark fw-bold" style="font-size: 0.75rem;">
                                    <span><i class="fas fa-clock me-1"></i>${timeStart}-${timeEnd}</span>
                                    <span class="retro-badge py-0 px-1" style="background-color: var(--retro-yellow); font-size: 0.65rem;">${quota} Q</span>
                                </div>

                                <button class="btn btn-sm text-danger p-0 position-absolute top-0 end-0 me-2 mt-1 fw-bold" onclick="deleteSchedule(${scheduleId})" title="Hapus">
                                    <i class="fas fa-times fs-6"></i>
                                </button>
                            </article>
                        `;
                    }
                });

                // Isi tulisan kosong jika tidak ada jadwal
                daysList.forEach(d => {
                    const col = document.getElementById(`col-day-${d}`);
                    if (col && col.innerHTML.trim() === '') {
                        col.innerHTML = `<div class="text-center py-4 text-muted small fw-bold">Tidak ada jadwal</div>`;
                    }
                });
            })
            .catch(err => {
                console.error("Gagal memuat data jadwal:", err);
                document.getElementById('scheduleTableBody').innerHTML = `<tr><td colspan="7" class="text-center py-4 text-danger fw-bold">Gagal memuat data jadwal.</td></tr>`;
            });
    }

    function onModalPoliChange() {
        const poliId = document.getElementById('poli_id').value;
        const docSelect = document.getElementById('doctor_id');

        if (!poliId) {
            docSelect.innerHTML = '<option value="">-- Pilih Poliklinik Terlebih Dahulu --</option>';
            docSelect.disabled = true;
            return;
        }

        docSelect.innerHTML = '<option value="">Memuat data dokter...</option>';
        docSelect.disabled = true;

        const url = `{{ route('master_jadwal_doctor_poliklinik_getDoctorsByPoli') }}?poli_id=${encodeURIComponent(poliId)}`;

        fetch(url)
            .then(res => res.json())
            .then(res => {
                docSelect.innerHTML = '<option value="">-- Pilih Dokter --</option>';

                if (res.data && Array.isArray(res.data) && res.data.length > 0) {
                    res.data.forEach(doc => {
                        const fullName = doc.nama_lengkap || doc.master_doctor_name || 'Dokter';
                        const docId = doc.id || doc.doctor_id;
                        docSelect.innerHTML += `<option value="${docId}">${fullName}</option>`;
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

        // Normalisasi format jam agar sesuai standard SQL (H:i)
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
                btnSave.innerHTML = '<i class="fas fa-save me-1"></i> Simpan Jadwal';

                if (res.status === 'success') {
                    if (modalJadwal) {
                        modalJadwal.hide();
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
                btnSave.innerHTML = '<i class="fas fa-save me-1"></i> Simpan Jadwal';

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
            confirmButtonColor: '#1e1e24',
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
                            id_schedule: id
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
