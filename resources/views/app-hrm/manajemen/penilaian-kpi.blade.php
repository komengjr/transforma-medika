@extends('layouts.layouts')

@section('content')

{{-- CSS Custom HRM Compact & Precision UI --}}
<style>
    .hrm-card {
        border: 1px solid #e3e6f0;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
        background: #ffffff;
    }

    .hrm-header-primary {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: #ffffff !important;
        border-top-left-radius: 7px !important;
        border-top-right-radius: 7px !important;
    }

    .hrm-header-dark {
        background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        color: #ffffff !important;
        border-top-left-radius: 7px !important;
        border-top-right-radius: 7px !important;
    }

    .table-compact th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.72rem;
        letter-spacing: 0.3px;
        padding: 8px 10px !important;
        border-bottom: 2px solid #e2e8f0;
    }

    .table-compact td {
        padding: 6px 10px !important;
        vertical-align: middle;
    }

    .form-control-sm-custom,
    .form-select-sm-custom {
        padding: 4px 8px;
        font-size: 0.82rem;
        border-radius: 5px;
    }

    .avatar-sm-initial {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #1e3c72;
        font-size: 0.75rem;
    }
</style>


{{-- Alert Notifikasi --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm p-2 mb-2 fs--1" role="alert">
    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
    <button type="button" class="btn-close p-2" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm p-2 mb-2 fs--1" role="alert">
    <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
    <button type="button" class="btn-close p-2" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- 1. FORM INPUT PENILAIAN KPI --}}
<div class="card hrm-card mb-3">
    <div class="card-header hrm-header-primary py-2 px-3">
        <div class="d-flex align-items-center">
            <i class="fas fa-user-check me-2 fs-1 text-white"></i>
            <h6 class="mb-0 fs-2 fw-bold text-white">Form Penilaian Key Performance Indicator (KPI)</h6>
        </div>
    </div>
    <div class="card-body p-3">
        <form action="{{ route('kpi.penilaian.store') }}" method="POST">
            @csrf

            <div class="row g-2 mb-2">
                <div class="col-md-8">
                    <label class="form-label fw-bold text-secondary fs--2 mb-1">PILIH PEGAWAI & DEPARTEMEN</label>

                    @if(Auth::check() && Auth::user()->access_code == 'master')
                    {{-- Dropdown Akses Master --}}
                    <select name="hrm_m_pegawai_code" id="pegawai_select" class="form-select form-select-sm-custom shadow-none border-1" required>
                        <option value="" data-dept="">-- Pilih Pegawai --</option>
                        @foreach($pegawais as $p)
                        <option value="{{ $p->hrm_m_pegawai_code }}" data-dept="{{ $p->hrm_m_position_code }}">
                            {{ $p->hrm_m_pegawai_name }} ({{ $p->hrm_m_pegawai_nip }}) - Dept: {{ $p->hrm_departemen_name ?? 'N/A' }}
                        </option>
                        @endforeach
                    </select>
                    @else
                    {{-- Dropdown Terkunci untuk Akses Pegawai Biasa --}}
                    @php
                    $userNip = Auth::user()->userid ?? '';
                    $pegawaiLogin = $pegawais->firstWhere('hrm_m_pegawai_nip', $userNip);
                    @endphp

                    @if($pegawaiLogin)
                    <input type="hidden" name="hrm_m_pegawai_code" id="pegawai_code_hidden" value="{{ $pegawaiLogin->hrm_m_pegawai_code }}">
                    <input type="hidden" id="pegawai_dept_hidden" value="{{ $pegawaiLogin->hrm_m_position_code }}">
                    <input type="text" class="form-control form-control-sm-custom bg-light fw-bold text-dark" value="{{ $pegawaiLogin->hrm_m_pegawai_name }} ({{ $pegawaiLogin->hrm_m_pegawai_nip }}) - Dept: {{ $pegawaiLogin->hrm_departemen_name ?? 'N/A' }}" readonly>
                    @else
                    <input type="text" class="form-control form-control-sm-custom is-invalid" value="Data Pegawai Tidak Ditemukan (NIP: {{ $userNip }})" readonly>
                    <small class="text-danger fs--2 mt-1 d-block">NIP akun Anda tidak cocok dengan data master pegawai.</small>
                    @endif
                    @endif
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold text-secondary fs--2 mb-1">PERIODE PENILAIAN</label>
                    <input type="month" name="hrm_kpi_pegawai_periode" id="hrm_kpi_pegawai_periode" class="form-control form-control-sm-custom shadow-none" value="{{ date('Y-m') }}" required>
                </div>
            </div>

            <div class="table-responsive rounded-2 border my-2">
                <table class="table table-bordered table-compact align-middle mb-0" id="kpi_table">
                    <thead>
                        <tr>
                            <th style="width: 35%;">Indikator KPI</th>
                            <th style="width: 10%;" class="text-center">Bobot (%)</th>
                            <th style="width: 10%;" class="text-center">Target</th>
                            <th style="width: 20%;">Realisasi / Capaian</th>
                            <th style="width: 25%;">Catatan Evaluator</th>
                        </tr>
                    </thead>
                    <tbody id="kpi_container">
                        <tr>
                            <td colspan="5" class="text-center py-3 text-muted fs--1">Silakan pilih pegawai terlebih dahulu.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-2">
                <button type="submit" class="btn btn-primary btn-sm px-3 py-1 rounded-2 fw-semibold fs--1">
                    <i class="fas fa-paper-plane me-1"></i>Simpan & Hitung Penilaian
                </button>
            </div>
        </form>
    </div>
