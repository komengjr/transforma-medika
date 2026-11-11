<div class="card retro-card mb-3" style="border: 3px solid var(--retro-dark); box-shadow: 5px 5px 0px var(--retro-dark); border-radius: 12px; overflow: hidden;">
    <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: var(--retro-cyan); border-bottom: 3px solid var(--retro-dark);">
        <h5 class="mb-0 text-dark fw-bolder fs-0">
            <i class="fas fa-file-pdf me-2"></i> Report Dokumentasi Hasil <span class="font-monospace">{{ $code }}</span>
        </h5>
        <button class="btn btn-sm px-3 py-2 fw-bolder shadow-sm d-flex align-items-center gap-1" id="button-kirim-dokumentasi-hasil" data-code="{{ $code }}" style="background-color: var(--retro-yellow); color: var(--retro-dark); border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark); transition: 0.1s;">
            <i class="fas fa-paper-plane"></i> Kirim
        </button>
    </div>
    <div class="card-body bg-white p-3">
        <div class="border-2 border-dark rounded-3 overflow-hidden shadow-sm" style="border: 2px solid var(--retro-dark);">
            <iframe src="{{ Storage::url('hasil/rad/'.$code.'.pdf' )}}" frameborder="0" style="width: 100%; height: 480px; display: block;"></iframe>
        </div>
    </div>
</div>
