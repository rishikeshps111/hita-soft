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

$contact_defaults = \App\ContactUsPage::defaults();
$contact_data = isset($contact_page) && $contact_page
    ? array_merge($contact_defaults, array_filter($contact_page->toArray(), function ($value) {
        return $value !== null && $value !== "";
    }))
    : $contact_defaults;
$contact_asset = function ($path) {
    if (!$path) {
        return "";
    }

    return preg_match('/^https?:\/\//', $path) ? $path : asset($path);
};
?>

@extends('layouts.frontend')
@section('title', 'Contact Us')

@section('content')
<style>

</style>

<div class="page-baner"
    style="  background-image:linear-gradient(128deg,rgba(0, 0, 0, 0.485) 0%, rgba(0, 0, 0, 0.589) 100%), url({{ $contact_asset($contact_data['banner_image'] ?? '') }});">
    <h3>{{ $contact_data['banner_title'] ?? '' }}</h3>
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
                            {{ $contact_data['address'] ?? '' }}

                        </li>
                        <li class="align-items-center">
                            <div class="contact-ad-icon">
                                <i class="fa-regular fa-envelope-open"></i>
                            </div>
                            {{ $contact_data['email'] ?? '' }}
                        </li>
                        <li class="align-items-center">
                            <a href="tel:{{ $contact_data['phone'] ?? '' }}" class="contact-a">
                                <div class="contact-ad-icon">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                {{ $contact_data['phone'] ?? '' }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="contact-us-box mb-2">
                    <div class="cnt-map">
                        <iframe src="{{ $contact_data['map_iframe'] ?? '' }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

            </div>
            <div class="col-lg-8 mb-3">
                <div class="contact-form">

                    <p>{{ $contact_data['form_intro'] ?? '' }}</p>
                    <div class="gj_msg">
                        @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }} auto-dismiss" id="successMessage">
                            {{ Session::get('message') }}
                        </p>
                        @endif
                        @if($errors->any())
                        <p class="alert alert-danger auto-dismiss" id="errorMessage">
                            {{ $errors->first() }}
                        </p>
                        @endif
                    </div>
                    <form action="{{ route('contact_us.store') }}" method="POST" class="mt-3">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <div class="contact-form-box">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" name="contact_name" class="form-control shadow-none" id="name" value="{{ old('contact_name') }}">
                                    @if($errors->has('contact_name'))
                                    <span class="text-danger">{{ $errors->first('contact_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="contact-form-box">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="contact_email" class="form-control shadow-none" id="email" value="{{ old('contact_email') }}">
                                    @if($errors->has('contact_email'))
                                    <span class="text-danger">{{ $errors->first('contact_email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="contact-form-box">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="contact_phone" class="form-control shadow-none" id="phone" value="{{ old('contact_phone') }}">
                                    @if($errors->has('contact_phone'))
                                    <span class="text-danger">{{ $errors->first('contact_phone') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="contact-form-box">
                                    <label for="Subject" class="form-label">Subject</label>
                                    <input type="text" name="subject" class="form-control shadow-none" id="Subject" value="{{ old('subject') }}">
                                    @if($errors->has('subject'))
                                    <span class="text-danger">{{ $errors->first('subject') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div class="contact-form-box">
                                    <label for="Message" class="form-label">Message</label>
                                    <textarea name="message" id="Message" class="form-control shadow-none">{{ old('message') }}</textarea>
                                    @if($errors->has('message'))
                                    <span class="text-danger">{{ $errors->first('message') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="contact-btn">Send Message</button>
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