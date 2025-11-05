<div class="modal-body p-0">
    <div class="bg-primary rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" style="color: white;" id="staticBackdropLabel">Data Registrasi Pasien</h4>
        <p class="fs--2 mb-0" style="color: white;">Support by <a class="link-600 fw-semi-bold"
                href="#!">{{ Env('APP_LABEL')}}</a>
        </p>
    </div>
    <div class="p-4">
        <div class="row g-3">
            <div class="col-12">
                <div class="accordion" id="accordionExample">
                    @php
                        $no = $data->count();
                    @endphp
                    @foreach ($data as $datas)
                        <div class="accordion-item bg-200">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{$datas->id_d_reg_order}}" aria-expanded="true"
                                    aria-controls="collapse2">
                                    Pemeriksaan ke {{ $no-- }} - {{ $datas->d_reg_order_date }} -
                                    {{ $datas->t_layanan_cat_name }}
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapse{{$datas->id_d_reg_order}}"
                                aria-labelledby="heading2" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="card p-3">
                                        <h6 class="mb-3 text-primary">Instructions for Processing: </h6>
                                        <table class="table table-striped table-bordered">
                                            <tbody>
                                                <tr class="bg-300">
                                                    <td><strong>Description</strong></td>
                                                    <td><strong>Details</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Subject matter of the processing </td>
                                                    <td>Providing the Customer with bulk email sending via the Falcon
                                                        platform.</td>
                                                </tr>
                                                <tr>
                                                    <td>Duration of the processing </td>
                                                    <td>For the duration of the Agreement</td>
                                                </tr>
                                                <tr>
                                                    <td>Nature and purposes of the processing</td>
                                                    <td>Sending campaigns through the Falcon platform storing email
                                                        addresses provided through one of our forms or integrations. Storing
                                                        data on recipient behavior, whether they click, open, unsubscribe,
                                                        bounce when a campaign is sent. Actioning on the Customer’s behalf
                                                        any ‘unsubscribe’ requests from recipients of messages sent using
                                                        the Service.</td>
                                                </tr>
                                                <tr>
                                                    <td>Type of Personal Data </td>
                                                    <td>Email address, Customer IP Address, First Name, Last Name, Timezone
                                                        and any other personal data provided through a custom field.</td>
                                                </tr>
                                                <tr>
                                                    <td>Categories of Data Subject</td>
                                                    <td>Recipients of the emails as specified when creating a campaign</td>
                                                </tr>
                                                <tr>
                                                    <td>Plan for return and destruction of the data once the Customer wants
                                                        to destroy them UNLESS there is a requirement under EU or applicable
                                                        EU Member State law to preserve that type of data</td>
                                                    <td>Campaign data (Sent, Delivered, Fails, Bounces, Opens, Clicks,
                                                        Revenues, Sells, Complaints, Unsubscribes), Customer data (email
                                                        addresses, first name, last name, timezone, and any associated
                                                        custom fields) will be held forever until the request to terminate
                                                        The customer data is received.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p>IN WITNESS WHEREOF, this Addendum is entered into and becomes a binding part of
                                            the Agreement with effect from the last date of execution below.</p>
                                        <div class="row">
                                            <div class="col-6">
                                                <p><strong>Falcon</strong><br></p>
                                                <p><strong>Signature _____________________________</strong><br></p>
                                                <p><strong>Name: John Doe</strong><br></p>
                                                <p><strong>Title: CEO</strong><br></p>
                                                <p><strong>Date Signed: </strong></p>
                                            </div>
                                            <div class="col-6">
                                                <p><strong>Customer: </strong><br></p>
                                                <p><strong>Signature _____________________________</strong><br></p>
                                                <p><strong>Name: </strong><br></p>
                                                <p><strong>Title: </strong><br></p>
                                                <p><strong>Date Signed: </strong></p>
                                            </div>
                                        </div>
                                        <p>Last update: 04 Nov 2020</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer px-4 bg-300">

</div>
