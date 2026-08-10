@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<style>
    /* Gradient Header & Banner Cards */
    .bg-gradient-kpi {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #3b82f6 100%) !important;
    }

    .bg-gradient-filter {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    /* Modern Card Elevate & Transition */
    .kpi-card {
        transition: all 0.25s ease-in-out;
        border-radius: 12px !important;
    }

    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04) !important;
    }

    /* Custom Color Accents for Stats */
    .card-stat-primary {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(37, 99, 235, 0.02) 100%);
        border-left: 4px solid #2563eb !important;
    }

    .card-stat-success {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(5, 150, 105, 0.02) 100%);
        border-left: 4px solid #059669 !important;
    }

    .card-stat-info {
        background: linear-gradient(135deg, rgba(6, 182, 212, 0.08) 0%, rgba(14, 116, 144, 0.02) 100%);
        border-left: 4px solid #0e7490 !important;
    }

    .card-stat-warning {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(217, 119, 6, 0.02) 100%);
        border-left: 4px solid #d97706 !important;
    }

    /* Icon Containers */
    .icon-shape {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    /* Form Styles */
    .form-control-kpi,
    .form-select-kpi {
        border: 1px solid #cbd5e1;
        transition: all 0.2s ease;
    }

    .form-control-kpi:focus,
    .form-select-kpi:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.15);
    }

    /* Custom Table Style */
    .table-modern thead th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    .table-modern tbody tr:hover {
        background-color: rgba(241, 245, 249, 0.6);
    }
</style>
@endsection

@section('content')
{{-- Header Banner Modern --}}
<div class="row mb-3">
    <div class="col">
        <div class="card border-0 shadow-lg bg-gradient-kpi text-white rounded-3 overflow-hidden position-relative">
            <div class="card-body p-3 p-md-4">
                <div class="row align-items-center">
                    <div class="col-md-7 d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 p-2 rounded-3 me-3 backdrop-blur">
                            <img src="{{ asset('img/gl.png') }}" alt="Logo" width="45" />
                        </div>
                        <div>
                            <span class="badge bg-white bg-opacity-20 text-white px-2 py-1 mb-1 fs--2 fw-semibold">
                                <i class="fas fa-sparkles me-1 text-warning"></i>KPI Dashboard
                            </span>
                            <h3 class="text-white fw-bold mb-0 fs--2">
                                {{ env('APP_LABEL') }} <span class="fw-light opacity-75">Management System</span>
                            </h3>
                        </div>
                    </div>
                    <div class="col-md-5 text-md-end mt-2 mt-md-0 border-start-md border-white border-opacity-20 ps-md-4">
                        <div class="text-white-50 fs--2 text-uppercase fw-semibold">Module Menu</div>
                        <h4 class="text-white fw-bold mb-0 fs--2">
                            Master <span class="badge bg-warning text-dark ms-1 fs--2 align-middle">KPI Rekap All</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Form Filter Card --}}
<div class="card border-0 shadow-sm bg-gradient-filter rounded-3 mb-3">
    <div class="card-body p-3">
        <form id="filterForm" class="row g-2 align-items-end">
            <input type="hidden" name="id" value="{{ $id }}">

            <div class="col-md-3">
                <label class="form-label fw-bold text-dark fs--2 mb-1">
                    <i class="far fa-calendar-alt me-1 text-primary"></i>PERIODE BULAN
                </label>
                <input type="month" name="periode" class="form-control form-control-sm form-control-kpi rounded-2 fs--2 shadow-none" value="{{ $selectedPeriode }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold text-dark fs--2 mb-1">
                    <i class="fas fa-sitemap me-1 text-primary"></i>FILTER DEPARTEMEN
                </label>
                <select name="dept_code" class="form-select form-select-sm form-select-kpi rounded-2 fs--2 shadow-none">
                    <option value="">-- Semua Departemen --</option>
                    @foreach($departemens as $d)
                    <option value="{{ $d->hrm_departemen_code }}">
                        {{ $d->hrm_departemen_name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-dark fs--2 mb-1">
                    <i class="fas fa-search me-1 text-primary"></i>CARI PEGAWAI
                </label>
                <input type="text" name="search" class="form-control form-control-sm form-control-kpi rounded-2 fs--2 shadow-none" placeholder="Masukkan Nama atau NIP...">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" id="btnSearch" class="btn btn-primary btn-sm rounded-2 w-100 fs--2 fw-semibold shadow-sm">
                    <i class="fas fa-filter me-1"></i>Search
                </button>
                <button type="button" id="btnReset" class="btn btn-light btn-sm border rounded-2 fs--2 text-secondary shadow-sm" title="Reset Filter">
                    <i class="fas fa-redo-alt"></i>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Container Utama Hasil --}}
