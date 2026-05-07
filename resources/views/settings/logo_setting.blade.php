@extends('layouts.master')
@section('title', 'Logo Settings')
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
               
                <div class="col-md-12"> 
                <form action="{{ route('store_logo_setting') }}" method="POST" class="gj_logo_form" enctype="multipart/form-data">
                    <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                          <div class="col-lg-12 mb-3">
                             <h3 class="gj_heading"> Logo Settings  </h3>
                         </div>
                         <div class="col-lg-4">
                              @csrf
                        @if(isset($logo))
                         <input type="hidden" name="a_id" value="{{ $logo->id ? $logo->id : ''}}" class="form-control ">
                            <?php 
                            $file_path = 'images/logo';
                            ?>
                            @if($logo->logo_image !='')
                            <div class="form-group">
                            <label for="current_logo"> Current Logo</label>
                                <div class="gj_cl_div">
                                   <img src="{{ asset($file_path.'/'.$logo->logo_image)}}" class="img-responsive"> 
                                </div>
                                <input type="hidden" name="old_logo_image" class="form-control" value="{{ $logo->logo_image ?? '' }}">
                            </div>
                            @endif
                        @else
                             <input type="text" name="id" class="form-control" value="{{ old('id') }}">
                        @endif

                         </div>
                         <div class="col-lg-8">
                             
                        <div class="form-group">
                            <label for="logo_image">Upload Logo Image</label>
                            <span class="error">* 
                                @if ($errors->has('logo_image'))
                                    {{ $errors->first('logo_image') }}
                                @endif
                            </span>
                            <p class="gj_not" style="color:red"><em>image size must be 180 x 45 pixels</em></p>

                            @if(isset($logo))
                                <input type="file" name="logo_image" id="logo_image" accept="image/*" class="gj_logo_image" style="width:100%">
                            @else
                                <input type="file" name="logo_image" id="logo_image" accept="image/*" class="gj_logo_image" style="width:100%">
                            @endif
                        </div>
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
        $("#country_name").select2();
        $('p.alert').delay(1000).slideUp(300); 
    });
</script>
@endsection
