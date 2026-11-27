@extends('layouts.layouts')

@section('base.css')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-grid-border: rgba(99, 102, 241, 0.14);
        --ent-surface: #ffffff;
        --ent-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark,
    body.dark-mode {
        --ent-surface: #0f172a;
        --ent-text: #f8fafc;
        --ent-grid-border: rgba(148, 163, 184, 0.16);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1rem;
    }

    /* Skala Font Standar: fs-2 (default), fs-1, fs--1, fs--2 */
    .fs-2 {
        font-size: 1rem !important;
        line-height: 1.55;
    }

    .fs-1 {
        font-size: 1.15rem !important;
        line-height: 1.4;
    }

    .fs--1 {
        font-size: 0.875rem !important;
        line-height: 1.5;
    }

    .fs--2 {
        font-size: 0.75rem !important;
        line-height: 1.4;
    }

    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.25) !important;
        border-radius: 14px;
        box-shadow: 0 10px 24px -6px rgba(15, 23, 42, 0.2);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.2) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 12px;
        color: #ffffff;
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 14px;
        background-color: var(--bs-body-bg, var(--ent-surface));
        box-shadow: 0 2px 12px -2px rgba(15, 23, 42, 0.05);
        transition: all 0.25s ease;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.05) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        padding: 14px 20px;
    }

    .cardreader:hover {
        transform: translateY(-2px);
        border-color: rgba(79, 70, 229, 0.35) !important;
        box-shadow: 0 8px 20px -4px rgba(15, 23, 42, 0.1) !important;
    }

    .icon-shape {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        flex-shrink: 0;
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        letter-spacing: 0.03em;
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
    }

    .ent-btn:hover:not(:disabled) {
        transform: translateY(-1px);
    }

    .table-custom {
        width: 100% !important;
        border-collapse: collapse !important;
        margin-bottom: 0 !important;
    }

    .table-custom thead th {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        padding: 12px 14px;
        white-space: nowrap;
    }

    .table-custom tbody td {
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 11px 14px;
        vertical-align: middle;
    }

    .table-custom tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.04) !important;
    }

    .chart-box {
        position: relative;
        height: 310px;
        width: 100%;
    }

    .ent-mono {
        font-family: 'JetBrains Mono', monospace;
    }
</style>
@endsection

@section('content')
<!-- 1. HERO HEADER LOGISTIK -->
<header class="mb-3 fs-2">
    <div class="card ent-header-banner p-1">
        <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
            <div class="row align-items-center justify-content-between gy-3">
                <div class="col-lg-8 d-flex align-items-center">
                    <div class="ent-glass-pill me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 56px; height: 56px;">
                        <i class="fas fa-truck-loading fs-1 text-white"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="ent-badge fs--2" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.35); color: #7dd3fc;">
                                <i class="fas fa-shipping-fast"></i> Supply Chain &amp; Logistics Control
                            </span>
                            <span class="fs--2 fw-semibold" style="color: #94a3b8;">{{ env('APP_NAME', 'INNOVENTRA') }} Management System</span>
                        </div>
                        <h4 class="text-white fw-bold mb-0 fs-1" style="letter-spacing: -0.02em;">
                            Dashboard Sistem Logistik
                        </h4>
                        <p class="mb-0 fs--1" style="color: #cbd5e1;">
                            Pemantauan alur keluar-masuk barang, inventarisasi gudang medis, dan peringatan stok kritis secara real-time.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-inline-flex flex-wrap gap-2 justify-content-lg-end">
                        <button type="button" class="btn btn-sm ent-btn ent-glass-pill px-3 py-2 fs--1">
                            <i class="fas fa-file-export me-1 text-warning"></i> Export Laporan
                        </button>
                        <button type="button" class="btn btn-sm ent-btn px-3 py-2 fs--1 fw-bold"
                            style="background: rgba(56, 189, 248, 0.24); border: 1px solid rgba(56, 189, 248, 0.45); color: #ffffff;">
                            <i class="fas fa-sync-alt me-1"></i> Sync Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- 2. SUMMARY STATISTIC CARDS -->
