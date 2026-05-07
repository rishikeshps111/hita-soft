<?php
$product_path = "images/featured_products";
$noimage = \DB::table("noimage_settings")->first();
$noimage_path = "images/noimage";
?>

@extends('layouts.frontend')
@section('title', 'Products')

@section('content')
<div class="page-baner"
    style="background-image:linear-gradient(128deg,rgba(0, 0, 0, 0.485) 0%, rgba(0, 0, 0, 0.589) 100%), url({{ asset('assets/img/ab3.jpg') }});">
    <h3>Our Products</h3>
</div>

<section class="section-padding bg-light-gray">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title">
                    <p>Built with intelligent control, safety protection, and durable components, our products ensure efficient, hassle-free, and long-lasting performance.</p>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            @forelse($products as $product)
                <div class="col-xl-4 col-lg-6 mb-3">
                    @include('frontend.partials.product-card', ['product' => $product])
                </div>
            @empty
                <div class="col-lg-12">
                    <h6 class="fw-bold text-center">Products Not Found</h6>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
