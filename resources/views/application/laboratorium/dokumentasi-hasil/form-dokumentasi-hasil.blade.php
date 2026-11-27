<style>
    .ent-report-card {
        --ent-grid-border: rgba(99, 102, 241, 0.22);
        --ent-solid-bg: #ffffff;
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 6px 24px -4px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    [data-bs-theme="dark"] .ent-report-card,
    .dark .ent-report-card {
        --ent-solid-bg: #0f172a;
        --ent-grid-border: rgba(148, 163, 184, 0.2);
    }

    .ent-report-header {
        background: linear-gradient(180deg, rgba(79, 70, 229, 0.08) 0%, rgba(79, 70, 229, 0.02) 100%);
        border-bottom: 1px solid var(--ent-grid-border);
        padding: 14px 18px;
    }

    .ent-report-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background-color: rgba(225, 29, 72, 0.12);
        border: 1px solid rgba(225, 29, 72, 0.28);
        color: #e11d48;
    }

    .ent-report-badge {
        border-radius: 9999px;
        padding: 5px 11px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        font-size: 0.68rem;
        letter-spacing: 0.04em;
    }

    .ent-report-btn {
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.18s ease;
        font-size: 0.78rem;
    }

    .ent-report-btn:hover {
        transform: translateY(-1px);
    }

    .ent-pdf-toolbar {
        background-color: rgba(79, 70, 229, 0.04);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 9px 14px;
    }

    .ent-pdf-frame-wrap {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        overflow: hidden;
        background-color: rgba(15, 23, 42, 0.03);
    }
</style>

<div class="ent-report-card mb-3">
    <!-- Header Card -->
    <div class="ent-report-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex align-items-center gap-3">
            <div class="ent-report-icon d-flex align-items-center justify-content-center flex-shrink-0">
                <i class="fas fa-file-pdf fs-2"></i>
            </div>
            <div>
                <h6 class="mb-0 fw-bold" style="font-size: 0.95rem;">Report Dokumentasi Hasil</h6>
                <span class="opacity-75" style="font-size: 0.78rem;">
                    Preview Laporan Hasil Laboratorium: <strong class="fw-semibold">{{ $data->master_patient_name ?? '-' }}</strong>
                </span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Badge Status & Dynamic Action Button -->
            @if (isset($data->status_pemeriksaan) && $data->status_pemeriksaan == 'TERVERIFIKASI')
            <span class="ent-report-badge d-none d-sm-inline-flex"
                style="background-color: rgba(217, 119, 6, 0.14); border: 1px solid rgba(217, 119, 6, 0.35); color: #d97706;">
                <i class="fas fa-clock me-1"></i> Menunggu Pengiriman
            </span>
            <button type="button"
                class="btn btn-success ent-report-btn btn-sm px-3 shadow-sm"
                id="button-kirim-dokumentasi-hasil"
                data-code="{{ $code }}">
                <i class="fas fa-paper-plane me-1"></i> Kirim Hasil
            </button>
            @else
            <span class="ent-report-badge d-none d-sm-inline-flex"
                style="background-color: rgba(5, 150, 105, 0.14); border: 1px solid rgba(5, 150, 105, 0.35); color: #059669;">
                <i class="fas fa-check-circle me-1"></i> Terkirim
            </span>
            <button type="button"
                class="btn btn-outline-danger ent-report-btn btn-sm px-3"
                id="button-batal-kirim-dokumentasi-hasil"
                data-code="{{ $code }}">
                <i class="fas fa-undo me-1"></i> Batal Kirim
            </button>
            @endif
        </div>
    </div>

    <!-- Body Card & PDF Viewer Container -->
    <div class="card-body p-3 p-md-4">
        <!-- Toolbar Mini PDF -->
        <div class="ent-pdf-toolbar d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <div class="d-flex align-items-center gap-2" style="font-size: 0.8rem;">
                <i class="fas fa-file-alt text-primary"></i>
                <span class="fw-bold" style="font-family: 'JetBrains Mono', monospace;">{{ $code }}.pdf</span>
            </div>
            <a href="{{ Storage::url('hasil/lab/' . $code . '.pdf') }}"
                target="_blank"
                class="btn btn-sm btn-outline-primary ent-report-btn py-1 px-2">
                <i class="fas fa-external-link-alt me-1"></i> Buka di Tab Baru
            </a>
        </div>

        <!-- Frame PDF -->
        <div class="ent-pdf-frame-wrap position-relative">
            <iframe src="{{ Storage::url('hasil/lab/' . $code . '.pdf') }}"
                frameborder="0"
                style="width: 100%; height: 520px; display: block;"></iframe>
        </div>
    </div>
</div>
