<div class="card mb-3">
    <div class="card-header bg-300 py-2">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Judul Header -->
            <h5 class="mb-0 fs-0 text-dark fw-bold">
                <i class="fas fa-user-check text-primary me-1"></i> Pasien Details No Reg: <span class="text-primary">{{ $code ?? '-' }}</span>
            </h5>

            <!-- Group Tombol Aksi Berwarna -->
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-info text-white shadow-sm fw-bold px-2 py-1 fs--1" id="button-sinkronisasi-proses-result">
                    <i class="fas fa-sync-alt me-1"></i> Sinkronisasi Alat
                </button>
                <button type="button" class="btn btn-sm btn-success text-white shadow-sm fw-bold px-3 py-1 fs--1" id="button-simpan-proses-result">
                    <i class="fas fa-check-circle me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
    <div class="card-body bg-light">

        <div class="row align-items-center">

            <!-- KIRI: Foto Pasien -->
            <div class="col-md-3 col-lg-2 text-center border-end-md mb-3 mb-md-0">
                <div class="avatar avatar-5lg mx-auto mb-2">
                    @if (empty($data->master_patient_profile ?? null))
                    <img src="{{ asset('img/pasien.png') }}" class="rounded-circle img-thumbnail shadow-sm" alt="Foto Pasien" style="width: 100px; height: 100px; object-fit: cover;">
                    @else
                    <img src="{{ Storage::url($data->master_patient_profile) }}" class="rounded-circle img-thumbnail shadow-sm" alt="Foto Pasien" style="width: 100px; height: 100px; object-fit: cover;">
                    @endif
                </div>
                <span class="badge bg-soft-primary text-primary fw-bold px-3 py-1 rounded-pill fs--2">
                    {{ $data->master_patient_code ?? '-' }}
                </span>
            </div>

            <!-- KANAN: Detail Informasi Pasien -->
            <div class="col-md-9 col-lg-10 ps-md-4">
                <!-- Nama Pasien Utama -->
                <div class="mb-3">
                    <h4 class="mb-0 text-dark fw-bold">{{ $data->master_patient_name ?? '-' }}</h4>
                    <small class="text-muted"><i class="fas fa-id-badge me-1"></i> NIK: <strong>{{ $data->master_patient_nik ?? '-' }}</strong></small>
                </div>

                <hr class="my-2 text-200">

                <!-- Informasi Ringkas Grid -->
                <div class="row g-2 fs--1 text-dark">
                    <div class="col-sm-6 col-md-4">
                        <div class="text-muted fs--2">No. Rekam Medis</div>
                        <div class="fw-semibold text-primary"><i class="fas fa-hashtag me-1"></i>{{ $data->master_patient_code ?? '-' }}</div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="text-muted fs--2">Jenis Kelamin</div>
                        <div class="fw-semibold">
                            @if(strtolower($data->master_patient_jk ?? '') == 'l' || strtolower($data->master_patient_jk ?? '') == 'laki-laki')
                            <i class="fas fa-mars text-info me-1"></i> Laki-laki
                            @elseif(strtolower($data->master_patient_jk ?? '') == 'p' || strtolower($data->master_patient_jk ?? '') == 'perempuan')
                            <i class="fas fa-venus text-danger me-1"></i> Perempuan
                            @else
                            <i class="fas fa-genderless me-1"></i> {{ $data->master_patient_jk ?? '-' }}
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4">
                        <div class="text-muted fs--2">Tanggal Lahir</div>
                        <div class="fw-semibold"><i class="fas fa-calendar-alt text-warning me-1"></i>{{ !empty($data->master_patient_tgl_lahir) ? date('d-m-Y', strtotime($data->master_patient_tgl_lahir)) : '-' }}</div>
                    </div>

                    <div class="col-sm-6 col-md-4 mt-2">
                        <div class="text-muted fs--2">Tempat Lahir</div>
                        <div class="fw-semibold"><i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $data->master_patient_tempat_lahir ?? '-' }}</div>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-3 border rounded">
            <form id="form-result-pasien" action="{{ route('menu_lab_proses_result_detail_proses_save') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="code" value="{{ $code ?? '' }}">

                <table class="table table-bordered fs--2 mb-0 border text-dark">
                    <thead class="bg-300">
                        <tr>
                            <th>Nama Pemeriksaan</th>
                            <th style="width: 25%;">Hasil ( Unit )</th>
                            <th style="width: 18%;">Flag</th>
                            <th style="width: 20%;">Nilai Normal</th>
                            <th style="width: 20%;">Metode</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark">
                        @forelse ($pemeriksaan ?? [] as $pem)
                        <!-- HEADER UTAMA PEMERIKSAAN -->
                        <tr class="bg-200 fw-bold">
                            <td colspan="5" class="py-2 text-primary">
                                <i class="fas fa-flask me-1"></i> {{ $pem->t_pemeriksaan_list_name ?? '-' }}
                            </td>
                        </tr>

                        @php
                        // Ambil parameter utama (parent_id is null) yang berelasi dengan master_pemeriksaan_id
                        $parameters = DB::table('medical_master_parameter')
                        ->where('master_pemeriksaan_id', $pem->t_pemeriksaan_list_code) // master_id dari tabel master pemeriksaan
                        ->whereNull('parent_id')
                        ->orderBy('urutan', 'ASC')
                        ->get();
                        @endphp

                        @foreach ($parameters as $param)
                        @if($param->is_group == 1)
                        <!-- JIKA INI KELOMPOK/SUB-HEADER (Contoh: Hitung Jenis) -->
                        <tr class="bg-100 fw-bold">
                            <td colspan="5" class="ps-3 py-2 text-dark">
                                <i class="fas fa-folder-open text-warning me-1"></i> {{ $param->nama_parameter }}
                            </td>
                        </tr>

                        @php
                        // Ambil sub-parameter di bawah kelompok ini
                        $subParameters = DB::table('medical_master_parameter')
                        ->where('parent_id', $param->id)
                        ->orderBy('urutan', 'ASC')
                        ->get();
                        @endphp

                        @foreach ($subParameters as $sub)
                        @php
                        // Cek apakah sudah ada riwayat nilai hasil tersimpan sebelumnya
                        $nilai = DB::table('medical_transaksi_hasil')
                        ->where('detail_id', $pem->detail_id)
                        ->where('parameter_id', $sub->id)
                        ->first();

                        $hasValue = $nilai && !empty($nilai->hasil);
                        $currentFlag = $nilai ? $nilai->flag : '*';
                        $currentCatatan = $nilai ? $nilai->catatan : '';
                        @endphp
                        <!-- RENDER SUB-PARAMETER (ANAKAN DENGAN INDENTASI) -->
                        <tr>
                            <td class="ps-4">
                                <i class="fas fa-level-up-alt fa-rotate-90 text-400 me-2"></i>
                                <span class="fw-semibold">{{ $sub->nama_parameter }}</span>
                            </td>
                            <td>
                                <div class="input-group has-validation">
                                    <input type="text"
                                        class="form-control form-control-sm input-hasil {{ $hasValue ? 'border-success bg-light-success' : '' }}"
                                        data-code="{{ $sub->id }}"
                                        name="hasil[{{ $pem->detail_id }}][{{ $sub->id }}]"
                                        value="{{ $hasValue ? $nilai->hasil : '' }}"
                                        placeholder="0.0">

                                    <span class="input-group-text {{ $hasValue ? 'border-success' : '' }} fs--2 py-0 px-2">
                                        {{ $sub->satuan ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            <!-- INPUT / SELECT FLAG -->
                            <td class="text-center align-middle">
                                <select name="flag[{{ $pem->detail_id }}][{{ $sub->id }}]"
                                    class="form-select form-select-sm fs--2 text-center select-flag {{ $hasValue ? 'border-success bg-light-success' : '' }}"
                                    data-code="{{ $sub->id }}">
                                    <option value="*" {{ $currentFlag == '*' ? 'selected' : '' }}>*</option>
                                    <option value="N" {{ $currentFlag == 'N' ? 'selected' : '' }}>N (Normal)</option>
                                    <option value="H" {{ $currentFlag == 'H' ? 'selected' : '' }}>H (High)</option>
                                    <option value="L" {{ $currentFlag == 'L' ? 'selected' : '' }}>L (Low)</option>
                                    <option value="A" {{ $currentFlag == 'A' ? 'selected' : '' }}>A (Abnormal)</option>
                                </select>
                            </td>

                            <td class="align-middle">{{ $sub->nilai_normal ?? '-' }}</td>
                            <td class="fs--2 align-middle">
                                <select name="metode[{{ $pem->detail_id }}][{{ $sub->id }}]"
                                    class="form-select form-select-sm fs--2 select-metode {{ $hasValue ? 'border-success bg-light-success' : '' }}"
                                    data-code="{{ $sub->id }}">
                                    <option value="{{ $sub->metode ?? '-' }}" selected>{{ $sub->metode ?? '-' }}</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach

                        @else
                        @php
                        // Cek riwayat hasil untuk parameter biasa
                        $nilai = DB::table('medical_transaksi_hasil')
                        ->where('detail_id', $pem->detail_id)
                        ->where('parameter_id', $param->id)
                        ->first();

                        $hasValue = $nilai && !empty($nilai->hasil);
                        $currentFlag = $nilai ? $nilai->flag : '*';
                        @endphp
                        <!-- RENDER PARAMETER BIASA / SINGLE -->
                        <tr>
                            <td class="ps-3 fw-bold">
                                {{ $param->nama_parameter }}
                            </td>
                            <td>
                                <div class="input-group has-validation">
                                    <input type="text"
                                        class="form-control form-control-sm input-hasil {{ $hasValue ? 'border-success bg-light-success' : '' }}"
                                        data-code="{{ $param->id }}"
                                        name="hasil[{{ $pem->detail_id }}][{{ $param->id }}]"
                                        value="{{ $hasValue ? $nilai->hasil : '' }}"
                                        placeholder="0.0">

                                    <span class="input-group-text {{ $hasValue ? 'border-success' : '' }} fs--2 py-0 px-2">
                                        {{ $param->satuan ?? '-' }}
                                    </span>
                                </div>
                            </td>

                            <!-- INPUT / SELECT FLAG -->
                            <td class="text-center align-middle">
                                <select name="flag[{{ $pem->detail_id }}][{{ $param->id }}]"
                                    class="form-select form-select-sm fs--2 text-center select-flag {{ $hasValue ? 'border-success bg-light-success' : '' }}"
                                    data-code="{{ $param->id }}">
                                    <option value="*" {{ $currentFlag == '*' ? 'selected' : '' }}>*</option>
                                    <option value="N" {{ $currentFlag == 'N' ? 'selected' : '' }}>N (Normal)</option>
                                    <option value="H" {{ $currentFlag == 'H' ? 'selected' : '' }}>H (High)</option>
                                    <option value="L" {{ $currentFlag == 'L' ? 'selected' : '' }}>L (Low)</option>
                                    <option value="A" {{ $currentFlag == 'A' ? 'selected' : '' }}>A (Abnormal)</option>
                                </select>
                            </td>

                            <td class="align-middle">{{ $param->nilai_normal ?? '-' }}</td>
                            <td class="fs--2 align-middle">
                                <select name="metode[{{ $pem->detail_id }}][{{ $param->id }}]"
                                    class="form-select form-select-sm fs--2 select-metode {{ $hasValue ? 'border-success bg-light-success' : '' }}"
                                    data-code="{{ $param->id }}">
                                    <option value="{{ $param->metode ?? '-' }}" selected>{{ $param->metode ?? '-' }}</option>
                                </select>
                            </td>
                        </tr>
                        @endif
                        @endforeach

                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-3 text-muted">Tidak ada data pemeriksaan laboratorium.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
