<style>
    /* Custom Scrollbar untuk Ringkasan & Table */
    .custom-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scroll::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05);
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }

    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: #dc3545;
    }

    /* Item Card E-Commerce Style */
    .cart-item {
        transition: all 0.2s ease-in-out;
        border-left: 4px solid transparent;
    }

    .cart-item:hover {
        background-color: rgba(220, 53, 69, 0.05);
        border-left-color: #dc3545;
    }

    .style-micro {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .border-dashed {
        border-style: dashed !important;
    }
</style>

<!-- HEADER RADIOLOGI -->
<div class="card bg-white shadow-none border border-subtle mb-3">
    <div class="card-body p-3 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <div class="avatar avatar-xl me-3 bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center">
                <i class="fas fa-x-ray text-white"></i>
            </div>
            <div>
                <h4 class="mb-0 text-danger fw-bold">PELAYANAN RADIOLOGI</h4>
                <p class="text-body-secondary mb-0 small">Pilih tanggal, dokter rujukan, dan paket pemeriksaan radiologi pasien</p>
            </div>
        </div>
        <div>
            <span class="badge bg-danger bg-opacity-10 text-white"><i class="fas fa-info-circle me-1 text-white"></i> Form Input Registrasi</span>
        </div>
    </div>
</div>

<!-- FORM TANGGAL, DOKTER RUJUKAN & UPLOAD FILE -->
<div class="card bg-white shadow-sm border border-subtle mb-3">
    <div class="card-body p-3">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="tgl_pemeriksaan" class="form-label fw-bold text-body" style="font-size: 0.78rem;">
                    Tanggal Pemeriksaan <span class="text-danger">*</span>
                </label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-danger bg-opacity-10 text-white border-subtle"><i class="fas fa-calendar-alt"></i></span>
                    <input type="date" name="tanggal_periksa" id="tgl_pemeriksaan" class="form-control form-control-lg bg-white text-body border-subtle fw-semibold" required>
                </div>
            </div>
            <div class="col-md-4">
                <label for="rujukan" class="form-label fw-bold text-body" style="font-size: 0.78rem;">
                    Dokter Rujukan <span class="text-danger">*</span>
                </label>
                <select name="rujukan" id="rujukan" class="form-select form-select-lg choices-single-master bg-white" required>
                    <option value="">- Pilih Dokter -</option>
                    @foreach ($dokter as $dok)
                    <option value="{{ $dok->master_doctor_code }}">{{ $dok->master_doctor_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="file_rujukan" class="form-label fw-bold text-body" style="font-size: 0.78rem;">File Rujukan (Opsional)</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light text-body border-subtle"><i class="fas fa-file-upload"></i></span>
                    <input type="file" name="file_rujukan" id="file_rujukan" class="form-control form-control-lg bg-white text-body border-subtle">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ALUR PEMILIHAN AGREEMENT & SUMMARY CART -->
<div class="row g-3">
    <!-- PANEL KIRI: HIRARKI AGREEMENT & LIST ITEM -->
    <div class="col-xl-7">

        <!-- STEP 1 & STEP 2 -->
        <div class="row g-3">
            <div class="col-md-6">
                <!-- STEP 1: MASTER AGREEMENT -->
                <div class="card bg-white border border-subtle shadow-sm mb-3">
                    <div class="card-header bg-light border-bottom border-subtle py-2">
                        <h6 class="mb-0 text-body fw-bold" style="font-size: 0.85rem;">
                            <span class="badge bg-danger me-2">1</span> Master Agreement
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <select name="pilih_m_sales" class="form-select form-select-lg bg-white" id="pilih_m_sales">
                            <option value="">-- Pilih Master Agreement --</option>
                            @foreach ($masterSales as $ms)
                            <option value="{{ $ms->p_m_sales_code }}">{{ $ms->p_m_sales_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- STEP 2: SUB MASTER SALES -->
                <div class="card bg-white border border-subtle shadow-sm mb-3" id="card-step-sub" style="display: none;">
                    <div class="card-header bg-light border-bottom border-subtle py-2">
                        <h6 class="mb-0 text-body fw-bold" style="font-size: 0.85rem;">
                            <span class="badge bg-secondary me-2">2</span> Sub Agreement
                        </h6>
                    </div>
                    <div class="card-body p-3">
                        <select name="pilih_sub_sales" class="form-select form-select-lg bg-white" id="pilih_sub_sales">
                            <option value="">-- Pilih Sub Agreement --</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 3: PAKET / KATEGORI -->
        <div class="card bg-white border border-subtle shadow-sm mb-3" id="card-step-paket" style="display: none;">
            <div class="card-header bg-light border-bottom border-subtle py-2">
                <h6 class="mb-0 text-body fw-bold" style="font-size: 0.85rem;">
                    <span class="badge bg-info me-2">3</span> Pilih Paket / Kategori Radiologi
                </h6>
            </div>
            <div class="card-body p-3">
                <select name="pilih_paket_cat" class="form-select form-select-lg bg-white" id="pilih_paket_cat">
                    <option value="">-- Pilih Paket / Kategori --</option>
                </select>
            </div>
        </div>

        <!-- STEP 4: ITEM PEMERIKSAAN RADIOLOGI -->
        <div class="card bg-white border border-subtle shadow-sm mb-3" id="card-step-pemeriksaan" style="display: none;">
            <div class="card-header bg-light border-bottom border-subtle py-2 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-body fw-bold" style="font-size: 0.85rem;">
                    <span class="badge bg-success me-2">4</span> Item Pemeriksaan Radiologi
                </h6>
                <input type="text" id="search-pemeriksaan" class="form-control form-control-sm w-50 bg-white" placeholder="🔍 Cari item radiologi...">
            </div>
            <div class="card-body p-0">
                <div class="table-responsive custom-scroll" style="max-height: 320px;">
                    <table class="table table-hover table-striped align-middle mb-0 bg-white">
                        <thead class="bg-light sticky-top">
                            <tr>
                                <th width="12%" class="text-center">Pilih</th>
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

    <!-- PANEL KANAN: RINGKASAN ORDER / CART RADIOLOGI -->
    <div class="col-xl-5">
        <div class="card bg-white border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <!-- Header Ringkasan -->
            <div class="card-header text-white py-3 px-4 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-shopping-bag fs-2"></i>
                    <h6 class="mb-0 fw-bold text-uppercase tracking-wider text-white">Ringkasan Radiologi</h6>
                </div>
                <span class="badge bg-white text-danger rounded-pill px-3 py-2 fw-bold" id="cart-badge-count">
                    0 Item
                </span>
            </div>

            <!-- Body Item Keranjang -->
            <div class="card-body p-0 bg-white">
                <div id="cart-items-container" class="custom-scroll" style="max-height: 380px; overflow-y: auto;">
                    <div id="cart-empty-state" class="text-center py-5 px-3">
                        <div class="avatar-lg mx-auto mb-3 text-muted opacity-50">
                            <i class="fas fa-x-ray display-4"></i>
                        </div>
                        <h6 class="fw-semibold text-secondary mb-1">Keranjang Masih Kosong</h6>
                        <p class="text-muted small mb-0">Pilih item pemeriksaan radiologi di sebelah kiri.</p>
                    </div>
                    <ul class="list-group list-group-flush bg-white" id="cart-list"></ul>
                </div>
            </div>

            <!-- Footer / Total Pembayaran -->
            <div class="card-footer bg-white p-4 border-top border-subtle">
                <div class="d-flex justify-content-between align-items-center mb-2 text-body-secondary small">
                    <span>Subtotal Pemeriksaan</span>
                    <span class="fw-semibold" id="cart-subtotal">Rp 0</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 text-body-secondary small">
                    <span>Diskon / Potongan</span>
                    <span class="text-danger fw-semibold" id="cart-discount">- Rp 0</span>
                </div>

                <hr class="my-3 border-dashed">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="d-block text-uppercase fw-bold text-body-secondary style-micro">Total Pembayaran</span>
                        <h4 class="fw-bold text-danger mb-0" id="cart-grand-total">Rp 0</h4>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill small">
                        <i class="fas fa-shield-alt me-1"></i> Siap Disimpan
                    </span>
                </div>

                <!-- Tombol Action Utama -->
                <button type="button" id="button-fix-registrasi-rad" class="btn btn-danger btn-lg w-100 rounded-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 py-3" disabled>
                    <i class="fas fa-check-circle fs-5"></i>
                    <span>PROSES REGISTRASI RADIOLOGI</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT LOGIC -->
<script>
    let cartItems = [];

    // Initialize Choices.js jika ada
    if (typeof window.Choices !== 'undefined' && document.querySelector(".choices-single-master")) {
        new window.Choices(document.querySelector(".choices-single-master"));
    }

    // Helper Format Rupiah Safe (Cegah RpNaN)
    function formatRupiah(number) {
        let val = parseFloat(number);
        if (isNaN(val)) val = 0;
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(val);
    }

    // STEP 1 -> STEP 2 (Get Sub Sales)
    $('#pilih_m_sales').on('change', function() {
        let mSalesCode = $(this).val();
        $('#card-step-sub, #card-step-paket, #card-step-pemeriksaan').hide();

        if (mSalesCode) {
            $.post("{{ route('radiologi.get_sub_sales') }}", {
                _token: "{{ csrf_token() }}",
                m_sales_code: mSalesCode
            }, function(res) {
                if (res.status === 'success') {
                    $('#pilih_sub_sales').html(res.html);
                    $('#card-step-sub').fadeIn();
                }
            });
        }
    });

    // STEP 2 -> STEP 3 (Get Paket / Kategori)
    $('#pilih_sub_sales').on('change', function() {
        let salesCode = $(this).val();
        $('#card-step-paket, #card-step-pemeriksaan').hide();

        if (salesCode) {
            $.post("{{ route('radiologi.get_paket_cat') }}", {
                _token: "{{ csrf_token() }}",
                sales_code: salesCode
            }, function(res) {
                if (res.status === 'success') {
                    $('#pilih_paket_cat').html(res.html);
                    $('#card-step-paket').fadeIn();
                }
            });
        }
    });

    // STEP 3 -> STEP 4 (Get Items Pemeriksaan)
    $('#pilih_paket_cat').on('change', function() {
        let catCode = $(this).val();
        $('#card-step-pemeriksaan').hide();

        if (catCode) {
            $.post("{{ route('radiologi.get_items') }}", {
                _token: "{{ csrf_token() }}",
                cat_code: catCode
            }, function(res) {
                if (res.status === 'success') {
                    let html = '';

                    if (!res.data || res.data.length === 0) {
                        html = `<tr><td colspan="3" class="text-center text-muted py-3">Tidak ada item pemeriksaan pada kategori ini</td></tr>`;
                    } else {
                        res.data.forEach(item => {
                            // Penanganan nama kolom dinamis sesuai controller
                            let itemCode = item.p_sales_data_code || item.rad_item_code || item.id || '';
                            let itemName = item.p_sales_data_name || item.rad_item_name || 'Tanpa Nama Item';
                            let itemPrice = parseFloat(item.p_sales_data_price || item.price || 0);

                            let isChecked = cartItems.some(c => c.code === itemCode) ? 'checked' : '';

                            html += `
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input item-check"
                                               data-code="${itemCode}"
                                               data-name="${itemName}"
                                               data-price="${itemPrice}" ${isChecked}>
                                    </td>
                                    <td class="fw-semibold text-body-highlight">${itemName}</td>
                                    <td class="text-end pe-3 fw-bold text-danger">${formatRupiah(itemPrice)}</td>
                                </tr>
                            `;
                        });
                    }

                    $('#container-pemeriksaan-body').html(html);
                    $('#card-step-pemeriksaan').fadeIn();
                }
            });
        }
    });

    // Filter Live Search Item Radiologi
    $('#search-pemeriksaan').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $("#container-pemeriksaan-body tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Checkbox Toggle Cart
    $(document).on('change', '.item-check', function() {
        let code = $(this).data('code');
        let name = $(this).data('name');
        let price = parseFloat($(this).data('price'));

        if ($(this).is(':checked')) {
            cartItems.push({
                code,
                name,
                price
            });
        } else {
            cartItems = cartItems.filter(item => item.code !== code);
        }
        renderCart();
    });

    // Render Cart Summary
    function renderCart() {
        let cartList = $('#cart-list');
        let total = 0;

        if (cartItems.length === 0) {
            $('#cart-empty-state').show();
            cartList.html('');
            $('#button-fix-registrasi-rad').prop('disabled', true);
        } else {
            $('#cart-empty-state').hide();
            let html = '';
            cartItems.forEach((item) => {
                total += item.price;
                html += `
                    <li class="list-group-item cart-item bg-white d-flex justify-content-between align-items-center p-3 border-bottom border-subtle">
                        <div>
                            <h6 class="mb-0 fw-bold style-micro text-body">${item.name}</h6>
                            <small class="text-danger fw-semibold">${formatRupiah(item.price)}</small>
                        </div>
                        <button class="btn btn-sm btn-link text-danger p-0 btn-remove-item" data-code="${item.code}">
                            <i class="fas fa-times-circle fs-5"></i>
                        </button>
                    </li>
                `;
            });
            cartList.html(html);
            $('#button-fix-registrasi-rad').prop('disabled', false);
        }

        $('#cart-badge-count').text(`${cartItems.length} Item`);
        $('#cart-subtotal').text(formatRupiah(total));
        $('#cart-grand-total').text(formatRupiah(total));
    }

    // Remove Item Dari Cart
    $(document).on('click', '.btn-remove-item', function() {
        let code = $(this).data('code');
        cartItems = cartItems.filter(item => item.code !== code);
        $(`.item-check[data-code="${code}"]`).prop('checked', false);
        renderCart();
    });

    // Submit Registration via AJAX
    $('#button-fix-registrasi-rad').on('click', function(e) {
        e.preventDefault();
        let rujukan = $('#rujukan').val();
        let date = $('#tgl_pemeriksaan').val();
        var patient_cat = document.getElementById('kategori').value;
        if (!date || !rujukan) {
            Swal.fire({
                icon: 'warning',
                title: 'Data Belum Lengkap',
                text: 'Tanggal Pemeriksaan dan Dokter Rujukan wajib diisi!'
            });
            return;
        }

        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: "Data registrasi radiologi akan diproses!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-check me-1"></i> Ya, Daftarkan!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-danger me-2',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('rujukan', rujukan);
                formData.append('patient_cat', patient_cat);
                formData.append('date', date);
                formData.append('no_reg', $('#no_registrasi').val() || '');
                formData.append('no_rm', $('#no_rm').val() || '');

                if ($('#file_rujukan')[0] && $('#file_rujukan')[0].files[0]) {
                    formData.append('file_rujukan', $('#file_rujukan')[0].files[0]);
                }

                cartItems.forEach((item, index) => {
                    formData.append(`items[${index}][code]`, item.code);
                    formData.append(`items[${index}][name]`, item.name);
                    formData.append(`items[${index}][price]`, item.price);
                });

                $.ajax({
                    url: "{{ route('registrasi_pasien_pilih_data_pasien_kebutuhan_fix_registrasi_rad') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        Swal.fire('Terregistrasi!', 'Registrasi Radiologi Berhasil Disimpan', 'success');
                        document.getElementById("menu-fasilitas-layanan").disabled = true;
                        document.getElementById("menu-cetak-data-registrasi").style.display = "block";
                        document.getElementById("pill-contact-tab").click();
                        document.getElementById("button-pilih-end-proses").click();
                    },
                    error: function(err) {
                        Swal.fire('Error', 'Gagal memproses registrasi radiologi!', 'error');
                    }
                });
            }
        });
    });
</script>
