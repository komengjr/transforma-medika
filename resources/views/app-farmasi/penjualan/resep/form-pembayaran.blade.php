<style>
    .methods {
        margin: 30px;
        display: flex;
        flex-direction: column;
        gap: 12px
    }

    .method {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 12px;
        padding: 12px 14px;
        border: 1px solid #0489efff;
        cursor: pointer;
        transition: all .18s;
        background: white
    }

    .method:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(14, 30, 60, 0.06);
        background: #0489efff;
        color: #eef4ff;
    }

    .method.active {
        border-color: rgba(0, 123, 255, 0.18);
        background: #0489efff;
        color: #eef4ff;
    }

    .left {
        display: flex;
        align-items: center;
        gap: 12px
    }

    .left .label {
        font-weight: 600
    }

    .icons {
        display: flex;
        gap: 8px;
        align-items: center
    }

    .icon-wrap {
        width: 44px;
        height: 28px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(15, 23, 42, 0.03);
        padding: 4px
    }

    .icons svg {
        width: 28px;
        height: 18px
    }

    .details {
        margin-top: 18px;
        padding: 14px;
        border-radius: 10px;
        background: #fbfdff;
        border: 1px solid #eef4ff;
        color: #334155;
        display: none
    }

    .details.show {
        display: block
    }

    .summary {
        margin-top: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px
    }

    .price {
        font-weight: 700;
        font-size: 18px
    }

    /* .btn {
        border: 0;
        padding: 12px 16px;
        border-radius: 10px;
        background: linear-gradient(90deg, var(--primary1), var(--primary2));
        color: #fff;
        font-weight: 700;
        cursor: pointer
    } */

    @media (max-width:520px) {
        .icons {
            gap: 6px
        }

        .icon-wrap {
            width: 36px;
            height: 24px
        }

        .icons svg {
            width: 22px;
            height: 14px
        }
    }
</style>

