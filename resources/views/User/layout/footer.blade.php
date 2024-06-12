<script src="Admin/assets/js/plugins/chartjs.min.js"></script> 

<!-- Search  -->
<div class="search-popup">
    <div class="search-popup__overlay custom-cursor__overlay">
        <div class="cursor"></div>
        <div class="cursor-follower"></div>
    </div>
    <div class="search-popup__inner">
        <form action="#" class="search-popup__form">
        <input type="text" name="search" placeholder="{{ __('en.SearchPlaceholder')}}" autocomplete="off" />
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


</div>
<!-- Footer -->
<section class="MainFooter">
    <div class="Footer">
        <div class="left-footer">
            <!-- Logo -->
            <h2>Zhome</h2>
            <h3> {{ __('en.AlwaysInControl')}}</h3>
            <div class="text-footer">
                <p>{{ $contact->phone ." - " . $contact->Phone2}}</p>
                <p>{{ $contact->Market ." and " . $contact->Market2}}</p>
                <p>{{ "Find us in " . $contact->Address }}</p>
            </div>

            <p class="Download">{{ __('en.DownloadApp')}}</p>
            <button>
                <i class="fa-brands fa-android"></i>
                    {{ __('en.Android')}}
            </button>
            <button> 
                <i class="fa-brands fa-apple"></i>
                    {{ __('en.IOS')}}
            </button>
        </div>

        <div class="right-footer mr-0">
            <h3>{{ __('en.Subscription')}}</h3>
            <p>{{ __('en.SubscriptionText')}}</p>
            <div class="subscriptions">
                <input type="text" class="form-control" id="inputEmail" name="Email" placeholder="{{ __('en.EmailPlaceholder')}}" required oninput="handleInput()">
            </div>
            <script>
                var typingTimer;
                var doneTypingInterval = 1000;
            </script>

            <div class="list">
                <ul>
                    <li class="First">{{ __('en.Zhome')}}</li>
                    <li>
                        <a href="{{route('Shop.index')}}">{{ __('en.Shop')}}</a>
                    </li>
                    <li>
                        <a href="{{route('Categories.index')}}">{{ __('en.Categories')}}</a>
                    </li>
                    <li>
                        <a href="{{route('Platforms.index')}}">{{ __('en.Platforms')}}</a>
                    </li>
                    <li>
                        <a href="{{route('Brand.index')}}">{{ __('en.Brands')}}</a>
                    </li>
                </ul>
                <ul>
                    <li class="First">{{ __('en.About')}}</li>
                    <li>
                        <a href="{{route('About.index')}}">
                            {{ __('en.Zhome')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('Services.index')}}">
                            {{ __('en.Services')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('Contact.contact')}}">
                            {{ __('en.ContactUs')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('About.index')}}">
                            {{ __('en.WhyZhome')}}
                        </a>
                    </li>
                </ul>
                <ul>
                    <li class="First">
                        @if (Auth::guard('web')->check())
                            {{ __('en.User')}}
                        @elseif (Auth::guard('admin')->check())
                            {{ __('en.Admin')}}
                        @else
                            {{ __('en.User')}}
                        @endif
                    </li>
                    <li>
                        @if (Auth::guard('web')->check())
                            <a href="{{route('Users.profile')}}">
                                {{ __('en.Profile')}}
                            </a>
                        @elseif (Auth::guard('admin')->check())
                            <a href="{{route('Admins.profile')}}">
                                {{ __('en.Profile')}}
                            </a>
                        @else
                            {{ __('en.JoinUs')}}
                        @endif
                    </li>
                    <li>
                        <a href="{{route('Cart.index')}}">
                            {{ __('en.Cart')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('Tools.index')}}">
                            {{ __('en.Tools')}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('Shop.index')}}">
                            {{ __('en.Products')}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="Lang">
        <button id="langSwitchBtn" onclick="toggleLanguage()">
            <?php if(isset($_SESSION['language']) && $_SESSION['language'] == 'ar'){ ?>
                <img id="langFlag" src="https://zhome.com.eg/Admin/Images/Uploads/egypt.png" alt="Englsih">
                <span id="langName">Arabic</span>
            <?php }else{ ?>
                <img id="langFlag" src="https://zhome.com.eg/Admin/Images/united-kingdom.png" alt="Arabic">
                <span id="langName">English</span>
            <?php } ?>
        </button>

        </div>
        <div class="copy">
            <p >
                Copyright@ {{ \Carbon\Carbon::now()->toDateString() }} Zhome. {{ __('en.CopyRights')}}
            </p>
        </div>
        <div class="Icons">
            <a href=""><i class="fa-brands fa-twitter"></i></a> 
            <a href=""><i class="fa-brands fa-facebook"></i></a> 
            <a href=""><i class="fa-brands fa-linkedin"></i></a> 
        </div>
    </div>
</section>



<!-- Argon dashboard in cart page -->
<script src="{{ asset('UI/') }}Admin/assets/js/core/popper.min.js"></script>
<script src="Admin/assets/js/core/bootstrap.min.js"></script>
<script src="Admin/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="Admin/assets/js/plugins/smooth-scrollbar.min.js"></script>
<!-- End -->
<script src="{{ asset('UI/js/jquery-3.6.1.js') }}"></script>

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
<script src="{{ asset('UI/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('UI/js/theme.js') }}"></script>
<script src="{{ asset('UI/js/Navbar.js') }}"></script>
<!--End-->
<!-- Swipper -->
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- End Swipper -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="{{ asset('UI/js/TweenMax.min.js') }}"></script>
<script src="{{ asset('UI/js/paymob.js') }}"></script>
<script src="{{ asset('UI/js/backend.js') }}"></script>
