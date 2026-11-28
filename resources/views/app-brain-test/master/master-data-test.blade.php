@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-indigo-soft: rgba(79, 70, 229, 0.12);
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-emerald: #059669;
        --ent-sky: #0284c7;
        --ent-amber: #d97706;
        --ent-rose: #e11d48;
        --ent-solid-bg: #ffffff;
        --ent-solid-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .font-mono-code {
        font-family: 'JetBrains Mono', monospace;
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 15px 20px;
    }

    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 18px;
        box-shadow: 0 14px 32px -8px rgba(15, 23, 42, 0.25);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -55%;
        right: -5%;
        width: 380px;
        height: 380px;
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

    .form-control,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .form-control[type="file"] {
        padding-top: 6px;
        padding-bottom: 6px;
        font-weight: 500 !important;
        font-size: 0.76rem !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.14) !important;
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        cursor: pointer;
        font-size: 0.82rem;
    }

    .ent-btn:hover {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.28);
    }

    .ent-btn-primary:hover {
        box-shadow: 0 6px 18px rgba(79, 70, 229, 0.4);
        color: #ffffff;
    }

    .ent-btn-light {
        background-color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.35);
        color: #0f172a;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.18);
    }

    .ent-btn-light:hover {
        background-color: #f8fafc;
        color: #0f172a;
    }

    .icon-shape-sm {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        flex-shrink: 0;
    }

    .card-feature-hover {
        transition: all 0.2s ease;
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 16px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 4px 18px -4px rgba(15, 23, 42, 0.07);
    }

    .card-feature-hover:hover {
        transform: translateY(-3px);
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 12px 24px -6px rgba(79, 70, 229, 0.16);
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

    .ent-nav-pills .nav-link {
        border: 1px solid var(--ent-grid-border);
        border-radius: 10px !important;
        font-weight: 600;
        font-size: 0.82rem;
        color: var(--bs-body-color);
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        padding: 8px 16px;
        transition: all 0.18s ease;
    }

    .ent-nav-pills .nav-link:hover {
        border-color: var(--ent-indigo);
        background-color: rgba(79, 70, 229, 0.08);
    }

    .ent-nav-pills .nav-link.active {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%) !important;
        border-color: transparent !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.28);
    }

    .ent-paket-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        background-color: rgba(79, 70, 229, 0.025);
        padding: 14px;
    }

    .ent-kategori-row {
        border: 1px solid var(--ent-grid-border);
        border-radius: 10px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        transition: border-color 0.18s ease, background-color 0.18s ease;
    }

    .ent-kategori-row:hover {
        border-color: rgba(79, 70, 229, 0.45);
        background-color: rgba(79, 70, 229, 0.05);
    }

    .ent-table thead th {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .ent-table tbody td {
        border-bottom-color: var(--ent-grid-border) !important;
        font-size: 0.84rem;
    }

    .ent-modal-content {
        border: 1px solid var(--ent-grid-border);
        border-radius: 18px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 24px 48px -12px rgba(15, 23, 42, 0.25);
        overflow: hidden;
    }

    .ent-modal-header {
        background-color: rgba(79, 70, 229, 0.06);
        border-bottom: 1px solid var(--ent-grid-border);
        padding: 16px 22px;
    }

    .ent-opsi-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 10px 12px;
        background-color: rgba(79, 70, 229, 0.02);
        transition: border-color 0.18s ease;
    }

    .ent-opsi-card:hover {
        border-color: rgba(79, 70, 229, 0.45);
    }

    .img-preview-box {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 10px;
        border: 1px dashed var(--ent-grid-border);
        border-radius: 10px;
        background-color: rgba(79, 70, 229, 0.04);
    }

    .img-preview-thumb {
        max-height: 76px;
        max-width: 150px;
        object-fit: contain;
        border-radius: 8px;
        border: 1px solid var(--ent-grid-border);
        background-color: #ffffff;
    }

    .soal-list-img {
        max-height: 110px;
        max-width: 220px;
        object-fit: contain;
        border-radius: 8px;
        border: 1px solid var(--ent-grid-border);
        background-color: #ffffff;
    }

    .opsi-list-img {
        max-height: 56px;
        max-width: 110px;
        object-fit: contain;
        border-radius: 6px;
        border: 1px solid var(--ent-grid-border);
        background-color: #ffffff;
        vertical-align: middle;
    }

    .modal-dialog-scrollable .modal-content.ent-modal-content {
        max-height: 100%;
        overflow: hidden !important;
        display: flex;
        flex-direction: column;
    }

    .modal-dialog-scrollable .ent-modal-content>form {
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
        min-height: 0;
        overflow: hidden;
    }

    .modal-dialog-scrollable .ent-modal-content .ent-modal-header,
    .modal-dialog-scrollable .ent-modal-content .modal-footer {
        flex-shrink: 0;
    }

    .modal-dialog-scrollable .ent-modal-content .modal-body {
        flex: 1 1 auto;
        min-height: 0;
        overflow-y: auto !important;
    }
</style>
@endsection

