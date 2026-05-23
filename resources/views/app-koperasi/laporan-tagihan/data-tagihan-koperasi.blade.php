<div class="card" id="customersTable"
    data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
    <div class="card-header bg-primary">
        <div class="row flex-between-center">
            <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">-</h5>
            </div>
            <div class="col-8 col-sm-auto text-end ps-2">
                <div class="d-none" id="table-customers-actions">
                    <div class="d-flex">
                        <select class="form-select form-select-sm" aria-label="Bulk actions">
                            <option selected="">Bulk actions</option>
                            <option value="Refund">Refund</option>
                            <option value="Delete">Delete</option>
                            <option value="Archive">Archive</option>
                        </select>
                        <button class="btn btn-falcon-default btn-sm ms-2" type="button">Apply</button>
                    </div>
                </div>
                <div id="table-customers-replace-element">
                    <button class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-plus"
                            data-fa-transform="shrink-3 down-2"></span><span
                            class="d-none d-sm-inline-block ms-1">New</span></button>
                    <button class="btn btn-falcon-default btn-sm mx-2" type="button"><span class="fas fa-filter"
                            data-fa-transform="shrink-3 down-2"></span><span
                            class="d-none d-sm-inline-block ms-1">Filter</span></button>
                    <button class="btn btn-falcon-default btn-sm" type="button"><span class="fas fa-external-link-alt"
                            data-fa-transform="shrink-3 down-2"></span><span
                            class="d-none d-sm-inline-block ms-1">Export</span></button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0 mb-3 mt-3">
        <div class="table-responsive">
            <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden" id="data-ledger">
                <thead class="bg-200 text-900 fs--2">
                    <tr>
                        <th class="align-middle white-space-nowrap">No</th>
                        <th class="align-middle white-space-nowrap">Name</th>
                        <th class="align-middle white-space-nowrap">Cabang</th>
                        <th class="text-end white-space-nowrap">Simpanan Pokok</th>
                        <th class="text-end white-space-nowrap">Simpanan Wajib</th>
                        <th class="text-end white-space-nowrap">Simpanan Sukarela</th>
                        <th class="text-end white-space-nowrap">Peminjaman Uang</th>
                        <th class="align-middle white-space-nowrap">Peminjaman Barang</th>
                        <th class="align-middle white-space-nowrap">Fren</th>
                        <th class="text-end white-space-nowrap">Vocher</th>
                        <th class="text-end white-space-nowrap">Arisan</th>
                        <th class="text-end white-space-nowrap">Nominal Total</th>

                    </tr>
                </thead>
                <tbody class="list fs--2">
                    @php
                    $no = 1;
                    $total_pokok = 0;
                    $total_wajib = 0;
                    $total_sukarela = 0;
                    $total_all = 0;
                    @endphp
                    @foreach ($peserta as $pes)
                    @php

                    $pokok = DB::table('kop_peserta_sim_pok')
                    ->join('kop_simpanan_pokok','kop_simpanan_pokok.kop_simpanan_pokok_code','=','kop_peserta_sim_pok.kop_simpanan_pokok_code')
                    ->where('kop_master_peserta_code',$pes->kop_master_peserta_code)
                    ->sum('kop_simpanan_pokok.kop_simpanan_pokok_nominal');
                    $wajib = DB::table('kop_log_tagihan_bulan')
                    ->join('kop_tagihan_bulan_peserta','kop_tagihan_bulan_peserta.kop_tagihan_bulan_peserta_code','=','kop_log_tagihan_bulan.kop_tagihan_bulan_peserta_code')
                    ->where('kop_master_peserta_code',$pes->kop_master_peserta_code)
                    ->sum('kop_log_tagihan_bulan.kop_log_tagihan_bulan_nominal');
                    $sukarela = DB::table('kop_log_simpanan_sukarela')
                    ->join('kop_simpanan_sukarela','kop_simpanan_sukarela.kop_simpanan_sukarela_code','=','kop_log_simpanan_sukarela.kop_simpanan_sukarela_code')
                    ->where('kop_master_peserta_code',$pes->kop_master_peserta_code)
                    ->sum('kop_log_simpanan_sukarela.kop_log_simpanan_sukarela_nominal');
                    $vocher = DB::table('kop_log_vocher')
                    ->join('kop_vocher_data','kop_vocher_data.kop_vocher_data_code','=','kop_log_vocher.kop_vocher_data_code')
                    ->where('kop_master_peserta_code',$pes->kop_master_peserta_code)
                    ->sum('kop_log_vocher_nominal');
                    $pem_uang = DB::table('kop_log_peminjaman_uang')
                    ->join('kop_proses_peminjaman_uang','kop_proses_peminjaman_uang.kop_proses_uang_code','=','kop_log_peminjaman_uang.kop_proses_uang_code')
                    ->where('kop_master_peserta_code',$pes->kop_master_peserta_code)
                    ->sum('kop_log_peminjaman_uang_nominal');

                    $total = $pokok + $wajib + $vocher + $pem_uang + $sukarela;
                    $total_pokok = $total_pokok + $pokok;
                    $total_wajib = $total_wajib + $wajib;
                    $total_sukarela = $total_sukarela + $sukarela;
                    $total_all = $total_all + $total;
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $pes->kop_master_peserta_name }}</td>
                        <td>{{ $pes->kop_master_peserta_cabang }}</td>
                        <td class="text-end">@currency($pokok)</td>
                        <td class="text-end">@currency($wajib)</td>
                        <td class="text-end">@currency($sukarela)</td>
                        <td class="text-end">@currency($pem_uang)</td>
                        <td class="text-end">@currency(0)</td>
                        <td class="text-end">@currency(0)</td>
                        <td class="text-end"> @currency($vocher)</td>
                        <td class="text-end">@currency(0)</td>
                        <td class="text-end">@currency($total)</td>

                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="align-middle white-space-nowrap"></th>
                        <th class="align-middle white-space-nowrap"></th>
                        <th class="align-middle white-space-nowrap">Total</th>
                        <th class="text-end white-space-nowrap">@currency($total_pokok)</th>
                        <th class="text-end white-space-nowrap">@currency($total_wajib)</th>
                        <th class="text-end white-space-nowrap">@currency($total_sukarela)</th>
                        <th class="text-end white-space-nowrap">@currency(0)</th>
                        <th class="text-end white-space-nowrap">@currency(0)</th>
                        <th class="text-end white-space-nowrap">@currency(0)</th>
                        <th class="text-end white-space-nowrap">@currency(0)</th>
                        <th class="text-end white-space-nowrap">@currency(0)</th>
                        <th class="text-end white-space-nowrap">@currency($total_all)</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    new DataTable('#data-ledger', {
        responsive: true,
        "lengthMenu": [
            [100, 50, 25],
            [100, 50, 25]
        ],
        layout: {
            topStart: {
                buttons: [{
                    extend: 'excel',
                    exportOptions: {
                        orthogonal: 'export'
                    },
                    text: 'Export Excel',
                    title: 'Data Laporan Keuangan'
                }],
            }
        }
    });
</script>
