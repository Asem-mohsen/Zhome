@extends('User.layout.master')

@section('Title', 'Shop')


@section('Content')

    <section>
        <div class="container-shop" id="shop-background">
            <div class="background-image" style="background-image: url({{ asset("UI/Imgs/website/Shop/AlexaImage2.jpg")}})"></div>
            <div class="content parent-home">
                <h1>{{ __('messages.ContentShop')}}</h1>
            </div>
        </div>
    </section>

    <!-- All Categories -->
    <section>
        <div class="container CatgeorySliderShop">
            <h1 id="ShopByCategory">{{ __('messages.Category')}}</h1>
            <div class="categories-shop customer-logos slider">
                @foreach($categories as $category)
                    <div class="category-shop slide">
                        <a href="{{route('Shop.Filter.category' , $category->ID)}}">
                            <img src="{{asset("Admin/dist/img/web/Categories/$category->MainImage")}}" alt="{{$category->Category}}">
                        </a>
                        <a href="">
                            @if(App::getLocale() == 'ar')
                                {{$category->ArabicName}}
                            @else
                                {{$category->Category}}
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="StartYourSystem-Shop">
        <div class="container">
            <h2 class="heading">{{ __('messages.BestProduct')}}</h2>
            <ul class="nav nav-tabs nav-primary" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#All" role="tab" aria-selected="false">
                            {{ __('messages.All')}}
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#Recommended" role="tab" aria-selected="true">
                            {{ __('messages.Recommendition')}}
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#MostPopular" role="tab" aria-selected="false">
                            {{ __('messages.MostPopular')}}
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#OnSale" role="tab" aria-selected="false">
                            {{ __('messages.OnSale')}}
                        </a>
                    </li>
                </ul>
            <div class="tab-content py-3">
                <!-- Recommended -->
                <div class="tab-pane fade show active" id="Recommended" role="tabpanel">
                        <div class="wrapper">
                            <div class="card">
                                <div class="card-body pl-0">
                                    <div class="related-product__carousel owl-carousel owl-theme">
                                        @foreach($categoriesProduct2 as $product)
                                            <div class="item">
                                                <x-user.product-card-user :variable="$product" :productID="$product->ID" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- All -->
                <div class="tab-pane fade" id="All" role="tabpanel">
                    <div class="wrapper">
                        <div class="card">
                            <div class="card-body pl-0">
                                <div class="related-product__carousel owl-carousel owl-theme">
                                    @foreach($categoriesProduct2 as $product)
                                        <div class="item">
                                            <x-user.product-card-user :variable="$product" :productID="$product->ID" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MostPopular -->
                <div class="tab-pane fade" id="MostPopular" role="tabpanel">
                    <div class="wrapper">
                        <div class="card" >
                            <div class="card-body pl-0">
                                <div class="related-product__carousel owl-carousel owl-theme">
                                    @foreach($categoriesProduct as $product)
                                        <div class="item">
                                            <x-user.product-card-user :variable="$product" :productID="$product->ID" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- On Sale -->
                <div class="tab-pane fade" id="OnSale" role="tabpanel">
                    <div class="wrapper">
                        <div class="card" >
                            <div class="card-body pl-0">
                                <div class="related-product__carousel owl-carousel owl-theme">
                                    @if($productsOnSale->isNotEmpty())
                                        @foreach($productsOnSale as $product)
                                            <div class="item">
                                                <x-user.product-card-user :variable="$product" :productID="$product->ID" />
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="Boxes">
        <!-- Select Bundles-->
        <div class="container">
            <div class="More-boxes">
                <div class="box box-1" style="background-image:url({{asset('UI/Imgs/website/Shop/Escritorio.jpg')}})">
                    <p>{{ __('messages.ExploreCollection')}}</p>
                    <a class="Button" href="{{route('Categories.index')}}">{{ __('messages.DiscoverMore')}}</a>
                </div>
                <div class="box hoverhere box-2" style="background-image:url({{asset('UI/Imgs/website/Shop/AlexaImage2.jpg')}})">
                    <div class="overlay-button" style="width: 85%;">
                        <div class="Info-bundle">
                            <h3>{{ucfirst(strtolower($bundle->Name))}}</h3>
                            <p>{{ucfirst(strtolower($bundle->brand->Brand))}}</p>
                        </div>
                        <a href="{{route('Product.show', $bundle->ID)}}">Read More</a>
                    </div>
                </div>
                <div class="box hoverhere box-3"  style="background-image:url({{asset('UI/Imgs/website/Shop/Escritorio.jpg')}})">
                    <div class="overlay-button" style="width: 85%;">
                        <div class="Info-bundle">
                            <h3>{{ucfirst(strtolower($bundle->Name))}}</h3>
                            <p>{{ucfirst(strtolower($bundle->brand->Brand))}}</p>
                        </div>
                        <a href="{{route('Product.show', $bundle->ID)}}">Read More</a>
                    </div>
                </div>
                <div class="box box-4"  style="background-image:url({{asset('UI/Imgs/website/Shop/LightZhome.jpg')}});flex: 0.6;">
                    <p>{{ __('messages.FindYourPerfect')}}</p>
                    <a class="Button" href="{{route('Tools.index')}}">{{ __('messages.GetYourDesignButton')}}</a>
                </div>
                <div class="box hoverhere box-5" style="background-image:url({{asset('UI/Imgs/website/Shop/james-mcdonald-74nIYjsOY88-unsplash.jpg')}})">
                    <div class="overlay-button" style="width: 85%;">
                        <div class="Info-bundle">
                            <h3>{{ucfirst(strtolower($bundle->Name))}}</h3>
                            <p>{{ucfirst(strtolower($bundle->brand->Brand))}}</p>
                        </div>
                        <a href="{{route('Product.show' , $bundle->ID)}}">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Promocode -->
    <section>
        <div class="container">
            @if($promocodes)
                {{-- Timer --}}
                <script>

                    // Function to update the countdown
                    var days =  {{$remainingDays}}
                    var hours = {{$remainingHours}}
                    var minutes = {{$remainingMinutes}}
                    var seconds =  {{$remainingSeconds}}
                    function updateCountdown() {

                        seconds--;
                            if (seconds < 0){
                                minutes--;
                                seconds = 59
                            }
                            if (minutes < 0){
                                hours--;
                                minutes = 59
                            }
                            if (hours < 0){
                                days--;
                                hours = 23
                            }

                            function pad(n) {
                                if ( n < 10 && n >= 0 ) {
                                    return "0" + n;
                                } else {
                                    return n;
                                }
                            }
                        // Update the countdown display
                        document.getElementById("Days").innerHTML =  pad(days) ;
                        document.getElementById("Hours").innerHTML = pad(hours) ;
                        document.getElementById("Minutes").innerHTML = pad(minutes) ;
                        document.getElementById("Seconds").innerHTML = pad(seconds) ;
                        // Update the countdown every second
                        setTimeout("updateCountdown()", 1000);
                    }

                </script>
                @php
                    // Calculate remaining time
                    $endDate = $promocodes->EndsIn;
                    $currentTime = time();
                    $remainingTime = strtotime($endDate) - $currentTime;

                    $remainingDays = floor($remainingTime / (60 * 60 * 24));
                    $remainingHours = floor(($remainingTime % (60 * 60 * 24)) / (60 * 60));
                    $remainingMinutes = floor(($remainingTime % (60 * 60)) / 60);
                    $remainingSeconds = $remainingTime % 60;
                @endphp
                <div class="promocode" style="background-image: url({{asset('UI/Imgs/website/Shop/pexels-eric-anada-1495580.jpg')}}">
                    <div class="promoInfo">
                        <h2>{{ __('messages.FreshSale')}}</h2>
                        <p>{{ __('messages.SaveUpTo')}} {{$promocodes->Save . "%"}} </p>
                        <h3>{{ __('messages.WithPromo')}}</h3><br>
                        <span>{{$promocodes->Promocode}}</span>
                    </div>
                    <div class="countdown" id="countdown">
                        <div class="num">
                            <span id="Days"></span>
                            <p>{{ __('messages.DaysSale')}}</p>
                        </div>
                        <div class="num">
                            <span id="Hours"></span>
                            <p>{{ __('messages.HoursSale')}}</p>
                        </div>
                        <div class="num" >
                            <span id="Minutes"></span>
                            <p>{{ __('messages.MinutesSale')}}</p>
                        </div>
                        <div class="num">
                            <span id="Seconds"></span>
                            <p>{{ __('messages.SecondsSale')}}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Products With Sale -->

    @if($productsOnSale->isNotEmpty())
        <section>
            <div class="container">
                <div class="Category-Product mt-5">
                    <h3></h3>
                    <a href="{{route('Shop.index')}}">{{ __('messages.DiscoverMore')}}<i class="fa fa-arrow-right"></i></a>
                </div>
                <div class="related-product__carousel owl-carousel owl-theme mt-3 mb-5">
                    @foreach($productsOnSale as $product)
                        <div class="item">
                            <x-user.product-card-user :variable="$product" :productID="$product->ID" />
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @else
        <div class='m-4'>
        </div>
    @endif

    <!-- Sub Categories of one category and thier product -->
    <section>
        <div class="container Category-selected-shop">

            <!-- Category and Sub of that Category -->
            <section>
                <div class="boxes-shop SubCategory-OnlineShop">
                    <div class="category-Name">
                        <h3>
                            @if(App::getLocale() == 'ar')
                                {{$category2->ArabicName}}
                            @else
                                {{$category2->Category}}
                            @endif
                            <br>
                            {{ __('messages.Category')}}
                        </h3>
                    </div>

                    @if($category2->subcategories->isNotEmpty())
                        <div class="Subs">
                            @foreach($category2->subcategories as $subcategory)
                                <a class="ToTheSubPage" href="{{route('Shop.Filter.subcategory' , $subcategory->ID)}}">
                                    <div class="box-shop SubCategory-OnlineShop-Circled" style="background-image: url({{asset("Admin/dist/img/web/Categories/SubCategory/$subcategory->image")}})">
                                    </div>
                                    <p>
                                        @if(App::getLocale() == 'ar')
                                            {{$subcategory->SubArabicName}}
                                        @else
                                            {{$subcategory->SubName}}
                                        @endif
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <!-- Product From The Selected Category -->
            <section>
                <div class="Category-Product">
                    <a href="{{route('Shop.Filter.category' , $category2->ID)}}">{{ __('messages.DiscoverMore')}}<i class="fa fa-arrow-right"></i></a>
                </div>
                <div class="related-product__carousel owl-carousel owl-theme mt-5 mb-5 pb-3">
                    @foreach($categoriesProduct as $product)
                        <div class="item">
                            <x-user.product-card-user :variable="$product" :productID="$product->ID" />
                        </div>
                    @endforeach
                </div>
            </section>
            
        </div>
    </section>

    <!-- Bundles -->
    <section>
        <div class="container">
            <!-- Select Bundles -->
            <h2 class="Home-Text">
                {{ __('messages.BundlesMadeforYou')}}
            </h2>
            <div class="Bundles Images-Home">
                @foreach ($bundles as $bundle )
                    <div class="Bundle-Shop Image-One">
                        <img src="{{asset("Admin/dist/img/web/Products/MainImage/$bundle->MainImage")}}" class="BigWidth" alt="{{$bundle->Name}}">
                        <div class="overlay-button" style="width: 250px;">
                            <div class="Info-bundle">
                                <h3>
                                    @if(App::getLocale() == 'ar')
                                        {{$bundle->ArabicName}}
                                    @else
                                        {{$bundle->Name}}
                                    @endif
                                </h3>
                                <p>{{$bundle->brand->Brand}}</p>
                            </div>
                            <a href="{{route('Product.show' , $bundle->ID)}}" class="btn btn-info">Read More</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sub Categories of one category and thier product -->
    <section>
        <div class="container Category-selected-shop">
            <!-- Category and Sub of that Category -->
            <section>
                <div class="boxes-shop SubCategory-OnlineShop">
                    <div class="category-Name">
                        <h3>
                            @if(App::getLocale() == 'ar')
                                {{$category->ArabicName}}
                            @else
                                {{$category->Category}}
                            @endif
                            <br>
                            {{ __('messages.Category')}}
                        </h3>
                    </div>
                    @if($category->subcategories->isNotEmpty())
                        <div class="Subs">
                            @foreach($category->subcategories as $subcategory)

                                <a class="ToTheSubPage" href="{{route('Shop.Filter.subcategory' , $subcategory->ID)}}">
                                    <div class="box-shop SubCategory-OnlineShop-Circled" style="background-image: url({{asset("Admin/dist/img/web/Categories/SubCategory/$subcategory->Image")}})">
                                    </div>
                                    <p>
                                        @if(App::getLocale() == 'ar')
                                            {{$subcategory->SubArabicName}}
                                        @else
                                            {{$subcategory->SubName}}
                                        @endif
                                    </p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <!-- Product From The Selected Category -->
            <section>
                <div class="Category-Product">
                    <a href="{{route('Shop.Filter.category' , $category->ID)}}">{{ __('messages.DiscoverMore')}}<i class="fa fa-arrow-right"></i></a>
                </div>
                <div class="related-product__carousel owl-carousel owl-theme mt-5 mb-5 pb-3">
                    @foreach($categoriesProduct as $product)
                        <div class="item">
                            <a href="{{ route('Product.show', $product->ID) }}">
                                <x-user.product-card-user :variable="$product" :productID="$product->ID" />
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </section>

    <!-- Fixed attach for bundles -->
    <section>
        <div class="Fixed-bundle item slider-one__slider-1" style="background-image: url({{asset('UI/Imgs/website/Shop/bence-boros-anapPhJFRhM-unsplash.jpg')}})">
            <div class="bottom-slider">
                <a href="{{route('Shop.FilterIndex')}}" class="thm-btn slider-one__btn">{{ __('messages.ExploreBundles')}}</a>
                <h2 class="slider-one__title">
                    {{ __('messages.PackagesAndBundles')}}
                    <br/>
                    {{ __('messages.Matches')}}
                </h2>
            </div>
        </div>
    </section>

    <!-- one Brand and thier product-->
    <section>
        <div class="container mt-5 pt-3">
            <!-- Product From The Selected Brand -->
            <section>
                <div class="Category-Product mt-4 justify-content-between">
                    <h3>{{$brand->Brand . " Products"}} </h3>
                    <a href="{{route('Shop.Filter.brand' , $brand->ID)}}">{{ __('messages.DiscoverMore')}}<i class="fa fa-arrow-right"></i></a>
                </div>
                <div class="related-product__carousel owl-carousel owl-theme mt-5 mb-5">
                    @foreach($productsBrand as $product)
                        <div class="item">
                            <a href="{{ route('Product.show', $product->ID) }}">
                                <x-user.product-card-user :variable="$product" :productID="$product->ID" />
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </section>

    <!-- Tool -->
    <section>
        <div class="container">
            <div class="Cards-contact mt-5 pt-4">
                <div class="card-contact-left align-items-center">
                    <a href="{{route('Tools.index')}}">
                        <img src="{{asset('UI/Imgs/website/Shop/r-architecture-T6d96Qrb5MY-unsplash2.png')}}" class="ProposalProduct" alt="Design Your Home">
                    </a>
                    <div class="ToolOnlineShop">
                        <h3>{{ __('messages.ToolOnlineShop')}}</h3>
                        <div>
                            <a href="{{route('Tools.index')}}" class="cta ShopNowButton" id="BuildHomeCta">
                                <svg xmlns="http://www.w3.org/2000/svg" id="HomeIcon" height="15" width="17" viewBox="0 0 576 512">
                                    <path transform="translate(30)"  id="Path_10" d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/></path>
                                </svg>
                                <span class="hover-underline-animation">{{ __('messages.BuildYourHomeButton')}}</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="mt-5 pt-2">
        <div class="customer-logos shop-slider-brands slider">
            @foreach($brands as $brand)
                <div class="slide Brand">
                    <img src="{{asset("Admin/dist/img/web/Brands/$brand->Logo")}}" alt="{{$brand->Brand}}">
                </div>
            @endforeach
        </div>
    </section>

@endsection


@section('Js')
    <script>
        $(document).ready(function() {
            $('.card-slider').slick({
                dots: false,
                arrows: true,
                slidesToShow: 5,
                infinite: true,
                responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                    slidesToShow: 3
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                    slidesToShow: 2
                    }
                },
                {
                    breakpoint: 600,
                settings: {
                slidesToShow: 1
                }
            }
            ]
        });
        });
    </script>

    <!-- Logo Brands Slider -->
    <script>
        $(document).ready(function(){
            $('.customer-logos').slick({
                slidesToShow: 6,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 1500,
                arrows: false,
                dots: false,
                pauseOnHover: false,
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 4
                    }
                }, {
                    breakpoint: 520,
                    settings: {
                        slidesToShow: 3
                    }
                }]
            });
        });
    </script>
@stop
