<style>
    #canvasContainer {
        position: relative;
        width: 100%;
        max-width: 350px;
        margin: auto;
    }

    #wheel {
        width: 100%;
        height: auto;
        border-radius: 50%;
        border: 5px solid #333;
        transition: transform 0s;
    }

    #pointer {
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 15px solid transparent;
        border-right: 15px solid transparent;
        border-top: 30px solid #dc3545;
        z-index: 10;
    }

    .scrollable-table {
        max-height: 500px;
        overflow-y: auto;
    }
</style>
<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Proses Arisan</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-add-data-pr-all">

        <div class="row g-4">
            <!-- TABEL BELUM TERPILIH (AKTIF) -->
            <div class="col-md-4">
                <div class="card shadow-lg border h-100">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Belum Terpilih (Aktif)</h6>
                        <span class="badge bg-white text-primary" id="countActive">0</span>
                    </div>
                    <div class="card-body">
                        <!-- Input Pencarian Aktif -->
                        <input type="text" id="searchActive" class="form-control form-control-sm search-input" placeholder="Cari di daftar aktif..." onkeyup="filterTable('searchActive', 'participantTable')">

                        <div class="scrollable-table">
                            <table class="table table-hover align-middle">
                                <tbody id="participantTable"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SPIN WHEEL -->
            <div class="col-md-4 text-center ">
                <div class="card shadow-sm py-4 h-100 border border-primary">
                    <div id="canvasContainer">
                        <div id="pointer"></div>
                        <canvas id="wheel" width="400" height="400"></canvas>
                    </div>
                    <div class="mt-4">
                        <button id="spinBtn" class="btn btn-success btn-lg px-5 shadow fw-bold" onclick="spin()">PUTAR RODA</button>
                    </div>
                    <h3 id="winnerDisplay" class="mt-3 text-danger fw-bold" style="min-height: 40px;"></h3>
                    <input type="text" id="peserta_code" name="peserta_code" style="display: none;">
                    <input type="text" id="peserta_name" name="peserta_name" style="display: none;">
                    <input type="text" id="arisan_code" name="arisan_code" value="{{ $arisan->kop_arisan_tagihan_code }}" style="display: none;">
                </div>
            </div>

            <!-- TABEL SUDAH TERPILIH (TERELIMINASI) -->
            <div class="col-md-4">
                <div class="card shadow-lg h-100">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Sudah Terpilih (Eliminasi)</h6>
                        <span class="badge bg-light text-dark" id="countEliminated">0</span>
                    </div>
                    <div class="card-body">
                        <div class="scrollable-table">
                            <table class="table table-striped align-middle">
                                <tbody id="eliminatedTable">
                                    <!-- Riwayat muncul di sini -->
                                </tbody>
                            </table>
                        </div>
                        <div id="emptyEliminated" class="text-muted text-center small py-3 italic"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <!-- <span id="menu-add-data-arisan">
        <button class="btn btn-success float-end" id="button-simpan-data-arisan" data-code="">Simpan
            Data</button>
    </span> -->
