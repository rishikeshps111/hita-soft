
<?php  
    $product_path = 'images/featured_products';
    $noimage = \DB::table('noimage_settings')->first();
    $noimage_path = 'images/noimage';
?>
@extends('layouts.master')
@section('title', 'View Orders')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

<style>
    table.border-table tr td,table.border-table tr th {
            border: 1px solid #ccc !important;
    }
    table{
        width: 100%;
    }
</style>

<section class="gj_brands_setting">
    <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
   @include('layouts.transaction_sidebar')
        </div>

        <div class="col-lg-10 pt-30">
            <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                <div class="col-lg-12 back-container">
                    <h3 class="gj_heading"> View Orders  </h3>
                    <a href="javascript:history.back()" class="btn btn-outline-secondary" >
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                </div>
                <div class="col-lg-12">
                    <div class="gj_box dark mt__0" id="gj_svw_odr_tbl">
                

                   <div class="adm-product-view">
                    @if($orders) 
                        <div class="gj_res_odr table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th class="w-50">Order Code</th>
                                    <td  class="w-50">{{$orders->order_code}}</td>
                                </tr>
                                
                                 <tr>
                                    <th class="w-50">Tracking Id</th>
                                    <td  class="w-50">{{$orders->tracking_id ?? '-'}}</td>
                                </tr>

                                <tr>
                                    <th >Order Date</th>
                                    <td >{{ date('d-m-Y', strtotime($orders->order_date)) }}</td>
                                </tr>

                                <tr>
                                    <th >Payment Mode</th>
                                    <td >
                                        @if($orders->payment_mode == 0)
                                            {{'------'}}
                                        @elseif ($orders->payment_mode == 1)
                                            {{'Cash On Delivery'}}
                                        @elseif ($orders->payment_mode == 2)
                                            {{'PhonePe'}}
                                        @elseif ($orders->payment_mode == 3)
                                            {{'Cash On Pickup'}}
                                        @elseif ($orders->payment_mode == 4)
                                            {{'Easebuzz'}}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Delivery Date</th>
                                    <td>
                                        @if($orders->delivery_date)
                                            {{ date('d-m-Y', strtotime($orders->delivery_date)) }}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th >Order Status</th>
                                    <td>
                                        @if($orders->order_status == 0)
                                            {{'------'}}
                                        @elseif($orders->order_status == 1)
                                            {{'Order Placed'}}
                                        @elseif ($orders->order_status == 2)
                                            {{'Order Dispatched'}}
                                        @elseif ($orders->order_status == 3)
                                            {{'Order Delivered'}}
                                        @elseif ($orders->order_status == 4)
                                            {{'Order Complete'}}
                                        @elseif ($orders->order_status == 5)
                                            {{'Order Cancelled'}}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th>Contact Person</th>
                                    <td>{{$orders->contact_person}}</td>
                                </tr>
                                
                                <tr>
                                    <th >Contact Number</th>
                                    <td >{{$orders->contact_no}}</td>
                                </tr>

                                <tr>
                                    <th>Shipping Address</th>
                                    <td>{{$orders->shipping_address}}</td>
                                </tr>

                                <tr>
                                    <th>Total Items</th>
                                    <td>{{$orders->total_items}}</td>
                                </tr>

                                <tr>
                                    <th >Sub Total</th>
                                    <td >Rs. {{$orders->total_amount}}</td>
                                </tr>

                                {{--<tr>
                                    <th colspan="2">Discount</th>
                                    <td colspan="5">
                                        @if($orders->discount_flag)
                                            {{$orders->discount_flag}}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th >Discount Rate</th>
                                    <td >
                                        @if($orders->discount)
                                            {{'₹ '.$orders->discount}}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>--}}

                                <tr>
                                    <th >Shipping Charge</th>
                                    <td>
                                        @if($orders->shipping_charge)
                                            {{'₹ '.$orders->shipping_charge}}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>

                               {{-- <tr>
                                    <th colspan="2">COD Charge</th>
                                    <td colspan="5">
                                        @if($orders->cod_charge)
                                            {{'₹ '.$orders->cod_charge}}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Tax Amount</th>
                                    <td >
                                        @if($orders->tax_amount)
                                            {{'₹ '.$orders->tax_amount}}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>--}}

                                <tr>
                                    <th >Net Amount</th>
                                    <td >
                                        @if($orders->net_amount)
                                            {{'₹ '.$orders->net_amount}}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th >Payment Status</th>
                                    <td >
                                        @if($orders->payment_status == 0)
                                            {{'Pending'}}
                                        @elseif($orders->payment_status == 1)
                                            {{'Success'}}
                                        @elseif ($orders->payment_status == 2)
                                            {{'Failed'}}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th >Delivery Status</th>
                                    <td >
                                        @if($orders->order_status == 0)
                                            {{'Pending'}}
                                        @elseif ($orders->order_status == 2)
                                            {{'In Transit'}}
                                        @elseif ($orders->order_status == 3)
                                            {{'Delivered'}}
                                        @elseif ($orders->order_status == 4)
                                            {{'Success'}}
                                        @else
                                            {{'Pending'}}
                                        @endif
                                    </td>
                                </tr>

                                {{--<tr>
                                    <th >Return Order Status</th>
                                    <td >
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
                                    </td>
                                </tr>

                                <tr>
                                    <th >RePlace Order</th>
                                    <td >
                                        {{$orders->replace_order}}
                                    </td>
                                </tr>

                                <tr>
                                    <th >Reference Order</th>
                                    <td >
                                        @if($orders->ref_order_id)
                                            @if($orders->Reference->order_code)
                                                {{$orders->Reference->order_code}}
                                            @else 
                                                {{'------'}}
                                            @endif
                                        @else 
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>--}}

                                <tr>
                                    <th >Remarks</th>
                                    <td >
                                        @if($orders->remarks)
                                            {{$orders->remarks}}
                                        @else 
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>

                                

                                
                            </table>
                            <table class="border-table">
                                @if(sizeof($orders['details']) != 0) 
                                    <tr class="bottom-bg-th">
                                        <th></th>
                                        <th>Title</th>
                                        <th>Product Code</th>
                                        <!--<th>Product Add</th>-->
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Tax(INCL)</th>
                                        <th>Total</th>
                                    </tr>
                                    @foreach ($orders['details'] as $key => $value)
                                        <tr>
                                            <td><a href="{{ route('view_products', ['id' => $value->product_id]) }}">
                                                <a href="{{ asset($product_path.'/'.$value->Products->featured_product_img) }}" data-lightbox="product" data-title="Product Image">
                                                     @if($value->Products->featured_product_img)
                                                        <img src="{{ asset($product_path.'/'.$value->Products->featured_product_img)}}" class="img-responsive" style="max-width: 150px;">
                                                    @else 
                                                        <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}" class="img-responsive" style="max-width: 150px;">
                                                    @endif
                                                </a>
                                                    
                                                </td>
                                                    
                                            <td>
                                                {{$value->product_title}}
                                                
                                                  <span> @if($value->color_name)
                                                    ({{$value->color_name}} )
                                                     @endif</span>

                                                @if(isset($value->att_name) && $value->att_name != 0)
                                                    @if(isset($value->AttName->att_name) && isset($value->AttValue->att_value)) 
                                                        <span>({{$value->AttName->att_name}} : {{$value->AttValue->att_value}})</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($value->Products->product_code))
                                                    {{$value->Products->product_code}}
                                                @else
                                                    {{'-----'}}
                                                @endif
                                            </td>
                                            {{--<td>
                                                @if(isset($value->Products->Creatier->first_name))
                                                    {{$value->Products->Creatier->first_name.' '.$value->Products->Creatier->last_name}}
                                                @else
                                                    {{'-----'}}
                                                @endif
                                            </td>--}}
                                            <td>{{$value->order_qty}}</td>
                                            <td>{{'₹ '.$value->unitprice}}</td>
                                            <td>{{$value->tax_amount}}</td>
                                            <td>{{'₹ '.$value->totalprice}}</td>
                                            
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="text-right" colspan="6">Sub Total</td>
                                        <td colspan="1">{{'₹ '.$orders->total_amount}}</td>
                                    </tr>
                                     <tr>
                                        <td class="text-right" colspan="6">Shipping Charge</td>
                                        <td colspan="2">{{'₹ '.$orders->shipping_charge}}</td>
                                    </tr>
                                    @if($orders->coupon_discount>0)
                                     <tr>
                                        <td class="text-right" colspan="6">Coupon Discount ({{$orders->coupon_code}})</td>
                                        <td colspan="2">- {{'₹ '.$orders->coupon_discount}}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="text-right" colspan="6">Grand Total</td>
                                        <td colspan="3">{{'₹ '.$orders->net_amount}}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    @endif
                </div>

                <div class="col-md-12">
                    <div class="gj_exp_but text-right">
                        <button class="btn btn-primary" onclick="Export()">Export</button>
                        
                        <a href="{{ route('all_orders') }}"><button class="btn btn-info">Back</button></a>
                    </div>
                </div>
            </div>
                </div>
                
            </div>

            
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script type="text/javascript">
    function Export() {
        $('.gj_exp_but').hide();
        html2canvas(document.getElementById('gj_svw_odr_tbl'), {
            onrendered: function (canvas) {
                var data = canvas.toDataURL();
                var docDefinition = {
                    content: [{
                        image: data,
                        width: 500
                    }]
                };
                pdfMake.createPdf(docDefinition).download("view_order.pdf");
            }
        });
    }
</script>
@endsection
