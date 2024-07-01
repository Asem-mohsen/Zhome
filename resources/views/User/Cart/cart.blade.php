@extends('User.layout.master')

@section('Title', 'Cart')


@section('Css')
    <style>
        button:focus{
            outline: 0;
        }
        .slider-OnlineShop .owl-carousel .owl-stage-outer {
        border-radius: 0;
        }
       .Userform .row {
            padding-right: 15px;
            padding-left: 15px;
       }
       div.Checkout .Userform .form-group {
            display: grid;
            align-items: center;
            gap: 4px;
            padding:0;
        }
        div.Checkout .Userform .form-group label {
            margin: 0;
            width: 83px;
        }
         @media (max-width: 767px) {
            .related-product__carousel .owl-item {
                width: 225px !important;
            }
            .col-lg-12 .ShopNowInCart#ShopNowInCheckout {
                height: auto;
               margin-top: 22px !important;
            }
            .CardCarouselCart{
               height: 400px;
                padding: 0;
                margin: 25px 0;
             }
             .Splitted div.Image-One {
                padding: 20px 0 !important;
            }
            .topping{
                display: grid;
                justify-content: center;
                text-align: center;
            }
            div.Checkout .Summery ul:nth-child(odd) {
                width: 100%;
            }
            div.Checkout .Summery ul {
                width: 100%;
            }
                #wizard .content.clearfix .row .col-md-4 , #wizard .content.clearfix .row .col-md-12,  .row .col-md-6 {
                    padding:0 !important;
                }
                .wizard .actions > ul {
                    gap: 20px;
                }
                 .wizard .actions li a  {
                    width: 150px  !important;
                    text-align: center;
                    font-style: 15px;
                    font-weight: bold;
                    text-decoration: none;
                    text-align: center;
                }
               .wizard .actions li:not(.disabled) + li, .wizard .actions li:not(:first-child):last-child {
                     margin-left: 0px !important;
                }
                .PromocodeInput .form-group{
                    display:grid !important;
                }
                .PayWithCardButton .card-line {
                    width: 65px !important;
                    height: 13px !important;
                }
                .PayWithCardButton .left-side {
                    background-color: #5de2a3;
                    width: 100px !important;
                }
                .PayWithCardButton .new {
                    font-size: 17px;
                    color: #67748e;
                    padding: 9px;
                    margin:0 !important;
                }
                .PayWithCardButton {
                    display: flex;
                    width: auto !important;
                    height: 47px !important;

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
            <li class="active"><a href="{{route('Cart.index')}}">{{ __('messages.Cart')}}</a></li>
        </ul>
    </div>

    <section>
        <div class="container">
            <div class="CartHeader">
                <p class="active">
                    {{ __('messages.Cart')}}
                </p>
                >
                <p>
                    {{ __('messages.Checkout')}}
                </p>
                >
                <p>
                    {{ __('messages.Payment')}}
                </p>
            </div>
        </div>
    </section>

    <!-- Cart -->
    <section>
        <div class="container">
            <div class="CartContainer">
                <div class="col-lg-12 CartProducts">
                    <div class="topping">
                        <div class="CartandCount">
                            <h3>{{ __('messages.Cart')}}</h3>
                            <span id="TotalItems">
                                @if ($cartItems->count() <= 1 )
                                    {{$cartItems->count() ." ".  __('messages.Product')}} 
                                @else
                                    {{$cartItems->count() ." ". __('messages.Products')}} 
                                @endif
                            </span>
                        </div>

                        @if($cartItems->count() > 0)
                            <div class="ClearAll">
                                <a class="remove-All-btn">
                                    <i class="fa fa-x"></i>
                                    {{ __('messages.ClearCart')}}
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="cart-main">
                        <div class="table-outer table-responsive">
                            <table class="cart-table" id="myTable">
                                <thead class="cart-header">
                                    <tr>
                                        <th class="prod-column">{{ __('messages.Product')}}</th>
                                        <th>{{ __('messages.Quantity')}}</th>
                                        <th>{{ __('messages.installation')}}</th>
                                        <th>{{ __('messages.Total')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($cartItems->count() > 0)
                                        @foreach($cartItems as $item)
                                            <tr data-product-id="{{$item->ProductID}}">
                                                <td class="prod-column price">
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <figure class="prod-thumb">
                                                                <a href="{{route('Product.show' , $item->ProductID)}}">
                                                                    <img src="{{asset("Admin/dist/img/web/Products/MainImage/" .$item->product->MainImage )}}" class="ProductCartImage" alt="{{$item->product->Name}}">
                                                                </a>
                                                            </figure>
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center ml-1">
                                                            <h3 class="prod-title padd-top-20">{{ucfirst(strtolower($item->product->Name)) }}</h3>
                                                            @if($item->product->sale)
                                                                <div class="d-flex" style="gap:20px;">
                                                                    <p class="text-xs text-secondary mb-0 fw-bold" style="font-size:17px">{{ number_format($item->product->sale->PriceAfter, 2) . "EGP" }}</p>
                                                                    <p class="text-xs text-secondary mb-0 BeforeSale" style="text-decoration: line-through; font-size:14px">{{ number_format($item->product->Price, 2) . "EGP" }}</p>
                                                                    <input type="hidden" name="SavedPrice" class="SavedPrice" value="{{$item->product->sale->PriceAfter}}"> 
                                                                </div>
                                                            @else
                                                                <p class="text-xs text-secondary mb-0 BeforeSale" >{{$item->product->Price . " EGP"}}</p>
                                                            @endif
                                                                <input type="hidden" name="Price[]" class="ProductPrice" value="{{$item->product->Price}}">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="qty">
                                                    <input class="quantity-spinner Quantity" onchange="updateTotalPrice()" type="number" min="1" max="{{ $item->product->Quantity }}" value="{{ $item->Quantity }}" name="Quantity[]">
                                                </td>
                                                <td for="installmentPriceCheckbox">
                                                    @if($item->product->InstallationCost && $item->product->InstallationCost > 0 )
                                                        <div class="d-flex justify-content-center" style="gap: 20px;">
                                                            <p class="text-secondary mb-0">{{$item->product->InstallationCost .  " EGP"}}</p>
                                                            <input type="hidden" class="installmentsPrice"  name="Installments" value="{{$item->product->InstallationCost}}">
                                                            <input type="checkbox" id="installmentPriceCheckbox" class="installments installmentPriceCheckbox" name="Installments" value="{{$item->product->InstallationCost}}">
                                                        </div>
                                                    @else
                                                        <p class="text-secondary mb-0">{{__('messages.NoInstallationCost')}}</p>
                                                        <input type="hidden" class="installments installmentPriceCheckbox" name="Installments" value="0">
                                                    @endif
                                                </td>
                                                <td class="sub-total SubTotal p-0"></td>
                                                <td class="remove p-1">
                                                    <a class="remove-btn" onclick="removeFromCart({{ $item->ProductID }})">
                                                        <span class="fa fa-x"></span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    @else
                                        <tr>
                                            <td class="text-center pt-4 border-none" colspan="4" style="border-top: 1px solid #eeee;border-radius: 0;">
                                                <a href="{{route('Shop.index')}}" class="cta ShopNowButton">
                                                    <span class="hover-underline-animation">{{ __('messages.ShopNowButton')}}</span>
                                                    <svg viewBox="0 0 46 16" height="10" width="30" xmlns="http://www.w3.org/2000/svg" id="arrow-horizontal">
                                                        <path transform="translate(30)" d="M8,0,6.545,1.455l5.506,5.506H-30V9.039H12.052L6.545,14.545,8,16l8-8Z" data-name="Path 10" id="Path_10"></path>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Total -->
    <section>
        <div class="container">
            <div class="row m-0 justify-content-evenly">
                @if($cartItems->count() > 0)
                    <div class="col-lg-6 CartPrices">
                        <h5 class="mb-4">{{ __('messages.Total')}}</h5>
                            <div class="PromocodeInput">
                                <!-- Line -->
                                <div class="Totals">
                                    <ul>
                                        <li>
                                            {{ __('messages.SubTotal')}}
                                            <span id='TotalPriceOne'></span>
                                        </li>
                                        {{-- <input type="hidden" name="TotalPriceAjax" id="TotalPriceAjax"> --}}
                                        <li class="Saved">
                                            {{ __('messages.YouSaved')}}
                                            <span id="discountDiv2"></span>
                                        </li>
                                        <input type="hidden" name="totalSaved" id="totalSaved">
                                        <li class="total">
                                            {{ __('messages.Total')}}
                                            <span id='FinalTotal'></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="buttons-in-cart d-flex justify-content-center align-items-center mt-3">
                                    @if (!Auth::check())
                                        <a href="{{route('login')}}" class="Signincart"><i class="fa-solid fa-user-plus"></i></a>
                                    @endif
                                    <button type="submit" id="Checkout" class="cta ShopNowButton">
                                        <span class="hover-underline-animation">{{ __('messages.ContinuetoCheckout')}}</span>
                                        <svg viewBox="0 0 46 16" height="10" width="30" xmlns="http://www.w3.org/2000/svg" id="arrow-horizontal">
                                            <path transform="translate(30)" d="M8,0,6.545,1.455l5.506,5.506H-30V9.039H12.052L6.545,14.545,8,16l8-8Z" data-name="Path 10" id="Path_10"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                    </div>
                @else
                    <div class="col-lg-6">
                        <div class="Splitted Images-Home">
                            <div class="SplittedProduct_1 Image-One ">
                                <img src="{{asset('UI/Imgs/website/Cart/r-architecture-rOk4VSMS3Ck-unsplash.jpg')}}" class="BigWidth" alt="Bundles">
                                <div class="overlay-button" style="width: 85%;">
                                    <div class="Info-bundle">
                                        <h3>Bundle Name</h3>
                                        <p>Apple</p>
                                    </div>
                                    <a href="{{route('Product.show' , 1)}}" class="btn btn-info">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-lg-5 CardCarouselCart">
                    <div class="card card-carousel overflow-hidden h-100 p-0" style="border-radius:10px">
                        <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                            <div class="carousel-inner border-radius-lg h-100">
                                <div class="carousel-item h-100 active" style="background-image: url({{asset('UI/Imgs/website/Cart/james-yarema-zdjZ4kCaJaY-unsplash.jpg')}});background-size: cover;">
                                    <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                        <div class="icon icon-shape icon-sm bg-transparent text-center border-radius-md mb-3">
                                            <i class="fa fa-camera text-white opacity-10 fa-5"></i>
                                        </div>
                                        <h5 class="text-white mb-1">{{ __('messages.BuildyourDreamHome')}}</h5>
                                        <p class="text-white">{{ __('messages.BuildyourDreamHomeText')}}</p>
                                        <a class="btn btn-xs bg-gradient-info" href="{{route('Tools.index')}}" target="_blank"><i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                                <div class="carousel-item h-100" style="background-image: url({{asset('UI/Imgs/website/Cart/darryl-low-uqk9RAzm6lk-unsplash.jpg')}}); background-size: cover;">
                                    <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                        <div class="icon icon-shape icon-sm bg-transparent text-center border-radius-md mb-3">
                                        <i class="fa fa-lightbulb text-white opacity-10 fa-5"></i>
                                        </div>
                                        <h5 class="text-white mb-1">{{ __('messages.DiscoverourProducts')}}</h5>
                                        <p class="text-white">{{ __('messages.DiscoverourProductsText')}}</p>
                                        <a class="btn btn-xs bg-gradient-info" href="{{route('Shop.index')}}" target="_blank"><i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden d-none">{{ __('messages.Previous')}}</span>
                            </button>
                            <button class="carousel-control-next w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden d-none">{{ __('messages.Next')}}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Selling Product -->
    <section>
        <div class="container">
            <div class="col-lg-12 p-0">
                <div class="ShopNowInCart" id="ShopNowInCheckout" style="background-image: url({{asset('UI/Imgs/website/Cart/bence-boros-anapPhJFRhM-unsplash.jpg')}});">
                    <h4>
                        {{ __('messages.CheckTheNewest')}}
                        <br>
                        Apple Products
                    </h4>
                    <a href="{{route('Shop.index')}}" class="btn btn-secondary">{{ __('messages.ShopNowButton')}}</a>
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
            // Remove a product and Empty Cart
            $(document).ready(function() {

                // Empty Cart
                $('.remove-All-btn').click(function() {
                    emptyCart();
                });
            });

            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('.Quantity, .installmentPriceCheckbox').forEach(elem => {
                    elem.addEventListener('change', updateTotalPrice);
                });
                
                document.getElementById('Checkout').addEventListener('click', checkout);
                
                updateTotalPrice();
            });
        </script>

@stop

