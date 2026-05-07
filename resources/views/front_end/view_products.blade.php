<?php 
$banner_path = 'images/banner_image';
$main_cat_path = 'images/main_cat_image';
$sub_cat_path = 'images/sub_cat_image';
$product_path = 'images/featured_products';
$product_img_path = 'images/products';
$product_att_path = 'images/attributes';
$profile_img_path = 'images/profile_img';
$brand_img_path = 'images/brands';
$noimage = \DB::table('noimage_settings')->first();
$noimage_path = 'images/noimage';
?>
@extends('layouts.frontend')
@section('title', 'View Products')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css"/>
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



    .product-fade-ct {
    position: absolute;
    bottom: 0;
    width: 100%;
    background: rgba(255, 255, 255, 0.9);
    z-index: 5;
    transition: all 0.3s ease-in-out;
    opacity: 0;
}

.product-fade:hover .product-fade-ct {
    opacity: 1;
}

#product-image {
    position: relative;
    z-index: 10; /* Ensures the image is above other elements */
}

.product-icons {
    position: relative;
    z-index: 15;
}

.prdct-grid {
    position: relative;
    overflow: hidden;
}
a{
    list-style-type:none;
}

.gallery-main-img {
    position: relative;
}

.gallery-main-img img {
    pointer-events: none; 
}

.gallery-main-img .share-button-container {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 10;
    pointer-events: auto; /* allow button to be clickable */
}
/* COLOR SQUARES */
.color-list {
    padding: 0;
    margin: 0;
}

.color-list li {
    display: inline-block;
    margin-right: 10px;
}

.color-swatch {
    width: 26px !important;
    height: 26px!important;
    border-radius: 4px !important;
    border: 1px solid #ccc !important;;
    cursor: pointer;
    display: inline-block;
}

.color-swatch.active {
    border: 2px solid #000;
}

