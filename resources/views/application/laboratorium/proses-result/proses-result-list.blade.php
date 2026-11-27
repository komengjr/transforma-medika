@forelse ($data as $datas)
    <div class="patient-card remove-class button-pilih-registrasi p-2" data-code="{{ $datas->registrasi_id }}">
        <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
            <h6 class="mb-0 fw-bold small">{{ $datas->master_patient_name }}</h6>
            <span class="code-chip flex-shrink-0">{{ $datas->no_registrasi }}</span>
        </div>
        <div class="d-flex justify-content-between align-items-center small opacity-75 fw-semibold" style="font-size: 0.74rem;">
            <span style="font-family: 'JetBrains Mono', monospace;">
                <i class="far fa-clock me-1 text-primary"></i>{{ $datas->d_reg_order_lab_date }}
            </span>
            <span class="fw-bold text-primary">
                {{ $datas->total_pemeriksaan }} Pemeriksaan <i class="fas fa-chevron-right ms-1"></i>
            </span>
        </div>
    </div>
@empty
    <div class="text-center py-4 opacity-75">
        <i class="fas fa-inbox fa-2x mb-2 text-primary"></i>
        <p class="small fw-semibold mb-0">Tidak ada antrean registrasi lab pada filter ini</p>
    </div>
@endforelse
