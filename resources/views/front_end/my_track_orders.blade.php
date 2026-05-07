<?php  
    $product_path = 'images/featured_products';
    $noimage = \DB::table('noimage_settings')->first();
    $noimage_path = 'images/noimage';
?>
@extends('layouts.frontend')
@section('title', 'Track Orders')
<!--<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">-->
<!--<link rel="stylesheet" type="text/css" href="{{ asset('login/animate.css')}}">-->
<!--<link rel="stylesheet" type="text/css" href="{{ asset('login/main.css')}}">-->
<!--<link rel="stylesheet" href="{{ asset('frontend/css/theme-config.css')}}">-->
@section('content')
@if(Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
<style>
    .order_status_class{
        border: 2px solid red;
    }
  .track-container {
    /*width: fit-content;*/
    text-align: center;
    position: relative;
    background: #fff;
    padding: 20px 20px;
    border-radius: 10px;
    margin:auto;
    border:1px solid #ccc;
}

.track-timeline {
    display: flex;
    /*flex-direction: column;*/
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 0;
    position: relative;
    flex-wrap:wrap;
    padding-top:20px !important;
}

.track-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    margin-bottom: 20px;
  
}


.track-box {
      width: 92%;
      height:130px;
    padding: 12px;
    border: 2px solid #0000001f;
    background-color: white;
    text-align: center;
    font-size: 14px;
    font-weight: bold;
    border-radius: 25px;
    transition: 0.3s;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    padding-top:25px;
    position:relative;
}
.track-box::after{
   position: absolute;
    right: -31px;
    top: 40%;
    content: '>';
    min-width: 25px;
    min-height: 25px;
    background-color: #f2f2f2;
    border-radius: 50%;
    font-size: 15px;
    color: #222;
    border: 1px solid #ccc;
    display: flex
;
    justify-content: center;
    align-items: center;
    font-weight: 600;
    
}
.track-timeline .track-item:last-child .track-box::after{
    display:none;
}

.track-box h3{
    font-size:15px;
}
.track-active .track-box {
      background-color: #519e0063;
    color: white;
    border-color: #77cf1aeb;
    padding-top:12px;
}
.track-active .track-box::after{
     background-color: #62b808d4;
    color: white;
}
.track-active .track-box h3{
    color: #519e00;
    font-size: 15px;
    font-weight: 600;
    background: #fff;
    width: fit-content;
    margin: 12px auto;
    padding: 5px 20px;
    border-radius: 30px;
}
.canceled {
    background-color: #d9534f;
    color: white;
    border-color: #d9534f;
      padding-top:12px;
}

.canceled h3{
     color: #d9534f;
    font-size: 15px;
    font-weight: 600;
    background: #fff;
    width: fit-content;
    margin: 12px auto;
    padding: 5px 20px;
    border-radius: 30px;
}

