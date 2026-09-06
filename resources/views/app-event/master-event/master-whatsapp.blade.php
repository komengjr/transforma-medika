@extends('layouts.layouts')

@section('content')
<style>
    /* Styling Kustom Elemen UI Modern */
    .wa-card {
        border: none;
        border-radius: 16px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .wa-card:hover {
        transform: translateY(-2px);
    }

    .gradient-header-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        border-top-left-radius: 16px !important;
        border-top-right-radius: 16px !important;
    }

    .gradient-header-success {
        background: linear-gradient(135deg, #198754 0%, #0f5132 100%);
        border-top-left-radius: 16px !important;
        border-top-right-radius: 16px !important;
    }

    .btn-gradient-success {
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        border: none;
        color: #fff;
        transition: opacity 0.2s ease, transform 0.1s ease;
    }

    .btn-gradient-success:hover:not(:disabled) {
        opacity: 0.95;
        color: #fff;
        transform: scale(1.01);
    }

    .status-badge-custom {
        font-size: 0.85rem;
        padding: 6px 14px;
        border-radius: 30px;
    }

    .form-control:focus {
        border-color: #25D366;
        box-shadow: 0 0 0 0.25rem rgba(37, 211, 102, 0.25);
    }
</style>

<!-- Notifikasi Status Laravel -->
@if(session('status'))
<div class="alert alert-info alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert">
    <i class="bi bi-info-circle-fill me-2"></i>{{ session('status') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row g-3 pt-3">
    <!-- KARTU STATUS DEVICE & QR CODE -->
    <div class="col-lg-5 col-md-6">
        <div class="card wa-card shadow-lg h-100">
            <div class="card-header gradient-header-primary text-white d-flex justify-content-between align-items-center py-3 px-4">
                <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                    <i class="bi bi-phone"></i> Status Device
                </h5>
                <span class="badge bg-white text-primary fw-semibold px-3 py-2 rounded-pill shadow-sm">
                    User ID: {{ Auth::id() }}
                </span>
            </div>
            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center p-4">

                <!-- Status Badge -->
                <div id="status-container" class="mb-3">
                    <span class="text-muted small fw-bold me-2">Status Server:</span>
                    <span class="badge bg-secondary status-badge-custom shadow-sm" id="status-badge">Checking...</span>
                </div>

                <!-- Loading Spinner -->
                <div id="loading-spinner" class="spinner-border text-primary my-3" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>

                <p id="loading-text" class="text-muted small fw-semibold">Menghubungkan ke server WhatsApp...</p>

                <!-- QR Code Container -->
                <div id="qr-container" class="my-3 d-none">
                    <p class="text-dark small fw-bold mb-3">Scan QR Code ini menggunakan WhatsApp di HP Anda:</p>
                    <div class="p-3 bg-light rounded-4 border d-inline-block shadow-sm">
                        <img id="qr-image" src="" alt="QR Code" class="img-fluid rounded" style="max-width: 220px;">
                    </div>
                </div>

                <!-- Connected Alert -->
                <div id="connected-container" class="alert alert-success border-0 shadow-sm d-none w-100 mb-0 rounded-4 py-3">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-check-circle-fill fs-4 text-success"></i>
                        <div class="text-start">
                            <strong class="d-block text-success">Terkoneksi Sempurna!</strong>
                            <small class="text-muted">Device Anda siap mengirim pesan.</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- KARTU FORM KIRIM PESAN & ATTACHMENT -->
    <div class="col-lg-7 col-md-6">
        <div class="card wa-card shadow-lg h-100">
            <div class="card-header gradient-header-success text-white py-3 px-4">
                <h5 class="mb-0 fw-bold d-flex align-items-center gap-2">
                    <i class="bi bi-whatsapp"></i> Kirim Pesan WhatsApp
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('whatsapp.send') }}" method="POST" enctype="multipart/form-data" id="wa-form">
                    @csrf

                    <!-- Input Nomor Telepon -->
                    <div class="mb-3">
                        <label for="number" class="form-label fw-bold text-dark">Nomor WhatsApp Tujuan</label>
                        <div class="input-group shadow-sm rounded-3">
                            <span class="input-group-text bg-success text-white fw-bold border-0">+62 / 08</span>
                            <input type="text"
                                name="number"
                                id="number"
                                class="form-control wa-field py-2"
                                placeholder="Contoh: 081234567890"
                                required
                                disabled>
                        </div>
                    </div>

                    <!-- Input Isi Pesan -->
                    <div class="mb-3">
                        <label for="message" class="form-label fw-bold text-dark">Isi Pesan / Caption</label>
                        <textarea name="message"
                            id="message"
                            rows="4"
                            class="form-control wa-field shadow-sm py-2"
                            placeholder="Tulis pesan Anda di sini..."
                            disabled></textarea>
                    </div>

                    <!-- Input File Attachment -->
                    <div class="mb-4">
                        <label for="attachment" class="form-label fw-bold text-dark">Lampiran File (Opsional)</label>
                        <input type="file"
                            name="attachment"
                            id="attachment"
                            class="form-control wa-field shadow-sm"
                            disabled>
                        <small class="text-muted mt-1 d-block" style="font-size: 0.8rem;">
                            <i class="bi bi-paperclip me-1"></i>Format: Gambar (JPG, PNG), PDF, DOCX, XLSX. Maksimal 10 MB.
                        </small>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" id="btn-submit" class="btn btn-gradient-success w-100 py-3 fw-bold rounded-3 shadow-sm fs-6" disabled>
                        <i class="bi bi-send-fill me-2"></i> Kirim Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function checkWAStatus() {
        fetch("{{ route('whatsapp.status') }}")
            .then(res => res.json())
            .then(data => {
                const badge = document.getElementById('status-badge');
                const qrContainer = document.getElementById('qr-container');
                const connectedContainer = document.getElementById('connected-container');
                const qrImage = document.getElementById('qr-image');
                const loadingSpinner = document.getElementById('loading-spinner');
                const loadingText = document.getElementById('loading-text');

                const waFields = document.querySelectorAll('.wa-field');
                const btnSubmit = document.getElementById('btn-submit');

                badge.innerText = data.status;

                if (data.status === 'CONNECTED') {
                    // Sesi WhatsApp Aktif & Terkoneksi
                    badge.className = 'badge bg-success status-badge-custom shadow-sm';
                    loadingSpinner.classList.add('d-none');
                    loadingText.classList.add('d-none');
                    qrContainer.classList.add('d-none');
                    connectedContainer.classList.remove('d-none');

                    // Buka penguncian form
                    waFields.forEach(field => field.removeAttribute('disabled'));
                    btnSubmit.removeAttribute('disabled');

                } else if (data.qr) {
                    // Memerlukan scan QR Code
                    badge.innerText = 'DISCONNECTED';
                    badge.className = 'badge bg-warning text-dark status-badge-custom shadow-sm';
                    loadingSpinner.classList.add('d-none');
                    loadingText.classList.add('d-none');
                    qrImage.src = data.qr;
                    qrContainer.classList.remove('d-none');
                    connectedContainer.classList.add('d-none');

                    // Kunci form
                    waFields.forEach(field => field.setAttribute('disabled', 'disabled'));
                    btnSubmit.setAttribute('disabled', 'disabled');

                } else {
                    // Masih proses inisialisasi / booting Puppeteer
                    badge.innerText = data.status || 'INITIALIZING';
                    badge.className = 'badge bg-info text-dark status-badge-custom shadow-sm';
                    loadingSpinner.classList.remove('d-none');
                    loadingText.classList.remove('d-none');
                    loadingText.innerText = 'Menyiapkan browser Puppeteer & QR Code...';
                    qrContainer.classList.add('d-none');
                    connectedContainer.classList.add('d-none');

                    // Kunci form
                    waFields.forEach(field => field.setAttribute('disabled', 'disabled'));
                    btnSubmit.setAttribute('disabled', 'disabled');
                }
            })
            .catch(err => {
                const badge = document.getElementById('status-badge');
                const loadingSpinner = document.getElementById('loading-spinner');
                const loadingText = document.getElementById('loading-text');
                const waFields = document.querySelectorAll('.wa-field');
                const btnSubmit = document.getElementById('btn-submit');

                badge.innerText = 'OFFLINE';
                badge.className = 'badge bg-danger status-badge-custom shadow-sm';
                loadingSpinner.classList.add('d-none');
                loadingText.classList.remove('d-none');
                loadingText.innerText = 'Node.js Server Offline / Tidak Merespon';

                waFields.forEach(field => field.setAttribute('disabled', 'disabled'));
                btnSubmit.setAttribute('disabled', 'disabled');
            });
    }

    // Jalankan pemeriksaan saat halaman selesai dimuat
    checkWAStatus();

    // Polling status setiap 3 detik
    setInterval(checkWAStatus, 3000);
</script>
@endsection
