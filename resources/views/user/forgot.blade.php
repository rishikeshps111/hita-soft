<?php
$logo = \DB::table('logo_settings')->latest()->first();
$logo_path = 'images/logo';
?>


@extends('layouts.master')
@section('title', 'Forgot Password')
<link rel="stylesheet" type="text/css" href="{{ asset('login/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('login/main.css')}}">
@section('content')
<section class="gj_login_bk">
    <div class="row gj_row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="gj_login_box">
                <div class="col-md-12">
                    <div class="limiter">
                        <div class="container-login100">
                            @if(Session::has('message'))
                                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger" id="errorAlert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="wrap-login100">
                                <!--<div class="login100-pic js-tilt" data-tilt>
                                    <img src="{{ asset('login/forgot.jpg')}}" alt="IMG">
                                </div>-->
                                
                                	<!--<img src="{{ asset('images/logo.png')}}" alt="Logo" style="width:180px; margin:0 auto;display:block;padding-bottom:10px;">-->
                                    
                                <form class="login100-form validate-form" method="post" action="{{ route('admin.check_forgot') }}">
                                    @csrf
                                    
                                     @if($logo)
                                        <img src="{{ asset($logo_path.'/'.$logo->logo_image)}}" alt="Logo" style="width:80px; margin:0 auto;display:block;padding-bottom:15px;">
                                        @else
                                        <img src="{{ asset('images/palackal-logo.png')}}" alt="Logo" style="width:80px; margin:0 auto;display:block;padding-bottom:15px;">
                                        @endif
                                    
                                    <span class="login100-form-title">
                                        Forgot Password
                                    </span>

                                    <div class="wrap-input100 validate-input">
                                        <input class="input100" type="text" name="email_id" placeholder="Email">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <p class="error gj_l_err"> 
                                        @if ($errors->has('email_id'))
                                            {{ $errors->first('email_id') }}
                                        @endif
                                    </p>

                                    <p class="gj_fp_or">or</p>

                                    <div class="wrap-input100 validate-input">
                                        <input class="input100" type="number" name="mobnumber" placeholder="Moblile Number">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fa fa-phone" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <p class="error gj_l_err"> 
                                        @if ($errors->has('mobnumber'))
                                            {{ $errors->first('mobnumber') }}
                                        @endif
                                    </p>
                                    
                                    <div class="container-login100-form-btn">
                                        <button class="login100-form-btn" type="submit">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<style>
    .gj_top_header{display:none;}
    
    .container-login100{padding:0px;}
    
    .wrap-login100{display:block;}
</style>


<script src="{{ asset('login/tilt.jquery.min.js')}}"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#errorAlert').fadeOut('slow');
        }, 3000); // 3000ms = 3 seconds
    });
</script>

<script >
    $('.js-tilt').tilt({
        scale: 1.1
    })
</script>
<!-- <script src="{{ asset('login/main.js')}}"></script> -->

<script>
    $(document).ready(function() { 
        $('p.alert').delay(2000).slideUp(300); 
    });
</script>
@endsection
