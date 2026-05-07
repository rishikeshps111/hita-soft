@extends('layouts.master')
@section('title', 'Favicon Settings')
@section('content')
<style>
    .gj_cf_div
 {
    width: 100px !important;
    height: 100px !important;
}
</style>
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
               

                <div class="col-md-12" >
                    <form action="{{route('store_favicon_setting')}}" class="gj_favicon_form" method="POST" enctype="multipart/form-data">
                          <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                              <div class="col-lg-12 mb-3" style="padding:0;">
                             <h3 class="gj_heading" style="margin-left:10px;"> Favicon Settings  </h3>
                             <div class="col-lg-4 mt__3">
                                      @csrf
                        @if(isset($favicon))
                            <input type="hidden" name="id" class="form-control" value="{{ $favicon->id ? $favicon->id : '' }}" >

                            <?php 
                            $file_path = 'images/favicon';
                            ?>
                            @if($favicon->favicon_image !='')
                            <div class="form-group">
                                <label for="current_favicon">Current Favicon</label>
                                <div class="gj_cf_div">
                                   <img src="{{ asset($file_path.'/'.$favicon->favicon_image)}}" class="img-responsive"> 
                                </div>
                                 <input type="hidden" name="old_favicon_image" class="form-control" value="{{ $favicon->old_favicon_image ? $favicon->old_favicon_image : '' }}" >

                            </div>
                            @endif
                        @else
                            <input type="hidden" name="id" class="form-control" value="{{ old('id') }}" >

                        @endif
                             </div>
                             <div class="col-lg-8 mt__3">
                                   <div class="form-group">
                                <label for="favicon_image">Upload favicon Image</label>
                            <span class="error">* 
                                @if ($errors->has('favicon_image'))
                                    {{ $errors->first('favicon_image') }}
                                @endif
                            </span>
                            <p class="gj_not" style="color:red"><em>image size must be 16 x 16 pixels</em></p>

                            @if(isset($favicon))
                                <input type="file" name="favicon_image" id="favicon_image" accept="image/*" class="gj_favicon_image" style="width:100%">
                            @else
                                <input type="file" name="favicon_image" id="favicon_image" accept="image/*" class="gj_favicon_image" style="width:100%">
                            @endif
                        </div>
                             </div>
                         </div>
                          </div>
                   

                       <div class="update-btn-box mx_auto">
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
        $("#country_name").select2();
        $('p.alert').delay(1000).slideUp(300); 
    });
</script>
@endsection
