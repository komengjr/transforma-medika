<style>
    .coa-edit-modal {
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-indigo: #4f46e5;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .coa-edit-modal .coa-modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
    }

    .coa-edit-modal .form-control {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .coa-edit-modal .ent-input,
    .coa-edit-modal .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        padding-top: 18px !important;
        padding-bottom: 5px !important;
        padding-left: 11px !important;
        font-size: 0.8rem !important;
        height: 44px !important;
        transition: all 0.2s ease;
    }

    .coa-edit-modal .form-control:focus,
    .coa-edit-modal .ent-input:focus,
    .coa-edit-modal .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .coa-edit-modal .input-group-text {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px 0 0 10px !important;
        background-color: rgba(79, 70, 229, 0.08) !important;
        color: #4f46e5 !important;
    }

    .coa-edit-modal .input-group>.form-control,
    .coa-edit-modal .input-group>.form-select {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    .coa-edit-modal .coa-field-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 6px;
    }

    .coa-edit-modal .btn-coa-update {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        border-radius: 10px;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.55rem 1.25rem;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        transition: all 0.18s ease;
    }

    .coa-edit-modal .btn-coa-update:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }
</style>

<div class="coa-edit-modal">
    <div class="modal-body p-0">
        <div class="coa-modal-header rounded-top-4 py-3 px-4 pe-5 d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <h5 class="mb-1 fw-bold text-white">
                    <i class="fas fa-pen-to-square me-2 text-info"></i>Edit Account COA Koperasi
                </h5>
                <p class="fs--2 mb-0" style="color: #cbd5e1;">
                    Master: <strong class="text-white">{{ $masterCoa->kop_master_coa_name ?? $coa->kop_master_coa_code }}</strong>
                    &bull; Level {{ $coa->kop_coa_data_level }}
                </p>
            </div>
            <span class="badge rounded-pill px-3 py-2" style="background: rgba(56, 189, 248, 0.18); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc; font-family: 'JetBrains Mono', monospace; font-size: 0.75rem;">
                Kode: {{ $coa->kop_coa_data_code }}
            </span>
        </div>

        <div class="p-4">
            <form class="row g-3" id="form-update-coa">
                @csrf
                <input type="hidden" name="kop_coa_data_code" value="{{ $coa->kop_coa_data_code }}">
                <input type="hidden" name="kop_master_coa_code" value="{{ $coa->kop_master_coa_code }}">
                <input type="hidden" name="kop_coa_data_level" value="{{ $coa->kop_coa_data_level }}">

                <div class="col-md-4">
                    <label for="kop_coa_data_no" class="form-label coa-field-label">Nomor Account</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                        <input type="text" name="kop_coa_data_no" id="kop_coa_data_no" class="form-control" value="{{ $coa->kop_coa_data_no }}" required>
                    </div>
                </div>

                <div class="col-md-8">
                    <label for="kop_coa_data_name" class="form-label coa-field-label">Nama Account</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                        <input type="text" name="kop_coa_data_name" id="kop_coa_data_name" class="form-control" value="{{ $coa->kop_coa_data_name }}" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="kop_coa_data_opt" class="form-label coa-field-label">Tipe Account (Single / Multi)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                        <select name="kop_coa_data_opt" id="kop_coa_data_opt" class="form-select">
                            <option value="0" {{ (string) $coa->kop_coa_data_opt === '0' ? 'selected' : '' }}>Single</option>
                            <option value="1" {{ (string) $coa->kop_coa_data_opt === '1' ? 'selected' : '' }}>Multi</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="kop_coa_data_type" class="form-label coa-field-label">Kategori / Type</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                        <input type="text" name="kop_coa_data_type" id="kop_coa_data_type" class="form-control" value="{{ $coa->kop_coa_data_type }}" placeholder="Opsional">
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="kop_coa_data_status" class="form-label coa-field-label">Status Akun</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                        <select name="kop_coa_data_status" id="kop_coa_data_status" class="form-select">
                            <option value="AKTIF" {{ strtoupper((string) $coa->kop_coa_data_status) === 'AKTIF' || (string) $coa->kop_coa_data_status === '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="NONAKTIF" {{ strtoupper((string) $coa->kop_coa_data_status) === 'NONAKTIF' || (string) $coa->kop_coa_data_status === '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 pt-2 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary rounded-3 fw-semibold" data-bs-dismiss="modal" onclick="location.reload()">
                        Batal
                    </button>
                    <span id="menu-add-data-coa">
                        <button type="button" class="btn btn-coa-update" id="button-simpan-data-update-level-coa">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan COA
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>
