@extends('layouts.layouts')
@section('base.css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    :root {
        --retro-dark: #1e1e24;
        --retro-yellow: #ffde59;
        --retro-cyan: #8bf0fa;
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
        background: linear-gradient(135deg, #2b5876 0%, #4e4376 100%);
        border: var(--retro-border);
        border-radius: 12px;
        box-shadow: var(--retro-shadow);
        color: white;
    }

    .retro-btn {
        font-weight: 800 !important;
        border: 2px solid var(--retro-dark);
        box-shadow: var(--retro-shadow-sm);
        border-radius: 6px;
        text-transform: uppercase;
        cursor: pointer;
    }

    .retro-btn-primary {
        background-color: var(--retro-cyan);
        color: var(--retro-dark);
    }

    .retro-btn-warning {
        background-color: var(--retro-yellow);
        color: var(--retro-dark);
    }

    .retro-btn-success {
        background-color: var(--retro-green);
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
        font-size: 0.8rem !important;
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
            <div class="card-body p-4 text-white">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="p-2 rounded-4 me-3 d-flex align-items-center justify-content-center"
                            style="width: 65px; height: 65px; background: white; border: 2px solid var(--retro-dark); box-shadow: 3px 3px 0px var(--retro-dark);">
                            <i class="fas fa-history text-warning fs-2"></i>
                        </div>
                        <div>
                            <span class="retro-badge mb-1 d-inline-block bg-warning text-dark">Manajemen Farmasi</span>
                            <h3 class="fw-bolder mb-0 text-white" style="font-size: 1.4rem;">History Penjualan Obat</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER RANGE TANGGAL & PENCARIAN NO NOTA -->
<div class="retro-card mb-4 p-3 bg-white">
    <form method="GET" action="">
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <label class="form-label fs--1 fw-bold text-dark">Dari Tanggal</label>
                <input class="form-control form-control-sm datetimepicker retro-input" type="text" name="start_date" value="{{ $startDate ?? date('Y-m-01') }}" data-options='{"dateFormat":"Y-m-d"}'>
            </div>
            <div class="col-md-3">
                <label class="form-label fs--1 fw-bold text-dark">Sampai Tanggal</label>
                <input class="form-control form-control-sm datetimepicker retro-input" type="text" name="end_date" value="{{ $endDate ?? date('Y-m-d') }}" data-options='{"dateFormat":"Y-m-d"}'>
            </div>
            <div class="col-md-4">
                <label class="form-label fs--1 fw-bold text-dark">Cari No. Order / Nota</label>
                <input class="form-control form-control-sm retro-input" type="text" name="keyword" value="{{ $keyword ?? '' }}" placeholder="Masukkan No Nota...">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn retro-btn retro-btn-warning btn-sm w-100 fw-bold" style="height: 38px;"><span class="fas fa-search me-1"></span> Filter</button>
            </div>
        </div>
    </form>
</div>

<!-- MAIN TABLE -->
<div class="retro-card mb-4">
    <div class="card-header bg-white border-bottom border-dark d-flex justify-content-between align-items-center py-3 px-3" style="border-bottom: var(--retro-border) !important;">
        <h5 class="fw-bolder mb-0 text-dark"><i class="fas fa-list-alt text-success me-2"></i> Data Riwayat Penjualan</h5>

    </div>
    <div class="card-body p-3 bg-white">
        <div class="table-responsive">
            <table id="example" class="table table-custom align-middle w-100 mb-0" style="border: 2px solid var(--retro-dark);">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>No Order / Nota</th>
                        <th>Tanggal Order</th>
                        <th>Type Order</th>
                        <th>List Obat</th>
                        <th class="text-end">Total Pembayaran</th>
                        <th class="text-center">Status Pembayaran</th>
                        <th class="text-center" style="width: 100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td><span class="fw-bold text-success">{{ $datas->farm_order_data_code }}</span></td>
                        <td>{{ $datas->farm_order_data_date }}</td>
                        <td>
                            @if ($datas->farm_order_data_type == 'NON RESEP')
                            <span class="retro-badge bg-warning text-dark">NON RESEP</span>
                            @else
                            @php
                            $pasien = DB::table('farm_order_data_pasien')->where('farm_order_data_code',$datas->farm_order_data_code)->first();
                            @endphp
                            <span class="retro-badge bg-primary text-white">RESEP</span> <br>
                            @if ($pasien)
                            <strong class="text-dark fs--1">{{ $pasien->farm_order_data_pasien_name }}</strong>
                            @endif
                            @endif
                        </td>
                        <td>
                            <ul class="list-unstyled mb-0">
                                @php
                                $total = 0;
                                $list = DB::table('farm_order_data_list')
                                ->join('farm_data_obat', 'farm_data_obat.farm_data_obat_code', '=', 'farm_order_data_list.farm_data_obat_code')
                                ->where('farm_order_data_code', $datas->farm_order_data_code)->get();
                                @endphp
                                @foreach ($list as $lists)
                                <li class="mb-1">
                                    <span class="fw-bold text-dark">- {{ $lists->farm_data_obat_name }}</span><br>
                                    <small class="text-muted">@currency($lists->farm_order_data_list_price) x {{ $lists->farm_order_data_list_qty }}</small>
                                </li>
                                @php
                                $total = $total + ($lists->farm_order_data_list_price * $lists->farm_order_data_list_qty);
                                @endphp
                                @endforeach
                            </ul>
                        </td>
                        <td class="text-end fw-bolder text-danger">@currency($total)</td>
                        <td class="text-center"><span class="retro-badge bg-warning text-dark">Pending</span></td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn retro-btn retro-btn-warning btn-sm dropdown-toggle py-1 px-2" id="btnAction"
                                    type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="fas fa-bars me-1"></span> Aksi
                                </button>
                                <div class="dropdown-menu border-dark shadow-sm" aria-labelledby="btnAction">
                                    <button class="dropdown-item fw-bold" data-bs-toggle="modal" data-bs-target="#modal-riwayat"
                                        id="button-data-riwayat-penjualan" data-code="{{$datas->farm_order_data_code}}">
                                        <span class="fas fa-eye me-2 text-primary"></span> Show Data
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('base.js')
<div class="modal fade" id="modal-riwayat-full" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 95%;">
        <div class="modal-content border-0 retro-card">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-riwayat-full"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-riwayat" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content border-0 retro-card">
            <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="menu-riwayat"></div>
        </div>
    </div>
</div>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
<script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
<script src="{{ asset('asset/js/flatpickr.js') }}"></script>
<script>
    new DataTable('#example', {
        responsive: true
    });
</script>
<script>
    $(document).on("click", "#button-data-riwayat-penjualan", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        $.ajax({
            url: "{{ route('penjualan_history_penjualan_detail') }}",
            type: "POST",
            cache: false,
            data: {
                "_token": "{{ csrf_token() }}",
                "code": code,
            },
            dataType: 'html',
        }).done(function(data) {
            $('#menu-riwayat').html(data);
        }).fail(function() {
            $('#menu-riwayat').html('eror');
        });
    });
</script>
@endsection
