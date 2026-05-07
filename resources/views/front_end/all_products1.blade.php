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
@section('title', 'All Products')

<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/jquery-ui.css')}}">

@section('content')
<!-- PRODUCTS SECTION START -->
<div class="gj_catlist_sec">
    <!-- <section class="gj_clban_sec">
        <div class="inban inban3" style="background-image:url('{{asset('images/site_img/inban3.jpg')}}')">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                       <h4> Products  </h4> 
                    </div>
                </div>
            </div>  
        </div>  
    </section> -->

    <section class="gj_pro_lst_sec">
        <div class="ps-page--shop" id="shop-sidebar">
            <div class="ps-container">
                {{ Form::open(array('url' => 'all_products', 'method'=>'GET','class'=>'gj_all_prd_srh','files' => true)) }}
                    <div class="ps-layout--shop">
                        <div class="ps-layout__left">
                            <aside class="widget widget_shop">
                                <h4 class="widget-title">Categories</h4>
                                <ul class="ps-list--categories">
                                    @if(isset($category) && sizeof($category) != 0)
                                        @foreach($category as $fck => $fcv)
                                            @if(isset($fcv->sub) && sizeof($fcv->sub) != 0)
                                                <li class="current-menu-item menu-item-has-children"><a href="javascript:void(0);" class="gj_main_cat_filt" data-main_cat="{{$fcv->id}}">{{$fcv->main_cat_name}}</a><span class="sub-toggle <?php if(isset($_GET['main_cat']) && $_GET['main_cat'] == $fcv->id) { echo "active"; } ?>"><i class="fa fa-angle-down"></i></span>
                                                    <ul <?php if(isset($_GET['main_cat']) && $_GET['main_cat'] == $fcv->id) { echo 'style="display:block;"'; } ?> class="sub-menu">
                                                        @foreach($fcv->sub as $sck => $scv)
                                                            <li class="current-menu-item ">
                                                                <a href="javascript:void(0);" data-sub_cat="{{$scv->sub_cat_id}}" class="<?php if(isset($_GET['sub_cat']) && $_GET['sub_cat'] == $scv->sub_cat_id) { echo "gj_act_sub"; } ?> gj_sub_cat_filt">{{$scv->sub_cat_name}}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li class="current-menu-item ">
                                                    <a href="javascript:void(0);" class="gj_main_cat_filt" data-main_cat="{{$fcv->id}}">{{$fcv->main_cat_name}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>

                                <input type="hidden" name="main_cat" class="gj_main_cat_filter" value="{{((isset($data['main_cat']) && $data['main_cat']) ? $data['main_cat'] : '')}}">

                                <input type="hidden" name="sub_cat" class="gj_sub_cat_filter" value="{{((isset($data['sub_cat']) && $data['sub_cat']) ? $data['sub_cat'] : '')}}">

                                <input type="hidden" name="sub_sub_cat" class="gj_sub_sub_cat_filter" value="{{((isset($data['sub_sub_cat']) && $data['sub_sub_cat']) ? $data['sub_sub_cat'] : '')}}">
                            </aside>

                            <aside class="widget widget_shop">
                                <!--<h4 class="widget-title">BY BRANDS</h4>-->
                                <!-- <form class="ps-form--widget-search" action="" method="get"> -->
                                <!-- <div class="ps-form--widget-search">
                                    <input name="brand_name" class="form-control" type="text" placeholder="">
                                    <button type="button" class="gj_filt_brandz"><i class="icon-magnifier"></i></button>
                                </div> -->
                                <!-- </form> -->
                                <!--<figure class="ps-custom-scrollbar" data-height="250">-->
                                <!--    @if(isset($brands) && sizeof($brands) != 0)-->
                                <!--        @foreach($brands as $brdk => $brdv)-->
                                <!--            @if(isset($data['brand']) && sizeof($data['brand']) != 0)-->
                                <!--                @if (in_array($brdv->id, $data['brand']))-->
                                <!--                    <div class="ps-checkbox">-->
                                <!--                        <input class="form-control gj_filt_brand" checked type="checkbox" id="brand-{{$brdk+1}}" name="brand[]" value="{{$brdv->id}}">-->
                                <!--                        <label for="brand-{{$brdk+1}}">{{$brdv->brand_name}} ({{Products::Where('is_block', 1)->Where('brand', $brdv->id)->count()}})</label>-->
                                <!--                    </div>-->
                                <!--                @else-->
                                <!--                    <div class="ps-checkbox">-->
                                <!--                        <input class="form-control gj_filt_brand" type="checkbox" id="brand-{{$brdk+1}}" name="brand[]" value="{{$brdv->id}}">-->
                                <!--                        <label for="brand-{{$brdk+1}}">{{$brdv->brand_name}} ({{Products::Where('is_block', 1)->Where('brand', $brdv->id)->count()}})</label>-->
                                <!--                    </div>-->
                                <!--                @endif -->
                                <!--            @else-->
                                <!--                <div class="ps-checkbox">-->
                                <!--                    <input class="form-control gj_filt_brand" type="checkbox" id="brand-{{$brdk+1}}" name="brand[]" value="{{$brdv->id}}">-->
                                <!--                    <label for="brand-{{$brdk+1}}">{{$brdv->brand_name}} ({{Products::Where('is_block', 1)->Where('brand', $brdv->id)->count()}})</label>-->
                                <!--                </div>-->
                                <!--            @endif-->
                                <!--        @endforeach-->
                                <!--    @endif-->
                                <!--</figure>-->

                               <figure>
                                    <h4 class="widget-title">By Price</h4>
                                    <div id="nonlinear"></div>
                                    <p class="ps-slider__meta">Price:<span class="ps-slider__value"><i class="fa fa-inr"></i><span class="ps-slider__min"></span></span>-<span class="ps-slider__value"><i class="fa fa-inr"></i><span class="ps-slider__max"></span></span></p>

                                    <input type="hidden" name="min_pce" class="gj_min_pce_filter" value="{{((isset($data['min_pce']) && $data['min_pce']) ? $data['min_pce'] : '')}}">

                                    <input type="hidden" name="max_pce" class="gj_max_pce_filter" value="{{((isset($data['max_pce']) && $data['max_pce']) ? $data['max_pce'] : '')}}">
                                </figure>

                                <!--<figure>-->
                                <!--    <h4 class="widget-title">By Rating</h4>-->
                                <!--    @if(isset($data['review']) && sizeof($data['review']) != 0)-->
                                <!--        @if (in_array(5, $data['review']))-->
                                <!--            <div class="ps-checkbox">-->
                                <!--                <input class="form-control gj_filt_review" type="checkbox" id="review-1" name="review[]" value="5" checked>-->

                                <!--                <label for="review-1"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i></span><small>({{(isset($stars['review5']) && $stars['review5']) ? $stars['review5'] : '0'}})</small></label>-->
                                <!--            </div>-->
                                <!--        @else-->
                                <!--            <div class="ps-checkbox">-->
                                <!--                <input class="form-control gj_filt_review" type="checkbox" id="review-1" name="review[]" value="5">-->

                                <!--                <label for="review-1"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i></span><small>({{(isset($stars['review5']) && $stars['review5']) ? $stars['review5'] : '0'}})</small></label>-->
                                <!--            </div>-->
                                <!--        @endif-->

                                <!--        @if (in_array(4, $data['review']))-->
                                <!--            <div class="ps-checkbox">-->
                                <!--                <input class="form-control gj_filt_review" type="checkbox" id="review-2" name="review[]" value="4" checked>-->
                                <!--                <label for="review-2"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star"></i></span><small>({{(isset($stars['review4']) && $stars['review4']) ? $stars['review4'] : '0'}})</small></label>-->
                                <!--            </div>-->
                                <!--        @else-->
                                <!--            <div class="ps-checkbox">-->
                                <!--                <input class="form-control gj_filt_review" type="checkbox" id="review-2" name="review[]" value="4">-->
                                <!--                <label for="review-2"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star"></i></span><small>({{(isset($stars['review4']) && $stars['review4']) ? $stars['review4'] : '0'}})</small></label>-->
                                <!--            </div>-->
                                <!--        @endif-->

                                <!--        @if (in_array(3, $data['review']))-->
                                <!--            <div class="ps-checkbox">-->
                                <!--                <input class="form-control gj_filt_review" type="checkbox" id="review-3" name="review[]" value="3" checked>-->
                                <!--                <label for="review-3"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span><small>({{(isset($stars['review3']) && $stars['review3']) ? $stars['review3'] : '0'}})</small></label>-->
                                <!--            </div>-->
                                <!--        @else-->
                                <!--            <div class="ps-checkbox">-->
                                <!--                <input class="form-control gj_filt_review" type="checkbox" id="review-3" name="review[]" value="3">-->
                                <!--                <label for="review-3"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span><small>({{(isset($stars['review3']) && $stars['review3']) ? $stars['review3'] : '0'}})</small></label>-->
                                <!--            </div>-->
                                <!--        @endif-->

                                <!--        @if (in_array(2, $data['review']))-->
                                <!--            <div class="ps-checkbox">-->
                                <!--                <input class="form-control gj_filt_review" type="checkbox" id="review-4" name="review[]" value="2" checked>-->
                                <!--                <label for="review-4"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span><small>({{(isset($stars['review2']) && $stars['review2']) ? $stars['review2'] : '0'}})</small></label>-->
                                <!--            </div>-->
                                <!--        @else-->
                                <!--            <div class="ps-checkbox">-->
                                <!--                <input class="form-control gj_filt_review" type="checkbox" id="review-4" name="review[]" value="2">-->
                                <!--                <label for="review-4"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span><small>({{(isset($stars['review2']) && $stars['review2']) ? $stars['review2'] : '0'}})</small></label>-->
                                <!--            </div>-->
                                <!--        @endif-->

                                <!--        @if (in_array(1, $data['review']))-->
                                <!--            <div class="ps-checkbox">-->
                                <!--                <input class="form-control gj_filt_review" type="checkbox" id="review-5" name="review[]" value="1" checked>-->
                                <!--                <label for="review-5"><span><i class="fa fa-star rate"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span><small>({{(isset($stars['review1']) && $stars['review1']) ? $stars['review1'] : '0'}})</small></label>-->
                                <!--            </div>-->
                                <!--        @else-->
                                <!--            <div class="ps-checkbox">-->
                                <!--                <input class="form-control gj_filt_review" type="checkbox" id="review-5" name="review[]" value="1">-->
                                <!--                <label for="review-5"><span><i class="fa fa-star rate"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span><small>({{(isset($stars['review1']) && $stars['review1']) ? $stars['review1'] : '0'}})</small></label>-->
                                <!--            </div>-->
                                <!--        @endif-->
                                <!--    @else -->
                                <!--        <div class="ps-checkbox">-->
                                <!--            <input class="form-control gj_filt_review" type="checkbox" id="review-1" name="review[]" value="5">-->

                                <!--            <label for="review-1"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i></span><small>({{(isset($stars['review5']) && $stars['review5']) ? $stars['review5'] : '0'}})</small></label>-->
                                <!--        </div>-->

                                <!--        <div class="ps-checkbox">-->
                                <!--            <input class="form-control gj_filt_review" type="checkbox" id="review-2" name="review[]" value="4">-->
                                <!--            <label for="review-2"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star"></i></span><small>({{(isset($stars['review4']) && $stars['review4']) ? $stars['review4'] : '0'}})</small></label>-->
                                <!--        </div>-->

                                <!--        <div class="ps-checkbox">-->
                                <!--            <input class="form-control gj_filt_review" type="checkbox" id="review-3" name="review[]" value="3">-->
                                <!--            <label for="review-3"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span><small>({{(isset($stars['review3']) && $stars['review3']) ? $stars['review3'] : '0'}})</small></label>-->
                                <!--        </div>-->

                                <!--        <div class="ps-checkbox">-->
                                <!--            <input class="form-control gj_filt_review" type="checkbox" id="review-4" name="review[]" value="2">-->
                                <!--            <label for="review-4"><span><i class="fa fa-star rate"></i><i class="fa fa-star rate"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span><small>({{(isset($stars['review2']) && $stars['review2']) ? $stars['review2'] : '0'}})</small></label>-->
                                <!--        </div>-->

                                <!--        <div class="ps-checkbox">-->
                                <!--            <input class="form-control gj_filt_review" type="checkbox" id="review-5" name="review[]" value="1">-->
                                <!--            <label for="review-5"><span><i class="fa fa-star rate"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span><small>({{(isset($stars['review1']) && $stars['review1']) ? $stars['review1'] : '0'}})</small></label>-->
                                <!--        </div>-->
                                <!--    @endif-->
                                <!--</figure>-->

                                <!--<figure>-->
                                <!--    <h4 class="widget-title">By Color</h4>-->
                                <!--    <div class="ps-checkbox ps-checkbox--color color-1 ps-checkbox--inline">-->
                                <!--        <input class="form-control" type="checkbox" id="color-1" name="size">-->
                                <!--        <label for="color-1"></label>-->
                                <!--    </div>-->
                                <!--    <div class="ps-checkbox ps-checkbox--color color-2 ps-checkbox--inline">-->
                                <!--        <input class="form-control" type="checkbox" id="color-2" name="size">-->
                                <!--        <label for="color-2"></label>-->
                                <!--    </div>-->
                                <!--    <div class="ps-checkbox ps-checkbox--color color-3 ps-checkbox--inline">-->
                                <!--        <input class="form-control" type="checkbox" id="color-3" name="size">-->
                                <!--        <label for="color-3"></label>-->
                                <!--    </div>-->
                                <!--    <div class="ps-checkbox ps-checkbox--color color-4 ps-checkbox--inline">-->
                                <!--        <input class="form-control" type="checkbox" id="color-4" name="size">-->
                                <!--        <label for="color-4"></label>-->
                                <!--    </div>-->
                                <!--    <div class="ps-checkbox ps-checkbox--color color-5 ps-checkbox--inline">-->
                                <!--        <input class="form-control" type="checkbox" id="color-5" name="size">-->
                                <!--        <label for="color-5"></label>-->
                                <!--    </div>-->
                                <!--    <div class="ps-checkbox ps-checkbox--color color-6 ps-checkbox--inline">-->
                                <!--        <input class="form-control" type="checkbox" id="color-6" name="size">-->
                                <!--        <label for="color-6"></label>-->
                                <!--    </div>-->
                                <!--    <div class="ps-checkbox ps-checkbox--color color-7 ps-checkbox--inline">-->
                                <!--        <input class="form-control" type="checkbox" id="color-7" name="size">-->
                                <!--        <label for="color-7"></label>-->
                                <!--    </div>-->
                                <!--    <div class="ps-checkbox ps-checkbox--color color-8 ps-checkbox--inline">-->
                                <!--        <input class="form-control" type="checkbox" id="color-8" name="size">-->
                                <!--        <label for="color-8"></label>-->
                                <!--    </div>-->
                                <!--</figure>-->
                                <!--<figure class="sizes">-->
                                <!--    <h4 class="widget-title">BY SIZE</h4><a href="#">L</a><a href="#">M</a><a href="#">S</a><a href="#">XL</a>-->
                                <!--</figure>-->
                            </aside>
                        </div>

                        <div class="ps-layout__right">
                            <div class="ps-shopping ps-tab-root">
                                <div class="ps-shopping__header">
                                    <p><strong> {{((isset($all_products) && count($all_products) != 0) ? count($all_products) : 0)}}</strong> Products found</p>

                                    <a href="{{route('all_products')}}">Clear Filter</a>
                                
                                    <div class="ps-shopping__actions">                                 
                                        <div class="porlaqiopz ps-shopping__view">
                                            <p>Sort By</p>
                                            <ul class="ps-tab-list">
                                                 
                                                <li><a href="javascript:void(0);" class="gj_product_sort" data-sort="popular"> Popularity </a></li>
                                                <li><a href="javascript:void(0);" class="gj_product_sort" data-sort="l_h"> Price : Low to High </a></li>
                                                <li><a href="javascript:void(0);" class="gj_product_sort" data-sort="h_l"> Price : High to Low </a></li>
                                                <li><a href="javascript:void(0);" class="gj_product_sort" data-sort="latest"> Newest First </a></li> 
                                            </ul>

                                            <input type="hidden" name="sort_fitler" class="gj_sort_filter" value="{{((isset($data['sort_fitler']) && $data['sort_fitler']) ? $data['sort_fitler'] : '')}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="ps-tabs">
                                    <div class="ps-tab active" id="tab-1">
                                        <div class="ps-shopping-product prodlistz">
                                            <div class="row">
                                                @if(isset($all_products) && count($all_products) != 0)
                                                    @foreach($all_products as $key => $value)                                     
                                                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                                            <div class="ps-product">
                                                                <div class="ps-product__thumbnail">
                                                                    <a href="{{ route('view_products', ['id' => $value->id]) }}">
                                                                        @if(isset($value->featured_product_img) && $value->featured_product_img)
                                                                            <img src="{{ asset($product_path.'/'.$value->featured_product_img) }}" alt="PImg">
                                                                        @else
                                                                            <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image) }}" alt="NImg">
                                                                        @endif
                                                                    </a>
                                                                </div>

                                                                <div class="ps-product__container">
                                                                    <div class="ps-product__content">
                                                                        <a class="ps-product__title" href="{{ route('view_products', ['id' => $value->id]) }}">{{$value->product_title}}</a>

                                                                        <p class="ps-product__price sale"> <span class="money"> <i class="fa fa-inr"></i> </span>{{$value->discounted_price}} <del> <span class="money"> <i class="fa fa-inr"></i> </span>{{$value->original_price}} </del></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                    @endforeach
                                                @else
                                                    <p class="gj_no_data">Products Not Found</p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="loadinz">
                                            <!-- <img src="{{asset('images/site_img/loadz.gif')}}"> -->
                                        </div>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </section>
