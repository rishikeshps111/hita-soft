@extends('layouts.frontend')
@section('title', 'SignIn')
@section('content')

<section class="section-padding bg-section mt-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="login-section">
                    <h3>Sign In with Phone number</h3>
                    <p>to continue</p>
                            <div class="back-to-order">
                                <a href="{{route('signin')}}"><i class="fa-solid fa-arrow-left"></i></a>
                            </div>
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
                    
                    <form action="{{route('mobile_signin_check')}}" id="customer_login_email" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div class="login-field">
                                    <label for="">Phone number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control shadow-none" placeholder="Phone number" name="phone" value="{{old('phone')}}" required>
                                     <span class="error text-danger">
                                        @if ($errors->has('phone'))
                                            {{ $errors->first('phone') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div class="login-field" id="otp_section" style="display: none;">
                                  <div class="mb-3">
                                    <label>Enter OTP</label>
                                    <input type="text" name="otp" class="form-control shadow-none" placeholder="Enter OTP" required>
                                  </div>
                                </div>
                                 <div id="otp_message" class="text-success mb-2" style="display: none;"></div>
                                 
                                 <button type="button" id="send_otp_btn" class="btn btn-secondary">Send OTP</button>
                            </div>
                             
                            
                            <div class="col-lg-12 mb-3">                                
                                <button class="sign-btn" type="submit"> Sign In </button> 
                                <!-- <a href="my_account.html" class="sign-btn">Sign In</a> -->
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


<script>
document.getElementById('send_otp_btn').addEventListener('click', function () {
    const phone = document.querySelector('input[name="phone"]').value;
    if (!phone) {
        alert("Please enter phone number.");
        return;
    }

    fetch("{{ route('send_login_otp') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ phone })
    })
    .then(res => res.json())
    .then(data => {
         if (data.success) {
            // Show OTP section
            const otpSection = document.getElementById('otp_section');
            const otpSubmitBtn = document.getElementById('otp_submit_btn');
            const otpMessage = document.getElementById('otp_message');

            if (otpSection) otpSection.style.display = 'block';
            if (otpSubmitBtn) otpSubmitBtn.style.display = 'inline-block';
            if (otpMessage) {
                otpMessage.innerText = "OTP sent successfully!";
                otpMessage.style.display = 'block';
                otpMessage.style.color = 'green';
            }
        } else {
            alert(data.message || "OTP send failed");
        }
    });
});
</script>


@endsection