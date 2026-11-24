<style>
    .verif-detail-surface {
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        color: var(--bs-body-color);
    }

    .verif-avatar-ring {
        width: 92px;
        height: 92px;
        border-radius: 50%;
        padding: 3px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.25), rgba(14, 165, 233, 0.25));
        border: 1px solid var(--ent-grid-border);
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .verif-info-tile {
        border: 1px solid var(--ent-grid-border);
        border-radius: 11px;
        padding: 9px 10px;
        background-color: rgba(79, 70, 229, 0.04);
        height: 100%;
    }

    .verif-info-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(79, 70, 229, 0.12);
        color: var(--ent-indigo);
        border: 1px solid var(--ent-grid-border);
        flex-shrink: 0;
        font-size: 0.78rem;
    }

    [data-bs-theme="dark"] .verif-info-icon,
    .dark .verif-info-icon {
        color: #a5b4fc;
    }

    .verif-btn-preview {
        background-color: rgba(225, 29, 72, 0.12);
        border: 1px solid rgba(225, 29, 72, 0.35);
        color: #e11d48;
    }

    .verif-btn-preview:hover {
        background-color: #e11d48;
        border-color: #e11d48;
        color: #ffffff;
    }

    [data-bs-theme="dark"] .verif-btn-preview,
    .dark .verif-btn-preview {
        color: #fda4af;
    }

    [data-bs-theme="dark"] .verif-btn-preview:hover,
    .dark .verif-btn-preview:hover {
        color: #ffffff;
    }

    .verif-btn-incomplete {
        background-color: rgba(225, 29, 72, 0.14) !important;
        border: 1px solid rgba(225, 29, 72, 0.4) !important;
        color: #e11d48 !important;
        opacity: 0.9;
    }

    [data-bs-theme="dark"] .verif-btn-incomplete,
    .dark .verif-btn-incomplete {
        color: #fda4af !important;
    }

    .verif-btn-ready {
        background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
        border: none !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25) !important;
    }

    .verif-btn-ready:hover {
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35) !important;
        color: #ffffff !important;
    }

    .verif-group-main td {
        background-color: rgba(79, 70, 229, 0.14) !important;
        color: var(--bs-body-color) !important;
        font-weight: 700 !important;
        font-size: 0.78rem !important;
    }

    .verif-group-sub td {
        background-color: rgba(79, 70, 229, 0.05) !important;
        color: var(--bs-body-color) !important;
        font-weight: 700 !important;
        font-size: 0.76rem !important;
    }

    .verif-table .form-control {
        min-height: 30px !important;
        height: 30px !important;
        padding-top: 3px !important;
        padding-bottom: 3px !important;
        padding-left: 8px !important;
        padding-right: 8px !important;
        font-size: 0.76rem !important;
        border-radius: 8px !important;
    }

    .verif-table .input-group .form-control {
        border-radius: 8px 0 0 8px !important;
        font-family: 'JetBrains Mono', monospace !important;
    }

    .verif-unit-addon {
        background-color: rgba(79, 70, 229, 0.08) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-left: none !important;
        border-radius: 0 8px 8px 0 !important;
        color: var(--bs-body-color) !important;
        font-size: 0.7rem !important;
        font-weight: 700 !important;
        font-family: 'JetBrains Mono', monospace;
    }

    .verif-pdf-frame {
        width: 100%;
        height: 450px;
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
    }
</style>

