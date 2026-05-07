<header class="header">
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="top-header-content">
                        <div class="top-bar-contact">
                            <ul>
                                <li><a href="#!"><i class="fa-solid fa-envelope"></i> hitasoftsystems@gmail.com</a>
                                </li>
                                <li><a href="#!"><i class="fa-solid fa-phone"></i>+91 9387737998</a></li>
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
                        <div class="top-auth-box">
                            <a href="auth-page.html">Sign In</a>
                            <!-- <a href="sign_up.html">Sign Up</a> -->
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>