@extends('User.layout.master')

@section('Title', $subcategory->SubName)


@section('Css')
    <!-- Price Slider Range -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- End Price Slider Range -->
    <style>
        .slider-OnlineShop .owl-carousel .owl-stage-outer {
            border-radius: 0;
        }
        .product-one__single{
            border: 1px solid rgb(240, 240, 240);
            border-radius: 6px; height: 379px;
            visibility: visible;
            animation-delay: 0.2s;
            animation-name: fadeInUpBig;
            padding: 10px;
        }

        /*Shop Container*/
        @media (max-width: 767px){
            .header-navigation.ShopNav {
                display: none;
            }
            .FilterTransform{
                width: -webkit-fill-available;
                flex: 100% !important;
                max-width: 100% !important;
            }
            .shop_sidebar_area{
                display: flex;
                flex-wrap: wrap;
                width: 100%;
            }
            .shop_grid_area a.btn.btn-info { 
                display: none;
            }
            .widget {
                    width: 50%;
                padding: 20px 0;
            }
            .FilterTransform {
                transform: translateY(0px) !important; 
            }
            .widget:last-child {
                display: none;
            }
            .nav-side-menu{
                width: 100%;
            }
            .icon.icon-shape.icon-sm.border-radius-md.text-center.me-2.d-flex.align-items-center{
                display: block !important;
            }
            .shop_grid_product_area{
                width: 100%;
            }
            .shop_grid_product_area .row{
                width: -webkit-fill-available;
                padding: 16px;
            }
            .shop_grid_product_area .row .item {
                width: 100%;
            }
            .shop_grid_product_area .row .item .product-one__single {
                width: 100%;
            }
            .shop_grid_product_area .row .item .product-one__image > img {
                width: 100%;
                object-fit: contain;
            }
            .Plaforms-flex a{
                width: 50px;
            }
            section.shop-background {
                /*transform: translateY(-50px)!important;*/
            }
            .BrandDescriptionShop{
                display:none !important;
            }
            #filterOverlay.overlay{
                display:none;
            }
            #FilterShopButton {
                text-align: center;
                display: flex !important;
                border: 1px solid #d4d4d4;
                padding: 9px 4px;
                align-items: center;
                gap: 8px;
                width: -webkit-fill-available;
                border-radius: 4px;
                background-color: white;
                margin: auto;
                justify-content: center;
                font-size: 17px;
                color: #525252;
            }
            #FilterShopButton:foucs{
                outline: 0px auto -webkit-focus-ring-color;
                border: 1px solid #1c839a;
            }
            #FilterShopButton:hover{
                outline: 0px auto -webkit-focus-ring-color;
                border: 1px solid #1c839a;
            }
            .FilterTransform.MainFilter{
                display:none!important;
            }
        }
        .SubCategory-OnlineShop a.ToTheSubPage{
            display: grid;
            justify-content: center;
            align-items: center;
            justify-items: center;
        }
        /*@media (min-width: 1200px){*/
        @media screen and (min-width: 1500px) {
            .container {
                max-width: 1763px !important;
            }
            .shop_sidebar_area{
                width: 193px;
            }

            .shop_grid_product_area .row{
                padding-left: 0px !important;
                gap: 55px !important;
            }
            
            .product-one__single {
                width: 241px !important;
            }
            .col-lg-3 {
                flex: 0 0 18% !important;
            }
            #filterOverlay .FilterTransform{
                padding:0px !important;
            }
        }
    </style>
@endsection


@section('Content')

    <!-- Header -->
    <section class="shop-background site-banner jarallax pb-0" style="min-height:100px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-title">
                        @if(App::getLocale() == 'ar')
                            {{$subcategory->SubArabicName}}
                        @else
                            {{$subcategory->SubName}}
                        @endif
                    </h1>
                    <div class="breadcrumbs">
                    <span class="item">
                        <a href="{{route('Shop.index')}}" style="color: #d1d1d1;">
                            @if(App::getLocale() == 'ar')
                                {{$category->ArabicName}}
                            @else
                                {{$category->Category}}
                            @endif
                        /</a>
                    </span>
                        <span class="item text-black">
                            @if(App::getLocale() == 'ar')
                                {{$subcategory->SubArabicName}}
                            @else
                                {{$subcategory->SubName}}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <button id="FilterShopButton mt-5"><i class="fa-solid fa-filter"></i><span>{{ __('messages.Filters')}}</span></button>
        </div>
    </section>

    <!-- Filter and Products -->
    <section class="shop_grid_area">
        <div class="container" style="max-width: 1220px;">
            <div class="row Page-flex">
                
                @include('User.Partials.shop_filter')

                <!-- Products -->
                <div class="col-12 col-md-8 col-lg-10">
                    <div class="shop_grid_product_area">
                        <div class="row d-flex justify-content-start pl-3" style="gap: 23px">

                            <!-- Single gallery Item -->
                            @foreach($products as $product)
                                <div class="item">
                                    <x-user.product-card-user :variable="$product" :productID="$product->ID" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="SellingProduct-Separated">
            <div class="ShopNowInCart" style="background-image: url(../Admin/Images/sebastian-scholz-nuki-Fh3Dtg6QX4Q-unsplash3.png);height:285px;align-content: space-evenly;border-radius:4px;width: 751px;">
                <h4>
                    {{__('messages.Bundles')}}
                </h4>
                <a href="{{route('Shop.index')}}" class="btn btn-secondary" style="height: 41px;">{{__('messages.MoreInfo')}}</a>
            </div>
            <div class="ShopNowInCart" style="background-image: url(../Admin/Images/bence-boros-anapPhJFRhM-unsplash-2.png);height:285px;align-content: space-evenly;border-radius:4px;width: 400px">
                <h4>
                    {{__('messages.BuildToolShop')}}
                </h4>
                <a href="{{route('Shop.index')}}" class="btn btn-secondary" style="height: 41px;">{{__('messages.DiscoverNow')}}</a>
            </div>
        </div>
    </section>
@endsection

@section('Js')
    <script src="{{asset('UI/js/shop_filter.js')}}"></script>
@stop