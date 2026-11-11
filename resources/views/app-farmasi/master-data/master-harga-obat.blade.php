@extends('layouts.layouts')

@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-pink: #ffa6c9;
        --retro-cyan: #8bf0fa;
        --retro-orange: #ff914d;
        --retro-green: #c1ff72;
        --retro-border: 3px solid var(--retro-dark);
        --retro-shadow: 5px 5px 0px var(--retro-dark);
        --retro-shadow-sm: 3px 3px 0px var(--retro-dark);
    }

    .retro-card {
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        background-color: #ffffff;
        overflow: hidden;
    }

    .retro-header-banner {
        background: linear-gradient(135deg, var(--retro-yellow) 0%, var(--retro-orange) 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: var(--retro-dark);
    }

    .retro-btn {
        font-weight: 800 !important;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        transition: all 0.1s ease-in-out;
        text-transform: uppercase;
        cursor: pointer;
    }

    .retro-btn-success {
        background-color: var(--retro-green);
        color: var(--retro-dark);
    }

    .retro-btn-warning {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
    }

    .retro-input,
    .form-control,
    .form-select {
        border: 2px solid var(--retro-dark) !important;
        border-radius: 6px !important;
        box-shadow: 2px 2px 0px var(--retro-dark) !important;
        font-weight: 700 !important;
        color: var(--retro-dark) !important;
        background-color: #ffffff !important;
        font-size: 0.8rem !important;
    }

    .form-control:disabled {
        background-color: #e9ecef !important;
        opacity: 0.7;
    }

    .table-custom {
        font-size: 0.8rem;
        border-collapse: collapse !important;
        width: 100%;
    }

    .table-custom thead th {
        background-color: var(--retro-dark) !important;
        color: var(--retro-green) !important;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        border: 2px solid var(--retro-dark) !important;
        padding: 12px 10px;
        text-align: center;
    }

    .table-custom td {
        border: 2px solid var(--retro-dark) !important;
        font-weight: 700;
        color: var(--retro-dark);
        padding: 10px;
        vertical-align: middle;
        background-color: #ffffff;
    }

    .retro-badge {
        border: 2px solid var(--retro-dark);
        border-radius: 6px;
        padding: 4px 8px;
        font-weight: 800;
        box-shadow: 2px 2px 0px var(--retro-dark);
        text-transform: uppercase;
        font-size: 0.7rem;
    }
</style>
@endsection

@section('content')
<!-- HEADER BANNER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card retro-header-banner p-1">
            <div class="card-body p-4 text-dark">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <i class="fas fa-file-invoice-dollar text-dark fs-2"></i>
                        </div>
                        <div>
                            <span class="retro-badge mb-1 d-inline-block" style="background-color: var(--retro-cyan);">Manajemen Farmasi</span>
                            <h3 class="fw-bolder mb-0 text-dark" style="font-size: 1.4rem;">Master Harga Obat (Penjamin & Sub Penjamin)</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FORM KELOLA HARGA -->
<form id="form-master-harga-obat">
    @csrf
    <div class="retro-card mb-4 p-4 bg-white">
        <h5 class="fw-bolder mb-3 text-dark"><i class="fas fa-filter text-warning me-2"></i> Pilih Target Penjamin & Kelompok Pelanggan</h5>
        <div class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label fw-bold text-dark fs--1">Penjamin Utama</label>
                <select id="penjamin_id" name="penjamin_id" class="form-select retro-input" required>
                    <option value="">-- Pilih Penjamin Utama --</option>
                    @foreach($penjamins as $pj)
                    <option value="{{ $pj->id }}">{{ $pj->nama_penjamin }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold text-dark fs--1">Kelompok Pelanggan (Sub Penjamin)</label>
                <select id="sub_penjamin_id" name="sub_penjamin_id" class="form-select retro-input" required>
                    <option value="">-- Pilih Penjamin Utama Dulu --</option>
                </select>
            </div>
        </div>
    </div>

    <!-- MAIN TABLE HARGA OBAT -->
    <div class="retro-card mb-4">
        <div class="card-header bg-white border-bottom border-dark d-flex justify-content-between align-items-center py-3 px-3">
            <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-pills text-success me-2"></i> Daftar Harga Jual Obat & Status</h5>
            <button type="submit" class="btn retro-btn retro-btn-success btn-sm px-4 py-2">
                <i class="fas fa-save me-1"></i> Simpan Semua Perubahan
            </button>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="table-harga-obat" class="table table-custom align-middle w-100 mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th class="text-center" style="width: 90px;">Status Aktif</th>
                            <th>Kode Obat</th>
                            <th>Nama Obat</th>
                            <th>Satuan</th>
                            <th class="text-end" style="width: 250px;">Harga Jual (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($obats as $obat)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td class="text-center">
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <!-- Checkbox Status Aktif/Non-Aktif -->
                                    <input class="form-check-input toggle-status" type="checkbox" name="item[{{ $obat->farm_data_obat_code }}][status]" value="1" data-kode="{{ $obat->farm_data_obat_code }}" style="width: 40px; height: 20px; cursor: pointer;">
                                </div>
                            </td>
                            <td class="text-danger fw-bold">{{ $obat->farm_data_obat_code }}</td>
                            <td class="fw-bolder text-dark">{{ $obat->farm_data_obat_name }}</td>
                            <td><span class="retro-badge" style="background-color: var(--retro-cyan);">{{ $obat->farm_data_satuan_name ?? '-' }}</span></td>
                            <td class="text-end">
                                <!-- Input terformat rupiah, disabled secara default sampai switch diaktifkan -->
                                <input type="text" class="form-control form-control-sm retro-input text-end input-harga-format" data-kode="{{ $obat->farm_data_obat_code }}" placeholder="0" value="0" disabled>
                                <!-- Hidden input untuk nilai mentah -->
                                <input type="hidden" name="item[{{ $obat->farm_data_obat_code }}][harga]" class="input-harga-raw" data-kode="{{ $obat->farm_data_obat_code }}" value="0">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>
@endsection

@section('base.js')
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let tableHarga;
    $(document).ready(function() {
        tableHarga = $('#table-harga-obat').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Cari obat..."
            }
        });

        // Fungsi Helper Format Rupiah
        function formatRupiah(angka) {
            let numberString = String(angka).replace(/[^,\d]/g, "").toString();
            let split = numberString.split(",");
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            return split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
        }

        // Toggle Switch Aktif / Non-Aktif untuk mengontrol input harga
        $(document).on('change', '.toggle-status', function() {
            let kode = $(this).data('kode');
            let inputFormat = $(`input.input-harga-format[data-kode="${kode}"]`);

            if ($(this).is(':checked')) {
                inputFormat.prop('disabled', false).focus();
            } else {
                inputFormat.prop('disabled', true).val('0');
                $(`input.input-harga-raw[data-kode="${kode}"]`).val('0');
            }
        });

        // Event saat nilai input harga diketik
        $(document).on('input', '.input-harga-format', function() {
            let valFormatted = formatRupiah($(this).val());
            $(this).val(valFormatted);

            let kode = $(this).data('kode');
            let valRaw = valFormatted.replace(/\./g, '');
            $(`input.input-harga-raw[data-kode="${kode}"]`).val(valRaw === '' ? '0' : valRaw);
        });

        // Event Ubah Penjamin Utama -> Muat Sub Penjamin
        $('#penjamin_id').on('change', function() {
            let penjaminId = $(this).val();
            let subSelect = $('#sub_penjamin_id');
            subSelect.html('<option value="">Sedang memuat...</option>');
            $('.input-harga-format').val('0').prop('disabled', true);
            $('.input-harga-raw').val('0');
            $('.toggle-status').prop('checked', false);

            if (!penjaminId) {
                subSelect.html('<option value="">-- Pilih Penjamin Utama Dulu --</option>');
                return;
            }

            $.ajax({
                url: "{{ route('ranap.get.subpenjamin') }}",
                type: "GET",
                data: {
                    penjamin_id: penjaminId
                },
                success: function(res) {
                    let options = '<option value="">-- Pilih Kelompok Pelanggan --</option>';
                    res.forEach(function(item) {
                        options += `<option value="${item.id}">${item.nama_sub_penjamin}</option>`;
                    });
                    subSelect.html(options);
                }
            });
        });

        // Event Ubah Sub Penjamin -> Tarik data harga dan status yang tersimpan di database
        $('#sub_penjamin_id').on('change', function() {
            let subPenjaminId = $(this).val();
            $('.input-harga-format').val('0').prop('disabled', true);
            $('.input-harga-raw').val('0');
            $('.toggle-status').prop('checked', false);

            if (!subPenjaminId) return;

            $.ajax({
                url: "{{ route('manajemen_farmasi_harga_obat_get') }}",
                type: "GET",
                data: {
                    sub_penjamin_id: subPenjaminId
                },
                success: function(res) {
                    if (res.prices) {
                        $.each(res.prices, function(kodeObat, dataObj) {
                            // Jika status aktif (1), centang switch dan aktifkan input harganya
                            if (dataObj.status == 1) {
                                $(`input.toggle-status[data-kode="${kodeObat}"]`).prop('checked', true);
                                let inputFormat = $(`input.input-harga-format[data-kode="${kodeObat}"]`);
                                inputFormat.prop('disabled', false);

                                let formatted = formatRupiah(String(dataObj.harga_jual));
                                inputFormat.val(formatted);
                                $(`input.input-harga-raw[data-kode="${kodeObat}"]`).val(dataObj.harga_jual);
                            }
                        });
                    }
                }
            });
        });
    });

    // Event Submit Form Simpan Harga & Status
    $('#form-master-harga-obat').on('submit', function(e) {
        e.preventDefault();
        let subPenjamin = $('#sub_penjamin_id').val();
        if (!subPenjamin) {
            Swal.fire('Perhatian', 'Pilih Kelompok Pelanggan (Sub Penjamin) terlebih dahulu!', 'warning');
            return;
        }

        let btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: "{{ route('farmasi.harga.obat.save') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(res) {
                btn.prop('disabled', false).text('Simpan Semua Perubahan');
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message || 'Terjadi kesalahan.'
                    });
                }
            },
            error: function() {
                btn.prop('disabled', false).text('Simpan Semua Perubahan');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal menghubungi server.'
                });
            }
        });
    });
</script>
@endsection
