@extends('layouts.template')
@section('content')
<div class="card mb-3">
    <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(../../assets/img/icons/spot-illustrations/corner-4.png);">
    </div>
    <!--/.bg-holder-->

    <div class="card-body position-relative">
        <div class="row">
            <div class="col-lg-8">
                <h3>FAQ Accordion</h3>
                <p class="mb-0">Below you'll find answers to the questions we get <br class="d-none.d-sm-block"> asked the most about to join with Falcon</p>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="accordion border-x border-top rounded" id="accordionFaq">
            <div class="card shadow-none border-bottom rounded-bottom-0">
                <div class="card-header p-0" id="faqAccordionHeading1">
                    <button class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 border-0 text-start collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion1" aria-expanded="false" aria-controls="collapseFaqAccordion1"><svg class="svg-inline--fa fa-caret-right fa-w-6 accordion-icon me-3" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" data-fa-i2svg="" style="transform-origin: 0.1875em 0.5em;">
                            <g transform="translate(96 256)">
                                <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                    <path fill="currentColor" d="M0 384.662V127.338c0-17.818 21.543-26.741 34.142-14.142l128.662 128.662c7.81 7.81 7.81 20.474 0 28.284L34.142 398.804C21.543 411.404 0 402.48 0 384.662z" transform="translate(-96 -256)"></path>
                                </g>
                            </g>
                        </svg><!-- <span class="fas fa-caret-right accordion-icon me-3" data-fa-transform="shrink-2"></span> Font Awesome fontawesome.com --><span class="fw-medium font-sans-serif text-900">How long do payouts take?</span></button>
                </div>
                <div class="bg-light collapse" id="collapseFaqAccordion1" aria-labelledby="faqAccordionHeading1" data-parent="#accordionFaq" style="">
                    <div class="card-body">
                        <p class="ps-4 mb-0">Once you’re set up, payouts arrive in your bank account on a 2-day rolling basis. Or you can opt to receive payouts weekly or monthly.</p>
                    </div>
                </div>
            </div>
            <div class="card shadow-none border-bottom rounded-0">
                <div class="card-header p-0" id="faqAccordionHeading2">
                    <button class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed border-0 text-start" data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion2" aria-expanded="false" aria-controls="collapseFaqAccordion2"><svg class="svg-inline--fa fa-caret-right fa-w-6 accordion-icon me-3" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" data-fa-i2svg="" style="transform-origin: 0.1875em 0.5em;">
                            <g transform="translate(96 256)">
                                <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                    <path fill="currentColor" d="M0 384.662V127.338c0-17.818 21.543-26.741 34.142-14.142l128.662 128.662c7.81 7.81 7.81 20.474 0 28.284L34.142 398.804C21.543 411.404 0 402.48 0 384.662z" transform="translate(-96 -256)"></path>
                                </g>
                            </g>
                        </svg><!-- <span class="fas fa-caret-right accordion-icon me-3" data-fa-transform="shrink-2"></span> Font Awesome fontawesome.com --><span class="fw-medium font-sans-serif text-900">How do refunds work?</span></button>
                </div>
                <div class="collapse bg-light" id="collapseFaqAccordion2" aria-labelledby="faqAccordionHeading2" data-parent="#accordionFaq">
                    <div class="card-body">
                        <p class="ps-4 mb-0">You can issue either partial or full refunds. There are no fees to refund a charge, but the fees from the original charge are not returned.</p>
                    </div>
                </div>
            </div>
            <div class="card shadow-none border-bottom rounded-0">
                <div class="card-header p-0" id="faqAccordionHeading3">
                    <button class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed border-0 text-start" data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion3" aria-expanded="false" aria-controls="collapseFaqAccordion3"><svg class="svg-inline--fa fa-caret-right fa-w-6 accordion-icon me-3" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" data-fa-i2svg="" style="transform-origin: 0.1875em 0.5em;">
                            <g transform="translate(96 256)">
                                <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                    <path fill="currentColor" d="M0 384.662V127.338c0-17.818 21.543-26.741 34.142-14.142l128.662 128.662c7.81 7.81 7.81 20.474 0 28.284L34.142 398.804C21.543 411.404 0 402.48 0 384.662z" transform="translate(-96 -256)"></path>
                                </g>
                            </g>
                        </svg><!-- <span class="fas fa-caret-right accordion-icon me-3" data-fa-transform="shrink-2"></span> Font Awesome fontawesome.com --><span class="fw-medium font-sans-serif text-900">How much do disputes costs?</span></button>
                </div>
                <div class="collapse bg-light" id="collapseFaqAccordion3" aria-labelledby="faqAccordionHeading3" data-parent="#accordionFaq">
                    <div class="card-body">
                        <p class="ps-4 mb-0">Disputed payments (also known as chargebacks) incur a $15.00 fee. If the customer’s bank resolves the dispute in your favor, the fee is fully refunded.</p>
                    </div>
                </div>
            </div>
            <div class="card shadow-none border-bottom">
                <div class="card-header p-0" id="faqAccordionHeading4">
                    <button class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed border-0 text-start" data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion4" aria-expanded="false" aria-controls="collapseFaqAccordion4"><svg class="svg-inline--fa fa-caret-right fa-w-6 accordion-icon me-3" data-fa-transform="shrink-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" data-fa-i2svg="" style="transform-origin: 0.1875em 0.5em;">
                            <g transform="translate(96 256)">
                                <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                    <path fill="currentColor" d="M0 384.662V127.338c0-17.818 21.543-26.741 34.142-14.142l128.662 128.662c7.81 7.81 7.81 20.474 0 28.284L34.142 398.804C21.543 411.404 0 402.48 0 384.662z" transform="translate(-96 -256)"></path>
                                </g>
                            </g>
                        </svg><!-- <span class="fas fa-caret-right accordion-icon me-3" data-fa-transform="shrink-2"></span> Font Awesome fontawesome.com --><span class="fw-medium font-sans-serif text-900">Is there a fee to use Apple Pay or Google Pay?</span></button>
                </div>
                <div class="collapse bg-light" id="collapseFaqAccordion4" aria-labelledby="faqAccordionHeading4" data-parent="#accordionFaq">
                    <div class="card-body">
                        <p class="ps-4 mb-0">There are no additional fees for using our mobile SDKs or to accept payments using consumer wallets like Apple Pay or Google Pay.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