@section('content')
<!-- Hero Header Master Data Tes -->
<div class="card mb-3 ent-header-banner p-1">
    <div class="card-body position-relative p-4" style="z-index: 2;">
        <div class="row align-items-center gy-3">
            <div class="col-lg-5">
                <div class="ent-glass-pill d-inline-flex align-items-center rounded-pill px-3 py-1 mb-2">
                    <i class="fas fa-layer-group me-2 text-info" style="font-size: 0.78rem;"></i>
                    <small class="fw-semibold" style="font-size: 0.76rem; color: #cbd5e1;">Klasifikasi &rarr; Nama Tes &rarr; Kategori &rarr; Soal</small>
                </div>
                <h3 class="fw-bold mb-1" style="letter-spacing: -0.02em; color: #ffffff;">
                    Manajemen Master Data Tes
                </h3>
                <p class="mb-0" style="color: #cbd5e1; font-size: 0.88rem;">
                    Kelola klasifikasi ujian, nama paket tes, kategori materi (TIU/TWK/TKP), dan bank soal.
                </p>
            </div>
            <div class="col-lg-7 d-flex flex-wrap justify-content-lg-end gap-2">
                <button type="button" class="btn ent-btn px-3 py-2" style="background-color: rgba(16, 185, 129, 0.22); color: #6ee7b7; border: 1px solid rgba(110, 231, 183, 0.45);" data-bs-toggle="modal" data-bs-target="#modalImportMasterLengkap">
                    <i class="fas fa-file-excel me-1"></i> Import Master Excel
                </button>
                <button type="button" class="btn ent-btn ent-btn-light px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahKlasifikasi">
                    <i class="fas fa-folder-plus me-1 text-primary"></i> Klasifikasi
                </button>
                <button type="button" class="btn ent-btn px-3 py-2" style="background-color: rgba(2, 132, 199, 0.2); color: #7dd3fc; border: 1px solid rgba(125, 211, 252, 0.4);" data-bs-toggle="modal" data-bs-target="#modalTambahPaket">
                    <i class="fas fa-file-signature me-1"></i> Nama Tes
                </button>
                <button type="button" class="btn ent-btn ent-btn-primary px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                    <i class="fas fa-plus me-1"></i> Kategori
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Notifikasi Flash Message -->
@if(session('success'))
<div class="alert alert-dismissible fade show mb-3 d-flex align-items-center justify-content-between" role="alert" style="border-radius: 12px; border: 1px solid rgba(5, 150, 105, 0.35); background-color: rgba(5, 150, 105, 0.12); color: #10b981;">
    <div class="fw-semibold" style="font-size: 0.85rem;">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Filter / Navigasi Klasifikasi Tes (Dynamic Tabs) -->
<div class="ent-card mb-3">
    <div class="card-body p-3">
        <ul class="nav nav-pills ent-nav-pills gap-2 flex-wrap" id="klasifikasiTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#content-all" type="button" role="tab">
                    <i class="fas fa-border-all me-1"></i> Semua Klasifikasi
                </button>
            </li>
            @foreach($klasifikasiList as $klas)
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-{{ $klas->id }}" data-bs-toggle="pill" data-bs-target="#content-{{ $klas->id }}" type="button" role="tab">
                    {{ $klas->nama_klasifikasi }}
                </button>
            </li>
            @endforeach
        </ul>
    </div>
</div>

