@extends('layouts.master')
@section('title', 'Sell On Folkgems Page Settings')
@section('content')
<section class="gj_sofp_setting">
    <div class="row gj_row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            @include('layouts.sidebar')
        </div>

        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <ul class="breadcrumb">
                        <li class=""><a> Home  </a></li>
                        <li class="active"><a> Sell On Folkgems Page Settings  </a></li>
                    </ul> -->
                    @if(Session::has('message'))
                        <p class="alert gj_bk_alt {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                </div>
            </div>

            <div class="gj_box dark">
                <header>
                    <div class="gj_icons"><i class="fa fa-edit"></i></div>
                    <h5 class="gj_heading"> Sell On Folkgems Page Settings  </h5>
                </header>

                <div class="col-md-12">
                    {{ Form::open(array('url' => 'sofp_setting','class'=>'gj_sofp_form','files' => true)) }}
                        <div class="form-group">
                            {{ Form::label('title', 'Main Title') }}
                            <span class="error">* 
                                @if ($errors->has('title'))
                                    {{ $errors->first('title') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::hidden('id', ($sofp->id ? $sofp->id : ''), array('class' => 'form-control')) }}

                                {{ Form::text('title', ($sofp->title ? $sofp->title : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::hidden('id', Input::old('id'), array('class' => 'form-control')) }}

                                {{ Form::text('title', Input::old('title'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('desc', 'Description') }}
                            <span class="error">* 
                                @if ($errors->has('desc'))
                                    {{ $errors->first('desc') }}
                                @endif
                            </span>

                            <textarea name="desc" cols="20" rows="4" class="summernote" >{{((isset($sofp) && $sofp->desc) ? $sofp->desc : Input::old('desc'))}}</textarea>
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($sofp))
                                @if($sofp->banner_image != '')
                                <div class="form-group">
                                    {{ Form::label('current_banner_image', 'Current Banner Image') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($sofp->banner_image)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_banner_image', ($sofp->banner_image ? $sofp->banner_image : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('banner_image', 'Upload Banner Image') }}
                                <span class="error">* 
                                    @if ($errors->has('banner_image'))
                                        {{ $errors->first('banner_image') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="banner_image" id="banner_image" accept="image/*" class="gj_banner_image">
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('banner_caption', 'Banner Caption') }}
                            <span class="error"> 
                                @if ($errors->has('banner_caption'))
                                    {{ $errors->first('banner_caption') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('banner_caption', ($sofp->banner_caption ? $sofp->banner_caption : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('banner_caption', Input::old('banner_caption'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($sofp))
                                @if($sofp->sell_bg != '')
                                <div class="form-group">
                                    {{ Form::label('current_sell_bg', 'Current Sell On Folkgems BG Image') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($sofp->sell_bg)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_sell_bg', ($sofp->sell_bg ? $sofp->sell_bg : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('sell_bg', 'Upload Sell On Folkgems BG Image') }}
                                <span class="error">* 
                                    @if ($errors->has('sell_bg'))
                                        {{ $errors->first('sell_bg') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="sell_bg" id="sell_bg" accept="image/*" class="gj_sell_bg">
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('sell_content1', 'Sell On Folkgems Content1') }}
                            <span class="error">* 
                                @if ($errors->has('sell_content1'))
                                    {{ $errors->first('sell_content1') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('sell_content1', ($sofp->sell_content1 ? $sofp->sell_content1 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('sell_content1', Input::old('sell_content1'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('sell_content2', 'Sell On Folkgems Content2') }}
                            <span class="error">* 
                                @if ($errors->has('sell_content2'))
                                    {{ $errors->first('sell_content2') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('sell_content2', ($sofp->sell_content2 ? $sofp->sell_content2 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('sell_content2', Input::old('sell_content2'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('button_text', 'Button Text') }}
                            <span class="error"> 
                                @if ($errors->has('button_text'))
                                    {{ $errors->first('button_text') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('button_text', ($sofp->button_text ? $sofp->button_text : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('button_text', Input::old('button_text'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('button_url', 'Button Link') }}
                            <span class="error"> 
                                @if ($errors->has('button_url'))
                                    {{ $errors->first('button_url') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('button_url', ($sofp->button_url ? $sofp->button_url : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('button_url', Input::old('button_url'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('next_main_hd', 'Next Main Heading') }}
                            <span class="error">* 
                                @if ($errors->has('next_main_hd'))
                                    {{ $errors->first('next_main_hd') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('next_main_hd', ($sofp->next_main_hd ? $sofp->next_main_hd : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('next_main_hd', Input::old('next_main_hd'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('why_sell_hd', 'Why Sell Heading') }}
                            <span class="error">* 
                                @if ($errors->has('why_sell_hd'))
                                    {{ $errors->first('why_sell_hd') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('why_sell_hd', ($sofp->why_sell_hd ? $sofp->why_sell_hd : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('why_sell_hd', Input::old('why_sell_hd'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('why_sell_desc', 'Why Sell Description') }}
                            <span class="error">* 
                                @if ($errors->has('why_sell_desc'))
                                    {{ $errors->first('why_sell_desc') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::textarea('why_sell_desc', ($sofp->why_sell_desc ? $sofp->why_sell_desc : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::textarea('why_sell_desc', Input::old('why_sell_desc'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($sofp))
                                @if($sofp->why_img_1 != '')
                                <div class="form-group">
                                    {{ Form::label('current_why_img_1', 'Current Why Sell Image 1') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($sofp->why_img_1)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_why_img_1', ($sofp->why_img_1 ? $sofp->why_img_1 : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('why_img_1', 'Upload Why Sell Image 1') }}
                                <span class="error">* 
                                    @if ($errors->has('why_img_1'))
                                        {{ $errors->first('why_img_1') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="why_img_1" id="why_img_1" accept="image/*" class="gj_why_img_1">
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('why_title_1', 'Why Sell Title 1') }}
                            <span class="error">* 
                                @if ($errors->has('why_title_1'))
                                    {{ $errors->first('why_title_1') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('why_title_1', ($sofp->why_title_1 ? $sofp->why_title_1 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('why_title_1', Input::old('why_title_1'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('why_content_1', 'Why Sell Content 1') }}
                            <span class="error">* 
                                @if ($errors->has('why_content_1'))
                                    {{ $errors->first('why_content_1') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::textarea('why_content_1', ($sofp->why_content_1 ? $sofp->why_content_1 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::textarea('why_content_1', Input::old('why_content_1'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('why_link_text_1', 'Why Sell Link Text 1') }}
                            <span class="error">* 
                                @if ($errors->has('why_link_text_1'))
                                    {{ $errors->first('why_link_text_1') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('why_link_text_1', ($sofp->why_link_text_1 ? $sofp->why_link_text_1 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('why_link_text_1', Input::old('why_link_text_1'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('why_link_1', 'Why Sell Link 1') }}
                            <span class="error">* 
                                @if ($errors->has('why_link_1'))
                                    {{ $errors->first('why_link_1') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('why_link_1', ($sofp->why_link_1 ? $sofp->why_link_1 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('why_link_1', Input::old('why_link_1'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($sofp))
                                @if($sofp->why_img_2 != '')
                                <div class="form-group">
                                    {{ Form::label('current_why_img_2', 'Current Why Sell Image 2') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($sofp->why_img_2)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_why_img_2', ($sofp->why_img_2 ? $sofp->why_img_2 : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('why_img_2', 'Upload Why Sell Image 2') }}
                                <span class="error">* 
                                    @if ($errors->has('why_img_2'))
                                        {{ $errors->first('why_img_2') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="why_img_2" id="why_img_2" accept="image/*" class="gj_why_img_2">
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('why_title_2', 'Why Sell Title 2') }}
                            <span class="error">* 
                                @if ($errors->has('why_title_2'))
                                    {{ $errors->first('why_title_2') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('why_title_2', ($sofp->why_title_2 ? $sofp->why_title_2 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('why_title_2', Input::old('why_title_2'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('why_content_2', 'Why Sell Content 2') }}
                            <span class="error">* 
                                @if ($errors->has('why_content_2'))
                                    {{ $errors->first('why_content_2') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::textarea('why_content_2', ($sofp->why_content_2 ? $sofp->why_content_2 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::textarea('why_content_2', Input::old('why_content_2'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('why_link_text_2', 'Why Sell Link Text 2') }}
                            <span class="error">* 
                                @if ($errors->has('why_link_text_2'))
                                    {{ $errors->first('why_link_text_2') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('why_link_text_2', ($sofp->why_link_text_2 ? $sofp->why_link_text_2 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('why_link_text_2', Input::old('why_link_text_2'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('why_link_2', 'Why Sell Link 2') }}
                            <span class="error">* 
                                @if ($errors->has('why_link_2'))
                                    {{ $errors->first('why_link_2') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('why_link_2', ($sofp->why_link_2 ? $sofp->why_link_2 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('why_link_2', Input::old('why_link_2'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($sofp))
                                @if($sofp->why_img_3 != '')
                                <div class="form-group">
                                    {{ Form::label('current_why_img_3', 'Current Why Sell Image 3') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($sofp->why_img_3)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_why_img_3', ($sofp->why_img_3 ? $sofp->why_img_3 : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('why_img_3', 'Upload Why Sell Image 3') }}
                                <span class="error">* 
                                    @if ($errors->has('why_img_3'))
                                        {{ $errors->first('why_img_3') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="why_img_3" id="why_img_3" accept="image/*" class="gj_why_img_3">
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('why_title_3', 'Why Sell Title 3') }}
                            <span class="error">* 
                                @if ($errors->has('why_title_3'))
                                    {{ $errors->first('why_title_3') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('why_title_3', ($sofp->why_title_3 ? $sofp->why_title_3 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('why_title_3', Input::old('why_title_3'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('why_content_3', 'Why Sell Content 3') }}
                            <span class="error">* 
                                @if ($errors->has('why_content_3'))
                                    {{ $errors->first('why_content_3') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::textarea('why_content_3', ($sofp->why_content_3 ? $sofp->why_content_3 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::textarea('why_content_3', Input::old('why_content_3'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('why_link_text_3', 'Why Sell Link Text 3') }}
                            <span class="error">* 
                                @if ($errors->has('why_link_text_3'))
                                    {{ $errors->first('why_link_text_3') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('why_link_text_3', ($sofp->why_link_text_3 ? $sofp->why_link_text_3 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('why_link_text_3', Input::old('why_link_text_3'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('why_link_3', 'Why Sell Link 3') }}
                            <span class="error">* 
                                @if ($errors->has('why_link_3'))
                                    {{ $errors->first('why_link_3') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('why_link_3', ($sofp->why_link_3 ? $sofp->why_link_3 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('why_link_3', Input::old('why_link_3'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('how_it_hd', 'How It Heading') }}
                            <span class="error">* 
                                @if ($errors->has('how_it_hd'))
                                    {{ $errors->first('how_it_hd') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('how_it_hd', ($sofp->how_it_hd ? $sofp->how_it_hd : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('how_it_hd', Input::old('how_it_hd'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('how_it_desc', 'How It Description') }}
                            <span class="error">* 
                                @if ($errors->has('how_it_desc'))
                                    {{ $errors->first('how_it_desc') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::textarea('how_it_desc', ($sofp->how_it_desc ? $sofp->how_it_desc : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::textarea('how_it_desc', Input::old('how_it_desc'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('how_title_1', 'How It Title 1') }}
                            <span class="error">* 
                                @if ($errors->has('how_title_1'))
                                    {{ $errors->first('how_title_1') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('how_title_1', ($sofp->how_title_1 ? $sofp->how_title_1 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('how_title_1', Input::old('how_title_1'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('how_content_1', 'How It Content 1') }}
                            <span class="error">* 
                                @if ($errors->has('how_content_1'))
                                    {{ $errors->first('how_content_1') }}
                                @endif
                            </span>

                            <textarea name="how_content_1" cols="20" rows="4" class="summernote" >{{((isset($sofp) && $sofp->how_content_1) ? $sofp->how_content_1 : Input::old('how_content_1'))}}</textarea>
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($sofp))
                                @if($sofp->how_img_1 != '')
                                <div class="form-group">
                                    {{ Form::label('current_how_img_1', 'Current How It Image 1') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($sofp->how_img_1)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_how_img_1', ($sofp->how_img_1 ? $sofp->how_img_1 : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('how_img_1', 'Upload How It Image 1') }}
                                <span class="error">* 
                                    @if ($errors->has('how_img_1'))
                                        {{ $errors->first('how_img_1') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="how_img_1" id="how_img_1" accept="image/*" class="gj_how_img_1">
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('how_title_2', 'How It Title 2') }}
                            <span class="error">* 
                                @if ($errors->has('how_title_2'))
                                    {{ $errors->first('how_title_2') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('how_title_2', ($sofp->how_title_2 ? $sofp->how_title_2 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('how_title_2', Input::old('how_title_2'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('how_content_2', 'How It Content 2') }}
                            <span class="error">* 
                                @if ($errors->has('how_content_2'))
                                    {{ $errors->first('how_content_2') }}
                                @endif
                            </span>

                            <textarea name="how_content_2" cols="20" rows="4" class="summernote" >{{((isset($sofp) && $sofp->how_content_2) ? $sofp->how_content_2 : Input::old('how_content_2'))}}</textarea>
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($sofp))
                                @if($sofp->how_img_2 != '')
                                <div class="form-group">
                                    {{ Form::label('current_how_img_2', 'Current How It Image 2') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($sofp->how_img_2)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_how_img_2', ($sofp->how_img_2 ? $sofp->how_img_2 : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('how_img_2', 'Upload How It Image 2') }}
                                <span class="error">* 
                                    @if ($errors->has('how_img_2'))
                                        {{ $errors->first('how_img_2') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="how_img_2" id="how_img_2" accept="image/*" class="gj_how_img_2">
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('how_title_3', 'How It Title 3') }}
                            <span class="error">* 
                                @if ($errors->has('how_title_3'))
                                    {{ $errors->first('how_title_3') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('how_title_3', ($sofp->how_title_3 ? $sofp->how_title_3 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('how_title_3', Input::old('how_title_3'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('how_content_3', 'How It Content 3') }}
                            <span class="error">* 
                                @if ($errors->has('how_content_3'))
                                    {{ $errors->first('how_content_3') }}
                                @endif
                            </span>

                            <textarea name="how_content_3" cols="20" rows="4" class="summernote" >{{((isset($sofp) && $sofp->how_content_3) ? $sofp->how_content_3 : Input::old('how_content_3'))}}</textarea>
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($sofp))
                                @if($sofp->how_img_3 != '')
                                <div class="form-group">
                                    {{ Form::label('current_how_img_3', 'Current How It Image 3') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($sofp->how_img_3)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_how_img_3', ($sofp->how_img_3 ? $sofp->how_img_3 : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('how_img_3', 'Upload How It Image 3') }}
                                <span class="error">* 
                                    @if ($errors->has('how_img_3'))
                                        {{ $errors->first('how_img_3') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="how_img_3" id="how_img_3" accept="image/*" class="gj_how_img_3">
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('how_title_4', 'How It Title 4') }}
                            <span class="error">* 
                                @if ($errors->has('how_title_4'))
                                    {{ $errors->first('how_title_4') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('how_title_4', ($sofp->how_title_4 ? $sofp->how_title_4 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('how_title_4', Input::old('how_title_4'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('how_content_4', 'How It Content 4') }}
                            <span class="error">* 
                                @if ($errors->has('how_content_4'))
                                    {{ $errors->first('how_content_4') }}
                                @endif
                            </span>

                            <textarea name="how_content_4" cols="20" rows="4" class="summernote">{{((isset($sofp) && $sofp->how_content_4) ? $sofp->how_content_4 : Input::old('how_content_4'))}}</textarea>
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($sofp))
                                @if($sofp->how_img_4 != '')
                                <div class="form-group">
                                    {{ Form::label('current_how_img_4', 'Current How It Image 4') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($sofp->how_img_4)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_how_img_4', ($sofp->how_img_4 ? $sofp->how_img_4 : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('how_img_4', 'Upload How It Image 4') }}
                                <span class="error">* 
                                    @if ($errors->has('how_img_4'))
                                        {{ $errors->first('how_img_4') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="how_img_4" id="how_img_4" accept="image/*" class="gj_how_img_4">
                            </div>
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($sofp))
                                @if($sofp->start_sell_bg != '')
                                <div class="form-group">
                                    {{ Form::label('current_start_sell_bg', 'Current Start Sell BG Image') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($sofp->start_sell_bg)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_start_sell_bg', ($sofp->start_sell_bg ? $sofp->start_sell_bg : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('start_sell_bg', 'Upload Start Sell BG Image') }}
                                <span class="error">* 
                                    @if ($errors->has('start_sell_bg'))
                                        {{ $errors->first('start_sell_bg') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="start_sell_bg" id="start_sell_bg" accept="image/*" class="gj_start_sell_bg">
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('start_sell_content', 'Start Sell Content') }}
                            <span class="error">* 
                                @if ($errors->has('start_sell_content'))
                                    {{ $errors->first('start_sell_content') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('start_sell_content', ($sofp->start_sell_content ? $sofp->start_sell_content : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('start_sell_content', Input::old('start_sell_content'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('start_sell_link_text', 'Start Sell Link Text') }}
                            <span class="error">* 
                                @if ($errors->has('start_sell_link_text'))
                                    {{ $errors->first('start_sell_link_text') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('start_sell_link_text', ($sofp->start_sell_link_text ? $sofp->start_sell_link_text : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('start_sell_link_text', Input::old('start_sell_link_text'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('start_sell_link', 'Start Sell Link') }}
                            <span class="error">* 
                                @if ($errors->has('start_sell_link'))
                                    {{ $errors->first('start_sell_link') }}
                                @endif
                            </span>
                            @if(isset($sofp))
                                {{ Form::text('start_sell_link', ($sofp->start_sell_link ? $sofp->start_sell_link : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('start_sell_link', Input::old('start_sell_link'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}

                    {{ Form::close() }}
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
@endsection