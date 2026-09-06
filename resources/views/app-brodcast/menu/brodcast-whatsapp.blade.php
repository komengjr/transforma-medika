@extends('layouts.layouts')

@section('base.css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
<div class="row g-3">
    <!-- Form Send Broadcast WhatsApp -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-success text-white py-3">
                <h5 class="card-title text-white mb-0 fw-bold"><i class="fab fa-whatsapp me-2"></i>Broadcast Message WhatsApp</h5>
            </div>
            <div class="card-body p-4">
                <form id="form-broadcast-wa" enctype="multipart/form-data">
                    @csrf

                    <!-- Checkbox Pilih Semua Kontak -->
                    <div class="mb-3 p-3 bg-light rounded-3 border">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="select_all" value="1" id="switch-select-all">
                            <label class="form-check-label fw-bold text-dark" for="switch-select-all">
                                Kirim ke Semua Kontak (2000++ Kontak)
                            </label>
                        </div>
                        <small class="text-muted fs--2 d-block mt-1">Aktifkan untuk mengirim pesan sekaligus ke seluruh daftar kontak yang aktif.</small>
                    </div>

                    <!-- Dropdown Select2 Async Search -->
                    <div class="mb-3" id="wrapper-select-contact">
                        <label class="form-label fw-semibold text-secondary">Atau Cari & Pilih Kontak Spesifik</label>
                        <select name="contact_ids[]" id="contact_ids" class="form-select select2-ajax" multiple="multiple">
                        </select>
                    </div>

                    <!-- Subject / Judul Broadcast -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Subjek / Judul Pesan</label>
                        <input type="text" name="subject" class="form-control" placeholder="Masukkan subjek pesan..." required>
                    </div>

                    <!-- Pesan WhatsApp -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Pesan WhatsApp</label>
                        <textarea name="message" class="form-control" rows="4" placeholder="Tuliskan pesan WhatsApp di sini..." required></textarea>
                    </div>

                    <!-- Input Attach File -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary"><i class="fas fa-paperclip me-1"></i>Lampirkan File / Gambar (Opsional)</label>
                        <input type="file" name="attachment" class="form-control" id="attachment">
                        <small class="text-muted fs--2">Format: JPG, PNG, PDF, DOCX (Max: 10MB)</small>
                    </div>

                    <button type="button" id="btn-submit-broadcast" class="btn btn-success w-100 fw-bold py-2">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Broadcast WhatsApp
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Table History Pengiriman WhatsApp -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-dark text-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title text-white mb-0 fw-bold"><i class="fas fa-history me-2"></i>Riwayat Broadcast WhatsApp</h5>
                <button class="btn btn-sm btn-outline-light" id="btn-refresh-history"><i class="fas fa-sync-alt me-1"></i>Refresh Data</button>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle w-100 fs--1" id="table-wa-history">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Penerima</th>
                                <th>Subjek & Lampiran</th>
                                <th>Status</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // DataTables Server-Side Initialization
        let historyTable = $('#table-wa-history').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('menu_brodcast_whatsapp.history_ajax') }}",
            columns: [{
                    data: 'no',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'recipient'
                },
                {
                    data: 'subject'
                },
                {
                    data: 'status'
                },
                {
                    data: 'created_at'
                }
            ]
        });

        $('#btn-refresh-history').on('click', function() {
            historyTable.ajax.reload(null, false);
        });

        // Initialize Select2 Async Search
        $('.select2-ajax').select2({
            theme: 'bootstrap-5',
            placeholder: "Cari nama / nomor WA...",
            allowClear: true,
            ajax: {
                url: "{{ route('menu_brodcast_whatsapp.contacts_ajax') }}",
                dataType: 'json',
                delay: 300,
                data: function(params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.results
                    };
                },
                cache: true
            }
        });

        // Toggle Switch Pilih Semua Kontak
        $('#switch-select-all').on('change', function() {
            if ($(this).is(':checked')) {
                $('#wrapper-select-contact').addClass('d-none');
                $('#contact_ids').val(null).trigger('change');
            } else {
                $('#wrapper-select-contact').removeClass('d-none');
            }
        });

        // Submit Form via AJAX
        $('#btn-submit-broadcast').on('click', function(e) {
            e.preventDefault();

            let formElement = $('#form-broadcast-wa')[0];
            let isSelectAll = $('#switch-select-all').is(':checked');
            let selectedContacts = $('#contact_ids').val();

            // Validasi Sisi Klien
            if (!isSelectAll && (!selectedContacts || selectedContacts.length === 0)) {
                Swal.fire('Peringatan', 'Silahkan centang "Kirim ke Semua" atau pilih minimal satu kontak!', 'warning');
                return;
            }

            if (!$('input[name="subject"]').val().trim() || !$('textarea[name="message"]').val().trim()) {
                Swal.fire('Peringatan', 'Subjek dan Pesan WhatsApp wajib diisi!', 'warning');
                return;
            }

            let formData = new FormData(formElement);

            // Pastikan parameter select_all terkirim secara eksplisit sebagai boolean/string
            formData.set('select_all', isSelectAll ? '1' : '0');

            let btn = $(this);
            btn.html('<i class="fas fa-spinner fa-spin me-1"></i> Memproses...').prop('disabled', true);

            // Step 1: Submit Form & Dapatkan Batch ID
            $.ajax({
                url: "{{ route('menu_brodcast_whatsapp_send') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json"
            }).done(function(res) {
                if (res.status) {
                    let batchId = res.batch_id;
                    let totalCount = res.total || 0;

                    // Step 2: Tampilkan SweetAlert dengan Progress Bar
                    Swal.fire({
                        title: 'Mengirim Broadcast WhatsApp...',
                        html: `
                            <div class="mb-2 fw-semibold text-secondary" id="swal-progress-text">Menyiapkan antrean (0 / ${totalCount})...</div>
                            <div class="progress style-1 style-3" style="height: 20px;">
                                <div id="swal-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                     role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        `,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false
                    });

                    // Step 3: Polling Real-time
                    let timer = setInterval(function() {
                        $.ajax({
                            url: "{{ url('brodcast/menu-brodcast/brodcast-whatsapp/progress') }}/" + batchId,
                            type: "GET",
                            dataType: "json"
                        }).done(function(p) {
                            let percentage = parseInt(p.percentage || 0);
                            let processed = p.processed || 0;
                            let total = p.total || totalCount;

                            // Update tampilan persentase & text
                            $('#swal-progress-bar').css('width', percentage + '%').text(percentage + '%');
                            $('#swal-progress-text').text(`Terkirim ${processed} dari ${total} pesan WA...`);

                            // Jika pengiriman selesai atau kondisi terlampaui
                            if (percentage >= 100 || p.status === 'completed' || (total > 0 && processed >= total)) {
                                clearInterval(timer);
                                btn.html('<i class="fas fa-paper-plane me-1"></i> Kirim Broadcast WhatsApp').prop('disabled', false);

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pengiriman Selesai!',
                                    text: `Berhasil memproses total ${total} pesan WhatsApp.`,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    formElement.reset();
                                    $('#contact_ids').val(null).trigger('change');
                                    $('#switch-select-all').prop('checked', false).trigger('change');
                                    historyTable.ajax.reload();
                                });
                            }
                        }).fail(function() {
                            // Abaikan error jaringan sementara saat polling, tetap lanjutkan loop
                        });
                    }, 1000);
                } else {
                    btn.html('<i class="fas fa-paper-plane me-1"></i> Kirim Broadcast WhatsApp').prop('disabled', false);
                    Swal.fire('Gagal', res.message || 'Gagal memproses antrean WhatsApp.', 'error');
                }
            }).fail(function(xhr) {
                btn.html('<i class="fas fa-paper-plane me-1"></i> Kirim Broadcast WhatsApp').prop('disabled', false);
                let message = xhr.responseJSON?.message || 'Terjadi kesalahan sistem.';
                Swal.fire('Error', message, 'error');
            });
        });
    });
</script>
@endsection
