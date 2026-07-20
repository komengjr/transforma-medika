<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Kontrak - {{ $data->kop_master_peserta_name }}</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Innoventra</a></p>
    </div>
    <div class="p-4 pb-4" id="menu-data-show-peminjaman-baru">
        <div class="card mb-2" id="menu-status-kontrak">
            <div class="card-header bg-300">
                <div class="row flex-between-end">
                    <div class="col-auto align-self-center">
                        <h5 class="mb-0" data-anchor="data-anchor" id="horizontal-form-label-sizing">Data Pengajuan Peminjaman Uang</h5>
                        <p class="mb-0 mt-2 mb-0">Lorem ipsum dolor sit amet...</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="text-500">Report to</h6>
                        <h5>{{ $data->kop_master_peserta_name }}</h5>
                        <p class="fs--1">{{ $data->kop_master_peserta_nik }}<br>{{ $data->kop_master_peserta_tgl_lahir }}<br>{{ $data->kop_master_peserta_tempat_lahir }}</p>
                        <p class="fs--1"><a href="mailto:{{ $data->kop_master_peserta_email }}">{{ $data->kop_master_peserta_email }}</a><br><a href="tel:{{ $data->kop_master_peserta_no_hp }}">{{ $data->kop_master_peserta_no_hp }}</a></p>
                    </div>
                    <div class="col-sm-auto ms-auto">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless fs--1">
                                <tbody>
                                    <tr>
                                        <th>No Pengajuan</th>
                                        <td>: 14</td>
                                    </tr>
                                    <tr>
                                        <th>Nominal Pengajuan</th>
                                        <td>: @currency($data->kop_proses_uang_nominal)</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Pengajuan</th>
                                        <td>: {{ $data->kop_proses_uang_tgl }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tenor :</th>
                                        <td>: {{ $data->kop_proses_uang_tenor }} Bulan</td>
                                    </tr>
                                    <tr class="alert-success fw-bold">
                                        <th>Suku Bunga</th>
                                        <td>: {{ $data->kop_proses_uang_bunga }} %</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- FORM PEMBUNGKUS UNTUK MULTI CHECKBOX -->
                <form id="form-pelunasan-multi">
                    @csrf
                    <input type="hidden" name="kop_proses_uang_code" value="{{ $data->kop_proses_uang_code }}">

                    <div class="table-responsive scrollbar mt-4 fs--1">
                        <table class="table table-striped border-bottom">
                            <thead class="light">
                                <tr class="bg-primary text-white dark__bg-1000">
                                    <th class="border-0 text-center" style="width: 50px;">
                                        <!-- Checkbox untuk select all (opsional) -->
                                        <input type="checkbox" id="select-all-tagihan" class="form-check-input">
                                    </th>
                                    <th class="border-0">Bulan</th>
                                    <th class="border-0 text-center">Tenor Ke</th>
                                    <th class="border-0 text-center">Suku Bunga {{ $data->kop_proses_uang_bunga }} %</th>
                                    <th class="border-0 text-end">Angsuran Pokok</th>
                                    <th class="border-0 text-end">Total Angsuran Bulanan</th>
                                    <th class="border-0 text-end">Status/Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $total = 0 ;
                                $paid = 0;
                                $pokok = $data->kop_proses_uang_nominal / $data->kop_proses_uang_tenor;
                                $suku_bunga = ($data->kop_proses_uang_nominal * ($data->kop_proses_uang_bunga / 100)) / $data->kop_proses_uang_tenor;
                                $admin = ($data->kop_proses_uang_admin / 100) * $data->kop_proses_uang_nominal;
                                @endphp

                                @for ($i = 1 ; $i <= $data->kop_proses_uang_tenor ; $i++)
                                    @php
                                    $cek = DB::table('kop_log_peminjaman_uang')
                                    ->where('kop_proses_uang_code', $data->kop_proses_uang_code)
                                    ->where('kop_log_peminjaman_uang_tenor', $i)
                                    ->first();
                                    @endphp
                                    <tr>
                                        <td class="align-middle text-center">
                                            <!-- Checkbox dengan tambahan data-amount (Pokok + Suku Bunga) -->
                                            @if ($cek && $cek->kop_log_peminjaman_uang_status == '0')
                                            <input type="checkbox"
                                                name="log_codes[]"
                                                value="{{ $cek->kop_log_peminjaman_uang_code }}"
                                                data-amount="{{ $pokok + $suku_bunga }}"
                                                class="form-check-input cb-tagihan">
                                            @else
                                            <input type="checkbox" class="form-check-input" disabled>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <h6 class="mb-0 text-nowrap">{{ date('d - M - Y', strtotime('+' . $i .' month', strtotime($data->kop_proses_uang_tgl))) }}</h6>
                                        </td>
                                        <td class="align-middle text-center">{{ $i }}</td>
                                        <td class="align-middle text-center">@currency($suku_bunga)</td>
                                        <td class="align-middle text-end">@currency($pokok)</td>
                                        <td class="align-middle text-end">@currency($pokok + $suku_bunga)</td>
                                        <td class="align-middle text-end">
                                            @if ($cek)
                                            @if ($cek->kop_log_peminjaman_uang_status == '0')
                                            @if ($cek->kop_log_peminjaman_uang_date <= date('Y-m-d') )
                                                <span class="badge bg-warning text-dark">Jatuh Tempo</span>
                                                @else
                                                <span class="badge bg-dark">Menunggu</span>
                                                @endif
                                                @else
                                                <span class="badge bg-primary">Lunas</span>
                                                @endif
                                                @else
                                                <span class="badge bg-danger">Unvalid</span>
                                                @endif
                                        </td>
                                    </tr>
                                    @endfor
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                    <!-- Masukkan ini di dalam form, tepat di bawah @csrf -->
                    @php
                    // Contoh mengambil data akun kas/bank dari COA untuk metode pembayaran.
                    // Sesuaikan query ini dengan nama tabel dan filter COA di sistem Anda.
                    $list_coa = DB::table('kop_fin_master_coa') // Ganti dengan nama tabel COA Anda
                    // ->where('coa_tipe', 'Kas/Bank') // Contoh filter tipe akun
                    ->get();
                    @endphp

                    <!-- Dropdown COA Master yang disembunyikan (akan di-cloning oleh SweetAlert) -->
                    <div id="container-select-coa-hidden" style="display: none;">
                        <div class="text-start mb-3">
                            <label class="form-label fw-bold text-900">Pilih Metode Pembayaran (Akun COA) :</label>
                            <select class="form-select" id="swal-pilih-coa" required>
                                <option value="">-- Pilih Metode Pembayaran --</option>
                                @foreach($list_coa as $coa)
                                <!-- Sesuaikan property value dan text dengan kolom tabel Anda -->
                                <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Input hidden untuk menampung COA yang dipilih dari SweetAlert -->
                    <input type="hidden" name="payment_coa_code" id="hidden-payment-coa-code">
                </form>

            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    <!-- Tombol Aksi Multi Pelunasan -->
    <button type="button" class="btn btn-info" id="button-pelunasan-terpilih" style="display: none;">
        Bayar Bulan Terpilih (<span id="jumlah-terpilih">0</span>)
    </button>

    @if ($lunas == $data->kop_proses_uang_tenor)
    <span id="menu-add-data-verifikasi">
        <button class="btn btn-success float-end" id="button-penyelesaian-data-kontrak" data-code="{{ $data->kop_proses_uang_code }}">Penyelesaian Data</button>
    </span>
    @else
    <span id="menu-add-data-verifikasi">
        <button class="btn btn-success float-end" id="button-create-data-kontrak-baru" data-code="{{ $data->kop_proses_uang_code }}">Membuat Kontrak Baru</button>
    </span>
    @endif
</div>

<!-- SCRIPT JAVASCRIPT / JQUERY (Letakkan di section script Anda) -->
<script>
    $(document).ready(function() {
        // Fungsi pembantu untuk memformat angka ke Rupiah
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        // Logika menampilkan tombol bayar ketika checkbox dipilih
        $(document).on('change', '.cb-tagihan, #select-all-tagihan', function() {
            if ($(this).attr('id') == 'select-all-tagihan') {
                $('.cb-tagihan:not(:disabled)').prop('checked', this.checked);
            }

            var countChecked = $('.cb-tagihan:checked').length;
            $('#jumlah-terpilih').text(countChecked);

            if (countChecked > 0) {
                $('#button-pelunasan-terpilih').fadeIn();
            } else {
                $('#button-pelunasan-terpilih').fadeOut();
            }
        });

        // Proses klik tombol "Bayar Bulan Terpilih"
        // Proses klik tombol "Bayar Bulan Terpilih"
        $(document).on('click', '#button-pelunasan-terpilih', function(e) {
            e.preventDefault();

            var countChecked = $('.cb-tagihan:checked').length;

            // Mengambil nilai master nominal dari Blade PHP ke JavaScript
            var pokokBulanan = parseFloat("{{ $pokok }}") || 0;
            var bungaBulanan = parseFloat("{{ $suku_bunga }}") || 0;

            // LOGIKA PERHITUNGAN MULTI BULAN (Opsi 1)
            var totalPokok = pokokBulanan * countChecked;
            var totalBunga = (bungaBulanan * countChecked) * (10 / 100);
            var totalBayar = totalPokok + totalBunga;

            // Ambil isi HTML dari div hidden select COA
            var htmlSelectCoa = $('#container-select-coa-hidden').html();

            Swal.fire({
                title: 'Konfirmasi Pelunasan',
                html: `
            <div class="alert alert-info text-start py-2 fs--1 mb-3">
                <table class="table table-sm table-borderless mb-0 text-dark">
                    <tr>
                        <td>Jumlah Bulan</td>
                        <td>: <strong>${countChecked} Bulan</strong></td>
                    </tr>
                    <tr>
                        <td>Total Pokok (${countChecked}x)</td>
                        <td>: ${formatRupiah(totalPokok)}</td>
                    </tr>
                    <tr>
                        <td>Total Bunga (${countChecked}x)</td>
                        <td>: ${formatRupiah(totalBunga)}</td>
                    </tr>
                    <tr class="border-top">
                        <td><strong>Total yang Dibayar</strong></td>
                        <td>: <strong class="text-danger fs-0">${formatRupiah(totalBayar)}</strong></td>
                    </tr>
                </table>
            </div>
            ${htmlSelectCoa}
        `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Proses Pelunasan',
                cancelButtonText: 'Batal',
                preConfirm: () => {
                    const selectedCoa = Swal.getPopup().querySelector('#swal-pilih-coa').value;
                    if (!selectedCoa) {
                        Swal.showValidationMessage(`Silakan pilih metode pembayaran/akun COA terlebih dahulu!`);
                    }
                    return {
                        coa_code: selectedCoa
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#hidden-payment-coa-code').val(result.value.coa_code);
                    var formData = $('#form-pelunasan-multi').serialize();

                    Swal.fire({
                        title: 'Memproses Pembayaran...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ route('menu_peminjaman_list_cek_kontrak_payment_multi') }}",
                        type: "POST",
                        data: formData,
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Gagal!', response.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Terjadi kesalahan pada sistem.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
