@extends('User.layout.master')
@section('Title' , 'Categories')

@section('Css')
    <style>
        .owl-carousel .owl-stage-outer {
            height: 400px;
            border-radius: 10px;
        }
        .bottom-slider {
            display: flex;
            margin: 0 39px;
            gap: 56px;
            align-items: center;
            top: -318px;
            position: relative;
        }
        .slider-one__btn {
            padding: 13px 27px;
            width: 176px;
            border-radius: 35px;
        }
        @media (max-width: 767px) {
            .related-product__carousel .owl-item {
                width: 225px !important;
            }
            .Category-Product {
                margin-top: 20px;
                display: grid;
                text-align: center;
                justify-content: center;
            }
            .bottom-slider {
                top: -140px !important;
            }
            .slider-one .active .slider-one__title {
                width: -webkit-fill-available;
            }
        }
    </style>
@endsection

@section('Content')

    <section>
        <div class="container mt-3 mb-4">
            <div class="block-title text-center">
                <p class="block-title__tag-line text-center">{{ __('messages.Zhome')}}</p>
                <h1 class="text-center">{{ __('messages.Categories')}}</h1>
            </div>
        </div>
    </section>

    <!-- All Categories header -->
    <section class="mt-5">
        <div class="notSilder pb-5 border-none">
            @foreach ( $categories as $category )
                <a href="#{{$category->Category}}">
                    <div class="slide Categories">
                        <p class="text-center pr-0">
                            @if(App::getLocale() == 'ar')
                                {{$category->ArabicName}}
                            @else
                                {{$category->Category}}
                            @endif
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- All Categories and thier sub -->
    <section>
        <div class="container">

            <!-- Category -->
            <section class="all-Category">

                @foreach ( $categories as $category )

                    <section class="slider-one" style="top:0;" id="{{$category->Category}}">
                        <div class="slider-one__carousel owl-carousel owl-theme">
                            <div class="item slider-one__slider-1" style="background-image: url({{asset("Admin/dist/img/web/Categories/$category->MainImage")}};" >
                                <div class="container bottom-slider">
                                    <a href="{{route("Shop.Filter.category" , $category->ID)}}" class="thm-btn slider-one__btn">
                                        @if(App::getLocale() == 'ar')
                                            {{$category->ArabicName}}
                                        @else
                                            {{$category->Category}}
                                        @endif
                                    </a>
                                    <h2 class="slider-one__title">
                                        {{ __('messages.DiscoverTheProductsOf')}}
                                        @if(App::getLocale() == 'ar')
                                            {{$category->ArabicName}}
                                        @else
                                            {{$category->Category}}
                                        @endif
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Sub of that Category -->
                    <section>
                            <div class="boxes-shop SubCategory-OnlineShop justify-content-center">
                                    @if($category->subcategories->isNotEmpty())
                                        @foreach($category->subcategories as $subCategory)

                                            <a class="ToTheSubPage" href="{{route("Shop.Filter.subcategory" , $subCategory->ID)}}">
                                                <div class="box-shop SubCategory-onlineshop" style="background-image: url({{asset("Admin/dist/img/web/Categories/SubCategories/$subCategory->Image")}};">
                                                </div>
                                                <p>
                                                    @if(App::getLocale() == 'ar')
                                                        {{$subCategory->SubArabicName}}
                                                    @else
                                                        {{$subCategory->SubName}}
                                                    @endif
                                                </p>
                                            </a>

                                        @endforeach
                                    @endif
                            </div>
                    </section>

                    <!-- Product From The Selected Category -->
                    <section>
                        <div class="Category-Product">
                            <h3>
                                @if(App::getLocale() == 'ar')
                                    {{$category->ArabicName . " منتجات"}}
                                @else
                                    {{$category->Category . " Products"}}
                                @endif
                            </h3>
                            <a href="{{route("Shop.Filter.category" , $category->ID)}}">{{ __('messages.DiscoverMore')}}<i class="fa fa-arrow-right"></i></a>
                        </div>
                        <div class="related-product__carousel owl-carousel owl-theme mt-5 mb-5">

                            @foreach($category->subcategories as $subcategory)
                                @if ($subcategory->products->isNotEmpty())
                                    @foreach($subcategory->products as $product)
                                        <div class="item">
                                            <a href="{{ route('Product.show', $product->ID) }}">
                                                <x-user.product-card-user :variable="$product" :productID="$product->ID" />
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </section>

                @endforeach

            </section>

        </div>
    </section>
@endsection
