@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE HEALTHCARE UI STYLES
       (ADAPTIVE LIGHT & DARK MODE BOOTSTRAP 5)
       ========================================= */
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-indigo-soft: rgba(79, 70, 229, 0.12);
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-emerald: #059669;
        --ent-sky: #0284c7;
        --ent-amber: #d97706;
        --ent-rose: #e11d48;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Adaptive Enterprise Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: transparent;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.07) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 14px 18px;
    }

    /* Hero Banner */
    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 16px;
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.22);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 340px;
        height: 340px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    /* Filter Form Inputs */
    .form-control-ent,
    .form-select-ent {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem;
        transition: all 0.2s ease;
    }

    .form-control-ent:focus,
    .form-select-ent:focus {
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        border-color: var(--ent-indigo) !important;
        outline: none;
    }

    .input-group-text-ent {
        border: 1px solid var(--ent-grid-border) !important;
        border-right: none !important;
        border-top-left-radius: 10px !important;
        border-bottom-left-radius: 10px !important;
        background-color: rgba(79, 70, 229, 0.06) !important;
        color: var(--bs-secondary-color, #64748b);
    }

    .input-group>.form-control-ent {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    .btn-ent-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        border-radius: 10px;
        font-weight: 600;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        transition: all 0.18s ease;
        font-size: 0.84rem;
    }

    .btn-ent-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    /* Styling List Patient Card (Adaptive Light/Dark Mode) */
    .patient-list-container::-webkit-scrollbar {
        width: 5px;
    }

    .patient-list-container::-webkit-scrollbar-track {
        background: transparent;
    }

    .patient-list-container::-webkit-scrollbar-thumb {
        background: rgba(99, 102, 241, 0.3);
        border-radius: 10px;
    }

    .patient-card-item {
        cursor: pointer;
        transition: all 0.18s ease;
        border: 1px solid var(--ent-grid-border) !important;
        background-color: var(--bs-body-bg);
        border-radius: 12px;
        margin-bottom: 10px;
        position: relative;
        overflow: hidden;
    }

    .patient-card-item:hover {
        background-color: rgba(79, 70, 229, 0.06);
        border-color: rgba(99, 102, 241, 0.55) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px -4px rgba(79, 70, 229, 0.15);
    }

    .patient-card-item.active-patient {
        background-color: rgba(79, 70, 229, 0.12) !important;
        border: 1.5px solid var(--ent-indigo) !important;
        box-shadow: 0 8px 20px -4px rgba(79, 70, 229, 0.25) !important;
    }

    .patient-card-item.active-patient::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, #4f46e5, #0ea5e9);
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    .empty-state-icon {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.14), rgba(14, 165, 233, 0.14));
        border: 1px solid var(--ent-grid-border);
        color: #6366f1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection

