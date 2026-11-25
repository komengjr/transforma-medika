<style>
    .gl-summary-strip {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
        gap: 12px;
        margin-bottom: 18px;
    }

    .gl-stat-box {
        border: 1px solid rgba(99, 102, 241, 0.25);
        border-radius: 12px;
        padding: 12px 15px;
        background-color: rgba(79, 70, 229, 0.03);
    }

    .gl-stat-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        opacity: 0.72;
        display: block;
        margin-bottom: 4px;
    }

    .gl-stat-value {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.98rem;
        font-weight: 700;
    }

    .gl-journal-table {
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.82rem;
    }

    .gl-journal-table thead th {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        color: #ffffff;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 11px 12px;
        border-color: rgba(99, 102, 241, 0.35);
        white-space: nowrap;
    }

    .gl-group-header-row {
        cursor: pointer;
        user-select: none;
    }

    .gl-group-header-row td {
        background-color: rgba(79, 70, 229, 0.07) !important;
        border-top: 2px solid rgba(79, 70, 229, 0.32) !important;
        border-bottom: 1px solid rgba(79, 70, 229, 0.2) !important;
        padding: 10px 12px !important;
        transition: background-color 0.15s ease;
    }

    .gl-group-header-row:hover td {
        background-color: rgba(79, 70, 229, 0.13) !important;
    }

    .gl-group-header-row.is-open td {
        background-color: rgba(79, 70, 229, 0.14) !important;
    }

    .gl-collapse-icon {
        width: 24px;
        height: 24px;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(79, 70, 229, 0.14);
        color: #4f46e5;
        font-size: 0.72rem;
        transition: transform 0.2s ease;
        flex-shrink: 0;
    }

    [data-bs-theme="dark"] .gl-collapse-icon,
    .dark .gl-collapse-icon {
        color: #a5b4fc;
        background: rgba(129, 140, 248, 0.2);
    }

    .gl-group-header-row.is-open .gl-collapse-icon {
        transform: rotate(90deg);
    }

    /* Default tertutup (collapsed) */
    .gl-detail-child-row {
        display: none;
    }

    .gl-journal-table tr.is-expanded {
        display: table-row;
    }

    .gl-entry-row td {
        padding: 8px 12px !important;
        vertical-align: middle;
        border-color: rgba(148, 163, 184, 0.22) !important;
    }

    .gl-entry-row:hover td {
        background-color: rgba(79, 70, 229, 0.035);
    }

    .gl-subtotal-row td {
        background-color: rgba(148, 163, 184, 0.08) !important;
        border-top: 1px dashed rgba(99, 102, 241, 0.35) !important;
        border-bottom: 1px solid rgba(99, 102, 241, 0.25) !important;
        padding: 7px 12px !important;
        font-size: 0.78rem;
    }

    .gl-grandtotal-row td {
        background: rgba(15, 23, 42, 0.06) !important;
        border-top: 2px solid #4f46e5 !important;
        border-bottom: 2px solid #4f46e5 !important;
        padding: 11px 12px !important;
        font-size: 0.85rem;
    }

    .gl-mono {
        font-family: 'JetBrains Mono', monospace;
    }

    .gl-coa-pill {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 6px;
        background: rgba(79, 70, 229, 0.11);
        color: #4f46e5;
        border: 1px solid rgba(79, 70, 229, 0.25);
        display: inline-block;
    }

    [data-bs-theme="dark"] .gl-coa-pill,
    .dark .gl-coa-pill {
        color: #a5b4fc;
        background: rgba(129, 140, 248, 0.16);
    }

    .gl-action-btn {
        border-radius: 8px;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 5px 10px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .gl-post-btn {
        border-radius: 8px;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 5px 10px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .gl-account-cell {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 10px;
    }

    .gl-account-main {
        display: inline-flex;
        align-items: flex-start;
        gap: 7px;
        min-width: 0;
    }

    .gl-credit-indent {
        padding-left: 1.5rem !important;
    }

    .gl-credit-arrow {
        color: #0c6aee;
        font-weight: 700;
        line-height: 1.45;
        flex-shrink: 0;
    }
</style>

@php
$collection = collect($data);

$groupedJournals = $collection->groupBy(function ($item) {
    return $item->id_jurnal ?? ($item->jurnal_id ?? ($item->jurnal_no_bukti ?? uniqid()));
});

$postedCount = $groupedJournals->filter(function ($entries) {
    $first = $entries->first();
    return !empty($first->acc_jurnal_no) || (($first->status_posting ?? '') === 'posted');
})->count();

$grandTotalDebit = $collection->sum(fn($r) => (int) ($r->jurnal_debit ?? 0));
$grandTotalKredit = $collection->sum(fn($r) => (int) ($r->jurnal_kredit ?? 0));
$isAllBalanced = ($grandTotalDebit === $grandTotalKredit);
@endphp

<div class="card-header bg-transparent border-bottom p-3 p-md-4" style="border-color: var(--ent-grid-border) !important;">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="ent-badge" style="background: rgba(79, 70, 229, 0.12); color: #4f46e5;">
                    <i class="fas fa-book-open"></i> GENERAL JOURNAL
                </span>
                <span class="ent-badge" style="background: rgba(2, 132, 199, 0.12); color: #0284c7;">
                    {{ strtoupper($source_type ?? 'KOPERASI') }}
                </span>
            </div>
            <h6 class="mb-0 fw-bold">Buku Jurnal Umum &amp; Pelaporan Pusat Keuangan</h6>
            <small class="opacity-75">
                Periode: <strong>{{ !empty($tanggal_awal) ? $tanggal_awal : 'Semua Tanggal' }}</strong>
                s/d <strong>{{ !empty($tanggal_akhir) ? $tanggal_akhir : 'Semua Tanggal' }}</strong>
                &bull; Klik baris transaksi untuk membuka/menutup detail COA
            </small>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <button type="button" class="btn btn-outline-primary gl-action-btn" id="btn-expand-all-jurnal">
                <i class="fas fa-folder-open"></i> Buka Semua
            </button>
            <button type="button" class="btn btn-outline-secondary gl-action-btn" id="btn-collapse-all-jurnal">
                <i class="fas fa-folder"></i> Tutup Semua
            </button>
            <div class="input-group input-group-sm" style="width: 225px;">
                <span class="input-group-text bg-transparent"><i class="fas fa-search opacity-75"></i></span>
                <input type="text" id="filter-jurnal-quick" class="form-control" placeholder="Cari No. Bukti / COA...">
            </div>
        </div>
    </div>
</div>

<div class="card-body p-3 p-md-4">
    <!-- RINGKASAN SALDO & STATUS POSTING -->
    <div class="gl-summary-strip">
        <div class="gl-stat-box">
            <span class="gl-stat-label">Jumlah Bukti Jurnal</span>
            <span class="gl-stat-value text-primary">{{ number_format($groupedJournals->count(), 0, ',', '.') }} Transaksi</span>
        </div>
        <div class="gl-stat-box">
            <span class="gl-stat-label">Status Posting Pusat</span>
            <span class="gl-stat-value text-info">{{ $postedCount }} / {{ $groupedJournals->count() }} Posted</span>
        </div>
        <div class="gl-stat-box">
            <span class="gl-stat-label">Total Mutasi Debit</span>
            <span class="gl-stat-value text-success">Rp {{ number_format($grandTotalDebit, 0, ',', '.') }}</span>
        </div>
        <div class="gl-stat-box">
            <span class="gl-stat-label">Total Mutasi Kredit</span>
            <span class="gl-stat-value text-danger">Rp {{ number_format($grandTotalKredit, 0, ',', '.') }}</span>
        </div>
        <div class="gl-stat-box">
            <span class="gl-stat-label">Status Keseimbangan</span>
            @if ($collection->count() === 0)
            <span class="gl-stat-value opacity-50">-</span>
            @elseif ($isAllBalanced)
            <span class="gl-stat-value text-success"><i class="fas fa-check-circle me-1"></i>BALANCED</span>
            @else
            <span class="gl-stat-value text-danger">
                <i class="fas fa-exclamation-triangle me-1"></i>Selisih Rp {{ number_format(abs($grandTotalDebit - $grandTotalKredit), 0, ',', '.') }}
            </span>
            @endif
        </div>
    </div>

    @if ($groupedJournals->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered gl-journal-table w-100 mb-0" id="table-jurnal-umum">
            <thead>
                <tr>
                    <th style="width: 135px;">Tanggal</th>
                    <th style="width: 185px;">No. Bukti / Ref</th>
                    <th style="width: 165px;">Status Posting</th>
                    <th>Nama Akun &amp; Uraian Transaksi</th>
                    <th class="text-end" style="width: 155px;">Debit (Rp)</th>
                    <th class="text-end" style="width: 155px;">Kredit (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @php $trxNo = 1; @endphp
                @foreach ($groupedJournals as $jurnalKey => $entries)
                @php
                $head = $entries->first();
                $sourceJurnalId = $head->id_jurnal ?? ($head->jurnal_id ?? $jurnalKey);
                $noBukti = $head->jurnal_no_bukti ?? ($head->jurnal_ref_code ?? ('JV-' . $jurnalKey));
                $refTable = $head->jurnal_ref_table ?? '-';
                $refCode = $head->jurnal_ref_code ?? '-';
                $keterangan = $head->jurnal_keterangan ?? '';
                $userInput = $head->jurnal_user ?? '-';
                $cabang = $head->jurnal_cabang ?? '-';

                $tglRaw = !empty($head->jurnal_tgl)
                    ? $head->jurnal_tgl
                    : (!empty($head->jurnal_created) ? $head->jurnal_created : null);
                $tglFormatted = $tglRaw ? \Carbon\Carbon::parse($tglRaw)->format('d/m/Y') : '-';

                $sortedEntries = $entries->sortBy(function ($item) {
                    return ((int) ($item->jurnal_debit ?? 0) > 0) ? 0 : 1;
                });

                $subDebit = $entries->sum(fn($r) => (int) ($r->jurnal_debit ?? 0));
                $subKredit = $entries->sum(fn($r) => (int) ($r->jurnal_kredit ?? 0));
                $trxBalanced = ($subDebit === $subKredit);

                $isPosted = !empty($head->acc_jurnal_no) || (($head->status_posting ?? '') === 'posted');
                $accJurnalNo = $head->acc_jurnal_no ?? null;
                @endphp

                <!-- BARIS UTAMA TRANSAKSI JURNAL -->
                <tr class="gl-group-header-row" data-journal-group="{{ $jurnalKey }}" title="Klik untuk membuka/menutup detail COA">
                    <td class="fw-bold gl-mono">
                        <div class="d-flex align-items-center gap-2">
                            <span class="gl-collapse-icon">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                            <div>
                                <span class="badge bg-dark text-white me-1">#{{ $trxNo++ }}</span>
                                <span>{{ $tglFormatted }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold text-primary gl-mono">{{ $noBukti }}</div>
                        <small class="opacity-75 d-block">{{ $refTable }} &bull; {{ $refCode }}</small>
                    </td>
                    <td>
                        <div class="d-flex flex-column gap-1 gl-posting-cell" data-journal-group="{{ $jurnalKey }}">
                            @if ($isPosted)
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill gl-posting-badge">
                                    <i class="fas fa-check-circle me-1"></i>Posted
                                </span>
                                @if ($accJurnalNo)
                                    <small class="gl-mono fw-semibold text-success gl-acc-no-label">{{ $accJurnalNo }}</small>
                                @endif
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill gl-posting-badge">
                                    <i class="fas fa-clock me-1"></i>Belum Diposting
                                </span>
                                <button type="button"
                                    class="btn btn-primary gl-post-btn btn-lapor-keuangan"
                                    data-source-jurnal-id="{{ $sourceJurnalId }}"
                                    data-source-project="{{ $source_type ?? 'koperasi' }}"
                                    data-no-bukti="{{ $noBukti }}"
                                    data-balanced="{{ $trxBalanced ? '1' : '0' }}">
                                    <i class="fas fa-paper-plane"></i> Laporkan ke Pusat
                                </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold">
                            {{ $keterangan !== '' ? $keterangan : ('Transaksi ' . ucwords(str_replace('_', ' ', $refTable))) }}
                        </div>
                        <small class="opacity-75">
                            <i class="fas fa-building me-1"></i>Cabang: <strong>{{ $cabang }}</strong>
                            &nbsp;&bull;&nbsp;
                            <i class="fas fa-user me-1"></i>User: <strong>{{ $userInput }}</strong>
                            &nbsp;&bull;&nbsp;
                            <span>{{ $entries->count() }} Akun</span>
                            @if (!$trxBalanced)
                                &nbsp;&bull;&nbsp;<span class="text-danger fw-bold">Selisih</span>
                            @endif
                        </small>
                    </td>
                    <td class="text-end gl-mono fw-bold text-success">
                        {{ number_format($subDebit, 0, ',', '.') }}
                    </td>
                    <td class="text-end gl-mono fw-bold text-danger">
                        {{ number_format($subKredit, 0, ',', '.') }}
                    </td>
                </tr>

                <!-- BARIS AKUN DEBIT & KREDIT (TERTUTUP SECARA DEFAULT) -->
                @foreach ($sortedEntries as $line)
                @php
                $debitVal = (int) ($line->jurnal_debit ?? 0);
                $kreditVal = (int) ($line->jurnal_kredit ?? 0);
                $isCredit = ($kreditVal > 0 && $debitVal === 0);
                $coaCode = $line->coa_code ?? '-';
                $coaName = $line->coa_name ?? ($line->nama_akun ?? ('Akun COA ' . $coaCode));
                $coaType = $line->coa_type ?? null;
                @endphp
                <tr class="gl-entry-row gl-detail-child-row" data-journal-group="{{ $jurnalKey }}">
                    <td></td>
                    <td class="text-end small opacity-60 gl-mono">
                        {{ $isCredit ? 'Kredit' : 'Debit' }}
                    </td>
                    <td>
                        <span class="gl-coa-pill">{{ $coaCode }}</span>
                    </td>
                    <td class="{{ $isCredit ? 'gl-credit-indent' : '' }}">
                        <div class="gl-account-cell">
                            <div class="gl-account-main">
                                @if ($isCredit)
                                <span class="gl-credit-arrow" aria-hidden="true">↳</span>
                                @endif
                                <span class="fw-semibold">{{ $coaName }}</span>
                            </div>

                            @if (!empty($coaType))
                            <span class="badge bg-light text-dark border text-uppercase flex-shrink-0" style="font-size: 0.62rem;">
                                {{ $coaType }}
                            </span>
                            @endif
                        </div>
                    </td>
                    <td class="text-end gl-mono fw-semibold {{ $debitVal > 0 ? 'text-success' : 'opacity-50' }}">
                        {{ $debitVal > 0 ? number_format($debitVal, 0, ',', '.') : '-' }}
                    </td>
                    <td class="text-end gl-mono fw-semibold {{ $kreditVal > 0 ? 'text-danger' : 'opacity-50' }}">
                        {{ $kreditVal > 0 ? number_format($kreditVal, 0, ',', '.') : '-' }}
                    </td>
                </tr>
                @endforeach

                <!-- SUBTOTAL PER BUKTI JURNAL (TERTUTUP SECARA DEFAULT) -->
                <tr class="gl-subtotal-row gl-detail-child-row" data-journal-group="{{ $jurnalKey }}">
                    <td colspan="4" class="text-end fw-semibold opacity-75">
                        Subtotal Bukti <span class="gl-mono">{{ $noBukti }}</span>
                    </td>
                    <td class="text-end gl-mono fw-bold text-success">
                        {{ number_format($subDebit, 0, ',', '.') }}
                    </td>
                    <td class="text-end gl-mono fw-bold text-danger">
                        {{ number_format($subKredit, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="gl-grandtotal-row">
                    <td colspan="4" class="text-end fw-bold text-uppercase">
                        Total Keseluruhan ({{ $groupedJournals->count() }} Bukti Jurnal)
                    </td>
                    <td class="text-end gl-mono fw-bold text-success">
                        Rp {{ number_format($grandTotalDebit, 0, ',', '.') }}
                    </td>
                    <td class="text-end gl-mono fw-bold text-danger">
                        Rp {{ number_format($grandTotalKredit, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    @else
    <div class="text-center py-5 opacity-75">
        <i class="fas fa-folder-open fa-2x text-primary mb-2"></i>
        <div class="fw-bold">Belum Ada Transaksi Jurnal</div>
        <small>Tidak ditemukan catatan jurnal pada rentang tanggal yang dipilih.</small>
    </div>
    @endif
</div>

<script>
    function setJournalGroupExpanded(jurnalKey, expanded) {
        const $headerRow = $('#table-jurnal-umum tbody tr.gl-group-header-row[data-journal-group="' + jurnalKey + '"]');
        const $childRows = $('#table-jurnal-umum tbody tr.gl-detail-child-row[data-journal-group="' + jurnalKey + '"]');

        $headerRow.toggleClass("is-open", expanded);
        $childRows.toggleClass("is-expanded", expanded);
    }

    // Toggle buka / tutup per baris bukti jurnal
    $(document).off("click", "#table-jurnal-umum tbody tr.gl-group-header-row")
        .on("click", "#table-jurnal-umum tbody tr.gl-group-header-row", function() {
            const jurnalKey = $(this).attr("data-journal-group");
            const isOpen = $(this).hasClass("is-open");
            setJournalGroupExpanded(jurnalKey, !isOpen);
        });

    // Buka semua bukti jurnal
    $(document).off("click", "#btn-expand-all-jurnal").on("click", "#btn-expand-all-jurnal", function() {
        $("#table-jurnal-umum tbody tr.gl-group-header-row:visible").each(function() {
            setJournalGroupExpanded($(this).attr("data-journal-group"), true);
        });
    });

    // Tutup semua bukti jurnal
    $(document).off("click", "#btn-collapse-all-jurnal").on("click", "#btn-collapse-all-jurnal", function() {
        $("#table-jurnal-umum tbody tr.gl-group-header-row").each(function() {
            setJournalGroupExpanded($(this).attr("data-journal-group"), false);
        });
    });

    // Laporkan jurnal ke Pusat Keuangan (acc_jurnal)
    $(document).off("click", ".btn-lapor-keuangan").on("click", ".btn-lapor-keuangan", function(e) {
        e.preventDefault();
        e.stopPropagation();

        const $btn = $(this);
        if ($btn.prop("disabled")) return;

        const sourceJurnalId = $btn.data("source-jurnal-id");
        const sourceProject = $btn.data("source-project");
        const noBukti = $btn.data("no-bukti");
        const isBalanced = String($btn.data("balanced")) === "1";

        if (!isBalanced) {
            if (typeof Swal !== "undefined") {
                Swal.fire({
                    icon: "warning",
                    title: "Jurnal Belum Seimbang",
                    text: "Jurnal " + noBukti + " memiliki selisih Debit dan Kredit sehingga belum dapat dilaporkan ke Pusat Keuangan."
                });
            }
            return;
        }

        const executePost = function() {
            $btn.prop("disabled", true);
            const originalHtml = $btn.html();
            $btn.html('<i class="fas fa-spinner fa-spin"></i> Memposting...');

            $.ajax({
                url: "{{ route('general_ledger_post_accounting') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "source_jurnal_id": sourceJurnalId,
                    "source_project": sourceProject
                },
                dataType: "json"
            }).done(function(res) {
                if (res && res.success) {
                    const $cell = $btn.closest(".gl-posting-cell");
                    $cell.find(".gl-posting-badge")
                        .removeClass("bg-warning-subtle text-warning border-warning-subtle")
                        .addClass("bg-success-subtle text-success border-success-subtle")
                        .html('<i class="fas fa-check-circle me-1"></i>Posted');

                    $btn.remove();

                    if (res.acc_jurnal_no) {
                        $cell.append('<small class="gl-mono fw-semibold text-success gl-acc-no-label">' + res.acc_jurnal_no + '</small>');
                    }

                    if (typeof Swal !== "undefined") {
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil Diposting",
                            text: res.message || ("Jurnal " + noBukti + " telah tercatat di Pusat Keuangan."),
                            timer: 1800,
                            showConfirmButton: false
                        });
                    }
                } else {
                    $btn.prop("disabled", false).html(originalHtml);
                    if (typeof Swal !== "undefined") {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal Posting",
                            text: (res && res.message) ? res.message : "Terjadi kesalahan saat melapor ke Pusat Keuangan."
                        });
                    }
                }
            }).fail(function(xhr) {
                $btn.prop("disabled", false).html(originalHtml);
                const errMsg = (xhr.responseJSON && xhr.responseJSON.message)
                    ? xhr.responseJSON.message
                    : "Gagal menghubungi server saat melapor ke Pusat Keuangan.";
                if (typeof Swal !== "undefined") {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: errMsg
                    });
                }
            });
        };

        if (typeof Swal !== "undefined") {
            Swal.fire({
                icon: "question",
                title: "Laporkan ke Pusat Keuangan?",
                html: "Jurnal <strong>" + noBukti + "</strong> akan dicatat ke tabel jurnal terpusat (<code>acc_jurnal</code>) dengan status <strong>Posted</strong>.",
                showCancelButton: true,
                confirmButtonText: "Ya, Laporkan",
                cancelButtonText: "Batal"
            }).then(function(result) {
                if (result.isConfirmed) {
                    executePost();
                }
            });
        } else {
            if (confirm("Laporkan jurnal " + noBukti + " ke Pusat Keuangan?")) {
                executePost();
            }
        }
    });

    // Pencarian cepat per kelompok bukti jurnal
    $(document).off("keyup", "#filter-jurnal-quick").on("keyup", "#filter-jurnal-quick", function() {
        const keyword = $(this).val().toLowerCase().trim();
        const groups = {};

        $("#table-jurnal-umum tbody tr[data-journal-group]").each(function() {
            const grp = $(this).attr("data-journal-group");
            if (!groups[grp]) {
                groups[grp] = {
                    header: null,
                    children: [],
                    text: ""
                };
            }
            if ($(this).hasClass("gl-group-header-row")) {
                groups[grp].header = this;
            } else {
                groups[grp].children.push(this);
            }
            groups[grp].text += " " + $(this).text().toLowerCase();
        });

        Object.keys(groups).forEach(function(grp) {
            const matched = keyword === "" || groups[grp].text.indexOf(keyword) !== -1;
            $(groups[grp].header).toggle(matched);

            if (!matched) {
                $(groups[grp].children).removeClass("is-expanded").hide();
            } else if (keyword !== "") {
                $(groups[grp].header).addClass("is-open");
                $(groups[grp].children).addClass("is-expanded").show();
            } else {
                $(groups[grp].children).css("display", "");
            }
        });
    });
</script>
