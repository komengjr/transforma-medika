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
            <h3 class="text-center mb-3">Viewer Rontgen Interaktif</h3>
            <canvas id="xrayCanvas" width="700" height="500"></canvas>

            <div class="controls">
                <button class="btn btn-outline-light btn-sm" id="modeWindow">🩻 Window/Level</button>
                <button class="btn btn-outline-light btn-sm" id="modeMove">✋ Move</button>
                <button class="btn btn-outline-light btn-sm" id="zoomIn">🔍 Zoom In</button>
                <button class="btn btn-outline-light btn-sm" id="zoomOut">🔎 Zoom Out</button>
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
<script>
    const canvas<?php echo $no ?> = document.getElementById("xrayCanvas");
    const ctx<?php echo $no ?> = canvas<?php echo $no ?>.getContext("2d");
    const info<?php echo $no ?> = document.getElementById("info");

    const img<?php echo $no ?> = new Image();
    img<?php echo $no ?>.src = "{{ asset('img/display/1.png') }}";

    let originalImage<?php echo $no ?> = null;
    let brightness<?php echo $no ?> = 0;
    let contrast<?php echo $no ?> = 1;
    let scale<?php echo $no ?> = 1.0;
    let offsetX<?php echo $no ?> = 0;
    let offsetY<?php echo $no ?> = 0;
    let isDragging<?php echo $no ?> = false;
    let mode<?php echo $no ?> = "window";
    let lastX<?php echo $no ?>, lastY<?php echo $no ?>;

    const btnWindow<?php echo $no ?> = document.getElementById("modeWindow");
    const btnMove<?php echo $no ?> = document.getElementById("modeMove");

    function updateActiveModeButton() {
        btnWindow<?php echo $no ?>.classList.toggle("active-mode", mode<?php echo $no ?> === "window");
        btnMove<?php echo $no ?>.classList.toggle("active-mode", mode<?php echo $no ?> === "pan");
    }

    img<?php echo $no ?>.onload = () => {
        ctx<?php echo $no ?>.drawImage(img<?php echo $no ?>, 0, 0, canvas<?php echo $no ?>.width, canvas<?php echo $no ?>.height);
        originalImage<?php echo $no ?> = ctx<?php echo $no ?>.getImageData(0, 0, canvas<?php echo $no ?>.width, canvas<?php echo $no ?>.height);
        updateActiveModeButton();
    };

    function drawImageTransformed() {
        if (!originalImage<?php echo $no ?>) return;

        ctx<?php echo $no ?>.save();
        ctx<?php echo $no ?>.clearRect(0, 0, canvas<?php echo $no ?>.width, canvas<?php echo $no ?>.height);

        const centerX<?php echo $no ?> = canvas<?php echo $no ?>.width / 2;
        const centerY<?php echo $no ?> = canvas<?php echo $no ?>.height / 2;

        ctx<?php echo $no ?>.translate(centerX<?php echo $no ?> + offsetX<?php echo $no ?>, centerY<?php echo $no ?> + offsetY<?php echo $no ?>);
        ctx<?php echo $no ?>.scale(scale<?php echo $no ?>, scale<?php echo $no ?>);
        ctx<?php echo $no ?>.translate(-centerX<?php echo $no ?>, -centerY<?php echo $no ?>);

        const tempCanvas<?php echo $no ?> = document.createElement("canvas");
        tempCanvas<?php echo $no ?>.width = originalImage<?php echo $no ?>.width;
        tempCanvas<?php echo $no ?>.height = originalImage<?php echo $no ?>.height;
        const tempCtx<?php echo $no ?> = tempCanvas<?php echo $no ?>.getContext("2d");
        tempCtx<?php echo $no ?>.putImageData(originalImage<?php echo $no ?>, 0, 0);

        const imgData<?php echo $no ?> = tempCtx<?php echo $no ?>.getImageData(0, 0, tempCanvas<?php echo $no ?>.width, tempCanvas<?php echo $no ?>.height);
        const data<?php echo $no ?> = imgData<?php echo $no ?>.data;
        for (let i = 0; i < data.length; i += 4) {
            for (let j = 0; j < 3; j++) {
                let value<?php echo $no ?> = data<?php echo $no ?>[i + j];
                value<?php echo $no ?> = ((value<?php echo $no ?> - 128) * contrast<?php echo $no ?>) + 128 + brightness<?php echo $no ?>;
                data<?php echo $no ?>[i + j] = Math.max(0, Math.min(255, value<?php echo $no ?>));
            }
        }
        tempCtx<?php echo $no ?>.putImageData(imgData<?php echo $no ?>, 0, 0);
        ctx<?php echo $no ?>.drawImage(tempCanvas<?php echo $no ?>, 0, 0, canvas<?php echo $no ?>.width, canvas<?php echo $no ?>.height);
        ctx<?php echo $no ?>.restore();
    }

    // Mouse control
    canvas<?php echo $no ?>.addEventListener("mousedown", (e) => {
        isDragging<?php echo $no ?> = true;
        lastX<?php echo $no ?> = e.clientX<?php echo $no ?>;
        lastY<?php echo $no ?> = e.clientY<?php echo $no ?>;
    });

    canvas<?php echo $no ?>.addEventListener("mouseup", () => isDragging<?php echo $no ?> = false);
    canvas<?php echo $no ?>.addEventListener("mouseleave", () => isDragging<?php echo $no ?> = false);

    canvas<?php echo $no ?>.addEventListener("mousemove", (e) => {
        if (!isDragging<?php echo $no ?>) return;
        const dx<?php echo $no ?> = e.clientX<?php echo $no ?> - lastX<?php echo $no ?>;
        const dy<?php echo $no ?> = e.clientY<?php echo $no ?> - lastY<?php echo $no ?>;

        if (mode<?php echo $no ?> === "window") {
            contrast<?php echo $no ?> += dx<?php echo $no ?> * 0.01;
            brightness<?php echo $no ?> += dy<?php echo $no ?> * 1.0;
            contrast<?php echo $no ?> = Math.max(0.1, Math.min(5, contrast<?php echo $no ?>));
            brightness<?php echo $no ?> = Math.max(-255, Math.min(255, brightness<?php echo $no ?>));
        } else if (mode<?php echo $no ?> === "pan") {
            offsetX<?php echo $no ?> += dx<?php echo $no ?>;
            offsetY<?php echo $no ?> += dy<?php echo $no ?>;
        }

        drawImageTransformed();
        info<?php echo $no ?>.innerText = `Mode: ${mode<?php echo $no ?> === "window" ? "Window/Level" : "Move"} | Kontras: ${contrast<?php echo $no ?>.toFixed(2)} | Brightness: ${brightness<?php echo $no ?>.toFixed(0)} | Zoom: ${(scale<?php echo $no ?> * 100).toFixed(0)}%`;

        lastX<?php echo $no ?> = e.clientX<?php echo $no ?>;
        lastY<?php echo $no ?> = e.clientY<?php echo $no ?>;
    });

    // Zoom
    document.getElementById("zoomIn").addEventListener("click", () => {
        scale<?php echo $no ?> = Math.min(scale<?php echo $no ?> * 1.2, 10);
        drawImageTransformed();
    });

    document.getElementById("zoomOut").addEventListener("click", () => {
        scale<?php echo $no ?> = Math.max(scale<?php echo $no ?> / 1.2, 0.2);
        drawImageTransformed();
    });

    // Reset
    document.getElementById("resetView").addEventListener("click", () => {
        brightness<?php echo $no ?> = 0;
        contrast<?php echo $no ?> = 1;
        scale<?php echo $no ?> = 1;
        offsetX<?php echo $no ?> = 0;
        offsetY<?php echo $no ?> = 0;
        drawImageTransformed();
        info<?php echo $no ?>.innerText = "Tampilan direset ke posisi awal.";
    });

    // Mode buttons
    btnWindow<?php echo $no ?>.addEventListener("click", () => {
        mode = "window";
        updateActiveModeButton();
        info<?php echo $no ?>.innerText = "Mode: Window/Level (klik dan drag untuk ubah kontras & brightness)";
    });

    btnMove<?php echo $no ?>.addEventListener("click", () => {
        mode = "pan";
        updateActiveModeButton();
        info<?php echo $no ?>.innerText = "Mode: Move (klik dan drag untuk geser gambar)";
    });
</script>
