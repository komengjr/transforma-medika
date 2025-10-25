@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <style>
        .container-box {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }

        h2 {
            font-weight: 600;
            color: #1e40af;
        }

        table {
            margin-top: 10px;
        }

        th {
            background-color: #3b82f6;
            color: white;
            text-align: center;
        }

        tfoot td {
            font-weight: bold;
            background: #e0f2fe;
        }

        canvas {
            margin-top: 20px;
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
    <div class="container-box">
        <h2 class="mb-3">💼 Balance Sheet (Neraca)</h2>
        <p class="text-secondary">Laporan posisi keuangan antara aset, kewajiban, dan ekuitas.</p>

        <div class="row">
            <!-- Aset -->
            <div class="col-md-6">
                <h5 class="mt-3">Aset</h5>
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nama Aset</th>
                            <th class="text-end">Nilai (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Kas dan Bank</td>
                            <td class="text-end">50.000.000</td>
                        </tr>
                        <tr>
                            <td>Piutang Usaha</td>
                            <td class="text-end">30.000.000</td>
                        </tr>
                        <tr>
                            <td>Persediaan</td>
                            <td class="text-end">20.000.000</td>
                        </tr>
                        <tr>
                            <td>Aset Tetap</td>
                            <td class="text-end">100.000.000</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total Aset</td>
                            <td class="text-end fw-bold" id="totalAset">200.000.000</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Kewajiban & Ekuitas -->
            <div class="col-md-6">
                <h5 class="mt-3">Kewajiban & Ekuitas</h5>
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nama Akun</th>
                            <th class="text-end">Nilai (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Hutang Usaha</td>
                            <td class="text-end">40.000.000</td>
                        </tr>
                        <tr>
                            <td>Hutang Bank</td>
                            <td class="text-end">20.000.000</td>
                        </tr>
                        <tr>
                            <td>Modal Pemilik</td>
                            <td class="text-end">140.000.000</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total Kewajiban + Ekuitas</td>
                            <td class="text-end fw-bold" id="totalLiab">200.000.000</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Grafik Visual -->
    <div class="container-box">
        <h4 class="mb-3">📈 Grafik Aset vs Kewajiban & Ekuitas</h4>
        <canvas id="balanceChart" height="100"></canvas>
    </div>
@endsection
@section('base.js')
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('asset/js/flatpickr.js') }}"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('balanceChart').getContext('2d');
        const balanceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Aset', 'Kewajiban', 'Ekuitas'],
                datasets: [{
                    label: 'Nilai (dalam juta Rupiah)',
                    data: [200, 60, 140],
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
                    title: {
                        display: true,
                        text: 'Perbandingan Komponen Neraca',
                        font: { size: 16 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: val => val + ' jt' }
                    }
                }
            }
        });
    </script>
@endsection