</div>
<!-- PRODUCTS SECTION END -->
@endsection

@section('before_scripts')
<script type="text/javascript">
    $(document).ready(function() {
        /*$("form.gj_all_product_form").on("change", "input:checkbox", function(){
            $("form.gj_all_product_form").submit();
        });

        $("form.gj_all_product_sort_form").on("change", "#SortBy", function(){
            $("form.gj_all_product_sort_form").submit();
        });*/
    });

    $(".gj_ftr_attr_vls").click(function(e){
        e.preventDefault();
        var att = "";
        if($(this).attr('data-id')) {
            att = $(this).attr('data-id');
        }

        $('.gj_fil_atts').val(att);

        $('.gj_p_filt').trigger('click');
    });

    $(".gj_id_fill_cat").click(function(e){
        e.preventDefault();
        var cat = "";
        if($(this).attr('data-id')) {
            cat = $(this).attr('data-id');
        }

        $('.gj_fil_cats').val(cat);

        $('.gj_p_filt').trigger('click');
    });

    $(".gj_SortBy").change(function(e){
        e.preventDefault();
        var sort = "";
        if($(this).val()) {
            sort = $(this).val();
        }

        $('.gj_fil_sort').val(sort);

        $('.gj_p_filt').trigger('click');
    });
</script>

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

