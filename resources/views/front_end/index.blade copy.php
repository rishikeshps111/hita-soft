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
@section('title', 'Home')

@section('content')
<style>
    .navbar-toggler i{
    color:#fff;
}
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


<section class="home-baner-section">
    {{--  <video playsinline autoplay muted loop class="baner-video">
            <source src="{{asset('assets/video/9.mp4')}}" type="video/mp4">
        </video>
        
        <div class="banner-text-cs">
           <div class="container">
               <div class="row justify-content-center">
                   <div class="col-lg-8">
                        <h1>Your Destination for Timeless Fashion</h1>
            <p>Style that reflects your personality</p>
                   </div>
               </div>
           </div>
        </div>
        <div class="scroll-bottom">
                        <a href="#explore">
                            <p>Explore More</p>
                            <i class="fa-solid fa-circle-arrow-down"></i>
                        </a>
                    </div> --}}
       <div class="home-baner-slider">
              <div class="owl-carousel hero-section owl-theme baner-owl-btns">
       
                @if(isset($banner_images) && sizeof($banner_images) != 0)
                @foreach($banner_images as $bankey => $banvalue)
                <div class="item">
                    <!--<a href="{{$banvalue->redirect_url}}">-->
                    <div class="hero-baner" style="background-image:linear-gradient(129deg,rgba(0, 0, 0, 0.43) 0%, rgba(0, 0, 0, 0.44) 100%),url('{{ asset($banner_path.'/'.$banvalue->banner_image) }}');">
                        
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-7 ">
                                    <div class="hero-baner-caption">
                                       
                                        <h1>{{ $banvalue->image_title ?? 'Default Title' }}</h1>
                                        <!--<p>Timeless Fashion. Thoughtfully Crafted. Uniquely You.</p>-->
                                        <a href="{{$banvalue->redirect_url}}" class="baner-btn">{{$banvalue->button_title}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--</a>-->
                </div>
                  @endforeach
                @else
                    <!--<div class="carousel-item active">-->
                    <!--    <img src="{{ asset($noimage_path.'/'.$noimage->banner_no_image)}}" width="100%" height="500">-->
                    <!--</div>-->
                @endif
        
        
            </div>
         </div> 
   

</section>

<section class="section-padding" id="explore">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 py-1">
                <div class="section-title">
                    <h3><span class="left-span"></span>Shop by Product <span class="right-span"></span></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="owl-carousel cat-carousel owl-theme">
                @if(isset($main_cat) && sizeof($main_cat) != 0)
                    @foreach($main_cat as $tckey => $tcvalue)
                    <div class="item">
                        <a href="{{ route('category.products',strtolower(str_replace(' ', ' ', $tcvalue->main_cat_name))) }}" class="cat-product-btn-home">
                            <div class="cat-img"
                                style="background-image: linear-gradient(0deg, rgba(0,0,0,0.2582282913165266) 0%, rgba(0,0,0,0.2190126050420168) 100%),url({{ asset($main_cat_path.'/'.$tcvalue->main_cat_image) }});">
                                <div>
                                    <h3>{{$tcvalue->main_cat_name}}</h3>
                                    <p>{{$tcvalue->main_cat_desc}}
                                    </p>
                                </div>
                                <a href="{{ route('category.products', strtolower(str_replace(' ', ' ', $tcvalue->main_cat_name))) }}" class="shop-cat">SHOP</a>
                            </div>
                        </a>
                    </div>
                    @endforeach
                @else
                    <div class="item">
                        <a href="" class="cat-product-btn-home">
                            <div class="cat-img"
                                style="background-image: linear-gradient(0deg, rgba(0,0,0,0.2582282913165266) 0%, rgba(0,0,0,0.2190126050420168) 100%),url(assets/img/product/13.jpg);">
                                <div>
                                    <h3>No Category </h3>
                                    <p></p>
                                </div>
                                <a href="" class="shop-cat">SHOP</a>
                            </div>
                        </a>

                    </div>
                @endif
                   
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-padding about-home">
    <div class="container">
           @if($about)
        <div class="row">
            <div class="col-lg-5">
                <div class="about-home-left">
                    <img src="{{asset('assets/img/about/17.webp')}}">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="about-home-right">
                      <h6>Our <span>Story</span></h6>
                    <h3>Where Elegance Meets Style</h3>
                    <?php echo $about->video_desc; ?>
                </div>
                
            </div>
        </div>
        @endif
    </div>
</section>



<!--<section class="section-padding p-0 home-about-paris-sec" >-->
   
<!--    <div class="about-section ">-->
<!--        @if($about)-->
<!--        <div class="about-left">-->
<!--            <video autoplay muted loop style>-->
<!--                <source src="{{ url('public/uploads/videos/' . basename($about->video)) }}" type="video/mp4">-->
<!--            </video>-->
<!--        </div>-->
<!--        <div class="about-right">-->
<!--            <div class="">-->
                    
<!--                    <h6>Our <span>Story</span></h6>-->
<!--                    <h3>Where Elegance Meets Style</h3>-->
<!--                </div>-->
<!--            <div class="about-right-icon-img">-->
<!--                <img src="assets/img/parislogo.png" alt="">-->
<!--            </div>-->
<!--           <?php echo $about->video_desc; ?>-->

<!--        </div>-->
<!--        @endif-->
<!--    </div>-->
<!--</section>-->
<section class="section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <a href="{{ route('featured_product') }}" style="text-decoration:none;color:#000;"><div class="section-title column-title pb-1">
                    <div class="title-direction-column">
                        <h3><span class="left-span"></span>Featured Products <span class="right-span"></span> </h3>
                        <p >Crafted for women who love graceful fashion</p>
                       
                    </div>
                    <!--<p>From graceful dresses to elegant ensembles, our featured collections are curated to elevate your wardrobe with sophistication and comfort.</p>-->
                </div></a>
            </div>
        </div>
        <div class="row mt-3">
            {{--<div class="col-lg-12">
                 <a href="{{ route('ready_to_ship') }}" class="view_all_btn">View All</a>
            </div>--}}
            <div class="col-lg-12">
                <div class="owl-carousel Featured-carousel owl-theme">
                    @if(isset($featured_products) && (sizeof($featured_products) != 0))
                    @foreach($featured_products as $fpkey => $fpval)
                    <div class="item">
                        <div class="Featured-product">
                            <a href="{{ route('view_products', ['id' => $fpval->id]) }}" class="view-a">
                                <div class="Featured-product-img">
                                    
                                     @if(($fpval->featured_product_img) )
                                    <img src="{{ asset($product_path.'/'.$fpval->featured_product_img) }}" alt="">
                                    @else
                                    <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}">
                                    @endif
                                    @if($fpval->onhand_qty == 0)
                                        <div class="stock-overlay">Out of Stock</div>
                                    @endif
                                    <!--<div class="product-icon-container">-->
                                    <!--     <a href="javascript:void(0)"  class="gj_add2cart icons-p" data-cart-id="{{$fpval->id}}"><i class="fa-solid fa-bag-shopping"></i></a>-->
                                    <!--    <a href="" class="gj_wish_list icons-p" data-wish-id="{{$fpval->id}}"><i class="fa-regular fa-heart"></i></a>-->
                                    <!--</div>-->
                                </div>
                            </a>

                            <div class="Featured-product-info">
                                <div class="product-title">
                                    <h6><a href="{{ route('view_products', ['id' => $fpval->id]) }}">{{$fpval->product_title}}</a></h6>
                                    <!--<span>-->
                                    <!--     <a href="#!"><i class="fa-solid fa-code-compare"></i></a> -->
                                       
                                    <!--</span>-->
                                </div>
                                <!--<p><?php echo $fpval->product_desc; ?></p>-->
                                <div class="product-features-price">
                                    @if($fpval->discounted_price > 0)
                                    <p class="price">
                                        <!--<strike>₹ {{ $fpval->original_price }}</strike>&ensp;-->
                                        ₹ {{ $fpval->discounted_price }}
                                    </p>
                                @else
                                    <p class="price">₹ {{ $fpval->original_price }}</p>
                                @endif
                                <p class="stock" style="font-size: 14px;">In Stock: {{$fpval->onhand_qty}}</p>
                                </div>
                                <div class="bottom-ftr-btns">
                                     <a href="javascript:void(0)"  class="gj_add2cart icons-p" data-cart-id="{{$fpval->id}}"><i class="fa-solid fa-bag-shopping"></i></a>
                                        <a href="" class="gj_wish_list icons-p" data-wish-id="{{$fpval->id}}"><i class="fa-regular fa-heart"></i></a>
                                         <a href="{{ route('view_products', ['id' => $fpval->id]) }}" ><i class="fa-solid fa-eye"></i></a>
                                </div>
                               
                                

                            </div>


                        </div>
                    </div>
                     @endforeach
                     @endif
                   
                </div>
            </div>
        </div>
    </div>
