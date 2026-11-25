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

    .super-menu-card {
        border: 1px solid rgba(99, 102, 241, 0.28);
        border-radius: 14px;
        background-color: rgba(79, 70, 229, 0.03);
        margin-bottom: 12px;
        overflow: hidden;
    }

    .super-menu-card:last-child {
        margin-bottom: 0;
    }

    .super-menu-toggle-btn {
        width: 100%;
        border: 0;
        background: rgba(2, 132, 199, 0.11);
        color: var(--bs-body-color, #0f172a);
        padding: 11px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        text-align: left;
        cursor: pointer;
        transition: background-color 0.16s ease;
    }

    .super-menu-toggle-btn:hover {
        background: rgba(2, 132, 199, 0.18);
    }

    .super-menu-card.is-open .super-menu-toggle-btn {
        border-bottom: 1px solid rgba(99, 102, 241, 0.22);
    }

    .super-menu-chevron {
        width: 24px;
        height: 24px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(79, 70, 229, 0.12);
        color: #4f46e5;
        font-size: 0.75rem;
        transition: transform 0.2s ease;
        flex-shrink: 0;
    }

    [data-bs-theme="dark"] .super-menu-chevron,
    .dark .super-menu-chevron {
        color: #a5b4fc;
        background: rgba(129, 140, 248, 0.18);
    }

    .super-menu-card.is-open .super-menu-chevron {
        transform: rotate(180deg);
    }

    .super-menu-collapse-body {
        display: none;
    }

    .super-menu-card.is-open .super-menu-collapse-body {
        display: block;
    }

    .menu-group-box {
        padding: 10px 14px;
        border-bottom: 1px dashed rgba(99, 102, 241, 0.22);
    }

    .menu-group-box:last-child {
        border-bottom: 0;
    }

    .menu-title-line {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        font-size: 0.85rem;
        margin-bottom: 8px;
    }

    .sub-menu-block {
        margin-bottom: 10px;
    }

    .sub-menu-block:last-child {
        margin-bottom: 0;
    }

    .sub-menu-parent-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 7px 11px;
        border-radius: 10px;
        border: 1px solid rgba(99, 102, 241, 0.26);
        background-color: rgba(79, 70, 229, 0.05);
        transition: all 0.15s ease;
    }

    .sub-menu-child-list {
        display: flex;
        flex-direction: column;
        gap: 5px;
        padding-left: 18px;
        margin-top: 5px;
        border-left: 2px solid rgba(99, 102, 241, 0.3);
    }

    .sub-menu-child-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 6px 11px;
        border-radius: 9px;
        border: 1px solid rgba(99, 102, 241, 0.18);
        background-color: var(--bs-body-bg, #ffffff);
        transition: all 0.15s ease;
    }

    .sub-menu-child-card:hover {
        background-color: rgba(79, 70, 229, 0.04);
    }

    .status-toggle-pill {
        cursor: pointer;
        border: 0;
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
        transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease, opacity 0.15s ease;
    }

    .status-toggle-pill:hover:not(:disabled) {
        transform: translateY(-1px);
        filter: brightness(0.96);
        box-shadow: 0 3px 10px rgba(15, 23, 42, 0.14);
    }

    .status-toggle-pill:active:not(:disabled) {
        transform: scale(0.97);
    }

    .status-toggle-pill:disabled {
        opacity: 0.65;
        cursor: wait;
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

@php
    $groupedBySuper = collect($data)->groupBy('menu_super_code');
@endphp

<div class="modal-body p-0">
    <div class="ent-modal-header py-3 ps-4 pe-6">
        <div class="position-relative" style="z-index: 2;">
            <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                <span class="ent-badge" style="background: rgba(56, 189, 248, 0.2); border: 1px solid rgba(56, 189, 248, 0.4); color: #7dd3fc;">
                    <i class="fas fa-sitemap"></i> ACCESS CONFIGURATION
                </span>
                <span class="code-chip" style="background: rgba(255, 255, 255, 0.12); color: #e2e8f0; border-color: rgba(255, 255, 255, 0.22);">
                    {{ $code }}
                </span>
            </div>
            <h5 class="fw-bold mb-1 text-white" id="staticBackdropLabel">Form Setup Super Menu, Menu &amp; Sub Menu</h5>
            <p class="fs--2 mb-0" style="color: #cbd5e1;">
                Klik <strong>Super Menu</strong> untuk membuka/menutup daftar menu &bull; Support by
                <a class="fw-semibold text-info text-decoration-none" href="#!">Transforma</a>
            </p>
        </div>
    </div>

    <div class="p-3 p-md-4" id="menu-akses-tree-container">
        @if ($groupedBySuper->count() > 0)
            @foreach ($groupedBySuper as $superCode => $menusInSuper)
                @php
                    $firstSuper = $menusInSuper->first();
                    $totalItems = 0;
                    $activeItems = 0;

                    foreach ($menusInSuper as $d) {
                        $subMenusCalc = DB::table('z_menu_sub')->where('menu_code', $d->menu_code)->get();
                        foreach ($subMenusCalc as $sm) {
                            $cekP = DB::table('z_menu_user')
                                ->where('access_code', $code)
                                ->where('menu_sub_code', $sm->menu_sub_code)
                                ->first();
                            $totalItems++;
                            if ($cekP) $activeItems++;

                            $mainSubsCalc = DB::table('z_menu_sub_main')->where('menu_sub_code', $sm->menu_sub_code)->get();
                            foreach ($mainSubsCalc as $ms) {
                                $cekC = DB::table('z_menu_user_sub')
                                    ->where('access_code', $code)
                                    ->where('menu_main_sub_code', $ms->menu_main_sub_code)
                                    ->first();
                                $totalItems++;
                                if ($cekC) $activeItems++;
                            }
                        }
                    }
                @endphp

                <div class="super-menu-card" data-super-code="{{ $superCode }}">
                    <button type="button" class="super-menu-toggle-btn" aria-expanded="false">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <span class="ent-badge" style="background: rgba(2, 132, 199, 0.16); color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.32);">
                                <i class="fas fa-layer-group"></i> SUPER MENU
                            </span>
                            <span class="fw-bold small">{{ $firstSuper->menu_super_name }}</span>
                            <span class="code-chip">{{ $superCode }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle super-active-counter" style="font-size: 0.7rem;">
                                {{ $activeItems }} / {{ $totalItems }} Aktif
                            </span>
                            <span class="super-menu-chevron">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </div>
                    </button>

                    <div class="super-menu-collapse-body">
                        @foreach ($menusInSuper as $datas)
                            <div class="menu-group-box">
                                <div class="menu-title-line text-primary">
                                    <i class="fas fa-folder-open"></i>
                                    <span>Menu: {{ $datas->menu_name }}</span>
                                </div>

                                @php
                                    $subMenus = DB::table('z_menu_sub')->where('menu_code', $datas->menu_code)->get();
                                @endphp

                                @if ($subMenus->count() > 0)
                                    @foreach ($subMenus as $menus)
                                        @php
                                            $cekParent = DB::table('z_menu_user')
                                                ->where('access_code', $code)
                                                ->where('menu_sub_code', $menus->menu_sub_code)
                                                ->first();
                                            $parentActive = (bool) $cekParent;
                                            $mainSubMenus = DB::table('z_menu_sub_main')->where('menu_sub_code', $menus->menu_sub_code)->get();
                                        @endphp

                                        <div class="sub-menu-block">
                                            <div class="sub-menu-parent-card">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill" style="font-size: 0.62rem;">Kepala</span>
                                                    <span class="fw-bold small">{{ $menus->menu_sub_name }}</span>
                                                </div>

                                                <button type="button"
                                                    class="status-toggle-pill btn-toggle-menu-akses {{ $parentActive ? 'status-pill-active' : 'status-pill-inactive' }}"
                                                    data-target-role="parent"
                                                    data-code="{{ $menus->menu_sub_code }}"
                                                    data-id="{{ $code }}"
                                                    data-active="{{ $parentActive ? '1' : '0' }}">
                                                    <i class="fas {{ $parentActive ? 'fa-check-circle' : 'fa-times-circle' }} toggle-icon"></i>
                                                    <span class="toggle-label">{{ $parentActive ? 'Aktif' : 'Tidak Aktif' }}</span>
                                                </button>
                                            </div>

                                            @if ($mainSubMenus->count() > 0)
                                                <div class="sub-menu-child-list">
                                                    @foreach ($mainSubMenus as $subs)
                                                        @php
                                                            $cekChild = DB::table('z_menu_user_sub')
                                                                ->where('access_code', $code)
                                                                ->where('menu_main_sub_code', $subs->menu_main_sub_code)
                                                                ->first();
                                                            $childActive = (bool) $cekChild;
                                                        @endphp

                                                        <div class="sub-menu-child-card">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill" style="font-size: 0.62rem;">Sub</span>
                                                                <span class="fw-semibold small">{{ $subs->menu_main_sub_name }}</span>
                                                            </div>

                                                            <button type="button"
                                                                class="status-toggle-pill btn-toggle-menu-akses {{ $childActive ? 'status-pill-active' : 'status-pill-inactive' }}"
                                                                data-target-role="child"
                                                                data-parent-code="{{ $menus->menu_sub_code }}"
                                                                data-code="{{ $subs->menu_main_sub_code }}"
                                                                data-id="{{ $code }}"
                                                                data-active="{{ $childActive ? '1' : '0' }}">
                                                                <i class="fas {{ $childActive ? 'fa-check-circle' : 'fa-times-circle' }} toggle-icon"></i>
                                                                <span class="toggle-label">{{ $childActive ? 'Aktif' : 'Tidak Aktif' }}</span>
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <span class="opacity-50 small fst-italic ps-3">Belum ada sub menu</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center py-4 opacity-75">
                <i class="fas fa-info-circle fa-lg mb-2 text-primary"></i>
                <div class="fw-semibold small">Belum ada Super Menu / Menu yang terhubung ke role ini.</div>
            </div>
        @endif
    </div>
</div>

<script>
    function setTogglePillState($btn, isActive, labelText) {
        const finalLabel = labelText || (isActive ? "Aktif" : "Tidak Aktif");
        $btn.attr("data-active", isActive ? "1" : "0");
        $btn.toggleClass("status-pill-active", isActive);
        $btn.toggleClass("status-pill-inactive", !isActive);
        $btn.find(".toggle-label").text(finalLabel);
        $btn.find(".toggle-icon")
            .removeClass("fa-spinner fa-spin fa-check-circle fa-times-circle")
            .addClass(isActive ? "fa-check-circle" : "fa-times-circle");
    }

    function refreshSuperMenuCounter($card) {
        if (!$card || !$card.length) return;
        const $allPills = $card.find(".btn-toggle-menu-akses");
        const totalCount = $allPills.length;
        const activeCount = $allPills.filter('[data-active="1"]').length;
        $card.find(".super-active-counter").text(activeCount + " / " + totalCount + " Aktif");
    }

    // Toggle buka / tutup per Super Menu seperti navbar
    $(document).off("click", ".super-menu-toggle-btn").on("click", ".super-menu-toggle-btn", function (e) {
        e.preventDefault();
        const $card = $(this).closest(".super-menu-card");
        const isOpen = $card.hasClass("is-open");
        $card.toggleClass("is-open", !isOpen);
        $(this).attr("aria-expanded", !isOpen ? "true" : "false");
    });

    // Toggle Aktif / Tidak Aktif langsung pada tombol
    $(document).off("click", ".btn-toggle-menu-akses").on("click", ".btn-toggle-menu-akses", function (e) {
        e.preventDefault();

        const $btn = $(this);
        if ($btn.prop("disabled")) return;

        const $superCard = $btn.closest(".super-menu-card");
        const code = $btn.data("code");
        const id = $btn.data("id");
        const targetRole = $btn.data("target-role");
        const parentCode = $btn.data("parent-code");
        const currentActive = String($btn.attr("data-active")) === "1";

        $btn.prop("disabled", true);
        $btn.find(".toggle-icon")
            .removeClass("fa-check-circle fa-times-circle")
            .addClass("fa-spinner fa-spin");

        $.ajax({
            url: "{{ route('master_menu_akses_update_sub_menu') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "code": code
            },
            dataType: "json"
        }).done(function (res) {
            const nextActive = (typeof res === "object" && res !== null && typeof res.active !== "undefined")
                ? Boolean(res.active)
                : !currentActive;

            const labelText = (typeof res === "object" && res !== null && res.label)
                ? res.label
                : (nextActive ? "Aktif" : "Tidak Aktif");

            setTogglePillState($btn, nextActive, labelText);

            if (targetRole === "child" && nextActive && parentCode) {
                const $parentBtn = $superCard.find('.btn-toggle-menu-akses[data-target-role="parent"][data-code="' + parentCode + '"]');
                if ($parentBtn.length && String($parentBtn.attr("data-active")) !== "1") {
                    setTogglePillState($parentBtn, true, "Aktif");
                }
            }

            refreshSuperMenuCounter($superCard);
        }).fail(function () {
            setTogglePillState($btn, currentActive, currentActive ? "Aktif" : "Tidak Aktif");

            if (typeof Swal !== "undefined") {
                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: "Tidak dapat memperbarui status akses menu.",
                    timer: 1800,
                    showConfirmButton: false
                });
            }
        }).always(function () {
            $btn.prop("disabled", false);
        });
    });
</script>
