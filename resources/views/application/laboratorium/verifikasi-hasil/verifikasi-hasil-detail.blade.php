<div class="modal-body p-0 retro-card border-0" style="background-color: var(--retro-bg); border-radius: 12px; overflow: hidden;">
    <!-- Header Modal dengan Retro Styling -->
    <div class="py-3 px-4 d-flex justify-content-between align-items-center border-bottom border-dark" style="background-color: var(--retro-yellow); border-width: 3px !important;">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: white; border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                <i class="fas fa-microscope text-dark fs-1"></i>
            </div>
            <div>
                <h5 class="mb-0 text-dark fw-bolder" id="staticBackdropLabel">Verifikasi Hasil Pasien Laboratorium</h5>
                <p class="fs--2 mb-0 text-dark fw-bold opacity-75">Supported by Transforma Hospital System</p>
            </div>
        </div>
    </div>

    <div class="p-4" style="background-color: var(--retro-bg);">
        <div class="row g-4" id="menu-verifikasi-hasil">

            <!-- Sidebar: Profil & Informasi Pasien -->
            <div class="col-lg-4">
                <div class="retro-card h-100 bg-white">
                    <!-- Card Header -->
                    <div class="card-header border-bottom border-dark py-3 px-3 position-relative" style="background-color: var(--retro-dark); color: var(--retro-yellow);">
                        <div class="d-flex justify-content-between align-items-center position-relative z-index-1">
                            <div>
                                <span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark); font-size: 0.6rem;">
                                    <i class="fas fa-hashtag me-1"></i>No. Registrasi
                                </span>
                                <h5 class="mb-0 text-white fw-bolder mt-1 tracking-wide">{{ $reg }}</h5>
                            </div>
                            <div class="text-end">
                                <span class="retro-badge" style="background-color: var(--retro-green); color: var(--retro-dark); font-size: 0.6rem;">
                                    <i class="fas fa-check-circle me-1"></i>Terdaftar
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-3 bg-white">
                        <!-- Profil Pasien Avatar & Nama -->
                        <div class="text-center position-relative mb-3 pt-2">
                            <div class="mx-auto mb-3 position-relative p-1 bg-white rounded-circle overflow-hidden" style="width: 90px; height: 90px; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                                <img src="{{ asset('img/pasien.png') }}" class="rounded-circle img-fluid w-100 h-100 object-fit-cover" alt="Foto Pasien">
                            </div>

                            <h5 class="mb-1 fw-bolder text-dark text-uppercase fs-0">{{ $data->master_patient_name ?? '-' }}</h5>
                            <div class="d-flex align-items-center justify-content-center gap-1">
                                <span class="retro-badge" style="background-color: var(--retro-bg); color: var(--retro-dark); font-size: 0.65rem;">
                                    <i class="fas fa-id-badge me-1"></i>RM: {{ $data->master_patient_code ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="d-flex align-items-center my-3">
                            <div class="flex-grow-1 border-top border-dark" style="border-width: 2px !important;"></div>
                            <span class="mx-2 fs--2 text-dark fw-bolder text-uppercase">Informasi Personal</span>
                            <div class="flex-grow-1 border-top border-dark" style="border-width: 2px !important;"></div>
                        </div>

                        <!-- Info Grid Cards -->
                        <div class="row g-2 fs--1">
                            <!-- Tanggal Lahir -->
                            <div class="col-6">
                                <div class="p-2 rounded-2 d-flex align-items-center h-100" style="background-color: #fffbeb; border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                                    <div class="rounded-2 p-1 text-dark me-2 flex-shrink-0 fw-bold" style="background-color: var(--retro-yellow); border: 1.5px solid var(--retro-dark);">
                                        <i class="fas fa-birthday-cake"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="fs--2 text-dark text-uppercase fw-bolder">Tgl Lahir</div>
                                        <div class="fw-bold text-dark fs--2">{{ !empty($data->master_patient_tgl_lahir) ? date('d/m/Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="col-6">
                                <div class="p-2 rounded-2 d-flex align-items-center h-100" style="background-color: #e0f2fe; border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                                    <div class="rounded-2 p-1 text-dark me-2 flex-shrink-0 fw-bold" style="background-color: var(--retro-cyan); border: 1.5px solid var(--retro-dark);">
                                        <i class="fas fa-venus-mars"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="fs--2 text-dark text-uppercase fw-bolder">Gender</div>
                                        <div class="fw-bold text-dark fs--2">
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
                                <div class="p-2 rounded-2 d-flex align-items-center" style="background-color: #ffe4e6; border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                                    <div class="rounded-2 p-1 text-dark me-2 flex-shrink-0 fw-bold" style="background-color: var(--retro-pink); border: 1.5px solid var(--retro-dark);">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="fs--2 text-dark text-uppercase fw-bolder">Tempat Lahir</div>
                                        <div class="fw-bold text-dark text-truncate fs--1">{{ $data->master_patient_tempat_lahir ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <button class="btn retro-btn btn-danger btn-sm w-100 py-2" id="button-verifikasi-preview-report"
                                    data-code="{{ $code }}" data-reg="{{ $reg }}" style="background-color: var(--retro-pink); color: var(--retro-dark);">
                                    <i class="fas fa-file-pdf me-1"></i> Preview Report
                                </button>
                                <hr class="my-2 border-dark" style="border-width: 2px;">
                                <div id="view-map"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white p-2 border-top border-dark text-center" style="border-top-width: 2px !important;">
                        <button class="btn btn-link btn-sm text-dark text-decoration-underline fw-bolder" type="button">
                            <i class="fas fa-notes-medical me-1"></i> Lihat Rekam Medis Lengkap <i class="fas fa-arrow-right ms-1 fs--2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content: Hasil Laboratorium -->
            <div class="col-lg-8">
                <div class="retro-card h-100 bg-white">
                    <!-- Header Hasil Laboratorium -->
                    <div class="card-header text-dark py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-dark); color: white;">
                        <h6 class="mb-0 fw-bolder text-white"><i class="fas fa-flask text-info me-2"></i>Rincian Hasil Laboratorium</h6>
                        <div class="d-flex align-items-center gap-2">
                            <span id="text-status-verifikasi" class="fs--2 fw-bold text-warning me-2"></span>

                            <button class="btn retro-btn btn-sm px-4 shadow-sm" id="button-verifikasi-hasil-lab"
                                data-code="{{ $code }}" data-reg="{{ $reg }}" disabled style="background-color: var(--retro-pink); color: var(--retro-dark);">
                                <i class="fas fa-exclamation-circle me-1" id="icon-button-verifikasi"></i>
                                <span id="label-button-verifikasi">Hasil Belum Lengkap</span>
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-0 bg-white">
                        <!-- Tabel Hasil dengan Border Grid Tegas -->
                        <div class="table-responsive">
                            <table class="table table-custom align-middle fs--1 mb-0 table-bordered text-dark" style="width: 100%; border: 2px solid var(--retro-dark);">
                                <thead style="background-color: var(--retro-dark); color: var(--retro-green);">
                                    <tr>
                                        <th style="width: 25%; border: 2px solid var(--retro-dark); color: var(--retro-green); font-weight: 800;">Pemeriksaan</th>
                                        <th style="width: 18%; border: 2px solid var(--retro-dark); color: var(--retro-green); font-weight: 800;">Hasil</th>
                                        <th style="width: 10%; border: 2px solid var(--retro-dark); color: var(--retro-green); font-weight: 800;" class="text-center">Flag</th>
                                        <th style="width: 15%; border: 2px solid var(--retro-dark); color: var(--retro-green); font-weight: 800;" class="text-center">Nilai Rujukan</th>
                                        <th style="width: 17%; border: 2px solid var(--retro-dark); color: var(--retro-green); font-weight: 800;" class="text-center">Metode</th>
                                        <th style="width: 15%; border: 2px solid var(--retro-dark); color: var(--retro-green); font-weight: 800;">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pemeriksaan as $pem)
                                    <!-- Header Layanan Utama -->
                                    <tr style="background-color: var(--retro-yellow); font-weight: 900;">
                                        <td colspan="6" class="py-2 text-dark ps-3" style="border: 2px solid var(--retro-dark);">
                                            <i class="fas fa-vial text-dark me-2"></i>{{ strtoupper($pem->t_pemeriksaan_list_name) }}
                                        </td>
                                    </tr>

                                    @php
                                    $parameters = DB::table('medical_master_parameter')
                                    ->where('master_pemeriksaan_id', $pem->t_pemeriksaan_list_code)
                                    ->whereNull('parent_id')
                                    ->orderBy('urutan', 'ASC')
                                    ->get();
                                    @endphp

                                    @foreach ($parameters as $param)
                                    @if($param->is_group == 1)
                                    <!-- JIKA INI GRUP -->
                                    <tr style="background-color: #f4f0ea; font-weight: 800;">
                                        <td colspan="6" class="fw-bolder text-dark ps-3 py-2" style="border: 2px solid var(--retro-dark);">
                                            <i class="fas fa-folder text-dark me-2 fs-0"></i>{{ $param->nama_parameter }}
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
                                    <!-- Anakan Parameter -->
                                    <tr style="background-color: #ffffff;">
                                        <td class="ps-4" style="border: 2px solid var(--retro-dark);">
                                            <span class="text-dark me-2 fw-bold">↳</span>
                                            <span class="text-dark fw-bold">{{ $sub->nama_parameter }}</span>
                                        </td>
                                        <td style="border: 2px solid var(--retro-dark);">
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control text-end bg-white fw-bolder text-primary retro-input"
                                                    name="hasil[{{ $pem->detail_id }}][{{ $sub->id }}]"
                                                    value="{{ $nilai ? $nilai->hasil : '' }}" readonly style="border: 2px solid var(--retro-dark) !important;">
                                                @if(!empty($sub->satuan))
                                                <span class="input-group-text text-dark px-2 fs--2 fw-bold" style="border: 2px solid var(--retro-dark); background-color: var(--retro-bg);">
                                                    {{ $sub->satuan }}
                                                </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center fw-bolder text-danger" style="border: 2px solid var(--retro-dark);">{{ $nilai ? $nilai->flag : '-' }}</td>
                                        <td class="text-center text-dark fs--2 fw-bold" style="border: 2px solid var(--retro-dark);">{{ $sub->nilai_normal ?? '-' }}</td>
                                        <td class="fs--2 text-center text-uppercase text-dark fw-bold" style="border: 2px solid var(--retro-dark);">{{ $sub->metode ?? '-' }}</td>
                                        <td style="border: 2px solid var(--retro-dark);"><input type="text" class="form-control form-control-sm fs--2 bg-white text-dark fw-bold" value="{{ $nilai ? $nilai->catatan : '' }}" readonly style="border: 2px solid var(--retro-dark) !important;"></td>
                                    </tr>
                                    @endforeach

                                    @else
                                    <!-- JIKA INI PARAMETER TUNGGAL -->
                                    @php
                                    $nilai = DB::table('medical_transaksi_hasil')
                                    ->where('detail_id', $pem->detail_id)
                                    ->where('parameter_id', $param->id)
                                    ->first();
                                    @endphp
                                    <tr style="background-color: #ffffff;">
                                        <td class="ps-3 fw-bolder text-dark" style="border: 2px solid var(--retro-dark);">{{ $param->nama_parameter }}</td>
                                        <td style="border: 2px solid var(--retro-dark);">
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control text-end bg-white fw-bolder text-primary retro-input"
                                                    name="hasil[{{ $pem->detail_id }}][{{ $param->id }}]"
                                                    value="{{ $nilai ? $nilai->hasil : '' }}" readonly style="border: 2px solid var(--retro-dark) !important;">
                                                @if(!empty($param->satuan))
                                                <span class="input-group-text text-dark px-2 fs--2 fw-bold" style="border: 2px solid var(--retro-dark); background-color: var(--retro-bg);">
                                                    {{ $param->satuan }}
                                                </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center fw-bolder text-danger" style="border: 2px solid var(--retro-dark);">{{ $nilai ? $nilai->flag : '-' }}</td>
                                        <td class="text-center text-dark fs--2 fw-bold" style="border: 2px solid var(--retro-dark);">{{ $param->nilai_normal ?? '-' }}</td>
                                        <td class="fs--2 text-center text-uppercase text-dark fw-bold" style="border: 2px solid var(--retro-dark);">{{ $param->metode ?? '-' }}</td>
                                        <td style="border: 2px solid var(--retro-dark);"><input type="text" class="form-control form-control-sm fs--2 bg-white text-dark fw-bold" value="{{ $nilai ? $nilai->catatan : '' }}" readonly style="border: 2px solid var(--retro-dark) !important;"></td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Footer Modal -->
                    <div class="card-footer bg-white py-3 px-3 border-top border-dark d-flex justify-content-between align-items-center" style="border-top-width: 2px !important;">
                        <button class="btn retro-btn btn-secondary btn-sm" data-bs-dismiss="modal">
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
                $statusText.html('<span class="text-success fw-bold"><i class="fas fa-check me-1"></i> Semua hasil siap diverifikasi</span>');
            }
        }

        checkFormCompleteness();

        // ====================================================================
        // AKSI KLIK TOMBOL VERIFIKASI HASIL
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
                confirmButtonColor: "#c1ff72",
                cancelButtonColor: "#ffa6c9",
                confirmButtonText: "Ya, Verifikasi!",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses PDF...');

                    $.ajax({
                        url: "{{ route('verifikasi_laboratorium_verifikasi_data') }}",
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
                                $('#modal-lab-full').modal('hide');
                                location.reload();
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
        // PREVIEW DOKUMEN
        // ====================================================================
        $('#button-verifikasi-preview-report').off('click').on('click', function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            var reg = $(this).data("reg");

            $('#view-map').html('<div class="text-center py-4"><div class="spinner-border text-dark" role="status"></div><p class="text-dark fw-bold fs--1 mt-2">Menyiapkan pratinjau dokumen...</p></div>');

            $.ajax({
                url: "{{ route('verifikasi_laboratorium_preview_report') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code,
                    "reg": reg,
                },
                success: function(data) {
                    $('#view-map').html('<iframe src="data:application/pdf;base64, ' + data + '" style="width:100%; height:450px; border: 2px solid var(--retro-dark); border-radius: 6px;" frameborder="0" class="shadow-sm"></iframe>');
                },
                error: function() {
                    $('#view-map').html('<div class="alert alert-danger m-0 fs--1 fw-bold border-2 border-dark">Gagal memuat pratinjau laporan.</div>');
                }
            });
        });

    });
</script>
