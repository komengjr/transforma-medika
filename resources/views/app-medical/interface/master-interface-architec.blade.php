<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Architect Lab Data Acquisitor (RS-232 to LAN)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .log-container {
            background-color: #1e1e1e;
            color: #00ff00;
            font-family: 'Courier New', Courier, monospace;
            height: 350px;
            overflow-y: auto;
            padding: 15px;
            border-radius: 5px;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0 mb-4">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0">Koneksi Alat Architect Lab (RS-232 to LAN)</h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="ipAddress" class="form-label">IP Address Converter</label>
                                <input type="text" class="form-control" id="ipAddress" value="192.168.61.127" placeholder="Contoh: 192.168.1.50">
                            </div>
                            <div class="col-md-3">
                                <label for="portNumber" class="form-label">Port</label>
                                <input type="number" class="form-control" id="portNumber" value="6501" placeholder="8899">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button id="btnConnect" class="btn btn-success w-100 fw-bold">Hubungkan</button>
                            </div>
                        </div>

                        <div class="mt-4 d-flex align-items-center justify-content-between">
                            <div>
                                <span>Status Alat: </span>
                                <span id="connectionStatus" class="badge bg-danger fs-6">Terputus</span>
                            </div>
                            <div>
                                <button id="btnClear" class="btn btn-sm btn-outline-secondary">Hapus Log</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow border-0">
                    <div class="card-header bg-dark text-white fw-bold">
                        Stream Data Alat (Terambil Otomatis)
                    </div>
                    <div class="card-body">
                        <div id="dataLog" class="log-container">
                            [Sistem Ready] Silakan isi IP Converter dan klik "Hubungkan"...
                        </div>
                    </div>
                    <div class="card-footer text-muted text-end small">
                        Menggunakan Protokol WebSocket/TCP Bridge
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        let socket = null;
        const btnConnect = document.getElementById('btnConnect');
        const connectionStatus = document.getElementById('connectionStatus');
        const dataLog = document.getElementById('dataLog');
        const btnClear = document.getElementById('btnClear');

        // Fungsi untuk mencetak data/log ke layar
        function appendLog(message, isData = false) {
            const time = new Date().toLocaleTimeString();
            const formatMsg = isData ? `[${time}] DATA -> ${message}` : `[${time}] SYSTEM: ${message}`;
            dataLog.innerHTML += `<br>${formatMsg}`;
            dataLog.scrollTop = dataLog.scrollHeight; // Auto-scroll ke bawah
        }

        // Event Klik Tombol Hubungkan
        btnConnect.addEventListener('click', () => {
            if (socket && socket.readyState === WebSocket.OPEN) {
                // Jika sudah konek, klik tombol akan memutuskan koneksi
                socket.close();
                return;
            }

            const ip = document.getElementById('ipAddress').value;
            const port = document.getElementById('portNumber').value;

            if (!ip || !port) {
                alert('IP Address dan Port Converter tidak boleh kosong!');
                return;
            }

            appendLog(`Mencoba menghubungkan ke alat via ws://${ip}:${port}...`);
            btnConnect.disabled = true;
            btnConnect.textContent = 'Menghubungkan...';

            // Membuat koneksi ke converter LAN (Bisa menggunakan WebSocket converter bawaan perangkat atau websocket bridge)
            // Catatan: Pastikan Converter RS232-LAN Anda mendukung mode WebSocket Server.
            try {
                socket = new WebSocket(`ws://${ip}:${port}`);

                // 1. KETIKA SUDAH CONNECTING OTOMATIS
                socket.onopen = function(e) {
                    connectionStatus.textContent = 'Terhubung';
                    connectionStatus.className = 'badge bg-success fs-6';
                    btnConnect.disabled = false;
                    btnConnect.textContent = 'Putuskan';
                    btnConnect.className = 'btn btn-danger w-100 fw-bold';

                    appendLog("Koneksi sukses! Menunggu alat mengirimkan data...");

                    // JIKA alat butuh dipicu perintah (Trigger Command) untuk mengeluarkan data:
                    // Contoh mengirim byte hex khusus Architect Lab untuk meminta data:
                    // socket.send("POLL_DATA_COMMAND");
                };

                // 2. DATA OTOMATIS TERAMBIL / DITERIMA
                socket.onmessage = function(event) {
                    // event.data berisi string data mentah (Raw ASCII/Hex) dari port RS-232 alat Architect
                    const dataDiterima = event.data;

                    // Tampilkan ke layar secara otomatis
                    appendLog(dataDiterima, true);

                    // Di sini Anda bisa menambahkan fungsi parsing data Lab (misal memisahkan data pasien, hasil tes, dll)
                    parseLabData(dataDiterima);
                };

                // Ketika Koneksi Terputus
                socket.onclose = function(event) {
                    connectionStatus.textContent = 'Terputus';
                    connectionStatus.className = 'badge bg-danger fs-6';
                    btnConnect.disabled = false;
                    btnConnect.textContent = 'Hubungkan';
                    btnConnect.className = 'btn btn-success w-100 fw-bold';

                    if (event.wasClean) {
                        appendLog(`Koneksi ditutup dengan bersih.`);
                    } else {
                        appendLog(`Koneksi terputus tiba-tiba (Periksa kabel LAN / IP Converter).`);
                    }
                };

                // Ketika Terjadi Error
                socket.onerror = function(error) {
                    appendLog(`Error: Gagal terhubung ke IP tersebut.`);
                    console.error("WebSocket Error: ", error);
                };

            } catch (err) {
                appendLog(`Error inisialisasi: ${err.message}`);
                btnConnect.disabled = false;
                btnConnect.textContent = 'Hubungkan';
            }
        });

        // Simulasi fungsi parsing data khusus alat Architect
        function parseLabData(rawData) {
            console.log("Proses parsing data lab:", rawData);
            // Anda bisa menyimpan rawData ke database lokal atau server di sini via fetch API
        }

        // Hapus Log Layar
        btnClear.addEventListener('click', () => {
            dataLog.innerHTML = '[Log dibersihkan]';
        });
    </script>
</body>

</html>
