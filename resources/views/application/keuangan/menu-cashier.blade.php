@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<style>
    .card-custom {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.08);
        border: none;
    }

    .bg-layanan {
        background-color: #f1f3f5;
        font-weight: bold;
    }

    .subtotal-row {
        background-color: #e9ecef;
        font-weight: bold;
    }

    .text-coret {
        text-decoration: line-through;
        font-size: 0.85rem;
    }
</style>
@endsection
@section('content')
<div class="row mb-3">
    <div class="col">
        <div class="card bg-primary shadow border border-primary">
            <div class="row gx-0 flex-between-center">
                <div class="col-sm-auto d-flex align-items-center border-bottom">
                    <img class="ms-3 mx-3 m-2" src="{{ asset('img/keuangan.png') }}" alt="" width="50" />
                    <div>
                        <h6 class="text-white fs--1 mb-0 pt-2">Welcome to </h6>
                        <h4 class="text-white fw-bold mb-1">{{env('APP_NAME')}} <span
                                class="text-white fw-medium">Management
                                System</span></h4>
                    </div>
                    <img class="ms-n4 d-none d-lg-block "
                        src="{{ asset('asset/img/illustrations/crm-line-chart.png') }}" alt="" width="150" />
                </div>
                <div class="col-xl-auto px-3 py-2">
                    <h6 class="text-white fs--1 mb-0">Menu : </h6>
                    <h4 class="text-white fw-bold mb-0">Menu <span class="text-white fw-medium">Cashier</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card card-custom mb-3">
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-qr-code"></i></span>
                    <input type="text" id="noRegInput" class="form-control" placeholder="Masukkan No. Order Code Pasien...">
                    <button class="btn btn-primary" onclick="cariRegistrasi()"><i class="bi bi-search"></i> Cari</button>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalDaftarPasien" onclick="loadDaftarPasienModal()">
                    <i class="bi bi-person-lines-fill"></i> Lihat Antrean & Total Tagihan Pasien
                </button>
            </div>
        </div>
    </div>
</div>

<div id="sectionPembayaran" style="display: none;">
    <div class="row mb-3 g-3">
        <div class="col-md-4">
            <div class="card card-custom h-100">
                <div class="card-header bg-primary text-white fw-bold"><i class="bi bi-person-badge"></i> Profil Pasien</div>
                <div class="card-body">
                    <table class="table table-borderless sm mb-0">
                        <tr>
                            <th>No. Order</th>
                            <td>: <span id="lblNoReg" class="fw-bold">-</span></td>
                        </tr>
                        <tr>
                            <th>No. RM</th>
                            <td>: <span id="lblNoRM">-</span></td>
                        </tr>
                        <tr>
                            <th>Nama Pasien</th>
                            <td>: <span id="lblNama" class="text-uppercase fw-bold text-primary">-</span></td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>: <span id="lblJK">-</span></td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>: <span id="lblUnit">-</span></td>
                        </tr>
                        <tr>
                            <th>Tgl Order</th>
                            <td>: <span id="lblTanggal">-</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-custom h-100">
                <div class="card-header bg-dark text-white fw-bold"><i class="bi bi-receipt-cutoff"></i> Rincian Tindakan</div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0 align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th width="5%" class="text-center">Pilih</th>
                                <th>Nama Pemeriksaan / Tindakan</th>
                                <th width="15%" class="text-center">Diskon</th>
                                <th width="25%" class="text-end">Biaya Akhir</th>
                                <th width="15%" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody id="tabelRincianLayanan"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h5 class="text-muted">Total Dicentang Kasir:</h5>
                    <h2 class="text-success fw-bold" id="totalBayar">Rp 0</h2>
                </div>
                <div class="col-md-6" id="sectionMetodeBayar" style="display: none;">
                    <h5>Metode Pembayaran</h5>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-lg" id="metodePembayaran">
                            <option value="" selected disabled>-- Pilih Jenis --</option>
                            <option value="Tunai">Tunai / Cash</option>
                            <option value="Debit">Debit Card</option>
                            <option value="QRIS">QRIS Standar</option>
                        </select>
                        <button class="btn btn-danger btn-lg text-nowrap" onclick="prosesPembayaran()">Eksekusi Bayar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('base.js')
<div class="modal fade" id="modalDaftarPasien" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="bi bi-table"></i> Antrean Billing Aktif (Direct Total Price)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped border">
                        <thead class="table-secondary">
                            <tr>
                                <th>No. Order</th>
                                <th>No. RM</th>
                                <th>Nama Pasien</th>
                                <th>Kategori</th>
                                <th class="text-end">Total Tagihan</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tabelListModalPasien"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-cashier" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-cashier"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('asset/js/rupiah-payment.js') }}"></script>

