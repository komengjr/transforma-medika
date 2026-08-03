<style>
    /* Custom Scrollbar untuk Ringkasan */
    .custom-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .custom-scroll::-webkit-scrollbar-dash,
    .custom-scroll::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }

    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: #0d6efd;
    }

    /* Item Card E-Commerce Style */
    .cart-item {
        transition: all 0.2s ease-in-out;
        border-left: 4px solid transparent;
    }

    .cart-item:hover {
        background-color: #f8f9fa;
        border-left-color: #0d6efd;
    }

    .style-micro {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .border-dashed {
        border-style: dashed !important;
    }
</style>
<!-- HEADER LABORATORIUM -->
<div class="card bg-light shadow-none border mb-3">
    <div class="card-body p-3 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <div class="avatar avatar-xl me-3 bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center">
                <i class="fas fa-flask fa-lg"></i>
            </div>
            <div>
                <h4 class="mb-0 text-primary fw-bold">PELAYANAN LABORATORIUM</h4>
                <p class="text-600 mb-0 small">Pilih tanggal, dokter rujukan, dan paket pemeriksaan pasien</p>
            </div>
        </div>
        <div>
            <span class="badge bg-soft-info text-info"><i class="fas fa-info-circle me-1"></i> Form Input Registrasi</span>
        </div>
    </div>
</div>

<!-- FORM TANGGAL & DOKTER RUJUKAN -->
<div class="card shadow-sm border mb-3">
    <div class="card-body p-3">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="tgl_pemeriksaan" class="form-label fw-bold text-dark">Tanggal Pemeriksaan <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-primary"><i class="far fa-calendar-alt"></i></span>
                    <input type="date" name="tanggal_periksa" id="tgl_pemeriksaan" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                    <label for="rujukan" class="form-label fw-bold">Dokter Rujukan <span class="text-danger">*</span></label>
                    <select name="rujukan" id="rujukan" class="form-select choices-single-master" required>
                        <option value=""></option> <!-- Dibiarkan kosong untuk placeholder Select2 -->
                        @foreach ($dokter as $dok)
                        <option value="{{ $dok->master_doctor_code }}">{{ $dok->master_doctor_name }}</option>
                        @endforeach
                    </select>

            </div>
        </div>
    </div>
</div>

<!-- ALUR PEMILIHAN PAKET & SUMMARY -->
<div class="row g-3">
    <!-- PANEL KIRI: STEP-BY-STEP SELECTION -->
    <div class="col-xl-7">

        <div class="row g-3">
            <div class="col-md-6">
                <!-- STEP 1: MASTER AGREEMENT (p_m_sales) - Sembunyikan Secara Default -->
                <div class="card border shadow-sm mb-3" id="card-step-master" style="display: none;">
                    <div class="card-header bg-light py-2">
                        <h6 class="mb-0 text-800 fw-bold"><span class="badge bg-primary me-2">1</span> Master Agreement</h6>
                    </div>
                    <div class="card-body p-3">
                        <select name="pilih_m_sales" class="form-select choices-single-master" id="pilih_m_sales">
                            <option value="">-- Pilih Master Agreement --</option>
                            @foreach ($masterSales as $ms)
                            <option value="{{ $ms->p_m_sales_code }}">{{ $ms->p_m_sales_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- STEP 2: SUB MASTER SALES (p_sales) -->
                <div class="card border shadow-sm mb-3" id="card-step-sub" style="display: none;">
                    <div class="card-header bg-light py-2">
                        <h6 class="mb-0 text-800 fw-bold"><span class="badge bg-secondary me-2">2</span> Sub Master Sales</h6>
                    </div>
                    <div class="card-body p-3">
                        <div id="container-sub-sales" class="row g-2"></div>
                    </div>
                </div>
            </div>
        </div>


        <!-- STEP 3: PAKET PEMERIKSAAN (p_sales_cat) -->
        <div class="card border shadow-sm mb-3" id="card-step-paket" style="display: none;">
            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-800 fw-bold"><span class="badge bg-info me-2">3</span> Pilih Paket / Kategori</h6>
                <small class="text-muted" id="label-sub-terpilih"></small>
            </div>
            <div class="card-body p-3">
                <div id="container-paket" class="row g-2"></div>
            </div>
        </div>

        <!-- STEP 4: ITEM PEMERIKSAAN (p_sales_data) -->
        <div class="card border shadow-sm mb-3" id="card-step-pemeriksaan" style="display: none;">
            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-800 fw-bold"><span class="badge bg-success me-2">4</span> Pilih Item Pemeriksaan</h6>
                <input type="text" id="search-pemeriksaan" class="form-control form-control-sm w-50" placeholder="🔍 Cari nama pemeriksaan...">
            </div>
            <div class="card-body p-0">
                <div class="table-responsive scrollbar" style="max-height: 320px;">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="bg-200 sticky-top">
                            <tr>
                                <th width="10%" class="text-center">Pilih</th>
                                <th>Nama Pemeriksaan</th>
                                <th class="text-end pe-3">Harga</th>
                            </tr>
                        </thead>
                        <tbody id="container-pemeriksaan-body"></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- PANEL KANAN: RINGKASAN ORDER / CART -->
    <div class="col-xl-5">
        <!-- Card Ringkasan Pemeriksaan Style E-Commerce -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <!-- Header Ringkasan -->
            <div class="card-header bg-gradient-primary text-white py-3 px-4 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-shopping-bag fs-2"></i>
                    <h6 class="mb-0 fw-bold text-uppercase tracking-wider text-white">Ringkasan Pemeriksaan</h6>
                </div>
                <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-bold" id="cart-badge-count">
                    0 Item
                </span>
            </div>

            <!-- Body / List Item Pemeriksaan -->
            <div class="card-body p-0">
                <div id="cart-items-container" class="custom-scroll" style="max-height: 380px; overflow-y: auto;">
                    <!-- State Saat Keranjang Kosong -->
                    <div id="cart-empty-state" class="text-center py-5 px-3">
                        <div class="avatar-lg mx-auto mb-3 text-muted opacity-50">
                            <i class="bi bi-cart-x display-4"></i>
                        </div>
                        <h6 class="fw-semibold text-secondary mb-1">Keranjang Masih Kosong</h6>
                        <p class="text-muted small mb-0">Pilih item pemeriksaan di sebelah kiri untuk ditambahkan.</p>
                    </div>

                    <!-- Tempat Item Keranjang Dirender oleh JS -->
                    <ul class="list-group list-group-flush" id="cart-list"></ul>
                </div>
            </div>

            <!-- Footer / Rincian Pembayaran & Total -->
            <div class="card-footer bg-light p-4 border-top">
                <div class="d-flex justify-content-between align-items-center mb-2 text-muted small">
                    <span>Subtotal Pemeriksaan</span>
                    <span class="fw-semibold" id="cart-subtotal">Rp 0</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 text-muted small">
                    <span>Diskon / Potongan</span>
                    <span class="text-danger fw-semibold" id="cart-discount">- Rp 0</span>
                </div>

                <hr class="my-3 border-dashed">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="d-block text-uppercase fw-bold text-muted style-micro">Total Pembayaran</span>
                        <h4 class="fw-bold text-primary mb-0" id="cart-grand-total">Rp 0</h4>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill small">
                        <i class="bi bi-shield-check me-1"></i> Siap Disimpan
                    </span>
                </div>

                <!-- Tombol Action Utama -->
                <button type="button" id="button-fix-registrasi-lab" class="btn btn-primary btn-lg w-100 rounded-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 py-3" disabled>
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <span>PROSES REGISTRASI LAB</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT LOGIC -->
<script>

    new window.Choices(document.querySelector(".choices-single-master"));

    var cartItems = [];

    function checkHeaderSelection() {
        var tgl = $('#tgl_pemeriksaan').val();
        var dokter = $('#rujukan').val();

        if (tgl !== '' && dokter !== '') {
            // Tampilkan Master Agreement jika kedua field sudah diisi
            $('#card-step-master').slideDown();
        } else {
            // Sembunyikan seluruh step di bawahnya jika salah satu kosong
            $('#card-step-master, #card-step-sub, #card-step-paket, #card-step-pemeriksaan').slideUp();

            // Reset nilai pilihan & cart
            $('#pilih_m_sales').val('').trigger('change');
            cartItems = [];
            renderCart();
        }
    }

    // Event saat Tanggal Pemeriksaan diubah
    $('#tgl_pemeriksaan').on('change', function() {
        checkHeaderSelection();
    });

    // Event saat Dokter Rujukan diubah
    $('#rujukan').on('change', function() {
        checkHeaderSelection();
    });

    // STEP 1: MASTER SALES (p_m_sales) CHANGED
    $('#pilih_m_sales').on("change", function() {
        var mSalesCode = $(this).val();
        var tgl = $('#tgl_pemeriksaan').val();


        if (mSalesCode) {
            $('#card-step-sub').slideDown();
            $('#card-step-paket, #card-step-pemeriksaan').slideUp();
            $("#container-sub-sales").html('<div class="col-12 text-center py-2 text-muted"><i class="fas fa-spinner fa-spin me-2"></i>Memuat Sub Master Sales...</div>');

            $.ajax({
                url: "{{ route('lab.get_sub_sales') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "m_sales_code": mSalesCode
                },
            }).done(function(res) {
                if (res.status === 'success') {
                    let html = '';
                    res.data.forEach(item => {
                        html += `
                        <div class="col-md-6">
                            <button type="button" class="btn btn-outline-primary btn-sm w-100 text-start btn-sub-sales fw-semi-bold p-2" data-code="${item.p_sales_code}" data-nama="${item.p_sales_name}">
                                <i class="fas fa-folder me-2"></i>${item.p_sales_name}
                            </button>
                        </div>`;
                    });
                    $("#container-sub-sales").html(html);
                } else {
                    $("#container-sub-sales").html(res.html);
                }
            });
        } else {
            $('#card-step-sub, #card-step-paket, #card-step-pemeriksaan').slideUp();
        }
    });

    // STEP 2: SUB SALES (p_sales) CLICKED
    $(document).on("click", ".btn-sub-sales", function() {
        $(".btn-sub-sales").removeClass("btn-primary text-white").addClass("btn-outline-primary");
        $(this).removeClass("btn-outline-primary").addClass("btn-primary text-white");

        var salesCode = $(this).data('code');
        var salesName = $(this).data('nama');

        $('#label-sub-terpilih').text('Group: ' + salesName);
        $('#card-step-paket').slideDown();
        $('#card-step-pemeriksaan').slideUp();
        $("#container-paket").html('<div class="col-12 text-center py-2 text-muted"><i class="fas fa-spinner fa-spin me-2"></i>Memuat Paket...</div>');

        $.ajax({
            url: "{{ route('lab.get_categories') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "sales_code": salesCode
            },
        }).done(function(res) {
            if (res.status === 'success') {
                let html = '';
                res.data.forEach(cat => {
                    html += `
                    <div class="col-md-6">
                        <button type="button" class="btn btn-outline-info btn-sm w-100 text-start btn-paket-cat fw-semi-bold p-2" data-code="${cat.p_sales_cat_code}" data-nama="${cat.p_sales_cat_name}">
                            <i class="fas fa-vials me-2"></i>${cat.p_sales_cat_name}
                        </button>
                    </div>`;
                });
                $("#container-paket").html(html);
            } else {
                $("#container-paket").html(res.html);
            }
        });
    });

    // STEP 3: PAKET (p_sales_cat) CLICKED
    $(document).on("click", ".btn-paket-cat", function() {
        $(".btn-paket-cat").removeClass("btn-info text-white").addClass("btn-outline-info");
        $(this).removeClass("btn-outline-info").addClass("btn-info text-white");

        var catCode = $(this).data('code');

        // =========================================================
        // FITUR RESET CART SAAT PILIH PAKET LAIN
        // =========================================================
        cartItems = []; // Kosongkan array cart
        renderCart(); // Render ulang tampilan cart (reset total harga & item)
        // =========================================================

        $('#card-step-pemeriksaan').slideDown();
        $("#container-pemeriksaan-body").html('<tr><td colspan="3" class="text-center py-3 text-muted"><i class="fas fa-spinner fa-spin me-2"></i>Memuat Daftar Pemeriksaan...</td></tr>');

        $.ajax({
            url: "{{ route('lab.get_pemeriksaan_items') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "cat_code": catCode
            },
        }).done(function(res) {
            if (res.status === 'success' && res.data.length > 0) {
                let html = '';
                res.data.forEach(item => {
                    // Karena cart baru saja di-reset, ketersediaan checkbox dimulai dari unchecked
                    let isChecked = cartItems.some(c => c.code === item.p_sales_data_code) ? 'checked' : '';
                    let hargaFormatted = parseFloat(item.p_sales_data_price || 0).toLocaleString('id-ID');

                    // Di dalam AJAX .done() Step 3 (btn-paket-cat):
                    html += `
                    <tr class="item-row">
                        <td class="text-center">
                            <input type="checkbox" class="form-check-input check-item" ${isChecked}
                                data-code="${item.p_sales_data_code}"
                                data-nama="${item.p_sales_data_name}"
                                data-harga="${item.p_sales_data_price || 0}">
                        </td>
                        <td class="item-nama fw-semi-bold text-dark">${item.p_sales_data_name}</td>
                        <td class="text-end pe-3 text-success fw-bold">Rp ${parseFloat(item.p_sales_data_price || 0).toLocaleString('id-ID')}</td>
                    </tr>`;
                });
                $("#container-pemeriksaan-body").html(html);
            } else {
                $("#container-pemeriksaan-body").html('<tr><td colspan="3" class="text-center text-muted py-3">Tidak ada data pemeriksaan.</td></tr>');
            }
        });
    });

    // SEARCH REAL-TIME IN TABLE
    $("#search-pemeriksaan").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#container-pemeriksaan-body tr.item-row").filter(function() {
            $(this).toggle($(this).find('.item-nama').text().toLowerCase().indexOf(value) > -1);
        });
    });

    // CART MANAGEMENT (CHECKBOX TOGGLE)
    $(document).on("change", ".check-item", function() {
        var code = $(this).attr('data-code'); // Menggunakan .attr() lebih stabil dari .data()
        var nama = $(this).attr('data-nama');
        var harga = parseFloat($(this).attr('data-harga')) || 0;

        if ($(this).is(':checked')) {
            if (!cartItems.some(i => i.code === code)) {
                cartItems.push({
                    code: code,
                    nama: nama,
                    harga: harga
                });
            }
        } else {
            cartItems = cartItems.filter(i => i.code !== code);
        }

        console.log("Current Cart Items:", cartItems); // Buka Console Browser (F12) untuk cek array ini
        renderCart();
    });

    function removeCartItem(code) {
        cartItems = cartItems.filter(i => i.code !== code);
        $(`.check-item[data-code="${code}"]`).prop('checked', false);
        renderCart();
    }

    // Fungsi Render Keranjang Tampilan E-Commerce
    function renderCart() {
        var $cartList = $('#cart-list');
        var $emptyState = $('#cart-empty-state');
        var $btnSubmit = $('#button-fix-registrasi-lab');

        $cartList.empty();

        if (cartItems.length === 0) {
            $emptyState.removeClass('d-none');
            $('#cart-badge-count').text('0 Item');
            $('#cart-subtotal').text('Rp 0');
            $('#cart-grand-total').text('Rp 0');
            $btnSubmit.prop('disabled', true);
            return;
        }

        $emptyState.addClass('d-none');
        $btnSubmit.prop('disabled', false);

        var subtotal = 0;

        // Loop & Render Item E-Commerce Style
        cartItems.forEach(function(item, index) {
            subtotal += parseFloat(item.harga);

            var itemHtml = `
            <li class="list-group-item p-3 cart-item border-bottom d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <!-- Icon Test Tube / Lab -->
                    <div class="bg-light text-white p-2 rounded-3 border text-center" style="width: 42px; height: 42px;">
                        <i class="fas fa-scroll fs-2 text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold text-dark text-truncate" style="max-width: 200px;">${item.nama}</h6>
                        <span class="badge bg-light text-secondary border font-monospace style-micro">${item.code}</span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="fw-bold text-dark">Rp ${parseFloat(item.harga).toLocaleString('id-ID')}</span>
                    <!-- Tombol Hapus Item -->
                    <button type="button" class="btn btn-sm btn-outline-danger border-0 rounded-circle btn-remove-item" data-code="${item.code}" title="Hapus Item">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>
            </li>
        `;
            $cartList.append(itemHtml);
        });

        // Update Counter & Total
        $('#cart-badge-count').text(cartItems.length + ' Item');
        $('#cart-subtotal').text('Rp ' + subtotal.toLocaleString('id-ID'));
        $('#cart-grand-total').text('Rp ' + subtotal.toLocaleString('id-ID'));
    }

    // Event Hapus Item dari Keranjang
    $(document).on('click', '.btn-remove-item', function() {
        var code = $(this).data('code');

        // Filter keluarkan item
        cartItems = cartItems.filter(function(i) {
            return i.code !== code;
        });

        // Uncheck checkbox yang bersangkutan di tabel pilihan (jika ada)
        $(`.check-item[data-code="${code}"]`).prop('checked', false);

        // Render Ulang
        renderCart();
    });

    // SIMPAN REGISTRASI
    $('#button-fix-registrasi-lab').on('click', function(e) {
        e.preventDefault();

        var date = $('#tgl_pemeriksaan').val();
        var rujukan = $('#rujukan').val();
        var mSales = $('#pilih_m_sales').val();
        var patient_cat = document.getElementById('kategori').value;

        if (!date || !rujukan || !mSales) {
            Lobibox.notify('warning', {
                position: 'top right',
                msg: 'Lengkapi Tanggal, Dokter Rujukan, dan Master Sales!'
            });
            return;
        }

        if (cartItems.length === 0) {
            Lobibox.notify('warning', {
                position: 'top right',
                msg: 'Pilih minimal satu item pemeriksaan!'
            });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Registrasi',
            text: `Simpan ${cartItems.length} item pemeriksaan laboratorium ini?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-success me-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('lab.store_registrasi') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "patient_cat": patient_cat,
                        "date": $('#tgl_pemeriksaan').val(),
                        "rujukan": $('#rujukan').val(),
                        "master_sales": $('#pilih_m_sales').val(),
                        "no_reg": $("#no_registrasi").val() || '',
                        "no_rm": $("#no_rm").val() || '',
                        "items": JSON.stringify(cartItems) // <--- WAJIB DI-STRINGIFY
                    },
                }).done(function(res) {
                    Swal.fire('Berhasil!', 'Data Registrasi Lab telah tersimpan.', 'success');
                    // if (document.getElementById("menu-cetak-data-registrasi")) document.getElementById("menu-cetak-data-registrasi").style.display = "block";
                    document.getElementById("menu-fasilitas-layanan").disabled = true;
                    document.getElementById("menu-cetak-data-registrasi").style.display = "block";
                    document.getElementById("pill-contact-tab").click();
                    document.getElementById("button-pilih-end-proses").click();
                }).fail(function() {
                    Lobibox.notify('error', {
                        position: 'top right',
                        msg: 'Gagal menyimpan data registrasi.'
                    });
                });
            }
        });
    });
</script>
