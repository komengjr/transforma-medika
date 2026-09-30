@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold mb-1"><i class="fas fa-stethoscope text-primary me-2"></i> Handling Proses Pemeriksaan Elektromedis</h3>
            <p class="text-muted">Pilih rentang tanggal dan jenis pemeriksaan terlebih dahulu untuk menampilkan data antrean.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Card Filter Option -->
    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-filter me-1"></i> Filter Data Pemeriksaan</h5>
        </div>
        <div class="card-body bg-light">
            <form action="{{ route('menu_elektromedis_handling', [$akses, $code]) }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Dari Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate ?? date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">Sampai Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate ?? date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Pilih Pemeriksaan <span class="text-danger">*</span></label>
                        <select name="examination_type" class="form-select" required>
                            <option value="">-- Pilih Jenis Pemeriksaan --</option>
                            <option value="ALL" {{ (isset($selectedExam) && $selectedExam == 'ALL') ? 'selected' : '' }}>-- Tampilkan Semua Jenis Pemeriksaan --</option>
                            @foreach($examinationTypes as $key => $label)
                            <option value="{{ $key }}" {{ (isset($selectedExam) && $selectedExam == $key) ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i> Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tampilkan Tabel Data Hanya Jika Filter Sudah Dijalankan -->
    @if(isset($registrations))
    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-secondary fw-bold">
                <i class="fas fa-list me-1"></i> Data Antrean Pemeriksaan
                @if($selectedExam)
                <span class="badge bg-info text-dark ms-2">Filter: {{ $selectedExam == 'ALL' ? 'Semua Pemeriksaan' : $selectedExam }}</span>
                @endif
            </h5>
        </div>
        <div class="card-body">
            @if($registrations->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="fas fa-info-circle fa-2x mb-2"></i>
                <p class="mb-0">Tidak ada data pendaftaran ditemukan pada rentang tanggal dan jenis pemeriksaan tersebut.</p>
            </div>
            @else
            <div class="table-responsive">
                <table id="tableHandling" class="table table-striped table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Reg</th>
                            <th>No. RM</th>
                            <th>Nama Pasien</th>
                            <th>Unit Asal</th>
                            <th>Pemeriksaan</th>
                            <th>Jadwal</th>
                            <th>Status</th>
                            <th>Aksi Handling</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span class="fw-bold text-primary">{{ $row->registration_number }}</span></td>
                            <td>{{ $row->medical_record_number }}</td>
                            <td>{{ $row->patient_name }}</td>
                            <td>{{ $row->origin_unit }}</td>
                            <td><span class="badge bg-info text-dark">{{ $row->examination_type }}</span></td>
                            <td>{{ date('d/m/Y H:i', strtotime($row->scheduled_at)) }}</td>
                            <td><span class="badge bg-warning text-dark">{{ $row->status }}</span></td>
                            <td>
                                @if($row->examination_type == 'ECG')
                                <!-- Tombol pemicu modal -->
                                <button type="button" class="btn btn-sm btn-primary btn-open-ecg-modal"
                                    data-reg-number="{{ $row->registration_number }}"
                                    data-patient-name="{{ $row->patient_name }}"
                                    data-rm="{{ $row->medical_record_number }}">
                                    <i class="fas fa-notes-medical me-1"></i> Form ECG
                                </button>
                                @else
                                <button type="button" class="btn btn-sm btn-secondary" disabled>
                                    <i class="fas fa-clock me-1"></i> Segera Hadir
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection

@section('base.js')
<!-- Modal Form Pemeriksaan ECG -->
<div class="modal fade" id="ecgModal" tabindex="-1" aria-labelledby="ecgModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="ecgModalLabel"><i class="fas fa-heartbeat text-danger me-2"></i> Form Pemeriksaan ECG</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Konten Form akan dimuat melalui AJAX atau ditaruh di sini -->
            <div class="modal-body" id="ecgModalBody">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="text-muted mt-2">Memuat data pasien...</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>

<script>
    $(document).ready(function() {
        if ($('#tableHandling').length) {
            // Cek apakah DataTables sudah pernah diinisialisasi sebelumnya untuk menghindari error re-init
            if ($.fn.DataTable.isDataTable('#tableHandling')) {
                $('#tableHandling').DataTable().destroy();
            }

            $('#tableHandling').DataTable({
                responsive: true,
                language: {
                    processing: "Sedang memproses...",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                    infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                    loadingRecords: "Sedang memuat...",
                    zeroRecords: "Tidak ditemukan data yang sesuai",
                    emptyTable: "Tidak ada data yang tersedia pada tabel ini",
                    paginate: {
                        first: "Pertama",
                        previous: "Sebelumnya",
                        next: "Selanjutnya",
                        last: "Terakhir"
                    },
                    aria: {
                        sortAscending: ": aktifkan untuk mengurutkan kolom ke atas",
                        sortDescending: ": aktifkan untuk mengurutkan kolom ke bawah"
                    }
                }
            });
        }
    });
</script>
<script>
    // 1. Event saat tombol buka modal diklik
    $(document).on('click', '.btn-open-ecg-modal', function() {
        var regNumber = $(this).data('reg-number'); // atau .data('id') jika menggunakan ID

        // Tampilkan modal terlebih dahulu
        $('#ecgModal').modal('show');

        // Tampilkan indikator loading di dalam modal body
        $('#ecgModalBody').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted mt-2">Memuat form pemeriksaan...</p>
            </div>
        `);

        // Ambil konten form menggunakan AJAX
        $.get('/elektromedis/ecg-form/' + regNumber, function(htmlContent) {
            // Masukkan konten HTML ke dalam body modal
            $('#ecgModalBody').html(htmlContent);
        }).fail(function() {
            $('#ecgModalBody').html('<div class="alert alert-danger m-3">Gagal memuat data pemeriksaan pasien.</div>');
        });
    });

    // 2. Event saat form di dalam modal disubmit (menggunakan AJAX)
    $(document).on('submit', '#formEcgModal', function(e) {
        e.preventDefault(); // Mencegah reload halaman standar

        var $form = $(this);
        var url = $form.attr('action');
        var formData = $form.serialize();
        var $submitBtn = $form.find('button[type="submit"]');
        var originalBtnText = $submitBtn.html();

        // Ubah tombol jadi loading / disabled
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                // Sembunyikan modal
                $('#ecgModal').modal('hide');

                // Tampilkan notifikasi sukses (bisa pakai SweetAlert2 jika ada, atau alert biasa)
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message || 'Data pemeriksaan ECG berhasil disimpan.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    alert('Data pemeriksaan ECG berhasil disimpan.');
                }

                // Opsional: Reload tabel data di background atau refresh halaman utama
                // location.reload();
            },
            error: function(xhr) {
                $submitBtn.prop('disabled', false).html(originalBtnText);

                if (xhr.status === 422) {
                    // Validasi error Laravel
                    let errors = xhr.responseJSON.errors;
                    let errorString = '';
                    $.each(errors, function(key, value) {
                        errorString += value[0] + '\n';
                    });
                    alert('Validasi Gagal:\n' + errorString);
                } else {
                    alert('Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
                }
            }
        });
    });
</script>
@endsection
