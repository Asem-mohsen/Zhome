@extends('User.layout.master')

@php
    $title = App::getLocale() == 'ar' ? $product->ArabicName : $product->Name;
@endphp

@section('Title', $title)


@section('Css')
    <style>
            .slider-OnlineShop .owl-carousel .owl-stage-outer {
                border-radius: 0;
            }
        @media (max-width: 767px){
            h3.product-details__title{
                text-align: center;
                margin-top: 20px;
                font-weight: bold;
                font-size: 30px;
            }
            .product-details__price{
                    text-align: center;
            }
            div.product-details__button-block{
                display: flex !important;
                justify-content: space-evenly;
                justify-items: center;
            }
            .product-details__availabelity{
                text-align: center;
                margin-top: 26px;
            }

            .Product-Platforms{
                justify-content: center;
            }
            .product-details__social{
                justify-content: center;
            }
            hr.separator {
                margin-top: 0px !important;
            }
            .Image-One-ProductDetails {
                width: auto;
                left:0;
            }
            nav.navbar {
                border-bottom: none !important;
            }
            .Images-ProductsDetails div.Image-One-ProductDetails img {
                border-radius: 0 !important;
                height: 250px !important;
            }
            .Text-under-images-ProductDetails {
                width: auto !important;
                justify-content: center;
            }
            h2.ProductDetails-Text {
                width: auto !important;
                    font-size: 37px !important;
                    text-align: center !important;
            }
            .Product-Platforms .platform{
                    width: 100% !important;
            }
            .product-details__review{
                margin-bottom: 0px;
                padding: 0 20px;
            }
            .product-details__review-left{
                margin: auto;
                margin-bottom: 25px;
            }
            .product-details__review-top {
                justify-content: center;
            }
            .product-details__review-top-left{
                display: grid;
                justify-content: center;
                justify-items: center;
                align-self: center;
            }
            .Product-spacification .Details h5 {
                width: auto !important;
            }
            .row.LessMarginHere{
                margin-top: 22px !important;
            }
            .product-details .accrodion-title {
                padding: 10px;
            }
            .ProductDetails_Section_last button {
                transform: translateX(0px);
            }
            .Product-spacification{
                width: 100%;
                    padding: 0px;
                    display: block;
            }
            .Product-spacification .container{
                padding-right: 0px;
                    padding-left: 0px;
            }
            .Product-spacification .Details {
                display: grid;
                justify-content: center;
                padding-top: 26px;
                text-align: center;
                width: -webkit-fill-available;
            }
            .Details .many-details {
                gap: 14px;
                padding: 20px;
                grid-column-gap: 7px;
            }
            .product-details__review video{
                width: -webkit-fill-available !important;
                height: 254px !important;
            }
        }
    </style>
@endsection