<div class="row g-3 mb-3 fs-2">
    <!-- Total Barang -->
    <div class="col-sm-6 col-xl-3">
        <div class="card ent-card cardreader p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Total Jenis Barang</div>
                    <div class="fs-1 fw-bold text-primary ent-mono">1,240 <span class="fs--2 opacity-75 fw-normal">SKU</span></div>
                    <small class="text-success fs--2 fw-semibold"><i class="fas fa-arrow-up me-1"></i>+4.2% dari bulan lalu</small>
                </div>
                <div class="icon-shape" style="background: rgba(79, 70, 229, 0.12); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                    <i class="fas fa-boxes fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Masuk -->
    <div class="col-sm-6 col-xl-3">
        <div class="card ent-card cardreader p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Inbound (Masuk)</div>
                    <div class="fs-1 fw-bold text-success ent-mono">520 <span class="fs--2 opacity-75 fw-normal">Transaksi</span></div>
                    <small class="text-success fs--2 fw-semibold"><i class="fas fa-check-circle me-1"></i>Bulan Ini</small>
                </div>
                <div class="icon-shape" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">
                    <i class="fas fa-arrow-down fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Keluar -->
    <div class="col-sm-6 col-xl-3">
        <div class="card ent-card cardreader p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Outbound (Keluar)</div>
                    <div class="fs-1 fw-bold text-warning ent-mono">410 <span class="fs--2 opacity-75 fw-normal">Transaksi</span></div>
                    <small class="text-warning fs--2 fw-semibold"><i class="fas fa-shipping-fast me-1"></i>Bulan Ini</small>
                </div>
                <div class="icon-shape" style="background: rgba(245, 158, 11, 0.14); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.24);">
                    <i class="fas fa-arrow-up fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stok Menipis -->
    <div class="col-sm-6 col-xl-3">
        <div class="card ent-card cardreader p-3 h-100">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-uppercase fw-bold opacity-75 fs--2 mb-1">Stok Kritis / Menipis</div>
                    <div class="fs-1 fw-bold text-danger ent-mono">35 <span class="fs--2 opacity-75 fw-normal">Item</span></div>
                    <small class="text-danger fs--2 fw-semibold"><i class="fas fa-exclamation-triangle me-1"></i>Butuh Re-order</small>
                </div>
                <div class="icon-shape" style="background: rgba(225, 29, 72, 0.12); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.2);">
                    <i class="fas fa-box-open fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. GRAFIK MONITORING -->
<div class="row g-3 mb-3 fs-2">
    <div class="col-lg-8">
        <div class="card ent-card h-100">
            <div class="ent-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h6 class="mb-0 fw-bold fs-1"><i class="fas fa-chart-line text-primary me-2"></i>Tren Transaksi Barang (Inbound vs Outbound)</h6>
                    <span class="opacity-75 fs--1">Perbandingan volume barang masuk dan keluar bulanan.</span>
                </div>
                <span class="ent-badge fs--2 ent-mono" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                    Tahun 2026
                </span>
            </div>
            <div class="card-body p-3 p-md-4">
                <div class="chart-box">
                    <canvas id="grafikTransaksi"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card ent-card h-100">
            <div class="ent-card-header">
                <h6 class="mb-0 fw-bold fs-1"><i class="fas fa-chart-pie text-info me-2"></i>Distribusi Kategori Stok</h6>
                <span class="opacity-75 fs--1">Proporsi persediaan per kelompok barang.</span>
            </div>
            <div class="card-body p-3 p-md-4 d-flex align-items-center justify-content-center">
                <div class="chart-box" style="max-height: 290px;">
                    <canvas id="grafikKategori"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4. TABEL RINGKASAN STOK TERBARU -->
