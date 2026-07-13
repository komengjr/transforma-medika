<form class="row g-3 mb-3" id="form-pengajuan-peminjaman-uang" method="POST">
    @csrf
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header bg-300">
                <h5 class="mb-0">Data Pengajuan Peminjaman Baru</h5>
            </div>
            <div class="card-body bg-light">
                <p class="fs--1 mb-2"><span class="badge bg-primary">Pinjaman Baru</span></p>

                <div class="row gx-3">
                    <div class="col-12">
                        <label for="inputAddress3" class="form-label">Keperluan Peminjaman</label>
                        <textarea class="form-control" name="keperluan" id="inputAddress3" rows="3" required></textarea>
                        <input type="text" name="kode_peminjaman" id="" value="{{ $code }}" hidden>
                        <input type="text" name="nominal_tagihan" id="" value="{{ $sisa }}" hidden>
                    </div>
                    <div class="col-8">
                        <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1" for="cardNumber">Nominal Peminjaman <strong class="text-danger">Maksimal Peminjaman @currency($data->kop_setup_cabang_koperasi_jp_uang)</strong></label>
                        <input class="form-control" name="nominal_pinjam" id="plafon" placeholder="Contoh: 10000000" oninput="handleInput(this)" type="text">
                        <input type="text" name="peserta_koperasi" id="peserta_koperasi" value="{{ $data->kop_master_peserta_code }}" hidden>
                    </div>
                    <div class="col-4 col-sm-4">
                        <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1" for="inputCountry">Tanggal Peminjaman</label>
                        <input class="form-control" name="tgl_pinjam" id="tgl_pinjam" placeholder="1234" type="date">
                    </div>
                    <div class="col-6 col-sm-6">
                        <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1" for="inputCountry">Lama Peminjaman</label>
                        <select class="form-select mb-3" name="tenor" id="tenor" placeholder="Contoh: 12" onclick="hitungOtomatis()">
                            <option value="">Pilih Bulan</option>
                            @for ($i = $data->kop_setup_cabang_koperasi_tenor_uang ; $i > 0 ; $i--)
                            <option value="{{ $i }}">{{ $i }} Bulan</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-6 col-sm-3">
                        <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1" for="expDate">Bunga / Bulan %</label>
                        <input class="form-control" type="number" name="bunga_pinjam" id="bunga" oninput="hitungOtomatis()" value="{{ $data->kop_setup_cabang_koperasi_bunga }}" readonly>
                    </div>
                    <div class="col-6 col-sm-3">
                        <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1" for="expDate">Biaya Admin %</label>
                        <input class="form-control" type="number" name="biaya_admin" id="bunga_pinjam" oninput="hitungOtomatis()" value="{{ $data->kop_setup_cabang_koperasi_admin }}" readonly>
                    </div>
                    <div class="col-6 col-sm-4">
                        <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1" for="zipCode">Biaya Bunga</label>
                        <input class="form-control angsuran-pokok" id="biaya-bunga" placeholder="@currency(100000)" type="text" readonly>
                    </div>
                    <div class="col-6 col-sm-4">
                        <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1" for="zipCode">Biaya Admin</label>
                        <input class="form-control biaya-admin" id="biaya-admin" placeholder="@currency(100000)" type="text" readonly>
                    </div>

                    <div class="col-6 col-sm-4">
                        <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1" for="expDate">Total Angsuran Per Bulan</label>
                        <input class="form-control total-angsuran" id="total-angsuran" readonly placeholder="Rp 0" style="font-weight: bold; color: #27ae60;">
                    </div>

                </div>
                <!-- <p class="fs--1 mb-2 mt-3"><span class="badge bg-primary">Pinjaman Sebelumnya</span></p>
                <p>Belum Ada Meminjam</p> -->
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-300">
                <h5 class="mb-0">Mengetahui</h5>
            </div>
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <label class="form-label ls text-uppercase text-primary fw-semi-bold mb-0 fs--1" for="expDate">Jumlah Total</label>
                        <input class="form-control jumlah-total" id="jumlah-total" readonly placeholder="Rp 0" style="font-weight: bold; color: #27ae60;">
                    </div>
                    <div class="col-12 col-sm-12">
                        <label class="form-label ls text-uppercase text-primary fw-semi-bold mb-0 fs--1" for="expDate">Potongan Angsuran Sebelumnya</label>
                        <input class="form-control" id="hasilTotalAngsuran" readonly value="@currency($sisa)" style="font-weight: bold; color: #ae4b27;">
                    </div>
                    <div class="col-12 col-sm-12">
                        <label class="form-label ls text-uppercase text-primary fw-semi-bold mb-0 fs--1" for="expDate">Jumlah Total Yang diterima</label>
                        <input class="form-control total-diterima" id="hasilTotalAngsuran" readonly placeholder="Rp 0" style="font-weight: bold; color: #27ae60;">
                    </div>
                </div>
                <!-- <label for="">Kepala Cabang</label>
                <select name="kepala_cabang" id="kepala_cabang" class="form-select">
                    <option value="">Pilih Kepala Cabang</option>

                </select>

                <label for="">Ketua Koperasi</label>
                <select name="ketua_koperasi" id="ketua_koperasi" class="form-select">
                    <option value="">Pilih Ketua Koperasi</option>

                </select> -->
                <hr>
                <div class="row mb-2">
                    <div class="col-12">
                        <label for="">Pilih Akun Pencairan</label>
                        <select class="form-control form-control-lg" name="akun" id="akun">
                            <option value="">Pilih Akun</option>
                            @foreach ($akun as $akuns)
                                <option value="{{$akuns->coa_code}}">{{$akuns->coa_code}} - {{$akuns->coa_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="loading-button-proses">
                    <button class="btn btn-primary d-block w-100" type="button" id="button-save-proses-pengajuan-peminjaman-baru">Proses Peminjaman Baru</button>
                </div>
                <div class="text-center mt-2"><small class="d-inline-block">By continuing, you are agreeing to our subscriber <a href="#!">terms</a> and will be charged at the end of the trial. </small></div>
            </div>
        </div>
    </div>
</form>
<script>
    // Fungsi pembersih format mata uang (mengubah Rp 10.000 menjadi angka biasa 10000)
    function cleanCurrency(value) {
        return parseFloat(value.replace(/[^0-9,-]/g, '').replace(',', '.')) || 0;
    }

    // Fungsi format angka menjadi format mata uang Rupiah
    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(angka));
    }

    // 1. Fungsi handleInput untuk input nominal #plafon
    function handleInput(element) {
        let value = element.value.replace(/[^0-9]/g, '');
        if (value) {
            element.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            element.value = '';
        }
        hitungOtomatis();
    }

    // 2. Fungsi Utama Perhitungan
    function hitungOtomatis() {
        // Ambil element input berdasarkan ID tepat sesuai HTML baru Anda
        const inputPlafon = document.getElementById('plafon');
        const selectTenor = document.getElementById('tenor');
        const inputBunga = document.getElementById('bunga');
        const inputAdminPersen = document.getElementById('bunga_pinjam'); // Atribut ID di HTML Anda
        const inputPotongan = document.getElementById('hasilTotalAngsuran');

        // Ambil element output berdasarkan ID / Class terbaru Anda
        const outputBiayaBunga = document.getElementById('biaya-bunga'); // Sudah disesuaikan ke ID baru
        const outputAdminRupiah = document.getElementById('biaya-admin');
        const outputTotalAngsuran = document.getElementById('total-angsuran');
        const outputJumlahTotal = document.getElementById('jumlah-total');
        const outputTotalDiterima = document.querySelector('.total-diterima');

        // Konversi nilai input menjadi tipe data angka jika ada
        const nominalPinjam = cleanCurrency(inputPlafon.value);
        const tenor = parseInt(selectTenor.value) || 0;
        const bungaPersen = parseFloat(inputBunga.value) || 0;
        const adminPersen = parseFloat(inputAdminPersen.value) || 0;
        const potonganSebelumnya = cleanCurrency(inputPotongan.value);

        // Jika nominal atau tenor kosong, kosongkan tampilan (set ke Rp 0)
        if (nominalPinjam === 0 || tenor === 0) {
            outputBiayaBunga.value = formatRupiah(0);
            outputAdminRupiah.value = formatRupiah(0);
            outputTotalAngsuran.value = formatRupiah(0);
            outputJumlahTotal.value = formatRupiah(0);
            outputTotalDiterima.value = formatRupiah(0);
            return;
        }

        // --- LOGIKA RUMUS SESUAI REQUEST ---

        // 1. Hitung Angsuran Pokok Murni per Bulan
        const pokokPerBulan = nominalPinjam / tenor;

        // 2. Hitung Biaya Bunga Per Bulan: (Nominal / Tenor) lalu dibungakan %
        const totalBiayaBungaPerBulan = pokokPerBulan * (bungaPersen / 100);

        // 3. Biaya Admin Rupiah (Nominal Pinjam * Persen Admin)
        const biayaAdminRupiah = nominalPinjam * (adminPersen / 100);

        // 4. Total Angsuran Per Bulan (Pokok Murni + Biaya Bunga Per Bulan)
        const totalAngsuranPerBulan = pokokPerBulan + totalBiayaBungaPerBulan;

        // 5. Jumlah Total Pinjaman (Nominal Pinjam + Seluruh Akumulasi Bunga)
        const jumlahTotal = nominalPinjam + (totalBiayaBungaPerBulan * tenor);

        // 6. Jumlah Total yang Diterima (Jumlah Total Pinjaman - Potongan Pinjaman Lama)
        let totalDiterima = jumlahTotal - potonganSebelumnya;
        if (totalDiterima < 0) totalDiterima = 0; // Kunci agar tidak bernilai minus

        // --- TAMPILKAN HASIL KE INPUT FORM ---
        outputBiayaBunga.value = formatRupiah(totalBiayaBungaPerBulan);
        outputAdminRupiah.value = formatRupiah(biayaAdminRupiah);
        outputTotalAngsuran.value = formatRupiah(totalAngsuranPerBulan);
        outputJumlahTotal.value = formatRupiah(jumlahTotal);
        outputTotalDiterima.value = formatRupiah(totalDiterima);
    }

    // 3. Event Listener untuk melengkapi deteksi perubahan tanggal pinjam
    document.getElementById('tgl_pinjam').addEventListener('change', hitungOtomatis);
</script>
