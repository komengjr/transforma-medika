<div class="modal-body p-0">
    <div class="bg-dark rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1 text-white" id="staticBackdropLabel">List Antrian Hari Ini</h4>
        <p class="fs--2 mb-0 text-warning">Support by <a class="text-warning fw-semi-bold"
                href="#!">{{env('APP_LABEL')}}</a>
        </p>
    </div>
    <div class="p-3" id="menu-modal-antrian">
        <table id="example" class="table table-striped" style="width:100%">
            <thead class="bg-200 text-700 fs--1">
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Waktu Antrian</th>
                    <th>Layanan</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody class="fs--1">
                @php
                    $no = 1;
                @endphp
                <tr>
                    <td>1</td>
                    <td>A0023</td>
                    <td>08:05:00</td>
                    <td>Front Office</td>
                    <td></td>
                    <td class="text-center">
                        <button class="btn-primary" id="panggil" data-code="A0020"><span
                                class="fab fa-spotify"></span></button>
                        <button class="btn-warning"><span class="fas fa-sim-card"></span></button>
                        <button class="btn-dark"><span class="fas fa-question-circle"></span></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    new DataTable('#example', {
        responsive: true
    });
</script>

<script>
    const socket = io("http://127.0.0.1:3000", {
        transports: ["websocket", "polling"]
    });
    $(document).on("click", "#panggil", function (e) {
        e.preventDefault();
        var code = $(this).data("code");
        const loket = "loket 20";
        const nomor = code;
        if (!nomor) return alert("Masukkan nomor antrian!");

        socket.emit("panggil", { loket, nomor });
    });
    // document.getElementById("panggil").onclick = () => {
    //     var code = $(this).data("code");

    // };
</script>
