<?php  
    $main_cat_path = "images/main_cat_image";
    $noimage = \DB::table('noimage_settings')->first();
    $noimage_path = 'images/noimage';
?>

@extends('layouts.frontend')
@section('title', 'Collection')
@section('content')

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

 <section class="section-padding pb-0 bg-light-gray">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- <div class="faq-icon-top">
                        <img src="assets/img/icon.png" alt="">
                    </div> -->
                    <div class="section-title column-title">
                        <h3>Shop by Collections</h3>
                        <p class="collections-desc">Our handcrafted jewels are created in limited quantities, ensuring their uniqueness and exclusivity. If in stock, they ship within two weeks.

                            If already sold, they will be lovingly crafted again and shipped within 3–5 weeks.</p>
                    </div>
                </div>
            </div>
         
            
        </div>
    </section>
    
    <section class="section-padding pb-2 sec-border">
        <div class="container">
            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="collection-title">
                        <h3>Traditional </h3>
                    </div>
                </div>
                @if(isset($hcat1) && count($hcat1) != 0)
                @foreach($hcat1 as $tpmk => $tpmv)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                    <div class="collection-container">
                        <a href="{{ route('category.products', strtolower(str_replace(' ', ' ', $tpmv->main_cat_name))) }}">
                            <div class="collection-img">
                                <img src="{{ asset($main_cat_path.'/'.$tpmv->main_cat_image)}}" alt="">
                            </div>
                        </a>
                        <div class="collection-bottom">
                            <h3><a href="{{ route('category.products',strtolower(str_replace(' ', ' ', $tpmv->main_cat_name))) }}">{{$tpmv->main_cat_name}}</a></h3>
                            <p>{{$tpmv->main_cat_desc}} </p>
                        </div>
                    </div>

                </div>
                    @endforeach
                @else
                   <div class="col-lg-12">
                        <h6 class="gj_no_data fw-bold text-center">Collections Not Found</h6>
                   </div>
                @endif
            </div>
            <!--<div class="row mb-3">-->
            <!--    <div class="col-lg-12">-->
            <!--        <div class="collection-title">-->
            <!--            <h3>Modern Contemporary</h3>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    <div class="col-lg-3 col-md-6 mb-3">-->
            <!--        <div class="collection-container">-->
            <!--            <a href="collection_list.html">-->
            <!--                <div class="collection-img">-->
            <!--                    <img src="assets/img/collections/1.webp" alt="">-->
            <!--                </div>-->
            <!--            </a>-->
            <!--            <div class="collection-bottom">-->
            <!--                <h3><a href="collection_list.html">Jasmine</a></h3>-->
            <!--                <p>Jewels inspired by the fragrant bloom weaving tales of romance,culture & divinity</p>-->
            <!--            </div>-->
            <!--        </div>-->

            <!--    </div>-->
            <!--    <div class="col-lg-3 col-md-6 mb-3">-->
            <!--        <div class="collection-container">-->
            <!--            <a href="collection_list.html">-->
            <!--                <div class="collection-img">-->
            <!--                    <img src="assets/img/collections/2.jpg" alt="">-->
            <!--                </div>-->
            <!--            </a>-->
            <!--            <div class="collection-bottom">-->
            <!--                <h3><a href="collection_list.html">Loving & Longing</a></h3>-->
            <!--                <p>An ode to kamadeva & allure of romantic birds</p>-->
            <!--            </div>-->
            <!--        </div>-->

            <!--    </div>-->
            <!--    <div class="col-lg-3 col-md-6 mb-3">-->
            <!--        <div class="collection-container">-->
            <!--            <a href="collection_list.html">-->
            <!--                <div class="collection-img">-->
            <!--                    <img src="assets/img/collections/3.avif" alt="">-->
            <!--                </div>-->
            <!--            </a>-->
            <!--            <div class="collection-bottom">-->
            <!--                <h3><a href="collection_list.html">Harvest</a></h3>-->
            <!--                <p>Jewels that celebrate the spirit of harvest around the globe</p>-->
            <!--            </div>-->
            <!--        </div>-->

            <!--    </div>-->
            <!--    <div class="col-lg-3 col-md-6 mb-3">-->
            <!--        <div class="collection-container">-->
            <!--            <a href="collection_list.html">-->
            <!--                <div class="collection-img">-->
            <!--                    <img src="assets/img/collections/4.png" alt="">-->
            <!--                </div>-->
            <!--            </a>-->
            <!--            <div class="collection-bottom">-->
            <!--                <h3><a href="collection_list.html">Beaten coin</a></h3>-->
            <!--                <p>Contemporary south indian kasai mala, symbolic of goddess lakshmi</p>-->
            <!--            </div>-->
            <!--        </div>-->

            <!--    </div>-->
            <!--</div>-->
        </div>
    </section>
    



@endsection