@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .event-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .event-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .event-cover {
        height: 180px;
        object-fit: cover;
    }

    /* Z-Index Fix untuk Dropdown Aksi Event */
    .event-action-dropdown {
        position: relative;
        z-index: 10;
    }
</style>
@endsection

@section('content')

{{-- Header & Input Filter --}}
<div class="row mb-3 align-items-center">
    <div class="col-md-6 mb-3 mb-md-0">
        <h3 class="fw-bold mb-0">Daftar Event</h3>
        <p class="text-muted mb-0">Kelola dan telusuri event yang tersedia</p>
    </div>
    <div class="col-md-6">
        <div class="input-group input-group-lg shadow-sm">
            <span class="input-group-text bg-white border-end-0">
                <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text" id="filterTitle" class="form-control border-start-0 ps-0" placeholder="Cari nama event...">
        </div>
    </div>
</div>

{{-- Grid Card Event --}}
<div class="row g-3" id="eventCardGrid">
    @forelse ($data as $item)
    <div class="col-12 col-md-3 col-lg-3 event-item" data-title="{{ strtolower($item->event_data_tittle) }}">
        <div class="card h-100 border-0 shadow-sm event-card overflow-hidden">
            {{-- Cover Image --}}
            @if ($item->event_data_cover)
            <img src="{{ asset('storage/' . $item->event_data_cover) }}" class="card-img-top event-cover" alt="{{ $item->event_data_tittle }}">
            @else
            <div class="bg-secondary bg-gradient text-white d-flex align-items-center justify-content-center event-cover">
                <i class="fas fa-calendar-alt fa-3x opacity-50"></i>
            </div>
            @endif

            <div class="card-body d-flex flex-column">
                {{-- Header Badges --}}
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-light text-dark fw-normal border">
                        Code: {{ $item->event_data_code }}
                    </span>
                    @if ($item->event_data_status == 1)
                    <span class="badge bg-success">Aktif</span>
                    @else
                    <span class="badge bg-secondary">Draft</span>
                    @endif
                </div>

                {{-- Judul Event --}}
                <h5 class="card-title fw-bold mb-2">{{ $item->event_data_tittle }}</h5>

                {{-- Metadata --}}
                <div class="text-muted small mb-3">
                    <div class="mb-1">
                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                        {{ $item->event_data_venue }}, {{ $item->event_data_city }}
                    </div>
                    <div class="mb-1">
                        <i class="far fa-calendar-alt text-primary me-2"></i>
                        {{ \Carbon\Carbon::parse($item->event_data_start_date)->translatedFormat('d M Y, H:i') }}
                    </div>
                    <div>
                        <i class="far fa-clock text-warning me-2"></i>
                        Reg Deadline: {{ \Carbon\Carbon::parse($item->event_data_reg_deadline)->translatedFormat('d M Y') }}
                    </div>
                </div>

                {{-- Deskripsi Ringkas --}}
                <p class="card-text text-secondary small flex-grow-1">
                    {{ Str::limit(strip_tags($item->event_data_desc), 90, '...') }}
                </p>

                {{-- Action Dropdown --}}
                <div class="pt-3 border-top mt-auto d-flex justify-content-between align-items-center position-relative">
                    <div class="dropdown event-action-dropdown">
                        <button class="btn btn-outline-primary btn-sm rounded-pill dropdown-toggle" type="button" id="dropdownMenuButton{{ $item->id_event_data }}" data-bs-toggle="dropdown" aria-expanded="false">
                            Aksi Event
                        </button>
                        <ul class="dropdown-menu shadow-lg border-0" aria-labelledby="dropdownMenuButton{{ $item->id_event_data }}">
                            <li>
                                <button class="dropdown-item py-2 btn-modal-detail" data-code="{{ $item->event_data_code }}">
                                    <i class="fas fa-info-circle me-2 text-primary"></i> Detail Event
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item py-2 btn-modal-session" data-code="{{ $item->event_data_code }}">
                                    <i class="fas fa-clock me-2 text-warning"></i> Check Session
                                </button>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <button class="dropdown-item py-2 btn-modal-peserta" data-code="{{ $item->event_data_code }}">
                                    <i class="fas fa-users me-2 text-success"></i> Lihat Peserta
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item py-2 btn-modal-survey" data-code="{{ $item->event_data_code }}">
                                    <i class="fas fa-poll-h me-2 text-info"></i> Data Survey Peserta
                                </button>
                            </li>
                            {{-- Button Tambahan: Verifikasi Pelunasan --}}
                            <li>
                                <button class="dropdown-item py-2 btn-modal-verifikasi" data-code="{{ $item->event_data_code }}">
                                    <i class="fas fa-check-circle me-2 text-success"></i> Verifikasi Pelunasan
                                </button>
                            </li>
                        </ul>
                    </div>
                    {{-- Penggantian ID User dengan Icon Event --}}
                    <div class="text-primary">
                        <i class="fas fa-calendar-alt fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12" id="emptyDatabaseMsg">
        <div class="text-center py-5">
            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada data event.</h5>
        </div>
    </div>
    @endforelse

    {{-- Notifikasi jika pencarian kosong --}}
    <div class="col-12 d-none" id="notFoundMsg">
        <div class="text-center py-5">
            <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Event tidak ditemukan.</h5>
        </div>
    </div>
