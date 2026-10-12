<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Tryout - {{ $kategori->nama_kategori }}</title>
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
                    <i class="fa-solid fa-building-shield me-1"></i> PREVIEW UJIAN
                </div>
                <div>
                    <h5 class="mb-0 fw-bold fs-6 fs-md-5">{{ $kategori->nama_kategori }}</h5>
                    <small class="text-white-50">Mode Preview Admin - Klasifikasi: {{ $kategori->klasifikasi->nama_klasifikasi ?? '-' }}</small>
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
        <div id="loadingState" class="text-center py-5">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
            <p class="text-muted mt-3 fw-semibold">Memuat soal tryout dari database...</p>
        </div>

        <div class="row g-4" id="examContainer" style="display: none;">
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
                            <div style="width: 16px; height: 16px; background: #10b981; border-radius: 4px;"></div> Dijawab
                        </div>
                        <div class="col-6 d-flex align-items-center gap-2">
                            <div style="width: 16px; height: 16px; background: #ffffff; border: 2px solid #e2e8f0; border-radius: 4px;"></div> Belum
                        </div>
                        <div class="col-6 d-flex align-items-center gap-2 mt-1">
                            <div style="width: 16px; height: 16px; background: #f59e0b; border-radius: 4px;"></div> Ragu-ragu
                        </div>
                        <div class="col-6 d-flex align-items-center gap-2 mt-1">
                            <div style="width: 16px; height: 16px; background: #1e3a8a; border-radius: 4px;"></div> Aktif
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
                    <p class="fs-5 mb-3">Apakah Anda ingin mengakhiri sesi preview tryout ini?</p>
                    <div class="bg-light p-3 rounded text-start mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Total Soal:</span> <span class="fw-bold" id="summary-total">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1 text-success">
                            <span>Sudah Dijawab:</span> <span class="fw-bold" id="summary-answered">0</span>
                        </div>
                        <div class="d-flex justify-content-between text-warning">
                            <span>Ragu-ragu:</span> <span class="fw-bold" id="summary-doubt">0</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Kembali Ujian</button>
                    <button type="button" class="btn btn-success px-4 fw-bold" onclick="submitExam()">Ya, Selesai</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let questions = [];
        let currentIdx = 0;
        let examStarted = false;

        // Ambil data soal dari endpoint JSON backend saat halaman dimuat
        document.addEventListener("DOMContentLoaded", function() {
            fetch(`/admin/brain-test/kategori/{{ $kategori->id }}/json-soal`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        Swal.fire({
                            title: 'Kosong!',
                            text: 'Belum ada soal pada kategori ini. Silakan tambahkan soal terlebih dahulu.',
                            icon: 'warning',
                            confirmButtonText: 'Kembali'
                        }).then(() => {

                        });
                        return;
                    }

                    // Format data dari database agar sesuai struktur preview[cite: 8]
                    questions = data.map(item => ({
                        id: item.id,
                        question: item.pertanyaan,
                        options: item.opsi_jawabans.map(opt => opt.teks_jawaban),
                        optionIds: item.opsi_jawabans.map(opt => opt.id),
                        answer: null,
                        doubt: false
                    }));

                    document.getElementById('loadingState').style.display = 'none';
                    document.getElementById('examContainer').style.display = 'flex';

                    showWelcomeAlert();
                    initSecurityFeatures();
                })
                .catch(error => {
                    console.error('Error fetching questions:', error);
                    document.getElementById('loadingState').innerHTML = `<p class="text-danger">Gagal memuat soal tryout dari server.</p>`;
                });
        });

        function showWelcomeAlert() {
            Swal.fire({
                title: '<span style="color: #003366;"><i class="fa-solid fa-building-shield me-2"></i>PREVIEW TRYOUT</span>',
                html: `
                    <div class="text-start p-2" style="font-size: 0.95rem;">
                        <p class="mb-3">Anda sedang memasuki mode simulasi tryout untuk kategori <strong>{{ $kategori->nama_kategori }}</strong>:</p>
                        <ul class="list-unstyled d-flex flex-column gap-2 mb-3 text-secondary">
                            <li><i class="fa-solid fa-circle-check text-success me-2"></i><strong>Jumlah Soal:</strong> ${questions.length} Butir Soal.</li>
                            <li><i class="fa-solid fa-circle-check text-success me-2"></i><strong>Waktu Pengerjaan:</strong> 60 Menit.</li>
                            <li><i class="fa-solid fa-circle-check text-success me-2"></i><strong>Fitur:</strong> Navigasi nomor, ragu-ragu, dan sistem layar penuh otomatis[cite: 8].</li>
                        </ul>
                    </div>
                `,
                confirmButtonText: '<i class="fa-solid fa-play me-2"></i>Mulai Preview',
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

        function requestFullScreen() {
            const elem = document.documentElement;
            if (elem.requestFullscreen) {
                elem.requestFullscreen().catch(() => {});
            }
        }

        function startExamSession() {
            examStarted = true;
            renderNavGrid();
            loadQuestion(0);
            startCountdown(3600);
        }

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

            document.getElementById('prevBtn').disabled = idx === 0;
            document.getElementById('nextBtn').innerHTML = idx === questions.length - 1 ? 'Selesai / Cek <i class="fa-solid fa-check ms-2"></i>' : 'Selanjutnya <i class="fa-solid fa-arrow-right ms-2"></i>';

            renderNavGrid();
            updateSummaryModal();
        }

        function selectAnswer(optIdx) {
            questions[currentIdx].answer = optIdx;
            renderNavGrid();
            updateSummaryModal();
            loadQuestion(currentIdx);
        }

        function clearAnswer() {
            questions[currentIdx].answer = null;
            questions[currentIdx].doubt = false;
            renderNavGrid();
            updateSummaryModal();
            loadQuestion(currentIdx);
        }

        function toggleDoubt() {
            questions[currentIdx].doubt = document.getElementById('doubtCheck').checked;
            renderNavGrid();
        }

        function prevQuestion() {
            if (currentIdx > 0) {
                currentIdx--;
                loadQuestion(currentIdx);
            }
        }

        function nextQuestion() {
            if (currentIdx < questions.length - 1) {
                currentIdx++;
                loadQuestion(currentIdx);
            } else {
                const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
                confirmModal.show();
            }
        }

        function updateSummaryModal() {
            document.getElementById('summary-total').innerText = questions.length;
            document.getElementById('summary-answered').innerText = questions.filter(q => q.answer !== null).length;
            document.getElementById('summary-doubt').innerText = questions.filter(q => q.doubt).length;
        }

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
                    submitExam();
                }
            }, 1000);
        }

        function submitExam() {
            Swal.fire({
                title: 'Preview Tryout Selesai!',
                text: 'Simulasi tryout kategori ini telah selesai diuji.',
                icon: 'success',
                confirmButtonText: 'Kembali ke Master Data',
                confirmButtonColor: '#003366',
                allowOutsideClick: false
            }).then(() => {

            });
        }

        function initSecurityFeatures() {
            document.addEventListener('contextmenu', e => e.preventDefault());
            document.addEventListener('keydown', e => {
                if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && ['I', 'J', 'C'].includes(e.key)) || (e.ctrlKey && e.key === 'U')) {
                    e.preventDefault();
                }
            });
        }
    </script>
</body>

</html>
