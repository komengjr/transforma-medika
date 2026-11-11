<div class="card retro-card mb-4 overflow-hidden" style="border: var(--retro-border); box-shadow: var(--retro-shadow);">
    <!-- CARD HEADER -->
    <div class="card-header py-3 px-3 border-bottom border-dark d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow);">
        <!-- Judul Header -->
        <h6 class="mb-0 fs-0 text-dark fw-bolder">
            <i class="fas fa-user-check text-dark me-1"></i> Pasien Details No Reg: <span class="text-primary text-decoration-underline">{{ $code ?? '-' }}</span>
        </h6>

        <!-- Group Tombol Aksi Berwarna -->
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm retro-btn text-dark shadow-sm fw-bold px-2 py-1 fs--1" id="button-sinkronisasi-proses-result" style="background-color: var(--retro-cyan);">
                <i class="fas fa-sync-alt me-1"></i> Sinkronisasi Alat
            </button>
            <button type="button" class="btn btn-sm retro-btn retro-btn-success text-dark shadow-sm fw-bold px-3 py-1 fs--1" id="button-simpan-proses-result">
                <i class="fas fa-check-circle me-1"></i> Simpan
            </button>
        </div>
    </div>

    <!-- CARD BODY -->
    <div class="card-body bg-white p-3 p-md-4">

        <div class="row align-items-center">

            <!-- KIRI: Foto Pasien -->
            <div class="col-md-3 col-lg-2 text-center border-end-md mb-3 mb-md-0 border-dark" style="border-right-width: 2px !important;">
                <div class="mx-auto mb-2 overflow-hidden rounded-circle" style="width: 100px; height: 100px; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                    @if (empty($data->master_patient_profile ?? null))
                    <img src="{{ asset('img/pasien.png') }}" class="w-100 h-100 object-fit-cover" alt="Foto Pasien">
                    @else
                    <img src="{{ Storage::url($data->master_patient_profile) }}" class="w-100 h-100 object-fit-cover" alt="Foto Pasien">
                    @endif
                </div>
                <span class="retro-badge" style="background-color: var(--retro-cyan); color: var(--retro-dark);">
                    {{ $data->master_patient_code ?? '-' }}
                </span>
            </div>

            <!-- KANAN: Detail Informasi Pasien -->
            <div class="col-md-9 col-lg-10 ps-md-4">
                <!-- Nama Pasien Utama -->
                <div class="mb-3">
                    <h4 class="mb-1 text-dark fw-bolder">{{ $data->master_patient_name ?? '-' }}</h4>
                    <small class="text-dark fw-bold"><i class="fas fa-id-badge me-1 text-primary"></i> NIK: <strong>{{ $data->master_patient_nik ?? '-' }}</strong></small>
                </div>

                <hr class="border-dark my-2" style="border-width: 2px;">

                <!-- Informasi Ringkas Grid -->
                <div class="row g-2 fs--1 text-dark">
                    <div class="col-sm-6 col-md-4">
                        <div class="text-dark fw-bold fs--2">No. Rekam Medis</div>
                        <div class="fw-bolder text-primary"><i class="fas fa-hashtag me-1"></i>{{ $data->master_patient_code ?? '-' }}</div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="text-dark fw-bold fs--2">Jenis Kelamin</div>
                        <div class="fw-bolder">
                            @if(strtolower($data->master_patient_jk ?? '') == 'l' || strtolower($data->master_patient_jk ?? '') == 'laki-laki')
                            <i class="fas fa-mars text-primary me-1"></i> Laki-laki
                            @elseif(strtolower($data->master_patient_jk ?? '') == 'p' || strtolower($data->master_patient_jk ?? '') == 'perempuan')
                            <i class="fas fa-venus text-danger me-1"></i> Perempuan
                            @else
                            <i class="fas fa-genderless me-1"></i> {{ $data->master_patient_jk ?? '-' }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="text-dark fw-bold fs--2">Tanggal Lahir</div>
                        <div class="fw-bolder"><i class="fas fa-calendar-alt text-warning me-1"></i>{{ !empty($data->master_patient_tgl_lahir) ? date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}</div>
                    </div>

                    <div class="col-sm-6 col-md-4 mt-2">
                        <div class="text-dark fw-bold fs--2">Tempat Lahir</div>
                        <div class="fw-bolder"><i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $data->master_patient_tempat_lahir ?? '-' }}</div>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-4">
            <form id="form-result-pasien" action="{{ route('menu_lab_proses_result_detail_proses_save') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="code" value="{{ $code ?? '' }}">

                <!-- TABEL DENGAN GARIS TEGAS / BORDER GRID -->
                <div class="table-responsive">
                    <table class="table table-custom align-middle fs--2 mb-0 table-bordered text-dark" style="width: 100%; border: 2px solid var(--retro-dark);">
                        <thead style="background-color: var(--retro-dark); color: var(--retro-green);">
                            <tr>
                                <th style="border: 2px solid var(--retro-dark); color: var(--retro-green); font-weight: 800;">Nama Pemeriksaan</th>
                                <th style="width: 25%; border: 2px solid var(--retro-dark); color: var(--retro-green); font-weight: 800;">Hasil ( Unit )</th>
                                <th style="width: 18%; border: 2px solid var(--retro-dark); color: var(--retro-green); font-weight: 800;" class="text-center">Flag</th>
                                <th style="width: 20%; border: 2px solid var(--retro-dark); color: var(--retro-green); font-weight: 800;">Nilai Normal</th>
                                <th style="width: 20%; border: 2px solid var(--retro-dark); color: var(--retro-green); font-weight: 800;">Metode</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            @forelse ($pemeriksaan ?? [] as $pem)
                            <!-- HEADER UTAMA PEMERIKSAAN -->
                            <tr style="background-color: var(--retro-yellow); font-weight: 900;">
                                <td colspan="5" class="py-2 text-dark" style="border: 2px solid var(--retro-dark);">
                                    <i class="fas fa-flask me-1 text-dark"></i> {{ $pem->t_pemeriksaan_list_name ?? '-' }}
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
                            <!-- JIKA INI KELOMPOK/SUB-HEADER -->
                            <tr style="background-color: #f4f0ea; font-weight: 800;">
                                <td colspan="5" class="ps-3 py-2 text-dark" style="border: 2px solid var(--retro-dark);">
                                    <i class="fas fa-folder-open text-warning me-1"></i> {{ $param->nama_parameter }}
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
                            $currentCatatan = $nilai ? $nilai->catatan : '';
                            @endphp
                            <!-- RENDER SUB-PARAMETER -->
                            <tr style="background-color: #ffffff;">
                                <td class="ps-4" style="border: 2px solid var(--retro-dark);">
                                    <i class="fas fa-level-up-alt fa-rotate-90 text-dark me-2"></i>
                                    <span class="fw-bold text-dark">{{ $sub->nama_parameter }}</span>
                                </td>
                                <td style="border: 2px solid var(--retro-dark);">
                                    <div class="input-group has-validation">
                                        <input type="text"
                                            class="form-control form-control-sm input-hasil retro-input {{ $hasValue ? 'border-success bg-light-success' : '' }}"
                                            data-code="{{ $sub->id }}"
                                            name="hasil[{{ $pem->detail_id }}][{{ $sub->id }}]"
                                            value="{{ $hasValue ? $nilai->hasil : '' }}"
                                            placeholder="0.0">

                                        <span class="input-group-text {{ $hasValue ? 'border-success' : '' }} fs--2 py-0 px-2 fw-bold text-dark" style="border: 2px solid var(--retro-dark); background-color: var(--retro-bg);">
                                            {{ $sub->satuan ?? '-' }}
                                        </span>
                                    </div>
                                </td>

                                <!-- INPUT / SELECT FLAG -->
                                <td class="text-center align-middle" style="border: 2px solid var(--retro-dark);">
                                    <select name="flag[{{ $pem->detail_id }}][{{ $sub->id }}]"
                                        class="form-select form-select-sm fs--2 text-center select-flag retro-input {{ $hasValue ? 'border-success bg-light-success' : '' }}"
                                        data-code="{{ $sub->id }}">
                                        <option value="*" {{ $currentFlag == '*' ? 'selected' : '' }}>*</option>
                                        <option value="N" {{ $currentFlag == 'N' ? 'selected' : '' }}>N (Normal)</option>
                                        <option value="H" {{ $currentFlag == 'H' ? 'selected' : '' }}>H (High)</option>
                                        <option value="L" {{ $currentFlag == 'L' ? 'selected' : '' }}>L (Low)</option>
                                        <option value="A" {{ $currentFlag == 'A' ? 'selected' : '' }}>A (Abnormal)</option>
                                    </select>
                                </td>

                                <td class="align-middle fw-bold text-dark" style="border: 2px solid var(--retro-dark);">{{ $sub->nilai_normal ?? '-' }}</td>
                                <td class="fs--2 align-middle" style="border: 2px solid var(--retro-dark);">
                                    <select name="metode[{{ $pem->detail_id }}][{{ $sub->id }}]"
                                        class="form-select form-select-sm fs--2 select-metode retro-input {{ $hasValue ? 'border-success bg-light-success' : '' }}"
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
                            <!-- RENDER PARAMETER BIASA / SINGLE -->
                            <tr style="background-color: #ffffff;">
                                <td class="ps-3 fw-bolder text-dark" style="border: 2px solid var(--retro-dark);">
                                    {{ $param->nama_parameter }}
                                </td>
                                <td style="border: 2px solid var(--retro-dark);">
                                    <div class="input-group has-validation">
                                        <input type="text"
                                            class="form-control form-control-sm input-hasil retro-input {{ $hasValue ? 'border-success bg-light-success' : '' }}"
                                            data-code="{{ $param->id }}"
                                            name="hasil[{{ $pem->detail_id }}][{{ $param->id }}]"
                                            value="{{ $hasValue ? $nilai->hasil : '' }}"
                                            placeholder="0.0">

                                        <span class="input-group-text {{ $hasValue ? 'border-success' : '' }} fs--2 py-0 px-2 fw-bold text-dark" style="border: 2px solid var(--retro-dark); background-color: var(--retro-bg);">
                                            {{ $param->satuan ?? '-' }}
                                        </span>
                                    </div>
                                </td>

                                <!-- INPUT / SELECT FLAG -->
                                <td class="text-center align-middle" style="border: 2px solid var(--retro-dark);">
                                    <select name="flag[{{ $pem->detail_id }}][{{ $param->id }}]"
                                        class="form-select form-select-sm fs--2 text-center select-flag retro-input {{ $hasValue ? 'border-success bg-light-success' : '' }}"
                                        data-code="{{ $param->id }}">
                                        <option value="*" {{ $currentFlag == '*' ? 'selected' : '' }}>*</option>
                                        <option value="N" {{ $currentFlag == 'N' ? 'selected' : '' }}>N (Normal)</option>
                                        <option value="H" {{ $currentFlag == 'H' ? 'selected' : '' }}>H (High)</option>
                                        <option value="L" {{ $currentFlag == 'L' ? 'selected' : '' }}>L (Low)</option>
                                        <option value="A" {{ $currentFlag == 'A' ? 'selected' : '' }}>A (Abnormal)</option>
                                    </select>
                                </td>

                                <td class="align-middle fw-bold text-dark" style="border: 2px solid var(--retro-dark);">{{ $param->nilai_normal ?? '-' }}</td>
                                <td class="fs--2 align-middle" style="border: 2px solid var(--retro-dark);">
                                    <select name="metode[{{ $pem->detail_id }}][{{ $param->id }}]"
                                        class="form-select form-select-sm fs--2 select-metode retro-input {{ $hasValue ? 'border-success bg-light-success' : '' }}"
                                        data-code="{{ $param->id }}">
                                        <option value="{{ $param->metode ?? '-' }}" selected>{{ $param->metode ?? '-' }}</option>
                                    </select>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-3 text-dark fw-bold" style="border: 2px solid var(--retro-dark);">Tidak ada data pemeriksaan laboratorium.</td>
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
                alert('Tidak ada parameter pemeriksaan yang dapat disinkronkan.');
                return;
            }

            if (!orderLabListCode) {
                alert('Kode Order Lab List tidak ditemukan.');
                return;
            }

            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menyinkronkan...');

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
                                let inputEl = $(this);
                                let selectMetode = $('.select-metode[data-code="' + code + '"]');
                                let selectFlag = $('.select-flag[data-code="' + code + '"]');
                                let inputGroupText = inputEl.siblings('.input-group-text');

                                inputEl.val(updatedData[code]);
                                inputEl.addClass('border-success bg-light-success');
                                selectMetode.addClass('border-success bg-light-success');
                                selectFlag.addClass('border-success bg-light-success');
                                inputGroupText.addClass('border-success');
                            }
                        });

                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan saat sinkronisasi.';
                    alert(msg);
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="fas fa-sync-alt me-1"></i> Sinkronisasi Alat');
                }
            });
        });

        // --- SIMPAN RESULT VIA AJAX (TANPA RELOAD) ---
        $('#button-simpan-proses-result').off('click').on('click', function(e) {
            e.preventDefault();

            let btn = $(this);
            let form = $('#form-result-pasien');

            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');

            let formData = form.serialize();

            $.ajax({
                url: form.attr('action'),
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        let savedCodes = response.saved_codes || [];

                        savedCodes.forEach(function(code) {
                            let inputEl = $('.input-hasil[data-code="' + code + '"]');
                            let selectMetode = $('.select-metode[data-code="' + code + '"]');
                            let selectFlag = $('.select-flag[data-code="' + code + '"]');
                            let inputGroupText = inputEl.siblings('.input-group-text');

                            inputEl.addClass('border-success bg-light-success');
                            selectMetode.addClass('border-success bg-light-success');
                            selectFlag.addClass('border-success bg-light-success');
                            inputGroupText.addClass('border-success');
                        });

                        alert(response.message);
                    } else {
                        alert(response.message || 'Gagal menyimpan data.');
                    }
                },
                error: function(xhr) {
                    let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan saat menyimpan data.';
                    alert(msg);
                },
                complete: function() {
                    btn.prop('disabled', false).html('<i class="fas fa-check-circle me-1"></i> Simpan');
                }
            });
        });
    });
</script>
