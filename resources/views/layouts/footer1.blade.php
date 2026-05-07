<?php 
    // $general = \DB::table('general_settings')->first();
    // $email = \DB::table('email_settings')->first();
    // $social = \DB::table('social_media_settings')->first();
    $widget = \DB::table('widgets')->first();
    $f_cat = \DB::table('category_management_settings')->Where('is_block',1)->OrderBy('priority', 'ASC')->get();
?>

<div class="gj_home_footer_cnt">
    <div class="ps-site-features">                
        <div class="ps-block--site-features">
            <div class="ps-block__item">
                <div class="ps-block__left"><i class="fa {{(($widget && $widget->first_icon) ? $widget->first_icon : 'fa-rocket')}}"></i></div>
                <div class="ps-block__right">
                    <h4>{{(($widget && $widget->first_title) ? $widget->first_title : 'Free Delivery')}}</h4>
                    <p>{{(($widget && $widget->first_content) ? $widget->first_content : 'For all oders over  <span class="money"> <i class="fa fa-inr"></i> </span> 99')}}</p>
                </div>
            </div>
            <div class="ps-block__item">
                <div class="ps-block__left"><i class="fa {{(($widget && $widget->second_icon) ? $widget->second_icon : 'fa-refresh')}}"></i></div>
                <div class="ps-block__right">
                    <h4>{{(($widget && $widget->second_title) ? $widget->second_title : '90 Days Return')}}</h4>
                    <p>{{(($widget && $widget->second_content) ? $widget->second_content : 'If goods have problems')}}</p>
                </div>
            </div>
            <div class="ps-block__item">
                <div class="ps-block__left"><i class="fa {{(($widget && $widget->third_icon) ? $widget->third_icon : 'fa-credit-card')}}"></i></div>
                <div class="ps-block__right">
                    <h4>{{(($widget && $widget->third_title) ? $widget->third_title : 'Secure Payment')}}</h4>
                    <p>{{(($widget && $widget->third_content) ? $widget->third_content : '100% secure payment')}}</p>
                </div>
            </div>
            <div class="ps-block__item">
                <div class="ps-block__left"><i class="fa {{(($widget && $widget->fourth_icon) ? $widget->fourth_icon : 'fa-comments-o')}}"></i></div>
                <div class="ps-block__right">
                    <h4>{{(($widget && $widget->fourth_title) ? $widget->fourth_title : '24/7 Support')}}</h4>
                    <p>{{(($widget && $widget->fourth_content) ? $widget->fourth_content : 'Dedicated support')}}</p>
                </div>
            </div>
            <div class="ps-block__item">
                <div class="ps-block__left"><i class="fa {{(($widget && $widget->fifth_icon) ? $widget->fifth_icon : 'fa-gift')}}"></i></div>
                <div class="ps-block__right">
                    <h4>{{(($widget && $widget->fifth_title) ? $widget->fifth_title : 'Gift Service')}}</h4>
                    <p>{{(($widget && $widget->fifth_content) ? $widget->fifth_content : 'Support gift service')}}</p>
                </div>
            </div>
        </div>                
    </div>

    <div class="ps-vendor-banner homelizven bg--cover" @if($widget && $widget->start_sell_bg) style="background: url('{{ asset($widget->start_sell_bg)}}');" @else style="background: url('ui_assets/img/vendor.jpg');" @endif>
        <div class="row">
            <div class="col-md-6 col-lg-6">                        
                <h4>{{(($widget && $widget->start_sell_hd_1) ? $widget->start_sell_hd_1 : 'Start sell with us')}}</h4>
        
                <a class="ps-btn ps-btn--lg" href="{{(($widget && $widget->start_sell_button_link) ? $widget->start_sell_button_link : route('seller_signup'))}}">{{(($widget && $widget->start_sell_button) ? $widget->start_sell_button : 'Sell on Folkgems')}}</a>                    
            </div>
        
            <div class="col-md-6 col-lg-6">
            
                <!--<h4>{{(($widget && $widget->start_sell_hd_2) ? $widget->start_sell_hd_2 : 'Download Folkgems App!')}}</h4> -->
        
                <!--<p class="download-link">-->
                <!--    <a href="{{(($widget && $widget->app_link_1) ? $widget->app_link_1 : '#')}}">-->
                <!--        @if($widget && $widget->app_img_1)-->
                <!--            <img src="{{ asset($widget->app_img_1)}}" alt="">-->
                <!--        @else-->
                <!--            <img src="{{ asset('ui_assets/img/google-play.png')}}" alt="">-->
                <!--        @endif-->
                <!--    </a>-->

                <!--    <a href="{{(($widget && $widget->app_link_2) ? $widget->app_link_2 : '#')}}">-->
                <!--        @if($widget && $widget->app_img_2)-->
                <!--            <img src="{{ asset($widget->app_img_2)}}" alt="">-->
                <!--        @else-->
                <!--            <img src="{{ asset('ui_assets/img/app-store.png')}}" alt="">-->
                <!--        @endif-->
                <!--    </a>-->
                <!--</p>-->
            </div>                     
        </div>     
    </div> 

    <!--<div class="ps-footer__links">-->
    <!--    @if(isset($f_cat) && sizeof($f_cat) != 0)-->
    <!--        @foreach($f_cat as $f_key => $f_val)-->
    <!--            <?php $s_cat = \DB::table('sub_category_management_settings')->Where('main_cat_name', $f_val->id)->Where('is_block',1)->OrderBy('sub_cat_name', 'ASC')->get(); ?>-->
    <!--            @if(isset($s_cat) && sizeof($s_cat) != 0)-->
    <!--                <p>-->
    <!--                    <strong>{{$f_val->main_cat_name}}:</strong>-->
                    
    <!--                    @foreach($s_cat as $s_key => $s_val)-->
    <!--                        <a href="{{ route('sub_sub_cat_lists', ['sub_cat' => $s_val->sub_cat_id]) }}">{{$s_val->sub_cat_name}}</a>-->
    <!--                    @endforeach-->
    <!--                </p>-->
    <!--            @endif-->
    <!--        @endforeach-->
    <!--    @endif-->
    <!--</div>-->
</div>