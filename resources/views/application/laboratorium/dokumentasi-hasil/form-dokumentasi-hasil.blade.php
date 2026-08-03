<div class="card shadow-sm border-0 rounded-3 mb-3 overflow-hidden">
    <!-- Header Card dengan Gradient & Action Buttons -->
    <div class="card-header border-0 py-3 px-3 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #0c5bda 0%, #334155 100%);">
        <div class="d-flex align-items-center gap-2">
            <div class="avatar avatar-md bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center p-2">
                <i class="fas fa-file-pdf text-danger fs-0"></i>
            </div>
            <div>
                <h6 class="mb-0 text-white fw-bold">Report Dokumentasi Hasil</h6>
                <span class="fs--2 text-300">Preview Laporan Hasil Laboratorium</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Badge Status & Dynamic Action Button -->
            @if ($data->d_reg_order_lab_status == 3)
            <span class="badge bg-warning bg-opacity-20 text-white border border-warning border-opacity-25 rounded-pill px-2.5 py-1 fs--2 d-none d-sm-inline-block">
                <i class="fas fa-clock me-1"></i>Menunggu Pengiriman
            </span>
            <button class="btn btn-success btn-sm px-3 shadow-sm" id="button-kirim-dokumentasi-hasil"
                data-code="{{ $code }}">
                <i class="fas fa-paper-plane me-1"></i> Kirim Hasil
            </button>
            @else
            <span class="badge bg-success bg-opacity-20 text-success border border-success border-opacity-25 rounded-pill px-2.5 py-1 fs--2 d-none d-sm-inline-block">
                <i class="fas fa-check-circle me-1"></i>Terkirim
            </span>
            <button class="btn btn-outline-danger btn-sm px-3 bg-white" id="button-batal-kirim-dokumentasi-hasil"
                data-code="{{ $code }}">
                <i class="fas fa-undo me-1"></i> Batal Kirim
            </button>
            @endif
        </div>
    </div>

    <!-- Body Card & PDF Viewer Container -->
    <div class="card-body bg-light p-3">
        <!-- Toolbar Mini PDF -->
        <div class="d-flex justify-content-between align-items-center bg-white p-2 px-3 rounded-2 border border-200 mb-2 fs--2 text-600">
            <div class="d-flex align-items-center">
                <i class="fas fa-file-alt text-primary me-2"></i>
                <span class="fw-bold text-800">{{ $code }}.pdf</span>
            </div>
            <a href="{{ Storage::url('hasil/lab/' . $code . '.pdf') }}" target="_blank" class="text-primary text-decoration-none fw-semi-bold">
                <i class="fas fa-external-link-alt me-1"></i> Buka di Tab Baru
            </a>
        </div>

        <!-- Frame PDF dengan Border & Shadow Halus -->
        <div class="rounded-3 overflow-hidden border border-200 shadow-sm bg-white position-relative">
            <iframe src="{{ Storage::url('hasil/lab/' . $code . '.pdf') }}" frameborder="0"
                style="width: 100%; height: 500px; display: block;"></iframe>
        </div>
    </div>
</div>
