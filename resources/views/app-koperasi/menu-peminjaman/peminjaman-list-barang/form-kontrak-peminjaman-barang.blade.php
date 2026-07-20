<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Form Kontrak - {{ $data->kop_master_peserta_name }}</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold" href="#!">Innoventra</a>
        </p>
    </div>
    <div class="p-4 pb-4" id="menu-data-show-peminjaman-baru" data-kontrak-code="{{ $data->kop_proses_brg_code }}">
        <div class="card mb-2" id="menu-status-kontrak">
            <div class="card-header bg-300">
                <div class="row flex-between-end">
                    <div class="col-auto align-self-center">
                        <h5 class="mb-0" data-anchor="data-anchor" id="horizontal-form-label-sizing">Data Pengajuan Peminjaman Uang<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#horizontal-form-label-sizing" style="padding-left: 0.375em;"></a></h5>
                        <p class="mb-0 mt-2 mb-0">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Rem minima non quis fugiat natus quo officia nam maiores! Minima mollitia id cumque repellat modi consequatur quasi quas hic est sed?</p>
                    </div>
                    <div class="col-auto ms-auto">

                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="text-500">Report to</h6>
                        <h5>{{ $data->kop_master_peserta_name }}</h5>
                        <p class="fs--1">{{ $data->kop_master_peserta_nik }}<br>{{ $data->kop_master_peserta_tgl_lahir }}<br>{{ $data->kop_master_peserta_tempat_lahir }}</p>
                        <p class="fs--1"><a href="mailto:example@gmail.com">{{ $data->kop_master_peserta_email }}</a><br><a href="tel:444466667777">{{ $data->kop_master_peserta_no_hp }}</a></p>
                    </div>
                    <div class="col-sm-auto ms-auto">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless fs--1">
                                <tbody>
                                    <tr>
                                        <th class="">No Pengajuan</th>
                                        <td>: 14</td>
                                    </tr>
                                    <tr>
                                        <th class="">Nominal Pengajuan</th>
                                        <td>: @currency($data->kop_proses_brg_nominal)</td>
                                    </tr>
                                    <tr>
                                        <th class="">Tanggal Pengajuan </th>
                                        <td>: {{ $data->kop_proses_brg_tgl }}</td>
                                    </tr>
                                    <tr>
                                        <th class="">Tenor :</th>
                                        <td>: {{ $data->kop_proses_brg_tenor }} Bulan</td>
                                    </tr>
                                    <tr class="alert-success fw-bold">
                                        <th class="">Suku Bunga </th>
                                        <td>: {{ $data->kop_proses_brg_bunga }} %</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="table-responsive scrollbar mt-4 fs--1">
                    <form id="form-pelunasan-multi-barang">
                        @csrf
                        <table class="table table-striped border-bottom">
                            <thead class="light">
                                <tr class="bg-primary text-white dark__bg-1000">
                                    <th class="border-0 text-center" style="width: 5%">
                                        <input type="checkbox" id="check-all-tenor">
                                    </th>
                                    <th class="border-0">Bulan</th>
                                    <th class="border-0 text-center">Tenor Ke</th>
                                    <th class="border-0 text-center">Suku Bunga {{ $data->kop_proses_brg_bunga }} %</th>
                                    <th class="border-0 text-end">Angsuran Pokok</th>
                                    <th class="border-0 text-end">Total Angsuran Bulanan</th>
                                    <th class="border-0 text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $total = 0;
                                $paid = 0;
                                $pokok = $data->kop_proses_brg_nominal / $data->kop_proses_brg_tenor;
                                $suku_bunga = ($data->kop_proses_brg_nominal * ($data->kop_proses_brg_bunga / 100)) / $data->kop_proses_brg_tenor;
                                $admin = ($data->kop_proses_brg_admin / 100) * $data->kop_proses_brg_nominal;
                                @endphp

                                @for ($i = 1 ; $i <= $data->kop_proses_brg_tenor ; $i++)
                                    <tr>
                                        @php
                                        $cek = DB::table('kop_log_peminjaman_barang')
                                        ->where('kop_proses_brg_code', $data->kop_proses_brg_code)
                                        ->where('kop_log_peminjaman_brg_tenor', $i)
                                        ->first();
                                        @endphp

                                        <!-- Kolom Checkbox Multi Pilih -->
                                        <td class="align-middle text-center">
                                            @if ($cek && $cek->kop_log_peminjaman_brg_status == '0')
                                            <input type="checkbox" class="check-tenor-item" name="log_codes[]"
                                                value="{{ $cek->kop_log_peminjaman_barang_code }}"
                                                data-tenor="{{ $i }}"
                                                data-pokok="{{ $pokok }}"
                                                data-bunga="{{ $suku_bunga }}"
                                                data-total="{{ $pokok + $suku_bunga }}">
                                            @else
                                            <input type="checkbox" disabled>
                                            @endif
                                        </td>

                                        <td class="align-middle">
                                            <h6 class="mb-0 text-nowrap">{{ date('d - M - Y', strtotime('+' . $i .' month', strtotime($data->kop_proses_brg_tgl))) }}</h6>
                                        </td>
                                        <td class="align-middle text-center">{{ $i }}</td>
                                        <td class="align-middle text-center">@currency($suku_bunga)</td>
                                        <td class="align-middle text-end">@currency($pokok)</td>
                                        <td class="align-middle text-end">@currency($pokok + $suku_bunga)</td>

                                        <td class="align-middle text-end">
                                            @if ($cek)
                                            @if ($cek->kop_log_peminjaman_brg_status == '0')
                                            @if ($cek->kop_log_peminjaman_brg_date <= date('Y-m-d'))
                                                <span class="badge bg-warning">Jatuh Tempo</span>
                                                @else
                                                <span class="badge bg-dark">Belum Tempo</span>
                                                @endif
                                                @else
                                                @php
                                                $jurnal = DB::table('kop_fin_jurnal')
                                                ->where('jurnal_ref_table','=','kop_proses_peminjaman_barang')
                                                ->where('jurnal_ref_code', $data->kop_proses_brg_code)
                                                ->orderBy('id_jurnal', 'desc')
                                                ->first();
                                                @endphp
                                                @if ($jurnal)
                                                <span class="badge bg-primary">{{ $jurnal->jurnal_no_bukti }}</span>
                                                @else
                                                <span class="badge bg-success">Lunas</span>
                                                @endif

                                                @php
                                                $paid = $paid + ($pokok + $suku_bunga);
                                                @endphp
                                                @endif
                                                @else
                                                <span class="badge bg-danger">Invalid</span>
                                                @endif
                                        </td>
                                    </tr>
                                    @php
                                    $total = $total + ( $pokok + $suku_bunga );
                                    @endphp
                                    @endfor
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-900" colspan="5">Subtotal :</td>
                                    <td class="fw-semi-bold align-middle text-end">@currency($total)</td>
                                    <td class="fw-semi-bold align-middle text-end text-success">@currency($paid)</td>
                                </tr>
                                <tr class="border-top">
                                    <td class="text-900" colspan="5">Biaya Admin :</td>
                                    <td class="align-middle text-end">@currency($admin)</td>
                                    <td class="fw-semi-bold align-middle text-end">@currency(0)</td>
                                </tr>
                                <tr class="border-top border-top-2 fw-bolder text-900">
                                    <td class="text-900" colspan="5">Total :</td>
                                    <td class="align-middle text-end">@currency($total + $admin)</td>
                                    <td class="fw-semi-bold align-middle text-end text-danger">@currency($paid)</td>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Tombol Pemicu Pembayaran Masal -->
                        @if ($total != $paid)
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-primary btn-sm px-4" id="btn-pemicu-modal-pelunasan">
                                <i class="fas fa-money-check-alt me-1"></i> Bayar Bulan Terpilih
                            </button>
                        </div>
                        @endif

                        <!-- MODAL POP-UP: KONFIRMASI TOTAL & COA -->
                        <div class="modal fade" id="modalKonfirmasiPelunasanBarang" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalKonfirmasiLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title text-white" id="modalKonfirmasiLabel">Konfirmasi Pembayaran Angsuran</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <!-- Ringkasan Struk Perhitungan Dinamis -->
                                        <div class="bg-light p-3 rounded mb-3 border">
                                            <h6 class="text-700 border-bottom pb-2 mb-2 fs--1 fw-bold text-uppercase">Ringkasan Tagihan Terpilih</h6>
                                            <div class="d-flex justify-content-between mb-1 fs--1">
                                                <span>Bulan Dipilih:</span>
                                                <span class="fw-bold text-primary" id="text-modal-jumlah-bulan">0 Bulan</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-1 fs--1">
                                                <span>Total Pokok:</span>
                                                <span class="fw-semi-bold" id="text-modal-total-pokok">Rp 0</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2 fs--1">
                                                <span>Total Bunga:</span>
                                                <span class="fw-semi-bold" id="text-modal-total-bunga">Rp 0</span>
                                            </div>
                                            <div class="d-flex justify-content-between pt-2 border-top fw-bolder text-900 fs-0">
                                                <span>Total Bayar:</span>
                                                <span class="text-danger font-monospace" id="text-modal-grand-total">Rp 0</span>
                                            </div>
                                        </div>

                                        <!-- Opsi Dropdown Kas / Bank Pembayar -->
                                        <div class="mb-2">
                                            <label class="form-label fs--1 fw-semi-bold text-700">Pilih Metode Pembayaran Kas/Bank <span class="text-danger">*</span></label>
                                            <select class="form-select" name="payment_coa_code" id="payment_coa_code" required>
                                                <option value="">-- Pilih Akun Pembayaran --</option>
                                                @php
                                                $coas = DB::table('kop_fin_master_coa')->get();
                                                @endphp
                                                @foreach($coas as $coa)
                                                <option value="{{ $coa->coa_code }}">{{ $coa->coa_code }} - {{ $coa->coa_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-success btn-sm px-4" id="btn-submit-pelunasan-multi">
                                            <i class="fas fa-check-circle me-1"></i> Proses Pelunasan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">
    @if ($total + $admin == $paid + $admin)
    <span id="menu-add-data-verifikasi">
        <button class="btn btn-success float-end" id="button-penyelesaian-data-kontrak" data-code="{{ $data->kop_proses_brg_code }}">Penyelesaian Data</button>
    </span>
    @else
    <span id="menu-add-data-verifikasi">
        <!-- <button class="btn btn-success float-end" id="button-create-data-kontrak-baru" data-code="{{ $data->kop_proses_brg_code }}">Membuat Kontrak Baru</button> -->
    </span>
    @endif
</div>


<script>
    $(document).ready(function() {
        // Format mata uang rupiah client-side
        function formatRupiah(angka) {
            return 'Rp ' + parseFloat(angka).toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        // Aksi Checkbox Utama (Check All)
        $(document).on('change', '#check-all-tenor', function() {
            $('.check-tenor-item:not(:disabled)').prop('checked', this.checked);
        });

        // Pemicu Klik Tombol Utama: Menghitung Akumulasi & Membuka Modal
        $(document).on('click', '#btn-pemicu-modal-pelunasan', function(e) {
            e.preventDefault();

            let checkedItems = $('.check-tenor-item:checked');
            let jumlahBulan = checkedItems.length;

            if (jumlahBulan === 0) {
                Swal.fire('Perhatian', 'Silakan centang minimal satu bulan angsuran yang ingin dibayar.', 'warning');
                return;
            }

            let totalPokok = 0;
            let totalBunga = 0;
            let grandTotal = 0;
            let listTenor = [];

            // Kalkulasi data agregat langsung dari attribute check data item
            checkedItems.each(function() {
                totalPokok += parseFloat($(this).data('pokok'));
                totalBunga += parseFloat($(this).data('bunga'));
                grandTotal += parseFloat($(this).data('total'));
                listTenor.push($(this).data('tenor'));
            });

            // Tembakkan hasil perhitungan ke elemen UI Modal
            $('#text-modal-jumlah-bulan').text(jumlahBulan + ' Bulan (Tenor Ke: ' + listTenor.join(', ') + ')');
            $('#text-modal-total-pokok').text(formatRupiah(totalPokok));
            $('#text-modal-total-bunga').text(formatRupiah(totalBunga));
            $('#text-modal-grand-total').text(formatRupiah(grandTotal));

            // Bersihkan data lama pada kolom pilihan COA modal
            $('#payment_coa_code').val('');

            // Tampilkan komponen Modal Bootstrap
            $('#modalKonfirmasiPelunasanBarang').modal('show');
        });

        // Aksi Final: Pengiriman Request Transaksi Massal via AJAX
        $(document).on('click', '#btn-submit-pelunasan-multi', function(e) {
            e.preventDefault();

            let kontrakCode = $('#menu-data-show-peminjaman-baru').data('kontrak-code');
            let coaSelected = $('#payment_coa_code').val();

            if (!coaSelected) {
                Swal.fire('Perhatian', 'Silakan tentukan Metode Pembayaran (Akun COA) terlebih dahulu.', 'warning');
                return;
            }

            // Tutup modal agar user tidak melakukan double-click submit
            $('#modalKonfirmasiPelunasanBarang').modal('hide');

            Swal.fire({
                title: 'Memproses Pembayaran',
                text: 'Sedang mendaftarkan jurnal pelunasan barang...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Serialisasikan seluruh data form input checkbox
            let formData = $('#form-pelunasan-multi-barang').serializeArray();
            formData.push({
                name: "kop_proses_brg_code",
                value: kontrakCode
            });

            $.ajax({
                url: "{{ route('menu_peminjaman_list_barang_cek_status_kontrak_payment_multi') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Pelunasan Berhasil!', response.message, 'success').then(() => {
                            location.reload(); // Refresh halaman untuk memperbarui status dan BKM
                        });
                    } else {
                        Swal.fire('Gagal', response.message, 'error').then(() => {
                            $('#modalKonfirmasiPelunasanBarang').modal('show');
                        });
                    }
                },
                error: function(xhr) {
                    let err = xhr.responseJSON;
                    Swal.fire('Sistem Error', err.message || 'Terjadi gangguan koneksi pada server.', 'error').then(() => {
                        $('#modalKonfirmasiPelunasanBarang').modal('show');
                    });
                }
            });
        });
    });
</script>
