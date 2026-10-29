<div class="modal-body p-0">
    <div class="bg-dark rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">Registrasi Pasien</h4>
        <p class="fs--2 mb-0 text-warning">Support by <a class="text-warning fw-semi-bold" href="#!">Innoventra</a>
        </p>
    </div>
    <!-- 1. Banner Header Keren di atas Form -->
    <div class="alert alert-primary d-flex align-items-center mb-4 border-0 shadow-sm rounded-3" role="alert">
        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
            <i class="fas fa-hospital-user fa-lg"></i>
        </div>
        <div>
            <h6 class="mb-0 fw-bold">Modul Registrasi Pasien</h6>
            <small class="text-primary">Cari data pasien, daftar baru, atau pindai paspor dengan mudah.</small>
        </div>
    </div>

    <!-- 2. Card Form Pencarian (Lebih Bersih & Modern) -->
    <div class="card border-0 shadow-sm mb-4 rounded-3">
        <div class="card-body px-4 py-4">
            <form class="row g-3" action="#" id="form-registrasi-pasien">
                @csrf

                <!-- Input Pencarian -->
                <div class="col-md-8">
                    <label class="form-label fw-semibold text-secondary small" for="option_nama">Pencarian Data</label>
                    <div class="input-group input-group-lg shadow-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="option_nama" class="form-control border-start-0 ps-0"
                            id="option_nama" placeholder="Cth: Bambang Junaidi">
                        <input type="text" name="ss" required hidden>
                    </div>
                </div>

                <!-- Select Kategori -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary small" for="option_pencarian">Kategori Kriteria</label>
                    <div class="input-group input-group-lg shadow-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="fas fa-filter"></i>
                        </span>
                        <select name="option_pencarian" id="option_pencarian" class="form-select border-start-0" required>
                            <option value="" selected disabled>Pilih Filter...</option>
                            <option value="nama">Cari By Nama</option>
                            <option value="tanggal_lahir">Cari By Tanggal Lahir</option>
                        </select>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="col-12 mt-4 d-flex flex-wrap justify-content-between gap-3">
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-outline-primary px-4 fw-medium shadow-sm" id="button-create-data-pasien" type="button">
                            <i class="fas fa-user-plus me-2"></i><span class="d-none d-md-inline-block">Pasien Baru</span>
                        </button>
                        <button class="btn btn-outline-danger px-4 fw-medium shadow-sm" id="button-scan-data-pasien" type="button">
                            <i class="fas fa-passport me-2"></i><span class="d-none d-md-inline-block">Scan Passport</span>
                        </button>
                    </div>

                    <button class="btn btn-primary px-5 fw-bold shadow-sm" id="button-cari-data-pasien" type="button">
                        <i class="fas fa-search me-2"></i> Cari Pasien
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. Card Hasil Pencarian (Dengan Empty State yang Menarik) -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0" id="menu-registrasi-pasien" style="min-height: 300px;">

            <!-- Empty State Placeholder (Tampil sebelum ada data) -->
            <div class="d-flex flex-column align-items-center justify-content-center h-100 py-5 bg-light rounded-3">
                <div class="bg-white p-4 rounded-circle shadow-sm mb-3 mt-3">
                    <i class="fas fa-folder-open fa-3x text-muted opacity-50"></i>
                </div>
                <h6 class="fw-bold text-secondary mb-1">Belum Ada Data</h6>
                <p class="text-muted small mb-4">Hasil pencarian pasien akan tampil di sini.</p>
            </div>

        </div>
    </div>
</div>
