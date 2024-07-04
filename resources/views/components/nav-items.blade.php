@if(isset($showAll) || isset($showMain))
    <li class="menu__item">
        <a href="{{ route('index') }}" class="menu__link">{{ __('messages.Home') }}</a>
    </li>
@endif

@if(isset($showAll) || isset($showCategories))
    <li class="menu__item">
        <a href="{{ route('Shop.index') }}" class="menu__link">{{ __('messages.Shop') }}</a>
    </li>

    <li class="menu__item menu__dropdown">
        <a href="#" class="menu__link">
            {{ __('messages.Categories') }}
            <i class="fa-solid fa-arrow-right"></i>
        </a>
        <div class="submenu megamenu__text">
            <ul class="menu__inner SubCategoriesInNav">
                @foreach ( $navCategories as $category)
                    <li class="menu__item menu__dropdown">
                        <a href="{{route('Shop.Filter.category' , $category->ID )}}" class="menu__link">
                            {{$category->Category}}
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <div class="submenu megamenu__text">
                            <div class="submenu__inner">
                                <h4 class="submenu__title">
                                    <a href="{{route('Shop.Filter.category' , $category->ID )}}" style="color: var(--color);">
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
                                            <a href="{{route('Shop.Filter.subcategory' , $subcategory->ID )}}">
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
            </ul>
        </div>
    </li>
@endif

@if(isset($showAll) || isset($showBrands))
    <li class="menu__item menu__dropdown">
        <a href="#" class="menu__link">
        {{ __('messages.Brands')}}
        <i class="fa-solid fa-arrow-right"></i>
        </a>
        <div class="submenu megamenu__text">
            <div id="BrandsInNav">
            @foreach ($brands as $brand )
                <div class="submenu__inner PlatformInNav">
                    <a href="{{route('Shop.Filter.brand' , $brand->ID )}}" >
                        <img src="{{asset("Admin/dist/img/web/Brands/$brand->Logo")}}" alt="{{$brand->Brand}}">
                    </a>
                </div>
            @endforeach
            </div>
        </div>
    </li>
@endif

@if(isset($showAll) || isset($showPlatforms))
    <li class="menu__item menu__dropdown">
        <a href="#" class="menu__link">
        {{ __('messages.Platforms')}}
        <i class="fa-solid fa-arrow-right"></i>
        </a>
        <div class="submenu megamenu__text">
            @foreach ($platforms as $platform )
                <div class="submenu__inner PlatformInNav">
                    <div class="submenu__inner PlatformInNav">
                        <a href="{{route('Shop.Filter.platform' , $platform->ID )}}" class="d-flex align-items-center">
                            <img src="{{asset("Admin/dist/img/web/Platforms/$platform->Logo")}}" alt="{{$platform->Platform}}">
                            {{$platform->Platform}}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </li>
@endif

@if(isset($showAll) || isset($showMain))
    <li class="menu__item">
        <a href="{{ route('Shop.index') }}" class="menu__link">{{ __('messages.Shop') }}</a>
    </li>
    <li class="menu__item">
        <a href="{{ route('Tools.index') }}" class="menu__link">{{ __('messages.Design') }}</a>
    </li>
    <li class="menu__item">
        <a href="{{ route('About.index') }}" class="menu__link">{{ __('messages.About') }}</a>
    </li>
@endif
