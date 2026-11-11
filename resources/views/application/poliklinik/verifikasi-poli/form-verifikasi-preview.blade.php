<style>
    .retro-modal-wrap {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-cyan: #8bf0fa;
        --retro-green: #c1ff72;
        --retro-purple: #c8b6ff;
        --retro-orange: #ff914d;
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
    .retro-modal-wrap .form-control,
    .retro-modal-wrap .form-select {
        border: 2px solid var(--retro-dark) !important;
        background-color: #ffffff;
        font-weight: 700;
        color: var(--retro-dark);
    }
    .retro-modal-wrap .btn-retro {
        font-weight: 800;
        text-transform: uppercase;
        border: 2px solid var(--retro-dark);
        box-shadow: 3px 3px 0px var(--retro-dark);
        border-radius: 6px;
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
    .tooth-normal {
        background-color: #ffffff;
        color: var(--retro-dark);
        text-shadow: none;
        background-image: none !important;
    }
</style>

<div class="modal-body p-0 retro-modal-wrap" style="background-color: var(--retro-bg);">
    <div class="py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: var(--retro-purple); border-bottom: 3px solid var(--retro-dark);">
        <div>
            <h4 class="mb-0 text-dark fw-bolder d-flex align-items-center">
                <i class="fas fa-stethoscope me-2"></i> Pratinjau & Verifikasi: {{ $data->m_poli_name ?? 'Poliklinik' }}
            </h4>
            <span class="badge bg-white text-dark mt-1 border border-dark fw-bold">Template: {{ $template_type }}</span>
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
                                <img src="{{ asset('img/pasien.png') }}" class="rounded-circle" alt="Foto" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid var(--retro-dark);">
                            @else
                                <img src="{{ $data->master_patient_profile }}" class="rounded-circle" alt="Foto" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid var(--retro-dark);">
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

            <!-- FORM HANDLING PREVIEW -->
            <div class="col-12">
                <form id="form-handling-medis">
                    @csrf
                    <input type="hidden" name="no_registrasi" value="{{ $code }}">
                    <input type="hidden" name="jenis_template" value="{{ $template_type }}">

                    <!-- ODONTOGRAM PREVIEW (JIKA POLI GIGI & MENU AKTIF) -->
                    @if($template_type === 'GIGI' && in_array('odontogram', $menu_aktif))
                    <div class="card-retro mb-4">
                        <div class="form-header-retro" style="background-color: var(--retro-orange); color: var(--retro-dark);">
                            <i class="fas fa-tooth me-2"></i> Pratinjau Odontogram Interaktif & Asesmen Gigi
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
                                                <th width="35%">Kondisi / Diagnosa</th>
                                                <th width="50%">Catatan / Rencana</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- ANAMNESA PREVIEW -->
                    @if(in_array('anamnesa', $menu_aktif))
                    <div class="card-retro mb-4">
                        <div class="form-header-retro" style="background-color: var(--retro-cyan); color: var(--retro-dark);">
                            <i class="fas fa-comment-medical me-2"></i> Pratinjau Anamnesa & Riwayat Medis
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark mb-1">Keluhan Utama</label>
                                    <textarea name="keluhan_utama" class="form-control form-control-retro" rows="2">{{ $existing_anamnesa->keluhan_utama ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark mb-1">Riwayat Penyakit Sekarang</label>
                                    <textarea name="riwayat_penyakit_sekarang" class="form-control form-control-retro" rows="2">{{ $existing_anamnesa->riwayat_penyakit_sekarang ?? '' }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark mb-1">Riwayat Penyakit Dahulu</label>
                                    <textarea name="riwayat_penyakit_dahulu" class="form-control form-control-retro" rows="2">{{ $existing_anamnesa->riwayat_penyakit_dahulu ?? '' }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark mb-1">Riwayat Penyakit Keluarga</label>
                                    <input type="text" name="riwayat_penyakit_keluarga" class="form-control form-control-retro" value="{{ $existing_anamnesa->riwayat_penyakit_keluarga ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark mb-1">Riwayat Alergi</label>
                                    <input type="text" name="riwayat_alergi" class="form-control form-control-retro" value="{{ $existing_anamnesa->riwayat_alergi ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold text-dark mb-1">Riwayat Penggunaan Obat</label>
                                    <input type="text" name="riwayat_penggunaan_obat" class="form-control form-control-retro" value="{{ $existing_anamnesa->riwayat_penggunaan_obat ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- VITAL SIGN PREVIEW -->
                    @if(in_array('vital_sign', $menu_aktif))
                    <div class="card-retro mb-4">
                        <div class="form-header-retro" style="background-color: var(--retro-green); color: var(--retro-dark);">
                            <i class="fas fa-heartbeat me-2"></i> Pratinjau Tanda Vital & Fisik Umum
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold text-dark mb-1">Kesadaran</label>
                                    <select name="kesadaran" class="form-select form-select-retro">
                                        @php $kesadaranVal = $existing_vs->kesadaran ?? 'Compos Mentis'; @endphp
                                        <option value="Compos Mentis" {{ $kesadaranVal == 'Compos Mentis' ? 'selected' : '' }}>Compos Mentis</option>
                                        <option value="Apatis" {{ $kesadaranVal == 'Apatis' ? 'selected' : '' }}>Apatis</option>
                                        <option value="Delirium" {{ $kesadaranVal == 'Delirium' ? 'selected' : '' }}>Delirium</option>
                                        <option value="Somnolen" {{ $kesadaranVal == 'Somnolen' ? 'selected' : '' }}>Somnolen</option>
                                        <option value="Sopor" {{ $kesadaranVal == 'Sopor' ? 'selected' : '' }}>Sopor</option>
                                        <option value="Coma" {{ $kesadaranVal == 'Coma' ? 'selected' : '' }}>Coma</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold text-dark mb-1">Tekanan Darah (TD)</label>
                                    <input type="text" name="tekanan_darah" class="form-control form-control-retro" value="{{ $existing_vs->tekanan_darah ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold text-dark mb-1">Nadi</label>
                                    <input type="number" name="nadi" class="form-control form-control-retro" value="{{ $existing_vs->nadi ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold text-dark mb-1">Suhu Tubuh</label>
                                    <input type="number" step="0.1" name="suhu" class="form-control form-control-retro" value="{{ $existing_vs->suhu ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold text-dark mb-1">Pernapasan (RR)</label>
                                    <input type="number" name="pernapasan" class="form-control form-control-retro" value="{{ $existing_vs->pernapasan ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold text-dark mb-1">Saturasi O2</label>
                                    <input type="number" name="saturasi_o2" class="form-control form-control-retro" value="{{ $existing_vs->saturasi_o2 ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold text-dark mb-1">Berat Badan (BB)</label>
                                    <input type="number" step="0.1" name="berat_badan" class="form-control form-control-retro" value="{{ $existing_vs->berat_badan ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold text-dark mb-1">Tinggi Badan (TB)</label>
                                    <input type="number" step="0.1" name="tinggi_badan" class="form-control form-control-retro" value="{{ $existing_vs->tinggi_badan ?? '' }}">
                                </div>
                                <div class="col-12 mt-2">
                                    <label class="form-label fw-bold text-dark mb-1">Pemeriksaan Fisik Lain</label>
                                    <textarea name="pemeriksaan_fisik_lain" class="form-control form-control-retro" rows="2">{{ $existing_vs->pemeriksaan_fisik_lain ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- ORDER TINDAKAN PREVIEW -->
                    @if(in_array('tindakan', $menu_aktif))
                    <div class="card-retro mb-4">
                        <div class="form-header-retro" style="background-color: var(--retro-purple); color: var(--retro-dark);">
                            <i class="fas fa-vial me-2"></i> Pratinjau Order Tindakan / Pemeriksaan
                        </div>
                        <div class="card-body p-4 bg-white">
                            <table class="table table-retro w-100 mb-0">
                                <thead>
                                    <tr>
                                        <th width="60%">Nama Tindakan</th>
                                        <th width="20%">Kategori</th>
                                        <th width="20%">Tarif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($existing_tindakan ?? [] as $tind)
                                    <tr>
                                        <td>
                                            {{ $tind->nama_layanan }}
                                            <input type="hidden" name="order_pemeriksaan_id[]" value="{{ $tind->id }}">
                                            <input type="hidden" name="order_tarif[]" value="{{ $tind->tarif }}">
                                        </td>
                                        <td><span class="badge bg-light text-dark border border-dark">{{ $tind->kategori_tindakan }}</span></td>
                                        <td>Rp {{ number_format($tind->tarif, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Belum ada order tindakan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- E-RESEP PREVIEW -->
                    @if(in_array('resep', $menu_aktif))
                    <div class="card-retro mb-4">
                        <div class="form-header-retro" style="background-color: var(--retro-yellow); color: var(--retro-dark);">
                            <i class="fas fa-pills me-2"></i> Pratinjau E-Resep Obat
                        </div>
                        <div class="card-body p-4 bg-white">
                            <table class="table table-retro w-100 mb-0">
                                <thead>
                                    <tr>
                                        <th width="40%">Nama Obat</th>
                                        <th width="15%" class="text-center">Jumlah</th>
                                        <th width="20%">Subtotal Harga</th>
                                        <th width="25%">Aturan Pakai (Signa)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($existing_resep ?? [] as $rsp)
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
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada resep obat.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- DIAGNOSA AKHIR -->
                    @if(in_array('diagnosa', $menu_aktif))
                    <div class="card-retro mb-4">
                        <div class="card-body p-4" style="background-color: #f1f1f1;">
                            <label class="fw-bolder text-dark mb-2 text-uppercase"><i class="fas fa-stethoscope me-1"></i> Diagnosa Utama Dokter</label>
                            <textarea name="diagnosa_akhir" class="form-control form-control-retro" rows="2" required>{{ $existing_soap->asesmen ?? '' }}</textarea>
                        </div>
                    </div>
                    @endif
                </form>
            </div>

            <!-- Footer Action Button -->
            <div class="col-12 mt-2 border-top border-dark pt-4 text-end">
                <button type="button" class="btn btn-light btn-retro px-4 me-2 text-dark" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success btn-lg btn-retro px-5 text-dark" id="button-save-data-diagnosa-pasien-poli" style="background-color: var(--retro-green);">
                    <i class="fas fa-check-circle me-2"></i> Verifikasi & Setujui Pemeriksaan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // --- AUTOLOAD DATA LAMA PADA PRATINJAU (VERIFIKASI) ---
    $(document).ready(function() {
        @if(isset($existing_soap) && $existing_soap)
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

                            let conditionOpts = {'KARIES': 'Karies (Berlubang)', 'TAMBALAN': 'Tumpatan (Tambalan)', 'HILANG': 'Hilang / Dicabut', 'SISA_AKAR': 'Sisa Akar'};
                            let displayStatus = statuses.map(s => `<span class="badge bg-dark border border-light mx-1">${conditionOpts[s]}</span>`).join('');
                            let catatanVal = savedData.gigi_catatan[toothNo] || '';

                            let row = `<tr id="log-gigi-${toothNo}">
                                <td class="text-center fw-bolder fs-5 text-dark align-middle">${toothNo}</td>
                                <td class="align-middle">${displayStatus}</td>
                                <td class="align-middle"><input type="text" name="catatan_gigi[${toothNo}]" class="form-control form-control-retro form-control-sm" value="${catatanVal}"></td>
                            </tr>`;
                            $('#tabel-log-gigi tbody').append(row);
                        }
                    }
                }
            @endif
        @endif
    });
</script>
