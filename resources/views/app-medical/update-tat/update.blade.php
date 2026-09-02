@extends('layouts.layouts')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Menu Update Data TAT</h3>

    <div id="alert-container"></div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form id="filterForm" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Tipe Tabel</label>
                    <select id="type" class="form-select">
                        <option value="lab">TAT Lab (ss_tat_v2)</option>
                        <option value="nonlab">TAT Non-Lab (ss_tat_v2_nonlab)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Tanggal Mulai</label>
                    <input type="date" id="start_date" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Tanggal Selesai</label>
                    <input type="date" id="end_date" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Filter Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Form Update -->
    <div class="card d-none" id="tableCard">
        <div class="card-header bg-white fw-bold" id="tableHeader">Data TAT</div>
        <div class="card-body">
            <form id="updateDataForm">
                @csrf
                <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                    <table class="table table-bordered table-sm align-middle text-nowrap">
                        <thead class="table-light sticky-top" id="tableHead"></thead>
                        <tbody id="tableBody"></tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-success mt-3" id="btnSubmit">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        const updateDataForm = document.getElementById('updateDataForm');
        const tableCard = document.getElementById('tableCard');
        const tableHead = document.getElementById('tableHead');
        const tableBody = document.getElementById('tableBody');
        const alertContainer = document.getElementById('alert-container');

        let currentType = 'lab';

        // Helper untuk generate input number agar lebih rapi
        const createInput = (name, val) => `<input type="number" step="0.01" style="min-width: 90px;" name="${name}" class="form-control form-control-sm" value="${val ?? ''}">`;

        // 1. Fetch Data
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();

            currentType = document.getElementById('type').value;
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            const endpoint = currentType === 'lab' ?
                `{{ route('master_tat.get_lab') }}?start_date=${startDate}&end_date=${endDate}` :
                `{{ route('master_tat.get_nonlab') }}?start_date=${startDate}&end_date=${endDate}`;

            fetch(endpoint)
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        renderTable(currentType, res.data);
                    }
                })
                .catch(err => console.error(err));
        });

        // 2. Render Seluruh Kolom Tabel
        function renderTable(type, data) {
            tableBody.innerHTML = '';
            tableHead.innerHTML = '';
            tableCard.classList.remove('d-none');

            if (data.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="25" class="text-center text-muted">Tidak ada data ditemukan.</td></tr>`;
                return;
            }

            if (type === 'lab') {
                tableHead.innerHTML = `
                <tr>
                    <th>Tanggal</th>
                    <th>FO Target Entry</th>
                    <th>FO Verif</th>
                    <th>FO Total Data</th>
                    <th>FO Pct FO</th>
                    <th>FO Pct Verif</th>
                    <th>Sampling Data</th>
                    <th>Sampling Hasil</th>
                    <th>Sampling Pct</th>
                    <th>Verif Data</th>
                    <th>Verif Hasil</th>
                    <th>Verif Pct</th>
                    <th>Pengolahan Data</th>
                    <th>Pengolahan Hasil</th>
                    <th>Pengolahan Pct</th>
                    <th>Validasi Data</th>
                    <th>Validasi Hasil</th>
                    <th>Validasi Pct</th>
                    <th>Adm Lab Data</th>
                    <th>Adm Lab Hasil</th>
                    <th>Adm Lab Pct</th>
                    <th>Full Lab Data</th>
                    <th>Full Lab Hasil</th>
                    <th>Full Lab Pct</th>
                </tr>`;

                data.forEach(item => {
                    const prefix = `data[${item.SsTatV2ID}]`;
                    tableBody.innerHTML += `
                    <tr>
                        <td class="fw-bold">${item.SsTatV2Date}</td>
                        <td>${createInput(`${prefix}[SsTatV2FoTargetEntry]`, item.SsTatV2FoTargetEntry)}</td>
                        <td>${createInput(`${prefix}[SsTatV2FoVerif]`, item.SsTatV2FoVerif)}</td>
                        <td>${createInput(`${prefix}[SsTatV2FoTotalData]`, item.SsTatV2FoTotalData)}</td>
                        <td>${createInput(`${prefix}[SsTatV2FoPctFo]`, item.SsTatV2FoPctFo)}</td>
                        <td>${createInput(`${prefix}[SsTatV2FoPctVerif]`, item.SsTatV2FoPctVerif)}</td>
                        <td>${createInput(`${prefix}[SsTatV2SamplingData]`, item.SsTatV2SamplingData)}</td>
                        <td>${createInput(`${prefix}[SsTatV2SamplingHasil]`, item.SsTatV2SamplingHasil)}</td>
                        <td>${createInput(`${prefix}[SsTatV2SamplingPct]`, item.SsTatV2SamplingPct)}</td>
                        <td>${createInput(`${prefix}[SsTatV2VerifData]`, item.SsTatV2VerifData)}</td>
                        <td>${createInput(`${prefix}[SsTatV2VerifHasil]`, item.SsTatV2VerifHasil)}</td>
                        <td>${createInput(`${prefix}[SsTatV2VerifPct]`, item.SsTatV2VerifPct)}</td>
                        <td>${createInput(`${prefix}[SsTatV2PengolahanData]`, item.SsTatV2PengolahanData)}</td>
                        <td>${createInput(`${prefix}[SsTatV2PengolahanHasil]`, item.SsTatV2PengolahanHasil)}</td>
                        <td>${createInput(`${prefix}[SsTatV2PengolahanPct]`, item.SsTatV2PengolahanPct)}</td>
                        <td>${createInput(`${prefix}[SsTatV2ValidasiData]`, item.SsTatV2ValidasiData)}</td>
                        <td>${createInput(`${prefix}[SsTatV2ValidasiHasil]`, item.SsTatV2ValidasiHasil)}</td>
                        <td>${createInput(`${prefix}[SsTatV2ValidasiPct]`, item.SsTatV2ValidasiPct)}</td>
                        <td>${createInput(`${prefix}[SsTatV2AdmLabData]`, item.SsTatV2AdmLabData)}</td>
                        <td>${createInput(`${prefix}[SsTatV2AdmLabHasil]`, item.SsTatV2AdmLabHasil)}</td>
                        <td>${createInput(`${prefix}[SsTatV2AdmLabPct]`, item.SsTatV2AdmLabPct)}</td>
                        <td>${createInput(`${prefix}[SsTatV2FullLabData]`, item.SsTatV2FullLabData)}</td>
                        <td>${createInput(`${prefix}[SsTatV2FullLabHasil]`, item.SsTatV2FullLabHasil)}</td>
                        <td>${createInput(`${prefix}[SsTatV2FullLabPct]`, item.SsTatV2FullLabPct)}</td>
                    </tr>`;
                });
            } else {
                tableHead.innerHTML = `
                <tr>
                    <th>Tanggal</th>
                    <th>Group Name</th>
                    <th>Handling Data</th>
                    <th>Handling</th>
                    <th>Handling Pct</th>
                    <th>Verifikasi Data</th>
                    <th>Verifikasi</th>
                    <th>Verifikasi Pct</th>
                    <th>Handling Img Data</th>
                    <th>Handling Img</th>
                    <th>Handling Img Pct</th>
                    <th>Validasi Data</th>
                    <th>Validasi</th>
                    <th>Validasi Pct</th>
                    <th>Terima FO Data</th>
                    <th>Terima FO</th>
                    <th>Terima FO Pct</th>
                </tr>`;

                data.forEach(item => {
                    const prefix = `data[${item.SsTatV2NonLabID}]`;
                    tableBody.innerHTML += `
                    <tr>
                        <td class="fw-bold">${item.SsTatV2NonLabDate}</td>
                        <td class="fw-semibold">${item.SsTatV2NonLabNat_GroupName ?? ''}</td>
                        <td>${createInput(`${prefix}[SsTatV2NonLabHandlingData]`, item.SsTatV2NonLabHandlingData)}</td>
                        <td>${createInput(`${prefix}[SsTatV2NonLabHandling]`, item.SsTatV2NonLabHandling)}</td>
                        <td>${createInput(`${prefix}[SsTatV2NonLabHandlingPct]`, item.SsTatV2NonLabHandlingPct)}</td>
                        <td>${createInput(`${prefix}[SsTatV2NonLabVerifikasiData]`, item.SsTatV2NonLabVerifikasiData)}</td>
                        <td>${createInput(`${prefix}[SsTatV2NonLabVerifikasi]`, item.SsTatV2NonLabVerifikasi)}</td>
                        <td>${createInput(`${prefix}[SsTatV2NonLabVerifikasiPct]`, item.SsTatV2NonLabVerifikasiPct)}</td>
                        <td>${createInput(`${prefix}[SsTatV2NonLabHandlingImageData]`, item.SsTatV2NonLabHandlingImageData)}</td>
                        <td>${createInput(`${prefix}[SsTatV2NonLabHandlingImage]`, item.SsTatV2NonLabHandlingImage)}</td>
                        <td>${createInput(`${prefix}[SsTatV2NonLabHandlingImagePct]`, item.SsTatV2NonLabHandlingImagePct)}</td>
                        <td>${createInput(`${prefix}[SsTatV2NonLabValidasiData]`, item.SsTatV2NonLabValidasiData)}</td>
                        <td>${createInput(`${prefix}[SsTatV2NonLabValidasi]`, item.SsTatV2NonLabValidasi)}</td>
                        <td>${createInput(`${prefix}[SsTatV2NonLabValidasiPct]`, item.SsTatV2NonLabValidasiPct)}</td>
                        <td>${createInput(`${prefix}[SsTatV2NonLabTerimaFoData]`, item.SsTatV2NonLabTerimaFoData)}</td>
                        <td>${createInput(`${prefix}[SsTatV2NonLabTerimaFo]`, item.SsTatV2NonLabTerimaFo)}</td>
                        <td>${createInput(`${prefix}[SsTatV2NonLabTerimaFoPct]`, item.SsTatV2NonLabTerimaFoPct)}</td>
                    </tr>`;
                });
            }
        }

        // 3. Submit Update AJAX
        updateDataForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(updateDataForm);
            const updateUrl = currentType === 'lab' ?
                `{{ route('master_tat.update_lab') }}` :
                `{{ route('master_tat.update_nonlab') }}`;

            fetch(updateUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        alertContainer.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${res.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }
                })
                .catch(err => console.error(err));
        });
    });
</script>
@endsection