.size-list {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.size-box {
    position: relative;
    padding: 8px 14px;
    border: 1px solid #ccc;
    cursor: pointer;
    border-radius: 4px;
    font-size: 14px;
    user-select: none;
    transition: all 0.2s ease;
}

/* Hide radio */
.size-box input[type="radio"] {
    display: none;
}

/* Hover */
.size-box:hover {
    border-color: #000;
}

/* ✅ When clicked (checked) */
.size-box input[type="radio"]:checked + span,
.size-box:has(input[type="radio"]:checked) {
    background-color: #000;
    color: #fff;
    border-color: #000;
}
  
a.product-whatsapp-btn-cs {
    min-width: 38px !important;
    height: 35px !important;
}
a.product-whatsapp-btn-cs i {
    margin-right: 0px !important;
}
.product-cart-btn {
    width: 38px !important;
    height: 37px !important;
}

.product-desc-top-main {
    padding: 10px !important;
    border: 1px solid #ccc !important;
</style>
@section('before_style')

@endsection

@section('content')
<!-- SUB CATEGORY SECTION START -->
@if($products)
<div class="cover-head"></div>
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

<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="gj_msg">
                        <p class="alert alert-danger" id="stock-message" style="display: none;">
                        </p>
                </div>
                <div id="product-flash-message" 
                     class="alert alert-danger d-none" 
                     role="alert">
                </div>

            </div>
        </div>
    </div>

<section class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="product-gallery">
                        <!-- The grid: four columns -->
                        <div class="row gallery-row">
                            
                            
                            <div class="col-lg-12 gallery-main-img position-relative">
                               
                             @if(($products->featured_product_img) )
                                <img id="mainImg" src="{{ asset($product_path.'/'.$products->featured_product_img)}}" alt="" data-zoom-image="{{ asset($product_path.'/'.$products->featured_product_img) }}">
                               @else
                                        <img id="mainImg" src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}">
                                @endif    
                               
                                <div class="product-share-icon-top-container product-icon-absolute">
                            <a href="" style="text-decoration: none;" class="gj_wish_list product-wishlist-btn" data-wish-id="{{$products->id}}"><i class="fa-solid fa-heart"></i> </a>
                        
                        @php
                            $whatsapp_link = '';
                            $instagram_link = '';
                        
                            if(isset($footer_social_links)) {
                                foreach ($footer_social_links as $item) {
                        
                                    if (strpos($item->icon, 'fa-whatsapp') !== false) {
                                        $whatsapp_link = $item->url;
                                    }
                        
                                    if (strpos($item->icon, 'fa-instagram') !== false) {
                                        $instagram_link = $item->url;
                                    }
                                }
                            }
                        @endphp

                         <div class="product-share-icon-top">
                                    <div class="btn-group" >
                                        <button type="button" class="product-share-icon-top-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-share-alt"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="#" class="dropdown-item copy-link-btn" data-url="{{ url()->current() }}">
                                                    <i class="fa fa-copy me-2"></i> Copy Link
                                                </a>
                                            </li>
                                             @if($whatsapp_link != '')
                                            <li>
                                                <a href="{{ $whatsapp_link }}?text={{ urlencode(url()->current()) }}" class="dropdown-item " target="_blank">
                                                    <i class="fa-brands fa-whatsapp text-success me-2"></i> WhatsApp
                                                </a>
                                            </li>
                                            @endif
                                
                                            <!-- Instagram -->
                                            @if($instagram_link != '')
                                            <li>
                                                <a href="{{ $instagram_link }}" target="_blank" class="dropdown-item">
                                                    <i class="fa-brands fa-instagram text-danger me-2"></i> Instagram
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                        </div>
                            </div>
                            <div class="col-lg-12 gallery-col-flex">
                                 <div class="row">
                                     <div class="col-lg-3 gallery-label">
                                      @if(($products->featured_product_img) ) 
                                    <img src="{{ asset($product_path.'/'.$products->featured_product_img) }}" class="img-thumbnail thumb-img" alt="Featured Image">
                                     @else
                                        <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}">
                                @endif 
                                </div>
                                 @if(($products['images']) )
                                    @foreach($products['images'] as $key => $value)
                                         <div class="col-lg-3 gallery-label">
                                            <img src="{{ asset($product_img_path.'/'.$value->image)}}"  class="img-thumbnail thumb-img">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-lg-3 gallery-label">
                                        <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}">
                                    </div>
                                @endif
                                @if(!empty($products['att']) && count($products['att']) != 0)
                                    @foreach($products['att'] as $key => $value)
                                        @if(!empty($value->image) )
                                            <div class="col-lg-3 gallery-label">
                                                <img src="{{ asset($product_att_path.'/'.$value->image)}}" class="img-thumbnail thumb-img">
                                            </div>
                                        @endif
                                    @endforeach
                                @endif

                                 </div>
                              
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="product-details-right">
                        <h3>{{$products->product_title}} 
                        
                        
                        </h3>
                         @if($products->discounted_price > 0)
                        <p class="price"> ₹ {{ $products->discounted_price }} </p>
                            <!--<p class="price">-->
                            <!--    <strike>₹ {{ $products->original_price }}</strike>&ensp;-->
                            <!--</p>-->
                        @else
                            <p class="price">₹ {{ $products->original_price }}</p>
                        @endif
                        <hr>
                        
                         
                            <div class="product-colors mb-3">
                               
                                 @if(($products['att']) && (count($products['att']) != 0))
                                <ul class="color-list"><span class="fw-bold">Colors :</span> 
                                    @foreach($products['att'] as $key => $value)
                                    <li style="">
                                        <!--<span class="bg_1" style="color:{{$value->colors}}"></span>-->
                                        <span 
                                            class="color-swatch" 
                                            style="background-color: {{ $value->colors }};"
                                            data-image="{{ asset($product_att_path.'/'.$value->image) }}" data-id="{{$value->id}}" data-color-name="{{ $value->color_name ?? '' }}">
                                        </span>
                                        <!--<div >{{ $value->color_name ?? '' }}</div>-->
               
                                        
                                    </li>
                                    
                                    @endforeach
                                </ul>
                                @endif
                                
                                @if($products['att_fields'] && count($products['att_fields'])) 
                                    @foreach($products['att_fields'] as $field)
                                        <div class="product-size-dt">
                                            <label class="fw-bold">
                                                {{ $field->att_name }} :
                                            </label>
                                
                                            <div class="size-list">
                                                @foreach($p_atts_vals as $value)
                                                    @if($value->attribute_name == $field->id)
                                                        <label class="size-box">
                                                            <input type="radio"
                                                                   name="att_value"
                                                                   value="{{ $value->attribute_values }}"
                                                                   data-att-name="{{ $field->id }}"
                                                                   class="attr-option gj_vw_att_value"
                                                                   required>
                                                            {{ optional($value->AttributeValue)->att_value }}
                                                        </label>

                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                

                             </div>
                             
                             <small style="display: block; margin-top: 5px; font-size: 18px;font-weight: 600; color: {{ $products->onhand_qty > 0 ? 'green' : 'red' }}">
                                {{ $products->onhand_qty > 0 ? 'In Stock' : 'Out of Stock' }} - {{ $products->onhand_qty}}
                            </small>
                              <div class="product-qty-box pt-1 view-product-qty">
                                <div class="product-qty">
                                    <button class="down gj_subtract_product"><i class="fa-solid fa-minus"></i></button>
                                    <input type="text" value="1"  min="1" id="qty" name="quantity" class="form-control shadow-none">
                                    
                                    <input type="hidden" id="price" name="price" value="{{$products->discounted_price}}" class="quantity-selector">
                                    <input type="hidden" name="id" value="{{$products->id}}" />
                                    <input type="hidden" name="selected_color_id" id="selected_color_id" value="">
                                    <input type="hidden" name="selected_color_name" id="selected_color_name" value="">

                                    <button class="up gj_add_product"><i class="fa-solid fa-plus"></i></button>
    
                                </div>
                              
                                @if($whatsapp_link != '')
                                <a href="{{ $whatsapp_link }}?text={{ urlencode(url()->current()) }}" target="_blank" class="product-whatsapp-btn-cs btn-sm" >
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                @endif
                                 <a href="javascript:void(0)" class="product-cart-btn  gj_add2cart btn-sm" data-cart-id="{{$products->id}}"><i class="fa-solid fa-bag-shopping"></i></a>
                               
                                
                                
                            </div>
                             <div class="product-shop-btns shop-cart-btn mb-2">
                                  <!--<a href="javascript:void(0)" class="product-cart-btn  gj_add2cart btn-sm" data-cart-id="{{$products->id}}"><i class="fa-solid fa-bag-shopping"></i></a>-->
                                  <!--<a href="javascript:void(0)" class="product-cart-btn buy-now-btn" data-product-id="{{$products->id}}" style="background-color:#a70f1d;">One Click Buy</a>-->
                            </div>
                            
                            <div class="product-desc-top-main">
                                <h5>Product Description</h5>
                    <?php echo $products->product_desc; ?>
                            </div>
                       
                         
                        
                    </div>
                </div>
               {{-- <div class="col-lg-12 mt-5">
                    
                    <table class="table table-bordered  product-dt-table">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <td>{{$products->MainCat->main_cat_name}}</td>
                                  
                                </tr> 
                                <tr>
                                    <th>Product Description</th>
                                    <td> <?php echo $products->product_desc; ?></td>
                                  
                                </tr>
                               <tr>
                                    <th>Features</th>
                                    <td> <?php echo $products->features; ?></td>
                                  
                                </tr>
                                <tr>
                                    <th>Delivery</th>
                                    <td>{!! nl2br(e($products->delivery_text)) !!}</td>
                                </tr>
                                <tr>
                                    <th>Care Instructions</th>
                                    <td>{!! nl2br(e($products->instructions)) !!}</td>
                                </tr>
                                <tr>
                                    <th>Disclaimer</th>
                                    <td>{!! nl2br(e($products->disclaimer)) !!}</td>
                                </tr>
                                <tr>
                                    <th>Note</th>
                                    <td>{!! nl2br(e($products->note)) !!}</td>
                                </tr>
                                <tr>
                                    
                                    <td colspan="2"> <p><a href="https://rangjewelry.com/pages/Shipping%20Policy" target="_blank">Shipping</a> calculated at checkout.</p></td>
                                  
                                </tr>
                            </thead>
                           
                        </table> 
                </div> --}}
            </div>
           
        </div>
    </section>
    <!--<section class=" bg-section py-3">-->
    <!--    <div class="container">-->
    <!--        <div class="row justify-content-center">-->
    <!--            <div class="col-lg-12">-->
    <!--                <div class="product-view-widget-container">-->
    <!--                    <ul>-->
    <!--                        <li>-->
    <!--                            <div class="product-view-widget justify-content-end align-items-center">-->
    <!--                                <h3>92.5</h3>-->
    <!--                                <p>Silver Jewelry </p>-->
    <!--                            </div> -->
    <!--                        </li>-->
    <!--                        <li>-->
    <!--                            <div class="product-view-widget">-->
    <!--                                <img src="{{ asset('assets/img/icn-1.png') }}" alt="">-->
    <!--                                <p>HandCrafted In India</p>-->
    <!--                            </div> -->
    <!--                        </li>-->
    <!--                        <li>-->
    <!--                            <div class="product-view-widget">-->
    <!--                                <img src="{{ asset('assets/img/icn-2.png') }}" alt="">-->
    <!--                                <p>Skin Safe</p>-->
    <!--                            </div> -->
    <!--                        </li>-->
    <!--                        <li>-->
    <!--                            <div class="product-view-widget">-->
    <!--                                <img src="{{ asset('assets/img/icn-3.png') }}" alt="" >-->
    <!--                                <p>Lifetime Warranty</p>-->
    <!--                            </div> -->
    <!--                        </li>-->
    <!--                        <li>-->
    <!--                            <div class="product-view-widget">-->
    <!--                                <img src="{{ asset('assets/img/icn-4.png') }}" alt="" >-->
    <!--                                <p>Easy Return</p>-->
    <!--                            </div> -->
    <!--                        </li>-->
    <!--                        <li>-->
    <!--                            <div class="product-view-widget">-->
    <!--                                <img src="{{ asset('assets/img/icn-5.png') }}" alt="" >-->
    <!--                                <p>22K Gold Tone Plated</p>-->
    <!--                            </div> -->
    <!--                        </li>-->
    <!--                    </ul>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->
    
    
    
    
      @if(($related) && (count($related) != 0))
    <section class="section-padding pt-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title column-title">
                        <h3><span class="left-span"></span>Related Products <span class="right-span"></span></h3>
                        <!-- <p>Redefining silver jewelry with unwavering quality and timeless Indian elegance</p> -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="owl-carousel Featured-carousel owl-theme">
                         @foreach($related as $key => $value)
                        <div class="item">
                            <div class="Featured-product">
                                <a href="{{ route('view_products', ['id' => $value->id]) }}" class="view-a">
                                    <div class="Featured-product-img">
                                        @if(($value->featured_product_img) )
                                            <img src="{{ asset($product_path.'/'.$value->featured_product_img) }}" alt="">
                                           @else
                                                    <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}">
                                            @endif  
                                            <!--<div class="product-icon-container">-->
                                               
                                            <!--</div>-->
                                        
                                    </div>
                                </a>
                                
                                <div class="Featured-product-info">
                                    <div class="product-title">
                                        <h6><a href="{{ route('view_products', ['id' => $value->id]) }}">{{$value->product_title}}</a></h6>
                                        <!--<span>-->
                                        <!--     <a href="#!"><i class="fa-solid fa-code-compare"></i></a> -->
                                           
                                          
                                        <!--</span>-->
                                    </div>
                                    <!--<p><?php echo $value->product_desc; ?></p>-->
                                    <div class="product-features-price">
                                          @if($value->discounted_price > 0)
                                            <p class="price">
                                                <strike>₹ {{ $value->original_price }}</strike>&ensp;₹ {{ $value->discounted_price }}
                                            </p>
                                        @else
                                            <p class="price">₹ {{ $value->original_price }}</p>
                                        @endif
                                    <p class="stock" style="font-size: 14px;">In Stock: {{$value->onhand_qty}}</p>
                                    </div>
                                     <div class="bottom-ftr-btns">
                                     <a href="javascript:void(0)" class="gj_add2cart icons-p" data-cart-id="{{$value->id}}"><i class="fa-solid fa-bag-shopping"></i><div class="clearfix"></div></a>
                                            <a href="" data-wish-id="{{$value->id}}" class="gj_wish_list icons-p"><i class="fa-regular fa-heart"></i></a>
                                         <a href="{{ route('view_products', ['id' => $value->id]) }}" ><i class="fa-solid fa-cart-shopping"></i></a>
                                </div>
                                   
                                  

                                </div>


                            </div>
                        </div>
                        @endforeach
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    
    
    <section class="pb-5" >
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title column-title">
                        <h3><span class="left-span"></span>Customer Ratings <span class="right-span"></span></h3>
                        <!-- <p>Redefining silver jewelry with unwavering quality and timeless Indian elegance</p> -->
                    </div>
                </div>
               
                
                @if (count($review) != 0)
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                        <div class="ps-block--average-rating">
                            <div class="ps-block__header">
                                @if($average != 0)
                                    <!--<h3 class="gj_avg_str">{{round($average)}}</h3>-->

                                    <?php 
                                    $r_average = round($average); 
                                    $tot_rev = 5;
                                    ?>
                                    <div class="d-flex align-items-center mb-2">
                                        <h3 class="mb-0 me-2">{{ $r_average }}</h3>
                                        <div>
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $r_average)
                                                    <i class="fa fa-star text-warning"></i>
                                                @else
                                                    <i class="fa fa-star-o text-muted"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                @else
                                    <h3 class="gj_avg_str">0</h3>
                                @endif
                            </div>
                            @php
                                $ratings = [
                                    5 => round(($stars['review5'] / count($review)) * 100, 2),
                                    4 => round(($stars['review4'] / count($review)) * 100, 2),
                                    3 => round(($stars['review3'] / count($review)) * 100, 2),
                                    2 => round(($stars['review2'] / count($review)) * 100, 2),
                                    1 => round(($stars['review1'] / count($review)) * 100, 2),
                                ];
                            @endphp
                                                        
                            @foreach($ratings as $star => $percent)
                                <div class="d-flex align-items-center mb-1" style="font-size: 14px;">
                                    <div style="width: 60px;">{{ $star }} Star</div>
                                    <div class="progress flex-grow-1 mx-2" style="height: 8px; background-color: #eee;">
                                        <div class="progress-bar bg-warning" style="width: {{ $percent }}%; height: 8px;"></div>
                                    </div>
                                    <div style="width: 40px;">{{ $percent }}%</div>
                                </div>
                                
                            @endforeach
                             <div class="mt-4">
                    <h5 class="mb-3">Customer Reviews</h5>
                    @foreach($review as $r)
                        <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong>{{ $r->ReviewUser->full_name ?? 'Anonymous' }}</strong>
                            <small class="text-muted">{{ date('F d, Y', strtotime($r->created_at)) }}</small>
                        </div>

                        {{-- Rating --}}
                        <div class="mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $r->rating)
                                    <i class="fa fa-star text-warning"></i>
                                @else
                                    <i class="fa fa-star-o text-muted"></i>
                                @endif
                            @endfor
                        </div>

                        {{-- Review Text --}}
                        <p class="mb-0">{{ $r->description }}</p>
                    </div>
                @endforeach
                <div class="mt-3">
                    {{ $review->links() }}
                </div>
            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-12">
                        <p class="gj_no_data no-data-box">Reviews Not Available For This Product</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
    
    
