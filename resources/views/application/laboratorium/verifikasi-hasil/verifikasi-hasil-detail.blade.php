<div class="modal-body p-0">
    <!-- Header Modal dengan Soft Gradient -->
    <div class="bg-gradient-primary text-white rounded-top-lg py-3 px-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #2c7be5 0%, #1a5bb8 100%);">
        <div class="d-flex align-items-center gap-2">
            <div class="avatar avatar-xl bg-white bg-opacity-10 rounded-circle p-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-microscope text-white fs-1"></i>
            </div>
            <div>
                <h4 class="mb-0 text-white fw-bold" id="staticBackdropLabel">Verifikasi Hasil Pasien Laboratorium</h4>
                <p class="fs--2 mb-0 opacity-75">Supported by Transforma Hospital System</p>
            </div>
        </div>
    </div>

    <div class="p-4 bg-light">
        <div class="row g-3" id="menu-verifikasi-hasil">

            <!-- Sidebar: Profil & Informasi Pasien -->
            <div class="col-lg-4">
                <div class="card h-100 shadow-sm border-0 overflow-hidden">
                    <!-- Card Header -->
                    <div class="card-header border-0 py-3 px-3 position-relative" style="background: linear-gradient(135deg, #1f2937 0%, #111827 100%);">
                        <div class="d-flex justify-content-between align-items-center position-relative z-index-1">
                            <div>
                                <span class="badge bg-primary bg-opacity-20 text-primary-light border border-primary border-opacity-20 rounded-pill px-2 py-1 fs--2">
                                    <i class="fas fa-hashtag me-1"></i>No. Registrasi
                                </span>
                                <h5 class="mb-0 text-white fw-extrabold mt-1 tracking-wide">{{ $reg }}</h5>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success bg-opacity-20 text-success-light border border-success border-opacity-25 rounded-pill px-2 py-1 fs--2">
                                    <i class="fas fa-check-circle me-1"></i>Terdaftar
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <!-- Profil Pasien Avatar & Nama -->
                        <div class="text-center position-relative mb-3 pt-2">
                            <div class="avatar avatar-5xl shadow-lg rounded-circle mx-auto mb-3 position-relative p-1 bg-white border border-2 border-primary">
                                <img src="{{ asset('img/pasien.png') }}" class="rounded-circle img-fluid w-100 h-100 object-fit-cover" alt="Foto Pasien">
                                <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-2 border-white rounded-circle" title="Pasien Aktif"></span>
                            </div>

                            <h5 class="mb-1 fw-bold text-900 fs-0">{{ $data->master_patient_name ?? '-' }}</h5>
                            <div class="d-flex align-items-center justify-content-center gap-1">
                                <span class="badge bg-soft-secondary text-secondary fw-bold fs--2">
                                    <i class="fas fa-id-badge me-1"></i>RM: {{ $data->master_patient_code ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="d-flex align-items-center my-3">
                            <div class="flex-grow-1 border-top border-200"></div>
                            <span class="mx-2 fs--2 text-400 fw-semi-bold text-uppercase">Informasi Personal</span>
                            <div class="flex-grow-1 border-top border-200"></div>
                        </div>

                        <!-- Info Grid Cards -->
                        <div class="row g-2 fs--1">
                            <!-- Tanggal Lahir -->
                            <div class="col-6">
                                <div class="p-2 rounded-2 bg-soft-warning border border-warning-subtle d-flex align-items-center h-100">
                                    <div class="icon-item icon-item-sm bg-warning text-white rounded-2 me-2 flex-shrink-0">
                                        <i class="fas fa-birthday-cake"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="fs--2 text-600 text-uppercase fw-semi-bold">Tgl Lahir</div>
                                        <div class="fw-bold text-800 fs--1">{{ !empty($data->master_patient_tgl_lahir) ? date('d/m/Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="col-6">
                                <div class="p-2 rounded-2 bg-soft-primary border border-primary-subtle d-flex align-items-center h-100">
                                    <div class="icon-item icon-item-sm bg-primary text-white rounded-2 me-2 flex-shrink-0">
                                        <i class="fas fa-venus-mars"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="fs--2 text-600 text-uppercase fw-semi-bold">Gender</div>
                                        <div class="fw-bold text-800 fs--1">
                                            @if(strtolower($data->master_patient_jk ?? '') == 'l' || strtolower($data->master_patient_jk ?? '') == 'laki-laki')
                                            Laki-laki
                                            @elseif(strtolower($data->master_patient_jk ?? '') == 'p' || strtolower($data->master_patient_jk ?? '') == 'perempuan')
                                            Perempuan
                                            @else
                                            {{ $data->master_patient_jk ?? '-' }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tempat Lahir -->
                            <div class="col-12">
                                <div class="p-2 rounded-2 bg-soft-danger border border-danger-subtle d-flex align-items-center">
                                    <div class="icon-item icon-item-sm bg-danger text-white rounded-2 me-2 flex-shrink-0">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="fs--2 text-600 text-uppercase fw-semi-bold">Tempat Lahir</div>
                                        <div class="fw-bold text-800 text-truncate">{{ $data->master_patient_tempat_lahir ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <button class="btn btn-danger btn-sm w-100 shadow-sm" id="button-verifikasi-preview-report"
                                    data-code="{{ $code }}" data-reg="{{ $reg }}">
                                    <i class="fas fa-file-pdf me-1"></i> Preview Report
                                </button>
                                <hr class="my-2">
                                <div id="view-map"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-100 p-2 border-top text-center">
                        <button class="btn btn-link btn-sm text-primary text-decoration-none fw-bold" type="button">
                            <i class="fas fa-notes-medical me-1"></i> Lihat Rekam Medis Lengkap <i class="fas fa-arrow-right ms-1 fs--2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content: Hasil Laboratorium -->
            <div class="col-lg-8">
                <div class="card h-100 shadow-sm border-0">
                    <!-- Header Hasil Laboratorium -->
                    <div class="card-header text-white py-3 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
                        <h6 class="mb-0 fw-bold text-white"><i class="fas fa-flask text-info me-2"></i>Rincian Hasil Laboratorium</h6>
                        <div class="d-flex align-items-center gap-2">
                            <span id="text-status-verifikasi" class="fs--2 fw-semi-bold text-danger me-2"></span>

                            <button class="btn btn-success btn-sm px-4 shadow-sm" id="button-verifikasi-hasil-lab"
                                data-code="{{ $code }}" data-reg="{{ $reg }}" disabled>
                                <i class="fas fa-exclamation-circle me-1" id="icon-button-verifikasi"></i>
                                <span id="label-button-verifikasi">Hasil Belum Lengkap</span>
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <!-- Tabel Hasil -->
                        <div class="table-responsive scrollbar">
                            <table class="table table-bordered align-middle fs--1 mb-0 border-200">
                                <thead class="bg-200 text-800 text-center">
                                    <tr>
                                        <th style="width: 25%;">Pemeriksaan</th>
                                        <th style="width: 18%;">Hasil</th>
                                        <th style="width: 10%;">Flag</th>
                                        <th style="width: 15%;">Nilai Rujukan</th>
                                        <th style="width: 17%;">Metode</th>
                                        <th style="width: 15%;">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pemeriksaan as $pem)
                                    <!-- Header Layanan Utama -->
                                    <tr class="bg-soft-primary border-top border-primary border-2">
                                        <td colspan="6" class="fw-bold text-primary ps-3 py-2">
                                            <i class="fas fa-vial text-primary me-2"></i>{{ strtoupper($pem->t_pemeriksaan_list_name) }}
                                        </td>
                                    </tr>

                                    @php
                                    // Ambil Parameter Utama (Tanpa Induk/Parent)
                                    $parameters = DB::table('medical_master_parameter')
                                    ->where('master_pemeriksaan_id', $pem->t_pemeriksaan_list_code)
                                    ->whereNull('parent_id')
                                    ->orderBy('urutan', 'ASC')
                                    ->get();
                                    @endphp

                                    @foreach ($parameters as $param)
                                    @if($param->is_group == 1)
                                    <!-- JIKA INI GRUP (Cth: Hitung Jenis) -->
                                    <tr class="bg-soft-warning border-start border-3 border-warning">
                                        <td colspan="6" class="fw-bold text-800 ps-3 py-2">
                                            <i class="fas fa-folder text-warning me-2 fs-0"></i>{{ $param->nama_parameter }}
                                        </td>
                                    </tr>

                                    @php
                                    $subParams = DB::table('medical_master_parameter')
                                    ->where('parent_id', $param->id)
                                    ->orderBy('urutan', 'ASC')
                                    ->get();
                                    @endphp

                                    @foreach($subParams as $sub)
                                    @php
                                    $nilai = DB::table('medical_transaksi_hasil')
                                    ->where('detail_id', $pem->detail_id)
                                    ->where('parameter_id', $sub->id)
                                    ->first();
                                    @endphp
                                    <!-- Anakan Parameter (Indentasi) -->
                                    <tr class="hover-actions-trigger">
                                        <td class="ps-4">
                                            <span class="text-400 me-2 fw-bold">↳</span>
                                            <span class="text-700 fw-medium">{{ $sub->nama_parameter }}</span>
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <!-- Disabled saat verifikasi, hanya re-check jika perlu -->
                                                <input type="text" class="form-control text-end bg-white fw-bold text-primary"
                                                    name="hasil[{{ $pem->detail_id }}][{{ $sub->id }}]"
                                                    value="{{ $nilai ? $nilai->hasil : '' }}" readonly>
                                                @if(!empty($sub->satuan))
                                                <span class="input-group-text bg-100 text-600 px-2 fs--2 fw-semi-bold">
                                                    {{ $sub->satuan }}
                                                </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center fw-bold text-danger">{{ $nilai ? $nilai->flag : '-' }}</td>
                                        <td class="text-center text-700 fs--2 fw-medium">{{ $sub->nilai_normal ?? '-' }}</td>
                                        <!-- PERBAIKAN DI SINI -->
                                        <td class="fs--2 text-center text-uppercase">{{ $sub->metode ?? '-' }}</td>
                                        <td><input type="text" class="form-control form-control-sm fs--2 bg-white" value="{{ $nilai ? $nilai->catatan : '' }}" readonly></td>
                                    </tr>
                                    @endforeach

                                    @else
                                    <!-- JIKA INI PARAMETER TUNGGAL (Cth: Hemoglobin) -->
                                    @php
                                    $nilai = DB::table('medical_transaksi_hasil')
                                    ->where('detail_id', $pem->detail_id)
                                    ->where('parameter_id', $param->id)
                                    ->first();
                                    @endphp
                                    <tr class="hover-actions-trigger">
                                        <td class="ps-3 fw-bold text-800">{{ $param->nama_parameter }}</td>
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control text-end bg-white fw-bold text-primary"
                                                    name="hasil[{{ $pem->detail_id }}][{{ $param->id }}]"
                                                    value="{{ $nilai ? $nilai->hasil : '' }}" readonly>
                                                @if(!empty($param->satuan))
                                                <span class="input-group-text bg-100 text-600 px-2 fs--2 fw-semi-bold">
                                                    {{ $param->satuan }}
                                                </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center fw-bold text-danger">{{ $nilai ? $nilai->flag : '-' }}</td>
                                        <td class="text-center text-700 fs--2 fw-medium">{{ $param->nilai_normal ?? '-' }}</td>
                                        <!-- PERBAIKAN DI SINI -->
                                        <td class="fs--2 text-center text-uppercase">{{ $param->metode ?? '-' }}</td>
                                        <td><input type="text" class="form-control form-control-sm fs--2 bg-white" value="{{ $nilai ? $nilai->catatan : '' }}" readonly></td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Footer Modal -->
                    <div class="card-footer bg-light py-3 border-top d-flex justify-content-between align-items-center">
                        <button class="btn btn-falcon-default btn-sm" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Tutup Form
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document.body).ready(function() {

        function checkFormCompleteness() {
            let totalInput = 0;
            let emptyCount = 0;

            $('input[name^="hasil["]').each(function() {
                totalInput++;
                if ($(this).val().trim() === '') {
                    emptyCount++;
                }
            });

            const $btn = $('#button-verifikasi-hasil-lab');
            const $label = $('#label-button-verifikasi');
            const $icon = $('#icon-button-verifikasi');
            const $statusText = $('#text-status-verifikasi');

            if (emptyCount > 0) {
                $btn.removeClass('btn-success').addClass('btn-danger').prop('disabled', true);
                $icon.attr('class', 'fas fa-exclamation-circle me-1');
                $label.text(`Belum Lengkap (${emptyCount} Kosong)`);
                $statusText.html(`<i class="fas fa-info-circle me-1"></i> Ada ${emptyCount} parameter belum diisi`);
            } else {
                $btn.removeClass('btn-danger').addClass('btn-success').prop('disabled', false);
                $icon.attr('class', 'fas fa-check-circle me-1');
                $label.text('Verifikasi Hasil Sekarang');
                $statusText.html('<span class="text-success"><i class="fas fa-check me-1"></i> Semua hasil siap diverifikasi</span>');
            }
        }

        checkFormCompleteness();

        // ====================================================================
        // TAMBAHKAN KODE INI UNTUK AKSI KLIK TOMBOL VERIFIKASI HASIL
        // ====================================================================
        $('#button-verifikasi-hasil-lab').off('click').on('click', function(e) {
            e.preventDefault();
            var code = $(this).data("code"); // registrasi_id
            var reg = $(this).data("reg"); // no_registrasi
            var $btn = $(this);

            Swal.fire({
                title: "Konfirmasi Verifikasi?",
                text: "Anda yakin akan memverifikasi hasil ini? Dokumen PDF terenkripsi (Password Tgl Lahir) akan dibuat otomatis.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#22c55e",
                cancelButtonColor: "#ef4444",
                confirmButtonText: "Ya, Verifikasi!",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan status loading pada tombol
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses PDF...');

                    $.ajax({
                        url: "{{ route('verifikasi_laboratorium_verifikasi_data') }}", // Pastikan nama route ini sudah benar di file web.php Anda
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "code": code,
                            "reg": reg,
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Terverifikasi!",
                                text: "Hasil laboratorium berhasil diverifikasi dan dokumen PDF telah tersimpan.",
                                icon: "success",
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                $('#modal-lab-full').modal('hide'); // Tutup Modal
                                location.reload(); // Reload halaman untuk mereset DataTable
                            });
                        },
                        error: function(xhr) {
                            Swal.fire("Gagal!", "Terjadi kesalahan saat memverifikasi atau membuat PDF.", "error");
                            $btn.prop('disabled', false).html('<i class="fas fa-check-circle me-1"></i> Verifikasi Hasil Sekarang');
                        }
                    });
                }
            });
        });

        // ====================================================================
        // TAMBAHKAN KODE INI UNTUK PREVIEW DOKUMEN (Opsional jika Anda pakai fitur ini)
        // ====================================================================
        $('#button-verifikasi-preview-report').off('click').on('click', function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            var reg = $(this).data("reg");

            $('#view-map').html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="text-muted fs--1 mt-2">Menyiapkan pratinjau dokumen...</p></div>');

            $.ajax({
                url: "{{ route('verifikasi_laboratorium_preview_report') }}", // Sesuaikan nama route preview Anda
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                    "reg": reg,
                },
                success: function(data) {
                    $('#view-map').html('<iframe src="data:application/pdf;base64, ' + data + '" style="width:100%; height:450px;" frameborder="0" class="rounded-3 shadow-sm border"></iframe>');
                },
                error: function() {
                    $('#view-map').html('<div class="alert alert-danger m-0 fs--1">Gagal memuat pratinjau laporan.</div>');
                }
            });
        });

    });
</script>
