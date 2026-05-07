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
    style="  background-image:linear-gradient(128deg,rgba(0, 0, 0, 0.485) 0%, rgba(0, 0, 0, 0.589) 100%), url(assets/img/baner/1.jpg);">
    <h3>About Us</h3>
</div>
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="about-left">
                    <img src="assets/img/ab3.jpg" alt="">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="about-right">
                    <h3>Who We Are</h3>
                    <p>Hita Soft Systems is a specialized engineering firm based in Thiruvananthapuram, Kerala,
                        focused on the design and manufacturing of embedded software-controlled automation systems,
                        particularly for water pump management</p>
                    <p>Founded and led by CS Rajan Babu, Design Engineer, the company combines strong technical
                        expertise with practical innovation to deliver reliable, efficient, and cost-effective
                        solutions for residential, commercial, and industrial applications.</p>
                    <p>With a deep understanding of real-world challenges in water management and electrical
                        systems, we develop products that ensure automation, safety, and long-term performance.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-padding bg-light-gray" style="background-color: #e9e9e9;">
    <div class="container">
        <div class="row justify-content-end">

            <div class="col-lg-7">
                <div class="about-right abt-left-r">
                    <h3>What We Do</h3>
                    <p>We design and manufacture advanced control panel systems that automate and protect water
                        pumping operations. Our solutions are built with intelligent features such as</p>
                    <ul>
                        <li>Water level sensing automation</li>
                        <li>Dry run protection</li>
                        <li>Overload safety</li>
                        <li>High/low voltage protection</li>
                        <li>Phase failure and sequence protection</li>
                        <li>Timer-based operation control</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="about-left">
                    <img src="assets/img/ab2.jpg" alt="">
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-6 mb-2">
                <div class="mission-box">
                    <h3>Our Mission</h3>
                    <p>To deliver innovative, reliable, and energy-efficient automation solutions through advanced
                        embedded technology, ensuring safety, convenience, and long-term value for our customers.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 mb-2">
                <div class="mission-box">
                    <h3> Our Vision</h3>
                    <p>To become a trusted leader in embedded automation systems by continuously innovating and
                        providing high-quality engineering solutions that enhance everyday life and industrial
                        efficiency.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-padding ">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title">
                    <h3>Our Core Values</h3>

                </div>
            </div>
        </div>
        <div class="row mt-3 row-20">
            <div class="col-lg-3 mb-3">
                <div class="core-values">
                    <h3>Innovation</h3>
                    <p>Continuously improving and adopting new technologies</p>
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="core-values">
                    <h3>Quality</h3>
                    <p>Delivering durable and reliable products</p>
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="core-values">
                    <h3>Integrity</h3>
                    <p>Transparent and ethical business practices</p>
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="core-values">
                    <h3>Customer Focus</h3>
                    <p>Understanding and fulfilling customer needs</p>
                </div>
            </div>
            <div class="col-lg-3 mb-3">
                <div class="core-values">
                    <h3>Excellence</h3>
                    <p>Commitment to engineering precision and performance</p>
                </div>
            </div>

        </div>
    </div>
</section>
<section class="section-padding bg-img-sec" style="background-image: linear-gradient(128deg,rgba(0, 0, 0, 0.386) 0%, rgba(0, 0, 0, 0.408) 100%),url(assets/img/ab4.jpg);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 mb-3">
                <div class="leadership-box">
                    <h6>Leadership</h6>
                    <h3>CS Rajan Babu</h3>
                    <hr>
                    <h5>Owner & Design Architect | Design Engineer</h5>
                    <p>With extensive experience in embedded systems and automation, he leads the company with a
                        strong focus on technical excellence and product innovation.</p>

                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="leadership-box">
                    <h6>Our Presence</h6>
                    <h3>Hita Soft Systems</h3>
                    <hr>
                    <p>TC 49/20-1
                        Pamamcode, Pappanamcode <br>
                        Industrial Estate PO <br>
                        Thiruvananthapuram, Kerala - 695019
                        India</p>
                    <a href="#!">+91-9387737998</a>
                    <a href="#!">hitasoftsystems@gmail.com</a>

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