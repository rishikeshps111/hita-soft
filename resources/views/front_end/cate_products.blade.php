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

    .product-fade-wrap img {
   height:200px !important;
    
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

</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.css">
@section('content')
<!-- PRODUCTS SECTION START -->
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
                        <h3>{{ $category->main_cat_name ?? 'Products' }}</h3>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    <section class="section-padding pt-4 pb-2 sec-border">
        <div class="container">
             <div class="row">
                 <div class="col-lg-3 mb-3">
                      <form action="{{route('category.products', strtolower(str_replace(' ', '-', $category->main_cat_name)))}}" class="gj_all_prd_srh produlct-filter-left" method="GET">
                          <div class="filter-sidebar ">
                                
                                    <h5 class="filter-title">Price</h5>
                                
                                    <div class="price-range-values">
                                        ₹<span id="min-price">0</span> - ₹<span id="max-price">90000</span>
                                    </div>
                                
                                    <div id="price-slider"></div>
                                
                                    <input type="hidden" name="min_price" id="min_price" value="{{ request('min_price') }}">
                                    <input type="hidden" name="max_price" id="max_price" value="{{ request('max_price') }}">
                                
                    
                               {{-- <input type="hidden" name="main_cat" class="gj_main_cat_filter"
                                    value="{{ request()->get('main_cat') }}"> --}}
                    
                            </div>
                          
                        </form>
                     
                     
                </div>
            
                <div class="col-lg-9">
                    <div class="product-main-container">
                       

                        <div class="row">
                        @if(isset($products) && count($products) != 0)
                            @foreach($products as $key => $value) 
                            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
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
                                            <p class="price">
                                                <strike>₹ {{ $value->original_price }}</strike>&ensp;₹ {{ $value->discounted_price }}
                                            </p>
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
                                <h6 class="gj_no_data fw-bold text-center">Products Not Found</h6>
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
                   <!-- <div class="spinner-border " role="status">-->
                   <!--     <span class="visually-hidden">Loading...</span>-->
                   <!--   </div>-->
                   <!--</div>-->

                </div>
           
        </div>
        
            </div>
    </section>




 
<!-- PRODUCTS SECTION END -->
@endsection

@section('before_scripts')

<script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.js"></script>
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
   $(document).ready(function () {
    // Sort dropdown functionality
    $(".gj_product_sort").change(function () {
        var srt = $(this).val(); // Get selected sort value
        $(".gj_sort_filter").val(srt); // Update hidden input
        $(".gj_all_prd_srh").submit(); // Submit form
    });

    // Main category filter
    $(".gj_main_cat_filt").click(function (e) {
        e.preventDefault();
        var srt = $(this).attr('data-main_cat');
        if (srt) {
            $(".gj_main_cat_filter").val(srt);
            $(".gj_all_prd_srh").submit();
        }
    });

    // Subcategory filter
    $(".gj_sub_cat_filt").change(function () {
        var subCat = $(this).val(); // Get selected subcategory ID
        $(".gj_sub_cat_filter").val(subCat); // Update hidden input
        $(".gj_all_prd_srh").submit(); // Submit form
    });

    // Brand filter
    $(".gj_filt_brand").change(function () {
        if ($(this).val()) {
            $(".gj_all_prd_srh").submit();
        }
    });

    // Review filter
    $(".gj_filt_review").change(function () {
        if ($(this).val()) {
            $(".gj_all_prd_srh").submit();
        }
    });

    // Price range filter using noUiSlider
    var nonLinearSlider = document.getElementById("nonlinear");
    if (nonLinearSlider && nonLinearSlider.noUiSlider) {
        nonLinearSlider.noUiSlider.on("change", function () {
            $(".gj_all_prd_srh").submit();
        });
    }
});

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
</script>


@endsection