@extends('layouts.master')
@section('title', 'Edit Sub Category')
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
                     <form action="{{route('update_sub_category')}}" class="gj_geneal_form" method="POST" enctype="multipart/form-data">
                                             @csrf
                        @if($sub_cats)
                        <input type="hidden" name="msc_id" class="form-control gj_b_id" value="{{ $sub_cats->sub_cat_id }}" >
                        @endif
                         <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                             <div class="col-lg-12">
                                  <h3 class="gj_heading"> Edit Sub Category  </h3>
                             </div>
                             <div class="form-group col-lg-6">
                            <label for="main_cat_name">Main Category Name </label>
                            <span class="error">* 
                                @if ($errors->has('main_cat_name'))
                                    {{ $errors->first('main_cat_name') }}
                                @endif
                            </span>
                            <input type="text" class="form-control shadow-none gj_h_main_cat_name" name="h_main_cat_name" value="{{$sub_cats->cat_name ? $sub_cats->cat_name : old('main_cat_name')}}" placeholder="Enter Category Name In English" disabled>
                             <input type="hidden" class="form-control shadow-none gj_main_cat_name" name="main_cat_name" value="{{$sub_cats->main_cat_name ? $sub_cats->main_cat_name : old('main_cat_name')}}" placeholder="Enter Category Name In English" >
                                                   
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="sub_cat_name">Sub Category Name</label>
                            <span class="error">* 
                                @if ($errors->has('sub_cat_name'))
                                    {{ $errors->first('sub_cat_name') }}
                                @endif
                            </span>
                            <input type="text" class="form-control shadow-none gj_sub_cat_name" name="sub_cat_name" value="{{$sub_cats->sub_cat_name ? $sub_cats->sub_cat_name : old('sub_cat_name')}}" placeholder="Enter Sub Category Name In English" >
                            
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
                                    <input type="radio" <?php if($sub_cats->is_block == 1) { echo "checked"; } ?> name="is_block" value="1"> Active
                                </span>
                                <span class="gj_py_ro">
                                    <input type="radio" <?php if($sub_cats->is_block == 0) { echo "checked"; } ?> name="is_block" value="0"> Deactive
                                </span>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="gj_ban_img_whole">
                            <?php 
                            $file_path = 'images/sub_cat_image';
                            ?>
                            @if(isset($sub_cats))
                                @if($sub_cats->sub_cat_image !='')
                                <div class="form-group">
                                    <label for="current_sub_cat_image">Current Sub Category Image</label>
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($file_path.'/'.$sub_cats->sub_cat_image)}}" class="img-responsive"> 
                                    </div>
                                     <input type="hidden" class="form-control shadow-none " name="old_sub_cat_image" value="{{$sub_cats->sub_cat_image ? $sub_cats->sub_cat_image : ''}}" >
                            
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                    <label for="sub_cat_image">Upload Sub Category Image</label>
                                <span class="error"> 
                                    @if ($errors->has('sub_cat_image'))
                                        {{ $errors->first('sub_cat_image') }}
                                    @endif
                                </span>
                                <p class="gj_not" style="color:red"><em>image size must be 200 x 200 pixels</em></p>

                                <input type="file" name="sub_cat_image" id="sub_cat_image" accept="image/*" class="gj_sub_cat_image">
                            </div>
                        </div>
                        </div>
                         </div>
                          <div class="update-btn-box">
                               <button type="submit" class="btn btn-primary mx_auto">Update</button>
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
</script>
@endsection
