@extends('layouts.master')
@section('title', 'Edit COD')
@section('content')
<section class="gj_edt_cod_setting">
    <button type="button" class="Mob-side-open" onclick="openadminSide()"><i class="fa-solid fa-bars"></i></button>
    <div class="row gj_row ">
       
        <div class="col-lg-2 adminLeftSide" id="adminSideNav">
            <button type="button" class="Mob-side-close" onclick="openadminSide()"><i  class="fa-solid fa-xmark"></i></button>
            @include('layouts.sidebar')
        </div>

        <div class="col-lg-10 ">


            <div class="gj_box dark">
                

                <div class="col-md-12">
                    <form action="{{ route('update_cod') }}" method="POST" class="gj_cod_form" enctype="multipart/form-data">
                          @csrf
                        @if($cod)
                            <input type="hidden" name="cod_id" class="form-control gj_cod_id" value="{{$cod->id}}">
                        @endif
                        <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                            
                        <div class="col-lg-12 back-container">
                           <h3 class="gj_heading"> Edit Payment Setting </h3>
                           <a href="javascript:history.back()" class="btn btn-outline-secondary" >
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>

                        <div class="form-group col-lg-6">
                             <label for="name">Name</label>
                            <span class="error">* 
                                @if ($errors->has('name'))
                                    {{ $errors->first('name') }}
                                @endif
                            </span>
                            <input type="text" name="name" class="form-control gj_above_amount" placeholder="Enter Name" value="{{$cod->name ? $cod->name : old('name')}}">
                       
                        </div>

                        <div class="form-group col-lg-6">
                             <label for="note">Note</label>
                            <span class="error">* 
                                @if ($errors->has('note'))
                                    {{ $errors->first('note') }}
                                @endif
                            </span>
                            
                            <input type="text" name="note" class="form-control gj_cod_amount" placeholder="Enter Note" value="{{$cod->note ? $cod->note :old('note')}}">
                       </div>
                       
                       <div class="form-group col-lg-12">
                            <label for="is_block"> Staus</label>
                            <span class="error">* 
                                @if ($errors->has('is_enabled'))
                                    {{ $errors->first('is_enabled') }}
                                @endif
                            </span>

                            <div class="gj_py_ro_div">
                                <span class="gj_py_ro">
                                    <input type="radio" <?php if($cod->is_enabled == 1) { echo "checked"; } ?> name="is_enabled" value="1"> Active
                                </span>
                                <span class="gj_py_ro">
                                    <input type="radio" <?php if($cod->is_enabled == 0) { echo "checked"; } ?> name="is_enabled" value="0"> Deactive
                                </span>
                            </div>
                        </div>
                       
                       <div class="col-lg-12">
                            <div class="gj_ban_img_whole">
                            <?php 
                            $file_path = 'images/icons';
                            ?>
                            @if(isset($cod))
                                @if($cod->icon_image !='')
                                <div class="form-group">
                                    <label for="current_icon_image">Icon Image</label>
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($file_path.'/'.$cod->icon_image)}}" class="img-responsive"> 
                                    </div>
                                     <input type="hidden" name="old_icon_image" class="form-control"  value="{{ $cod->icon_image }}" >

                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                <label for="icon_image">Upload Icon Image</label>
                                <span class="error"> 
                                    @if ($errors->has('icon_image'))
                                        {{ $errors->first('icon_image') }}
                                    @endif
                                </span>
                                <p class="gj_not" style="color:red"><em>image size must be 200 x 200 pixels</em></p>

                                <input type="file" name="icon_image" id="icon_image" accept="image/*" class="gj_main_cat_image">
                            </div>
                        </div>
                        </div>
                       
                       </div>


                         <input type="submit" class="btn btn-primary mx_auto" value="Update">

                   </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('p.alert').delay(3000).slideUp(500);
</script>
@endsection
