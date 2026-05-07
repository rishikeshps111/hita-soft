
<?php 
use App\Products;

$banner_path = 'images/banner_image';
$main_cat_path = 'images/main_cat_image';
$sub_cat_path = 'images/sub_cat_image';
$product_path = 'images/featured_products';
$noimage = \DB::table('noimage_settings')->first();
$noimage_path = 'images/noimage';


$all_left_off = \DB::table('category_advertisement_settings')->Where('is_block', 1)->Where('payment_status', 1)->Where('page', 'All Product Page')->Where('position', 'Bottom Left')->first();
$nw_date = date('Y-m-d');
$nw_date = date('Y-m-d', strtotime($nw_date));

if($all_left_off) {
  $st_date1 = date('Y-m-d', strtotime($all_left_off->ad_start_date));
  $en_date1 = date('Y-m-d', strtotime($all_left_off->ad_end_date));
}
?>

@extends('layouts.frontend')
@section('title', 'Ready To Ship')
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

#price-slider{
    margin-top:15px;
}

.price-range-values{
    font-weight:600;
    margin-bottom:10px;
}
.category-filter-list{
    list-style:none;
    padding:0;
    margin:0;
}

.category-filter-list li{
    margin-bottom:8px;
}

.category-item{
    display:flex;
    align-items:center;
    gap:8px;
    cursor:pointer;
    font-size:14px;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.css">
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

<section class="">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <div class="faq-icon-top">
                        <img src="assets/img/icon.png" alt="">
                    </div> -->
                    <div class="section-title column-title title-bg">
                    <h3> @if(request('type') === 'latest')
                        Latest Products
                    @else
                        Ready to Ship
                    @endif</h3>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    <section class="section-padding pt-4 pb-0 sec-border">
        <div class="container">
             <div class="row">
                 <div class="col-lg-3 mb-3">
                      <form action="{{ url('ready-to-ship') }}" class="gj_all_prd_srh produlct-filter-left" method="GET">
                          <div class="filter-sidebar ">
                                
                                    <h5 class="filter-title">Price</h5>
                                
                                    <div class="price-range-values">
                                        ₹<span id="min-price">0</span> - ₹<span id="max-price">90000</span>
                                    </div>
                                
                                    <div id="price-slider"></div>
                                
                                    <input type="hidden" name="min_price" id="min_price" value="{{ request('min_price') }}">
                                    <input type="hidden" name="max_price" id="max_price" value="{{ request('max_price') }}">
                                
                    
                                <!--<h5 class="filter-title mt-4">Category</h5>-->
                    
                                <!--<select class="form-select shadow-none gj_main_cat_filt">-->
                                <!--    <option value="">Select Category</option>-->
                    
                                <!--    @foreach($category as $fcv)-->
                                <!--        <option value="{{$fcv->id}}" -->
                                <!--            {{ request()->get('main_cat') == $fcv->id ? 'selected' : '' }}>-->
                                <!--            {{$fcv->main_cat_name}}-->
                                <!--        </option>-->
                                <!--    @endforeach-->
                    
                                <!--</select>-->
                                <h5 class="filter-title mt-4">Category</h5>

                                <ul class="category-filter-list">
                                    @foreach($category as $fcv)
                                        <li>
                                            <label class="category-item">
                                                <input type="checkbox"
                                                       name="main_cat[]"
                                                       value="{{ $fcv->id }}"
                                                       {{ (is_array(request()->get('main_cat')) && in_array($fcv->id, request()->get('main_cat'))) ? 'checked' : '' }}>
                                
                                                <span>{{ $fcv->main_cat_name }}</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                    
                               {{-- <input type="hidden" name="main_cat" class="gj_main_cat_filter"
                                    value="{{ request()->get('main_cat') }}"> --}}
                    
                            </div>
                          
                        </form>
                 </div>
                 
                 <div class="col-lg-9 mb-3">
                     
                     <div class="product-main-container">
                       

                        <div class="row">
                           @if(isset($products) && count($products) != 0)
                            @foreach($products as $key => $value) 
                            <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                                <div class="Featured-product">
                                    @if(isset($value->featured_product_img) && $value->featured_product_img)
                                        <a href="{{ route('view_products', ['id' => $value->id]) }}" class="view-a">
                                            <div class="Featured-product-img">
                                                <img src="{{ asset($product_path.'/'.$value->featured_product_img) }}" alt="">
                                                @if($value->onhand_qty == 0)
                                                    <div class="stock-overlay">Out of Stock</div>
                                                @endif
                                                 <!--<div class="product-icon-container">-->
                                                     
                                                 <!--</div>-->
                                            </div>
                                        </a>
                                    
                                    @else
                                    <a href="{{ route('view_products', ['id' => $value->id]) }}">
                                            <div class="Featured-product-img">
                                        <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image) }}" alt="NImg">
                                        @if($value->onhand_qty == 0)
                                                    <div class="stock-overlay">Out of Stock</div>
                                                @endif
                                                 <div class="product-icon-container">
                                                     <a href="javascript:void(0)" class="gj_add2cart icons-p" data-cart-id="{{$value->id}}"><i class="fa-solid fa-bag-shopping"></i></a>
                                                <a href="" class="gj_wish_list icons-p" data-wish-id="{{$value->id}}"><i class="fa-regular fa-heart"></i></a>
                                                 </div>
                                         </div>
                                        </a>
                                    @endif
                                   
                                    
                                    <div class="Featured-product-info">
                                        <div class="product-title">
                                            <h6><a href="{{ route('view_products', ['id' => $value->id]) }}"> {{$value->product_title}}</a></h6>
                                            <!--<span>-->
                                            <!--     <a href="#!"><i class="fa-solid fa-code-compare"></i></a> -->
                                                
                                            <!--</span>-->
                                        </div>
                                        <!--<p><?php echo $value->product_desc; ?></p>-->
                                        <div class="product-features-price">
                                            
                                             @if($value->discounted_price > 0)
                                           <p class="price"> ₹ {{ $value->discounted_price }} </p>
                                            <!--<p class="price">-->
                                            <!--    <strike>₹ {{ $value->original_price }}</strike>&ensp; -->
                                            <!--</p>-->
                                        @else
                                            <p class="price">₹ {{ $value->original_price }}</p>
                                        @endif
                                        <p class="stock" style="font-size: 14px;">In Stock: {{$value->onhand_qty}}</p>
                                        
                                        </div>
                                         <div class="bottom-ftr-btns">
                                    <a href="javascript:void(0)" class="gj_add2cart icons-p" data-cart-id="{{$value->id}}"><i class="fa-solid fa-bag-shopping"></i></a>
                                                <a href="" class="gj_wish_list icons-p" data-wish-id="{{$value->id}}"><i class="fa-regular fa-heart"></i></a>
                                         <a href="{{ route('view_products', ['id' => $value->id]) }}" ><i class="fa-solid fa-eye"></i></a>
                                </div>
                                        
                                    </div>
                                </div>
                            </div>
                             @endforeach
                        @else
                           <div class="col-lg-12">
                                <h6 class="gj_no_data text-center">Products Not Found</h6>
                           </div>
                        @endif
                          
                        </div>
                    </div>
                     
                     
                     
                </div>
             </div>
            

            
        </div>
    </section>

