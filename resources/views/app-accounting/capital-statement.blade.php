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
                        <h4 class="text-white fw-bold mb-0" style="color: white !important;">Capital <span
                                class="text-white fw-medium" style="color: white !important;"> Statement</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-box">
        <h2>🏦 Capital Statement (Laporan Perubahan Modal)</h2>
        <p class="text-secondary">Menunjukkan perubahan modal pemilik selama periode tertentu.</p>

        <div class="row mt-4">
            <div class="col-md-6">
                <h5>📅 Periode: Januari - Desember 2025</h5>
                <table class="table table-bordered table-striped align-middle mt-3">
                    <thead>
                        <tr>
                            <th>Deskripsi</th>
                            <th class="text-end">Jumlah (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Modal Awal</td>
                            <td class="text-end">100.000.000</td>
                        </tr>
                        <tr>
                            <td>Tambahan Investasi</td>
                            <td class="text-end">25.000.000</td>
                        </tr>
                        <tr>
                            <td>Penarikan Pribadi (Prive)</td>
                            <td class="text-end text-danger">-10.000.000</td>
                        </tr>
                        <tr>
                            <td>Laba Bersih Tahun Berjalan</td>
                            <td class="text-end text-success">35.000.000</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total Modal Akhir</td>
                            <td class="text-end fw-bold" id="totalCapital">150.000.000</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="col-md-6">
                <h5 class="mt-3">📈 Grafik Perubahan Modal</h5>
                <canvas id="capitalChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="container-box">
        <h4>🧾 Keterangan</h4>
        <ul>
            <li><b>Modal Awal:</b> Jumlah modal pemilik di awal periode.</li>
            <li><b>Tambahan Investasi:</b> Penambahan modal yang disetor selama periode berjalan.</li>
            <li><b>Prive:</b> Penarikan modal oleh pemilik.</li>
            <li><b>Laba Bersih:</b> Keuntungan bersih yang menambah modal.</li>
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
        const ctx = document.getElementById('capitalChart').getContext('2d');
        const capitalChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Modal Awal', 'Investasi Tambahan', 'Prive', 'Laba Bersih', 'Modal Akhir'],
                datasets: [{
                    label: 'Perubahan Modal (juta Rupiah)',
                    data: [100, 125, 115, 150, 150],
                    fill: true,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    tension: 0.3,
                    borderWidth: 3,
                    pointRadius: 6,
                    pointBackgroundColor: '#2563eb'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Grafik Pergerakan Modal Pemilik',
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
