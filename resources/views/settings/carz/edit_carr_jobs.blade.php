@extends('layouts.master')
@section('title', 'Edit Career Jobs')
@section('content')
<section class="gj_email_setting">
    <div class="row gj_row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            @include('layouts.sidebar')
        </div>

        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <li class=""><a> Home  </a></li>
                        <li class="active"><a> Edit Career Jobs  </a></li>
                    </ul>
                </div>
            </div>

            <div class="gj_box dark">
                <header>
                    <div class="gj_icons"><i class="fa fa-edit"></i></div>
                    <h5 class="gj_heading"> Edit Career Jobs  </h5>
                </header>

                <div class="col-md-12">
                    {{ Form::open(array('url' => 'edit_carr_jobs','class'=>'gj_carr_jobs_form','files' => true)) }}
                        @if($careerz)
                            {{ Form::hidden('cj_id', $careerz->id, array('class' => 'form-control gj_b_id')) }}
                        @endif

                        <div class="form-group">
                            {{ Form::label('job_title', 'Job Title') }}
                            <span class="error">* 
                                @if ($errors->has('job_title'))
                                    {{ $errors->first('job_title') }}
                                @endif
                            </span>

                            {{ Form::text('job_title', ($careerz->job_title ? $careerz->job_title : Input::old('job_title')), array('class' => 'form-control gj_job_title','placeholder' => 'Title in English')) }}
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
    });

    $('.summernote').summernote({
        placeholder: 'Enter Content',
        tabsize: 2,
        height: 100
    });
</script>
@endsection