@section('content')
<!-- Banner Header Enterprise -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 d-flex justify-content-between align-items-center flex-wrap gap-3 position-relative" style="z-index: 2;">
                <div class="d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 60px; height: 60px;">
                        <img src="{{ asset('img/lab.png') }}" alt="Logo" width="38" />
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                                <i class="fas fa-stethoscope me-1"></i> v2.4 Medical Suite
                            </span>
                            <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Unit Pelayanan Rawat Jalan</span>
                        </div>
                        <h4 class="fw-bold mb-0 text-white" style="letter-spacing: -0.02em;">Poliklinik Handling System</h4>
                    </div>
                </div>
                <div class="text-end">
                    <div class="ent-glass-pill px-3 py-2 d-inline-flex align-items-center gap-2">
                        <i class="fas fa-calendar-check text-info"></i>
                        <span class="fw-semibold" style="font-size: 0.88rem;">{{ date('d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Split Area -->
<div class="row g-3">
    <!-- Sidebar Patient List & Filters -->
    <div class="col-lg-5">
        <div class="sticky-sidebar">
            <!-- Card Filter -->
            <div class="ent-card mb-3">
                <div class="ent-card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="fas fa-filter text-primary"></i> Filter Pencarian
                    </h6>
                </div>
                <div class="card-body p-3  bg-white">
                    <!-- Form Filter -->
                    <form method="GET" action="{{ url()->current() }}">
                        <div class="row g-2.5">
                            <div class="col-6">
                                <label class="fw-semibold small text-uppercase opacity-75 mb-1" style="font-size: 0.68rem;">Mulai Tanggal</label>
                                <input type="date" name="start_date" class="form-control form-control-ent form-control-sm" value="{{ $request->start_date ?? date('Y-m-d') }}">
                            </div>
                            <div class="col-6">
                                <label class="fw-semibold small text-uppercase opacity-75 mb-1" style="font-size: 0.68rem;">Sampai Tanggal</label>
                                <input type="date" name="end_date" class="form-control form-control-ent form-control-sm" value="{{ $request->end_date ?? date('Y-m-d') }}">
                            </div>
                            <div class="col-12 mt-2">
                                <label class="fw-semibold small text-uppercase opacity-75 mb-1" style="font-size: 0.68rem;">Poliklinik</label>
                                <select name="poli_id" class="form-select form-select-ent form-select-sm">
                                    <option value="">-- Semua Poliklinik --</option>
                                    @foreach($polis ?? [] as $poli)
                                    <option value="{{ $poli->id }}" {{ ($request->poli_id == $poli->id) ? 'selected' : '' }}>
                                        {{ $poli->nama_poli }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mt-2">
                                <label class="fw-semibold small text-uppercase opacity-75 mb-1" style="font-size: 0.68rem;">Pencarian No. Reg / Nama / RM</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text input-group-text-ent"><i class="fas fa-search"></i></span>
                                    <input type="text" name="search_query" class="form-control form-control-ent" value="{{ $request->search_query }}" placeholder="Ketik nomor registrasi, nama, atau RM...">
                                </div>
                            </div>
                            <div class="col-12 mt-3 d-grid">
                                <button type="submit" class="btn btn-ent-primary py-2">
                                    <i class="fas fa-search me-1"></i> Terapkan Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Card Antrean Pasien -->
            <div class="ent-card">
                <div class="ent-card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="fas fa-user-clock text-primary"></i> Antrean Pasien
                    </h6>
                    <span class="ent-badge" style="background: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.32);">
                        {{ count($data) }} Pasien
                    </span>
                </div>
                <div class="card-body p-3  bg-white">
                    <!-- Patients List -->
                    <div class="patient-list-container pe-1" style="max-height: 52vh; overflow-y: auto;">
                        @forelse ($data as $datas)
                        <div class="patient-card-item button-handling-pasien-poli" data-code="{{ $datas->no_registrasi }}">
                            <div class="card-body py-2.5 px-3">
                                <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                    <div>
                                        <div class="fw-bold" style="font-size: 0.9rem;">{{ $datas->master_patient_name }}</div>
                                        <div class="fw-semibold opacity-75 mt-0.5" style="font-size: 0.72rem; font-family: 'JetBrains Mono', monospace;">
                                            <i class="fas fa-qrcode text-primary me-1"></i>RM: {{ $datas->master_patient_code }}
                                        </div>
                                    </div>
                                    <span class="ent-badge px-2.5 py-1 flex-shrink-0" style="background: rgba(14, 165, 233, 0.14); color: #38bdf8; border: 1px solid rgba(14, 165, 233, 0.32); font-size: 0.65rem;">
                                        {{ $datas->m_poli_name ?? 'Poli Umum' }}
                                    </span>
                                </div>
                                <div class="pt-2 mt-2 d-flex flex-wrap justify-content-between align-items-center gap-1" style="border-top: 1px dashed var(--ent-grid-border);">
                                    <div class="fw-semibold" style="font-size: 0.76rem; font-family: 'JetBrains Mono', monospace;">
                                        <i class="fas fa-hashtag text-primary me-1"></i>{{ $datas->no_registrasi }}
                                    </div>
                                    <div class="fw-medium opacity-75" style="font-size: 0.76rem;">
                                        <i class="fas fa-user-md text-info me-1"></i>Dr. {{ $datas->master_doctor_name ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center p-4 rounded-3" style="border: 1px dashed var(--ent-grid-border);">
                            <i class="fas fa-inbox fa-2x opacity-50 mb-2"></i>
                            <h6 class="fw-bold opacity-75 mb-0 small">Tidak ada data antrean.</h6>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Handling Area -->
    <div class="col-lg-7">
        <div id="menu-detail-handling" class="h-100">
            <div class="ent-card text-center py-5 h-100 d-flex align-items-center justify-content-center" style="min-height: 460px;">
                <div class="card-body px-4">
                    <div class="empty-state-icon mb-3">
                        <i class="fas fa-hand-pointer fa-2x"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Pilih Pasien dari Antrean</h5>
                    <p class="opacity-75 mb-0 mx-auto small" style="max-width: 380px;">
                        Klik pada salah satu kartu pasien di sebelah kiri untuk membuka lembar pemeriksaan dan memberikan penanganan medis.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        const loaderHtml = `
            <div class="ent-card d-flex flex-column justify-content-center align-items-center py-5 h-100" style="min-height: 460px;">
                <div class="spinner-border text-primary mb-3" style="width: 2.6rem; height: 2.6rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span class="fw-semibold opacity-75 small">Memuat lembar penanganan pasien...</span>
            </div>`;

        // Handling Load Patient Detail
        $(document).on("click", ".button-handling-pasien-poli", function(e) {
            e.preventDefault();
            const $this = $(this);
            // Ambil nomor registrasi dari parameter
            const code = $this.data("code");

            $(".button-handling-pasien-poli").removeClass("active-patient");
            $this.addClass("active-patient");

            $('#menu-detail-handling').html(loaderHtml);

            // Pastikan URL route mengarah ke controller detail handling yang telah diperbarui
            $.ajax({
                url: "{{ route('data_registrasi_poliklinik_handling_detail') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html'
            }).done(function(data) {
                $('#menu-detail-handling').html(data);
            }).fail(function() {
                $('#menu-detail-handling').html(`
                    <div class="ent-card p-5 text-center" style="border-color: rgba(225, 29, 72, 0.45);">
                        <div class="mb-3 text-danger"><i class="fas fa-exclamation-circle fa-3x"></i></div>
                        <h5 class="fw-bold text-danger">Gagal Memuat Data!</h5>
                        <p class="opacity-75 small mb-0">Terjadi kesalahan pada server. Silakan coba lagi.</p>
                    </div>
                `);
            });
        });
    });
</script>
@endsection