@endif

    <div id="compareModal" class="modal compare-modal-cs" style="display:none; ">
        
       <div class="compare-container">
           <div class="compare-top-pop">
               <h3>Compare Product</h3>
                 <span class="close-btn" style="float:right; cursor:pointer;">&times;</span>
           </div>
          
        <div class="row">
            <div class="col-lg-6 mb-2">
                 <div id="compareDetails" class="compare-left">
                    <div>
                        <img id="mainProductImage"  src="{{ asset($product_path.'/'.$products->featured_product_img)}}" data-original="{{ asset($product_path.'/'.$products->featured_product_img)}}" width="300">
                        <h3>{{$products->product_title}}</h3>
                        <p class="mt-2"><span>₹ {{$products->product_cost}}</span> &ensp;<strike>₹ {{$products->discounted_price}}</strike> </p>
                        <p>Category: {{$products->MainCat->main_cat_name}}</p>
                        <p><?php echo $products->product_desc; ?></p>
                        <div class="product-colors">
                            <ul>
                            @if(($products['att']) && (count($products['att']) != 0))
                                @foreach($products['att'] as $key => $value)
                                <li>
                                    <!--<span class="bg_1" style="color:{{$value->colors}}"></span>-->
                                    <span 
                                        class="compare_color-swatch" 
                                        style="background-color: {{ $value->colors }}; display: inline-block; width: 25px; height: 25px; border-radius: 50%; cursor: pointer;"
                                        data-image="{{ asset($product_att_path.'/'.$value->image) }}" data-id="{{$value->id}}">
                                    </span>
                                </li>
                                
                                @endforeach
                            @endif
                               
                            </ul>
                         </div>
                    </div>
                 </div>
            </div>
            <div class="col-lg-6 mb-2">
                 <div id="compareProductBox" class="compare-left compare-right">
          
            <div id="compareBoxContent"><h6>Details Here</h6></div>
        </div>
            </div>
        </div>
       
       
    
        <h4></h4>
        <div class="row">
                <div class="col-lg-12">
                    <div class="owl-carousel Featured-carousel owl-theme carousel-pop" id="relatedProducts"> 
                        
                    </div>
                </div>
            </div>
       
       </div>
    </div>

