<?php  
    $general = \DB::table('general_settings')->first();
    $product_path = 'images/featured_products';
    $noimage = \DB::table('noimage_settings')->first();
    $noimage_path = 'images/noimage';
?>
@extends('layouts.frontend')
@section('title', 'View CheckOut')
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('login/animate.css')}}"> -->
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('login/main.css')}}"> -->
@section('content')

<style>
    .custom-popup-class {
   width: fit-content;
    /*max-width: 400px*/
    height: auto;
    border-radius: 50px !important;
    padding: 15px;
}
.country-code span select {
    width: 81px !important;
}
.swal2-actions .swal2-confirm{
          width: 150px;
    height: 45px;
    background-color: #dc3545;
    color: #fff;
    border-radius: 5px;
    display: flex
;
    justify-content: center;
    align-items: center;
    font-size: 16px;
    font-weight: 400;
    border: 1px solid #dc3545;
    transition: 0.5s;
    text-decoration: none;
        border-radius: 40px;
}
ul {
    list-style-type: none;
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
 <section class="section-padding bg-light-gray">
        @if(Session::has('message'))
            <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                {{ Session::get('message') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                   
                    <div class="section-title column-title pb-0" >
                        <h3>Checkout Information</h3>
                        <div class="col-lg-12">
                             <a href="{{ route('cart') }}" class="view_all_btn btn btn-primary mb-3"><i class="fas fa-arrow-left"></i>&ensp; Back to Cart</a>
                        </div>
                       
                    </div>
                </div>
            </div>
            <form action="{{route('checkout_verif')}}" class="gj_ch_trans ps-form--checkout" id="gj_ch_trans" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="row">
           
                <div class="col-lg-8 mb-3">
                    <div class="checkout-container">
                        @php
                            $defaultAddress = $addresses->where('is_default', 1)->first();
                        @endphp
                        <h3>Shipping Address</h3>
                        <div class="checkout-radio">
                            <ul class="checkout-now">
                                 @foreach ($addresses as $address)
                                    <li>
                                        <input type="radio" id="ad{{ $address->id }}" name="address_id" value="{{ $address->id }}" data-pincode="{{ $address->pincode }}"
                                            {{ $defaultAddress && $defaultAddress->id == $address->id ? 'checked' : '' }}>
                                        <label for="ad{{ $address->id }}">{{ $address->address_type }}</label>
                                    </li>
                                @endforeach
                                <li>
                                    <input type="radio" id="ad3" name="address_id" value="new">
                                    <label for="ad3" style="width: 127px !important; background-color:#1987548f;">+ Add New Address</label>
                                </li>
                            </ul>
                        </div>
                       
                            <div class="row" id="address-details">
                                <div class="col-lg-12 mb-3">
                                     <input id="user_id" type="hidden" placeholder="user_id" name="user_id" class="form-control input-md" value="{{$users->id}}">
                                    <div class="shiping-form-field">
                                        @php
                                            $name = '';
                                            if (isset($ships) && $ships->full_name) {
                                                $name = $ships->full_name;
                                            } else {
                                                $first = trim($lusr->first_name ?? '');
                                                $last = trim($lusr->last_name ?? '');
                                                $combined = trim($first . ' ' . $last);
                                                $name = $combined ?: ($lusr->full_name ?? '');
                                            }
                                        @endphp
                                        <label for="">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control shadow-none" name="full_name" placeholder="Enter Your Name"  value="{{$name}}">
                                         <span class="error">
                                              @if ($errors->has('full_name'))
                                                  {{ $errors->first('full_name') }}
                                              @endif
                                          </span> 
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="shiping-form-field">
                                        <label for="">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control shadow-none" placeholder="Enter Your Email" value="{{(isset($ships) && ($ships->email) ? $ships->email : $users->email)}}" name="email" >
                                        <span class="error">
                                              @if ($errors->has('email'))
                                                  {{ $errors->first('email') }}
                                              @endif
                                          </span> 
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="shiping-form-field">
                                        <label for="">Phone No <span class="text-danger">*</span></label>
                                        <div class="country-code">
                                            <span>
                                                <select name="country_code" class="form-select shadow-none" id="countryCodeSelect">
                                                    <!--<option value="">Select Country Code</option>-->
                                                </select>
                                            </span>
                                            <input type="number" class="form-control shadow-none"
                                            placeholder="Enter Your Phone" value="{{(isset($ships) && ($ships->contact_no) ? $ships->contact_no : $users->phone)}}" name="contact_no" >
                                          </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="shiping-form-field">
                                        <label for="">Address <span class="text-danger">*</span></label>
                                        <textarea class="form-control shadow-none" placeholder="(House No, Building, Street, Area)" name="address" id="address">{{ $defaultAddress ? $defaultAddress->address2 : '' }}</textarea>
                                        <span class="error">
                                          @if ($errors->has('address'))
                                              {{ $errors->first('address') }}
                                          @endif
                                        </span> 
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="shiping-form-field">
                                        <label for="">Pincode <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control shadow-none" placeholder="Enter Your Pincode" name="pincode" id="pincode"  value="{{ $defaultAddress ? $defaultAddress->pincode : '' }}" pattern="^\d{6}$" 
           oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                                        <span class="error">
                                          @if ($errors->has('pincode'))
                                              {{ $errors->first('pincode') }}
                                          @endif
                                        </span> 
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="shiping-form-field">
                                        <label for="">Locality / Town <span class="text-danger">*</span></label>
                                        <textarea class="form-control shadow-none" placeholder="" name="landmark" id="landmark">{{ $defaultAddress ? $defaultAddress->locality : '' }}</textarea>
                                       
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-1">
                                    <div class="shiping-form-field check-field">
                                        <input type="checkbox" class="form-check shadow-none" id="defaultAddress" name="default_address" 
                                        {{ isset($defaultAddress) && $defaultAddress->is_default ? 'checked' : '' }}>
                                        <label for="defaultAddress"> Do you make this address as default address?</label>
                                    </div>

                                </div>
                                <div class="col-lg-12 mb-1">
                                    <div class="shiping-form-field check-field">
                                        <input type="checkbox" class="form-check shadow-none" id="saveaddress" name="save_address">
                                        <label for="saveaddress"> Do you want to save this address to profile?</label>
                                    </div>

                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="shiping-form-field">
                                        <label for="">Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control shadow-none" placeholder="Enter Your Title" name="title" id="title" value="{{ $defaultAddress ? $defaultAddress->title : '' }}">
                                    </div>
                                </div>
                            </div>
                       

                    </div>
                   

                </div>
                <div class="col-lg-4">
                    <div class="cart-overview mb-3">
                        <div class="cart-overview-top">
                            <h3>Products</h3>
                            <h3>Total</h3>
                        </div>
                         @foreach ($items as $key => $value)
                        <div class="cart-over-view-product">
                            <div class="cart-over-view-product-item">
                                 @if(($value->image))
                                    <img src="{{ asset($product_path.'/'.$value->image) }}">
                                    @else
                                     <img src="{{ asset($noimage_path.'/'.$noimage->product_no_image)}}">
                                    @endif
                                <h3>{{$value->name}} @if($value->color_name)
                                                    ({{$value->color_name}} )
                                                     @endif <br/> <small> Quantity : {{$value->qty}}</small></h3>
                            </div>
                            <div class="cart-over-view-product-price gj_all_cart_pce"  id="prod_{{$value->product_id}}">
                                 @if($value->discounted_price > 0)
                                   <p>₹ {{ round(($value->qty * $value->discounted_price),2) }}</p>
                                @else
                                <p>₹ {{ round(($value->qty * $value->product_cost),2) }}</p>
                                @endif
                            </div>

                        </div>
                        <input type="hidden" name="shiping_charge[]" id="shc_{{$value->product_id}}" class="gj_sc_shiping_charge" value="{{$shipping->domestic_shipping ?? $shipping->inter_shipping}}"  data-domestic="{{ $shipping->domestic_shipping ?? 0 }}"
    data-international="{{ $shipping->inter_shipping ?? 0 }}"  data-original="{{ $shipping->domestic_shipping ?? $shipping->inter_shipping }}">
                        <div class="cart-item">
                            <input type="hidden" name="tax_amount[]" class="gj_sc_tax_charge" value="{{ $value->tax_amount }}">
                             <input class="gj_cart_qty" value="{{ $value->qty }}" type="hidden" />
                         </div>
                        @endforeach
                        <table>
                           
                            <tr>
                                <td>Subtotal</td>
                                <td class="gj_all_sub_cart_total">₹ 0.00</td>
                            </tr>
                            <!--<tr>-->
                            <!--    <td>Tax</td>-->
                            <!--    <td class="gj_all_cart_tax_tot">₹ 0.00</td>-->
                            <!--</tr>-->
                            <tr>
                                <td>Shipping</td>
                                <td class="gj_all_cart_ship_tot">₹ 0.00</td>
                            </tr>
                             @if(session()->has('coupon'))
                            <tr>
                                <td>Coupon ({{ session('coupon.code') }})</td>
                                <td class="gj_all_cart_coupon">- ₹ {{ session('coupon.discount') }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td>Total <br/><small>Including <span class="gj_all_cart_tax_tot">₹ 0.00</span> in taxes </small></td>
                                <td class="gj_all_cart_total">₹ 0.00</td>
                            </tr>
                            <input type="hidden" name="cart_sub_tot" class="gj_cart_sub_tot">
                      <input type="hidden" name="cart_ship_tot" class="gj_cart_ship_tot">
                      <input type="hidden" name="cart_tax_tot" class="gj_cart_tax_tot">
                      <input type="hidden" name="cart_dis_tot" class="gj_cart_dis_tot" value="{{(isset($offer_discounts) && $offer_discounts) ? $offer_discounts : '0'}}">
                      <input type="hidden" name="cart_totalval" class="gj_cart_totalval">
                     <input type="hidden" name="cart_coupon_discount" class="gj_cart_coupon_discount" value="{{ session('coupon.discount') ?? 0 }}">


                        </table>
                         @if($shipping->text)
                         <div class="input-group mb-3 mt-2">
                            <div class="form-control shadow-none" readonly style="height:auto; min-height:45px;">
                                {!! nl2br(e($shipping->text ?? '')) !!}
                            </div>
                        </div>
                        @endif
                       {{-- <div id="coupon-box" class="mt-2">
                            @if(session()->has('coupon'))
                                <div class="alert alert-success d-flex justify-content-between align-items-center">
                                    <span>
                                        Coupon <strong>{{ session('coupon.code') }}</strong> applied.
                                        Discount: ₹<span id="coupon-discount">{{ session('coupon.discount') }}</span>
                                    </span>
                                    <button type="button" class="btn btn-sm btn-danger remove-coupon">Remove</button>
                                </div>
                            @else
                                <div class="input-group mb-3 mt-2">
                                    <input type="text" id="coupon_code" class="form-control shadow-none" placeholder="Enter Coupon Code" style="height:45px;">
                                    <button id="apply-coupon-btn" type="button" class="btn" style="background-color: #ca3554; color: #fff;">Apply</button>
                                </div>
                                <div id="coupon-message" class="text-danger mt-1"></div>
                            @endif
                        </div> --}}

                        
                        <div class="payment-method-widget">
                            <h3>Select Payment Method</h3>
                            <div class="checkout-radio">
                                <ul class="">
                                     <?php 
                                        $file_path = 'images/icons';
                                        ?>
                                    @foreach($enabled_methods as $method)
                                        <li class="mb-2 ">
                                            <input type="radio" id="payment_{{ $method->id }}" name="payment_method" value="{{ $method->id }}" data-name="{{ $method->name }}">
                                            <div class="payment-method-info">
                                                <label for="payment_{{ $method->id }}" class="d-flex align-items-center" >
                                                  <div class="payment-method-info-img">
                                                      <img src="{{ asset($file_path.'/'.$method->icon_image)}}" alt=" {{ $method->name }}" style="
    width: 67px; height: 67px; object-fit: contain;">
                                                  </div>
                                                {{ $method->name }}
                                              </label>
                                              
                                                <p>{{ $method->note ?? '' }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- <p>Taxes and <a href="shipping_policy.html" target="_blank">shipping</a> calculated at checkout</p> -->
                        <button type="submit" class="cart-btn mt-3 ps-btn--fullwidth">Proceed to Complete</button>
                    </div>

                    <div class="contact-us-box mb-2">
                        
                        <ul class="contact-address">
                            <li class="d-flex align-items-start">
                                <div class="contact-ad-icon">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div class="contact-details">
                                    <span id="contact-address">{{ $defaultAddress ? $defaultAddress->address2 : '' }}</span><br/>
                                    <span id="contact-locality">{{ $defaultAddress ? $defaultAddress->locality : '' }}</span> - 
                                    <span id="contact-pincode">{{ $defaultAddress ? $defaultAddress->pincode : '' }}</span>
                                </div>
                            </li>
                        
                            <li class="d-flex align-items-start">
                                <div class="contact-ad-icon">
                                    <i class="fa-regular fa-envelope-open"></i>
                                </div>
                                <div class="contact-details">
                                    <span id="contact-email">{{ isset($ships) && $ships->email ? $ships->email : $users->email }}</span>
                                </div>
                            </li>
                            @php
                                $phone = isset($ships) && $ships->contact_no ? $ships->contact_no : $users->phone;
                                $phone = preg_replace('/[^0-9]/', '', $phone); // keep digits only
                            @endphp
                            <li class="d-flex align-items-start">
                                <a href="https://wa.me/{{ $phone }}" target="_blank" class="d-flex contact-a">
                                    <div class="contact-ad-icon">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>
                                    <div class="contact-details">
                                        <span id="contact-phone">{{ $phone }}</span>
                                    </div>
                                </a>
                            </li>
                        </ul>

                    </div>

                </div>
                 
            </div>
            </form>
        </div>

    </section>


@endsection

@section('before_scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('countryCodeSelect');

    let selectedCode = {!! json_encode(old('country_code', @$user->country) ?: '+91') !!};
    selectedCode = selectedCode.toString(); // Convert to string
    console.log("Selected Code:", selectedCode);

    fetch('https://restcountries.com/v3.1/all?fields=name,idd')
        .then(response => response.json())
        .then(data => {
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

            const uniqueCodes = Array.from(new Map(codes.map(item => [item.code, item])).values());
            uniqueCodes.sort((a, b) => a.name.localeCompare(b.name));

            uniqueCodes.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.code;
                opt.textContent = `(${item.code}) ${item.name}`;

                if (item.code === ('+' + selectedCode.replace('+', ''))) {
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
$(document).ready(function () {
    function updateContactPreview() {
        $('#contact-address').text($('#address').val());
        $('#contact-locality').text($('#landmark').val());
        $('#contact-pincode').text($('#pincode').val());
        $('#contact-email').text($('input[name="email"]').val());
        $('#contact-phone').text($('input[name="contact_no"]').val());
    }

    // Update on input changes
    $('#address, #landmark, #pincode, input[name="email"], input[name="contact_no"]').on('input', function () {
        if ($('#ad3').is(':checked')) {
            updateContactPreview();
        }
    });

    // When "New" address is selected, clear fields and reset preview
    $('#ad3').on('change', function () {
        if (this.checked) {
            $('#address, #pincode, #landmark, #title').val('');
            $('#defaultAddress, #saveaddress').prop('checked', false);
            updateContactPreview();
        }
    });
});
</script>

<script>
    $(document).ready(function () {
    $('input[name="address_id"]').on('change', function () {
        let addressId = $(this).val();

        $.ajax({
            url: "{{ route('getAddress') }}",
            type: "GET",
            data: { address_id: addressId },
            success: function (response) {
                if (response.status === "success") {
                    $('#address').val(response.data.address2);
                    $('#pincode').val(response.data.pincode);
                    $('#landmark').val(response.data.locality);
                    $('#title').val(response.data.title);
                     
                    if (response.data.is_default == 1) {
                        $('#defaultAddress').prop('checked', true);
                    } else {
                        $('#defaultAddress').prop('checked', false);
                    }
                    
                    $('#contact-address').text(response.data.address2);
                    $('#contact-locality').text(response.data.locality);
                    $('#contact-pincode').text(response.data.pincode);
                    $('#contact-email').text(response.data.email);
                    $('#contact-phone').text(response.data.contact_no);
                    
                }
            }
        });
    });
    
        $('#gj_ch_trans').on('submit', function (e) {
        e.preventDefault(); // Prevent form submission to handle via AJAX
    
        var addressId = $('input[name="address_id"]:checked').val(); // Get the selected address ID
        
        if ($('#defaultAddress').prop('checked')) {
            $.ajax({
                url: "{{ route('address.make_default', ':id') }}".replace(':id', addressId), // Pass the addressId dynamically
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    address_id: addressId, // Include the address_id in the data
                },
                success: function (response) {
                    if (response.status === 'success') {
                        // Address marked as default successfully
                        alert(response.message); // Optional: Show success message
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error); // Log any error that occurs
                }
            });
        }
    });

    
});

</script>
  <script>
  
//   $(document).ready(function() {
//     // Add event listener to the "Proceed to Complete" button
//     $('.ps-btn--fullwidth').click(function(event) {
//         event.preventDefault(); // Prevent the default form submission

//         // Show a loader using SweetAlert
//         Swal.fire({
//             title: 'Loading',
//             text: 'Please wait...',
//             imageUrl: '{{ asset('images/Spinner.gif') }}', // Add path to your loader image
//             imageWidth: 80,
//             imageHeight: 80,
//             showCancelButton: false,
//             showConfirmButton: false,
//             allowOutsideClick: false,
//             allowEscapeKey: false,
//         });

//         // Simulate a delay to simulate the completion of the process
//         setTimeout(function() {
//             // Close the loader
//             Swal.close();

//             // Show a popup with text and OK button using SweetAlert
//           Swal.fire({
//                 title: 'ORDER PLACED SUCCESSFULLY',
//                 text: 'Reach us on Whatsapp at +91-9633052041.\nPlease share your Order No & Phone No to this WhatsApp No for our quick response.\nWhatsapp No: +91-9633052041.\nCheck your email as well. Thanks!',
//                 icon: 'success',
//                 confirmButtonText: 'OK',
//                 customClass: {
//                     popup: 'custom-popup-class'
//                 }
//             }).then((result) => {
//               if (result.isConfirmed) {
//                     window.location.href = '{{ route('home') }}';
//                 }
//             });

//         }, 2000); // Adjust the delay time as needed
//     });
// });

$(document).ready(function() {
    $('.ps-btn--fullwidth').click(function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Check if any required field is empty
        var emptyFields = $('.ps-form__billing-info input[required]').filter(function() {
            return $(this).val() === '';
        });

        if (emptyFields.length > 0) {
            Swal.fire({
                title: 'Empty Fields',
                text: 'Please fill in all required fields.',
                icon: 'warning',
                confirmButtonText: 'OK',
                customClass: { popup: 'custom-popup-class' }
            });
            return;
        }

        // Show a loader
        Swal.fire({
            title: 'Loading',
            text: 'Please wait...',
            imageUrl: '{{ asset('images/Spinner.gif') }}',
            imageWidth: 80,
            imageHeight: 80,
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
        });

        // Send an AJAX request
        $.ajax({
            type: 'POST',
            url: '{{ url('checkout_verif') }}',
            data: $('#gj_ch_trans').serialize(),
            success: function(response) {
                 Swal.close(); // Close the loader

                if (response.success) {
                    // ✅ Show success message immediately
                    if (response.payment_url) {
                        window.location.href = response.payment_url;
                        return;  // stop execution
                    }
                    Swal.fire({
                        title: 'Success!',
                        text: 'Order placed successfully!',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    });

                    // ✅ Redirect after a short delay
                    setTimeout(() => {
                        window.location.href = '{{ route('home') }}';
                    }, 2000);

                    // ✅ Send confirmation email in background (non-blocking)
                    if (!response.payment_url) {
                        fetch("{{ route('send.checkout.email') }}", {
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({})
                        })
                        .then(res => res.json())
                        .then(data => console.log('Email status:', data.status))
                        .catch(err => console.error('Email send error:', err));
                    } else {
                        // Redirect to payment page if payment_url exists
                        window.location.href = response.payment_url;
                    } 
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message || 'An error occurred. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr) {
                Swal.close();

                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessages = Object.values(errors).map(msg => msg.join('<br>')).join('<br>');
                    Swal.fire({
                        title: 'Errors',
                        html: errorMessages,
                        icon: 'warning',
                        confirmButtonText: 'OK',
                        customClass: { popup: 'custom-popup-class' }
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'An error occurred. Please try again later.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: { popup: 'custom-popup-class' }
                    });
                }
            }
        });
    });
});



</script>

<script type="text/javascript">
  $("#state").select2();
  $("#city").select2();

  $('#state').on('change',function() {
    var st = $(this).val();
    if(st) {
      $.ajax({
          type: 'post',
          url: '{{url('/select_city')}}',
          data: {st: st, type: 'city'},
          success: function(data){
              if(data){
                  $("#city").html(data);
                  $("#city").removeAttr("disabled");
              } else {
                  $.confirm({
                      title: '',
                      content: 'Please Select State!',
                      icon: 'fa fa-ban',
                      theme: 'modern',
                      closeIcon: true,
                      animation: 'scale',
                      type: 'blue',
                      buttons: {
                          Ok: function(){
                          }
                      }
                  });
                  $("#city").val('');
                  $("#city").prop("disabled", true);
              }
          }
      });
    } else {
      $.confirm({
          title: '',
          content: 'Please Select State!',
          icon: 'fa fa-ban',
          theme: 'modern',
          closeIcon: true,
          animation: 'scale',
          type: 'blue',
          buttons: {
              Ok: function(){
              }
          }
      });
    }
  });

  if($('#state').val()) {
      var city = '';
      @if(isset($ships) && $ships->city)
        city = <?php echo $ships->city; ?>;
      @elseif($users->city)
        city = <?php echo $users->city; ?>;
      @endif

      var st = $('#state').val();
      $.ajax({
          type: 'post',
          url: '{{url('/select_city')}}',
          data: {st: st, city: city, type: 'city'},
          success: function(data){
              if(data){
                  $("#city").html(data);
                  $("#city").removeAttr("disabled");
              } else {
                  $.confirm({
                      title: '',
                      content: 'Please Select State!',
                      icon: 'fa fa-ban',
                      theme: 'modern',
                      closeIcon: true,
                      animation: 'scale',
                      type: 'blue',
                      buttons: {
                          Ok: function(){
                          }
                      }
                  });
                  $("#city").val('');
                  $("#city").prop("disabled", true);
              }
          }
      });
    }
</script>



<script type="text/javascript">
//   function cal_sum() {
//         var sum = 0, ship = 0, dis = 0, tax = 0, coupon = 0;

//         // Subtotal
//         $(".gj_all_cart_pce").each(function() {
//             var value = $(this).text().replace(/[^0-9.]/g, "");
//             if (!isNaN(value) && value.length !== 0) {
//                 sum += parseFloat(value);
//             }
//         });

//         // Shipping
//         $(".gj_sc_shiping_charge").each(function() {
//             var sh_value = $(this).val().replace(/[^0-9.]/g, "");
//             if (!isNaN(sh_value) && sh_value.length !== 0) {
//                 ship += parseFloat(sh_value);
//             }
//         });

//         // Tax
//         $(".gj_sc_tax_charge").each(function() {
//             var tax_value = $(this).val().replace(/[^0-9.]/g, "");
//             if (!isNaN(tax_value) && tax_value.length !== 0) {
//                 tax += parseFloat(tax_value);
//             }
//         });

//         // Static discount (like offers or seasonal)
//         dis = parseFloat($('.gj_cart_dis_tot').val()) || 0;

//         // Coupon discount (from session)
//         coupon = parseFloat($('.gj_cart_coupon_discount').val()) || 0;

//         // Final total
//         var ctot = (sum + tax + ship - dis - coupon).toFixed(2);
//         sum = sum.toFixed(2);
//         ship = ship.toFixed(2);
//         tax = tax.toFixed(2);

//         // Update HTML and hidden inputs
//         $('.gj_all_sub_cart_total').text("₹ " + sum);
//         $('.gj_cart_sub_tot').val(sum);
        
//         if (ship == 0) {
//             $('.gj_all_cart_ship_tot').text('FREE');
//         } else {
//             $('.gj_all_cart_ship_tot').text('₹ ' + ship);
//         }

//         // $('.gj_all_cart_ship_tot').text("₹ " + ship);
//         $('.gj_cart_ship_tot').val(ship);

//         $('.gj_all_cart_tax_tot').text("₹ " + tax);
//         $('.gj_cart_tax_tot').val(tax);

//         $('.gj_all_cart_total').text("₹ " + ctot);
//         $('.gj_cart_totalval').val(ctot);
//     }

//     $(document).ready(function() {
//         setTimeout(cal_sum, 500);
//     });

//     $(window).on("load", function() {
//         cal_sum();
//     });
 </script>

 <script>
// function updateShippingCharges() {
//     let countryCode = $('#countryCodeSelect').val();
//     let pincode = $('#pincode').val();

//     // Loop through each product
//     $('.gj_sc_shiping_charge').each(function () {
//         let input = $(this);
//         let productId = input.attr('id').replace('shc_', '');
        
//         let domestic = input.data('domestic');
//         let international = input.data('international');

//         if (countryCode === '+91') {
//             input.val(domestic); 
//         } else {
//             input.val(international); 
//         }
//     });

//     cal_sum(); 
// }

// $(document).ready(function() {
//     updateShippingCharges();

//     $('#countryCodeSelect, #pincode').on('change keyup', function () {
//         updateShippingCharges();
//     });
// });
 </script>



<!-- <script>
    function gj_round(value, decPlaces) {
      var val = value * Math.pow(10, decPlaces);
      var fraction = (Math.round((val - parseInt(val)) * 10) / 10);

      // -342.055 => -342.06
      if (fraction == -0.5) fraction = -0.6;

      val = Math.round(parseInt(val) + fraction) / Math.pow(10, decPlaces);
      return val;
    }

    function cut_off(sum, shc, sc, tax_tot, cnt_shc) {
        var is_cod = $("input[name='payment_method']:checked").val();
        if(is_cod && is_cod == 1){
            is_cod = 1;
        } else {
            is_cod = 2;
        }

        $.ajax({
          type: 'post',
          url: '{{url('/check_cut_off')}}',
          data: {sum: sum, tax_tot: tax_tot, cnt_shc: cnt_shc, shc: shc, sc: sc, is_cod: is_cod, type: 'check_cut_off'},    
          dataType:"json",   
          success: function(data){
            if(data['error'] == 1){
              $('#cut_off').val(data['shc']);

              $('.gj_ch_sub_tot').html(data['sum']);
              $('#sub_total').val(data['sum']);

              $('.gj_ch_tax_tot').html(data['tax_tot']);
              $('#tax_total').val(data['tax_tot']);

              // $('.gj_ch_sc_tot').html(data['sc']);
              $('#serv_total').val(data['sc']);

              $('.gj_ch_shc_tot').html(data['shc']);
              $('#ship_total').val(data['shc']);

              $('.gj_ch_cod').html(data['cod_amount']);
              $('#cod_charge').val(data['cod_amount']);


              $('.gj_ch_grand_tot').html(data['tot']);
              $('#net_amount').val(data['tot']);          
            }
          }
        });
    }

    function sum() {
        var sum = 0;
        var tax_tot = 0;
        var gj = 0;
        var sc = 0;
        var shc = 0; 
        var cnt_shc = 0; 
        
        $(".gj_ch_p").each(function() {
          var value = $(this).text();
          if(!isNaN(value) && value.length != 0) {
            sum += parseFloat(value);
          }
        });

        $(".gj_ch_tax_amt").each(function() {
          var values = $(this).val();
          if(!isNaN(values) && values.length != 0) {
            tax_tot += parseFloat(values);
          }
        });

        $(".gj_ch_sc").each(function() {
          var value = $(this).val();
          if(!isNaN(value) && value.length != 0) {
            sc += parseFloat(value);
          }
        });

        // $(".gj_ch_shc").each(function() {
        //   var value = $(this).val();
        //   if(!isNaN(value) && value.length != 0) {
        //     shc += parseFloat(value);
        //   }
        // });
        
        if($(".product-item").find(".gj_ch_shc").length) {
            cnt_shc = $(".product-item").find(".gj_ch_shc").length;
        }

        var shc = Math.max.apply(Math, $('.gj_ch_shc').map(function(i,elem){ 
            return Number($(elem).val()); 
        }));

        $(".gj_ch_qty").each(function() {
          var value = $(this).val();
          if(!isNaN(value) && value.length != 0) {
            gj += parseFloat(value);
          }
        });

        cut_off(sum, shc, sc, tax_tot, cnt_shc);

        $('#total_items').val(gj);
    }

  $('#shipping').on('change', function() {
    if($(this).is(':checked')) { 
      $('#gj_shipping').slideDown(); 
      $(this).val(1); 
    } else {
      $(this).val(0); 
      $('#gj_shipping').slideUp(); 
    }
  });

    $(document).ready(function() {
        $('p.alert').delay(5000).slideUp(500);
        $('#gj_shipping').hide(); 

        var radioValue = $("input[name='payment_method']:checked").val();
        if(radioValue && radioValue == 1){
            $('.gj_cod_set').show();
        } else {
            $('.gj_cod_set').hide();
        }

        $('input[name="payment_method"]').on('change', function() {
            if($(this).is(':checked')) { 
                if($(this).val() && $(this).val() == 1){
                    $('.gj_cod_set').show();
                } else {
                    $('.gj_cod_set').hide();
                }
            }
            sum();
        });

        if($('#shipping').is(':checked')) { 
          $('#shipping').val(1); 
        } else {
          $('#shipping').val(0); 
        }

        sum();
    });

    $('.gj_ch_qty').on('change', function() {
        var id = $(this).closest('tr').find('.gj_p_id').val();
        var cart_id = $(this).closest('tr').find('.gj_ch_id').val();
        var qty = 1;
        var price = 0;
        var tax_amount = 0;
        var att_name = 0;
        var att_value = 0;
        var tax = 0;
        var tax_type = 0;
        var total = 0.00;
        var is_offer = "No";
        var offer_det_id = 0;
        var hm = $(this);

        if($(this).val() == 0) {
          var qty = 1;
          $(this).val(qty);
          $(this).closest('tr').find('.gj_ch_hqty').val(qty);
        } else {
            var qty = $(this).val();
        }

        if($(this).closest('tr').find('.gj_is_offer').val()) {
          var is_offer = $(this).closest('tr').find('.gj_is_offer').val();
        }

        if($(this).closest('tr').find('.gj_offer_det_id').val()) {
          var offer_det_id = $(this).closest('tr').find('.gj_offer_det_id').val();
        }

        if($(this).closest('tr').find('.gj_ch_att_name').val()) {
            var att_name = $(this).closest('tr').find('.gj_ch_att_name').val();
        }

        if($(this).closest('tr').find('.gj_ch_att_value').val()) {
            var att_value = $(this).closest('tr').find('.gj_ch_att_value').val();
        }

        if($(this).closest('tr').find('.gj_ch_dp').val()) {
            var price = parseFloat($(this).closest('tr').find('.gj_ch_dp').val());
        }

        if($(this).closest('tr').find('.gj_ch_tax_amt').val()) {
            var tax_amount = parseFloat($(this).closest('tr').find('.gj_ch_tax_amt').val());
        }

        if($(this).closest('tr').find('.gj_ch_tax').val()) {
          tax = $(this).closest('tr').find('.gj_ch_tax').val();
        }

        if($(this).closest('tr').find('.gj_ch_tax_type').val()) {
          tax_type = $(this).closest('tr').find('.gj_ch_tax_type').val();
        }

        /*if(tax_type == 2) {
          var calc_tax = ((price * tax)/100);
          price = price + calc_tax;
        }*/

        // var calc_tax = ((price * tax)/100);
        // price = price + calc_tax;

        if(is_offer == 'Yes') {
            qty = 1;
            $(this).attr('disabled', true);
        }

        if(id) {
          $.ajax({
            type: 'post',
            url: '{{url('/check_onhand_qty')}}',
            data: {id: id, is_offer: is_offer, offer_det_id: offer_det_id, qty: qty, price: price, att_name: att_name, att_value: att_value, type: 'check_onhand_qty'}, 
            dataType:"json",   
            success: function(data){
              if(data['error'] == 2){
                $.confirm({
                    title: '',
                    content: 'Out of Stock. Only ' + data['onhand_qty'] + ' Products Avaliable!',
                    icon: 'fa fa-exclamation',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'purple',
                    buttons: {
                        Ok: function(){
                            window.location.reload();
                        }
                    }
                });
                $(hm).val(1);
                data = price * $(hm).val();
                data = gj_round(data ,2);
                $(hm).closest('tr').find('.gj_ch_hqty').val(1);
                $(hm).closest('tr').find('.gj_ch_p').html(data);
                $(hm).closest('tr').find('.gj_ch_total').val(data);
                sum();
              } else if(data['error'] == 3){
                $.confirm({
                    title: '',
                    content: 'Out of Stock. Products Not Avaliable!',
                    icon: 'fa fa-exclamation',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'purple',
                    buttons: {
                        Ok: function(){
                            window.location.reload();
                        }
                    }
                });
                $(hm).val(1);
                data = price * $(hm).val();
                data = gj_round(data ,2);
                $(hm).closest('tr').find('.gj_ch_hqty').val(1);
                $(hm).closest('tr').find('.gj_ch_p').html(data);
                $(hm).closest('tr').find('.gj_ch_total').val(data);
                sum();
              } else if (data != 1) {
                $(hm).val(qty);
                data = gj_round(data ,2);
                $(hm).closest('tr').find('.gj_ch_hqty').val(qty);
                $(hm).closest('tr').find('.gj_ch_p').html(data);
                $(hm).closest('tr').find('.gj_ch_total').val(data);
                sum();
              } else {
                $(hm).val('1');
                data = price * $(hm).val();
                data = gj_round(data ,2);
                $(hm).closest('tr').find('.gj_ch_hqty').val(1);
                $(hm).closest('tr').find('.gj_ch_p').html(data);
                $(hm).closest('tr').find('.gj_ch_total').val(data);
                sum();
              }

              var qtys = $(hm).val();
              var totals = $(hm).closest('tr').find('.gj_ch_total').val();
              var tax_amount = $(hm).closest('tr').find('.gj_ch_tax_amt').val();
              $.ajax({
                type: 'post',
                url: '{{url('/update_qty')}}',
                data: {cart_id: cart_id, qtys: qtys, totals: totals, type: 'update_qty'}, 
                dataType:"json",   
                success: function(data) {

                }
              });
            }
          });        
        }
    });
</script> -->

<!-- <script type="text/javascript">
  $('#is_same').on('change', function() {
    if($(this).is(':checked')) {
      if($('#user_id').val()) {
        var user_id = $('#user_id').val();

        $.ajax({
          type: 'post',
          url: '{{url('/data_billing')}}',
          data: {id: user_id, type: 'data_billing'}, 
          dataType:"json",   
          success: function(data) {
            if(data['error'] == 1) {
              $('#s_firstname').val(data['user']['first_name']);
              $('#s_last_name').val(data['user']['last_name']);
              $('#contact_no').val(data['user']['phone']);
              $('#s_landmark').val(data['user']['landmark']);
              $('#address').val(data['user']['address1'] + ',' + data['user']['address2']);
              $('#s_pincode').val(data['user']['pincode']);
              $('#s_country').val(data['user']['country']);
              $('#s_state').val(data['user']['state']);
              $('#s_city').val(data['user']['city']);
            } else {
              $.confirm({
                  title: '',
                  content: 'Please You Have Enter Manually!',
                  icon: 'fa fa-ban',
                  theme: 'modern',
                  closeIcon: true,
                  animation: 'scale',
                  type: 'red',
                  buttons: {
                      Ok: function(){
                      }
                  }
              });
            }
          }
        });
      } else {
        $.confirm({
            title: '',
            content: 'Please Enter Manually!',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                Ok: function(){
                }
            }
        });
      }
    } else {
      if($('#user_id').val()) {
        var user_id = $('#user_id').val();

        $.ajax({
          type: 'post',
          url: '{{url('/data_billing')}}',
          data: {id: user_id, type: 'data_shipping'}, 
          dataType:"json",   
          success: function(data) {
            if(data['error'] == 1) {
              $('#s_firstname').val(data['user']['first_name']);
              $('#s_last_name').val(data['user']['last_name']);
              $('#contact_no').val(data['user']['contact_no']);
              $('#s_landmark').val(data['user']['landmark']);
              $('#address').val(data['user']['address']);
              $('#s_pincode').val(data['user']['pincode']);
              $('#s_country').val(data['user']['country']);
              $('#s_state').val(data['user']['state']);
              $('#s_city').val(data['user']['city']);
            } else {
              $.confirm({
                  title: '',
                  content: 'Please You Have Enter Manually!',
                  icon: 'fa fa-ban',
                  theme: 'modern',
                  closeIcon: true,
                  animation: 'scale',
                  type: 'red',
                  buttons: {
                      Ok: function(){
                      }
                  }
              });
            }
          }
        });
      } else {
        $.confirm({
            title: '',
            content: 'Please Enter Manually!',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                Ok: function(){
                }
            }
        });
      }
    }
  });
</script> -->

@if (isset($items) && count($items) != 0)
 <!--  <script type="text/javascript">
    $(document).ready(function() {
      var country = $('#country').val();
      var state = $('#old_state').val();

      var s_country = $('#s_country').val();
      var s_state = $('#s_old_state').val();
      if(country != 0) {
        $.ajax({
          type: 'post',
          url: '{{url('/select_state')}}',
          data: {country: country, state: state, type: 'state'},
          success: function(data){
            if(data){
              $("#state").html(data);
              $("#state").removeAttr("disabled");

              var st = $('#state').val();
              var city = $('#old_city').val();
              if(st) {
                  $.ajax({
                      type: 'post',
                      url: '{{url('/select_city')}}',
                      data: {st: st, city: city, type: 'city'},
                      success: function(data){
                          if(data){
                              $("#city").html(data);
                              $("#city").removeAttr("disabled");
                          } else {
                              $.confirm({
                                  title: '',
                                  content: 'Please Select State!',
                                  icon: 'fa fa-ban',
                                  theme: 'modern',
                                  closeIcon: true,
                                  animation: 'scale',
                                  type: 'blue',
                                  buttons: {
                                      Ok: function(){
                                      }
                                  }
                              });
                              $("#city").prop("disabled", true);
                          }
                      }
                  });
              } else {
                $.confirm({
                    title: '',
                    content: 'Please Select State!',
                    icon: 'fa fa-ban',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'blue',
                    buttons: {
                        Ok: function(){
                        }
                    }
                });
              }
            } else {
              $.confirm({
                  title: '',
                  content: 'Please Select Country!',
                  icon: 'fa fa-ban',
                  theme: 'modern',
                  closeIcon: true,
                  animation: 'scale',
                  type: 'blue',
                  buttons: {
                      Ok: function(){
                      }
                  }
              });
              $("#state").prop("disabled", true);
              $("#city").prop("disabled", true);
            }
          }
        });
      } else {
        $.confirm({
            title: '',
            content: 'Please Select Country!',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                Ok: function(){
                }
            }
        });
      }

      if(s_country != 0) {
        $.ajax({
          type: 'post',
          url: '{{url('/select_state')}}',
          data: {country: s_country, state: s_state, type: 'state'},
          success: function(data){
            if(data){
              $("#s_state").html(data);
              $("#s_state").removeAttr("disabled");

              var s_st = $('#s_state').val();
              var s_city = $('#s_old_city').val();
              if(s_st) {
                  $.ajax({
                      type: 'post',
                      url: '{{url('/select_city')}}',
                      data: {st: s_st, city: s_city, type: 'city'},
                      success: function(data){
                          if(data){
                              $("#s_city").html(data);
                              $("#s_city").removeAttr("disabled");
                          } else {
                              $.confirm({
                                  title: '',
                                  content: 'Please Select State!',
                                  icon: 'fa fa-ban',
                                  theme: 'modern',
                                  closeIcon: true,
                                  animation: 'scale',
                                  type: 'blue',
                                  buttons: {
                                      Ok: function(){
                                      }
                                  }
                              });
                              $("#s_city").prop("disabled", true);
                          }
                      }
                  });
              } else {
                $.confirm({
                    title: '',
                    content: 'Please Select State!',
                    icon: 'fa fa-ban',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'blue',
                    buttons: {
                        Ok: function(){
                        }
                    }
                });
              }
            } else {
              $.confirm({
                  title: '',
                  content: 'Please Select Country!',
                  icon: 'fa fa-ban',
                  theme: 'modern',
                  closeIcon: true,
                  animation: 'scale',
                  type: 'blue',
                  buttons: {
                      Ok: function(){
                      }
                  }
              });
              $("#state").prop("disabled", true);
              $("#city").prop("disabled", true);
            }
          }
        });
      } else {
        if($('#shipping').is(':checked')) { 
          $.confirm({
              title: '',
              content: 'Please Select Country!',
              icon: 'fa fa-ban',
              theme: 'modern',
              closeIcon: true,
              animation: 'scale',
              type: 'blue',
              buttons: {
                  Ok: function(){
                  }
              }
          });
        }
      }
    });

    $('#country').on('change',function() {
      var country = $(this).val();
      if(country) {
          $.ajax({
              type: 'post',
              url: '{{url('/select_state')}}',
              data: {country: country, type: 'state'},
              success: function(data){
                  if(data){
                      $("#state").html(data);
                      $("#state").removeAttr("disabled");
                  } else {
                      $.confirm({
                          title: '',
                          content: 'Please Select Country!',
                          icon: 'fa fa-ban',
                          theme: 'modern',
                          closeIcon: true,
                          animation: 'scale',
                          type: 'blue',
                          buttons: {
                              Ok: function(){
                              }
                          }
                      });
                      $("#state").val(0);
                      $("#city").val(0);
                      $("#state").prop("disabled", true);
                      $("#city").prop("disabled", true);
                  }
              }
          });
      } else {
        $.confirm({
            title: '',
            content: 'Please Select Country!',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                Ok: function(){
                }
            }
        });
      }
    });

    $('#state').on('change',function() {
      var st = $(this).val();
      if(st) {
        $.ajax({
            type: 'post',
            url: '{{url('/select_city')}}',
            data: {st: st, type: 'city'},
            success: function(data){
                if(data){
                    $("#city").html(data);
                    $("#city").removeAttr("disabled");
                } else {
                    $.confirm({
                        title: '',
                        content: 'Please Select State!',
                        icon: 'fa fa-ban',
                        theme: 'modern',
                        closeIcon: true,
                        animation: 'scale',
                        type: 'blue',
                        buttons: {
                            Ok: function(){
                            }
                        }
                    });
                    $("#city").val(0);
                    $("#city").prop("disabled", true);
                }
            }
        });
      } else {
        $.confirm({
            title: '',
            content: 'Please Select State!',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                Ok: function(){
                }
            }
        });
      }
    });

    $('#s_country').on('change',function() {
      var country = $(this).val();
      if(country) {
          $.ajax({
              type: 'post',
              url: '{{url('/select_state')}}',
              data: {country: country, type: 'state'},
              success: function(data){
                  if(data){
                      $("#s_state").html(data);
                      $("#s_state").removeAttr("disabled");
                  } else {
                      $.confirm({
                          title: '',
                          content: 'Please Select Country!',
                          icon: 'fa fa-ban',
                          theme: 'modern',
                          closeIcon: true,
                          animation: 'scale',
                          type: 'blue',
                          buttons: {
                              Ok: function(){
                              }
                          }
                      });
                      $("#s_state").val(0);
                      $("#s_city").val(0);
                      $("#s_state").prop("disabled", true);
                      $("#s_city").prop("disabled", true);
                  }
              }
          });
      } else {
        $.confirm({
            title: '',
            content: 'Please Select Country!',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                Ok: function(){
                }
            }
        });
      }
    });

    $('#s_state').on('change',function() {
      var st = $(this).val();
      if(st) {
        $.ajax({
            type: 'post',
            url: '{{url('/select_city')}}',
            data: {st: st, type: 'city'},
            success: function(data){
                if(data){
                    $("#s_city").html(data);
                    $("#s_city").removeAttr("disabled");
                } else {
                    $.confirm({
                        title: '',
                        content: 'Please Select State!',
                        icon: 'fa fa-ban',
                        theme: 'modern',
                        closeIcon: true,
                        animation: 'scale',
                        type: 'blue',
                        buttons: {
                            Ok: function(){
                            }
                        }
                    });
                    $("#s_city").val(0);
                    $("#s_city").prop("disabled", true);
                }
            }
        });
      } else {
        $.confirm({
            title: '',
            content: 'Please Select State!',
            icon: 'fa fa-ban',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'blue',
            buttons: {
                Ok: function(){
                }
            }
        });
      }
    });
  </script> -->


<script>
  const freeShippingLimit = {{ $free_shipping_limit ?? 0 }};
    let originalShipping = 0;

    function calculateTotal() {
        let subtotal = 0;
        let tax = 0;
        let shipping = 0;
        let discount = 0;
        let coupon = 0;
        let pincode = $('#pincode').val();
        let isDomestic = /^\d{6}$/.test(pincode);

        // Calculate subtotal from product prices
        $('.gj_all_cart_pce').each(function () {
            subtotal += parseFloat($(this).text().replace(/[^\d.]/g, '')) || 0;
        });

        // Calculate shipping total
        // $('.gj_sc_shiping_charge').each(function () {
        //     shipping += parseFloat($(this).val()) || 0;
        // });
        
        let firstShippingInput = $('.gj_sc_shiping_charge').first();
        shipping = parseFloat(firstShippingInput.val()) || 0;

        // Calculate tax total
        // $('.gj_sc_tax_charge').each(function () {
        //     tax += parseFloat($(this).val()) || 0;
        // });
        $('.gj_sc_tax_charge').each(function () {
            let taxPerUnit = parseFloat($(this).val()) || 0;
            let quantity = parseInt($(this).closest('.cart-item').find('.gj_cart_qty').val()) || 1;
        
            tax += taxPerUnit * quantity;
        });
        
        // if (subtotal >= freeShippingLimit) {
        //     shipping = 0;
        //     $('.gj_sc_shiping_charge').val(0);
        //     $('.gj_cart_ship_tot').val(0);
        //     $('.gj_all_cart_ship_tot').text('FREE');
        // } else {
        //     $('.gj_cart_ship_tot').val(shipping.toFixed(2));
        //     $('.gj_all_cart_ship_tot').text('₹ ' + shipping.toFixed(2));
        // }
         
        
        if (isDomestic && subtotal >= freeShippingLimit) {
            shipping = 0;
            $('.gj_sc_shiping_charge').val(0);
            $('.gj_cart_ship_tot').val(0);
            $('.gj_all_cart_ship_tot').text('FREE');
        } else {
            $('.gj_cart_ship_tot').val(shipping.toFixed(2));
            $('.gj_all_cart_ship_tot').text('₹ ' + shipping.toFixed(2));
        }

        discount = parseFloat($('.gj_cart_dis_tot').val()) || 0;

        coupon = parseFloat($('.gj_cart_coupon_discount').val()) || 0;

        // Update hidden fields and text
        $('.gj_cart_sub_tot').val(subtotal);
        $('.gj_cart_tax_tot').val(tax);
        $('.gj_cart_ship_tot').val(shipping);
        $('.gj_all_sub_cart_total').text('₹ ' + subtotal.toFixed(2));
        $('.gj_all_cart_tax_tot').text('₹ ' + tax.toFixed(2));
        
        if (shipping == 0) {
            $('.gj_all_cart_ship_tot').text('FREE');
        } else {
            $('.gj_all_cart_ship_tot').text('₹ ' + shipping.toFixed(2));
        }

        // Total after all deductions
        let total = subtotal + tax + shipping - discount - coupon;
        $('.gj_all_cart_total').text('₹ ' + total.toFixed(2));
        $('.gj_cart_totalval').val(total.toFixed(2));
    }
   function updateShippingCharges() {
        let pincode = $('#pincode').val();
        console.log("Pincode:", pincode);
    
        let isDomestic = /^\d{6}$/.test(pincode);
    
        $('.gj_sc_shiping_charge').each(function () {
            let input = $(this);
            let domestic = input.data('domestic');
            let international = input.data('international');
    
            if (isDomestic) {
                input.val(domestic);
            } else {
                input.val(international); 
            }
        });
    
        calculateTotal();
    }

    $(document).ready(function () {

        originalShipping = 0;
        updateShippingCharges();
        // $('.gj_sc_shiping_charge').each(function () {
        //     originalShipping += parseFloat($(this).val()) || 0; 
        // });
       let firstShippingInput = $('.gj_sc_shiping_charge').first();
        originalShipping = parseFloat(firstShippingInput.val()) || 0;


        // Shipping logic based on payment method
        $('input[name="payment_method"]').on('change', function () {
            let selectedMethod = $(this).data('name');

            if (selectedMethod === 'Pay on Pick up') {
                $('.gj_sc_shiping_charge').val(0);
                $('.gj_cart_ship_tot').val(0);
                $('.gj_all_cart_ship_tot').text('FREE');
            } else {
                // Reset each charge from data-original
                // let newTotal = 0;
                // $('.gj_sc_shiping_charge').each(function () {
                //     let original = parseFloat($(this).data('original')) || 0;
                //     $(this).val(original.toFixed(2));
                //     newTotal += original;
                // });
                 let pincode = $('#pincode').val();
                console.log("Pincode:", pincode);
            
                let isDomestic = /^\d{6}$/.test(pincode);
            
                $('.gj_sc_shiping_charge').each(function () {
                    let input = $(this);
                    let domestic = input.data('domestic');
                    let international = input.data('international');
            
                    if (isDomestic) {
                        input.val(domestic);
                    } else {
                        input.val(international); 
                    }
                });
    
                 $('.gj_cart_ship_tot').val(originalShipping.toFixed(2));
            $('.gj_all_cart_ship_tot').text('₹ ' + originalShipping.toFixed(2));
            }

            calculateTotal(); // Recalculate after change
        });
       
        $('input[name="address_id"]').on('change', function () {
            let selected = $('input[name="address_id"]:checked');
            let pincode = selected.data('pincode') || '';
        
            if (pincode) {
                 $('#pincode').val(pincode).trigger('change'); // ✅ Force set the pincode input
                updateShippingCharges();    // ✅ Recalculate shipping
            }
        });

        
        $('#pincode').on('keyup change', function () {
            updateShippingCharges();
        });


    });
    
</script>

<script>
// Apply Coupon with <div> method
$(document).on('click', '#apply-coupon-btn', function () {
    let coupon = $('#coupon_code').val();
    if (coupon.trim() === '') {
        $('#coupon-message').text('Please enter a coupon code.');
        setTimeout(function () {
            $('#coupon-message').text('');
        }, 5000);
        return;
    }

    $.ajax({
        url: '{{ route("apply.coupon") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            coupon_code: coupon
        },
        success: function (res) {
            if (res.success) {
                // $('#coupon-box').html(res.html);
                // $('.gj_cart_coupon_discount').val(res.discount);
                // updateCartTotals();
                 location.reload();
            } else {
                $('#coupon-message').text(res.message);
                setTimeout(function () {
                    $('#coupon-message').text('');
                }, 5000);
            }
        }
    });
});

$(document).on('click', '.remove-coupon', function () {
    $.ajax({
        url: '{{ route("remove.coupon") }}',
        type: 'GET',
        success: function (res) {
            if (res.success) {
                // $('#coupon-box').html(res.html);
                // $('.gj_cart_coupon_discount').val(0);
                // updateCartTotals();
                 location.reload();
            }
        }
    });
});


</script>



@endif
@endsection