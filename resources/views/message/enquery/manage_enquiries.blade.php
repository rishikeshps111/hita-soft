@extends('layouts.master')
@section('title', 'Manage Enqueries')
@section('content')
<style>
      .container-field .dataTables_filter input, .container-field .dataTables_length select {
    margin-left: 10px;
}

.container-field table tr th, .container-field table tr td {
    max-width: 390px !important;
}

.filter-row {
    display: flex;
    align-items: center;
    gap: 10px; /* spacing between select and button */
}

.filter-row select {
    padding: 6px 10px;
    font-size: 14px;
}

.reset-btn {
    display: inline-block;
    padding: 6px 12px;
    background-color: #6c757d; /* gray */
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    font-size: 14px;
}

.reset-btn:hover {
    background-color: #5a6268;
}

</style>
<section class="gj_enquiries_setting">
     <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
  @include('layouts.message_sidebar')
        </div>

        <div class="col-lg-10 ">


            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                    <div class="col-lg-12">
                         <h3 class="gj_heading"> Manage Enqueries  </h3>
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
                    <div class="gj_manage_enquiries">
                        {{--<div class="gj_cs_srh_div filter-row " style="position:static;">
                            <form action="{{ route('search_enquiry') }}" method="GET" class="gj_search_trans_form formtop-cs-tb" enctype="multipart/form-data">
                            @csrf
                                <select id="gj_srh_odr_sts" name="gj_srh_odr_sts" class="gj_srh_odr_sts">
                                    <option value=""> Select </option>
                                    <option value="all"> All </option>
                                    <option value="enquiry"> Enquiry</option>
                                    <option value="testimonial"> Brand Review</option>
                                </select>
                            </form>
                            <a href="{{ route('manage_enquiries') }}" class="btn btn-primary ms-2">Reset</a>
                        </div>--}}
                        <div class="table-responsive mob-row-flex">
                            <table class="table table-bordered table-striped" id="gj_mge_enquiries_table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>#</th>
                                    <!--<th>Review Type</th>-->
                                    <th>Name</th>
                                    <th>E-Mail</th>
                                    <th>Subject</th>
                                    <!--<th>Status</th>-->
                                    <th>View</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="gj_mge_enquiries_bdy">
                                @if($enquiries)
                                    @php ($i = 1)
                                    
                                    @foreach($enquiries as $key => $value)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td><input type="checkbox" name="check[]" class="checkBoxClass" value="{{$value->id}}" id="Checkbox{{$i}}" /></td>
                                            <!--<td> @if($value->review_type=='enquiry') -->
                                            <!--Enquiry-->
                                            <!--@else-->
                                            <!--Brand Review-->
                                            <!--@endif-->
                                            <!--</td>-->
                                            <td>{{$value->contact_name}}</td>
                                            <td>{{$value->contact_email}}</td>
                                            <td>{{$value->subject}}</td>
                                            {{--<td>
                                                <a href="{{ route('status_enquiries', ['id' => $value->id]) }}" data-tooltip="block" >
                                                    @if($value->is_block == 1)
                                                        <i class="gj_ok fa fa-check fa-2x"></i>
                                                    @else
                                                        <i class="gj_danger fa fa-ban fa-2x"></i>
                                                    @endif
                                                </a>
                                            </td>--}}
                                            <td>
                                                <a href="{{ route('view_enquiries', ['id' => $value->id]) }}" data-tooltip="block" class="td-vw">
                                                    <i class="gj_view fa fa-eye fa-2x"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="#" id="{{$value->id}}" class="gj_mge_enquiries_del td-dlt" data-tooltip="Delete" class="td-dlt">
                                                    <i class="fa fa-trash fa-2x"></i>
                                                </a>
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
        $('#gj_mge_enquiries_table').dataTable({
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
                url: '{{url('/enquiries_block')}}',
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
                url: '{{url('/enquiries_unblock')}}',
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
                            url: '{{url('/delete_enquiries_all')}}',
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

    $('.gj_mge_enquiries_del').on('click',function(){
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
                        url: '{{url('/delete_enquiries')}}',
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
