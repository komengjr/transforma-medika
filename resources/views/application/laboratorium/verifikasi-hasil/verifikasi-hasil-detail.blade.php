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
                                @if (empty($data->master_patient_profile))
                                <img src="{{ asset('img/pasien.png') }}" class="rounded-circle img-fluid w-100 h-100 object-fit-cover" alt="Foto Pasien" id="videoPreview">
                                @else
                                <img src="{{ Storage::url($data->master_patient_profile) }}" class="rounded-circle img-fluid w-100 h-100 object-fit-cover" alt="Foto Pasien" id="videoPreview">
                                @endif
                                <span class="position-absolute bottom-0 end-0 p-2 bg-success border border-2 border-white rounded-circle" title="Pasien Aktif"></span>
                            </div>

                            <h5 class="mb-1 fw-bold text-900 fs-0">{{ $data->master_patient_name }}</h5>
                            <div class="d-flex align-items-center justify-content-center gap-1">
                                <span class="badge bg-soft-secondary text-secondary fw-bold fs--2">
                                    <i class="fas fa-id-badge me-1"></i>RM: {{ $data->master_patient_code }}
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
                            <!-- NIK -->
                            <div class="col-12">
                                <div class="p-2 rounded-2 bg-soft-info border border-info-subtle d-flex align-items-center">
                                    <div class="icon-item icon-item-sm bg-info text-white rounded-2 me-2 flex-shrink-0">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="fs--2 text-600 text-uppercase fw-semi-bold">Nomor Induk Kependudukan (NIK)</div>
                                        <div class="fw-bold text-800 text-truncate">{{ $data->master_patient_nik ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="col-6">
                                <div class="p-2 rounded-2 bg-soft-warning border border-warning-subtle d-flex align-items-center h-100">
                                    <div class="icon-item icon-item-sm bg-warning text-white rounded-2 me-2 flex-shrink-0">
                                        <i class="fas fa-birthday-cake"></i>
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="fs--2 text-600 text-uppercase fw-semi-bold">Tgl Lahir</div>
                                        <div class="fw-bold text-800 fs--1">{{ $data->master_patient_tgl_lahir ?? '-' }}</div>
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
                                        <div class="fw-bold text-800 fs--1">{{ $data->master_patient_jk ?? '-' }}</div>
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

                            <button class="btn btn-danger btn-sm px-4 shadow-sm" id="button-verifikasi-hasil-lab"
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
                                    <!-- Header Kelompok Utama -->
                                    <tr class="bg-soft-primary border-top border-primary border-2">
                                        <td colspan="6" class="fw-bold text-primary ps-3 py-2">
                                            <i class="fas fa-vial text-primary me-2"></i>{{ strtoupper($pem->t_pemeriksaan_list_name) }}
                                        </td>
                                    </tr>

                                    @php
                                    $sub = DB::table('t_pemeriksaan_list_val')
                                    ->where('t_pemeriksaan_list_code', $pem->t_pemeriksaan_list_code)
                                    ->get();
                                    @endphp

                                    @foreach ($sub as $subs)
                                    @php
                                    // PENCARIAN DIREVISI MENGGUNAKAN COLUMN: order_lab_list_code
                                    $nilai = DB::table('h_reg_lab')
                                    ->where('order_lab_list_code', $pem->order_lab_list_code)
                                    ->where('t_pem_list_val_code', $subs->t_pem_list_val_code)
                                    ->first();

                                    $is_child = !empty($subs->t_pem_list_val_opt_code);
                                    @endphp

                                    {{-- CASE 1: JIKA INI KEPALA TURUNAN (t_pem_list_val_opt == 'Y') --}}
                                    @if ($subs->t_pem_list_val_opt == 'Y')
                                    <tr class="bg-soft-warning border-start border-3 border-warning">
                                        <td colspan="6" class="fw-bold text-800 ps-3 py-2">
                                            <i class="fas fa-folder text-warning me-2 fs-0"></i>{{ $subs->t_pem_list_val_name }}
                                        </td>
                                    </tr>

                                    {{-- CASE 2: PARAMETER INPUT (Bisa Anakan ATAU Parameter Mandiri) --}}
                                    @else
                                    <tr class="hover-actions-trigger">
                                        <!-- Parameter Name -->
                                        <td class="{{ $is_child ? 'ps-4' : 'ps-3' }}">
                                            @if($is_child)
                                            <!-- Jika Anak -->
                                            <span class="text-400 me-2 fw-bold">↳</span>
                                            <span class="text-700 fw-medium">{{ $subs->t_pem_list_val_name }}</span>
                                            @else
                                            <!-- Jika Parameter Mandiri -->
                                            <span class="fw-bold text-800">{{ $subs->t_pem_list_val_name }}</span>
                                            @endif
                                        </td>

                                        <!-- Input Hasil & Satuan -->
                                        <td>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control text-end bg-white fw-bold text-primary"
                                                    name="hasil[{{ $subs->t_pem_list_val_code }}]"
                                                    value="{{ $nilai ? $nilai->h_reg_lab_value : '' }}">
                                                @if(!empty($subs->t_pem_list_val_satuan))
                                                <span class="input-group-text bg-100 text-600 px-2 fs--2 fw-semi-bold" style="min-width: 45px; justify-content: center;">
                                                    {{ $subs->t_pem_list_val_satuan }}
                                                </span>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Dropdown Flag -->
                                        <td class="text-center">
                                            <select class="form-select form-select-sm text-center px-1 fw-bold text-danger" name="flag[{{ $subs->t_pem_list_val_code }}]">
                                                <option value="">-</option>
                                                <option value="N" {{ ($nilai && $nilai->h_reg_lab_flag == 'N') ? 'selected' : '' }}>N</option>
                                                <option value="H" class="text-danger fw-bold" {{ ($nilai && $nilai->h_reg_lab_flag == 'H') ? 'selected' : '' }}>H</option>
                                                <option value="L" class="text-warning fw-bold" {{ ($nilai && $nilai->h_reg_lab_flag == 'L') ? 'selected' : '' }}>L</option>
                                                <option value="*" class="text-danger fw-bold" {{ ($nilai && $nilai->h_reg_lab_flag == '*') ? 'selected' : '' }}>*</option>
                                            </select>
                                        </td>

                                        <!-- Nilai Rujukan -->
                                        <td class="text-center text-700 fs--2 fw-medium">
                                            {{ $subs->t_pem_list_val_rujukan ?? '-' }}
                                        </td>

                                        <!-- Dropdown Metode -->
                                        <td>
                                            <select class="form-select form-select-sm fs--2 text-uppercase" name="metode[{{ $subs->t_pem_list_val_code }}]">
                                                <option value="">-- Pilih --</option>
                                                <option value="LASER OPTICAL FLOWCY" {{ ($nilai && $nilai->h_reg_lab_metode == 'LASER OPTICAL FLOWCY') ? 'selected' : '' }}>LASER OPTICAL FLOWCY</option>
                                                <option value="IMPEDANCE WITH HDFC" {{ ($nilai && $nilai->h_reg_lab_metode == 'IMPEDANCE WITH HDFC') ? 'selected' : '' }}>IMPEDANCE WITH HDFC</option>
                                                <option value="SLS HEMOGLOBIN" {{ ($nilai && $nilai->h_reg_lab_metode == 'SLS HEMOGLOBIN') ? 'selected' : '' }}>SLS HEMOGLOBIN</option>
                                                <option value="RBC PULSE HEIGHT DETE" {{ ($nilai && $nilai->h_reg_lab_metode == 'RBC PULSE HEIGHT DETE') ? 'selected' : '' }}>RBC PULSE HEIGHT DETE</option>
                                                <option value="CALCULATION" {{ ($nilai && $nilai->h_reg_lab_metode == 'CALCULATION') ? 'selected' : '' }}>CALCULATION</option>
                                                @if($nilai && !empty($nilai->h_reg_lab_metode))
                                                <option value="{{ $nilai->h_reg_lab_metode }}" selected>{{ $nilai->h_reg_lab_metode }}</option>
                                                @endif
                                            </select>
                                        </td>

                                        <!-- Input Catatan -->
                                        <td>
                                            <input type="text" class="form-control form-control-sm fs--2" name="catatan[{{ $subs->t_pem_list_val_code }}]" placeholder="...">
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
                    <div class="card-footer bg-light py-3 border-top d-flex justify-content-between align-items-center">
                        <button class="btn btn-falcon-default btn-sm" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document.body).ready(function() {

        // Fungsi mengecek apakah semua input hasil terisi
        function checkFormCompleteness() {
            let totalInput = 0;
            let emptyCount = 0;

            $('input[name^="hasil"]').each(function() {
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
                $btn.removeClass('btn-success')
                    .addClass('btn-danger')
                    .prop('disabled', true);

                $icon.attr('class', 'fas fa-exclamation-circle me-1');
                $label.text(`Belum Lengkap (${emptyCount} Kosong)`);
                $statusText.html(`<i class="fas fa-info-circle me-1"></i> Ada ${emptyCount} parameter belum diisi`);
            } else {
                $btn.removeClass('btn-danger')
                    .addClass('btn-success')
                    .prop('disabled', false);

                $icon.attr('class', 'fas fa-check-circle me-1');
                $label.text('Verifikasi Hasil');
                $statusText.html('<span class="text-success"><i class="fas fa-check me-1"></i> Semua hasil siap diverifikasi</span>');
            }
        }

        // Run otomatis saat load
        checkFormCompleteness();

        // Real-time listener
        $(document).on('input change', 'input[name^="hasil"]', function() {
            checkFormCompleteness();
        });

    });
</script>
