<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Event - Self Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2c7be5;
            --primary-hover: #1a68d1;
            --success-color: #00d27a;
            --success-hover: #00b368;
            --bg-page: #edf2f9;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--bg-page);
        }

        .full-page-container {
            min-height: 100vh;
            display: flex;
        }

        /* Sisi Kiri: Gambar/Banner Event */
        .image-side {
            background: linear-gradient(rgba(44, 123, 229, 0.25), rgba(15, 23, 42, 0.85)),
                url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            width: 50%;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 3.5rem;
            color: #ffffff;
        }

        .event-badge {
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        /* Sisi Kanan: Form Container */
        .form-side {
            width: 50%;
            background-color: var(--bg-page);
            display: flex;
            /* align-items: center; */
            justify-content: center;
            padding: 2.5rem;
            overflow-y: auto;
        }

        /* Desain Card Falcon diperlebar */
        .falcon-card {
            width: 100%;
            max-width: 680px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            border: 1px solid #d8e2ef;
        }

        /* Header Biru Khas Falcon */
        .falcon-header {
            background-color: var(--primary-blue);
            background-image: radial-gradient(circle at top right, rgba(255, 255, 255, 0.15), transparent);
            padding: 1rem;
            text-align: center;
            position: relative;
        }

        .falcon-brand {
            color: #ffffff;
            font-weight: 800;
            font-size: 2rem;
            letter-spacing: -0.5px;
            margin: 0;
        }

        .falcon-body {
            padding: 3.5rem 3rem;
        }

        /* Custom Input */
        .form-label-custom {
            font-weight: 500;
            color: #4d5969;
            font-size: 0.95rem;
            margin-bottom: 0.4rem;
        }

        .form-control-custom {
            border: 1px solid #d8e2ef;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            color: #2b354e;
            font-size: 1rem;
        }

        .form-control-custom:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(44, 123, 229, 0.15);
        }

        /* Loading Animation Area */
        .scan-loading-box {
            display: none;
            border: 1px solid #d8e2ef;
            border-radius: 8px;
            background-color: #f8fafc;
            padding: 2rem;
            text-align: center;
            margin-top: 1.5rem;
        }

        .loading-text {
            color: var(--primary-blue);
            font-weight: 600;
            animation: pulseText 1.2s infinite;
        }

        /* Hasil Scan Section */
        .result-box {
            display: none;
            background-color: #f8fafd;
            border: 1px dashed var(--primary-blue);
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        /* Tombol Cetak Registrasi */
        .btn-print-custom {
            background-color: var(--success-color);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.85rem 1.5rem;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .btn-print-custom:hover {
            background-color: var(--success-hover);
            color: white;
        }

        .btn-print-custom:disabled {
            background-color: #a0aec0;
            cursor: not-allowed;
        }

        /* Toast / Notifikasi Sukses Kecil */
        .print-toast {
            display: none;
            background-color: #10b981;
            color: white;
            padding: 1rem;
            border-radius: 6px;
            text-align: center;
            font-weight: 600;
            margin-top: 1rem;
            animation: pulseText 1s infinite;
        }

        @keyframes pulseText {
            0% {
                opacity: 0.6;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.6;
            }
        }

        /* Responsif */
        @media (max-width: 992px) {
            .full-page-container {
                flex-direction: column;
            }

            .image-side {
                width: 100%;
                min-height: 25vh;
                padding: 2rem;
            }

            .form-side {
                width: 100%;
                padding: 2rem 1rem;
            }
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>

    <div class="full-page-container">
        <div class="image-side">
            <div>
                <span class="event-badge text-uppercase">Tech Conference 2026</span>
                <h1 class="display-5 fw-bold mb-3">Falcon Summit 2026</h1>
                <p class="lead text-white-50 mb-0">Platform masa depan untuk ekosistem integrasi teknologi nirsentuh.</p>
            </div>
        </div>

        <div class="form-side">
            <div class="falcon-card">
                <div class="falcon-header">
                    <!-- <h2 class="falcon-brand">falcon</h2> -->
                </div>

                <div class="falcon-body">
                    <div class="mb-3">
                        <h3 class="fw-bold text-dark m-0" style="font-size: 1.75rem;">Self Register</h3>
                        <p class="text-muted small mb-0">Silakan pindai kartu identitas, kode tiket Anda, atau tekan Enter setelah mengetik.</p>
                    </div>

                    <div id="printToast" class="print-toast mb-3">
                        <i class="bi bi-check-circle-fill me-2"></i> Perintah Cetak Berhasil Dikirim! Form Mereset...
                    </div>

                    <form id="scanForm" onsubmit="event.preventDefault(); startScanProcess();">
                        <div class="mb-4">
                            <label class="form-label form-label-custom">ID Card Code / Ticket Code</label>
                            <div class="input-group">
                                <input type="text" id="idInput" class="form-control form-control-custom" placeholder="Scan Barcode atau ketik ID di sini..." required autocomplete="off">
                                <button class="btn btn-primary px-4" type="submit" style="background-color: var(--primary-blue); border-color: var(--primary-blue);"><i class="bi bi-qr-code-scan"></i> Scan</button>
                            </div>
                        </div>

                        <!-- <div class="mb-4">
                            <label class="form-label form-label-custom">Verification Token</label>
                            <input type="password" class="form-control form-control-custom" placeholder="••••••••" value="123456" disabled>
                        </div> -->
                    </form>

                    <div class="scan-loading-box" id="loadingContainer">
                        <div class="spinner-border text-primary mb-3" style="width: 2.5rem; height: 2.5rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="loading-text">Menghubungkan ke Scanner & Membaca Data...</div>
                    </div>

                    <div class="result-box" id="resultContainer">
                        <div class="d-flex align-items-center gap-2 mb-3 text-success">
                            <i class="bi bi-check-circle-fill" style="font-size: 1.2rem;"></i>
                            <strong style="font-size: 1rem;">Data Terbaca & Terverifikasi</strong>
                        </div>
                        <div class="bg-white p-4 rounded border border-light-subtle mb-4">
                            <div class="row g-3 text-dark style-result" style="font-size: 1rem;">
                                <div class="col-sm-4 text-muted">Nama Lengkap:</div>
                                <div class="col-sm-8 fw-semibold" id="resName">Raditya Pratama</div>
                                <div class="col-sm-4 text-muted">Status Kehadiran:</div>
                                <div class="col-sm-8 fw-semibold text-primary" id="resStatus">VIP Attendee</div>
                                <div class="col-sm-4 text-muted">Waktu Pindai:</div>
                                <div class="col-sm-8 text-muted" id="resTime">--:-- WIB</div>
                            </div>
                        </div>

                        <button class="btn btn-print-custom w-100 d-flex align-items-center justify-content-center gap-2 shadow-sm mb-2" id="btnPrint" onclick="processBackgroundPrint()">
                            <i class="bi bi-printer-fill"></i> <span id="printBtnText">Cetak Nomor Registrasi</span>
                        </button>
                        <button class="btn btn-link w-100 text-decoration-none text-muted small" id="btnReset" onclick="resetScan()">
                            <i class="bi bi-arrow-counterclockwise"></i> Scan Ulang
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        const idInput = document.getElementById('idInput');
        const btnPrint = document.getElementById('btnPrint');
        const printBtnText = document.getElementById('printBtnText');
        const printToast = document.getElementById('printToast');
        const resultBox = document.getElementById('resultContainer');
        const loadingBox = document.getElementById('loadingContainer');

        // Mendeteksi Enter di field scan
        idInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                startScanProcess();
            }
        });

        // 1. PROSES ANIMASI LOADING SAAT SCAN
        function startScanProcess() {
            if (!idInput.value) idInput.value = "FLC-2026-991A";

            resultBox.style.display = 'none';
            loadingBox.style.display = 'block';
            printToast.style.display = 'none';

            loadingBox.scrollIntoView({
                behavior: 'smooth'
            });

            setTimeout(() => {
                loadingBox.style.display = 'none';
                resultBox.style.display = 'block';

                const now = new Date();
                document.getElementById('resTime').innerText = now.toLocaleTimeString('id-ID') + ' WIB';

                resultBox.scrollIntoView({
                    behavior: 'smooth'
                });
            }, 1200);
        }

        // 2. PROSES CETAK LEWAT BACKEND / LATAR BELAKANG + AUTO RESET
        function processBackgroundPrint() {
            // Ubah tombol menjadi status loading proses cetak
            btnPrint.disabled = true;
            printBtnText.innerText = "Memproses Cetak Tiket...";
            btnPrint.innerHTML = `<div class="spinner-border spinner-border-sm text-light" role="status"></div> Menyambungkan ke Printer Latar Belakang...`;
            setTimeout(() => {
                // Tampilkan notifikasi sukses singkat
                printToast.style.display = 'block';
                printToast.scrollIntoView({
                    behavior: 'smooth'
                });
                $.ajax({
                    url: "{{ route('menu_event_data_form_registrasi_event_test_print') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "nama_produk": 'Agus Prasetyo Raharjo',
                        "nama_event": 'PDGI KALIMANTAN BAGIAN BARAT DAYA TENGAH MALAM JUMAT',
                        "sku": 'E102939101923',
                        "harga": '2000000',
                    },
                    dataType: 'html',
                }).done(function(data) {

                    // Jeda 1.5 detik ekstra agar user sempat melihat notifikasi sukses, lalu reset form otomatis ke awal
                    setTimeout(() => {
                        resetScan();
                        printToast.style.display = 'none';
                    }, 1500);

                }).fail(function() {
                    $('#menu-detail-seub-event').html('eror');
                });
            }, 2000);
            // Simulasi pengiriman data ke server / printer background (2 detik)

        }

        // 3. FUNGSI RESET FORM KEMBALI KE AWAL
        function resetScan() {
            idInput.value = "";
            resultBox.style.display = 'none';
            loadingBox.style.display = 'none';

            // Kembalikan kondisi bawaan tombol cetak
            btnPrint.disabled = false;
            btnPrint.innerHTML = `<i class="bi bi-printer-fill"></i> Cetak Nomor Registrasi`;

            // Otomatis arahkan kursor fokus kembali ke input scan
            idInput.focus();
        }
    </script>
</body>

</html>