</div>

{{-- 2. TABEL REKAPITULASI HASIL KPI --}}
<div class="card hrm-card">
    <div class="card-header hrm-header-dark py-2 px-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <i class="fas fa-chart-line me-2 fs-1 text-white"></i>
            <h6 class="mb-0 fs-2 fw-bold text-white">Rekapitulasi Hasil Penilaian KPI</h6>
        </div>
        <span class="badge bg-light text-dark fs--2 fw-bold">{{ count($rekaps) }} Record</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-compact align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 4%;">No</th>
                        <th>Kode Rekap</th>
                        <th>Pegawai</th>
                        <th class="text-center">Periode</th>
                        <th class="text-center">Total Skor</th>
                        <th>Kategori / Predikat</th>
                        <th class="text-center" style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekaps as $index => $rekap)
                    <tr>
                        <td class="text-center fw-bold text-secondary fs--1">{{ $index + 1 }}</td>
                        <td><span class="badge bg-light text-dark font-monospace border fs--2">{{ $rekap->hrm_kpi_rekap_code }}</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm-initial me-2">
                                    {{ strtoupper(substr($rekap->hrm_m_pegawai_name ?? 'P', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark fs--1">{{ $rekap->hrm_m_pegawai_name ?? 'N/A' }}</div>
                                    <div class="text-muted fs--2">NIP: {{ $rekap->hrm_m_pegawai_nip ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary fs--2 px-2 py-1">{{ $rekap->hrm_kpi_rekap_periode }}</span>
                        </td>
                        <td class="text-center fs-0 fw-bold text-primary">{{ $rekap->hrm_kpi_rekap_total }}</td>
                        <td>
                            @if(str_contains($rekap->hrm_kpi_rekap_cat, 'Sangat Baik') || str_contains($rekap->hrm_kpi_rekap_cat, 'A'))
                            <span class="badge bg-success bg-opacity-10 text-white border border-success fs--2 px-2 py-1">{{ $rekap->hrm_kpi_rekap_cat }}</span>
                            @elseif(str_contains($rekap->hrm_kpi_rekap_cat, 'Baik') || str_contains($rekap->hrm_kpi_rekap_cat, 'B'))
                            <span class="badge bg-primary bg-opacity-10 text-white border border-primary fs--2 px-2 py-1">{{ $rekap->hrm_kpi_rekap_cat }}</span>
                            @elseif(str_contains($rekap->hrm_kpi_rekap_cat, 'Cukup') || str_contains($rekap->hrm_kpi_rekap_cat, 'C'))
                            <span class="badge bg-warning bg-opacity-10 text-dark border border-warning fs--2 px-2 py-1">{{ $rekap->hrm_kpi_rekap_cat }}</span>
                            @else
                            <span class="badge bg-danger bg-opacity-10 text-white border border-danger fs--2 px-2 py-1">{{ $rekap->hrm_kpi_rekap_cat }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button type="button"
                                class="btn btn-xs btn-outline-primary py-1 px-2 fs--2 btn-detail-modal"
                                data-pegawai="{{ $rekap->hrm_m_pegawai_code }}"
                                data-periode="{{ $rekap->hrm_kpi_rekap_periode }}">
                                <i class="fas fa-eye me-1"></i> Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4 fs--1">
                            <i class="fas fa-folder-open fa-lg me-1 text-secondary"></i>
                            Belum ada data rekapitulasi penilaian KPI.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



{{-- MODAL DETAIL EVALUASI KPI MODERN & COMPACT --}}
<div class="modal fade" id="modalDetailKpi" tabindex="-1" aria-labelledby="modalDetailKpiLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header hrm-header-primary py-2 px-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-id-card me-2 fs-1 text-white"></i>
                    <h6 class="modal-title fs-2 fw-bold text-white" id="modalDetailKpiLabel">Rincian Evaluasi KPI Pegawai</h6>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3" id="modal_kpi_body">
                <div class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                    <p class="mt-1 text-muted fs--1">Memuat detail evaluasi...</p>
                </div>
            </div>
            <div class="modal-footer py-1 px-3 bg-light border-top-0">
                <button type="button" class="btn btn-secondary btn-sm fs--1 py-1" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let selectPegawai = document.getElementById('pegawai_select');
        let hiddenDept = document.getElementById('pegawai_dept_hidden');
        let inputPeriode = document.getElementById('hrm_kpi_pegawai_periode');

        // Helper function untuk mengambil deptCode aktif saat ini
        function getCurrentDeptCode() {
            if (selectPegawai) {
                let selectedOption = selectPegawai.options[selectPegawai.selectedIndex];
                return selectedOption ? selectedOption.getAttribute('data-dept') : '';
            }
            if (hiddenDept) {
                return hiddenDept.value || '';
            }
            return '';
        }

        function loadKpiByDeptCode(deptCode) {
            let container = document.getElementById('kpi_container');

            // Tangkap kode pegawai dan periode terbaru dari input form
            let pegawaiCode = document.getElementById('pegawai_select')?.value || document.getElementById('pegawai_code_hidden')?.value || '';
            let periode = inputPeriode?.value || '';

            if (!deptCode) {
                container.innerHTML = '<tr><td colspan="5" class="text-center py-3 text-muted fs--1">Silakan pilih pegawai terlebih dahulu.</td></tr>';
                return;
            }

            container.innerHTML = '<tr><td colspan="5" class="text-center py-3 fs--1"><i class="fas fa-spinner fa-spin me-1 text-primary"></i> Memuat indikator KPI...</td></tr>';

            // Mengirim query parameter pegawai_code & periode
            fetch(`{{ url('hrm/manajemen/kpi-dan-target/getKpiByDept') }}/${deptCode}?pegawai_code=${pegawaiCode}&periode=${periode}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        container.innerHTML = '<tr><td colspan="5" class="text-center py-3 text-danger fs--1">Tidak ada indikator KPI untuk departemen ini.</td></tr>';
                        return;
                    }

                    let html = '';
                    data.forEach(kpi => {
                        let isAuto = (kpi.hrm_kpi_master_type !== 'manual');
                        let readOnlyAttr = isAuto ? 'readonly bg-light' : '';
                        let val = (kpi.auto_calculated_value !== null && kpi.auto_calculated_value !== undefined) ? kpi.auto_calculated_value : '';

                        html += `
            <tr>
                <td>
                    <div class="fw-bold text-dark fs--1">${kpi.hrm_kpi_master_name}</div>
                    <small class="text-muted d-block fs--2">${kpi.hrm_kpi_master_desc ?? '-'}</small>
                </td>
                <td class="text-center"><span class="badge bg-light text-dark border fs--2">${kpi.hrm_kpi_master_bobot}%</span></td>
                <td class="text-center fw-semibold fs--1">${kpi.hrm_kpi_master_target}</td>
                <td>
                    <input type="number" step="0.01"
                           name="values[${kpi.hrm_kpi_master_code}]"
                           value="${val}"
                           class="form-control form-control-sm-custom shadow-none ${readOnlyAttr}"
                           placeholder="Nilai Realisasi" required ${readOnlyAttr}>
                </td>
                <td>
                    <input type="text" name="catatan[${kpi.hrm_kpi_master_code}]" class="form-control form-control-sm-custom shadow-none" placeholder="Catatan Evaluator (Opsional)">
                </td>
            </tr>`;
                    });
                    container.innerHTML = html;
                })
                .catch(error => {
                    console.error(error);
                    container.innerHTML = '<tr><td colspan="5" class="text-center py-3 text-danger fs--1">Gagal mengambil data KPI.</td></tr>';
                });
        }

        // Event listener ketika dropdown pegawai diubah
        if (selectPegawai) {
            selectPegawai.addEventListener('change', function() {
                let selectedOption = this.options[this.selectedIndex];
                let deptCode = selectedOption ? selectedOption.getAttribute('data-dept') : '';
                loadKpiByDeptCode(deptCode);
            });
        }

        // Event listener ketika input bulan/periode diubah
        if (inputPeriode) {
            inputPeriode.addEventListener('change', function() {
                let deptCode = getCurrentDeptCode();
                if (deptCode) {
                    loadKpiByDeptCode(deptCode);
                }
            });
        }

        // Auto load saat pertama kali halaman terbuka (untuk user pegawai/non-master)
        let initialDeptCode = getCurrentDeptCode();
        if (initialDeptCode) {
            loadKpiByDeptCode(initialDeptCode);
        }

        // Handler Modal Detail
        const modalElement = new bootstrap.Modal(document.getElementById('modalDetailKpi'));
        const modalBody = document.getElementById('modal_kpi_body');

        document.querySelectorAll('.btn-detail-modal').forEach(button => {
            button.addEventListener('click', function() {
                let pegawaiCode = this.getAttribute('data-pegawai');
                let periode = this.getAttribute('data-periode');

                modalBody.innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                        <p class="mt-1 text-muted fs--1 fw-semibold">Mengambil Data Evaluasi...</p>
                    </div>
                `;
                modalElement.show();

                fetch(`{{ url('hrm/manajemen/kpi-dan-target/getDetailAjax') }}/${pegawaiCode}/${periode}`)
                    .then(response => {
                        if (!response.ok) throw new Error('Akses ditolak atau data tidak ditemukan');
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
                                        <div class="fw-bold fs--1">${item.hrm_kpi_master_name}</div>
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
                                        <small class="text-uppercase fw-bold text-white fs--2">Total Skor Performance</small>
                                        <div class="fs-3 fw-bold text-white my-0">${r ? r.hrm_kpi_rekap_total : '0'}</div>
                                        <div><span class="badge bg-primary px-2 py-1 fs--2">${r ? r.hrm_kpi_rekap_cat : '-'}</span></div>
                                    </div>
                                </div>
                            </div>

                            <h6 class="fw-bold mb-1 text-dark fs--1"><i class="fas fa-list me-1"></i>Rincian Indikator KPI</h6>
                            <div class="table-responsive rounded-2 border">
                                <table class="table table-sm table-compact align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Indikator</th>
                                            <th class="text-center">Bobot</th>
                                            <th class="text-center">Target</th>
                                            <th class="text-center">Realisasi</th>
                                            <th class="text-center">Skor</th>
                                            <th>Catatan Evaluator</th>
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
