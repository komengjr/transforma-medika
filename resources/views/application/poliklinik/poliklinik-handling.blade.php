@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<style>
    /* =========================================
       RETRO / NEUBRUTALISM THEME STYLES
       ========================================= */
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-cyan: #8bf0fa;
        --retro-orange: #ff914d;
        --retro-green: #c1ff72;
        --retro-purple: #c8b6ff;
        --retro-bg: #f4f0ea;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 4px 4px 0px var(--retro-dark);
        --retro-shadow-hover: 6px 6px 0px var(--retro-dark);
    }

    .card-retro {
        border: var(--retro-border);
        border-radius: 12px;
        background: #ffffff;
        box-shadow: var(--retro-shadow);
        overflow: hidden;
    }

    /* Filter Form */
    .form-control-retro,
    .form-select-retro {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        font-weight: 700;
        color: var(--retro-dark);
        background: #ffffff;
    }

    .form-control-retro:focus,
    .form-select-retro:focus {
        box-shadow: 3px 3px 0px var(--retro-dark);
        border-color: var(--retro-dark) !important;
    }

    .btn-retro {
        border: 2px solid var(--retro-dark);
        box-shadow: 3px 3px 0px var(--retro-dark);
        border-radius: 6px;
        font-weight: 800;
        text-transform: uppercase;
        transition: all 0.1s;
    }

    .btn-retro:hover,
    .btn-retro:active {
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px var(--retro-dark);
    }

    /* Styling List Patient Card */
    .patient-card-item {
        cursor: pointer;
        transition: all 0.1s ease-in-out;
        border: 2px solid var(--retro-dark) !important;
        background-color: #ffffff;
        border-radius: 8px;
        margin-bottom: 12px;
        box-shadow: 3px 3px 0px var(--retro-dark);
    }

    .patient-card-item:hover {
        background-color: var(--retro-yellow);
        transform: translate(-2px, -2px);
        box-shadow: 5px 5px 0px var(--retro-dark);
    }

    .patient-card-item.active-patient {
        background-color: var(--retro-cyan) !important;
        border: 3px solid var(--retro-dark) !important;
        box-shadow: 5px 5px 0px var(--retro-dark) !important;
        transform: translate(-2px, -2px);
    }

    .badge-retro {
        border: 2px solid var(--retro-dark);
        background: #ffffff;
        color: var(--retro-dark);
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
    }
</style>
@endsection

