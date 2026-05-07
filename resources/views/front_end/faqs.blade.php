<?php 
$banner_path = 'images/banner_image';
$main_cat_path = 'images/main_cat_image';
$sub_cat_path = 'images/sub_cat_image';
$product_path = 'images/featured_products';
$noimage = \DB::table('noimage_settings')->first();
$noimage_path = 'images/noimage';
?>
@extends('layouts.frontend')
@section('title', 'FAQs')

@section('content')
<style>
      ul.nav-menu li.nav-item a.nav-link {
    color: #222 !important;
}
div.click-search,div.search-items-top,.top-right ul li a.cart_rang{
    box-shadow:none;
        border: 1px solid #827e7e8f;
}
div.click-search i,div.search-items-top i,div.search-items-top input,div.search-items-top input::placeholder,.top-right ul li a.cart_rang{
    color:#222 !important;
}

</style>
<div class="cover-head"></div>
<div class="section-padding bg-light-gray py-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <div class="faq-icon-top">
                        <img src="assets/img/icon.png" alt="">
                    </div> -->
                    <div class="section-title column-title pb-2">
                        <h3>FAQs</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <section class="section-padding " >
        <div class="container">
          
            <div class="row justify-content-center">
                <!--<div class="col-lg-4 mb-3">-->
                <!--    <div class="faq-left-img">-->
                <!--        <img src="{{asset('assets/img/basic/1.jpg')}}" alt="">-->
                <!--    </div>-->
                <!--</div>-->
                <div class="col-lg-8 mb-3">
                    <div class="accordion faq-accordion" id="accordionExample">
                          @foreach($faq as $index => $fv)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button shadow-none {{ $index == 0 ? '' : 'collapsed' }}" 
                                        type="button" 
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $index }}" 
                                        aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" 
                                        aria-controls="collapse{{ $index }}">
                                    {{ $fv->title }}
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {!! $fv->content !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('before_scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection