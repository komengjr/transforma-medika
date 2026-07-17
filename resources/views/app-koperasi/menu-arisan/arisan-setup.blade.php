@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<style>
    .month-header {
        background-color: #0099ff;
        color: white;
        font-weight: bold;
        text-align: center;
        padding: 8px;
        text-transform: uppercase;
    }

    .month-body {
        flex-grow: 1;
        padding: 10px;
    }

    .month-footer {
        background-color: #e9ecef;
        padding: 8px;
        font-size: 0.85rem;
        border-top: 1px solid #dee2e6;
    }

    .member-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px 0;
        border-bottom: 1px dashed #dee2e6;
        font-size: 0.9rem;
    }
</style>
@endsection
@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow border border-success">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3" src="{{ asset('img/koperasi.png') }}" alt="" width="60" />
                    <div>
                        <h6 class="text-success fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-success fw-bold mb-1">{{ Env('APP_LABEL')}} <span
                                class="text-success fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-success fs--1 mb-0">Menu : </h6>
                    <h4 class="text-success fw-bold mb-0">Arisan <span class="text-success fw-medium">Koperasi</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4 border-primary collapsed">
    <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#collapseMasterForm">
        <span><i class="bi bi-gear-fill me-2"></i> Buat Program Master Arisan Baru</span>
        <i class="bi bi-chevron-down"></i>
    </div>
    <div id="collapseMasterForm" class="collapse card-body">
        <form id="formMasterArisan" onsubmit="submitMasterArisan(event)" class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Kode Arisan</label>
                <input type="text" id="masterCode" class="form-control" placeholder="ARS-2026" required>
            </div>
            <div class="col-md-5">
                <label class="form-label fw-semibold">Nama Program Arisan</label>
                <input type="text" id="masterName" class="form-control" placeholder="Arisan Sejahtera Dekade I" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Nilai Rupiah per 1 Poin</label>
                <div class="input-group"><span class="input-group-text">Rp</span><input type="number" id="masterNominal" class="form-control" placeholder="50000" min="1" required></div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Tahun Mulai</label>
                <input type="number" id="thnMulai" class="form-control" value="2026" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Tahun Selesai (1 Dekade)</label>
                <input type="number" id="thnSelesai" class="form-control" value="2035" required>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Simpan & Aktifkan Program</button>
            </div>
        </form>
    </div>
</div>

<div class="card card-body shadow-sm mb-4 bg-white">
    <div class="row g-3 align-items-center">
        <div class="col-md-5">
            <label for="selectMasterArisan" class="fw-bold text-secondary mb-1"><i class="bi bi-layers-half me-1"></i> 1. Filter Pratama (Master Arisan):</label>
            <select id="selectMasterArisan" class="form-select border-primary fw-bold" onchange="handleMasterChange()">
                <option value="">-- Pilih Master Arisan --</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="filterTahun" class="fw-bold text-secondary mb-1"><i class="bi bi-calendar3 me-1"></i> 2. Pilih Tahun Jadwal:</label>
            <select id="filterTahun" class="form-select fw-bold border-primary" onchange="loadJadwalBulan()" disabled>
                <option value="">-- Pilih Master Dahulu --</option>
            </select>
        </div>
        <div class="col-md-4 text-md-end mt-4">
            <span id="badgeStatusArisan" class="badge fs-2 p-2 bg-secondary">Status: Belum Memilih</span>
        </div>
    </div>
</div>

