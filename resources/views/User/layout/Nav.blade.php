
<header class="header hidden stricky" id="header">
    <nav class="navbar container" style="padding: 0;">
      <section class="navbar__left">
        <div class="burger" id="burger">
          <span class="burger-line"></span>
          <span class="burger-line"></span>
          <span class="burger-line"></span>
        </div>
        <a href="{{route('index')}}" class="BrandName">
          {{ __('messages.Zhome')}}
        </a>
      </section>
      <section class="navbar__center">
        <span class="overlay"></span>
        <div class="menu" id="menu">
          <div class="menu__header">

            <span class="menu__arrow"><i class="fa-solid fa-arrow-left"></i></span>
            <span class="menu__title"></span>
          </div>
          <div class="menu__logo">
           <a href="{{route('index')}}" class="BrandName">
              {{ __('messages.Zhome')}}
            </a>
          </div>
          <ul class="menu__inner">
            <li class="menu__item">
                <a href="{{route('index')}}" class="menu__link">{{ __('messages.Home')}}</a>
            </li>
            <li class="menu__item menu__dropdown OnlyShwonInSmallSize OnlyShowInShopNav">
                <a href="#" class="menu__link">
                    {{ __('messages.Categories')}}
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
                <div class="submenu megamenu__text">
                    <ul class="menu__inner SubCategoriesInNav">
                    @if($categories->isNotEmpty())
                        @foreach ( $categories as $category)
                            <li class="menu__item menu__dropdown OnlyShwonInSmallSize OnlyShowInShopNav">
                                <a href="#" class="menu__link">
                                    {{$category->Category}}
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                                <div class="submenu megamenu__text">
                                    <div class="submenu__inner">
                                        <h4 class="submenu__title">
                                            <a href="{{route('Shop.index')}}" style="color: var(--color);">
                                                @if(App::getLocale() == 'ar')
                                                    {{$category->ArabicName}}
                                                @else
                                                    {{$category->Category}}
                                                @endif
                                            </a>
                                        </h4>
                                        <ul class="submenu__list">
                                            @foreach ( $category->subcategories as $subcategory)
                                                <li>
                                                    <a href="{{route('Shop.index')}}">
                                                        @if(App::getLocale() == 'ar')
                                                            {{$subcategory->SubArabicName}}
                                                        @else
                                                            {{$subcategory->SubName}}
                                                        @endif
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                    </ul>
                </div>
            </li>
            <li class="menu__item menu__dropdown OnlyShwonInSmallSize OnlyShowInShopNav">
                <a href="#" class="menu__link">
                {{ __('messages.Brands')}}
                <i class="fa-solid fa-arrow-right"></i>
                </a>
                <div class="submenu megamenu__text">
                    <div id="BrandsInNav">
                    @foreach ($brands as $brand )
                        <div class="submenu__inner PlatformInNav">
                            <a href="{{route('Shop.index')}}" >
                                <img src="{{asset("Admin/dist/img/web/Brands/$brand->Logo")}}" alt="{{$brand->Brand}}">
                            </a>
                        </div>
                    @endforeach
                    </div>
                </div>
            </li>
            <li class="menu__item menu__dropdown OnlyShwonInSmallSize OnlyShowInShopNav">
                <a href="#" class="menu__link">
                {{ __('messages.Platforms')}}
                <i class="fa-solid fa-arrow-right"></i>
                </a>
                <div class="submenu megamenu__text">
                @foreach ($platforms as $platform )
                    <div class="submenu__inner PlatformInNav">
                        <div class="submenu__inner PlatformInNav">
                            <a href="{{route('Shop.index')}}" class="d-flex align-items-center">
                                <img src="{{asset("Admin/dist/img/web/Platforms/$platform->Logo")}}" alt="{{$platform->Platform}}">
                                {{$platform->Platform}}
                            </a>
                        </div>
                    </div>
                @endforeach
                </div>
            </li>
            <li class="menu__item">
                <a href="{{route('Shop.index')}}" class="menu__link">{{ __('messages.Shop')}}</a>
            </li>
            <li class="menu__item OnlyShwonInSmallSize">
                <a href="{{route('Tools.index')}}" class="menu__link">{{ __('messages.Design')}}</a>
            </li>
             <li class="menu__item HideInShopNav">
                <a href="{{route('About.index')}}" class="menu__link">{{ __('messages.About')}}</a>
            </li>
           <li class="menu__item HideInShopNav OnlyShwonInSmallSize">
                <a href="{{route('Shop.index')}}" class="menu__link" >{{ __('messages.Bundles')}}</a>
            </li>
            <li class="menu__item HideInShopNav OnlyShwonInSmallSize">
                <a href="{{route('Cart.index')}}" class="menu__link" >{{ __('messages.Cart')}}</a>
            </li>
             <li class="menu__item HideInShopNav" id="ToolButton">
                <a href="{{route('Tools.index')}}" class="menu__link">{{ __('messages.ProposalDesignButton')}}</a>
            </li>
            <hr class="vr OnlyShwonInSmallSize">
             <li class="menu__item OnlyShwonInSmallSize">
                <a href="{{route('About.index')}}" class="menu__link">{{ __('messages.Company')}}</a>
            </li>
            <li class="menu__item OnlyShwonInSmallSize">
                <a href="{{route('Contact.contact')}}" class="menu__link">{{ __('messages.ContactUs')}}</a>
            </li>

            @if (!Auth::check())
                <hr class="vr OnlyShwonInSmallSize">
                <li class="menu__item OnlyShwonInSmallSize">
                    <a href="{{route('register')}}" class="menu__link">{{ __('messages.SignUp')}}</a>
                </li>
                <li class="menu__item OnlyShwonInSmallSize">
                    <a href="{{route('login')}}" class="menu__link">{{ __('messages.SignIn')}}</a>
                </li>
            @elseif (Auth::guard('web')->check())
                <li class="menu__item OnlyShwonInSmallSize">
                    <a href="{{route('Users.profile' , Auth::id() )}}" class="menu__link">{{ __('messages.Profile')}}</a>
                </li>
            @elseif (Auth::guard('admin')->check())
                <li class="menu__item OnlyShwonInSmallSize">
                    <a href="{{route('Admins.profile'  , Auth::guard('admin')->user()->id)}}" class="menu__link">{{ __('messages.Profile')}}</a>
                </li>
            @endif

            <div class="copyright">
                <div class="Icons">
                    <a href=""><i class="fa-brands fa-twitter"></i></a>
                    <a href=""><i class="fa-brands fa-facebook"></i></a>
                    <a href=""><i class="fa-brands fa-linkedin"></i></a>
                </div>
                <div class="Lang">
                    <div id="langSwitchBtn">
                        @if(App::getLocale() == 'en')
                            <a id="langSwitchBtn" href="{{ route('language', 'ar') }}" class="lang-switch-btn">
                                <img class="lang-flag" src="https://zhome.com.eg/Admin/Images/Uploads/egypt.png" alt="Arabic">
                                <span class="lang-name">Arabic</span>
                            </a>
                        @else
                            <a id="langSwitchBtn" href="{{ route('language', 'en') }}" class="lang-switch-btn">
                                <img class="lang-flag" src="https://zhome.com.eg/Admin/Images/united-kingdom.png" alt="English">
                                <span class="lang-name">English</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="copy">
                    <p>
                        Copyright@ {{ \Carbon\Carbon::now()->toDateString() }} Zhome. {{ __('messages.CopyRights')}}
                    </p>
                </div>
            </div>
          </ul>
        </div>
      </section>
      <!--Icons-->
      <section id="Icons">
            <ul class="topbar-one__right list-unstyled ml-4">
                @if (!Auth::check())
                    <hr class="vr OnlyShwonInSmallSize">
                    <li class="menu__item OnlyShwonInSmallSize">
                        <a href="{{route('register')}}" class="menu__link">{{ __('messages.SignUp')}}</a>
                    </li>
                    <li class="menu__item OnlyShwonInSmallSize">
                        <a href="{{route('login')}}" class="menu__link">{{ __('messages.SignIn')}}</a>
                    </li>
                @elseif (Auth::guard('web')->check())
                    <a href="{{route('Users.profile' , Auth::id() )}}" class="nav-icon JoinUs hidInSign">
                        {{ __('messages.Profile')}}
                    </a>
                    <div class="separator NewSeparator"></div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                    <a class="nav-link" href="#" title="{{ __('messages.LogOut')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </a>
                    <a href="{{route('Cart.index')}}" class="nav-icon CartIcon CartIconNav">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="count" id="cart-count"></span>
                    </a>
                @elseif (Auth::guard('admin')->check())
                    <a href="{{route('Admins.profile', Auth::guard('admin')->user()->id )}}" class="nav-icon JoinUs hidInSign">
                        {{ __('messages.Profile')}}
                    </a>
                    <div class="separator NewSeparator"></div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                    <a class="nav-link" href="#" title="{{ __('messages.LogOut')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </a>
                @else
                    <a href="{{route('login')}}" class="nav-icon JoinUs hidInSign">
                        {{ __('messages.JoinUs')}}
                    </a>
                    <div class="separator NewSeparator"></div>
                    <a href="#" class="nav-icon search-popup__toggler">
                        <i class="fa fa-search"></i>
                    </a>
                    <a href="{{route('Cart.index')}}" class="nav-icon CartIconNav">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="count" id="cart-count"></span>
                    </a>
                @endif
            </ul>
      </section>
    </nav>
  </header>
