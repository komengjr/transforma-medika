@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<style>
    .bg-gradient-payroll {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0284c7 100%) !important;
    }

    .kpi-card {
        border-radius: 12px !important;
        transition: all 0.25s ease-in-out;
    }

    .kpi-card:hover {
        transform: translateY(-3px);
    }

    .card-stat-primary {
        background: linear-gradient(135deg, rgba(14, 165, 233, 0.08) 0%, rgba(2, 132, 199, 0.02) 100%);
        border-left: 4px solid #0284c7 !important;
    }

    .card-stat-success {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(5, 150, 105, 0.02) 100%);
        border-left: 4px solid #059669 !important;
    }

    .card-stat-warning {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.08) 0%, rgba(217, 119, 6, 0.02) 100%);
        border-left: 4px solid #d97706 !important;
    }

    .icon-shape {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }
</style>
@endsection

@section('content')
{{-- Header Banner --}}
<div class="row mb-3">
    <div class="col">
        <div class="card border-0 shadow-lg bg-gradient-payroll text-white rounded-3 overflow-hidden">
            <div class="card-body p-3 p-md-4">
                <div class="row align-items-center">
                    <div class="col-md-7 d-flex align-items-center">
                        <div class="bg-white bg-opacity-20 p-2 rounded-3 me-3 backdrop-blur">
                            <img src="{{ asset('img/gl.png') }}" alt="Logo" width="45" />
                        </div>
                        <div>
                            <span class="badge bg-info bg-opacity-20 text-white px-2 py-1 mb-1 fs--2 fw-semibold">
                                <i class="fas fa-wallet me-1 text-warning"></i>Finance & Payroll
                            </span>
                            <h3 class="text-white fw-bold mb-0 fs-2">
                                {{ env('APP_LABEL', 'HRM System') }} <span class="fw-light opacity-75">Management</span>
                            </h3>
                        </div>
                    </div>
                    <div class="col-md-5 text-md-end mt-2 mt-md-0 border-start-md border-white border-opacity-20 ps-md-4">
                        <div class="text-white-50 fs--2 text-uppercase fw-semibold">Payroll Dynamic Module</div>
                        <h4 class="text-white fw-bold mb-0 fs-2">
                            Pendataan <span class="badge bg-warning text-dark ms-1 fs--2 align-middle">Gaji Pegawai</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Top Cards --}}
<div class="row g-2 mb-3">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm kpi-card card-stat-primary p-2">
            <div class="d-flex align-items-center justify-content-between px-2">
                <div>
                    <small class="text-uppercase fw-bold text-primary fs--2 d-block">Total Pegawai Terdata</small>
                    <span class="fs-2 fw-extrabold text-dark" id="statTotalPegawai">0</span>
                    <small class="text-muted fs--2 d-block">Sudah Memiliki Data Struktur</small>
                </div>
                <div class="icon-shape bg-primary text-white shadow-sm"><i class="fas fa-users-cog fa-lg"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm kpi-card card-stat-success p-2">
            <div class="d-flex align-items-center justify-content-between px-2">
                <div>
                    <small class="text-uppercase fw-bold text-success fs--2 d-block">Estimasi Pengeluaran Gaji</small>
                    <span class="fs-2 fw-extrabold text-dark" id="statTotalGaji">Rp 0</span>
                    <small class="text-muted fs--2 d-block">Total Estimasi THP Periode</small>
                </div>
                <div class="icon-shape bg-success text-white shadow-sm"><i class="fas fa-money-bill-wave fa-lg"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm kpi-card card-stat-warning p-2">
            <div class="d-flex align-items-center justify-content-between px-2">
                <div>
                    <small class="text-uppercase fw-bold text-warning fs--2 d-block">Pegawai Belum Lunas</small>
                    <span class="fs-2 fw-extrabold text-dark" id="statPendingGaji">0</span>
                    <small class="text-muted fs--2 d-block">Belum Dibayar di Periode Ini</small>
                </div>
                <div class="icon-shape bg-warning text-white shadow-sm"><i class="fas fa-user-clock fa-lg"></i></div>
            </div>
        </div>
    </div>
</div>

