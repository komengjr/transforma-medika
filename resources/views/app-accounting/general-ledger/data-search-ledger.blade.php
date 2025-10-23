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
                        <th class="align-middle white-space-nowrap">Layanan</th>
                        <th class="align-middle white-space-nowrap">Debit ( IDR )</th>
                        <th class="align-middle white-space-nowrap">Credit ( IDR )</th>
                        <th class="align-middle white-space-nowrap">Balance ( IDR )</th>
                        <!-- <th class="align-middle">Vocher Type</th> -->
                        <th>Tipe Pasien</th>
                        <th class="align-middle white-space-nowrap">Nota No</th>
                        <th>Aggaints Account</th>
                        <th>Methode Payment</th>
                    </tr>
                </thead>
                <tbody class="list fs--2">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($data as $datas)
                        <tr class="btn-reveal-trigger">
                            <td class="align-middle py-2 white-space-nowrap">{{$no++}}</td>
                            <td class="align-middle white-space-nowrap">
                                <a href="#">
                                    <div class="d-flex d-flex align-items-center">
                                        <!-- <div class="avatar avatar-l me-2">
                                            <div class="avatar-name rounded-circle"><span>P</span></div>
                                        </div> -->
                                        <div class="flex-1">
                                            <h5 class="mb-0 fs--2">{{ $datas->master_patient_name }}</h5>
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td>
                                @php
                                    $layanan = DB::table('d_reg_order_list')->where('d_reg_order_code', $datas->d_reg_order_code)
                                        ->join('t_layanan_cat', 't_layanan_cat.t_layanan_cat_code', '=', 'd_reg_order_list.t_layanan_cat_code')
                                        ->get();
                                @endphp
                                @foreach ($layanan as $layanans)
                                    <li class="ms-2"><strong>{{$layanans->d_reg_order_list_code }}</strong> <br> <span
                                            class="text-warning">{{$layanans->t_layanan_cat_name}}</span></li>
                                @endforeach
                            </td>
                            @php
                                $debit = DB::table('d_reg_order_poli')
                                    ->join('m_doctor_poli', 'm_doctor_poli.m_doctor_poli_code', '=', 'd_reg_order_poli.m_doctor_poli_code')
                                    ->join('master_doctor', 'master_doctor.master_doctor_code', '=', 'm_doctor_poli.master_doctor_code')
                                    ->where('d_reg_order_poli.d_reg_order_code', $datas->d_reg_order_code)->get();
                            @endphp
                            <td class="align-top py-2 white-space-nowrap">
                                @foreach ($debit as $debits)
                                        @php
                                            $total_debit = DB::table('d_reg_order_poli_list')->where('d_reg_order_poli_code',$debits->d_reg_order_poli_code)->sum(DB::raw('order_poli_log_price - (order_poli_log_price * order_poli_log_discount / 100)'));
                                        @endphp
                                    <li class="ms-2"><strong>@currency($total_debit)</strong></li>
                                @endforeach
                            </td>
                            <td class="align-top py-2 white-space-nowrap">
                                @foreach ($debit as $debits)
                                        @php
                                            $total_kredit = DB::table('d_reg_order_payment')->where('d_reg_order_list_code',$debits->d_reg_order_poli_code)->sum('d_reg_order_payment_total');
                                        @endphp
                                    <li class="ms-2"><strong>@currency($total_kredit)</strong></li>
                                @endforeach
                            </td>
                            <td class="align-top py-2 white-space-nowrap"><strong>@currency($total_kredit-$total_debit)</strong></td>

                            <!-- <td class="align-middle">Sales Invoice</td> -->
                            <td class="joined align-middle py-2">{{$datas->t_pasien_cat_name}}</td>
                            <td class="joined align-middle py-2">INV{{$datas->d_reg_order_code}}</td>
                            <td class="joined align-middle py-2">
                                @if ($total_kredit == 0)
                                    Penagihan Poli Gigi
                                @else
                                    Pendapatan Poli Gigi
                                @endif
                            </td>
                            <td>
                                @php
                                    $payment = DB::table('d_reg_order_payment')
                                    ->join('m_pay_card','m_pay_card.m_pay_card_code','=','d_reg_order_payment.d_reg_order_payment_card')
                                    ->join('m_pay_detail','m_pay_detail.m_pay_detail_code','=','m_pay_card.m_pay_detail_code')
                                    ->where('d_reg_order_code',$datas->d_reg_order_code)->get();
                                @endphp
                                @if ($payment->isEmpty())
                                    CASH
                                @endif
                                @foreach ($payment as $pays)
                                    <li class="ms-3">{{ $pays->m_pay_detail_name }} <br>{{ $pays->m_pay_card_name }} - ( {{ $pays->m_pay_card_number }} )</li>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th class="align-middle white-space-nowrap"></th>
                        <th class="align-middle white-space-nowrap"></th>
                        <th class="align-middle white-space-nowrap">Total</th>
                        <th class="align-middle white-space-nowrap">@currency(0)</th>
                        <th class="align-middle white-space-nowrap">@currency(0)</th>
                        <th class="align-middle white-space-nowrap">@currency(0)</th>

                        <th></th>
                        <th class="align-middle white-space-nowrap"></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    new DataTable('#data-ledger', {
        responsive: true,
        "lengthMenu": [[28, 50, 25], [28, 50, 25]],
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