<div class="row g-3 mb-4 d-none" id="panelInputContainer">
    <div class="col-lg-12">
        <div class="card shadow-sm border-success" id="inputCardWrapper">
            <div class="card-header bg-success text-white fw-bold d-flex justify-content-between align-items-center">
                <span><i class="bi bi-person-plus-fill me-2"></i>Plotting Anggota Baru (<span id="textInfoMode">Mode Edit Terbuka</span>)</span>
                <span class="badge bg-light text-dark" id="displayNominal">Point: -</span>
            </div>
            <div class="card-body">
                <form id="formPenjadwalan" class="row g-3" onsubmit="submitFormJadwal(event)">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Cabang</label>
                        <select id="selectCabang" class="form-select border-primary" onchange="fetchPesertaByCabang()" required>
                            <option value="">-- Pilih Cabang --</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Nama Peserta</label>
                        <select id="selectPeserta" class="form-select" disabled required>
                            <option value="">-- Pilih Cabang Dahulu --</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Bulan</label>
                        <select id="selectBulan" class="form-select" required>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Poin Diikuti</label>
                        <input type="number" id="inputPoin" class="form-control" min="1" value="5" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" id="btnSubmitJadwal" class="btn btn-success w-100 fw-bold"><i class="bi bi-calendar-plus-fill me-1"></i> Tambah</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="alertLocked" class="alert alert-danger d-none fw-bold text-center mb-0 shadow-sm">
            <i class="bi bi-lock-fill me-2"></i> JADWAL PADA PERIODE INI SUDAH BERJALAN (AKTIF). DATA DIKUNCI & TIDAK BOLEH DIUBAH LAGI.
        </div>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 row-cols-xxl-6 g-3 mb-3" id="gridBulan">

