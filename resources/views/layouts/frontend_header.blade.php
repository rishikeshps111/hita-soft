<header class="header">
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="top-header-content">
                        <div class="top-bar-contact">
                            <ul>
                                <li><a href="mailto:{{ $header_email }}"><i class="fa-solid fa-envelope"></i>
                                        {{ $header_email }}</a>
                                </li>
                                <li><a href="tel:{{ $header_phone }}"><i
                                            class="fa-solid fa-phone"></i>{{ $header_phone }}</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg ">
        <div class="container">
            <a class="navbar-brand nav-logo" href="{{ route('home') }}">
                @if($logo)
                    <img src="{{ asset($logo_path . '/' . $logo->logo_image) }}" alt="Logo">
                @else
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                @endif</a>
            <button class="navbar-toggler nav-toggle-open" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title nav-logo" id="offcanvasNavbarLabel">
                        @if($logo)
                            <img src="{{ asset($logo_path . '/' . $logo->logo_image) }}" alt="Logo">
                        @else
                            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                        @endif
                    </h5>
                    <button type="button" class="nav-toggle-close" data-bs-dismiss="offcanvas" aria-label="Close"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 navbar-menu-list">

                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('home') }}">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('products') }}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('services') }}">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('about_us') }}">About</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('contact_us') }}">Contact Us</a>
                        </li>
                        @php
                            $headerCarts = [];
                            $headerWishlists = [];
                            $sessionCart = Session::get('cart', []);
                            $headerCartCount = is_countable($sessionCart) ? count($sessionCart) : 0;

                            if ($login_user && $login_user->user_type == 4) {
                                $headerCarts = \DB::table('carts')->where('user_id', $login_user->id)->get()->toArray();
                                $headerWishlists = \DB::table('wish_lists')->where('user_id', $login_user->id)->get()->toArray();
                                $headerCartCount = count($headerCarts) > 0 ? count($headerCarts) : $headerCartCount;
                            }

                            $headerWishlistCount = count($headerWishlists);
                            $headerUserName = 'My Account';

                            if ($login_user) {
                                $headerUserName = trim(($login_user->full_name ?? '') ?: trim(($login_user->first_name ?? '') . ' ' . ($login_user->last_name ?? '')));
                                $headerUserName = $headerUserName !== '' ? $headerUserName : 'My Account';
                            }

                            $headerProfileImage = null;

                            if ($login_user && !empty($login_user->profile_img)) {
                                $headerProfileImage = asset($prof_file_path . '/' . $login_user->profile_img);
                            } elseif (!empty($noimage->profile_no_img)) {
                                $headerProfileImage = asset($noimage_path . '/' . $noimage->profile_no_img);
                            } else {
                                $headerProfileImage = asset('assets/img/no-user-image-square.jpg');
                            }
                        @endphp

                        @if($login_user && $login_user->user_type == 4 && $headerWishlistCount > 0)
                            <li class="nav-item header-action-item">
                                <a href="{{ route('wishlist') }}" class="cart-icon cart_rang cart-heart"
                                    aria-label="Wishlist">
                                    <i class="fa-regular fa-heart" aria-hidden="true"></i>
                                    <span class="cart-count">{{ $headerWishlistCount }}</span>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item header-action-item">
                            <a href="{{ route('cart') }}" class="cart-icon cart_rang cart-shop" aria-label="Cart">
                                <i class="fa-solid fa-bag-shopping" aria-hidden="true"></i>
                                @if($headerCartCount > 0)
                                    <span class="cart-count">{{ $headerCartCount }}</span>
                                @endif
                            </a>
                        </li>

                        @if($login_user && $login_user->user_type == 4)
                            <div class="acount-drop-down" id="profileDrop" onclick="profileDrop()">
                                <span>
                                    <img src="{{ $headerProfileImage }}" alt="{{ $headerUserName }}">
                                    <p>{{ $headerUserName }}</p>
                                </span>
                                <i class="fa-solid fa-chevron-down"></i>
                                <div class="acount-drop-menu">
                                    <ul>
                                        <li><a href="{{ route('my_account') }}"><i class="fa-solid fa-user"></i> My
                                                Account</a></li>
                                        <li><a href="{{ route('logout') }}"><i
                                                    class="fa-solid fa-arrow-right-from-bracket"></i> Log Out</a></li>
                                    </ul>
                                </div>
                            </div>
                        @else
                            <li class="nav-item header-action-item top-auth-box">
                                <a href="{{ route('signin') }}" class="sign-in" style="color: #fff;"> Sign In</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>