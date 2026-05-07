@extends('layouts.master')
@section('title', 'Manage Coupon')
@section('content')
<style>
    .container-field .dataTables_filter input, .container-field .dataTables_length select {
    margin-left: 10px;
}
</style>
<section class="gj_email_setting">  
     <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
              @include('layouts.coupon_sidebar')
        </div>

        <div class="col-lg-10 ">
            
             <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}" id="session-alert">{{ Session::get('message') }}</p>
                @endif
                 <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                     <div class="col-lg-12">
                          <h3 class="gj_heading"> Manage Coupon  </h3>
                           
                     </div>
                     <div class="col-lg-12">
                    <div class="table-responsive gj_manage_user mob-row-flex" style="margin-top:10px;">
                        <table class="table table-bordered table-striped" id="gj_mge_user_table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <!--<th>#</th>-->
                                    <th>Coupon Code </th>
                                    <th>Coupon Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Discount Value</th>
                                    <th>Usage Limit</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="gj_mge_user_bdy">
                                    @if($coupons)
                                    @php ($i = 1)
                                    
                                    @foreach($coupons as $key => $coupon)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <!--<td><input type="checkbox" name="check[]" class="checkBoxClass" value="{{$coupon->id}}" id="Checkbox{{$i}}" /></td>-->
                                            
                                            <td class="gj_m_n_e">{{$coupon->code}}</td>
                                            <td class="gj_m_n_e">
                                                @if($coupon->type=='fixed')
                                                Fixed amount
                                                @else
                                                Percentage discount
                                                @endif
                                            </td>
                                            <td>{{$coupon->start_date}}</td>
                                            <td><span class="text-danger">{{$coupon->end_date}}</span></td>
                                            <td>
                                                @if($coupon->type == 'fixed')
                                                    Rs. {{ $coupon->value }}
                                                @else
                                                    {{ $coupon->value }} %
                                                @endif
                                            </td>
                                            <td>{{$coupon->usage_limit}}</td>
                                            <td>
                                               <div class="td-action">
                                                <span>
                                                    <a href="{{ route('status_coupon', ['id' => $coupon->id]) }}" data-tooltip="block">
                                                        @if($coupon->status == 1)
                                                            <i class="gj_ok fa fa-check fa-2x"></i>
                                                        @else
                                                            <i class="gj_danger fa fa-ban fa-2x"></i>
                                                        @endif
                                                    </a>
                                                </span>
                                                <a href="{{ route('edit_coupons', ['id' => $coupon->id]) }}" title="Edit" class="td-edt">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>
                                                <a href="{{ route('redeem_list', ['id' => $coupon->id]) }}" title="Redeem List" class="btn btn-primary">
                                                    Redeem List
                                                </a>
                                                <a href="#" id="{{$coupon->id}}" class="gj_mge_user_del td-dlt" title="Delete" >
                                                    <i class="fa fa-trash fa-2x"></i>
                                                </a>
                                                <a href="{{ route('share_coupon_form', ['id' => $coupon->id]) }}" class="btn btn-success">
                                                    <i class="fa fa-share-alt"></i>
                                                </a>

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
</section>


<script>
    $(document).ready(function () {
        setTimeout(function () {
            $('#session-alert').fadeOut('slow');
        }, 3000); // 4000ms = 4 seconds
    });
</script>


<script> 
$(document).ready(function() { $('#user_id').on('change', function() 
{ 
    $('#gj_filter_pdts_form').submit();
    }); 
}); 
</script>
<script>
    $(document).ready(function() { 
        $('#gj_mge_user_table').dataTable({
            "paginate": true,
            "searching": true,
            "bInfo" : true,
            "sort": true
        });
    });
    
    $('.gj_mge_user_del').on('click',function(){
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
                        url: '{{url('/delete_coupons')}}',
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

@endsection

