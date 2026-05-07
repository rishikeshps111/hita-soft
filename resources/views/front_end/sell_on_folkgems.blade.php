<?php 
$banner_path = 'images/banner_image';
$main_cat_path = 'images/main_cat_image';
$sub_cat_path = 'images/sub_cat_image';
$product_path = 'images/featured_products';
$noimage = \DB::table('noimage_settings')->first();
$noimage_path = 'images/noimage';
?>
@extends('layouts.frontend')
@section('title', 'Sell on Folkgems')

@section('content')

<!-- Pages SECTION START -->
<div class="gj_sofp_sec">
    <!-- Sell ON Page Det Start -->
    <section class="gj_sofp_det_sec">
        <div class="inban inban2" style="background-image:url('{{asset($sell->banner_image)}}')">
            @if(isset($sell->banner_caption) && $sell->banner_caption)
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                           <h4> {{$sell->banner_caption}}  </h4> 
                        </div>
                    </div>
                </div>  
            @endif  
        </div>

        <div class="whysell">
            <div class="container">
                <div class="row">                
                    <div class="col-md-12">
                        <div class="sellikz">
                            <h4> {{$sell->title}} </h4>
                            <hr>
                            <div class="gj_page_desc">
                                <?php echo $sell->desc; ?>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </section>
    <!-- Sell ON Page Det End -->

    <!-- Sell ON Register Start -->
    <section class="call-action overlay gj_sell_reg_sec" style="background-image:url('{{asset($sell->sell_bg)}}')">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-12">
                    <div class="call-inner">
                        <h2>{{$sell->sell_content1}} </h2>
                        <p>{{$sell->sell_content2}}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="button">
                        <a href="{{$sell->button_url}}" class="bizwheel-btn">{{$sell->button_text}} </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Sell ON Register END -->


    <!-- Why Sell Start -->
    <section class="gj_sell_why_sec">
        <div class="ps-section--vendor ps-vendor-about">
            <div class="container">
                <div class="ps-section__header">
                    <p>{{$sell->why_sell_hd}}</p>
                    <h4><?php echo nl2br($sell->why_sell_desc); ?></h4>
                </div>

                <div class="ps-section__content">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                            <div class="ps-block--icon-box-2">
                                <div class="ps-block__thumbnail">
                                    <img src="{{asset($sell->why_img_1)}}" alt=""></div>
                                <div class="ps-block__content">
                                    <h4> {{$sell->why_title_1}} </h4>
                                    <div class="ps-block__desc" data-mh="about-desc">
                                        <p><?php echo nl2br($sell->why_content_1); ?></p>
                                    </div><a href="{{$sell->why_link_1}}">{{$sell->why_link_text_1}}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                            <div class="ps-block--icon-box-2">
                                <div class="ps-block__thumbnail">
                                    <img src="{{asset($sell->why_img_2)}}" alt=""></div>
                                <div class="ps-block__content">
                                    <h4> {{$sell->why_title_2}} </h4>
                                    <div class="ps-block__desc" data-mh="about-desc">
                                        <p><?php echo $sell->why_content_2; ?></p>
                                    </div><a href="{{$sell->why_link_2}}">{{$sell->why_link_text_2}}</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 ">
                            <div class="ps-block--icon-box-2">
                                <div class="ps-block__thumbnail">
                                    <img src="{{asset($sell->why_img_3)}}" alt=""></div>
                                <div class="ps-block__content">
                                    <h4>{{$sell->why_title_3}}</h4>
                                    <div class="ps-block__desc" data-mh="about-desc">
                                        <p><?php echo $sell->why_content_3; ?></p>
                                    </div><a href="{{$sell->why_link_3}}">{{$sell->why_link_text_3}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Why Sell Section END -->

    <!-- How It Section Start -->
    <section class="gj_how_sec">
        <div class="ps-section--vendor ps-vendor-milestone">
            <div class="container">
                <div class="ps-section__header">
                    <p>{{$sell->how_it_hd}}</p>
                    <h4><?php echo nl2br($sell->how_it_desc); ?></h4>
                </div>
                <div class="ps-section__content">
                    <div class="ps-block--vendor-milestone">
                        <div class="ps-block__left">
                            <h4>{{$sell->how_title_1}}</h4>

                            <div class="gj_how_desc">
                                <?php echo $sell->how_content_1; ?>
                            </div>

                            <!-- <ul>
                                <li>Register your business for free and create a product catalogue. Get free training on how to run your online business</li>
                                <li>Our Folkgems Advisors will help you at every step and fully assist you in taking your business online</li>
                            </ul> -->
                        </div>
                        <div class="ps-block__right"><img src="{{asset($sell->how_img_1)}}" alt=""></div>
                        <div class="ps-block__number"><span>1</span></div>
                    </div>
                    <div class="ps-block--vendor-milestone reverse">
                        <div class="ps-block__left">
                            <h4>{{$sell->how_title_2}}</h4>
                            
                            <div class="gj_how_desc">
                                <?php echo $sell->how_content_2; ?>
                            </div>
                        </div>
                        <div class="ps-block__right"><img src="{{asset($sell->how_img_2)}}" alt=""></div>
                        <div class="ps-block__number"><span>2</span></div>
                    </div>
                    <div class="ps-block--vendor-milestone">
                        <div class="ps-block__left">
                            <h4>{{$sell->how_title_3}}</h4>
                            
                            <div class="gj_how_desc">
                                <?php echo $sell->how_content_3; ?>
                            </div>
                        </div>
                        <div class="ps-block__right"><img src="{{asset($sell->how_img_3)}}" alt=""></div>
                        <div class="ps-block__number"><span>3</span></div>
                    </div>
                    <div class="ps-block--vendor-milestone reverse">
                        <div class="ps-block__left">
                            <h4>{{$sell->how_title_4}}</h4>
                            
                            <div class="gj_how_desc">
                                <?php echo $sell->how_content_4; ?>
                            </div>
                        </div>
                        <div class="ps-block__right"><img src="{{asset($sell->how_img_4)}}" alt=""></div>
                        <div class="ps-block__number"><span>4</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- How It Section END -->

    <!-- Start Selling Section Start -->
    <section class="gj_srt_sell_sec">
        <div class="ps-vendor-banner bg--cover" data-background="{{asset($sell->start_sell_bg)}}">
            <div class="container">
                <h2><?php echo nl2br($sell->start_sell_content); ?></h2>
                <a class="ps-btn ps-btn--lg" href="{{$sell->start_sell_link}}">{{$sell->start_sell_link_text}}</a>
            </div>
        </div>
    </section>
    <!-- Start Selling Section END -->

    <!-- FAQ SECTION Start -->
    <section class="gj_faq_sec">
        @if(isset($faq) && sizeof($faq) != 0)
            <div class="delfixques">
                <div class="container">
                    <h3 class="text-center">  {{$sell->next_main_hd}} </h3>
            
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                @foreach($faq as $fk => $fv)
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="heading{{$fk}}">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$fk}}" aria-expanded="false" aria-controls="collapse{{$fk}}">
                                                {{$fv->title}}
                                                </a>
                                            </h4>
                                        </div>
                                    
                                        <div id="collapse{{$fk}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$fk}}">
                                            <div class="panel-body">
                                                <div class="gj_faq_desc"> <?php echo $fv->content; ?>  </div>
                                
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
    <!-- FAQ SECTION END -->
</div>
<!-- Pages SECTION END -->
@endsection

@section('before_scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
