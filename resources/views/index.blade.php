@extends('User.layout.master')
@section('Title' , 'Zhome')

@section('Content')
<!-- Welcome  -->
<section class="slider-one">
    <style>
        #ToolButton {
            display:none;
        }
    </style>

    <div id="index-background" style="background-image: url({{asset('UI/Imgs/website/Home/Sliders/AlexaBlueGround.jpg')}});">
        <div class="parent-home">
            <p id="Welcome">{{ __('en.Welcome')}}</p>
            <h1>{{ __('en.Zhome')}}</h1>
            <p id="welcome-text">{{ __('en.SliderTextTwo')}}</p>
            
            <div class="parent-buttons">
                <a href="{{route('Tools.index')}}" class="DesignButton">{{ __('en.Design')}}</a>
                <hr>
                <a href="{{route('Shop.index')}}"  class="ShopButton">{{ __('en.ShopNowButton')}}</a>
            </div>
        </div>
        
    </div>
</section>

<!-- Text -->
<section>
    <div class="container">
        <h2 class="Home-Text">
            {{ __('en.ToolTextBelowSlider')}}
        </h2>
        <div class="Images-Home">
            <div class="Image-One">
                <img src="{{asset('UI/Imgs/website/Home/Sliders/r-architecture-rOk4VSMS3Ck-unsplash.jpg')}}" alt="Zhome Design">
                <div class="overlay-button">
                    <a href="{{route('Tools.index')}}" class="HomeImageInButton">
                        <div class="d-grid text-center g-1">
                            <i class="fa-solid fa-house"></i>
                            <p class="text-white">{{ __('en.GetYourDesignButton')}}</p>
                        </div>
                     </a>
                </div>
            </div>
            <div class="Image-Two">
                <img src="{{asset('UI/Imgs/website/Home/Sliders/james-mcdonald-74nIYjsOY88-unsplash.jpg')}}" alt="Zhome Design">
                <div class="overlay-button-two">
                    <a href="{{route('Tools.index')}}" class="HomeImageInButton">
                         <div class="d-grid text-center g-1">
                            <i class="fa-solid fa-house"></i>
                            <p class="text-white">{{ __('en.GetYourDesignButton')}}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="Text-under-images">
            <div class="text-one">
                <h3>{{ __('en.DesignOnline')}}</h3>
                <p>
                    {{ __('en.DesignOnlineText')}}
                </p>
            </div>
            <div class="text-one">
                <h3>{{ __('en.PersonalAdvice')}}</h3>
                <p>
                    {{ __('en.PersonalAdviceText')}}
                </p>
            </div>
            <div class="text-one">
                <h3>{{ __('en.ProfessionalInstallation')}}</h3>
                <p>
                    {{ __('en.ProfessionalInstallationText')}}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Brands -->
<section style="margin-top: 83px;">
    <div class="customer-logos slider">
        @foreach ($brands as $brand )
            <div class="slide Brand">
                <img src="{{asset("Admin/dist/img/web/Brands/$brand->Logo")}}" alt="{{$brand->Brand}}">
            </div>
        @endforeach
    </div>
</section>