<!--<a href="javascript:void(0)" class="gj_add2cart" data-cart-id="${item.id}"><i class="fa-solid fa-bag-shopping"></i><div class="clearfix"></div></a>-->

<!-- SUB CATEGORY SECTION END -->
@endsection

@section('before_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/3.0.8/jquery.elevatezoom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

<script>
$('.color-swatch').on('click', function () {

    // UI highlight (optional)
    $('.color-swatch').removeClass('active');
    $(this).addClass('active');

    let colorId   = $(this).data('id');
    let colorName = $(this).data('color-name');

    $('#selected_color_id').val(colorId);
    $('#selected_color_name').val(colorName);
});
</script>


<script>
$(document).ready(function () {
    let zoomActive = false;

    function initZoom() {
        $('#mainImg').elevateZoom({
            zoomType: "lens",
            lensShape: "round",
            lensSize: 180,           
            scrollZoom: true,
            easing: true,
            responsive: true,
            borderSize: 1,
            containLensZoom: true,
            lensFadeIn: 200,
            lensFadeOut: 200,
            cursor: "crosshair",
            zoomLevel: 1.2           
        });
        zoomActive = true;
    }

    function removeZoom() {
        $.removeData($('#mainImg')[0], 'elevateZoom');
        $('.zoomContainer').remove();
        zoomActive = false;
    }

    $(document).on('click', '#mainImg', function (e) {
        e.preventDefault();
        if (!zoomActive) {
            initZoom();
        } else {
            removeZoom();
        }
    });

    $('.thumb-img').on('click', function () {
        const newSrc = $(this).attr('src');
        replaceMainImage(newSrc);
    });

    function replaceMainImage(newSrc) {
        removeZoom();

        $('#mainImg').parent('a').attr('href', newSrc); 
        $('#mainImg')
            .attr('src', newSrc)
            .attr('data-zoom-image', newSrc);

        zoomActive = false;
    }

    $(document).on('dblclick', '#mainImg', function () {
        $(this).parent('a')[0].click(); // trigger lightbox
    });
});
</script>

<script>
    document.querySelectorAll('.copy-link-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');
            navigator.clipboard.writeText(url).then(() => {
                alert('Link copied to clipboard!');
            });
        });
    });