</div>
@endsection
@section('base.js')
<div class="modal fade" id="modal-koperasi-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-koperasi-full"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-koperasi" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-koperasi"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Penamaan kamus bulan global
    const namaBulan = {
        1: "Januari",
        2: "Februari",
        3: "Maret",
        4: "April",
        5: "Mei",
        6: "Juni",
        7: "Juli",
        8: "Agustus",
        9: "September",
        10: "Oktober",
        11: "November",
        12: "Desember"
    };

    let masterDataGlobal = [];
    let currentStatusMaster = 'Draft';
    let nominalPerPoin = 0;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // 1. Ambil data Konfigurasi Master Arisan & List Cabang saat dimuat
    async function initPage() {
        try {
            const res = await fetch(`{{ route('menu_koperasi_setup_arisan_get_data') }}`);
            const data = await res.json();

            masterDataGlobal = data.master_arisan_list;

            // Render dropdown Filter Pratama
            const selectMaster = document.getElementById('selectMasterArisan');
            selectMaster.innerHTML = '<option value="">-- Pilih Master Arisan --</option>';
            masterDataGlobal.forEach(m => {
                let opt = document.createElement('option');
                opt.value = m.id_kop_master_arisan;
                opt.textContent = `${m.kop_master_arisan_name} (${m.kop_master_arisan_status})`;
                selectMaster.appendChild(opt);
            });

            // Render opsi Cabang Form
            const selectCabang = document.getElementById('selectCabang');
            selectCabang.innerHTML = '<option value="">-- Pilih Cabang --</option>';
            data.cabang_list.forEach(c => {
                let opt = document.createElement('option');
                opt.value = c.kop_master_cabang_code;
                opt.textContent = `${c.kop_master_cabang_code} - ${c.kop_master_cabang_name}`;
                selectCabang.appendChild(opt);
            });
        } catch (err) {
            console.error("Gagal inisialisasi awal:", err);
        }
    }

    // 2. Aksi ketika Filter Pratama Berubah (Pilih Tahun Dekade)
    function handleMasterChange() {
        const idMaster = document.getElementById('selectMasterArisan').value;
        const selectTahun = document.getElementById('filterTahun');

        document.getElementById('panelInputContainer').classList.add('d-none');
        document.getElementById('gridBulan').innerHTML = '';

        if (!idMaster) {
            selectTahun.disabled = true;
            selectTahun.innerHTML = '<option value="">-- Pilih Master Dahulu --</option>';
            return;
        }

        // Generate list tahun 1 dekade berjalan (2026 s/d 2035)
        selectTahun.innerHTML = '<option value="">-- Pilih Tahun --</option>';
        for (let y = 2026; y <= 2035; y++) {
            let opt = document.createElement('option');
            opt.value = y;
            opt.textContent = y;
            selectTahun.appendChild(opt);
        }
        selectTahun.disabled = false;
    }

    // 3. Mengambil data peserta berdasarkan filter cabang
    async function fetchPesertaByCabang() {
        const cabang = document.getElementById('selectCabang').value;
        const selectPeserta = document.getElementById('selectPeserta');

        selectPeserta.innerHTML = '<option value="">-- Pilih Peserta --</option>';
        if (!cabang) {
            selectPeserta.disabled = true;
            return;
        }

        try {
            const res = await fetch(`{{ url('koperasi/menu-koperasi/setup-arisan/peserta-by-cabang') }}/${cabang}`);
            const data = await res.json();

            data.forEach(p => {
                let opt = document.createElement('option');
                opt.value = p.id_kop_master_peserta;
                opt.textContent = `${p.kop_master_peserta_name} (${p.kop_master_peserta_code})`;
                selectPeserta.appendChild(opt);
            });
            selectPeserta.disabled = false;
        } catch (err) {
            console.error("Gagal memuat peserta:", err);
        }
    }

    // 4. Ambil data jadwal bulanan & terapkan logika LOCKING STATUS
    async function loadJadwalBulan() {
        const idMaster = document.getElementById('selectMasterArisan').value;
        const tahun = document.getElementById('filterTahun').value;

        if (!idMaster || !tahun) return;

        document.getElementById('panelInputContainer').classList.remove('d-none');

        try {
            const res = await fetch(`{{ url('koperasi/menu-koperasi/setup-arisan/jadwal') }}?id_master=${idMaster}&tahun=${tahun}`);
            const data = await res.json();

            currentStatusMaster = data.status_master;
            nominalPerPoin = parseFloat(data.nominal_point);

            // Logika Penguncian Komponen (Locking UI)
            const badge = document.getElementById('badgeStatusArisan');
            if (currentStatusMaster === 'Aktif') {
                badge.className = "badge fs-2 p-2 bg-danger text-white";
                badge.innerHTML = `<i class="bi bi-lock-fill"></i> JADWAL JALAN (LOCKED)`;

                document.getElementById('formPenjadwalan').classList.add('d-none');
                document.getElementById('alertLocked').classList.remove('d-none');
                document.getElementById('inputCardWrapper').className = "card shadow-sm border-danger";
            } else {
                badge.className = "badge fs-2 p-2 bg-warning text-dark";
                badge.innerHTML = `<i class="bi bi-pencil-square"></i> STATUS: DRAFT (EDITABLE)`;

                document.getElementById('formPenjadwalan').classList.remove('d-none');
                document.getElementById('alertLocked').classList.add('d-none');
                document.getElementById('inputCardWrapper').className = "card shadow-sm border-success";
            }

            document.getElementById('displayNominal').innerText = `Nominal per Poin: Rp ` + new Intl.NumberFormat('id-ID').format(nominalPerPoin);

            renderGridJadwal(data.jadwal);
        } catch (err) {
            console.error("Gagal load jadwal:", err);
        }
    }

    // 5. Render Data ke grid bulanan
    function renderGridJadwal(listJadwal) {
        const gridBulan = document.getElementById('gridBulan');
        gridBulan.innerHTML = '';

        for (let b = 1; b <= 12; b++) {
            const jadwalBulanIni = listJadwal.filter(j => j.kop_jadwal_arisan_bulan == b);
            let totalPoin = 0;
            let rowsHTML = '';

            jadwalBulanIni.forEach(j => {
                totalPoin += j.kop_jadwal_arisan_point;
                const setoranIndividu = j.kop_jadwal_arisan_point * nominalPerPoin;

                // Hilangkan tombol hapus jika status master arisan 'Aktif'
                const tombolHapusHTML = (currentStatusMaster === 'Aktif') ?
                    '' :
                    `<button type="button" class="btn btn-sm text-danger p-0 border-0" onclick="hapusJadwal(${j.id_kop_jadwal_arisan})"><i class="far fa-trash-alt"></i></button>`;

                rowsHTML += `
                    <div class="member-row">
                        <div class="text-truncate" style="max-width: 70%;">
                            <strong>${j.peserta.kop_master_peserta_name}</strong><br>
                            <small class="text-muted" style="font-size:0.7rem;">${j.peserta.kop_master_peserta_cabang}</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-primary me-1">${j.kop_jadwal_arisan_point} P</span>
                            ${tombolHapusHTML}
                        </div>
                    </div>
                `;
            });

            if (jadwalBulanIni.length === 0) {
                rowsHTML = `<div class="text-center text-muted my-4" style="font-size: 0.8rem;">Belum ada antrean</div>`;
            }

            const totalSetoranBulan = totalPoin * nominalPerPoin;
            const headerColor = (currentStatusMaster === 'Aktif') ? 'bg-danger' : 'bg-primary';

            gridBulan.innerHTML += `
                <div class="col">
                    <div class="month-card shadow-sm">
                        <div class="month-header ${headerColor}">${namaBulan[b]}</div>
                        <div class="month-body">${rowsHTML}</div>
                        <div class="month-footer">
                            <div class="d-flex justify-content-between"><span>Poin:</span><strong>${totalPoin}</strong></div>
                            <div class="d-flex justify-content-between text-success"><span>Total:</span><strong>Rp ${new Intl.NumberFormat('id-ID').format(totalSetoranBulan)}</strong></div>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    // 6. Submit Plotting Jadwal Anggota
    async function submitFormJadwal(event) {
        event.preventDefault();
        const idMaster = document.getElementById('selectMasterArisan').value;

        const payload = {
            id_kop_master_arisan: parseInt(idMaster),
            id_kop_master_peserta: parseInt(document.getElementById('selectPeserta').value),
            kop_jadwal_arisan_bulan: parseInt(document.getElementById('selectBulan').value),
            kop_jadwal_arisan_tahun: parseInt(document.getElementById('filterTahun').value),
            kop_jadwal_arisan_point: parseInt(document.getElementById('inputPoin').value)
        };

        try {
            const res = await fetch(`{{ route('menu_koperasi_setup_arisan_get_jadwal_store') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                body: JSON.stringify(payload)
            });
            const result = await res.json();

            if (res.ok) {
                document.getElementById('selectPeserta').value = "";
                loadJadwalBulan();
            } else {
                alert(result.message || 'Gagal menyimpan.');
            }
        } catch (err) {
            alert('Terjadi kesalahan koneksi.');
        }
    }

    // 7. Hapus Jadwal Anggota
    async function hapusJadwal(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus peserta ini?')) return;
        try {
            const res = await fetch(`{{ url('koperasi/menu-koperasi/setup-arisan/jadwal/delete') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                }
            });
            if (res.ok) {
                loadJadwalBulan();
            } else {
                alert('Gagal menghapus.');
            }
        } catch (err) {
            console.error(err);
        }
    }

    // 8. Tambah Master Arisan Baru via Panel Atas
    async function submitMasterArisan(event) {
        event.preventDefault();
        const payload = {
            kop_master_arisan_code: document.getElementById('masterCode').value.trim(),
            kop_master_arisan_name: document.getElementById('masterName').value.trim(),
            kop_master_arisan_nominal_point: parseFloat(document.getElementById('masterNominal').value),
            kop_master_arisan_thn_mulai: parseInt(document.getElementById('thnMulai').value),
            kop_master_arisan_thn_selesai: parseInt(document.getElementById('thnSelesai').value),
        };

        try {
            const res = await fetch(`{{ route('menu_koperasi_setup_arisan_save_master_arisan') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify(payload)
            });
            const result = await res.json();
            if (res.ok) {
                alert(result.message);
                document.getElementById('formMasterArisan').reset();
                initPage();
            } else {
                alert(result.message || 'Gagal menyimpan.');
            }
        } catch (err) {
            alert('Terjadi kesalahan.');
        }
    }

    window.onload = initPage;
</script>

@endsection
