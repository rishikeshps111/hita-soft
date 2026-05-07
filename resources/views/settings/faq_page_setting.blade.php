@extends('layouts.master')
@section('title', 'FAQ Page Settings')
@section('content')
<section class="gj_faq_setting">
    <div class="row gj_row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            @include('layouts.sidebar')
        </div>

        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <ul class="breadcrumb">
                        <li class=""><a> Home  </a></li>
                        <li class="active"><a> FAQ Page Settings  </a></li>
                    </ul> -->
                    @if(Session::has('message'))
                        <p class="alert gj_bk_alt {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                </div>
            </div>

            <div class="gj_box dark">
                <header>
                    <div class="gj_icons"><i class="fa fa-edit"></i></div>
                    <h5 class="gj_heading"> FAQ Page Settings  </h5>
                </header>

                <div class="col-md-12">
                    {{ Form::open(array('url' => 'faq_page_setting','class'=>'gj_faq_form','files' => true)) }}
                        <div class="form-group">
                            {{ Form::label('title', 'Main Title') }}
                            <span class="error">* 
                                @if ($errors->has('title'))
                                    {{ $errors->first('title') }}
                                @endif
                            </span>
                            @if(isset($faq))
                                {{ Form::hidden('id', ($faq->id ? $faq->id : ''), array('class' => 'form-control')) }}

                                {{ Form::text('title', ($faq->title ? $faq->title : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::hidden('id', Input::old('id'), array('class' => 'form-control')) }}

                                {{ Form::text('title', Input::old('title'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <!-- <div class="form-group">
                            {{ Form::label('desc', 'Description') }}
                            <span class="error">* 
                                @if ($errors->has('desc'))
                                    {{ $errors->first('desc') }}
                                @endif
                            </span>

                            <textarea name="desc" cols="20" rows="4" class="summernote" required="">{{((isset($faq) && $faq->desc) ? $faq->desc : Input::old('desc'))}}</textarea>
                        </div> -->

                        <div class="gj_ban_img_whole">
                            @if(isset($faq))
                                @if($faq->banner_image != '')
                                <div class="form-group">
                                    {{ Form::label('current_banner_image', 'Current Banner Image') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($faq->banner_image)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_banner_image', ($faq->banner_image ? $faq->banner_image : ''), array('class' => 'form-control')) }}
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
                            @if(isset($faq))
                                {{ Form::text('banner_caption', ($faq->banner_caption ? $faq->banner_caption : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('banner_caption', Input::old('banner_caption'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <!-- <div class="form-group">
                            {{ Form::label('next_main_hd', 'Next Main Heading') }}
                            <span class="error">* 
                                @if ($errors->has('next_main_hd'))
                                    {{ $errors->first('next_main_hd') }}
                                @endif
                            </span>
                            @if(isset($faq))
                                {{ Form::text('next_main_hd', ($faq->next_main_hd ? $faq->next_main_hd : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('next_main_hd', Input::old('next_main_hd'), array('class' => 'form-control')) }}
                            @endif
                        </div> -->

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