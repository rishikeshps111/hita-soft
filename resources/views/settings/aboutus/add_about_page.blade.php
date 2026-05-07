@extends('layouts.master')
@section('title', 'Add CMS About Us Page')
@section('content')
<style>
    video{
        width:300px;
        height:300px;
        margin:20px 0;
        object-fit:cover
        
    }
       .note-editor{
        margin-bottom:0;
    }
    .gj_ban_img_whole{
        margin:0;
    }
    .gj_ban_img_whole{
        box-shadow:none;
        padding:10px 0;
    }
    .gj_ban_img_whole .row{
        margin:0;
    }
    .gj_ban_img_whole .row .col-sm-12{
        padding:0;
    }
</style>
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
                <!--<header>-->
                <!--    <div class="gj_icons"><i class="fa fa-edit"></i></div>-->
                <!--    <h5 class="gj_heading">  </h5>-->
                <!--</header>-->

                <div class="col-md-12">
                    <form action="{{ route('store_about_page') }}" method="POST" class="gj_about_cms_form" enctype="multipart/form-data">
                     @csrf
                        @if(isset($about_page))
                            @if($about_page)
                                <input type="hidden" name="a_id" value="{{ $about_page->id }}" class="form-control gj_a_id">
                            @endif
                        @endif
                         <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                              <div class="col-lg-12 mb-3">
                                 <h3 class="gj_heading">Add CMS About Us Page   </h3>
                            </div>
                              <div class="form-group col-lg-12">
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
                         <div class="form-group col-lg-12">
                            <label for="abo_desc"> Description</label>
                            <span class="error">* 
                                @if ($errors->has('abo_desc'))
                                    {{ $errors->first('abo_desc') }}
                                @endif
                            </span>

                            <textarea name="abo_desc" cols="20" rows="4" class="summernote" >{{((isset($about_page) && $about_page->abo_desc) ? $about_page->abo_desc : old('abo_desc'))}}</textarea>
                        </div>
                        <div class="col-lg-12">
                            <div class="gj_ban_img_whole">
                            <div class="row">
                                <div class="col-sm-12">
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
                                 {{--<div class="col-sm-12">
                                     @if(isset($about_page))
                                        @if($about_page->abo_bg1 != '')
                                        <div class="form-group">
                                            <label for="current_abo_bg1">Current About Image1</label>
                                            <div class="gj_mc_div">
                                               <img src="{{ asset($about_page->abo_bg1)}}" class="img-responsive"> 
                                            </div>
                                            <input type="hidden" name="old_abo_bg1" class="form-control" value="{{ $about_page->abo_bg1 ? $about_page->abo_bg1 : '' }}">
                                        </div>
                                        @endif
                                    @endif
        
                                    <div class="form-group">
                                        <label for="abo_bg1">Upload About Image1</label>
                                        <span class="error">* 
                                            @if ($errors->has('abo_bg1'))
                                                {{ $errors->first('abo_bg1') }}
                                            @endif
                                        </span>
                                        <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->
        
                                        <input type="file" name="abo_bg1" id="abo_bg1" accept="image/*" class="gj_abo_bg1">
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                     @if(isset($about_page))
                                        @if($about_page->abo_bg2 != '')
                                        <div class="form-group">
                                        <label for="current_abo_bg2">Current About Image2</label>
                                            <div class="gj_mc_div">
                                               <img src="{{ asset($about_page->abo_bg2)}}" class="img-responsive"> 
                                            </div>
                                            <input type="hidden" name="old_abo_bg2" class="form-control" value="{{ $about_page->old_abo_bg2 ? $about_page->old_abo_bg2 : '' }}">
                                        </div>
                                        @endif
                                    @endif
        
                                    <div class="form-group">
                                        <label for="current_abo_bg2">Upload About Image2</label>
                                        <span class="error">* 
                                            @if ($errors->has('abo_bg2'))
                                                {{ $errors->first('abo_bg2') }}
                                            @endif
                                        </span>
                                        <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->
        
                                        <input type="file" name="abo_bg2" id="abo_bg2" accept="image/*" class="gj_abo_bg2">
                                    </div>
                                </div> --}}
                                
                            </div>
                          
                            
                           
                        </div>
                        </div>
                        <div class="col-lg-12">
                            <!--section 1-->
                      
                        <div class="gj_ban_img_whole">
                            <div class="row">
                                 <div class="form-group">
                                    <label for="sec1_desc">Section1 Description</label>
                                    <span class="error">* 
                                        @if ($errors->has('sec1_desc'))
                                            {{ $errors->first('sec1_desc') }}
                                        @endif
                                    </span>
        
                                    <textarea name="sec1_desc" cols="20" rows="4" class="summernote" >{{((isset($about_page) && $about_page->sec1_desc) ? $about_page->sec1_desc : old('sec1_desc'))}}</textarea>
                                </div>
                        
                                <div class="col-sm-12">
                            @if(isset($about_page))
                                @if($about_page->section1_image != '')
                                <div class="form-group">
                                    <label for="current_section1_image"> About Section1 Image</label>
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($about_page->section1_image)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="old_section1_image" class="form-control" value="{{ $about_page->section1_image ?? '' }}">
                                </div>
                                @endif
                                @endif
    
                                <div class="form-group">
                                    <label for="section1_image"> Upload Section1 Image</label>
                                    <span class="error">* 
                                        @if ($errors->has('section1_image'))
                                            {{ $errors->first('section1_image') }}
                                        @endif
                                    </span>
                                    <input type="file" name="section1_image" id="section1_image" accept="image/*" class="gj_banner_image">
                                </div>
                            
                                </div>
                                <div class="col-sm-12">
                                     @if(isset($about_page))
                                        @if($about_page->section1_image2 != '')
                                        <div class="form-group">
                                            <label for="current_abo_bg1">About Section1 Image2</label>
                                            <div class="gj_mc_div">
                                               <img src="{{ asset($about_page->section1_image2)}}" class="img-responsive"> 
                                            </div>
                                            <input type="hidden" name="old_section1_image2" class="form-control" value="{{ $about_page->section1_image2 ? $about_page->section1_image2 : '' }}">
                                        </div>
                                        @endif
                                    @endif
        
                                    <div class="form-group">
                                        <label for="section1_image2">Upload About Image2</label>
                                        <span class="error">* 
                                            @if ($errors->has('section1_image2'))
                                                {{ $errors->first('section1_image2') }}
                                            @endif
                                        </span>
                                        <input type="file" name="section1_image2" id="section1_image2" accept="image/*" class="gj_abo_bg1">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                            <!---->
                        </div>
                        <div class="col-lg-12">
                              <!--section 2-->
                      
                        <div class="gj_ban_img_whole">
                            <div class="row">
                                 <div class="form-group">
                                    <label for="abo_desc">Section2 Description</label>
                                    <span class="error">* 
                                        @if ($errors->has('sec2_desc'))
                                            {{ $errors->first('sec2_desc') }}
                                        @endif
                                    </span>
        
                                    <textarea name="sec2_desc" cols="20" rows="4" class="summernote" >{{((isset($about_page) && $about_page->sec2_desc) ? $about_page->sec2_desc : old('sec2_desc'))}}</textarea>
                                </div>
                        
                                <div class="col-sm-12">
                            @if(isset($about_page))
                                @if($about_page->section2_image != '')
                                <div class="form-group">
                                    <label for="current_section2_image"> About Section2 Image</label>
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($about_page->section2_image)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="old_section2_image" class="form-control" value="{{ $about_page->section2_image ?? '' }}">
                                </div>
                                @endif
                                @endif
    
                                <div class="form-group">
                                    <label for="section1_image"> Upload Section2 Image</label>
                                    <span class="error">* 
                                        @if ($errors->has('section2_image'))
                                            {{ $errors->first('section2_image') }}
                                        @endif
                                    </span>
                                    <input type="file" name="section2_image" id="section2_image" accept="image/*" class="gj_banner_image">
                                </div>
                            
                                </div>
                                <div class="col-sm-12">
                                     @if(isset($about_page))
                                        @if($about_page->section2_image2 != '')
                                        <div class="form-group">
                                            <label for="current_section2_image2">About Section2 Image2</label>
                                            <div class="gj_mc_div">
                                               <img src="{{ asset($about_page->section2_image2)}}" class="img-responsive"> 
                                            </div>
                                            <input type="hidden" name="old_section2_image2" class="form-control" value="{{ $about_page->section2_image2 ? $about_page->section2_image2 : '' }}">
                                        </div>
                                        @endif
                                    @endif
        
                                    <div class="form-group">
                                        <label for="section2_image2">Upload About Image2</label>
                                        <span class="error">* 
                                            @if ($errors->has('section2_image2'))
                                                {{ $errors->first('sectio21_image2') }}
                                            @endif
                                        </span>
                                        <input type="file" name="section2_image2" id="section2_image2" accept="image/*" class="gj_abo_bg1">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                            <!---->
                        </div>
                        {{--<div class="col-lg-12">
                      
                        <div class="gj_ban_img_whole">
                            <div class="row">
                                 <div class="form-group">
                                    <label for="abo_desc">Section3 Description</label>
                                    <span class="error">* 
                                        @if ($errors->has('sec3_desc'))
                                            {{ $errors->first('sec3_desc') }}
                                        @endif
                                    </span>
        
                                    <textarea name="sec3_desc" cols="20" rows="4" class="summernote" >{{((isset($about_page) && $about_page->sec3_desc) ? $about_page->sec3_desc : old('sec3_desc'))}}</textarea>
                                </div>
                        
                                <div class="col-sm-12">
                            @if(isset($about_page))
                                @if($about_page->section3_image != '')
                                <div class="form-group">
                                    <label for="current_section3_image"> About Section3 Image</label>
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($about_page->section3_image)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="old_section3_image" class="form-control" value="{{ $about_page->section3_image ?? '' }}">
                                </div>
                                @endif
                                @endif
    
                                <div class="form-group">
                                    <label for="section3_image"> Upload Section3 Image</label>
                                    <span class="error">* 
                                        @if ($errors->has('section3_image'))
                                            {{ $errors->first('section3_image') }}
                                        @endif
                                    </span>
                                    <input type="file" name="section3_image" id="section3_image" accept="image/*" class="gj_banner_image">
                                </div>
                            
                                </div>
                                <div class="col-sm-12">
                                     @if(isset($about_page))
                                        @if($about_page->section3_image2 != '')
                                        <div class="form-group">
                                            <label for="current_section3_image2">About Section3 Image2</label>
                                            <div class="gj_mc_div">
                                               <img src="{{ asset($about_page->section3_image2)}}" class="img-responsive"> 
                                            </div>
                                            <input type="hidden" name="old_section3_image2" class="form-control" value="{{ $about_page->section3_image2 ? $about_page->section3_image2 : '' }}">
                                        </div>
                                        @endif
                                    @endif
        
                                    <div class="form-group">
                                        <label for="section3_image2">Upload About Image2</label>
                                        <span class="error">* 
                                            @if ($errors->has('section3_image2'))
                                                {{ $errors->first('section3_image2') }}
                                            @endif
                                        </span>
                                        <input type="file" name="section3_image2" id="section3_image2" accept="image/*" class="gj_abo_bg1">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        </div> 
                        <div class="col-lg-12">
                      
                        <div class="gj_ban_img_whole">
                            <div class="row">
                                 <div class="form-group">
                                    <label for="sec4_desc">Section4 Description</label>
                                    <span class="error">* 
                                        @if ($errors->has('sec4_desc'))
                                            {{ $errors->first('sec4_desc') }}
                                        @endif
                                    </span>
        
                                    <textarea name="sec4_desc" cols="20" rows="4" class="summernote" >{{((isset($about_page) && $about_page->sec4_desc) ? $about_page->sec4_desc : old('sec4_desc'))}}</textarea>
                                </div>
                        
                                <div class="col-sm-12">
                            @if(isset($about_page))
                                @if($about_page->section4_image != '')
                                <div class="form-group">
                                    <label for="current_section4_image"> About Section4 Image</label>
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($about_page->section4_image)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="old_section4_image" class="form-control" value="{{ $about_page->section4_image ?? '' }}">
                                </div>
                                @endif
                                @endif
    
                                <div class="form-group">
                                    <label for="section4_image"> Upload Section4 Image</label>
                                    <span class="error">* 
                                        @if ($errors->has('section4_image'))
                                            {{ $errors->first('section4_image') }}
                                        @endif
                                    </span>
                                    <input type="file" name="section4_image" id="section4_image" accept="image/*" class="gj_banner_image">
                                </div>
                            
                                </div>
                                <div class="col-sm-12">
                                     @if(isset($about_page))
                                        @if($about_page->section4_image2 != '')
                                        <div class="form-group">
                                            <label for="current_section4_image2">About Section4 Image2</label>
                                            <div class="gj_mc_div">
                                               <img src="{{ asset($about_page->section4_image2)}}" class="img-responsive"> 
                                            </div>
                                            <input type="hidden" name="old_section4_image2" class="form-control" value="{{ $about_page->section4_image2 ? $about_page->section4_image2 : '' }}">
                                        </div>
                                        @endif
                                    @endif
        
                                    <div class="form-group">
                                        <label for="section4_image2">Upload About Image2</label>
                                        <span class="error">* 
                                            @if ($errors->has('section4_image2'))
                                                {{ $errors->first('section4_image2') }}
                                            @endif
                                        </span>
                                        <input type="file" name="section4_image2" id="section4_image2" accept="image/*" class="gj_abo_bg1">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        </div>
                        <div class="col-lg-12">
                      
                        <div class="gj_ban_img_whole">
                            <div class="row">
                                 <div class="form-group">
                                    <label for="sec5_desc">Section5 Description</label>
                                    <span class="error">* 
                                        @if ($errors->has('sec5_desc'))
                                            {{ $errors->first('sec5_desc') }}
                                        @endif
                                    </span>
        
                                    <textarea name="sec5_desc" cols="20" rows="4" class="summernote" >{{((isset($about_page) && $about_page->sec5_desc) ? $about_page->sec5_desc : old('sec5_desc'))}}</textarea>
                                </div>
                        
                                <div class="col-sm-12">
                            @if(isset($about_page))
                                @if($about_page->section5_image != '')
                                <div class="form-group">
                                    <label for="current_section5_image"> About Section5 Image</label>
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($about_page->section5_image)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="old_section5_image" class="form-control" value="{{ $about_page->section5_image ?? '' }}">
                                </div>
                                @endif
                                @endif
    
                                <div class="form-group">
                                    <label for="section5_image"> Upload Section5 Image</label>
                                    <span class="error">* 
                                        @if ($errors->has('section5_image'))
                                            {{ $errors->first('section5_image') }}
                                        @endif
                                    </span>
                                    <input type="file" name="section5_image" id="section5_image" accept="image/*" class="gj_banner_image">
                                </div>
                            
                                </div>
                                <div class="col-sm-12">
                                     @if(isset($about_page))
                                        @if($about_page->section5_image2 != '')
                                        <div class="form-group">
                                            <label for="current_section5_image2">About Section5 Image2</label>
                                            <div class="gj_mc_div">
                                               <img src="{{ asset($about_page->section5_image2)}}" class="img-responsive"> 
                                            </div>
                                            <input type="hidden" name="old_section5_image2" class="form-control" value="{{ $about_page->section5_image2 ? $about_page->section5_image2 : '' }}">
                                        </div>
                                        @endif
                                    @endif
        
                                    <div class="form-group">
                                        <label for="section5_image2">Upload About Image2</label>
                                        <span class="error">* 
                                            @if ($errors->has('section5_image2'))
                                                {{ $errors->first('section5_image2') }}
                                            @endif
                                        </span>
                                        <input type="file" name="section5_image2" id="section5_image2" accept="image/*" class="gj_abo_bg1">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        </div> 
                        <div class="col-lg-12">
                          
                      
                        <div class="gj_ban_img_whole">
                            <div class="row">
                                 <div class="form-group">
                                    <label for="sec6_desc">Section6 Description</label>
                                    <span class="error">* 
                                        @if ($errors->has('sec6_desc'))
                                            {{ $errors->first('sec6_desc') }}
                                        @endif
                                    </span>
        
                                    <textarea name="sec6_desc" cols="20" rows="4" class="summernote" >{{((isset($about_page) && $about_page->sec6_desc) ? $about_page->sec6_desc : old('sec6_desc'))}}</textarea>
                                </div>
                        
                                <div class="col-sm-12">
                            @if(isset($about_page))
                                @if($about_page->section6_image != '')
                                <div class="form-group">
                                    <label for="current_section6_image"> About Section6 Image</label>
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($about_page->section6_image)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="old_section6_image" class="form-control" value="{{ $about_page->section6_image ?? '' }}">
                                </div>
                                @endif
                                @endif
    
                                <div class="form-group">
                                    <label for="section6_image"> Upload Section6 Image</label>
                                    <span class="error">* 
                                        @if ($errors->has('section6_image'))
                                            {{ $errors->first('section6_image') }}
                                        @endif
                                    </span>
                                    <input type="file" name="section6_image" id="section6_image" accept="image/*" class="gj_banner_image">
                                </div>
                            
                                </div>
                                <div class="col-sm-12">
                                     @if(isset($about_page))
                                        @if($about_page->section6_image2 != '')
                                        <div class="form-group">
                                            <label for="current_section6_image2">About Section6 Image2</label>
                                            <div class="gj_mc_div">
                                               <img src="{{ asset($about_page->section6_image2)}}" class="img-responsive"> 
                                            </div>
                                            <input type="hidden" name="old_section6_image2" class="form-control" value="{{ $about_page->section6_image2 ? $about_page->section6_image2 : '' }}">
                                        </div>
                                        @endif
                                    @endif
        
                                    <div class="form-group">
                                        <label for="section6_image2">Upload About Image2</label>
                                        <span class="error">* 
                                            @if ($errors->has('section6_image2'))
                                                {{ $errors->first('section6_image2') }}
                                            @endif
                                        </span>
                                        <input type="file" name="section6_image2" id="section6_image2" accept="image/*" class="gj_abo_bg1">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-12">
                      
                        <div class="gj_ban_img_whole">
                            <div class="row">
                                 <div class="form-group">
                                    <label for="sec7_desc">Section7 Description</label>
                                    <span class="error">* 
                                        @if ($errors->has('sec7_desc'))
                                            {{ $errors->first('sec7_desc') }}
                                        @endif
                                    </span>
        
                                    <textarea name="sec7_desc" cols="20" rows="4" class="summernote" >{{((isset($about_page) && $about_page->sec7_desc) ? $about_page->sec7_desc : old('sec7_desc'))}}</textarea>
                                </div>
                        
                                <div class="col-sm-12">
                            @if(isset($about_page))
                                @if($about_page->section7_image != '')
                                <div class="form-group">
                                    <label for="current_section7_image"> About Section7 Image</label>
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($about_page->section7_image)}}" class="img-responsive"> 
                                    </div>
                                    <input type="hidden" name="old_section7_image" class="form-control" value="{{ $about_page->section7_image ?? '' }}">
                                </div>
                                @endif
                                @endif
    
                                <div class="form-group">
                                    <label for="section1_image"> Upload Section7 Image</label>
                                    <span class="error">* 
                                        @if ($errors->has('section7_image'))
                                            {{ $errors->first('section7_image') }}
                                        @endif
                                    </span>
                                    <input type="file" name="section7_image" id="section7_image" accept="image/*" class="gj_banner_image">
                                </div>
                            
                                </div>
                                <div class="col-sm-12">
                                     @if(isset($about_page))
                                        @if($about_page->section7_image2 != '')
                                        <div class="form-group">
                                            <label for="current_section7_image2">About Section7 Image2</label>
                                            <div class="gj_mc_div">
                                               <img src="{{ asset($about_page->section7_image2)}}" class="img-responsive"> 
                                            </div>
                                            <input type="hidden" name="old_section7_image2" class="form-control" value="{{ $about_page->section7_image2 ? $about_page->section7_image2 : '' }}">
                                        </div>
                                        @endif
                                    @endif
        
                                    <div class="form-group">
                                        <label for="section7_image2">Upload About Image2</label>
                                        <span class="error">* 
                                            @if ($errors->has('section1_image2'))
                                                {{ $errors->first('section7_image2') }}
                                            @endif
                                        </span>
                                        <input type="file" name="section7_image2" id="section7_image2" accept="image/*" class="gj_abo_bg1">
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        </div> --}}
                        <div class="col-lg-12">
                            <div class="form-group">
                             <label for="banner_caption">Banner Caption</label>
                            <span class="error"> 
                                @if ($errors->has('banner_caption'))
                                    {{ $errors->first('banner_caption') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                <input type="text" name="banner_caption" value="{{$about_page->banner_caption ? $about_page->banner_caption : ''}}"  class="form-control">
                            @else 
                                <input type="text" name="banner_caption" value="{{ old('banner_caption') }}" class="form-control">
                            @endif
                        </div>
                        </div>

                         </div>

                      

                        {{--<div class="form-group">
                            <label for="abo_sub_title"> Short Description</label>
                            <span class="error">* 
                                @if ($errors->has('abo_sub_title'))
                                    {{ $errors->first('abo_sub_title') }}
                                @endif
                            </span>

                            <textarea name="abo_sub_title" cols="20" rows="4" class="gj_abosub_des form-control" placeholder="Enter Short Description" >{{((isset($about_page) && $about_page->abo_sub_title) ? $about_page->abo_sub_title : old('abo_sub_title'))}}</textarea>
                        </div>--}}

                        <div class=" main-right-container container-field row mx_0 px_5 mb-field">
                             <div class="col-lg-12 mb-3">
                                 <h3 class="gj_heading">Home Page About US Details </h3>
                            </div>
                            <div class="col-lg-12">
                                <div class="gj_box dark gj_inside_box">
                         
                            
                            <div class="col-md-12">
                                <div class="gj_f_pay_div">
                                    
                                    <div class="mb-3">
                                        <label for="video" class="form-label">Upload Video</label>
                                        <input type="file" class="form-control" name="video" id="video" accept="video/*" >
                                    </div>
                
                                    {{-- Video Preview --}}
                                    @if(isset($about_page->video) && file_exists(public_path($about_page->video)))
                                        <div class="mb-3">
                                            <video  controls>
                                                <source src="{{ url('public/uploads/videos/' . basename($about_page->video)) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    @endif
                
                                    {{-- Content Input --}}
                                    <div class="mb-3">
                                        <label for="content" class="form-label"> Description</label>
                                         <textarea name="video_desc" cols="20" rows="4" class="summernote" >{{((isset($about_page) && $about_page->video_desc) ? $about_page->video_desc : old('video_desc'))}}</textarea>
                                
                                    </div>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                        
                        
                         
                            
                           
                            
                           
                            
                         
                            
                        
                            
                           
                        
                            <!---->
                            
                             
                            
                            
                        

                        {{--<div class="form-group">
                             <label for="stat_first_icon">About First Section</label>
                            <span class="error">* 
                                @if ($errors->has('stat_first_icon'))
                                    {{ $errors->first('stat_first_icon') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                <input type="text" name="stat_first_icon" value="{{$about_page->stat_first_icon ? $about_page->stat_first_icon : ''}}"  class="form-control">
                            @else
                                <input type="text" name="stat_first_icon" value="{{ old('stat_first_icon') }}" class="form-control">
                            @endif

                            <p class="gj_lt_fa">View Icon Codes : <button type="button" class="gj_lt_icons" data-toggle="modal" data-target="#myModal">FontAwesome Icons</button></p>
                        </div>

                        <div class="form-group">
                             <label for="stat_first_value">About First Section</label>
                            <span class="error">* 
                                @if ($errors->has('stat_first_value'))
                                    {{ $errors->first('stat_first_value') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                <input type="text" name="about_first_sec" value="{{$about_page->about_first_sec ? $about_page->about_first_sec : ''}}"  class="form-control">
                            @else
                                <input type="text" name="about_first_sec" value="{{ old('about_first_sec') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group">
                             <label for="stat_first_title">Statistics First Title</label>
                            <span class="error">* 
                                @if ($errors->has('stat_first_title'))
                                    {{ $errors->first('stat_first_title') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                <input type="text" name="stat_first_title" value="{{$about_page->stat_first_title ? $about_page->stat_first_title : ''}}"  class="form-control">
                            @else
                                <input type="text" name="stat_first_title" value="{{ old('stat_first_title') }}" class="form-control">
                            @endif
                            @if(isset($about_page))
                                    @if($about_page->abo_bg1 != '')
                                    <div class="form-group">
                                        <label for="current_abo_bg1">Current About Image1</label>
                                        <div class="gj_mc_div">
                                           <img src="{{ asset($about_page->abo_bg1)}}" class="img-responsive"> 
                                        </div>
                                        <input type="hidden" name="old_abo_bg1" class="form-control" value="{{ $about_page->abo_bg1 ? $about_page->abo_bg1 : '' }}">
                                    </div>
                                    @endif
                                @endif
    
                                <div class="form-group">
                                    <label for="abo_bg1">Upload About Image1</label>
                                    <span class="error">* 
                                        @if ($errors->has('abo_bg1'))
                                            {{ $errors->first('abo_bg1') }}
                                        @endif
                                    </span>
                                    <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->
    
                                    <input type="file" name="abo_bg1" id="abo_bg1" accept="image/*" class="gj_abo_bg1">
                                </div>
                        </div>

                        <div class="form-group">
                             <label for="stat_second_icon">Statistics Second Icon</label>
                            <span class="error">* 
                                @if ($errors->has('stat_second_icon'))
                                    {{ $errors->first('stat_second_icon') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                <input type="text" name="stat_second_icon" value="{{$about_page->stat_second_icon ? $about_page->stat_second_icon : ''}}"  class="form-control">
                            @else
                                <input type="text" name="stat_second_icon" value="{{ old('stat_second_icon') }}" class="form-control">
                            @endif

                            <p class="gj_lt_fa">View Icon Codes : <button type="button" class="gj_lt_icons" data-toggle="modal" data-target="#myModal">FontAwesome Icons</button></p>
                        </div>

                        <div class="form-group">
                             <label for="stat_second_value">Statistics Second Value</label>
                            <span class="error">* 
                                @if ($errors->has('stat_second_value'))
                                    {{ $errors->first('stat_second_value') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                <input type="text" name="stat_second_value" value="{{$about_page->stat_second_value ? $about_page->stat_second_value : ''}}"  class="form-control">
                            @else
                                <input type="text" name="stat_second_value" value="{{ old('stat_second_value') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group">
                             <label for="stat_second_title">Statistics Second Title</label>
                            <span class="error">* 
                                @if ($errors->has('stat_second_title'))
                                    {{ $errors->first('stat_second_title') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                <input type="text" name="stat_second_title" value="{{$about_page->stat_second_title ? $about_page->stat_second_title : ''}}"  class="form-control">
                            @else
                                <input type="text" name="stat_second_title" value="{{ old('stat_second_title') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group">
                             <label for="stat_third_icon">Statistics Third Icon</label>
                            <span class="error">* 
                                @if ($errors->has('stat_third_icon'))
                                    {{ $errors->first('stat_third_icon') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                <input type="text" name="stat_third_icon" value="{{$about_page->stat_third_icon ? $about_page->stat_third_icon : ''}}"  class="form-control">
                            @else
                                <input type="text" name="stat_third_icon" value="{{ old('stat_third_icon') }}" class="form-control">
                            @endif

                            <p class="gj_lt_fa">View Icon Codes : <button type="button" class="gj_lt_icons" data-toggle="modal" data-target="#myModal">FontAwesome Icons</button></p>
                        </div>

                        <div class="form-group">
                            <label for="stat_third_value">Statistics Third Value</label>
                            <span class="error">* 
                                @if ($errors->has('stat_third_value'))
                                    {{ $errors->first('stat_third_value') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                <input type="text" name="stat_third_value" value="{{$about_page->stat_third_value ? $about_page->stat_third_value : ''}}"  class="form-control">
                            @else
                                <input type="text" name="stat_third_value" value="{{ old('stat_third_value') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="stat_third_title">Statistics Third Title</label>
                            <span class="error">* 
                                @if ($errors->has('stat_third_title'))
                                    {{ $errors->first('stat_third_title') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                <input type="text" name="stat_third_title" value="{{$about_page->stat_third_title ? $about_page->stat_third_title : ''}}"  class="form-control">
                            @else
                                <input type="text" name="stat_third_title" value="{{ old('stat_third_title') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="stat_fourth_icon">Statistics Fourth Icon</label>
                            <span class="error">* 
                                @if ($errors->has('stat_fourth_icon'))
                                    {{ $errors->first('stat_fourth_icon') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                <input type="text" name="stat_fourth_icon" value="{{$about_page->stat_fourth_icon ? $about_page->stat_fourth_icon : ''}}"  class="form-control">
                            @else
                                <input type="text" name="stat_fourth_icon" value="{{ old('stat_fourth_icon') }}" class="form-control">
                            @endif

                            <p class="gj_lt_fa">View Icon Codes : <button type="button" class="gj_lt_icons" data-toggle="modal" data-target="#myModal">FontAwesome Icons</button></p>
                        </div>

                        <div class="form-group">
                            <label for="stat_fourth_value">Statistics Fourth Value</label>
                            <span class="error">* 
                                @if ($errors->has('stat_fourth_value'))
                                    {{ $errors->first('stat_fourth_value') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                <input type="text" name="stat_fourth_value" value="{{$about_page->stat_fourth_value ? $about_page->stat_fourth_value : ''}}"  class="form-control">
                            @else
                                <input type="text" name="stat_fourth_value" value="{{ old('stat_fourth_value') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="stat_fourth_title">Statistics Fourth Title</label>
                            
                            <span class="error">* 
                                @if ($errors->has('stat_fourth_title'))
                                    {{ $errors->first('stat_fourth_title') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                <input type="text" name="stat_fourth_title" value="{{$about_page->stat_fourth_title ? $about_page->stat_fourth_title : ''}}"  class="form-control">
                            @else
                                <input type="text" name="stat_fourth_title" value="{{ old('stat_fourth_title') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="award_hd">Award Heading</label>
                            <span class="error">* 
                                @if ($errors->has('award_hd'))
                                    {{ $errors->first('award_hd') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                <input type="text" name="award_hd" value="{{$about_page->award_hd ? $about_page->award_hd : ''}}"  class="form-control">
                            @else
                                <input type="text" name="award_hd" value="{{ old('award_hd') }}" class="form-control">
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="award_desc">Award Description</label>
                            <span class="error">* 
                                @if ($errors->has('award_desc'))
                                    {{ $errors->first('award_desc') }}
                                @endif
                            </span>

                            <textarea name="award_desc" cols="20" rows="4" class="summernote" >{{((isset($about_page) && $about_page->award_desc) ? $about_page->award_desc : Input::old('award_desc'))}}</textarea>
                        </div> --}}

                        

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">FontAwesome Icons</h4>
                                    </div>
                                    <div class="modal-body">
                                        @include('layouts.icons')
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
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


<script>
    $(document).ready(function() { 
        $('p.alert').delay(7000).slideUp(700);
    });
</script>

<script type="text/javascript">
    $('p.gj_bk_alt').delay(7000).slideUp(700);

    $('.summernote').summernote({
        placeholder: 'Enter Description',
        tabsize: 2,
        height: 100
    });

  
</script>
<script>
    document.getElementById("video").addEventListener("change", function(event) {
        let file = event.target.files[0];
        if (file) {
            let videoURL = URL.createObjectURL(file);
            document.getElementById("previewSrc").src = videoURL;
            document.getElementById("videoPreview").style.display = "block";
        }
    });
</script>

@endsection
