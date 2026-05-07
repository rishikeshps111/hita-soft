@extends('layouts.master')
@section('title', 'Add Career Jobs')
@section('content')
<section class="gj_carrjob_setting">
    <div class="row gj_row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            @include('layouts.sidebar')
        </div>

        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <li class=""><a> Home  </a></li>
                        <li class="active"><a> Add Career Jobs  </a></li>
                    </ul>
                </div>
            </div>

            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <header>
                    <div class="gj_icons"><i class="fa fa-edit"></i></div>
                    <h5 class="gj_heading"> Add Career Jobs  </h5>
                </header>

                <div class="col-md-12">
                    {{ Form::open(array('url' => 'add_carr_jobs','class'=>'gj_cj_form','files' => true)) }}
                        <div class="form-group">
                            {{ Form::label('title', 'Job Title') }}
                            <span class="error">* 
                                @if ($errors->has('job_title'))
                                    {{ $errors->first('job_title') }}
                                @endif
                            </span>

                            {{ Form::text('job_title', Input::old('job_title'), array('class' => 'form-control gj_job_title','placeholder' => 'Title in English')) }}
                        </div>

                        {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}

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

    $('.summernote').summernote({
        placeholder: 'Enter Content',
        tabsize: 2,
        height: 100
    });
</script>
@endsection
