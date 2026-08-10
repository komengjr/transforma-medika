
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
</style>

<div class="container-fluid p-2">

    {{-- Tombol Navigasi Kembali --}}
    <div class="d-flex justify-content-between align-items-center mb-2">

        <button onclick="window.print()" class="btn btn-sm btn-light border px-3 py-1 fs--1 rounded-2">
            <i class="fas fa-print me-1"></i> Cetak Evaluasi
        </button>
    </div>

    {{-- CARD UTAMA EVALUASI --}}
    <div class="card hrm-card mb-3">
        <div class="card-header hrm-header-primary py-2 px-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-id-card me-2 fs-1 text-white"></i>
                <h6 class="mb-0 fs-2 fw-bold text-white">Detail Evaluasi Key Performance Indicator (KPI)</h6>
            </div>
        </div>
        <div class="card-body p-3">

            {{-- INFORMASI PEGAWAI & HASIL SKOR --}}
            <div class="row g-2 mb-3">
                <div class="col-md-7">
                    <div class="p-2 bg-light rounded-2 border fs--1">
                        <div class="fw-bold text-dark fs-0 mb-1">{{ $pegawai->hrm_m_pegawai_name ?? 'N/A' }}</div>
                        <div class="text-muted fs--2 mb-1">
                            <i class="fas fa-id-badge me-1"></i> NIP: <span class="text-dark fw-semibold">{{ $pegawai->hrm_m_pegawai_nip ?? '-' }}</span>
                        </div>
                        <div class="text-muted fs--2 mb-1">
                            <i class="fas fa-building me-1"></i> Departemen: <span class="text-dark fw-semibold">{{ $pegawai->hrm_departemen_name ?? '-' }}</span>
                        </div>
                        <div class="text-muted fs--2">
                            <i class="fas fa-calendar-alt me-1"></i> Periode Penilaian: <span class="badge bg-secondary fs--2 px-2 py-1">{{ $periode }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="p-2 bg-primary bg-opacity-10 border border-primary rounded-2 text-center h-100 d-flex flex-column justify-content-center">
                        <small class="text-uppercase fw-bold text-primary fs--2">Total Skor Performance</small>
                        <div class="fs-3 fw-bold text-primary my-0">{{ $rekap->hrm_kpi_rekap_total ?? '0' }}</div>
                        <div>
                            @php
                            $cat = $rekap->hrm_kpi_rekap_cat ?? '-';
                            @endphp
                            @if(str_contains($cat, 'Sangat Baik') || str_contains($cat, 'A'))
                            <span class="badge bg-success fs--2 px-2 py-1">{{ $cat }}</span>
                            @elseif(str_contains($cat, 'Baik') || str_contains($cat, 'B'))
                            <span class="badge bg-primary fs--2 px-2 py-1">{{ $cat }}</span>
                            @elseif(str_contains($cat, 'Cukup') || str_contains($cat, 'C'))
                            <span class="badge bg-warning text-dark fs--2 px-2 py-1">{{ $cat }}</span>
                            @else
                            <span class="badge bg-danger fs--2 px-2 py-1">{{ $cat }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABEL RINCIAN INDIKATOR --}}
            <h6 class="fw-bold mb-2 text-dark fs--1"><i class="fas fa-list me-1"></i>Rincian Indikator KPI</h6>
            <div class="table-responsive rounded-2 border">
                <table class="table table-bordered table-compact align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 4%;">No</th>
                            <th style="width: 30%;">Indikator KPI</th>
                            <th class="text-center" style="width: 10%;">Bobot (%)</th>
                            <th class="text-center" style="width: 10%;">Target</th>
                            <th class="text-center" style="width: 12%;">Realisasi</th>
                            <th class="text-center" style="width: 12%;">Skor KPI</th>
                            <th style="width: 22%;">Catatan Evaluator</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($details as $index => $item)
                        <tr>
                            <td class="text-center fs--1">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark fs--1">{{ $item->hrm_kpi_master_name }}</div>
                                <small class="text-muted fs--2 d-block">{{ $item->hrm_kpi_master_desc ?? '-' }}</small>
                            </td>
                            <td class="text-center fs--1">
                                <span class="badge bg-light text-dark border fs--2">{{ $item->hrm_kpi_master_bobot }}%</span>
                            </td>
                            <td class="text-center fs--1 fw-semibold">{{ $item->hrm_kpi_master_target }}</td>
                            <td class="text-center fs--1 fw-bold text-dark">{{ $item->hrm_kpi_pegawai_value }}</td>
                            <td class="text-center fs--1 fw-bold text-primary">{{ $item->hrm_kpi_pegawai_score }}</td>
                            <td class="fs--2 text-secondary">{{ $item->hrm_kpi_pegawai_catatan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-3 fs--1">
                                Tidak ada data indikator penilaian untuk periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