@endsection
@section('before_scripts')
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.js"></script>
<script>
// $(document).ready(function () {
//     // Price Range Filter
//     $('.gj_product_sort').on('change', function () {
//         const val = $(this).val();
//         $('input[name="sort_filter"]').val(val); // update hidden input
//         $('form.gj_all_prd_srh').submit(); // submit form
//     });

//     // Main Category Filter
//     $('.gj_main_cat_filt').on('change', function () {
//         const val = $(this).val();
//         $('input[name="main_cat"]').val(val); // update hidden input
//         $('form.gj_all_prd_srh').submit(); // submit form
//     });

//     // Show loader if needed
//     $('form.gj_all_prd_srh').on('submit', function () {
//         $('.loading-spinner').show();
//     });
// });
</script>

<script>

var minPriceVal = {{ request('min_price',7700) }};
var maxPriceVal = {{ request('max_price',89900) }};

var slider = document.getElementById('price-slider');

noUiSlider.create(slider, {
    start: [minPriceVal, maxPriceVal],
    connect: true,
    range: {
        'min': 0,
        'max': 90000
    }
});

var minPrice = document.getElementById('min-price');
var maxPrice = document.getElementById('max-price');

var minInput = document.getElementById('min_price');
var maxInput = document.getElementById('max_price');

var form = document.querySelector('.gj_all_prd_srh');

slider.noUiSlider.on('update', function(values) {

    minPrice.innerHTML = Math.round(values[0]);
    maxPrice.innerHTML = Math.round(values[1]);

    minInput.value = Math.round(values[0]);
    maxInput.value = Math.round(values[1]);

});

slider.noUiSlider.on('change', function(){
    form.submit();
});

$('.category-filter-list input').on('change', function(){
    $('.gj_all_prd_srh').submit();
});
</script>

@endsection