<!-- Konten Berdasarkan Klasifikasi -->
<div class="tab-content" id="klasifikasiTabContent">

    <!-- Tab: Semua Klasifikasi -->
    <div class="tab-pane fade show active" id="content-all" role="tabpanel">
        <div class="row g-3 g-md-3">
            @forelse($klasifikasiList as $klas)
            <div class="col-xl-6">
                <div class="card-feature-hover h-100 d-flex flex-column justify-content-between" style="border-top: 4px solid var(--ent-indigo) !important;">
                    <div class="p-4">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <div>
                                <span class="ent-badge mb-2" style="background-color: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.32);">
                                    Klasifikasi Utama
                                </span>
                                <h5 class="fw-bold mb-1">{{ $klas->nama_klasifikasi }}</h5>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <button type="button" class="btn ent-btn px-2.5 py-1 btn-tambah-paket"
                                    style="background-color: rgba(2, 132, 199, 0.12); color: #0ea5e9; border: 1px solid rgba(2, 132, 199, 0.3);"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalTambahPaket"
                                    data-klasifikasi-id="{{ $klas->id }}">
                                    <i class="fas fa-plus me-1"></i> Tes
                                </button>
                                <div class="dropdown">
                                    <button class="btn ent-btn px-2.5 py-1" type="button" data-bs-toggle="dropdown" style="background-color: rgba(79, 70, 229, 0.08); border: 1px solid var(--ent-grid-border);">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow" style="border-radius: 12px; border: 1px solid var(--ent-grid-border);">
                                        <li>
                                            <form action="{{ route('admin.brain-test.klasifikasi.destroy', $klas->id) }}" method="POST" onsubmit="return confirm('Hapus klasifikasi ini beserta seluruh nama tes, kategori, dan soal di dalamnya?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger fw-semibold" style="font-size: 0.82rem;">
                                                    <i class="fas fa-trash me-2"></i>Hapus Klasifikasi
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <p class="opacity-75 mb-3" style="font-size: 0.82rem; line-height: 1.55;">
                            {{ $klas->deskripsi ?? 'Tidak ada deskripsi.' }}
                        </p>

                        <!-- Daftar Nama Tes / Paket di dalam Klasifikasi -->
                        <div class="d-flex flex-column gap-3">
                            @forelse($klas->pakets as $paket)
                            <div class="ent-paket-box">
                                <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                                    <div>
                                        <span class="fw-bold d-block" style="font-size: 0.9rem;">
                                            <i class="fas fa-file-alt text-primary me-1"></i> {{ $paket->nama_test }}
                                        </span>
                                        <span class="opacity-75 font-mono-code" style="font-size: 0.72rem;">
                                            Durasi: {{ $paket->durasi_menit }} mnt &bull; Passing Grade: {{ $paket->passing_grade }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <a href="{{ route('admin.brain-test.preview', $paket->id) }}" class="btn ent-btn px-2 py-1" style="background-color: rgba(5, 150, 105, 0.12); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.3);" title="Preview Tryout">
                                            <i class="fas fa-play"></i>
                                        </a>
                                        <button type="button" class="btn ent-btn px-2 py-1 btn-tambah-kategori"
                                            style="background-color: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3);"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalTambahKategori"
                                            data-paket-id="{{ $paket->id }}"
                                            title="Tambah Kategori">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <form action="{{ route('admin.brain-test.paket.destroy', $paket->id) }}" method="POST" onsubmit="return confirm('Hapus nama tes ini beserta kategorinya?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn ent-btn px-2 py-1" style="background-color: rgba(225, 29, 72, 0.12); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.3);" title="Hapus Tes">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Daftar Kategori (TIU, TWK, TKP, dll.) di dalam Paket -->
                                <div class="d-flex flex-column gap-1 mt-2">
                                    @forelse($paket->kategoris as $kat)
                                    <div class="ent-kategori-row d-flex justify-content-between align-items-center py-1 px-2">
                                        <div>
                                            <span class="fw-bold" style="font-size: 0.82rem;">{{ $kat->nama_kategori }}</span>
                                            <span class="opacity-75 font-mono-code ms-2" id="kat-count-all-{{ $kat->id }}" style="font-size: 0.72rem;">({{ $kat->soals_count ?? 0 }} Soal)</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-1">
                                            <button type="button" class="btn ent-btn px-2 py-0.5 btn-kelola-soal"
                                                style="background-color: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3); font-size: 0.75rem;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalKelolaSoal"
                                                data-id="{{ $kat->id }}"
                                                data-nama="{{ $paket->nama_test }} - {{ $kat->nama_kategori }}">
                                                <i class="fas fa-list-ol me-1"></i> Soal
                                            </button>
                                            <form action="{{ route('admin.brain-test.kategori.destroy', $kat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn ent-btn px-2 py-0.5" style="background-color: rgba(225, 29, 72, 0.12); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.3); font-size: 0.75rem;" title="Hapus Kategori">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="opacity-75 fst-italic py-1" style="font-size: 0.78rem;">Belum ada kategori (TIU/TWK/TKP) pada tes ini.</div>
                                    @endforelse
                                </div>
                            </div>
                            @empty
                            <div class="opacity-75 fst-italic py-2" style="font-size: 0.82rem;">Belum ada nama tes di klasifikasi ini.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="px-4 pb-4 pt-2">
                        <button type="button" class="btn ent-btn w-100 py-2 btn-tambah-paket"
                            style="background-color: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3);"
                            data-bs-toggle="modal"
                            data-bs-target="#modalTambahPaket"
                            data-klasifikasi-id="{{ $klas->id }}">
                            <i class="fas fa-plus-circle me-1"></i> Tambah Nama Tes ke {{ $klas->nama_klasifikasi }}
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="ent-card p-5 text-center">
                    <p class="opacity-75 mb-0" style="font-size: 0.88rem;">Belum ada data klasifikasi tes. Silakan klik tombol <strong>Klasifikasi</strong> atau <strong>Import Master Excel</strong> di atas.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Tab Dinamis Per Klasifikasi -->
    @foreach($klasifikasiList as $klas)
    <div class="tab-pane fade" id="content-{{ $klas->id }}" role="tabpanel">
        <div class="ent-card">
            <div class="ent-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div>
                    <h6 class="fw-bold mb-0">{{ $klas->nama_klasifikasi }}</h6>
                    <small class="opacity-75">{{ $klas->deskripsi ?? 'Daftar nama tes dan kategori soal.' }}</small>
                </div>
                <button type="button" class="btn ent-btn ent-btn-primary px-3 py-1 btn-tambah-paket"
                    data-bs-toggle="modal"
                    data-bs-target="#modalTambahPaket"
                    data-klasifikasi-id="{{ $klas->id }}">
                    <i class="fas fa-plus me-1"></i> Tambah Nama Tes
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 ent-table">
                        <thead>
                            <tr>
                                <th class="py-3 ps-4" style="width: 60px;">No</th>
                                <th class="py-3">Nama Tes / Paket</th>
                                <th class="py-3">Durasi &amp; PG</th>
                                <th class="py-3">Kategori &amp; Jumlah Soal</th>
                                <th class="py-3 pe-4 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($klas->pakets as $index => $paket)
                            <tr>
                                <td class="fw-bold ps-4 font-mono-code">{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $paket->nama_test }}</td>
                                <td class="font-mono-code" style="font-size: 0.78rem;">{{ $paket->durasi_menit }}m / PG {{ $paket->passing_grade }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($paket->kategoris as $kat)
                                        <button type="button" class="btn ent-btn px-2.5 py-1 btn-kelola-soal"
                                            style="background-color: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.3); font-size: 0.76rem;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalKelolaSoal"
                                            data-id="{{ $kat->id }}"
                                            data-nama="{{ $paket->nama_test }} - {{ $kat->nama_kategori }}">
                                            {{ $kat->nama_kategori }} (<span id="kat-count-tab-{{ $kat->id }}">{{ $kat->soals_count ?? 0 }}</span>)
                                        </button>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="pe-4 text-end">
                                    <button type="button" class="btn ent-btn px-2.5 py-1 btn-tambah-kategori"
                                        style="background-color: rgba(5, 150, 105, 0.12); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.3);"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalTambahKategori"
                                        data-paket-id="{{ $paket->id }}">
                                        <i class="fas fa-plus me-1"></i> Kategori
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 opacity-75 fst-italic">Belum ada nama tes pada klasifikasi ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>

<!-- Modal Import Master Lengkap (Level 1 Klasifikasi -> Level 4 Soal) -->
<div class="modal fade" id="modalImportMasterLengkap" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ent-modal-content">
            <div class="ent-modal-header d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                    <span class="icon-shape-sm" style="background-color: rgba(5, 150, 105, 0.14); color: #10b981;">
                        <i class="fas fa-file-excel"></i>
                    </span>
                    Import Master Data Tes Lengkap
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formImportMasterLengkap" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold" style="font-size: 0.78rem;">Pilih File Excel (.xlsx / .xls / .csv)</label>
                        <input type="file" name="file_excel" class="form-control" accept=".xlsx,.xls,.csv" required>
                    </div>
                    <div class="p-3" style="border: 1px solid var(--ent-grid-border); border-radius: 12px; background-color: rgba(79, 70, 229, 0.04); font-size: 0.8rem;">
                        <div class="fw-bold mb-1"><i class="fas fa-info-circle me-1 text-primary"></i> Ketentuan Sheet <code>Import_Master_Lengkap</code>:</div>
                        <ul class="mb-0 ps-3 opacity-75">
                            <li><strong>nama_klasifikasi, nama_test, nama_kategori</strong>: Otomatis dibuat jika belum ada</li>
                            <li><strong>durasi_menit, passing_grade_paket, passing_grade_kategori, urutan_kategori</strong>: Konfigurasi paket &amp; kategori</li>
                            <li><strong>tipe_soal, pertanyaan, opsi_a..opsi_e, poin_a..poin_e, kunci_jawaban, kunci_jawaban_isian, bobot_nilai, pembahasan</strong></li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid var(--ent-grid-border);">
                    <button type="button" class="btn ent-btn px-3 py-2" style="background-color: rgba(100, 116, 139, 0.12); border: 1px solid var(--ent-grid-border);" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn px-4 py-2" style="background: linear-gradient(135deg, #059669 0%, #047857 100%); color: #ffffff; border: none;">
                        <i class="fas fa-upload me-1"></i> Upload &amp; Import Master
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Klasifikasi -->
<div class="modal fade" id="modalTambahKlasifikasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ent-modal-content">
            <div class="ent-modal-header d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                    <span class="icon-shape-sm" style="background-color: rgba(79, 70, 229, 0.14); color: #6366f1;">
                        <i class="fas fa-folder-plus"></i>
                    </span>
                    Tambah Klasifikasi Tes
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.brain-test.klasifikasi.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold" style="font-size: 0.78rem;">Nama Klasifikasi Tes</label>
                        <input type="text" name="nama_klasifikasi" class="form-control" placeholder="Contoh: Tes CPNS, Tes BUMN" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold" style="font-size: 0.78rem;">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Keterangan singkat klasifikasi tes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid var(--ent-grid-border);">
                    <button type="button" class="btn ent-btn px-3 py-2" style="background-color: rgba(100, 116, 139, 0.12); border: 1px solid var(--ent-grid-border);" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-primary px-4 py-2">Simpan Klasifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Nama Tes / Paket -->
<div class="modal fade" id="modalTambahPaket" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ent-modal-content">
            <div class="ent-modal-header d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                    <span class="icon-shape-sm" style="background-color: rgba(2, 132, 199, 0.14); color: #0ea5e9;">
                        <i class="fas fa-file-signature"></i>
                    </span>
                    Tambah Nama Tes / Paket
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.brain-test.paket.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold" style="font-size: 0.78rem;">Klasifikasi Tes</label>
                        <select name="klasifikasi_id" id="selectKlasifikasiId" class="form-select" required>
                            <option value="">-- Pilih Klasifikasi --</option>
                            @foreach($klasifikasiList as $klas)
                            <option value="{{ $klas->id }}">{{ $klas->nama_klasifikasi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold" style="font-size: 0.78rem;">Nama Tes</label>
                        <input type="text" name="nama_test" class="form-control" placeholder="Contoh: Soal CPNS 2025, Soal CPNS 2026" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold" style="font-size: 0.78rem;">Durasi (Menit)</label>
                            <input type="number" name="durasi_menit" class="form-control font-mono-code" value="60" min="1" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold" style="font-size: 0.78rem;">Passing Grade</label>
                            <input type="number" name="passing_grade" class="form-control font-mono-code" value="0" min="0" required>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold" style="font-size: 0.78rem;">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" class="form-control" rows="2" placeholder="Keterangan paket tes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid var(--ent-grid-border);">
                    <button type="button" class="btn ent-btn px-3 py-2" style="background-color: rgba(100, 116, 139, 0.12); border: 1px solid var(--ent-grid-border);" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-primary px-4 py-2">Simpan Nama Tes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori (TIU, TWK, TKP, dll.) -->
<div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ent-modal-content">
            <div class="ent-modal-header d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                    <span class="icon-shape-sm" style="background-color: rgba(79, 70, 229, 0.14); color: #6366f1;">
                        <i class="fas fa-tags"></i>
                    </span>
                    Tambah Kategori Soal
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.brain-test.kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold" style="font-size: 0.78rem;">Pilih Nama Tes / Paket</label>
                        <select name="paket_id" id="selectPaketId" class="form-select" required>
                            <option value="">-- Pilih Nama Tes --</option>
                            @foreach($klasifikasiList as $klas)
                            <optgroup label="{{ $klas->nama_klasifikasi }}">
                                @foreach($klas->pakets as $paket)
                                <option value="{{ $paket->id }}">{{ $paket->nama_test }}</option>
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold" style="font-size: 0.78rem;">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: TIU, TWK, TKP" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold" style="font-size: 0.78rem;">Passing Grade Kategori</label>
                            <input type="number" name="passing_grade" class="form-control font-mono-code" value="0" min="0">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold" style="font-size: 0.78rem;">Urutan</label>
                            <input type="number" name="urutan" class="form-control font-mono-code" value="1" min="1">
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold" style="font-size: 0.78rem;">Deskripsi (Opsional)</label>
                        <textarea name="deskripsi" class="form-control" rows="2" placeholder="Keterangan singkat kategori..."></textarea>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid var(--ent-grid-border);">
                    <button type="button" class="btn ent-btn px-3 py-2" style="background-color: rgba(100, 116, 139, 0.12); border: 1px solid var(--ent-grid-border);" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-primary px-4 py-2">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Kelola Soal (Utama) -->
<div class="modal fade" id="modalKelolaSoal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ent-modal-content">
            <div class="ent-modal-header d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="fw-bold mb-0" id="modalSoalTitle">Kelola Bank Soal</h6>
                    <small class="opacity-75">Kelola pertanyaan (teks/gambar/isian) dan opsi jawaban langsung dari sini.</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="modalSoalBody">
                <div class="text-center py-5" id="soalLoading">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="opacity-75 mt-2 mb-0" style="font-size: 0.84rem;">Memuat data soal...</p>
                </div>

                <div id="soalContentWrapper" style="display: none;">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <h6 class="fw-bold mb-0">Daftar Pertanyaan</h6>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn ent-btn px-3 py-1" style="background-color: rgba(5, 150, 105, 0.12); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.35);" data-bs-toggle="modal" data-bs-target="#modalImportExcelInModal">
                                <i class="fas fa-file-excel me-1"></i> Import Excel
                            </button>
                            <button type="button" class="btn ent-btn ent-btn-primary px-3 py-1" data-bs-toggle="modal" data-bs-target="#modalTambahSoalInModal">
                                <i class="fas fa-plus me-1"></i> Tambah Soal
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive" style="border: 1px solid var(--ent-grid-border); border-radius: 12px;">
                        <table class="table table-hover align-middle mb-0 ent-table">
                            <thead>
                                <tr>
                                    <th class="py-3 ps-3" style="width: 60px;">No</th>
                                    <th class="py-3">Pertanyaan, Pilihan &amp; Pembahasan</th>
                                    <th class="py-3 text-center" style="width: 130px;">Tipe / Opsi</th>
                                    <th class="py-3 pe-3 text-end" style="width: 90px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tabelSoalBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer px-4 py-3" style="border-top: 1px solid var(--ent-grid-border);">
                <button type="button" class="btn ent-btn px-4 py-2" style="background-color: rgba(100, 116, 139, 0.12); border: 1px solid var(--ent-grid-border);" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Soal Manual (Sub-Modal) -->
<div class="modal fade" id="modalTambahSoalInModal" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content ent-modal-content">
            <div class="ent-modal-header d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">Tambah Soal Manual (Teks &amp; Gambar)</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambahSoalAjax" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="kategori_id" id="inputKategoriId">
                <div class="modal-body p-4">
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="font-size: 0.78rem;">Tipe Soal</label>
                            <select name="tipe_soal" id="selectTipeSoalManual" class="form-select">
                                <option value="pilihan_ganda" selected>Pilihan Ganda (A–E)</option>
                                <option value="isian">Isian Singkat</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="font-size: 0.78rem;">Bobot Nilai Default</label>
                            <input type="number" name="bobot_nilai" class="form-control font-mono-code" value="5" min="1">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold" style="font-size: 0.78rem;">Pertanyaan Soal</label>
                        <textarea name="pertanyaan" id="inputPertanyaanSoal" class="form-control" rows="2" placeholder="Tuliskan teks pertanyaan (boleh dikosongkan jika soal murni gambar)..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold" style="font-size: 0.78rem;">
                            <i class="fas fa-image me-1 text-primary"></i> Gambar Soal (Opsional)
                        </label>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <input type="file" name="gambar_soal" id="inputGambarSoal" class="form-control flex-grow-1" accept="image/jpeg,image/png,image/webp,image/gif" onchange="previewSoalImage(this)">
                            <button type="button" id="btnResetGambarSoal" class="btn ent-btn px-2.5 py-2" style="display: none; background-color: rgba(225, 29, 72, 0.12); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.3);" onclick="resetSoalImage()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div id="previewGambarSoalWrapper" class="mt-2" style="display: none;">
                            <div class="img-preview-box">
                                <img id="previewGambarSoal" src="" alt="Preview Gambar Soal" class="img-preview-thumb">
                                <span class="opacity-75 font-mono-code" style="font-size: 0.72rem;">Preview Soal</span>
                            </div>
                        </div>
                    </div>

                    <!-- Box Kunci Jawaban Isian (Tampil jika tipe_soal == isian) -->
                    <div id="boxKunciIsianManual" class="mb-3" style="display: none;">
                        <label class="form-label fw-bold" style="font-size: 0.78rem;">Kunci Jawaban Isian</label>
                        <input type="text" name="kunci_jawaban_isian" class="form-control" placeholder="Contoh: 1 Juni">
                    </div>

                    <div id="wrapperOpsiManual">
                        <hr style="border-color: var(--ent-grid-border);">

                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-1 mb-2">
                            <label class="form-label fw-bold mb-0" style="font-size: 0.78rem;">
                                Pilihan Opsi Jawaban (A–E: Bisa Teks, Gambar, atau Keduanya)
                            </label>
                            <span class="opacity-75 font-mono-code" style="font-size: 0.72rem;">Radio = Kunci Jawaban</span>
                        </div>

                        <div id="opsi-container" class="d-flex flex-column gap-2">
                            @php $hurufOpsi = ['A', 'B', 'C', 'D', 'E']; @endphp
                            @for($i = 0; $i < 5; $i++)
                                @php $isWajib=$i < 4; @endphp
                                <div class="ent-opsi-card">
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <div class="d-flex align-items-center justify-content-center px-2 gap-1" style="height: 38px; min-width: 64px; border: 1px solid var(--ent-grid-border); border-radius: 10px; background-color: rgba(79, 70, 229, 0.05);">
                                            <input class="form-check-input mt-0" type="radio" name="jawaban_benar" value="{{ $i }}" {{ $i == 0 ? 'checked' : '' }} title="Kunci Jawaban {{ $hurufOpsi[$i] }}">
                                            <span class="fw-bold font-mono-code" style="font-size: 0.78rem;">{{ $hurufOpsi[$i] }}</span>
                                        </div>
                                        <input
                                            type="text"
                                            name="opsi[{{ $i }}][teks]"
                                            class="form-control flex-grow-1"
                                            style="min-width: 170px;"
                                            placeholder="Teks pilihan {{ $hurufOpsi[$i] }}{{ !$isWajib ? ' (Opsional)' : ' (Boleh kosong jika pakai gambar)' }}">
                                        <input
                                            type="number"
                                            name="opsi[{{ $i }}][poin]"
                                            class="form-control font-mono-code"
                                            style="max-width: 90px;"
                                            value="{{ $i == 0 ? 5 : 0 }}"
                                            placeholder="Poin">
                                    </div>

                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-2 pt-2" style="border-top: 1px dashed var(--ent-grid-border);">
                                        <div class="d-flex align-items-center gap-2 flex-grow-1">
                                            <span class="opacity-75" style="font-size: 0.74rem; white-space: nowrap;">
                                                <i class="fas fa-image me-1 text-info"></i> Gambar {{ $hurufOpsi[$i] }}:
                                            </span>
                                            <input
                                                type="file"
                                                name="opsi[{{ $i }}][gambar]"
                                                id="inputGambarOpsi_{{ $i }}"
                                                class="form-control"
                                                accept="image/jpeg,image/png,image/webp,image/gif"
                                                onchange="previewOpsiImage(this, {{ $i }})">
                                            <button
                                                type="button"
                                                id="btnResetGambarOpsi_{{ $i }}"
                                                class="btn ent-btn px-2 py-1"
                                                style="display: none; background-color: rgba(225, 29, 72, 0.12); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.3);"
                                                title="Hapus Gambar Opsi {{ $hurufOpsi[$i] }}"
                                                onclick="resetOpsiImage({{ $i }})">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>

                                        <div id="previewGambarOpsiWrapper_{{ $i }}" style="display: none;">
                                            <img id="previewGambarOpsi_{{ $i }}" src="" alt="Preview Opsi {{ $hurufOpsi[$i] }}" class="opsi-list-img">
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label fw-bold" style="font-size: 0.78rem;">Pembahasan Soal (Opsional)</label>
                        <textarea name="pembahasan" class="form-control" rows="2" placeholder="Penjelasan kunci jawaban untuk peserta setelah ujian selesai..."></textarea>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid var(--ent-grid-border);">
                    <button type="button" class="btn ent-btn px-3 py-2" style="background-color: rgba(100, 116, 139, 0.12); border: 1px solid var(--ent-grid-border);" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn ent-btn-primary px-4 py-2">Simpan Soal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import Excel Soal per Kategori (Sub-Modal) -->
<div class="modal fade" id="modalImportExcelInModal" tabindex="-1" aria-hidden="true" style="z-index: 1070;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ent-modal-content">
            <div class="ent-modal-header d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0">Import Soal ke Kategori via Excel</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formImportExcel" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold" style="font-size: 0.78rem;">Pilih File Excel (.xlsx / .xls / .csv)</label>
                        <input type="file" name="file_excel" class="form-control" accept=".xlsx, .xls, .csv" required>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('admin.brain-test.soal.template') }}" class="text-decoration-none fw-bold text-primary" style="font-size: 0.8rem;">
                            <i class="fas fa-download me-1"></i> Download Contoh Format Template Soal (CSV)
                        </a>
                    </div>
                    <div class="p-3" style="border: 1px solid var(--ent-grid-border); border-radius: 12px; background-color: rgba(79, 70, 229, 0.04); font-size: 0.8rem;">
                        <div class="fw-bold mb-1"><i class="fas fa-info-circle me-1 text-primary"></i> Ketentuan Kolom Excel (<code>Import_Bank_Soal</code>):</div>
                        <ul class="mb-0 ps-3 opacity-75">
                            <li><strong>tipe_soal</strong>: <code>pilihan_ganda</code> atau <code>isian</code></li>
                            <li><strong>pertanyaan</strong>: Teks soal (Wajib)</li>
                            <li><strong>opsi_a .. opsi_e</strong> &amp; <strong>poin_a .. poin_e</strong>: Pilihan jawaban &amp; poin masing-masing (misal 1–5 untuk TKP)</li>
                            <li><strong>kunci_jawaban</strong>: Huruf kapital A–E (atau isi <strong>kunci_jawaban_isian</strong> untuk tipe <code>isian</code>)</li>
                            <li><strong>bobot_nilai</strong> &amp; <strong>pembahasan</strong>: Opsional</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid var(--ent-grid-border);">
                    <button type="button" class="btn ent-btn px-3 py-2" style="background-color: rgba(100, 116, 139, 0.12); border: 1px solid var(--ent-grid-border);" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn ent-btn px-4 py-2" style="background: linear-gradient(135deg, #059669 0%, #047857 100%); color: #ffffff; border: none;">Upload &amp; Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script>
    function resolveStorageImg(path) {
        if (!path) return '';
        if (String(path).startsWith('http://') || String(path).startsWith('https://')) {
            return path;
        }
        return `{{ asset('storage') }}/${String(path).replace(/^\/+/, '')}`;
    }

    function escapeHtmlText(text) {
        if (text === null || text === undefined) return '';
        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function previewSoalImage(input) {
        const wrapper = document.getElementById('previewGambarSoalWrapper');
        const img = document.getElementById('previewGambarSoal');
        const btnReset = document.getElementById('btnResetGambarSoal');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                wrapper.style.display = 'block';
                btnReset.style.display = 'inline-flex';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            resetSoalImage();
        }
    }

    function resetSoalImage() {
        const input = document.getElementById('inputGambarSoal');
        const wrapper = document.getElementById('previewGambarSoalWrapper');
        const img = document.getElementById('previewGambarSoal');
        const btnReset = document.getElementById('btnResetGambarSoal');

        if (input) input.value = '';
        if (img) img.src = '';
        if (wrapper) wrapper.style.display = 'none';
        if (btnReset) btnReset.style.display = 'none';
    }

    function previewOpsiImage(input, index) {
        const wrapper = document.getElementById(`previewGambarOpsiWrapper_${index}`);
        const img = document.getElementById(`previewGambarOpsi_${index}`);
        const btnReset = document.getElementById(`btnResetGambarOpsi_${index}`);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                wrapper.style.display = 'block';
                btnReset.style.display = 'inline-flex';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            resetOpsiImage(index);
        }
    }

    function resetOpsiImage(index) {
        const input = document.getElementById(`inputGambarOpsi_${index}`);
        const wrapper = document.getElementById(`previewGambarOpsiWrapper_${index}`);
        const img = document.getElementById(`previewGambarOpsi_${index}`);
        const btnReset = document.getElementById(`btnResetGambarOpsi_${index}`);

        if (input) input.value = '';
        if (img) img.src = '';
        if (wrapper) wrapper.style.display = 'none';
        if (btnReset) btnReset.style.display = 'none';
    }

    function resetAllFormSoalMedia() {
        resetSoalImage();
        for (let i = 0; i < 5; i++) {
            resetOpsiImage(i);
        }
    }

    function loadDaftarSoalKategori(kategoriId) {
        document.getElementById('soalLoading').style.display = 'block';
        document.getElementById('soalContentWrapper').style.display = 'none';

        fetch(`{{ url('admin/brain-test/kategori') }}/${kategoriId}/json-soal`)
            .then(response => response.json())
            .then(data => {
                let tbody = document.getElementById('tabelSoalBody');
                tbody.innerHTML = '';

                // Update counter soal di tampilan utama
                const badgeAll = document.getElementById(`kat-count-all-${kategoriId}`);
                const badgeTab = document.getElementById(`kat-count-tab-${kategoriId}`);
                if (badgeAll) badgeAll.innerText = `(${data.length} Soal)`;
                if (badgeTab) badgeTab.innerText = data.length;

                if (data.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="4" class="text-center py-4 opacity-75 fst-italic">Belum ada soal pada kategori ini.</td></tr>`;
                } else {
                    const hurufArr = ['A', 'B', 'C', 'D', 'E'];
                    data.forEach((soal, index) => {
                        const tipeSoal = soal.tipe_soal || 'pilihan_ganda';
                        const soalImgHtml = soal.gambar ?
                            `<div class="mb-2"><img src="${escapeHtmlText(resolveStorageImg(soal.gambar))}" alt="Gambar Soal" class="soal-list-img"></div>` :
                            '';

                        let jawabanHtml = '';
                        if (tipeSoal === 'isian') {
                            jawabanHtml = `
                                <div class="mt-1 px-2.5 py-1.5 rounded-3 d-inline-block" style="background-color: rgba(5, 150, 105, 0.1); border: 1px solid rgba(5, 150, 105, 0.3); font-size: 0.78rem;">
                                    <span class="text-success fw-bold"><i class="fas fa-key me-1"></i> Kunci Isian:</span>
                                    <span class="font-mono-code fw-semibold">${escapeHtmlText(soal.kunci_jawaban_isian || '-')}</span>
                                </div>
                            `;
                        } else {
                            jawabanHtml = (soal.opsi_jawabans || []).map((opt, idxOpt) => {
                                const huruf = hurufArr[idxOpt] || '-';
                                const optImgHtml = opt.gambar ?
                                    `<div class="mt-1"><img src="${escapeHtmlText(resolveStorageImg(opt.gambar))}" alt="Gambar Opsi" class="opsi-list-img"></div>` :
                                    '';

                                return `
                                    <div class="mb-1 ${opt.is_benar ? 'text-success fw-bold' : 'opacity-75'}" style="font-size: 0.78rem;">
                                        <span class="font-mono-code fw-bold">${huruf}.</span> ${escapeHtmlText(opt.teks_jawaban || (opt.gambar ? '[Gambar]' : '-'))}
                                        ${opt.is_benar ? '<span class="badge bg-success-subtle text-success ms-1">Kunci</span>' : ''}
                                        <span class="font-mono-code opacity-75 ms-1">[${opt.poin ?? 0} poin]</span>
                                        ${optImgHtml}
                                    </div>
                                `;
                            }).join('');
                        }

                        const pembahasanHtml = soal.pembahasan ?
                            `<div class="mt-2 p-2 rounded-3 opacity-85" style="background-color: rgba(2, 132, 199, 0.06); border-left: 3px solid var(--ent-sky); font-size: 0.76rem;">
                                <strong class="text-info"><i class="fas fa-lightbulb me-1"></i>Pembahasan:</strong> ${escapeHtmlText(soal.pembahasan)}
                            </div>` :
                            '';

                        const badgeTipe = tipeSoal === 'isian'
                            ? `<span class="ent-badge mb-1" style="background-color: rgba(217, 119, 6, 0.14); color: #f59e0b; border: 1px solid rgba(217, 119, 6, 0.3);">Isian</span>`
                            : `<span class="ent-badge mb-1" style="background-color: rgba(79, 70, 229, 0.12); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.28);">${(soal.opsi_jawabans || []).length} Opsi PG</span>`;

                        tbody.innerHTML += `
                            <tr>
                                <td class="ps-3 fw-bold font-mono-code">${index + 1}</td>
                                <td>
                                    ${soal.pertanyaan ? `<div class="fw-bold mb-1">${escapeHtmlText(soal.pertanyaan)}</div>` : ''}
                                    ${soalImgHtml}
                                    <div>${jawabanHtml}</div>
                                    ${pembahasanHtml}
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column align-items-center">
                                        ${badgeTipe}
                                        <small class="font-mono-code opacity-75" style="font-size: 0.7rem;">Bobot: ${soal.bobot_nilai ?? 1}</small>
                                    </div>
                                </td>
                                <td class="pe-3 text-end">
                                    <button type="button" class="btn ent-btn px-2.5 py-1" style="background-color: rgba(225, 29, 72, 0.12); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.3);" onclick="hapusSoal(${soal.id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                }

                document.getElementById('soalLoading').style.display = 'none';
                document.getElementById('soalContentWrapper').style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('soalLoading').innerHTML = `<p class="text-danger mb-0" style="font-size: 0.84rem;">Gagal memuat data soal.</p>`;
            });
    }

    function hapusSoal(soalId) {
        if (!confirm('Hapus soal ini?')) return;

        fetch(`{{ url('admin/brain-test/soal') }}/${soalId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(res => {
                if (res.status === 'success' || res.success) {
                    if (window.activeKategoriId) {
                        loadDaftarSoalKategori(window.activeKategoriId);
                    }
                } else {
                    alert(res.message || 'Gagal menghapus soal.');
                }
            })
            .catch(() => alert('Terjadi kesalahan saat menghapus soal.'));
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Toggle form pilihan ganda vs isian pada modal tambah soal manual
        const selectTipeSoal = document.getElementById('selectTipeSoalManual');
        if (selectTipeSoal) {
            selectTipeSoal.addEventListener('change', function() {
                const isIsian = this.value === 'isian';
                document.getElementById('boxKunciIsianManual').style.display = isIsian ? 'block' : 'none';
                document.getElementById('wrapperOpsiManual').style.display = isIsian ? 'none' : 'block';
            });
        }

        // Pre-select klasifikasi saat tombol tambah tes di klasifikasi diklik
        document.querySelectorAll('.btn-tambah-paket').forEach(btn => {
            btn.addEventListener('click', function() {
                const klasId = this.getAttribute('data-klasifikasi-id');
                if (klasId) {
                    document.getElementById('selectKlasifikasiId').value = klasId;
                }
            });
        });

        // Pre-select paket saat tombol tambah kategori di paket diklik
        document.querySelectorAll('.btn-tambah-kategori').forEach(btn => {
            btn.addEventListener('click', function() {
                const paketId = this.getAttribute('data-paket-id');
                if (paketId) {
                    document.getElementById('selectPaketId').value = paketId;
                }
            });
        });

        const modalKelolaSoal = document.getElementById('modalKelolaSoal');
        modalKelolaSoal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            if (!button) return;

            const kategoriId = button.getAttribute('data-id');
            const namaKategori = button.getAttribute('data-nama');

            document.getElementById('modalSoalTitle').innerText = 'Bank Soal: ' + namaKategori;
            document.getElementById('inputKategoriId').value = kategoriId;
            window.activeKategoriId = kategoriId;

            loadDaftarSoalKategori(kategoriId);
        });
    });

    // Submit Tambah Soal Manual
    document.getElementById('formTambahSoalAjax').addEventListener('submit', function(e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);
        let kategoriId = document.getElementById('inputKategoriId').value || window.activeKategoriId;

        if (!kategoriId) {
            alert('ID Kategori tidak ditemukan.');
            return;
        }

        const pertanyaanVal = (document.getElementById('inputPertanyaanSoal')?.value || '').trim();
        const gambarSoalFile = document.getElementById('inputGambarSoal')?.files?.[0];
        if (!pertanyaanVal && !gambarSoalFile) {
            alert('Isi teks pertanyaan atau unggah gambar soal terlebih dahulu.');
            return;
        }

        let submitBtn = form.querySelector('button[type="submit"]');
        let originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...`;

        fetch(`{{ url('admin/brain-test/kategori') }}/${kategoriId}/soal`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json().then(data => ({
                status: response.status,
                body: data
            })))
            .then(res => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;

                if (res.status === 200 || res.status === 201 || res.body.status === 'success') {
                    const subModalEl = document.getElementById('modalTambahSoalInModal');
                    const subModal = bootstrap.Modal.getInstance(subModalEl);
                    if (subModal) subModal.hide();

                    form.reset();
                    resetAllFormSoalMedia();
                    document.getElementById('boxKunciIsianManual').style.display = 'none';
                    document.getElementById('wrapperOpsiManual').style.display = 'block';

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.body.message || 'Soal berhasil ditambahkan!',
                            timer: 1400,
                            showConfirmButton: false
                        });
                    }
                    loadDaftarSoalKategori(kategoriId);
                } else {
                    throw new Error(res.body.message || 'Gagal menyimpan soal.');
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                alert('Gagal: ' + error.message);
            });
    });

    // Submit Import Soal Excel ke Kategori Aktif
    document.getElementById('formImportExcel').addEventListener('submit', function(e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);
        let kategoriId = document.getElementById('inputKategoriId')?.value || window.activeKategoriId;

        if (!kategoriId) {
            alert('ID Kategori tidak ditemukan.');
            return;
        }

        let submitBtn = form.querySelector('button[type="submit"]');
        let originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Mengimpor...`;

        fetch(`{{ url('admin/brain-test/kategori') }}/${kategoriId}/soal/import`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json().then(data => ({
                status: response.status,
                body: data
            })))
            .then(res => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;

                if (res.status === 200 && res.body.status === 'success') {
                    const importModalEl = document.getElementById('modalImportExcelInModal');
                    const importModal = bootstrap.Modal.getInstance(importModalEl);
                    if (importModal) importModal.hide();

                    form.reset();

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Import Berhasil!',
                            text: res.body.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                    loadDaftarSoalKategori(kategoriId);
                } else {
                    throw new Error(res.body.message || 'Terjadi kesalahan saat mengimpor data.');
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                alert('Gagal: ' + error.message);
            });
    });

    // Submit Import Master Lengkap (Klasifikasi -> Paket -> Kategori -> Soal)
    document.getElementById('formImportMasterLengkap').addEventListener('submit', function(e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        let submitBtn = form.querySelector('button[type="submit"]');
        let originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1"></span> Mengimpor Master...`;

        fetch(`{{ route('admin.brain-test.master.import') }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json().then(data => ({
                status: response.status,
                body: data
            })))
            .then(res => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;

                if (res.status === 200 && res.body.status === 'success') {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.body.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        alert(res.body.message);
                        location.reload();
                    }
                } else {
                    throw new Error(res.body.message || 'Gagal mengimpor master data tes.');
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                alert('Gagal: ' + error.message);
            });
    });
</script>
@endsection
