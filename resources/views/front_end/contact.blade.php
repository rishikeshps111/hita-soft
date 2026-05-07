<?php

$footer_contact = DB::table('footer_contact')->get();
 use Illuminate\Support\Str;
?>

@extends('layouts.frontend')
@section('title', 'Contact Us')
<link rel="stylesheet" type="text/css" href="{{ asset('login/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('login/main.css')}}">
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
header{
    border-bottom:1px solid #ccc;
}
@media screen and (max-width:991px){
    .col-reverse{
        flex-direction:column-reverse;
    }
}

</style>
<div class="cover-head"></div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="gj_msg">
                @if($errors->any())
                    <p class="alert alert-danger auto-dismiss" id="errorMessage">
                        {{ $errors->first() }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
    <!--       <section class="">-->
    <!--    <div class="contact-container">-->

    <!--        <div class="contact-right">-->
    <!--            <img src="{{asset('assets/img/baner/10.jpg')}}" alt="">-->
    <!--        </div>-->
    <!--        <div class="contact-left">-->
    <!--            <h3>We’d Love to Hear from You</h3>-->
    <!--            <p><strong>Have a question, custom request, or need assistance? We’re here to help.</strong></p>-->
                <!--<img src="assets/img/ring.png" alt="">-->
    <!--            <p>Reach out to Rukmini Fashions for inquiries related to orders, made-to-order designs, collaborations, or general support. Our team is committed to providing you with a seamless and delightful experience.</p>-->

    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->
    <section class="section-padding ">
        <div class="container">
            <div class="row col-reverse">
                 <div class="col-lg-4 mb-3" >
                     <div class="contact-content">
                         <img src="{{asset('assets/img/baner/12.webp')}}" alt="">
                         
                <h3>We’d Love to Hear from You</h3>
                <p><strong>Have a question, custom request, or need assistance? We’re here to help.</strong></p>
                <!--<img src="assets/img/ring.png" alt="">-->
                <p class="mt-2">Reach out to Rukmini Fashions for inquiries related to orders, made-to-order designs, collaborations, or general support. Our team is committed to providing you with a seamless and delightful experience.</p>

           
                     </div>
                     
                 </div>
                <div class="col-lg-4 mb-3" style="display:none;">
                    <div class="contact-us-box mb-2">
                        
                        <ul class="contact-address">
                            @foreach($footer_contact as $footer)
                                @php
                                    $isEmail = Str::contains($footer->title, '@');
                                    $cleanNumber = preg_replace('/[^0-9]/', '', $footer->title);
                                @endphp
                        
                                <li class="align-items-center">
                                    @if($isEmail)
                                        {{-- Email --}}
                                        <a href="mailto:{{ $footer->title }}" target="_blank" class="contact-a">
                                            <div class="contact-ad-icon">
                                                <i class="fa-solid {{ $footer->icon }}"></i>
                                            </div>
                                            {{ $footer->title }}
                                        </a>
                        
                                    @elseif($footer->icon == 'fa-phone')
                                        {{-- Phone / WhatsApp --}}
                                        <a href="https://wa.me/{{ $cleanNumber }}" target="_blank" class="contact-a">
                                            <div class="contact-ad-icon">
                                                <i class="fa-solid {{ $footer->icon }}"></i>
                                            </div>
                                            {{ $footer->title }}
                                        </a>
                        
                                    @elseif($footer->icon == 'fa-location-dot')
                                        {{-- Location --}}
                                        <a href="https://www.google.com/maps?q={{ urlencode($footer->title) }}" target="_blank" class="contact-a">
                                            <div class="contact-ad-icon">
                                                <i class="fa-solid {{ $footer->icon }}"></i>
                                            </div>
                                            {{ $footer->title }}
                                        </a>
                        
                                    @elseif($footer->icon == 'fa-clock')
                                        {{-- Working Hours --}}
                                        <div class="contact-a">
                                            <div class="contact-ad-icon">
                                                <i class="fa-solid {{ $footer->icon }}"></i>
                                            </div>
                                            <p><strong>Working Hours</strong><br>{{ $footer->title }}</p>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                            
                        </ul>
                    </div>
                    <div class="contact-us-box mb-2">
                        <div class="cnt-map">
                           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3947.0303768947188!2d77.08585837477291!3d8.398672891639608!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b05afafb4f93243%3A0xfa30db791d0d304e!2sParis%20La%20Belle!5e0!3m2!1sen!2sin!4v1767868414179!5m2!1sen!2sin"  style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                   
                </div>
                <div class="col-lg-8 mb-3">
                    <div class="contact-form " >
                       
                        <p>Please complete the form below. We'll do everything we can to respond to you as quickly as possible.</p>
                         <form action="{{ route('store_contact') }}" method="POST" class=" cnt-frms" id="contact" enctype="multipart/form-data">
                                @csrf
                            <div class="row mt-4">
                                <div class="col-lg-12 mb-3">
                                    <div class="contact-form-box">
                                        <label for="review_type" class="form-label">Purpose of Message <span class="text-danger">*</span></label>
                                        <span class="error text-danger">
                                            @if ($errors->has('review_type'))
                                                {{ $errors->first('review_type') }}
                                            @endif
                                        </span>
                                        <select name="review_type" id="review_type" class="form-select shadow-none" disabled>
                                            <option value="">-- Select --</option>
                                            <option value="enquiry" {{ old('review_type') == 'enquiry' ? 'selected' : 'selected' }}>Enquiry</option>
                                            <option value="testimonial" {{ old('review_type') == 'testimonial' ? 'selected' : '' }}>Brand Review</option>
                                        </select>
                                        
                                        <input type="hidden" name="review_type" value="{{ old('review_type', 'enquiry') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="contact-form-box">
                                        <label for="contact_name" class="form-label">Full Name</label>
                                         <span class="error text-danger">*
                                            @if ($errors->has('contact_name'))
                                                {{ $errors->first('contact_name') }}
                                            @endif
                                        </span>
                                            <input type="text" class="form-control shadow-none" id="name" name="contact_name" value="{{ old('contact_name') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="contact-form-box">
                                        <label for="contact_email" class="form-label">Email</label>
                                         <span class="error text-danger">*
                                            @if ($errors->has('contact_email'))
                                                {{ $errors->first('contact_email') }}
                                            @endif
                                        </span>
                                            <input type="email" class="form-control shadow-none" id="email" name="contact_email" value="{{ old('contact_email') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="contact-form-box">
                                        <label for="contact_phone" class="form-label">Phone</label>
                                         <span class="error">
                                            @if ($errors->has('contact_phone'))
                                                {{ $errors->first('contact_phone') }}
                                            @endif
                                        </span>
                                            <input type="tel" pattern="\d{10}"  maxlength="10" minlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57"  oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control shadow-none" id="phone" name="contact_phone" value="{{ old('contact_phone') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="contact-form-box">
                                        <label for="Subject" class="form-label">Subject</label>
                                         <span class="error">
                                            @if ($errors->has('subject'))
                                                {{ $errors->first('subject') }}
                                            @endif
                                        </span>
                                            <input type="text" class="form-control shadow-none" id="Subject" name="subject" value="{{ old('subject') }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="contact-form-box">
                                        <label for="Message" class="form-label">Message </label>
                                         <span class="error text-danger"> *
                                            @if ($errors->has('message'))
                                                {{ $errors->first('message') }}
                                            @endif
                                        </span>
                                            <textarea name="message" id="Message" class="form-control shadow-none">{{ old('message') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="contact-form-box">
                                        <div id="mail_signin_capcha"></div>
                                        <span class="error text-danger">
                                            @if ($errors->has('g-recaptcha-response'))
                                                {{ $errors->first('g-recaptcha-response') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="contact-btn">Send Message</button>
                                </div>
                            </div>
                        </form>
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
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=en" async defer> </script>
<script type="text/javascript">
    var grecaptcha;
    var onloadCallback = function() {
        // grecaptcha.render('mob_signin_capcha', {
        //   'sitekey' : '6LdWA6cUAAAAAEcJihfUvZ7js5pBLmbL4zq6ZPE4'
        // });
// 6LfFPCcrAAAAAHOdU7fmX5hbUHjXTkOe4OZAFKZq
        grecaptcha.render('mail_signin_capcha', {
          'sitekey' : '6LeAjIIsAAAAANx6zG-9UTIT0G0DAGn83Dy2dGuP'
        });
    };
</script>

<script>
    $(document).ready(function(){
        /*$(".gj_cont_info").each(function(){
            var embed ="<iframe width='100%' height='315' frameborder='0' scrolling='no'  marginheight='0' marginwidth='0' src='https://maps.google.com/maps?&amp;q="+ encodeURIComponent( $(this).text() ) +"&amp;output=embed'></iframe>";
            $('.gj_map_div').html(embed);
        }); */
    });
</script>

@if(Session::has('message'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch("{{ route('send.contact.email') }}", {
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