<!-- Accordian Script Start -->
<script type="text/javascript">
    var acc = document.getElementsByClassName("block-title");
    var i;

    for (i = 0; i < acc.length; i++) {
      acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        $(this).closest('.block').find(".gj_ftr_attr").slideToggle();
        $(this).closest('.block').find(".widget-content").slideToggle();
        $(this).closest('.block').find(".block-content").slideToggle();
        $(this).closest('.block').find(".wrap").slideToggle();
      });
    }
</script>
<!-- Accordian Script End -->

<!-- Price Range Slider Script Start -->
<!-- <script src="{{ asset('frontend/js/jquery-ui.js')}}"></script>
<script>
    $( function() {
        var pa1 = 0;
        var pa2 = 0;
        @if(isset($filter_amount1))
            pa1 = <?php echo $filter_amount1; ?>;
        @endif

        @if(isset($filter_amount2))
            pa2 = <?php echo $filter_amount2; ?>;
        @endif

        pa1 = parseInt(pa1);
        pa2 = parseInt(pa2);

        $( "#slider-range" ).slider({
            range: true,
            min: 0,
            @if(isset($all_products) && sizeof($all_products) != 0)
                @if(isset($all_products->max_price) && ($all_products->max_price != 0))
                    max: <?php echo $all_products->max_price; ?>,
                @else
                    max: 500,
                @endif
            @else
                max: 500,
            @endif
            values: [ pa1, pa2 ],
            slide: function( event, ui ) {
                $( "#p_amount1" ).val(ui.values[ 0 ]);
                $( "#p_amount2" ).val(ui.values[ 1 ]);
            }
        });
        $( "#p_amount1" ).val($( "#slider-range" ).slider( "values", 0 ));
        $( "#p_amount2" ).val($( "#slider-range" ).slider( "values", 1 ));
    } );

    $('body').on('change','#p_amount1',function() {
        var p1 = 0;
        var p2 = 0;
        if($(this).val()) {
            p1 = parseInt($(this).val()); 
        } 

        if($('#p_amount2').val()) {
            p2 = parseInt($('#p_amount2').val()); 
            if(p2 <= p1) {
                p2 = p1;
            }
        }

        
        $( "#slider-range" ).slider({
            range: true,
            min: 0,
            @if(isset($all_products) && sizeof($all_products) != 0)
                @if(isset($all_products->max_price) && ($all_products->max_price != 0))
                    max: <?php echo $all_products->max_price; ?>,
                @else
                    max: 500,
                @endif
            @else
                max: 500,
            @endif
            values: [ p1, p2 ]
        });
        $( "#p_amount1" ).val($( "#slider-range" ).slider( "values", 0 ));
        $( "#p_amount2" ).val($( "#slider-range" ).slider( "values", 1 ));
    });

    $('body').on('change','#p_amount2',function() {
        var p1 = 0;
        var p2 = 0;

        if($('#p_amount1').val()) {
            p1 = parseInt($('#p_amount1').val()); 
        }
        if($(this).val()) {
            p2 = parseInt($(this).val()); 
            if(p2 <= p1) {
                p2 = p1;
            }
        } 
        
        $( "#slider-range" ).slider({
            range: true,
            min: 0,
            @if(isset($all_products) && sizeof($all_products) != 0)
                @if(isset($all_products->max_price) && ($all_products->max_price != 0))
                    max: <?php echo $all_products->max_price; ?>,
                @else
                    max: 500,
                @endif
            @else
                max: 500,
            @endif
            values: [ p1, p2 ]
        });
        $( "#p_amount1" ).val($( "#slider-range" ).slider( "values", 0 ));
        $( "#p_amount2" ).val($( "#slider-range" ).slider( "values", 1 ));
    });
