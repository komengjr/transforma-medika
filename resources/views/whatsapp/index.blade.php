<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koneksi & Kirim WhatsApp Interaktif</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light p-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <!-- Notifikasi Status dari Laravel -->
                @if(session('status'))
                <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="row">
                    <!-- KARTU STATUS DEVICE & QR CODE -->
                    <div class="col-md-5 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Status Device WA</h5>
                            </div>
                            <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                                <div id="status-container" class="mb-2">
                                    Status: <span class="badge bg-secondary" id="status-badge">Checking...</span>
                                </div>

                                <!-- Loading Spinner -->
                                <div id="loading-spinner" class="spinner-border text-primary my-3" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>

                                <!-- QR Code Container -->
                                <div id="qr-container" class="my-3 d-none">
                                    <p class="text-muted small">Scan QR Code ini menggunakan WhatsApp di HP Anda:</p>
                                    <img id="qr-image" src="" alt="QR Code" class="img-fluid border p-2 rounded shadow-sm" style="max-width: 220px;">
                                </div>

                                <!-- Connected Alert -->
                                <div id="connected-container" class="alert alert-success d-none w-100 mb-0">
                                    <strong>Terkoneksi!</strong> Device siap digunakan untuk mengirim pesan.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KARTU FORM KIRIM PESAN & BUTTONS -->
                    <div class="col-md-7 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Kirim Pesan WhatsApp</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('whatsapp.send') }}" method="POST" id="wa-form">
                                    @csrf

                                    <!-- Input Nomor Telepon -->
                                    <div class="mb-3">
                                        <label for="number" class="form-label fw-bold">Nomor WhatsApp Tujuan</label>
                                        <div class="input-group">
                                            <span class="input-group-text">+62 / 08</span>
                                            <input type="text"
                                                name="number"
                                                id="number"
                                                class="form-control wa-field"
                                                placeholder="Contoh: 081234567890"
                                                required
                                                disabled>
                                        </div>
                                    </div>

                                    <!-- Input Isi Pesan -->
                                    <div class="mb-3">
                                        <label for="message" class="form-label fw-bold">Isi Pesan</label>
                                        <textarea name="message"
                                            id="message"
                                            rows="3"
                                            class="form-control wa-field"
                                            placeholder="Tulis pesan Anda di sini..."
                                            required
                                            disabled></textarea>
                                    </div>

                                    <!-- Input Tombol Interaktif -->
                                    <div class="mb-3">
                                        <label class="form-label fw-bold d-block">
                                            Tombol Interaktif
                                            <span class="text-muted fw-normal" style="font-size: 0.85rem;">(Opsional, Maks 3 Tombol)</span>
                                        </label>

                                        <div class="mb-2">
                                            <input type="text"
                                                name="buttons[]"
                                                class="form-control wa-field"
                                                placeholder="Teks Tombol 1 (Misal: Ya / Setuju)"
                                                disabled>
                                        </div>
                                        <div class="mb-2">
                                            <input type="text"
                                                name="buttons[]"
                                                class="form-control wa-field"
                                                placeholder="Teks Tombol 2 (Misal: Tidak / Tolak)"
                                                disabled>
                                        </div>
                                        <div class="mb-2">
                                            <input type="text"
                                                name="buttons[]"
                                                class="form-control wa-field"
                                                placeholder="Teks Tombol 3 (Misal: Bantuan)"
                                                disabled>
                                        </div>
                                        <small class="text-muted fs-7">*Kosongkan bidang tombol jika hanya ingin mengirim pesan teks biasa.</small>
                                    </div>

                                    <!-- Tombol Submit -->
                                    <button type="submit" id="btn-submit" class="btn btn-success w-100 fw-bold" disabled>
                                        Kirim Pesan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- JavaScript Handling -->
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

                    // Ambil seluruh elemen input dengan class 'wa-field' dan tombol submit
                    const waFields = document.querySelectorAll('.wa-field');
                    const btnSubmit = document.getElementById('btn-submit');

                    loadingSpinner.classList.add('d-none');
                    badge.innerText = data.status;

                    if (data.status === 'CONNECTED') {
                        badge.className = 'badge bg-success';
                        qrContainer.classList.add('d-none');
                        connectedContainer.classList.remove('d-none');

                        // Aktifkan SELURUH field input dan tombol kirim
                        waFields.forEach(field => field.removeAttribute('disabled'));
                        btnSubmit.removeAttribute('disabled');

                    } else if (data.status === 'DISCONNECTED' && data.qr) {
                        badge.className = 'badge bg-warning text-dark';
                        qrImage.src = data.qr;
                        qrContainer.classList.remove('d-none');
                        connectedContainer.classList.add('d-none');

                        // Nonaktifkan SELURUH field input dan tombol kirim
                        waFields.forEach(field => field.setAttribute('disabled', 'disabled'));
                        btnSubmit.setAttribute('disabled', 'disabled');

                    } else {
                        badge.className = 'badge bg-danger';
                        qrContainer.classList.add('d-none');
                        connectedContainer.classList.add('d-none');

                        // Nonaktifkan SELURUH field input dan tombol kirim
                        waFields.forEach(field => field.setAttribute('disabled', 'disabled'));
                        btnSubmit.setAttribute('disabled', 'disabled');
                    }
                })
                .catch(err => {
                    const badge = document.getElementById('status-badge');
                    const loadingSpinner = document.getElementById('loading-spinner');
                    const waFields = document.querySelectorAll('.wa-field');
                    const btnSubmit = document.getElementById('btn-submit');

                    badge.innerText = 'OFFLINE';
                    badge.className = 'badge bg-danger';
                    loadingSpinner.classList.add('d-none');

                    // Nonaktifkan form saat server mati/offline
                    waFields.forEach(field => field.setAttribute('disabled', 'disabled'));
                    btnSubmit.setAttribute('disabled', 'disabled');
                });
        }

        // Panggil fungsi status saat halaman pertama dimuat
        checkWAStatus();

        // Lakukan polling periksa status setiap 3 detik
        setInterval(checkWAStatus, 3000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
