<div class="card retro-card border-0 mb-0">
    <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: var(--retro-yellow); border-bottom: 3px solid var(--retro-dark);">
        <h5 class="mb-0 text-dark fw-bolder">
            <i class="fas fa-notes-medical me-2"></i> Form Handling Pasien IGD: <span class="text-danger">{{ $pasien->nama_pasien }}</span> (RM: {{ $pasien->pid }})
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="card-body p-4 bg-white">
        <!-- Informasi Singkat Pasien -->
        <div class="alert alert-light border border-dark mb-4 shadow-sm" style="border-radius: 8px;">
            <div class="row g-2 fs--1">
                <div class="col-md-3"><strong>No. Registrasi:</strong> <span class="text-danger fw-bold">{{ $pasien->no_registrasi }}</span></div>
                <div class="col-md-3"><strong>Tgl Masuk:</strong> {{ date('d/m/Y H:i', strtotime($pasien->tanggal_registrasi)) }}</div>
                <div class="col-md-3"><strong>Penjamin:</strong> {{ $pasien->nama_penjamin ?? 'Umum' }} - {{ $pasien->nama_sub_penjamin }}</div>
                <div class="col-md-3"><strong>Dokter Jaga:</strong> {{ $pasien->nama_dokter ?? '-' }}</div>
            </div>
        </div>

        <!-- Tab Navigasi Handling -->
        <ul class="nav nav-tabs border-0 mb-3" id="handlingTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold" id="triase-tab" data-bs-toggle="tab" data-bs-target="#triase-pane" type="button" role="tab">
                    <i class="fas fa-heartbeat me-1"></i> 1. Triase & TTV
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="soap-tab" data-bs-toggle="tab" data-bs-target="#soap-pane" type="button" role="tab">
                    <i class="fas fa-id-card me-1"></i> 2. Anamnesis (SOAP)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="tindakan-tab" data-bs-toggle="tab" data-bs-target="#tindakan-pane" type="button" role="tab">
                    <i class="fas fa-stethoscope me-1"></i> 3. Tindakan
                </button>
            </li>
            <!-- TAMBAHAN TAB E-RESEP OBAT -->
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="resep-tab" data-bs-toggle="tab" data-bs-target="#resep-pane" type="button" role="tab">
                    <i class="fas fa-pills me-1"></i> 4. E-Resep Obat
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="disposisi-tab" data-bs-toggle="tab" data-bs-target="#disposisi-pane" type="button" role="tab">
                    <i class="fas fa-door-open me-1"></i> 5. Disposisi
                </button>
            </li>
        </ul>

        <form id="form-handling-igd">
            @csrf
            <input type="hidden" name="registrasi_id" value="{{ $pasien->id }}">
            <input type="hidden" id="current_sub_penjamin_id" value="{{ $pasien->sub_penjamin_id }}">

            <div class="tab-content" id="handlingTabContent">
                <!-- PANE 1: TRIASE & TTV -->
                <div class="tab-pane fade show active" id="triase-pane" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark fs--1">Skala Triase</label>
                            <select class="form-select retro-input" name="skala_triage">
                                <option value="1" {{ optional($triase)->skala_triage == 1 ? 'selected' : '' }}>Level 1 - Resusitasi (Merah)</option>
                                <option value="2" {{ optional($triase)->skala_triage == 2 ? 'selected' : '' }}>Level 2 - Emergent (Kuning)</option>
                                <option value="3" {{ optional($triase)->skala_triage == 3 ? 'selected' : '' }}>Level 3 - Urgent (Hijau)</option>
                                <option value="4" {{ optional($triase)->skala_triage == 4 ? 'selected' : '' }}>Level 4 - Semi Urgent / Non Urgent</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-bold text-dark fs--1">Keluhan Utama</label>
                            <input type="text" class="form-control retro-input" name="keluhan_utama" value="{{ optional($triase)->keluhan_utama ?? $pasien->keluhan_medis }}" placeholder="Contoh: Nyeri dada sebelah kiri, sesak napas...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-dark fs--1">Tekanan Darah (mmHg)</label>
                            <input type="text" class="form-control retro-input" name="tekanan_darah" value="{{ optional($triase)->tekanan_darah }}" placeholder="120/80">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-dark fs--1">Nadi (x/menit)</label>
                            <input type="text" class="form-control retro-input" name="nadi" value="{{ optional($triase)->nadi }}" placeholder="80">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-dark fs--1">Suhu (°C)</label>
                            <input type="text" class="form-control retro-input" name="suhu" value="{{ optional($triase)->suhu }}" placeholder="36.5">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold text-dark fs--1">Saturasi Oksigen (%)</label>
                            <input type="text" class="form-control retro-input" name="saturasi_oksigen" value="{{ optional($triase)->saturasi_oksigen }}" placeholder="98">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Pernapasan (x/menit)</label>
                            <input type="text" class="form-control retro-input" name="pernapasan" value="{{ optional($triase)->pernapasan }}" placeholder="20">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Kesadaran (GCS / AVPU)</label>
                            <input type="text" class="form-control retro-input" name="kesadaran" value="{{ optional($triase)->kesadaran }}" placeholder="Compos Mentis (E4V5M6)">
                        </div>
                    </div>
                </div>

                <!-- PANE 2: ANAMNESIS SOAP -->
                <div class="tab-pane fade" id="soap-pane" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Subjektif (Anamnesis)</label>
                            <textarea class="form-control retro-input" name="subjektif" rows="3" placeholder="Keluhan tambahan riwayat penyakit...">{{ optional($soap)->subjektif }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Objektif (Pemeriksaan Fisik)</label>
                            <textarea class="form-control retro-input" name="objektif" rows="3" placeholder="Hasil pemeriksaan fisik organ...">{{ optional($soap)->objektif }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Asesmen (Diagnosis Kerja)</label>
                            <textarea class="form-control retro-input" name="asesmen" rows="3" placeholder="Diagnosis medis...">{{ optional($soap)->asesmen }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Planning (Rencana Terapi / Instruksi)</label>
                            <textarea class="form-control retro-input" name="planning" rows="3" placeholder="Rencana pengobatan, diet, atau observasi...">{{ optional($soap)->planning }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- PANE 3: TINDAKAN & LAYANAN -->
                <div class="tab-pane fade" id="tindakan-pane" role="tabpanel">
                    <div class="p-3 bg-light border border-dark rounded mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-plus-circle me-1"></i> Order Pemeriksaan & Tindakan IGD</h6>
                            <span class="badge bg-dark text-white fw-bold border border-secondary px-3 py-1">Tarif Berlaku: {{ $pasien->nama_sub_penjamin ?? 'UMUM' }}</span>
                        </div>

                        <div class="row g-3">
                            <!-- Pilih Pemeriksaan / Tindakan -->
                            <div class="col-md-9">
                                <label class="form-label fw-bold text-dark fs--1">Cari Pemeriksaan / Tindakan Medis</label>
                                <select class="form-select retro-input" id="select-master-tindakan" disabled>
                                    <option value="">-- Memuat Data Layanan... --</option>
                                </select>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <button type="button" class="btn retro-btn retro-btn-success w-100 fw-bold text-dark" id="btn-tambah-tindakan-list" style="height: 38px;">
                                    <i class="fas fa-plus me-1"></i> Tambah Tindakan
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm fs--1 table-custom align-middle mb-0" style="border: 2px solid var(--retro-dark);">
                            <thead class="table-dark" style="background-color: var(--retro-dark); color: var(--retro-green);">
                                <tr>
                                    <th class="py-2 px-3 text-start">Nama Tindakan / Pemeriksaan</th>
                                    <th class="py-2 px-3 text-end" style="width: 180px;">Tarif (Rp)</th>
                                    <th class="py-2 px-3 text-center" style="width: 70px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tindakan-terpilih-tbody" class="bg-white">
                                @forelse($tindakanList as $tindakan)
                                <tr data-id="{{ $tindakan->master_pemeriksaan_id }}" data-tarif="{{ $tindakan->tarif ?? 0 }}">
                                    <td class="fw-bold text-dark px-3 py-2">
                                        {{ $tindakan->nama_layanan }}
                                        <input type="hidden" name="tindakan_ids[]" value="{{ $tindakan->master_pemeriksaan_id }}">
                                        <input type="hidden" name="tarif_tindakan[]" value="{{ $tindakan->tarif ?? 0 }}">
                                    </td>
                                    <td class="text-end fw-bold text-dark px-3 py-2">Rp {{ number_format($tindakan->tarif ?? 0, 0, ',', '.') }}</td>
                                    <td class="text-center py-2">
                                        <button type="button" class="btn btn-sm btn-danger py-0 px-1 btn-hapus-tindakan fw-bold">x</button>
                                    </td>
                                </tr>
                                @empty
                                <tr id="empty-row-tindakan">
                                    <td colspan="3" class="text-center text-muted py-3 fw-bold">Belum ada tindakan atau pemeriksaan yang ditambahkan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-light">
                                <tr style="border-top: 3px solid var(--retro-dark);">
                                    <td class="text-end fw-bolder text-dark px-3 py-2 text-uppercase" style="font-size: 0.85rem;">Total Harga Tindakan:</td>
                                    <td class="text-end fw-bolder text-danger px-3 py-2" id="total-tarif-text" style="font-size: 0.9rem;">Rp 0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- PANE 4: E-RESEP OBAT -->
                <div class="tab-pane fade" id="resep-pane" role="tabpanel">
                    <div class="p-3 bg-light border border-dark rounded mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bolder text-dark mb-0"><i class="fas fa-plus-circle me-1"></i> Order E-Resep Obat IGD</h6>
                            <span class="badge bg-dark text-white fw-bold border border-secondary px-3 py-1">Harga: {{ $pasien->nama_sub_penjamin ?? 'UMUM' }}</span>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label fw-bold text-dark fs--1">Cari Obat Farmasi</label>
                                <select class="form-select retro-input" id="select-master-obat">
                                    <option value="">-- Cari atau Pilih Obat --</option>
                                    @foreach($daftarObat ?? [] as $obat)
                                    <option value="{{ $obat->farm_data_obat_code }}"
                                        data-nama="{{ $obat->farm_data_obat_name }}"
                                        data-satuan="{{ $obat->farm_data_obat_satuan }}"
                                        data-harga="{{ $obat->harga_jual }}">
                                        {{ $obat->farm_data_obat_name }} (Stok: {{ $obat->farm_data_obat_stok }}) - Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-bold text-dark fs--1">Jumlah (Qty)</label>
                                <input type="number" id="input_jumlah_obat" class="form-control retro-input text-center fw-bold" min="1" value="1">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark fs--1">Signa / Aturan Pakai</label>
                                <input type="text" id="input_signa_obat" class="form-control retro-input fw-bold" placeholder="Cth: 3 x 1">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn retro-btn retro-btn-warning w-100 fw-bold text-dark" id="btn-tambah-resep-list" style="height: 38px;">
                                    <i class="fas fa-plus me-1"></i> Resep
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm fs--1 table-custom align-middle mb-0" style="border: 2px solid var(--retro-dark);">
                            <thead class="table-dark" style="background-color: var(--retro-dark); color: var(--retro-yellow);">
                                <tr>
                                    <th class="py-2 px-3 text-start">Nama Obat</th>
                                    <th class="py-2 px-3 text-center" style="width: 80px;">Qty</th>
                                    <th class="py-2 px-3 text-start" style="width: 200px;">Aturan Pakai</th>
                                    <th class="py-2 px-3 text-end" style="width: 150px;">Subtotal (Rp)</th>
                                    <th class="py-2 px-3 text-center" style="width: 70px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="resep-terpilih-tbody" class="bg-white">
                                @forelse($resepList as $resep)
                                <tr data-code="{{ $resep->farm_data_obat_code }}">
                                    <td class="fw-bold text-dark px-3 py-2">
                                        {{ $resep->farm_data_obat_name ?? 'Obat Farmasi' }}
                                        <input type="hidden" name="resep_obat_code[]" value="{{ $resep->farm_data_obat_code }}">
                                        <input type="hidden" name="resep_harga[]" value="{{ $resep->harga ?? 0 }}">
                                    </td>
                                    <td class="text-center fw-bold text-dark px-3 py-2">
                                        {{ $resep->qty ?? 1 }} {{ $resep->farm_data_obat_satuan ?? '' }}
                                        <input type="hidden" name="resep_jumlah[]" value="{{ $resep->qty ?? 1 }}">
                                    </td>
                                    <td class="fw-bold text-dark px-3 py-2">
                                        {{ $resep->signa ?? '-' }}
                                        <input type="hidden" name="resep_signa[]" value="{{ $resep->signa ?? '-' }}">
                                    </td>
                                    <td class="text-end fw-bold text-dark px-3 py-2 subtotal-obat">
                                        Rp {{ number_format(($resep->qty ?? 1) * ($resep->harga ?? 0), 0, ',', '.') }}
                                    </td>
                                    <td class="text-center py-2">
                                        <button type="button" class="btn btn-sm btn-danger py-0 px-1 btn-hapus-obat fw-bold">x</button>
                                    </td>
                                </tr>
                                @empty
                                <tr id="empty-row-obat">
                                    <td colspan="5" class="text-center text-muted py-3 fw-bold">Belum ada resep obat yang ditambahkan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-light">
                                <tr style="border-top: 3px solid var(--retro-dark);">
                                    <td colspan="3" class="text-end fw-bolder text-dark px-3 py-2 text-uppercase" style="font-size: 0.85rem;">Total Harga Obat:</td>
                                    <td class="text-end fw-bolder text-danger px-3 py-2" id="total-obat-text" style="font-size: 0.9rem;">Rp 0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- PANE 5: DISPOSISI PASIEN -->
                <div class="tab-pane fade" id="disposisi-pane" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Status Kunjungan Akhir</label>
                            <select class="form-select retro-input" name="status_kunjungan">
                                <option value="PROSES" {{ $pasien->status_kunjungan == 'PROSES' ? 'selected' : '' }}>Dalam Penanganan / Observasi</option>
                                <option value="SELESAI" {{ $pasien->status_kunjungan == 'SELESAI' ? 'selected' : '' }}>Selesai / Pulang / Rawat Inap</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Tindak Lanjut / Disposisi (Verifikasi Akhir)</label>
                            <select class="form-select retro-input" id="select-tindak-lanjut" name="tindak_lanjut">
                                <option value="PULANG">Pulang (Berobat Jalan / Kontrol)</option>
                                <option value="RAWAT_INAP">Pindah Rawat Inap (Otomatis Masuk Ranap)</option>
                                <option value="RUJUK">Rujuk ke Rumah Sakit Lain</option>
                                <option value="MENINGGAL">Meninggal Dunia</option>
                            </select>
                        </div>
                        <div class="col-md-12" id="div-ruangan-inap" style="display: none;">
                            <label class="form-label fw-bold text-dark fs--1 text-danger fw-bold"><i class="fas fa-bed me-1"></i> Pilih Ruangan & Bed / Kasur Rawat Inap</label>
                            <select class="form-select retro-input border-danger" name="ruangan_bed_id">
                                <option value="">-- Pilih Bed / Kasur Kosong --</option>
                                @foreach($ruanganInap as $bed) <!-- Asumsikan variabel ini memuat data bed/ruangan -->
                                <option value="{{ $bed->id }}">{{ $bed->nama_ruangan ?? 'Bangsal' }} - Bed: {{ $bed->nomor_bed ?? $bed->id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold text-dark fs--1">Catatan / Edukasi Pulang / Alasan Masuk Ranap</label>
                            <textarea class="form-control retro-input" name="catatan_pulang" rows="3" placeholder="Instruksi dokter, indikasi rawat inap..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 pt-3 mt-4 border-top border-dark">
                <button type="button" class="btn retro-btn btn-light border border-dark btn-sm px-3 fw-bold text-dark" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn retro-btn retro-btn-success btn-sm px-4 fw-bold text-dark" id="btn-simpan-handling">Simpan Handling IGD</button>
            </div>
        </form>
    </div>
</div>

<script>
    if (typeof window.choicesTindakan === 'undefined') window.choicesTindakan = null;
    if (typeof window.choicesObat === 'undefined') window.choicesObat = null;

    window.cacheDataPemeriksaan = {}; // Cache tindakan medis
    window.cacheDataObat = {}; // Cache obat farmasi

    function initChoices(elementId, instanceName, placeholderText = "Pilih...") {
        const element = document.getElementById(elementId);
        if (element) {
            if (window[instanceName]) {
                window[instanceName].destroy();
                window[instanceName] = null;
            }

            window[instanceName] = new Choices(element, {
                searchEnabled: true,
                itemSelectText: '',
                placeholder: true,
                placeholderValue: placeholderText,
                shouldSort: false
            });
        }
    }

    // ==========================================
    // 1. LOGIKA TINDAKAN MEDIS IGD
    // ==========================================
    function hitungTotalTarif() {
        let total = 0;
        $('#tindakan-terpilih-tbody tr').each(function() {
            let tarif = parseFloat($(this).attr('data-tarif')) || 0;
            total += tarif;
        });
        $('#total-tarif-text').text('Rp ' + total.toLocaleString('id-ID'));
    }

    function loadLayananTarifIGD() {
        let subPenjaminId = $('#current_sub_penjamin_id').val();
        let tindakanSelect = $('#select-master-tindakan');

        if (window.choicesTindakan) {
            window.choicesTindakan.destroy();
            window.choicesTindakan = null;
        }

        tindakanSelect.html('<option value="">-- Memuat Layanan... --</option>').prop('disabled', true);
        window.cacheDataPemeriksaan = {};

        $.ajax({
            url: "{{ route('api.get.tarif.igd') }}",
            type: "GET",
            data: {
                sub_penjamin_id: subPenjaminId
            },
            success: function(response) {
                tindakanSelect.html('<option value="">-- Cari Layanan Medis / Tindakan IGD --</option>');

                if (response.data && response.data.length > 0) {
                    let existingIds = [];
                    $('#tindakan-terpilih-tbody tr').each(function() {
                        let tid = $(this).data('id');
                        if (tid) existingIds.push(String(tid));
                    });

                    response.data.forEach(function(item) {
                        let isDisabled = existingIds.includes(String(item.id)) ? 'disabled' : '';
                        let tarifVal = item.tarif ? Number(item.tarif) : 0;

                        window.cacheDataPemeriksaan[item.id] = {
                            nama: item.nama_pemeriksaan,
                            tarif: tarifVal
                        };

                        let labelText = `${item.nama_pemeriksaan} - Rp ${tarifVal.toLocaleString('id-ID')}`;
                        tindakanSelect.append(`<option value="${item.id}" ${isDisabled}>${labelText}</option>`);
                    });

                    tindakanSelect.prop('disabled', false);
                    initChoices('select-master-tindakan', 'choicesTindakan', 'Cari tindakan atau pemeriksaan...');
                } else {
                    tindakanSelect.html('<option value="">Tidak ada data layanan</option>');
                    initChoices('select-master-tindakan', 'choicesTindakan', 'Tidak ada data tersedia');
                }
            }
        });
    }

    $('#btn-tambah-tindakan-list').on('click', function(e) {
        e.preventDefault();

        let idTindakan = $('#select-master-tindakan').val();
        if (!idTindakan || idTindakan === "") {
            return Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih pemeriksaan atau tindakan terlebih dahulu!'
            });
        }

        let itemData = window.cacheDataPemeriksaan[idTindakan];
        let namaPemeriksaan = itemData ? itemData.nama : 'Pemeriksaan IGD';
        let tarifTindakan = itemData ? itemData.tarif : 0;

        let sudahAda = false;
        $('#tindakan-terpilih-tbody tr').each(function() {
            if ($(this).data('id') == idTindakan) sudahAda = true;
        });

        if (sudahAda) return Swal.fire({
            icon: 'error',
            title: 'Duplikasi',
            text: 'Pemeriksaan ini sudah ditambahkan!'
        });

        $('#empty-row-tindakan').remove();

        let htmlRow = `
            <tr data-id="${idTindakan}" data-tarif="${tarifTindakan}">
                <td class="fw-bold text-dark px-3 py-2">
                    ${namaPemeriksaan}
                    <input type="hidden" name="tindakan_ids[]" value="${idTindakan}">
                    <input type="hidden" name="tarif_tindakan[]" value="${tarifTindakan}">
                </td>
                <td class="text-end fw-bold text-dark px-3 py-2">Rp ${Number(tarifTindakan).toLocaleString('id-ID')}</td>
                <td class="text-center py-2">
                    <button type="button" class="btn btn-sm btn-danger py-0 px-1 btn-hapus-tindakan fw-bold">x</button>
                </td>
            </tr>
        `;
        $('#tindakan-terpilih-tbody').append(htmlRow);

        hitungTotalTarif();

        if (window.choicesTindakan) window.choicesTindakan.setChoiceByValue("");
        else $('#select-master-tindakan').val('').trigger('change');
    });

    $(document).on('click', '.btn-hapus-tindakan', function() {
        $(this).closest('tr').remove();
        if ($('#tindakan-terpilih-tbody tr').length === 0) {
            $('#tindakan-terpilih-tbody').html('<tr id="empty-row-tindakan"><td colspan="3" class="text-center text-muted py-3 fw-bold">Belum ada tindakan atau pemeriksaan yang ditambahkan.</td></tr>');
        }
        hitungTotalTarif();
    });

    // ==========================================
    // 2. LOGIKA E-RESEP OBAT IGD
    // ==========================================
    function hitungTotalObat() {
        let totalObat = 0;
        $('#resep-terpilih-tbody tr').each(function() {
            let harga = parseFloat($(this).find('input[name="resep_harga[]"]').val()) || 0;
            let qty = parseFloat($(this).find('input[name="resep_jumlah[]"]').val()) || 0;
            totalObat += (harga * qty);
        });
        $('#total-obat-text').text('Rp ' + totalObat.toLocaleString('id-ID'));
    }

    function setupCacheObat() {
        window.cacheDataObat = {};
        $('#select-master-obat option').each(function() {
            let code = $(this).val();
            if (code) {
                window.cacheDataObat[code] = {
                    nama: $(this).attr('data-nama'),
                    satuan: $(this).attr('data-satuan'),
                    harga: parseFloat($(this).attr('data-harga')) || 0
                };
            }
        });
    }

    $('#btn-tambah-resep-list').on('click', function(e) {
        e.preventDefault();

        let kodeObat = $('#select-master-obat').val();
        if (!kodeObat || kodeObat === "") {
            return Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih obat terlebih dahulu!'
            });
        }

        let obatData = window.cacheDataObat[kodeObat];
        let namaObat = obatData ? obatData.nama : 'Obat Farmasi';
        let satuanObat = obatData ? obatData.satuan : '';
        let hargaObat = obatData ? obatData.harga : 0;

        let qty = parseInt($('#input_jumlah_obat').val()) || 1;
        let signa = $('#input_signa_obat').val() || '-';
        let subtotal = hargaObat * qty;

        let sudahAda = false;
        $('#resep-terpilih-tbody tr').each(function() {
            if ($(this).data('code') == kodeObat) sudahAda = true;
        });

        if (sudahAda) return Swal.fire({
            icon: 'error',
            title: 'Duplikasi',
            text: 'Obat ini sudah diresepkan!'
        });

        $('#empty-row-obat').remove();

        let htmlRow = `
            <tr data-code="${kodeObat}">
                <td class="fw-bold text-dark px-3 py-2">
                    ${namaObat}
                    <input type="hidden" name="resep_obat_code[]" value="${kodeObat}">
                    <input type="hidden" name="resep_harga[]" value="${hargaObat}">
                </td>
                <td class="text-center fw-bold text-dark px-3 py-2">
                    ${qty} ${satuanObat}
                    <input type="hidden" name="resep_jumlah[]" value="${qty}">
                </td>
                <td class="fw-bold text-dark px-3 py-2">
                    ${signa}
                    <input type="hidden" name="resep_signa[]" value="${signa}">
                </td>
                <td class="text-end fw-bold text-dark px-3 py-2 subtotal-obat">Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td class="text-center py-2">
                    <button type="button" class="btn btn-sm btn-danger py-0 px-1 btn-hapus-obat fw-bold">x</button>
                </td>
            </tr>
        `;
        $('#resep-terpilih-tbody').append(htmlRow);

        hitungTotalObat();

        if (window.choicesObat) window.choicesObat.setChoiceByValue("");
        else $('#select-master-obat').val('').trigger('change');

        $('#input_jumlah_obat').val(1);
        $('#input_signa_obat').val('');
    });

    $(document).on('click', '.btn-hapus-obat', function() {
        $(this).closest('tr').remove();
        if ($('#resep-terpilih-tbody tr').length === 0) {
            $('#resep-terpilih-tbody').html('<tr id="empty-row-obat"><td colspan="5" class="text-center text-muted py-3 fw-bold">Belum ada resep obat yang ditambahkan.</td></tr>');
        }
        hitungTotalObat();
    });

    // ==========================================
    // 3. AJAX SIMPAN HANDLING IGD
    // ==========================================
    $(document).on('click', '#btn-simpan-handling', function(e) {
        e.preventDefault();

        let form = $('#form-handling-igd');
        let formData = form.serialize();
        let submitBtn = $(this);

        submitBtn.prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: "{{ route('igd.handling.store') }}",
            type: "POST",
            data: formData,
            dataType: 'json',
            success: function(response) {
                submitBtn.prop('disabled', false).text('Simpan Handling IGD');

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message || 'Data handling IGD berhasil disimpan.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Tutup modal dan refresh tabel data registrasi
                        $('#modalHandlingIgd').modal('hide'); // Sesuaikan ID modal wrapper Anda jika berbeda
                        if (typeof reloadTable === 'function') {
                            reloadTable();
                        } else {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message || 'Terjadi kesalahan saat menyimpan data.'
                    });
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).text('Simpan Handling IGD');

                let errorMessage = 'Terjadi kesalahan pada server.';
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    errorMessage = '';
                    $.each(errors, function(key, value) {
                        errorMessage += value[0] + '\n';
                    });
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: errorMessage
                });
            }
        });
    });

    // ==========================================
    // 4. INISIALISASI DOCUMENT READY
    // ==========================================
    $(document).ready(function() {
        hitungTotalTarif();
        hitungTotalObat();

        loadLayananTarifIGD();
        setupCacheObat();
        initChoices('select-master-obat', 'choicesObat', 'Cari obat farmasi...');

        // Tampilkan/Sembunyikan Pilihan Ruangan Inap berdasarkan Disposisi
        $('#select-tindak-lanjut').on('change', function() {
            if ($(this).val() === 'RAWAT_INAP') {
                $('#div-ruangan-inap').slideDown();
            } else {
                $('#div-ruangan-inap').slideUp();
                $('select[name="ruangan_tujuan_id"]').val('');
            }
        });
    });
</script>