{{-- Filter & Actions Card (Ditambahkan Filter Bulan & Tahun) --}}
<div class="card border-0 shadow-sm rounded-3 mb-3">
    <div class="card-body p-3">
        <form id="filterGajiForm" class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="form-label fw-bold text-dark fs--2 mb-1">BULAN</label>
                <select name="bulan" id="filterBulan" class="form-select form-select-sm fs--2 shadow-none">
                    @php
                    $namaBulan = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];
                    $bulanSkrg = (int)date('m');
                    @endphp
                    @foreach($namaBulan as $num => $nama)
                    <option value="{{ $num }}" {{ $num == $bulanSkrg ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold text-dark fs--2 mb-1">TAHUN</label>
                <select name="tahun" id="filterTahun" class="form-select form-select-sm fs--2 shadow-none">
                    @php $tahunSkrg = (int)date('Y'); @endphp
                    @for($t = $tahunSkrg - 2; $t <= $tahunSkrg + 2; $t++)
                        <option value="{{ $t }}" {{ $t == $tahunSkrg ? 'selected' : '' }}>{{ $t }}</option>
                        @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-dark fs--2 mb-1">DEPARTEMEN</label>
                <select name="dept_code" id="filterDeptCode" class="form-select form-select-sm fs--2 shadow-none">
                    <option value="">-- Semua Departemen --</option>
                    @foreach($departemens as $d)
                    <option value="{{ $d->hrm_departemen_code }}">{{ $d->hrm_departemen_name }} ({{ $d->hrm_departemen_lokasi }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-bold text-dark fs--2 mb-1">CARI PEGAWAI</label>
                <input type="text" name="search" id="filterSearch" class="form-control form-control-sm fs--2 shadow-none" placeholder="Nama/NIP/NIK...">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm rounded-2 w-100 fs--2 fw-semibold">
                    <i class="fas fa-search me-1"></i>Filter
                </button>
                <button type="button" id="btnReset" class="btn btn-light border btn-sm rounded-2 fs--2 text-secondary">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button type="button" id="btnExportExcel" class="btn btn-success btn-sm rounded-2 fs--2 fw-semibold text-nowrap px-3">
                    <i class="fas fa-file-excel me-1"></i>Excel
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Main Table --}}
<div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-3">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="mb-0 fw-bold text-dark fs--2"><i class="fas fa-table text-primary me-2"></i>Master & Status Penggajian Pegawai</h6>
    </div>
    <div class="card-body p-3">
        <div class="table-responsive">
            <table id="tableMasterGaji" class="table table-hover align-middle w-100 mb-0">
                <thead>
                    <tr class="bg-light">
                        <th class="text-center fs--2 py-2" style="width: 40px;">#</th>
                        <th class="fs--2 py-2">Pegawai</th>
                        <th class="fs--2 py-2">Departemen</th>
                        <th class="text-end fs--2 py-2">Total Pendapatan</th>
                        <th class="text-end fs--2 py-2">Total Potongan</th>
                        <th class="text-end fs--2 py-2">Take Home Pay (THP)</th>
                        <th class="text-center fs--2 py-2" style="width: 120px;">Status Pembayaran</th>
                        <th class="text-center fs--2 py-2" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Dynamic Setup Gaji --}}
