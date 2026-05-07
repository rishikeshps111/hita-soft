@php
    use Illuminate\Support\Str;
@endphp
<footer class="footer">
    <div class="container">
        <div class="row">

            <div class="col-lg-3">
                <div class="footer-logo">
                    <a href="{{ route('home') }}">
                        @if($logo)
                            <img src="{{ asset($logo_path . '/' . $logo->logo_image) }}" alt="Logo">
                        @else
                            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                        @endif
                    </a>

                    <p>
                        {{ $footer_setting->footer_desc ?? 'Hita Soft Systems is a specialized engineering firm based in Thiruvananthapuram, Kerala, focused on the design and manufacturing of embedded software-controlled automation systems, particularly for water pump management' }}
                    </p>
                </div>
            </div>

            <div class="col-lg-2 mb-2">
                <div class="footer-widget-third ps-5">
                    <h3>{{ $footer_setting->heading1 ?? 'Quick Links' }}</h3>
                    <ul>
                        @if(isset($footer_links1) && sizeof($footer_links1) != 0)
                            @foreach($footer_links1 as $link)
                                <li><a href="{{ $link->url }}">{{ $link->title }}</a></li>
                            @endforeach
                        @else
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('about_us') }}">About</a></li>
                            <li><a href="{{ route('services') }}">Services</a></li>
                            <li><a href="{{ route('products') }}">Products</a></li>
                            <li><a href="{{ route('contact_us') }}">Contact</a></li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="col-lg-2 mb-2">
                <div class="footer-widget-third">
                    <h3>{{ $footer_setting->heading2 ?? 'Others' }}</h3>
                    <ul>
                        @if(isset($footer_links2) && sizeof($footer_links2) != 0)
                            @foreach($footer_links2 as $link)
                                <li><a href="{{ $link->url }}">{{ $link->title }}</a></li>
                            @endforeach
                        @else
                            <li><a href="#">Terms & Conditions</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Cookies</a></li>
                            <li><a href="#">Refund Policy</a></li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 mb-2">
                <div class="footer-widget-third">
                    <h3>{{ $footer_setting->heading3 ?? 'Others' }}</h3>
                    <ul class="ftr-cnt">
                        @if(isset($footer_contact) && sizeof($footer_contact) != 0)
                            @foreach($footer_contact as $contact)
                                @php
                                    $isEmail = Str::contains($contact->title, '@');
                                    $cleanNumber = preg_replace('/[^0-9]/', '', $contact->title);
                                @endphp

                                <li>
                                    <i class="fa {{ $contact->icon }}"></i>

                                    @if($isEmail)
                                        <a href="mailto:{{ $contact->title }}">{{ $contact->title }}</a>
                                    @elseif($contact->icon == 'fa-phone')
                                        <a href="tel:{{ $cleanNumber }}">{{ $contact->title }}</a>
                                    @else
                                        {{ $contact->title }}
                                    @endif
                                </li>
                            @endforeach
                        @else
                            <li><i class="fa fa-location-dot"></i> TC 49/20-1 Pamamcode, Pappanamcode Industrial Estate PO,
                                Thiruvananthapuram, Kerala - 695019 India</li>
                            <li><i class="fa fa-phone"></i><a href="tel:+919387737998">+91-9387737998</a></li>
                            <li><i class="fa fa-envelope"></i><a
                                    href="mailto:hitasoftsystems@gmail.com">hitasoftsystems@gmail.com</a></li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="col-lg-2 mb-2">
                <div class="footer-widget-third">
                    <h3>Follow Us</h3>
                    <div class="footer-left-icons">
                        <ul>
                            @if(isset($footer_social_links) && sizeof($footer_social_links) != 0)
                                @foreach($footer_social_links as $social)
                                    <li>
                                        <a href="{{ $social->url }}" target="_blank">
                                            <i class="{{ $social->icon }}"></i>
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li><a href="#!" class="twitter"><i class="fa-brands fa-x-twitter"></i></a></li>
                                <li><a href="#!" class="facebook"><i class="fa-brands fa-facebook-f"></i></a></li>
                                <li><a href="#!" class="linkedin"><i class="fa-brands fa-instagram"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="copyright">
        <p>
            ©2026 Hita Soft Solutions All rights reserved | Powered by
            <a href="https://axnoldigitalsolutions.com/" target="_blank">Axnol Digital Solutions</a>
        </p>
    </div>
</footer>