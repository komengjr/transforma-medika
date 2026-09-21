<style>
    .modal-header-detail {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .profile-cover-avatar {
        width: 85px;
        height: 85px;
        object-fit: cover;
        border: 3px solid #ffffff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .kpi-card {
        border: none;
        border-radius: 10px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
    }

    .nav-tabs-modern .nav-link {
        border: none;
        color: #64748b;
        font-weight: 600;
        padding: 0.75rem 1.25rem;
        border-bottom: 3px solid transparent;
        transition: all 0.2s ease;
    }

    .nav-tabs-modern .nav-link.active {
        color: #0d6efd;
        background: transparent;
        border-bottom-color: #0d6efd;
    }

    .detail-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        font-weight: 600;
    }

    .detail-value {
        font-size: 0.95rem;
        color: #1e293b;
        font-weight: 600;
    }
</style>

<div class="modal-body p-0 bg-light">
    <!-- Header Banner Profil -->
    <div class="modal-header-detail text-white p-4">
        <div class="d-flex justify-content-between align-items-start">
            <div class="d-flex align-items-center gap-3">
                @php
                $defaultFoto = asset('asset/img/team/avatar.png');
                $cabang = Auth::user()->access_cabang ?? 'PA';
                $fotoPath = !empty($data->hrm_m_pegawai_image)
                ? asset('storage/pegawai/profile/' . $cabang . '/' . $data->hrm_m_pegawai_image)
                : $defaultFoto;
                @endphp
                <a href="{{ $fotoPath }}" data-fancybox="profile-detail">
                    <img src="{{ $fotoPath }}" alt="{{ $data->hrm_m_pegawai_name }}" class="rounded-circle profile-cover-avatar" onerror="this.src='{{ $defaultFoto }}'">
                </a>
                <div>
                    <h4 class="mb-0 text-white fw-bold">{{ $data->hrm_m_pegawai_name ?? '-' }}</h4>
                    <p class="mb-1 text-white-50 fs--1">
                        <i class="fas fa-briefcase me-1"></i> {{ $data->hrm_departemen_name ?? 'Departemen Belum Diatur' }}
                        <span class="mx-1">•</span>
                        <i class="fas fa-id-card me-1"></i> NIP: {{ $data->hrm_m_pegawai_nip ?? '-' }}
                    </p>
                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">
                        <i class="fas fa-check-circle me-1"></i> Pegawai Aktif
                    </span>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    </div>

    <!-- Metrics Cards Summary (KPI & Absensi) -->
    <div class="px-4 mt-n3">
        <div class="row g-3">
            <div class="col-md-3 col-6">
                <div class="card kpi-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted fs--2 text-uppercase fw-bold">Skor KPI</div>
                            <h4 class="mb-0 fw-bold text-primary">{{ $kpiSummary['skor_total'] }}</h4>
                            <small class="badge bg-primary-subtle text-primary mt-1">{{ $kpiSummary['kategori'] }}</small>
                        </div>
                        <div class="bg-primary-subtle text-primary p-2 rounded-3">
                            <i class="fas fa-chart-line fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card kpi-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted fs--2 text-uppercase fw-bold">Tepat Waktu</div>
                            <h4 class="mb-0 fw-bold text-success">{{ $kpiSummary['tepat_waktu'] }} Hari</h4>
                            <small class="text-muted fs--2">Bulan Ini</small>
                        </div>
                        <div class="bg-success-subtle text-success p-2 rounded-3">
                            <i class="fas fa-user-clock fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card kpi-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted fs--2 text-uppercase fw-bold">Terlambat</div>
                            <h4 class="mb-0 fw-bold text-warning">{{ $kpiSummary['terlambat'] }} Kali</h4>
                            <small class="text-muted fs--2">Bulan Ini</small>
                        </div>
                        <div class="bg-warning-subtle text-warning p-2 rounded-3">
                            <i class="fas fa-history fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card kpi-card shadow-sm p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-muted fs--2 text-uppercase fw-bold">Total Lembur</div>
                            <h4 class="mb-0 fw-bold text-info">{{ $kpiSummary['overtime_hours'] }} Jam</h4>
                            <small class="text-muted fs--2">Bulan Ini</small>
                        </div>
                        <div class="bg-info-subtle text-info p-2 rounded-3">
                            <i class="fas fa-business-time fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="px-4 mt-4">
        <ul class="nav nav-tabs nav-tabs-modern border-bottom" id="pegawaiDetailTab" role="tablist">
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
                    <i class="fas fa-file-invoice-dollar me-1"></i> Gaji & Payroll
                </button>
            </li>
        </ul>

        <div class="tab-content py-4" id="pegawaiDetailTabContent">

            <!-- TAB 1: PROFIL LENGKAP -->
            <div class="tab-pane fade show active" id="biodata-pane" role="tabpanel">
                <div class="card border-0 shadow-sm p-4 bg-white">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="detail-label">NIK (KTP)</div>
                            <div class="detail-value">{{ $data->hrm_m_pegawai_nik ?? '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Jenis Kelamin</div>
                            <div class="detail-value">{{ isset($data->hrm_m_pegawai_gender) && strtolower($data->hrm_m_pegawai_gender) == 'l' ? 'Laki-Laki' : 'Perempuan' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Agama</div>
                            <div class="detail-value">{{ $data->hrm_m_pegawai_religion ?? '-' }}</div>
                        </div>

                        <div class="col-md-4">
                            <div class="detail-label">Tempat, Tanggal Lahir</div>
                            <div class="detail-value">{{ $data->hrm_m_pegawai_pob ?? '-' }}, {{ !empty($data->hrm_m_pegawai_dob) ? date('d M Y', strtotime($data->hrm_m_pegawai_dob)) : '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">No. Telepon / Whatsapp</div>
                            <div class="detail-value text-primary"><i class="fab fa-whatsapp me-1"></i> {{ $data->hrm_m_pegawai_phone ?? '-' }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Email</div>
                            <div class="detail-value">{{ $data->hrm_m_pegawai_email ?? '-' }}</div>
                        </div>

                        <!-- Informasi Penugasan -->
                        <div class="col-12 border-top pt-3">
                            <div class="p-3 bg-light rounded-3 border">
                                <div class="fw-bold text-dark mb-2"><i class="fas fa-sitemap me-2 text-primary"></i>Informasi Penugasan Departemen</div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="detail-label">Departemen</div>
                                        <div class="detail-value text-primary">{{ $data->hrm_departemen_name ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="detail-label">Lokasi Kerja</div>
                                        <div class="detail-value"><i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ $data->hrm_departemen_lokasi ?? '-' }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="detail-label">Kepala Departemen</div>
                                        <div class="detail-value"><i class="fas fa-user-shield me-1 text-success"></i> {{ $data->nama_kepala_departemen ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 border-top pt-3">
                            <div class="detail-label">Alamat Domisili</div>
                            <div class="detail-value fw-normal">
                                {{ $data->hrm_m_pegawai_address ?? '-' }}
                                <br><small class="text-muted">Kecamatan: {{ $data->hrm_m_pegawai_kecamatan ?? '-' }}, Kota: {{ $data->hrm_m_pegawai_kota ?? '-' }}, Provinsi: {{ $data->hrm_m_pegawai_provinsi ?? '-' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 2: PENILAIAN KPI -->
            <div class="tab-pane fade" id="kpi-pane" role="tabpanel">
                <div class="card border-0 shadow-sm p-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-primary mb-0">
                            <i class="fas fa-tasks me-2"></i>Rincian Evaluasi Indikator KPI (Periode: {{ $kpiRekap->hrm_kpi_rekap_periode ?? date('Y-m') }})
                        </h6>
                        <span class="badge bg-primary fs--1 px-3 py-2">
                            Kategori: <strong>{{ $kpiRekap->hrm_kpi_rekap_cat ?? 'N/A' }}</strong>
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 border">
                            <thead class="table-light">
                                <tr class="text-uppercase fs--2">
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
                                        <div class="fw-bold text-dark">{{ $item->hrm_kpi_master_name }}</div>
                                        <small class="text-muted">{{ $item->hrm_kpi_master_desc }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border">{{ ucfirst($item->hrm_kpi_master_type) }}</span>
                                    </td>
                                    <td class="text-center fw-bold">{{ $item->hrm_kpi_master_target }}</td>
                                    <td class="text-center text-primary fw-bold">{{ $item->hrm_kpi_pegawai_value }}</td>
                                    <td class="text-center">{{ $item->hrm_kpi_master_bobot }}%</td>
                                    <td class="text-center fw-bold text-success">{{ $item->hrm_kpi_pegawai_score }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success-subtle text-success">{{ ucfirst($item->hrm_kpi_pegawai_status ?? 'Selesai') }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Belum ada rincian indikator KPI yang dinilai untuk periode ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 3: RIWAYAT ABSENSI -->
            <div class="tab-pane fade" id="absensi-pane" role="tabpanel">
                <div class="card border-0 shadow-sm p-3 bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="text-uppercase fs--2">
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
                                    <td class="fw-bold">{{ date('d/m/Y', strtotime($abs->hrm_absensi_date)) }}</td>
                                    <td>
                                        @if($abs->hrm_absensi_in)
                                        <span class="badge bg-success-subtle text-success"><i class="far fa-clock me-1"></i> {{ date('H:i', strtotime($abs->hrm_absensi_in)) }}</span>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($abs->hrm_absensi_out)
                                        <span class="badge bg-danger-subtle text-danger"><i class="far fa-clock me-1"></i> {{ date('H:i', strtotime($abs->hrm_absensi_out)) }}</span>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($abs->hrm_absensi_late_minutes > 0)
                                        <span class="text-danger fw-bold"><i class="fas fa-exclamation-circle me-1"></i> {{ $abs->hrm_absensi_late_minutes }} Mnt</span>
                                        @else
                                        <span class="text-success"><i class="fas fa-check me-1"></i> 0 Mnt</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                        $badges = [
                                        'hadir' => 'bg-primary',
                                        'terlambat' => 'bg-warning text-dark',
                                        'dinas_luar' => 'bg-info',
                                        'izin' => 'bg-secondary',
                                        'sakit' => 'bg-dark',
                                        'cuti' => 'bg-info text-dark',
                                        'alpa' => 'bg-danger'
                                        ];
                                        @endphp
                                        <span class="badge {{ $badges[$abs->hrm_absensi_status] ?? 'bg-secondary' }}">
                                            {{ ucfirst(str_replace('_', ' ', $abs->hrm_absensi_status)) }}
                                        </span>
                                    </td>
                                    <td class="text-muted">{{ $abs->hrm_absensi_notes ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-3 text-muted">Belum ada data absensi tercatat.</td>
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
                        <div class="card border-0 shadow-sm p-4 bg-white h-100">
                            <h6 class="fw-bold mb-3 text-primary"><i class="fas fa-wallet me-2"></i>Komponen Gaji Pokok & Tunjangan</h6>

                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Gaji Pokok</span>
                                <span class="fw-bold">Rp {{ number_format($gajiPokok->gaji_pokok ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Tunjangan Jabatan</span>
                                <span class="fw-bold">Rp {{ number_format($gajiPokok->tunjangan_jabatan ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Tunjangan Kehadiran</span>
                                <span class="fw-bold">Rp {{ number_format($gajiPokok->tunjangan_kehadiran ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Makan & Transport</span>
                                <span class="fw-bold">Rp {{ number_format($gajiPokok->tunjangan_makan_transpor ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Tunjangan Kinerja (KPI)</span>
                                <span class="fw-bold">Rp {{ number_format($gajiPokok->tunjangan_kinerja_kpi ?? 0, 0, ',', '.') }}</span>
                            </div>

                            <div class="mt-3 p-3 bg-light rounded">
                                <div class="detail-label">Informasi Rekening Bank</div>
                                <div class="fw-bold text-dark mt-1">
                                    <i class="fas fa-university me-1 text-secondary"></i> {{ $gajiPokok->nama_bank ?? 'Belum Diatur' }}
                                </div>
                                <div class="text-muted fs--1">{{ $gajiPokok->nomor_rekening ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="card border-0 shadow-sm p-3 bg-white h-100">
                            <h6 class="fw-bold mb-3 text-primary px-2"><i class="fas fa-history me-2"></i>Riwayat Slip Gaji (Payroll)</h6>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr class="text-uppercase fs--2">
                                            <th>No. Slip</th>
                                            <th>Periode</th>
                                            <th>Gaji Bersih (THP)</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs--1">
                                        @forelse($payrollSlip as $slip)
                                        <tr>
                                            <td class="fw-bold text-primary">{{ $slip->nomor_slip }}</td>
                                            <td>{{ $slip->periode }}</td>
                                            <td class="fw-bold text-success">Rp {{ number_format($slip->gaji_bersih, 0, ',', '.') }}</td>
                                            <td>
                                                @if($slip->status == 'PAID')
                                                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Paid</span>
                                                @elseif($slip->status == 'APPROVED')
                                                <span class="badge bg-info"><i class="fas fa-thumbs-up me-1"></i> Approved</span>
                                                @else
                                                <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Draft</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-3 text-muted">Belum ada riwayat slip gaji.</td>
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
<div class="modal-footer px-4 py-3 bg-white border-top">
    <button type="button" class="btn btn-secondary px-4 fw-bold" data-bs-dismiss="modal">
        <i class="fas fa-times me-1"></i> Tutup
    </button>
</div>
