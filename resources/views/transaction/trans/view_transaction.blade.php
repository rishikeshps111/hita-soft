<?php  
    $product_path = 'images/featured_products';
    $noimage = \DB::table('noimage_settings')->first();
    $noimage_path = 'images/noimage';
?>
@extends('layouts.master')
@section('title', 'View Transaction')
@section('content')
<style>
    table.border-table tr td,table.border-table tr th {
            border: 1px solid #ccc !important;
    }
    table.border-table tr td{
        text-align:center !important;
    }
    table {
        width: 100%;
    }
</style>
<section class="gj_vw_trans_setting">
    <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
   @include('layouts.transaction_sidebar')
        </div>

        <div class="col-lg-10 pt-30">

            <div class="gj_box dark" id="gj_svw_trans_tbl">
                 <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                     <div class="col-lg-12 back-container">
                          <h3 class="gj_heading"> View Transaction  </h3>
                          <a href="javascript:history.back()" class="btn btn-outline-secondary" >
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                     </div>
                      <div class="col-lg-12 ">
                    @if($trans) 
                        <div class="gj_res_trans table-responsive adm-product-view">
                            <table class="table table-striped">
                                <tr>
                                    <th  class="w-50">Transaction Code</th>
                                    <td  class="w-50">{{$trans->trans_code}}</td>
                                </tr>

                                <tr>
                                    <th >Order Code</th>
                                    <td >{{$trans->orders->order_code}}</td>
                                </tr>

                                <tr>
                                    <th >Transaction Date</th>
                                    <td >{{ date('d-m-Y H:i:s', strtotime($trans->trans_date)) }}</td>
                                </tr>

                                <tr>
                                    <th >Transaction ID</th>
                                    <td >
                                        @if ($trans->gatewaytransactionid)
                                            {{$trans->gatewaytransactionid}}
                                        @else
                                            {{'-------'}}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th >Amount Paid</th>
                                    <td >
                                        @if ($trans->amountpaid)
                                            {{$trans->amountpaid}}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th >Order Status</th>
                                    <td >
                                        @if($trans->orders->order_status == 0)
                                            {{'------'}}
                                        @elseif($trans->orders->order_status == 1)
                                            {{'Order Placed'}}
                                        @elseif ($trans->orders->order_status == 2)
                                            {{'Order Dispatched'}}
                                        @elseif ($trans->orders->order_status == 3)
                                            {{'Order Delivered'}}
                                        @elseif ($trans->orders->order_status == 4)
                                            {{'Order Complete'}}
                                        @elseif ($trans->orders->order_status == 5)
                                            {{'Order Cancelled'}}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th >Contact Person</th>
                                    <td >{{$trans->orders->contact_person}}</td>
                                </tr>
                                
                                <tr>
                                    <th >Contact Number</th>
                                    <td >{{$trans->orders->contact_no}}</td>
                                </tr>

                                <tr>
                                    <th >Shipping Address</th>
                                    <td >{{$trans->orders->shipping_address}}</td>
                                </tr>

                                <tr>
                                    <th >Total Items</th>
                                    <td >{{$trans->orders->total_items}}</td>
                                </tr>

                                <tr>
                                    <th >Sub Total</th>
                                    <td >Rs. {{$trans->orders->total_amount}}</td>
                                </tr>

                                <tr>
                                    <th >Payment Mode</th>
                                    <td >
                                        @if($trans->paymentmode == 1)
                                            {{'COD'}}
                                        @elseif($trans->paymentmode == 2)
                                            {{'PhonePe'}}
                                        @elseif($trans->paymentmode == 3)
                                            {{'COP'}}
                                        @elseif($trans->paymentmode == 4)
                                            {{'Easebuzz'}}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>

                                {{--<tr>
                                    <th >Payment Method</th>
                                    <td >
                                        @if($trans->paymentmode == 1)
                                            @if($trans->pay_method)
                                                {{$trans->pay_method}}
                                            @else
                                                {{'COD'}}
                                            @endif
                                        @elseif($trans->paymentmode == 2)
                                            @if($trans->pay_method)
                                                {{$trans->pay_method}}
                                            @else
                                                {{'------'}}
                                            @endif
                                        @else
                                            @if($trans->pay_method)
                                                {{$trans->pay_method}}
                                            @else
                                                {{'------'}}
                                            @endif
                                        @endif
                                    </td>
                                </tr>--}}

                                <tr>
                                    <th >Shipping Charge</th>
                                    <td>
                                        @if($trans->orders->shipping_charge)
                                            {{'₹ '.$trans->orders->shipping_charge}}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th >Net Amount</th>
                                    <td >
                                        @if($trans->net_amount)
                                            {{'₹ '.$trans->net_amount}}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th >Transaction Status</th>
                                    <td >
                                        @if($trans->trans_status)
                                            {{$trans->trans_status}}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th >Remarks</th>
                                    <td>
                                        @if($trans->remarks)
                                            {{$trans->remarks}}
                                        @else 
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>

                              

                                
                            </table>
                              <table class="border-table">
                                  @if(count($trans['orders_dets']) != 0) 
                                    <tr class="bottom-bg-th">
                                        <th></th>
                                        <th>Title</th>
                                        <th>Product Code</th>
                                        <!--<th>Product Add</th>-->
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Tax</th>
                                        <th>Total</th>
                                        <!--<th>Cost Price (Basis)</th> -->
                                        <!--<th>Profit/Loss</th>-->
                                    </tr>
                                    @foreach ($trans['orders_dets'] as $key => $value)
                                        <tr>
                                             <td><a href="{{ route('view_products', ['id' => $value->product_id]) }}">
                                                  @if($value->Products->featured_product_img)
                                                            <img src="{{ asset($product_path.'/'.$value->Products->featured_product_img)}}" width="100px">
                                                        @else 
                                                            <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}" width="100px">
                                                        @endif
                                            </a></td>
                                           
                                            <td>
                                                {{$value->product_title}}

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
                                            <td>{{$value->unitprice}}</td>
                                            <td>{{$value->tax_amount}}</td>
                                            <td>{{$value->totalprice}}</td>
                                            
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td style="text-align:right !important;"  colspan="6">Sub Total</td>
                                        <td colspan="1">{{'₹ '.$trans->orders->total_amount}}</td>
                                    </tr>
                                     <tr>
                                        <td style="text-align:right !important;" colspan="6">Shipping Charge</td>
                                        <td colspan="1">{{'₹ '.$trans->orders->shipping_charge}}</td>
                                    </tr>
                                     @if($trans->orders->coupon_discount>0)
                                     <tr>
                                        <td style="text-align:right !important;"  colspan="6">Coupon Discount ({{$trans->orders->coupon_code}})</td>
                                        <td colspan="1">{{'₹ '.$trans->orders->coupon_discount}}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td style="text-align:right !important;"  colspan="6">Grand Total</td>
                                        <td colspan="1">{{'₹ '.$trans->orders->net_amount}}</td>
                                    </tr>
                                @endif
                              </table>
                        </div>
                    @endif
                </div>
                 </div>
                

               

                <div class="col-md-12">
                    <div class="gj_exp_but text-right">
                        <button class="btn btn-primary" onclick="Export()">Export</button>
                        
                        <a href="{{ route('all_transaction') }}"><button class="btn btn-info">Back</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script type="text/javascript">
    function Export() {
        $('.gj_exp_but').hide();
        html2canvas(document.getElementById('gj_svw_trans_tbl'), {
            onrendered: function (canvas) {
                var data = canvas.toDataURL();
                var docDefinition = {
                    content: [{
                        image: data,
                        width: 500
                    }]
                };
                pdfMake.createPdf(docDefinition).download("view_transaction.pdf");
            }
        });
    }
</script>
@endsection
