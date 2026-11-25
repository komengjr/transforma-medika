<style>
    .ent-modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 55%, #312e81 100%);
        border-bottom: 1px solid rgba(99, 102, 241, 0.35);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .ent-modal-header::before {
        content: '';
        position: absolute;
        top: -40%;
        right: -5%;
        width: 240px;
        height: 240px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.22) 0%, transparent 70%);
        pointer-events: none;
    }

    .super-menu-icon-badge {
        width: 32px;
        height: 32px;
        border-radius: 9px;
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.16) 0%, rgba(2, 132, 199, 0.16) 100%);
        border: 1px solid rgba(99, 102, 241, 0.28);
        color: #4f46e5;
        font-size: 0.78rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    [data-bs-theme="dark"] .super-menu-icon-badge,
    .dark .super-menu-icon-badge {
        color: #a5b4fc;
    }

    .status-toggle-pill {
        cursor: pointer;
        border-radius: 9999px;
        padding: 4px 12px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
        user-select: none;
        transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
    }

    .status-toggle-pill:hover {
        transform: translateY(-1px);
        filter: brightness(0.96);
        box-shadow: 0 3px 10px rgba(15, 23, 42, 0.14);
    }

    .status-toggle-pill:active {
        transform: scale(0.97);
    }

    .status-pill-active {
        background: rgba(5, 150, 105, 0.14);
        color: #059669;
        border: 1px solid rgba(5, 150, 105, 0.35);
    }

    [data-bs-theme="dark"] .status-pill-active,
    .dark .status-pill-active {
        background: rgba(16, 185, 129, 0.18);
        color: #34d399;
        border-color: rgba(16, 185, 129, 0.38);
    }

    .status-pill-inactive {
        background: rgba(225, 29, 72, 0.12);
        color: #e11d48;
        border: 1px solid rgba(225, 29, 72, 0.32);
    }

    [data-bs-theme="dark"] .status-pill-inactive,
    .dark .status-pill-inactive {
        background: rgba(244, 63, 94, 0.18);
        color: #fb7185;
        border-color: rgba(244, 63, 94, 0.38);
    }
</style>

<div class="modal-body p-0">
    <div class="ent-modal-header py-3 ps-4 pe-6">
        <div class="position-relative" style="z-index: 2;">
            <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                    <i class="fas fa-layer-group"></i> SUPER MENU ACCESS
                </span>
                <span class="code-chip" style="background: rgba(255, 255, 255, 0.12); color: #e2e8f0; border-color: rgba(255, 255, 255, 0.22);">
                    {{ $code }}
                </span>
            </div>
            <h5 class="fw-bold mb-1 text-white" id="staticBackdropLabel">Form Setup Super Menu</h5>
            <p class="fs--2 mb-0" style="color: #cbd5e1;">
                Klik status <strong>Aktif / Belum Aktif</strong> untuk mengatur akses Super Menu &bull; Support by
                <a class="fw-semibold text-info text-decoration-none" href="#!">Transforma</a>
            </p>
        </div>
    </div>

    <div class="p-3 p-md-4">
        <div class="table-responsive">
            <table id="data-menu" class="table table-custom nowrap w-100">
                <thead>
                    <tr>
                        <th style="width: 55px;" class="text-center">No</th>
                        <th>Super Menu</th>
                        <th style="width: 150px;" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                        @php
                            $cek = DB::table('z_menu_user_super')
                                ->where('menu_super_code', $datas->menu_super_code)
                                ->where('access_code', $code)
                                ->first();
                        @endphp
                        <tr>
                            <td class="text-center fw-bold" style="font-family: 'JetBrains Mono', monospace;">{{ $no++ }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="super-menu-icon-badge">
                                        <i class="fas fa-th-large"></i>
                                    </span>
                                    <div>
                                        <div class="fw-bold">{{ $datas->menu_super_name }}</div>
                                        @if (!empty($datas->menu_super_code))
                                            <span class="code-chip mt-1">{{ $datas->menu_super_code }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                @if ($cek)
                                    <button type="button"
                                        class="btn btn-sm status-toggle-pill status-pill-active"
                                        id="button-pilih-akses"
                                        data-code="{{ $datas->menu_super_code }}"
                                        data-id="{{ $code }}"
                                        title="Klik untuk menonaktifkan Super Menu">
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </button>
                                @else
                                    <button type="button"
                                        class="btn btn-sm status-toggle-pill status-pill-inactive"
                                        id="button-pilih-akses"
                                        data-code="{{ $datas->menu_super_code }}"
                                        data-id="{{ $code }}"
                                        title="Klik untuk mengaktifkan Super Menu">
                                        <i class="fas fa-times-circle"></i> Belum Aktif
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    new DataTable('#data-menu', {
        responsive: true,
        pageLength: 10,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ super menu",
            infoEmpty: "Tidak ada data super menu",
            zeroRecords: "Super menu tidak ditemukan",
            emptyTable: "Belum ada data super menu"
        }
    });
</script>
