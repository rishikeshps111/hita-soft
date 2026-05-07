@extends('layouts.frontend')
@section('title', 'Register')
@section('content')
    <style>
        /* Define your custom CSS class for styling the larger popup */
        .larger-popup {
            width: 500px !important;
            /* Adjust the width as needed */
            height: auto !important;
            /* Prevent automatic height adjustment */
        }

        .country-code span {
            padding: 8px 0px !important;
            height: 58px;
            display: flex;
        }

        .country-code span select {
            width: 83px !important;
        }

        ul.nav-menu li.nav-item a.nav-link {
            color: #222 !important;
        }

        div.click-search,
        div.search-items-top,
        .top-right ul li a.cart_rang {
            box-shadow: none;
            border: 1px solid #827e7e8f;
        }

        div.click-search i,
        div.search-items-top i,
        div.search-items-top input,
        div.search-items-top input::placeholder,
        .top-right ul li a.cart_rang {
            color: #222 !important;
        }
    </style>
    <div class="cover-head"></div>

    <section class="section-padding login-main-section mt-3">
        <div class="container">
            <div class="row justify-content-center">
                {{-- <div class="col-lg-6">
                    <div class="login-left">
                        <!--<img src="{{asset('assets/img/baner/logo.png')}}">-->

                        <h3>Create Your Account</h3>
                        <p>Join Rukmini Fashions and discover the latest styles, offers, and exclusive collections.</p>
                    </div>

                </div> --}}
                <div class="col-lg-6">
                    <div class="login-section">
                        <h3>Sign Up</h3>
                        <p>to continue</p>
                        <form action="{{route('email_register')}}" method="POST" class="gj_user_email_register"
                            id="customer_login_email" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="login-field">
                                        <label for="">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control shadow-none" name="full_name"
                                            placeholder="Enter Your Full Name" value="{{ old('full_name') }}">
                                        <span class="error text-danger">
                                            @if ($errors->has('full_name'))
                                                {{ $errors->first('full_name') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="login-field">
                                        <label for="">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control shadow-none" name="email"
                                            placeholder="Enter Your Email" value="{{ old('email') }}">
                                        <span class="error text-danger">
                                            @if ($errors->has('email'))
                                                {{ $errors->first('email') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="login-field">
                                        <label for="">Phone No <span class="text-danger">*</span></label>
                                        <div class="country-code">
                                            <span>
                                                <select name="country_code" class="form-select shadow-none"
                                                    id="countryCodeSelect">
                                                    <!--<option value="">Select Country Code</option>-->
                                                </select>
                                            </span>
                                            <input type="mob" class="form-control shadow-none" name="phone" maxlength="10"
                                                placeholder="Enter Your Number" value="{{ old('phone') }}">

                                        </div>
                                        <span class="error text-danger">
                                            @if ($errors->has('phone'))
                                                {{ $errors->first('phone') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="login-field">
                                        <label for="">Password <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control shadow-none"
                                            placeholder="Enter Your Password" name="password">
                                        <span class="error text-danger">
                                            @if ($errors->has('password'))
                                                {{ $errors->first('password') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="login-field">
                                        <div id="mail_signin_capcha"></div>
                                        <span class="error text-danger">
                                            @if ($errors->has('g-recaptcha-response'))
                                                {{ $errors->first('g-recaptcha-response') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="subscribe_newsletter"
                                            id="subscribe_newsletter" value="1" checked>
                                        <label class="form-check-label" for="subscribe_newsletter">
                                            Subscribe to newsletter
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="login-field-a">
                                        <p>Already have account? <a href="{{route('signin')}}">Sign in</a></p>
                                    </div>

                                </div>
                                <div class="col-lg-12 mb-3">
                                    <input type="submit" class="sign-btn" value="Sign Up">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!--<script src="https://www.google.com/recaptcha/enterprise.js?render=6Lf6UaYnAAAAAOfp_Ejd8f_mhYf3mCmD37BiLpN3"></script>-->
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=en" async defer> </script>
    <script type="text/javascript">
        var grecaptcha;
        var onloadCallback = function () {
            // grecaptcha.render('mob_signin_capcha', {
            //   'sitekey' : '6LdWA6cUAAAAAEcJihfUvZ7js5pBLmbL4zq6ZPE4'
            // });
            // 6LfFPCcrAAAAAHOdU7fmX5hbUHjXTkOe4OZAFKZq
            grecaptcha.render('mail_signin_capcha', {
                'sitekey': '6LfGkY8sAAAAANRhxXMrw963LRsgoTW1pTHOUq37'
            });
        };
    </script>

    <script>
        $(document).ready(function () {
            $('p.alert').delay(7000).slideUp(700);
        });
    </script>

    <script>
        $(document).ready(function () {

        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('countryCodeSelect');

            fetch('https://restcountries.com/v3.1/all?fields=name,idd')
                .then(response => response.json())
                .then(data => {
                    console.log("Fetched country data:", data);

                    const codes = [];

                    data.forEach(country => {
                        if (country.idd && country.idd.root) {
                            let root = country.idd.root;
                            let suffixes = country.idd.suffixes || [''];
                            suffixes.forEach(suffix => {
                                const dialCode = root + suffix;
                                const name = country.name.common;
                                codes.push({ code: dialCode, name });
                            });
                        }
                    });

                    console.log("Parsed dial codes:", codes);

                    // Remove duplicates
                    const uniqueCodes = Array.from(
                        new Map(codes.map(item => [item.code, item])).values()
                    );

                    // Sort alphabetically by country name
                    uniqueCodes.sort((a, b) => a.name.localeCompare(b.name));

                    // Fill the dropdown
                    uniqueCodes.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.code;
                        // Display country name and code in this format: "Country Name (+Code)"
                        opt.textContent = `(${item.code}) ${item.name} `;

                        let selectedCode = "{{ old('country_code', @$user->country) }}" || "+91"; // Default to +91

                        if (selectedCode === item.code) {
                            opt.selected = true;
                        }

                        select.appendChild(opt);
                    });
                })
                .catch(err => {
                    console.error("Error loading country codes:", err);
                });
        });

    </script>


    <script>
        /*$(document).ready(function() {
            $('.gj_logwith_email').hide();
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
            }
        });

        $('input[name="log_with"]').on('change',function() {
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

    <script>
        function showLoader() {
            Swal.fire({
                title: 'Registration in Progress',
                html: 'Please wait while your registration is being completed...',
                showConfirmButton: false,
                allowOutsideClick: false,
                width: '400px', // Adjust the width as needed
                heightAuto: false, // Prevent automatic height adjustment
                customClass: {
                    popup: 'larger-popup' // Define a custom CSS class for styling
                },
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        function hideLoader() {
            Swal.close();
        }
    </script>





@endsection