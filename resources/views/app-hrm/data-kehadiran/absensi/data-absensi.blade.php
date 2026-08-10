<div class="card border-0 shadow-sm rounded-4 overflow-hidden" id="customersTable">

    <!-- Card Header -->
    <div class="card-header py-3 px-4" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
        <div class="row flex-between-center align-items-center">
            <div class="col-12 col-sm-auto d-flex align-items-center mb-2 mb-sm-0">
                <div class="bg-white bg-opacity-20 p-2 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="fas fa-calendar-check text-white fs-0"></i>
                </div>
                <div>
                    <h5 class="fs-0 mb-0 text-white fw-bold">Detail Rekap Kehadiran Karyawan</h5>
                    <span class="fs--2 text-white-50">Periode: {{ date('F', mktime(0, 0, 0, (int)$bulan, 1)) }} {{ $tahun }}</span>
                </div>
            </div>
            <div class="col-12 col-sm-auto text-sm-end">
                <button class="btn btn-light btn-sm shadow-sm border-0 fw-semibold text-primary me-1" type="button" onclick="location.reload()">
                    <i class="fas fa-sync-alt me-1"></i> Refresh
                </button>
                <button class="btn btn-success btn-sm shadow-sm border-0 fw-semibold" type="button">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </button>
            </div>
        </div>
    </div>

    <div class="card-body p-3 p-md-4">

        <!-- Profile Card Employee Info -->
        <div class="card border-0 mb-4 rounded-4" style="background: linear-gradient(135deg, #0c75df 0%, #0578eb 100%); border: 1px solid #e2e8f0 !important;">
            <div class="card-body p-3 p-md-4">
                <div class="row g-3 align-items-center">

                    <!-- Avatar & Identity -->
                    <div class="col-md-6 col-lg-4">
                        <div class="d-flex align-items-center">
                            <div class="position-relative me-3">
                                <div class="p-1 rounded-circle" style="background: linear-gradient(135deg, #0284c7, #38bdf8); box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);">
                                    <img class="rounded-circle bg-white" src="{{ (!empty($pegawai) && !empty($pegawai->hrm_m_pegawai_img)) ? asset($pegawai->hrm_m_pegawai_img) : asset('img/pp.png') }}" width="60" height="60" alt="User Avatar" style="object-fit: cover;">
                                </div>
                                <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white rounded-circle">
                                    <span class="visually-hidden">Active</span>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-1 text-dark fw-bold fs-0">{{ $pegawai->hrm_m_pegawai_name ?? 'Semua Karyawan' }}</h6>
                                <span class="badge bg-soft-primary text-primary fw-bold rounded-pill px-2 py-1 fs--2">
                                    <i class="fas fa-calendar-day me-1"></i>{{ $data }} Hari dalam Bulan Ini
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Code & NIP Info -->
                    <div class="col-md-6 col-lg-4 border-start-md border-200">
                        <div class="ps-md-2">
                            <span class="text-uppercase text-400 fw-bold fs--2 tracking-wide d-block mb-1">Identitas Pegawai</span>
                            <h6 class="mb-1 text-dark fw-bold">{{ $pegawai->hrm_m_pegawai_code ?? '-' }}</h6>
                            <p class="mb-0 fs--1 text-600">
                                <strong>NIP :</strong> <span class="badge bg-light text-dark border font-monospace ms-1 fs--2">{{ $pegawai->hrm_m_pegawai_nip ?? '-' }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Work Shift Info -->
                    <div class="col-md-6 col-lg-4 border-start-lg border-200">
                        <div class="ps-lg-2">
                            <span class="text-uppercase text-400 fw-bold fs--2 tracking-wide d-block mb-1">Skema Jam Kerja Standar</span>
                            <h6 class="mb-1 text-dark fw-bold">{{ $jam_kerja_setting->hrm_m_jam_kerja_name ?? 'Jam Kerja Regular' }}</h6>
                            <div class="text-primary fw-medium fs--1 d-flex align-items-center">
                                <i class="fas fa-clock me-1 fs--2"></i>
                                {{ date('H:i', strtotime($jam_kerja_setting->hrm_m_jam_kerja_in ?? '08:00:00')) }} - {{ date('H:i', strtotime($jam_kerja_setting->hrm_m_jam_kerja_out ?? '17:00:00')) }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Attendance Data Table -->
        <div class="table-responsive rounded-3 border">
            <table class="table table-hover table-striped align-middle fs--1 mb-0" id="data-absen" style="width:100%;">
                <thead class="bg-light text-800 fw-bold">
                    <tr>
                        <th class="py-3 px-3 border-0">Hari</th>
                        <th class="py-3 px-3 border-0">Tanggal</th>
                        <th class="py-3 px-3 border-0">Jam Kerja</th>
                        <th class="py-3 px-3 border-0 text-center">Absen Masuk</th>
                        <th class="py-3 px-3 border-0 text-center">Absen Pulang</th>
                        <th class="py-3 px-3 border-0 text-center">Keterlambatan</th>
                        <th class="py-3 px-3 border-0 text-center">Jam Lembur</th>
                        <th class="py-3 px-3 border-0 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="text-700">
                    @for ($i = 1; $i <= $data; $i++)
                        @php
                        $current_date=$date_keys[$i];
                        $record=$absensi[$current_date] ?? null;
                        $lembur_item=$data_lembur[$current_date] ?? null;
                        $isSunday=($hari[$i]=='Minggu' );
                        $terlambat=$late_minutes_calculated[$i] ?? 0;
                        $lembur=$overtime_calculated[$i] ?? 0;
                        @endphp
                        <tr class="{{ $isSunday ? 'bg-soft-danger' : '' }}">
                        <!-- Hari -->
                        <td class="py-2 px-3 fw-bold {{ $isSunday ? 'text-danger' : 'text-dark' }}">
                            {{ $hari[$i] }}
                        </td>
                        <!-- Tanggal -->
                        <td class="py-2 px-3 white-space-nowrap fw-medium text-600">
                            {{ $tgl[$i] }}
                        </td>
                        <!-- Jam Kerja -->
                        <td class="py-2 px-3 white-space-nowrap">
                            {!! $jam_kerja[$i] !!}
                        </td>
                        <!-- Absen Masuk -->
                        <td class="py-2 px-3 text-center white-space-nowrap">
                            @if(!empty($record->hrm_absensi_in))
                            <span class="badge bg-soft-success text-success rounded-pill px-2">
                                <i class="fas fa-sign-in-alt me-1"></i>{{ date('H:i:s', strtotime($record->hrm_absensi_in)) }}
                            </span>
                            @else
                            <span class="badge bg-soft-secondary text-secondary rounded-pill px-2">-</span>
                            @endif
                        </td>
                        <!-- Absen Pulang -->
                        <td class="py-2 px-3 text-center white-space-nowrap">
                            @if(!empty($record->hrm_absensi_out))
                            <span class="badge bg-soft-info text-info rounded-pill px-2">
                                <i class="fas fa-sign-out-alt me-1"></i>{{ date('H:i:s', strtotime($record->hrm_absensi_out)) }}
                            </span>
                            @else
                            <span class="badge bg-soft-secondary text-secondary rounded-pill px-2">-</span>
                            @endif
                        </td>
                        <!-- Keterlambatan -->
                        <td class="py-2 px-3 text-center white-space-nowrap">
                            @if($terlambat > 0)
                            <span class="badge bg-soft-warning text-warning rounded-pill px-2 fw-bold">
                                {{ $terlambat }} Menit
                            </span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <!-- Jam Lembur (Dari hrm_pengajuan_lembur) -->
                        <td class="py-2 px-3 text-center white-space-nowrap">
                            @if($lembur > 0)
                            <span class="badge bg-soft-primary text-primary rounded-pill px-2 fw-bold" data-bs-toggle="tooltip" title="{{ $lembur_item->hrm_lembur_keterangan ?? 'Lembur Approved' }}">
                                <i class="fas fa-clock me-1"></i>{{ $lembur }} Jam
                            </span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <!-- Status Kehadiran -->
                        <td class="py-2 px-3 text-center white-space-nowrap">
                            @if($record)
                            @if($terlambat > 0 && $record->hrm_absensi_status == 'hadir')
                            <span class="badge bg-soft-warning text-warning rounded-pill px-2">Terlambat</span>
                            @else
                            @switch($record->hrm_absensi_status)
                            @case('hadir')
                            <span class="badge bg-soft-success text-success rounded-pill px-2">Hadir</span>
                            @break
                            @case('terlambat')
                            <span class="badge bg-soft-warning text-warning rounded-pill px-2">Terlambat</span>
                            @break
                            @case('dinas_luar')
                            <span class="badge bg-soft-info text-info rounded-pill px-2">Dinas Luar</span>
                            @break
                            @case('izin')
                            <span class="badge bg-soft-primary text-primary rounded-pill px-2">Izin</span>
                            @break
                            @case('sakit')
                            <span class="badge bg-soft-secondary text-secondary rounded-pill px-2">Sakit</span>
                            @break
                            @case('cuti')
                            <span class="badge bg-soft-dark text-dark rounded-pill px-2">Cuti</span>
                            @break
                            @case('alpa')
                            <span class="badge bg-soft-danger text-danger rounded-pill px-2">Alpa</span>
                            @break
                            @default
                            <span class="badge bg-soft-secondary text-secondary rounded-pill px-2">-</span>
                            @endswitch
                            @endif
                            @elseif($isSunday)
                            <span class="badge bg-soft-danger text-danger rounded-pill px-2">Libur</span>
                            @else
                            <span class="badge bg-soft-secondary text-secondary rounded-pill px-2">Belum Absen</span>
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
</script>
