<style>
    .ent-import-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
        color: #ffffff;
    }

    .ent-import-form .ent-section-title {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #4f46e5;
        display: flex;
        align-items: center;
        gap: 8px;
        padding-bottom: 6px;
        border-bottom: 1px dashed rgba(99, 102, 241, 0.3);
        margin-bottom: 12px;
    }

    .ent-import-form .ent-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 5px;
    }

    .ent-import-form .input-group-text {
        background-color: rgba(79, 70, 229, 0.08);
        border: 1px solid rgba(99, 102, 241, 0.28);
        border-right: none;
        border-radius: 10px 0 0 10px !important;
        color: #4f46e5;
        font-size: 0.85rem;
        min-width: 38px;
        justify-content: center;
    }

    .ent-import-form .form-control,
    .ent-import-form .form-select {
        border: 1px solid rgba(99, 102, 241, 0.28) !important;
        border-radius: 0 10px 10px 0 !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .ent-import-form .form-control:focus,
    .ent-import-form .form-select:focus {
        border-color: #4f46e5 !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.14) !important;
    }

    .ent-file-dropzone {
        border: 1.5px dashed rgba(79, 70, 229, 0.45);
        background-color: rgba(79, 70, 229, 0.04);
        border-radius: 12px;
        padding: 14px 16px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .ent-file-dropzone:hover {
        border-color: #4f46e5;
        background-color: rgba(79, 70, 229, 0.08);
    }

    .ent-btn-import {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        border-radius: 10px;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.82rem;
        padding: 9px 18px;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.28);
        transition: all 0.18s ease;
    }

    .ent-btn-import:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.38);
        color: #ffffff;
    }
</style>

<div class="modal-body p-0">
    <!-- HEADER BANNER -->
    <div class="ent-import-header rounded-top-lg py-3 px-4 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3"
                style="width: 44px; height: 44px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.18);">
                <i class="fas fa-file-excel fa-lg text-info"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold" id="staticBackdropLabel" style="letter-spacing: -0.01em; color: #cbd5e1;">
                    Form Upload Data Peserta Koperasi
                </h5>
                <p class="fs--2 mb-0" style="color: #cbd5e1;">
                    Import massal anggota dari berkas Excel/CSV &bull; Support by
                    <a class="text-white fw-semi-bold text-decoration-underline" href="#!">Transforma</a>
                </p>
            </div>
        </div>
        <!-- <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> -->
    </div>

    <!-- FORM CONTENT -->
    <form action="{{ route('master_koperasi_peserta_import_save') }}" method="post" id="form-input-upload"
        enctype="multipart/form-data" class="ent-import-form">
        @csrf
        <div class="p-4">
            <div class="row g-3">
                <!-- PENGATURAN PARAMETER KEANGGOTAAN & SIMPANAN -->
                <div class="col-12">
                    <div class="ent-section-title">
                        <i class="fas fa-sliders-h"></i> Parameter Cabang & Skema Simpanan
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="code" class="form-label ent-label">Pilih Cabang <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-code-branch"></i></span>
                        <select name="code" id="code" class="form-select single-select" required>
                            <option value="">-- Pilih Cabang --</option>
                            @foreach ($cabang as $cab)
                            <option value="{{ $cab->kop_master_cabang_code }}">
                                [{{ $cab->kop_master_cabang_code }}] {{ $cab->kop_master_cabang_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="pokok" class="form-label ent-label">Pilih Simpanan Pokok <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-piggy-bank"></i></span>
                        <select name="pokok" id="pokok" class="form-select single-select" required>
                            <option value="">-- Pilih Simpanan Pokok --</option>
                            @foreach ($pokok as $pok)
                            <option value="{{ $pok->kop_simpanan_pokok_code }}">
                                {{ $pok->kop_simpanan_pokok_name }} - Rp {{ number_format((float) $pok->kop_simpanan_pokok_nominal, 0, ',', '.') }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="wajib" class="form-label ent-label">Pilih Simpanan Wajib <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                        <select name="wajib" id="wajib" class="form-select single-select" required>
                            <option value="">-- Pilih Simpanan Wajib --</option>
                            @foreach ($wajib as $jib)
                            <option value="{{ $jib->kop_simpanan_wajib_code }}">
                                {{ $jib->kop_simpanan_wajib_name }} - Rp {{ number_format((float) $jib->kop_simpanan_wajib_nominal, 0, ',', '.') }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- BERKAS IMPORT -->
                <div class="col-12 mt-4">
                    <div class="ent-section-title">
                        <i class="fas fa-cloud-upload-alt"></i> Berkas Data Peserta
                    </div>
                </div>

                <div class="col-12">
                    <label for="file" class="form-label ent-label">File Import (.xlsx, .xls, .csv) <span class="text-danger">*</span></label>
                    <label for="file" class="ent-file-dropzone d-flex align-items-center justify-content-between gap-3 w-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                                style="width: 42px; height: 42px; background: rgba(79, 70, 229, 0.14); color: #4f46e5;">
                                <i class="fas fa-file-upload fa-lg"></i>
                            </div>
                            <div>
                                <div class="fw-bold small" id="file-import-name">Klik untuk memilih berkas Excel / CSV</div>
                                <div class="text-muted" style="font-size: 0.7rem;" id="file-import-meta">
                                    Pastikan format kolom sesuai template data peserta koperasi.
                                </div>
                            </div>
                        </div>
                        <span class="badge rounded-pill px-3 py-2"
                            style="background: rgba(79, 70, 229, 0.14); color: #4f46e5; font-size: 0.7rem;">
                            Pilih File
                        </span>
                    </label>
                    <input type="file" name="file" id="file" class="d-none" accept=".xlsx,.xls,.csv" required
                        onchange="
                            const f = this.files && this.files[0];
                            document.getElementById('file-import-name').textContent = f ? f.name : 'Klik untuk memilih berkas Excel / CSV';
                            document.getElementById('file-import-meta').textContent = f
                                ? 'Ukuran: ' + (f.size / 1024).toFixed(1) + ' KB'
                                : 'Pastikan format kolom sesuai template data peserta koperasi.';
                        ">
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="modal-footer px-4 py-3 d-flex justify-content-between align-items-center"
            style="background-color: rgba(79, 70, 229, 0.04); border-top: 1px solid rgba(99, 102, 241, 0.28);">
            <button type="button" class="btn btn-secondary btn-sm px-3 py-2 fw-semibold" style="border-radius: 10px;" data-bs-dismiss="modal">
                <i class="fas fa-times me-1"></i> Batal
            </button>
            <button type="submit" class="btn ent-btn-import" id="button-upload-excel-data">
                <i class="fas fa-file-import me-1"></i> Start Import
            </button>
        </div>
    </form>
</div>
