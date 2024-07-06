<section id="Icons">
    <ul class="topbar-one__right list-unstyled ml-4">
        @if (Auth::guard('web')->check())
            {{-- Profile --}}
            <a href="{{route('Profile.profile', Auth::guard('web')->user()->id)}}" class="nav-icon JoinUs hidInSign">
                {{ __('messages.Profile')}}
            </a>
            <div class="separator NewSeparator"></div>
            {{-- Cart --}}
            <a href="{{route('Cart.index')}}" class="nav-icon CartIcon CartIconNav">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="count" id="cart-count"></span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @method('GET')
                @csrf
            </form>
            {{-- Logout --}}
            <a class="nav-icon text-white" href="#" title="{{ __('messages.LogOut')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>

        @elseif (Auth::guard('admin')->check())
            {{-- Profile --}}
            <a href="{{route('Admins.profile', Auth::guard('admin')->user()->id)}}" class="nav-icon JoinUs hidInSign">
                {{ __('messages.Profile')}}
            </a>
            <div class="separator NewSeparator"></div>
            {{-- Logout --}}
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @method('GET')
                @csrf
            </form>
            <a class="nav-link" href="#" title="{{ __('messages.LogOut')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </a>
        @else
            {{-- Cart --}}
            <a href="{{route('Cart.index')}}" class="nav-icon CartIcon CartIconNav">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="count" id="cart-count"></span>
            </a>
            <div class="separator NewSeparator"></div>
            {{-- Login --}}
            <li class="menu__item">
                <a href="{{route('login')}}" class="menu__link JoinUsBtn">{{ __('messages.JoinUs')}}</a>
            </li>
        @endif
    </ul>
</section>
