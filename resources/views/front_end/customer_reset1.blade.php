@extends('layouts.frontend1')
@section('title', 'Reset Password')
@section('content')
<div class="gj_cus_reg_sec">
    <!-- Reset Banner Section Start -->
    <section class="gj_cus_signup_ban_sec">
        <div class="inban inban9" style="background-image:url('{{asset('images/site_img/inban9.jpg')}}')">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                         <h4> Reset Password </h4> 
                    </div>
                </div>
            </div>    
        </div>  
    </section>
    <!-- Reset Banner Section End -->
    
    <!-- Reset Form Section Start -->
    <section class="sptb gj_cus_forgot_frm_sec">
        <div class="container customerpage">        
            <div class="row">
                <div class="col-lg-5 col-xl-4 col-md-6 d-block mx-auto">
                    <div class="single-page">
                        <div class="wrapper wrapper2">
                            {{ Form::open(array('url' => 'customer_reset_password','class'=>'card-body gj_user_customer_reset_password', 'id' => 'forgotpsd', 'files' => true)) }}
                                <h3 class="pb-2">Forgot password</h3> 
                                <div class="mail">
                                    <input type="text" name="remember_token" placeholder="Reset Code *">
                                    
                                    <span class="error">
                                        @if ($errors->has('remember_token'))
                                            {{ $errors->first('remember_token') }}
                                        @endif
                                    </span> 
                                </div> 

                                <div class="passwd">
                                    <input type="password" name="password"  placeholder="Password *"> 

                                    <span class="error">
                                        @if ($errors->has('password'))
                                            {{ $errors->first('password') }}
                                        @endif
                                    </span>                                    
                                </div>

                                <div class="submit"> <button type="submit" class="btn btn-primary btn-block">Send Now </button> 
                                </div>
                                <!-- <div class="text-center text-dark mb-0"> Back to <a href="{{route('signin')}}"> Login </a> </div> -->
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Forgot Form Section End -->
</div>
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