</div>


{{-- ==================== MODAL CONTAINERS ==================== --}}

{{-- Modal 1: Detail Event --}}
<div class="modal fade" id="modalDetailEvent" tabindex="-1" aria-labelledby="modalDetailEventLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalDetailEventLabel">
                    <i class="fas fa-info-circle text-primary me-2"></i> Detail Event
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="contentModalDetail">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2 text-muted mb-0">Memuat data detail event...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal 2: Check Session --}}
<div class="modal fade" id="modalSessionEvent" tabindex="-1" aria-labelledby="modalSessionEventLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalSessionEventLabel">
                    <i class="fas fa-clock text-warning me-2"></i> Daftar Session & Class Event
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="contentModalSession">
                <div class="text-center py-4">
                    <div class="spinner-border text-warning" role="status"></div>
                    <p class="mt-2 text-muted mb-0">Memuat data session...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal 3: Lihat Peserta --}}
<div class="modal fade" id="modalPesertaEvent" tabindex="-1" aria-labelledby="modalPesertaEventLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalPesertaEventLabel">
                    <i class="fas fa-users text-success me-2"></i> Daftar Peserta Registered
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="contentModalPeserta">
                <div class="text-center py-4">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="mt-2 text-muted mb-0">Memuat data peserta...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal 4: Data Survey Peserta --}}