<div class="modal-body p-0 verif-detail-surface">
    <!-- Header Modal -->
    <div class="ent-modal-header py-3 px-4 pe-5 d-flex justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="ent-glass-pill d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px;">
                <i class="fas fa-microscope text-info fs-5"></i>
            </div>
            <div>
                <h5 class="mb-0 text-white fw-bold" id="staticBackdropLabel">Verifikasi Hasil Pasien Laboratorium</h5>
                <p class="small mb-0" style="color: #cbd5e1;">Supported by Transforma Hospital System</p>
            </div>
        </div>
    </div>

    <div class="p-3 p-md-4">
        <div class="row g-3 g-md-4" id="menu-verifikasi-hasil">

            <!-- Sidebar: Profil & Informasi Pasien -->
            <div class="col-lg-4">
                <div class="card ent-card h-100">
                    <!-- Card Header -->
                    <div class="ent-card-header py-3 px-3">
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <div>
                                <span class="ent-field-label mb-1">
                                    <i class="fas fa-hashtag me-1 text-primary"></i>No. Registrasi
                                </span>
                                <span class="code-chip" style="font-size: 0.82rem;">{{ $reg }}</span>
                            </div>
                            <div class="text-end">
                                <span class="ent-badge" style="background: rgba(16, 185, 129, 0.14); color: #059669; border: 1px solid rgba(16, 185, 129, 0.35);">
                                    <i class="fas fa-check-circle me-1"></i>Terdaftar
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-3 ent-table-surface">
                        <!-- Profil Pasien Avatar & Nama -->
                        <div class="text-center mb-3 pt-1">
                            <div class="verif-avatar-ring mx-auto mb-3">
                                <img src="{{ asset('img/pasien.png') }}" class="rounded-circle w-100 h-100 object-fit-cover" alt="Foto Pasien">
                            </div>

                            <h6 class="mb-1.5 fw-bold text-uppercase">{{ $data->master_patient_name ?? '-' }}</h6>
                            <div class="d-flex align-items-center justify-content-center gap-1">
                                <span class="code-chip">
                                    <i class="fas fa-id-badge me-1"></i>RM: {{ $data->master_patient_code ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="d-flex align-items-center my-3">
                            <div class="flex-grow-1" style="border-top: 1px solid var(--ent-grid-border);"></div>
                            <span class="mx-2 text-uppercase fw-bold opacity-75" style="font-size: 0.65rem; letter-spacing: 0.04em;">Informasi Personal</span>
                            <div class="flex-grow-1" style="border-top: 1px solid var(--ent-grid-border);"></div>
                        </div>

                        <!-- Info Grid Cards -->
                        <div class="row g-2">
                            <!-- Tanggal Lahir -->
                            <div class="col-6">
                                <div class="verif-info-tile d-flex align-items-center gap-2">
                                    <div class="verif-info-icon">
                                        <i class="fas fa-birthday-cake"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <span class="ent-field-label mb-0" style="font-size: 0.6rem;">Tgl Lahir</span>
                                        <div class="fw-bold small" style="font-family: 'JetBrains Mono', monospace; font-size: 0.74rem;">
                                            {{ !empty($data->master_patient_tgl_lahir) ? date('d/m/Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="col-6">
                                <div class="verif-info-tile d-flex align-items-center gap-2">
                                    <div class="verif-info-icon">
                                        <i class="fas fa-venus-mars"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <span class="ent-field-label mb-0" style="font-size: 0.6rem;">Gender</span>
                                        <div class="fw-bold small" style="font-size: 0.74rem;">
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
                                <div class="verif-info-tile d-flex align-items-center gap-2">
                                    <div class="verif-info-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <span class="ent-field-label mb-0" style="font-size: 0.6rem;">Tempat Lahir</span>
                                        <div class="fw-bold small text-truncate">{{ $data->master_patient_tempat_lahir ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <button type="button" class="btn ent-btn verif-btn-preview btn-sm w-100 py-2" id="button-verifikasi-preview-report"
                                    data-code="{{ $code }}" data-reg="{{ $reg }}">
                                    <i class="fas fa-file-pdf me-1"></i> Preview Report
                                </button>
                                <hr class="my-3" style="border-color: var(--ent-grid-border); opacity: 1;">
                                <div id="view-map"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer py-2.5 px-3 text-center ent-table-surface" style="border-top: 1px solid var(--ent-grid-border);">
                        <button class="btn btn-link btn-sm text-decoration-none fw-semibold small" type="button">
                            <i class="fas fa-notes-medical me-1 text-primary"></i> Lihat Rekam Medis Lengkap <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content: Hasil Laboratorium -->
            <div class="col-lg-8">
                <div class="card ent-card h-100">
                    <!-- Header Hasil Laboratorium -->
                    <div class="ent-card-header py-3 px-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                            <i class="fas fa-flask text-primary"></i>
                            <span>Rincian Hasil Laboratorium</span>
                        </h6>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <span id="text-status-verifikasi" class="small fw-semibold"></span>

                            <button type="button" class="btn ent-btn verif-btn-incomplete btn-sm px-3 py-1.5" id="button-verifikasi-hasil-lab"
                                data-code="{{ $code }}" data-reg="{{ $reg }}" disabled>
                                <i class="fas fa-exclamation-circle me-1" id="icon-button-verifikasi"></i>
                                <span id="label-button-verifikasi">Hasil Belum Lengkap</span>
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-0 ent-table-surface">
                        <div class="table-responsive">
                            <table class="table table-custom verif-table align-middle mb-0" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 25%;" class="text-start">Pemeriksaan</th>
                                        <th style="width: 19%;" class="text-start">Hasil</th>
                                        <th style="width: 9%;" class="text-center">Flag</th>
                                        <th style="width: 15%;" class="text-center">Nilai Rujukan</th>
                                        <th style="width: 16%;" class="text-center">Metode</th>
                                        <th style="width: 16%;" class="text-start">Catatan</th>
                                    </tr>
                                </thead>
                                <tbody class="ent-table-surface">
                                    @foreach ($pemeriksaan as $pem)
                                        <!-- Header Layanan Utama -->
                                        <tr class="verif-group-main">
                                            <td colspan="6" class="py-2 ps-3">
                                                <i class="fas fa-vial text-primary me-2"></i>{{ strtoupper($pem->t_pemeriksaan_list_name) }}
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
                                                <tr class="verif-group-sub">
                                                    <td colspan="6" class="fw-bold ps-3 py-2">
                                                        <i class="fas fa-folder text-warning me-2"></i>{{ $param->nama_parameter }}
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
                                                    <tr>
                                                        <td class="ps-4">
                                                            <span class="opacity-60 me-2 fw-bold">↳</span>
                                                            <span class="fw-semibold">{{ $sub->nama_parameter }}</span>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control text-end fw-bold text-primary ent-input"
                                                                    name="hasil[{{ $pem->detail_id }}][{{ $sub->id }}]"
                                                                    value="{{ $nilai ? $nilai->hasil : '' }}" readonly>
                                                                @if(!empty($sub->satuan))
                                                                    <span class="input-group-text verif-unit-addon px-2">
                                                                        {{ $sub->satuan }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td class="text-center fw-bold text-danger" style="font-family: 'JetBrains Mono', monospace;">
                                                            {{ $nilai ? $nilai->flag : '-' }}
                                                        </td>
                                                        <td class="text-center fw-semibold" style="font-family: 'JetBrains Mono', monospace; font-size: 0.74rem;">
                                                            {{ $sub->nilai_normal ?? '-' }}
                                                        </td>
                                                        <td class="text-center text-uppercase fw-semibold" style="font-size: 0.72rem;">
                                                            {{ $sub->metode ?? '-' }}
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-sm ent-input"
                                                                value="{{ $nilai ? $nilai->catatan : '' }}" readonly>
                                                        </td>
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
                                                <tr>
                                                    <td class="ps-3 fw-semibold">{{ $param->nama_parameter }}</td>
                                                    <td>
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" class="form-control text-end fw-bold text-primary ent-input"
                                                                name="hasil[{{ $pem->detail_id }}][{{ $param->id }}]"
                                                                value="{{ $nilai ? $nilai->hasil : '' }}" readonly>
                                                            @if(!empty($param->satuan))
                                                                <span class="input-group-text verif-unit-addon px-2">
                                                                    {{ $param->satuan }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-center fw-bold text-danger" style="font-family: 'JetBrains Mono', monospace;">
                                                        {{ $nilai ? $nilai->flag : '-' }}
                                                    </td>
                                                    <td class="text-center fw-semibold" style="font-family: 'JetBrains Mono', monospace; font-size: 0.74rem;">
                                                        {{ $param->nilai_normal ?? '-' }}
                                                    </td>
                                                    <td class="text-center text-uppercase fw-semibold" style="font-size: 0.72rem;">
                                                        {{ $param->metode ?? '-' }}
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm ent-input"
                                                            value="{{ $nilai ? $nilai->catatan : '' }}" readonly>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Footer Modal -->
                    <div class="card-footer py-3 px-3 d-flex justify-content-between align-items-center ent-table-surface" style="border-top: 1px solid var(--ent-grid-border);">
                        <button type="button" class="btn ent-btn ent-btn-reset btn-sm px-3" data-bs-dismiss="modal">
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
                $btn.removeClass('verif-btn-ready').addClass('verif-btn-incomplete').prop('disabled', true);
                $icon.attr('class', 'fas fa-exclamation-circle me-1');
                $label.text(`Hasil Belum Lengkap (${emptyCount} Kosong)`);
                $statusText.html(`<span class="text-danger"><i class="fas fa-info-circle me-1"></i> Ada ${emptyCount} parameter belum diisi</span>`);
            } else {
                $btn.removeClass('verif-btn-incomplete').addClass('verif-btn-ready').prop('disabled', false);
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
            var code = $(this).data("code");
            var reg = $(this).data("reg");
            var $btn = $(this);

            Swal.fire({
                title: "Konfirmasi Verifikasi?",
                text: "Anda yakin akan memverifikasi hasil ini? Dokumen PDF terenkripsi (Password Tgl Lahir) akan dibuat otomatis.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#059669",
                cancelButtonColor: "#e11d48",
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
                        success: function() {
                            Swal.fire({
                                title: "Terverifikasi!",
                                text: "Hasil laboratorium berhasil diverifikasi dan dokumen PDF telah tersimpan.",
                                icon: "success",
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                const modalLabFullEl = document.getElementById('modal-lab-full');
                                if (modalLabFullEl && window.bootstrap) {
                                    const inst = bootstrap.Modal.getInstance(modalLabFullEl);
                                    if (inst) inst.hide();
                                }
                                location.reload();
                            });
                        },
                        error: function() {
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

            $('#view-map').html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="opacity-75 fw-semibold small mt-2 mb-0">Menyiapkan pratinjau dokumen...</p>
                </div>
            `);

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
                    $('#view-map').html('<iframe src="data:application/pdf;base64, ' + data + '" class="verif-pdf-frame" frameborder="0"></iframe>');
                },
                error: function() {
                    $('#view-map').html('<div class="alert alert-danger m-0 rounded-3 small fw-semibold"><i class="fas fa-exclamation-triangle me-1"></i>Gagal memuat pratinjau laporan.</div>');
                }
            });
        });

    });
</script>