</script>


<script>
    $(document).ready(function() {
    $('.close-btn').on('click', function() {
        location.reload(); // Refreshes the page
    });
});

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const thumbnails = document.querySelectorAll('.thumb-img');
        const mainImage = document.getElementById('mainImg');

        thumbnails.forEach(function (thumb) {
            thumb.addEventListener('click', function () {
                mainImage.src = this.src;
            });
        });
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let selectedColorId = ''; 

    document.querySelectorAll('.color-swatch').forEach(function (swatch) {
        swatch.addEventListener('click', function () {
            const newImage = this.getAttribute('data-image');
            selectedColorId = this.getAttribute('data-id'); // Get ID instead of color
            const colorName = this.getAttribute('data-color-name');

            // Change main image
            document.getElementById('mainImg').setAttribute('src', newImage);

            // Remove active class from all swatches
            document.querySelectorAll('.color-swatch').forEach(el => el.classList.remove('active'));
            this.classList.add('active');

            // Hide all color names
            document.querySelectorAll('.color-name').forEach(function(el) {
                el.style.display = 'none';
            });

            // Show clicked color's name
            let nameContainer = this.parentElement.querySelector('.color-name');
            if (nameContainer) {
                nameContainer.textContent = colorName;
                nameContainer.style.display = 'block';
            }

        });
    });
});
</script>