</section>
<!--<section class="section-padding">-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-lg-12">-->
<!--                <div class="section-title column-title">-->
<!--                    <h3>Our Highlights</h3>-->

<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="row justify-content-center mt-3">-->
<!--            <div class="col-lg-5 mb-3">-->
<!--                <div class="highlights-container mtop_hlts_100"-->
<!--                    style="background-image: linear-gradient(0deg, rgba(0,0,0,0.2582282913165266) 0%, rgba(0,0,0,0.2190126050420168) 100%),url(assets/img/basic/4.jpeg);">-->
<!--                    <div class="highlights-info">-->
<!--                        <h3>Premium Fabrics, Perfect Finish</h3>-->
<!--                        <p>Premium fabrics crafted with a flawless finish, designed to elevate every woman’s style.</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-lg-5 mb-3">-->
<!--                <div class="highlights-container"-->
<!--                    style="background-image: linear-gradient(0deg, rgba(0,0,0,0.2582282913165266) 0%, rgba(0,0,0,0.2190126050420168) 100%),url(assets/img/basic/5.jpeg);">-->
<!--                    <div class="highlights-info">-->
<!--                        <h3>Designed for the Modern Woman</h3>-->
<!--                        <p>Thoughtfully designed styles that reflect the confidence and grace of the modern woman.</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-lg-5 mb-3">-->
<!--                <div class="highlight-icon">-->
<!--                    <img src="assets/img/parislogo.png" alt="">-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-lg-5 mb-3">-->
<!--                <div class="highlights-container"-->
<!--                    style="background-image: linear-gradient(0deg, rgba(0,0,0,0.2582282913165266) 0%, rgba(0,0,0,0.2190126050420168) 100%),url(assets/img/basic/6.jpeg);">-->
<!--                    <div class="highlights-info">-->
<!--                        <h3>Made with Precision & Passion</h3>-->
<!--                        <p>Every piece is made with precision and passion for flawless detail and lasting elegance.</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

