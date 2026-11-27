@php
    $fotoPegawai = (!empty($pegawai) && !empty($pegawai->hrm_m_pegawai_img)) ? $pegawai->hrm_m_pegawai_img : null;
    $hasFotoPegawai = false;
    $fotoPegawaiUrl = null;

    if ($fotoPegawai) {
        if (\Illuminate\Support\Str::startsWith($fotoPegawai, ['http://', 'https://'])) {
            $hasFotoPegawai = true;
            $fotoPegawaiUrl = $fotoPegawai;
        } else {
            $cleanPath = ltrim($fotoPegawai, '/');
            if (file_exists(public_path($cleanPath))) {
                $hasFotoPegawai = true;
                $fotoPegawaiUrl = asset($cleanPath);
            }
        }
    }
@endphp

<div class="ent-card fs-2" id="customersTable">

    <!-- Card Header -->
    <div class="ent-card-header px-4 py-3" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%); border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important; border-radius: 14px 14px 0 0;">
        <div class="row justify-content-between align-items-center g-2">
            <div class="col-12 col-sm-auto d-flex align-items-center">
                <div class="ent-glass-pill p-2 me-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <i class="fas fa-calendar-check text-white fs-1"></i>
                </div>
                <div>
                    <h5 class="fs-1 mb-0 text-white fw-bold">Detail Rekap Kehadiran Karyawan</h5>
                    <span class="fs--2" style="color: #cbd5e1;">
                        Periode: <strong class="text-white">{{ date('F', mktime(0, 0, 0, (int)$bulan, 1)) }} {{ $tahun }}</strong>
                    </span>
                </div>
            </div>
            <div class="col-12 col-sm-auto text-sm-end d-flex flex-wrap gap-2 justify-content-sm-end">
                <button class="btn ent-btn btn-light text-primary py-1 px-3 fs--1" type="button" onclick="location.reload()">
                    <i class="fas fa-sync-alt me-1"></i> Refresh
                </button>
                <button class="btn ent-btn btn-success text-white py-1 px-3 fs--1" type="button" id="btn-export-absensi-excel">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </button>
            </div>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">

        <!-- Profile Card Employee Info -->
        <div class="ent-sub-box p-3 p-md-4 mb-4">
            <div class="row g-3 align-items-center">

                <!-- Avatar & Identity -->
                <div class="col-md-6 col-lg-4">
                    <div class="d-flex align-items-center">
                        <div class="position-relative me-3 flex-shrink-0">
                            <div class="p-1 rounded-circle" style="border: 2px solid rgba(79, 70, 229, 0.35);">
                                @if($hasFotoPegawai)
                                    <img class="rounded-circle" src="{{ $fotoPegawaiUrl }}" width="58" height="58" alt="{{ $pegawai->hrm_m_pegawai_name ?? 'Foto Pegawai' }}" style="object-fit: cover;">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 58px; height: 58px; background: rgba(79, 70, 229, 0.12); color: #6366f1;">
                                        <i class="fas fa-user fs-1"></i>
                                    </div>
                                @endif
                            </div>
                            <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle">
                                <span class="visually-hidden">Active</span>
                            </span>
                        </div>
                        <div>
                            <div class="fw-bold fs-1 mb-1">{{ $pegawai->hrm_m_pegawai_name ?? 'Semua Karyawan' }}</div>
                            <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.22);">
                                <i class="fas fa-calendar-day me-1"></i>{{ $data }} Hari dalam Bulan Ini
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Code & NIP Info -->
                <div class="col-md-6 col-lg-4" style="border-left: 1px solid var(--ent-grid-border);">
                    <div class="ps-md-2">
                        <span class="text-uppercase opacity-75 fw-bold fs--2 d-block mb-1" style="letter-spacing: 0.04em;">Identitas Pegawai</span>
                        <div class="fw-bold fs-2 mb-1 ent-mono">{{ $pegawai->hrm_m_pegawai_code ?? '-' }}</div>
                        <div class="fs--1 opacity-75">
                            <strong>NIP:</strong>
                            <span class="ent-badge fs--2 ent-mono ms-1" style="background: rgba(79, 70, 229, 0.08); border: 1px solid var(--ent-grid-border);">
                                {{ $pegawai->hrm_m_pegawai_nip ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Work Shift Info -->
                <div class="col-md-12 col-lg-4" style="border-left: 1px solid var(--ent-grid-border);">
                    <div class="ps-lg-2">
                        <span class="text-uppercase opacity-75 fw-bold fs--2 d-block mb-1" style="letter-spacing: 0.04em;">Skema Jam Kerja Standar</span>
                        <div class="fw-bold fs-2 mb-1">{{ $jam_kerja_setting->hrm_m_jam_kerja_name ?? 'Jam Kerja Regular' }}</div>
                        <div class="text-primary fw-semibold fs--1 ent-mono d-flex align-items-center">
                            <i class="fas fa-clock me-1 fs--2"></i>
                            {{ date('H:i', strtotime($jam_kerja_setting->hrm_m_jam_kerja_in ?? '08:00:00')) }} - {{ date('H:i', strtotime($jam_kerja_setting->hrm_m_jam_kerja_out ?? '17:00:00')) }}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Attendance Data Table -->
        <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
            <table class="table table-hover align-middle table-custom fs-2" id="data-absen" style="width:100%;">
                <thead>
                    <tr class="fs--2">
                        <th>Hari</th>
                        <th>Tanggal</th>
                        <th>Jam Kerja</th>
                        <th class="text-center">Absen Masuk</th>
                        <th class="text-center">Absen Pulang</th>
                        <th class="text-center">Keterlambatan</th>
                        <th class="text-center">Jam Lembur</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                    @for ($i = 1; $i <= $data; $i++)
                        @php
                        $current_date = $date_keys[$i];
                        $record = $absensi[$current_date] ?? null;
                        $lembur_item = $data_lembur[$current_date] ?? null;
                        $isSunday = ($hari[$i] == 'Minggu');
                        $terlambat = $late_minutes_calculated[$i] ?? 0;
                        $lembur = $overtime_calculated[$i] ?? 0;
                        @endphp
                        <tr style="{{ $isSunday ? 'background-color: rgba(225, 29, 72, 0.05);' : '' }}">
                            <!-- Hari -->
                            <td class="fw-bold {{ $isSunday ? 'text-danger' : '' }}">
                                {{ $hari[$i] }}
                            </td>
                            <!-- Tanggal -->
                            <td class="text-nowrap fw-medium ent-mono">
                                {{ $tgl[$i] }}
                            </td>
                            <!-- Jam Kerja -->
                            <td class="text-nowrap ent-mono">
                                {!! $jam_kerja[$i] !!}
                            </td>
                            <!-- Absen Masuk -->
                            <td class="text-center text-nowrap ent-mono">
                                @if(!empty($record->hrm_absensi_in))
                                <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);">
                                    <i class="fas fa-sign-in-alt"></i>{{ date('H:i:s', strtotime($record->hrm_absensi_in)) }}
                                </span>
                                @else
                                <span class="opacity-50">-</span>
                                @endif
                            </td>
                            <!-- Absen Pulang -->
                            <td class="text-center text-nowrap ent-mono">
                                @if(!empty($record->hrm_absensi_out))
                                <span class="ent-badge fs--2" style="background: rgba(2, 132, 199, 0.14); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.25);">
                                    <i class="fas fa-sign-out-alt"></i>{{ date('H:i:s', strtotime($record->hrm_absensi_out)) }}
                                </span>
                                @else
                                <span class="opacity-50">-</span>
                                @endif
                            </td>
                            <!-- Keterlambatan -->
                            <td class="text-center text-nowrap ent-mono">
                                @if($terlambat > 0)
                                <span class="ent-badge fs--2" style="background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.28);">
                                    {{ $terlambat }} Menit
                                </span>
                                @else
                                <span class="opacity-50">-</span>
                                @endif
                            </td>
                            <!-- Jam Lembur -->
                            <td class="text-center text-nowrap ent-mono">
                                @if($lembur > 0)
                                <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.25);" data-bs-toggle="tooltip" title="{{ $lembur_item->hrm_lembur_keterangan ?? 'Lembur Approved' }}">
                                    <i class="fas fa-clock"></i>{{ $lembur }} Jam
                                </span>
                                @else
                                <span class="opacity-50">-</span>
                                @endif
                            </td>
                            <!-- Status Kehadiran -->
                            <td class="text-center text-nowrap">
                                @if($record)
                                    @if($terlambat > 0 && $record->hrm_absensi_status == 'hadir')
                                    <span class="ent-badge fs--2" style="background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.28);">Terlambat</span>
                                    @else
                                        @switch($record->hrm_absensi_status)
                                        @case('hadir')
                                        <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);">Hadir</span>
                                        @break
                                        @case('terlambat')
                                        <span class="ent-badge fs--2" style="background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.28);">Terlambat</span>
                                        @break
                                        @case('dinas_luar')
                                        <span class="ent-badge fs--2" style="background: rgba(2, 132, 199, 0.14); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.25);">Dinas Luar</span>
                                        @break
                                        @case('izin')
                                        <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.14); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.25);">Izin</span>
                                        @break
                                        @case('sakit')
                                        <span class="ent-badge fs--2" style="background: rgba(100, 116, 139, 0.14); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.25);">Sakit</span>
                                        @break
                                        @case('cuti')
                                        <span class="ent-badge fs--2" style="background: rgba(124, 58, 237, 0.14); color: #7c3aed; border: 1px solid rgba(124, 58, 237, 0.25);">Cuti</span>
                                        @break
                                        @case('alpa')
                                        <span class="ent-badge fs--2" style="background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.25);">Alpa</span>
                                        @break
                                        @default
                                        <span class="ent-badge fs--2" style="background: rgba(100, 116, 139, 0.14); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.25);">-</span>
                                        @endswitch
                                    @endif
                                @elseif($isSunday)
                                <span class="ent-badge fs--2" style="background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.25);">Libur</span>
                                @else
                                <span class="ent-badge fs--2" style="background: rgba(100, 116, 139, 0.14); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.25);">Belum Absen</span>
                                @endif
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
    if ($.fn.DataTable.isDataTable('#data-absen')) {
        $('#data-absen').DataTable().destroy();
    }

    new DataTable('#data-absen', {
        responsive: true,
        ordering: false,
        pageLength: 31,
        lengthMenu: [
            [10, 20, 31, -1],
            [10, 20, 31, "Semua"]
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Cari tanggal / hari...",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            paginate: {
                first: '<i class="fas fa-angle-double-left"></i>',
                last: '<i class="fas fa-angle-double-right"></i>',
                next: '<i class="fas fa-angle-right"></i>',
                previous: '<i class="fas fa-angle-left"></i>'
            }
        }
    });

    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        document.querySelectorAll('#data-absen [data-bs-toggle="tooltip"]').forEach(function(el) {
            new bootstrap.Tooltip(el);
        });
    }
</script>
