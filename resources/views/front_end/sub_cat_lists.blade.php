<?php 
$banner_path = 'images/banner_image';
$main_cat_path = 'images/main_cat_image';
$sub_cat_path = 'images/sub_cat_image';
$product_path = 'images/featured_products';
$noimage = \DB::table('noimage_settings')->first();
$noimage_path = 'images/noimage';
?>
@extends('layouts.frontend')
@section('title', 'Categories')

@section('content')
<!-- Pages SECTION START -->
<div class="pages-baner" style="background-image: linear-gradient(176deg, rgba(0, 0, 0, 0.364670868347339) 0%, rgba(0, 0, 0, 0.3702731092436975) 100%), url('{{asset('ui_assets/images/baner/5.jpg')}}');">
   <div class="container">
    <div class="row jc_center">
        <div class="col-lg-7">
            <div class="pages-title">
                <h3>Sub Categories</h3>
            </div>

        </div>
    </div>
   </div>
</div>
    
    <section class="gj_allcatlist_sec">
        <div class="catliztin">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ps-shopping ps-tab-root catelioz" data-select2-id="8">
                            <div class="ps-shopping__header">
                                <form class="ps-form--widget-search mikwofg" action="{{route('sub_cat_lists', $main_cat)}}" method="get">
                                    <input class="form-control" name="cat_srh" type="text" placeholder="Search by Categories..." value="{{((isset($_GET['cat_srh']) && $_GET['cat_srh']) ? $_GET['cat_srh'] : '')}}">
                                 
                                    <button><i class="icon-magnifier"></i></button>
                                </form>
                        
                        
                                <div class="ps-shopping__actions milkwoapz">
                                    <select class="ps-select select2-hidden-accessible" data-placeholder="Sort Items" data-select2-id="4" tabindex="-1" aria-hidden="true" onchange="window.location.href=this.value">
                                        <option <?php if(isset($_GET['filter']) && $_GET['filter'] == "latest") { echo "selected"; } ?> value="{{route('sub_cat_lists', $main_cat)}}?{{((isset($_GET['cat_srh']) && $_GET['cat_srh']) ? 'cat_srh='.$_GET['cat_srh'].'&' : '')}}filter=latest">Sort by latest</option>
                                        <option <?php if(isset($_GET['filter']) && $_GET['filter'] == "popular") { echo "selected"; } ?> value="{{route('sub_cat_lists', $main_cat)}}?{{((isset($_GET['cat_srh']) && $_GET['cat_srh']) ? 'cat_srh='.$_GET['cat_srh'].'&' : '')}}filter=popular">Sort by popularity</option>
                                        <option <?php if(isset($_GET['filter']) && $_GET['filter'] == "rating") { echo "selected"; } ?> value="{{route('sub_cat_lists', $main_cat)}}?{{((isset($_GET['cat_srh']) && $_GET['cat_srh']) ? 'cat_srh='.$_GET['cat_srh'].'&' : '')}}filter=rating">Sort by average rating</option>
                                        <option <?php if(isset($_GET['filter']) && $_GET['filter'] == "low_high") { echo "selected"; } ?> value="{{route('sub_cat_lists', $main_cat)}}?{{((isset($_GET['cat_srh']) && $_GET['cat_srh']) ? 'cat_srh='.$_GET['cat_srh'].'&' : '')}}filter=low_high">Sort by price: low to high</option>
                                        <option <?php if(isset($_GET['filter']) && $_GET['filter'] == "high_low") { echo "selected"; } ?> value="{{route('sub_cat_lists', $main_cat)}}?{{((isset($_GET['cat_srh']) && $_GET['cat_srh']) ? 'cat_srh='.$_GET['cat_srh'].'&' : '')}}filter=high_low">Sort by price: high to low</option>
                                    </select>                                   
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="ps-top-categories cateliqiop">
                            <div class="ps-section__header">
                                <div class="ps-block--countdown-deal">
                                    <div class="ps-block__left">
                                        <h3><a href="{{route('cat_lists')}}"> Top categories  </a> </h3>
                                    </div>
                                </div> 
                            </div>
                        
                            <div class="row">
                                @if(isset($category) && sizeof($category) != 0)
                                    @foreach($category as $ckey => $cval)
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 ">
                                            <div class="card"> 
                                                <div class="item-card"> 
                                                    <div class="item-card-desc">
                                                        <a href="{{route('all_products')}}?sub_cat={{$cval->sub_cat_id}}"></a> 
                                                            <div class="item-card-img">
                                                                <img src="{{ asset($sub_cat_path.'/'.$cval->sub_cat_image) }}" alt="img" class="br-tr-7 br-tl-7">
                                                            </div>
                                                            
                                                            <div class="item-card-text">
                                                                <h4 class="mb-2">{{$cval->sub_cat_name}}</h4>
                                                            </div>
                                                         
                                                    </div>
                                                </div> 
                                            </div>     
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>       
                    </div>
                </div>
            </div>    
        </div>
    </section>
<!--</div>-->
<!-- Pages SECTION END -->
@endsection
