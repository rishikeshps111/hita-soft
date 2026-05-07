@extends('layouts.master')
@section('title', 'Manage All Orders')
@section('content')

@php ($logged = session()->get('user')) @endphp
<style>
   .container-field .dataTables_filter input, .container-field .dataTables_length select {
    margin-left: 10px;
}
    .container-field form{
        margin-top:0;
    }
    .container-field form input,.container-field input,.container-field form select,.container-field select{
        height:37px;
        padding-left:10px;
    }
    div#gj_mge_all_orders_table_wrapper {
        margin-top: 45px;
    }
    
    table tr th {
    min-width: 101px;
    text-align: center !important;
}

.width-tb-cs tr td.wd-200 {
    min-width: 120px !important;
}
#paid_sts {
    float: none !important;
    width: 100% !important;
}
.pagination{
    display:flex;
}
@media screen and (max-width:768px){
    div#gj_mge_all_orders_table_wrapper{
        margin-top:12px;
    }
    
}
</style>
<section class="gj_all_orders_setting">
    <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
   @include('layouts.transaction_sidebar')
        </div>

        <div class="col-lg-10 ">
            

            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
               
                <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                 <div class="col-lg-12">
                      <h3 class="gj_heading"> Manage All Orders  </h3>
                      <div class="gj_manage_filter mt__3 top-btns">
                    @if($logged)
                        @if($logged->user_type == 1)
                            <span class="gj_squaredFour">
                                <input type="checkbox" id="ckbCheckAll" name="ckbCheckAll" />
                                <label for="ckbCheckAll">Check all</label>
                            </span>
                            {{--<a href="{{route('replace_all_orders')}}" class="gj_repl_odr"><button type="button" class="btn btn-primary gj_srh_replace">Replace Orders</button></a>--}}
                            <a href="{{route('all_orders')}}" class="gj_repl_odr"><button type="button" class="btn btn-warning gj_srh_replace">All Orders</button></a>
                            <button class="btn btn-danger" id="Delete_value" type="button">Delete</button>          
                            <button class="btn btn-info" id="export_csv" type="button">Export CSV</button>
                            <button class="btn btn-info" id="export_all_csv" type="button">Export All CSV</button>
                            <button id="downloadPdfBtn" class="btn btn-info mb-3">Download PDF</button>

                            <a href="#" id="download_csv"><button class="btn btn-info" id="export_csv_but" type="button">Download CSV</button></a>
                        @elseif($logged->user_type == 2 || $logged->user_type == 3)
                            <span class="gj_squaredFour">
                                <input type="checkbox" id="ckbCheckAll" name="ckbCheckAll" />
                                <label for="ckbCheckAll">Check all</label>
                            </span>
                             {{--<a href="{{route('replace_all_orders')}}" class="gj_repl_odr"><button type="button" class="btn btn-primary gj_srh_replace">Replace Orders</button></a>--}}
                            <a href="{{route('all_orders')}}" class="gj_repl_odr"><button type="button" class="btn btn-warning gj_srh_replace">All Orders</button></a>
                            <button class="btn btn-info" id="export_csv" type="button">Export CSV</button>
                            <button class="btn btn-info" id="export_all_csv" type="button">Export All CSV</button>
                            <a href="#" id="download_csv"><button class="btn btn-info" id="export_csv_but" type="button">Download CSV</button></a>
                        @endif
                    @endif
                </div>
                 </div>
                  <div class="col-md-12">
                    <div class=" gj_manage_all_orders mob-row-flex" id="orderTableToExport">
                        <div class="gj_cs_srh_div mob-static ">
                            <form action="{{ route('search_order') }}" method="GET" class="gj_search_order_form formtop-cs-tb date-filter-mob" enctype="multipart/form-data">
                            @csrf
                                <input type="date" name="gj_srh_odr_date" id="gj_srh_odr_date" class="gj_srh_odr_date">
                                <input type="text" name="gj_srh_odr_code" id="gj_srh_odr_code" class="gj_srh_odr_code" placeholder="Search By Order Code" value="{{request('gj_srh_odr_code')}}">
                                <select id="gj_srh_odr_sts" name="gj_srh_odr_sts" class="gj_srh_odr_sts">
                                    <option value=""> Select Order Status </option>
                                    <option value="1"> Order Placed </option>
                                    <option value="2"> Order Dispatched </option>
                                    <option value="3"> Order Delivered </option>
                                    <option value="4"> Order Completed </option>
                                    <option value="5"> Order Cancelled </option>
                                    <option value="with_coupon">Orders with Coupons</option>
                                </select>
                                <!--<select name="gj_srh_cpn_code" id="gj_srh_cpn_code" class="form-control" style="padding-left: 5px">-->
                                <!--    <option value="">Orders with Coupon</option>-->
                                    
                                    <!-- Add other options here -->
                                <!--</select>-->
                                <button type="submit" class="gj_srh_subm btn btn-primary" id="gj_srh_odr_subm">Search</button>
                                
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped width-tb-cs" id="gj_mge_all_orders_table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>#</th>
                                    <th>Order Code</th>
                                    <th>Order Date</th>
                                    <th>Customer Name</th>
                                    <th>Total Items</th>
                                    <!--<th>Rang Price</th>-->
                                    <th>Price </th>
                                    <th>Additional Discount</th>
                                    <!--<th>Order Profit</th>-->
                                    <th>Tracking ID</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="gj_mge_all_orders_bdy ">
                                @if($orders)
                                    @php 
                                    ($i = 1);
                                    
                                      $totalProfit = 0;
                                      $totalRangPrice = 0;
                                    @endphp
                                    
                                    @foreach($orders as $key => $value)
                                        @php
                                            $rangPrice = $value->orderDetails->sum(function($detail) {
                                                 $productPrice = $detail->Products->rang_price ?? 0;
                                                $qty = $detail->order_qty ?? 1;
                                                return $productPrice * $qty;
                                            });
                                        
                                            $pricePaid = $value->net_amount ?? 0;
                                            $tax = $value->tax_amount ?? 0;
                                            $shipping = $value->shipping_charge ?? 0;
                                            $discount = $value->additional_discount ?? 0;
                                        
                                            $profit = $pricePaid - $rangPrice - $tax - $shipping - $discount;
                                            $totalProfit += $profit; 
                                            $totalRangPrice += $rangPrice; 
                                        @endphp

                                        <tr>
                                            <td>{{$i}}</td>
                                            <td><input type="checkbox" name="check[]" class="checkBoxClass" value="{{$value->id}}" id="Checkbox{{$i}}" /></td>
                                            <td>
                                                {{$value->order_code}}
                                                @if($value->ref_order_id)
                                                    @if($value->Reference->order_code)
                                                        <p class="gj_ref_odr">Reference Order : {{$value->Reference->order_code}}</p>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($value->order_date)) }}</td>
                                            <td>{{$value->contact_person}}</td>
                                            <td>{{$value->total_items}}</td>
                                            <!--<td>{{ $rangPrice }}</td>-->
                                            <td>{{$value->net_amount}}</td>
                                            <td>
                                                @if($logged && $logged->user_type == 1)
                                                    <input type="text" 
                                                           class="form-control gj_add_discount_input" 
                                                           data-order-id="{{ $value->id }}" 
                                                           value="{{ $value->additional_discount ?? '' }}" 
                                                           placeholder="Enter Additional discount" oninput="this.value = this.value.replace(/[^0-9.-]/g, '').replace(/(\..*)\./g, '$1').replace(/(?!^)-/g, '')"  style="width: 140px;">
                                                @else
                                                    {{ $value->additional_discount ?? '----' }}
                                                @endif
                                            </td>
                                            <!--<td>{{ number_format($profit, 2) }}</td>-->
                                            <td>
                                                @if($logged && $logged->user_type == 1)
                                                    <input type="text" 
                                                           class="form-control gj_tracking_input" 
                                                           data-order-id="{{ $value->id }}" 
                                                           value="{{ $value->tracking_id ?? '' }}" 
                                                           placeholder="Enter Tracking ID"  style="width: 140px;">
                                                @else
                                                    {{ $value->tracking_id ?? '----' }}
                                                @endif
                                            </td>

                                            <td>
                                                {{--<p class="gj_p_met text-center">
                                                    @if($value->payment_mode == 1)
                                                        {{'COD'}}
                                                    @elseif($value->payment_mode == 2)
                                                        {{'Online'}}
                                                    @else
                                                        {{'----'}}
                                                    @endif
                                                </p>--}}

                                                @if($logged)
                                                    @if($logged->user_type == 1)
                                                        <select name="paid_sts" id="paid_sts" data-ord-id="{{$value->id}}" class="form-control gj_paid_sts">
                                                            <option value="0" @if($value->payment_status == 0) {{'selected'}} @endif>Pending</option>
                                                            <option value="1" @if($value->payment_status == 1) {{'selected'}} @endif>Success</option>
                                                            <option value="2" @if($value->payment_status == 2) {{'selected'}} @endif>Failed</option>
                                                        </select>
                                                    @elseif($logged->user_type == 2 || $logged->user_type == 3)
                                                        <p class="gj_p_met text-center">
                                                            @if($value->payment_status == 0)
                                                                {{'Pending'}}
                                                            @elseif($value->payment_status == 1)
                                                                {{'Success'}}
                                                            @elseif($value->payment_status == 2)
                                                                {{'Failed'}}
                                                            @else
                                                                {{'----'}}
                                                            @endif
                                                        </p>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if($logged)
                                                    @if($logged->user_type == 1)
                                                        @if($value->order_status == 4 || $value->order_status == 5)
                                                            <!-- Show static status text -->
                                                            @if($value->order_status == 4)
                                                                {{ 'Order Completed' }}
                                                            @elseif($value->order_status == 5)
                                                                {{ 'Order Cancelled' }}
                                                            @endif
                                                        @else
                                                            <!-- Show dropdown if not completed or cancelled -->
                                                            <select name="status" id="status" data-odr-id="{{$value->id}}" class="form-control gj_odr_sts">
                                                                <option value="0" @if($value->order_status == 0) selected @endif>-- Select Order Status --</option>
                                                                <option value="1" @if($value->order_status == 1) selected @endif>Order Placed</option>
                                                                <option value="2" @if($value->order_status == 2) selected @endif>Order Dispatched</option>
                                                                <option value="3" @if($value->order_status == 3) selected @endif>Order Delivered</option>
                                                                <option value="4" @if($value->order_status == 4) selected @endif>Order Completed</option>
                                                                <option value="5" @if($value->order_status == 5) selected @endif>Order Cancelled</option>
                                                            </select>
                                                        @endif
                                                    @elseif($logged->user_type == 2 || $logged->user_type == 3)
                                                        @if($value->order_status == 1)
                                                            {{'Order Placed'}}
                                                        @elseif($value->order_status == 2)
                                                            {{'Order Dispatched'}}
                                                        @elseif($value->order_status == 3)
                                                            {{'Order Delivered'}}
                                                        @elseif($value->order_status == 4)
                                                            {{'Order Completed'}}
                                                        @elseif($value->order_status == 5)
                                                            {{'Order Cancelled'}}
                                                        @else
                                                            {{'----'}}
                                                        @endif
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                <div class="td-action">
                                                     @if($logged)
                                                    @if($logged->user_type == 1)
                                                        <a href="{{ route('edit_orders', ['id' => $value->id]) }}" title="Edit" class="td-edt">
                                                            <i class="fa fa-edit fa-2x"></i>
                                                        </a>
                                                        
                                                        <a href="{{ route('view_orders', ['id' => $value->id]) }}" id="{{$value->id}}" class="gj_mge_all_orders_sview td-vw" title="View">
                                                            <i class="fa fa-eye fa-2x"></i>
                                                        </a>
                                                        <a href="#" id="{{$value->id}}" class="gj_mge_all_orders_del td-dlt" title="Delete">
                                                            <i class="fa fa-trash fa-2x"></i>
                                                        </a>
                                                        @if($value->order_status != 4 && $value->order_status != 5)
                                                            <a href="{{ route('delivery_orders', ['id' => $value->id]) }}" title="Delivered" class="td-vh">
                                                                <i class="fa fa-truck fa-2x"></i>
                                                            </a>
                                                        @endif
                                                    @elseif($logged->user_type == 2 || $logged->user_type == 3)
                                                        <a href="{{ route('view_orders', ['id' => $value->id]) }}" id="{{$value->id}}" class="gj_mge_all_orders_sview td-vw" title="View">
                                                            <i class="fa fa-eye fa-2x"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                                </div>
                                               
                                            </td>
                                        </tr>
                                        @php ($i = $i+1) @endphp
                                    @endforeach
                                @endif
                            </tbody>
                           <!--<tfoot>-->
                           <!--     <tr>-->
                           <!--         <td colspan="6" style="text-align: right;"><strong>Total Rang Price:</strong></td>-->
                           <!--         <td><strong>{{ number_format($totalRangPrice, 2) }}</strong></td>-->
                           <!--     </tr>-->
                           <!--     <tr>-->
                           <!--         <td colspan="9" style="text-align: right;"><strong>Total Profit:</strong></td>-->
                           <!--         <td><strong>{{ number_format($totalProfit, 2) }}</strong></td>-->
                           <!--     </tr>-->
                           <!-- </tfoot>-->
                        </table>
                        </div>

                        
                    </div>

                   
                </div>
             </div>

                

               
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>


