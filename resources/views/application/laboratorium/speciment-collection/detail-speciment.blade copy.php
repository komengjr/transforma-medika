<div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden">
    <!-- CARD HEADER -->
    <div class="card-header bg-light py-2 px-3 border-bottom d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="fas fa-user-check text-primary fs-0"></i>
            <h6 class="mb-0 fw-bold text-dark fs-0">
                Pasien Details No Reg: <span class="text-primary">{{ $code }}</span>
            </h6>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm btn-success rounded-2 px-3 fw-semibold fs--1 d-flex align-items-center gap-1" id="button-simpan-proses-specimen-collection" data-code="{{ $code }}">
                <i class="fas fa-check-circle"></i> Simpan
            </button>
        </div>
    </div>

    <!-- CARD BODY -->
    <div class="card-body p-3 p-md-4" id="menu-proses-specimen-collection">
        <div class="row g-3 align-items-start">

            <!-- AVATAR / PROFILE PHOTO & BADGE CODE -->
            <div class="col-auto text-center pe-md-3">
                <div class="avatar rounded-circle shadow-sm border border-2 border-white overflow-hidden bg-light mx-auto mb-2" style="width: 100px; height: 100px;">
                    @if (empty($data->master_patient_profile))
                    <img src="{{ asset('img/pasien.png') }}" class="w-100 h-100 object-fit-cover" alt="Foto Pasien" id="videoPreview">
                    @else
                    <img src="{{ Storage::url($data->master_patient_profile) }}" class="w-100 h-100 object-fit-cover" alt="Foto Pasien" id="videoPreview">
                    @endif
                </div>
                <br>
                <span class="badge bg-primary bg-opacity-10 text-white rounded-pill px-3 py-1 fs--2 fw-bold">
                    {{ $data->master_patient_code ?? '-' }}
                </span>
            </div>

            <!-- PATIENT DETAILS (CLEAN LAYOUT) -->
            <div class="col">
                <!-- NAMA & NIK -->
                <div class="mb-3">
                    <h3 class="fw-bold text-dark mb-1 fs-2">{{ $data->master_patient_name ?? '-' }}</h3>
                    <div class="text-secondary fs--1 d-flex align-items-center gap-1">
                        <i class="fas fa-id-card"></i>
                        <span>NIK:</span>
                        <strong class="text-dark">{{ $data->master_patient_nik ?? '-' }}</strong>
                    </div>
                </div>

                <hr class="border-200 my-2">

                <!-- GRID INFORMASI TAMBAHAN -->
                <div class="row g-3 pt-1">
                    <!-- NO REKAM MEDIS -->
                    <div class="col-md-4 col-sm-6">
                        <div class="text-muted fs--2 mb-1">No. Rekam Medis</div>
                        <div class="fw-bold text-primary fs-0 d-flex align-items-center gap-1">
                            <i class="fas fa-hashtag fs--1"></i>
                            <span>{{ $data->master_patient_code ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- JENIS KELAMIN -->
                    <div class="col-md-4 col-sm-6">
                        <div class="text-muted fs--2 mb-1">Jenis Kelamin</div>
                        <div class="fw-bold text-dark fs-0 d-flex align-items-center gap-1">
                            @if(strtolower($data->master_patient_jk ?? '') == 'laki-laki' || strtolower($data->master_patient_jk ?? '') == 'l')
                            <i class="fas fa-mars text-info"></i> Laki-laki
                            @elseif(strtolower($data->master_patient_jk ?? '') == 'perempuan' || strtolower($data->master_patient_jk ?? '') == 'p')
                            <i class="fas fa-venus text-danger"></i> Perempuan
                            @else
                            <i class="fas fa-genderless"></i> {{ $data->master_patient_jk ?? '-' }}
                            @endif
                        </div>
                    </div>

                    <!-- TANGGAL LAHIR -->
                    <div class="col-md-4 col-sm-6">
                        <div class="text-muted fs--2 mb-1">Tanggal Lahir</div>
                        <div class="fw-bold text-dark fs-0 d-flex align-items-center gap-1">
                            <i class="far fa-calendar-alt text-warning"></i>
                            <span>{{ $data->master_patient_tgl_lahir ? date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}</span>
                        </div>
                    </div>

                    <!-- TEMPAT LAHIR -->
                    <div class="col-md-4 col-sm-6">
                        <div class="text-muted fs--2 mb-1">Tempat Lahir</div>
                        <div class="fw-bold text-dark fs-0 d-flex align-items-center gap-1">
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            <span>{{ $data->master_patient_tempat_lahir ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- TABLE: SPECIMEN LIST -->
        <div class="mt-4">
            <h6 class="fw-bold text-800 mb-2 fs--1 text-uppercase tracking-wider">
                <i class="fas fa-vials text-primary me-1"></i> Daftar Pemeriksaan & Spesimen
            </h6>

            <div class="table-responsive rounded-3 border">
                <table class="table table-hover align-middle mb-0 fs--1">
                    <thead class="bg-200 text-800">
                        <tr>
                            <th class="py-2 px-3 fw-bold">Jenis Pemeriksaan / Sampel</th>
                            <th class="py-2 px-3 fw-bold text-end">Aksi Spesimen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($pemeriksaan as $pem)
                        <tr>
                            <td class="py-3 px-3">
                                <div class="fw-bold text-dark mb-0">{{ $pem->t_pemeriksaan_list_name }}</div>
                                <span class="fs--2 text-muted">Kode List: {{ $pem->t_pemeriksaan_list_code }}</span>
                                @php
                                $specimen = DB::table('t_pem_specimen')
                                ->join('s_specimen_data', 's_specimen_data.s_specimen_data_code', '=', 't_pem_specimen.s_specimen_data_code')
                                ->where('t_pemeriksaan_list_code', $pem->t_pemeriksaan_list_code)
                                ->get();
                                @endphp
                            </td>
                            <td class="py-3 px-3 text-end">
                                @foreach ($specimen as $spec)
                                @php
                                $log = DB::table('s_specimen_log')
                                ->where('t_pem_specimen_code', $spec->t_pem_specimen_code)
                                ->where('order_lab_list_code', $pem->order_lab_list_code)
                                ->first();
                                @endphp

                                <div id="menudata{{ $pem->id_t_pemeriksaan_list }}{{ $spec->id_s_specimen_data }}" class="d-inline-flex align-items-center gap-1 m-1">

                                    <!-- TOMBOL AKSI SPESIMEN -->
                                    @if ($log)
                                    @if ($log->s_specimen_log_status == 0)
                                    <!-- STATUS BELUM SELESAI / DALAM PROSES -->
                                    <!-- STATUS DALAM PROSES (1 BUTTON UTAMA + NAMA SPESIMEN DI BAWAH) -->
                                    <div class="d-inline-flex flex-column align-items-center">
                                        <button class="btn btn-warning btn-sm shadow-sm px-3 py-1 d-flex align-items-center justify-content-center gap-1"
                                            id="button-simpan-specimen{{ $pem->id_t_pemeriksaan_list }}{{ $spec->t_pem_specimen_code }}"
                                            data-code="{{ $pem->id_t_pemeriksaan_list }}"
                                            data-specimen="{{ $spec->t_pem_specimen_code }}"
                                            data-reg="{{ $pem->order_lab_list_code }}"
                                            title="Klik untuk Menyelesaikan Proses Spesimen">
                                            <i class="fas fa-clock me-1"></i> Proses ({{ $log->s_specimen_log_time }})
                                        </button>
                                        <small class="text-muted fw-semibold mt-1 fs--2">
                                            {{ $spec->s_specimen_data_name }}
                                        </small>
                                    </div>
                                    @else
                                    <!-- STATUS SELESAI -->
                                    <!-- STATUS SELESAI & PRINT BARCODE (1 BUTTON TUNGGAL) -->
                                    <div class="d-inline-flex flex-column align-items-center">
                                        <button class="btn btn-success btn-sm shadow-sm px-3 py-1 d-flex align-items-center justify-content-center gap-1"
                                            id="button-print-barcode{{ $pem->id_t_pemeriksaan_list }}{{ $spec->id_s_specimen_data }}"
                                            data-code="{{ $pem->id_t_pemeriksaan_list }}"
                                            data-specimen="{{ $spec->t_pem_specimen_code }}"
                                            data-reg="{{ $pem->order_lab_list_code }}"
                                            title="Klik untuk Cetak Barcode Sampel">
                                            <i class="fas fa-barcode"></i> Print Barcode
                                        </button>
                                        <small class="text-muted fw-semibold mt-1 fs--2">
                                            {{ $spec->s_specimen_data_name }}
                                        </small>
                                    </div>
                                    @endif
                                    @else
                                    <!-- BELUM DIPROSES -->
                                    <!-- STATUS BELUM DIPROSES (1 BUTTON UTAMA + NAMA SPESIMEN DI BAWAH) -->
                                    <div class="d-inline-flex flex-column align-items-center">
                                        <button class="btn btn-outline-danger btn-sm shadow-sm px-3 py-1 d-flex align-items-center justify-content-center gap-1"
                                            id="button-collection-specimen{{ $pem->id_t_pemeriksaan_list }}{{ $spec->id_s_specimen_data }}"
                                            data-code="{{ $pem->id_t_pemeriksaan_list }}"
                                            data-specimen="{{ $spec->t_pem_specimen_code }}"
                                            data-reg="{{ $pem->order_lab_list_code }}"
                                            title="Klik untuk Mulai Ambil/Proses Spesimen">
                                            <i class="fas fa-vial me-1"></i> Mulai Proses
                                        </button>
                                        <small class="text-muted fw-semibold mt-1 fs--2">
                                            {{ $spec->s_specimen_data_name }}
                                        </small>
                                    </div>
                                    @endif
                                </div>

                                <script>
                                    // PRINT BARCODE SAMPLE HANDLER
                                    $(document).off("click", "#button-print-barcode{{ $pem->id_t_pemeriksaan_list }}{{ $spec->id_s_specimen_data }}").on("click", "#button-print-barcode{{ $pem->id_t_pemeriksaan_list }}{{ $spec->id_s_specimen_data }}", function(e) {
                                        e.preventDefault();
                                        var code = $(this).data("code");
                                        var specimen = $(this).data("specimen");
                                        var reg = $(this).data("reg");

                                        // 1. Tampilkan Swal Loading saat mengambil preview
                                        Swal.fire({
                                            title: 'Memuat Preview Barcode...',
                                            text: 'Mohon tunggu sebentar',
                                            allowOutsideClick: false,
                                            didOpen: () => {
                                                Swal.showLoading();
                                            }
                                        });

                                        // Ambil data preview barcode dari backend
                                        $.ajax({
                                            url: "{{ route('data_specimen_collection_lab_print_barcode') }}",
                                            type: 'GET',
                                            data: {
                                                code: code,
                                                specimen: specimen,
                                                reg: reg
                                            },
                                            dataType: 'html',
                                            success: function(response) {
                                                // 2. Tampilkan Modal Swal dengan Preview & Tombol Cetak
                                                Swal.fire({
                                                    title: '<strong>Preview Barcode Sampel</strong>',
                                                    html: '<div class="p-2 border rounded bg-light overflow-auto" style="max-height: 400px;">' + response + '</div>',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#0d6efd',
                                                    cancelButtonColor: '#6c757d',
                                                    confirmButtonText: '<i class="fas fa-print me-1"></i> Cetak Now',
                                                    cancelButtonText: 'Tutup',
                                                    focusConfirm: false,
                                                    showLoaderOnConfirm: true, // Mengaktifkan loading bawaan Swal pada tombol confirm
                                                    preConfirm: () => {
                                                        // 3. Kirim Perintah Cetak ke Backend saat "Cetak Now" diklik
                                                        return $.ajax({
                                                            url: "{{ route('data_specimen_collection_lab_print_barcode_proses') }}",
                                                            type: 'POST',
                                                            data: {
                                                                _token: "{{ csrf_token() }}",
                                                                code: code,
                                                                specimen: specimen,
                                                                reg: reg
                                                            },
                                                            dataType: 'json'
                                                        }).then(function(res) {
                                                            if (!res.success) {
                                                                throw new Error(res.message || 'Gagal mencetak barcode.');
                                                            }
                                                            return res;
                                                        }).catch(function(error) {
                                                            Swal.showValidationMessage(`Proses Cetak Gagal: ${error.message}`);
                                                        });
                                                    },
                                                    allowOutsideClick: () => !Swal.isLoading()
                                                }).then((result) => {
                                                    // 4. Tampilkan Respon Sukses dari Backend
                                                    if (result.isConfirmed && result.value) {
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Berhasil!',
                                                            text: result.value.message || 'Perintah cetak telah dikirim ke printer.',
                                                            timer: 2000,
                                                            showConfirmButton: false
                                                        });
                                                    }
                                                });
                                            },
                                            error: function() {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Gagal Memuat Barcode',
                                                    text: 'Terjadi kesalahan saat mengambil data preview.',
                                                    confirmButtonColor: '#ef4444'
                                                });
                                            }
                                        });
                                    });

                                    // PROSES COLLECTION HANDLER
                                    $(document).on("click", "#button-collection-specimen{{ $pem->id_t_pemeriksaan_list }}{{ $spec->id_s_specimen_data }}", function(e) {
                                        e.preventDefault();
                                        var code = $(this).data("code");
                                        var specimen = $(this).data("specimen");
                                        var reg = $(this).data("reg");

                                        Swal.fire({
                                            title: "Proses Spesimen?",
                                            text: "Apakah Anda yakin ingin memproses pengambilan spesimen ini?",
                                            icon: "question",
                                            showCancelButton: true,
                                            confirmButtonColor: "#22c55e",
                                            cancelButtonColor: "#ef4444",
                                            confirmButtonText: "Ya, Proses!",
                                            cancelButtonText: "Batal",
                                            reverseButtons: true
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $.ajax({
                                                    url: "{{ route('data_specimen_collection_lab_proses') }}",
                                                    type: "POST",
                                                    cache: false,
                                                    data: {
                                                        "_token": "{{ csrf_token() }}",
                                                        "code": code,
                                                        "specimen": specimen,
                                                        "reg": reg,
                                                    },
                                                    dataType: 'html',
                                                }).done(function(data) {
                                                    $('#menudata{{ $pem->id_t_pemeriksaan_list }}{{ $spec->id_s_specimen_data }}').html(data);
                                                    Toast.fire({
                                                        icon: "success",
                                                        title: "Spesimen Berhasil Diproses"
                                                    });
                                                }).fail(function() {
                                                    Swal.fire({
                                                        title: "Gagal!",
                                                        text: "Proses spesimen gagal dilakukan.",
                                                        icon: "error"
                                                    });
                                                });
                                            }
                                        });
                                    });

                                    // SIMPAN SPECIMEN HANDLER
                                    $(document).on("click", "#button-simpan-specimen{{ $pem->id_t_pemeriksaan_list }}{{ $spec->t_pem_specimen_code }}", function(e) {
                                        e.preventDefault();
                                        var code = $(this).data("code");
                                        var specimen = $(this).data("specimen");
                                        var reg = $(this).data("reg");

                                        Swal.fire({
                                            title: "Konfirmasi Simpan",
                                            text: "Apakah Anda yakin ingin menyimpan status spesimen ini?",
                                            icon: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#22c55e",
                                            cancelButtonColor: "#ef4444",
                                            confirmButtonText: "Ya, Simpan!",
                                            cancelButtonText: "Batal",
                                            reverseButtons: true
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $.ajax({
                                                    url: "{{ route('data_specimen_collection_lab_proses_simpan') }}",
                                                    type: "POST",
                                                    cache: false,
                                                    data: {
                                                        "_token": "{{ csrf_token() }}",
                                                        "code": code,
                                                        "specimen": specimen,
                                                        "reg": reg,
                                                    },
                                                    dataType: 'html',
                                                }).done(function(data) {
                                                    Swal.fire({
                                                        title: "Berhasil!",
                                                        text: "Data spesimen telah disimpan.",
                                                        icon: "success",
                                                        timer: 1500,
                                                        showConfirmButton: false
                                                    });
                                                    $('#menudata{{ $pem->id_t_pemeriksaan_list }}{{ $spec->id_s_specimen_data }}').html(data);
                                                }).fail(function() {
                                                    Swal.fire({
                                                        title: "Gagal!",
                                                        text: "Terjadi kesalahan saat menyimpan data.",
                                                        icon: "error"
                                                    });
                                                });
                                            }
                                        });
                                    });
                                </script>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ACTION FOOTER -->
        <div class="d-flex justify-content-end pt-3">
            <button class="btn btn-primary rounded-pill px-4 shadow-sm" id="button-simpan-proses-specimen-collection" data-code="{{ $code }}">
                <i class="fas fa-save me-1"></i> Simpan Keseluruhan Spesimen
            </button>
        </div>
    </div>
</div>
