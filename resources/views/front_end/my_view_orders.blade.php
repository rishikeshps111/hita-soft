<?php  
    $product_path = 'images/featured_products';
    $noimage = \DB::table('noimage_settings')->first();
    $noimage_path = 'images/noimage';
?>
@extends('layouts.frontend')
@section('title', 'View Orders')
<!--<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">-->
<!--<link rel="stylesheet" type="text/css" href="{{ asset('login/animate.css')}}">-->
<!--<link rel="stylesheet" type="text/css" href="{{ asset('login/main.css')}}">-->
<!--<link rel="stylesheet" href="{{ asset('frontend/css/theme-config.css')}}">-->
@section('content')
@if(Session::has('message'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
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
.order-table tr th{
    color: #fff;
    background-color: #ad8715;
        border-bottom: 1px solid #dfd7d7 !important;
}
@media screen and (max-width:567px){
   .order-table tr td{
        min-width:180px;
    }
}

</style>
<div class="cover-head"></div>

 <section class="section-padding bg-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="view-order-container">
                        @php
                            $returnTab = request()->get('return_url', 'myOrders'); 
                        @endphp

                        <h3>View Order
                            <div class="back-to-order">
                                <a href="{{route('my_account', ['tab' => $returnTab])}}"><i class="fa-solid fa-arrow-left"></i></a>
                            </div>
                        </h3>
                        @if(isset($orders))
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="view-order-details-top">
                                    <p>Contact Person : <span>{{$orders->contact_person}}</span></p>
                                    <p>Contact No : <span>{{$orders->contact_no}}</span></p>
                                </div>

                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="view-order-details">
                                    <div class="view-order-info">
                                        <ul>
                                            <li>Total Items : <span>{{$orders->total_items}}</span></li>
                                            <li>Order Code : <span>{{$orders->order_code}}</span></li>
                                            <li>Order Status : 
                                                <span>
                                                @if($orders->is_deleted)
                                                            Order Deleted
                                                            
                                                 @else
                                                    @if($orders->order_status == 0)
                                                        ------
                                            
                                                    @elseif($orders->order_status == 1)
                                                        Order Placed
                                            
                                                    @elseif($orders->order_status == 2)
                                                        Order Dispatched
                                            
                                                    @elseif($orders->order_status == 3)
                                                        Order Delivered
                                            
                                                    @elseif($orders->order_status == 4)
                                                        Order Complete
                                            
                                                    @elseif($orders->order_status == 5)
                                                       
                                                            Order Cancelled
                                                      
                                            
                                                    @else
                                                        ------
                                                    @endif
                                                @endif
                                                </span>
                                            </li>

                                            <li>Order Date : <span>{{ date('d-m-Y', strtotime($orders->order_date)) }}</span></li>
                                           
                                        </ul>

                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <div class="view-order-details">
                                    <div class="view-order-info">
                                        <ul>
                                            <li>Estimate Delivery Date : <span>
                                            @if($orders->delivery_date)
                                                    {{ date('d-m-Y', strtotime($orders->delivery_date)) }}
                                                @else
                                                    {{'------'}}
                                                @endif
                                            </span></li>
                                            <li>Delivery Status : <span>
                                                @if($orders->order_status == 0)
                                                    {{'------'}}
                                                @elseif ($orders->order_status == 2)
                                                    {{'In Transit'}}
                                                @elseif ($orders->order_status == 3)
                                                    {{'Delivered'}}
                                                @elseif ($orders->order_status == 4)
                                                    {{'Success'}}
                                                @else
                                                    {{'------'}}
                                                @endif
                                           {{-- @if($orders->delivery_status == 0)
                                                    {{'------'}}
                                                @elseif ($orders->delivery_status == 1)
                                                    {{'Success'}}
                                                @elseif ($orders->delivery_status == 2)
                                                    {{'Failed'}}
                                                @else 
                                                    {{'------'}}
                                                @endif--}}
                                            </span></li>
                                            <li>Payment Mode : <span>
                                             @if($orders->payment_mode == 0)
                                                    {{'------'}}
                                                @elseif ($orders->payment_mode == 1)
                                                    {{'Cash On Delivery'}}
                                                @elseif ($orders->payment_mode == 3)
                                                    {{'Cash On Pickup (COP)'}}
                                                @elseif ($orders->payment_mode == 2)
                                                    {{'PhonePe'}}
                                                @elseif ($orders->payment_mode == 4)
                                                    {{'Easebuzz'}}
                                                @else
                                                    {{'------'}}
                                                @endif
                                                @if(!empty($orders->order_trans?->gatewaytransactionid))
                                                    ({{ $orders->order_trans->gatewaytransactionid }})
                                                @endif
                                            </span></li>
                                            <li>Payment Status : <span>
                                                @if($orders->payment_status == 0)
                                                    {{'Pending'}}
                                                @elseif($orders->payment_status == 1)
                                                    {{'Success'}}
                                                @elseif ($orders->payment_status == 2)
                                                    {{'Failed'}}
                                                @else
                                                    {{'------'}}
                                                @endif
                                                </span></li>
                                            
                                           
                                            
                                        </ul>

                                    </div>

                                </div>
                            </div>
                            {{--<div class="col-lg-6 mb-3">
                                <div class="view-order-details">
                                    <div class="view-order-info">
                                        <ul>
                                            <li>Return Order Status : <span>
                                                 @if($orders->return_order_status == 0)
                                                    {{'------'}}
                                                @elseif ($orders->return_order_status == 1)
                                                    {{'Order Return Initialized'}}
                                                @elseif ($orders->return_order_status == 2)
                                                    {{'Order Return Confirmed'}}
                                                @elseif ($orders->return_order_status == 3)
                                                    {{'Order Return Cancelled'}}
                                                @else 
                                                    {{'------'}}
                                                @endif
                                            </span></li>
                                            <li>Reference Order	: <span>
                                                @if($orders->ref_order_id)
                                                    @if($orders->Reference->order_code)
                                                        {{$orders->Reference->order_code}}
                                                    @else 
                                                        {{'------'}}
                                                    @endif
                                                @else 
                                                    {{'------'}}
                                                @endif
                                            </span></li>
                                            <li>Replace Order : <span>{{$orders->replace_order}}</span></li>
                                            
                                        </ul>

                                    </div>

                                </div>
                            </div> --}}
                            
                        </div>
                        {{--<div class="col-lg-12">
                            <div class="view-order-details-top">
                                <p>Discount : <span>
                                    @if($orders->discount_flag)
                                            {{$orders->discount_flag}}
                                        @else
                                            {{'------'}}
                                        @endif
                                </span></p>
                                <p>Discount Rate : <span>₹ 
                                    @if($orders->discount)
                                        <i class="fa fa-inr"></i> {{$orders->discount}}
                                    @else
                                        {{'------'}}
                                    @endif
                                    </span></p>
                            </div>

                        </div>--}}
                       
                        <div class="view-order-bottom">
                            <div class="over-scrol">
                                <table class="table order-table table-striped table-bordered order-preview-table">
                                     @if(count($orders['details']) != 0) 
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Items</th>
                                            <th>Quantity</th>
                                            <th>Unit Price	</th>
                                            <th>Tax</th>
                                            <!--<th>Shipping Charge</th>-->
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         @foreach ($orders['details'] as $key => $value)
                                        <tr>
                                            <td><a href="{{ route('view_products', ['id' => $value->product_id]) }}">
                                                    @if(isset($value->Products) && $value->Products->featured_product_img)
                                                        <img src="{{ asset($product_path.'/'.$value->Products->featured_product_img) }}" >
                                                        @else
                                                         <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}"  >
                                                    @endif
                                                </a>
                                            </td>
                                            <td>{{$value->product_title}} @if($value->color_name)
                                                    ({{$value->color_name}} )
                                                     @endif
                                                @if(isset($value->att_name) && $value->att_name != 0)
                                                    @if(isset($value->AttName->att_name) && isset($value->AttValue->att_value)) 
                                                        <span>({{$value->AttName->att_name}} : {{$value->AttValue->att_value}})</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{$value->order_qty}}</td>
                                            <td class="white-nowrap">₹ {{$value->unitprice}}</td>
                                            <td class="white-nowrap">₹ {{$value->tax_amount}}</td>
                                            <!--<td>₹ {{$value->shiping_charge ?? '0.00'}}</td>-->
                                            <td class="white-nowrap">₹ {{$value->totalprice}}</td>
                                            
                                        </tr>
                                         @endforeach
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                            
                        </div>
                        <div class="col-lg-12 mb-2">
                                <div class="view-order-between">
                                    <div class="view-order-info">
                                        <ul>
                                           {{-- <li class="view-order-li-pd">COD Charge : <span>
                                             @if($orders->cod_charge)
                                                    <i class="fa fa-inr"></i> 
                                                    {{$orders->cod_charge}}
                                                @else
                                                    {{'------'}}
                                                @endif
                                            </span></li>--}}
                                            <li class="view-order-li-pd">Tax Amount : <span>
                                                @if($orders->tax_amount)
                                                    <i class="fa fa-inr"></i> {{$orders->tax_amount}}
                                                @else
                                                    {{'------'}}
                                                @endif
                                            </span></li>
                                           
                                            <li class="view-order-li-pd">Shipping Charge : <span>
                            
                                                @if($orders->shipping_charge)
                                                    <i class="fa fa-inr"></i> 
                                                    {{$orders->shipping_charge}}
                                                @else
                                                    {{'------'}}
                                                @endif
                                                </span>
                                            </li>
                                              @if($orders->coupon_discount >0)
                                              <li class="view-order-li-pd">Coupon : <span>
                                                   {{$orders->coupon_code}} / <i class="fa fa-inr"></i> {{$orders->coupon_discount}}
                                               
                                            </span></li>
                                            @endif
                                            
                                             <li style="background-color: #edc8aee6;">Net Amount : <span class="fw-bold text-danger fs-5">
                                                 
                                             @if($orders->net_amount)
                                                    <i class="fa fa-inr"></i> {{$orders->net_amount}}
                                                @else
                                                    {{'------'}}
                                                @endif
                                            </span></li>
                                            
                                        </ul>

                                    </div>

                                </div>
                            </div>
                        <div class="view-order-shiping">
                            <label for="">Shipping Address</label>
                            <p>{{$orders->shipping_address}}</p>
                        </div>
                        <div class="view-order-shiping">
                            <label for="">Remarks</label>
                           <p>
                             @if($orders->remarks)
                                {{$orders->remarks}}
                            @else 
                                {{'------'}}
                            @endif
                           </p>

                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        

    </section>




