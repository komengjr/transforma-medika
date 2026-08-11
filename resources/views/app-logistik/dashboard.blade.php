@extends('layouts.layouts')

@section('content')
<style>
    /* Custom Styling Dashboard Logistik */
    .logistics-hero {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border: none;
    }

    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }

    .stat-card-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .chart-box {
        position: relative;
        height: 320px;
        width: 100%;
    }
</style>

<!-- 1. HERO HEADER LOGISTIK -->
<div class="card logistics-hero text-white mb-4 overflow-hidden position-relative shadow-sm">
    <div class="bg-holder d-none d-lg-block bg-card"
        style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png); opacity: 0.15;">
    </div>
    <div class="card-body position-relative z-index-1 p-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-soft-info text-info mb-2 px-3 py-1 rounded-pill fs--1">
                    <i class="fas fa-shipping-fast me-1"></i> Supply Chain & Logistics Control
                </span>
                <h3 class="text-white fw-bold mb-1">Dashboard Sistem Logistik 🚚</h3>
                <p class="mb-0 text-300 fs--1">
                    Pemantauan alur keluar-masuk barang, inventarisasi gudang medis, dan peringatan stok kritis secara kualitatif.
                </p>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <button class="btn btn-sm btn-light fw-bold rounded-pill me-2">
                    <i class="fas fa-file-export me-1"></i> Export Laporan
                </button>
                <button class="btn btn-sm btn-info rounded-pill">
                    <i class="fas fa-sync-alt me-1"></i> Sync Data
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 2. SUMMARY STATISTIC CARDS -->
<div class="row g-3 mb-4">
    <!-- Total Barang -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm hover-lift border-start border-4 border-primary h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-uppercase text-600 fw-bold fs--2">Total Jenis Barang</span>
                    <h3 class="fw-bold mb-0 text-900 mt-1">1,240 <span class="fs--2 text-muted fw-normal">SKU</span></h3>
                    <small class="text-success fs--2 fw-semibold"><i class="fas fa-arrow-up me-1"></i>+4.2% dari bulan lalu</small>
                </div>
                <div class="stat-card-icon bg-soft-primary text-primary">
                    <i class="fas fa-boxes fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Masuk -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm hover-lift border-start border-4 border-success h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-uppercase text-600 fw-bold fs--2">Inbound (Masuk)</span>
                    <h3 class="fw-bold mb-0 text-900 mt-1">520 <span class="fs--2 text-muted fw-normal">Transaksi</span></h3>
                    <small class="text-success fs--2 fw-semibold"><i class="fas fa-check-circle me-1"></i>Bulan Ini</small>
                </div>
                <div class="stat-card-icon bg-soft-success text-success">
                    <i class="fas fa-arrow-down fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Keluar -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm hover-lift border-start border-4 border-warning h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-uppercase text-600 fw-bold fs--2">Outbound (Keluar)</span>
                    <h3 class="fw-bold mb-0 text-900 mt-1">410 <span class="fs--2 text-muted fw-normal">Transaksi</span></h3>
                    <small class="text-warning fs--2 fw-semibold"><i class="fas fa-shipping-fast me-1"></i>Bulan Ini</small>
                </div>
                <div class="stat-card-icon bg-soft-warning text-warning">
                    <i class="fas fa-arrow-up fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stok Menipis -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm hover-lift border-start border-4 border-danger h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-uppercase text-600 fw-bold fs--2">Stok Kritis / Menipis</span>
                    <h3 class="fw-bold mb-0 text-danger mt-1">35 <span class="fs--2 text-muted fw-normal">Item</span></h3>
                    <small class="text-danger fs--2 fw-semibold"><i class="fas fa-exclamation-triangle me-1"></i>Butuh Re-order</small>
                </div>
                <div class="stat-card-icon bg-soft-danger text-danger">
                    <i class="fas fa-box-open fs-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. GRAFIK MONITORING -->
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold text-800"><i class="fas fa-chart-line text-primary me-2"></i>Tren Transaksi Barang (Inbound vs Outbound)</h6>
                <span class="badge bg-soft-secondary text-secondary fs--2">Tahun 2026</span>
            </div>
            <div class="card-body p-3">
                <div class="chart-box">
                    <canvas id="grafikTransaksi"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-bold text-800"><i class="fas fa-chart-pie text-info me-2"></i>Distribusi Kategori Stok</h6>
            </div>
            <div class="card-body p-3 d-flex align-items-center justify-content-center">
                <div class="chart-box" style="max-height: 280px;">
                    <canvas id="grafikKategori"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4. TABEL RINGKASAN STOK TERBARU -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
        <div>
            <h6 class="mb-0 fw-bold text-800"><i class="fas fa-table text-success me-2"></i>Ringkasan Stok Terbaru</h6>
            <small class="text-muted fs--2">Daftar pembaruan barang persediaan dalam sistem</small>
        </div>
        <a href="#" class="btn btn-link btn-sm text-decoration-none p-0 fw-bold">Lihat Semua <i class="fas fa-chevron-right ms-1"></i></a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="bg-200 text-800 fs--1">
                    <tr>
                        <th class="ps-3">Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok Saat Ini</th>
                        <th>Satuan</th>
                        <th class="text-end pe-3">Status Stok</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                    <tr>
                        <td class="ps-3"><code class="fw-bold text-primary">BRG001</code></td>
                        <td class="fw-bold text-dark">Masker Medis 3-Ply</td>
                        <td><span class="badge bg-soft-primary text-primary">Alat Kesehatan</span></td>
                        <td class="fw-bold">350</td>
                        <td>Box</td>
                        <td class="text-end pe-3"><span class="badge bg-soft-success text-success"><i class="fas fa-check me-1"></i>Aman</span></td>
                    </tr>
                    <tr>
                        <td class="ps-3"><code class="fw-bold text-primary">BRG002</code></td>
                        <td class="fw-bold text-dark">Sarung Tangan Latex</td>
                        <td><span class="badge bg-soft-primary text-primary">Alat Kesehatan</span></td>
                        <td class="fw-bold">220</td>
                        <td>Box</td>
                        <td class="text-end pe-3"><span class="badge bg-soft-success text-success"><i class="fas fa-check me-1"></i>Aman</span></td>
                    </tr>
                    <tr>
                        <td class="ps-3"><code class="fw-bold text-primary">BRG003</code></td>
                        <td class="fw-bold text-dark">Infus Set Adult</td>
                        <td><span class="badge bg-soft-info text-info">Medis</span></td>
                        <td class="fw-bold">180</td>
                        <td>Pcs</td>
                        <td class="text-end pe-3"><span class="badge bg-soft-success text-success"><i class="fas fa-check me-1"></i>Aman</span></td>
                    </tr>
                    <tr>
                        <td class="ps-3"><code class="fw-bold text-primary">BRG004</code></td>
                        <td class="fw-bold text-dark">Alkohol 70% 1 Liter</td>
                        <td><span class="badge bg-soft-warning text-warning">Bahan Kimia</span></td>
                        <td class="fw-bold text-danger">95</td>
                        <td>Botol</td>
                        <td class="text-end pe-3"><span class="badge bg-soft-danger text-danger"><i class="fas fa-exclamation-circle me-1"></i>Menipis</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- CHART.JS INTEGRATION -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Line Chart: Barang Masuk & Keluar
        const ctx = document.getElementById('grafikTransaksi').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'],
                datasets: [{
                        label: 'Barang Masuk (Inbound)',
                        data: [120, 150, 180, 200, 170, 210, 250, 300, 280, 320],
                        borderColor: '#2196f3',
                        backgroundColor: 'rgba(33, 150, 243, 0.08)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2,
                        pointRadius: 4
                    },
                    {
                        label: 'Barang Keluar (Outbound)',
                        data: [80, 100, 150, 180, 160, 190, 220, 250, 230, 270],
                        borderColor: '#ff9800',
                        backgroundColor: 'rgba(255, 152, 0, 0.08)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2,
                        pointRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Doughnut Chart: Stok Kategori
        const ctx2 = document.getElementById('grafikKategori').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Alat Kesehatan', 'Medis', 'Kimia', 'Lainnya'],
                datasets: [{
                    data: [45, 25, 20, 10],
                    backgroundColor: ['#2c7be5', '#00d27a', '#f5803e', '#6e84a3'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endsection
