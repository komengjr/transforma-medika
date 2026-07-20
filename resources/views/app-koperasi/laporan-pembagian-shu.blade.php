@extends('layouts.layouts') {{-- Sesuaikan dengan nama layout aplikasi Anda --}}

@section('content')

<div class="card shadow-sm border-0 mb-3">
    <div class="card-body">
        <h5 class="fw-bold text-uppercase mb-4 text-dark border-bottom pb-2">
            <i class="bi bi-calculator me-2 text-primary"></i> Perhitungan & Distribusi SHU Koperasi
        </h5>

        <!-- FORM FILTER -->
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="tgl_mulai" class="form-label small fw-bold text-secondary">Tanggal Mulai Periode</label>
                <input type="date" id="tgl_mulai" class="form-control" value="{{ date('Y-01-01') }}">
            </div>
            <div class="col-md-3">
                <label for="tgl_selesai" class="form-label small fw-bold text-secondary">Tanggal Selesai Periode</label>
                <input type="date" id="tgl_selesai" class="form-control" value="{{ date('Y-12-31') }}">
            </div>
            <div class="col-md-3">
                <label for="filter-cabang" class="form-label small fw-bold text-secondary">Unit / Kantor Cabang</label>
                <select id="filter-cabang" class="form-select border-primary fw-semibold">
                    <option value="ALL">-- Semua Cabang --</option>
                    @foreach($cabangs as $cabang)
                    <option value="{{ $cabang->kop_master_cabang_code }}">{{ $cabang->kop_master_cabang_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="button" id="btn-proses-shu" class="btn btn-primary w-100 fw-bold shadow-sm">
                    <i class="bi bi-gear-fill me-2"></i> Proses SHU
                </button>
            </div>
        </div>
    </div>
</div>

<!-- KONTAINER UTAMA -->
<div id="shu-report-container" class="card shadow-sm border-0 p-4 min-vh-25">
    <div class="text-center text-muted py-5">
        <i class="bi bi-file-earmark-bar-graph fs-1 d-block mb-3 text-secondary opacity-50"></i>
        Silakan tentukan periode tanggal dan cabang di atas, lalu klik tombol <strong>Proses SHU</strong> untuk memuat data.
    </div>
</div>

<!-- MODAL PILIH COA PENCAIRAN -->
<div class="modal fade" id="modalCairkanShu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCairkanShuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="modalCairkanShuLabel">
                    <i class="bi bi-cash-coin me-2"></i> Konfirmasi Pencairan SHU
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Info Anggota (Dinamis via JS) -->
                <div class="bg-light p-3 rounded mb-3 border">
                    <table class="table table-sm table-borderless m-0 small">
                        <tr>
                            <td class="text-secondary" style="width: 35%;">ID / Nama Anggota</td>
                            <td class="fw-bold text-dark">: <span id="modal-info-anggota">-</span></td>
                        </tr>
                        <tr>
                            <td class="text-secondary">Nominal SHU</td>
                            <td class="fw-bold text-success">: <span id="modal-info-nominal">-</span></td>
                        </tr>
                    </table>
                </div>

                <!-- Pilihan Akun COA -->
                <div class="mb-3">
                    <label for="modal-select-coa" class="form-label small fw-bold text-secondary">Pilih Akun Sumber Dana (COA)</label>
                    <select id="modal-select-coa" class="form-select border-primary fw-semibold">
                        <option value="">-- Pilih Akun Kas / Bank --</option>
                        @foreach($coas as $coa)
                        {{-- Sesuaikan 'code' dan 'name' dengan property model COA Anda --}}
                        <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                        @endforeach
                    </select>
                    <div class="form-text text-muted small">Akun ini akan didebit/kredit pada jurnal pengeluaran kas pencairan SHU.</div>
                </div>
            </div>
            <div class="modal-footer bg-light border-top-0">
                <button type="button" class="btn btn-secondary fw-bold shadow-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btn-submit-cairkan" class="btn btn-success fw-bold shadow-sm">
                    <i class="bi bi-check-circle me-1"></i> Proses Cairkan
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('base.js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let rawShuAnggota = [];
        let dataPencairanAktif = {}; // Menyimpan data baris anggota yang sedang dipilih untuk modal

        const rupiahFormatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });

        // Inisialisasi Instance Bootstrap Modal
        const bsModalCairkan = new bootstrap.Modal(document.getElementById('modalCairkanShu'));

        const btnProses = document.getElementById('btn-proses-shu');
        const container = document.getElementById('shu-report-container');
        const selectCabang = document.getElementById('filter-cabang');
        const btnSubmitCairkan = document.getElementById('btn-submit-cairkan');
        const selectCoa = document.getElementById('modal-select-coa');

        if (btnProses) {
            btnProses.addEventListener('click', prosesHitungSHU);
        }

        function prosesHitungSHU() {
            const tglMulai = document.getElementById('tgl_mulai').value;
            const tglSelesai = document.getElementById('tgl_selesai').value;
            const cabangId = selectCabang.value;

            if (!tglMulai || !tglSelesai) {
                alert('Mohon isi tanggal mulai dan tanggal selesai terlebih dahulu.');
                return;
            }

            btnProses.disabled = true;
            btnProses.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Menghitung...`;

            container.innerHTML = `
            <div class="text-center py-5 my-3 text-muted">
                <div class="spinner-border text-primary mb-3" style="width: 2.5rem; height: 2.5rem;" role="status"></div>
                <p class="mb-0 fw-semibold">Menghitung alokasi anggaran, partisipasi modal, dan transaksi belanja anggota...</p>
                <small class="text-secondary">Mohon tunggu, server sedang mengkalkulasi database jurnal akuntansi.</small>
            </div>`;

            const params = new URLSearchParams({
                tgl_mulai: tglMulai,
                tgl_selesai: tglSelesai,
                cabang_id: cabangId
            }).toString();

            const url = `{{ url('koperasi/laporan-koperasi/laporan-pembagian-shu/get-data') }}?${params}`;

            fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Respon server bermasalah.');
                    return res.json();
                })
                .then(data => {
                    btnProses.disabled = false;
                    btnProses.innerHTML = `<i class="bi bi-gear-fill me-2"></i> Proses SHU`;

                    const persentase = data.persentase || {};
                    const alokasi = data.alokasi_shu || data.alokasi || {};
                    rawShuAnggota = data.detail_anggota || [];

                    const namaCabangTerpilih = selectCabang.options[selectCabang.selectedIndex].text;

                    container.innerHTML = `
                    <div class="text-center mb-4 border-bottom pb-3">
                        <h4 class="fw-bold m-0 text-dark">LAPORAN ALOKASI & DISTRIBUSI SHU ANGGOTA</h4>
                        <p class="text-muted fw-semibold mb-1">Unit/Cabang: <span class="text-primary">${escapeHtml(namaCabangTerpilih)}</span></p>
                        <p class="text-muted small mb-0">Periode Perhitungan: <span class="badge bg-secondary">${escapeHtml(tglMulai)}</span> sampai <span class="badge bg-secondary">${escapeHtml(tglSelesai)}</span></p>
                    </div>

                    <div class="alert alert-primary d-flex justify-content-between align-items-center p-3 mb-4 rounded-3 border-0 shadow-sm">
                        <span class="fw-bold text-uppercase"><i class="bi bi-bank me-2 fs-5"></i> Sisa Hasil Usaha (SHU) Bersih Terbuku</span>
                        <span class="fw-bold fs-3 font-monospace">${rupiahFormatter.format(data.shu_total || 0)}</span>
                    </div>

                    <!-- TABEL ALOKASI -->
                    <div class="card shadow-none border mb-5">
                        <div class="card-header bg-body-tertiary fw-bold text-dark py-2">
                            <i class="bi bi-pie-chart-fill me-2 text-warning"></i> Distribusi Pagu Anggaran Pembagian SHU
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle m-0 small">
                                <thead>
                                    <tr class="table-light text-secondary">
                                        <th>Nama Komponen / Peruntukan Alokasi</th>
                                        <th class="text-center" style="width: 20%;">Rasio AD/ART</th>
                                        <th class="text-end" style="width: 35%;">Nilai Nominal (Rupiah)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td class="ps-3">Dana Cadangan Lembaga Koperasi</td><td class="text-center">${persentase.dana_cadangan || 0}%</td><td class="text-end font-monospace fw-semibold">${rupiahFormatter.format(alokasi.dana_cadangan || 0)}</td></tr>
                                    <tr class="table-success text-success fw-bold"><td class="ps-3"><i class="bi bi-check-circle-fill me-2"></i> Jasa Modal / Simpanan (Hak Anggota)</td><td class="text-center">${persentase.jasa_modal || 0}%</td><td class="text-end font-monospace">${rupiahFormatter.format(alokasi.jasa_modal || 0)}</td></tr>
                                    <tr class="table-success text-success fw-bold"><td class="ps-3"><i class="bi bi-check-circle-fill me-2"></i> Jasa Usaha / Partisipasi Belanja (Hak Anggota)</td><td class="text-center">${persentase.jasa_anggota || persentase.jasa_usaha || 0}%</td><td class="text-end font-monospace">${rupiahFormatter.format(alokasi.jasa_anggota || alokasi.jasa_usaha || 0)}</td></tr>
                                    <tr><td class="ps-3">Dana Insentif Pengurus & Pengawas</td><td class="text-center">${persentase.dana_pengurus || 0}%</td><td class="text-end font-monospace">${rupiahFormatter.format(alokasi.dana_pengurus || 0)}</td></tr>
                                    <tr><td class="ps-3">Dana Kesejahteraan Karyawan/Pengelola</td><td class="text-center">${persentase.dana_karyawan || 0}%</td><td class="text-end font-monospace">${rupiahFormatter.format(alokasi.dana_karyawan || 0)}</td></tr>
                                    <tr><td class="ps-3">Dana Pendidikan Anggota & Koperasi</td><td class="text-center">${persentase.dana_pendidikan || 0}%</td><td class="text-end font-monospace">${rupiahFormatter.format(alokasi.dana_pendidikan || 0)}</td></tr>
                                    <tr><td class="ps-3">Dana Alokasi Sosial & Pembangunan Lingkungan</td><td class="text-center">${persentase.dana_sosial || 0}%</td><td class="text-end font-monospace">${rupiahFormatter.format(alokasi.dana_sosial || 0)}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- DATA PER ANGGOTA -->
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col">
                            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-people-fill text-primary me-2"></i> Rincian Hak Penerimaan Per Anggota</h5>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-primary text-primary"><i class="bi bi-search"></i></span>
                                <input type="text" id="search-shu-anggota" class="form-control border-primary" placeholder="Cari Nama / ID Anggota...">
                            </div>
                        </div>
                    </div>

                    <div id="shu-anggota-wrapper" class="table-responsive"></div>
                `;

                    const inputSearch = document.getElementById('search-shu-anggota');
                    if (inputSearch) {
                        inputSearch.addEventListener('input', function() {
                            renderTabelShuAnggota(this.value, selectCabang.value);
                        });
                    }

                    renderTabelShuAnggota('', cabangId);
                })
                .catch(err => {
                    console.error(err);
                    btnProses.disabled = false;
                    btnProses.innerHTML = `<i class="bi bi-gear-fill me-2"></i> Proses SHU`;

                    container.innerHTML = `
                <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                    <div>
                        <strong>Proses Gagal Menerima Data!</strong><br>
                        Terjadi kendala teknis atau tidak ada rekam data pada cabang dan periode yang Anda pilih.
                    </div>
                </div>`;
                });
        }

        selectCabang.addEventListener('change', function() {
            const inputSearch = document.getElementById('search-shu-anggota');
            const keyword = inputSearch ? inputSearch.value : '';
            renderTabelShuAnggota(keyword, this.value);
        });

        function renderTabelShuAnggota(keyword, cabangFilterId) {
            const searchKeyword = keyword.toLowerCase().trim();
            const wrapper = document.getElementById('shu-anggota-wrapper');

            if (!wrapper) return;

            let htmlAnggota = `
            <table class="table table-striped table-bordered align-middle small table-hover m-0" style="width: 100%">
                <thead>
                    <tr class="table-dark text-center">
                        <th>No</th>
                        <th>ID Anggota</th>
                        <th>Nama Lengkap</th>
                        <th>Simpanan Rata²</th>
                        <th>Jasa Modal</th>
                        <th>Vol. Transaksi</th>
                        <th>Jasa Usaha</th>
                        <th>Total SHU</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>`;

            let no = 1;
            let grandJasaModal = 0;
            let grandJasaUsaha = 0;
            let grandTotalShu = 0;

            rawShuAnggota.forEach(item => {
                const namaAnggota = String(item.name || '').toLowerCase();
                const kodeAnggota = String(item.code || '').toLowerCase();
                const idCabangItem = String(item.cabang_id || '');

                const matchKeyword = searchKeyword === '' || namaAnggota.includes(searchKeyword) || kodeAnggota.includes(searchKeyword);
                const matchCabang = cabangFilterId === 'ALL' || idCabangItem === String(cabangFilterId);

                if (matchKeyword && matchCabang) {
                    const totalShu = Number(item.total_shu || 0);
                    grandJasaModal += Number(item.jasa_modal || 0);
                    grandJasaUsaha += Number(item.jasa_usaha || 0);
                    grandTotalShu += totalShu;

                    let btnCairkan = totalShu > 0 ?
                        `<button type="button" class="btn btn-xs btn-success fw-bold py-1 px-2 btn-buka-modal-cair"
                                   data-code="${escapeHtml(item.code)}"
                                   data-name="${escapeHtml(item.name)}"
                                   data-nominal="${totalShu}">
                               <i class="bi bi-cash-coin"></i> Cairkan
                           </button>` :
                        `<button type="button" class="btn btn-xs btn-secondary py-1 px-2 text-white small" disabled style="font-size:11px;">Nol</button>`;

                    htmlAnggota += `
                    <tr>
                        <td class="text-center text-muted">${no++}</td>
                        <td class="fw-semibold text-secondary text-center">${escapeHtml(item.code)}</td>
                        <td class="fw-bold text-dark">${escapeHtml(item.name)}</td>
                        <td class="text-end font-monospace">${rupiahFormatter.format(item.simpanan || 0)}</td>
                        <td class="text-end font-monospace text-success fw-semibold">${rupiahFormatter.format(item.jasa_modal || 0)}</td>
                        <td class="text-end font-monospace">${rupiahFormatter.format(item.transaksi || 0)}</td>
                        <td class="text-end font-monospace text-success fw-semibold">${rupiahFormatter.format(item.jasa_usaha || 0)}</td>
                        <td class="text-end font-monospace text-primary">${rupiahFormatter.format(totalShu)}</td>
                        <td class="text-center">${btnCairkan}</td>
                    </tr>`;
                }
            });

            if (no === 1) {
                htmlAnggota += `<tr><td colspan="9" class="text-center text-muted fst-italic py-4">Tidak ada data anggota yang sesuai dengan kriteria filter.</td></tr>`;
            } else {
                htmlAnggota += `
                <tr class="fw-bold table-secondary align-middle">
                    <td colspan="4" class="text-end text-uppercase pe-3 text-muted small">Total Ditanggung Anggota:</td>
                    <td class="text-end font-monospace text-success">${rupiahFormatter.format(grandJasaModal)}</td>
                    <td></td>
                    <td class="text-end font-monospace text-success">${rupiahFormatter.format(grandJasaUsaha)}</td>
                    <td colspan="2" class="text-end font-monospace table-primary text-primary">${rupiahFormatter.format(grandTotalShu)}</td>
                </tr>`;
            }

            htmlAnggota += `</tbody></table>`;
            wrapper.innerHTML = htmlAnggota;
        }

        // 1. EVENT DELEGATION: intercept klik tombol cairkan di dalam tabel
        container.addEventListener('click', function(e) {
            const targetBtn = e.target.closest('.btn-buka-modal-cair');
            if (!targetBtn) return;

            // Simpan data target ke object temporary global di Javascript
            dataPencairanAktif = {
                code: targetBtn.getAttribute('data-code'),
                name: targetBtn.getAttribute('data-name'),
                nominal: targetBtn.getAttribute('data-nominal')
            };

            // Pasang text dinamis di dalam modal body
            document.getElementById('modal-info-anggota').innerText = `${dataPencairanAktif.code} / ${dataPencairanAktif.name}`;
            document.getElementById('modal-info-nominal').innerText = rupiahFormatter.format(dataPencairanAktif.nominal);

            // Reset dropdown COA pilihan sebelumnya jika ada
            selectCoa.value = "";

            // Munculkan Modal
            bsModalCairkan.show();
        });

        // 2. SUBMIT EVENT: Eksekusi tombol "Proses Cairkan" yang ada di dalam modal
        if (btnSubmitCairkan) {
            btnSubmitCairkan.addEventListener('click', function() {
                const coaSelected = selectCoa.value;

                // Validasi pilihan akun COA
                if (!coaSelected) {
                    alert('Silakan pilih Akun Sumber Dana (COA) terlebih dahulu.');
                    selectCoa.focus();
                    return;
                }

                if (confirm(`Apakah Anda yakin ingin memproses pencairan SHU menggunakan akun COA: [${coaSelected}]?`)) {

                    // Kunci tombol modal agar tidak double-click/spam request
                    btnSubmitCairkan.disabled = true;
                    btnSubmitCairkan.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memproses...`;

                    fetch(`{{ route('laporan_koperasi_pembagian_shu_cairkan_shu') }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                anggota_code: dataPencairanAktif.code,
                                nominal: dataPencairanAktif.nominal,
                                coa_code: coaSelected, // Mengirim data COA terpilih ke backend
                                tgl_pencairan: new Date().toISOString().slice(0, 10)
                            })
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Gagal memproses ke server.');
                            return response.json();
                        })
                        .then(res => {
                            // Kembalikan status tombol
                            btnSubmitCairkan.disabled = false;
                            btnSubmitCairkan.innerHTML = `<i class="bi bi-check-circle me-1"></i> Proses Cairkan`;

                            if (res.status === 'success') {
                                alert(`Sukses! SHU Anggota ${dataPencairanAktif.name} berhasil dicairkan.\nNomor Jurnal Terbentuk: ${res.jurnal}`);
                                bsModalCairkan.hide(); // Tutup modal
                                prosesHitungSHU(); // Refresh kalkulasi/isi data tabel utama
                            } else {
                                alert('Gagal mencairkan: ' + res.message);
                            }
                        })
                        .catch(err => {
                            alert('Terjadi kesalahan sistem atau kendala jaringan backend.');
                            btnSubmitCairkan.disabled = false;
                            btnSubmitCairkan.innerHTML = `<i class="bi bi-check-circle me-1"></i> Proses Cairkan`;
                        });
                }
            });
        }

        function escapeHtml(str) {
            return String(str).replace(/[&<>"']/g, function(match) {
                const escapes = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#x27;'
                };
                return escapes[match];
            });
        }
    });
</script>
@endsection
