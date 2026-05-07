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
    <div class="main-content maxil" id="MainContent">
        <div class="container">
            <div class="col-main col-full">
                <div id="shopify-section-product-template" class="shopify-section main-product">
                    <script src="{{ asset('frontend/js/jquery.elevateZoom.min.js')}}" type="text/javascript"></script>
                    <script src="{{ asset('frontend/js/option_selection.js')}}" type="text/javascript"></script>
                    <div id="ProductSection-product-template" class="bzoom product-template__containe product" >
                        <input type="hidden" name="product_id" id="product_id" value="{{$products->id}}">
                        <div class="product-single ">
                            <div class="row">
                                <div class="col-lg-5 col-md-12 col-sm-12 col-12  horizontal">
                                    <div class=" product-media thumbnais-bottom">
                                        <div   class="product-photo-container slider-for horizontal">
                                            @if(($products['images']) && (count($products['images']) != 0))
                                                @foreach($products['images'] as $key => $value)
                                                    <div class="thumb">
                                                        <a class="fancybox" rel="gallery1" href="{{ asset($product_img_path.'/'.$value->image)}}" >
                                                            <img id="pimg_{{$value->id}}" class="product-featured-img" src="{{ asset($product_img_path.'/'.$value->image)}}" alt="{{$value->p_name}}" data-zoom-image="{{ asset($product_img_path.'/'.$value->image)}}"/>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="thumb">
                                                    <a class="fancybox" rel="gallery1" href="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}" >
                                                        <img id="product-featured-image-4774111608943" class="product-featured-img" src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}" alt="Smart TV" data-zoom-image="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}"/>
                                                    </a>
                                                </div>
                                            @endif

                                            @if($products->attributes_flag != 0)
                                                @foreach($products['att'] as $k => $val)
                                                    @if($val->image)
                                                        <div class="thumb">
                                                            <a class="fancybox" rel="gallery1" href="{{ asset($product_att_path.'/'.$val->image)}}" >
                                                                <img id="pimg_{{$value->id}}" class="product-featured-img" src="{{ asset($product_att_path.'/'.$val->image)}}" alt="{{$value->attribute_name}}" data-zoom-image="{{ asset($product_att_path.'/'.$val->image)}}"/>
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                        
                                        <div class="slider-nav horizontal" id="gallery_01">
                                            @if(($products['images']) && (count($products['images']) != 0))
                                                @foreach($products['images'] as $key => $value)
                                                    <div class="item">
                                                        <a class ="thumb" href="javascript:void(0)" data-image="{{ asset($product_img_path.'/'.$value->image)}}" data-zoom-image="{{ asset($product_img_path.'/'.$value->image)}}">
                                                            <img src="{{ asset($product_img_path.'/'.$value->image)}}" alt="{{$value->p_name}}">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="item">
                                                    <a class ="thumb" href="javascript:void(0)" data-image="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}" data-zoom-image="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}">
                                                        <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}" alt="No Images">
                                                    </a>
                                                </div>
                                            @endif

                                            @if($products->attributes_flag != 0)
                                                @foreach($products['att'] as $k => $val)
                                                    @if($val->image)
                                                        <div class="item">
                                                            <a class ="thumb" href="javascript:void(0)" data-image="{{ asset($product_att_path.'/'.$val->image)}}" data-zoom-image="{{ asset($product_att_path.'/'.$val->image)}}">
                                                                <img src="{{ asset($product_att_path.'/'.$val->image)}}" alt="{{$val->attribute_name}}">
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-7 col-md-12 col-sm-12 col-12 product-single__detail grid__item ">
                                    <div class="product-single__meta">
                                        <h1 itemprop="name" class="product-single__title"> {{$products->product_title}} 
                                            @if($products->brand && $products->brand != 0)
                                                <span class="brandzz"> 
                                                    <a href="{{ route('brands_products', ['id' => $products->brand]) }}">
                                                        <img src="{{ asset($brand_img_path.'/'.$products->ProductBrand->brand_image) }}" alt="{{$products->ProductBrand->brand_name}}" class="gj_brd_img">
                                                    </a>
                                                </span> 
                                            @endif
                                        </h1>

                                        <div class="custom-reviews a-left hidden-xs">          
                                            <span class="shopify-product-reviews-badge" data-id="1674859675759"></span>          
                                        </div>

                                        <div class="product-info">
                                            @if($products->model_no)
                                                <p class="product-single__type"><label> Model Number </label>: {{$products->model_no}} </p>
                                            @endif
                                            @if($products->varient)
                                                <p class="product-single__type"><label> Varient </label>: {{$products->varient}} </p>
                                            @endif
                                            <p class="product-single__alb instock">
                                                <label>Availability</label>: 
                                                @if($products->onhand_qty != 0)
                                                    <i class="fa fa-check-square-o"></i> In stock
                                                @else
                                                    <i class="fa fa-window-close-o"></i> Out of stock
                                                @endif
                                            </p>
                                            <p class="product-single__type"><label>Product type</label>: {{$products->MainCat->main_cat_name}}</p>
                                            <!-- <p itemprop="brand" class="product-single__vendor"><label>Vendor</label>: <a href=" " title="Furnicom"> Xioami </a></p> -->
                                            <p itemprop="brand" class="product-single__vendor"><label>Delivery</label>: <input type="text" class="_3X4tVa" placeholder="Enter Delivery Pincode" value="" pattern="[0-9]{6}" maxlength="6" title="Only 6 digit numerical value allowed" placeholder="Eg. 629168" id="pincodeInputId"> <span class="clss" id="gj_pincode_chk"> Check </span><span id="gj_res_pin"></span></p>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="gj_det_atts">
                                            <input type="hidden" name="gj_att_flag" id="gj_att_flag" class="gj_att_flag" value="{{$products->attributes_flag}}">
                                            <input type="hidden" name="gj_vw_att_name" id="gj_vw_att_name" class="gj_vw_att_name">
                                            <input type="hidden" name="gj_vw_att_value" id="gj_vw_att_value" class="gj_vw_att_value">
                                            <input type="hidden" name="gj_vw_att_qty" id="gj_vw_att_qty" class="gj_vw_att_qty">

                                            @if($products->attributes_flag != 0)
                                                @if(isset($products['att_fields']) && count($products['att_fields']) != 0)
                                                    @foreach ($products['att_fields'] as $k => $val)
                                                    <div class="gj_att_div">
                                                        <label class="gj_sele_att_name" data-id="{{$val->id}}">{{$val->att_name}}:</label>
                                                        
                                                        <div class="selectStyle">
                                                            <div id="gj_sele_atts" class="gj_sele_atts"> 
                                                                <ul class="detixz">
                                                                    @if(isset($products['att_values']) && count($products['att_values']) != 0)
                                                                        @foreach ($products['att_values'] as $ky => $vals)
                                                                            @if($vals->att_name == $val->id)
                                                                                <li>
                                                                                    <a href="#0" class="gj_att_vals" data-name="{{$vals->att_name}}" data-val="{{$vals->id}}" @if(isset($products['att']) && count($products['att']) != 0) @foreach ($products['att'] as $kz => $valz) @if(($vals->att_name == $valz->attribute_name) && ($vals->id == $valz->attribute_values)) data-qty="{{$valz->att_qty}}" @endif @endforeach @endif>  {{$vals->att_value}} </a>
                                                                                </li>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    @endforeach
                                                @endif
                                            @endif
                                            
                                            <!-- @if($products->attributes_flag != 0)
                                                <div class="remazcod">
                                                        <div class="gj_s_att">
                                                            <p class="gj_s_att_hd">Attributes</p>
                                                            <select id="gj_vw_attribute_name" name="attribute_name" class="form-control gj_vw_att_name">
                                                                <option value="0">Select Attribute</option>
                                                                @if(isset($products['att_fields']) && count($products['att_fields']) != 0)
                                                                    @foreach ($products['att_fields'] as $k => $val)
                                                                        <option value="{{$val->id}}">{{$val->att_name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                   
                                                        <div class="gj_s_att">
                                                            <p class="gj_s_att_hd">Attributes Values</p>
                                                            <select id="gj_vw_attribute_value" name="attribute_value" class="form-control gj_vw_att_value">
                                                                <option value="0">Select Attribute</option>
                                                            </select>
                                                        </div>
                                                 
                                                </div>
                                            @endif -->
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="clearfix product-price"  >
                                            <p class="price-box product-single__price-product-template">
                                                <span class="special-price product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
                                                    <span id="ProductPrice-product-template" itemprop="price" content="2161.0">
                                                        <span class="money"> &#8377; <span id="gj_vw_mny">{{$products->discounted_price}}</span></span>
                                                        <span class="gj_mrp"> &#8377; {{$products->original_price}}</span>
                                                    </span>
                                                </span>
                                            </p>
                                        </div>

                                        <div>
                                            <form action=" " method="post" enctype="multipart/form-data" class="product-form product-form-product-template product-form--hide-variant-labels" data-section="product-template">
                                                <div id="product-variants">
                                                    <input type="hidden" name="id" value="{{$products->id}}" />
                                                </div>
                                                
                                                <div class="total-price">
                                                    <label>Subtotal: </label><span class="money">&#8377; <span class="money gj_tot_price">{{$products->discounted_price}}</span></span>
                                                </div>

                                                <div class="product-options-bottom">
                                                    <div class="product-form__item product-form__item--quantity">
                                                        <label for="Quantity" class="quantity-selector">Qty:</label> 

                                                        <div class="form_qty">
                                                            <div class="reduced items" id="gj_subtract_product">
                                                                <i class="fa fa-minus"></i>
                                                            </div>

                                                            <input type="text" id="qty" name="quantity" value="1" min="1" class="quantity-selector">

                                                            <input type="hidden" id="price" name="price" value="{{$products->discounted_price}}" class="quantity-selector">

                                                            <div class="increase items" id="gj_add_product">
                                                                <i class="fa fa-plus"></i>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="product-form__item product-form__item--submit">
                                                        <button type="submit" name="add" id="AddToCart-product-template"  class="btn product-form__cart-submit product-form__cart-submit--small gj_add2cart" data-cart-id="{{$products->id}}">
                                                            <span id="AddToCartText-product-template">
                                                                <i class="fa fa-shopping-basket"></i> Add to cart
                                                            </span>
                                                        </button>


                                                        <!-- <button type="submit" name="add" id=" Buy Now"  class="btn product-form__cart-submit product-form__cart-submit--small">
                                                            <span id=" Buy Now">
                                                                <i class="fa fa-shopping-basket"></i> Buy Now
                                                            </span>
                                                        </button> -->
                                                    </div>
                                                </div>

                                                <form method="post" action=" " id="AddToCart-{{ 'section.id' }}" accept-charset="UTF-8" class="shopify-product-form" enctype="multipart/form-data">
                                                    <input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" />

                                                    <div data-shopify="payment-button" class="shopify-payment-button">
                                                        <button class="shopify-payment-button__button shopify-payment-button__button--unbranded shopify-payment-button__button--hidden" disabled="disabled" aria-hidden="true"> </button>
                                                        <button class="shopify-payment-button__more-options shopify-payment-button__button--hidden" disabled="disabled" aria-hidden="true"> </button>
                                                    </div>

                                                    <div class="product-addto-links">
                                                        <a class="btn_df btnProduct gj_wish_list" href="" title="Wishlist" data-wish-id="{{$products->id}}">
                                                            <i class="fa fa-heart gj_wish_hrt"></i>
                                                            <span class="hidden-xs hidden-sm hidden-md">Wishlist</span>
                                                        </a>
                                                    </div>
                                                </form>
                                            </form>
                                        </div>
                                        
                                        <div class="clearfix"></div>
                                        
                                        <div class="product-wrap">
                                            <!-- <div class="simpAsk-container" id="simpAskQuestion">
                                                <div class="simpAsk-title-container">
                                                    <h2>QUESTIONS & ANSWERS</h2>
                                                    <div class="simpAsk-error-msg" style="display:none"></div>
                                                    <div class="simpAsk-success-msg" style="display:none"></div>
                                                </div>

                                                <div class="simp-ask-question-header">
                                                    <div class="simpAskQuestion-Qcontent">
                                                        <h3>Have any Question?</h3>
                                                        <br>
                                                    </div>

                                                    <a href="javascript:void(0)" class="simpAskQuestionForm-btnOpen btn button"><i class="demo-icon icon-simp-help-circled"></i>Ask a Question</a>
                                                </div>

                                                <div class="simpAskForm-container" id="simpAskForm_container" style="display:none;">
                                                    <form method="post" action="" id="askQuestion" class="">
                                                        <input type="hidden" value="contact" name="form_type"/>

                                                        <div class="">
                                                            <input type="hidden" name="simpAskAction" value="askQuestion">
                                                            <input type="hidden" id="simpAskProductId" name="simpAskProductId" value="1674859675759">
                                                            <textarea required="" style="resize:none; min-height:86px;" name="question" placeholder="Type your question here" title="Please Enter Your Question."></textarea>
                                                            <input required="" type="text" name="name" value="" placeholder="Your Name" title="Please Enter Your Name here." class="simpAsk-fifty-percent fleft">
                                                            <input required="" type="email" name="email" value="" placeholder="Your Email" title="Please Enter Your Email." class="simpAsk-fifty-percent fright">
                                                            <div class="simpAskSubmitForm">
                                                                <input class="button button-primary btn btn-primary btn btn--fill btn--color" type="submit" name="submit" value=" Submit">
                                                                <a href="javascript:void(0)" class="simpAskForm-cancel-btn button">Cancel</a>
                                                                <div class="clear"></div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div> -->

                                            <!-- <script type="text/javascript" src="https://sqa.simpshopifyapps.com/shopStyle?shop=Ecambiar.myshopify.com&hashKey=45ae3a92ecd33aa9fe1db2e324c1fb00"></script> -->

                                            <div class="wrap__category detail_category">
                                                <h2>Category: </h2>
                                                <ul class="category_content">
                                                    <li><a href="{{ route('sub_category', ['main_cat' => $products->main_cat_name]) }}" title="{{$products->MainCat->main_cat_name}}">{{$products->MainCat->main_cat_name}}</a></li> , 
                                                    <li><a href="{{ route('sub_sub_category', ['sub_cat' => $products->sub_cat_name]) }}" title="{{$products->SubCat->sub_cat_name}}">{{$products->SubCat->sub_cat_name}}</a></li> , 
                                                    <li><a href="{{ route('sub_sub_category_products', ['sub_sub_cat' => $products->sub_cat_name]) }}" title="{{$products->SubSubCat->sub_sub_cat_name}}">{{$products->SubSubCat->sub_sub_cat_name}}</a></li>
                                                </ul>
                                            </div>

                                            <div class="wrap__category detail_category">
                                                <h2> Seller: </h2>
                                                <ul class="category_content">
                                                    @if($products->created_user == 1)
                                                        <li><a  title=""> Ecambiar</a></li> 
                                                    @else
                                                        @if($products->MStore->store_name)
                                                            <li><a  title=""> {{$products->MStore->store_name}}</a></li> 
                                                        @else
                                                            <li><a  title=""> Merchants</a></li>  
                                                        @endif
                                                    @endif
                                                </ul>
                                            </div>
                                            
                                            <!-- <div class="wrap__category detail_category">
                                                <h2> Warranty: </h2>
                                                <ul class="category_content">
                                                    <li><a href="#" title=""> 1 year</a></li> ,  
                                                </ul>
                                            </div> -->

                                            <!-- <div class="wrap__tag detail_tag">
                                                <h2>Tags:  </h2>
                                                <ul id="details" class="hlist">
                                                    <?php 
                                                        $tags = json_decode($products->tags);
                                                        if($tags && count($tags) != 0) {
                                                            foreach ($tags as $key => $value) {
                                                                $tag = \DB::table('tags')->where('id',$value)->where('is_block',1)->first();
                                                                if(($tag)){ ?>
                                                                    <li><a href="{{route('tag_products', ['id' => $tag->id])}}" title="{{$tag->tag_title}}">{{$tag->tag_title}}</a></li> ,
                                                                <?php }
                                                            }
                                                        } else {
                                                            echo '<li>No Tags</li>';
                                                        }
                                                    ?>
                                                </ul>
                                            </div> -->

                                            <!-- <div class="wrap__brand">
                                                <label class="">Guaranteed safe checkout:</label>
                                                <div class="wrap__brand_content">
                                                    <img src="{{ asset('frontend/images/pay.png')}}" alt=" " />
                                                </div>
                                            </div> -->

                                            <div class="sozzz">
                                                <h5> Share via </h5>
                                                <ul>
                                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}&t=TITLE" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Facebook"><i class="fa fa-facebook"></i> </a></li>
                                                    
                                        <li><a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}&t=TITLE" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="Share on Twitter"><i class="fa fa-twitter"></i> </a></li>

                                                    <!-- <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}" target="_blank"><i class="fa fa-facebook"></i></a></li> -->

                                                    <!--<li><a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}" target="_blank"><i class="fa fa-twitter"></i></a></li>-->

                                                    <!-- <script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>
                                                    <script type="IN/Share" data-url="{{ urlencode(Request::fullUrl()) }}"></script> -->

                                                    <!-- <li><a href="https://api.linkedin.com/v1/people/~/shares?url={{ urlencode(Request::fullUrl()) }}" target="_blank"><i class="fa fa-linkedin"></i></a></li> -->
                                                    <!-- https://www.linkedin.com/shareArticle?mini=true&url=<?php //the_permalink(); ?>&title=Some%20Title&summary=Some%20Summary&source=YourWebsiteName -->

                                                    <!-- <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(Request::fullUrl()) }}&title=Some%20Title&summary=Some%20Summary&source=YourWebsiteName" target="_blank"><i class="fa fa-linkedin"></i></a></li> -->
                                                    
                                                    <!-- <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=http://eladdu.com&title=Some%20Title&summary=Some%20Summary&source=YourWebsiteName" target="_blank"><i class="fa fa-linkedin"></i></a></li> -->

                                                    <!-- <li><i class="fa fa-youtube"></i></li>
                                                    <li><a href="https://plus.google.com/share?url={{ urlencode(Request::fullUrl()) }}" target="_blank"><i class="fa fa-google-plus"></i></a></li> -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-group detail-bottom">
                                <div class="tab-vertical">
                                    <ul class="nav nav-tabs font-ct">
                                        <li class="nav-item"><a class="nav-link active" href="#tabs1" data-toggle="tab">Details</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#tabs2" data-toggle="tab">Shipping &amp; Returns</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#tabs3" data-toggle="tab">Product Features</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#tabs4" data-toggle="tab">Reviews</a></li>
                                    </ul>
                                    
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tabs1">
                                            <div class="rte description">
                                                <?php echo $products->product_desc; ?>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tabs2">
                                            <div class="success rte">
                                                <?php echo $products->shiping_policy; ?>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tabs3">
                                            <div class="placeholder-bg gj_pro_features">
                                                <!-- <pre>{{}}</pre> -->
                                                <?php echo $products->features; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="tab-pane" id="tabs4"> 
                                            <div class="container">
                                                @if (count($review) != 0)
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="rating-block">
                                                                <h4>Average user rating</h4>
                                                                @if($average != 0)
                                                                    <h2 class="bold padding-bottom-7">{{$average}} <small>/ 5</small></h2>
                                                                    <?php 
                                                                    $r_average = round($average); 
                                                                    $tot_rev = 5;
                                                                    ?>
                                                                    @for ($i=0; $i<$tot_rev; $i++)
                                                                        @if($i < $r_average)
                                                                            <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                                                                                <span class="fa fa-star"></span>
                                                                            </button>
                                                                        @else
                                                                            <button type="button" class="btn btn-default btn-grey btn-sm" aria-label="Left Align">
                                                                                <span class="fa fa-star"></span>
                                                                            </button>
                                                                        @endif
                                                                    @endfor
                                                                @else
                                                                    <h2 class="bold padding-bottom-7">0 Reviews</h2>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <h4>Rating breakdown</h4>
                                                            <div class="pull-left">
                                                                <div class="pull-left" style="width:35px; line-height:1;">
                                                                    <div style="height:9px; margin:5px 0;">5 <span class="glyphicon glyphicon-star"></span></div>
                                                                </div>
                                                                
                                                                <div class="pull-left" style="width:180px;">
                                                                    <div class="progress" style="height:9px; margin:8px 0;">
                                                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 1000%">
                                                                            <span class="sr-only">80% Complete (danger)</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="pull-right" style="margin-left:10px;">
                                                                    @if(isset($stars['review5']))
                                                                        {{$stars['review5']}}
                                                                    @else
                                                                        {{'0'}}
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="pull-left">
                                                                <div class="pull-left" style="width:35px; line-height:1;">
                                                                    <div style="height:9px; margin:5px 0;">4 <span class="glyphicon glyphicon-star"></span></div>
                                                                </div>
                                                                
                                                                <div class="pull-left" style="width:180px;">
                                                                    <div class="progress" style="height:9px; margin:8px 0;">
                                                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width: 80%">
                                                                            <span class="sr-only">80% Complete (danger)</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="pull-right" style="margin-left:10px;">
                                                                    @if(isset($stars['review4']))
                                                                        {{$stars['review4']}}
                                                                    @else
                                                                        {{'0'}}
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="pull-left">
                                                                <div class="pull-left" style="width:35px; line-height:1;">
                                                                    <div style="height:9px; margin:5px 0;">3 <span class="glyphicon glyphicon-star"></span></div>
                                                                </div>
                                                                
                                                                <div class="pull-left" style="width:180px;">
                                                                    <div class="progress" style="height:9px; margin:8px 0;">
                                                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="5" style="width: 60%">
                                                                            <span class="sr-only">80% Complete (danger)</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="pull-right" style="margin-left:10px;">
                                                                    @if(isset($stars['review3']))
                                                                        {{$stars['review3']}}
                                                                    @else
                                                                        {{'0'}}
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="pull-left">
                                                                <div class="pull-left" style="width:35px; line-height:1;">
                                                                    <div style="height:9px; margin:5px 0;">2 <span class="glyphicon glyphicon-star"></span></div>
                                                                </div>
                                                                
                                                                <div class="pull-left" style="width:180px;">
                                                                    <div class="progress" style="height:9px; margin:8px 0;">
                                                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="5" style="width: 40%">
                                                                            <span class="sr-only">80% Complete (danger)</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="pull-right" style="margin-left:10px;">
                                                                    @if(isset($stars['review2']))
                                                                        {{$stars['review2']}}
                                                                    @else
                                                                        {{'0'}}
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="pull-left">
                                                                <div class="pull-left" style="width:35px; line-height:1;">
                                                                    <div style="height:9px; margin:5px 0;">1 <span class="glyphicon glyphicon-star"></span></div>
                                                                </div>
                                                                
                                                                <div class="pull-left" style="width:180px;">
                                                                    <div class="progress" style="height:9px; margin:8px 0;">
                                                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5" style="width: 20%">
                                                                            <span class="sr-only">80% Complete (danger)</span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="pull-right" style="margin-left:10px;">
                                                                    @if(isset($stars['review1']))
                                                                        {{$stars['review1']}}
                                                                    @else
                                                                        {{'0'}}
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>      
                                                    </div>      

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <hr/>
                                                            <div class="review-block">
                                                                @foreach ($review as $value)
                                                                    <div class="row">
                                                                        <div class="col-sm-3">
                                                                            @if($value->ReviewUser->profile_img)
                                                                                <img src="{{ asset($profile_img_path.'/'.$value->ReviewUser->profile_img) }}" alt="{{$value->ReviewUser->first_name.' '.$value->ReviewUser->last_name}}" class="imzz">
                                                                            @else
                                                                                <img src="{{ asset($noimage_path.'/'.$noimage->profile_no_img) }}" alt="No Profile Image" class="imzz">
                                                                            @endif
                                                                            <div class="review-block-name">{{$value->ReviewUser->first_name.' '.$value->ReviewUser->last_name}}</div>
                                                                            <div class="review-block-date">{{date('F d, Y', strtotime($value->created_at))}}<br/>{{App\Review::gj_ago_calc($value->created_at)}}</div>
                                                                        </div>
                                                                        
                                                                        <div class="col-sm-9">
                                                                            <div class="review-block-rate">
                                                                                <?php $tot_rev = 5; ?>
                                                                                @for ($i=0; $i<$tot_rev; $i++)
                                                                                    @if($i < $value->rating)
                                                                                        <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                                                                            <span class="fa fa-star"></span>
                                                                                        </button>
                                                                                    @else
                                                                                        <button type="button" class="btn btn-default btn-grey btn-xs" aria-label="Left Align">
                                                                                            <span class="fa fa-star"></span>
                                                                                        </button>
                                                                                    @endif
                                                                                @endfor
                                                                            </div>

                                                                            <div class="review-block-description">{{$value->description}}</div>
                                                                        </div>
                                                                    </div>
                                                                    <hr/>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <p class="gj_no_data">Reviews Not Available This Product</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <section class="section-related">
                                <div id="related" class="related-products">
                                    <h3 class="detail-title font-ct"><strong><span>Related Products</span></strong></h3>
                                    <div class="products-listing grid ss-carousel ss-owl">
                                        <div class="product-layout owl-carousel"
                                            data-nav="true"
                                            data-margin    ="30" 
                                            data-lazyLoad    ="true"
                                            data-column1=" 5" 
                                            data-column2=" 4" 
                                            data-column3=" 3" 
                                            data-column4=" 2" 
                                            data-column5=" 2">

                                            @if(($related) && (count($related) != 0))
                                                @foreach($related as $key => $value)
                                                    <div class="item">
                                                        <div class="product-item" data-id="product-{{$value->id}}">
                                                            <div class="product-item-container  ">
                                                                <div class="row">
                                                                    <div class="left-block col-12">
                                                                        <div class="product-image-container product-image">
                                                                            <a class="grid-view-item__link image-ajax" href="{{ route('view_products', ['id' => $value->id]) }}">
                                                                                <img class="img-responsive lazyload" data-sizes="auto" src="{{ asset('frontend/images/icon-loadings.svg') }}" data-src="{{ asset($product_path.'/'.$value->featured_product_img) }}" alt="{{$value->product_title}}">
                                                                            </a>
                                                                            <span class="label-product label-sale"><span class="hidden">Sale</span> -5%</span>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="right-block col-12">
                                                                        <div class="button-link">
                                                                            <div class="btn-button add-to-cart action  ">
                                                                               <form action=" " method="post" class="variants" data-id="AddToCartForm-1674837164143" enctype="multipart/form-data">
                                                                                  <input type="hidden" name="id" value="15484107096175">           
                                                                                  <a class="btn-addToCart grl btn_df gj_add2cart" href="javascript:void(0)" title="Add to cart" data-cart-id="{{$value->id}}">
                                                                                     <p class="disable-in-col6">Add to cart</p>
                                                                                     <i class="fa fa-shopping-basket enable-in-col6"></i>
                                                                                  </a>
                                                                               </form>
                                                                            </div>
                                                                            <div class="product-addto-links">
                                                                               <a class="btn_df btnProduct" href="#" title="Wishlist">
                                                                               <i class="fa fa-heart"></i>
                                                                               <span class="hidden-xs hidden-sm hidden-md">Wishlist</span>
                                                                               </a>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="caption">
                                                                            <div class="custom-reviews hidden-xs">          
                                                                                <span class="shopify-product-reviews-badge" data-id="{{$value->id}}"></span>          
                                                                            </div>
                                                                            <h4 class="title-product text-truncate"><a class="product-name" href="{{ route('view_products', ['id' => $value->id]) }}"> {{$value->product_title}}</a></h4>
                                                                            <div class="price">
                                                                                <p class="gj_ssc_prod_dp"><i class="fa fa-inr"></i>  {{$value->discounted_price}}<span class="gj_ssc_prod_op"><i class="fa fa-inr"></i> {{$value->original_price}}</span></p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="countdown_tabs">
                                                                        </div>
                                                                        <div class="countdown_tabs">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                                            
                                                @endforeach
                                            @else
                                                <div class="item">
                                                    <div class="product-item" data-id="product-0">
                                                        <div class="product-item-container  ">
                                                            <div class="row">
                                                                <div class="left-block col-12">
                                                                    <div class="product-image-container product-image">
                                                                        <a class="grid-view-item__link image-ajax" href="#">
                                                                            <img class="img-responsive lazyload" data-sizes="auto" src="{{ asset('frontend/images/icon-loadings.svg') }}" data-src="{{ asset($noimage_path.'/'.$noimage->product_no_image) }}" alt="No Images">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="right-block col-12">
                                                                    <div class="caption">
                                                                        <div class="custom-reviews hidden-xs">          
                                                                            <span class="shopify-product-reviews-badge" data-id="0"></span>          
                                                                        </div>
                                                                        <h4 class="title-product text-truncate"><a class="product-name" href="#"> Related Products Not Available</a></h4>
                                                                    </div>
                                                                    <div class="countdown_tabs">
                                                                    </div>
                                                                    <div class="countdown_tabs">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                                
                    <script>
                        var slider = function() {
                            if (!$('.slider-for').hasClass('slick-initialized') && !$('.slider-nav').hasClass('slick-initialized')) {
                                $('.slider-for').slick({
                                    slidesToShow: 1,
                                    slidesToScroll: 1,
                                    nextArrow: '<div class="slick-next"><i class="fa fa-angle-right"></i></div>',
                                    prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left"></i></div>',
                                    fade: true,
                                    accessibility:false,
                                    verticalSwiping: false,
                                    arrows : false,

                                    asNavFor: '.slider-nav'
                                });

                                $('.slider-nav').slick({
                                    infinite: true,
                                    slidesToShow: 5,


                                    slidesToScroll: 1,
                                    asNavFor: '.slider-for',
                                    verticalSwiping: false,
                                    dots: false,

                                    accessibility:false,
                                    focusOnSelect: true,


                                    nextArrow: '<div class="slick-next"><i class="fa fa-angle-right"></i></div>',
                                    prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left"></i></div>',


                                    responsive: [
                                    {
                                        breakpoint: 1200,
                                        settings: {
                                            slidesToShow: 5,
                                            slidesToScroll: 1
                                        }
                                    },

                                    {
                                        breakpoint: 1024,
                                        settings: {
                                            slidesToShow: 5,
                                            slidesToScroll: 1
                                        }
                                    },

                                    {
                                        breakpoint: 768,
                                        settings: {
                                            slidesToShow: 4,
                                            slidesToScroll: 1,
                                            dots: false
                                        }
                                    },
                                    {
                                    breakpoint: 321,
                                        settings: {
                                            slidesToShow: 3,
                                            slidesToScroll: 2,
                                            dots: false
                                        }
                                    },

                                    ]

                                });
                            }        
                        };

                        $(window).load(function() {
                            slider();  
                            if ($(window).width() >= 992 && $('.zoomContainer').length === 0) {
                                $(".fancybox").fancybox();
                                var zoomOptions = {
                                    cursor: "crosshair",
                                    galleryActiveClass: 'active',
                                    imageCrossfade: false,
                                    scrollZoom: false,

                                    onImageSwapComplete: function() {
                                        $(".zoomWrapper div").hide();
                                    },
                                    loadingIcon: window.loading_url
                                };
                                $(".slider-for .slick-current img").elevateZoom(zoomOptions);

                                $(".slider-for ").on("beforeChange", function(event, slick, currentSlide, nextSlide) {
                                    $.removeData(currentSlide, "elevateZoom");
                                    $(".zoomContainer").remove();
                                });
                                $(".slider-for ").on("afterChange", function() {
                                    $(".slider-for  .slick-current img").elevateZoom(zoomOptions);
                                });
                            }
                        }); 

                        var timer;
                        var winW = $(window).width();

                        $(window).on('resize.refreshSlick', function() {
                            clearTimeout(timer);
                            timer = setTimeout(function() {
                                var curW = $(window).width();
                                if (curW >= 768 && winW < 768) {
                                    $('.slider-for').slick('unslick');    
                                    $('.slider-nav').slick('unslick');   
                                    $('.slider-nav').find('.slick-list').removeAttr('style');
                                    $('.slider-nav').find('.slick-track').removeAttr('style');
                                    $('.slider-nav').find('.slick-slide').removeAttr('style');
                                    $('.slider-nav').find('button.slick-arrow').remove();

                                    slider();
                                }
                                winW = curW;  
                            }, 500);
                        });

                        $(".tab-vertical>ul>li").on('click', function () {
                            $(".tab-vertical>ul>li").removeClass("active");
                            $(this).addClass("active");
                        });
                    </script>
                </div>
            </div>
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

