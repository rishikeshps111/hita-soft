@extends('layouts.master')
@section('title', 'Add CMS Career Page')
@section('content')
<section class="gj_carr_setting">
    <div class="row gj_row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            @include('layouts.sidebar')
        </div>

        <div class="col-md-9 col-sm-9 col-xs-12">
            <!-- <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <li class=""><a> Home  </a></li>
                        <li class="active"><a> Add CMS Career Page  </a></li>
                    </ul>
                </div>
            </div> -->

            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <header>
                    <div class="gj_icons"><i class="fa fa-edit"></i></div>
                    <h5 class="gj_heading"> Add CMS Career Page  </h5>
                </header>

                <div class="col-md-12">
                    {{ Form::open(array('url' => 'add_career','class'=>'gj_about_cms_form','files' => true)) }}
                        @if(isset($career))
                            @if($career)
                                {{ Form::hidden('cr_id', $career->id, array('class' => 'form-control gj_cr_id')) }}
                            @endif
                        @endif

                        <div class="form-group">
                            {{ Form::label('career_hd', 'Title') }}
                            <span class="error">* 
                                @if ($errors->has('career_hd'))
                                    {{ $errors->first('career_hd') }}
                                @endif
                            </span>
                            @if(isset($career))
                                {{ Form::text('career_hd', ($career->career_hd ? $career->career_hd : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('career_hd', Input::old('career_hd'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="form-group">
                            {{ Form::label('career_desc', 'Description') }}
                            <span class="error">* 
                                @if ($errors->has('career_desc'))
                                    {{ $errors->first('career_desc') }}
                                @endif
                            </span>

                            <textarea name="career_desc" cols="20" rows="4" class="summernote" >{{((isset($career) && $career->career_desc) ? $career->career_desc : Input::old('career_desc'))}}</textarea>
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($career))
                                @if($career->career_img != '')
                                <div class="form-group">
                                    {{ Form::label('current_career_img', 'Current Career Image') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($career->career_img)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_career_img', ($career->career_img ? $career->career_img : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('career_img', 'Upload Career Image') }}
                                <span class="error">* 
                                    @if ($errors->has('career_img'))
                                        {{ $errors->first('career_img') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="career_img" id="career_img" accept="image/*" class="gj_career_img">
                            </div>
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($career))
                                @if($career->banner_image != '')
                                <div class="form-group">
                                    {{ Form::label('current_banner_image', 'Current Banner Image') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($career->banner_image)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_banner_image', ($career->banner_image ? $career->banner_image : ''), array('class' => 'form-control')) }}
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
                            @if(isset($career))
                                {{ Form::text('banner_caption', ($career->banner_caption ? $career->banner_caption : ''), array('class' => 'form-control')) }}
                            @else
                                {{ Form::text('banner_caption', Input::old('banner_caption'), array('class' => 'form-control')) }}
                            @endif
                        </div>

                        <div class="gj_ban_img_whole">
                            @if(isset($career))
                                @if($career->career_bg != '')
                                <div class="form-group">
                                    {{ Form::label('current_career_bg', 'Current Career BG Image') }}
                                    <div class="gj_mc_div">
                                       <img src="{{ asset($career->career_bg)}}" class="img-responsive"> 
                                    </div>
                                    {{ Form::hidden('old_career_bg', ($career->career_bg ? $career->career_bg : ''), array('class' => 'form-control')) }}
                                </div>
                                @endif
                            @endif

                            <div class="form-group">
                                {{ Form::label('career_bg', 'Upload Career BG Image') }}
                                <span class="error">* 
                                    @if ($errors->has('career_bg'))
                                        {{ $errors->first('career_bg') }}
                                    @endif
                                </span>
                                <!-- <p class="gj_not" style="color:red"><em>image size must be 800 x 800 pixels</em></p> -->

                                <input type="file" name="career_bg" id="career_bg" accept="image/*" class="gj_career_bg">
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
