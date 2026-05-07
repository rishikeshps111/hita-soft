<?php  
    $product_path = 'images/featured_products';
    $noimage = \DB::table('noimage_settings')->first();
    $noimage_path = 'images/noimage';
?>
@extends('layouts.frontend')
@section('title', 'View Wish List')
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('login/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('login/main.css')}}"> -->
@section('content')

<section class="gj_sec_cart">
  <div class="main-content" id="MainContent">
    <section id="pageContent">
      <div class="container">
        <div class="wishlist-product">
          <h2 class="page-title">Wishlist</h2>

          @if (isset($wishlist) && count($wishlist) != 0)
            <div class="pageContent">
              <div class="table-responsive">
               <table class="table wishlist-product">
                  <thead>
                     <tr class="wl-title">
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th class="text-center">Unit Price</th>
                        <th class="text-center">Add to cart</th>
                        <th class="text-center">Remove</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($wishlist as $key =>$value)
                      <tr class="row-15484180791407 product-item" id="pi_{{$value->id}}">
                          <td>
                            <input type="hidden" name="product_id[]" id="product_{{$value->product_id}}" class="gj_p_id" value="{{$value->product_id}}">

                            <input type="hidden" name="w_id[]" id="wishlist_{{$value->id}}" class="gj_w_id" value="{{$value->id}}">

                            <a href="{{ route('view_products', ['id' => $value->product_id]) }}">
                              <img class="cart__image" src="{{ asset($product_path.'/'.$value->image) }}" alt="{{$value->name}}">
                              <input type="hidden" name="image[]" id="image_{{$value->product_id}}" class= "gj_w_img" value="{{$value->image}}">
                            </a>
                          </td>
                          <td>
                            <a href="{{ route('view_products', ['id' => $value->product_id]) }}" class="product-title">{{$value->name}}</a>
                            <input type="hidden" name="name[]" id="name_{{$value->product_id}}" class="gj_w_name" value="{{$value->name}}">
                          </td>
                          <td class="text-center">
                             <div class="price">
                                <span class="price-new"><span class="money" data-currency-usd="&#8377;{{$value->discounted_price}}"> &#8377;  <span class="gj_w_d_p">{{$value->discounted_price}}</span></span></span>
                                <span class="price-old"><span class="money" data-currency-usd="&#8377; {{$value->original_price}}">&#8377; <span class="gj_w_o_p">{{$value->original_price}}</span></span></span>
                             </div>
                            <input type="hidden" name="discounted_price[]" id="dp_{{$value->product_id}}" class="gj_w_dp" value="{{$value->discounted_price}}">

                            <input type="hidden" name="name[]" id="op_{{$value->product_id}}" class="gj_w_op" value="{{$value->original_price}}">
                          </td>
                          <td class="text-center">
                             <div class="info-wl action">
                                <form action="#" method="post" class="formAddToCart" enctype="multipart/form-data">
                                   <input type="hidden" name="id" value="15484180791407">
                                   <button class="btn btnAddToCart gj_add2cart" data-cart-id="{{$value->product_id}}" type="submit" value="Submit">
                                   <span>Add to cart</span>
                                   </button>
                                </form>
                             </div>
                          </td>
                          <td class="text-center">
                             <form method="post" action="/delete_wishlist" id="removeWishlist" accept-charset="UTF-8">
                                <input name="utf8" type="hidden" value="✓">
                                <input type="hidden" name="id" value="{{$value->id}}">
                                <button type="submit" class="btnRemoveWishlist"><i class="fa fa-remove"></i></button>
                             </form>
                          </td>
                      </tr>
                    @endforeach
                  </tbody>
               </table>
              </div>
            </div>
          @else
            <tr>
              <td colspan="5">
                <p class="gj_no_data">Wish List is Empty</p>
              </td>
            </tr>
          @endif 
        </div>
      </div>
    </section>
  </div>
</section>

<script>
  $(document).ready(function() { 
    $('p.alert').delay(7000).slideUp(700);
  });
</script>
@endsection