<div class="methods">
    <h4>Pilih Metode Pembayaran</h4>
    <div class="row">
        <div class="col-md-6">
            <label class="method" data-key="cod" id="button-pilih-method">
                <div class="left">
                    <div class="label">Bayar di Tempat (COD)</div>
                </div>
                <div class="icons">
                    <div class="icon-wrap" title="Tunai"> <!-- Cash SVG -->
                        <svg viewBox="0 0 24 18" xmlns="http://www.w3.org/2000/svg">
                            <rect width="24" height="18" rx="3" fill="#f3f9f6" />
                            <path d="M6 5h12v8H6z" fill="#bbf7d0" />
                            <circle cx="12" cy="9" r="2" fill="#10b981" />
                        </svg>
                    </div>
                </div>
            </label>
            <label class="method" data-key="bank" id="button-pilih-method">
                <div class="left">
                    <div class="label">Transfer Bank (VA)</div>
                </div>
                <div class="icons">
                    <div class="icon-wrap" title="BCA"> <!-- BCA SVG -->
                        <svg viewBox="0 0 24 8" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect width="24" height="8" rx="1" fill="#012169" /><text x="4" y="5.9" font-size="4"
                                fill="#fff" font-family="Arial" font-weight="700">BCA</text>
                        </svg>
                    </div>
                    <div class="icon-wrap" title="BNI"> <!-- BNI SVG -->
                        <svg viewBox="0 0 24 8" xmlns="http://www.w3.org/2000/svg">
                            <rect width="24" height="8" rx="1" fill="#e60012" /><text x="3" y="5.7" font-size="4"
                                fill="#fff" font-family="Arial" font-weight="700">BNI</text>
                        </svg>
                    </div>
                    <div class="icon-wrap" title="BRI"> <!-- BRI SVG -->
                        <svg viewBox="0 0 24 8" xmlns="http://www.w3.org/2000/svg">
                            <rect width="24" height="8" rx="1" fill="#0033a0" /><text x="3" y="5.7" font-size="4"
                                fill="#fff" font-family="Arial" font-weight="700">BRI</text>
                        </svg>
                    </div>
                </div>
            </label>

            <label class="method" data-key="ewallet" id="button-pilih-method">
                <div class="left">
                    <div class="label">E‑Wallet</div>
                </div>
                <div class="icons">
                    <div class="icon-wrap" title="Gopay"> <!-- Gopay SVG -->
                        <svg viewBox="0 0 36 24" xmlns="http://www.w3.org/2000/svg">
                            <rect width="36" height="24" rx="4" fill="#1e86ff" />
                            <path d="M6 16h6v-8H6z" fill="#fff" opacity="0.08" /><text x="10" y="16" font-size="10"
                                fill="#fff" font-family="Arial" font-weight="700">GP</text>
                        </svg>
                    </div>
                    <div class="icon-wrap" title="OVO"> <!-- OVO SVG -->
                        <svg viewBox="0 0 36 24" xmlns="http://www.w3.org/2000/svg">
                            <rect width="36" height="24" rx="4" fill="#5b2b9f" /><text x="11" y="16" font-size="10"
                                fill="#fff" font-family="Arial" font-weight="700">OVO</text>
                        </svg>
                    </div>
                    <div class="icon-wrap" title="DANA"> <!-- DANA SVG -->
                        <svg viewBox="0 0 36 24" xmlns="http://www.w3.org/2000/svg">
                            <rect width="36" height="24" rx="4" fill="#1b5fff" /><text x="10" y="16" font-size="10"
                                fill="#fff" font-family="Arial" font-weight="700">DANA</text>
                        </svg>
                    </div>
                    <div class="icon-wrap" title="ShopeePay"> <!-- ShopeePay SVG -->
                        <svg viewBox="0 0 36 24" xmlns="http://www.w3.org/2000/svg">
                            <rect width="36" height="24" rx="4" fill="#ff6f3c" /><text x="7" y="16" font-size="10"
                                fill="#fff" font-family="Arial" font-weight="700">SP</text>
                        </svg>
                    </div>
                </div>
            </label>

            <label class="method" data-key="card" id="button-pilih-method">
                <div class="left">
                    <div class="label">Kartu Kredit / Debit</div>
                </div>
                <div class="icons">
                    <div class="icon-wrap" title="Visa"> <!-- Visa SVG -->
                        <svg viewBox="0 0 36 24" xmlns="http://www.w3.org/2000/svg">
                            <rect width="36" height="24" rx="4" fill="#142787" /><text x="8" y="16" font-size="10"
                                fill="#fff" font-family="Arial" font-weight="700">VISA</text>
                        </svg>
                    </div>
                    <div class="icon-wrap" title="Mastercard"> <!-- Mastercard SVG -->
                        <svg viewBox="0 0 36 24" xmlns="http://www.w3.org/2000/svg">
                            <rect width="36" height="24" rx="4" fill="#fff" />
                            <circle cx="14" cy="12" r="7" fill="#ff5f00" />
                            <circle cx="22" cy="12" r="7" fill="#eb001b" opacity="0.92" />
                        </svg>
                    </div>
                </div>
            </label>
        </div>
        <div class="col-md-6">
            <div class="card" id="menu-payment-method">
            </div>
        </div>
    </div>

</div>

<div id="details" class="details"></div>

<!-- <div class="summary mx-3">
    <div>
        <div class="muted">Total</div>
        <div class="price">Rp 185.300</div>
    </div>
    <div style="flex:0 0 160px;">
        <button id="payBtn" class="btn">Bayar Sekarang</button>
    </div>
</div> -->
@php
    $no = mt_rand(1000, 9999);
@endphp
<script>
    const labels<?php echo $no; ?> = document.querySelectorAll('.method');
    const details<?php echo $no; ?> = document.getElementById('details');
    let selectedKey<?php echo $no; ?> = null;
    function setActive(el) {
        labels<?php echo $no; ?>.forEach(l => l.classList.remove('active'));
        el.classList.add('active');
        selectedKey<?php echo $no; ?> = el.dataset.key;
        // renderDetails(selectedKey);
    }
    labels<?php echo $no; ?>.forEach(l => {
        l.addEventListener('click', () => setActive(l));
        l.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); setActive(l); } });
    });
</script>
