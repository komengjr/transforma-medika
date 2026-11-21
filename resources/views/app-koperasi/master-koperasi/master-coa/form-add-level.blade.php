<style>
    .coa-form-modal {
        --ent-grid-border: rgba(99, 102, 241, 0.28);
        --ent-indigo: #4f46e5;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .coa-form-modal .coa-modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
    }

    .coa-form-modal .form-control {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        color: var(--bs-body-color) !important;
        background-color: var(--bs-body-bg) !important;
        font-size: 0.82rem !important;
        min-height: 38px;
        transition: all 0.2s ease;
    }

    .coa-form-modal .ent-input,
    .coa-form-modal .form-select {
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

    .coa-form-modal .form-control:focus,
    .coa-form-modal .ent-input:focus,
    .coa-form-modal .form-select:focus {
        border-color: var(--ent-indigo) !important;
        box-shadow: 0 0 0 3.5px rgba(79, 70, 229, 0.15) !important;
        outline: none;
    }

    .coa-form-modal .input-group-text {
        border: 1px solid var(--ent-grid-border) !important;
        border-radius: 10px 0 0 10px !important;
        background-color: rgba(79, 70, 229, 0.08) !important;
        color: #4f46e5 !important;
    }

    .coa-form-modal .input-group > .form-control,
    .coa-form-modal .input-group > .form-select {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    .coa-form-modal .coa-field-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        color: var(--bs-secondary-color, #64748b);
        margin-bottom: 6px;
    }

    .coa-form-modal .btn-coa-save {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        border: none;
        border-radius: 10px;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.55rem 1.2rem;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
        transition: all 0.18s ease;
    }

    .coa-form-modal .btn-coa-save:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
        color: #ffffff;
    }

    .coa-form-modal .coa-table-wrap {
        border: 1px solid var(--ent-grid-border);
        border-radius: 12px;
        padding: 12px;
        background-color: var(--bs-body-bg);
    }

    .coa-form-modal #data-account thead th {
        background-color: rgba(79, 70, 229, 0.12) !important;
        color: var(--bs-body-color) !important;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        border-color: var(--ent-grid-border) !important;
    }

    .coa-form-modal #data-account td {
        border-color: var(--ent-grid-border) !important;
        vertical-align: middle;
        font-size: 0.76rem;
        font-weight: 500;
    }
</style>

<div class="coa-form-modal">
    <div class="modal-body p-0">
        <div class="coa-modal-header rounded-top-4 py-3 px-4 pe-5 d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <h5 class="mb-1 fw-bold text-white" id="staticBackdropLabel">
                    <i class="fas fa-folder-plus me-2 text-info"></i>Form Add Account Koperasi
                </h5>
                <p class="fs--2 mb-0" style="color: #cbd5e1;">
                    Support by <a class="fw-semibold text-info text-decoration-none" href="#!">{{ Env('APP_LABEL') }}</a>
                </p>
            </div>
            <span class="badge rounded-pill px-3 py-2" style="background: rgba(56, 189, 248, 0.18); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc; font-family: 'JetBrains Mono', monospace; font-size: 0.75rem;">
                No. Akun: {{ $nomor }}
            </span>
        </div>

        <div class="p-4 pb-3">
            <div class="row g-3 mb-3">
                <div class="col-12">
                    <form class="row g-3" id="form-input-coa">
                        @csrf
                        <input type="text" name="level" value="{{ $level }}" hidden>
                        <input type="text" name="code" value="{{ $code }}" hidden>
                        <input type="text" name="nomor" value="{{ $nomor }}" hidden>

                        <div class="col-md-6">
                            <label for="nama_account" class="form-label coa-field-label">Account Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                                <input type="text" name="name" class="form-control form-control-lg" id="nama_account" placeholder="Masukkan nama akun...">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="option_account" class="form-label coa-field-label">Optional Account</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                                <select name="option" class="form-select form-select-lg" id="option_account">
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="0">Single</option>
                                    <option value="1">Multi</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 pt-1">
                            <span id="menu-add-data-coa">
                                <button type="button" class="btn btn-coa-save float-end" id="button-simpan-data-level-coa">
                                    <i class="fas fa-save me-1"></i> Simpan Data COA Koperasi
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>

            <div class="coa-table-wrap">
                <div id="data-table-accoaunt-coa">
                    <table class="table table-bordered table-hover fs--2 mb-0" id="data-account">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Master Account</th>
                                <th>Sub Account</th>
                                <th>Nomor Account</th>
                                <th>Nama Account</th>
                                <th class="text-center">Type Account</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach ($data as $datas)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td style="font-family: 'JetBrains Mono', monospace;">{{ $datas->kop_master_coa_code }}</td>
                                <td style="font-family: 'JetBrains Mono', monospace;">{{ $datas->kop_coa_data_code }}</td>
                                <td class="fw-bold text-primary" style="font-family: 'JetBrains Mono', monospace;">{{ $datas->kop_coa_data_no }}</td>
                                <td class="fw-semibold">{{ $datas->kop_coa_data_name }}</td>
                                <td class="text-center">
                                    @if ($datas->kop_coa_data_opt == 0)
                                    <span class="badge bg-warning text-dark rounded-pill px-2.5 py-1">Single</span>
                                    @else
                                    <span class="badge bg-primary rounded-pill px-2.5 py-1">Multi</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer px-4 py-2.5" style="background-color: rgba(79, 70, 229, 0.05); border-top: 1px solid var(--ent-grid-border);">
        <button type="button" class="btn btn-sm btn-outline-secondary rounded-3 fw-semibold" data-bs-dismiss="modal" onclick="location.reload()">
            Tutup
        </button>
    </div>
</div>

<script>
    new DataTable('#data-account', {
        responsive: true,
        ordering: false,
        "lengthMenu": [
            [5, 50, 25],
            [5, 50, 25]
        ]
    });
</script>
