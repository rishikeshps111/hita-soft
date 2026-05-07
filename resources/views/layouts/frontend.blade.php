<?php

$general = \DB::table('general_settings')->first();
$email = \DB::table('email_settings')->first();
$social = \DB::table('social_media_settings')->first();
$widget = \DB::table('widgets')->first();
$main_cat = \DB::table('category_management_settings')->where('is_block', 1)->where('is_top_cat', 1)->get();

$footer_setting = DB::table('footer_setting')->first();
$footer_contact = DB::table('footer_contact')->get();
$footer_links1 = \DB::table('footer_all_links')->Where('type', 1)->get();
$footer_links2 = \DB::table('footer_all_links')->Where('type', 2)->get();
$footer_links3 = \DB::table('footer_all_links')->Where('type', 3)->get();
$footer_social_links = \DB::table('footer_social_links')->get();
$footer_payments = \DB::table('footer_payments')->get();


$top_menus = \DB::table('header_menus')->OrderBy('priority', 'ASC')->get();

$logo = \DB::table('logo_settings')->latest()->first();
$logo_path = 'images/logo';
$favicon = \DB::table('favicon_settings')->first();
$favicon_path = 'images/favicon';
$product_path = 'images/featured_products';
$noimage = \DB::table('noimage_settings')->first();
$noimage_path = 'images/noimage';
$prof_file_path = 'images/profile_img';
$login_user = session()->get('user');
$wishls = array();

use Illuminate\Support\Str;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="@if($general) {{$general->meta_title}} @else Rang | Silver-Soul-Style @endif">
    <meta name="description" content="@if($general) {{$general->meta_description}} @else Rang | Silver-Soul-Style @endif">
    <meta name="keywords" content="@if($general) {{$general->meta_keywords}} @else Rang | Silver-Soul-Style @endif">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if($favicon)
    <link rel="shortcut icon" href="{{ asset($favicon_path.'/'.$favicon->favicon_image)}}" type="image/x-icon">
    @else
    <link rel="shortcut icon" href="{{ asset('images/fav_icon.png')}}" type="image/x-icon">
    @endif

    <title> @if($general){{$general->site_name}} @else Rang | Silver-Soul-Style @endif - @yield('title')</title>

    <!-- Custom css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css')}}">

    <!-- Responsive css -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css')}}">

    <!-- Owl carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- Fontawesome -->
    <link href="{{ asset('assets/fontawesome-free-7.0.0-web/css/fontawesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/fontawesome-free-7.0.0-web/css/brands.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/fontawesome-free-7.0.0-web/css/solid.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/fontawesome-free-7.0.0-web/css/sharp-thin.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/fontawesome-free-7.0.0-web/css/sharp-duotone-thin.css') }}" rel="stylesheet" />

    <!-- bootstrap css CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

</head>

