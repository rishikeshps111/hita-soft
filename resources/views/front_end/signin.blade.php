@extends('layouts.frontend')
@section('title', 'SignIn')
@section('content')

<style>
    .sign-btn {
    width: 216px;
    }
     ul.nav-menu li.nav-item a.nav-link {
    color: #222 !important;
}
div.click-search,div.search-items-top,.top-right ul li a.cart_rang{
    box-shadow:none;
        border: 1px solid #827e7e8f;
}
div.click-search i,div.search-items-top i,div.search-items-top input,div.search-items-top input::placeholder,.top-right ul li a.cart_rang{
    color:#222 !important;
}
</style>
<div class="cover-head"></div>
<section class="section-padding login-main-section mt-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="login-left">
                    <!--<img src="{{asset('assets/img/baner/logo.png')}}">-->
                  
                    <h3>Your Fashion Journey Starts Here</h3>
                    <p>Log in to discover new arrivals, deals, and personalized picks.</p>
                </div>
                
            </div>
            <div class="col-lg-5">
                <div class="login-section">
                    
                    @if(Session::has('message') || Session::has('msg_prefix'))
                        <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                            @if(Session::has('message'))
                                {{ Session::get('message') }}
                            @else
                                {!! Session::get('msg_prefix') !!} 
                                {!! Session::get('msg_link') !!} 
                                {!! Session::get('msg_suffix') !!}
                            @endif
                        </div>
                    @endif
                    
                    <form action="{{route('email_signin_check')}}" id="customer_login_email" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div class="login-field">
                                    <label for="">Email<span class="text-danger">*</span></label>
                                    <input type="email" class="form-control shadow-none" placeholder="Enter Your Email" name="email" value="{{old('email')}}" required>
                                     <span class="error text-danger">
                                        @if ($errors->has('email'))
                                            {{ $errors->first('email') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div class="login-field">
                                    <label for="">Password <span class="text-danger">*</span></label>
                                    <div class="password-show-field">
                                         <input type="password" class="form-control shadow-none" name="password" id="passwordField" placeholder="Enter Your Password" required>
                                    <span  onclick="togglePasswordVisibility()">
                                        <i id="toggleIcon" class="fa fa-eye-slash"></i>
                                    </span>
                                    </div>
                                   
                                     <span class="error text-danger">
                                        @if ($errors->has('password'))
                                            {{ $errors->first('password') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                             <div class="col-lg-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                
                                <div class="login-field-a">
                                    <a href="{{route('customer_forgot')}}">Forgot your password?</a>
                                    <p >Don't have an account? <a href="{{route('signup')}}">Sign up</a></p>

                                </div>

                            </div>
                            <div class="col-lg-12 mb-3">                                
                                <button class="sign-btn" type="submit"> Sign In </button> 
                                <!-- <a href="my_account.html" class="sign-btn">Sign In</a> -->
                                <!--<h5 class="text-center m-2">OR</h5>-->
                                <!-- <div class="text-center mt-2">-->
                                <!--    <a href="{{route('signin.otp')}}" class="sign-btn">Sign In with Phone number</a>-->
                                <!--</div>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-- Reactivation Modal -->
<div class="modal fade" id="reactivationModal" tabindex="-1" role="dialog" aria-labelledby="reactivationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form method="POST" action="{{ route('reactivate.account') }}">
        @csrf
        <input type="hidden" name="user_id" value="{{ session('reactivate_user_id') }}">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Reactivate Account</h5>
            <button type="button" class="btn btn-danger close ms-auto" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ session('message') }}</p>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Yes, Reactivate</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Cancel</button>
          </div>
        </div>
    </form>
  </div>
</div>



</section>


@endsection

@section('before_scripts')
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=en" async defer> </script>
<!--<script src="https://www.google.com/recaptcha/enterprise.js?render=6Ld1o60nAAAAAIJAW_XUr7bZJm4uZflt33d7hO1P"></script>-->
@if(Session::has('show_reactivation_modal') && Session::get('show_reactivation_modal') === true)
<script>
    $(document).ready(function(){
        $('#reactivationModal').modal('show');
    });
</script>
@endif

<script type="text/javascript">
    var grecaptcha;
    var captcha;
    var m_grecaptcha;
    var onloadCallback = function() {
        // grecaptcha.render('mob_signin_capcha', {
        //   'sitekey' : '6LdWA6cUAAAAAEcJihfUvZ7js5pBLmbL4zq6ZPE4'
        // });

        grecaptcha.render('mail_signin_capcha', {
            'sitekey': '6Ld1o60nAAAAAIJAW_XUr7bZJm4uZflt33d7hO1P'
        });

        // const token = await grecaptcha.enterprise.execute('6Lf6UaYnAAAAAOfp_Ejd8f_mhYf3mCmD37BiLpN3', {action: 'LOGIN'});
    };
</script>

<script>
    $(document).ready(function() {
        $('p.alert').delay(7000).slideUp(700);
    });
</script>

<script>
    $(document).ready(function() {

    });
</script>
<script>
    function togglePasswordVisibility() {
        const passwordField = document.getElementById("passwordField");
        const toggleIcon = document.getElementById("toggleIcon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        }
    }
</script>


<script>
    $(document).ready(function() {
        /*$('.gj_logwith_email').hide();
        $('.gj_logwith_mobile').hide();
        $('.gj_af_otp').hide();
        $('.gj_bf_otp').show();

        
        if($("input[name='log_with']:checked").val() == 1) {
            $('.gj_logwith_mobile').slideUp();
            $('.gj_logwith_email').slideDown();
            $('.bk_log_with').val('email');
            $('.gj_login_type').val(1);
        } else {
            $('.gj_logwith_email').slideUp();
            $('.gj_logwith_mobile').slideDown();
            $('.bk_log_with').val('mobile');
            $('.gj_login_type').val(0);
        }*/
    });

    /*$('input[name="log_with"]').on('change',function() {
        var radioValue = $("input[name='log_with']:checked").val();
        if(radioValue == 1) {
            $('.gj_logwith_mobile').slideUp();
            $('.gj_logwith_email').slideDown();
            $('.bk_log_with').val('email');
            $('.gj_login_type').val(1);
        } else {
            $('.gj_logwith_email').slideUp();
            $('.gj_logwith_mobile').slideDown();
            $('.bk_log_with').val('mobile');
            $('.gj_login_type').val(0);
        }
    }); */
</script>

@endsection