<!-- Start Your System -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<section id="StartYourSystem">
    <div class="container">
        <h2 class="heading">{{ __('en.StartYourOwnSystem')}}</h2>
            <ul class="nav nav-tabs nav-primary" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#Recommended" role="tab" aria-selected="true">
                        {{ __('en.Recommendition')}}
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#BestSelling" role="tab" aria-selected="false">
                        {{ __('en.BestSelling')}}
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#OnSale" role="tab" aria-selected="false">
                        {{ __('en.OnSale')}}
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#Bundles" role="tab" aria-selected="false">
                        {{ __('en.Bundles')}}
                    </a>
                </li>
            </ul>
        <div class="tab-content py-3">
            <!-- Recommended -->
            <div class="tab-pane fade show active" id="Recommended" role="tabpanel">
                    <div class="wrapper">
                        <div class="card" style="height: 469px;">
                            <div class="card-body" style="padding-left: 0;">
                                <div class="Box-Sizes">
                                    <div class="small-size box-1" style="background-image: url(https://zhome.com.eg/Admin/Images/darryl-low-uqk9RAzm6lk-unsplash.jpg);">
                                        <a>Daley low</a>
                                    </div>
                                    <div class="small-size box-2" style="background-image: url(https://zhome.com.eg/Admin/Images/sebastian-scholz-nuki-Fh3Dtg6QX4Q-unsplash.jpg);">
                                        <a>Daley low</a>
                                    </div>
                                    <div class="small-size box-3" style="background-image: url(https://zhome.com.eg/Admin/Images/SmartOutlet.jpg);">
                                        <a>Daley low</a>
                                    </div>
                                    <div class="small-size box-4" style="background-image: url(https://zhome.com.eg/Admin/Images/SmartSwitch.jpg);">
                                        <a>Daley low</a>
                                    </div>
                                    <div class="small-size box-5" style="background-image: url(https://zhome.com.eg/Admin/Images/darryl-low-uqk9RAzm6lk-unsplash.jpg);">
                                        <a>Daley low</a>
                                    </div>

                                </div>
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide small-size" style="background-image: url(https://zhome.com.eg/Admin/Images/sebastian-scholz-nuki-Fh3Dtg6QX4Q-unsplash.jpg);">
                                            <a>Daley low</a>
                                        </div>
                                        <div class="swiper-slide small-size" style="background-image: url(https://zhome.com.eg/Admin/Images/SmartOutlet.jpg);">
                                            <a>Daley low</a>
                                        </div>
                                        <div class="swiper-slide small-size" style="background-image: url(https://zhome.com.eg/Admin/Images/SmartSwitch.jpg);">
                                            <a>Daley low</a>
                                        </div>
                                        <div class="swiper-slide small-size" style="background-image: url(https://zhome.com.eg/Admin/Images/darryl-low-uqk9RAzm6lk-unsplash.jpg);">
                                            <a>Daley low</a>
                                        </div>
                                    </div>
                                    <!-- Add Pagination -->
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Best Selling -->
            <div class="tab-pane fade" id="BestSelling" role="tabpanel">
                <div class="wrapper">
                    <div class="card" style="height: 469px;">
                        <div class="card-body" style="padding-left: 0;">
                            <div class="Box-Sizes">
                                <div class="Big-size box-1" style="background-image: url(https://zhome.com.eg/Admin/Images/darryl-low-uqk9RAzm6lk-unsplash.jpg);">
                                    <a>Daley low</a>
                                </div>
                                <div class="small-size box-2" style="background-image: url(https://zhome.com.eg/Admin/Images/sebastian-scholz-nuki-Fh3Dtg6QX4Q-unsplash.jpg);">
                                    <a>Daley low</a>
                                </div>
                                <div class="small-size box-3" style="background-image: url(https://zhome.com.eg/Admin/Images/SmartOutlet.jpg);">
                                    <a>Daley low</a>
                                </div>
                                <div class="small-size box-4" style="background-image: url(https://zhome.com.eg/Admin/Images/SmartSwitch.jpg);">
                                    <a>Daley low</a>
                                </div>
                                <div class="small-size box-5" style="background-image: url(https://zhome.com.eg/Admin/Images/darryl-low-uqk9RAzm6lk-unsplash.jpg);">
                                    <a>Daley low</a>
                                </div>
                            </div>
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide small-size" style="background-image: url(https://zhome.com.eg/Admin/Images/sebastian-scholz-nuki-Fh3Dtg6QX4Q-unsplash.jpg);">
                                        <a>Daley low</a>
                                    </div>
                                    <div class="swiper-slide small-size" style="background-image: url(https://zhome.com.eg/Admin/Images/SmartOutlet.jpg);">
                                        <a>Daley low</a>
                                    </div>
                                    <div class="swiper-slide small-size" style="background-image: url(https://zhome.com.eg/Admin/Images/SmartSwitch.jpg);">
                                        <a>Daley low</a>
                                    </div>
                                    <div class="swiper-slide small-size" style="background-image: url(https://zhome.com.eg/Admin/Images/darryl-low-uqk9RAzm6lk-unsplash.jpg);">
                                        <a>Daley low</a>
                                    </div>
                                </div>
                                <!-- Add Pagination -->
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- On Sale -->
            <div class="tab-pane fade" id="OnSale" role="tabpanel">
                <div class="wrapper">
                    <div class="card" style="height: 469px;">
                        <div class="card-body" style="padding-left: 0;">
                            <div class="Box-Sizes">
                                    @if($products->isNotEmpty())
                                        @php $number = 1 @endphp
                                        @foreach($products as $saleProduct)
                                            <div class="Big-size box-{{ $number++ }}" style="background-image: url({{asset("Admin/dist/img/web/Products/MainImage/$saleProduct->MainImage")}});">
                                                <a>{{ $saleProduct->Name }}</a>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @if($products->isNotEmpty())
                                        @php $number = 1 @endphp
                                        @foreach($products as $saleProduct)
                                            <div class="Big-size box-{{ $number++ }}" style="background-image: url({{asset("Admin/dist/img/web/Products/MainImage/$saleProduct->MainImage")}});">
                                                <a>{{ $saleProduct->Name }}</a>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <!-- Add Pagination -->
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bundles -->
            <div class="tab-pane fade" id="Bundles" role="tabpanel">
                <div class="wrapper">
                    <div class="card" style="height: 469px;">
                        <div class="card-body" style="padding-left: 0;">
                            <div class="Box-Sizes">
                                <div class="Big-size box-1" style="background-image: url(https://zhome.com.eg/Admin/Images/darryl-low-uqk9RAzm6lk-unsplash.jpg);">
                                    <a>Daley low</a>
                                </div>
                                <div class="small-size box-2" style="background-image: url(https://zhome.com.eg/Admin/Images/sebastian-scholz-nuki-Fh3Dtg6QX4Q-unsplash.jpg);">
                                    <a>Daley low</a>
                                </div>
                                <div class="small-size box-3" style="background-image: url(https://zhome.com.eg/Admin/Images/SmartOutlet.jpg);">
                                    <a>Daley low</a>
                                </div>
                                <div class="small-size box-4" style="background-image: url(https://zhome.com.eg/Admin/Images/SmartSwitch.jpg);">
                                    <a>Daley low</a>
                                </div>
                                <div class="small-size box-5" style="background-image: url(https://zhome.com.eg/Admin/Images/darryl-low-uqk9RAzm6lk-unsplash.jpg);">
                                    <a>Daley low</a>
                                </div>
                            </div>
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide small-size" style="background-image: url(https://zhome.com.eg/Admin/Images/sebastian-scholz-nuki-Fh3Dtg6QX4Q-unsplash.jpg);">
                                        <a>Daley low</a>
                                    </div>
                                    <div class="swiper-slide small-size" style="background-image: url(https://zhome.com.eg/Admin/Images/SmartOutlet.jpg);">
                                        <a>Daley low</a>
                                    </div>
                                    <div class="swiper-slide small-size" style="background-image: url(https://zhome.com.eg/Admin/Images/SmartSwitch.jpg);">
                                        <a>Daley low</a>
                                    </div>
                                    <div class="swiper-slide small-size" style="background-image: url(https://zhome.com.eg/Admin/Images/darryl-low-uqk9RAzm6lk-unsplash.jpg);">
                                        <a>Daley low</a>
                                    </div>
                                </div>
                                <!-- Add Pagination -->
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{route('Shop.index')}}"class="cta ShopNowButton">
                <span class="hover-underline-animation">{{ __('en.ShopNowButton')}}</span>
                <svg viewBox="0 0 46 16" height="10" width="30" xmlns="http://www.w3.org/2000/svg" id="arrow-horizontal">
                    <path transform="translate(30)" d="M8,0,6.545,1.455l5.506,5.506H-30V9.039H12.052L6.545,14.545,8,16l8-8Z" data-name="Path 10" id="Path_10"></path>
                </svg>
            </a>
        </div>
        
    </div>
</section>

<!-- testmonials -->
<section class="testmonials">
    <h2>{{ __('en.Testmonials')}}</h2>
    <div class="tests">
        <div class="testmo active" data-id="content1">
            <img src="{{asset('UI/Imgs/website/Home/testmonials/algeria.jpeg')}}" alt="Alegria testmonials">
            <div>
                <h3>Alaa Abdelghafar</h3>
                <p>Allegria Sodic compound</p>
            </div>
            <div class="gradient"></div>
        </div>
        <div class="testmo" data-id="content2">
            <img src="{{asset('UI/Imgs/website/Home/testmonials/Mivida-logo.png')}}" alt="Mivida testmonials">
            <div>
                <h3>Sherif Youssef</h3>
                <p>Mivida</p>
            </div>
            <div class="gradient"></div>
        </div>
        <div class="testmo" data-id="content3">
            <img src="{{asset('UI/Imgs/website/Home/testmonials/mountain.png')}}" alt="mountain view testmonials">
            <div>
                <h3>Osama Elsayed</h3>
                <p>Mountain View Hyde Park</p>
            </div>
            <div class="gradient"></div>
        </div>
    </div>
    <div class="content">
        <div class="contentBox active" id="content1">
        <div class="text">
            <h2>{{ __('en.AlaaAbdelghafar')}}</h2>
            <span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
            </span>
            <p> {{ __('en.AlaaAbdelghafarOpinion')}}</p>
            <p></p>
        </div>
        </div>
        <div class="contentBox" id="content2">
        <div class="text">
            <h2>{{ __('en.SherifYoussef')}}</h2>
            <span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
            </span>

            <p> {{ __('en.SherifYoussefOpenion')}} </p>
        </div>
        </div>
        <div class="contentBox" id="content3">
        <div class="text">
            <h2>
              {{ __('en.OsamaElsayed')}}</h2>
            <span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
            </span>
            <p>  {{ __('en.OsamaElsayedOpenion')}}</p>
            <p></p>
        </div>
        </div>
    </div>
</section>
<script>
    let card = document.querySelectorAll(".testmo");
    let contentBox = document.querySelectorAll(".contentBox");

    for (let i = 0; i < card.length; i++) {
        card[i].addEventListener("mouseover", function () {
            for (let i = 0; i < contentBox.length; i++) {
            contentBox[i].className = "contentBox";
            }
            document.getElementById(this.dataset.id).className = "contentBox active";

            for (let i = 0; i < card.length; i++) {
            card[i].className = "testmo";
            }
            this.className = "testmo active";
        });
    }
</script>

<!-- Control You Home -->
<style>
    @media (min-width: 1200px){
        .container.ControlHomeCont {
            max-width: 1140px;
        }
    }
</style>
<section>
    <div class="container ControlHomeCont">
        <div class="ControlHome HomeSmallNone">
            <h2> {{ __('en.ControlYourHome')}}</h2>
            <img src="{{asset('UI/Imgs/website/Home/control-home/Exterior-II-scaled.jpg')}}" class="MainImage" alt="Zhome Energy">
            <div class="svg svg1">
                <p class="text-block">
                    <b>{{ __('en.ControlHomeEnergy')}}</b> <br>
                    {{ __('en.ControlHomeEnergyText')}}
                </p>
                <img src="{{asset('UI/Imgs/website/Home/control-home/eco-solar-panel-svgrepo-com.svg')}}" class="SvgIcon" alt="Zhome Alarm">
            </div>
            <div class="svg svg2">
                <p class="text-block">
                    <b>{{ __('en.ControlHomeAlarm')}}</b> <br>
                    {{ __('en.ControlHomeAlarmText')}}
                </p>
                <img src="{{asset('UI/Imgs/website/Home/control-home/ring-svgrepo-com.svg')}}" class="SvgIcon" alt="Zhome Alarm">
            </div>
            <div class="svg svg3">
                <p class="text-block">
                    <b>{{ __('en.ControlHomeLight')}}</b> <br>
                    {{ __('en.ControlHomeLightText')}}
                </p>
                <img src="{{asset('UI/Imgs/website/Home/control-home/light-bulb-13-svgrepo-com.svg')}}" class="SvgIcon" alt="Zhome Light system">
            </div>
            <div class="svg svg4">
                <p class="text-block">
                    <b>{{ __('en.ControlHomeSound')}}</b> <br>
                    {{ __('en.ControlHomeSoundText')}}
                </p>
                <img src="{{asset('UI/Imgs/website/Home/control-home/sound-system-with-big-speakers-svgrepo-com.svg')}}" class="SvgIcon" alt="Zhome Sound System">
            </div>
            <div class="svg svg5">
                <p class="text-block">
                    <b> {{ __('en.ControlHomeGarage')}}</b> <br>
                       {{ __('en.ControlHomeGarageText')}}
                </p>
                <img src="{{asset('UI/Imgs/website/Home/control-home/garage-svgrepo-com.svg')}}" class="SvgIcon" alt="Zhome Garage">
            </div>
            <div class="svg svg6">
                <p class="text-block">
                    <b>{{ __('en.ControlHomeLock')}}</b> <br>
                    {{ __('en.ControlHomeLockText')}}
                </p>
                <img src="{{asset('UI/Imgs/website/Home/control-home/lock-open-svgrepo-com.svg')}}" class="SvgIcon" alt="Zhome Lock system">
            </div>
            <div class="svg svg7">
                <p class="text-block">
                    <b>{{ __('en.ControlHomeBattery')}}</b> <br>
                    {{ __('en.ControlHomeBatteryText')}}
                </p>
                <img src="{{asset('UI/Imgs/website/Home/control-home/battery-charging-svgrepo-com.svg')}}" class="SvgIcon" alt="Zhome Battery system">
            </div>
            <div class="svg svg8">
                <p class="text-block">
                    <b>{{ __('en.ControlHomeAC')}}</b> <br>
                    {{ __('en.ControlHomeACText')}}
                </p>
                <img src="{{asset('UI/Imgs/website/Home/control-home/air-conditioner-svgrepo-com.svg')}}" class="SvgIcon" alt="Zhome AC System">
            </div>
            <div class="svg svg9">
                <p class="text-block">
                    <b>{{ __('en.ControlHomeCamera')}}</b> <br>
                    {{ __('en.ControlHomeCameraText')}}
                </p>
                <img src="{{asset('UI/Imgs/website/Home/control-home/camera-svgrepo-com.svg')}}" class="SvgIcon"  alt="Zhome Camera system">
            </div>
            <div class="svg svg10">
                <p class="text-block">
                    <b>{{ __('en.ControlHomeElectricity')}}</b> <br>
                   {{ __('en.ControlHomeElectricityText')}}
                </p>
                <img src="{{asset('UI/Imgs/website/Home/control-home/electricity-socket-circle-svgrepo-com.svg')}}" class="SvgIcon" alt="Zhome Electricity system">
            </div>
            <div class="svg svg11">
                <p class="text-block">
                    <b>{{ __('en.ControlHomeShutter')}}</b> <br>
                    {{ __('en.ControlHomeShutterText')}}
                </p>
                <img src="{{asset('UI/Imgs/website/Home/control-home/window-blind-svgrepo-com.svg')}}" class="SvgIcon" alt="Zhome ShutterT system">
            </div>
            <div class="svg svg12">
                <p class="text-block">
                    <b>{{ __('en.ControlHomeIrrigation')}}</b> <br>
                    {{ __('en.ControlHomeIrrigationText')}}
                </p>
                <img src="{{asset('UI/Imgs/website/Home/control-home/irrigation-svgrepo-com.svg')}}" class="SvgIcon" alt="Zhome Irrigation system">
            </div>
            <div class="svg svg13">
                <p class="text-block">
                    <b> {{ __('en.ControlHomeElectrical')}}</b> <br>
                    {{ __('en.ControlHomeElectricalText')}}
                </p>
                <img src="{{asset('UI/Imgs/website/Home/control-home/gardening-grass-svgrepo-com.svg')}}" class="SvgIcon" alt="Zhome Electrical Cleaner">
            </div>
        </div>
    </div>
</section>

<!-- Why Zhome -->
<section class="WhyZhomeSection">
    <div class="Why">
        <div class="Features">
            <img src="{{asset('UI/Imgs/website/Home/About/customer.jpg')}}" alt="Cutomer Service">
            <div class="Info">
                <h4>{{ __('en.FunctionsExpertOne')}}</h4>
                <p>
                    {{ __('en.FunctionsExpertOneText')}}
                </p>
            </div>
        </div>
        <div class="Features">
            <img src="{{asset('UI/Imgs/website/Home/About/medal-quality-svgrepo-com.svg')}}" alt="Guarantee">
            <div class="Info">
                <h4>{{ __('en.FunctionsGuaranteeTwo')}}</h4>
                <p>{{ __('en.FunctionsGuaranteeTwoText')}}</p>
            </div>
        </div>
        <div class="Features">
            <img src="{{asset('UI/Imgs/website/Home/About/verified-svgrepo-com.svg')}}" alt="Main Source">
            <div class="Info">
                <h4>{{ __('en.FunctionsSourceThree')}}</h4>
                <p style="max-height: 79px;">
                    {{ __('en.FunctionsSourceThreeText')}}
                </p>
            </div>
        </div>
        <div class="Features">
            <img src="{{asset('UI/Imgs/website/Home/About/shipping-fast-solid-svgrepo-com.svg')}}" alt="Free Shipping">
            <div class="Info">
                <h4>{{ __('en.FunctionsShippingFour')}}</h4>
                <p>
                    {{ __('en.FunctionsShippingFourText')}}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Tool and Shop -->
<section>
    <div class="container">
        <div class="Build">
            <div class="Products-home" style="background-image:url({{asset('UI/Imgs/website/Home/About/bence-boros-anapPhJFRhM-unsplash-3.png')}}">
                <h3 style="color: black;font-weight: bold;">
                    {{ __('en.ShopTextHome')}}
                </h3>
                <a href="{{route('Shop.index')}}" class="buttonBlack">{{ __('en.FunctionsShippingFourText')}}</a>
            </div>
            <div class="Products-home" style="background-image:url({{asset('UI/Imgs/website/Home/About/pexels-andrew-neel-2312369-3.png')}}">
                <h3>
                    {{ __('en.ToolTextHome')}}

                </h3>
                <a href="{{route('Tools.index')}}"> {{ __('en.DiscoverOurToolButton')}}</a>
            </div>
        </div>
    </div>
</section>

<!-- Compitability -->
<section>
    <div class="container">
        <!-- Platforms -->
        <div class="Platfroms">
            <h3>{{ __('en.ZhomeCompability')}}</h3>
            @foreach($platforms as $platform)
                <div class="Platform-home">
                    <img src="{{asset("Admin/dist/img/web/Platforms/$platform->Logo")}}" alt="{{$platform->Platform}}">
                    <a href="{{route('Platforms.index' , $platform->Platform)}}">{{$platform->Platform}}</a>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection


@section('Js')

<script>
    $(document).ready(function() {
    // Add click event for the navigation tabs
        $('.nav-tabs li a').click(function(e) {
            e.preventDefault();
            var targetDiv = $(this).attr('href');
            $('.nav-tabs li a').removeClass('active');
            $('div').removeClass('show active');
            $(this).addClass('active');
            $(targetDiv).addClass('show active');
        });
    });

    $(document).ready(function() {
        $('.svg').hover(
            function() {
            $(this).find('.text-block').css('display', 'block');
            },
            function() {
            $(this).find('.text-block').css('display', 'none');
            }
        );
    });
</script>
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
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 'auto',
        spaceBetween: 10,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    });
</script>
<script>
    updateCartCount();
</script>

@stop