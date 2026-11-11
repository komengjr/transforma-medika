<div class="retro-card mb-3 overflow-hidden">
    <!-- Header Card dengan Retro Styling -->
    <div class="card-header border-bottom border-dark py-3 px-3 d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow);">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle d-flex align-items-center justify-content-center p-2" style="width: 40px; height: 40px; background: white; border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                <i class="fas fa-file-pdf text-danger fs-0"></i>
            </div>
            <div>
                <h6 class="mb-0 text-dark fw-bolder">Report Dokumentasi Hasil</h6>
                <span class="fs--2 text-dark fw-bold opacity-75">Preview Laporan Hasil Laboratorium: {{ $data->master_patient_name ?? '-' }}</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Badge Status & Dynamic Action Button -->
            @if (isset($data->status_pemeriksaan) && $data->status_pemeriksaan == 'TERVERIFIKASI')
            <span class="retro-badge d-none d-sm-inline-block" style="background-color: var(--retro-orange); color: var(--retro-dark);">
                <i class="fas fa-clock me-1"></i>Menunggu Pengiriman
            </span>
            <button class="btn retro-btn retro-btn-success btn-sm px-3 shadow-sm" id="button-kirim-dokumentasi-hasil"
                data-code="{{ $code }}">
                <i class="fas fa-paper-plane me-1"></i> Kirim Hasil
            </button>
            @else
            <span class="retro-badge d-none d-sm-inline-block" style="background-color: var(--retro-green); color: var(--retro-dark);">
                <i class="fas fa-check-circle me-1"></i>Terkirim
            </span>
            <button class="btn retro-btn retro-btn-danger btn-sm px-3" id="button-batal-kirim-dokumentasi-hasil"
                data-code="{{ $code }}" style="background-color: var(--retro-pink); color: var(--retro-dark);">
                <i class="fas fa-undo me-1"></i> Batal Kirim
            </button>
            @endif
        </div>
    </div>

    <!-- Body Card & PDF Viewer Container -->
    <div class="card-body bg-white p-3">
        <!-- Toolbar Mini PDF -->
        <div class="d-flex justify-content-between align-items-center bg-white p-2 px-3 rounded-2 mb-2 fs--2 text-dark fw-bold" style="border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark); background-color: var(--retro-bg) !important;">
            <div class="d-flex align-items-center">
                <i class="fas fa-file-alt text-dark me-2"></i>
                <span class="fw-bolder text-dark">{{ $code }}.pdf</span>
            </div>
            <a href="{{ Storage::url('hasil/lab/' . $code . '.pdf') }}" target="_blank" class="text-dark text-decoration-underline fw-bolder">
                <i class="fas fa-external-link-alt me-1"></i> Buka di Tab Baru
            </a>
        </div>

        <!-- Frame PDF dengan Border & Shadow Tegas -->
        <div class="rounded-3 overflow-hidden bg-white position-relative" style="border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
            <iframe src="{{ Storage::url('hasil/lab/' . $code . '.pdf') }}" frameborder="0"
                style="width: 100%; height: 500px; display: block;"></iframe>
        </div>
    </div>
</div>