</script> -->

<script type="text/javascript">
    function filterSlider() {
        var max_val = 1000;
        @if(isset($all_products) && sizeof($all_products) != 0)
            @if(isset($all_products->max_price) && ($all_products->max_price != 0))
                max_val = <?php echo $all_products->max_price; ?>;
            @endif
        @endif

        var min_pce = 0;
        var max_pce = max_val;

        @if((isset($data['min_pce']) && $data['min_pce']))
            min_pce = <?php echo $data['min_pce']; ?>;
        @endif

        @if((isset($data['max_pce']) && $data['max_pce']))
            max_pce = <?php echo $data['max_pce']; ?>;
        @endif

        var nonLinearSlider = document.getElementById('nonlinear');
        if (typeof nonLinearSlider != 'undefined' && nonLinearSlider != null) {
            noUiSlider.create(nonLinearSlider, {
                connect: true,
                behaviour: 'tap',
                start: [min_pce, max_pce],
                range: {
                    min: 0,
                    '10%': 100,
                    '20%': 200,
                    '30%': 300,
                    '40%': 400,
                    '50%': 500,
                    '60%': 600,
                    '70%': 700,
                    '80%': 800,
                    '90%': 900,
                    max: max_val,
                },
            });
            var nodes = [
                document.querySelector('.ps-slider__min'),
                document.querySelector('.ps-slider__max'),
            ];

            var ihv = [
                document.querySelector('.gj_min_pce_filter'),
                document.querySelector('.gj_max_pce_filter'),
            ];

            nonLinearSlider.noUiSlider.on('update', function(values, handle) {
                nodes[handle].innerHTML = Math.round(values[handle]);
                ihv[handle].value = Math.round(values[handle]);
            });
        }
    }

    filterSlider();
