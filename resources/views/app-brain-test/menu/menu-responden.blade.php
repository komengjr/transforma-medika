@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    :root {
        --ent-indigo: #4f46e5;
        --ent-indigo-dark: #4338ca;
        --ent-indigo-soft: rgba(79, 70, 229, 0.12);
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-emerald: #059669;
        --ent-sky: #0284c7;
        --ent-amber: #d97706;
        --ent-rose: #e11d48;
        --ent-solid-bg: #ffffff;
        --ent-solid-text: #0f172a;
    }

    [data-bs-theme="dark"],
    .dark {
        --ent-solid-bg: #0f172a;
        --ent-solid-text: #f8fafc;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .font-mono-code {
        font-family: 'JetBrains Mono', monospace;
    }

    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 15px 20px;
    }

    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 18px;
        box-shadow: 0 14px 32px -8px rgba(15, 23, 42, 0.25);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -55%;
        right: -5%;
        width: 380px;
        height: 380px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .ent-glass-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        color: #ffffff;
    }

    .form-control,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.14) !important;
    }

    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        cursor: pointer;
        font-size: 0.82rem;
    }

    .ent-btn:hover {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.28);
    }

    .ent-btn-primary:hover {
        box-shadow: 0 6px 18px rgba(79, 70, 229, 0.4);
        color: #ffffff;
    }

    .ent-btn-reset {
        background-color: rgba(217, 119, 6, 0.14);
        color: #b45309;
        border: 1px solid rgba(217, 119, 6, 0.35);
    }

    .ent-btn-reset:hover {
        background-color: #d97706;
        color: #ffffff;
        border-color: #d97706;
    }

    .icon-shape-sm {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        flex-shrink: 0;
    }

    .icon-shape-md {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        flex-shrink: 0;
    }

    .pulse-badge {
        display: inline-block;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
        animation: pulse 1.6s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(0.95);
        }

        70% {
            transform: scale(1.12);
        }

        100% {
            transform: scale(0.95);
        }
    }

    .ent-badge {
        border-radius: 9999px;
        padding: 4px 10px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        font-size: 0.68rem;
        letter-spacing: 0.03em;
    }

    .ent-table thead th {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .ent-table tbody td {
        border-bottom-color: var(--ent-grid-border) !important;
        font-size: 0.84rem;
    }

    .mini-progress {
        height: 7px;
        border-radius: 999px;
        background-color: rgba(79, 70, 229, 0.12);
        overflow: hidden;
    }

    .mini-progress-bar {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #4f46e5 0%, #0ea5e9 100%);
    }
</style>
@endsection

@section('content')
@php
$totalResponden = collect($rekapPerPaket)->sum('jumlah');
$totalPaket = $pakets->count();
$rataRataGlobal = $totalResponden > 0
? round(collect($rekapPerPaket)->filter(fn($r) => $r['jumlah'] > 0)->avg('avg_skor'), 1)
: 0;
@endphp

<!-- 1. PALING ATAS: RESPONDEN TERBARU & HEADER -->
<div class="card mb-3 ent-header-banner p-1">
    <div class="card-body position-relative p-4" style="z-index: 2;">
        <div class="row align-items-center gy-3">
            <div class="col-lg-8">
                <div class="ent-glass-pill d-inline-flex align-items-center rounded-pill px-3 py-1 mb-2">
                    <span class="pulse-badge me-2"></span>
                    <small class="fw-semibold" style="font-size: 0.78rem; color: #cbd5e1;">
                        Monitoring Responden &amp; Hasil Penilaian Tes
                    </small>
                </div>
                <h2 class="fw-bold mb-1" style="letter-spacing: -0.02em; color: #ffffff;">
                    Menu Responden Tes
                </h2>
                <p class="mb-0" style="color: #cbd5e1; font-size: 0.88rem;">
                    Pantau responden terbaru yang baru masuk serta rekap jumlah, grafik, dan penilaian per nama tes.
                </p>
            </div>
            <div class="col-lg-4 d-flex flex-wrap justify-content-lg-end gap-2">
                <a href="#daftar-nama-tes" class="btn ent-btn ent-btn-primary px-4 py-2">
                    <i class="fas fa-chart-bar me-2"></i> Rekap Per Nama Tes
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Ringkasan Cepat -->
<div class="row g-3 g-md-4 mb-3">
    <div class="col-sm-6 col-xl-4">
        <div class="ent-card h-100 p-3" style="border-left: 4px solid var(--ent-sky) !important;">
            <div class="d-flex align-items-center">
                <div class="icon-shape-md me-3" style="background-color: rgba(2, 132, 199, 0.14); color: #0ea5e9; border: 1px solid rgba(2, 132, 199, 0.3);">
                    <i class="fas fa-users fs-5"></i>
                </div>
                <div>
                    <span class="opacity-75 fw-semibold d-block" style="font-size: 0.72rem; text-transform: uppercase;">Total Responden</span>
                    <h5 class="fw-bold mb-0 font-mono-code" style="font-size: 1.1rem;">{{ $totalResponden }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="ent-card h-100 p-3" style="border-left: 4px solid var(--ent-indigo) !important;">
            <div class="d-flex align-items-center">
                <div class="icon-shape-md me-3" style="background-color: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.3);">
                    <i class="fas fa-file-alt fs-5"></i>
                </div>
                <div>
                    <span class="opacity-75 fw-semibold d-block" style="font-size: 0.72rem; text-transform: uppercase;">Total Nama Tes</span>
                    <h5 class="fw-bold mb-0 font-mono-code" style="font-size: 1.1rem;">{{ $totalPaket }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-xl-4">
        <div class="ent-card h-100 p-3" style="border-left: 4px solid var(--ent-emerald) !important;">
            <div class="d-flex align-items-center">
                <div class="icon-shape-md me-3" style="background-color: rgba(5, 150, 105, 0.14); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.3);">
                    <i class="fas fa-award fs-5"></i>
                </div>
                <div>
                    <span class="opacity-75 fw-semibold d-block" style="font-size: 0.72rem; text-transform: uppercase;">Rata-Rata Penilaian</span>
                    <h5 class="fw-bold mb-0 font-mono-code" style="font-size: 1.1rem;">{{ $rataRataGlobal }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Card Responden Terbaru (Paling Atas) -->
<div class="ent-card mb-4" id="responden-terbaru">
    <div class="ent-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
            <span class="icon-shape-sm" style="background-color: rgba(5, 150, 105, 0.14); color: #10b981;">
                <i class="fas fa-user-clock"></i>
            </span>
            Responden Terbaru
        </h6>
        <span class="ent-badge" style="background-color: rgba(5, 150, 105, 0.14); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.3);">
            Terbaru Masuk
        </span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 ent-table">
                <thead>
                    <tr>
                        <th class="py-3 ps-4" style="width: 55px;">No</th>
                        <th class="py-3">Responden</th>
                        <th class="py-3">Nama Tes</th>
                        <th class="py-3">Waktu Masuk</th>
                        <th class="py-3">Skor / Penilaian</th>
                        <th class="py-3">Status</th>
                        <th class="py-3 pe-4 text-end" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($respondenTerbaru as $idx => $resp)
                    @php
                    $namaResp = $resp->nama_responden ?? $resp->nama ?? $resp->peserta_nama ?? ('Responden #' . $resp->id);
                    $kontakResp = $resp->email_atau_hp ?? $resp->email ?? $resp->no_hp ?? $resp->asal_instansi ?? null;
                    $skorResp = $resp->skor_nilai ?? $resp->total_skor ?? $resp->skor ?? 0;
                    $pgPaket = (int) ($resp->paket_passing_grade ?? 0);
                    $isLulus = $pgPaket > 0 ? ($skorResp >= $pgPaket) : true;
                    $waktuResp = $resp->waktu_selesai ?? $resp->waktu_mulai ?? $resp->created_at ?? '-';
                    @endphp
                    <tr>
                        <td class="ps-4 fw-bold font-mono-code">{{ $idx + 1 }}</td>
                        <td>
                            <div class="fw-bold">{{ $namaResp }}</div>
                            @if (!empty($kontakResp))
                            <div class="opacity-75" style="font-size: 0.75rem;">
                                {{ $kontakResp }}
                            </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $resp->nama_test ?? '-' }}</div>
                            <div class="opacity-75" style="font-size: 0.72rem;">{{ $resp->nama_klasifikasi ?? '-' }}</div>
                        </td>
                        <td class="font-mono-code opacity-75" style="font-size: 0.78rem;">{{ $waktuResp }}</td>
                        <td>
                            <span class="fw-bold font-mono-code text-primary">{{ $skorResp }}</span>
                        </td>
                        <td>
                            @if ($pgPaket > 0)
                            @if ($isLulus)
                            <span class="ent-badge" style="background-color: rgba(5, 150, 105, 0.14); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.3);">
                                Lulus PG
                            </span>
                            @else
                            <span class="ent-badge" style="background-color: rgba(225, 29, 72, 0.14); color: #f43f5e; border: 1px solid rgba(225, 29, 72, 0.3);">
                                Belum Lulus
                            </span>
                            @endif
                            @else
                            <span class="ent-badge" style="background-color: rgba(79, 70, 229, 0.14); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.3);">
                                Selesai
                            </span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <button type="button"
                                class="btn btn-sm ent-btn ent-btn-reset px-2.5 py-1"
                                onclick="resetSesiResponden({{ $resp->id }}, @js($namaResp), @js($resp->nama_test ?? '-'))"
                                title="Reset sesi & riwayat tes responden ini">
                                <i class="fas fa-rotate-left me-1"></i> Reset
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 opacity-75 fst-italic">
                            Belum ada data responden terbaru yang tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 2. BAGIAN BAWAH: DAFTAR NAMA-NAMA TES (JUMLAH, GRAFIK, PENILAIAN) -->
<div class="ent-card mb-3" id="daftar-nama-tes">
    <div class="ent-card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
            <span class="icon-shape-sm" style="background-color: rgba(79, 70, 229, 0.14); color: #6366f1;">
                <i class="fas fa-clipboard-list"></i>
            </span>
            Daftar Nama Tes &amp; Rekap Penilaian
        </h6>
        <input type="text" id="searchNamaTes" class="form-control" style="max-width: 240px;" placeholder="Cari nama tes...">
    </div>

    <div class="card-body p-4">
        <!-- Grafik Visualisasi Jumlah & Rata-Rata Skor Per Nama Tes -->
        <div class="ent-card p-3 mb-4" style="border-radius: 14px;">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                <span class="fw-bold" style="font-size: 0.85rem;">
                    <i class="fas fa-chart-column me-1 text-primary"></i> Grafik Jumlah Responden &amp; Rata-Rata Nilai Per Tes
                </span>
                <span class="opacity-75 font-mono-code" style="font-size: 0.72rem;">Visualisasi Per Nama Tes</span>
            </div>
            <div style="position: relative; height: 240px; width: 100%;">
                <canvas id="chartRespondenTes"></canvas>
            </div>
        </div>

        <!-- Tabel Nama-Nama Tes: Jumlah, Grafik, dan Penilaian -->
        <div class="table-responsive" style="border: 1px solid var(--ent-grid-border); border-radius: 12px;">
            <table class="table table-hover align-middle mb-0 ent-table" id="tabelNamaTes">
                <thead>
                    <tr>
                        <th class="py-3 ps-4" style="width: 55px;">No</th>
                        <th class="py-3">Nama Tes</th>
                        <th class="py-3 text-center" style="width: 140px;">Jumlah</th>
                        <th class="py-3" style="width: 220px;">Grafik</th>
                        <th class="py-3">Penilaian</th>
                        <th class="py-3 pe-4 text-end" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $maxJumlah = max(1, collect($rekapPerPaket)->max('jumlah') ?? 1);
                    @endphp
                    @forelse ($pakets as $i => $paket)
                    @php
                    $rekap = $rekapPerPaket[$paket->id] ?? ['jumlah' => 0, 'avg_skor' => 0, 'max_skor' => 0, 'lulus_count' => 0];
                    $persenGrafik = min(100, round(($rekap['jumlah'] / $maxJumlah) * 100));
                    @endphp
                    <tr>
                        <td class="ps-4 fw-bold font-mono-code">{{ $i + 1 }}</td>
                        <td>
                            <div class="fw-bold">{{ $paket->nama_test }}</div>
                            <div class="opacity-75" style="font-size: 0.75rem;">
                                {{ $paket->klasifikasi->nama_klasifikasi ?? 'Tanpa Klasifikasi' }}
                                &bull; <span class="font-mono-code">{{ $paket->durasi_menit }} mnt</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="ent-badge font-mono-code" style="background-color: rgba(2, 132, 199, 0.14); color: #0ea5e9; border: 1px solid rgba(2, 132, 199, 0.3);">
                                {{ $rekap['jumlah'] }} Responden
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 0.72rem;">
                                <span class="opacity-75">Proporsi Responden</span>
                                <span class="fw-bold font-mono-code">{{ $persenGrafik }}%</span>
                            </div>
                            <div class="mini-progress">
                                <div class="mini-progress-bar" style="width: {{ $persenGrafik }}%;"></div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <span class="ent-badge font-mono-code" style="background-color: rgba(5, 150, 105, 0.14); color: #10b981; border: 1px solid rgba(5, 150, 105, 0.3);">
                                    Rata-rata: {{ $rekap['avg_skor'] }}
                                </span>
                                <span class="ent-badge font-mono-code" style="background-color: rgba(79, 70, 229, 0.12); color: #818cf8; border: 1px solid rgba(79, 70, 229, 0.28);">
                                    PG: {{ $paket->passing_grade ?? 0 }}
                                </span>
                                @if (($paket->passing_grade ?? 0) > 0 && $rekap['jumlah'] > 0)
                                <span class="opacity-75 font-mono-code" style="font-size: 0.74rem;">
                                    ({{ $rekap['lulus_count'] }}/{{ $rekap['jumlah'] }} Lulus)
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="pe-4 text-end">
                            <button type="button"
                                class="btn btn-sm ent-btn ent-btn-reset px-2.5 py-1"
                                onclick="resetSesiPaket({{ $paket->id }}, @js($paket->nama_test))"
                                title="Reset seluruh sesi responden pada tes ini">
                                <i class="fas fa-rotate-left me-1"></i> Reset
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 opacity-75 fst-italic">
                            Belum ada data nama tes yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

    function kirimPermintaanReset(url, judulSukses) {
        fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json().then(body => ({
                status: response.status,
                body
            })))
            .then(res => {
                if (res.status === 200 && res.body.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: judulSukses,
                        text: res.body.message || 'Data sesi & cache tes berhasil direset.',
                        confirmButtonColor: '#4f46e5'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Reset',
                        text: res.body.message || 'Tidak dapat mereset sesi tes.',
                        confirmButtonColor: '#4f46e5'
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Jaringan',
                    text: 'Gagal menghubungi server.',
                    confirmButtonColor: '#4f46e5'
                });
            });
    }

    function resetSesiResponden(sesiId, namaResponden, namaTest) {
        Swal.fire({
            title: 'Reset Sesi Responden?',
            html: `<div style="font-size:0.9rem;">Sesi &amp; cache tes milik <strong>${namaResponden}</strong> pada <strong>${namaTest}</strong> akan direset sehingga peserta dapat mengikuti tes ulang.</div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Reset',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d97706',
            cancelButtonColor: '#64748b',
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed) return;
            kirimPermintaanReset(`{{ url('admin/brain-test/sesi') }}/${sesiId}/reset`, 'Berhasil Direset');
        });
    }

    function resetSesiPaket(paketId, namaTest) {
        Swal.fire({
            title: 'Reset Semua Sesi Tes?',
            html: `<div style="font-size:0.9rem;">Seluruh riwayat sesi &amp; cache peserta pada tes <strong>${namaTest}</strong> akan direset.</div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Reset Semua',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d97706',
            cancelButtonColor: '#64748b',
            reverseButtons: true
        }).then((result) => {
            if (!result.isConfirmed) return;
            kirimPermintaanReset(`{{ url('admin/brain-test/paket') }}/${paketId}/reset-sesi`, 'Tes Berhasil Direset');
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Filter pencarian tabel nama tes
        const searchInput = document.getElementById("searchNamaTes");
        const rows = document.querySelectorAll("#tabelNamaTes tbody tr");
        if (searchInput) {
            searchInput.addEventListener("input", function() {
                const q = this.value.toLowerCase().trim();
                rows.forEach(row => {
                    row.style.display = row.innerText.toLowerCase().includes(q) ? "" : "none";
                });
            });
        }

        // Render Grafik Chart.js per Nama Tes
        const labels = @json($pakets->pluck('nama_test'));
        const jumlahData = @json($pakets->map(fn($p) => $rekapPerPaket[$p->id]['jumlah'] ?? 0)->values());
        const rataData = @json($pakets->map(fn($p) => $rekapPerPaket[$p->id]['avg_skor'] ?? 0)->values());

        const canvas = document.getElementById("chartRespondenTes");
        if (canvas && typeof Chart !== "undefined") {
            new Chart(canvas, {
                type: "bar",
                data: {
                    labels: labels.length ? labels : ["Belum Ada Tes"],
                    datasets: [{
                            label: "Jumlah Responden",
                            data: labels.length ? jumlahData : [0],
                            backgroundColor: "rgba(79, 70, 229, 0.75)",
                            borderColor: "#4f46e5",
                            borderWidth: 1,
                            borderRadius: 6
                        },
                        {
                            label: "Rata-Rata Penilaian",
                            data: labels.length ? rataData : [0],
                            backgroundColor: "rgba(16, 185, 129, 0.75)",
                            borderColor: "#059669",
                            borderWidth: 1,
                            borderRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "top"
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
