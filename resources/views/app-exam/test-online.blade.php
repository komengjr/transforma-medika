<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Asesmen & Ujian Online BUMN</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .navbar-bumn {
            background: linear-gradient(135deg, #003366 0%, #002244 100%);
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-shadow {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            border: none;
            border-radius: 0.75rem;
        }

        .nav-box {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.2s ease;
            border: 2px solid #e2e8f0;
            background-color: #ffffff;
            color: #4a5568;
        }

        .nav-box:hover {
            transform: translateY(-2px);
            border-color: #cbd5e0;
        }

        .nav-box.answered {
            background-color: #d1fae5;
            border-color: #10b981;
            color: #065f46;
        }

        .nav-box.doubtful {
            background-color: #fef3c7;
            border-color: #f59e0b;
            color: #92400e;
        }

        .nav-box.active {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
            color: #ffffff;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.2);
        }

        .option-label {
            cursor: pointer;
            border: 2px solid #e2e8f0;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }

        .option-label:hover {
            background-color: #f8fafc;
            border-color: #cbd5e0;
        }

        .option-input:checked+.option-label {
            background-color: #eff6ff;
            border-color: #3b82f6;
            color: #1e40af;
        }

        .timer-badge {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-bumn py-3 px-4">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white text-primary px-3 py-1 rounded fw-bold shadow-sm">
                    <i class="fa-solid fa-building-shield me-1"></i> BUMN REKRUTMEN
                </div>
                <div>
                    <h5 class="mb-0 fw-bold fs-6 fs-md-5">Tes Kemampuan Dasar (TKD) - Paket A</h5>
                    <small class="text-white-50">Kandidat: Peserta Ujian (ID: BUMN-2026-9812)</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="timer-badge px-3 py-2 rounded-pill d-flex align-items-center gap-2 text-white fw-bold">
                    <i class="fa-regular fa-clock text-warning"></i>
                    <span id="countdown" class="font-monospace fs-5">01:00:00</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid my-4 px-3 px-md-5 flex-grow-1">
        <div class="row g-4">
            <!-- Kolom Soal Utama -->
            <div class="col-lg-8">
                <div class="card card-shadow p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <!-- Header Soal & Status Ragu -->
                        <div class="d-flex justify-content-between align-items-center pb-3 mb-3 border-bottom">
                            <span class="badge bg-primary px-3 py-2 fs-6" id="question-number-badge">Soal No. 1</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="doubtCheck" onchange="toggleDoubt()">
                                <label class="form-check-label fw-semibold text-warning" for="doubtCheck">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Ragu-ragu
                                </label>
                            </div>
                        </div>

                        <!-- Pertanyaan -->
                        <div class="mb-4">
                            <h5 class="text-dark fw-bold mb-3 lh-base" id="question-text">Memuat pertanyaan...</h5>
                            <div id="options-container" class="d-flex flex-column gap-3">
                                <!-- Opsi jawaban dirender dinamis via JavaScript -->
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Navigasi Bawah -->
                    <div class="d-flex justify-content-between pt-3 border-top mt-4">
                        <button class="btn btn-outline-secondary px-4 fw-semibold" id="prevBtn" onclick="prevQuestion()">
                            <i class="fa-solid fa-arrow-left me-2"></i> Sebelumnya
                        </button>
                        <div class="d-flex gap-2">
                            <button class="btn btn-warning text-dark px-4 fw-semibold" onclick="clearAnswer()">
                                <i class="fa-solid fa-eraser me-1"></i> Kosongkan Pilihan
                            </button>
                            <button class="btn btn-primary px-4 fw-semibold" id="nextBtn" onclick="nextQuestion()">
                                Selanjutnya <i class="fa-solid fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Panel Navigasi Nomor Soal -->
            <div class="col-lg-4">
                <div class="card card-shadow p-4 h-100">
                    <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-list-check me-2 text-primary"></i>Navigasi Nomor Soal</h6>

                    <!-- Keterangan Status -->
                    <div class="row g-2 mb-3 text-muted small">
                        <div class="col-6 d-flex align-items-center gap-2">
                            <div style="width: 16px; height: 16px; background: #10b981; border-radius: 4px;"></div> Sudah Dijawab
                        </div>
                        <div class="col-6 d-flex align-items-center gap-2">
                            <div style="width: 16px; height: 16px; background: #ffffff; border: 2px solid #e2e8f0; border-radius: 4px;"></div> Belum
                        </div>
                        <div class="col-6 d-flex align-items-center gap-2 mt-1">
                            <div style="width: 16px; height: 16px; background: #f59e0b; border-radius: 4px;"></div> Ragu-ragu
                        </div>
                        <div class="col-6 d-flex align-items-center gap-2 mt-1">
                            <div style="width: 16px; height: 16px; background: #1e3a8a; border-radius: 4px;"></div> Positif Aktif
                        </div>
                    </div>
                    <hr class="text-muted">

                    <!-- Kotak Nomor Soal Grid -->
                    <div id="nav-grid" class="d-flex flex-wrap gap-2 overflow-auto align-content-start" style="max-height: 320px;">
                        <!-- Nomor soal dirender otomatis -->
                    </div>

                    <!-- Tombol Selesaikan Ujian -->
                    <div class="mt-auto pt-4 border-top">
                        <button class="btn btn-danger w-100 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmModal">
                            <i class="fa-solid fa-paper-plane me-2"></i> Selesai & Kirim Ujian
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Selesai -->
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-triangle-exclamation me-2 text-warning"></i>Konfirmasi Selesai Ujian</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <p class="fs-5 mb-3">Apakah Anda yakin ingin mengakhiri sesi ujian ini?</p>
                    <div class="bg-light p-3 rounded text-start mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Total Soal:</span> <span class="fw-bold">10 Soal</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1 text-success">
                            <span>Sudah Dijawab:</span> <span class="fw-bold" id="summary-answered">0</span>
                        </div>
                        <div class="d-flex justify-content-between text-warning">
                            <span>Ragu-ragu:</span> <span class="fw-bold" id="summary-doubt">0</span>
                        </div>
                    </div>
                    <p class="text-muted small mb-0">Pastikan seluruh jawaban Anda sudah diperiksa kembali sebelum dikirim.</p>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Kembali Ujian</button>
                    <button type="button" class="btn btn-success px-4 fw-bold" onclick="submitExam()">Ya, Kirim Jawaban</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Peringatan Pelanggaran Anti-Kecurangan -->
    <div class="modal fade" id="warningModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-shield-halved me-2"></i>Peringatan Sistem Keamanan BUMN</h5>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="text-danger mb-3" style="font-size: 3rem;">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h4 class="fw-bold text-danger mb-2">Aktivitas Mencurigakan Terdeteksi!</h4>
                    <p class="text-muted" id="warning-message">Anda terdeteksi meninggalkan halaman ujian atau mencoba membuka aplikasi lain. Tindakan ini dicatat oleh sistem pengawas online BUMN.</p>
                    <div class="alert alert-warning py-2 mb-0 fw-bold">
                        Sisa Peringatan: <span id="violation-count">3</span> kali sebelum diskualifikasi otomatis.
                    </div>
                </div>
                <div class="modal-footer justify-content-center bg-light">
                    <button type="button" class="btn btn-danger px-5 fw-bold" onclick="dismissWarning()">Saya Mengerti & Kembali Ujian</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Data Bank Soal Simulasi Tes BUMN
        const questions = [{
                id: 1,
                question: "BUMN yang bergerak di bidang logistik dan pos nasional Indonesia adalah...",
                options: ["PT Pos Indonesia (Persero)", "PT Kereta Api Indonesia", "PT Jasa Marga", "PT Perusahaan Listrik Negara", "PT Telkom Indonesia"],
                answer: null,
                doubt: false
            },
            {
                id: 2,
                question: "Nilai utama (Core Values) SDM BUMN yang menjunjung tinggi komitmen dan dedikasi terhadap bangsa dan negara adalah...",
                options: ["Amanah", "Kompeten", "Harmonis", "Loyal", "Kolaboratif"],
                answer: null,
                doubt: false
            },
            {
                id: 3,
                question: "Sinonim dari kata 'KOLABORASI' adalah...",
                options: ["Kompetisi", "Kerjasama", "Isolasi", "Dominasi", "Konfrontasi"],
                answer: null,
                doubt: false
            },
            {
                id: 4,
                question: "Jika sebuah perusahaan BUMN memperoleh laba bersih Rp 120 Miliar dan 30% dibagikan sebagai dividen negara, berapa besaran dividen tersebut?",
                options: ["Rp 30 Miliar", "Rp 36 Miliar", "Rp 40 Miliar", "Rp 45 Miliar", "Rp 50 Miliar"],
                answer: null,
                doubt: false
            },
            {
                id: 5,
                question: "Pernyataan berikut yang paling tepat mengenai fungsi utama BUMN di Indonesia adalah...",
                options: [
                    "Hanya mencari keuntungan sebesar-besarnya untuk pemegang saham mayoritas",
                    "Memberikan layanan publik sekaligus mengejar keuntungan bagi perekonomian nasional",
                    "Mengambil alih seluruh pangsa pasar perusahaan swasta nasional",
                    "Sebagai instrumen monopoli harga komoditas utama",
                    "Fokus sepenuhnya pada kegiatan amal dan sosial tanpa orientasi bisnis"
                ],
                answer: null,
                doubt: false
            },
            {
                id: 6,
                question: "Berapakah hasil dari operasi hitung berikut: 15% dari 450 + 25?",
                options: ["87.5", "92.5", "97.5", "102.5", "105.0"],
                answer: null,
                doubt: false
            },
            {
                id: 7,
                question: "Manakah dari perusahaan berikut yang merupakan bagian dari Holding BUMN Danareksa?",
                options: ["PT Bank Rakyat Indonesia", "PT Perusahaan Gas Negara", "PT Nindya Karya", "PT Telkomsel", "PT Garuda Indonesia"],
                answer: null,
                doubt: false
            },
            {
                id: 8,
                question: "Kebijakan strategis pemerintah dalam hilirisasi produk tambang nikel bertujuan utama untuk...",
                options: [
                    "Meningkatkan ekspor bahan mentah secara besar-besaran",
                    "Menambah nilai tambah ekonomi domestik dan membuka lapangan kerja industri baterai",
                    "Mengurangi ketergantungan pada sektor pertanian lokal",
                    "Menurunkan cadangan devisa negara secara bertahap",
                    "Membatasi investasi asing secara mutlak"
                ],
                answer: null,
                doubt: false
            },
            {
                id: 9,
                question: "Lawan kata (Antonim) dari kata 'AUTENTIK' adalah...",
                options: ["Asli", "Sahih", "Palsu", "Murni", "Resmi"],
                answer: null,
                doubt: false
            },
            {
                id: 10,
                question: "Prinsip tata kelola perusahaan yang baik (Good Corporate Governance / GCG) dalam BUMN meliputi aspek berikut, KECUALI...",
                options: ["Transparency", "Accountability", "Responsibility", "Independence", "Monopoly"],
                answer: null,
                doubt: false
            }
        ];

        let currentIdx = 0;
        let violations = 3;
        let examStarted = false;

        // Inisialisasi Ujian saat Halaman Dimuat - Tampilkan SweetAlert Instruksi
        window.onload = function() {
            showWelcomeAlert();
            initSecurityFeatures();
        }

        // Tampilkan Popup Instruksi SweetAlert2 di Awal
        function showWelcomeAlert() {
            Swal.fire({
                title: '<span style="color: #003366;"><i class="fa-solid fa-building-shield me-2"></i>SELAMAT DATANG DI ASESMEN BUMN</span>',
                html: `
                    <div class="text-start p-2" style="font-size: 0.95rem;">
                        <p class="mb-3">Halo Peserta Rekrutmen BUMN, silakan perhatikan ketentuan tes berikut sebelum memulai:</p>
                        <ul class="list-unstyled d-flex flex-column gap-2 mb-3 text-secondary">
                            <li><i class="fa-solid fa-circle-check text-success me-2"></i><strong>Jumlah Soal:</strong> 10 Butir Soal Pilihan Ganda.</li>
                            <li><i class="fa-solid fa-circle-check text-success me-2"></i><strong>Waktu Pengerjaan:</strong> 60 Menit (Hitung mundur otomatis).</li>
                            <li><i class="fa-solid fa-circle-check text-success me-2"></i><strong>Aturan Layar:</strong> Halaman akan otomatis masuk ke mode <strong>Full Screen (Layar Penuh)</strong>.</li>
                            <li><i class="fa-solid fa-triangle-exclamation text-danger me-2"></i><strong>Sistem Pengawasan:</strong> Dilarang keluar tab, meminimalisir jendela, atau menggunakan F12. Pelanggaran tercatat otomatis.</li>
                        </ul>
                        <div class="alert alert-warning py-2 mb-0 small fw-semibold text-center">
                            Pastikan koneksi internet stabil dan siap untuk memulai tes.
                        </div>
                    </div>
                `,
                confirmButtonText: '<i class="fa-solid fa-play me-2"></i>Mulai Ujian Sekarang',
                confirmButtonColor: '#003366',
                allowOutsideClick: false,
                allowEscapeKey: false,
                customClass: {
                    popup: 'rounded-4 shadow-lg border-0'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    requestFullScreen();
                    startExamSession();
                }
            });
        }

        // Fungsi Request Full Screen Otomatis
        function requestFullScreen() {
            const elem = document.documentElement;
            if (elem.requestFullscreen) {
                elem.requestFullscreen().catch(err => {
                    console.log("Full screen prevented or error:", err);
                });
            } else if (elem.webkitRequestFullscreen) {
                /* Safari */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) {
                /* IE11 */
                elem.msRequestFullscreen();
            }
        }

        // Mulai Sesi Ujian
        function startExamSession() {
            examStarted = true;
            renderNavGrid();
            loadQuestion(0);
            startCountdown(3600); // 1 Jam Countdown
        }

        // Render Navigasi Grid Soal
        function renderNavGrid() {
            const grid = document.getElementById('nav-grid');
            grid.innerHTML = '';
            questions.forEach((q, index) => {
                const box = document.createElement('div');
                box.className = `nav-box ${index === currentIdx ? 'active' : ''}`;
                if (q.doubt) {
                    box.classList.add('doubtful');
                } else if (q.answer !== null) {
                    box.classList.add('answered');
                }
                box.innerText = index + 1;
                box.onclick = () => {
                    currentIdx = index;
                    loadQuestion(currentIdx);
                };
                grid.appendChild(box);
            });
        }

        // Muat Pertanyaan Berdasarkan Indeks
        function loadQuestion(idx) {
            currentIdx = idx;
            const q = questions[idx];

            document.getElementById('question-number-badge').innerText = `Soal No. ${idx + 1} dari ${questions.length}`;
            document.getElementById('question-text').innerText = q.question;
            document.getElementById('doubtCheck').checked = q.doubt;

            const optionsContainer = document.getElementById('options-container');
            optionsContainer.innerHTML = '';

            q.options.forEach((opt, oIdx) => {
                const isChecked = q.answer === oIdx ? 'checked' : '';
                const optionId = `opt_${oIdx}`;

                const html = `
                    <div class="form-check p-0 m-0">
                        <input class="form-check-input option-input d-none" type="radio" name="examOption" id="${optionId}" value="${oIdx}" ${isChecked} onchange="selectAnswer(${oIdx})">
                        <label class="option-label p-3 d-flex align-items-center w-100 ${q.answer === oIdx ? 'bg-primary-subtle border-primary text-primary fw-semibold' : ''}" for="${optionId}">
                            <span class="badge bg-secondary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">${String.fromCharCode(65 + oIdx)}</span>
                            <span class="fs-6">${opt}</span>
                        </label>
                    </div>
                `;
                optionsContainer.insertAdjacentHTML('beforeend', html);
            });

            // Status Tombol Navigasi Sebelumnya / Selanjutnya
            document.getElementById('prevBtn').disabled = idx === 0;
            document.getElementById('nextBtn').innerHTML = idx === questions.length - 1 ? 'Selesai / Cek <i class="fa-solid fa-check ms-2"></i>' : 'Selanjutnya <i class="fa-solid fa-arrow-right ms-2"></i>';

            renderNavGrid();
            updateSummaryModal();
        }

        // Pilih Jawaban
        function selectAnswer(optIdx) {
            questions[currentIdx].answer = optIdx;
            // Jika sebelumnya dijawab ragu, saat diganti opsi jawaban bisa dihilangkan status ragunya atau dipertahankan
            renderNavGrid();
            updateSummaryModal();
            loadQuestion(currentIdx); // Refresh UI opsi aktif
        }

        // Kosongkan Pilihan
        function clearAnswer() {
            questions[currentIdx].answer = null;
            questions[currentIdx].doubt = false;
            renderNavGrid();
            updateSummaryModal();
            loadQuestion(currentIdx);
        }

        // Toggle Status Ragu-ragu
        function toggleDoubt() {
            const isChecked = document.getElementById('doubtCheck').checked;
            questions[currentIdx].doubt = isChecked;
            renderNavGrid();
        }

        // Navigasi Sebelumnya
        function prevQuestion() {
            if (currentIdx > 0) {
                currentIdx--;
                loadQuestion(currentIdx);
            }
        }

        // Navigasi Selanjutnya
        function nextQuestion() {
            if (currentIdx < questions.length - 1) {
                currentIdx++;
                loadQuestion(currentIdx);
            } else {
                // Jika soal terakhir, buka modal konfirmasi
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                confirmModal.show();
            }
        }

        // Update Ringkasan Jawaban pada Modal
        function updateSummaryModal() {
            const answeredCount = questions.filter(q => q.answer !== null).length;
            const doubtCount = questions.filter(q => q.doubt).length;
            document.getElementById('summary-answered').innerText = answeredCount;
            document.getElementById('summary-doubt').innerText = doubtCount;
        }

        // Timer Hitung Mundur (Countdown)
        function startCountdown(duration) {
            let timer = duration,
                hours, minutes, seconds;
            const display = document.getElementById('countdown');

            const interval = setInterval(function() {
                hours = parseInt(timer / 3600, 10);
                minutes = parseInt((timer % 3600) / 60, 10);
                seconds = parseInt(timer % 60, 10);

                hours = hours < 10 ? "0" + hours : hours;
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = hours + ":" + minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(interval);
                    alert("Waktu Ujian Telah Habis! Sistem akan mengirimkan jawaban Anda secara otomatis.");
                    submitExam();
                }
            }, 1000);
        }

        // Kirim Ujian (Submit)
        function submitExam() {
            Swal.fire({
                title: 'Ujian Berhasil Dikirim!',
                text: 'Terima kasih telah mengikuti Tes Kompetensi Dasar (TKD) BUMN.',
                icon: 'success',
                confirmButtonText: 'Keluar',
                confirmButtonColor: '#003366',
                allowOutsideClick: false
            }).then(() => {
                window.location.reload();
            });
        }

        // Fitur Keamanan Anti-Kecurangan (Anti F12, Inspect, Tab Switching)
        function initSecurityFeatures() {
            // 1. Blokir Klik Kanan
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                if (examStarted) triggerSecurityWarning("Klik kanan dinonaktifkan demi integritas keamanan asesmen BUMN.");
            });

            // 2. Blokir Tombol Pintasan Keyboard (F12, Ctrl+Shift+I, Ctrl+U, dll)
            document.addEventListener('keydown', function(e) {
                if (
                    e.key === 'F12' ||
                    (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) ||
                    (e.ctrlKey && e.key === 'U') ||
                    (e.ctrlKey && e.key === 'S') ||
                    (e.ctrlKey && e.key === 'P')
                ) {
                    e.preventDefault();
                    if (examStarted) triggerSecurityWarning(`Pintasan tombol [${e.key}] atau Inspect Element dilarang selama tes berlangsung!`);
                }
            });

            // 3. Deteksi Perpindahan Tab / Jendela Browser (Blur Detection)
            window.addEventListener('blur', function() {
                if (examStarted) {
                    triggerSecurityWarning("Anda terdeteksi keluar dari halaman ujian (Pindah Tab / Minimized Window).");
                }
            });

            // 4. Deteksi Keluar Fullscreen manual
            document.addEventListener('fullscreenchange', function() {
                if (!document.fullscreenElement && examStarted) {
                    Swal.fire({
                        title: 'Peringatan Mode Layar Penuh!',
                        text: 'Anda keluar dari mode layar penuh. Harap kembali ke mode layar penuh.',
                        icon: 'warning',
                        confirmButtonText: 'Masuk Layar Penuh Lagi',
                        confirmButtonColor: '#f59e0b',
                        allowOutsideClick: false
                    }).then(() => {
                        requestFullScreen();
                    });
                }
            });
        }

        // Tampilkan Modal Peringatan Keamanan
        function triggerSecurityWarning(msg) {
            if (violations > 0) {
                violations--;
                Swal.fire({
                    title: 'Peringatan Keamanan BUMN',
                    html: `<p class="text-danger fw-semibold">${msg}</p><div class="alert alert-warning py-2 mb-0">Sisa Peringatan: <strong>${violations}</strong> kali sebelum diskualifikasi otomatis.</div>`,
                    icon: 'error',
                    confirmButtonText: 'Saya Mengerti',
                    confirmButtonColor: '#dc3545',
                    allowOutsideClick: false
                }).then(() => {
                    requestFullScreen();
                });
            } else {
                Swal.fire({
                    title: 'Diskualifikasi Ujian!',
                    text: 'Batas pelanggaran keamanan terlampaui! Sesi ujian Anda dinyatakan GUGUR.',
                    icon: 'error',
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#dc3545',
                    allowOutsideClick: false
                }).then(() => {
                    window.location.reload();
                });
            }
        }

        function dismissWarning() {
            // Ditangani SweetAlert
        }
    </script>
</body>

</html>
