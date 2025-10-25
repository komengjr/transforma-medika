@extends('layouts.layouts')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
    <style>
        .btn-export {
            margin-left: 5px;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .modal-content {
            border-radius: 15px;
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
    <!-- Filter Periode -->
    <div class="card mb-4 p-3">
        <form class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Periode Bulan</label>
                <select class="form-select">
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
            <div class="col-md-3">
                <label class="form-label">Tahun</label>
                <input type="number" class="form-control" value="2025">
            </div>
            <div class="col-md-5 text-end">
                <button type="button" class="btn btn-primary">Tampilkan</button>
                <button type="button" class="btn btn-success btn-export">Export Excel</button>
                <button type="button" class="btn btn-danger btn-export">Export PDF</button>
            </div>
        </form>
    </div>

    <!-- Grafik Konsolidasi -->
    <div class="card mb-4 p-3">
        <h5 class="mb-3">Perbandingan Aset vs Kewajiban + Ekuitas</h5>
        <div class="chart-container">
            <canvas id="financeChart"></canvas>
        </div>
    </div>

    <!-- Tabel Laporan Konsolidasi -->
    <div class="card p-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="mb-0">Ringkasan Konsolidasi</h5>
        </div>
        <table class="table table-striped align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>Perusahaan</th>
                    <th>Total Aset</th>
                    <th>Total Kewajiban</th>
                    <th>Ekuitas</th>
                    <th>Pendapatan</th>
                    <th>Beban</th>
                    <th>Net Profit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>PT Alpha Medika</td>
                    <td>Rp 2.500.000.000</td>
                    <td>Rp 1.200.000.000</td>
                    <td>Rp 1.300.000.000</td>
                    <td>Rp 800.000.000</td>
                    <td>Rp 600.000.000</td>
                    <td class="text-success fw-bold">Rp 200.000.000</td>
                    <td>
                        <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal"
                            data-bs-target="#detailModal">Preview</button>
                    </td>
                </tr>
                <tr>
                    <td>CV Beta Farma</td>
                    <td>Rp 1.800.000.000</td>
                    <td>Rp 900.000.000</td>
                    <td>Rp 900.000.000</td>
                    <td>Rp 600.000.000</td>
                    <td>Rp 500.000.000</td>
                    <td class="text-success fw-bold">Rp 100.000.000</td>
                    <td>
                        <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal"
                            data-bs-target="#detailModal">Preview</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
@section('base.js')
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Detail Laporan Konsolidasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Perusahaan:</strong> PT Alpha Medika</p>
                    <p>Menampilkan detail aset, kewajiban, dan ekuitas lengkap beserta laporan pendapatan dan beban...</p>
                    <ul>
                        <li>Aset Tetap: Rp 1.200.000.000</li>
                        <li>Kas & Bank: Rp 500.000.000</li>
                        <li>Piutang: Rp 800.000.000</li>
                        <li>Kewajiban Lancar: Rp 700.000.000</li>
                        <li>Kewajiban Jangka Panjang: Rp 500.000.000</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
    <script>
        // Grafik Aset vs Kewajiban + Ekuitas
        const ctx = document.getElementById('financeChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['PT Alpha Medika', 'CV Beta Farma'],
                datasets: [
                    {
                        label: 'Aset',
                        data: [2500000000, 1800000000],
                        backgroundColor: 'rgba(59, 130, 246, 0.8)'
                    },
                    {
                        label: 'Kewajiban + Ekuitas',
                        data: [2500000000, 1800000000],
                        backgroundColor: 'rgba(16, 185, 129, 0.8)'
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
@endsection
