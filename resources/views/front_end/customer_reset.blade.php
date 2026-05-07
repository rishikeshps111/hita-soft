@extends('layouts.frontend')
@section('title', 'Reset Password')
@section('content')

  <section class="section-padding bg-section mt-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="login-section">
                        <h3>Reset Password</h3>
                        <form action="{{route('customer_reset_password')}}" method="POST" enctype="multipart/form-data" class="gj_user_customer_reset_password" id="forgotpsd">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="login-field">
                                        <label for="">Reset Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control shadow-none"  name="remember_token" placeholder="Enter Your Code">
                                         <span class="error">
                                            @if ($errors->has('remember_token'))
                                                {{ $errors->first('remember_token') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="login-field">
                                        <label for="">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control shadow-none"  name="password" placeholder="Enter Your Password">
                                         <span class="error">
                                            @if ($errors->has('password'))
                                                {{ $errors->first('password') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <button type="submit" class="sign-btn">Send Now</button>
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