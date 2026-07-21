<!-- resources/views/koperasi/voucher/index.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Voucher Koperasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="card-title mb-0">Form Pembayaran Tagihan Anggota (Voucher)</h5>
                        <small>Biaya akan ditagihkan secara akumulatif pada akhir bulan ini.</small>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('menu_koperasi_vocher_store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <!-- Kode Anggota -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label font-weight-bold">Kode Anggota Peserta</label>
                                    <input type="text" name="kop_master_peserta_code" class="form-control" placeholder="Contoh: AGT-00192" required>
                                </div>

                                <!-- Cabang Koperasi -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Cabang Koperasi</label>
                                    <input type="text" name="kop_data_cabang" class="form-control" placeholder="Contoh: Cabang Pusat" required>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Kategori Layanan -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jenis Layanan / Kategori</label>
                                    <select name="kop_vocher_cat_code" class="form-select" required>
                                        <option value="">-- Pilih Layanan --</option>
                                        @foreach($categories as $code => $name)
                                        <option value="{{ $code }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Nomor ID Pelanggan -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor ID Pelanggan (No. Rek Listrik/PDAM/Internet)</label>
                                    <input type="text" name="kop_vocher_data_number_id" class="form-control" placeholder="Contoh: 5321098xxxx" required>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Nominal Tagihan -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nominal Tagihan (Rp)</label>
                                    <input type="number" name="kop_vocher_data_nominal" class="form-control" min="1000" placeholder="0" required>
                                </div>

                                <!-- Biaya Admin Koperasi -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Biaya Admin Koperasi (Rp)</label>
                                    <input type="number" name="kop_vocher_data_admin" class="form-control" min="0" value="2500" required>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Proses & Terbitkan Voucher</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
