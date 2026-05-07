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
@section('title', 'About Us')

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
    style="  background-image:linear-gradient(128deg,rgba(0, 0, 0, 0.485) 0%, rgba(0, 0, 0, 0.589) 100%), url(assets/img/baner/2.jpg);">
    <h3>Contact Us</h3>
</div>

<section class="section-padding  bg-section">
    <div class="container">
        <div class="row col-reverse">
            <div class="col-lg-4 mb-3">
                <div class="contact-us-box mb-2">

                    <ul class="contact-address">
                        <li>
                            <div class="contact-ad-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            TC 49/20-1 Pamamcode, Pappanamcode Industrial Estate PO Thiruvananthapuram, Kerala -
                            695019 India

                        </li>
                        <li class="align-items-center">
                            <div class="contact-ad-icon">
                                <i class="fa-regular fa-envelope-open"></i>
                            </div>
                            hitasoftsystems@gmail.com
                        </li>
                        <li class="align-items-center">
                            <a href="#!" target="_blank" class="contact-a">
                                <div class="contact-ad-icon">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                +91-9387737998
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="contact-us-box mb-2">
                    <div class="cnt-map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.3111668607303!2d77.0014897747738!3d8.469091891571589!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b05bb00115a96cf%3A0xbdbab5ca7c70fa2a!2sHita%20Soft%20Systems!5e0!3m2!1sen!2sin!4v1777365749512!5m2!1sen!2sin" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

            </div>
            <div class="col-lg-8 mb-3">
                <div class="contact-form">

                    <p>Please complete the form below. We'll do everything we can to respond to you as quickly as
                        possible.</p>
                    <form action="" class="mt-3">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="contact-form-box">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control shadow-none" id="name">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="contact-form-box">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control shadow-none" id="email">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="contact-form-box">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control shadow-none" id="phone">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="contact-form-box">
                                    <label for="Subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control shadow-none" id="Subject">
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div class="contact-form-box">
                                    <label for="Message" class="form-label">Message</label>
                                    <textarea name="" id="Message" class="form-control shadow-none"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="button" class="contact-btn">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
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