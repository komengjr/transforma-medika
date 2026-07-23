@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

@endsection
@section('content')
<div class="mb-4">
    <h3 class="fw-bold text-dark"><i class="bi bi-cash-stack text-primary me-2"></i>Pencairan Paket Dana Arisan</h3>
    <p class="text-muted">Pencairan dihitung mandiri berdasarkan plot kapasitas poin pada bulan klaim berjalan ($\text{Poin Bulan Ini} \times \text{Rate} \times 12$)</p>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body bg-white rounded">
        <form id="formFilterPencairan" class="row g-3" onsubmit="loadPemenangArisan(event)">
            <div class="col-md-4">
                <label class="form-label fw-bold text-secondary">1. Program Arisan</label>
                <select id="pencairanMaster" class="form-select border-primary" required></select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-secondary">2. Tahun</label>
                <select id="pencairanTahun" class="form-select border-primary" required>
                    <option value="">-- Pilih Tahun --</option>
                    @for ($year = 2026; $year <= 2035; $year++)
                        <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold text-secondary">3. Bulan Klaim</label>
                <select id="pencairanBulan" class="form-select border-primary" required>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="bi bi-eye-fill me-1"></i> Cek Klaim</button>
            </div>
        </form>
    </div>
</div>

<div id="wrapperPemenang" class="row g-3"></div>
@endsection
@section('base.js')

