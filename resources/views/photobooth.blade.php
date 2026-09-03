<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Web Photobooth Laravel</title>

    <!-- SweetAlert2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- QRCode.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* LATAR BELAKANG UTAMA DENGAN GAMBAR + OVERLAY WARNA-WARNI */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, rgba(106, 17, 203, 0.75), rgba(37, 117, 252, 0.75), rgba(255, 64, 129, 0.75)),
                url('https://pustaka.bca.co.id/Promo/A2C31A68-BC10-4CBD-AB51-85474A36CC50/Detail/ImageListing/20250723_PRAMITA-LAB-SBY-thumb.jpeg') center/cover no-repeat fixed;
            color: #fff;
            text-align: center;
            padding: 20px;
            min-height: 100vh;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 2.2rem;
            font-weight: bold;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            color: #ffffff;
        }

        /* LAYOUT STEP (CONTAINER FORM & FRAME) */
        .step-box {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.92);
            padding: 30px;
            border-radius: 20px;
            text-align: left;
            color: #333;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #444;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            border: 2px solid #ddd;
            background: #f9f9f9;
            color: #333;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #ff4081;
            background: #fff;
            box-shadow: 0 0 8px rgba(255, 64, 129, 0.3);
        }

        /* STEP 2: FRAME OPTIONS */
        .frame-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 20px 0;
        }

        .frame-card {
            padding: 12px;
            border: 3px solid #e0e0e0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fff;
            text-align: center;
            color: #333;
            font-weight: 600;
        }

        .frame-card img {
            width: 100%;
            height: 100px;
            object-fit: contain;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .frame-card:hover {
            transform: translateY(-3px);
        }

        .frame-card.active {
            border-color: #ff4081;
            background: #fff0f5;
            box-shadow: 0 4px 15px rgba(255, 64, 129, 0.3);
        }

        /* STEP 3: LAYOUT BOOTH */
        #step-booth {
            display: none;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-start;
            gap: 30px;
            width: 100%;
            padding: 0 20px;
        }

        .booth-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        /* CONTAINER KAMERA */
        .camera-container {
            position: relative;
            width: 100%;
            max-width: 600px;
            border-radius: 16px;
            overflow: hidden;
            background: #000;
            margin-bottom: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
            border: 4px solid #fff;
        }

        /* VIDEO KAMERA FULL */
        video {
            width: 100%;
            height: auto;
            display: block;
            transform: scaleX(-1);
            transition: filter 0.3s ease;
        }

        /* FILTER CSS PADA VIDEO & CANVAS */
        .filter-normal {
            filter: none;
        }

        .filter-grayscale {
            filter: grayscale(100%);
        }

        .filter-sepia {
            filter: sepia(100%);
        }

        .filter-vintage {
            filter: sepia(50%) contrast(120%) brightness(90%);
        }

        .filter-bright {
            filter: brightness(125%) contrast(105%);
        }

        .filter-cool {
            filter: hue-rotate(30deg) saturate(120%);
        }

        .frame-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            object-fit: fill;
        }

        .countdown {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 7rem;
            font-weight: bold;
            color: #ffeb3b;
            text-shadow: 0 0 20px rgba(0, 0, 0, 0.9);
            display: none;
            z-index: 10;
        }

        .preview-section {
            width: 100%;
            max-width: 600px;
            background: rgba(255, 255, 255, 0.92);
            padding: 20px;
            border-radius: 16px;
            margin-bottom: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
        }

        .preview-gallery {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            width: 100%;
        }

        .preview-item {
            background: #f0f0f0;
            border: 2px dashed #bbb;
            border-radius: 10px;
            min-height: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: #888;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* CANVAS HIDDEN */
        canvas {
            display: none;
        }

        /* TABEL HASIL */
        .table-container {
            width: 100%;
            max-width: 600px;
            margin-top: 10px;
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 16px;
            display: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            text-align: left;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }

        th {
            background: #f0f0f0;
            color: #ff4081;
            font-weight: bold;
        }

        td a {
            color: #2196F3;
            font-weight: bold;
            text-decoration: none;
        }

        /* BUTTONS */
        .btn {
            background: linear-gradient(45deg, #ff4081, #ff6e40);
            color: white;
            border: none;
            padding: 16px 28px;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 30px;
            cursor: pointer;
            width: 100%;
            margin-bottom: 10px;
            box-shadow: 0 4px 15px rgba(255, 64, 129, 0.4);
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 64, 129, 0.6);
        }

        .btn:disabled {
            background: #bbb;
            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }

        .btn-secondary {
            background: #666;
            font-size: 0.95rem;
            padding: 12px 20px;
            box-shadow: none;
        }

        .btn-secondary:hover {
            background: #555;
            box-shadow: none;
        }

        .btn-merge {
            background: linear-gradient(45deg, #2196F3, #00BCD4);
            display: none;
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.4);
        }

        /* STYLE MODAL SWAL QR */
        .qrcode-swal-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 15px;
        }

        .qrcode-swal-container img,
        .qrcode-swal-container canvas {
            border: 4px solid #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 900px) {
            #step-booth {
                flex-direction: column;
                align-items: center;
                padding: 0;
            }
        }
    </style>
