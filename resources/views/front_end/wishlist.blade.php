<?php  
    $product_path = 'images/featured_products';
    $noimage = \DB::table('noimage_settings')->first();
    $noimage_path = 'images/noimage';
?>
@extends('layouts.frontend')
@section('title', 'View Wish List')
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('login/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('login/main.css')}}"> -->
<style>
    .wishlist-table tr td button.wishlist-delete {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 1px solid #9d2727;
    color: #9d2727;
    background-color: #ec9c9c63;
    font-size: 14px;
    transition: 0.5s;
    display: flex;
    justify-content: center;
    align-items: center;
}
#flash-message-container {
    margin-top: 20px;
}
.alert {
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 10px;
    font-size: 16px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}

.alert-warning {
    background-color: #fff3cd;
    color: #856404;
}
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
@section('content')
<div class="cover-head"></div>

 @if (session('errors'))
    <div class="gj_msg">
            @foreach (session('errors')->all() as $error)
                <p class="alert {{ Session::get('alert-class', 'alert-danger') }} auto-dismiss">
                    {{ $error }}
                </p>
            @endforeach
    </div>
@endif
 <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="flash-message-container"></div>
            </div>
        </div>
  </div>

<section class="section-padding py-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ route('category.products', 'necklaces') }}" style="text-decoration: none !important;"><div class="Wishlist-hero">
                        <h1>Kanchipuram Silk Saree With Floral Zari Buttas</h1>
                        <h4>SAVE UP TO</h4>
                        <h3>5 % OFF</h3>

                    </div></a>
                </div>
            </div>
        </div>
    </section>
    <section class="section-padding  bg-light-gray">
         @if (isset($wishlist) && count($wishlist) != 0)
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="wishlist-container">
                       <div class="over-scrol">
                        <table class="table wishlist-table table-borderless ">
                            <thead>
                             <tr>
                                 <th>
                                     <input type="checkbox" id="select_all" class="select-all-checkbox">
                                  </th>
                                 <th></th>
                                 <th>Product Name</th>
                                 <th>Price</th>
                                 <th>Stock Status</th>
                                 <!--<th>Actions</th>-->
                             </tr>
                            </thead>
                            <tbody>
                            @foreach ($wishlist as $key =>$value)
                             <tr>
                                <td>
                                    <input type="checkbox" class="select-item-checkbox" data-product-id="{{ $value->product_id }}">
                                    <input type="hidden" name="product_id[]" id="product_{{$value->product_id}}" class="gj_p_id" value="{{$value->product_id}}">
                                    <input type="hidden" name="w_id[]" id="wishlist_{{$value->id}}" class="gj_w_id" value="{{$value->id}}">
                                 {{-- <form method="post" action="{{route('delete_wishlist')}}" id="removeWishlist" accept-charset="UTF-8">
                                    <input name="utf8" type="hidden" value="✓">
                                    <input type="hidden" name="id" value="{{$value->id}}">
                                    <button type="submit" class="gj_btn_wish_rem wishlist-delete"><i class="fa-solid fa-trash-can" aria-hidden="true"></i></button>
                                  </form>--}}
                                </td>
                                 <td>
                                    <a href="{{ route('view_products', ['id' => $value->product_id]) }}">
                                         @if(($value->image))
                                        <img src="{{ asset($product_path.'/'.$value->image) }}" alt="" class="wishlist-product-img"> 
                                        @else
                                         <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}" class="wishlist-product-img">
                                        @endif
                                        
                                        </a> 
                                      <input type="hidden" name="image[]" id="image_{{$value->product_id}}" class= "gj_w_img" value="{{$value->image}}">
                                       <input type="hidden" name="name[]" id="name_{{$value->product_id}}" class="gj_w_name" value="{{$value->name}}">

                                    <input type="hidden" name="discounted_price[]" id="dp_{{$value->product_id}}" class="gj_w_dp" value="{{$value->discounted_price}}">

                                    <input type="hidden" name="name[]" id="op_{{$value->product_id}}" class="gj_w_op" value="{{$value->original_price}}">
                                 </td>
                                 <td> {{$value->name}}</td>
                                 <td class="td-price">₹ {{$value->discounted_price}}</td>
                                 <td>
                                    @if(isset($value->Products->onhand_qty) && $value->Products->onhand_qty != 0)
                                     In-stock
                                  @else
                                      Out of stock
                                  @endif
                                  </td>
                                 <!--<td>-->
                                 <!--   <button type="button" class="wishlist-cart-btn gj_add2cart" data-cart-id="{{$value->product_id}}">Add to Cart</button>-->
                                 <!--</td>-->
                             </tr>
                             @endforeach
                            
                            </tbody>
 
                         </table>
                         <div class="wishlist-actions add-cart-wishlist-btns">
                            <button type="button" id="add_to_cart_selected" class="wishlist-cart-btn btn" style="background-color:#198723;color: #fff;border-radius: 5px;">Add To Cart</button>
                            <button type="button" id="delete_selected" class="btn btn-danger">Delete Selected</button>
                        </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
     @else
    <h6 class="gj_no_data fw-bold text-center">Wish List is Empty</h6>
  @endif 
    </section>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() { 
    $('p.alert').delay(7000).slideUp(700);
  });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const message = localStorage.getItem('wishlistMessage');
        if (message) {
            const flashMessageContainer = document.getElementById('flash-message-container');
            flashMessageContainer.innerHTML = `
                <div class="alert alert-success" id="wishlistSuccessMessage">
                    ${message}
                </div>
            `;
            localStorage.removeItem('wishlistMessage');

            // Auto-hide after 3 seconds
            setTimeout(() => {
                const alert = document.getElementById('wishlistSuccessMessage');
                if (alert) {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = 0;
                    setTimeout(() => alert.remove(), 500); // Remove from DOM
                }
            }, 3000);
        }
    });
