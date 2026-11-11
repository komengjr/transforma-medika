<style>
    /* Variabel Retro Lokal */
    .retro-modal-wrap {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-cyan: #8bf0fa;
        --retro-green: #c1ff72;
        --retro-purple: #c8b6ff;
        --retro-orange: #ff914d;
        --retro-pink: #ff66c4;
        --retro-bg: #f4f0ea;
        --retro-red: #ff4d4d;
        --retro-blue: #4d94ff;
        --retro-gray: #a6a6a6;
    }

    .retro-modal-wrap .card-retro {
        border: 3px solid var(--retro-dark);
        border-radius: 12px;
        box-shadow: 4px 4px 0px var(--retro-dark);
        background: #ffffff;
        margin-bottom: 1rem;
    }

    .retro-modal-wrap .input-group-text {
        background-color: var(--retro-bg);
        border: 2px solid var(--retro-dark);
        border-right: none;
        color: var(--retro-dark);
        font-weight: 800;
    }

    .retro-modal-wrap .form-control,
    .retro-modal-wrap .form-select {
        border: 2px solid var(--retro-dark) !important;
        background-color: #ffffff;
        font-weight: 700;
        color: var(--retro-dark);
    }

    .retro-modal-wrap .form-control:focus,
    .retro-modal-wrap .form-select:focus,
    .retro-modal-wrap textarea:focus {
        box-shadow: 3px 3px 0px var(--retro-dark);
        border-color: var(--retro-dark) !important;
    }

    .retro-modal-wrap .btn-retro {
        font-weight: 800;
        text-transform: uppercase;
        border: 2px solid var(--retro-dark);
        box-shadow: 3px 3px 0px var(--retro-dark);
        border-radius: 6px;
        transition: all 0.1s;
    }

    .retro-modal-wrap .btn-retro:hover {
        transform: translate(2px, 2px);
        box-shadow: 0px 0px 0px var(--retro-dark);
    }

    .retro-modal-wrap .form-header-retro {
        background-color: var(--retro-dark);
        color: #fff;
        padding: 10px 15px;
        font-weight: 800;
        text-transform: uppercase;
        border-bottom: 3px solid var(--retro-dark);
    }

    .retro-modal-wrap .table-retro th {
        background-color: var(--retro-dark);
        color: #fff;
        border: 2px solid var(--retro-dark);
        text-transform: uppercase;
        font-size: 0.85rem;
    }

    .retro-modal-wrap .table-retro td {
        border: 2px solid var(--retro-dark);
        font-weight: 700;
        vertical-align: middle;
    }

    /* ODONTOGRAM STYLES */
    .odontogram-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
        align-items: center;
        background-color: var(--retro-bg);
        padding: 20px;
        border: 3px solid var(--retro-dark);
        border-radius: 12px;
    }

    .odontogram-row {
        display: flex;
        gap: 20px;
    }

    .odontogram-quadrant {
        display: flex;
        gap: 5px;
    }

    .tooth-box {
        width: 35px;
        height: 45px;
        border: 2px solid var(--retro-dark);
        background-color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 0.85rem;
        color: var(--retro-dark);
        cursor: pointer;
        box-shadow: 2px 2px 0px var(--retro-dark);
        transition: all 0.1s;
        position: relative;
    }

    .tooth-box:hover {
        transform: translate(-2px, -2px);
        box-shadow: 4px 4px 0px var(--retro-dark);
    }

    .tooth-normal {
        background-color: #ffffff;
        color: var(--retro-dark);
        text-shadow: none;
        background-image: none !important;
    }

    /* Custom Checkbox dalam SweetAlert */
    .swal2-html-container .form-check-input {
        border: 2px solid var(--retro-dark);
        cursor: pointer;
    }

    .swal2-html-container .form-check-input:checked {
        background-color: var(--retro-green);
        border-color: var(--retro-dark);
    }
</style>

