<style>
    .ent-modal-wrap {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1rem;
        background-color: var(--bs-body-bg, var(--ent-surface, #ffffff));
        color: var(--bs-body-color, var(--ent-text, #0f172a));
        border-radius: 14px;
        overflow: hidden;
    }

    .ent-modal-wrap .fs-2 {
        font-size: 1rem !important;
        line-height: 1.55;
    }

    .ent-modal-wrap .fs-1 {
        font-size: 1.15rem !important;
        line-height: 1.4;
    }

    .ent-modal-wrap .fs--1 {
        font-size: 0.875rem !important;
        line-height: 1.5;
    }

    .ent-modal-wrap .fs--2 {
        font-size: 0.75rem !important;
        line-height: 1.4;
    }

    .ent-modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        position: relative;
        overflow: hidden;
    }

    .ent-modal-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 240px;
        height: 240px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-modal-group .input-group-text {
        border: 1px solid var(--ent-grid-border, rgba(99, 102, 241, 0.16)) !important;
        border-right: 0 !important;
        border-radius: 10px 0 0 10px !important;
        background-color: rgba(79, 70, 229, 0.06) !important;
        color: #6366f1 !important;
        padding: 0 14px;
    }

    .ent-modal-group .form-control,
    .ent-modal-group .form-select {
        min-height: 44px;
        border: 1px solid var(--ent-grid-border, rgba(99, 102, 241, 0.16)) !important;
        border-radius: 0 10px 10px 0 !important;
        background-color: var(--bs-body-bg, var(--ent-surface, #ffffff)) !important;
        color: var(--bs-body-color, var(--ent-text, #0f172a)) !important;
        font-size: 1rem !important;
    }

    .ent-modal-textarea {
        border: 1px solid var(--ent-grid-border, rgba(99, 102, 241, 0.16)) !important;
        border-radius: 10px !important;
        background-color: var(--bs-body-bg, var(--ent-surface, #ffffff)) !important;
        color: var(--bs-body-color, var(--ent-text, #0f172a)) !important;
        font-size: 1rem !important;
        padding: 10px 14px !important;
    }

    .ent-modal-group .form-control:focus,
    .ent-modal-group .form-select:focus,
    .ent-modal-textarea:focus {
        border-color: #4f46e5 !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12) !important;
        outline: none;
    }

    .ent-modal-footer {
        background-color: rgba(79, 70, 229, 0.04);
        border-top: 1px solid var(--ent-grid-border, rgba(99, 102, 241, 0.14));
    }

    .ent-mono {
        font-family: 'JetBrains Mono', monospace;
    }
</style>

<div class="ent-modal-wrap fs-2">
    <div class="modal-body p-0">
        <!-- Header Modal -->
        <div class="ent-modal-header px-4 py-3 text-white">
            <div class="d-flex justify-content-between align-items-center position-relative" style="z-index: 2;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width: 44px; height: 44px; border-radius: 12px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.16);">
                        <i class="fas fa-bullseye text-white fs-1"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge rounded-pill fs--2 text-uppercase"
                                style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                                Master KPI
                            </span>
                            <span class="fs--2" style="color: #94a3b8;">Support by <strong class="text-white">Transforma</strong></span>
                        </div>
                        <h4 class="mb-0 fw-bold fs-1 text-white" id="staticBackdropLabel">Form Add Master KPI</h4>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>

        <!-- Form Body -->
        <div class="p-4" id="menu-add-data-pr-all">
            <form class="row g-3" id="form-master-kpi" method="POST">
                @csrf

                {{-- Nama KPI --}}
                <div class="col-md-12">
                    <label for="nama_kpi" class="form-label fw-bold fs--1 mb-1">
                        Nama KPI <span class="text-danger">*</span>
                    </label>
                    <div class="input-group ent-modal-group">
                        <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                        <input type="text" name="nama" class="form-control fs-2" id="nama_kpi" placeholder="Contoh: Ketepatan Waktu & Kehadiran" required>
                    </div>
                </div>

                {{-- Bobot KPI --}}
                <div class="col-md-4">
                    <label for="bobot_kpi" class="form-label fw-bold fs--1 mb-1">
                        Bobot KPI (%) <span class="text-danger">*</span>
                    </label>
                    <div class="input-group ent-modal-group">
                        <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                        <input type="number" step="0.01" min="0" max="100" name="bobot" class="form-control ent-mono fs-2" id="bobot_kpi" placeholder="Ex. 20" required>
                    </div>
                </div>

                {{-- Target KPI --}}
                <div class="col-md-4">
                    <label for="target_kpi" class="form-label fw-bold fs--1 mb-1">
                        Target KPI <span class="text-danger">*</span>
                    </label>
                    <div class="input-group ent-modal-group">
                        <span class="input-group-text"><i class="fas fa-bullseye"></i></span>
                        <input type="number" step="0.01" name="target" class="form-control ent-mono fs-2" id="target_kpi" placeholder="Ex. 100" required>
                    </div>
                </div>

                {{-- Departemen --}}
                <div class="col-md-4">
                    <label for="departemen_kpi" class="form-label fw-bold fs--1 mb-1">
                        Posisi Departemen <span class="text-danger">*</span>
                    </label>
                    <div class="input-group ent-modal-group">
                        <span class="input-group-text"><i class="fas fa-sitemap"></i></span>
                        <select name="departemen" id="departemen_kpi" class="form-select single-select fs-2" required>
                            <option value="">Pilih Departemen</option>
                            @foreach ($departemen as $dep)
                            <option value="{{ $dep->hrm_departemen_code }}">{{ $dep->hrm_departemen_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Tipe Penilaian --}}
                <div class="col-md-6">
                    <label for="hrm_kpi_master_type" class="form-label fw-bold fs--1 mb-1">
                        Tipe Penilaian <span class="text-danger">*</span>
                    </label>
                    <div class="input-group ent-modal-group">
                        <span class="input-group-text"><i class="fas fa-sliders-h"></i></span>
                        <select name="hrm_kpi_master_type" id="hrm_kpi_master_type" class="form-select fs-2" onchange="toggleFormulaInput(this.value)" required>
                            <option value="manual" selected>Manual (Diisi Penilai/Evaluator)</option>
                            <option value="kehadiran">Kehadiran (Otomatis dari Absensi)</option>
                            <option value="sistem">Sistem (Otomatis Perhitungan Sistem)</option>
                        </select>
                    </div>
                </div>

                {{-- Formula Sistem (Dinamis Muncul) --}}
                <div class="col-md-6" id="container_formula" style="display: none;">
                    <label for="hrm_kpi_master_formula" class="form-label fw-bold fs--1 mb-1">
                        Formula Sistem <span class="text-danger">*</span>
                    </label>
                    <div class="input-group ent-modal-group">
                        <span class="input-group-text"><i class="fas fa-calculator"></i></span>
                        <select name="hrm_kpi_master_formula" id="hrm_kpi_master_formula" class="form-select fs-2">
                            <option value="">-- Pilih Formula Sistem --</option>
                            <option value="TOTAL_TASK_COMPLETED">Jumlah Tasks Completed (hrm_tasks)</option>
                            <option value="PUNCTUALITY_SCORE">Skor Kedisiplinan / Ketepatan Waktu</option>
                            <option value="SALES_ACHIEVEMENT">Total Pencapaian Penjualan (Sales)</option>
                        </select>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="col-12">
                    <label for="desc_kpi" class="form-label fw-bold fs--1 mb-1">Deskripsi KPI</label>
                    <textarea class="form-control ent-modal-textarea fs-2" name="desc" id="desc_kpi" placeholder="Masukkan indikator atau deskripsi penilaian KPI" rows="3"></textarea>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Footer -->
    <div class="modal-footer ent-modal-footer px-4 py-3 d-flex justify-content-between align-items-center">
        <button type="button" class="btn ent-btn btn-light border px-3 fs--1" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Batal
        </button>
        <span id="menu-add-data-master-kpi">
            <button type="button" class="btn ent-btn btn-success px-4 fs--1" id="button-simpan-data-master-kpi" data-code="">
                <i class="fas fa-save me-1"></i> Simpan Data
            </button>
        </span>
    </div>
</div>
