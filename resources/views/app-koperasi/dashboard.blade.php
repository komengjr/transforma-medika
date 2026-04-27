@extends('layouts.layouts')
@section('content')
<div class="card  mb-3">
    <div class="card-header position-relative">
        <div class="bg-holder d-none d-md-block bg-card z-index-1" style="background-image:url(../../asset/img/illustrations/ecommerce-bg.png);background-size:230px;background-position:right bottom;z-index:-1;">
        </div>
        <!--/.bg-holder-->

        <div class="position-relative z-index-2">
            <div>
                <h3 class="text-primary mb-1">Welcome, {{Auth::user()->fullname}}!</h3>
                <p>Here’s what happening with your store today </p>
            </div>
            <!-- <div class="d-flex py-3">

            </div> -->
        </div>
    </div>

</div>
@endsection
