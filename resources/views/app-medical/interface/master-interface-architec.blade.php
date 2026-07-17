@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<style>
    #button-pick-request {
        cursor: pointer;
    }

    #button-pick-request:hover {
        background: rgb(223, 217, 25);
    }

    #button-terima-order-barang-peminjaman:hover {
        background: rgb(223, 217, 25);
        cursor: pointer;
    }
</style>
@endsection
@section('content')
<div class="row mb-3 ">
    <div class="col">
        <div class="card bg-200 shadow border border-primary bg-primary">
            <div class="row gx-0 flex-between-center" style="color: white !important;">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3 m-2" src="{{ asset('img/pasien.png') }}" alt="" width="50" />
                    <div>
                        <h6 class="text-white fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-white fw-bold mb-1">{{ env('APP_LABEL')}} <span
                                class="text-white fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-white fs--1 mb-0">Menu : </h6>
                    <h4 class="text-white fw-bold mb-0">Data <span class="text-white fw-medium">Pasien</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
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
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white fw-bold text-secondary">Foto Perangkat Serial Server</div>
            <div class="card-body text-center">
                <div class="device-img-container mb-3 border">
                    <img id="deviceImage" src="https://sinergimsas.net/wp-content/uploads/2019/03/c4000-246x200.png" alt="ZQWL Device Image">
                </div>
                <small class="text-muted d-block">Model: ZQWL-EthRS (Serial to Ethernet)</small>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-3">
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
                        <tr>
                            <td class="ps-3 text-muted">Mode Perangkat</td>
                            <td class="fw-bold text-end pe-3">TCP_CLIENT</td>
                        </tr>
                        <tr>
                            <td class="ps-3 text-muted">IP Target (PC Anda)</td>
                            <td class="fw-bold text-end pe-3 text-primary">192.168.61.127</td>
                        </tr>
                        <tr>
                            <td class="ps-3 text-muted">Remote Port Target</td>
                            <td class="fw-bold text-end pe-3">6501</td>
                        </tr>
                        <tr>
                            <td class="ps-3 text-muted">Baudrate Serial</td>
                            <td class="fw-bold text-end pe-3">9600 bps</td>
                        </tr>
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
@endsection
@section('base.js')
<div class="modal fade" id="modal-pegawai-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-pegawai-xl"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        } else if (message === '___DISCONNECTED___') {
            setDeviceStatus(false);
            printLog('Koneksi dari alat terputus!', 'error');
        } else {
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
@endsection