<script>
    $(document).ready(function() {
        $('.compare_color-swatch').on('click', function() {
            // Get the new image URL from the clicked swatch
            var newImage = $(this).data('image');

            $('#compareDetails img').attr('src', newImage);
        });
    });
</script>



<script>
const att_pathBase = "{{ asset('images/attributes') }}";
const assetBase = "{{ asset('images/featured_products') }}";
$(document).on('click', '.product-compare', function () {
    var productId = $(this).data('product-id');
    var compareUrl = "{{ route('compare.product', ':id') }}".replace(':id', productId);

    $.ajax({
        url: compareUrl,
        type: 'GET',
        success: function (res) {
            let product = res.product;
            let related = res.related;

            let relatedHtml = '';
            if (related.length > 0) {
                related.forEach(item => {
                    relatedHtml += `
                        <div class="item related-product-card" data-product='${JSON.stringify(item)}'>
                            <div style="position: relative;">
                                <input type="radio" class="compare-checkbox" name="compareGroup" data-product-id="${item.id}" style="position: absolute; top: 10px; left: 10px; z-index: 1;">
                                <img src="${assetBase}/${item.featured_product_img}" width="120" class="compare-img">
                            </div>
                            <p class="mt-2"><span>₹ ${item.product_cost}</span> &ensp;<strike>₹ ${item.discounted_price}</strike> </p>
                            <p>${item.product_title}</p>
                            <input type="hidden" id="price" name="price" value="${item.original_price}" class="quantity-selector">
                        </div>`;
                });
            } else {
                relatedHtml = `<div class="text-center p-3">There are no related products available.</div>`;
            }
            $('#relatedProducts').html(relatedHtml);


            // Show the modal
            $('#compareModal').fadeIn();
        }
    });
});