<div id="resultContainer">
    <div class="card border-0 shadow-sm rounded-3 text-center py-5 bg-white">
        <div class="card-body py-4">
            <div class="mb-3">
                <span class="p-3 bg-primary bg-opacity-10 rounded-circle d-inline-block">
                    <i class="fas fa-search-plus fa-2x text-primary"></i>
                </span>
            </div>
            <h5 class="fw-bold text-dark mb-1 fs--2">Silakan Pilih Filter Pencarian</h5>
            <p class="text-muted fs--2 mb-0 max-w-md mx-auto">
                Tentukan <strong>Periode Bulan</strong> dan/atau <strong>Departemen</strong> pada form di atas, lalu klik tombol <span class="text-primary fw-semibold">Search</span> untuk memuat data rekap KPI.
            </p>
        </div>
    </div>
</div>

{{-- Modal Detail KPI --}}
<div class="modal fade" id="modalDetailKpi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-gradient-kpi text-white py-2 px-3">
                <h6 class="modal-title fw-bold text-white fs--2 mb-0">
                    <i class="fas fa-award text-warning me-2"></i>Rincian Evaluasi KPI Pegawai
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3" id="modal_kpi_body">
                {{-- Dynamic via JavaScript --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        const resultContainer = document.getElementById('resultContainer');
        const btnReset = document.getElementById('btnReset');
        const modalElement = new bootstrap.Modal(document.getElementById('modalDetailKpi'));
        const modalBody = document.getElementById('modal_kpi_body');

        // Default Content Awal
        const defaultInitialContent = `
        <div class="card border-0 shadow-sm rounded-3 text-center py-5 bg-white">
            <div class="card-body py-4">
                <div class="mb-3">
                    <span class="p-3 bg-primary bg-opacity-10 rounded-circle d-inline-block">
                        <i class="fas fa-search-plus fa-2x text-primary"></i>
                    </span>
                </div>
                <h5 class="fw-bold text-dark mb-1 fs--2">Silakan Pilih Filter Pencarian</h5>
                <p class="text-muted fs--2 mb-0 max-w-md mx-auto">
                    Tentukan <strong>Periode Bulan</strong> dan/atau <strong>Departemen</strong> pada form di atas, lalu klik tombol <span class="text-primary fw-semibold">Search</span> untuk memuat data rekap KPI.
                </p>
            </div>
        </div>
        `;

        // Handle Form Search
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();

            resultContainer.innerHTML = `
            <div class="card border-0 shadow-sm rounded-3 text-center py-5 bg-white">
                <div class="card-body py-4">
                    <div class="spinner-grow text-primary mb-3" role="status" style="width: 2.5rem; height: 2.5rem;"></div>
                    <h6 class="fw-bold text-dark fs--2 mb-1">Sedang Memproses Data...</h6>
                    <p class="text-muted fs--2 mb-0">Mohon tunggu sebentar, sistem sedang memuat rekap KPI.</p>
                </div>
            </div>
            `;

            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData).toString();

            fetch(`{{ route('master_data_kpi_rekap_get') }}?${params}`)
                .then(response => {
                    if (!response.ok) throw new Error('Gagal mengambil data dari server.');
                    return response.json();
                })
                .then(data => {
                    renderResult(data);
                })
                .catch(error => {
                    resultContainer.innerHTML = `
                    <div class="card border-0 shadow-sm rounded-3 text-center py-4 bg-white">
                        <div class="card-body text-danger">
                            <span class="p-2 bg-danger bg-opacity-10 rounded-circle d-inline-block mb-2">
                                <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                            </span>
                            <h6 class="fw-bold fs--2 mb-1">Terjadi Kesalahan</h6>
                            <p class="mb-0 fs--2 fw-medium">${error.message}</p>
                        </div>
                    </div>
                    `;
                });
        });

        // Reset Event
        btnReset.addEventListener('click', function() {
            filterForm.reset();
            resultContainer.innerHTML = defaultInitialContent;
        });

        // Render Result UI
        function renderResult(data) {
            let tableRows = '';

            if (data.rekaps && data.rekaps.length > 0) {
                data.rekaps.forEach((row, index) => {
                    let score = parseFloat(row.total_score) || 0;
                    let badgeClass = 'bg-secondary';
                    let textClass = 'text-secondary';

                    if (score >= 90) {
                        badgeClass = 'bg-success text-white';
                        textClass = 'text-success';
                    } else if (score >= 80) {
                        badgeClass = 'bg-primary text-white';
                        textClass = 'text-primary';
                    } else if (score >= 70) {
                        badgeClass = 'bg-info text-white';
                        textClass = 'text-info';
                    } else if (score >= 60) {
                        badgeClass = 'bg-warning text-dark';
                        textClass = 'text-warning';
                    } else {
                        badgeClass = 'bg-danger text-white';
                        textClass = 'text-danger';
                    }

                    tableRows += `
                    <tr>
                        <td class="text-center fs--2 text-muted fw-bold">${index + 1}</td>
                        <td>
                            <div class="fw-bold text-dark fs--2">${row.hrm_m_pegawai_name}</div>
                            <div class="text-muted fs--2"><i class="far fa-id-card me-1 text-primary"></i>NIP: ${row.hrm_m_pegawai_nip}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border fs--2 px-2 py-1"><i class="fas fa-building me-1 text-secondary"></i>${row.hrm_departemen_name ?? '-'}</span>
                        </td>
                        <td class="text-center fs--2">
                            <span class="fw-semibold text-dark fs--2"><i class="far fa-calendar me-1 text-muted"></i>${row.periode}</span>
                        </td>
                        <td class="text-center">
                            <span class="fs--2 fw-extrabold ${textClass}">${score.toFixed(2)}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge ${badgeClass} px-2 py-1 fs--2 rounded-pill shadow-sm">
                                ${row.kategori}
                            </span>
                        </td>
                        <td class="text-center">
                            <button type="button"
                                    class="btn btn-sm btn-outline-primary rounded-2 px-2 py-1 fs--2 fw-semibold btn-detail-modal shadow-sm"
                                    data-pegawai="${row.hrm_m_pegawai_code}"
                                    data-periode="${row.periode}">
                                <i class="fas fa-eye me-1"></i>Detail
                            </button>
                        </td>
                    </tr>
                    `;
                });
            } else {
                tableRows = `
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted fs--2">
                        <i class="fas fa-folder-open fa-3x mb-3 text-secondary opacity-50 d-block"></i>
                        <span class="fw-bold">Data tidak ditemukan</span>
                        <p class="fs--2 text-muted mb-0">Coba ubah kata kunci atau periode pencarian Anda.</p>
                    </td>
                </tr>
                `;
            }

            // Stat Cards + Modern Table
            resultContainer.innerHTML = `
            <div class="row g-2 mb-3">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm kpi-card card-stat-primary p-2">
                        <div class="d-flex align-items-center justify-content-between px-2">
                            <div>
                                <small class="text-uppercase fw-bold text-primary fs--2 d-block">Total Evaluasi</small>
                                <span class="fs--2 fw-extrabold text-dark">${data.totalEvaluasi}</span>
                                <small class="text-muted fs--2 d-block">Pegawai Terdaftar</small>
                            </div>
                            <div class="icon-shape bg-primary text-white shadow-sm">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm kpi-card card-stat-success p-2">
                        <div class="d-flex align-items-center justify-content-between px-2">
                            <div>
                                <small class="text-uppercase fw-bold text-success fs--2 d-block">Rata-Rata Skor</small>
                                <span class="fs--2 fw-extrabold text-dark">${data.avgSkor}</span>
                                <small class="text-muted fs--2 d-block">Performa Keseluruhan</small>
                            </div>
                            <div class="icon-shape bg-success text-white shadow-sm">
                                <i class="fas fa-star fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm kpi-card card-stat-info p-2">
                        <div class="d-flex align-items-center justify-content-between px-2">
                            <div>
                                <small class="text-uppercase fw-bold text-info fs--2 d-block">High Performer</small>
                                <span class="fs--2 fw-extrabold text-dark">${data.totalHighPerformer}</span>
                                <small class="text-muted fs--2 d-block">Skor Sangat Baik (A/B)</small>
                            </div>
                            <div class="icon-shape bg-info text-white shadow-sm">
                                <i class="fas fa-trophy fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm kpi-card card-stat-warning p-2">
                        <div class="d-flex align-items-center justify-content-between px-2">
                            <div>
                                <small class="text-uppercase fw-bold text-warning fs--2 d-block">Perlu Evaluasi</small>
                                <span class="fs--2 fw-extrabold text-dark">${data.totalUnderPerformer}</span>
                                <small class="text-muted fs--2 d-block">Di Bawah Target Standar</small>
                            </div>
                            <div class="icon-shape bg-warning text-white shadow-sm">
                                <i class="fas fa-exclamation-triangle fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-3">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold text-dark fs--2"><i class="fas fa-list-alt text-primary me-2"></i>Daftar Rekapitulasi KPI</h6>
                    <span class="badge bg-primary bg-opacity-10 text-primary fs--2 px-2 py-1">Updated</span>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table id="tableRekapKpi" class="table table-hover table-modern align-middle mb-0 w-100">
                            <thead>
                                <tr>
                                    <th class="text-center py-2 fs--2" style="width: 40px;">#</th>
                                    <th class="py-2 fs--2">Informasi Pegawai</th>
                                    <th class="py-2 fs--2">Departemen</th>
                                    <th class="text-center py-2 fs--2">Periode</th>
                                    <th class="text-center py-2 fs--2">Total Skor</th>
                                    <th class="text-center py-2 fs--2">Kategori</th>
                                    <th class="text-center py-2 fs--2" style="width: 90px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${tableRows}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            `;

            if (data.rekaps && data.rekaps.length > 0) {
                new DataTable('#tableRekapKpi', {
                    responsive: true,
                    language: {
                        search: "Cari Cepat:",
                        lengthMenu: "Tampilkan _MENU_ Data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ Pegawai",
                        paginate: {
                            previous: "<i class='fas fa-angle-left'></i>",
                            next: "<i class='fas fa-angle-right'></i>"
                        }
                    }
                });
            }

            bindDetailModalEvent();
        }

        // Modal Event
        function bindDetailModalEvent() {
            document.querySelectorAll('.btn-detail-modal').forEach(button => {
                button.addEventListener('click', function() {
                    let pegawaiCode = this.getAttribute('data-pegawai');
                    let periode = this.getAttribute('data-periode');

                    modalBody.innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary spinner-border-sm mb-2" role="status"></div>
                        <p class="mb-0 text-muted fs--2 fw-semibold">Mengambil Rincian KPI...</p>
                    </div>
                    `;
                    modalElement.show();

                    fetch(`{{ url('hrm/manajemen/kpi-dan-target/getDetailAjax') }}/${pegawaiCode}/${periode}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Data rincian tidak ditemukan.');
                            return response.json();
                        })
                        .then(data => {
                            let p = data.pegawai;
                            let r = data.rekap;
                            let details = data.details;

                            let detailRows = '';
                            details.forEach((item, idx) => {
                                detailRows += `
                                <tr>
                                    <td class="text-center fs--2 font-monospace">${idx + 1}</td>
                                    <td>
                                        <div class="fw-bold fs--2 text-dark">${item.hrm_kpi_master_name}</div>
                                        <small class="text-muted fs--2">${item.hrm_kpi_master_desc ?? '-'}</small>
                                    </td>
                                    <td class="text-center fs--2 fw-semibold">${item.hrm_kpi_master_bobot}%</td>
                                    <td class="text-center fs--2">${item.hrm_kpi_master_target}</td>
                                    <td class="text-center fw-bold text-dark fs--2">${item.hrm_kpi_pegawai_value}</td>
                                    <td class="text-center fw-bold text-primary fs--2">${item.hrm_kpi_pegawai_score}</td>
                                    <td><small class="text-secondary fs--2">${item.hrm_kpi_pegawai_catatan ?? '-'}</small></td>
                                </tr>
                                `;
                            });

                            modalBody.innerHTML = `
                            <div class="row g-2 mb-3">
                                <div class="col-md-7">
                                    <div class="p-3 bg-light rounded-3 border fs--2">
                                        <h6 class="fw-bold text-dark mb-1 fs--2">${p.hrm_m_pegawai_name}</h6>
                                        <div class="text-muted fs--2 mb-1"><i class="far fa-id-card me-1 text-primary"></i>NIP: <strong>${p.hrm_m_pegawai_nip}</strong></div>
                                        <div class="text-muted fs--2 mb-1"><i class="fas fa-building me-1 text-primary"></i>Dept: <strong>${p.hrm_departemen_name ?? '-'}</strong></div>
                                        <div class="text-muted fs--2"><i class="far fa-calendar-alt me-1 text-primary"></i>Periode Evaluasi: <span class="badge bg-secondary fs--2">${data.periode}</span></div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="p-3 bg-primary bg-opacity-10 border border-primary border-opacity-20 rounded-3 text-center h-100 d-flex flex-column justify-content-center">
                                        <small class="text-uppercase fw-bold text-primary fs--2">Skor Akhir Performance</small>
                                        <div class="fs--2 fw-extrabold text-primary my-1">${r ? r.hrm_kpi_rekap_total : '0'}</div>
                                        <div><span class="badge bg-primary px-3 py-1 fs--2 rounded-pill shadow-sm">${r ? r.hrm_kpi_rekap_cat : '-'}</span></div>
                                    </div>
                                </div>
                            </div>

                            <h6 class="fw-bold mb-2 text-dark fs--2"><i class="fas fa-tasks text-primary me-1"></i>Indikator Penilaian KPI</h6>
                            <div class="table-responsive rounded-3 border">
                                <table class="table table-sm table-hover align-middle mb-0">
                                    <thead class="bg-light border-bottom">
                                        <tr>
                                            <th class="text-center fs--2 py-2">No</th>
                                            <th class="fs--2 py-2">Indikator</th>
                                            <th class="text-center fs--2 py-2">Bobot</th>
                                            <th class="text-center fs--2 py-2">Target</th>
                                            <th class="text-center fs--2 py-2">Realisasi</th>
                                            <th class="text-center fs--2 py-2">Skor</th>
                                            <th class="fs--2 py-2">Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${detailRows}
                                    </tbody>
                                </table>
                            </div>
                            `;
                        })
                        .catch(err => {
                            modalBody.innerHTML = `
                            <div class="text-center py-4 text-danger fs--2">
                                <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                                <p class="mb-0 fw-semibold fs--2">${err.message}</p>
                            </div>
                            `;
                        });
                });
            });
        }
    });
</script>
@endsection