<script>
    $(document).on('change', '.gj_tracking_input', function() {
        var orderId = $(this).data('order-id');
        var trackingId = $(this).val();

        $.ajax({
            url: '{{ route("orders.update.tracking") }}', // create this route
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                order_id: orderId,
                tracking_id: trackingId
            },
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
            },
            error: function() {
                alert('Server error occurred.');
            }
        });
    });
</script>

<script>
    $(document).on('change', '.gj_add_discount_input', function() {
        var orderId = $(this).data('order-id');
        var additional_discount = $(this).val();

        $.ajax({
            url: '{{ route("orders.update.additional.discount") }}', // create this route
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                order_id: orderId,
                additional_discount: additional_discount
            },
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
            },
            error: function() {
                alert('Server error occurred.');
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const orderStatusDropdown = document.getElementById('gj_srh_odr_sts');

        orderStatusDropdown.addEventListener('change', function () {
            this.form.submit(); // auto submit the form when dropdown changes
        });
    });
</script>
    <script>
        $(document).ready(function() { 
            $('#gj_mge_all_orders_table').DataTable({
                "paginate": true,
                "searching": false,
                "bInfo" : true,
                "sort": true,
                "ordering": true,
                "lengthChange": true, 
            });
        });

        $(document).ready(function () {
            $("#ckbCheckAll").click(function () {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });
            
            $(".checkBoxClass").change(function(){
                if (!$(this).prop("checked")){
                    $("#ckbCheckAll").prop("checked",false);
                }
            });

            $('p.alert').delay(5000).slideUp(500);
            $("#download_csv").hide();
        });

        $('#Delete_value').on('click',function(){
            var all = [];
            $("input:checkbox[class=checkBoxClass]:checked").each(function () {
                all.push($(this).val());
            });
            if (all.length === 0) {
                $.confirm({
                    title: '',
                    content: 'Please select atleast one Item by ticking the check box',
                    icon: 'fa fa-exclamation',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'purple',
                    buttons: {
                        Ok: function(){
                        }
                    }
                });
            } else {
                $.confirm({
                    title: '',
                    content: 'Are You Sure to Delete?',
                    icon: 'fa fa-trash-o',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'blue',
                    buttons: {
                        Yes: function(){
                            $.ajax({
                                type: 'post',
                                url: '{{url('/delete_all_orders')}}',
                                data: {ids: all, type: 'delete_all_orders'},
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
                        },
                        No:function() {
                        }
                    }
                });
            }
        });

        $('.gj_mge_all_orders_del').on('click',function(){
            var id = 0;
            if($(this).attr('id')) {
                id = $(this).attr('id');
            }

            $.confirm({
                title: '',
                content: 'Are You Sure to Delete?',
                icon: 'fa fa-trash-o',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'blue',
                buttons: {
                    Yes: function(){
                        $.ajax({
                            type: 'post',
                            url: '{{url('/delete_orders')}}',
                            data: {id: id, type: 'delete'},
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
                    },
                    No:function() {
                    }
                }
            });
        });

        $('.gj_odr_sts').on('change',function(){
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
                url: '{{url('/status_orders')}}',
                data: {id: id, status: status, type: 'staus_change'},
                success: function(data){
                    if(data == 0){
                        window.location.reload();
                    } else {
                        // $.confirm({
                        //     title: '',
                        //     content: 'No Action Performed!',
                        //     icon: 'fa fa-exclamation',
                        //     theme: 'modern',
                        //     closeIcon: true,
                        //     animation: 'scale',
                        //     type: 'purple',
                        //     buttons: {
                        //         Ok: function(){
                                    window.location.reload();
                        //         }
                        //     }
                        // });
                    }
                }
            });
        });

        $('.gj_paid_sts').on('change',function(){
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
                url: '{{url('/paymentstatus_orders')}}',
                data: {id: id, status: status, type: 'staus_change'},
                success: function(data){
                    window.location.reload();
                }
            });
        });
    </script>

    <!-- Export Script Start -->
    <script type="text/javascript">
        $('#export_csv').on('click',function(){
            var all = [];
            $("input:checkbox[class=checkBoxClass]:checked").each(function () {
                all.push($(this).val());
            });
            if (all.length === 0) {
                $.confirm({
                    title: '',
                    content: 'Please select atleast one Item by ticking the check box',
                    icon: 'fa fa-exclamation',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'purple',
                    buttons: {
                        Ok: function(){
                        }
                    }
                });
            } else {
                $.ajax({
                    type: 'post',
                    url: '{{url('/export_csv_order')}}',
                    data: {ids: all, type: 'export'},
                    success: function(response){
                        if(response){
                            // $("#download_csv").show();
                            // $("#download_csv").attr("href", response);
                            window.location.href = "<?php echo route('home'); ?>/" + response;
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
                        $(function () {
                            setTimeout(function() {
                                window.location.reload();
                            }, 5000);
                        });
                    }
                });
            }
        });
    </script>
    <!-- Export Script End -->

    <!-- Export CSV ALL Script Start -->
    <script type="text/javascript">
        $('#export_all_csv').on('click',function() {
            $.ajax({
                type: 'post',
                url: '{{url('/export_csv_order')}}',
                data: {type: 'export_all'},
                success: function(response){
                    if(response){
                        window.location.href = "<?php echo route('home'); ?>/" + response;
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
    </script>
    <!-- Export CSV ALL Script End -->
    <script>
    document.getElementById("downloadPdfBtn").addEventListener("click", function () {
        const allRows = document.querySelectorAll("#gj_mge_all_orders_table tbody tr");
        const checkedBoxes = document.querySelectorAll(".checkBoxClass:checked");

        const tempTable = document.createElement("table");
        tempTable.className = "table table-bordered table-striped width-tb-cs";

        const thead = document.querySelector("#gj_mge_all_orders_table thead").cloneNode(true);
        tempTable.appendChild(thead);

        const tbody = document.createElement("tbody");

        if (checkedBoxes.length > 0) {
            checkedBoxes.forEach(box => {
                const row = box.closest("tr").cloneNode(true);
                tbody.appendChild(row);
            });
        } else {
            allRows.forEach(row => {
                const clonedRow = row.cloneNode(true);
                tbody.appendChild(clonedRow);
            });
        }

        tempTable.appendChild(tbody);

        const wrapper = document.createElement("div");
        wrapper.style.width = "1500px";
        wrapper.style.overflow = "auto";
        wrapper.appendChild(tempTable);

        const style = document.createElement("style");
        style.textContent = `
            table {
                width: 100%;
                border-collapse: collapse;
                table-layout: auto;
                font-size: 10px;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 6px 8px;
                word-wrap: break-word;
            }
        `;
        wrapper.appendChild(style);

        const opt = {
            margin:       0.5,
            filename:     'all-orders-list.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'a3', orientation: 'landscape' }
        };

        html2pdf().from(wrapper).set(opt).save();
    });
</script>
@endsection