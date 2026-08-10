<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Add Master KPI</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-4 pb-0" id="menu-add-data-pr-all">
        <form class="row g-3 pb-3" id="form-master-kpi" method="POST">
            @csrf
            {{-- Nama KPI --}}
            <div class="col-md-12">
                <label for="nama_kpi" class="form-label text-youtube">Nama KPI</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-file-archive"></i></span>
                    <input type="text" name="nama" class="form-control form-control-lg border-start-0" id="nama_kpi" placeholder="Contoh: Ketepatan Waktu & Kehadiran" required>
                </div>
            </div>

            {{-- Bobot KPI --}}
            <div class="col-md-4">
                <label for="bobot_kpi" class="form-label">Bobot KPI (%)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                    <input type="number" step="0.01" min="0" max="100" name="bobot" class="form-control form-control-lg border-start-0" id="bobot_kpi" placeholder="Ex. 20" required>
                </div>
            </div>

            {{-- Target KPI --}}
            <div class="col-md-4">
                <label for="target_kpi" class="form-label">Target KPI</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-bullseye"></i></span>
                    <input type="number" step="0.01" name="target" class="form-control form-control-lg border-start-0" id="target_kpi" placeholder="Ex. 100" required>
                </div>
            </div>

            {{-- Departemen --}}
            <div class="col-md-4">
                <label for="departemen_kpi" class="form-label text-youtube">Posisi Departemen</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-sitemap"></i></span>
                    <select name="departemen" id="departemen_kpi" class="form-select form-select-lg single-select" required>
                        <option value="">Pilih Departemen</option>
                        @foreach ($departemen as $dep)
                        <option value="{{ $dep->hrm_departemen_code }}">{{ $dep->hrm_departemen_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- FITUR BARU: Tipe Penilaian --}}
            <div class="col-md-6">
                <label for="hrm_kpi_master_type" class="form-label text-youtube fw-bold">Tipe Penilaian</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-sliders-h"></i></span>
                    <select name="hrm_kpi_master_type" id="hrm_kpi_master_type" class="form-select form-select-lg" onchange="toggleFormulaInput(this.value)" required>
                        <option value="manual" selected>Manual (Diisi Penilai/Evaluator)</option>
                        <option value="kehadiran">Kehadiran (Otomatis dari Absensi)</option>
                        <option value="sistem">Sistem (Otomatis Perhitungan Sistem)</option>
                    </select>
                </div>
            </div>

            {{-- FITUR BARU: Formula Sistem (Dinamis Muncul) --}}
            <div class="col-md-6" id="container_formula" style="display: none;">
                <label for="hrm_kpi_master_formula" class="form-label text-youtube fw-bold">Formula Sistem</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-calculator"></i></span>
                    <select name="hrm_kpi_master_formula" id="hrm_kpi_master_formula" class="form-select form-select-lg">
                        <option value="">-- Pilih Formula Sistem --</option>
                        <option value="TOTAL_TASK_COMPLETED">Jumlah Tasks Completed (hrm_tasks)</option>
                        <option value="PUNCTUALITY_SCORE">Skor Kedisiplinan / Ketepatan Waktu</option>
                        <option value="SALES_ACHIEVEMENT">Total Pencapaian Penjualan (Sales)</option>
                    </select>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="col-12">
                <label for="desc_kpi" class="form-label text-youtube">Deskripsi KPI</label>
                <textarea class="form-control" name="desc" id="desc_kpi" placeholder="Masukkan indikator atau deskripsi penilaian KPI" rows="3"></textarea>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-master-kpi">
        <button class="btn btn-success float-end" id="button-simpan-data-master-kpi" data-code="">Simpan Data</button>
    </span>
</div>
