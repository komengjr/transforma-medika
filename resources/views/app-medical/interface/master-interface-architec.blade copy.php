<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Data Acquisitor - Architect Lab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .log-terminal {
            background-color: #111827;
            color: #10B981;
            font-family: 'Fira Code', 'Courier New', monospace;
            height: 450px;
            overflow-y: auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: inset 0 2px 8px rgba(0,0,0,0.8);
            border: 1px solid #374151;
        }
        .device-img-container {
            max-height: 200px;
            overflow: hidden;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #eaeaea;
        }
        .device-img-container img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }
        .status-badge {
            font-size: 0.9rem;
            padding: 6px 12px;
            border-radius: 50px;
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
            <div>
                <h2 class="fw-bold text-dark mb-0">Architect Lab Data System</h2>
                <p class="text-muted mb-0">Penerimaan data otomatis via RS-232 to LAN (TCP Client Mode)</p>
            </div>
            <div>
                <span id="mainStatusBadge" class="badge bg-danger status-badge shadow-sm">
                    <i id="mainStatusIcon" class="bi bi-broadcast-pin me-1"></i>
                    <span id="mainStatusText">ALAT DISKONEK</span>
                </span>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold text-secondary">Foto Perangkat Serial Server</div>
                    <div class="card-body text-center">
                        <div class="device-img-container mb-3 border">
                            <img id="deviceImage" src="https://images.unsplash.com/photo-1581092335397-9583fe92d232?auto=format&fit=crop&w=400&q=80" alt="ZQWL Device Image">
                        </div>
                        <small class="text-muted d-block">Model: ZQWL-EthRS (Serial to Ethernet)</small>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body text-center p-4">
                        <h6 class="text-uppercase text-muted fw-bold mb-3 small">Live Status</h6>
                        <div id="statusIndicator" class="spinner-grow text-danger mb-3" role="status" style="width: 2.5rem; height: 2.5rem;"></div>
                        <h4 id="statusText" class="fw-bold text-danger">Alat Terputus</h4>
                        <p id="deviceIpDetail" class="text-muted small mb-0">Menunggu sambungan dari port 6501...</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white fw-bold text-secondary">Parameter Konfigurasi</div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0 small">
                            <tbody>
                                <tr><td class="ps-3 text-muted">Mode Perangkat</td><td class="fw-bold text-end pe-3">TCP_CLIENT</td></tr>
                                <tr><td class="ps-3 text-muted">IP Target (PC Anda)</td><td class="fw-bold text-end pe-3 text-primary">192.168.61.127</td></tr>
                                <tr><td class="ps-3 text-muted">Remote Port Target</td><td class="fw-bold text-end pe-3">6501</td></tr>
                                <tr><td class="ps-3 text-muted">Baudrate Serial</td><td class="fw-bold text-end pe-3">9600 bps</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 fw-bold text-dark">Data Terambil (Real-time Stream)</h5>
                        <button id="btnClearLog" class="btn btn-sm btn-outline-secondary px-3">Bersihkan Layar</button>
                    </div>
                    <div class="card-body">
                        <div id="terminalLog" class="log-terminal">
                            [SYSTEM] Menunggu koneksi dari server backend...
                        </div>
                    </div>
                    <div class="card-footer bg-white text-muted small text-end">
                        Data akan muncul otomatis di atas begitu alat melakukan transmisi.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const terminalLog = document.getElementById('terminalLog');
        const statusIndicator = document.getElementById('statusIndicator');
        const statusText = document.getElementById('statusText');
        const deviceIpDetail = document.getElementById('deviceIpDetail');
        const btnClearLog = document.getElementById('btnClearLog');

        // Element Status Atas
        const mainStatusBadge = document.getElementById('mainStatusBadge');
        const mainStatusIcon = document.getElementById('mainStatusIcon');
        const mainStatusText = document.getElementById('mainStatusText');

        // Sambungkan ke WebSocket Backend (Port 8080)
        const ws = new WebSocket('ws://localhost:8080');

        ws.onopen = () => {
            printLog('Terhubung ke Backend Server. Siap menerima stream data dari port 6501.');
        };

        // PROSES PENERIMAAN DATA OTOMATIS
        ws.onmessage = (event) => {
            const message = event.data;

            // Cek sinyal internal koneksi alat dari backend
            if (message.startsWith('___CONNECTED___')) {
                const ipAlat = message.split(':')[1];
                setDeviceStatus(true, ipAlat);
                printLog(`Alat dengan IP ${ipAlat} berhasil terhubung ke server!`, 'info');
            }
            else if (message === '___DISCONNECTED___') {
                setDeviceStatus(false);
                printLog('Koneksi dari alat terputus!', 'error');
            }
            else {
                // JIKA MURNI DATA DARI ALAT ARCHITECT LAB
                printLog(message, 'data');
            }
        };

        ws.onclose = () => {
            setDeviceStatus(false);
            printLog('Koneksi ke Backend Server terputus! Pastikan Anda sudah menjalankan node server.js', 'error');
        };

        // Fungsi manipulasi status UI Konek dan Diskonek
        function setDeviceStatus(isConnected, ip = '') {
            if (isConnected) {
                // Tampilan Tengah Card
                statusIndicator.className = "spinner-grow text-success mb-3";
                statusText.textContent = "Alat Terhubung";
                statusText.className = "fw-bold text-success";
                deviceIpDetail.textContent = `Menerima data aktif dari IP: ${ip}`;

                // Tampilan Badge Atas (KONEK)
                mainStatusBadge.className = "badge bg-success status-badge shadow-sm animate__animated animate__fadeIn";
                mainStatusIcon.className = "bi bi-check-circle-fill me-1";
                mainStatusText.textContent = "ALAT TERHUBUNG";
            } else {
                // Tampilan Tengah Card
                statusIndicator.className = "spinner-grow text-danger mb-3";
                statusText.textContent = "Alat Terputus";
                statusText.className = "fw-bold text-danger";
                deviceIpDetail.textContent = "Menunggu perangkat mengirim data ke port 6501...";

                // Tampilan Badge Atas (DISKONEK)
                mainStatusBadge.className = "badge bg-danger status-badge shadow-sm";
                mainStatusIcon.className = "bi bi-exclamation-triangle-fill me-1";
                mainStatusText.textContent = "ALAT DISKONEK";
            }
        }

        // Fungsi mencetak log ke terminal tiruan
        function printLog(text, type = 'system') {
            const time = new Date().toLocaleTimeString();
            let formattedText = '';

            if (type === 'data') {
                formattedText = `<div class="mb-1"><span class="text-warning">[${time}] DATA IN &gt;&gt;</span> <span class="text-white fw-bold">${text}</span></div>`;
            } else if (type === 'error') {
                formattedText = `<div class="text-danger mb-1">[${time}] ERROR: ${text}</div>`;
            } else {
                formattedText = `<div class="text-muted mb-1">[${time}] SYS: ${text}</div>`;
            }

            terminalLog.innerHTML += formattedText;
            terminalLog.scrollTop = terminalLog.scrollHeight;
        }

        btnClearLog.addEventListener('click', () => {
            terminalLog.innerHTML = `<div class="text-muted">[Layar dibersihkan pada ${new Date().toLocaleTimeString()}]</div>`;
        });
    </script>
</body>
</html>
