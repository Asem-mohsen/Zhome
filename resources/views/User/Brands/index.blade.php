@extends('User.layout.master')
@section('Title' , 'Brands')

@section('Content')

@section('Css')
    <style>
        /* Navbar for specific pages */
        .header{
            border-bottom: 1px solid #eeee;
        }
        .menu .menu__inner .menu__item .menu__link , .nav-icon i{
            color: black
        }
        #Icons .separator {
            border-left: 1px solid black;
        }
        a.menu__link.JoinUsBtn {
            border: 1px solid #154352;
            color: black;
        }
        a.menu__link.JoinUsBtn:hover{
            color: white;
        }
        /* End */
        section.SectionNumber:nth-child(even) {
                background-color: aliceblue;
        }
        @media (max-width: 767px) {
            .owl-carousel .owl-item {
                width: 225px !important;
            }
            .Category-Product {
                display: grid;
                text-align: center;
                justify-content: center;
            }
            .customer-logos .platform img {
                width: 70px !important;
                height: 55px !important;
                padding: 5px;
            }
            .customer-logos .platform {
                width: max-content;
            }
            .customer-logos .platform p {
                padding-right: 7px !important;
            }
            .customer-logos .slick-track {
                display: flex;
            }
            .slick-initialized .slick-slide {
                width: -webkit-fill-available !important;
            }
        }
        .customer-logos .platform {
            justify-content: center;
        }
        .slick-track{
            margin:auto;
        }
    </style>
@endsection

    <section class="mt-5">
        <div class="container mt-5 pt-5 mb-4">
            <div class="block-title text-center">
                <p class="block-title__tag-line text-center">{{ __('messages.Zhome')}}</p>
                <h1 class="text-center">{{ __('messages.Brands')}}</h1>
            </div>
        </div>
    </section>

    <!-- Slider for Brands -->
    <section class="mt-5">
        <div class="slider customer-logos border-none"> <!-- class -> slider customer-logos  to be slidable-->
            @if ($brands->isNotEmpty())
                @foreach ($brands as $brand )
                    <a href="#{{ $brand->Brand }}" class="customer-logos-brands">
                        <div class="slide platform">
                            <img src="{{asset("Admin/dist/img/web/Brands/$brand->Logo")}}" alt="{{$brand->Brand}}" class="w-100" style="object-fit:contain;">
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </section>

    <!-- Brands -->
    @php
        $i = 1;
    @endphp
    @foreach ($brands as $brand )
        <section class="SectionNumber" id="{{$brand->Brand}}">
            <div class="container">
                <div class="PlatformSection">
                    <div class="PlatformTop">
                        <h2>{{$brand->Brand}}</h2>
                        <img src="{{asset("Admin/dist/img/web/Brands/Cover/$brand->CoverImg")}}" alt="{{$brand->Brand}}" style="object-fit: contain;height: 300px;">
                    </div>
                    <div class="container">
                        <div class="PlatformDesc">
                            <p>{{$brand->MainDescription}}</p>
                        </div>

                        <!-- Products Related -->
                        <div class="category-Name mt-5 pt-5">
                            <h3>{{ __('messages.RelatedProducts')}}</h3>
                            <a href="{{route('Shop.Filter.brand' , $brand->ID)}}">{{ __('messages.DiscoverMore')}}<i class="fa fa-arrow-right"></i></a>
                        </div>
                        <div class="related-product__carousel owl-carousel owl-theme mt-3 mb-4">
                            @if ($brand->products->isNotEmpty())
                                @foreach ($brand->products as $product)
                                    <div class="item">
                                        <x-user.product-card-user :variable="$product" :productID="$product->ProductID" />
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach

@endsection

@section('Js')

    <!-- Logo Brands Slider -->
    <script>
        $(document).ready(function(){
            $('.customer-logos').slick({
                slidesToShow: 11,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2500,
                arrows: false,
                dots: false,
                pauseOnHover: true,
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 11
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
