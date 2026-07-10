<div class="card mb-3">
    <div class="card-header bg-300">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor" id="form-grid-layout">Form Peminjaman Barang Koperasi<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#form-grid-layout" style="padding-left: 0.375em;"></a></h5>
                <p class="mb-0 mt-2 mb-0">More complex layouts can also be created with the grid system.</p>
            </div>
            <div class="col-auto ms-auto">

            </div>
        </div>
    </div>
    <div class="card-body bg-light" id="menu-form-peminjaman-uang">
        <form class="row g-3 pb-3" id="form-peserta-baru" method="POST">
            @csrf
            <div class="col-md-2 d-flex justify-content-center">
                <div class="avatar avatar-5xl shadow-sm img-thumbnail rounded-circle justify-content-center">
                    <div class="h-100 w-100 rounded-circle overflow-hidden">
                        <img src="{{ asset('asset/img/team/avatar.png') }}" width="200" alt="" id="videoPreview"
                            data-dz-thumbnail="data-dz-thumbnail">
                        <input class="d-none" id="profile-image" type="file">
                        <label class="mb-0 overlay-icon d-flex flex-center" for="profile-image">
                            <span class="bg-holder overlay overlay-0"></span>
                            <span class="z-index-1 text-white dark__text-white text-center fs--1">
                                <span class="d-block">Upload</span></span></label>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text"><i
                                    class="fas fa-user-friends"></i></span>
                            <input type="text" name="nama_lengkap" class="form-control form-control-lg border-start-2"
                                id="nama_lengkap" value="{{ $data->kop_master_peserta_name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label">Jenis Kelamin</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-transgender fs-2"></i></span>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control form-control-lg single-select">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="l">Laki Laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label">NIK</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="nik" class="form-control form-control-lg border-start-2" value="{{ $data->kop_master_peserta_nik }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputLastName1" class="form-label">NIP</label>
                        <div class="input-group"> <span class="input-group-text"><i
                                    class="fas fa-money-check"></i></span>
                            <input type="text" name="nip" class="form-control form-control-lg border-start-2" value="{{ $data->kop_master_peserta_nip }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label">Tanggal Lahir</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                    <input type="date" name="tgl_lahir" class="form-control form-control-lg border-start-2" value="{{ $data->kop_master_peserta_tgl_lahir }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label">Tempat Lahir</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    <input type="text" name="tempat_lahir" class="form-control form-control-lg border-start-2" value="{{ $data->kop_master_peserta_tempat_lahir }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputEmailAddress" class="form-label">Agama</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-pray"></i></span>
                    <input type="email" name="email" class="form-control form-control-lg border-start-2" value="{{ $data->kop_master_peserta_agama }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName2" class="form-label">No Handphone</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-phone-square-alt"></i></span>
                    <input type="text" name="no_hp" class="form-control form-control-lg border-start-2" value="{{ $data->kop_master_peserta_no_hp }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName2" class="form-label">Email</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-mail-bulk"></i></span>
                    <input type="email" name="email" class="form-control form-control-lg border-start-2" value="{{ $data->kop_master_peserta_email }}" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <label for="inputLastName1" class="form-label">Cabang</label>
                <div class="input-group"> <span class="input-group-text"><i class="fas fa-place-of-worship"></i></span>
                    <input type="email" name="email" class="form-control form-control-lg border-start-2" value="{{ $data->kop_master_cabang_name }}" readonly>
                </div>
            </div>


            <div class="col-12">
                <label for="inputAddress3" class="form-label">Deskripsi Alamat</label>
                <textarea class="form-control" name="alamat" id="inputAddress3" readonly
                    rows="3">{{ $data->kop_master_peserta_alamat }}</textarea>
            </div>
            <input id="link" type="text" name="link" class="form-control" hidden>
        </form>
    </div>
</div>
<form class="row g-3 mb-3" id="form-pengajuan-peminjaman-uang" method="POST">
    @csrf
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header bg-300">
                <h5 class="mb-0">Data Peminjaman</h5>
            </div>
            <div class="card-body bg-light">

                <p class="fs--1 mb-2"><span class="badge bg-primary">Pinjaman Baru</span></p>

                <div class="row gx-3">
                    <div class="col-7">
                        <label for="inputAddress3" class="form-label">Keperluan Peminjaman / Deskripsi Barang</label>
                        <textarea class="form-control" name="keperluan" id="inputAddress3" rows="3" required></textarea>
                    </div>
                    <div class="col-5">
                        <label for="inputAddress3" class="form-label">Upload file Pendukung</label>
                        <input type="file" class="form-control" name="" id="">
                    </div>
                    <div class="col-7">
                        <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1" for="cardNumber">Nominal Peminjaman <strong class="text-danger">Maksimal Peminjaman @currency($data->kop_setup_cabang_koperasi_jp_brg)</strong></label>
                        <input class="form-control" name="nominal_pinjam" id="plafon" placeholder="Contoh: 10000000" oninput="handleInput(this)" type="text">
                        <input type="text" name="peserta_koperasi" id="peserta_koperasi" value="{{ $data->kop_master_peserta_code }}" hidden>
                    </div>
                    <div class="col-5 col-sm-5">
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
                        <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1" for="zipCode">Angsuran Pokok (Bulan 1)</label>
                        <input class="form-control" id="hasilPokok" placeholder="@currency(100000)" type="text" readonly>
                    </div>
                    <div class="col-6 col-sm-4">
                        <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1" for="zipCode">Biaya Admin</label>
                        <input class="form-control" id="BiayaAdmin" placeholder="@currency(100000)" type="text" readonly>
                    </div>

                    <div class="col-6 col-sm-4">
                        <label class="form-label ls text-uppercase text-600 fw-semi-bold mb-0 fs--1" for="expDate">Total Angsuran Per Bulan</label>
                        <input class="form-control" id="hasilTotal" readonly placeholder="Rp 0" style="font-weight: bold; color: #27ae60;">
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
                        <label class="form-label ls text-uppercase text-primary fw-semi-bold mb-0 fs--1" for="expDate">Jumlah Total Angsuran</label>
                        <input class="form-control" id="hasilTotalAngsuran" readonly placeholder="Rp 0" style="font-weight: bold; color: #27ae60;">
                    </div>
                </div>
                <label for="">Kepala Cabang</label>
                <select name="kepala_cabang" id="kepala_cabang" class="form-select">
                    <option value="">Pilih Kepala Cabang</option>
                    @foreach ($kcb as $kacab)
                    <option value="{{ $kacab->kop_user_verifikasi_code }}">{{ $kacab->kop_user_verifikasi_name }}</option>
                    @endforeach
                </select>

                <label for="">Ketua Koperasi</label>
                <select name="ketua_koperasi" id="ketua_koperasi" class="form-select">
                    <option value="">Pilih Ketua Koperasi</option>
                    @foreach ($mgr as $mgrs)
                    <option value="{{ $mgrs->kop_user_verifikasi_code }}">{{ $mgrs->kop_user_verifikasi_name }}</option>
                    @endforeach
                </select>
                <hr>

                <div id="loading-button-proses">
                    <button class="btn btn-primary d-block w-100" type="button" id="button-proses-pengajuan-peminjaman">Pengajuan Peminjaman</button>
                </div>
                <div class="text-center mt-2"><small class="d-inline-block">By continuing, you are agreeing to our subscriber <a href="#!">terms</a> and will be charged at the end of the trial. </small></div>
            </div>
        </div>
    </div>
</form>
<script>
    function formatRupiah(angka, prefix) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
    }

    function handleInput(e) {
        e.value = formatRupiah(e.value, 'Rp ');
        const nilai = document.getElementById('plafon').value.replace(/[^0-9]/g, '');
        if (nilai >= <?php echo $data->kop_setup_cabang_koperasi_jp_brg ?>) {
            document.getElementById('plafon').value = "";
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Peminjaman Lebih dari batas pinjaman",
                footer: "<a href=\"#\">Why do I have this issue?</a>"
            });
        }
        hitungOtomatis();
    }

    function hitungOtomatis() {
        const plafonRaw = document.getElementById('plafon').value.replace(/[^0-9]/g, '');
        const P = parseFloat(plafonRaw);
        const n = parseFloat(document.getElementById('tenor').value);
        const bungaTahun = parseFloat(document.getElementById('bunga').value);
        const bungaAdmin = parseFloat(document.getElementById('bunga_pinjam').value);
        const r = (bungaTahun / 100) / 12; // Bunga per bulan

        if (P > 0 && n > 0 && bungaTahun > 0) {
            // 1. Hitung Total Angsuran (Anuitas)
            // const totalAngsuran = P * (r / (1 - Math.pow(1 + r, -n)));
            const totalAngsuran = (P * (bungaTahun / 100) / n);


            // 2. Hitung Bunga Bulan Pertama
            const bungaBulanPertama = (P * (bungaTahun / 100)) / 12;

            // 3. Hitung Angsuran Pokok Bulan Pertama (Total - Bunga)
            const pokokBulanPertama = P / n;

            // 4. Hitung Biaya Admin
            const BiayaAdmins = (bungaAdmin / 100) * P;
            //
            const TotalAngsuran = totalAngsuran + pokokBulanPertama;
            // 4. Hitung Total
            const hasilTotalAngsuran = (TotalAngsuran * n) + BiayaAdmins;

            // Tampilkan Hasil
            document.getElementById('hasilTotal').value = formatRupiah(Math.round(TotalAngsuran).toString(), 'Rp ');
            document.getElementById('hasilPokok').value = formatRupiah(Math.round(pokokBulanPertama).toString(), 'Rp ');
            document.getElementById('BiayaAdmin').value = formatRupiah(Math.round(BiayaAdmins).toString(), 'Rp ');
            document.getElementById('hasilTotalAngsuran').value = formatRupiah(Math.round(hasilTotalAngsuran).toString(), 'Rp ');
        } else {
            document.getElementById('hasilTotal').value = "";
            document.getElementById('hasilPokok').value = "";
            document.getElementById('BiayaAdmin').value = "";
            document.getElementById('hasilTotalAngsuran').value = "";
        }
    }
</script>
