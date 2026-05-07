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

$about_defaults = \App\AboutUsCMSSettings::defaults();
$about_data = isset($about_page) && $about_page
    ? array_merge($about_defaults, array_filter($about_page->toArray(), function ($value) {
        return $value !== null && $value !== "";
    }))
    : $about_defaults;
$about_asset = function ($path) {
    if (!$path) {
        return "";
    }

    return preg_match('/^https?:\/\//', $path) ? $path : asset($path);
};
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
    style="  background-image:linear-gradient(128deg,rgba(0, 0, 0, 0.485) 0%, rgba(0, 0, 0, 0.589) 100%), url({{ $about_asset($about_data['banner_image'] ?? '') }});">
    <h3>{{ $about_data['banner_title'] ?? '' }}</h3>
</div>
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="about-left">
                    <img src="{{ $about_asset($about_data['who_image'] ?? '') }}" alt="">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="about-right">
                    <h3>{{ $about_data['who_title'] ?? '' }}</h3>
                    @foreach(($about_data['who_content'] ?? []) as $paragraph)
                    <p>{{ $paragraph }}</p>
                    @endforeach
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
                    <h3>{{ $about_data['what_title'] ?? '' }}</h3>
                    <p>{{ $about_data['what_content'] ?? '' }}</p>
                    <ul>
                        @foreach(($about_data['what_items'] ?? []) as $item)
                        <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="about-left">
                    <img src="{{ $about_asset($about_data['what_image'] ?? '') }}" alt="">
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-6 mb-2">
                <div class="mission-box">
                    <h3>{{ $about_data['mission_title'] ?? '' }}</h3>
                    <p>{{ $about_data['mission_content'] ?? '' }}</p>
                </div>
            </div>
            <div class="col-lg-6 mb-2">
                <div class="mission-box">
                    <h3>{{ $about_data['vision_title'] ?? '' }}</h3>
                    <p>{{ $about_data['vision_content'] ?? '' }}</p>
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
                    <h3>{{ $about_data['core_values_title'] ?? '' }}</h3>

                </div>
            </div>
        </div>
        <div class="row mt-3 row-20">
            @foreach(($about_data['core_values'] ?? []) as $core)
            <div class="col-lg-3 mb-3">
                <div class="core-values">
                    <h3>{{ $core['title'] ?? '' }}</h3>
                    <p>{{ $core['description'] ?? '' }}</p>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
<section class="section-padding bg-img-sec" style="background-image: linear-gradient(128deg,rgba(0, 0, 0, 0.386) 0%, rgba(0, 0, 0, 0.408) 100%),url({{ $about_asset($about_data['leadership_bg_image'] ?? '') }});">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 mb-3">
                <div class="leadership-box">
                    <h6>{{ $about_data['leadership_label'] ?? '' }}</h6>
                    <h3>{{ $about_data['leadership_name'] ?? '' }}</h3>
                    <hr>
                    <h5>{{ $about_data['leadership_designation'] ?? '' }}</h5>
                    <p>{{ $about_data['leadership_content'] ?? '' }}</p>

                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="leadership-box">
                    <h6>{{ $about_data['presence_label'] ?? '' }}</h6>
                    <h3>{{ $about_data['presence_name'] ?? '' }}</h3>
                    <hr>
                    <p>{!! nl2br(e($about_data['presence_address'] ?? '')) !!}</p>
                    @if(!empty($about_data['presence_phone']))
                    <a href="tel:{{ $about_data['presence_phone'] }}">{{ $about_data['presence_phone'] }}</a>
                    @endif
                    @if(!empty($about_data['presence_email']))
                    <a href="mailto:{{ $about_data['presence_email'] }}">{{ $about_data['presence_email'] }}</a>
                    @endif

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