.track-arrow {
   width: 0;
    height: 0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-top: 15px solid #519e0096;
    margin: 5px;
    margin-bottom: 20px;
    display:none;
}
.track-active .track-box p{
   font-size: 14px;
    margin-bottom: 5px;
    font-weight: 600;
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





@media screen and (max-width:1200px){
    .track-container ul li{
        width:23%;
    }
}
@media screen and (max-width:991px){
     .track-container ul li{
        width:31%;
    }
}
@media screen and (max-width:768px){
     .track-container ul li{
        width:100%;
    }
    .track-box::after{
   right: unset;
    left: 50%;
    top: 103%;
    rotate: 90deg;
    padding-bottom: 2px;}
}
@media screen and (max-width:568px){
    .track-box,.track-container ul li {
        width:100%;
    }
      .track-container{
          padding:15px;
      }
}

</style>
<div class="cover-head"></div>
<section class="section-padding bg-light">
           <div class="container-fluid ">
               <div class="row">
                   @php
                        $returnTab = request()->get('return_url', 'myOrders'); 
                    @endphp
                   <div class="col-lg-12">
                        <div class="back-to-order">
                                <a href='{{  route("my_account", ["tab" => $returnTab])}}' class="order-back-btn"><i class="fa-solid fa-arrow-left"></i></a>
                                
                            </div>
                   </div>
               </div>
          
            @if(isset($orders))
             @if (isset($orders['shipments']) && $orders['shipments'])
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table  class="table table-striped table-responsive">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <p> Shipment 1 of 1 </p>
                                                            <p class="gj_sh_det_p">
                                                                @if ($orders['shipments']->shiping_status)
                                                                    <b>{{$orders['shipments']->shiping_status}}</b>
                                                                @else
                                                                    <b>No Status</b>
                                                                @endif
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p> Courier</p>
                                                            <p class="gj_sh_det_p">
                                                                @if ($orders['shipments']->shiping_status)
                                                                    <b>{{$orders['shipments']->carrier}}</b>
                                                                @else
                                                                    <b>Carrier Not Availible</b>
                                                                @endif
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p> Tracking #</p>
                                                            <p class="gj_sh_det_p">
                                                                @if ($orders['shipments']->shiping_status)
                                                                    <b>{{$orders['shipments']->awb}}</b>
                                                                @else
                                                                    <b>------</b>
                                                                @endif
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
            <div class="row">
                
             <div class="col-lg-12">
                    <div class="track-container">
                          <div class="row justify-content-center">
                <div class="col-lg-8">
                     <h3>Track Order </h3>
                     <h6>Order Id : {{$orders->order_code}}</h6>
                      <h6>Tracking Id : <a href="https://www.indiapost.gov.in/_layouts/15/dop.portal.tracking/trackconsignment.aspx" target="_blank">{{$orders->tracking_id}}</a></h6>
                </div>
            </div>
                        <ul class="track-timeline">
                            <!-- Order Placed -->
                            <li class="track-item @if($orders->order_status >= 1) track-active @endif">
                                <div class="track-box">
                                    <h3>Order Placed</h3>
                                    <p>Date: {{ date('l, F d, Y', strtotime($orders->order_date)) }}</p>
                                </div>
                                <!--<div class="track-arrow"></div>-->
                            </li>
                
                            <!-- Order Dispatched -->
                            <li class="track-item @if($orders->order_status >= 2) track-active @endif">
                                <div class="track-arrow"></div>
                                <div class="track-box">
                                    <h3>Order Dispatched</h3>
                                    <p>Date:@if($orders->order_status >= 2) {{ ($orders->updated_at ? date('l, F d, Y', strtotime($orders->updated_at)) : '------') }} @else ------ @endif</p>
                                </div>
                            </li>
                
                            <!-- Order Delivered -->
                            <li class="track-item @if($orders->order_status >= 3) track-active @endif">
                                <div class="track-arrow"></div>
                                <div class="track-box">
                                     <h3>Order Delivered</h3>
                                    <p>Date: @if($orders->order_status >= 3){{ ($orders->delivery_date ? date('l, F d, Y', strtotime($orders->delivery_date)) : '------') }}@else ------ @endif</p>
                                </div>
                            </li>
                
                            <!-- Order Completed -->
                            <li class="track-item @if($orders->order_status >= 4) track-active @endif">
                                <div class="track-arrow"></div>
                                <div class="track-box">
                                    <h3>Order Completed</h3>
                                    <p>Date: @if($orders->order_status >= 4) {{ ($orders->updated_at ? date('l, F d, Y', strtotime($orders->updated_at)) : '------') }}@else ------ @endif</p>
                                </div>
                            </li>
                
                            <!-- Order Canceled -->
                            @if($returnTab != 'completedOrders')
                            <li class="track-item  @if($orders->order_status == 5) track-active @endif">
                                <div class="track-arrow"></div>
                                <div class="track-box canceled">
                                     <h3>Order Canceled</h3>
                                    <p>Date: {{ ($orders->cancel_date ? date('l, F d, Y', strtotime($orders->cancel_date)) : '------') }}</p>
                                </div>
                            </li>
                            @endif
                        </ul>
                
                    @if($returnTab != 'completedOrders' && $orders->order_status < 3)
                        <div class="track-bottom">
                            <p><strong>Estimated Delivery:</strong>  
                            @if($orders->delivery_date)
                                {{ ($orders->delivery_date ? date('l, F d, Y', strtotime($orders->delivery_date)) : '------') }}
                            @else
                               ------
                               @endif
                               </p>
                        </div>
                        @endif
                    </div>
                    
                </div>

            @else
                <p class="gj_no_data">Orders is Empty</p>
            @endif
           </div>
        </section>
@endsection

@section('before_scripts')
<script>     
    $(document).ready(function(){
        $('.vertical-tab .nav-tabs li a[href="#Section4"]').tab('show');
        $('.vertical-tab .nav-tabs li').removeClass('active'); 
        $('.vertical-tab .nav-tabs li a[href="#Section4"]').parent().addClass('active');

        $('.vertical-tab .nav-tabs li').click(function(){ 
            $('.vertical-tab .nav-tabs li').removeClass('active'); 
            $(this).addClass('active'); 
        });

        $('#logout').click(function(){ 
            window.location.href = "{{ route('logout') }}";
        });

        $('.buzin').click(function(){ 
            $(".buzzacc").toggle(); 
        });

        var sum = 0;
        $(".gj_tk_up").each(function() {
            var value = $(this).html();
            if(!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        sum = (sum).toFixed(2);
        $('.gj_tk_st').html(sum);
    });
</script>

<script>
    $(document).ready(function() { 
        $('p.alert').delay(5000).slideUp(500); 
        $("#country").select2();
    });
</script>

<script>     
    $(document).ready(function() {
        <?php if(isset($_GET['tab_id']) && $_GET['tab_id'] == 'Section4') { ?>
            $('.vertical-tab .nav-tabs li a[href="#Section4"]').tab('show');
            $('.vertical-tab .nav-tabs li').removeClass('active'); 
            $('.vertical-tab .nav-tabs li a[href="#Section4"]').parent().addClass('active');
        <?php } ?>

        $('.vertical-tab .nav-tabs li').click(function(){ 
            $('.vertical-tab .nav-tabs li').removeClass('active'); 
            $(this).addClass('active'); 
        });

        $('#logout').click(function(){ 
            window.location.href = "{{ route('logout') }}";
        });

        $('.buzin').click(function(){ 
            $(".buzzacc").toggle(); 
        })

    });
</script>

<script>
    // $('body').on('click','.gj_myacc_pge ul.pagination li',function() {
    //     $('a[href="#Section4"]').trigger();                                                                      
    // });
    function getUrlVars() {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }

    $(document).ready(function() { 
        $('p.alert').delay(5000).slideUp(800); 
        $("#country").select2();
        $("#state").select2();
        $("#city").select2();

        var trgr = false;
        var url = document.location.href;
        var res = url.toString().split('#');

        if(res[1]) {
            var trgr = res[1];
        }

        if(trgr) {
            $('.vertical-tab .nav-tabs li a[href="#' + trgr + '"]').tab('show');
            $('.vertical-tab .nav-tabs li').removeClass('active'); 
            $('.vertical-tab .nav-tabs li a[href="#' + trgr + '"]').parent().addClass('active');
        }

        var country = $('#country').select2('val');
      

        if(city) {
            city = city;          
        } else {
            city = 0;
        }

        // if(country) {
        //     $.ajax({
        //         type: 'post',
        //         url: '{{url('/select_state')}}',
        //         data: {country: country, state: state, type: 'state'},
        //         success: function(data){
        //             if(data){
        //                 $("#state").html(data);
        //                 $("#state").removeAttr("disabled");

        //                 var st = $('#state').val();
        //                 if(st) {
        //                     $.ajax({
        //                         type: 'post',
        //                         url: '{{url('/select_city')}}',
        //                         data: {st: st, city: city, type: 'city'},
        //                         success: function(data){
        //                             if(data){
        //                                 $("#city").html(data);
        //                                 $("#city").removeAttr("disabled");
        //                             } else {
        //                                 $.confirm({
        //                                     title: '',
        //                                     content: 'Please Select State!',
        //                                     icon: 'fa fa-exclamation',
        //                                     theme: 'modern',
        //                                     closeIcon: true,
        //                                     animation: 'scale',
        //                                     type: 'purple',
        //                                     buttons: {
        //                                         Ok: function(){
        //                                         }
        //                                     }
        //                                 });
        //                                 $("#city").prop("disabled", true);
        //                             }
        //                         }
        //                     });
        //                 } else {
        //                     $.confirm({
        //                         title: '',
        //                         content: 'Please Select State!',
        //                         icon: 'fa fa-exclamation',
        //                         theme: 'modern',
        //                         closeIcon: true,
        //                         animation: 'scale',
        //                         type: 'purple',
        //                         buttons: {
        //                             Ok: function(){
        //                             }
        //                         }
        //                     });
        //                 }
        //             } else {
        //                 $.confirm({
        //                     title: '',
        //                     content: 'Please Select Country!',
        //                     icon: 'fa fa-exclamation',
        //                     theme: 'modern',
        //                     closeIcon: true,
        //                     animation: 'scale',
        //                     type: 'purple',
        //                     buttons: {
        //                         Ok: function(){
        //                         }
        //                     }
        //                 });
        //                 $("#state").prop("disabled", true);
        //                 $("#city").prop("disabled", true);
        //             }
        //         }
        //     });
        // } else {
        //     $.confirm({
        //         title: '',
        //         content: 'Please Select Country!',
        //         icon: 'fa fa-exclamation',
        //         theme: 'modern',
        //         closeIcon: true,
        //         animation: 'scale',
        //         type: 'purple',
        //         buttons: {
        //             Ok: function(){
        //             }
        //         }
        //     });
        // }

       

        $("#img_addButton").click(function () {
            var newTextBoxDiv = $(document.createElement('tr')).attr("id", 'gj_tr_m_doc_' + cnt);
            newTextBoxDiv.after().html('<td><input class="form-control gj_d_name" placeholder="Enter Product Name" name="d_name[]" type="text" id="d_name_' + cnt + '"></td><td><input type="file" name="d_image[]" id="d_image_' + cnt + '" class="gj_d_image form-control"></td><td><button type="button" id="img_removeButton_' + cnt + '" class="gj_m_doc_rem"><i class="fa fa-trash"></i></button></td>');
            newTextBoxDiv.appendTo("#gj_m_doc_bdy");
            cnt++;
        });

        $('body').on('click','.gj_m_doc_rem',function() {
            if(cnt==1){
                $.confirm({
                    title: '',
                    content: 'No more textbox to remove!',
                    icon: 'fa fa-ban',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'red',
                    buttons: {
                        Ok: function(){
                        }
                    }
                });
                return false;
            }   
        
            cnt--;
            $(this).closest('tr').remove();
        });
    });

    $('#country').on('change',function() {
        var country = $(this).val();
        if(country) {
            $.ajax({
                type: 'post',
                url: '{{url('/select_state')}}',
                data: {country: country, type: 'state'},
                success: function(data){
                    if(data){
                        $("#state").html(data);
                        $("#state").removeAttr("disabled");
                    } else {
                        $.confirm({
                            title: '',
                            content: 'Please Select Country!',
                            icon: 'fa fa-ban',
                            theme: 'modern',
                            closeIcon: true,
                            animation: 'scale',
                            type: 'red',
                            buttons: {
                                Ok: function(){
                                }
                            }
                        });
                        $("#state").prop("disabled", true);
                        $("#city").prop("disabled", true);
                    }
                }
            });
        } else {
            $.confirm({
                title: '',
                content: 'Please Select Country!',
                icon: 'fa fa-ban',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'red',
                buttons: {
                    Ok: function(){
                    }
                }
            });
        }
    });

    $('#state').on('change',function() {
        var st = $(this).val();
        if(st) {
            $.ajax({
                type: 'post',
                url: '{{url('/select_city')}}',
                data: {st: st, type: 'city'},
                success: function(data){
                    if(data){
                        $("#city").html(data);
                        $("#city").removeAttr("disabled");
                    } else {
                        $.confirm({
                            title: '',
                            content: 'Please Select State!',
                            icon: 'fa fa-ban',
                            theme: 'modern',
                            closeIcon: true,
                            animation: 'scale',
                            type: 'red',
                            buttons: {
                                Ok: function(){
                                }
                            }
                        });
                        $("#city").prop("disabled", true);
                    }
                }
            });
        } else {
            $.confirm({
                title: '',
                content: 'Please Select State!',
                icon: 'fa fa-ban',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'red',
                buttons: {
                    Ok: function(){
                    }
                }
            });
        }
    });
</script>
@endsection