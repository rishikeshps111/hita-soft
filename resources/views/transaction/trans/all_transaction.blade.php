@extends('layouts.master')
@section('title', 'Manage All Transaction')
@section('content')
<style>
    .container-field form{
        margin-top:0;
    }
    .container-field form input,.container-field input,.container-field form select,.container-field select{
        height:37px;
        padding-left:10px;
    }
    
       table tr th {
            min-width: 101px;
            text-align: center !important;
        }
        
        .width-tb-cs tr td.wd-200 {
            min-width: 120px !important;
        }
        .pagination{
    display:flex;
}
        @media screen and (max-width:567px){
            .date-filter-mob,.dataTables_wrapper{
                padding:10px !important;
            }
        }
    
</style>

@php ($logged = session()->get('user'))
<section class="gj_all_transaction_setting">
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
                          <h3 class="gj_heading"> Manage All Transaction  </h3>
                           <div class="gj_manage_filter mt__3 top-btns">
                    @if($logged)
                        @if($logged->user_type == 1)
                            <span class="gj_squaredFour">
                                <input type="checkbox" id="ckbCheckAll" name="ckbCheckAll" />
                                <label for="ckbCheckAll">Check all</label>
                            </span>
                            <button class="btn btn-danger" id="Delete_value" type="button">Delete</button>          
                            <button class="btn btn-info" id="export_csv" type="button">Export CSV</button>
                            <button class="btn btn-info" id="export_all_csv" type="button">Export All CSV</button>
                            <a href="#" id="download_csv"><button class="btn btn-info" id="export_csv_but" type="button">Download CSV</button></a>
                        @elseif($logged->user_type == 2 || $logged->user_type == 3)
                            <span class="gj_squaredFour">
                                <input type="checkbox" id="ckbCheckAll" name="ckbCheckAll" />
                                <label for="ckbCheckAll">Check all</label>
                            </span>
                            <button class="btn btn-info" id="export_csv" type="button">Export CSV</button>
                            <button class="btn btn-info" id="export_all_csv" type="button">Export All CSV</button>
                            <a href="#" id="download_csv"><button class="btn btn-info" id="export_csv_but" type="button">Download CSV</button></a>
                        @endif
                    @endif
                </div>
                     </div>
                     <div class="col-md-12">
                    <div class=" gj_manage_all_trans">
                        <div class="gj_cs_srh_div  " style="position:static;">
                            <form action="{{ route('search_trans') }}" method="GET" class="gj_search_trans_form formtop-cs-tb date-filter-mob" enctype="multipart/form-data">
                            @csrf
                                <input type="date" name="gj_srh_trans_date" id="gj_srh_trans_date" class="gj_srh_trans_date">
                                <input type="text" name="gj_srh_trans_code" id="gj_srh_trans_code" class="gj_srh_trans_code" placeholder="Search By Transaction Code">
                                <input type="text" name="gj_srh_odr_code" id="gj_srh_odr_code" class="gj_srh_odr_code" placeholder="Search By Order Code">
                                <select id="gj_srh_odr_sts" name="gj_srh_odr_sts" class="gj_srh_odr_sts">
                                    <option value=""> Select Order Status </option>
                                    <option value="1"> Order Placed </option>
                                    <option value="2"> Order Dispatched </option>
                                    <option value="3"> Order Delivered </option>
                                    <option value="4"> Order Completed </option>
                                    <option value="5"> Order Cancelled </option>
                                </select>
                                <button type="submit" class="gj_srh_subm btn btn-primary" id="gj_srh_trans_subm">Search</button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="gj_mge_all_trans_table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>#</th>
                                    <th>T-Code</th>
                                    <th>O-Code</th>
                                    <th>Customer</th>
                                    <th>Total Items</th>
                                    <th>Price Paid</th>
                                    <th>Payment Type</th>
                                    <th>Payment Status</th>
                                    <th>Payment Date</th>
                                    <th>Order Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="gj_mge_all_trans_bdy">
                                @if($trans)
                                    @php ($i = 1)
                                    
                                    @foreach($trans as $key => $value)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td><input type="checkbox" name="check[]" class="checkBoxClass" value="{{$value->id}}" id="Checkbox{{$i}}" /></td>
                                            <td>{{$value->trans_code}}</td>
                                            <td>
                                                @if($value['orders'])
                                                    {{$value['orders']->order_code}}
                                                @else
                                                    {{'-------'}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($value['orders'])
                                                    {{$value['orders']->contact_person}}
                                                @else
                                                    {{'-------'}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($value['orders'])
                                                    {{$value['orders']->total_items}}
                                                @else
                                                    {{'-------'}}
                                                @endif
                                            </td>
                                            <td>{{$value->net_amount}}</td>
                                            <td>
                                                @if ($value->paymentmode == 1)
                                                    {{'COD'}}
                                                @elseif ($value->paymentmode == 2)
                                                    PhonePe
                                                @elseif ($value->paymentmode == 3)
                                                    COP
                                                 @elseif ($value->paymentmode == 4)
                                                    Easebuzz   
                                                @else
                                                    {{'-------'}}
                                                @endif
                                            </td>
                                            <td>{{$value->trans_status}}</td>
                                            <td>{{ date('d-m-Y H:i:s', strtotime($value->trans_date)) }}</td>
                                            <td>
                                                @if($value['orders'])
                                                    @if ($value['orders']->order_status == 1)
                                                        {{'Order Placed'}}
                                                    @elseif ($value['orders']->order_status == 2)
                                                        {{'Order Dispatched'}}
                                                    @elseif ($value['orders']->order_status == 3)
                                                        {{'Order Delivered'}}
                                                    @elseif ($value['orders']->order_status == 4)
                                                        {{'Order Completed'}}
                                                    @elseif ($value['orders']->order_status == 5)
                                                        {{'Order Cancelled'}}
                                                    @else
                                                        {{'-------'}}
                                                    @endif
                                                @else
                                                    {{'-------'}}
                                                @endif
                                            </td>
                                            <td>
                                                <div class="td-action">
                                                     @if($logged)
                                                    @if($logged->user_type == 1)
                                                        <a href="{{ route('view_transaction', ['id' => $value->id]) }}" id="{{$value->id}}" class="gj_mge_all_trans_sview td-vw" title="View">
                                                            <i class="fa fa-eye fa-2x"></i>
                                                        </a>
                                                        <a href="#" id="{{$value->id}}" class="gj_mge_all_trans_del td-dlt" title="Delete" >
                                                            <i class="fa fa-trash fa-2x"></i>
                                                        </a>
                                                    @elseif($logged->user_type == 2 || $logged->user_type == 3)
                                                        <a href="{{ route('view_transaction', ['id' => $value->id]) }}" id="{{$value->id}}" class="gj_mge_all_trans_sview td-vw " title="View">
                                                            <i class="fa fa-eye fa-2x"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                                </div>
                                               
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
    </div>
</section>

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
        $('#gj_mge_all_trans_table').dataTable({
            "paging": true,
            "searching": false,
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

        $('p.alert').delay(2000).slideUp(300);
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
                            url: '{{url('/delete_all_trans')}}',
                            data: {ids: all, type: 'all_delete'},
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

    $('.gj_mge_all_trans_del').on('click',function(){
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
                        url: '{{url('/delete_trans')}}',
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
                url: '{{url('/export_csv_trans')}}',
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

<!-- Export CSV ALL Script Start -->
    <script type="text/javascript">
        $('#export_all_csv').on('click',function() {
            $.ajax({
                type: 'post',
                url: '{{url('/export_csv_trans')}}',
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
@endsection
