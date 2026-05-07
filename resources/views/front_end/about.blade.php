<?php 
$banner_path = 'images/banner_image';
$main_cat_path = 'images/main_cat_image';
$sub_cat_path = 'images/sub_cat_image';
$product_path = 'images/featured_products';
$noimage = \DB::table('noimage_settings')->first();
$noimage_path = 'images/noimage';
?>
@extends('layouts.frontend')
@section('title', 'About Us')

@section('content')
<!-- Pages SECTION START -->

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

        <div class="about-container">


            <!--<div class="about-left-2">-->
            <!--    <video autoplay muted loop style>-->
            <!--        <source src="./assets/video/8.mp4" type="video/mp4">-->
            <!--    </video>-->
            <!--</div>-->
            <div class="about-right-2">
                <img src="{{asset($about->banner_image)}}" alt="">
                <div class="about-overlay">
                    <h3>{{$about->abo_title}}</h3>
                    <p>The Story Of Rukmini Fashions</p>
                </div>
            </div>

        </div>
    </section>
    <section class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="about-top">
                        <p><?php echo $about->abo_desc; ?></p>
                        <!--<i class="fa-solid fa-ring"></i>-->
                    </div>
                </div>
            </div>
        </div>

    </section>
    
    <section class="section-padding about-home">
    <div class="container">

        <div class="row">
            <div class="col-lg-5">
                <div class="about-home-left about-main-left">
                    <img src="{{asset($about->section1_image)}}" alt="">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="about-home-right">
                    <h3>About Rukmini Fashions</h3>
                   <p> <?php echo $about->sec1_desc; ?></p>
                </div>
                
            </div>
        </div>
       
    </div>
</section>
    <section class="section-padding ">
    <div class="container">

        <div class="row">
            
            <div class="col-lg-7">
                <div class="about-home-right about-main-right">
                    <h3>Our Promise</h3>
                   <p><?php echo $about->sec2_desc; ?></p>
                </div>
                
            </div>
            <div class="col-lg-5">
                <div class="about-home-left about-main-left">
                    <img src="{{asset($about->section2_image)}}" alt="">
                </div>
            </div>
        </div>
       
    </div>
</section>
    
    
     <section class="section-padding ">
         <div class="container">
              <div class="row">
            <div class="col-lg-12 py-1">
                <div class="section-title">
                    <h3>Why Choose Rukmini Fashions?</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="why-choose-container">
                        <span>01</span>
                        <h3>Curated Collections</h3>
                        <p>Handpicked styles to suit every mood.</p>

                    </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="why-choose-container">
                        <span>02</span>
                        <h3>Quality You Can Trust</h3>
                        <p>Strong focus on fabric, fit, and finish.</p>

                    </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="why-choose-container">
                        <span>03</span>
                        <h3>Designed for You</h3>
                        <p>Modern fashion with timeless appeal.</p>

                    </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="why-choose-container">
                        <span>04</span>
                        <h3>Customer-First Experience</h3>
                        <p>Thoughtful service from browsing to delivery.</p>

                    </div>
            </div>
        </div>
        
         </div>
     </section>
    <section class="section-padding dnone-about">
        <div class="container">
            <div class="row ">
                <div class="col-lg-5">
                    <div class="about-section-img">
                        <img src="{{asset($about->section3_image)}}" alt="">
                        <div class="about-section-overlay">
                            <div class="about-secton-title">
                                <h3>Decolonizing Design</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="about-section-info">
                        <img src="{{asset($about->section3_image2)}}" alt="">
                        <p><?php echo $about->sec3_desc; ?></p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="section-padding bg-light-gray dnone-about">
        <div class="container">
            <div class="row flex-reverse">


                <div class="col-lg-7">
                    <div class="about-section-info">
                        <img src="{{asset($about->section4_image2)}}" alt="">
                        <p><?php echo $about->sec4_desc; ?></p>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="about-section-img">
                        <img src="{{asset($about->section4_image)}}" alt="">
                        <div class="about-section-overlay">
                            <div class="about-secton-title">
                                <h3>Ethical Craftsmanship</h3>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="section-padding bg-section dnone-about">
        <div class="container">
            <div class="row ">

                <div class="col-lg-5">
                    <div class="about-section-img">
                        <img src="{{asset($about->section5_image)}}" alt="">
                        <div class="about-section-overlay">
                            <div class="about-secton-title">
                                <h3>Our Collections</h3>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-7">
                    <div class="about-section-info">
                        <img src="{{asset($about->section5_image2)}}" alt="">
                        <p><?php echo $about->sec5_desc; ?></p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="section-padding dnone-about">
        <div class="container">
            <div class="row flex-reverse">



                <div class="col-lg-7">
                    <div class="about-section-info">
                        <img src="{{asset($about->section6_image2)}}" alt="">
                        <p><?php echo $about->sec6_desc; ?></p>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="about-section-img">
                        <img src="{{asset($about->section6_image)}}" alt="">
                        <div class="about-section-overlay">
                            <div class="about-secton-title">
                                <h3>Living Legacy</h3>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
    <section class="section-padding bg-light-gray dnone-about">
        <div class="container">
            <div class="row ">
                <div class="col-lg-5">
                    <div class="about-section-img">
                        <img src="{{asset($about->section7_image)}}" alt="">
                        <div class="about-section-overlay">
                            <div class="about-secton-title">
                                <h3>Designer Note</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="about-section-info">
                        <img src="{{asset($about->section7_image2)}}" alt="">
                        <p><?php echo $about->sec7_desc; ?></p>
                    </div>
                </div>


            </div>
        </div>
    </section>

   

<!-- Pages SECTION END -->
@endsection

@section('before_scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
