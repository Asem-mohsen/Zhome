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
            @if ($isMobile)
                <x-sidebar-nav :categories="$categories" :brands="$brands" :platforms="$platforms" />
            @elseif ($isShop)
                <x-shop-nav :categories="$categories" :brands="$brands" :platforms="$platforms" />
            @else
                <x-main-nav />
            @endif
        </section>

        <x-navbar-icons />
    </nav>
</header>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const burger = document.querySelector('#burger');
        const menu = document.querySelector('#menu');
        const overlay = document.querySelector('.overlay');

        burger.addEventListener('click', function() {
            menu.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', function() {
            menu.classList.remove('active');
            overlay.classList.remove('active');
        });

        function handleResize() {
            if (window.innerWidth > 768) {
                menu.classList.remove('active');
                overlay.classList.remove('active');
            }
        }

        window.addEventListener('resize', handleResize);
    });
</script>
