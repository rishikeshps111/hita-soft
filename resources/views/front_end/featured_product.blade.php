
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
@section('title', 'Featured Products')
@section('content')
<section class="section-padding pb-0 bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <div class="faq-icon-top">
                        <img src="assets/img/icon.png" alt="">
                    </div> -->
                    <div class="section-title column-title">
                    <h3> 
                        Featured Products
                   </h3>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    <section class="section-padding pt-4 pb-0 sec-border">
        <div class="container">
             <form action="{{ url('featured-product') }}" class="gj_all_prd_srh" method="GET">

            <div class="row">
                
                <div class="col-lg-12">
                    <div class="product-main-container">
                       <div class="row">
                        <div class="col-lg-4">
                            <p class="product-count">{{((isset($products) && count($products) != 0) ? count($products) : 0)}} Products</p>
                        </div>
                        <div class="col-lg-8">
                            <div class="product-filters">
                               <select class="form-select shadow-none gj_product_sort">
                                    <option value="">Price Range</option>
                                    <option value="l_h" {{ request()->get('sort_filter') == 'l_h' ? 'selected' : '' }}>Low to High</option>
                                    <option value="h_l" {{ request()->get('sort_filter') == 'h_l' ? 'selected' : '' }}>High to Low</option>
                                </select>
                                <input type="hidden" name="sort_filter" class="gj_sort_filter" value="{{ request()->get('sort_filter', '') }}">
                                <select class="form-select shadow-none gj_main_cat_filt">
                                     <option value="">Select Category</option>
                                @if(isset($category) && sizeof($category) != 0)
                                    @foreach($category as $fck => $fcv)
                                    <option value="{{$fcv->id}}" {{ request()->get('main_cat') == $fcv->id ? 'selected' : '' }}>{{$fcv->main_cat_name}}</option>
                                     @endforeach
                                @endif
                                    
                                </select>
                                 <input type="hidden" name="main_cat" class="gj_main_cat_filter" value="{{((isset($data['main_cat']) && $data['main_cat']) ? $data['main_cat'] : '')}}">
                                 <!--<input type="hidden" name="sub_cat" class="gj_sub_cat_filter" value="{{((isset($data['sub_cat']) && $data['sub_cat']) ? $data['sub_cat'] : '')}}">-->
                                 <!--<input type="hidden" name="sub_sub_cat" class="gj_sub_sub_cat_filter" value="{{((isset($data['sub_sub_cat']) && $data['sub_sub_cat']) ? $data['sub_sub_cat'] : '')}}">-->
                                
                            </div>
                        </div>
                       </div>

                        <div class="row">
                           @if(isset($products) && count($products) != 0)
                            @foreach($products as $key => $value) 
                            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                <div class="Featured-product">
                                    @if(isset($value->featured_product_img) && $value->featured_product_img)
                                        <a href="{{ route('view_products', ['id' => $value->id]) }}">
                                            <div class="Featured-product-img">
                                                <img src="{{ asset($product_path.'/'.$value->featured_product_img) }}" alt="">
                                            </div>
                                        </a>
                                    
                                    @else
                                        <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image) }}" alt="NImg">
                                    @endif
                                   
                                    
                                    <div class="Featured-product-info">
                                        <div class="product-title">
                                            <h6><a href="{{ route('view_products', ['id' => $value->id]) }}"> {{$value->product_title}}</a></h6>
                                            <span>
                                                <!-- <a href="#!"><i class="fa-solid fa-code-compare"></i></a> -->
                                                <a href="javascript:void(0)" class="gj_add2cart" data-cart-id="{{$value->id}}"><i class="fa-solid fa-bag-shopping"></i></a>
                                                <a href="" class="gj_wish_list" data-wish-id="{{$value->id}}"><i class="fa-regular fa-heart"></i></a>
                                            </span>
                                        </div>
                                        <p><?php echo $value->product_desc; ?></p>
                                        <p class="price"><strike>₹ {{$value->product_cost}} </strike>&ensp;₹ {{$value->discounted_price}}</p>
                                        <p class="stock" style="font-size: 13px;">In Stock: {{$value->onhand_qty}}</p>
    
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
                    <!-- <div class="pagination">
                        <ul>
                            <li><a href="#!"><i class="fa-solid fa-chevron-left"></i></a></li>
                            <li><a href="#!" class="page-active">1</a></li>
                            <li><a href="#!">2</a></li>
                            <li><a href="#!"><i class="fa-solid fa-chevron-right"></i></a></li>
                        </ul>
                    </div> -->
                    <!--<div class="loading-spinner">-->
                    <!--    <div class="spinner-border " role="status">-->
                    <!--        <span class="visually-hidden">Loading...</span>-->
                    <!--      </div>-->
                    <!--   </div>-->

                </div>
            </div>
            </form>
        </div>
    </section>

@endsection
@section('before_scripts')
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
<script>
$(document).ready(function () {
    // Price Range Filter
    $('.gj_product_sort').on('change', function () {
        const val = $(this).val();
        $('input[name="sort_filter"]').val(val); // update hidden input
        $('form.gj_all_prd_srh').submit(); // submit form
    });

    // Main Category Filter
    $('.gj_main_cat_filt').on('change', function () {
        const val = $(this).val();
        $('input[name="main_cat"]').val(val); // update hidden input
        $('form.gj_all_prd_srh').submit(); // submit form
    });

    // Show loader if needed
    $('form.gj_all_prd_srh').on('submit', function () {
        $('.loading-spinner').show();
    });
});
</script>



@endsection