<div class="modal fade" id="modalSurveyEvent" tabindex="-1" aria-labelledby="modalSurveyEventLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalSurveyEventLabel">
                    <i class="fas fa-poll-h text-info me-2"></i> Data Survey Peserta Event
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="contentModalSurvey">
                <div class="text-center py-4">
                    <div class="spinner-border text-info" role="status"></div>
                    <p class="mt-2 text-muted mb-0">Memuat data survey peserta...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. SEARCH FILTER ---
        const searchInput = document.getElementById('filterTitle');
        const eventItems = document.querySelectorAll('.event-item');
        const notFoundMsg = document.getElementById('notFoundMsg');

        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase().trim();
            let visibleCount = 0;

            eventItems.forEach(function(item) {
                const title = item.getAttribute('data-title');
                if (title.includes(query)) {
                    item.classList.remove('d-none');
                    visibleCount++;
                } else {
                    item.classList.add('d-none');
                }
            });

            if (visibleCount === 0 && eventItems.length > 0) {
                notFoundMsg.classList.remove('d-none');
            } else {
                notFoundMsg.classList.add('d-none');
            }
        });

        // --- 2. MODAL INSTANCES ---
        const modalDetail = new bootstrap.Modal(document.getElementById('modalDetailEvent'));
        const modalSession = new bootstrap.Modal(document.getElementById('modalSessionEvent'));
        const modalPeserta = new bootstrap.Modal(document.getElementById('modalPesertaEvent'));
        const modalSurvey = new bootstrap.Modal(document.getElementById('modalSurveyEvent'));

        // URL base dari Route Name Laravel
        const routeDetailUrl = "{{ route('menu_event_daftar_get_detail', ['code' => 'XXX']) }}";
        const routeSessionUrl = "{{ route('menu_event_get_session', ['code' => 'XXX']) }}";
        const routePesertaUrl = "{{ route('menu_event_daftar_get_peserta', ['code' => 'XXX']) }}";
        const routeSurveyUrl = "{{ route('menu_event_daftar_get_survay', ['code' => 'XXX']) }}";

        // --- 3. AJAX DETAIL EVENT ---
        document.querySelectorAll('.btn-modal-detail').forEach(button => {
            button.addEventListener('click', function() {
                const eventCode = this.getAttribute('data-code');
                const container = document.getElementById('contentModalDetail');

                container.innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 text-muted mb-0">Memuat data detail event...</p>
                    </div>`;
                modalDetail.show();

                const url = routeDetailUrl.replace('XXX', eventCode);

                fetch(url)
                    .then(response => response.json())
                    .then(res => {
                        if (res.status === 'success') {
                            const data = res.data;
                            container.innerHTML = `
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <tr><th width="30%">Kode Event</th><td>${data.event_data_code}</td></tr>
                                        <tr><th>Judul Event</th><td><strong>${data.event_data_tittle}</strong></td></tr>
                                        <tr><th>Lokasi / Venue</th><td>${data.event_data_venue}, ${data.event_data_city}</td></tr>
                                        <tr><th>Alamat</th><td>${data.event_data_address}</td></tr>
                                        <tr><th>Tanggal Mulai</th><td>${data.event_data_start_date}</td></tr>
                                        <tr><th>Tanggal Selesai</th><td>${data.event_data_end_date}</td></tr>
                                        <tr><th>Deadline Reg.</th><td>${data.event_data_reg_deadline}</td></tr>
                                        <tr><th>Deskripsi</th><td>${data.event_data_desc}</td></tr>
                                    </table>
                                </div>
                            `;
                        } else {
                            container.innerHTML = `<div class="alert alert-warning">${res.message}</div>`;
                        }
                    })
                    .catch(err => {
                        container.innerHTML = `<div class="alert alert-danger">Gagal mengambil data dari server.</div>`;
                    });
            });
        });

        // --- AJAX CHECK SESSION ---
        document.querySelectorAll('.btn-modal-session').forEach(button => {
            button.addEventListener('click', function() {
                const eventCode = this.getAttribute('data-code');
                const container = document.getElementById('contentModalSession');

                container.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-warning" role="status"></div>
                <p class="mt-2 text-muted mb-0">Memuat data session...</p>
            </div>`;
                modalSession.show();

                const url = routeSessionUrl.replace('XXX', eventCode);

                fetch(url)
                    .then(response => response.json())
                    .then(res => {
                        if (res.status === 'success' && res.data.length > 0) {
                            let rows = '';
                            res.data.forEach((item, idx) => {
                                const sessionName = item.event_data_sub_session_name || 'Session';
                                const sessionNameLower = sessionName.toLowerCase();

                                let btnClass = 'btn-outline-primary';
                                let btnIcon = 'fas fa-external-link-alt';

                                if (sessionNameLower.includes('check in') || sessionNameLower.includes('check-in') || sessionNameLower.includes('masuk')) {
                                    btnClass = 'btn-outline-success';
                                    btnIcon = 'fas fa-sign-in-alt';
                                } else if (sessionNameLower.includes('check out') || sessionNameLower.includes('check-out') || sessionNameLower.includes('keluar')) {
                                    btnClass = 'btn-outline-danger';
                                    btnIcon = 'fas fa-sign-out-alt';
                                } else if (sessionNameLower.includes('doorprize') || sessionNameLower.includes('undian') || sessionNameLower.includes('hadiah')) {
                                    btnClass = 'btn-outline-warning text-dark';
                                    btnIcon = 'fas fa-gift';
                                } else if (sessionNameLower.includes('makan') || sessionNameLower.includes('lunch') || sessionNameLower.includes('snack')) {
                                    btnClass = 'btn-outline-info text-dark';
                                    btnIcon = 'fas fa-utensils';
                                }

                                rows += `
                            <tr>
                                <td>${idx + 1}</td>
                                <td>
                                    <strong>${item.event_data_sub_name}</strong><br>
                                    <small class="text-muted">Sub Code: ${item.event_data_sub_code}</small>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">${sessionName}</span><br>
                                    <small class="text-muted">Sess Code: ${item.event_data_sub_session_code}</small>
                                </td>
                                <td>
                                    <i class="far fa-clock text-primary me-1"></i> ${item.event_data_sub_start || '-'}<br>
                                    <small class="text-muted">s/d ${item.event_data_sub_end || '-'}</small>
                                </td>
                                <td class="text-center">
                                    <button type="button"
                                            class="btn btn-sm ${btnClass} btn-execute-session"
                                            data-session-code="${item.event_data_sub_session_code}"
                                            data-session-name="${sessionName}"
                                            data-sub-code="${item.event_data_sub_code}">
                                        <i class="${btnIcon} me-1"></i> ${sessionName}
                                    </button>
                                </td>
                            </tr>
                        `;
                            });

                            container.innerHTML = `
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="30%">Sub Event</th>
                                        <th width="25%">Nama Session</th>
                                        <th width="20%">Waktu Sub Event</th>
                                        <th width="20%" class="text-center">Aksi Session</th>
                                    </tr>
                                </thead>
                                <tbody>${rows}</tbody>
                            </table>
                        </div>
                    `;
                        } else {
                            container.innerHTML = `<div class="alert alert-info mb-0">Belum ada data session untuk event ini.</div>`;
                        }
                    })
                    .catch(err => {
                        container.innerHTML = `<div class="alert alert-danger mb-0">Gagal mengambil data session dari server.</div>`;
                    });
            });
        });

        document.getElementById('contentModalSession').addEventListener('click', function(e) {
            const btnSession = e.target.closest('.btn-execute-session');
            if (btnSession) {
                const sessionCode = btnSession.getAttribute('data-session-code');
                const subCode = btnSession.getAttribute('data-sub-code');
                window.location.href = `{{ url('admin/session/execute') }}?session_code=${sessionCode}&sub_code=${subCode}`;
            }
        });

        // --- AJAX LIHAT PESERTA ---
        let allParticipantsData = [];
        let allClassOptions = [];
        let currentPage = 1;
        const rowsPerPage = 10;

        document.querySelectorAll('.btn-modal-peserta').forEach(button => {
            button.addEventListener('click', function() {
                const eventCode = this.getAttribute('data-code');
                const container = document.getElementById('contentModalPeserta');

                container.innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-success" role="status"></div>
                <p class="mt-2 text-muted mb-0">Memuat data peserta & pilihan filter...</p>
            </div>`;
                modalPeserta.show();

                const url = routePesertaUrl.replace('XXX', eventCode);

                fetch(url)
                    .then(response => response.json())
                    .then(res => {
                        if (res.status === 'success' && res.data.length > 0) {
                            allParticipantsData = res.data;
                            allClassOptions = res.classes || [];
                            currentPage = 1;

                            let subEventOptions = '<option value="">-- Semua Sub Event --</option>';
                            if (res.sub_events) {
                                res.sub_events.forEach(sub => {
                                    subEventOptions += `<option value="${sub.event_data_sub_code}">${sub.event_data_sub_name}</option>`;
                                });
                            }

                            let classOptions = '<option value="">-- Semua Class --</option>';
                            if (res.classes) {
                                res.classes.forEach(c => {
                                    classOptions += `<option value="${c.id_event_data_sub_class}">${c.event_data_sub_class_name}</option>`;
                                });
                            }

                            container.innerHTML = `
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body p-2">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold mb-1">Cari Nama / No. Reg / Booking</label>
                                        <input type="text" id="filterSearchName" class="form-control form-control-sm" placeholder="Ketik kata kunci...">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold mb-1">Sub Event</label>
                                        <select id="filterSubEvent" class="form-select form-select-sm">
                                            ${subEventOptions}
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold mb-1">Class</label>
                                        <select id="filterClass" class="form-select form-select-sm">
                                            ${classOptions}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle small mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="4%">#</th>
                                        <th>No. Reg</th>
                                        <th>No. Booking</th>
                                        <th>Peserta</th>
                                        <th>Sub Event</th>
                                        <th>Class & Room</th>
                                        <th>Bayar</th>
                                        <th>Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody id="tablePesertaBody"></tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                            <div class="small text-muted" id="paginationInfo">Menampilkan 0 data</div>
                            <nav>
                                <ul class="pagination pagination-sm mb-0" id="paginationNav"></ul>
                            </nav>
                        </div>
                    `;

                            renderFilteredPesertaTable();

                            document.getElementById('filterSearchName').addEventListener('input', function() {
                                currentPage = 1;
                                renderFilteredPesertaTable();
                            });

                            document.getElementById('filterSubEvent').addEventListener('change', function() {
                                currentPage = 1;
                                const selectedSubCode = this.value;
                                const classSelect = document.getElementById('filterClass');

                                let filteredClassesHtml = '<option value="">-- Semua Class --</option>';
                                allClassOptions.forEach(c => {
                                    if (!selectedSubCode || c.event_data_sub_code === selectedSubCode) {
                                        filteredClassesHtml += `<option value="${c.id_event_data_sub_class}">${c.event_data_sub_class_name}</option>`;
                                    }
                                });
                                classSelect.innerHTML = filteredClassesHtml;

                                renderFilteredPesertaTable();
                            });

                            document.getElementById('filterClass').addEventListener('change', function() {
                                currentPage = 1;
                                renderFilteredPesertaTable();
                            });

                        } else {
                            container.innerHTML = `<div class="alert alert-info mb-0">Belum ada peserta yang terdaftar pada event ini.</div>`;
                        }
                    })
                    .catch(err => {
                        container.innerHTML = `<div class="alert alert-danger mb-0">Gagal mengambil data peserta dari server.</div>`;
                    });
            });
        });

        function renderFilteredPesertaTable() {
            const tbody = document.getElementById('tablePesertaBody');
            const pageInfo = document.getElementById('paginationInfo');
            const pageNav = document.getElementById('paginationNav');

            const keyword = (document.getElementById('filterSearchName')?.value || '').toLowerCase().trim();
            const selectedSub = document.getElementById('filterSubEvent')?.value || '';
            const selectedClass = document.getElementById('filterClass')?.value || '';

            const filtered = allParticipantsData.filter(item => {
                const matchName = !keyword ||
                    (item.full_name && item.full_name.toLowerCase().includes(keyword)) ||
                    (item.registration_code && item.registration_code.toLowerCase().includes(keyword)) ||
                    (item.qr_code_token && item.qr_code_token.toLowerCase().includes(keyword));

                const matchSub = !selectedSub || item.event_data_sub_code === selectedSub;
                const matchClass = !selectedClass || String(item.id_event_data_sub_class) === String(selectedClass);

                return matchName && matchSub && matchClass;
            });

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted py-3">Tidak ada data peserta yang cocok.</td></tr>`;
                pageInfo.innerHTML = `Menampilkan 0 data`;
                pageNav.innerHTML = '';
                return;
            }

            const totalData = filtered.length;
            const totalPages = Math.ceil(totalData / rowsPerPage);
            if (currentPage > totalPages) currentPage = totalPages;

            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, totalData);
            const paginatedData = filtered.slice(startIndex, endIndex);

            let rows = '';
            paginatedData.forEach((p, idx) => {
                let paymentBadge = p.payment_status === 'paid' ? '<span class="badge bg-success">Paid</span>' :
                    p.payment_status === 'pending' ? '<span class="badge bg-warning text-dark">Pending</span>' :
                    p.payment_status === 'failed' ? '<span class="badge bg-danger">Failed</span>' :
                    '<span class="badge bg-secondary">Cancelled</span>';

                let attendanceBadge = p.attendance_status === 'present' ? '<span class="badge bg-primary">Hadir</span>' :
                    p.attendance_status === 'registered' ? '<span class="badge bg-info text-dark">Terdaftar</span>' :
                    p.attendance_status === 'absent' ? '<span class="badge bg-danger">Absen</span>' : '-';

                rows += `
            <tr>
                <td>${startIndex + idx + 1}</td>
                <td>
                    <strong>${p.registration_code}</strong><br>
                    <small class="text-muted">${p.registration_date}</small>
                </td>
                <td>
                    ${p.qr_code_token
                        ? `<span class="badge bg-dark font-monospace">${p.qr_code_token}</span>`
                        : '<span class="text-muted small">-</span>'}
                </td>
                <td>
                    <strong>${p.full_name}</strong><br>
                    <small class="text-muted">${p.email} | ${p.phone_number || '-'}</small>
                </td>
                <td>
                    ${p.event_data_sub_name
                        ? `<strong class="text-primary">${p.event_data_sub_name}</strong>`
                        : '<span class="text-muted small">-</span>'}
                </td>
                <td>
                    ${p.event_data_sub_class_name
                        ? `<strong>${p.event_data_sub_class_name}</strong><br>
                           <small class="text-muted"><i class="fas fa-door-open me-1"></i> ${p.event_data_sub_class_room || '-'}</small>`
                        : '<span class="text-muted small">-</span>'}
                </td>
                <td>${paymentBadge}</td>
                <td>${attendanceBadge}</td>
            </tr>
        `;
            });

            tbody.innerHTML = rows;
            pageInfo.innerHTML = `Menampilkan <strong>${startIndex + 1}</strong> - <strong>${endIndex}</strong> dari <strong>${totalData}</strong> data`;

            let navHtml = `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <button class="page-link" onclick="changePage(${currentPage - 1})">&laquo;</button>
        </li>`;

            for (let i = 1; i <= totalPages; i++) {
                navHtml += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <button class="page-link" onclick="changePage(${i})">${i}</button>
            </li>`;
            }

            navHtml += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <button class="page-link" onclick="changePage(${currentPage + 1})">&raquo;</button>
        </li>`;

            pageNav.innerHTML = navHtml;
        }

        window.changePage = function(page) {
            currentPage = page;
            renderFilteredPesertaTable();
        };

        // --- 4. AJAX DATA SURVEY PESERTA (GROUPED PER PARTICIPANT) ---
        document.querySelectorAll('.btn-modal-survey').forEach(button => {
            button.addEventListener('click', function() {
                const eventCode = this.getAttribute('data-code');
                const container = document.getElementById('contentModalSurvey');

                container.innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-info" role="status"></div>
                        <p class="mt-2 text-muted mb-0">Memuat data survey peserta...</p>
                    </div>`;
                modalSurvey.show();

                const url = routeSurveyUrl.replace('XXX', eventCode);

                fetch(url)
                    .then(response => response.json())
                    .then(res => {
                        if (res.status === 'success' && res.data && res.data.length > 0) {
                            let rows = '';

                            res.data.forEach((participant, idx) => {
                                let surveyAnswersRows = '';

                                if (participant.surveys && participant.surveys.length > 0) {
                                    participant.surveys.forEach((s, sIdx) => {
                                        surveyAnswersRows += `
                                            <tr>
                                                <td width="5%" class="text-center fw-bold text-secondary">${sIdx + 1}</td>
                                                <td width="55%" class="fw-semibold text-dark">${s.survey_question}</td>
                                                <td width="40%">
                                                    <span class="badge bg-light text-dark border px-2 py-1">${s.survey_answer}</span>
                                                </td>
                                            </tr>
                                        `;
                                    });
                                } else {
                                    surveyAnswersRows = `<tr><td colspan="3" class="text-center text-muted">Belum ada rincian jawaban.</td></tr>`;
                                }

                                rows += `
                                    <tr>
                                        <td class="text-center">${idx + 1}</td>
                                        <td>
                                            <strong class="text-dark">${participant.full_name}</strong><br>
                                            <small class="text-muted"><i class="fas fa-id-badge me-1"></i> ${participant.participant_code || '-'}</small>
                                        </td>
                                        <td>${participant.email || '-'}</td>
                                        <td>${participant.phone_number || '-'}</td>
                                        <td class="text-center">
                                            <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-2 py-1">
                                                ${participant.total_answers} Pertanyaan Terjawab
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-info rounded-pill px-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSurvey${participant.id_participant}" aria-expanded="false">
                                                <i class="fas fa-list me-1"></i> Lihat Jawaban
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="collapse" id="collapseSurvey${participant.id_participant}">
                                        <td colspan="6" class="p-3 bg-light">
                                            <div class="card card-body border-0 shadow-sm p-3 rounded-3">
                                                <h6 class="fw-bold text-info mb-2">
                                                    <i class="fas fa-clipboard-list me-2"></i> Rincian Jawaban Survey (${participant.full_name})
                                                </h6>
                                                <table class="table table-sm table-bordered align-middle mb-0 bg-white">
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th class="text-center">No</th>
                                                            <th>Pertanyaan Survey</th>
                                                            <th>Jawaban Peserta</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        ${surveyAnswersRows}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            });

                            container.innerHTML = `
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle small mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="4%" class="text-center">#</th>
                                                <th width="25%">Nama Peserta</th>
                                                <th width="20%">Email</th>
                                                <th width="15%">No. WA</th>
                                                <th width="18%" class="text-center">Status Survey</th>
                                                <th width="18%" class="text-center">Aksi Rincian</th>
                                            </tr>
                                        </thead>
                                        <tbody>${rows}</tbody>
                                    </table>
                                </div>
                            `;
                        } else {
                            container.innerHTML = `<div class="alert alert-info mb-0">Belum ada data survey yang diisi oleh peserta pada event ini.</div>`;
                        }
                    })
                    .catch(err => {
                        container.innerHTML = `<div class="alert alert-danger mb-0">Gagal mengambil data survey dari server.</div>`;
                    });
            });
        });
    });
