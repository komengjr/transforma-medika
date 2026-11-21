@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* =========================================
       MODERN ENTERPRISE UI STYLES (REGISTRASI PESERTA)
       (ADAPTIVE LIGHT & DARK MODE BOOTSTRAP 5)
       ========================================= */
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

    /* Adaptive Enterprise Card */
    .ent-card {
        border: 1px solid var(--ent-grid-border);
        border-radius: 16px;
        background-color: var(--bs-body-bg, var(--ent-solid-bg));
        color: var(--bs-body-color, var(--ent-solid-text));
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .ent-card-header {
        background-color: rgba(79, 70, 229, 0.06) !important;
        border-bottom: 1px solid var(--ent-grid-border) !important;
        padding: 15px 20px;
    }

    .ent-card-footer {
        background-color: rgba(79, 70, 229, 0.05) !important;
        border-top: 1px solid var(--ent-grid-border) !important;
        padding: 14px 20px;
    }

    /* Hero Banner */
    .ent-header-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border: 1px solid rgba(99, 102, 241, 0.35);
        border-radius: 16px;
        box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.22);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 340px;
        height: 340px;
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

    /* Buttons */
    .ent-btn {
        font-weight: 600 !important;
        border-radius: 10px;
        transition: all 0.18s ease;
        letter-spacing: 0.01em;
        cursor: pointer;
        font-size: 0.8rem;
    }

    .ent-btn:hover {
        transform: translateY(-1px);
    }

    .ent-btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        border: none;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
    }

    .ent-btn-primary:hover {
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        color: #ffffff;
    }

    /* Field Labels & Inputs */
    .ent-field-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 6px;
    }

    .form-control {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .ent-input,
    .form-select {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        padding-top: 18px !important;
        padding-bottom: 5px !important;
        padding-left: 11px !important;
        font-size: 0.8rem !important;
        height: 44px !important;
        transition: all 0.2s ease;
    }

    .form-control:focus,
    .ent-input:focus,
    .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .input-group-text {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px 0 0 10px !important;
        background-color: rgba(79, 70, 229, 0.08) !important;
        color: #4f46e5 !important;
    }

    .input-group>.form-control,
    .input-group>.form-select,
    .input-group>.ent-input {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    /* Avatar Upload Box */
    .ent-avatar-upload {
        width: 118px;
        height: 118px;
        border-radius: 50%;
        border: 2px solid var(--ent-grid-border);
        box-shadow: 0 8px 20px -6px rgba(15, 23, 42, 0.18);
        position: relative;
        overflow: hidden;
        background-color: var(--bs-body-bg);
    }

    .ent-avatar-upload img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .ent-avatar-overlay {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.58);
        color: #ffffff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        cursor: pointer;
        transition: opacity 0.2s ease;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .ent-avatar-upload:hover .ent-avatar-overlay {
        opacity: 1;
    }

    /* Protection Box */
    .ent-protection-box {
        border: 1px solid var(--ent-grid-border);
        border-radius: 14px;
        padding: 16px;
        background-color: rgba(79, 70, 229, 0.04);
    }

    /* Modal Adaptive Enterprise */
    .modal-ent-content {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 18px !important;
        background-color: var(--bs-body-bg, var(--ent-solid-bg)) !important;
        color: var(--bs-body-color, var(--ent-solid-text)) !important;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35) !important;
        overflow: hidden;
    }
</style>
@endsection

@section('content')
<!-- HERO BANNER HEADER ATAS -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card ent-header-banner p-1">
            <div class="card-body p-3 p-md-4 text-white position-relative" style="z-index: 2;">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="ent-glass-pill p-2 me-3 d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 60px; height: 60px;">
                            <img src="{{ asset('img/koperasi.png') }}" alt="Logo Koperasi" class="img-fluid" width="40" />
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.45); color: #7dd3fc;">
                                    <i class="fas fa-handshake me-1"></i> Koperasi Simpan Pinjam
                                </span>
                                <span style="color: #94a3b8; font-size: 0.75rem; font-weight: 600;">Member Onboarding</span>
                            </div>
                            <h4 class="fw-bold mb-0" style="letter-spacing: -0.02em; color: white;">
                                Welcome to {{ Env('APP_LABEL') }} <span class="fw-normal" style="color: #cbd5e1;">Management System</span>
                            </h4>
                        </div>
                    </div>

                    <div class="col-lg-5 text-lg-end">
                        <div class="ent-glass-pill d-inline-flex align-items-center px-3 py-2">
                            <h6 class="text-warning fw-bold mb-0" style="font-size: 0.92rem;">
                                <i class="fas fa-user-plus me-1"></i> Registrasi Peserta
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FORM PENDAFTARAN KEPESERTAAN ANGGOTA KOPERASI -->
<div class="ent-card mb-4">
    <div class="ent-card-header">
        <div class="row gy-2 align-items-center justify-content-between">
            <div class="col-auto">
                <h6 class="mb-0 fw-bold d-flex align-items-center gap-2">
                    <i class="fas fa-id-card text-primary"></i> Form Pendaftaran Kepesertaan Anggota Koperasi
                </h6>
                <p class="opacity-75 mb-0 mt-1" style="font-size: 0.8rem;">
                    Selamat Datang di aplikasi Koperasi Simpan Pinjam — lengkapi data calon anggota di bawah ini.
                </p>
            </div>
            <div class="col-auto ms-auto">
                <button class="btn ent-btn ent-btn-primary btn-sm px-3 py-2" type="button">
                    <i class="fas fa-search me-1"></i> Cari Data
                </button>
            </div>
        </div>
    </div>

    <div class="card-body p-3 p-md-4 bg-white">
        <div class="tab-content">
            <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="tab-dom-f1d388f8-6223-48cd-b720-917f0290eedd" id="dom-f1d388f8-6223-48cd-b720-917f0290eedd">
                <form class="row g-3" id="form-peserta-registrasi" method="POST">
                    @csrf

                    <!-- Foto Profil -->
                    <div class="col-md-2 d-flex flex-column align-items-center justify-content-start pt-md-2">
                        <div class="ent-avatar-upload mb-2">
                            <img src="{{ asset('asset/img/team/avatar.png') }}" alt="Avatar Peserta" id="videoPreview" data-dz-thumbnail="data-dz-thumbnail">
                            <input class="d-none" id="profile-image" type="file" accept="image/*" onchange="previewPesertaAvatar(this)">
                            <label class="ent-avatar-overlay mb-0" for="profile-image">
                                <i class="fas fa-camera mb-1 fs-6"></i>
                                <span>Upload</span>
                            </label>
                        </div>
                        <small class="opacity-75 text-center" style="font-size: 0.7rem;">Foto Anggota</small>
                    </div>

                    <!-- Identitas Utama -->
                    <div class="col-md-10">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nama_lengkap" class="form-label ent-field-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                                    <input type="text" name="nama_lengkap" class="form-control form-control-lg" id="nama_lengkap" placeholder="Ex. Jhon Doe">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="jenis_kelamin" class="form-label ent-field-label">Jenis Kelamin</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-transgender"></i></span>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select form-select-lg single-select">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="l">Laki Laki</option>
                                        <option value="p">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="nik" class="form-label ent-field-label">NIK</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                    <input type="text" name="nik" class="form-control form-control-lg" id="nik" placeholder="*12 Digit" style="font-family: 'JetBrains Mono', monospace;">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="nip" class="form-label ent-field-label">NIP</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                                    <input type="text" name="nip" class="form-control form-control-lg" id="nip" placeholder="*12 Digit" style="font-family: 'JetBrains Mono', monospace;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kelahiran & Agama -->
                    <div class="col-md-4">
                        <label for="tgl_lahir" class="form-label ent-field-label">Tanggal Lahir</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                            <input type="date" name="tgl_lahir" class="form-control form-control-lg" id="tgl_lahir">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="tempat_lahir" class="form-label ent-field-label">Tempat Lahir</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                            <input type="text" name="tempat_lahir" class="form-control form-control-lg" id="tempat_lahir" placeholder="Ex. Pontianak">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="agama" class="form-label ent-field-label">Agama</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-pray"></i></span>
                            <select name="agama" id="agama" class="form-select form-select-lg single-select">
                                <option value="">Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Budha">Budha</option>
                            </select>
                        </div>
                    </div>

                    <!-- Kontak & Unit Kerja -->
                    <div class="col-md-4">
                        <label for="no_hp" class="form-label ent-field-label">No Handphone</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone-square-alt"></i></span>
                            <input type="text" name="no_hp" class="form-control form-control-lg" id="no_hp" placeholder="Ex. 08982839182xxx" style="font-family: 'JetBrains Mono', monospace;">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="email" class="form-label ent-field-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                            <input type="email" name="email" class="form-control form-control-lg" id="email" placeholder="Ex. Contoh@gmail.com">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="cabang" class="form-label ent-field-label">Pilih Cabang</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            <select name="cabang" id="cabang" class="form-select form-select-lg single-select">
                                <option value="">Pilih Cabang</option>
                                @foreach ($cabang as $cab)
                                <option value="{{ $cab->kop_master_cabang_code }}">{{ $cab->kop_master_cabang_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="divisi" class="form-label ent-field-label">Pilih Divisi / Departemen</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-sitemap"></i></span>
                            <select name="divisi" id="divisi" class="form-select form-select-lg single-select">
                                <option value="">Pilih</option>
                                @foreach ($divisi as $div)
                                <option value="{{ $div->kop_master_div_bag_code }}">{{ $div->kop_master_divisi_name }} - {{ $div->kop_master_div_bag_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="tgl_masuk" class="form-label ent-field-label">Tanggal Masuk Kerja</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                            <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control form-control-lg">
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="col-12">
                        <label for="inputAddress3" class="form-label ent-field-label">Deskripsi Alamat</label>
                        <textarea class="form-control" name="alamat" id="inputAddress3" placeholder="Enter Address" rows="3"></textarea>
                    </div>

                    <input id="link" type="text" name="link" class="form-control" hidden>

                    <!-- Simpanan Pokok & Wajib -->
                    <div class="col-md-6">
                        <label class="form-label ent-field-label" for="simpanan_pokok">Pilih Simpanan Pokok</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-vault"></i></span>
                            <select name="simpanan_pokok" id="simpanan_pokok" class="form-select form-select-lg single-select">
                                <option value="">Pilih</option>
                                @foreach ($pokok as $pok)
                                <option value="{{ $pok->kop_simpanan_pokok_code }}">{{ $pok->kop_simpanan_pokok_name }}, @currency($pok->kop_simpanan_pokok_nominal)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label ent-field-label" for="simpanan_wajib">Pilih Simpanan Wajib</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="far fa-file-archive"></i></span>
                            <select name="simpanan_wajib" id="simpanan_wajib" class="form-select form-select-lg single-select">
                                <option value="">Pilih</option>
                                @foreach ($wajib as $jib)
                                <option value="{{ $jib->kop_simpanan_wajib_code }}">{{ $jib->kop_simpanan_wajib_name }}, @currency($jib->kop_simpanan_wajib_nominal)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Proteksi Keanggotaan -->
                    <div class="col-12 pt-2">
                        <div class="ent-protection-box d-flex align-items-start gap-3">
                            <img class="flex-shrink-0" src="{{ asset('asset/img/icons/shield.png') }}" alt="Proteksi" width="52" height="52">
                            <div class="flex-grow-1">
                                <h6 class="mb-2 fw-bold">Proteksi Keanggotaan</h6>
                                <div class="form-check mb-1">
                                    <input class="form-check-input" id="protection-option-1" type="checkbox" checked="checked">
                                    <label class="form-check-label mb-0" for="protection-option-1" style="font-size: 0.82rem;">
                                        <strong>Full Refund</strong> if you don't receive your order
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" id="protection-option-2" type="checkbox" checked="checked">
                                    <label class="form-check-label mb-0" for="protection-option-2" style="font-size: 0.82rem;">
                                        <strong>Full or Partial Refund</strong> if the product is not as described in details
                                    </label>
                                </div>
                                <a class="text-primary fw-semibold text-decoration-none" href="#!" style="font-size: 0.78rem;">
                                    Learn More <i class="fas fa-caret-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="ent-card-footer clearfix" id="menu-footer-registrasi">
        <button class="btn ent-btn ent-btn-primary px-4 py-2 float-end" id="button-simpan-data-registrasi">
            <i class="fas fa-save me-1"></i> Simpan Data
        </button>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-penjualan-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-poliklinik-full"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-penjualan" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content modal-ent-content">
            <div class="position-absolute top-0 end-0 mt-3 me-3" style="z-index: 10;">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-penjualan"></div>
        </div>
    </div>
</div>

<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function previewPesertaAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('videoPreview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    if (document.querySelector('#example')) {
        new DataTable('#example', {
            responsive: true
        });
    }
</script>

<script>
    // Bersihkan tanda error saat user mulai mengisi atau mengubah field
    $(document).on("input change", "#form-peserta-registrasi input, #form-peserta-registrasi select, #form-peserta-registrasi textarea", function() {
        if ($(this).val() && $(this).val().toString().trim() !== "") {
            $(this).removeClass("is-invalid");
        }
    });

    $(document).on("click", "#button-simpan-data-registrasi", function(e) {
        e.preventDefault();

        const requiredFields = [{
                selector: "#nama_lengkap",
                label: "Nama Lengkap"
            },
            {
                selector: "#jenis_kelamin",
                label: "Jenis Kelamin"
            },
            {
                selector: "#nik",
                label: "NIK"
            },
            {
                selector: "#nip",
                label: "NIP"
            },
            {
                selector: "#tgl_lahir",
                label: "Tanggal Lahir"
            },
            {
                selector: "#tempat_lahir",
                label: "Tempat Lahir"
            },
            {
                selector: "#agama",
                label: "Agama"
            },
            {
                selector: "#no_hp",
                label: "No Handphone"
            },
            {
                selector: "#email",
                label: "Email"
            },
            {
                selector: "#cabang",
                label: "Pilih Cabang"
            },
            {
                selector: "#divisi",
                label: "Pilih Divisi / Departemen"
            },
            {
                selector: "#tgl_masuk",
                label: "Tanggal Masuk Kerja"
            },
            {
                selector: "#inputAddress3",
                label: "Deskripsi Alamat"
            },
            {
                selector: "#simpanan_pokok",
                label: "Pilih Simpanan Pokok"
            },
            {
                selector: "#simpanan_wajib",
                label: "Pilih Simpanan Wajib"
            }
        ];

        const missingFields = [];
        $("#form-peserta-registrasi .is-invalid").removeClass("is-invalid");

        requiredFields.forEach(function(field) {
            const $el = $(field.selector);
            const val = ($el.val() || "").toString().trim();
            if (val === "") {
                $el.addClass("is-invalid");
                missingFields.push(field.label);
            }
        });

        if (missingFields.length > 0) {
            const firstMissingEl = $(requiredFields.find(f => $(f.selector).hasClass("is-invalid")).selector);
            if (firstMissingEl.length) {
                firstMissingEl.focus();
            }

            Swal.fire({
                icon: "warning",
                title: "Data Wajib Belum Lengkap",
                html: `
                    <div class="text-start" style="font-size: 0.85rem;">
                        <p class="mb-2">Mohon lengkapi field berikut sebelum menyimpan data:</p>
                        <ul class="mb-0 ps-3">
                            ${missingFields.map(item => `<li><strong>${item}</strong></li>`).join("")}
                        </ul>
                    </div>
                `,
                confirmButtonColor: "#4f46e5",
                confirmButtonText: "Mengerti"
            });
            return;
        }

        const originalFooterHtml = $('#menu-footer-registrasi').html();
        const data = $("#form-peserta-registrasi").serialize();

        $('#menu-footer-registrasi').html(
            '<div class="spinner-border text-primary my-2" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
        );

        $.ajax({
            url: "{{ route('menu_koperasi_registrasi_peserta_add') }}",
            type: "POST",
            cache: false,
            data: data,
            dataType: 'html',
        }).done(function(data) {
            if (data == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                    footer: '<a href="#">Why do I have this issue?</a>'
                });
                $('#menu-footer-registrasi').html(originalFooterHtml);
            } else {
                Swal.fire({
                    title: "Berhasil Registrasi Kepesertaan Koperasi",
                    icon: "success",
                    html: `
                        Data kepesertaan anggota koperasi <b>berhasil disimpan</b> ke sistem.
                    `,
                    allowOutsideClick: false,
                    confirmButtonText: "Oke",
                    confirmButtonColor: "#059669"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire("Saved!", "", "success");
                        location.reload();
                    }
                });
            }
        }).fail(function(xhr) {
            $('#menu-footer-registrasi').html(originalFooterHtml);
            let errorText = "Terjadi kesalahan saat menyimpan data.";
            if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                const errorsList = Object.values(xhr.responseJSON.errors).flat();
                errorText = errorsList.join("<br>");
            }
            Swal.fire({
                icon: "error",
                title: "Gagal Menyimpan",
                html: errorText,
                confirmButtonColor: "#e11d48"
            });
        });
    });
</script>
@endsection
