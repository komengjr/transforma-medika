<div class="card mb-3">
    <div class="card-header bg-300">
        <div class="d-flex justify-content-between">
            <h5 class="mb-0">Pasien Details No Reg {{ $code }}</h5>

        </div>
    </div>
    <div class="card-body bg-light">
        <form>
            <div class="row g-3">
                <div class="col-md-2 d-flex justify-content-center">
                    <div class="avatar avatar-5lg shadow-sm justify-content-center">
                        <div class="h-100 w-100 overflow-hidden ">
                            @if ($data->master_patient_profile == "")
                            <img src="{{ asset('img/pasien.png') }}" class="img-thumbnail " alt="" id="videoPreview"
                                data-dz-thumbnail="data-dz-thumbnail">
                            @else
                            <img src="{{ Storage::url($data->master_patient_profile) }}" class="img-thumbnail " alt=""
                                id="videoPreview" data-dz-thumbnail="data-dz-thumbnail">
                            @endif
                        </div>

                    </div>

                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="inputLastName1" class="form-label text-primary">Nama Lengkap</label>
                            <div class="input-group"> <span class="input-group-text"><i
                                        class="fas fa-user-friends"></i></span>
                                <input type="text" name="nama"
                                    class="form-control form-control-lg border-start-0 bg-white"
                                    value="{{ $data->master_patient_name }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputLastName1" class="form-label text-youtube">NIK</label>
                            <div class="input-group"> <span class="input-group-text"><i
                                        class="fas fa-money-check"></i></span>
                                <input type="text" name="nik"
                                    class="form-control form-control-lg border-start-0 bg-white" id="nik"
                                    value="{{ $data->master_patient_nik }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputLastName1" class="form-label text-youtube">No Rekam
                                Medis</label>
                            <div class="input-group"> <span class="input-group-text"><i
                                        class="fas fa-money-check"></i></span>
                                <input type="text" name="nik"
                                    class="form-control form-control-lg border-start-0 bg-white" id="nik"
                                    value="{{ $data->master_patient_code }}" disabled>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <label for="inputLastName1" class="form-label text-youtube">Tanggal
                        Lahir</label>
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                        <input type="date" name="tgl_lahir" class="form-control form-control-lg bg-white border-start-0"
                            id="tgl_lahir" value="{{ $data->master_patient_tgl_lahir }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="inputLastName1" class="form-label text-youtube">Jenis
                        Kelamin</label>
                    <div class="input-group"> <span class="input-group-text"><i
                                class="fas fa-transgender fs-2"></i></span>
                        <input type="text" class="form-control form-control-lg bg-white border-start-0" id="tgl_lahir"
                            value="{{ $data->master_patient_jk }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="inputLastName1" class="form-label">Tempat Lahir</label>
                    <div class="input-group"> <span class="input-group-text"><i
                                class="fas fa-map-marked-alt"></i></span>
                        <input type="text" name="tempat_lahir"
                            class="form-control form-control-lg border-start-0 bg-white" id="inputLastName1"
                            value="{{ $data->master_patient_tempat_lahir }}" disabled>
                    </div>
                </div>
                <!-- <div class="col-md-4">
                    <label for="inputEmailAddress" class="form-label text-youtube">Agama</label>
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-pray fs-2"></i></span>
                        <input type="text" class="form-control form-control-lg bg-white border-start-0"
                            value="{{ $data->master_patient_agama }}" disabled>
                    </div>

                </div>
                <div class="col-md-4">
                    <label for="inputLastName2" class="form-label text-youtube">No Handphone</label>
                    <div class="input-group"> <span class="input-group-text"><i
                                class="fas fa-phone-square-alt"></i></span>
                        <input type="text" name="no_hp"
                            class="form-control form-control-lg border-start-0 bg-white" id="no_hp"
                            value="{{ $data->master_patient_no_hp }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="inputLastName2" class="form-label">Email</label>
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                        <input type="email" name="email"
                            class="form-control form-control-lg border-start-0 bg-white" id="inputLastName2"
                            value="{{ $data->master_patient_email }}" disabled>
                    </div>
                </div> -->

            </div>
        </form>
        <div class="card my-3 border border-warning">
            <div class="card-body d-flex justify-content-between ">
                <div>
                    <button class="btn btn-falcon-primary" id="button-sinkronisasi-proses-result">
                        <span class="far fa-save"></span> Sinkronisasi Alat
                    </button>
                </div>
                <div class="d-flex">
                    <button class="btn btn-falcon-primary" id="button-simpan-proses-result"><span
                            class="far fa-save"></span> Simpan</button>
                </div>
            </div>
        </div>
        <div class="mt-3 border rounded">
            <form id="form-result-pasien" action="{{ route('menu_lab_proses_result_simpan_sinkronisasi') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="text" name="code" value="{{ $code }}" hidden>

                <table class="table table-bordered fs--2 mb-0 border text-dark">
                    <thead class="bg-300">
                        <tr>
                            <th>Nama Pemeriksaan</th>
                            <th>Hasil ( Unit )</th>
                            <th>Flag</th>
                            <th>Nilai Normal</th>
                            <th>Metode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemeriksaan as $pem)
                        <tr>
                            <td colspan="5"><strong>{{$pem->t_pemeriksaan_list_name}}</strong></td>
                        </tr>
                        @php
                        $sub = DB::table('t_pemeriksaan_list_val')->where('t_pemeriksaan_list_code', $pem->t_pemeriksaan_list_code)->get();
                        @endphp

                        @foreach ($sub as $subs)
                        <tr>
                            <td>{{$subs->t_pem_list_val_name}}</td>
                            <td style="width: 20%;">
                                @php
                                $nilai = DB::table('h_reg_lab')
                                ->where('d_reg_order_lab_code', $code)
                                ->where('t_pem_list_val_code', $subs->t_pem_list_val_code)
                                ->first();

                                // Cek apakah sudah ada nilainya
                                $hasValue = $nilai && !empty($nilai->h_reg_lab_value);
                                @endphp

                                <div class="input-group has-validation">
                                    <!-- Tambahkan attribute disabled dan class border/bg-success jika $hasValue true -->
                                    <input type="text"
                                        class="form-control input-hasil {{ $hasValue ? 'border-success bg-light-success' : '' }}"
                                        data-code="{{ $subs->t_pem_list_val_code }}"
                                        name="hasil[{{ $subs->t_pem_list_val_code }}]"
                                        value="{{ $hasValue ? $nilai->h_reg_lab_value : '' }}"
                                        {{ $hasValue ? 'disabled' : '' }}>

                                    <span class="input-group-text {{ $hasValue ? 'border-success' : '' }} fs--2">{{$subs->t_pem_list_val_satuan}}</span>
                                </div>
                            </td>
                            <td>*</td>
                            <td>{{$subs->t_pem_list_val_rujukan}}</td>
                            <td class="fs--2">
                                <select name="metode[{{ $subs->t_pem_list_val_code }}]"
                                    class="form-control fs--2 select-metode {{ $hasValue ? 'border-success bg-light-success' : '' }}"
                                    data-code="{{ $subs->t_pem_list_val_code }}"
                                    {{ $hasValue ? 'disabled' : '' }}>
                                    <option value="{{ $nilai ? $nilai->h_reg_lab_metode : '-' }}">{{ $nilai ? $nilai->h_reg_lab_metode : '-' }}</option>
                                    <option value="RBC PULSE HEIGHT DETECTION">RBC PULSE HEIGHT DETECTION</option>
                                    <option value="RBC PULSE AJA">RBC PULUSE AJA</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#button-sinkronisasi-proses-result').on('click', function(e) {
            e.preventDefault();
            let btn = $(this);
            let codeLab = $('input[name="code"]').val();
            // 1. Ambil semua t_pem_list_val_code yang ADA HANYA DI HALAMAN INI
            let listCodes = [];
            $('.select-metode').each(function() {
                let code = $(this).data('code');
                if (code) {
                    listCodes.push(code);
                }
            });
            if (listCodes.length === 0) {
                alert('Tidak ada parameter pemeriksaan di halaman ini.');
                return;
            }
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menyinkronkan...');

            // 2. Kirim listCodes bersamaan dengan code lab
            $.ajax({
                url: "{{ route('menu_lab_proses_result_detail_sinkronisasi') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    code: codeLab,
                    list_codes: listCodes // Send array of codes on this page
                },
                success: function(response) {
                    if (response.status === 'success') {
                        let updatedData = response.data; // Objek [code => value]

                        $('.input-hasil').each(function() {
                            let code = $(this).data('code');

                            if (updatedData[code] !== undefined && updatedData[code] !== '') {
                                let inputEl = $(this);
                                let selectMetode = $('.select-metode[data-code="' + code + '"]');
                                let inputGroupText = inputEl.siblings('.input-group-text');

                                // Isi nilai
                                inputEl.val(updatedData[code]);

                                // Lock & Style
                                inputEl.prop('disabled', true);
                                selectMetode.prop('disabled', true);

                                inputEl.addClass('border-success bg-light-success');
                                selectMetode.addClass('border-success bg-light-success');
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
                    btn.prop('disabled', false).html('<span class="far fa-save"></span> Sinkronisasi Alat');
                }
            });
        });

        // Otomatis lepas disabled sejenak sebelum form disubmit agar data tetap ikut terkirim
        $('#form-result-pasien').on('submit', function() {
            $(this).find(':disabled').removeAttr('disabled');
        });

        $('#button-simpan-proses-result').on('click', function(e) {
            e.preventDefault();
            $('#form-result-pasien').submit();
        });

    });
</script>
