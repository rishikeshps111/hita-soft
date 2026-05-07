@extends('layouts.master')
@section('title', 'Artist Settings')
@section('content')
<section class="gj_artist_setting">
    <div class="row gj_row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            @include('layouts.sidebar')
        </div>

        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <ul class="breadcrumb">
                        <li class=""><a> Home  </a></li>
                        <li class="active"><a> Artist Settings  </a></li>
                    </ul> -->
                    @if(Session::has('message'))
                        <p class="alert gj_bk_alt {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                </div>
            </div>

            <div class="gj_box dark">
                <header>
                    <div class="gj_icons"><i class="fa fa-edit"></i></div>
                    <h5 class="gj_heading"> Artist Settings  </h5>
                </header>

                <div class="col-md-12">
                    {{ Form::open(array('url' => 'artist_setting','class'=>'gj_artist_form','files' => true)) }}
                        <div class="form-group">
                            {{ Form::label('main_heading', 'Main Heading') }}
                            <span class="error">* 
                                @if ($errors->has('main_heading'))
                                    {{ $errors->first('main_heading') }}
                                @endif
                            </span>
                            @if(isset($artist))
                                {{ Form::hidden('id', ($artist->id ? $artist->id : ''), array('class' => 'form-control')) }}

                                {{ Form::text('main_heading', ($artist->main_heading ? $artist->main_heading : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::hidden('id', Input::old('id'), array('class' => 'form-control')) }}

                                {{ Form::text('main_heading', Input::old('main_heading'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($artist))
                                @if($artist->first_bg != '')
                                <div class="form-group">
                                    {{ Form::label('current_first_bg', 'Current Artist First BG Image') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($artist->first_bg)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_first_bg', ($artist->first_bg ? $artist->first_bg : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('first_bg', 'Upload Artist First BG Image') }}
                                <span class="error">* 
                                    @if ($errors->has('first_bg'))
                                        {{ $errors->first('first_bg') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="first_bg" id="first_bg" accept="image/*" class="gj_first_bg">
                            </div>
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($artist))
                                @if($artist->first_poster != '')
                                <div class="form-group">
                                    <div class="gj_oldpad_div">
                                        {{ Form::label('current_first_poster', 'Current Artist First Poster Image') }}
                                        <div class="gj_mc_div">
                                           <img src="{{ asset($artist->first_poster)}}" class="img-responsive"> 

                                           <span class="gj_cls_pstr"><i class="fa fa-close"></i></span>
                                        </div>
                                    </div>
                                    {{ Form::hidden('old_first_poster', ($artist->first_poster ? $artist->first_poster : ''), array('class' => 'form-control gj_old_first_poster')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('first_poster', 'Upload Artist First Poster Image') }}
                                <span class="error"> 
                                    @if ($errors->has('first_poster'))
                                        {{ $errors->first('first_poster') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="first_poster" id="first_poster" accept="image/*" class="gj_first_poster">
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('first_link_text', 'First Artist Link Text') }}
                            <span class="error">* 
                                @if ($errors->has('first_link_text'))
                                    {{ $errors->first('first_link_text') }}
                                @endif
                            </span>
                            @if(isset($artist))
                                {{ Form::text('first_link_text', ($artist->first_link_text ? $artist->first_link_text : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('first_link_text', Input::old('first_link_text'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('first_link', 'First Artist Link') }}
                            <span class="error">* 
                                @if ($errors->has('first_link'))
                                    {{ $errors->first('first_link') }}
                                @endif
                            </span>
                            @if(isset($artist))
                                {{ Form::text('first_link', ($artist->first_link ? $artist->first_link : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('first_link', Input::old('first_link'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('first_caption1', 'First Artist Caption1') }}
                            <span class="error"> 
                                @if ($errors->has('first_caption1'))
                                    {{ $errors->first('first_caption1') }}
                                @endif
                            </span>
                            @if(isset($artist))
                                {{ Form::text('first_caption1', ($artist->first_caption1 ? $artist->first_caption1 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('first_caption1', Input::old('first_caption1'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('first_caption2', 'First Artist Caption2') }}
                            <span class="error"> 
                                @if ($errors->has('first_caption2'))
                                    {{ $errors->first('first_caption2') }}
                                @endif
                            </span>
                            @if(isset($artist))
                                {{ Form::text('first_caption2', ($artist->first_caption2 ? $artist->first_caption2 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('first_caption2', Input::old('first_caption2'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($artist))
                                @if($artist->second_bg != '')
                                <div class="form-group">
                                    {{ Form::label('current_second_bg', 'Current Artist Second BG Image') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($artist->second_bg)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_second_bg', ($artist->second_bg ? $artist->second_bg : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('second_bg', 'Upload Artist Second BG Image') }}
                                <span class="error">* 
                                    @if ($errors->has('second_bg'))
                                        {{ $errors->first('second_bg') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="second_bg" id="second_bg" accept="image/*" class="gj_second_bg">
                            </div>
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($artist))
                                @if($artist->second_poster != '')
                                <div class="form-group">
                                    <div class="gj_oldpad_div">
                                        {{ Form::label('current_second_poster', 'Current Artist Second Poster Image') }}
                                        <div class="gj_mc_div">
                                           <img src="{{ asset($artist->second_poster)}}" class="img-responsive"> 

                                           <span class="gj_cls_pstr"><i class="fa fa-close"></i></span>
                                        </div>
                                    </div>
                                    {{ Form::hidden('old_second_poster', ($artist->second_poster ? $artist->second_poster : ''), array('class' => 'form-control gj_old_second_poster')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('second_poster', 'Upload Artist Second Poster Image') }}
                                <span class="error"> 
                                    @if ($errors->has('second_poster'))
                                        {{ $errors->first('second_poster') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="second_poster" id="second_poster" accept="image/*" class="gj_second_poster">
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('second_link_text', 'Second Artist Link Text') }}
                            <span class="error">* 
                                @if ($errors->has('second_link_text'))
                                    {{ $errors->first('second_link_text') }}
                                @endif
                            </span>
                            @if(isset($artist))
                                {{ Form::text('second_link_text', ($artist->second_link_text ? $artist->second_link_text : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('second_link_text', Input::old('second_link_text'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('second_link', 'Second Artist Link') }}
                            <span class="error">* 
                                @if ($errors->has('second_link'))
                                    {{ $errors->first('second_link') }}
                                @endif
                            </span>
                            @if(isset($artist))
                                {{ Form::text('second_link', ($artist->second_link ? $artist->second_link : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('second_link', Input::old('second_link'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('second_caption1', 'Second Artist Caption1') }}
                            <span class="error"> 
                                @if ($errors->has('second_caption1'))
                                    {{ $errors->first('second_caption1') }}
                                @endif
                            </span>
                            @if(isset($artist))
                                {{ Form::text('second_caption1', ($artist->second_caption1 ? $artist->second_caption1 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('second_caption1', Input::old('second_caption1'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('second_caption2', 'Second Artist Caption2') }}
                            <span class="error"> 
                                @if ($errors->has('second_caption2'))
                                    {{ $errors->first('second_caption2') }}
                                @endif
                            </span>
                            @if(isset($artist))
                                {{ Form::text('second_caption2', ($artist->second_caption2 ? $artist->second_caption2 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('second_caption2', Input::old('second_caption2'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($artist))
                                @if($artist->third_bg != '')
                                <div class="form-group">
                                    {{ Form::label('current_third_bg', 'Current Artist Third BG Image') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($artist->third_bg)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_third_bg', ($artist->third_bg ? $artist->third_bg : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('third_bg', 'Upload Artist Third BG Image') }}
                                <span class="error">* 
                                    @if ($errors->has('third_bg'))
                                        {{ $errors->first('third_bg') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="third_bg" id="third_bg" accept="image/*" class="gj_third_bg">
                            </div>
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($artist))
                                @if($artist->third_poster != '')
                                <div class="form-group">
                                    <div class="gj_oldpad_div">
                                        {{ Form::label('current_third_poster', 'Current Artist Third Poster Image') }}
                                        <div class="gj_mc_div">
                                           <img src="{{ asset($artist->third_poster)}}" class="img-responsive"> 

                                           <span class="gj_cls_pstr"><i class="fa fa-close"></i></span>
                                        </div>
                                    </div>
                                    {{ Form::hidden('old_third_poster', ($artist->third_poster ? $artist->third_poster : ''), array('class' => 'form-control gj_old_third_poster')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('third_poster', 'Upload Artist Third Poster Image') }}
                                <span class="error"> 
                                    @if ($errors->has('third_poster'))
                                        {{ $errors->first('third_poster') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="third_poster" id="third_poster" accept="image/*" class="gj_third_poster">
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('third_link_text', 'Third Artist Link Text') }}
                            <span class="error">* 
                                @if ($errors->has('third_link_text'))
                                    {{ $errors->first('third_link_text') }}
                                @endif
                            </span>
                            @if(isset($artist))
                                {{ Form::text('third_link_text', ($artist->third_link_text ? $artist->third_link_text : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('third_link_text', Input::old('third_link_text'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('third_link', 'Third Artist Link') }}
                            <span class="error">* 
                                @if ($errors->has('third_link'))
                                    {{ $errors->first('third_link') }}
                                @endif
                            </span>
                            @if(isset($artist))
                                {{ Form::text('third_link', ($artist->third_link ? $artist->third_link : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('third_link', Input::old('third_link'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('third_caption1', 'Third Artist Caption1') }}
                            <span class="error"> 
                                @if ($errors->has('third_caption1'))
                                    {{ $errors->first('third_caption1') }}
                                @endif
                            </span>
                            @if(isset($artist))
                                {{ Form::text('third_caption1', ($artist->third_caption1 ? $artist->third_caption1 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('third_caption1', Input::old('third_caption1'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('third_caption2', 'Third Artist Caption2') }}
                            <span class="error"> 
                                @if ($errors->has('third_caption2'))
                                    {{ $errors->first('third_caption2') }}
                                @endif
                            </span>
                            @if(isset($artist))
                                {{ Form::text('third_caption2', ($artist->third_caption2 ? $artist->third_caption2 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('third_caption2', Input::old('third_caption2'), array('class' => 'form-control')) }}
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

    $('.gj_cls_pstr').click(function() {
        $(this).closest('.form-group').remove();
    });
</script>
@endsection