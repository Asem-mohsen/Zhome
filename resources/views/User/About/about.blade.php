@extends('User.layout.master')
@section('Title' , 'About')

@section('Content')

<section class="shop-background site-banner jarallax padding-large" style="background: url({{asset('UI/Imgs/website/Home/About/contactusbackgorund.webp')}}); no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title text-white">{{ __('messages.Zhome')}}</h1>
                <div class="breadcrumbs">
                <span class="item">
                    <a href="{{route('index')}}" class="text-white" >{{ __('messages.Home')}} /</a>
                </span>
                <span class="item text-white" >{{ __('messages.AboutUs')}}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About -->
<section>
    <div class="container">
        <div class="block-title text-center">
            <p class="block-title__tag-line">{{ __('messages.AboutUs')}}</p>
            <h2 class="block-title__title">
                {{ __('messages.TheFirstEgyptian')}} </br>
                {{ __('messages.SmartHomeMarketplace')}}
            </h2>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="about-three__content">
                    <h3 class="about-three__content-title">{{ __('messages.Established')}} 2019</h3>
                    <p class="about-three__content-text">
                    <a href="{{route('Contact.contact')}}" style="color: #154352;">{{ __('messages.Zhome')}} </a>
                        {{ __('messages.WhyZhomeText')}}
                        </br></br>
                        <a href="{{route('Contact.contact')}}" style="color: #154352;">{{ __('messages.Zhome')}} </a> {{ __('messages.WhyZhomeText2')}} 
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Counter -->
<section class="funfact-one">
    <div class="container">
    <div class="row" style="justify-content: center;">
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1500ms"  data-wow-delay="0ms">
        <div class="funfact-one__single">
            <div class="funfact-one__icon">
            <i class="egypt-icon-art-museum"></i>
            </div>
            <div class="funfact-one__content">
            <div class="funfact-one__count">
                <span class="counter">500</span>
            </div>
            <div class="funfact-one__text">
                <span class="text-uppercase">{{ __('messages.Product')}}</span>
            </div>
            </div>
        </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="100ms">
        <div class="funfact-one__single">
            <div class="funfact-one__icon">
            <i class="egypt-icon-smile"></i>
            </div>
            <div class="funfact-one__content">
            <div class="funfact-one__count">
                <span class="counter">2</span>
                
            </div>
            <div class="funfact-one__text">
                <span class="text-uppercase">{{ __('messages.Markets')}}</span>
            </div>
            </div>
        </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="200ms">
            <div class="funfact-one__single">
                <div class="funfact-one__icon">
                    <i class="egypt-icon-medal"></i>
                </div>
                <div class="funfact-one__content">
                    <div class="funfact-one__count">
                        <span class="counter">400</span>k
                    </div>
                    <div class="funfact-one__text">
                        <span class="text-uppercase">{{ __('messages.Users')}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="300ms">
            <div class="funfact-one__single">
                <div class="funfact-one__icon">
                <i class="egypt-icon-jar"></i>
                </div>
                <div class="funfact-one__content">
                <div class="funfact-one__count">
                    <span class="counter">2500</span>
                    
                </div>
                <div class="funfact-one__text">
                    <span class="text-uppercase">{{ __('messages.Orders')}}</span>
                    
                </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- Why zhome -->
<section>
    <div class="container">
        <div class="block-title text-center">
            <p class="block-title__tag-line text-center">{{ __('messages.Why')}}</p>
            <h2 style="text-align: center;">{{ __('messages.Zhome')}}</h2>
        </div>
        <div class="Cards-contact">
            <div class="card-contact-left">
                <img src="{{asset('UI/Imgs/website/Home/About/sebastian-scholz-nuki-Fh3Dtg6QX4Q-unsplash3.png')}}" alt="">
                <div>
                    <h3>{{ __('messages.BestCustomized')}}</h3>
                    <p>
                        {{ __('messages.BestCustomizedText')}}
                    </p>
                </div>
            </div>
            <div class="card-contact-left">
                <div>
                    <h3>{{ __('messages.InstallationAndDesigning')}}</h3>
                    <p>
                        {{ __('messages.InstallationAndDesigningText')}}
                    </p>
                </div>
                <img src="{{asset('UI/Imgs/website/Home/About/Entertainment.jpg')}}" alt="Entertainments ">
            </div>
            <div class="card-contact-left">
                <img src="{{asset('UI/Imgs/website/Home/About/smart-security.jpg')}}" alt="smart-security">
                <div>
                    <h3>{{ __('messages.SmartProducts')}}</h3>
                    <p>
                        {{ __('messages.SmartProductsText')}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map -->
<div class="contact-map-one" id="map">
    <div class="container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3456.490986993673!2d31.325215774340798!3d29.965316574963495!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1458392bdbce2669%3A0xae3fdbc2258f3e74!2sZHome!5e0!3m2!1sen!2seg!4v1695458349636!5m2!1sen!2seg" class="google-map__home" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>

@endsection

@section('Js')

    <script>
        updateCartCount();
    </script>

@stop