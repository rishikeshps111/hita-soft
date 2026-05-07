@extends('layouts.master')
@section('title', 'Manage Sub Category')
@section('content')
<section class="gj_email_setting">
   <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
            @include('layouts.sidebar')
        </div>

        <div class="col-lg-10 ">

            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
               
                  <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                         <div class="col-lg-12 ">
                             <div class="back-container">
                             <h3 class="gj_heading"> Manage Sub Category  </h3>
                             <a href="javascript:history.back()" class="btn btn-outline-secondary" >
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                              <div class="gj_manage_filter  mt__3 top-btns">
                                    <span class="gj_squaredFour">
                                        <input type="checkbox" id="ckbCheckAll" name="ckbCheckAll" />
                                        <label for="ckbCheckAll">Check all</label>
                                    </span>
                                    <button class="btn btn-primary" id="Block_value" type="button">Block</button>
                                    <button class="btn btn-warning" id="UNBlock_value" type="button">Un Block</button>          
                                </div>
                         </div>
                         <div class="col-md-12">
                    <div class="table-responsive gj_manage_cnty mob-row-flex">
                        <table class="table table-bordered table-striped" id="gj_mge_sub_cat_table">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>#</th>
                                    <th>Main Category Name</th>
                                    <th>Sub Category Name</th>
                                    <th class="gj_mge_sc_img_th">Sub Category Image</th>
                                    <th>No of Products</th>
                                    <!--<th>Add Sub Sub Category</th>-->
                                    <!--<th>Manage Sub Sub Category</th>-->
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="gj_mge_msc_bdy">
                                @if($sub_cats)
                                    @php ($i = 1)
                                    <?php 
                                    $file_path = 'images/sub_cat_image';
                                    $no_file_path = 'images/noimage';
                                    $no_images = \DB::table('noimage_settings')->first();
                                    $images = "";
                                    if($no_images) {
                                        $images =  $no_file_path.'/'.$no_images->category_no_image;
                                    }
                                    ?>
                                    @foreach($sub_cats as $key => $value)
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td><input type="checkbox" name="check[]" class="checkBoxClass" value="{{$value->sub_cat_id}}" id="Checkbox{{$i}}" /></td>
                                            <td>{{$value->main_cat_name}}</td>
                                            <td>{{$value->sub_cat_name}}</td>
                                            <td class="gj_mge_sc_img_td">
                                                @if($value->sub_cat_image)
                                                    <a href="{{ asset($file_path.'/'.$value->sub_cat_image)}}" target="_blank"><img src="{{ asset($file_path.'/'.$value->sub_cat_image)}}" class="img-responsive gj_mge_sc_img"></a>
                                                @else 
                                                    <a href="{{ asset($images)}}" target="_blank"><img src="{{ asset($images)}}" class="img-responsive gj_mge_sc_img"></a>
                                                @endif
                                            </td>
                                            <td>{{ $value->products->count() }}</td>
                                            <!--<td>-->
                                            <!--    <a href="{{ route('add_sub_sub_category', ['id' => $value->sub_cat_id]) }}" data-tooltip="Add Main Category">-->
                                            <!--        <i class="fa fa-plus fa-2x"></i>-->
                                            <!--    </a>-->
                                            <!--</td>-->
                                            <!--<td>-->
                                            <!--    <a href="{{ route('manage_sub_sub_category', ['id' => $value->sub_cat_id]) }}" data-tooltip="Manage Main Category">-->
                                            <!--        <i class="fa fa-shopping-cart fa-2x"></i>-->
                                            <!--        <span class="gj_cnt_sc">( {{$value->sub_sub}} ) Categories </span>-->
                                            <!--    </a>-->
                                            <!--</td>-->
                                            <td>
                                                <a href="{{ route('edit_sub_category', ['id' => $value->sub_cat_id]) }}" data-tooltip="Edit" class="td-edt">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>
                                            </td>
                                            <td>
                                                 <a href="#" id="{{$value->sub_cat_id}}" class="gj_mge_bi_del td-dlt" data-tooltip="Delete">
                                                    <i class="fa fa-trash fa-2x"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('status_sub_category', ['id' => $value->sub_cat_id]) }}" data-tooltip="block">
                                                    @if($value->is_block == 1)
                                                        <i class="gj_ok fa fa-check fa-2x"></i>
                                                    @else
                                                        <i class="gj_danger fa fa-ban fa-2x"></i>
                                                    @endif
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
</section>

<script>
    $(document).ready(function() { 
        $('#gj_mge_sub_cat_table').dataTable({
            "paginate": true,
            "searching": true,
            "bInfo" : false,
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
                url: '{{url('/sub_category_block')}}',
                data: {ids: all, type: 'block'},
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
                url: '{{url('/sub_category_unblock')}}',
                data: {ids: all, type: 'unblock'},
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
        }
    });
     $('.gj_mge_bi_del').on('click',function(){
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
                        url: '{{url('/delete_sub_category_image')}}',
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
</script>
@endsection