</div>
@php
$otp = random_int(100000, 999999);
@endphp
<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
<script>
    // DATA DENGAN STRUKTUR OBJEK
    let participants = [

        @foreach($peserta as $pes) {
            name: "{{ $pes->kop_master_peserta_name }}",
            id: "{{ $pes->kop_arisan_group_user_code }}"
        },
        @endforeach

    ];
    let eliminated = [
        @foreach($terpilih as $ter)

        {
            name: "{{ $ter->kop_master_peserta_name }}",
            id: "P009",
            time: "09:15"
        },

        @endforeach

    ];
    let isSpinning = false;

    const canvas = document.getElementById('wheel');
    const ctx = canvas.getContext('2d');
    const colors = ["#FF5733", "#33FF57", "#3357FF", "#F333FF", "#FF33A1", "#F3FF33", "#33FFF3"];

    function drawWheel() {
        const n = participants.length;
        const arc = (2 * Math.PI) / n;
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        if (n === 0) {
            ctx.textAlign = 'center';
            ctx.fillText("Data Kosong", 200, 200);
            return;
        }

        participants.forEach((p, i) => {
            const angle = i * arc;
            ctx.beginPath();
            ctx.fillStyle = colors[i % colors.length];
            ctx.moveTo(200, 200);
            ctx.arc(200, 200, 200, angle, angle + arc);
            ctx.lineTo(200, 200);
            ctx.fill();
            ctx.stroke();

            ctx.save();
            ctx.translate(200, 200);
            ctx.rotate(angle + arc / 2);
            ctx.textAlign = "right";
            ctx.fillStyle = "white";
            ctx.font = "bold 12px Arial";
            // Hanya menampilkan Nama di Roda agar tidak terlalu penuh
            ctx.fillText(p.name, 180, 5);
            ctx.restore();
        });
    }
    // FUNGSI PENCARIAN
    function filterTable(inputId, tableId) {
        let input = document.getElementById(inputId);
        let filter = input.value.toUpperCase();
        let tbody = document.getElementById(tableId);
        let tr = tbody.getElementsByTagName("tr");

        for (let i = 0; i < tr.length; i++) {
            let text = tr[i].textContent || tr[i].innerText;
            if (text.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }

    function updateTables() {
        document.getElementById('countActive').innerText = participants.length;
        document.getElementById('countEliminated').innerText = eliminated.length;

        const tbodyActive = document.getElementById('participantTable');
        tbodyActive.innerHTML = '';
        participants.forEach((p, i) => {
            tbodyActive.innerHTML += `
                <tr class="row-active">
                    <td>
                        <span class="fw-bold">${p.name}</span><br>
                        <small class="text-muted">code : ${p.id}</small>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-success" onclick="manualSelect(${i})">✅</button>
                    </td>
                </tr>`;
        });

        const tbodyEliminated = document.getElementById('eliminatedTable');
        tbodyEliminated.innerHTML = '';
        eliminated.forEach((p) => {
            tbodyEliminated.innerHTML += `
                <tr class="row-eliminated">
                    <td>
                        <span class="text-decoration-line-through text-muted">${p.name}</span><br>
                        <small class="text-danger">Terpilih: ${p.time} (${p.id})</small>
                    </td>
                </tr>`;
        });

        drawWheel();
    }

    function addName() {
        const nameInp = document.getElementById('nameInput');
        const idInp = document.getElementById('idInput');
        if (nameInp.value.trim() !== "" && idInp.value.trim() !== "") {
            participants.push({
                name: nameInp.value.trim(),
                id: idInp.value.trim()
            });
            nameInp.value = "";
            idInp.value = "";
            updateTables();
        } else {
            alert("Nama dan No Pegawai harus diisi!");
        }
    }

    function manualSelect(index) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: true
        });
        swalWithBootstrapButtons.fire({
            title: "Are you sure?",
            text: "You Want choose this user ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Setuju",
            cancelButtonText: "No, Batal!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                if (isSpinning) return;
                processElimination(index);
                console.log(index);

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Your imaginary file is safe :)",
                    icon: "error"
                });
            }
        });

    }

    function spin() {
        if (isSpinning || participants.length < 2) return;
        isSpinning = true;
        document.getElementById('winnerDisplay').innerText = "🎡 Memutar...";
        let rotations = 8 + Math.random() * 5;
        let totalAngle = rotations * 2 * Math.PI;
        let start = null;
        const duration = 3500;

        function animate(timestamp) {
            if (!start) start = timestamp;
            let elapsed = timestamp - start;
            let progress = Math.min(elapsed / duration, 1);
            let easeOut = 1 - Math.pow(1 - progress, 3);
            let currentAngle = easeOut * totalAngle;
            canvas.style.transform = `rotate(${currentAngle}rad)`;
            if (elapsed < duration) requestAnimationFrame(animate);
            else finalizeSpin(currentAngle);
        }
        requestAnimationFrame(animate);
    }

    function finalizeSpin(rotation) {
        isSpinning = false;
        const n = participants.length;
        const arc = (2 * Math.PI) / n;
        let actualRotation = rotation % (2 * Math.PI);
        let winningIndex = Math.floor((2 * Math.PI - actualRotation + (1.5 * Math.PI)) / arc) % n;

        const winner = participants[winningIndex];
        document.getElementById('winnerDisplay').innerText = "🏆 " + winner.name;
        document.getElementById('peserta_name').value = winner.name;
        document.getElementById('peserta_code').value = winner.id;
        setTimeout(() => {
            processElimination(winningIndex);
            document.getElementById('winnerDisplay').innerText = "";
            canvas.style.transform = `rotate(0rad)`;
        }, 1200);
    }

    function processElimination(index) {
        var data_arisan = document.getElementById('arisan_code').value;
        const p = participants[index];
        const now = new Date();
        const timeStr = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        });

        eliminated.unshift({
            ...p,
            time: timeStr
        });
        participants.splice(index, 1);

        $.ajax({
            url: "{{ route('menu_koperasi_arisan_proses_group_arisan_spin') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "data_peserta": p.id,
                "data_arisan": data_arisan,
            },
            dataType: 'html',
        }).done(function(data) {
            if (data == 1) {
                Swal.fire('Berhasil!', 'Selamat Untuk ' + p.name + ' Yang telah Mendapatkan giliran Arisan Bulan ini', 'success').then(() => {
                    // location.reload();
                });
                updateTables();
            } else {
                Swal.fire('Failed!', ' Gagal Menyimpan', 'error').then(() => {
                    // location.reload();
                });
            }
        }).fail(function() {
            $('#menu-koperasi-full').html('eror');
        });
    }

    updateTables();
</script>