<div class="modal fade" id="modalPencairan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalPencairanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="modalPencairanLabel"><i class="bi bi-wallet2 me-2"></i> Konfirmasi Pencairan Dana</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEksekusiPencairan" onsubmit="submitPencairan(event)">
                <div class="modal-body p-4">
                    <div class="mb-3 border-bottom pb-3">
                        <span class="text-secondary small d-block">Penerima / Anggota</span>
                        <h5 id="modalNamaPeserta" class="fw-bold text-dark mb-0">-</h5>
                        <small id="modalKodePeserta" class="text-muted">-</small>
                    </div>

                    <div class="mb-4 bg-light p-3 rounded border text-center">
                        <span class="small text-secondary d-block">NOMINAL YANG AKAN DICAIRKAN</span>
                        <h3 id="modalNominal" class="fw-bold text-success mb-0">Rp 0</h3>
                        <small id="modalDetailHitungan" class="text-muted">-</small>
                    </div>

                    <input type="hidden" id="submitIdPeserta">
                    <input type="hidden" id="submitNominal">
                    <input type="hidden" id="submitPoin">

                    <div class="mb-3">
                        <label for="pencairanAkun" class="form-label fw-bold text-secondary">Pilih Akun Sumber Dana (Pencairan)</label>
                        <select id="pencairanAkun" class="form-select border-primary" required>
                            <option value="">-- Hubungkan ke Akun Kas/Bank --</option>
                            @foreach ($akun as $akuns)
                            <option value="{{ $akuns->coa_code }}">{{ $akuns->coa_code }} - {{ $akuns->coa_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="pencairanKeterangan" class="form-label fw-bold text-secondary">Keterangan Tambahan (Opsional)</label>
                        <textarea id="pencairanKeterangan" class="form-control" rows="2" placeholder="Masukkan catatan transfer atau memo..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top-0">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Setujui & Cairkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const namaBulanIndo = {
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
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Inisialisasi Instance Modal Bootstrap
    let modalPencairanInstance;

    async function initPencairanPage() {
        modalPencairanInstance = new bootstrap.Modal(document.getElementById('modalPencairan'));
        try {
            const res = await fetch(`{{ route('menu_koperasi_pencairan_arisan_get_data') }}`);
            const data = await res.json();

            // Load Dropdown Program Arisan
            const selectMaster = document.getElementById('pencairanMaster');
            selectMaster.innerHTML = '<option value="">-- Pilih Arisan --</option>';
            data.master_aktif.forEach(m => {
                let opt = document.createElement('option');
                opt.value = m.id_kop_master_arisan;
                opt.textContent = m.kop_master_arisan_name;
                selectMaster.appendChild(opt);
            });

            // Load Dropdown Akun Pencairan (Dinamis dari Backend jika ada)
            const selectAkun = document.getElementById('pencairanAkun');
            // selectAkun.innerHTML = '<option value="">-- Hubungkan ke Akun Kas/Bank --</option>';

            // Catatan: sesuaikan atribut data.akun_kas jika nama variabel di backend Anda berbeda

        } catch (err) {
            console.error(err);
        }
    }

    async function loadPemenangArisan(event) {
        event.preventDefault();
        const idMaster = document.getElementById('pencairanMaster').value;
        const tahun = document.getElementById('pencairanTahun').value;
        const bulan = document.getElementById('pencairanBulan').value;

        try {
            const res = await fetch(`{{ url('koperasi/menu-koperasi/pencairan-arisan/cek-pemenang') }}?id_master=${idMaster}&tahun=${tahun}&bulan=${bulan}`);
            const data = await res.json();

            const wrapper = document.getElementById('wrapperPemenang');
            wrapper.innerHTML = '';

            if (data.pemenang.length === 0) {
                wrapper.innerHTML = `<div class="col-12"><div class="alert alert-warning text-center fw-bold shadow-sm">Tidak ada jadwal pencairan poin anggota pada bulan ini.</div></div>`;
                return;
            }

            data.pemenang.forEach(p => {
                let trackingHTML = '';
                p.review_pembayaran.forEach(rev => {
                    let badgeClass = (rev.status === 'Lunas') ? 'status-lunas' : 'status-belum';
                    trackingHTML += `<span class="badge-status ${badgeClass}">${namaBulanIndo[rev.bulan]}: ${rev.status}</span>`;
                });

                let buttonHTML = '';
                if (p.is_sudah_cair) {
                    buttonHTML = `<button class="btn btn-secondary w-100 fw-bold" disabled><i class="bi bi-check-all"></i> DANA PAKET INI SUDAH CAIR</button>`;
                } else if (!p.is_siap_cair) {
                    buttonHTML = `<button class="btn btn-danger w-100 fw-bold" disabled><i class="bi bi-exclamation-triangle-fill"></i> BLOCKED: IURAN BULANAN BELUM LUNAS</button>`;
                } else {
                    // Mengirimkan objek JSON peserta ke parameter fungsi trigger modal
                    const stringifiedData = encodeURIComponent(JSON.stringify(p));
                    buttonHTML = `<button class="btn btn-success w-100 fw-bold" onclick="tampilkanModalCair('${stringifiedData}', ${data.nominal_rate})"><i class="bi bi-cash-coin"></i> CAIRKAN Rp ${new Intl.NumberFormat('id-ID').format(p.nominal_pencairan)}</button>`;
                }

                let card = `
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 bg-white">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-primary">Jadwal Cair Bulan ${namaBulanIndo[bulan]}</span>
                                    <span class="badge bg-dark fs--2">${p.poin_bulan_ini} Poin Paket</span>
                                </div>
                                <h4 class="fw-bold text-dark mb-1">${p.nama_peserta}</h4>
                                <p class="text-muted small border-bottom pb-2">${p.kode_peserta} | ${p.cabang}</p>

                                <div class="mb-3 bg-light p-3 rounded border text-center">
                                    <span class="small text-secondary d-block">TOTAL DANA HAK CAIR BULAN INI</span>
                                    <h3 class="fw-bold text-success mb-0">Rp ${new Intl.NumberFormat('id-ID').format(p.nominal_pencairan)}</h3>
                                    <small class="text-muted">Hitungan: ${p.poin_bulan_ini} Poin x Rp ${new Intl.NumberFormat('id-ID').format(data.nominal_rate)} x 12 Bulan</small>
                                </div>

                                <div class="mb-4">
                                    <label class="fw-bold text-secondary small mb-1 d-block"><i class="bi bi-journal-check"></i> Status Iuran Wajib (Jan s/d ${namaBulanIndo[bulan]}):</label>
                                    <div class="d-flex flex-wrap">${trackingHTML}</div>
                                </div>

                                ${buttonHTML}
                            </div>
                        </div>
                    </div>
                `;
                wrapper.innerHTML += card;
            });

        } catch (err) {
            console.error(err);
        }
    }

    // FUNGSI UNTUK MEMUNCULKAN MODAL & MENGISI DATA FORM MODAL
    function tampilkanModalCair(encodedData, nominalRate) {
        const dataPeserta = JSON.parse(decodeURIComponent(encodedData));
        const bulanText = namaBulanIndo[document.getElementById('pencairanBulan').value];

        // Set data visual di Modal
        document.getElementById('modalNamaPeserta').innerText = dataPeserta.nama_peserta;
        document.getElementById('modalKodePeserta').innerText = `${dataPeserta.kode_peserta} | ${dataPeserta.cabang}`;
        document.getElementById('modalNominal').innerText = `Rp ${new Intl.NumberFormat('id-ID').format(dataPeserta.nominal_pencairan)}`;
        document.getElementById('modalDetailHitungan').innerText = `Hitungan: ${dataPeserta.poin_bulan_ini} Poin x Rp ${new Intl.NumberFormat('id-ID').format(nominalRate)} x 12 Bulan (Bulan ${bulanText})`;

        // Set value input tersembunyi
        document.getElementById('submitIdPeserta').value = dataPeserta.id_peserta;
        document.getElementById('submitNominal').value = dataPeserta.nominal_pencairan;
        document.getElementById('submitPoin').value = dataPeserta.poin_bulan_ini;

        // Set default keterangan
        document.getElementById('pencairanKeterangan').value = `Pencairan Klaim Paket ${dataPeserta.poin_bulan_ini} Poin Terjadwal (${bulanText})`;

        // Reset pilihan akun ke kosong
        document.getElementById('pencairanAkun').value = "";

        // Munculkan Modal
        modalPencairanInstance.show();
    }

    // FUNGSI UNTUK MENGIRIM DATA KE BACKEND SETELAH SUBMIT MODAL
    async function submitPencairan(event) {
        event.preventDefault();

        const idPeserta = document.getElementById('submitIdPeserta').value;
        const nominal = parseFloat(document.getElementById('submitNominal').value);
        const poin = document.getElementById('submitPoin').value;
        const akunKeuangan = document.getElementById('pencairanAkun').value;
        const keterangan = document.getElementById('pencairanKeterangan').value;

        const payload = {
            id_kop_master_arisan: parseInt(document.getElementById('pencairanMaster').value),
            id_kop_master_peserta: parseInt(idPeserta),
            kop_pencairan_bulan: parseInt(document.getElementById('pencairanBulan').value),
            kop_pencairan_tahun: parseInt(document.getElementById('pencairanTahun').value),
            kop_pencairan_nominal: nominal,
            id_akun_keuangan: akunKeuangan, // Tambahan parameter ID Akun Pencairan
            kop_pencairan_keterangan: keterangan
        };

        try {
            const res = await fetch(`{{ route('menu_koperasi_pencairan_arisan_proses') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(payload)
            });
            const result = await res.json();

            if (res.ok) {
                alert(result.message);
                modalPencairanInstance.hide(); // Tutup modal
                loadPemenangArisan(new Event('submit')); // Reload data list pemenang
            } else {
                alert(result.message || 'Gagal memproses pencairan kas.');
            }
        } catch (err) {
            alert('Terjadi kesalahan jaringan.');
        }
    }

    window.onload = initPencairanPage;
</script>
@endsection
