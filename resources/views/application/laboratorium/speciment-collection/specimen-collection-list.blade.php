@forelse ($data as$item)
    <div class="specimen-item-card p-2"
        data-reg="{{ $item->d_reg_order_code }}"
        data-code="{{ $item->d_reg_order_lab_code }}">
        <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
            <h6 class="mb-0 fw-bold small">{{ $item->title ? $item->title . ' ' : '' }}{{$item->master_patient_name }}</h6>
            <span class="specimen-chip flex-shrink-0">{{ $item->d_reg_order_code }}</span>
        </div>
        <div class="d-flex justify-content-between align-items-center opacity-75 fw-semibold" style="font-size: 0.73rem;">
            <span style="font-family: 'JetBrains Mono', monospace;">
                <i class="fas fa-vial me-1 text-primary"></i>{{ $item->d_reg_order_lab_code }}
            </span>
            <span style="font-family: 'JetBrains Mono', monospace;">
                <i class="far fa-clock me-1 text-primary"></i>{{ $item->d_reg_order_date }}
            </span>
        </div>
    </div>
@empty
    <div class="text-center py-4 opacity-75">
        <i class="fas fa-inbox fa-2x mb-2 text-primary"></i>
        <p class="small fw-semibold mb-0">Tidak ada data spesimen pada filter ini</p>
    </div>
@endforelse
