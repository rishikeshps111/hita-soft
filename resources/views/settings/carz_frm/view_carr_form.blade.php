@extends('layouts.master')
@section('title', 'View Career Form')
@section('content')
<section class="gj_vw_careerz_setting">
    <div class="row gj_row">
        <div class="col-md-3 col-sm-3 col-xs-12">
            @include('layouts.sidebar')
        </div>

        <div class="col-md-9 col-sm-9 col-xs-12">
            <!-- <div class="row">
                <div class="col-lg-12">
                    <ul class="breadcrumb">
                        <li class=""><a> Home  </a></li>
                        <li class="active"><a> View Career Form  </a></li>
                    </ul>
                </div>
            </div> -->

            <div class="gj_box dark">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <header>
                    <div class="gj_icons"><i class="fa fa-edit"></i></div>
                    <h5 class="gj_heading"> View Career Form  </h5>
                </header>

                <div class="col-md-12">
                    <div class="gj_box dark gj_inside_box">
                        <header>
                            <h5 class="gj_heading"> Career Job Form Details  </h5>
                        </header>
                        
                        <div class="col-md-12">
                            @if($careerz)
                                <div class="table-responsive gj_vw_cf_res">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>First Name</th>
                                            <td>{{$careerz->first_name}}</td>
                                        </tr>

                                        <tr>
                                            <th>Last Name</th>
                                            <td>
                                                @if($careerz->last_name)
                                                    {{$careerz->last_name}}
                                                @else
                                                    {{'------'}}
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Email-ID</th>
                                            <td>
                                                @if($careerz->email)
                                                    {{$careerz->email}}
                                                @else
                                                    {{'------'}}
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Mobile Number</th>
                                            <td>
                                                @if($careerz->mobile)
                                                    {{$careerz->mobile}}
                                                @else
                                                    {{'------'}}
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Job</th>
                                            <td>
                                                @if(isset($careerz->Jobs->job_title) && $careerz->Jobs->job_title)
                                                    {{$careerz->Jobs->job_title}}
                                                @else
                                                    {{'------'}}
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Message</th>
                                            <td>
                                                @if($careerz->message)
                                                    <?php echo nl2br($careerz->message); ?>
                                                @else
                                                    {{'------'}}
                                                @endif
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th>Create Date</th>
                                            <td>{{date('d-m-Y', strtotime($careerz->created_at))}}</td>
                                        </tr>

                                        <tr>
                                            <th>Resume</th>
                                            <td>
                                                @if($careerz->resume)
                                                    <a href="{{ asset($careerz->resume)}}" target="_blank" title="{{$careerz->resume}}" class="gj_vw_user_doc" download><embed src="{{ asset($careerz->resume)}}"/></a>
                                                @else
                                                    {{'-------'}}
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
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
@endsection
