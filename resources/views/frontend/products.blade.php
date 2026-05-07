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
@section('title', 'Products')

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
    style="  background-image:linear-gradient(128deg,rgba(0, 0, 0, 0.485) 0%, rgba(0, 0, 0, 0.589) 100%), url(assets/img/ab3.jpg);">
    <h3>Our Products</h3>
</div>
<section class="section-padding bg-light-gray">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title">
                    <p>
                        Built with intelligent control, safety protection, and durable components, our products
                        ensure efficient, hassle-free, and long-lasting performance.</p>

                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-xl-4 col-lg-6 mb-3">
                <div class="purchase-container">
                    <div class="purchase-image">
                        <img src="assets/img/item/1.png" alt="">
                        <div class="purchase-tags">
                            <!-- <span>₹ 47,000 OFF</span> -->
                            <span>1 Left</span>
                        </div>

                    </div>
                    <div class="purchase-info">
                        <h6><a href="product-details.html">
                                Aquamate Automatic Starter</a></h6>
                        <!-- <div class="purchase-rating">
                                <a href="product-details.html">Lowest Price</a>
                                <span>5.0 <i class="fa-solid fa-star"></i></span>

                            </div> -->
                        <h5>₹ 3,360.00</h5>
                        <p>Compact and efficient starter for small capacity water pumps.</p>
                        <ul>
                            <li><i class="fas fa-cogs"></i>Capacity: 0.5 - 1.5 HP</li>
                            <li><i class="fas fa-cog"></i>Type: DOL Starter</li>
                            <li><i class="fas fa-bolt"></i>Power: Single Phase 230V</li>
                            <li><i class="fas fa-ruler-combined"></i>Size: L 12, B 7.5, H 10 cm</li>
                            <li><i class="fas fa-shield-alt"></i>Suitable for basic pump automation with reliable performance</li>
                        </ul>
                        <a href="product-details.html" class="view-details">View Details</a>

                    </div>
                </div>

            </div>
            <div class="col-xl-4 col-lg-6 mb-3">
                <div class="purchase-container">
                    <div class="purchase-image">
                        <img src="assets/img/item/2.png" alt="">
                        <div class="purchase-tags">
                            <span>1 Left</span>
                        </div>

                    </div>
                    <div class="purchase-info">
                        <h6><a href="product-details.html">Aquamate Automatic Panel</a></h6>

                        <h5>₹ 3,870.00</h5>
                        <p>Reliable automatic panel for open well pump systems.</p>
                        <ul>
                            <li><i class="fas fa-cogs"></i>Capacity: 0.5 - 1.5 HP</li>
                            <li><i class="fas fa-cog"></i>Type: Open Well Pump Panel (Without Cap)</li>
                            <li><i class="fas fa-bolt"></i>Power: Single Phase 230V</li>
                            <li><i class="fas fa-ruler-combined"></i>Size: L 18.5, B 9.5, H 19 cm</li>
                            <li><i class="fas fa-shield-alt"></i>Ensures automatic operation with protection features</li>
                        </ul>
                        <a href="product-details.html" class="view-details">View Details</a>

                    </div>
                </div>

            </div>
            <div class="col-xl-4 col-lg-6 mb-3">
                <div class="purchase-container">
                    <div class="purchase-image">
                        <img src="assets/img/item/3.png" alt="">
                        <div class="purchase-tags">
                            <span>1 Left</span>
                        </div>

                    </div>
                    <div class="purchase-info">
                        <h6><a href="product-details.html">Universal Single Phase Automatic Panel Board</a></h6>

                        <h5>₹ 7,950.00</h5>
                        <p>Smart automation panel designed for borewell pump systems.</p>
                        <ul>
                            <li><i class="fas fa-cogs"></i>Capacity: 0.75 - 3 HP</li>
                            <li><i class="fas fa-cog"></i>Type: Borewell Pump Timer Panel (Without Cap)</li>
                            <li><i class="fas fa-bolt"></i>Power: Single Phase 230V</li>
                            <li><i class="fas fa-ruler-combined"></i>Size: L 24, B 9, H 29 cm</li>
                            <li><i class="fas fa-shield-alt"></i>Includes timer-based control and automation</li>
                        </ul>
                        <a href="product-details.html" class="view-details">View Details</a>

                    </div>
                </div>

            </div>
            <div class="col-xl-4 col-lg-6 mb-3">
                <div class="purchase-container">
                    <div class="purchase-image">
                        <img src="assets/img/item/4.png" alt="">
                        <div class="purchase-tags">
                            <span>1 Left</span>
                        </div>

                    </div>
                    <div class="purchase-info">
                        <h6><a href="product-details.html">Universal 3 Phase DOL Automatic Panel Board</a></h6>

                        <h5>₹ 18,550.00</h5>
                        <p>High-performance panel for industrial-grade 3-phase pumps.</p>
                        <ul>
                            <li><i class="fas fa-cogs"></i>Capacity: 5 - 10 HP / 3 Phase 440V</li>
                            <li><i class="fas fa-cog"></i>Type: DOL Universal</li>
                            <li><i class="fas fa-bolt"></i>Power: 3 Phase 440V</li>
                            <li><i class="fas fa-ruler-combined"></i>Size: L 35, B 12, H 27 cm</li>
                            <li><i class="fas fa-shield-alt"></i>Designed for durability and stable operation</li>
                        </ul>
                        <a href="product-details.html" class="view-details">View Details</a>

                    </div>
                </div>

            </div>
            <div class="col-xl-4 col-lg-6 mb-3">
                <div class="purchase-container">
                    <div class="purchase-image">
                        <img src="assets/img/item/5.png" alt="">
                        <div class="purchase-tags">
                            <span>1 Left</span>
                        </div>

                    </div>
                    <div class="purchase-info">
                        <h6><a href="product-details.html">Universal 3 Phase DOL 2 Load Interchange Automatic Panel Board</a></h6>

                        <h5>₹ 27,950.00</h5>
                        <p>Dual pump automation panel with interchange functionality.</p>
                        <ul>
                            <li><i class="fas fa-cogs"></i>Capacity: 5 - 10 HP (2 Pumps) / 3 Phase 440V</li>
                            <li><i class="fas fa-cog"></i>Type: DOL Universal</li>
                            <li><i class="fas fa-bolt"></i>Power: 3 Phase 440V</li>
                            <li><i class="fas fa-ruler-combined"></i>Size: L 45, B 12, H 27 cm</li>
                            <li><i class="fas fa-shield-alt"></i>Alternates pump usage to prevent wear and ensure longevity</li>
                        </ul>
                        <a href="product-details.html" class="view-details">View Details</a>

                    </div>
                </div>

            </div>
            <div class="col-xl-4 col-lg-6 mb-3">
                <div class="purchase-container">
                    <div class="purchase-image">
                        <img src="assets/img/item/6.png" alt="">
                        <div class="purchase-tags">
                            <span>1 Left</span>
                        </div>

                    </div>
                    <div class="purchase-info">
                        <h6><a href="product-details.html">Universal 3 Phase Star-Delta Automatic Panel Board</a></h6>

                        <h5>₹ 45,800.00</h5>
                        <p>Advanced panel for heavy-duty pump operations.</p>
                        <ul>
                            <li><i class="fas fa-cogs"></i>Capacity: 10 - 20 HP / 3 Phase 440V</li>
                            <li><i class="fas fa-cog"></i>Type: Star-Delta (SD) Universal</li>
                            <li><i class="fas fa-bolt"></i>Power: 3 Phase 440V</li>
                            <li><i class="fas fa-ruler-combined"></i>Size: L 45, B 18, H 37 cm</li>
                            <li><i class="fas fa-shield-alt"></i>Suitable for high-load applications with smooth start</li>
                        </ul>
                        <a href="product-details.html" class="view-details">View Details</a>

                    </div>
                </div>

            </div>
            <div class="col-xl-4 col-lg-6 mb-3">
                <div class="purchase-container">
                    <div class="purchase-image">
                        <img src="assets/img/item/7.png" alt="">
                        <div class="purchase-tags">
                            <span>1 Left</span>
                        </div>

                    </div>
                    <div class="purchase-info">
                        <h6><a href="product-details.html">Universal 3 Phase Star-Delta 2 Load Interchange Automatic Panel Board</a>
                        </h6>

                        <h5>₹ 88,000.00</h5>
                        <p>Premium dual-load panel for large-scale automation systems.</p>
                        <ul>
                            <li><i class="fas fa-cogs"></i>Capacity: 10 - 25 HP (2 Pumps) / 3 Phase 440V</li>
                            <li><i class="fas fa-cog"></i>Type: Star-Delta (SD) Universal</li>
                            <li><i class="fas fa-bolt"></i>Power: 3 Phase 440V</li>
                            <li><i class="fas fa-ruler-combined"></i>Size: L 100, B 22, H 80 cm</li>
                            <li><i class="fas fa-shield-alt"></i>Supports interchange operation for heavy-duty usage</li>
                        </ul>
                        <a href="product-details.html" class="view-details">View Details</a>

                    </div>
                </div>

            </div>



            <!-- 
                <div class="col-lg-12">
                    <a href="#!" class="view-more-btn">View More</a>
                </div> -->


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