@section('content')
<!-- Banner Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-retro" style="background-color: var(--retro-purple);">
            <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-white border border-dark rounded-3 me-3 text-dark d-flex align-items-center justify-content-center" style="box-shadow: 3px 3px 0px var(--retro-dark); border-width: 2px !important;">
                        <img src="{{ asset('img/lab.png') }}" alt="Logo" width="45" />
                    </div>
                    <div>
                        <span class="badge badge-retro bg-white mb-2">v2.4 Medical Suite</span>
                        <h2 class="fw-bolder mb-0 text-dark" style="letter-spacing: -1px;">Poliklinik Handling System</h2>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge bg-warning text-dark px-4 py-2 fs-2 border border-dark border-2" style="box-shadow: 3px 3px 0px var(--retro-dark);">
                        <i class="fas fa-calendar-check me-2"></i> {{ date('d F Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Split Area -->
<div class="row g-4">
    <!-- Sidebar Patient List & Filters -->
    <div class="col-lg-5">
        <div class="sticky-sidebar">
            <div class="card-retro mb-4">
                <div class="card-header border-bottom border-dark border-2 p-3 d-flex justify-content-between align-items-center" style="background-color: var(--retro-cyan);">
                    <h5 class="mb-0 fw-bolder text-dark"><i class="fas fa-filter me-2"></i> Filter Pencarian</h5>
                </div>
                <div class="card-body p-3">
                    <!-- Form Filter -->
                    <form method="GET" action="{{ url()->current() }}">
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="fw-bold text-dark fs--1 mb-1">Mulai Tanggal</label>
                                <input type="date" name="start_date" class="form-control form-control-retro form-control-sm" value="{{ $request->start_date ?? date('Y-m-d') }}">
                            </div>
                            <div class="col-6">
                                <label class="fw-bold text-dark fs--1 mb-1">Sampai Tanggal</label>
                                <input type="date" name="end_date" class="form-control form-control-retro form-control-sm" value="{{ $request->end_date ?? date('Y-m-d') }}">
                            </div>
                            <div class="col-12 mt-2">
                                <label class="fw-bold text-dark fs--1 mb-1">Poliklinik</label>
                                <select name="poli_id" class="form-select form-select-retro form-select-sm">
                                    <option value="">-- Semua Poliklinik --</option>
                                    @foreach($polis ?? [] as $poli)
                                    <option value="{{ $poli->id }}" {{ ($request->poli_id == $poli->id) ? 'selected' : '' }}>
                                        {{ $poli->nama_poli }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mt-2">
                                <label class="fw-bold text-dark fs--1 mb-1">Pencarian No. Reg / Nama / RM</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light border-dark border-2 fw-bold text-dark"><i class="fas fa-search"></i></span>
                                    <input type="text" name="search_query" class="form-control form-control-retro" value="{{ $request->search_query }}" placeholder="Ketik keyword...">
                                </div>
                            </div>
                            <div class="col-12 mt-3 d-grid">
                                <button type="submit" class="btn btn-primary btn-retro bg-dark text-white border-dark"><i class="fas fa-search me-1"></i> Terapkan Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-retro">
                <div class="card-header border-bottom border-dark border-2 p-3 d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow);">
                    <h5 class="mb-0 fw-bolder text-dark"><i class="fas fa-user-clock me-2"></i> Antrean Pasien</h5>
                    <span class="badge badge-retro">{{ count($data) }} Pasien</span>
                </div>
                <div class="card-body bg-light p-3">
                    <!-- Patients List -->
                    <div class="patient-list-container pe-1" style="max-height: 50vh; overflow-y: auto;">
                        @forelse ($data as $datas)
                        <div class="patient-card-item button-handling-pasien-poli" data-code="{{ $datas->no_registrasi }}">
                            <div class="card-body py-2 px-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <div class="fw-bolder fs-0 text-dark">{{ $datas->master_patient_name }}</div>
                                        <div class="fw-bold fs--2 text-dark opacity-75"><i class="fas fa-qrcode"></i> RM: {{ $datas->master_patient_code }}</div>
                                    </div>
                                    <span class="badge badge-retro px-2 py-1 fs--2" style="background-color: var(--retro-orange);">
                                        {{ $datas->m_poli_name ?? 'Poli Umum' }}
                                    </span>
                                </div>
                                <div class="border-top border-dark pt-2 mt-2">
                                    <div class="fw-bold text-dark fs--1 mb-1">
                                        <i class="fas fa-hashtag me-1"></i> Reg: {{ $datas->no_registrasi }}
                                    </div>
                                    <div class="fw-bold text-dark fs--1">
                                        <i class="fas fa-user-md me-1"></i> Dr. {{ $datas->master_doctor_name ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="card-retro border-dark text-center p-4" style="background-color: #f1f1f1;">
                            <i class="fas fa-inbox fa-3x text-dark opacity-50 mb-2"></i>
                            <h6 class="fw-bolder text-dark mb-0">Tidak ada data antrean.</h6>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Handling Area -->
    <div class="col-lg-7">
        <div id="menu-detail-handling">
            <div class="card-retro border-dark text-center py-5 h-100 d-flex align-items-center justify-content-center">
                <div class="card-body">
                    <i class="fas fa-hand-pointer fa-4x text-dark mb-4 animate-pulse"></i>
                    <h3 class="fw-bolder text-dark">Pilih Pasien dari Antrean</h3>
                    <p class="fw-bold text-dark opacity-75 mb-0">Klik pada salah satu kartu pasien di sebelah kiri untuk melihat form dan memberikan penanganan medis.</p>
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
            <div class="d-flex justify-content-center align-items-center py-5 h-100">
                <div class="spinner-border text-dark" style="width: 3rem; height: 3rem; border-width: 5px;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
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
                    <div class="card-retro border-dark bg-danger p-4 text-center">
                        <h4 class="fw-bolder text-white">Gagal Memuat Data!</h4>
                        <p class="text-white fw-bold mb-0">Terjadi kesalahan pada server. Silakan coba lagi.</p>
                    </div>
                `);
            });
        });
    });
</script>
@endsection
