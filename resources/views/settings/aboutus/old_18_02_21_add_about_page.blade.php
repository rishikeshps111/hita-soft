@extends('layouts.master')
@section('title', 'Add CMS About Us Page')
@section('content')
<section class="gj_abou_setting">
    <div class="row gj_row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            @include('layouts.sidebar')
        </div>

        <div class="col-md-9 col-sm-9 col-xs-12">
            <!-- <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <li class=""><a> Home  </a></li>
                        <li class="active"><a> Add CMS About Us Page  </a></li>
                    </ul>
                </div>
            </div> -->

            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <header>
                    <div class="gj_icons"><i class="fa fa-edit"></i></div>
                    <h5 class="gj_heading"> Add CMS About Us Page  </h5>
                </header>

                <div class="col-md-12">
                    {{ Form::open(array('url' => 'add_about_page','class'=>'gj_about_cms_form','files' => true)) }}
                        @if(isset($about_page))
                            @if($about_page)
                                {{ Form::hidden('a_id', $about_page->id, array('class' => 'form-control gj_a_id')) }}
                            @endif
                        @endif

                        <div class="form-group">
                            {{ Form::label('abo_title', 'Title') }}
                            <span class="error">* 
                                @if ($errors->has('abo_title'))
                                    {{ $errors->first('abo_title') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                {{ Form::text('abo_title', ($about_page->abo_title ? $about_page->abo_title : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('abo_title', Input::old('abo_title'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('abo_desc', 'Description') }}
                            <span class="error">* 
                                @if ($errors->has('abo_desc'))
                                    {{ $errors->first('abo_desc') }}
                                @endif
                            </span>

                            <textarea name="abo_desc" cols="20" rows="4" class="summernote" >{{((isset($about_page) && $about_page->abo_desc) ? $about_page->abo_desc : Input::old('abo_desc'))}}</textarea>
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($about_page))
                                @if($about_page->abo_img != '')
                                <div class="form-group">
                                    {{ Form::label('current_abo_img', 'Current About Image') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($about_page->abo_img)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_abo_img', ($about_page->abo_img ? $about_page->abo_img : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('abo_img', 'Upload About Image') }}
                                <span class="error">* 
                                    @if ($errors->has('abo_img'))
                                        {{ $errors->first('abo_img') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="abo_img" id="abo_img" accept="image/*" class="gj_abo_img">
                            </div>
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($about_page))
                                @if($about_page->banner_image != '')
                                <div class="form-group">
                                    {{ Form::label('current_banner_image', 'Current Banner Image') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($about_page->banner_image)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_banner_image', ($about_page->banner_image ? $about_page->banner_image : ''), array('class' => 'form-control')) }}
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
                            @if(isset($about_page))
                                {{ Form::text('banner_caption', ($about_page->banner_caption ? $about_page->banner_caption : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('banner_caption', Input::old('banner_caption'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('mission_hd', 'Mission Heading') }}
                            <span class="error">* 
                                @if ($errors->has('mission_hd'))
                                    {{ $errors->first('mission_hd') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                {{ Form::text('mission_hd', ($about_page->mission_hd ? $about_page->mission_hd : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('mission_hd', Input::old('mission_hd'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('mission_desc', 'Mission Description') }}
                            <span class="error">* 
                                @if ($errors->has('mission_desc'))
                                    {{ $errors->first('mission_desc') }}
                                @endif
                            </span>

                            <textarea name="mission_desc" cols="20" rows="4" class="summernote" >{{((isset($about_page) && $about_page->mission_desc) ? $about_page->mission_desc : Input::old('mission_desc'))}}</textarea>
                        </div>

                        <div class="form-group">
                            {{ Form::label('mission_link_text', 'Mission Link Text') }}
                            <span class="error">* 
                                @if ($errors->has('mission_link_text'))
                                    {{ $errors->first('mission_link_text') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                {{ Form::text('mission_link_text', ($about_page->mission_link_text ? $about_page->mission_link_text : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('mission_link_text', Input::old('mission_link_text'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('mission_link', 'Mission Link') }}
                            <span class="error">* 
                                @if ($errors->has('mission_link'))
                                    {{ $errors->first('mission_link') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                {{ Form::text('mission_link', ($about_page->mission_link ? $about_page->mission_link : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('mission_link', Input::old('mission_link'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($about_page))
                                @if($about_page->abo_bg1 != '')
                                <div class="form-group">
                                    {{ Form::label('current_abo_bg1', 'Current About BG Image1') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($about_page->abo_bg1)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_abo_bg1', ($about_page->abo_bg1 ? $about_page->abo_bg1 : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('abo_bg1', 'Upload About BG Image1') }}
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
                            {{ Form::label('vision_hd', 'Vission Heading') }}
                            <span class="error">* 
                                @if ($errors->has('vision_hd'))
                                    {{ $errors->first('vision_hd') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                {{ Form::text('vision_hd', ($about_page->vision_hd ? $about_page->vision_hd : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('vision_hd', Input::old('vision_hd'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('vision_desc', 'Vission Description') }}
                            <span class="error">* 
                                @if ($errors->has('vision_desc'))
                                    {{ $errors->first('vision_desc') }}
                                @endif
                            </span>

                            <textarea name="vision_desc" cols="20" rows="4" class="summernote" >{{((isset($about_page) && $about_page->vision_desc) ? $about_page->vision_desc : Input::old('vision_desc'))}}</textarea>
                        </div>

                        <div class="form-group">
                            {{ Form::label('vision_link_text', 'Vission Link Text') }}
                            <span class="error">* 
                                @if ($errors->has('vision_link_text'))
                                    {{ $errors->first('vision_link_text') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                {{ Form::text('vision_link_text', ($about_page->vision_link_text ? $about_page->vision_link_text : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('vision_link_text', Input::old('vision_link_text'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('vision_link', 'Vission Link') }}
                            <span class="error">* 
                                @if ($errors->has('vision_link'))
                                    {{ $errors->first('vision_link') }}
                                @endif
                            </span>
                            @if(isset($about_page))
                                {{ Form::text('vision_link', ($about_page->vision_link ? $about_page->vision_link : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('vision_link', Input::old('vision_link'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($about_page))
                                @if($about_page->abo_bg2 != '')
                                <div class="form-group">
                                    {{ Form::label('current_abo_bg2', 'Current About BG Image2') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($about_page->abo_bg2)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_abo_bg2', ($about_page->abo_bg2 ? $about_page->abo_bg2 : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('abo_bg2', 'Upload About BG Image2') }}
                                <span class="error">* 
                                    @if ($errors->has('abo_bg2'))
                                        {{ $errors->first('abo_bg2') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="abo_bg2" id="abo_bg2" accept="image/*" class="gj_abo_bg2">
                            </div>
                        </div>

                        {{ Form::submit('Update', array('class' => 'btn btn-primary', 'id'=>'update')) }}

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
