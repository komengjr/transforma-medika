<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-grid-border: rgba(99, 102, 241, 0.14);
        --ent-surface: #ffffff;
        --ent-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark,
    body.dark-mode {
        --ent-surface: #0f172a;
        --ent-text: #f8fafc;
        --ent-grid-border: rgba(148, 163, 184, 0.16);
    }

    /* Skala Font Standar: fs-2 (default), fs-1, fs--1, fs--2 */
    .fs-2 {
        font-size: 1rem !important;
        line-height: 1.55;
    }

    .fs-1 {
        font-size: 1.15rem !important;
        line-height: 1.4;
    }

    .fs--1 {
        font-size: 0.875rem !important;
        line-height: 1.5;
    }

    .fs--2 {
        font-size: 0.75rem !important;
        line-height: 1.4;
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 14px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 2px 12px -2px rgba(15, 23, 42, 0.05);
    }

    .ent-header-indigo {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        color: #ffffff !important;
        border-bottom: 1px solid rgba(99, 102, 241, 0.25) !important;
        border-top-left-radius: 14px !important;
        border-top-right-radius: 14px !important;
    }

    .ent-sub-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        background-color: rgba(79, 70, 229, 0.03);
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        letter-spacing: 0.03em;
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
    }

    .ent-btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 11px 14px;
        white-space: nowrap;
    }

    .table-custom tbody td {
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 10px 14px;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.04) !important;
    }

    .ent-mono {
        font-family: 'JetBrains Mono', monospace;
    }

    @media print {
        .no-print {
            display: none !important;
        }

        .ent-card {
            box-shadow: none !important;
        }
    }
</style>

<div class="container-fluid p-2 fs-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">

    {{-- Baris Aksi Cetak --}}
    <div class="d-flex justify-content-end align-items-center mb-3 no-print">
        <button type="button" onclick="window.print()" class="btn ent-btn btn-light border px-3 py-2 fs--1">
            <i class="fas fa-print me-1 text-primary"></i> Cetak Evaluasi
        </button>
    </div>

    {{-- CARD UTAMA EVALUASI --}}
    <div class="card ent-card mb-3">
        <div class="card-header ent-header-indigo py-3 px-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center">
                    <i class="fas fa-id-card me-2 fs-1 text-warning"></i>
                    <h6 class="mb-0 fs-1 fw-bold text-white">Detail Evaluasi Key Performance Indicator (KPI)</h6>
                </div>
                <span class="ent-badge fs--2 ent-mono" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                    <i class="far fa-calendar-alt"></i> {{ $periode }}
                </span>
            </div>
        </div>

        <div class="card-body p-3 p-md-4">

            {{-- INFORMASI PEGAWAI & HASIL SKOR --}}
            <div class="row g-3 mb-4">
                <div class="col-md-7">
                    <div class="p-3 ent-sub-box h-100">
                        <h6 class="fw-bold fs-1 mb-2">{{ $pegawai->hrm_m_pegawai_name ?? 'N/A' }}</h6>
                        <div class="opacity-75 fs--1 mb-1 ent-mono">
                            <i class="fas fa-id-badge me-2 text-primary"></i>NIP: <strong>{{ $pegawai->hrm_m_pegawai_nip ?? '-' }}</strong>
                        </div>
                        <div class="opacity-75 fs--1 mb-2">
                            <i class="fas fa-building me-2 text-primary"></i>Departemen: <strong>{{ $pegawai->hrm_departemen_name ?? '-' }}</strong>
                        </div>
                        <div class="opacity-75 fs--1">
                            <i class="far fa-calendar-check me-2 text-primary"></i>Periode Penilaian:
                            <span class="ent-badge fs--2 ent-mono ms-1" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.22);">
                                {{ $periode }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    @php
                    $cat = $rekap->hrm_kpi_rekap_cat ?? '-';
                    $catStyle = 'background: rgba(225, 29, 72, 0.2); border: 1px solid rgba(251, 113, 133, 0.4); color: #fda4af;';
                    if (str_contains($cat, 'Sangat Baik') || str_contains($cat, 'A')) {
                        $catStyle = 'background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(52, 211, 153, 0.4); color: #6ee7b7;';
                    } elseif (str_contains($cat, 'Baik') || str_contains($cat, 'B')) {
                        $catStyle = 'background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;';
                    } elseif (str_contains($cat, 'Cukup') || str_contains($cat, 'C')) {
                        $catStyle = 'background: rgba(245, 158, 11, 0.22); border: 1px solid rgba(251, 191, 36, 0.4); color: #fcd34d;';
                    }
                    @endphp
                    <div class="p-3 rounded-3 text-center text-white h-100 d-flex flex-column justify-content-center"
                        style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border: 1px solid rgba(99, 102, 241, 0.3);">
                        <span class="text-uppercase fw-bold fs--2" style="color: #94a3b8;">Total Skor Performance</span>
                        <div class="fw-bold text-white my-1 ent-mono" style="font-size: 1.5rem !important;">
                            {{ $rekap->hrm_kpi_rekap_total ?? '0' }}
                        </div>
                        <div>
                            <span class="ent-badge fs--2" style="{{ $catStyle }}">{{ $cat }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABEL RINCIAN INDIKATOR --}}
            <h6 class="fw-bold mb-2 fs-1"><i class="fas fa-list me-2 text-primary"></i>Rincian Indikator KPI</h6>
            <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                <table class="table table-hover table-custom align-middle mb-0">
                    <thead>
                        <tr class="fs--2">
                            <th class="text-center" style="width: 48px;">No</th>
                            <th style="width: 28%;">Indikator KPI</th>
                            <th class="text-center" style="width: 10%;">Bobot (%)</th>
                            <th class="text-center" style="width: 10%;">Target</th>
                            <th class="text-center" style="width: 12%;">Realisasi</th>
                            <th class="text-center" style="width: 12%;">Skor KPI</th>
                            <th style="width: 22%;">Catatan Evaluator</th>
                        </tr>
                    </thead>
                    <tbody class="fs--1">
                        @forelse($details as $index => $item)
                        <tr>
                            <td class="text-center ent-mono fw-semibold">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold fs-2">{{ $item->hrm_kpi_master_name }}</div>
                                <span class="opacity-75 fs--2 d-block">{{ $item->hrm_kpi_master_desc ?? '-' }}</span>
                            </td>
                            <td class="text-center ent-mono">
                                <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.08); border: 1px solid var(--ent-grid-border);">
                                    {{ $item->hrm_kpi_master_bobot }}%
                                </span>
                            </td>
                            <td class="text-center ent-mono fw-semibold">{{ $item->hrm_kpi_master_target }}</td>
                            <td class="text-center ent-mono fw-bold">{{ $item->hrm_kpi_pegawai_value }}</td>
                            <td class="text-center ent-mono fw-bold text-primary">{{ $item->hrm_kpi_pegawai_score }}</td>
                            <td class="fs--2 opacity-85">{{ $item->hrm_kpi_pegawai_catatan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center opacity-75 py-4 fs--1">
                                <i class="fas fa-folder-open fs-1 mb-2 d-block text-primary"></i>
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
