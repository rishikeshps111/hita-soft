@extends('layouts.frontend')
@section('title', 'Forgot Password')
@section('content')
<style>
   
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
  <section class="section-padding bg-section mt-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="login-section">
                        <h3>Reset Your Password</h3>
                        <p class="reset_password-ds">We will send you a code to reset your password.</p>
                        <form action="{{route('check_customer_forgot')}}" method="POST" id="forgotpsd" class="gj_user_check_customer_forgot">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="login-field">
                                        <label for="">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control shadow-none"  name="email_mob" placeholder="Enter Your Email">
                                         <span class="error">
                                            @if ($errors->has('email_mob'))
                                                {{ $errors->first('email_mob') }}
                                            @endif
                                        </span> 
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="login-field-a">
                                       
                                        <p>Back to <a href="{{route('signin')}}">Sign in</a></p>
                                        
                                    </div>

                                </div>
                               
                                <div class="col-lg-12 mb-3">
                                    <button type="submit" class="sign-btn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('before_scripts')
<script>
    $(document).ready(function() { 
        $('p.alert').delay(7000).slideUp(700); 
    });
</script>

<script>
    $(document).ready(function() { 
        
    });
</script>
@endsection