<div class="modal-body p-0">
    <div class="bg-warning rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Setup Cabang</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a>
        </p>
    </div>
    <div class="p-4 pb-3" id="menu-add-data-pr-all">
        @php
        $setup = DB::table('kop_setup_cabang_koperasi')->where('kop_setup_cabang_koperasi_cabang',$code)->first();
        @endphp
        @if ($setup)
        <form class="row g-3 pb-3" id="form-add-setup-baru" method="POST">
            @csrf
            <h5><span class="badge bg-primary">Jumlah Pinjaman</span></h5>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Barang Maksimal</label>
                <div class="input-group"> <span class="input-group-text"><i class="far fa-dot-circle"></i></span>
                    <input type="text" name="jp_brg_max" class="form-control form-control-lg border-start-0"
                        id="jp_brg_max" value="{{ $setup->kop_setup_cabang_koperasi_jp_brg }}">
                    <input type="text" name="code" value="{{ $code }}" hidden>
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Uang Maksimal</label>
                <div class="input-group"> <span class="input-group-text"><i class="far fa-dot-circle"></i></span>
                    <input type="text" name="jp_uang_max" class="form-control form-control-lg border-start-0"
                        id="jp_uang_max" value="{{ $setup->kop_setup_cabang_koperasi_jp_uang }}">
                </div>
            </div>
            <h5><span class="badge bg-primary">Tenor Pembayaran</span></h5>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Barang Maksimal</label>
                <div class="input-group"> <span class="input-group-text"><i class="far fa-dot-circle"></i></span>
                    <input type="text" name="tenor_brg_max" class="form-control form-control-lg border-start-0"
                        id="whatsapp" value="{{ $setup->kop_setup_cabang_koperasi_tenor_brg }}">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Uang Maksimal</label>
                <div class="input-group"> <span class="input-group-text"><i class="far fa-dot-circle"></i></span>
                    <input type="text" name="tenor_uang_max" class="form-control form-control-lg border-start-0"
                        id="tenor_uang_max" value="{{ $setup->kop_setup_cabang_koperasi_tenor_uang }}">
                </div>
            </div>
            <h5><span class="badge bg-primary">Bunga Angsuran</span></h5>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Bunga Bulanan</label>
                <div class="input-group"> <span class="input-group-text"><i class="far fa-dot-circle"></i></span>
                    <input type="text" name="bunga_angsuran" class="form-control form-control-lg border-start-0"
                        id="bunga_angsuran" value="{{ $setup->kop_setup_cabang_koperasi_bunga }}">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Biaya Admin</label>
                <div class="input-group"> <span class="input-group-text"><i class="far fa-dot-circle"></i></span>
                    <input type="text" name="bunga_admin" class="form-control form-control-lg border-start-0"
                        id="bunga_admin" value="{{ $setup->kop_setup_cabang_koperasi_admin }}">
                </div>
            </div>
            <h5><span class="badge bg-primary">Metode Verifikasi</span></h5>
            <div class="col-md-6">
                <label class="form-check-label align-top" for="customCheck1">Whatsapp</label>
                <select name="metode_whatsapp" id="" class="form-control form-control-lg">
                    @if ($setup->kop_setup_cabang_koperasi_wa == '0')
                    <option value="0">Tidak</option>
                    <option value="1">Ya</option>
                    @else
                    <option value="1">Ya</option>
                    <option value="0">Tidak</option>
                    @endif
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-check-label align-top" for="customCheck2">Email</label>
                <select name="metode_email" id="" class="form-control form-control-lg">
                    @if ($setup->kop_setup_cabang_koperasi_email == '0')
                    <option value="0">Tidak</option>
                    <option value="1">Ya</option>
                    @else
                    <option value="1">Ya</option>
                    <option value="0">Tidak</option>
                    @endif
                </select>
            </div>
        </form>
        @else
        <form class="row g-3 pb-3" id="form-add-setup-baru" method="POST">
            @csrf
            <h5><span class="badge bg-primary">Jumlah Pinjaman</span></h5>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Barang Maksimal</label>
                <div class="input-group"> <span class="input-group-text"><i class="far fa-dot-circle"></i></span>
                    <input type="text" name="jp_brg_max" class="form-control form-control-lg border-start-0"
                        id="jp_brg_max" placeholder="Ex. Kepala">
                    <input type="text" name="code" value="{{ $code }}" hidden>
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Uang Maksimal</label>
                <div class="input-group"> <span class="input-group-text"><i class="far fa-dot-circle"></i></span>
                    <input type="text" name="jp_uang_max" class="form-control form-control-lg border-start-0"
                        id="jp_uang_max" placeholder="Ex@gmail.com">
                </div>
            </div>
            <h5><span class="badge bg-primary">Tenor Pembayaran</span></h5>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Barang Maksimal</label>
                <div class="input-group"> <span class="input-group-text"><i class="far fa-dot-circle"></i></span>
                    <input type="text" name="tenor_brg_max" class="form-control form-control-lg border-start-0"
                        id="whatsapp" placeholder="Ex. 089XXXXXXX">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Uang Maksimal</label>
                <div class="input-group"> <span class="input-group-text"><i class="far fa-dot-circle"></i></span>
                    <input type="text" name="tenor_uang_max" class="form-control form-control-lg border-start-0"
                        id="tenor_uang_max" placeholder="Ex. 089XXXXXXX">
                </div>
            </div>
            <h5><span class="badge bg-primary">Bunga Angsuran</span></h5>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Bunga Bulanan</label>
                <div class="input-group"> <span class="input-group-text"><i class="far fa-dot-circle"></i></span>
                    <input type="text" name="bunga_angsuran" class="form-control form-control-lg border-start-0"
                        id="bunga_angsuran" placeholder="Ex. 089XXXXXXX">
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName1" class="form-label">Biaya Admin</label>
                <div class="input-group"> <span class="input-group-text"><i class="far fa-dot-circle"></i></span>
                    <input type="text" name="bunga_admin" class="form-control form-control-lg border-start-0"
                        id="bunga_admin" placeholder="Ex. 089XXXXXXX">
                </div>
            </div>
            <h6 class="fs-0">Metode Verifikasi :</h6>
            <div class="col-md-6">
                <label class="form-check-label align-top" for="customCheck1">Whatsapp</label>
                <select name="metode_whatsapp" id="" class="form-control form-control-lg">
                    <option value="0">Tidak</option>
                    <option value="1">Ya</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-check-label align-top" for="customCheck2">Email</label>
                <select name="metode_email" id="" class="form-control form-control-lg">
                    <option value="0">Tidak</option>
                    <option value="1">Ya</option>
                </select>
            </div>

        </form>
        @endif
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <span id="menu-add-data-setup">
        <button class="btn btn-success float-end" id="button-simpan-data-setup" data-code="">Simpan
            Data</button>
    </span>
</div>
