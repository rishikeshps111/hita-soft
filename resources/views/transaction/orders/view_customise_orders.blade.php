@extends('layouts.master')
@section('title', 'View Orders')
@section('content')
<style>
    .td-file-img {
    width: 400px;
    transition: transform 0.3s ease;
    cursor: zoom-in;
}

.td-file-img:hover {
    transform: scale(2.5); /* Adjust zoom level */
    z-index: 1000;
    position: relative;
}

</style>
<section class="gj_brands_setting">
    <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
   @include('layouts.transaction_sidebar')
        </div>

        <div class="col-lg-10 ">

            <div class="gj_box dark" id="gj_svw_odr_tbl">
                <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                    <div class="col-lg-12 back-container">
                         <h3 class="gj_heading"> View Custom Orders  </h3>
                         <a href="javascript:history.back()" class="btn btn-outline-secondary">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                       <div class="col-lg-12">
                    @if($orders) 
                        <div class="gj_res_odr table-responsive adm-product-view">
                            <table class="table table-striped ">
                                {{-- <tr>
                                    <th colspan="2">Order Code</th>
                                    <td colspan="5">{{$orders->order_code}}</td>
                                </tr> --}}

                                <tr>
                                    <th colspan="2" class="w-50">Order Date</th>
                                    <td colspan="5" class="w-50">{{ date('d-m-Y', strtotime($orders->created_at)) }}</td>
                                </tr>

                               
                                <tr>
                                    <th colspan="2">Contact Person</th>
                                    <td colspan="5">{{$orders->name}}</td>
                                </tr>
                                
                                <tr>
                                    <th colspan="2">Contact Number</th>
                                    <td colspan="5">{{$orders->phone_number}}</td>
                                </tr>
                                
                                 <tr>
                                    <th colspan="2">Custom Order Profit</th>
                                    <td colspan="5">Rs {{$orders->custom_order_profit ?? ''}}</td>
                                </tr>
                                <!-- <tr>-->
                                <!--    <th colspan="2">Product Name</th>-->
                                <!--    <td colspan="5">{{$orders->product_name}}</td>-->
                                <!--</tr>-->

                                {{--<tr>
                                    <th colspan="2">Shipping Address</th>
                                    <td colspan="5">{{$orders->shipping_address}}</td>
                                </tr>

                                <tr>
                                    <th colspan="2">Company Name</th>
                                    <td colspan="5">{{$orders->company_name}}</td>
                                </tr>
                                
                                 <tr>
                                    <th colspan="2">Company Website</th>
                                    <td colspan="5">{{$orders->company_website}}</td>
                                </tr>
                                
                                 <tr>
                                    <th colspan="2">What are you looking to pack ?</th>
                                    <td colspan="5">{{$orders->packing_item}}</td>
                                </tr>
                                
                                 <tr>
                                    <th colspan="2">How many boxes do you need </th>
                                    <td colspan="5">{{$orders->box_quantity}}</td>
                                </tr>
                                
                                 <tr>
                                    <th colspan="2">Dimension of the box or product </th>
                                    <td colspan="5">{{$orders->box_dimension}}</td>
                                </tr>
                                
                                 <tr>
                                    <th colspan="2">What type of boxes are you looking for</th>
                                    <td colspan="5">{{$orders->box_type}}</td>
                                </tr>--}}
                                
                                 <tr>
                                    <th colspan="2">Uploaded image</th>
                                    <td colspan="5">  @if ($orders->uploaded_image)
                                        <img src="{{ asset($orders->uploaded_image) }}" alt="Uploaded Image" data-bs-toggle="modal" data-bs-target="#zoomModal" class="td-file-img" style="width: 200px; height:100%; cursor: zoom-in;">
                                    @else
                                        No image uploaded.
                                    @endif</td>
                                </tr>

                                {{--<tr>
                                    <th colspan="2">Sub Total</th>
                                    <td colspan="5">Rs. {{$orders->total_amount}}</td>
                                </tr>--}}

                                <!--<tr>-->
                                <!--    <th colspan="2">Discount</th>-->
                                <!--    <td colspan="5">-->
                                <!--        @if($orders->discount_flag)-->
                                <!--            {{$orders->discount_flag}}-->
                                <!--        @else-->
                                <!--            {{'------'}}-->
                                <!--        @endif-->
                                <!--    </td>-->
                                <!--</tr>-->

                                <!--<tr>-->
                                <!--    <th colspan="2">Discount Rate</th>-->
                                <!--    <td colspan="5">-->
                                <!--        @if($orders->discount)-->
                                <!--            {{'₹ '.$orders->discount}}-->
                                <!--        @else-->
                                <!--            {{'------'}}-->
                                <!--        @endif-->
                                <!--    </td>-->
                                <!--</tr>-->

                                <!--<tr>-->
                                <!--    <th colspan="2">Shipping Charge</th>-->
                                <!--    <td colspan="5">-->
                                <!--        @if($orders->shipping_charge)-->
                                <!--            {{'₹ '.$orders->shipping_charge}}-->
                                <!--        @else-->
                                <!--            {{'------'}}-->
                                <!--        @endif-->
                                <!--    </td>-->
                                <!--</tr>-->

                                <!--<tr>-->
                                <!--    <th colspan="2">COD Charge</th>-->
                                <!--    <td colspan="5">-->
                                <!--        @if($orders->cod_charge)-->
                                <!--            {{'₹ '.$orders->cod_charge}}-->
                                <!--        @else-->
                                <!--            {{'------'}}-->
                                <!--        @endif-->
                                <!--    </td>-->
                                <!--</tr>-->

                                <!--<tr>-->
                                <!--    <th colspan="2">Tax Amount</th>-->
                                <!--    <td colspan="5">-->
                                <!--        @if($orders->tax_amount)-->
                                <!--            {{'₹ '.$orders->tax_amount}}-->
                                <!--        @else-->
                                <!--            {{'------'}}-->
                                <!--        @endif-->
                                <!--    </td>-->
                                <!--</tr>-->

                                <!--<tr>-->
                                <!--    <th colspan="2">Net Amount</th>-->
                                <!--    <td colspan="5">-->
                                <!--        @if($orders->net_amount)-->
                                <!--            {{'₹ '.$orders->net_amount}}-->
                                <!--        @else-->
                                <!--            {{'------'}}-->
                                <!--        @endif-->
                                <!--    </td>-->
                                <!--</tr>-->

                                <!--<tr>-->
                                <!--    <th colspan="2">Payment Mode</th>-->
                                <!--    <td colspan="5">-->
                                <!--        @if($orders->payment_mode == 0)-->
                                <!--            {{'------'}}-->
                                <!--        @elseif ($orders->payment_mode == 1)-->
                                <!--            {{'Cash On Delivery'}}-->
                                <!--        @elseif ($orders->payment_mode == 2)-->
                                <!--            {{'Online Payment'}}-->
                                <!--        @else-->
                                <!--            {{'------'}}-->
                                <!--        @endif-->
                                <!--    </td>-->
                                <!--</tr>-->

                               {{-- <tr>
                                    <th colspan="2">Delivery Date</th>
                                    <td colspan="5">
                                        @if($orders->delivery_date)
                                            {{ date('d-m-Y', strtotime($orders->delivery_date)) }}
                                        @else
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>--}}

                                <!--<tr>-->
                                <!--    <th colspan="2">Order Status</th>-->
                                <!--    <td colspan="5">-->
                                <!--    <span class="error">-->
                                <!--        @if ($errors->has('order_status'))-->
                                <!--            {{ $errors->first('order_status') }}-->
                                <!--        @endif-->
                                <!--    </span>-->
        
                                <!--    <select id="status" name="status" data-odr-id="{{$orders->id}}" class="form-control gj_edt_order_status">-->
                                <!--        <option value="1" @if($orders->order_status == 1) {{'selected'}} @endif>Order Placed</option>-->
                                <!--        <option value="2" @if($orders->order_status == 2) {{'selected'}} @endif>Order Dispatched</option>-->
                                <!--        <option value="3" @if($orders->order_status == 3) {{'selected'}} @endif>Order Delivered </option>-->
                                <!--        <option value="4" @if($orders->order_status == 4) {{'selected'}} @endif>Order Complete</option>-->
                                <!--        <option value="5" @if($orders->order_status == 5) {{'selected'}} @endif>Order Cancelled</option>-->
                                <!--    </select>-->
                                <!--    </td>-->
                                <!--</tr>-->
                                
                                <!--<tr>-->
                                <!--    <th colspan="2">Payment Status</th>-->
                                <!--    <td colspan="5">-->
                                       
            
                                <!--        <select id="payment_status" name="paid_sts" data-ord-id="{{$orders->id}}" class="form-control gj_edt_payment_status">-->
                                <!--            <option value="0" @if($orders->payment_status == 0) {{'selected'}} @endif>Pending</option>-->
                                <!--            <option value="1" @if($orders->payment_status == 1) {{'selected'}} @endif>Success</option>-->
                                <!--            <option value="2" @if($orders->payment_status == 2) {{'selected'}} @endif>Failed </option>-->
                                <!--        </select>-->
                                <!--    </td>-->
                                <!--</tr>-->

                               {{-- <tr>
                                    <th colspan="2">Delivery Status</th>
                                    <td colspan="5">
                                        @if($orders->delivery_status == 0)
                                            {{'------'}}
                                        @elseif ($orders->delivery_status == 1)
                                            {{'Success'}}
                                        @elseif ($orders->delivery_status == 2)
                                            {{'Failed'}}
                                        @else 
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th colspan="2">Return Order Status</th>
                                    <td colspan="5">
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
                                    <th colspan="2">RePlace Order</th>
                                    <td colspan="5">
                                        {{$orders->replace_order}}
                                    </td>
                                </tr>

                                <tr>
                                    <th colspan="2">Reference Order</th>
                                    <td colspan="5">
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
                                    <th colspan="2">Message</th>
                                    <td colspan="5">
                                        @if($orders->message)
                                            {{$orders->message}}
                                        @else 
                                            {{'------'}}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th colspan="6"></th>
                                </tr>

                            </table>
                        </div>
                    @endif
                </div>
                </div>
               

             

                <div class="col-md-12">
                    <div class="gj_exp_but text-right">
                        <button class="btn btn-primary" onclick="Export()">Export</button>
                        
                        <a href="{{ route('custom_orders') }}"><button class="btn btn-info">Back</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Zoom Modal -->
<div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <img src="{{ asset($orders->uploaded_image) }}" class="img-fluid" alt="Zoomed Image">
      </div>
    </div>
  </div>
</div>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script>
         $('.gj_edt_order_status').on('change',function(){
            var id = 0;
            var status = 0;
            if($(this).attr('data-odr-id')) {
                id = $(this).attr('data-odr-id');
            }

            if($(this).val()) {
                status = $(this).val();
            }

            $.ajax({
                type: 'post',
                url: '{{url('/status_customise_orders')}}',
                data: {id: id, status: status, type: 'staus_change'},
                success: function(data){
                    if(data == 0){
                        window.location.reload();
                    } else {
                        $.confirm({
                            title: '',
                            content: 'No Action Performed!',
                            icon: 'fa fa-exclamation',
                            theme: 'modern',
                            closeIcon: true,
                            animation: 'scale',
                            type: 'purple',
                            buttons: {
                                Ok: function(){
                                    window.location.reload();
                                }
                            }
                        });
                    }
                }
            });
        });

        $('.gj_edt_payment_status').on('change',function(){
            var id = 0;
            var status = 0;
            if($(this).attr('data-ord-id')) {
                id = $(this).attr('data-ord-id');
            }

            if($(this).val()) {
                status = $(this).val();
            }

            $.ajax({
                type: 'post',
                url: '{{url('/paymentstatus_customise_orders')}}',
                data: {id: id, status: status, type: 'staus_change'},
                success: function(data){
                    window.location.reload();
                }
            });
        });
</script>
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
                pdfMake.createPdf(docDefinition).download("view_custom_order.pdf");
            }
        });
    }
</script>
@endsection