<div class="card ent-card mb-3 fs-2">
    <div class="ent-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h6 class="mb-0 fw-bold fs-1"><i class="fas fa-table text-success me-2"></i>Ringkasan Stok Terbaru</h6>
            <span class="opacity-75 fs--1">Daftar pembaruan barang persediaan dalam sistem logistik.</span>
        </div>
        <a href="#" class="btn btn-sm ent-btn btn-outline-primary px-3 py-1 fs--2">
            Lihat Semua <i class="fas fa-chevron-right ms-1"></i>
        </a>
    </div>
    <div class="card-body p-3 p-md-4">
        <div class="table-responsive rounded-3" style="border: 1px solid var(--ent-grid-border);">
            <table class="table table-hover table-custom align-middle mb-0 w-100 fs-2">
                <thead>
                    <tr class="fs--2">
                        <th style="width: 130px;">Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th class="text-end">Stok Saat Ini</th>
                        <th>Satuan</th>
                        <th class="text-center" style="width: 150px;">Status Stok</th>
                    </tr>
                </thead>
                <tbody class="fs--1">
                    <tr>
                        <td class="ent-mono">
                            <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                BRG001
                            </span>
                        </td>
                        <td class="fw-bold fs-2">Masker Medis 3-Ply</td>
                        <td>
                            <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                Alat Kesehatan
                            </span>
                        </td>
                        <td class="text-end ent-mono fw-bold fs-2">350</td>
                        <td class="opacity-75">Box</td>
                        <td class="text-center">
                            <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);">
                                <i class="fas fa-check-circle"></i> Aman
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="ent-mono">
                            <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                BRG002
                            </span>
                        </td>
                        <td class="fw-bold fs-2">Sarung Tangan Latex</td>
                        <td>
                            <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                Alat Kesehatan
                            </span>
                        </td>
                        <td class="text-end ent-mono fw-bold fs-2">220</td>
                        <td class="opacity-75">Box</td>
                        <td class="text-center">
                            <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);">
                                <i class="fas fa-check-circle"></i> Aman
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="ent-mono">
                            <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                BRG003
                            </span>
                        </td>
                        <td class="fw-bold fs-2">Infus Set Adult</td>
                        <td>
                            <span class="ent-badge fs--2" style="background: rgba(2, 132, 199, 0.12); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.24);">
                                Medis
                            </span>
                        </td>
                        <td class="text-end ent-mono fw-bold fs-2">180</td>
                        <td class="opacity-75">Pcs</td>
                        <td class="text-center">
                            <span class="ent-badge fs--2" style="background: rgba(16, 185, 129, 0.14); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25);">
                                <i class="fas fa-check-circle"></i> Aman
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="ent-mono">
                            <span class="ent-badge fs--2" style="background: rgba(79, 70, 229, 0.1); color: #6366f1; border: 1px solid rgba(79, 70, 229, 0.2);">
                                BRG004
                            </span>
                        </td>
                        <td class="fw-bold fs-2">Alkohol 70% 1 Liter</td>
                        <td>
                            <span class="ent-badge fs--2" style="background: rgba(245, 158, 11, 0.15); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.28);">
                                Bahan Kimia
                            </span>
                        </td>
                        <td class="text-end ent-mono fw-bold fs-2 text-danger">95</td>
                        <td class="opacity-75">Botol</td>
                        <td class="text-center">
                            <span class="ent-badge fs--2" style="background: rgba(225, 29, 72, 0.14); color: #e11d48; border: 1px solid rgba(225, 29, 72, 0.25);">
                                <i class="fas fa-exclamation-circle"></i> Menipis
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark' || document.body.classList.contains('dark-mode');
        const labelColor = isDark ? '#cbd5e1' : '#475569';
        const gridColor = isDark ? 'rgba(148, 163, 184, 0.12)' : 'rgba(99, 102, 241, 0.08)';

        // Line Chart: Barang Masuk & Keluar
        const ctx = document.getElementById('grafikTransaksi').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'],
                datasets: [{
                        label: 'Barang Masuk (Inbound)',
                        data: [120, 150, 180, 200, 170, 210, 250, 300, 280, 320],
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointBackgroundColor: '#4f46e5'
                    },
                    {
                        label: 'Barang Keluar (Outbound)',
                        data: [80, 100, 150, 180, 160, 190, 220, 250, 230, 270],
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14, 165, 233, 0.1)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2.5,
                        pointRadius: 4,
                        pointBackgroundColor: '#0ea5e9'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: labelColor,
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif",
                                weight: '600'
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: labelColor
                        },
                        grid: {
                            color: gridColor
                        }
                    },
                    x: {
                        ticks: {
                            color: labelColor
                        },
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
                    backgroundColor: ['#4f46e5', '#0ea5e9', '#10b981', '#f59e0b'],
                    borderWidth: 2,
                    borderColor: isDark ? '#0f172a' : '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: labelColor,
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif",
                                weight: '600'
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endsection