</script>
<script>
    document.querySelectorAll('.btn-modal-verifikasi').forEach(button => {
        button.addEventListener('click', function() {
            const eventCode = this.getAttribute('data-code');

            Swal.fire({
                title: 'Verifikasi Pelunasan',
                text: 'Masukkan Nomor Registrasi Peserta:',
                input: 'text',
                inputPlaceholder: 'Contoh: REG-123456',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-check me-1"></i> Verifikasi',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Nomor registrasi wajib diisi!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const noRegistrasi = result.value;

                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang memverifikasi pelunasan...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // 1. Definisikan Route dengan dummy parameter 'XXX'
                    const rawRoute = "{{ route('menu_event_daftar_verifikasi_pelunasan', ['code' => 'XXX']) }}";

                    // 2. Ganti 'XXX' dengan eventCode asli
                    const finalUrl = rawRoute.replace('XXX', eventCode);

                    fetch(finalUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                event_code: eventCode,
                                registration_code: noRegistrasi
                            })
                        })
                        .then(response => response.json())
                        .then(res => {
                            if (res.status === true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: res.message,
                                    timer: 1800,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: res.message
                                });
                            }
                        })
                        .catch(err => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: 'Gagal menghubungkan ke server.'
                            });
                        });
                }
            });
        });
    });
</script>
@endsection