@section('Content')

        <!-- Header -->
        <div class="container">
            <ul class="list-unstyled thm-breadcrumb thm-breadcrumb__two">
                <li><a href="{{route('index')}}">{{ __('messages.Home')}}</a></li>
                <li><a href="{{route('Shop.index')}}">{{ __('messages.Shop')}}</a></li>
                <li>
                    @if(App::getLocale() == 'ar')
                        {{ucfirst(strtolower($product->ArabicName))}}
                    @else
                        {{ucfirst(strtolower($product->Name))}}
                    @endif
                </li>
            </ul>
        </div>

        <!-- Details -->
        <section class="product-details NearestDiv">
            <div class="container">
                <div class="row RowReverseInArabic justify-content-center">
                    <div class="col-lg-6">
                        <div class="product-details__image">
                            <img class="img-fluid MainUpperImage" src="{{asset("Admin/dist/img/web/Products/MainImage/$product->MainImage")}}" width="500px" height="500px" alt="{{$product->Name}}" />
                            <a href="#" class="product-details__img-popup img-popup">
                                <i class="fa fa-search"></i>
                            </a>
                        </div>
                        <div class="additional-images">
                            @foreach ($product->images as $image)
                                <div class="additional-image m-2">
                                    <img class="img-fluid h-100" src="{{ asset("Admin/dist/img/web/Products/OtherImages/{$image->Image}") }}" style="width:130px;object-fit: cover;" alt="{{$product->Name}}" />
                                </div>
                            @endforeach
                        </div>
                        <div class="Hidden-inputs">
                            <!-- HiddenInputs -->
                                <input type="hidden" name="UserID"       value="@if(Auth::guard('web')->check()) {{ Auth::guard('web')->user()->id }} @else {{session_id()}} @endif ">
                                <input type="hidden" name="ProductID"    value="{{$product->ID}}">
                                <input type="hidden" name="Price"        value="{{$product->Price}}">
                                <input type="hidden" name="ProductName"  value="{{$product->Name}}">
                                <input type="hidden" name="ProductImage" value="{{asset("Admin/dist/img/web/Products/MainImag/$product->MainImage")}}">
                            <!-- End -->
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="product-details__content ">
                            <!-- Product With Sale -->
                                <h1 class="product-details__title">
                                    @if(App::getLocale() == 'ar')
                                        {{ucfirst(strtolower($product->ArabicName))}}
                                    @else
                                        {{ucfirst(strtolower($product->Name))}}
                                    @endif
                                </h1>
                                @if($product->sale != NULL)
                                    <input type="hidden" name="PriceAfterSale" value="{{ $product->sale->PriceAfter }}" >
                                    <p class="product-details__price">{{ $product->sale->PriceAfter . " EGP"}}</p>
                                    <p class="product-details__price" style="text-decoration: line-through; font-size:19px">{{ $product->Price . " EGP"}}</p>
                                @else
                                    <p class="product-details__price">{{ $product->Price . " EGP"}}</p>
                                @endif

                                <p class="product-details__text">
                                    @if(App::getLocale() == 'ar')
                                        {{$product->ArabicProductDescription }}
                                    @else
                                        {{ $product->Description }}
                                    @endif
                                </p>
                                <p class="product-details__categories">
                                    <span class="text-uppercase"> {{ __('messages.Category')}} </span>
                                    <a href="{{route('Shop.Filter.category' , $product->subcategory->category->ID )}}">
                                        @if(App::getLocale() == 'ar')
                                            {{$product->subcategory->category->ArabicName }}
                                        @else
                                            {{$product->subcategory->category->Category }}
                                        @endif
                                    </a>
                                                    </br>
                                    <span class="text-uppercase"> {{ __('messages.Brand')}}  </span>
                                    <a href="{{ $product->brand->ID }}">
                                        {{ $product->brand->Brand }}
                                    </a>
                                </p>
                                <div class="product-details__button-block d-grid gap-1">
                                    <input type='hidden' name='Quantity' value="{{$product->Quantity}}" />
                                    @if($product->Quantity > 0)
                                        <input class="quantity-spinner" type="text" min="1" value="1" name="quantity" id="quantity-{{ $product->ID }}">
                                        <button onclick="addToCart({{ $product->ID }}, {{ $product->sale  ? $product->sale->PriceAfter : $product->Price }}, {{ $product->InstallationCost ?? 0 }})" class="thm-btn product-details__cart-btn">{{ __('messages.AddtoCart')}} <span>+</span></button>
                                    @elseif($product->Quantity <= 0)
                                        <p class='OutStock'> {{ __('messages.OutofStock')}} </p>
                                    @endif
                                </div>
                                @if($product->Quantity > 0)
                                    <p class="product-details__availabelity">
                                        <span>{{ __('messages.Availability')}}</span>
                                        <i class='fa-solid fa-check'></i> {{ __('messages.AvailableInstock')}}
                                    </p>
                                @else
                                    <p class="product-details__availabelity">
                                        <span>{{ __('messages.Availability')}}</span>
                                        <span style='color: red;'><i class='fa-solid fa-xmark' style='color: red;'></i> {{ __('messages.CurrentlyOutofstock')}} </span>
                                    </p>
                                @endif

                                <div class="Product-Platforms DisplayFlex">
                                    @foreach($product->platforms as $platform)
                                        <a href="{{route('Shop.Filter.platform' , $platform->ID)}}">
                                            <div class="platform">
                                                <img src="{{ asset("Admin/dist/img/web/Platforms/{$platform->Logo}") }}" alt="{{$platform->Platform}}">
                                                <p>{{$platform->Platform}}</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                                <p class="product-details__social">
                                    <a href="" target="_blank"><i class="fa fa-facebook-f"></i></a>
                                    <a href=""  target="_blank"><i class="fa fa-twitter"></i></a>
                                    <a href="" target="_blank"><i class="fa fa-instagram"></i></a>
                                </p>
                        </div>
                    </div>
                    <hr class="separator">

                    <div class="col-lg-12">
                        <div class="container">
                            <h2 class="ProductDetails-Text">
                                @if(App::getLocale() == 'ar')
                                    {{$product->productDetails->ArabicTitle}}
                                @else
                                    {{ $product->productDetails->Title}}
                                @endif
                            </h2>
                            <div class="Images-ProductsDetails">
                                <div class="Image-One-ProductDetails fadeInUp">
                                    <img src="{{ asset("Admin/dist/img/web/Products/CoverImage/{$product->productDetails->CoverImage}") }}" alt="Cover Image">
                                </div>
                            </div>
                            <div class="Text-under-images-ProductDetails">
                                <div class="text-one-ProductDetails">
                                    <div class="top-text">
                                        <img src="{{ asset("Admin/dist/img/web/Brands/{$product->brand->Logo}") }}" alt="{{$product->brand->Brand}}">
                                        <h3>{{ __('messages.Brand')}}</h3>
                                    </div>
                                    <div class="bottom-text">
                                        <p>
                                            @if(App::getLocale() == 'ar')
                                                {{ucfirst(strtolower($product->ArabicName . 'من ضمن منتجات '))}}
                                            @else
                                                {{ucfirst(strtolower($product->Name . ' is a '))}}
                                            @endif
                                            {{$product->brand->Brand}}
                                        </p>
                                    </div>

                                </div>
                                <div class="text-one-ProductDetails">
                                    <div class="top-text">
                                    <i class="fa-solid fa-folder"></i>
                                    <h3>{{ __('messages.Platform')}}</h3>
                                    </div>
                                    <div class="bottom-text">
                                        <div class="Product-Platforms">
                                            @foreach($product->platforms as $platform)
                                                <a href="{{route('Shop.Filter.platform' , $platform->ID)}}">
                                                    <div class="platform">
                                                        <img src="{{ asset("Admin/dist/img/web/Platforms/{$platform->Logo}") }}" alt="{{$platform->Platform}}">
                                                        <p>{{$platform->Platform}}</p>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @if($product->InstallationCost != NULL || $product->InstallationCost != 0)
                                    <div class="text-one-ProductDetails">
                                        <div class="top-text">
                                            <i class="fa-solid fa-gears"></i>
                                            <h3>{{ __('messages.ProfessionalInstallation')}}</h3>
                                        </div>
                                        <div class="bottom-text">
                                            <p>
                                                {{ __('messages.TextProfessionalInstallation')}} {{$product->InstallationCost . ' EGP'}}.
                                            </p>
                                        </div>
                                    </div>
                                @endif
                                <div class="text-one-ProductDetails">
                                    <div class="top-text">
                                        <i class="fa-solid fa-house-signal"></i>
                                        <h3>{{ __('messages.Technology')}}</h3>
                                    </div>
                                    <div class="bottom-text">
                                        <p>
                                            @foreach ($product->technologies as $technology)
                                                @php
                                                    $technologyArray[] = $technology['Technology'];
                                                @endphp
                                            @endforeach
                                                @php
                                                    $technologyCount = count($technologyArray);
                                                @endphp
                                            @for ($i = 0; $i < $technologyCount; $i++)
                                                    {{$technologyArray[$i]}}
                                                    @if($i < $technologyCount - 1)
                                                        {{'-'}}
                                                    @endif
                                            @endfor
                                        </p>
                                    </div>
                                </div>
                                @foreach($product->features as $feature)
                                    <div class="text-one-ProductDetails">
                                        <div class="top-text">
                                            <img src="{{asset('Admin/dist/img/photo3.jpg')}}" alt="{{$feature->Feature}}">
                                            <h3>{{$feature->Feature}}</h3>
                                        </div>
                                        <div class="bottom-text">
                                            <p>
                                                {{$feature->Description}}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Expert Review -->
                    <div class="mt-4" style="border-bottom:1px solid #eeee; ">
                        <div class="product-details__review-form">
                            <h2 class="mb-4 text-center">{{ __('messages.ExpertReview')}}</h2>
                            <!-- Reviews -->
                            <div class="product-details__review mb-4">
                                <div class="ExpertReview m-auto mt-5">
                                    <div class="product-details__review-form">
                                        <div class="product-details__review-single">
                                            <div class="product-details__review-left">
                                                <img src="{{asset('Admin/dist/img/avatar2.png')}}" width="70px" height="70px" alt="Image" />
                                            </div>
                                            <div class="product-details__review-right">
                                                <div class="product-details__review-top">
                                                    <div class="product-details__review-top-left">
                                                        <h3 class="product-details__review-title">{{ "Admin Name"}}</h3>
                                                        <span class="product-details__review-sep">-</span>
                                                        <span class="product-details__review-date"><?php // echo $Date
                                                                                                            echo "Expert engineer"    ?></span>
                                                    </div>
                                                </div>
                                                <p class="product-details__review-text">
                                                    @if(App::getLocale() == 'ar')
                                                        {{$product->evaluations->ArabicEvaluation}}
                                                    @else
                                                        {{$product->evaluations->Evaluation}}
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Product Part 2 -->
                <div class="row LessMarginHere mt-5 pt-5">
                    <div class="col-lg-6">
                        <div class="product-details__content ProductDetails_Section_last">
                                <h3 class="product-details__title">
                                    @if(App::getLocale() == 'ar')
                                        {{$product->productDetails->ArabicTitle2}}
                                    @else
                                        {{ $product->productDetails->Title}}
                                    @endif
                                </h3>
                                <ul>
                                    <li>
                                        <span><i class="fa-solid fa-check"></i></span>
                                        <p>{{$product->brand->Brand ." Brand" }} </p>
                                    </li>
                                    <li>
                                        <span><i class="fa-solid fa-check"></i></span>
                                        <p>
                                            {{ __('messages.CompitableWith')}}
                                                @foreach($product->platforms as $Platform)
                                                    <p>{{$Platform->Platform}}</p>
                                                @endforeach
                                            Platfrom
                                        </p>
                                    </li>
                                    @foreach($product->features as $feature)
                                        <li>
                                            <span><i class="fa-solid fa-check"></i></span>
                                            <p>{{$feature->Feature}}</p>
                                        </li>
                                    @endforeach

                                    <li>
                                        <span><i class="fa-solid fa-check"></i></span>
                                        <p> {{ __('messages.FreeTransportation')}}</p>
                                    </li>

                                    @if($product->InstallationCost != NULL || $product->InstallationCost != 0)
                                        <li>
                                            <span><i class="fa-solid fa-check"></i></span>
                                            <p>{{ __('messages.TextProfessionalInstallation')}} {{ $product->InstallationCost . 'EGP'}}</p>
                                        </li>
                                    @endif

                                </ul>
                                <div class="product-details__button-block d-grid gap-1">
                                    <input type='hidden' name='Quantity' value="{{$product->Quantity}}" />
                                    @if($product->sale != NULL)
                                        <input type="hidden" name="PriceAfterSale" value="{{$product->sale->PriceAfter}}">
                                    @endif

                                    @if($product->Quantity > 0)
                                        <button onclick="addToCart({{ $product->ID }}, {{ $product->sale  ? $product->sale->PriceAfter : $product->Price }}, {{ $product->InstallationCost ?? 0 }})" data-toggle="tooltip" data-placement="top" class="thm-btn product-details__cart-btn"> {{ __('messages.AddtoCart')}}</button>
                                    @elseif($product->Quantity <= 0)
                                        <p class='OutStock text-center' style='font-size: 20px;'> {{ __('messages.OutofStock')}}</p>
                                    @endif
                                </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="product-details__image LastProductDetails">
                            <img class="img-fluid" src="{{asset("Admin/dist/img/web/Products/MainImage/$product->MainImage")}}" alt="{{$product->Name}}" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- User Reviews and FAQ , Video and Description-->
        <section class="product-details">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-details__content">
                            <div class="accrodion-grp" data-grp-name="product-details__accrodion">
                                <div class="accrodion">
                                    <div class="accrodion-title">
                                        <a data-toggle="collapse" href="#Description" role="button" aria-expanded="false"  aria-controls="Description">{{ __('messages.ProductDescription')}}</a>
                                    </div>
                                    <div class="collapse " id="Description">
                                        <div class="inner">
                                            <div class="product-details__review-form">
                                                <!-- Description -->
                                                <div class="Product-spacification">
                                                    <div class="container">
                                                        <div class="Details">
                                                            <h5>{{ __('messages.Capacity')}}</h5>
                                                            <div class="Details-info">
                                                                <p>{{ __('messages.Capacity')}}(m)</p>
                                                                <span>{{ $product->productDetails->Capacity . 'm'}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="Details">
                                                            <h5>{{ __('messages.Noise')}}</h5>
                                                            <div class="Details-info">
                                                                <p>{{ __('messages.NoiseLevel')}}(dBA)</p>
                                                                <span>50 dBA</span>
                                                            </div>
                                                        </div>
                                                        <div class="Details">
                                                            <h5> {{ __('messages.PhysicalSpecification')}}</h5>
                                                            <div class="many-details">
                                                                <div class="Details-info">
                                                                    <p>{{ __('messages.NetDimension')}}(WxHxD)</p>
                                                                    <span>{{ $product->productDetails->Width . 'x' . $product->productDetails->Height .  'x' . $product->productDetails->Length}}</span>
                                                                </div>
                                                                <div class="Details-info">
                                                                    <p>{{ __('messages.NetWeight')}}(kg)</p>
                                                                    <span>{{ $product->productDetails->Weight . 'KG'}}</span>
                                                                </div>
                                                                <div class="Details-info">
                                                                    <p>{{ __('messages.Color')}}</p>
                                                                    <div class="Colorsdiv">
                                                                        @if($product->productDetails->Color)
                                                                            <span class="color" style="background-color:{{ $product->productDetails->Color }}">
                                                                            </span>
                                                                        @elseif ($product->productDetails->Color2)
                                                                            <span class="color" style="background-color:{{ $product->productDetails->Color2 }}">
                                                                            </span>
                                                                        @elseif ($product->productDetails->Color3)
                                                                            <span class="color" style="background-color:{{ $product->productDetails->Color3 }}">
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="Details">
                                                            <h5>{{ __('messages.AirPurification')}}</h5>
                                                            <div class="many-details">
                                                                <div class="Details-info">
                                                                    <p>Indcator(cleanliness)</p>
                                                                    <span>{{ $product->productDetails->AirPurification }}</span>
                                                                </div>
                                                                <div class="Details-info">
                                                                    <p>Pre Filter</p>
                                                                    <span>
                                                                        @if( $product->productDetails->PreFilter == 1)
                                                                                {{'Yes'}}
                                                                        @else
                                                                                {{'No'}}
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                <div class="Details-info">
                                                                    <p>Dust Collecting</p>
                                                                    <span> {{ $product->productDetails->DustCollecting == 1 ? 'Yes' : 'No' }}</span>
                                                                </div>
                                                                <div class="Details-info">
                                                                    <p>Deodorizing Filter</p>
                                                                    <span>{{ $product->productDetails->DeodorizingFilter == 1 ? 'Yes' : 'No' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="Details">
                                                            <h5>{{ __('messages.ElectricalDate')}}</h5>
                                                            <div class="Details-info">
                                                                <p>Power Consumption(W)</p>
                                                                <span>{{ $product->productDetails->PowerConsumption .' W' }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Tech details -->
                                <div class="accrodion">
                                    <div class="accrodion-title">
                                        <a data-toggle="collapse" href="#FAQ" role="button" aria-expanded="false" aria-controls="FAQ">{{ __('messages.TechnicalDetails')}}</a>
                                    </div>
                                    <div class="collapse " id="FAQ">
                                        <div class="inner">
                                            <div class="product-details__review-form mt-3">
                                                <!-- FAQ -->
                                                <div class="product-details__review mb-4">
                                                    @foreach ($product->faqs as $faq)
                                                        <div class="product-details__review-single" style="padding: 1px 30px;border:none;justify-content: left;">
                                                            <div class="product-details__review-right">
                                                                <div class="FAQ"  style="gap: 0px;">
                                                                    <div class="Question">
                                                                        {{ ucfirst(strtolower($faq->Question)) }}
                                                                    </div>
                                                                    <div class="Answer">
                                                                        <p class="product-details__review-text mt-3"> {{ ucfirst(strtolower($faq->Answer)) }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Video -->
                                <div class="accrodion">
                                    <div class="accrodion-title">
                                        <a data-toggle="collapse" href="#Video" role="button"  aria-expanded="false" aria-controls="Video">{{ __('messages.Video')}}</a>
                                    </div>
                                    <div class="collapse " id="Video">
                                        <div class="inner">
                                            <div class="product-details__review-form" style="text-align-last: center;">
                                                <!-- Video -->
                                                <div class="product-details__review" style="margin-bottom: 40px;">
                                                    <source src="{{$product->productDetails->Video}}" type="video/mp4">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- You may also like -->
        <section>
            <div class="container">
                <h3 class="related-product__title">{{ __('messages.YouMayAlsoLike')}}</h3>
                <div class="related-product__carousel owl-carousel owl-theme">

                    @foreach($products as $product)
                        <div class="item">
                            <x-user.product-card-user :variable="$product" :productID="$product->ID" />
                        </div>
                    @endforeach

                </div>
            </div>
        </section>

@endsection


@section('Js')
    <script>
        $(document).ready(function () {
            $('.additional-image, .product-details__img-popup').click(function () {
                var imageUrl = $(this).closest('.additional-image, .product-details__image').find('img').attr('src');
                $('.product-details__image img').attr('src', imageUrl);
                $('.product-details__img-popup').attr('href', imageUrl);
            });
        });
    </script>
@stop
