<header class="header hidden stricky" id="header">
    <nav class="navbar container p-0">
        <section class="navbar__left">
            <div class="burger" id="burger">
                <span class="burger-line"></span>
                <span class="burger-line"></span>
                <span class="burger-line"></span>
            </div>
            <a href="{{ route('index') }}" class="BrandName">
                Zhome
            </a>
        </section>

        <section class="navbar__center">
            <span class="overlay"></span>
            <div class="menu" id="menu">
                @if ($isMobile)
                    <x-sidebar-nav :categories="$allCategories" :brands="$brands" :platforms="$platforms" />
                @elseif ($isShop)
                    <x-shop-nav :categories="$navCategories" :brands="$brands" :platforms="$platforms" />
                @else
                    <x-main-nav />
                @endif
            </div>
        </section>

        <x-navbar-icons />
    </nav>
</header>


<script>

</script>
