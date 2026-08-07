<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4">
        <h5 class="fw-bold text-primary mb-3"><i class="fas fa-clock me-2"></i>Informasi Jadwal & Kuota</h5>

        <div class="row align-items-center mb-4">
            <div class="col-md-4 mb-2 mb-md-0">
                <span class="text-secondary small d-block">Jam Praktik:</span>
                <span class="fw-bold fs-2 text-dark">
                    {{ substr($schedule->time_start, 0, 5) }} - {{ substr($schedule->time_end, 0, 5) }} WIB
                </span>
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
                <span class="text-secondary small d-block">Kapasitas Kuota:</span>
                <span class="badge bg-secondary fs-6">{{ $schedule->quota }} Pasien</span>
            </div>
            <div class="col-md-4">
                <span class="text-secondary small d-block">Sisa Kuota:</span>
                @if($sisaKuota > 0)
                <span class="badge bg-success fs-2">{{ $sisaKuota }} Kuota Tersedia</span>
                @else
                <span class="badge bg-danger fs-2">Kuota Penuh</span>
                @endif
            </div>
        </div>

        <hr class="my-3 text-secondary opacity-25">

        <!-- Area Tombol Simpan Registrasi -->
        <div class="d-flex justify-content-end">
            @if($sisaKuota > 0)
            <button type="button" id="btnSimpanRegistrasi" class="btn btn-success btn-lg px-4 fw-semibold" onclick="simpanRegistrasiPoli()">
                <i class="fas fa-save me-2"></i> Simpan & Cetak Registrasi
            </button>
            @else
            <button type="button" class="btn btn-secondary btn-lg px-4 fw-semibold" disabled>
                <i class="fas fa-ban me-2"></i> Kuota Sudah Penuh
            </button>
            @endif
        </div>

        <input type="hidden" id="payment_method" value="UMUM">
    </div>
</div>

