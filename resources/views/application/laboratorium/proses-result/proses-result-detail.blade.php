<style>
    .res-detail-card {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 16px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08) !important;
        overflow: hidden;
    }

    .res-patient-avatar {
        width: 96px;
        height: 96px;
        border-radius: 18px;
        border: 1px solid var(--ent-grid-border);
        background-color: rgba(79, 70, 229, 0.06);
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .res-info-grid {
        background-color: rgba(79, 70, 229, 0.04);
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 12px 14px;
    }

    .ent-btn-cyan {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
    }

    .ent-btn-cyan:hover {
        box-shadow: 0 6px 16px rgba(2, 132, 199, 0.35);
        color: #ffffff;
    }

    .ent-btn-success {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .ent-btn-success:hover {
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        color: #ffffff;
    }

    /* Result Table Hierarchy & Controls */
    .res-group-main td {
        background-color: rgba(79, 70, 229, 0.14) !important;
        color: var(--bs-body-color) !important;
        font-weight: 700 !important;
        font-size: 0.8rem !important;
    }

    .res-group-sub td {
        background-color: rgba(79, 70, 229, 0.05) !important;
        color: var(--bs-body-color) !important;
        font-weight: 700 !important;
        font-size: 0.78rem !important;
    }

    .res-table .form-control,
    .res-table .form-select {
        min-height: 32px !important;
        height: 32px !important;
        padding-top: 4px !important;
        padding-bottom: 4px !important;
        padding-left: 8px !important;
        padding-right: 8px !important;
        font-size: 0.78rem !important;
        border-radius: 8px !important;
    }

    .res-unit-addon {
        background-color: rgba(79, 70, 229, 0.08) !important;
        border: 1px solid var(--ent-grid-border) !important;
        border-left: none !important;
        border-radius: 0 8px 8px 0 !important;
        color: var(--bs-body-color) !important;
        font-size: 0.72rem !important;
        font-weight: 700 !important;
        font-family: 'JetBrains Mono', monospace;
    }

    .res-table .input-group .form-control {
        border-radius: 8px 0 0 8px !important;
        font-family: 'JetBrains Mono', monospace !important;
    }

    .res-filled {
        border-color: #059669 !important;
        background-color: rgba(16, 185, 129, 0.08) !important;
    }

    .res-unit-addon.res-filled {
        border-color: #059669 !important;
        background-color: rgba(16, 185, 129, 0.14) !important;
        color: #059669 !important;
    }

    [data-bs-theme="dark"] .res-unit-addon.res-filled,
    .dark .res-unit-addon.res-filled {
        color: #34d399 !important;
    }
</style>

<div class="card res-detail-card mb-4">
    <!-- CARD HEADER -->
    <div class="ent-card-header py-3 px-3 px-md-4 d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <i class="fas fa-user-check text-primary"></i>
            <h6 class="mb-0 fw-bold">
                Pasien Details No Reg:
            </h6>
            <span class="code-chip">{{ $code ?? '-' }}</span>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-sm ent-btn ent-btn-cyan px-3 py-1.5" id="button-sinkronisasi-proses-result">
                <i class="fas fa-sync-alt me-1"></i> Sinkronisasi Alat
            </button>
            <button type="button" class="btn btn-sm ent-btn ent-btn-success px-3 py-1.5" id="button-simpan-proses-result">
                <i class="fas fa-check-circle me-1"></i> Simpan
            </button>
        </div>
    </div>

    <!-- CARD BODY -->
    <div class="card-body p-3 p-md-4 ent-table-surface">

        <div class="row g-3 g-md-4 align-items-center">

            <!-- KIRI: Foto Pasien -->
            <div class="col-md-3 col-lg-2 text-center">
                <div class="res-patient-avatar mx-auto mb-2">
                    @if (empty($data->master_patient_profile ?? null))
                        <img src="{{ asset('img/pasien.png') }}" class="w-100 h-100 object-fit-cover" alt="Foto Pasien">
                    @else
                        <img src="{{ Storage::url($data->master_patient_profile) }}" class="w-100 h-100 object-fit-cover" alt="Foto Pasien">
                    @endif
                </div>
                <span class="code-chip">{{ $data->master_patient_code ?? '-' }}</span>
            </div>

            <!-- KANAN: Detail Informasi Pasien -->
            <div class="col-md-9 col-lg-10">
                <div class="mb-3">
                    <h5 class="mb-1 fw-bold">{{ $data->master_patient_name ?? '-' }}</h5>
                    <div class="small d-flex align-items-center gap-1.5 flex-wrap">
                        <i class="fas fa-id-badge text-primary"></i>
                        <span class="opacity-75 fw-semibold">NIK:</span>
                        <strong style="font-family: 'JetBrains Mono', monospace;">{{ $data->master_patient_nik ?? '-' }}</strong>
                    </div>
                </div>

                <div class="res-info-grid">
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-3">
                            <span class="ent-field-label">No. Rekam Medis</span>
                            <div class="fw-bold small d-flex align-items-center gap-1.5 text-primary" style="font-family: 'JetBrains Mono', monospace;">
                                <i class="fas fa-hashtag"></i>
                                <span>{{ $data->master_patient_code ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <span class="ent-field-label">Jenis Kelamin</span>
                            <div class="fw-bold small d-flex align-items-center gap-1.5">
                                @if(strtolower($data->master_patient_jk ?? '') == 'l' || strtolower($data->master_patient_jk ?? '') == 'laki-laki')
                                    <i class="fas fa-mars text-primary"></i> <span>Laki-laki</span>
                                @elseif(strtolower($data->master_patient_jk ?? '') == 'p' || strtolower($data->master_patient_jk ?? '') == 'perempuan')
                                    <i class="fas fa-venus text-danger"></i> <span>Perempuan</span>
                                @else
                                    <i class="fas fa-genderless opacity-75"></i> <span>{{ $data->master_patient_jk ?? '-' }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <span class="ent-field-label">Tanggal Lahir</span>
                            <div class="fw-bold small d-flex align-items-center gap-1.5" style="font-family: 'JetBrains Mono', monospace;">
                                <i class="far fa-calendar-alt text-warning"></i>
                                <span>{{ !empty($data->master_patient_tgl_lahir) ? date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}</span>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <span class="ent-field-label">Tempat Lahir</span>
                            <div class="fw-bold small d-flex align-items-center gap-1.5">
                                <i class="fas fa-map-marker-alt text-danger"></i>
                                <span>{{ $data->master_patient_tempat_lahir ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-4">
            <form id="form-result-pasien" action="{{ route('menu_lab_proses_result_detail_proses_save') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="code" value="{{ $code ?? '' }}">

                <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
                    <table class="table table-custom res-table align-middle mb-0" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Nama Pemeriksaan</th>
                                <th style="width: 25%;">Hasil (Unit)</th>
                                <th style="width: 18%;" class="text-center">Flag</th>
                                <th style="width: 20%;">Nilai Normal</th>
                                <th style="width: 17%;">Metode</th>
                            </tr>
                        </thead>
                        <tbody class="ent-table-surface">
                            @forelse ($pemeriksaan ?? [] as $pem)
                                <!-- HEADER UTAMA PEMERIKSAAN -->
                                <tr class="res-group-main">
                                    <td colspan="5" class="py-2 px-3">
                                        <i class="fas fa-flask me-1.5 text-primary"></i> {{ $pem->t_pemeriksaan_list_name ?? '-' }}
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
                                        <!-- KELOMPOK / SUB-HEADER -->
                                        <tr class="res-group-sub">
                                            <td colspan="5" class="ps-3 py-2">
                                                <i class="fas fa-folder-open text-warning me-1.5"></i> {{ $param->nama_parameter }}
                                            </td>
                                        </tr>

                                        @php
                                            $subParameters = DB::table('medical_master_parameter')
                                                ->where('parent_id', $param->id)
                                                ->orderBy('urutan', 'ASC')
                                                ->get();
                                        @endphp

                                        @foreach ($subParameters as $sub)
                                            @php
                                                $nilai = DB::table('medical_transaksi_hasil')
                                                    ->where('detail_id', $pem->detail_id)
                                                    ->where('parameter_id', $sub->id)
                                                    ->first();

                                                $hasValue = $nilai && !empty($nilai->hasil);
                                                $currentFlag = $nilai ? $nilai->flag : '*';
                                            @endphp
                                            <tr>
                                                <td class="ps-4">
                                                    <i class="fas fa-level-up-alt fa-rotate-90 opacity-60 me-2"></i>
                                                    <span class="fw-semibold">{{ $sub->nama_parameter }}</span>
                                                </td>
                                                <td>
                                                    <div class="input-group has-validation">
                                                        <input type="text"
                                                            class="form-control form-control-sm input-hasil ent-input {{ $hasValue ? 'res-filled' : '' }}"
                                                            data-code="{{ $sub->id }}"
                                                            name="hasil[{{ $pem->detail_id }}][{{ $sub->id }}]"
                                                            value="{{ $hasValue ? $nilai->hasil : '' }}"
                                                            placeholder="0.0">

                                                        <span class="input-group-text res-unit-addon px-2 {{ $hasValue ? 'res-filled' : '' }}">
                                                            {{ $sub->satuan ?? '-' }}
                                                        </span>
                                                    </div>
                                                </td>

                                                <td class="text-center align-middle">
                                                    <select name="flag[{{ $pem->detail_id }}][{{ $sub->id }}]"
                                                        class="form-select form-select-sm text-center select-flag ent-input {{ $hasValue ? 'res-filled' : '' }}"
                                                        data-code="{{ $sub->id }}">
                                                        <option value="*" {{ $currentFlag == '*' ? 'selected' : '' }}>*</option>
                                                        <option value="N" {{ $currentFlag == 'N' ? 'selected' : '' }}>N (Normal)</option>
                                                        <option value="H" {{ $currentFlag == 'H' ? 'selected' : '' }}>H (High)</option>
                                                        <option value="L" {{ $currentFlag == 'L' ? 'selected' : '' }}>L (Low)</option>
                                                        <option value="A" {{ $currentFlag == 'A' ? 'selected' : '' }}>A (Abnormal)</option>
                                                    </select>
                                                </td>

                                                <td class="align-middle fw-semibold" style="font-family: 'JetBrains Mono', monospace; font-size: 0.76rem;">
                                                    {{ $sub->nilai_normal ?? '-' }}
                                                </td>

                                                <td class="align-middle">
                                                    <select name="metode[{{ $pem->detail_id }}][{{ $sub->id }}]"
                                                        class="form-select form-select-sm select-metode ent-input {{ $hasValue ? 'res-filled' : '' }}"
                                                        data-code="{{ $sub->id }}">
                                                        <option value="{{ $sub->metode ?? '-' }}" selected>{{ $sub->metode ?? '-' }}</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @php
                                            $nilai = DB::table('medical_transaksi_hasil')
                                                ->where('detail_id', $pem->detail_id)
                                                ->where('parameter_id', $param->id)
                                                ->first();

                                            $hasValue = $nilai && !empty($nilai->hasil);
                                            $currentFlag = $nilai ? $nilai->flag : '*';
                                        @endphp
                                        <tr>
                                            <td class="ps-3 fw-semibold">
                                                {{ $param->nama_parameter }}
                                            </td>
                                            <td>
                                                <div class="input-group has-validation">
                                                    <input type="text"
                                                        class="form-control form-control-sm input-hasil ent-input {{ $hasValue ? 'res-filled' : '' }}"
                                                        data-code="{{ $param->id }}"
                                                        name="hasil[{{ $pem->detail_id }}][{{ $param->id }}]"
                                                        value="{{ $hasValue ? $nilai->hasil : '' }}"
                                                        placeholder="0.0">

                                                    <span class="input-group-text res-unit-addon px-2 {{ $hasValue ? 'res-filled' : '' }}">
                                                        {{ $param->satuan ?? '-' }}
                                                    </span>
                                                </div>
                                            </td>

                                            <td class="text-center align-middle">
                                                <select name="flag[{{ $pem->detail_id }}][{{ $param->id }}]"
                                                    class="form-select form-select-sm text-center select-flag ent-input {{ $hasValue ? 'res-filled' : '' }}"
                                                    data-code="{{ $param->id }}">
                                                    <option value="*" {{ $currentFlag == '*' ? 'selected' : '' }}>*</option>
                                                    <option value="N" {{ $currentFlag == 'N' ? 'selected' : '' }}>N (Normal)</option>
                                                    <option value="H" {{ $currentFlag == 'H' ? 'selected' : '' }}>H (High)</option>
                                                    <option value="L" {{ $currentFlag == 'L' ? 'selected' : '' }}>L (Low)</option>
                                                    <option value="A" {{ $currentFlag == 'A' ? 'selected' : '' }}>A (Abnormal)</option>
                                                </select>
                                            </td>

                                            <td class="align-middle fw-semibold" style="font-family: 'JetBrains Mono', monospace; font-size: 0.76rem;">
                                                {{ $param->nilai_normal ?? '-' }}
                                            </td>

                                            <td class="align-middle">
                                                <select name="metode[{{ $pem->detail_id }}][{{ $param->id }}]"
                                                    class="form-select form-select-sm select-metode ent-input {{ $hasValue ? 'res-filled' : '' }}"
                                                    data-code="{{ $param->id }}">
                                                    <option value="{{ $param->metode ?? '-' }}" selected>{{ $param->metode ?? '-' }}</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 opacity-75 fw-semibold">Tidak ada data pemeriksaan laboratorium.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function notifyResult(icon, title) {
            if (typeof Toast !== 'undefined' && Toast && typeof Toast.fire === 'function') {
                Toast.fire({ icon: icon, title: title });
            } else if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: icon, title: title, timer: 2000, showConfirmButton: false });
            } else {
                alert(title);
            }
        }

        function markResultFilled(code) {
            let inputEl = $('.input-hasil[data-code="' + code + '"]');
            let selectMetode = $('.select-metode[data-code="' + code + '"]');
            let selectFlag = $('.select-flag[data-code="' + code + '"]');
            let inputGroupText = inputEl.siblings('.input-group-text');

            inputEl.addClass('res-filled');
            selectMetode.addClass('res-filled');
            selectFlag.addClass('res-filled');
            inputGroupText.addClass('res-filled');
        }

        // --- SINKRONISASI ALAT ---
        $('#button-sinkronisasi-proses-result').off('click').on('click', function(e) {
            e.preventDefault();
            let btn = $(this);

            let orderLabListCode = btn.data('order-lab-list-code') || $('input[name="order_lab_list_code"]').val() || $('input[name="code"]').val();

            let listCodes = [];
            $('.select-metode').each(function() {
                let code = $(this).data('code');
                if (code) {
                    listCodes.push(code);
                }
            });

            if (listCodes.length === 0) {
                notifyResult('warning', 'Tidak ada parameter pemeriksaan yang dapat disinkronkan.');
                return;
            }

            if (!orderLabListCode) {
                notifyResult('error', 'Kode Order Lab List tidak ditemukan.');
                return;
            }

            let originalHtml = btn.html();
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyinkronkan...');

            $.ajax({
                url: "{{ route('menu_lab_proses_result_detail_sinkronisasi') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    code: orderLabListCode,
                    list_codes: listCodes
                },
                success: function(response) {
                    if (response.status === 'success') {
                        let updatedData = response.data || {};

                        $('.input-hasil').each(function() {
                            let code = $(this).data('code');

                            if (updatedData[code] !== undefined && updatedData[code] !== '') {
                                $(this).val(updatedData[code]);
                                markResultFilled(code);
                            }
                        });

                        notifyResult('success', response.message || 'Sinkronisasi alat berhasil.');
                    } else {
                        notifyResult('warning', response.message || 'Tidak ada data baru dari alat.');
                    }
                },
                error: function(xhr) {
                    let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan saat sinkronisasi.';
                    notifyResult('error', msg);
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalHtml);
                }
            });
        });

        // --- SIMPAN RESULT VIA AJAX (TANPA RELOAD) ---
        $('#button-simpan-proses-result').off('click').on('click', function(e) {
            e.preventDefault();

            let btn = $(this);
            let form = $('#form-result-pasien');
            let originalHtml = btn.html();

            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

            let formData = form.serialize();

            $.ajax({
                url: form.attr('action'),
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        let savedCodes = response.saved_codes || [];

                        savedCodes.forEach(function(code) {
                            markResultFilled(code);
                        });

                        notifyResult('success', response.message || 'Data hasil laboratorium berhasil disimpan.');
                    } else {
                        notifyResult('error', response.message || 'Gagal menyimpan data.');
                    }
                },
                error: function(xhr) {
                    let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan saat menyimpan data.';
                    notifyResult('error', msg);
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalHtml);
                }
            });
        });
    });
</script>