</head>

<body>

    <h1>📸 Web Photobooth</h1>

    <!-- LANGKAH 1: ISI FORM DATA DIRI -->
    <div id="step-1-form" class="step-box">
        <h3 style="margin-bottom: 20px; color: #ff4081; text-align: center;">Langkah 1: Isi Data Diri</h3>
        <div class="form-group">
            <label for="user-name">Nama Lengkap:</label>
            <input type="text" id="user-name" placeholder="Masukkan nama Anda">
        </div>
        <div class="form-group">
            <label for="user-phone">Nomor HP / WhatsApp:</label>
            <input type="tel" id="user-phone" placeholder="Contoh: 08123456789">
        </div>
        <div class="form-group">
            <label for="user-email">Email:</label>
            <input type="email" id="user-email" placeholder="Contoh: user@email.com">
        </div>
        <button class="btn" onclick="submitFormStep1()">Submit Data Diri</button>
    </div>

    <!-- LANGKAH 2: PILIH FRAME, FILTER, & KAMERA PREVIEW FULL -->
    <div id="step-2-frame" class="step-box" style="display: none;">
        <h3 style="margin-bottom: 15px; color: #ff4081; text-align: center;">Langkah 2: Pilih Frame & Filter</h3>

        <!-- PREVIEW KAMERA FULL -->
        <div class="camera-container" style="max-width: 100%;">
            <video id="webcam-preview" class="filter-normal" autoplay playsinline></video>
            <img id="frame-preview-overlay" class="frame-overlay" src="" alt="Frame Overlay">
        </div>

        <!-- FITUR PILIHAN FILTER KAMERA -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="camera-filter">Pilih Filter Kamera:</label>
            <select id="camera-filter" onchange="applyFilter(this.value)">
                <option value="filter-normal">Normal</option>
                <option value="filter-grayscale">Hitam Putih (Grayscale)</option>
                <option value="filter-sepia">Sepia (Klasik)</option>
                <option value="filter-vintage">Vintage / Retro</option>
                <option value="filter-bright">Bright & Contrast</option>
                <option value="filter-cool">Cool Blue</option>
            </select>
        </div>

        <!-- PILIHAN FRAME -->
        <div class="frame-options">
            @foreach($frames as $key => $frame)
            <div class="frame-card {{ $key === 0 ? 'active' : '' }}"
                data-src="{{ $frame['image'] }}"
                onclick="selectFrame(this)">
                <img src="{{ $frame['image'] }}" alt="{{ $frame['name'] }}">
                <span>{{ $frame['name'] }}</span>
            </div>
            @endforeach
        </div>

        <button class="btn" onclick="goToStep3Booth()">Next: Mulai Sesi Foto</button>
        <button class="btn btn-secondary" onclick="backToStep1()">Kembali ke Form</button>
    </div>

    <!-- LANGKAH 3: PEMOTRETAN -->
    <div id="step-booth">
        <!-- KOLOM KIRI: KAMERA UTAMA -->
        <div class="booth-column">
            <div class="camera-container">
                <video id="webcam" class="filter-normal" autoplay playsinline></video>
                <img id="live-frame-overlay" class="frame-overlay" src="" alt="Frame Overlay">
                <div id="countdown" class="countdown">3</div>
            </div>

            <div style="width: 100%; max-width: 600px;">
                <button id="start-btn" class="btn" onclick="startPhotobooth()">Mulai Ambil Foto (4 Pose)</button>
                <button id="merge-btn" class="btn btn-merge" onclick="mergePhotos()">Proses & Dapatkan Barcode</button>
                <button id="back-btn" class="btn btn-secondary" onclick="backToStep2()">Ganti Frame / Filter</button>
            </div>
        </div>

        <!-- KOLOM KANAN: PREVIEW 4 POSE & TABEL HASIL -->
        <div class="booth-column">
            <div class="preview-section">
                <h4 style="margin-bottom: 12px; color: #ff4081;">Hasil Jepretan (4 Pose)</h4>
                <div class="preview-gallery">
                    <div class="preview-item" id="slot-0">Pose 1</div>
                    <div class="preview-item" id="slot-1">Pose 2</div>
                    <div class="preview-item" id="slot-2">Pose 3</div>
                    <div class="preview-item" id="slot-3">Pose 4</div>
                </div>
            </div>

            <!-- CANVAS TERSEMBUNYI -->
            <canvas id="photo-strip"></canvas>

            <!-- TABEL HASIL DENGAN QR CODE -->
            <div id="table-container" class="table-container">
                <h4 style="margin-bottom: 12px; color: #ff4081;">Daftar Barcode Link Foto</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Barcode QR</th>
                        </tr>
                    </thead>
                    <tbody id="user-table-body"></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const step1Form = document.getElementById('step-1-form');
        const step2Frame = document.getElementById('step-2-frame');
        const stepBooth = document.getElementById('step-booth');

        const videoPreview = document.getElementById('webcam-preview');
        const videoMain = document.getElementById('webcam');

        const framePreviewOverlay = document.getElementById('frame-preview-overlay');
        const liveOverlay = document.getElementById('live-frame-overlay');

        const canvas = document.getElementById('photo-strip');
        const ctx = canvas.getContext('2d');
        const countdownEl = document.getElementById('countdown');

        const startBtn = document.getElementById('start-btn');
        const mergeBtn = document.getElementById('merge-btn');
        const backBtn = document.getElementById('back-btn');

        const tableContainer = document.getElementById('table-container');
        const userTableBody = document.getElementById('user-table-body');

        const TOTAL_PHOTOS = 4;
        let photoWidth = 600,
            photoHeight = 450;
        const PADDING = 20,
            BORDER_COLOR = '#ffffff',
            BORDER_WIDTH = 6;

        let mediaStream = null;
        let selectedFrameSrc = document.querySelector('.frame-card.active')?.getAttribute('data-src') || '';
        let currentFilterClass = 'filter-normal';
        let frameImageObj = new Image();
        let framedPhotos = [];
        let audioCtx = null;

        function initAudio() {
            if (!audioCtx) audioCtx = new(window.AudioContext || window.webkitAudioContext)();
        }

        function playBeepSound() {
            initAudio();
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(600, audioCtx.currentTime);
            gain.gain.setValueAtTime(0.1, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.15);
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.start();
            osc.stop(audioCtx.currentTime + 0.15);
        }

        function playShutterSound() {
            initAudio();
            const bufferSize = audioCtx.sampleRate * 0.08;
            const buffer = audioCtx.createBuffer(1, bufferSize, audioCtx.sampleRate);
            const output = buffer.getChannelData(0);
            for (let i = 0; i < bufferSize; i++) output[i] = Math.random() * 2 - 1;
            const noise = audioCtx.createBufferSource();
            noise.buffer = buffer;
            const filter = audioCtx.createBiquadFilter();
            filter.type = 'highpass';
            filter.frequency.value = 1000;
            const gain = audioCtx.createGain();
            gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.08);
            noise.connect(filter);
            filter.connect(gain);
            gain.connect(audioCtx.destination);
            noise.start();
        }

        /* LOGIKA AKSI FILTER */
        function applyFilter(filterClass) {
            currentFilterClass = filterClass;

            // Update class filter pada element video
            videoPreview.className = filterClass;
            videoMain.className = filterClass;
        }

        /* STEP 1 LOGIC (DENGAN LOADING SWAL ALERT) */
        async function submitFormStep1() {
            const name = document.getElementById('user-name').value.trim();
            const phone = document.getElementById('user-phone').value.trim();
            const email = document.getElementById('user-email').value.trim();

            if (!name || !phone || !email) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: 'Harap lengkapi nama, nomor HP, dan email!',
                    confirmButtonColor: '#ff4081'
                });
                return;
            }

            // Tampilkan Swal Loading saat memuat kamera & pindah ke Langkah 2
            Swal.fire({
                title: 'Memuat Kamera...',
                text: 'Mohon izinkan akses kamera pada browser Anda.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                await startCamera();

                // Sembunyikan Swal Loading
                Swal.close();

                // Pindah ke Langkah 2
                step1Form.style.display = 'none';
                step2Frame.style.display = 'block';

                videoPreview.srcObject = mediaStream;
                updateFrameOverlay();

            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kamera Gagal Dimuat',
                    text: 'Tidak dapat mengakses kamera: ' + err.message,
                    confirmButtonColor: '#ff4081'
                });
            }
        }

        function backToStep1() {
            step2Frame.style.display = 'none';
            step1Form.style.display = 'block';
            stopCamera();
        }

        /* STEP 2 LOGIC */
        function selectFrame(element) {
            document.querySelectorAll('.frame-card').forEach(card => card.classList.remove('active'));
            element.classList.add('active');
            selectedFrameSrc = element.getAttribute('data-src');
            updateFrameOverlay();
        }

        function updateFrameOverlay() {
            frameImageObj.src = selectedFrameSrc;
            framePreviewOverlay.src = selectedFrameSrc;
            liveOverlay.src = selectedFrameSrc;
        }

        function goToStep3Booth() {
            if (!selectedFrameSrc) {
                Swal.fire('Perhatian', 'Silakan pilih frame terlebih dahulu!', 'warning');
                return;
            }

            step2Frame.style.display = 'none';
            stepBooth.style.display = 'flex';

            videoMain.srcObject = mediaStream;
            resetBoothState();
        }

        function backToStep2() {
            resetBoothState();
            stepBooth.style.display = 'none';
            step2Frame.style.display = 'block';
            videoPreview.srcObject = mediaStream;
        }

        /* CAMERA FUNCTIONALITY */
        async function startCamera() {
            if (!mediaStream) {
                mediaStream = await navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: false
                });
                videoMain.onloadedmetadata = () => {
                    photoWidth = videoMain.videoWidth || 600;
                    photoHeight = videoMain.videoHeight || 450;
                };
            }
        }

        function stopCamera() {
            if (mediaStream) {
                mediaStream.getTracks().forEach(track => track.stop());
                mediaStream = null;
            }
        }

        function resetBoothState() {
            framedPhotos = [];
            for (let i = 0; i < TOTAL_PHOTOS; i++) {
                document.getElementById(`slot-${i}`).innerHTML = `Pose ${i + 1}`;
            }
            mergeBtn.style.display = 'none';
            startBtn.style.display = 'block';
            startBtn.disabled = false;
            backBtn.disabled = false;
        }

        /* PEMOTRETAN & IMPLEMENTASI FILTER PADA CANVAS */
        async function startPhotobooth() {
            initAudio();
            startBtn.disabled = true;
            backBtn.disabled = true;
            mergeBtn.style.display = 'none';
            framedPhotos = [];

            for (let i = 0; i < TOTAL_PHOTOS; i++) {
                await runCountdown(3);
                captureFramedPhoto(i);
            }

            startBtn.style.display = 'none';
            mergeBtn.style.display = 'block';
            backBtn.disabled = false;
        }

        function runCountdown(seconds) {
            return new Promise((resolve) => {
                countdownEl.style.display = 'block';
                let count = seconds;
                countdownEl.innerText = count;
                playBeepSound();

                const interval = setInterval(() => {
                    count--;
                    if (count > 0) {
                        countdownEl.innerText = count;
                        playBeepSound();
                    } else {
                        clearInterval(interval);
                        countdownEl.style.display = 'none';
                        resolve();
                    }
                }, 1000);
            });
        }

        function captureFramedPhoto(index) {
            playShutterSound();

            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = photoWidth;
            tempCanvas.height = photoHeight;
            const tempCtx = tempCanvas.getContext('2d');

            // Terapkan Filter CSS terpilih ke konteks Canvas
            const filterStyles = getComputedStyle(videoMain).filter;
            tempCtx.filter = filterStyles !== 'none' ? filterStyles : 'none';

            // Mirroring & Gambar Video
            tempCtx.translate(photoWidth, 0);
            tempCtx.scale(-1, 1);
            tempCtx.drawImage(videoMain, 0, 0, photoWidth, photoHeight);
            tempCtx.restore();

            // Reset filter untuk frame agar frame tidak kena imbas filter
            tempCtx.filter = 'none';
            tempCtx.drawImage(frameImageObj, 0, 0, photoWidth, photoHeight);

            const imgDataUrl = tempCanvas.toDataURL('image/png');
            framedPhotos.push(imgDataUrl);

            document.getElementById(`slot-${index}`).innerHTML = `<img src="${imgDataUrl}" alt="Pose ${index + 1}">`;
        }

        function mergePhotos() {
            if (framedPhotos.length < TOTAL_PHOTOS) return;

            canvas.width = photoWidth + (PADDING * 2);
            canvas.height = (photoHeight * TOTAL_PHOTOS) + (PADDING * (TOTAL_PHOTOS + 1));

            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            let loadedCount = 0;

            framedPhotos.forEach((src, index) => {
                const img = new Image();
                img.src = src;
                img.onload = () => {
                    const yOffset = PADDING + index * (photoHeight + PADDING);
                    ctx.drawImage(img, PADDING, yOffset, photoWidth, photoHeight);
                    ctx.strokeStyle = BORDER_COLOR;
                    ctx.lineWidth = BORDER_WIDTH;
                    ctx.strokeRect(PADDING, yOffset, photoWidth, photoHeight);

                    loadedCount++;
                    if (loadedCount === TOTAL_PHOTOS) {
                        saveToDatabase(canvas.toDataURL('image/png'));
                    }
                };
            });
        }

        /* LOGIKA SIMPAN VIA SWAL LOADING & QRCODE */
        function saveToDatabase(base64Image) {
            const name = document.getElementById('user-name').value;
            const phone = document.getElementById('user-phone').value;
            const email = document.getElementById('user-email').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            Swal.fire({
                title: 'Menyimpan Foto...',
                text: 'Mohon tunggu sebentar, foto sedang diunggah.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch("{{ route('photobooth.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        name,
                        phone,
                        email,
                        image_data: base64Image
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const shareUrl = data.share_url;

                        Swal.fire({
                            title: 'Foto Berhasil Disimpan!',
                            html: `
              <p style="font-size: 0.9rem; margin-bottom: 10px; color: #555;">Pindai QR Code di bawah untuk melihat foto:</p>
              <div class="qrcode-swal-container">
                <div id="swal-qrcode"></div>
              </div>
              <p style="margin-top: 15px;"><a href="${shareUrl}" target="_blank" style="color: #2196F3; font-size: 0.9rem; font-weight: bold;">Buka Link Langsung</a></p>
            `,
                            icon: 'success',
                            confirmButtonText: 'Selesai',
                            confirmButtonColor: '#ff4081',
                            didOpen: () => {
                                new QRCode(document.getElementById("swal-qrcode"), {
                                    text: shareUrl,
                                    width: 180,
                                    height: 180,
                                    colorDark: "#000000",
                                    colorLight: "#ffffff",
                                    correctLevel: QRCode.CorrectLevel.H
                                });
                            }
                        });

                        const tr = document.createElement('tr');
                        const qrContainerId = `qr-table-${Date.now()}`;
                        tr.innerHTML = `
            <td>${escapeHtml(data.data.name)}</td>
            <td>${escapeHtml(data.data.phone)}</td>
            <td>
              <div id="${qrContainerId}"></div>
              <a href="${shareUrl}" target="_blank" style="font-size: 0.75rem;">Buka Link</a>
            </td>
          `;

                        userTableBody.appendChild(tr);
                        tableContainer.style.display = 'block';

                        new QRCode(document.getElementById(qrContainerId), {
                            text: shareUrl,
                            width: 70,
                            height: 70
                        });

                    } else {
                        Swal.fire('Gagal!', data.message || 'Terjadi kesalahan saat menyimpan foto.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', 'Gagal menghubungkan ke server.', 'error');
                });
        }

        function escapeHtml(text) {
            return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }
    </script>
</body>

</html>
