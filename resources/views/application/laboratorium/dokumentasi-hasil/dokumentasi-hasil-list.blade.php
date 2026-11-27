@forelse ($data as $datas)
<div class="handling-card p-3 button-dokumentasi-hasil-lab"
    data-code="{{ $datas->registrasi_id }}">
    <div class="card-body p-0">
        <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
            <h6 class="mb-0 patient-name fw-bold text-uppercase" style="font-size: 0.84rem;">
                <i class="fas fa-user-circle me-1 text-primary"></i>{{ $datas->master_patient_name }}
            </h6>
            <span class="ent-badge flex-shrink-0" style="background-color: rgba(2, 132, 199, 0.14); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.3); font-family: 'JetBrains Mono', monospace;">
                {{ $datas->no_registrasi }}
            </span>
        </div>

        <div class="d-flex justify-content-between align-items-center opacity-75 mt-2" style="font-size: 0.74rem; font-weight: 600;">
            <span><i class="far fa-clock me-1 text-primary"></i>{{ $datas->d_reg_order_lab_date }}</span>
            <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle" style="font-family: 'JetBrains Mono', monospace;">
                {{ $datas->total_pemeriksaan }} Layanan
            </span>
        </div>
    </div>
</div>
@empty
<div class="text-center py-4 ent-empty-state">
    <i class="fas fa-inbox opacity-50 fs-3 mb-2 d-block"></i>
    <p class="fw-semibold mb-0" style="font-size: 0.82rem;">Tidak ada data hasil lab pada filter tersebut.</p>
</div>
@endforelse
