@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <style>
        .card-header {
            background: #3b82f6;
            color: white;
            font-weight: 600;
            font-size: 22px;
            padding: 20px;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table thead {
            background: #f3f4f6;
            font-weight: 600;
        }

        .summary-card {
            border-radius: 15px;
            background: #f9fafb;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-5px);
        }

        .summary-card h4 {
            font-weight: 600;
            color: #2563eb;
        }

        .summary-card p {
            font-size: 22px;
            font-weight: 700;
            margin: 0;
        }

        .text-profit {
            color: #16a34a;
            font-weight: 700;
        }

        .text-loss {
            color: #dc2626;
            font-weight: 700;
        }

        .filter-section {
            display: flex;
            gap: 15px;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .fade-in {
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
@section('content')
    <div class="row mb-3 ">
        <div class="col">
            <div class="card bg-200 shadow border border-primary bg-primary">
                <div class="row gx-0 flex-between-center">
                    <div class="col-sm-auto d-flex align-items-center border-bottom">
                        <img class="ms-3 mx-3 m-2" src="{{ asset('img/profit.png') }}" alt="" width="50" />
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
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Profit & Loss <span
                                class="text-white fw-medium" style="color: white !important;">Statement</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>📊 Laporan Laba Rugi</span>
            <div class="filter-section">
                <input type="month" id="filterPeriode" class="form-control form-control-sm" style="max-width:180px;">
                <button class="btn btn-light btn-sm" id="btnFilter">🔍 Tampilkan</button>
            </div>
        </div>

        <div class="card-body fade-in">
            <h5 class="mb-3 fw-semibold">Pendapatan</h5>
            <table class="table table-bordered align-middle text-center" id="tablePendapatan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Keterangan</th>
                        <th>Nominal (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Penjualan Produk</td>
                        <td class="nilai">15000000</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jasa Service</td>
                        <td class="nilai">5000000</td>
                    </tr>
                </tbody>
            </table>

            <h5 class="mt-4 mb-3 fw-semibold">Beban / Pengeluaran</h5>
            <table class="table table-bordered align-middle text-center" id="tableBeban">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Keterangan</th>
                        <th>Nominal (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Gaji Karyawan</td>
                        <td class="nilai">7000000</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Sewa Kantor</td>
                        <td class="nilai">2000000</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Biaya Listrik & Air</td>
                        <td class="nilai">1000000</td>
                    </tr>
                </tbody>
            </table>

            <div class="row text-center mt-4">
                <div class="col-md-4 mb-3">
                    <div class="summary-card">
                        <h4>Total Pendapatan</h4>
                        <p id="totalPendapatan">Rp 0</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="summary-card">
                        <h4>Total Beban</h4>
                        <p id="totalBeban">Rp 0</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="summary-card">
                        <h4>Laba Bersih</h4>
                        <p id="labaBersih" class="text-profit">Rp 0</p>
                    </div>
                </div>
            </div>
        </div>
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
        const sound = document.getElementById("notifSound");

        function playSound() {
            sound.currentTime = 0;
            sound.play().catch(() => { });
        }

        function formatRupiah(angka) {
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function hitungLabaRugi() {
            const pendapatan = [...document.querySelectorAll("#tablePendapatan .nilai")].reduce((a, b) => a + Number(b.innerText), 0);
            const beban = [...document.querySelectorAll("#tableBeban .nilai")].reduce((a, b) => a + Number(b.innerText), 0);
            const laba = pendapatan - beban;

            document.getElementById("totalPendapatan").innerText = "Rp " + formatRupiah(pendapatan);
            document.getElementById("totalBeban").innerText = "Rp " + formatRupiah(beban);

            const labaEl = document.getElementById("labaBersih");
            labaEl.innerText = "Rp " + formatRupiah(laba);
            labaEl.classList.toggle("text-profit", laba >= 0);
            labaEl.classList.toggle("text-loss", laba < 0);
        }

        document.getElementById("btnFilter").addEventListener("click", () => {
            playSound();
            hitungLabaRugi();
        });

        // Jalankan saat halaman pertama dibuka
        window.onload = hitungLabaRugi;
    </script>
@endsection
