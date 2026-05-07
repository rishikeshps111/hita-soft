@extends('layouts.master')
@section('title', 'Manage Cancel Order Request')
@section('content')
<style>
      .container-field .dataTables_filter input, .container-field .dataTables_length select {
    margin-left: 10px;
}
 .pagination{
    display:flex;
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
                    <div class="alert {{ Session::get('alert-class', 'alert-info') }}" id="session-alert">
                        {{ Session::get('message') }}
                    </div>
                @endif
                <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                    <div class="col-lg-12">
                         <h3 class="gj_heading"> Manage Cancel Order Requests  </h3>
                         <div class="gj_manage_filter mt__3 top-btns">
                             <span class="gj_squaredFour">
                                <input type="checkbox" id="ckbCheckAll" name="ckbCheckAll" />
                                <label for="ckbCheckAll">Check all</label>
                            </span>
                            <button class="btn btn-primary" id="approve_value" type="button">Approve</button> 
                             <button class="btn btn-primary" id="reject_value" type="button">Reject</button> 
                        </div>
                    </div>
                    <div class="col-md-12">
                    <div class="table-responsive gj_manage_all_orders mob-row-flex">
                        <table class="table table-bordered table-striped" id="gj_mge_all_orders_table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>#</th>
                                    <th>Order Code</th>
                                    <th>Order Date</th>
                                    <th>Request Date</th>
                                    <th>Customer Name</th>
                                    <th>Total Items</th>
                                    <th>Price Paid</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="gj_mge_all_orders_bdy">
                                @if($orders)
                                    @php ($i = 1)
                                    
                                    @foreach($orders as $key => $value)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td><input type="checkbox" name="check[]" class="checkBoxClass" value="{{$value->id}}" id="Checkbox{{$i}}" /></td>
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
                                                </p>--}}

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
                                                <a href="{{ route('cancel_req_accept', ['id' => $value->id]) }}" id="{{$value->id}}" class="gj_mge_all_orders_sview" title="Cancel Request Status">
                                                    <i class="fa fa-snowflake-o fa-2x"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @php ($i = $i+1)
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if($orders)
                        {{$orders->links()}}
                    @endif
                </div>
                </div>
               

                
            </div>
        </div>
    </div>
</section>

<script>
    // Auto-hide session alert after 3 seconds (3000 ms)
    setTimeout(function() {
        let alertBox = document.getElementById('session-alert');
        if (alertBox) {
            alertBox.style.transition = "opacity 0.5s ease";
            alertBox.style.opacity = '0';
            setTimeout(() => alertBox.remove(), 500); // remove from DOM after fade-out
        }
    }, 3000);
</script>

<script>
    document.getElementById("approve_value").addEventListener("click", function () {
        let selected = [];
        document.querySelectorAll(".checkBoxClass:checked").forEach(function (checkbox) {
            selected.push(checkbox.value);
        });

        if (selected.length === 0) {
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
        }else{
            $.confirm({
                    title: '',
                    content: 'Are you sure you want to approve the selected cancellation requests?',
                    icon: 'fa fa-check-o',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'blue',
                    buttons: {
                        Yes: function(){
                            $.ajax({
                                type: 'post',
                                url: '{{ route('approve.cancel.orders') }}',
                                data: {order_ids: selected},
                                    success: function(data){
                                       if (data.success && data.redirect) {
                                            fetch("{{ route('send.cancel-request.email') }}", {
                                                method: "POST",
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'Content-Type': 'application/json',
                                                },
                                                body: JSON.stringify({})
                                            })
                                            .then(res => res.json())
                                            .then(data => console.log('Email status:', data.status));
                                            window.location.href = data.redirect;
                                        }else {
                                            $.alert({
                                                title: 'Error',
                                                content: 'Something went wrong.',
                                                type: 'red'
                                            });
                                        }
                                    },
                                    error: function(xhr) {
                                        $.alert({
                                            title: 'Error!',
                                            content: 'Something went wrong. Please try again.',
                                            type: 'red'
                                        });
                                    }
                            });
                        },
                        No:function() {
                        }
                    }
                });
        }

    });
</script>

<script>
    document.getElementById("reject_value").addEventListener("click", function () {
        let selected = [];
        document.querySelectorAll(".checkBoxClass:checked").forEach(function (checkbox) {
            selected.push(checkbox.value);
        });

        if (selected.length === 0) {
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
        }else{
            $.confirm({
                    title: '',
                    content: 'Are you sure you want to reject the selected cancellation requests?',
                    icon: 'fa fa-check-o',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'blue',
                    buttons: {
                        Yes: function(){
                            $.ajax({
                                type: 'post',
                                url: '{{ route('reject.cancel.orders') }}',
                                data: {order_ids: selected},
                                    success: function(data){
                                       if (data.success && data.redirect) {
                                           fetch("{{ route('send.cancel-reject.email') }}", {
                                                method: "POST",
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'Content-Type': 'application/json',
                                                },
                                                body: JSON.stringify({})
                                            })
                                            .then(res => res.json())
                                            .then(data => console.log('Email status:', data.status));
                                            window.location.href = data.redirect;
                                        }else {
                                            $.alert({
                                                title: 'Error',
                                                content: 'Something went wrong.',
                                                type: 'red'
                                            });
                                        }
                                    },
                                    error: function(xhr) {
                                        $.alert({
                                            title: 'Error!',
                                            content: 'Something went wrong. Please try again.',
                                            type: 'red'
                                        });
                                    }
                            });
                        },
                        No:function() {
                        }
                    }
                });
        }

    });
</script>


<script>
    $(document).ready(function() { 
        $('#gj_mge_all_orders_table').dataTable({
            "paginate": false,
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
                            url: '{{url('/approve_cancel_orders')}}',
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