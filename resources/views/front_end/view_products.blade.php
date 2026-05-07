<?php
$product_path = 'images/featured_products';
$product_img_path = 'images/products';
$noimage = \DB::table('noimage_settings')->first();
$noimage_path = 'images/noimage';
?>

@extends('layouts.frontend')
@section('title', 'View Products')

@section('content')
@if($products)
@php
    $mainImage = $products->featured_product_img
        ? asset($product_path . '/' . $products->featured_product_img)
        : asset($noimage_path . '/' . ($noimage->product_no_image ?? 'no-img.jpg'));
    $galleryImages = collect([$mainImage]);

    if (!empty($products['images'])) {
        foreach ($products['images'] as $image) {
            if (!empty($image->image)) {
                $galleryImages->push(asset($product_img_path . '/' . $image->image));
            }
        }
    }

    $price = $products->original_price;
    $shortDescription = $products->short_description ?: strip_tags($products->product_desc);
    $featureText = $products->product_feature_text ?: $products->features;
@endphp

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="gj_msg">
                @if($errors->any())
                    <p class="alert alert-danger auto-dismiss" id="errorMessage">{{ $errors->first() }}</p>
                @endif
            </div>
            <div id="product-flash-message" class="alert alert-danger d-none" role="alert"></div>
        </div>
    </div>
</div>

<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="product-gallery">
                    <div class="row gallery-row">
                        <div class="col-lg-3 gallery-col-flex">
                            @foreach($galleryImages->take(4) as $image)
                                <div class="col-lg-12 gallery-label">
                                    <img src="{{ $image }}" onclick="myFunction(this);" alt="{{ $products->product_title }}">
                                </div>
                            @endforeach
                        </div>
                        <div class="col-lg-9">
                            <div class="gallery-main-img">
                                <img src="{{ $mainImage }}" alt="{{ $products->product_title }}" id="demoimg">
                                <img id="expandedImg" alt="{{ $products->product_title }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="product-details-right">
                    <h3>{{ $products->product_title }}</h3>
                    @if($shortDescription)
                        <p class="warrant-p">{{ $shortDescription }}</p>
                    @endif
                    <p class="price">₹ {{ number_format((float) $price, 2) }}</p>
                    <div class="product-features">
                        <ul>
                            @if($products->product_capacity)
                                <li>Capacity : <span>{{ $products->product_capacity }}</span></li>
                            @endif
                            @if($products->product_type)
                                <li>Type : <span>{{ $products->product_type }}</span></li>
                            @endif
                            @if($products->product_power)
                                <li>Power : <span>{{ $products->product_power }}</span></li>
                            @endif
                            @if($products->product_size)
                                <li>Size : <span>{{ $products->product_size }}</span></li>
                            @endif
                            @if($featureText)
                                <li>{{ $featureText }}</li>
                            @endif
                        </ul>
                    </div>
                    <small style="display:block;margin-bottom:10px;font-size:16px;font-weight:600;color:{{ $products->onhand_qty > 0 ? 'green' : 'red' }}">
                        {{ $products->onhand_qty > 0 ? 'In Stock' : 'Out of Stock' }} - {{ $products->onhand_qty }}
                    </small>
                    <div class="product-qty-box pt-1 view-product-qty">
                        <div class="product-qty">
                            <button class="down gj_subtract_product" type="button"><i class="fa-solid fa-minus"></i></button>
                            <input type="text" value="1" min="1" id="qty" name="quantity" class="form-control shadow-none">
                            <input type="hidden" id="price" name="price" value="{{ $price }}" class="quantity-selector">
                            <input type="hidden" name="id" value="{{ $products->id }}">
                            <input type="hidden" name="selected_color_id" id="selected_color_id" value="">
                            <input type="hidden" name="selected_color_name" id="selected_color_name" value="">
                            <button class="up gj_add_product" type="button"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="product-main-btns">
                        @if($products->onhand_qty > 0)
                            <a href="javascript:void(0)" class="gj_add2cart" data-cart-id="{{ $products->id }}">Add to Cart</a>
                        @else
                            <a href="javascript:void(0)" class="disabled" aria-disabled="true">Out of Stock</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if(isset($related) && count($related) != 0)
<section class="section-padding bg-light-gray">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title">
                    <h3>Related Products</h3>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            @foreach($related as $product)
                <div class="col-xl-4 col-lg-6 mb-3">
                    @include('frontend.partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endif
@endsection

@section('before_scripts')
<script>
    $(document).ready(function () {
        let onhandQty = {{ $products->onhand_qty ?? 0 }};

        function calculate(qty) {
            qty = parseInt(qty);
            if (isNaN(qty) || qty <= 0) qty = 1;
            $('#qty').val(qty);
            $('.gj_subtract_product').prop('disabled', qty <= 1);
        }

        $('.gj_add_product').on('click', function () {
            calculate((parseInt($('#qty').val()) || 1) + 1);
        });

        $('.gj_subtract_product').on('click', function () {
            calculate(Math.max((parseInt($('#qty').val()) || 1) - 1, 1));
        });

        $('#qty').on('input', function () {
            calculate($(this).val());
        });

        calculate(1);
    });
</script>
@endsection
