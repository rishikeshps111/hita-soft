@extends('layouts.master')
@section('title', 'Widget Settings')
@section('content')
<section class="gj_widget_setting">
    <div class="row gj_row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            @include('layouts.sidebar')
        </div>

        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <ul class="breadcrumb">
                        <li class=""><a> Home  </a></li>
                        <li class="active"><a> Widget Settings  </a></li>
                    </ul> -->
                    @if(Session::has('message'))
                        <p class="alert gj_bk_alt {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                </div>
            </div>

            <div class="gj_box dark">
                <header>
                    <div class="gj_icons"><i class="fa fa-edit"></i></div>
                    <h5 class="gj_heading"> Widget Settings  </h5>
                </header>

                <div class="col-md-12">
                    {{ Form::open(array('url' => 'widget_setting','class'=>'gj_widget_form','files' => true)) }}
                        <div class="form-group">
                            {{ Form::label('first_title', 'First Widget Title') }}
                            <span class="error">* 
                                @if ($errors->has('first_title'))
                                    {{ $errors->first('first_title') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::hidden('id', ($widget->id ? $widget->id : ''), array('class' => 'form-control')) }}

                                {{ Form::text('first_title', ($widget->first_title ? $widget->first_title : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::hidden('id', Input::old('id'), array('class' => 'form-control')) }}

                                {{ Form::text('first_title', Input::old('first_title'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('first_content', 'First Widgte Content') }}
                            <span class="error">* 
                                @if ($errors->has('first_content'))
                                    {{ $errors->first('first_content') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('first_content', ($widget->first_content ? $widget->first_content : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('first_content', Input::old('first_content'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('first_url', 'First Widget URL') }}
                            <span class="error"> 
                                @if ($errors->has('first_url'))
                                    {{ $errors->first('first_url') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('first_url', ($widget->first_url ? $widget->first_url : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('first_url', Input::old('first_url'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('first_icon', 'First Widget Icon') }}
                            <span class="error">* 
                                @if ($errors->has('first_icon'))
                                    {{ $errors->first('first_icon') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('first_icon', ($widget->first_icon ? $widget->first_icon : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('first_icon', Input::old('first_icon'), array('class' => 'form-control')) }}
                            @endif

                            <p class="gj_lt_fa">View Icon Codes : <button type="button" class="gj_lt_icons" data-toggle="modal" data-target="#myModal">FontAwesome Icons</button></p>

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
                        </div>

                        <div class="form-group">
                            {{ Form::label('second_title', 'Second Widget Title') }}
                            <span class="error">* 
                                @if ($errors->has('second_title'))
                                    {{ $errors->first('second_title') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('second_title', ($widget->second_title ? $widget->second_title : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('second_title', Input::old('second_title'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('second_content', 'Second Widgte Content') }}
                            <span class="error">* 
                                @if ($errors->has('second_content'))
                                    {{ $errors->first('second_content') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('second_content', ($widget->second_content ? $widget->second_content : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('second_content', Input::old('second_content'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('second_url', 'Second Widget URL') }}
                            <span class="error"> 
                                @if ($errors->has('second_url'))
                                    {{ $errors->first('second_url') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('second_url', ($widget->second_url ? $widget->second_url : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('second_url', Input::old('second_url'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('second_icon', 'Second Widget Icon') }}
                            <span class="error">* 
                                @if ($errors->has('second_icon'))
                                    {{ $errors->first('second_icon') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('second_icon', ($widget->second_icon ? $widget->second_icon : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('second_icon', Input::old('second_icon'), array('class' => 'form-control')) }}
                            @endif

                            <p class="gj_lt_fa">View Icon Codes : <button type="button" class="gj_lt_icons" data-toggle="modal" data-target="#myModal">FontAwesome Icons</button></p>
                        </div>

                        <div class="form-group">
                            {{ Form::label('third_title', 'Third Widget Title') }}
                            <span class="error">* 
                                @if ($errors->has('third_title'))
                                    {{ $errors->first('third_title') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('third_title', ($widget->third_title ? $widget->third_title : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('third_title', Input::old('third_title'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('third_content', 'Third Widgte Content') }}
                            <span class="error">* 
                                @if ($errors->has('third_content'))
                                    {{ $errors->first('third_content') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('third_content', ($widget->third_content ? $widget->third_content : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('third_content', Input::old('third_content'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('third_url', 'Third Widget URL') }}
                            <span class="error"> 
                                @if ($errors->has('third_url'))
                                    {{ $errors->first('third_url') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('third_url', ($widget->third_url ? $widget->third_url : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('third_url', Input::old('third_url'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('third_icon', 'Third Widget Icon') }}
                            <span class="error">* 
                                @if ($errors->has('third_icon'))
                                    {{ $errors->first('third_icon') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('third_icon', ($widget->third_icon ? $widget->third_icon : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('third_icon', Input::old('third_icon'), array('class' => 'form-control')) }}
                            @endif

                            <p class="gj_lt_fa">View Icon Codes : <button type="button" class="gj_lt_icons" data-toggle="modal" data-target="#myModal">FontAwesome Icons</button></p>
                        </div>

                        <div class="form-group">
                            {{ Form::label('fourth_title', 'Fourth Widget Title') }}
                            <span class="error">* 
                                @if ($errors->has('fourth_title'))
                                    {{ $errors->first('fourth_title') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('fourth_title', ($widget->fourth_title ? $widget->fourth_title : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('fourth_title', Input::old('fourth_title'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('fourth_content', 'Fourth Widgte Content') }}
                            <span class="error">* 
                                @if ($errors->has('fourth_content'))
                                    {{ $errors->first('fourth_content') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('fourth_content', ($widget->fourth_content ? $widget->fourth_content : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('fourth_content', Input::old('fourth_content'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('fourth_url', 'Fourth Widget URL') }}
                            <span class="error"> 
                                @if ($errors->has('fourth_url'))
                                    {{ $errors->first('fourth_url') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('fourth_url', ($widget->fourth_url ? $widget->fourth_url : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('fourth_url', Input::old('fourth_url'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('fourth_icon', 'Fourth Widget Icon') }}
                            <span class="error">* 
                                @if ($errors->has('fourth_icon'))
                                    {{ $errors->first('fourth_icon') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('fourth_icon', ($widget->fourth_icon ? $widget->fourth_icon : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('fourth_icon', Input::old('fourth_icon'), array('class' => 'form-control')) }}
                            @endif

                            <p class="gj_lt_fa">View Icon Codes : <button type="button" class="gj_lt_icons" data-toggle="modal" data-target="#myModal">FontAwesome Icons</button></p>
                        </div>

                        <div class="form-group">
                            {{ Form::label('fifth_title', 'Fifth Widget Title') }}
                            <span class="error">* 
                                @if ($errors->has('fifth_title'))
                                    {{ $errors->first('fifth_title') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('fifth_title', ($widget->fifth_title ? $widget->fifth_title : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('fifth_title', Input::old('fifth_title'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('fifth_content', 'Fifth Widgte Content') }}
                            <span class="error">* 
                                @if ($errors->has('fifth_content'))
                                    {{ $errors->first('fifth_content') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('fifth_content', ($widget->fifth_content ? $widget->fifth_content : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('fifth_content', Input::old('fifth_content'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('fifth_url', 'Fifth Widget URL') }}
                            <span class="error"> 
                                @if ($errors->has('fifth_url'))
                                    {{ $errors->first('fifth_url') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('fifth_url', ($widget->fifth_url ? $widget->fifth_url : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('fifth_url', Input::old('fifth_url'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('fifth_icon', 'Fifth Widget Icon') }}
                            <span class="error">* 
                                @if ($errors->has('fifth_icon'))
                                    {{ $errors->first('fifth_icon') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('fifth_icon', ($widget->fifth_icon ? $widget->fifth_icon : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('fifth_icon', Input::old('fifth_icon'), array('class' => 'form-control')) }}
                            @endif

                            <p class="gj_lt_fa">View Icon Codes : <button type="button" class="gj_lt_icons" data-toggle="modal" data-target="#myModal">FontAwesome Icons</button></p>
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($widget))
                                @if($widget->start_sell_bg != '')
                                <div class="form-group">
                                    {{ Form::label('current_start_sell_bg', 'Current Start Sell BG Image') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($widget->start_sell_bg)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_start_sell_bg', ($widget->start_sell_bg ? $widget->start_sell_bg : ''), array('class' => 'form-control')) }}
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
                            {{ Form::label('start_sell_hd_1', 'Start Sell First Heading') }}
                            <span class="error"> 
                                @if ($errors->has('start_sell_hd_1'))
                                    {{ $errors->first('start_sell_hd_1') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('start_sell_hd_1', ($widget->start_sell_hd_1 ? $widget->start_sell_hd_1 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('start_sell_hd_1', Input::old('start_sell_hd_1'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('start_sell_button', 'Start Sell Button Text') }}
                            <span class="error"> 
                                @if ($errors->has('start_sell_button'))
                                    {{ $errors->first('start_sell_button') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('start_sell_button', ($widget->start_sell_button ? $widget->start_sell_button : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('start_sell_button', Input::old('start_sell_button'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('start_sell_button_link', 'Start Sell Button Link') }}
                            <span class="error"> 
                                @if ($errors->has('start_sell_button_link'))
                                    {{ $errors->first('start_sell_button_link') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('start_sell_button_link', ($widget->start_sell_button_link ? $widget->start_sell_button_link : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('start_sell_button_link', Input::old('start_sell_button_link'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('start_sell_hd_2', 'Start Sell Second Heading') }}
                            <span class="error"> 
                                @if ($errors->has('start_sell_hd_2'))
                                    {{ $errors->first('start_sell_hd_2') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('start_sell_hd_2', ($widget->start_sell_hd_2 ? $widget->start_sell_hd_2 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('start_sell_hd_2', Input::old('start_sell_hd_2'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($widget))
                                @if($widget->app_img_1 != '')
                                <div class="form-group">
                                    {{ Form::label('current_app_img_1', 'Current Start Sell App Image 1') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($widget->app_img_1)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_app_img_1', ($widget->app_img_1 ? $widget->app_img_1 : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('app_img_1', 'Upload Start Sell App Image 1') }}
                                <span class="error">* 
                                    @if ($errors->has('app_img_1'))
                                        {{ $errors->first('app_img_1') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="app_img_1" id="app_img_1" accept="image/*" class="gj_app_img_1">
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('app_link_1', 'Start Sell App Link 1') }}
                            <span class="error"> 
                                @if ($errors->has('app_link_1'))
                                    {{ $errors->first('app_link_1') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('app_link_1', ($widget->app_link_1 ? $widget->app_link_1 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('app_link_1', Input::old('app_link_1'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($widget))
                                @if($widget->app_img_2 != '')
                                <div class="form-group">
                                    {{ Form::label('current_app_img_2', 'Current Start Sell App Image 2') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($widget->app_img_2)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_app_img_2', ($widget->app_img_2 ? $widget->app_img_2 : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('app_img_2', 'Upload Start Sell App Image 2') }}
                                <span class="error">* 
                                    @if ($errors->has('app_img_2'))
                                        {{ $errors->first('app_img_2') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="app_img_2" id="app_img_2" accept="image/*" class="gj_app_img_2">
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('app_link_2', 'Start Sell App Link 2') }}
                            <span class="error"> 
                                @if ($errors->has('app_link_2'))
                                    {{ $errors->first('app_link_2') }}
                                @endif
                            </span>
                            @if(isset($widget))
                                {{ Form::text('app_link_2', ($widget->app_link_2 ? $widget->app_link_2 : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('app_link_2', Input::old('app_link_2'), array('class' => 'form-control')) }}
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
</script>
@endsection