<div class="modal fade" id="modalSetupGaji" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-gradient-payroll text-white py-2 px-3">
                <h6 class="modal-title fw-bold text-white fs-2 mb-0">
                    <i class="fas fa-file-invoice-dollar text-warning me-2"></i>Pengaturan Finansial & Gaji Pegawai
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formSetupGaji">
                @csrf
                <input type="hidden" name="hrm_m_pegawai_code" id="inputPegawaiCode">

                <div class="modal-body p-3">
                    {{-- Pegawai Info Banner --}}
                    <div class="p-3 bg-light rounded-3 border mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="fw-bold text-dark mb-0 fs-2" id="labelNamaPegawai">-</h5>
                                <div class="text-muted fs--2">
                                    NIP: <span id="labelNipPegawai" class="fw-bold text-dark me-3">-</span>
                                    Departemen: <span id="labelDeptPegawai" class="fw-bold text-dark">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Dynamic Forms Container --}}
                    <div class="row g-3">
                        {{-- Container Pendapatan --}}
                        <div class="col-md-6 border-end">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fw-bold text-success mb-0 fs-2"><i class="fas fa-plus-circle me-1"></i>KOMPONEN PENDAPATAN</h6>
                                <span class="badge bg-success bg-opacity-10 text-success fs--2">Terisi Otomatis per Dept</span>
                            </div>
                            <div class="p-3 bg-success bg-opacity-10 rounded-3 border border-success border-opacity-25" id="containerPendapatan">
                                {{-- Loaded Dynamically via JS --}}
                            </div>
                        </div>

                        {{-- Container Potongan & Bank --}}
                        <div class="col-md-6">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="fw-bold text-danger mb-0 fs-2"><i class="fas fa-minus-circle me-1"></i>KOMPONEN POTONGAN</h6>
                                <span class="badge bg-danger bg-opacity-10 text-danger fs--2">Wajib / Opsional</span>
                            </div>
                            <div class="p-3 bg-danger bg-opacity-10 rounded-3 border border-danger border-opacity-25 mb-3" id="containerPotongan">
                                {{-- Loaded Dynamically via JS --}}
                            </div>

                            {{-- Transfer Info --}}
                            <div class="p-2 bg-light border rounded-2 mb-3">
                                <small class="fw-bold text-dark fs--2 d-block mb-1">Rekening Transfer Bank</small>
                                <div class="row g-2">
                                    <div class="col-5">
                                        <input type="text" name="nama_bank" id="nama_bank" class="form-control form-control-sm fs-2" placeholder="Nama Bank (e.g. BCA)">
                                    </div>
                                    <div class="col-7">
                                        <input type="text" name="nomor_rekening" id="nomor_rekening" class="form-control form-control-sm fs-2" placeholder="Nomor Rekening">
                                    </div>
                                </div>
                            </div>

                            {{-- Realtime THP Display --}}
                            <div class="p-3 bg-primary text-white rounded-3 text-center">
                                <span class="fs--2 text-uppercase fw-semibold text-white-50">Estimasi Take Home Pay (THP)</span>
                                <h3 class="fw-bold text-white mb-0" id="previewTakeHomePay">Rp 0</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light py-2 px-3">
                    <button type="button" class="btn btn-secondary btn-sm fs-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm fs-2 fw-semibold px-3">
                        <i class="fas fa-save me-1"></i>Simpan Master
                    </button>
                    <button type="button" id="btnSimpanCetak" class="btn btn-success btn-sm fs-2 fw-semibold px-3">
                        <i class="fas fa-print me-1"></i>Simpan & Cetak Slip
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Preview Slip Gaji --}}
<div class="modal fade" id="modalPreviewSlip" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 850px;">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-gradient-payroll text-white py-2 px-3">
                <h6 class="modal-title fw-bold text-white fs-2 mb-0">
                    <i class="fas fa-file-invoice-dollar text-warning me-2"></i>Preview Slip Gaji
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="iframePreviewSlip" src="" style="width: 100%; height: 500px; border: none;"></iframe>
            </div>
            <div class="modal-footer bg-light py-2 px-3">
                <button type="button" class="btn btn-secondary btn-sm fs-2" data-bs-dismiss="modal">Tutup</button>
                <a id="btnCetakPdfModal" href="#" target="_blank" class="btn btn-primary btn-sm fs-2 fw-semibold">
                    <i class="fas fa-print me-1"></i>Cetak / Download PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterGajiForm');
        const modalElement = new bootstrap.Modal(document.getElementById('modalSetupGaji'));
        const modalPreviewElement = new bootstrap.Modal(document.getElementById('modalPreviewSlip'));
        const formSetupGaji = document.getElementById('formSetupGaji');
        let tableGaji = null;
        let cetakSetelahSimpan = false;

        // Init load
        loadGajiData();

        // Filter events
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            loadGajiData();
        });
        document.getElementById('btnReset').addEventListener('click', function() {
            filterForm.reset();
            loadGajiData();
        });

        // Export Excel Event
        document.getElementById('btnExportExcel').addEventListener('click', function() {
            let dept = document.getElementById('filterDeptCode').value;
            let search = document.getElementById('filterSearch').value;
            let bulan = document.getElementById('filterBulan').value;
            let tahun = document.getElementById('filterTahun').value;
            window.location.href = `{{ route('payroll_data_gaji_export_excel') }}?dept_code=${dept}&search=${search}&bulan=${bulan}&tahun=${tahun}`;
        });

        // Trigger Simpan & Cetak
        document.getElementById('btnSimpanCetak').addEventListener('click', function() {
            cetakSetelahSimpan = true;
            formSetupGaji.requestSubmit();
        });

        // Load AJAX Main Table
        function loadGajiData() {
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData).toString();

            fetch(`{{ route('payroll_data_gaji_get_data') }}?${params}`)
                .then(res => res.json())
                .then(res => {
                    if (res.status) {
                        document.getElementById('statTotalPegawai').innerText = res.stats.totalPegawai;
                        document.getElementById('statTotalGaji').innerText = res.stats.totalGajiEstimasi;
                        document.getElementById('statPendingGaji').innerText = res.stats.pendingGaji;
                        renderTable(res.data);
                    }
                });
        }

        // Render Datatable
        function renderTable(data) {
            if (tableGaji) tableGaji.destroy();

            let rows = '';
            data.forEach((item, index) => {
                let thp = parseFloat(item.total_pendapatan || 0) - parseFloat(item.total_potongan || 0);

                // Badge Payment Status
                let paymentBadge = item.is_paid ?
                    `<span class="badge bg-success bg-opacity-10 text-white border border-success border-opacity-25 fs--2 px-2 py-1"><i class="fas fa-check-circle me-1"></i>PAID</span>` :
                    `<span class="badge bg-danger bg-opacity-10 text-white border border-danger border-opacity-25 fs--2 px-2 py-1"><i class="fas fa-times-circle me-1"></i>UNPAID</span>`;

                rows += `
                <tr>
                    <td class="text-center fs--2 font-monospace">${index + 1}</td>
                    <td>
                        <div class="fw-bold text-dark fs--2">${item.hrm_m_pegawai_name}</div>
                        <small class="text-muted fs--2"><i class="far fa-id-card me-1"></i>NIP: ${item.hrm_m_pegawai_nip}</small>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border fs--2">${item.hrm_departemen_name ?? '-'}</span>
                        <small class="d-block text-muted fs--2">${item.hrm_departemen_lokasi ?? ''}</small>
                    </td>
                    <td class="text-end fs--2 fw-semibold text-success">Rp ${parseFloat(item.total_pendapatan || 0).toLocaleString('id-ID')}</td>
                    <td class="text-end fs--2 text-danger">Rp ${parseFloat(item.total_potongan || 0).toLocaleString('id-ID')}</td>
                    <td class="text-end fs--2 fw-bold text-primary">Rp ${thp.toLocaleString('id-ID')}</td>
                    <td class="text-center">${paymentBadge}</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-primary fs--2 btn-setup-gaji" data-id="${item.hrm_m_pegawai_code}" title="Setup Gaji">
                                <i class="fas fa-cog"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info fs--2 btn-preview-slip" data-id="${item.hrm_m_pegawai_code}" title="Preview Slip">
                                <i class="fas fa-eye"></i>
                            </button>
                            <a href="{{ url('hrm/payroll/data-gaji/print-pdf') }}/${item.hrm_m_pegawai_code}" target="_blank" class="btn btn-sm btn-outline-danger fs--2" title="Cetak Slip PDF">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                `;
            });

            document.querySelector('#tableMasterGaji tbody').innerHTML = rows;
            tableGaji = new DataTable('#tableMasterGaji', {
                responsive: true
            });
            bindEvents();
        }

        // Bind Events (Setup & Preview)
        function bindEvents() {
            // Setup Gaji Modal Event
            document.querySelectorAll('.btn-setup-gaji').forEach(btn => {
                btn.addEventListener('click', function() {
                    let pegawaiCode = this.getAttribute('data-id');

                    fetch(`{{ url('hrm/payroll/data-gaji/get-detail') }}/${pegawaiCode}`)
                        .then(res => res.json())
                        .then(res => {
                            if (res.status) {
                                let p = res.pegawai;
                                let g = res.gaji || {};
                                let komponen = res.komponen;

                                document.getElementById('inputPegawaiCode').value = p.hrm_m_pegawai_code;
                                document.getElementById('labelNamaPegawai').innerText = p.hrm_m_pegawai_name;
                                document.getElementById('labelNipPegawai').innerText = p.hrm_m_pegawai_nip;
                                document.getElementById('labelDeptPegawai').innerText = `${p.hrm_departemen_name ?? '-'} (${p.hrm_departemen_lokasi ?? '-'})`;

                                document.getElementById('nama_bank').value = g.nama_bank ?? '';
                                document.getElementById('nomor_rekening').value = g.nomor_rekening ?? '';

                                // Render Dynamic Input Komponen Gaji
                                let htmlPendapatan = '';
                                let htmlPotongan = '';

                                komponen.forEach(k => {
                                    let val = k.nominal_default;

                                    let field = `
                                        <div class="mb-2">
                                            <label class="form-label fs--2 mb-1 fw-semibold text-dark">${k.nama_komponen}</label>
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text fs--2">Rp</span>
                                                <input type="number"
                                                       name="komponen[${k.kode_komponen}]"
                                                       class="form-control form-control-sm fs-2 hitung-gaji"
                                                       data-tipe="${k.tipe}"
                                                       value="${val}">
                                            </div>
                                        </div>
                                    `;

                                    if (k.tipe === 'pendapatan') {
                                        htmlPendapatan += field;
                                    } else {
                                        htmlPotongan += field;
                                    }
                                });

                                document.getElementById('containerPendapatan').innerHTML = htmlPendapatan || '<small class="text-muted fs--2">Tidak ada komponen pendapatan.</small>';
                                document.getElementById('containerPotongan').innerHTML = htmlPotongan || '<small class="text-muted fs--2">Tidak ada komponen potongan.</small>';

                                // Listen Input Event Live THP Calculation
                                document.querySelectorAll('.hitung-gaji').forEach(input => {
                                    input.addEventListener('input', hitungEstimasiGaji);
                                });

                                hitungEstimasiGaji();
                                modalElement.show();
                            }
                        });
                });
            });

            // Preview Slip Modal Event
            document.querySelectorAll('.btn-preview-slip').forEach(btn => {
                btn.addEventListener('click', function() {
                    let pegawaiCode = this.getAttribute('data-id');
                    let previewUrl = `{{ url('hrm/payroll/data-gaji/preview-html') }}/${pegawaiCode}`;
                    let pdfUrl = `{{ url('hrm/payroll/data-gaji/print-pdf') }}/${pegawaiCode}`;

                    document.getElementById('iframePreviewSlip').src = previewUrl;
                    document.getElementById('btnCetakPdfModal').href = pdfUrl;
                    modalPreviewElement.show();
                });
            });
        }

        // Live Realtime THP Calculation
        function hitungEstimasiGaji() {
            let totalPendapatan = 0;
            let totalPotongan = 0;

            document.querySelectorAll('.hitung-gaji').forEach(input => {
                let val = parseFloat(input.value) || 0;
                if (input.getAttribute('data-tipe') === 'pendapatan') {
                    totalPendapatan += val;
                } else {
                    totalPotongan += val;
                }
            });

            let thp = totalPendapatan - totalPotongan;
            document.getElementById('previewTakeHomePay').innerText = 'Rp ' + thp.toLocaleString('id-ID');
        }

        // Submit Form Setup Gaji
        formSetupGaji.addEventListener('submit', function(e) {
            e.preventDefault();
            fetch(`{{ route('payroll_data_gaji_store') }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: new FormData(formSetupGaji)
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status) {
                        let pegawaiCode = document.getElementById('inputPegawaiCode').value;
                        modalElement.hide();
                        loadGajiData();

                        if (cetakSetelahSimpan) {
                            window.open(`{{ url('hrm/payroll/data-gaji/print-pdf') }}/${pegawaiCode}`, '_blank');
                            cetakSetelahSimpan = false;
                        }
                    } else {
                        alert('Gagal menyimpan: ' + res.message);
                    }
                });
        });
    });
</script>
@endsection