$(document).on('click', '.close-btn', function () {
    $('#compareModal').fadeOut();
    // $('#compareDetails').html('');
    $('#relatedProducts').trigger('destroy.owl.carousel').html('');
});

</script>
<script>
    $(document).on('change', '.compare-checkbox', function () {
        let productData = $(this).closest('.related-product-card').data('product');
        showProductDetails(productData);
    });

    $(document).on('click', '.compare-img', function () {
        let parentCard = $(this).closest('.related-product-card');
        parentCard.find('.compare-checkbox').prop('checked', true).trigger('change');
    });

    function showProductDetails(productData) {
        let colorSwatchesHtml = '';

        if (productData.att && productData.att.length > 0) {
            colorSwatchesHtml += `<div class="product-colors mt-2"><ul style="list-style: none; padding-left: 0; display: flex; gap: 10px;">`;
    
            productData.att.forEach(function (attr) {
                colorSwatchesHtml += `
                    <li>
                        <span 
                            class="color-swatch-box" 
                            style="background-color: ${attr.colors}; display: inline-block; width: 25px; height: 25px; border-radius: 50%; cursor: pointer;"
                            data-image="${assetBase + '/' + attr.image}">
                        </span>
                    </li>`;
            });
    
            colorSwatchesHtml += `</ul></div>`;
        }
        let detailHtml = `
            <img src="${assetBase}/${productData.featured_product_img}" width="300"><br>
            <strong>${productData.product_title}</strong><br>
            <p class="price"><span>₹ ${productData.product_cost}</span>  &ensp;<strike>₹ ${productData.discounted_price}</strike> </p>
            <p>Category: ${productData.main_cat?.main_cat_name ?? 'N/A'}</p>
            <p>${productData.product_desc ?? ''}</p>
            ${colorSwatchesHtml}
        `;
        $('#compareBoxContent').html(detailHtml);
    }
