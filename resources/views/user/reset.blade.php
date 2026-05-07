<?php
$logo = \DB::table('logo_settings')->latest()->first();
$logo_path = 'images/logo';
?>

@extends('layouts.master')
@section('title', 'Reset Password')
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
                            <div class="wrap-login100">
                                <form class="login100-form validate-form" method="post" action="{{ route('reset_password') }}" enctype="multipart/form-data">
                                    @csrf
                                    
                                     @if($logo)
                                        <img src="{{ asset($logo_path.'/'.$logo->logo_image)}}" alt="Logo" style="width:80px; margin:0 auto;display:block;padding-bottom:15px;">
                                        @else
                                        <img src="{{ asset('images/palackal-logo.png')}}" alt="Logo" style="width:80px; margin:0 auto;display:block;padding-bottom:15px;">
                                        @endif
                                        
                                    <span class="login100-form-title">
                                        Reset Password
                                    </span>

                                    <div class="wrap-input100 validate-input" data-validate = "Enter Your Reset Password Code">
                                        <input class="input100" type="text" name="remember_token" placeholder="OTP Code / Reset Code">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fa fa-address-book" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <p class="error gj_l_err"> 
                                        @if ($errors->has('remember_token'))
                                            {{ $errors->first('remember_token') }}
                                        @endif
                                    </p>

                                    <div class="wrap-input100 validate-input" data-validate = "Password is required">
                                        <input class="input100" type="password" name="password" placeholder="New Password">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <p class="error gj_l_err"> 
                                        @if ($errors->has('password'))
                                            {{ $errors->first('password') }}
                                        @endif
                                    </p>

                                    <div class="wrap-input100 validate-input" data-validate = "Confirm Password is required">
                                        <input class="input100" type="password" name="password_salt" placeholder="Confirm Password">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <p class="error gj_l_err"> 
                                        @if ($errors->has('password_salt'))
                                            {{ $errors->first('password_salt') }}
                                        @endif
                                    </p>

                                    <div class="wrap-input100 validate-input" data-validate = "Confirm Password is required">
                                        <!--<p class="gj_taw_pwd">If Didn't receive any reset code <a href="{{ route('chk_repwd_question') }}" class="link-color">Try Another Way?</a></p>-->
                                    </div>
                                    
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

<script src="{{ asset('login/tilt.jquery.min.js')}}"></script>
<script >
    $('.js-tilt').tilt({
        scale: 1.1
    })
</script>
<script src="{{ asset('login/main.js')}}"></script>

<script>
    $(document).ready(function() { 
        $('p.alert').delay(2000).slideUp(300); 
    });
</script>
@endsection