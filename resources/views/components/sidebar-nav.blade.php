<span class="overlay"></span>
<div class="menu" id="menu">
    <div class="menu__header">
        <span class="menu__arrow"><i class="fa-solid fa-arrow-left"></i></span>
        <span class="menu__title"></span>
    </div>
    <div class="menu__logo">
        <a href="{{ route('index') }}" class="BrandName">
            Zhome
        </a>
    </div>
    <ul class="menu__inner">
        @include('components.nav-items', ['showAll' => true])
    </ul>
</div>
