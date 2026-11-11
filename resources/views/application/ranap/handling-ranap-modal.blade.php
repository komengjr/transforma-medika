<div class="card retro-card border-0 mb-0">
    <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center" style="background-color: var(--retro-green); border-bottom: 3px solid var(--retro-dark);">
        <h5 class="mb-0 text-dark fw-bolder">
            <i class="fas fa-bed me-2"></i> Form Handling Pasien Rawat Inap: <span class="text-danger">{{ $pasien->nama_pasien }}</span> (RM: {{ $pasien->pid }})
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="card-body p-4 bg-white">
        <!-- Info Singkat Pasien & Penjamin -->
        <div class="alert alert-light border border-dark mb-4 shadow-sm" style="border-radius: 8px;">
            <div class="row g-2 fs--1">
                <div class="col-md-3"><strong>No. Registrasi:</strong> <span class="text-success fw-bold">{{ $pasien->no_registrasi }}</span></div>
                <div class="col-md-3"><strong>Tgl Masuk:</strong> {{ date('d/m/Y H:i', strtotime($pasien->tanggal_registrasi)) }}</div>
                <div class="col-md-3"><strong>Ruangan:</strong> {{ $pasien->nama_ruangan ?? '-' }} ({{ $pasien->nomor_bed }})</div>
                <div class="col-md-3"><strong>DPJP:</strong> {{ $pasien->nama_dokter ?? '-' }}</div>
                <div class="col-md-6 pt-2 border-top border-dark mt-2"><strong>Penjamin Utama:</strong> <span class="text-primary fw-bold">{{ $pasien->nama_penjamin ?? 'Umum / Mandiri' }}</span></div>
                <div class="col-md-6 pt-2 border-top border-dark mt-2"><strong>Sub Penjamin:</strong> <span class="text-danger fw-bold">{{ $pasien->nama_sub_penjamin ?? '-' }}</span></div>
            </div>
        </div>

        <!-- Tab Navigasi -->
        <ul class="nav nav-tabs border-0 mb-3" id="handlingRanapTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold" id="soap-ranap-tab" data-bs-toggle="tab" data-bs-target="#soap-ranap-pane" type="button" role="tab">
                    <i class="fas fa-id-card me-1"></i> 1. SOAP & Perkembangan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold" id="tindakan-ranap-tab" data-bs-toggle="tab" data-bs-target="#tindakan-ranap-pane" type="button" role="tab">
                    <i class="fas fa-stethoscope me-1"></i> 2. Tindakan & Visite
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold text-danger" id="resep-ranap-tab" data-bs-toggle="tab" data-bs-target="#resep-ranap-pane" type="button" role="tab">
                    <i class="fas fa-pills me-1"></i> 3. Order Resep / Obat Farmasi
                </button>
            </li>
        </ul>

        <form id="form-handling-ranap">
            @csrf
            <input type="hidden" name="registrasi_id" value="{{ $pasien->id }}">
            <input type="hidden" id="sub_penjamin_id" value="{{ $pasien->sub_penjamin_id }}">

            <div class="tab-content" id="handlingRanapTabContent">
                <!-- PANE 1: SOAP RANAP -->
                <div class="tab-pane fade show active" id="soap-ranap-pane" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Subjektif (Keluhan Harian)</label>
                            <textarea class="form-control retro-input" name="subjektif" rows="3" placeholder="Perkembangan keluhan pasien...">{{ optional($soap)->subjektif }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Objektif (Pemeriksaan Fisik & TTV)</label>
                            <textarea class="form-control retro-input" name="objektif" rows="3" placeholder="Keadaan umum, TTV, dll...">{{ optional($soap)->objektif }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Asesmen (Diagnosis Medis)</label>
                            <textarea class="form-control retro-input" name="asesmen" rows="3" placeholder="Diagnosis saat ini...">{{ optional($soap)->asesmen }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark fs--1">Planning (Instruksi / Terapi Lanjutan)</label>
                            <textarea class="form-control retro-input" name="planning" rows="3" placeholder="Instruksi cairan infus, obat, diet...">{{ optional($soap)->planning }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- PANE 2: TINDAKAN RANAP -->
                <div class="tab-pane fade" id="tindakan-ranap-pane" role="tabpanel">
                    <div class="p-3 bg-light border border-dark rounded mb-3">
                        <h6 class="fw-bolder text-dark mb-3"><i class="fas fa-hand-holding-medical me-1"></i> Penambahan Tindakan & Layanan (Menyesuaikan Penjamin Pasien)</h6>
                        <div class="row g-3">
                            <div class="col-md-10">
                                <label class="form-label fw-bold text-dark fs--1">Pilih Layanan, Tindakan & Jasa Dokter Visite</label>
                                <select class="form-select retro-input" id="select-master-tindakan-ranap">
                                    <option value="">-- Memuat Data Layanan --</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn retro-btn retro-btn-success w-100 fw-bold" id="btn-tambah-tindakan-ranap" style="height: 38px;">+ Tambah</button>
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
                            <tbody id="tindakan-ranap-tbody" class="bg-white">
                                @forelse($tindakanList as $tind)
                                <tr data-id="{{ $tind->master_pemeriksaan_id }}" data-tarif="{{ $tind->tarif ?? 0 }}">
                                    <td class="fw-bold text-dark px-3 py-2">
                                        {{ $tind->nama_layanan }}
                                        <input type="hidden" name="tindakan_ids[]" value="{{ $tind->master_pemeriksaan_id }}">
                                        <input type="hidden" name="tarif_tindakan[]" value="{{ $tind->tarif }}">
                                    </td>
                                    <td class="text-end fw-bold text-dark px-3 py-2">Rp {{ number_format($tind->tarif ?? 0, 0, ',', '.') }}</td>
                                    <td class="text-center py-2">
                                        <button type="button" class="btn btn-sm btn-danger py-0 px-1 btn-hapus-tindakan fw-bold">x</button>
                                    </td>
                                </tr>
                                @empty
                                <tr id="empty-row-ranap">
                                    <td colspan="3" class="text-center text-muted py-3 fw-bold">Belum ada tindakan yang ditambahkan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-light">
                                <tr style="border-top: 3px solid var(--retro-dark);">
                                    <td class="text-end fw-bolder text-dark px-3 py-2 text-uppercase">Total Keseluruhan Tarif:</td>
                                    <td class="text-end fw-bolder text-danger px-3 py-2" id="total-tarif-ranap-text">Rp 0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- PANE 3: ORDER RESEP / OBAT FARMASI -->
                <div class="tab-pane fade" id="resep-ranap-pane" role="tabpanel">
                    <div class="p-3 bg-light border border-dark rounded mb-3">
                        <h6 class="fw-bolder text-dark mb-3"><i class="fas fa-prescription-bottle-medical me-1"></i> Input Resep & Permintaan Obat ke Farmasi</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark fs--1">Pilih Master Obat</label>
                                <select class="form-select retro-input" id="select_obat_farmasi">
                                    <option value="">-- Pilih Obat --</option>
                                    @foreach($obatList as $obt)
                                    <option value="{{ $obt->farm_data_obat_code }}">
                                        [{{ $obt->farm_data_obat_code }}] {{ $obt->farm_data_obat_name }} - Rp {{ number_format($obt->harga_jual ?? 0, 0, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-bold text-dark fs--1">Jumlah (Qty)</label>
                                <input type="number" class="form-control retro-input text-center" id="qty_obat_resep" value="1" min="1">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold text-dark fs--1">Aturan Pakai / Signa</label>
                                <input type="text" class="form-control retro-input" id="signa_obat_resep" placeholder="Cth: 3 x 1 Tablet">
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn retro-btn retro-btn-success w-100 fw-bold" id="btn-tambah-resep-ranap" style="height: 38px;">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm fs--1 table-custom align-middle mb-0" style="border: 2px solid var(--retro-dark);">
                            <thead class="table-dark" style="background-color: var(--retro-dark); color: var(--retro-green);">
                                <tr>
                                    <th class="py-2 px-3 text-start">Nama Obat</th>
                                    <th class="py-2 px-3 text-center" style="width: 80px;">Qty</th>
                                    <th class="py-2 px-3 text-start" style="width: 200px;">Signa / Aturan Pakai</th>
                                    <th class="py-2 px-3 text-end" style="width: 140px;">Harga Satuan</th>
                                    <th class="py-2 px-3 text-end" style="width: 150px;">Subtotal</th>
                                    <th class="py-2 px-3 text-center" style="width: 70px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="resep-ranap-tbody" class="bg-white">
                                @forelse($resepList as $rsp)
                                <tr data-kode="{{ $rsp->farm_data_obat_code }}" data-qty="{{ $rsp->qty }}" data-harga="{{ $rsp->harga }}">
                                    <td class="fw-bold text-dark px-3 py-2">
                                        {{ $rsp->farm_data_obat_name }}
                                        <input type="hidden" name="resep_obat_code[]" value="{{ $rsp->farm_data_obat_code }}">
                                        <input type="hidden" name="resep_qty[]" value="{{ $rsp->qty }}">
                                        <input type="hidden" name="resep_signa[]" value="{{ $rsp->signa }}">
                                        <input type="hidden" name="resep_harga[]" value="{{ $rsp->harga }}">
                                    </td>
                                    <td class="text-center px-3 py-2">{{ $rsp->qty }}</td>
                                    <td class="px-3 py-2">{{ $rsp->signa }}</td>
                                    <td class="text-end px-3 py-2">Rp {{ number_format($rsp->harga, 0, ',', '.') }}</td>
                                    <td class="text-end fw-bold text-success px-3 py-2">Rp {{ number_format($rsp->qty * $rsp->harga, 0, ',', '.') }}</td>
                                    <td class="text-center py-2">
                                        <button type="button" class="btn btn-sm btn-danger py-0 px-1 btn-hapus-resep fw-bold">x</button>
                                    </td>
                                </tr>
                                @empty
                                <tr id="empty-row-resep">
                                    <td colspan="6" class="text-center text-muted py-3 fw-bold">Belum ada item resep obat yang ditambahkan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-light">
                                <tr style="border-top: 3px solid var(--retro-dark);">
                                    <td colspan="4" class="text-end fw-bolder text-dark px-3 py-2 text-uppercase">Total Estimasi Biaya Resep:</td>
                                    <td class="text-end fw-bolder text-danger px-3 py-2" id="total-resep-ranap-text">Rp 0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 pt-3 mt-4 border-top border-dark">
                <button type="button" class="btn retro-btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn retro-btn retro-btn-success btn-sm px-4" id="btn-simpan-handling-ranap">Simpan Handling Ranap</button>
            </div>
        </form>
    </div>
</div>

<script>
(function() {
    if (typeof window.choicesRanap === 'undefined') window.choicesRanap = null;
    if (typeof window.choicesObat === 'undefined') window.choicesObat = null;

    // Gunakan window agar aman dari duplikasi deklarasi saat modal dibuka berulang kali
    window.masterLayananData = window.masterLayananData || {};
    window.masterObatData = window.masterObatData || {};

    @foreach($obatList as $obt)
        window.masterObatData["{{ $obt->farm_data_obat_code }}"] = {
            nama: "{{ addslashes($obt->farm_data_obat_name) }}",
            harga: {{ $obt->harga_jual ?? 0 }}
        };
    @endforeach

    function hitungTotalRanap() {
        let total = 0;
        $('#tindakan-ranap-tbody tr').each(function() {
            let tarif = parseFloat($(this).attr('data-tarif')) || 0;
            total += tarif;
        });
        $('#total-tarif-ranap-text').text('Rp ' + total.toLocaleString('id-ID'));
    }

    function hitungTotalResep() {
        let total = 0;
        $('#resep-ranap-tbody tr').each(function() {
            let qty = parseFloat($(this).attr('data-qty')) || 0;
            let harga = parseFloat($(this).attr('data-harga')) || 0;
            total += (qty * harga);
        });
        $('#total-resep-ranap-text').text('Rp ' + total.toLocaleString('id-ID'));
    }

    $(document).ready(function() {
        hitungTotalRanap();
        hitungTotalResep();

        if (document.getElementById('select_obat_farmasi')) {
            window.choicesObat = new Choices(document.getElementById('select_obat_farmasi'), {
                searchEnabled: true,
                itemSelectText: '',
                placeholder: true,
                shouldSort: false
            });
        }

        let subPenjaminId = $('#sub_penjamin_id').val();
        if (subPenjaminId) {
            loadLayananDanJasa(subPenjaminId);
        }
    });

    function loadLayananDanJasa(subPenjaminId) {
        let laySelect = $('#select-master-tindakan-ranap');
        if (window.choicesRanap) window.choicesRanap.destroy();
        laySelect.html('<option value="">Sedang memuat layanan...</option>');

        $.ajax({
            url: "{{ route('ranap.get.layanan') }}",
            type: "GET",
            data: { sub_penjamin_id: subPenjaminId },
            success: function(res) {
                let options = '<option value="">-- Pilih Pemeriksaan / Jasa Visite --</option>';
                window.masterLayananData = {}; // Reset dictionary

                res.forEach(function(item) {
                    window.masterLayananData[item.id] = {
                        nama: item.nama_layanan,
                        tarif: parseFloat(item.tarif) || 0
                    };

                    options += `<option value="${item.id}">
                                    ${item.nama_layanan} (Rp ${Number(item.tarif).toLocaleString('id-ID')})
                                </option>`;
                });
                laySelect.html(options);
                window.choicesRanap = new Choices(document.getElementById('select-master-tindakan-ranap'), {
                    searchEnabled: true,
                    itemSelectText: '',
                    placeholder: true,
                    shouldSort: false
                });
            }
        });
    }

    // Tambah Tindakan ke Tabel Sementara
    $('#btn-tambah-tindakan-ranap').off('click').on('click', function(e) {
        e.preventDefault();
        let selectEl = document.getElementById('select-master-tindakan-ranap');
        let idTindakan = selectEl.value;

        if (!idTindakan) {
            Swal.fire('Perhatian', 'Pilih layanan/tindakan terlebih dahulu!', 'warning');
            return;
        }

        let tindakanInfo = window.masterLayananData[idTindakan];
        if (!tindakanInfo) {
            Swal.fire('Error', 'Data layanan tidak ditemukan!', 'error');
            return;
        }

        let namaPemeriksaan = tindakanInfo.nama;
        let tarifTindakan = tindakanInfo.tarif;

        let sudahAda = false;
        $('#tindakan-ranap-tbody tr').each(function() {
            if ($(this).attr('data-id') == idTindakan) sudahAda = true;
        });

        if (sudahAda) {
            Swal.fire('Duplikasi', 'Tindakan ini sudah ditambahkan!', 'error');
            return;
        }

        $('#empty-row-ranap').remove();
        let htmlRow = `
            <tr data-id="${idTindakan}" data-tarif="${tarifTindakan}">
                <td class="fw-bold text-dark px-3 py-2">${namaPemeriksaan}
                    <input type="hidden" name="tindakan_ids[]" value="${idTindakan}">
                    <input type="hidden" name="tarif_tindakan[]" value="${tarifTindakan}">
                </td>
                <td class="text-end fw-bold text-dark px-3 py-2">Rp ${tarifTindakan.toLocaleString('id-ID')}</td>
                <td class="text-center py-2"><button type="button" class="btn btn-sm btn-danger py-0 px-1 btn-hapus-tindakan fw-bold">x</button></td>
            </tr>`;
        $('#tindakan-ranap-tbody').append(htmlRow);
        hitungTotalRanap();

        if (window.choicesRanap) {
            window.choicesRanap.setChoiceByValue("");
        } else {
            $(selectEl).val("").trigger("change");
        }
    });

    $(document).off('click', '.btn-hapus-tindakan').on('click', '.btn-hapus-tindakan', function() {
        $(this).closest('tr').remove();
        if ($('#tindakan-ranap-tbody tr').length === 0) {
            $('#tindakan-ranap-tbody').html('<tr id="empty-row-ranap"><td colspan="3" class="text-center text-muted py-3 fw-bold">Belum ada tindakan yang ditambahkan.</td></tr>');
        }
        hitungTotalRanap();
    });

    // Tambah Resep Obat ke Tabel Sementara
    $('#btn-tambah-resep-ranap').off('click').on('click', function(e) {
        e.preventDefault();
        let selectEl = document.getElementById('select_obat_farmasi');
        let obatCode = selectEl.value;
        let qty = parseInt($('#qty_obat_resep').val()) || 1;
        let signa = $('#signa_obat_resep').val().trim();

        if (!obatCode || qty <= 0) {
            Swal.fire('Perhatian', 'Pilih obat dan masukkan jumlah (qty) dengan benar!', 'warning');
            return;
        }

        let obatInfo = window.masterObatData[obatCode];
        if (!obatInfo) {
            Swal.fire('Error', 'Data obat tidak ditemukan!', 'error');
            return;
        }

        let namaObat = obatInfo.nama;
        let hargaJual = obatInfo.harga;
        let subtotal = qty * hargaJual;

        let sudahAda = false;
        $('#resep-ranap-tbody tr').each(function() {
            if ($(this).attr('data-kode') == obatCode) sudahAda = true;
        });

        if (sudahAda) {
            Swal.fire('Duplikasi', 'Obat ini sudah ada dalam daftar resep!', 'error');
            return;
        }

        $('#empty-row-resep').remove();
        let htmlRow = `
            <tr data-kode="${obatCode}" data-qty="${qty}" data-harga="${hargaJual}">
                <td class="fw-bold text-dark px-3 py-2">${namaObat}
                    <input type="hidden" name="resep_obat_code[]" value="${obatCode}">
                    <input type="hidden" name="resep_qty[]" value="${qty}">
                    <input type="hidden" name="resep_signa[]" value="${signa}">
                    <input type="hidden" name="resep_harga[]" value="${hargaJual}">
                </td>
                <td class="text-center px-3 py-2">${qty}</td>
                <td class="px-3 py-2">${signa || '-'}</td>
                <td class="text-end px-3 py-2">Rp ${hargaJual.toLocaleString('id-ID')}</td>
                <td class="text-end fw-bold text-success px-3 py-2">Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td class="text-center py-2"><button type="button" class="btn btn-sm btn-danger py-0 px-1 btn-hapus-resep fw-bold">x</button></td>
            </tr>`;
        $('#resep-ranap-tbody').append(htmlRow);
        hitungTotalResep();

        if (window.choicesObat) {
            window.choicesObat.setChoiceByValue("");
        } else {
            $(selectEl).val("").trigger("change");
        }
        $('#qty_obat_resep').val('1');
        $('#signa_obat_resep').val('');
    });

    $(document).off('click', '.btn-hapus-resep').on('click', '.btn-hapus-resep', function() {
        $(this).closest('tr').remove();
        if ($('#resep-ranap-tbody tr').length === 0) {
            $('#resep-ranap-tbody').html('<tr id="empty-row-resep"><td colspan="6" class="text-center text-muted py-3 fw-bold">Belum ada item resep obat yang ditambahkan.</td></tr>');
        }
        hitungTotalResep();
    });

    // Simpan Handling Ranap
    $('#btn-simpan-handling-ranap').off('click').on('click', function(e) {
        e.preventDefault();
        let btn = $(this);
        btn.prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: "{{ route('ranap.handling.store') }}",
            type: "POST",
            data: $('#form-handling-ranap').serialize(),
            success: function(response) {
                btn.prop('disabled', false).text('Simpan Handling Ranap');
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        $('#modal-handling-ranap').modal('hide');
                        if (typeof reloadTable === 'function') reloadTable();
                    });
                } else {
                    Swal.fire('Gagal', response.message, 'error');
                }
            },
            error: function() {
                btn.prop('disabled', false).text('Simpan Handling Ranap');
                Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
            }
        });
    });
})();
</script>
