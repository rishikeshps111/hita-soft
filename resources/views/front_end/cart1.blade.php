<?php  
    $product_path = 'images/featured_products';
    $noimage = \DB::table('noimage_settings')->first();
    $noimage_path = 'images/noimage';

    //print_r($ses_carts);die();
?>
@extends('layouts.frontend1')
@section('title', 'View Cart')
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('login/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('login/main.css')}}"> -->
@section('content')
    <section class="ps-section--account ps-checkout">
        <div class="container"> 
            <div class="ps-section__content">
                @if(isset($carts) && count($carts) != 0)
                
                    {{ Form::open(array('url' => 'cart', 'novalidate','class'=>'gj_cart_frm ps-form--checkout','files' => true)) }}
                        <div class="ps-form__content">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 ">
                                    <div class="ps-block--shipping takrolliz">
                                        <h4>Shipping method</h4>
                                        <hr>                                
                  
                                        <div class="table-responsive ">
                                            <table class="table ps-table--shopping-cart"> 
                                                <tbody>
                                                    @foreach ($carts as $key => $value)
                                                    <?php
                                                    // dd($value);
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="product_id[]" id="product_{{$value->product_id}}" class="gj_p_id" value="{{$value->product_id}}">
    
                                                              <input type="hidden" name="cart_id[]" id="cart_{{$value->id}}" class="gj_cart_id" value="{{$value->id}}">
                        
                                                              <input type="hidden" name="cart_key[]" id="cartkey_{{$key}}" class="gj_cart_key" value="{{(isset($value->cart_key) ? $value->cart_key : '')}}">
                        
                                                              <input type="hidden" name="cart_del[]" id="cart_del_{{$key}}" class="gj_cart_del" value="{{(isset($value->cart_del) ? $value->cart_del : '')}}">
                        
                                                              <input type="hidden" name="is_offer[]" id="isoffer_{{$key}}" class="gj_is_offer" value="{{(isset($value->is_offer) ? $value->is_offer : '')}}">
                        
                                                              <input type="hidden" name="offer_id[]" id="offerid_{{$key}}" class="gj_offer_id" value="{{(isset($value->offer_id) ? $value->offer_id : '')}}">
                                                              
                                                              <input type="hidden" name="offer_det_id[]" id="offerdetid_{{$key}}" class="gj_offer_det_id" value="{{(isset($value->offer_det_id) ? $value->offer_det_id : '')}}">

                                                              <input type="hidden" name="image[]" id="image_{{$value->product_id}}" class= "gj_c_img" value="{{$value->image}}">

                                                            <div class="ps-product--cart">
                                                                <div class="ps-product__thumbnail"><a href="{{ route('view_products', ['id' => $value->product_id]) }}" target="_blank"><img src="{{ asset($product_path.'/'.$value->image) }}" alt=""></a></div>

                                                                <div class="ps-product__content">
                                                                    <a href="{{ route('view_products', ['id' => $value->product_id]) }}" target="_blank">
                                                                        <span class="gj_ctit">{{$value->name}}</span>

                                                                        @if(isset($value->att_name) && $value->att_name != 0)
                                                                          @if(isset($value->AttName->att_name) && isset($value->AttValue->att_value))
                                                                            <span>
                                                                              ({{$value->AttName->att_name}} : {{$value->AttValue->att_value}})
                                                                            </span>
                                
                                                                          @endif
                                                                         @endif
                                                                    </a>

                                                                    <p>Sold By:<strong> SHOP</strong></p>

                                                                    <input type="hidden" name="att_name[]" id="attname_{{$value->att_name}}" class="gj_att_name" value="{{$value->att_name}}">
    
                                                                    <input type="hidden" name="att_value[]" id="attvalue_{{$value->att_value}}" class="gj_att_value" value="{{$value->att_value}}">
                            
                                                                     <input type="hidden" name="name[]" id="name_{{$value->product_id}}" class="gj_c_name" value="{{$value->name}}">
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td class="price">
                                                            <!--<span class="money"> <i class="fa fa-inr"></i> </span>-->
                                                            

                                                            <input type="hidden" name="original_price[]" id="price_{{$value->product_id}}" class="gj_c_o_price" value="{{$value->original_price}}">
                                                              <input type="hidden" name="product_cost[]" id="price_{{$value->product_id}}" class="gj_c_product_cost" value="{{$value->discounted_price}}">
                                                              <input type="hidden" name="price[]" id="price_{{$value->product_id}}" class="gj_c_price" value="{{$value->price}}">
                                                              <input type="hidden" name="tax_amount[]" id="price_{{$value->product_id}}" class="gj_c_tax_amount" value="{{$value->tax_amount}}">

                                                              <input type="hidden" name="tax[]" id="tax_{{$value->product_id}}" class="gj_c_tax" value="{{$value->tax}}">
    
                                                                <input type="hidden" name="tax_type[]" id="taxtype_{{$value->product_id}}" class="gj_c_tax_type" value="{{$value->tax_type}}">
                                                        </td>
                                                        
                                                        <td>
                                                            <input type="hidden" name="service_charge[]" id="sc_{{$value->product_id}}" class="gj_sc_service_charge" value="{{$value->service_charge}}">
                                                            
                                                            <input type="hidden" name="shiping_charge[]" id="shc_{{$value->product_id}}" class="gj_sc_shiping_charge" value="{{$value->shiping_charge}}">
                                                            
                                                            <!-- @if ($value->tax_type == 2)
                                                            <input type="hidden" name="shiping_charge[]" id="shc_{{$value->product_id}}" class="gj_sc_shiping_charge" value="{{$value->shiping_charge}}">
                                                            @else
                                                              <input type="hidden" name="shiping_charge[]" id="shc_{{$value->product_id}}" class="gj_sc_shiping_charge" value="0">
                                                            @endif -->

                                                            <div class="form-group--number">
                                                                <button type="button" class="up">+</button>
                                                                <button type="button" class="down">-</button>

                                                                <input class="cart__qty-input gj_cart_qty form-control" type="text" name="h_qty[]" id="gj_cart_hqty_{{$value->product_id}}" value="{{$value->qty}}" min="1" pattern="[0-9]*" @if($value->is_offer == "Yes") disabled @endif>
                        
                                                                <input class="cart__qty-input gj_cart_qty" type="hidden" name="qty[]" id="gj_cart_qty_{{$value->product_id}}" value="{{$value->qty}}" min="1" pattern="[0-9]*">
                                                            </div>
                                                        </td>
                                                        
                                                        <td>
                                                            <span class="money"> <i class="fa fa-inr"></i> </span>
                                                            <span class="gj_cart_pce">
                                                                {{ round(($value->qty * $value->discounted_price),2) }}
                                                            </span>

                                                            <input type="hidden" name="total_price[]" id="totprice_{{$value->product_id}}" class="gj_tot_price" value="{{ round(($value->qty * $value->product_cost),2) }}">
                                                        </td>

                                                        <td>
                                                            <a href="javascript:void(0);" type="button" class="btnRemoveWishlist gj_cart_tabl_del" data-id="{{$value->product_id}}" data-cart-id="{{$value->id}}" data-cart-key="{{(isset($value->cart_key) ? $value->cart_key : '')}}" data-cart-del="{{(isset($value->cart_del) ? $value->cart_del : '')}}"><i class="icon-cross"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>              
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                    <div class="ps-block--checkout-order">
                                        <div class="ps-block__content">
                                            <figure>
                                                <figcaption><strong>Product</strong><strong>Total</strong></figcaption>
                                            </figure>

                                            <figure class="ps-block__items">
                                                @foreach ($carts as $key => $value)
                                                    <a href="{{ route('view_products', ['id' => $value->product_id]) }}">
                                                        <strong>{{$value->name}}</strong>
                                                        <span> 
                                                            <small> 
                                                                <span class="money"> <i class="fa fa-inr"></i> </span> 
                                                                <span class="gj_all_cart_pce" id="prod_{{$value->product_id}}"> {{ round(($value->qty * $value->discounted_price),2) }}</span>
                                                            </small>
                                                        </span>
                                                    </a>
                                                @endforeach
                                            </figure>
                                            
                                            <figure>
                                                <figcaption><strong>Subtotal</strong><strong> <span class="money"> <i class="fa fa-inr"></i> </span> <span class="gj_all_cart_sub_tot">0.00</span></strong></figcaption>
                                            </figure>

                                            <figure>
                                                <figcaption><strong>Shipping</strong><strong> <span class="money"> <i class="fa fa-inr"></i> </span> <span class="gj_all_cart_ship_tot">0.00</span></strong></figcaption>
                                            </figure>
                                            
                                            <figure class="ps-block__total">
                                                <h3>Total<strong> <span class="money"> <i class="fa fa-inr"></i> </span> <span class="gj_all_cart_total">0.00</span></strong></h3>

                                                <input type="hidden" name="cart_sub_tot" class="gj_cart_sub_tot">
                                                <input type="hidden" name="cart_ship_tot" class="gj_cart_ship_tot">
                                                <input type="hidden" name="cart_totalval" class="gj_cart_totalval">
                                            </figure> 

                                            <a class="ps-btn ps-btn--fullwidth" href="{{ route('checkout') }}">Proceed to checkout</a>
                                        </div>             
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                @elseif(isset($ses_carts) && $ses_carts)
                    {{ Form::open(array('url' => 'cart', 'novalidate','class'=>'gj_cart_frm ps-form--checkout','files' => true)) }}
                        <div class="ps-form__content">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 ">
                                    <div class="ps-block--shipping takrolliz">
                                        <h4>Shipping method</h4>
                            
                                        <hr>                                
                  
                                        <div class="table-responsive ">
                                            <table class="table ps-table--shopping-cart"> 
                                                <tbody>
                                                    @foreach ($ses_carts as $key => $value)
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="product_id[]" id="product_{{$value->product_id}}" class="gj_p_id" value="{{$value->product_id}}">
    
                                                            <input type="hidden" name="cart_id[]" id="cart_{{$key}}" class="gj_cart_id" value="0">
                        
                                                              <input type="hidden" name="cart_key[]" id="cartkey_{{$key}}" class="gj_cart_key" value="{{(isset($value->cart_key) ? $value->cart_key : '')}}">
                        
                                                              <input type="hidden" name="cart_del[]" id="cart_del_{{$key}}" class="gj_cart_del" value="{{(isset($value->cart_del) ? $value->cart_del : '')}}">
                        
                                                              <input type="hidden" name="is_offer[]" id="isoffer_{{$key}}" class="gj_is_offer" value="{{((isset($value->is_offer)) ? $value->is_offer : '')}}">
                        
                                                              <input type="hidden" name="offer_id[]" id="offerid_{{$key}}" class="gj_offer_id" value="{{(isset($value->offer_id) ? $value->offer_id : '')}}">
                                                              
                                                              <input type="hidden" name="offer_det_id[]" id="offerdetid_{{$key}}" class="gj_offer_det_id" value="{{(isset($value->offer_det_id) ? $value->offer_det_id : '')}}">

                                                              <input type="hidden" name="image[]" id="image_{{$value->product_id}}" class= "gj_c_img" value="{{$value->image}}">

                                                            <div class="ps-product--cart">
                                                                <div class="ps-product__thumbnail"><a href="{{ route('view_products', ['id' => $value->product_id]) }}" target="_blank"><img src="{{ asset($product_path.'/'.$value->image) }}" alt=""></a></div>

                                                                <div class="ps-product__content">
                                                                    <a href="{{ route('view_products', ['id' => $value->product_id]) }}" target="_blank">
                                                                        <span class="gj_ctit">{{$value->name}}</span>

                                                                        @if(isset($value->att_name) && $value->att_name != 0)
                                                                          @if(isset($value->AttName->att_name) && isset($value->AttValue->att_value))
                                                                            <span>
                                                                              ({{$value->AttName->att_name}} : {{$value->AttValue->att_value}})
                                                                            </span>
                                
                                                                          @endif
                                                                         @endif
                                                                    </a>

                                                                    <p>Sold By:<strong> SHOP</strong></p>

                                                                    <input type="hidden" name="att_name[]" id="attname_{{$value->att_name}}" class="gj_att_name" value="{{$value->att_name}}">
    
                                                                    <input type="hidden" name="att_value[]" id="attvalue_{{$value->att_value}}" class="gj_att_value" value="{{$value->att_value}}">
                            
                                                                     <input type="hidden" name="name[]" id="name_{{$value->product_id}}" class="gj_c_name" value="{{$value->name}}">
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td class="price">
                                                            <span class="money"> <i class="fa fa-inr"></i> </span>{{$value->product_cost}}

                                                            <input type="hidden" name="original_price[]" id="price_{{$value->product_id}}" class="gj_c_o_price" value="{{$value->original_price}}">
                                                              <input type="hidden" name="product_cost[]" id="price_{{$value->product_id}}" class="gj_c_product_cost" value="{{$value->product_cost}}">
                                                              <input type="hidden" name="price[]" id="price_{{$value->product_id}}" class="gj_c_price" value="{{$value->price}}">
                                                              <input type="hidden" name="tax_amount[]" id="price_{{$value->product_id}}" class="gj_c_tax_amount" value="{{$value->tax_amount}}">

                                                              <input type="hidden" name="tax[]" id="tax_{{$value->product_id}}" class="gj_c_tax" value="{{$value->tax}}">
    
                                                                <input type="hidden" name="tax_type[]" id="taxtype_{{$value->product_id}}" class="gj_c_tax_type" value="{{$value->tax_type}}">
                                                        </td>
                                                        
                                                        <td>
                                                            <input type="hidden" name="service_charge[]" id="sc_{{$value->product_id}}" class="gj_sc_service_charge" value="{{$value->service_charge}}">
                                                            
                                                            <input type="hidden" name="shiping_charge[]" id="shc_{{$value->product_id}}" class="gj_sc_shiping_charge" value="{{$value->shiping_charge}}">
                                                            
                                                            <!-- @if ($value->tax_type == 2)
                                                            <input type="hidden" name="shiping_charge[]" id="shc_{{$value->product_id}}" class="gj_sc_shiping_charge" value="{{$value->shiping_charge}}">
                                                            @else
                                                              <input type="hidden" name="shiping_charge[]" id="shc_{{$value->product_id}}" class="gj_sc_shiping_charge" value="0">
                                                            @endif -->

                                                            <div class="form-group--number">
                                                                <button type="button" class="up">+</button>
                                                                <button type="button" class="down">-</button>

                                                                <input class="cart__qty-input gj_cart_qty form-control" type="text" name="h_qty[]" id="gj_cart_hqty_{{$value->product_id}}" value="{{$value->qty}}" min="1" pattern="[0-9]*" @if(isset($value->is_offer) && $value->is_offer == "Yes") disabled @endif>
                        
                                                                <input class="cart__qty-input gj_cart_qty" type="hidden" name="qty[]" id="gj_cart_qty_{{$value->product_id}}" value="{{$value->qty}}" min="1" pattern="[0-9]*">
                                                            </div>
                                                        </td>
                                                        
                                                        <td>
                                                            <span class="money"> <i class="fa fa-inr"></i> </span>
                                                            <span class="gj_cart_pce">
                                                                {{ round(($value->qty * $value->product_cost),2) }}
                                                            </span>

                                                            <input type="hidden" name="total_price[]" id="totprice_{{$value->product_id}}" class="gj_tot_price" value="{{ round(($value->qty * $value->product_cost),2) }}">
                                                        </td>

                                                        <td>
                                                            <a href="javascript:void(0);" type="button" class="btnRemoveWishlist gj_cart_tabl_del" data-id="{{$value->product_id}}" data-cart-id="0" data-cart-key="{{(isset($value->cart_key) ? $value->cart_key : '')}}" data-cart-del="{{(isset($value->cart_del) ? $value->cart_del : '')}}"><i class="icon-cross"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>              
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                                    <div class="ps-block--checkout-order">
                                        <div class="ps-block__content">
                                            <figure>
                                                <figcaption><strong>Product</strong><strong>Total</strong></figcaption>
                                            </figure>

                                            <figure class="ps-block__items">
                                                @foreach ($ses_carts as $key => $value)
                                                    <a href="{{ route('view_products', ['id' => $value->product_id]) }}">
                                                        <strong>{{$value->name}}</strong>
                                                        <span> 
                                                            <small> 
                                                                <span class="money"> <i class="fa fa-inr"></i> </span> 
                                                                <span class="gj_all_cart_pce" id="prod_{{$value->product_id}}">{{ round(($value->qty * $value->discounted_price),2) }} </span>
                                                            </small>
                                                        </span>
                                                    </a>
                                                @endforeach
                                            </figure>
                                            
                                            <figure>
                                                <figcaption><strong>Subtotal</strong><strong> <span class="money"> <i class="fa fa-inr"></i> </span> <span class="gj_all_cart_sub_tot">0.00</span></strong></figcaption>
                                            </figure>

                                            <figure>
                                                <figcaption><strong>Shipping</strong><strong> <span class="money"> <i class="fa fa-inr"></i> </span> <span class="gj_all_cart_ship_tot">0.00</span></strong></figcaption>
                                            </figure>
                                            
                                            <figure class="ps-block__total">
                                                <h3>Total<strong> <span class="money"> <i class="fa fa-inr"></i> </span> <span class="gj_all_cart_total">0.00</span></strong></h3>

                                                <input type="hidden" name="cart_sub_tot" class="gj_cart_sub_tot">
                                                <input type="hidden" name="cart_ship_tot" class="gj_cart_ship_tot">
                                                <input type="hidden" name="cart_totalval" class="gj_cart_totalval">
                                            </figure> 

                                            <a class="ps-btn ps-btn--fullwidth" href="{{ route('checkout') }}">Proceed to checkout</a>
                                        </div>             
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                @else
                    <p class="gj_no_data">Cart is Empty</p>
                @endif 
            </div>
        </div>
    </section>
@endsection

@section('before_scripts')
<script>
    function cal_sum() {
        var sum = 0;
        var ship = 0;

        $(".gj_all_cart_pce").each(function() {
            var value = $(this).text();

            if(!isNaN(value) && value.length != 0) {
              sum += parseFloat(value);
            }
        });


        $(".gj_sc_shiping_charge").each(function() {
            var sh_value = $(this).val();

            if(!isNaN(sh_value) && sh_value.length != 0) {
              ship += parseFloat(sh_value);
            }
        });


        ctot = sum + ship;

        sum = (sum).toFixed(2);
        $('.gj_all_cart_sub_tot').text(sum);
        $('.gj_cart_sub_tot').val(sum);

        ship = (ship).toFixed(2);
        $('.gj_all_cart_ship_tot').text(ship); 
        $('.gj_cart_ship_tot').val(ship); 

        ctot = (ctot).toFixed(2);
        $('.gj_all_cart_total').text(ctot);
        $('.gj_cart_totalval').val(ctot);
    }

    $(document).ready(function() { 
        $('p.alert').delay(7000).slideUp(700);

        cal_sum(); 
    });

    $('.gj_cart_qty').on('change', function() {
        var id = $(this).closest('tr').find('.gj_p_id').val();
        var qty = 1;
        var price = 0;
        var tax = 0;
        var att_name = 0;
        var att_value = 0;
        var tax_type = 0;
        var total = 0.00;
        var cart_key = "";
        var cart_id = "";
        var is_offer = "No";
        var hm = $(this);

        if($(this).val() == 0) {
            var qty = 1;
            $(this).val(qty);
        } else {
            var qty = $(this).val();
        }

        if($(this).closest('tr').find('.gj_cart_key').val()) {
          var cart_key = $(this).closest('tr').find('.gj_cart_key').val();
        }

        if($(this).closest('tr').find('.gj_cart_id').val()) {
          var cart_id = $(this).closest('tr').find('.gj_cart_id').val();
        }

        if($(this).closest('tr').find('.gj_is_offer').val()) {
          var is_offer = $(this).closest('tr').find('.gj_is_offer').val();
        }

        if($(this).closest('tr').find('.gj_att_name').val()) {
          var att_name = $(this).closest('tr').find('.gj_att_name').val();
        }

        if($(this).closest('tr').find('.gj_att_value').val()) {
          var att_value = $(this).closest('tr').find('.gj_att_value').val();
        }

        if($(this).closest('tr').find('.gj_c_product_cost').val()) {
          var price = parseFloat($(this).closest('tr').find('.gj_c_product_cost').val());
        }

        if($(this).closest('tr').find('.gj_c_tax').val()) {
          tax = $(this).closest('tr').find('.gj_c_tax').val();
        }

        if($(this).closest('tr').find('.gj_c_tax_type').val()) {
          tax_type = $(this).closest('tr').find('.gj_c_tax_type').val();
        }

        /*if(tax_type == 2) {
          var calc_tax = ((price * tax)/100);
          price = price + calc_tax;
        }*/

        // var calc_tax = ((price * tax)/100);
        // price = price + calc_tax;
        if(is_offer == 'Yes') {
            qty = 1;
            $(this).attr('disabled', true);
        }

        if(id) {
            $.ajax({
                type: 'post',
                url: '{{url('/check_onhand_qty')}}',
                data: {id: id, qty: qty, price: price, att_name: att_name, att_value: att_value, type: 'check_onhand_qty'},       
                dataType:"json",   
                success: function(data){
                    if(data['error'] == 2){
                      $.confirm({
                            title: '',
                            content: 'Out of Stock. Only ' + data['onhand_qty'] + ' Products Avaliable!',
                            icon: 'fa fa-exclamation',
                            theme: 'modern',
                            closeIcon: true,
                            animation: 'scale',
                            type: 'purple',
                            buttons: {
                                Ok: function(){
                                    // window.location.reload();
                                }
                            }
                        });

                        qty = 1;
                        $(hm).val(1);
                        data = (price * $(hm).val()).toFixed(2);
                        $(hm).closest('tr').find('.gj_cart_qty').val(1);
                        $(hm).closest('tr').find('.gj_cart_pce').html(data);
                        $('#prod_'+id).text(data);
                        $(hm).closest('tr').find('.gj_tot_price').val(data);

                        cal_sum();

                        $.ajax({
                            type: 'post',
                            url: '{{url('/cart_qty_update')}}',
                            data: {id: id, qty: qty, tot_price: data, cart_key: cart_key, cart_id: cart_id, type: 'cart_qty_update'},       
                            dataType:"json",   
                            success: function(data){
                                console.log(data);
                            }
                        });
                    } else if(data['error'] == 3){
                      $.confirm({
                            title: '',
                            content: 'Out of Stock.Products Not Avaliable!',
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

                        qty = 1;
                        $(hm).val(1);
                        data = (price * $(hm).val()).toFixed(2);
                        $(hm).closest('tr').find('.gj_cart_qty').val(1);
                        $(hm).closest('tr').find('.gj_cart_pce').html(data);
                        $('#prod_'+id).text(data);
                        $(hm).closest('tr').find('.gj_tot_price').val(data);
                        cal_sum();

                        $.ajax({
                            type: 'post',
                            url: '{{url('/cart_qty_update')}}',
                            data: {id: id, qty: qty, tot_price: data, cart_key: cart_key, cart_id: cart_id, type: 'cart_qty_update'},       
                            dataType:"json",   
                            success: function(data){
                                console.log(data);
                            }
                        });
                    } else if (data != 1) {
                        $(hm).val(qty);
                        data = (data).toFixed(2);
                        $(hm).closest('tr').find('.gj_cart_qty').val(qty);
                        $(hm).closest('tr').find('.gj_cart_pce').html(data);
                        $('#prod_'+id).text(data);
                        $(hm).closest('tr').find('.gj_tot_price').val(data);
                        cal_sum();

                        $.ajax({
                            type: 'post',
                            url: '{{url('/cart_qty_update')}}',
                            data: {id: id, qty: qty, tot_price: data, cart_key: cart_key, cart_id: cart_id, type: 'cart_qty_update'},       
                            dataType:"json",   
                            success: function(data){
                                console.log(data);
                            }
                        });
                    } else {
                        qty = 1;
                        $(hm).val('1');
                        data = (price * $(hm).val()).toFixed(2);
                        $(hm).closest('tr').find('.gj_cart_qty').val(1);
                        $(hm).closest('tr').find('.gj_cart_pce').html(data);
                        $('#prod_'+id).text(data);
                        $(hm).closest('tr').find('.gj_tot_price').val(data);
                        cal_sum();

                        $.ajax({
                            type: 'post',
                            url: '{{url('/cart_qty_update')}}',
                            data: {id: id, qty: qty, tot_price: data, cart_key: cart_key, cart_id: cart_id, type: 'cart_qty_update'},       
                            dataType:"json",   
                            success: function(data){
                                console.log(data);
                            }
                        });
                    }
                }
            });        
        }
    });

    $('.up').on('click', function() {
        var id = $(this).closest('tr').find('.gj_p_id').val();
        var qty = 1;
        var price = 0;
        var tax = 0;
        var att_name = 0;
        var att_value = 0;
        var tax_type = 0;
        var total = 0.00;
        var cart_id = "";
        var cart_key = "";
        var is_offer = "No";
        var hm = $(this);

        if($(this).closest('tr').find('.gj_cart_key').val()) {
          var cart_key = $(this).closest('tr').find('.gj_cart_key').val();
        }

        if($(this).closest('tr').find('.gj_cart_id').val()) {
          var cart_id = $(this).closest('tr').find('.gj_cart_id').val();
        }

        if($(this).closest('tr').find('.gj_cart_qty').val() == 0) {
            var qty = 1;
            $(this).closest('tr').find('.gj_cart_qty').val(qty);
        } else {
            var qty = parseInt($(this).closest('tr').find('.gj_cart_qty').val()) + 1;
        }

        if($(this).closest('tr').find('.gj_is_offer').val()) {
          var is_offer = $(this).closest('tr').find('.gj_is_offer').val();
        }

        if($(this).closest('tr').find('.gj_att_name').val()) {
          var att_name = $(this).closest('tr').find('.gj_att_name').val();
        }

        if($(this).closest('tr').find('.gj_att_value').val()) {
          var att_value = $(this).closest('tr').find('.gj_att_value').val();
        }

        if($(this).closest('tr').find('.gj_c_product_cost').val()) {
          var price = parseFloat($(this).closest('tr').find('.gj_c_product_cost').val());
        }

        if($(this).closest('tr').find('.gj_c_tax').val()) {
          tax = $(this).closest('tr').find('.gj_c_tax').val();
        }

        if($(this).closest('tr').find('.gj_c_tax_type').val()) {
          tax_type = $(this).closest('tr').find('.gj_c_tax_type').val();
        }

        /*if(tax_type == 2) {
          var calc_tax = ((price * tax)/100);
          price = price + calc_tax;
        }*/

        // var calc_tax = ((price * tax)/100);
        // price = price + calc_tax;
        if(is_offer == 'Yes') {
            qty = 1;
            $(this).attr('disabled', true);
        }

        if(id) {
            $.ajax({
                type: 'post',
                url: '{{url('/check_onhand_qty')}}',
                data: {id: id, qty: qty, price: price, att_name: att_name, att_value: att_value, type: 'check_onhand_qty'},       
                dataType:"json",   
                success: function(data){
                    if(data['error'] == 2){
                      $.confirm({
                            title: '',
                            content: 'Out of Stock. Only ' + data['onhand_qty'] + ' Products Avaliable!',
                            icon: 'fa fa-exclamation',
                            theme: 'modern',
                            closeIcon: true,
                            animation: 'scale',
                            type: 'purple',
                            buttons: {
                                Ok: function(){
                                    // window.location.reload();
                                }
                            }
                        });
                        qty = 1;
                        $(hm).val(1);
                        data = (price * $(hm).val()).toFixed(2);
                        $(hm).closest('tr').find('.gj_cart_qty').val(1);
                        $(hm).closest('tr').find('.gj_cart_pce').html(data);
                        $('#prod_'+id).text(data);
                        $(hm).closest('tr').find('.gj_tot_price').val(data);
                        cal_sum();

                        $.ajax({
                            type: 'post',
                            url: '{{url('/cart_qty_update')}}',
                            data: {id: id, qty: qty, tot_price: data, cart_key: cart_key, cart_id: cart_id, type: 'cart_qty_update'},       
                            dataType:"json",   
                            success: function(data){
                                console.log(data);
                            }
                        });
                    } else if(data['error'] == 3){
                      $.confirm({
                            title: '',
                            content: 'Out of Stock.Products Not Avaliable!',
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
                        qty = 1;
                        $(hm).val(1);
                        data = (price * $(hm).val()).toFixed(2);
                        $(hm).closest('tr').find('.gj_cart_qty').val(1);
                        $(hm).closest('tr').find('.gj_cart_pce').html(data);
                        $(hm).closest('tr').find('.gj_all_cart_pce').html(data);
                        $(hm).closest('tr').find('.gj_tot_price').val(data);
                        cal_sum();

                        $.ajax({
                            type: 'post',
                            url: '{{url('/cart_qty_update')}}',
                            data: {id: id, qty: qty, tot_price: data, cart_key: cart_key, cart_id: cart_id, type: 'cart_qty_update'},       
                            dataType:"json",   
                            success: function(data){
                                console.log(data);
                            }
                        });
                    } else if (data != 1) {
                        $(hm).val(qty);
                        data = (data).toFixed(2);
                        $(hm).closest('tr').find('.gj_cart_qty').val(qty);
                        $(hm).closest('tr').find('.gj_cart_pce').html(data);
                        $('#prod_'+id).text(data);
                        $(hm).closest('tr').find('.gj_tot_price').val(data);
                        cal_sum();

                        $.ajax({
                            type: 'post',
                            url: '{{url('/cart_qty_update')}}',
                            data: {id: id, qty: qty, tot_price: data, cart_key: cart_key, cart_id: cart_id, type: 'cart_qty_update'},       
                            dataType:"json",   
                            success: function(data){
                                console.log(data);
                            }
                        });
                    } else {
                        qty= 1;

                        $(hm).val('1');
                        data = (price * $(hm).val()).toFixed(2);
                        $(hm).closest('tr').find('.gj_cart_qty').val(1);
                        $(hm).closest('tr').find('.gj_cart_pce').html(data);
                        $('#prod_'+id).text(data);
                        $(hm).closest('tr').find('.gj_tot_price').val(data);
                        cal_sum();

                        $.ajax({
                            type: 'post',
                            url: '{{url('/cart_qty_update')}}',
                            data: {id: id, qty: qty, tot_price: data, cart_key: cart_key, cart_id: cart_id, type: 'cart_qty_update'},       
                            dataType:"json",   
                            success: function(data){
                                console.log(data);
                            }
                        });
                    }
                }
            });        
        }
    });

    $('.down').on('click', function() {
        var id = $(this).closest('tr').find('.gj_p_id').val();
        var qty = 1;
        var price = 0;
        var tax = 0;
        var att_name = 0;
        var att_value = 0;
        var tax_type = 0;
        var total = 0.00;
        var cart_id = "";
        var cart_key = "";
        var is_offer = "No";
        var hm = $(this);

        if($(this).closest('tr').find('.gj_cart_key').val()) {
          var cart_key = $(this).closest('tr').find('.gj_cart_key').val();
        }

        if($(this).closest('tr').find('.gj_cart_id').val()) {
          var cart_id = $(this).closest('tr').find('.gj_cart_id').val();
        }

        if($(this).closest('tr').find('.gj_cart_qty').val() == 0) {
            var qty = 1;
            $(this).closest('tr').find('.gj_cart_qty').val(qty);
        } else {
            var qty = parseInt($(this).closest('tr').find('.gj_cart_qty').val()) - 1;

            if(qty <= 0) {
                qty = 1;
            }
        }

        if($(this).closest('tr').find('.gj_is_offer').val()) {
          var is_offer = $(this).closest('tr').find('.gj_is_offer').val();
        }

        if($(this).closest('tr').find('.gj_att_name').val()) {
          var att_name = $(this).closest('tr').find('.gj_att_name').val();
        }

        if($(this).closest('tr').find('.gj_att_value').val()) {
          var att_value = $(this).closest('tr').find('.gj_att_value').val();
        }

        if($(this).closest('tr').find('.gj_c_product_cost').val()) {
          var price = parseFloat($(this).closest('tr').find('.gj_c_product_cost').val());
        }

        if($(this).closest('tr').find('.gj_c_tax').val()) {
          tax = $(this).closest('tr').find('.gj_c_tax').val();
        }

        if($(this).closest('tr').find('.gj_c_tax_type').val()) {
          tax_type = $(this).closest('tr').find('.gj_c_tax_type').val();
        }

        /*if(tax_type == 2) {
          var calc_tax = ((price * tax)/100);
          price = price + calc_tax;
        }*/

        // var calc_tax = ((price * tax)/100);
        // price = price + calc_tax;
        if(is_offer == 'Yes') {
            qty = 1;
            $(this).attr('disabled', true);
        }

        if(id) {
            $.ajax({
                type: 'post',
                url: '{{url('/check_onhand_qty')}}',
                data: {id: id, qty: qty, price: price, att_name: att_name, att_value: att_value, type: 'check_onhand_qty'},       
                dataType:"json",   
                success: function(data){
                    if(data['error'] == 2){
                      $.confirm({
                            title: '',
                            content: 'Out of Stock. Only ' + data['onhand_qty'] + ' Products Avaliable!',
                            icon: 'fa fa-exclamation',
                            theme: 'modern',
                            closeIcon: true,
                            animation: 'scale',
                            type: 'purple',
                            buttons: {
                                Ok: function(){
                                    // window.location.reload();
                                }
                            }
                        });

                        qty = 1;
                        $(hm).val(1);
                        data = (price * $(hm).val()).toFixed(2);
                        $(hm).closest('tr').find('.gj_cart_qty').val(1);
                        $(hm).closest('tr').find('.gj_cart_pce').html(data);
                        $('#prod_'+id).text(data);
                        $(hm).closest('tr').find('.gj_tot_price').val(data);
                        cal_sum();

                        $.ajax({
                            type: 'post',
                            url: '{{url('/cart_qty_update')}}',
                            data: {id: id, qty: qty, tot_price: data, cart_key: cart_key, cart_id: cart_id, type: 'cart_qty_update'},       
                            dataType:"json",   
                            success: function(data){
                                console.log(data);
                            }
                        });
                    } else if(data['error'] == 3){
                      $.confirm({
                            title: '',
                            content: 'Out of Stock.Products Not Avaliable!',
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
                        qty = 1;
                        $(hm).val(1);
                        data = (price * $(hm).val()).toFixed(2);
                        $(hm).closest('tr').find('.gj_cart_qty').val(1);
                        $(hm).closest('tr').find('.gj_cart_pce').html(data);
                        $('#prod_'+id).text(data);
                        $(hm).closest('tr').find('.gj_tot_price').val(data);
                        cal_sum();

                        $.ajax({
                            type: 'post',
                            url: '{{url('/cart_qty_update')}}',
                            data: {id: id, qty: qty, tot_price: data, cart_key: cart_key, cart_id: cart_id, type: 'cart_qty_update'},       
                            dataType:"json",   
                            success: function(data){
                                console.log(data);
                            }
                        });
                    } else if (data != 1) {
                        $(hm).val(qty);
                        data = (data).toFixed(2);
                        $(hm).closest('tr').find('.gj_cart_qty').val(qty);
                        $(hm).closest('tr').find('.gj_cart_pce').html(data);
                        $('#prod_'+id).text(data);
                        $(hm).closest('tr').find('.gj_tot_price').val(data);
                        cal_sum();

                        $.ajax({
                            type: 'post',
                            url: '{{url('/cart_qty_update')}}',
                            data: {id: id, qty: qty, tot_price: data, cart_key: cart_key, cart_id: cart_id, type: 'cart_qty_update'},       
                            dataType:"json",   
                            success: function(data){
                                console.log(data);
                            }
                        });
                    } else {
                        qty = 1;
                        $(hm).val('1');
                        data = (price * $(hm).val()).toFixed(2);
                        $(hm).closest('tr').find('.gj_cart_qty').val(1);
                        $(hm).closest('tr').find('.gj_cart_pce').html(data);
                        $('#prod_'+id).text(data);
                        $(hm).closest('tr').find('.gj_tot_price').val(data);
                        cal_sum();

                        $.ajax({
                            type: 'post',
                            url: '{{url('/cart_qty_update')}}',
                            data: {id: id, qty: qty, tot_price: data, cart_key: cart_key, cart_id: cart_id, type: 'cart_qty_update'},       
                            dataType:"json",   
                            success: function(data){
                                console.log(data);
                            }
                        });
                    }
                }
            });        
        }
    });
</script>
@endsection
