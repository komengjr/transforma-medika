<style>
    /* Styling Ringkas & Hemat Ruang untuk Detail Pasien */
    .patient-compact-card {
        background-color: #ffffff;
        border-left: 4px solid #2c7be5 !important;
    }

    .patient-avatar-compact {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border: 2px solid #e3e8f0;
    }

    .info-label {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6e84a3;
        font-weight: 700;
        margin-bottom: 1px;
    }

    .info-value {
        font-size: 0.875rem;
        font-weight: 600;
        color: #2c3e50;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ========================================== */
    /* ODONTOGRAM ANATOMIS MINIMALIS & PRESISI    */
    /* ========================================== */
    .odontogram-wrapper {
        background: #f8fafc;
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #e2e8f0;
    }

    .jaw-container {
        display: flex;
        justify-content: center;
        gap: 4px;
        flex-wrap: nowrap;
        overflow-x: auto;
        padding-bottom: 4px;
    }

    .tooth-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 38px;
        cursor: pointer;
        user-select: none;
        transition: transform 0.15s ease;
    }

    .tooth-box:hover {
        transform: translateY(-2px);
    }

    .tooth-number {
        font-size: 11px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 2px;
    }

    /* Tampilan Anatomi Gigi 5 Sektor (Cross/Crown Shape) */
    .tooth-crown-svg {
        width: 32px;
        height: 32px;
    }

    .tooth-sector {
        fill: #ffffff;
        stroke: #64748b;
        stroke-width: 1.5;
        transition: fill 0.2s ease;
    }

    .tooth-box:hover .tooth-sector {
        stroke: #2563eb;
    }

    .tooth-status-label {
        font-size: 9px;
        font-weight: 600;
        color: #64748b;
        text-align: center;
        margin-top: 2px;
        white-space: nowrap;
        max-width: 38px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Warna Status Odontogram */
    .tooth-box[data-status="karies"] .tooth-sector {
        fill: #ef4444;
        stroke: #dc2626;
    }

    .tooth-box[data-status="tambalan"] .tooth-sector {
        fill: #a855f7;
        stroke: #9333ea;
    }

    .tooth-box[data-status="hilang"] .tooth-sector {
        fill: #94a3b8;
        stroke: #64748b;
    }

    .tooth-box[data-status="lainnya"] .tooth-sector {
        fill: #eab308;
        stroke: #ca8a04;
    }

    /* Separator Rahang Kiri & Kanan */
    .jaw-divider {
        width: 2px;
        background-color: #cbd5e1;
        margin: 0 4px;
        height: 32px;
        align-self: flex-end;
    }
</style>

<!-- CARD DETIL PASIEN (MINIMALIS & COMPACT) -->
<div class="card mb-3 border-0 shadow-sm patient-compact-card">
    <div class="card-body p-2 p-md-3">
        <div class="row align-items-center g-2">
            <!-- Foto & Info Ringkas Utama -->
            <div class="col-auto d-flex align-items-center me-md-2">
                @if (empty($data->master_patient_profile))
                <img src="{{ asset('img/pasien.png') }}" class="rounded-circle patient-avatar-compact me-2" alt="Profile Pasien" id="videoPreview">
                @else
                <img src="{{ Storage::url($data->master_patient_profile) }}" class="rounded-circle patient-avatar-compact me-2" alt="Profile Pasien" id="videoPreview">
                @endif
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <h6 class="mb-0 fw-bold text-dark">{{ $data->master_patient_name }}</h6>
                        <span class="badge bg-soft-primary text-primary fs--2 border border-primary-subtle">
                            {{ $data->master_patient_code ?? 'RM-000' }}
                        </span>
                    </div>
                    <div class="text-muted fs--2 mt-1">
                        <i class="fas fa-venus-mars me-1 text-400"></i>{{ $data->master_patient_jk ?? '-' }}
                        <span class="mx-1">•</span>
                        <i class="fas fa-birthday-cake me-1 text-400"></i>{{ $data->master_patient_tgl_lahir ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="col-12 col-md d-none d-lg-block border-start px-3">
                <div class="row g-2">
                    <div class="col-4">
                        <div class="info-label"><i class="fas fa-id-card me-1"></i>NIK</div>
                        <div class="info-value">{{ $data->master_patient_nik ?? '-' }}</div>
                    </div>
                    <div class="col-4">
                        <div class="info-label"><i class="fas fa-phone me-1"></i>No. HP / WA</div>
                        <div class="info-value">{{ $data->master_patient_no_hp ?? '-' }}</div>
                    </div>
                    <div class="col-4">
                        <div class="info-label"><i class="fas fa-envelope me-1"></i>Email</div>
                        <div class="info-value">{{ $data->master_patient_email ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi Kanan -->
            <div class="col-auto ms-auto" id="menu-pasien-poliklinik">
                <button class="btn btn-outline-primary btn-sm fw-bold px-3" id="button-save-data-diagnosa-pasien-poli">
                    <i class="fas fa-save me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CARD DIAGNOSA PASIEN (MINIMALIS & COMPACT) -->
<div class="card mb-3 shadow-sm border-0">
    <div class="card-header bg-300 py-2">
        <div class="row gx-0 flex-between-center">
            <div class="col-auto d-flex align-items-center">
                <h6 class="mb-0 fw-bold fs--1 text-800"><i class="fas fa-notes-medical me-2 text-primary"></i>Diagnosa Pasien</h6>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary btn-sm py-0 px-2 fs--2" data-bs-toggle="modal" data-bs-target="#modal-poliklinik" id="button-penunjang-poliklinik">
                    <i class="fas fa-folder-open me-1"></i> Data Penunjang
                </button>
            </div>
        </div>
    </div>
    <div class="card-body p-2 bg-light">
        <!-- Form Input Horizontal 1 Baris (Inline Input) -->
        <div class="bg-white p-2 rounded border mb-2">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <input class="form-control form-control-sm" id="data-name" type="text" placeholder="Nama Diagnosa / Anamnesa (mis: ICD-10)" />
                </div>
                <div class="col-md-6">
                    <input class="form-control form-control-sm" id="data-desc" type="text" placeholder="Deskripsi & Catatan Dokter..." />
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-sm w-100 fs--1" type="button" id="button-simpan-data-diagnosa-umum">
                        <span class="fas fa-plus me-1"></span>Tambah
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabel Hasil Diagnosa Compact -->
        <div id="menu-diagnosa-umum">
            @php
            $umum = DB::table('diag_poli_gigi_umum')->where('d_reg_order_poli_code', $data->d_reg_order_poli_code)->get();
            @endphp
            <div class="table-responsive scrollbar">
                <table class="table table-sm table-bordered table-striped bg-white fs--1 mb-0">
                    <thead class="bg-200">
                        <tr>
                            <th scope="col" style="width: 35%;">Title</th>
                            <th scope="col">Deskripsi</th>
                            <th class="text-end" scope="col" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($umum as $umums)
                        <tr>
                            <td class="fw-semi-bold align-middle">{{ $umums->diag_poli_gigi_umum_name }}</td>
                            <td class="align-middle">{{ $umums->diag_poli_gigi_umum_desc }}</td>
                            <td class="text-end align-middle">
                                <button class="btn p-0 text-500 hover-text-info" type="button" data-bs-toggle="tooltip" title="Edit"><span class="fas fa-edit"></span></button>
                                <button class="btn p-0 ms-2 text-500 hover-text-danger" type="button" data-bs-toggle="tooltip" title="Delete"><span class="fas fa-trash-alt"></span></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-2 fs--2">Belum ada data diagnosa tersimpan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- TEMPLATE SPESIFIK KEBUTUHAN TIAP POLIKLINIK (M_POLI_NAME) -->
@php
$ran = mt_rand(100, 999);
$namaPoli = strtoupper($poli->m_poli_name ?? '');
@endphp

@if (str_contains($namaPoli, 'GIGI'))
<!-- TEMPLATE POLI GIGI (ODONTOGRAM ANATOMIS MINIMALIS) -->
<div class="card mb-3 shadow-sm border-0">
    <div class="card-header bg-300 py-2 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold fs--1"><i class="fas fa-tooth me-2 text-primary"></i>Odontogram Interaktif - {{ $poli->m_poli_name }}</h6>
        <div class="d-flex align-items-center gap-3 fs--2">
            <span class="d-flex align-items-center"><span class="badge bg-danger rounded-circle me-1" style="width:8px;height:8px;"></span> Karies</span>
            <span class="d-flex align-items-center"><span class="badge bg-purple rounded-circle me-1" style="width:8px;height:8px;background-color:#a855f7;"></span> Tambalan</span>
            <span class="d-flex align-items-center"><span class="badge bg-secondary rounded-circle me-1" style="width:8px;height:8px;"></span> Hilang</span>
            <span class="d-flex align-items-center"><span class="badge bg-warning rounded-circle me-1" style="width:8px;height:8px;"></span> Lainnya</span>
        </div>
    </div>
    <div class="card-body p-3 bg-light">
        <input type="hidden" name="code_gigi" value="{{ $data->d_reg_order_poli_code }}" id="code_gigi">

        <div class="odontogram-wrapper shadow-xs">
            <!-- Rahang Atas (Maxilla) -->
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fs--2 fw-bold text-primary"><i class="fas fa-chevron-up me-1"></i> Rahang Atas (Maxilla)</span>
                <span class="fs--2 text-muted">Klik elemen gigi untuk ubah kondisi</span>
            </div>
            <div class="jaw-container bg-white p-2 rounded border mb-3" id="upperJaw"></div>

            <!-- Rahang Bawah (Mandibula) -->
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fs--2 fw-bold text-primary"><i class="fas fa-chevron-down me-1"></i> Rahang Bawah (Mandibula)</span>
            </div>
            <div class="jaw-container bg-white p-2 rounded border" id="lowerJaw"></div>
        </div>

        <!-- Tombol Aksi Minimalis -->
        <div class="mt-2 d-flex justify-content-end gap-2">
            <button class="btn btn-outline-danger btn-sm py-1 fs--2" id="resetBtn"><i class="fas fa-undo me-1"></i> Reset</button>
            <button class="btn btn-success btn-sm py-1 fs--2" id="exportBtn"><i class="fas fa-save me-1"></i> Simpan Odontogram</button>
        </div>
        <textarea id="exportArea" class="d-none"></textarea>

        <!-- Modal Diagnosa Gigi -->
        <div class="modal fade" id="diagnosisModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white py-2">
                        <h6 class="modal-title text-white fw-bold fs-0"><i class="fas fa-tooth me-2"></i>Kondisi Gigi No: <span id="toothNumber" class="badge bg-light text-primary"></span></h6>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3">
                        <div id="diagnosisList" class="row g-2"></div>
                        <label for="note" class="form-label mt-3 fw-bold fs--1 text-700">Catatan Khusus Tindakan:</label>
                        <textarea id="note" class="form-control form-control-sm" rows="2" placeholder="Catatan kondisi/tindakan medis gigi..."></textarea>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-light btn-sm fs--1" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary btn-sm fs--1" id="saveBtn"><i class="fas fa-check me-1"></i> Terapkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var upperNums = [18, 17, 16, 15, 14, 13, 12, 11, 21, 22, 23, 24, 25, 26, 27, 28];
    var lowerNums = [48, 47, 46, 45, 44, 43, 42, 41, 31, 32, 33, 34, 35, 36, 37, 38];
    var diagnoses = [
        "Karies superfisialis", "Karies media", "Karies profunda", "Pulpitis",
        "Abses periapikal", "Tambalan baik", "Tambalan bocor", "Kalkulus",
        "Gingivitis", "Periodontitis", "Gigi hilang", "Gigi goyah",
        "Gigi impaksi", "Gigi fraktur", "Gigi erupsi parsial",
        "Crown / bridge", "Protesa", "Lainnya"
    ];
    var data = {};

    // SVG Anatomi Gigi 5 Sektor Standar Kedokteran Gigi
    function getToothSVG() {
        return `
            <svg class="tooth-crown-svg" viewBox="0 0 40 40">
                <polygon points="0,0 40,0 30,10 10,10" class="tooth-sector sector-top" />
                <polygon points="40,0 40,40 30,30 30,10" class="tooth-sector sector-right" />
                <polygon points="0,40 40,40 30,30 10,30" class="tooth-sector sector-bottom" />
                <polygon points="0,0 0,40 10,30 10,10" class="tooth-sector sector-left" />
                <rect x="10" y="10" width="20" height="20" class="tooth-sector sector-center" />
            </svg>
        `;
    }

    function makeTooth(num) {
        var t = document.createElement("div");
        t.className = "tooth-box";
        t.dataset.num = num;
        t.dataset.status = "sehat";
        t.innerHTML = `
            <div class="tooth-number">${num}</div>
            ${getToothSVG()}
            <div class="tooth-status-label">Normal</div>
        `;
        t.onclick = () => openModal(num);
        return t;
    }

    function buildOdontogram() {
        var uj = document.getElementById("upperJaw");
        var lj = document.getElementById("lowerJaw");
        if (uj && lj) {
            uj.innerHTML = "";
            lj.innerHTML = "";

            upperNums.forEach((n, idx) => {
                uj.appendChild(makeTooth(n));
                if (idx === 7) {
                    var div = document.createElement("div");
                    div.className = "jaw-divider";
                    uj.appendChild(div);
                }
            });

            lowerNums.forEach((n, idx) => {
                lj.appendChild(makeTooth(n));
                if (idx === 7) {
                    var div = document.createElement("div");
                    div.className = "jaw-divider";
                    lj.appendChild(div);
                }
            });
        }
    }
    buildOdontogram();

    var modal = new bootstrap.Modal(document.getElementById('diagnosisModal'));
    var diagList = document.getElementById("diagnosisList");
    var toothNumLabel = document.getElementById("toothNumber");
    var noteField = document.getElementById("note");
    let currentTooth<?php echo $ran ?> = null;

    function openModal(num) {
        currentTooth<?php echo $ran ?> = num;
        toothNumLabel.textContent = num;
        diagList.innerHTML = diagnoses.map((d, i) => `
            <div class="col-6">
              <div class="form-check mb-1">
                <input class="form-check-input" type="checkbox" value="${d}" id="d${i}">
                <label class="form-check-label fs--2 text-700" for="d${i}">${d}</label>
              </div>
            </div>
          `).join("");
        var existing = data[num] || {
            diagnosis: [],
            note: ""
        };
        [...diagList.querySelectorAll("input")].forEach(i => {
            if (existing.diagnosis.includes(i.value)) i.checked = true;
        });
        noteField.value = existing.note;
        modal.show();
    }

    document.getElementById("saveBtn").onclick = () => {
        var selected = [...diagList.querySelectorAll("input:checked")].map(i => i.value);
        var note = noteField.value.trim();
        data[currentTooth<?php echo $ran ?>] = {
            diagnosis: selected,
            note
        };
        updateToothDisplay(currentTooth<?php echo $ran ?>);
        modal.hide();
    };

    function updateToothDisplay(num) {
        var el = document.querySelector(`.tooth-box[data-num='${num}']`);
        if (!el) return;
        var info = data[num];
        if (!info || info.diagnosis.length === 0) {
            el.dataset.status = "sehat";
            el.querySelector(".tooth-status-label").textContent = "Normal";
            return;
        }
        let status = "lainnya";
        if (info.diagnosis.some(d => d.toLowerCase().includes("karies"))) status = "karies";
        else if (info.diagnosis.some(d => d.toLowerCase().includes("tambalan"))) status = "tambalan";
        else if (info.diagnosis.some(d => d.toLowerCase().includes("hilang"))) status = "hilang";
        el.dataset.status = status;
        el.querySelector(".tooth-status-label").textContent = info.diagnosis[0];
    }

    var reset = document.getElementById("resetBtn");
    reset.onclick = () => {
        if (confirm("Yakin ingin reset semua data odontogram?")) {
            var id = document.getElementById('code_gigi').value;
            for (var k in data) delete data[k];
            document.querySelectorAll(".tooth-box").forEach(el => {
                el.dataset.status = "sehat";
                el.querySelector(".tooth-status-label").textContent = "Normal";
            });

            $.ajax({
                url: "{{ route('data_registrasi_poliklinik_reset_odontogram') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'html',
            });
        }
    };

    $(document).on("click", "#exportBtn", function(e) {
        e.preventDefault();
        var id = document.getElementById('code_gigi').value;
        Swal.fire({
            title: "Simpan Odontogram?",
            text: "Data pemeriksaan gigi pasien akan diperbarui.",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('data_registrasi_poliklinik_save_odontogram') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                        "data": JSON.stringify(data, null, 2),
                    },
                    dataType: 'html',
                }).done(function(res) {
                    Swal.fire("Berhasil!", "Data odontogram berhasil disimpan.", "success");
                }).fail(function() {
                    Swal.fire("Gagal", "Gagal menyimpan data.", "error");
                });
            }
        });
    });
</script>

@elseif (str_contains($namaPoli, 'DALAM'))
<!-- TEMPLATE POLI PENYAKIT DALAM -->
<div class="card mb-3">
    <div class="card-header bg-300 py-2">
        <h6 class="mb-0 fw-bold"><i class="fas fa-stethoscope me-2"></i>Pemeriksaan Spesifik - {{ $poli->m_poli_name }}</h6>
    </div>
    <div class="card-body bg-light p-3">
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label fw-semi-bold fs--1">Tekanan Darah (mmHg)</label>
                <input type="text" class="form-control form-control-sm" placeholder="Contoh: 120/80">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semi-bold fs--1">Gula Darah Sewaktu (mg/dL)</label>
                <input type="number" class="form-control form-control-sm" placeholder="Contoh: 110">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semi-bold fs--1">Asam Urat (mg/dL)</label>
                <input type="number" step="0.1" class="form-control form-control-sm" placeholder="Contoh: 6.0">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semi-bold fs--1">Kolesterol Total (mg/dL)</label>
                <input type="number" class="form-control form-control-sm" placeholder="Contoh: 190">
            </div>
            <div class="col-md-12">
                <label class="form-label fw-semi-bold fs--1">Pemeriksaan Abdomen / Organ Dalam</label>
                <textarea class="form-control form-control-sm" rows="2" placeholder="Hasil palpasi, auskultasi, dll..."></textarea>
            </div>
        </div>
    </div>
</div>

@elseif (str_contains($namaPoli, 'JANTUNG'))
<!-- TEMPLATE POLI JANTUNG -->
<div class="card mb-3">
    <div class="card-header bg-300 py-2">
        <h6 class="mb-0 fw-bold"><i class="fas fa-heartbeat me-2"></i>Pemeriksaan Kardiovaskular - {{ $poli->m_poli_name }}</h6>
    </div>
    <div class="card-body bg-light p-3">
        <div class="row g-2">
            <div class="col-md-4">
                <label class="form-label fw-semi-bold fs--1">Detak Jantung (BPM)</label>
                <input type="number" class="form-control form-control-sm" placeholder="Contoh: 80 bpm">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semi-bold fs--1">Irama Jantung</label>
                <select class="form-select form-select-sm">
                    <option value="Reguler">Reguler (Sinus Rhythm)</option>
                    <option value="Ireguler">Ireguler (Aritmia)</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semi-bold fs--1">Hasil EKG Ringkas</label>
                <input type="text" class="form-control form-control-sm" placeholder="Contoh: Normal Sinus Rhythm">
            </div>
            <div class="col-md-12">
                <label class="form-label fw-semi-bold fs--1">Catatan Echocardiography / EKG Detail</label>
                <textarea class="form-control form-control-sm" rows="2" placeholder="Masukkan hasil evaluasi gelombang EKG..."></textarea>
            </div>
        </div>
    </div>
</div>

@elseif (str_contains($namaPoli, 'ANAK'))
<!-- TEMPLATE POLI ANAK -->
<div class="card mb-3">
    <div class="card-header bg-300 py-2">
        <h6 class="mb-0 fw-bold"><i class="fas fa-baby me-2"></i>Pemeriksaan Tumbuh Tembang - {{ $poli->m_poli_name }}</h6>
    </div>
    <div class="card-body bg-light p-3">
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label fw-semi-bold fs--1">Berat Badan (Kg)</label>
                <input type="number" step="0.1" class="form-control form-control-sm" placeholder="Contoh: 12.5">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semi-bold fs--1">Tinggi / Panjang Badan (cm)</label>
                <input type="number" step="0.1" class="form-control form-control-sm" placeholder="Contoh: 85">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semi-bold fs--1">Lingkar Kepala (cm)</label>
                <input type="number" step="0.1" class="form-control form-control-sm" placeholder="Contoh: 46">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semi-bold fs--1">Suhu Tubuh (°C)</label>
                <input type="number" step="0.1" class="form-control form-control-sm" placeholder="Contoh: 36.6">
            </div>
            <div class="col-md-12">
                <label class="form-label fw-semi-bold fs--1">Riwayat Imunisasi & Tumbuh Tumbuh</label>
                <textarea class="form-control form-control-sm" rows="2" placeholder="Catatan vaksinasi dan perkembangan anak..."></textarea>
            </div>
        </div>
    </div>
</div>

@else
<!-- TEMPLATE DEFAULT POLI UMUM / LAINNYA -->
<div class="card mb-3">
    <div class="card-header bg-300 py-2">
        <h6 class="mb-0 fw-bold"><i class="fas fa-clinic-medical me-2"></i>Pemeriksaan Umum - {{ $poli->m_poli_name ?? 'Poliklinik' }}</h6>
    </div>
    <div class="card-body bg-light p-3">
        <div class="row g-2">
            <div class="col-md-4">
                <label class="form-label fw-semi-bold fs--1">Tekanan Darah</label>
                <input type="text" class="form-control form-control-sm" placeholder="120/80 mmHg">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semi-bold fs--1">Suhu (°C)</label>
                <input type="number" step="0.1" class="form-control form-control-sm" placeholder="36.5">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semi-bold fs--1">Nadi (x/menit)</label>
                <input type="number" class="form-control form-control-sm" placeholder="80">
            </div>
        </div>
    </div>
</div>
@endif

<!-- CARD FASILITAS ORDER / PENUNJANG -->
<!-- CARD FASILITAS ORDER / PENUNJANG (2 KOLOM - SPLIT VIEW) -->
<div class="card mb-3 shadow-sm border-0">
    <div class="card-header bg-300 py-2 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold fs--1 text-800">
            <i class="fas fa-boxes me-2 text-primary"></i>Fasilitas Order (Laboratorium, Radiologi, dll)
        </h6>
        <span class="badge bg-soft-info text-info fs--2">Pemeriksaan Penunjang</span>
    </div>
    <div class="card-body bg-light p-2 p-md-3">
        <div class="row g-2">
            <!-- KOLOM KIRI: DAFTAR LAYANAN (LIST VERTIKAL) -->
            <div class="col-12 col-md-4 col-lg-3 border-end-md">
                <div class="text-xs fw-bold text-uppercase text-muted mb-2 px-1">
                    <i class="fas fa-list me-1"></i>Pilih Jenis Order
                </div>
                <div class="nav flex-column nav-pills gap-1" id="order-layanan-tab" role="tablist">
                    @foreach ($layanan as $lay)
                    <button class="nav-link text-start btn-order-category fs--2 fw-semi-bold py-2 px-3 d-flex align-items-center justify-content-between border"
                        type="button"
                        data-code="{{ $lay->t_layanan_cat_code }}"
                        data-reg="{{ $code }}"
                        style="border-radius: 6px; background-color: #ffffff;">
                        <span>
                            <i class="fas fa-microscope me-2 text-primary"></i> {{ $lay->t_layanan_cat_name }}
                        </span>
                        <i class="fas fa-chevron-right fs--3 opacity-50 icon-arrow"></i>
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- KOLOM KANAN: MENU & FORM ORDER VIA AJAX -->
            <div class="col-12 col-md-8 col-lg-9 ps-md-3">
                <div id="menu-order-layanan-dokter" class="h-100">
                    <!-- Default State Tampilan Awal Sebelum Kategori Dipilih -->
                    <div class="d-flex flex-column align-items-center justify-content-center h-100 py-4 text-center bg-white rounded border border-dashed p-3" style="min-height: 180px;">
                        <i class="fas fa-hand-pointer text-400 fa-2x mb-2"></i>
                        <h6 class="fs--1 text-600 mb-1 fw-bold">Belum Ada Kategori Dipilih</h6>
                        <p class="fs--2 text-500 mb-0">Silakan pilih jenis layanan/order di panel sebelah kiri untuk melihat opsi pemeriksaan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling Komponen List Kiri agar Lebih Interaktif */
    .btn-order-category {
        color: #475569;
        transition: all 0.2s ease;
    }

    .btn-order-category:hover {
        background-color: #edf2f7 !important;
        color: #2b6cb0;
    }

    .btn-order-category.active-order-btn {
        background-color: #2c7be5 !important;
        color: #ffffff !important;
        border-color: #2c7be5 !important;
    }

    .btn-order-category.active-order-btn i {
        color: #ffffff !important;
    }
</style>

<script>
    (function() {
        // Variabel terisolasi di dalam scope IIFE (Aman dari error redeclaration)
        let activeCategoryCode = null;
        var isAllSelected = false;
        $(document).ready(function() {

            // 1. Matikan event handler lama sebelum mendaftarkan yang baru (.off)
            $(document).off('click', '.btn-order-category').on('click', '.btn-order-category', function(e) {
                e.preventDefault();

                var $btn = $(this);
                var catCode = $btn.data('code');
                var regCode = $btn.data('reg');
                var $container = $('#menu-order-layanan-dokter');

                // Toggle off jika tombol kategori yang sama diklik ulang
                if (activeCategoryCode === catCode) {
                    resetOrderMenu();
                    return;
                }

                // Highlight item terpilih di kolom kiri
                $('.btn-order-category').removeClass('active-order-btn');
                $btn.addClass('active-order-btn');
                activeCategoryCode = catCode;

                // Tampilkan Loading State di kolom kanan
                $container.html(`
                <div class="d-flex flex-column align-items-center justify-content-center h-100 py-4 text-center bg-white rounded border" style="min-height: 180px;">
                    <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
                    <span class="fs--1 text-muted">Memuat item order penunjang...</span>
                </div>
            `);

                // Exec AJAX Request untuk ambil Form Order di kanan
                $.ajax({
                    url: "{{ route('data_registrasi_poliklinik_handling_order_layanan') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "cat_code": catCode,
                        "reg_code": regCode
                    },
                    dataType: "html",
                    success: function(response) {
                        $container.hide().html(response).fadeIn(150);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error AJAX Order:", error);
                        $container.html(`
                        <div class="alert alert-danger fs--1 mb-0 py-2" role="alert">
                            <i class="fas fa-exclamation-triangle me-1"></i> Gagal memuat formulir order. Silakan coba lagi.
                        </div>
                    `);
                    }
                });
            });

            // 2. Fungsi Helper untuk Mereset Tampilan Menu & State
            function resetOrderMenu() {
                activeCategoryCode = null;
                $('.btn-order-category').removeClass('active-order-btn');
                $('#menu-order-layanan-dokter').html(`
                <div class="d-flex flex-column align-items-center justify-content-center h-100 py-4 text-center bg-white rounded border border-dashed p-3" style="min-height: 180px;">
                    <i class="fas fa-hand-pointer text-400 fa-2x mb-2"></i>
                    <h6 class="fs--1 text-600 mb-1 fw-bold">Belum Ada Kategori Dipilih</h6>
                    <p class="fs--2 text-500 mb-0">Silakan pilih jenis layanan/order di panel sebelah kiri untuk melihat opsi pemeriksaan.</p>
                </div>
            `);
            }

            // 3. Listener Custom Event saat Pasien Berganti
            $(document).off('patientChanged').on('patientChanged', function() {
                resetOrderMenu();
            });

        });
    })();
</script>
