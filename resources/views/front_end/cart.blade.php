<?php  
    $product_path = 'images/featured_products';
    $noimage = \DB::table('noimage_settings')->first();
    $noimage_path = 'images/noimage';

    //print_r($ses_carts);die();
?>
@extends('layouts.frontend')
@section('title', 'View Cart')
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('login/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('login/main.css')}}"> -->
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
     <section class="section-padding bg-light-gray">
         <div id="stock-error-banner" class="alert alert-danger d-none" role="alert">
            Some products in your cart are out of stock. Please remove them before proceeding to checkout.
        </div>
        <div class="container">
            @if(isset($carts) && count($carts) != 0)
                
             <form action="{{route('cart_save')}}" class="gj_cart_frm ps-form--checkout" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="row">
                <div class="col-lg-12">
                    <!-- <div class="faq-icon-top">
                        <img src="assets/img/icon.png" alt="">
                    </div> -->
                    <div class="section-title column-title">
                        <h3>Your Cart</h3>
                        <p><a href="{{route('home')}}">Continue Shopping</a></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">

                        @foreach ($carts as $key => $value)
                    <div class="cart-container mb-3">
                        <div class="row">
                            <tr>
                            <div class="col-lg-7">
                                <div class="cart-img">
                                    <input type="hidden" name="product_id[]" id="product_{{$value->product_id}}" class="gj_p_id" value="{{$value->product_id}}">                                    <!--<input type="hidden" name="cart_id[]" id="cart_{{$key}}" class="gj_cart_id" value="0">-->
                                    <input type="hidden" name="cart_id[]" id="cart_{{$key}}" class="gj_cart_id" value="{{ $value->id ?? '' }}">
                                      <input type="hidden" name="cart_key[]" id="cartkey_{{$key}}" class="gj_cart_key" value="{{(isset($value->cart_key) ? $value->cart_key : '')}}">
                                      <input type="hidden" name="cart_del[]" id="cart_del_{{$key}}" class="gj_cart_del" value="{{(isset($value->cart_del) ? $value->cart_del : '')}}">
                                      <input type="hidden" name="is_offer[]" id="isoffer_{{$key}}" class="gj_is_offer" value="{{((isset($value->is_offer)) ? $value->is_offer : '')}}">
                                      <input type="hidden" name="offer_id[]" id="offerid_{{$key}}" class="gj_offer_id" value="{{(isset($value->offer_id) ? $value->offer_id : '')}}">
                                      <input type="hidden" name="offer_det_id[]" id="offerdetid_{{$key}}" class="gj_offer_det_id" value="{{(isset($value->offer_det_id) ? $value->offer_det_id : '')}}">
                                      <input type="hidden" name="image[]" id="image_{{$value->product_id}}" class= "gj_c_img" value="{{$value->image}}">

                                 <a href="{{ route('view_products', ['id' => $value->product_id]) }}">  
                                 @if(($value->image) )
                                    <img src="{{ asset($product_path.'/'.$value->image) }}">
                                    @else
                                     <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}">
                                    @endif
                                 </a>
                                   <div class="cart-product-dt">
                                    <p><a href="{{ route('view_products', ['id' => $value->product_id]) }}">{{$value->name}} @if($value->color_name)
                                                    ({{$value->color_name}} )
                                                     @endif</a></p>
                                     <input type="hidden" name="att_name[]" id="attname_{{$value->att_name}}" class="gj_att_name" value="{{$value->att_name}}">
                                    <input type="hidden" name="att_value[]" id="attvalue_{{$value->att_value}}" class="gj_att_value" value="{{$value->att_value}}">
                                     <input type="hidden" name="name[]" id="name_{{$value->product_id}}" class="gj_c_name" value="{{$value->name}}">
                                    
                                    <p class="product-cat">Category : {{$value->Products->MainCat->main_cat_name}}</p> 
                                   
                                            <p class="price">
                                                 @if($value->Products->discounted_price > 0)
                                                ₹ {{ $value->discounted_price }}
                                                @else
                                                   ₹ {{ $value->original_price }}
                                                @endif
                                            </p>
                                        
                                    
                                    <small class="gj_stock_status" 
    data-stock="{{ $value->Products->onhand_qty }}" style="display: block; margin-top: 5px; font-size: 13px;font-weight: 600; color: {{ $value->Products->onhand_qty > 0 ? 'green' : 'red' }}">
                                        {{ $value->Products->onhand_qty > 0 ? 'In Stock' : 'Out of Stock' }} - {{ $value->Products->onhand_qty}}
                                    </small>
                                    <input type="hidden" name="original_price[]" id="price_{{$value->product_id}}" class="gj_c_o_price" value="{{$value->original_price}}">
                                      <input type="hidden" name="product_cost[]" id="price_{{$value->product_id}}" class="gj_c_product_cost" value="{{$value->product_cost}}"> 
                                      @if($value->discounted_price > 0)
                                      <input type="hidden" name="discounted_price[]" id="price_{{$value->product_id}}" class="gj_c_discounted_price" value="{{$value->discounted_price}}">
                                    @else
                                      <input type="hidden" name="discounted_price[]" id="price_{{$value->product_id}}" class="gj_c_discounted_price" value="{{$value->original_price}}">
                                    @endif
                                      <input type="hidden" name="price[]" id="price_{{$value->product_id}}" class="gj_c_price" value="{{$value->price}}">
                                      <input type="hidden" name="tax_amount[]" id="price_{{$value->product_id}}" class="gj_c_tax_amount" value="{{$value->tax_amount}}">
    
                                      <input type="hidden" name="tax[]" id="tax_{{$value->product_id}}" class="gj_c_tax" value="{{$value->tax}}">
                                    <input type="hidden" name="tax_type[]" id="taxtype_{{$value->product_id}}" class="gj_c_tax_type" value="{{$value->tax_type}}">
                                   </div>
                                </div>
                            </div>

                           <div class="col-lg-5">
                            <div class="row h-100">
                                <div class="col-6">
                                    <div class="product-qty-box cart-qty">
                                     <input type="hidden" name="service_charge[]" id="sc_{{$value->product_id}}" class="gj_sc_service_charge" value="{{$value->service_charge}}">
                                     <input type="hidden" name="shiping_charge[]" id="shc_{{$value->product_id}}" class="gj_sc_shiping_charge" value="{{$value->shiping_charge}}">
                                        
                                        <div class="product-qty gj_cart_item">
                                            <button type="button" class="down"><i class="fa-solid fa-minus"></i></button>
                                             <input class=" form-control shadow-none gj_cart_qty w-80" type="text" name="h_qty[]" id="gj_cart_hqty_{{$value->product_id}}" value="{{$value->qty}}" min="1" pattern="[0-9]*" @if(isset($value->is_offer) && $value->is_offer == "Yes") disabled @endif>
                                            <input class=" form-control shadow-none  gj_cart_qty w-80" type="hidden" name="qty[]" id="gj_cart_qty_{{$value->product_id}}" value="{{$value->qty}}" min="1" pattern="[0-9]*">
                                    
                                            <button type="button" class="up"><i class="fa-solid fa-plus"></i></button>
            
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="col-6">
                                 <div class="cart-column-right"> 
                                    <div class="cart-column-right-top">
                                        <button class="cart-wishlist gj_wish_list" data-wish-id="{{$value->product_id}}"><i class="fa-solid fa-heart"></i> </button>
                                        <button type="button" class="cart-delete dlt-btn-cart">
                                            <a href="javascript:void(0);" type="button" class="btnRemoveWishlist gj_cart_tabl_del" data-id="{{$value->product_id}}" data-cart-id="{{$value->id}}" data-cart-key="{{(isset($value->cart_key) ? $value->cart_key : '')}}" data-cart-del="{{(isset($value->cart_del) ? $value->cart_del : '')}}">
                                                <i class="fa-solid fa-trash"></i>
                                            </a></button>
                                       </div>
                                        @if($value->discounted_price > 0)
                                           <p>Total : <span>₹ {{ round(($value->qty * $value->discounted_price),2) }}</span>
                                            <input type="hidden" name="total_price[]" id="totprice_{{$value->product_id}}" class="gj_tot_price" value="{{ round(($value->qty * $value->discounted_price), 2)}}"></p>
                                 
                                        @else
                                        <p>Total : <span>₹ {{ round(($value->qty * $value->original_price),2) }}</span>
                                         <input type="hidden" name="total_price[]" id="totprice_{{$value->product_id}}" class="gj_tot_price" value="{{ round(($value->qty * $value->original_price),2) }}"></p>
                                        @endif
                                 </div>
                                </div>
                               </div>
                           </div>
                           </tr>
                        </div>
                         </div>
                     @endforeach
                   
                  
                </div>
                <div class="col-lg-4">
                    <div class="cart-overview mb-3">
                        <div class="cart-overview-top">
                            <h3>Products</h3>
                            <h3>Total</h3>
                        </div>
                         @foreach ($carts as $key => $value)
                        <div class="cart-over-view-product">
                            <div class="cart-over-view-product-item">
                                 @if(($value->image))
                                    <img src="{{ asset($product_path.'/'.$value->image) }}">
                                    @else
                                     <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}">
                                    @endif
                                <h3>{{$value->name}}  @if($value->color_name)
                                                    ({{$value->color_name}} )
                                                     @endif 
                                                     <br/> <small> Quantity : {{$value->qty}}</small></h3>
                            </div>
                            <div class="cart-over-view-product-price gj_all_cart_pce" id="prod_{{$value->product_id}}">
                                 @if($value->Products->discounted_price > 0)
                                           <p>₹ {{ round(($value->qty * $value->discounted_price),2) }}</p>
                                        @else
                                        <p>₹ {{ round(($value->qty * $value->original_price),2) }}</p>
                                        @endif
                            </div>

                        </div>
                        @endforeach
                        <table>
                            <tr>
                                <td>Subtotal</td>
                                <td class="gj_all_cart_sub_tot">₹ 0.00</td>
                            </tr>
                            
                            <!-- <tr>-->
                            <!--    <td>Shipping</td>-->
                            <!--    <td class="gj_all_cart_ship_tot">₹ 0.00</td>-->
                                
                            <!--</tr>-->
                            
                            @if(session()->has('coupon'))
                            <tr>
                                <td>Coupon ({{ session('coupon.code') }})</td>
                                <td class="gj_all_cart_coupon">- ₹ {{ session('coupon.discount') }}</td>
                            </tr>
                            @endif
                            
                            <tr>
                                <td>Total</td>
                                <td class="gj_all_cart_total">₹ 0.00</td>
                                
                            </tr>
                            <input type="hidden" name="cart_sub_tot" class="gj_cart_sub_tot">
                            <input type="hidden" name="cart_ship_tot" class="gj_cart_ship_tot"> 
                            <input type="hidden" name="cart_totalval" class="gj_cart_totalval">
                            <input type="hidden" class="gj_cart_coupon_discount" value="{{ session('coupon.discount') ?? 0 }}">

                        </table>
                       {{-- @if(session()->has('coupon'))
                            <div class="alert alert-success">
                                Coupon <strong>{{ session('coupon.code') }}</strong> applied. 
                                <a href="{{ route('remove.coupon') }}" class="text-danger" style="float: right;">Remove</a><br>
                                Discount: ₹{{ session('coupon.discount') }}
                            </div>
                        @else
                           <div id="coupon-apply-section" class="input-group mb-3 mt-2">
                                <input type="text" id="coupon_code" class="form-control shadow-none" placeholder="Enter Coupon Code" required style="height:45px;">
                                <button id="apply-coupon-btn" type="button" class="btn" style="background-color: #ca3554; color: #fff;">Apply</button>
                            </div>
                            <div id="coupon-message" class="text-danger mt-1"></div>
                        @endif --}}
                        @if($shipping->text)
                            <div class="input-group mb-3 mt-2">
                                <div class="form-control shadow-none" readonly style="height:auto; min-height:45px;">
                                    {!! nl2br(e($shipping->text ?? '')) !!}
                                </div>
                            </div>
                            @endif
                        <p>Taxes and Shipping will be calculated at checkout</p>
                        <!--<a href="{{ route('checkout') }}" class="cart-btn">Checkout</a>-->
                        <button type="button" id="checkout-btn" class="cart-btn">Checkout</button>
                    </div>
                    

                </div>
            </div>
            </form>
             @elseif(isset($ses_carts) && $ses_carts)
             <form action="{{route('cart_save')}}" class="gj_cart_frm" method="POST" enctype="multipart/form-data">
                @csrf
                 <div class="row">
                <div class="col-lg-12">
                    <!-- <div class="faq-icon-top">
                        <img src="assets/img/icon.png" alt="">
                    </div> -->
                    <div class="section-title column-title">
                        <h3>Your Cart</h3>
                        <p><a href="{{route('all_products')}}">Continue Shopping</a></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-container mb-3">
                        @foreach ($ses_carts as $key => $value)
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="cart-img">
                                     <input type="hidden" name="product_id[]" id="product_{{$value->product_id}}" class="gj_p_id" value="{{$value->product_id}}">
                                    <input type="hidden" name="cart_id[]" id="cart_{{$key}}" class="gj_cart_id" value="{{ $value->id ?? '' }}">
                                      <input type="hidden" name="cart_key[]" id="cartkey_{{$key}}" class="gj_cart_key" value="{{(isset($value->cart_key) ? $value->cart_key : '')}}">
                                      <input type="hidden" name="cart_del[]" id="cart_del_{{$key}}" class="gj_cart_del" value="{{(isset($value->cart_del) ? $value->cart_del : '')}}">
                                      <input type="hidden" name="is_offer[]" id="isoffer_{{$key}}" class="gj_is_offer" value="{{((isset($value->is_offer)) ? $value->is_offer : '')}}">
                                      <input type="hidden" name="offer_id[]" id="offerid_{{$key}}" class="gj_offer_id" value="{{(isset($value->offer_id) ? $value->offer_id : '')}}">
                                      <input type="hidden" name="offer_det_id[]" id="offerdetid_{{$key}}" class="gj_offer_det_id" value="{{(isset($value->offer_det_id) ? $value->offer_det_id : '')}}">
                                      <input type="hidden" name="image[]" id="image_{{$value->product_id}}" class= "gj_c_img" value="{{$value->image}}">

                                 <a href="{{ route('view_products', ['id' => $value->product_id]) }}">   
                                     @if(($value->image))
                                        <img src="{{ asset($product_path.'/'.$value->image) }}">
                                        @else
                                         <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}">
                                    @endif
                                </a>
                                   <div class="cart-product-dt">
                                    <p><a href="{{ route('view_products', ['id' => $value->product_id]) }}">{{$value->name}}</a></p>
                                     <input type="hidden" name="att_name[]" id="attname_{{$value->att_name}}" class="gj_att_name" value="{{$value->att_name}}">
                                    <input type="hidden" name="att_value[]" id="attvalue_{{$value->att_value}}" class="gj_att_value" value="{{$value->att_value}}">
                                     <input type="hidden" name="name[]" id="name_{{$value->product_id}}" class="gj_c_name" value="{{$value->name}}">
                                    
                                     @if($value->discounted_price > 0)
                                            <p class="price">
                                               ₹ {{ $value->discounted_price }}
                                            </p>
                                        @else
                                            <p class="price">₹ {{ $value->original_price }}</p>
                                        @endif
                                   
                                   <input type="hidden" name="original_price[]" id="price_{{$value->product_id}}" class="gj_c_o_price" value="{{$value->original_price}}">
                                  <input type="hidden" name="product_cost[]" id="price_{{$value->product_id}}" class="gj_c_product_cost" value="{{$value->product_cost}}">
                                  @if($value->discounted_price > 0)
                                      <input type="hidden" name="discounted_price[]" id="price_{{$value->product_id}}" class="gj_c_discounted_price" value="{{$value->discounted_price}}">
                                      
                                    @else
                                      <input type="hidden" name="discounted_price[]" id="price_{{$value->product_id}}" class="gj_c_discounted_price" value="{{$value->original_price}}">
                                    @endif
                                  <input type="hidden" name="price[]" id="price_{{$value->product_id}}" class="gj_c_price" value="{{$value->price}}">
                                  <input type="hidden" name="tax_amount[]" id="price_{{$value->product_id}}" class="gj_c_tax_amount" value="{{$value->tax_amount}}">
                                  <input type="hidden" name="tax[]" id="tax_{{$value->product_id}}" class="gj_c_tax" value="{{$value->tax}}">
                                    <input type="hidden" name="tax_type[]" id="taxtype_{{$value->product_id}}" class="gj_c_tax_type" value="{{$value->tax_type}}">
                                    
                                </div>
                                </div>
                            </div>

                           <div class="col-lg-6">
                            <div class="row h-100">
                                <div class="col-6">
                                    <div class="product-qty-box cart-qty">
                                     <input type="hidden" name="service_charge[]" id="sc_{{$value->product_id}}" class="gj_sc_service_charge" value="{{$value->service_charge}}">
                                     <input type="hidden" name="shiping_charge[]" id="shc_{{$value->product_id}}" class="gj_sc_shiping_charge" value="{{$value->shiping_charge}}">
                                        
                                        <div class="product-qty gj_cart_item">
                                            <button type="button"  class="down"><i class="fa-solid fa-minus"></i></button>
                                             <input class=" form-control shadow-none gj_cart_qty w-80" type="text" name="h_qty[]" id="gj_cart_hqty_{{$value->product_id}}" value="{{$value->qty}}" min="1" pattern="[0-9]*" @if(isset($value->is_offer) && $value->is_offer == "Yes") disabled @endif>
                                            <input class=" form-control shadow-none  gj_cart_qty w-80" type="hidden" name="qty[]" id="gj_cart_qty_{{$value->product_id}}" value="{{$value->qty}}" min="1" pattern="[0-9]*">
                                    
                                            <button type="button"  class="up"><i class="fa-solid fa-plus"></i></button>
            
                                        </div>
                                      
                                    </div>
                                </div>
                                <div class="col-6">
                                 <div class="cart-column-right">
                                    <div class="cart-column-right-top">
                                        <button class="cart-wishlist gj_wish_list" data-wish-id="{{$value->product_id}}"><i class="fa-solid fa-heart"></i> </button>
                                        <button type="button" class="cart-delete dlt-btn-cart">
                                            <a href="javascript:void(0);" type="button" class="btnRemoveWishlist gj_cart_tabl_del" data-id="{{$value->product_id}}" data-cart-id="0" data-cart-key="{{(isset($value->cart_key) ? $value->cart_key : '')}}" data-cart-del="{{(isset($value->cart_del) ? $value->cart_del : '')}}">
                                                <i class="fa-solid fa-trash"></i>
                                            </a></button>
                                       </div>
                                       @if($value->discounted_price > 0)
                                           <p>Total : <span>₹ {{ round(($value->qty * $value->discounted_price),2) }}</span>
                                            <input type="hidden" name="total_price[]" id="totprice_{{$value->product_id}}" class="gj_tot_price" value="{{ round(($value->qty * ($value->discounted_price ?? 0)),2)}}"></p>
                                 
                                        @else
                                        <p>Total : <span>₹ {{ round(($value->qty * $value->original_price),2) }}</span> 
                                        <input type="hidden" name="total_price[]" id="totprice_{{$value->product_id}}" class="gj_tot_price" value="{{ round(($value->qty * ($value->original_price ?? 0)),2)}}"></p>
                                 
                                        @endif
                                 </div>
                                </div>
                               </div>
                           </div>
                        </div>
                     @endforeach
                    </div>
                  
                </div>
                <div class="col-lg-4">
                    <div class="cart-overview mb-3">
                        <div class="cart-overview-top">
                            <h3>Products</h3>
                            <h3>Total</h3>
                        </div>
                        @foreach ($ses_carts as $key => $value)
                        <div class="cart-over-view-product">
                            <div class="cart-over-view-product-item">
                                 @if(($value->image))
                                    <img src="{{ asset($product_path.'/'.$value->image) }}">
                                    @else
                                     <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}">
                                    @endif
                                <h3>{{$value->name}}  <br/> <small> Quantity : {{$value->qty}}</small></h3>
                            </div>
                            <div class="cart-over-view-product-price gj_all_cart_pce" id="prod_{{$value->product_id}}">
                                @if($value->discounted_price > 0)
                                           <p>₹ {{ round(($value->qty * $value->discounted_price),2) }}</p>
                                        @else
                                        <p>₹ {{ round(($value->qty * $value->original_price),2) }}</p>
                                        @endif
                            </div>

                        </div>
                        @endforeach
                       
                        <table>
                            <tr>
                                <td>Subtotal</td>
                                <td class="gj_all_cart_sub_tot">₹ 0.00</td>
                            </tr>
                            
                            <tr>
                                <td>Total</td>
                                <td class="gj_all_cart_total">₹ 0.00</td>
                            </tr>
                            <input type="hidden" name="cart_sub_tot" class="gj_cart_sub_tot">
                            <input type="hidden" name="cart_ship_tot" class="gj_cart_ship_tot">
                            <input type="hidden" name="cart_totalval" class="gj_cart_totalval">
                        </table>
                        <p>Taxes and Shipping will be calculated at checkout</p>
                        <a href="{{ route('checkout') }}" class="cart-btn">Checkout</a>
                    </div>
                    

                </div>
            </div>
                
                
            </form>
              @else
                    <h6 class="gj_no_data fw-bold text-center">Cart is Empty</h6>
                @endif 
        </div>

    </section>
    
    
   
    