</script>


<script>
    $(document).ready(function () {
        $("#quoteForm").on('submit', function (e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            
            $.ajax({
                type: "POST",
                url: "",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert(response.success);
                    $("#quoteForm")[0].reset();
                },
                error: function (error) {
                    console.log(error);
                    alert("Something went wrong!");
                }
            });
        });
    });
</script>
  <script type="text/javascript">
   $(document).ready(function () {
    let onhand_qty = {{ $products->onhand_qty ?? 0 }};
     let productName = "{{ $products->product_title ?? 'this product' }}";
     
     function showStockMessage(message) {
            $('#stock-message').text(message).fadeIn();

            // Hide the message after 3 seconds
            setTimeout(function () {
                $('#stock-message').fadeOut();
            }, 5000);
        }

    function calculate(qty) {
        qty = parseInt(qty);
        if (isNaN(qty) || qty <= 0) qty = 1;

         if (qty > onhand_qty) {
        //     qty = onhand_qty;
        //     $.confirm({
        //         title: '',
        //         content: 'Sorry, we are out of stock for this product, we shall add more soon :)',
        //         icon: 'fa fa-exclamation',
        //         theme: 'modern',
        //         closeIcon: true,
        //         animation: 'scale',
        //         type: 'purple',
        //         buttons: {
        //             Ok: function () { }
        //         }
        //     });
         showStockMessage('Only ' + onhand_qty + ' piece(s) available in stock for "' + productName + '"!');
          
         }

        $('#qty').val(qty);

        // Optional: disable/enable buttons based on limits
        $('.gj_subtract_product').prop('disabled', qty <= 1);
        // $('.gj_add_product').prop('disabled', qty >= onhand_qty);
    }

    $('.gj_add_product').on('click', function () {
        let qty = parseInt($('#qty').val()) || 1;
        qty += 1;
        calculate(qty);
        
    });

    $('.gj_subtract_product').on('click', function () {
        let qty = parseInt($('#qty').val()) || 1;
        qty = qty > 1 ? qty - 1 : 1;
        calculate(qty);
    });

    // ✅ Handle manual input
    $('#qty').on('input', function () {
        let qty = parseInt($(this).val()) || 1;
        calculate(qty);
    });

    calculate(1);
});

</script>

<script>
$(document).on('click', '.buy-now-btn', function () {

    if (!validateAttributes()) {
        return false; 
    }
    var productId = $(this).data('product-id');
    var qtyBox = $(this).closest('.product-qty-box');
    var quantity = parseInt(qtyBox.find('input[name="quantity"]').val()) || 1;
    let onhand_qty = {{ $products->onhand_qty ?? 0 }};

    if (quantity  > onhand_qty) {
        quantity  = onhand_qty;
        $.confirm({
            title: '',
            content: 'Sorry, we are out of stock for this product, we shall add more soon :)',
            icon: 'fa fa-exclamation',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'purple',
            buttons: {
                Ok: function () { }
            }
        });
    }
    else{
    $.ajax({
        url: "{{ route('cart.buyNow') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            product_id: productId,
            quantity: quantity
        },
        success: function(response) {
            // Redirect to checkout if product was added successfully
            if (response.status === 'success') {
                window.location.href = "{{ route('checkout') }}";
            } else if (response.status === 'unauthenticated') {
                // alert(response.message); 
               window.location.href = response.redirect_url;
            
            }else {
                alert(response.message || 'Something went wrong.');
            }
        },
        error: function(xhr) {
            alert('Error occurred. Try again.');
        }
    });
    }
});
</script>


    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=6020ff9d502e4d0011f5f290&product=inline-share-buttons" async="async"></script>
@endsection