<div class="modal-body p-0 retro-modal-wrap" style="background-color: var(--retro-bg);">
    <div class="card-retro">
        <div class="py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: var(--retro-cyan); border-bottom: 3px solid var(--retro-dark);">
            <div>
                <h4 class="mb-0 text-dark fw-bolder d-flex align-items-center">
                    <i class="fas fa-notes-medical me-2"></i> Handling: {{ $data->m_poli_name ?? 'Poliklinik' }}
                </h4>
                <span class="badge bg-white text-dark mt-1 border border-dark fw-bold">Template Aktif: {{ $template_type }}</span>
            </div>
            <div class="text-end">
                <span class="badge bg-warning text-dark px-3 py-2 fw-bolder" style="border: 2px solid var(--retro-dark); box-shadow: 2px 2px 0px var(--retro-dark);">
                    <i class="fas fa-hashtag me-1"></i> {{ $data->no_registrasi }}
                </span>
            </div>
        </div>

        <div class="p-4">
            <div class="row g-4">
                <!-- IDENTITAS PASIEN -->
                <div class="col-12">
                    <div class="card-retro p-0">
                        <div class="row g-0">
                           <div class="col-md-2 d-flex align-items-center justify-content-center p-3 border-end border-dark border-3" style="background-color: var(--retro-yellow);">
                                @if (empty($data->master_patient_profile))
                                    <img src="{{ asset('img/pasien.png') }}" class="rounded-circle" alt="Foto Pasien" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid var(--retro-dark);">
                                @else
                                    <!-- Render string Base64 langsung ke dalam atribut src -->
                                    <img src="{{ $data->master_patient_profile }}" class="rounded-circle" alt="Foto Pasien" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid var(--retro-dark);">
                                @endif
                            </div>
                            <div class="col-md-10 p-3">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fs--1 fw-bold text-dark mb-1">Nama Pasien</label>
                                        <div class="fw-bolder fs-5 text-dark">{{ $data->master_patient_name }}</div>
                                        <div class="fs--1 fw-bold opacity-75">RM: {{ $data->master_patient_code }}</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fs--1 fw-bold text-dark mb-1">Gender & Tgl Lahir</label>
                                        <div class="fw-bold text-dark">{{ $data->master_patient_jk == 'L' ? 'Laki-Laki' : 'Perempuan' }}</div>
                                        <div class="fw-bold text-dark">{{ $data->master_patient_tgl_lahir }}</div>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label fs--1 fw-bold text-dark mb-1">Dokter & Penjamin</label>
                                        <div class="fw-bolder text-dark"><i class="fas fa-user-md me-1"></i> {{ $data->master_doctor_name ?? 'Belum Ditentukan' }}</div>
                                        <div class="mt-1">
                                            <span class="badge text-dark border border-dark fw-bold" style="background-color: var(--retro-green);">
                                                <i class="fas fa-shield-alt me-1"></i> {{ $data->nama_penjamin ?? 'UMUM' }}
                                                {{ !empty($data->nama_sub_penjamin) ? ' - ' . $data->nama_sub_penjamin : '' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FORM TEMPLATE -->
                <div class="col-12">
                    <form id="form-handling-medis">
                        @csrf
                        <input type="hidden" name="no_registrasi" value="{{ $code }}">
                        <input type="hidden" name="jenis_template" value="{{ $template_type }}">

                        @if(!empty($data->instruksi_poli))
                        <div class="alert alert-warning border-dark border-3 fw-bold text-dark" style="box-shadow: 3px 3px 0px var(--retro-dark);">
                            <i class="fas fa-info-circle me-2"></i> Instruksi: {{ $data->instruksi_poli }}
                        </div>
                        @endif

                        <!-- 1. ODONTOGRAM (MUNCUL JIKA DICENTANG DI TEMPLATE & TIPE GIGI) -->
                        @if($template_type === 'GIGI' && in_array('odontogram', $menu_aktif))
                        <div class="card-retro mb-4">
                            <div class="form-header-retro" style="background-color: var(--retro-orange); color: var(--retro-dark);">
                                <i class="fas fa-tooth me-2"></i> Odontogram Interaktif & Asesmen Gigi
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="odontogram-container">
                                            <h6 class="fw-bolder text-dark mb-2 border-bottom border-dark pb-1 text-uppercase">RAHANG ATAS</h6>
                                            <div class="odontogram-row">
                                                <div class="odontogram-quadrant" id="quadrant-1">
                                                    @foreach(range(18, 11) as $tooth)
                                                    <div class="tooth-box tooth-normal" data-tooth="{{ $tooth }}"><span class="tooth-num">{{ $tooth }}</span></div>
                                                    <input type="hidden" name="gigi[{{ $tooth }}]" id="input-gigi-{{ $tooth }}" value="NORMAL">
                                                    @endforeach
                                                </div>
                                                <div style="width: 4px; background-color: var(--retro-dark);"></div>
                                                <div class="odontogram-quadrant" id="quadrant-2">
                                                    @foreach(range(21, 28) as $tooth)
                                                    <div class="tooth-box tooth-normal" data-tooth="{{ $tooth }}"><span class="tooth-num">{{ $tooth }}</span></div>
                                                    <input type="hidden" name="gigi[{{ $tooth }}]" id="input-gigi-{{ $tooth }}" value="NORMAL">
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div style="height: 4px; width: 100%; background-color: var(--retro-dark); margin: 5px 0;"></div>
                                            <div class="odontogram-row">
                                                <div class="odontogram-quadrant" id="quadrant-4">
                                                    @foreach(range(48, 41) as $tooth)
                                                    <div class="tooth-box tooth-normal" data-tooth="{{ $tooth }}"><span class="tooth-num">{{ $tooth }}</span></div>
                                                    <input type="hidden" name="gigi[{{ $tooth }}]" id="input-gigi-{{ $tooth }}" value="NORMAL">
                                                    @endforeach
                                                </div>
                                                <div style="width: 4px; background-color: var(--retro-dark);"></div>
                                                <div class="odontogram-quadrant" id="quadrant-3">
                                                    @foreach(range(31, 38) as $tooth)
                                                    <div class="tooth-box tooth-normal" data-tooth="{{ $tooth }}"><span class="tooth-num">{{ $tooth }}</span></div>
                                                    <input type="hidden" name="gigi[{{ $tooth }}]" id="input-gigi-{{ $tooth }}" value="NORMAL">
                                                    @endforeach
                                                </div>
                                            </div>
                                            <h6 class="fw-bolder text-dark mt-2 border-top border-dark pt-1 text-uppercase">RAHANG BAWAH</h6>
                                        </div>
                                        <div class="d-flex justify-content-center gap-3 mt-3 flex-wrap">
                                            <div class="d-flex align-items-center gap-1"><span style="display:inline-block; width:15px; height:15px; border:2px solid var(--retro-dark); background:#fff;"></span> <span class="fw-bold fs--1">Normal</span></div>
                                            <div class="d-flex align-items-center gap-1"><span style="display:inline-block; width:15px; height:15px; border:2px solid var(--retro-dark); background:var(--retro-red);"></span> <span class="fw-bold fs--1">Karies/Lubang</span></div>
                                            <div class="d-flex align-items-center gap-1"><span style="display:inline-block; width:15px; height:15px; border:2px solid var(--retro-dark); background:var(--retro-blue);"></span> <span class="fw-bold fs--1">Tumpatan/Tambal</span></div>
                                            <div class="d-flex align-items-center gap-1"><span style="display:inline-block; width:15px; height:15px; border:2px solid var(--retro-dark); background:var(--retro-dark);"></span> <span class="fw-bold fs--1">Hilang/Cabut</span></div>
                                            <div class="d-flex align-items-center gap-1"><span style="display:inline-block; width:15px; height:15px; border:2px solid var(--retro-dark); background:var(--retro-gray);"></span> <span class="fw-bold fs--1">Sisa Akar</span></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="fw-bold text-dark mb-1">Kalkulus / Karang Gigi</label>
                                        <select class="form-select form-select-retro" name="gigi_kalkulus">
                                            <option value="TIDAK_ADA">Tidak Ada</option>
                                            <option value="RINGAN">Ringan</option>
                                            <option value="SEDANG">Sedang</option>
                                            <option value="BERAT">Berat</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fw-bold text-dark mb-1">Catatan Khusus Gigi Utama</label>
                                        <textarea class="form-control form-control-retro" rows="2" name="keluhan_gigi"></textarea>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label class="fw-bold text-dark mb-1">Rincian Tindakan per Gigi</label>
                                        <table class="table table-retro w-100 mb-0" id="tabel-log-gigi">
                                            <thead>
                                                <tr>
                                                    <th width="15%" class="text-center">No Gigi</th>
                                                    <th width="35%">Kondisi / Diagnosa (Multiple)</th>
                                                    <th width="50%">Catatan / Rencana Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- 2. ANAMNESA (MUNCUL JIKA DICENTANG DI MENU_AKTIF) -->
                        @if(in_array('anamnesa', $menu_aktif))
                        <div class="card-retro mb-4">
                            <div class="form-header-retro" style="background-color: var(--retro-cyan); color: var(--retro-dark);">
                                <i class="fas fa-comment-medical me-2"></i> Anamnesa & Riwayat Medis Pasien
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark mb-1">Keluhan Utama <span class="text-danger">*</span></label>
                                        <textarea name="keluhan_utama" class="form-control form-control-retro" rows="2" placeholder="Tuliskan keluhan utama secara rinci...">{{ $existing_anamnesa->keluhan_utama ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark mb-1">Riwayat Penyakit Sekarang</label>
                                        <textarea name="riwayat_penyakit_sekarang" class="form-control form-control-retro" rows="2" placeholder="Perjalanan penyakit saat ini...">{{ $existing_anamnesa->riwayat_penyakit_sekarang ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark mb-1">Riwayat Penyakit Dahulu</label>
                                        <textarea name="riwayat_penyakit_dahulu" class="form-control form-control-retro" rows="2" placeholder="Contoh: Hipertensi, Diabetes, Asma...">{{ $existing_anamnesa->riwayat_penyakit_dahulu ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark mb-1">Riwayat Penyakit Keluarga</label>
                                        <input type="text" name="riwayat_penyakit_keluarga" class="form-control form-control-retro" value="{{ $existing_anamnesa->riwayat_penyakit_keluarga ?? '' }}" placeholder="Penyakit turunan/menular dalam keluarga">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark mb-1">Riwayat Alergi</label>
                                        <input type="text" name="riwayat_alergi" class="form-control form-control-retro" value="{{ $existing_anamnesa->riwayat_alergi ?? '' }}" placeholder="Alergi obat, makanan, dll">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark mb-1">Riwayat Penggunaan Obat</label>
                                        <input type="text" name="riwayat_penggunaan_obat" class="form-control form-control-retro" value="{{ $existing_anamnesa->riwayat_penggunaan_obat ?? '' }}" placeholder="Obat yang sedang rutin dikonsumsi">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- 3. VITAL SIGN (MUNCUL JIKA DICENTANG DI MENU_AKTIF) -->
                        @if(in_array('vital_sign', $menu_aktif))
                        <div class="card-retro mb-4">
                            <div class="form-header-retro" style="background-color: var(--retro-green); color: var(--retro-dark);">
                                <i class="fas fa-heartbeat me-2"></i> Fisik Umum & Tanda Vital (Vital Signs)
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold text-dark mb-1">Kesadaran</label>
                                        <select name="kesadaran" class="form-select form-select-retro">
                                            @php $kesadaranVal = $existing_vs->kesadaran ?? 'Compos Mentis'; @endphp
                                            <option value="Compos Mentis" {{ $kesadaranVal == 'Compos Mentis' ? 'selected' : '' }}>Compos Mentis (Sadar)</option>
                                            <option value="Apatis" {{ $kesadaranVal == 'Apatis' ? 'selected' : '' }}>Apatis</option>
                                            <option value="Delirium" {{ $kesadaranVal == 'Delirium' ? 'selected' : '' }}>Delirium</option>
                                            <option value="Somnolen" {{ $kesadaranVal == 'Somnolen' ? 'selected' : '' }}>Somnolen</option>
                                            <option value="Sopor" {{ $kesadaranVal == 'Sopor' ? 'selected' : '' }}>Sopor</option>
                                            <option value="Coma" {{ $kesadaranVal == 'Coma' ? 'selected' : '' }}>Coma</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold text-dark mb-1">Tekanan Darah (TD)</label>
                                        <div class="input-group">
                                            <input type="text" name="tekanan_darah" class="form-control form-control-retro" value="{{ $existing_vs->tekanan_darah ?? '' }}" placeholder="120/80">
                                            <span class="input-group-text" style="background-color: var(--retro-yellow);">mmHg</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold text-dark mb-1">Nadi</label>
                                        <div class="input-group">
                                            <input type="number" name="nadi" class="form-control form-control-retro" value="{{ $existing_vs->nadi ?? '' }}" placeholder="80">
                                            <span class="input-group-text" style="background-color: var(--retro-yellow);">x/min</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold text-dark mb-1">Suhu Tubuh</label>
                                        <div class="input-group">
                                            <input type="number" step="0.1" name="suhu" class="form-control form-control-retro" value="{{ $existing_vs->suhu ?? '' }}" placeholder="36.5">
                                            <span class="input-group-text" style="background-color: var(--retro-yellow);">&deg;C</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold text-dark mb-1">Pernapasan (RR)</label>
                                        <div class="input-group">
                                            <input type="number" name="pernapasan" class="form-control form-control-retro" value="{{ $existing_vs->pernapasan ?? '' }}" placeholder="20">
                                            <span class="input-group-text" style="background-color: var(--retro-yellow);">x/min</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold text-dark mb-1">Saturasi Oksigen (SpO2)</label>
                                        <div class="input-group">
                                            <input type="number" name="saturasi_o2" class="form-control form-control-retro" value="{{ $existing_vs->saturasi_o2 ?? '' }}" placeholder="98">
                                            <span class="input-group-text" style="background-color: var(--retro-yellow);">%</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold text-dark mb-1">Berat Badan (BB)</label>
                                        <div class="input-group">
                                            <input type="number" step="0.1" name="berat_badan" class="form-control form-control-retro" value="{{ $existing_vs->berat_badan ?? '' }}" placeholder="60">
                                            <span class="input-group-text" style="background-color: var(--retro-yellow);">Kg</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold text-dark mb-1">Tinggi Badan (TB)</label>
                                        <div class="input-group">
                                            <input type="number" step="0.1" name="tinggi_badan" class="form-control form-control-retro" value="{{ $existing_vs->tinggi_badan ?? '' }}" placeholder="170">
                                            <span class="input-group-text" style="background-color: var(--retro-yellow);">cm</span>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label class="form-label fw-bold text-dark mb-1">Pemeriksaan Fisik Lain / Status Generalis</label>
                                        <textarea name="pemeriksaan_fisik_lain" class="form-control form-control-retro" rows="2" placeholder="Catatan tambahan pemeriksaan fisik...">{{ $existing_vs->pemeriksaan_fisik_lain ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- 4. ORDER TINDAKAN (MUNCUL JIKA DICENTANG DI MENU_AKTIF) -->
                        @if(in_array('tindakan', $menu_aktif))
                        <div class="card-retro mb-4">
                            <div class="form-header-retro d-flex justify-content-between align-items-center" style="background-color: var(--retro-purple); color: var(--retro-dark);">
                                <span><i class="fas fa-vial me-2"></i> Order Pemeriksaan Lab / Rad / Tindakan Poli</span>
                                <span class="badge bg-white text-dark border-dark border px-2 py-1 fs--2">Tarif: {{ $data->nama_sub_penjamin ?? ($data->nama_penjamin ?? 'UMUM') }}</span>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="row g-2 mb-3">
                                    <div class="col-md-9">
                                        <label class="fw-bold text-dark mb-1">Cari Layanan / Tindakan</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            <select id="input_pemeriksaan" class="form-select form-select-retro">
                                                <option value="" disabled selected>Pilih Layanan / Tindakan...</option>
                                                @foreach($daftar_tindakan ?? [] as $tindakan)
                                                <option value="{{ $tindakan->id }}"
                                                    data-nama="{{ $tindakan->nama_layanan }}"
                                                    data-kategori="{{ $tindakan->kategori_tindakan }}"
                                                    data-harga="{{ $tindakan->harga_akhir }}">
                                                    [{{ $tindakan->kategori_tindakan }}] {{ $tindakan->nama_layanan }} - Rp {{ number_format($tindakan->harga_akhir, 0, ',', '.') }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary btn-retro w-100 text-dark" id="btn-tambah-pemeriksaan" style="background-color: var(--retro-cyan);">
                                            <i class="fas fa-plus"></i> Tambah Order
                                        </button>
                                    </div>
                                </div>
                                <table class="table table-retro w-100 mb-0" id="tabel-order-pemeriksaan">
                                    <thead>
                                        <tr>
                                            <th width="50%">Nama Tindakan / Pemeriksaan</th>
                                            <th width="20%">Kategori</th>
                                            <th width="20%">Tarif Akhir</th>
                                            <th width="10%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        @endif

                        <!-- 5. E-RESEP OBAT (MUNCUL JIKA DICENTANG DI MENU_AKTIF) -->
                        @if(in_array('resep', $menu_aktif))
                        <div class="card-retro mb-4">
                            <div class="form-header-retro d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow); color: var(--retro-dark);">
                                <span><i class="fas fa-pills me-2"></i> E-Resep Dokter (Order Obat)</span>
                                <span class="badge bg-white text-dark border-dark border px-2 py-1 fs--2">Harga: {{ $data->nama_sub_penjamin ?? ($data->nama_penjamin ?? 'UMUM') }}</span>
                            </div>
                            <div class="card-body p-4 bg-white">
                                <div class="row g-2 mb-3">
                                    <div class="col-md-4">
                                        <label class="fw-bold text-dark mb-1">Nama Obat</label>
                                        <select id="input_obat" class="form-select form-select-retro">
                                            <option value="" disabled selected>Pilih Obat...</option>
                                            @foreach($daftar_obat ?? [] as $obat)
                                            <option value="{{ $obat->farm_data_obat_code }}"
                                                data-nama="{{ $obat->farm_data_obat_name }}"
                                                data-satuan="{{ $obat->farm_data_obat_satuan }}"
                                                data-harga="{{ $obat->harga_jual }}"
                                                data-stok="{{ $obat->farm_data_obat_stok }}">
                                                {{ $obat->farm_data_obat_name }} (Stok: {{ $obat->farm_data_obat_stok }}) - Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="fw-bold text-dark mb-1">Jumlah</label>
                                        <input type="number" id="input_jumlah_obat" class="form-control form-control-retro" min="1" value="1">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fw-bold text-dark mb-1">Signa / Aturan Pakai</label>
                                        <input type="text" id="input_signa_obat" class="form-control form-control-retro" placeholder="3 x 1 sesudah makan">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-warning btn-retro w-100 text-dark" id="btn-tambah-resep" style="background-color: var(--retro-orange);">
                                            <i class="fas fa-plus"></i> Resep
                                        </button>
                                    </div>
                                </div>
                                <table class="table table-retro w-100 mb-0" id="tabel-resep-obat">
                                    <thead>
                                        <tr>
                                            <th width="35%">Nama Obat</th>
                                            <th width="15%" class="text-center">Jumlah</th>
                                            <th width="15%">Satuan / Harga</th>
                                            <th width="25%">Aturan Pakai</th>
                                            <th width="10%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        @endif

                        <!-- 6. DIAGNOSA AKHIR (MUNCUL JIKA DICENTANG DI MENU_AKTIF) -->
                        @if(in_array('diagnosa', $menu_aktif))
                        <div class="card-retro mb-4">
                            <div class="card-body p-4" style="background-color: #f1f1f1;">
                                <label class="fw-bolder text-dark mb-2 text-uppercase"><i class="fas fa-stethoscope me-1"></i> Diagnosa Utama Dokter</label>
                                <textarea name="diagnosa_akhir" class="form-control form-control-retro" rows="2" placeholder="Masukkan diagnosa medis akhir..." required></textarea>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>

                <!-- Footer Action Button -->
                <div class="col-12 mt-2 border-top border-dark pt-4 text-end">
                    <button type="button" class="btn btn-light btn-retro px-4 me-2 text-dark" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success btn-lg btn-retro px-5 text-dark" id="button-save-data-diagnosa-pasien-poli" style="background-color: var(--retro-green);">
                        <i class="fas fa-save me-2"></i> Simpan Hasil Pemeriksaan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // --- ODONTOGRAM LOGIC ---
    $('.tooth-box').click(async function() {
        const toothNo = $(this).data('tooth');
        const box = $(this);
        const inputHidden = $('#input-gigi-' + toothNo);
        const currentVals = inputHidden.val().split(',');

        const conditionOpts = {
            'KARIES': 'Karies (Berlubang)',
            'TAMBALAN': 'Tumpatan (Tambalan)',
            'HILANG': 'Hilang / Dicabut',
            'SISA_AKAR': 'Sisa Akar'
        };

        let htmlCheckboxes = '<div class="text-start px-3 mt-2"><div class="form-check mb-2"><input class="form-check-input swal-tooth-check" type="checkbox" value="NORMAL" id="check-NORMAL" ' + (currentVals.includes('NORMAL') ? 'checked' : '') + '><label class="form-check-label fw-bold" for="check-NORMAL">Normal / Sehat (Reset)</label></div><hr class="border-dark my-2">';
        for (const [val, label] of Object.entries(conditionOpts)) {
            let isChecked = currentVals.includes(val) ? 'checked' : '';
            htmlCheckboxes += `<div class="form-check mb-2"><input class="form-check-input swal-tooth-check" type="checkbox" value="${val}" id="check-${val}" ${isChecked}><label class="form-check-label fw-bold" for="check-${val}">${label}</label></div>`;
        }
        htmlCheckboxes += '</div>';

        const {
            value: selectedStatuses
        } = await Swal.fire({
            title: 'Diagnosa Gigi ' + toothNo,
            html: htmlCheckboxes,
            showCancelButton: true,
            confirmButtonText: 'Lanjut',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-retro btn-primary mx-1',
                cancelButton: 'btn btn-retro btn-light mx-1'
            },
            buttonsStyling: false,
            didOpen: () => {
                $('.swal-tooth-check').change(function() {
                    if ($(this).val() === 'NORMAL' && $(this).is(':checked')) $('.swal-tooth-check').not(this).prop('checked', false);
                    else if ($(this).val() !== 'NORMAL' && $(this).is(':checked')) $('#check-NORMAL').prop('checked', false);
                });
            },
            preConfirm: () => {
                let vals = [];
                $('.swal-tooth-check:checked').each(function() {
                    vals.push($(this).val());
                });
                if (vals.length === 0) {
                    Swal.showValidationMessage('Pilih minimal satu kondisi!');
                    return false;
                }
                return vals;
            }
        });

        if (selectedStatuses) {
            let catatan = '';
            if (!selectedStatuses.includes('NORMAL')) {
                let currentCatatan = $(`#catatan-gigi-${toothNo}`).val() || '';
                let labels = selectedStatuses.map(s => conditionOpts[s]).join(' + ');
                const {
                    value: textCatatan
                } = await Swal.fire({
                    title: 'Catatan Gigi ' + toothNo,
                    text: 'Kondisi: ' + labels,
                    input: 'text',
                    inputValue: currentCatatan,
                    inputPlaceholder: 'Rencana / Detail (Opsional)',
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Lewati',
                    customClass: {
                        confirmButton: 'btn btn-retro btn-success mx-1',
                        cancelButton: 'btn btn-retro btn-light mx-1'
                    },
                    buttonsStyling: false
                });
                catatan = textCatatan || '';
            }

            inputHidden.val(selectedStatuses.join(','));
            box.removeClass('tooth-normal').css({
                'background-image': 'none',
                'color': 'var(--retro-dark)',
                'text-shadow': 'none'
            });

            if (selectedStatuses.includes('NORMAL')) {
                box.addClass('tooth-normal').css('background-color', '#ffffff');
            } else {
                const colorMap = {
                    'KARIES': 'var(--retro-red)',
                    'TAMBALAN': 'var(--retro-blue)',
                    'HILANG': 'var(--retro-dark)',
                    'SISA_AKAR': 'var(--retro-gray)'
                };
                let activeColors = selectedStatuses.map(s => colorMap[s]);
                box.css({
                    'color': '#ffffff',
                    'text-shadow': '1px 1px 0px #000'
                });
                if (activeColors.length === 1) box.css('background-color', activeColors[0]);
                else {
                    let gradient = 'linear-gradient(135deg, ',
                        step = 100 / activeColors.length,
                        stops = [];
                    for (let i = 0; i < activeColors.length; i++) {
                        stops.push(`${activeColors[i]} ${i*step}%`);
                        stops.push(`${activeColors[i]} ${(i+1)*step}%`);
                    }
                    box.css('background-image', gradient + stops.join(', ') + ')');
                }
            }

            $('#log-gigi-' + toothNo).remove();
            if (!selectedStatuses.includes('NORMAL')) {
                let displayStatus = selectedStatuses.map(s => `<span class="badge bg-dark border border-light mx-1">${conditionOpts[s]}</span>`).join('');
                let row = `<tr id="log-gigi-${toothNo}"><td class="text-center fw-bolder fs-5 text-dark align-middle">${toothNo}</td><td class="align-middle">${displayStatus}</td><td class="align-middle"><input type="text" name="catatan_gigi[${toothNo}]" id="catatan-gigi-${toothNo}" class="form-control form-control-retro form-control-sm" value="${catatan}"></td></tr>`;
                $('#tabel-log-gigi tbody').append(row);
            }
        }
    });

    // --- ORDER PEMERIKSAAN DENGAN TARIF PENJAMIN ---
    $('#btn-tambah-pemeriksaan').click(function() {
        let select = $('#input_pemeriksaan option:selected');
        let id = select.val();
        let nama = select.data('nama');
        let kategori = select.data('kategori');
        let harga = select.data('harga'); // Mengambil harga dari data-harga option

        if (!id) return Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: 'Pilih pemeriksaan!'
        });

        let row = `
            <tr>
                <td>
                    ${nama}
                    <input type="hidden" name="order_pemeriksaan_id[]" value="${id}">
                    <input type="hidden" name="order_tarif[]" value="${harga}"> <!-- Menyimpan nilai tarif -->
                </td>
                <td><span class="badge bg-light text-dark border border-dark">${kategori}</span></td>
                <td>Rp ${parseInt(harga).toLocaleString('id-ID')}</td>
                <td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-retro text-dark btn-hapus-row"><i class="fas fa-trash"></i></button></td>
            </tr>`;
        $('#tabel-order-pemeriksaan tbody').append(row);
        $('#input_pemeriksaan').val('');
    });

    // --- TAMBAH E-RESEP ---
    $('#btn-tambah-resep').click(function() {
        let select = $('#input_obat option:selected');
        let kodeObat = select.val();
        let nama = select.data('nama');
        let satuan = select.data('satuan');
        let harga = select.data('harga');
        let stok = parseInt(select.data('stok') || 0);
        let jumlah = parseInt($('#input_jumlah_obat').val());
        let signa = $('#input_signa_obat').val();

        if (!kodeObat || !jumlah || !signa) {
            return Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih obat, isi jumlah dan aturan pakai!'
            });
        }

        if (jumlah > stok) {
            return Swal.fire({
                icon: 'error',
                title: 'Stok Tidak Cukup',
                text: `Stok obat saat ini tersisa ${stok} ${satuan}.`
            });
        }

        let row = `
            <tr>
                <td>
                    ${nama}
                    <input type="hidden" name="resep_obat_code[]" value="${kodeObat}">
                    <input type="hidden" name="resep_harga[]" value="${harga}">
                </td>
                <td class="text-center">
                    ${jumlah} ${satuan}
                    <input type="hidden" name="resep_jumlah[]" value="${jumlah}">
                </td>
                <td>Rp ${parseInt(harga * jumlah).toLocaleString('id-ID')}</td>
                <td>
                    ${signa}
                    <input type="hidden" name="resep_signa[]" value="${signa}">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger btn-retro text-dark btn-hapus-row"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`;

        $('#tabel-resep-obat tbody').append(row);
        $('#input_obat').val('');
        $('#input_jumlah_obat').val('1');
        $('#input_signa_obat').val('');
    });

    $(document).on('click', '.btn-hapus-row', function() {
        $(this).closest('tr').remove();
    });

    // --- SIMPAN FINAL ---
    $('#button-save-data-diagnosa-pasien-poli').click(function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Simpan Pemeriksaan?",
            text: "Data anamnesa, order tindakan, resep, dan diagnosa akan disimpan secara final.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            customClass: {
                confirmButton: 'btn btn-success btn-retro mx-2',
                cancelButton: 'btn btn-light btn-retro mx-2'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = $('#form-handling-medis').serialize();

                $.ajax({
                    url: "{{ route('store_handling_medis') }}",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Menyimpan...',
                            text: 'Mohon tunggu sebentar.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'btn btn-success btn-retro'
                                },
                                buttonsStyling: false
                            }).then(() => {
                                $('.modal').modal('hide');
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Terjadi kesalahan pada server.'
                        });
                    }
                });
            }
        });
    });
