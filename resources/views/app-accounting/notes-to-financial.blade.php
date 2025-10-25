@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <style>
        h2 {
            color: #1d4ed8;
            font-weight: 600;
        }

        th {
            background: #2563eb;
            color: white;
            text-align: center;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-action {
            padding: 4px 8px;
            border-radius: 8px;
        }
    </style>
@endsection
@section('content')
    <div class="row mb-3 ">
        <div class="col">
            <div class="card bg-200 shadow border border-primary bg-primary">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/balance.png') }}" alt="" width="50" />
                        <div>
                            <h6 class="text-white fs--1 mb-0 pt-2" style="color: white !important;">Welcome to </h6>
                            <h4 class="text-white fw-bold mb-1" style="color: white !important;">{{ Env('APP_LABEL') }}
                                <span class="text-white fw-medium" style="color: white !important;">Management
                                    System</span>
                            </h4>
                        </div>
                        <img class="ms-n4 d-none d-lg-block "
                            src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                    </div>
                    <div class="col-xl-auto px-3 py-2">
                        <h6 class="text-white fs--1 mb-0" style="color: white !important;">Menu : </h6>
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Balance <span
                                class="text-white fw-medium" style="color: white !important;"> Sheets</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mb-4">🧾 Notes to Financial Statement</h2>

    <!-- Filter Periode -->
    <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 gap-2">
        <div class="d-flex gap-2">
            <div>
                <label>Bulan:</label>
                <select id="bulan" class="form-select">
                    <option>Januari</option>
                    <option>Februari</option>
                    <option>Maret</option>
                    <option>April</option>
                    <option>Mei</option>
                    <option>Juni</option>
                    <option>Juli</option>
                    <option>Agustus</option>
                    <option>September</option>
                    <option>Oktober</option>
                    <option>November</option>
                    <option>Desember</option>
                </select>
            </div>
            <div>
                <label>Tahun:</label>
                <select id="tahun" class="form-select"></select>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNote">➕ Tambah Catatan</button>
            <button class="btn btn-success" onclick="exportExcel()">📗 Excel</button>
            <button class="btn btn-danger" onclick="exportPDF()">📕 PDF</button>
        </div>
    </div>

    <!-- Notes Table -->
    <div class="card p-4 mb-4">
        <h5 id="periodeText" class="text-primary mb-3">Periode: Januari 2025</h5>
        <table id="notesTable" class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Akun</th>
                    <th>Deskripsi</th>
                    <th class="text-end">Nilai (Rp)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
    </div>

    <!-- Grafik -->
    <div class="card p-4">
        <h5>📊 Komposisi Akun Utama</h5>
        <canvas id="notesChart" height="120"></canvas>
    </div>
@endsection
@section('base.js')
    <div class="modal fade" id="modalNote" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah / Edit Catatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="noteForm">
                        <input type="hidden" id="editIndex">
                        <div class="mb-3">
                            <label>Akun</label>
                            <input type="text" id="akun" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Deskripsi / Catatan</label>
                            <textarea id="deskripsi" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Nilai (Rp)</label>
                            <input type="number" id="nilai" class="form-control" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" onclick="simpanNote()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('asset/js/flatpickr.js') }}"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        // ===== Data Awal =====
        let notes = [
            { akun: "Kas dan Setara Kas", deskripsi: "Kas dan rekening bank yang siap digunakan.", nilai: 50000000 },
            { akun: "Piutang Usaha", deskripsi: "Piutang dari pelanggan belum tertagih.", nilai: 35000000 },
            { akun: "Persediaan Barang", deskripsi: "Barang dagang yang masih tersisa di akhir periode.", nilai: 25000000 },
            { akun: "Utang Usaha", deskripsi: "Kewajiban perusahaan kepada pemasok.", nilai: -40000000 },
        ];

        const tableBody = document.getElementById("tableBody");
        const ctx = document.getElementById("notesChart").getContext("2d");
        let chart;

        // ===== Render Table =====
        function renderTable() {
            tableBody.innerHTML = "";
            notes.forEach((n, i) => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                          <td>${i + 1}</td>
                          <td>${n.akun}</td>
                          <td>${n.deskripsi}</td>
                          <td class="text-end">${n.nilai.toLocaleString("id-ID")}</td>
                          <td class="text-center">
                            <button class="btn btn-sm btn-warning btn-action" onclick="editNote(${i})">✏️</button>
                            <button class="btn btn-sm btn-danger btn-action" onclick="hapusNote(${i})">🗑️</button>
                          </td>
                        `;
                tableBody.appendChild(tr);
            });
            renderChart();
        }

        // ===== Chart =====
        function renderChart() {
            const labels = notes.map(n => n.akun);
            const data = notes.map(n => n.nilai);
            if (chart) chart.destroy();
            chart = new Chart(ctx, {
                type: "pie",
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            "#3b82f6", "#10b981", "#f59e0b", "#6366f1", "#ef4444", "#22c55e"
                        ],
                    }]
                },
                options: {
                    plugins: {
                        legend: { position: "bottom" },
                        title: { display: true, text: "Komposisi Akun", font: { size: 16 } }
                    }
                }
            });
        }

        // ===== Tambah / Edit Note =====
        function simpanNote() {
            const akun = document.getElementById("akun").value.trim();
            const deskripsi = document.getElementById("deskripsi").value.trim();
            const nilai = parseFloat(document.getElementById("nilai").value);
            const index = document.getElementById("editIndex").value;

            if (!akun || !deskripsi || isNaN(nilai)) return alert("Lengkapi semua data!");

            if (index === "") {
                notes.push({ akun, deskripsi, nilai });
            } else {
                notes[index] = { akun, deskripsi, nilai };
            }

            document.getElementById("noteForm").reset();
            document.getElementById("editIndex").value = "";
            bootstrap.Modal.getInstance(document.getElementById("modalNote")).hide();
            renderTable();
        }

        // ===== Edit =====
        function editNote(i) {
            const n = notes[i];
            document.getElementById("akun").value = n.akun;
            document.getElementById("deskripsi").value = n.deskripsi;
            document.getElementById("nilai").value = n.nilai;
            document.getElementById("editIndex").value = i;
            new bootstrap.Modal(document.getElementById("modalNote")).show();
        }

        // ===== Hapus =====
        function hapusNote(i) {
            if (confirm("Yakin ingin menghapus catatan ini?")) {
                notes.splice(i, 1);
                renderTable();
            }
        }

        // ===== Export Excel =====
        function exportExcel() {
            const wb = XLSX.utils.json_to_sheet(notes);
            const book = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(book, wb, "Notes");
            XLSX.writeFile(book, "Notes_to_Financial.xlsx");
        }

        // ===== Export PDF =====
        function exportPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF("p", "pt", "a4");
            doc.text("Notes to Financial Statement", 40, 40);
            let y = 70;
            notes.forEach((n, i) => {
                doc.text(`${i + 1}. ${n.akun} - Rp${n.nilai.toLocaleString("id-ID")}`, 40, y);
                doc.text(`   ${n.deskripsi}`, 40, y + 20);
                y += 40;
            });
            doc.save("Notes_to_Financial_Statement.pdf");
        }

        // ===== Init =====
        const tahunSelect = document.getElementById("tahun");
        const currentYears = new Date().getFullYear();
        for (let i = currentYears; i >= currentYears - 5; i--) {
            const opt = document.createElement("option");
            opt.textContent = i;
            tahunSelect.appendChild(opt);
        }

        renderTable();
    </script>
@endsection
