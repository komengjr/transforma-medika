@extends('layouts.layouts')

@section('content')
<style>
    /* Custom Styling Photobooth Studio Dashboard */
    .pb-header-gradient {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #db2777 100%);
    }

    .pb-card-glass {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(229, 231, 235, 0.8);
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .pb-card-glass:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.08);
    }

    .pb-checkerboard {
        background-color: #f8fafc;
        background-image: linear-gradient(45deg, #e2e8f0 25%, transparent 25%),
            linear-gradient(-45deg, #e2e8f0 25%, transparent 25%),
            linear-gradient(45deg, transparent 75%, #e2e8f0 75%),
            linear-gradient(-45deg, transparent 75%, #e2e8f0 75%);
        background-size: 16px 16px;
        background-position: 0 0, 0 8px, 8px -8px, -8px 0px;
    }

    .pb-frame-item {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .pb-frame-item:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12) !important;
    }
</style>

<div class="container-fluid py-4 px-md-5">

    <!-- Header Section -->
    <div class="card pb-header-gradient text-white border-0 shadow-lg rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4 p-md-5 d-flex flex-column flex-md-row justify-content-between align-items-md-center position-relative">
            <div class="z-1">
                <span class="badge bg-white text-dark fw-bold mb-2 px-3 py-2 rounded-pill shadow-sm">
                    📸 Studio Configurator
                </span>
                <h1 class="display-6 fw-bold mb-1">Master Setup Photobooth</h1>
                <p class="text-white-50 mb-0">Kelola master data organisasi, logo, background, dan frame transparan photobooth Anda.</p>
            </div>
        </div>
    </div>

    {{-- Alert Notifications --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill fs-5 me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="bi bi-exclamation-triangle-fill fs-5 me-2 mt-1"></i>
            <div>
                <strong class="d-block mb-1">Gagal Menyimpan Data:</strong>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Form Tambah Organisasi -->
    <div class="card pb-card-glass shadow-sm mb-5">
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex align-items-center">
            <div class="bg-primary bg-gradient text-white rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="bi bi-plus-lg fs-5"></i>
            </div>
            <h5 class="card-title fw-bold text-dark mb-0">Tambah Organisasi Baru</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('photobooth.setup.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-secondary small">Kode Organisasi (Unik)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-qr-code"></i></span>
                            <input type="text" name="org_code" class="form-control border-start-0 ps-0" placeholder="Contoh: PRAMITA-SBY" value="{{ old('org_code') }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-secondary small">Nama Organisasi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-building"></i></span>
                            <input type="text" name="org_name" class="form-control border-start-0 ps-0" placeholder="Pramita Lab Surabaya" value="{{ old('org_name') }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-secondary small">Logo Organisasi</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-secondary small">Background Utama</label>
                        <input type="file" name="background" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold rounded-3 shadow-sm">
                        <i class="bi bi-cloud-arrow-up-fill me-2"></i>Simpan Organisasi Baru
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Section Title -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h4 class="fw-bold text-dark mb-0 d-flex align-items-center">
            <i class="bi bi-collection-play me-2 text-primary"></i> Daftar Photobooth Organisasi
        </h4>
        <span class="badge bg-secondary rounded-pill px-3 py-2">Total: {{ count($photobooths) }} Organisasi</span>
    </div>

    <!-- Cards Loop Organisasi -->
    @forelse($photobooths as $pb)
    @php
    $logoUrl = $pb->logo_path
    ? (str_contains($pb->logo_path, 'photobooth/') ? asset('storage/' . $pb->logo_path) : asset('storage/photobooth/' . $pb->logo_path))
    : null;

    $bgUrl = $pb->bg_path
    ? (str_contains($pb->bg_path, 'photobooth/') ? asset('storage/' . $pb->bg_path) : asset('storage/photobooth/' . $pb->bg_path))
    : null;
    @endphp

    <div class="card pb-card-glass mb-4 shadow-sm">
        <div class="card-header bg-transparent border-bottom py-3 px-4 d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <span class="badge bg-dark text-white me-2 px-2 py-2 font-monospace">{{ $pb->org_code }}</span>
                <h5 class="fw-bold text-dark mb-0">{{ $pb->org_name }}</h5>
            </div>
            <a href="{{ route('photobooth.client', $pb->org_code) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm">
                <i class="bi bi-box-arrow-up-right me-1"></i> Buka Canvas Photobooth
            </a>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">

                <!-- Left Column: Master Assets -->
                <div class="col-lg-4 border-end-lg">
                    <div class="bg-light p-3 rounded-3 mb-3 border">
                        <label class="form-label fw-bold text-muted small uppercase mb-2 d-block">Logo Resmi</label>
                        @if($logoUrl)
                        <div class="p-3 bg-white rounded-3 text-center border shadow-sm">
                            <img src="{{ $logoUrl }}" height="60" style="object-fit: contain; max-width: 100%;" alt="Logo">
                        </div>
                        @else
                        <div class="text-center py-3 text-muted small bg-white rounded border">
                            <i class="bi bi-image text-secondary fs-4 d-block"></i> Belum ada logo
                        </div>
                        @endif
                    </div>

                    <div class="bg-light p-3 rounded-3 border">
                        <label class="form-label fw-bold text-muted small uppercase mb-2 d-block">Background Canvas</label>
                        @if($bgUrl)
                        <div class="p-1 bg-white rounded-3 border shadow-sm overflow-hidden text-center">
                            <img src="{{ $bgUrl }}" height="110" class="w-100 rounded" style="object-fit: cover;" alt="Background">
                        </div>
                        @else
                        <div class="text-center py-4 text-muted small bg-white rounded border">
                            <i class="bi bi-palette text-secondary fs-4 d-block"></i> Default Gradient
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Frames Gallery & Upload -->
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-dark mb-0">
                            <i class="bi bi-layers me-1 text-primary"></i> Frame Transparan (Overlay PNG)
                        </h6>
                        <span class="badge bg-light text-dark border">{{ count($pb->frames) }} Frame</span>
                    </div>

                    <!-- Gallery Frame -->
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        @forelse($pb->frames as $frame)
                        @php
                        $frameUrl = str_contains($frame->frame_path, 'photobooth/')
                        ? asset('storage/' . $frame->frame_path)
                        : asset('storage/photobooth/' . $frame->frame_path);
                        @endphp
                        <div class="pb-frame-item card border-0 shadow-sm rounded-3 overflow-hidden pb-checkerboard" style="width: 110px;">
                            <div class="p-2 text-center d-flex align-items-center justify-content-center" style="height: 90px;">
                                <img src="{{ $frameUrl }}" class="img-fluid" style="max-height: 80px; object-fit: contain;">
                            </div>
                            <div class="card-footer bg-white border-top-0 p-2 text-center">
                                <small class="fw-bold text-dark d-block text-truncate" title="{{ $frame->frame_name }}">
                                    {{ $frame->frame_name }}
                                </small>
                            </div>
                        </div>
                        @empty
                        <div class="w-100 p-4 text-center border border-dashed rounded-3 bg-light">
                            <i class="bi bi-file-earmark-image fs-3 text-muted d-block mb-1"></i>
                            <span class="text-muted small">Belum ada overlay frame untuk organisasi ini.</span>
                        </div>
                        @endforelse
                    </div>

                    <!-- Form Add New Frame -->
                    <div class="p-3 bg-light rounded-3 border">
                        <label class="form-label fw-bold text-muted small mb-2">Upload Frame Baru (PNG Transparan)</label>
                        <form action="{{ route('photobooth.setup.frame.store', $pb->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-2 align-items-center">
                                <div class="col-md-5">
                                    <input type="text" name="frame_name" class="form-control form-control-sm" placeholder="Nama/Judul Frame" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="file" name="frame_image" class="form-control form-control-sm" accept="image/png" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-sm btn-primary w-100 fw-semibold">
                                        <i class="bi bi-plus-circle me-1"></i> Add
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="card p-5 text-center border-0 shadow-sm rounded-4 bg-white">
        <div class="my-3">
            <i class="bi bi-camera-video-off fs-1 text-muted"></i>
            <h5 class="fw-bold text-dark mt-2">Belum Ada Data Photobooth</h5>
            <p class="text-muted small mb-0">Silakan tambahkan organisasi baru di atas untuk mulai membuat studio photobooth.</p>
        </div>
    </div>
    @endforelse

</div>
@endsection
