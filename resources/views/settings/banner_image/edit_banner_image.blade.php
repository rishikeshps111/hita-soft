@extends('layouts.master')
@section('title', 'Edit Banner Image')
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
                     <form action="{{ route('update_banner_image') }}" method="POST" class="gj_geneal_form" enctype="multipart/form-data">
                     @csrf
                        @if($banner)
                                <input type="hidden" name="b_id" value="{{ $banner->id }}" class="form-control gj_b_id">
                        @endif
                         <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                 <div class="col-lg-12">
                      <h3 class="gj_heading">Edit Banner Image </h3>
                      <a href="javascript:history.back()" class="btn btn-outline-secondary" style="margin-left:90%;">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                 </div>
                  <div class="col-lg-4 mt__3">
                       <div class="form-group">
                        
                            <label for="image_title"> Banner Caption</label>
                            <span class="error"> 
                                @if ($errors->has('image_title'))
                                    {{ $errors->first('image_title') }}
                                @endif
                            </span>

                                <input type="text" name="image_title" value="{{$banner->image_title ? $banner->image_title : old('image_title')}}"  class="form-control gj_image_title" placeholder="Banner Title in English">
                        </div>
                  </div>
                  
                  <div class="col-lg-4 mt__3">
                       <div class="form-group">
                             <label for="redirect_url">Button Title</label>
                            <span class="error">* 
                                @if ($errors->has('button_title'))
                                    {{ $errors->first('button_title') }}
                                @endif
                            </span>

                            <input type="text" name="button_title" value="{{$banner->button_title ? $banner->button_title : old('button_title') }}"  class="form-control gj_redirect_url" placeholder="Button Title">
                          
                        </div>
                  </div>
                
                  <div class="col-lg-4 mt__3">
                       <div class="form-group">
                             <label for="redirect_url">Redirect URL</label>
                            <span class="error">* 
                                @if ($errors->has('redirect_url'))
                                    {{ $errors->first('redirect_url') }}
                                @endif
                            </span>

                            <input type="text" name="redirect_url" value="{{$banner->redirect_url ? $banner->redirect_url : old('redirect_url') }}"  class="form-control gj_redirect_url" placeholder="Redirect URL">
                            <p class="gj_ru_ex">Example : <b>http://www.google.com</b> or <b>#</b></p>
                        </div>
                  </div>
                    <div class="col-lg-4 ">
                      <div class="no-img-box">
                          <div class="gj_ban_img_whole">
                            <?php 
                            $file_path = 'images/banner_image';
                            ?>
                            @if(isset($banner))
                                @if($banner->banner_image !='')
                                <div class="form-group">
                                    <label for="current_noimage">Current Banner Image</label>
                                    <div class="gj_ni_div">
                                       <img src="{{ asset($file_path.'/'.$banner->banner_image)}}" class="img-responsive"> 
                                    </div>
                                <input type="hidden" name="old_banner_image" value="{{$banner->banner_image ? $banner->banner_image : ''}}"  class="form-control " >
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                    <label for="banner_image">Upload Banner Image</label>
                                <span class="error"> 
                                    @if ($errors->has('banner_image'))
                                        {{ $errors->first('banner_image') }}
                                    @endif
                                </span>
                                <p class="gj_not" style="color:red"><em>image size must be 1090 x 450 pixels</em></p>

                                <input type="file" name="banner_image" id="banner_image" accept="image/*" class="gj_banner_image">
                            </div>
                        </div>
                      </div>
                  </div>
             </div>

                       

                        <!-- <div class="form-group">
                            <label for="slider_speed">Image Slider Speed</label>
                            <span class="error">* 
                                @if ($errors->has('slider_speed'))
                                    {{ $errors->first('slider_speed') }}
                                @endif
                            </span>

                                <input type="number" name="slider_speed" value="{{$banner->slider_speed ? $banner->slider_speed : old('slider_speed')}}"  class="form-control gj_slider_speed" placeholder="Banner Slider Speed in Number">

                            <p class="gj_note">1000 = 1second. You have put the value for 1000,2000 like us.</p>
                        </div> -->

                        

                       <div class="update-btn-box">
                              <input type="submit" class="btn btn-primary  mx_auto" value="Update">
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
