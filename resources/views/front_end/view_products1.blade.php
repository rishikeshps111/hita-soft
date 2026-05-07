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

@section('content')
<!-- SUB CATEGORY SECTION START -->
@if($products)
<section class="gj_view_product_sec">
    <div class="ps-page--product">
        <div class="ps-container">
            <div class="ps-page__container">
                <div class="ps-page__left">
                    <div class="ps-product--detail ps-product--fullwidth">
                        <div class="ps-product__header">
                            <div class="ps-product__thumbnail" data-vertical="true">
                                <figure>
                                    <div class="ps-wrapper">
                                        <div class="ps-product__gallery" data-arrow="true">
                                            @if(($products['images']) && (count($products['images']) != 0))
                                                @foreach($products['images'] as $key => $value)
                                                    <div class="item"><a href="{{ asset($product_img_path.'/'.$value->image)}}"><img src="{{ asset($product_img_path.'/'.$value->image)}}" alt=""></a>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="item"><a href="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}"><img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}" alt=""></a></div>
                                            @endif
                                        </div>
                                        <div style="border: 1px solid red;bottom: 80px; margin-top: 10px;padding: 10px;">
                                             <span class="notice-for-instruction" style="margin: 0 auto;color:red;"><strong>Product images shown in this site are representational only.Actuals will vary.</strong></span>
                                        </div>
                                        
                                    </div>
                                </figure>
                                <div class="ps-product__variants" data-item="4" data-md="4" data-sm="4" data-arrow="false">
                                    @if(($products['images']) && (count($products['images']) != 0))
                                        @foreach($products['images'] as $key => $value)
                                            <div class="item"><img src="{{ asset($product_img_path.'/'.$value->image)}}" alt=""></div>
                                        @endforeach
                                    @else
                                        <div class="item"><img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}" alt=""></div>
                                    @endif
                                </div>
                            </div>
                            <div class="ps-product__info">
                                <h1>{{$products->product_title}}</h1>
                                <div class="ps-product__meta">
                                     
                                    <div class="ps-product__rating">
                                        <select class="ps-rating" data-read-only="true">
                                            <option value="1">1</option>
                                            <option value="1">2</option>
                                            <option value="1">3</option>
                                            <option value="1">4</option>
                                            <option value="2">5</option>
                                        </select><span>(1 review)</span>
                                    </div>
                                </div>

                                <h4 class="ps-product__price"> 
                                    <span class="money"> <i class="fa fa-inr"></i> <span class="gj_vw_mny">{{$products->discounted_price}}</span></span>
                                    <del><span class="gj_mrp"> <i class="fa fa-inr"></i> {{$products->original_price}}</span></del>
                                </h4>

                                <div class="ps-product__desc">
                                    <!--<p>  Status:<a href="#">-->
                                    <!--    <strong class="ps-tag--in-stock"> -->
                                    <!--        @if($products->onhand_qty != 0)-->
                                    <!--            <i class="fa fa-check-square-o"></i> In stock-->
                                    <!--        @else-->
                                    <!--            <i class="fa fa-window-close-o"></i> Out of stock-->
                                    <!--        @endif-->
                                    <!--    </strong></a>-->
                                    <!--</p>-->

                                    <!--<ul class="ps-list--dot">-->
                                    <!--    <li> Unrestrained and portable active stereo speaker</li>-->
                                    <!--    <li> Free from the confines of wires and chords</li>-->
                                    <!--    <li> 20 hours of portable capabilities</li>-->
                                    
                                    <!--</ul>-->
                                    
                                      <!--<p> Sold By:<a class="mr-20" href="#"><strong> Marlix </strong></a> </p>-->
                                </div>
                       
                       
                        {{-- <figure>
                            <h4 class="widget-title">By Color</h4>
                            <div class="ps-checkbox ps-checkbox--color color-1 ps-checkbox--inline">
                                <input class="form-control" type="checkbox" id="color-1" name="size">
                                <label for="color-1"></label>
                            </div>
                            <div class="ps-checkbox ps-checkbox--color color-2 ps-checkbox--inline">
                                <input class="form-control" type="checkbox" id="color-2" name="size">
                                <label for="color-2"></label>
                            </div>
                            <div class="ps-checkbox ps-checkbox--color color-3 ps-checkbox--inline">
                                <input class="form-control" type="checkbox" id="color-3" name="size">
                                <label for="color-3"></label>
                            </div>
                            <div class="ps-checkbox ps-checkbox--color color-4 ps-checkbox--inline">
                                <input class="form-control" type="checkbox" id="color-4" name="size">
                                <label for="color-4"></label>
                            </div>
                            <div class="ps-checkbox ps-checkbox--color color-5 ps-checkbox--inline">
                                <input class="form-control" type="checkbox" id="color-5" name="size">
                                <label for="color-5"></label>
                            </div>
                            <div class="ps-checkbox ps-checkbox--color color-6 ps-checkbox--inline">
                                <input class="form-control" type="checkbox" id="color-6" name="size">
                                <label for="color-6"></label>
                            </div>
                            <div class="ps-checkbox ps-checkbox--color color-7 ps-checkbox--inline">
                                <input class="form-control" type="checkbox" id="color-7" name="size">
                                <label for="color-7"></label>
                            </div>
                            <div class="ps-checkbox ps-checkbox--color color-8 ps-checkbox--inline">
                                <input class="form-control" type="checkbox" id="color-8" name="size">
                                <label for="color-8"></label>
                            </div>
                        </figure> --}}
                        {{-- <figure class="sizes silozkq">
                            <h4 class="widget-title">BY SIZE</h4><a href="#">L</a><a href="#">M</a><a href="#">S</a><a href="#">XL</a>
                        </figure> --}}
                       
                                <div class="ps-product__shopping">
                                    <figure>
                                        <figcaption>Quantity</figcaption>
                                        <div class="form-group--number">
                                            <button class="up gj_add_product"><i class="fa fa-plus"></i></button>
                                            <button class="down gj_subtract_product"><i class="fa fa-minus"></i></button>
                                            <input class="form-control"id="qty" name="quantity" value="1" min="1" type="text" placeholder="">

                                            <input type="hidden" id="price" name="price" value="{{$products->discounted_price}}" class="quantity-selector">

                                            <input type="hidden" name="id" value="{{$products->id}}" />
                                        </div>
                                    </figure>

                                    <a class="ps-btn ps-btn--black gj_add2cart" href="javascript:void(0)" title="Add to cart" data-cart-id="{{$products->id}}">Add to cart</a>

                                    <a class="ps-btn" href="{{route('checkout')}}">Buy Now</a>

                                    <div class="ps-product__actions">
                                        <a class="gj_wish_list" href="" title="Wishlist" data-wish-id="{{$products->id}}">
                                            <i class="icon-heart gj_wish_hrt"></i>
                                        </a>
                                        <!--<a href="#"><i class="icon-chart-bars"></i></a>-->
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                        <div class="ps-product__content ps-tab-root">
                        
                            <ul class="ps-tab-list">
                                <li class="active"><a href="#tab-1">Description</a></li>
                                <li><a href="#tab-2">Specification</a></li>
                               
                                <li><a href="#tab-4">Reviews ({{count($review)}})</a></li>
                             
                            </ul>
                            <div class="ps-tabs">
                                <div class="ps-tab active" id="tab-1">
                                    <div class="ps-document gj_prod_descs">
                                        <?php echo $products->product_desc; ?>
                                    </div>
                                </div>

                                <div class="ps-tab" id="tab-2">
                                    <div class="gj_pro_features">
                                        <?php echo $products->features; ?>
                                    </div>
                                </div>
                        
                                <div class="ps-tab" id="tab-4">
                                    <div class="row">
                                        @if (count($review) != 0)
                                            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12 ">
                                                <div class="ps-block--average-rating">
                                                    <div class="ps-block__header">
                                                        @if($average != 0)
                                                            <h3 class="gj_avg_str">{{round($average)}}</h3>

                                                            <?php 
                                                            $r_average = round($average); 
                                                            $tot_rev = 5;
                                                            ?>

                                                            <select class="ps-rating" data-read-only="true">
                                                                <option <?php if($r_average == 1) { echo 'selected'; } ?> value="1">1</option>
                                                                <option <?php if($r_average == 2) { echo 'selected'; } ?> value="2">2</option>
                                                                <option <?php if($r_average == 3) { echo 'selected'; } ?> value="3">3</option>
                                                                <option <?php if($r_average == 4) { echo 'selected'; } ?> value="4">4</option>
                                                                <option <?php if($r_average == 5) { echo 'selected'; } ?> value="5">5</option>
                                                            </select>

                                                            <span>{{count($review)}} Review(s)</span>
                                                        @else
                                                            <h3 class="gj_avg_str">0</h3>
                                                        @endif
                                                    </div>

                                                    <div class="ps-block__star"><span>5 Star</span>
                                                        @php $st5 = round(($stars['review5'] / count($review)) * 100, 2); @endphp

                                                        <div class="ps-progress" data-value="{{$st5}}"><span></span></div><span>{{($st5) != 0 ? $st5.'%' : '0'}}</span>
                                                    </div>
                                                    <div class="ps-block__star"><span>4 Star</span>
                                                        @php $st4 = round(($stars['review4'] / count($review)) * 100, 2); @endphp

                                                        <div class="ps-progress" data-value="{{$st4}}"><span></span></div><span>{{($st4) != 0 ? $st4.'%' : '0'}}</span>
                                                    </div>
                                                    <div class="ps-block__star"><span>3 Star</span>
                                                        @php $st3 = round(($stars['review3'] / count($review)) * 100, 2); @endphp

                                                        <div class="ps-progress" data-value="{{$st3}}"><span></span></div><span>{{($st3) != 0 ? $st3.'%' : '0'}}</span>
                                                    </div>
                                                    <div class="ps-block__star"><span>2 Star</span>
                                                        @php $st2 = round(($stars['review2'] / count($review)) * 100, 2); @endphp

                                                        <div class="ps-progress" data-value="{{$st2}}"><span></span></div><span>{{($st2) != 0 ? $st2.'%' : '0'}}</span>
                                                    </div>
                                                    <div class="ps-block__star"><span>1 Star</span>
                                                        @php $st1 = round(($stars['review1'] / count($review)) * 100, 2); @endphp

                                                        <div class="ps-progress" data-value="{{$st1}}"><span></span></div><span>{{($st1) != 0 ? $st1.'%' : '0'}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <p class="gj_no_data">Reviews Not Available This Product</p>
                                        @endif

                                        <!-- <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12 ">
                                            <?php 
                                            $value_usr = session()->get('user');
                                            ?>
                                            @if($value_usr)
                                                @if($value_usr->user_type == 4)
                                                    {{ Form::open(array('url' => 'submit_review','class'=>'gj_rw_form ps-form--review','files' => true)) }}
                                                        <h4>Submit Your Review</h4>
                                                        <p>Your email address will not be published. Required fields are marked<sup>*</sup></p>
                                                        <div class="form-group form-group__rating">
                                                            <label>Your rating of this product</label>
                                                            <select class="ps-rating" data-read-only="false" name="rating">
                                                                <option value="0">0</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <textarea class="form-control" rows="6" placeholder="Write your review here" name="description"></textarea>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12  ">
                                                                <div class="form-group">
                                                                    <input readonly class="form-control" type="text" placeholder="Your Name" value="{{$value_usr->first_name}} {{$value_usr->last_name}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12  ">
                                                                <div class="form-group">
                                                                    <input readonly class="form-control" type="email" placeholder="Your Email" value="{{$value_usr->email}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="product_id" id="gj_rw_product_id">
                                                        
                                                        <input type="hidden" name="user_id" id="gj_rw_user_id" value="{{$value_usr->id}}">

                                                        <div class="form-group submit">
                                                            <button class="ps-btn" type="submit">Submit Review</button>
                                                        </div>
                                                    {{ Form::close() }}
                                                @endif
                                            @endif
                                        </div> -->
                                    </div>
                                </div>
                     
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ps-page__right">
                    <aside class="widget widget_product widget_features">
                        <p><i class="icon-network"></i> Shipping worldwide</p>
                        <p><i class="icon-3d-rotate"></i> Free 7-day return if eligible, so easy</p>
                        <p><i class="icon-receipt"></i> Supplier give bills for this product.</p>
                        <p><i class="icon-credit-card"></i> Pay online or when receiving goods</p>
                    </aside>
                     
                     <aside class="widget widget_shop">
                        <h4 class="widget-title">Categories</h4>
                        <!-- <ul class="ps-list--categories">
                            <li class="current-menu-item menu-item-has-children"><a href="#">Clothing &amp; Apparel</a><span class="sub-toggle"><i class="fa fa-angle-down"></i></span>
                                <ul class="sub-menu">
                                    <li class="current-menu-item "><a href="#">Womens</a>
                                    </li>
                                    <li class="current-menu-item "><a href="#">Mens</a>
                                    </li>
                                    <li class="current-menu-item "><a href="#">Bags</a>
                                    </li>
                                    <li class="current-menu-item "><a href="#">Sunglasses</a>
                                    </li>
                                    <li class="current-menu-item "><a href="#">Accessories</a>
                                    </li>
                                    <li class="current-menu-item "><a href="#">Kid's Fashion</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="current-menu-item menu-item-has-children"><a href="#">Garden &amp; Kitchen</a><span class="sub-toggle"><i class="fa fa-angle-down"></i></span>
                                <ul class="sub-menu">
                                    <li class="current-menu-item "><a href="#">Cookware</a>
                                    </li>
                                    <li class="current-menu-item "><a href="#">Decoration</a>
                                    </li>
                                    <li class="current-menu-item "><a href="#">Furniture</a>
                                    </li>
                                    <li class="current-menu-item "><a href="#">Garden Tools</a>
                                    </li>
                                    <li class="current-menu-item "><a href="#">Home Improvement</a>
                                    </li>
                                    <li class="current-menu-item "><a href="#">Powers And Hand Tools</a>
                                    </li>
                                    <li class="current-menu-item "><a href="#">Utensil &amp; Gadget</a>
                                    </li>
                                </ul>
                            </li>
                            
                            <li class="current-menu-item "><a href="#">Babies &amp; Moms</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Books &amp; Office</a>
                            </li>
                            <li class="current-menu-item "><a href="#">Cars &amp; Motocycles</a>
                            </li>
                        </ul> -->

                        <ul class="ps-list--categories">
                            <li class="current-menu-item " style="list-style:none;"><a href="{{ route('sub_category', ['main_cat' => $products->main_cat_name]) }}" title="{{$products->MainCat->main_cat_name}}">{{$products->MainCat->main_cat_name}}</a></li>
                            <li class="current-menu-item " style="list-style:none;"><a href="{{ route('sub_sub_category', ['sub_cat' => $products->sub_cat_name]) }}" title="{{$products->SubCat->sub_cat_name}}">{{$products->SubCat->sub_cat_name}}</a></li>
                            <li class="current-menu-item " style="list-style:none;"><a href="{{ route('sub_sub_category_products', ['sub_sub_cat' => $products->sub_cat_name]) }}" title="{{$products->SubSubCat->sub_sub_cat_name}}">{{$products->SubSubCat->sub_sub_cat_name}}</a></li>
                        </ul>
                    </aside>
                    
                    
                    <aside class="widget widget_ads ps-product--detail"> 
                    
                    <!-- <div class="ps-product__sharing">-->
                        <!-- <div class="sharethis-inline-share-buttons"></div> -->

                    <!--    <a href="https://facebook.com/sharer/sharer.php?u={{ route('view_products', $products->id) }}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Facebook" class="facebook"><i class="fa fa-facebook"></i> </a>-->

                    <!--    <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}&t={{$products->product_title}}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Twitter" class="twitter"><i class="fa fa-twitter"></i> </a>-->

                    <!--    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(Request::fullUrl()) }}&t={{$products->product_title}}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Linkedin" class="linkedin"><i class="fa fa-linkedin"></i> </a>-->

                        <!-- <a href="https://www.instagram.com/?url={{ urlencode(Request::fullUrl()) }}&t={{$products->product_title}}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Instagram" class="instagram"><i class="fa fa-instagram"></i> </a> -->

                        <!-- <a class="google" href="#"><i class="fa fa-google-plus"></i></a> -->
                    <!--</div>-->
                     
                     </aside>
                  
                </div>
            </div>
            
            @if(($related) && (count($related) != 0))
                <div class="ps-section--default">
                    <div class="ps-section__header">
                        <h3>Related products</h3>
                    </div>
                    <div class="ps-section__content prodlistz">
                        <div class="ps-carousel--nav owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="10000" data-owl-gap="30" data-owl-nav="true" data-owl-dots="true" data-owl-item="6" data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-item-xl="5" data-owl-duration="1000" data-owl-mousedrag="on">
                            @foreach($related as $key => $value)
                                <div class="ps-product">
                                    <div class="ps-product__thumbnail">
                                        <a href="{{ route('view_products', ['id' => $value->id]) }}">
                                            <img src="{{ asset($product_path.'/'.$value->featured_product_img) }}" alt="">
                                        </a>
                                    </div>

                                    <div class="ps-product__container"> 
                                        <div class="ps-product__content"><a class="ps-product__title" href="{{ route('view_products', ['id' => $value->id]) }}">{{$value->product_title}}</a>
                                            
                                            <p class="ps-product__price"> <span class="money"> <i class="fa fa-inr"></i> </span>{{$value->discounted_price}}</p>
                                        </div>
                                        <div class="ps-product__content hover"><a class="ps-product__title" href="{{ route('view_products', ['id' => $value->id]) }}">{{$value->product_title}}</a>
                                            <p class="ps-product__price"> <span class="money"> <i class="fa fa-inr"></i> </span>{{$value->discounted_price}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@else
<section class="gj_view_product_sec">
    <div class="main-content maxil" id="MainContent">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="gj_no_data">Data Not Available</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- SUB CATEGORY SECTION END -->
@endsection

@section('before_scripts')
    <script type="text/javascript">
        function calculate() {
            @if($products->onhand_qty != 0)
                var onhand_qty = <?php echo $products->onhand_qty; ?>;
            @else
                var onhand_qty = 0;
            @endif
            var f_qty = $('#qty').val();
            var price = $('#price').val();
            var tot = 0.00;
            if ((f_qty != '') && (price != '')) {
                qty = parseInt(f_qty);
                if(qty == 0) {
                    qty = parseInt(1);    
                }
                if(qty <= onhand_qty) {
                    tot = qty * price;
                    // $('.gj_tot_price').html(tot);
                    $('#qty').val(qty);
                } else {
                    tot = 1 * price;
                    // $('.gj_tot_price').html(tot);
                    $('#qty').val(1);
                    $.confirm({
                        title: '',
                        content: 'Remaining only <?php echo $products->onhand_qty; ?> items.',
                        icon: 'fa fa-exclamation',
                        theme: 'modern',
                        closeIcon: true,
                        animation: 'scale',
                        type: 'purple',
                        buttons: {
                            Ok: function(){
                            }
                        }
                    });
                }
            }
        }

        $(document).ready(function() { 
            var qty = 1;
            var price = $('#price').val();
            var tot = 0.00;
            if ((qty != '') && (price != '')) {
                qty = parseInt(qty);
                tot = qty * price;
                // $('.gj_tot_price').html(tot);
                $('#qty').val(qty);
            }
        });

        $('#qty').on('keyup',function(event) {
            calculate();
        });

        $('.gj_add_product').on('click',function(event) {
            @if($products->onhand_qty != 0)
                var onhand_qty = <?php echo $products->onhand_qty; ?>;
            @else
                var onhand_qty = 0;
            @endif

            var att_qty = 0;
            var f_qty = $('#qty').val();
            var price = $('#price').val();
            var tot = 0.00;
            if ((f_qty != '') && (price != '')) {
                qty = parseInt(f_qty) + 1;
                if(qty <= onhand_qty) {
                    if($('#gj_vw_att_qty').val()) {
                        att_qty = $('#gj_vw_att_qty').val();
                        if(qty <= att_qty) {
                            tot = qty * price;
                            $('.gj_tot_price').html(tot);
                            $('#qty').val(qty);
                        } else {
                            tot = 1 * price;
                            $('.gj_tot_price').html(tot);
                            $('#qty').val(1);
                            $.confirm({
                                title: '',
                                content: 'Remaining only '+ att_qty +' items.',
                                icon: 'fa fa-exclamation',
                                theme: 'modern',
                                closeIcon: true,
                                animation: 'scale',
                                type: 'purple',
                                buttons: {
                                    Ok: function(){
                                    }
                                }
                            });
                        }
                    } else {
                        tot = qty * price;
                        // $('.gj_tot_price').html(tot);
                        $('#qty').val(qty);
                    }
                } else {
                    tot = 1 * price;
                    // $('.gj_tot_price').html(tot);
                    $('#qty').val(1);
                    $.confirm({
                        title: '',
                        content: 'Remaining only <?php echo $products->onhand_qty; ?> items.',
                        icon: 'fa fa-exclamation',
                        theme: 'modern',
                        closeIcon: true,
                        animation: 'scale',
                        type: 'purple',
                        buttons: {
                            Ok: function(){
                            }
                        }
                    });
                }
            }
        });

        $('.gj_subtract_product').on('click',function() {
            var qty = $('#qty').val();
            var price = $('#price').val();
            var tot = 0.00;
            if ((qty != '') && (price != '')) {
                qty = parseInt(qty) - 1;
                if(qty == 0) {
                    qty = 1;
                }
                tot = qty * price;
                // $('.gj_tot_price').html(tot);
                $('#qty').val(qty);
            }
        });
    </script>

    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=6020ff9d502e4d0011f5f290&product=inline-share-buttons" async="async"></script>
@endsection