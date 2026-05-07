@extends('layouts.master')
@section('title', 'Manage User')
@section('content')
<style>
    .container-field .dataTables_filter input, .container-field .dataTables_length select {
    margin-left: 10px;
}
.pagination{
    display:flex;
}
</style>
<section class="gj_email_setting">
    <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
              @include('layouts.user_sidebar')
        </div>

        <div class="col-lg-10 ">
            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                 <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                     <div class="col-lg-12">
                          <h3 class="gj_heading"> Manage Admin Staff  </h3>
                           <div class="gj_manage_filter top-btns mt__3">
                    <span class="gj_squaredFour">
                        <input type="checkbox" id="ckbCheckAll" name="ckbCheckAll" />
                        <label for="ckbCheckAll">Check all</label>
                    </span>
                    {{--<button class="btn btn-primary" id="Block_value" type="button">Block</button>
                    <button class="btn btn-warning" id="UNBlock_value" type="button">Un Block</button>  --}}        
                    <button class="btn btn-danger" id="Delete_value" type="button">Delete</button>  
                   
                </div>
                     </div>
                     <div class="col-lg-12">
                    <div class="table-responsive gj_manage_user mob-row-flex">
                        <table class="table table-bordered table-striped" id="gj_mge_user_table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>#</th>
                                    <th>Name </th>
                                    <th>E-Mail</th>
                                    <th>Phone</th>
                                    <th>City</th>
                                    <th>Pincode</th>
                                    <!--<th>Country</th>-->
                                    <th>Status</th>
                                    <!--<th>Approved/Reject</th>-->
                                    <th>Actions</th>
                                    <th>User Type</th>
                                </tr>
                            </thead>
                            <tbody id="gj_mge_user_bdy">
                                @if($user)
                                    @php ($i = 1)
                                    
                                    @foreach($user as $key => $value)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td><input type="checkbox" name="check[]" class="checkBoxClass" value="{{$value->id}}" id="Checkbox{{$i}}" /></td>
                                            <td class="gj_m_n_e">
                                                <p class="gj_m_name">
                                                @if(!empty($value->first_name) || !empty($value->last_name))
                                                    {{ $value->first_name }} {{ $value->last_name }}
                                                @else
                                                    {{ $value->full_name }}
                                                @endif
                                                </p>
                                            </td>
                                            <td class="gj_m_n_e">
                                                <p class="gj_m_email">{{$value->email}}</p>
                                            </td>
                                            <td class="gj_m_n_e">
                                                <p class="gj_m_email">{{$value->phone}}</p>
                                            </td>
                                            <td>{{$value->address2}}</td>
                                            <td>{{$value->pincode}}</td>
                                            <!--<td>{{$value->country}}</td>-->
                                            <td>
                                                <a href="{{ route('status_user', ['id' => $value->id]) }}" 
                                                    @if($value->is_block == 1)
                                                        title="Block">
                                                        <i class="gj_ok fa fa-check fa-2x"></i>
                                                    @else
                                                        data-tooltip="Unblock">
                                                        <i class="gj_danger fa fa-ban fa-2x"></i>
                                                    @endif
                                                </a>
                                            </td>
                                            <!--<td>-->
                                            <!--    <a href="{{ route('approve_user', ['id' => $value->id]) }}" -->
                                            <!--        @if($value->is_approved == 1)-->
                                            <!--            title="Approved">-->
                                            <!--            <i class="gj_ok fa fa-check fa-2x"></i>-->
                                            <!--        @else-->
                                            <!--            data-tooltip="Reject">-->
                                            <!--            <i class="gj_danger fa fa-ban fa-2x"></i>-->
                                            <!--        @endif-->
                                            <!--    </a>-->
                                            <!--</td>-->
                                            <td>
                                               <div class="td-action">
                                                    <a href="{{ route('edit_user', ['id' => $value->id]) }}" title="Edit" class="td-edt">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>
                                                <!--<a href="{{ route('view_user', ['id' => $value->id]) }}" id="{{$value->id}}" class="gj_mge_user_vw" data-tooltip="View">-->
                                                <!--    <button><i class="fa fa-eye fa-2x"></i></button>-->
                                                <!--</a>-->
                                                <a href="#" id="{{$value->id}}" class="gj_mge_user_del td-dlt" title="Delete" >
                                                    <i class="fa fa-trash fa-2x"></i>
                                                </a>
                                               </div>
                                            </td>
                                            <td>
                                                @if($value->user_type == 1)
                                                    Admin
                                                @elseif($value->user_type == 2)
                                                    Admin Staff
                                                @elseif($value->user_type == 3)
                                                    Website Merchant
                                                @else
                                                    User
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

    $(document).ready(function () {
        $("#ckbCheckAll").click(function () {
            $(".checkBoxClass").prop('checked', $(this).prop('checked'));
        });
        
        $(".checkBoxClass").change(function(){
            if (!$(this).prop("checked")){
                $("#ckbCheckAll").prop("checked",false);
            }
        });

        $('p.alert').delay(1000).slideUp(300);
    });

    $('#Block_value').on('click',function(){
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
                url: '{{url('/user_block')}}',
                data: {ids: all, type: 'block'},
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
        }
    });

    $('#UNBlock_value').on('click',function(){
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
                url: '{{url('/user_unblock')}}',
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
        }
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
                            url: '{{url('/delete_user_all')}}',
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
                    No:function() {
                    }
                }
            });
        }
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
                        url: '{{url('/delete_user')}}',
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
