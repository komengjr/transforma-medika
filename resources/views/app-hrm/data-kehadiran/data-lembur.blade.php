@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

@section('content')
<!-- Banner Header -->
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow border border-primary bg-primary">
            <div class="row gx-0 flex-between-center" style="color: white !important;">
                <div class="col-sm-auto d-flex align-items-center border-bottom border-sm-0">
                    <img class="ms-3 mx-3 m-2" src="{{ asset('img/app.png') }}" alt="" width="50" />
                    <div>
                        <h6 class="text-white fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-white fw-bold mb-1">{{ env('APP_NAME') }} <span class="text-white fw-medium">Management System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block" src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-white fs--1 mb-0">Menu : </h6>
                    <h4 class="text-white fw-bold mb-0">Pengajuan <span class="text-white fw-medium">Lembur Karyawan</span></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Card -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-light py-3">
        <h6 class="mb-0 text-700 fw-bold"><i class="fas fa-filter me-2 text-primary"></i>Filter Data Lembur Karyawan</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('lembur.index') }}" method="GET" id="form-filter">
            <div class="row g-3 align-items-end">
                <!-- Filter Nama Pegawai -->
                <div class="col-md-5">
                    <label class="form-label fw-semibold text-700">Pilih Pegawai</label>
                    <select name="pegawai_code" id="select-pegawai" class="form-select select2" required>
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach ($list_pegawai as $peg)
                        <option value="{{ $peg->hrm_m_pegawai_code }}" {{ request('pegawai_code') == $peg->hrm_m_pegawai_code ? 'selected' : '' }}>
                            {{ $peg->hrm_m_pegawai_code }} - {{ $peg->hrm_m_pegawai_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Bulan -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-700">Bulan</label>
                    <select name="bulan" class="form-select">
                        @foreach(range(1, 12) as $m)
                        @php $m_val = sprintf('%02d', $m); @endphp
                        <option value="{{ $m_val }}" {{ request('bulan', date('m')) == $m_val ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Tahun -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold text-700">Tahun</label>
                    <select name="tahun" class="form-select">
                        @foreach(range(date('Y') - 1, date('Y') + 1) as $y)
                        <option value="{{ $y }}" {{ request('tahun', date('Y')) == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>
                    <a href="{{ route('lembur.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Data Table Card -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="text-white mb-0 fw-bold">
                <i class="fas fa-clock me-2"></i>Daftar Riwayat Lembur
            </h5>
            <button class="btn btn-light btn-sm text-primary fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-lembur-xl">
                <i class="fas fa-plus-circle me-1"></i> Ajukan Lembur
            </button>
        </div>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="table-responsive">
            <table class="table align-middle table-hover table-striped text-center border" id="table-lembur" style="width:100%;">
                <thead class="bg-light text-800 fw-bold">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Tanggal</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Total Jam</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list_lembur as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ date('d M Y', strtotime($item->hrm_lembur_date)) }}</td>
                        <td>{{ date('H:i', strtotime($item->hrm_lembur_start)) }}</td>
                        <td>{{ date('H:i', strtotime($item->hrm_lembur_end)) }}</td>
                        <td>
                            <span class="fw-bold text-primary">{{ (float)$item->hrm_lembur_total_hours }} Jam</span>
                        </td>
                        <td class="text-start">{{ $item->hrm_lembur_keterangan ?? '-' }}</td>
                        <td>
                            @switch(strtolower($item->hrm_lembur_status))
                            @case('approved')
                            <span class="badge bg-soft-success text-success rounded-pill px-3 py-1 fw-bold">Disetujui</span>
                            @break
                            @case('pending')
                            <span class="badge bg-soft-warning text-warning rounded-pill px-3 py-1 fw-bold">Menunggu</span>
                            @break
                            @case('rejected')
                            <span class="badge bg-soft-danger text-danger rounded-pill px-3 py-1 fw-bold">Ditolak</span>
                            @break
                            @default
                            <span class="badge bg-soft-secondary text-secondary rounded-pill px-3 py-1">{{ ucfirst($item->hrm_lembur_status) }}</span>
                            @endswitch
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fas fa-info-circle me-1"></i> Data lembur tidak ditemukan. Silakan pilih pegawai/periode filter di atas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Summary Widgets -->
<div class="row mt-3 g-3">
    <div class="col-md-6">
        <div class="card text-center p-3 shadow-sm border-0 border-start border-4 border-primary">
            <h6 class="text-muted mb-1 fs--1 text-uppercase fw-semibold">Total Jam Lembur Disetujui (Bulan Ini)</h6>
            <h3 class="fw-bold text-primary mb-0">{{ $total_jam_approved ?? 0 }} Jam</h3>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-center p-3 shadow-sm border-0 border-start border-4 border-success">
            <h6 class="text-muted mb-1 fs--1 text-uppercase fw-semibold">Total Pengajuan Lembur</h6>
            <h3 class="fw-bold text-success mb-0">{{ count($list_lembur) }} Kali</h3>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<!-- Modal Ajukan Lembur -->
<div class="modal fade" id="modal-lembur-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalLemburLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
                    <h4 class="mb-1 text-white" id="modalLemburLabel">Ajukan Lembur Karyawan</h4>
                    <p class="fs--2 mb-0 text-white-50">Support by Transforma</p>
                </div>
                <form action="{{ route('lembur.store') }}" method="POST" class="p-4" id="form-ajukan-lembur">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pegawai</label>
                        <select name="hrm_m_pegawai_code" class="form-select select2-modal" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach ($list_pegawai as $peg)
                            <option value="{{ $peg->hrm_m_pegawai_code }}">
                                {{ $peg->hrm_m_pegawai_code }} - {{ $peg->hrm_m_pegawai_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Lembur</label>
                        <input type="date" name="hrm_lembur_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jam Mulai</label>
                            <input type="time" name="hrm_lembur_start" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jam Selesai</label>
                            <input type="time" name="hrm_lembur_end" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan Pekerjaan</label>
                        <textarea name="hrm_lembur_keterangan" class="form-control" rows="3" placeholder="Tuliskan alasan/kegiatan lembur..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i> Kirim Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS Libraries -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTable
        if ($.fn.DataTable.isDataTable('#table-lembur')) {
            $('#table-lembur').DataTable().destroy();
        }

        $('#table-lembur').DataTable({
            responsive: true,
            ordering: false,
            pageLength: 10,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari riwayat lembur...",
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

        // Inisialisasi Select2
        $('.select2').select2({
            theme: 'bootstrap-5',
            width: '100%'
        });

        $('.select2-modal').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#modal-lembur-xl'),
            width: '100%'
        });
    });
</script>
@endsection
