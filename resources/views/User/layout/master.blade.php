<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Schema.org Markup -->
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Organization",
            "name": "Zhome",
            "url": "https://zhome.com.eg/",
            "logo": "https://zhome.com.eg/Admin/Images/LogoZhome.png",
            "description": "Zhome is the first Egyptian smart home marketplace"
        }
    </script>

    <meta charset="utf-8" />
    <meta name="viewport"     content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"  content="Zhome is the expert for all connected life products. We are the First complete platform and solution provider for products and services that make your home smarter and your life more connected!"/>
    <title>@yield('Title')</title>

    <link rel="icon"          type="image/png"    href="{{asset('UI/imgs/Logos/LogoZhome.png')}}">
    <link rel="icon"          type="image/x-icon" href="{{asset('UI/imgs/Logos/LogoZhome.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('UI/imgs/Logos/LogoZhome.png')}}" >
    <!--Google Search-->
    <meta name="google-site-verification" content="D3BTXkEFE3-YrOevNUYmT0RckGfr78c3d3hjxazurQo" />
    <!--   Fonts and icons     -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Roboto:wght@100;300;400;500;700;900&family=Work+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset('UI/css/animate.css')}}">
    <link rel="stylesheet" href="{{ asset('UI/css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{ asset('UI/css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{ asset('UI/css/bootstrap.min.css')}}">
    {{-- <link rel="stylesheet" href="{{ asset('UI/css/hover-min.css')}}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('UI/css/query.bootstrap-touchspin.min.css')}}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('UI/css/jquery.mCustomScrollbar.min.css')}}"> --}}
    <!-- Swipper Home Page Brands -->
    <!-- End Swipper -->
    <link rel="stylesheet" href="{{ asset('UI/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{ asset('UI/css/nouislider.css')}}">
    <link rel="stylesheet" href="{{ asset('UI/css/nouislider.pips.css')}}">
    <link rel="stylesheet" href="{{ asset('UI/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('UI/css/owl.theme.default.min.css')}}">
    {{-- <link rel="stylesheet" href="{{ asset('UI/css/payment.css')}}"> --}}
    <link rel="stylesheet" href="{{ asset('UI/css/responsive.css')}}">
    <!-- Shop -->
    <link rel="stylesheet" href="{{ asset('UI/css/core-style.css')}}">
    <!-- End Shop -->
    <link rel="stylesheet" href="{{ asset('UI/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('UI/css/Main.css')}}">
    <link rel="stylesheet" href="{{ asset('UI/css/Navbar.css')}}">
    @if(App::getLocale() == 'ar')
        <link rel="stylesheet" href="{{ asset('UI/css/ArabicStyle.css')}}">
    @endif

    <!--Google API SignIn Authitication and 2nd is youtube API-->
    <?php
        echo '<script src="https://accounts.google.com/gsi/client" async defer></script>';
        echo '<script src="https://www.youtube.com/iframe_api"></script>';
    ?>
    <script src="https://apis.google.com/js/platform.js" async defer></script>

</head>

<body class="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    @yield('Css')

        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-CD5EZ20T9R"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-CD5EZ20T9R');
        </script>

        {{-- Loader --}}
        <div id="loader-container">
            <div id="logo-container">
                <img src="{{asset('UI/imgs/Logos/LogoZhome.png')}}" alt="Zhome logo" id="logo">
            </div>
            <div id="loader" style="display:none;"></div>
        </div>

        @include('components.navbar')

        @yield('Content')

        @include('User.layout.footer')

    @yield('Js')

</body>
</html>
