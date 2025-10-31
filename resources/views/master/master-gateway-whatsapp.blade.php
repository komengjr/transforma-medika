@extends('layouts.template')
@section('base.css')
    <script src="https://cdn.socket.io/4.6.1/socket.io.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <style>
        .card {
            border-radius: 16px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        #qr {
            width: 250px;
            display: none;
            padding: 10px;
            margin: 20px auto;
            border: 1px solid #04e544ff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .status {
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* 🔄 Animasi teks status (pulse) */
        .pulse {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 0.4;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.4;
            }
        }

        /* ⚙️ Spinner Loading */
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #25d366;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* 📤 Animasi kirim pesan */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
@section('content')
    <div class="row mb-3">
        <div class="col">
            <div class="card bg-100 shadow-none border">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3" src="{{ asset('asset/img/logos/apple.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-primary fs--1 mb-0 pt-2">Welcome to </h6>
                            <h4 class="text-primary fw-bold mb-1">Innoventra <span class="text-info fw-medium">Management
                                    System</span></h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-primary fs--1 mb-0">Menu : </h6>
                        <h4 class="text-primary fw-bold mb-0">Master <span class="text-info fw-medium">Gateway WA</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-primary">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="m-0"><span class="badge bg-primary m-0 p-0">Setup Whatsapp Gateway</span></h3>
                </div>
                <div class="col-auto">

                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                            type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span
                                class="fas fa-align-left me-1" data-fa-transform="shrink-3"></span>Option</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-gateway"
                                id="button-krim-pesan" data-code="123"><span class="far fa-edit"></span>
                                Kirim Pesan</button>
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-cabang"
                                id="button-data-barang-cabang" data-code="123"><span class="far fa-folder-open"></span>
                                History</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body border-top p-3">
            <!-- <h3 class="text-center mb-4">💬 WhatsApp Web JS Dashboard</h3> -->
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card border border primary p-3">
                        <div class="row">
                            <div class="col-sm-5 col-md-4">
                                <h5>Status: <span id="status" class="status text-secondary pulse">Menunggu koneksi...</span>
                                </h5>

                                <!-- 🔄 Animasi loading -->
                                <div id="spinner" class="spinner"></div>

                                <!-- 📱 QR Code -->
                                <img id="qr" src="" alt="QR Code" />

                            </div>
                            <div class="col-sm-7 col-md-8">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <form id="sendForm">
                                            <div class="mb-3">
                                                <input type="text" id="phone" class="form-control"
                                                    placeholder="Nomor tujuan (628...)" required />
                                            </div>
                                            <div class="mb-3">
                                                <textarea id="message" class="form-control" placeholder="Tulis pesan..."
                                                    required></textarea>
                                            </div>
                                            <button class="btn btn-success w-100">Kirim Pesan</button>
                                        </form>
                                        <!-- <div id="msgStatus" class="mt-3 text-muted"></div> -->
                                    </div>
                                    <div class="col-lg-4 d-flex justify-content-between flex-column">
                                        <div id="msgStatus" class="mt-3 text-muted"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('base.js')
    <div class="modal fade" id="modal-gateway" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-gateway"></div>
            </div>
        </div>
    </div>

    <script>
        const socket = io("http://localhost:3000");

        // Saat QR diterima dari server
        socket.on("qr", (qr) => {
            const qrImg = document.getElementById("qr");
            const status = document.getElementById("status");
            const spinner = document.getElementById("spinner");

            qrImg.src = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" + qr;
            qrImg.style.display = "block";
            spinner.style.display = "none";

            status.textContent = "Scan QR Code";
            status.className = "status text-warning pulse";
        });

        // Saat WhatsApp siap digunakan
        socket.on("ready", () => {
            document.getElementById("qr").style.display = "none";
            document.getElementById("spinner").style.display = "none";
            const status = document.getElementById("status");
            status.textContent = "Connected";
            status.className = "status text-success fade-in";
        });

        // Saat koneksi terputus
        socket.on("disconnected", () => {
            document.getElementById("qr").style.display = "none";
            const spinner = document.getElementById("spinner");
            spinner.style.display = "block";

            const status = document.getElementById("status");
            status.textContent = "Disconnected";
            status.className = "status text-danger pulse";
        });

        // Form kirim pesan
        document.getElementById("sendForm").addEventListener("submit", (e) => {
            e.preventDefault();
            const phone = document.getElementById("phone").value;
            const message = document.getElementById("message").value;
            socket.emit("send_message", { phone, message });
        });

        // Status kirim pesan
        socket.on("message_status", ({ phone, success }) => {
            const msgStatus = document.getElementById("msgStatus");
            msgStatus.textContent = success
                ? `Pesan ke ${phone} berhasil dikirim ✅`
                : `Gagal kirim ke ${phone} ❌`;
            msgStatus.className = success ? "text-success fade-in" : "text-danger fade-in";
        });
    </script>
@endsection
