<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koperasi E-Shop & Katalog Anggota</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f6f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .product-card {
            border: none;
            border-radius: 12px;
            transition: transform 0.2s, box-shadow 0.2s;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .product-img-wrapper {
            position: relative;
            height: 200px;
            width: 100%;
            background-color: #eaeaea;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge-category {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 2;
        }

        .cart-sticky {
            position: sticky;
            top: 24px;
        }

        .fs-7 {
            font-size: 0.75rem;
        }

        /* Style Tambahan untuk Pencarian & Kategori */
        .search-box {
            border-radius: 30px;
            padding-left: 20px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s;
        }

        .search-box:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .category-pill {
            cursor: pointer;
            transition: all 0.2s;
            user-select: none;
            border: 1px solid #0d6efd;
        }

        .category-pill:hover {
            background-color: #0d6efd;
            color: #fff !important;
        }

        .category-pill.active {
            background-color: #0d6efd;
            color: #fff !important;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- TOP NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm py-3 mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class="fas fa-shopping-bag me-2 text-warning"></i>KOP-MART ONLINE</a>
            <span class="navbar-text text-white-50 d-none d-sm-inline">Katalog Belanja Khusus Anggota Koperasi</span>
        </div>
    </nav>

    <div class="container pb-5">

        <!-- FITUR FILTER & PENCARIAN -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm p-4 rounded-3 bg-white">
                    <div class="row align-items-center g-3">
                        <!-- Input Cari Nama -->
                        <div class="col-md-5">
                            <label class="form-label small fw-bold text-secondary mb-2"><i class="fas fa-search me-1"></i> Cari Produk</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0 rounded-start-pill text-muted"><i class="fas fa-search"></i></span>
                                <input type="text" id="search-product" class="form-control search-box border-start-0 rounded-end-pill py-2" placeholder="Ketik nama produk yang dicari...">
                            </div>
                        </div>
                        <!-- Filter Kategori Buttons -->
                        <div class="col-md-7">
                            <label class="form-label small fw-bold text-secondary mb-2"><i class="fas fa-tags me-1"></i> Filter Kategori</label>
                            <div class="d-flex flex-wrap gap-2" id="category-filter-container">
                                <span class="badge bg-outline-primary text-primary category-pill rounded-pill px-3 py-2 active" data-category="all">Semua</span>

                                @php
                                $categories = $produk->pluck('kategori')->unique();
                                @endphp
                                @foreach($categories as $cat)
                                <span class="badge bg-outline-primary text-primary category-pill rounded-pill px-3 py-2" data-category="{{ $cat }}">{{ $cat }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">

            <!-- BAGIAN KIRI: ETALASE DAFTAR PRODUK (8 COLUMNS) -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0 text-dark"><i class="fas fa-boxes me-2 text-primary"></i>Pilih Produk</h4>
                    <span class="text-muted small" id="search-status"></span>
                </div>

                <div class="row row-cols-1 row-cols-md-3 g-4" id="product-list-container">
                    @forelse($produk as $p)
                    <div class="col product-item" data-nama="{{ strtolower($p->nama_produk) }}" data-kategori="{{ $p->kategori }}">
                        <div class="card h-100 product-card">
                            <div class="product-img-wrapper">
                                <span class="badge bg-dark badge-category shadow-sm">{{ $p->kategori }}</span>
                                <img src="{{ $p->url_gambar }}" class="product-img" alt="{{ $p->nama_produk }}">
                            </div>
                            <div class="card-body d-flex flex-column p-3">
                                <small class="text-muted text-uppercase tracking-wider font-monospace fs-7">{{ $p->kode_produk }}</small>
                                <h6 class="fw-bold text-dark mt-1 text-truncate product-name" title="{{ $p->nama_produk }}">{{ $p->nama_produk }}</h6>
                                <h5 class="text-danger fw-bold my-2">Rp {{ number_format($p->harga_jual_default, 0, ',', '.') }}</h5>

                                <div class="mt-auto pt-2">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="small text-muted">Stok Tersedia:</span>
                                        @if($p->stok_aktual <= 0)
                                            <span class="badge bg-danger-subtle text-danger fw-bold">Habis</span>
                                            @else
                                            <span class="badge bg-success-subtle text-success fw-bold">{{ $p->stok_aktual }} {{ $p->satuan }}</span>
                                            @endif
                                    </div>

                                    <button class="btn btn-outline-primary w-100 fw-bold btn-add-to-cart btn-sm rounded-pill"
                                        data-id="{{ $p->id_produk }}"
                                        data-nama="{{ $p->nama_produk }}"
                                        data-harga="{{ $p->harga_jual_default }}"
                                        data-stok="{{ $p->stok_aktual }}"
                                        {{ $p->stok_aktual <= 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-cart-plus me-1"></i> Beli Barang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5" id="original-empty-message">
                        <div class="text-muted"><i class="fas fa-folder-open fa-3x mb-3 text-secondary"></i><br>Belum ada produk aktif yang dijual oleh koperasi.</div>
                    </div>
                    @endforelse

                    <div class="col-12 text-center py-5 d-none" id="search-empty-message">
                        <div class="text-muted"><i class="fas fa-search fa-3x mb-3 text-secondary"></i><br>Produk yang kamu cari tidak ditemukan. coba kata kunci lain!</div>
                    </div>
                </div>
            </div>

            <!-- BAGIAN KANAN: PILIHAN ANGGOTA & RINGKASAN KERANJANG (4 COLUMNS) -->
            <div class="col-lg-4">
                <div class="cart-sticky">

                    <!-- BOX PILIH IDENTITAS ANGGOTA -->
                    <div class="card border-0 shadow-sm p-3 bg-white rounded-3 mb-3">
                        <!-- UPDATE: Ditambahkan tombol lihat list belanja -->
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label small fw-bold text-secondary mb-0"><i class="fas fa-user-check me-1"></i> Pilih Anggota Pembeli:</label>
                            <button class="btn btn-outline-secondary btn-sm fw-bold px-2 py-0 rounded-pill" id="btn-view-history" style="font-size: 0.7rem;">
                                <i class="fas fa-history me-1"></i> List Belanja
                            </button>
                        </div>
                        <select class="form-select font-monospace text-dark btn-sm fs-7" id="select-peserta">
                            <option value="" selected disabled>-- Pilih Anggota Koperasi --</option>
                            @foreach($peserta as $item)
                            <option value="{{ $item->id_kop_master_peserta }}">
                                {{ $item->kop_master_peserta_nip }} - {{ $item->kop_master_peserta_name }} ({{ $item->kop_master_peserta_cabang }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- RINGKASAN KERANJANG BELANJA -->
                    <div class="card border-0 shadow-sm p-4 bg-white rounded-3">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <h5 class="fw-bold text-dark mb-0"><i class="fas fa-shopping-cart me-2 text-primary"></i>Keranjang Saya</h5>
                            <span class="badge bg-danger rounded-circle px-2 py-1" id="cart-count-badge">0</span>
                        </div>

                        <!-- Kontainer Daftar Rincian Barang di Keranjang -->
                        <div id="cart-items-container" style="max-height: 200px; overflow-y: auto;" class="mb-3">
                            <p class="text-muted text-center py-4 small mb-0" id="cart-empty-text">Keranjang masih kosong. Silakan pilih produk di sebelah kiri.</p>
                        </div>

                        <!-- PILIHAN METODE PEMBAYARAN -->
                        <div class="border-top pt-3 mb-3" id="payment-method-wrapper">
                            <label class="form-label small fw-bold text-secondary mb-2"><i class="fas fa-credit-card me-1"></i> Pilih Metode Pembayaran:</label>

                            <!-- Opsi 1: Masuk Tagihan -->
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="select_metode_bayar" id="pay-cash" value="CASH" checked>
                                <label class="form-check-label small" for="pay-cash">
                                    <strong>CASH</strong>
                                    <div class="text-muted fs-7">Silahkan Langsung Bayar ke Bagian Bendahara.</div>
                                </label>
                            </div>
                            <!-- Opsi 1: Masuk Tagihan -->
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="select_metode_bayar" id="pay-tagihan" value="MASUK_TAGIHAN" checked>
                                <label class="form-check-label small" for="pay-tagihan">
                                    <strong>Masuk Tagihan Anggota</strong>
                                    <div class="text-muted fs-7">Akumulasi otomatis ke dalam lembar tagihan rutin koperasi bulanan Anda.</div>
                                </label>
                            </div>

                            <!-- Opsi 2: Transfer Bank -->
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="select_metode_bayar" id="pay-tf" value="TRANSFER_BANK" disabled>
                                <label class="form-check-label small" for="pay-tf">
                                    <strong>Transfer Bank Manual</strong>
                                    <div class="text-muted fs-7">Transfer langsung ke rekening bank resmi Koperasi (Verifikasi manual).</div>
                                </label>
                            </div>

                            <!-- Opsi 3: Virtual Account -->
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="select_metode_bayar" id="pay-va" value="VIRTUAL_ACCOUNT" disabled>
                                <label class="form-check-label small" for="pay-va">
                                    <strong>Virtual Account (Otomatis)</strong>
                                    <div class="text-muted fs-7">Konfirmasi instan menggunakan kode VA unik (Mandiri, BRI, BCA, BNI).</div>
                                </label>
                            </div>
                        </div>

                        <!-- Total Harga Gabungan -->
                        <div class="border-top pt-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-bold text-secondary">Total Tagihan:</span>
                                <h4 class="fw-bold text-primary mb-0" id="cart-total-price">Rp 0</h4>
                            </div>
                            <div class="alert alert-info py-2 px-3 small rounded-3 border-0 mb-3" id="tenor-info-alert">
                                <i class="fas fa-info-circle me-1"></i> Transaksi menggunakan metode: <strong id="text-tenor-info">Masuk Tagihan Anggota</strong>.
                            </div>
                            <button class="btn btn-primary w-100 fw-bold py-2 rounded-3 shadow-sm" id="btn-checkout" disabled>
                                <i class="fas fa-lock me-1"></i> Verifikasi Keamanan & Ajukan
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- JS Dependencies -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            let internalCart = [];

            function formatRupiah(number) {
                return 'Rp ' + parseFloat(number).toLocaleString('id-ID');
            }

            // FILTER & PENCARIAN REALTIME (CLIENT-SIDE)
            function filterProducts() {
                let searchText = $('#search-product').val().toLowerCase().trim();
                let selectedCategory = $('.category-pill.active').data('category');
                let visibleCount = 0;

                $('.product-item').each(function() {
                    let productName = $(this).data('nama');
                    let productCategory = $(this).data('kategori');

                    let matchSearch = productName.includes(searchText);
                    let matchCategory = (selectedCategory === 'all' || productCategory === selectedCategory);

                    if (matchSearch && matchCategory) {
                        $(this).removeClass('d-none');
                        visibleCount++;
                    } else {
                        $(this).addClass('d-none');
                    }
                });

                if (visibleCount === 0 && $('.product-item').length > 0) {
                    $('#search-empty-message').removeClass('d-none');
                } else {
                    $('#search-empty-message').addClass('d-none');
                }

                if (searchText !== "" || selectedCategory !== "all") {
                    $('#search-status').text(`Menampilkan ${visibleCount} produk`);
                } else {
                    $('#search-status').text('');
                }
            }

            $('#search-product').on('keyup', function() {
                filterProducts();
            });

            $('.category-pill').on('click', function() {
                $('.category-pill').removeClass('active');
                $(this).addClass('active');
                filterProducts();
            });

            // Listener metode pembayaran baru
            $('input[name="select_metode_bayar"]').on('change', function() {
                let currentMethod = $(this).val();
                if (currentMethod === 'MASUK_TAGIHAN') {
                    $('#text-tenor-info').text('Masuk Tagihan Anggota');
                } else if (currentMethod === 'TRANSFER_BANK') {
                    $('#text-tenor-info').text('Transfer Bank Manual');
                } else if (currentMethod === 'VIRTUAL_ACCOUNT') {
                    $('#text-tenor-info').text('Virtual Account (Otomatis)');
                }
            });

            // Klik Tombol Beli Barang
            $('.btn-add-to-cart').on('click', function() {
                let id = $(this).data('id');
                let nama = $(this).data('nama');
                let harga = parseFloat($(this).data('harga'));
                let maxStok = parseInt($(this).data('stok'));

                let existingItem = internalCart.find(item => item.id === id);

                if (existingItem) {
                    if (existingItem.qty >= maxStok) {
                        Swal.fire('Stok Terbatas', 'Jumlah pesanan tidak boleh melebihi sisa stok produk aktif.', 'warning');
                        return;
                    }
                    existingItem.qty += 1;
                } else {
                    internalCart.push({
                        id: id,
                        nama: nama,
                        harga: harga,
                        qty: 1,
                        maxStok: maxStok
                    });
                }

                renderKeranjangVisual();
            });

            // Menggambar UI Rincian item
            function renderKeranjangVisual() {
                if (internalCart.length === 0) {
                    $('#cart-empty-text').removeClass('d-none');
                    $('#cart-items-container .cart-item-row').remove();
                    $('#cart-count-badge').text('0');
                    $('#cart-total-price').text('Rp 0');
                    $('#btn-checkout').prop('disabled', true);
                    return;
                }

                $('#cart-empty-text').addClass('d-none');
                $('#cart-items-container .cart-item-row').remove();

                let totalBelanja = 0;
                let totalQtyItem = 0;

                internalCart.forEach(function(item, index) {
                    totalBelanja += (item.harga * item.qty);
                    totalQtyItem += item.qty;

                    let rowHtml = `
                    <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded-3 mb-2 border cart-item-row">
                        <div style="max-width: 65%;">
                            <span class="fw-bold d-block text-truncate small">${item.nama}</span>
                            <small class="text-danger font-monospace text-muted">${formatRupiah(item.harga)}</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-light border py-0 px-2 btn-change-qty" data-index="${index}" data-action="minus">-</button>
                            <span class="mx-2 fw-bold small">${item.qty}</span>
                            <button class="btn btn-sm btn-light border py-0 px-2 btn-change-qty" data-index="${index}" data-action="plus">+</button>
                        </div>
                    </div>
                `;
                    $('#cart-items-container').append(rowHtml);
                });

                $('#cart-count-badge').text(totalQtyItem);
                $('#cart-total-price').text(formatRupiah(totalBelanja));
                $('#btn-checkout').prop('disabled', false);
            }

            // Handler Ubah Qty
            $(document).on('click', '.btn-change-qty', function() {
                let index = $(this).data('index');
                let action = $(this).data('action');
                let targetItem = internalCart[index];

                if (action === 'plus') {
                    if (targetItem.qty >= targetItem.maxStok) {
                        Swal.fire('Batas Maksimal', 'Pembelian tidak bisa melebihi persediaan fisik barang.', 'warning');
                        return;
                    }
                    targetItem.qty += 1;
                } else {
                    targetItem.qty -= 1;
                    if (targetItem.qty <= 0) {
                        internalCart.splice(index, 1);
                    }
                }
                renderKeranjangVisual();
            });

            // Action Checkout
            $('#btn-checkout').on('click', function() {
                let idPeserta = $('#select-peserta').val();
                let metodeTerpilih = $('input[name="select_metode_bayar"]:checked').val();
                let labelMetode = $('#text-tenor-info').text();

                if (!idPeserta) {
                    Swal.fire('Anggota Belum Dipilih', 'Silakan pilih Anggota Koperasi Pembeli terlebih dahulu pada dropdown di atas.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Verifikasi Keamanan Anggota',
                    text: `Metode: [${labelMetode}]. Masukkan 6 digit Kode Security Anggota terpilih untuk melakukan otorisasi transaksi:`,
                    input: 'password',
                    inputAttributes: {
                        autocapitalize: 'off',
                        autocorrect: 'off',
                        maxlength: 6,
                        placeholder: '******',
                        style: 'text-align: center; font-size: 24px; letter-spacing: 8px;'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    confirmButtonText: 'Konfirmasi Pembelian',
                    cancelButtonText: 'Batal',
                    inputValidator: (value) => {
                        if (!value || value.length < 6) {
                            return 'Kode security harus diisi lengkap 6 digit!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let secureCodeValue = result.value;

                        $.ajax({
                            url: "{{ route('shop.checkout') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                cart: internalCart,
                                id_kop_master_peserta: idPeserta,
                                metode_bayar: metodeTerpilih,
                                security_code: secureCodeValue
                            },
                            success: function(res) {
                                if (res.status === 'success') {
                                    Swal.fire({
                                        title: 'Transaksi Berhasil!',
                                        html: `${res.message}<br><br><b class="fs-4 font-monospace text-primary bg-light p-2 rounded border d-inline-block mt-2">${res.nota}</b>`,
                                        icon: 'success'
                                    }).then(() => {
                                        internalCart = [];
                                        location.reload();
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Otorisasi Gagal', xhr.responseJSON.message || 'Kode security salah atau data tidak sesuai.', 'error');
                            }
                        });
                    }
                });
            });

            // UPDATE: Action Lihat List Belanja (History) Anggota
            $('#btn-view-history').on('click', function() {
                let idPeserta = $('#select-peserta').val();
                let namaPeserta = $("#select-peserta option:selected").text().trim();

                if (!idPeserta) {
                    Swal.fire('Anggota Belum Dipilih', 'Silakan pilih Anggota Koperasi terlebih dahulu untuk melihat list belanja.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Verifikasi Keamanan Riwayat',
                    text: `Masukkan 6 digit Kode Security untuk melihat list belanja dari: ${namaPeserta}`,
                    input: 'password',
                    inputAttributes: {
                        autocapitalize: 'off',
                        autocorrect: 'off',
                        maxlength: 6,
                        placeholder: '******',
                        style: 'text-align: center; font-size: 24px; letter-spacing: 8px;'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    confirmButtonText: 'Lihat List Belanja',
                    cancelButtonText: 'Batal',
                    inputValidator: (value) => {
                        if (!value || value.length < 6) {
                            return 'Kode security harus diisi lengkap 6 digit!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let secureCodeValue = result.value;

                        // Loading State
                        Swal.fire({
                            title: 'Mengambil Data...',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });

                        $.ajax({
                            url: "{{ route('shop.history') }}", // Sesuaikan dengan nama route history Anda di Laravel
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id_kop_master_peserta: idPeserta,
                                security_code: secureCodeValue
                            },
                            success: function(res) {
                                if (res.status === 'success') {
                                    // Membuat tampilan list belanja dalam modal
                                    let listHtml = `<div class="text-start" style="max-height: 350px; overflow-y: auto;">`;

                                    if(res.data && res.data.length > 0) {
                                        listHtml += `<table class="table table-sm small table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Nota / Tgl</th>
                                                    <th>Item Belanja</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
                                        res.data.forEach(function(nota) {
                                            listHtml += `<tr>
                                                <td>
                                                    <strong class="text-primary">${nota.no_nota}</strong><br>
                                                    <small class="text-muted">${nota.tanggal}</small>
                                                </td>
                                                <td>${nota.rincian_barang}</td>
                                                <td class="text-end fw-bold text-danger">${formatRupiah(nota.total_harga)}</td>
                                            </tr>`;
                                        });
                                        listHtml += `</tbody></table>`;
                                    } else {
                                        listHtml += `<div class="text-center py-3 text-muted"><i class="fas fa-receipt fa-2x mb-2"></i><br>Belum ada riwayat transaksi belanja.</div>`;
                                    }
                                    listHtml += `</div>`;

                                    Swal.fire({
                                        title: `List Belanja Anggota`,
                                        html: listHtml,
                                        icon: 'info',
                                        width: '600px',
                                        confirmButtonText: 'Tutup'
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal Membuka Riwayat', xhr.responseJSON.message || 'Kode security salah atau otorisasi gagal.', 'error');
                            }
                        });
                    }
                });
            });

        });
    </script>
</body>

</html>