@endsection

@section('before_scripts')
<script src="{{ asset('ui_assets_old/plugins/select2/dist/js/select2.full.min.js')}}"></script>
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
        })
    });
</script>

<script>
    $(document).ready(function() { 
        $('p.alert').delay(7000).slideUp(500); 
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
       
            var state = 0;
       
            var city = 0;
       
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
        //                                     icon: 'fa fa-ban',
        //                                     theme: 'modern',
        //                                     closeIcon: true,
        //                                     animation: 'scale',
        //                                     type: 'red',
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
        //                         icon: 'fa fa-ban',
        //                         theme: 'modern',
        //                         closeIcon: true,
        //                         animation: 'scale',
        //                         type: 'red',
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
        //                     icon: 'fa fa-ban',
        //                     theme: 'modern',
        //                     closeIcon: true,
        //                     animation: 'scale',
        //                     type: 'red',
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
        //         icon: 'fa fa-ban',
        //         theme: 'modern',
        //         closeIcon: true,
        //         animation: 'scale',
        //         type: 'red',
        //         buttons: {
        //             Ok: function(){
        //             }
        //         }
        //     });
        // }

        @if(isset($user['docs']))
            var cnt = <?php echo count($user['docs']) + 1;?>;
        @else
            var cnt = 2;
        @endif

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