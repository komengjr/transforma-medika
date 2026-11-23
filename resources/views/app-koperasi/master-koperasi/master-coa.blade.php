@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (MASTER COA)
       (ADAPTIVE LIGHT & DARK MODE BOOTSTRAP 5)
       ========================================= */
    :root {
        --coa-indigo: #4f46e5;
        --coa-indigo-dark: #4338ca;
        --coa-indigo-soft: rgba(79, 70, 229, 0.12);
        --coa-emerald: #059669;
        --coa-grid-border: rgba(99, 102, 241, 0.28);
        --coa-solid-bg: #ffffff;
        --coa-solid-text: #0f172a;
        --coa-subtle-surface: #f8fafc;
        --coa-row-hover: #f1f5f9;
    }

    [data-bs-theme="dark"],
    .dark {
        --coa-solid-bg: #0f172a;
        --coa-solid-text: #f8fafc;
        --coa-subtle-surface: #1e293b;
        --coa-row-hover: rgba(99, 102, 241, 0.14);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .coa-font-display {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    /* Compact Hero Header */
    .coa-hero-card {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-radius: 16px;
        border: 1px solid rgba(99, 102, 241, 0.35);
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.22);
        position: relative;
        overflow: hidden;
    }

    .coa-hero-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 340px;
        height: 340px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .coa-icon-glass {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.18);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .coa-stat-pill {
        background: rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 12px;
        padding: 0.42rem 0.9rem;
    }

    /* Main Card & Compact Toolbar */
    .coa-main-card {
        border-radius: 16px;
        border: 1px solid var(--coa-grid-border);
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        background-color: var(--bs-body-bg, var(--coa-solid-bg));
        color: var(--bs-body-color, var(--coa-solid-text));
        overflow: hidden;
    }

    .coa-toolbar {
        background-color: var(--coa-subtle-surface);
        border-bottom: 1px solid var(--coa-grid-border);
        padding: 0.65rem 1rem;
    }

    .coa-search-box {
        background-color: var(--coa-solid-bg);
        border: 1px solid var(--coa-grid-border);
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .coa-search-box:focus-within {
        border-color: var(--coa-indigo);
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15);
    }

    .coa-search-box input {
        font-size: 0.78rem !important;
        font-weight: 600;
        color: var(--coa-solid-text) !important;
        background-color: transparent !important;
        padding-top: 0.28rem;
        padding-bottom: 0.28rem;
    }

    .coa-search-box input:focus {
        box-shadow: none;
        outline: none;
    }

    .btn-coa-sync {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        color: #ffffff !important;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.76rem;
        padding: 0.38rem 0.85rem;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        transition: all 0.18s ease;
    }

    .btn-coa-sync:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
    }

    .btn-coa-outline {
        background-color: var(--coa-solid-bg);
        border: 1px solid var(--coa-grid-border);
        color: var(--bs-body-color, var(--coa-solid-text));
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.76rem;
        padding: 0.36rem 0.75rem;
        transition: all 0.15s ease;
    }

    .btn-coa-outline:hover {
        background-color: var(--coa-indigo-soft);
        border-color: var(--coa-indigo);
        color: var(--coa-indigo);
    }

    /* ========================================================= */
    /* COMPACT CHAPTER / LAMPIRAN BAB TREEVIEW                   */
    /* ========================================================= */
    .coa-tree-root {
        list-style: none;
        padding-left: 0;
        margin: 0;
        font-size: 0.75rem;
    }

    .coa-master-node {
        border: 1px solid var(--coa-grid-border);
        border-radius: 12px;
        margin-bottom: 0.65rem;
        background-color: var(--coa-solid-bg);
        overflow: hidden;
        box-shadow: 0 2px 10px -4px rgba(15, 23, 42, 0.06);
    }

    .coa-master-trigger {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.48rem 0.8rem;
        background-color: var(--coa-subtle-surface);
        text-decoration: none !important;
        color: var(--bs-body-color, var(--coa-solid-text)) !important;
        transition: background 0.15s ease;
    }

    .coa-master-trigger:hover {
        background-color: var(--coa-row-hover);
    }

    .coa-master-trigger[aria-expanded="true"] {
        border-bottom: 1px solid var(--coa-grid-border);
        background-color: rgba(79, 70, 229, 0.08);
    }

    .coa-master-trigger .coa-chevron {
        font-size: 0.66rem;
        transition: transform 0.2s ease;
        color: var(--coa-indigo);
    }

    .coa-master-trigger[aria-expanded="true"] .coa-chevron {
        transform: rotate(90deg);
    }

    .coa-master-title {
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.01em;
    }

    .coa-bab-pill {
        background-color: var(--coa-solid-bg);
        color: var(--bs-body-color, var(--coa-solid-text));
        border: 1px solid var(--coa-grid-border);
        font-size: 0.62rem;
        font-weight: 700;
    }

    /* Compact Sub-levels List & Guide Lines */
    .coa-branch-list {
        list-style: none;
        padding-left: 1.05rem;
        margin: 0;
        position: relative;
        border-left: 1px dashed rgba(99, 102, 241, 0.35);
        margin-left: 0.95rem;
        padding-top: 0.14rem;
        padding-bottom: 0.18rem;
    }

    .coa-branch-item {
        position: relative;
        margin: 1px 0;
    }

    .coa-branch-item::before {
        content: '';
        position: absolute;
        left: -1.05rem;
        top: 0.72rem;
        width: 0.85rem;
        height: 1px;
        background: rgba(99, 102, 241, 0.35);
    }

    .coa-node-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.24rem 0.55rem;
        border-radius: 8px;
        text-decoration: none !important;
        color: var(--bs-body-color, var(--coa-solid-text)) !important;
        background: transparent;
        border: 1px solid transparent;
        line-height: 1.3;
        transition: all 0.12s ease;
    }

    .coa-node-row:hover {
        background-color: var(--coa-row-hover);
        border-color: var(--coa-grid-border);
        color: var(--coa-indigo) !important;
    }

    .coa-node-row.is-leaf:hover {
        background-color: var(--coa-indigo-soft);
        border-color: rgba(79, 70, 229, 0.35);
    }

    .coa-node-row[aria-expanded="true"] .coa-chevron-sm {
        transform: rotate(90deg);
        color: var(--coa-indigo);
    }

    .coa-chevron-sm {
        transition: transform 0.18s ease;
        font-size: 0.6rem;
        width: 10px;
        text-align: center;
        color: #94a3b8;
    }

    .coa-label-text {
        font-size: 0.74rem;
    }

    /* Compact Level Number Badges */
    .coa-code-badge {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        font-size: 0.67rem;
        padding: 0.08rem 0.42rem;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        line-height: 1.25;
    }

    .lvl-0 {
        background: #4f46e5;
        color: #ffffff;
    }

    .lvl-1 {
        background: rgba(2, 132, 199, 0.14);
        color: #0284c7;
        border: 1px solid rgba(2, 132, 199, 0.3);
    }

    .lvl-2 {
        background: rgba(5, 150, 105, 0.14);
        color: #059669;
        border: 1px solid rgba(5, 150, 105, 0.3);
    }

    .lvl-3 {
        background: rgba(124, 58, 237, 0.14);
        color: #7c3aed;
        border: 1px solid rgba(124, 58, 237, 0.3);
    }

    .lvl-4 {
        background: rgba(217, 119, 6, 0.14);
        color: #d97706;
        border: 1px solid rgba(217, 119, 6, 0.3);
    }

    .lvl-5 {
        background: rgba(100, 116, 139, 0.14);
        color: #64748b;
        border: 1px solid rgba(100, 116, 139, 0.3);
    }

    /* Compact Add Button Row */
    .coa-add-trigger {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.16rem 0.55rem;
        margin: 2px 0;
        border-radius: 6px;
        font-size: 0.68rem;
        font-weight: 600;
        color: var(--coa-emerald) !important;
        background-color: rgba(5, 150, 105, 0.08);
        border: 1px dashed rgba(5, 150, 105, 0.45);
        text-decoration: none !important;
        transition: all 0.12s ease;
    }

    .coa-add-trigger:hover {
        background-color: #059669;
        color: #ffffff !important;
        border-style: solid;
        border-color: #059669;
    }

    .coa-edit-pill {
        opacity: 0;
        font-size: 0.64rem;
        padding: 0.08rem 0.45rem;
        border-radius: 5px;
        background-color: var(--coa-indigo-soft);
        color: var(--coa-indigo);
        font-weight: 600;
        transition: opacity 0.12s ease;
    }

    .coa-node-row:hover .coa-edit-pill {
        opacity: 1;
    }

    /* Search Highlight */
    .coa-highlight {
        background-color: rgba(245, 158, 11, 0.25) !important;
        border-color: #f59e0b !important;
    }

    .coa-modal-content {
        border-radius: 18px !important;
        border: 1px solid var(--coa-grid-border) !important;
        background-color: var(--bs-body-bg, var(--coa-solid-bg)) !important;
        color: var(--bs-body-color, var(--coa-solid-text)) !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        overflow: hidden;
    }

    /* =========================================
   FORM CONTROL, ENT-INPUT & FORM-SELECT
   ========================================= */
    .form-control {
        border: 1px solid var(--ent-grid-border, rgba(99, 102, 241, 0.28)) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color, #0f172a) !important;
        /* background-color: var(--bs-body-bg, #ffffff) !important; */
        font-size: 0.82rem !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .ent-input,
    .form-select {
        border: 1px solid var(--ent-grid-border, rgba(99, 102, 241, 0.28)) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color, #0f172a) !important;
        /* background-color: var(--bs-body-bg, #ffffff) !important; */
        padding-top: 18px !important;
        padding-bottom: 5px !important;
        padding-left: 11px !important;
        font-size: 0.8rem !important;
        height: 44px !important;
        transition: all 0.2s ease;
    }
</style>
@endsection

@section('content')
<!-- COMPACT HERO HEADER BANNER -->
<div class="row mb-3">
    <div class="col">
        <div class="coa-hero-card px-3 py-3">
            <div class="row gx-2 gy-2 align-items-center justify-content-between position-relative" style="z-index: 2;">
                <div class="col-lg-auto d-flex align-items-center gap-3">
                    <div class="coa-icon-glass shrink-0">
                        <img src="{{ asset('img/profit.png') }}" alt="Logo" width="24" />
                    </div>
                    <div>
                        <span class="d-block text-uppercase fw-semibold" style="color: #a5b4fc; font-size: 0.62rem; letter-spacing: 0.05em;">
                            {{ Env('APP_LABEL') }} Management System
                        </span>
                        <h5 class="coa-font-display fw-bold mb-0" style="font-size: 1.05rem; color: white;">
                            Master <span style="color: #38bdf8;">Chart of Accounts (COA)</span> Koperasi
                        </h5>
                    </div>
                </div>

                <div class="col-lg-auto d-flex align-items-center gap-2">
                    <div class="coa-stat-pill d-flex align-items-center gap-2">
                        <i class="fas fa-sitemap text-success" style="font-size: 0.85rem;"></i>
                        <div>
                            <span class="d-block text-uppercase" style="color: #94a3b8; font-size: 0.58rem; line-height: 1;">Total Akun</span>
                            <span class="coa-font-display fw-bold text-white" style="font-size: 0.85rem; font-family: 'JetBrains Mono', monospace !important;">{{ number_format($total) }} Accounts</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN COA CARD -->
<div class="coa-main-card mb-4">
    <!-- Compact Toolbar Atas -->
    <div class="coa-toolbar">
        <div class="row g-2 align-items-center justify-content-between">
            <div class="col-md-5 col-lg-4">
                <div class="input-group coa-search-box px-0">
                    <span class="input-group-text bg-transparent border-0 opacity-75 py-1">
                        <i class="fas fa-search" style="font-size: 0.72rem;"></i>
                    </span>
                    <input type="text" id="searchCoaInput" class="form-control border-0 ps-1" placeholder="Cari nomor atau nama akun COA...">
                    <button type="button" id="clearSearchCoa" class="btn btn-sm opacity-75 py-0 d-none" title="Reset pencarian">
                        <i class="fas fa-times" style="font-size: 0.7rem;"></i>
                    </button>
                </div>
            </div>

            <div class="col-md-auto d-flex flex-wrap align-items-center gap-2">
                <span class="d-none d-xl-inline-block opacity-75 me-2" style="font-size: 0.68rem;">
                    <i class="fas fa-info-circle text-primary me-1"></i>Klik kanan / klik <strong>Edit</strong> untuk ubah akun
                </span>

                <button type="button" class="btn btn-coa-outline" id="btnExpandAllCoa">
                    <i class="fas fa-folder-open me-1 text-primary"></i>Buka Semua
                </button>
                <button type="button" class="btn btn-coa-outline" id="btnCollapseAllCoa">
                    <i class="fas fa-folder me-1 opacity-75"></i>Tutup Semua
                </button>
                <button type="button" class="btn btn-coa-sync" data-bs-toggle="modal" data-bs-target="#modal-coa-xl" id="button-sinkronisasi-data-coa">
                    <i class="fas fa-sync-alt me-1"></i>Sinkronisasi COA
                </button>
            </div>
        </div>
    </div>

    <!-- Treeview Container (Semua Terbuka / Expanded by Default) -->
    <div class="card-body p-2 p-md-3">
        <ul class="coa-tree-root" id="treeviewStriped">
            <!-- TINGKAT MASTER -->
            @foreach ($data as $datas)
            <li class="coa-master-node coa-searchable-node">
                <a class="coa-master-trigger" data-bs-toggle="collapse" href="#treeviewStriped-1-{{ $datas->id_kop_master_coa }}" role="button" aria-expanded="true">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-chevron-right coa-chevron"></i>
                        <span class="coa-code-badge lvl-0">{{ $datas->kop_master_coa_no }}</span>
                        <span class="coa-font-display coa-master-title coa-label-text">{{ $datas->kop_master_coa_name }}</span>
                    </div>
                    <span class="badge coa-bab-pill">BAB {{ $datas->kop_master_coa_no }}</span>
                </a>

                <ul class="collapse show coa-branch-list" id="treeviewStriped-1-{{ $datas->id_kop_master_coa }}">
                    @php
                    $sub = DB::table('kop_master_coa_data')
                    ->where('kop_master_coa_code', $datas->kop_master_coa_code)
                    ->where('kop_coa_data_level', 1)
                    ->get();
                    $no = 1;
                    @endphp

                    <!-- TINGKAT 1 START -->
                    @foreach ($sub as $subs)
                    @if ($subs->kop_coa_data_opt == 1)
                    <li class="coa-branch-item coa-searchable-node">
                        <a class="coa-node-row" data-bs-toggle="collapse" href="#treeviewStriped-2-{{ $subs->id_kop_master_coa_data }}" oncontextmenu="myFunction('{{ $subs->kop_coa_data_code }}'); return false;" role="button" aria-expanded="true">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-chevron-right coa-chevron-sm"></i>
                                <span class="coa-code-badge lvl-1">{{ $datas->kop_master_coa_no }}.{{ $no++ }}</span>
                                <span class="fw-semibold coa-label-text">{{ $subs->kop_coa_data_name }}</span>
                            </div>
                            <span class="coa-edit-pill" onclick="event.preventDefault(); event.stopPropagation(); myFunction('{{ $subs->kop_coa_data_code }}');">
                                <i class="fas fa-pen me-1"></i>Edit
                            </span>
                        </a>

                        <ul class="collapse show coa-branch-list" id="treeviewStriped-2-{{ $subs->id_kop_master_coa_data }}">
                            @php
                            $sub1 = DB::table('kop_master_coa_data')
                            ->where('kop_master_coa_code', $subs->kop_coa_data_code)
                            ->where('kop_coa_data_level', 2)
                            ->get();
                            $no1 = 1;
                            @endphp

                            <!-- TINGKAT 2 -->
                            @foreach ($sub1 as $subs1)
                            @if ($subs1->kop_coa_data_opt == 1)
                            <li class="coa-branch-item coa-searchable-node">
                                <a class="coa-node-row" data-bs-toggle="collapse" href="#treeviewStriped-2-{{ $subs1->id_kop_master_coa_data }}" role="button" oncontextmenu="myFunction('{{ $subs1->kop_coa_data_code }}'); return false;" aria-expanded="true">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-chevron-right coa-chevron-sm"></i>
                                        <span class="coa-code-badge lvl-2">{{ $datas->kop_master_coa_no }}.{{ $no-1 }}.{{ $no1++ }}</span>
                                        <span class="fw-semibold coa-label-text">{{ $subs1->kop_coa_data_name }}</span>
                                    </div>
                                    <span class="coa-edit-pill" onclick="event.preventDefault(); event.stopPropagation(); myFunction('{{ $subs1->kop_coa_data_code }}');">
                                        <i class="fas fa-pen me-1"></i>Edit
                                    </span>
                                </a>

                                <ul class="collapse show coa-branch-list" id="treeviewStriped-2-{{ $subs1->id_kop_master_coa_data }}">
                                    @php
                                    $sub2 = DB::table('kop_master_coa_data')
                                    ->where('kop_master_coa_code', $subs1->kop_coa_data_code)
                                    ->where('kop_coa_data_level', 3)
                                    ->get();
                                    $no2 = 1;
                                    @endphp

                                    <!-- TINGKAT 3 -->
                                    @foreach ($sub2 as $subs2)
                                    @if ($subs2->kop_coa_data_opt == 1)
                                    <li class="coa-branch-item coa-searchable-node">
                                        <a class="coa-node-row" data-bs-toggle="collapse" href="#treeviewStriped-3-{{ $subs2->id_kop_master_coa_data }}" role="button" oncontextmenu="myFunction('{{ $subs2->kop_coa_data_code }}'); return false;" aria-expanded="true">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-chevron-right coa-chevron-sm"></i>
                                                <span class="coa-code-badge lvl-3">{{ $datas->kop_master_coa_no }}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2++ }}</span>
                                                <span class="fw-semibold coa-label-text">{{ $subs2->kop_coa_data_name }}</span>
                                            </div>
                                            <span class="coa-edit-pill" onclick="event.preventDefault(); event.stopPropagation(); myFunction('{{ $subs2->kop_coa_data_code }}');">
                                                <i class="fas fa-pen me-1"></i>Edit
                                            </span>
                                        </a>

                                        <ul class="collapse show coa-branch-list" id="treeviewStriped-3-{{ $subs2->id_kop_master_coa_data }}">
                                            @php
                                            $sub3 = DB::table('kop_master_coa_data')
                                            ->where('kop_master_coa_code', $subs2->kop_coa_data_code)
                                            ->where('kop_coa_data_level', 4)
                                            ->get();
                                            $no3 = 1;
                                            @endphp

                                            <!-- TINGKAT 4 -->
                                            @foreach ($sub3 as $subs3)
                                            @if ($subs3->kop_coa_data_opt == 1)
                                            <li class="coa-branch-item coa-searchable-node">
                                                <a class="coa-node-row" data-bs-toggle="collapse" href="#treeviewStriped-3-{{ $subs3->id_kop_master_coa_data }}" role="button" oncontextmenu="myFunction('{{ $subs3->kop_coa_data_code }}'); return false;" aria-expanded="true">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="fas fa-chevron-right coa-chevron-sm"></i>
                                                        <span class="coa-code-badge lvl-4">{{ $datas->kop_master_coa_no }}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3++ }}</span>
                                                        <span class="fw-semibold coa-label-text">{{ $subs3->kop_coa_data_name }}</span>
                                                    </div>
                                                    <span class="coa-edit-pill" onclick="event.preventDefault(); event.stopPropagation(); myFunction('{{ $subs3->kop_coa_data_code }}');">
                                                        <i class="fas fa-pen me-1"></i>Edit
                                                    </span>
                                                </a>

                                                <ul class="collapse show coa-branch-list" id="treeviewStriped-3-{{ $subs3->id_kop_master_coa_data }}">
                                                    @php
                                                    $sub4 = DB::table('kop_master_coa_data')
                                                    ->where('kop_master_coa_code', $subs3->kop_coa_data_code)
                                                    ->where('kop_coa_data_level', 5)
                                                    ->get();
                                                    $no4 = 1;
                                                    @endphp

                                                    <!-- TINGKAT 5 -->
                                                    @foreach ($sub4 as $subs4)
                                                    <li class="coa-branch-item coa-searchable-node">
                                                        <a class="coa-node-row is-leaf" href="#!" oncontextmenu="myFunction('{{ $subs4->kop_coa_data_code }}'); return false;">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <i class="fas fa-file-alt text-primary" style="font-size: 0.65rem;"></i>
                                                                <span class="coa-code-badge lvl-5">{{ $datas->kop_master_coa_no }}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3-1 }}.{{ $no4++ }}</span>
                                                                <span class="coa-label-text">{{ $subs4->kop_coa_data_name }}</span>
                                                            </div>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="coa-edit-pill" onclick="event.preventDefault(); myFunction('{{ $subs4->kop_coa_data_code }}');">
                                                                    <i class="fas fa-pen me-1"></i>Edit
                                                                </span>
                                                                <span class="rounded-circle bg-info" style="width: 5px; height: 5px;" title="Akun Detail"></span>
                                                            </div>
                                                        </a>
                                                    </li>
                                                    @endforeach

                                                    <li class="coa-branch-item">
                                                        <a class="coa-add-trigger" href="#!" id="button-add-level" data-bs-toggle="modal" data-bs-target="#modal-coa" data-nomor="{{ $datas->kop_master_coa_no }}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3-1 }}.{{ $no4 }}" data-level="5" data-code="{{ $subs3->kop_coa_data_code }}">
                                                            <i class="fas fa-plus-circle"></i>
                                                            <span>add Data {{ $datas->kop_master_coa_no }}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3-1 }}.{{ $no4 }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            @else
                                            <li class="coa-branch-item coa-searchable-node">
                                                <a class="coa-node-row is-leaf" href="#!" oncontextmenu="myFunction('{{ $subs3->kop_coa_data_code }}'); return false;">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="fas fa-file-alt text-primary" style="font-size: 0.65rem;"></i>
                                                        <span class="coa-code-badge lvl-4">{{ $datas->kop_master_coa_no }}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3++ }}</span>
                                                        <span class="coa-label-text">{{ $subs3->kop_coa_data_name }}</span>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="coa-edit-pill" onclick="event.preventDefault(); myFunction('{{ $subs3->kop_coa_data_code }}');">
                                                            <i class="fas fa-pen me-1"></i>Edit
                                                        </span>
                                                        <span class="rounded-circle bg-info" style="width: 5px; height: 5px;" title="Akun Detail"></span>
                                                    </div>
                                                </a>
                                            </li>
                                            @endif
                                            @endforeach

                                            <li class="coa-branch-item">
                                                <a class="coa-add-trigger" href="#!" id="button-add-level" data-bs-toggle="modal" data-bs-target="#modal-coa" data-nomor="{{ $datas->kop_master_coa_no }}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3 }}" data-level="4" data-code="{{ $subs2->kop_coa_data_code }}">
                                                    <i class="fas fa-plus-circle"></i>
                                                    <span>add Data {{ $datas->kop_master_coa_no }}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2-1 }}.{{ $no3 }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    @else
                                    <li class="coa-branch-item coa-searchable-node">
                                        <a class="coa-node-row is-leaf" href="#!" oncontextmenu="myFunction('{{ $subs2->kop_coa_data_code }}'); return false;">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fas fa-file-alt text-primary" style="font-size: 0.65rem;"></i>
                                                <span class="coa-code-badge lvl-3">{{ $datas->kop_master_coa_no }}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2++ }}</span>
                                                <span class="coa-label-text">{{ $subs2->kop_coa_data_name }}</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="coa-edit-pill" onclick="event.preventDefault(); myFunction('{{ $subs2->kop_coa_data_code }}');">
                                                    <i class="fas fa-pen me-1"></i>Edit
                                                </span>
                                                <span class="rounded-circle bg-info" style="width: 5px; height: 5px;" title="Akun Detail"></span>
                                            </div>
                                        </a>
                                    </li>
                                    @endif
                                    @endforeach

                                    <li class="coa-branch-item">
                                        <a class="coa-add-trigger" href="#!" id="button-add-level" data-bs-toggle="modal" data-bs-target="#modal-coa" data-nomor="{{ $datas->kop_master_coa_no }}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2 }}" data-level="3" data-code="{{ $subs1->kop_coa_data_code }}">
                                            <i class="fas fa-plus-circle"></i>
                                            <span>add Data {{ $datas->kop_master_coa_no }}.{{ $no-1 }}.{{ $no1-1 }}.{{ $no2 }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @else
                            <li class="coa-branch-item coa-searchable-node">
                                <a class="coa-node-row is-leaf" href="#!" oncontextmenu="myFunction('{{ $subs1->kop_coa_data_code }}'); return false;">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-file-alt text-primary" style="font-size: 0.65rem;"></i>
                                        <span class="coa-code-badge lvl-2">{{ $datas->kop_master_coa_no }}.{{ $no-1 }}.{{ $no1++ }}</span>
                                        <span class="coa-label-text">{{ $subs1->kop_coa_data_name }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="coa-edit-pill" onclick="event.preventDefault(); myFunction('{{ $subs1->kop_coa_data_code }}');">
                                            <i class="fas fa-pen me-1"></i>Edit
                                        </span>
                                        <span class="rounded-circle bg-info" style="width: 5px; height: 5px;" title="Akun Detail"></span>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @endforeach

                            <li class="coa-branch-item">
                                <a class="coa-add-trigger" href="#!" id="button-add-level" data-bs-toggle="modal" data-bs-target="#modal-coa" data-nomor="{{ $datas->kop_master_coa_no }}.{{ $no-1 }}.{{ $no1 }}" data-level="2" data-code="{{ $subs->kop_coa_data_code }}">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>add Data {{ $datas->kop_master_coa_no }}.{{ $no-1 }}.{{ $no1 }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @elseif($subs->kop_coa_data_opt == 0)
                    <li class="coa-branch-item coa-searchable-node">
                        <a class="coa-node-row is-leaf" href="#!" oncontextmenu="myFunction('{{ $subs->kop_coa_data_code }}'); return false;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-file-alt text-primary" style="font-size: 0.65rem;"></i>
                                <span class="coa-code-badge lvl-1">{{ $datas->kop_master_coa_no }}.{{ $no++ }}</span>
                                <span class="coa-label-text">{{ $subs->kop_coa_data_name }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="coa-edit-pill" onclick="event.preventDefault(); myFunction('{{ $subs->kop_coa_data_code }}');">
                                    <i class="fas fa-pen me-1"></i>Edit
                                </span>
                                <span class="rounded-circle bg-info" style="width: 5px; height: 5px;" title="Akun Detail"></span>
                            </div>
                        </a>
                    </li>
                    @endif
                    @endforeach
                    <!-- TINGKAT 1 END -->

                    <li class="coa-branch-item">
                        <a class="coa-add-trigger" href="#!" id="button-add-level" data-bs-toggle="modal" data-bs-target="#modal-coa" data-nomor="{{ $datas->kop_master_coa_no }}.{{ $no }}" data-level="1" data-code="{{ $datas->kop_master_coa_code }}">
                            <i class="fas fa-plus-circle"></i>
                            <span>add Data {{ $datas->kop_master_coa_no }}.{{ $no }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-coa" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content coa-modal-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <!-- <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" onclick="location.reload()"
                    data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div id="menu-coa"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-coa-xl" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content coa-modal-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-coa-xl"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.addEventListener('load', () => {
        const shouldCenter = localStorage.getItem('reloadToCenter');
        if (shouldCenter === 'true') {
            const centerPosition = (document.body.scrollHeight - window.innerHeight) / 2;
            window.scrollTo({
                top: centerPosition,
                behavior: 'smooth'
            });
            localStorage.removeItem('reloadToCenter');
        }
    });

    // Fitur Expand All, Collapse All & Live Search COA
    document.addEventListener('DOMContentLoaded', function() {
        const btnExpandAll = document.getElementById('btnExpandAllCoa');
        const btnCollapseAll = document.getElementById('btnCollapseAllCoa');
        const searchInput = document.getElementById('searchCoaInput');
        const clearBtn = document.getElementById('clearSearchCoa');

        if (btnExpandAll) {
            btnExpandAll.addEventListener('click', () => {
                document.querySelectorAll('#treeviewStriped .collapse').forEach(el => {
                    el.classList.add('show');
                });
                document.querySelectorAll('#treeviewStriped [data-bs-toggle="collapse"]').forEach(btn => {
                    btn.setAttribute('aria-expanded', 'true');
                });
            });
        }

        if (btnCollapseAll) {
            btnCollapseAll.addEventListener('click', () => {
                document.querySelectorAll('#treeviewStriped .collapse').forEach(el => {
                    el.classList.remove('show');
                });
                document.querySelectorAll('#treeviewStriped [data-bs-toggle="collapse"]').forEach(btn => {
                    btn.setAttribute('aria-expanded', 'false');
                });
            });
        }

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const keyword = this.value.trim().toLowerCase();
                document.querySelectorAll('.coa-highlight').forEach(el => el.classList.remove('coa-highlight'));

                if (keyword.length > 0) {
                    clearBtn.classList.remove('d-none');
                    document.querySelectorAll('.coa-searchable-node').forEach(node => {
                        const labelEl = node.querySelector(':scope > a .coa-label-text');
                        const badgeEl = node.querySelector(':scope > a .coa-code-badge');
                        const text = ((labelEl ? labelEl.innerText : '') + ' ' + (badgeEl ? badgeEl.innerText : '')).toLowerCase();

                        if (text.includes(keyword)) {
                            const row = node.querySelector(':scope > a');
                            if (row) row.classList.add('coa-highlight');

                            // Buka parent collapse jika tertutup
                            let parentCollapse = node.closest('.collapse');
                            while (parentCollapse) {
                                parentCollapse.classList.add('show');
                                const trigger = document.querySelector(`[href="#${parentCollapse.id}"]`);
                                if (trigger) trigger.setAttribute('aria-expanded', 'true');
                                parentCollapse = parentCollapse.parentElement.closest('.collapse');
                            }
                        }
                    });
                } else {
                    clearBtn.classList.add('d-none');
                }
            });

            clearBtn.addEventListener('click', () => {
                searchInput.value = '';
                clearBtn.classList.add('d-none');
                document.querySelectorAll('.coa-highlight').forEach(el => el.classList.remove('coa-highlight'));
            });
        }
    });
</script>

<script>

</script>

<script>
    if (document.getElementById('example')) {
        new DataTable('#example', {
            responsive: true
        });
    }
</script>

<script>
    $(document).on("click", "#button-add-level", function(e) {
        e.preventDefault();
        let code = $(this).data("code");
        let level = $(this).data("level");
        let nomor = $(this).data("nomor");
        $.ajax({
            url: "{{ route('master_koperasi_data_coa_add_level') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "nomor": nomor,
                "code": code,
                "level": level
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-coa').html(data);
        }).fail(function() {
            $('#menu-coa').html('<div class="p-4 text-center text-danger">Gagal memuat form tambah COA.</div>');
        });
    });



    $(document).on("click", "#button-simpan-data-level-coa", function(e) {
        e.preventDefault();
        var data = $("#form-input-coa").serialize();
        $('#menu-add-data-coa').html(
            '<div class="spinner-border text-primary my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );
        $.ajax({
            url: "{{ route('master_koperasi_data_coa_save_level') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'html',
        }).done(function(data) {
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Gagal Menyimpan",
                    text: "Pastikan seluruh field telah diisi dengan benar."
                });
                $('#menu-add-data-coa').html('<button class="btn btn-success float-end" id="button-simpan-data-level-coa" data-code="">Simpan Data</button>');
            } else {
                document.getElementById('nama_account').value = "";
                document.getElementById('option_account').value = "";
                $('#data-table-accoaunt-coa').html(data);
                $('#menu-add-data-coa').html('<button class="btn btn-success float-end" id="button-simpan-data-level-coa" data-code="">Simpan Data</button>');
            }
        }).fail(function() {
            Swal.fire({
                icon: "error",
                title: "Terjadi Kesalahan",
                text: "Gagal terhubung ke server."
            });
            $('#menu-add-data-coa').html('<button class="btn btn-success float-end" id="button-simpan-data-level-coa" data-code="">Simpan Data</button>');
        });
    });

    function myFunction(data) {
        $('#modal-coa').modal('show');
        $('#menu-coa').html(
            '<div class="spinner-border text-primary my-4" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );

        $.ajax({
            url: "{{ route('master_koperasi_data_coa_update_level') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": data
            },
            dataType: 'html',
        }).done(function(resHtml) {
            $('#menu-coa').html(resHtml);
        }).fail(function() {
            $('#menu-coa').html('<div class="p-4 text-center text-danger fw-semibold">Gagal memuat data akun.</div>');
            Swal.fire({
                icon: "error",
                title: "Gagal Memuat",
                text: "Tidak dapat mengambil detail akun COA.",
                confirmButtonColor: "#4f46e5"
            });
        });
    }

    $(document).off("click", "#button-simpan-data-update-level-coa").on("click", "#button-simpan-data-update-level-coa", function(e) {
        e.preventDefault();

        const $form = $("#form-update-coa");
        const $btn = $(this);
        const originalHtml = $btn.html();

        $btn.prop("disabled", true).html('<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...');

        Swal.fire({
            title: "Menyimpan Perubahan...",
            text: "Mohon tunggu sebentar.",
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('master_accounting_coa_update_save_level') }}",
            type: "POST",
            cache: false,
            data: $form.serialize(),
            dataType: "json"
        }).done(function(res) {
            $btn.prop("disabled", false).html(originalHtml);

            if (res && res.status === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: res.message || "Data akun COA berhasil diperbarui.",
                    confirmButtonColor: "#059669",
                    confirmButtonText: "OK"
                }).then(() => {
                    $('#modal-coa').modal('hide');
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: "warning",
                    title: "Gagal Memperbarui",
                    text: (res && res.message) ? res.message : "Data gagal disimpan.",
                    confirmButtonColor: "#e11d48"
                });
            }
        }).fail(function(xhr) {
            $btn.prop("disabled", false).html(originalHtml);

            let errMsg = "Terjadi kesalahan saat menyimpan perubahan data COA.";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errMsg = xhr.responseJSON.message;
            }

            Swal.fire({
                icon: "error",
                title: "Terjadi Kesalahan",
                text: errMsg,
                confirmButtonColor: "#e11d48"
            });
        });
    });
</script>

<script>
    $(document).on("click", "#button-sinkronisasi-data-coa", function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('master_koperasi_data_coa_sinskronisasi') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "nomor": 123,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-coa-xl').html(data);
        }).fail(function() {
            $('#menu-coa-xl').html('<div class="p-4 text-center text-danger">Gagal memuat data sinkronisasi.</div>');
        });
    });

    $(document).on("click", "#button-proses-sinkrosnisasi-data-coa", function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('master_koperasi_data_coa_sinskronisasi_proses') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "nomor": 1,
            },
            dataType: 'html',
        }).done(function(data) {
            location.reload();
        }).fail(function() {
            $('#menu-coa-xl').html('<div class="p-4 text-center text-danger">Gagal memproses sinkronisasi.</div>');
        });
    });
</script>
@endsection
