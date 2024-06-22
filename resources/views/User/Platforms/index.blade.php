@extends('User.layout.master')
@section('Title' , 'Platforms')


@section('Content')

    @section('Css')
        <style>
            .slider-OnlineShop .owl-carousel .owl-stage-outer {
            border-radius: 0;
            }
            .platform{
                width: 271px;
                padding: 8px;
                gap: 10px;
            }
            @media (max-width: 767px) {
                .PlatformSection .PlatformTop {
                    display: block !important; 
                }
                .owl-carousel .owl-item {
                    width: 225px !important;
                }
                iframe.PlatformVideo {
                    width: auto;
                }
                .PlatformSection .PlatformInfo {
                    grid-template-columns: auto;
                }
                .Category-Product {
                    display: grid;
                    text-align: center;
                    justify-content: center;
                }
            }
            section.SectionNumber:nth-child(even) {
                    background-color: aliceblue;
            }

            button[data-toggle="collapse"] .fa:before {  
                content: "";
            }

            button[data-toggle="collapse"].collapsed .fa:before {
                content: "";
            }
        </style>
    @endsection

    <section>
        <div class="container mt-3 mb-4">
            <div class="block-title text-center">
                <p class="block-title__tag-line text-center">{{ __('messages.Zhome')}}</p>
                <h1 class="text-center">{{ __('messages.Platforms')}}</h1>
            </div>
        </div>
    </section>

    <!-- Slider for Platforms -->
    <section class="mt-5">
        <div class="notSilder">
            @if($platforms->isNotEmpty())
                @foreach ( $platforms as $platform )
                    <a href="#{{$platform->Platform}}">
                        <div class="slide platform">
                            <img src="{{asset("Admin/dist/img/web/Platforms/$platform->Logo")}}" alt="{{$platform->Platform}}">
                            <p>{{$platform->Platform}}</p>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </section>

    <!-- Platforms -->
    @php
        $i = 1;
    @endphp
    @foreach($platforms as $platform)
        <section class="SectionNumber" id="{{$platform->Platform}}">
            <div class="PlatformSection">
                <div class="PlatformTop">
                    <h2>{{$platform->Platform}}</h2>
                    <img src="{{asset("Admin/dist/img/web/Platforms/$platform->CoverImg")}}" alt="{{$platform->Platform}}">
                </div>
                <div class="container">
                    <div class="PlatformDesc">
                        <p>
                            @if(App::getLocale() == 'ar')
                                {{$platform->ArabicDescription}}
                            @else
                                {{$platform->MainDescription}}
                            @endif
                        </p>
                    </div>

                    <div id="accordion">
                        <div class="FAQonly">
                            <div class="FAQTop">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#FAQ{{$platform->ID}}" aria-expanded="true" aria-controls="FAQ">
                                        {{ __('messages.FAQ')}}
                                    </button>
                                </h5>
                            </div>
                            <div class="PlatformInfo">
                                @foreach($platform->Faqs as $FAQ)
                                    <div class="collapse" id="FAQ{{$platform->ID}}" aria-labelledby="{{$platform->Platform}}" data-parent="#accordion">
                                        <div class="PlafromQuestion">
                                            <h3>{{$FAQ->Question}}</h3>
                                            <p>{{$FAQ->Asnwer}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="Videos">
                            <div id="youtube-player">
                                <div class="FAQTop">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="{{$platform->ID}}" aria-expanded="true" aria-controls="Video">
                                            {{ __('messages.Video')}}
                                        </button>
                                    </h5>
                                </div>
                                <div class="collapse" id="Video{{$platform->ID}}" aria-labelledby="{{$platform->Platform}}" data-parent="#accordion">
                                    <iframe class="PlatformVideo" src="{{$platform->VideoURL}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Related -->
                    <div class="Category-Product mt-5 pt-4">
                        <h3>{{ __('messages.RelatedProducts')}}</h3>
                        <a href="https://zhome.com.eg/Front/Shop.php?action=PlatformFilter&PlatformID={{$platform->ID}}">{{ __('messages.DiscoverMore')}}<i class="fa fa-arrow-right"></i></a>
                    </div>
                    <div class="related-product__carousel owl-carousel owl-theme mt-4 mb-5">                                
                            @foreach($platform->products as $product)
                                <div class="item">
                                    <a href="{{ route('Product.show', $product->ID) }}">
                                        <x-user.product-card-user :variable="$product" :productID="$product->ID" />
                                    </a>
                                </div>
                            @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endsection

@section('Js')
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
    <!-- Add to Cart -->
    <script>
        updateCartCount()
    </script>

@stop