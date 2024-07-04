
<!-- Search  -->
<div class="search-popup">
    <div class="search-popup__overlay custom-cursor__overlay">
        <div class="cursor"></div>
        <div class="cursor-follower"></div>
    </div>
    <div class="search-popup__inner">
        <form action="#" class="search-popup__form">
        <input type="text" name="search" placeholder="{{ __('messages.SearchPlaceholder')}}" autocomplete="off" />
        <button type="submit">
            <i class="fa fa-search"></i>
        </button>
        </form>
    </div>
</div>

<!-- Scroll to Top -->
<a href="#" data-target="html" class="scroll-to-target scroll-to-top">
    <i class="fa fa-arrow-turn-up"></i>
</a>

<!-- Footer -->
<section class="MainFooter">
    <div class="Footer">
        <div class="left-footer">
            <!-- Logo -->
            <h2>Zhome</h2>
            <h3> {{ __('messages.AlwaysInControl')}}</h3>
            <div class="text-footer">
                <p>{{ $contact->phone ." - " . $contact->Phone2}}</p>
                <p>{{ $contact->Market ." and " . $contact->Market2}}</p>
                <p>{{ "Find us in " . $contact->Address }}</p>
            </div>

            <p class="Download">{{ __('messages.DownloadApp')}}</p>
            <button>
                <i class="fa-brands fa-android"></i>
                    {{ __('messages.Android')}}
            </button>
            <button>
                <i class="fa-brands fa-apple"></i>
                    {{ __('messages.IOS')}}
            </button>
        </div>

        <div class="right-footer mr-0">
            <h3>{{ __('messages.Subscription')}}</h3>
            <p>{{ __('messages.SubscriptionText')}}</p>
            <div class="subscriptions">
                <input type="text" class="form-control" id="inputEmail" name="Email" placeholder="{{ __('messages.EmailPlaceholder')}}" required oninput="handleInput()">
            </div>
            <script>
                var typingTimer;
                var doneTypingInterval = 1000;
            </script>

            <div class="list">
                <ul>
                    <li class="First">{{ __('messages.Zhome')}}</li>
                    <li>
                        <a href="{{route('Shop.index')}}">{{ __('messages.Shop')}}</a>
                    </li>
                    <li>
                        <a href="{{route('Categories.index')}}">{{ __('messages.Categories')}}</a>
                    </li>
                    <li>
                        <a href="{{route('Platforms.user.index')}}">{{ __('messages.Platforms')}}</a>
                    </li>
                    <li>
                        <a href="{{route('Brand.index')}}">{{ __('messages.Brands')}}</a>
                    </li>
                </ul>
                <ul>
                    <li class="First">{{ __('messages.About')}}</li>
                    <li>
                        <a href="{{route('About.index')}}">
                            {{ __('messages.Zhome')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('Services.index')}}">
                            {{ __('messages.Services')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('Contact.contact')}}">
                            {{ __('messages.ContactUs')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('About.index')}}">
                            {{ __('messages.WhyZhome')}}
                        </a>
                    </li>
                </ul>
                <ul>
                    <li class="First">
                        @if (Auth::guard('web')->check())
                            {{ __('messages.User')}}
                        @elseif (Auth::guard('admin')->check())
                            {{ __('messages.Admin')}}
                        @else
                            {{ __('messages.User')}}
                        @endif
                    </li>
                    <li>
                        @if (Auth::guard('web')->check())
                            <a href="{{route('Profile.profile', Auth::guard('web')->user()->id)}}">
                                {{ __('messages.Profile')}}
                            </a>
                        @elseif (Auth::guard('admin')->check())
                            <a href="{{route('Admins.profile' , Auth::guard('admin')->user()->id )}}">
                                {{ __('messages.Profile')}}
                            </a>
                        @else
                            <a href="{{route('login')}}">
                                {{ __('messages.JoinUs')}}
                            </a>
                        @endif
                    </li>
                    <li>
                        <a href="{{route('Cart.index')}}">
                            {{ __('messages.Cart')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('Tools.index')}}">
                            {{ __('messages.Tools')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('Shop.FilterIndex')}}">
                            {{ __('messages.Products')}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="Lang">
            @if(App::getLocale() == 'en')
                <a id="langSwitchBtn" href="{{ route('language', 'ar') }}" class="lang-switch-btn">
                    <img class="lang-flag" src="{{asset('UI/Imgs/website/Footer/egypt.png')}}" alt="Arabic">
                    <span class="lang-name">Arabic</span>
                </a>
            @else
                <a id="langSwitchBtn" href="{{ route('language', 'en') }}" class="lang-switch-btn">
                    <img class="lang-flag" src="{{asset('UI/Imgs/website/Footer/united-kingdom.png')}}" alt="English">
                    <span class="lang-name">English</span>
                </a>
            @endif
        </div>
        <div class="copy">
            <p >
                Copyright@ {{ \Carbon\Carbon::now()->year }} Zhome. {{ __('messages.CopyRights')}}
            </p>
        </div>
        <div class="Icons">
            <a href=""><i class="fa-brands fa-twitter"></i></a>
            <a href=""><i class="fa-brands fa-facebook"></i></a>
            <a href=""><i class="fa-brands fa-linkedin"></i></a>
        </div>
    </div>
</section>


<!-- End -->
<script src="{{ asset('UI/js/jquery-3.6.1.js') }}"></script>
<script src="{{ asset('UI/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('UI/js/jquery.min.js') }}"></script>
<script src="{{ asset('UI/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('UI/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('UI/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset('UI/js/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('UI/js/jquery.selectBoxIt.min.js') }}"></script>
<script src="{{ asset('UI/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('UI/js/bootoast.min.js') }}"></script>
<script src="{{ asset('UI/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('UI/js/isotope.js') }}"></script>
<script src="{{ asset('UI/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('UI/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('UI/js/html2canvas.js') }}"></script>

<script src="https://kit.fontawesome.com/39c3d46f9d.js" crossorigin="anonymous"></script>
<script src="{{ asset('UI/js/nouislider.js') }}"></script>
<script src="{{ asset('UI/js/wow.min.js') }}"></script>
<script src="{{ asset('UI/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('UI/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('UI/js/waypoints.min.js') }}"></script>

<script src="{{ asset('UI/js/theme.js') }}"></script>
<script src="{{ asset('UI/js/Navbar.js') }}"></script>
<script src="{{ asset('UI/js/popper.min.js') }}"></script>
<!--End-->
<!-- Swipper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- End Swipper -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script src="{{ asset('UI/js/TweenMax.min.js') }}"></script>
<script src="{{ asset('UI/js/paymob.js') }}"></script>
<script src="{{ asset('UI/js/backend.js') }}"></script>
<script src="{{ asset('UI/js/user.js') }}"></script>
<script>
    function toggleLanguage() {
        var currentLocale = $('html').attr('lang');
        var newLocale = currentLocale === 'en' ? 'ar' : 'en';

        $.get('/language/' + newLocale, function() {
            location.reload();
        });
    }
</script>
