<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pendaftaran & Hasil Laboratorium</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .list-search-result {
            max-height: 220px;
            overflow-y: auto;
            z-index: 1050;
        }

        .table-input input,
        .table-input select {
            font-size: 0.85rem;
            padding: 0.25rem 0.5rem;
        }
    </style>
</head>

<body>

    <div class="container-fluid py-4" x-data="labModule()" x-init="initData()">

        <!-- Header & Navigasi Tab -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
            <div>
                <h3 class="fw-bold mb-1"><i class="bi bi-hospital text-primary me-2"></i>Modul Laboratorium</h3>
                <p class="text-muted small mb-0">Kelola pendaftaran order lab dan entri hasil pemeriksaan</p>
            </div>
            <div class="btn-group" role="group">
                <button type="button"
                    class="btn btn-sm"
                    :class="activeTab === 'pendaftaran' ? 'btn-primary' : 'btn-outline-primary'"
                    @click="activeTab = 'pendaftaran'">
                    <i class="bi bi-person-plus me-1"></i> Order Baru
                </button>
                <button type="button"
                    class="btn btn-sm"
                    :class="activeTab === 'pemeriksaan' ? 'btn-primary' : 'btn-outline-primary'"
                    @click="activeTab = 'pemeriksaan'">
                    <i class="bi bi-file-earmark-medical me-1"></i> Daftar & Input Hasil
                </button>
            </div>
        </div>

        <!-- TAB 1: FORM PENDAFTARAN ORDER LAB -->
        <div x-show="activeTab === 'pendaftaran'" class="row g-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title fw-bold mb-0 text-dark">
                            <i class="bi bi-1-circle text-primary me-2"></i>Pencarian Pasien
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Input Pencarian Pasien -->
                        <div class="position-relative">
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                                <input type="text"
                                    class="form-control"
                                    x-model="searchQuery"
                                    @input.debounce.300ms="searchPasien()"
                                    placeholder="Ketik No. RM, NIK, atau Nama Pasien...">
                            </div>

                            <!-- Dropdown Hasil Pencarian -->
                            <div x-show="searchResults.length > 0"
                                @click.away="searchResults = []"
                                class="list-group position-absolute w-100 shadow list-search-result mt-1">
                                <template x-for="pasien in searchResults" :key="pasien.id_master_patient">
                                    <button type="button"
                                        @click="pilihPasien(pasien)"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold" x-text="pasien.nm_pasien"></div>
                                            <small class="text-muted" x-text="'No. RM: ' + pasien.no_rkm_medis + ' | NIK: ' + (pasien.nik || '-')"></small>
                                        </div>
                                        <span class="badge bg-primary rounded-pill">Pilih <i class="bi bi-chevron-right"></i></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title fw-bold mb-0 text-dark">
                            <i class="bi bi-2-circle text-primary me-2"></i>Form Order Laboratorium
                        </h5>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="registerLabOrder()">
                            <!-- Info Pasien Terpilih -->
                            <div class="row g-3 mb-4 p-3 bg-light rounded border">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary">No. Rekam Medis</label>
                                    <input type="text" x-model="formReg.no_rkm_medis" class="form-control bg-white font-monospace fw-bold" readonly placeholder="Pilih pasien dari pencarian di atas...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary">Nama Pasien</label>
                                    <input type="text" x-model="formReg.nm_pasien" class="form-control bg-white fw-bold" readonly placeholder="Pilih pasien dari pencarian di atas...">
                                </div>
                            </div>

                            <!-- Checkbox Pilihan Paket / Jenis Pemeriksaan Lab -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Pilih Paket / Jenis Pemeriksaan Lab <span class="text-danger">*</span></label>
                                <div class="border rounded p-3 bg-light" style="max-height: 250px; overflow-y: auto;">
                                    <div class="row g-2">
                                        <template x-for="item in masterPemeriksaanList" :key="item.id">
                                            <div class="col-md-4 col-sm-6">
                                                <div class="card h-100 border-0 shadow-sm">
                                                    <div class="card-body p-2 d-flex align-items-center">
                                                        <div class="form-check w-100 mb-0">
                                                            <input class="form-check-input"
                                                                type="checkbox"
                                                                :value="item.id"
                                                                :id="'check_lab_' + item.id"
                                                                x-model="formReg.pemeriksaan_ids">
                                                            <label class="form-check-label d-flex justify-content-between align-items-center w-100 pe-2" :for="'check_lab_' + item.id">
                                                                <span class="small fw-semibold text-dark" x-text="item.nama_pemeriksaan"></span>
                                                                <span class="badge bg-secondary font-monospace" x-text="'Rp ' + Number(item.harga).toLocaleString('id-ID')"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Catatan Klinik -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Catatan Klinik / Keterangan</label>
                                <input type="text" x-model="formReg.catatan" class="form-control" placeholder="Contoh: Cito, Puasa 10 Jam, Pasien Rujukan...">
                            </div>

                            <!-- Action Button -->
                            <div class="d-flex justify-content-end">
                                <button type="submit"
                                    :disabled="loadingReg || !formReg.id_master_patient || formReg.pemeriksaan_ids.length === 0"
                                    class="btn btn-primary px-4">
                                    <span x-show="!loadingReg"><i class="bi bi-send me-1"></i> Daftarkan Order Lab</span>
                                    <span x-show="loadingReg"><span class="spinner-border spinner-border-sm me-1"></span> Memproses...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: DAFTAR ORDER & INPUT HASIL LAB -->
        <div x-show="activeTab === 'pemeriksaan'" class="row g-4">
            <!-- List Sidebar Transaksi Hari Ini -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h6 class="card-title fw-bold mb-0 text-dark"><i class="bi bi-clock-history me-2"></i>Daftar Order Hari Ini</h6>
                    </div>
                    <div class="list-group list-group-flush border-top" style="max-height: 600px; overflow-y: auto;">
                        <template x-for="order in daftarPendaftaran" :key="order.id">
                            <button type="button"
                                @click="selectOrder(order.nolab)"
                                class="list-group-item list-group-item-action p-3"
                                :class="selectedOrder && selectedOrder.nolab === order.nolab ? 'bg-primary-subtle border-start border-primary border-4' : ''">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold font-monospace text-primary" x-text="order.nolab"></span>
                                    <span class="badge"
                                        :class="{
                                          'bg-warning text-dark': order.status === 'PENDING',
                                          'bg-info text-dark': order.status === 'PROSES',
                                          'bg-success': order.status === 'SELESAI'
                                      }" x-text="order.status">
                                    </span>
                                </div>
                                <div class="fw-bold text-dark text-truncate" x-text="order.nm_pasien"></div>
                                <div class="small text-muted" x-text="'No. RM: ' + order.no_rkm_medis"></div>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Form Entry Hasil -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <template x-if="selectedOrder">
                        <div>
                            <div class="card-header bg-white py-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                                <div>
                                    <h6 class="fw-bold text-dark mb-0" x-text="selectedOrder.nm_pasien + ' (' + selectedOrder.no_rkm_medis + ')'"></h6>
                                    <small class="text-muted" x-text="'No. Lab: ' + selectedOrder.nolab + ' | Tgl: ' + selectedOrder.tanggal_daftar"></small>
                                </div>
                                <button type="button" @click="syncSysmex()" :disabled="loadingSync" class="btn btn-outline-indigo btn-sm btn-light border">
                                    <i class="bi bi-arrow-repeat text-primary me-1"></i> Sync Sysmex
                                </button>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0 table-input">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Pemeriksaan / Parameter</th>
                                                <th style="width: 150px;">Hasil</th>
                                                <th style="width: 100px;">Satuan</th>
                                                <th>Nilai Rujukan</th>
                                                <th style="width: 110px;">Flag</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="(item, index) in selectedOrder.pemeriksaan" :key="item.detail_id">
                                                <tr>
                                                    <td class="fw-semibold text-dark" x-text="item.nm_perawatan"></td>
                                                    <td>
                                                        <input type="text" class="form-control font-monospace" x-model="item.nilai">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" x-model="item.satuan">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" x-model="item.nilai_rujukan">
                                                    </td>
                                                    <td>
                                                        <select class="form-select fw-bold" x-model="item.flag">
                                                            <option value="N">N</option>
                                                            <option value="L">L</option>
                                                            <option value="H">H</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer bg-white py-3 d-flex justify-content-end">
                                <button type="button" @click="saveHasil()" :disabled="loadingSave" class="btn btn-success px-4">
                                    <span x-show="!loadingSave"><i class="bi bi-check-circle me-1"></i> Simpan Hasil Lab</span>
                                    <span x-show="loadingSave"><span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...</span>
                                </button>
                            </div>
                        </div>
                    </template>

                    <template x-if="!selectedOrder">
                        <div class="card-body text-center py-5 text-muted">
                            <i class="bi bi-file-earmark-text display-4 d-block mb-2"></i>
                            <p class="mb-0">Pilih salah satu transaksi order di sebelah kiri untuk memasukkan/melihat hasil laboratorium.</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Logika Alpine.js Integrasi API -->
    <script>
        function labModule() {
            return {
                activeTab: 'pendaftaran',
                searchQuery: '',
                searchResults: [],
                masterPemeriksaanList: [],
                daftarPendaftaran: [],
                selectedOrder: null,
                loadingReg: false,
                loadingSync: false,
                loadingSave: false,

                formReg: {
                    id_master_patient: null,
                    no_rkm_medis: '',
                    nm_pasien: '',
                    pemeriksaan_ids: [],
                    catatan: ''
                },

                initData() {
                    this.fetchMasterPemeriksaan();
                    this.fetchDaftarPendaftaran();
                },

                fetchMasterPemeriksaan() {
                    fetch('/api/lab/master-pemeriksaan')
                        .then(res => res.json())
                        .then(res => this.masterPemeriksaanList = res.data || []);
                },

                fetchDaftarPendaftaran() {
                    fetch('/api/lab/pendaftaran')
                        .then(res => res.json())
                        .then(res => this.daftarPendaftaran = res.data || []);
                },

                searchPasien() {
                    if (this.searchQuery.length < 2) {
                        this.searchResults = [];
                        return;
                    }
                    fetch(`/api/lab/pasien/search?q=${encodeURIComponent(this.searchQuery)}`)
                        .then(res => res.json())
                        .then(res => this.searchResults = res.data || []);
                },

                pilihPasien(pasien) {
                    this.formReg.id_master_patient = pasien.id_master_patient;
                    this.formReg.no_rkm_medis = pasien.no_rkm_medis;
                    this.formReg.nm_pasien = pasien.nm_pasien;
                    this.searchResults = [];
                    this.searchQuery = '';
                },

                registerLabOrder() {
                    this.loadingReg = true;
                    fetch('/api/lab/pendaftaran', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(this.formReg)
                        })
                        .then(res => res.json())
                        .then(res => {
                            this.loadingReg = false;
                            if (res.status === 'success') {
                                alert(`Order Lab Berhasil Dibuat!\nNo. Lab: ${res.nolab}`);
                                this.formReg = {
                                    id_master_patient: null,
                                    no_rkm_medis: '',
                                    nm_pasien: '',
                                    pemeriksaan_ids: [],
                                    catatan: ''
                                };
                                this.fetchDaftarPendaftaran();
                                this.activeTab = 'pemeriksaan';
                                this.selectOrder(res.nolab);
                            } else {
                                alert(res.message || 'Gagal mendaftarkan order');
                            }
                        })
                        .catch(() => this.loadingReg = false);
                },

                selectOrder(nolab) {
                    fetch(`/api/lab/pendaftaran/${nolab}`)
                        .then(res => res.json())
                        .then(res => this.selectedOrder = res.data);
                },

                syncSysmex() {
                    if (!this.selectedOrder) return;

                    this.loadingSync = true;

                    fetch('/api/lab/sync-sysmex', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                nolab: this.selectedOrder.nolab
                            })
                        })
                        .then(async res => {
                            const data = await res.json();
                            this.loadingSync = false;

                            if (res.ok && data.status === 'success') {
                                this.selectedOrder = data.data;
                                alert('Berhasil! Data dari alat Sysmex XN-500 telah ditarik dan dicocokkan.');
                            } else {
                                alert(data.message || 'Gagal melakukan sinkronisasi dengan alat Sysmex.');
                            }
                        })
                        .catch(err => {
                            this.loadingSync = false;
                            console.error(err);
                            alert('Terjadi kesalahan jaringan/server saat menarik data Sysmex.');
                        });
                },

                saveHasil() {
                    if (!this.selectedOrder) return;
                    this.loadingSave = true;
                    fetch(`/api/lab/pendaftaran/${this.selectedOrder.id}/hasil`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                nolab: this.selectedOrder.nolab,
                                pemeriksaan: this.selectedOrder.pemeriksaan
                            })
                        })
                        .then(res => res.json())
                        .then(res => {
                            this.loadingSave = false;
                            if (res.status === 'success') {
                                alert('Hasil laboratorium berhasil disimpan!');
                                this.fetchDaftarPendaftaran();
                            } else {
                                alert(res.message || 'Gagal menyimpan hasil');
                            }
                        })
                        .catch(() => this.loadingSave = false);
                }
            }
        }
    </script>
</body>

</html>
