@extends('layouts.master')
@section('title', 'Add CMS About Us Page')
@section('content')
<section class="gj_abou_setting">
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
                <header>
                    <div class="gj_icons"><i class="fa fa-edit"></i></div>
                    <h5 class="gj_heading"> Add Highlights </h5>
                </header>
                 <div class="col-md-12">
                    <form action="{{ route('store_highlights') }}" method="POST" class="gj_about_cms_form" enctype="multipart/form-data">
                     @csrf
                        @if(isset($about_page))
                            @if($about_page)
                                <input type="hidden" name="a_id" value="{{ $about_page->id }}" class="form-control gj_a_id">
                            @endif
                        @endif

                        <div class="form-group">
                            <label for="abo_title"> Title</label>
                            <span class="error">* 
                                @if ($errors->has('abo_title'))
                                    {{ $errors->first('abo_title') }}
                                @endif
                            </span>
                            @if(isset($about_page)) 
                                <input type="text" name="abo_title" class="form-control" value="{{ $about_page->abo_title ? $about_page->abo_title : '' }}">
                            @else
                                <input type="text" name="abo_title" class="form-control" value="{{ old('abo_title') }}">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="abo_desc"> Description</label>
                            <span class="error">* 
                                @if ($errors->has('abo_desc'))
                                    {{ $errors->first('abo_desc') }}
                                @endif
                            </span>

                            <textarea name="abo_desc" cols="20" rows="4" class="summernote" >{{((isset($about_page) && $about_page->abo_desc) ? $about_page->abo_desc : old('abo_desc'))}}</textarea>
                        </div>

                        <div class="gj_ban_img_whole">
                            <div class="row">
                                <div class="col-sm-4">
                                @if(isset($about_page))
                                @if($about_page->banner_image != '')
                                <div class="form-group">
                                    <label for="current_banner_image"> Current Banner Image</label>
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($about_page->banner_image)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="old_banner_image" class="form-control" value="{{ $about_page->banner_image ?? '' }}">
                                </div>
                                @endif
                                @endif
    
                                <div class="form-group">
                                    <label for="banner_image"> Upload Banner Image</label>
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
                            
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</section>


@endsection