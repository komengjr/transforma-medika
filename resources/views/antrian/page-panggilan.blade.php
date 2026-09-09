<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Petugas Pemanggil Antrian | Innoventra Queue</title>

    <!-- Bootstrap 5 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- SweetAlert2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: #f1f5f9;
            color: #1e293b;
            min-height: 100vh;
        }

        .card-custom {
            background: #ffffff;
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .active-number {
            font-size: 5.5rem;
            font-weight: 800;
            color: #0284c7;
            line-height: 1;
        }

        .btn-action {
            border-radius: 14px;
            padding: 12px 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>

<body class="py-4">

    <div class="container">
        <!-- Header Selection Bar (Bound By IP) -->
        <div class="card card-custom p-4 mb-4">
            @if(!$assignedCounter)
            <div class="alert alert-danger mb-0 d-flex align-items-center" role="alert">
                <i class="fa-solid fa-triangle-exclamation fs-3 me-3"></i>
                <div>
                    <strong>Akses Dibatasi!</strong> Komputer dengan IP <code>{{ $clientIp }}</code> belum terdaftar dalam sistem <b>medical_loket_counters</b>. Silakan masukkan IP ini ke database terlebih dahulu.
                </div>
            </div>
            @else
            <div class="row g-3 align-items-center">
                <div class="col-md-5">
                    <label class="form-label fw-bold text-secondary mb-1">
                        <i class="fa-solid fa-building-user me-1"></i> Pilih Filter Loket Pelayanan
                    </label>
                    <select class="form-select form-select-lg fw-bold border-primary" id="selectLoket" onchange="initData()">
                        <option value="">-- Semua Loket Terikat --</option>
                        @foreach($loketList as $loket)
                        <option value="{{ $loket->id }}">{{ $loket->nama_loket }} ({{ $loket->kode_prefix }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-secondary mb-1">
                        <i class="fa-solid fa-desktop me-1"></i> Counter / Meja (IP Terkunci)
                    </label>
                    <input type="text" class="form-control form-control-lg fw-bold bg-light text-primary" value="Counter {{ $assignedCounter->nomor_counter }} (IP: {{ $clientIp }})" readonly>
                </div>
                <div class="col-md-3 text-end pt-3">
                    <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill" id="badgeTotalMenunggu">0 Antrian Menunggu</span>
                </div>
            </div>
            @endif
        </div>

        @if($assignedCounter)
        <div class="row g-4">
            <!-- Boks Pemanggilan Antrian Aktif -->
            <div class="col-md-7">
                <div class="card card-custom p-5 text-center h-100 d-flex flex-column justify-content-between">
                    <div>
                        <span class="text-uppercase fw-bold text-muted tracking-wide fs-6">Sedang Dilayani</span>
                        <div class="active-number my-3" id="textNomorAktif">---</div>
                        <div class="badge bg-soft-info text-info fs-6 px-3 py-2 mb-4 rounded-pill border border-info" id="textLoketAktif">
                            Siap Memanggil
                        </div>
                    </div>

                    <!-- Tombol Aksi Utama -->
                    <div class="d-grid gap-3">
                        <button class="btn btn-primary btn-action fs-5 shadow" id="btnPanggilBerikutnya" onclick="panggilBerikutnya()">
                            <i class="fa-solid fa-bullhorn me-2"></i> Panggil Antrian Berikutnya
                        </button>

                        <div class="row g-2">
                            <div class="col-md-4">
                                <button class="btn btn-warning btn-action w-100 text-white" id="btnPanggilUlang" onclick="panggilUlang()" disabled>
                                    <i class="fa-solid fa-rotate-right me-1"></i> Panggil Ulang
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success btn-action w-100" id="btnSelesai" onclick="updateStatus('selesai')" disabled>
                                    <i class="fa-solid fa-check me-1"></i> Selesai
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-outline-danger btn-action w-100" id="btnBatal" onclick="updateStatus('batal')" disabled>
                                    <i class="fa-solid fa-xmark me-1"></i> Lewati / Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Sisa Antrian Menunggu -->
            <div class="col-md-5">
                <div class="card card-custom p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h5 class="fw-bold mb-0 text-slate-700">
                            <i class="fa-solid fa-list-ol me-2 text-primary"></i>Daftar Menunggu
                        </h5>
                        <button class="btn btn-sm btn-light rounded-circle" onclick="initData()">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </button>
                    </div>

                    <div class="overflow-auto" style="max-height: 420px;" id="containerMenunggu">
                        <!-- Dynamic List via Javascript -->
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- JavaScript Logic -->
    <script>
        let currentLogId = null;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Toast notification serbaguna untuk feedback ringan
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        // Fetch & Sync Data dari Server
        async function initData() {
            try {
                const selectedLoket = document.getElementById('selectLoket').value;
                const res = await fetch(`{{ route('antrian.petugas.data') }}?loket_id=${selectedLoket}`);
                const data = await res.json();

                if (res.ok && data.success) {
                    // Set State Pemanggilan Aktif
                    if (data.sedang_dilayani) {
                        currentLogId = data.sedang_dilayani.id;
                        document.getElementById('textNomorAktif').textContent = data.sedang_dilayani.nomor_antrian;
                        document.getElementById('textLoketAktif').textContent = `Melayani di Counter ${data.counter.nomor_counter}`;

                        // Kunci tombol panggil berikutnya, aktifkan tombol selesai/batal/panggil ulang
                        toggleButtons(true);
                    } else {
                        currentLogId = null;
                        document.getElementById('textNomorAktif').textContent = "---";
                        document.getElementById('textLoketAktif').textContent = "Siap Memanggil";

                        // Buka kunci tombol panggil berikutnya
                        toggleButtons(false);
                    }

                    // Render Total & List Menunggu
                    document.getElementById('badgeTotalMenunggu').textContent = `${data.total_menunggu} Antrian Menunggu`;

                    let htmlList = '';
                    if (data.list_menunggu && data.list_menunggu.length > 0) {
                        data.list_menunggu.forEach((item, index) => {
                            let jam = item.created_at ? new Date(item.created_at).toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            }) : '-';
                            htmlList += `
                            <div class="d-flex justify-content-between align-items-center p-3 mb-2 bg-light rounded-3 border-start border-4 border-primary">
                                <div>
                                    <span class="fw-bold fs-5 text-dark">#${index + 1} - ${item.nomor_antrian}</span>
                                    <div class="small text-muted">${jam}</div>
                                </div>
                                <span class="badge bg-secondary">Menunggu</span>
                            </div>
                        `;
                        });
                    } else {
                        htmlList = '<div class="text-center text-muted my-4">Tidak ada antrian menunggu.</div>';
                    }
                    document.getElementById('containerMenunggu').innerHTML = htmlList;
                } else if (!data.success) {
                    console.warn(data.message);
                }
            } catch (err) {
                console.error('Error fetching data:', err);
            }
        }

        // Action Panggil Antrian Selanjutnya
        async function panggilBerikutnya() {
            try {
                const selectedLoket = document.getElementById('selectLoket').value;
                const res = await fetch("{{ route('antrian.panggil') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        loket_id: selectedLoket
                    })
                });

                const data = await res.json();
                if (res.ok && data.success) {
                    Toast.fire({
                        icon: 'success',
                        title: `Memanggil antrian ${data.nomor_antrian || ''}`
                    });
                    initData();
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Informasi Antrian',
                        text: data.message || 'Tidak ada antrian tersisa.',
                        confirmButtonColor: '#0284c7'
                    });
                }
            } catch (err) {
                console.error('Error calling queue:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Sistem',
                    text: 'Gagal terhubung ke server pemanggilan.'
                });
            }
        }

        // Action Panggil Ulang
        async function panggilUlang() {
            if (!currentLogId) return;

            try {
                const res = await fetch("{{ route('antrian.panggil.ulang') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        log_id: currentLogId
                    })
                });

                if (res.ok) {
                    Toast.fire({
                        icon: 'info',
                        title: 'Panggil ulang berhasil dikirim ke TV Display'
                    });
                }
            } catch (err) {
                console.error('Error re-calling:', err);
            }
        }

        // Action Update Status (Selesai / Batal)
        async function updateStatus(status) {
            if (!currentLogId) return;

            const isBatal = status === 'batal';
            const confirmResult = await Swal.fire({
                title: isBatal ? 'Lewati / Batalkan Antrian?' : 'Selesaikan Antrian?',
                text: isBatal ? 'Nomor antrian ini akan dilewati.' : 'Antrian ini telah selesai dilayani.',
                icon: isBatal ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonColor: isBatal ? '#ef4444' : '#22c55e',
                cancelButtonColor: '#64748b',
                confirmButtonText: isBatal ? 'Ya, Batalkan!' : 'Ya, Selesai!',
                cancelButtonText: 'Kembali'
            });

            if (!confirmResult.isConfirmed) return;

            try {
                const res = await fetch("{{ route('antrian.update.status') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        log_id: currentLogId,
                        status: status
                    })
                });

                const data = await res.json();
                if (data.success) {
                    Toast.fire({
                        icon: 'success',
                        title: isBatal ? 'Antrian berhasil dibatalkan' : 'Antrian selesai dilayani'
                    });
                    initData();
                }
            } catch (err) {
                console.error('Error updating status:', err);
            }
        }

        // Control Kuncian Tombol
        function toggleButtons(hasActiveQueue) {
            document.getElementById('btnPanggilBerikutnya').disabled = hasActiveQueue;
            document.getElementById('btnPanggilUlang').disabled = !hasActiveQueue;
            document.getElementById('btnSelesai').disabled = !hasActiveQueue;
            document.getElementById('btnBatal').disabled = !hasActiveQueue;
        }

        // Real-time polling setiap 5 detik
        setInterval(initData, 5000);

        // Inisialisasi awal saat halaman dibuka
        initData();
    </script>
</body>

</html>
