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
                        <th class="align-middle white-space-nowrap">Post ID</th>
                        <th class="align-middle white-space-nowrap">Account</th>
                        <th class="align-middle white-space-nowrap">Debit ( IDR )</th>
                        <th class="align-middle white-space-nowrap">Credit ( IDR )</th>
                        <th class="align-middle white-space-nowrap">Balance ( IDR )</th>
                        <th class="align-middle">Vocher Type</th>
                        <th>Voucher Subtype</th>
                        <th class="align-middle white-space-nowrap">Voucher No</th>
                        <th>Aggaints Account</th>
                        <th>Party Type</th>
                        <th>Party</th>
                        <th>Cost Center</th>
                        <th>Aggaints Vocher Type</th>
                        <th>Aggaints Vocher</th>
                        <th>Supplier</th>
                    </tr>
                </thead>
                <tbody class="list fs--2" >
                    <tr class="btn-reveal-trigger">
                        <td class="align-middle py-2 white-space-nowrap">D002</td>
                        <td class="align-middle white-space-nowrap">
                            <a href="#">
                                <div class="d-flex d-flex align-items-center">
                                    <div class="avatar avatar-l me-2">
                                        <div class="avatar-name rounded-circle"><span>BK</span></div>
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="mb-0 fs--2">BEBAN KELUARGA</h5>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td class="align-middle py-2 white-space-nowrap">@currency(423000000)</td>
                        <td class="align-middle py-2 white-space-nowrap">@currency(4210000)</td>
                        <td class="align-middle py-2 white-space-nowrap">@currency(533000000)</td>

                        <td class="align-middle">Sales Invoice</td>
                        <td class="joined align-middle py-2">Asuransi</td>
                        <td class="joined align-middle py-2">INV-PA-0293-2025</td>
                        <td class="joined align-middle py-2">Stock Rechive</td>
                        <td class="joined align-middle py-2">Supplier</td>
                        <td class="joined align-middle py-2">Bote Jirsa</td>
                        <td class="joined align-middle py-2">-</td>
                        <td class="joined align-middle py-2">-</td>
                        <td class="joined align-middle py-2">-</td>
                        <td class="joined align-middle py-2">-</td>

                    </tr>
                    <tr class="btn-reveal-trigger">
                        <td class="align-middle py-2 white-space-nowrap">D003</td>
                        <td class="name align-middle white-space-nowrap py-2"><a href="#">
                                <div class="d-flex d-flex align-items-center">
                                    <div class="avatar avatar-l me-2">
                                        <div class="avatar-name rounded-circle"><span>PP</span></div>
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="mb-0 fs--2">PENDAPATAN POLIKLINIK</h5>
                                    </div>
                                </div>
                            </a></td>
                        <td class="align-middle py-2 white-space-nowrap">@currency(223000000)</td>
                        <td class="align-middle py-2 white-space-nowrap">@currency(23000000)</td>
                        <td class="align-middle py-2 white-space-nowrap">@currency(233000000)</td>

                        <td class="white-space-nowrap">Sales Invoice</td>
                        <td class="joined align-middle py-2">-</td>
                        <td class="joined align-middle py-2">INV-GA-0293-2025</td>
                        <td class="joined align-middle py-2">Stock Kocor</td>
                        <td class="joined align-middle py-2">Supplier</td>
                        <td class="joined align-middle py-2">Boti A</td>
                        <td class="joined align-middle py-2">-</td>
                        <td class="joined align-middle py-2">-</td>
                        <td class="joined align-middle py-2">-</td>
                        <td class="joined align-middle py-2">-</td>

                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    new DataTable('#data-ledger', {
        responsive: true
    });
</script>
