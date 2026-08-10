@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
@endsection

@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow border border-primary bg-primary">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3 m-2" src="{{ asset('img/gl.png') }}" alt="" width="50" />
                    <div>
                        <h6 class="text-white fs--1 mb-0 pt-2" style="color: white !important;">Welcome to </h6>
                        <h4 class="text-white fw-bold mb-1" style="color: white !important;">{{ env('APP_LABEL') }}
                            <span class="text-white fw-medium" style="color: white !important;">Management System</span>
                        </h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block"
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-white fs--1 mb-0" style="color: white !important;">Menu : </h6>
                    <h4 class="text-white fw-bold mb-0" style="color: white !important;">Master <span
                            class="text-white fw-medium" style="color: white !important;">KPI Rekap All Pegawai</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Form Filter --}}
<div class="card border-0 shadow-sm rounded-3 mb-3">
    <div class="card-body p-3">
        <form action="{{ route('kpi.rekap.data') }}" method="GET" class="row g-2 align-items-end">
            <input type="hidden" name="id" value="{{ $id }}">

            <div class="col-md-3">
                <label class="form-label fw-bold text-secondary fs--2 mb-1">PERIODE BULAN</label>
                <input type="month" name="periode" class="form-control form-control-sm shadow-none" value="{{ $selectedPeriode }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold text-secondary fs--2 mb-1">FILTER DEPARTEMEN</label>
                <select name="dept_code" class="form-select form-select-sm shadow-none">
                    <option value="">-- Semua Departemen --</option>
                    @foreach($departemens as $d)
                    <option value="{{ $d->hrm_departemen_code }}" {{ $selectedDept == $d->hrm_departemen_code ? 'selected' : '' }}>
                        {{ $d->hrm_departemen_name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-secondary fs--2 mb-1">CARI PEGAWAI</label>
                <input type="text" name="search" class="form-control form-control-sm shadow-none" placeholder="Cari Nama / NIP..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-primary btn-sm w-100 shadow-none">
                    <i class="fas fa-search me-1"></i>Search
                </button>
                <a href="{{ route('kpi.rekap.index', ['id' => $id]) }}" class="btn btn-light btn-sm border shadow-none" title="Reset Awal">
                    <i class="fas fa-undo"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Summary Cards --}}
<div class="row g-2 mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-2 bg-primary bg-opacity-10 border-start border-primary border-4">
            <div class="d-flex align-items-center justify-content-between px-2">
                <div>
                    <small class="text-uppercase fw-bold text-primary fs--2 d-block">Total Evaluasi</small>
                    <span class="fs-4 fw-bold text-dark">{{ count($rekaps) }}</span>
                    <small class="text-muted fs--2 d-block">Pegawai Terdaftar</small>
                </div>
                <div class="bg-primary text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-2 bg-success bg-opacity-10 border-start border-success border-4">
            <div class="d-flex align-items-center justify-content-between px-2">
                <div>
                    <small class="text-uppercase fw-bold text-success fs--2 d-block">Rata-Rata Skor</small>
                    <span class="fs-4 fw-bold text-dark">{{ number_format($avgSkor, 1) }}</span>
                    <small class="text-muted fs--2 d-block">Performa Keseluruhan</small>
                </div>
                <div class="bg-success text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-2 bg-info bg-opacity-10 border-start border-info border-4">
            <div class="d-flex align-items-center justify-content-between px-2">
                <div>
                    <small class="text-uppercase fw-bold text-info fs--2 d-block">Sangat Baik (A/B)</small>
                    <span class="fs-4 fw-bold text-dark">{{ $totalHighPerformer }}</span>
                    <small class="text-muted fs--2 d-block">Pegawai High Perform</small>
                </div>
                <div class="bg-info text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-award"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 p-2 bg-warning bg-opacity-10 border-start border-warning border-4">
            <div class="d-flex align-items-center justify-content-between px-2">
                <div>
                    <small class="text-uppercase fw-bold text-warning fs--2 d-block">Perlu Perbaikan</small>
                    <span class="fs-4 fw-bold text-dark">{{ $totalUnderPerformer }}</span>
                    <small class="text-muted fs--2 d-block">Skor di bawah standar</small>
                </div>
                <div class="bg-warning text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Data --}}