</script>


<script>
document.getElementById('select_all').addEventListener('change', function() {
    let checkboxes = document.querySelectorAll('.select-item-checkbox');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
});

// ADD TO CART SELECTED ITEMS
document.getElementById('add_to_cart_selected').addEventListener('click', function() {
    let selectedItems = [];
    document.querySelectorAll('.select-item-checkbox:checked').forEach(checkbox => {
        selectedItems.push({
            product_id: checkbox.getAttribute('data-product-id'),
            quantity: 1
        });
    });

    let flashMessageContainer = document.getElementById('flash-message-container');

    if (selectedItems.length > 0) {
        fetch('{{ route("add_multiple_to_cart") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ items: selectedItems })
        })
        .then(response => response.json())
        .then(data => { 
            if (data.success) {
                flashMessageContainer.innerHTML = `
                    <div class="alert alert-success">
                        Items added to cart!
                    </div>
                `;
            } else {
                flashMessageContainer.innerHTML = `
                    <div class="alert alert-danger">
                        Failed to add items to cart. ${data.error || 'Please try again.'}
                    </div>
                `;
            }
            setTimeout(function() {
                window.location.href = '{{ route("wishlist") }}';
            }, 2000);
        })
        .catch(error => {
            console.error("Error during fetch:", error);
            flashMessageContainer.innerHTML = `
                <div class="alert alert-danger">
                    There was an error processing your request.
                </div>
            `;
        });
    } else {
        flashMessageContainer.innerHTML = `
            <div class="alert alert-warning">
                Please select at least one item.
            </div>
        `;
    }
});

// DELETE SELECTED ITEMS FROM WISHLIST
document.getElementById('delete_selected').addEventListener('click', function() {
    let selectedItems = [];
    document.querySelectorAll('.select-item-checkbox:checked').forEach(checkbox => {
        selectedItems.push(checkbox.getAttribute('data-product-id'));
    });

    let flashMessageContainer = document.getElementById('flash-message-container');

    if (selectedItems.length > 0) {
        fetch('{{ route("delete_multiple_from_wishlist") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ items: selectedItems })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                localStorage.setItem('wishlistMessage', 'Selected Items Removed From WishList!');
                window.scrollTo({ top: 0, behavior: 'smooth' }); 
                setTimeout(() => {
                    window.location.reload(); // reload after a short delay
                }, 300); 
            } else {
                flashMessageContainer.innerHTML = `
                    <div class="alert alert-danger">
                        Failed to delete items from wishlist. ${data.error || ''}
                    </div>
                `;
            }
            // setTimeout(function() {
            //     window.location.href = '{{ route("wishlist") }}';
            // }, 2000);
        })
        .catch(error => {
            console.error('Error:', error);
            flashMessageContainer.innerHTML = `
                <div class="alert alert-danger">
                    There was an error processing your request.
                </div>
            `;
        });
    } else {
        flashMessageContainer.innerHTML = `
            <div class="alert alert-warning">
                Please select at least one item to delete.
            </div>
        `;
    }
});
</script>




@endsection