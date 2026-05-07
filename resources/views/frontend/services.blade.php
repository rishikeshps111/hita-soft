<?php
$banner_path = "images/banner_image";
$brand_path = "images/brands";
$main_cat_path = "images/main_cat_image";
$product_path = "images/featured_products";
$offer_product_path = "images/offer_products";
$noimage = \DB::table("noimage_settings")->first();
$noimage_path = "images/noimage";

$index_tr_as = \DB::table("category_advertisement_settings")
    ->Where("is_block", 1)
    ->Where("payment_status", 1)
    ->Where("page", "Home Page")
    ->Where("position", "Top Right")
    ->first();
$index_cat2_as = \DB::table("category_advertisement_settings")
    ->Where("is_block", 1)
    ->Where("payment_status", 1)
    ->Where("page", "Home Category-2")
    ->Where("position", "Right")
    ->first();
$index_cat3_as = \DB::table("category_advertisement_settings")
    ->Where("is_block", 1)
    ->Where("payment_status", 1)
    ->Where("page", "Home Category-3")
    ->Where("position", "Right")
    ->first();
$middle_as = \DB::table("category_advertisement_settings")
    ->Where("is_block", 1)
    ->Where("payment_status", 1)
    ->Where("page", "Home Page")
    ->Where("position", "Middle")
    ->first();
$left_offer = \DB::table("category_advertisement_settings")
    ->Where("is_block", 1)
    ->Where("payment_status", 1)
    ->Where("page", "Home Page")
    ->Where("position", "Bottom Left")
    ->first();
$right_offer = \DB::table("category_advertisement_settings")
    ->Where("is_block", 1)
    ->Where("payment_status", 1)
    ->Where("page", "Home Page")
    ->Where("position", "Bottom Right")
    ->first();
$nw_date = date("Y-m-d");
$nw_date = date("Y-m-d", strtotime($nw_date));

if ($index_tr_as) {
    $st_date = date("Y-m-d", strtotime($index_tr_as->ad_start_date));
    $en_date = date("Y-m-d", strtotime($index_tr_as->ad_end_date));
}

if ($index_cat2_as) {
    $st_date2 = date("Y-m-d", strtotime($index_cat2_as->ad_start_date));
    $en_date2 = date("Y-m-d", strtotime($index_cat2_as->ad_end_date));
}

if ($index_cat3_as) {
    $st_date3 = date("Y-m-d", strtotime($index_cat3_as->ad_start_date));
    $en_date3 = date("Y-m-d", strtotime($index_cat3_as->ad_end_date));
}

if ($middle_as) {
    $st_date4 = date("Y-m-d", strtotime($middle_as->ad_start_date));
    $en_date4 = date("Y-m-d", strtotime($middle_as->ad_end_date));
}

if ($left_offer) {
    $st_date5 = date("Y-m-d", strtotime($left_offer->ad_start_date));
    $en_date5 = date("Y-m-d", strtotime($left_offer->ad_end_date));
}

if ($right_offer) {
    $st_date6 = date("Y-m-d", strtotime($right_offer->ad_start_date));
    $en_date6 = date("Y-m-d", strtotime($right_offer->ad_end_date));
}
?>

@extends('layouts.frontend')
@section('title', 'Services')

@section('content')
<style>

</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="gj_msg">
                @if($errors->any())
                <p class="alert alert-danger auto-dismiss" id="errorMessage">
                    {{ $errors->first() }}
                </p>
                @endif
            </div>
        </div>
    </div>
</div>



<div class="page-baner"
    style="  background-image:linear-gradient(128deg,rgba(0, 0, 0, 0.485) 0%, rgba(0, 0, 0, 0.589) 100%), url(assets/img/ab2.jpg);">
    <h3>Services</h3>
</div>
<section class="section-padding">
    <div class="container">
        <div class="row">
            @if(isset($services) && count($services) != 0)
                @foreach($services as $service)
                    <div class="col-lg-6 mb-3">
                        <div class="how-it-works-container-cs">

                            <img src="{{ asset($service->image ? $service->image : 'assets/img/no-img.jpg') }}" alt="">
                            <div>
                                <h3>{{ $service->title }}</h3>
                                <p>{{ $service->description }}</p>
                            </div>

                        </div>
                    </div>
                @endforeach
            @else
            <div class="col-lg-6 mb-3">
                <div class="how-it-works-container-cs">

                    <img src="assets/img/how-works/1.jpg" alt="">
                    <div>
                        <h3>Embedded System Design</h3>
                        <p>We design and develop embedded systems tailored for automation, ensuring accuracy,
                            efficiency, and seamless performance in real-world applications.</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="how-it-works-container-cs">

                    <img src="assets/img/how-works/2.jpg" alt="">
                    <div>
                        <h3>Water Pump Automation Solutions</h3>
                        <p>Automation systems that control pump operations based on water levels, ensuring efficient
                            usage and preventing overflow or dry run conditions.</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="how-it-works-container-cs">

                    <img src="assets/img/how-works/3.jpg" alt="">
                    <div>
                        <h3>Control Panel Manufacturing</h3>
                        <p>Design and fabrication of high-quality panel boards equipped with protection systems like
                            overload, voltage fluctuation, and phase failure safeguards.</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="how-it-works-container-cs">

                    <img src="assets/img/how-works/4.jpg" alt="">
                    <div>
                        <h3>Custom Automation Solutions</h3>
                        <p>We build customized automation systems based on specific industrial or residential
                            requirements, ensuring optimal performance and usability.</p>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="how-it-works-container-cs">

                    <img src="assets/img/how-works/5.jpg" alt="">
                    <div>
                        <h3>Maintenance & Support</h3>
                        <p>Providing technical support, maintenance, and upgrades to ensure long-term efficiency and
                            durability of all systems.</p>
                    </div>

                </div>
            </div>
            @endif
        </div>
    </div>
</section>


@endsection




@section('before_scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const errorMessage = document.getElementById('errorMessage');
        if (errorMessage) {
            setTimeout(() => {
                errorMessage.style.transition = "opacity 0.5s ease";
                errorMessage.style.opacity = 0;
                setTimeout(() => errorMessage.remove(), 500); // Remove from DOM
            }, 3000); // 3 seconds
        }
    });
</script>

@if(Session::has('newsletter_trigger'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch("{{ route('send.news_letters.email') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                console.log('Email status:', data.status);
            });
    });
</script>
@endif

@if(Session::has('signup_trigger'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch("{{ route('send.signup.email') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                console.log('Email status:', data.status);
            });
    });
</script>
@endif

<script>
    $(document).ready(function() {
        $(".Featured-carousel").owlCarousel({
            loop: false,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });
    });
</script>


@endsection
