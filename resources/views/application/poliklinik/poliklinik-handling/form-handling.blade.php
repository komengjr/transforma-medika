<style>
    .tooth {
        width: 70px;
        height: 100px;
        position: relative;
        cursor: pointer;
        margin: 4px;
    }

    .crown {
        width: 60px;
        height: 30px;
        /* background: #ffffff; */
        border: 2px solid #dee2e6;
        border-radius: 10px 10px 0 0;
        margin: auto;
    }

    .root {
        width: 20px;
        height: 25px;
        /* background: #ffffff; */
        border: 2px solid #dee2e6;
        border-radius: 0 0 10px 10px;
        margin: auto;
        margin-top: -1px;
    }

    .tooth[data-status="karies"] .crown {
        background: #fa0303ff;
        border-color: #ff7a7a;
    }

    .tooth[data-status="tambalan"] .crown {
        background: #ea04ffff;
        border-color: #31cf94;
    }

    .tooth[data-status="hilang"] .crown {
        background: #ffc907ff;
        border-color: #94a3b8;
    }

    .tooth[data-status="lainnya"] .crown {
        background: #fffce6;
        border-color: #facc15;
    }

    .tooth .label {
        font-size: 11px;
        text-align: center;
        color: #495057;
        margin-top: 2px;
    }

    .tooth .num {
        position: absolute;
        top: -8px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 15px;
        color: #0bff64ff;
        background-color: #495057;
        border-radius: 20px;
        padding: 5px;
    }
</style>
<div class="card mb-3">
    <div class="card-header bg-300">
        <div class="row gx-0 flex-between-center">
            <dic class="col-auto d-flex">
                <h5 class="mb-0">Pasien Details</h5>
            </dic>
            <div class="col-auto" id="menu-pasien-poliklinik">
                <button class="btn btn-warning btn-sm" id="button-save-data-diagnosa-pasien-poli">Skip / Simpan Data</button>
            </div>
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
                <div class="col-md-4">
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
                        <input type="text" name="no_hp" class="form-control form-control-lg border-start-0 bg-white"
                            id="no_hp" value="{{ $data->master_patient_no_hp }}" disabled>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="inputLastName2" class="form-label">Email</label>
                    <div class="input-group"> <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                        <input type="email" name="email" class="form-control form-control-lg border-start-0 bg-white"
                            id="inputLastName2" value="{{ $data->master_patient_email }}" disabled>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header bg-300">
        <h5 class="mb-0">Diagnosa Pasien</h5>
    </div>
    <div class="card-body bg-light">
        <div class="position-relative rounded-1 border bg-white dark__bg-1100 p-3">
            <div class="position-absolute end-0 top-0 mt-2 me-3 z-index-1">
                <button class="btn btn-link btn-sm p-0" type="button"><span class="fas fa-times-circle text-danger"
                        data-fa-transform="shrink-1"></span></button>
            </div>
            <div class="row gx-2">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="field-name">Name</label>
                    <input class="form-control form-control-sm" id="data-name" type="text"
                        placeholder="Name (e.g. Bagian Kepala)" />
                    <div class="form-text fs--1 text-warning">* Separate your options with comma</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="field-options">Deskripsi</label>
                    <textarea class="form-control form-control-sm" id="data-desc" rows="3"></textarea>

                </div>
            </div>
        </div>
        <button class="btn btn-falcon-default btn-sm mt-2" type="submit" id="button-simpan-data-diagnosa-umum"><span class="fas fa-plus fs--2 me-1"
                data-fa-transform="up-1"></span>Add Diagnosa</button>
        <div id="menu-diagnosa-umum"></div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header bg-300">
        <h5 class="mb-0">Odontogram Interaktif</h5>
    </div>
    <div class="card-body bg-light">
        <div class="container py-4">
            <h2 class="text-center mb-3 fw-bold">🦷 Odontogram Diagnosa Detail</h2>
            <p class="text-center text-muted">Klik gigi untuk mengisi diagnosa dan catatan.</p>
            <input type="text" name="code_gigi" value="{{ $data->d_reg_order_poli_code }}" id="code_gigi" hidden>
            <div class="text-center my-3 fw-semibold text-danger">Rahang Atas</div>
            <div class="d-flex flex-wrap justify-content-center" id="upperJaw"></div>

            <hr class="my-4">

            <div class="text-center my-3 fw-semibold text-danger">Rahang Bawah</div>
            <div class="d-flex flex-wrap justify-content-center" id="lowerJaw"></div>

            <div class="mt-4 d-flex flex-wrap gap-2 justify-content-center">
                <button class="btn btn-teal btn-sm btn-primary" id="exportBtn">Simpan Diagnosa</button>
                <button class="btn btn-outline-primary btn-sm d-none" id="importBtn">Impor JSON</button>
                <button class="btn btn-outline-danger btn-sm" id="resetBtn">Reset</button>
            </div>

            <div class="mt-3 d-none">
                <textarea id="exportArea" class="form-control" rows="5"
                    placeholder="Hasil ekspor / tempel JSON di sini..."></textarea>
            </div>
        </div>

        <!-- Modal Diagnosa -->
        <div class="modal fade" id="diagnosisModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-300">
                        <h5 class="modal-title">Diagnosa Gigi <span id="toothNumber"></span></h5>
                        <button class="btn-close btn btn-circle d-flex flex-center transition-base"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="diagnosisList" class="row g-3"></div>
                        <label for="note" class="form-label mt-2">Catatan:</label>
                        <textarea id="note" class="form-control" placeholder="Tambahkan catatan khusus..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="saveBtn">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- <div class="card mb-3">
    <div class="card-header bg-300">
        <h5 class="mb-0">Fasilitas Order</h5>
    </div>
    <div class="card-body bg-light">
        @foreach ($layanan as $lay)
            <button class="btn btn-falcon-warning btn-sm me-2" type="button" id="button-order-layanan-dokter"
                data-code="{{$lay->t_layanan_cat_code}}" data-reg="{{$code}}"><span class="fab fa-squarespace"></span>
                {{ $lay->t_layanan_cat_name }}</button>
        @endforeach
        <hr />
        <div id="menu-order-layanan-dokter">

        </div>
    </div>

