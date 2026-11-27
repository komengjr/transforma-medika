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

    .ent-detail-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1rem;
        background-color: var(--bs-body-bg, var(--ent-surface));
        color: var(--bs-body-color, var(--ent-text));
    }

    /* Skala Font Standar: fs-2 (default), fs-1, fs--1, fs--2 */
    .ent-detail-wrapper .fs-2 {
        font-size: 1rem !important;
        line-height: 1.55;
    }

    .ent-detail-wrapper .fs-1 {
        font-size: 1.15rem !important;
        line-height: 1.4;
    }

    .ent-detail-wrapper .fs--1 {
        font-size: 0.875rem !important;
        line-height: 1.5;
    }

    .ent-detail-wrapper .fs--2 {
        font-size: 0.75rem !important;
        line-height: 1.4;
    }

    .modal-header-detail {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        position: relative;
        overflow: hidden;
    }

    .modal-header-detail::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 280px;
        height: 280px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .profile-cover-avatar {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.85);
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.25);
    }

    .profile-default-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.14);
        border: 2px solid rgba(255, 255, 255, 0.45);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.25);
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 14px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 2px 12px -2px rgba(15, 23, 42, 0.05);
        transition: all 0.2s ease;
    }

    .kpi-card:hover {
        transform: translateY(-2px);
        border-color: rgba(79, 70, 229, 0.35) !important;
        box-shadow: 0 8px 20px -4px rgba(15, 23, 42, 0.1) !important;
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

    .nav-tabs-modern {
        border-bottom: 1px solid var(--ent-grid-border) !important;
        gap: 4px;
    }

    .nav-tabs-modern .nav-link {
        border: 1px solid transparent !important;
        border-bottom: 2px solid transparent !important;
        border-radius: 10px 10px 0 0;
        opacity: 0.75;
        font-weight: 600;
        padding: 0.7rem 1.15rem;
        color: var(--bs-body-color, var(--ent-text));
        transition: all 0.2s ease;
    }

    .nav-tabs-modern .nav-link:hover {
        opacity: 1;
        background-color: rgba(79, 70, 229, 0.05);
    }

    .nav-tabs-modern .nav-link.active {
        opacity: 1;
        color: #6366f1 !important;
        background-color: rgba(79, 70, 229, 0.08) !important;
        border-bottom-color: #4f46e5 !important;
    }

    .detail-label {
        text-transform: uppercase;
        letter-spacing: 0.04em;
        opacity: 0.7;
        font-weight: 700;
        margin-bottom: 4px;
        display: block;
    }

    .detail-value {
        font-weight: 600;
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
    }

    .ent-mono {
        font-family: 'JetBrains Mono', monospace;
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
    }
</style>

@php
$cabang = Auth::user()->access_cabang ?? 'PA';
$rawFoto = $data->hrm_m_pegawai_image ?? null;
$hasFotoPegawai = false;
$fotoUrl = null;

if (!empty($rawFoto)) {
if (\Illuminate\Support\Str::startsWith($rawFoto, ['http://', 'https://'])) {
$hasFotoPegawai = true;
$fotoUrl = $rawFoto;
} else {
$cleanRaw = ltrim($rawFoto, '/');
$storageRelative = \Illuminate\Support\Str::startsWith($cleanRaw, 'storage/')
? $cleanRaw
: 'storage/pegawai/profile/' . $cabang . '/' . $cleanRaw;

if (file_exists(public_path($storageRelative))) {
$hasFotoPegawai = true;
$fotoUrl = asset($storageRelative);
} elseif (file_exists(public_path($cleanRaw))) {
$hasFotoPegawai = true;
$fotoUrl = asset($cleanRaw);
}
}
}
@endphp

<div class="modal-body p-0 ent-detail-wrapper fs-2">
    <!-- Header Banner Profil -->
    <div class="modal-header-detail text-white p-4">
        <div class="d-flex justify-content-between align-items-start position-relative" style="z-index: 2;">
            <div class="d-flex align-items-center gap-3">
                <div class="flex-shrink-0" id="detail-avatar-container">
                    @if($hasFotoPegawai)
                    <a href="{{ $fotoUrl }}" data-fancybox="profile-detail">
                        <img src="{{ $fotoUrl }}"
                            alt="{{ $data->hrm_m_pegawai_name ?? 'Foto Pegawai' }}"
                            class="rounded-circle profile-cover-avatar"
                            onerror="this.closest('#detail-avatar-container').innerHTML = '<div class=\'profile-default-avatar\'><i class=\'fas fa-user fs-1\'></i></div>';">
                    </a>
                    @else
                    <div class="profile-default-avatar">
                        <i class="fas fa-user fs-1"></i>
                    </div>
                    @endif
                </div>
                <div>
                    <h4 class="mb-1 text-white fw-bold fs-1">{{ $data->hrm_m_pegawai_name ?? '-' }}</h4>
                    <div class="mb-2 fs--1" style="color: #cbd5e1;">
                        <i class="fas fa-briefcase me-1"></i> {{ $data->hrm_departemen_name ?? 'Departemen Belum Diatur' }}
                        <span class="mx-1">•</span>
                        <i class="fas fa-id-card me-1"></i> NIP: <span class="ent-mono">{{ $data->hrm_m_pegawai_nip ?? '-' }}</span>
                    </div>
                    <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.4); color: #6ee7b7;">
                        <i class="fas fa-check-circle"></i> Pegawai Aktif
                    </span>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    </div>

    <!-- Metrics Cards Summary (KPI & Absensi) -->
    <div class="px-4 mt-3">
        <div class="row g-3">
            <div class="col-md-3 col-6">
                <div class="card ent-card kpi-card p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="detail-label fs--2">Skor KPI</div>
                            <div class="fw-bold text-primary fs-1 ent-mono">{{ $kpiSummary['skor_total'] }}</div>
                            <span class="ent-badge fs--2 mt-1" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.22);">
                                {{ $kpiSummary['kategori'] }}
                            </span>
                        </div>
                        <div class="p-2 rounded-3" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                            <i class="fas fa-chart-line fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card ent-card kpi-card p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="detail-label fs--2">Tepat Waktu</div>
                            <div class="fw-bold text-success fs-1 ent-mono">{{ $kpiSummary['tepat_waktu'] }} Hari</div>
                            <span class="opacity-75 fs--2">Bulan Ini</span>
                        </div>
                        <div class="p-2 rounded-3" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">
                            <i class="fas fa-user-clock fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card ent-card kpi-card p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="detail-label fs--2">Terlambat</div>
                            <div class="fw-bold text-warning fs-1 ent-mono">{{ $kpiSummary['terlambat'] }} Kali</div>
                            <span class="opacity-75 fs--2">Bulan Ini</span>
                        </div>
                        <div class="p-2 rounded-3" style="background: rgba(245, 158, 11, 0.12); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2);">
                            <i class="fas fa-history fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card ent-card kpi-card p-3 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="detail-label fs--2">Total Lembur</div>
                            <div class="fw-bold text-info fs-1 ent-mono">{{ $kpiSummary['overtime_hours'] }} Jam</div>
                            <span class="opacity-75 fs--2">Bulan Ini</span>
                        </div>
                        <div class="p-2 rounded-3" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.2);">
                            <i class="fas fa-business-time fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="px-4 mt-4">
        <ul class="nav nav-tabs nav-tabs-modern fs--1" id="pegawaiDetailTab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="biodata-tab" data-bs-toggle="tab" data-bs-target="#biodata-pane" type="button" role="tab">
                    <i class="fas fa-user-circle me-1"></i> Profil Lengkap
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="kpi-tab" data-bs-toggle="tab" data-bs-target="#kpi-pane" type="button" role="tab">
                    <i class="fas fa-bullseye me-1"></i> Penilaian KPI
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="absensi-tab" data-bs-toggle="tab" data-bs-target="#absensi-pane" type="button" role="tab">
                    <i class="fas fa-fingerprint me-1"></i> Riwayat Absensi
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="gaji-tab" data-bs-toggle="tab" data-bs-target="#gaji-pane" type="button" role="tab">
                    <i class="fas fa-file-invoice-dollar me-1"></i> Gaji &amp; Payroll
                </button>
            </li>
        </ul>

        <div class="tab-content py-4" id="pegawaiDetailTabContent">

            <!-- TAB 1: PROFIL LENGKAP -->
            <div class="tab-pane fade show active" id="biodata-pane" role="tabpanel">
                <div class="card ent-card p-4">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <span class="detail-label fs--2">NIK (KTP)</span>
                            <div class="detail-value fs-2 ent-mono">{{ $data->hrm_m_pegawai_nik ?? '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <span class="detail-label fs--2">Jenis Kelamin</span>
                            <div class="detail-value fs-2">{{ isset($data->hrm_m_pegawai_gender) && strtolower($data->hrm_m_pegawai_gender) == 'l' ? 'Laki-Laki' : 'Perempuan' }}</div>
                        </div>
                        <div class="col-md-4">
                            <span class="detail-label fs--2">Agama</span>
                            <div class="detail-value fs-2">{{ $data->hrm_m_pegawai_religion ?? '-' }}</div>
                        </div>

                        <div class="col-md-4">
                            <span class="detail-label fs--2">Tempat, Tanggal Lahir</span>
                            <div class="detail-value fs-2">{{ $data->hrm_m_pegawai_pob ?? '-' }}, {{ !empty($data->hrm_m_pegawai_dob) ? date('d M Y', strtotime($data->hrm_m_pegawai_dob)) : '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <span class="detail-label fs--2">No. Telepon / WhatsApp</span>
                            <div class="detail-value fs-2 text-primary ent-mono"><i class="fab fa-whatsapp me-1"></i> {{ $data->hrm_m_pegawai_phone ?? '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <span class="detail-label fs--2">Email</span>
                            <div class="detail-value fs-2">{{ $data->hrm_m_pegawai_email ?? '-' }}</div>
                        </div>

                        <!-- Informasi Penugasan -->
                        <div class="col-12 pt-3" style="border-top: 1px solid var(--ent-grid-border);">
                            <div class="ent-sub-box p-3">
                                <div class="fw-bold fs-2 mb-3"><i class="fas fa-sitemap me-2 text-primary"></i>Informasi Penugasan Departemen</div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <span class="detail-label fs--2">Departemen</span>
                                        <div class="detail-value fs-2 text-primary">{{ $data->hrm_departemen_name ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="detail-label fs--2">Lokasi Kerja</span>
                                        <div class="detail-value fs-2"><i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ $data->hrm_departemen_lokasi ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <span class="detail-label fs--2">Kepala Departemen</span>
                                        <div class="detail-value fs-2"><i class="fas fa-user-shield me-1 text-success"></i> {{ $data->nama_kepala_departemen ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 pt-3" style="border-top: 1px solid var(--ent-grid-border);">
                            <span class="detail-label fs--2">Alamat Domisili</span>
                            <div class="detail-value fs-2 fw-normal">
                                {{ $data->hrm_m_pegawai_address ?? '-' }}
                                <div class="opacity-75 fs--1 mt-1">
                                    Kecamatan: {{ $data->hrm_m_pegawai_kecamatan ?? '-' }}, Kota: {{ $data->hrm_m_pegawai_kota ?? '-' }}, Provinsi: {{ $data->hrm_m_pegawai_provinsi ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: PENILAIAN KPI -->
            <div class="tab-pane fade" id="kpi-pane" role="tabpanel">
                <div class="card ent-card p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <h6 class="fw-bold text-primary mb-0 fs-1">
                            <i class="fas fa-tasks me-2"></i>Rincian Evaluasi Indikator KPI (Periode: <span class="ent-mono">{{ $kpiRekap->hrm_kpi_rekap_periode ?? date('Y-m') }}</span>)
                        </h6>
                        <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.25);">
                            Kategori: <strong>{{ $kpiRekap->hrm_kpi_rekap_cat ?? 'N/A' }}</strong>
                        </span>
                    </div>

                    <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                        <table class="table table-hover align-middle mb-0 table-custom">
                            <thead>
                                <tr class="fs--2">
                                    <th>Indikator KPI</th>
                                    <th class="text-center">Tipe</th>
                                    <th class="text-center">Target</th>
                                    <th class="text-center">Realisasi</th>
                                    <th class="text-center">Bobot</th>
                                    <th class="text-center">Skor</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="fs--1">
                                @forelse($kpiItems as $item)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $item->hrm_kpi_master_name }}</div>
                                        <span class="opacity-75 fs--2">{{ $item->hrm_kpi_master_desc }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.08); border: 1px solid var(--ent-grid-border);">
                                            {{ ucfirst($item->hrm_kpi_master_type) }}
                                        </span>
                                    </td>
                                    <td class="text-center fw-bold ent-mono">{{ $item->hrm_kpi_master_target }}</td>
                                    <td class="text-center text-primary fw-bold ent-mono">{{ $item->hrm_kpi_pegawai_value }}</td>
                                    <td class="text-center ent-mono">{{ $item->hrm_kpi_master_bobot }}%</td>
                                    <td class="text-center fw-bold text-success ent-mono">{{ $item->hrm_kpi_pegawai_score }}</td>
                                    <td class="text-center">
                                        <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);">
                                            {{ ucfirst($item->hrm_kpi_pegawai_status ?? 'Selesai') }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 opacity-75">Belum ada rincian indikator KPI yang dinilai untuk periode ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 3: RIWAYAT ABSENSI -->
            <div class="tab-pane fade" id="absensi-pane" role="tabpanel">
                <div class="card ent-card p-3">
                    <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                        <table class="table table-hover align-middle mb-0 table-custom">
                            <thead>
                                <tr class="fs--2">
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Out</th>
                                    <th>Keterlambatan</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="fs--1">
                                @forelse($absensi as $abs)
                                <tr>
                                    <td class="fw-bold ent-mono">{{ date('d/m/Y', strtotime($abs->hrm_absensi_date)) }}</td>
                                    <td class="ent-mono">
                                        @if($abs->hrm_absensi_in)
                                        <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);">
                                            <i class="far fa-clock"></i> {{ date('H:i', strtotime($abs->hrm_absensi_in)) }}
                                        </span>
                                        @else
                                        <span class="opacity-50">-</span>
                                        @endif
                                    </td>
                                    <td class="ent-mono">
                                        @if($abs->hrm_absensi_out)
                                        <span class="ent-badge fs--2" style="background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.25);">
                                            <i class="far fa-clock"></i> {{ date('H:i', strtotime($abs->hrm_absensi_out)) }}
                                        </span>
                                        @else
                                        <span class="opacity-50">-</span>
                                        @endif
                                    </td>
                                    <td class="ent-mono">
                                        @if($abs->hrm_absensi_late_minutes > 0)
                                        <span class="text-danger fw-bold"><i class="fas fa-exclamation-circle me-1"></i> {{ $abs->hrm_absensi_late_minutes }} Mnt</span>
                                        @else
                                        <span class="text-success"><i class="fas fa-check me-1"></i> 0 Mnt</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                        $statusStyles = [
                                        'hadir' => 'background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);',
                                        'terlambat' => 'background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.28);',
                                        'dinas_luar' => 'background: rgba(2, 132, 199, 0.14); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.25);',
                                        'izin' => 'background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.25);',
                                        'sakit' => 'background: rgba(100, 116, 139, 0.14); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.25);',
                                        'cuti' => 'background: rgba(124, 58, 237, 0.14); color: #7c3aed; border: 1px solid rgba(124, 58, 237, 0.25);',
                                        'alpa' => 'background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.25);',
                                        ];
                                        $defaultStatusStyle = 'background: rgba(100, 116, 139, 0.14); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.25);';
                                        $statusKey = $abs->hrm_absensi_status ?? '';
                                        $statusStyle = isset($statusStyles[$statusKey]) ? $statusStyles[$statusKey] : $defaultStatusStyle;
                                        @endphp
                                        <span class="ent-badge fs--2" style="{{ $statusStyle }}">
                                            {{ ucfirst(str_replace('_', ' ', $abs->hrm_absensi_status)) }}
                                        </span>
                                    </td>
                                    <td class="opacity-75">{{ $abs->hrm_absensi_notes ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 opacity-75">Belum ada data absensi tercatat.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 4: GAJI & PAYROLL -->
            <div class="tab-pane fade" id="gaji-pane" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-5">
                        <div class="card ent-card p-4 h-100">
                            <h6 class="fw-bold mb-3 text-primary fs-1"><i class="fas fa-wallet me-2"></i>Komponen Gaji Pokok &amp; Tunjangan</h6>

                            <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--ent-grid-border);">
                                <span class="opacity-75 fs--1">Gaji Pokok</span>
                                <span class="fw-bold ent-mono fs--1">Rp {{ number_format($gajiPokok->gaji_pokok ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--ent-grid-border);">
                                <span class="opacity-75 fs--1">Tunjangan Jabatan</span>
                                <span class="fw-bold ent-mono fs--1">Rp {{ number_format($gajiPokok->tunjangan_jabatan ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--ent-grid-border);">
                                <span class="opacity-75 fs--1">Tunjangan Kehadiran</span>
                                <span class="fw-bold ent-mono fs--1">Rp {{ number_format($gajiPokok->tunjangan_kehadiran ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--ent-grid-border);">
                                <span class="opacity-75 fs--1">Makan &amp; Transport</span>
                                <span class="fw-bold ent-mono fs--1">Rp {{ number_format($gajiPokok->tunjangan_makan_transpor ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2" style="border-bottom: 1px solid var(--ent-grid-border);">
                                <span class="opacity-75 fs--1">Tunjangan Kinerja (KPI)</span>
                                <span class="fw-bold ent-mono fs--1">Rp {{ number_format($gajiPokok->tunjangan_kinerja_kpi ?? 0, 0, ',', '.') }}</span>
                            </div>

                            <div class="mt-3 p-3 ent-sub-box">
                                <span class="detail-label fs--2">Informasi Rekening Bank</span>
                                <div class="fw-bold mt-1 fs-2">
                                    <i class="fas fa-university me-1 text-primary"></i> {{ $gajiPokok->nama_bank ?? 'Belum Diatur' }}
                                </div>
                                <div class="opacity-75 fs--1 ent-mono">{{ $gajiPokok->nomor_rekening ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="card ent-card p-3 h-100">
                            <h6 class="fw-bold mb-3 text-primary px-2 fs-1"><i class="fas fa-history me-2"></i>Riwayat Slip Gaji (Payroll)</h6>
                            <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                                <table class="table table-hover align-middle mb-0 table-custom">
                                    <thead>
                                        <tr class="fs--2">
                                            <th>No. Slip</th>
                                            <th>Periode</th>
                                            <th>Gaji Bersih (THP)</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs--1">
                                        @forelse($payrollSlip as $slip)
                                        <tr>
                                            <td class="fw-bold text-primary ent-mono">{{ $slip->nomor_slip }}</td>
                                            <td class="ent-mono">{{ $slip->periode }}</td>
                                            <td class="fw-bold text-success ent-mono">Rp {{ number_format($slip->gaji_bersih, 0, ',', '.') }}</td>
                                            <td>
                                                @if($slip->status == 'PAID')
                                                <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);">
                                                    <i class="fas fa-check-circle"></i> Paid
                                                </span>
                                                @elseif($slip->status == 'APPROVED')
                                                <span class="ent-badge fs--2" style="background: rgba(2, 132, 199, 0.14); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.25);">
                                                    <i class="fas fa-thumbs-up"></i> Approved
                                                </span>
                                                @else
                                                <span class="ent-badge fs--2" style="background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.28);">
                                                    <i class="fas fa-clock"></i> Draft
                                                </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 opacity-75">Belum ada riwayat slip gaji.</td>
                                        </tr>
                                        @endforelse
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

<!-- Modal Footer -->
<div class="modal-footer px-4 py-3 ent-detail-wrapper fs-2" style="border-top: 1px solid var(--ent-grid-border); border-bottom-left-radius: 14px; border-bottom-right-radius: 14px;">
    <button type="button" class="btn ent-btn btn-secondary px-4 fs--1" data-bs-dismiss="modal">
        <i class="fas fa-times me-1"></i> Tutup
    </button>
</div>
