<style>
    .viewer-container {
        text-align: center;
        margin-top: 10px;
    }

    canvas {
        border: 2px solid #444;
        border-radius: 10px;
        cursor: crosshair;
        max-width: 100%;
    }

    .info {
        text-align: center;
        margin-top: 10px;
        font-size: 0.9rem;
        color: #aaa;
    }
</style>
<div class="modal-body p-0">
    <div class="bg-300 rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Data Penunjang Poliklinik</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">{{ env('APP_LABEL') }}</a></p>
    </div>
    <div class="row g-3 p-3">
        <div class="container viewer-container">
            <canvas id="xrayCanvas" style="width: 100%;"></canvas>

            <div class="controls">
                <button class="btn btn-outline-warning btn-sm" id="modeWindow">🩻 Window/Level</button>
                <button class="btn btn-outline-danger btn-sm" id="modeMove">✋ Move</button>
                <button class="btn btn-outline-dark btn-sm" id="zoomIn">🔍 Zoom In</button>
                <button class="btn btn-outline-dark btn-sm" id="zoomOut">🔎 Zoom Out</button>
                <button class="btn btn-outline-secondary btn-sm" id="resetView">🔄 Reset View</button>
            </div>

            <div class="info" id="info">
                Mode: Window/Level (klik dan drag untuk ubah kontras & brightness)
            </div>
        </div>
    </div>
</div>
@php
    $no = mt_rand(100, 900);
@endphp
@if ($data)
    <script>
        const canvas = document.getElementById("xrayCanvas");
        const ctx = canvas.getContext("2d");
        const info = document.getElementById("info");

        const img = new Image();
        img.src = "{{ Storage::url($data->t_pasien_cat_data_poli_desc) }}";

        let originalImage = null;
        let brightness = 0;
        let contrast = 1;
        let scale = 1.0;
        let offsetX = 0;
        let offsetY = 0;
        let isDragging = false;
        let mode = "window";
        let lastX, lastY;

        const btnWindow = document.getElementById("modeWindow");
        const btnMove = document.getElementById("modeMove");

        function updateActiveModeButton() {
            btnWindow.classList.toggle("active-mode", mode === "window");
            btnMove.classList.toggle("active-mode", mode === "pan");
        }

        img.onload = () => {
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            originalImage = ctx.getImageData(0, 0, canvas.width, canvas.height);
            updateActiveModeButton();
        };

        function drawImageTransformed() {
            if (!originalImage) return;

            ctx.save();
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;

            ctx.translate(centerX + offsetX, centerY + offsetY);
            ctx.scale(scale, scale);
            ctx.translate(-centerX, -centerY);

            const tempCanvas = document.createElement("canvas");
            tempCanvas.width = originalImage.width;
            tempCanvas.height = originalImage.height;
            const tempCtx = tempCanvas.getContext("2d");
            tempCtx.putImageData(originalImage, 0, 0);

            const imgData = tempCtx.getImageData(0, 0, tempCanvas.width, tempCanvas.height);
            const data = imgData.data;
            for (let i = 0; i < data.length; i += 4) {
                for (let j = 0; j < 3; j++) {
                    let value = data[i + j];
                    value = ((value - 128) * contrast) + 128 + brightness;
                    data[i + j] = Math.max(0, Math.min(255, value));
                }
            }
            tempCtx.putImageData(imgData, 0, 0);
            ctx.drawImage(tempCanvas, 0, 0, canvas.width, canvas.height);
            ctx.restore();
        }

        // Mouse control
        canvas.addEventListener("mousedown", (e) => {
            isDragging = true;
            lastX = e.clientX;
            lastY = e.clientY;
        });

        canvas.addEventListener("mouseup", () => isDragging = false);
        canvas.addEventListener("mouseleave", () => isDragging = false);

        canvas.addEventListener("mousemove", (e) => {
            if (!isDragging) return;
            const dx = e.clientX - lastX;
            const dy = e.clientY - lastY;

            if (mode === "window") {
                contrast += dx * 0.01;
                brightness += dy * 1.0;
                contrast = Math.max(0.1, Math.min(5, contrast));
                brightness = Math.max(-255, Math.min(255, brightness));
            } else if (mode === "pan") {
                offsetX += dx;
                offsetY += dy;
            }

            drawImageTransformed();
            info.innerText = `Mode: ${mode === "window" ? "Window/Level" : "Move"} | Kontras: ${contrast.toFixed(2)} | Brightness: ${brightness.toFixed(0)} | Zoom: ${(scale * 100).toFixed(0)}%`;

            lastX = e.clientX;
            lastY = e.clientY;
        });

        // Zoom
        document.getElementById("zoomIn").addEventListener("click", () => {
            scale = Math.min(scale * 1.2, 10);
            drawImageTransformed();
        });

        document.getElementById("zoomOut").addEventListener("click", () => {
            scale = Math.max(scale / 1.2, 0.2);
            drawImageTransformed();
        });

        // Reset
        document.getElementById("resetView").addEventListener("click", () => {
            brightness = 0;
            contrast = 1;
            scale = 1;
            offsetX = 0;
            offsetY = 0;
            drawImageTransformed();
            info.innerText = "Tampilan direset ke posisi awal.";
        });

        // Mode buttons
        btnWindow.addEventListener("click", () => {
            mode = "window";
            updateActiveModeButton();
            info.innerText = "Mode: Window/Level (klik dan drag untuk ubah kontras & brightness)";
        });

        btnMove.addEventListener("click", () => {
            mode = "pan";
            updateActiveModeButton();
            info.innerText = "Mode: Move (klik dan drag untuk geser gambar)";
        });
    </script>
@endif
