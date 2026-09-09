<style>
    /* Custom Utility Classes untuk Ukuran Font Lebih Kecil */
    .fs--1 {
        font-size: 0.875rem !important;
        /* ~14px */
    }

    .fs--2 {
        font-size: 0.75rem !important;
        /* ~12px */
    }

    .card-custom {
        border-radius: 16px;
        border: 2px solid transparent;
        box-shadow: 0 4px 20px rgba(5, 193, 235, 0.05);
    }

    /* Ukuran Angka Antrian Dibatasi ke Skala fs-2 */
    .active-number {
        font-size: 3.25rem;
        /* Setara / mendekati skala fs-2 terbesar */
        font-weight: 800;
        color: #0284c7;
        line-height: 1;
    }

    .btn-action {
        border-radius: 12px;
        padding: 8px 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<div class="modal-body bg-light p-4 rounded-3">
    <!-- Header Selection Bar (Bound By IP) -->
    <div class="card card-custom p-3 mb-3">
        @if(!$assignedCounter)
        <div class="alert alert-danger mb-0 d-flex align-items-center" role="alert">
            <i class="fa-solid fa-triangle-exclamation fs-3 me-3"></i>
            <div class="fs--1">
                <strong>Akses Dibatasi!</strong> Komputer dengan IP <code>{{ $clientIp }}</code> belum terdaftar dalam sistem <b>medical_loket_counters</b>. Silakan masukkan IP ini ke database terlebih dahulu.
            </div>
        </div>
        @else
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <label class="form-label fw-bold text-secondary mb-1 fs--1">
                    <i class="fa-solid fa-building-user me-1"></i> Filter Loket Pelayanan
                </label>
                <select class="form-select fw-bold border-primary fs--1" id="selectLoket" onchange="initDataAntrian()">
                    <option value="">-- Semua Loket Terikat --</option>
                    @foreach($loketList as $loket)
                    <option value="{{ $loket->id }}">{{ $loket->nama_loket }} ({{ $loket->kode_prefix }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold text-secondary mb-1 fs--1">
                    <i class="fa-solid fa-desktop me-1"></i> Counter / Meja (IP Terkunci)
                </label>
                <input type="text" class="form-control fw-bold bg-light text-primary fs--1" value="Counter {{ $assignedCounter->nomor_counter }} (IP: {{ $clientIp }})" readonly>
            </div>
            <div class="col-md-3 text-md-end pt-2">
                <span class="badge bg-primary fs--1 px-3 py-2 rounded-pill" id="badgeTotalMenunggu">0 Antrian Menunggu</span>
            </div>
        </div>
        @endif
    </div>

    @if($assignedCounter)
    <div class="row g-3">
        <!-- Boks Pemanggilan Antrian Aktif -->
        <div class="col-md-7">
            <div class="card card-custom p-4 text-center h-100 d-flex flex-column justify-content-between">
                <div>
                    <span class="text-uppercase fw-bold text-muted tracking-wide fs--1">Sedang Dilayani</span>
                    <!-- Font Ukuran Paling Besar (Maksimal fs-2) -->
                    <div class="active-number my-2 fs-2" id="textNomorAktif">---</div>
                    <div class="badge bg-info text-dark fs--1 px-3 py-2 mb-3 rounded-pill border border-info" id="textLoketAktif">
                        Siap Memanggil
                    </div>
                </div>

                <!-- Tombol Aksi Utama -->
                <div class="d-grid gap-2">
                    <!-- Baris Tombol Pemanggilan & Proses Registrasi -->
                    <div class="row g-2">
                        <div class="col-md-7">
                            <button class="btn btn-primary btn-action w-100 fs--1 shadow" id="btnPanggilBerikutnya" onclick="panggilBerikutnya()">
                                <i class="fa-solid fa-bullhorn me-1"></i> Panggil Berikutnya
                            </button>
                        </div>
                        <div class="col-md-5">
                            <button class="btn btn-info text-white btn-action w-100 fs--1 shadow" id="btnProsesRegistrasi" onclick="openFullModalRegistrasi()" disabled>
                                <i class="fa-solid fa-id-card me-1"></i> Proses Registrasi
                            </button>
                        </div>
                    </div>

                    <!-- Baris Tombol Kontrol (Panggil Ulang, Selesai, Batal) -->
                    <div class="row g-2">
                        <div class="col-4">
                            <button class="btn btn-warning btn-action w-100 text-white fs--2" id="btnPanggilUlang" onclick="panggilUlang()" disabled>
                                <i class="fa-solid fa-rotate-right me-1"></i> Panggil Ulang
                            </button>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-success btn-action w-100 fs--2" id="btnSelesai" onclick="updateStatus('selesai')" disabled>
                                <i class="fa-solid fa-check me-1"></i> Selesai
                            </button>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-outline-danger btn-action w-100 fs--2" id="btnBatal" onclick="updateStatus('batal')" disabled>
                                <i class="fa-solid fa-xmark me-1"></i> Lewati / Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Sisa Antrian Menunggu -->
        <div class="col-md-5">
            <div class="card card-custom p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <h5 class="fw-bold mb-0 text-slate-700 fs-2">
                        <i class="fa-solid fa-list-ol me-2 text-primary"></i>Daftar Menunggu
                    </h5>
                    <button class="btn btn-sm btn-light rounded-circle" onclick="initDataAntrian()">
                        <i class="fa-solid fa-arrows-rotate fs--2"></i>
                    </button>
                </div>

                <div class="overflow-auto" style="max-height: 350px;" id="containerMenunggu">
                    <!-- Dynamic List via Javascript -->
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal Fullscreen untuk Form Registrasi Pasien -->
<div class="modal fade" id="modalFullRegistrasi" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white py-2 px-3">
                <h5 class="modal-title fw-bold text-white fs-5">
                    <i class="fa-solid fa-user-plus me-2"></i> Form Registrasi Pasien - Antrian <span id="labelNomorAntrianReg" class="badge bg-warning text-dark fs--1">---</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" id="contentModalFullRegistrasi">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript Logic -->
<script>
    (() => {
        let currentLogId = null;
        let activeNomorAntrian = null;
        const csrfToken = "{{ csrf_token() }}";

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        async function initDataAntrian() {
            try {
                const selectLoketEl = document.getElementById('selectLoket');
                const selectedLoket = selectLoketEl ? selectLoketEl.value : '';
                const res = await fetch(`{{ route('antrian.petugas.data') }}?loket_id=${selectedLoket}`);
                const data = await res.json();

                if (res.ok && data.success) {
                    if (data.sedang_dilayani) {
                        currentLogId = data.sedang_dilayani.id;
                        activeNomorAntrian = data.sedang_dilayani.nomor_antrian;

                        document.getElementById('textNomorAktif').textContent = data.sedang_dilayani.nomor_antrian;
                        document.getElementById('textLoketAktif').textContent = `Melayani di Counter ${data.counter.nomor_counter}`;
                        toggleButtons(true);
                    } else {
                        currentLogId = null;
                        activeNomorAntrian = null;

                        document.getElementById('textNomorAktif').textContent = "---";
                        document.getElementById('textLoketAktif').textContent = "Siap Memanggil";
                        toggleButtons(false);
                    }

                    document.getElementById('badgeTotalMenunggu').textContent = `${data.total_menunggu} Antrian Menunggu`;

                    let htmlList = '';
                    if (data.list_menunggu && data.list_menunggu.length > 0) {
                        data.list_menunggu.forEach((item, index) => {
                            let jam = item.created_at ? new Date(item.created_at).toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            }) : '-';
                            htmlList += `
                        <div class="d-flex justify-content-between align-items-center p-2 mb-2 bg-light rounded-3 border-start border-4 border-primary">
                            <div>
                                <span class="fw-bold fs--1 text-dark">#${index + 1} - ${item.nomor_antrian}</span>
                                <div class="fs--2 text-muted">${jam}</div>
                            </div>
                            <span class="badge bg-secondary fs--2">Menunggu</span>
                        </div>`;
                        });
                    } else {
                        htmlList = '<div class="text-center text-muted fs--1 my-4">Tidak ada antrian menunggu.</div>';
                    }
                    document.getElementById('containerMenunggu').innerHTML = htmlList;
                }
            } catch (err) {
                console.error('Error fetching data:', err);
            }
        }

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
                    initDataAntrian();
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Informasi Antrian',
                        text: data.message || 'Tidak ada antrian tersisa.',
                        confirmButtonColor: '#0284c7'
                    });
                }
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Sistem',
                    text: 'Gagal terhubung ke server.'
                });
            }
        }

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
                        title: 'Panggil ulang berhasil dikirim'
                    });
                }
            } catch (err) {
                console.error('Error re-calling:', err);
            }
        }

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
                        title: isBatal ? 'Antrian dibatalkan' : 'Antrian selesai dilayani'
                    });
                    initDataAntrian();
                }
            } catch (err) {
                console.error('Error updating status:', err);
            }
        }

        function openFullModalRegistrasi() {
            if (!activeNomorAntrian) return;

            document.getElementById('labelNomorAntrianReg').textContent = activeNomorAntrian;

            const modalEl = document.getElementById('modalFullRegistrasi');
            const modalInstance = new bootstrap.Modal(modalEl);
            modalInstance.show();

            $('#contentModalFullRegistrasi').html(
                '<div class="d-flex justify-content-center align-items-center h-100"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );

            // Menggunakan Route Laravel yang Anda miliki
            $.ajax({
                url: "{{ route('registrasi_pasien_poses_registrasi_pasien') }}",
                type: "GET",
                data: {
                    nomor_antrian: activeNomorAntrian,
                    log_id: currentLogId
                },
                success: function(response) {
                    $('#contentModalFullRegistrasi').html(response);
                },
                error: function() {
                    $('#contentModalFullRegistrasi').html('<div class="alert alert-danger m-4 fs--1">Gagal memuat form registrasi.</div>');
                }
            });
        }

        function toggleButtons(hasActiveQueue) {
            document.getElementById('btnPanggilBerikutnya').disabled = hasActiveQueue;
            document.getElementById('btnProsesRegistrasi').disabled = !hasActiveQueue;
            document.getElementById('btnPanggilUlang').disabled = !hasActiveQueue;
            document.getElementById('btnSelesai').disabled = !hasActiveQueue;
            document.getElementById('btnBatal').disabled = !hasActiveQueue;
        }

        window.initDataAntrian = initDataAntrian;
        window.panggilBerikutnya = panggilBerikutnya;
        window.panggilUlang = panggilUlang;
        window.updateStatus = updateStatus;
        window.openFullModalRegistrasi = openFullModalRegistrasi;

        initDataAntrian();
        if (window.antrianInterval) clearInterval(window.antrianInterval);
        window.antrianInterval = setInterval(initDataAntrian, 5000);
    })();
</script>