@endsection

@section('before_scripts') 
<script src="{{ asset('ui_assets/js/main.js')}}"></script>
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->

<script>
    $(document).ready(function () {
        $('#checkout-btn').on('click', function (e) {
            let outOfStock = false;

            $('.gj_stock_status').each(function () {
                let stock = parseInt($(this).data('stock'), 10);
                if (stock <= 0) {
                    outOfStock = true;
                    return false; // Break the loop
                }
            });

            if (outOfStock) {
                $('#stock-error-banner').removeClass('d-none').addClass('d-block');
                $('html, body').animate({
                    scrollTop: $('#stock-error-banner').offset().top - 50
                }, 500);
            } else {
                // No stock issue — redirect manually
                window.location.href = "{{ route('checkout') }}";
            }
        });
    });
</script>


<script>
$(document).ready(function () {
    function updateCartTotals() {
        let subtotal = 0;
        let shipping = 0;
        let discount = 0;

        $(".gj_tot_price").each(function () {
            subtotal += parseFloat($(this).val());
        });

        $(".gj_sc_shiping_charge").each(function () {
            shipping += parseFloat($(this).val());
        });
        
        if ($(".gj_cart_coupon_discount").length > 0) {
            discount = parseFloat($(".gj_cart_coupon_discount").val());
        }
        // + shipping

        let total = subtotal - discount;

        $(".gj_all_cart_sub_tot").text("₹ " + subtotal.toFixed(2));
        if (shipping == 0) {
            $('.gj_all_cart_ship_tot').text('FREE');
        } else {
            $('.gj_all_cart_ship_tot').text('₹ ' + shipping.toFixed(2));
        }
        // $(".gj_all_cart_ship_tot").text("₹ " + shipping.toFixed(2));
        $(".gj_all_cart_total").text("₹ " + total.toFixed(2));

        $("input.gj_cart_sub_tot").val(subtotal.toFixed(2));
        $("input.gj_cart_ship_tot").val(shipping.toFixed(2));
        $("input.gj_cart_total").val(total.toFixed(2));
    }

    function toggleMinusButton(input) {
        let qty = parseInt(input.val());
        let minusButton = input.closest('.product-qty').find('.down');

        if (qty <= 1) {
            minusButton.prop('disabled', true).css('opacity', 0.5).css('cursor', 'not-allowed');
        } else {
            minusButton.prop('disabled', false).css('opacity', 1).css('cursor', 'pointer');
        }
    }

    // Initialize minus button states on load
    $("input[name='h_qty[]']").each(function () {
        toggleMinusButton($(this));
    });

    updateCartTotals();

    $('.product-qty .up, .product-qty .down').on('click', function () {
        let container = $(this).closest('.product-qty');
        let input = container.find("input[name='h_qty[]']");
        let qty = parseInt(input.val());
        let originalQty = qty;

        if ($(this).hasClass('up')) {
            qty++;
        } else if ($(this).hasClass('down') && qty > 1) {
            qty--;
        }

        if (qty !== originalQty) {
            input.val(qty);
            let product_id = input.attr('id').replace('gj_cart_hqty_', '');
            let cost = parseFloat($('#price_' + product_id + '.gj_c_discounted_price').val());
            let tax = parseFloat($('#price_' + product_id + '.gj_c_tax_amount').val());


            $('#gj_cart_qty_' + product_id).val(qty);

            let total = (qty * cost) + (qty * tax);
            $('#totprice_' + product_id).val(total.toFixed(2));
            $('#prod_' + product_id + ' p').text('₹ ' + total.toFixed(2));

            updateCartTotals();
            toggleMinusButton(input);
            $(this).closest("form").submit();
        }
    });

    $("input[name='h_qty[]']").on('input', function () {
        let input = $(this);
        let qty = parseInt(input.val());

        if (isNaN(qty) || qty < 1) {
            qty = 1;
            input.val(qty);
        }

        let product_id = input.attr('id').replace('gj_cart_hqty_', '');
        let cost = parseFloat($('#price_' + product_id + '.gj_c_discounted_price').val());
        let tax = parseFloat($('#price_' + product_id + '.gj_c_tax_amount').val());


        $('#gj_cart_qty_' + product_id).val(qty);

        let total = (qty * cost) + (qty * tax);
        $('#totprice_' + product_id).val(total.toFixed(2));
        $('#prod_' + product_id + ' p').text('₹ ' + total.toFixed(2));

        updateCartTotals();
        toggleMinusButton(input);
        $(this).closest("form").submit();
    });
});
</script>

<script>
// Apply Coupon with <div> method
$(document).on('click', '#apply-coupon-btn', function () {
    let coupon = $('#coupon_code').val();
    if (coupon.trim() === '') {
        $('#coupon-message').text('Please enter a coupon code.');
        setTimeout(function () {
            $('#coupon-message').text('');
        }, 5000);
        return;
    }

    $.ajax({
        url: '{{ route("apply.coupon") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            coupon_code: coupon
        },
        success: function (res) {
            if (res.success) {
                // $('#coupon-box').html(res.html);
                // $('.gj_cart_coupon_discount').val(res.discount);
                // updateCartTotals();
                 location.reload();
            } else {
                $('#coupon-message').text(res.message);
                setTimeout(function () {
                    $('#coupon-message').text('');
                }, 5000);
            }
        }
    });
});

$(document).on('click', '.remove-coupon', function () {
    $.ajax({
        url: '{{ route("remove.coupon") }}',
        type: 'GET',
        success: function (res) {
            if (res.success) {
                // $('#coupon-box').html(res.html);
                // $('.gj_cart_coupon_discount').val(0);
                // updateCartTotals();
                 location.reload();
            }
        }
    });
});


</script>


@endsection