<script>
    $(".open-sidebar").click(function(e){
        $(".sidebar-overlay").toggleClass("show");
        $(".sidebar-fixed").toggleClass("active");
    });
    
    $( ".open-fiter" ).click(function() {
        $('.sidebar-fixed').slideToggle(200);
        $(this).toggleClass('active');
    });

    $(".sidebar-overlay").click(function(e){
        $(".sidebar-overlay").toggleClass("show");
        $(".sidebar-fixed").toggleClass("active");
    });

    $('#close-sidebar').click(function() {
        $('.sidebar-overlay').removeClass('show');
        $('.sidebar-fixed').removeClass('active');
    }); 
</script>

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
                $('.gj_tot_price').html(tot);
                $('#qty').val(qty);
            } else {
                tot = 1 * price;
                $('.gj_tot_price').html(tot);
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
            $('.gj_tot_price').html(tot);
            $('#qty').val(qty);
        }
    });

    $('#qty').on('keyup',function(event) {
        calculate();
    });

    $('#gj_add_product').on('click',function(event) {
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
                    $('.gj_tot_price').html(tot);
                    $('#qty').val(qty);
                }
            } else {
                tot = 1 * price;
                $('.gj_tot_price').html(tot);
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

    $('#gj_subtract_product').on('click',function() {
        var qty = $('#qty').val();
        var price = $('#price').val();
        var tot = 0.00;
        if ((qty != '') && (price != '')) {
            qty = parseInt(qty) - 1;
            if(qty == 0) {
                qty = 1;
            }
            tot = qty * price;
            $('.gj_tot_price').html(tot);
            $('#qty').val(qty);
        }
    });
</script>

<script type="text/javascript">
    $('body').on('change','#gj_vw_attribute_name',function() {
        var att_n = 0;
        if ($(this).val()) {
            att_n = $(this).val();
        }
        if($('#product_id').val()){
            var product_id = $('#product_id').val();
        } else {
            var product_id = 0;
        }
        
        var ths = $(this);

        $.ajax({
            type: 'post',
            url: '{{url('/select_att_vals')}}',
            data: {id: att_n, product_id: product_id, type: 'select_att_vals'},
            success: function(data){
                if(data != 0){
                    $('#gj_vw_attribute_value').html(data);
                } else {
                    $.confirm({
                        title: '',
                        content: 'Select Another Attributes',
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
                    // window.location.reload();
                }
            }
        });
    });

    /*$('#gj_vw_attribute_value').on('change',function() {
        var id = $(this).val();
        if($('#product_id').val()){
            var product_id = $('#product_id').val();
        } else {
            var product_id = 0;
        }

        if(id) {
            $.ajax({
                type: 'post',
                url: '{{url('/attributes_image')}}',
                data: {id: id, product_id: product_id, type: 'image'},
                dataType: "json",
                success: function(data){
                    if(data != 0){
                        $("a.thumb").each(function () {
                            if(data['image'] == $(this).attr('data-image')) {
                                $(this).trigger("click");
                            }
                        });

                        if(data['price'] && data['price'] != 0) {
                            $('#price').val(data['price']);
                            $('#gj_vw_mny').html(data['price']);

                            calculate();
                        }
                    } else {
                        $.confirm({
                            title: '',
                            content: 'Select Another Attributes Values!',
                            icon: 'fa fa-exclamation',
                            theme: 'modern',
                            closeIcon: true,
                            animation: 'scale',
                            type: 'purple',
                            buttons: {
                                Ok: function(){
                                    window.location.reload();
                                }
                            }
                        });
                    }
                }
            });
        } else {
            $.confirm({
                title: '',
                content: 'Select Another Attributes Values!',
                icon: 'fa fa-exclamation',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'purple',
                buttons: {
                    Ok: function(){
                        window.location.reload();
                    }
                }
            });
        }
    });*/

    $('.gj_att_vals').on('click',function() {
        var ts = $(this);
        var id = $(this).attr('data-val');
        $('#gj_vw_att_name').val($(this).attr('data-name'));
        $('#gj_vw_att_value').val($(this).attr('data-val'));
        $('#gj_vw_att_qty').val($(this).attr('data-qty'));

        if($('#product_id').val()){
            var product_id = $('#product_id').val();
        } else {
            var product_id = 0;
        }

        if(id) {
            $.ajax({
                type: 'post',
                url: '{{url('/attributes_image')}}',
                data: {id: id, product_id: product_id, type: 'image'},
                dataType: "json",
                success: function(data){
                    if(data != 0){
                        $("a.thumb").each(function () {
                            if(data['image'] == $(this).attr('data-image')) {
                                $(this).trigger("click");
                            }
                        });

                        if(data['price'] && data['price'] != 0) {
                            $('#price').val(data['price']);
                            $('#gj_vw_mny').html(data['price']);

                            calculate();
                        }
                        $('.gj_att_vals').parent().removeClass('gj_val_active');
                        ts.parent().addClass('gj_val_active');
                    } else {
                        $.confirm({
                            title: '',
                            content: 'Select Another Attributes Values!',
                            icon: 'fa fa-exclamation',
                            theme: 'modern',
                            closeIcon: true,
                            animation: 'scale',
                            type: 'purple',
                            buttons: {
                                Ok: function(){
                                    window.location.reload();
                                }
                            }
                        });
                    }
                }
            });
        } else {
            $.confirm({
                title: '',
                content: 'Select Another Attributes Values!',
                icon: 'fa fa-exclamation',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'purple',
                buttons: {
                    Ok: function(){
                        window.location.reload();
                    }
                }
            });
        }
    });
</script>

<!-- Pincode Availabity Check Start -->
<script type="text/javascript">
    $('#gj_res_pin').hide();
    $('#gj_pincode_chk').on('click',function() {
        var pincode = $('#pincodeInputId').val();
        if(pincode) {
            $.ajax({
                type: 'post',
                url: '{{url('/pincode_check')}}',
                data: {pincode: pincode, type: 'pincode_check'},
                success: function(data){
                    // alert(data);
                    if(data == "1") {
                        $('#gj_res_pin').text('Delivery Available for this Pincode!');
                        $('#gj_res_pin').css('background-color','#dff0d8');
                        $('#gj_res_pin').css('color','#3c763d');
                        $('#gj_res_pin').css('border-color','#d6e9c6');
                    } else {
                        $('#gj_res_pin').text(data);
                        $('#gj_res_pin').css('background-color','#f2dede');
                        $('#gj_res_pin').css('color','#a94442');
                        $('#gj_res_pin').css('border-color','#ebccd1');
                    }
                    $('#gj_res_pin').slideDown();
                    $('#gj_res_pin').delay(7000).slideUp(500);
                    $('#pincodeInputId').val('');
                }
            });
        } else {
            $.confirm({
                title: '',
                content: 'Please Enter Valid Pincode!',
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
            $('#pincodeInputId').val('');
        }
    });
</script>
<!-- Pincode Availabity Check End -->
@endsection