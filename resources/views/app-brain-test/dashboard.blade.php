@extends('layouts.layouts')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Welcome Banner Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white border-0 shadow-sm rounded-4 p-4" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-1">Selamat Datang di Brain Test! 👋</h2>
                        <p class="mb-3 text-white-50">Siapkan dirimu untuk menaklukkan Tes IQ, Psikotes, dan CAT BUMN hari ini. Pilih kategori tes di bawah untuk mulai berlatih.</p>
                        <a href="#kategori-tes" class="btn btn-light text-primary fw-semibold px-4 rounded-pill shadow-sm">Mulai Tes Sekarang</a>
                    </div>
                    <div class="col-md-4 text-center d-none d-md-block">
                        <i class="bi bi-cpu-fill" style="font-size: 5rem; opacity: 0.2;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-primary border-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <span class="text-muted small text-uppercase fw-bold">Total Tes Dikerjakan</span>
                            <h4 class="fw-bold mb-0 text-dark mt-1">12</h4>
                        </div>
                        <div class="col-auto">
                            <div class="icon-shape bg-primary text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="bi bi-journal-check fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-success border-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <span class="text-muted small text-uppercase fw-bold">Rata-Rata Skor IQ</span>
                            <h4 class="fw-bold mb-0 text-dark mt-1">115 <span class="badge bg-success-subtle text-success fs-6 fw-normal">Superior</span></h4>
                        </div>
                        <div class="col-auto">
                            <div class="icon-shape bg-success text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="bi bi-graph-up-arrow fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-warning border-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <span class="text-muted small text-uppercase fw-bold">Simulasi CAT BUMN</span>
                            <h4 class="fw-bold mb-0 text-dark mt-1">4 Selesai</h4>
                        </div>
                        <div class="col-auto">
                            <div class="icon-shape bg-warning text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="bi bi-building fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 border-start border-info border-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <span class="text-muted small text-uppercase fw-bold">Peringkat Nasional</span>
                            <h4 class="fw-bold mb-0 text-dark mt-1">#142</h4>
                        </div>
                        <div class="col-auto">
                            <div class="icon-shape bg-info text-white rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="bi bi-award fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kategori Tes Utama -->
    <div class="row mb-4" id="kategori-tes">
        <div class="col-12 mb-3">
            <h5 class="fw-bold text-dark m-0"><i class="bi bi-grid-fill text-primary me-2"></i>Pilih Kategori Tes</h5>
        </div>

        <!-- Tes IQ -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow transition">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="bg-primary-subtle text-primary rounded-3 p-3 d-inline-block mb-3">
                            <i class="bi bi-cpu fs-3"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Tes IQ & Kognitif</h4>
                        <p class="text-muted small mb-4">Uji kemampuan logika, spasial, numerik, dan verbal untuk mengukur kapasitas intelektualmu secara akurat.</p>
                    </div>
                    <a href="#" class="btn btn-outline-primary rounded-pill w-100 fw-semibold">Mulai Tes IQ</a>
                </div>
            </div>
        </div>

        <!-- Tes Psikotes Kerja -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow transition">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="bg-success-subtle text-success rounded-3 p-3 d-inline-block mb-3">
                            <i class="bi bi-person-badge fs-3"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Psikotes & Kepribadian</h4>
                        <p class="text-muted small mb-4">Simulasi lengkap tes koran (Pauli/Kraepelin), tes kepribadian DISC, PAPI Kostick, dan ketelitian kerja.</p>
                    </div>
                    <a href="#" class="btn btn-outline-success rounded-pill w-100 fw-semibold">Mulai Psikotes</a>
                </div>
            </div>
        </div>

        <!-- CAT BUMN & CPNS -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow transition">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="bg-warning-subtle text-warning rounded-3 p-3 d-inline-block mb-3">
                            <i class="bi bi-building-check fs-3"></i>
                        </div>
                        <h4 class="fw-bold text-dark">CAT BUMN & CPNS</h4>
                        <p class="text-muted small mb-4">Latihan soal TWK, TIU, TKP, dan Core Values AKHLAK BUMN dengan sistem waktu otomatis ala CAT resmi.</p>
                    </div>
                    <a href="#" class="btn btn-outline-warning text-dark rounded-pill w-100 fw-semibold">Mulai CAT BUMN</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat & Aktivitas Terakhir -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark m-0"><i class="bi bi-clock-history text-secondary me-2"></i>Riwayat Tes Terakhir</h5>
                    <a href="#" class="text-decoration-none small fw-bold">Lihat Semua</a>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-uppercase fs-7">
                                <tr>
                                    <th class="py-3 rounded-start">Jenis Tes</th>
                                    <th class="py-3">Kategori</th>
                                    <th class="py-3">Tanggal</th>
                                    <th class="py-3">Skor / Hasil</th>
                                    <th class="py-3 text-end rounded-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-semibold text-dark">Simulasi CAT BUMN Paket 1</td>
                                    <td><span class="badge bg-warning-subtle text-warning">CAT BUMN</span></td>
                                    <td class="text-muted">05 Okt 2026</td>
                                    <td><span class="badge bg-success">780 (Lulus Passing Grade)</span></td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-light text-primary fw-semibold">Detail</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-dark">Tes IQ Standar Kognitif</td>
                                    <td><span class="badge bg-primary-subtle text-primary">Tes IQ</span></td>
                                    <td class="text-muted">02 Okt 2026</td>
                                    <td><span class="badge bg-info">118 (Superior)</span></td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-light text-primary fw-semibold">Detail</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-dark">Simulasi Kraepelin & Pauli</td>
                                    <td><span class="badge bg-success-subtle text-success">Psikotes</span></td>
                                    <td class="text-muted">28 Sep 2026</td>
                                    <td><span class="badge bg-secondary">Stabil (Grafik Baik)</span></td>
                                    <td class="text-end">
                                        <a href="#" class="btn btn-sm btn-light text-primary fw-semibold">Detail</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