<!--        </div>-->
<!--    </div>-->
<!--</section>-->
<section class="section-padding bg-light-cs">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <a  href="{{ route('ready_to_ship', ['type' => 'latest']) }}" style="text-decoration:none;color:#000;"><div class="section-title column-title pb-1">
                     <div >
                        <h3 ><span class="left-span"></span>Latest Products<span class="right-span"></span></h3>
                       
                    </div>
                    <p>Where tradition blends with modern style
            </div>
        </div>
        <div class="row mt-3">
             {{--<div class="col-lg-12">
                  <a href="{{ route('ready_to_ship', ['type' => 'latest']) }}"  class="view_all_btn">View All</a>
             </div>--}}
             @if(isset($latest_products) && sizeof($latest_products) != 0)
                    @foreach($latest_products as $latkey => $latval)
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                         <div class="Featured-product">
                            <a href="{{ route('view_products', ['id' => $latval->id]) }}" class="view-a">
                                <div class="Featured-product-img">
                                    @if(isset($latval->featured_product_img) )
                                    <img src="{{ asset($product_path.'/'.$latval->featured_product_img) }}" alt="">
                                    @else
                                    <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}">
                                    @endif
                                    @if($latval->onhand_qty == 0)
                                        <div class="stock-overlay">Out of Stock</div>
                                    @endif
                                       <!--<div class="product-icon-container">-->
                                           
                                       <!--</div>-->
                                </div>
                            </a>

                            <div class="Featured-product-info">
                                <div class="product-title">
                                    <h6><a href="{{ route('view_products', ['id' => $latval->id]) }}">{{$latval->product_title}}</a></h6>
                                  
                                </div>
                                 <!--<p><?php echo $latval->product_desc; ?></p>-->
                                <div class="product-features-price">
                                       @if($latval->discounted_price > 0)
                                    <p class="price">
                                        <!--<strike>₹ {{ $latval->original_price }}</strike>&ensp;-->
                                        ₹ {{ $latval->discounted_price }}
                                    </p>
                                @else
                                    <p class="price">₹ {{ $latval->original_price }}</p>
                                @endif
                                <p class="stock" style="font-size: 14px;">In Stock: {{$latval->onhand_qty}}</p>
                                </div>
                                <div class="bottom-ftr-btns">
                                      <a href="javascript:void(0)" class="gj_add2cart icons-p" data-cart-id="{{$latval->id}}"><i class="fa-solid fa-bag-shopping"></i></a>
                                        <a href="" class="gj_wish_list icons-p" data-wish-id="{{$latval->id}}"><i class="fa-regular fa-heart"></i></a>
                                         <a href="{{ route('view_products', ['id' => $latval->id]) }}" ><i class="fa-solid fa-eye"></i></a>
                                </div>
                               
                             

                            </div>
                        </div>
                    </div>
            
                    @endforeach
                @endif

                </div>
            </div>
        </div>
    </div>
