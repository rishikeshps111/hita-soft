@extends('layouts.master')
@section('title', 'Edit CMS Page')
@section('content')
<style>
    .note-editor{
        margin-bottom:0;
    }
    .gj_ban_img_whole{
        margin:0;
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
                <!--<header>-->
                <!--    <div class="gj_icons"><i class="fa fa-edit"></i></div>-->
                <!--    <h5 class="gj_heading"> Edit CMS Page  </h5>-->
                <!--</header>-->

                <div class="col-md-12">
                    
                    <form action="{{ route('update_cms_page') }}" method="POST" class="gj_cms_page_form" enctype="multipart/form-data">
                     @csrf
                        @if($cms_page)
                            <input type="hidden" name="cms_page_id" value="{{ $cms_page->id }}" class="form-control gj_cms_page_id">
                        @endif
                         <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                               <div class="col-lg-12 mb-3">
                                 <h3 class="gj_heading">Edit CMS Page  </h3>
                                 <a href="javascript:history.back()" class="btn btn-outline-secondary" style="margin-left:90%;">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                            </div>
                            <div class="form-group col-lg-12">
                            <label for="page_name">Page Title</label>
                            <span class="error">* 
                                @if ($errors->has('page_name'))
                                    {{ $errors->first('page_name') }}
                                @endif
                            </span>
                            <input type="text" name="page_name" class="form-control gj_page_name" placeholder="Page Title in English" value="{{ isset($cms_page) && $cms_page->page_name ? $cms_page->page_name : old('page_name') }}">

                        </div>

                        <div class="form-group col-lg-12">
                            <label for="page_description">Page Content</label>
                            <span class="error">* 
                                @if ($errors->has('page_description'))
                                    {{ $errors->first('page_description') }}
                                @endif
                            </span>

                            <textarea name="page_description" cols="20" rows="4" class="summernote" required="">{{((isset($cms_page) && $cms_page->page_description) ? $cms_page->page_description : Input::old('page_description'))}}</textarea>
                        </div>
                        {{-- <div class="col-lg-12">
                            <div class="gj_ban_img_whole ">
                            @if(isset($cms_page))
                                @if($cms_page->banner_image != '')
                                <div class="form-group">
                                    <label for="current_banner_image">Current Banner Image</label>
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($cms_page->banner_image)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="old_banner_image" class="form-control" value="{{ isset($cms_page) && $cms_page->banner_image ? $cms_page->banner_image : '' }}">

                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                 <label for="banner_image">Upload Banner Image</label>
                                <span class="error">* 
                                    @if ($errors->has('banner_image'))
                                        {{ $errors->first('banner_image') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="banner_image" id="banner_image" accept="image/*" class="gj_banner_image">
                            </div>
                        </div>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="banner_caption"> Banner Caption</label>
                            <span class="error"> 
                                @if ($errors->has('banner_caption'))
                                    {{ $errors->first('banner_caption') }}
                                @endif
                            </span>
                            @if(isset($cms_page))
                                <input type="text" name="banner_caption" value="{{$cms_page->banner_caption ? $cms_page->banner_caption : ''}}"  class="form-control">
                            @else
                                <input type="text" name="banner_caption" value="{{ old('banner_caption') }}" class="form-control">
                            @endif
                        </div> --}}

                        <div class="form-group col-lg-4">
                            <label for="meta_tags"> Meta Tags</label>
                            <span class="error"> 
                                @if ($errors->has('meta_tags'))
                                    {{ $errors->first('meta_tags') }}
                                @endif
                            </span>
                            @if(isset($cms_page))
                                <input type="text" name="meta_tags" value="{{ $cms_page->meta_tags ? $cms_page->meta_tags : '' }}" class="form-control">
                            @else
                                <input type="text" name="meta_tags" value="{{ old('meta_tags') }}" class="form-control">
                            @endif
                        </div>

                        {{-- <div class="form-group col-lg-4">
                            <label for="video_url"> Video Url</label>
                            <span class="error"> 
                                @if ($errors->has('video_url'))
                                    {{ $errors->first('video_url') }}
                                @endif
                            </span>
                            @if(isset($cms_page))
                                <input type="text" name="video_url" value="{{ $cms_page->video_url ? $cms_page->video_url : '' }}" class="form-control">
                            @else
                                <input type="text" name="video_url" value="{{ old('video_url') }}" class="form-control">
                            @endif
                        </div> --}}

                        
                         </div>
                         <div class="update-btn-box mx_auto">
                             <input type="submit" id="update" class="btn btn-primary mx_auto" value="Update">
                         </div>

                        

                        

                         

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/editor.css')}}">
<script src="{{ asset('js/editor.js')}}"></script> -->

<script>
    $(document).ready(function() {
        $('p.alert').delay(7000).slideUp(700); 
        $("#cms_page").select2(); 

        $('.summernote').summernote({
            placeholder: 'Enter Content',
            tabsize: 2,
            height: 100
        });

        // $("#page_description").Editor();
        <?php 
        if($cms_page->page_description) { 
            // $ed = htmlentities($cms_page->page_description, ENT_QUOTES);
            // $ed = preg_replace( "/\r|\n/", "", $ed);
        ?>
            
            // $("#page_description").Editor("setText", '<?php //echo html_entity_decode($ed); ?>'); 
        <?php } ?>
    });

    /*$('#update').on('click',function(){
        var page_name = 0;
        var page_description = 0;
        var cms_page_id = 0;
        if($('#page_name').val()) {
            page_name = $('#page_name').val();
        }

        if($('#page_description').Editor("getText")) {
            page_description = $('#page_description').Editor("getText");
        }

        if($('.gj_cms_page_id').val()) {
            cms_page_id = $('.gj_cms_page_id').val();
        }

        if((page_name != 0) && (page_description != 0) && (cms_page_id != 0)) {
            $.ajax({
                type: 'post',
                url: '{{url('/edit_cms_page')}}',
                data: {page_name: page_name, page_description: page_description, cms_page_id: cms_page_id, type: 'update'},
                success: function(data){
                    if(data == 0){
                        window.location.href = "{{route('manage_cms_page')}}";
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
        } else {
            $.confirm({
                title: '',
                content: 'Please Enter Correct Details!',
                icon: 'fa fa-exclamation',
                theme: 'modern',
                closeIcon: true,
                animation: 'scale',
                type: 'red',
                buttons: {
                    Ok: function(){
                        window.location.reload();
                    }
                }
            });                        
        }
    });*/
</script>
@endsection
