@extends('layouts.master')
@section('title', 'Manage Cancel All Orders')
@section('content')
<style>
      .container-field .dataTables_filter input, .container-field .dataTables_length select {
    margin-left: 10px;
}
</style>

@php ($logged = session()->get('user'))
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
                         <h3 class="gj_heading" style="margin-bottom:7px;"> Manage Cancelled Orders  </h3>
                     </div>
                     <div class="col-lg-12">
                    <div class="table-responsive gj_manage_all_orders mob-row-flex">
                        <table class="table table-bordered table-striped" id="gj_mge_all_orders_table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <!--<th>#</th>-->
                                    <th>Order Code</th>
                                    <th>Order Date</th>
                                    <th>Cancel Date</th>
                                    <th>Customer Name</th>
                                    <th>Total Items</th>
                                    <th>Price Paid</th>
                                    <th>Payment</th>
                                    <th>Order Status</th>
                                    <th>Status</th>
                                    <th>Refund Status</th>
                                </tr>
                            </thead>
                            <tbody id="gj_mge_all_orders_bdy">
                                @if($orders)
                                    @php ($i = 1)
                                    
                                    @foreach($orders as $key => $value)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <!--<td><input type="checkbox" name="check[]" class="checkBoxClass" value="{{$value->id}}" id="Checkbox{{$i}}" /></td>-->
                                            <td>{{$value->order_code}}</td>
                                            <td>{{ date('d-m-Y', strtotime($value->order_date)) }}</td>
                                            <td>{{ date('d-m-Y', strtotime($value->cancel_date)) }}</td>
                                            <td>{{$value->contact_person}}</td>
                                            <td>{{$value->total_items}}</td>
                                            <td>{{$value->net_amount}}</td>
                                            <td>
                                                {{--<p class="gj_p_met text-center">
                                                    @if($value->payment_mode == 1)
                                                        {{'COD'}}
                                                    @elseif($value->payment_mode == 2)
                                                        {{'Online'}}
                                                    @else
                                                        {{'----'}}
                                                    @endif
                                                </p> --}}

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
                                            </td>
                                            <td>
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
                                            </td>

                                            <td>
                                                @if($value->cancel_approved == 1)
                                                    {{'Accept'}}
                                                @elseif($value->cancel_approved == 2)
                                                    {{'Reject'}}
                                                @elseif($value->cancel_approved == 3)
                                                    {{'Process'}}
                                                @else
                                                    {{'----'}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($value->refund_status == 'complete')
                                                    <span class=" text-success">Complete</span>
                                                @else
                                                    <select name="refund_sts" id="refund_sts" data-ord-id="{{ $value->id }}" class="form-control gj_paid_sts">
                                                        <option value="pending" @if($value->refund_status == 'pending') selected @endif>Pending</option>
                                                        <option value="complete" @if($value->refund_status == 'complete') selected @endif>Complete</option>
                                                    </select>
                                                @endif
                                            </td>
                                        </tr>
                                        @php ($i = $i+1)
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
                 </div>
                
                
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() { 
        $('#gj_mge_all_orders_table').dataTable({
            "paginate": true,
            "searching": true,
            "bInfo" : true,
            "sort": true
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
                content: 'Please Select atleast one check box!',
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
                    Ok: function(){
                        $.ajax({
                            type: 'post',
                            url: '{{url('/delete_all_orders')}}',
                            data: {ids: all, type: 'unblock'},
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
                    Cancel:function() {
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
                Ok: function(){
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
                Cancel:function() {
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
            url: '{{url('/refundstatus_orders')}}',
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
                content: 'Please Select atleast one check box!',
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
                        $("#download_csv").show();
                        $("#download_csv").attr("href", response);
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
@endsection