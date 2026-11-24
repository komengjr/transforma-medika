<div class="card ent-card mb-3">
    <div class="ent-card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="d-flex flex-wrap align-items-center gap-2">
            <h6 class="mb-0 fw-bold fs--1">
                <i class="fas fa-file-pdf me-2 text-danger"></i> Report Dokumentasi Hasil
            </h6>
            <span class="code-chip code-chip-cyan">{{ $code }}</span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ Storage::url('hasil/rad/'.$code.'.pdf') }}" target="_blank" class="btn btn-sm ent-btn ent-btn-reset px-3 py-1.5 d-inline-flex align-items-center gap-1" title="Buka di Tab Baru">
                <i class="fas fa-external-link-alt"></i>
                <span>Buka PDF</span>
            </a>
            <button type="button" class="btn btn-sm ent-btn ent-btn-primary px-3 py-1.5 d-inline-flex align-items-center gap-1" id="button-kirim-dokumentasi-hasil" data-code="{{ $code }}">
                <i class="fas fa-paper-plane"></i>
                <span>Kirim</span>
            </button>
        </div>
    </div>

    <div class="card-body ent-table-surface p-3">
        <div class="rounded-3 overflow-hidden" style="border: 1px solid var(--ent-grid-border);">
            <iframe src="{{ Storage::url('hasil/rad/'.$code.'.pdf') }}" frameborder="0" style="width: 100%; height: 480px; display: block;"></iframe>
        </div>
    </div>
</div>
