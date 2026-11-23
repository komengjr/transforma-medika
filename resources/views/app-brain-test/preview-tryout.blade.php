<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Tryout - {{ $paket->nama_test }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ent-indigo: #4f46e5;
            --ent-indigo-dark: #3730a3;
            --ent-grid-border: rgba(99, 102, 241, 0.25);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            color: #0f172a;
            user-select: none;
            -webkit-user-select: none;
        }

        .font-mono-code {
            font-family: 'JetBrains Mono', monospace;
        }

        .navbar-exam {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
            color: #ffffff;
            box-shadow: 0 8px 24px -6px rgba(15, 23, 42, 0.25);
            border-bottom: 1px solid rgba(129, 140, 248, 0.25);
        }

        .ent-card {
            background: #ffffff;
            border: 1px solid var(--ent-grid-border);
            border-radius: 16px;
            box-shadow: 0 8px 24px -8px rgba(15, 23, 42, 0.08);
        }

        .timer-pill {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(8px);
        }

        .kat-pill {
            border: 1px solid var(--ent-grid-border);
            border-radius: 9999px;
            padding: 5px 14px;
            font-size: 0.78rem;
            font-weight: 700;
            background: #ffffff;
            color: #334155;
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .kat-pill:hover {
            border-color: var(--ent-indigo);
            color: var(--ent-indigo);
        }

        .kat-pill.active {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            border-color: transparent;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.28);
        }

        .nav-box {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            border-radius: 10px;
            transition: all 0.18s ease;
            border: 1.5px solid #cbd5e1;
            background-color: #ffffff;
            color: #334155;
        }

        .nav-box:hover {
            transform: translateY(-2px);
            border-color: var(--ent-indigo);
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
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            border-color: transparent;
            color: #ffffff;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.22);
        }

        .option-label {
            cursor: pointer;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.18s ease;
            background-color: #ffffff;
        }

        .option-label:hover {
            background-color: #f8fafc;
            border-color: #94a3b8;
        }

        .option-input:checked + .option-label {
            background-color: #eef2ff;
            border-color: var(--ent-indigo);
            color: #312e81;
            font-weight: 600;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-exam py-3 px-3 px-md-4">
        <div class="container-fluid d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-white text-dark px-3 py-2 rounded-3 fw-bold shadow-sm">
                    <i class="fa-solid fa-eye me-1 text-primary"></i> PREVIEW TRYOUT
                </span>
                <div>
                    <h5 class="mb-0 fw-bold" style="letter-spacing: -0.01em;">{{ $paket->nama_test }}</h5>
                    <small class="text-white-50">
                        Klasifikasi: <strong class="text-white">{{ $paket->klasifikasi->nama_klasifikasi ?? '-' }}</strong>
                        &bull; Passing Grade: <span class="font-mono-code">{{ $paket->passing_grade }}</span>
                    </small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="timer-pill px-3 py-2 rounded-pill d-flex align-items-center gap-2 text-white fw-bold">
                    <i class="fa-regular fa-clock text-warning"></i>
                    <span id="countdown" class="font-mono-code fs-6">--:--:--</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid my-4 px-3 px-md-5 flex-grow-1">
        <!-- Filter Kategori pada Paket -->
        <div class="ent-card p-3 mb-3">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="d-flex flex-wrap align-items-center gap-2" id="kategoriFilterGroup">
                    <span class="small fw-bold text-secondary me-1">
                        <i class="fa-solid fa-filter me-1 text-primary"></i> Kategori:
                    </span>
                    <button type="button" class="kat-pill active" data-kategori-id="" onclick="switchKategori(this, '')">
                        Semua ({{ $paket->kategoris->sum('soals_count') }})
                    </button>
                    @foreach($paket->kategoris as $kat)
                    <button type="button" class="kat-pill" data-kategori-id="{{ $kat->id }}" onclick="switchKategori(this, {{ $kat->id }})">
                        {{ $kat->nama_kategori }} ({{ $kat->soals_count ?? 0 }})
                    </button>
                    @endforeach
                </div>
                <div class="small text-secondary font-mono-code">
                    Durasi: {{ $paket->durasi_menit }} Menit
                </div>
            </div>
        </div>

        <div id="loadingState" class="text-center py-5">
            <div class="spinner-border text-primary" role="status" style="width: 2.8rem; height: 2.8rem;"></div>
            <p class="text-secondary mt-3 fw-semibold">Memuat soal preview dari database...</p>
        </div>

        <div class="row g-4" id="examContainer" style="display: none;">
            <!-- Kolom Soal Utama -->
            <div class="col-lg-8">
                <div class="ent-card p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pb-3 mb-3 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-primary px-3 py-2 font-mono-code" id="question-number-badge">Soal No. 1</span>
                                <span class="badge bg-light text-primary border px-3 py-2" id="question-kategori-badge">-</span>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="doubtCheck" onchange="toggleDoubt()">
                                <label class="form-check-label fw-semibold text-warning" for="doubtCheck">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> Ragu-ragu
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-bold mb-3 lh-base" id="question-text">Memuat pertanyaan...</h5>
                            <div id="question-image-wrapper" class="mb-3" style="display: none;">
                                <img id="question-image" src="" alt="Gambar Soal" class="img-fluid rounded-3 border" style="max-height: 280px;">
                            </div>
                            <div id="options-container" class="d-flex flex-column gap-3"></div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap justify-content-between gap-2 pt-3 border-top mt-4">
                        <button type="button" class="btn btn-outline-secondary px-4 fw-semibold rounded-3" id="prevBtn" onclick="prevQuestion()">
                            <i class="fa-solid fa-arrow-left me-2"></i> Sebelumnya
                        </button>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-warning text-dark px-3 fw-semibold rounded-3" onclick="clearAnswer()">
                                <i class="fa-solid fa-eraser me-1"></i> Kosongkan
                            </button>
                            <button type="button" class="btn btn-primary px-4 fw-semibold rounded-3" id="nextBtn" onclick="nextQuestion()">
                                Selanjutnya <i class="fa-solid fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Panel Navigasi Nomor Soal -->
            <div class="col-lg-4">
                <div class="ent-card p-4 h-100 d-flex flex-column">
                    <h6 class="fw-bold mb-3">
                        <i class="fa-solid fa-list-check me-2 text-primary"></i>Navigasi Nomor Soal
                    </h6>

                    <div class="row g-2 mb-3 text-secondary small">
                        <div class="col-6 d-flex align-items-center gap-2">
                            <div style="width: 15px; height: 15px; background: #10b981; border-radius: 4px;"></div> Dijawab
                        </div>
                        <div class="col-6 d-flex align-items-center gap-2">
                            <div style="width: 15px; height: 15px; background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 4px;"></div> Belum
                        </div>
                        <div class="col-6 d-flex align-items-center gap-2 mt-1">
                            <div style="width: 15px; height: 15px; background: #f59e0b; border-radius: 4px;"></div> Ragu-ragu
                        </div>
                        <div class="col-6 d-flex align-items-center gap-2 mt-1">
                            <div style="width: 15px; height: 15px; background: #4f46e5; border-radius: 4px;"></div> Aktif
                        </div>
                    </div>
                    <hr class="my-2">

                    <div id="nav-grid" class="d-flex flex-wrap gap-2 overflow-auto align-content-start my-2" style="max-height: 320px;"></div>

                    <div class="mt-auto pt-3 border-top">
                        <button type="button" class="btn btn-danger w-100 py-3 fw-bold rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmModal">
                            <i class="fa-solid fa-paper-plane me-2"></i> Selesai &amp; Akhiri Preview
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Selesai -->
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title fw-bold mb-0">
                        <i class="fa-solid fa-triangle-exclamation me-2 text-warning"></i>Konfirmasi Selesai Preview
                    </h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <p class="fw-semibold mb-3">Apakah Anda ingin mengakhiri sesi preview tryout ini?</p>
                    <div class="bg-light p-3 rounded-3 text-start mb-2 border">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Total Soal:</span> <span class="fw-bold font-mono-code" id="summary-total">0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1 text-success">
                            <span>Sudah Dijawab:</span> <span class="fw-bold font-mono-code" id="summary-answered">0</span>
                        </div>
                        <div class="d-flex justify-content-between text-warning">
                            <span>Ragu-ragu:</span> <span class="fw-bold font-mono-code" id="summary-doubt">0</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Kembali</button>
                    <button type="button" class="btn btn-success px-4 fw-bold rounded-3" onclick="submitExam()">Ya, Selesai</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let questions = [];
        let currentIdx = 0;
        let countdownInterval = null;
        let timerStarted = false;
        const paketDurasiDetik = {{ (int) ($paket->durasi_menit ?? 60) * 60 }};
        const backUrl = "{{ url()->previous() }}";

        document.addEventListener("DOMContentLoaded", function() {
            fetchQuestions('');
            initSecurityFeatures();
        });

        function switchKategori(el, kategoriId) {
            document.querySelectorAll('#kategoriFilterGroup .kat-pill').forEach(btn => btn.classList.remove('active'));
            el.classList.add('active');
            fetchQuestions(kategoriId);
        }

        function fetchQuestions(kategoriId) {
            document.getElementById('loadingState').style.display = 'block';
            document.getElementById('examContainer').style.display = 'none';

            const query = kategoriId ? `?kategori_id=${encodeURIComponent(kategoriId)}` : '';

            fetch(`{{ url('admin/brain-test/paket/' . $paket->id . '/json-soal') }}${query}`)
                .then(response => response.json())
                .then(data => {
                    if (!Array.isArray(data) || data.length === 0) {
                        document.getElementById('loadingState').innerHTML = `
                            <div class="ent-card p-5 d-inline-block">
                                <i class="fa-regular fa-folder-open fa-2x text-secondary mb-2"></i>
                                <p class="text-secondary fw-semibold mb-0">Belum ada soal pada pilihan paket/kategori ini.</p>
                            </div>
                        `;
                        return;
                    }

                    questions = data.map(item => {
                        const opsiList = item.opsi_jawabans || item.opsiJawabans || [];
                        return {
                            id: item.id,
                            kategoriNama: item.kategori?.nama_kategori || '{{ $paket->nama_test }}',
                            question: item.pertanyaan,
                            image: item.gambar || null,
                            options: opsiList.map(opt => opt.teks_jawaban),
                            optionIds: opsiList.map(opt => opt.id),
                            answer: null,
                            doubt: false
                        };
                    });

                    currentIdx = 0;
                    document.getElementById('loadingState').style.display = 'none';
                    document.getElementById('examContainer').style.display = 'flex';

                    renderNavGrid();
                    loadQuestion(0);
                    updateSummaryModal();

                    if (!timerStarted) {
                        timerStarted = true;
                        startCountdown(paketDurasiDetik);
                    }
                })
                .catch(error => {
                    console.error('Error fetching questions:', error);
                    document.getElementById('loadingState').innerHTML = `<p class="text-danger fw-semibold">Gagal memuat soal tryout dari server.</p>`;
                });
        }

        function renderNavGrid() {
            const grid = document.getElementById('nav-grid');
            grid.innerHTML = '';
            questions.forEach((q, index) => {
                const box = document.createElement('div');
                box.className = `nav-box font-mono-code ${index === currentIdx ? 'active' : ''}`;
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

            document.getElementById('question-number-badge').innerText = `Soal No. ${idx + 1} / ${questions.length}`;
            document.getElementById('question-kategori-badge').innerText = q.kategoriNama;
            document.getElementById('question-text').innerText = q.question;
            document.getElementById('doubtCheck').checked = q.doubt;

            const imgWrapper = document.getElementById('question-image-wrapper');
            const imgEl = document.getElementById('question-image');
            if (q.image) {
                imgEl.src = q.image.startsWith('http') ? q.image : `{{ asset('storage') }}/${q.image}`;
                imgWrapper.style.display = 'block';
            } else {
                imgWrapper.style.display = 'none';
                imgEl.src = '';
            }

            const optionsContainer = document.getElementById('options-container');
            optionsContainer.innerHTML = '';

            q.options.forEach((opt, oIdx) => {
                const isChecked = q.answer === oIdx ? 'checked' : '';
                const optionId = `opt_${oIdx}`;

                const html = `
                    <div class="form-check p-0 m-0">
                        <input class="form-check-input option-input d-none" type="radio" name="examOption" id="${optionId}" value="${oIdx}" ${isChecked} onchange="selectAnswer(${oIdx})">
                        <label class="option-label p-3 d-flex align-items-center w-100" for="${optionId}">
                            <span class="badge bg-secondary rounded-circle me-3 d-flex align-items-center justify-content-center font-mono-code" style="width: 28px; height: 28px;">${String.fromCharCode(65 + oIdx)}</span>
                            <span class="fs-6">${opt}</span>
                        </label>
                    </div>
                `;
                optionsContainer.insertAdjacentHTML('beforeend', html);
            });

            document.getElementById('prevBtn').disabled = idx === 0;
            document.getElementById('nextBtn').innerHTML = idx === questions.length - 1
                ? 'Selesai / Cek <i class="fa-solid fa-check ms-2"></i>'
                : 'Selanjutnya <i class="fa-solid fa-arrow-right ms-2"></i>';

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
            updateSummaryModal();
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
            let timer = duration;
            const display = document.getElementById('countdown');

            if (countdownInterval) clearInterval(countdownInterval);

            countdownInterval = setInterval(function() {
                const hours = String(Math.floor(timer / 3600)).padStart(2, '0');
                const minutes = String(Math.floor((timer % 3600) / 60)).padStart(2, '0');
                const seconds = String(timer % 60).padStart(2, '0');

                display.textContent = `${hours}:${minutes}:${seconds}`;

                if (--timer < 0) {
                    clearInterval(countdownInterval);
                    submitExam();
                }
            }, 1000);
        }

        function submitExam() {
            if (countdownInterval) clearInterval(countdownInterval);
            Swal.fire({
                title: 'Preview Tryout Selesai!',
                text: 'Simulasi preview paket tryout ini telah selesai diuji.',
                icon: 'success',
                confirmButtonText: 'Kembali',
                confirmButtonColor: '#4f46e5',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = backUrl;
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
