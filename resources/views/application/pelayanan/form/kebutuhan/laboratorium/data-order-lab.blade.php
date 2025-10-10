  @if (!$list->isEmpty())
  <div class="card-body" id="menu-harga-pemeriksaan">
      <table class="table table-borderless fs--1 mb-0">
          @php
          $total = 0;
          @endphp
          <thead class="bg-300">
              <tr>
                  <th>Desc</th>
                  <th>#</th>
                  <th class="text-end">Total</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($list as $lists)
              <tr class="border-bottom">
                  <th class="ps-0 pt-0 text-primary">{{$lists->t_pemeriksaan_list_name}}
                      <div class="text-400 fw-normal fs--2">Normal Price : @currency($lists->order_lab_log_price) Disc. {{$lists->order_lab_log_discount}} %</div>
                  </th>
                  <th>
                      <button class="btn btn-danger btn-sm" id="button-remove-data-pemeriksaan-pasien" data-code="{{ $lists->order_lab_log_code }}" data-reg="{{ $lists->d_reg_order_code }}"><span class="fas fa-trash-alt"></span></button>
                  </th>
                  <th class="pe-0 text-end pt-0">@currency($lists->order_lab_log_price - ($lists->order_lab_log_discount*$lists->order_lab_log_price/100))</th>
              </tr>
              @php
              $total = $total + $lists->order_lab_log_price - ($lists->order_lab_log_discount*$lists->order_lab_log_price/100);
              @endphp
              @endforeach
          </tbody>
          <!-- <tr class="border-bottom">
              <th class="ps-0">Subtotal</th>
              <th class="pe-0 text-end">$3355</th>
          </tr>
          <tr class="border-bottom">
              <th class="ps-0">Coupon: <span class="text-success">40SITEWIDE</span></th>
              <th class="pe-0 text-end">-$55</th>
          </tr>
          <tr class="border-bottom">
              <th class="ps-0">Shipping</th>
              <th class="pe-0 text-end">$20</th>
          </tr>
          <tr>
              <th class="ps-0 pb-0">Total</th>
              <th class="pe-0 text-end pb-0">$3320</th>
          </tr> -->
      </table>
  </div>
  <div class="card-footer d-flex justify-content-between bg-light">
      <div class="fw-semi-bold">Payable Total</div>
      <div class="fw-bold">@currency($total)</div>
  </div>
  <div class="row card-body">
      <div class="col-md-7 col-xl-12 col-xxl-7 px-md-3 mb-xxl-0 position-relative">
          <div class="d-flex"><img class="me-3" src="../../asset/img/icons/shield.png" alt="" width="60" height="60" />
              <div class="flex-1">
                  <h5 class="mb-2">Buyer Protection</h5>
                  <div class="form-check mb-0">
                      <input class="form-check-input" id="protection-option-1" type="checkbox" checked="checked" />
                      <label class="form-check-label mb-0" for="protection-option-1"> <strong>Full Refund </strong>If you don't <br class="d-none d-md-block d-lg-none" />receive your order</label>
                  </div>
                  <div class="form-check">
                      <input class="form-check-input" id="protection-option-2" type="checkbox" checked="checked" />
                      <label class="form-check-label mb-0" for="protection-option-2"> <strong>Full or Partial Refund, </strong>If the product is not as described in details</label>
                  </div>
              </div>
          </div>
          <div class="vertical-line d-none d-md-block d-xl-none d-xxl-block"> </div>
      </div>
      <div class="col-md-5 col-xl-12 col-xxl-5 ps-lg-4 ps-xl-2 ps-xxl-5 text-center text-md-start text-xl-center text-xxl-start">
          <div class="border-dashed-bottom d-block d-md-none d-xl-block d-xxl-none my-4"></div>
          <div class="fs-2 fw-semi-bold">All Total: <span class="text-primary">@currency($total)</span></div>
          <button class="btn btn-success mt-3 px-5" type="submit" id="button-fix-registrasi-lab">Confirm &amp; Create Bill</button>
          <p class="fs--1 mt-3 mb-0">By clicking <strong>Confirm & Pay </strong>button you agree to the <a href="#!">Terms &amp; Conditions</a></p>
      </div>
  </div>
  @endif