<body>

    @include('layouts.frontend_header')

    @yield('content')

    @include('layouts.frontend_footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/carousel.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(Session::has('message'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: '{{ Session::get('
                alert - class ') == '
                alert - success ' ? '
                success ' : '
                error ' }}',
                title: 'Message',
                text: "{{ Session::get('message') }}",
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif


    <script>
        setTimeout(function() {
            document.querySelectorAll('.auto-dismiss').forEach(function(el) {
                el.style.transition = 'opacity 0.5s ease';
                el.style.opacity = 0;
                setTimeout(() => el.remove(), 500);
            });
        }, 5000);
    </script>
    <script>
        window.addEventListener("scroll", function() {
            let navbar = document.querySelector(".nav-custom");
            navbar.classList.toggle("navbar-scrolled", window.scrollY > 50);
        });
    </script>
    <!-- Scripts End -->
    <script>
        function showFlashMessage(message) {
            let flash = $('#product-flash-message');

            flash.text(message)
                .removeClass('d-none')
                .fadeIn();

            setTimeout(function() {
                flash.fadeOut();
            }, 3000);
        }

        function validateAttributes() {

            let colorRequired = $('.color-swatch').length > 1;
            let selectedColor = $('#selected_color_id').val();

            if (colorRequired && !selectedColor) {
                showFlashMessage('Please select a color');
                return false;
            }

            let sizeRequired = $('.gj_vw_att_value').length > 0;
            let sizeSelected = $('.gj_vw_att_value:checked').length > 0;

            if (sizeRequired && !sizeSelected) {
                showFlashMessage('Please select a size');
                return false;
            }

            return true;
        }
    </script>

    <!-- Add To Cart Script Start -->
    <script type="text/javascript">
        $('.gj_add2cart').on('click', function(e) {
            e.preventDefault();

            if (!validateAttributes()) {
                return false;
            }
            var id = $(this).attr('data-cart-id');
            var qty = parseInt($('#qty').val()) || 1;

            var price = 0;
            var att_name = 0;
            var att_value = 0;
            let colorId = $('#selected_color_id').val();
            let colorName = $('#selected_color_name').val();

            var selectedAttr = $('.gj_vw_att_value:checked');

            var att_value = selectedAttr.val() || null;
            var att_name = selectedAttr.data('att-name') || null;

            // if($('#qty').val()) {
            //   var qty = $('#qty').val();
            // }
            if ($('#price').val()) {
                var price = $('#price').val();
            }


            if (id) {
                $.ajax({
                    type: 'post',
                    url: '{{url(' / add_to_cart ')}}',
                    data: {
                        id: id,
                        qty: qty,
                        price: price,
                        att_value: att_value,
                        att_name: att_name,
                        type: 'add_to_cart',
                        color_id: colorId,
                        color_name: colorName
                    },
                    success: function(data) {
                        if (data == 2) {
                            $.confirm({
                                title: '',
                                content: 'Items Already in Cart, Go to Cart to Change Quantiy!',
                                icon: 'fa fa-exclamation',
                                theme: 'modern',
                                closeIcon: true,
                                animation: 'scale',
                                type: 'purple',
                                buttons: {
                                    Ok: function() {}
                                }
                            });
                            // window.location.reload();
                        } else if (data == 7) {
                            $.confirm({
                                title: '',
                                content: 'Sorry, we are out of stock for this product, we shall add more soon :)',
                                icon: 'fa fa-exclamation',
                                theme: 'modern',
                                closeIcon: true,
                                animation: 'scale',
                                type: 'red',
                                buttons: {
                                    Ok: function() {
                                        window.location.reload();
                                    }
                                }
                            });

                            // setTimeout(function(){ window.location.reload(); }, 3000);
                        } else if (data != 1) {
                            // $.confirm({
                            //     title: '',
                            //     content: 'Added To Cart!',
                            //     icon: 'fa fa-check',
                            //     theme: 'modern',
                            //     closeIcon: true,
                            //     animation: 'scale',
                            //     type: 'green',
                            //     buttons: {
                            //         Ok: function(){
                            //             window.location.reload();
                            //         }
                            //     }
                            // });
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });
                            setTimeout(() => {
                                window.location.reload();
                            }, 300);
                        } else {
                            $.confirm({
                                title: '',
                                content: 'No Action Performed!',
                                icon: 'fa fa-exclamation',
                                theme: 'modern',
                                closeIcon: true,
                                animation: 'scale',
                                type: 'purple',
                                buttons: {
                                    Ok: function() {
                                        window.location.reload();
                                    }
                                }
                            });
                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        }
                    }
                });
            } else {
                $.confirm({
                    title: '',
                    content: 'Please Add product to the cart in another time!',
                    icon: 'fa fa-exclamation',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'purple',
                    buttons: {
                        Ok: function() {}
                    }
                });
            }
        });

        /*Delete Cart Script Start*/
        $('.gj_cart_tabl_del').on('click', function() {
            if ($(this).data('id')) {
                var id = $(this).data('id');
                var cart_id = $(this).data('cart-id');
                var cart_key = $(this).data('cart-key');
                var cart_del = $(this).data('cart-del');
                $.ajax({
                    type: 'post',
                    url: '{{url(' / delete_cart ')}}',
                    data: {
                        id: id,
                        cart_id: cart_id,
                        cart_key: cart_key,
                        cart_del: cart_del,
                        type: 'delete_cart'
                    },
                    success: function(data) {
                        if (data != 1) {
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });
                            setTimeout(() => {
                                window.location.reload(); // reload after scroll
                            }, 300);
                        } else {
                            $.confirm({
                                title: '',
                                content: 'No Action Performed!',
                                icon: 'fa fa-exclamation',
                                theme: 'modern',
                                closeIcon: true,
                                animation: 'scale',
                                type: 'purple',
                                buttons: {
                                    Ok: function() {
                                        window.location.reload();
                                    }
                                }
                            });
                        }
                    }
                });
            }
        });
    </script>
    <!-- Add To Cart Script End -->

    <!-- Wish List Script Start -->
    <script type="text/javascript">
        $('.gj_wish_list').on('click', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-wish-id');

            if (id) {
                $.ajax({
                    type: 'post',
                    url: '{{url(' / wishlist ')}}',
                    data: {
                        id: id,
                        type: 'wishlist'
                    },
                    success: function(data) {
                        if (data == 2) {
                            $.confirm({
                                title: '',
                                content: 'Already Added To Wish List!',
                                icon: 'fa fa-exclamation',
                                theme: 'modern',
                                closeIcon: true,
                                animation: 'scale',
                                type: 'blue',
                                buttons: {
                                    Ok: function() {}
                                }
                            });
                            // window.location.reload();
                        } else if (data == 3) {
                            $.confirm({
                                title: '',
                                content: 'You Must Login!',
                                icon: 'fa fa-exclamation',
                                theme: 'modern',
                                closeIcon: true,
                                animation: 'scale',
                                type: 'red',
                                buttons: {
                                    Ok: function() {}
                                }
                            });
                            // window.location.reload();
                        } else if (data != 1) {
                            // $.confirm({
                            //     title: '',
                            //     content: 'Added To Wish List Successfully!',
                            //     icon: 'fa fa-check',
                            //     theme: 'modern',
                            //     closeIcon: true,
                            //     animation: 'scale',
                            //     type: 'green',
                            //     buttons: {
                            //         Ok: function(){
                            //             window.location.reload();
                            //         }
                            //     }
                            // });
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            }); // ðŸ‘ˆ Scroll to top smoothly
                            setTimeout(() => {
                                window.location.reload(); // reload after scroll
                            }, 300);
                        } else {
                            $.confirm({
                                title: '',
                                content: 'No Action Performed!',
                                icon: 'fa fa-exclamation',
                                theme: 'modern',
                                closeIcon: true,
                                animation: 'scale',
                                type: 'purple',
                                buttons: {
                                    Ok: function() {}
                                }
                            });
                        }
                    }
                });
            } else {
                $.confirm({
                    title: '',
                    content: 'Please Add product to the Favourite in another time!',
                    icon: 'fa fa-exclamation',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'blue',
                    buttons: {
                        Ok: function() {
                            window.location.reload();
                        }
                    }
                });
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ✅ Only run on homepage
            if (window.location.pathname !== "/") {
                return;
            }

            let popup = document.getElementById("launchPopup");
            if (!popup) return;

            let today = new Date();
            today.setHours(0, 0, 0, 0);

            let startDate = new Date(2026, 3, 14);
            let endDate = new Date(2026, 3, 15);
            endDate.setHours(23, 59, 59, 999);

            if (today >= startDate && today <= endDate) {
                popup.style.display = "flex";

                setTimeout(() => {
                    popup.style.display = "none";
                }, 15000);
            }
        });
    </script>
    <!-- Wish List Script End -->

    <!-- Auto Complete Off Script Start -->
    <script type="text/javascript">
        $(document).ready(function() {
            $("input").attr('autocomplete', 'new-password');
        });
    </script>
    <!-- Auto Complete Off Script End -->
    @if($social)
    @if($social->analytics_code)
    <div><?php echo htmlspecialchars_decode($social->analytics_code); ?></div>
    @endif
    @endif

    <!-- All Scripts Start -->

    @yield('before_scripts')

    @php
    $whatsappLink = null;
    if (isset($footer_social_links) && sizeof($footer_social_links) != 0) {
    foreach ($footer_social_links as $link) {
    if (strpos($link->icon, 'fa-whatsapp') !== false) {
    $whatsappLink = $link->url;
    break;
    }
    }
    }
    @endphp


    <!-- <a href="{{ $whatsappLink }}" target="_blank" class="whatsapp-float" title="Chat on WhatsApp">
        <img src="https://cdn-icons-png.flaticon.com/512/124/124034.png" alt="WhatsApp" />

    </a> -->



</body>

</html>