<script>
    let dataAktif = null;

    function loadDaftarPasienModal() {
        const tbodyModal = document.getElementById("tabelListModalPasien");
        tbodyModal.innerHTML = `<tr><td colspan="6" class="text-center">Sedang menghitung total tagihan...</td></tr>`;

        fetch(`{{ route('keuangan_menu_cashier_list_all_patient') }}`)
            .then(r => r.json())
            .then(res => {
                if (res.success && res.data.length > 0) {
                    tbodyModal.innerHTML = "";
                    res.data.forEach(order => {
                        let rItem = `
                                <tr>
                                    <td><span class="badge bg-secondary">${order.d_reg_order_code}</span></td>
                                    <td>${order.rm_code}</td>
                                    <td class="fw-bold">${order.patient_name}</td>
                                    <td><span class="badge bg-info text-dark">${order.t_layanan_cat_code}</span></td>
                                    <td class="text-end fw-bold text-danger">Rp ${(order.total_tagihan).toLocaleString('id-ID')}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-success" onclick="pilihPasienDariModal('${order.d_reg_order_code}')">Pilih</button>
                                    </td>
                                </tr>`;
                        tbodyModal.insertAdjacentHTML('beforeend', rItem);
                    });
                } else {
                    tbodyModal.innerHTML = `<tr><td colspan="6" class="text-center text-muted">Tidak ada transaksi menggantung.</td></tr>`;
                }
            });
    }

    function pilihPasienDariModal(noReg) {
        document.getElementById("noRegInput").value = noReg;
        bootstrap.Modal.getInstance(document.getElementById('modalDaftarPasien')).hide();
        cariRegistrasi();
    }

    function cariRegistrasi() {
        const noReg = document.getElementById("noRegInput").value.trim().toUpperCase();
        if (!noReg) return;

        fetch(`{{ route('keuangan_menu_cashier_find_data_v2') }}?no_reg=${noReg}`)
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    dataAktif = res.data;
                    document.getElementById("lblNoReg").innerText = dataAktif.no_reg;
                    document.getElementById("lblNoRM").innerText = dataAktif.no_rm;
                    document.getElementById("lblNama").innerText = dataAktif.nama;
                    document.getElementById("lblJK").innerText = dataAktif.jk;
                    document.getElementById("lblUnit").innerText = dataAktif.kategori_layanan;
                    document.getElementById("lblTanggal").innerText = dataAktif.tanggal;

                    renderTabelKategori(dataAktif.layanan);
                    document.getElementById("sectionPembayaran").style.display = "block";
                    hitungMasingMasingSubtotal();
                } else {
                    alert(res.message);
                }
            });
    }

    function renderTabelKategori(layananData) {
        const tbody = document.getElementById("tabelRincianLayanan");
        tbody.innerHTML = "";

        for (const namaLayanan in layananData) {
            if (!layananData[namaLayanan] || layananData[namaLayanan].length === 0) continue;
            let namaId = namaLayanan.replace(/\s+/g, '');

            let hRow = `
                    <tr class="bg-layanan text-primary">
                        <td class="text-center"><input class="form-check-input header-check" type="checkbox" id="chAll-${namaId}" onchange="toggleCheckAll('${namaId}', this)"></td>
                        <td colspan="4"><label for="chAll-${namaId}" style="cursor:pointer;">${namaLayanan}</label></td>
                    </tr>`;
            tbody.insertAdjacentHTML('beforeend', hRow);

            layananData[namaLayanan].forEach(item => {
                let hargaAsli = parseInt(item.harga) || 0;
                let disc = parseInt(item.diskon) || 0;
                let hargaAkhir = hargaAsli - disc;

                let bHTML = disc > 0 ? `<div class="text-muted text-coret">Rp ${hargaAsli.toLocaleString('id-ID')}</div><div class="fw-bold">Rp ${hargaAkhir.toLocaleString('id-ID')}</div>` : `<div class="fw-bold">Rp ${hargaAsli.toLocaleString('id-ID')}</div>`;
                let cbHTML = item.lunas ? `<input class="form-check-input" type="checkbox" disabled checked>` : `<input class="form-check-input item-checkbox child-of-${namaId}" type="checkbox" value="${hargaAkhir}" data-id="${item.id}" data-kategori="${namaLayanan}" onchange="cekKondisiHeader('${namaId}')">`;
                let stHTML = item.lunas ? `<span class="badge bg-success">Lunas</span>` : `<span class="badge bg-warning text-dark">Belum Lunas</span>`;

                let iRow = `
                        <tr>
                            <td class="text-center">${cbHTML}</td>
                            <td>${item.nama}</td>
                            <td class="text-center">${disc > 0 ? '-' + disc.toLocaleString('id-ID') : '-'}</td>
                            <td class="text-end">${bHTML}</td>
                            <td class="text-center">${stHTML}</td>
                        </tr>`;
                tbody.insertAdjacentHTML('beforeend', iRow);
            });

            tbody.insertAdjacentHTML('beforeend', `<tr class="subtotal-row"><td colspan="3" class="text-end text-muted">Subtotal:</td><td class="text-end" id="subtotal-${namaId}">Rp 0</td><td></td></tr>`);
        }
    }

    function toggleCheckAll(id, master) {
        document.querySelectorAll(`.child-of-${id}`).forEach(cb => {
            if (!cb.disabled) cb.checked = master.checked;
        });
        hitungMasingMasingSubtotal();
    }

    function cekKondisiHeader(id) {
        const total = document.querySelectorAll(`.child-of-${id}`).length;
        const checked = document.querySelectorAll(`.child-of-${id}:checked`).length;
        document.getElementById(`chAll-${id}`).checked = total === checked;
        hitungMasingMasingSubtotal();
    }

    function hitungMasingMasingSubtotal() {
        let grand = 0;
        for (const key in dataAktif.layanan) {
            let sub = 0;
            let namaId = key.replace(/\s+/g, '');
            if (!document.getElementById(`subtotal-${namaId}`)) continue;
            document.querySelectorAll(`.item-checkbox[data-kategori="${key}"]:checked`).forEach(cb => sub += parseInt(cb.value));
            document.getElementById(`subtotal-${namaId}`).innerText = "Rp " + sub.toLocaleString('id-ID');
            grand += sub;
        }
        document.getElementById("totalBayar").innerText = "Rp " + grand.toLocaleString('id-ID');
        document.getElementById("sectionMetodeBayar").style.display = grand > 0 ? "block" : "none";
    }

    function prosesPembayaran() {
        // 1. Ambil metode pembayaran terpilih (Tunai / Debit / QRIS)
        const metodePilihan = document.getElementById("metodePembayaran").value;
        if (!metodePilihan) {
            return alert("Peringatan: Silakan pilih metode pembayaran terlebih dahulu!");
        }

        // 2. Kumpulkan seluruh ID item tindakan yang sedang dicentang oleh kasir
        let itemTerpilih = [];
        document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
            itemTerpilih.push({
                id: cb.getAttribute('data-id'),
                kategori: cb.getAttribute('data-kategori')
            });
        });

        // Validasi pengaman awal sebelum mengirim ke server
        if (itemTerpilih.length === 0) {
            return alert("Peringatan: Centang minimal satu item tindakan sebelum memproses transaksi!");
        }
        if (!dataAktif || !dataAktif.no_reg) {
            return alert("Error: Berkas pendaftaran pasien belum dimuat sempurna.");
        }

        // Konfirmasi final kepada petugas kasir
        if (!confirm("Apakah Anda yakin ingin memproses pelunasan untuk item tindakan yang dipilih?")) {
            return;
        }

        // 3. Kirim paket data menggunakan FETCH API menuju endpoint Laravel
        fetch(`{{ route('keuangan_menu_cashier_proses_payment') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Pengaman CSRF token laravel
                },
                body: JSON.stringify({
                    d_reg_order_code: dataAktif.no_reg, // Kode pendaftaran puncak (misal: ORD-001)
                    metode_pembayaran: metodePilihan, // String: 'Tunai' / 'Debit' / 'QRIS'
                    items: itemTerpilih // Array ID tindakan detail
                })
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    // Tampilkan pesan sukses berserta kode invoice yang terbit dari database
                    alert(`SUKSES!\n${result.message}\nTotal Uang Masuk: Rp ${result.total_dibayar.toLocaleString('id-ID')}`);

                    // Panggil kembali fungsi cariRegistrasi() untuk memuat ulang tabel rincian tindakan
                    // Item yang baru saja dibayar otomatis berubah status menjadi "Lunas" & checkbox menghilang
                    cariRegistrasi();
                } else {
                    alert("Gagal: " + result.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Terjadi gangguan koneksi internet, silakan periksa jaringan server kasir.");
            });
    }
</script>
@endsection
