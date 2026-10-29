<style>
    /* Styling Tabel Full-Bleed & Adaptif Dark/Light Mode */
    .table-full-bleed {
        width: 100% !important;
        margin-bottom: 0 !important;
    }

    .table-full-bleed thead th {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;
        color: #ffffff !important;
        font-size: 0.7rem !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 14px 16px !important;
        border: none !important;
        white-space: nowrap;
    }

    .table-full-bleed tbody tr {
        transition: all 0.2s ease-in-out;
    }

    /* Penyesuaian Baris Hover & Warna Teks untuk Dark Mode / Light Mode */
    [data-bs-theme="dark"] .table-full-bleed tbody tr,
    body.dark .table-full-bleed tbody tr {
        background-color: #111827;
        border-bottom: 1px solid #1f2937;
    }

    [data-bs-theme="dark"] .table-full-bleed tbody tr:hover,
    body.dark .table-full-bleed tbody tr:hover {
        background-color: #1f2937 !important;
    }

    :not([data-bs-theme="dark"]) .table-full-bleed tbody tr {
        background-color: #ffffff;
        border-bottom: 1px solid #f1f5f9;
    }

    :not([data-bs-theme="dark"]) .table-full-bleed tbody tr:hover {
        background-color: #f8fafc !important;
    }

    .table-full-bleed tbody td {
        padding: 14px 16px !important;
        vertical-align: middle;
        font-size: 0.8rem;
    }

    /* Komponen Pendukung */
    .avatar-modern {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        color: #ffffff;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 0.85rem;
        box-shadow: 0 3px 8px rgba(99, 102, 241, 0.25);
        flex-shrink: 0;
    }

    .badge-reg-code {
        color: #3b82f6;
        font-weight: 700;
        font-size: 0.82rem;
    }

    .badge-user-pill {
        background-color: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 6px;
        padding: 2px 8px;
        font-size: 0.68rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 3px;
    }

    .badge-category-pill {
        background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
        color: #ffffff;
        font-size: 0.68rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-block;
    }

    .badge-layanan-item {
        background-color: rgba(148, 163, 184, 0.08);
        border: 1px solid rgba(148, 163, 184, 0.2);
        border-radius: 8px;
        padding: 4px 8px;
        font-size: 0.72rem;
    }

    .badge-date-pill {
        background-color: #0f172a;
        color: #ffffff;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action-options {
        background: transparent;
        border: 1px solid rgba(148, 163, 184, 0.3);
        color: inherit;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-action-options:hover {
        background-color: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }
</style>


<table id="example" class="table table-full-bleed align-middle">
    <thead>
        <tr class="fs--2">
            <th class="text-center" style="width: 50px;">NO</th>
            <th>NO. REGISTRASI & PETUGAS</th>
            <th>NAMA PASIEN</th>
            <th>TEMPAT, TGL LAHIR</th>
            <th>PENJAMIN</th>
            <th>LAYANAN PEMERIKSAAN</th>
            <th class="text-end">BIAYA & PEMBAYARAN</th>
            <th>PENGIRIMAN & BAHASA</th>
            <th>TANGGAL REG</th>
            <th class="text-center" style="width: 70px;">AKSI</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($data as$datas)
        @php
        $initial = strtoupper(substr($datas->nama_pasien, 0, 1));$gender = isset($datas->jk) ?$datas->jk : 'L';
        $isBatal = ($datas->status_kunjungan === 'BATAL');

        // Ambil informasi transaksi tambahan
        $transaksi = DB::table('medical_transaksi')->where('registrasi_id',$datas->registrasi_id)->first();
        @endphp
        <tr>
            <td class="text-center fw-bold text-muted">{{ $no++ }}</td>
            <td>
                @if($datas->is_cito)
                <span class="badge bg-danger text-white shadow-sm mb-1" style="font-size: 0.65rem;"><i class="fas fa-exclamation-triangle me-1"></i>CITO</span>
                @endif
                @if($isBatal)
                <span class="badge bg-dark text-white shadow-sm mb-1" style="font-size: 0.65rem;"><i class="fas fa-times me-1"></i>VOID</span>
                @endif

                <div class="badge-reg-code {{ $isBatal ? 'text-decoration-line-through text-muted' : '' }}">{{ $datas->no_registrasi }}</div>
                <div class="badge-user-pill mt-1">
                    <i class="fas fa-user me-1"></i>{{ $datas->petugas ?? 'Sistem' }}
                </div>
            </td>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar-modern">{{ $initial }}</div>
                    <div>
                        <div class="fw-bold d-inline-block">
                            {{ $datas->title ? $datas->title . ' ' : '' }}{{$datas->nama_pasien }}
                        </div>
                        <span class="ms-1 fw-bold {{ $gender == 'L' ? 'text-primary' : 'text-danger' }}" style="font-size: 0.75rem;">
                            ({{ $gender }})
                        </span>
                        <div class="text-muted fs--2">
                            PID: {{ $datas->pid }}
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="fs--1">
                    <i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $datas->tempat_lahir ?? '-' }}
                </div>
                <div class="text-muted fs--2">
                    {{ $datas->tgl_lahir ? date('d-m-Y', strtotime($datas->tgl_lahir)) : '-' }}
                </div>
            </td>
            <td>
                <span class="badge-category-pill">
                    <i class="fas fa-id-card me-1"></i>{{ strtoupper($datas->agreement ?? 'UMUM') }}
                </span>
            </td>
            <td>
                @php
                $layananList = DB::table('medical_transaksi_detail as td')
                ->join('medical_master_pemeriksaan as mp', 'td.master_pemeriksaan_id', '=', 'mp.id')
                ->where('td.transaksi_id', $datas->transaksi_id ?? 0)
                ->select('td.no_pemeriksaan', 'mp.nama_layanan')
                ->get();
                @endphp
                <div class="d-flex flex-column gap-1" style="max-width: 220px;">
                    @forelse ($layananList as$itemLayanan)
                    <div class="badge-layanan-item">
                        <span class="fw-bold">{{ $itemLayanan->no_pemeriksaan }}</span><br>
                        <span class="text-warning fw-semibold">{{ strtoupper($itemLayanan->nama_layanan) }}</span>
                    </div>
                    @empty
                    <span class="text-muted fs--2">-</span>
                    @endforelse
                </div>
            </td>
            <td class="text-end">
                <div class="fw-bold" style="font-size: 0.85rem;">
                    Rp {{ $transaksi ? number_format($transaksi->total_tagihan, 0, ',', '.') : '0' }}
                </div>
                <div class="mt-1">
                    <span class="badge border px-2 py-0.5 fw-bold text-dark" style="font-size: 0.62rem;">
                        {{ $transaksi ? $transaksi->metode_bayar : '-' }}
                    </span>
                </div>
                <div class="mt-1">
                    @php
                    $statusBayar = strtoupper($transaksi->status_pembayaran ?? 'BELUM LUNAS');
                    @endphp
                    @if($statusBayar === 'LUNAS')
                    <span class="badge bg-success" style="font-size: 0.6rem;">LUNAS</span>
                    @elseif($statusBayar === 'REFUND')
                    <span class="badge bg-secondary" style="font-size: 0.6rem;">RETUR DANA</span>
                    @elseif($statusBayar === 'BATAL')
                    <span class="badge bg-danger" style="font-size: 0.6rem;">BATAL</span>
                    @else
                    <span class="badge bg-warning text-dark" style="font-size: 0.6rem;">BELUM LUNAS</span>
                    @endif
                </div>
            </td>
            <td>
                <div class="d-flex flex-column gap-1 mb-1.5">
                    @php
                    $metodeArray = json_decode($datas->metode_pengiriman ?? '[]', true);
                    @endphp
                    @if(!empty($metodeArray) && is_array($metodeArray))
                    @foreach ($metodeArray as$metode)
                    <span class="badge bg-info text-dark" style="font-size: 0.62rem; width: fit-content;">
                        <i class="fas fa-paper-plane me-1"></i>{{ strtoupper($metode) }}
                    </span>
                    @endforeach
                    @else
                    <span class="badge bg-secondary" style="font-size: 0.62rem; width: fit-content;">AMBIL SENDIRI</span>
                    @endif
                </div>
                <div>
                    @php
                    $bahasaArray = json_decode($datas->bahasa_hasil ?? '[]', true);
                    @endphp
                    <span class="text-muted fs--2">Bahasa:
                        <strong class="text-info">{{ !empty($bahasaArray) ? implode(', ', $bahasaArray) : 'ID' }}</strong>
                    </span>
                </div>
            </td>
            <td>
                <span class="badge-date-pill">
                    <i class="far fa-clock text-info"></i> {{ date('d-m-Y H:i', strtotime($datas->tanggal_registrasi)) }}
                </span>
            </td>
            <td class="text-center">
                <div class="dropdown">
                    <button class="btn-action-options" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3 py-2 fs--1">
                        <li>
                            <button class="dropdown-item text-primary py-2 fw-semibold d-flex align-items-center gap-2 button-data-detail-pasien" data-bs-toggle="modal" data-bs-target="#modal-supervisior" data-code="{{ $datas->registrasi_id }}">
                                <i class="fas fa-user-shield text-primary"></i> Supervisi / Edit Data
                            </button>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


<script>
    if (!$.fn.DataTable.isDataTable('#example')) {
        new DataTable('#example', {
            responsive: true,
            language: {
                searchPlaceholder: "Cari data pasien...",
                search: "",
                lengthMenu: "Tampilkan _MENU_ data"
            }
        });
    }
</script>