</script>

<!-- Price Range Slider Script End -->

<script type="text/javascript">
    if ($('.gj_sub_cat_filt').hasClass('gj_act_sub')){
        $('.gj_act_sub').closest('ul').show();  
        $('.gj_act_sub').closest('.sub-toggle').addClass('active');  
    }
</script>

<script type="text/javascript">
    $(".gj_product_sort").click(function(e){
        e.preventDefault();
        var srt = "";
        if($(this).attr('data-sort')) {
            srt = $(this).attr('data-sort');
        }

        if(srt) {
            $('.gj_sort_filter').val(srt);
            $('.gj_all_prd_srh').submit();
        }
    });

    $(".gj_main_cat_filt").click(function(e){
        e.preventDefault();
        var srt = "";
        if($(this).attr('data-main_cat')) {
            srt = $(this).attr('data-main_cat');
        }

        if(srt) {
            $('.gj_main_cat_filter').val(srt);
            $('.gj_all_prd_srh').submit();
        }
    });

    $(".gj_sub_cat_filt").click(function(e){
        e.preventDefault();
        var srt = "";
        if($(this).attr('data-sub_cat')) {
            srt = $(this).attr('data-sub_cat');
        }

        if(srt) {
            $('.gj_sub_cat_filter').val(srt);
            $('.gj_all_prd_srh').submit();
        }
    });

    // $(".gj_filt_brandz").click(function(e){
    $(".gj_filt_brand").click(function(e){
        e.preventDefault();
        if($('.gj_filt_brand').val()) {
            $('.gj_all_prd_srh').submit();
        }
    });

    $(".gj_filt_review").click(function(e){
        e.preventDefault();
        if($('.gj_filt_review').val()) {
            $('.gj_all_prd_srh').submit();
        }
    });

    var nonLinearSlider = document.getElementById('nonlinear');
    nonLinearSlider.noUiSlider.on('change', function () {
        $('.gj_all_prd_srh').submit();
    });
</script>
@endsection