<!-- MODAL TIKET STRUK (BG-WHITE UNTUK MENCEGAH TRANSPARAN) -->
<div class="modal fade" id="modalTiket" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content text-center border-0 shadow-lg rounded-4 overflow-hidden bg-white" style="background-color: #ffffff !important;">
            <div class="bg-primary text-white p-3 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <i class="fas fa-check-circle fa-3x"></i>
                <h6 class="fw-bold mb-0 mt-2">RSUD HOSPITAL</h6>
                <small class="opacity-75">Bukti Pendaftaran Poliklinik</small>
            </div>
            <div class="modal-body p-4 bg-white" id="printableTicket">
                <span class="text-body-secondary extra-small fw-semibold text-uppercase tracking-wider d-block">Nomor Antrean Anda</span>
                <div class="queue-number my-2 fs-1 fw-bold text-primary" id="ticket_queue_no">A-000</div>

                <h6 class="fw-bold mb-0" id="ticket_poli_name">Poli Umum</h6>
                <p class="small text-body-secondary mb-3" id="ticket_doctor_name">dr. John Doe</p>

                <div class="bg-light p-3 rounded-3 text-start small mb-3 border">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-body-secondary">Kode Pasien:</span>
                        <span class="fw-bold" id="ticket_patient_code">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-body-secondary">Pasien:</span>
                        <span class="fw-semibold" id="ticket_patient_name">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-body-secondary">Penjamin:</span>
                        <span class="fw-semibold" id="ticket_payment">-</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-body-secondary">Tanggal:</span>
                        <span class="fw-semibold" id="ticket_date">-</span>
                    </div>
                </div>

                <p class="text-body-secondary extra-small mb-0"><i class="fas fa-info-circle me-1"></i>Harap datang 15 menit sebelum jam praktek dimulai.</p>
            </div>
            <div class="modal-footer border-0 p-3 bg-light">
                <button type="button" id="btnCetakTiket" class="btn btn-primary w-100 fw-semibold" onclick="cetakStrukViaAjax()">
                    <i class="fas fa-print me-1"></i> Cetak Struk
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Set Schedule ID ke hidden input di form utama
    $('#id_schedule').val("{{ $schedule->id_schedule }}");

    // Fungsi AJAX untuk Simpan Registrasi
    function simpanRegistrasiPoli() {
        var btn = $('#btnSimpanRegistrasi');

        // Ambil data pendukung dari form utama
        var patientId = $('#patient_id').val() || $('#id_pasien').val();
        var poliCode = $('#poli').val();
        var poliName = $('#poli option:selected').text();
        var doctorName = $('#doctor option:selected').text();
        var scheduleId = $('#id_schedule').val();
        var visitDate = $('#tanggal_periksa').val();
        var paymentMethod = $('#payment_method').val() || 'UMUM';
        var insuranceNo = $('#insurance_no').val() || '';
        var patientCode = $('#patient_code').val();
        var patientName = $('#patient_name').val() || $('#nama_pasien').val() || '-';

        // Validasi Pasien
        if (!patientId) {
            alert('Data Pasien tidak ditemukan. Silakan pilih pasien terlebih dahulu.');
            return;
        }

        // Validasi Form
        if (!poliCode || !scheduleId || !visitDate) {
            alert('Lengkapi data pendaftaran terlebih dahulu.');
            return;
        }

        // State Loading Tombol
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Memproses...');

        $.ajax({
            url: "{{ route('registrasi_pasien_pilih_data_pasien_storeRegistration') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "patient_id": patientId,
                "patientCode": patientCode,
                "m_poli_code": poliCode,
                "schedule_id": scheduleId,
                "visit_date": visitDate,
                "payment_method": paymentMethod,
                "insurance_no": insuranceNo
            },
            dataType: 'json',
            success: function(response) {
                // Pengecekan status (bisa berupa true atau "success")
                if (response.status === true || response.status === 'success') {

                    // SAFE CHECKING: Mengambil nomor antrean dari berbagai kemungkinan atribut response
                    var queueNo = response.queue ||
                        response.queue_number ||
                        (response.data && response.data.queue) ||
                        (response.data && response.data.queue_number) ||
                        '-';

                    // Populate data ke elemen Modal Tiket Struk
                    $('#ticket_queue_no').text(queueNo);
                    $('#ticket_poli_name').text(poliName);
                    $('#ticket_doctor_name').text(doctorName);
                    $('#ticket_patient_code').text(patientCode);
                    $('#ticket_patient_name').text(patientName);
                    $('#ticket_payment').text(paymentMethod);
                    $('#ticket_date').text(visitDate);

                    // Tampilkan Modal Tiket Struk
                    var modalEl = document.getElementById('modalTiket');
                    var modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modalInstance.show();
                } else {
                    alert(response.message || 'Gagal menyimpan pendaftaran.');
                }
            },
            error: function(xhr) {
                var errMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan sistem.';
                alert('Gagal: ' + errMessage);
            },
            complete: function() {
                btn.prop('disabled', false).html('<i class="fas fa-save me-2"></i> Simpan & Cetak Registrasi');
            }
        });
    }

    // Fungsi AJAX untuk Pencetakan Struk
    function cetakStrukViaAjax() {
        var btnCetak = $('#btnCetakTiket');

        var dataTiket = {
            queue_no: $('#ticket_queue_no').text().trim(),
            poli_name: $('#ticket_poli_name').text().trim(),
            doctor_name: $('#ticket_doctor_name').text().trim(),
            patient_code: $('#ticket_patient_code').text().trim(),
            patient_name: $('#ticket_patient_name').text().trim(),
            payment: $('#ticket_payment').text().trim(),
            date: $('#ticket_date').text().trim()
        };

        btnCetak.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Mencetak...');

        $.ajax({
            url: "{{ route('registrasi_pasien_pilih_data_pasien_print_ticket') }}",
            type: 'POST',
            data: JSON.stringify(dataTiket),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                alert('Struk berhasil dikirim ke printer!');

                var modalEl = document.getElementById('modalTiket');
                var modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) {
                    modalInstance.hide();
                }
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Gagal mencetak struk: ' + (xhr.responseJSON?.message || error));
            },
            complete: function() {
                btnCetak.prop('disabled', false).html('<i class="fas fa-print me-1"></i> Cetak Struk');
            }
        });
    }
</script>
