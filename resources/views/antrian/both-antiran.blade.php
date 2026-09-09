<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ambil Tiket Antrian | Innoventra Queue</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet" />

    <!-- SweetAlert2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
            user-select: none;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        body {
            background: linear-gradient(135deg, #e0f2fe 0%, #f0fdf4 50%, #fef2f2 100%);
            color: #1e293b;
            display: flex;
            flex-direction: column;
            padding: 15px 20px;
        }

        /* HEADER SECTION */
        .brand-header {
            text-align: center;
            margin-bottom: 10px;
            flex-shrink: 0;
        }

        .brand-badge {
            background: #ffffff;
            color: #0284c7;
            border: 2px solid #bae6fd;
            padding: 5px 16px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 5px;
            box-shadow: 0 4px 15px rgba(2, 132, 199, 0.12);
        }

        h2.main-title {
            font-weight: 800;
            font-size: 1.8rem;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .subtitle {
            color: #475569;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        /* LOKET WRAPPER & BALANCED FLEX 2 BARIS */
        .loket-wrapper {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            min-height: 0;
            padding: 5px 0;
        }

        .loket-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-content: center;
            gap: 15px;
            width: 100%;
            max-width: 1400px;
            height: 100%;
            max-height: 100%;
        }

        .loket-card-wrapper {
            flex: 0 0 calc((100% / var(--cols-per-row)) - 15px);
            height: calc(50% - 10px);
            max-height: 280px;
        }

        /* CARD LOKET */
        .loket-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 12px 10px;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.04);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            border: 3px solid #7dd3fc;

            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            height: 100%;
            width: 100%;
        }

        .loket-card:hover {
            transform: translateY(-4px) scale(1.015);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .loket-card:active {
            transform: translateY(-1px) scale(0.98);
        }

        /* VARIASI WARNA CARD */
        .card-loket-1 {
            border-color: #7dd3fc;
        }

        .card-loket-1 .icon-box {
            background: #e0f2fe;
            color: #0284c7;
        }

        .card-loket-1 .btn-antrian {
            background: linear-gradient(135deg, #38bdf8, #0284c7);
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
        }

        .card-loket-2 {
            border-color: #86efac;
        }

        .card-loket-2 .icon-box {
            background: #dcfce7;
            color: #16a34a;
        }

        .card-loket-2 .btn-antrian {
            background: linear-gradient(135deg, #4ade80, #16a34a);
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);
        }

        .card-loket-3 {
            border-color: #fde047;
        }

        .card-loket-3 .icon-box {
            background: #fef9c3;
            color: #ca8a04;
        }

        .card-loket-3 .btn-antrian {
            background: linear-gradient(135deg, #facc15, #eab308);
            box-shadow: 0 4px 12px rgba(234, 179, 8, 0.25);
            color: #422006 !important;
        }

        .card-loket-4 {
            border-color: #f472b6;
        }

        .card-loket-4 .icon-box {
            background: #fce7f3;
            color: #db2777;
        }

        .card-loket-4 .btn-antrian {
            background: linear-gradient(135deg, #f472b6, #db2777);
            box-shadow: 0 4px 12px rgba(219, 39, 119, 0.25);
        }

        .card-loket-5 {
            border-color: #a78bfa;
        }

        .card-loket-5 .icon-box {
            background: #f3e8ff;
            color: #9333ea;
        }

        .card-loket-5 .btn-antrian {
            background: linear-gradient(135deg, #c084fc, #9333ea);
            box-shadow: 0 4px 12px rgba(147, 51, 234, 0.25);
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            transition: all 0.3s ease;
            margin-bottom: 4px;
            flex-shrink: 0;
        }

        .loket-card:hover .icon-box {
            transform: rotate(-6deg) scale(1.05);
        }

        .loket-info {
            width: 100%;
            margin-bottom: 4px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .loket-title {
            font-size: 1.1rem;
            color: #0f172a;
            margin-bottom: 2px;
            font-weight: 800;
            line-height: 1.2;
        }

        .loket-desc {
            font-size: 0.78rem;
            color: #64748b;
            font-weight: 600;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .btn-antrian {
            color: #ffffff;
            border: none;
            font-weight: 800;
            font-size: 0.85rem;
            border-radius: 10px;
            padding: 8px 0;
            width: 100%;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            flex-shrink: 0;
        }

        /* CUSTOM STYLING UNTUK SWAL TIKET */
        .swal-ticket-box {
            background: #f8fafc;
            border: 2px dashed #0284c7;
            border-radius: 16px;
            padding: 15px;
            margin-top: 10px;
        }

        .swal-ticket-number {
            font-size: 3.5rem;
            font-weight: 800;
            color: #0284c7;
            line-height: 1;
            margin: 10px 0;
        }
    </style>
</head>

<body>

    <div class="brand-header">
        <div class="brand-badge"><i class="fa-solid fa-hospital me-2"></i> Innoventra Health Queue</div>
        <h2 class="main-title">Selamat Datang, Silakan Ambil Antrian</h2>
        <p class="subtitle">Sentuh tombol di bawah sesuai dengan tujuan pelayanan Anda</p>
    </div>

    @php
    $totalLoket = count($lokets);
    $colsPerRow = $totalLoket > 0 ? ceil($totalLoket / 2) : 1;
    @endphp

    <div class="loket-wrapper">
        <div class="loket-container" style="--cols-per-row: {{ $colsPerRow }};">
            @forelse($lokets as $index => $loket)
            <div class="loket-card-wrapper">
                <div class="loket-card {{ $loket->warna_tema ?? 'card-loket-1' }}" onclick="konfirmasiAntrian({{ $loket->id }}, '{{ $loket->nama_loket }}')">
                    <div class="icon-box">
                        <i class="{{ $loket->icon ?? 'fa-solid fa-headset' }}"></i>
                    </div>

                    <div class="loket-info">
                        <div class="loket-title">{{ $loket->nama_loket }}</div>
                        <div class="loket-desc">{{ $loket->deskripsi ?? 'Pelayanan Antrian Pasien' }}</div>
                    </div>

                    <button class="btn-antrian"><i class="fa-solid fa-hand-pointer me-2"></i>Ambil Antrian</button>
                </div>
            </div>
            @empty
            <div class="text-center text-muted w-100 py-5">
                <h4>Belum ada loket pelayanan yang aktif saat ini.</h4>
            </div>
            @endforelse
        </div>
    </div>

    <script>
        const clickSound = new Audio("https://assets.mixkit.co/active_storage/sfx/2571/2571-preview.mp3");

        function konfirmasiAntrian(loketId, namaLoket) {
            clickSound.play().catch(() => {});

            // 1. Tampilkan SWAL Konfirmasi
            Swal.fire({
                title: 'Konfirmasi Antrian',
                text: `Apakah Anda yakin ingin mengambil antrian di ${namaLoket}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0284c7',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: '<i class="fa-solid fa-check me-1"></i> Ya, Ambil!',
                cancelButtonText: '<i class="fa-solid fa-xmark me-1"></i> Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-4'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    prosesAmbilAntrian(loketId, namaLoket);
                }
            });
        }

        async function prosesAmbilAntrian(loketId, namaLoket) {
            // 2. Tampilkan SWAL Loading saat Server Memproses Data + Mencetak dari Backend
            Swal.fire({
                title: 'Memproses Antrian...',
                html: 'Sistem sedang membuat nomor antrian dan mencetak struk Anda.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Mengirim Request ke Backend (Backend yang mencetak langsung ke Printer ESC/POS)
                const response = await fetch("{{ route('antrian.cetak') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        loket_id: loketId
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // Confetti animasi
                    if (typeof confetti === "function") {
                        confetti({
                            particleCount: 80,
                            spread: 70,
                            origin: {
                                y: 0.6
                            }
                        });
                    }

                    // 3. Tampilkan Swal Sukses + Nomor Antrian (Backend Sudah Cetak Otomatis)
                    Swal.fire({
                        icon: 'success',
                        title: 'Antrian Berhasil Diambil!',
                        html: `
                            <div class="swal-ticket-box">
                                <span class="badge bg-primary text-uppercase px-3 py-2 mb-2">${namaLoket}</span>
                                <div class="text-muted small">Nomor Antrian Anda:</div>
                                <div class="swal-ticket-number">${data.nomor_antrian}</div>
                                <div class="text-secondary small"><i class="fa-regular fa-clock me-1"></i> ${data.waktu}</div>
                            </div>
                            <p class="text-success fw-bold mt-3 mb-0"><i class="fa-solid fa-check-circle me-1"></i> Struk telah dicetak oleh mesin.</p>
                        `,
                        confirmButtonColor: '#0284c7',
                        confirmButtonText: 'Selesai',
                        timer: 4000, // Menutup otomatis dalam 4 detik
                        timerProgressBar: true,
                        customClass: {
                            popup: 'rounded-4'
                        }
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memproses Antrian',
                        text: data.message || 'Terjadi kesalahan pada sistem backend.',
                        confirmButtonColor: '#ef4444'
                    });
                }

            } catch (error) {
                console.error("Error:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Koneksi Terputus',
                    text: 'Tidak dapat terhubung ke server antrian.',
                    confirmButtonColor: '#ef4444'
                });
            }
        }
    </script>
</body>

</html>
