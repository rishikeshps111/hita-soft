@extends('layouts.frontend')
@section('title', 'Made To Order')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <div class="gj_msg" id="error-message">
                        @foreach ($errors->all() as $error)
                             <p class="alert {{ Session::get('alert-class', 'alert-danger') }} auto-dismiss">
                                {{ $error }}
                            </p>
                        @endforeach
                </div>
            
                <script>
                    setTimeout(function() {
                        let errorBox = document.getElementById('error-message');
                        if (errorBox) {
                            errorBox.style.display = 'none';
                        }
                    }, 4000);
                </script>
            @endif
        </div>
    </div>
</div>


   <section class="pt-3">
        <div class="made-to-order-container">
            <div class="made-to-order-left">
                <h3>MADE TO ORDER</h3>
                <p><strong>Crafted Just for You</strong></p>
                <!--<img src="{{asset('assets/img/ring-2.png')}}" alt="">-->
                <p>
At Paris Labelle, our made-to-order service ensures every piece is tailored with care, precision, and exclusivity. Each design is crafted only after your order is placed, allowing us to focus on quality, detailing, and a perfect fit—made especially for you.
</p>
<p>Experience fashion that is not mass-produced, but thoughtfully created to reflect your unique style.</p>
            </div>
            <div class="made-to-order-right">
                <img src="{{asset('assets/img/baner/6.jpeg')}}" alt="">
            </div>
        </div>
    </section>
    <section class="section-padding bg-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="order-container">
                        <p>Do you wish to customise a piece? Drop your information below and we will personally get in
                            touch with you soon!</p>
                        <form action="{{route('customise_store')}}" method="POST" class="gj_ch_trans" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <div class="order-form-field">
                                        <label for="Name">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control shadow-none" id="Name" name="name" value="{{ old('name') }}"
                                            placeholder="Enter Your Name" required>
                                        @error('name')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="order-form-field">
                                        <label for="Email">E mail <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control shadow-none" id="Email" name="email" value="{{ old('email') }}"
                                            placeholder="Enter Your Email" required>
                                            @error('email')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="order-form-field">
                                        <label for="Number">Phone <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control shadow-none" id="Number" name="phone_number" value="{{ old('phone_number') }}"
                                            placeholder="Enter Your Number" required>
                                            @error('phone_number')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="order-form-field">
                                        <label for="fileupload">Upload Image</label>
                                        <input type="file" class="form-control shadow-none" id="fileupload" name="uploaded_image">
                                        <!--@if(session('temp_uploaded_image'))-->
                                        <!--    <div class="mt-2">-->
                                        <!--        <img src="{{ asset(session('temp_uploaded_image')) }}" alt="Uploaded Image" style="max-height: 200px;">-->
                                        <!--    </div>-->
                                        <!--@endif-->
                                    </div>
                                </div>
                                <!-- <div class="col-lg-6 mb-3">
                                    <div class="order-form-field">
                                        <label for="cname">Company Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control shadow-none" id="cname"
                                           required>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="order-form-field">
                                        <label for="cweb">Company Website <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control shadow-none" id="cweb"
                                           required>
                                    </div>
                                </div> -->
                                <div class="col-lg-12 mb-3">
                                    <div class="order-form-field">
                                        <label for="Message">Message <span class="text-danger">*</span></label>
                                        <textarea class="form-control shadow-none" id="message" name="message"
                                            placeholder="Type Your Message">{{ old('message') }}</textarea>
                                         @error('message')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror   
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="order-form-field">
                                        <div id="mail_signin_capcha"></div>
                                        <span class="error text-danger">
                                            @if ($errors->has('g-recaptcha-response'))
                                                {{ $errors->first('g-recaptcha-response') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <button type="submit" class="order-btn">Send Message</button>
                                </div>
                               <div class="col-lg-12">
                                    <p class="note-p"><span>Note: </span>{{ $general->made_to_order_note ? $general->made_to_order_note : '' }}</p>
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
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=en" async defer> </script>
<script type="text/javascript">
    var grecaptcha;
    var onloadCallback = function() {
        // grecaptcha.render('mob_signin_capcha', {
        //   'sitekey' : '6LdWA6cUAAAAAEcJihfUvZ7js5pBLmbL4zq6ZPE4'
        // });
// 6LfFPCcrAAAAAHOdU7fmX5hbUHjXTkOe4OZAFKZq
        grecaptcha.render('mail_signin_capcha', {
          'sitekey' : '6Ldwt1grAAAAAG4uCHADmoAY6iJUF_WtVGR1VzEE'
        });
    };
</script>

@if(Session::has('message'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch("{{ route('send.made_order.email') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                console.log('Email status:', data.status);
            });
        });
    </script>
@endif

@endsection