</div> -->
@php
    $ran = mt_rand(100, 999);
@endphp
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

    function makeTooth(num) {
        var t = document.createElement("div");
        t.className = "tooth";
        t.dataset.num = num;
        t.dataset.status = "sehat";
        t.innerHTML = `<div class="num">${num}</div>
        <div class="crown"></div>
        <div class="root"></div>
        <div class="label">Sehat</div>`;
        t.onclick = () => openModal(num);
        return t;
    }
    function buildOdontogram() {
        var uj = document.getElementById("upperJaw");
        var lj = document.getElementById("lowerJaw");
        upperNums.forEach(n => uj.appendChild(makeTooth(n)));
        lowerNums.forEach(n => lj.appendChild(makeTooth(n)));
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
        <div class="col-md-4">
          <input class="form-check-input" type="checkbox" value="${d}" id="d${i}">
          <label class="form-check-label" for="d${i}">${d}</label>
        </div>
      `).join("");
        var existing = data[num] || { diagnosis: [], note: "" };
        [...diagList.querySelectorAll("input")].forEach(i => {
            if (existing.diagnosis.includes(i.value)) i.checked = true;
        });
        noteField.value = existing.note;
        modal.show();
    }

    document.getElementById("saveBtn").onclick = () => {
        var selected = [...diagList.querySelectorAll("input:checked")].map(i => i.value);
        var note = noteField.value.trim();
        data[currentTooth<?php echo $ran ?>] = { diagnosis: selected, note };
        updateToothDisplay(currentTooth<?php echo $ran ?>);
        modal.hide();
    };

    function updateToothDisplay(num) {
        var el = document.querySelector(`.tooth[data-num='${num}']`);
        if (!el) return;
        var info = data[num];
        if (!info || info.diagnosis.length === 0) {
            el.dataset.status = "sehat";
            el.querySelector(".label").textContent = "Sehat";
            return;
        }
        let status = "lainnya";
        if (info.diagnosis.some(d => d.toLowerCase().includes("karies"))) status = "karies";
        else if (info.diagnosis.some(d => d.toLowerCase().includes("tambalan"))) status = "tambalan";
        else if (info.diagnosis.some(d => d.toLowerCase().includes("hilang"))) status = "hilang";
        el.dataset.status = status;
        el.querySelector(".label").textContent = info.diagnosis[0];
    }

    // Export / Import / Reset
    var exp = document.getElementById("exportBtn");
    var imp = document.getElementById("importBtn");
    var reset = document.getElementById("resetBtn");
    var text = document.getElementById("exportArea");

    imp.onclick = () => {
        try {
            var obj = JSON.parse(text.value);
            for (var k in obj) { data[k] = obj[k]; updateToothDisplay(k); }
            alert("Data diimpor!");
        } catch (e) { alert("Format JSON salah."); }
    };
    reset.onclick = () => {
        if (confirm("Yakin ingin reset semua data?")) {
            var id = document.getElementById('code_gigi').value;
            for (var k in data) delete data[k];
            document.querySelectorAll(".tooth").forEach(el => {
                el.dataset.status = "sehat";
                el.querySelector(".label").textContent = "Sehat";
            });

            $.ajax({
                url: "{{ route('data_registrasi_poliklinik_reset_odontogram') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                dataType: 'html',
            }).done(function (data) {
                text.value = "";
            }).fail(function () {
                alert('error');
            });
        }
    };
    $(document).on("click", "#exportBtn", function (e) {
        e.preventDefault();
        var id = document.getElementById('code_gigi').value;
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: true
        });
        swalWithBootstrapButtons.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Verif it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('data_registrasi_poliklinik_save_odontogram') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id,
                        "data": JSON.stringify(data, null, 2),
                    },
                    dataType: 'html',
                }).done(function (data) {
                    if (data == 0) {
                        swalWithBootstrapButtons.fire({
                            title: "Kosong",
                            text: "Data Masih Kosong :)",
                            icon: "error"
                        });
                    } else {
                        swalWithBootstrapButtons.fire({
                            title: "Success!",
                            text: data,
                            icon: "success"
                        });
                    }
                }).fail(function () {
                    swalWithBootstrapButtons.fire({
                        title: "Failed",
                        text: "Your Data Failed :)",
                        icon: "error"
                    });
                });

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Your Data file is safe :)",
                    icon: "error"
                });
            }
        });
        // alert(JSON.stringify(data, null, 2))

    });
</script>
