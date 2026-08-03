<div class="row g-2">
    @forelse($paketList as $paket)
    <div class="col-md-6">
        <div class="card border border-200 shadow-none h-100 hover-actions-trigger">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-1 text-primary fw-bold">{{ $paket->p_sales_cat_name }}</h6>
                    <small class="text-500">Kode: {{ $paket->p_sales_cat_code }}</small>
                </div>
                <button type="button"
                        class="btn btn-sm btn-outline-primary btn-pilih-paket"
                        data-id="{{ $paket->p_sales_cat_code }}"
                        data-nama="{{ $paket->p_sales_cat_name }}">
                    Pilih Paket <i class="fas fa-chevron-right ms-1"></i>
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center text-muted py-3">
        <i class="fas fa-info-circle me-1"></i> Tidak ada paket pemeriksaan untuk agreement ini.
    </div>
    @endforelse
</div>
