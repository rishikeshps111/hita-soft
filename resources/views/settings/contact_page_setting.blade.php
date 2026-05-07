@extends('layouts.master')
@section('title', 'Contact Us Page Settings')
@section('content')
<section class="gj_contact_setting">
    <div class="row gj_row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            @include('layouts.sidebar')
        </div>

        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <ul class="breadcrumb">
                        <li class=""><a> Home  </a></li>
                        <li class="active"><a> Contact Us Page Settings  </a></li>
                    </ul> -->
                    @if(Session::has('message'))
                        <p class="alert gj_bk_alt {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                </div>
            </div>

            <div class="gj_box dark">
                <header>
                    <div class="gj_icons"><i class="fa fa-edit"></i></div>
                    <h5 class="gj_heading"> Contact Us Page Settings  </h5>
                </header>

                <div class="col-md-12">
                    {{ Form::open(array('url' => 'contact_page_setting','class'=>'gj_contact_form','files' => true)) }}
                        <div class="form-group">
                            {{ Form::label('main_hd', 'Main Heading') }}
                            <span class="error">* 
                                @if ($errors->has('main_hd'))
                                    {{ $errors->first('main_hd') }}
                                @endif
                            </span>
                            @if(isset($contact))
                                {{ Form::hidden('id', ($contact->id ? $contact->id : ''), array('class' => 'form-control')) }}

                                {{ Form::text('main_hd', ($contact->main_hd ? $contact->main_hd : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::hidden('id', Input::old('id'), array('class' => 'form-control')) }}

                                {{ Form::text('main_hd', Input::old('main_hd'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('content_1', 'Content 1') }}
                            <span class="error">* 
                                @if ($errors->has('content_1'))
                                    {{ $errors->first('content_1') }}
                                @endif
                            </span>

                            <textarea name="content_1" cols="20" rows="4" class="summernote">{{((isset($contact) && $contact->content_1) ? $contact->content_1 : Input::old('content_1'))}}</textarea>
                        </div>

                        <div class="form-group">
                            {{ Form::label('content_2', 'Content 2') }}
                            <span class="error">* 
                                @if ($errors->has('content_2'))
                                    {{ $errors->first('content_2') }}
                                @endif
                            </span>

                            <textarea name="content_2" cols="20" rows="4" class="summernote">{{((isset($contact) && $contact->content_2) ? $contact->content_2 : Input::old('content_2'))}}</textarea>
                        </div>

                        <div class="form-group">
                            {{ Form::label('content_3', 'Content 3') }}
                            <span class="error">* 
                                @if ($errors->has('content_3'))
                                    {{ $errors->first('content_3') }}
                                @endif
                            </span>

                            <textarea name="content_3" cols="20" rows="4" class="summernote">{{((isset($contact) && $contact->content_3) ? $contact->content_3 : Input::old('content_3'))}}</textarea>
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($contact))
                                @if($contact->banner_image != '')
                                <div class="form-group">
                                    {{ Form::label('current_banner_image', 'Current Banner Image') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($contact->banner_image)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_banner_image', ($contact->banner_image ? $contact->banner_image : ''), array('class' => 'form-control')) }}
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
                            @if(isset($contact))
                                {{ Form::text('banner_caption', ($contact->banner_caption ? $contact->banner_caption : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('banner_caption', Input::old('banner_caption'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('touch_hd', 'Touch Heading') }}
                            <span class="error">* 
                                @if ($errors->has('touch_hd'))
                                    {{ $errors->first('touch_hd') }}
                                @endif
                            </span>
                            @if(isset($contact))
                                {{ Form::text('touch_hd', ($contact->touch_hd ? $contact->touch_hd : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('touch_hd', Input::old('touch_hd'), array('class' => 'form-control')) }}
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
        placeholder: 'Enter Content',
        tabsize: 2,
        height: 100
    });
</script>
@endsection