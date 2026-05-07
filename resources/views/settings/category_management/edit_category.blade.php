@extends('layouts.master')
@section('title', 'Edit Main Category')
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
               
                <div class="col-md-12">
                    <form action="{{ route('update_category') }}" method="POST" class="gj_geneal_form" enctype="multipart/form-data">
                     @csrf
                        @if($main)
                             <input type="hidden" name="mc_id" class="form-control gj_b_id" value="{{ $main->id }}" >

                        @endif
                         <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                             <div class="col-lg-12 back-container">
                                   <h3 class="gj_heading"> Edit Main Category  </h3>
                                   <a href="javascript:history.back()" class="btn btn-secondary" style="margin-left:auto;">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </a>
                             </div>
                             <div class="form-group col-lg-6">
                            <label for="main_cat_name">Main Category Name</label>
                            <span class="error">* 
                                @if ($errors->has('main_cat_name'))
                                    {{ $errors->first('main_cat_name') }}
                                @endif
                            </span>
                            <input type="text" name="main_cat_name" class="form-control gj_main_cat_name" placeholder="Enter Category Name In English"  value="{{ $main->main_cat_name ? $main->main_cat_name : old('main_cat_name') }}" >

                        </div>
                        
                        
                        <div class="form-group col-lg-6">
                            <label for="main_cat_name"> Category Description</label>
                            <span class="error">* 
                                @if ($errors->has('main_cat_desc'))
                                    {{ $errors->first('main_cat_desc') }}
                                @endif
                            </span>
                            <input type="text" name="main_cat_desc" class="form-control gj_main_cat_name" placeholder="Enter Category Description"  value="{{ $main->main_cat_desc ? $main->main_cat_desc : old('main_cat_desc') }}" >

                        </div>

                        <!--<div class="form-group">-->
                        {{--    {{ Form::label('main_cat_icon', 'Main Category Icon') }}--}}
                        <!--    <span class="error">* -->
                        <!--        @if ($errors->has('main_cat_icon'))-->
                        <!--            {{ $errors->first('main_cat_icon') }}-->
                        <!--        @endif-->
                        <!--    </span>-->
                        <!--    <p class="gj_ex_ph">Example: fa-user </p>-->

                        {{--    {{ Form::text('main_cat_icon', ($main->main_cat_icon ? $main->main_cat_icon : Input::old('main_cat_icon')), array('class' => 'form-control gj_main_cat_icon','placeholder' => 'Enter Category Icon In Under the List')) }}--}}
                        <!--    <p class="gj_lt_fa">View Icon Codes : <button type="button" class="gj_lt_icons" data-toggle="modal" data-target="#myModal">FontAwesome Icons</button></p>-->

                            <!-- Modal -->
                        <!--    <div class="modal fade" id="myModal" role="dialog">-->
                        <!--        <div class="modal-dialog">-->
                                    <!-- Modal content-->
                        <!--            <div class="modal-content">-->
                        <!--                <div class="modal-header">-->
                        <!--                    <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                        <!--                    <h4 class="modal-title">FontAwesome Icons</h4>-->
                        <!--                </div>-->
                        <!--                <div class="modal-body">-->
                        <!--                    @include('layouts.icons')-->
                        <!--                </div>-->
                        <!--                <div class="modal-footer">-->
                        <!--                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->

                        <!--<div class="form-group">-->
                        {{--    {{ Form::label('priority', 'Priority') }}--}}
                        <!--    <span class="error">* -->
                        <!--        @if ($errors->has('priority'))-->
                        <!--            {{ $errors->first('priority') }}-->
                        <!--        @endif-->
                        <!--    </span>-->

                        {{--    {{ Form::number('priority', ($main->priority ? $main->priority : Input::old('priority')), array('class' => 'form-control gj_priority','placeholder' => 'Enter Priority In Number')) }}--}}
                        <!--</div>-->

                        <div class="form-group col-lg-12">
                            <label for="is_top_cat">Top Category</label>
                            <span class="error">* 
                                @if ($errors->has('is_top_cat'))
                                    {{ $errors->first('is_top_cat') }}
                                @endif
                            </span>

                            <div class="gj_py_ro_div">
                                <span class="gj_py_ro">
                                    <input type="radio" <?php if($main->is_top_cat == 1) { echo "checked"; } ?> name="is_top_cat" value="1"> Yes
                                </span>
                                <span class="gj_py_ro">
                                    <input type="radio" <?php if($main->is_top_cat == 0) { echo "checked"; } ?> name="is_top_cat" value="0"> No
                                </span>
                            </div>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="is_block">Category Staus</label>
                            <span class="error">* 
                                @if ($errors->has('is_block'))
                                    {{ $errors->first('is_block') }}
                                @endif
                            </span>

                            <div class="gj_py_ro_div">
                                <span class="gj_py_ro">
                                    <input type="radio" <?php if($main->is_block == 1) { echo "checked"; } ?> name="is_block" value="1"> Active
                                </span>
                                <span class="gj_py_ro">
                                    <input type="radio" <?php if($main->is_block == 0) { echo "checked"; } ?> name="is_block" value="0"> Deactive
                                </span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="gj_ban_img_whole">
                            <?php 
                            $file_path = 'images/main_cat_image';
                            ?>
                            @if(isset($main))
                                @if($main->main_cat_image !='')
                                <div class="form-group">
                                    <label for="current_main_cat_image">Current Main Category Image</label>
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($file_path.'/'.$main->main_cat_image)}}" class="img-responsive"> 
                                    </div>
                                     <input type="hidden" name="old_main_cat_image" class="form-control"  value="{{ $main->main_cat_image }}" >

                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                <label for="main_cat_image">Upload Main Category Image</label>
                                <span class="error"> 
                                    @if ($errors->has('main_cat_image'))
                                        {{ $errors->first('main_cat_image') }}
                                    @endif
                                </span>
                                <p class="gj_not" style="color:red"><em>image size must be 200 x 200 pixels</em></p>

                                <input type="file" name="main_cat_image" id="main_cat_image" accept="image/*" class="gj_main_cat_image">
                            </div>
                        </div>
                        </div>

                        <div class="gj_box dark gj_inside_box">
                            <!--<header>-->
                            <!--    <h5 class="gj_heading"> General Attributes  </h5>-->
                            <!--</header>-->
                            
                            
                        </div>
                         </div>

                        <div class="update-btn-box">
                            <input type="submit" class="btn btn-primary mx_auto" value="Update">
                        </div>

                         

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() { 
    });

  

    $('body').on('click','.gj_att_rem',function() {
        if(counter==1){
            $.confirm({
                title: '',
                content: 'No more textbox to remove!',
                icon: 'fa fa-ban',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'red',
                buttons: {
                    Ok: function(){
                    }
                }
            });
            return false;
        }   
    
        counter--;
        $(this).closest('tr').remove();
    });

    $('body').on('change','.gj_att_name',function() {
        var att_n = 0;
        if ($(this).val()) {
            att_n = $(this).val();
        }
        var ths = $(this);

        $.ajax({
            type: 'post',
            url: '{{url('/cat_select_att_vals')}}',
            data: {id: att_n, type: 'select_att_vals'},
            success: function(data){
                if(data != 0){
                    ths.closest('tr').find('.gj_attr_values').html(data);
                } else {
                    $.confirm({
                        title: '',
                        content: 'Select Another Attributes!',
                        icon: 'fa fa-exclamation',
                        theme: 'modern',
                        closeIcon: true,
                        animation: 'scale',
                        type: 'red',
                        buttons: {
                            Ok: function(){
                            }
                        }
                    });
                    // window.location.reload();
                }
            }
        });
    });

    var att_n = 0;
    $.each($(".gj_att_name option:selected"), function(){            
        if ($(this).val()) {
            att_n = $(this).val();
        }
        var old_id = $(this).closest('tr').find('.gj_old_attr_values').val();

        var ths = $(this);

        $.ajax({
            type: 'post',
            url: '{{url('/cat_select_att_vals')}}',
            data: {id: att_n, old_id: old_id, type: 'select_att_vals'},
            success: function(data){
                if(data != 0){
                    ths.closest('tr').find('.gj_attr_values').html(data);
                } else {
                    $.confirm({
                        title: '',
                        content: 'Select Another Attributes!',
                        icon: 'fa fa-ban',
                        theme: 'modern',
                        closeIcon: true,
                        animation: 'scale',
                        type: 'red',
                        buttons: {
                            Ok: function(){
                            }
                        }
                    });
                    // window.location.reload();
                }
            }
        });
    });
</script>
@endsection