</section>
 <section class="testimonial-sec">
      <div class="container-fluid">
          <div class="row m-0">
              <div class="col-lg-6 p-0">
                    <div class="testimonial-left">
                                           <img src="{{asset('assets/img/about/16.webp')}}">
                    </div>
                </div>
                 <div class="col-lg-6">
                     <div class="testimonial-right">
                         <h2>Customer Feedbacks</h2>
                          <div class="owl-carousel customer-carousel owl-theme">
                @if(isset($testimonial) && count($testimonial) > 0)
                    @foreach ($testimonial as $testimonialData)
                    <div class="item">
                        <div class="customer-container">
                            <div class="customer-box-top">
                                <div class="customer-box-top-left">
                                    <h3>{{ $testimonialData->name }}</h3>
                                    <img src="{{ asset($testimonialData->image ? $testimonialData->image : 'assets/img/no-img.jpg') }}" alt="">
                                </div>
                                <i class="fa-solid fa-quote-right"></i>

                            </div>
                            <div class="customer-bottom">
                                <p>{{ $testimonialData->message }}</p>
                            </div>
                        </div>

                    </div>
                    @endforeach
                @endif
                    
                </div

                     </div>
                 </div>
          </div>
      </div>
 </section>


@endsection




@section('before_scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
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
        document.addEventListener('DOMContentLoaded', function () {
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
        document.addEventListener('DOMContentLoaded', function () {
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
$(document).ready(function(){
    $(".Featured-carousel").owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        responsive:{
            0:{ items:1 },
            600:{ items:2 },
            1000:{ items:3 }
        }
    });
});
</script>


@endsection