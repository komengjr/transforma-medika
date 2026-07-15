@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

@endsection
@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="card bg-200 shadow border border-success">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3" src="{{ asset('img/koperasi.png') }}" alt="" width="60" />
                    <div>
                        <h6 class="text-success fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-success fw-bold mb-1">{{ Env('APP_LABEL')}} <span
                                class="text-success fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-success fs--1 mb-0">Menu : </h6>
                    <h4 class="text-success fw-bold mb-0">Arisan <span class="text-success fw-medium">Penagihan</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
    <div>
        <h3 class="fw-bold text-dark"><i class="bi bi-wallet2 text-success me-2"></i>Monitoring Pembayaran & Penagihan Arisan</h3>
        <p class="text-muted mb-0">Klik pada kotak indikator bulan berwarna merah untuk memproses pembayaran iuran anggota</p>
    </div>
    <button class="btn btn-outline-secondary btn-sm" onclick="window.print()"><i class="bi bi-printer-fill me-1"></i> Cetak</button>
</div>

<div class="card shadow-sm mb-4 border-0">
    <div class="card-body bg-white rounded">
        <form id="formFilterPenagihan" class="row g-3" onsubmit="prosesCariTagihan(event)">
            <div class="col-md-6">
                <label class="form-label fw-bold text-secondary">1. Program Arisan Aktif</label>
                <select id="penagihanMaster" class="form-select border-success" required></select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold text-secondary">2. Pilih Tahun Berjalan</label>
                <select id="penagihanTahun" class="form-select border-success" required>
                    <option value="">-- Pilih Tahun --</option>
                    @for ($year = 2026; $year <= 2035; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100 fw-bold"><i class="bi bi-arrow-clockwise me-1"></i> Hitung & Monitor</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4 d-none" id="rowSummaryPenagihan">
    <div class="col-md-6">
        <div class="card card-counter shadow-sm border-0 p-4 text-center rounded-3">
            <h6 class="text-white-50 fw-bold mb-1">PROYEKSI TARGET KAS / BULAN</h6>
            <h2 class="fw-bold mb-0" id="txtTotalKasBulanIni">Rp 0</h2>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-0 bg-white p-4 text-center rounded-3">
            <h6 class="text-muted fw-bold mb-1">TOTAL POIN TERDAFTAR (1 TAHUN)</h6>
            <h2 class="fw-bold text-dark mb-0" id="txtTotalPoinBulanIni">0 Poin</h2>
        </div>
    </div>
</div>

<div class="card shadow-sm d-none" id="cardTabelPenagihan">
    <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between align-items-center">
        <span><i class="bi bi-table me-2"></i>Matriks Status Pembayaran Anggota - Tahun <span id="titlePeriodePenagihan" class="text-warning">-</span></span>
        <span class="badge bg-success" id="badgeNominalPoin">Rate: -</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-striped mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th width="50" class="text-center">No</th>
                    <th>Anggota</th>
                    <th>Cabang</th>
                    <th class="text-center">Poin</th>
                    <th class="text-end">Tagihan/Bln</th>
                    <th class="text-center" style="min-width: 460px;">Status Pembayaran Bulanan (Jan - Des)</th>
                </tr>
            </thead>
            <tbody id="tbodyPenagihan"></tbody>
        </table>
    </div>
</div>

@endsection
@section('base.js')

<div class="modal fade" id="modalBayarArisan" tabindex="-1" aria-labelledby="modalBayarArisanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="modalBayarArisanLabel"><i class="bi bi-cash-coin me-2"></i>Konfirmasi Bayar Kas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formBayarArisan" onsubmit="submitPembayaranKas(event)">
                <div class="modal-body row g-3">
                    <input type="hidden" id="modalIdPeserta">
                    <input type="hidden" id="modalTotalPoin">
                    <input type="hidden" id="modalRawNominal">
                    <input type="hidden" id="modalBulanBayar">

                    <div class="col-md-8">
                        <label class="form-label text-muted mb-0 small">Nama Anggota</label>
                        <input type="text" id="modalNamaPeserta" class="form-control fw-bold bg-light" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted mb-0 small">Bulan Daring</label>
                        <input type="text" id="modalTextBulan" class="form-control fw-bold bg-light text-danger text-center" readonly>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Metode Pembayaran</label>
                        <select id="modalMetodeBayar" class="form-select border-primary" required>
                            <option value="Tunai">Tunai / Cash</option>
                            <option value="Transfer">Transfer Bank</option>
                            <option value="Potong Gaji">Potong Gaji</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <div class="p-3 bg-light rounded border text-center">
                            <span class="text-secondary d-block small mb-1 fw-bold">NOMINAL WAJIB SETOR</span>
                            <h3 class="text-success fw-bold mb-0" id="modalDisplayNominal">Rp 0</h3>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Keterangan Tambahan</label>
                        <textarea id="modalKeterangan" class="form-control" rows="2" placeholder="Catatan nomor referensi bank..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold"><i class="bi bi-check-circle-fill"></i> Validasi Lunas</button>
                </div>
            </form>
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
    const namaBulanIndo = {
        1: "Jan",
        2: "Feb",
        3: "Mar",
        4: "Apr",
        5: "Mei",
        6: "Jun",
        7: "Jul",
        8: "Agu",
        9: "Sep",
        10: "Okt",
        11: "Nov",
        12: "Des"
    };
    const namaBulanLengkap = {
        1: "Januari",
        2: "Februari",
        3: "Maret",
        4: "April",
        5: "Mei",
        6: "Juni",
        7: "Juli",
        8: "Agustus",
        9: "September",
        10: "Oktober",
        11: "November",
        12: "Desember"
    };

    let nominalPerPoin = 0;
    let modalBootstrapInstance;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    async function initPenagihanPage() {
        modalBootstrapInstance = new bootstrap.Modal(document.getElementById('modalBayarArisan'));
        try {
            const res = await fetch(`{{ route('menu_koperasi_penagihan_arisan_get_data') }}`);
            const data = await res.json();
            const selectMaster = document.getElementById('penagihanMaster');
            selectMaster.innerHTML = '<option value="">-- Pilih Arisan Aktif --</option>';
            data.master_aktif.forEach(m => {
                let opt = document.createElement('option');
                opt.value = m.id_kop_master_arisan;
                opt.textContent = m.kop_master_arisan_name;
                selectMaster.appendChild(opt);
            });
        } catch (err) {
            console.error(err);
        }
    }

    async function prosesCariTagihan(event) {
        if (event) event.preventDefault();
        const idMaster = document.getElementById('penagihanMaster').value;
        const tahun = document.getElementById('penagihanTahun').value;

        try {
            const res = await fetch(`{{ url('koperasi/menu-koperasi/penagihan-arisan/get-laporan') }}?id_master=${idMaster}&tahun=${tahun}`);
            const result = await res.json();

            document.getElementById('rowSummaryPenagihan').classList.remove('d-none');
            document.getElementById('cardTabelPenagihan').classList.remove('d-none');
            document.getElementById('titlePeriodePenagihan').innerText = tahun;

            nominalPerPoin = result.nominal_per_poin;
            document.getElementById('badgeNominalPoin').innerText = `Rate: Rp ` + new Intl.NumberFormat('id-ID').format(nominalPerPoin) + ' / Poin';

            const tbody = document.getElementById('tbodyPenagihan');
            tbody.innerHTML = '';

            let grandTotalKasPerBulan = 0;
            let grandTotalPoinTahunan = 0;

            if (result.data_tagihan.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data jadwal arisan untuk tahun ini.</td></tr>`;
            } else {
                result.data_tagihan.forEach((item, index) => {
                    grandTotalKasPerBulan += item.tagihan_per_bulan;
                    grandTotalPoinTahunan += parseFloat(item.total_poin_setahun);

                    // Generate blok kotak indikator bulan (Jan - Des)
                    let statusBulanHTML = '';
                    for (let m = 1; m <= 12; m++) {
                        const isLunas = item.bulan_lunas.includes(m);
                        if (isLunas) {
                            statusBulanHTML += `<span class="badge-month month-paid" title="${namaBulanLengkap[m]}: Lunas"><i class="bi bi-check"></i></span>`;
                        } else {
                            statusBulanHTML += `<button type="button" class="badge-month month-unpaid" title="Klik untuk bayar bulan ${namaBulanLengkap[m]}"
                                onclick="bukaModalBayar(${item.id_kop_master_peserta}, '${item.peserta.kop_master_peserta_name}', ${item.total_poin_setahun}, ${item.tagihan_per_bulan}, ${m})">
                                ${namaBulanIndo[m]}
                            </button>`;
                        }
                    }

                    let row = `
                        <tr>
                            <td class="text-center fw-bold text-secondary">${index + 1}</td>
                            <td>
                                <strong>${item.peserta.kop_master_peserta_name}</strong><br>
                                <small class="text-muted">${item.peserta.kop_master_peserta_code}</small>
                            </td>
                            <td>${item.peserta.kop_master_peserta_cabang}</td>
                            <td class="text-center"><span class="badge bg-dark">${item.total_poin_setahun} P</span></td>
                            <td class="text-end fw-bold text-success">Rp ${new Intl.NumberFormat('id-ID').format(item.tagihan_per_bulan)}</td>
                            <td class="text-center">${statusBulanHTML}</td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            }

            document.getElementById('txtTotalKasBulanIni').innerText = `Rp ` + new Intl.NumberFormat('id-ID').format(grandTotalKasPerBulan);
            document.getElementById('txtTotalPoinBulanIni').innerText = `${grandTotalPoinTahunan} Poin`;

        } catch (err) {
            console.error(err);
        }
    }

    function bukaModalBayar(idPeserta, namaPeserta, totalPoin, nominal, bulan) {
        document.getElementById('modalIdPeserta').value = idPeserta;
        document.getElementById('modalNamaPeserta').value = namaPeserta;
        document.getElementById('modalTotalPoin').value = totalPoin;
        document.getElementById('modalRawNominal').value = nominal;
        document.getElementById('modalBulanBayar').value = bulan;
        document.getElementById('modalTextBulan').value = namaBulanLengkap[bulan].toUpperCase();
        document.getElementById('modalKeterangan').value = '';

        document.getElementById('modalDisplayNominal').innerText = `Rp ` + new Intl.NumberFormat('id-ID').format(nominal);

        modalBootstrapInstance.show();
    }

    async function submitPembayaranKas(event) {
        event.preventDefault();

        const payload = {
            id_kop_master_arisan: parseInt(document.getElementById('penagihanMaster').value),
            id_kop_master_peserta: parseInt(document.getElementById('modalIdPeserta').value),
            kop_transaksi_bulan: parseInt(document.getElementById('modalBulanBayar').value),
            kop_transaksi_tahun: parseInt(document.getElementById('penagihanTahun').value),
            kop_transaksi_total_poin: parseInt(document.getElementById('modalTotalPoin').value),
            kop_transaksi_nominal: parseFloat(document.getElementById('modalRawNominal').value),
            kop_transaksi_metode: document.getElementById('modalMetodeBayar').value,
            kop_transaksi_keterangan: document.getElementById('modalKeterangan').value.trim()
        };

        try {
            const res = await fetch(`{{ route('menu_koperasi_penagihan_arisan_payment') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify(payload)
            });

            const result = await res.json();

            if (res.ok) {
                alert(result.message);
                modalBootstrapInstance.hide();
                prosesCariTagihan(null); // Refreshes matrix table status updates directly without re-submit event
            } else {
                alert(result.message || 'Gagal menyimpan transaksi kas.');
            }
        } catch (err) {
            alert('Terjadi eror jaringan.');
        }
    }

    window.onload = initPenagihanPage;
</script>
@endsection
