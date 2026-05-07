<?php
$banner_path = 'images/banner_image';
$main_cat_path = 'images/main_cat_image';
$sub_cat_path = 'images/sub_cat_image';
$product_path = 'images/featured_products';
$noimage = \DB::table('noimage_settings')->first();
$noimage_path = 'images/noimage';
?>
@extends('layouts.frontend')
@section('title', $cms->page_name)

@section('content')

<!-- Pages SECTION START -->
<section class="section-padding text-baner-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-baner">
                    <h1>{{$cms->page_name}}</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="cms-container">
                    <p><?php echo $cms->page_description; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pages SECTION END -->
@endsection