</script>
<script>
    // --- AUTOLOAD DATA LAMA JIKA SUDAH PERNAH DIISI ---
    $(document).ready(function() {
        @if(isset($existing_soap) && $existing_soap)
            // 1. Munculkan Diagnosa Akhir yang lama
            $('textarea[name="diagnosa_akhir"]').val("{{ $existing_soap->asesmen }}");

            // 2. Jika Poli Gigi, Load Odontogram lama dari JSON
            @if($template_type === 'GIGI' && !empty($existing_soap->data_spesifik_poli))
                let savedData = {!! $existing_soap->data_spesifik_poli !!};

                if (savedData.kalkulus) {
                    $('select[name="gigi_kalkulus"]').val(savedData.kalkulus);
                }

                if (savedData.gigi_status) {
                    for (const [toothNo, statusStr] of Object.entries(savedData.gigi_status)) {
                        if (statusStr !== 'NORMAL') {
                            let inputHidden = $('#input-gigi-' + toothNo);
                            inputHidden.val(statusStr);
                            let statuses = statusStr.split(',');
                            let box = $(`[data-tooth="${toothNo}"]`);

                            // Warnai kotak gigi
                            box.removeClass('tooth-normal');
                            const colorMap = {'KARIES': 'var(--retro-red)', 'TAMBALAN': 'var(--retro-blue)', 'HILANG': 'var(--retro-dark)', 'SISA_AKAR': 'var(--retro-gray)'};
                            let activeColors = statuses.map(s => colorMap[s]);
                            box.css({'color': '#ffffff', 'text-shadow': '1px 1px 0px #000'});

                            if(activeColors.length === 1) {
                                box.css('background-color', activeColors[0]);
                            } else {
                                let gradient = 'linear-gradient(135deg, ', step = 100 / activeColors.length, stops = [];
                                for(let i=0; i < activeColors.length; i++) {
                                    stops.push(`${activeColors[i]} ${i*step}%`);
                                    stops.push(`${activeColors[i]} ${(i+1)*step}%`);
                                }
                                box.css('background-image', gradient + stops.join(', ') + ')');
                            }

                            // Masukkan ke tabel rincian gigi
                            let conditionOpts = {'KARIES': 'Karies (Berlubang)', 'TAMBALAN': 'Tumpatan (Tambalan)', 'HILANG': 'Hilang / Dicabut', 'SISA_AKAR': 'Sisa Akar'};
                            let displayStatus = statuses.map(s => `<span class="badge bg-dark border border-light mx-1">${conditionOpts[s]}</span>`).join('');
                            let catatanVal = savedData.gigi_catatan[toothNo] || '';

                            let row = `<tr id="log-gigi-${toothNo}">
                                <td class="text-center fw-bolder fs-5 text-dark align-middle">${toothNo}</td>
                                <td class="align-middle">${displayStatus}</td>
                                <td class="align-middle"><input type="text" name="catatan_gigi[${toothNo}]" id="catatan-gigi-${toothNo}" class="form-control form-control-retro form-control-sm" value="${catatanVal}"></td>
                            </tr>`;
                            $('#tabel-log-gigi tbody').append(row);
                        }
                    }
                }
            @endif
        @endif

        // 3. Load Tabel Order Tindakan Lama
        @if(isset($existing_tindakan))
            @foreach($existing_tindakan as $tind)
                let rowTindakan = `
                    <tr>
                        <td>{{ $tind->nama_layanan }}<input type="hidden" name="order_pemeriksaan_id[]" value="{{ $tind->id }}"></td>
                        <td><span class="badge bg-light text-dark border border-dark">{{ $tind->kategori_tindakan }}</span></td>
                        <td>Rp {{ number_format($tind->tarif, 0, ',', '.') }}</td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-retro text-dark btn-hapus-row"><i class="fas fa-trash"></i></button></td>
                    </tr>`;
                $('#tabel-order-pemeriksaan tbody').append(rowTindakan);
            @endforeach
        @endif

        // 4. Load Tabel Resep Obat Lama
        @if(isset($existing_resep))
            @foreach($existing_resep as $rsp)
                let rowResep = `
                    <tr>
                        <td>
                            {{ $rsp->farm_data_obat_name }}
                            <input type="hidden" name="resep_obat_code[]" value="{{ $rsp->farm_data_obat_code }}">
                            <input type="hidden" name="resep_harga[]" value="{{ $rsp->harga }}">
                        </td>
                        <td class="text-center">
                            {{ $rsp->qty }} {{ $rsp->farm_data_obat_satuan }}
                            <input type="hidden" name="resep_jumlah[]" value="{{ $rsp->qty }}">
                        </td>
                        <td>Rp {{ number_format($rsp->harga * $rsp->qty, 0, ',', '.') }}</td>
                        <td>
                            {{ $rsp->signa }}
                            <input type="hidden" name="resep_signa[]" value="{{ $rsp->signa }}">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger btn-retro text-dark btn-hapus-row"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>`;
                $('#tabel-resep-obat tbody').append(rowResep);
            @endforeach
        @endif
    });
</script>