<div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-3">
    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="tableRekapKpi" class="table table-hover align-middle mb-0 w-100">
                <thead class="bg-light border-bottom">
                    <tr>
                        <th class="text-center py-2 fs--1" style="width: 40px;">#</th>
                        <th class="py-2 fs--1">Informasi Pegawai</th>
                        <th class="py-2 fs--1">Departemen</th>
                        <th class="text-center py-2 fs--1">Periode</th>
                        <th class="text-center py-2 fs--1">Total Skor KPI</th>
                        <th class="text-center py-2 fs--1">Kategori Performa</th>
                        <th class="text-center py-2 fs--1" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekaps as $index => $row)
                    @php
                    $badgeClass = 'bg-secondary';
                    $score = $row->total_score ?? 0;
                    if ($score >= 90) $badgeClass = 'bg-success';
                    elseif ($score >= 80) $badgeClass = 'bg-primary';
                    elseif ($score >= 70) $badgeClass = 'bg-info text-dark';
                    elseif ($score >= 60) $badgeClass = 'bg-warning text-dark';
                    else $badgeClass = 'bg-danger';
                    @endphp
                    <tr>
                        <td class="text-center fs--1 text-muted fw-semibold">{{ $index + 1 }}</td>
                        <td>
                            <div class="fw-bold text-dark fs--1">{{ $row->hrm_m_pegawai_name }}</div>
                            <div class="text-muted fs--2"><i class="fas fa-id-badge me-1"></i>NIP: {{ $row->hrm_m_pegawai_nip }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border fs--2">{{ $row->hrm_departemen_name ?? '-' }}</span>
                        </td>
                        <td class="text-center fs--1">
                            <span class="fw-semibold text-secondary">{{ date('F Y', strtotime($row->periode . '-01')) }}</span>
                        </td>
                        <td class="text-center">
                            <span class="fs-6 fw-bold text-dark">{{ number_format($score, 2) }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $badgeClass }} px-2 py-1 fs--2 rounded-pill">
                                {{ $row->kategori ?? 'Belum Dinilai' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <button type="button"
                                class="btn btn-outline-primary btn-xs px-2 py-1 btn-detail-modal"
                                data-pegawai="{{ $row->hrm_m_pegawai_code }}"
                                data-periode="{{ $row->periode }}"
                                title="Lihat Detail">
                                <i class="fas fa-eye me-1"></i>Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted fs--1">
                            <i class="fas fa-folder-open fa-2x mb-2 d-block text-secondary"></i>
                            Tidak ada data rekap KPI ditemukan untuk pencarian ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Detail --}}
<div class="modal fade" id="modalDetailKpi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light py-2 px-3">
                <h6 class="modal-title fw-bold text-dark"><i class="fas fa-file-alt text-primary me-2"></i>Rincian Penilaian KPI Pegawai</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
        if (document.getElementById('tableRekapKpi')) {
            new DataTable('#tableRekapKpi', {
                responsive: true,
                language: {
                    search: "Cari cepat:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ pegawai",
                    paginate: {
                        previous: "<i class='fas fa-angle-left'></i>",
                        next: "<i class='fas fa-angle-right'></i>"
                    }
                }
            });
        }

        const modalElement = new bootstrap.Modal(document.getElementById('modalDetailKpi'));
        const modalBody = document.getElementById('modal_kpi_body');

        document.querySelectorAll('.btn-detail-modal').forEach(button => {
            button.addEventListener('click', function() {
                let pegawaiCode = this.getAttribute('data-pegawai');
                let periode = this.getAttribute('data-periode');

                modalBody.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                    <p class="mt-2 text-muted fs--1 fw-semibold">Mengambil Data Evaluasi...</p>
                </div>
            `;
                modalElement.show();

                fetch(`{{ url('hrm/manajemen/kpi-dan-target/getDetailAjax') }}/${pegawaiCode}/${periode}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Data tidak ditemukan');
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
                                <td class="text-center fs--1">${idx + 1}</td>
                                <td>
                                    <div class="fw-bold fs--1 text-dark">${item.hrm_kpi_master_name}</div>
                                    <small class="text-muted fs--2">${item.hrm_kpi_master_desc ?? '-'}</small>
                                </td>
                                <td class="text-center fs--1">${item.hrm_kpi_master_bobot}%</td>
                                <td class="text-center fs--1">${item.hrm_kpi_master_target}</td>
                                <td class="text-center fw-bold text-dark fs--1">${item.hrm_kpi_pegawai_value}</td>
                                <td class="text-center fw-bold text-primary fs--1">${item.hrm_kpi_pegawai_score}</td>
                                <td><small class="text-secondary fs--2">${item.hrm_kpi_pegawai_catatan ?? '-'}</small></td>
                            </tr>
                        `;
                        });

                        modalBody.innerHTML = `
                        <div class="row g-2 mb-3">
                            <div class="col-md-7">
                                <div class="p-2 bg-light rounded-2 border fs--1">
                                    <div class="fw-bold text-dark mb-1">${p.hrm_m_pegawai_name}</div>
                                    <div class="text-muted fs--2 mb-1"><i class="fas fa-id-badge me-1"></i>NIP: ${p.hrm_m_pegawai_nip}</div>
                                    <div class="text-muted fs--2 mb-1"><i class="fas fa-building me-1"></i>Dept: ${p.hrm_departemen_name ?? '-'}</div>
                                    <div class="text-muted fs--2"><i class="fas fa-calendar-alt me-1"></i>Periode: <span class="fw-bold text-dark">${data.periode}</span></div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="p-2 bg-primary bg-opacity-10 border border-primary rounded-2 text-center h-100 d-flex flex-column justify-content-center">
                                    <small class="text-uppercase fw-bold text-primary fs--2">Total Skor Performance</small>
                                    <div class="fs-3 fw-bold text-primary my-0">${r ? r.hrm_kpi_rekap_total : '0'}</div>
                                    <div><span class="badge bg-primary px-2 py-1 fs--2">${r ? r.hrm_kpi_rekap_cat : '-'}</span></div>
                                </div>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-1 text-dark fs--1"><i class="fas fa-list me-1"></i>Rincian Indikator KPI</h6>
                        <div class="table-responsive rounded-2 border">
                            <table class="table table-sm align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Indikator</th>
                                        <th class="text-center">Bobot</th>
                                        <th class="text-center">Target</th>
                                        <th class="text-center">Realisasi</th>
                                        <th class="text-center">Skor</th>
                                        <th>Catatan</th>
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
                        <div class="text-center py-3 text-danger fs--1">
                            <i class="fas fa-exclamation-circle fa-lg mb-1"></i>
                            <p class="mb-0">${err.message}</p>
                        </div>
                    `;
                    });
            });
        });
    });
</script>
@endsection
