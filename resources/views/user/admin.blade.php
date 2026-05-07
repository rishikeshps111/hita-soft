<?php
$logo = \DB::table('logo_settings')->latest()->first();
$logo_path = 'images/logo';
?>

@extends('layouts.master')
@section('title', 'Login')
<link rel="stylesheet" type="text/css" href="{{ asset('login/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('login/main.css')}}">
@section('content')

<style>
@media screen and (max-width:991px){
    .container-login100{
        width:100%;}
        .wrap-login100{
            padding: 30px;
        }
    }
@media screen and (max-width:567px){
    
        .wrap-login100{
            padding: 0px;
        }
    }
    
</style>

<section class="gj_login_bk bg-log">
    <div class="row gj_row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="gj_login_box">
                <div class="col-md-12">
                    <div class="limiter">
                        <div class="container-login100">
                            <div class="wrap-login100">
                                <!--<div class="login100-pic js-tilt" data-tilt>
                                    <img src="{{ asset('login/login.png')}}" alt="IMG">
                                </div>-->
                                
                         
		                 	  		<!--<img src="{{ asset('images/png.png')}}" alt="Logo" style="width:180px; margin:0 auto;display:block;padding-bottom:10px;">-->
                               	 

                                <form class="login100-form validate-form" method="post" action="{{ route('admin') }}">
                                     @if($logo)
                                        <img src="{{ asset($logo_path.'/'.$logo->logo_image)}}" alt="Logo" style="width:150px; margin:0 auto;display:block;padding-bottom:15px;">
                                        @else
                                        <img src="{{ asset('images/palackal-logo.png')}}" alt="Logo" style="width:150px; margin:0 auto;display:block;padding-bottom:15px;">
                                        @endif
                                    @if(Session::has('message'))
                                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                                    @endif
                                
                                    <span class="login100-form-title">
                                        Dashboard Login
                                    </span>

                                    <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                                        <input class="input100" type="text" name="email" placeholder="Email">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fa fa-envelope" aria-hidden="true"></i>
                                        </span>
                                        
                                    </div>
                                    <p class="error gj_l_err"> 
                                        @if ($errors->has('email'))
                                            {{ $errors->first('email') }}
                                        @endif
                                    </p>

                                    <div class="wrap-input100 validate-input" data-validate = "Password is required">
                                        <input class="input100 gj_password_field" type="password" name="password" placeholder="Password" id="passwordInput">
                                        <span class="focus-input100"></span>
                                        <span class="symbol-input100">
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                        </span>
                                        <span class="toggle-password" style="position:absolute; right:15px; top:16px; cursor:pointer;">
                                            <i class="fa fa-eye-slash" id="togglePassword"></i>
                                        </span>
                                    </div>
                                    <p class="error gj_l_err"> 
                                        @if ($errors->has('password'))
                                            {{ $errors->first('password') }}
                                        @endif
                                    </p>

                                    <div class="form-group" style="display:flex; align-items:center; justify-content:flex-start;">
                                        <label for="password" style="margin:0;">Remember me</label>
                                        
                                        <input type="checkbox" style="    width: 16px;height: 16px;margin-left: 5px;" name="remember" id="remember" <?php if(isset($_COOKIE["user"])) { echo "checked"; } ?> />
                                    </div>
                                    
                                    <div class="container-login100-form-btn">
                                        <button class="login100-form-btn" type="submit">
                                            Login
                                        </button>
                                    </div>

                                    <div class="text-center p-t-12">
                                        <span class="txt1">
                                            
                                        </span>
                                        <!--<a class="txt2" href="{{ route('forgot') }}">-->
                                        <!--   Forgot Password?-->
                                        <!--</a>-->
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
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('passwordInput');
        const icon = this;

        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            passwordField.type = "password";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    });
</script>

@endsection