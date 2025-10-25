@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .container-box {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 30px;
        }

        h2,
        h4 {
            color: #1e40af;
            font-weight: 600;
        }

        th {
            background: #3b82f6;
            color: white;
            text-align: center;
        }

        tfoot td {
            font-weight: bold;
            background: #e0f2fe;
        }
    </style>
@endsection
@section('content')
    <div class="row mb-3 ">
        <div class="col">
            <div class="card bg-200 shadow border border-primary bg-primary">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/capital.png') }}" alt="" width="50" />
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
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Cash <span
                                class="text-white fw-medium" style="color: white !important;"> Flow</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-box">
        <h2>💰 Cash Flow Statement (Laporan Arus Kas)</h2>
        <p class="text-secondary">Menunjukkan arus kas masuk dan keluar dari aktivitas operasi, investasi, dan pendanaan.
        </p>

        <!-- Filter -->
        <div class="filter-box">
            <div>
                <label>Bulan:</label>
                <select id="bulan" class="form-select">
                    <option value="Januari">Januari</option>
                    <option value="Februari">Februari</option>
                    <option value="Maret">Maret</option>
                    <option value="April">April</option>
                    <option value="Mei">Mei</option>
                    <option value="Juni">Juni</option>
                    <option value="Juli">Juli</option>
                    <option value="Agustus">Agustus</option>
                    <option value="September">September</option>
                    <option value="Oktober">Oktober</option>
                    <option value="November">November</option>
                    <option value="Desember">Desember</option>
                </select>
            </div>
            <div>
                <label>Tahun:</label>
                <select id="tahun" class="form-select">
                    <script>
                        const currentYear = new Date().getFullYear();
                        for (let y = currentYear; y >= currentYear - 5; y--) {
                            document.write(`<option value="${y}">${y}</option>`);
                        }
                    </script>
                </select>
            </div>
            <div class="d-flex align-items-end">
                <button class="btn btn-primary" onclick="filterLaporan()">Tampilkan</button>
            </div>
            <div class="ms-auto d-flex align-items-end gap-2">
                <button class="btn btn-success" onclick="exportExcel()">📗 Export Excel</button>
                <button class="btn btn-danger" onclick="exportPDF()">📕 Export PDF</button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <h5 id="periodeText">📅 Periode: Januari 2025</h5>
                <table id="cashFlowTable" class="table table-bordered table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Aktivitas</th>
                            <th class="text-end">Nilai (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>Arus Kas dari Aktivitas Operasi</b></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Penerimaan dari Pelanggan</td>
                            <td class="text-end">200.000.000</td>
                        </tr>
                        <tr>
                            <td>Pembayaran kepada Pemasok</td>
                            <td class="text-end text-danger">-120.000.000</td>
                        </tr>
                        <tr>
                            <td>Pembayaran Gaji & Biaya Operasional</td>
                            <td class="text-end text-danger">-50.000.000</td>
                        </tr>
                        <tr class="table-info fw-bold">
                            <td>Kas Bersih dari Aktivitas Operasi</td>
                            <td class="text-end">30.000.000</td>
                        </tr>

                        <tr>
                            <td><b>Arus Kas dari Aktivitas Investasi</b></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Pembelian Aset Tetap</td>
                            <td class="text-end text-danger">-40.000.000</td>
                        </tr>
                        <tr>
                            <td>Penjualan Aset Lama</td>
                            <td class="text-end">10.000.000</td>
                        </tr>
                        <tr class="table-info fw-bold">
                            <td>Kas Bersih dari Aktivitas Investasi</td>
                            <td class="text-end">-30.000.000</td>
                        </tr>

                        <tr>
                            <td><b>Arus Kas dari Aktivitas Pendanaan</b></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Penerimaan Pinjaman Bank</td>
                            <td class="text-end">25.000.000</td>
                        </tr>
                        <tr>
                            <td>Pembayaran Angsuran Pinjaman</td>
                            <td class="text-end text-danger">-15.000.000</td>
                        </tr>
                        <tr class="table-info fw-bold">
                            <td>Kas Bersih dari Aktivitas Pendanaan</td>
                            <td class="text-end">10.000.000</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total Kenaikan (Penurunan) Kas</td>
                            <td class="text-end fw-bold text-success">10.000.000</td>
                        </tr>
                        <tr>
                            <td>Saldo Kas Awal Periode</td>
                            <td class="text-end">40.000.000</td>
                        </tr>
                        <tr>
                            <td>Saldo Kas Akhir Periode</td>
                            <td class="text-end fw-bold">50.000.000</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="col-md-6">
                <h5>📊 Grafik Arus Kas per Aktivitas</h5>
                <canvas id="cashFlowChart" height="130"></canvas>
            </div>
        </div>
    </div>

    <div class="container-box">
        <h4>🧾 Keterangan</h4>
        <ul>
            <li><b>Aktivitas Operasi:</b> Arus kas dari kegiatan utama seperti penjualan & pembelian operasional.</li>
            <li><b>Aktivitas Investasi:</b> Pembelian atau penjualan aset jangka panjang.</li>
            <li><b>Aktivitas Pendanaan:</b> Transaksi yang memengaruhi struktur modal (pinjaman, modal, dividen).</li>
        </ul>
    </div>
@endsection
@section('base.js')
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('asset/js/flatpickr.js') }}"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script>
        // ======== GRAFIK ========
        const ctx = document.getElementById('cashFlowChart').getContext('2d');
        let cashFlowChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Operasi', 'Investasi', 'Pendanaan'],
                datasets: [{
                    label: 'Arus Kas Bersih (juta Rupiah)',
                    data: [30, -30, 10],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(239, 68, 68, 0.7)',
                        'rgba(34, 197, 94, 0.7)'
                    ],
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'Visualisasi Arus Kas Bersih per Aktivitas', font: { size: 16 } }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { callback: val => val + ' jt' } }
                }
            }
        });

        // ======== FILTER PERIODE ========
        function filterLaporan() {
            const bulan = document.getElementById('bulan').value;
            const tahun = document.getElementById('tahun').value;
            document.getElementById('periodeText').innerText = `📅 Periode: ${bulan} ${tahun}`;
            alert(`Laporan Arus Kas periode ${bulan} ${tahun} ditampilkan.`);
        }

        // ======== EXPORT EXCEL ========
        function exportExcel() {
            const table = document.getElementById("cashFlowTable");
            const wb = XLSX.utils.table_to_book(table, { sheet: "Cash Flow" });
            XLSX.writeFile(wb, "Laporan_Arus_Kas.xlsx");
        }

        // ======== EXPORT PDF ========
        function exportPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF("p", "pt", "a4");
            doc.text("Laporan Arus Kas", 40, 40);
            doc.text(document.getElementById("periodeText").innerText, 40, 60);

            const table = document.getElementById("cashFlowTable");
            let rows = [];
            for (let r of table.rows) {
                let row = [];
                for (let cell of r.cells) row.push(cell.innerText);
                rows.push(row);
            }

            let y = 90;
            rows.forEach(row => {
                doc.text(row.join(" | "), 40, y);
                y += 20;
            });

            doc.save("Laporan_Arus_Kas.pdf");
        }
    </script>
@endsection
